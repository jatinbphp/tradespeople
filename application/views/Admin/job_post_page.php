<?php include ("include/header.php") ?>
<?php
if(isset($user_data) && $user_data['type']==1){
	redirect('dashboard');
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
.form-rounded {
border-radius: 1rem;
}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Post a job</h1>
		<ol class="breadcrumb">
		  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		  <li class="active">Post a job</li>
		</ol>
		<?=$this->session->flashdata('responseMessage');?>
	</section>
	<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<form id="post_jobs" method="post" class="">
				<div class="panel-group">
					<div class="panel panel-default" id="div_1">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group" style="margin-bottom:0px;">
									<label class="col-md-12 control-label"> <b>What would you like to have done? </b></label>  
									<div class="col-md-8">
										<select data-placeholder="Select Category" class="form-control input-lg form-rounded" name="category" id="category" onchange="return changecategory(this.value)">
											<option value="">Pick Category</option>
											<?php foreach($category as $row) { ?>
											<option value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_2" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group">
									<label class="col-md-12 control-label"> <b id="cate_level_1">What would you like to have done? </b></label>  
									<div class="col-md-12">
										<div id="subcategories"></div>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_9" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">	
								<div class="form-group">
									<label class="col-md-12 control-label"> <b id="cate_level_2"></b></label>  
									<div class="col-md-12">
										<div id="subcategories_1"></div>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_10" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group">
									<label class="col-md-12 control-label"> <b id="cate_level_3"></b></label>  
									<div class="col-md-12">
										<div id="subcategories_2"></div>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_3" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12 control-label"> <b>Give some details about the job </b></label>  
										<div class="col-md-12">
											<p>Please give a description of the job you want doing including detail of any materials you need the tradesman to supply, the condition of any repair/replacement work, etc.</p>
											<textarea class="form-control input-lg textarea form-rounded" name="description" id="description" rows="6"></textarea> 
											<div class="msg alert alert-danger" style="display:none; margin-top:10px;"> Please give some details about the job.
											</div>
											<div class="msg1-11 alert alert-danger" style="display: none; margin-top:10px;">Please do not enter contact information here.</div>
										</div>			
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12 control-label"><b>Upload Files </b> </label>  
										<div class="col-md-12">
										<input type="file" name="post_doc[]" id="post_doc" multiple>
										</div>
									</div>
								</div>
								<div class="col-md-12" style="margin-top:10px;">
									<div class="form-group" style="margin-bottom:0px;">
										<label class="col-md-12 control-label">  <a href="#div_4"><button type="button" id="next" class="btn btn-primary btn-lg">Next </button></a></label>  	
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_4" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12 control-label"> <b>Give your job a headline </b></label>  
										<div class="col-md-12"><p>More tradespeople express interest in jobs that have a descriptive name.</p>
											<input type="text" class="form-control input-lg form-rounded" name="title" id="title">	
											<div class="msg1 alert alert-danger" style="display: none; margin-top:10px;">Please give title to your job.</div>
											
										</div>				
									</div>
								</div>
								<div class="col-md-12" style="margin-top:10px;">
									<div class="form-group" style="margin-bottom:0px;">
										<label class="col-md-12 control-label">  <a href="#div_5"><button type="button" id="next1" class="btn btn-primary  btn-block btn-lg" style="width: 200px;" >Next </button></a></label>  	
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_5" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12 control-label"> <b>Postcode for the job </b></label> 
										<div class="col-md-6">
										<p>To find conservatory installers near you we need to know where the job is.</p> 
											<input type="text" class="form-control input-lg form-rounded" name="post_code" id="post_code">	
											<div class="msg2 alert alert-danger" style="display: none; margin-top:10px;">Please provide postcode.</div>
											<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
										</div>			
									</div>
								</div>
								<div class="col-md-12" style="margin-top:10px;">
									<div class="form-group" style="margin-bottom:0px;">
										<label class="col-md-12 control-label">  <a id="next2" class="btn btn-primary   btn-block btn-lg" style="width: 200px;" href="#div_6">Next </a></label>  	
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_6" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
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
										$admin_amounts = $this->Common_model->newgetRows('job_amount',null,'amount1','asc');
										if(!empty($admin_amounts)){
										foreach($admin_amounts as $key => $value){
										?>
										
										<div class="radio-how">
											<label class="col-md-5"> 
												<input type="radio" name="budget" id="budget<?php echo $value['amount1']; ?>" value="<?php echo $value['amount1']; ?>" onchange="return changebudget($(this).val(),<?php echo $value['amount2']; ?>)"> £<?php echo $value['amount1']; ?> - £<?php echo $value['amount2']; ?><span class="outside"><span class="inside"></span></span>
											</label>
										</div>
										
										<?php } ?>
										<?php } ?>
										
										<input type="hidden" name="static_amount2" id="static_amount2">
										
										<div class="radio-how">
											<label class="col-md-5"> 
												<input type="radio" name="budget" id="budgetCustom" value="Custom" onchange="return changebudget('Custom')"> Custom Budget<span class="outside"><span class="inside"></span></span>
											</label>
										</div>
										
									</div>  	
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="div_8" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-8">
									<div class="form-group">
										<label>Custom Budget</label>
										<input type="number" class="form-control form-rounded" name="custom_budget" id="custom_budget">
										<p class="text-danger" id="custom_budget_error" style="display:none;"></p>
									</div>
									<div class="form-group">
										<label>Custom Budget</label>
										<input type="number" class="form-control form-rounded" name="custom_budget2" id="custom_budget2">
										<p class="text-danger" id="custom_budget_error2" style="display:none;"></p>
									</div>
								</div>
								<div class="col-md-12" style="margin-top:10px;">
									<div class="form-group" style="margin-bottom:0px;">
										<label class="col-md-12 control-label">  <a href="#div_7"><button type="button" id="next3" class="btn btn-primary  btn-block btn-lg" style="width: 200px;" >Next </button></a></label>  	
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<!--<div class="panel panel-default" id="div_7" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group" style="margin-bottom:0px;">
									<label class="col-md-12 control-label"> <b>Please select a user </b></label>  
									<div class="col-md-12">
										<select data-placeholder="Select User" class="form-control input-lg" name="custom_user" id="custom_user">
											<option value="">Pick User</option>
											<?php foreach($users as $row) { ?>
											<option value="<?= $row['id']; ?>"> <?= $row['f_name']; ?> <?= $row['l_name']; ?> </option>
											<?php } ?>
										</select>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<button type="submit" class="btn btn-warning btn-lg post_btn" id="buttonpost">Post a Job</button>
												
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>-->
					<div class="panel panel-default" id="div_7" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<h3>Job Poster</h3>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label"> First name * </label>  
											<div class="col-md-12">
												<input type="text" class="form-control input-lg form-rounded" name="f_name" id="f_name">	
											</div>
										</div>
									</div>
			
			
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label"> Last name *</label>  
											<div class="col-md-12">
												<input type="text" class="form-control input-lg form-rounded" name="l_name" id="l_name">	
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label"> County *</label>  
											<div class="col-md-12">
												<input type="text" name="country" class="form-control form-rounded" value="">
											
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label"> Town/City *</label>  
											<div class="col-md-12" style="margin-top: 5px;">
												<input type="text" placeholder="City" name="locality" id="e_city" value="" class="form-control form-rounded" >
												
									
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="margin-top:10px;">
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" class="btn btn-warning btn-lg post_btn" id="buttonpost">Post a Job</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<!--<div class="panel panel-default" id="login" style="display: none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
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
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>-->
				</div>
			</form>
		</div>
	</div>
	</section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
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
		url:site_url+'Admin/home/get_subcategories',
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
			url:site_url+'Admin/home/get_subcategories_sub2',
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
	$("#div_6").hide();
	$("#div_7").hide();
	$("#div_8").hide();
}
 $("#next").click(function () {
	if ($("#description").val()) {
		$(".msg").hide();
		$.ajax({
			type:'POST',
			url:site_url+'Admin/posts/check_contact_info',
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
			url:site_url+'Admin/home/check_postcode',
			data:{post_code:post_code},
			dataType:'JSON',
			beforeSend:function(){
				$('.postcode-err').hide();
			},
			success:function(res){
				if(res.status==1){
					window.location.href="#div_6";
					$("#div_6").show();
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
		
	var custom_budget = $('#custom_budget').val();
	
	var check = true;
		
	if(custom_budget){
		
		$('#custom_budget_error').hide();
	} else {
		$('#custom_budget_error').html('Enter budget amount');
		$('#custom_budget_error').show();
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

function getcity(val)
{
	$.ajax({
			url:site_url+'Admin/home/get_city',
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
		$.ajax({
		type:'POST',
		url:site_url+'Admin/posts/job_a_post',
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
				window.location.href = site_url+'Admin/email-verify';
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
		url:site_url+'Admin/posts/job_a_post',
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

					window.location.href = site_url+'Admin/proposals?post_id='+resp.job_id;
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
		url:site_url+'Admin/posts/job_a_post',
		data: new FormData($('#post_jobs')[0]),
		dataType: 'JSON',
        processData: false,           
        contentType: false,
        cache: false,
		beforeSend:function (){
			$('.post_btn').prop('disabled',true);
			$('.post_btn').html('<i class="fa fa-spin fa-spinner"></i> Posting...');
			$('.msgss').html('');
			$('.postcode-err').hide();
		},
		success:function(resp){
			if(resp.status==1){
					window.location.href = site_url+'Admin/Home/proposals?post_id='+resp.job_id;
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
		},
		error: function(data) {
                console.log('error');
                console.log(data);
            }
	});
	return false;



 });
 
 /* start function added by Pranotosh */
 function changeuser(){
	 $('.post_btn').prop('disabled',true);
 }
 /* end function added by Pranotosh */
 
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>