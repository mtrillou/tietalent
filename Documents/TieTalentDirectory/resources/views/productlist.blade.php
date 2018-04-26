<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <center>
      <h1>Laravel dynamic</h1>


          <span>Division: </span>
           <select style="width: 200px" class="division" id="prod_cat_id">
               <option value="0" disabled="true" selected="true">-Select-</option>
               @foreach($prod as $cat)
                  <option value="{{$cat->id}}">{{$cat->name}}</option>
                  <!--<div class="col-md-3"><input type="radio" id="candidateStartUpchoice" name="companytype" value="{{$cat->id}}" class="formchoicebutton threeperline" required><label>{{$cat->name}}</label></div>-->
              @endforeach

           </select>

          <span>Departments: </span>




          <select style="width: 200px" class="department">

            <option value="0" disabled="true" selected="true">Product Name</option>
          </select>

          <span>Positions: </span>

          <select style="width: 200px" class="positionname">

             <option value="0" disabled="true" selected="true">Position</option>
           </select>

          <span>Description: </span>
          <input type="text" class="prod_price">

          <i class="fa fa-plus addIT-5 marginright-small" aria-hidden="true"></i>

        <div class="">
          <span>Division: </span>
           <select style="width: 200px" class="division" id="prod_cat_id">
               <option value="0" disabled="true" selected="true">-Select-</option>
               @foreach($prod as $cat)
                  <option value="{{$cat->id}}">{{$cat->name}}</option>
                  <!--<div class="col-md-3"><input type="radio" id="candidateStartUpchoice" name="companytype" value="{{$cat->id}}" class="formchoicebutton threeperline" required><label>{{$cat->name}}</label></div>-->
              @endforeach

           </select>

          <span>Departments: </span>




          <select style="width: 200px" class="department">

            <option value="0" disabled="true" selected="true">Product Name</option>
          </select>

          <span>Positions: </span>

          <select style="width: 200px" class="positionname">

             <option value="0" disabled="true" selected="true">Position</option>
           </select>

          <span>Description: </span>
          <input type="text" class="prod_price">
        </div>


        <div class="test" style="display:none">
          <div id="fun_accountsPayable_reason"  style="border-top:dashed #333333" >
            <h2 class="orange"><span class="position"></span>{{ trans('partnerplatform_itwcandidatefeedback.recommendationAccountsPayable') }}</h2>
            <p id="alert_accountsPayable" style="border-radius:0.5rem; color:red; padding:1rem; background-color:rgba(241,241,241,0.5);font-size:1rem;">{{ trans('partnerplatform_itwcandidatefeedback.30wordsReasonAlert') }}</p>
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
        </div>



    </center>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change','.division',function () {
            //console.log("hmm its change");

            var cat_id=$(this).val();
             //console.log(cat_id);
             var div=$(this).parent();
              var op=" ";

             $.ajax({
               type:'get',
                url:'{!!URL::to('findDepartment')!!}',
                data:{'id':cat_id},
                success:function(data){
                    // console.log('success');

                    // console.log(data);

                    // console.log(data.length);

                    op+='<option value="0" selected disabled>chose product</option>';
                    for(var i=0;i<data.length;i++){
                    op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                   }

                   div.find('.department').html(" ");
                   div.find('.department').append(op);



                },
                error:function(){

                }


             });


            });


            $(document).on('change','.department',function () {
                //console.log("hmm its change");

                var dpt_id=$(this).val();
                 //console.log(cat_id);
                 var div=$(this).parent();
                  var op=" ";

                 $.ajax({
                   type:'get',
                    url:'{!!URL::to('findPosition')!!}',
                    data:{'id':dpt_id},
                    success:function(data){
                        // console.log('success');

                        // console.log(data);

                        // console.log(data.length);

                        op+='<option value="0" selected disabled>chose position</option>';
                        for(var i=0;i<data.length;i++){
                        op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';

                       }

                       div.find('.positionname').html(" ");
                       div.find('.positionname').append(op);



                    },
                    error:function(){

                    }


                 });


                });



            $(document).on('change','.positionname',function () {
            var prod_id=$(this).val();

            var a=$(this).parent();
            console.log(prod_id);

            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('findPrice')!!}',
                data:{'id':prod_id},
                dataType:'json',//return data will be json
                success:function(data){
                    console.log("Description");
                    console.log(data.description);

                    // here price is coloumn name in products table data.coln name

                    a.find('.prod_price').val(data.description);

                    a.find('.position').html(data.description);

                    a.find('.test').show();


                },
                error:function(){

                }
            });



            });


        });
        </script>
  </body>
</html>
