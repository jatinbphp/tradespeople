<form action="<?= site_url().'users/storeServices2'; ?>" id="update_service" method="post" enctype="multipart/form-data">  
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
						<select class="form-control input-md tradesCategory" name="plugins[]" id="plugins" multiple>
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