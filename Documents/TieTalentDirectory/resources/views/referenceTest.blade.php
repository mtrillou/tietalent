


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('reference.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcomecompany.pageDescription') }}" />
      <meta name="recruitment" content="---"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="{{ asset('public/css/newMain.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/animate.css') }}" type="text/css" />

      <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">

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
      <!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = 'eiwwzCto9Z6CffBXo';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
        + '//call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<script>
window.ChatraSetup = {
    colors: {
        buttonText: '#f0f0f0', /* chat button text color */
        buttonBg: '#F14904'    /* chat button background color */
    }
};
</script>
<!-- /Chatra {/literal} -->
  </head>
  <body>
    <div class="container-fluid">
     <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img width="150px" id="tietalentLogoWebsite" src="{{ asset('public/img/logott.png') }}" alt="TieTalent logo" title="TieTalent logo"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="smallButton"><a href="/about">{{ trans('welcomecandidate.about') }}</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('welcomecandidate.headercandidatetitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
                <li><a href="/candidates/welcome" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
                <li><a href="/candidates/faq" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercandidatefaq') }}</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('welcomecandidate.headercompanytitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
                <li><a href="/companies/welcome" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercompanyhiw') }}</a></li>
                <li><a href="/companies/pricing" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercompanypricing') }}</a></li>
                <li><a href="/companies/faq" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercompanyfaq') }}</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('welcomecandidate.headerpartnertitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
                <li><a href="/partners/welcome" class="centeralign paddingSmall">{{ trans('welcomecandidate.headerpartnerhiw') }}</a></li>
                <li><a href="/partners/faq" class="centeralign paddingSmall">{{ trans('welcomecandidate.headerpartnerfaq') }}</a></li>
              </ul>
            </li>
            <li class="smallButton"><a href="/home"><i class="fa fa-unlock" aria-hidden="true" style="margin-right: 0.3rem;"></i> Login</a></li>
            <li class="smallButton"><a href="/signup" class="orange">{{ trans('welcomecandidate.signUp2') }}</a></li></li>
            <li class="darkGreyColor verySmallButton">
              <i class="fa fa-globe" aria-hidden="true" style="font-size:1.3rem;"></i>
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
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </div><!-- end container -->

    <main id="mainConditions" style="padding-top:5rem;">
      <div class="form-wrap signup-form-wrap" id="referenceForm">
      		<div class="tabs">
      			<h1 class="candidate-tab" id="referenceTitle"><a id="candidate-title-content" class="active" href="#candidate-tab-content">{{ trans('reference.referenceFor') }} Antoine Dumoulins</a></h1>
      		</div><!--.tabs-->
      		<div class="tabs-content">
      			<div id="candidate-tab-content" class="active">
              <h2>John {{ trans('reference.referenceFor2') }}
                <br/><small>{{ trans('reference.referenceFor3') }}</small>
              </h2>


                <h3>{{ trans('reference.aboutYou') }}</h3>
                <div class="row" style="margin-top:0rem;" id="referenceIdentityRow">
                  <p id="alert_partner_fname" style="display:none; margin:0rem; color:red;">{{ trans('signup.alert_candidate_element_one') }}</p>
                  <input type="" class="input referenceIdentityFName" style="width:17%;" name="refereeFirstName" id="" autocomplete="off" placeholder="{{ trans('reference.firstName') }}" value="John" required>
                  <p id="alert_partner_lname" style="display:none; margin:0rem; color:red;">{{ trans('signup.alert_candidate_element_two') }}</p>
                  <input type="" class="input referenceIdentityLName" style="width:17%;" name="refereeLastName" id="" autocomplete="off" placeholder="{{ trans('reference.lastName') }}" value="Lebrun" required>
                  <input type="" class="input referenceIdentityPosition" style="width:25%;" name="refereePosition" id="" autocomplete="off" placeholder="{{ trans('reference.position') }}" value="Accounting manager" required>
                  <input type="" class="input referenceIdentityCompany" style="width:35%;" name="refereeCompany" id="" autocomplete="off" placeholder="{{ trans('reference.companyWhere') }} Antoine" value="Simon SA" required>
                </div>

                <h3>{{ trans('reference.experienceWith') }}  Antoine</h3>
                <h5 style="font-size:1rem;">{{ trans('reference.howLong') }} Antoine?</h5>
                <div class="col-md-3 buttonReferenceDetail buttonReferenceDetail1"><input type="radio" name="experienceLength" value="starter" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="experienceLength" value="junior" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="experienceLength" value="confirmed" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="experienceLength" value="senior" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</p></label></div>

                <h5 class="titleReferenceQuality">{{ trans('reference.responsibilities') }} Antoine{{ trans('reference.responsibilities2') }}?</h5>
                <textarea name="responsibilities" class="borderradius referenceTextarea" rows="5" cols="80" placeholder="{{ trans('reference.mentionResponsibilities') }}" required></textarea>

                <h5 style="font-size:1rem;">{{ trans('reference.integration') }} Antoine{{ trans('reference.integration2') }}?</h5>
                <div class="col-md-3 buttonReferenceDetail buttonReferenceDetail1"><input type="radio" name="integration" value="sufficient" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.sufficient') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="integration" value="good" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.good') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="integration" value="very good" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.veryGood') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="integration" value="excellent" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.excellent') }}</p></label></div>

                <h5 class="titleReferenceQuality">How would you qualify Antoine's overall quality of work when working with you?</h5>
                <div class="col-md-3 buttonReferenceDetail buttonReferenceDetail1"><input type="radio" name="workQuality" value="sufficient" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.sufficient') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="workQuality" value="good" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.good') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="workQuality" value="very good" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.veryGood') }}</p></label></div>
                <div class="col-md-3 buttonReferenceDetail"><input type="radio" name="workQuality" value="excellent" class="buttonReference buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="buttonReferenceLabel label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.excellent') }}</p></label></div>



                <h5 style='margin-top:7rem;font-size:1rem;'>{{ trans('reference.comments') }} Antoine.</h5>
                <textarea name="comments" rows="5" cols="80" class="borderradius referenceTextarea" placeholder="{{ trans('reference.giveGeneralComments') }} Antoine {{ trans('reference.here') }}" required></textarea>
                <h5 class="titleReferenceQuality" style="margin-top:2rem;">{{ trans('reference.today') }}Antoine Dumoulins {{ trans('reference.today2') }}? </h5>
                <div class="row" id="rowDecideToHireAgain" style="margin-top:0rem;">
                  <div class="col-md-3 buttonDecideToHireAgain" style="margin-top:1.5rem;"><input type="radio" name="hireAgain" value="no" class="inputDecideToHireAgain buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="labelDecideToHireAgain label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.no') }}</p></label></div>
                  <div class="col-md-3 buttonDecideToHireAgain" style="margin-top:1.5rem;"><input type="radio" name="hireAgain" value="yes" class="inputDecideToHireAgain buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="labelDecideToHireAgain label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('reference.yes') }}</p></label></div>
                </div>

      					<button type="" style="margin-top:5rem;display: block;width: 100%;background: none;border: none;background-color: #27AE60;color: white;padding: 0.7rem;border-radius: 0.5rem;" class="button centeralign" id="button_partner">{{ trans('reference.submit') }}</button>

      			</div><!--.candidate-tab-content-->
      		</div><!--.tabs-content-->
      	</div><!--.form-wrap-->
        <p class="linktoregistration" style="font-size:1rem;">{{ trans('reference.beenRecruiting') }} <a href="/companies/welcome" target="_blank">{{ trans('reference.here') }}</a></p>
    </main>
    <footer id="footer" class="column">
      <div class="col-md-12">
        <div class="col-md-3 column alignleft">
          <h3>{{ trans('welcomecandidate.headercandidatetitle') }}</h3>
          <a href="/candidates/welcome" class="underlineHover">{{ trans('welcomecandidate.headercandidatehiw') }}</a>
          <a href="/candidates/faq" class="underlineHover">{{ trans('welcomecandidate.headercandidatefaq') }}</a>
          <a href="/signup" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
        </div>
        <div class="col-md-3 column alignleft">
          <h3>{{ trans('welcomecandidate.headercompanytitle') }}</h3>
          <a href="/companies/welcome" class="underlineHover">{{ trans('welcomecandidate.headercompanyhiw') }}</a>
          <a href="/companies/faq" class="underlineHover">{{ trans('welcomecandidate.headercompanyfaq') }}</a>
          <a href="/signup?company_email=" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
        </div>
        <div class="col-md-3 column alignleft">
          <h3>{{ trans('welcomecandidate.headerpartnertitle') }}</h3>
          <a href="/partners/welcome" class="underlineHover">{{ trans('welcomecandidate.headerpartnerhiw') }}</a>
          <a href="/partners/faq" class="underlineHover">{{ trans('welcomecandidate.headerpartnerfaq') }}</a>
          <a href="/signup_partner" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
        </div>
        <div class="col-md-3 column alignleft">
          <span  style="font-size:2rem;margin-top:1.2rem;margin-bottom:0.2rem;padding-left:0.3rem">
            <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
            <script type="IN/FollowCompany" data-id="11010661"></script>
          </span>
          <a href="mailto:info@tietalent.com?Subject=TieTalent" target="_top" class="underlineHover">Contact</a>
          <a href="/termsofservice" class="underlineHover">{{ trans('welcomecandidate.terms') }}</a>
          <a href="/sitemap" class="underlineHover">Sitemap</a>
        </div>
      </div>
      <p class="alignleft" style="display:block;padding-left:34.8px;margin-top:2rem;"><i class="fa fa-copyright" aria-hidden="true"></i> {{ trans('welcomecandidate.allRightReserved') }}</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('public/js/signup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/newClients.js') }}" type="text/javascript"></script>
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
