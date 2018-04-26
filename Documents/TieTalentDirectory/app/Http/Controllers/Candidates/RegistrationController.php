<?php

namespace App\Http\Controllers\Candidates;
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
use App\candidateInfos;
use App\candidateReferral;
use App\candidateInviteFriends;
use App\candidateInviteCompany;
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
use App\linkedCandidateVacancy;
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

    public function registration_candidate_step($token){
        return view('candidateplatform.registrationform')->with('token', $token);
    }


    public function registration_candidate_step_post(Request $request){
        $shareLink = str_random(11);

        $token = str_random(64);


        $userfind = User::create([
            'email' => $request['candidate_email'],
            'password' => $request['password'],
            'token' => $token,
        ]);

        $userfind->grade = 1;
        $userfind->language = $request['locale'];
        $userfind->save();

        $id_user = $userfind->id;

        $user = new candidate;
        $user->id_user = $id_user;
        $user->firstName = Input::get('firstName');
        $user->lastName = Input::get('lastName');
        $user->candidate_email = Input::get('candidate_email');
        $user->candidate_skype = Input::get('candidate_skype');
        $user->candidateReferralShareCode = Input::get('candidateReferralShareCode');
        $user->communication = 5;
        $user->avatar = 'default.jpg';
        $user->interviewStatut = 1;
        $user->otherDivisionMatch = '';
        $user->opportunitiesStatut = 0;
        $user->activeJobSearchEmailStatut = '';
        $user->lastActiveJobSearchEmail = new DateTime('now');
        $user->save();



        $candidateDocuments = new candidateDocuments();
        $candidateDocuments->id_user = $id_user;


        if(!is_null(request()->file('document'))){
          $candidateDocuments->id_user = $id_user;

          $file = request()->file('document');
          $docLanguage = $request->input('docLanguage');
          $docExt = $file->guessClientExtension();

          $file->storeAs('documents/' . $id_user, "CV".$docLanguage.".".$docExt);
          $storage_path = 'app/documents/'.$id_user.'/CV'.$docLanguage;
          $fileName = "CV".$docLanguage.".".$docExt;

          $candidateDocuments->docType = 'CV';
          $candidateDocuments->docLanguage = $docLanguage;
          $candidateDocuments->storage_path = $storage_path;
          $candidateDocuments->docExt = $docExt;
          $candidateDocuments->fileName = $fileName;


          $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
            'interviewStatut' => '2',
              ));

        }

        $candidateDocuments->save();



        $candidateInfos = new candidateInfos();
        $candidateInfos->id_user = $id_user;
        $candidateInfos->shareLink = $shareLink;
        $candidateInfos->confidentiality = 0;
        $candidateInfos->save();

        $candidateInviteFriends = new candidateInviteFriends();
        $candidateInviteFriends->id_user = $id_user;
        $candidateInviteFriends->save();

        $candidateInviteCompany = new candidateInviteCompany();
        $candidateInviteCompany->id_user = $id_user;
        $candidateInviteCompany->save();



        $partTime = $request['partTime'];
        $partTimeMin = explode(',',trim($partTime))[0];
        $partTimeMax = explode(',',trim($partTime))[1];

        $candidateDetails = new candidateDetails();
        $candidateDetails->id_user = $id_user;
        /*$candidateDetails->companytype = $request['companytype'];
        $candidateDetails->companytypeOther = $request['companytype_other'];*/
        $candidateDetails->division = $request['division'];
        $candidateDetails->divisionOther = $request['division_other'];
        $candidateDetails->department = $request['department'];
        $candidateDetails->departmentOther = $request['department_other'];
        $candidateDetails->function = $request['function'];
        $candidateDetails->functionOther = $request['function_other'];
        $candidateDetails->salaryExpectations = $request['salaryExpectations'];
        /*$candidateDetails->job = $request['job'];*/
        $candidateDetails->availability = $request['availability'];
        $candidateDetails->contractTypePermanent = $request['contractTypePermanent'];
        $candidateDetails->contractTypeTH = $request['contractTypeTH'];
        $candidateDetails->contractTypeTemporary = $request['contractTypeTemporary'];
        $candidateDetails->partTimeMin = $partTimeMin;
        $candidateDetails->partTimeMax = $partTimeMax;
        $candidateDetails->reasonJobSearch = $request['reasonJobSearch'];
        $candidateDetails->address = $request['candidateAddress'];
        $candidateDetails->car = $request['car'];
        $candidateDetails->mobility = $request['mobility'];
        $candidateDetails->workPermit = $request['workPermit'];
        $candidateDetails->linkedIn = $request['linkedIn'];
        $candidateDetails->save();

        App::setLocale($userfind->language);

        Mail::send('email.register',['user' => $user, 'token' => $token, 'sharelink' => $candidateInfos->shareLink],function($mail) use ($user) {
          $mail->to($user['candidate_email'],$user['firstName'])->from('no-reply@tietalent.com')->subject('Welcome');
        });

        return view("/successfulSignUp");
    }




    public function registration_candidate_step_post2(Request $request){
        $shareLink = str_random(11);

        $token = str_random(64);


        $userfind = User::create([
            'email' => $request['candidate_email'],
            'password' => $request['password'],
            'token' => $token,
        ]);

        $userfind->grade = 1;
        $userfind->language = $request['locale'];
        $userfind->save();

        $id_user = $userfind->id;

        $user = new candidate;
        $user->id_user = $id_user;
        $user->firstName = Input::get('firstName');
        $user->lastName = Input::get('lastName');
        $user->candidate_email = Input::get('candidate_email');
        $user->candidate_skype = Input::get('candidate_skype');
        $user->candidateReferralShareCode = Input::get('candidateReferralShareCode');
        $user->communication = 5;
        $user->avatar = 'default.jpg';
        $user->interviewStatut = 1;
        $user->otherDivisionMatch = '';
        $user->opportunitiesStatut = 0;
        $user->activeJobSearchEmailStatut = '';
        $user->lastActiveJobSearchEmail = new DateTime('now');
        $user->save();



        $candidateInfos = new candidateInfos();
        $candidateInfos->id_user = $id_user;
        $candidateInfos->shareLink = $shareLink;
        $candidateInfos->confidentiality = 0;
        $candidateInfos->save();

        function multiexplode ($delimiters,$data) {
        	$MakeReady = str_replace($delimiters, $delimiters[0], $data);
        	$Return    = explode($delimiters[0], $MakeReady);
        	return  $Return;
        }
        $data = $request['invite'];

        $invite = multiexplode(array(","," ",";"),$data);

        //$invite = explode(';',explode(',',$request['invite']));



        foreach ($invite as $singleMail) {


          $userDB=DB::table('users')
              ->where('email','=',$singleMail)
              ->count();

          if($userDB > 0){

          }

          else {

            if (filter_var($singleMail, FILTER_VALIDATE_EMAIL)) {

              $firstName = Input::get('firstName');
              $lastName = Input::get('lastName');

              $candidateReferral = new candidateReferral;
              $candidateReferral->tietalentUser_id_user = $id_user;
              $candidateReferral->tietalentUser_email = Input::get('candidate_email');
              $candidateReferral->referred_email = $singleMail;
              $candidateReferral->save();



              Mail::send('email.referral',['singleMail' => $singleMail,'firstName' => $firstName, 'lastName' => $lastName],function($mail) use ($singleMail, $firstName, $lastName) {
                $mail->to($singleMail)->from('no-reply@tietalent.com')->subject($firstName . ' ' . $lastName . ' ' . 'is inviting you on TieTalent');
              });

            }

                else {


                }

          }


        }




        $candidateDocuments = new candidateDocuments();
        $candidateDocuments->id_user = $id_user;


        if(!is_null(request()->file('document'))){
          $candidateDocuments->id_user = $id_user;

          $file = request()->file('document');
          $docLanguage = $request->input('docLanguage');
          $docExt = $file->guessClientExtension();

          $file->storeAs('documents/' . $id_user, "CV".$docLanguage.".".$docExt);
          $storage_path = 'app/documents/'.$id_user.'/CV'.$docLanguage;
          $fileName = "CV".$docLanguage.".".$docExt;

          $candidateDocuments->docType = 'CV';
          $candidateDocuments->docLanguage = $docLanguage;
          $candidateDocuments->storage_path = $storage_path;
          $candidateDocuments->docExt = $docExt;
          $candidateDocuments->fileName = $fileName;


          $candidates = DB::table('candidates')->where('id_user',$id_user)->update( array(
            'interviewStatut' => '2',
              ));

        }

        $candidateDocuments->save();





        $candidateInviteFriends = new candidateInviteFriends();
        $candidateInviteFriends->id_user = $id_user;
        $candidateInviteFriends->save();

        $candidateInviteCompany = new candidateInviteCompany();
        $candidateInviteCompany->id_user = $id_user;
        $candidateInviteCompany->save();



        $partTime = $request['partTime'];
        $partTimeMin = explode(',',trim($partTime))[0];
        $partTimeMax = explode(',',trim($partTime))[1];

        $candidateDetails = new candidateDetails();
        $candidateDetails->id_user = $id_user;
        /*$candidateDetails->companytype = $request['companytype'];
        $candidateDetails->companytypeOther = $request['companytype_other'];*/
        $candidateDetails->division = $request['division'];
        $candidateDetails->divisionOther = $request['division_other'];
        $candidateDetails->department = $request['department'];
        $candidateDetails->departmentOther = $request['department_other'];
        $candidateDetails->function = $request['function'];
        $candidateDetails->functionOther = $request['function_other'];
        $candidateDetails->salaryExpectations = $request['salaryExpectations'];
        /*$candidateDetails->job = $request['job'];*/
        $candidateDetails->availability = $request['availability'];
        $candidateDetails->contractTypePermanent = $request['contractTypePermanent'];
        $candidateDetails->contractTypeTH = $request['contractTypeTH'];
        $candidateDetails->contractTypeTemporary = $request['contractTypeTemporary'];
        $candidateDetails->partTimeMin = $partTimeMin;
        $candidateDetails->partTimeMax = $partTimeMax;
        $candidateDetails->reasonJobSearch = $request['reasonJobSearch'];
        $candidateDetails->address = $request['candidateAddress'];
        $candidateDetails->car = $request['car'];
        $candidateDetails->mobility = $request['mobility'];
        $candidateDetails->workPermit = $request['workPermit'];
        $candidateDetails->linkedIn = $request['linkedIn'];
        $candidateDetails->save();

        App::setLocale($userfind->language);

        Mail::send('email.register',['user' => $user, 'token' => $token, 'sharelink' => $candidateInfos->shareLink],function($mail) use ($user) {
          $mail->to($user['candidate_email'],$user['firstName'])->from('no-reply@tietalent.com')->subject('Welcome');
        });

        return view("/successfulSignUp");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registration_candidate(Request $request) {


        $user = User::where('email', '=', Input::get('candidate_email'))->first();

        if ($user === null) {
          $firstName = $request['firstName'];
          $lastName = $request['lastName'];
          $candidate_email = $request['candidate_email'];
          $password = bcrypt($request['password']);

          return View::make("/candidateplatform/registrationform",[
            'firstName'=>$firstName,
            'lastName'=>$lastName,
            'candidate_email'=>$candidate_email,
            'password'=>$password,
          ]);

        }

        else {
          $firstName = $request['firstName'];
          $lastName = $request['lastName'];
          $candidate_email = $request['candidate_email'];
          return view('signup')->withEmail($candidate_email)->withFname($firstName)->withLname($lastName)->withMessage(' is already used. Please insert another email address.');

        }
      }




}
