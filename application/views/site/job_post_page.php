<?php include ("include/header.php") ?>
<?php
if(isset($user_data) && $user_data['type']==1){
	redirect('dashboard');
}
$check_budget = $this->common_model->get_single_data('show_page',array('id'=>2));
$show_buget = 1;
if($check_budget && $check_budget['status']==0){
	$show_buget = 0;
}
?>
<!-- how-it-work -->
<style type="text/css">
	html {
  scroll-behavior: smooth;
}
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}

.select2.select2-container.select2-container--default {
	width: 100% !important;
}
</style>
<style type="text/css">
	#pass_content{ color: red; }
	#cnf_err_content{ color: red; }
</style>
<div class="post_jobs">
	<div class="top-hand">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="set-hand">
						<img src="<?php echo base_url(); ?>img/hand-tools.png">
						<div class="hand-text">
							<h1>Get Quotes from local Tradespeople</h1>
							<p>Fill out the form below. It only takes around two minutes!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<form id="post_jobs" method="post" class="">	
					<div  id="job_post">
						<div class="">
							<div class="add-space"></div>
							<div class="row">
								<div class="col-sm-12">	
									<div class="login-box" id="div_1">
										<div class="form-group" style="margin-bottom:0px;">
											<label class="col-md-12 control-label"> <b>What type of tradesperson or service are you looking for? </b></label>  
											<div class="col-md-12">
												<select data-placeholder="Select Category" class="form-control input-lg" name="category" id="category" onchange="return changecategory(this.value)">
													<option value="">Pick Category</option>
													<?php foreach($category as $row) { ?>
													<option value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="add-space"></div>
									<div class="login-box" id="div_2" style="display: none;">	
										<div class="form-group">
											<label class="col-md-12 control-label"> <b id="cate_level_1">What would you like to have done? </b></label>  
											<div class="col-md-12">
												<div id="subcategories"></div>
											</div>
										</div>
									</div>
									
									<div class="add-space"></div>
									<div class="login-box" id="div_9" style="display: none;">	
										<div class="form-group">
											<label class="col-md-12 control-label"> <b id="cate_level_2"></b></label>  
											<div class="col-md-12">
												<div id="subcategories_1"></div>
											</div>
										</div>
									</div>
									
									<div class="add-space"></div>
									<div class="login-box" id="div_10" style="display: none;">	
										<div class="form-group">
											<label class="col-md-12 control-label"> <b id="cate_level_3"></b></label>  
											<div class="col-md-12">
												<div id="subcategories_2"></div>
											</div>
										</div>
									</div>
									<div class="add-space"></div>
									<div class="login-box" id="div_3" style="display: none;">
										<div class="form-group">
											<label class="col-md-12 control-label"> <b>Give some details about the job </b></label>  
											<div class="col-md-12">
												<p>Please give a description of the job you want doing including detail of any materials you need the tradesman to supply, the condition of any repair/replacement work, etc.</p>
												<textarea class="form-control input-lg" name="description" id="description" rows="8"></textarea> 
												<div class="msg alert alert-danger" style="display:none; margin-top:10px;"> Please give some details about the job.
												</div>
												<div class="msg1-11 alert alert-danger" style="display: none; margin-top:10px;">Please do not enter contact information here.</div>
											</div>			
										</div>
										<div class="form-group ">
											<div class="col-md-12">
												<label class=" control-label"><b> Upload Files </b> </label>  
												
												<div class="row uuss_rowws adde_more_ddiv">
													
													<div class="col-sm-3">
														<div class="image_uplod1">
															<img src="<?php echo site_url(); ?>/img/icon_us2.png" class="tradup_img1">
															<input type="file" onchange="preview_image();" name="post_doc[]" accept="image/*" id="post_doc" class="uplldui">
														</div>
													</div>
												</div>
												
											</div>
										
											
										</div>	
											
										<div class="form-group" style="margin-bottom:0px;">
											<label class="col-md-12 control-label">  <a href="#div_4"><button type="button" id="next" class="btn btn-primary btn-lg">Next </button></a></label>  	
										</div>
									</div>
			
									<div class="add-space"></div>
									<div class="login-box" id="div_4" style="display: none;">
										<div class="form-group">
											<label class="col-md-12 control-label"> <b>Give your job a headline </b></label>  
											<div class="col-md-12"><p>More tradespeople express interest in jobs that have a descriptive name.</p>
												<input type="text" class="form-control input-lg" name="title" id="title">	
												<div class="msg1 alert alert-danger" style="display: none; margin-top:10px;">Please give title to your job.</div>
												
											</div>				
										</div>
										<div class="form-group" style="margin-bottom:0px;">
											<label class="col-md-12 control-label">  <a href="#div_5"><button type="button" id="next1" class="btn btn-primary  btn-block btn-lg" style="width: 200px;" >Next </button></a></label>  	
										</div>		
									</div>
			
									<div class="add-space"></div>
									<div class="login-box" id="div_5" style="display: none;">
										<div class="form-group">
											<label class="col-md-12 control-label"> <b>Postcode for the job </b></label> 
											<div class="col-md-12">
											<p>To find conservatory installers near you we need to know where the job is.</p> 
												<input type="text" class="form-control input-lg" name="post_code" id="post_code">	
												<div class="msg2 alert alert-danger" style="display: none; margin-top:10px;">Please provide postcode.</div>
												<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
											</div>			
										</div>
										<div class="form-group" style="margin-bottom:0px;">
											<label class="col-md-12 control-label">  <a id="next2" class="btn btn-primary   btn-block btn-lg" style="width: 200px;" href="#div_6">Next </a></label>  	
										</div>		
									</div>
			
									<div class="add-space"></div>
									<div class="login-box" id="div_6" style="display: none;">
										<div class="form-group">
											<label class="col-md-12 control-label"> <b>What's your estimated budget? </b></label>
											<div class="col-sm-12">
											<p style="margin-top: 10px;">Please let us know your maximum budget for the job. Don't worry, you're not committing to anything here but bear in mind that more tradesman are likely to give you a quote if you give a reasonable budget for the job.</p> 
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('user_id') ?>">			
											</div>
										</div>
										<div class="form-group" style="margin-bottom:0px;">
											<div class="col-sm-12">
												
												<?php
												$admin_amounts = $this->common_model->newgetRows('job_amount',null,'amount1','asc');
												if(!empty($admin_amounts)){
												foreach($admin_amounts as $key => $value){
												?>
												
												<div class="radio-how">
													<label class="col-md-12"> 
														<input type="radio" name="budget" id="budget<?php echo $value['amount1']; ?>" value="<?php echo $value['amount1']; ?>" onchange="return changebudget($(this).val(),<?php echo $value['amount2']; ?>)"> £<?php echo $value['amount1']; ?> - £<?php echo $value['amount2']; ?><span class="outside"><span class="inside"></span></span>
													</label>
												</div>
												
												<?php } ?>
												<?php } ?>
												
												<input type="hidden" name="static_amount2" id="static_amount2">
												
												<div class="radio-how ">
													<label class="col-md-12"> 
														<input type="radio" name="budget" id="budgetCustom" value="Custom" onchange="return changebudget('Custom')"> Custom Budget<span class="outside"><span class="inside"></span></span>
													</label>
												</div>
												
											</div>  	
										</div>						
									</div>
					
									<div class="login-box" id="div_8" style="display: none;">
									
										<div class="form-group">
											<label>Custom Budget</label>
											<input type="number" min="500" class="form-control" name="custom_budget" id="custom_budget">
											<p class="text-danger" id="custom_budget_error" style="display:none;"></p>
										</div>
										<div class="form-group">
											<label>Custom Budget</label>
											<input type="number" min="500" class="form-control" name="custom_budget2" id="custom_budget2">
											<p class="text-danger" id="custom_budget_error2" style="display:none;"></p>
										</div>
								
								
										<div class="form-group" style="margin-bottom:0px;">
											<label class="col-md-12 control-label">  <a href="#div_7"><button type="button" id="next3" class="btn btn-primary  btn-block btn-lg" style="width: 200px;" >Next </button></a></label>  	
										</div>
									</div>
			
								</div>
			
							</div>
						</div>
					</div>
					<div class="add-space"></div>
					<div id="div_7" style="display: none;">
						<?php if($this->session->userdata('user_id')){ ?>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<button type="submit" class="btn btn-warning btn-lg post_btn" id="buttonpost">Post a Job</button>
								
								</div>
							</div>
						</div>
						<?php }else{ ?>
						<div class="login-box">
							<div class="row">
								<div class="col-sm-12">
									<h1 style="margin-top:0px;text-align: center;margin-bottom: 24px;font-size: 22px;">Create a new account</h1>

									<div class="msgs"><?= $this->session->flashdata('msg'); ?></div>			
				
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-md-12 control-label"> First name * </label>  
												<div class="col-md-12">
													<input type="text" class="form-control input-lg" name="f_name" id="f_name">	
												</div>
											</div>
										</div>
				
				
										<div class="col-sm-6">
											<div class="form-group">
												<label class="col-md-12 control-label"> Last name *</label>  
												<div class="col-md-12">
													<input type="text" class="form-control input-lg" name="l_name" id="l_name">	
												</div>
											</div>
										</div>
									</div>
									
									<div class="form-group con-drop">
										<label class="col-md-12 control-label"> Phone number *</label>  
										<div class="col-md-12 input-group">
											<span class="input-group-addon">+44</span>
											<input type="text" class="form-control input-lg" name="phone_no" id="phone_no">
										</div>
									</div>	
				
									<div class="form-group">
										<label class="col-md-12 control-label">Email *</label>  
										<div class="col-md-12">
											<input type="text" class="form-control input-lg" name="email1" id="email1">
										</div>
									</div>
				
									<input type="hidden" name="account"  id="account" value="1">
									<!-- <div class="form-group">
										<label class="col-md-12 control-label">Password *</label>  
										<div class="col-md-12">
											<input type="password" class="form-control input-lg" name="password1" id="password1">
										</div>
									</div> -->

									<div class="row form-group">
									  <div class="col-md-6">
									  	<label class="control-label">Password *</label>  
									  	<input type="password" class="form-control input-lg" name="password1" id="password1">
									  <p id="pass_content"></p>
									  </div>
									  <div class="col-md-6">
									  <label class="control-label">Confirm Password *</label>  
									  <input type="password" class="form-control input-lg" name="confirm_password" id="cnf_password" required>
									  <p id="cnf_err_content"></p>
									  </div>
									  <br>
									</div>




									
									<div class="row form-group">
										<div class="col-md-12">
										<label for="checkboxes-0">
											<input type="checkbox" name="checkboxes" id="checkboxes-0" value="1" required>
											 I agree to the <a href="<?php echo base_url('terms-and-conditions'); ?>">Terms & Conditions</a>
										</label>
										</div>
									</div>
									<div class="term-acc">
										<label for="tncCheckbox0">
											<input type="checkbox" name="checkboxes" id="tncCheckbox" value="1" required>
										</label> I have read and understood the <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Notice</a> and <a href="<?php echo base_url('cookie-policy'); ?>" >Cookie Policy</a>.
									</div>
				
									<div class="col-md-12 nopadding">
										<button type="submit" class="btn btn-warning btn-lg signup_btn" id="buttonsub">Save and Continue</button>
								
									</div>
									<div class="term-acc" >
										<p style="margin-top: 10px;">I already have an account, <a href="#login">sign in here.</a></p>
									</div>
								</div>			
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="add-space"></div>
					<div class="" id="login" style="display: none;">
						<div class="login-box">
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-12">
										<div class="msgss"><?= $this->session->flashdata('msg'); ?></div>
										<h1 style="margin-top:0px;text-align: center;margin-bottom: 24px;font-size: 22px;">Login</h1>	
									</div>
									<div class="row nomargin" >
										<div class="col-sm-12">
										<div class="form-group">
											<div class="">							
												<input class="form-control input-lg" type="hidden" id="job_id" name="job_id" value="">
												<input class="form-control input-lg" type="text" placeholder="Email" name="email" id="email">
											</div>	
											</div>
										</div>
									</div>
									
									<div class="row nomargin ">
										<div class="col-sm-12">
										<div class="form-group">
											<div class="">							
												<input class="form-control input-lg" type="password" placeholder="Password" name="password" name="password">
											</div>	
											</div>
										</div>
									</div>
									<div class="row nomargin">
										<div class="col-sm-12">
										<div class="form-group">
											<div class=" text-center">
												<button type="submit" class="btn btn-warning  btn-lg login_btn" id="loginbtn">Save and Continue </button>
											</div>	
																
												<a href="<?php echo base_url('forgot-password'); ?>" class="for-link">Need help logging in?</a>
												<a href="#div_7" class="for-link"><span style="float: right;">Create an account?</span></a>
											</div>
										</div>
									</div>		
								</div>	
							</div>			
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script type="text/javascript">
	$(function () {
        $(".signup_btn").click(function () {
            var password = $("#password1").val();
            var confirmPassword = $("#cnf_password").val();
            if (password != confirmPassword) {
                $('#cnf_err_content').text("Passwords do not match.");
                return false;
            }
             $('#cnf_err_content').text("");

            return true;
        });
    });


</script>
<script>
var show_buget = <?php echo $show_buget; ?>;
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		menubar: false,
		branding: false,
		statusbar: false,
		height:250,
		plugins: [ 
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}
/*$(function(){
	
	$("#geocomplete").geocomplete({
		details: "form",
		types: ["geocode", "establishment"],
	});
	$("#find").click(function(){
	  $("#geocomplete").trigger("geocode");
	});
});*/
</script>
<script>

$('a[href^="#"]').on('click', function(event) {
    var target = $(this).attr('href');
    $('#login'+target).toggle();
    $("#div_7").hide();

});
$('a[href^="#div_7"]').on('click', function(event) {
    var target = $(this).attr('href');
    $('#div_7'+target).toggle();
    $("#login").hide();


});
function changecategory(val){
	
	//$("html, body").animate({ scrollTop: $(document).height() }, 10);	
	$.ajax({
		url:site_url+'home/get_subcategories',
		type:"POST",
		dataType:'json',
		data:{'val':val},
		success:function(datas){
			$("#div_9").hide();
			$("#div_10").hide();
			if(datas.status==1){

				$('#subcategories').html(datas.subcategory);
				$('#cate_level_1').html(datas.label);
				$("#div_2").show();
				window.location.href="#div_2";
				hide_other_by_cate();
			} else {
				$("#div_2").hide();
				window.location.href="#div_3";
				$("#div_3").show();
			}
			return false;
		}
	});
	return false;
}

function changesub(val)
{
 if($('#subcategory'+val).is(':checked')) { 
 		//window.location.href="#div_3";
		//$("#div_3").show(); 
		
		$.ajax({
			url:site_url+'home/get_subcategories_sub2',
			type:"POST",
			dataType:'json',
			data:{'val':val},
			success:function(datas){
				$("#div_10").hide();
				if(datas.status==1){
					$('#subcategories_1').html(datas.subcategory);
					$('#cate_level_2').html(datas.label);
					$("#div_9").show();
					window.location.href="#div_9";
					hide_other_by_cate();
				} else {
					$("#div_9").hide();
					window.location.href="#div_3";
					$("#div_3").show();
				}
				return false;
			}
		});
	}
}
function changesub_sub(val)
{
 if($('#subcategory_sub'+val).is(':checked')) { 
		$("#div_3").show();
		window.location.href="#div_3";
		
		/*
		$.ajax({
			url:site_url+'home/get_subcategories_sub3',
			type:"POST",
			dataType:'json',
			data:{'val':val},
			success:function(datas){
				if(datas.status==1){
					$('#subcategories_2').html(datas.subcategory);
					$('#cate_level_3').html(datas.label);
					$("#div_10").show();
					window.location.href="#div_10";
					hide_other_by_cate();
				} else {
					$("#div_10").hide();
					window.location.href="#div_3";
					$("#div_3").show();
				}
				return false;
			}
		});
		*/
	}
}

function changesub_sub_sub(val)
{
 if($('#subcategory_sub_sub'+val).is(':checked')) { 
		window.location.href="#div_3";
		$("#div_3").show();
	}
}

function hide_other_by_cate(){
	$("#div_3").hide();
	$("#div_4").hide();
	$("#div_5").hide();
	if(show_buget==1){
	$("#div_6").hide();
	$("#div_8").hide();
	}
	$("#div_7").hide();
}
 $("#next").click(function () {
	if ($("#description").val()) {
		$(".msg").hide();
		$.ajax({
			type:'POST',
			url:site_url+'posts/check_contact_info',
			data:{description:$("#description").val()},
			async:false,
			beforeSend:function(){
				$(".msg1-11").hide();
			},
			success:function(res){
				if(res==1){
					window.location.href="#div_4";
					$("#div_4").show();
					//$("html, body").animate({ scrollTop: $(document).height() }, 10);
					$("#next").hide();
				} else {
					$(".msg1-11").show();
				}
			}
		});
	} else {
		$(".msg1-11").hide();
		$(".msg").show();
	}
});
  $("#description").click(function () {
	$("#next").show();
        });

 $("#next1").click(function () {
    if ($("#title").val()) 
    {
    	window.location.href="#div_5";
   	$("#div_5").show();
	//$("html, body").animate({ scrollTop: $(document).height() }, 10);
	$(".msg1").hide();
	$("#next1").hide();
	}
	else
	{
		$(".msg1").show();
	}

        });
  $("#title").click(function () {
  	   
	$("#next1").show();
        });

$("#next2").click(function () {
	var post_code = $("#post_code").val();
	if (post_code) {
		
		$.ajax({
			type:'POST',
			url:site_url+'home/check_postcode',
			data:{post_code:post_code},
			dataType:'JSON',
			beforeSend:function(){
				$('.postcode-err').hide();
			},
			success:function(res){
				if(res.status==1){
					
					if(show_buget==1){
						window.location.href="#div_6";
						$("#div_6").show();
					} else {
						$("#div_7").show();
						window.location.href="#div_7";
					}
					//$("html, body").animate({ scrollTop: $(document).height() }, 10);
					$(".msg2").hide();
					$("#next2").hide();
					$('.postcode-err').hide();
					
					
				} else {
					$('.postcode-err').show();
					$("#div_6").hide();
					$("#div_7").hide();
					$("#login").hide();
				}
			}
		});
		return false;
			
	} else {
		$(".msg2").show();
	}
	
	
});
$("#post_code").click(function () {
	$("#next2").show();
});

$("#next3").click(function () {
		
	var custom_budget = parseFloat($('#custom_budget').val());
	var custom_budget2 = parseFloat($('#custom_budget2').val());
	
	var check = true;
		
	if(custom_budget){
		$('#custom_budget_error').hide();
	} else {
		$('#custom_budget_error').html('Enter budget amount');
		$('#custom_budget_error').show();
		return false;
		check = false;
	}	
	
	if(custom_budget >= 500){
		$('#custom_budget_error').hide();
	} else {
		$('#custom_budget_error').html('Budget can not be less than £500.');
		$('#custom_budget_error').show();
		return false;
		check = false;
	}
	
	if(custom_budget2){
		
		$('#custom_budget_error2').hide();
	} else {
		$('#custom_budget_error2').html('Enter budget amount');
		$('#custom_budget_error2').show();
		return false;
		check = false;
	}
	
	if(custom_budget2 > custom_budget){
		
		$('#custom_budget_error2').hide();
	} else {
		$('#custom_budget_error2').html('First amount can not be more than second amount!');
		$('#custom_budget_error2').show();
		return false;
		check = false;
	}
	
	if (check) {
   	$("#div_7").show();
		window.location.href="#div_7";
		//$("html, body").animate({ scrollTop: $(document).height() }, 10);
		$("#next3").hide();
	} else {
		$("#next3").show();
		$("#div_7").hide();
	}
});

function changebudget(val,amount2=null){
	
	if($('#budget'+val).is(':checked')) { 
	
		if($('#budget'+val).val()=='Custom'){
			$('#custom_budget').attr('required','required');
			$('#custom_budget2').attr('required','required');
			$("#div_8").show();
			$("#div_7").hide();
			window.location.href="#div_8";
		} else {
			$('#static_amount2').val(amount2);
			$('#custom_budget').removeAttr('required');
			$('#custom_budget2').removeAttr('required');
			$("#div_7").show();
			$("#div_8").hide();
			window.location.href="#div_7";
		}
	
 	
	//$("html, body").animate({ scrollTop: $(document).height() }, 10);	 
	}
}

</script>
<script>
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
function getcity(val)
{
	$.ajax({
			url:site_url+'home/get_city',
			type:"POST",
			dataType:'json',
			data:{'val':val},
			success:function(datas)
			{
			
		   $('#city').html(datas.cities);
	
				return false;
			}
	});
	return false;
	
}
$('#buttonsub').on('click',function(){
	
	var budget_type = $('input:radio[name="budget"]:checked').val();
	
	if(budget_type=='Custom'){
		var custom_budget = $('#custom_budget').val();
		
		if(!custom_budget){
			$('#custom_budget').focus();
			$('#custom_budget_error').html('Enter budget amount');
			$('#custom_budget_error').show();
			return false;
		}
		
	}
	
	var account=$("#account").val('1');




	var err_text_msg='';
var lower;
var upper;
var number;
// var spec;
var len;


var myInput = document.getElementById("password1");

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
	// err_text_msg = "Must contain atleast 6 characters with atleast one lowercase, uppercase and special character."; 
	err_text_msg = "Must contain at least 6 characters with at least one lowercase, uppercase and number."; 

	$('#pass_content').text(err_text_msg);
  	return false;

}else{
  err_text_msg='';
  document.getElementById("pass_content").style.display = "none";
}











		$.ajax({
		type:'POST',
		url:site_url+'posts/job_a_post',
		data: new FormData($('#post_jobs')[0]),
		dataType: 'JSON',
        processData: false,           
        contentType: false,
        cache: false,
		beforeSend:function (){
			$('.signup_btn').prop('disabled',true);
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			$('.msgs').html('');
			$('.postcode-err').hide();
		},
		success:function(resp){
			if(resp.status==1){

				
				//window.location.href = site_url+'proposals?post_id='+resp.job_id;
				window.location.href = site_url+'email-verify';
			} else if(resp.status==2){
				$('.postcode-err').show();
				$('#post_code').focus();
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
			} else if(resp.status==3){
				
				window.location.href="#div_3";
				$('.msg1-11').show();
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);	
			} else {
				$('.msgs').html(resp.msg);
				$('.signup_btn').html('Save and Continue');
				$('.signup_btn').prop('disabled',false);
		
			}
		}
	});
	return false;

 });
