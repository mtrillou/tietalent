
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8"/>
      <title>{{ trans('welcomecompany.pagetitle') }}</title>
      <meta name="description" content="{{ trans('welcomecompany.pageDescription') }}" />
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
            <span class="navButton">{{ trans('welcomecandidate.headercandidatetitle') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="/candidates/welcome">{{ trans('welcomecandidate.headercandidatehiw') }}</a></li>
              <li><a href="/candidates/faq">{{ trans('welcomecandidate.headercandidatefaq') }}</a></li>
            </ul>
          </li>
          <li>
            <span class="navButton"><span class="orange">{{ trans('welcomecandidate.headercompanytitle') }}</span> <i class="fa fa-angle-down orange" aria-hidden="true"></i></span>
            <ul>
              <li><a href="#steps">{{ trans('welcomecandidate.headercompanyhiw') }}</a></li>
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
    <main id="welcomecompany-main" class="lightGreyBackground">
        <script>
          (function(e){function t(t,n,r){var i=e(".original").offset();orgElementTop=i.top;var s=window,o="inner";if(!("innerWidth"in window)){o="client";s=document.documentElement||document.body}viewport=s[o+"Width"];if(e(window).scrollTop()>=orgElementTop-t&&viewport>=n&&viewport<=r){orgElement=e(".original");coordsOrgElement=orgElement.offset();leftOrgElement=coordsOrgElement.left;widthOrgElement=orgElement.css("width");e(".cloned").css("left",leftOrgElement+"px").css("top",t+"px").css("width",widthOrgElement).show();e(".original").css("visibility","hidden")}else{e(".cloned").hide();e(".original").css("visibility","visible")}}e.fn.stickThis=function(n){var r=e.extend({top:0,minscreenwidth:0,maxscreenwidth:99999,zindex:1,debugmode:false},n);var i=e(this).length;if(i<1){if(r.debugmode==true){console.error("STICKY ANYTHING DEBUG: There are no elements with the class/ID you selected.")}}else if(i>1){if(r.debugmode==true){console.error("STICKY ANYTHING DEBUG: There is more than one element with the class/ID you selected. You can only make ONE element sticky.")}}else{e(this).addClass("original").clone().insertAfter(this).addClass("cloned").css("position","fixed").css("top",r.top+"px").css("margin-top","0").css("margin-left","0").css("z-index",r.zindex).removeClass("original").hide();checkElement=setInterval(function(){t(r.top,r.minscreenwidth,r.maxscreenwidth)},10)}return this}})
        </script>
        <div id="demoHeader" style="display:flex;justify-content:space-around">
          <p class="fontweightlight" style="font-size:1.2rem;margin-top:0.5rem;margin-bottom:0.5rem;">{{ trans('welcomecompany.hireProfessionals') }}</p>
          <button type="button" name="button" class="button" style="background-color:white;color:#333333;border:none;padding:0.2rem 1rem">{{ trans('welcomecompany.requestDemo') }}</button>
        </div>
        <div class="modal-bg" style="display:none;">
          <div id="modal" style="width:50%;">
            <span style="font-size:1.5rem;">{{ trans('welcomecompany.requestDemo') }}<a href="#close" id="close">&#215;</a></span>
            <form role="form" action="demoRequest" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input id="" class="inputRequestDemo" name="firstName" type="textbox" placeholder="{{ trans('signup.company_element_one') }}" required>
              <input id="" class="inputRequestDemo" name="lastName" placeholder="{{ trans('signup.company_element_two') }}" required>
              <input id="" class="inputRequestDemo" name="email" placeholder="{{ trans('signup.company_element_four') }}" required>
              <input id="" class="inputRequestDemo" name="phone" placeholder="{{ trans('signup.company_element_five') }}" required>
              <input id="" class="inputRequestDemo" name="company" placeholder="{{ trans('signup.company_element_three') }}" required>
              <input id="" class="inputRequestDemo" name="position" placeholder="{{ trans('signup.company_element_six') }}" required>
              <button name="submit" id="submit" type="submit" style="display:block;width:30%;background-color:#4FDA8C;border:none;border-radius:0.5rem;margin:0 auto;padding:0.5rem;margin-top:1.5rem;margin-bottom:1.5rem;color:white;">{{ trans('welcomecompany.requestDemo') }}</button>
            </form>
          </div>
        </div>

        <h1 class="darkGreyColor centeralign" style="padding:2.5rem 0rem">Pricing Guide</h1>

        <div class="width-big" style="background-color:white;margin:0 auto;border-top:7px solid #F14904;color:#333333">
          <h2 style="padding:2.5rem 0rem">Different <span class="orange underlineDarkGrey">pricing</span> for your different needs</h2>

          <table class="table">
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">
                <div class="pricingContractType">
                  Permanent recruitment
                </div>
              </td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">One-time fee</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">Monthly fee</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">Monthly subscription</td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"><span style="font-size:5rem">9</span>%
                <br/><small>of candidate's yearly salary</small>
              </td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"><span style="font-size:5rem">1</span>%
                <br/><small>of candidate's yearly salary</small>
              </td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"><span style="font-size:5rem">?</span></td>
            </tr>
            <tr>
              <td class="col-md-3" style="border-right:1px solid #F1F1F1;border-top:none;"></td>
              <td class="col-md-3" style="border-right:1px solid #F1F1F1;border-top:none;"><button style="" class="nooutline buttonPricing"><i class="fa fa-unlock" aria-hidden="true"></i> Get Started</button></td>
              <td class="col-md-3" style="border-right:1px solid #F1F1F1;border-top:none;"><button style="" class="nooutline buttonPricing"><i class="fa fa-unlock" aria-hidden="true"></i> Get Started</button></td>
              <td class="col-md-3" style="border-right:1px solid #F1F1F1;border-top:none;"><button style="" class="nooutline buttonPricingGrey">Contact Us</button></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">Success basis</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-question-circle orange" aria-hidden="true"></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">One-time fee</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-question-circle orange" aria-hidden="true"></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">14 months monthly subscription</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-question-circle orange" aria-hidden="true"></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">Instant access to the best talents</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-question-circle orange" aria-hidden="true"></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">Candidates interviewed and recommended by our partners</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-check-circle" style="color:#28A55F" aria-hidden="true"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;"><i class="fa fa-question-circle orange" aria-hidden="true"></td>
            </tr>



            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">100% guarantee up to 90 days</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-question-circle orange" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">One-time fee</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-question-circle orange" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td style="border-right:1px solid #F1F1F1;border-top:none;">14-month period</td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;"></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
              <td style="border-right:1px solid #F1F1F1;border-top:none;font-size:3rem;color:#28A55F"><i class="fa fa-question-circle orange" aria-hidden="true"></i></td>
            </tr>
          </table>
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

  </body>
</html>
