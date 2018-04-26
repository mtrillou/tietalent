

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>Find your next employee - TieTalent</title>
    <meta name="description" content="content of the description" />
    <meta name="recruitment" content="---"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-slider.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/default.css') }}" id="theme_base">
    <link rel="stylesheet" href="{{ asset('public/css/default.date.css') }}" id="theme_date">
    <link rel="stylesheet" href="{{ asset('public/css/default.time.css') }}" id="theme_time">
    <link href="{{ asset('public/css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/img/logopuzzle.png') }}">
    <link rel="manifest" href="{{ asset('public/img/logopuzzle.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
  <body>
    <header>
      <a href="/home"><img class="logo" width="150px"src="{{ asset('public/img/logott.png') }}" alt="logo" title="logo"/></a>
      <nav>
        <ul>
          <li><a href="#">Settings</a>
            <div class="header-submenu-partner">
              <a href="/partner/settings">Account</a>
              <a href="/partner/faq">FAQ & Help</a>
              <a href="/partner/feedback">Feedback</a>
              <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
            </div>
          </li>
        </ul>
      </nav>
    </header>
    <main>
      <div id="partnermainpage">
        <aside class="leftpart">
          <h1><a href="/home"><img class="profile-picture-circle" src="{{ asset('public/img/logopuzzle.png') }}" height="100px" width="100px"></a></h1>
          <ul>
            <li><a href="/home">General</a></li>
            <li><a href="/admin/candidates" class="orange">Candidates <i class="fa fa-exclamation-circle orange" id="adminCandidatesUpdate" aria-hidden="true" style="display:none;"></i></a></li>
            <li><a href="/admin/partners">Partners <i class="fa fa-exclamation-circle orange" id="adminPartnersUpdate" aria-hidden="true" style="display:none;"></i></a></li>
            <li><a href="/admin/companies">Companies <i class="fa fa-exclamation-circle orange" id="adminCompaniesUpdate" aria-hidden="true" style="display:none;"></i></a></li>
          </ul>
        </aside>
        <article class="rightpart">
          <p id="candidatesToReview" style="display:none;">@foreach($candidatesAll as $candidateAll) @if($candidateAll->interviewStatut == '2') {{ $candidateAll->id }} @endif @endforeach</p>
          <p id="companiesToReview" style="display:none;">@foreach($companiesAll as $companyAll) @if($companyAll->statut == '1') {{ $companyAll->id }} @endif @endforeach</p>
          <p id="partnersToReview" style="display:none;">@foreach($partnersAll as $partnerAll) @if($partnerAll->partner_statut == '1') {{ $partnerAll->id }} @endif @endforeach</p>


          <h2 class="aligncenter">Profile of {{ ucfirst($candidates->firstName) }} {{ ucfirst($candidates->lastName) }}</h2>
          <h5 id="candidateStatut" style="display:none;">{{ $candidates->interviewStatut }}</h5>


          <div class="row" id="profileRowPresentation">
          <img src="{{ asset('public/uploads/avatars') }}/{{ $candidates->avatar }}" height="120px" width="120px" style="border-radius:0.5rem;">
            <div class="candidatemaininfo">
              <p>Living in <b>{{ $candidateDetails->address }}</b></p>
              <p>Aiming get a position in {{ $candidateDetails->division }}{{ $candidateDetails->divisionOther }}</p>
              <p>Open to <b>{{ $candidateDetails->contractTypePermanent }} - {{ $candidateDetails->contractTypeTH }} - {{ $candidateDetails->contractTypeTemporary }}</b> contracts</p>
              <p>Availability: <b>{{ $candidateDetails->availability }}</b></p>
              <p>Salary expectations of approx. <b>CHF {{ number_format($candidateDetails->salaryExpectations, 0, ',', "'") }} / year</b></p>
            </div>
          </div>
          <a id="inviteFromEmailAccount" class="wp-btn-default centeralign marginbottom-middle width-middleMinus" href="mailto:{{$candidates->candidate_email}}?">
            Send email
          </a>
          <div id="validationButtons" style="display:none;">
            <button type="submit" id="noValidateProfile" class="btn welcome-company-btn-default width-middleMinus marginright-small" style="background-color:#333333">Profile not validated</button>
            <button type="submit" id="validateProfile" class="btn welcome-company-btn-default width-middleMinus marginleft-small">Send profile to partner</button>
          </div>

          <div class="thickdashedborder">
            <form class="" action="/admin/candidateCRMNotes" method="post">
              {{ csrf_field() }}
              <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
              <div id="CRMNotes">{{ $candidateInfos->candidateNotes }}</div>
              <textarea cols="40" rows="7" class="nooutline" name="candidateNotes" id="userCRMNotes" style="display:none;" placeholder="Notes about {{ $candidates->firstName }} {{ $candidates->lastName }}">{{ $candidateInfos->candidateNotes }}</textarea>
              <div class="row-reverse">
                <input type="submit" id="CRMNotes_save" style="display:none;" class="wp-btn-default saveclick nooutline" value="{{ trans('candidateplatform_home.save') }}"></a>
                <i class="fa fa-pencil hover" aria-hidden="true" id="CRMNotes_update" style="display:none;">
                  <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                  </div>
                </i>
              </div>
            </form>
          </div>

          <div id="candidateNotValidated" style="display:none;">
            <form class="" action="/admin/candidateNotSelected" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input name="candidate_id" type="hidden" value="{{ $candidates->id }}">
            <h3>Main reason not to validate this candidate:</h3>
            <div class="marginbottom-xsmall">
              <select class="nooutline" name="reasonNotValidated" id="reasonNotValidated">
                <option value="selectReasonNotSelected" disabled selected>Reason</option>
                <option value="noMatch">Profile not matching our clients needs</option>
                <option value="noDivision">Good profile but division not open yet</option>
              </select>
              <select class="nooutline" value='' name="toKeepForDivision" id="toKeepForDivision" style="display:none;">
                <option value="divisionCandidate" disabled selected>Division to consider this candidate for</option>
                <option value="Human resources - Recruitment">Human resources - Recruitment</option>
                <option value="Sales - Marketing - Communications">Sales - Marketing - Communications</option>
                <option value="Information Technology">Information Technology</option>
                <option value="Office Support - Secretarial">Office Support - Secretarial</option>
                <option value="Legal">Legal</option>
                <option value="Procurement & Supply Chain">Procurement & Supply Chain</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <button type="submit" id="confirmCandidateNotSelected" class="btn welcome-company-btn-default width-middleMinus margintop-small" style="display:none;">Confirm</button>
            </form>
          </div>

          <div id="candidateValidated" style="display:none;">
            <form class="" action="/admin/candidateSelected" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input name="candidate_id" type="hidden" value="{{ $candidates->id }}">
            <h3>Tie this candidate to the right partner:</h3>
            <div class="marginbottom-xsmall">
              <select class="nooutline" name="partnerCompensation" id="" style="width:20%">
                <option value="" disabled selected>Candidate average yearly salary (partner compensation)</option>
                <option value="45.83">CHF 55'000 (45.83)</option>
                <option value="50">CHF 60'000 (50)</option>
                <option value="54.17">CHF 65'000 (54.17)</option>
                <option value="58.33">CHF 70'000 (58.33)</option>
                <option value="62.5">CHF 75'000 (62.5)</option>
                <option value="66.67">CHF 80'000 (66.67)</option>
                <option value="70.83">CHF 85'000 (70.83)</option>
                <option value="75">CHF 90'000 (75)</option>
                <option value="79.17">CHF 95'000 (79.17)</option>
                <option value="83.33">CHF 100'000 (83.33)</option>
                <option value="87.5">CHF 105'000 (87.5)</option>
                <option value="91.67">CHF 110'000 (91.67)</option>
                <option value="95.83">CHF 115'000 (95.83)</option>
                <option value="100">CHF 120'000 (100)</option>
                <option value="104.17">CHF 125'000 (104.17)</option>
                <option value="108.33">CHF 130'000 (108.33)</option>
                <option value="112.5">CHF 135'000 (112.5)</option>
                <option value="116.67">CHF 140'000 (116.67)</option>
                <option value="120.83">CHF 145'000 (120.83)</option>
                <option value="125">CHF 150'000 (125)</option>
              </select>
              <select class="nooutline" name="divisionPartner" id="partnerDivision">
                <option value="" disabled selected>Division</option>
                <option value="Finance & Accounting">Finance & Accounting</option>
              </select>
              <select class="nooutline" name="department" id="partnerDepartmentFinanceAccounting" style="display:none;">
                <option value="" disabled selected>Department</option>
                <option value="Accounting Department">Accounting</option>
                <option value="Finance & Controlling Department">Finance & Controlling</option>
                <option value="Tax & Treasury Department">Tax & Treasury</option>
              </select>
              <select class="nooutline partnerFunction" name="function" id="partnerFunctionAccounting" style="display:none;">
                <option value="" disabled selected>Function</option>
                <option value="Accounts Payable">Accounts Payable</option>
                <option value="Accounts Receivable - Billing specialist">Accounts Receivable - Billing specialist</option>
                <option value="General Ledger">General Ledger</option>
                <option value="Payroll Specialist">Payroll Specialist</option>
                <option value="Credit Analyst">Credit Analyst</option>
                <option value="Internal Audit">Internal Audit</option>
                <option value="External Audit">External Audit</option>
              </select>
              <select class="nooutline partnerFunction" name="function" id="partnerFunctionFC" style="display:none;">
                <option value="" disabled selected>Function</option>
                <option value="Industrial Controller">Industrial Controller</option>
                <option value="Analyst - FP&A">Analyst - FP&A</option>
                <option value="Consolidation - Reporting">Consolidation - Reporting</option>
              </select>
              <select class="nooutline partnerFunction" name="function" id="partnerFunctionTaxTreasury" style="display:none;">
                <option value="" disabled selected>Function</option>
                <option value="VAT Accountant">VAT Accountant</option>
                <option value="Tax Analyst">Tax Analyst</option>
                <option value="Treasury Analyst">Treasury Analyst</option>
              </select>
            </div>
            <button type="submit" id="choosePartner" class="btn welcome-company-btn-default width-middle margintop-small nooutline" style="display:none;">Go select partner</button>
            </form>
          </div>
          <p id="goBackToValidationButtons" style="display:none;text-align:right;">Go back</p>





          <div class="thickdashedborder">
            <form class="" action="/admin/candidateAboutYou" method="post">
              {{ csrf_field() }}
              <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
              <h3>{{ trans('candidateplatform_home.aboutYou') }}
                <br/><small>{{ trans('candidateplatform_home.describeCareer') }}</small></h3>
                <div id="aboutYou">{{ $candidateDetails->aboutYou }}</div>
              <textarea cols="40" rows="7" class="nooutline" name="aboutYou" id="candidateCareerSummary" style="display:none;" placeholder="{{ trans('candidateplatform_home.placeholderDescribeCareer') }}">{{ $candidateDetails->aboutYou }}</textarea>
              <div class="row-reverse">
                <input type="submit" id="aboutYou_save" style="display:none;" class="wp-btn-default saveclick nooutline" value="{{ trans('candidateplatform_home.save') }}"></a>
                <i class="fa fa-pencil hover" aria-hidden="true" id="aboutYou_update" style="display:none;">
                  <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                  </div>
                </i>
              </div>
            </form>
          </div>

          <!--
          <div class="thickdashedborderOrange">
            <div class="linkstoposition">
              <h3><big>Experiences that would make {{ ucfirst($candidates->firstName) }} an excellent {{ $candidateDetails->function }} candidate</big>
              <br/><small>Experiences {{ ucfirst($candidates->firstName) }} would highlight to get a {{ $candidateDetails->function }} job</small></h3>
              <div class="alignleft">
                <div class="paddingbottom-tworem marginleft-small">Argument 1</div>
                <div class="paddingbottom-tworem marginleft-small">Argument 2</div>
                <div class="paddingbottom-tworem marginleft-small">Argument 3</div>
                <div class="paddingbottom-tworem marginleft-small">Argument 4</div>
              </div>
            </div>
          </div>
        -->


          <div class="thickdashedborder">
            <h3><big>Documents</big></h3>
            <h3 class="centeralign"><big>CV</big></h3>
            <div class="row" id="CVRow">
              @foreach ($documents as $document)
                @if ( $document->docType  === 'CV')



                    <form action="/downloadCandidate/CV{{ $document->others }}{{ $document->docLanguage }}.{{ $document->docExt }}" class="centeralign document-button width-small" style="cursor:pointer" method="post">
                      {{ csrf_field() }}
                      <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
                      <a onclick="$('#CV{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}').trigger( 'click' )" >
                      <h3 class="orange fontweightlight">{{ $document->docType }}<br/><small>{{ $document->docLanguage }}</small></h3>
                      </a>
                      <input type="submit" id="CV{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}" name="" value="" style="display:none;">
                    </form>


                @endif
              @endforeach

            </div>


            <h3 class="aligncenter"><big>Work certificates</big></h3>
            <div class="row" id="WCRow">
              @foreach ($documents as $document)
                @if ( $document->docType  === 'WorkCertificate')

                <form action="/downloadCandidate/WorkCertificate{{ $document->others }}{{ $document->docLanguage }}.{{ $document->docExt }}" class="centeralign document-button width-small" style="cursor:pointer" method="post">
                  {{ csrf_field() }}
                  <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
                  <a onclick="$('#WorkCertificate{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}').trigger( 'click' )" >
                  <h3 class="orange fontweightlight">Work Certificate<br/><small>{{ $document->company }}</small></h3>
                  </a>
                  <input type="submit" id="WorkCertificate{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}" name="" value="" style="display:none;">
                </form>

                @endif
              @endforeach
            </div>


            <h3 class="aligncenter"><big>Diploma</big></h3>
            <div class="row" id="DiplomaRow">
              @foreach ($documents as $document)
                @if ( $document->docType  === 'Diploma')

                <form action="/downloadCandidate/Diploma{{ $document->others }}{{ $document->docLanguage }}.{{ $document->docExt }}" class="centeralign document-button width-small" style="cursor:pointer" method="post">
                  {{ csrf_field() }}
                  <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
                  <a onclick="$('#Diploma{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}').trigger( 'click' )" >
                  <h3 class="orange fontweightlight">{{ $document->diplomaGrade }}<br/><small>{{ $document->school }}</small></h3>
                  </a>
                  <input type="submit" id="Diploma{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}" name="" value="" style="display:none;">
                </form>

                @endif
              @endforeach
          </div>

          <h3 class="aligncenter"><big>Others</big></h3>
          <div class="row" id="OthersRow">
            @foreach ($documents as $document)
              @if ( $document->docType  === 'Others')

              <form action="/downloadCandidate/Others{{ $document->others }}{{ $document->docLanguage }}.{{ $document->docExt }}" class="centeralign document-button width-small" style="cursor:pointer" method="post">
                {{ csrf_field() }}
                <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
                <a onclick="$('#Others{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}').trigger( 'click' )" >
                <h3 class="orange fontweightlight">{{ $document->others }}<br/><small>{{ $document->docLanguage }}</small></h3>
                </a>
                <input type="submit" id="Others{{ $document->others }}{{ $document->docLanguage }}{{ $document->docExt }}" name="" value="" style="display:none;">
              </form>

              @endif
            @endforeach
          </div>


        </div>

        <h2>Candidate information</h2>
        <div class="settings-element-generalinfo marginleft-middle" style="display:block;text-align:left;">
          <form class="marginbottom-big" action="/admin/candidateDetails" method="post">
              {{ csrf_field() }}
            <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">

            <p class="margintop-small general_information">{{ trans('candidateplatform_settings.firstName') }}: <b>{{ ucfirst($candidates->firstName) }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >{{ trans('candidateplatform_settings.firstName') }}: <input type="text" name="firstName" id="candidateFirstName" placeholder="{{ trans('candidateplatform_settings.firstName') }}" class="borderradius nooutline width-middle" value="{{ $candidates->firstName }}"></p>

            <p id="lastName" class="paddingtop-small general_information">{{ trans('candidateplatform_settings.lastName') }}: <b>{{ ucfirst($candidates->lastName) }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >{{ trans('candidateplatform_settings.lastName') }}: <input type="text" name="lastName" id="candidateLastName" placeholder="{{ trans('candidateplatform_settings.lastName') }}" class="borderradius nooutline width-middle" value="{{ $candidates->lastName }}"></p>

            <p id="address" class="paddingtop-small general_information">{{ trans('candidateplatform_settings.address') }}: <b>{{ $candidateDetails->address }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >{{ trans('candidateplatform_settings.address') }}: <input type="text" id="candidateAddress" name="address" placeholder="{{ trans('candidateplatform_settings.address') }}" class="borderradius nooutline width-middle" value="{{ $candidateDetails->address }}"/></p>

            <p id="email" class="paddingtop-small general_information">Email: <b>{{ $candidates->candidate_email }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >Email: <input type="text" name="candidate_email" id="candidateEmail" placeholder="Email" class="borderradius nooutline width-middle" value="{{ $candidates->candidate_email }}"></p>

            <p id="reasonJobSearch" class="paddingtop-small general_information">Reason for job search: <b>{{ $candidateDetails->reasonJobSearch }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >Reason for job search: <input type="text" name="reasonJobSearch" id="candidateReasonJobSearch" placeholder="Reason for job search" class="borderradius nooutline width-middle" value="{{ $candidateDetails->reasonJobSearch }}"></p>

            <p id="skype" class="paddingtop-small general_information">Skype: <b>{{ $candidates->candidate_skype }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >Skype: <input type="text" name="skype" id="candidateSkype" placeholder="Skype" class="borderradius nooutline width-middle" value="{{ $candidates->candidate_skype }}"></p>

            <p id="linkedIn" class="paddingtop-small general_information">LinkedIn: <b>{{ $candidateDetails->linkedIn }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >LinkedIn: <input type="text" name="linkedIn" id="candidateLinkedIn" placeholder="LinkedIn" class="borderradius nooutline width-middle" value="{{ $candidateDetails->linkedIn }}"></p>

            <p id="shareLink" class="paddingtop-small general_information">ShareLink: <b>{{ $candidateInfos->shareLink }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >ShareLink: <input type="text" name="shareLink" id="candidateShareLink" placeholder="shareLink" class="borderradius nooutline width-middle" value="{{ $candidateInfos->shareLink }}"></p>


            <p id="partTime" class="paddingtop-small general_information">PartTime:
              <br/><b><span class="marginleft-big" id="workPermit" >Between  <?php echo array_sum(array($candidateDetails->partTimeMin,1)) ?>0% and <?php echo array_sum(array($candidateDetails->partTimeMax,1)) ?>0%</b></span>
            </p>
            <div style="display:none;" class="paddingtop-small general_information_update"><p>Work permit</p>
              <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.occupationRate') }}</h3>
              <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.occupationRate2') }}</h3>
              <h5 class="partTime color-dark">{{ trans('candidateplatform_registrationform.dragSliderExpectations') }}</h5>
              <div class="row" style="display:inline;">
                <input id="candidatePartTime" name="partTime" type="text" value="" data-slider-tooltip="hide" />
              </div>
            </div>

            <p id="workPermit" class="paddingtop-small general_information">Work permit (either Yes or No): <b>{{ $candidateDetails->workPermit }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >Work permit (either Yes or No): <input type="text" name="workPermit" id="candidateWorkPermit" placeholder="Work Permit" class="borderradius nooutline width-middle" value="{{ $candidateDetails->workPermit }}"></p>

            <p id="workPermit" class="paddingtop-small general_information">Car (either 1 or 0): <b>{{ $candidateDetails->car }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >Car (either 1 or 0): <input type="text" name="car" id="candidateCar" placeholder="Car" class="borderradius nooutline width-middle" value="{{ $candidateDetails->car }}"></p>





            <p class="paddingtop-small general_information" >{{ trans('candidateplatform_settings.communication') }}: <b class="communicationChoice">{{ $candidates->communication }}</b></p>


            <div style="display:none;" class="general_information_update settings-element-communication">
              <div class="marginbottom-big">
                <div>
                  <p><b><big>{{ trans('candidateplatform_settings.trendsEmail') }}</big></b></p>
                  <p class="updateChoice" id="candidate_communicationPreferencesChoice">{{ $candidates->communication }}</p>
                  <p class="updateChoice" id="candidate_communicationPreferences" style="display:none;">{{ $candidates->communication }}</p>
                  <input id="candidateUpdateChoice" name="communication" style="display:block;" data-slider-min="1" data-slider-max="5"   data-slider-tooltip="hide" data-slider-value="{{ $candidates->communication }}">
                </div>
              </div>
            </div>




            <p id="interviewStatut" class="paddingtop-small general_information">InterviewStatut: <b>{{ $candidates->interviewStatut }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >InterviewStatut: <input type="text" name="interviewStatut" id="candidateInterviewStatut" placeholder="interviewStatut" class="borderradius nooutline width-middle" value="{{ $candidates->interviewStatut }}"></p>

            <p id="opportunitiesStatut" class="paddingtop-small general_information">OpportunitiesStatut: <b>{{ $candidates->opportunitiesStatut }}</b></p>
            <p class="margintop-small general_information general_information_update" style="display:none;" >OpportunitiesStatut: <input type="text" name="opportunitiesStatut" id="candidateOpportunitiesStatut" placeholder="interviewStatut" class="borderradius nooutline width-middle" value="{{ $candidates->opportunitiesStatut }}"></p>

            <p class="paddingtop-small general_information" >{{ trans('candidateplatform_settings.mobility') }}: <b class="mobilityChoice">{{ $candidateDetails->mobility }}</b></p>
            <p class="updateChoice" id="mobility" style="display:none;">{{ $candidateDetails->mobility }}</p>

            <div style="display:none;" class="general_information_update">
              <p class="paddingtop-small">{{ trans('candidateplatform_settings.mobility') }}:
                <p class="mobility centeralign mobilityChoice">{{ $candidateDetails->mobility }}</p>
                <div class="row margintop-small">
                  <input id="candidateMobility" name="mobility" data-slider-min="1" data-slider-max="5"   data-slider-tooltip="hide" data-slider-value="{{ $candidateDetails->mobility }}">
                </div>
              </p>
            </div>


            <p class="paddingtop-small general_information" >{{ trans('candidateplatform_settings.availability') }}: <b class="availabilityChoice">{{ $candidateDetails->availability }}</b></p>
            <p class="updateChoice" id="availability" style="display:none;">{{ $candidateDetails->availability }}</p>

            <div style="display:none;" class="general_information_update">
              <p class="paddingtop-small">{{ trans('candidateplatform_settings.availability') }}:
                <p class="availability centeralign availabilityChoice">{{ $candidateDetails->availability }}</p>
                <div class="row margintop-small">
                  <input id="candidateAvailability" name="availability" data-slider-min="1" data-slider-max="5"   data-slider-tooltip="hide" data-slider-value="{{ $candidateDetails->availability }}">
                </div>
              </p>
            </div>




            <p id="salary" class="paddingtop-small general_information">{{ trans('candidateplatform_settings.salaryExpectations') }}: <b>CHF {{ number_format($candidateDetails->salaryExpectations, 0, ',', "'") }} / {{ trans('candidateplatform_settings.year') }}</b></p>
            <div style="display:none;" class="general_information_update">
              <p class="paddingtop-small">{{ trans('candidateplatform_settings.salaryExpectations2') }}:
              <p class="salary color-dark centeralign">CHF {{ number_format($candidateDetails->salaryExpectations, 0, ',', "'") }}</p>
              <div class="row margintop-small">
                <input id="candidateSalaryExpectations" name="salaryExpectations" value="" data-slider-min="50000" data-slider-max="130000"   data-slider-tooltip="hide" data-slider-value="{{ $candidateDetails->salaryExpectations }}" data-slider-step="1000">
              </div>
            </div>


            <p id="contracts" class="paddingtop-small general_information">{{ trans('candidateplatform_settings.contractTypes') }}:
              <br/><b><span class="marginleft-big" id="contractTypePermanent" >{{ ucfirst($candidateDetails->contractTypePermanent) }}</span>
              <br/><span class="marginleft-big" id="contractTypeTH">{{ ucfirst($candidateDetails->contractTypeTH) }}</span>
              <br/><span class="marginleft-big" id="contractTypeTemporary">{{ ucfirst($candidateDetails->contractTypeTemporary) }}</span></b>
            </p>
            <div style="display:none;" class="paddingtop-small general_information_update"><p>{{ trans('candidateplatform_settings.contractTypes2') }}</p>
              <div class="row centeralign margintop-small" style="margin-bottom:1rem;">
                <div class="col-md-4"><input type="checkbox" name="contractTypePermanent" id="contractTypePermanent_checkbox" value="{{ ucfirst($candidateDetails->contractTypePermanent) }}" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_settings.permanent') }}<br/><small>{{ trans('candidateplatform_settings.permanent2') }}</small></label></div>
                <div class="col-md-4"><input type="checkbox" name="contractTypeTH" id="contractTypeTH_checkbox" value="{{ ucfirst($candidateDetails->contractTypeTH) }}" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_settings.TH') }}<br/><small>{{ trans('candidateplatform_settings.TH2') }}</small></label></div>
                <div class="col-md-4"><input type="checkbox" name="contractTypeTemporary" id="contractTypeTemporary_checkbox" value="{{ ucfirst($candidateDetails->contractTypeTemporary) }}" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_settings.temporary') }}<br/><small>{{ trans('candidateplatform_settings.temporary2') }}</small></label></div>
              </div>
            </div>

            <div style="display:none;" class="paddingtop-small general_information_update">
              <p>{{ trans('candidateplatform_settings.changePositionInterestedIn') }}</p>
            </div>
            <p class="paddingtop-small general_information">{{ trans('candidateplatform_settings.positionInterestedIn') }}<b>{{ $candidateDetails->division }}</b></p>

            <div style="display:none;" class="paddingtop-small general_information_update">
              <p>Position recommended for by the partner</p>
            </div>
            <p class="paddingtop-small general_information">Position recommended for by the partner <b>@foreach($partnerInterviewFeedback as $feedback) {{ $feedback->function }}   @endforeach</b></p>



            <input type="" id="general_edit" class="wp-btn-default saveclick nooutline centeralign" style="float:right;width:12%;background-color:#333333;color:#F14904" value="{{ trans('candidateplatform_settings.edit') }}"></a>
            <input type="submit" id="general_save" class="wp-btn-default saveclick nooutline" style="display:none;float:right;width:12%" value="{{ trans('candidateplatform_settings.save') }}"></a>
          </form>

          <!--
            <div class="thickdashedborder" id="referencesTab">
              <div class="candidatereferences">
                <form class="" action="/admin/candidateReferences" method="post">
                  {{ csrf_field() }}
                  <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">

                <h3>{{ trans('candidateplatform_home.references') }}
                <br/><small>{{ trans('candidateplatform_home.references2') }}</small></h3>
                <div id="reference1" class="row" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p id="referenceFirstName1" class="border-radius reference-fn nooutline">{{ $candidateDetails->firstNameReference1 }}</p>
                      <p id="referenceLastName1" class="border-radius reference-fn nooutline">{{ $candidateDetails->lastNameReference1 }}</p>
                      <p id="referenceEmail1" class="border-radius reference-company nooutline">{{ $candidateDetails->emailReference1 }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p id="referencePosition1" class="border-radius reference-company nooutline">{{ $candidateDetails->positionReference1 }}</p>
                      <p id="referenceCompany1" class="border-radius reference-company nooutline">{{ $candidateDetails->companyReference1 }}</p>
                    </div>
                  </div>
                  <i class="fa fa-pencil hover" id="reference1_update" aria-hidden="true">
                      <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                      </div>
                  </i>
                  <i class="fa fa-plus nooutline" id="addReference2" aria-hidden="true"></i>

                </div>
                <div id="reference1_inputs" class="row">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <input type="text" name="firstNameReference1" id="reference1_FirstNameInput" placeholder="{{ trans('candidateplatform_home.firstName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->firstNameReference1 }}"/>
                      <input type="text" name="lastNameReference1" id="reference1_LastNameInput" placeholder="{{ trans('candidateplatform_home.lastName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->lastNameReference1 }}"/>
                      <input type="text" name="emailReference1" id="reference1_EmailInput" placeholder="{{ trans('candidateplatform_home.professionalEmail') }}" class="reference-company nooutline" value="{{ $candidateDetails->emailReference1 }}"/>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <input type="text" name="positionReference1" id="reference1_PositionInput" placeholder="{{ trans('candidateplatform_home.occupation') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->positionReference1 }}"/>
                      <input type="text" name="companyReference1" id="reference1_CompanyInput" placeholder="{{ trans('candidateplatform_home.whichCompany') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->companyReference1 }}"/>
                    </div>
                  </div>
                  <span class="candidate-linktoposition-addbutton addreference1 nooutline"><i class="fa fa-plus nooutline" aria-hidden="true"></i></span>
                  <span class="candidate-linktoposition-removebutton nooutline" id="removeReference1"><i class="fa fa-minus nooutline" aria-hidden="true"></i></span>
                </div>
                <div id="reference2" class="row" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p id="referenceFirstName2" class="border-radius reference-fn nooutline">{{ $candidateDetails->firstNameReference2 }}</p>
                      <p id="referenceLastName2" class="border-radius reference-fn nooutline">{{ $candidateDetails->lastNameReference2 }}</p>
                      <p id="referenceEmail2" class="border-radius reference-company nooutline">{{ $candidateDetails->emailReference2 }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p id="referencePosition2" class="border-radius reference-company nooutline">{{ $candidateDetails->positionReference2 }}</p>
                      <p id="referenceCompany2" class="border-radius reference-company nooutline">{{ $candidateDetails->companyReference2 }}</p>
                    </div>
                  </div>
                  <i class="fa fa-pencil hover" id="reference2_update" aria-hidden="true">
                      <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                      </div>
                  </i>
                  <i class="fa fa-plus nooutline" id="addReference3" aria-hidden="true"></i>
                </div>
                <div id="reference2_inputs" class="row candidate-reference2" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <input type="text" name="firstNameReference2" id="reference2_FirstNameInput" placeholder="{{ trans('candidateplatform_home.firstName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->firstNameReference2 }}"/>
                      <input type="text" name="lastNameReference2" id="reference2_LastNameInput" placeholder="{{ trans('candidateplatform_home.lastName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->lastNameReference2 }}"/>
                      <input type="text" name="emailReference2" id="reference2_EmailInput" placeholder="{{ trans('candidateplatform_home.professionalEmail') }}" class="reference-company nooutline" value="{{ $candidateDetails->emailReference2 }}"/>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <input type="text" name="positionReference2" id="reference2_PositionInput" placeholder="{{ trans('candidateplatform_home.occupation') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->positionReference2 }}"/>
                      <input type="text" name="companyReference2" id="reference2_CompanyInput" placeholder="{{ trans('candidateplatform_home.whichCompany') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->companyReference2 }}"/>
                    </div>
                  </div>
                  <span class="candidate-linktoposition-addbutton addreference2 nooutline"><i class="fa fa-plus nooutline" aria-hidden="true"></i></span>
                  <span class="candidate-linktoposition-removebutton nooutline" id="removeReference2"><i class="fa fa-minus nooutline" aria-hidden="true"></i></span>
                </div>
                <div id="reference3" class="row" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p id="referenceFirstName3" class="border-radius reference-fn nooutline">{{ $candidateDetails->firstNameReference3 }}</p>
                      <p id="referenceLastName3" class="border-radius reference-fn nooutline">{{ $candidateDetails->lastNameReference3 }}</p>
                      <p id="referenceEmail3" class="border-radius reference-company nooutline">{{ $candidateDetails->emailReference3 }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p id="referencePosition3" class="border-radius reference-company nooutline">{{ $candidateDetails->positionReference3 }}</p>
                      <p id="referenceCompany3" class="border-radius reference-company nooutline">{{ $candidateDetails->companyReference3 }}</p>
                    </div>
                  </div>
                  <i class="fa fa-pencil hover" id="reference3_update" aria-hidden="true">
                      <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                      </div>
                  </i>
                  <i class="fa fa-plus nooutline" id="addReference4" aria-hidden="true"></i>
                </div>
                <div id="reference3_inputs" class="row candidate-reference3" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <input type="text" name="firstNameReference3" id="reference3_FirstNameInput" placeholder="{{ trans('candidateplatform_home.firstName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->firstNameReference3 }}"/>
                      <input type="text" name="lastNameReference3" id="reference3_LastNameInput" placeholder="{{ trans('candidateplatform_home.lastName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->lastNameReference3 }}"/>
                      <input type="text" name="emailReference3" id="reference3_EmailInput" placeholder="{{ trans('candidateplatform_home.professionalEmail') }}" class="reference-company nooutline" value="{{ $candidateDetails->emailReference3 }}"/>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <input type="text" name="positionReference3" id="reference3_PositionInput" placeholder="{{ trans('candidateplatform_home.occupation') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->positionReference3 }}"/>
                      <input type="text" name="companyReference3" id="reference3_CompanyInput" placeholder="{{ trans('candidateplatform_home.whichCompany') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->companyReference3 }}"/>
                    </div>
                  </div>
                  <span class="candidate-linktoposition-addbutton addreference3 nooutline"><i class="fa fa-plus nooutline" aria-hidden="true"></i></span>
                  <span class="candidate-linktoposition-removebutton nooutline" id="removeReference3"><i class="fa fa-minus nooutline" aria-hidden="true"></i></span>
                </div>
                <div id="reference4" class="row" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p id="referenceFirstName4" class="border-radius reference-fn nooutline">{{ $candidateDetails->firstNameReference4 }}</p>
                      <p id="referenceLastName4" class="border-radius reference-fn nooutline">{{ $candidateDetails->lastNameReference4 }}</p>
                      <p id="referenceEmail4" class="border-radius reference-company nooutline">{{ $candidateDetails->emailReference4 }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p id="referencePosition4" class="border-radius reference-company nooutline">{{ $candidateDetails->positionReference4 }}</p>
                      <p id="referenceCompany4" class="border-radius reference-company nooutline">{{ $candidateDetails->companyReference4 }}</p>
                    </div>
                  </div>
                  <i class="fa fa-pencil hover" id="reference4_update" aria-hidden="true">
                      <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                      </div>
                  </i>
                  <i class="fa fa-plus nooutline" id="addReference5" aria-hidden="true"></i>
                </div>
                <div id="reference4_inputs" class="row candidate-reference4" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <input type="text" name="firstNameReference4" id="reference4_FirstNameInput" placeholder="{{ trans('candidateplatform_home.firstName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->firstNameReference4 }}"/>
                      <input type="text" name="lastNameReference4" id="reference4_LastNameInput" placeholder="{{ trans('candidateplatform_home.lastName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->lastNameReference4 }}"/>
                      <input type="text" name="emailReference4" id="reference4_EmailInput" placeholder="{{ trans('candidateplatform_home.professionalEmail') }}" class="reference-company nooutline" value="{{ $candidateDetails->emailReference4 }}"/>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <input type="text" name="positionReference4" id="reference4_PositionInput" placeholder="{{ trans('candidateplatform_home.occupation') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->positionReference4 }}"/>
                      <input type="text" name="companyReference4" id="reference4_CompanyInput" placeholder="{{ trans('candidateplatform_home.whichCompany') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->companyReference4 }}"/>
                    </div>
                  </div>
                  <span class="candidate-linktoposition-addbutton addreference4 nooutline"><i class="fa fa-plus nooutline" aria-hidden="true"></i></span>
                  <span class="candidate-linktoposition-removebutton nooutline" id="removeReference4"><i class="fa fa-minus nooutline" aria-hidden="true"></i></span>
                </div>
                <div id="reference5" class="row" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p id="referenceFirstName5" class="border-radius reference-fn nooutline">{{ $candidateDetails->firstNameReference5 }}</p>
                      <p id="referenceLastName5" class="border-radius reference-fn nooutline">{{ $candidateDetails->lastNameReference5 }}</p>
                      <p id="referenceEmail5" class="border-radius reference-company nooutline">{{ $candidateDetails->emailReference5 }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p id="referencePosition5" class="border-radius reference-company nooutline">{{ $candidateDetails->positionReference5 }}</p>
                      <p id="referenceCompany5" class="border-radius reference-company nooutline">{{ $candidateDetails->companyReference5 }}</p>
                    </div>
                  </div>
                  <i class="fa fa-pencil hover" id="reference5_update" aria-hidden="true">
                      <div class="tooltip">{{ trans('candidateplatform_home.modify') }}
                      </div>
                  </i>
                </div>
                <div id="reference5_inputs" class="row candidate-reference5" style="display:none;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <input type="text" name="firstNameReference5" id="reference5_FirstNameInput" placeholder="{{ trans('candidateplatform_home.firstName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->firstNameReference5 }}"/>
                      <input type="text" name="lastNameReference5" id="reference5_LastNameInput" placeholder="{{ trans('candidateplatform_home.lastName') }}" class="reference-fn nooutline" rows="2" value="{{ $candidateDetails->lastNameReference5 }}"/>
                      <input type="text" name="emailReference5" id="reference5_EmailInput" placeholder="{{ trans('candidateplatform_home.professionalEmail') }}" class="reference-company nooutline" value="{{ $candidateDetails->emailReference5 }}"/>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <input type="text" name="positionReference5" id="reference5_PositionInput" placeholder="{{ trans('candidateplatform_home.occupation') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->positionReference5 }}"/>
                      <input type="text" name="companyReference5" id="reference5_CompanyInput" placeholder="{{ trans('candidateplatform_home.whichCompany') }}" class="reference-company nooutline"  rows="2" value="{{ $candidateDetails->companyReference5 }}"/>
                    </div>
                  </div>
                  <span class="candidate-linktoposition-addbutton addreference5 nooutline"><i class="fa fa-plus nooutline" aria-hidden="true"></i></span>
                  <span class="candidate-linktoposition-removebutton nooutline" id="removeReference5"><i class="fa fa-minus nooutline" aria-hidden="true"></i></span>
                </div>
                <div class="row-reverse">
                  <input type="submit" id="references_save"  style="display:none;" class="wp-btn-default saveclick nooutline" value="{{ trans('candidateplatform_home.save') }}">
                  <input class="wp-btn-default saveclick nooutline" id="references_update" style="display:none;border:1px solid #333333;color:#333333;background-color:#F1F1F1" value="{{ trans('candidateplatform_home.update') }}"></a>
                </div>
                </form>
              </div>
            </div>
          -->
            <!--
            <div class="row" style="display:none;justify-content:flex-start" id="reference1ButtonSendEmail">
              <form class="" action="/admin/emailReference1" method="post" style="width:75%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="firstNameReference1" type="hidden" value="{{ $candidateDetails->firstNameReference1 }}">
                <input name="lastNameReference1" type="hidden" value="{{ $candidateDetails->lastNameReference1 }}">
                <input name="emailReference1" type="hidden" value="{{ $candidateDetails->emailReference1 }}">
                <input name="positionReference1" type="hidden" value="{{ $candidateDetails->positionReference1 }}">
                <input name="companyReference1" type="hidden" value="{{ $candidateDetails->companyReference1 }}">
                <div class="row" style="margin:0;">
                  <p>{{ $candidateDetails->firstNameReference1 }} {{ $candidateDetails->lastNameReference1 }} Statut: <span style="color:#F14904;">{{ $candidateDetails->statutReference1 }}</span></p>
                  <input type="submit" id="" class="saveclick nooutline" style="float:right;width:50%" value="Send email reference 1"></a>
                </div>
              </form>
              <form class="" action="/admin/seeReference1" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="candidateFirstName" type="hidden" value="{{ $candidates->firstName }}">
                <input name="candidateLastName" type="hidden" value="{{ $candidates->lastName }}">
                <input name="firstNameReference1" type="hidden" value="{{ $candidateDetails->firstNameReference1 }}">
                <input name="lastNameReference1" type="hidden" value="{{ $candidateDetails->lastNameReference1 }}">
                <input name="positionReference1" type="hidden" value="{{ $candidateDetails->positionReference1 }}">
                <input name="companyReference1" type="hidden" value="{{ $candidateDetails->companyReference1 }}">

                <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%" value="See reference 1"></a>
              </form>
            </div>
            <div class="row" style="display:none;justify-content:flex-start" id="reference2ButtonSendEmail">
              <form class="" action="/admin/emailReference2" method="post" style="width:75%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="firstNameReference2" type="hidden" value="{{ $candidateDetails->firstNameReference2 }}">
                <input name="lastNameReference2" type="hidden" value="{{ $candidateDetails->lastNameReference2 }}">
                <input name="emailReference2" type="hidden" value="{{ $candidateDetails->emailReference2 }}">
                <input name="positionReference2" type="hidden" value="{{ $candidateDetails->positionReference2 }}">
                <input name="companyReference2" type="hidden" value="{{ $candidateDetails->companyReference2 }}">
                <div class="row" style="margin:0;">
                  <p>{{ $candidateDetails->firstNameReference2 }} {{ $candidateDetails->lastNameReference2 }} Statut: <span style="color:#F14904;">{{ $candidateDetails->statutReference2 }}</span></p>
                  <input type="submit" id="" class="saveclick nooutline" style="float:right;width:50%" value="Send email reference 2"></a>
                </div>
              </form>
              <form class="" action="/admin/seeReference2" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="candidateFirstName" type="hidden" value="{{ $candidates->firstName }}">
                <input name="candidateLastName" type="hidden" value="{{ $candidates->lastName }}">
                <input name="firstNameReference2" type="hidden" value="{{ $candidateDetails->firstNameReference2 }}">
                <input name="lastNameReference2" type="hidden" value="{{ $candidateDetails->lastNameReference2 }}">
                <input name="positionReference2" type="hidden" value="{{ $candidateDetails->positionReference2 }}">
                <input name="companyReference2" type="hidden" value="{{ $candidateDetails->companyReference2 }}">

                <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%" value="See reference 2"></a>
              </form>
            </div>
            <div class="row" style="display:none;justify-content:flex-start" id="reference3ButtonSendEmail">
              <form class="" action="/admin/emailReference3" method="post" style="width:75%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="firstNameReference3" type="hidden" value="{{ $candidateDetails->firstNameReference3 }}">
                <input name="lastNameReference3" type="hidden" value="{{ $candidateDetails->lastNameReference3 }}">
                <input name="emailReference3" type="hidden" value="{{ $candidateDetails->emailReference3 }}">
                <input name="positionReference3" type="hidden" value="{{ $candidateDetails->positionReference3 }}">
                <input name="companyReference3" type="hidden" value="{{ $candidateDetails->companyReference3 }}">
                <div class="row" style="margin:0;">
                  <p>{{ $candidateDetails->firstNameReference3 }} {{ $candidateDetails->lastNameReference3 }} Statut: <span style="color:#F14904;">{{ $candidateDetails->statutReference3 }}</span></p>
                  <input type="submit" id="" class="saveclick nooutline" style="float:right;width:50%" value="Send email reference 3"></a>
                </div>
              </form>
              <form class="" action="/admin/seeReference3" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="candidateFirstName" type="hidden" value="{{ $candidates->firstName }}">
                <input name="candidateLastName" type="hidden" value="{{ $candidates->lastName }}">
                <input name="firstNameReference3" type="hidden" value="{{ $candidateDetails->firstNameReference3 }}">
                <input name="lastNameReference3" type="hidden" value="{{ $candidateDetails->lastNameReference3 }}">
                <input name="positionReference3" type="hidden" value="{{ $candidateDetails->positionReference3 }}">
                <input name="companyReference3" type="hidden" value="{{ $candidateDetails->companyReference3 }}">

                <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%" value="See reference 3"></a>
              </form>
            </div>
            <div class="row" style="display:none;justify-content:flex-start" id="reference4ButtonSendEmail">
              <form class="" action="/admin/emailReference4" method="post" style="">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="firstNameReference4" type="hidden" value="{{ $candidateDetails->firstNameReference4 }}">
                <input name="lastNameReference4" type="hidden" value="{{ $candidateDetails->lastNameReference4 }}">
                <input name="emailReference4" type="hidden" value="{{ $candidateDetails->emailReference4 }}">
                <input name="positionReference4" type="hidden" value="{{ $candidateDetails->positionReference4 }}">
                <input name="companyReference4" type="hidden" value="{{ $candidateDetails->companyReference4 }}">
                <div class="row" style="margin:0;">
                  <p>{{ $candidateDetails->firstNameReference4 }} {{ $candidateDetails->lastNameReference4 }} Statut: <span style="color:#F14904;">{{ $candidateDetails->statutReference4 }}</span></p>
                  <input type="submit" id="" class="saveclick nooutline" style="float:right;width:25%" value="Send email reference 4"></a>
                </div>
              </form>
              <form class="" action="/admin/seeReference4" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="candidateFirstName" type="hidden" value="{{ $candidates->firstName }}">
                <input name="candidateLastName" type="hidden" value="{{ $candidates->lastName }}">
                <input name="firstNameReference4" type="hidden" value="{{ $candidateDetails->firstNameReference4 }}">
                <input name="lastNameReference4" type="hidden" value="{{ $candidateDetails->lastNameReference4 }}">
                <input name="positionReference4" type="hidden" value="{{ $candidateDetails->positionReference4 }}">
                <input name="companyReference4" type="hidden" value="{{ $candidateDetails->companyReference4 }}">

                <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%" value="See reference 4"></a>
              </form>
            </div>
            <div class="row" style="display:none;justify-content:flex-start" id="reference5ButtonSendEmail" >
              <form class="" action="/admin/emailReference5" method="post" style="">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="firstNameReference5" type="hidden" value="{{ $candidateDetails->firstNameReference5 }}">
                <input name="lastNameReference5" type="hidden" value="{{ $candidateDetails->lastNameReference5 }}">
                <input name="emailReference5" type="hidden" value="{{ $candidateDetails->emailReference5 }}">
                <input name="positionReference5" type="hidden" value="{{ $candidateDetails->positionReference5 }}">
                <input name="companyReference5" type="hidden" value="{{ $candidateDetails->companyReference5 }}">
                <div class="row" style="margin:0;">
                  <p>{{ $candidateDetails->firstNameReference5 }} {{ $candidateDetails->lastNameReference5 }} Statut: <span style="color:#F14904;">{{ $candidateDetails->statutReference5 }}</span></p>
                  <input type="submit" id="" class="saveclick nooutline" style="float:right;width:25%" value="Send email reference 5"></a>
                </div>
              </form>
              <form class="" action="/admin/seeReference5" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                <input name="candidateFirstName" type="hidden" value="{{ $candidates->firstName }}">
                <input name="candidateLastName" type="hidden" value="{{ $candidates->lastName }}">
                <input name="firstNameReference5" type="hidden" value="{{ $candidateDetails->firstNameReference5 }}">
                <input name="lastNameReference5" type="hidden" value="{{ $candidateDetails->lastNameReference5 }}">
                <input name="positionReference5" type="hidden" value="{{ $candidateDetails->positionReference5 }}">
                <input name="companyReference5" type="hidden" value="{{ $candidateDetails->companyReference5 }}">

                <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%" value="See reference 5"></a>
              </form>
            </div>

          -->


            <div class="">
              <h2>References</h2>
              @foreach($candidateReferences as $candidateReference)
                @if($candidateReference->active != '2')
                <h2 class="orange" style="margin-bottom:0;font-weight:500">Reference details</h2>
                <div class="row" style="margin-top:0.5rem;margin-bottom:0;">
                  <div class="column" style="width:90%">
                    <div class="row" style="margin:0rem">
                      <p class="border-radius reference-fn nooutline">{{ $candidateReference->refereeFirstName }}</p>
                      <p class="border-radius reference-fn nooutline">{{ $candidateReference->refereeLastName }}</p>
                      <p class="border-radius reference-company nooutline">{{ $candidateReference->refereeEmail }}</p>
                    </div>
                    <div class="row" style="margin:0.2rem 0rem 0.2rem 0rem">
                      <p class="border-radius reference-company nooutline">{{ $candidateReference->refereePosition }}</p>
                      <p class="border-radius reference-company nooutline">{{ $candidateReference->refereeCompany }}</p>
                    </div>
                  </div>
                  <!--
                  <form class="" action="/candidate/deleteReferences" method="post">
                      {{ csrf_field() }}
                    <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                    <input name="referenceId" type="hidden" value="{{ $candidateReference->id }}">
                    <button type="submit" style="border:none;background-color:transparent"><i class="fa fa-times" aria-hidden="true"></i></button>
                  </form>
                -->
                </div>
                  <div class="row" style="margin-top:0;">
                    <p>{{ $candidateReference->refereeFirstName }} {{ $candidateReference->refereeLastName }} Active: <span style="color:#F14904;">{{ $candidateReference->active }}</span> Statut: <span style="color:#F14904;">{{ $candidateReference->referenceStatut }}</span></p>

                    <form class="" action="/admin/emailNewReference" method="post" style="width:75%;">
                      {{ csrf_field() }}
                      <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                      <input name="refereeFirstName" type="hidden" value="{{ $candidateReference->refereeFirstName }}">
                      <input name="refereeLastName" type="hidden" value="{{ $candidateReference->refereeLastName }}">
                      <input name="refereeEmail" type="hidden" value="{{ $candidateReference->refereeEmail }}">
                      <input name="refereePosition" type="hidden" value="{{ $candidateReference->refereePosition }}">
                      <input name="refereeCompany" type="hidden" value="{{ $candidateReference->refereeCompany }}">
                      <div class="row" style="margin:0;">
                        <p>{{ $candidateReference->refereeFirstName }} {{ $candidateReference->refereeLastName }} Active: <span style="color:#F14904;">{{ $candidateReference->active }}</span> Statut: <span style="color:#F14904;">{{ $candidateReference->referenceStatut }}</span></p>
                        <input type="submit" id="" class="saveclick nooutline" style="float:right;width:50%" value="Send email reference"></a>
                      </div>
                    </form>


                    <form class="" action="/admin/seeReference" method="post" style="width:25%;">
                      {{ csrf_field() }}
                      <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
                      <input name="referenceId" type="hidden" value="{{ $candidateReference->id }}">

                      <input type="submit" id="" class="saveclick nooutline" style="float:right;width:100%;background: transparent;border: 1px solid #F14904;border-radius: 0.5rem;" value="See reference"></a>
                    </form>


                    <!-- fill reference "manually"
                      <a class="btn" href="https://tietalent.com/reference?token={{hash_hmac('sha256', $candidates->id_user, $candidateReference->token)}}">Add Reference</a>
                    -->


                  </div>
                @endif
              @endforeach
            </div>

            <form class="" action="/admin/candidateLanguagePreference" method="post">
              {{ csrf_field() }}
              <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">
              <div>Language</div>

              <select name="language">
                <option value="">language...</option>
                <option value="en">english</option>
                <option value="fr">french</option>
              </select>

              <div class="row-reverse">
                <input type="submit" class="wp-btn-default saveclick nooutline" value="{{ trans('candidateplatform_home.save') }}"></a>
              </div>
            </form>


            <form class="" action="/admin/candidateConfidentiality" method="post">
              {{ csrf_field() }}
              <input name="candidateIdUser" type="hidden" value="{{ $candidates->id_user }}">

              <h2 class="aligncenter marginbottom-middle">{{ trans('candidateplatform_confidentiality.confidentiality') }}</h1>
                <h3>{{ trans('candidateplatform_confidentiality.confidentialityLevels') }}</h3>
                <p>{{ trans('candidateplatform_confidentiality.confidentialityLevels2') }}
                  <br/>
                  Confidentiality level: <span id="confidentialityLevel" value="{{ $candidateInfos->confidentiality }}">{{ $candidateInfos->confidentiality }}</span>
                </p>
                <div class="row margintop-big" id="confidentialityRow">
                  <div class="col-md-4 confidentialityButton"><input type="radio" name="confidentiality" id="confidentialityOpen" value="0" class="buttondesign threeperline width-full confidentiality-candidatelist-button" checked=""><label id="labelConfidentialityOpen" class="label-buttondesign centeralign width-full">{{ trans('candidateplatform_confidentiality.open') }}</label></div>
                  <div class="col-md-4 confidentialityButton"><input type="radio" name="confidentiality" id="confidentialityHide" value="1" class="buttondesign threeperline width-full confidentiality-candidatelist-button confidentiality-candidatelist-button-add" checked=""><label id="labelConfidentialityHide" class="label-buttondesign centeralign width-full">{{ trans('candidateplatform_confidentiality.close') }}</label></div>
                </div>
                <div id="confidentialityCompanyList">
                  <div class="confidentiality-candidatelist aligncenter row" style="margin:0.5rem 0rem 0.5rem 0rem;display:block">
                    <label for="companytoprevent">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany1" id="confidentialityCompany1_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany1 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany2" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany1" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany2" style="display:none;margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany2" id="confidentialityCompany2_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany2 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany3" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany2" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany3" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany3" id="confidentialityCompany3_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany3 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany4" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany3" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany4" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany4" id="confidentialityCompany4_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany4 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany5" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany4" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany5" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany5" id="confidentialityCompany5_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany5 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany6" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany5" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany6" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany6" id="confidentialityCompany6_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany6 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany7" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany6" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany7" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany7" id="confidentialityCompany7_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany7 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany8" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany7" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany8" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany8" id="confidentialityCompany8_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany8 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany9" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany8" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany9" style="margin:0.5rem 0rem 0.5rem 0rem;display:none;">
                    <label for="companytoprevent" style="opacity:0;">{{ trans('candidateplatform_confidentiality.companyToHideFrom') }}</label>
                    <input type="text" name="confidentialityCompany9" id="confidentialityCompany9_input" class="borderradius width-middleLess margintop-small nooutline" placeholder="{{ trans('candidateplatform_confidentiality.companyName') }}" value="{{ $candidateInfos->confidentialityCompany9 }}">
                    <i class="fa fa-plus nooutline" id="addConfidentialityCompany10" aria-hidden="true"></i>
                    <i class="fa fa-minus nooutline" id="removeConfidentialityCompany9" aria-hidden="true"></i>
                  </div>
                  <div class="confidentiality-candidatelist aligncenter row" id="confidentialityCompany10" style="margin:2rem 0rem 0.5rem 0rem;display:none;">
                    <p>{{ trans('candidateplatform_confidentiality.moreCompaniesToHideFrom') }}</p>
                  </div>
                </div>
                <input type="submit" id="confidentiality_save" class="wp-btn-default saveclick nooutline margintop-middle" style="float:right;width:12%" value="{{ trans('candidateplatform_confidentiality.save') }}"></a>
              </form>



              <button id="adminFillCandidateInterview" class="btn welcome-company-btn-default partner-waitingforinterviewconf-button" style="width:25%;margin-top:10rem;">Fill interview feedback</button>
              <div id="adminFillCandidateInterviewShow" style="display:none;margin-top:13rem;">
                <form class="" action="/admin/candidateInterviewFeedback" method="post">
                  {{ csrf_field() }}
                  <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
                  <div class="row">
                    <input type="text" class="borderradius" name="partner_id_user" value="" placeholder="Partner ID user" required>
                    <input type="text" class="borderradius" name="partnerCompensation" value="" placeholder="Partner compensation" required>
                    <input class="datepickerAdmin borderradius" name="datepicker1" type="text" placeholder="{{ trans('partnerplatform_candidateDetails.day') }}">
                    <input class="timepicker borderradius" name="timepicker1" type="text" placeholder="{{ trans('partnerplatform_candidateDetails.time') }}">
                  </div>


                  <button class="nooutline giveFeedbackOnCandidateInterview" style="padding:0.8rem;border:1px solid #F14904;border-radius:0.5rem;background-color:#F14904;color:white;font-size:1rem;">Fill feedback</button>
                </form>

              </div>


              <div id="validationButtonsAccountPartner" style="margin-top:10rem;">
                <button type="" id="validateCompany" class="wp-btn-default saveclick nooutline centeralign" style="float:left;width:20%;background-color:#333333;color:#F14904">Delete account</button>
              </div>
              <div id="companyValidated" style="display:none;padding-top:3rem;text-align:center;">
                <form action="/admin/deleteCandidate" method="post">
                  {{ csrf_field() }}
                  <input name="idUser" type="hidden" value="{{ $candidates->id_user }}">
                  <h3>Are you sure you want to remove this user account from the database?</h3>
                  <button type="button" class="goBackToValidationButtons btn welcome-company-btn-default partner-waitingforinterviewconf-button" style="width:25%;background-color:#333333">Go back</button>
                  <button type="submit" class="btn welcome-company-btn-default partner-waitingforinterviewconf-button" style="width:25%;">Yes</button>
                </form>
              </div>


        </div>

      </article>
      <span class="clear">&nbsp;</span>
      </div>
    </main>
    <footer id="footer">
      <p><big>2017 - TieTalent</big></p>
        <form class="" action="language" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <select class="language" name="locale">
            <option id="language-english" value="en" class="language-selection" {{ App::getLocale() == 'en' ? ' selected' : '' }}>English</option>
            <option id="footer-hidden-language-menu" value="fr" class="language-selection" {{ App::getLocale() == 'fr' ? ' selected' : '' }}>Français</option>
          </select>
          <input type="submit" value="Submit" id="language-selection-submit" style="display:none;">
        </form>
        <p class="social">
          <a href="https://www.linkedin.com/company-beta/11010661/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
        </p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('public/js/clients.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/candidateplatform.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/candidateConfidentiality.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/partnerplatform.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQqLBvJ2mFzZNq1LpeFooWD7bREfQWMZI&libraries=places"></script>
    <script src="{{ asset('public/js/jquery.geocomplete.min.js') }}"></script>
    <script src="{{ asset('public/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('public/js/picker.js') }}"></script>
    <script src="{{ asset('public/js/picker.date.js') }}"></script>
    <script src="{{ asset('public/js/picker.time.js') }}"></script>
  </body>
</html>
