


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('welcome.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcome.pageDescription') }}" />
      <meta name="recruitment" content="---"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="{{ asset('public/css/main.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
      <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}" type="text/css" />
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
      <meta name="google-site-verification" content="WmbXtAgu1pvuoGXcVUOqWEzhed1lnKSW38UatsVCiAY" />
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
        <a href="/"><img class="logo" id="logoTieTalentSmallMenu" width="150px" src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="Tie Talent logo" title="Tie Talent logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/" id="logoTieTalent"><img class="logo" width="150px" src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;" alt="Tie Talent logo" title="Tie Talent logo"/></a>
        <ul class="nav">
          <li>
            <span class="navButton">{{ trans('welcomecandidate.headercandidatetitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="/candidates/welcome">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
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

          <li style="width:15%;margin:0 auto;"><a href="/home" style="width:100%;">Login</a></li>
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
    <main id="welcome">
      <h1 class="alignleft welcomeTitle">{{ trans('welcome.title1') }} <span class="orange">{{ trans('welcome.title2') }}</span></h1>
      <h2 class="title alignleft titleh2" style="width:50%;margin-top:3rem;">
        <i class="fa fa-quote-left orange" aria-hidden="true" style="font-size:3rem;float:left;margin:-0.7rem 1rem 0rem 0rem;padding-bottom:7rem;"></i>
        <span style="color:rgb(41,88,108);font-family:'roboto';font-size:2rem"><i> {{ trans('welcome.subtitle') }}</i></span>
      </h2>
      <div class="identity" style="margin-top:3rem;">
        <a href="/candidates/welcome"><button type="submit" class="btn welcome-btn-default" style="font-size:1.3rem;"><b>{{ trans('welcome.candidate_button') }}</b></button></a>
        <a href="/companies/welcome"><button type="submit" class="btn welcome-btn-default company" style="font-size:1.3rem;"><b>{{ trans('welcome.company_button') }}</b></button></a>
        <a href="/home"><button type="submit" class="btn welcome-btn-default company loginMobileButton" style="font-size:1.3rem;color:#333333;background-color:transparent;border:3px solid #F14904;display:none;"><b>Login</b></button></a>
      </div>
    </main>
    <footer id="footer" class="column">
      <div class="col-md-12">
        <div class="col-md-3 column alignleft">
          <h3 style="padding-left:0.3rem">{{ trans('welcomecandidate.headercandidatetitle') }}</h3>
          <a href="/candidates/welcome" class="underlineHover">{{ trans('welcomecandidate.headercandidatehiw') }}</a>
          <a href="/candidates/faq" class="underlineHover">{{ trans('welcomecandidate.headercandidatefaq') }}</a>
          <a href="/signup" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
        </div>
        <div class="col-md-3 column alignleft">
          <h3 style="padding-left:0.3rem">{{ trans('welcomecandidate.headercompanytitle') }}</h3>
          <a href="/companies/welcome" class="underlineHover">{{ trans('welcomecandidate.headercompanyhiw') }}</a>
          <a href="/companies/faq" class="underlineHover">{{ trans('welcomecandidate.headercompanyfaq') }}</a>
          <a href="/signup?company_email=" class="underlineHover">{{ trans('welcomecandidate.signUp') }}</a>
        </div>
        <div class="col-md-3 column alignleft">
          <h3 style="padding-left:0.3rem">{{ trans('welcomecandidate.headerpartnertitle') }}</h3>
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
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.min.js') }}"></script>
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
