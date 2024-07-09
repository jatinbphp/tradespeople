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
						<h1>Add Service</h1> 
						<form action="<?= site_url().'users/storeServices3'; ?>" id="update_service" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">
												What does the offer include?
											</label>
											<div class="col-md-12">
												<?php 
													if(!empty($ex_service)){
												?>
													<div class="row">
												<?php		
														foreach($ex_service as $list){
												?>
														<div class="col-sm-12">
															<div class="form-group">
																<div class="form-check" style="margin: 0;">
																	<input class="form-check-input" type="checkbox" name="extra_service[]" value="<?php echo $list['id']?>" style="margin-right:10px;">
																	<label class="form-check-label" style="margin-top:10px; font-weight: normal;"><?php echo $list['ex_service_name']?></label>
																</div>
															</div>
														</div>
												<?php			
														}
												?>
													</div>
												<?php		
													}
												?>
											</div>
										</div>
									</div>														
								</div>																
							</div>                        
							<!-- Edit-section-->
							  
							<div class="edit-user-section gray-bg">
								<div class="row nomargin">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary submit_btn">Continue</button>
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
<?php include 'include/footer.php'; ?>