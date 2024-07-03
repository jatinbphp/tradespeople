<?php 
include ("include/header1.php");
$step1 = $this->session->userdata('signup_step1');
/*if(isset($_GET['referral']) && !empty($_GET['referral'])){
	$referred_by = $_GET['referral'];
}else{
	$referred_by = '';
}*/
?>
<style type="text/css">
	#pass_content{ color: red; }
	#cnf_err_content{ color: red; }
	.pac-container:after {
	    background-image: none !important;
	    height: 0px;
	}
</style>
<link href="<?php echo base_url(); ?>css/address_search.css" type="text/css" rel="stylesheet"/>
<!-- how-it-work -->
<div class="start-sign">
	<div class="container">  
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						<h1><a href="<?php echo base_url(""); ?>"><i class="fa fa-caret-left"></i> Back</a> 
						Sign-up for a trade account</h1>
					</div>
					
					<div class="sing-body">
						<p><i>Complete the form below to create a trade account on TradespeopleHub</i></p>
						<form method="post" id="signup" enctype="multipart/form-data"  onsubmit="return signup();">
								
						<input type="hidden" name="type" id="type" value="1">
						<?php
							// if(isset($_GET['userid'])){
							//  $referred_by = $_GET['userid'];
							// }else{
							// 	$referred_by = '';
							// }
							// if(isset($_GET['unique_id'])){
						 // 	$unique_id = $_GET['unique_id'];
							// }else{
							// 	$unique_id = '';
							// }
							// if(isset($_GET['user_type'])){
							//  $referred_type = $_GET['user_type'];
							// }else{
							// 	$referred_type = '';
							// }
						?>
							<!--<input type="hidden" name="referred_by"  value="<?php //echo $referred_by;?>">
							 <input type="hidden" name="unique_id"  value="<?php //echo $unique_id;?>">
							<input type="hidden" name="referred_type"  value="<?php //echo $referred_type;?>"> -->
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> First name * </label>  
									<div class="col-md-12">
										<input type="text" class="form-control input-lg" name="f_name" value="<?php echo ($step1)?$step1['f_name']:'';?>" id="f_name" required>	
									</div>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-md-12 control-label"> Last name *</label>  
									<div class="col-md-12">
									<input type="text" value="<?php echo ($step1)?$step1['l_name']:'';?>" class="form-control input-lg" name="l_name" id="l_name" required>	
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12 control-label"> Trading Name * </label>  
							<div class="col-md-12">
								<input type="text" class="form-control input-lg" name="trading_name" value="<?php echo ($step1)?$step1['trading_name']:'';?>" id="trading_name" required>	
							</div>
						</div>
						<div class="search-address-section">
							<div class="form-group">
								<label class="col-md-12 control-label"> Search for your address </label>  
								<div class="col-md-12">
									<input type="text" class="form-control input-lg" name="search_address" value="" id="search_address" placeholder="Postcode or street address" required>	
									<div>
										<a href="javascript:void(0);" onclick="showManuallyAddress()" style="font-size: 16px;">Enter address manually</a>
										<br>
										<!--<span id="addressMsg" class="text-danger" style="display: none;"></span>-->
									</div>
								</div>
							</div>
						</div>
						<div class="manually-address-section" style="display: none;">
							<span id="addressMsg" class="text-danger" style="display: none;"></span>
							<div>
								<a href="javascript:void(0);" onclick="showSearchAddress()" style="font-size: 16px;">Search for the address</a>
							</div>
				            <div class="form-group">
				              <label class="col-md-12 control-label"> Postcode *</label> 
				              <div class="col-md-12">
				                <input type="text" placeholder="Postcode" id="postcode" value="<?php echo ($step1)?$step1['postal_code']:'';?>" name="postal_code" class="form-control input-lg" onblur="check_postcode();">

				               <input type="hidden" id="latitude" value="<?php echo ($step1)?$step1['latitude']:'';?>" name="latitude" class="form-control input-lg">

				               <input type="hidden" id="longitude" value="<?php echo ($step1)?$step1['longitude']:'';?>" name="longitude" class="form-control input-lg">

				                <p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
				              </div>
				            </div>

							<div class="form-group">
								<label class="col-md-12 control-label"> Town/City *</label>  
								<div class="col-md-12" style="margin-top: 5px;">
									<input type="text" value="<?php echo ($step1)?$step1['city']:'';?>" placeholder="Town/City" name="locality" id="e_city" class="form-control input-lg">
								</div>
							</div>
						
							
							
							<div class="form-group">
								<label class="col-md-12 control-label"> Address *</label>  
								<div class="col-md-12">
									<input type="text" name="e_address" id="geocomplete" class="form-control input-lg" value="<?php echo ($step1)?$step1['e_address']:'';?>" placeholder="Enter an address">
								</div>
							</div>
						</div>
						
						<!--<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="col-md-12 control-label"> County *</label>  
									<div class="col-md-12">
										<select class="form-control input-lg" required name="country" id="country11">
											<option value=""></option>
											
											<?php
											foreach($country as $key => $val){
												$selected = ($step1 && $step1['county'] == $val['region_name']) ? 'selected' : '';
												echo '<option '.$selected.' value="'.$val['region_name'].'">'.$val['region_name'].'</option>';
											}
											?>
										</select>
								
									</div>
								</div>
							</div>
							
						</div>-->
						
						<div class="form-group">
						  <label class="col-md-12 control-label" style="font-size:14px">How long are you willing to travel for work?</label>  
						  <div class="col-md-12">
								<select class="form-control input-lg" required name="distance" id="distance">
									<option <?php echo (!$step1)?'selected':'';?> value="">Please select</option>
									
									<option <?php echo ($step1 && $step1['max_distance']==5)?'selected':'';?> value="5">05 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==10)?'selected':'';?> value="10">10 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==15)?'selected':'';?> value="15">15 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==20)?'selected':'';?> value="20">20 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==25)?'selected':'';?> value="25">25 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==30)?'selected':'';?> value="30">30 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==35)?'selected':'';?> value="35">35 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==40)?'selected':'';?> value="40">40 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==45)?'selected':'';?> value="45">45 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==50)?'selected':'';?> value="50">50 Miles</option>
									<option <?php echo ($step1 && $step1['max_distance']==5000)?'selected':'';?> value="5000">More than 50 Miles</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12 control-label"> Phone number *</label>  
							<div class="col-md-12 input-group">
							<span class="input-group-addon">+44</span>
							<input type="text" class="form-control input-lg" name="phone_no" id="phone_no" value="<?php echo ($step1)?$step1['phone_no']:'';?>" required>
							</div>
						</div>	
						<div class="form-group">
						  <label class="col-md-12 control-label">Email *</label>  
						  <div class="col-md-12">
						  <input type="text" class="form-control input-lg" name="email" id="email" value="<?php echo ($step1)?$step1['email']:'';?>" required>
							<p class="text-danger email-err" style="display:none;">Please enter valid email address</p>
						  </div>
						</div>
						<div class="form-group" style="margin-bottom: 50px;">
						  <div class="col-md-6">
						  	<label class="control-label">Password *</label>  
						  <input type="password" class="form-control input-lg" name="password" id="password" required>
						  <p id="pass_content"></p>
						  </div>
						  <div class="col-md-6">
						  <label class="control-label">Confirm Password *</label>  
						  <input type="password" class="form-control input-lg" name="confirm_password" id="cnf_password" required>
						  <p id="cnf_err_content"></p>

						  
						  </div>
						  <br>
						</div>
						<div class="form-group">
			              	<label class="col-md-12 control-label"> Referral Code </label> 
			              	<div class="col-md-12">
			                	<input type="text" placeholder="If someone referred you, enter their code" id="referred_by" value="<?=$this->session->userdata('referred_by')?>" name="referred_by" class="form-control input-lg">
			                	<p class="text-danger reffer-err" style="display:none;">Wrong Referal Code</p>
			              	</div>
			            </div>
						
						<div class="form-group">
							<div class="col-md-12">
							<label for="checkboxes-0">
							  <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1" required>
							   I agree to the <a href="<?php echo base_url('terms-and-conditions'); ?>">Terms & Conditions</a>
							</label>
							</div>
						</div>
						<div class="term-acc">
							<label for="tncCheckbox0">
								<input type="checkbox" name="checkboxes1" id="checkboxes-1" value="1" required> I have read and understood the <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Notice</a> and <a href="<?php echo base_url('cookie-policy'); ?>">Cookie Policy</a>.
							</label>
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
<!-- <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsMVoMDDvhOfRet3mdorvpmTRErqVJd7c&libraries=places&callback=initAutocomplete">
</script> -->


