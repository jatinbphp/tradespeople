
<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="msg"><?= $this->session->flashdata('msg');?></div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">
						What does the offer include?
					</label>
					<div class="col-md-12">
						<div id="ex-service-div" style="margin-top:10px">
							<?php if(!empty($ex_service)):?>
								<?php $i= 1;?>
								<?php 
									foreach($ex_service as $key => $exs): 
										$matchedItem = $this->common_model->findMatchingItem($exs, $serviceData['trades_ex_service']);
									    $isChecked = $matchedItem ? 'checked' : '';
									    $price = $matchedItem['price'] ?? $exs['price'];
									    $additional_working_days = $matchedItem['additional_working_days'] ?? $exs['days'];
								?>
									<div class="row" id="newExS<?php echo $i; ?>" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">

										<input type="hidden" name="newExS[<?php echo $i; ?>][category]" value="<?php echo $exs['category'] ?? '' ?>">

										<input type="hidden" name="newExS[<?php echo $i; ?>][type]" value="1">

										<input type="hidden" name="newExS[<?php echo $i; ?>][ex_service_name]" value="<?php echo $exs['ex_service_name'] ?? '' ?>">

										<div class="col-md-5" style="margin-top:10px;">
											<input class="form-check-input" type="checkbox" name="newExS[<?php echo $i; ?>][id]" value="<?php echo $exs['id']?>" <?php echo $isChecked; ?> style="margin-right:10px;">
											<label class="form-check-label" style="margin-top:10px; font-weight: normal;"><?php echo $exs['ex_service_name']?></label>
										</div>
										<div class="col-md-3" style="margin-top:10px;">
											<div class="form-group">
												<label class="control-label" for="price<?php echo $i; ?>">
													Extra Service Price
												</label>
												<div class="">
													<input type="number" class="form-control input-md" name="newExS[<?php echo $i; ?>][price]" id="price<?php echo $i; ?>" placeholder="Extra Service Price" value="<?php echo $price; ?>">
												</div>
											</div>
										</div>
										<div class="col-md-3" style="margin-top:10px;">
											<div class="form-group">
												<label class="control-label" for="additional_working_days<?php echo $i; ?>" style="width:100%">
													Additional Working Days
												</label>
												<div>
													<input type="number" step="1" class="form-control input-md" name="newExS[<?php echo $i; ?>][additional_working_days]" id="additional_working_days<?php echo $i; ?>" placeholder="Additional Working Days" value="<?php echo $additional_working_days; ?>">
												</div>
											</div>
										</div>									
									</div>
									<?php $i++; ?>
								<?php endforeach ?>
							<?php endif; ?>

							<!--****************Tradesman Personal Extra Services****************-->

							<?php if(!empty($serviceData['trades_ex_service'])):?>
								<?php $i= count($ex_service) + 1;?>
								<?php 
									foreach($serviceData['trades_ex_service'] as $tkey => $texs): 
										if($texs['type'] == 2):
										$matchedItem = $this->common_model->findMatchingItem($texs, $serviceData['trades_ex_service']);
									    $isChecked = $matchedItem ? 'checked' : '';
									    $price = $matchedItem['price'] ?? $texs['price'];
									    $additional_working_days = $matchedItem['additional_working_days'] ?? $texs['days'];
								?>
									<div class="row" id="newExS<?php echo $i; ?>" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">

										<input type="hidden" name="newExS[<?php echo $i; ?>][category]" value="<?php echo $texs['category'] ?? '' ?>">

										<input type="hidden" name="newExS[<?php echo $i; ?>][id]" value="<?php echo $texs['id'] ?? 0; ?>">

										<input type="hidden" name="newExS[<?php echo $i; ?>][type]" value="2">

										<input type="hidden" name="newExS[<?php echo $i; ?>][ex_service_name]" value="<?php echo $texs['ex_service_name'] ?? '' ?>">

										<div class="col-md-5" style="margin-top:10px;">
											<div class="form-group">
												<label class="control-label" for="ex_service_name'+totalnewExService+'">Extra Service Name</label>
												<div>
													<input type="text" class="form-control input-md" name="newExS[<?php echo $i; ?>][ex_service_name]" id="ex_service_name<?php echo $i; ?>" placeholder="Service Name" value="<?php echo $texs['ex_service_name']?>" required>
												</div>
											</div>
										</div>

										<div class="col-md-3" style="margin-top:10px;">
											<div class="form-group">
												<label class="control-label" for="price<?php echo $i; ?>">
													Extra Service Price
												</label>
												<div class="">
													<input type="number" class="form-control input-md" name="newExS[<?php echo $i; ?>][price]" id="price<?php echo $i; ?>" placeholder="Extra Service Price" value="<?php echo $texs['price']; ?>">
												</div>
											</div>
										</div>
										<div class="col-md-3" style="margin-top:10px;">
											<div class="form-group">
												<label class="control-label" for="additional_working_days<?php echo $i; ?>" style="width:100%">
													Additional Working Days
												</label>
												<div>
													<input type="number" step="1" class="form-control input-md" name="newExS[<?php echo $i; ?>][additional_working_days]" id="additional_working_days<?php echo $i; ?>" placeholder="Additional Working Days" value="<?php echo $texs['additional_working_days']; ?>">
												</div>
											</div>
										</div>									
									</div>
									<?php $i++; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<span class="text-info addNewExService"><i class="fa fa-plus" style="font-size:12px;"></i> Add New Extra Service</span>
					</div>
				</div>
			</div>														
		</div>																
	</div>	
	<div class="edit-user-section gray-bg">
		<div class="row nomargin">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary submit_btn">Continue</button>
			</div>                                 
		</div>
	</div>                        
