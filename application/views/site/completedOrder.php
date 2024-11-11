<?php include ("include/header.php") ?>
<style>
	.payment_method{
		margin-right: 10px!important;
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

	.member-summary .member-image{
		width: 60px;
		height: 60px;
		max-width: none;
		max-height: none;
	}

	.rating {
		display: flex;
		justify-content: center;
		align-items: center;
		grid-gap: .5rem;
		font-size: 2rem;
		color: var(--yellow);
		/*margin-bottom: 2rem;*/
	}

	.rating .star {
		cursor: pointer;
	}

	.rating .star.active {
		color: gold;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	.rating .tradeStar {
		cursor: pointer;
	}

	.rating .tradeStar.active {
		color: gold;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	.rating .tradeStar2 {
		cursor: pointer;
	}

	.rating .tradeStar2.active {
		color: gold;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	@keyframes animate {
		0% {
			opacity: 0;
			transform: scale(1);
		}
		50% {
			opacity: 1;
			transform: scale(1.2);
		}
		100% {
			opacity: 1;
			transform: scale(1);
		}
	}

	.rating .star:hover {
		transform: scale(1.1);
	}

	.rating .tradeStar:hover {
		transform: scale(1.1);
	}

	.rating .tradeStar2:hover {
		transform: scale(1.1);
	}

	.rating-form {
		padding: 0 30px;
	}
	.rating-list {
		display: flex;
		justify-content: space-between;
		gap: 0 30px;
		margin-bottom: 10px;
	}
	.rating-list .rating {
		width: auto;
		flex-direction:column;
	}
	.rating-list .rating > div {
    margin-left: auto;
	}

	.rating-form h2 {
		font-weight: 600;
		color: rgba(0, 0, 0, 0.3);
		font-size: 24px;
	}
	.rating-form h3 {
		font-weight: 600;
		font-size: 24px;
		margin-top: 0;
		margin-bottom: 30px;
	}

	.rating-list p {
		color: rgba(0, 0, 0, 0.5);
		font-size: 16px;
	}
	.rating-list p b {
		color: #464c5b;
	}
	.rating-form textarea.form-control {
		border-width: 1px;
		font-size: 16px;
	}
	.rating-form .review-div {
		margin-top: 30px;
	}
	.rating-form .review-div label {
		font-size: 18px;
		font-weight: 600;
	}
</style>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="thank-purchase-msg alert alert-success">
					<span class="icon">
						<i class="fa fa-check" aria-hidden="true"></i>
					</span>
					<div>
						<h2>
							<?php if($order['is_review'] != 1):?>
								Congratulation for completing your order
							<?php else: ?>
								Congratulation for completed your order
							<?php endif;?>
						</h2>
						<p>Share your experience with other users</p>
					</div>
				</div>

				<div class="rating-form">
						<?php if($order['is_review'] != 1):?>
							<h2>
							Public Feedback
								<h3>Share your experience with the community, to help them make better decisions.</h3>
							</h2>
							<form class="mt-3" id="order_service_review_form" style="width:100%">
								<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
								<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
								<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
								<div class="rating-list">
									<p><b>Communication With Seller</b><br> 
									How responsive was the seller during the process?</p>
									<div class="rating" id="orderRating">
										<div id="orderStartDiv">
											<input type="hidden" name="rating" id="ratingValue">
											<?php for($i=0; $i<=4; $i++):?>
												<i class="fa fa-star-o star" style="--i: <?php echo $i?>;" onclick="handleStarClick(<?php echo $i?>)"></i>
											<?php endfor;?>
										</div>
									</div>
								</div>
								<div class="rating-list">
									<p><b>Service as Described</b><br>
										Did the result match the servies's description?
									</p>
									<div class="rating tradeRating" id="tRating">
										<div id="tradesStartDiv">
											<input type="hidden" name="seller_communication_rating" id="ratingValue1">
											<?php for($j=0; $j<=4; $j++):?>
												<i class="fa fa-star-o tradeStar" style="--i: <?php echo $j?>;" onclick="handleTradeStarClick(<?php echo $j?>)"></i>
											<?php endfor;?>
										</div>	
									</div>
								</div>
								<div class="rating-list">
									<p><b>Buy Again or Recommanded</b><br>
										Would you recommanded buying this service?
									</p>
									<div class="rating tradeRating2" id="tRating2">
										<div id="recommandedStartDiv">
											<input type="hidden" name="recommanded_service_rating" id="ratingValue2">
											<?php for($j=0; $j<=4; $j++):?>
												<i class="fa fa-star-o tradeStar2" style="--i: <?php echo $j?>;" onclick="handleRecommandedStarClick(<?php echo $j?>)"></i>
											<?php endfor;?>
										</div>
									</div>
								</div>

								<div class="review-div">
									<label>What was it like working with this Seller?</label>
									<textarea name="reviews" class="form-control" rows="5" placeholder="Your review..."></textarea>
								</div>
								<div class="text-center mt-4">
									<button type="submit" id="give-rating" class="btn btn-warning">
										Submit
									</button>
								</div>
							</form>
						<?php else: ?>
							<?php 
								if(isset($homeOwner['profile']) && !empty($homeOwner['profile'])){
									$uprofileImg = base_url('img/profile/'.$homeOwner['profile']);
								}else{
									$uprofileImg = base_url('img/default-img.png');
								}
								$homeUserName = ($homeOwner['f_name'] ?? '').' '.($homeOwner['l_name'] ??  '');
							?>

							<div class="member-summary mb-5">
								<div class="summary member-summary-section">
									<div class="member-image-container">
										<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $homeUserName?>">
									</div>
									<div class="member-information-container">
										<div class="member-name-container crop">
											<h3 style="margin-bottom: 5px;"><?php echo $homeUserName?></h3>
											<div class="member-job-title crop">
												<?php echo $review['review']; ?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="rating-list">
								<p><b>Communication With Seller</b><br> 
								How responsive was the seller during the process?</p>
								<div class="rating" id="orderRating">
									<div id="orderStartDiv">
										<?php for($i=1; $i<=5; $i++):?>
											<?php $active = $review['rating'] >= $i ? 'active' : ''; ?>
											<i class="fa fa-star-o star <?php echo $active; ?>"></i>
										<?php endfor;?>
									</div>
								</div>
							</div>
							<div class="rating-list">
								<p><b>Service as Described</b><br>
									Did the result match the servies's description?
								</p>
								<div class="rating tradeRating" id="tRating">
									<div id="tradesStartDiv">
										<?php for($i=1; $i<=5; $i++):?>
											<?php $active1 = $review['seller_communication_rating'] >= $i ? 'active' : ''; ?>
											<i class="fa fa-star-o star <?php echo $active1; ?>"></i>
										<?php endfor;?>
									</div>	
								</div>
							</div>
							<div class="rating-list">
								<p><b>Buy Again or Recommanded</b><br>
									Would you recommanded buying this service?
								</p>
								<div class="rating tradeRating2" id="tRating2">
									<div id="recommandedStartDiv">
										<?php for($i=1; $i<=5; $i++):?>
											<?php $active2 = $review['recommanded_service_rating'] >= $i ? 'active' : ''; ?>
											<i class="fa fa-star-o star <?php echo $active2; ?>"></i>
										<?php endfor;?>
									</div>
								</div>
							</div>

							<?php if($user_type == 1):?>
								<?php if($review['is_responded'] == 0):?>
									<form class="mt-3" id="seller_respond_form" style="width:100%">
										<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
										<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
										<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
										<div class="review-div">
											<label>You may respond to this review (This will be public)</label>
											<textarea name="seller_response" class="form-control" rows="5" placeholder="Your reponse..."></textarea>
										</div>
										<div class="text-center mt-4">
											<button type="submit" id="give-rating" class="btn btn-warning">
												Submit
											</button>
										</div>
									</form>
								<?php else:?>									
									<?php 
										if(isset($tradesman['profile']) && !empty($tradesman['profile'])){
											$tProfileImg = base_url('img/profile/'.$tradesman['profile']);
										}else{
											$tProfileImg = base_url('img/default-img.png');
										}
										$tradeUserName = ($tradesman['trading_name'] ?? '');
									?>
									<div class="member-summary mb-5 mt-5">
										<h3 style="margin-bottom: 5px;">Seller's Response</h3>
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h3 style="margin-bottom: 5px;"><?php echo $tradeUserName?></h3>
													<div class="member-job-title crop">
														<?php echo $review['seller_response']; ?>
													</div>
												</div>
											</div>
										</div>
									</div>								
								<?php endif;?>
							<?php else:?>	
								<?php if($review['is_responded'] == 1):?>
									<?php 
										if(isset($tradesman['profile']) && !empty($tradesman['profile'])){
											$tProfileImg = base_url('img/profile/'.$tradesman['profile']);
										}else{
											$tProfileImg = base_url('img/default-img.png');
										}
										$tradeUserName = ($tradesman['trading_name'] ?? '');
									?>
									<div class="member-summary mb-5 mt-5">
										<h3 style="margin-bottom: 5px;">Seller's Response</h3>
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h3 style="margin-bottom: 5px;"><?php echo $tradeUserName?></h3>
													<div class="member-job-title crop">
														<?php echo $review['seller_response']; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>
							<?php endif;?>							
						<?php endif;?>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="box-border p-4 submit-requirements-sidebar">
						<?php 
							$image_path = FCPATH . 'img/services/' . ($service['image'] ?? '');
							$mime_type = get_mime_by_extension($image_path);
              $is_image = strpos($mime_type, 'image') !== false;
              $is_video = strpos($mime_type, 'video') !== false;
						?>

						<?php if (file_exists($image_path) && $service['image']): ?>
							<?php if ($is_image): ?>
								<img src="<?php echo base_url('img/services/') . $service['image']; ?>" class="img-responsive">
							<?php else: ?>
								<video width="100%" controls autoplay><source src="<?php echo base_url('img/services/') . $service['image']; ?>" type="video/mp4">Your browser does not support the video tag.</video>
							<?php endif; ?>
						<?php else: ?>	
							<img src="<?php echo base_url('img/default-image.jpg'); ?>" class="img-responsive">
						<?php endif; ?>

						<h3 style="margin-top: 10px; font-weight: bold;"><?php echo $service['service_name'];?></h3>
						<?php if(!empty($ex_services)): ?>
							<h5 class="mt-3"><b>Extra Services</b></h5>
							<ul class="fix-block-website">
								<?php foreach($ex_services as $exs): ?>
									<li>
										<i class="fa fa-check" aria-hidden="true"></i> 
										<?php echo $exs['ex_service_name']; ?>
									</li>
								<?php endforeach; ?>	
							</ul>
						<?php endif; ?>

						<ul class="status-order" style="border-bottom: 1px solid #efeff0;">
							<li><span>Status</span> <span class="bg-warning"><?php echo ucfirst($order['status'])?></span></li>
							<li><span>Order</span> <span><?php echo ucfirst($order['order_id'])?></span></li>
							<li><span>Order Date</span> <span><?php echo $created_date; ?></span></li>
							<li><span>Quantity</span> <span><?php echo $order['service_qty']; ?></span></li>
							<li><span>Price</span> <span><?php echo '£'.number_format($order['total_price'],2); ?></span></li>
						</ul>
						<?php if(!empty($taskAddress)):?>
							<h5 class="mt-3"><b>Task Address</b></h5>
							<span><?php echo $taskAddress['address']; ?></span></li>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include ("include/footer.php") ?>
	<script>
		$(document).ready(function(){
			$.validator.addMethod("requiredHidden", function(value, element) {
        return $(element).val() !== ""; // Validate that the value is not empty
      }, "This field is required.");

			$("#order_service_review_form").validate({
				ignore: [],
				rules: {
					reviews: {
						required: true,
					},
					rating: {
						requiredHidden: true
					},
					seller_communication_rating: {
						requiredHidden: true
					},
					recommanded_service_rating: {
						requiredHidden: true
					}
				},
				messages: {
					reviews: "Please enter review for your order",
					rating: "Please give rating of the order",
					seller_communication_rating: "Please give rating of the seller coomunication",
					recommanded_service_rating: "Please give rating of the recommanded service",
				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "rating") {
						error.insertAfter("#orderStartDiv");
					} else if (element.attr("name") == "seller_communication_rating") {
						error.insertAfter("#tradesStartDiv");
					} else if (element.attr("name") == "recommanded_service_rating") {
						error.insertAfter("#recommandedStartDiv");
					} else {
						error.insertAfter(element);
					}
				},
				submitHandler: function(form) {
					giveRating();
				}
			});

			$("#seller_respond_form").validate({
				ignore: [],
				rules: {
					seller_response: {
						required: true,
					}
				},
				messages: {
					seller_response: "Please enter your response for this review",
				},
				submitHandler: function(form) {
					giveRespond();
				}
			});
		}); 

	function handleStarClick(index) {
			const allStar = document.getElementsByClassName('star');
			const ratingValue = document.querySelector('.rating input');

			if (allStar && ratingValue) {
				ratingValue.value = index + 1;

				for (let i = 0; i < allStar.length; i++) {
					allStar[i].classList.remove('active');
				}

				for (let i = 0; i <= index; i++) {
        allStar[i].classList.add('active');  // Mark as active
      }
    } else {
    	console.error('Rating stars or input element not found.');
    }

    const activeStars = document.getElementsByClassName('star active').length;
    $('#ratingValue').val(activeStars); 
    $('#ratingValue-error').remove();
  }

  function handleTradeStarClick(index) {
  	const allStar = document.getElementsByClassName('tradeStar');
  	const ratingValue = document.querySelector('.tradeRating input');

  	if (allStar && ratingValue) {
  		ratingValue.value = index + 1;

  		for (let i = 0; i < allStar.length; i++) {
  			allStar[i].classList.remove('active');
  		}

  		for (let i = 0; i <= index; i++) {
        allStar[i].classList.add('active');  // Mark as active
      }
    } else {
    	console.error('Rating stars or input element not found.');
    }

    const activeStars = document.getElementsByClassName('tradeStar active').length;
    $('#ratingValue1').val(activeStars);
    $('#ratingValue1-error').remove();
  }

  function handleRecommandedStarClick(index) {
  	const allStar = document.getElementsByClassName('tradeStar2');
  	const ratingValue = document.querySelector('.tradeRating2 input');

  	if (allStar && ratingValue) {
  		ratingValue.value = index + 1;

  		for (let i = 0; i < allStar.length; i++) {
  			allStar[i].classList.remove('active');
  		}

  		for (let i = 0; i <= index; i++) {
        allStar[i].classList.add('active');  // Mark as active
      }
    } else {
    	console.error('Rating stars or input element not found.');
    }

    const activeStars = document.getElementsByClassName('tradeStar2 active').length;
    $('#ratingValue2').val(activeStars);
    $('#ratingValue2-error').remove();
  }

	/* Start Code For Submit Review & Rating */
  function giveRating(){
  	$('#loader').removeClass('hide');
  	formData = $("#order_service_review_form").serialize();

  	$.ajax({
  		url: '<?= site_url().'users/submitReviewRating'; ?>',
  		type: 'POST',
  		data: formData,
  		dataType: 'json',		                
  		success: function(result) {
  			$('#loader').addClass('hide');
  			if(result.status == 0){
  				swal({
  					title: "Error",
  					text: result.message,
  					type: "error"
  				}, function() {
  					window.location.reload();
  				});	
  			}else if(result.status == 2){
  				swal({
  					title: "Login Required!",
  					text: "If you want to order the please login first!",
  					type: "warning"
  				}, function() {
  					window.location.href = '<?php echo base_url().'login'; ?>';
  				});	
  			}else{
  				swal({
  					title: "Success",
  					text: result.message,
  					type: "success"
  				}, function() {
  					window.location.reload();
  				});
  			}		                    
  		},
  		error: function(xhr, status, error) {
          // Handle error
  		}
  	});
  }
	/* End Code For Submit Review & Rating */

	/* Start Code For Submit Seller Respond */
  function giveRespond(){
  	$('#loader').removeClass('hide');
  	formData = $("#seller_respond_form").serialize();

  	$.ajax({
  		url: '<?= site_url().'users/submitRespond'; ?>',
  		type: 'POST',
  		data: formData,
  		dataType: 'json',		                
  		success: function(result) {
  			$('#loader').addClass('hide');
  			if(result.status == 0){
  				swal({
  					title: "Error",
  					text: result.message,
  					type: "error"
  				}, function() {
  					window.location.reload();
  				});	
  			}else if(result.status == 2){
  				swal({
  					title: "Login Required!",
  					text: "If you want to order the please login first!",
  					type: "warning"
  				}, function() {
  					window.location.href = '<?php echo base_url().'login'; ?>';
  				});	
  			}else{
  				swal({
  					title: "Success",
  					text: result.message,
  					type: "success"
  				}, function() {
  					window.location.reload();
  				});
  			}		                    
  		},
  		error: function(xhr, status, error) {
          // Handle error
  		}
  	});
  }
	/* End Code For Submit Seller Respond */
	</script>