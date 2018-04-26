<?php

namespace App\Http\Controllers;
use DateTime;
use App;

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
use View;
use Auth;
use Mail;
use File;
use Storage;
use Image;
use Carbon\Carbon;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
      $grade = $request->user()->grade;
      $id_user = $request->user()->id;

      $user = Auth::user();
      $user->touch();



      if($grade == 1){
         $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
         $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();
         return View::make('candidateplatform/home',[
           'candidates'=>$candidates,
           'candidateDetails'=>$candidateDetails,
         ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
           ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));

      }


      if($grade == 2){
        $companies = DB::table('companies')->where('id_user',$id_user)->first();
        $companyDetails = DB::table('companyDetails')->where('id_user',$id_user)->first();
        $offices = DB::table('offices')->where('id_user',$id_user)->first();
        return View::make('companyplatform/home',[
          'companies'=>$companies,
          'companyDetails'=>$companyDetails,
          'offices'=>$offices,
        ]);

      }
      if($grade == 3){
        $partners = DB::table('partners')->where('id_user',$id_user)->first();

        $partnerDetails = DB::table('partnerDetails')->where('id_user',$id_user)->first();

        $plannedInterviews = DB::table('partnerInterviews')->where('partner_id_user',$id_user)
                                                          ->where('statut','4')
                                                          ->count();

        $passedInterviews = DB::table('partnerInterviews')->where('partner_id_user',$id_user)
                                                          ->where('statut','5')
                                                          ->count();

        $lifeChanged = DB::table('partnerInterviews')->where('partner_id_user',$id_user)
                                                     ->where('statut','6')
                                                     ->count();

        $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->update( array(
          'numberInterviewPlanned' => $plannedInterviews,
          'numberCandidateInterviewed' => $passedInterviews,
          'numberLifeChanged'=>$lifeChanged,
        ));


        $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->first();

        return View::make('partnerplatform/home',[
          'partners'=>$partners,
          'partnerInfos'=>$partnerInfos,
          'partnerDetails'=>$partnerDetails,
        ])->with('partnerDocuments', partnerDocuments::all()->where('id_user',$id_user))
          ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user',$id_user))
          ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user',$id_user)
                                                                            ->where('partnerStatut','1'));
      }
      if($grade == 4){

        $nbCandidates= AdminPlatform::getNbCandidates();
        $nbCompanies= AdminPlatform::getNbCompanies();
        $nbPartners= AdminPlatform::getNbPartners();
        $nbInterviewsToOrganize = AdminPlatform::nbInterviewsToOrganize();
        $nbInterviewsPlanned= AdminPlatform::nbInterviewsPlanned();
        $nbRecommendedCandidates= AdminPlatform::nbRecommendedCandidates();
        $nbCandidatesNoSkype= AdminPlatform::nbCandidatesNoSkype();
        $nbPartnersNoSkype= AdminPlatform::nbPartnersNoSkype();
        $nbCandidatesMore24Hours= AdminPlatform::getNbCandidatesMore24Hours();
        $nbCandidatesLess24Hours= AdminPlatform::nbCandidatesLess24Hours();
        $getNbCandidatesMore48Hours= AdminPlatform::getNbCandidatesMore48Hours();
        $getNbCandidatesMore72Hours= AdminPlatform::getNbCandidatesMore72Hours();
        $nbPartnersLess24Hours= AdminPlatform::nbPartnersLess24Hours();
        $getNbPartnersMore24Hours= AdminPlatform::getNbPartnersMore24Hours();
        $getNbPartnersMore48Hours= AdminPlatform::getNbPartnersMore48Hours();
        $getNbPartnersMore72Hours= AdminPlatform::getNbPartnersMore72Hours();
        $nbCompaniesLess24Hours= AdminPlatform::nbCompaniesLess24Hours();
        $getNbCompaniesMore24Hours= AdminPlatform::getNbCompaniesMore24Hours();
        $getNbCompaniesMore48Hours= AdminPlatform::getNbCompaniesMore48Hours();
        $getNbCompaniesMore72Hours= AdminPlatform::getNbCompaniesMore72Hours();
        $getNbCandidatePartnersContactLess24h= AdminPlatform::getNbCandidatePartnersContactLess24h();
        $getNbCandidatePartnersContactMore24h= AdminPlatform::getNbCandidatePartnersContactMore24h();
        $getNbCandidatePartnersContactMore48h= AdminPlatform::getNbCandidatePartnersContactMore48h();
        $getNbCandidatePartnersContactMore72h= AdminPlatform::getNbCandidatePartnersContactMore72h();



        return View::make('adminplatform/home',[
          'nbCandidates' => $nbCandidates,
          'nbCompanies' => $nbCompanies,
          'nbPartners' => $nbPartners,
          'nbInterviewsToOrganize' => $nbInterviewsToOrganize,
          'nbInterviewsPlanned' => $nbInterviewsPlanned,
          'nbRecommendedCandidates' => $nbRecommendedCandidates,
          'nbCandidatesNoSkype' => $nbCandidatesNoSkype,
          'nbPartnersNoSkype' => $nbPartnersNoSkype,
          'nbCandidatesMore24Hours' => $nbCandidatesMore24Hours,
          'nbCandidatesLess24Hours' => $nbCandidatesLess24Hours,
          'getNbCandidatesMore48Hours' => $getNbCandidatesMore48Hours,
          'getNbCandidatesMore72Hours' => $getNbCandidatesMore72Hours,
          'nbPartnersLess24Hours' => $nbPartnersLess24Hours,
          'getNbPartnersMore24Hours' => $getNbPartnersMore24Hours,
          'getNbPartnersMore48Hours' => $getNbPartnersMore48Hours,
          'getNbPartnersMore72Hours' => $getNbPartnersMore72Hours,
          'nbCompaniesLess24Hours' => $nbCompaniesLess24Hours,
          'getNbCompaniesMore24Hours' => $getNbCompaniesMore24Hours,
          'getNbCompaniesMore48Hours' => $getNbCompaniesMore48Hours,
          'getNbCompaniesMore72Hours' => $getNbCompaniesMore72Hours,
          'getNbCandidatePartnersContactLess24h' => $getNbCandidatePartnersContactLess24h,
          'getNbCandidatePartnersContactMore24h' => $getNbCandidatePartnersContactMore24h,
          'getNbCandidatePartnersContactMore48h' => $getNbCandidatePartnersContactMore48h,
          'getNbCandidatePartnersContactMore72h' => $getNbCandidatePartnersContactMore72h,

        ])->with('candidates', candidate::all())
          ->with('companies', company::all())
          ->with('partners', partner::all());
    }


  }




    public function candidate_aboutYou(Request $request){
      $id_user = $request->user()->id;
      $aboutYou =  $request->input('aboutYou');
      DB::table('candidateDetails')->where('id_user',$id_user)->update( array('aboutYou' => $aboutYou) );


      return redirect()->back();
    }

    public function candidate_experiences(Request $request){
      $id_user = $request->user()->id;
      $experiencecompany1 =  $request->input('experiencecompany1');
      $experienceelement1 =  $request->input('experienceelement1');
      $experiencecompany2 =  $request->input('experiencecompany2');
      $experienceelement2 =  $request->input('experienceelement2');
      $experiencecompany3 =  $request->input('experiencecompany3');
      $experienceelement3 =  $request->input('experienceelement3');
      $experiencecompany4 =  $request->input('experiencecompany4');
      $experienceelement4 =  $request->input('experienceelement4');
      $experiencecompany5 =  $request->input('experiencecompany5');
      $experienceelement5 =  $request->input('experienceelement5');
      DB::table('candidateDetails')->where('id_user',$id_user)->update( array(
        'experiencecompany1' => $experiencecompany1,
        'experienceelement1' => $experienceelement1,
        'experiencecompany2' => $experiencecompany2,
        'experienceelement2' => $experienceelement2,
        'experiencecompany3' => $experiencecompany3,
        'experienceelement3' => $experienceelement3,
        'experiencecompany4' => $experiencecompany4,
        'experienceelement4' => $experienceelement4,
        'experiencecompany5' => $experiencecompany5,
        'experienceelement5' => $experienceelement5,
      ));

      return redirect()->back();
    }

    public function candidate_references(Request $request){
      $id_user = $request->user()->id;
      $firstNameReference1 =  $request->input('firstNameReference1');
      $lastNameReference1 =  $request->input('lastNameReference1');
      $emailReference1 =  $request->input('emailReference1');
      $positionReference1 =  $request->input('positionReference1');
      $companyReference1 =  $request->input('companyReference1');
      $firstNameReference2 =  $request->input('firstNameReference2');
      $lastNameReference2 =  $request->input('lastNameReference2');
      $emailReference2 =  $request->input('emailReference2');
      $positionReference2 =  $request->input('positionReference2');
      $companyReference2 =  $request->input('companyReference2');
      $firstNameReference3 =  $request->input('firstNameReference3');
      $lastNameReference3 =  $request->input('lastNameReference3');
      $emailReference3 =  $request->input('emailReference3');
      $positionReference3 =  $request->input('positionReference3');
      $companyReference3 =  $request->input('companyReference3');
      $firstNameReference4 =  $request->input('firstNameReference4');
      $lastNameReference4 =  $request->input('lastNameReference4');
      $emailReference4 =  $request->input('emailReference4');
      $positionReference4 =  $request->input('positionReference4');
      $companyReference4 =  $request->input('companyReference4');
      $firstNameReference5 =  $request->input('firstNameReference5');
      $lastNameReference5 =  $request->input('lastNameReference5');
      $emailReference5 =  $request->input('emailReference5');
      $positionReference5 =  $request->input('positionReference5');
      $companyReference5 =  $request->input('companyReference5');

      DB::table('candidateDetails')->where('id_user',$id_user)->update( array(
        'firstNameReference1' => $firstNameReference1,
        'lastNameReference1' => $lastNameReference1,
        'emailReference1' => $emailReference1,
        'positionReference1' => $positionReference1,
        'companyReference1' => $companyReference1,
        'firstNameReference2' => $firstNameReference2,
        'lastNameReference2' => $lastNameReference2,
        'emailReference2' => $emailReference2,
        'positionReference2' => $positionReference2,
        'companyReference2' => $companyReference2,
        'firstNameReference3' => $firstNameReference3,
        'lastNameReference3' => $lastNameReference3,
        'emailReference3' => $emailReference3,
        'positionReference3' => $positionReference3,
        'companyReference3' => $companyReference3,
        'firstNameReference4' => $firstNameReference4,
        'lastNameReference4' => $lastNameReference4,
        'emailReference4' => $emailReference4,
        'positionReference4' => $positionReference4,
        'companyReference4' => $companyReference4,
        'firstNameReference5' => $firstNameReference5,
        'lastNameReference5' => $lastNameReference5,
        'emailReference5' => $emailReference5,
        'positionReference5' => $positionReference5,
        'companyReference5' => $companyReference5,

      ));

      return redirect()->back();
    }


    public function candidate_newReferences(Request $request){
      $id_user = $request->input('candidate_idUser');
      $refereeFirstName =  $request->input('refereeFirstName');
      $refereeLastName =  $request->input('refereeLastName');
      $refereeEmail =  $request->input('refereeEmail');
      $refereePosition =  $request->input('refereePosition');
      $refereeCompany =  $request->input('refereeCompany');

      $token = str_random(64);


      if(DB::table('candidateReferences')->where('id_user',$id_user)->where('refereeEmail', $refereeEmail)->first()){
        DB::table('candidateReferences')->where('id_user',$id_user)->where('refereeEmail', $refereeEmail)->update( array(
          'id_user' => $id_user,
          'active' => '0',
          'refereeFirstName' => $refereeFirstName,
          'refereeLastName' => $refereeLastName,
          'refereeEmail' => $refereeEmail,
          'refereePosition' => $refereePosition,
          'refereeCompany' => $refereeCompany,
          'token' => $token,
          'referenceStatut' => 'Email to send',
        ));
      }

      else {
        $candidateReferences = new candidateReferences();
        $candidateReferences->id_user = $id_user;
        $candidateReferences->active = '0';
        $candidateReferences->refereeFirstName = $refereeFirstName;
        $candidateReferences->refereeLastName = $refereeLastName;
        $candidateReferences->refereeEmail = $refereeEmail;
        $candidateReferences->refereePosition = $refereePosition;
        $candidateReferences->refereeCompany = $refereeCompany;
        $candidateReferences->token = $token;
        $candidateReferences->referenceStatut = 'Email to send';
        $candidateReferences->save();
      }


      return redirect()->back();
    }

//Candidate routes
public function invitefriends(Request $request){
  $id_user = $request->user()->id;
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/invitefriends',[
      'candidateInfos'=>$candidateInfos,
      'candidates'=>$candidates,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function candidate_inviteFriends(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailFriendsContent =  $request->input('emailFriendsContent');
  $inviteFirstName1 =  $request->input('inviteFirstName1');
  $inviteEmail1 =  $request->input('inviteEmail1');
  $inviteFirstName2 =  $request->input('inviteFirstName2');
  $inviteEmail2 =  $request->input('inviteEmail2');
  $inviteFirstName3 =  $request->input('inviteFirstName3');
  $inviteEmail3 =  $request->input('inviteEmail3');
  $inviteFirstName4 =  $request->input('inviteFirstName4');
  $inviteEmail4 =  $request->input('inviteEmail4');
  $inviteFirstName5 =  $request->input('inviteFirstName5');
  $inviteEmail5 =  $request->input('inviteEmail5');
  $inviteFirstName6 =  $request->input('inviteFirstName6');
  $inviteEmail6 =  $request->input('inviteEmail6');
  $inviteFirstName7 =  $request->input('inviteFirstName7');
  $inviteEmail7 =  $request->input('inviteEmail7');
  $inviteFirstName8 =  $request->input('inviteFirstName8');
  $inviteEmail8 =  $request->input('inviteEmail8');
  $inviteFirstName9 =  $request->input('inviteFirstName9');
  $inviteEmail9 =  $request->input('inviteEmail9');


  DB::table('candidateInviteFriends')->where('id_user',$id_user)->update( array(
    'emailFriendsContent' => $emailFriendsContent,
    'inviteFirstName1' => $inviteFirstName1,
    'inviteEmail1' => $inviteEmail1,
    'inviteFirstName2' => $inviteFirstName2,
    'inviteEmail2' => $inviteEmail2,
    'inviteFirstName3' => $inviteFirstName3,
    'inviteEmail3' => $inviteEmail3,
    'inviteFirstName4' => $inviteFirstName4,
    'inviteEmail4' => $inviteEmail4,
    'inviteFirstName5' => $inviteFirstName5,
    'inviteEmail5' => $inviteEmail5,
    'inviteFirstName6' => $inviteFirstName6,
    'inviteEmail6' => $inviteEmail6,
    'inviteFirstName7' => $inviteFirstName7,
    'inviteEmail7' => $inviteEmail7,
    'inviteFirstName8' => $inviteFirstName8,
    'inviteEmail8' => $inviteEmail8,
    'inviteFirstName9' => $inviteFirstName9,
    'inviteEmail9' => $inviteEmail9,

  ) );

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateInviteFriends = DB::table('candidateInviteFriends')->where('id_user',$id_user)->first();

  if($inviteFirstName1 != '' && $inviteEmail1 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });

  }

  if($inviteEmail2 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail3 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail4 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail5 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail6 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail7 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail8 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail9 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'candidates' => $candidates, 'candidateInviteFriends' => $candidateInviteFriends],function($mail) use ($candidateInviteFriends) {
      $mail->to($candidateInviteFriends->inviteEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }



  return redirect()->back();
}

public function invitecompany(Request $request){
  $id_user = $request->user()->id;
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/invitecompany',[
      'candidateInfos'=>$candidateInfos,
      'candidates'=>$candidates,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function candidate_inviteCompany(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailCompanyContent =  $request->input('emailCompanyContent');
  $inviteCompanyFirstName1 =  $request->input('inviteCompanyFirstName1');
  $inviteCompanyEmail1 =  $request->input('inviteCompanyEmail1');
  $inviteCompanyFirstName2 =  $request->input('inviteCompanyFirstName2');
  $inviteCompanyEmail2 =  $request->input('inviteCompanyEmail2');
  $inviteCompanyFirstName3 =  $request->input('inviteCompanyFirstName3');
  $inviteCompanyEmail3 =  $request->input('inviteCompanyEmail3');
  $inviteCompanyFirstName4 =  $request->input('inviteCompanyFirstName4');
  $inviteCompanyEmail4 =  $request->input('inviteCompanyEmail4');
  $inviteCompanyFirstName5 =  $request->input('inviteCompanyFirstName5');
  $inviteCompanyEmail5 =  $request->input('inviteCompanyEmail5');
  $inviteCompanyFirstName6 =  $request->input('inviteCompanyFirstName6');
  $inviteCompanyEmail6 =  $request->input('inviteCompanyEmail6');
  $inviteCompanyFirstName7 =  $request->input('inviteCompanyFirstName7');
  $inviteCompanyEmail7 =  $request->input('inviteCompanyEmail7');
  $inviteCompanyFirstName8 =  $request->input('inviteCompanyFirstName8');
  $inviteCompanyEmail8 =  $request->input('inviteCompanyEmail8');
  $inviteCompanyFirstName9 =  $request->input('inviteCompanyFirstName9');
  $inviteCompanyEmail9 =  $request->input('inviteCompanyEmail9');


  DB::table('candidateInviteCompany')->where('id_user',$id_user)->update( array(
    'emailCompanyContent' => $emailCompanyContent,
    'inviteCompanyFirstName1' => $inviteCompanyFirstName1,
    'inviteCompanyEmail1' => $inviteCompanyEmail1,
    'inviteCompanyFirstName2' => $inviteCompanyFirstName2,
    'inviteCompanyEmail2' => $inviteCompanyEmail2,
    'inviteCompanyFirstName3' => $inviteCompanyFirstName3,
    'inviteCompanyEmail3' => $inviteCompanyEmail3,
    'inviteCompanyFirstName4' => $inviteCompanyFirstName4,
    'inviteCompanyEmail4' => $inviteCompanyEmail4,
    'inviteCompanyFirstName5' => $inviteCompanyFirstName5,
    'inviteCompanyEmail5' => $inviteCompanyEmail5,
    'inviteCompanyFirstName6' => $inviteCompanyFirstName6,
    'inviteCompanyEmail6' => $inviteCompanyEmail6,
    'inviteCompanyFirstName7' => $inviteCompanyFirstName7,
    'inviteCompanyEmail7' => $inviteCompanyEmail7,
    'inviteCompanyFirstName8' => $inviteCompanyFirstName8,
    'inviteCompanyEmail8' => $inviteCompanyEmail8,
    'inviteCompanyFirstName9' => $inviteCompanyFirstName9,
    'inviteCompanyEmail9' => $inviteCompanyEmail9,

  ) );

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateInviteCompany = DB::table('candidateInviteCompany')->where('id_user',$id_user)->first();

  if($inviteCompanyFirstName1 != '' && $inviteCompanyEmail1 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail2 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail3 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail4 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail5 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail6 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail7 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail8 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail9 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'candidates' => $candidates, 'candidateInviteCompany' => $candidateInviteCompany],function($mail) use ($candidateInviteCompany) {
      $mail->to($candidateInviteCompany->inviteCompanyEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }


  return redirect()->back();
}


public function settings(Request $request){
    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/settings',[
        'candidates'=>$candidates,
        'candidateDetails'=>$candidateDetails,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }


}

public function candidate_communication(Request $request){
  $id_user = $request->user()->id;
  $communication =  $request->input('communication');
  DB::table('candidates')->where('id_user',$id_user)->update( array('communication' => $communication) );

  return redirect()->back();
}

public function candidate_email(Request $request){
  $id_user = $request->user()->id;
  $candidate_email =  $request->input('candidate_email');
  $candidate_email2 =  $request->input('candidate_email2');
  $candidate_email3 =  $request->input('candidate_email3');
  DB::table('users')->where('id',$id_user)->update( array(
    'email' => $candidate_email,
  ) );
  DB::table('candidates')->where('id_user',$id_user)->update( array(
    'candidate_email' => $candidate_email,
    'candidate_email2' => $candidate_email2,
    'candidate_email3' => $candidate_email3,
  ) );

  return redirect()->back();
}

public function candidate_skype(Request $request){
  $id_user = $request->user()->id;
  $candidate_skype =  $request->input('candidate_skype');

  DB::table('candidates')->where('id_user',$id_user)->update( array(
    'candidate_skype' => $candidate_skype,

  ) );

  return redirect()->back();
}

public function candidate_phone(Request $request){
  $id_user = $request->user()->id;
  $candidate_phone =  $request->input('candidate_phone');
  $candidate_phone2 =  $request->input('candidate_phone2');
  $candidate_phone3 =  $request->input('candidate_phone3');
  DB::table('candidates')->where('id_user',$id_user)->update( array(
    'candidate_phone' => $candidate_phone,
    'candidate_phone2' => $candidate_phone2,
    'candidate_phone3' => $candidate_phone3,
  ) );

  return redirect()->back();
}

public function candidate_password(Request $request){
  $id = $request->user()->id;
  $password =  $request->input('password');
  $password_confirm =  $request->input('password_confirm');

  if($password == $password_confirm){

    DB::table('users')->where('id',$id)->update( array(
      'password' => bcrypt($password),
    ) );

    return redirect()->back();
  }

}

public function candidate_general(Request $request){
  $id_user = $request->user()->id;
  $firstName =  $request->input('firstName');
  $lastName =  $request->input('lastName');
  $address =  $request->input('address');
  $mobility =  $request->input('mobility');
  $availability =  $request->input('availability');
  $salaryExpectations =  $request->input('salaryExpectations');
  $contractTypePermanent =  $request->input('contractTypePermanent');
  $contractTypeTH =  $request->input('contractTypeTH');
  $contractTypeTemporary =  $request->input('contractTypeTemporary');

  DB::table('candidates')->where('id_user',$id_user)->update( array(
    'firstName' => $firstName,
    'lastName' => $lastName,
    'lastActiveJobSearchEmail' => new DateTime('now'),
  ) );

  DB::table('candidateDetails')->where('id_user',$id_user)->update( array(
    'address' => $address,
    'mobility' => $mobility,
    'availability' => $availability,
    'salaryExpectations' => $salaryExpectations,
    'contractTypePermanent' => $contractTypePermanent,
    'contractTypeTH' => $contractTypeTH,
    'contractTypeTemporary' => $contractTypeTemporary,
  ) );


    return redirect()->back();

}

public function candidate_deactivate(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $deactivate =  $request->input('deactivate');
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();

  $interviewStatutBeforeDeactivation = $candidates->interviewStatut;

  if($deactivate == "I will get back"){
    DB::table('candidates')->where('id_user',$id_user)->update( array(
      'interviewStatut' => '33',
      'interviewStatutBeforeDeactivation' => $interviewStatutBeforeDeactivation,
    ) );
    Mail::send('email.deactivateAccountCandidate',['user' => $user, 'candidates' => $candidates, 'candidateInfos' => $candidateInfos],function($mail) use ($user) {
      $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('A candidate wants to deactivate its account for an unlimited period of time');
    });
  }

  return redirect()->back();

}


public function candidate_reactivate(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $interviewStatutBeforeDeactivation = $candidates->interviewStatutBeforeDeactivation;

  DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => $interviewStatutBeforeDeactivation,
    'lastActiveJobSearchEmail' => new DateTime('now'),
  ) );

  return redirect()->back();

}



public function candidate_feedbackTieTalent(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $feedbackTieTalentRating =  $request->input('feedbackTieTalentRating');
  $feedbackTieTalentText =  $request->input('feedbackTieTalentText');

  DB::table('candidateInfos')->where('id_user',$id_user)->update( array(
    'feedbackTieTalentRating' => $feedbackTieTalentRating,
    'feedbackTieTalentText' => $feedbackTieTalentText,
  ) );

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();

  Mail::send('email.feedbackTieTalentCandidate',['user' => $user, 'candidates' => $candidates, 'candidateInfos' => $candidateInfos],function($mail) use ($user) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Candidate feedback on TieTalent');
  });

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/feedbackSent',[
      'candidates'=>$candidates,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function candidate_confidentiality(Request $request){
  $id_user = $request->user()->id;
  $confidentiality =  $request->input('confidentiality');
  $confidentialityCompany1 =  $request->input('confidentialityCompany1');
  $confidentialityCompany2 =  $request->input('confidentialityCompany2');
  $confidentialityCompany3 =  $request->input('confidentialityCompany3');
  $confidentialityCompany4 =  $request->input('confidentialityCompany4');
  $confidentialityCompany5 =  $request->input('confidentialityCompany5');
  $confidentialityCompany6 =  $request->input('confidentialityCompany6');
  $confidentialityCompany7 =  $request->input('confidentialityCompany7');
  $confidentialityCompany8 =  $request->input('confidentialityCompany8');
  $confidentialityCompany9 =  $request->input('confidentialityCompany9');

  DB::table('candidateInfos')->where('id_user',$id_user)->update( array(
    'confidentiality' => $confidentiality,
    'confidentialityCompany1' => $confidentialityCompany1,
    'confidentialityCompany2' => $confidentialityCompany2,
    'confidentialityCompany3' => $confidentialityCompany3,
    'confidentialityCompany4' => $confidentialityCompany4,
    'confidentialityCompany5' => $confidentialityCompany5,
    'confidentialityCompany6' => $confidentialityCompany6,
    'confidentialityCompany7' => $confidentialityCompany7,
    'confidentialityCompany8' => $confidentialityCompany8,
    'confidentialityCompany9' => $confidentialityCompany9,

  ) );

  return redirect()->back();
}



