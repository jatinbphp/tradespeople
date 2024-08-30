<?php include_once('include/header.php'); ?>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
<style>.us_er3 a{	color:#fff !important;	background:#1e282c;	border-left-color:#ff797a !important;}
.custo {margin-top: 15px;}</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Marketer</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Marketer</li>
      </ol>
	  
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
		  <?php 
			if($this->session->flashdata('error'))
			{
				?>
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
				<?php
			}
			if($this->session->flashdata('success'))
			{
				?>
				<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
				<?php
			}
			?>
		
			<div class="row"> 

			<form  method="post" enctype="multipart/form-data" class="update_marketers_details">  
				<input type="hidden" name="user_id" value="<?php echo $marketer['id']; ?>">
							<div class="edit-user-section">
								<div class="msg"></div>
								<div class="col-sm-12">
									<h2>Name</h2>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">First Name*</label>  
											<div class="col-md-12">
												<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md f_name" <?php echo ($marketer['type']==1) ? 'readonly' : ''; ?> type="text" value="<?php echo $marketer['f_name']; ?>">
                                        
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Last Name*</label>  
											<div class="col-md-12">
												<input id="l_name" <?php echo ($marketer['type']==1) ? 'readonly' : ''; ?> name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $marketer['l_name']; ?>">
                                        
											</div>
										</div>
									</div>
								</div>
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
														<input type="text" name="e_address" id="e_address" class="form-control" value="<?php echo $marketer['e_address']; ?>" placeholder="Enter a address" autocomplete="off">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Country* </label>  
													<div class="col-md-12">
														<select class="form-control input-lg"  name="country" id="countryus1">
															<option value="">Select country</option>
															<?php
															foreach($country as $key => $val){
																$value_country = strtolower($val['region_name']);
																$country_name = ucfirst($value_country);
																$selected = (strtolower($marketer['county']) == strtolower($val['region_name'])) ? 'selected' : '';
																echo '<option '.$selected.' value="'.$val['region_name'].'">'.$country_name.'</option>';
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
														<input type="text" placeholder="Town/City" name="locality" id="e_city" value="<?php echo $marketer['city']; ?>" class="form-control">
												
													</div>
												</div>
											</div> 
										</div>
                                    
										<div class="row">
                        
											<div class="col-sm-6">                                                    
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">PostCode</label>  
														<div class="col-md-12">
														<input type="text" placeholder="PostCode" value="<?php echo $marketer['postal_code']; ?>" name="postal_code" class="form-control input-md">
														
													</div>
												</div>
                                       
											</div>
											<div class="col-sm-6">     
											<?php
												if($marketer['profile'] == ''){
													$value=0;
												}else{
													$value=1;
												}
											?>                                         
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Profile Picture*</label>  
													<div class="col-md-12">
														<input type="file" name="profile" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();" value="<?= $marketer['profile']; ?>" >
														<input type="hidden" name="u_profile_old" value="<?= $marketer['profile']; ?>" >  
														<div id="imgpreview">
															<?php if($marketer['profile']){ ?>
															<img src="<?php echo base_url();?>img/profile/<?php echo $marketer['profile'];?>"  width='100px' height='100px'>
															<?php } ?>
														</div>
                                    
													</div>
												</div>
                                       
											</div>
										</div>  
										<div class="row">
											<div class="col-sm-6">                             
													<!-- Text input-->
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Email*</label>  
															<div class="col-md-12">
															<input type="text" value="<?php echo $marketer['email']; ?>" id="email" name="email" class="form-control input-md">
															
														</div>
													</div>        
											</div>
											<div class="col-sm-6">                             
													<!-- Text input-->
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Number*</label>  
															<div class="col-md-12">
															<input type="text"  value="<?php echo $marketer['phone_no']; ?>" id="phone_no" name="phone_no" class="form-control input-md">
															
														</div>
													</div>        
											</div>
											<div class="col-sm-6">                             
													<!-- Text input-->
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Traffic source</label>  
															<div class="col-md-12">
															<input type="url"  value="<?php echo $marketer['u_website']; ?>" name="u_website" class="form-control input-md" placeholder="Enter your traffic source">
															
														</div>
													</div>        
											</div>
										</div>
										</div>
										</div>
										</div> 
										<div class="edit-user-section">
											<div class="row nomargin" style="background: #fff; padding: 10px 0;">
												<div class="col-sm-12">
													<button type="submit" class="btn btn-primary" style="width: 10%;">SAVE</button>
												</div>                                 
											</div>
										</div> 
									</form>
			</div>
			
			   </div>
        </div>
      </div>
    </div>
  </section>
 </div>

 
<script type="text/javascript">
   jQuery('.update_marketers_details').submit(function(e){
   			 e.preventDefault();
    	var user_id= jQuery('#user_id').val();
    	var f_name= jQuery('#f_name').val();
			var l_name= jQuery('#l_name').val();
			var e_address= jQuery('#e_address').val();
			var countryus1= jQuery('#countryus1').val();
			var e_city= jQuery('#e_city').val();
			var profile= jQuery('#u_profile_old').val();
			var email= jQuery('#email').val();
			var phone_no= jQuery('#phone_no').val();
			// var u_website= jQuery('#u_website').val();
			// console.log(f_name , l_name, e_address , countryus1 , e_city , profile , email , phone_no);


			if(f_name == '' || l_name == '' || e_address == '' || countryus1 == '' || e_city == '' || profile == '' || email == '' || phone_no == '' ){
				alert(' All Fields Are Mandatory');
			}
			else{ 
				    jQuery.ajax({
		             url:'<?= base_url(); ?>Admin/Admin/update_marketer_profile',
		             type:"post",
		             dataType:'json',
		             data:new FormData(this),
		             processData:false,
		             contentType:false,
		             cache:false,  
		             async:false, 
		             success: function(data){
		                console.log(data);
		                if(data == 1){
		                	// alert('Profile Updated Successfully');
		                	setTimeout(function(){
		                      location.reload(true);
		                       }, 1000);
		                }else{
		                	alert("Profile doesn't Updated");
		                }
		           },error:function(ts){
		             console.log(ts);
		           }
		         });
			}
    	});	
</script>
<?php include_once('include/footer.php'); ?>