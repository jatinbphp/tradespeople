<?php 
include ("include/header1.php");
?>
<style>
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
</style>
<!-- how-it-work -->
<?php
  $signup_step4 = false;
  $is_qualification = 0;
  $insurance_liability = 'no';
  $about_business = '';
  $qualification = '';
  $insurance_amount = '';
  $insurance_date = date("Y-m-d");
  if($this->session->userdata('signup_step4')){
    $signup_step4 = $this->session->userdata('signup_step4');
    $is_qualification = $signup_step4['is_qualification'];
		
		if($is_qualification==1){
			$qualification = $signup_step4['qualification'];
		}
		
    
    $insurance_liability = $signup_step4['insurance_liability'];
    if($insurance_liability == 'yes'){
      $insurance_amount = $signup_step4['insurance_amount'];
      $insurance_date = $signup_step4['insurance_date'];
    }
    $about_business = $signup_step4['about_business'];
  }
?>
<div class="start-sign">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
        <div class="white-start">
          <form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup2();">
            <div class="sing-top">
              <h1>
                <a href="<?=base_url("signup-step3"); ?>"><i class="fa fa-caret-left"></i> Back</a>
                About your service
              </h1>
            </div>
            <div class="sing-body" id="about_business11" tabindex='1'>
              <p> Please tell the customers about your business, experience and quality of your work.<br>
							It's the first thing users reads about you, so it's essential to make sure it is well written.</p>
             
              <textarea class="form-control" name="about_business" id="about_business" rows="14"><?=$about_business;?></textarea>
              <div class="text-right"><small class="text-danger">Minimum 100 Characters</small></div>
              <div class="custom_err alert alert-danger" style="display:none;">About your business field can't be empty.</div>
              <!-- <div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Please don't include contact details or your website in this section.</div> -->
              <div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Contact detail detected. Remove it to continue.</div>
              <hr>
            </div>
            <div class="sing-top">
              <p class="text-center"><b style="font-weight: normal; font-size: 20px;"> 
                Do you have any trade qualification or accreditation?
              </b><p>
              <div class="form-group" style="display:inline-block; width:100%;">
                <div class="col-md-12 text-center">
                  <label class="radio-inline" for="qualification_yes">
                    <input type="radio" name="is_qualification" value="1" onclick="showHideQualification(this.value)" required id="qualification_yes" /> YES
                  </label>
                  <label class="radio-inline" for="qualification_no">
                    <input type="radio" name="is_qualification" value="0" onclick="showHideQualification(this.value)" id="qualification_no" /> NO
                  </label>
                </div>
              </div>
            </div>
            <div class="sing-body" id="qualificationBox" tabindex='1'>
              <p>Please list your qualifications and accreditations (with the relevant registration number) in this section. If you're time served tradesman, leave this section blank.</p>

              <textarea class="form-control" name="qualification" id="work_history" rows="14"><?=$qualification; ?></textarea>

              <div class="msg1-12 text-danger" style="display: none; margin-top:10px;">Please don't include contact details or your website in this section.</div>

            </div>
            <div class="sing-top">
              <p class="text-center"><b style="font-weight: normal; font-size: 20px;">Do you have public liability insurance? 
              </b><p>
              <div class="form-group" style="display:inline-block; width:100%;">
                <div class="col-md-12 text-center">
                  <label class="radio-inline" for="insurance_yes">
                    <input type="radio" name="insurance_liability" value="yes" onclick="showHideInsurance(this.value)" required id="insurance_yes" /> Yes
                  </label>
                  <label class="radio-inline" for="insurance_no">
                    <input type="radio" name="insurance_liability" value="no" onclick="showHideInsurance(this.value)" id="insurance_no" /> No
                  </label>
                </div>
              </div>
            </div>
            <div class="sing-body" id="insuranceBox">
              <p>How much professional indemnity insurance do you have?</p>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-gbp"></i>
                    </span>
                    <input type="text" name="insurance_amount" class="form-control" placeholder="0.00" value="<?=$insurance_amount;?>" />
                  </div>
                </div>
              </div>

              <p>When is the insurance expiring ?</p>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="date" class="form-control" name="insurance_date" value="<?=date("Y-m-d", strtotime($insurance_date));?>" />
                </div>
              </div>

              <hr>
            </div>
            <div id="errorBox">
              
            </div>
            <div class="start-btn maggg1 text-center">
              <button type="submit" class="btn btn-warning btn-lg signup_btn">Save and Continue</button>
              <a href="<?=base_url("signup-step7"); ?>">Do This Later</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  init_tinymce();
  function init_tinymce(){
    tinymce.init({
      selector: '.textarea',
      height:250,
      menubar: false,
      branding: false,
      statusbar: false,
			//toolbar: 'bold | alignleft alignjustify | numlist',
      setup: function (editor) {
        editor.on('change', function () {
          tinymce.triggerSave();
        });
      }
    });
  }

  var is_qualification = <?=$is_qualification;?>;
  if(is_qualification == 1){
    $("#qualification_yes").attr('checked', true).trigger('click');
  }else{
    $("#qualification_no").attr('checked', true).trigger('click');
  }

  var insurance_liability = '<?=$insurance_liability;?>';
  if(insurance_liability == 'yes'){
    $("#insurance_yes").attr('checked', true).trigger('click');
  }else{
    $("#insurance_no").attr('checked', true).trigger('click');
  }

  function signup2(){
		
		var about_business = $('#about_business').val();
		
		if(about_business){
      var len = about_business.length;
      if(len < 100){
        $('.custom_err').html('About your business field must be at least 100 characters in length.');
        $('.custom_err').show();
        return false;
      }
			$('.custom_err').hide();
		} else {
			window.location.href = '#about_business11';
			$('.custom_err').show();
			return false;
		}
		
    $.ajax({
      type:'POST',
      url:site_url+'home/submit_signup4/',
      data:$('#signup').serialize(),
      dataType:'JSON',
      beforeSend:function(){
        $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $('.signup_btn').prop('disabled',true);
        $('.msg').html('');
				$("#errorBox").empty();
				$('.msg1-11').hide();
				$('.msg1-12').hide();
      },
      success:function(resp){
        if(resp.status==1){
          //window.location.href = site_url+'email-verify';
          window.location.href = site_url+'signup-step7';
        } else if(resp.status==2){	
					//$('.msg1-11').show();
          swal("", "Contact detail detected. Remove it to continue.", "error");
					$('#about_business11').focus();
					$('.signup_btn').html('Save and Continue');
          $('.signup_btn').prop('disabled',false);
				} else if(resp.status==3){	
					//$('.msg1-12').show();
          swal("", "Contact detail detected. Remove it to continue.", "error");
					$('#qualificationBox').focus();
					$('.signup_btn').html('Save and Continue');
          $('.signup_btn').prop('disabled',false);
				} else {
          
          $("#errorBox").append(resp.msg);
          $('.signup_btn').html('Save and Continue');
          $('.signup_btn').prop('disabled',false);
        }
      }
    });

    return false;
  }

  function showHideQualification(radioValue){
    if(radioValue == 0){
      $("#qualificationBox").slideUp();
    }else{
      $("#qualificationBox").slideDown();
    }
  }

  function showHideInsurance(radioValue){
    if(radioValue == 'no'){
      $("#insuranceBox").slideUp();
    }else{
      $("#insuranceBox").slideDown();
    }
  }

  showHideQualification(is_qualification);
  showHideInsurance(insurance_liability);

</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
