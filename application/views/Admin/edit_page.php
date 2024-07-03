<?php 
include_once('include/header.php');
if(!in_array(1,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
.us_er3 a{	
	color:#fff !important;	
	background:#1e282c;	
	border-left-color:#ff797a !important;
}
.custo {
	margin-top: 15px;
}
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
.child {
    margin-left: 10px;
 }
.checkbox {
    margin-left: 20px;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit User</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Edit User</li>
		</ol>
	  
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-8"> 
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
						<?php if($this->session->flashdata('error')) { ?>
						<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
						<?php } if($this->session->flashdata('success')) { ?>
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php } 	?>
		
						<div class="row"> 
							<div class="col-sm-12">			
								<form method="POST"  action="<?= site_url().'Admin/Admin/update_user_profile'; ?>" id="update_profile" onsubmit="return update_profile();" enctype='multipart/form-data' >
									<input type="hidden" name="id" value="<?php echo $userinfo['id']; ?>">
									<input type="hidden" name="type" value="<?php echo $userinfo['type']; ?>">
								
									<div class="edit-user-section">
										<div class="msg"><?= $this->session->flashdata('msg');?></div>
										<div class="col-sm-12">
											<h2>Name</h2>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">First Name*</label>  
													<div class="col-md-12">
														<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md" type="text" value="<?php echo $userinfo['f_name']; ?>" required>
																						
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Last Name*</label>  
													<div class="col-md-12">
														<input id="l_name" name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $userinfo['l_name']; ?>" required>
																						
													</div>
												</div>
											</div>
										</div>
										<?php if($userinfo['type']==1){ ?>
										<div class="row">
											<div class="col-sm-12">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Trading Name*</label>  
													<div class="col-md-12">
														<input id="trading_name" name="trading_name" placeholder="Trading Name" class="form-control input-md" type="text" value="<?php echo $userinfo['trading_name']; ?>" required>
																						
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
																<input type="text" name="e_address" id="geocomplete" class="form-control" value="<?php echo $userinfo['e_address']; ?>" placeholder="Enter a location" autocomplete="off" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">     
														<div class="form-group">
															<label class="col-md-12 control-label" for=""> County* </label>  
															<div class="col-md-12">
																 <select class="form-control" required name="country" id="country">
																	<?php
																	foreach($country as $key => $val){
																		$selected = ($userinfo['county'] == $val['region_name']) ? 'selected' : '';
																		echo '<option '.$selected.' value="'.$val['region_name'].'">'.$val['region_name'].'</option>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>                                         
																																									
													<!-- Text input-->
													<div class="col-sm-6">     
														<div class="form-group">
															<label class="col-md-12 control-label" for=""> Town/City* </label>  
															<div class="col-md-12">
																<input type="text" placeholder="Town/City" name="locality" id="e_city" value="<?php echo $userinfo['city']; ?>" class="form-control" required>
														
															</div>
														</div>
													</div> 
												</div>
																				
												<div class="row">
														
													<div class="col-sm-6">                                                    
														<!-- Text input-->
														<div class="form-group">
															<label class="col-md-12 control-label" for="">PostCode*</label>  
															<div class="col-md-12">
																<input type="text" placeholder="PostCode" value="<?php echo $userinfo['postal_code']; ?>" id="postal_code" name="postal_code" class="form-control input-md" required>
													
																<p class="text-danger postcode-rec" style="display:none;">Post code is required</p>
																<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
															</div>
														</div>
																					 
													</div>
													<div class="col-sm-6">                                                    
														<!-- Text input-->
														<div class="form-group">
															<label class="col-md-12 control-label" for="">Profile Picture*</label>  
															<div class="col-md-12">
																<input type="file" name="profile" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();">
																<input type="hidden" name="u_profile_old" value="<?= $userinfo['profile']; ?>" >  
																<div id="imgpreview">
																	<?php if($userinfo['profile']){ ?>
																	<img src="<?php echo base_url();?>img/profile/<?php echo $userinfo['profile'];?>"  width='100px' height='100px'>
																	<?php } ?>
																</div>
																				
															</div>
														</div>
																					 
													</div>
												</div>   
												<?php if($userinfo['type']==1){ ?>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">  About business </label>  
													<div class="col-md-12">
														<textarea class="form-control input-md " name="about_business" id="about_business" rows="12"><?php echo $userinfo['about_business']; ?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-12 control-label" for="">  Qualification*  </label>  
													<div class="col-md-12">
														<textarea class="form-control input-md " name="qualification" id="qualification" rows="12"><?php echo $userinfo['qualification']; ?></textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<h2>Select Category </h2>
												</div>
												<div class="form-group">
                               <?php
                                    $category = $this->Common_model->GetAllData('category' ,array('cat_parent'=>0 , 'is_delete'=>0 ));
                                    
																	foreach($category as $key => $value){
																	//print_r($value);
																	$checked = ($userinfo['category'] && in_array($value['cat_id'], explode(',', $userinfo['category'])))?'checked':'';
																	$child =$this->Common_model->GetColumnName('category',array('is_delete'=>0,'cat_parent'=>$value['cat_id']),null,true,'cat_id','asc');
																	?>
																	<div class="checkbox">
																		<label><input <?php echo $checked; ?> type="checkbox" name="category[]" onchange="expandSub('sub_<?= $value['cat_id'] ?>' , this)" value="<?php echo $value['cat_id']; ?>"> <?php echo $value['cat_name']?></label>
																		<div class="child sub_<?= $value['cat_id'] ?>">
																			<?php foreach($child as $cvalue){ 

																				$cchecked = ($userinfo['subcategory'] && in_array($cvalue['cat_id'], explode(',', $userinfo['subcategory'])))?'checked':'';
																			?>

																			<div class="checkbox">
																				<label><input <?php echo $cchecked; ?> type="checkbox" name="subcategory[]" value="<?php echo $cvalue['cat_id']; ?>"> <?php echo $cvalue['cat_name']?></label>
																			</div>
																		<?php } ?>
																		</div>
																	</div>
																				
																	<?php } ?>
										                                  
                                </div>
                              </div>                     
												<!-- Text input-->
												
												<div class="row">
													<div class="col-sm-6">
														<!-- Text input-->
														<div class="form-group">
															<label class="col-md-12 control-label" for="">Maximum distance you are willing to travel for work? </label>  
															<div class="col-md-12">
																<select class="form-control input-md" name="distance" id="distance" required>
																
																	
																	<option value="">Please select</option>
									
																<option <?php echo ($userinfo['max_distance']==5)?'selected':'';?> value="5">05 Miles</option>
																<option <?php echo ($userinfo['max_distance']==10)?'selected':'';?> value="10">10 Miles</option>
																<option <?php echo ($userinfo['max_distance']==15)?'selected':'';?> value="15">15 Miles</option>
																<option <?php echo ($userinfo['max_distance']==20)?'selected':'';?> value="20">20 Miles</option>
																<option <?php echo ($userinfo['max_distance']==25)?'selected':'';?> value="25">25 Miles</option>
																<option <?php echo ($userinfo['max_distance']==30)?'selected':'';?> value="30">30 Miles</option>
																<option <?php echo ($userinfo['max_distance']==35)?'selected':'';?> value="35">35 Miles</option>
																<option <?php echo ($userinfo['max_distance']==40)?'selected':'';?> value="40">40 Miles</option>
																<option <?php echo ($userinfo['max_distance']==45)?'selected':'';?> value="45">45 Miles</option>
																<option <?php echo ($userinfo['max_distance']==50)?'selected':'';?> value="50">50 Miles</option>
																<option <?php echo ($userinfo['max_distance']==5000)?'selected':'';?> value="5000">More than 50 Miles</option>
																</select>
																					
															</div>
														</div>
													</div>
										
																	 
												</div>  
												<?php } ?>
																				
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
												<input id="phone_no" name="phone_no" placeholder="Phone Number" value="<?php echo $userinfo['phone_no']; ?>" class="form-control input-md">
											</div>
											</div>
											
											<div class="col-sm-6">
												<h2> Email* </h2>
												<input id="email" placeholder="Email" value="<?php echo $userinfo['email']; ?>" class="form-control input-md" readonly>
											</div>
									</div>                          
										 
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
  </section>
 </div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>
  $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});
  $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});
</script>
<script>
  init_tinymce();
  function init_tinymce(){
    tinymce.init({
      selector: '.textarea2',
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
});
  function update_profile(){
	
	var post_code = $("#postal_code").val();
	if (post_code) {
		
		$.ajax({
			type:'POST',
			url:site_url+'home/check_postcode',
			data:{post_code:post_code},
			dataType:'JSON',
			beforeSend:function(){
				$('.postcode-err').hide();
				$('.postcode-rec').hide();
			},
			success:function(res){
				if(res.status==1){
					
					$('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
					$('.submit_btn').prop('disabled',true);
					
					$("#update_profile").removeAttr('onsubmit');
					$("#update_profile").submit();
					
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
</script>
<?php include_once('include/footer.php'); ?>