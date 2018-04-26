


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('welcomecandidate.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcomecandidate.pageDescription') }}" />
      <meta name="recruitment" content="---"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="{{ asset('public/css/main.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" type="text/css" />
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
    <div class="wrapper">
      <nav class="topbar">
        <a href="/"><img class="logo" id="logoTieTalentSmallMenu" width="150px" src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="TieTalent logo" title="TieTalent logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/" id="logoTieTalent"><img class="logo" width="150px" src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;padd" alt="TieTalent logo" title="TieTalent logo"/></a>
        <ul class="nav">
          <li>
            <span class="navButton"><span class="orange">{{ trans('welcomecandidate.headercandidatetitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="#steps">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
              <li><a href="/candidates/faq">{{ trans('welcomecandidate.headercandidatefaq') }}</a></li>
            </ul>
          </li>
          <li>
            <span class="navButton">{{ trans('welcomecandidate.headercompanytitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="/companies/welcome">{{ trans('welcomecandidate.headercompanyhiw') }}</a></li>
              <li><a href="/companies/pricing">{{ trans('welcomecandidate.headercompanypricing') }}</a></li>
              <li><a href="/companies/faq">{{ trans('welcomecandidate.headercompanyfaq') }}</a></li>
            </ul>
          </li>
          <li>
            <span class="navButton">{{ trans('welcomecandidate.headerpartnertitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="/partners/welcome">{{ trans('welcomecandidate.headerpartnerhiw') }}</a></li>
              <li><a href="/partners/faq">{{ trans('welcomecandidate.headerpartnerfaq') }}</a></li>
            </ul>
          </li>
          <li style="width:15%;"><a href="/home">Login</a></li>
          <li style="width:20%;margin:0 auto;"><a href="/signup" style="width:100%;color:#F14904">{{ trans('welcomecandidate.signUp2') }}</a></li>
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

    <main id="welcomecompany-main">
      <article class="structure presentationcandidate">
        <div class="companytoppart" style="padding:2.5rem 0rem 0rem 0rem">
          <div class="leftpart">
            <h1 class="HowItWorksH1">{{ trans('welcomecandidate.title1') }} <span class="orange">{{ trans('welcomecandidate.title2') }}</span></h1>
            <h2 class="title titleh2" style="width:50%;background-color:rgba(255, 255, 255, 0.6);padding:1.5rem 0rem 1.5rem 1rem;margin-left:50%;">
              <i class="fa fa-quote-left orange" aria-hidden="true" style="font-size:3rem;float:left;margin:-0.7rem 0.5rem 3rem 0rem;"></i>
              <span style="color:#333333;font-family:'roboto';font-size:2rem"><i> {{ trans('welcomecandidate.subtitle') }}</i></span>
            </h2>
          </div>
            <form class="wp-form-group" role="form" action="/signup" method="GET" style="margin-bottom:2rem;">
              <p id="alert_candidate" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('welcomecandidate.invalidEmail') }}</p>
              <input type="email" class="wp-company-form-control" style="font-size:1.3rem;" name="candidate_email" id="candidateEmail" placeholder="{{ trans('welcomecandidate.placeholderEmail') }}">
              <button style="font-size:1.3rem;" id="button_candidate_mail" class="wp-btn-default centeralign">{{ trans('welcomecandidate.candidate_button') }}</button>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

        </div>
        <a href="#candidateSteps"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
      </article>
      <div id="candidateSteps" class="structure">
        <article class="title animated fadeIn">
          <h2 class="orange" style="font-size:3rem; font-weight:500;margin-bottom: 0;margin-top: 4rem;">{{ trans('welcomecandidate.hiw_title') }}</h2>
        </article>

        <!--
        <div class="row">
          <div class="row animated fadeIn col-md-4" style="margin-left:0.5rem;margin-right:0.5rem;justify-content:center">
            <i class="fa fa-commenting-o" aria-hidden="true" style="font-size:2rem;color:#333333;padding-right:0.5rem;"></i>
            <p style="font-size:1rem;text-align:left;margin-left:1rem;margin-right:1rem;">{{ trans('welcomecandidate.interview') }}</p>
          </div>
          <div class="row animated fadeIn col-md-4" style="margin-left:0.5rem;margin-right:0.5rem;justify-content:center">
            <i class="fa fa-magnet" aria-hidden="true" style="font-size:2rem;color:#333333;padding-right:0.5rem;"></i>
            <p style="font-size:1rem;text-align:left;margin-left:1rem;margin-right:1rem;">{{ trans('welcomecandidate.magnet') }}</p>
          </div>
          <div class="row animated fadeIn col-md-4" style="margin-left:0.5rem;margin-right:0.5rem;justify-content:center">
            <i class="fa fa-briefcase" aria-hidden="true" style="font-size:2rem;color:#333333;padding-right:0.5rem;"></i>
            <p style="font-size:1rem;text-align:left;margin-left:1rem;margin-right:1rem;">{{ trans('welcomecandidate.newAdventure') }}</p>
          </div>
        </div>

      -->



        <div class="row whiteBackground evenNumb HIWFullStep">
          <div class="width50 HIWPictureTab">
            <img class="width100 HIWPicture" src="{{ trans('welcomecandidate.step1picture') }}" alt="">
          </div>
          <div class="width40 HITDescriptionStep">
            <div class="row" style="margin:0">
              <span class="HIWStepNumber" style="font-size: 20rem;color:#D1D1D1">1</span>
              <div class="column alignleft HIWStepDescription">
                <h2 style="font-size:4rem;margin-top:0;" class="marginbottom-xsmall underlineOrange stepTitle darkGreyColor">{{ trans('welcomecandidate.step1title') }}</h2>
                <h2>
                  <small class="orange" style="margin-top:0;font-size:1.6rem;">{{ trans('welcomecandidate.step1subtitle') }}</small>
                </h2>
                <p style="font-size:1rem;" class="darkGreyColor">{{ trans('welcomecandidate.step1details') }}</p>
              </div>
            </div>
          </div>
        </div>


        <div class="row oddNumb HIWFullStep" style="background-color:#D1D1D1">
          <div class="width40 HITDescriptionStep">
              <div class="row" style="margin:0">
                <span class="HIWStepNumber" style="font-size: 20rem;color:white">2</span>
                <div class="column alignleft HIWStepDescription">
                  <h2 style="font-size:4rem;margin-top:0;" class="marginbottom-xsmall underlineOrange stepTitle darkGreyColor">{{ trans('welcomecandidate.step2title') }}</h2>
                  <h2>
                    <small class="orange" style="margin-top:0;font-size:1.6rem;">{{ trans('welcomecandidate.step2subtitle') }}</small>
                  </h2>
                  <p style="font-size:1rem;" class="darkGreyColor">{{ trans('welcomecandidate.step2details') }}</p>
                </div>
              </div>
            </div>
            <div class="width50 HIWPictureTab">
              <img class="width100 HIWPicture" src="{{ trans('welcomecandidate.step2picture') }}" alt="">
            </div>
        </div>
        <div class="row whiteBackground evenNumb HIWFullStep">
          <div class="width50 HIWPictureTab">
            <img class="width100 HIWPicture" src="{{ trans('welcomecandidate.step3picture') }}" alt="">
          </div>
          <div class="width40 HITDescriptionStep">
            <div class="row" style="margin:0">
              <span class="HIWStepNumber" style="font-size: 20rem;color:#D1D1D1">3</span>
              <div class="column alignleft HIWStepDescription" style="padding-left:2rem;">
                <h2 class="marginbottom-xsmall underlineOrange stepTitle darkGreyColor">{{ trans('welcomecandidate.step3title') }}</h2>
                <h2>
                  <small class="orange" style="margin-top:0;font-size:1.6rem;">{{ trans('welcomecandidate.step3subtitle') }}</small>
                </h2>
                <p style="font-size:1rem;" class="darkGreyColor">{{ trans('welcomecandidate.step3details') }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row HIWFullStep" style="background-color:#D1D1D1">
          <div class="width40 HITDescriptionStep">
              <div class="row" style="margin:0">
                <span class="HIWStepNumber" style="font-size: 20rem;color:white">4</span>
                <div class="column alignleft HIWStepDescription" style="padding-left:2rem;">
                  <h2 style="font-size:4rem;margin-top:0;" class="marginbottom-xsmall underlineOrange stepTitle darkGreyColor">{{ trans('welcomecandidate.step4title') }}</h2>
                  <h2>
                    <small class="orange" style="margin-top:0;font-size:1.6rem;">{{ trans('welcomecandidate.step4subtitle') }}</small>
                  </h2>
                  <p style="font-size:1rem;" class="darkGreyColor">{{ trans('welcomecandidate.step4details') }}</p>
                </div>
              </div>
            </div>
            <div class="width50 HIWPictureTab">
              <img class="width100 HIWPicture" src="{{ trans('welcomecandidate.step4picture') }}" alt="">
            </div>
        </div>
      </div>

      <div id="benefits">
        <h2 style="font-size:3rem; font-weight:500; margin-bottom:5rem;">{{ trans('welcomecandidate.benefits_title') }}<i class="fa fa-heart" aria-hidden="true"></i> TieTalent?</h2>
        <div class="row rowbenefits" style="margin: 0;">
          <div class="colonne">
            <img class="reason" src="{{ asset('public/img/looknomore.svg') }}" alt="reason 1 why candidates love Tie Talent" title="reason1" width="120px"/>
            <h4 style="font-size:1.7rem;font-weight:500;margin-top:4rem">{{ trans('welcomecandidate.one_title') }}</h4>
          </div>
          <div class="colonne">
            <img class="reason" src="{{ asset('public/img/feedback.png') }}" alt="reason 2 why candidates love Tie Talent" title="reason 2 why candidates love TieTalent" width="120px"/>
            <h4 style="font-size:1.7rem;font-weight:500;margin-top:4rem">{{ trans('welcomecandidate.two_title') }}</h4>
          </div>
          <div class="colonne">
            <img class="reason" src="{{ asset('public/img/spotlight1.svg') }}" alt="reason 3 why candidates love Tie Talent" title="reason 3 why candidates love TieTalent" width="130px"/>
            <h4 class="adjust" style="font-size:1.7rem;font-weight:500;margin-top:4rem">{{ trans('welcomecandidate.three_title') }}</h4>
          </div>
          <div class="colonne">
            <img class="reason" src="{{ asset('public/img/confidentiality.svg') }}" alt="reason 4 why candidates love Tie Talent" title="reason 4 why candidates love TieTalent" width="120px"/>
            <h4 style="font-size:1.7rem;font-weight:500;margin-top:4rem">{{ trans('welcomecandidate.four_title') }}</h4>
          </div>
        </div>
        <a href="#gettietalent"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
      </div>
      <div id="gettietalent">
        <img class="logopuzzle" src="{{ asset('public/img/logopuzzle.png') }}" alt="TieTalent logo" title="Tie Talent logo" width="100rem"/>
        <p>{{ trans('welcomecandidate.register') }}</p>
        <a href="/signup"><button type="submit" class="btn welcome-company-btn-default">{{ trans('welcomecandidate.candidate_button') }}</button></a>
      </div>
      <!-- Return to top -->
      <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
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
          <a href="/signup" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
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
          <a href="/privacypolicy" class="underlineHover">{{ trans('welcomecandidate.policy') }}</a>
          <a href="/sitemap" class="underlineHover">Sitemap</a>
        </div>
      </div>
      <p class="alignleft" style="display:block;padding-left:34.8px;margin-top:2rem;"><i class="fa fa-copyright" aria-hidden="true"></i> {{ trans('welcomecandidate.allRightReserved') }}</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.geocomplete.min.js') }}"></script>
    <script src="{{ asset('public/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('public/js/clients.js') }}" type="text/javascript"></script>
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
