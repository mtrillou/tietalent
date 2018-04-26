
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>TieTalent - About</title>
      <meta name="description" content="{{ trans('pricingcompany.pageDescription') }}" />
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
            <li class="smallButton"><a href="/about" class="orange">About</a></li>
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

    <!--
    <div class="wrapper">
      <nav class="topbar">
        <a href="/"><img class="logo" id="logoTieTalentSmallMenu" width="150px" src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="TieTalent logo" title="TieTalent logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/" id="logoTieTalent"><img class="logo" width="150px" src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;padd" alt="TieTalent logo" title="TieTalent logo"/></a>
        <ul class="nav">
          <li>
            <span class="navButton">{{ trans('welcomecandidate.headercandidatetitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="/candidates/welcome">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
              <li><a href="/candidates/faq">{{ trans('welcomecandidate.headercandidatefaq') }}</a></li>
            </ul>
          </li>
          <li>
            <span class="navButton"><span class="orange">{{ trans('welcomecandidate.headercompanytitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
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
          <li style="width:20%;margin:0 auto;"><a href="/signup?company_email=" style="width:100%;color:#F14904">{{ trans('welcomecandidate.signUp2') }}</a></li>
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


    <main id="welcomecompany-main" class="lightGreyBackground" style="padding-bottom:5rem">
        <div style="background-color:#F14904;color:white;font-size: 5rem;letter-spacing: 5px;height:12rem;height:12rem;">
          <h1 class="centeralign" style="font-size: 5rem;letter-spacing: 5px;padding-top:2rem;font-weight: 500;">About Us</h1>
          <p style="letter-spacing:1px;font-size:1.5rem;margin-top:0;">Simple - Quick - Relevant</p>
        </div>

        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:2rem">
          <h2 class="orange" style="padding-top:2.5rem;margin-top: 0rem;font-weight: 500;font-size: 2.5rem;">- Our Mission -</h2>
          <p class="darkGreyColor" style="font-size:1.8rem;font-weight:900">To make recruitment easy.</p>
        </div>

        <!--
        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:2rem">
          <h2 class="orange" style="padding:2rem;margin-top: 1rem;font-weight: 500;font-size: 2.5rem;">- Our Vision -</h2>
          <p style="font-size:1.2rem;">We are on our way to create</p>
        </div>
      -->

        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:4rem">
          <h2 class="orange" style="padding-top:2rem;margin-top: 1rem;font-weight: 500;font-size: 2.5rem;">- Our Story -</h2>
          <div class="alignleft" style="width:70%;margin:0 auto;">
            <p style="font-size:1.2rem;">While working in a recruitment corporation, Marc Trillou realised that he was recruiting people for jobs he had absolutely no knowledge about, but he was good in sales and could convince his clients to call him for their needs. And even though it might seem playful on the first hand, this situation is pretty foolish.
              <br/>Starting a new job is changing one’s life. Hiring the wrong employee can bring a company to bankruptcy.
              <br/>So why do we trust any person with good sales skills to hire our future employees?
            </p>
            <p style="font-size:1.2rem;">The founders Marc Trillou and Jovana Rotula saw a missing opportunity and came up with a simple idea: getting a developer to prequalify developers.</p>
            <p style="font-size:1.2rem;">For the community of experts who make interviews with TieTalent candidates, our platform represents a new way for you to share your knowledge, meet new people and earn money in a flexible manner.
              <br/>For people looking for a new job, we make it easy for you to get hired, and improve your chances to get your dream job by connecting you with true professionals from your field.
              <br/>For the companies looking for a new employee, we make it simple for you to recruit, by instantly giving you access to the best talents matching your need.
            </p>
            <p style="font-size:1.2rem;">When you make recruitment as easy and reliable as a swiss pocket knife, everyone benefits.</p>
          </div>

        </div>

        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:4rem">
          <h2 class="orange" style="padding:2rem;margin-top: 1rem;font-weight: 500;font-size: 2.5rem;">- Our Founders -</h2>
          <div class="row" style="margin:0;">
            <div style="width:35%">
              <img src="{{ asset('public/img/IMG_3845.png') }}" alt="" style="width:50%;border-radius:100%;">
            </div>
            <div class="column alignleft" style="width:50%;padding-right:5rem;">
              <p style="font-size:1.8rem;margin:0" class="orange">Jovana Rotula</p>
              <p style="font-size:1.3rem;margin: 0.5rem 0rem;">COO & Co-Founder</p>
              <p style="margin:0rem;font-size:1rem">Jovana is the co-founder and Chief Operating Officer at TieTalent. Jovana is involved in developing the company culture, the TieTalent community, and innovating future growth opportunities.</p>
              <p style="font-size:1rem">She earned a Bachelor in Science in Hospitality Management from the Ecole hôtelière de Lausanne and worked for Starbucks regional marketing in Middle-East before co-founding TieTalent.</p>
            </div>
          </div>
          <div class="row" style="margin:3rem 0rem 0rem 0rem;">
            <div style="width:35%">
              <img src="{{ asset('public/img/IMG_3830.png') }}" alt="" style="width:50%;border-radius:100%;">
            </div>
            <div class="column alignleft" style="width:50%;padding-right:5rem;">
              <p style="font-size:1.8rem;margin:0" class="orange">Marc Trillou</p>
              <p style="font-size:1.3rem;margin: 0.5rem 0rem;">CEO & Co-Founder</p>
              <p style="margin:0rem;font-size:1rem">Marc is the co-founder and Chief Executive Officer at TieTalent. He drives the company’s vision, overall strategy and growth activities.</p>
              <p style="font-size:1rem">Marc met co-founder Jovana Rotula at the Ecole hôtelière de Lausanne where he received a Bachelor in Science in Hospitality Manegement.
                <br/>Before co-founding TieTalent, Marc worked in both a recruitment startup and a recruitment corporation, which led him to see the missing opportunities in the staffing industry.
              </p>
            </div>
          </div>
        </div>
        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:2rem">
          <h2 class="orange" style="padding:2rem;margin-top: 1rem;font-weight: 500;font-size: 2.5rem;">- Accelerator -</h2>
            <a href="http://masschallenge.org/" target="_blank"><img src="{{ asset('public/img/MCLogo.png') }}" alt="" style="width:20%;margin-bottom: 4rem;"></a>
        </div>
        <div class="width-big pricingDiv" style="background-color:white;margin:0 auto;color:#333333;padding-bottom:4rem">
          <h2 class="orange" style="padding:2rem;margin-top: 1rem;font-weight: 500;font-size: 2.5rem;">- Location -</h2>
          <div class="row" style="margin:0;">
            <div class="column alignleft darkGreyColor" style="width:50%;margin:0rem 0rem 4rem 4rem;">
              <p class="orange" style="font-size:1.3rem;"><i class="fa fa-map-marker" aria-hidden="true"></i> Geneva (Headquarters)</p>
              <p style="font-size:1rem;"><b>TieTalent Sàrl</b> is headquartered in <b>Geneva, Switzerland</b></p>
              <p style="font-size:1rem;line-height: 1.5rem;">Place de Grenus 4
                <br/>1201 Geneva
                <br/>Switzerland
              </p>
            </div>
            <div id="map" style="margin:0rem 4rem;"></div>
          </div>

        </div>








      <!-- Return to top -->
      <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
    </main>
    <footer id="footer" class="column" style="background-color:white;">
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
    <script src="{{ asset('public/js/signup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/newClients.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.sticky.js') }}"></script>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90353807-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
  $(window).load(function(){
    $("#demoHeader").sticky({ topSpacing: 0 });
  });
</script>
<script>
$('.button').click(function(){
		  $('#modal').css('display','block');
		  $('.modal-bg').fadeIn();
	});

		$('#close').click(function(){
			  $('.modal-bg').fadeOut();
			  $('#modal').fadeOut();
		  return false;
		});
</script>
<style>
       #map {
        height: 300px;
        width: 100%;
       }
    </style>
    <script>
      function initMap() {
        var uluru = {lat: 46.206667, lng: 6.143569};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQqLBvJ2mFzZNq1LpeFooWD7bREfQWMZI&callback=initMap">
    </script>

  </body>
</html>
