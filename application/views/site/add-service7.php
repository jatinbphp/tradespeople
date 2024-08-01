<style>
	.form-check-label{background: transparent!important;}
	.switch {
		position: relative;
		display: inline-block;
		width: 53px;
		height: 26px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.switch-slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.switch-slider:before {
		position: absolute;
		content: "";
		height: 22px;
		width: 22px;
		left: 3px;
		bottom: 2px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .switch-slider {
		background-color: #2196F3;
	}

	input:focus + .switch-slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .switch-slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded switch-sliders */
	.switch-slider.round {
		border-radius: 34px;
	}

	.switch-slider.round:before {
		border-radius: 50%;
	}
</style>

<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="row">
			<div class="col-sm-12" style="border-bottom:1px solid #e1e1e1;">
				<div class="form-group mb-0">
					<h3 class="col-md-6 control-label mt-1 pl-0" for="">Pricing</h3>
					<div class="col-md-6 text-right pr-0">
						<span>Offer Packages</span>
						<label class="switch">
							<input type="checkbox" name="package_type" <?php echo $serviceData['package_type'] == 1 ? 'checked' : ''; ?> id="offerPackage">
							<span class="switch-slider round"></span>						  
						</label>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<h4 class="control-label" for="">Packages</h4>				
			</div>
			<div class="col-md-12">
				<div class="packages-table">
					<table class="table">
						<thead>
							<tr>
								<!-- <th></th> -->
								<th>BASIC</th>
								<th class="multiplePackage">STANDARD</th>
								<th class="multiplePackage">PREMIUM</th>
							</tr>
							<tbody>
								<!--<tr>
									<td class="first-table-col"></td>
									<td>
										<textarea class="form-control input-md" rows="3" name="package[basic][name]" placeholder="Name your package"><?php echo isset($package_data) ? trim($package_data->basic->name) : '';?></textarea>
									</td>
									<td class="multiplePackage">
										<textarea class="form-control input-md" rows="3" name="package[standard][name]" placeholder="Name your package"><?php echo isset($package_data) ? trim($package_data->standard->name) : '';?></textarea>
									</td>
									<td class="multiplePackage">
										<textarea class="form-control input-md" rows="3" name="package[premium][name]" placeholder="Name your package"><?php echo isset($package_data) ? trim($package_data->premium->name) : '';?></textarea>
									</td>
								</tr>
								<tr>
									<td class="first-table-col"></td>
									<td>
										<textarea class="form-control input-md" rows="3" name="package[basic][description]" placeholder="Describe the details of your offering"><?php echo isset($package_data) ? trim($package_data->basic->description) : '';?></textarea>
									</td>
									<td class="multiplePackage">
										<textarea class="form-control input-md" rows="3" name="package[standard][description]" placeholder="Describe the details of your offering"><?php echo isset($package_data) ? trim($package_data->standard->description) : '';?></textarea>
									</td>
									<td class="multiplePackage">
										<textarea class="form-control input-md" rows="3" name="package[premium][description]" placeholder="Describe the details of your offering"><?php echo isset($package_data) ? trim($package_data->premium->description) : '';?></textarea>
									</td>
								</tr>-->								
								<?php 
									$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
									$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
									$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
								?>
								<?php if(!empty($attributes)):?>
									<?php foreach($attributes as $key => $value):?>
										<?php 
											$bchecked = !empty($basicAtt) && in_array($value['id'], $basicAtt) ? 'checked' : '';
											$schecked = !empty($standardAtt) && in_array($value['id'], $standardAtt) ? 'checked' : '';
											$pchecked = !empty($premiumAtt) && in_array($value['id'], $premiumAtt) ? 'checked' : '';
										?>
										<tr>
											<td>
												<div class="form-check" style="margin: 0;">
													<input class="form-check-input" type="checkbox" name="package[basic][attributes][]" value="<?php echo $value['id']?>" id="attCheckBasic<?php echo $value['id']?>" <?php echo $bchecked; ?> style="margin-right:10px;">
													<label class="form-check-label" for="attCheckBasic<?php echo $value['id']?>" style="margin-top:10px; font-weight: normal;">
														<?php echo $value['attribute_name']?>
													</label>
													
												</div>
											</td>
											<td class="multiplePackage">
												<div class="form-check" style="margin: 0;">
													<input class="form-check-input" type="checkbox" name="package[standard][attributes][]" value="<?php echo $value['id']?>" id="attCheckStandard<?php echo $value['id']?>" <?php echo $schecked; ?> style="margin-right:10px;">
													<label class="form-check-label" for="attCheckStandard<?php echo $value['id']?>" style="margin-top:10px; font-weight: normal;">
														<?php echo $value['attribute_name']?>
													</label>
												</div>
											</td>
											<td class="multiplePackage">
												<div class="form-check" style="margin: 0;">
													<input class="form-check-input" type="checkbox" name="package[premium][attributes][]" value="<?php echo $value['id']?>" id="attCheckPremium<?php echo $value['id']?>" <?php echo $pchecked; ?> style="margin-right:10px;">
													<label class="form-check-label" for="attCheckPremium<?php echo $value['id']?>" style="margin-top:10px; font-weight: normal;">
														<?php echo $value['attribute_name']?>
													</label>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif;?>	
								<tr>
									<?php 
										$basicDays = isset($package_data) ? $package_data->basic->days : [];
										$standardDays = isset($package_data) ? $package_data->standard->days : [];
										$premiumDays = isset($package_data) ? $package_data->premium->days : [];
									?>
									<td>
										<select name="package[basic][days]" class="form-control">
											<option value="">Delivery Days</option>
											<?php for($i=1; $i<=10; $i++):?>
												<option value="<?php echo $i;?>" <?php echo $basicDays == $i ? 'selected' : ''; ?> ><?php echo $i;?> Days Delivery</option>
											<?php endfor;?>
										</select>
									</td>
									<td class="multiplePackage"> 
										<select name="package[standard][days]" class="form-control">
											<option value="">Delivery Days</option>
											<?php for($i=1; $i<=10; $i++):?>
												<option value="<?php echo $i;?>" <?php echo $standardDays == $i ? 'selected' : ''; ?> ><?php echo $i;?> Days Delivery</option>
											<?php endfor;?>
										</select>
									</td>
									<td class="multiplePackage">
										<select name="package[premium][days]" class="form-control">
											<option value="">Delivery Days</option>
											<?php for($i=1; $i<=10; $i++):?>
												<option value="<?php echo $i;?>" <?php echo $premiumDays == $i ? 'selected' : ''; ?> ><?php echo $i;?> Days Delivery</option>
											<?php endfor;?>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<b>Price <?php echo !empty($service_category['price_type']) ? '/'.$service_category['price_type'] : ''; ?></b>
										<input name="package[basic][price]" class="form-control" type="number" value="<?php echo isset($package_data) ? trim($package_data->basic->price) : '';?>">
									</td>
									<td class="multiplePackage">
										<b>Price <?php echo !empty($service_category['price_type']) ? '/'.$service_category['price_type'] : ''; ?></b>
										<input name="package[standard][price]" class="form-control" type="number" value="<?php echo isset($package_data) ? trim($package_data->standard->price) : '';?>">
									</td>
									<td class="multiplePackage">
										<b>Price <?php echo !empty($service_category['price_type']) ? '/'.$service_category['price_type'] : ''; ?></b>
										<input name="package[premium][price]" class="form-control" type="number" value="<?php echo isset($package_data) ? trim($package_data->premium->price) : '';?>">
									</td>
								</tr>
							</tbody>
						</thead>
					</table>
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
	$(document).ready(function() {
		var package_type = <?php echo $serviceData['package_type']; ?>

		if (package_type == 0) {
	        $('#offerPackage').prop('checked', false);
	        $('.multiplePackage').css('background-color', '#e9ecef'); // Change to desired disabled background color
	        $('.multiplePackage input, .multiplePackage textarea, .multiplePackage select').prop('disabled', true);
	    } else {
	        $('#offerPackage').prop('checked', true);
	        $('.multiplePackage').css('background-color', ''); // Reset to original background color
	        $('.multiplePackage input, .multiplePackage textarea, .multiplePackage select').prop('disabled', false);
	    }


	    $('#offerPackage').on('change', function() {
	        if ($(this).is(':checked')) {	            
	            $('.multiplePackage').css('background-color', ''); // Reset to original background color
	            $('.multiplePackage input, .multiplePackage textarea, .multiplePackage select').prop('disabled', false)
	        } else {
	        	$('.multiplePackage').css('background-color', '#e9ecef'); // Change to desired disabled background color
	            $('.multiplePackage input, .multiplePackage textarea, .multiplePackage select').prop('disabled', true);;
	        }
	    });
	});	
</script>