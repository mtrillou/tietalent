

$(document).ready(function() {  // premiere ligne de jQuery



// Make menu appear on click for responsive
(function($) {

var $event = $.event,
  $special,
  resizeTimeout;

$special = $event.special.debouncedresize = {
  setup: function() {
    $( this ).on( "resize", $special.handler );
  },
  teardown: function() {
    $( this ).off( "resize", $special.handler );
  },
  handler: function( event, execAsap ) {
    // Save the context
    var context = this,
      args = arguments,
      dispatch = function() {
        // set correct event type
        event.type = "debouncedresize";
        $event.dispatch.apply( context, args );
      };

    if ( resizeTimeout ) {
      clearTimeout( resizeTimeout );
    }

    execAsap ?
      dispatch() :
      resizeTimeout = setTimeout( dispatch, $special.threshold );
  },
  threshold: 150
};

})(jQuery);


// END debouncedresize


// resize logic

var ww = $(window).width();               // window width
var bpo = 860;                            // breaking point
var tot = $('.topbar .toggle');           // topbar toggle button
var ddl = $('.topbar .dropdown ul');      // dropdown list
var nav = $('.nav');                      // root ul navigation
var ddt = $('.topbar .dropdown > a');     // dropdown trigger

// toggle topbar
tot.click(function(ev){
  ev.preventDefault();
  nav.slideToggle()
});

// if mobile
if(!!('ontouchstart' in window)){
  clickOn();
} else {
  $(window).on("debouncedresize", function(event){
    ww = $(window).width(); // reset ww
    if (ww > bpo) {
      clickOff();
    } else {
      clickOn();
    };
  });
};

function clickOn() {
  nav.hide();
  ddl.css('display', 'none');
  tot.next().css('display', 'none');

  var ev = $._data(ddt[0], 'events');
  if (ev && ev.click) {
    // click already bounded do nothing
  } else {
    ddt.click(function(ev){
      ev.preventDefault();
      $(this).next().slideToggle();
      $(this).parent().siblings().children().next().slideUp();
      return false;
    });
  }
  return false;
}

function clickOff() {
  nav.show();
  ddl.removeAttr('style');
  ddt.off('click');
  return false;
}


// Scroll down effect

  $(function() {
    $('a[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top
          }, 800);
          return false;
        }
      }
    });
  });