$('#loginbtn').on('click',function(){

	var budget_type = $('input:radio[name="budget"]:checked').val();
	
	if(budget_type=='Custom'){
		var custom_budget = $('#custom_budget').val();
		
		if(!custom_budget){
			$('#custom_budget').focus();
			$('#custom_budget_error').html('Enter budget amount');
			$('#custom_budget_error').show();
			return false;
		}
		
	}
	var account=$("#account").val('2');

		$.ajax({
		type:'POST',
		url:site_url+'posts/job_a_post',
		data: new FormData($('#post_jobs')[0]),
		dataType: 'JSON',
        processData: false,           
        contentType: false,
        cache: false,
		beforeSend:function (){
			$('.login_btn').prop('disabled',true);
			$('.login_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			$('.msgss').html('');
			$('.postcode-err').hide();
		},
		success:function(resp){
			if(resp.status==1){

					window.location.href = site_url+'proposals?post_id='+resp.job_id;
			} else if(resp.status==2){
				$('.postcode-err').show();
				$('#post_code').focus();
				$('.login_btn').html('Save and Continue');
				$('.login_btn').prop('disabled',false);
			} else if(resp.status==3){
				
				window.location.href="#div_3";
				$('.msg1-11').show();
				$('.login_btn').html('Save and Continue');
				$('.login_btn').prop('disabled',false);	
			} else {
				$('.msgss').html(resp.msg);
				$('.login_btn').html('Save and Continue');
				$('.login_btn').prop('disabled',false);
		
			}
		}
	});
	return false;

 });
$('#buttonpost').on('click',function(){
	
	var budget_type = $('input:radio[name="budget"]:checked').val();
	
	if(budget_type=='Custom'){
		var custom_budget = $('#custom_budget').val();
		
		if(!custom_budget){
			$('#custom_budget').focus();
			$('#custom_budget_error').html('Enter budget amount');
			$('#custom_budget_error').show();
			return false;
		}
		
	}
	var account=$("#account").val('0');

		$.ajax({
		type:'POST',
		url:site_url+'posts/job_a_post',
		data: new FormData($('#post_jobs')[0]),
		dataType: 'JSON',
        processData: false,           
        contentType: false,
        cache: false,
		beforeSend:function (){
			$('.post_btn').prop('disabled',true);
			$('.post_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			$('.msgss').html('');
			$('.postcode-err').hide();
		},
		success:function(resp){
			if(resp.status==1){

					window.location.href = site_url+'proposals?post_id='+resp.job_id;
			} else if(resp.status==2){
				$('.postcode-err').show();
				$('#post_code').focus();
				$('.post_btn').html('Post a Job');
				$('.post_btn').prop('disabled',false);
			} else if(resp.status==3){
				
				window.location.href="#div_3";
				$('.msg1-11').show();
				$('.post_btn').html('Post a Job');
				$('.post_btn').prop('disabled',false);
			} else {
				$('.post_btn').html('Post a Job');
				$('.post_btn').prop('disabled',false);
		
			}
		}
	});
	return false;



 });
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#countryus2').select2();
});

