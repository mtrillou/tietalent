$(document).ready(function() {  // premiere ligne de jQuery

  // language selection at the footer
  $(".language").change(function(){

    document.getElementById("language-selection-submit").click();

  });

  // partner registration form - alerts (messages) to display if input not filled
  $("#partnerRegistrationFormSubmit").click(function() {
    // alert for partner department specialization
    if($("input:radio[name=departmentSpecialization]").not(":checked")) {
      $("#alert_partnerDepartment").css("display", "");
     }
    if($("input:radio[name=departmentSpecialization]").is(":checked")) {
      $("#alert_partnerDepartment").css("display", "none");
     }

    // alert for partner company type
    if($("input:radio[name=companyType]").not(":checked")) {
      $("#alert_partnerCompanyType").css("display", "");
     }
    if($("input:radio[name=companyType]").is(":checked")) {
      $("#alert_partnerCompanyType").css("display", "none");
     }

    // alert for partner address
    if($("#partnerAddress").val().length < 4) {
      $("#alert_partnerAddress").css("display", "");
     }
    if($("#partnerAddress").val().length > 3) {
      $("#alert_partnerAddress").css("display", "none");
     }

    // alert for partner internet access
    if($("input:radio[name=internetAccess]").not(":checked")) {
      $("#alert_partnerInternetAccess").css("display", "");
     }
    if($("input:radio[name=internetAccess]").is(":checked")) {
      $("#alert_partnerInternetAccess").css("display", "none");
     }

  })




  // partnerplatformfeedback.html

      $(".telluswhatyouthink a").click(function() {
        $(".telluswhatyouthink").css("display", "none");
        $(".thanksforyourfeedback").css("display", "block");
      })


      // partneraccountsettings.html
      // Company update choice slider value

      //Initiate bar
        var mySlider = $("input#candidateUpdateChoice").slider();

          $("input#candidateUpdateChoice").on("slide", function (slideEvt) {

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

          if($("#partner_communicationPreferences").text() === '1') {
            $("#partner_communicationPreferencesChoice").text("Never");
          }
          if($("#partner_communicationPreferences").text() === '2') {
            $("#partner_communicationPreferencesChoice").text("Only when it's about market trends");
          }
          if($("#partner_communicationPreferences").text() === '3') {
            $("#partner_communicationPreferencesChoice").text("Monthly updates");
          }
          if($("#partner_communicationPreferences").text() === '4') {
            $("#partner_communicationPreferencesChoice").text("Weekly updates");
          }
          if($("#partner_communicationPreferences").text() === '5') {
            $("#partner_communicationPreferencesChoice").text("Everytime there is something new");
          }


          //display subcategories on click
            //communication
            $(".settings-element-communication-button").on("click", function() {
                $(".settings-element-communication").toggle()
              })

            //email
            $(".settings-element-email-button").on("click", function() {
                $(".settings-element-email").toggle()
              })

            $(".add-newcandidateemail-button").on("click", function() {
                $(".add-newcandidateemail").toggle()
              })

            //phone
            $(".settings-element-phone-button").on("click", function() {
                $(".settings-element-phone").toggle()
              })

            $(".add-newcandidatephone-button").on("click", function() {
                $(".add-newcandidatephone").toggle()
              })

            //Skype
            $(".settings-element-skype-button").on("click", function() {
                $(".settings-element-skype").toggle()
              })

            $(".add-newcandidateskype-button").on("click", function() {
                $(".add-newcandidateskype").toggle()
              })

            //password
            $(".settings-element-password-button").on("click", function() {
                $(".settings-element-password").toggle()
              })

            //general
            $(".settings-element-generalinfo-button").on("click", function() {
                $(".settings-element-generalinfo").toggle()
              })

            //language
            $(".settings-element-language-button").on("click", function() {
                $(".settings-element-language").toggle()
              })



    // partnerseecandidates-profile.html
    $('.datepicker').pickadate({
      min: true,
      format: 'mmmm d yyyy',
      formatSubmit: 'yyyy-mm-dd',
      hiddenSuffix: '',
    });
    $('.timepicker').pickatime({
      min: [7,00],
      max: [21,00],
      format: 'H:i',
    })

      //Ask for interview messages display
      $(".partner-askforinterview-button").click(function() {
        $(".partner-askforinterview").css("display", "block");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      })

      if($("#statut").text() === '1' || $("#statut").text() === '13') {
        $(".partner-askforinterview-button").css("display", "");
        $("#partner-notavailable-button").css("display", "inline");
        $(".partnerInterviewTimePropositions").css("display", "none");
      };

      if($("#statut").text() === '2') {
        $(".partnerInterviewTimePropositions").css("display", "none");
        $(".partner-waitingforinterviewconf").css("display", "block");
        $(".partner-askforinterview").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      };

      if($("#statut").text() === '3') {
        $(".partnerInterviewTimePropositions").css("display", "");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partner-askforinterview").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      };

      $(".changeItwRequest").click(function() {
        $(".partner-askforinterview").css("display", "block");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partnerInterviewTimePropositions").css("display", "none");
      })

      if($("#statut").text() === '4') {
        $(".partnerInterviewTimePropositions").css("display", "none");
        $(".partner-interviewconfirmed").css("display", "block");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      };

      // Selection of the interview time and date
      $("#proposition4button").click(function() {
        $("#proposition4").prop("checked", "checked");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition4button").css("color", "#F14904");
        $("#proposition5button").css("color", "#333333");
        $("#proposition6button").css("color", "#333333");
        $("#proposition5").prop("checked", "");
        $("#proposition6").prop("checked", "");
      })
      $("#proposition5button").click(function() {
        $("#proposition4").prop("checked", "");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition4button").css("color", "#333333");
        $("#proposition5button").css("color", "#F14904");
        $("#proposition6button").css("color", "#333333");
        $("#proposition5").prop("checked", "checked");
        $("#proposition6").prop("checked", "");
      })
      $("#proposition6button").click(function() {
        $("#proposition4").prop("checked", "");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition4button").css("color", "#333333");
        $("#proposition5button").css("color", "#333333");
        $("#proposition6button").css("color", "#F14904");
        $("#proposition5").prop("checked", "");
        $("#proposition6").prop("checked", "checked");
      })



      //Ask for interview messages display -> companies tab
      $(".partner-askforinterview-button").click(function() {
        $(".partner-askforinterview").css("display", "block");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      })

      if($("#interviewStatut").text() === '1') {
        $(".partner-askforinterview-button").css("display", "");
        $(".setUpAnInterview").css("display", "");
        $(".partnerInterviewTimePropositions").css("display", "none");
        $("#partner-notavailable-button").css("display", "");
      };

      if($("#interviewStatut").text() === '2') {
        $(".partnerInterviewTimePropositions").css("display", "none");
        $(".partner-waitingforinterviewconf").css("display", "block");
        $(".partner-askforinterview").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      };

      if($("#interviewStatut").text() === '3') {
        $(".partnerInterviewTimePropositions").css("display", "");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partner-askforinterview").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $("#partner-notavailable-button").css("display", "none");
      };

      $(".changeItwRequest").click(function() {
        $(".partner-askforinterview").css("display", "block");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partnerInterviewTimePropositions").css("display", "none");
      })

      if($("#interviewStatut").text() === '4') {
        $(".partnerInterviewTimePropositions").css("display", "none");
        $(".partner-interviewconfirmed").css("display", "block");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
      };

      if($("#interviewStatut").text() === '5') {
        $(".partnerInterviewTimePropositions").css("display", "none");
        $(".partner-interviewconfirmed").css("display", "none");
        $(".partner-waitingforinterviewconf").css("display", "none");
        $(".partner-askforinterview-button").css("display", "none");
        $(".candidateNotInterested").css("display", "");
        $(".partner-notavailable-button").css("display", "");
      };



  // candidate did not show up button

  $(".candidateDidNotShowUpButton").click(function() {
    $(".candidateDidNotShowUpConfirm").show();
    $(".candidateDidNotShowUpButton").hide();
    $(".giveFeedbackOnCandidateInterview").hide();
  })

  $(".candidateDidNotShowUpGoBack").click(function() {
    $(".candidateDidNotShowUpButton").show();
    $(".candidateDidNotShowUpConfirm").hide();
    $(".giveFeedbackOnCandidateInterview").show();
  })


      //Add to calendar function
            if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
            if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
                var h = d[g]('body')[0];h.appendChild(s); }


    // Feedback after the interview with the candidate form

    $("#hiringChoice input").click(function () {
      $(this).addClass('selected');
      $("#hiringChoice input").not(this).removeClass('selected');

            //Depending on the choice, show the right tabs (if candidate recommended or not)
            if($("#recommended").hasClass("selected")) {
                $("#recommended_tab").show();
                $("#dpt_accounting").prop('required',true);
                $("#dpt_FandC").prop('required',true);
                $("#dpt_TaxTreasury").prop('required',true);
                $("#dpt_other").prop('required',true);
                $("#reasonRecommendationPersonality").prop('required',true);
                $("#commentsForTheCandidate").prop('required',true);
              }
            else {
              $("#recommended_tab").hide();
              $("#dpt_accounting").prop('required',false);
              $("#dpt_FandC").prop('required',false);
              $("#dpt_TaxTreasury").prop('required',false);
              $("#dpt_other").prop('required',false);
              $("#reasonRecommendationPersonality").prop('required',false);
              $("#commentsForTheCandidate").prop('required',false);
              }

            if($("#notRecommended").hasClass("selected")) {
                $("#notRecommended_tab").show();
                $("#reasonNoRecommendation").prop('required',true);
              }
            else {
              $("#notRecommended_tab").hide();
              $("#reasonNoRecommendation").prop('required',false);
              }

    });


    // Regex to count number of words used to explain the reason of the recommendation

    $("#reasonRecommendationAccountsPayable").blur(function(){

      // Regex count the number of words
      var reasonRecommendationAccountsPayable = $("#reasonRecommendationAccountsPayable").val();
      var pattReasonRecommendationAccountsPayable = /^\s*\S+(?:\s+\S+){29,}\s*$/igm;
      var resReasonRecommendationAccountsPayable = pattReasonRecommendationAccountsPayable.test(reasonRecommendationAccountsPayable);


      if(resReasonRecommendationAccountsPayable == false) {
        $("#reasonRecommendationAccountsPayable").css("border", "1px solid red");
        document.getElementById("alert_accountsPayable").style.display="";
      }
      else {
        document.getElementById("alert_accountsPayable").style.display="none";
        $("#reasonRecommendationAccountsPayable").css("border", "1px solid #333333");
      }
      });






        // Company Type
      /* $("#candidateCompanyTypeChoice input").click(function () {
          $(this).addClass('selected');
          $("#candidateCompanyTypeChoice input").not(this).removeClass('selected');

                //show the other company type input bar if "Other" is selected
                if($("#candidateOtherCompanyTypeChoice").hasClass("selected")) {
                    $("#candidateOtherCompanyType").show();
                  }
                else {
                  $("#candidateOtherCompanyType").hide();
                  }
                });

                */

        // Division
      /*  $("#candidateDivisionChoice input").click(function () {
          $(this).addClass('selected');
          $("#candidateDivisionChoice input").not(this).removeClass('selected');

                //show the Finance & accounting departments if "Finance & Accounting" is selected
                if($("#candidateFandADivisionChoice").hasClass("selected") && $("#candidateMultinationalechoice").hasClass("selected")) {
                    $("#departmentFandA").show();
                  }
                else {
                  $("#departmentFandA").hide();
                  }

                //show the other division input bar if "Other" is selected
                if($("#candidateOtherDivisionChoice").hasClass("selected")) {
                    $("#candidateOtherDivision").show();
                    $("#candidateFunctionsFandA").hide();
                  }
                else {
                  $("#candidateOtherDivision").hide();
                  $("#candidateFunctionsFandA").show();
                  }
                });
    */
        // Department
        // Finance and Accounting department
        $("#departmentFandA input").click(function () {
          $(this).addClass('selected');
          $("#departmentFandA input").not(this).removeClass('selected');

                //show the Accounting functions if "Accounting" is selected
                if($("#dpt_accounting").hasClass("selected")) {
                    $("#functions_accounting").show();
                  }
                else {
                  $("#functions_accounting").hide();
                  }

                //show the Finance & Controlling functions if "Finance & Controlling" is selected
                if($("#dpt_FandC").hasClass("selected")) {
                    $("#functions_FandC").show();
                  }
                else {
                  $("#functions_FandC").hide();
                  }

                //show the Tax & Treasury functions if "Tax & Treasury" is selected
                if($("#dpt_TaxTreasury").hasClass("selected")) {
                    $("#functions_TaxTreasury").show();
                  }
                else {
                  $("#functions_TaxTreasury").hide();
                  }

                //show the other department input bar if "Other" is selected
                if($("#dpt_other").hasClass("selected")) {
                    $("#dpt_other_dpt").show();
                    $("#functions_other").show();
                  }
                else {
                  $("#dpt_other_dpt").hide();
                  $("#functions_other").hide();
                  }
                });

       // Function
          // Reasons to recommend the candidate
              $("#fun_accountsPayable").click(function () {
                  $('#fun_accountsPayable_reason').toggle();
                  $("#fun_accountsPayable").toggleClass("selected");
                  if($("#fun_accountsPayable").hasClass( "selected" )){
                    $("#reasonAccountsPayable").prop('required',true);
                    $("#seniorityLevelAccountsPayable").prop('required',true);
                    $("input:checkbox[name='companyTypeAccountsPayable[]']").prop('required',true);
                    var requiredCheckboxes = $('#fun_accountsPayable_reason input:checkbox[required]');
                      requiredCheckboxes.change(function(){
                          if(requiredCheckboxes.is(':checked')) {
                              requiredCheckboxes.removeAttr('required');
                          } else {
                              requiredCheckboxes.attr('required', 'required');
                          }
                      });
                  }

                  if(!$("#fun_accountsPayable").hasClass( "selected" )){
                    $("#reasonAccountsPayable").prop('required',false);
                    $("#seniorityLevelAccountsPayable").prop('required',false);
                    $("input:checkbox[name='companyTypeAccountsPayable[]']").prop('required',false);
                  }
              });
              $("#fun_accountsReceivable").click(function () {
                $('#fun_accountsReceivable_reason').toggle();
                $("#fun_accountsReceivable").toggleClass("selected");
                if($("#fun_accountsReceivable").hasClass( "selected" )){
                  $("#reasonAccountsReceivable").prop('required',true);
                  $("#seniorityLevelAccountsReceivable").prop('required',true);
                  $("input:checkbox[name='companyTypeAccountsReceivable[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_accountsReceivable_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }

                if(!$("#fun_accountsReceivable").hasClass( "selected" )){
                  $("#reasonAccountsReceivable").prop('required',false);
                  $("#seniorityLevelAccountsReceivable").prop('required',false);
                  $("input:checkbox[name='companyTypeAccountsReceivable[]']").prop('required',false);
                }
              });

              $("#fun_generalLedger").click(function () {
                $('#fun_generalLedger_reason').toggle();
                $("#fun_generalLedger").toggleClass("selected");
                if($("#fun_generalLedger").hasClass( "selected" )){
                  $("#reasonGeneralLedger").prop('required',true);
                  $("#seniorityLevelGeneralLedger").prop('required',true);
                  $("input:checkbox[name='companyTypeGeneralLedger[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_generalLedger_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }

                if(!$("#fun_generalLedger").hasClass( "selected" )){
                  $("#reasonGeneralLedger").prop('required',false);
                  $("#seniorityLevelGeneralLedger").prop('required',false);
                  $("input:checkbox[name='companyTypeGeneralLedger[]']").prop('required',false);
                }
              });
              $("#fun_payrollSpecialist").click(function () {
                $('#fun_payrollSpecialist_reason').toggle();
                $("#fun_payrollSpecialist").toggleClass("selected");
                if($("#fun_payrollSpecialist").hasClass( "selected" )){
                  $("#reasonPayrollSpecialist").prop('required',true);
                  $("#seniorityLevelPayrollSpecialist").prop('required',true);
                  $("input:checkbox[name='companyTypePayrollSpecialist[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_payrollSpecialist_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }

                if(!$("#fun_payrollSpecialist").hasClass( "selected" )){
                  $("#reasonPayrollSpecialist").prop('required',false);
                  $("#seniorityLevelPayrollSpecialist").prop('required',false);
                  $("input:checkbox[name='companyTypePayrollSpecialist[]']").prop('required',false);
                }
              });
              $("#fun_creditAnalyst").click(function () {
                $('#fun_creditAnalyst_reason').toggle();
                $("#fun_creditAnalyst").toggleClass("selected");
                if($("#fun_creditAnalyst").hasClass( "selected" )){
                  $("#reasonCreditAnalyst").prop('required',true);
                  $("#seniorityLevelCreditAnalyst").prop('required',true);
                  $("input:checkbox[name='companyTypeCreditAnalyst[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_creditAnalyst_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_creditAnalyst").hasClass( "selected" )){
                  $("#reasonCreditAnalyst").prop('required',false);
                  $("#seniorityLevelCreditAnalyst").prop('required',false);
                  $("input:checkbox[name='companyTypeCreditAnalyst[]']").prop('required',false);
                }
              });
              $("#fun_internalAudit").click(function () {
                $('#fun_internalAudit_reason').toggle();
                $("#fun_internalAudit").toggleClass("selected");
                if($("#fun_internalAudit").hasClass( "selected" )){
                  $("#reasonInternalAudit").prop('required',true);
                  $("#seniorityLevelInternalAudit").prop('required',true);
                  $("input:checkbox[name='companyTypeInternalAudit[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_internalAudit_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_internalAudit").hasClass( "selected" )){
                  $("#reasonInternalAudit").prop('required',false);
                  $("#seniorityLevelInternalAudit").prop('required',false);
                  $("input:checkbox[name='companyTypeInternalAudit[]']").prop('required',false);
                }
              });

              $("#fun_externalAudit").click(function () {
                $('#fun_externalAudit_reason').toggle();
                $("#fun_externalAudit").toggleClass("selected");
                if($("#fun_externalAudit").hasClass( "selected" )){
                  $("#reasonExternalAudit").prop('required',true);
                  $("#seniorityLevelExternalAudit").prop('required',true);
                  $("input:checkbox[name='companyTypeExternalAudit[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_externalAudit_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_externalAudit").hasClass( "selected" )){
                  $("#reasonExternalAudit").prop('required',false);
                  $("#seniorityLevelExternalAudit").prop('required',false);
                  $("input:checkbox[name='companyTypeExternalAudit[]']").prop('required',false);
                }
              });

              $("#fun_financialController").click(function () {
                $('#fun_financialController_reason').toggle();
                $("#fun_financialController").toggleClass("selected");
                if($("#fun_financialController").hasClass( "selected" )){
                  $("#reasonFinancialController").prop('required',true);
                  $("#seniorityLevelFinancialController").prop('required',true);
                  $("input:checkbox[name='companyTypeFinancialController[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_financialController_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_financialController").hasClass( "selected" )){
                  $("#reasonFinancialController").prop('required',false);
                  $("#seniorityLevelFinancialController").prop('required',false);
                  $("input:checkbox[name='companyTypeFinancialController[]']").prop('required',false);
                }
              });

              $("#fun_industrialController").click(function () {
                $('#fun_industrialController_reason').toggle();
                $("#fun_industrialController").toggleClass("selected");
                if($("#fun_industrialController").hasClass( "selected" )){
                  $("#reasonIndustrialController").prop('required',true);
                  $("#seniorityLevelIndustrialController").prop('required',true);
                  $("input:checkbox[name='companyTypeIndustrialController[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_industrialController_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_industrialController").hasClass( "selected" )){
                  $("#reasonIndustrialController").prop('required',false);
                  $("#seniorityLevelIndustrialController").prop('required',false);
                  $("input:checkbox[name='companyTypeIndustrialController[]']").prop('required',false);
                }
              });

              $("#fun_analystFPA").click(function () {
                $('#fun_analystFPA_reason').toggle();
                $("#fun_analystFPA").toggleClass("selected");
                if($("#fun_analystFPA").hasClass( "selected" )){
                  $("#reasonAnalystFPA").prop('required',true);
                  $("#seniorityLevelAnalystFPA").prop('required',true);
                  $("input:checkbox[name='companyTypeAnalystFPA[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_analystFPA_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_analystFPA").hasClass( "selected" )){
                  $("#reasonAnalystFPA").prop('required',false);
                  $("#seniorityLevelAnalystFPA").prop('required',false);
                  $("input:checkbox[name='companyTypeAnalystFPA[]']").prop('required',false);
                }
              });
              $("#fun_consolidationReporting").click(function () {
                $('#fun_consolidationReporting_reason').toggle();
                $("#fun_consolidationReporting").toggleClass("selected");
                if($("#fun_consolidationReporting").hasClass( "selected" )){
                  $("#reasonConsolidationReporting").prop('required',true);
                  $("#seniorityLevelConsolidationReporting").prop('required',true);
                  $("input:checkbox[name='companyTypeConsolidationReporting[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_consolidationReporting_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_consolidationReporting").hasClass( "selected" )){
                  $("#reasonConsolidationReporting").prop('required',false);
                  $("#seniorityLevelConsolidationReporting").prop('required',false);
                  $("input:checkbox[name='companyTypeConsolidationReporting[]']").prop('required',false);
                }
              });

              $("#fun_VATAccountant").click(function () {
                $('#fun_VATAccountant_reason').toggle();
                $("#fun_VATAccountant").toggleClass("selected");
                if($("#fun_VATAccountant").hasClass( "selected" )){
                  $("#reasonVATAccountant").prop('required',true);
                  $("#seniorityLevelVATAccountant").prop('required',true);
                  $("input:checkbox[name='companyTypeVATAccountant[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_VATAccountant_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_VATAccountant").hasClass( "selected" )){
                  $("#reasonVATAccountant").prop('required',false);
                  $("#seniorityLevelVATAccountant").prop('required',false);
                  $("input:checkbox[name='companyTypeVATAccountant[]']").prop('required',false);
                }
              });

              $("#fun_taxAnalyst").click(function () {
                $('#fun_taxAnalyst_reason').toggle();
                $("#fun_taxAnalyst").toggleClass("selected");
                if($("#fun_taxAnalyst").hasClass( "selected" )){
                  $("#reasonTaxAnalyst").prop('required',true);
                  $("#seniorityLevelTaxAnalyst").prop('required',true);
                  $("input:checkbox[name='companyTypeTaxAnalyst[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_taxAnalyst_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_taxAnalyst").hasClass( "selected" )){
                  $("#reasonTaxAnalyst").prop('required',false);
                  $("#seniorityLevelTaxAnalyst").prop('required',false);
                  $("input:checkbox[name='companyTypeTaxAnalyst[]']").prop('required',false);
                }
              });

              $("#fun_treasuryAnalyst").click(function () {
                $('#fun_treasuryAnalyst_reason').toggle();
                $("#fun_treasuryAnalyst").toggleClass("selected");
                if($("#fun_treasuryAnalyst").hasClass( "selected" )){
                  $("#reasonTreasuryAnalyst").prop('required',true);
                  $("#seniorityLevelTreasuryAnalyst").prop('required',true);
                  $("input:checkbox[name='companyTypeTreasuryAnalyst[]']").prop('required',true);
                  var requiredCheckboxes = $('#fun_treasuryAnalyst_reason input:checkbox[required]');
                    requiredCheckboxes.change(function(){
                        if(requiredCheckboxes.is(':checked')) {
                            requiredCheckboxes.removeAttr('required');
                        } else {
                            requiredCheckboxes.attr('required', 'required');
                        }
                    });
                }
                if(!$("#fun_treasuryAnalyst").hasClass( "selected" )){
                  $("#reasonTreasuryAnalyst").prop('required',false);
                  $("#seniorityLevelTreasuryAnalyst").prop('required',false);
                  $("input:checkbox[name='companyTypeTreasuryAnalyst[]']").prop('required',false);
                }
              });

              $(".fun_Other").click(function () {
                $('#functions_other').toggle();
              });





      // Partner platform


      //  partner address

      $("input#partnerAddress").geocomplete();

      // Trigger geocoding request.
      $("button.find").click(function(){
        $("input#partnerAddress").trigger("geocode");
      });

      //home or interview tabs
      if($("#uploadedCV:contains('CV')").length) {
        $("#noCVuploaded").hide();
      }
      else {
        $("#noCVuploaded").show();
      }

      if($("#interviewsToMake:contains('interview to make')").length) {
        $('#candidatesToInterview').show();
      }

      if($("#interviewFeedbackToGive:contains('feedback to give')").length) {
        $('#partnerItwcandidateFeedback').show();
      }


      if ($('#partnerStatut').text() === '1') {
        $('#profileReviewed').show();
      }
      if ($('#partnerStatut').text() === '2') {
        $('#partnerNoMatch').show();
      }
      if ($('#partnerStatut').text() === '3') {
        $('#partnerOtherDivisionMatch').show();
      }
      if ($('#partnerStatut').text() === '4') {
        $('#partnerNoMatchButConsiderCandidate').show();
      }
      if ($('#partnerStatut').text() === '5') {
        $('#adminPartnerInterview').show();
        $('#partnerMatch').show();
      }
      if ($('#partnerStatut').text() === '6') {
        $('.partner-waitingforadmininterviewconf').show();
      }
      if ($('#partnerStatut').text() === '7') {
        $('#partnerAdminInterviewSummary').show();
      }
      if ($('#partnerStatut').text() === '8') {
        $('#adminItwPartnerFeedback').show();
      }
      if ($('#partnerStatut').text() === '9') {
        $('#partnerNotSelected').show();
      }
      if ($('#partnerStatut').text() === '10') {
        $('#partnerInterviewSummary').show();
      }

      $('.partnerChangeItwRequest').click(function(){
        $(".partner-waitingforadmininterviewconf").hide();
        $(".partnerInterviewTimePropositions").hide();
        $(".candidateCantAttend").hide();
        $("#adminPartnerInterview").show();
        $(".candidate-askforinterview").show();
      });


      if ( $('#aboutPartner').text().length > 0 ) {
        $('#partnerCareerSummary').hide();
        $('#aboutPartner_save').hide();
        $('#aboutPartner_update').show();
        }
      else{
        $('#partnerCareerSummary').show();
        $('#aboutPartner_save').show();
      };

      $("#aboutPartner_update").click(function(){
        $('#partnerCareerSummary').show();
        $('#aboutPartner_save').show();
        $('#aboutPartner_update').hide();
        $('#aboutPartner').hide();
      });

      // Selection of the interview time and date
      $("#proposition1button").click(function() {
        $("#proposition1").prop("checked", "checked");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition1button").css("color", "#F14904");
        $("#proposition2button").css("color", "#333333");
        $("#proposition3button").css("color", "#333333");
        $("#proposition2").prop("checked", "");
        $("#proposition3").prop("checked", "");
      })
      $("#proposition2button").click(function() {
        $("#proposition1").prop("checked", "");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition1button").css("color", "#333333");
        $("#proposition2button").css("color", "#F14904");
        $("#proposition3button").css("color", "#333333");
        $("#proposition2").prop("checked", "checked");
        $("#proposition3").prop("checked", "");
      })
      $("#proposition3button").click(function() {
        $("#proposition1").prop("checked", "");
        $("#partnerInterviewTimeChoice").attr('type', 'submit');
        $("#proposition1button").css("color", "#333333");
        $("#proposition2button").css("color", "#333333");
        $("#proposition3button").css("color", "#F14904");
        $("#proposition2").prop("checked", "");
        $("#proposition3").prop("checked", "checked");
      })


      // cancel or postpone the confirmed interview
      $("#interviewOptions").click(function() {
        $("#interviewOptions").hide();
        $("#showInterviewOptions").show();
      })

      $("#backInterviewOptions").click(function() {
        $("#interviewOptions").show();
        $("#showInterviewOptions").hide();
      })

      $("#partnerPostponeInterview").click(function() {
        $("#seePartnerPostponeInterview").show();
        $("#showInterviewOptions").hide();
      })

      $("#partnerCancelInterview").click(function() {
        $("#seePartnerCancelInterview").show();
        $("#showInterviewOptions").hide();
      })



      // partner interview feedback tab

      if ($('#partnerFeedbackStatut').text() === '1') {
        $('#feedbackToGive').show();
      }
      if ($('#partnerFeedbackStatut').text() === '2') {
        $('#feedbackGiven').show();
      }



      // partner interviews
      if (parseInt($('.halloTest').html()) < 0){
        $('.halloTest123').css("display","block");
        $('.candidateDidNotShowUpButton').css("display","block");
      }
      else {
        $('.halloTest123').css("display","none");
        $('.candidateDidNotShowUpButton').css("display","none");
      }



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


      // Add IT skills requirement for the position
      $('.addIT-2').on("click", function() {
        $(".vacancy-IT-2").css("display", "block")
      })

      $('.addIT-3').on("click", function() {
        $(".vacancy-IT-3").css("display", "block")
      })
      $('.deleteIT-2').on("click", function() {
        $(".vacancy-IT-2").css("display", "none")
      })

      $('.addIT-4').on("click", function() {
        $(".vacancy-IT-4").css("display", "block")
      })
      $('.deleteIT-3').on("click", function() {
        $(".vacancy-IT-3").css("display", "none")
      })
      $('.addIT-5').on("click", function() {
        $(".vacancy-IT-5").css("display", "block")
      })
      $('.deleteIT-4').on("click", function() {
        $(".vacancy-IT-4").css("display", "none")
      })


      $('.deleteIT-5').on("click", function() {
        $(".vacancy-IT-5").css("display", "none")
      })





    // Candidates tab
    if ($('#partnerStat').text() === '1') {
      $('#profileReview').css("display","");
    }
    else {
      $('#profileReview').hide();
    }

    if ( $('#aboutPart').text().length == 0 ) {
      $('#missingInformation').show();
    };



      //Settings

      //Initiate bar
        var mySlider = $("#partnerUpdateChoice").slider();

          $("#partnerUpdateChoice").on("slide", function (slideEvt) {

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


      //Email addresses
      if ($('#emailPartner1').text().length > 10 ) {
        $('#emailPartner_save').hide();
        $('#emailPartner1').show();
        $('#emailPartner_update').show();
        $('#addEmailPartner2').show();
        $('#emailPartner_input').hide();
        }
      else{
        $('#emailPartner1').hide();
        $('#emailPartner_save').show();

      };

      $("#emailPartner_update").click(function(){
        $('#emailPartner_input').show();
        $('#emailPartner_save').show();
        $('#emailPartner1').hide();
      });

      $("#addEmailPartner2").click(function(){
        $('#emailPartner2_input').show();
        $('#emailPartner_save').show();
      });

      //Email address 2
      if ($('#emailPartner2').text().length > 2 ) {
        $('#emailPartner_save').hide();
        $('#emailPartner2').show();
        $('#emailPartner2_update').show();
        $('#addEmailPartner3').show();
        $('#emailPartner2_input').hide();
        $("#addEmailPartner2").hide();
        }
      else{
        $('#emailPartner2').hide();
        $('#emailPartner_save').show();

      };

      $("#emailPartner2_update").click(function(){
        $('#emailPartner2_input').show();
        $('#emailPartner_save').show();
        $('#emailPartner2').hide();
      });

      $("#addEmailPartner3").click(function(){
        $('#emailPartner3_input').show();
        $('#emailPartner_save').show();
      });

      //Email address 3
      if ($('#emailPartner3').text().length > 2 ) {
        $('#emailPartner_save').hide();
        $('#emailPartner3').show();
        $('#emailPartner3_update').show();
        $('#emailPartner3_input').hide();
        $("#addEmailPartner3").hide();
        }
      else{
        $('#emailPartner3').hide();

      };

      $("#emailPartner3_update").click(function(){
        $('#emailPartner3_input').show();
        $('#emailPartner_save').show();
        $('#emailPartner3').hide();
      });


      //Phone numbers
      if ($('#phonePartner1').text().length > 10 ) {
        $('#phonePartner_save').hide();
        $('#phonePartner1').show();
        $('#phonePartner_update').show();
        $('#addPhonePartner2').show();
        $('#phonePartner_input').hide();
        }
      else{
        $('#phonePartner1').hide();
        $('#phonePartner_save').show();

      };

      $("#phonePartner_update").click(function(){
        $('#phonePartner_input').show();
        $('#phonePartner_save').show();
        $('#phonePartner1').hide();
      });

      $("#addPhonePartner2").click(function(){
        $('#phonePartner2_input').show();
        $('#phonePartner_save').show();
      });

      //Phone 2
      if ($('#phonePartner2').text().length > 2 ) {
        $('#phonePartner_save').hide();
        $('#phonePartner2').show();
        $('#phonePartner2_update').show();
        $('#addPhonePartner3').show();
        $('#phonePartner2_input').hide();
        $("#addPhonePartner2").hide();
        }
      else{
        $('#phonePartner2').hide();
        $('#phonePartner_save').show();

      };

      $("#phonePartner2_update").click(function(){
        $('#phonePartner2_input').show();
        $('#phonePartner_save').show();
        $('#phonePartner2').hide();
      });

      $("#addPhonePartner3").click(function(){
        $('#phonePartner3_input').show();
        $('#phonePartner_save').show();
      });

      //Phone 3
      if ($('#phonePartner3').text().length > 2 ) {
        $('#phonePartner_save').hide();
        $('#phonePartner3').show();
        $('#phonePartner3_update').show();
        $('#phonePartner3_input').hide();
        $("#addPhonePartner3").hide();
        }
      else{
        $('#phonePartner3').hide();

      };

      $("#phonePartner3_update").click(function(){
        $('#phonePartner3_input').show();
        $('#phonePartner_save').show();
        $('#phonePartner3').hide();
      });


      //Skype
      if ($('#skypePartner1').text().length > 10 ) {
        $('#skypePartner_save').hide();
        $('#skypePartner1').show();
        $('#skypePartner_update').show();
        $('#skypePartner_input').hide();
        }
      else{
        $('#skypePartner1').hide();
        $('#skypePartner_save').show();

      };

      $("#skypePartner_update").click(function(){
        $('#skypePartner_input').show();
        $('#skypePartner_save').show();
        $('#skypePartner1').hide();
      });


      // Password
      $('#passwordPartnerInputs input').keyup(function() {
      if ($('#passwordPartner').val() === $('#passwordPartner_confirmation').val() ) {
        $('#passwordPartner_save').attr('type', 'submit');
      }
      else {
        $('#passwordPartner_save').attr('type', '');
        }
      });

      // General
      $('#general_edit').click(function() {
        $('.general_information').hide();
        $('.general_information_update').show();
        $('#general_save').show();
        $('#general_edit').hide();
      });

      //  Partner address

      $("input#partnerAddress").geocomplete();

      // Trigger geocoding request.
      $("button.find").click(function(){
        $("input#partnerAddress").trigger("geocode");
      });




  // documents
  $('#docType').change(function() {
      if ($(this).val() === 'WorkCertificate') {
        $('#companyWorkCertificate').show();
      }
      else {
        $('#companyWorkCertificate').hide();
      }
      if ($(this).val() === 'Diploma') {
        $('#diplomaUniversity').show();
        $('#diplomaGrade').show();
      }
      else {
        $('#diplomaUniversity').hide();
        $('#diplomaGrade').hide();
      }
      if ($(this).val() === 'Others') {
        $('#others').show();
      }
      else {
        $('#others').hide();
      }
  });


    if($('#CVRow a').length > 0){
      $('#noCVuploaded').hide();
      $('#profileNotComplete #NoCV').css('display','none');
    }
    if($('#WCRow a').length > 0){
      $('#noWCuploaded').hide();
    }
    if($('#DiplomaRow a').length > 0){
      $('#noDiplomaUploaded').hide();
    }
    if($('#OthersRow a').length > 0){
      $('#noOthersUploaded').hide();
    }

   // uploads

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


// partner can't attend the interview with admin and proposes new slots
 $('.candidateCantAttend').click(function() {
   $('.candidate-askforinterview').show();
   $('.candidateCantAttend').hide();
   $('.partnerInterviewTimePropositions').hide();
 });



  // Admin platform

  // Validate candidate profiles

  if($('#candidateStatut').text() === '2' || $('#candidateStatut').text() === '11' || $('#candidateStatut').text() === '15'){
    $('#validationButtons').show();
  }
  else {
    $('#validationButtons').hide();
  }


  $('#noValidateProfile').click(function() {
    $('#candidateNotValidated').show();
    $('#candidateValidated').hide();
    $('#validationButtons').hide();
    $('#goBackToValidationButtons').show();
  });

  $('#validateProfile').click(function() {
    $('#candidateNotValidated').hide();
    $('#candidateValidated').show();
    $('#validationButtons').hide();
    $('#goBackToValidationButtons').show();
  });

  $('#goBackToValidationButtons').click(function() {
    $('#validationButtons').show();
    $('#candidateValidated').hide();
    $('#candidateNotValidated').hide();
    $('#goBackToValidationButtons').hide();
  });

$('#reasonNotValidated').change(function() {
    if ($(this).val() === 'noDivision') {
      $('#toKeepForDivision').show();
      $('#confirmCandidateNotSelected').hide();
      if ($('#toKeepForDivision').val() !== '') {
            $('#confirmCandidateNotSelected').show();
      };
    }
    else if ($(this).val() === 'noMatch') {
      $('#confirmCandidateNotSelected').show();
    }
    else if ($(this).val() === 'toConsiderAsCandidate') {
      $('#confirmCandidateNotSelected').show();
    }
    else {
      $('#toKeepForDivision').hide();
    }
});

$('#reasonNotValidated').change(function() {
    if ($(this).val() === 'noDivision') {
      $('#toKeepForDivision').show();

    }
    else {
      $('#toKeepForDivision').hide();
    }
});


$('#partnerDivision').change(function() {
    if ($(this).val() === 'Finance & Accounting') {
      $('#partnerDepartmentFinanceAccounting').show();
    }
    else {
      $('#partnerDepartmentFinanceAccounting').hide();
    }
});


$('#partnerDepartmentFinanceAccounting').change(function() {
    if ($(this).val() === 'Accounting Department') {
      $('#partnerFunctionAccounting').show();
      $('#partnerFunctionFC').hide();
      $('#partnerFunctionTaxTreasury').hide();
    }

    if ($(this).val() === 'Finance & Controlling Department') {
      $('#partnerFunctionFC').show();
      $('#partnerFunctionAccounting').hide();
      $('#partnerFunctionTaxTreasury').hide();
    }

    if ($(this).val() === 'Tax & Treasury Department') {
      $('#partnerFunctionTaxTreasury').show();
      $('#partnerFunctionAccounting').hide();
      $('#partnerFunctionFC').hide();
    }

});


$('.partnerFunction').change(function() {
      $('#choosePartner').show();

});

  // Fill feedback candidate
  $('#adminFillCandidateInterview').click(function() {
    $('#adminFillCandidateInterview').hide();
    $('#adminFillCandidateInterviewShow').show();
  });


  // seePartners

  if($("#interviewStatut").text() === '1') {
    $("#validationButtons").css("display", "");
  };

  if($("#interviewStatut").text() === '2') {
    $(".admin-waitingforpartnerinterviewconf").css("display", "");
  };
  if($("#interviewStatut").text() === '3') {
    $(".adminPartnerInterviewTimePropositions").css("display", "");
  };
  if($("#interviewStatut").text() === '4') {
    $("#confirmedInterviewWithPartner").css("display", "");
  };
  if($("#interviewStatut").text() === '5') {
    $("#partnerItwAdminFeedback").css("display", "");
  };

  $(".changeItwRequest").click(function() {
    $("#candidateValidated").css("display", "block");
    $(".admin-waitingforpartnerinterviewconf").css("display", "none");
    $(".adminPartnerInterviewTimePropositions").css("display", "none");
  })

  $("#deleteAccount").click(function() {
    $("#deleteAccount").css("display", "none");
    $("#confirmDeleteAccount").css("display", "block");
  })








  // Validate company profiles

  // seeCompanies

  if($("#companyStatut").text() === '1' || $("#companyStatut").text() === '3') {
    $("#validationButtonsCompany").css("display", "");
  }
  else{
    $("#validationButtonsCompany").css("display", "none");
  }

  $('#noValidateCompany').click(function() {
    $('#companyNotValidated').show();
    $('#companyValidated').hide();
    $('#validationButtons').hide();
    $('.goBackToValidationButtons').show();
  });

  $('#validateCompany').click(function() {
    $('#companyNotValidated').hide();
    $('#companyValidated').show();
    $('#validationButtons').hide();
    $('.goBackToValidationButtons').show();
  });

  $('#companyDeleteAccount').click(function() {
    $('.companyDeleteAccountConfirm').show();
    $('.goBackToValidationButtons').show();
  });


  $('.goBackToValidationButtons').click(function() {
    $('#validationButtons').show();
    $('#companyValidated').hide();
    $('#companyValidated2').hide();
    $('#companyNotValidated').hide();
    $('.goBackToValidationButtons').hide();
  });

  $('#reasonNotValidated').change(function() {
    if ($(this).val() === 'noDivision') {
      $('#toKeepForDivision').show();
      $('#toKeepForLocation').hide();
      $('#confirmCompanyNotSelected').hide();
      if ($('#toKeepForDivision').val() !== '') {
            $('#confirmCompanyNotSelected').show();
      };
    }
    else if ($(this).val() === 'noLocation') {
      $('#toKeepForLocation').show();
      $('#toKeepForDivision').hide();
      $('#confirmCompanyNotSelected').hide();
      if ($('#toKeepForLocation').val() !== '') {
            $('#confirmCompanyNotSelected').show();
      };
    }
    else if ($(this).val() === 'noSerious') {
      $('#confirmCompanyNotSelected').show();
      $('#toKeepForDivision').hide();
      $('#toKeepForLocation').hide();
    }
    else {
      $('#toKeepForDivision').hide();
    }
  });

  $('#reasonNotValidated').change(function() {
    if ($(this).val() === 'noDivision') {
      $('#toKeepForDivision').show();

    }
    else {
      $('#toKeepForDivision').hide();
    }
  });
























    }); // fermeture de jQuery

    // profile picture

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

    function removeUpload() {
      $('.file-upload-input').replaceWith($('.file-upload-input').clone());
      $('#documentDetails').hide();
      $('.file-upload').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
      });
      $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