<script type="text/javascript" src="<?php echo base_url(); ?>js/address_search.js"></script>
<script>
    var options = {
        //key: 'FE94-PT27-TC96-DA52', // 'JG55-UR47-XY47-TT22',
        key: '<?php echo $settings[0]['search_api_key']; ?>',
        search: { countries: 'GB' },
        manualEntryItem: true,
    }
    var fields = [
        { field: "Search", element: "search_address", mode: pca.fieldMode.SEARCH },
        { field: "Line1", element: "geocomplete", mode: pca.fieldMode.POPULATE  },
       // { field: "Line2", element: "questions_line2", mode: pca.fieldMode.POPULATE },
        { field: "City", element: "e_city", mode: pca.fieldMode.POPULATE },
        { field: "PostalCode", element: "postcode", mode: pca.fieldMode.POPULATE },
       // { field: "Id", element: "questions_addressId", mode: pca.fieldMode.POPULATE },
    ];
    var control = new pca.Address(fields, options);
    control.listen("load", function() {
        initManualToggle()
    })

    function initManualToggle() {
        var DATA_ATTR = 'data-address-mode';
        console.log("call initi");
        // var manualBtn = document.getElementById('js-manual-entry-btn');
        // var searchBtn = document.getElementById('js-search-entry-btn');
        // var manualAddressToggle = document.getElementById('js-address-manual-toggle');
        // var radiusInput = document.getElementById('js-radius-input');

        // radiusInput.classList.add('is-hidden');
   
        console.log("call initi 2");
        /*function showRadiusInput() {
            radiusInput.classList.remove('is-hidden')
        }
        var isListeningToPostCodeInput = false;
        function listenForPostCodeInput() {
            if( isListeningToPostCodeInput ) return;
            document.getElementById('questions_postcode').addEventListener('input', function(e) {
                console.log('event')
                if (e.target.value.length >= 5) {
                  showRadiusInput();
                }
            });
            isListeningToPostCodeInput = true;
        }

        function manualMode() {
            manualAddressToggle.setAttribute(DATA_ATTR, 'manual');
            listenForPostCodeInput();
        }
        function searchMode() {
            manualAddressToggle.setAttribute(DATA_ATTR, 'search');
        }
        function filledMode() {
            manualAddressToggle.setAttribute(DATA_ATTR, 'filled');
              console.log("filledd");
            showRadiusInput();
        }

        if (manualAddressToggle.getElementsByClassName('error').length > 0 || document.getElementById('questions_line1').value !== '') {
            filledMode();
        } else {
            searchMode();
        }*/

        control.listen('manual', function() {
            console.log("call manual");
            showManuallyAddress();
        })
        control.listen("populate", function() {
           console.log("call populate");
            $(".manually-address-section").show();
		  	$(".manually-address-section a").hide();
		  	$(".search-address-section a").hide();
		  	check_postcode();
        });

        // manualBtn.addEventListener('click', function(e) {
        //     e.preventDefault();
        //     manualMode();
        // })
        // searchBtn.addEventListener('click', function(e) {
        //     e.preventDefault();
        //     searchMode();
        // })

    };

    function showManuallyAddress() {
		$(".search-address-section").hide()
		$(".manually-address-section").show();
		$("input[name='search_address']").removeAttr("required");
		$("input[name='postal_code']").addAttr("required");
		$("input[name='locality']").addAttr("required");
		$("input[name='e_address']").addAttr("required");
	}

	function showSearchAddress() {
		$(".manually-address-section").hide();
		$(".search-address-section").show();
		$("input[name='search_address']").addAttr("required");
	}
