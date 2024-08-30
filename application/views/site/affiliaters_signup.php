<?php include ("include/header1.php"); ?>
<!-- how-it-work -->
<div class="start-sign">
	<div class="container">
		<div class="row"> 
			<div class="col-sm-8 col-sm-offset-2">
				<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						<h1><a href="<?php echo base_url("marketers"); ?>"><i class="fa fa-caret-left"></i> Back</a> 
						Create a new account</h1>
					</div>
					
					<div class="sing-body">
						<form method="post" id="signup" enctype="multipart/form-data"  onsubmit="return signup();">
								
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> First name * </label>  
									<div class="col-md-12">
										<input type="text" class="form-control input-lg" name="f_name" id="f_name" required>	
									</div>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Last name *</label>  
									<div class="col-md-12">
									<input type="text" class="form-control input-lg" name="l_name" id="l_name" required>	
									</div>
								</div>
							</div>
						</div> 
						<div class="form-group">
						  <label class="col-md-12 control-label">Email *</label>  
						  <div class="col-md-12">
						  <input type="text" class="form-control input-lg" name="email" id="email" value="<?php echo ($step1)?$step1['email']:'';?>" required>
						  </div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Password * </label>  
									<div class="col-md-12">
										<input type="password" class="form-control input-lg" name="password" id="password" required>	
									</div> 
								</div>

							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Confirm Password * </label>  
									<div class="col-md-12">
										<input type="password" class="form-control input-lg" name="confirm_password" id="confirm_password" required>	
									</div>
								</div>
								<p id="cnf_err_content" style="color: red;"></p>

							</div>
						  	<p id="pass_content" style="color: red;"></p>

						</div>  
						<div class="form-group">
						  <label class="col-md-12 control-label">Address *</label>  
						  <div class="col-md-12">
						  <input type="text" name="e_address" id="geocomplete" class="form-control input-lg" value="<?php echo ($step1)?$step1['e_address']:'';?>" placeholder="Enter an address" required>
						  </div>
						</div>
						<div class="row"> 
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Country * </label>  
									<div class="col-md-12">
									<select class="form-control input-lg"  name="country" id="countryus3">
										<option value=""></option>
										<?php
											foreach($country as $key => $val){
											$value_country = strtolower($val->name);
											$country_name = ucfirst($value_country);
											echo '<option  value="'.$val->name.'">'.$country_name.'</option>';
										}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<!-- <label class="col-md-12 control-label"> Country * </label>  -->
									<label class="col-md-6 control-label">Traffic source *</label>   
									<div class="col-md-12">
									<input type="url" class="form-control input-lg" placeholder="Enter URL" name="traffic_source" id="traffic_source" required>
									</div>
								</div>
							</div>
						
							<!-- <div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label">Town/City</label>  
									<div class="col-md-12">
		                		<input type="text" placeholder="" id=""  name="city" class="form-control input-lg">
									
		              			</div>
								</div>
							</div> -->
						</div>
						<!-- <div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Postcode *</label>  
									<div class="col-md-12">
		                		<input type="text" placeholder="Postcode" id="postcode"  name="postal_code" class="form-control input-lg" required>
									
		              			</div>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Phone number *</label>  
									<div class="col-md-12 input-group">
									<input type="text" class="form-control input-lg" name="phone_no" id="phone_no" value="" required>
									</div>
								</div>
							</div>
						</div>  --> 
						
							<!-- <div class="form-group">
						  <label class="col-md-6 control-label">Traffic source *</label>  
						  <div class="col-md-6">
						  <input type="url" class="form-control input-lg" placeholder="Enter URL" name="traffic_source" id="traffic_source" required>
						  </div>
						</div>  -->
						
					
						<div class="form-group">
							<div class="col-md-12">
							<label for="checkboxes-0">
							  <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1" required>
							   I agree to the <a href="<?php echo base_url('terms-and-conditions'); ?>">Terms & Conditions</a>
							</label>
							</div>
						</div>
						<div class="term-acc">
							<p><input type="checkbox" name="checkboxes1" id="checkboxes-1" value="1" required> I have read and understood the <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Notice</a> and <a href="<?php echo base_url('cookie-policy'); ?>">Cookie Policy</a>.</p>
						</div>
						<div class="start-btn text-center">
							<button type="submit" class="btn btn-warning btn-lg signup_btn">Save and Continue</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
//$this->session->unset_userdata('some_name');
?>
<script type="text/javascript">
	$(function () {
        $(".signup_btn").click(function () {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            if (password != confirmPassword) {
                $('#cnf_err_content').text("Passwords do not match.");
                $('#pass_content').css('display', 'none');
                return false;
            }
             $('#cnf_err_content').text("");

            return true;
        });
    });


</script>



<script>
// function check_postcode(postcode){

// 	$.ajax({
// 		type:'POST',
// 		url:site_url+'home/check_postcode',
// 		data:{post_code:postcode},
// 		dataType:'JSON',
// 		beforeSend:function(){ 
// 			$('.postcode-err').hide();
// 		},
// 		success:function(res){
// 			if(res.status==1){
// 				$('#latitude').val(res.latitude);
// 				$('#longitude').val(res.longitude);
// 				$('.postcode-err').hide(); 

// 			} else {
// 				$('.postcode-err').show();
// 				$('#postcode').focus(); 
// 			}
// 		}
// 	});
// 	return false;
// } 
function signup(){ 
	var err_text_msg='';

		var lower;
		var upper;
		var number;
		// var spec;
		var len;

		
    var myInput = document.getElementById("password");
		var lowerCaseLetters = /[a-z]/g;
		if (myInput.value.match(lowerCaseLetters)) { lower = true; } else {
   		lower = false;

		}	

		var upperCaseLetters = /[A-Z]/g;
   	if (myInput.value.match(upperCaseLetters)) { upper = true; } else {
   		upper = false;

   }

   var numbers = /[0-9]/g;
   if (myInput.value.match(numbers)) { number = true; } else {
   		number = false;


   }

		if (myInput.value.length >= 6) { 
			len = true;
		} else {
   		len = false;

		}

		if(lower==false || upper==false || number==false || len==false){
		  document.getElementById("pass_content").style.display = "block";
		 
			err_text_msg = "Must contain at least 6 characters with at least one lowercase, uppercase and number."; 

   		$('#pass_content').text(err_text_msg);
		  return false;
		}else{
		  err_text_msg='';
		  document.getElementById("pass_content").style.display = "none";
		}


	$.ajax({
		type:'POST',
		url:site_url+'home/submit_affiliater_signup',
		data:$('#signup').serialize(), 
		dataType:'JSON',
		beforeSend:function(){
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.signup_btn').prop('disabled',true);
			$('.msg').html('');
		}, 
		success:function(resp){
			if(resp.status==1) {
				window.location.href = site_url + 'marketer_email_verify';
				//window.location.href = site_url+'users/not_verify_phone';
			} else {
				$('.msg').html(resp.msg);
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
				$('#f_name').focus();
			}
		}
	});
	return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#countryus3').select2();
});
</script>