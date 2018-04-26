

<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('candidateplatform_registrationform.pagetitle') }}</title>
      <meta name="description" content="content of the description" />
      <meta name="recruitment" content="---"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="{{ asset('public/css/main.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/bootstrap-slider.min.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/animate.css') }}" type="text/css" />
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
    <div class="wrapper">
      <nav role='navigation' class="topbar">
        <a href="/"><img class="logo" id="logoTieTalentSmallMenu" width="150px"src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="logo" title="logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/" id="logoTieTalent"><img class="logo" width="150px"src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;padd" alt="logo" title="logo"/></a>
        <ul class="nav">
          <li>
            <a href="/candidates/welcome"><span class="orange">{{ trans('welcomecandidate.headercandidatetitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
            <ul>
              <li><a href="/candidates/welcome">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
              <li><a href="/candidates/faq">{{ trans('welcomecandidate.headercandidatefaq') }}</a></li>
            </ul>
          </li>
          <li>
            <a href="/companies/welcome">{{ trans('welcomecandidate.headercompanytitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
            <ul>
              <li><a href="/companies/welcome">{{ trans('welcomecandidate.headercompanyhiw') }}</a></li>
              <li><a href="/companies/faq">{{ trans('welcomecandidate.headercompanyfaq') }}</a></li>
            </ul>
          </li>
          <li>
            <a href="/partners/welcome">{{ trans('welcomecandidate.headerpartnertitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
            <ul>
              <li><a href="/partners/welcome">{{ trans('welcomecandidate.headerpartnerhiw') }}</a></li>
              <li><a href="/partners/faq">{{ trans('welcomecandidate.headerpartnerfaq') }}</a></li>
            </ul>
          </li>
          <li style="width:15%;"><a href="/home">Login</a></li>
          <li style="width:20%;color:#333333;line-height:2.6rem;margin:0 auto;padding-top:0.4rem;"><i class="fa fa-globe" aria-hidden="true" style="font-size:1.3rem;"></i>
            <form class="" action="language" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <select class="language displayLanguage" name="locale" style="display:none;">
                <option id="language-english" value="en" class="language-selection" {{ App::getLocale() == 'en' ? ' selected' : '' }}>English</option>
                <option id="footer-hidden-language-menu" value="fr" class="language-selection" {{ App::getLocale() == 'fr' ? ' selected' : '' }}>Français</option>
              </select>
              <input type="submit" value="Submit" id="language-selection-submit" style="display:none;">
            </form>
          </li>
        </ul>
      </nav>
    </div>
    <main id="candidateregistrationform" style="height:92rem;">
      <h1 class="headlineRegistrationform">{{ trans('candidateplatform_registrationform.welcome') }}</h1>
            <!-- multistep form -->
            <form id="msform" action="/step/candidate" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="firstName" type="hidden" value="{{ $firstName }}">
                <input name="lastName" type="hidden" value="{{ $lastName }}">
                <input name="candidate_email" type="hidden" value="{{ $candidate_email }}">
                <input name="password" type="hidden" value="{{ $password }}">
                <input type="hidden" name="locale" value='{{ App::getLocale() }}'>

              <!-- progressbar -->
              <ul id="progressbar" class="headlineRegistrationform">
                <li class="active">{{ trans('candidateplatform_registrationform.job') }}</li>
                <li>{{ trans('candidateplatform_registrationform.today') }}</li>
                <li>{{ trans('candidateplatform_registrationform.mobility') }}</li>
                <li>{{ trans('candidateplatform_registrationform.profile') }}</li>
              </ul>
               <!-- fieldsets -->

        <fieldset>
          <h2 class="fs-title">{{ trans('candidateplatform_registrationform.profile') }}</h2>
          <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">CV</h3>
          <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.uploadCV') }}</h3>

          <div class="file-upload" style="padding-top:0;">
            <div class="image-upload-wrap">
              <input type='file' value="" name="document" class="file-upload-input" onchange="readURL(this);" />
              <div class="drag-text">
                <h3>{{ trans('candidateplatform_documents.dragDrop') }}</h3>
              </div>
            </div>
          </div>
          <div id="documentDetails" style="display:none;">
            <h5 class="document-title orange"></h5>
            <h3>{{ trans('partnerplatform_documents.documentDetails') }}:</h3>
            <select class=" borderradius nooutline" name="docType" id="docType" style="background-color:white;height:2.5rem;color:#333333;width:10%;">
              <option value="CV" class="language-selection">CV</option>
            </select>

            <select class=" borderradius nooutline" name="docLanguage" style="background-color:white;height:2.5rem;color:#333333;">
              <option value="selectDocLanguage" disabled selected>{{ trans('partnerplatform_documents.languageDocument') }}</option>
              <option value="English" class="language-selection">English</option>
              <option value="Francais" class="language-selection">Français</option>
              <option value="German" class="language-selection">German</option>
            </select>

            <div class="file-upload-content flexcentermiddle">
              <div class="image-title-wrap row" style="width:50%;">
                <button type="button" onclick="removeUpload()" class="remove-CV" style="height:4rem;margin-top:1.5rem;width:100%">{{ trans('candidateplatform_documents.remove') }}<br/><span class="image-title"><small>{{ trans('candidateplatform_documents.uploadedDoc') }}</small></span></button>
              </div>
            </div>
          </div>

                <!--
                  <div id="candidateCompanyTypeChoice">
                    <h3 class="fs-subtitle" style="font-size:1.17rem;">{{ trans('candidateplatform_registrationform.companyType') }} *</h3>
                    <p id="alert_candidateCompanyType" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertCompanyType') }} <i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                    <div class="radioinput">
                      <div class="row">
                        <div class="col-md-3"><input type="radio" id="candidateStartUpchoice" name="companytype" value="StartUp" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.promisingStartUp') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="candidateMultinationalechoice" name="companytype" value="Multinational" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.multinationale') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="candidateSMEchoice" name="companytype" value="SME" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.sme') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="candidateNGOchoice" name="companytype" value="NGO" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.ngo') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="candidateOtherCompanyTypeChoice" name="companytype" value="Other" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.other') }}</label></div>
                      </div>
                    </div>
                    <input type="text" id="candidateOtherCompanyType" name="companytype_other" placeholder="{{ trans('candidateplatform_registrationform.whatOtherCompany') }}"/>
                  </div>
                -->

                  <div id="candidateDivisionChoice">
                    <h3 class="fs-subtitle" style="font-size:1.17rem;">{{ trans('candidateplatform_registrationform.division') }} *</h3>
                    <p id="alert_candidateDivision" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.selectDivision') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                    <div class="radioinput">
                      <div class="row registrationFormRow">
                        <div class="col-md-4"><input type="radio" id="candidateFandADivisionChoice" name="division" value="Finance & Accounting" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.financeAccounting') }}</label></div>
                        <div class="col-md-4"><input type="radio" name="division" value="Human Resources - Recruitment" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.hrRecruitment') }}</label></div>
                        <div class="col-md-4"><input type="radio" name="division" value="Sales - Marketing - Communications" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.salesMarketingCommunications') }}</label></div>
                        <div class="col-md-4"><input type="radio" name="division" value="Information Technology" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.IT') }}</label></div>
                      </div>
                      <!--
                      <div class="row">
                        <div class="col-md-4"><input type="radio" name="division" value="Office Support - Secretarial" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.officeSupport') }}</label></div>
                        <div class="col-md-4"><input type="radio" name="division" value="Legal" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.legal') }}</label></div>
                        <div class="col-md-4"><input type="radio" name="division" value="Procurement & Supply Chain" class="formchoicebutton threeperline" required><label>{{ trans('partnerplatform_registrationform.supplyChain') }}</label></div>
                      </div>
                    -->
                    </div>
                  </div>
                  <input type="text" id="candidateOtherDivision" name="division_other" placeholder="{{ trans('candidateplatform_registrationform.whatOtherDivision') }}"/>

                  <!--
                  <div id="candidateDepartmentFandA">
                    <h3 class="fs-subtitle"> {{ trans('candidateplatform_registrationform.department') }}</h3>
                      <div class="radioinput">
                        <div class="row">
                          <div class="col-md-4"><input type="radio" id="candidateAccountingDepartmentChoice" name="department" value="Accounting" class="candidateDepartmentChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.accounting') }}</label></div>
                          <div class="col-md-4"><input type="radio" id="candidateFandCDepartmentChoice" name="department" value="Finance & Controlling" class="candidateDepartmentChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.financeControlling') }}</label></div>
                          <div class="col-md-4"><input type="radio" id="candidateTaxandTreasuryDepartmentChoice" name="department" value="Tax & Treasury" class="candidateDepartmentChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.taxTreasury') }}</label></div>
                          <div class="col-md-4"><input type="radio" id="candidateFandAOtherDepartmentChoice" name="department" value="Other" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.other') }}</label></div>
                        </div>
                      </div>
                    </div>
                    <input type="text" id="candidateFandAOtherDepartment" name="department_other" placeholder="{{ trans('candidateplatform_registrationform.whatOtherDepartment') }}"/>

                    <div id="candidateFunctionsFandA">
                      <div id="candidateFunctionAccounting">
                        <h3 class="fs-subtitle"> {{ trans('candidateplatform_registrationform.function') }}
                        <br/> <small>{{ trans('candidateplatform_registrationform.max1choice') }}<i class="fa fa-question-circle" aria-hidden="true"></i></small></h3>
                        <div class="radioinput">
                          <div class="row">
                            <div class="col-md-4"><input type="radio" name="function" value="Accounts Payable" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.accountsPayable') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Accounts Receivable" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.accountsReceivable') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="General Ledger" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.generalLedger') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Payroll Specialist" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.payroll') }}</label></div>
                          </div>
                          <div class="row">
                            <div class="col-md-4"><input type="radio" name="function" value="Credit Analyst" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.creditAnalyst') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Internal Audit" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.internalAudit') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="External Audit" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.externalAudit') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Other" class="candidateOtherFunctionChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.other') }}</label></div>
                          </div>
                        </div>
                      </div>

                      <div id="candidateFunctionFandC">
                      <h3 class="fs-subtitle"> {{ trans('candidateplatform_registrationform.function') }}
                        <br/> <small>{{ trans('candidateplatform_registrationform.max1choice') }}<i class="fa fa-question-circle" aria-hidden="true"></i></small></h3>
                        <div class="radioinput">
                          <div class="row">
                            <div class="col-md-4"><input type="radio" name="function" value="Industrial Controller" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.industrialController') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Analyst / FP&A" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.analyst') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Consolidation / Reporting" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.consolidation') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Other" class="candidateOtherFunctionChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.other') }}</label></div>
                          </div>
                        </div>
                      </div>

                      <div id="candidateFunctionTaxandTreasury">
                      <h3 class="fs-subtitle"> {{ trans('candidateplatform_registrationform.function') }}
                        <br/> <small>{{ trans('candidateplatform_registrationform.max1choice') }}<i class="fa fa-question-circle" aria-hidden="true"></i></small></h3>
                        <div class="radioinput">
                          <div class="row">
                            <div class="col-md-4"><input type="radio" name="function" value="VAT Accountant" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.vatAccountant') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Tax Analyst" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.taxAnalyst') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Treasury Analyst" class="formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.treasuryAnalyst') }}</label></div>
                            <div class="col-md-4"><input type="radio" name="function" value="Other" class="candidateOtherFunctionChoice formchoicebutton threeperline"><label>{{ trans('candidateplatform_registrationform.other') }}</label></div>
                          </div>
                        </div>
                      </div>
                      <div>
                          <input type="text" id="candidateOtherFunction" name="function_other" value="" placeholder="{{ trans('candidateplatform_registrationform.whatOtherFunction') }}"/>
                      </div>
                    </div>
                  -->
                    <div id="salaryExpectations">
                      <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.salaryExpectations') }}</h3>
                      <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.salaryExpectations2') }}</h3>
                      <p style="color:#333333;">{{ trans('candidateplatform_registrationform.salaryExpectations3') }}</p>

                      <h5 class="salary color-dark">{{ trans('candidateplatform_registrationform.dragSliderExpectations') }}</h5>
                      <div class="row">
                        <input id="candidateSalaryExpectations" name="salaryExpectations" value="" data-slider-min="50000" data-slider-max="130000"   data-slider-tooltip="hide" data-slider-value="75000" data-slider-step="1000" required>
                      </div>
                    </div>
                    <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.contractType') }}</h3>
                    <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.contractType2') }}</h3>

                    <div class="radioinput">
                      <div class="row registrationFormRow">
                        <div class="col-md-4"><input type="checkbox" name="contractTypePermanent" value="permanent" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_registrationform.permanent') }}<br/><small>{{ trans('candidateplatform_registrationform.permanent2') }}</small></label></div>
                        <div class="col-md-4"><input type="checkbox" name="contractTypeTH" value="try & hire" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_registrationform.TH') }}<br/><small>{{ trans('candidateplatform_registrationform.TH2') }}</small></label></div>
                        <div class="col-md-4"><input type="checkbox" name="contractTypeTemporary" value="temporary" class="formchoicebutton threeperline"><label class="column">{{ trans('candidateplatform_registrationform.temporary') }}<br/><small>{{ trans('candidateplatform_registrationform.temporary2') }}</small></label></div>
                      </div>
                    </div>
                    <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.occupationRate') }}</h3>
                    <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.occupationRate2') }}</h3>
                    <h5 class="partTime color-dark">{{ trans('candidateplatform_registrationform.dragSliderExpectations') }}</h5>
                    <div class="row" style="display:inline;">
                      <input id="candidatePartTime" name="partTime" type="text" value="" data-slider-tooltip="hide" /><br/>
                    </div>



                <input type="button" name="next" id="nextTest" style="margin-top:3rem;" class="next action-button" value="{{ trans('candidateplatform_registrationform.next') }}" />
              </fieldset>
              <fieldset>
          		  <h2 class="fs-title">{{ trans('candidateplatform_registrationform.aboutToday') }}</h2>

                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.workPermit') }}</h3>
                <p id="alert_candidateWorkPermit" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertWorkPermit') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <div class="radioinput">
                  <div class="row registrationFormRow">
                    <div class="col-md-6"><input type="radio" name="workPermit" value="No" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.no') }}</label></div>
                    <div class="col-md-6"><input type="radio" name="workPermit" value="Yes" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.yes') }}</label></div>
                  </div>
                </div>
                <!--
                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.jobToday') }} *</h3>
                <p id="alert_candidateHasJob" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertJobToday') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <div class="radioinput">
                  <div class="row">
                    <div class="col-md-6"><input type="radio" name="job" value="0" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.no') }}</label></div>
                    <div class="col-md-6"><input type="radio" name="job" value="1" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.yes') }}</label></div>
                  </div>
                </div>
              -->
                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.whenAvailable') }}</h3>
                <h3 class="availability">{{ trans('candidateplatform_registrationform.dragSliderAvailability') }}</h3>
                <div class="row">
                  <input id="candidateAvailability" name="availability" value="" data-slider-min="1" data-slider-max="6"   data-slider-tooltip="hide" data-slider-value="3" required>
                </div>


                <h3 class="fs-subtitle" style="margin-bottom:1rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.reasonLooking') }} *</h3>
                <p id="alert_candidateReasonJobSearch" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertReasonLooking') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <p style="color:#333333"><i>{{ trans('candidateplatform_registrationform.reasonLooking2') }}</i></p>
                <textarea cols="40" name="reasonJobSearch" rows="2" id="candidateReasonForJobSearch" maxlength="255" required></textarea>
                </br>
                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.mobility2') }}</h3>
                <h3 class="mobility">{{ trans('candidateplatform_registrationform.dragSliderMobility') }}</h3>
                <div class="row">
                  <input id="candidateMobility" name="mobility" data-slider-min="1" data-slider-max="5"   data-slider-tooltip="hide" data-slider-value="2" required>
                </div>
                <h3 class="fs-subtitle" style="margin-bottom:1rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.whatAddress') }} *</h3>
                <p id="alert_candidateAddress" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertAddress') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <p style="color:#333333"><i>{{ trans('candidateplatform_registrationform.whatAddress2') }}</i></p>
          		   <input type="text" id="candidateAddress" name="candidateAddress"  placeholder="{{ trans('candidateplatform_registrationform.address') }}" required/>  <!-- onchange="doGeocode()" qu'on peut rajouter dans cet input si besoin (mais pas défini)-->
          		  <input type="button" name="previous" id="candidateRegistrationFormPreviousTo1" class="previous action-button" value="{{ trans('candidateplatform_registrationform.previous') }}" />
                <input type="button" name="next" class="next action-button" value="{{ trans('candidateplatform_registrationform.next') }}" />
          	  </fieldset>
              <fieldset>
          		  <h2 class="fs-title">{{ trans('candidateplatform_registrationform.mobility') }}</h2>

                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.car') }} *</h3>
                <p id="alert_candidateCar" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertCar') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <div class="radioinput">
                  <div class="row registrationFormRow">
                    <div class="col-md-6"><input type="radio" name="car" value="0" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.no') }}</label></div>
                    <div class="col-md-6"><input type="radio" name="car" value="1" class="formchoicebutton threeperline" required><label>{{ trans('candidateplatform_registrationform.yes') }}</label></div>
                  </div>
                </div>
                </br>
                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.linkedIn') }}</h3>
                <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.linkedIn2') }}</h3>

                <input type="text" id="candidateLinkedInProfileURL" name="linkedIn" placeholder="{{ trans('candidateplatform_registrationform.linkedIn3') }}"/>

                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.skype') }}</h3>
                <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.skype2') }}</h3>


                <input type="text" name="candidate_skype" placeholder="{{ trans('candidateplatform_registrationform.skype') }}"/>
                <h3 class="fs-subtitle" style="margin-bottom:0rem;font-size:1.17rem;">{{ trans('candidateplatform_registrationform.referrals') }}</h3>
                <h3 style="font-weight:normal;color:#333333;font-size:1rem;margin-top:0.5rem;">{{ trans('candidateplatform_registrationform.referrals2') }}
                  <br/><small>{{ trans('candidateplatform_registrationform.ex') }} HeDjiuYTmPji</small>
                </h3>
                <input type="text" name="candidateReferralShareCode" placeholder="{{ trans('candidateplatform_registrationform.referrals3') }}"/>
          		  <input type="button" name="previous" id="candidateRegistrationFormPreviousTo2" class="previous action-button" value="{{ trans('candidateplatform_registrationform.previous') }}" />
          		  <input type="button" name="next" class="next action-button" value="{{ trans('candidateplatform_registrationform.next') }}" />
          	  </fieldset>

              <fieldset>
          		  <h2 class="fs-subtitle">{{ trans('candidateplatform_registrationform.profile') }}</h2>