public function candidate_document(Request $request){
    $id_user = $request->user()->id;
    $docType =  $request->input('docType');
    $company = $request->input('company');
    $diplomaGrade = $request->input('diplomaGrade');
    $school = $request->input('school');
    $others = $request->input('others');
    $docLanguage = $request->input('docLanguage');

    $file = request()->file('document');
    $docExt = $file->guessClientExtension();
    $file->storeAs('documents/' . auth()->id(), $docType.$others.$docLanguage.".".$docExt);
    $storage_path = 'app/documents/'.$id_user.'/'.$docType.$docLanguage;
    $fileName = $docType.$others.$docLanguage.".".$docExt;

    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $interviewStatut = $candidates->interviewStatut;

    if($docType == 'CV' && $interviewStatut == '1'){
      DB::table('candidates')->where('id_user',$id_user)->update( array(
        'interviewStatut' => '2',
      ));
      DB::table('users')->where('id',$id_user)->update( array(
        'created_at' => new DateTime('now'),
      ));

      $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();
      $sharelink = $candidateInfos->shareLink;

      Mail::send('email.candidateProfileReviewed',['candidates' => $candidates, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
        $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Profile submitted');
      });
    }

    DB::table('candidateDocuments')->where('id_user',$id_user)->insert( array(
      'id_user' => $id_user,
      'docType' => $docType,
      'company' => $company,
      'diplomaGrade' => $diplomaGrade,
      'school' => $school,
      'others' => $others,
      'docLanguage' => $docLanguage,
      'docExt' => $docExt,
      'storage_path' => $storage_path,
      'fileName' => $fileName,
    ));



    return back();

}


public function candidate_profilePicture(Request $request){

  $id_user = $request->user()->id;

  if($request->hasFile('avatar')){
    $avatar = $request->file('avatar');
    $filename = time() . '.'. $avatar->getClientOriginalExtension();
    Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

    DB::table('candidates')->where('id_user',$id_user)->update( array(
    'avatar' => $filename,
  ));
}

    return back();

}


public function confidentiality(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/confidentiality',[
      'candidates'=>$candidates,
      'candidateInfos'=>$candidateInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function documents(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateDocuments = DB::table('candidateDocuments')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/documents',[
      'candidates'=>$candidates,
      ])->with('documents', candidateDocuments::all()->where('id_user',$id_user));
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function interview(Request $request){
    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();
    $candidateInterviewStatut = $candidates->interviewStatut;
    $candidateInterviewStatutBefore = $candidates->interviewStatutBeforeDeactivation;

    if($candidateInterviewStatut == '1' || $candidateInterviewStatut == '2' || $candidateInterviewStatut == '3' || $candidateInterviewStatut == '11' || $candidateInterviewStatut == '13' || $candidateInterviewStatut == '14' || ($candidateInterviewStatut == '33' && $candidateInterviewStatutBefore == '1')){

      $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

      $grade = $request->user()->grade;
      if($grade == 1){
        return View::make('candidateplatform/interviewStage1',[
          'candidates'=>$candidates,
          'candidateDetails'=>$candidateDetails,
        ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
          ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
      }
      else {
        return View::make('404',[
        ]);
      }


    }

    if($candidateInterviewStatut == '4' || $candidateInterviewStatut == '5' || $candidateInterviewStatut == '6' || $candidateInterviewStatut == '7' || $candidateInterviewStatut == '8' || $candidateInterviewStatut == '9' || $candidateInterviewStatut == '10' || $candidateInterviewStatut == '15' || $candidateInterviewStatut == '16' || $candidateInterviewStatut == '30'){

        $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->orderBy('updated_at', 'DESC')->first();
        $partnerInterviewStatut = $partnerInterviews->statut;
        $partnerIdUser = $partnerInterviews->partner_id_user;


        if($partnerInterviewStatut == '2' || $partnerInterviewStatut == '3' || $partnerInterviewStatut == '7' || $partnerInterviewStatut == '8' || $partnerInterviewStatut == '20'){

          $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

          $grade = $request->user()->grade;
          if($grade == 1){
            return View::make('candidateplatform/interviewStage2',[
              'candidates'=>$candidates,
              'candidateDetails'=>$candidateDetails,
            ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
              ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
              ->with('partnerInterviews', partnerInterviews::all()->where('candidate_id_user',$id_user))
              ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$id_user))
              ->with('partners', partner::all()->where('id_user',$partnerIdUser))
              ->with('partnerDetails', partnerDetails::all()->where('id_user',$partnerIdUser));
          }
          else {
            return View::make('404',[
            ]);
          }

        }



        if($partnerInterviewStatut == '4' || $partnerInterviewStatut == '5'){
          $itwDate = $partnerInterviews->date;
          $itwTime = $partnerInterviews->time;

          if($candidateInterviewStatut != '8' && $candidateInterviewStatut !== '9' && $candidateInterviewStatut !== '10'){
            $diff = Carbon::now()->diffInMinutes(Carbon::create(explode("-", $itwDate)[0], explode("-", $itwDate)[1], explode("-", $itwDate)[2], explode(":", $itwTime)[0], explode(":", $itwTime)[1], 00, 'Europe/Paris'), false);

            if($diff <  -30) {
              $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
              'statut' => '5',
              ));
              $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
              'interviewStatut' => '7',
              ));
            }
          }
          $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

          $grade = $request->user()->grade;
          if($grade == 1){
            return View::make('candidateplatform/interviewStage2',[
              'candidates'=>$candidates,
              'candidateDetails'=>$candidateDetails,
            ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
              ->with('partnerInterviews', partnerInterviews::all()->where('candidate_id_user',$id_user))
              ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
              ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$id_user))
              ->with('partners', partner::all()->where('id_user',$partnerIdUser))
              ->with('partnerDetails', partnerDetails::all()->where('id_user',$partnerIdUser));
          }
          else {
            return View::make('404',[
            ]);
          }

        }
      }

      if($candidateInterviewStatut == '18' || $candidateInterviewStatut == '19'){
        $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)
                                                           ->orderBy('round', 'DESC')
                                                           ->first();


        $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)->first();
        $companyIdUser = $companyInterviews->company_id_user;
        $companyVacancyID = $companyInterviews->company_vacancy;

        $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
        $partnerInterviewStatut = $partnerInterviews->statut;
        $partnerIdUser = $partnerInterviews->partner_id_user;

        $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
        $grade = $request->user()->grade;
        if($grade == 1){
          return View::make('candidateplatform/interview',[
            'candidates'=>$candidates,
            'candidateDetails'=>$candidateDetails,
          ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
            ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
            ->with('partnerInterviews', partnerInterviews::all()->where('candidate_id_user',$id_user))
            ->with('partners', partner::all()->where('id_user',$partnerIdUser))
            ->with('partnerDetails', partnerDetails::all()->where('id_user',$partnerIdUser))
            ->with('companyVacancies', companyVacancies::all()->where('id',$companyVacancyID))
            ->with('companyInterviews', companyInterviews::all()->where('candidate_id_user',$id_user))
            ->with('companyInterviewFeedback', companyInterviewFeedback::all()->where('candidate_id_user',$id_user)
                                                                              ->where('company_id_user',$companyIdUser))
            ->with('companies', company::all()->where('id_user',$companyIdUser));
        }
        else {
          return View::make('404',[
          ]);
        }

        }



        if($candidateInterviewStatut == '20'){
          $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)
                                                             ->orderBy('round', 'DESC')
                                                             ->first();
          $companyIdUser = $companyInterviews->company_id_user;
          $itwDateCompany = $companyInterviews->date;
          $itwTimeCompany = $companyInterviews->time;

          $diff = Carbon::now()->diffInMinutes(Carbon::create(explode("-", $itwDateCompany)[0], explode("-", $itwDateCompany)[1], explode("-", $itwDateCompany)[2], explode(":", $itwTimeCompany)[0], explode(":", $itwTimeCompany)[1], 00, 'Europe/Paris'), false);

          if($diff < -30) {
            $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)
                                                               ->where('company_id_user',$companyIdUser)
                                                               ->orderBy('round', 'DESC')
                                                               ->take(1)
                                                               ->update( array(
                'statut' => '6',
                ));

            $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
            'interviewStatut' => '22',
            ));
          }


          $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)->first();
          $companyIdUser = $companyInterviews->company_id_user;
          $companyVacancyID = $companyInterviews->company_vacancy;

          $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
          $partnerInterviewStatut = $partnerInterviews->statut;
          $partnerIdUser = $partnerInterviews->partner_id_user;

          $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
          $grade = $request->user()->grade;
          if($grade == 1){
            return View::make('candidateplatform/interview',[
              'candidates'=>$candidates,
              'candidateDetails'=>$candidateDetails,
            ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
              ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
              ->with('partnerInterviews', partnerInterviews::all()->where('candidate_id_user',$id_user))
              ->with('partners', partner::all()->where('id_user',$partnerIdUser))
              ->with('partnerDetails', partnerDetails::all()->where('id_user',$partnerIdUser))
              ->with('companyVacancies', companyVacancies::all()->where('id',$companyVacancyID))
              ->with('companyInterviews', companyInterviews::all()->where('candidate_id_user',$id_user))
              ->with('companies', company::all()->where('id_user',$companyIdUser))
              ->with('companyInterviewFeedback', companyInterviewFeedback::all()->where('candidate_id_user',$id_user)
                                                                                ->where('company_id_user',$companyIdUser));
          }
          else {
            return View::make('404',[
            ]);
          }

          }



    $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
    $partnerInterviewStatut = $partnerInterviews->statut;
    $partnerIdUser = $partnerInterviews->partner_id_user;
    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)->first();
    $companyIdUser = $companyInterviews->company_id_user;
    $companyVacancyID = $companyInterviews->company_vacancy;

    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/interview',[
        'candidates'=>$candidates,
        'candidateDetails'=>$candidateDetails,
      ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
        ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
        ->with('partnerInterviews', partnerInterviews::all()->where('candidate_id_user',$id_user))
        ->with('partners', partner::all()->where('id_user',$partnerIdUser))
        ->with('partnerDetails', partnerDetails::all()->where('id_user',$partnerIdUser))
        ->with('companyVacancies', companyVacancies::all()->where('id',$companyVacancyID))
        ->with('companyInterviews', companyInterviews::all()->where('candidate_id_user',$id_user))
        ->with('companies', company::all()->where('id_user',$companyIdUser))
        ->with('companyInterviewFeedback', companyInterviewFeedback::all()->where('candidate_id_user',$id_user)
                                                                          ->where('company_id_user',$companyIdUser));
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function candidate_interviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => '5',
    ));


  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
  'statut' => '3',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  'updated_at' => new DateTime('now'),
  ));

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
  $partnerIdUser = $partnerInterviews->partner_id_user;

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  Mail::send('email.partnerCandidateNewTimesProposed',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Candidate answer');
  });

return redirect()->back();

}


public function candidate_postponeInterviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => '5',
    ));

  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');
  $postponeMessage = Input::get('postponeMessage');

  DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
  'statut' => '3',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  'postponeMessage' => $postponeMessage,
  ));

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
  $partnerIdUser = $partnerInterviews->partner_id_user;

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  Mail::send('email.partnerCandidatePostponeNewTimesProposed',['partners' => $partners, 'postponeMessage' => $postponeMessage],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview postponed!');
  });

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  Mail::send('email.adminCandidatePostponeInterviewPartner',['partners' => $partners, 'candidates' => $candidates, 'postponeMessage' => $postponeMessage],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview postponed!');
  });

return redirect()->back();

}


public function candidate_cancelInterviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => '30',
    ));

  $cancelMessage = Input::get('cancelMessage');

  DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
  'statut' => '20',
  'postponeMessage' => $cancelMessage,
  ));

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
  $partnerIdUser = $partnerInterviews->partner_id_user;

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  Mail::send('email.partnerCandidateCancelInterview',['partners' => $partners, 'cancelMessage' => $cancelMessage],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview cancelled!');
  });

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  Mail::send('email.adminCandidateCancelInterviewPartner',['partners' => $partners, 'candidates' => $candidates, 'cancelMessage' => $cancelMessage],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview cancelled!');
  });

return redirect()->back();

}


public function candidate_confirmPartnerInterview(Request $request){
    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => '6',
    ));



    $dateTime =  $request->input('proposition');
    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }

    $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
    'statut' => '4',
    'date' => $date,
    'time' => $time,
    ));

    $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();
    $partnerInterviewsId = $partnerInterviews->id;
    $partnerIdUser = $partnerInterviews->partner_id_user;
    $interviewDate = $partnerInterviews->date;
    $interviewTime = $partnerInterviews->time;

    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
    $skypePartner = $partners->partner_skype;


    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $skypeCandidate = $candidates->candidate_skype;

    Mail::send('email.candidateConfirmPartnerInterview',['candidates' => $candidates, 'partners' => $partners, 'interviewDate'=>$interviewDate, 'interviewTime'=>$interviewTime, 'skypePartner'=>$skypePartner],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });

    Mail::send('email.partnerCandidateConfirmInterview',['partners' => $partners, 'candidates'=>$candidates, 'interviewDate'=>$interviewDate, 'interviewTime'=>$interviewTime, 'skypeCandidate'=>$skypeCandidate],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });


    $partnerInterviewFeedback = new partnerInterviewFeedback();
    $partnerInterviewFeedback->partnerInterviews_id = $partnerInterviewsId;
    $partnerInterviewFeedback->partner_id_user = $partnerIdUser;
    $partnerInterviewFeedback->candidate_id_user = $id_user;
    $partnerInterviewFeedback->candidateStatut = '1';
    $partnerInterviewFeedback->partnerStatut = '1';
    $partnerInterviewFeedback->date = $interviewDate;
    $partnerInterviewFeedback->time = $interviewTime;
    $partnerInterviewFeedback->save();


    return redirect()->back();
}

public function candidate_partnerDidNotShowUp(Request $request){
  $id_user = $request->user()->id;

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '15',
  ));

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->update( array(
  'statut' => '8',
  ));

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_user)->first();

  $partnerIdUser = $partnerInterviews->partner_id_user;
  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  Mail::send('email.partnerDidNotShowUp',['candidates' => $candidates, 'partners'=>$partners],function($mail) use ($candidates) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject("Partner didn't show up on interview");
  });

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/partnerNoShowConfirmation',[
      'candidates'=>$candidates,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function candidate_partnerInterviewFeedback(Request $request){
  $id_user = $request->user()->id;

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/itwpartnerfeedback',[
      'candidates'=>$candidates,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function candidate_interviewPartnerFeedback(Request $request){
  $id_user = $request->user()->id;

  $candidateExperiencePartner = Input::get('candidateExperiencePartner');
  $candidatePartnerProfessionalism = Input::get('candidatePartnerProfessionalism');
  $candidatePartnerCapabilities = Input::get('candidatePartnerCapabilities');
  $candidateComments = Input::get('candidateComments');

  $partnerInterviews = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$id_user)->update( array(
  'candidateStatut' => '2',
  'candidateExperiencePartner' => $candidateExperiencePartner,
  'candidatePartnerProfessionalism' => $candidatePartnerProfessionalism,
  'candidatePartnerCapabilities' => $candidatePartnerCapabilities,
  'candidateComments' => $candidateComments,
  ));

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$id_user)->first();
  $partnerIdUser = $partnerInterviewFeedback->partner_id_user;
  $partnerStatutInterviewFeedback = $partnerInterviewFeedback->partnerStatut;

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  if($partnerStatutInterviewFeedback == '1'){
    Mail::send('email.partnerGiveCandidateFeedback',['partners' => $partners],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('What did you think about the interview?');
    });
  }


  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '8',
  ));

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/home',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
    ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
  }
  else {
    return View::make('404',[
    ]);
  }


}

public function candidate_getPartnerFeedback(Request $request){
  $id_user = $request->user()->id;
  $partnerIdUser = $request->input('partnerIdUser');
  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$id_user)
                                                                   ->where('partner_id_user',$partnerIdUser)->first();



  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/partnerInterviewFeedback',[
      'candidates'=>$candidates,
      'partners'=>$partners,
      'partnerInterviewFeedback'=>$partnerInterviewFeedback,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function candidate_interviewCompanyTimes(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '19',
  ));

  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  $companyIdUser = $request->input('company_id_user');

  DB::table('companyInterviews')->where('candidate_id_user',$id_user)
                                ->where('company_id_user',$companyIdUser)
                                ->orderBy('round', 'DESC')
                                ->take(1)
                                ->update( array(
  'statut' => '3',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  ));

  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  Mail::send('email.companyCandidateNewTimesProposed',['companies' => $companies],function($mail) use ($companies) {
    $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Candidate answer');
  });


return redirect()->back();

}

public function candidate_confirmCompanyInterview(Request $request){
    $id_user = $request->user()->id;
    $companyIdUser = $request->input('company_id_user');
    $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
    'interviewStatut' => '20',
    ));

    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

    Mail::send('email.candidateConfirmCompanyInterview',['candidates' => $candidates, 'companies' => $companies],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Company interview');
    });

    Mail::send('email.companyCandidateConfirmInterview',['companies' => $companies],function($mail) use ($companies) {
      $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });

    $dateTime =  $request->input('propositionCompany');
    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }

    $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$companyIdUser)
                                                       ->where('candidate_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->first();
    $companyVacancyId = $companyInterviews->company_vacancy;
    $vacancyRound = $companyInterviews->round;

    $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$companyIdUser)
                                                       ->where('candidate_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->update( array(
    'statut' => '4',
    'round' => $vacancyRound,
    'date' => $date,
    'time' => $time,
    ));



    DB::table('companyVacancies')->where('id',$companyVacancyId)->update( array(
    'vacancyStage' => '3',
    ));


    $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$companyIdUser)
                                                       ->where('candidate_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->first();
    $companyInterviewsId = $companyInterviews->id;
    $companyIdUser = $companyInterviews->company_id_user;
    $interviewDate = $companyInterviews->date;
    $interviewTime = $companyInterviews->time;


    $companyInterviewFeedback = new companyInterviewFeedback();
    $companyInterviewFeedback->companyInterviews_id = $companyInterviewsId;
    $companyInterviewFeedback->round = $vacancyRound;
    $companyInterviewFeedback->company_id_user = $companyIdUser;
    $companyInterviewFeedback->candidate_id_user = $id_user;
    $companyInterviewFeedback->candidateStatut = '1';
    $companyInterviewFeedback->companyStatut = '1';
    $companyInterviewFeedback->date = $interviewDate;
    $companyInterviewFeedback->time = $interviewTime;
    $companyInterviewFeedback->save();


    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/home',[
        'candidates'=>$candidates,
        'candidateDetails'=>$candidateDetails,
      ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
        ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function candidate_confirmNotInterested(Request $request){
  $id_user = $request->user()->id;
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '10',
  ));

  $reasonNotInterested = Input::get('reasonNotInterested');

  DB::table('companyInterviews')->where('candidate_id_user',$id_user)->update( array(
  'statut' => '5',
  'reasonNotInterested' => $reasonNotInterested,
  ));

  $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)->first();
  $companyIdUser = $companyInterviews->company_id_user;

  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  Mail::send('email.companyCandidateNotInterested',['companies' => $companies],function($mail) use ($companies) {
    $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Candidate response');
  });

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/home',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
    ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function candidate_companyInterviewFeedback(Request $request){
  $id_user = $request->user()->id;
  $company_id_user = $request->input('company_id_user');

  $companies = DB::table('companies')->where('id_user',$company_id_user)->first();

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/itwcompanyfeedback',[
      'candidates'=>$candidates,
      'companies'=>$companies,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function candidate_interviewVacancyFeedback(Request $request){
  $id_user = $request->user()->id;
  $companyIdUser = $request->input('company_id_user');

  $candidateMotivation1 = Input::get('candidateMotivation1');
  $candidateVacancyForward = Input::get('candidateVacancyForward');
  $reasonNotInterested = Input::get('reasonNotInterested');
  $candidateComments = Input::get('candidateComments');

  $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('candidate_id_user',$id_user)
                                                                   ->where('company_id_user',$companyIdUser)->update( array(
  'candidateStatut' => '2',
  'candidateMotivation1' => $candidateMotivation1,
  'candidateVacancyForward' => $candidateVacancyForward,
  'reasonNotInterested' => $reasonNotInterested,
  'candidateComments' => $candidateComments,
  ));

  $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('candidate_id_user',$id_user)
                                                                   ->where('company_id_user',$companyIdUser)
                                                                   ->first();
  $candidateVacancyForward = $companyInterviewFeedback->candidateVacancyForward;

  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  if($candidateVacancyForward == '0'){
      Mail::send('email.companyCandidateNotInterested',['companies' => $companies],function($mail) use ($companies) {
        $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Interview feedback');
      });


      $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
      'interviewStatut' => '23',
      ));

      $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
      $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();
      $grade = $request->user()->grade;
      if($grade == 1){
        return View::make('candidateplatform/home',[
          'candidates'=>$candidates,
          'candidateDetails'=>$candidateDetails,
        ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
          ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
      }
      else {
        return View::make('404',[
        ]);
      }


  }

  if($candidateVacancyForward == '1'){
      Mail::send('email.companyGiveCandidateFeedback',['companies' => $companies],function($mail) use ($companies) {
        $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Interview feedback');
      });


      $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
      'interviewStatut' => '23',
      ));

      $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
      $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

      $grade = $request->user()->grade;
      if($grade == 1){
        return View::make('candidateplatform/home',[
          'candidates'=>$candidates,
          'candidateDetails'=>$candidateDetails,
        ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
          ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
      }
      else {
        return View::make('404',[
        ]);
      }

    }

}


public function candidate_getCompanyFeedback(Request $request){
  $id_user = $request->user()->id;
  $companyIdUser = $request->input('companyIdUser');
  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$id_user)
                                                     ->where('company_id_user',$companyIdUser)
                                                     ->orderBy('round', 'DESC')
                                                     ->first();


  $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('candidate_id_user',$id_user)
                                                                   ->where('company_id_user',$companyIdUser)
                                                                   ->orderBy('round', 'DESC')
                                                                   ->first();

  $vacancyId = $companyInterviews->company_vacancy;

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $companyVacancies = DB::table('companyVacancies')->where('id',$vacancyId)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/companyInterviewFeedback',[
      'candidates'=>$candidates,
      'companies'=>$companies,
      'companyInterviews'=>$companyInterviews,
      'companyInterviewFeedback'=>$companyInterviewFeedback,
      'companyVacancies'=>$companyVacancies,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function candidate_acceptOffer(Request $request){
  $id_user = $request->user()->id;
  $companyVacanciesId = $request->input('companyVacanciesId');
  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '25',
  ));

  $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacanciesId)->update( array(
  'vacancyStage' => '6',
  'vacancyStatut' => '2',
  ));

  $companyInterviews = DB::table('companyInterviews')->where('company_vacancy',$companyVacanciesId)
                                                     ->where('candidate_id_user',$id_user)
                                                     ->update( array(
  'statut' => '7',
  ));

  $companyInterviews = DB::table('companyInterviews')->where('company_vacancy',$companyVacanciesId)
                                                     ->where('candidate_id_user',$id_user)
                                                     ->first();

  $companyIdUser = $companyInterviews->company_id_user;

  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  Mail::send('email.adminCandidateAcceptsOffer',['companies' => $companies],function($mail) use ($companies) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Placement! A candidate just accepted the offer made by a company!');
  });

  Mail::send('email.companyCandidateAcceptsOffer',['companies' => $companies],function($mail) use ($companies) {
    $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('The candidate accepts your offer!');
  });


  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_user)->first();
  $sharelink = $candidateInfos->shareLink;

  Mail::send('email.candidateAcceptsOffer',['candidates' => $candidates, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Congratulations!');
  });

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/home',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
    ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
  }
  else {
    return View::make('404',[
    ]);
  }



}


public function candidate_refuseOffer(Request $request){
  $id_user = $request->user()->id;
  $companyVacanciesId = $request->input('companyVacanciesId');

  $reasonNotInterested = Input::get('reasonNotInterested');


  $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
  'interviewStatut' => '24',
  ));

  $companyInterviews = DB::table('companyInterviews')->where('company_vacancy',$companyVacanciesId)->update( array(
  'statut' => '8',
  'reasonNotInterested'=>$reasonNotInterested,
  ));

  $companyInterviews = DB::table('companyInterviews')->where('company_vacancy',$companyVacanciesId)->first();
  $companyIdUser = $companyInterviews->company_id_user;
  $companies = DB::table('companies')->where('id_user',$companyIdUser)->first();

  Mail::send('email.companyCandidateNotInterested',['companies' => $companies],function($mail) use ($companies) {
    $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Candidate response');
  });

  $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();
  $grade = $request->user()->grade;
  if($grade == 1){
    return View::make('candidateplatform/home',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
    ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user));
  }
  else {
    return View::make('404',[
    ]);
  }


}



public function opportunities(Request $request){
    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/opportunities',[
        'candidates'=>$candidates,
        'candidateDetails'=>$candidateDetails,
      ])->with('candidateDocuments', candidateDocuments::all()->where('id_user',$id_user))
        ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_user))
        ->with('companies', company::all())
        ->with('companyVacancies', companyvacancies::all())
        ->with('companyDetails', companyDetails::all())
        ->with('companyInterviews', companyInterviews::where('candidate_id_user',$id_user)
                                                     ->where(function($step) {
                                                           $step->where('statut', '2');
                                                           $step->orWhere('statut', '3');
                                                           $step->orWhere('statut', '4');
                                                           $step->orWhere('statut', '6');
                                                             })
                                                     ->get());
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function faq(Request $request){

    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/faq',[
        'candidates'=>$candidates,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }
}

