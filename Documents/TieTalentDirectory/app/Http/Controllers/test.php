<?php

namespace App\Http\Controllers;
use DateTime;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\candidate;
use App\company;
use App\partner;
use Mail;
use App\User;
use DB;
use App\candidateDetails;
use App\candidateInfos;
use App\candidateInviteFriends;
use App\candidateInviteCompany;
use App\candidateDocuments;
use App\companyDetails;
use App\companyUsers;
use App\companyInfos;
use App\companyInviteFriends;
use App\companyInviteCompany;
use App\office;
use App\partnerDetails;
use App\partnerInfos;
use App\partnerDocuments;
use App\partnerInviteFriends;
use App\partnerInviteCompany;
use App\partnerInterviewFeedback;
use App\adminInterviews;
use App\candidateReferences;
use View;

use Illuminate\Support\Facades\Input;

class test extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("candidate/welcomecandidate");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


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
        $candidateDetails->companytype = $request['companytype'];
        $candidateDetails->companytypeOther = $request['companytype_other'];
        $candidateDetails->division = $request['division'];
        $candidateDetails->divisionOther = $request['division_other'];
        $candidateDetails->department = $request['department'];
        $candidateDetails->departmentOther = $request['department_other'];
        $candidateDetails->function = $request['function'];
        $candidateDetails->functionOther = $request['function_other'];
        $candidateDetails->salaryExpectations = $request['salaryExpectations'];
        $candidateDetails->job = $request['job'];
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
          return redirect()->back();
        }
      }


      public function candidate_reference(Request $request){

        $candidareReferences = new candidateReferences();
        $candidareReferences->id_user = $request->input('candidateIdUser');
        $candidareReferences->refereeFirstName =  $request->input('refereeFirstName');
        $candidareReferences->refereeLastName =  $request->input('refereeLastName');
        $candidareReferences->refereePosition =  $request->input('refereePosition');
        $candidareReferences->refereeCompany =  $request->input('refereeCompany');
        $candidareReferences->experienceLength =  $request->input('experienceLength');
        $candidareReferences->responsibilities =  $request->input('responsibilities');
        $candidareReferences->integration =  $request->input('integration');
        $candidareReferences->workQuality =  $request->input('workQuality');
        $candidareReferences->hireAgain =  $request->input('hireAgain');
        $candidareReferences->comments =  $request->input('comments');
        $candidareReferences->save();

        return View::make("thanksForReference",[

        ]);

      }


      public function candidate_newReference(Request $request){

        $candidateIdUser = $request->input('candidateIdUser');
        $token = $request->input('token');
        $refereeFirstName = $request->input('refereeFirstName');
        $refereeLastName = $request->input('refereeLastName');
        $refereePosition = $request->input('refereePosition');
        $refereeCompany = $request->input('refereeCompany');
        $experienceLength = $request->input('experienceLength');
        $responsibilities = $request->input('responsibilities');
        $integration = $request->input('integration');
        $workQuality = $request->input('workQuality');
        $hireAgain = $request->input('hireAgain');
        $comments = $request->input('comments');

        $candidateReferences = DB::table('candidateReferences')->where('id_user', $candidateIdUser)->where('token', $token)->first();
        $candidates = DB::table('candidates')->where('id_user', $candidateIdUser)->first();

        DB::table('candidateReferences')->where('id_user', $candidateIdUser)->where('token', $token)->update( array(
          'active' => '1',
          'refereeFirstName' => $refereeFirstName,
          'refereeLastName' => $refereeLastName,
          'refereePosition' => $refereePosition,
          'refereeCompany' => $refereeCompany,
          'experienceLength' => $experienceLength,
          'responsibilities' => $responsibilities,
          'integration' => $integration,
          'workQuality' => $workQuality,
          'hireAgain' => $hireAgain,
          'comments' => $comments,
          'referenceStatut' => 'Given',
          'token' => '',
          'updated_at' => new DateTime('now'),
         ));



        return View::make("thanksForReference",[

        ]);

      }


      public function candidate_deleteReferences(Request $request){

        $candidateIdUser = $request->input('candidateIdUser');
        $referenceId = $request->input('referenceId');

        DB::table('candidateReferences')->where('id_user',$candidateIdUser)->where('id',$referenceId)->update( array(
          'active' => '2',
          'updated_at' => new DateTime('now'),
         ));

        return back();

      }


      public function emailNewReference(Request $request){

        $candidateIdUser = $request->input('candidateIdUser');
        $refereeFirstName = $request->input('refereeFirstName');
        $refereeLastName = $request->input('refereeLastName');
        $refereeEmail = $request->input('refereeEmail');
        $refereePosition = $request->input('refereePosition');
        $refereeCompany = $request->input('refereeCompany');

        $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

        $candidateReferences = DB::table('candidateReferences')->where('id_user',$candidateIdUser)->where('refereeEmail',$refereeEmail)->update( array(
          'referenceStatut' => 'Email sent',
          'updated_at' => new DateTime('now'),
        ) );


        $candidateReferences = DB::table('candidateReferences')->where('id_user',$candidateIdUser)->where('refereeEmail',$refereeEmail)->first();
        $candidateDetails = DB::table('candidateDetails')->where('id_user',$candidateIdUser)->first();
        $candidateInfos = DB::table('candidateInfos')->where('id_user',$candidateIdUser)->first();

        Mail::send('email.newReference',[

          'candidates'=>$candidates,
          'candidateReferences'=>$candidateReferences,

        ],function($message) use ($candidateReferences, $candidates){
          $message->to($candidateReferences->refereeEmail)->from('no-reply@tietalent.com')->subject('Reference for ' . $candidates->firstName . ' ' . $candidates->lastName);
        });



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



      public function seeReference(Request $request){
        $candidateIdUser = $request->input('candidateIdUser');
        $referenceId = $request->input('referenceId');

        $candidateReferences = DB::table('candidateReferences')->where('id_user',$candidateIdUser)
                                                               ->where('id',$referenceId)
                                                               ->first();

       $candidates = DB::table('candidates')->where('id_user',$candidateIdUser)->first();

        return View::make("/seeReference",[
          'candidates'=>$candidates,
          'candidateReferences'=>$candidateReferences,
        ]);

      }



      public function company_seeReference(Request $request){
        $candidateIdUser = $request->input('candidateIdUser');
        $candidateFirstName = $request->input('candidateFirstName');
        $candidateLastName = $request->input('candidateLastName');
        $firstNameReference = $request->input('firstNameReference');
        $lastNameReference = $request->input('lastNameReference');
        $positionReference = $request->input('positionReference');
        $companyReference = $request->input('companyReference');
        $candidateReferences = DB::table('candidateReferences')->where('id_user',$candidateIdUser)
                                                               ->where('refereeFirstName','LIKE', '%'.$firstNameReference.'%')
                                                               ->where('refereeLastName','LIKE', '%'.$lastNameReference.'%')
                                                               ->first();
        return View::make("/seeReference",[
          'candidateFirstName'=>$candidateFirstName,
          'candidateLastName'=>$candidateLastName,
          'firstNameReference'=>$firstNameReference,
          'lastNameReference'=>$lastNameReference,
          'positionReference'=>$positionReference,
          'companyReference'=>$companyReference,
          'candidateReferences'=>$candidateReferences,
        ]);

      }



    public function valid($token){
        $user = DB::table('users')->select('token')->where('token', $token)->first();
        if($user){
            DB::table('users')
                ->where('token', $token)
                ->update(['active' => 1, 'token' => '']);

            return redirect('/emailValidated');
        }else{
            return 'ko';
        }
    }


    public function reference(Request $request){
        $candidateIdUser = $request->input('candidateIdUser');
        $token = $request->input('token');

        $candidateReferences = DB::table('candidateReferences')->where('id_user', $candidateIdUser)->where('token', $token)->first();
        $candidates = DB::table('candidates')->where('id_user', $candidateIdUser)->first();

        if($candidateReferences){
          return View::make("/newReference",[
            'candidates'=>$candidates,
            'candidateReferences'=>$candidateReferences,
          ]);

        }
        else{
            return View::make("/404",[
              ]);
        }
    }


    public function activeJobSearch(Request $request){
        $candidateIdUser = $request->input('candidateIdUser');
        $activeJobSearch = $request->input('activeJobSearch');
        $activeJobSearchEmailStatut = $request->input('activeJobSearchEmailStatut');
        $lastActiveJobSearchEmail = new DateTime('now');

        $candidates = DB::table('candidates')->where('id_user', $candidateIdUser)->update(array(
          'activeJobSearch' => $activeJobSearch,
          'activeJobSearchEmailStatut' => $activeJobSearchEmailStatut,
          'lastActiveJobSearchEmail' => $lastActiveJobSearchEmail,
            ));

        if($activeJobSearch == '2') {
          $candidateDetails = DB::table('candidateDetails')->where('id_user', $candidateIdUser)->update(array(
            'availability'=>"3",
          ));

          return View::make("/thankYouForTheInformationNotLooking",[
            ]);
        }

        if($activeJobSearch == '1') {
          return View::make("/thankYouForTheInformation",[
            ]);
        }

    }



    public function demoRequest(Request $request) {

        $firstName = $request['firstName'];
        $lastName = $request['lastName'];
        $email = $request['email'];
        $phone = $request['phone'];
        $company = $request['company'];
        $position = $request['position'];

        Mail::send('email.adminDemoRequest',['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phone' => $phone, 'company' => $company, 'position' => $position],function($mail) {
          $mail->to('info@tietalent.com')->from('no-reply@tietalent.com')->subject('Demo Request');
        });

        Mail::send('email.prospectDemoRequest',['firstName' => $firstName, 'email' => $email],function($mail) use ($email){
          $mail->to($email)->from('no-reply@tietalent.com')->subject('Demo Request');
        });

        return redirect()->back();
      }



    public function registration_company(Request $request){

      $user = User::where('email', '=', Input::get('company_email'))->first();

      if ($user === null) {
        $firstName = $request['firstName'];
        $lastName = $request['lastName'];
        $company = $request['company'];
        $company_email = $request['company_email'];
        $phone = $request['phone'];
        $password = bcrypt($request['password']);

        return View::make("/companyplatform/registrationform",[
          'firstName'=>$firstName,
          'lastName'=>$lastName,
          'company'=>$company,
          'company_email'=>$company_email,
          'phone'=>$phone,
          'password'=>$password,
        ]);

        }

          else {
            return redirect()->back();
          }
      }

      public function registration_company_step($token){
          return view('companyplatform.registrationform')->with('token', $token);
      }


      public function registration_company_step_post(Request $request){

          $token = str_random(64);
          $shareLink = str_random(11);

          $userfind = User::create([
              'email' => $request['company_email'],
              'password' => $request['password'],
              'token' => $token,
          ]);
          $userfind->grade = 2;
          $userfind->save();

          $id_user = $userfind->id;

          $user = new company;
          $user->id_user = $id_user;
          $user->statut = '1';
          $user->company = Input::get('company');
          $user->company_email = Input::get('company_email');
          $user->avatar = 'default.jpg';
          $user->companyReferralShareCode = '';
          $user->save();

          $companyUser = new companyUsers;
          $companyUser->id_user = $id_user;
          $companyUser->firstName = Input::get('firstName');
          $companyUser->lastName = Input::get('lastName');
          $companyUser->company = Input::get('company');
          $companyUser->user_email = Input::get('company_email');
          $companyUser->user_phone = Input::get('phone');
          $companyUser->shareLink = $shareLink;
          $companyUser->save();


          $company = new companyDetails();
          $company->id_user = $id_user;
          $company->companyType = $request['companyType'];
          $company->companyType_other = $request['companyType_other'];
          $company->numberEmployeesWorld = $request['numberEmployeesWorld'];
          $company->companyHQ = $request['companyHQ'];
          $company->listed = $request['listed'];
          $company->save();

          $companyInviteFriends = new companyInviteFriends();
          $companyInviteFriends->id_user = $id_user;
          $companyInviteFriends->save();

          $companyInviteCompany = new companyInviteCompany();
          $companyInviteCompany->id_user = $id_user;
          $companyInviteCompany->save();

          $companyInfos = new companyInfos();
          $companyInfos->id_user = $id_user;
          $companyInfos->save();

          if($request['companywebsite'] = ''){
            $companies = DB::table('companies')->where('id_user',$id_user)->update( array(
              'website' => '-',
              'companyReferralShareCode' => $request['companyReferralShareCode'],
                ));
              }
          else {
            $companies = DB::table('companies')->where('id_user',$id_user)->update( array(
              'website' => $request['companywebsite'],
              'companyReferralShareCode' => $request['companyReferralShareCode'],
                ));
              }


          $office = new office();
          $office->id_user = $id_user;
          $office->officeRole = $request['officeRole'];
          $office->officeRole_other = $request['officeRole_other'];
          $office->officeAddress = $request['officeAddress'];
          $office->numberEmployeesOffice = $request['numberEmployeesOffice'];
          $office->officeAddress = $request['officeAddress'];
          $office->officeDepartmentFinanceAccounting = $request['officeDepartmentFinanceAccounting'];
          $office->officeDepartmentHR = $request['officeDepartmentHR'];
          $office->officeDepartmentSalesMarketingCommunications = $request['officeDepartmentSalesMarketingCommunications'];
          $office->officeDepartmentIT = $request['officeDepartmentIT'];
          $office->officeDepartmentOfficeSupport = $request['officeDepartmentOfficeSupport'];
          $office->officeDepartmentLegal = $request['officeDepartmentLegal'];
          $office->officeDepartmentmentSupplyChain = $request['officeDepartmentmentSupplyChain'];
          $office->officeDepartmentOther = $request['officeDepartmentOther'];
          $office->officeDepartment_other = $request['officeDepartment_other'];
          $office->numberRecruitment = $request['numberRecruitment'];
          $office->vacancyToFill = $request['vacancyToFill'];
          $office->vacancyDepartmentFinanceAccounting = $request['vacancyDepartmentFinanceAccounting'];
          $office->vacancyDepartmentHR = $request['vacancyDepartmentHR'];
          $office->vacancyDepartmentSalesMarketingCommunications = $request['vacancyDepartmentSalesMarketingCommunications'];
          $office->vacancyDepartmentIT = $request['vacancyDepartmentIT'];
          $office->vacancyDepartmentOfficeSupport = $request['vacancyDepartmentOfficeSupport'];
          $office->vacancyDepartmentLegal = $request['vacancyDepartmentLegal'];
          $office->vacancyDepartmentmentSupplyChain = $request['vacancyDepartmentmentSupplyChain'];
          $office->vacancyDepartmentOther = $request['vacancyDepartmentOther'];
          $office->vacancyDepartment_other = $request['vacancyDepartment_other'];

          $office->save();

          Mail::send('email.registerCompany',['user' => $user, 'token' => $token],function($mail) use ($user) {
            $mail->to($user['company_email'])->from('no-reply@tietalent.com')->subject('Welcome');
          });

          return view("/successfulSignUpCompanies");


      }


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
              return redirect()->back();
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

            Mail::later(180,'email.register',['user' => $user, 'token' => $token],function($mail) use ($user) {
              $mail->to($user['partner_email'],$user['firstName'])->from('no-reply@tietalent.com')->subject('Welcome');
            });

            return view("/successfulSignUp");
        }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
