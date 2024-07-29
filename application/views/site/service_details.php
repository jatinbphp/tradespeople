
<?php include ("include/header.php") ?>

<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>

<div class="detail-cat acount-page service-detail-page">
	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url(""); ?>"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill"><path d="M12.773 14.5H3.227a.692.692 0 0 1-.482-.194.652.652 0 0 1-.2-.468V7.884H.5l7.041-6.212a.694.694 0 0 1 .918 0L15.5 7.884h-2.046v5.954a.652.652 0 0 1-.2.468.692.692 0 0 1-.481.194Zm-4.091-1.323h3.409V6.664L8 3.056 3.91 6.664v6.513h3.408v-3.97h1.364v3.97Z"></path></svg></a></li>
					<?php 
						$breadcrumb = $this->common_model->get_breadcrumb(($service_details['service_type'] ?? 0));
					    $url = site_url('category');
					    $total_items = count($breadcrumb);
	    				$current_item = 0;
					    foreach ($breadcrumb as $category): 
				    	$current_item++;
				        $url .= '/' . $category['slug'];				        
				    ?> 				    		
				    	<li><a href="<?php echo $url; ?>"><?php echo $category['cat_name']; ?></a></li>
				    <?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="service-detail-slider-main">
					<div class="row">
						<div class="col-sm-8">
							<h2 class="title"><?php echo $service_details['service_name']?></h2>	
							<div class="service-detail-slider">						
								<div class="slider slider-for">
									<?php
										echo $this->common_model->make_all_image($service_details['image'], $service_images);										
									?>
								</div>
								<div class="slider slider-nav">
									<?php
										echo $this->common_model->make_all_image($service_details['image'], $service_images);										
									?>									
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="sidebar-main">
								<div class="service-detail-sidebar">
									<h2 class="title"><?php echo '£'.number_format($service_details['price'],2); ?></h2>
									<p>15s Social Media Ad in 1 format of your choice: Landscape, Square or Vertical</p>
									<h4><i class="fa fa-clock-o" aria-hidden="true"></i> 7-day delivery</h4>				
									<ul>
										<li><i class="fa fa-check" aria-hidden="true"></i> Hand-picked freelancer</li>
										<li><i class="fa fa-check" aria-hidden="true"></i> Hand-picked freelancer</li>
										<li><i class="fa fa-check" aria-hidden="true"></i> Hand-picked freelancer</li>
										<li><i class="fa fa-check" aria-hidden="true"></i> Hand-picked freelancer</li>
										<li><i class="fa fa-check" aria-hidden="true"></i> Hand-picked freelancer</li>
									</ul>
									<form action="" method="post" id="serviceOrder" style="margin-top:0">
										<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
										<input type="hidden" name="selected_exsIds" id="selected_exsIds">
										<p class="text-left">
											Price is based on 
											<?php echo lcfirst($service_details['price_per_type']); ?>.
										</p>
										<div class="row text-left mb-3">
											<div class="col-md-8">
												<p>
													Number of <?php echo lcfirst($service_details['price_per_type']); ?>
												</p>
											</div>
											<div class="col-md-4">
												<input type="number" class="form-control" name="qty_of_type" id="qty_of_type" min="1" value="1">
											</div>
										</div>
										<input class="btn btn-warning btn-lg" type="submit" id="orderBtn" value="Order (<?php echo '£'.number_format($service_details['price'],2); ?>)">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="about-this">
					<h2 class="title">About this service</h2>
					<p>
						<?php echo $service_details['description']; ?>
					</p>
					<?php if(!empty($service_details['plugins'])): ?>
						<h2 class="title">What you get with this Offer</h2>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<?php $plugins = explode(',', $service_details['plugins']); ?>
									<?php foreach($plugins as $plugin): ?>
										<?php
											$pDetail = $this->common_model->GetSingleData('category',['cat_id'=>$plugin]); 											
										?>
									<tr>
										<td><?php echo $pDetail['cat_name']; ?></td>
										<td><i class="fa fa-check" aria-hidden="true"></i></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="about-this-sidebar">
					<div class="row">
						<div class="col-sm-4 text-center no-padding">
							<div class="icon-container">
								<i class="fa fa-paper-plane" aria-hidden="true"></i>
							</div>
							<div class="label-container">Delivery in</div>
							<div class="value-container"><b><?php echo $service_details['delivery_in_days']; ?> days</b></div>
						</div>
						<div class="col-sm-4 text-center no-padding">
							<div class="icon-container">
								<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
							</div>
							<div class="label-container">Rating</div>
							<div class="value-container"><b><?php echo $rating_percentage; ?>%</b> (<?php echo $service_details['total_reviews']; ?> reviews)</div>
						</div>
						<div class="col-sm-4 text-center no-padding">
							<div class="icon-container">
								<i class="fa fa-clock-o" aria-hidden="true"></i>
							</div>
							<div class="label-container">Response time</div>
							<div class="value-container"><b>within a few <br/>hours</b></div>
						</div>
					</div>
					<div class="views-sales">
						<ul>
							<li>
								<span>Views</span>
								<span class="value"><?php echo $service_details['total_views']; ?></span>
							</li>
							<li>
								<span>Sales</span>
								<span class="value"><?php echo $service_details['total_orders']; ?></span>
							</li>
							<li class="star-container pull-right">
								<div class="widget-star-item "><a class="action-entity-star fa fa-heart" href="#"></a><span class=" count-stars"><?php echo $service_details['total_likes']; ?></span></div>
							</li>
						</ul>
					</div>

					<div class="member-summary">
						<div class="summary member-summary-section">
							<div class="member-image-container">
								<?php 
									if(isset($service_user['profile']) && !empty($service_user['profile'])){
										$uprofileImg = base_url('img/profile/'.$service_user['profile']);
									}else{
										$uprofileImg = base_url('img/default-img.png');
									}
									$suserName = ($service_user['f_name'] ?? '').' '.($service_user['l_name'] ??  '');
								?>
								<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $suserName;?>">
							</div>
							<div class="member-information-container">
								<div class="member-name-container crop">
									<h5>
										<a class="crop member-short-name" rel="nofollow" title="Ripon K." href="<?php echo base_url('profile/'.$service_user['id']); ?>">
											<?php echo $suserName;?>
										</a>
									</h5>
									<div class="member-job-title crop">
										<?php echo $service_user['trading_name'];?>
									</div>
								</div>
							</div>
							<!-- <div class="cert-container text-right">
								<span class="cert cert-img"></span>
							</div> -->
						</div>
						<div class=" about member-summary-section clearfix">
							<div class="about-container js-about-container">
								<p><?php echo $service_user['about_business'];?></span>
								</p>
							</div>
						</div>
						<div class=" location member-summary-section clearfix">
							<div class="location-container crop">
								<i class="fa fa-map-marker"></i>
							<?php echo $service_user['city'];?></div>
						</div>
						<div class=" contact member-summary-section clearfix">
							<a class="btn btn-warning contact-button" id="contactBtn" rel="nofollow" href="javascript:void(0)">Contact</a>
						</div>
					</div>

				</div>

				<div class="rating">
					<!-- <div class="rate">
						<span><?php echo $service_user['average_rate']; ?></span>
						<input type="radio" id="star5" name="rate" value="5" />
						<label for="star5" title="text">5 stars</label>
						<input type="radio" id="star4" name="rate" value="4" />
						<label for="star4" title="text">4 stars</label>
						<input type="radio" id="star3" name="rate" value="3" />
						<label for="star3" title="text">3 stars</label>
						<input type="radio" id="star2" name="rate" value="2" />
						<label for="star2" title="text">2 stars</label>
						<input type="radio" id="star1" name="rate" value="1" />
						<label for="star1" title="text">1 star</label>
					</div> -->
					<ul>
						<li><p>seller communication level</p><div class="star"><span></span> 4.9</div></li>
						<li><p>Recommend to a friend</p><div class="star"><span></span> 4.9</div></li>
						<li><p>Service as described</p><div class="star"><span></span> 5.0</div></li>
					</ul>
				</div>

			</div>
		</div>

		<div class="row order-hourlie-addons">
			<div class="col-sm-8">
				<?php if(!empty($extra_services)): ?>
					<h2 class="title">Get more with Offer Add-ons</h2>
					<div class="content-text clear addons-container">
						<ul class="addons clearfix boxmodelfix">
							<?php foreach($extra_services as $exs): ?>
								<li class="item bg-fill clearfix clear">
									<div class="checkbox col-xs-7 col-sm-9">
										<div class="form-check">
											<div class="check-box">
												<input class="checkbox-effect" data-price="<?php echo $exs['price']?>" data-id="<?php echo $exs['id']?>" id="business_<?php echo $exs['id']?>" type="checkbox" value="<?php echo $exs['id']?>" name="extra_services[]">
												<label for="business_<?php echo $exs['id']?>">
													<div>
														<h6><?php echo $exs['ex_service_name']; ?></h6>
														<?php if(!empty($exs['additional_working_days'])): ?>
															<span>
																Additional Working Days <?php echo $exs['additional_working_days'];?>
															</span>
														<?php endif; ?>
													</div>
												</label>
											</div>
										</div>
									</div>	
									<div class="price-tag text-right col-xs-5 col-sm-3">
										<span>
											<i class="fa fa-plus"></i> <?php echo $exs['price']?>
										</span>
									</div>							
								</li>
							<?php endforeach; ?>							
						</ul>
					</div>
				<?php endif; ?>					
			</div>
			<div class="col-sm-4">
				<div class="order-hourlie-addons-sidebar">
					<h2 class="title">Availability Of Seller</h2>
					<div id="datepicker"></div>
					<input type="hidden" name="selected_dates" id="selectedDates">
					<div class="mt-4">
						<select class="form-control input-md" name="time_slot" id="timeSlot">
							<option value="">Select time slot</option>
							<?php for ($hour = 0; $hour <= 23; $hour++) {
								$hour_padded = sprintf("%02d", $hour % 12 == 0 ? 12 : $hour % 12); // Convert 0 to 12 for am/pm display
								$ampm = $hour < 12 ? 'am' : 'pm'; // Determine am/pm
								echo "<option value=\"$hour_padded:00 $ampm\">$hour_padded:00 $ampm</option>\n";

							}?>
						</select>
					</div>
					<div style="padding: 10px 0;">
						<span>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</span>
					</div>
					<div id="notAvailablMsg" style="border-top:1px solid #b0c0d3; padding: 10px 0; display: none;"></div>
					<input class="btn btn-warning btn-lg col-md-12" type="button" id="openChat" value="Select & Continue">
				</div>		
			</div>
		</div>

		<?php if(!empty($service_faqs)): ?>
			<div class="row faq-accordion help-center">
				<div class="col-sm-8">
					<h2 class="title">FAQ</h2>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php foreach($service_faqs as $key => $faq): ?>
							<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading<?php echo $key; ?>">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
										<?php echo $faq['question']; ?>
									</a>
								</h4>
							</div>
							<div id="collapse<?php echo $key; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $key; ?>">
								<div class="panel-body">
									<p><?php echo $faq['answer']; ?></p>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!empty($user_profile)): ?>
			<div class="row">
				<div class="col-sm-8">
					<div class="portfolio-presence">
						<div class="presence-header">
							<a href="#">My portfolio</a>
							<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16ZM6.667 6.222c0-.228.075-.59.277-.87C7.112 5.12 7.4 4.89 8 4.89c.734 0 1.116.388 1.245.777.136.41.02.867-.405 1.15-.701.468-1.218.92-1.49 1.556-.24.56-.24 1.175-.239 1.752v.098H8.89c0-.728.015-.964.095-1.15.06-.142.21-.356.842-.777a2.751 2.751 0 0 0 1.106-3.19C10.558 3.978 9.488 3.111 8 3.111c-1.179 0-2.001.511-2.5 1.203a3.37 3.37 0 0 0-.611 1.908h1.778Zm2.222 6.667V11.11H7.11v1.778H8.89Z"></path></svg>
							<span class="new">NEW</span>
						</div>

						<ul class="project-grid grid-5">
							<?php foreach($user_profile as $key => $pImg): ?>
								<li class="project-photo photo-<?php echo $key; ?>">
									<div class="project-img hide-on-error responsive-wrapper">
										<img src="<?php echo base_url('img/profile/'.$pImg['port_image']); ?>">
									</div>
									<?php if(!empty($pImg['port_title'])): ?>
										<div class="project-title-wrapper responsive-wrapper">
											<span class="project-title"><?php echo $pImg['port_title']; ?></span>
										</div>
									<?php endif; ?>	
								</li>
							<?php endforeach;?>								
						</ul>
					</div>
				</div>
			</div>
		<?php endif;?>

		<?php if(!empty($service_rating)): ?>
		<div class="row client-reviews">
			<div class="col-sm-8">
				<h2 class="title">Reviews</h2>
				<ul id="reviewList">
					<?php foreach($service_rating as $rate): ?>
						<li>
							<div class="profile-img">
								<?php 
									if(isset($rate['rate_by_profile']) && !empty($rate['rate_by_profile'])){
										$profileImg = base_url('img/profile/'.$rate['rate_by_profile']);
									}else{
										$profileImg = base_url('img/default-img.png');
									}
									$userName = ($rate['rate_by_fname'] ?? '').' '.($rate['rate_by_lname'] ??  '');
								?>
								<img src="<?php echo $profileImg; ?>" alt="<?php echo $userName; ?>" />
							</div>
							<div class="review-right">
								<div class="review-name">
									<h4><?php echo $userName; ?></h4>
									<span><?php echo time_ago($rate['created_at']); ?></span>
								</div>
								<div class="review-star">
									<?php
										for($i=1; $i<=$rate['rating']; $i++){
											echo '<i class="fa fa-star" aria-hidden="true"></i>';
										}
									?>										
								</div>
								<div class="review-text"><p><?php echo $rate['review']; ?></p></div>
							</div>
						</li>
					<?php endforeach; ?>						
				</ul>
				<button type="button" class="btn btn-warning mt-3" id="loadReview">Load More Review</button>
			</div>
		</div>
		<?php endif;?>

		<div class="row compare-packages">
			<div class="col-sm-8">
				<h2 class="title">Compare packages</h2>
				<div class="gig-page-packages-table">
				<table>
					<tbody>
						<tr class="package-type">
							<th class="package-row-label">Package</th>
							<th class="package-type-price">
								<div class="price-wrapper">
									<p class="price">₹2,191</p>
								</div>
								<b class="type">Basic</b>
								<b class="title">50 SEO Backlinks on Blogs</b>
							</th>
							<th class="package-type-price">
								<div class="price-wrapper">
									<p class="price">₹4,382</p>
								</div>
								<b class="type">Standard</b>
								<b class="title">100 SEO Backlinks on Blogs</b>
							</th>
							<th class="package-type-price">
								<div class="price-wrapper">
									<p class="price">₹7,888</p>
								</div>
								<b class="type">Premium</b>
								<b class="title">200 Backlinks on Blogs</b>
							</th>
						</tr>
						<tr class="description">
							<td class="package-row-label"></td>
							<td>50 dofollow SEO Backlinks on SEO Blogs with DA 50+</td>
							<td>100 dofollow SEO Backlinks on SEO Blogs with DA 50+ | BONUS 200 Tier 2 Links </td>
							<td>200 dofollow SEO Backlinks on SEO Blogs with DA 50+ | BONUS 600 Tier 2 Links</td>
						</tr>
						<tr class="delivery-time">
							<td class="package-row-label">Delivery Time</td>
							<td>1-3 Days</td>
							<td>1-5 Days</td>
							<td>2-3 Months</td>
						</tr>
						<tr>
							<td>Revisions</td>
							<td>3</td>
							<td>5</td>
							<td>10</td>
						</tr>
						<tr>
							<td>Source File</td>
							<td><i class="fa fa-times" aria-hidden="true"></i></td>
							<td><i class="fa fa-check" aria-hidden="true"></i></td>
							<td><i class="fa fa-check" aria-hidden="true"></i></td>
						</tr>

						<tr class="select-package">
							<td class="package-row-label">Total</td>
							<td>
								Order $5.00
							</td>
							<td>
								Order $20.00
							</td>
							<td>
								Order $30.00
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			</div>
		</div>

		<?php if(!empty($browse_history)): ?>
			<div class="container">
				<div class="row">
					<h1 class="title text-center">
						Your Browsing History
					</h1>
					<?php
						$data['all_services'] = $browse_history;
						$this->load->view('site/service_list',$data);
					?>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!empty($people_history)): ?>
			<div class="container">
				<div class="row">
					<h1 class="title text-center">
						People Who Viewed This Service Also Viewed
					</h1>
					<?php
						$data['all_services'] = $people_history;
						$this->load->view('site/service_list',$data);
					?>			
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php include ("include/footer.php") ?>