public function feedback(Request $request){

    $id_user = $request->user()->id;
    $candidates = DB::table('candidates')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;
    if($grade == 1){
      return View::make('candidateplatform/feedback',[
        'candidates'=>$candidates,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function getDisplay(Request $request, $file_name)
{
    $id_user = $request->user()->id;
    $file= storage_path()."/app/documents/".$id_user."/".$file_name;

    $headers = array(
              'Content-Type: application',
            );

  return response()->download($file);
}

public function getDownload(Request $request, $file_name)
{
    $id_user = $request->user()->id;
    $file= storage_path()."/app/documents/".$id_user."/".$file_name;

    $headers = array(
              'Content-Type: application',
            );

    return response()->download($file, $file_name, $headers);
}


public function getDownloadCandidate(Request $request, $file_name)
{
    $id_user = $request->input('candidate_id_user');
    $file= storage_path()."/app/documents/".$id_user."/".$file_name;

    $headers = array(
              'Content-Type: application',
            );

    return response()->download($file, $file_name, $headers);
}

public function getDownloadCompany(Request $request, $file_name)
{
    $id_user = $request->input('company_id_user');
    $file= storage_path()."/app/documents/".$id_user."/".$file_name;

    $headers = array(
              'Content-Type: application',
            );

    return response()->download($file, $file_name, $headers);
}


public function getDownloadPublic(Request $request, $file_name)
{

    $file= storage_path()."/app/public/".$file_name;

    $headers = array(
              'Content-Type: application',
            );

    return response()->download($file, $file_name, $headers);
}




public function delete(Request $request, $file)
{
    $id_user = $request->user()->id;
    $file_delete = storage_path()."/app/documents/".$id_user."/".$file;

    File::Delete($file_delete);

    $grade = $request->user()->grade;
    $id_user = $request->user()->id;


    if($grade == 1){
       DB::table('candidateDocuments')->where('id_user',$id_user)->where('fileName',$file)->delete();
    }

    if($grade == 3){
      DB::table('partnerDocuments')->where('id_user',$id_user)->where('fileName',$file)->delete();
    }


    return redirect()->back();
}


// Company routes

public function company_about(Request $request){
  $id_user = $request->user()->id;
  $about =  $request->input('about');
  DB::table('companyDetails')->where('id_user',$id_user)->update( array('about' => $about) );

  return redirect()->back();
}

public function company_values(Request $request){
  $id_user = $request->user()->id;
  $values =  $request->input('values');
  DB::table('companyDetails')->where('id_user',$id_user)->update( array('values' => $values) );

  return redirect()->back();
}

public function companyInvitefriends(Request $request){
  $id_user = $request->user()->id;

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/invitefriends',[
      'companies'=>$companies,
      'companyUsers'=>$companyUsers,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function companyInvitecompany(Request $request){
  $id_user = $request->user()->id;

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/invitecompany',[
      'companies'=>$companies,
      'companyUsers'=>$companyUsers,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }



}

public function companySettings(Request $request){
    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $companyDetails = DB::table('companyDetails')->where('id_user',$id_user)->first();
    $companyUsers = DB::table('companyUsers')->where('id_user',$id_user)->first();
    $offices = DB::table('offices')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/settings',[
        'companies'=>$companies,
        'companyDetails'=>$companyDetails,
        'companyUsers'=>$companyUsers,
        'offices' => $offices,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }


}

public function companyInterviews(Request $request){
    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    $id_company = $companies->id;

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/interviews',[
        'companies'=>$companies,
        ])->with('vacancies', companyVacancies::all()->where('id_company',$id_company))
          ->with('candidates', candidate::all())
          ->with('companyInterviews', companyInterviews::all());
    }
    else {
      return View::make('404',[
      ]);
    }



}

public function companyVacancies(Request $request){
    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $companyVacancies = DB::table('companyVacancies')->where('id_user',$id_user)->first();
    $id_company = $companies->id;

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/vacancies',[
        'companies'=>$companies,
        'companyVacancies'=>$companyVacancies,
        ])->with('vacancies', companyVacancies::all()->where('id_company',$id_company));
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function companyVacancyDetails(Request $request){
    $id_user = $request->user()->id;
    $vacancy_id = $request->input('vacancy_id');


    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $id_company = $companies->id;
    $company_id_user = $companies->id_user;

    $companyVacancies = DB::table('companyVacancies')->where('id',$vacancy_id) // to return the right vacancy
                                                     ->where('id_company',$id_company)   // to return vacancies that only belong to the company (if the user changes the vacancy id in the URL bar)
                                                     ->first();
    $vacancyId = $companyVacancies->id;
    $positionFunction = $companyVacancies->function;
    $positionAddress = $companyVacancies->address;
    $seniorityStarter = $companyVacancies->seniorityLevelStarter;
    $seniorityJunior = $companyVacancies->seniorityLevelJunior;
    $seniorityConfirmed = $companyVacancies->seniorityLevelConfirmed;
    $senioritySenior = $companyVacancies->seniorityLevelSenior;
    $companyType = $companies->companyType;
    $vacancyStage = $companyVacancies->vacancyStage;
    $companyIdUser = $companyVacancies->id_user;
    $contractType = $companyVacancies->contractType;
    $startDate = $companyVacancies->startDate;
    $budget = $companyVacancies->budget;
    $occupationRate = $companyVacancies->occupationRate;
    $visaSponsor = $companyVacancies->visaSponsor;

    $language1 = $companyVacancies->language1;
    $language1Level = $companyVacancies->language1Level;
    $language1Statut = $companyVacancies->language1Statut;

    $language2 = $companyVacancies->language2;
    $language2Level = $companyVacancies->language2Level;
    $language2Statut = $companyVacancies->language2Statut;

    $language3 = $companyVacancies->language3;
    $language3Level = $companyVacancies->language3Level;
    $language3Statut = $companyVacancies->language3Statut;

    $language4 = $companyVacancies->language4;
    $language4Level = $companyVacancies->language4Level;
    $language4Statut = $companyVacancies->language4Statut;

    $IT1 = $companyVacancies->IT1;
    $IT1Usage = $companyVacancies->IT1Usage;
    $IT2 = $companyVacancies->IT2;
    $IT2Usage = $companyVacancies->IT2Usage;
    $IT3 = $companyVacancies->IT3;
    $IT3Usage = $companyVacancies->IT3Usage;
    $IT4 = $companyVacancies->IT4;
    $IT4Usage = $companyVacancies->IT4Usage;
    $IT5 = $companyVacancies->IT5;
    $IT5Usage = $companyVacancies->IT5Usage;



    if($vacancyStage == '6'){
    $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('company_id_user',$companyIdUser)
                                                                     ->where('nextStep','3')
                                                                     ->first();
    $candidateIdUser = $companyInterviewFeedback->candidate_id_user;
    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

      return View::make('companyplatform/vacancydetailsplacement',[
        'candidates'=>$candidates,
        'companies'=>$companies,
        'companyVacancies'=>$companyVacancies,
        'companyInterviewFeedback'=>$companyInterviewFeedback,
      ]);
  }



  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/vacancydetails',[
      'companies'=>$companies,
      'companyVacancies'=>$companyVacancies,
    ])->with('partnerInterviewFeedback', partnerInterviewFeedback::where(function($query) use ($positionFunction,$seniorityStarter,$seniorityJunior,$seniorityConfirmed,$senioritySenior,$companyType){
                                                                      $query->where('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityStarter.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityJunior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityConfirmed.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$senioritySenior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                  })

                                                                 ->where(function($languageOne) use ($language1,$language1Level){
                                                                   if($language1Level == 'basic'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£good level/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'good level'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'fluent'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'mother tongue'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                ->where(function($languageTwo) use ($language2,$language2Level){
                                                                  if($language2Level == 'basic'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£good level/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'good level'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'fluent'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'mother tongue'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                  }
                                                                 })

                                                                 ->where(function($languageThree) use ($language3,$language3Level){
                                                                   if($language3Level == 'basic'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£good level/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'good level'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'fluent'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'mother tongue'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($languageFour) use ($language4,$language4Level){
                                                                   if($language4Level == 'basic'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£good level/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'good level'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'fluent'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'mother tongue'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($ITOne) use ($IT1,$IT1Usage){
                                                                   if($IT1Usage == 'class'){
                                                                     $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                     $ITOne->orWhere('ITSkills', 'LIKE', '%'.$IT1.'/£work'.'%');
                                                                   }
                                                                   if($IT1Usage == 'work'){
                                                                   $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                   }
                                                                   })
                                                                  ->where(function($ITTwo) use ($IT2,$IT2Usage){
                                                                    if($IT2Usage == 'class'){
                                                                      $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                      $ITTwo->orWhere('ITSkills', 'LIKE', '%'.$IT2.'/£work'.'%');
                                                                    }
                                                                    if($IT2Usage == 'work'){
                                                                     $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITThree) use ($IT3,$IT3Usage){
                                                                    if($IT3Usage == 'class'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                      $ITThree->orWhere('ITSkills', 'LIKE', '%'.$IT3.'/£work'.'%');
                                                                    }
                                                                    if($IT3Usage == 'work'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFour) use ($IT4,$IT4Usage){
                                                                    if($IT4Usage == 'class'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                      $ITFour->orWhere('ITSkills', 'LIKE', '%'.$IT4.'/£work'.'%');
                                                                    }
                                                                    if($IT4Usage == 'work'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFive) use ($IT5,$IT5Usage){
                                                                    if($IT5Usage == 'class'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                      $ITFive->orWhere('ITSkills', 'LIKE', '%'.$IT5.'/£work'.'%');
                                                                    }
                                                                    if($IT5Usage == 'work'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                    }
                                                                   })
                                                                  ->get())

      ->with('candidates', candidate::where('interviewStatut','10')->orWhere('interviewStatut', '18')
                                                                   ->orWhere('interviewStatut', '19')
                                                                   ->orWhere('interviewStatut', '20')
                                                                   ->orWhere('interviewStatut', '21')
                                                                   ->orWhere('interviewStatut', '22')
                                                                   ->orWhere('interviewStatut', '23')
                                                                   ->orWhere('interviewStatut', '24')
                                                                   ->orWhere('interviewStatut', '25')
                                                                   ->get())
      ->with('candidateDetails', candidateDetails::where(function($contract) use ($contractType){
                                                                        $contract->where('contractTypePermanent', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTH', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTemporary', 'LIKE', $contractType);
                                                                    })

                                                 ->where(function($start) use ($startDate){
                                                      $start->where('availability', '<=', $startDate);
                                                   })

                                                 ->where(function($salary) use ($budget){
                                                      $salary->whereBetween('salaryExpectations', [0,$budget*1.05]);
                                                   })
                                                 ->where(function($occupation) use ($occupationRate){
                                                      $occupation->where('partTimeMin', '<=', $occupationRate);
                                                      $occupation->where('partTimeMax', '>=', $occupationRate);
                                                   })
                                                 ->where(function($mobility) use ($positionAddress){

                                                      })

                                                 ->where(function($permit) use ($visaSponsor){
                                                   if($visaSponsor == 'No'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                    }
                                                   if($visaSponsor == 'Yes'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                      $permit->orWhere('workPermit', 'LIKE', 'No');
                                                    }
                                                   })
                                                 ->get())

      ->with('companyInterviews', companyInterviews::where('company_vacancy',$vacancyId)->get())
      ->with('companyInterviewFeedback', companyInterviewFeedback::where('company_id_user',$company_id_user)->get());



      }
      else {
        return View::make('404',[
        ]);
      }

}


public function company_closeOpportunity(Request $request){
    $id_user = $request->user()->id;
    $companyVacancyId = Input::get('companyVacancyId');
    $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacancyId)->update( array(
      'vacancyStage' => '5',
      'vacancyStatut' => '2',
    ));

    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacancyId)->first();
    $id_company = $companyVacancies->id_company;

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/vacancies',[
        'companies'=>$companies,
        'companyVacancies'=>$companyVacancies,
        ])->with('vacancies', companyVacancies::all()->where('id_company',$id_company));
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function company_deleteOpportunity(Request $request){
    $id_user = $request->user()->id;
    $companyVacancyId = Input::get('companyVacancyId');
    $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacancyId)->update( array(
      'vacancyStatut' => '3',
    ));

    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacancyId)->first();
    $id_company = $companyVacancies->id_company;

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/vacancies',[
        'companies'=>$companies,
        'companyVacancies'=>$companyVacancies,
        ])->with('vacancies', companyVacancies::all()->where('id_company',$id_company));
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function seeCandidates(Request $request){
  $id_user = $request->user()->id;
  $candidateId = $request->input('candidate_id');
  $companyVacancy = $request->input('companyVacancy');
  $vacancyFunction = $request->input('vacancyFunction');

  $candidates = DB::table('candidates')->where('id',$candidateId)->first();
  $id_userCandidate = $candidates->id_user;
  $companies = DB::table('companies')->where('id_user',$id_user)->first();

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_userCandidate)->first();

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyIdUser = $companies->id_user;

  $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user', $id_userCandidate)
                                                     ->where('company_vacancy', $companyVacancy)
                                                     ->orderBy('round', 'DESC')
                                                     ->first();

  $id_company = $companies->id;

  $companyVacancies = DB::table('companyVacancies')->where('id',$companyVacancy)
                                                   ->where('id_company',$id_company)
                                                   ->first();

  if (is_null($companyInterviews)) {
    $companyInterviews = new companyInterviews();
    $companyInterviews->statut = '1';
    $companyInterviews->round = 1;
    $companyInterviews->company_vacancy = $companyVacancy;
    $companyInterviews->company_id_user = $companyIdUser;
    $companyInterviews->candidate_id_user = $id_userCandidate;
    $companyInterviews->save();
  }

  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/candidateDetails',[
      'companyVacancies'=>$companyVacancies,
      'companyInterviews'=>$companyInterviews,
      'companies'=>$companies,
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'vacancyFunction'=>$vacancyFunction,
    ])->with('documents', candidateDocuments::all()->where('id_user',$id_userCandidate))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$id_userCandidate)
                                                                        ->where("recommendation","Yes"))
      ->with('partnerDetails', partnerDetails::all())
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_userCandidate));
  }
  else {
    return View::make('404',[
    ]);
  }



}


public function company_interviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidateIdUser = Input::get('candidate_id_user');
  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '18',
    'opportunitiesStatut' => '3',
    ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $companies = DB::table('companies')->where('id_user',$id_user)->first();

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $sharelink = $candidateInfos->shareLink;

  Mail::send('email.candidateCompanyAskInterview',['candidates' => $candidates, 'companies' => $companies, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Company interview');
  });

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyId = $companies->id;
  $companyIdUser = $companies->id_user;

  $interviewer1Names = Input::get('interviewer1Names');
  $interviewer1Position = Input::get('interviewer1Position');
  $interviewer2Names = Input::get('interviewer2Names');
  $interviewer2Position = Input::get('interviewer2Position');
  $interviewer3Names = Input::get('interviewer3Names');
  $interviewer3Position = Input::get('interviewer3Position');

  $location = Input::get('location');

  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  DB::table('companyInterviews')->where('candidate_id_user',$candidateIdUser)
                                ->where('company_id_user',$companyIdUser)
                                ->orderBy('round', 'DESC')
                                ->take(1)
                                ->update( array(
  'statut' => '2',

  'interviewer1Names' => $interviewer1Names,
  'interviewer1Position' => $interviewer1Position,
  'interviewer2Names' => $interviewer2Names,
  'interviewer2Position' => $interviewer2Position,
  'interviewer3Names' => $interviewer3Names,
  'interviewer3Position' => $interviewer3Position,
  'location' => $location,
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  ));

  $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$companyIdUser)
                                                     ->where('candidate_id_user',$candidateIdUser)->first();
  $companyVacancyId = $companyInterviews->company_vacancy;

  DB::table('companyVacancies')->where('id',$companyVacancyId)->update( array(
  'vacancyStage' => '2',
  ));

  $offices = DB::table('offices')->where('id_user',$id_user)->first();


  $companyDetails = DB::table('companyDetails')->where('id_user',$id_user)->first();
  $grade = $request->user()->grade;

  $grade = $request->user()->grade;


  if($grade == 2){
    return View::make('companyplatform/home',[
      'companies'=>$companies,
      'companyDetails'=>$companyDetails,
      'offices'=>$offices,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function company_confirmCandidateInterview(Request $request){
    $id_user = $request->user()->id;

    $candidateIdUser = $request->input('candidate_id_user');
    $dateTime =  $request->input('propositionCompany');
    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }

    $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$id_user)
                                                       ->where('candidate_id_user',$candidateIdUser)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->update( array(
        'statut' => '4',
        'date' => $date,
        'time' => $time,
      ));

    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '20',
    ));

    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    Mail::send('email.candidateCompanyConfirmInterview',['candidates' => $candidates, 'companies' => $companies],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Company interview');
    });

    Mail::send('email.companyConfirmCandidateInterview',['companies' => $companies],function($mail) use ($companies) {
      $mail->to($companies->company_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });

    $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$id_user)
                                                       ->where('candidate_id_user',$candidateIdUser)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->first();
    $companyInterviewsId = $companyInterviews->id;
    $companyIdUser = $companyInterviews->company_id_user;
    $interviewDate = $companyInterviews->date;
    $interviewTime = $companyInterviews->time;
    $interviewRound = $companyInterviews->round;


    $companyVacancyId = $companyInterviews->company_vacancy;

    DB::table('companyVacancies')->where('id',$companyVacancyId)->update( array(
    'vacancyStage' => '3',
    ));

    $companyInterviewFeedback = new companyInterviewFeedback();
    $companyInterviewFeedback->companyInterviews_id = $companyInterviewsId;
    $companyInterviewFeedback->round = $interviewRound;
    $companyInterviewFeedback->company_id_user = $companyIdUser;
    $companyInterviewFeedback->candidate_id_user = $candidateIdUser;
    $companyInterviewFeedback->candidateStatut = '1';
    $companyInterviewFeedback->companyStatut = '1';
    $companyInterviewFeedback->date = $interviewDate;
    $companyInterviewFeedback->time = $interviewTime;
    $companyInterviewFeedback->save();

    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $companyDetails = DB::table('companyDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/home',[
        'companies'=>$companies,
        'companyDetails'=>$companyDetails,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function company_candidateInterviewFeedback(Request $request){
  $id_user = $request->user()->id;
  $candidate_id_user =  $request->input('candidate_id_user');

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
  $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('company_id_user',$id_user)
                                                                   ->where('candidate_id_user',$candidate_id_user)
                                                                   ->orderBy('round', 'DESC')
                                                                   ->take(1)
                                                                   ->first();

  $companyInterviews = DB::table('companyInterviews')->where('company_id_user',$id_user)
                                                     ->where('candidate_id_user',$candidate_id_user)
                                                     ->orderBy('round', 'DESC')
                                                     ->take(1)
                                                     ->first();

  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/itwcandidatefeedback',[
      'candidates'=>$candidates,
      'companies'=>$companies,
      'companyInterviewFeedback'=>$companyInterviewFeedback,
      'companyInterviews'=>$companyInterviews,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function company_interviewCandidateFeedback(Request $request){
  $id_user = $request->user()->id;
  $candidate_id_user =  $request->input('candidate_id_user');

  $offices = DB::table('offices')->where('id_user',$id_user)->first();

  $companyExperienceCandidate = Input::get('companyExperienceCandidate');
  $forward = Input::get('forward');
  $reasonNoGoForward = Input::get('reasonNoGoForward');
  $noteForCandidateNoGo = Input::get('noteForCandidateNoGo');
  $nextStep = Input::get('nextStep');

  $interviewer1Names = Input::get('interviewer1Names');
  $interviewer1Position = Input::get('interviewer1Position');
  $interviewer2Names = Input::get('interviewer2Names');
  $interviewer2Position = Input::get('interviewer2Position');
  $interviewer3Names = Input::get('interviewer3Names');
  $interviewer3Position = Input::get('interviewer3Position');
  $interviewer4Names = Input::get('interviewer4Names');
  $interviewer4Position = Input::get('interviewer4Position');
  $location = Input::get('location');
  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  $offerContractType = Input::get('offerContractType');
  $offerStartDate = Input::get('offerStartDate');
  $offerEndDateTH = Input::get('offerEndDateTH');
  $offerEndDateTempo = Input::get('offerEndDateTempo');
  $baseSalary = Input::get('baseSalary');
  $bonus = Input::get('bonus');
  $otherAdvantages = Input::get('otherAdvantages');
  $yearlyPackage = Input::get('yearlyPackage');
  $noteForCandidateGo = Input::get('noteForCandidateGo');
  $otherComments = Input::get('otherComments');



  $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('company_id_user',$id_user)
                                                                   ->orderBy('round', 'DESC')
                                                                   ->take(1)
                                                                   ->update( array(
  'companyStatut' => '2',
  'companyExperienceCandidate' => $companyExperienceCandidate,
  'forward' => $forward,
  'reasonNoGoForward' => $reasonNoGoForward,
  'noteForCandidateNoGo' => $noteForCandidateNoGo,
  'nextStep' => $nextStep,
  'noteForCandidateGo' => $noteForCandidateGo,
  'otherComments' => $otherComments,
  'offerContractType' => $offerContractType,
  'offerStartDate' => $offerStartDate,
  'offerEndDateTH' => $offerEndDateTH,
  'offerEndDateTempo' => $offerEndDateTempo,
  'offerContractType' => $offerContractType,
  'baseSalary' => $baseSalary,
  'bonus' => $bonus,
  'otherAdvantages' => $otherAdvantages,
  'yearlyPackage' => $yearlyPackage,

  ));

  if($forward == 'No'){
    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$candidate_id_user)
                                                       ->where('company_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->update( array(
    'statut' => '9',
    ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    Mail::send('email.candidateCompanyNoGo',['candidates' => $candidates, 'companies' => $companies],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Feedback entretien');
    });

  }
  if($nextStep == '2'){
    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$candidate_id_user)
                                                       ->where('company_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->update( array(
           'statut' => '10',
           ));
    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$candidate_id_user)
                                                       ->where('company_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->first();
    $companyInterviewRound = $companyInterviews->round;
    $companyVacancy = $companyInterviews->company_vacancy;

    $companyInterviews = new companyInterviews();
    $companyInterviews->company_vacancy = $companyVacancy;
    $companyInterviews->statut = 2;
    $companyInterviews->round = $companyInterviewRound + 1;
    $companyInterviews->company_id_user = $id_user;
    $companyInterviews->candidate_id_user = $candidate_id_user;
    $companyInterviews->location = $location;
    $companyInterviews->datepicker1 = $datepicker1;
    $companyInterviews->timepicker1 = $timepicker1;
    $companyInterviews->datepicker2 = $datepicker2;
    $companyInterviews->timepicker2 = $timepicker2;
    $companyInterviews->datepicker3 = $datepicker3;
    $companyInterviews->timepicker3 = $timepicker3;
    $companyInterviews->interviewer1Names = $interviewer1Names;
    $companyInterviews->interviewer1Position = $interviewer1Position;
    $companyInterviews->interviewer2Names = $interviewer2Names;
    $companyInterviews->interviewer2Position = $interviewer2Position;
    $companyInterviews->interviewer3Names = $interviewer3Names;
    $companyInterviews->interviewer3Position = $interviewer3Position;
    $companyInterviews->interviewer4Names = $interviewer4Names;
    $companyInterviews->interviewer4Position = $interviewer4Position;
    $companyInterviews->save();


    $vacancyId = $companyInterviews->company_vacancy;

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
      'interviewStatut' => '18',
      ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    Mail::send('email.candidateCompanyNewInterview',['candidates' => $candidates, 'companies' => $companies],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Company interview');
    });

    $companyVacancies = DB::table('companyVacancies')->where('id',$vacancyId)->update( array(
    'vacancyStage' => '3',
    ));
  }
  if($nextStep == '3'){
    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$candidate_id_user)
                                                       ->where('company_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->update( array(
    'statut' => '6',
    ));

    $companyInterviews = DB::table('companyInterviews')->where('candidate_id_user',$candidate_id_user)
                                                       ->where('company_id_user',$id_user)
                                                       ->orderBy('round', 'DESC')
                                                       ->take(1)
                                                       ->first();

    $vacancyId = $companyInterviews->company_vacancy;

    $companyVacancies = DB::table('companyVacancies')->where('id',$vacancyId)->update( array(
    'vacancyStage' => '4',
    ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    Mail::send('email.candidateCompanyOffer',['candidates' => $candidates, 'companies' => $companies],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('You just received an offer!');
    });
  }




  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyDetails = DB::table('companyDetails')->where('id_user',$id_user)->first();
  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/home',[
      'companies'=>$companies,
      'companyDetails'=>$companyDetails,
      'offices'=>$offices,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}



