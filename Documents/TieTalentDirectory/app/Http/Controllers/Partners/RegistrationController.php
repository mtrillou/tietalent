<?php

namespace App\Http\Controllers\Partners;
use App\Http\Controllers\Controller;
use DateTime;
use App;
use Illuminate\Support\Facades\Session;
use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailer;
use DB;
use App\User;
use App\AdminPlatform;
use App\Candidate;
use App\candidateDetails;
use App\CandidateInfos;
use App\candidateInviteFriends;
use App\candidateDocuments;
use App\candidateReferences;
use App\partnerInterviewFeedback;
use App\partner;
use App\partnerDocuments;
use App\partnerInterviews;
use App\partnerDetails;
use App\partnerInfos;
use App\company;
use App\companyVacancies;
use App\companyInterviews;
use App\companyInfos;
use App\companyInterviewFeedback;
use App\companyDetails;
use App\companyUsers;
use App\admin;
use App\adminInterviews;
use App\adminInterviewFeedback;
use App\linkedCandidateVacancy;
use App\partnerInviteFriends;
use App\partnerInviteCompany;
use View;
use Auth;
use Mail;
use File;
use Storage;
use Image;
use Carbon\Carbon;




class RegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function registration_partner(Request $request)
    {

      $user = User::where('email', '=', Input::get('partner_email'))->first();

      if ($user === null) {
        $firstName = $request['firstName'];
        $lastName = $request['lastName'];
        $partner_email = $request['partner_email'];
        $password = bcrypt($request['password']);

        return View::make("/partnerplatform/registrationform",[
              'firstName'=>$firstName,
              'lastName'=>$lastName,
              'partner_email'=>$partner_email,
              'password'=>$password,
            ]);

          }

          else {
            $firstName = $request['firstName'];
            $lastName = $request['lastName'];
            $partner_email = $request['partner_email'];
            return view('signup_partner')->withEmail($partner_email)->withFname($firstName)->withLname($lastName)->withMessage(' is already used. Please insert another email address.');
          }
      }


      public function registration_partner_step($token){
          return view('partnerplatform.registrationform')->with('token', $token);
      }


      public function registration_partner_step_post(Request $request){
          $shareLink = str_random(11);

          $token = str_random(64);

          $userfind = User::create([
              'email' => $request['partner_email'],
              'password' => $request['password'],
              'token' => $token,
          ]);

          $userfind->grade = 3;
          $userfind->language = $request['locale'];
          $userfind->save();

          $id_user = $userfind->id;

          $user = new partner;
          $user->id_user = $id_user;
          $user->partner_statut = '0';
          $user->firstName = Input::get('firstName');
          $user->lastName = Input::get('lastName');
          $user->partner_email = Input::get('partner_email');
          $user->partner_skype = Input::get('partner_skype');
          $user->avatar = 'default.jpg';
          $user->save();

          $partnerDocuments = new partnerDocuments();
          $partnerDocuments->id_user = $id_user;



          if(!is_null(request()->file('document'))){
            $partnerDocuments->id_user = $id_user;

            $file = request()->file('document');
            $docLanguage = $request->input('docLanguage');
            $docExt = $file->guessClientExtension();

            $file->storeAs('documents/' . $id_user, "CV".$docLanguage.".".$docExt);
            $storage_path = 'app/documents/'.$id_user.'/CV'.$docLanguage;
            $fileName = "CV".$docLanguage.".".$docExt;

            $partnerDocuments->docType = 'CV';
            $partnerDocuments->docLanguage = $docLanguage;
            $partnerDocuments->storage_path = $storage_path;
            $partnerDocuments->docExt = $docExt;
            $partnerDocuments->fileName = $fileName;


            $partners = DB::table('partners')->where('id_user',$id_user)->update( array(
              'partner_statut' => '1',
                ));

          }

          $partnerDocuments->save();


          $admininterviews = new adminInterviews();
          $admininterviews->statut = '1';
          $admininterviews->admin_id_user = '1';
          $admininterviews->partner_id_user = $id_user;
          $admininterviews->save();


          $partnerInviteFriends = new partnerInviteFriends();
          $partnerInviteFriends->id_user = $id_user;
          $partnerInviteFriends->save();

          $partnerInfos = new partnerInfos();
          $partnerInfos->id_user = $id_user;
          $partnerInfos->numberInterviewPlanned = "0";
          $partnerInfos->numberCandidateInterviewed = "0";
          $partnerInfos->numberLifeChanged = "0";
          $partnerInfos->shareLink = $shareLink;
          $partnerInfos->save();

          $partnerInviteCompany = new partnerInviteCompany();
          $partnerInviteCompany->id_user = $id_user;
          $partnerInviteCompany->save();

          $partner = new partnerDetails();
          $partner->id_user = $id_user;
          $partner->departmentSpecialization = $request['departmentSpecialization'];
          $partner->departmentSpecialization_other = $request['departmentSpecialization_other'];
          $partner->companyType = $request['companyType'];
          $partner->companyType_other = $request['companyType_other'];
          $partner->linkedIn = $request['linkedIn'];
          $partner->partnerCV = $request['partnerCV'];
          $partner->internetAccess = $request['internetAccess'];
          $partner->numberHours = $request['numberHours'];
          $partner->reasonGoodPartner = $request['reasonGoodPartner'];
          $partner->address = $request['address'];
          $partner->save();

          App::setLocale($userfind->language);

          Mail::send('email.register',['user' => $user, 'token' => $token],function($mail) use ($user) {
            $mail->to($user['partner_email'],$user['firstName'])->from('no-reply@tietalent.com')->subject('Welcome');
          });

          return view("/successfulSignUp");
      }





}
