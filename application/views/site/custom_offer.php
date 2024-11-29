<?php include ("include/header.php") ?>
<style type="text/css">
	#accordion .card-body, #accordion h4{padding: 15px 20px; margin: 0px;}
	#accordion .card-header{border-bottom: 1px solid #dbdbdb;}
</style>

<div class="container">
	<div class="single-payment-offer">

		<h2 id="mainTitle">Create a single payment offer</h2>
		<h3><?php echo $service['service_name']; ?></h3>
		<p><?php echo $service['description']; ?></p>

		<form method="POST" name="submit_form" id="submit_form" enctype="multipart/form-data">
			<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_id; ?>">
			<input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $receiver_id; ?>">
			<input type="hidden" name="order_type" id="orderType" value="single">
			<input type="hidden" name="customOrderId" id="customOrderId" value="<?php echo !empty($custom_order) ? $custom_order['id'] : ''; ?>">
			<input type="hidden" name="milestoneIds" id="milestoneIds" value="<?php echo rtrim($mIds,','); ?>">
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
				<textarea class="form-control" rows="6" name="description" placeholder="Enter description" required></textarea>
				</br>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<p>Set up your offer or <a href="javascript:void(0)" onclick="toggleMilestones()" id="toggle-milestones">Switch to Miletones</a></p>
						<p>Define the terms of your offer and what it inclides.</p>
					</div>
				</div>
			</div>		

			<?php 
				$milestoneArray = ['1st Milestone'];
				function ordinal($number) {
					$suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
					if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
						return $number . 'th';
					} else {
						return $number . $suffixes[$number % 10];
					}
				}
			?>

			<div class="row milestone_div" style="display: none;">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div id="accordion" style="box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.08), 0 2px 4px 0 rgba(0, 0, 0, 0.12);border-radius: 10px;">
								
								<div id="milestoneList">
									<?php echo $milestoneList;?>
								</div>

								<div class="card card-primary" id="milestoneForm">
									<div class="card-header">
										<div class="row">
											<div class="col-md-7">
												<h4 class="w-100">
													<a class="d-block w-100 text-success" data-toggle="collapse" href="#collapse<?php echo count($milestones); ?>">
														<i class="fa fa-plus-circle"></i>
														Add a Milestone
													</a>
												</h4>
											</div>
											<?php if(!empty($totalAmtDays)):?>
												<div class="col-md-2 text-right">
													<h4 class="w-100">
														Total: <?php echo $totalAmtDays[0]['totalDays']; ?> days
													</h4>
												</div>
												<div class="col-md-3 text-right">
													<h4 class="w-100">
														<?php echo '£'.number_format($totalAmtDays[0]['mAmount'],2)?>
													</h4>
												</div>
											<?php endif;?>	
										</div>										
									</div>

									<div id="collapse<?php echo count($milestones); ?>" class="<?php if (count($milestones)>0) { ?>collapse<?php } else { ?>in<?php } ?>" data-parent="#accordion">
										<div class="card-body">
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<label><?php echo ordinal(count($milestones) + 1); ?> Milestone Name</label>
														<input type="text" class="form-control" name="milestone_name" id="milestone_name" required placeholder="Enter Milestone Name">
														<div class="error" id="milestone_name_error"></div>
													</div>
												</div>
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
														<select class="form-control" name="milestone_delivery" id="milestone_delivery" required>
															<option value="">Please Select</option>
															<option value="3">3 days</option>
															<option value="6">6 days</option>
															<option value="9">9 days</option>
														</select>
														<div class="error" id="milestone_delivery_error"></div>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group">
														<label>Price</label>
														<input type="number" class="form-control" name="milestone_price" id="milestone_price" step="0.01" pattern="^\d+(\.\d{1,2})?$" required placeholder="Enter price">
														<div class="error" id="milestone_price_error"></div>
													</div>
												</div>
												<?php if($service_category['price_type'] == 1):?>
													<div class="col-sm-3">
								              <label>Charge Per</label>
							                <select class="form-control input-md" name="milestone_price_per_type" id="milestone_price_per_type">
							                    <option value="">Please Select</option>
							                    <?php if(!empty($price_per_type)): ?>
							                        <?php foreach ($price_per_type as $value): ?>
							                            <?php 
							                              $selected = $value == $serviceData['price_per_type'] ? 'selected' : '';
							                            ?>
							                            <option value="<?php echo $value; ?>" <?php echo $selected; ?> >
							                                <?php echo $value; ?>
							                            </option>
							                        <?php endforeach;?>
							                    <?php endif;?>    
							                </select>
							                <div class="error" id="price_per_type_error"></div>
								          </div>
								     		<?php endif; ?>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<textarea class="form-control" rows="4" name="milestone_details" id="milestone_details" placeholder="Describe your offer in details (options)" required></textarea>
														<div class="error" id="milestone_details_error"></div>
														<p>Adding a description helps set expectations with buyers.</p>
													</div>
													<div class="pull-right">
														<button class="btn btn-success" type="button" id="milestoneSave">Save</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="youll-text">
										<p>You'll get paid for each milestone once it's marked as completed.</p>
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
					
					<?php if($service_category['price_type'] == 1):?>
						<div class="col-sm-3">
	              <label>Charge Per</label>
                <select class="form-control input-md" name="price_per_type" id="price_per_type">
                    <option value="">Please Select</option>
                    <?php if(!empty($price_per_type)): ?>
                        <?php foreach ($price_per_type as $value): ?>
                            <?php 
                                $selected = $value == $serviceData['price_per_type'] ? 'selected' : '';
                            ?>
                            <option value="<?php echo $value; ?>" <?php echo $selected; ?> >
                                <?php echo $value; ?>
                            </option>
                        <?php endforeach;?>
                    <?php endif;?>    
                </select>
	          </div>
	     		<?php endif; ?>
				</div>
			</div>
			<ul class="mainUl">
				<li>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="is_offer_expires" name="is_offer_expires" value="1" onclick="toggleSelectBox(0)">
						<label class="form-check-label" for="is_offer_expires">Offer expires in</label>
					</div>
					<div class="form-group" style="margin-bottom: 0px;">
						<select class="form-control" id="offer_expires_days0" disabled name="offer_expires_days">
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

			<?php if(!empty($attributes) && !empty($package_data)):?>
				<div>
					<h4>Offer includes</h4>
					<?php 
						$basicAtt = isset($package_data) && isset($package_data->basic->attributes) ? $package_data->basic->attributes : [];
						$standardAtt = isset($package_data) && isset($package_data->standard->attributes) ? $package_data->standard->attributes : [];
						$premiumAtt = isset($package_data) && isset($package_data->premium->attributes) ? $package_data->premium->attributes : [];
						$allAttributes = array_unique(array_merge($basicAtt, $standardAtt, $premiumAtt));
					?>
					<ul class="pl-0">
						<?php foreach($attributes as $key => $value):?>
							<?php if(in_array($value['id'], $allAttributes)):?>
								<li>
									<div class="form-check">
										<input class="form-check-input" name="offer_includes_ids[basic][]" type="checkbox" value="<?php echo $value['id']?>" id="basic_<?php echo $value['id']?>">
										<label class="form-check-label" for="basic_<?php echo $value['id']?>">
											<?php echo $value['attribute_name']?>
										</label>
									</div>
								</li>
							<?php endif; ?>	
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif;?>
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
		$('#mainTitle').text('Create a milestones offer');
		$('#orderType').val('milestone');
    	/*$('#milestoneName').css('display', 'block');
    	$('#milestoneDetails').css('display', 'block');
    	$('.milestone_name').prop('required', true);
    	$('.milestone_details').prop('required', true);*/
	} else {
		$('.regular_div').css('display', 'block');
		$('.milestone_div').css('display', 'none');
		$('#toggle-milestones').text('Switch to miletones');
		$('#mainTitle').text('Create a single payment offer');
		$('#orderType').val('single');
    	/*$('#milestoneName').css('display', 'none');
    	$('#milestoneDetails').css('display', 'none');
    	$('.milestone_name').prop('required', false);
    	$('.milestone_details').prop('required', false);*/
	}
    isFirstClick = !isFirstClick; // Toggle the flag
  }

  function toggleSelectBox(dId) {
  	console.log(dId);
  	var checkBox = document.getElementById("is_offer_expires");
  	var selectBox = document.getElementById("offer_expires_days"+dId);
  	selectBox.disabled = !checkBox.checked;
  }

  $(document).ready(function () {
  	<?php 
  	if(!empty($milestones)){ ?>
  		$('#toggle-milestones').trigger('click');
  		<?php
  	} ?>
    
  	$("#submit_form").validate({
  		rules: {
  			description: "required",
  			delivery: "required",
  			price_per_type: "required",
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
  			price_per_type: "Please select the type of charge",
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

  	function validateField(selector, validationType, errorMessage) {
      var field = $(selector);
      var value = field.val();
      var errorContainer = $(selector + "_error");

      errorContainer.text('');
      field.removeClass('is-invalid');

      if (validationType == 'required' && !value.trim()) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "This field is required.");
          return false;
      } 

      if (validationType == 'number' && isNaN(value)) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "Please enter a valid number.");
          return false;
      } else if (validationType == 'min' && parseFloat(value) <= 0) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "Value must be greater than 0.");
          return false;
      }

      return true;
    }

    function resetMilestoneForm() {
      $('#milestoneForm').find('input[type="text"], input[type="number"], input[type="radio"], input[type="checkbox"], select, textarea').each(function () {
          $(this).val(''); // Reset the value
          $(this).prop('checked', false); // For checkboxes and radio buttons
      });
      $('#milestoneForm').find('.error-message').text('');
      $('#milestoneForm').find('.is-invalid').removeClass('is-invalid');
    }

    $('#milestoneSave').on('click', function () {
      var isValid = true;
      isValid &= validateField('#milestone_name', 'required', "Please enter a milestone name");
      isValid &= validateField('#milestone_delivery', 'required', "Please select a delivery option");
      isValid &= validateField('#milestone_price', 'required', "Please enter a price");
      if ($('#milestone_price').val() != '') {
      	isValid &= validateField('#milestone_price', 'number', "Please enter a valid price");
      }
      
      isValid &= validateField('#milestone_details', 'required', "Please enter a description");

      if ($('#milestone_price_per_type').val() === '') {
        $('#milestone_price_per_type').addClass('is-invalid');
        $('#price_per_type_error').text("Please select a charge per option");
        isValid = false;
      } else {
        $('#milestone_price_per_type').removeClass('is-invalid');
        $('#price_per_type_error').text('');
      }

      var name = $('#milestone_name').val();
      var delivery = $('#milestone_delivery').val();
      var price = $('#milestone_price').val();
      var description = $('#milestone_details').val();
      var price_per_type = $('#milestone_price_per_type').val();
      var service_id = $('#service_id').val();
      var receiver_id = $('#receiver_id').val();
      var order_type = $('#orderType').val();

      if (isValid) {
        $.ajax({
  				url: "<?php echo site_url('custom_offer/milestoneStore') ?>",
  				type: 'POST',
  				data: {name:name,delivery:delivery,price:price,description:description,price_per_type:price_per_type,service_id:service_id,receiver_id:receiver_id,order_type:order_type},
  				dataType: 'json',
  				beforeSend: function () {
  					$(this).prop('disabled', true);
  					$(this).html('<i class="fa fa-spin fa-spinner"></i> Save...');
  				},
  				success: function (resp) {
  					console.log(resp);
  					console.log('in ajax success 1');
  					console.log(resp.milestoneList);
  					console.log('in ajax success 2');


  					if(resp.status == 1){
  						/*$('#customOrderId').val(resp.oId);
  						$('#milestoneList').empty();
  						$('#milestoneList').html(resp.milestoneList);
  						var mIds = $('#milestoneIds').val();
  						if(mIds != ""){
  							var newMids = mIds+','+resp.milestoneId;	
  						}else{
  							var newMids = resp.milestoneId;
  						}  						
  						$('#milestoneIds').val(newMids);
  						resetMilestoneForm();*/
  						swal(resp.success);
  						setTimeout(function(){
  							location.reload();
  						}, 2000);
  					}else{
  						swal(resp.error);
  						setTimeout(function(){
  							location.reload();
  						}, 2000);
  					}

  					$(this).prop('disabled', false);
  					$(this).html('Save');
  				}
  			});
      }
    });
  });
</script>  
<?php include ("include/footer.php") ?>