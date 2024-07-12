<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Main Category</label>
					<div class="col-md-12">
						<select class="form-control input-md mainCategory" name="category" data-section="sub_category" id="category">
							<option value="">Select Category</option>
							<?php $selected = $serviceData['category1'] ?? '' ?>
							<?php foreach ($category as $cat) { ?>
								<option <?php echo (($selected == $cat['cat_id']) ? 'selected' : '') ?> value="<?php echo $cat['cat_id']; ?>">
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
						<select class="form-control input-md subCategory categories" name="sub_category" data-section="service_type" id="sub_category">
							<option value="">Select Sub Category</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-12 hidden categories_div" id="service_type_div">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Service Type</label>
					<div class="col-md-12">
						<select class="form-control input-md serviceType categories" name="service_type" data-section="plugins" id="service_type">
							<option value="">Select Service Type</option>
						</select>
					</div>
				</div>
			</div>	
			<div class="col-sm-12 hidden categories_div" id="plugins_div">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Select Plugins</label>
					<div class="col-md-12">
						<select class="form-control input-md plugin categories" name="plugins[]" id="plugins" multiple>
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
	var subCategory = 1;
	var serviceType = 1;
	var plugin = 1;
  	$('.mainCategory').on('change', function(){
  		var cat_id = $(this).val();
  		var sectionId = $(this).attr('data-section');
		$('.categories').empty();
		$('.categories_div').addClass('hidden');
		$.ajax({
			url:site_url+'users/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id,'type':1},
			success:function(data){
				if(data != ""){
					$('#'+sectionId+'_div').removeClass('hidden');
					$('#'+sectionId).empty().html(data);
					<?php if(isset($serviceData['sub_category']) && $serviceData['sub_category']): ?>
						if(subCategory == 1){
							$('.subCategory').val(<?php echo $serviceData['sub_category'] ?? '' ?>);
							$('.subCategory').trigger('change');
							subCategory = 0;
						}else{
							subCategory = 0;
						}
					<?php endif ?>
				}else{
					$('#'+sectionId+'_div').addClass('hidden');
				}
			}
		});
  	});

	$('.subCategory').on('change', function(){
  		var cat_id = $(this).val();
  		var sectionId = $(this).attr('data-section');
		$.ajax({
			url:site_url+'users/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id,'type':2},
			success:function(data){
				if(data != ""){
					$('#'+sectionId+'_div').removeClass('hidden');
					$('#'+sectionId).empty().html(data);
					<?php if(isset($serviceData['service_type']) && $serviceData['service_type']): ?>
						if(serviceType == 1){
							$('.serviceType').val(<?php echo $serviceData['service_type'] ?? '' ?>);
							$('.serviceType').trigger('change');
							serviceType = 0;
						}else{
							serviceType = 0;
						}
					<?php endif ?>
				}else{
					$('#'+sectionId+'_div').addClass('hidden');
				}
			}
		});
  	});

	$('.serviceType').on('change', function(){
  		var cat_id = $(this).val();
  		var sectionId = $(this).attr('data-section');
		$.ajax({
			url:site_url+'users/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id,'type':3},
			success:function(data){
				if(data != ""){
					$('#'+sectionId+'_div').removeClass('hidden');
					$('#'+sectionId).empty().html(data);
					<?php if(isset($serviceData['plugins']) && $serviceData['plugins']): ?>
						console.log(111);
						if(plugin == 1){
						console.log(222);
							var pluginData = "<?php echo $serviceData['plugins'] ?? ''; ?>";
							if (pluginData) {
								var pluginArray = pluginData.split(',');
								console.log(pluginArray);
								$('.plugin').val(pluginArray);
							}
							$('.plugin').trigger('change');
							plugin = 0;
						} else {
							plugin = 0;
						}
					<?php endif ?>
				}else{
					$('#'+sectionId+'_div').addClass('hidden');
				}
			}
		});
  	});

	// $('.plugin').on('change', function(){
  	// 	var cat_id = $(this).val();
  	// 	var sectionId = $(this).attr('data-section');
	// 	$.ajax({
	// 		url:site_url+'users/getSubCategory',
	// 		type:"POST",
	// 		data:{'cat_id':cat_id,'type':4},
	// 		success:function(data){
	// 			if(data != ""){
	// 				$('#'+sectionId+'_div').removeClass('hidden');
	// 				$('#'+sectionId).empty().html(data);
	// 			}else{
	// 				$('#'+sectionId+'_div').addClass('hidden');
	// 			}
	// 		}
	// 	});
  	// });

	$(document).ready(function(){
		<?php if(isset($serviceData['category']) && $serviceData['category']): ?>
			$('.mainCategory').val(<?php echo $serviceData['category'] ?? '' ?>);
			$('.mainCategory').trigger('change');
		<?php endif ?>
	});
</script>