public function companyFaq(Request $request){

    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/faq',[
        'companies'=>$companies,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function companyFeedback(Request $request){

    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/feedback',[
        'companies'=>$companies,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function companyRecruit(Request $request){

    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;
    if($grade == 2){
      return View::make('companyplatform/recruit',[
        'companies'=>$companies,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function companyNewVacancyForm(Request $request){

    $id_user = $request->user()->id;
    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $offices = DB::table('offices')->where('id_user',$id_user)->first();

    $companyStatut = $companies->statut;

    $grade = $request->user()->grade;
    if($grade == 2){

        if($companyStatut ==  '1' || $companyStatut ==  '3'){
          return View::make('companyplatform/newvacancyformProfileReviewed',[
            'companies'=>$companies,
            'offices'=>$offices,
          ]);
        }
        if($companyStatut ==  '2'){
        return View::make('companyplatform/newvacancyform',[
          'companies'=>$companies,
          'offices'=>$offices,
        ]);
      }
      if($companyStatut ==  '4'){
      return View::make('companyplatform/recruitProfileNoMatch',[
        'companies'=>$companies,
        'offices'=>$offices,
      ]);
    }
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function company_feedbackTieTalent(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $feedbackTieTalentRating =  $request->input('feedbackTieTalentRating');
  $feedbackTieTalentText =  $request->input('feedbackTieTalentText');

  DB::table('companyInfos')->where('id_user',$id_user)->update( array(
    'feedbackTieTalentRating' => $feedbackTieTalentRating,
    'feedbackTieTalentText' => $feedbackTieTalentText,
  ) );

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyInfos = DB::table('companyInfos')->where('id_user',$id_user)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$id_user)->first();

  Mail::send('email.feedbackTieTalentCompany',['user' => $user, 'companies' => $companies, 'companyUsers' => $companyUsers, 'companyInfos' => $companyInfos],function($mail) use ($user) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Company feedback on TieTalent');
  });

  $grade = $request->user()->grade;
  if($grade == 2){
    return View::make('companyplatform/feedbackSent',[
      'companies'=>$companies,
      'companyInfos'=>$companyInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}

public function company_inviteFriends(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailFriendsContent =  $request->input('emailFriendsContent');
  $inviteFirstName1 =  $request->input('inviteFirstName1');
  $inviteEmail1 =  $request->input('inviteEmail1');
  $inviteFirstName2 =  $request->input('inviteFirstName2');
  $inviteEmail2 =  $request->input('inviteEmail2');
  $inviteFirstName3 =  $request->input('inviteFirstName3');
  $inviteEmail3 =  $request->input('inviteEmail3');
  $inviteFirstName4 =  $request->input('inviteFirstName4');
  $inviteEmail4 =  $request->input('inviteEmail4');
  $inviteFirstName5 =  $request->input('inviteFirstName5');
  $inviteEmail5 =  $request->input('inviteEmail5');
  $inviteFirstName6 =  $request->input('inviteFirstName6');
  $inviteEmail6 =  $request->input('inviteEmail6');
  $inviteFirstName7 =  $request->input('inviteFirstName7');
  $inviteEmail7 =  $request->input('inviteEmail7');
  $inviteFirstName8 =  $request->input('inviteFirstName8');
  $inviteEmail8 =  $request->input('inviteEmail8');
  $inviteFirstName9 =  $request->input('inviteFirstName9');
  $inviteEmail9 =  $request->input('inviteEmail9');


  DB::table('companyInviteFriends')->where('id_user',$id_user)->update( array(
    'emailFriendsContent' => $emailFriendsContent,
    'inviteFirstName1' => $inviteFirstName1,
    'inviteEmail1' => $inviteEmail1,
    'inviteFirstName2' => $inviteFirstName2,
    'inviteEmail2' => $inviteEmail2,
    'inviteFirstName3' => $inviteFirstName3,
    'inviteEmail3' => $inviteEmail3,
    'inviteFirstName4' => $inviteFirstName4,
    'inviteEmail4' => $inviteEmail4,
    'inviteFirstName5' => $inviteFirstName5,
    'inviteEmail5' => $inviteEmail5,
    'inviteFirstName6' => $inviteFirstName6,
    'inviteEmail6' => $inviteEmail6,
    'inviteFirstName7' => $inviteFirstName7,
    'inviteEmail7' => $inviteEmail7,
    'inviteFirstName8' => $inviteFirstName8,
    'inviteEmail8' => $inviteEmail8,
    'inviteFirstName9' => $inviteFirstName9,
    'inviteEmail9' => $inviteEmail9,

  ) );

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyInviteFriends = DB::table('companyInviteFriends')->where('id_user',$id_user)->first();


  if($inviteFirstName1 != '' && $inviteEmail1 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail2 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail3 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail4 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail5 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail6 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail7 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail8 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail9 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'companies' => $companies, 'companyInviteFriends' => $companyInviteFriends],function($mail) use ($companyInviteFriends) {
      $mail->to($companyInviteFriends->inviteEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }


  return redirect()->back();
}

public function company_inviteCompany(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailCompanyContent =  $request->input('emailCompanyContent');
  $inviteCompanyFirstName1 =  $request->input('inviteCompanyFirstName1');
  $inviteCompanyEmail1 =  $request->input('inviteCompanyEmail1');
  $inviteCompanyFirstName2 =  $request->input('inviteCompanyFirstName2');
  $inviteCompanyEmail2 =  $request->input('inviteCompanyEmail2');
  $inviteCompanyFirstName3 =  $request->input('inviteCompanyFirstName3');
  $inviteCompanyEmail3 =  $request->input('inviteCompanyEmail3');
  $inviteCompanyFirstName4 =  $request->input('inviteCompanyFirstName4');
  $inviteCompanyEmail4 =  $request->input('inviteCompanyEmail4');
  $inviteCompanyFirstName5 =  $request->input('inviteCompanyFirstName5');
  $inviteCompanyEmail5 =  $request->input('inviteCompanyEmail5');
  $inviteCompanyFirstName6 =  $request->input('inviteCompanyFirstName6');
  $inviteCompanyEmail6 =  $request->input('inviteCompanyEmail6');
  $inviteCompanyFirstName7 =  $request->input('inviteCompanyFirstName7');
  $inviteCompanyEmail7 =  $request->input('inviteCompanyEmail7');
  $inviteCompanyFirstName8 =  $request->input('inviteCompanyFirstName8');
  $inviteCompanyEmail8 =  $request->input('inviteCompanyEmail8');
  $inviteCompanyFirstName9 =  $request->input('inviteCompanyFirstName9');
  $inviteCompanyEmail9 =  $request->input('inviteCompanyEmail9');


  DB::table('companyInviteCompany')->where('id_user',$id_user)->update( array(
    'emailCompanyContent' => $emailCompanyContent,
    'inviteCompanyFirstName1' => $inviteCompanyFirstName1,
    'inviteCompanyEmail1' => $inviteCompanyEmail1,
    'inviteCompanyFirstName2' => $inviteCompanyFirstName2,
    'inviteCompanyEmail2' => $inviteCompanyEmail2,
    'inviteCompanyFirstName3' => $inviteCompanyFirstName3,
    'inviteCompanyEmail3' => $inviteCompanyEmail3,
    'inviteCompanyFirstName4' => $inviteCompanyFirstName4,
    'inviteCompanyEmail4' => $inviteCompanyEmail4,
    'inviteCompanyFirstName5' => $inviteCompanyFirstName5,
    'inviteCompanyEmail5' => $inviteCompanyEmail5,
    'inviteCompanyFirstName6' => $inviteCompanyFirstName6,
    'inviteCompanyEmail6' => $inviteCompanyEmail6,
    'inviteCompanyFirstName7' => $inviteCompanyFirstName7,
    'inviteCompanyEmail7' => $inviteCompanyEmail7,
    'inviteCompanyFirstName8' => $inviteCompanyFirstName8,
    'inviteCompanyEmail8' => $inviteCompanyEmail8,
    'inviteCompanyFirstName9' => $inviteCompanyFirstName9,
    'inviteCompanyEmail9' => $inviteCompanyEmail9,

  ) );

  $companies = DB::table('companies')->where('id_user',$id_user)->first();
  $companyInviteCompany = DB::table('companyInviteCompany')->where('id_user',$id_user)->first();


  if($inviteCompanyFirstName1 != '' && $inviteCompanyEmail1 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail2 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail3 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail4 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail5 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail6 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail7 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail8 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail9 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'companies' => $companies, 'companyInviteCompany' => $companyInviteCompany],function($mail) use ($companyInviteCompany) {
      $mail->to($companyInviteCompany->inviteCompanyEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }


  return redirect()->back();
}


public function company_communication(Request $request){
  $id_user = $request->user()->id;
  $communication =  $request->input('communication');
  DB::table('companyUsers')->where('id_user',$id_user)->update( array('communication' => $communication) );

  return redirect()->back();
}

public function company_userInformation(Request $request){
  $id_user = $request->user()->id;
  $firstName =  $request->input('firstName');
  $lastName =  $request->input('lastName');
  $position =  $request->input('position');
  $user_email =  $request->input('user_email');
  $user_phone =  $request->input('user_phone');


  DB::table('companyUsers')->where('id_user',$id_user)->update( array(
    'firstName' => $firstName,
    'lastName' => $lastName,
    'position' => $position,
    'user_email' => $user_email,
    'user_phone' => $user_phone,
  ) );

  DB::table('users')->where('id',$id_user)->update( array(
    'email' => $user_email,
  ) );


    return redirect()->back();

}



public function company_companyInformation(Request $request){
  $id_user = $request->user()->id;

  $company =  $request->input('company');
  $website =  $request->input('website');
  $companyType = $request->input('companyType');
  $companyType_other = $request->input('companyType_other');
  $numberEmployeesWorld =  $request->input('numberEmployeesWorld');
  $companyHQ =  $request->input('companyHQ');
  $listed =  $request->input('listed');
  $officeRole = $request->input('officeRole');
  $officeRole_other = $request->input('officeRole_other');
  $numberEmployeesOffice = $request->input('numberEmployeesOffice');
  $officeAddress = $request->input('officeAddress');
  $numberRecruitment = $request->input('numberRecruitment');

  $officeDepartmentFinanceAccounting = $request->input('officeDepartmentFinanceAccounting');
  $officeDepartmentHR = $request->input('officeDepartmentHR');
  $officeDepartmentSalesMarketingCommunications = $request->input('officeDepartmentSalesMarketingCommunications');
  $officeDepartmentIT = $request->input('officeDepartmentIT');
  $officeDepartmentOfficeSupport = $request->input('officeDepartmentOfficeSupport');
  $officeDepartmentLegal = $request->input('officeDepartmentLegal');
  $officeDepartmentmentSupplyChain = $request->input('officeDepartmentmentSupplyChain');
  $officeDepartmentOther = $request->input('officeDepartmentOther');
  $officeDepartment_other = $request->input('officeDepartment_other');


  DB::table('companies')->where('id_user',$id_user)->update( array(
    'company' => $company,
    'website' => $website,

  ) );

  DB::table('companyDetails')->where('id_user',$id_user)->update( array(
    'companyType' => $companyType,
    'companyType_other' => $companyType_other,
    'numberEmployeesWorld' => $numberEmployeesWorld,
    'companyHQ' => $companyHQ,
    'listed' => $listed,
  ) );

  DB::table('offices')->where('id_user',$id_user)->update( array(
    'officeRole' => $officeRole,
    'officeRole_other' => $officeRole_other,
    'numberEmployeesOffice' => $numberEmployeesOffice,
    'officeAddress' => $officeAddress,
    'numberRecruitment' => $numberRecruitment,

    'officeDepartmentFinanceAccounting' => $officeDepartmentFinanceAccounting,
    'officeDepartmentHR' => $officeDepartmentHR,
    'officeDepartmentSalesMarketingCommunications' => $officeDepartmentSalesMarketingCommunications,
    'officeDepartmentIT' => $officeDepartmentIT,
    'officeDepartmentOfficeSupport' => $officeDepartmentOfficeSupport,
    'officeDepartmentLegal' => $officeDepartmentLegal,
    'officeDepartmentmentSupplyChain' => $officeDepartmentmentSupplyChain,
    'officeDepartmentOther' => $officeDepartmentOther,
    'officeDepartment_other' => $officeDepartment_other,

  ) );


    return redirect()->back();

}

public function company_skype(Request $request){
  $id_user = $request->user()->id;
  $company_skype =  $request->input('company_skype');

  DB::table('companies')->where('id_user',$id_user)->update( array(
    'company_skype' => $company_skype,

  ) );

  return redirect()->back();
}

public function company_password(Request $request){
  $id_user = $request->user()->id;
  $password =  $request->input('password');
  $password_confirm =  $request->input('password_confirm');

  if($password == $password_confirm){

    DB::table('users')->where('id',$id_user)->update( array(
      'password' => bcrypt($password),
    ) );

    return redirect()->back();
  }

}

public function company_profilePicture(Request $request){

  $id_user = $request->user()->id;

  if($request->hasFile('avatar')){
    $avatar = $request->file('avatar');
    $filename = time() . '.'. $avatar->getClientOriginalExtension();
    Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

    DB::table('companies')->where('id_user',$id_user)->update( array(
    'avatar' => $filename,
  ));
}

    return back();

}

public function company_newVacancy(Request $request){
    $id_user = $request->user()->id;
    $companyUsers = DB::table('companyUsers')->where('id_user',$id_user)->first();
    $firstNameCompanyUser = $companyUsers->firstName;
    $lastNameCompanyUser = $companyUsers->lastName;
    $emailCompanyUser = $companyUsers->user_email;
    $phoneCompanyUser = $companyUsers->user_phone;

    $companies = DB::table('companies')->where('id_user',$id_user)->first();


    $companyVacancies = new companyVacancies();
    $companyVacancies->id_company = $companies->id;
    $companyVacancies->id_user = $id_user;
    $companyVacancies->vacancyStatut = "1";
    $companyVacancies->vacancyStage = "1";
    $companyVacancies->division = $request['division'];
    $companyVacancies->divisionOther = $request['divisionOther'];
    $companyVacancies->department = $request['department'];
    $companyVacancies->departmentOther = $request['departmentOther'];
    $companyVacancies->function = $request['function'];
    $positionFunction = $companyVacancies->function;
    $companyVacancies->functionOther = $request['functionOther'];

    if($request['address'] == 'Other'){
      $companyVacancies->address = $request['otherAddress'];
    }
    else {
      $companyVacancies->address = $request['address'];
    }



    $companyVacancies->seniorityLevelStarter = $request['seniorityLevelStarter'];
    $companyVacancies->seniorityLevelJunior = $request['seniorityLevelJunior'];
    $companyVacancies->seniorityLevelConfirmed = $request['seniorityLevelConfirmed'];
    $companyVacancies->seniorityLevelSenior = $request['seniorityLevelSenior'];
    $companyVacancies->language1 = $request['language1'];
    $companyVacancies->language1Level = $request['language1Level'];
    $companyVacancies->language1Statut = $request['language1Statut'];
    $companyVacancies->language2 = $request['language2'];
    $companyVacancies->language2Level = $request['language2Level'];
    $companyVacancies->language2Statut = $request['language2Statut'];
    $companyVacancies->language3 = $request['language3'];
    $companyVacancies->language3Level = $request['language3Level'];
    $companyVacancies->language3Statut = $request['language3Statut'];
    $companyVacancies->language4 = $request['language4'];
    $companyVacancies->language4Level = $request['language4Level'];
    $companyVacancies->language4Statut = $request['language4Statut'];
    $companyVacancies->IT1 = $request['IT1'];
    $companyVacancies->IT1Usage = $request['IT1Usage'];
    $companyVacancies->IT2 = $request['IT2'];
    $companyVacancies->IT2Usage = $request['IT2Usage'];
    $companyVacancies->IT3 = $request['IT3'];
    $companyVacancies->IT3Usage = $request['IT3Usage'];
    $companyVacancies->IT4 = $request['IT4'];
    $companyVacancies->IT4Usage = $request['IT4Usage'];
    $companyVacancies->IT5 = $request['IT5'];
    $companyVacancies->IT5Usage = $request['IT5Usage'];
    $companyVacancies->startDate = $request['startDate'];
    $companyVacancies->contractType = $request['contractType'];
    $companyVacancies->occupationRate = $request['occupationRate'];
    $companyVacancies->context = $request['context'];
    $companyVacancies->budget = $request['budget'];
    $companyVacancies->visaSponsor = $request['visaSponsor'];
    $companyVacancies->lineManager = $request['lineManager'];
    $companyVacancies->lineManagerOtherNames = $request['lineManagerOtherNames'];
    $companyVacancies->lineManagerOtherEmail = $request['lineManagerOtherEmail'];
    $companyVacancies->jobDescriptionText = $request['jobDescriptionText'];

    $companyVacancies->save();

    if(!is_null(request()->file('document'))){
      $id_Vacancy = $companyVacancies->id;
      $file = request()->file('document');
      $docExt = $file->guessClientExtension();
      $file->storeAs('documents/' . auth()->id(), "JobDescription.".$id_Vacancy.".".$docExt);
      $storage_path = 'app/documents/'.$id_user.'/';
      $fileName = "JobDescription.".$id_Vacancy.".".$docExt;

      DB::table('companyVacancies')->where('id',$id_Vacancy)->update( array(
          'jobDescriptionStorage_path' => $storage_path,
          'jobDescriptionDocExt' => $docExt,
          'jobDescriptionFileName' => $fileName,
        ));
      }

    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $id_company = $companies->id;
    $company_id_user = $companies->id_user;

    $positionFunction = $companyVacancies->function;
    $vacancyId = $companyVacancies->id;

    $vacancy_id = $request->input('vacancy_id');

    $companies = DB::table('companies')->where('id_user',$id_user)->first();

    $positionFunction = $companyVacancies->function;
    $seniorityStarter = $companyVacancies->seniorityLevelStarter;
    $seniorityJunior = $companyVacancies->seniorityLevelJunior;
    $seniorityConfirmed = $companyVacancies->seniorityLevelConfirmed;
    $senioritySenior = $companyVacancies->seniorityLevelSenior;
    $companyType = $companies->companyType;
    $vacancyStage = $companyVacancies->vacancyStage;
    $companyIdUser = $companyVacancies->id_user;
    $contractType = $companyVacancies->contractType;
    $startDate = $companyVacancies->startDate;
    $occupationRate = $companyVacancies->occupationRate;
    $budget = $companyVacancies->budget;

    $language1 = $companyVacancies->language1;
    $language1Level = $companyVacancies->language1Level;
    $language1Statut = $companyVacancies->language1Statut;

    $language2 = $companyVacancies->language2;
    $language2Level = $companyVacancies->language2Level;
    $language2Statut = $companyVacancies->language2Statut;

    $language3 = $companyVacancies->language3;
    $language3Level = $companyVacancies->language3Level;
    $language3Statut = $companyVacancies->language3Statut;

    $language4 = $companyVacancies->language4;
    $language4Level = $companyVacancies->language4Level;
    $language4Statut = $companyVacancies->language4Statut;

    $IT1 = $companyVacancies->IT1;
    $IT1Usage = $companyVacancies->IT1Usage;
    $IT2 = $companyVacancies->IT2;
    $IT2Usage = $companyVacancies->IT2Usage;
    $IT3 = $companyVacancies->IT3;
    $IT3Usage = $companyVacancies->IT3Usage;
    $IT4 = $companyVacancies->IT4;
    $IT4Usage = $companyVacancies->IT4Usage;
    $IT5 = $companyVacancies->IT5;
    $IT5Usage = $companyVacancies->IT5Usage;

    $visaSponsor = $companyVacancies->visaSponsor;


    Mail::send('email.newCompanyVacancy',[
      'companies' => $companies,
      'positionFunction' => $positionFunction,
      'seniorityStarter' => $seniorityStarter,
      'seniorityJunior' => $seniorityJunior,
      'seniorityConfirmed' => $seniorityConfirmed,
      'senioritySenior' => $senioritySenior,
      'contractType' => $contractType,
      'startDate' => $startDate,
      'occupationRate' => $occupationRate,
      'budget' => $budget,
      'language1' => $language1,
      'language1Level' => $language1Level,
      'language1Statut' => $language1Statut,
      'language2' => $language2,
      'language2Level' => $language2Level,
      'language2Statut' => $language2Statut,
      'language3' => $language3,
      'language3Level' => $language3Level,
      'language3Statut' => $language3Statut,
      'language4' => $language4,
      'language4Level' => $language4Level,
      'language4Statut' => $language4Statut,
      'IT1' => $IT1,
      'IT1Usage' => $IT1Usage,
      'IT2' => $IT2,
      'IT2Usage' => $IT2Usage,
      'IT3' => $IT3,
      'IT3Usage' => $IT3Usage,
      'IT4' => $IT4,
      'IT4Usage' => $IT4Usage,
      'IT5' => $IT5,
      'IT5Usage' => $IT5Usage,
      'firstNameCompanyUser' => $firstNameCompanyUser,
      'lastNameCompanyUser' => $lastNameCompanyUser,
      'emailCompanyUser' => $emailCompanyUser,
      'phoneCompanyUser' => $phoneCompanyUser,
    ],function($mail) use ($companies) {
      $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('New company vacancy!');
    });

    $grade = $request->user()->grade;
    if($grade == 2){

    return View::make('companyplatform/vacancydetails',[
      'companies'=>$companies,
      'companyVacancies'=>$companyVacancies,
    ])->with('partnerInterviewFeedback', partnerInterviewFeedback::where(function($query) use ($positionFunction,$seniorityStarter,$seniorityJunior,$seniorityConfirmed,$senioritySenior,$companyType){
                                                                      $query->where('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityStarter.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityJunior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityConfirmed.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$senioritySenior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                  })

                                                                 ->where(function($languageOne) use ($language1,$language1Level){
                                                                   if($language1Level == 'basic'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£good level/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'good level'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'fluent'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'mother tongue'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                ->where(function($languageTwo) use ($language2,$language2Level){
                                                                  if($language2Level == 'basic'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£good level/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'good level'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'fluent'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'mother tongue'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                  }
                                                                 })

                                                                 ->where(function($languageThree) use ($language3,$language3Level){
                                                                   if($language3Level == 'basic'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£good level/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'good level'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'fluent'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'mother tongue'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($languageFour) use ($language4,$language4Level){
                                                                   if($language4Level == 'basic'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£good level/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'good level'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'fluent'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'mother tongue'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($ITOne) use ($IT1,$IT1Usage){
                                                                   if($IT1Usage == 'class'){
                                                                     $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                     $ITOne->orWhere('ITSkills', 'LIKE', '%'.$IT1.'/£work'.'%');
                                                                   }
                                                                   if($IT1Usage == 'work'){
                                                                   $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                   }
                                                                   })
                                                                  ->where(function($ITTwo) use ($IT2,$IT2Usage){
                                                                    if($IT2Usage == 'class'){
                                                                      $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                      $ITTwo->orWhere('ITSkills', 'LIKE', '%'.$IT2.'/£work'.'%');
                                                                    }
                                                                    if($IT2Usage == 'work'){
                                                                     $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITThree) use ($IT3,$IT3Usage){
                                                                    if($IT3Usage == 'class'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                      $ITThree->orWhere('ITSkills', 'LIKE', '%'.$IT3.'/£work'.'%');
                                                                    }
                                                                    if($IT3Usage == 'work'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFour) use ($IT4,$IT4Usage){
                                                                    if($IT4Usage == 'class'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                      $ITFour->orWhere('ITSkills', 'LIKE', '%'.$IT4.'/£work'.'%');
                                                                    }
                                                                    if($IT4Usage == 'work'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFive) use ($IT5,$IT5Usage){
                                                                    if($IT5Usage == 'class'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                      $ITFive->orWhere('ITSkills', 'LIKE', '%'.$IT5.'/£work'.'%');
                                                                    }
                                                                    if($IT5Usage == 'work'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                    }
                                                                   })
                                                                  ->get())

      ->with('candidates', candidate::where('interviewStatut','10')->orWhere('interviewStatut', '18')
                                                                   ->orWhere('interviewStatut', '19')
                                                                   ->orWhere('interviewStatut', '20')
                                                                   ->orWhere('interviewStatut', '21')
                                                                   ->orWhere('interviewStatut', '22')
                                                                   ->orWhere('interviewStatut', '23')
                                                                   ->orWhere('interviewStatut', '24')
                                                                   ->orWhere('interviewStatut', '25')
                                                                   ->get())
      ->with('candidateDetails', candidateDetails::where(function($contract) use ($contractType){
                                                                        $contract->where('contractTypePermanent', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTH', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTemporary', 'LIKE', $contractType);
                                                                    })

                                                 ->where(function($start) use ($startDate){
                                                      $start->where('availability', '<=', $startDate);
                                                   })

                                                 ->where(function($salary) use ($budget){
                                                      $salary->whereBetween('salaryExpectations', [0,$budget*1.05]);
                                                   })
                                                 ->where(function($occupation) use ($occupationRate){
                                                      $occupation->where('partTimeMin', '<=', $occupationRate);
                                                      $occupation->where('partTimeMax', '>=', $occupationRate);
                                                   })


                                                 ->where(function($permit) use ($visaSponsor){
                                                   if($visaSponsor == 'No'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                    }
                                                   if($visaSponsor == 'Yes'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                      $permit->orWhere('workPermit', 'LIKE', 'No');
                                                    }
                                                   })
                                                 ->get())

      ->with('companyInterviews', companyInterviews::where('company_vacancy',$vacancyId)->get())
      ->with('companyInterviewFeedback', companyInterviewFeedback::where('company_id_user',$company_id_user)->get());

    }
    else {
      return View::make('404',[
      ]);
    }

  }





// Partner routes

public function testPartnerFeedbackForm(Request $request){
  $grade = $request->user()->grade;

  if($grade == 3 || $grade == 4 || $grade == 5){
     return view('testPartnerFeedbackForm');
  }
}


public function partner_about(Request $request){
  $id_user = $request->user()->id;
  $about =  $request->input('about');
  DB::table('partnerDetails')->where('id_user',$id_user)->update( array('about' => $about) );

  return redirect()->back();
}

public function partnerInvitefriends(Request $request){
  $id_user = $request->user()->id;

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/invitefriends',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function partnerInvitecompany(Request $request){
  $id_user = $request->user()->id;

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/invitecompany',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }



}

public function partnerSettings(Request $request){
    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partnerDetails = DB::table('partnerDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 3){
      return View::make('partnerplatform/settings',[
        'partners'=>$partners,
        'partnerDetails'=>$partnerDetails,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }


}

public function partnerInterviews(Request $request){
    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partnerDetails = DB::table('partnerDetails')->where('id_user',$id_user)->first();

    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_user)->first();
    $adminIdUser = $adminInterviews->admin_id_user;
    $admin = DB::table('admin')->where('id_user',$adminIdUser)->first();

    $grade = $request->user()->grade;
    if($grade == 3){
      return View::make('partnerplatform/interviews',[
        'partners'=>$partners,
        'partnerDetails'=>$partnerDetails,
        'admin'=>$admin,
      ])->with('candidates', candidate::all())
        ->with('adminInterviews', adminInterviews::all()->where('partner_id_user',$id_user))
        ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user',$id_user))
        ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user',$id_user))
        ->with('partnerDocuments', partnerDocuments::all()->where('id_user',$id_user));
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function partnerDocuments(Request $request){
    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partnerDocuments = DB::table('partnerDocuments')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;
    if($grade == 3){
      return View::make('partnerplatform/documents',[
        'partners'=>$partners,
        ])->with('documents', partnerDocuments::all()->where('id_user',$id_user));
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function partner_document(Request $request){
    $id_user = $request->user()->id;
    $docType =  $request->input('docType');
    $company = $request->input('company');
    $diplomaGrade = $request->input('diplomaGrade');
    $school = $request->input('school');
    $others = $request->input('others');
    $docLanguage = $request->input('docLanguage');

    $file = request()->file('document');
    $docExt = $file->guessClientExtension();
    $file->storeAs('documents/' . auth()->id(), $docType.$others.$docLanguage.".".$docExt);
    $storage_path = 'app/documents/'.$id_user.'/'.$docType.$docLanguage;
    $fileName = $docType.$others.$docLanguage.".".$docExt;

    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partner_statut = $partners->partner_statut;

    if($docType == 'CV' && $partner_statut == '0'){
      DB::table('partners')->where('id_user',$id_user)->update( array(
        'partner_statut' => '1',
      ));

      Mail::send('email.partnerProfileReviewed',['partners' => $partners],function($mail) use ($partners) {
        $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Profile reviewed');
      });
    }

    DB::table('partnerDocuments')->where('id_user',$id_user)->insert( array(
      'id_user' => $id_user,
      'docType' => $docType,
      'company' => $company,
      'diplomaGrade' => $diplomaGrade,
      'school' => $school,
      'others' => $others,
      'docLanguage' => $docLanguage,
      'docExt' => $docExt,
      'storage_path' => $storage_path,
      'fileName' => $fileName,
    ));



    return back();

}


public function partner_adminInterviewTimes(Request $request){
  $id_user = $request->user()->id;
  $partners = DB::table('partners')->where('id_user',$id_user)->update( array(
    'partner_statut' => '6',
    ));


  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  DB::table('adminInterviews')->where('partner_id_user',$id_user)->update( array(
  'statut' => '3',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  ));

  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  Mail::send('email.partnerAskAdminNewTimes',['candidates' => $candidates],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Our partner recommended you!');
  });

return redirect()->back();

}


public function partner_confirmAdminInterview(Request $request){
    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->update( array(
    'partner_statut' => '7',
    ));

    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partnerIdUser = $partners->id_user;

    $dateTime =  $request->input('proposition');

    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }



    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_user)->update( array(
    'statut' => '4',
    'date' => $date,
    'time' => $time,
    ));

    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_user)->first();
    $adminInterviewsId = $adminInterviews->id;
    $adminIdUser = $adminInterviews->admin_id_user;
    $interviewDate = $adminInterviews->date;
    $interviewTime = $adminInterviews->time;

    $adminInterviewFeedback = new adminInterviewFeedback();
    $adminInterviewFeedback->adminInterviews_id = $adminInterviewsId;
    $adminInterviewFeedback->admin_id_user = $adminIdUser;
    $adminInterviewFeedback->partner_id_user = $partnerIdUser;
    $adminInterviewFeedback->partnerStatut = '1';
    $adminInterviewFeedback->adminStatut = '1';
    $adminInterviewFeedback->date = $interviewDate;
    $adminInterviewFeedback->time = $interviewTime;
    $adminInterviewFeedback->save();

    $partners = DB::table('partners')->where('id_user',$id_user)->first();

    Mail::send('email.partnerConfirmAdminInterview',['partners' => $partners],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview confirmed!');
    });


    return redirect()->back();
}


public function partner_candidateInterviewFeedback(Request $request){
  $id_user = $request->user()->id;
  $candidate_id_user =  $request->input('candidate_id_user');

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('partner_id_user',$id_user)
                                                                   ->where('candidate_id_user',$candidate_id_user)
                                                                   ->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/itwcandidatefeedback',[
      'candidates'=>$candidates,
      'partners'=>$partners,
      'partnerInterviewFeedback'=>$partnerInterviewFeedback,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function partner_interviewCandidateFeedback(Request $request){
  $id_user = $request->user()->id;
  $candidate_id_user =  $request->input('candidate_id_user');


  $partnerExperienceCandidate = Input::get('partnerExperienceCandidate');
  $partnerCandidatePresentation = Input::get('partnerCandidatePresentation');
  $partnerCandidateCommunication = Input::get('partnerCandidateCommunication');

  $language1 = Input::get('language1');
  $language1Level = Input::get('language1Level');
  $language1Statut = Input::get('language1Statut');
  $lang1 = $language1 . '/£' . $language1Level . '/€' . $language1Statut;

  $language2 = Input::get('language2');
  $language2Level = Input::get('language2Level');
  $language2Statut = Input::get('language2Statut');
  $lang2 = $language2 . '/£' . $language2Level . '/€' . $language2Statut;

  $language3 = Input::get('language3');
  $language3Level = Input::get('language3Level');
  $language3Statut = Input::get('language3Statut');
  $lang3 = $language3 . '/£' . $language3Level . '/€' . $language3Statut;

  $language4 = Input::get('language4');
  $language4Level = Input::get('language4Level');
  $language4Statut = Input::get('language4Statut');
  $lang4 = $language4 . '/£' . $language4Level . '/€' . $language4Statut;

  $IT1 = Input::get('IT1');
  $IT1Usage = Input::get('IT1Usage');
  $IT_1 = $IT1 . '/£' . $IT1Usage;

  $IT2 = Input::get('IT2');
  $IT2Usage = Input::get('IT2Usage');
  $IT_2 = $IT2 . '/£' . $IT2Usage;

  $IT3 = Input::get('IT3');
  $IT3Usage = Input::get('IT3Usage');
  $IT_3 = $IT3 . '/£' . $IT3Usage;

  $IT4 = Input::get('IT4');
  $IT4Usage = Input::get('IT4Usage');
  $IT_4 = $IT4 . '/£' . $IT4Usage;

  $IT5 = Input::get('IT5');
  $IT5Usage = Input::get('IT5Usage');
  $IT_5 = $IT5 . '/£' . $IT5Usage;

  $recommendation = Input::get('recommendation');
  $reasonNoRecommendation = Input::get('reasonNoRecommendation');
  $Reason_Personality = Input::get('Reason_Personality');
  $department = Input::get('department');


  $functionAccountsPayable = Input::get('functionAccountsPayable');
  $Reason_AccountsPayable = Input::get('Reason_AccountsPayable');
  $seniorityLevelAccountsPayable = Input::get('seniorityLevelAccountsPayable');
  if($functionAccountsPayable === 'Accounts Payable'){
    $companyTypeAccountsPayable = implode("",Input::get('companyTypeAccountsPayable'));
    $AccountsPayable = $functionAccountsPayable . '/£' . $seniorityLevelAccountsPayable . '/€' . $Reason_AccountsPayable . '/$' . $companyTypeAccountsPayable;
  } else {
    $AccountsPayable = $functionAccountsPayable . '/£' . $seniorityLevelAccountsPayable . '/€' . $Reason_AccountsPayable . '/$' ;
  }

  $functionAccountsReceivable = Input::get('functionAccountsReceivable');
  $Reason_AccountsReceivable = Input::get('Reason_AccountsReceivable');
  $seniorityLevelAccountsReceivable = Input::get('seniorityLevelAccountsReceivable');
  if($functionAccountsReceivable === 'Accounts Receivable - Billing specialist'){
    $companyTypeAccountsReceivable = implode("",Input::get('companyTypeAccountsReceivable'));
    $AccountsReceivable = $functionAccountsReceivable . '/£' . $seniorityLevelAccountsReceivable . '/€' . $Reason_AccountsReceivable . '/$' . $companyTypeAccountsReceivable;
  } else {
    $AccountsReceivable = $functionAccountsReceivable . '/£' . $seniorityLevelAccountsReceivable . '/€' . $Reason_AccountsReceivable . '/$';
  }

  $functionGeneralLedger = Input::get('functionGeneralLedger');
  $Reason_GeneralLedger = Input::get('Reason_GeneralLedger');
  $seniorityLevelGeneralLedger = Input::get('seniorityLevelGeneralLedger');
  if($functionGeneralLedger === 'General Ledger'){
    $companyTypeGeneralLedger = implode("",Input::get('companyTypeGeneralLedger'));
    $GeneralLedger = $functionGeneralLedger . '/£' . $seniorityLevelGeneralLedger . '/€' . $Reason_GeneralLedger . '/$' . $companyTypeGeneralLedger;
  } else {
    $GeneralLedger = $functionGeneralLedger . '/£' . $seniorityLevelGeneralLedger . '/€' . $Reason_GeneralLedger . '/$';
  }

  $functionPayrollSpecialist = Input::get('functionPayrollSpecialist');
  $Reason_PayrollSpecialist = Input::get('Reason_PayrollSpecialist');
  $seniorityLevelPayrollSpecialist = Input::get('seniorityLevelPayrollSpecialist');
  if($functionPayrollSpecialist === 'Payroll Specialist'){
    $companyTypePayrollSpecialist = implode("",Input::get('companyTypePayrollSpecialist'));
    $PayrollSpecialist = $functionPayrollSpecialist . '/£' . $seniorityLevelPayrollSpecialist . '/€' . $Reason_PayrollSpecialist . '/$' . $companyTypePayrollSpecialist;
  } else {
    $PayrollSpecialist = $functionPayrollSpecialist . '/£' . $seniorityLevelPayrollSpecialist . '/€' . $Reason_PayrollSpecialist . '/$' ;
  }

  $functionCreditAnalyst = Input::get('functionCreditAnalyst');
  $Reason_CreditAnalyst = Input::get('Reason_CreditAnalyst');
  $seniorityLevelCreditAnalyst = Input::get('seniorityLevelCreditAnalyst');
  if($functionCreditAnalyst === 'Credit Analyst'){
    $companyTypeCreditAnalyst = implode("",Input::get('companyTypeCreditAnalyst'));
    $CreditAnalyst = $functionCreditAnalyst . '/£' . $seniorityLevelCreditAnalyst . '/€' . $Reason_CreditAnalyst . '/$' . $companyTypeCreditAnalyst;
  } else {
    $CreditAnalyst = $functionCreditAnalyst . '/£' . $seniorityLevelCreditAnalyst . '/€' . $Reason_CreditAnalyst . '/$' ;
  }

  $functionInternalAudit = Input::get('functionInternalAudit');
  $Reason_InternalAudit = Input::get('Reason_InternalAudit');
  $seniorityLevelInternalAudit = Input::get('seniorityLevelInternalAudit');
  if($functionInternalAudit === 'Internal Audit'){
    $companyTypeInternalAudit = implode("",Input::get('companyTypeInternalAudit'));
    $InternalAudit = $functionInternalAudit . '/£' . $seniorityLevelInternalAudit . '/€' . $Reason_InternalAudit . '/$' . $companyTypeInternalAudit;
  } else {
    $InternalAudit = $functionInternalAudit . '/£' . $seniorityLevelInternalAudit . '/€' . $Reason_InternalAudit . '/$';
  }

  $functionExternalAudit = Input::get('functionExternalAudit');
  $Reason_ExternalAudit = Input::get('Reason_ExternalAudit');
  $seniorityLevelExternalAudit = Input::get('seniorityLevelExternalAudit');
  if($functionExternalAudit === 'External Audit'){
    $companyTypeExternalAudit = implode("",Input::get('companyTypeExternalAudit'));
    $ExternalAudit = $functionExternalAudit . '/£' . $seniorityLevelExternalAudit . '/€' . $Reason_ExternalAudit . '/$' . $companyTypeExternalAudit;
  } else {
    $ExternalAudit = $functionExternalAudit . '/£' . $seniorityLevelExternalAudit . '/€' . $Reason_ExternalAudit . '/$' ;
  }

  $functionAccounting = $AccountsPayable . ',' . $AccountsReceivable . ',' . $GeneralLedger . ',' . $PayrollSpecialist . ',' . $CreditAnalyst . ',' . $InternalAudit . ',' . $ExternalAudit;


  $functionFinancialController = Input::get('functionFinancialController');
  $Reason_FinancialController = Input::get('Reason_FinancialController');
  $seniorityLevelFinancialController = Input::get('seniorityLevelFinancialController');
  if($functionFinancialController === 'Financial Controller'){
    $companyTypeFinancialController = implode("",Input::get('companyTypeFinancialController'));
    $FinancialController = $functionFinancialController . '/£' . $seniorityLevelFinancialController . '/€' . $Reason_FinancialController . '/$' . $companyTypeFinancialController;
  } else {
    $FinancialController = $functionFinancialController . '/£' . $seniorityLevelFinancialController . '/€' . $Reason_FinancialController . '/$';
  }

  $functionIndustrialController = Input::get('functionIndustrialController');
  $Reason_IndustrialController = Input::get('Reason_IndustrialController');
  $seniorityLevelIndustrialController = Input::get('seniorityLevelIndustrialController');
  if($functionIndustrialController === 'Industrial Controller'){
    $companyTypeIndustrialController = implode("",Input::get('companyTypeIndustrialController'));
    $IndustrialController = $functionIndustrialController . '/£' . $seniorityLevelIndustrialController . '/€' . $Reason_IndustrialController . '/$' . $companyTypeIndustrialController;
  } else {
    $IndustrialController = $functionIndustrialController . '/£' . $seniorityLevelIndustrialController . '/€' . $Reason_IndustrialController . '/$';
  }

  $functionAnalystFPA = Input::get('functionAnalystFPA');
  $Reason_AnalystFPA = Input::get('Reason_AnalystFPA');
  $seniorityLevelAnalystFPA = Input::get('seniorityLevelAnalystFPA');
  if($functionAnalystFPA === 'Analyst - FP&A'){
    $companyTypeAnalystFPA = implode("",Input::get('companyTypeAnalystFPA'));
    $AnalystFPA = $functionAnalystFPA . '/£' . $seniorityLevelAnalystFPA . '/€' . $Reason_AnalystFPA . '/$' . $companyTypeAnalystFPA;
  } else {
    $AnalystFPA = $functionAnalystFPA . '/£' . $seniorityLevelAnalystFPA . '/€' . $Reason_AnalystFPA . '/$';
  }

  $functionConsolidationReporting = Input::get('functionConsolidationReporting');
  $Reason_ConsolidationReporting = Input::get('Reason_ConsolidationReporting');
  $seniorityLevelConsolidation = Input::get('seniorityLevelConsolidation');
  if($functionConsolidationReporting === 'Consolidation - Reporting'){
    $companyTypeConsolidation = implode("",Input::get('companyTypeConsolidation'));
    $ConsolidationReporting = $functionConsolidationReporting . '/£' . $seniorityLevelConsolidation . '/€' . $Reason_ConsolidationReporting . '/$' . $companyTypeConsolidation;
  } else {
    $ConsolidationReporting = $functionConsolidationReporting . '/£' . $seniorityLevelConsolidation . '/€' . $Reason_ConsolidationReporting . '/$';
  }

  $functionFC = $FinancialController . ',' . $IndustrialController . ',' . $AnalystFPA . ',' . $ConsolidationReporting;

  $functionVATAccountant = Input::get('functionVATAccountant');
  $Reason_VATAccountant = Input::get('Reason_VATAccountant');
  $seniorityLevelVATAccountant = Input::get('seniorityLevelVATAccountant');
  if($functionVATAccountant === 'VAT Accountant'){
    $companyTypeVATAccountant = implode("",Input::get('companyTypeVATAccountant'));
    $VATAccountant = $functionVATAccountant . '/£' . $seniorityLevelVATAccountant . '/€' . $Reason_VATAccountant . '/$' . $companyTypeVATAccountant;
  } else {
    $VATAccountant = $functionVATAccountant . '/£' . $seniorityLevelVATAccountant . '/€' . $Reason_VATAccountant . '/$' ;
  }

  $functionTaxAnalyst = Input::get('functionTaxAnalyst');
  $Reason_TaxAnalyst = Input::get('Reason_TaxAnalyst');
  $seniorityLevelTaxAnalyst = Input::get('seniorityLevelTaxAnalyst');
  if($functionTaxAnalyst === 'Tax Analyst'){
    $companyTypeTaxAnalyst = implode("",Input::get('companyTypeTaxAnalyst'));
    $TaxAnalyst = $functionTaxAnalyst . '/£' . $seniorityLevelTaxAnalyst . '/€' . $Reason_TaxAnalyst . '/$' . $companyTypeTaxAnalyst;
  } else {
    $TaxAnalyst = $functionTaxAnalyst . '/£' . $seniorityLevelTaxAnalyst . '/€' . $Reason_TaxAnalyst . '/$';
  }

  $functionTreasuryAnalyst = Input::get('functionTreasuryAnalyst');
  $Reason_TreasuryAnalyst = Input::get('Reason_TreasuryAnalyst');
  $seniorityLevelTreasuryAnalyst = Input::get('seniorityLevelTreasuryAnalyst');
  if($functionTreasuryAnalyst === 'Treasury Analyst'){
    $companyTypeTreasuryAnalyst = implode("",Input::get('companyTypeTreasuryAnalyst'));
    $TreasuryAnalyst = $functionTreasuryAnalyst . '/£' . $seniorityLevelTreasuryAnalyst . '/€' . $Reason_TreasuryAnalyst . '/$' . $companyTypeTreasuryAnalyst;
  } else {
    $TreasuryAnalyst = $functionTreasuryAnalyst . '/£' . $seniorityLevelTreasuryAnalyst . '/€' . $Reason_TreasuryAnalyst . '/$';
  }

  $functionTaxTreasury = $VATAccountant . ',' . $TaxAnalyst . ',' . $TreasuryAnalyst;



  $function = $functionAccounting . ',' . $functionFC . ',' . $functionTaxTreasury;


  $otherFunction = Input::get('otherFunction');


  $commentsForTheCandidate = Input::get('commentsForTheCandidate');
  $otherComments = Input::get('otherComments');

  if($recommendation === 'Yes'){
    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
        'interviewStatut' => '10',
        'lastActiveJobSearchEmail' => new DateTime('now'),
        ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
    $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidate_id_user)->first();
    $sharelink = $candidateInfos->shareLink;

    Mail::send('email.candidatePartnerFeedbackRecommended',['candidates' => $candidates, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Our partner recommended you!');
    });
  }

  if($recommendation === 'No'){
    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
        'interviewStatut' => '9',
        'lastActiveJobSearchEmail' => new DateTime('now'),
        ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();

    Mail::send('email.candidatePartnerFeedbackNotRecommended',['candidates' => $candidates],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Partner interview feedback');
    });
  }

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$id_user)->update( array(
  'partnerStatut' => '2',
  'partnerExperienceCandidate' => $partnerExperienceCandidate,
  'partnerCandidatePresentation' => $partnerCandidatePresentation,
  'partnerCandidateCommunication' => $partnerCandidateCommunication,
  'languageSkills' => $lang1 . ',' . $lang2 . ',' . $lang3 . ',' . $lang4 . ',',
  'ITSkills' => $IT_1 . ',' . $IT_2 . ',' . $IT_3 . ',' . $IT_4 . ',' . $IT_5 . ',',
  'recommendation' => $recommendation,
  'reasonNoRecommendation' => $reasonNoRecommendation,
  'Reason_Personality' => $Reason_Personality,
  'department' => $department,
  'function' => $function,
  'otherFunction' => $otherFunction,
  'commentsForTheCandidate' => $commentsForTheCandidate,
  'otherComments' => $otherComments,
  ));


  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$id_user)->update( array(
  'statut' => '5'
  ));

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$id_user)
                                                                   ->first();

  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();

  Mail::send('email.partnerFeedbackGiven',['partners' => $partners, 'candidates' => $candidates, 'partnerInterviewFeedback' => $partnerInterviewFeedback],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview feedback given by partner!');
  });


  $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/feedbackSent',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}





public function partnerCandidates(Request $request){
    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $partnerUserId = $partners->id_user;
    $partnerDetails = DB::table('partnerDetails')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;
    if($grade == 3){
      return View::make('partnerplatform/candidates',[
        'partners'=>$partners,
        'partnerDetails'=>$partnerDetails,
      ])->with('candidates', candidate::all())
        ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user',$partnerUserId))
        ->with('partnerDocuments', partnerDocuments::all()->where('id_user',$id_user));
    }
    else {
      return View::make('404',[
      ]);
    }
}


public function partnerSeeCandidates(Request $request){
  $candidate_id = Input::get('candidate_id');
  $id_user = $request->user()->id;

  $candidates = DB::table('candidates')->where('id',$candidate_id)->first();
  $id_userCandidate = $candidates->id_user;
  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_userCandidate)->first();
  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$id_userCandidate)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/candidateDetails',[
      'partners'=>$partners,
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'partnerInterviews'=>$partnerInterviews,
    ])->with('documents', candidateDocuments::all()->where('id_user',$id_userCandidate));
  }
  else {
    return View::make('404',[
    ]);
  }



}


public function partner_notAvailableInterview(Request $request){
  $candidateIdUser = Input::get('candidate_id_user');
  $partnerIdUser = Input::get('partner_id_user');

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '11',
    ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();




  DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)
                                ->where('partner_id_user',$partnerIdUser)->update( array(
  'statut' => '13',
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/notAvailableInterview',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function partner_interviewTimes(Request $request){
  $candidateIdUser = Input::get('candidate_id_user');
  $partnerIdUser = Input::get('partner_id_user');
  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '4',
    ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');

  DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)
                                ->where('partner_id_user',$partnerIdUser)->update( array(
  'statut' => '2',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  'updated_at' => new DateTime('now'),
  ));

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $sharelink = $candidateInfos->shareLink;


    Mail::send('email.candidatePartnerAskInterview',['candidates' => $candidates, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Partner interview');
    });

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();

  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/confirmInterview',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function partner_postponeInterviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidateIdUser = Input::get('candidate_id_user');

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '4',
    ));

  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');
  $postponeMessage = Input::get('postponeMessage');

  DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)
                                ->where('partner_id_user',$id_user)
                                ->update( array(
  'statut' => '2',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  'postponeMessage' => $postponeMessage,
  ));


  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

  Mail::send('email.candidatePartnerPostponeNewTimesProposed',['candidates' => $candidates, 'postponeMessage' => $postponeMessage],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Interview postponed!');
  });

  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  Mail::send('email.adminPartnerPostponeInterviewCandidate',['partners' => $partners, 'candidates' => $candidates, 'postponeMessage' => $postponeMessage],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview postponed!');
  });

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $grade = $request->user()->grade;
  if($grade == 3){
    return View::make('partnerplatform/faq',[
      'partners'=>$partners,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function partner_cancelInterviewTimes(Request $request){
  $id_user = $request->user()->id;
  $candidateIdUser = Input::get('candidate_id_user');

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '11',
    ));

  $cancelMessage = Input::get('cancelMessage');

  DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)
                                ->where('partner_id_user',$id_user)
                                ->update( array(
  'statut' => '21',
  'postponeMessage' => $cancelMessage,
  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

  Mail::send('email.candidatePartnerCancelInterview',['candidates' => $candidates, 'cancelMessage' => $cancelMessage],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Interview cancelled!');
  });

  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  Mail::send('email.adminPartnerCancelInterviewCandidate',['partners' => $partners, 'candidates' => $candidates, 'cancelMessage' => $cancelMessage],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview cancelled!');
  });

  $partners = DB::table('partners')->where('id_user',$id_user)->first();

  $grade = $request->user()->grade;

  if($grade == 3){
    return View::make('partnerplatform/faq',[
      'partners'=>$partners,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function partner_confirmCandidateInterview(Request $request){
    $id_user = $request->user()->id;

    $candidateIdUser = $request->input('candidate_id_user');
    $dateTime =  $request->input('proposition');

    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }

    $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)->update( array(
    'statut' => '4',
    'date' => $date,
    'time' => $time,
    ));



    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'interviewStatut' => '6',
    ));

    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
    $skypeCandidate = $candidates->candidate_skype;

    $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
    $sharelink = $candidateInfos->shareLink;

    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $skypePartner = $partners->partner_skype;

    $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidateIdUser)->first();
    $partnerInterviewsId = $partnerInterviews->id;
    $partnerIdUser = $partnerInterviews->partner_id_user;
    $interviewDate = $partnerInterviews->date;
    $interviewTime = $partnerInterviews->time;


    Mail::send('email.partnerConfirmCandidateInterview',['partners' => $partners, 'candidates'=>$candidates, 'interviewDate'=>$interviewDate, 'interviewTime'=>$interviewTime, 'skypeCandidate'=>$skypeCandidate],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });

    Mail::send('email.candidatePartnerConfirmInterview',['candidates' => $candidates, 'partners' => $partners, 'interviewDate'=>$interviewDate, 'interviewTime'=>$interviewTime, 'skypePartner'=>$skypePartner, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
      $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });



    $partnerInterviewFeedback = new partnerInterviewFeedback();
    $partnerInterviewFeedback->partnerInterviews_id = $partnerInterviewsId;
    $partnerInterviewFeedback->partner_id_user = $partnerIdUser;
    $partnerInterviewFeedback->candidate_id_user = $candidateIdUser;
    $partnerInterviewFeedback->candidateStatut = '1';
    $partnerInterviewFeedback->partnerStatut = '1';
    $partnerInterviewFeedback->date = $interviewDate;
    $partnerInterviewFeedback->time = $interviewTime;
    $partnerInterviewFeedback->save();

    $partners = DB::table('partners')->where('id_user',$id_user)->first();
    $grade = $request->user()->grade;

    if($grade == 3){
      return View::make('partnerplatform/faq',[
        'partners'=>$partners,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function partner_candidateDidNotShowUp(Request $request){
  $id_user = $request->user()->id;
  $candidate_id_user =  $request->input('candidate_id_user');

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidate_id_user)
                                                     ->where('partner_id_user',$id_user)
                                                     ->update( array(
  'statut' => '7',
  ));

  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidate_id_user)
                                                     ->where('partner_id_user',$id_user)
                                                     ->first();


  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
  'interviewStatut' => '16',
  ));


  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();

  Mail::send('email.candidateDidNotShowUp',['candidates' => $candidates, 'partners'=>$partners],function($mail) use ($partners) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject("Candidate didn't show up on interview");
  });

  $grade = $request->user()->grade;

  if($grade == 3){
    return View::make('partnerplatform/candidateNoShowConfirmation',[
      'partners'=>$partners,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function partnerFaq(Request $request){

    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;

    if($grade == 3){
      return View::make('partnerplatform/faq',[
        'partners'=>$partners,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function partnerFeedback(Request $request){

    $id_user = $request->user()->id;
    $partners = DB::table('partners')->where('id_user',$id_user)->first();

    $grade = $request->user()->grade;

    if($grade == 3){
      return View::make('partnerplatform/feedback',[
        'partners'=>$partners,
      ]);
    }
    else {
      return View::make('404',[
      ]);
    }

}

public function partner_feedbackTieTalent(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $feedbackTieTalentRating =  $request->input('feedbackTieTalentRating');
  $feedbackTieTalentText =  $request->input('feedbackTieTalentText');

  DB::table('partnerInfos')->where('id_user',$id_user)->update( array(
    'feedbackTieTalentRating' => $feedbackTieTalentRating,
    'feedbackTieTalentText' => $feedbackTieTalentText,
  ) );

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_user)->first();

  Mail::send('email.feedbackTieTalentPartner',['user' => $user, 'partners' => $partners, 'partnerInfos' => $partnerInfos,],function($mail) use ($user) {
    $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Partner feedback on TieTalent');
  });
  $grade = $request->user()->grade;

  if($grade == 3){
    return View::make('partnerplatform/feedbackSent',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }

}

public function partner_inviteFriends(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailFriendsContent =  $request->input('emailFriendsContent');
  $inviteFirstName1 =  $request->input('inviteFirstName1');
  $inviteEmail1 =  $request->input('inviteEmail1');
  $inviteFirstName2 =  $request->input('inviteFirstName2');
  $inviteEmail2 =  $request->input('inviteEmail2');
  $inviteFirstName3 =  $request->input('inviteFirstName3');
  $inviteEmail3 =  $request->input('inviteEmail3');
  $inviteFirstName4 =  $request->input('inviteFirstName4');
  $inviteEmail4 =  $request->input('inviteEmail4');
  $inviteFirstName5 =  $request->input('inviteFirstName5');
  $inviteEmail5 =  $request->input('inviteEmail5');
  $inviteFirstName6 =  $request->input('inviteFirstName6');
  $inviteEmail6 =  $request->input('inviteEmail6');
  $inviteFirstName7 =  $request->input('inviteFirstName7');
  $inviteEmail7 =  $request->input('inviteEmail7');
  $inviteFirstName8 =  $request->input('inviteFirstName8');
  $inviteEmail8 =  $request->input('inviteEmail8');
  $inviteFirstName9 =  $request->input('inviteFirstName9');
  $inviteEmail9 =  $request->input('inviteEmail9');


  DB::table('partnerInviteFriends')->where('id_user',$id_user)->update( array(
    'emailFriendsContent' => $emailFriendsContent,
    'inviteFirstName1' => $inviteFirstName1,
    'inviteEmail1' => $inviteEmail1,
    'inviteFirstName2' => $inviteFirstName2,
    'inviteEmail2' => $inviteEmail2,
    'inviteFirstName3' => $inviteFirstName3,
    'inviteEmail3' => $inviteEmail3,
    'inviteFirstName4' => $inviteFirstName4,
    'inviteEmail4' => $inviteEmail4,
    'inviteFirstName5' => $inviteFirstName5,
    'inviteEmail5' => $inviteEmail5,
    'inviteFirstName6' => $inviteFirstName6,
    'inviteEmail6' => $inviteEmail6,
    'inviteFirstName7' => $inviteFirstName7,
    'inviteEmail7' => $inviteEmail7,
    'inviteFirstName8' => $inviteFirstName8,
    'inviteEmail8' => $inviteEmail8,
    'inviteFirstName9' => $inviteFirstName9,
    'inviteEmail9' => $inviteEmail9,

  ) );

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $partnerInviteFriends = DB::table('partnerInviteFriends')->where('id_user',$id_user)->first();

  if($inviteFirstName1 != '' && $inviteEmail1 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail2 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail3 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail4 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail5 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail6 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail7 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail8 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteEmail9 != ''){
    Mail::send('email.inviteFriends',['user' => $user, 'partners' => $partners, 'partnerInviteFriends' => $partnerInviteFriends],function($mail) use ($partnerInviteFriends) {
      $mail->to($partnerInviteFriends->inviteEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }


  return redirect()->back();

}

public function partner_inviteCompany(Request $request){
  $user = $request->user();
  $id_user = $request->user()->id;
  $emailCompanyContent =  $request->input('emailCompanyContent');
  $inviteCompanyFirstName1 =  $request->input('inviteCompanyFirstName1');
  $inviteCompanyEmail1 =  $request->input('inviteCompanyEmail1');
  $inviteCompanyFirstName2 =  $request->input('inviteCompanyFirstName2');
  $inviteCompanyEmail2 =  $request->input('inviteCompanyEmail2');
  $inviteCompanyFirstName3 =  $request->input('inviteCompanyFirstName3');
  $inviteCompanyEmail3 =  $request->input('inviteCompanyEmail3');
  $inviteCompanyFirstName4 =  $request->input('inviteCompanyFirstName4');
  $inviteCompanyEmail4 =  $request->input('inviteCompanyEmail4');
  $inviteCompanyFirstName5 =  $request->input('inviteCompanyFirstName5');
  $inviteCompanyEmail5 =  $request->input('inviteCompanyEmail5');
  $inviteCompanyFirstName6 =  $request->input('inviteCompanyFirstName6');
  $inviteCompanyEmail6 =  $request->input('inviteCompanyEmail6');
  $inviteCompanyFirstName7 =  $request->input('inviteCompanyFirstName7');
  $inviteCompanyEmail7 =  $request->input('inviteCompanyEmail7');
  $inviteCompanyFirstName8 =  $request->input('inviteCompanyFirstName8');
  $inviteCompanyEmail8 =  $request->input('inviteCompanyEmail8');
  $inviteCompanyFirstName9 =  $request->input('inviteCompanyFirstName9');
  $inviteCompanyEmail9 =  $request->input('inviteCompanyEmail9');


  DB::table('partnerInviteCompany')->where('id_user',$id_user)->update( array(
    'emailCompanyContent' => $emailCompanyContent,
    'inviteCompanyFirstName1' => $inviteCompanyFirstName1,
    'inviteCompanyEmail1' => $inviteCompanyEmail1,
    'inviteCompanyFirstName2' => $inviteCompanyFirstName2,
    'inviteCompanyEmail2' => $inviteCompanyEmail2,
    'inviteCompanyFirstName3' => $inviteCompanyFirstName3,
    'inviteCompanyEmail3' => $inviteCompanyEmail3,
    'inviteCompanyFirstName4' => $inviteCompanyFirstName4,
    'inviteCompanyEmail4' => $inviteCompanyEmail4,
    'inviteCompanyFirstName5' => $inviteCompanyFirstName5,
    'inviteCompanyEmail5' => $inviteCompanyEmail5,
    'inviteCompanyFirstName6' => $inviteCompanyFirstName6,
    'inviteCompanyEmail6' => $inviteCompanyEmail6,
    'inviteCompanyFirstName7' => $inviteCompanyFirstName7,
    'inviteCompanyEmail7' => $inviteCompanyEmail7,
    'inviteCompanyFirstName8' => $inviteCompanyFirstName8,
    'inviteCompanyEmail8' => $inviteCompanyEmail8,
    'inviteCompanyFirstName9' => $inviteCompanyFirstName9,
    'inviteCompanyEmail9' => $inviteCompanyEmail9,

  ) );

  $partners = DB::table('partners')->where('id_user',$id_user)->first();
  $partnerInviteCompany = DB::table('partnerInviteCompany')->where('id_user',$id_user)->first();


  if($inviteCompanyFirstName1 != '' && $inviteCompanyEmail1 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail1)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail2 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail2)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail3 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail3)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail4 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail4)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail5 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail5)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail6 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail6)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail7 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail7)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail8 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail8)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }

  if($inviteCompanyEmail9 != ''){
    Mail::send('email.inviteCompany',['user' => $user, 'partners' => $partners, 'partnerInviteCompany' => $partnerInviteCompany],function($mail) use ($partnerInviteCompany) {
      $mail->to($partnerInviteCompany->inviteCompanyEmail9)->from('no-reply@tietalent.com')->subject('Recommendation to register to TieTalent');
    });
  }


  return redirect()->back();
}


public function partner_communication(Request $request){
  $id_user = $request->user()->id;
  $communication =  $request->input('communication');
  DB::table('partners')->where('id_user',$id_user)->update( array('communication' => $communication) );

  return redirect()->back();
}

public function partner_email(Request $request){
  $id_user = $request->user()->id;
  $partner_email =  $request->input('partner_email');
  $partner_email2 =  $request->input('partner_email2');
  $partner_email3 =  $request->input('partner_email3');
  DB::table('users')->where('id',$id_user)->update( array(
    'email' => $partner_email,
  ) );
  DB::table('partners')->where('id_user',$id_user)->update( array(
    'partner_email' => $partner_email,
    'partner_email2' => $partner_email2,
    'partner_email3' => $partner_email3,
  ) );

  return redirect()->back();
}

public function partner_phone(Request $request){
  $id_user = $request->user()->id;
  $partner_phone =  $request->input('partner_phone');
  $partner_phone2 =  $request->input('partner_phone2');
  $partner_phone3 =  $request->input('partner_phone3');
  DB::table('partners')->where('id_user',$id_user)->update( array(
    'partner_phone' => $partner_phone,
    'partner_phone2' => $partner_phone2,
    'partner_phone3' => $partner_phone3,
  ) );

  return redirect()->back();
}

public function partner_skype(Request $request){
  $id_user = $request->user()->id;
  $partner_skype =  $request->input('partner_skype');

  DB::table('partners')->where('id_user',$id_user)->update( array(
    'partner_skype' => $partner_skype,

  ) );

  return redirect()->back();
}

public function partner_password(Request $request){
  $id = $request->user()->id;
  $password =  $request->input('password');
  $password_confirm =  $request->input('password_confirm');

  if($password == $password_confirm){

    DB::table('users')->where('id',$id)->update( array(
      'password' => bcrypt($password),
    ) );

    return redirect()->back();
  }

}

public function partner_general(Request $request){
  $id_user = $request->user()->id;
  $firstName =  $request->input('firstName');
  $lastName =  $request->input('lastName');
  $address =  $request->input('address');

  DB::table('partners')->where('id_user',$id_user)->update( array(
    'firstName' => $firstName,
    'lastName' => $lastName,
  ) );

  DB::table('partnerDetails')->where('id_user',$id_user)->update( array(
    'address' => $address,
  ) );


    return redirect()->back();

}

public function partner_profilePicture(Request $request){

  $id_user = $request->user()->id;

  if($request->hasFile('avatar')){
    $avatar = $request->file('avatar');
    $filename = time() . '.'. $avatar->getClientOriginalExtension();
    Image::make($avatar)->resize(300,300)->save(public_path('uploads/avatars/'.$filename));

    DB::table('partners')->where('id_user',$id_user)->update( array(
    'avatar' => $filename,
  ));
}

    return back();

}




// Admin platform

public function adminSeeCandidates(Request $request){

  $candidate_id = Input::get('candidate_id');

  $candidates = DB::table('candidates')->where('id',$candidate_id)->first();
  $id_userCandidate = $candidates->id_user;
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$id_userCandidate)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$id_userCandidate)->first();

  $grade = $request->user()->grade;

  if($grade == 4){

  return View::make('adminplatform/seeCandidates',[
    'candidates'=>$candidates,
    'candidateDetails'=>$candidateDetails,
    'candidateInfos'=>$candidateInfos,
  ])->with('documents', candidateDocuments::all()->where('id_user',$id_userCandidate))
    ->with('candidatesAll', candidate::all())
    ->with('candidateReferences', candidateReferences::all()->where('id_user',$id_userCandidate))
    ->with('companiesAll', company::all())
    ->with('partnersAll', partner::all())
    ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$id_userCandidate));
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminCandidateCRMNotes(Request $request){

  $candidateIdUser = Input::get('candidateIdUser');
  $candidateNotes = Input::get('candidateNotes');

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->update( array(
    'candidateNotes' => $candidateNotes,
  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seeCandidates',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'candidateInfos'=>$candidateInfos,
    ])->with('documents', candidateDocuments::all()->where('id_user',$candidateIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$candidateIdUser))
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$candidateIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function adminCandidateAboutYou(Request $request){

  $candidateIdUser = Input::get('candidateIdUser');
  $aboutYou = Input::get('aboutYou');

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->update( array(
    'aboutYou' => $aboutYou,
  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seeCandidates',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'candidateInfos'=>$candidateInfos,
    ])->with('documents', candidateDocuments::all()->where('id_user',$candidateIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$candidateIdUser))
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$candidateIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function adminCandidateDetails(Request $request){

  $candidateIdUser = Input::get('candidateIdUser');

  $firstName = Input::get('firstName');
  $lastName = Input::get('lastName');
  $address = Input::get('address');
  $candidate_email = Input::get('candidate_email');
  $reasonJobSearch = Input::get('reasonJobSearch');
  $skype = Input::get('skype');
  $linkedIn = Input::get('linkedIn');
  $shareLink = Input::get('shareLink');
  $mobility = Input::get('mobility');
  $availability = Input::get('availability');
  $salaryExpectations = Input::get('salaryExpectations');
  $workPermit = Input::get('workPermit');
  $car = Input::get('car');
  $communication = Input::get('communication');

  $interviewStatut = Input::get('interviewStatut');
  $opportunitiesStatut = Input::get('opportunitiesStatut');

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->update( array(
    'firstName' => $firstName,
    'lastName' => $lastName,
    'candidate_email' => $candidate_email,
    'candidate_skype' => $skype,
    'interviewStatut' => $interviewStatut,
    'opportunitiesStatut' => $opportunitiesStatut,
    'communication' => $communication,
    'lastActiveJobSearchEmail' => new DateTime('now'),
  ));

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->update( array(
    'address' => $address,
    'reasonJobSearch' => $reasonJobSearch,
    'linkedIn' => $linkedIn,
    'mobility' => $mobility,
    'availability' => $availability,
    'salaryExpectations' => $salaryExpectations,
    'workPermit' => $workPermit,
    'car' => $car,
  ));

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->update( array(
    'shareLink' => $shareLink,
  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seeCandidates',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'candidateInfos'=>$candidateInfos,
    ])->with('documents', candidateDocuments::all()->where('id_user',$candidateIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$candidateIdUser))
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$candidateIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminCandidateReferences(Request $request){

  $candidateIdUser = Input::get('candidateIdUser');

  $firstNameReference1 = Input::get('firstNameReference1');
  $lastNameReference1 = Input::get('lastNameReference1');
  $emailReference1 = Input::get('emailReference1');
  $positionReference1 = Input::get('positionReference1');
  $companyReference1 = Input::get('companyReference1');

  $firstNameReference2 = Input::get('firstNameReference2');
  $lastNameReference2 = Input::get('lastNameReference2');
  $emailReference2 = Input::get('emailReference2');
  $positionReference2 = Input::get('positionReference2');
  $companyReference2 = Input::get('companyReference2');

  $firstNameReference3 = Input::get('firstNameReference3');
  $lastNameReference3 = Input::get('lastNameReference3');
  $emailReference3 = Input::get('emailReference3');
  $positionReference3 = Input::get('positionReference3');
  $companyReference3 = Input::get('companyReference3');

  $firstNameReference4 = Input::get('firstNameReference4');
  $lastNameReference4 = Input::get('lastNameReference4');
  $emailReference4 = Input::get('emailReference4');
  $positionReference4 = Input::get('positionReference4');
  $companyReference4 = Input::get('companyReference4');

  $firstNameReference5 = Input::get('firstNameReference5');
  $lastNameReference5 = Input::get('lastNameReference5');
  $emailReference5 = Input::get('emailReference5');
  $positionReference5 = Input::get('positionReference5');
  $companyReference5 = Input::get('companyReference5');

  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->update( array(
    'firstNameReference1' => $firstNameReference1,
    'lastNameReference1' => $lastNameReference1,
    'emailReference1' => $emailReference1,
    'positionReference1' => $positionReference1,
    'companyReference1' => $companyReference1,
    'firstNameReference2' => $firstNameReference2,
    'lastNameReference2' => $lastNameReference2,
    'emailReference2' => $emailReference2,
    'positionReference2' => $positionReference2,
    'companyReference2' => $companyReference2,
    'firstNameReference3' => $firstNameReference3,
    'lastNameReference3' => $lastNameReference3,
    'emailReference3' => $emailReference3,
    'positionReference3' => $positionReference3,
    'companyReference3' => $companyReference3,
    'firstNameReference4' => $firstNameReference4,
    'lastNameReference4' => $lastNameReference4,
    'emailReference4' => $emailReference4,
    'positionReference4' => $positionReference4,
    'companyReference4' => $companyReference4,
    'firstNameReference5' => $firstNameReference5,
    'lastNameReference5' => $lastNameReference5,
    'emailReference5' => $emailReference5,
    'positionReference5' => $positionReference5,
    'companyReference5' => $companyReference5,

  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){

    return View::make('adminplatform/seeCandidates',[
      'candidates'=>$candidates,
      'candidateDetails'=>$candidateDetails,
      'candidateInfos'=>$candidateInfos,
    ])->with('documents', candidateDocuments::all()->where('id_user',$candidateIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('candidateReferences', candidateReferences::all()->where('id_user',$candidateIdUser))
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$candidateIdUser));
    }
    else {
      return View::make('404',[
      ]);
    }
  }


public function adminCandidateConfidentiality(Request $request){

  $candidateIdUser = Input::get('candidateIdUser');

  $confidentialityCompany1 = Input::get('confidentialityCompany1');
  $confidentialityCompany2 = Input::get('confidentialityCompany2');
  $confidentialityCompany3 = Input::get('confidentialityCompany3');
  $confidentialityCompany4 = Input::get('confidentialityCompany4');
  $confidentialityCompany5 = Input::get('confidentialityCompany5');
  $confidentialityCompany6 = Input::get('confidentialityCompany6');
  $confidentialityCompany7 = Input::get('confidentialityCompany7');
  $confidentialityCompany8 = Input::get('confidentialityCompany8');
  $confidentialityCompany9 = Input::get('confidentialityCompany9');


  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->update( array(
    'confidentialityCompany1' => $confidentialityCompany1,
    'confidentialityCompany2' => $confidentialityCompany2,
    'confidentialityCompany3' => $confidentialityCompany3,
    'confidentialityCompany4' => $confidentialityCompany4,
    'confidentialityCompany5' => $confidentialityCompany5,
    'confidentialityCompany6' => $confidentialityCompany6,
    'confidentialityCompany7' => $confidentialityCompany7,
    'confidentialityCompany8' => $confidentialityCompany8,
    'confidentialityCompany9' => $confidentialityCompany9,
  ));

  $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
  return View::make('adminplatform/seeCandidates',[
    'candidates'=>$candidates,
    'candidateDetails'=>$candidateDetails,
    'candidateInfos'=>$candidateInfos,
  ])->with('documents', candidateDocuments::all()->where('id_user',$candidateIdUser))
    ->with('candidatesAll', candidate::all())
    ->with('candidateReferences', candidateReferences::all()->where('id_user',$candidateIdUser))
    ->with('companiesAll', company::all())
    ->with('partnersAll', partner::all())
    ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('candidate_id_user',$candidateIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}





public function adminCandidateNotSelected(Request $request){
  $candidate_id = Input::get('candidate_id');
  $reasonNotValidated =  $request->input('reasonNotValidated');
  $otherDivisionMatch = $request->input('toKeepForDivision');


  if( $reasonNotValidated === 'noMatch') {

  $candidates = DB::table('candidates')->where('id',$candidate_id)->update( array(
  'interviewStatut' => '13',
));
  $candidates = DB::table('candidates')->where('id',$candidate_id)->first();
  Mail::send('email.candidateNoMatch',['candidates' => $candidates],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  });
}

  if( $reasonNotValidated === 'noDivision') {
  $candidates = DB::table('candidates')->where('id',$candidate_id)->update( array(
  'interviewStatut' => '14',
  'otherDivisionMatch' => $otherDivisionMatch,
));
  $candidates = DB::table('candidates')->where('id',$candidate_id)->first();
  Mail::send('email.candidateNoMatch',['candidates' => $candidates],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  });
  //Mail::send('email.candidateNoDivision',['candidates' => $candidates],function($mail) use ($candidates) {
  //  $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  //});
}


$grade = $request->user()->grade;

if($grade == 4){
  return View::make('adminplatform/informationSent',[

  ])->with('candidates', candidate::all())
    ->with('companies', company::all())
    ->with('partners', partner::all());
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function adminCandidateSelected(Request $request){
  $candidate_id = Input::get('candidate_id');

  $candidates = DB::table('candidates')->where('id',$candidate_id)->first();
  $candidatesIdUser = $candidates->id_user;
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidatesIdUser)->first();

  $partnerCompensation = Input::get('partnerCompensation');
  $division =  $request->input('divisionPartner');
  $department =  $request->input('department');
  $function =  $request->input('function');

  $grade = $request->user()->grade;

  if($grade == 4){

    return View::make('adminplatform/linkCandidateToPartner',[
      'candidates' => $candidates,
      'candidateDetails' => $candidateDetails,
      'partnerCompensation' => $partnerCompensation,
    ])->with('partnerDetails', partnerDetails::where('functionSpecialization', 'LIKE', '%'.$function.'%')->get())
      ->with('partners', partner::where('partner_statut', 10)->get())
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all());
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function adminCandidateInterviewFeedback(Request $request){
  $candidate_id_user =  $request->input('candidate_id_user');
  $partner_id_user =  $request->input('partner_id_user');
  $partnerCompensation =  $request->input('partnerCompensation');

  $interviewDate =  $request->input('datepicker1');
  $interviewTime =  $request->input('timepicker1');

  $partners = DB::table('partners')->where('id_user',$partner_id_user)->first();
  $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();


  if(DB::table('partnerInterviews')->where('partner_id_user',$partner_id_user)->where('candidate_id_user',$candidate_id_user)->first()){

    $partnerInterviews = DB::table('partnerInterviews')->where('partner_id_user',$partner_id_user)
                                                       ->where('candidate_id_user',$candidate_id_user)
                                                       ->update( array(
                                     'date' => $interviewDate,
                                     'time' => $interviewTime,
                                     'statut' => '5',
                                   ));

    $partnerInterviews = DB::table('partnerInterviews')->where('partner_id_user',$partner_id_user)
                                                       ->where('candidate_id_user',$candidate_id_user)
                                                       ->first();
      }

  else {
    $partnerInterviews = new partnerInterviews();
    $partnerInterviews->statut = '5';
    $partnerInterviews->partner_id_user = $partner_id_user;
    $partnerInterviews->candidate_id_user = $candidate_id_user;
    $partnerInterviews->date = $interviewDate;
    $partnerInterviews->time = $interviewTime;
    $partnerInterviews->partnerCompensation = $partnerCompensation;
    $partnerInterviews->save();
  }

if(DB::table('partnerInterviewFeedback')->where('partner_id_user',$partner_id_user)->where('candidate_id_user',$candidate_id_user)->first()){
  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('partner_id_user',$partner_id_user)
                                                                   ->where('candidate_id_user',$candidate_id_user)
                                                                   ->first();
}

else {
  $partnerInterviewFeedback = new partnerInterviewFeedback();
  $partnerInterviewFeedback->partnerInterviews_id = $partnerInterviews->id;
  $partnerInterviewFeedback->partner_id_user = $partner_id_user;
  $partnerInterviewFeedback->candidate_id_user = $candidate_id_user;
  $partnerInterviewFeedback->candidateStatut = '1';
  $partnerInterviewFeedback->partnerStatut = '1';
  $partnerInterviewFeedback->date = $interviewDate;
  $partnerInterviewFeedback->time = $interviewTime;
  $partnerInterviewFeedback->save();
}



  $grade = $request->user()->grade;
  if($grade == 4){
    return View::make('adminplatform/itwcandidatefeedback',[
      'candidates'=>$candidates,
      'partners'=>$partners,
      'partnerInterviewFeedback'=>$partnerInterviewFeedback,
    ]);
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function admin_interviewCandidateFeedback(Request $request){
  $partner_id_user = $request->input('partner_id_user');
  $candidate_id_user =  $request->input('candidate_id_user');


  $partnerExperienceCandidate = Input::get('partnerExperienceCandidate');
  $partnerCandidatePresentation = Input::get('partnerCandidatePresentation');
  $partnerCandidateCommunication = Input::get('partnerCandidateCommunication');

  $language1 = Input::get('language1');
  $language1Level = Input::get('language1Level');
  $language1Statut = Input::get('language1Statut');
  $lang1 = $language1 . '/£' . $language1Level . '/€' . $language1Statut;

  $language2 = Input::get('language2');
  $language2Level = Input::get('language2Level');
  $language2Statut = Input::get('language2Statut');
  $lang2 = $language2 . '/£' . $language2Level . '/€' . $language2Statut;

  $language3 = Input::get('language3');
  $language3Level = Input::get('language3Level');
  $language3Statut = Input::get('language3Statut');
  $lang3 = $language3 . '/£' . $language3Level . '/€' . $language3Statut;

  $language4 = Input::get('language4');
  $language4Level = Input::get('language4Level');
  $language4Statut = Input::get('language4Statut');
  $lang4 = $language4 . '/£' . $language4Level . '/€' . $language4Statut;

  $IT1 = Input::get('IT1');
  $IT1Usage = Input::get('IT1Usage');
  $IT_1 = $IT1 . '/£' . $IT1Usage;

  $IT2 = Input::get('IT2');
  $IT2Usage = Input::get('IT2Usage');
  $IT_2 = $IT2 . '/£' . $IT2Usage;

  $IT3 = Input::get('IT3');
  $IT3Usage = Input::get('IT3Usage');
  $IT_3 = $IT3 . '/£' . $IT3Usage;

  $IT4 = Input::get('IT4');
  $IT4Usage = Input::get('IT4Usage');
  $IT_4 = $IT4 . '/£' . $IT4Usage;

  $IT5 = Input::get('IT5');
  $IT5Usage = Input::get('IT5Usage');
  $IT_5 = $IT5 . '/£' . $IT5Usage;

  $recommendation = Input::get('recommendation');
  $reasonNoRecommendation = Input::get('reasonNoRecommendation');
  $Reason_Personality = Input::get('Reason_Personality');
  $department = Input::get('department');


  $functionAccountsPayable = Input::get('functionAccountsPayable');
  $Reason_AccountsPayable = Input::get('Reason_AccountsPayable');
  $seniorityLevelAccountsPayable = Input::get('seniorityLevelAccountsPayable');
  if($functionAccountsPayable === 'Accounts Payable'){
    $companyTypeAccountsPayable = implode("",Input::get('companyTypeAccountsPayable'));
    $AccountsPayable = $functionAccountsPayable . '/£' . $seniorityLevelAccountsPayable . '/€' . $Reason_AccountsPayable . '/$' . $companyTypeAccountsPayable;
  } else {
    $AccountsPayable = $functionAccountsPayable . '/£' . $seniorityLevelAccountsPayable . '/€' . $Reason_AccountsPayable . '/$' ;
  }

  $functionAccountsReceivable = Input::get('functionAccountsReceivable');
  $Reason_AccountsReceivable = Input::get('Reason_AccountsReceivable');
  $seniorityLevelAccountsReceivable = Input::get('seniorityLevelAccountsReceivable');
  if($functionAccountsReceivable === 'Accounts Receivable - Billing specialist'){
    $companyTypeAccountsReceivable = implode("",Input::get('companyTypeAccountsReceivable'));
    $AccountsReceivable = $functionAccountsReceivable . '/£' . $seniorityLevelAccountsReceivable . '/€' . $Reason_AccountsReceivable . '/$' . $companyTypeAccountsReceivable;
  } else {
    $AccountsReceivable = $functionAccountsReceivable . '/£' . $seniorityLevelAccountsReceivable . '/€' . $Reason_AccountsReceivable . '/$';
  }

  $functionGeneralLedger = Input::get('functionGeneralLedger');
  $Reason_GeneralLedger = Input::get('Reason_GeneralLedger');
  $seniorityLevelGeneralLedger = Input::get('seniorityLevelGeneralLedger');
  if($functionGeneralLedger === 'General Ledger'){
    $companyTypeGeneralLedger = implode("",Input::get('companyTypeGeneralLedger'));
    $GeneralLedger = $functionGeneralLedger . '/£' . $seniorityLevelGeneralLedger . '/€' . $Reason_GeneralLedger . '/$' . $companyTypeGeneralLedger;
  } else {
    $GeneralLedger = $functionGeneralLedger . '/£' . $seniorityLevelGeneralLedger . '/€' . $Reason_GeneralLedger . '/$';
  }

  $functionPayrollSpecialist = Input::get('functionPayrollSpecialist');
  $Reason_PayrollSpecialist = Input::get('Reason_PayrollSpecialist');
  $seniorityLevelPayrollSpecialist = Input::get('seniorityLevelPayrollSpecialist');
  if($functionPayrollSpecialist === 'Payroll Specialist'){
    $companyTypePayrollSpecialist = implode("",Input::get('companyTypePayrollSpecialist'));
    $PayrollSpecialist = $functionPayrollSpecialist . '/£' . $seniorityLevelPayrollSpecialist . '/€' . $Reason_PayrollSpecialist . '/$' . $companyTypePayrollSpecialist;
  } else {
    $PayrollSpecialist = $functionPayrollSpecialist . '/£' . $seniorityLevelPayrollSpecialist . '/€' . $Reason_PayrollSpecialist . '/$' ;
  }

  $functionCreditAnalyst = Input::get('functionCreditAnalyst');
  $Reason_CreditAnalyst = Input::get('Reason_CreditAnalyst');
  $seniorityLevelCreditAnalyst = Input::get('seniorityLevelCreditAnalyst');
  if($functionCreditAnalyst === 'Credit Analyst'){
    $companyTypeCreditAnalyst = implode("",Input::get('companyTypeCreditAnalyst'));
    $CreditAnalyst = $functionCreditAnalyst . '/£' . $seniorityLevelCreditAnalyst . '/€' . $Reason_CreditAnalyst . '/$' . $companyTypeCreditAnalyst;
  } else {
    $CreditAnalyst = $functionCreditAnalyst . '/£' . $seniorityLevelCreditAnalyst . '/€' . $Reason_CreditAnalyst . '/$' ;
  }

  $functionInternalAudit = Input::get('functionInternalAudit');
  $Reason_InternalAudit = Input::get('Reason_InternalAudit');
  $seniorityLevelInternalAudit = Input::get('seniorityLevelInternalAudit');
  if($functionInternalAudit === 'Internal Audit'){
    $companyTypeInternalAudit = implode("",Input::get('companyTypeInternalAudit'));
    $InternalAudit = $functionInternalAudit . '/£' . $seniorityLevelInternalAudit . '/€' . $Reason_InternalAudit . '/$' . $companyTypeInternalAudit;
  } else {
    $InternalAudit = $functionInternalAudit . '/£' . $seniorityLevelInternalAudit . '/€' . $Reason_InternalAudit . '/$';
  }

  $functionExternalAudit = Input::get('functionExternalAudit');
  $Reason_ExternalAudit = Input::get('Reason_ExternalAudit');
  $seniorityLevelExternalAudit = Input::get('seniorityLevelExternalAudit');
  if($functionExternalAudit === 'External Audit'){
    $companyTypeExternalAudit = implode("",Input::get('companyTypeExternalAudit'));
    $ExternalAudit = $functionExternalAudit . '/£' . $seniorityLevelExternalAudit . '/€' . $Reason_ExternalAudit . '/$' . $companyTypeExternalAudit;
  } else {
    $ExternalAudit = $functionExternalAudit . '/£' . $seniorityLevelExternalAudit . '/€' . $Reason_ExternalAudit . '/$' ;
  }

  $functionAccounting = $AccountsPayable . ',' . $AccountsReceivable . ',' . $GeneralLedger . ',' . $PayrollSpecialist . ',' . $CreditAnalyst . ',' . $InternalAudit . ',' . $ExternalAudit;


  $functionFinancialController = Input::get('functionFinancialController');
  $Reason_FinancialController = Input::get('Reason_FinancialController');
  $seniorityLevelFinancialController = Input::get('seniorityLevelFinancialController');
  if($functionFinancialController === 'Financial Controller'){
    $companyTypeFinancialController = implode("",Input::get('companyTypeFinancialController'));
    $FinancialController = $functionFinancialController . '/£' . $seniorityLevelFinancialController . '/€' . $Reason_FinancialController . '/$' . $companyTypeFinancialController;
  } else {
    $FinancialController = $functionFinancialController . '/£' . $seniorityLevelFinancialController . '/€' . $Reason_FinancialController . '/$';
  }

  $functionIndustrialController = Input::get('functionIndustrialController');
  $Reason_IndustrialController = Input::get('Reason_IndustrialController');
  $seniorityLevelIndustrialController = Input::get('seniorityLevelIndustrialController');
  if($functionIndustrialController === 'Industrial Controller'){
    $companyTypeIndustrialController = implode("",Input::get('companyTypeIndustrialController'));
    $IndustrialController = $functionIndustrialController . '/£' . $seniorityLevelIndustrialController . '/€' . $Reason_IndustrialController . '/$' . $companyTypeIndustrialController;
  } else {
    $IndustrialController = $functionIndustrialController . '/£' . $seniorityLevelIndustrialController . '/€' . $Reason_IndustrialController . '/$';
  }

  $functionAnalystFPA = Input::get('functionAnalystFPA');
  $Reason_AnalystFPA = Input::get('Reason_AnalystFPA');
  $seniorityLevelAnalystFPA = Input::get('seniorityLevelAnalystFPA');
  if($functionAnalystFPA === 'Analyst - FP&A'){
    $companyTypeAnalystFPA = implode("",Input::get('companyTypeAnalystFPA'));
    $AnalystFPA = $functionAnalystFPA . '/£' . $seniorityLevelAnalystFPA . '/€' . $Reason_AnalystFPA . '/$' . $companyTypeAnalystFPA;
  } else {
    $AnalystFPA = $functionAnalystFPA . '/£' . $seniorityLevelAnalystFPA . '/€' . $Reason_AnalystFPA . '/$';
  }

  $functionConsolidationReporting = Input::get('functionConsolidationReporting');
  $Reason_ConsolidationReporting = Input::get('Reason_ConsolidationReporting');
  $seniorityLevelConsolidation = Input::get('seniorityLevelConsolidation');
  if($functionConsolidationReporting === 'Consolidation - Reporting'){
    $companyTypeConsolidation = implode("",Input::get('companyTypeConsolidation'));
    $ConsolidationReporting = $functionConsolidationReporting . '/£' . $seniorityLevelConsolidation . '/€' . $Reason_ConsolidationReporting . '/$' . $companyTypeConsolidation;
  } else {
    $ConsolidationReporting = $functionConsolidationReporting . '/£' . $seniorityLevelConsolidation . '/€' . $Reason_ConsolidationReporting . '/$';
  }

  $functionFC = $FinancialController . ',' . $IndustrialController . ',' . $AnalystFPA . ',' . $ConsolidationReporting;

  $functionVATAccountant = Input::get('functionVATAccountant');
  $Reason_VATAccountant = Input::get('Reason_VATAccountant');
  $seniorityLevelVATAccountant = Input::get('seniorityLevelVATAccountant');
  if($functionVATAccountant === 'VAT Accountant'){
    $companyTypeVATAccountant = implode("",Input::get('companyTypeVATAccountant'));
    $VATAccountant = $functionVATAccountant . '/£' . $seniorityLevelVATAccountant . '/€' . $Reason_VATAccountant . '/$' . $companyTypeVATAccountant;
  } else {
    $VATAccountant = $functionVATAccountant . '/£' . $seniorityLevelVATAccountant . '/€' . $Reason_VATAccountant . '/$' ;
  }

  $functionTaxAnalyst = Input::get('functionTaxAnalyst');
  $Reason_TaxAnalyst = Input::get('Reason_TaxAnalyst');
  $seniorityLevelTaxAnalyst = Input::get('seniorityLevelTaxAnalyst');
  if($functionTaxAnalyst === 'Tax Analyst'){
    $companyTypeTaxAnalyst = implode("",Input::get('companyTypeTaxAnalyst'));
    $TaxAnalyst = $functionTaxAnalyst . '/£' . $seniorityLevelTaxAnalyst . '/€' . $Reason_TaxAnalyst . '/$' . $companyTypeTaxAnalyst;
  } else {
    $TaxAnalyst = $functionTaxAnalyst . '/£' . $seniorityLevelTaxAnalyst . '/€' . $Reason_TaxAnalyst . '/$';
  }

  $functionTreasuryAnalyst = Input::get('functionTreasuryAnalyst');
  $Reason_TreasuryAnalyst = Input::get('Reason_TreasuryAnalyst');
  $seniorityLevelTreasuryAnalyst = Input::get('seniorityLevelTreasuryAnalyst');
  if($functionTreasuryAnalyst === 'Treasury Analyst'){
    $companyTypeTreasuryAnalyst = implode("",Input::get('companyTypeTreasuryAnalyst'));
    $TreasuryAnalyst = $functionTreasuryAnalyst . '/£' . $seniorityLevelTreasuryAnalyst . '/€' . $Reason_TreasuryAnalyst . '/$' . $companyTypeTreasuryAnalyst;
  } else {
    $TreasuryAnalyst = $functionTreasuryAnalyst . '/£' . $seniorityLevelTreasuryAnalyst . '/€' . $Reason_TreasuryAnalyst . '/$';
  }

  $functionTaxTreasury = $VATAccountant . ',' . $TaxAnalyst . ',' . $TreasuryAnalyst;



  $function = $functionAccounting . ',' . $functionFC . ',' . $functionTaxTreasury;


  $otherFunction = Input::get('otherFunction');


  $commentsForTheCandidate = Input::get('commentsForTheCandidate');
  $otherComments = Input::get('otherComments');

  if($recommendation === 'Yes'){
    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
        'interviewStatut' => '10',
        'lastActiveJobSearchEmail' => new DateTime('now'),
        ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();
    $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidate_id_user)->first();
    $sharelink = $candidateInfos->shareLink;

    //Mail::send('email.candidatePartnerFeedbackRecommended',['candidates' => $candidates, 'sharelink'=>$sharelink],function($mail) use ($candidates) {
    //  $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Our partner recommended you!');
    //});
  }

  if($recommendation === 'No'){
    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->update( array(
        'interviewStatut' => '9',
        'lastActiveJobSearchEmail' => new DateTime('now'),
        ));

    $candidates = DB::table('candidates')->where('id_user',$candidate_id_user)->first();

    //Mail::send('email.candidatePartnerFeedbackNotRecommended',['candidates' => $candidates],function($mail) use ($candidates) {
    //  $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Partner interview feedback');
    //});
  }

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$partner_id_user)->update( array(
  'partnerStatut' => '2',
  'partnerExperienceCandidate' => $partnerExperienceCandidate,
  'partnerCandidatePresentation' => $partnerCandidatePresentation,
  'partnerCandidateCommunication' => $partnerCandidateCommunication,
  'languageSkills' => $lang1 . ',' . $lang2 . ',' . $lang3 . ',' . $lang4 . ',',
  'ITSkills' => $IT_1 . ',' . $IT_2 . ',' . $IT_3 . ',' . $IT_4 . ',' . $IT_5 . ',',
  'recommendation' => $recommendation,
  'reasonNoRecommendation' => $reasonNoRecommendation,
  'Reason_Personality' => $Reason_Personality,
  'department' => $department,
  'function' => $function,
  'otherFunction' => $otherFunction,
  'commentsForTheCandidate' => $commentsForTheCandidate,
  'otherComments' => $otherComments,
  ));


  $partnerInterviews = DB::table('partnerInterviews')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$partner_id_user)->update( array(
  'statut' => '5'
  ));

  $partnerInterviewFeedback = DB::table('partnerInterviewFeedback')->where('candidate_id_user',$candidate_id_user)
                                                                   ->where('partner_id_user',$partner_id_user)
                                                                   ->first();


$partners = DB::table('partners')->where('id_user',$partner_id_user)->first();

Mail::send('email.partnerFeedbackGiven',['partners' => $partners, 'candidates' => $candidates, 'partnerInterviewFeedback' => $partnerInterviewFeedback],function($mail) use ($partners) {
  $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Interview feedback given by partner!');
});



  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partner_id_user)->first();

  $grade = $request->user()->grade;
  if($grade == 4){
    return View::make('adminplatform/informationSent',[

    ]);
  }
  else {
    return View::make('404',[
    ]);
  }


}


public function adminSelectPartner(Request $request){
  $partner_idUser = Input::get('partner_idUser');
  $candidate_idUser = Input::get('candidate_idUser');
  $partnerCompensation = Input::get('partnerCompensation');
  $candidates = DB::table('candidates')->where('id_user',$candidate_idUser)->first();
  $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidate_idUser)->first();


  $partners = DB::table('partners')->where('id_user',$partner_idUser)->first();


  $partnerInterview = new partnerInterviews();
  $partnerInterview->statut = '1';
  $partnerInterview->partner_id_user = $partner_idUser;
  $partnerInterview->candidate_id_user = $candidate_idUser;
  $partnerInterview->partnerCompensation = $partnerCompensation;
  $partnerInterview->save();

  $candidates = DB::table('candidates')->where('id_user',$candidate_idUser)->update( array(
  'interviewStatut' => '3',
));
  $candidates = DB::table('candidates')->where('id_user',$candidate_idUser)->first();

  $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidate_idUser)->first();
  $sharelink = $candidateInfos->shareLink;

  Mail::send('email.candidateProfileValidatedAdmin',['candidates' => $candidates, 'sharelink' => $sharelink],function($mail) use ($candidates) {
    $mail->to($candidates->candidate_email)->from('no-reply@tietalent.com')->subject('Profile validated');
  });

  $partners = DB::table('partners')->where('id_user',$partner_idUser)->first();
  Mail::send('email.partnerNewCandidateToInterview',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('New candidate to interview!');
  });

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/informationSent',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminPartners(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/partners',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerDetails', partnerDetails::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function adminCompanies(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/companies',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function adminCandidates(Request $request){
  $grade = $request->user()->grade;
  $min = 0;

  $nbCandidates= AdminPlatform::getNbCandidates();

  if($grade == 4){
    return View::make('adminplatform/candidates',[
      'min'=>$min,
      'nbCandidates'=>$nbCandidates,
    ])->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function adminCandidatesPage(Request $request){
  $page = Input::get('page');
  $min = $page*10 - 10;


  $grade = $request->user()->grade;

  $nbCandidates= AdminPlatform::getNbCandidates();


  if($grade == 4){
    return View::make('adminplatform/candidates',[
      'min'=>$min,
      'nbCandidates'=>$nbCandidates,
    ])->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all());
    }
    else {
      return View::make('404',[
      ]);
    }
}


public function candidatePartnerInterviewsPlanned(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/candidatePartnerInterviewsPlanned',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function candidatePartnerInterviewsToOrganize(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/candidatePartnerInterviewsToOrganize',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::where('statut','1')->orWhere('statut','2')->orWhere('statut','3')->get());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function recommendedCandidates(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/recommendedCandidates',[

    ])->with('candidates', candidate::all()->where('interviewStatut','10'))
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminUserWithoutSkypeId(Request $request){
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/UserNoSkypeId',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}

public function adminSeePartners(Request $request){

  $partner_id = Input::get('partner_id');

  $partners = DB::table('partners')->where('id',$partner_id)->first();
  $id_userPartner = $partners->id_user;

  $partnerDetails = DB::table('partnerDetails')->where('id_user',$id_userPartner)->first();

  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_userPartner)->first();


  if($adminInterviews->statut == '4' || $adminInterviews->statut == '5'){

    $itwDate = $adminInterviews->date;
    $itwTime = $adminInterviews->time;

    $diff = Carbon::now()->diffInMinutes(Carbon::create(explode("-", $itwDate)[0], explode("-", $itwDate)[1], explode("-", $itwDate)[2], explode(":", $itwTime)[0], explode(":", $itwTime)[1], 00, 'Europe/Paris'), false);

    if($diff < -30) {
      $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_userPartner)->update( array(
      'statut' => '5',
      ));
      $partners = DB::table('partners')->where('id_user',$id_userPartner)->update( array(
      'partner_statut' => '8',
      ));
    }
    if($diff > -30) {
      $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_userPartner)->update( array(
      'statut' => '4',
      ));
      $partners = DB::table('partners')->where('id_user',$id_userPartner)->update( array(
      'partner_statut' => '7',
      ));
    }
    $partners = DB::table('partners')->where('id_user',$id_userPartner)->first();
    $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_userPartner)->first();
    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_userPartner)->first();
    $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$id_userPartner)->first();
    $grade = $request->user()->grade;
    if($grade == 4){
      return View::make('adminplatform/seePartners',[
        'partners'=>$partners,
        'partnerInfos'=>$partnerInfos,
        'partnerDetails'=>$partnerDetails,
        'adminInterviews'=>$adminInterviews,
        'adminInterviewFeedback'=>$adminInterviewFeedback,
      ])->with('documents', partnerDocuments::all()->where('id_user',$id_userPartner))
        ->with('candidatesAll', candidate::all())
        ->with('companiesAll', company::all())
        ->with('partnersAll', partner::all())
        ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $id_userPartner))
        ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $id_userPartner));
    }
    else {
      return View::make('404',[
      ]);
    }
  }

  $partners = DB::table('partners')->where('id_user',$id_userPartner)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$id_userPartner)->first();
  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$id_userPartner)->first();
  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$id_userPartner)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seePartners',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
      'partnerDetails'=>$partnerDetails,
      'adminInterviews'=>$adminInterviews,
      'adminInterviewFeedback'=>$adminInterviewFeedback,
    ])->with('documents', partnerDocuments::all()->where('id_user',$id_userPartner))
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $id_userPartner))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $id_userPartner));
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminPartnerDescription(Request $request){

  $partnerIdUser = Input::get('partnerIdUser');
  $descriptionForCompanies = Input::get('descriptionForCompanies');

  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->update( array(
    'descriptionForCompanies' => $descriptionForCompanies,
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();
  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->first();
  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$partnerIdUser)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seePartners',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
      'partnerDetails'=>$partnerDetails,
      'adminInterviews'=>$adminInterviews,
      'adminInterviewFeedback'=>$adminInterviewFeedback,
    ])->with('documents', partnerDocuments::all()->where('id_user',$partnerIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $partnerIdUser))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $partnerIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function adminPartnerCRMNotes(Request $request){

  $partnerIdUser = Input::get('partnerIdUser');
  $partnerNotes = Input::get('partnerNotes');

  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->update( array(
    'partnerNotes' => $partnerNotes,
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();
  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->first();
  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$partnerIdUser)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seePartners',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
      'partnerDetails'=>$partnerDetails,
      'adminInterviews'=>$adminInterviews,
      'adminInterviewFeedback'=>$adminInterviewFeedback,
    ])->with('documents', partnerDocuments::all()->where('id_user',$partnerIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $partnerIdUser))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $partnerIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function adminPartnerAbout(Request $request){

  $partnerIdUser = Input::get('partnerIdUser');
  $about = Input::get('about');

  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->update( array(
    'about' => $about,
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();
  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->first();
  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$partnerIdUser)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seePartners',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
      'partnerDetails'=>$partnerDetails,
      'adminInterviews'=>$adminInterviews,
      'adminInterviewFeedback'=>$adminInterviewFeedback,
    ])->with('documents', partnerDocuments::all()->where('id_user',$partnerIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $partnerIdUser))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $partnerIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function adminPartnerDetails(Request $request){

  $partnerIdUser = Input::get('partnerIdUser');

  $firstName = Input::get('firstName');
  $lastName = Input::get('lastName');
  $address = Input::get('address');
  $partner_email = Input::get('partner_email');
  $partner_email2 = Input::get('partner_email2');
  $partner_email3 = Input::get('partner_email3');
  $partner_phone = Input::get('partner_phone');
  $partner_phone2 = Input::get('partner_phone2');
  $partner_phone3 = Input::get('partner_phone3');
  $departmentSpecialization = Input::get('departmentSpecialization');
  $departmentSpecialization_other = Input::get('departmentSpecialization_other');
  $companyType = Input::get('companyType');
  $companyType_other = Input::get('companyType_other');
  $reasonGoodPartner = Input::get('reasonGoodPartner');
  $partner_skype = Input::get('partner_skype');
  $linkedIn = Input::get('linkedIn');
  $shareLink = Input::get('shareLink');
  $internetAccess = Input::get('internetAccess');
  $numberHours = Input::get('numberHours');
  $communication = Input::get('communication');
  $partner_statut = Input::get('partner_statut');
  $functionSpecialization = Input::get('functionSpecialization');

  $users = DB::table('users')->where('id',$partnerIdUser)->update( array(
    'email' => $partner_email,

  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->update( array(
    'firstName' => $firstName,
    'lastName' => $lastName,
    'partner_email' => $partner_email,
    'partner_email2' => $partner_email2,
    'partner_email3' => $partner_email3,
    'partner_phone' => $partner_phone,
    'partner_phone2' => $partner_phone2,
    'partner_phone3' => $partner_phone3,
    'partner_skype' => $partner_skype,
    'partner_statut' => $partner_statut,
    'communication' => $communication,
  ));

  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->update( array(
    'address' => $address,
    'departmentSpecialization' => $departmentSpecialization,
    'departmentSpecialization_other' => $departmentSpecialization_other,
    'functionSpecialization' => $functionSpecialization,
    'companyType' => $companyType,
    'companyType_other' => $companyType_other,
    'reasonGoodPartner' => $reasonGoodPartner,
    'linkedIn' => $linkedIn,
    'internetAccess' => $internetAccess,
    'numberHours' => $numberHours,
  ));


  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->update( array(
    'shareLink' => $shareLink,
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $partnerInfos = DB::table('partnerInfos')->where('id_user',$partnerIdUser)->first();
  $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->first();
  $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->first();
  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$partnerIdUser)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seePartners',[
      'partners'=>$partners,
      'partnerInfos'=>$partnerInfos,
      'partnerDetails'=>$partnerDetails,
      'adminInterviews'=>$adminInterviews,
      'adminInterviewFeedback'=>$adminInterviewFeedback,
    ])->with('documents', partnerDocuments::all()->where('id_user',$partnerIdUser))
      ->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('partnerInterviews', partnerInterviews::all()->where('partner_id_user', $partnerIdUser))
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all()->where('partner_id_user', $partnerIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function adminPartnerNotSelected(Request $request){
  $id_user = $request->user()->id;
  $partner_id = Input::get('partner_id');
  $reasonNotValidated =  $request->input('reasonNotValidated');
  $otherDivisionMatch = $request->input('toKeepForDivision');


  if( $reasonNotValidated === 'noMatch') {

  $partners = DB::table('partners')->where('id',$partner_id)->update( array(
  'partner_statut' => '2',
));
  $partners = DB::table('partners')->where('id',$partner_id)->first();
  $partnerIdUser = $partners->id_user;

  $adminInterviews = DB::table('adminInterviews')->where('admin_id_user',$id_user)
                                                 ->where('partner_id_user',$partnerIdUser)
                                                 ->update( array(
    'statut' => '6',
    ));

  Mail::send('email.partnerNoMatch',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  });
}

  if( $reasonNotValidated === 'noDivision') {
  $partners = DB::table('partners')->where('id',$partner_id)->update( array(
  'partner_statut' => '3',
  'otherDivisionMatch' => $otherDivisionMatch,
));
  $partners = DB::table('partners')->where('id',$partner_id)->first();

  $partnerIdUser = $partners->id_user;

  $adminInterviews = DB::table('adminInterviews')->where('admin_id_user',$id_user)
                                                 ->where('partner_id_user',$partnerIdUser)
                                                 ->update( array(
    'statut' => '7',
    ));

  Mail::send('email.partnerNoDivision',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  });
}

  if( $reasonNotValidated === 'toConsiderAsCandidate') {
  $partners = DB::table('partners')->where('id',$partner_id)->update( array(
  'partner_statut' => '4',
  ));
  $partners = DB::table('partners')->where('id',$partner_id)->first();
  Mail::send('email.partnerNoMatch',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('No opportunity - today');
  });
  }

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/partners',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerDetails', partnerDetails::all());
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function adminPartnerSelected(Request $request){
  $id_user = $request->user()->id;
  $partner_id = Input::get('partner_id');



  $partnerIdUser = Input::get('partner_id_user');
  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->update( array(
      'partner_statut' => '5',
    ));


  $datepicker1 = Input::get('datepicker1');
  $timepicker1 = Input::get('timepicker1');
  $datepicker2 = Input::get('datepicker2');
  $timepicker2 = Input::get('timepicker2');
  $datepicker3 = Input::get('datepicker3');
  $timepicker3 = Input::get('timepicker3');


  DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->update( array(
  'admin_id_user' => $id_user,
  'statut' => '2',
  'datepicker1' => $datepicker1,
  'timepicker1' => $timepicker1,
  'datepicker2' => $datepicker2,
  'timepicker2' => $timepicker2,
  'datepicker3' => $datepicker3,
  'timepicker3' => $timepicker3,
  ));

  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

  Mail::send('email.partnerProfileValidatedAdmin',['partners' => $partners],function($mail) use ($partners) {
    $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Profile validated');
  });
  $grade = $request->user()->grade;

  if($grade == 4){
          return View::make('adminplatform/partners',[

          ])->with('candidates', candidate::all())
            ->with('companies', company::all())
            ->with('partners', partner::all())
            ->with('partnerDetails', partnerDetails::all());
      }
  else {
    return View::make('404',[
    ]);
  }
}



