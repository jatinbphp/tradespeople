<?php foreach($service_rating as $rate): ?>																			
	<?php 
		$isRespond = !empty($rate['seller_response']) && $rate['is_responded'] == 1 ? 1 : 0;
		$package_data = json_decode($rate['service_package_data'],true);
		$prices = array_column($package_data, 'price');
		$minPrice = !empty($prices) ? min($prices) : 0;
		$maxPrice = !empty($prices) ? max($prices) : 0;
		$days = $package_data[$rate['order_package_type']]['days'];
	?>	
	<li>
		<div class="profile-img-name">
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
			<div class="review-name">
				<h4><?php echo $userName; ?></h4>
				<div class="location"><i class="fa fa-map-marker"></i> <?php echo $rate['rate_by_location']?></div>
			</div>
		</div>
		<div class="review-right" <?php if($isRespond != 1):?> style="border-bottom: none;" <?php endif; ?> >
			<div class="review-star">
				<div>
					<?php
						for($i=1; $i<=5; $i++){
							$color = $i <= $rate['rating'] ? '#fe8a0f' : '#dcd9d9';
							echo '<i class="fa fa-star" aria-hidden="true" style="color:'.$color.'"></i>';
						}
					?>
					<b><?php echo $rate['rating']; ?></b>
				</div>
				<span><?php echo time_ago($rate['created_at']); ?></span>										
			</div>
			<div class="review-text">
				<p>
					<?php if (strlen($rate['review']) > 305): ?>
					<div class="paragraph" data-full-text="<?php echo $rate['review'];?>">
			      <span class="content"></span>
			      <span class="read-more-btn text-primary">Read More</span>
			    </div>
			  <?php else:?>
			  	<?php echo $rate['review'];?>
			  <?php endif;?>	
				</p>
				<div class="price-duration">
					<div>
						<b>
							<?php echo '£'.number_format($minPrice,2); ?>
							<?php if($maxPrice > 0):?>-
								<?php echo '£'.number_format($maxPrice,2); ?>
							<?php endif; ?>	
						</b>
						<span class="text-muted">Price</span>
					</div>
					<div>
						<b><?php echo $days; ?> Days</b>
						<span class="text-muted">Duration</span>
					</div>
				</div>
			</div>
		</div>

		<?php if($isRespond == 1):?>
			<div class="accordion-profile">
				<div class="accordion-profile-item" onclick="toggleOrderReq();">
					<div class="accordion-img-name">
						<?php 
						if(isset($rate['rate_to_profile']) && !empty($rate['rate_to_profile'])){
							$rateToProfileImg = base_url('img/profile/'.$rate['rate_to_profile']);
						}else{
							$rateToProfileImg = base_url('img/default-img.png');
						}
						?>
						<img src="<?php echo $rateToProfileImg; ?>" alt="<?php echo $rateToUserName; ?>" />
						<h5><?php echo $rate['tName']."'s Response"; ?></h5>
						<i class="fa fa-angle-down pull-right"></i>
					</div>
					<div class="accordion-review-text" id="requirement-div"  style="display:none;">
						<p><?php echo $rate['seller_response']; ?></p>
					</div>
				</div>
			</div>
		<?php endif; ?>	
	</li>	
	<div class="helpful">
		<p>Helpful?</p>
		<span class="helpfulRate" id="helpYes_<?php echo $rate['id'];?>" onclick="helpfulRating('Yes',<?php echo $rate['id'];?>,<?php echo $rate['service_id'];?>)">
			<?php if($rate['is_helpful'] == 1):?>
				<i class="fa fa-thumbs-up text-danger"></i>
			<?php else:?>	
				<i class="fa fa-thumbs-o-up"></i>
			<?php endif;?>	
			 Yes
		</span>

		<span class="helpfulRate" id="helpNo_<?php echo $rate['id'];?>" onclick="helpfulRating('No',<?php echo $rate['id'];?>,<?php echo $rate['service_id'];?>)">
			<?php if($rate['is_helpful'] == 2):?>
				<i class="fa fa-thumbs-down text-danger"></i>
			<?php else:?>	
				<i class="fa fa-thumbs-o-down"></i>
			<?php endif;?> No
		</span>
	</div>
<?php endforeach; ?>	

<script type="text/javascript">
	const MAX_LENGTH = 305;
  document.querySelectorAll(".paragraph").forEach(paragraph => {
    const fullText = paragraph.getAttribute("data-full-text");
    const truncatedText = fullText.slice(0, MAX_LENGTH) + "...";

    const contentElement = paragraph.querySelector(".content");
    const buttonElement = paragraph.querySelector(".read-more-btn");

    // Initialize paragraph content to truncated text
    contentElement.textContent = truncatedText;

    // Add click event for the "Read More/Less" toggle
    buttonElement.addEventListener("click", () => {
      if (contentElement.textContent === truncatedText) {
        contentElement.textContent = fullText; // Show full text
        buttonElement.textContent = "Read Less";
      } else {
        contentElement.textContent = truncatedText; // Show truncated text
        buttonElement.textContent = "Read More";
      }
    });
  });
</script>