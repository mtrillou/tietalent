<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Input;
use App\User;
use App\candidate;
use App\company;
use App\partner;
use App\partnerInterviews;
use App\partnerInterviewFeedback;

use App\division;
use App\department;
use App\position;

//welcome page on public website
Route::get('/', function () {
    return view('welcome');
});

Route::get('/2', function () {
    return view('welcome2');
});


Route::get('/prodview','test@prodfunct');

Route::get('/findDepartment','test@findDepartment');

Route::get('/findPosition','test@findPosition');

Route::get('/findPrice','test@findPrice');

Route::get('/findPositionName','test@findPositionName');



Route::post('/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

Route::post('/userLanguage', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'HomeController@userLanguagePreference',
  ));

Route::post('company/userLanguage', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'HomeController@userLanguagePreference',
  ));

Route::post('partner/userLanguage', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'HomeController@userLanguagePreference',
  ));


// CronJobs
  // hourly
Route::get('/cronTest/DrJIU0QQGUcRMGAvPaBfioYMvtRW0i4zcp', function () {
/* php artisan migrate */
  \Artisan::call('email:user');
});

// daily
Route::get('/cronTest/hXXWEcBOIzYSvJtFkH82IWJKQm', function () {
/* php artisan migrate */
\Artisan::call('daily:email');
});

// cron test
Route::get('/cronTest/hXKHftvFDGRkWEcBOIzYSvJtFkH82IWJKQm', function () {
/* php artisan migrate */
\Artisan::call('test:test');
});

// 15 minutes cron
Route::get('/cronTest/hdshfTTFvCTRDGlkljsfSEWJKQm', function () {
/* php artisan migrate */
\Artisan::call('minute:email');
});






//candidate automatic emails
Route::get('/auto68753908', function () {
    return view('auto68753908');
});


//candidate shortlist
Route::get('/shortlist1001', function () {
    return view('shortlist1001');
});




//Candidates in IT
Route::get('/otherDivisionCandidates', function () {
    return View::make('adminplatform/otherDivisionCandidates',[

    ])->with('candidates', candidate::orderBy('updated_at','desc')->get());
    });


//reference test (to show Frode)
Route::get('/referenceTest', function () {
    return view('referenceTest');
});

//about page
Route::get('/about', function () {
    return view('about');
});

// testPartnerFeedbackForm
Route::get('/testPartnerFeedbackForm', 'Partners\InterviewsController@testPartnerFeedbackForm');

//sitemap

Route::get("sitemap", function() {
     $content  = View::make('sitemap');
     return Response::make($content, '200')->header('Content-Type', 'text/xml');
});

//login
Route::get('/login', function () {
    return view('login');
});

//terms & conditions + privacy policy
Route::get('/termsofservice', function () {
    return view('termsofservice');
});

Route::get('/privacypolicy', function () {
    return view('privacypolicy');
});

Route::get('/logout', 'Auth\AuthController@logout');
//Route::post('/create', 'Auth\AuthController@create');
Route::post('/login', 'Auth\AuthController@login');


Route::group(['middleware' => 'web'], function() {
  Route::auth();
  Route::get('/thankyou','HomeController@index');
});


//email validated
Route::get('/emailValidated', function () {
    return view('emailValidated');
});

//password reset
Route::get('/emailSentNewPassword', function () {
    return view('emailSentNewPassword');
});



//signup
Route::get('/signup', function () {
    return view('signup');
});