public function admin_confirmPartnerInterview(Request $request){
    $id_user = $request->user()->id;

    $partnerIdUser = $request->input('partner_id_user');
    $dateTime =  $request->input('proposition');

    if( strpos( $dateTime, 'at' ) !== false ) {
      $date = explode(" at ", $dateTime)[0];
      $time = explode(" at ", $dateTime)[1];
    }
    else if( strpos( $dateTime, 'à' ) !== false ) {
      $date = explode(" à ", $dateTime)[0];
      $time = explode(" à ", $dateTime)[1];
    }

    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->update( array(
    'statut' => '4',
    'date' => $date,
    'time' => $time,
    ));

    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->update( array(
    'partner_statut' => '7',
    ));

    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

    Mail::send('email.partnerAdminConfirmInterview',['partners' => $partners],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview confirmed');
    });

    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->first();
    $adminInterviewsId = $adminInterviews->id;
    $adminIdUser = $adminInterviews->admin_id_user;
    $interviewDate = $adminInterviews->date;
    $interviewTime = $adminInterviews->time;
    $adminInterviewFeedback = new adminInterviewFeedback();
    $adminInterviewFeedback->adminInterviews_id = $adminInterviewsId;
    $adminInterviewFeedback->admin_id_user = $adminIdUser;
    $adminInterviewFeedback->partner_id_user = $partnerIdUser;
    $adminInterviewFeedback->partnerStatut = '1';
    $adminInterviewFeedback->adminStatut = '1';
    $adminInterviewFeedback->date = $interviewDate;
    $adminInterviewFeedback->time = $interviewTime;
    $adminInterviewFeedback->save();
    $grade = $request->user()->grade;

    if($grade == 4){
      return View::make('adminplatform/partners',[

      ])->with('candidates', candidate::all())
        ->with('companies', company::all())
        ->with('partners', partner::all())
        ->with('partnerDetails', partnerDetails::all());
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function admin_partnerInterviewFeedback(Request $request){
  $id_user = $request->user()->id;
  $partnerIdUser = $request->input('partner_id_user');
  $admin = DB::table('admin')->where('id_user',$id_user)->first();
  $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();
  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/partnerInterviewFeedback',[
      'admin'=>$admin,
      'partners'=>$partners,
    ])->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function admin_interviewPartnerFeedback(Request $request){
  $id_user = $request->user()->id;
  $partnerIdUser = $request->input('partner_id_user');
  $request->merge(['function' => implode(',', (array) $request->get('function'))]);

  $adminExperiencePartner = Input::get('adminExperiencePartner');
  $adminPartnerProfessionalism = Input::get('adminPartnerProfessionalism');
  $adminPartnerCapabilities = Input::get('adminPartnerCapabilities');
  $recommendation = Input::get('recommendation');
  $reasonNoRecommendation = Input::get('reasonNoRecommendation');
  $Reason_Personality = Input::get('Reason_Personality');
  $department = Input::get('department');
  $function = Input::get('function');
  $otherFunction = Input::get('otherFunction');
  $Reason_AccountsPayable = Input::get('Reason_AccountsPayable');
  $Reason_AccountsReceivable = Input::get('Reason_AccountsReceivable');
  $Reason_GeneralLedger = Input::get('Reason_GeneralLedger');
  $Reason_PayrollSpecialist = Input::get('Reason_PayrollSpecialist');
  $Reason_CreditAnalyst = Input::get('Reason_CreditAnalyst');
  $Reason_InternalAudit = Input::get('Reason_InternalAudit');
  $Reason_ExternalAudit = Input::get('Reason_ExternalAudit');
  $Reason_IndustrialController = Input::get('Reason_IndustrialController');
  $Reason_AnalystFPA = Input::get('Reason_AnalystFPA');
  $Reason_ConsolidationReporting = Input::get('Reason_ConsolidationReporting');
  $Reason_VATAccountant = Input::get('Reason_VATAccountant');
  $Reason_TaxAnalyst = Input::get('Reason_TaxAnalyst');
  $Reason_TreasuryAnalyst = Input::get('Reason_TreasuryAnalyst');
  $otherComments = Input::get('otherComments');

  if($recommendation === 'Yes'){
    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->update( array(
        'partner_statut' => '10',
        ));
    $partnerDetails = DB::table('partnerDetails')->where('id_user',$partnerIdUser)->update( array(
        'functionSpecialization' => $function,
        ));
    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

    $adminInterviews = DB::table('adminInterviews')->where('partner_id_user',$partnerIdUser)->update( array(
    'statut' => '8',
    ));

    Mail::send('email.partnerHired',['partners' => $partners],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Welcome');
    });
    }
  if($recommendation === 'No'){
    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->update( array(
        'partner_statut' => '9',
        ));
    $partners = DB::table('partners')->where('id_user',$partnerIdUser)->first();

    Mail::send('email.partnerNotHired',['partners' => $partners],function($mail) use ($partners) {
      $mail->to($partners->partner_email)->from('no-reply@tietalent.com')->subject('Interview feedback');
    });
    }

  $adminInterviewFeedback = DB::table('adminInterviewFeedback')->where('partner_id_user',$partnerIdUser)
                                                                   ->where('admin_id_user',$id_user)->update( array(
  'adminStatut' => '2',
  'adminExperiencePartner' => $adminExperiencePartner,
  'adminPartnerProfessionalism' => $adminPartnerProfessionalism,
  'adminPartnerCapabilities' => $adminPartnerCapabilities,
  'recommendation' => $recommendation,
  'reasonNoRecommendation' => $reasonNoRecommendation,
  'Reason_Personality' => $Reason_Personality,
  'department' => $department,
  'function' => $function,
  'otherFunction' => $otherFunction,
  'Reason_AccountsPayable' => $Reason_AccountsPayable,
  'Reason_AccountsReceivable' => $Reason_AccountsReceivable,
  'Reason_GeneralLedger' => $Reason_GeneralLedger,
  'Reason_PayrollSpecialist' => $Reason_PayrollSpecialist,
  'Reason_CreditAnalyst' => $Reason_CreditAnalyst,
  'Reason_InternalAudit' => $Reason_InternalAudit,
  'Reason_ExternalAudit' => $Reason_ExternalAudit,
  'Reason_IndustrialController' => $Reason_IndustrialController,
  'Reason_AnalystFPA' => $Reason_AnalystFPA,
  'Reason_ConsolidationReporting' => $Reason_ConsolidationReporting,
  'Reason_VATAccountant' => $Reason_VATAccountant,
  'Reason_TaxAnalyst' => $Reason_TaxAnalyst,
  'Reason_TreasuryAnalyst' => $Reason_TreasuryAnalyst,
  'otherComments' => $otherComments,
  ));


  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/partners',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerDetails', partnerDetails::all());
  }
  else {
    return View::make('404',[
    ]);
  }
}



