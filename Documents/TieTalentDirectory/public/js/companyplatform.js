$(document).ready(function() {  // premiere ligne de jQuery



  // companymainpage.html //

      //Notification buttons //
      $("#companyurgentnotification").on("click", function() {
        $("#companynotification-urgent").toggle()
        $("#companynotification-urgent").toggleClass("live")
        // créer une classe qui dit que l'autre est live et faire un toggleClass
      })

      $("#companynotifications").on("click", function() {
        $("#companynotification").toggle()
        $("#companynotification").toggleClass("live")
      })


      // Benefits => others input
      $("#benefits-others").change(function() {
        $(".others-benefits").toggle()
        $(".others-benefits").toggleClass("live")
      })




      // companynewvacancyform

      //jQuery time
      var current_fs, next_fs, previous_fs; //fieldsets
      var left, opacity, scale; //fieldset properties which we will animate
      var animating; //flag to prevent quick multi-click glitches

      $(".next").click(function(){
      	if(animating) return false;
      	animating = true;

      	current_fs = $(this).parent();
      	next_fs = $(this).parent().next();
        $('html, body').animate({scrollTop: $("#companyregistrationform h1").offset().top}, 400);

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      	//show the next fieldset
      	next_fs.show();
      	//hide the current fieldset with style
      	current_fs.animate({opacity: 0}, {
      		step: function(now, mx) {
      			//as the opacity of current_fs reduces to 0 - stored in "now"
      			//1. scale current_fs down to 80%
      			scale = 1 - (1 - now) * 0.2;
      			//2. bring next_fs from the right(50%)
      			left = (now * 50)+"%";
      			//3. increase opacity of next_fs to 1 as it moves in
      			opacity = 1 - now;
      			current_fs.css({'transform': 'scale('+scale+')'});
      			next_fs.css({'left': left, 'opacity': opacity});
      		},
      		duration: 800,
      		complete: function(){
      			current_fs.hide();
      			animating = false;
      		},
      		//this comes from the custom easing plugin
      		easing: 'easeInOutBack'
      	});
      });

      $(".previous").click(function(){
      	if(animating) return false;
      	animating = true;

      	current_fs = $(this).parent();
      	previous_fs = $(this).parent().prev();
        $('html, body').animate({scrollTop: $("#companyregistrationform h1").offset().top}, 400);

      	//de-activate current step on progressbar
      	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      	//show the previous fieldset
      	previous_fs.show();
      	//hide the current fieldset with style
      	current_fs.animate({opacity: 0}, {
      		step: function(now, mx) {
      			//as the opacity of current_fs reduces to 0 - stored in "now"
      			//1. scale previous_fs from 80% to 100%
      			scale = 0.8 + (1 - now) * 0.2;
      			//2. take current_fs to the right(50%) - from 0%
      			left = ((1-now) * 50)+"%";
      			//3. increase opacity of previous_fs to 1 as it moves in
      			opacity = 1 - now;
      			current_fs.css({'left': left});
      			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
      		},
      		duration: 800,
      		complete: function(){
      			current_fs.hide();
      			animating = false;
      		},
      		//this comes from the custom easing plugin
      		easing: 'easeInOutBack'
      	});
      });

      $(".submit").click(function(){
      	return false;
      })




      // Registration form : add the selected class to the checked input

      // Company type
      $("#companyType input").click(function () {
        $(this).addClass('selected');
        $("#companyType input").not(this).removeClass('selected');
        //show the Vacancy Address search input departments if "Other" is selected
        if($("#companyOtherTypeChoice").hasClass("selected")){
            $("#companyOtherType").show();
          }
        else {
          $("#companyOtherType").hide();
        }
        });

      // Office role
      $("#officeRole input").click(function () {
        $(this).addClass('selected');
        $("#officeRole input").not(this).removeClass('selected');

        if($("#officeOtherRoleChoice").hasClass("selected")){
            $("#officeOtherRole").show();
          }
        else {
          $("#officeOtherRole").hide();
        }
        });

      // Departments in the office

        $("#officeOtherDepartmentChoice").click(function() {
            $("#officeOtherDepartment").toggle();
          });

      // Vacancy to fill => display the departments to choose
      $("#vacancyToFill input").click(function () {
        $(this).addClass('selected');
        $("#vacancyToFill input").not(this).removeClass('selected');

        if($("#vacancyToFillYes").hasClass("selected")){
            $("#vacancyToFill_Departments").show();
          }
        else {
          $("#vacancyToFill_Departments").hide();
        }
        });


    // Vacancy to fill in another department
    $("#vacancyOtherDepartmentChoice").click(function() {
        $("#vacancyOtherDepartment").toggle();
      });


// candidate registration form - alerts (messages) to display if input not filled
$("#companyRegistrationFormSubmit").click(function() {
  // alert for company type
  if($("input:radio[name=companyType]").not(":checked")) {
    $("#alert_companyType").css("display", "");
   }
  if($("input:radio[name=companyType]").is(":checked")) {
    $("#alert_companyType").css("display", "none");
   }

  // alert for HQ address
  if($("#companyHQ").val().length < 4) {
    $("#alert_HQAddress").css("display", "");
   }
  if($("#companyHQ").val().length > 3) {
    $("#alert_HQAddress").css("display", "none");
   }

  // alert for candidate office address
  if($("#officeAddress").val().length < 4) {
    $("#alert_OfficeAddress").css("display", "");
    //$( "#partnerRegistrationFormPreviousButton" ).click();
   }
  if($("#officeAddress").val().length > 3) {
    $("#alert_OfficeAddress").css("display", "none");
   }

})

// Vacancy address
$("#companyVacancyAddress input").click(function () {
  $(this).addClass('selected');
  $("#companyVacancyAddress input").not(this).removeClass('selected');

        //show the Vacancy Address search input departments if "Other" is selected
        if($("#companyOtherAddress").hasClass("selected")){
            $("#companyOtherAddress-search").show();
          }
        else {
          $("#companyOtherAddress-search").hide();
        }

        });


  // Line Manager
  $("#company-LineManager input").click(function () {
    $(this).addClass('selected');
    $("#company-LineManager input").not(this).removeClass('selected');

          //show the line manager details input if "Other" is selected
          if($(".otherLineManager").hasClass("selected")){
              $("#companyOtherLineManager").show();
            }
          else {
            $("#companyOtherLineManager").hide();
          }

          });



      // Instantiate a slider

          //Availability bar
            var mySlider = $("input#company-vacancy-startDate").slider();
          //Mobility bar
            var mySlider = $("input#companyBudget").slider();

          //Occupation rate
            var mySlider = $("input#occupationRate").slider();

      // Availability slider value

          $("input#company-vacancy-startDate").on("slide", function (slideEvt) {

            if(slideEvt.value == 1) {
              slideEvt.value = ("I need someone available immediately");
            }

            else if (slideEvt.value == 2) {
              slideEvt.value = ("+/- 15 days");
            }

            else if (slideEvt.value == 3) {
              slideEvt.value = ("1 month");
            }

            else if (slideEvt.value == 4) {
              slideEvt.value = ("2 months");
            }

            else if (slideEvt.value == 5) {
              slideEvt.value = ("3 months");
            }

            else if (slideEvt.value == 6) {
              slideEvt.value = ("3+ months");
            }

            $(".availability").text(slideEvt.value);

          });


          // Budget slider value
          $("input#companyBudget").slider({
	           tooltip: 'always'
           });

              $("input#companyBudget").on("slide", function (slideEvt) {

                if(slideEvt.value == 150000) {
                  slideEvt.value = ("More than 150'000");
                }


                $(".budget").text(slideEvt.value);

              });


          // Occupation rate

          $("input#occupationRate").on("slide", function (slideEvt) {

            if(slideEvt.value == 0) {
              slideEvt.value = ("10%");
            }

            else if (slideEvt.value == 1) {
              slideEvt.value = ("20%");
            }

            else if (slideEvt.value == 2) {
              slideEvt.value = ("30%");
            }

            else if (slideEvt.value == 3) {
              slideEvt.value = ("40%");
            }

            else if (slideEvt.value == 4) {
              slideEvt.value = ("50%");
            }

            else if (slideEvt.value == 5) {
              slideEvt.value = ("60%");
            }

            else if (slideEvt.value == 6) {
              slideEvt.value = ("70%");
            }

            else if (slideEvt.value == 7) {
              slideEvt.value = ("80%");
            }

            else if (slideEvt.value == 8) {
              slideEvt.value = ("90%");
            }

            else if (slideEvt.value == 9) {
              slideEvt.value = ("100%");
            }

            $(".partTime").text(slideEvt.value);

          });


       //  Position address
       // HQ address
       $("input#companyHQ").geocomplete();

       // Trigger geocoding request.
       $("button.find").click(function(){
         $("input#companyHQ").trigger("geocode");
       });

       //Office address
       $("input#officeAddress").geocomplete();

       // Trigger geocoding request.
       $("button.find").click(function(){
         $("input#officeAddress").trigger("geocode");
       });

       $("input#positionAddress").geocomplete();

       // Trigger geocoding request.
       $("button.find").click(function(){
         $("input#positionAddress").trigger("geocode");
       });




       // Candidate CV uploads

       function readURL(input) {
      if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
          $('.image-upload-wrap').hide();

          $('.file-upload-image').attr('src', e.target.result);
          $('.file-upload-content').show();

          $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

      } else {
        removeUpload();
      }
    }

    function removeUpload() {
      $('.file-upload-input').replaceWith($('.file-upload-input').clone());
      $('.file-upload-content').hide();
      $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
    		$('.image-upload-wrap').addClass('image-dropping');
    	});
    	$('.image-upload-wrap').bind('dragleave', function () {
    		$('.image-upload-wrap').removeClass('image-dropping');
    });


    // Add language skills requirement for the position
    $('.addlanguage-2').on("click", function() {
      $(".vacancy-language-2").css("display", "block")
    })

    $('.addlanguage-3').on("click", function() {
      $(".vacancy-language-3").css("display", "block")
    })
    $('.deletelanguage-2').on("click", function() {
      $(".vacancy-language-2").css("display", "none")
    })

    $('.addlanguage-4').on("click", function() {
      $(".vacancy-language-4").css("display", "block")
    })
    $('.deletelanguage-3').on("click", function() {
      $(".vacancy-language-3").css("display", "none")
    })


    $('.deletelanguage-4').on("click", function() {
      $(".vacancy-language-4").css("display", "none")
    })





