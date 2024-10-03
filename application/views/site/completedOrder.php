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
		width: 165px;
		height: 165px;
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

</style>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
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
						<p><b>Share your experience with other users</b></p>
					</div>
				</div>
			</div>

			<div class="col-sm-8 checkout-form">
				<div class="submit-requirements">
					<h4 class="submit-title">
							<?php if($order['is_review'] != 1):?>
								Leave a Review
							<?php else: ?>
								Review
							<?php endif;?>						
					</h4>
					<div class="p-4 text-center">
						<h4>Let other users know what is like working <?php echo $tradesman['trading_name']; ?></h4>					
						<div class="member-summary mb-5">
							<div class="summary member-summary-section">
								<div class="member-image-container">
									<?php 
									if(isset($tradesman['profile']) && !empty($tradesman['profile'])){
										$uprofileImg = base_url('img/profile/'.$tradesman['profile']);
									}else{
										$uprofileImg = base_url('img/default-img.png');
									}
									$suserName = ($tradesman['f_name'] ?? '').' '.($tradesman['l_name'] ??  '');
									?>
									<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $suserName;?>">
								</div>											
							</div>
						</div>	

						<?php if($order['is_review'] != 1):?>

						<form class="mt-3" id="order_service_review_form" style="width:100%">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
							<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
							<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
							<p>
								Based on your expectations, how would you rate the quality of this delivery?
							</p>
							<div class="rating" id="orderRating">
								<input type="hidden" name="rating" id="ratingValue">
								<?php for($i=0; $i<=4; $i++):?>
									<i class="fa fa-star star" style="--i: <?php echo $i?>;" onclick="handleStarClick(<?php echo $i?>)"></i>
								<?php endfor;?>
							</div>

							<p class="mt-4">
								How was it working with <?php echo $tradesman['trading_name']; ?>
							</p>
							<div class="rating tradeRating" id="tRating">
								<input type="hidden" name="tradesman_rating" id="ratingValue1">
								<?php for($j=0; $j<=4; $j++):?>
									<i class="fa fa-star tradeStar" style="--i: <?php echo $j?>;" onclick="handleTradeStarClick(<?php echo $j?>)"></i>
								<?php endfor;?>
							</div>

							<div class="review-div mt-4">
								<textarea name="reviews" class="form-control" rows="5" placeholder="Your review..."></textarea>
							</div>
							<div class="btn-group mt-3">
								<button type="submit" id="give-rating" class="btn btn-warning mr-3">
									Submit
								</button>											
							</div>
						</form>
					<?php else: ?>
						<p>
							Based on your expectations, how would you rate the quality of this delivery?
						</p>
						<div class="rating" id="orderRating">
							<?php for($i=1; $i<=5; $i++):?>
								<?php 
									$active = $review['rating'] >= $i ? 'active' : '';
								?>
								<i class="fa fa-star star <?php echo $active; ?>"></i>
							<?php endfor;?>	
						</div>

						<p class="mt-4">
							How was it working with <?php echo $tradesman['trading_name']; ?>
						</p>
						<div class="rating tradeRating" id="tRating">
							<?php for($j=1; $j<=5; $j++):?>
								<?php 
									$active1 = $tRate['rt_rate'] >= $j ? 'active' : '';
								?>
								<i class="fa fa-star tradeStar <?php echo $active1; ?>"></i>
							<?php endfor;?>	
						</div>

						<div class="mt-4" id="orderReviewd">
							<label><b>Review By <?php echo $homeOwner['f_name'].' '.$homeOwner['l_name'];?></b></label>
							<p><?php echo $review['review']; ?></p>
						</div>
					<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="box-border p-4 submit-requirements-sidebar">
					<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
					<?php if (file_exists($image_path) && $service['image']): ?>
						<img src="<?php echo base_url('img/services/') . $service['image']; ?>" class="img-responsive">
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
				tradesman_rating: {
					requiredHidden: true
				}
      },
      messages: {
        reviews: "Please enter review for your order",
        rating: "Please give rating of the order",
        tradesman_rating: "Please give rating of the tradesman",
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") == "rating") {
          error.insertAfter("#orderRating");
        } else if (element.attr("name") == "tradesman_rating") {
          error.insertAfter("#tRating");
        }  else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        giveRating();
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
</script>