public function adminSeeCompanies(Request $request){

  $company_id = Input::get('company_id');

  $companies = DB::table('companies')->where('id',$company_id)->first();
  $id_userCompany = $companies->id_user;

  $offices = DB::table('offices')->where('id_user',$id_userCompany)->first();

  $companyDetails = DB::table('companyDetails')->where('id_user',$id_userCompany)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$id_userCompany)->first();
  $companyInfos = DB::table('companyInfos')->where('id_user',$id_userCompany)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seeCompanies',[
      'companies'=>$companies,
      'offices'=>$offices,
      'companyDetails'=>$companyDetails,
      'companyUsers'=>$companyUsers,
    ])->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('companyInfos', companyInfos::all()->where('id_user',$id_userCompany))
      ->with('companyVacancies', companyVacancies::all()->where('id_user',$id_userCompany));
  }
  else {
    return View::make('404',[
    ]);
  }

}


public function adminCompanyCRMNotes(Request $request){

  $company_id = Input::get('company_id');
  $companyUserIdUser = Input::get('companyUserIdUser');
  $companyNotes = Input::get('companyNotes');

  $companyInfos = DB::table('companyInfos')->where('id_user',$companyUserIdUser)->update( array(
    'companyNotes' => $companyNotes,
  ));

  $companies = DB::table('companies')->where('id',$company_id)->first();

  $offices = DB::table('offices')->where('id_user',$companyUserIdUser)->first();

  $companyDetails = DB::table('companyDetails')->where('id_user',$companyUserIdUser)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$companyUserIdUser)->first();

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/seeCompanies',[
      'companies'=>$companies,
      'companyUserIdUser'=>$companyUserIdUser,
      'offices'=>$offices,
      'companyDetails'=>$companyDetails,
      'companyUsers'=>$companyUsers,
    ])->with('candidatesAll', candidate::all())
      ->with('companiesAll', company::all())
      ->with('partnersAll', partner::all())
      ->with('companyInfos', companyInfos::all()->where('id_user',$companyUserIdUser));
  }
  else {
    return View::make('404',[
    ]);
  }
}


