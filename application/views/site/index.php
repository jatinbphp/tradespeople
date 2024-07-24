<?php include ("include/header.php") ?>
<style>
	.main_nw {
		display: flex;
		justify-content: center;
		align-items: center;
		width: 1170px;
		margin: 0 auto;
		text-align: center;
	}
	.main_nw h1 {
		font-size: 40px;
		line-height: 47px;
		color: #000;
	}
</style>


<div class="hamepage-banner">
	<div class="banner-img">

		<picture>
			<source srcset="https://www.myjobquote.co.uk/assets/images/topmainimage.png" media="(min-width: 768px)" />
			<img src="https://www.myjobquote.co.uk/assets/images/mobiletopmainimagemedium3-2.png" alt="" />
		</picture>
	</div>
	<div class="hamepage-banner-des">
		<div class="container">
			<div class="box">
				<h1>Find Tradespeople, compare up to 3 quotes!</h1>
				<p>It's FREE and there are no obligations</p>
				<div class="postcode-container">
					<form method="post" action="">
						<input type="hidden" name="_token" value="" autocomplete="off">
						<!-- <i class="icon-search search"></i> -->
						<i class="fa fa-search search" aria-hidden="true"></i>
						<input type="text" name="postcode" value="" placeholder="Enter your postcode" aria-label="Your postcode">
						<button type="submit" class="qform">Get Started</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="customer-service">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="box">
					<div>
						<i class="fa fa-truck" aria-hidden="true"></i>
					</div>
					<div>
						<h4>FREE SHIPPING & RETURN</h4>
						<p>free shipping on orders over $99</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box">
					<div>
						<i class="fa fa-usd" aria-hidden="true"></i>
					</div>
					<div>
						<h4>MONEY BACK GUARANTEE</h4>
						<p>100% Money Back Guarantee</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="box">
					<div>
						<i class="fa fa-clock-o" aria-hidden="true"></i>
					</div>
					<div>
						<h4>ONLINE SUPPORT 24/7</h4>
						<p>Always Dedicated Team</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($all_services)): ?>
	<hr class="my0">
	<div class="service-list">
		<div class="container">
			<h1 class="head-home">Most Popular Services</h1>
			<div class="row">
				<?php foreach($all_services as $list){ ?>
					<div class="col-sm-3">
						<!-- loop -->
						<div class="tradespeople-box">
							<div class="tradespeople-box-img">
								<a href="<?php echo base_url().'service/'.$list['slug']?>">
									<img src="<?php echo  base_url().'img/services/'.$list['image']; ?>">
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
								<a href="<?php echo base_url().'service/'.$list['slug']?>">
									<b>
										<?php echo 'From £'.$list['price']; ?>	
									</b>
								</a>
							</div>
						</div>									
					</div>
				<?php } ?>
			</div>
		</div>
	</div>	
<?php endif; ?>


<?php 
	if(!empty($all_categoty)){
?>
		<div class="category-list how-need pb-5">
			<div class="container">
					<h1 class="head-home text-center">Categories</h1>
				<div class="category-list-slider">
<?php					
		foreach($all_categoty as $cat){
?>

			<a href="<?php echo base_url().'category/'.$cat['slug']; ?>">
				<img src="<?php echo base_url('img/category_logo.svg') ?>" alt="category" loading="lazy">
				<p><?php echo $cat['cat_name']; ?></p>
			</a>

<?php
		}
?>
			</div>
		</div>
	</div>	
<?php		
	}
?>

<!-- news -->
<div class="man_nee2">
	<div class="container">
		<div class="neeesimng">
			<img src="img/news_newss.png">
		</div>
	</div>
</div>
<div class="main_nw" style="display: none;">
	<div class="news-home">
		<div class="" style="margin-right:10px;">
			<h1>We find you local vetted</h1>
			<img src="img/news_newss.png" class="img-responsive">
		</div>
	</div>
	<!-- 
	<div class="py-5">
  <div class="output" id="output">
    <h1 class="cursor"></h1>
    <p></p>
  </div>
</div> -->
<div class="news-home">
	<div class="" style="margin-right:10px;">
		<h1>&nbsp;fast, secure & free!</h1> 
		<!--  <img src="img/news.png" class="img-responsive">-->
	</div>
</div>

</div>