<script type="text/javascript">
	let totalPrice = 0;

	$('.checkbox-effect').change(function() {
	  updateTotalPrice();    
	});

	function updateTotalPrice() {
	  	totalPrice = 0;
	  	let selectedIds = [];
	  	var servicePrice = '<?php echo number_format($service_details['price'],2); ?>';

	  	var qty = $('#qty_of_type').val();
	  	if(qty != "" && qty > 0){
	  		var mainPrice = parseFloat(servicePrice) * qty;	
	  	}else{
	  		var mainPrice = '<?php echo number_format($service_details['price'],2); ?>';
	  	}

	  	$('.checkbox-effect:checked').each(function() {
	  		var price = $(this).attr('data-price');
	  		totalPrice += parseFloat(price);
	  		selectedIds.push($(this).data('id'));
	  	});
	  	var newPrice = parseFloat(mainPrice) + parseFloat(totalPrice); 
	  	var priceText = 'Order (£'+newPrice.toFixed(2)+')';
	  	$('#orderBtn').val(priceText);
	  	$('#selected_exsIds').val(selectedIds.join(','));
	}

	document.getElementById('qty_of_type').addEventListener('input', function() {
	    countPrice(this.value);
	});

	document.getElementById('qty_of_type').addEventListener('change', function() {
	    countPrice(this.value);
	});

	function countPrice(qty){
		var price = <?php echo $service_details['price']; ?>;
		var mainPrice = parseFloat(price) * qty;
		updateTotalPrice();
	};

	$("#serviceOrder").submit(function(){
	    $.ajax({
	        url: "<?= site_url().'checkout/addToCart'; ?>", 
	        data: $("#serviceOrder").serialize(), 
	        type: "POST", 
	        dataType: 'json',
	        success: function (data) {
	        	if(data.status == 1){
	        		window.location.href = '<?php echo base_url().'serviceCheckout'; ?>';
	        	}else if(data.status == 2){
	        		swal({
			            title: "Login Required!",
			            text: "If you want to order the please login first!",
			            type: "warning"
			        }, function() {
			            window.location.href = '<?php echo base_url().'login'; ?>';
			        });        		
	        	}else{
	        		alert('Something is wrong. Please try again!!!');
	        	}            
	        },
	        error:function(e){
	            console.log(JSON.stringify(e));
	        }
	    }); 
	    return false;
	});

	let offset = <?php echo count($service_rating); ?>;
	const limit = 3;

	function loadMoreReviews() {
		var baseUrl = "<?php echo base_url(); ?>";
	    $.ajax({
	        url: '<?= site_url().'home/loadMoreReviews'; ?>',
	        type: 'POST',
	        data: {
	            service_id: '<?php echo $service_details['id']; ?>',
	            limit: limit,
	            offset: offset
	        },
	        success: function(response) {
	            let reviews = JSON.parse(response);
	            if (reviews.length > 0) {
	                offset += limit;
	                // Append reviews to your reviews container
	                let reviewsHtml = '';
	                reviews.forEach(review => {
	                	let profileImg = review.rate_by_profile ? baseUrl + 'img/profile/' + review.rate_by_profile : baseUrl + 'img/default-img.png';
	                    let userName = (review.rate_by_fname || '') + ' ' + (review.rate_by_lname || '');
	                    
	                    reviewsHtml += `
	                        <li>
	                            <div class="profile-img">
	                                <img src="${profileImg}" alt="${userName}" />
	                            </div>
	                            <div class="review-right">
	                                <div class="review-name">
	                                    <h4>${userName}</h4>
	                                    <span></span>
	                                </div>
	                                <div class="review-star">
	                                    ${getStars(review.rating)}
	                                </div>
	                                <div class="review-text"><p>${review.review}</p></div>
	                            </div>
	                        </li>
	                    `;
	                });

	                $('#reviewList').append(reviewsHtml);
	            } else {
	                $('#loadReview').hide();
	            }
	        }
	    });
	}

	$('#loadReview').on('click', function() {
	    loadMoreReviews();
	});

	function timeAgo(dateString) {
	    // Function to format the time ago (e.g., using a library like moment.js)
	    return moment(dateString).fromNow(); // Example using moment.js
	}

	function getStars(rating) {
	    // Generate star icons based on the rating
	    let starsHtml = '';
	    for (let i = 1; i <= rating; i++) {
	        starsHtml += '<i class="fa fa-star" aria-hidden="true"></i>';
	    }
	    return starsHtml;
	}

	$('#timeSlot').on('change', function() {
        updateAvailabilityMessage(); // Call formatSentence when time slot changes
    });

    $('#openChat').on('click', function(){
    	$('#checkoutBtn').disabled = true;
    	var selectedDates = $('#selectedDates').val();
    	var timeSlot = $('#timeSlot').val();
    	var isOpen = 1;
    	if(selectedDates == "" || timeSlot == ""){
    		isOpen = 0;
    	}

    	if(isOpen == 0){
			swal({
	        	title: "Error",
	            text: 'Please select date & time',
	            type: "error"
	        });	
    	}else{
			swal({
		      title: "Send Inquiry",
		      text: "Are you sure you want to continue with this service?",
		      type: "warning",
		      showCancelButton: true,
		      confirmButtonText: 'Yes, Continue',
		      cancelButtonText: 'Cancel'
		    }, function() {
		    	$('#loader').removeClass('hide');
		    	var serviceId = <?php echo $service_details['id']; ?>;
		      	var msg = $('#notAvailablMsg').text();

		      	$.ajax({
			        url: '<?= site_url().'users/sendInquiry'; ?>',
			        type: 'POST',
			        data: {'serviceId':serviceId,'message':msg},
			        dataType: 'json',                   
			        success: function(result) {
			          if(result.status == 0){
			            swal({
			              title: "Error",
			              text: result.message,
			              type: "error"
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
			          	$('#loader').addClass('hide');
			            swal({
			              title: "Success",
			              text: result.message,
			              type: "success"
			            }, function() {
			            	$('#checkoutBtn').disabled = false;
			                get_chat_onclick(<?php echo $service_details['user_id'];?>, <?php echo $service_details['id'];?>);
			                showdiv();
			            });
			          }
			        },
			        error: function(xhr, status, error) {
			                // Handle error
			        }
		      	}); 
		    });
    	}
    });

    $('#contactBtn').on('click', function(){
		get_chat_onclick(<?php echo $service_details['user_id'];?>, <?php echo $service_details['id'];?>);
		showdiv();
    });

</script>