</script>



<script>
function check_postcode(){
	var postcode = $("#postcode").val();
	$.ajax({
		type:'POST',
		url:site_url+'home/check_postcode',
		data:{post_code:postcode},
		dataType:'JSON',
		beforeSend:function(){
			$('.postcode-err').hide();
		},
		success:function(res){
			if(res.status==1){
				//console.log(res);
				$('#latitude').val(res.latitude);
				$('#longitude').val(res.longitude);

				$('.postcode-err').hide();
			} else {
				$('.postcode-err').show();
				$('#postcode').focus();
			}
		}
	});
	return false;
}

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

   // var special = /[!@#$%^&*_=+-]/g;
   // if (myInput.value.match(special)) { spec = true; } else {
   // 		spec = false;
   // }

	if (myInput.value.length >= 6) { 
		len = true;
	} else {
		len = false;
	}

	if(lower==false || upper==false || number==false || len==false){
	  document.getElementById("pass_content").style.display = "block";
	 // err_text_msg = "Must contain atleast 6 characters with atleast one lowercase, uppercase and special character."; 
		err_text_msg = "Must contain at least 6 characters with at least one lowercase, uppercase and number.";
		$('#pass_content').text(err_text_msg);
	  return false;
	}else{
	  err_text_msg='';
	  document.getElementById("pass_content").style.display = "none";
	}

	var postcode = $('#postcode').val();
	if(postcode == ""){
		$('#addressMsg').html('You must enter address manually');
		$('#addressMsg').show();
		$(".search-address-section").hide()
		$(".manually-address-section").show();

		$("#postcode").prop('required',true);
		$("#e_city").prop('required',true);
		$("#geocomplete").prop('required',true);

		
		$('html, body').animate({
	        scrollTop: $('.manually-address-section').offset().top
	    }, 'slow');

		return false;
	}

	$.ajax({
		type:'POST',
		url:site_url+'home/submit_signup',
		data:$('#signup').serialize(),
		dataType:'JSON',
		beforeSend:function(){
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.email-err').hide();
			$('.signup_btn').prop('disabled',true);
			$('.msg').html('');
		},
		success:function(resp){
			if(resp.status==1){
				window.location.href = site_url+'signup-step2';
			} else if(resp.status==2) {
				
				$('.postcode-err').show();
				$('#postcode').focus();
				
				
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
				
			}else if(resp.status==10) {
				
				$('.reffer-err').show();
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
				
			} else if(resp.status==3){
				$('.email-err').show();
				$('#email').focus();
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
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

<?php include ("include/footer.php") ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#country11').select2({
		placeholder: "Select county",
	});
});
</script>