var file_no = 1;

function preview_image() 
{
 var total_file=document.getElementById("post_doc").files.length;
 
 file_no++;
 for(var i=0;i<total_file;i++) {
  //$('.adde_more_ddiv').append("<br>");
	
  var reader = new FileReader();
  reader.onload = function(r) {
    console.log('RESULT', reader.result);
		//var test = reader.result;
		var upload_file_name = false;
		
		$.ajax({
			type:'POST',
			url:site_url+'posts/save_image_for_post_job',
			data: {post_doc:reader.result},
			dataType: 'JSON',
			async:false,
			success:function(resp){
				if(resp.status==1){
					
					upload_file_name = resp.name;
					
				} else {
					
					alert('Something went wrong try again later!');
					return false;
				}
			}
		});
		
		$('.adde_more_ddiv').prepend('<div class="col-sm-3 adde_more_loop'+file_no+'"><div class="image_uplod1"><img class="tradup_img2" src="'+r.target.result+'"><input type="hidden" name="post_doc[]" value="'+upload_file_name+'"><div class="btttponm_psuiui"><button type="button" onclick="$(\'.adde_more_loop'+file_no+'\').remove();" class="btn btn-danger ">X</button></div></div></div>');
  }
	reader.readAsDataURL(event.target.files[i]);
	
	//	var test = encodeImageFileAsURL(event.target.files[i]);
	
 
 }
}	
</script>