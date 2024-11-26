<?php include ("include/header.php") ?>

<div class="container">
	<div class="single-payment-offer">

		<h2><?php echo $service['service_name']; ?></h2>
		<h5><?php echo $service['description']; ?></h5>

		<form method="POST" name="submit_form" id="submit_form" enctype="multipart/form-data">
			<input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
			<input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
			<div class="form-group img-textarea">
				<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
				<?php if (file_exists($image_path) && $service['image']): ?>
					<?php
		                $mime_type = get_mime_by_extension($image_path);
		                $is_image = strpos($mime_type, 'image') !== false;
		                $is_video = strpos($mime_type, 'video') !== false;
		            ?>
		            <?php if ($is_image): ?>
						<img src="<?php echo  base_url().'img/services/'.$service['image']; ?>">
					<?php elseif ($is_video): ?>
						<video src="<?php echo base_url('img/services/') . $service['image']; ?>" 
						type="<?php echo $mime_type; ?>" loop controls class="profileServiceVideo">
						</video>
					<?php else: ?>
						<img src="<?php echo  base_url().'img/default-image.jpg'; ?>">
					<?php endif; ?>
				<?php else: ?>
					<img src="<?php echo  base_url().'img/default-image.jpg'; ?>">
				<?php endif; ?>
				<textarea class="form-control" rows="6" name="description" placeholder="Enter description" required></textarea></br>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<p>Set up your offer or <a href="javascript:void(0)" onclick="toggleMilestones()" id="toggle-milestones">Switch to Miletones</a></p>
						<p>Define the terms of your offer and what it inclides.</p>
					</div>
				</div>
			</div>

			<style type="text/css">
				#accordion .card-body, #accordion h4{padding: 15px 20px; margin: 0px;}
				#accordion .card-header{border-bottom: 1px solid #dbdbdb;}
			</style>

			<?php 
			$milestoneArray = ['1st Milestone'];?>

			<div class="row milestone_div" style="display: none;">
				<div class="col-md-12">
				    <div class="card">
				        <div class="card-body">
				            <div id="accordion" style="box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.08), 0 2px 4px 0 rgba(0, 0, 0, 0.12);border-radius: 10px;">
				            	<?php

				            	function ordinal($number) {
								    $suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
								    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
								        return $number . 'th';
								    } else {
								        return $number . $suffixes[$number % 10];
								    }
								}

								if(!empty($milestones)){
									$lastKey = array_key_last($milestones);

					            	foreach ($milestones as $key => $value) { ?>
					            		<div class="card card-primary">
						                    <div class="card-header">
						                        <h4 class="card-title w-100">
						                            <a class="d-block w-100" data-toggle="collapse" href="#collapse<?php echo $key; ?>">
					                            	 	<?php echo ordinal($key + 1); ?> Milestone - <?php echo $value['milestone_name']; ?>
						                            </a>
						                        </h4>
						                    </div>
						                    <div id="collapse<?php echo $key; ?>" class="collapse" data-parent="#accordion">
						                        <div class="card-body">
													<div class="row">
														<div class="col-sm-3">
															<div class="form-group">
																<label><?php echo ordinal($key + 1); ?> Milestone Name</label>
																<input type="text" class="form-control" name="milestone_name" required placeholder="Enter Milestone Name">
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label>Revisions (optional)</label>
																<select class="form-control" name="revisions">
																	<option value="">Please Select</option>
																	<option value="0">0</option>
																	<option value="1">1</option>
																	<option value="2">2</option>
																</select>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label>Delivery</label>
																<select class="form-control" name="delivery" required>
																	<option value="">Please Select</option>
																	<option value="3">3 days</option>
																	<option value="6">6 days</option>
																	<option value="9">9 days</option>
																</select>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group" name="price">
																<label>Price</label>
																<input type="number" class="form-control" name="price" step="0.01" pattern="^\d+(\.\d{1,2})?$" required placeholder="Enter price">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-sm-12">
															<div class="form-group">
																<textarea class="form-control" rows="4" name="milestone_details" placeholder="Describe your offer in details (options)" required></textarea>
																<p>Adding a description helps set expectations with buyers.</p>
															</div>
															<div class="pull-right">
																<button class="btn btn-success" type="button">Save</button>
															</div>
														</div>
													</div>
						                        </div>
						                    </div>
						                </div>
					            	<?php 
					            	} 
				            	}?>

				            	<?php
				            	if(!empty($milestoneArray)){
					            	foreach ($milestoneArray as $key => $value) { ?>
						            	<div class="card card-primary">
						                    <div class="card-header">
						                        <h4 class="card-title w-100">
						                            <a class="d-block w-100" data-toggle="collapse" href="#collapse<?php echo count($milestones); ?>">
					                            	 	Add a Milestone
						                            </a>
						                        </h4>
						                    </div>
						                    <div id="collapse<?php echo count($milestones); ?>" class="<?php if (count($milestones)>0) { ?>collapse<?php } else { ?>in<?php } ?>" data-parent="#accordion">
						                        <div class="card-body">
													<div class="row">
														<div class="col-sm-3">
															<div class="form-group">
																<label><?php echo ordinal(count($milestones) + 1); ?> Milestone Name</label>
																<input type="text" class="form-control" name="milestone_name" required placeholder="Enter Milestone Name">
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label>Revisions (optional)</label>
																<select class="form-control" name="revisions">
																	<option value="">Please Select</option>
																	<option value="0">0</option>
																	<option value="1">1</option>
																	<option value="2">2</option>
																</select>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<label>Delivery</label>
																<select class="form-control" name="delivery" required>
																	<option value="">Please Select</option>
																	<option value="3">3 days</option>
																	<option value="6">6 days</option>
																	<option value="9">9 days</option>
																</select>
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group" name="price">
																<label>Price</label>
																<input type="number" class="form-control" name="price" step="0.01" pattern="^\d+(\.\d{1,2})?$" required placeholder="Enter price">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-sm-12">
															<div class="form-group">
																<textarea class="form-control" rows="4" name="milestone_details" placeholder="Describe your offer in details (options)" required></textarea>
																<p>Adding a description helps set expectations with buyers.</p>
															</div>
															<div class="pull-right">
																<button class="btn btn-success" type="button">Save</button>
															</div>
														</div>
													</div>
						                        </div>
						                    </div>
						                </div>
				                	<?php 
					            	} 
				            	}?>
				            	<hr>
				            	<div class="card-body">
					            	<ul class="mainUl">
										<li>
											<div class="form-check">
											    <input class="form-check-input" type="checkbox" id="is_offer_expires" name="is_offer_expires" value="1" onclick="toggleSelectBox()">
											    <label class="form-check-label" for="is_offer_expires">Offer expires in</label>
											</div>
											<div class="form-group" style="margin-bottom: 0px;">
												<select class="form-control" id="offer_expires_days" disabled name="offer_expires_days">
													<option value="">Select Days</option>
												    <option value="1">1 day</option>
												    <option value="3">3 days</option>
												    <option value="6">6 days</option>
												</select>
											</div>
										</li>
										<li>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="is_requirements" name="is_requirements" value="1">
												<label class="form-check-label" for="is_requirements">Request for requirements</label>
											</div>
										</li>					
									</ul>

							        <div class="accordion">
							            <!-- Accordion Item 1 -->
							            <div class="accordion-item">
								            <input type="checkbox" id="accordion1" name="offer_includes" value="1" />
							                <label class="accordion-label" for="accordion1">Offer includes</label>
								                   
							                <div class="accordion-content">
							                    <?php 
													$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
													$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
													$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
												?>

												<?php if(!empty($attributes)):?>
													<ul>
														<?php foreach($attributes as $key => $value):?>
															<?php 
																$bchecked = !empty($basicAtt) && in_array($value['id'], $basicAtt) ? 'checked' : '';
																$schecked = !empty($standardAtt) && in_array($value['id'], $standardAtt) ? 'checked' : '';
																$pchecked = !empty($premiumAtt) && in_array($value['id'], $premiumAtt) ? 'checked' : '';
															?>

															<?php
															if($bchecked=='checked'){ ?>
																<li>
																	<div class="form-check">
																		<input class="form-check-input" name="offer_includes_ids[basic][]" type="checkbox" value="<?php echo $value['id']?>" id="basic_<?php echo $value['id']?>">
																		<label class="form-check-label" for="basic_<?php echo $value['id']?>">
																			<?php echo $value['attribute_name']?>
																		</label>
																	</div>
																</li>
															<?php
															} ?>

															<?php
															if($schecked=='checked'){ ?>
																<li>
																	<div class="form-check">
																		<input class="form-check-input" name="offer_includes_ids[standard][]" type="checkbox" value="<?php echo $value['id']?>" id="standard_<?php echo $value['id']?>">
																		<label class="form-check-label" for="standard_<?php echo $value['id']?>">
																			<?php echo $value['attribute_name']?>
																		</label>
																	</div>
																</li>
															<?php
															} ?>

															<?php
															if($pchecked=='checked'){ ?>
																<li>
																	<div class="form-check">
																		<input class="form-check-input" name="offer_includes_ids[premium][]" type="checkbox" value="<?php echo $value['id']?>" id="premium_<?php echo $value['id']?>">
																		<label class="form-check-label" for="premium_<?php echo $value['id']?>">
																			<?php echo $value['attribute_name']?>
																		</label>
																	</div>
																</li>
															<?php
															} ?>
														<?php endforeach; ?>
													</ul>
												<?php endif;?>
							                </div>
							            </div>
							        </div>
						        </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>

			<div class="box-bg regular_div">
				<div class="row">
					<!--<div class="col-sm-3">
						<div class="form-group">
							<label>Revisions (optional)</label>
							<select class="form-control" name="revisions">
								<option value="">Please Select</option>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
							</select>
						</div>
					</div>-->
					<div class="col-sm-3">
						<div class="form-group">
							<label>Delivery</label>
							<select class="form-control" name="delivery" required>
								<option value="">Please Select</option>
								<option value="3">3 days</option>
								<option value="6">6 days</option>
								<option value="9">9 days</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" name="price">
							<label>Price</label>
							<input type="number" class="form-control" name="price" step="0.01" pattern="^\d+(\.\d{1,2})?$" required placeholder="Enter price">
						</div>
					</div>
				</div>
				<ul class="mainUl">
					<li>
						<div class="form-check">
						    <input class="form-check-input" type="checkbox" id="is_offer_expires" name="is_offer_expires" value="1" onclick="toggleSelectBox()">
						    <label class="form-check-label" for="is_offer_expires">Offer expires in</label>
						</div>
						<div class="form-group" style="margin-bottom: 0px;">
							<select class="form-control" id="offer_expires_days" disabled name="offer_expires_days">
								<option value="">Select Days</option>
							    <option value="1">1 day</option>
							    <option value="3">3 days</option>
							    <option value="6">6 days</option>
							</select>
						</div>
					</li>
					<li>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="is_requirements" name="is_requirements" value="1">
							<label class="form-check-label" for="is_requirements">Request for requirements</label>
						</div>
					</li>					
				</ul>

		        <div class="accordion">
		            <!-- Accordion Item 1 -->
		            <div class="accordion-item">
			            <input type="checkbox" id="accordion1" name="offer_includes" value="1" />
		                <label class="accordion-label" for="accordion1">Offer includes</label>
			                   
		                <div class="accordion-content">
		                    <?php 
								$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
								$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
								$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
							?>

							<?php if(!empty($attributes)):?>
								<ul>
									<?php foreach($attributes as $key => $value):?>
										<?php 
											$bchecked = !empty($basicAtt) && in_array($value['id'], $basicAtt) ? 'checked' : '';
											$schecked = !empty($standardAtt) && in_array($value['id'], $standardAtt) ? 'checked' : '';
											$pchecked = !empty($premiumAtt) && in_array($value['id'], $premiumAtt) ? 'checked' : '';
										?>

										<?php
										if($bchecked=='checked'){ ?>
											<li>
												<div class="form-check">
													<input class="form-check-input" name="offer_includes_ids[basic][]" type="checkbox" value="<?php echo $value['id']?>" id="basic_<?php echo $value['id']?>">
													<label class="form-check-label" for="basic_<?php echo $value['id']?>">
														<?php echo $value['attribute_name']?>
													</label>
												</div>
											</li>
										<?php
										} ?>

										<?php
										if($schecked=='checked'){ ?>
											<li>
												<div class="form-check">
													<input class="form-check-input" name="offer_includes_ids[standard][]" type="checkbox" value="<?php echo $value['id']?>" id="standard_<?php echo $value['id']?>">
													<label class="form-check-label" for="standard_<?php echo $value['id']?>">
														<?php echo $value['attribute_name']?>
													</label>
												</div>
											</li>
										<?php
										} ?>

										<?php
										if($pchecked=='checked'){ ?>
											<li>
												<div class="form-check">
													<input class="form-check-input" name="offer_includes_ids[premium][]" type="checkbox" value="<?php echo $value['id']?>" id="premium_<?php echo $value['id']?>">
													<label class="form-check-label" for="premium_<?php echo $value['id']?>">
														<?php echo $value['attribute_name']?>
													</label>
												</div>
											</li>
										<?php
										} ?>
									<?php endforeach; ?>
								</ul>
							<?php endif;?>
		                </div>
		            </div>
		        </div>
            </div>
			<div class="form-btn-group">
				<button class="btn" type="submit"><i class="fa fa-arrow-left"></i> Back</button>
				<button class="btn btn-warning sendbtn1" type="submit">Send Offer</button>
			</div>
		</form>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
