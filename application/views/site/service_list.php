<?php foreach($all_services as $list): ?>
	<?php 
		$package_data = json_decode($list['package_data'],true);
		$servicePrice = $package_data['basic']['price'];
	?>
<div class="col-sm-3">
	<div class="tradespeople-box">
		<div class="tradespeople-box-img">
			<div class="icon-wishlist">
				<a href="#"></a>
				</div>
			<a href="<?php echo base_url().'service/'.$list['slug']?>">
				
				<?php $image_path = FCPATH . 'img/services/' . ($list['image'] ?? ''); ?>
				<?php if (file_exists($image_path) && $list['image']): ?>
					<?php
		                $mime_type = get_mime_by_extension($image_path);
		                $is_image = strpos($mime_type, 'image') !== false;
		                $is_video = strpos($mime_type, 'video') !== false;
		            ?>
		            <?php if ($is_image): ?>
						<img src="<?php echo  base_url().'img/services/'.$list['image']; ?>">
					<?php elseif ($is_video): ?>
						<video src="<?php echo base_url('img/services/') . $list['image']; ?>" 
						type="<?php echo $mime_type; ?>" loop controls class="profileServiceVideo">
						</video>
					<?php endif; ?>
				<?php endif; ?>
			</a>
		</div>
		<div class="tradespeople-box-avtar">
			<div class="avtar">	
				<img src="<?php echo  base_url().'img/profile/'.$list['profile']; ?>">
			</div>
			<div class="names">
				<a href="<?php echo base_url().'profile/'.$list['user_id']?>">
					<?php echo $list['trading_name']; ?>
				</a>
			</div>			
		</div>
		<div class="tradespeople-box-desc">
			<a href="<?php echo base_url().'service/'.$list['slug']?>">
				<p>
					<?php
						$totalChr = strlen($list['description']);
						if($totalChr > 120 ){
							echo substr($list['description'], 0, 120).'...';		
						}else{
							echo $list['description'];
						}
					?>
				</p>
			</a>
		</div>
		<div class="rating">
			<b>
				<i class="fa fa-star active"></i>
				<?php echo number_format($list['average_rating'],1); ?>
			</b>
			(<?php echo $list['total_reviews']; ?>)	
		</div>
		<div class="price">
			<a href="<?php echo base_url().'service/'.$list['slug']?>">
				<b>
					<?php echo '£'.number_format($servicePrice,2).' Per '.$list['price_per_type']; ?>	
				</b>
			</a>
		</div>
	</div>									
</div>
<?php endforeach; ?>