// Return to top arrow
// ===== Scroll to Top ====
$(window).scroll(function() {
    if ($(this).scrollTop() >= 200) {        // If page is scrolled more than 200px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});




// Form - mise en couleur des champs mal remplis


// candidate Email

$("#candidateEmail").blur(function(){

  // Regex email
  var candidateEmailInput = $("#candidateEmail").val();
  var pattcandidateEmail = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/igm;
  var rescandidateEmail = pattcandidateEmail.test(candidateEmailInput);


  if(rescandidateEmail == false) {
    document.getElementById("button_candidate_mail").type="";
    $("#candidateEmail").css("border", "1px solid red");
    document.getElementById("alert_candidate").style.display="";
  }
  else {
    document.getElementById("button_candidate_mail").type="submit";
    document.getElementById("button_candidate_mail").click();
  }
  });


  // company Email

  $("#clientEmail").blur(function(){

    // Regex email
    var clientEmailInput = $("#clientEmail").val();
    var pattclientEmail = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/igm;
    var resclientEmail = pattclientEmail.test(clientEmailInput);

    // Regex input classical email addresses
    var pattClassicalEmailProviders = /^hotmail|gmail|bluemail|yahoo|aol|outlook|googlemail/igm;
    var resEmailProviders = pattClassicalEmailProviders.test(clientEmailInput);


    if(resclientEmail == false || resEmailProviders == true) {
      document.getElementById("button_company_mail").type="";
      $("#clientEmail").css("border", "1px solid red");
      document.getElementById("alert_company").style.display="";
    }
    else {
      document.getElementById("button_company_mail").type="submit";
      document.getElementById("button_company_mail").click();
    }
    });

  // partner Email

  $("#partnerEmail").blur(function(){

    // Regex email
    var partnerEmailInput = $("#partnerEmail").val();
    var pattpartnerEmail = /^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/igm;
    var respartnerEmail = pattpartnerEmail.test(partnerEmailInput);


    if(respartnerEmail == false) {
      document.getElementById("button_partner_mail").type="";
      $("#partnerEmail").css("border", "1px solid red");
      document.getElementById("alert_partner").style.display="";
    }
    else {
      document.getElementById("button_partner_mail").type="submit";
      document.getElementById("button_partner_mail").click();
    }
    });


  // Phone

  $("input#clientPhone").blur(function(){

    // Regex email
    var clientPhoneInput = $("input#clientPhone").val();
    var pattclientPhone = /([0]{1})([1-9]{1})*[-. (]*(([0-9]{2})[. ]?){4}|(\+)([3]{2})*[-. (]*([1-9]{1})*[-. (]*(([0-9]{2})[. ]?){4}|([0]{2})*[-. (]*([3]{2})*[-. (]*([1-9]{1})*[-. (]*(([0-9]{2})[. ]?){4}/igm;
    var resclientPhone = pattclientPhone.test(clientPhoneInput);

    // Phone check
    if(resclientPhone == false) {
      $("input#clientPhone").css("border", "1px solid red");
    }
    else {
      $("input#clientPhone").css("border", "none");
    }
   })




   // FAQ (animations)

$('.faq-element').on('click touchstart', function(){

  $('.faq-element').removeClass('faq-element--active');
  $(this).addClass('faq-element--active');

});

  // $('body').delegate('.faq-element', 'click', function(){

  //   $('.faq-element').removeClass('faq-element--active');
  //   $(this).addClass('faq-element--active');

//});


  // Language selection at the footer

  $(".language").change(function(){

    document.getElementById("language-selection-submit").click();

  });

  $(".fa-globe").click(function(){
    $(".displayLanguage").show();
    $(".fa-globe").hide();
  });



  // Company platform

  // home

  if ( $('#about').text().length > 0 ) {
    $('#companyAbout').hide();
    $('#about_save').hide();
    $('#about_update').show();
    }
  else{
    $('#companyAbout').show();
    $('#about_save').show();
  };

  $("#about_update").click(function(){
    $('#companyAbout').show();
    $('#about_save').show();
    $('#about_update').hide();
    $('#about').hide();
  });

  if ( $('#values').text().length > 0 ) {
    $('#companyCoreValues').hide();
    $('#values_save').hide();
    $('#values_update').show();
    }
  else{
    $('#companyCoreValues').show();
    $('#values_save').show();
  };

  $("#values_update").click(function(){
    $('#companyCoreValues').show();
    $('#values_save').show();
    $('#values_update').hide();
    $('#values').hide();
  });



  // Account Settings

  //display subcategories on click
    //communication
    $("#settings-element-communication-button").on("click", function() {
        $(".settings-element-communication").toggle()
      })

    //email
    $("#settings-element-email-button").on("click", function() {
        $(".settings-element-email").toggle()
      })

    //phone
    $("#settings-element-phone-button").on("click", function() {
        $(".settings-element-phone").toggle()
      })

    $(".add-newcandidatephone-button").on("click", function() {
        $(".add-newcandidatephone").toggle()
      })

    //Skype
    $("#settings-element-skype-button").on("click", function() {
        $(".settings-element-skype").toggle()
      })

    //password
    $("#settings-element-password-button").on("click", function() {
        $(".settings-element-password").toggle()
      })

    //general information
    $("#settings-element-generalinfo-button").on("click", function() {
        $(".settings-element-generalinfo").toggle()
      })

    //language
    $("#settings-element-language-button").on("click", function() {
        $(".settings-element-language").toggle()
      })


  //Initiate bar
    var mySlider = $("#companyUpdateChoice").slider();

      $("#companyUpdateChoice").on("slide", function (slideEvt) {

        if(slideEvt.value == 1) {
          slideEvt.value = ("Never");
        }

        else if (slideEvt.value == 2) {
          slideEvt.value = ("Only when it's about market trends");
        }

        else if (slideEvt.value == 3) {
          slideEvt.value = ("Monthly updates");
        }

        else if (slideEvt.value == 4) {
          slideEvt.value = ("Weekly updates");
        }

        else if (slideEvt.value == 5) {
          slideEvt.value = ("Everytime there is something new");
        }

        $(".settings-element-communication .updateChoice").text(slideEvt.value);

      });

      if($("#company_communicationPreferences").text() === '1') {
        $("#company_communicationPreferencesChoice").text("Never");
      }
      if($("#company_communicationPreferences").text() === '2') {
        $("#company_communicationPreferencesChoice").text("Only when it's about market trends");
      }
      if($("#company_communicationPreferences").text() === '3') {
        $("#company_communicationPreferencesChoice").text("Monthly updates");
      }
      if($("#company_communicationPreferences").text() === '4') {
        $("#company_communicationPreferencesChoice").text("Weekly updates");
      }
      if($("#company_communicationPreferences").text() === '5') {
        $("#company_communicationPreferencesChoice").text("Everytime there is something new");
      }


      // user information

      $('#generalCompanyUser_edit').click(function() {
        $('.general_information').hide();
        $('.general_information_update').show();
        $('#generalCompanyUser_save').show();
        $('#generalCompanyUser_edit').hide();
      });


      // company information

      $('#generalCompanyInformation_edit').click(function() {
        $('.general_information').hide();
        $('.general_information_update').show();
        $('#generalCompanyInformation_save').show();
        $('#generalCompanyInformation_edit').hide();
      });

      $('#officeOtherDepartment_select').change(function() {
        if($('#officeOtherDepartment_select').val() === 'Yes'){
          $('#officeOtherDepartment').show();
        }
        else {
          $('#officeOtherDepartment').hide();
        }
      });


  //Skype
  if ($('#skypeCompany1').text().length > 10 ) {
    $('#skypeCompany_save').hide();
    $('#skypeCompany1').show();
    $('#skypeCompany_update').show();
    $('#skypeCompany_input').hide();
    }
  else{
    $('#skypeCompany1').hide();
    $('#skypeCompany_save').show();

  };

  $("#skypeCompany_update").click(function(){
    $('#skypeCompany_input').show();
    $('#skypeCompany_save').show();
    $('#skypeCompany1').hide();
  });


  // Password
  $('#passwordCompanyInputs input').keyup(function() {
  if ($('#passwordCompany').val() === $('#passwordCompany_confirmation').val() ) {
    $('#passwordCompany_save').attr('type', 'submit');
  }
  else {
    $('#passwordCompany_save').attr('type', '');
    }
  });

  // General
  $('#general_edit').click(function() {
    $('.general_information').hide();
    $('.general_information_update').show();
    $('#general_save').show();
    $('#general_edit').hide();
  });

  //  Company HQ address

  $("input#companyHQ").geocomplete();

  // Trigger geocoding request.
  $("button.find").click(function(){
    $("input#companyHQ").trigger("geocode");
  });

  //  Company address

  $("input#officeAddress").geocomplete();

  // Trigger geocoding request.
  $("button.find").click(function(){
    $("input#officeAddress").trigger("geocode");
  });


  // Company vacancies

  if($("#candidateSelectionByPartner:contains('candidate selected by the partner')").length) {
    $("#noCandidateFoundSoFar").hide();
    $("#candidateFound").show();
  }
  else {
    $("#noCandidateFoundSoFar").show();
    $("#candidateFound").hide();
  }

  $("#showRecruitmentCriteria").on("click", function() {
      $("#recruitmentCriteria").toggle()
    })

  $("#closeOpportunity").on("click", function() {
      $("#confirmCloseOpportunity").show();
      $("#closeOpportunity").hide();
      $("#showRecruitmentCriteria").hide();
    })

  $("#goBackCloseOpportunity").on("click", function() {
     $("#closeOpportunity").show();
     $("#showRecruitmentCriteria").show();
     $("#confirmCloseOpportunity").hide();
   })

  if($("#vacancyStage").text() == 1 || $("#vacancyStage").text() == 2){
    $("#selectionStage").addClass("active");
    $("#selectionStageDiv").css("display","block");
  }
  if($("#vacancyStage").text() == 3){
    $("#selectionStage").addClass("active");
    $("#interviewStage").addClass("active");
    $("#interviewStageDiv").css("display","block");
  }
  if($("#vacancyStage").text() == 4){
    $("#selectionStage").addClass("active");
    $("#interviewStage").addClass("active");
    $("#offerStage").addClass("active");
    $("#offerStageDiv").css("display","block");
    $("#offerMade").css("display","block");
  }
  if($("#vacancyStage").text() == 6){
    $('.rightpart').hide();
    $("#offerAccepted").css("display","block");
  }


  if($("#vacancyStatut").text() == 2){
    $("#closeOpportunity").hide();
    $("#deleteOpportunity").css("display","block");
  }

  $("#deleteOpportunity").on("click", function() {
      $("#confirmDeleteOpportunity").show();
      $("#deleteOpportunity").hide();
      $("#showRecruitmentCriteria").hide();
    })

  $("#goBackDeleteOpportunity").on("click", function() {
     $("#deleteOpportunity").show();
     $("#showRecruitmentCriteria").show();
     $("#confirmDeleteOpportunity").hide();
   })




  //les box qui présentent les candidats révèlent les infos au hover
    $('.box').hover(function() {
    $(this).toggleClass('selected');
    });


  // Company interviews
  // Check if any interview is planned
  if($(".interviewStage:contains('4')").length) {

    $(".companyinterview-nointerview").hide();
    $("#interviewsPlanned").show();
  }
  else {
    $(".companyinterview-nointerview").show();
    $("#interviewsPlanned").hide();
  }

  // show past interviews
  $("#showPastinterviews").on("click", function() {
      $("#passedInterviews").toggle()
    })




// SeeReference

if($("#workLength:contains('starter')").length) {
    $("#workLengthStarter").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workLength:contains('junior')").length) {
    $("#workLengthJunior").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workLength:contains('confirmed')").length) {
    $("#workLengthConfirmed").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workLength:contains('senior')").length) {
    $("#workLengthSenior").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#integration:contains('sufficient')").length) {
    $("#integrationSufficient").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#integration:contains('good')").length && $("#integration:not(:contains('very good'))").length) {
    $("#integrationGood").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#integration:contains('very good')").length) {
    $("#integrationVeryGood").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#integration:contains('excellent')").length) {
    $("#integrationExcellent").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workQuality:contains('sufficient')").length) {
    $("#workQualitySufficient").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workQuality:contains('good')").length) {
    $("#workQualityGood").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workQuality:contains('very good')").length) {
    $("#workQualityVeryGood").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#workQuality:contains('excellent')").length) {
    $("#workQualityExcellent").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#hireAgain:contains('yes')").length) {
    $("#hireAgainYes").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }

if($("#hireAgain:contains('no')").length) {
    $("#hireAgainNo").css({
     'background-color' : "#333333",
     'color' : "#F14904",
     'border' : "2px solid #27AE60"
   });
  }


}); // fermeture de jQuery


// update profile picture

// Document uploads

function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.file-upload').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();
      $('#documentDetails').show();
      $('.document-title').html(input.files[0].name.substring(0, 100) + "...");
      $('.image-title').html(input.files[0].name.substring(0, 15) + "...");
      document.getElementById('submitProfilePicture').click();
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}
