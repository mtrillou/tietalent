


<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>Shortlist</title>
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
          <a class="navbar-brand" href="/"><img width="150px" src="{{ asset('public/img/logott.png') }}" alt="TieTalent logo" title="TieTalent logo"/></a>
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

    <main id="mainSignup" style="padding-top:5rem;">
      <script>
        (function(e){function t(t,n,r){var i=e(".original").offset();orgElementTop=i.top;var s=window,o="inner";if(!("innerWidth"in window)){o="client";s=document.documentElement||document.body}viewport=s[o+"Width"];if(e(window).scrollTop()>=orgElementTop-t&&viewport>=n&&viewport<=r){orgElement=e(".original");coordsOrgElement=orgElement.offset();leftOrgElement=coordsOrgElement.left;widthOrgElement=orgElement.css("width");e(".cloned").css("left",leftOrgElement+"px").css("top",t+"px").css("width",widthOrgElement).show();e(".original").css("visibility","hidden")}else{e(".cloned").hide();e(".original").css("visibility","visible")}}e.fn.stickThis=function(n){var r=e.extend({top:0,minscreenwidth:0,maxscreenwidth:99999,zindex:1,debugmode:false},n);var i=e(this).length;if(i<1){if(r.debugmode==true){console.error("STICKY ANYTHING DEBUG: There are no elements with the class/ID you selected.")}}else if(i>1){if(r.debugmode==true){console.error("STICKY ANYTHING DEBUG: There is more than one element with the class/ID you selected. You can only make ONE element sticky.")}}else{e(this).addClass("original").clone().insertAfter(this).addClass("cloned").css("position","fixed").css("top",r.top+"px").css("margin-top","0").css("margin-left","0").css("z-index",r.zindex).removeClass("original").hide();checkElement=setInterval(function(){t(r.top,r.minscreenwidth,r.maxscreenwidth)},10)}return this}})
      </script>
    <div style="width:85%;padding:2%;height:20rem;margin:0 auto;">
      <button id="demoHeader" class="col-md-4 box first nooutline noborder buttonJohnWayne" style="width:30%;background-color:white;margin:1.5%">
        <span class="icon-cont"><img class="" src="#" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
        <h2 style="color:#F14904;border-bottom: 1px solid #333333;">John Wayne*</h2>
        <ul class="hidden" style="color:#333333">
          <li onmouseover="this.style.color='#333333'">Vit à Genève</li>
          <li onmouseover="this.style.color='#333333'">Attentes salariales de CHF 80'000 / an</li>
          <li onmouseover="this.style.color='#333333'">Disponible de suite</li>
        </ul>
      </button>
      <button class="col-md-4 box first nooutline noborder" style="width:30%;background-color:white;margin:1.5%">
        <span class="icon-cont"><img class="" src="#" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
        <h2 style="color:#F14904;border-bottom: 1px solid #333333;">Indiana Jones*</h2>
        <ul class="hidden" style="color:#333333">
          <li onmouseover="this.style.color='#333333'">Vit à Genève</li>
          <li onmouseover="this.style.color='#333333'">Attentes salariales de CHF 80'000 / an</li>
          <li onmouseover="this.style.color='#333333'">Disponible de suite</li>
        </ul>
      </button>
      <button class="col-md-4 box first nooutline noborder" style="width:30%;background-color:white;margin:1.5%">
        <span class="icon-cont"><img class="" src="#" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
        <h2 style="color:#F14904;border-bottom: 1px solid #333333;">Marty McFly*</h2>
        <ul class="hidden" style="color:#333333">
          <li onmouseover="this.style.color='#333333'">Vit à Genève</li>
          <li onmouseover="this.style.color='#333333'">Attentes salariales de CHF 80'000 / an</li>
          <li onmouseover="this.style.color='#333333'">Disponible de suite</li>
        </ul>
      </button>
    </div>

    <div class="modal-bg" style="display:none;">
      <div id="modal" style="width:80%;left:10%;top:30%;">
        <span style="font-size:1.5rem;">John Wayne*<a href="#close" id="close">&#215;</a></span>
        <div class="form-wrap signup-form-wrap alignleft" style="width:90%;padding:2%;">
          <h4 style="margin-bottom:0.5rem;">Key elements:</h4>
          <ul>
            <li style="margin-left:4rem;list-style:circle">2 years of experience as accounts payable in a multinational company</li>
            <li style="margin-left:4rem;list-style:circle">Dynamic personality</li>
          </ul>
          <h4 style="margin-bottom:0.5rem;">Our partner comments:</h4> <i>"He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate"</i>
          <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
            <div style="width:50%">
              <h4 style="margin-bottom:0.5rem;text-align:center">Language skills:</h4>
              <ul>
                <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/french.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                    Fluent <br/>
                </li>
                <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/english.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                    Fluent <br/>
                </li>
                <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/german.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                    Mother tongue <br/>
                </li>
              </ul>
            </div>
            <div style="width:50%;text-align:center">
              <h4 style="margin-bottom:0.5rem;">IT skills:</h4>
              <ul>
                <li style="margin-left:2rem;">SAP</li>
                <li style="margin-left:2rem;">Excel</li>
              </ul>
            </div>
          </div>
          <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
            <h4 style="margin-bottom:0.5rem;">Salary preferences: CHF 80'000 / year</h4>
            <h4 style="margin-bottom:0.5rem;">Availability: immediately</h4>
          </div>
        </div><!--.form-wrap-->
      </div>
    </div>



    <!--
      <div class="form-wrap signup-form-wrap alignleft" style="width:75%;padding:2%;margin-top:3rem;">
        <h2 class="centeralign">Indiana Jones</h2>
        <h4 style="margin-bottom:0.5rem;">Key elements:</h4>
        <ul>
          <li style="margin-left:4rem;list-style:circle">2 years of experience as accounts payable in a multinational company</li>
          <li style="margin-left:4rem;list-style:circle">Dynamic personality</li>
        </ul>
        <h4 style="margin-bottom:0.5rem;">Our partner comments:</h4> <i>"He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate"</i>
        <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
          <div style="width:50%">
            <h4 style="margin-bottom:0.5rem;text-align:center">Language skills:</h4>
            <ul>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/french.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id="candidateLangaugeSkillsFrench"></span>Fluent <br/>
              </li>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/english.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id=""></span>Fluent <br/>
              </li>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/german.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id=""></span>Mother tongue <br/>
              </li>
            </ul>
          </div>
          <div style="width:50%;text-align:center">
            <h4 style="margin-bottom:0.5rem;">IT skills:</h4>
            <ul>
              <li style="margin-left:2rem;">SAP</li>
              <li style="margin-left:2rem;">Excel</li>
            </ul>
          </div>
        </div>
        <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
          <h4 style="margin-bottom:0.5rem;">Salary preferences: CHF 80'000 / year</h4>
          <h4 style="margin-bottom:0.5rem;">Availability: immediately</h4>
        </div>
      </div>

      <div class="form-wrap signup-form-wrap alignleft" style="width:75%;padding:2%;margin-top:3rem;">
        <h2 class="centeralign">Marty McFly</h2>
        <h4 style="margin-bottom:0.5rem;">Key elements:</h4>
        <ul>
          <li style="margin-left:4rem;list-style:circle">2 years of experience as accounts payable in a multinational company</li>
          <li style="margin-left:4rem;list-style:circle">Dynamic personality</li>
        </ul>
        <h4 style="margin-bottom:0.5rem;">Our partner comments:</h4> <i>"He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate He is a very bright and intelligent candidate"</i>
        <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
          <div style="width:50%">
            <h4 style="margin-bottom:0.5rem;text-align:center">Language skills:</h4>
            <ul>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/french.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id="candidateLangaugeSkillsFrench"></span>Fluent <br/>
              </li>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/english.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id=""></span>Fluent <br/>
              </li>
              <li style="margin-left:2rem;margin:1rem"><img class='logo' width='20px' src="{{ asset('public/img/german.png') }}" style='float:left;margin:0rem 25%;' alt='logo' title='logo'/>
                  <span id=""></span>Mother tongue <br/>
              </li>
            </ul>
          </div>
          <div style="width:50%;text-align:center">
            <h4 style="margin-bottom:0.5rem;">IT skills:</h4>
            <ul>
              <li style="margin-left:2rem;">SAP</li>
              <li style="margin-left:2rem;">Excel</li>
            </ul>
          </div>
        </div>
        <div class="row" style="margin-top:1rem;margin:0;align-items: flex-start;">
          <h4 style="margin-bottom:0.5rem;">Salary preferences: CHF 80'000 / year</h4>
          <h4 style="margin-bottom:0.5rem;">Availability: immediately</h4>
        </div>
      </div>

    -->

      <p class="linktoregistration" style="font-size:1rem;">* the candidate names and pictures are randomly taken in order to keep their identity confidential</p>
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
<script>
  $(window).load(function(){
    $("#demoHeader").sticky({ topSpacing: 0 });
  });
</script>
<script>
$('.buttonJohnWayne').click(function(){
		  $('#modal').css('display','block');
		  $('.modal-bg').fadeIn();
	});

		$('#close').click(function(){
			  $('.modal-bg').fadeOut();
			  $('#modal').fadeOut();
		  return false;
		});
</script>
  </body>
</html>