<!-- news -->
<!-- how-it-work -->
<div class="how-it">
	<div class="container">
		<h1 class="head-home">How it works</h1>
		<div class="how-section">
			<div class="row">
				<!-- loop -->
				<div class="col-sm-4">
					<div class="how-box">

						<div class="home-svg">
							<svg class="home-post" id="Layer_5" enable-background="new 0 0 64 64" height="512" viewBox="0 0 64 64" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m45.2 39.4 1.6 1.199 4.2-5.599v23c0 1.654-1.346 3-3 3h-36c-1.654 0-3-1.346-3-3v-25h-2v25c0 2.757 2.243 5 5 5h36c2.757 0 5-2.243 5-5v-23l4.2 5.599 1.6-1.199-6.8-9.067z"/><path d="m57.758 4c-1.4 0-2.717.545-3.707 1.535l-1.051 1.051v-.586c0-2.757-2.243-5-5-5h-36c-2.757 0-5 2.243-5 5v20l-4.2-5.6-1.6 1.2 6.8 9.067 6.8-9.067-1.6-1.2-4.2 5.6v-20c0-1.654 1.346-3 3-3h36c1.654 0 3 1.346 3 3v2.586l-17.942 17.942-1.236 8.65 8.65-1.236 10.528-10.528v4.586h2v-6.586l8.465-8.465c.99-.99 1.535-2.306 1.535-3.707 0-2.89-2.352-5.242-5.242-5.242zm-5.758 6.414 1.586 1.586-16.586 16.586-1.586-1.586zm-17.821 22.407.528-3.7 3.172 3.172zm5.821-1.235-1.586-1.586 16.586-16.586 1.586 1.586zm20.051-20.051-2.051 2.051-4.586-4.586 2.051-2.051c.612-.612 1.427-.949 2.293-.949 1.788 0 3.242 1.454 3.242 3.242 0 .866-.337 1.681-.949 2.293z"/><path d="m11 56c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-8c0-1.654-1.346-3-3-3h-14c-1.654 0-3 1.346-3 3zm2-8c0-.552.448-1 1-1h14c.552 0 1 .448 1 1v8c0 .552-.448 1-1 1h-14c-.552 0-1-.448-1-1z"/><path d="m11 32v8c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-8c0-1.654-1.346-3-3-3h-14c-1.654 0-3 1.346-3 3zm18 0v8c0 .552-.448 1-1 1h-14c-.552 0-1-.448-1-1v-8c0-.552.448-1 1-1h14c.552 0 1 .448 1 1z"/><path d="m33 57h16v2h-16z"/><path d="m47 53h2v2h-2z"/><path d="m33 53h12v2h-12z"/><path d="m33 49h16v2h-16z"/><path d="m33 45h16v2h-16z"/><path d="m33 41h10v2h-10z"/><path d="m33 37h10v2h-10z"/><path d="m11 5h2v2h-2z"/><path d="m15 5h2v2h-2z"/><path d="m19 5h2v2h-2z"/><path d="m11 9h26v2h-26z"/><path d="m35 13h2v2h-2z"/><path d="m11 13h22v2h-22z"/><path d="m11 17h26v2h-26z"/><path d="m17 21h2v2h-2z"/><path d="m21 21h2v2h-2z"/><path d="m25 21h2v2h-2z"/></svg>
						</div>
						<!--<img src="img/how1.png">-->
						<h2>Post A Job</h2>
						<p>It’s easy. Enter your requirements for the job you need undertaking and we’ll instantly notify our local tradespeople near you to provide you with quotes.
						</p>
					</div>
				</div>
				<!-- loop -->
				<!-- loop -->
				<div class="col-sm-4">
					<div class="how-box">
						<div class="home-svg">
							<svg class="get-quotes" height="496pt" viewBox="0 0 496 496" width="496pt" xmlns="http://www.w3.org/2000/svg"><path d="m472 80h-88v-32c0-2.472656-1.183594-4.601562-2.945312-6.0625l.074218-.082031-48-40-.074218.082031c-1.382813-1.160156-3.101563-1.9375-5.054688-1.9375h-208c-4.425781 0-8 3.574219-8 8v72h-88c-13.230469 0-24 10.769531-24 24v272c0 13.230469 10.769531 24 24 24h184v32h-48c-22.054688 0-40 17.945312-40 40v16c0 4.425781 3.574219 8 8 8h240c4.425781 0 8-3.574219 8-8v-16c0-22.054688-17.945312-40-40-40h-48v-32h184c13.230469 0 24-10.769531 24-24v-272c0-13.230469-10.769531-24-24-24zm-136-54.910156 17.894531 14.910156h-17.894531zm-208-9.089844h192v32c0 4.425781 3.574219 8 8 8h40v264h-240zm248 320c4.425781 0 8-3.574219 8-8v-200h64v224h-400v-224h64v200c0 4.425781 3.574219 8 8 8zm-16 136v8h-224v-8c0-13.230469 10.769531-24 24-24h176c13.230469 0 24 10.769531 24 24zm-88-40h-48v-32h48zm208-56c0 4.414062-3.585938 8-8 8h-448c-4.414062 0-8-3.585938-8-8v-272c0-4.414062 3.585938-8 8-8h88v16h-72c-4.425781 0-8 3.574219-8 8v240c0 4.425781 3.574219 8 8 8h416c4.425781 0 8-3.574219 8-8v-240c0-4.425781-3.574219-8-8-8h-72v-16h88c4.414062 0 8 3.585938 8 8zm0 0"/><path d="m215.144531 85.976562c5.457031-5.746093 8.855469-13.449218 8.855469-21.976562 0-17.648438-14.351562-32-32-32s-32 14.351562-32 32c0 8.527344 3.398438 16.230469 8.855469 21.976562-14.808594 8.183594-24.855469 23.945313-24.855469 42.023438v24c0 4.425781 3.574219 8 8 8h80c4.425781 0 8-3.574219 8-8v-24c0-18.078125-10.046875-33.839844-24.855469-42.023438zm-39.144531-21.976562c0-8.824219 7.175781-16 16-16s16 7.175781 16 16-7.175781 16-16 16-16-7.175781-16-16zm48 80h-64v-16c0-17.648438 14.351562-32 32-32s32 14.351562 32 32zm0 0"/><path d="m256 144h96v16h-96zm0 0"/><path d="m256 112h96v16h-96zm0 0"/><path d="m256 80h32v16h-32zm0 0"/><path d="m215.144531 229.976562c5.457031-5.746093 8.855469-13.449218 8.855469-21.976562 0-17.648438-14.351562-32-32-32s-32 14.351562-32 32c0 8.527344 3.398438 16.230469 8.855469 21.976562-14.808594 8.183594-24.855469 23.945313-24.855469 42.023438v24c0 4.425781 3.574219 8 8 8h80c4.425781 0 8-3.574219 8-8v-24c0-18.078125-10.046875-33.839844-24.855469-42.023438zm-39.144531-21.976562c0-8.824219 7.175781-16 16-16s16 7.175781 16 16-7.175781 16-16 16-16-7.175781-16-16zm48 80h-64v-16c0-17.648438 14.351562-32 32-32s32 14.351562 32 32zm0 0"/><path d="m256 288h96v16h-96zm0 0"/><path d="m256 256h96v16h-96zm0 0"/><path d="m256 224h32v16h-32zm0 0"/></svg>
						</div>
						<!--<img src="img/how2.png">-->
						<h2>Get Quotes</h2>
						<p>Compare the quotes, read profiles and ratings, browse previous work history, chat in real-time, choose and offer the job to the perfect tradesperson.
						</p>
					</div>
				</div>
				<!-- loop -->
				<!-- loop -->
				<div class="col-sm-4">
					<div class="how-box">
						<div class="home-svg">
							<svg class="pay-safe" viewBox="-25 1 511 511.99988" xmlns="http://www.w3.org/2000/svg"><path d="m460.242188 114.195312c-1.078126-16.929687-11.996094-31.886718-27.804688-38.105468l-185.621094-73.023438c-10.386718-4.085937-21.832031-4.089844-32.222656 0l-185.617188 73.023438c-15.8125 6.21875-26.726562 21.175781-27.804687 38.105468-1.03125 16.164063-4.605469 101.367188 26.359375 191.382813 15.488281 45.027344 37.222656 84.265625 64.597656 116.625 32.9375 38.933594 74.308594 68.167969 122.964844 86.890625 5.035156 1.9375 10.324219 2.90625 15.613281 2.90625 5.289063 0 10.578125-.96875 15.613281-2.90625 48.65625-18.722656 90.027344-47.957031 122.964844-86.890625 27.375-32.359375 49.105469-71.597656 64.597656-116.625 30.964844-90.015625 27.390626-175.21875 26.359376-191.382813zm-40.589844 186.488282c-14.882813 43.253906-35.691406 80.871094-61.855469 111.800781-31.285156 36.980469-70.609375 64.761719-116.878906 82.566406-6.585938 2.53125-13.839844 2.53125-20.421875 0-46.269532-17.804687-85.59375-45.585937-116.878906-82.566406-26.164063-30.929687-46.976563-68.542969-61.855469-111.800781-30.035157-87.304688-26.574219-169.867188-25.574219-185.53125.707031-11.128906 7.890625-20.964844 18.300781-25.058594l185.613281-73.027344c3.421876-1.34375 7.011719-2.015625 10.605469-2.015625 3.589844 0 7.183594.671875 10.601563 2.015625l185.617187 73.027344c10.40625 4.09375 17.589844 13.929688 18.300781 25.058594.996094 15.664062 4.457032 98.226562-25.574218 185.53125zm0 0"/><path d="m389.207031 112.441406-145.292969-57.15625c-8.519531-3.351562-17.898437-3.351562-26.414062 0l-145.292969 57.15625c-12.964843 5.101563-21.914062 17.367188-22.796875 31.246094-.636718 9.980469-1.628906 37.054688 2.859375 72.78125.519531 4.125 4.289063 7.046875 8.40625 6.527344 4.121094-.519532 7.042969-4.28125 6.523438-8.40625-4.328125-34.453125-3.378907-60.394532-2.773438-69.945313.515625-8.082031 5.734375-15.226562 13.292969-18.199219l145.289062-57.160156c4.964844-1.953125 10.433594-1.953125 15.398438 0l145.289062 57.160156c7.558594 2.972657 12.777344 10.117188 13.292969 18.199219 1.027344 16.105469 7.453125 159.9375-81.863281 248.652344-2.949219 2.925781-2.964844 7.691406-.035156 10.640625 1.46875 1.480469 3.40625 2.21875 5.339844 2.21875 1.914062 0 3.832031-.726562 5.300781-2.183594 94.027343-93.394531 87.34375-243.480468 86.273437-260.285156-.886718-13.878906-9.832031-26.144531-22.796875-31.246094zm0 0"/><path d="m289.269531 415.253906c-15.449219 11.160156-32.664062 20.429688-51.15625 27.546875-4.777343 1.835938-10.035156 1.835938-14.8125 0-98.238281-37.804687-135.992187-126.40625-150.363281-194.082031-.859375-4.066406-4.867188-6.660156-8.921875-5.796875-4.0625.863281-6.660156 4.855469-5.796875 8.921875 15.144531 71.316406 55.144531 164.773438 159.679688 205 4.128906 1.589844 8.46875 2.382812 12.808593 2.382812 4.339844 0 8.679688-.792968 12.808594-2.382812 19.707031-7.582031 38.0625-17.472656 54.566406-29.394531 3.367188-2.429688 4.125-7.132813 1.695313-10.503907-2.4375-3.367187-7.140625-4.125-10.507813-1.691406zm0 0"/><path d="m230.707031 144.109375c-61.695312 0-111.890625 50.191406-111.890625 111.886719 0 61.699218 50.195313 111.890625 111.890625 111.890625 61.695313 0 111.886719-50.191407 111.886719-111.886719s-50.191406-111.890625-111.886719-111.890625zm0 208.730469c-53.398437 0-96.84375-43.441406-96.84375-96.839844s43.445313-96.84375 96.84375-96.84375c53.398438 0 96.839844 43.445312 96.839844 96.84375s-43.441406 96.839844-96.839844 96.839844zm0 0"/><path d="m302.089844 226.855469c-.246094-7.453125-3.617188-14.527344-9.253906-19.414063l-1.828126-1.582031c-10.828124-9.382813-27.074218-8.628906-36.984374 1.71875l-39.851563 41.613281-10.039063-9.035156c-10.980468-9.878906-27.976562-9.003906-37.886718 1.953125-4.917969 5.441406-7.363282 12.46875-6.875 19.789063.484375 7.320312 3.832031 13.964843 9.429687 18.707031l30.339844 25.722656c5.070313 4.296875 11.234375 6.421875 17.378906 6.421875 6.824219 0 13.628907-2.625 18.875-7.8125l58.738281-58.105469c5.300782-5.246093 8.199219-12.527343 7.957032-19.976562zm-18.539063 9.277343-58.738281 58.105469c-4.382812 4.335938-11.238281 4.597657-15.941406.613281l-30.339844-25.722656c-2.460938-2.085937-3.933594-5.007812-4.148438-8.226562-.214843-3.21875.859376-6.308594 3.023438-8.703125 2.328125-2.570313 5.539062-3.878907 8.765625-3.878907 2.816406 0 5.644531.996094 7.894531 3.023438l11.023438 9.921875c5.527344 4.972656 13.886718 4.664063 19.03125-.707031l40.769531-42.570313c4.355469-4.550781 11.5-4.882812 16.261719-.757812l1.828125 1.585937c2.515625 2.175782 3.957031 5.207032 4.066406 8.535156.113281 3.324219-1.128906 6.441407-3.496094 8.78125zm0 0"/></svg>
						</div>
						<!--<img src="img/how3.png">-->
						<h2>Pay Safely </h2>
						<p>Pay for work securely using our milestone payment system, and rate the tradesperson.

						</p>
					</div>
				</div>
				<!-- loop -->
			</div>
		</div>
	</div>
