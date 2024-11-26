<?php include ("include/header.php") ?>
<style>
	.payment_method{
		margin-right: 10px!important;
	}

	.fa-star {
		color: #dcd9d9;
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
		width: 50px;
		height: 50px;
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
		color: #fe8a0f;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	.rating .tradeStar {
		cursor: pointer;
	}

	.rating .tradeStar.active {
		color: #fe8a0f;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	.rating .tradeStar2 {
		cursor: pointer;
	}

	.rating .tradeStar2.active {
		color: #fe8a0f;
		animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
	}

	.rating .homeownerStar.active {
		color: #fe8a0f;
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

	.rating .homeownerStar:hover {
		transform: scale(1.1);
	}

	.rating-form {
		/*padding: 0 30px;*/
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
		grid-gap: 0;
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
	.member-summary .member-image-container, .member-summary .member-information-container, .member-summary .cert-container{
		height: 50px;
	}
</style>

<?php 
	if(isset($homeOwner['profile']) && !empty($homeOwner['profile'])){
		$uprofileImg = base_url('img/profile/'.$homeOwner['profile']);
	}else{
		$uprofileImg = base_url('img/default-img.png');
	}
	$homeUserName = ($homeOwner['f_name'] ?? '').' '.($homeOwner['l_name'] ??  '');

	if(isset($tradesman['profile']) && !empty($tradesman['profile'])){
		$tProfileImg = base_url('img/profile/'.$tradesman['profile']);
	}else{
		$tProfileImg = base_url('img/default-img.png');
	}
	$tradeUserName = ($tradesman['trading_name'] ?? '');
?>

<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<?php if (!empty($completedFlashMessage)): ?>
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
				<?php endif; ?>

				<?php if($user_type == 1): ?>
					<?php if($order['is_review'] == 1 && !empty($review['seller_review'])):?>
						<div class="rating-form">
							<h2 class="mt-1">
								Public Review Left
							</h2>
						</div>
						<?php if($order['is_review'] == 1):?>
							<div class="accordion-completed-order">
								<div class="accordion-completed-name" onclick="toggleReviewDiv('homeOwnerReviewDiv');">
									<div class="member-summary mb-4">
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $homeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h3 class="mt-1" style="margin-bottom: 5px;"><?php echo $homeUserName."'s Feedback"?></h3>
												</div>
												<i class="fa fa-angle-down pull-right"></i>
											</div>
										</div>
									</div>
								</div>

								<div class="accordion-order-review-text mt-1" id="homeOwnerReviewDiv">
									<div class="rating-list">
										<p><b>Communication With Seller</b><br> 
										How responsive was the seller during the process?</p>
										<div class="rating" id="orderRating">
											<div id="orderStartDiv">
												<?php for($i=1; $i<=5; $i++):?>											
													<?php $active = $review['rating'] >= $i ? 'active' : ''; ?>
													<i class="fa fa-star star <?php echo $active; ?>"></i>
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
													<i class="fa fa-star star <?php echo $active1; ?>"></i>
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
													<i class="fa fa-star star <?php echo $active2; ?>"></i>
												<?php endfor;?>
											</div>
										</div>
									</div>
									<div class="member-job-title crop">
										<p>Comment</p>
										<?php echo $review['review']; ?>
									</div>
									<div class="accordion-completed-order mt-4">
										<?php if($review['is_responded'] == 0):?>
											<div class="accordion-order-review-text" id="requirement-div">
												<form id="seller_respond_form" style="width:100%">
													<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
													<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
													<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
													<input type="hidden" name="is_respond" value="1">
													<div class="review-div mt-4">
														<label>Respond to the Feddback (Public)</label>
														<textarea name="seller_review" class="form-control" rows="5" placeholder="Your respond..."></textarea>
													</div>
													<div class="text-center mt-4">
														<button type="submit" id="give-rating" class="btn btn-warning">
															Submit
														</button>
													</div>
												</form>
											</div>
										<?php else:?>	
											<div>
												<h3 class="mt-1">
													<?php //echo $tradeUserName."'s Response"?>
													My Response
												</h3>
												<p><?php echo $review['seller_response']; ?></p>
											</div>
										<?php endif;?>
									</div>
								</div>
							</div>							
							<hr>
						<?php endif; ?>

						<?php if(empty($review['seller_review'])):?>
							<hr>
							<div class="rating-form">
								<?php if($order['is_review'] == 1):?>
									<h2 class="mt-1">
										Leave Public Review
									</h2>
									<div class="member-summary mb-4">
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $homeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h4 class="mt-1" style="margin-bottom: 5px;">
														<?php echo $homeUserName?>
														has left you a feedback. To see their review, please leave your own feedback
													</h4>												
												</div>
											</div>
										</div>
									</div>
								<?php else:?>	
									<h2 class="mt-1">
										Leave Public Review
										<h4>
											Share your experience of working with <?php echo $homeUserName; ?>
										</h4>
									</h2>
								<?php endif;?>	
								
								<div class="accordion-completed-order mt-5">
									<div class="accordion-completed-name" onclick="toggleTradsmanRespond();">
										<div class="icon-star">
											<i class="fa fa-star-o" aria-hidden="true"></i>
										</div>
										<h5>Review your experience with this buyer 
											<span>May 19,9:34 PM</span>
										</h5>
										<i class="fa fa-angle-down pull-right"></i>
									</div>

									<div class="accordion-order-review-text" id="requirement-div">
										<div class="overview-experience">
											<h2 class="title">Overview Experience</h2>											

											<form id="seller_respond_form1" style="width:100%">
												<div class="rete-star" style="padding-left: 0;">
													<h3>Rate your experience
														<span>
															How would you rate your overall experience with this buyer?
														</span>
													</h3>
													<div class="rating homeRating" id="homeownerRating">
														<div id="homeownerStartDiv">
															<input type="hidden" name="homeowner_rating" id="homeownerRatingValue">
															<?php for($i=0; $i<=4; $i++):?>
																<i class="fa fa-star homeownerStar" style="--i: <?php echo $i?>;" onclick="handleHomeownerStarClick(<?php echo $i?>)"></i>
															<?php endfor;?>
														</div>
													</div>
												</div>

												<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
												<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
												<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
												<div class="review-div">
													<label>Share some more about your experience by words (public)</label>
													<textarea name="seller_review" class="form-control" rows="5" placeholder="Your review..."></textarea>
												</div>
												<div class="text-center mt-4">
													<button type="submit" id="give-rating" class="btn btn-warning">
														Submit
													</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>							
						<?php else: ?>
							<div class="accordion-completed-order">
								<div class="accordion-completed-name" onclick="toggleReviewDiv('tradesManReviewDiv');">
									<div class="member-summary mb-4">
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h3 class="mt-1" style="margin-bottom: 5px;">
														<?php //echo $tradeUserName."'s Feedback"?>
														My Feedback	
													</h3>												
												</div>
												<i class="fa fa-angle-down pull-right"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-order-review-text mt-1" id="tradesManReviewDiv">
									<div class="rating-list">
										<p style="color: #464c5b;">Overall Rating</p>
										<div class="rating homeRating" id="homeownerRating">
											<div id="homeownerStartDiv">
												<?php for($i=1; $i<=5; $i++):?>											
													<?php $active = $review['homeowner_rating'] >= $i ? 'active' : ''; ?>
													<i class="fa fa-star star <?php echo $active; ?>"></i>
												<?php endfor;?>
											</div>
										</div>
									</div>
									<div class="member-job-title crop">
										<p>Comment</p>
										<?php echo $review['seller_review']; ?>
									</div>
								</div>
							</div>
						<?php endif;?>	
					<?php else: ?>
						<div class="rating-form">
							<?php if(!empty($review['seller_review'])):?>
								<h2 class="mt-1">
									Public Review Left
								</h2>
								<div class="accordion-completed-order">
									<div class="accordion-completed-name" onclick="toggleReviewDiv('tradesManReviewDiv');">
										<div class="member-summary mb-4">
											<div class="summary member-summary-section">
												<div class="member-image-container">
													<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
												</div>
												<div class="member-information-container">
													<div class="member-name-container crop">
														<h3 class="mt-1" style="margin-bottom: 5px;">
															<?php //echo $tradeUserName."'s Feedback"?>
															My Feedback	
														</h3>												
													</div>
													<i class="fa fa-angle-down pull-right"></i>
												</div>
											</div>
										</div>
									</div>
									<div class="accordion-order-review-text mt-1" id="tradesManReviewDiv">
										<div class="rating-list">
											<p style="color: #464c5b;">Overall Rating</p>
											<div class="rating homeRating" id="homeownerRating">
												<div id="homeownerStartDiv">
													<?php for($i=1; $i<=5; $i++):?>											
														<?php $active = $review['homeowner_rating'] >= $i ? 'active' : ''; ?>
														<i class="fa fa-star star <?php echo $active; ?>"></i>
													<?php endfor;?>
												</div>
											</div>
										</div>
										<div class="member-job-title crop">
											<p>Comment</p>
											<?php echo $review['seller_review']; ?>
										</div>
									</div>
								</div>
							<?php else:?>	
								<?php if($order['is_review'] == 1):?>
									<h2 class="mt-1">
										Leave Public Review
									</h2>
									<div class="member-summary mb-4">
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $homeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h4 class="mt-1" style="margin-bottom: 5px;">
														<?php echo $homeUserName?>
														has left you a feedback. To see their review, please leave your own feedback
													</h4>												
												</div>
											</div>
										</div>
									</div>
								<?php else:?>	
									<h2 class="mt-1">
										Leave Public Review
										<h4>
											Share your experience of working with <?php echo $homeUserName; ?>
										</h4>
									</h2>
								<?php endif;?>
								
								<div class="accordion-completed-order mt-5">
									<div class="accordion-completed-name" onclick="toggleTradsmanRespond();">
										<div class="icon-star">
											<i class="fa fa-star-o" aria-hidden="true"></i>
										</div>
										<h5>Review your experience with this buyer 
											<span>May 19,9:34 PM</span>
										</h5>
										<i class="fa fa-angle-down pull-right"></i>
									</div>

									<div class="accordion-order-review-text" id="requirement-div">
										<div class="overview-experience">
											<h2 class="title">Overview Experience</h2>											

											<?php if($review['is_responded'] == 0):?>
												<form id="seller_respond_form" style="width:100%">
													<div class="rete-star" style="padding-left: 0;">
														<h3>Rate your experience
															<span>
																How would you rate your overall experience with this buyer?
															</span>
														</h3>
														<div class="rating homeRating" id="homeownerRating">
															<div id="homeownerStartDiv">
																<input type="hidden" name="homeowner_rating" id="homeownerRatingValue">
																<?php for($i=0; $i<=4; $i++):?>
																	<i class="fa fa-star homeownerStar" style="--i: <?php echo $i?>;" onclick="handleHomeownerStarClick(<?php echo $i?>)"></i>
																<?php endfor;?>
															</div>
														</div>
													</div>

													<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
													<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
													<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
													<div class="review-div">
														<label>Share some more about your experience by words (public)</label>
														<textarea name="seller_review" class="form-control" rows="5" placeholder="Your review..."></textarea>
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
												<div class="member-summary">
													<div class="summary member-summary-section">
														<div class="member-information-container">
															<div class="member-name-container crop p-3">
																<div class="rating-list">
																	<p>
																		<b>Rate your experience</b><br> 
																		How would you rate your overall experience with this buyer?
																	</p>
																	<div class="rating homeRating" id="homeownerRating">
																		<div id="homeownerStartDiv">
																			<?php for($i=1; $i<=5; $i++):?>
																				<?php $active = $review['homeowner_rating'] >= $i ? 'active' : ''; ?>
																				<i class="fa fa-star star <?php echo $active; ?>"></i>
																			<?php endfor;?>
																		</div>
																	</div>
																</div>
																<div class="member-job-title crop">
																	<p><b>Your response</b><br> 
																		<?php echo $review['seller_response']; ?>
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>								
											<?php endif;?>
										</div>
									</div>
								</div>
							<?php endif;?>
						</div>
					<?php endif;?>
				<?php endif;?>

				<?php if($user_type == 2): ?>
					<?php if($order['is_review'] != 1):?>
						<div class="rating-form">
							<?php if(!empty($review['seller_review'])):?>
								<h2 class="mt-1">
									Public Review Left									
								</h2>
							<?php else:?>
								<h2 class="mt-1">
									Leave a public review
									<h4>Share your experience of what is it like working with <?php echo $tradeUserName; ?>. </h4>
								</h2>
							<?php endif;?>

							<?php if(!empty($review['seller_review'])):?>
								<div class="member-summary mb-4">
									<div class="summary member-summary-section">
										<div class="member-image-container">
											<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
										</div>
										<div class="member-information-container">
											<div class="member-name-container crop">
												<h4 class="mt-1" style="margin-bottom: 5px;">
													<?php echo $tradeUserName?>
													has left you a feedback. To see their review, please leave your own feedback
												</h4>												
											</div>
										</div>
									</div>
								</div>
							<?php endif;?>

							<form class="mt-5" id="order_service_review_form" style="width:100%">
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
												<i class="fa fa-star star" style="--i: <?php echo $i?>;" onclick="handleStarClick(<?php echo $i?>)"></i>
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
												<i class="fa fa-star tradeStar" style="--i: <?php echo $j?>;" onclick="handleTradeStarClick(<?php echo $j?>)"></i>
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
												<i class="fa fa-star tradeStar2" style="--i: <?php echo $j?>;" onclick="handleRecommandedStarClick(<?php echo $j?>)"></i>
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
						</div>
					<?php endif;?>

					<?php if($order['is_review'] == 1):?>
						<div class="rating-form">
							<h2 class="mt-1">
								Public Review Left
							</h2>
						</div>
						<div class="accordion-completed-order mt-5">
							<div class="accordion-completed-name" onclick="toggleReviewDiv('homeOwnerReviewDiv');">
								<div class="member-summary mb-4">
									<div class="summary member-summary-section">
										<div class="member-image-container">
											<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $homeUserName?>">
										</div>
										<div class="member-information-container">
											<div class="member-name-container crop">
												<h3 class="mt-1" style="margin-bottom: 5px;">
													<?php //echo $homeUserName."'s Feedback"?>
													My Feedback		
												</h3>												
											</div>
											<i class="fa fa-angle-down pull-right"></i>
										</div>
									</div>
								</div>
							</div>	
							
							<div class="accordion-order-review-text mt-1" id="homeOwnerReviewDiv">
								<div class="rating-list">
									<p><b>Communication With Seller</b><br> 
									How responsive was the seller during the process?</p>
									<div class="rating" id="orderRating">
										<div id="orderStartDiv">
											<?php for($i=1; $i<=5; $i++):?>											
												<?php $active = $review['rating'] >= $i ? 'active' : ''; ?>
												<i class="fa fa-star star <?php echo $active; ?>"></i>
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
												<i class="fa fa-star star <?php echo $active1; ?>"></i>
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
												<i class="fa fa-star star <?php echo $active2; ?>"></i>
											<?php endfor;?>
										</div>
									</div>
								</div>
								<div class="member-job-title crop">
									<p>Comment</p>
									<?php echo $review['review']; ?>
								</div>
								<?php if(!empty($review['seller_response'])):?>
									<div class="mt-1">
										<h3>
											<?php echo $tradeUserName."'s Response"?>
										</h3>
										<p><?php echo $review['seller_response']; ?></p>
									</div>
								<?php endif;?>
							</div>
						</div>
						<hr>
						<?php if(!empty($review['seller_review'])):?>
							<div class="accordion-completed-order">
								<div class="accordion-completed-name" onclick="toggleReviewDiv('tradesManReviewDiv');">
									<div class="member-summary mb-4">
										<div class="summary member-summary-section">
											<div class="member-image-container">
												<img class="img-border-round member-image" src="<?php echo $tProfileImg;?>" alt="<?php echo $tradeUserName?>">
											</div>
											<div class="member-information-container">
												<div class="member-name-container crop">
													<h3 class="mt-1" style="margin-bottom: 5px;">
														<?php echo $tradeUserName."'s Feedback"?>
													</h3>												
												</div>
												<i class="fa fa-angle-down pull-right"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="accordion-order-review-text mt-1" id="tradesManReviewDiv">
									<div class="rating-list">
										<p style="color: #464c5b;">Overall Rating</p>
										<div class="rating homeRating" id="homeownerRating">
											<div id="homeownerStartDiv">
												<?php for($i=1; $i<=5; $i++):?>											
													<?php $active = $review['homeowner_rating'] >= $i ? 'active' : ''; ?>
													<i class="fa fa-star star <?php echo $active; ?>"></i>
												<?php endfor;?>
											</div>
										</div>
									</div>
									<div class="member-job-title crop">
										<p>Comment</p>
										<?php echo $review['seller_review']; ?>
									</div>
								</div>
							</div>
						<?php endif;?>
					<?php endif;?>
				<?php endif;?>
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
							<li>
								<span>Status</span> <span class="bg-warning"><?php echo ucfirst($order['status'])?></span>
							</li>
							<li>
								<span>Order</span> <span><?php echo ucfirst($order['order_id'])?></span>
							</li>
							<li>
								<span>Order Date</span> <span><?php echo $created_date; ?></span>
							</li>
							<li>
								<span>Quantity</span> <span><?php echo $order['service_qty']; ?></span>
							</li>
							<li>
								<span>Price</span> <span><?php echo '£'.number_format($order['total_price'],2); ?></span>
							</li>
						</ul>
						<?php if(!empty($taskAddress)):?>
							<h5 class="mt-3"><b>Task Address</b></h5>
							<span><?php echo $taskAddress['address']; ?></span>
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
				seller_review: {
					required: true,
				},
				homeowner_rating: {
					requiredHidden: true
				},
			},
			messages: {
				seller_review: "Please enter your review for this review",
				homeowner_rating: "Please give rating for the homeowner",
			},errorPlacement: function(error, element) {
				if (element.attr("name") == "homeowner_rating") {
					error.insertAfter("#homeownerStartDiv");
				} else {
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) {
				giveRespond();
			}
		});

		$("#seller_respond_form1").validate({
			ignore: [],
			rules: {
				seller_review: {
					required: true,
				},
				homeowner_rating: {
					requiredHidden: true
				},
			},
			messages: {
				seller_review: "Please enter your review for this review",
				homeowner_rating: "Please give rating for the homeowner",
			},errorPlacement: function(error, element) {
				if (element.attr("name") == "homeowner_rating") {
					error.insertAfter("#homeownerStartDiv");
				} else {
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) {
				giveHomeownerReview();
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

  function handleHomeownerStarClick(index) {
  	const allStar = document.getElementsByClassName('homeownerStar');
  	const ratingValue = document.querySelector('.homeRating input');

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

    const activeStars = document.getElementsByClassName('homeownerStar active').length;
    $('#homeownerRatingValue').val(activeStars);
    $('#homeownerRatingValue-error').remove();
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

  function giveHomeownerReview(){
  	$('#loader').removeClass('hide');
  	formData = $("#seller_respond_form1").serialize();

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

  function toggleTradsmanRespond(){
		$(".accordion-order-review-text").slideToggle(); // Toggle the visibility with sliding effect
    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
  }
  function toggleReviewDiv(divId){
		$("#"+divId).slideToggle(); // Toggle the visibility with sliding effect
    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
  }
</script>