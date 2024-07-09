<?php include ("include/header.php") ?>
<link href="css/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<div class="categories-menu-main">
	<div class="container">
		<nav class="scroll-container categories-menu">
			<button id="scroll-left" class="scroll-btn left" style="top:0;">
				<span class="icon-chevron">
					<svg width="8" height="15" viewBox="0 0 8 15" xmlns="http://www.w3.org/2000/svg"><path d="M7.2279 0.690653L7.84662 1.30934C7.99306 1.45578 7.99306 1.69322 7.84662 1.83968L2.19978 7.5L7.84662 13.1603C7.99306 13.3067 7.99306 13.5442 7.84662 13.6907L7.2279 14.3094C7.08147 14.4558 6.84403 14.4558 6.69756 14.3094L0.153374 7.76518C0.00693607 7.61875 0.00693607 7.38131 0.153374 7.23484L6.69756 0.690653C6.84403 0.544184 7.08147 0.544184 7.2279 0.690653Z"></path></svg>
				</span>
			</button>
			<ul class="scroll-list categories">
				<?php foreach($categories_data as $data): ?>
					<li>
						<a href="<?php echo site_url('category/'.($data['slug'] ?? '')) ?>"><?php echo ($data['cat_name'] ?? '') ?></a>
						<?php if(isset($data['chiled']) && count($data['chiled'])): ?>
							<ul class="menu-panel">
								<?php foreach($data['chiled'] as $chiledData): ?>
									<li>
										<a href="<?php echo site_url('category/'.($data['slug'] ?? '').'/'.($chiledData['slug'] ?? '')) ?>"><?php echo ($chiledData['cat_name'] ?? '') ?></a>
										<?php if(isset($chiledData['chiled']) && count($chiledData['chiled'])): ?>
											<ul class="sub-menu-panel">
													<?php foreach($chiledData['chiled'] as $chiled): ?>
														<li><a href="<?php echo site_url('category/'.($data['slug'] ?? '').'/'.($chiledData['slug'] ?? '').'/'.($chiled['slug'] ?? '')) ?>"><?php echo ($chiled['cat_name'] ?? '') ?></a></li>
													<?php endforeach; ?>
											</ul>
											<?php else: ?>
												<ul class="sub-menu-panel">
													<li>-</li>
												</ul>
										<?php endif ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<button id="scroll-right" class="scroll-btn right" style="top:0;">
				<span class="icon-chevron">
					<svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
				</span>	
			</button>
		</nav>
	</div>
</div>


<div class="categories-banner">
	<div class="bnanner-img">
		<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/c5be9e1ff7a9c16910688aa6b7b5ffee-1688626700100/V_A-%20Desktop%20banner.png" alt="" />
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

<div class="popular-subcategories">
	<div class="container">
		<div class="popular-subcategories-slider">
			<?php if(isset($first_chiled_categories) && count($first_chiled_categories)): ?>
				<?php foreach($first_chiled_categories as $category): ?>
					<div>
						<a href="<?php echo site_url('category/'.($category_details['slug'] ?? '').'/'.($category['slug'] ?? '')) ?>">
							<img class="m-r-12" src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/4e99f7989f6e3ea9fc115fc017051455-1630332866288/Whiteboard%20_%20Animated%20Explainers.png" alt="<?php echo ($category['cat_name'] ?? '') ?>">
							<p><?php echo ($category['cat_name'] ?? '') ?></p>
							<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.92332 2.96885C9.63854 2.66807 9.1768 2.66807 8.89202 2.96885C8.60723 3.26963 8.60723 3.75729 8.89202 4.05807L11.6958 7.01931H1.48616C1.08341 7.01931 0.756918 7.36413 0.756918 7.7895C0.756918 8.21487 1.08341 8.5597 1.48616 8.5597H11.8436L8.89202 11.677C8.60723 11.9778 8.60723 12.4654 8.89202 12.7662C9.1768 13.067 9.63854 13.067 9.92332 12.7662L14.0459 8.41213C14.3307 8.11135 14.3307 7.62369 14.0459 7.32291L13.977 7.25011C13.9737 7.24661 13.9704 7.24315 13.9671 7.23972L9.92332 2.96885Z"></path>
							</svg>
						</a>
					</div>
				<?php endforeach ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="service-list">
	<div class="container">
		<div class="row">
			<?php if(!empty($services)): ?>
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
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- <div class="service-list">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="tradespeople-box">
					<?php echo ($category_details['description'] ?? '') ?>
				</div>							
			</div>
		</div>
	</div>
</div> -->


<script>
	$(document).ready(function() {
    var scrollContainer = $('.scroll-list');
    var scrollLeftBtn = $('#scroll-left');
    var scrollRightBtn = $('#scroll-right');

    function updateButtons() {
        if (scrollContainer.scrollLeft() <= 0) {
            scrollLeftBtn.addClass('hidden');
        } else {
            scrollLeftBtn.removeClass('hidden');
        }

        if (scrollContainer[0].scrollWidth - scrollContainer.outerWidth() <= scrollContainer.scrollLeft()) {
			scrollRightBtn.addClass('hidden');
        } else {
            scrollRightBtn.removeClass('hidden');
        }
    }

    scrollLeftBtn.on('click', function() {
		var containerWidth = scrollContainer.width();
		var deduction = (scrollContainer.width() / 6) ;
		console.log(containerWidth);
        scrollContainer.animate({
            scrollLeft: '-='+ (containerWidth - deduction)
        }, 'smooth');
    });
	

    scrollRightBtn.on('click', function() {
		var containerWidth = scrollContainer.width();
		var deduction = (scrollContainer.width() / 6) ;
        scrollContainer.animate({
            scrollLeft: '+='+ (containerWidth - deduction)
        }, 'smooth');
    });

    scrollContainer.on('scroll', updateButtons);

    updateButtons();
});

</script>

<?php include ("include/footer.php") ?>