</div>
<div class="home-read">
	<div class="container">   
		<div class="see-more">
			<a href="<?php echo base_url('how-it-work'); ?>" class="btn btn-primary btn-lg">Learn more</a>
		</div>
	</div>
</div>
<!-- how-it-work -->

<!-- need -->
<div class="how-need">
	<div class="container">
		<div class="add-new-need">
			<h1 class="head-home">What’s great about our service</h1>          
			<div class="row">
      <!--<div class="col-sm-3">
        <div class="need-box-other">
          What's great about our website
        </div>
      </div>-->
      <div class="col-sm-4 white-bg-need center-border">
      	<div class="need-new">
      		<div class="new-top">
      			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 480 480" style="enable-background:new 0 0 480 480;" xml:space="preserve">
      				<g>
      					<g>
      						<path d="M472,80H280c-4.418,0-8,3.582-8,8v72c0.003,4.418,3.588,7.997,8.006,7.994c0.857-0.001,1.709-0.139,2.522-0.41    l10.056-3.352c10.918-3.574,22.665,2.38,26.238,13.298c3.573,10.918-2.38,22.665-13.298,26.238c-4.204,1.376-8.737,1.376-12.941,0    l-10.056-3.352c-4.192-1.396-8.722,0.87-10.118,5.062c-0.271,0.813-0.409,1.665-0.41,2.522v64h-64    c-4.418,0.003-7.997,3.588-7.994,8.006c0.001,0.857,0.139,1.709,0.41,2.522l3.352,10.056c3.574,10.918-2.38,22.665-13.298,26.238    c-10.918,3.574-22.665-2.38-26.238-13.298c-1.376-4.204-1.376-8.737,0-12.941l3.352-10.056c1.396-4.192-0.87-8.722-5.062-10.118    c-0.813-0.271-1.665-0.409-2.522-0.41H88c-4.418,0-8,3.582-8,8v192c0,4.418,3.582,8,8,8h384c4.418,0,8-3.582,8-8V88    C480,83.582,476.418,80,472,80z M272.41,397.478c-0.271,0.813-0.409,1.665-0.41,2.522v64H96V288h52.904    c-6.113,19.383,4.645,40.052,24.028,46.164c19.383,6.113,40.052-4.645,46.164-24.028c2.272-7.204,2.272-14.933,0-22.137H272v64    c0.003,4.418,3.588,7.997,8.006,7.994c0.857-0.001,1.709-0.139,2.522-0.41l10.056-3.352c10.918-3.573,22.665,2.38,26.238,13.298    c3.573,10.918-2.38,22.665-13.298,26.238c-4.204,1.376-8.737,1.376-12.941,0l-10.056-3.352    C278.336,391.02,273.806,393.286,272.41,397.478z M464,464H288v-52.904c19.383,6.113,40.052-4.645,46.164-24.028    c6.113-19.383-4.645-40.052-24.028-46.164c-7.204-2.272-14.933-2.272-22.137,0V288h64c4.418-0.003,7.997-3.588,7.994-8.006    c-0.001-0.857-0.139-1.709-0.41-2.522l-3.352-10.056c-3.573-10.918,2.38-22.665,13.298-26.238    c10.918-3.573,22.665,2.38,26.238,13.298c1.376,4.204,1.376,8.737,0,12.941l-3.352,10.056c-1.396,4.192,0.87,8.722,5.062,10.118    c0.813,0.271,1.665,0.409,2.522,0.41h64V464z M464,272h-52.904c6.113-19.383-4.645-40.052-24.028-46.164    c-19.383-6.113-40.052,4.645-46.164,24.028c-2.272,7.204-2.272,14.933,0,22.137H288v-52.904    c11.111,3.601,23.275,1.658,32.712-5.224c16.546-11.802,20.392-34.783,8.59-51.329c-9.32-13.066-26.033-18.585-41.302-13.639V96    h176V272z"/>
      					</g>
      				</g>
      				<g>
      					<g>
      						<path style="fill:#fe8a0f" d="M230.137,68.904c-7.204-2.272-14.933-2.272-22.137,0V8c0-4.418-3.582-8-8-8H8C3.582,0,0,3.582,0,8v192    c0,4.418,3.582,8,8,8h60.904c-6.113,19.383,4.645,40.052,24.028,46.164s40.052-4.645,46.164-24.028    c2.272-7.204,2.272-14.933,0-22.137H200c4.418,0,8-3.582,8-8v-60.904c19.383,6.113,40.052-4.645,46.164-24.028    C260.277,95.685,249.52,75.017,230.137,68.904z M225.525,123.768c-4.204,1.376-8.737,1.376-12.941,0l-10.056-3.352    c-4.192-1.396-8.722,0.87-10.118,5.062c-0.271,0.813-0.409,1.665-0.41,2.522v64h-64c-4.418,0.003-7.997,3.588-7.994,8.006    c0.001,0.857,0.139,1.709,0.41,2.522l3.352,10.056c3.574,10.918-2.38,22.665-13.298,26.238    c-10.918,3.573-22.665-2.38-26.238-13.298c-1.376-4.204-1.376-8.737,0-12.941l3.352-10.056c1.396-4.192-0.87-8.722-5.062-10.118    c-0.813-0.271-1.665-0.409-2.522-0.41H16V16h176v64c0.003,4.418,3.588,7.997,8.006,7.994c0.857-0.001,1.709-0.139,2.522-0.41    l10.056-3.352c10.918-3.573,22.665,2.38,26.238,13.298C242.396,108.447,236.442,120.195,225.525,123.768z"/>
      					</g>
      				</g>
      			</svg>
      			<h3>Free & Easy </h3>
      		</div>
      		<p>It’s easy and free to use our service finding and hiring local tradespeople.</p>
      	</div>
      </div>
      <div class="col-sm-4 white-bg-need">
      	<div class="need-new">
      		<div class="new-top">
      			<svg viewBox="-39 0 495 495.648" xmlns="http://www.w3.org/2000/svg"><path d="m216.324219 112h-112c-4.417969 0-8-3.585938-8-8v-32c0-4.414062 3.582031-8 8-8h112c4.414062 0 8 3.585938 8 8v32c0 4.414062-3.585938 8-8 8zm0 0" fill="#fe8a0f"/><path d="m64.324219 136h88v16h-88zm0 0"/><path d="m168.324219 136h88v16h-88zm0 0"/><path d="m64.324219 200h88v16h-88zm0 0"/><path d="m168.324219 200h88v16h-88zm0 0"/><path d="m288.324219 240v-168h-8c-17.648438 0-32-14.351562-32-32v-8h-176v8c0 17.648438-14.351563 32-32 32h-8v272h8c17.648437 0 32 14.351562 32 32v8h160v-16h-144.664063c-3.382812-20.070312-19.265625-35.953125-39.335937-39.335938v-241.328124c20.070312-3.382813 35.953125-19.265626 39.335937-39.335938h145.328125c3.382813 20.070312 19.265625 35.953125 39.335938 39.335938v152.664062zm0 0"/><path d="m378.292969 397.398438-15.328125 4.59375 16.375 54.566406-20.59375-10.292969-18.085938 18.085937-11.039062-44.136718-15.511719 3.882812 17.878906 71.550782 29.910157-29.914063 43.410156 21.707031zm0 0"/><path d="m283.988281 464.351562-18.089843-18.085937-20.589844 10.292969 16.375-54.566406-15.328125-4.59375-.785157 2.601562h-189.964843c-3.386719-20.054688-19.226563-35.886719-39.28125-39.28125v-305.4375c20.054687-3.386719 35.886719-19.226562 39.28125-39.28125h209.4375c3.386719 20.054688 19.226562 35.886719 39.28125 39.28125v176.71875h16v-232h-320v416h240.449219l-21.433594 71.441406 43.40625-21.707031 29.914062 29.914063 17.878906-71.550782-15.511718-3.875zm20.335938-448.351562v22.863281c-11.191407-2.902343-19.960938-11.671875-22.863281-22.863281zm-288 0h22.863281c-2.902344 11.191406-11.671875 19.960938-22.863281 22.863281zm0 384v-22.863281c11.191406 2.910156 19.960937 11.671875 22.863281 22.863281zm0 0"/><path d="m64.324219 232h88v16h-88zm0 0"/><path d="m168.324219 232h88v16h-88zm0 0"/><path d="m64.324219 168h192v16h-192zm0 0"/><path d="m64.324219 264h173.253906v16h-173.253906zm0 0"/><path d="m312.324219 432c-9.625 0-18.542969-3.984375-24.945313-10.910156-9 2.820312-18.71875 1.78125-27.054687-3.019532-8.335938-4.8125-14.070313-12.726562-16.152344-21.917968-9.191406-2.082032-17.113281-7.816406-21.917969-16.152344-4.808594-8.335938-5.832031-18.0625-3.019531-27.054688-6.925781-6.402343-10.910156-15.320312-10.910156-24.945312s3.984375-18.542969 10.910156-24.945312c-2.8125-8.992188-1.796875-18.71875 3.019531-27.054688 4.8125-8.335938 12.726563-14.070312 21.917969-16.152344 2.082031-9.191406 7.816406-17.113281 16.152344-21.917968 8.328125-4.808594 18.046875-5.832032 27.054687-3.019532 6.402344-6.925781 15.320313-10.910156 24.945313-10.910156s18.542969 3.984375 24.945312 10.910156c8.992188-2.832031 18.710938-1.789062 27.054688 3.019532 8.335937 4.8125 14.070312 12.726562 16.152343 21.917968 9.191407 2.082032 17.113282 7.816406 21.917969 16.152344 4.808594 8.335938 5.832031 18.0625 3.015625 27.054688 6.929688 6.402343 10.914063 15.320312 10.914063 24.945312s-3.984375 18.542969-10.914063 24.945312c2.816406 8.992188 1.800782 18.71875-3.015625 27.054688-4.816406 8.335938-12.726562 14.070312-21.917969 16.152344-2.082031 9.191406-7.816406 17.113281-16.152343 21.917968-8.34375 4.808594-18.0625 5.816407-27.054688 3.019532-6.402343 6.925781-15.320312 10.910156-24.945312 10.910156zm0 0" fill="#fe8a0f"/><path style="fill:#fff" d="m312.324219 400c-39.703125 0-72-32.296875-72-72s32.296875-72 72-72 72 32.296875 72 72-32.296875 72-72 72zm0-128c-30.871094 0-56 25.128906-56 56s25.128906 56 56 56c30.871093 0 56-25.128906 56-56s-25.128907-56-56-56zm0 0"/><path style="fill:#fff" d="m312.324219 371.3125-32.6875-32.6875c-4.648438-4.648438-7.3125-11.082031-7.3125-17.65625 0-13.769531 11.199219-24.96875 24.96875-24.96875 5.414062 0 10.726562 1.808594 15.03125 5.03125 4.304687-3.222656 9.617187-5.03125 15.03125-5.03125 13.769531 0 24.96875 11.199219 24.96875 24.96875 0 6.574219-2.664063 13.007812-7.3125 17.65625zm-15.03125-59.3125c-4.945313 0-8.96875 4.023438-8.96875 8.96875 0 2.359375.953125 4.671875 2.625 6.34375l21.375 21.375 21.375-21.375c1.671875-1.671875 2.625-3.984375 2.625-6.34375 0-4.945312-4.023438-8.96875-8.96875-8.96875-2.359375 0-4.671875.953125-6.34375 2.625l-8.6875 8.6875-8.6875-8.6875c-1.671875-1.671875-3.984375-2.625-6.34375-2.625zm0 0"/></svg>   
      			<h3>Live chat
      			</h3>
      		</div>
      		<p> Live chat with the tradesperson before releasing your phone number.

      		</p>
      	</div>
      </div>
      <div class="col-sm-4 white-bg-need">
      	<div class="need-new">
      		<div class="new-top">


      			<svg height="496pt" viewBox="-24 0 496 496" width="496pt" xmlns="http://www.w3.org/2000/svg"><path d="m16 48h240v56c0 4.425781 3.574219 8 8 8h56v64h16v-72c0-2.214844-.902344-4.214844-2.351562-5.664062l-63.976563-63.976563c-1.457031-1.457031-3.457031-2.359375-5.671875-2.359375h-216v-16h304v176h16v-184c0-4.425781-3.574219-8-8-8h-320c-4.425781 0-8 3.574219-8 8v24h-24c-4.425781 0-8 3.574219-8 8v448c0 4.425781 3.574219 8 8 8h272v-16h-264zm256 11.3125 36.6875 36.6875h-36.6875zm0 0"/><path style="fill:#fe8a0f" d="m440 240h-12.046875c-35.722656 0-69.320313-15.734375-92.183594-43.167969l-1.617187-1.945312c-3.03125-3.65625-9.265625-3.65625-12.296875 0l-1.617188 1.9375c-22.871093 27.441406-56.46875 43.175781-92.191406 43.175781h-12.046875c-4.425781 0-8 3.574219-8 8v129.566406c0 31.503906 16.992188 60.785156 44.34375 76.410156l71.6875 40.96875c1.226562.703126 2.601562 1.054688 3.96875 1.054688s2.742188-.351562 3.96875-1.054688l71.6875-40.96875c27.351562-15.625 44.34375-44.90625 44.34375-76.410156v-129.566406c0-4.425781-3.574219-8-8-8zm-8 137.566406c0 25.777344-13.894531 49.730469-36.28125 62.511719l-67.71875 38.714844-67.71875-38.703125c-22.386719-12.792969-36.28125-36.746094-36.28125-62.523438v-121.566406h4.046875c38.175781 0 74.226563-15.863281 99.953125-43.769531 25.71875 27.90625 61.777344 43.769531 99.953125 43.769531h4.046875zm0 0"/><path d="m328 264c-48.519531 0-88 39.480469-88 88s39.480469 88 88 88 88-39.480469 88-88-39.480469-88-88-88zm0 160c-39.703125 0-72-32.296875-72-72s32.296875-72 72-72 72 32.296875 72 72-32.296875 72-72 72zm0 0" style="fill:#fe8a0f" /><path d="m324.183594 376.871094-14.527344-14.527344-11.3125 11.3125 24 24c1.511719 1.519531 3.558594 2.34375 5.65625 2.34375.648438 0 1.304688-.078125 1.953125-.238281 2.734375-.691407 4.894531-2.769531 5.710937-5.464844l24-80-15.328124-4.59375zm0 0" style="fill:#fe8a0f" /><path d="m32 128h208v16h-208zm0 0"/><path d="m32 160h208v16h-208zm0 0"/><path d="m32 192h208v16h-208zm0 0"/><path d="m32 224h160v16h-160zm0 0"/><path d="m32 256h160v16h-160zm0 0"/><path d="m32 288h160v16h-160zm0 0"/><path d="m32 384h160v16h-160zm0 0"/><path d="m32 416h160v16h-160zm0 0"/><path d="m32 448h160v16h-160zm0 0"/><path d="m40 64h16v16h-16zm0 0"/><path d="m72 64h16v16h-16zm0 0"/><path d="m104 64h16v16h-16zm0 0"/><path d="m136 64h104v16h-104zm0 0"/></svg>      
      			<h3>Pay for quality</h3>
      		</div>
      		<p>Pay when your work has been completed, and you’re 100% satisfied. </p>
      	</div>
      </div>

      
    </div>
  </div>
  
		<!--<div class="row">
			<div class="col-sm-9">	
				<div class="need-text">
					<div class="need-box hide">
					<h1 class="head-home">Looking for a trusted local tradesperson near you?</h1>
					<p>Finding the right tradesmen for your project can be tricky without personal recommendations from friends and family.As one of the best websites to find tradespeople, Tradeshubpeople helps youevery step of the way from getting estimates from a vast pool of registered tradesperson to achieving maximum satisfaction; we’ve got you covered.</p>	 			
					</div>
					<div class="need-box">
					<h1 class="head-home">What's great about our website</h1>
					<ul>
					<li><i class="fa fa-check-circle"></i> 	Access thousands of traders backed by satisfied feedbacks, certifications, insurance, and proof of qualifications </li>

					<li><i class="fa fa-check-circle"></i> Find professional tradespeople you can trust by either posting your job or directly hiring on the platform.</li>

					<li><i class="fa fa-check-circle"></i> Free to post, find and hire tradespeople quickly with no extra charges</li>

					<li><i class="fa fa-check-circle"></i> Only pay for your projects after your projects are handled to your satisfaction with fixed price or hourly terms in milestones for successful leads or completed projects. </li>
					
					<li><i class="fa fa-check-circle"></i> Uncover empowering advice and resources for homeowners and traders to make the best decisions at every instant. </li>

					<li><i class="fa fa-check-circle"></i> Access over 40 categories of skilled tradespersons to choose from.</li>

					<li><i class="fa fa-check-circle"></i> Pay for your projects securely using our milestone payment system.</li>
					</ul>
					
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="set-need">
					<img src="img/need-work.png">
				</div>
			</div>
		</div>-->
	</div>
