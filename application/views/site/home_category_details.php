<?php include ("include/header.php") ?>
<link href="css/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-ui.js"></script>
<?php $this->load->view('site/category_header'); ?>
<?php if($step == 1):?>
	<div class="categories-banner">
		<div class="bnanner-img">
			<?php $image_path = FCPATH . 'img/category/' . $category_details['cat_image']; ?>
			<?php if(isset($category_details['cat_image']) && file_exists($image_path)): ?>
				<?php $image = base_url('img/category/').$category_details['cat_image']; ?>	
			<?php else: ?>
				<?php $image = base_url('img/category_default.webp'); ?>	
			<?php endif ?>
			<img src="<?php echo $image; ?>" alt="categoty" />
		</div>
		<div class="categories-banner-des">
			<div class="container">	
				<div class="box-overlay">
					<h1 class="title"><?php echo ($category_details['cat_name'] ?? '') ?></h1>
					<p><?php echo ($category_details['meta_title'] ?? '') ?></p>
					<div class="categories-banner-video">
						<a href="<?php echo site_url('how-it-work') ?>" class="btn-play">
							<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M8 0a8 8 0 1 0 8 8 8.009 8.009 0 0 0-8-8ZM5.742 11.778 11.655 8.3a.348.348 0 0 0 0-.6L5.742 4.222a.348.348 0 0 0-.525.3v6.956a.348.348 0 0 0 .525.3Z">
								</path>
							</svg>
							How Trades People Hub Works
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url(""); ?>">
							<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill">
								<path d="M12.773 14.5H3.227a.692.692 0 0 1-.482-.194.652.652 0 0 1-.2-.468V7.884H.5l7.041-6.212a.694.694 0 0 1 .918 0L15.5 7.884h-2.046v5.954a.652.652 0 0 1-.2.468.692.692 0 0 1-.481.194Zm-4.091-1.323h3.409V6.664L8 3.056 3.91 6.664v6.513h3.408v-3.97h1.364v3.97Z"></path>
							</svg>
						</a>
					</li>

					<?php 
					    $url = site_url('category');
					    $total_items = count($breadcrumb);
	    				$current_item = 0;
					    foreach ($breadcrumb as $category): 
				    	$current_item++;
				        $url .= '/' . $category['slug'];
				        if ($current_item === $total_items):
				    ?> 
				    		<li><?php echo $category['cat_name']; ?></li>
    					<?php else: ?>
				        	<li><a href="<?php echo $url; ?>"><?php echo $category['cat_name']; ?></a></li>
				    	<?php endif; ?>
				    <?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="container how-fiverr-works">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title"><?php echo ($category_details['cat_name'] ?? '') ?></h1>
				<div class="explanation-video">
					<p class="sc-subtitle"><?php echo ($category_details['meta_title'] ?? '') ?></p>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(isset($first_chiled_categories) && count($first_chiled_categories)): ?>
	<div class="popular-subcategories">
		<div class="container">
			<div class="popular-subcategories-slider">			
				<?php foreach($first_chiled_categories as $category): ?>
					<?php 
                        $categoryUrl = $this->common_model->get_breadcrumb(($category['cat_id'] ?? 0));
                        $breadurl = site_url('category');
                        foreach ($categoryUrl as $catUrl){
                        	$breadurl .= '/' . $catUrl['slug'];
                        }
                    ?>
					<div>
						<?php $image_path = FCPATH . 'img/category/' . ($category['cat_image'] ?? ''); ?>
						<?php if(isset($category['cat_image']) && file_exists($image_path)): ?>
							<?php $image = base_url('img/category/').$category['cat_image']; ?>	
						<?php else: ?>
							<?php $image = base_url('img/category_logo.svg'); ?>	
						<?php endif ?>
						<a href="<?php echo $breadurl; ?>" class="<?php echo $step != 1 ? 'innerCat' : '';?>" >
							<img src="<?php echo $image; ?>" alt="categoty" />	
							<!-- <img class="m-r-12" src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/4e99f7989f6e3ea9fc115fc017051455-1630332866288/Whiteboard%20_%20Animated%20Explainers.png" alt="<?php echo ($category['cat_name'] ?? '') ?>"> -->
							<p><?php echo ($category['cat_name'] ?? '') ?></p>
							<?php if($step ==1): ?>
								<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
									<path d="M9.92332 2.96885C9.63854 2.66807 9.1768 2.66807 8.89202 2.96885C8.60723 3.26963 8.60723 3.75729 8.89202 4.05807L11.6958 7.01931H1.48616C1.08341 7.01931 0.756918 7.36413 0.756918 7.7895C0.756918 8.21487 1.08341 8.5597 1.48616 8.5597H11.8436L8.89202 11.677C8.60723 11.9778 8.60723 12.4654 8.89202 12.7662C9.1768 13.067 9.63854 13.067 9.92332 12.7662L14.0459 8.41213C14.3307 8.11135 14.3307 7.62369 14.0459 7.32291L13.977 7.25011C13.9737 7.24661 13.9704 7.24315 13.9671 7.23972L9.92332 2.96885Z"></path>
								</svg>
							<?php endif; ?>
						</a>
					</div>
				<?php endforeach ?>			
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(!empty($services)): ?>
	<div class="service-list">
		<div class="container">
			<div class="row">			
				<?php foreach($services as $list): ?>
					<div class="col-sm-3">
						<div class="tradespeople-box">
							<div class="tradespeople-box-img">
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<img src="<?php echo base_url().'img/services/'.$list['image']; ?>">
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<p>
										<?php
											$totalChr = strlen($list['service_name']);
											if($totalChr > 60 ){
												echo substr($list['service_name'], 0, 60).'...';		
											}else{
												echo $list['service_name'];
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<b>
										<?php echo 'From £'.$list['price']; ?>	
									</b>
								</a>
							</div>
						</div>									
					</div>
				<?php endforeach; ?>			
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(!empty($faqs) && count($faqs)):?>
	<div class="container" style="padding-bottom: 30px;">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title text-center">
					<?php echo ($category_details['cat_name'] ?? '').' FAQs' ?>
				</h1>
				<div class="row">
					<?php if(count($faqs) == 1):?>
						<?php foreach($faqs as $list):?>
						<div class="col-sm-12">
							<div>
								<b><?php echo $list['question']; ?></b>
							</div>
							<div style="margin-top: 10px;">
								<?php echo $list['answer']; ?>
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(count($faqs) > 1):?>
						<?php foreach($faqs as $list):?>
						<div class="col-sm-6">
							<div>
								<b><?php echo $list['question']; ?></b>
							</div>
							<div style="margin-top: 10px;">
								<?php echo $list['answer']; ?>
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>	
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(!empty($browse_history)): ?>
	<div class="service-list">
		<div class="container">
			<div class="row">
				<h1 class="title text-center">
					Your Browsing History
				</h1>
				<?php foreach($browse_history as $list): ?>
					<div class="col-sm-3">
						<div class="tradespeople-box">
							<div class="tradespeople-box-img">
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<img src="<?php echo base_url().'img/services/'.$list['image']; ?>">
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<p>
										<?php
											$totalChr = strlen($list['service_name']);
											if($totalChr > 60 ){
												echo substr($list['service_name'], 0, 60).'...';		
											}else{
												echo $list['service_name'];
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<b>
										<?php echo 'From £'.$list['price']; ?>	
									</b>
								</a>
							</div>
						</div>									
					</div>
				<?php endforeach; ?>			
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(!empty($people_history)): ?>
	<div class="service-list">
		<div class="container">
			<div class="row">
				<h1 class="title text-center">
					People Who Viewed This Service Also Viewed
				</h1>
				<?php foreach($people_history as $list): ?>
					<div class="col-sm-3">
						<div class="tradespeople-box">
							<div class="tradespeople-box-img">
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<img src="<?php echo base_url().'img/services/'.$list['image']; ?>">
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<p>
										<?php
											$totalChr = strlen($list['service_name']);
											if($totalChr > 60 ){
												echo substr($list['service_name'], 0, 60).'...';		
											}else{
												echo $list['service_name'];
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
								<a href="<?php echo base_url().'service/'.($list['slug'] ?? '')?>">
									<b>
										<?php echo 'From £'.$list['price']; ?>	
									</b>
								</a>
							</div>
						</div>									
					</div>
				<?php endforeach; ?>			
			</div>
		</div>
	</div>
<?php endif; ?>

<?php include ("include/footer.php") ?>