let isFirstClick = true; // Initialize the toggle flag

function toggleMilestones() {
    if (isFirstClick) {
    	$('.regular_div').css('display', 'none');
    	$('.milestone_div').css('display', 'block');
    	$('#toggle-milestones').text('Switch to single payment offer');
    	/*$('#milestoneName').css('display', 'block');
    	$('#milestoneDetails').css('display', 'block');
    	$('.milestone_name').prop('required', true);
    	$('.milestone_details').prop('required', true);*/
    } else {
    	$('.regular_div').css('display', 'block');
    	$('.milestone_div').css('display', 'none');
    	$('#toggle-milestones').text('Switch to miletones');
    	/*$('#milestoneName').css('display', 'none');
    	$('#milestoneDetails').css('display', 'none');
    	$('.milestone_name').prop('required', false);
    	$('.milestone_details').prop('required', false);*/
    }
    isFirstClick = !isFirstClick; // Toggle the flag
}

function toggleSelectBox() {
    var checkBox = document.getElementById("is_offer_expires");
    var selectBox = document.getElementById("offer_expires_days");
    selectBox.disabled = !checkBox.checked;
}

$(document).ready(function () {

	<?php 
	if(!empty($milestones)){ ?>
		$('#toggle-milestones').trigger('click');
	<?php
	} ?>
    // Initialize jQuery validation
    $("#submit_form").validate({
        rules: {
            description: "required",
            delivery: "required",
            price: {
                required: true,
                number: true
            },
            offer_expires_days: {
                required: function () {
                    return $("#is_offer_expires").is(":checked");
                }
            }
        },
        messages: {
            description: "Please enter a description",
            delivery: "Please enter the delivery details",
            price: {
                required: "Please enter a price",
                number: "Please enter a valid price"
            },
            offer_expires_days: "Please select the number of days for offer expiration"
        },
        submitHandler: function (form) {
            $.ajax({
                url: "<?php echo site_url('custom_offer/store') ?>",
                type: 'POST',
                data: new FormData(form),
                dataType: 'JSON',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    $('.sendbtn1').prop('disabled', true);
                    $('.sendbtn1').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
                },
                success: function (resp) {
                    $('.sendbtn1').prop('disabled', false);
                    $('.sendbtn1').html(resp.button);

                    if (resp.success) {
                        $("#submit_form").trigger('reset');
                        swal(resp.success);
                        setTimeout(function(){
                        	window.location.href = "<?php echo site_url('my-orders') ?>";
                    	}, 2000);
                    } else if (resp.error) {
                    	swal(resp.error);
                    	setTimeout(function(){
	  						location.reload();
	  					}, 2000);
                    }
                }
            });
        }
    });
});  
</script>  
<?php include ("include/footer.php") ?>