</div>
<!-- need -->

<!-- browse -->
<div class="browse" id="top_categories">
	<div class="container">
		<h1 class="head-home text-center">Browse Top Tradesman Categories</h1>
		<div class="row">
			<?php $get_all_categories=$this->common_model->get_parent_category('category'); 
			$i = 1;
			foreach ($get_all_categories as $c) {
				if($c['is_activate'] != 1) continue;
				$custom_style = ($i > 20 || $c['cat_parent'] != 0)?'style="display:none"':'';
				?>
				<div class="col-sm-3 show_more_cate" <?php echo $custom_style; ?>>
					<div class="broswe-list">
						<ul>
							<li style="margin-top: -20px;">

								<a href="<?php echo base_url($c['slug']); ?>">
									<i class="fa fa-caret-right"></i>
									<?php echo $c['cat_name']; ?>
								</a>							
							</a>
						</li>
					</ul>
				</div>
			</div>
			<?php
			$i++; }
			?>

		</div>
	</div>
	<?php if(count($get_all_categories) > 0){ ?>
		<div class="show_more_cate_btn text-center ">
			<div class="set-home-white">
				<button class="btn btn-primary show_more_cate_btn2 btn-lg" onclick="load_more_cate();">See all</button>
			</div>
		</div>
		<script>
			function load_more_cate(){
				$('.show_more_cate_btn2').prop('disabled',true);
				$('.show_more_cate_btn2').html('See all <i class="fa fa-spin fa-spinner"></i>');
				setTimeout(function(){
					$('.show_more_cate_btn').hide();
					$('.show_more_cate').show();
				},1000);
			}
		</script>
	<?php } ?>
