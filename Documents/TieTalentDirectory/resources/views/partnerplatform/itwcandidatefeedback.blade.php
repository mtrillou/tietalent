

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>{{ trans('partnerplatform_itwcandidatefeedback.pagetitle') }}</title>
    <meta name="description" content="content of the description" />
    <meta name="recruitment" content="---"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/fontawesome/css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-slider.min.css') }}" type="text/css" />
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
      <nav role='navigation' class="topbar" style="position:fixed;width:100%;z-index:100;box-shadow:1px 1px 1px #333333;">
        <a href="/home"><img class="logo" id="logoTieTalentSmallMenu" width="150px"src="{{ asset('public/img/logott.png') }}" style="float:left;" alt="logo" title="logo"/></a><a class="toggle" href="#" style="text-align:right;">&#9776;</a>
        <a href="/home" id="logoTieTalent"><img class="logo" width="150px"src="{{ asset('public/img/logott.png') }}" style="margin-left:4rem;float:left;padd" alt="logo" title="logo"/></a>
        <ul class="nav" style="flex-direction:row-reverse;">
          <li><a href="#">{{ trans('partnerplatform_candidateDetails.settings') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
            <ul>
              <li><a href="/partner/settings">{{ trans('partnerplatform_candidateDetails.account') }}</a></li>
              <li><a href="/partner/faq">{{ trans('partnerplatform_candidateDetails.faq') }}</a></li>
              <li><a href="/partner/feedback">{{ trans('partnerplatform_candidateDetails.feedback') }}</a></li>
              <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('partnerplatform_candidateDetails.logout') }}</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
    <main>
      <div id="candidatemainpage">
        <aside class="leftpart">
          <h1><a href="/home"><img class="profile-picture-circle" src="{{ asset('public/uploads/avatars') }}/{{ $partners->avatar }}" height="100px" width="100px"></a></h1>
          <ul>
            <li><a href="/home">{{ trans('partnerplatform_candidateDetails.profile') }}</a></li>
            <li><a href="/partner/documents">{{ trans('partnerplatform_candidateDetails.documents') }}</a></li>
            <li><a href="/partner/candidates">{{ trans('partnerplatform_candidateDetails.candidates') }}</a></li>
            <li><a href="/partner/interviews" class="orange">{{ trans('partnerplatform_candidateDetails.interviews') }}</a></li>
            <li><a href="/partner/invitefriends">{{ trans('partnerplatform_candidateDetails.inviteFriends') }}</a></li>
          </ul>
        </aside>
        <article class="rightpart telluswhatyouthink">
          <p id="partnerFeedbackStatut" style="display:none;">{{ $partnerInterviewFeedback->partnerStatut }}</p>
          <div id="feedbackToGive" style="display:none;">
            <form class="" action="/partner/interviewCandidateFeedback" method="post">
                {{ csrf_field() }}
                <input name="candidate_id_user" type="hidden" value="{{ $candidates->id_user }}">
              <h2 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview') }}<h2>
              <p class="centeralign">{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview2') }}</p>
              <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview3') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview4') }}</small>
              </h3>
              <!-- LIKE -->
              <section id="like" class="rating" >
                <!-- FIFTH HEART -->
                <input type="radio" id="heart_5_partnerExperienceCandidate" name="partnerExperienceCandidate" value="5" />
                <label for="heart_5_partnerExperienceCandidate" title="Five">&#10084;</label>
                <!-- FOURTH HEART -->
                <input type="radio" id="heart_4_partnerExperienceCandidate" name="partnerExperienceCandidate" value="4" />
                <label for="heart_4_partnerExperienceCandidate" title="Four">&#10084;</label>
                <!-- THIRD HEART -->
                <input type="radio" id="heart_3_partnerExperienceCandidate" name="partnerExperienceCandidate" value="3" />
                <label for="heart_3_partnerExperienceCandidate" title="Three">&#10084;</label>
                <!-- SECOND HEART -->
                <input type="radio" id="heart_2_partnerExperienceCandidate" name="partnerExperienceCandidate" value="2" />
                <label for="heart_2_partnerExperienceCandidate" title="Two">&#10084;</label>
                <!-- FIRST HEART -->
                <input type="radio" id="heart_1_partnerExperienceCandidate" name="partnerExperienceCandidate" value="1" />
                <label for="heart_1_partnerExperienceCandidate" title="One">&#10084;</label>
              </section>

              <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.candidatePresentation') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.candidatePresentation2') }}</small>
              </h3>
              <!-- LIKE -->
              <section id="like" class="rating" >
                <!-- FIFTH HEART -->
                <input type="radio" id="heart_5_partnerCandidatePresentation" name="partnerCandidatePresentation" value="5" />
                <label for="heart_5_partnerCandidatePresentation" title="Five">&#10084;</label>
                <!-- FOURTH HEART -->
                <input type="radio" id="heart_4_partnerCandidatePresentation" name="partnerCandidatePresentation" value="4" />
                <label for="heart_4_partnerCandidatePresentation" title="Four">&#10084;</label>
                <!-- THIRD HEART -->
                <input type="radio" id="heart_3_partnerCandidatePresentation" name="partnerCandidatePresentation" value="3" />
                <label for="heart_3_partnerCandidatePresentation" title="Three">&#10084;</label>
                <!-- SECOND HEART -->
                <input type="radio" id="heart_2_partnerCandidatePresentation" name="partnerCandidatePresentation" value="2" />
                <label for="heart_2_partnerCandidatePresentation" title="Two">&#10084;</label>
                <!-- FIRST HEART -->
                <input type="radio" id="heart_1_partnerCandidatePresentation" name="partnerCandidatePresentation" value="1" />
                <label for="heart_1_partnerCandidatePresentation" title="One">&#10084;</label>
              </section>

              <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.candidateCommunication') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.candidateCommunication2') }}</small>
              </h3>
              <!-- LIKE -->
              <section id="like" class="rating" >
                <!-- FIFTH HEART -->
                <input type="radio" id="heart_5_partnerCandidateCommunication" name="partnerCandidateCommunication" value="5" />
                <label for="heart_5_partnerCandidateCommunication" title="Five">&#10084;</label>
                <!-- FOURTH HEART -->
                <input type="radio" id="heart_4_partnerCandidateCommunication" name="partnerCandidateCommunication" value="4" />
                <label for="heart_4_partnerCandidateCommunication" title="Four">&#10084;</label>
                <!-- THIRD HEART -->
                <input type="radio" id="heart_3_partnerCandidateCommunication" name="partnerCandidateCommunication" value="3" />
                <label for="heart_3_partnerCandidateCommunication" title="Three">&#10084;</label>
                <!-- SECOND HEART -->
                <input type="radio" id="heart_2_partnerCandidateCommunication" name="partnerCandidateCommunication" value="2" />
                <label for="heart_2_partnerCandidateCommunication" title="Two">&#10084;</label>
                <!-- FIRST HEART -->
                <input type="radio" id="heart_1_partnerCandidateCommunication" name="partnerCandidateCommunication" value="1" />
                <label for="heart_1_partnerCandidateCommunication" title="One">&#10084;</label>
              </section>


              <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.languageSkills') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.languageSkills2') }}</small></h3>
              <div>
                <select class="languageSelection width-middleMinus nooutline" name="language1" required>
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.language') }}</option>
                  <option value="english">{{ trans('partnerplatform_itwcandidatefeedback.english') }}</option>
                  <option value="french">{{ trans('partnerplatform_itwcandidatefeedback.french') }}</option>
                  <option value="german">{{ trans('partnerplatform_itwcandidatefeedback.german') }}</option>
                  <option value="italian">{{ trans('partnerplatform_itwcandidatefeedback.italian') }}</option>
                  <option value="spanish">{{ trans('partnerplatform_itwcandidatefeedback.spanish') }}</option>
                  <option value="portuguese">{{ trans('partnerplatform_itwcandidatefeedback.portuguese') }}</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language1Level" required>
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.level') }}</option>
                  <option value="basic">{{ trans('partnerplatform_itwcandidatefeedback.basic') }}</option>
                  <option value="good level">{{ trans('partnerplatform_itwcandidatefeedback.goodLevel') }}</option>
                  <option value="fluent">{{ trans('partnerplatform_itwcandidatefeedback.fluent') }}</option>
                  <option value="mother tongue">{{ trans('partnerplatform_itwcandidatefeedback.motherTongue') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language1Statut" required>
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.test') }}</option>
                  <option value="tested">{{ trans('partnerplatform_itwcandidatefeedback.tested') }}</option>
                  <option value="not tested">{{ trans('partnerplatform_itwcandidatefeedback.notTested') }}</option>
                </select>
                <i class="fa fa-plus addlanguage-2 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus opacity-zero" aria-hidden="true"></i>
              </div>
              <div class="vacancy-language-2">
                <select class="languageSelection width-middleMinus nooutline" name="language2">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.language') }}</option>
                  <option value="english">{{ trans('partnerplatform_itwcandidatefeedback.english') }}</option>
                  <option value="french">{{ trans('partnerplatform_itwcandidatefeedback.french') }}</option>
                  <option value="german">{{ trans('partnerplatform_itwcandidatefeedback.german') }}</option>
                  <option value="italian">{{ trans('partnerplatform_itwcandidatefeedback.italian') }}</option>
                  <option value="spanish">{{ trans('partnerplatform_itwcandidatefeedback.spanish') }}</option>
                  <option value="portuguese">{{ trans('partnerplatform_itwcandidatefeedback.portuguese') }}</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language2Level">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.level') }}</option>
                  <option value="basic">{{ trans('partnerplatform_itwcandidatefeedback.basic') }}</option>
                  <option value="good level">{{ trans('partnerplatform_itwcandidatefeedback.goodLevel') }}</option>
                  <option value="fluent">{{ trans('partnerplatform_itwcandidatefeedback.fluent') }}</option>
                  <option value="mother tongue">{{ trans('partnerplatform_itwcandidatefeedback.motherTongue') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language2Statut">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.test') }}</option>
                  <option value="tested">{{ trans('partnerplatform_itwcandidatefeedback.tested') }}</option>
                  <option value="not tested">{{ trans('partnerplatform_itwcandidatefeedback.notTested') }}</option>
                </select>
                <i class="fa fa-plus addlanguage-3 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deletelanguage-2" aria-hidden="true"></i>
              </div>
              <div class="vacancy-language-3">
                <select class="languageSelection width-middleMinus nooutline" name="language3">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.language') }}</option>
                  <option value="english">{{ trans('partnerplatform_itwcandidatefeedback.english') }}</option>
                  <option value="french">{{ trans('partnerplatform_itwcandidatefeedback.french') }}</option>
                  <option value="german">{{ trans('partnerplatform_itwcandidatefeedback.german') }}</option>
                  <option value="italian">{{ trans('partnerplatform_itwcandidatefeedback.italian') }}</option>
                  <option value="spanish">{{ trans('partnerplatform_itwcandidatefeedback.spanish') }}</option>
                  <option value="portuguese">{{ trans('partnerplatform_itwcandidatefeedback.portuguese') }}</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language3Level">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.level') }}</option>
                  <option value="basic">{{ trans('partnerplatform_itwcandidatefeedback.basic') }}</option>
                  <option value="good level">{{ trans('partnerplatform_itwcandidatefeedback.goodLevel') }}</option>
                  <option value="fluent">{{ trans('partnerplatform_itwcandidatefeedback.fluent') }}</option>
                  <option value="mother tongue">{{ trans('partnerplatform_itwcandidatefeedback.motherTongue') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language3Statut">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.test') }}</option>
                  <option value="tested">{{ trans('partnerplatform_itwcandidatefeedback.tested') }}</option>
                  <option value="not tested">{{ trans('partnerplatform_itwcandidatefeedback.notTested') }}</option>
                </select>
                <i class="fa fa-plus addlanguage-4 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deletelanguage-3" aria-hidden="true"></i>
              </div>
              <div class="vacancy-language-4">
                <select class="languageSelection width-middleMinus nooutline" name="language4">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.language') }}</option>
                  <option value="english">{{ trans('partnerplatform_itwcandidatefeedback.english') }}</option>
                  <option value="french">{{ trans('partnerplatform_itwcandidatefeedback.french') }}</option>
                  <option value="german">{{ trans('partnerplatform_itwcandidatefeedback.german') }}</option>
                  <option value="italian">{{ trans('partnerplatform_itwcandidatefeedback.italian') }}</option>
                  <option value="spanish">{{ trans('partnerplatform_itwcandidatefeedback.spanish') }}</option>
                  <option value="portuguese">{{ trans('partnerplatform_itwcandidatefeedback.portuguese') }}</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language4Level">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.level') }}</option>
                  <option value="basic">{{ trans('partnerplatform_itwcandidatefeedback.basic') }}</option>
                  <option value="good level">{{ trans('partnerplatform_itwcandidatefeedback.goodLevel') }}</option>
                  <option value="fluent">{{ trans('partnerplatform_itwcandidatefeedback.fluent') }}</option>
                  <option value="mother tongue">{{ trans('partnerplatform_itwcandidatefeedback.motherTongue') }}</option>
                </select>
                <select class="languageSelection width-middleMinus nooutline" name="language4Statut">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.test') }}</option>
                  <option value="tested">{{ trans('partnerplatform_itwcandidatefeedback.tested') }}</option>
                  <option value="not tested">{{ trans('partnerplatform_itwcandidatefeedback.notTested') }}</option>
                </select>
                <i class="fa fa-plus opacity-zero marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deletelanguage-4" aria-hidden="true"></i>
              </div>




              <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.ITSkills') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.ITSkills2') }}</small></h3>
              <div>
                <select class="ITSelection width-middleMinus nooutline" name="IT1">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.software') }}</option>
                  <option value="Abacus">Abacus</option>
                  <option value="AS400">AS400</option>
                  <option value="Dynamics">Dynamics</option>
                  <option value="Excel">Excel</option>
                  <option value="Oracle">Oracle</option>
                  <option value="PeopleSoft">PeopleSoft</option>
                  <option value="ProConcept">ProConcept</option>
                  <option value="Sadies">Sadies</option>
                  <option value="Sage">Sage</option>
                  <option value="SAP">SAP</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="ITSelection width-middleMinus nooutline" name="IT1Usage">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.use') }}</option>
                  <option value="class">{{ trans('partnerplatform_itwcandidatefeedback.learnedInClass') }}</option>
                  <option value="work">{{ trans('partnerplatform_itwcandidatefeedback.usedAtWork') }}</option>
                </select>
                <i class="fa fa-plus addIT-2 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus opacity-zero" aria-hidden="true"></i>
              </div>
              <div class="vacancy-IT-2">
                <select class="ITSelection width-middleMinus nooutline" name="IT2">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.software') }}</option>
                  <option value="Abacus">Abacus</option>
                  <option value="AS400">AS400</option>
                  <option value="Dynamics">Dynamics</option>
                  <option value="Excel">Excel</option>
                  <option value="Oracle">Oracle</option>
                  <option value="PeopleSoft">PeopleSoft</option>
                  <option value="ProConcept">ProConcept</option>
                  <option value="Sadies">Sadies</option>
                  <option value="Sage">Sage</option>
                  <option value="SAP">SAP</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="ITSelection width-middleMinus nooutline" name="IT2Usage">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.use') }}</option>
                  <option value="class">{{ trans('partnerplatform_itwcandidatefeedback.learnedInClass') }}</option>
                  <option value="work">{{ trans('partnerplatform_itwcandidatefeedback.usedAtWork') }}</option>
                </select>
                <i class="fa fa-plus addIT-3 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deleteIT-2" aria-hidden="true"></i>
              </div>
              <div class="vacancy-IT-3">
                <select class="ITSelection width-middleMinus nooutline" name="IT3">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.software') }}</option>
                  <option value="Abacus">Abacus</option>
                  <option value="AS400">AS400</option>
                  <option value="Dynamics">Dynamics</option>
                  <option value="Excel">Excel</option>
                  <option value="Oracle">Oracle</option>
                  <option value="PeopleSoft">PeopleSoft</option>
                  <option value="ProConcept">ProConcept</option>
                  <option value="Sadies">Sadies</option>
                  <option value="Sage">Sage</option>
                  <option value="SAP">SAP</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="ITSelection width-middleMinus nooutline" name="IT3Usage">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.use') }}</option>
                  <option value="class">{{ trans('partnerplatform_itwcandidatefeedback.learnedInClass') }}</option>
                  <option value="work">{{ trans('partnerplatform_itwcandidatefeedback.usedAtWork') }}</option>
                </select>
                <i class="fa fa-plus addIT-4 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deleteIT-3" aria-hidden="true"></i>
              </div>
              <div class="vacancy-IT-4">
                <select class="ITSelection width-middleMinus nooutline" name="IT4">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.software') }}</option>
                  <option value="Abacus">Abacus</option>
                  <option value="AS400">AS400</option>
                  <option value="Dynamics">Dynamics</option>
                  <option value="Excel">Excel</option>
                  <option value="Oracle">Oracle</option>
                  <option value="PeopleSoft">PeopleSoft</option>
                  <option value="ProConcept">ProConcept</option>
                  <option value="Sadies">Sadies</option>
                  <option value="Sage">Sage</option>
                  <option value="SAP">SAP</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="ITSelection width-middleMinus nooutline" name="IT4Usage">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.use') }}</option>
                  <option value="class">{{ trans('partnerplatform_itwcandidatefeedback.learnedInClass') }}</option>
                  <option value="work">{{ trans('partnerplatform_itwcandidatefeedback.usedAtWork') }}</option>
                </select>
                <i class="fa fa-plus addIT-5 marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deleteIT-4" aria-hidden="true"></i>
              </div>
              <div class="vacancy-IT-5">
                <select class="ITSelection width-middleMinus nooutline" name="IT5">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.software') }}</option>
                  <option value="Abacus">Abacus</option>
                  <option value="AS400">AS400</option>
                  <option value="Dynamics">Dynamics</option>
                  <option value="Excel">Excel</option>
                  <option value="Oracle">Oracle</option>
                  <option value="PeopleSoft">PeopleSoft</option>
                  <option value="ProConcept">ProConcept</option>
                  <option value="Sadies">Sadies</option>
                  <option value="Sage">Sage</option>
                  <option value="SAP">SAP</option>
                  <option value="other">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</option>
                </select>
                <select class="ITSelection width-middleMinus nooutline" name="IT5Usage">
                  <option value="">{{ trans('partnerplatform_itwcandidatefeedback.use') }}</option>
                  <option value="class">{{ trans('partnerplatform_itwcandidatefeedback.learnedInClass') }}</option>
                  <option value="work">{{ trans('partnerplatform_itwcandidatefeedback.usedAtWork') }}</option>
                </select>
                <i class="fa fa-plus opacity-zero marginright-small" aria-hidden="true"></i>
                <i class="fa fa-minus deleteIT-5 " aria-hidden="true"></i>
              </div>



              <h3 class="aligncenter" style="padding-bottom:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.wouldYouHire') }}</h3>
              <div class="row" id="hiringChoice" style="margin-bottom:4rem;">
                <div class="col-md-4"><input type="radio" id="recommended" name="recommendation" value="Yes" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.yes') }}</label></div>
                <div class="col-md-4"><input type="radio" id="notRecommended" name="recommendation" value="No" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add" required><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.no') }}</label></div>
              </div>

              <div id="notRecommended_tab" style="display:none;margin-bottom:-3rem;">
                <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.whyNot') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.whyNot2') }}</small>
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.messageCandidate2') }}</small>
              </h3>
                <textarea name="reasonNoRecommendation" cols="40" rows="5" id="reasonNoRecommendation" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.giveReasons') }}"></textarea>
              </div>

              <div id="recommended_tab" style="display:none;">
                <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.softSkills') }}
                  <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.softSkills2') }}
                  <br/><b>{{ trans('partnerplatform_itwcandidatefeedback.softSkills3') }}</b></small>
                </h3>
                <input class="col-md-12 borderradius marginbottom-middle" type="text" id="reasonRecommendationPersonality" name="Reason_Personality" placeholder="">
                <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.forWhichPosition') }}</h3>
                <h6>{{ trans('partnerplatform_itwcandidatefeedback.financeAccounting') }}</h6>
                <div id="departmentFandA">
                  <h3 class="fs-subtitle" style="padding-bottom:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.department') }}</h3>
                    <div class="radioinput">
                      <div class="row margintop-small marginbottom-middle">
                        <div class="col-md-3"><input type="radio" id="dpt_accounting" name="department" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.accounting') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="dpt_FandC" name="department" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.financeControlling') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="dpt_TaxTreasury" name="department" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.taxTreasury') }}</label></div>
                        <div class="col-md-3"><input type="radio" id="dpt_other" name="department" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</label></div>
                      </div>
                    </div>
                  </div>
                  <input type="text" id="dpt_other_dpt" style="display:none;" class="col-md-12 borderradius marginbottom-xsmall" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whatOtherDepartment') }}"/>
                  <div id="candidateFunctionsFandA">
                    <div id="functions_accounting" style="display:none;">
                      <h3 class="fs-subtitle" style="padding-bottom:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.function') }}</h3>
                      <div class="radioinput">
                        <div class="row margintop-small" style="padding-bottom:2.5rem;">
                          <div class="col-md-4"><input type="checkbox" id="fun_accountsPayable" name="functionAccountsPayable" value="Accounts Payable" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.accountsPayable') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_accountsReceivable" name="functionAccountsReceivable" value="Accounts Receivable - Billing specialist" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.accountsReceivable') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_generalLedger" name="functionGeneralLedger" value="General Ledger" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.generalLedger') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_payrollSpecialist" name="functionPayrollSpecialist" value="Payroll Specialist" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.payroll') }}</label></div>
                        </div>
                        <div class="row margintop-small marginbottom-middle">
                          <div class="col-md-4"><input type="checkbox" id="fun_creditAnalyst" name="functionCreditAnalyst" value="Credit Analyst" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.creditAnalyst') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_internalAudit" name="functionInternalAudit" value="Internal Audit" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.internalAudit') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_externalAudit" name="functionExternalAudit" value="External Audit" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.externalAudit') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" name="functionOther" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add fun_Other candidateOtherFunctionChoice"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</label></div>
                        </div>
                      </div>
                      <div class="radioinput">
                          <div id="fun_accountsPayable_reason"  style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationAccountsPayable') }}</h2>
                            <p id="alert_accountsPayable" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" id="reasonRecommendationAccountsPayable" rows="5" name="Reason_AccountsPayable" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyAccountsPayable') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityAccountsPayable') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAccountsPayable" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAccountsPayable" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAccountsPayable" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAccountsPayable" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeAccountsPayable') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsPayable[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>


                          <div id="fun_accountsReceivable_reason"  style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationAccountsReceivable') }}</h2>
                            <p id="alert_accountsReceivable" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationAccountsReceivable" name="Reason_AccountsReceivable" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyAccountsReceivable') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;margin-bottom:2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityAccountsReceivable') }}</small></h4>
                                <div class="col-md-3"><input type="radio" name="seniorityLevelAccountsReceivable" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3"><input type="radio" name="seniorityLevelAccountsReceivable" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3"><input type="radio" name="seniorityLevelAccountsReceivable" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3"><input type="radio" name="seniorityLevelAccountsReceivable" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeAccountsReceivable') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAccountsReceivable[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>

                          <div id="fun_generalLedger_reason" style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationGeneralLedger') }}</h2>
                            <p id="alert_generalLedger" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationGeneralLedger" name="Reason_GeneralLedger" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyGeneralLedger') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityGeneralLedger') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelGeneralLedger" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelGeneralLedger" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelGeneralLedger" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelGeneralLedger" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeGeneralLedger') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeGeneralLedger[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>

                          <div id="fun_payrollSpecialist_reason" style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationPayrollSpecialist') }}</h2>
                            <p id="alert_payrollSpecialist" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationPayrollSpecialist" name="Reason_PayrollSpecialist" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyPayroll') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityPayroll') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelPayrollSpecialist" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelPayrollSpecialist" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelPayrollSpecialist" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelPayrollSpecialist" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypePayroll') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypePayrollSpecialist[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>

                          <div id="fun_creditAnalyst_reason" style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationCreditAnalyst') }}</h2>
                            <p id="alert_creditAnalyst" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationCreditAnalyst" name="Reason_CreditAnalyst" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyCreditAnalyst') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityCreditAnalyst') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelCreditAnalyst" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelCreditAnalyst" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelCreditAnalyst" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><label><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelCreditAnalyst" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeCreditAnalyst') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeCreditAnalyst[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>

                          <div id="fun_internalAudit_reason" style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationInternalAudit') }}</h2>
                            <p id="alert_internalAudit" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationInternalAudit" name="Reason_InternalAudit" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyInternalAudit') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityInternalAudit') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelInternalAudit" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelInternalAudit" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelInternalAudit" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelInternalAudit" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeInternalAudit') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeInternalAudit[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>

                          <div id="fun_externalAudit_reason" style="display:none;border-top:dashed #333333" >
                            <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationExternalAudit') }}</h2>
                            <p id="alert_externalAudit" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                            <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                              <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationExternalAudit" name="Reason_ExternalAudit" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyExternalAudit') }}"></textarea>
                              <div class="col-md-6">
                                <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityExternalAudit') }}</small></h4>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelExternalAudit" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelExternalAudit" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelExternalAudit" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                                <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelExternalAudit" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                              </div>
                            </div>
                            <div>
                              <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeExternalAudit') }}</small></h4>
                              <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                                <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeExternalAudit[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>

                    <div id="functions_FandC"  style="display:none;">
                    <h3 class="fs-subtitle" style="padding-bottom:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.function') }}</h3>
                      <div class="radioinput">
                        <div class="row margintop-small marginbottom-middle">
                          <div class="col-md-4"><input type="checkbox" id="fun_financialController" name="functionFinancialController" value="Financial Controller" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.financialController') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_industrialController" name="functionIndustrialController" value="Industrial Controller" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.industrialController') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_analystFPA" name="functionAnalystFPA" value="Analyst - FP&A" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.analyst') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_consolidationReporting" name="functionConsolidationReporting" value="Consolidation - Reporting" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.consolidation') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" name="functionOther" value="Other" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add formchoicebutton candidateOtherFunctionChoice fun_Other"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</label></div>
                        </div>
                      </div>
                      <div class="radioinput">
                        <div id="fun_financialController_reason" style="display:none;border-top:dashed #333333" >
                          <p id="alert_financialController" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationFinancialController') }}</h2>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationFinancialController" name="Reason_FinancialController" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyFinancialController') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityFinancialController') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelFinancialController" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelFinancialController" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelFinancialController" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelFinancialController" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeFinancialController') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeFinancialController[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>
                        <div id="fun_industrialController_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationIndustrialController') }}</h2>
                          <p id="alert_industrialController" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationIndustrialController" name="Reason_IndustrialController" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyIndustrialController') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityIndustrialController') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelIndustrialController" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelIndustrialController" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelIndustrialController" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelIndustrialController" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeIndustrialController') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeIndustrialController[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>
                        <div id="fun_analystFPA_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationAnalyst') }}</h2>
                          <p id="alert_analystFPA" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationAnalystFPA" name="Reason_AnalystFPA" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyAnalyst') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityAnalyst') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAnalystFPA" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAnalystFPA" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAnalystFPA" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelAnalystFPA" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeAnalyst') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeAnalystFPA[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>
                        <div id="fun_consolidationReporting_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationConsolidation') }}</h2>
                          <p id="alert_consolidationReporting" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationConsolidationReporting" name="Reason_ConsolidationReporting" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyConsolidation') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityConsolidation') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelConsolidation" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelConsolidation" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelConsolidation" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelConsolidation" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeConsolidation') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeConsolidation[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div id="functions_TaxTreasury"  style="display:none;">
                    <h3 class="fs-subtitle" style="padding-bottom:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.function') }}</h3>
                      <div class="radioinput">
                        <div class="row margintop-small marginbottom-middle">
                          <div class="col-md-4"><input type="checkbox" id="fun_VATAccountant" name="functionVATAccountant" value="VAT Accountant" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.vatAccountant') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_taxAnalyst" name="functionTaxAnalyst" value="Tax Analyst" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.taxAnalyst') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" id="fun_treasuryAnalyst" name="functionTreasuryAnalyst" value="Treasury Analyst" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.treasuryAnalyst') }}</label></div>
                          <div class="col-md-4"><input type="checkbox" name="functionOther" value="Other" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add formchoicebutton candidateOtherFunctionChoice fun_Other"><label class="label-buttondesign centeralign width-big">{{ trans('partnerplatform_itwcandidatefeedback.other') }}</label></div>
                        </div>
                      </div>
                      <div class="radioinput">
                        <div id="fun_VATAccountant_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationVATAccountant') }}</h2>
                          <p id="alert_VATAccountant" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationVATAccountant" name="Reason_VATAccountant" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyVATAccountant') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityVATAccountant') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelVATAccountant" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelVATAccountant" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelVATAccountant" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelVATAccountant" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeVATAccountant') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeVATAccountant[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>

                        <div id="fun_taxAnalyst_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationTaxAnalyst') }}</h2>
                          <p id="alert_taxAnalyst" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationTaxAnalyst" name="Reason_TaxAnalyst" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyTaxAnalyst') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityTaxAnalyst') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTaxAnalyst" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTaxAnalyst" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTaxAnalyst" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTaxAnalyst" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeTaxAnalyst') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTaxAnalyst[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>

                        <div id="fun_treasuryAnalyst_reason" style="display:none;border-top:dashed #333333" >
                          <h2 class="orange">{{ trans('partnerplatform_itwcandidatefeedback.recommendationTreasuryAnalyst') }}</h2>
                          <p id="alert_treasuryAnalyst" style="display:none; border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
                          <div class="row" style="margin-bottom:1rem;margin-top:1rem;">
                            <textarea class="col-md-6 borderradius marginbottom-xsmall" rows="5" id="reasonRecommendationTreasuryAnalyst" name="Reason_TreasuryAnalyst" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whyTreasuryAnalyst') }}"></textarea>
                            <div class="col-md-6">
                              <h4 style="margin-top:-2.5rem;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.seniorityTreasuryAnalyst') }}</small></h4>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTreasuryAnalyst" value="starter" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.starter') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.starter2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTreasuryAnalyst" value="junior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.junior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.junior2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTreasuryAnalyst" value="confirmed" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.confirmed') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.confirmed2') }}</small></p></label></div>
                              <div class="col-md-3" style="margin-top:1rem;"><input type="radio" name="seniorityLevelTreasuryAnalyst" value="senior" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p><big>{{ trans('partnerplatform_itwcandidatefeedback.senior') }}</big><br/><small>{{ trans('partnerplatform_itwcandidatefeedback.senior2') }}</small></p></label></div>
                            </div>
                          </div>
                          <div>
                            <h4 style="margin:0 auto;"><small class="orange">{{ trans('partnerplatform_itwcandidatefeedback.companyTypeTreasuryAnalyst') }}</small></h4>
                            <div class="row" style="margin-top:2rem;margin-bottom:3rem;">
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="multinational" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.multinational') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="SME" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.SME') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="NGO" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.NGO') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="bank" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.bank') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="trading" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.trading') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="realestate" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.realEstate') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="fiduciary" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big"><p>{{ trans('partnerplatform_itwcandidatefeedback.fiduciary') }}</p></label></div>
                              <div class="col-md-2" style="margin-top:1rem;"><input type="checkbox" name="companyTypeTreasuryAnalyst[]" value="financial" class="buttondesign threeperline width-big confidentiality-candidatelist-button confidentiality-candidatelist-button-add"><label class="label-buttondesign centeralign width-big" style="padding:0;"><p>{{ trans('partnerplatform_itwcandidatefeedback.financial') }}</p></label></div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div>
                        <input type="text" id="functions_other" name="otherFunction" class="col-md-12 borderradius marginbottom-xsmall" style="display:none;" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.whatOtherFunction') }}"/>
                    </div>
                  </div>
                  <h3 class="aligncenter" style="margin-top:5rem;">{{ trans('partnerplatform_itwcandidatefeedback.messageCandidate') }}
                    <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.messageCandidate2') }}</small>
                  </h3>
                  <textarea name="commentsForTheCandidate" cols="40" rows="5" style="width:100%;border-radius:0.5rem;padding:0.5rem;" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.addCommentsForCandidate') }}"></textarea>
                </div>
              <h3 class="aligncenter" style="margin-top:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.addComments') }}
                <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.addComments3') }}</small>
              </h3>
              <textarea name="otherComments" cols="40" rows="7" id="candidateTietalentFeedbackOtherComments" placeholder="{{ trans('partnerplatform_itwcandidatefeedback.addComments2') }}"></textarea>
              <button type="submit" class="wp-btn-default nooutline">{{ trans('partnerplatform_itwcandidatefeedback.sendFeedback') }}</button>
            </form>
          </div>
          <div id="feedbackGiven" style="display:none;">

            <p class="alignleft" style="margin-top:3rem;">{{ trans('partnerplatform_itwcandidatefeedback.candidate') }}: <b>{{ ucfirst($candidates->firstName) }}</b></p>
            <p class="alignleft">{{ trans('partnerplatform_itwcandidatefeedback.interviewDate') }}: <b>{{ date_format(date_create($partnerInterviewFeedback->date),"l, F d Y") }}</b></p>
            <h2 class="aligncenter" style="margin-top:2rem;">{{ trans('partnerplatform_itwcandidatefeedback.findInterviewFeedbackSubmitted') }}<h2>

            <p class="centeralign">{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview2') }}</p>
            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview3') }}
              <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.howWasInterview4') }}</small>
            </h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->partnerExperienceCandidate }}</i></h4>


            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.candidatePresentation') }}
              <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.candidatePresentation2') }}</small>
            </h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->partnerCandidatePresentation }}</i></h4>


            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.candidateCommunication') }}
              <br/><small>{{ trans('partnerplatform_itwcandidatefeedback.candidateCommunication2') }}</small>
            </h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->partnerCandidateCommunication }}</i></h4>

            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.wouldYouHire') }}</h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->recommendation }}</i></h4>

            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.ifNoReasonWhy') }}</h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->reasonNoRecommendation }}</i></h4>

            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.ifYesSoftSkills') }}{{ ucfirst($candidates->firstName) }}?</h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->Reason_Personality }}</i></h4>

            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.ifYesPositions') }}{{ ucfirst($candidates->firstName) }}?</h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->function }}</i></h4>

            <h3 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.addComments') }}</h3>
            <h4 style="color:#777"><i>{{ $partnerInterviewFeedback->otherComments }}</i></h4>


          </div>
        </article>
        <article class="rightpart thanksforyourfeedback">
          <h2 class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.feedbackSent') }}<h2>
          <p class="aligncenter">{{ trans('partnerplatform_itwcandidatefeedback.feedbackSent2') }}
            <br/>
            {{ trans('partnerplatform_itwcandidatefeedback.thankYou') }}
          </p>
          <a href="candidatemainpage.php" class="wp-btn-default">{{ trans('partnerplatform_itwcandidatefeedback.backToProfile') }}</a>
        </article>
        <span class="clear">&nbsp;</span>
      </div>
      <div class="" id="navigationMobile">
        <nav role='navigation' class="" id="navigationMobileTopBar" style="position: fixed;bottom: 0px;width:100%;box-shadow:2px 2px 2px 2px #333333;z-index:100">
          <ul class="navMobile" id="navigationMobileNav" style="width:100%">
            <li><a href="/partner/candidates"><span class="textToHideMobile">{{ trans('partnerplatform_candidateDetails.candidates') }}</span><span class="iconToDisplayMobile"><i class="fa fa-users" aria-hidden="true"></i></span></a></li>
            <li><a href="/home"><span class="textToHideMobile">{{ trans('partnerplatform_candidateDetails.profile') }}</span><span class="iconToDisplayMobile"><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
            <li><a href="/partner/interviews"><span class="orange"><span class="textToHideMobile">{{ trans('partnerplatform_candidateDetails.interviews') }}</span><span class="iconToDisplayMobile"><i class="fa fa-comments" aria-hidden="true"></i></span></span></a></li>
            <li><a href="/partner/documents"><span class="textToHideMobile">{{ trans('partnerplatform_candidateDetails.documents') }}</span><span class="iconToDisplayMobile"><i class="fa fa-file" aria-hidden="true"></i></span></a></li>
            <li><a href="/partner/invitefriends"><span class="textToHideMobile">{{ trans('partnerplatform_candidateDetails.inviteFriends') }}</span><span class="iconToDisplayMobile"><i class="fa fa-user-plus" aria-hidden="true"></i></span></a></li>
          </ul>
        </nav>
      </div>
    </main>
    <footer id="footer">
      <p><big>2017 - TieTalent</big></p>

        <p class="social">
          <a href="https://www.linkedin.com/company-beta/11010661/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
        </p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="{{ asset('public/js/bootstrap.js') }}"></script>
      <script type="text/javascript" src="{{ asset('public/js/bootstrap-slider.min.js') }}"></script>
      <script src="{{ asset('public/js/partnerplatform.js') }}" type="text/javascript"></script>
      <script src="{{ asset('public/js/clients.js') }}" type="text/javascript"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQqLBvJ2mFzZNq1LpeFooWD7bREfQWMZI&libraries=places"></script>
      <script src="{{ asset('public/js/jquery.geocomplete.min.js') }}"></script>
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
