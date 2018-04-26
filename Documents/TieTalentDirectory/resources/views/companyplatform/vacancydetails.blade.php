

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title>{{ trans('companyplatform_vacancydetails.pagetitle') }}</title>
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
          <li><a href="#">{{ trans('companyplatform_candidateDetails.settings') }} <i class="fa fa-angle-down orange" aria-hidden="true"></i></a>
            <ul>
              <li><a href="/company/settings">{{ trans('companyplatform_candidateDetails.account') }}</a></li>
              <li><a href="/company/faq">{{ trans('companyplatform_candidateDetails.faq') }}</a></li>
              <li><a href="/company/feedback">{{ trans('companyplatform_candidateDetails.feedback') }}</a></li>
              <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('companyplatform_candidateDetails.logout') }}</a></li>
            </ul>
          </li>
          <li class="paddingtop-zero" id="recruitButton"><a href="/company/newvacancyform" id="buttonRecruit" class="wp-btn-default width-full padding-small centeralign">{{ trans('companyplatform_candidateDetails.recruit') }}</a></li>
        </ul>
      </nav>
    </div>
    <main>
      <div id="companymainpage">
        <aside class="leftpart">
          <h1><a href="/home"><img class="profile-picture-circle" src="{{ asset('public/uploads/avatars') }}/{{ $companies->avatar }}" height="100px" width="100px"></a></h1>
          <ul>
            <li><a href="/home">{{ trans('companyplatform_candidateDetails.profile') }}</a></li>
            <li><a href="/company/newvacancyform">{{ trans('companyplatform_candidateDetails.recruit') }}</a></li>
            <li><a href="/company/vacancies" class="orange">{{ trans('companyplatform_candidateDetails.vacancies') }}</a></li>
            <li><a href="/company/interviews">{{ trans('companyplatform_candidateDetails.interviews') }}</a></li>
            <li><a href="/company/invitefriends">{{ trans('companyplatform_candidateDetails.inviteFriends') }}</a></li>
          </ul>
        </aside>
        <article class="rightpart alignleft">
          <h2 class="aligncenter">{{ $companyVacancies->function }}<br/><small>{{ $companyVacancies->division }}</small></h2>
          <p id="vacancyStage" style="display:none;">{{ $companyVacancies->vacancyStage }}</p>
          <p id="vacancyStatut" style="display:none;">{{ $companyVacancies->vacancyStatut }}</p>
          <p id="candidateSelectionByPartner" style="display:none;">
            @foreach ($partnerInterviewFeedback as $partnerFeedback)
              @foreach ($candidates as $candidate)
                @foreach ($candidateDetails as $candidateDetail)
                  @if($partnerFeedback->candidate_id_user === $candidate->id_user)
                    @if($candidateDetail->id_user === $candidate->id_user)
                      candidate selected by the partner {{ $candidate->id_user }}
                    @endif
                  @endif
                @endforeach
              @endforeach
            @endforeach
          </p>

          <ul id="progressbarVacancy">
            <li class=" centeralign" id="selectionStage">{{ trans('companyplatform_vacancydetails.selection') }}</li>
            <li class=" centeralign" id="interviewStage">{{ trans('companyplatform_vacancydetails.interviews') }}</li>
            <li class=" centeralign" id="offerStage">{{ trans('companyplatform_vacancydetails.offer') }}</li>
          </ul>

          <div class="margintop-middle centeralign" id="selectionStageDiv" style="display:none;">
            <h4>{{ trans('companyplatform_vacancydetails.partnerSelection') }}:</h4>
            <div id="noCandidateFoundSoFar" class="row">
              <img class="reason" src="{{ asset('public/img/storm.svg') }}" alt="quick" title="quick" width="80px"/>
              <h2 style="color:#F14904;width:50%;">Search in progress
                <br/><small>Our team just got informed about your hiring need. We will get back to you within 24 hours.</small>
              </h2>
            </div>

            <div id="candidateFound">

                Received candidates
              <div style="height:20rem;" class="row">


                @foreach($linkedCandidateVacancy as $linkedCandidate)
                  @foreach($candidates as $candidate)
                    @foreach($candidateDetailsAll as $candidateDetail)
                      @if($candidateDetail->id_user === $candidate->id_user && $candidate->id_user === $linkedCandidate->candidateIdUser)
                      <form  action="/company/seeLinkedCandidates" method="post" enctype="multipart/form-data" style="width:30%;">
                        {{ csrf_field() }}
                        <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                        <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                        <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                        <button onclick="$('#seeCandidateDetails{{ $candidate->id }}').trigger( 'click' )" class="col-md-4 box first nooutline noborder" style="width:auto;">
                          <span class="icon-cont"><img class="" src="{{ asset('public/uploads/avatars') }}/{{ $candidate->avatar }}" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
                          <h2>{{ $candidate->firstName }}</h2>
                          <ul class="hidden">
                            <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.livingIn') }}{{ $candidateDetail->address }}</li>
                            <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.salaryExpectationsOf') }}CHF {{ number_format($candidateDetail->salaryExpectations, 0, ',', "'") }}</li>
                            <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.availability') }}: {{ $candidateDetail->availability }}</li>
                          </ul>
                        </button>
                        <input type="submit" id="seeCandidateDetails{{ $candidate->id }}" name="" value="" style="display:none;">
                      </form>
                      @endif
                    @endforeach
                  @endforeach
                @endforeach
              </div>


              <!--
              Other candidates
              <div style="height:20rem;" class="row">



              @foreach ($partnerInterviewFeedback as $partnerFeedback)
                @foreach ($candidates as $candidate)
                  @foreach ($candidateDetails as $candidateDetail)
                    @if($partnerFeedback->candidate_id_user === $candidate->id_user)
                      @if($candidateDetail->id_user === $candidate->id_user)






                          <form  action="/company/seeCandidates" method="post" enctype="multipart/form-data" style="width:30%;">
                            {{ csrf_field() }}
                            <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                            <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                            <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                            <button onclick="$('#seeCandidateDetails{{ $candidate->id }}').trigger( 'click' )" class="col-md-4 box first nooutline noborder" style="width:auto;">
                              <span class="icon-cont"><img class="" src="{{ asset('public/uploads/avatars') }}/{{ $candidate->avatar }}" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
                              <h2>{{ $candidate->firstName }}</h2>
                              <ul class="hidden">
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.livingIn') }}{{ $candidateDetail->address }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.salaryExpectationsOf') }}CHF {{ number_format($candidateDetail->salaryExpectations, 0, ',', "'") }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.availability') }}: {{ $candidateDetail->availability }}</li>
                              </ul>
                            </button>
                            <input type="submit" id="seeCandidateDetails{{ $candidate->id }}" name="" value="" style="display:none;">
                          </form>


                      @endif
                    @endif
                  @endforeach
                @endforeach
              @endforeach


            </div>
          -->

          <!--
            <h4>{{ trans('companyplatform_vacancydetails.candidatesContacted') }}:</h4>
            <div style="height:20rem;" class="row">



              @foreach ($partnerInterviewFeedback as $partnerFeedback)
                @foreach ($candidates as $candidate)
                  @foreach ($candidateDetails as $candidateDetail)
                    @if($partnerFeedback->candidate_id_user === $candidate->id_user)
                      @if($candidateDetail->id_user === $candidate->id_user)
                      @foreach($companyInterviews as $companyInterview)
                      @if($companyInterview->statut > 1 && $companyInterview->candidate_id_user === $candidate->id_user)




                          <form  action="/company/seeCandidates" method="post" enctype="multipart/form-data" style="width:30%;">
                            {{ csrf_field() }}
                            <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                            <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                            <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                            <button onclick="$('#seeCandidateDetails{{ $candidate->id }}').trigger( 'click' )" class="col-md-4 box first nooutline noborder" style="width:auto;">
                              <span class="icon-cont"><img class="" src="{{ asset('public/uploads/avatars') }}/{{ $candidate->avatar }}" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
                              <h2>{{ $candidate->firstName }}</h2>
                              <ul class="hidden">
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.livingIn') }}{{ $candidateDetail->address }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.salaryExpectationsOf') }}CHF {{ number_format($candidateDetail->salaryExpectations, 0, ',', "'") }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.availability') }}: {{ $candidateDetail->availability }}</li>
                              </ul>
                            </button>
                            <input type="submit" id="seeCandidateDetails{{ $candidate->id }}" name="" value="" style="display:none;">
                          </form>

                          @endif
                          @endforeach
                      @endif
                    @endif
                  @endforeach
                @endforeach
              @endforeach

            </div>
          -->

          </div>





          </div>

          <div class="margintop-middle centeralign" id="interviewStageDiv" style="display:none;">
            <h4 class="orange">{{ trans('companyplatform_vacancydetails.interviewsPlanned') }}:
              <br/><small>{{ trans('companyplatform_vacancydetails.interviewsPlanned2') }}</small>
            </h4>

            @foreach ($companyInterviews as $companyInterview)
              @foreach ($candidates as $candidate)
                @if($candidate->id_user === $companyInterview->candidate_id_user && $companyInterview->statut === '4')
                <div class="settings-element row">
                  <h5 class="alignleft"><big class="color-dark">{{ date_format(date_create($companyInterview->date),"l, F d Y") }} at {{ date_format(date_create($companyInterview->time),"G:i") }}</big></h5>
                  <form class="" action="/company/seeCandidates" method="post">
                    {{ csrf_field() }}
                    <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                    <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                    <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                    <h5 class="pointerCursor"><a onclick="$('#submitSeeCandidate{{ $candidate->id }}').trigger( 'click' )" ><big class="color-dark">{{ ucfirst($candidate->firstName) }}</big></a></h5>
                    <input type="submit" id="submitSeeCandidate{{ $candidate->id }}" name="" value="" style="display:none;">
                  </form>
                </div>

                <span class="greylign"></span>
                @endif
              @endforeach
            @endforeach

            <h4 class="margintop-big">{{ trans('companyplatform_vacancydetails.interviewsPassed') }}:</h4>

            @foreach ($companyInterviews as $companyInterview)
              @foreach ($candidates as $candidate)
                @if($candidate->id_user === $companyInterview->candidate_id_user && ($companyInterview->statut === '6' || $companyInterview->statut === '7' || $companyInterview->statut === '8' || $companyInterview->statut === '9'))

                  <div class="paddingtop-small row" style="margin-top:0rem;">
                    <span class="col-md-4">{{ date_format(date_create($companyInterview->date),"l, F d Y") }}</span>
                    <span class="col-md-4">
                      <form class="" action="/company/seeCandidates" method="post">
                        {{ csrf_field() }}
                        <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                        <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                        <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                        <h5 class="pointerCursor"><a onclick="$('#submitSeeCandidate{{ $candidate->id }}').trigger( 'click' )" ><big class="color-dark">{{ ucfirst($candidate->firstName) }}</big></a></h5>
                        <input type="submit" id="submitSeeCandidate{{ $candidate->id }}" name="" value="" style="display:none;">
                      </form>
                    </span>
                    <span class="col-md-4">
                      <form class="" action="/company/candidateInterviewFeedback" method="post">
                        {{ csrf_field() }}
                        <input name="candidate_id_user" type="hidden" value="{{ $candidate->id_user }}">
                        <button class="nooutline" style="padding:0.2rem;border:1px solid #F14904;border-radius:0.5rem;background-color:white;">{{ trans('companyplatform_vacancydetails.feedback') }}</button>
                      </form>
                    </span>
                  </div>

                @endif
              @endforeach
            @endforeach





            <h4 class="orange margintop-big">{{ trans('companyplatform_vacancydetails.otherRecommendedCandidates') }}:</h4>
            <div class="margintop-middle centeralign" id="" >

              @foreach ($partnerInterviewFeedback as $partnerFeedback)
                @foreach ($candidates as $candidate)
                  @foreach ($candidateDetails as $candidateDetail)
                    @if($partnerFeedback->candidate_id_user === $candidate->id_user)
                      @if($candidateDetail->id_user === $candidate->id_user)
                        @foreach($companyInterviews as $companyInterview)
                        @if($companyInterview->statut > 1 && $companyInterview->candidate_id_user !== $candidate->id_user)



                          <form  action="/company/seeCandidates" method="post" enctype="multipart/form-data" style="width:30%;">
                            {{ csrf_field() }}
                            <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                            <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                            <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                            <button onclick="$('#seeCandidateDetails{{ $candidate->id }}').trigger( 'click' )" class="box first nooutline noborder">
                              <span class="icon-cont"><img class="" src="{{ asset('public/uploads/avatars') }}/{{ $candidate->avatar }}" height="65px" width="65px" style="border-radius:2rem;margin-top:-1px;margin-left:-1px;"></span>
                              <h2>{{ $candidate->firstName }}</h2>
                              <ul class="hidden">
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.livingIn') }}{{ $candidateDetail->address }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.salaryExpectationsOf') }}CHF {{ number_format($candidateDetail->salaryExpectations, 0, ',', "'") }}</li>
                                <li onmouseover="this.style.color='white'">{{ trans('companyplatform_vacancydetails.availability') }}: {{ $candidateDetail->availability }}</li>
                              </ul>
                            </button>
                            <input type="submit" id="seeCandidateDetails{{ $candidate->id }}" name="" value="" style="display:none;">
                          </form>

                          @endif
                          @endforeach
                      @endif
                    @endif
                  @endforeach
                @endforeach
              @endforeach

            </div>


          </div>

          <div class="margintop-middle centeralign" id="offerStageDiv" style="display:none;">
            <div id="offerMade" style="display:none;">
              <h4>{{ trans('companyplatform_vacancydetails.offerMadeToCandidate') }}
                <br/><small>{{ trans('companyplatform_vacancydetails.offerMadeToCandidate2') }}</small>
              </h4>
            <!--  @foreach ($companyInterviewFeedback as $feedback)
                @foreach ($companyInterviews as $companyInterview)
                @foreach ($candidates as $candidate)
                  @if($companyInterview->id == $feedback->companyInterviews_id && ($feedback->nextStep === '3'))

                      <p>{{ $candidate->firstName }}</p>

                  @endif
                @endforeach
                @endforeach
              @endforeach

            -->


            </div>

          </div>





          <span class="clear">&nbsp;</span>

          <div class="row">
            <button id="showRecruitmentCriteria" class="wp-btn-default saveclick nooutline centeralign" style="width:25%;background-color:#F14904;color:white;margin-top:5rem;margin-left:3.6%;" >{{ trans('companyplatform_vacancydetails.showRecruitmentCriteria') }}</button>
            <button id="closeOpportunity" name="button" class="wp-btn-default saveclick nooutline centeralign" style="margin-top:5rem;width:25%;background-color:#333333">Close this opportunity</button>
            <button id="deleteOpportunity" name="button" class="wp-btn-default saveclick nooutline centeralign" style="margin-top:5rem;width:25%;background-color:#333333">Delete this opportunity</button>
          </div>

          <div id="confirmCloseOpportunity" style="display:none;">
            <h2 class="centeralign">Are you sure you want to close this opportunity?</h2>
            <div class="row" style="margin-top:0rem;">
              <button id="goBackCloseOpportunity" class="wp-btn-default saveclick nooutline centeralign" style="width:25%;background-color:#F14904;color:white;margin-top:1rem;margin-left:3.6%;" >Go back</button>
              <form action="/company/closeOpportunity" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="companyVacancyId" type="hidden" value="{{ $companyVacancies->id }}">
                <button name="button" class="wp-btn-default saveclick nooutline centeralign" style="margin-top:1rem;width:100%;background-color:#333333">Yes</button>
              </form>
            </div>
          </div>

          <div id="confirmDeleteOpportunity" style="display:none;">
            <h2 class="centeralign">Are you sure you want to delete this opportunity?</h2>
            <div class="row" style="margin-top:0rem;">
              <button id="goBackDeleteOpportunity" class="wp-btn-default saveclick nooutline centeralign" style="width:25%;background-color:#F14904;color:white;margin-top:1rem;margin-left:3.6%;" >Go back</button>
              <form action="/company/deleteOpportunity" method="post" style="width:25%;">
                {{ csrf_field() }}
                <input name="companyVacancyId" type="hidden" value="{{ $companyVacancies->id }}">
                <button name="button" class="wp-btn-default saveclick nooutline centeralign" style="margin-top:1rem;width:100%;background-color:#333333">Yes</button>
              </form>
            </div>
          </div>

          <span class="clear">&nbsp;</span>
          <div id="recruitmentCriteria" style="display:none;">
            <h2 class="centeralign margintop-middle">{{ trans('companyplatform_vacancydetails.searchCriteria') }}</h2>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.division') }}
              <br/><small>{{ $companyVacancies->division }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.location') }}
              <br/><small>{{ $companyVacancies->address }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.department') }}
              <br/><small>{{ $companyVacancies->department }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.seniorityLevel') }}
              <br/><small>{{ ucfirst($companyVacancies->seniorityLevelStarter) }}</small>
              <br/><small>{{ ucfirst($companyVacancies->seniorityLevelJunior) }}</small>
              <br/><small>{{ ucfirst($companyVacancies->seniorityLevelConfirmed) }}</small>
              <br/><small>{{ ucfirst($companyVacancies->seniorityLevelSenior) }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.function') }}
              <br/><small>{{ $companyVacancies->function }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.languageSkills') }}
              <br/><small>{{ ucfirst($companyVacancies->language1) }} - {{ $companyVacancies->language1Level }} - {{ $companyVacancies->language1Statut }}</small>
              <br/><small>{{ ucfirst($companyVacancies->language2) }} - {{ $companyVacancies->language2Level }} - {{ $companyVacancies->language2Statut }}</small>
              <br/><small>{{ ucfirst($companyVacancies->language3) }} - {{ $companyVacancies->language3Level }} - {{ $companyVacancies->language3Statut }}</small>
              <br/><small>{{ ucfirst($companyVacancies->language4) }} - {{ $companyVacancies->language4Level }} - {{ $companyVacancies->language4Statut }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.startDate') }}
              <br/><small>{{ $companyVacancies->startDate }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.contractType') }}
              <br/><small>{{ ucfirst($companyVacancies->contractType) }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.context') }}
              <br/><small>{{ ucfirst($companyVacancies->context) }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.budget') }}
              <br/><small>CHF {{ number_format($companyVacancies->budget, 0, ',', "'") }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.workPermit') }}
              <br/><small>{{ $companyVacancies->visaSponsor }}</small>
            </h4>
            <h4 class="orange col-md-6 centeralign">{{ trans('companyplatform_vacancydetails.lineManager') }}
              <br/><small>{{ $companyVacancies->division }}</small>
            </h4>

            <h4><small>{{ $companyVacancies->jobDescriptionText }}</small></h4>

            <form action="/downloadCompany/{{ $companyVacancies->jobDescriptionFileName }}" style="display:inline" method="post">
              {{ csrf_field() }}
              <input name="company_id_user" type="hidden" value="{{ $companyVacancies->id_user }}">
              <a class="wp-btn-default marginbottom-middle noblueborder centeralign" style="margin-top:1rem;background-color:#333333" onclick="$('#CVHello').trigger( 'click' )" >{{ trans('candidateplatform_opportunities.downloadJobDescription') }}</a>
              <input type="submit" id="CVHello" name="" value="" style="display:none;">
            </form>

            <form action="/company/editVacancy" style="display:inline" method="post">
              {{ csrf_field() }}
              <input name="vacancy_id" type="hidden" value="{{ $companyVacancies->id }}">
              <input name="id_user" type="hidden" value="{{ $companyVacancies->id_user }}">
              <input name="division" type="hidden" value="{{ $companyVacancies->division }}">
              <input name="address" type="hidden" value="{{ $companyVacancies->address }}">
              <input name="department" type="hidden" value="{{ $companyVacancies->department }}">
              <input name="seniorityLevelStarter" type="hidden" value="{{ $companyVacancies->seniorityLevelStarter }}">
              <input name="seniorityLevelJunior" type="hidden" value="{{ $companyVacancies->seniorityLevelJunior }}">
              <input name="seniorityLevelConfirmed" type="hidden" value="{{ $companyVacancies->seniorityLevelConfirmed }}">
              <input name="seniorityLevelSenior" type="hidden" value="{{ $companyVacancies->seniorityLevelSenior }}">
              <input name="function" type="hidden" value="{{ $companyVacancies->function }}">

              <button id="changeOpportunity" name="button" class="wp-btn-default saveclick nooutline centeralign" style="margin-top:5rem;width:25%;background-color:#333333">Change criterias</button>
            </form>
          </div>

        </article>
        <div id="offerAccepted" style="display:none;width:80%;padding-top:4rem;">
          <div style="padding:2rem;border-radius:2rem;margin:5rem;background-color:rgba(241,241,241,0.8)">
            @foreach ($companyInterviews as $companyInterview)
              @foreach ($candidates as $candidate)
                @if($candidate->id_user === $companyInterview->candidate_id_user && ($companyInterview->statut === '7'))
                <h2 class="margintop-middle" style="color:black;margin-top:1rem;">
                  <form action="/company/seeCandidates" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input name="candidate_id" type="hidden" value="{{ $candidate->id }}">
                  <input name="companyVacancy" type="hidden" value="{{ $companyVacancies->id }}">
                  <input name="vacancyFunction" type="hidden" value="{{ $companyVacancies->function }}">
                  <big>{{ trans('companyplatform_vacancydetails.congrats') }}<a href="#" onclick="$('#seeCandidateDetails{{ $candidate->id }}').trigger( 'click' )" class="">{{ ucfirst($candidate->firstName) }}</a> {{ trans('companyplatform_vacancydetails.congrats2') }}</big>
                  <input type="submit" id="seeCandidateDetails{{ $candidate->id }}" name="" value="" style="display:none;">
                </form>
                  <br/><small>{{ ucfirst($candidate->firstName) }} {{ trans('companyplatform_vacancydetails.congrats3') }}
                  <br/>{{ trans('companyplatform_vacancydetails.congrats4') }}</small>
                </h2>
                <div class="alignleft">
                  <p style="color:black;margin-bottom:0;"><big><b>{{ trans('companyplatform_vacancydetails.position') }}: </b></big></p>
                  <h4 class="orange" style="margin-top:0;margin-left:3rem;">{{ $companyVacancies->function }}</h4>

                  <p style="color:black;margin-bottom:0;"><big><b>{{ trans('companyplatform_vacancydetails.contractType') }}: </b></big></p>
                  <h4 class="orange" style="margin-top:0;margin-left:3rem;">{{ ucfirst($companyVacancies->offerContractType) }}</h4>

                  <p style="color:black;margin-bottom:0;"><big><b>{{ trans('companyplatform_vacancydetails.startDate') }}: </b></big></p>
                  <h4 class="orange" style="margin-top:0;margin-left:3rem;">{{ date_format(date_create($companyVacancies->offerStartDate),"l, F d Y") }}</h4>

                  <p style="color:black;margin-bottom:0;"><big><b>{{ trans('companyplatform_vacancydetails.salary') }}: </b></big></p>
                  <h4 class="orange" style="margin-top:0;margin-left:3rem;">CHF {{ number_format($companyVacancies->offerSalary, 0, ',', "'") }} / {{ trans('companyplatform_vacancydetails.year') }}</h4>
                  @endif
                @endforeach
              @endforeach

            </div>



        </div>
        <span class="clear">&nbsp;</span>
      </div>
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
    <script src="{{ asset('public/js/clients.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/companyplatform.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQqLBvJ2mFzZNq1LpeFooWD7bREfQWMZI&libraries=places"></script>
    <script src="{{ asset('public/js/jquery.geocomplete.min.js') }}"></script>
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
