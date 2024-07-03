<?php include 'include/header.php'; ?>
<style>
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
#profile {
	display: none;
}
#imageContainer {
	cursor: pointer;
}
/*----------LOADER CSS START----------*/
.loader_ajax_small {
	display: none;
	border: 2px solid #f3f3f3 !important;
	border-radius: 50%;
	border-top: 2px solid #2D2D2D !important;
	width: 29px;
	height: 29px;
	margin: 0 auto;
	-webkit-animation: spin_loader_ajax_small 2s linear infinite;
	animation: spin_loader_ajax_small 2s linear infinite;
}

@-webkit-keyframes spin_loader_ajax_small {
	0% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin_loader_ajax_small {
	0% { transform: rotate(0deg); }
	100% { transform: rotate(360deg); }
}
/*----------LOADER CSS END----------*/

#workImage{display: none;}
.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-color:#F1F2F6;background-size:cover;background-repeat:no-repeat;display:inline-block;box-shadow:0 -3px 6px 2px rgba(0,0,0,0.2);display:flex;align-content:center;justify-content:center;align-items:center}
.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
.imgUp{margin-bottom:15px}
.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
.boxImage { height: 100%;}
.boxImage img { height: 100%;object-fit: contain;}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Profile Details</h1> 
						<form action="<?= site_url().'users/update_profile'; ?>" onsubmit="return update_profile();" id="update_profile" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Profile Picture*</label>
											<div class="col-md-12">
												<div id="imageContainer">
													<?php if($user_profile['profile']){ ?>
														<img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='200' height='217'>
													<?php }else{ ?>
													<img src="<?php echo base_url(); ?>img/default-img.png" alt="Click to select image" width="200" height="217">
													<?php }?>
													<input type="file" name="profile" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();">
												</div>

												<input type="hidden" name="u_profile_old" value="<?= $user_profile['profile']; ?>" >
												<!--<div id="imgpreview">
													<?php if($user_profile['profile']){ ?>
														<img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='100px' height='100px'>
													<?php } ?>
												</div>-->
											</div>
										</div>
									</div>

									<?php if($this->session->userdata('type')==1){ ?>
										<div class="col-md-9">
											<div class="form-group">
												<label class="col-md-12 control-label" for="">About Your Business </label>
												<div class="col-md-12">
													<textarea class="form-control input-md" name="about_business" id="about_business" rows="10"><?php echo $user_profile['about_business']; ?></textarea>
													<div class="text-right"><small class="text-danger">(Minimum 100 characters)</small></div>
													<!--<div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Please don't include contact details or your website in this section.</div>-->
													<div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Contact detail detected. Remove it to continue.</div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
								<!-- <div class="col-sm-12">
									<h2>Name</h2>
								</div> -->
								<div class="row">
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">First Name*</label>  
											<div class="col-md-12">
												<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md" <?php echo ($user_profile['type']==1) ? 'readonly' : ''; ?> type="text" value="<?php echo $user_profile['f_name']; ?>" required readonly>
                                        
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Last Name*</label>  
											<div class="col-md-12">
												<input id="l_name" <?php echo ($user_profile['type']==1) ? 'readonly' : ''; ?> name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $user_profile['l_name']; ?>" readonly required>
                                        
											</div>
										</div>
									</div>
								</div>
								
								<?php if($this->session->userdata('type')==1){ ?>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Trading Name*</label>  
											<div class="col-md-12">
												<input id="trading_name" name="trading_name" placeholder="Trading Name" class="form-control input-md" type="text" value="<?php echo $user_profile['trading_name']; ?>" required>
                                        
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>                        
							<!-- Edit-section-->
                        
                        
							<!-- Edit-section-->
							<div class="edit-user-section">
								<div class="col-sm-12">
									<h2>Address</h2>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="row">
											<div class="col-sm-12">     
												<div class="form-group">
												
													<div class="col-md-12">
														<input type="text" name="e_address" id="geocomplete" class="form-control" value="<?php echo $user_profile['e_address']; ?>" placeholder="Enter a address" autocomplete="off" required readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<!-- <div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Country* </label>  
													<div class="col-md-12">
														<select class="form-control input-lg" required name="country" id="countryus1" disabled>
															<option value=""></option>
															<?php
															foreach($country as $key => $val){
																$selected = ($user_profile['county'] == $val['region_name']) ? 'selected' : '';
																echo '<option '.$selected.' value="'.$val['region_name'].'">'.$val['region_name'].'</option>';
															}
															?>
														</select>
													</div>
												</div>
											</div>  -->                                        
                                                                              
											<!-- Text input-->
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Town/City* </label>  
													<div class="col-md-12">
														<input type="text" placeholder="Town/City" name="locality" id="e_city" value="<?php echo $user_profile['city']; ?>" class="form-control" required readonly>
												
													</div>
												</div>
											</div> 
										    
											<div class="col-sm-6">                                                    
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">PostCode*</label>  
											<div class="col-md-12">
							<input type="text" placeholder="PostCode" value="<?php echo $user_profile['postal_code']; ?>" id="postal_code" name="postal_code" class="form-control input-md" required onblur="check_postcode(this.value);" readonly>

					<!-- <input type="hidden" id="latitude" value="<?php echo $user_profile['latitude']; ?>" name="latitude" class="form-control input-lg">

                 <input type="hidden" id="longitude" value="<?php echo $user_profile['longitude']; ?>" name="longitude" class="form-control input-lg"> -->
										
														<p class="text-danger postcode-rec" style="display:none;">Post code is required</p>
														<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
													</div>
												</div>                                       
											</div>
											
										</div>                                    
										                    
										<!-- Text input-->
										<?php if($this->session->userdata('type')==1){ ?>
										<!-- Edit-section-->
										<div class="edit-user-section">
											
											<div class="form-group" style="display:inline-block; width:100%;">
												<label class="col-md-12 control-label" for="">Do you have any trade qualification or accreditation? </label>
												<div class="col-md-12 text-center">
													<label class="radio-inline" for="qualification_yes">
														<input type="radio" name="is_qualification" value="1" onclick="showHideQualification(this.value)" required id="qualification_yes" /> YES
													</label>
													<label class="radio-inline" for="qualification_no">
														<input type="radio" name="is_qualification" value="0" onclick="showHideQualification(this.value)" id="qualification_no" /> NO
													</label>
												</div>
											</div>
											<div class="sing-body" id="qualificationBox"  tabindex='1'>
												<p>Please list your qualifications and accreditations (with the relevant registration number) in this section. If you're time served tradesman, leave this section blank.</p>

												<textarea class="form-control" name="qualification" id="work_history" rows="14"><?= $user_profile['qualification']; ?></textarea>
												
												<!--<div class="msg1-12 text-danger" style="display: none; margin-top:10px;">Please don't include contact details or your website in this section.</div>-->

												<div class="msg1-12 text-danger" style="display: none; margin-top:10px;">Contact detail detected. Remove it to continue.</div>

											</div>
									
											
											<div class="form-group" style="display:inline-block; width:100%;">
												<label class="col-md-12 mt20 control-label" for="">Do you have public liability insurance? </label>
												<div class="col-md-12 text-center">
													<label class="radio-inline" for="insurance_yes">
														<input type="radio" name="insurance_liability" value="yes" onclick="showHideInsurance(this.value)" required id="insurance_yes" /> Yes
													</label>
													<label class="radio-inline" for="insurance_no">
														<input type="radio" name="insurance_liability" value="no" onclick="showHideInsurance(this.value)" id="insurance_no" /> No
													</label>
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
															<input type="text" name="insurance_amount" class="form-control" placeholder="0.00" value="<?=$user_profile['insurance_amount'];?>" />
														</div>
													</div>
												</div>

												<p>When is the insurance expiring ?</p>
												<div class="form-group">
													<div class="col-md-12">
														<?php
														$insurance_date = date("Y-m-d");
														if($user_profile['insurance_liability'] == 'yes'){
															$insurance_date = $user_profile['insurance_date'];
														}
														?>
														<input type="date" class="form-control" name="insurance_date" value="<?=date("Y-m-d", strtotime($insurance_date));?>" />
													</div>
												</div>

												<hr>
											</div>
									
										
										</div>
										<?php } ?>
										<div class="row">
											<?php if($this->session->userdata('type')==1){ ?>
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Maximum distance you are willing to travel for work? </label>  
													<div class="col-md-12">
														<select class="form-control input-md" name="distance" id="distance" required>
															<option value="">Please select</option>
									
															<option <?php echo ($user_profile['max_distance']==5)?'selected':'';?> value="5">05 Miles</option>
															<option <?php echo ($user_profile['max_distance']==10)?'selected':'';?> value="10">10 Miles</option>
															<option <?php echo ($user_profile['max_distance']==15)?'selected':'';?> value="15">15 Miles</option>
															<option <?php echo ($user_profile['max_distance']==20)?'selected':'';?> value="20">20 Miles</option>
															<option <?php echo ($user_profile['max_distance']==25)?'selected':'';?> value="25">25 Miles</option>
															<option <?php echo ($user_profile['max_distance']==30)?'selected':'';?> value="30">30 Miles</option>
															<option <?php echo ($user_profile['max_distance']==35)?'selected':'';?> value="35">35 Miles</option>
															<option <?php echo ($user_profile['max_distance']==40)?'selected':'';?> value="40">40 Miles</option>
															<option <?php echo ($user_profile['max_distance']==45)?'selected':'';?> value="45">45 Miles</option>
															<option <?php echo ($user_profile['max_distance']==50)?'selected':'';?> value="50">50 Miles</option>
															<option <?php echo ($user_profile['max_distance']==5000)?'selected':'';?> value="5000">More than 50 Miles</option>
														</select>
                                      
													</div>
												</div>
											</div>
											<?php } ?>
											
											<?php if($this->session->userdata('type')==1){ ?>
											<?php /*
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class=" control-label" for="">Hourly Rate</label>  
													<div class="">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-gbp"></i></span><input value="<?php echo $user_profile['hourly_rate']; ?>" name="hourly_rate" id="hourly_rate" type="number" class="form-control " >
														</div>
													</div>
												</div> 
											</div>*/?>
											<?php } ?> 
															 
										</div>  
                                    
									</div>
								</div>
							</div>                        
							<!-- Edit-section-->
                        
							                     
               				
                        
                        
							<!-- Edit-section-->
							<div class="edit-user-section">
								
									<div class="col-sm-6">
										<h2> Phone Number* </h2>
									<div class="input-group">
										<span class="input-group-addon">+44</span>
										<input id="phone_no" name="phone_no" placeholder="Phone Number" value="<?php echo $user_profile['phone_no']; ?>" class="form-control input-md">
									</div>
									</div>
									
									<div class="col-sm-6">
										<h2> Email* </h2>
										<input id="email" name="email" placeholder="Email" value="<?php echo $user_profile['email']; ?>" class="form-control input-md" readonly>
									</div>
							</div>

							<!-- Edit-section--> 
							<?php if($this->session->userdata('type')==1){ ?>
								<div class="edit-user-section">
									<div class="col-md-12">
										<h2>Add Previous Work Images</h2>
										<div class="row loader">
											<div class="loader_ajax_small"></div>
											<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageAdd">
												<div class="addWorkImage imagePreviewPlus imgUp">
													<input type="file" name="workImage" id="workImage">
													<img src="img/upImage.png" id="defaultImg">
												</div>
											</div>
											<div id="previousImg">
											<?php
											if(!empty($portfolio)){
												foreach ($portfolio as $img){
											?>
													<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv<?php echo $img['id'];?>">
														<div class="boxImage imgUp">
															<div class="imagePreviewPlus">
																<div class="text-right">
																	<button type="button" class="btn btn-danger removeImage" data-id="<?php echo $img['id']?>"><i class="fa fa-trash"></i></button>
																</div>
																<img style="width: inherit; height: inherit;" src="<?php echo base_url().'img/profile/'.$img['port_image'];?>" alt="">
															</div>
														</div>
													</div>
											<?php
												}
											}
											?>
											</div>											
										</div>
									</div>
								</div>
							<?php } ?>
                        
							<!-- Edit-section-->
							  
							<div class="edit-user-section gray-bg">
								<div class="row nomargin">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary submit_btn">Save Profile</button>
                           
									</div>                                 
								</div>
							</div>                        
							<!-- Edit-section--> 
                        
						</form>
                        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script type="text/javascript">	
  document.getElementById('imageContainer').addEventListener('click', function() {
		document.getElementById('profile').click();
	});

	document.getElementById('profile').addEventListener('change', function(e) {
		var file = e.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			var image = document.querySelector('#imageContainer img');
			image.src = e.target.result;
		};

		reader.readAsDataURL(file);
	});

function check_postcode(postcode)
{

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
			console.log(res);
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
</script>>
<script>
  init_tinymce();
  function init_tinymce(){
    tinymce.init({
      selector: '.textarea',
      height:250,
      menubar: false,
      branding: false,
      statusbar: false,
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


  $(function(){
  /*
  $("#geocomplete").geocomplete({
    details: "form",
    types: ["geocode", "establishment"],
  });
  $("#find").click(function(){
    $("#geocomplete").trigger("geocode");
  });*/
});

function update_profile(){
	
	var post_code = $("#postal_code").val();
	var about_business = $("#about_business").val();
	var work_history = $("#work_history").val();
	if (post_code) {
		
		$.ajax({
			type:'POST',
			url:site_url+'users/check_profile_content',
			data:{
				post_code:post_code,
				about_business:about_business,
				work_history:work_history
			},
			dataType:'JSON',
			beforeSend:function(){
				$('.postcode-err').hide();
				$('.postcode-rec').hide();
				$('.msg1-11').hide();
				$('.msg1-12').hide();
			},
			success:function(res){
				if(res.status==1){
					
					$('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
					$('.submit_btn').prop('disabled',true);
					
					$("#update_profile").removeAttr('onsubmit');
					$("#update_profile").submit();
				} else if(res.status==2){	
					swal("", "Contact detail detected. Remove it to continue.", "error");
					//$('.msg1-11').show();
					$('#edit-user-section1').focus();
				} else if(res.status==3){	
					swal("", "Contact detail detected. Remove it to continue.", "error");
					//$('.msg1-12').show();
					$('#qualificationBox').focus();
				} else {
					$('.postcode-err').show();
					$('#postal_code').focus();
					
				}
			}
		});
			
	} else {
		$('.postcode-show').hide();
		$('.postcode-rec').show();
		$('#postal_code').focus();
		//return false;
	}
	
return false;
	
	
}
function seepreview(){
  var fileUploads = $("#profile")[0];
  var reader = new FileReader();
  reader.readAsDataURL(fileUploads.files[0]);
  reader.onload = function (e) {
    var image = new Image();
    image.src = e.target.result;
    image.onload = function () {
      var height = this.height;
      var width = this.width;
      $('#imgpreview').html('<img src="'+image.src+'"  width="100px" height="100px">'); 
    }
  }     
} 
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

var is_qualification = <?=$user_profile['is_qualification'];?>;
if(is_qualification == 1){
	$("#qualification_yes").attr('checked', true).trigger('click');
}else{
	$("#qualification_no").attr('checked', true).trigger('click');
}

var insurance_liability = '<?= $user_profile['insurance_liability'];?>';
if(insurance_liability == 'yes'){
	$("#insurance_yes").attr('checked', true).trigger('click');
}else{
	$("#insurance_no").attr('checked', true).trigger('click');
}

showHideQualification(is_qualification);
showHideInsurance(insurance_liability);
</script>
<?php include 'include/footer.php'; ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#countryus1').select2({
		placeholder: "Select county",
	});
});
</script>

<!--****************FILE UPLOAD FUNCTION CODE START****************-->
<script>
	const dropArea = document.querySelector(".addWorkImage"),
		button = dropArea.querySelector("img"),
		input = dropArea.querySelector("input");
	let file;
	var filename;

	button.onclick = () => {input.click();};

	input.addEventListener("change", function (e) {
		e.preventDefault();
		var file_data = $('#workImage').prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		$('.loader_ajax_small').show();
		$('#previousImg').css('opacity', '0.6');
		$.ajax({
			url:site_url+'users/dragDrop',
			type: "POST",
			data: form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType:'json',
			success: function(response){
				if(response.status == 1){
					var portElement = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
						'<div class="boxImage imgUp">'+
						'<div class="imagePreviewPlus">'+
						'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage('+response.id+')"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
						'</div></div></div>';
					$('#previousImg').append(portElement);
					$('.loader_ajax_small').hide();
					$('#previousImg').css('opacity', '1');
				}
			}
		});
	});

	$('.removeImage').on('click', function(e){
		removeImage($(this).attr('data-id'));
	});

	function removeImage(pImgId){
		$.ajax({
			url:site_url+'users/removePortfolio',
			type:"POST",
			data:{'pImgId':pImgId},
			success:function(data){
				$('#portDiv'+pImgId).remove();
				alert('image deleted successfully');
			}
		});
	}
</script>
<!--****************FILE UPLOAD FUNCTION CODE END****************-->