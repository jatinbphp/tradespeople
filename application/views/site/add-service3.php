
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
						<?php if(!empty($ex_service)):?>
							<div class="row">
								<?php
									$exServices = $serviceData['extra_service'] ?? '';
									$selectedExServices = explode(',', $exServices);
								?>
								<?php foreach($ex_service as $list):?>
									<div class="col-sm-12">
										<div class="form-group">
											<div class="form-check" style="margin: 0;">
												<input class="form-check-input" <?php echo in_array($list['id'], $selectedExServices) ? 'checked' : ''; ?> type="checkbox" name="extra_service[]" value="<?php echo $list['id']?>" style="margin-right:10px;">
												<label class="form-check-label" style="margin-top:10px; font-weight: normal;"><?php echo $list['ex_service_name']?></label>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<div id="ex-service-div" style="margin-top:10px">
							<?php if(isset($serviceData['trades_ex_service']) && $serviceData['trades_ex_service']): ?>
							<?php $i= 1;?>
							<?php foreach($serviceData['trades_ex_service'] as $key => $exs): ?>
								<div class="row" id="newExS<?php echo $i; ?>" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">
									<input type="hidden" name="newExS[<?php echo $i; ?>][id]" value="<?php echo $exs['id'] ?? '' ?>">
									<input type="hidden" name="newExS[<?php echo $i; ?>][category]" value="<?php echo $exs['category'] ?? '' ?>">
									<div class="col-md-5" style="margin-top:10px;">
										<div class="form-group">
											<label class="control-label" for="ex_service_name<?php echo $i; ?>" style="width:100%">
												Extra Service Name
											</label>
											<div>
												<input type="text" class="form-control input-md" name="newExS[<?php echo $i; ?>][ex_service_name]" id="ex_service_name<?php echo $i; ?>" placeholder="Extra Service Name" value="<?php echo $exs['ex_service_name'] ?? '' ?>" required>
											</div>
										</div>
									</div>
									<div class="col-md-3" style="margin-top:10px;">
										<div class="form-group">
											<label class="control-label" for="price<?php echo $i; ?>">
												Extra Service Price
											</label>
											<div class="">
												<input type="number" class="form-control input-md" name="newExS[<?php echo $i; ?>][price]" id="price<?php echo $i; ?>" placeholder="Extra Service Price" value="<?php echo $exs['price'] ?? '' ?>" required>
											</div>
										</div>
									</div>
									<div class="col-md-3" style="margin-top:10px;">
										<div class="form-group">
											<label class="control-label" for="additional_working_days<?php echo $i; ?>" style="width:100%">
												Additional Working Days
											</label>
											<div>
												<input type="number" step="1" class="form-control input-md" name="newExS[<?php echo $i; ?>][additional_working_days]" id="additional_working_days<?php echo $i; ?>" placeholder="Additional Working Days" value="<?php echo $exs['additional_working_days'] ?? '' ?>" required>
											</div>
										</div>
									</div>
									<div class="col-md-1" style="margin-top:10px;">
										<div class="form-group">
											<span id="remove<?php echo $i; ?>" class="btn btn-sm btn-danger pull-right removeExService" data-id="<?php echo $i; ?>"><i class="fa fa-trash"></i></span>
										</div>
									</div>
								</div>
								<?php $i++; ?>
							<?php endforeach ?>
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
		totalnewExService++;
		var exservicehtml = '<div class="row" id="newExS'+totalnewExService+'" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">'+
					'<input type="hidden" name="newExS['+totalnewExService+'][id]" value="0">'+
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
								'<input type="number" class="form-control input-md" name="newExS['+totalnewExService+'][price]" step="1" id="additional_working_days'+totalnewExService+'" placeholder="Additional Working Days" rows="3" required>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-1" style="margin-top:10px;">'+
						'<div class="form-group">'+
						'<span id="remove'+totalnewExService+'" class="btn btn-sm btn-danger pull-right removeExService" data-id="'+totalnewExService+'"><i class="fa fa-trash"></i></span></label>'+
					'</div>'+
				'</div>';

				console.log(exservicehtml);

		$('#ex-service-div').append(exservicehtml);
		updateExsIndices();
	});	


	$('#ex-service-div').on('click', '.removeExService', function (event) {
		event.preventDefault();
		var fId = $(this).attr('data-id');
		console.log(fId);
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
