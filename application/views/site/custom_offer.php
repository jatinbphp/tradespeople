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

			<div class="col-sm-12">
				<div class="form-group">
					<p>Set up your offer or <a href="#">Switch to Miletones</a></p>
					<p>Define the terms of your offer and what it inclides.</p>
				</div>
			</div>

			<div class="box-bg">
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
					<div class="col-sm-6">
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
function toggleSelectBox() {
    var checkBox = document.getElementById("is_offer_expires");
    var selectBox = document.getElementById("offer_expires_days");
    selectBox.disabled = !checkBox.checked;
}

$(document).ready(function () {
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
/*
$("#submit_form").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: "<?php echo site_url('custom_offer/store') ?>",
        type: 'POST',
        data: new FormData(this),
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
            
            $("#submit_form").trigger('reset');
        }
    });
});    */     
</script>  
<?php include ("include/footer.php") ?>