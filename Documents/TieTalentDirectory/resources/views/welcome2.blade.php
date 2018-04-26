


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('welcome.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcome.pageDescription') }}" />
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
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.10";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
                <li><a href="/" class="centeralign paddingSmall">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
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

  <main>
    <div class="row" style="margin:0rem;">

      <div id="imageWelcomePageCompany" style="width:50%">
        <!--<img src="{{ asset('public/img/happyCandidate.png') }}" alt="Picture">-->
      </div>
      <div id="leftWelcomePageCompany">
        <h1 id="mainTitle">Hire the best talents for your company</h1>
        <p style="font-size:1.5rem;padding:1rem;">Cut down you hiring time and get linked to top professionals recommended by our independent field experts.</p>
        <div class="identity buttonTitle">
          <a href="/signup?company_email="><button type="submit" class="btn welcome-btn-default" style="font-size:1.5rem;background-color: #F14904;border: none;padding: 0.5rem 3rem;border-radius: 0.5rem;"><b>{{ trans('welcome.createProfile') }}</b></button></a>
        </div>
        <div id="linkCompany">
          <a href="/" class="underlineHover">Looking for a job? Click here</a>
        </div>
      </div>
    </div>

    <div style="padding-top:6rem;padding-bottom:5rem;background-color:#F1F1F1">
      <h2 id="titleOperationalDivisions">Hire your future employees in hours!</h2>
      <h2 id="subtitleOperationalDivisions">Don't lose time reviewing hundreds of applicants. On TieTalent you receive a shortlist of top pre-selected candidates and save more than 50% of the agencies fees.</h2>

      <div class="row divisionRow">
        <a href="/signup">
          <div class="divisionBox">
            {{ trans('welcome.financeAccounting') }}
          </div>
        </a>
        <a href="/signup">
          <div class="divisionBox">
            {{ trans('welcome.salesMarketing') }}
          </div>
        </a>
        <a href="/signup">
          <div class="divisionBox">
            {{ trans('welcome.humanResources') }}
          </div>
        </a>
      </div>
      <div class="" style="padding:3rem 1rem 1rem 0rem;margin:0 auto;width:80%;color:black;">
        <p style="margin-top:0rem;font-size:1.2rem">Looking for an employee in another field?
          <br/>
          <br/><a href="/signup?company_email=" class="underlineHover">{{ trans('welcome.otherField2') }}</a></p>
      </div>
    </div>


    <div id="welcome2" style="color:black;">
      <h2 class="subTitle">{{ trans('welcome.howItWorks') }}</h2>






	<section id="cd-timeline" class="cd-container">
		<div class="cd-timeline-block">

			<div class="cd-timeline-img cd-picture">
				<img src="{{ asset('public/img/number_1.svg') }}" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content stepsAlignLeft">
        <div>
  				<h2>{{ trans('welcome.createProfile') }}</h2>
  				<p>{{ trans('welcome.createProfile2') }}</p>
        </div>
				<span class="cd-date"><img src="{{ asset('public/img/bulb.svg') }}" alt="Picture" style="width:150px;"></span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->

		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-movie">
				<img src="{{ asset('public/img/number_2.svg') }}" alt="Movie">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content stepsAlignRight">
        <div>
  				<h2>{{ trans('welcome.yourStory') }}</h2>
  				<p>{{ trans('welcome.yourStory2') }}</p>
        </div>
        <span class="cd-date"><img src="{{ asset('public/img/story.svg') }}" alt="Picture" style="width:150px;"></span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->

		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-picture">
				<img src="{{ asset('public/img/number_3.svg') }}" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content stepsAlignLeft">
				<div>
          <h2>{{ trans('welcome.meet') }}</h2>
  				<p>{{ trans('welcome.meet2') }}</p>
        </div>
        <span class="cd-date"><img src="{{ asset('public/img/meet.svg') }}" alt="Picture" style="width:200px;"></span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->

		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-location">
				<img src="{{ asset('public/img/number_4.svg') }}" alt="Location">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content stepsAlignRight">
        <div>
  				<h2>{{ trans('welcome.hired') }}</h2>
  				<p>{{ trans('welcome.hired2') }}</p>
        </div>
				<span class="cd-date"><img src="{{ asset('public/img/handshake.svg') }}" alt="Picture"  style="width:150px;"></span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->


	</section> <!-- cd-timeline -->



      <div class="row" style="margin:0rem;background-color:#F1F1F1;padding:0rem 2rem 4rem 2rem;">
        <!--
        <div id="imageDownWelcomePage" style="width:40%">
        </div>
      -->
        <div id="leftDownWelcomePage">
          <h2 id="makeYourLifeSimple">{{ trans('welcome.makeLifeSimple') }}</h2>
          <div class="alignleft listAdvantagesLifeSimple">
            <p style="font-size:1.5rem;"><i class="fa fa-check validateGreenColor" aria-hidden="true"></i> {{ trans('welcome.makeLifeSimple1') }}</p>
            <p style="font-size:1.5rem;"><i class="fa fa-check validateGreenColor" aria-hidden="true"></i> {{ trans('welcome.makeLifeSimple2') }}</p>
            <p style="font-size:1.5rem;"><i class="fa fa-check validateGreenColor" aria-hidden="true"></i> {{ trans('welcome.makeLifeSimple3') }}</p>
            <p style="font-size:1.5rem;"><i class="fa fa-check validateGreenColor" aria-hidden="true"></i> {{ trans('welcome.makeLifeSimple4') }}</p>
          </div>
          <div class="identity" style="margin-top:4rem;">
            <a href="/signup"><button type="submit" class="btn welcome-btn-default" style="font-size:1.5rem;background-color: #2e3e4a;color:white;border: none;padding: 0.5rem 3rem;border-radius: 0.5rem;"><b>{{ trans('welcome.register') }}</b></button></a>
          </div>
        </div>
      </div>

      <div class="row rowOtherDetails">

        <div class="otherDetails">
          <img src="{{ asset('public/img/dollar.svg') }}" alt="Money" style="height:200px;">
          <h2 style="font-size:2.5rem">Pricing</h2>
          <p style="font-size:1rem;">Thanks to our innovative approach and the technology we are able to offer our clients the best possible hiring experience at the most competitive market price.</p>
          <a href="/companies/pricing"><button type="submit" class="btn welcome-btn-default" style="margin-top:2rem;font-size:1.5rem;background-color: #2e3e4a;color:white;border: none;padding: 0.5rem 3rem;border-radius: 0.5rem;"><b>See pricing</b></button></a>
        </div>

        <div class="otherDetails">
          <img src="{{ asset('public/img/question.svg') }}" alt="Money" style="height:200px;">
          <h2 style="font-size:2.5rem">Other questions?</h2>
          <p style="font-size:1rem;">Learn more how TieTalent works for candidates, companies & experts.</p>
          <a href="/companies/faq"><button type="submit" class="btn welcome-btn-default" style="margin-top:2rem;font-size:1.5rem;background-color: #2e3e4a;color:white;border: none;padding: 0.5rem 3rem;border-radius: 0.5rem;"><b>Read the FAQ</b></button></a>
        </div>
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
          <span  style="font-size:2rem;margin-top:1.2rem;margin-bottom:0.2rem;">
            <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
            <script type="IN/FollowCompany" data-id="11010661"></script>
          </span>
          <div class="fb-like" data-href="https://www.facebook.com/tietalent/?ref=bookmarks" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
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