// companyplatformfeedback.html

    $(".telluswhatyouthink a").click(function() {
      $(".telluswhatyouthink").css("display", "none");
      $(".thanksforyourfeedback").css("display", "block");
    })



// companyaccountsettings.html
// Company update choice slider value

//Initiate bar
  var mySlider = $("input#companyUpdateChoice").slider();

    $("input#companyUpdateChoice").on("slide", function (slideEvt) {

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


    //display subcategories on click
      //communication
      $(".settings-element-communication-button").on("click", function() {
          $(".settings-element-communication").toggle()
        })

      //email
      $(".settings-element-email-button").on("click", function() {
          $(".settings-element-email").toggle()
        })

      $(".add-newcompanyemail-button").on("click", function() {
          $(".add-newcompanyemail").toggle()
        })

      //phone
      $(".settings-element-phone-button").on("click", function() {
          $(".settings-element-phone").toggle()
        })

      $(".add-newcompanyphone-button").on("click", function() {
          $(".add-newcompanyphone").toggle()
        })

      //Skype
      $(".settings-element-skype-button").on("click", function() {
          $(".settings-element-skype").toggle()
        })

      $(".add-newcompanyskype-button").on("click", function() {
          $(".add-newcompanyskype").toggle()
        })

      //password
      $(".settings-element-password-button").on("click", function() {
          $(".settings-element-password").toggle()
        })

      //general information
      $(".settings-element-generalinfo-button").on("click", function() {
          $(".settings-element-generalinfo").toggle()
        })

      //language
      $(".settings-element-language-button").on("click", function() {
          $(".settings-element-language").toggle()
        })



    // newvacancyform


    // Division
    $("#vacancyDivision input").click(function () {
      $(this).addClass('selected');
      $("#vacancyDivision input").not(this).removeClass('selected');

            //show the Finance & accounting departments if "Finance & Accounting" is selected
            if($("#FandADivisionChoice").hasClass("selected")) {
                $("#DepartmentFandA").show();
              }
            else {
              $("#DepartmentFandA").hide();
              }

            //show the other division input bar if "Other" is selected
            if($("#OtherDivisionChoice").hasClass("selected")) {
                $("#OtherDivision").show();
                $("#FunctionsFandA").hide();
              }
            else {
              $("#OtherDivision").hide();
              $("#FunctionsFandA").show();
              }
            });

    // Department
    // Finance and Accounting department
    $("#DepartmentFandA input").click(function () {
      $(this).addClass('selected');
      $("#DepartmentFandA input").not(this).removeClass('selected');
      $("#salaryExpectations").show();

            //show the Accounting functions if "Accounting" is selected
            if($("#AccountingDepartmentChoice").hasClass("selected") && $("#FandADivisionChoice").hasClass("selected")) {
                $("#FunctionAccounting").show();
              }
            else {
              $("#FunctionAccounting").hide();
              }

            //show the Finance & Controlling functions if "Finance & Controlling" is selected
            if($("#FandCDepartmentChoice").hasClass("selected")) {
                $("#FunctionFandC").show();
              }
            else {
              $("#FunctionFandC").hide();
              }

            //show the Tax & Treasury functions if "Tax & Treasury" is selected
            if($("#TaxandTreasuryDepartmentChoice").hasClass("selected")) {
                $("#FunctionTaxandTreasury").show();
              }
            else {
              $("#FunctionTaxandTreasury").hide();
              }

            //show the other department input bar if "Other" is selected
            if($("#FandAOtherDepartmentChoice").hasClass("selected")) {
                $("#FandAOtherDepartment").show();
              }
            else {
              $("#FandAOtherDepartment").hide();
              }
            });

   // Function
      // Finance & Accounting department
          $("#FunctionsFandA input").click(function () {
            $(this).addClass('selected');
            $("#FunctionsFandA input").not(this).removeClass('selected');

            if($(".candidateOtherFunctionChoice").hasClass("selected")) {
                $("#OtherFunction").show();
              }
            else {
              $("#OtherFunction").hide();
              }
          });




  // Vacancies->VacancyDetails->candidateDetails

  $('#addInterviewer2').on("click", function() {
    $("#interviewer2").css("display", "")
  })
  $('#addInterviewer3').on("click", function() {
    $("#interviewer3").css("display", "")
  })
  $('#addInterviewer4').on("click", function() {
    $("#interviewer4").css("display", "")
  })


  // ask a candidate for interview
  $("#phoneInterview").on("click", function() {
    $("#phoneInterviewDetails").show();
    $("#f2fInterviewDetails").hide();
    $("#skypeInterviewDetails").hide();
  })

  $("#f2fInterview").on("click", function() {
    $("#phoneInterviewDetails").hide();
    $("#f2fInterviewDetails").show();
    $("#skypeInterviewDetails").hide();
  })

  $("#skypeInterview").on("click", function() {
    $("#phoneInterviewDetails").hide();
    $("#f2fInterviewDetails").hide();
    $("#skypeInterviewDetails").show();
  })



    // candidate details laguage skills

        // french
    if($("#candidateLanguageSkills:contains('french')").length) {
      $("#candidateFrenchLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('french/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('french/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsFrench").html("French - Basic - not tested by our partner");
    }

        // english
    if($("#candidateLanguageSkills:contains('english')").length) {
      $("#candidateEnglishLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('english/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('english/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsEnglish").html("English - Basic - not tested by our partner");
    }


        // german
    if($("#candidateLanguageSkills:contains('german')").length) {
      $("#candidateGermanLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('german/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('german/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsGerman").html("German - Basic - not tested by our partner");
    }

        // spanish
    if($("#candidateLanguageSkills:contains('spanish')").length) {
      $("#candidateSpanishLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('spanish/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('spanish/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsSpanish").html("Spanish - Basic - not tested by our partner");
    }


        // italian
    if($("#candidateLanguageSkills:contains('italian')").length) {
      $("#candidateItalianLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('italian/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('italian/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsItalian").html("Italian - Basic - not tested by our partner");
    }

        // portuguese
    if($("#candidateLanguageSkills:contains('portuguese')").length) {
      $("#candidatePortugueseLangaugeSkills").css("display", "");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£mother tongue/€tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Mother tongue - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£mother tongue/€not tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Mother tongue - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£fluent/€tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Fluent - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£fluent/€not tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Fluent - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£good level/€tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Good level - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£good level/€not tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Good level - not tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£basic/€tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Basic - tested by our partner");
    }
    if($("#candidateLanguageSkills:contains('portuguese/£basic/€not tested')").length) {
      $("#candidateLangaugeSkillsPortuguese").html("Portuguese - Basic - not tested by our partner");
    }




    // Candidate IT Skills

      // SAP
      if($("#candidateLanguageSkills:contains('SAP')").length) {
        $("#candidateSAPITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('SAP/£work')").length) {
        $("#candidateITSkillsSAP").html("SAP - used at work");
      }
      if($("#candidateITSkills:contains('SAP/£class')").length) {
        $("#candidateITSkillsSAP").html("SAP - learned in class");
      }

      // Oracle
      if($("#candidateLanguageSkills:contains('Oracle')").length) {
        $("#candidateOracleITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('Oracle/£work')").length) {
        $("#candidateITSkillsOracle").html("Oracle - used at work");
      }
      if($("#candidateITSkills:contains('Oracle/£class')").length) {
        $("#candidateITSkillsOracle").html("Oracle - learned in class");
      }

      // Sage
      if($("#candidateLanguageSkills:contains('Sage')").length) {
        $("#candidateSageITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('Sage/£work')").length) {
        $("#candidateITSkillsSAP").html("Sage - used at work");
      }
      if($("#candidateITSkills:contains('Sage/£class')").length) {
        $("#candidateITSkillsSage").html("Sage - learned in class");
      }

      // AS400
      if($("#candidateLanguageSkills:contains('AS400')").length) {
        $("#candidateAS400ITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('AS400/£work')").length) {
        $("#candidateITSkillsAS400").html("AS400 - used at work");
      }
      if($("#candidateITSkills:contains('AS400/£class')").length) {
        $("#candidateITSkillsAS400").html("AS400 - learned in class");
      }

      // Abacus
      if($("#candidateLanguageSkills:contains('Abacus')").length) {
        $("#candidateAbacusITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('Abacus/£work')").length) {
        $("#candidateITSkillsAbacus").html("Abacus - used at work");
      }
      if($("#candidateITSkills:contains('Abacus/£class')").length) {
        $("#candidateITSkillsAbacus").html("Abacus - learned in class");
      }

      // Dynamics
      if($("#candidateLanguageSkills:contains('Dynamics')").length) {
        $("#candidateDynamicsITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('Dynamics/£work')").length) {
        $("#candidateITSkillsDynamics").html("Dynamics - used at work");
      }
      if($("#candidateITSkills:contains('Dynamics/£class')").length) {
        $("#candidateITSkillsDynamics").html("Dynamics - learned in class");
      }

      // ProConcept
      if($("#candidateLanguageSkills:contains('ProConcept')").length) {
        $("#candidateProConceptITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('ProConcept/£work')").length) {
        $("#candidateITSkillsProConcept").html("ProConcept - used at work");
      }
      if($("#candidateITSkills:contains('ProConcept/£class')").length) {
        $("#candidateITSkillsProConcept").html("ProConcept - learned in class");
      }

      // Excel
      if($("#candidateITSkills:contains('Excel')").length) {
        $("#candidateExcelITSkills").css("display", "");
      }
      if($("#candidateITSkills:contains('Excel/£work')").length) {
        $("#candidateITSkillsExcel").html("Excel - used at work");
      }
      if($("#candidateITSkills:contains('Excel/£class')").length) {
        $("#candidateITSkillsExcel").html("Excel - learned in class");
      }



  // candidateInterviewFeedback
  $("#forwardChoice input").click(function () {
    $(this).addClass('selected');
    $("#forwardChoice input").not(this).removeClass('selected');

          //Depending on the choice, show the right tabs (if the company wants to go forward with the candidate or not)
          if($("#goForward").hasClass("selected")) {
              $("#goForward_tab").show();
            }
          else {
            $("#goForward_tab").hide();
            }

          if($("#noGoForward").hasClass("selected")) {
              $("#noGoForward_tab").show();
            }
          else {
            $("#noGoForward_tab").hide();
            }

  });



  $("#vacancyNextStep input").click(function () {
    $(this).addClass('selected');
    $("#vacancyNextStep input").not(this).removeClass('selected');

          //Depending on the choice, show the right tabs (if the company wants to go forward with the candidate or not)
          if($("#vacancyNextStep_offer").hasClass("selected")) {
              $("#offerToCandidate").show();
            }
          else {
            $("#offerToCandidate").hide();
            }

          if($("#vacancyNextStep_interview").hasClass("selected")) {
              $("#newInterviewRound").show();
            }
          else {
            $("#newInterviewRound").hide();
            }

          if($("#vacancyNextStep_other").hasClass("selected")) {
              $("#TemporaryEndDate").show();
            }
          else {
            $("#TemporaryEndDate").hide();
            }

  });



  $("#contractTypeOffer input").click(function () {
    $(this).addClass('selected');
    $("#contractTypeOffer input").not(this).removeClass('selected');

          //Depending on the choice, show the right tabs (if the company wants to go forward with the candidate or not)
          if($("#contractTypeOffer_tryhire").hasClass("selected")) {
              $("#THEndDate").show();
            }
          else {
            $("#THEndDate").hide();
            }

          if($("#contractTypeOffer_temporary").hasClass("selected")) {
              $("#TemporaryEndDate").show();
            }
          else {
            $("#TemporaryEndDate").hide();
            }

  });




  // Selection of the reason why the company doesn't want to go forward with this candidate
  $("#foundSomeoneButton").click(function() {
    $("#foundSomeone").prop("checked", "checked");
    $("#foundSomeoneButton").css("color", "#F14904");
    $("#experiencesNotInLine").prop("checked", "");
    $("#experiencesNotInLineButton").css("color", "#333333");
    $("#disappointingInterview").prop("checked", "");
    $("#disappointingInterviewButton").css("color", "#333333");
    $("#other").prop("checked", "");
    $("#otherButton").css("color", "#333333");
  })

  $("#experiencesNotInLineButton").click(function() {
    $("#experiencesNotInLine").prop("checked", "checked");
    $("#experiencesNotInLineButton").css("color", "#F14904");
    $("#foundSomeone").prop("checked", "");
    $("#foundSomeoneButton").css("color", "#333333");
    $("#disappointingInterview").prop("checked", "");
    $("#disappointingInterviewButton").css("color", "#333333");
    $("#other").prop("checked", "");
    $("#otherButton").css("color", "#333333");
  })

  $("#disappointingInterviewButton").click(function() {
    $("#disappointingInterview").prop("checked", "checked");
    $("#disappointingInterviewButton").css("color", "#F14904");
    $("#foundSomeone").prop("checked", "");
    $("#foundSomeoneButton").css("color", "#333333");
    $("#experiencesNotInLine").prop("checked", "");
    $("#experiencesNotInLineButton").css("color", "#333333");
    $("#other").prop("checked", "");
    $("#otherButton").css("color", "#333333");
  })

  $("#otherButton").click(function() {
    $("#other").prop("checked", "checked");
    $("#otherButton").css("color", "#F14904");
    $("#foundSomeone").prop("checked", "");
    $("#foundSomeoneButton").css("color", "#333333");
    $("#experiencesNotInLine").prop("checked", "");
    $("#experiencesNotInLineButton").css("color", "#333333");
    $("#disappointingInterview").prop("checked", "");
    $("#disappointingInterviewButton").css("color", "#333333");
  })

















  }); // fermeture de jQuery


  var element =  document.getElementById('vacancyAddress');
  if (typeof(element) != 'undefined' && element != null)
  {
    window.onload = function calcRoute() {
      var directionsService = new google.maps.DirectionsService();
      var directionsDisplay = new google.maps.DirectionsRenderer();
          var start = document.getElementById("vacancyAddress").innerHTML;
          var end = document.getElementById("candidateAddress").innerHTML;

          var distanceInput = document.getElementById("distance");

          var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
          };

          directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
              directionsDisplay.setDirections(response);
              distanceInput.innerHTML = (response.routes[0].legs[0].duration.value/60).toFixed(1);
            }
          });
        }
  }
