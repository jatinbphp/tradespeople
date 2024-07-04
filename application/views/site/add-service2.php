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

	#serviceImage{display: none;}
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
						<h1>Edit Service</h1> 
						<form action="<?= site_url().'users/storeServices'; ?>" id="update_service" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Main Category</label>
											<div class="col-md-12">
												<select class="form-control input-md tradesCategory" name="category" data-section="sub_category" id="category">
													<option value="">Select Category</option>
													<?php foreach ($category as $cat) { ?>
														<option value="<?php echo $cat['cat_id']; ?>">
															<?php echo $cat['cat_name']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Sub Category</label>
											<div class="col-md-12">
												<select class="form-control input-md tradesCategory" name="sub_category" data-section="service_type" id="sub_category">
													<option value="">Select Sub Category</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12 hidden" id="service_type_div">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Service Type</label>
											<div class="col-md-12">
												<select class="form-control input-md tradesCategory" name="service_type" data-section="plugins" id="service_type">
													<option value="">Select Service Type</option>
												</select>
											</div>
										</div>
									</div>	
									<div class="col-sm-12 hidden" id="plugins_div">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Select Plugins</label>
											<div class="col-md-12">
												<select class="form-control input-md tradesCategory" name="plugins" id="plugins" multiple>
													<option value="">Select Plugins</option>
												</select>
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
<script type="text/javascript">	
  	$('.tradesCategory').on('change', function(){
  		var cat_id = $(this).val();
  		var sectionId = $(this).attr('data-section');
		$.ajax({
			url:site_url+'users/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id},
			success:function(data){
				if(data != ""){
					$('#'+sectionId+'_div').removeClass('hidden');
					$('#'+sectionId).empty().html(data);
				}else{
					$('#'+sectionId+'_div').addClass('hidden');
				}
			}
		});
  	});
</script>