public function admin_companyVacancyDetails(Request $request){
    $id_user = $request->input('companyIdUser');
    $vacancy_id = $request->input('vacancy_id');


    $companies = DB::table('companies')->where('id_user',$id_user)->first();
    $id_company = $companies->id;
    $company_id_user = $companies->id_user;

    $companyVacancies = DB::table('companyVacancies')->where('id',$vacancy_id) // to return the right vacancy
                                                     ->where('id_company',$id_company)   // to return vacancies that only belong to the company (if the user changes the vacancy id in the URL bar)
                                                     ->first();
    $vacancyId = $companyVacancies->id;
    $positionFunction = $companyVacancies->function;
    $positionAddress = $companyVacancies->address;
    $seniorityStarter = $companyVacancies->seniorityLevelStarter;
    $seniorityJunior = $companyVacancies->seniorityLevelJunior;
    $seniorityConfirmed = $companyVacancies->seniorityLevelConfirmed;
    $senioritySenior = $companyVacancies->seniorityLevelSenior;
    $companyType = $companies->companyType;
    $vacancyStage = $companyVacancies->vacancyStage;
    $companyIdUser = $companyVacancies->id_user;
    $contractType = $companyVacancies->contractType;
    $startDate = $companyVacancies->startDate;
    $budget = $companyVacancies->budget;
    $occupationRate = $companyVacancies->occupationRate;
    $visaSponsor = $companyVacancies->visaSponsor;

    $language1 = $companyVacancies->language1;
    $language1Level = $companyVacancies->language1Level;
    $language1Statut = $companyVacancies->language1Statut;

    $language2 = $companyVacancies->language2;
    $language2Level = $companyVacancies->language2Level;
    $language2Statut = $companyVacancies->language2Statut;

    $language3 = $companyVacancies->language3;
    $language3Level = $companyVacancies->language3Level;
    $language3Statut = $companyVacancies->language3Statut;

    $language4 = $companyVacancies->language4;
    $language4Level = $companyVacancies->language4Level;
    $language4Statut = $companyVacancies->language4Statut;

    $IT1 = $companyVacancies->IT1;
    $IT1Usage = $companyVacancies->IT1Usage;
    $IT2 = $companyVacancies->IT2;
    $IT2Usage = $companyVacancies->IT2Usage;
    $IT3 = $companyVacancies->IT3;
    $IT3Usage = $companyVacancies->IT3Usage;
    $IT4 = $companyVacancies->IT4;
    $IT4Usage = $companyVacancies->IT4Usage;
    $IT5 = $companyVacancies->IT5;
    $IT5Usage = $companyVacancies->IT5Usage;



    if($vacancyStage == '6'){
    $companyInterviewFeedback = DB::table('companyInterviewFeedback')->where('company_id_user',$companyIdUser)
                                                                     ->where('nextStep','3')
                                                                     ->first();
    $candidateIdUser = $companyInterviewFeedback->candidate_id_user;
    $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();
    $grade = $request->user()->grade;

    if($grade == 4){
      return View::make('adminplatform/vacancydetailsplacement',[
        'candidates'=>$candidates,
        'companies'=>$companies,
        'companyVacancies'=>$companyVacancies,
        'companyInterviewFeedback'=>$companyInterviewFeedback,
      ]);
   }
   else {
     return View::make('404',[
     ]);
   }
  }



  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/vacancydetails',[
      'companies'=>$companies,
      'companyVacancies'=>$companyVacancies,
    ])->with('partnerInterviewFeedback', partnerInterviewFeedback::where(function($query) use ($positionFunction,$seniorityStarter,$seniorityJunior,$seniorityConfirmed,$senioritySenior,$companyType){
                                                                      $query->where('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityStarter.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityJunior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$seniorityConfirmed.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                      $query->orWhere('function', 'LIKE', '%'.$positionFunction.'/£'.$senioritySenior.'/€'.'%'.'/$'.'%'.$companyType.'%');
                                                                  })

                                                                 ->where(function($languageOne) use ($language1,$language1Level){
                                                                   if($language1Level == 'basic'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£good level/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'good level'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£fluent/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'fluent'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                     $languageOne->orWhere('languageSkills', 'LIKE', '%'.$language1.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language1Level == 'mother tongue'){
                                                                     $languageOne->where('languageSkills', 'LIKE', '%'.$language1.'/£'.$language1Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                ->where(function($languageTwo) use ($language2,$language2Level){
                                                                  if($language2Level == 'basic'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£good level/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'good level'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£fluent/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'fluent'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                    $languageTwo->orWhere('languageSkills', 'LIKE', '%'.$language2.'/£mother tongue/€'.'%');
                                                                  }
                                                                  if($language2Level == 'mother tongue'){
                                                                    $languageTwo->where('languageSkills', 'LIKE', '%'.$language2.'/£'.$language2Level.'/€'.'%');
                                                                  }
                                                                 })

                                                                 ->where(function($languageThree) use ($language3,$language3Level){
                                                                   if($language3Level == 'basic'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£good level/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'good level'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£fluent/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'fluent'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                     $languageThree->orWhere('languageSkills', 'LIKE', '%'.$language3.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language3Level == 'mother tongue'){
                                                                     $languageThree->where('languageSkills', 'LIKE', '%'.$language3.'/£'.$language3Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($languageFour) use ($language4,$language4Level){
                                                                   if($language4Level == 'basic'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£good level/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'good level'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£fluent/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'fluent'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                     $languageFour->orWhere('languageSkills', 'LIKE', '%'.$language4.'/£mother tongue/€'.'%');
                                                                   }
                                                                   if($language4Level == 'mother tongue'){
                                                                     $languageFour->where('languageSkills', 'LIKE', '%'.$language4.'/£'.$language4Level.'/€'.'%');
                                                                   }
                                                                  })

                                                                 ->where(function($ITOne) use ($IT1,$IT1Usage){
                                                                   if($IT1Usage == 'class'){
                                                                     $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                     $ITOne->orWhere('ITSkills', 'LIKE', '%'.$IT1.'/£work'.'%');
                                                                   }
                                                                   if($IT1Usage == 'work'){
                                                                   $ITOne->where('ITSkills', 'LIKE', '%'.$IT1.'/£'.$IT1Usage.'%');
                                                                   }
                                                                   })
                                                                  ->where(function($ITTwo) use ($IT2,$IT2Usage){
                                                                    if($IT2Usage == 'class'){
                                                                      $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                      $ITTwo->orWhere('ITSkills', 'LIKE', '%'.$IT2.'/£work'.'%');
                                                                    }
                                                                    if($IT2Usage == 'work'){
                                                                     $ITTwo->where('ITSkills', 'LIKE', '%'.$IT2.'/£'.$IT2Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITThree) use ($IT3,$IT3Usage){
                                                                    if($IT3Usage == 'class'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                      $ITThree->orWhere('ITSkills', 'LIKE', '%'.$IT3.'/£work'.'%');
                                                                    }
                                                                    if($IT3Usage == 'work'){
                                                                      $ITThree->where('ITSkills', 'LIKE', '%'.$IT3.'/£'.$IT3Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFour) use ($IT4,$IT4Usage){
                                                                    if($IT4Usage == 'class'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                      $ITFour->orWhere('ITSkills', 'LIKE', '%'.$IT4.'/£work'.'%');
                                                                    }
                                                                    if($IT4Usage == 'work'){
                                                                      $ITFour->where('ITSkills', 'LIKE', '%'.$IT4.'/£'.$IT4Usage.'%');
                                                                    }
                                                                   })
                                                                  ->where(function($ITFive) use ($IT5,$IT5Usage){
                                                                    if($IT5Usage == 'class'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                      $ITFive->orWhere('ITSkills', 'LIKE', '%'.$IT5.'/£work'.'%');
                                                                    }
                                                                    if($IT5Usage == 'work'){
                                                                      $ITFive->where('ITSkills', 'LIKE', '%'.$IT5.'/£'.$IT5Usage.'%');
                                                                    }
                                                                   })
                                                                  ->get())

      ->with('candidates', candidate::where('interviewStatut','10')->orWhere('interviewStatut', '18')
                                                                   ->orWhere('interviewStatut', '19')
                                                                   ->orWhere('interviewStatut', '20')
                                                                   ->orWhere('interviewStatut', '21')
                                                                   ->orWhere('interviewStatut', '22')
                                                                   ->orWhere('interviewStatut', '23')
                                                                   ->orWhere('interviewStatut', '24')
                                                                   ->orWhere('interviewStatut', '25')
                                                                   ->get())
      ->with('candidateDetails', candidateDetails::where(function($contract) use ($contractType){
                                                                        $contract->where('contractTypePermanent', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTH', 'LIKE', $contractType);
                                                                        $contract->orWhere('contractTypeTemporary', 'LIKE', $contractType);
                                                                    })

                                                 ->where(function($start) use ($startDate){
                                                      $start->where('availability', '<=', $startDate);
                                                   })

                                                 ->where(function($salary) use ($budget){
                                                      $salary->whereBetween('salaryExpectations', [0,$budget*1.05]);
                                                   })
                                                 ->where(function($occupation) use ($occupationRate){
                                                      $occupation->where('partTimeMin', '<=', $occupationRate);
                                                      $occupation->where('partTimeMax', '>=', $occupationRate);
                                                   })
                                                 ->where(function($mobility) use ($positionAddress){

                                                      })

                                                 ->where(function($permit) use ($visaSponsor){
                                                   if($visaSponsor == 'No'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                    }
                                                   if($visaSponsor == 'Yes'){
                                                      $permit->where('workPermit', 'LIKE', 'Yes');
                                                      $permit->orWhere('workPermit', 'LIKE', 'No');
                                                    }
                                                   })
                                                 ->get())

      ->with('companyInterviews', companyInterviews::where('company_vacancy',$vacancyId)->get())
      ->with('companyInterviewFeedback', companyInterviewFeedback::where('company_id_user',$company_id_user)->get());
    }
    else {
      return View::make('404',[
      ]);
    }

}


public function adminCompanySelected(Request $request){
  $id_user = $request->user()->id;
  $company_id_user = Input::get('company_id_user');
  $companyUserIdUser = Input::get('companyUserIdUser');
  $companyType = Input::get('companyType');

  $companies = DB::table('companies')->where('id_user',$company_id_user)->update( array(
      'statut' => '2',
      'companyType' => $companyType,
    ));


  $companies = DB::table('companies')->where('id_user',$company_id_user)->first();
  $companyUsers = DB::table('companyUsers')->where('id_user',$companyUserIdUser)->first();

  Mail::send('email.companyProfileValidatedAdmin',['companyUsers' => $companyUsers],function($mail) use ($companyUsers) {
    $mail->to($companyUsers->user_email)->from('no-reply@tietalent.com')->subject('Recruit now on TieTalent!');
  });
  $grade = $request->user()->grade;

  if($grade == 4){
          return View::make('adminplatform/companies',[

          ])->with('candidates', candidate::all())
            ->with('companies', company::all())
            ->with('partners', partner::all());
        }
        else {
          return View::make('404',[
          ]);
        }
    }


public function adminCompanyNotSelected(Request $request){
  $id_user = $request->user()->id;
  $company_id = Input::get('company_id');
  $companyUserIdUser = Input::get('companyUserIdUser');
  $companyUsers = DB::table('companyUsers')->where('id_user',$companyUserIdUser)->first();

  $reasonNotValidated =  $request->input('reasonNotValidated');
  $otherDivisionMatch = $request->input('toKeepForDivision');
  $otherLocationMatch = $request->input('toKeepForLocation');

  if( $reasonNotValidated === 'noSerious') {
  $companies = DB::table('companies')->where('id',$company_id)->update( array(
    'statut' => '4',
    'reasonNotValidated' => $reasonNotValidated,
    ));


  Mail::send('email.companyNotValidated',['companyUsers' => $companyUsers],function($mail) use ($companyUsers) {
    $mail->to($companyUsers->user_email)->from('no-reply@tietalent.com')->subject('No matching candidates - today');
  });
}

  if( $reasonNotValidated === 'noDivision') {
  $companies = DB::table('companies')->where('id',$company_id)->update( array(
    'statut' => '4',
    'reasonNotValidated' => $reasonNotValidated,
    'otherDivisionMatch' => $otherDivisionMatch,
    ));

    Mail::send('email.companyNoDivision',['companyUsers' => $companyUsers],function($mail) use ($companyUsers) {
      $mail->to($companyUsers->user_email)->from('no-reply@tietalent.com')->subject('Division not open - today');
    });
}

if( $reasonNotValidated === 'noLocation') {
$companies = DB::table('companies')->where('id',$company_id)->update( array(
  'statut' => '4',
  'reasonNotValidated' => $reasonNotValidated,
  'otherLocationMatch' => $otherLocationMatch,
  ));

  Mail::send('email.companyNoLocation',['companyUsers' => $companyUsers],function($mail) use ($companyUsers) {
    $mail->to($companyUsers->user_email)->from('no-reply@tietalent.com')->subject('Location not open - today');
  });
}

$grade = $request->user()->grade;

if($grade == 4){
  return View::make('adminplatform/partners',[

  ])->with('candidates', candidate::all())
    ->with('companies', company::all())
    ->with('partners', partner::all());
 }
 else {
   return View::make('404',[
   ]);
 }

}


public function adminCompanyNotReachable(Request $request){
  $company_id_user = Input::get('company_id_user');
  $companyUserIdUser = Input::get('companyUserIdUser');

  $companies = DB::table('companies')->where('id_user',$company_id_user)->update( array(
      'statut' => '3',
    ));
    $grade = $request->user()->grade;

    if($grade == 4){
      return View::make('adminplatform/partners',[

      ])->with('candidates', candidate::all())
        ->with('companies', company::all())
        ->with('partners', partner::all());
      }
      else {
        return View::make('404',[
        ]);
      }

}


public function admin_deletePartner(Request $request){
  $idUser = Input::get('idUser');

  DB::table('users')->where('id', $idUser)->delete();
  DB::table('partners')->where('id_user', $idUser)->delete();
  DB::table('partnerInviteFriends')->where('id_user', $idUser)->delete();
  DB::table('partnerInviteCompany')->where('id_user', $idUser)->delete();
  DB::table('partnerInfos')->where('id_user', $idUser)->delete();
  DB::table('partnerDocuments')->where('id_user', $idUser)->delete();
  DB::table('partnerDetails')->where('id_user', $idUser)->delete();

  $file_delete = storage_path()."/app/documents/".$idUser;

  File::Delete($file_delete);

  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/partners',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerDetails', partnerDetails::all());
    }
    else {
      return View::make('404',[
      ]);
    }
}


public function admin_deleteCandidate(Request $request){
  $idUser = Input::get('idUser');

  DB::table('users')->where('id', $idUser)->delete();
  DB::table('candidateDetails')->where('id_user', $idUser)->delete();
  DB::table('candidateDocuments')->where('id_user', $idUser)->delete();
  DB::table('candidateInfos')->where('id_user', $idUser)->delete();
  DB::table('candidateInviteCompany')->where('id_user', $idUser)->delete();
  DB::table('candidateInviteFriends')->where('id_user', $idUser)->delete();
  DB::table('candidateReferences')->where('id_user', $idUser)->delete();
  DB::table('candidates')->where('id_user', $idUser)->delete();

  $file_delete = storage_path()."/app/documents/".$idUser;

  File::Delete($file_delete);

  $nbCandidates= AdminPlatform::getNbCandidates();

  $grade = $request->user()->grade;
  $min = 0;

  if($grade == 4){
    return View::make('adminplatform/candidates',[
      'min'=>$min,
      'nbCandidates'=>$nbCandidates,
    ])->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all());
    }
    else {
      return View::make('404',[
      ]);
    }
}


public function admin_deleteCompany(Request $request){
  $idUser = Input::get('idUser');

  DB::table('users')->where('id', $idUser)->delete();
  DB::table('companies')->where('id_user', $idUser)->delete();
  DB::table('companyDetails')->where('id_user', $idUser)->delete();
  DB::table('companyInfos')->where('id_user', $idUser)->delete();
  DB::table('companyInviteCompany')->where('id_user', $idUser)->delete();
  DB::table('companyInviteFriends')->where('id_user', $idUser)->delete();
  DB::table('companyUsers')->where('id_user', $idUser)->delete();
  DB::table('companyVacancies')->where('id_user', $idUser)->delete();
  DB::table('offices')->where('id_user', $idUser)->delete();




  $grade = $request->user()->grade;

  if($grade == 4){
    return View::make('adminplatform/companies',[

    ])->with('candidates', candidate::all())
      ->with('companies', company::all())
      ->with('partners', partner::all());
    }
  else {
    return View::make('404',[
    ]);
  }
}




public function adminMailTest(Request $request){
  $user = $request->user();

  App::setLocale('en');

  Mail::send('email.prospectDemoRequest',['user' => $user],function($mail) use ($user) {
    $mail->to('mtrillou@gmail.com')->from('no-reply@tietalent.com')->subject(trans('prospectDemoRequest.subject'));
  });


  $grade = $request->user()->grade;
  $min = 0;

  $nbCandidates= AdminPlatform::getNbCandidates();

  if($grade == 4){
    return View::make('adminplatform/candidates',[
      'min'=>$min,
      'nbCandidates'=>$nbCandidates,
    ])->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all());
    }
  }



public function shortListGetMoreInformation(Request $request){

    $inputPo = $request->input('inputPo');
    $inputAlex = $request->input('inputAlex');
    $inputBuzz = $request->input('inputBuzz');
    $url = $request->input('url');

    Mail::send('email.adminShortListMoreInformation',['inputPo' => $inputPo, 'inputAlex' => $inputAlex, 'inputBuzz' => $inputBuzz, 'url' => $url],function($mail) use ($inputPo) {
      $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('A company would like to get more information on the shortlist sent!');
    });

    return View::make('company/welcomecompany',[
    ]);
  }



}