//signup partner
Route::get('/signup_partner', function () {
    return view('signup_partner');
});
Route::get('/partner/registration_partner/step/{token}', 'Partners\RegistrationController@registration_partner_step');
Route::post('/step/partner', 'Partners\RegistrationController@registration_partner_step_post');
Route::get('/partnerplatform/CVupload', function () {
    return view('partnerplatform/CVupload');
});
Route::post('CVupload', 'UploadController@upload_partnerCV');
Route::post('/partner/registration_partner', 'Partners\RegistrationController@registration_partner');
Route::post('/partner/registration_partner/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

  // CV Upload of the partner
  Route::post('upload_partner', 'UploadController@upload_partner');

  Route::get('/successfulSignUp', function () {
      return view('successfulSignUp');
  });


//candidate main page
Route::get('/candidates/welcome', function () {
    return view('candidate/welcomecandidate');
});

Route::get('/candidate/welcome', function () {
    return view('candidate/welcomecandidate');
});

Route::post('/candidates/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

Route::post('/password/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

Route::get('/valid/{token}', 'test@valid');

//reference
Route::get('/reference', 'test@reference');

//candidate active job search
Route::get('/activeJobSearch', 'test@activeJobSearch');

//candidate active job search
Route::get('/notLooking/{email}/{id}', 'test@notLooking');


//candidate signup
Route::get('/candidate/registration_candidate/step/{token}', 'Candidates\RegistrationController@registration_candidate_step');
Route::post('/step/candidate', 'Candidates\RegistrationController@registration_candidate_step_post');
Route::post('/candidate/registration_candidate', 'Candidates\RegistrationController@registration_candidate');
Route::post('/candidate/registration_candidate/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

// candidate platform
Route::post('/candidate/aboutyou', 'Candidates\HomeCandidatesController@candidate_aboutYou');
Route::post('/candidate/experiences', 'Candidates\HomeCandidatesController@candidate_experiences');
Route::post('/candidate/references', 'Candidates\HomeCandidatesController@candidate_references');
Route::post('/candidate/newReferences', 'Candidates\HomeCandidatesController@candidate_newReferences');
Route::post('/candidate/inviteFriends', 'Candidates\InviteController@candidate_inviteFriends');
Route::post('/candidate/inviteCompany', 'Candidates\InviteController@candidate_inviteCompany');
Route::get('/settings', 'Candidates\SettingsController@settings');
Route::post('/candidate/communication', 'Candidates\SettingsController@candidate_communication');
Route::post('/candidate/email', 'Candidates\SettingsController@candidate_email');
Route::post('/candidate/skype', 'Candidates\SettingsController@candidate_skype');
Route::post('/candidate/phone', 'Candidates\SettingsController@candidate_phone');
Route::post('/candidate/password', 'Candidates\SettingsController@candidate_password');
Route::post('/candidate/general', 'Candidates\SettingsController@candidate_general');
Route::post('/candidate/deactivate', 'Candidates\SettingsController@candidate_deactivate');
Route::post('/candidate/reactivate', 'Candidates\SettingsController@candidate_reactivate');
Route::post('/candidate/feedbackTieTalent', 'Candidates\SettingsController@candidate_feedbackTieTalent');
Route::post('/candidate/confidentiality', 'Candidates\SettingsController@candidate_confidentiality');
Route::post('/candidate/documents', 'Candidates\DocumentsController@candidate_document');
Route::post('/candidate/profilePicture', 'Candidates\HomeCandidatesController@candidate_profilePicture');
Route::get('/confidentiality', 'Candidates\SettingsController@confidentiality');
Route::get('/documents', 'Candidates\DocumentsController@documents');
Route::get('/interview', 'Candidates\InterviewsController@interview');
Route::post('/candidate/interviewTimes', 'Candidates\InterviewsController@candidate_interviewTimes');
Route::post('/candidate/postponeInterviewTimes', 'Candidates\InterviewsController@candidate_postponeInterviewTimes');
Route::post('/candidate/cancelInterviewTimes', 'Candidates\InterviewsController@candidate_cancelInterviewTimes');
Route::post('/candidate/confirmPartnerInterview', 'Candidates\InterviewsController@candidate_confirmPartnerInterview');
Route::post('/candidate/partnerDidNotShowUp', 'Candidates\InterviewsController@candidate_partnerDidNotShowUp');
Route::post('/candidate/interviewPartnerFeedback', 'Candidates\InterviewsController@candidate_interviewPartnerFeedback');
Route::get('candidate/partnerInterviewFeedback', 'Candidates\InterviewsController@candidate_partnerInterviewFeedback');
Route::post('/candidate/getPartnerFeedback', 'Candidates\InterviewsController@candidate_getPartnerFeedback');
Route::post('/candidate/confirmCompanyInterview', 'Candidates\InterviewsController@candidate_confirmCompanyInterview');
Route::post('/candidate/interviewCompanyTimes', 'Candidates\InterviewsController@candidate_interviewCompanyTimes');
Route::post('/candidate/confirmNotInterested', 'Candidates\OpportunitiesController@candidate_confirmNotInterested');
Route::post('candidate/companyInterviewFeedback', 'Candidates\InterviewsController@candidate_companyInterviewFeedback');
Route::post('/candidate/interviewVacancyFeedback', 'Candidates\InterviewsController@candidate_interviewVacancyFeedback');
Route::post('/candidate/getCompanyFeedback', 'Candidates\InterviewsController@candidate_getCompanyFeedback');
Route::post('/candidate/acceptOffer', 'Candidates\OpportunitiesController@candidate_acceptOffer');
Route::post('/candidate/refuseOffer', 'Candidates\OpportunitiesController@candidate_refuseOffer');
Route::get('/opportunities', 'Candidates\OpportunitiesController@opportunities');
Route::get('/faq', 'Candidates\SettingsController@faq');
Route::get('/feedback', 'Candidates\SettingsController@feedback');


// company demo request
Route::post('companies/demoRequest', 'test@demoRequest');

//company signup
Route::get('/company/registration_company/step/{token}', 'Companies\RegistrationController@registration_company_step');
Route::post('/step/company', 'Companies\RegistrationController@registration_company_step_post');
Route::post('/company/registration_company', 'Companies\RegistrationController@registration_company');
Route::post('/company/registration_company/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

//candidate faq
Route::get('/candidates/faq', function () {
    return view('candidate/faqcandidate');
});

//candidate reference
Route::get('/candidate/reference/{shareLink}/{firstName}/{lastName}/{division}/{id_user}/{referee}', function () {
    return view('/reference');
});

//candidate reference
Route::post('/candidate/reference', 'test@candidate_newReference');

Route::post('/candidate/deleteReferences', 'test@candidate_deleteReferences');

Route::post('/admin/emailReference1', 'test@emailReference1');
Route::post('/admin/seeReference1', 'test@seeReference1');
Route::post('/admin/emailReference2', 'test@emailReference2');
Route::post('/admin/seeReference2', 'test@seeReference2');
Route::post('/admin/emailReference3', 'test@emailReference3');
Route::post('/admin/seeReference3', 'test@seeReference3');
Route::post('/admin/emailReference4', 'test@emailReference4');
Route::post('/admin/seeReference4', 'test@seeReference4');
Route::post('/admin/emailReference5', 'test@emailReference5');
Route::post('/admin/seeReference5', 'test@seeReference5');

// new admin see reference
Route::post('/admin/seeReference', 'test@seeReference');

// admin see interviewfeedback
Route::post('/admin/seeInterviewFeedback', 'test@seeInterviewFeedback');


Route::post('/admin/seeLinkedCandidates', 'Admin\CandidatesController@seeLinkedCandidate');

// test new reference
Route::post('/admin/emailNewReference', 'test@emailNewReference');


// email automation
Route::post('/admin/mailAutomation', 'test@emailAutomation');

//company main page
Route::get('/companies/welcome', function () {
    return view('company/welcomecompany');
});
Route::get('/company/welcome', function () {
    return view('company/welcomecompany');
});

Route::get('/companies/pricing', function () {
    return view('company/pricing');
});
Route::get('/company/pricing', function () {
    return view('company/pricing');
});

Route::post('/company/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

Route::post('/companies/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));



//company faq
Route::get('/companies/faq', function () {
    return view('company/faqcompany');
});

//partner main page
Route::get('/partners/welcome', function () {
    return view('partner/welcomepartner');
});

Route::get('/partner/welcome', function () {
    return view('partner/welcomepartner');
});

Route::post('/partner/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

Route::post('/partners/language', array (
  'Middleware'=>'LanguageSwitcher',
  'uses'=>'LanguageController@index'
  ));

//partner faq
Route::get('/partners/faq', function () {
    return view('partner/faqpartner');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// Candidate Routes
Route::get('/invitefriends', 'Candidates\InviteController@invitefriends');
Route::get('/invitecompany', 'Candidates\InviteController@invitecompany');





// Company Routes
Route::get('/company/invitefriends', 'Companies\InviteController@companyInvitefriends');
Route::get('/company/invitecompany', 'Companies\InviteController@companyInvitecompany');
Route::get('/company/settings', 'Companies\SettingsController@companySettings');
Route::get('/company/interviews', 'Companies\InterviewsController@companyInterviews');
Route::get('/company/vacancies', 'Companies\VacanciesController@companyVacancies');


Route::get('/company/faq', 'Companies\SettingsController@companyFaq');
Route::get('/company/feedback', 'Companies\SettingsController@companyFeedback');
Route::get('/company/recruit', 'Companies\VacanciesController@companyRecruit');
Route::get('/company/newvacancyform', 'Companies\VacanciesController@companyNewVacancyForm');
Route::get('/company/newvacancyformTest', 'Companies\VacanciesController@companyNewVacancyFormTest');

// Company platform
Route::post('/company/about', 'Companies\HomeCompaniesController@company_about');
Route::post('/company/values', 'Companies\HomeCompaniesController@company_values');
Route::post('/company/feedbackTieTalent', 'Companies\SettingsController@company_feedbackTieTalent');
Route::post('/company/inviteFriends', 'Companies\InviteController@company_inviteFriends');
Route::post('/company/inviteCompany', 'Companies\InviteController@company_inviteCompany');
Route::post('/company/communication', 'Companies\SettingsController@company_communication');
Route::post('/company/userInformation', 'Companies\SettingsController@company_userInformation');
Route::post('/company/skype', 'Companies\SettingsController@company_skype');
Route::post('/company/password', 'Companies\SettingsController@company_password');
Route::post('/company/companyInformation', 'Companies\SettingsController@company_companyInformation');
Route::post('/company/profilePicture', 'Companies\HomeCompaniesController@company_profilePicture');
Route::post('/newvacancy/company', 'Companies\VacanciesController@company_newVacancy');

Route::post('/company/editVacancy', 'Companies\VacanciesController@company_editVacancy');
Route::post('/editVacancy/company', 'Companies\VacanciesController@editVacancy');

// test HR Salon
Route::post('/newvacancy/companyTest', 'Companies\VacanciesController@company_newVacancyTest');
Route::post('/company/vacancyDetailsTest', 'Companies\VacanciesController@companyVacancyDetailsTest');

Route::post('/company/vacancyDetails', 'Companies\VacanciesController@companyVacancyDetails');
Route::post('/company/closeOpportunity', 'Companies\VacanciesController@company_closeOpportunity');
Route::post('/company/deleteOpportunity', 'Companies\VacanciesController@company_deleteOpportunity');
Route::post('/company/seeCandidates', 'Companies\CandidatesController@seeCandidates');
Route::post('/company/seeLinkedCandidates', 'Companies\CandidatesController@seeCandidatesLinked');

Route::post('/company/seeCandidatesTest1', 'Companies\CandidatesController@seeCandidatesTest1');
Route::post('/company/seeCandidatesTest2', 'Companies\CandidatesController@seeCandidatesTest2');
Route::post('/company/seeCandidatesTest3', 'Companies\CandidatesController@seeCandidatesTest3');


Route::post('/company/interviewTimes', 'Companies\InterviewsController@company_interviewTimes');
Route::post('/company/seeReference', 'test@company_seeReference');
Route::post('/company/confirmCandidateInterview', 'Companies\InterviewsController@company_confirmCandidateInterview');
Route::post('/company/candidateInterviewFeedback', 'Companies\InterviewsController@company_candidateInterviewFeedback');
Route::post('/company/interviewCandidateFeedback', 'Companies\InterviewsController@company_interviewCandidateFeedback');


// Partner Routes
Route::get('/partner/invitefriends', 'Partners\InviteController@partnerInvitefriends');
Route::get('/partner/invitecompany', 'Partners\InviteController@partnerInvitecompany');
Route::get('/partner/settings', 'Partners\SettingsController@partnerSettings');
Route::get('/partner/interviews', 'Partners\InterviewsController@partnerInterviews');
Route::get('/partner/candidates', 'Partners\CandidatesController@partnerCandidates');
Route::get('/partner/documents', 'Partners\DocumentsController@partnerDocuments');
Route::get('/partner/faq', 'Partners\SettingsController@partnerFaq');
Route::get('/partner/feedback', 'Partners\SettingsController@partnerFeedback');



// Partner platform
Route::post('/partner/about', 'Partners\HomePartnersController@partner_about');
Route::post('/partner/feedbackTieTalent', 'Partners\SettingsController@partner_feedbackTieTalent');
Route::post('/partner/inviteFriends', 'Partners\InviteController@partner_inviteFriends');
Route::post('/partner/inviteCompany', 'Partners\InviteController@partner_inviteCompany');
Route::post('/partner/communication', 'Partners\SettingsController@partner_communication');
Route::post('/partner/email', 'Partners\SettingsController@partner_email');
Route::post('/partner/phone', 'Partners\SettingsController@partner_phone');
Route::post('/partner/skype', 'Partners\SettingsController@partner_skype');
Route::post('/partner/password', 'Partners\SettingsController@partner_password');
Route::post('/partner/general', 'Partners\SettingsController@partner_general');
Route::post('/partner/profilePicture', 'Partners\HomePartnersController@partner_profilePicture');
Route::post('/partner/documents', 'Partners\DocumentsController@partner_document');
Route::post('/partner/confirmAdminInterview', 'Partners\InterviewsController@partner_confirmAdminInterview');
Route::post('/partner/adminInterviewTimes', 'Partners\InterviewsController@partner_adminInterviewTimes');
Route::post('/partner/seeCandidates', 'Partners\CandidatesController@partnerSeeCandidates');
Route::post('/partner/notAvailableInterview', 'Partners\InterviewsController@partner_notAvailableInterview');
Route::post('/partner/interviewTimes', 'Partners\InterviewsController@partner_interviewTimes');
Route::post('/partner/postponeInterviewTimes', 'Partners\InterviewsController@partner_postponeInterviewTimes');
Route::post('/partner/cancelInterviewTimes', 'Partners\InterviewsController@partner_cancelInterviewTimes');

Route::post('/partner/confirmCandidateInterview', 'Partners\InterviewsController@partner_confirmCandidateInterview');
Route::post('/partner/candidateInterviewFeedback', 'Partners\InterviewsController@partner_candidateInterviewFeedback');
Route::post('/partner/interviewCandidateFeedback', 'Partners\InterviewsController@partner_interviewCandidateFeedback');
Route::post('/partner/candidateDidNotShowUp', 'Partners\InterviewsController@partner_candidateDidNotShowUp');



// Admin routes
Route::any('/search',function(){
    $q = Input::get ( 'q' );
    $candidates = candidate::where('firstName','LIKE','%'.$q.'%')->orWhere('lastName','LIKE','%'.$q.'%')->orWhere('candidate_email','LIKE','%'.$q.'%')->get();
    if(count($candidates) > 0)
    return View::make('adminplatform/candidates',[
      'min'=>'10',
      'nbCandidates'=>'169',
    ])->with('users', user::all())
      ->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all())
      ->withDetails($candidates)->withQuery ( $q );
    else return View::make('adminplatform/candidates',[
      'min'=>'10',
      'nbCandidates'=>'169',
    ])->with('candidates', candidate::orderBy('updated_at','desc')->get())
      ->with('companies', company::all())
      ->with('partners', partner::all())
      ->with('partnerInterviews', partnerInterviews::all())
      ->with('partnerInterviewFeedback', partnerInterviewFeedback::all())
      ->withMessage('No Details found. Try to search again !');
});


Route::post('/filter', 'test@adminFilter');

Route::post('/filterDivisions', 'test@adminFilterDivisions');


Route::get('/admin/partners', 'Admin\PartnersController@adminPartners');
Route::get('/admin/companies', 'Admin\CompaniesController@adminCompanies');
Route::get('/admin/candidates', 'Admin\CandidatesController@adminCandidates');
Route::post('/admin/candidates/page', 'Admin\CandidatesController@adminCandidatesPage');
Route::get('/admin/allCandidates', 'Admin\CandidatesController@adminAllCandidates');
Route::get('/admin/allCandidatesDivisions', 'Admin\CandidatesController@allCandidatesDivisions');

Route::get('/admin/candidatePartnerInterviewsPlanned', 'Admin\CandidatesController@candidatePartnerInterviewsPlanned');

Route::get('/admin/candidatePartnerInterviewsToOrganize', 'Admin\CandidatesController@candidatePartnerInterviewsToOrganize');

Route::get('/admin/recommendedCandidates', 'Admin\CandidatesController@recommendedCandidates');
Route::get('/admin/adminUserWithoutSkypeId', 'Admin\CandidatesController@adminUserWithoutSkypeId');

Route::get('/admin/openedJobs', 'Admin\CompaniesController@adminOpenedJobs');


Route::post('/admin/seeCandidates', 'Admin\CandidatesController@adminSeeCandidates');
Route::post('/admin/candidateCRMNotes', 'Admin\CandidatesController@adminCandidateCRMNotes');
Route::post('/admin/candidateLanguagePreference', 'Admin\CandidatesController@adminCandidateLanguagePreference');
Route::post('/admin/candidateAboutYou', 'Admin\CandidatesController@adminCandidateAboutYou');
Route::post('/admin/candidateDetails', 'Admin\CandidatesController@adminCandidateDetails');
Route::post('/admin/candidateReferences', 'Admin\CandidatesController@adminCandidateReferences');
Route::post('/admin/candidateConfidentiality', 'Admin\CandidatesController@admincandidateConfidentiality');
Route::post('/admin/adminOrganizeItwPlanned', 'Admin\PartnerInterviewFeedbackController@adminOrganizeItwPlanned');
Route::post('/admin/adminItwPassed', 'Admin\PartnerInterviewFeedbackController@adminItwPassed');
Route::post('/admin/candidateInterviewFeedback', 'Admin\PartnerInterviewFeedbackController@adminCandidateInterviewFeedback');



Route::post('/admin/candidateNotSelected', 'Admin\CandidatesController@adminCandidateNotSelected');
Route::post('/admin/candidateSelected', 'Admin\CandidatesController@adminCandidateSelected');
Route::post('/admin/selectPartner', 'Admin\PartnersController@adminSelectPartner');

Route::post('/admin/seePartners', 'Admin\PartnersController@adminSeePartners');
Route::post('/admin/partnerCRMNotes', 'Admin\PartnersController@adminPartnerCRMNotes');
Route::post('/admin/partnerDescription', 'Admin\PartnersController@adminPartnerDescription');
Route::post('/admin/partnerAbout', 'Admin\PartnersController@adminPartnerAbout');
Route::post('/admin/partnerDetails', 'Admin\PartnersController@adminPartnerDetails');

Route::post('/admin/seeCompanies', 'Admin\CompaniesController@adminSeeCompanies');
Route::post('/admin/companyCRMNotes', 'Admin\CompaniesController@adminCompanyCRMNotes');
Route::post('/admin/companyVacancyDetails', 'Admin\CompaniesController@admin_companyVacancyDetails');
Route::post('/admin/linkCandidateToVacancy', 'Admin\CandidatesController@admin_linkCandidateToVacancy');

Route::post('/admin/partnerNotSelected', 'Admin\PartnersController@adminPartnerNotSelected');
Route::post('/admin/companyNotSelected', 'Admin\CompaniesController@adminCompanyNotSelected');
Route::post('/admin/companyNotReachable', 'Admin\CompaniesController@adminCompanyNotReachable');

Route::post('/admin/partnerSelected', 'Admin\PartnersController@adminPartnerSelected');
Route::post('/admin/companySelected', 'Admin\CompaniesController@adminCompanySelected');

Route::post('/admin/confirmPartnerInterview', 'Admin\PartnersController@admin_confirmPartnerInterview');
Route::post('/admin/partnerInterviewFeedback', 'Admin\PartnerInterviewFeedbackController@admin_partnerInterviewFeedback');
Route::post('/admin/interviewPartnerFeedback', 'Admin\PartnerInterviewFeedbackController@admin_interviewPartnerFeedback');
Route::post('/admin/interviewCandidateFeedback', 'Admin\PartnerInterviewFeedbackController@admin_interviewCandidateFeedback');


Route::post('/admin/deletePartner', 'Admin\PartnersController@admin_deletePartner');
Route::post('/admin/deleteCandidate', 'Admin\CandidatesController@admin_deleteCandidate');
Route::post('/admin/deleteCompany', 'Admin\CompaniesController@admin_deleteCompany');

//Mail test
Route::post('/admin/mailTest', 'Admin\CandidatesController@adminMailTest');


//Shortlist ask for more information email
Route::post('/shortListGetMoreInformation', 'Admin\CompaniesController@shortListGetMoreInformation');


// Display
Route::get('/display/avatar', 'HomeController@getDisplay');

// Download
Route::get('/download/{file}', 'HomeController@getDownload');

// Download public (download docs from TieTalent, i.e: partner guidelines / candidate interview advices...)
Route::get('/downloadPublic/{file}', 'HomeController@getDownloadPublic');

// Download candidate files by companies / partners
Route::post('/downloadCandidate/{file}', 'HomeController@getDownloadCandidate');

// Download company files (job description) by candidates
Route::post('/downloadCompany/{file}', 'HomeController@getDownloadCompany');

// Delete
Route::get('/delete/{file}', 'HomeController@delete');