</form>

<script>
	var totalnewExService =  <?php echo ($i ?? 0); ?>;
	$('.addNewExService').on('click', function(){
		var exservicehtml = '<div class="row" id="newExS'+totalnewExService+'" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">'+
					'<input type="hidden" name="newExS['+totalnewExService+'][id]" value="0">'+
					'<input type="hidden" name="newExS['+totalnewExService+'][type]" value="2">'+
					'<input type="hidden" name="newExS['+totalnewExService+'][category]" value="<?php echo $serviceData['category']?>">'+
					'<div class="col-md-5" style="margin-top:10px;">'+
						'<div class="form-group">'+
							'<label class="control-label" for="ex_service_name'+totalnewExService+'">Extra Service Name</label>'+
							'<div>'+
								'<input type="text" class="form-control input-md" name="newExS['+totalnewExService+'][ex_service_name]" id="ex_service_name'+totalnewExService+'" placeholder="Service Name" required>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-3" style="margin-top:10px;">'+
						'<div class="form-group">'+
							'<label class="control-label" for="price'+totalnewExService+'">Extra Service Price</label>'+
							'<div class="">'+
								'<input type="number" class="form-control input-md" name="newExS['+totalnewExService+'][price]" id="price'+totalnewExService+'" placeholder="Price" rows="3" required>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-3" style="margin-top:10px;">'+
						'<div class="form-group">'+
							'<label class="control-label" for="additional_working_days'+totalnewExService+'">Additional Working Days</label>'+
							'<div class="">'+
								'<input type="number" class="form-control input-md" name="newExS['+totalnewExService+'][additional_working_days]" step="1" id="additional_working_days'+totalnewExService+'" placeholder="Additional Working Days" rows="3" required>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-1" style="margin-top:10px;">'+
						'<div class="form-group">'+
						'<span id="remove'+totalnewExService+'" class="btn btn-sm btn-danger pull-right removeExService" data-id="'+totalnewExService+'"><i class="fa fa-trash"></i></span></label>'+
					'</div>'+
				'</div>';
		$('#ex-service-div').append(exservicehtml);
		totalnewExService++;
		updateExsIndices();
	});	


	$('#ex-service-div').on('click', '.removeExService', function (event) {
		event.preventDefault();
		var fId = $(this).attr('data-id');
		$('#newExS'+fId).remove();
		totalnewExService--;
		updateExsIndices();
	});

	function updateExsIndices() {
        $('#ex-service-div .row').each(function(index) {
            let newIndex = index + 1;
            $(this).attr('data-index', newIndex);
            $(this).find('input[name^="newExS"]').each(function() {
	            let inputName = $(this).attr('name');
	            if (inputName.includes('[category]')) {
	                $(this).attr('name', `newExS[${newIndex}][category]`);
	            } else if (inputName.includes('[id]')) {
	                $(this).attr('name', `newExS[${newIndex}][id]`);
	            } else if (inputName.includes('[ex_service_name]')) {
	                $(this).attr('name', `newExS[${newIndex}][ex_service_name]`);
	            } else if (inputName.includes('[price]')) {
	                $(this).attr('name', `newExS[${newIndex}][price]`);
	            }
	        });
        });
    }
</script>
