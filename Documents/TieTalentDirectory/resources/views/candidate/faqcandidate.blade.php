


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('faqcandidate.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcomecandidate.pageDescription') }}" />
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
      <a class="navbar-brand" href="/"><img width="150px" src="{{ asset('public/img/logott.png') }}" alt="TieTalent logo" title="TieTalent logo"/></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle orange" data-toggle="dropdown">{{ trans('welcomecandidate.headercandidatetitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
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
        <li class="smallButton"><a href="/home">Login</a></li>
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

    <!--
    <div class="wrapper">
      <nav class="topbar">
        <a href="/"><img class="logo" id="logoTieTalentSmallMenu" width="150px" src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="TieTalent logo" title="TieTalent logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/" id="logoTieTalent"><img class="logo" width="150px" src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;padd" alt="TieTalent logo" title="TieTalent logo"/></a>
        <ul class="nav">
          <li>
            <span class="navButton"><span class="orange">{{ trans('welcomecandidate.headercandidatetitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
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

  -->
    <main id="faq">
      <h1 class="faq-title" style="color:white;font-size:2rem;">{{ trans('faqcandidate.title') }}</h1>
      <div class="faq-container">
        <h2 class="faq-headline">{{ trans('faqcandidate.subtitle_one') }}</h2>
        <ul class="faq-list">
          <li class="faq-element faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_one_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_one_details_a') }}{{ trans('faqcandidate.element_one_details_b') }}{{ trans('faqcandidate.element_one_details_c') }}</p>
              <p>{{ trans('faqcandidate.element_one_details_d') }}</p>
          </div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_two_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_two_details') }}</p>
            </div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_three_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_three_details_a') }}<b>{{ trans('faqcandidate.element_three_details_b') }}</b>{{ trans('faqcandidate.element_three_details_c') }}</p></div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_four_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_four_details_a') }}<b>{{ trans('faqcandidate.element_four_details_b') }}</b>{{ trans('faqcandidate.element_four_details_c') }}<b>{{ trans('faqcandidate.element_four_details_d') }}</b>{{ trans('faqcandidate.element_four_details_e') }}</p>
            </div>
          </li>
        </ul>
        <h2 class="faq-headline">{{ trans('faqcandidate.subtitle_two') }}</h2>
        <ul class="faq-list">
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_five_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_five_details_a') }}<b>{{ trans('faqcandidate.element_five_details_b') }}</b>{{ trans('faqcandidate.element_five_details_c') }}<b>{{ trans('faqcandidate.element_five_details_d') }}</b>{{ trans('faqcandidate.element_five_details_e') }}<b>{{ trans('faqcandidate.element_five_details_f') }}</b>{{ trans('faqcandidate.element_five_details_g') }}<b>{{ trans('faqcandidate.element_five_details_h') }}</b>.</p>
              <p>{{ trans('faqcandidate.element_five_details_i') }}</div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_six_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_six_details_a') }}<b>{{ trans('faqcandidate.element_six_details_b') }}</b>.
                <br/>{{ trans('faqcandidate.element_six_details_c') }}</p>
              <p>{{ trans('faqcandidate.element_six_details_d') }}</p>
                <p>{{ trans('faqcandidate.element_six_details_e') }}</p>
            </div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_seven_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_seven_details') }}</p></div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_eight_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_eight_details_a') }}</p>
              <p>{{ trans('faqcandidate.element_eight_details_b') }}</p>
              <p>{{ trans('faqcandidate.element_eight_details_c') }}</p></div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_nine_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_nine_details_a') }}</p>
              <p>{{ trans('faqcandidate.element_nine_details_b') }}</p>
              <p>{{ trans('faqcandidate.element_nine_details_c') }}</p></div>
          </li>
          <li class="faq-element">
            <span class="faq-element__title">{{ trans('faqcandidate.element_ten_title') }}</span>
            <div class="faq-element__answer">
              <p>{{ trans('faqcandidate.element_ten_details') }}</p></div>
          </li>
        </ul>
      </div>
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
    <script src="{{ asset('public/js/newClients.js') }}" type="text/javascript"></script>
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