</div>
<!-- browse -->
<!-- testimonial -->
<div class="new_year_text">
	<h1 class="head-home">What Our Customers Says About Our Tradesmen
	</h1>
	<div class="container">
		<div class="owl-carousel owl-theme new_textmonial slider_arrrw">
			<?php 
			$showed_arr = array();
			if(count($customer_rev)>0){ 
				
				?>
				<?php foreach($customer_rev as $key=>$value){
					if(!in_array($value['rt_rateTo'],$showed_arr)){
						$userdataaa = $this->common_model->GetColumnName('users',array("id"=>$value['rt_rateTo']),array('trading_name','profile','total_reviews'));
						array_push($showed_arr,$value['rt_rateTo']);
						?>
						<div class="item">
							<div class="box_ny_1">
								<div class="box_rev">
									<?php if($userdataaa['profile']){ ?>
										<img src="<?php echo site_url().'img/profile/'.$userdataaa['profile']; ?>">
									<?php } else { ?>
										<img src="<?php echo site_url(); ?>img/profile/dummy_profile.jpg">
									<?php } ?>
									<!--span class="icon_review" data-toggle="modal" data-target="#testimonail"-->
									<a href="<?php echo site_url().'profile/'.$value['rt_rateTo']; ?>" ><span class="icon_review">

										<?php
										for($k=1; $k<=5; $k++){
											if($value['rt_rate'] >= $k){ ?>
												<i class="fa fa-star" aria-hidden="true"></i>
											<?php } else { ?>
												<i class="fa fa-star-o" aria-hidden="true"></i>
											<?php }
										}
										?>

									</span></a>
								</div>

								<?php

								$possitve_reviews_percent = $this->common_model->possitve_reviews_percent_given($value['rt_rateTo']);

								?>

								<h4><span class="testim_user_name"><?php echo $userdataaa['trading_name']; ?></span> reviewed <span class="testim_user_name"><?php echo $value['f_name']; ?></span> </br> <?php echo $userdataaa['total_reviews']; ?> Reviews, <?php echo round($possitve_reviews_percent,1); ?>% positive</h4>
								<h3 style="margin-top: 0px;">
									"<?php echo substr(strip_tags($value['rt_comment']),0,102); ?> <!--a href="" data-toggle="modal" data-target="#testimonail">Read More</a--><a href="<?php echo site_url().'profile/'.$value['rt_rateTo']; ?>" >Read More</a>"
								</h3>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>
<!-- testimonial -->


<!--<div class="nw_sec">
	<div class="container">
        <h1 class="head-home text-center">What Service Do You Need?</h1>
		<p>We aim to make the process of finding competent local tradespeople seamless. Let Trades People Hub help you every step of the waywith the right pros toprovide quality and consistency beyond your expectations.</p>
		<div class="btn-fot" style="text-align: center;">
			<a href="httpps://www.tradespeoplehub.co.uk/post-job" class="btn btn-primary btn-lg">Post Your Job Now</a>
		</div>
	</div>
</div>-->

<div class="nw_sec">
	<div class="container">
		<h1 class="head-home text-center">So what are you waiting for?</h1>
		<p>Post a job today and get quotes from skilled tradespeople.</p>
		<div class="btn-fot" style="text-align: center;">
			<a href="<?php echo site_url(); ?>post-job" class="btn btn-warning btn-lg">Post a job now</a>
		</div>
	</div>
</div>



<!-- upper-footer -->
<div class="upper-foot text-center">
	<div class="container">
		<h1 class="head-home">I'm a tradesperson</h1>
		<img src="img/apply.png">
		<p>Are you skilled, experienced, and ready to deliver the best?<br> Use Tradespeoplehub to boost your chances of getting attractive and verified jobs. <!--Learn how we help you <span>earn more.</span>--></p>
		
		<div class="btn-fot">
			<a href="<?php echo base_url('register'); ?>" class="btn btn-primary btn-lg">Join our pool of skilled tradesmen</a>
		</div>    
	</div>
</div>
<div class="browse" style="background-color:#fff;">
	<div class="container">
		<h1 class="head-home text-center">Find Tradesman Near You</h1>
		<div class="row">
			<?php 
			$cites=$this->common_model->GetColumnName('tbl_city',array('is_delete'=>0),null,true); 
			$i = 1;
			foreach ($cites as $city) {
				$custom_style = ($i > 19)?'style="display:none"':'';
				?>
				<div class="col-sm-3 show_more_city" <?php echo $custom_style; ?>>
					<div class="broswe-list">
						<ul>
							<li style="margin-top: -20px;">

								<a href="<?php echo base_url('find-tradesmen/'.strtolower($city['city_name'])); ?>">
									<i class="fa fa-caret-right"></i>
									<?php echo $city['city_name']; ?>
								</a>	
							</li>
						</ul>
					</div>
				</div>
				<?php
				$i++; }
				?>
				<?php if(count($cites) > 19){ ?>
					<div class="col-sm-3 show_more_city_btn">
						<div class="broswe-list">
							<ul>
								<li style="margin-top: -20px;">

									<a class="show_more_city_btn2" onclick="load_more_cate2();"><i class="fa fa-caret-right"></i> See all</a>
								</li>
							</ul>
						</div>
					</div>

					<script>
						function load_more_cate2(){
							$('.show_more_city_btn2').prop('disabled',true);
							$('.show_more_city_btn2').html('See all <i class="fa fa-spin fa-spinner"></i>');
							setTimeout(function(){
								$('.show_more_city_btn').hide();
								$('.show_more_city').show();
							},1000);
						}
					</script>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<!-- upper-footer -->
</div>
<?php include ("include/footer.php") ?>

<script type="text/javascript">

	$('.new_textmonial').owlCarousel({
		loop:false,
		margin:15,
		nav:true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1000:{
				items:3
			}
		}
	});


</script>


<!-- Modal -->
<div class="modal fade set-testi" id="testimonail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">What Our Customers Say About Us</h4>
			</div>
			<div class="modal-body">
				<div class="box_ny_1">
					<div class="box_rev">
						<img src="img/testi1.png">
						<span class="icon_review">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
						</span>
					</div>

					<h4>Jonth Smith <span class="rev_text">Reviewed</span> 60 feedback, 100% positive</h4>
					<h3>"I am truly impressed by this incredible platform, which helped me save a lot of money by accessing more affordable quotes for my home remodel project. I could not have been more pleased – our project was handled competently with lots of dedication and care, so  I was able to handle other important tasks without pressure. I totally recommend tradeshubpeople."</h3>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade set-testi" id="testimonail1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">What Our Customers Say About Us</h4>
			</div>
			<div class="modal-body">
				<div class="box_ny_1">
					<div class="box_rev">
						<img src="img/testi2.png">
						<span class="icon_review">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
						</span>
					</div>

					<h4>Bryant Twiford <span class="rev_text">Reviewed</span> 60 feedback, 100% positive</h4>
					<h3>"I was so thrilled after finding the perfect person without fussing around trying to figure out the website And XXX was so prompt and got the task completed within the deadline. I couldn't be happier – It was so amazing from start to finish!"</h3>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade set-testi" id="testimonail2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">What Our Customers Say About Us</h4>
			</div>
			<div class="modal-body">
				<div class="box_ny_1">
					<div class="box_rev">
						<img src="img/testi3.png">
						<span class="icon_review">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
						</span>
					</div>

					<h4>Ami Koehler <span class="rev_text">Reviewed</span> 60 feedback, 100% positive</h4>
					<h3>"On our own, we have tried using referrals from friends and neighbors, and it took too much time, and we got stuck filtering salesmen advice from real referrals.  Finding this website for the new bathroom remodel project was a huge relief, and the service was super awesome! Highly recommend!"</h3>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$yesterday = date('Y-m-d',strtotime(date('Y-m-d').' - 1 days'));

$this->common_model->delete(array('date <= '=>$yesterday),'daily_sms_records');

$today_sms = $this->common_model->get_data_count('daily_sms_records',array('date'=>date('Y-m-d')),'id');

?>


<script>

// values to keep track of the number of letters typed, which quote to use. etc. Don't change these values.
var i = 0,
a = 0,
isBackspacing = false,
isParagraph = false;

// Typerwrite text content. Use a pipe to indicate the start of the second line "|".  
var textArray = [
"Tradespeople.|", 
"Builders.", 
"Plumbers.", 
"Electricians."
];

// Speed (in milliseconds) of typing.
var speedForward = 100, //Typing Speed
    speedWait = 1000, // Wait between typing and backspacing
    speedBetweenLines = 1000, //Wait between first and second lines
    speedBackspace = 25; //Backspace Speed

//Run the loop
typeWriter("output", textArray);

function typeWriter(id, ar) {
	var element = $("#" + id),
	aString = ar[a],
      eHeader = element.children("span"), //Header element
      eParagraph = element.children("p"); //Subheader element

  // Determine if animation should be typing or backspacing
  if (!isBackspacing) {

    // If full string hasn't yet been typed out, continue typing
    if (i < aString.length) {

      // If character about to be typed is a pipe, switch to second line and continue.
      if (aString.charAt(i) == "|") {
      	isParagraph = true;
      	eHeader.removeClass("cursor");
      	eParagraph.addClass("cursor");
      	i++;
      	setTimeout(function(){ typeWriter(id, ar); }, speedBetweenLines);

      // If character isn't a pipe, continue typing.
    } else {
        // Type header or subheader depending on whether pipe has been detected
        if (!isParagraph) {
        	eHeader.text(eHeader.text() + aString.charAt(i));
        } else {
        	eParagraph.text(eParagraph.text() + aString.charAt(i));
        }
        i++;
        setTimeout(function(){ typeWriter(id, ar); }, speedForward);
      }
      
    // If full string has been typed, switch to backspace mode.
  } else if (i == aString.length) {

  	isBackspacing = true;
  	setTimeout(function(){ typeWriter(id, ar); }, speedWait);

  }

  // If backspacing is enabled
} else {

    // If either the header or the paragraph still has text, continue backspacing
    if (eHeader.text().length > 0 || eParagraph.text().length > 0) {

      // If paragraph still has text, continue erasing, otherwise switch to the header.
      if (eParagraph.text().length > 0) {
      	eParagraph.text(eParagraph.text().substring(0, eParagraph.text().length - 1));
      } else if (eHeader.text().length > 0) {
      	eParagraph.removeClass("cursor");
      	eHeader.addClass("cursor");
      	eHeader.text(eHeader.text().substring(0, eHeader.text().length - 1));
      }
      setTimeout(function(){ typeWriter(id, ar); }, speedBackspace);

    // If neither head or paragraph still has text, switch to next quote in array and start typing.
  } else { 

  	isBackspacing = false;
  	i = 0;
  	isParagraph = false;
      a = (a + 1) % ar.length; //Moves to next position in array, always looping back to 0
      setTimeout(function(){ typeWriter(id, ar); }, 50);
      
    }
  }
}
</script>