<!--
                <h3 class="fs-subtitle">And / Or</h3>
                <div class="file-upload">
                  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add CV</button>
                  <div class="image-upload-wrap">
                    <input class="file-upload-input" type="file" name="candidateCV" onchange="readURL(this);" accept="image/*" />
                    <div class="drag-text">
                      <h3>Drag and drop a file or select Add CV</h3>
                    </div>
                  </div>
                  <div class="file-upload-content">
                    <img class="file-upload-image" src="#" alt="your image" />
                    <div class="image-title-wrap">
                      <button type="button" onclick="removeUpload()" class="remove-CV">Remove <span class="image-title">Uploaded CV</span></button>
                    </div>
                  </div>
                </div> -->
                <p id="alert_candidateReasonGeneral" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('candidateplatform_registrationform.alertReasonLookingGeneral') }} <i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <p id="alert_candidateReasonGeneralCompanyType" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralCompanyType') }}</p>
                <p id="alert_candidateReasonGeneralDivision" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralDivision') }}</p>
                <p id="alert_candidateReasonGeneralJob" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralJob') }}</p>
                <p id="alert_candidateReasonGeneralReasonLooking" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralReason') }}</p>
                <p id="alert_candidateReasonGeneralAddress" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralAddress') }}</p>
                <p id="alert_candidateReasonGeneralCar" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;margin:0 auto;">* {{ trans('candidateplatform_registrationform.alertReasonLookingGeneralCar') }}</p>

          		  <input type="button" name="previous" id="candidateRegistrationFormPreviousTo3" class="previous action-button" value="{{ trans('candidateplatform_registrationform.previous') }}" />
                <button type="submit" name="button" id="candidateRegistrationFormSubmit" style="background:transparent; border:none; outline:0;"><input type="submit" class="button centeralign" value="{{ trans('candidateplatform_registrationform.validate') }}" style="border:none; background:#28A55F; padding:10px 5px; margin:10px 5px; color:white; width:100px; outline:0"></button>
          	  </fieldset>





            </form>




    </main>
    <footer id="footer">
      <p><big>2017 - TieTalent</big></p>
        <p class="social">
          <a href="https://www.linkedin.com/company-beta/11010661/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
        </p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('public/js/candidateplatform.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/clients.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQqLBvJ2mFzZNq1LpeFooWD7bREfQWMZI&libraries=places"></script>
    <script src="{{ asset('public/js/jquery.geocomplete.min.js') }}"></script>
    <script src="{{ asset('public/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('public/js/picker.js') }}"></script>
    <script src="{{ asset('public/js/picker.date.js') }}"></script>
    <script src="{{ asset('public/js/picker.time.js') }}"></script>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90353807-1', 'auto');
  ga('send', 'pageview');

</script>
  </body>
</html>
