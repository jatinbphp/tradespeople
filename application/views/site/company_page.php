<?php include 'include/header.php'; ?>

<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Company Details</h1>
						<!-- Edit-section-->
						<form action="<?= site_url().'users/update_company'; ?>" id="update_profile" method="post" enctype="multipart/form-data"> 
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="msg3"><?= $this->session->flashdata('msg3');?></div>  
								<div class="row">
									<?php /*if($this->session->userdata('type')==1){ ?>
									<div class="col-sm-6">       
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Company*</label>  
											<div class="col-md-12">
												<input type="text" placeholder="Company" value="<?php echo $user_profile['company']; ?>" name="company" class="form-control input-md" id="company" required>
											</div>
										</div>
									</div>
									<?php } */?>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Business Type*</label>  
											<div class="col-md-12">
												<select class="form-control input-md" name="business_type" id="business_type" required>
													<option value="">Select Business Type</option>
													<?php 
													$get_business=$this->common_model->getRows('business_types');
													foreach ($get_business as $bus) {
													?>
                          <option value="<?php echo $bus['id']; ?>" <?php if($user_profile['business_type']==$bus['id']){echo "selected"; } ?>><?php echo $bus['business_name']; ?></option>
													<?php } ?>
            
												</select>
                                             
											</div>
										</div>
                                       
									</div>
									<?php if($this->session->userdata('type')==1){ ?>
									<div class="col-sm-6">       
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Number of Employees*</label>  
											<div class="col-md-12">
												<select class="form-control input-md" name="no_of_employee" id="no_of_employee" required>
													<option value="">Select Number of Employees</option>
													<option value="1-2" <?php if($user_profile['no_of_employee']=='1-2'){ echo "selected"; } ?>>1-2</option>
													<option value="3-5" <?php if($user_profile['no_of_employee']=='3-5'){ echo "selected"; } ?>>3-5</option>
													<option value="6-10" <?php if($user_profile['no_of_employee']=='6-10'){ echo "selected"; } ?>>6-10</option>
													<option value="11-20" <?php if($user_profile['no_of_employee']=='11-20'){ echo "selected"; } ?>>11-20</option>
													<option value="21-50" <?php if($user_profile['no_of_employee']=='21-50'){ echo "selected"; } ?>>21-50</option>
													<option value="50+" <?php if($user_profile['no_of_employee']=='50+'){ echo "selected"; } ?>>50+</option>
												</select>
											</div>
										</div>
									</div>
									<?php } ?>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Active Since*</label>  
											<div class="col-md-12">
												<input type="text" placeholder="Year Active Since (e.g. 2006)" value="<?php echo $user_profile['active_since']; ?>" name="active_since" class="form-control input-md" id="active_since" required>
                                             
											</div>
										</div>
                                       
									</div>
                           
                                    
								
									<?php if($this->session->userdata('type')==1){ ?>
									<div class="col-sm-6" style="display: none;">       
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Your Website</label>  
											<div class="col-md-12">
                        <input type="text" placeholder="Your Website" value="<?php echo $user_profile['u_website']; ?>" name="u_website" class="form-control input-md" id="u_website">
											</div>
										</div>
									</div>
									<?php } ?>
      
								</div> 
							</div>                        
							<!-- Edit-section-->                        
                        
							<!-- Edit-section-->
							<div class="edit-user-section gray-bg">
								<div class="row nomargin">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-warning pass_btn">Update</button>
                              
									</div>                                 
								</div>
							</div>  
						</form> 
                        <!-- Edit-section-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'include/footer.php'; ?>
	