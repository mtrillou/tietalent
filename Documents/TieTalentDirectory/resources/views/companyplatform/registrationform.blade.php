

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
      <h1 class="headlineRegistrationform" style="margin-bottom:0rem;margin-top:0rem;"><!--{{ trans('candidateplatform_registrationform.welcome') }}--></h1>
            <!-- multistep form -->
            <form id="msform" action="/step/company" method="post">
                {{ csrf_field() }}
                <input name="firstName" type="hidden" value="{{ $firstName }}">
                <input name="lastName" type="hidden" value="{{ $lastName }}">
                <input name="company" type="hidden" value="{{ $company }}">
                <input name="company_email" type="hidden" value="{{ $company_email }}">
                <input name="phone" type="hidden" value="{{ $phone }}">
                <input name="password" type="hidden" value="{{ $password }}">
                <input type="hidden" name="locale" value='{{ App::getLocale() }}'>
              <!-- progressbar -->
              <ul id="progressbar">
                <li class="active">{{ trans('companyplatform_registrationform.company') }}</li>
                <li>{{ trans('companyplatform_registrationform.office') }}</li>
                <li>{{ trans('companyplatform_registrationform.vacancy') }}</li>
              </ul>
               <!-- fieldsets -->

        <fieldset>
                <h2 class="fs-title">{{ trans('companyplatform_registrationform.aboutCompany') }}</h2>
                    <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.companyType') }} *
                      <br/><small>{{ trans('companyplatform_registrationform.companyType2') }}</small>
                    </h3>
                    <p id="alert_companyType" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('companyplatform_registrationform.selectCompanyType') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                    <div class="radioinput" id="companyType">
                      <div class="row registrationFormRow">
                        <div class="col-md-3"><input type="radio" name="companyType" value="Promising Startup" class="formchoicebutton threeperline" required><label>{{ trans('companyplatform_registrationform.startUp') }}</label></div>
                        <div class="col-md-3"><input type="radio" name="companyType" value="Renowed Multinational" class="formchoicebutton threeperline" required><label>{{ trans('companyplatform_registrationform.multinationale') }}</label></div>
                        <div class="col-md-3"><input type="radio" name="companyType" value="Sustainable SME" class="formchoicebutton threeperline" required><label>{{ trans('companyplatform_registrationform.sme') }}</label></div>
                        <div class="col-md-3"><input type="radio" name="companyType" value="NGO" class="formchoicebutton threeperline" required><label>{{ trans('companyplatform_registrationform.ngo') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="companyOtherTypeChoice" name="companyType" value="Other" class="formchoicebutton threeperline" required><label>{{ trans('companyplatform_registrationform.other') }}</label></div>
                      </div>
                    </div>
                    <input type="text" id="companyOtherType" name="companyType_other" style="display:none;" placeholder="{{ trans('companyplatform_registrationform.whatOtherType') }}"/>
                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.website') }}</h3>
                  <input type="text" name="companywebsite" placeholder="{{ trans('companyplatform_registrationform.insertWebsite') }}"/>
                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.numberEmployeesWorld') }}
                    <br/><small>{{ trans('companyplatform_registrationform.numberEmployeesWorld2') }}</small>
                  </h3>
                  <select class="selectCompanySize" name="numberEmployeesWorld" >
                    <option value="1 - 10">1 - 10</option>
                    <option value="11 - 20">11 - 20</option>
                    <option value="21 - 50">21 - 50</option>
                    <option value="51 - 150">51 - 150</option>
                    <option value="151 - 500">151 - 500</option>
                    <option value="501 - 1000">501 - 1000</option>
                    <option value="1001 - 5000">1001 - 5000</option>
                    <option value="5001 - 10000">5001 - 10000</option>
                    <option value="10000+">10000+</option>
                  </select>
                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.companyHQ') }} *
                    <br/><small>{{ trans('companyplatform_registrationform.companyHQ2') }}</small>
                  </h3>
                  <p id="alert_HQAddress" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('companyplatform_registrationform.enterAddressHQ') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                  <input type="text" id="companyHQ" name="companyHQ"  placeholder="{{ trans('companyplatform_registrationform.placeholderAddressHQ') }}" required/>
                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.listed') }}
                    <br/><small>{{ trans('companyplatform_registrationform.listed2') }}</small>
                  </h3>
                  <div class="radioinput">
                    <div class="row registrationFormRow">
                      <div class="col-md-4"><input type="radio" name="listed" value="Listed" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.yes') }}</label></div>
                      <div class="col-md-4"><input type="radio" name="listed" value="Not listed" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.no') }}</label></div>
                    </div>
                  </div>
                <input type="button" name="next" class="next action-button" value="{{ trans('companyplatform_registrationform.next') }}" />
              </fieldset>


              <fieldset>
          		  <h2 class="fs-title">{{ trans('companyplatform_registrationform.aboutOffice') }}</h2>
                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.officeRole') }}
                  <br/><small>{{ trans('companyplatform_registrationform.officeRole2') }}</small>
                </h3>
                <div class="radioinput" id="officeRole">
                  <div class="row registrationFormRow">
                    <div class="col-md-3"><input type="radio" name="officeRole" value="Worldwide Headquarters" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.wwHQ') }}</label></div>
                    <div class="col-md-3"><input type="radio" name="officeRole" value="Regional Headquarters" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.regionalHQ') }}</label></div>
                    <div class="col-md-3"><input type="radio" name="officeRole" value="Shared Services Center" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.SSC') }}</label></div>
                    <div class="col-md-3"><input type="radio" name="officeRole" value="NGO" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.localBusinessOffice') }}</label></div>
                    <div class="col-md-3"><input type="radio" id="officeOtherRoleChoice" name="officeRole" value="Other" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.other') }}</label></div>
                  </div>
                </div>
                <input type="text" id="officeOtherRole" name="officeRole_other" style="display:none;" placeholder="{{ trans('companyplatform_registrationform.whatOtherRole') }}"/>



                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.officeAddress') }} *
                  <br/><small>{{ trans('companyplatform_registrationform.officeAddress2') }}</small>
                </h3>
                <p id="alert_OfficeAddress" style="display:none;border-radius:0.5rem; color:red; padding:0.2rem;"><big><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ trans('companyplatform_registrationform.alertOfficeAddress') }}<i class="fa fa-exclamation-circle" aria-hidden="true"></i></big></p>
                <input type="text" id="officeAddress" name="officeAddress"  placeholder="{{ trans('companyplatform_registrationform.placeholderOfficeAddress') }}" required/>


                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.numberEmployeesOffice') }}
                  <br/><small>{{ trans('companyplatform_registrationform.numberEmployeesOffice2') }}</small>
                </h3>
                <select class="selectOfficeSize" name="numberEmployeesOffice" >
                  <option value="1 - 10">1 - 10</option>
                  <option value="11 - 20">11 - 20</option>
                  <option value="21 - 50">21 - 50</option>
                  <option value="51 - 150">51 - 150</option>
                  <option value="151 - 500">151 - 500</option>
                  <option value="501 - 1000">501 - 1000</option>
                  <option value="1001 - 5000">1001 - 5000</option>
                  <option value="5001 - 10000">5001 - 10000</option>
                  <option value="10000+">10000+</option>
                </select>


                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.departmentsInOffice') }}
                    <br/><small>{{ trans('companyplatform_registrationform.departmentsInOffice2') }}</small>
                  </h3>
                  <div class="radioinput" id="officeDepartments">
                    <div class="row registrationFormRow">
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentFinanceAccounting" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.financeAccounting') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentHR" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.hrRecruitment') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentSalesMarketingCommunications" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.salesMarketingCommunications') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentIT" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.IT') }}</label></div>
                    </div>
                    <div class="row registrationFormRow">
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentOfficeSupport" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.officeSupport') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentLegal" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.legal') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="officeDepartmentmentSupplyChain" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.supplyChain') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" id="officeOtherDepartmentChoiceOther" name="officeDepartmentOther" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.other') }}</label></div>
                    </div>
                  </div>
                  <input type="text" id="officeOtherDepartment" name="officeDepartment_other" style="display:none;" placeholder="{{ trans('companyplatform_registrationform.whatOtherDepartment') }}"/>





          		  <input type="button" name="previous" class="previous action-button" value="{{ trans('companyplatform_registrationform.previous') }}" />
                <input type="button" name="next" class="next action-button" value="{{ trans('companyplatform_registrationform.next') }}" />
          	  </fieldset>
              <fieldset>
                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.numberRecruitmentsOffice') }}
                  <br/><small>{{ trans('companyplatform_registrationform.numberRecruitmentsOffice2') }}</small>
                </h3>
                <select class="selectNumberRecruitment" name="numberRecruitment" >
                  <option value="0 - 1">0 - 1</option>
                  <option value="2 - 5">2 - 5</option>
                  <option value="6 - 20">6 - 20</option>
                  <option value="21 - 50">21 - 50</option>
                  <option value="51 - 200">51 - 200</option>
                  <option value="200+">200+</option>
                </select>

                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.vacancyToFill') }}</h3>
                <div class="radioinput" id="vacancyToFill">
                  <div class="row registrationFormRow">
                    <div class="col-md-4"><input type="radio" name="vacancyToFill" id="vacancyToFillYes" value="Yes" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.yes') }}</label></div>
                    <div class="col-md-4"><input type="radio" name="vacancyToFill" value="No" class="formchoicebutton threeperline" ><label>{{ trans('companyplatform_registrationform.no') }}</label></div>
                  </div>
                </div>

                <div id="vacancyToFill_Departments" style="display:none;">
                  <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.whichDepartments') }}
                    <br/><small>{{ trans('companyplatform_registrationform.whichDepartments2') }}</small>
                  </h3>
                  <div class="radioinput" id="vacancyDepartments">
                    <div class="row registrationFormRow">
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentFinanceAccounting" value="Finance & Accounting" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.financeAccounting') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentHR" value="HR" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.hrRecruitment') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentSalesMarketingCommunications" value="Sales - Marketing - Communications" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.salesMarketingCommunications') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentIT" value="Information Technology" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.IT') }}</label></div>
                    </div>
                    <div class="row registrationFormRow">
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentOfficeSupport" value="Office Support - Secretarial" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.officeSupport') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentLegal" value="Legal" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.legal') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" name="vacancyDepartmentmentSupplyChain" value="Procurement & Supply Chain" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.supplyChain') }}</label></div>
                      <div class="col-md-4"><input type="checkbox" id="officeOtherDepartmentChoiceOther" name="vacancyDepartmentOther" value="Other" class="formchoicebutton threeperline"><label>{{ trans('companyplatform_registrationform.other') }}</label></div>
                    </div>
                  </div>
                  <input type="text" id="vacancyOtherDepartment" name="vacancyDepartment_other" style="display:none;" placeholder="{{ trans('companyplatform_registrationform.vacancyWhichOtherDepartment') }}"/>
                </div>

                <h3 class="fs-subtitle">{{ trans('companyplatform_registrationform.referrals') }}
                  <br/><small>{{ trans('companyplatform_registrationform.referrals2') }}
                  <br/>{{ trans('candidateplatform_registrationform.ex') }} HeDjiuYTmPji</small>
                </h3>
                <input type="text" name="companyReferralShareCode" placeholder="{{ trans('companyplatform_registrationform.referrals3') }}"/>

          		  <input type="button" name="previous" class="previous action-button" value="{{ trans('companyplatform_registrationform.previous') }}" />
          		  <button type="submit" name="button" id="companyRegistrationFormSubmit" style="background:transparent; border:none; outline:0;"><input type="submit" class="button centeralign" value="{{ trans('companyplatform_registrationform.validate') }}" style="border:none; background:#28A55F; padding:10px 5px; margin:10px 5px; color:white; width:100px; outline:0"></button>
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
    <script src="{{ asset('public/js/companyplatform.js') }}" type="text/javascript"></script>
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
