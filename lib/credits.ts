import { prisma } from "@/lib/db/prisma";

export const FREE_CREDITS_PER_DAY = 2;

function isNewDay(lastReset: Date): boolean {
  const now = new Date();
  const reset = new Date(lastReset);
  return (
    now.getUTCFullYear() !== reset.getUTCFullYear() ||
    now.getUTCMonth() !== reset.getUTCMonth() ||
    now.getUTCDate() !== reset.getUTCDate()
  );
}

export async function getUserCredits(userId: string) {
  const user = await prisma.user.findUnique({
    where: { id: userId },
    select: { credits_balance: true, daily_free_used: true, last_free_reset: true },
  });
  if (!user) throw new Error("User not found");

  if (isNewDay(user.last_free_reset)) {
    await prisma.user.update({
      where: { id: userId },
      data: { daily_free_used: 0, last_free_reset: new Date() },
    });
    user.daily_free_used = 0;
  }

  const freeRemaining = Math.max(0, FREE_CREDITS_PER_DAY - user.daily_free_used);
  const paidBalance = user.credits_balance;
  const totalAvailable = freeRemaining + paidBalance;

  return { freeRemaining, paidBalance, totalAvailable };
}

// ── Atomic credit deduction with race condition protection ───────────────────
export async function checkAndDeductCredit(userId: string): Promise<
  { ok: true } | { ok: false; reason: "no_credits" }
> {
  // Use a transaction to prevent race conditions / double-spending
  return await prisma.$transaction(async (tx) => {
    const user = await tx.user.findUnique({
      where: { id: userId },
      select: { credits_balance: true, daily_free_used: true, last_free_reset: true },
    });
    if (!user) return { ok: false as const, reason: "no_credits" as const };

    let dailyFreeUsed = user.daily_free_used;
    if (isNewDay(user.last_free_reset)) {
      dailyFreeUsed = 0;
      await tx.user.update({
        where: { id: userId },
        data: { daily_free_used: 0, last_free_reset: new Date() },
      });
    }

    const freeRemaining = FREE_CREDITS_PER_DAY - dailyFreeUsed;

    if (freeRemaining > 0) {
      await tx.user.update({
        where: { id: userId },
        data: { daily_free_used: { increment: 1 } },
      });
      return { ok: true as const };
    }

    if (user.credits_balance > 0) {
      // Atomic: only decrement if balance is still > 0 (prevents race)
      const updated = await tx.user.updateMany({
        where: { id: userId, credits_balance: { gt: 0 } },
        data: { credits_balance: { decrement: 1 } },
      });
      if (updated.count === 0) return { ok: false as const, reason: "no_credits" as const };
      return { ok: true as const };
    }

    return { ok: false as const, reason: "no_credits" as const };
  });
}

export async function saveScan({
  userId, type, input_label, result,
}: {
  userId: string;
  type: "candidate_intelligence" | "role_fit";
  input_label: string;
  result: object;
}) {
  // Never log raw result — just save to DB
  return prisma.scan.create({
    data: { userId, type, input_label, result },
  });
}
