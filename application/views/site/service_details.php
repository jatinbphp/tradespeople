
<?php include ("include/header.php") ?>

<div class="detail-cat acount-page service-detail-page">
	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li><a href="#0"><svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill"><path d="M12.773 14.5H3.227a.692.692 0 0 1-.482-.194.652.652 0 0 1-.2-.468V7.884H.5l7.041-6.212a.694.694 0 0 1 .918 0L15.5 7.884h-2.046v5.954a.652.652 0 0 1-.2.468.692.692 0 0 1-.481.194Zm-4.091-1.323h3.409V6.664L8 3.056 3.91 6.664v6.513h3.408v-3.97h1.364v3.97Z"></path></svg></a></li>
					<li><a href="#">service</a></li>
					<li class="current">test</li>
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
									<form>
										<input class="btn btn-warning btn-lg" type="submit" value="Order (<?php echo '£'.number_format($service_details['price'],2); ?>)">
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
					<p><i>Welcome to the journey of amazing design experience?</i></p>
					<p>You must be here in search of a professional and creative logo for your business thae can make your business nam <b>STAND OUT? <i>Yes you are at the perfect stop!</i></b> We have years of experience in creative designs and working with branda!</p>
					<h2 class="title">What you get with this Offer</h2>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Logo transparency</td>
									<td><i class="fa fa-check" aria-hidden="true"></i></td>

								</tr>
								<tr>
									<td>Vector file</td>
									<td><i class="fa fa-check" aria-hidden="true"></i></td>
								</tr>
								<tr>
									<td>Printable file</td>
									<td><i class="fa fa-check" aria-hidden="true"></i></td>
								</tr>
								<tr>
									<td>3D mockup</td>
									<td><i class="fa fa-check" aria-hidden="true"></i></td>
								</tr>
							</tbody>
						</table>
					</div>			
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
							<div class="value-container"><b>5 days</b></div>
						</div>
						<div class="col-sm-4 text-center no-padding">
							<div class="icon-container">
								<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
							</div>
							<div class="label-container">Rating</div>
							<div class="value-container"><b>98%</b> (645 reviews)</div>
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
								<span class="value">58,916</span>
							</li>
							<li>
								<span>Sales</span>
								<span class="value">903</span>
							</li>
							<li class="star-container pull-right">
								<div class="widget-star-item "><a class="action-entity-star fa fa-heart" href="#"></a><span class=" count-stars">464</span></div>
							</li>
						</ul>
					</div>

					<div class="member-summary">
						<div class="summary member-summary-section">
							<div class="member-image-container">
								<img class="img-border-round member-image" src="https://dw3i9sxi97owk.cloudfront.net/uploads/thumbs/03ce687db333b4fdb14992e6c2d0df77_150x150.jpg" alt="Ripon K.">
							</div>
							<div class="member-information-container">
								<div class="member-name-container crop">
									<h5>
										<a class="crop member-short-name" rel="nofollow" title="Ripon K." href="https://www.peopleperhour.com/freelancer/marketing-seo/ripon-kumar-seo-link-building-google-places-vnanjq?ref=provider">Ripon K.</a>
									</h5>
									<div class="member-job-title crop">seo,link Building,google places,Citations,back links,Website Traffic,social media,social bookmarks,local directory,twitter followers,youtube views,logo design,graphics design</div>
								</div>
							</div>
							<div class="cert-container text-right">
								<span class="cert cert-img"></span>
							</div>
						</div>
						<div class=" about member-summary-section clearfix">
							<div class="about-container js-about-container">
								<p>More than 5 years experience in SEO services.Completed 840+ projects with different buyers.Using White Hat SEO Technique. NO Automate 100% Manual Submission. Safe with Google Hummingbird,...<a class="about-read-more js-open-about-dialog-trigger" href="#">Read more</a>
									<span style="display: none;" class="js-about-full-text">More than 5 years experience in SEO services.Completed 840+ projects with different buyers.Using White Hat SEO Technique. NO Automate 100% Manual Submission. Safe with Google Hummingbird, Penguin &amp; Panda update 2.1. If you guys looking for a Quality Link building,Citations,local seo,local citations,social media services,website traffic,PBN Post,Guest Post,Video submission etc. then try us.<br>
										<br>
									► Results driven and Our Goal is providing Top Level Service to every customer, making sure we carefully check every order before delivery. Any questions you may have, you can write us directly through peopleperhour. We will respond within a few hours or sooner. Buy with confidence. Enjoy your visit and thank you for visiting our peopleperhour profile!</span>
								</p>
							</div>
						</div>
						<div class=" location member-summary-section clearfix">
							<div class="location-container crop">
								<i class="fpph-location"></i>
							Bangladesh</div>
						</div>
						<div class=" contact member-summary-section clearfix">
							<a class="btn btn-warning contact-button" rel="nofollow" href="/marketing/member/contact?id=490975&amp;job=H71678">Contact</a>
						</div>
					</div>

				</div>

				<div class="rating">
					<div class="rate">
						<span>4.9</span>
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
					</div>
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
				<h2 class="title">Get more with Offer Add-ons</h2>
				<div class="content-text clear addons-container">
					<ul class="addons clearfix boxmodelfix">
						<li class="item bg-fill clearfix clear">
							<div class="checkbox col-xs-7 col-sm-9">
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="business" type="checkbox" value="business" name="get-up-1">
										<label for="business"><div><h6>I can business Insider Press Release</h6>
											<p class="discreet small eta">Additional 2 working days</p></div></label>
										</div>
									</div>
								</div>
								<div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
									<span>+</span><span>$</span><span>141</span>
								</div>
							</li>
						</ul>
					</div>
					<div class="content-text clear addons-container">
						<ul class="addons clearfix boxmodelfix">
							<li class="item bg-fill clearfix clear">
								<div class="checkbox col-xs-7 col-sm-9">
									<div class="form-check">
										<div class="check-box">
											<input class="checkbox-effect" id="Do-Follw" type="checkbox" value="Do-Follw" name="get-up-1">
											<label for="Do-Follw"><div><h6>I can 132+ Do-Follw High PR or DA 30+ Highiy Authorized Backlinks</h6>
												<p class="discreet small eta">Additional 2 working days</p></div>
											</label>
										</div>
									</div>
								</div>
								<div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
									<span>+</span><span>$</span><span>42</span>
								</div>
							</li>
						</ul>
					</div>
					<div class="content-text clear addons-container">
						<ul class="addons clearfix boxmodelfix">
							<li class="item bg-fill clearfix clear">
								<div class="checkbox col-xs-7 col-sm-9">
									<div class="form-check">
										<div class="check-box">
											<input class="checkbox-effect" id="Authorized" type="checkbox" value="Authorized" name="get-up-1">
											<label for="Authorized"><div><h6>I can 132+ Do-Follw High PR or DA 30+ Highiy Authorized Backlinks</h6>
												<p class="discreet small eta">Additional 2 working days</p></div>
											</label>
										</div>
									</div>
								</div>

<<<<<<< HEAD
								<div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
									<span>+</span><span>$</span><span>56</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="order-hourlie-addons-sidebar">
						<h2 class="title">Availability Of Seller</h2>
						<div id="datepicker"></div>
					</div>		
				</div>
			</div>

			<div class="row faq-accordion help-center">

				<div class="col-sm-8">
					<h2 class="title">FAQ</h2>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
										Can you guarantee Google first page rankings?
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<p>I don't guarantee a first-page ranking, but I do guarantee an improvement in your website's ranking and visibility through high-quality backlinks and other proven off-page SEO strategies. Our goal is to help you achieve long-term success online.</p>
								</div>
=======
										<!-- <div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
											<span>+</span><span>$</span><span>141</span>
										</div> -->
									</li>
								</ul>
							</div>
							<div class="content-text clear addons-container">
								<ul class="addons clearfix boxmodelfix">
									<li class="item bg-fill clearfix clear">
										<div class="checkbox col-xs-7 col-sm-9">
											<div class="form-check">
												<div class="check-box">
													<input class="checkbox-effect" id="Do-Follw" type="checkbox" value="Do-Follw" name="get-up-1">
													<label for="Do-Follw"><div><h6>I can 132+ Do-Follw High PR or DA 30+ Highiy Authorized Backlinks</h6>
														<p class="discreet small eta">Additional 2 working days</p></div>
													</label>
												</div>
											</div>
										</div>

										<!-- <div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
											<span>+</span><span>$</span><span>42</span>
										</div> -->
									</li>
								</ul>
							</div>
							<div class="content-text clear addons-container">
								<ul class="addons clearfix boxmodelfix">
									<li class="item bg-fill clearfix clear">
										<div class="checkbox col-xs-7 col-sm-9">
											<div class="form-check">
												<div class="check-box">
													<input class="checkbox-effect" id="Authorized" type="checkbox" value="Authorized" name="get-up-1">
													<label for="Authorized"><div><h6>I can 132+ Do-Follw High PR or DA 30+ Highiy Authorized Backlinks</h6>
														<p class="discreet small eta">Additional 2 working days</p></div>
													</label>
												</div>
											</div>
										</div>

										<!-- <div class="addon-price col-xs-5 col-sm-3 price-tag medium text-right js-addon-price">
											<span>+</span><span>$</span><span>56</span>
										</div> -->
									</li>
								</ul>
>>>>>>> 96adb6005cf4997159024e9ce5d7f3f16f3b3b07
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Please Read!</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">      
									<p>I will not accept any adults, casinos, escorts, gambling, or illegal sites.</p>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Are these SEO backlinks Google safe?</a>
								</h4>
							</div>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<p>These links are 100% Google Panda and Penguin-safe! Most backlinks are from high-quality authority sites with few outbound links, so they are old domain, contextual, and relevant.</p>
								</div>
							</div>
						</div>       
						
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFour">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">How long for results?</a>
								</h4>
							</div>
							<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
								<div class="panel-body">
									<p>SEO is not a fixed science, and it is impossible to guarantee positions. Therefore I have no idea how long to get on the first page. Usually, it takes up to 2 months for sites that are well optimized (on-page) to see SERP movement on Google, but with our indexing service, we can see faster results.</p>
								</div>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingFive">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Do you create all the SEO backlinks all at once?</a>
								</h4>
							</div>
							<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
								<div class="panel-body">
									<p>This is a great question. If someone creates backlinks all at once, it will make your website look worse in google's eyes. With my service, your link profile will look natural because I will drip-feed all the links daily.</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="row">
				<div class="col-sm-8">
					<div class="portfolio-presence">
						<div class="presence-header">
							<a href="#">My portfolio</a>
							<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16ZM6.667 6.222c0-.228.075-.59.277-.87C7.112 5.12 7.4 4.89 8 4.89c.734 0 1.116.388 1.245.777.136.41.02.867-.405 1.15-.701.468-1.218.92-1.49 1.556-.24.56-.24 1.175-.239 1.752v.098H8.89c0-.728.015-.964.095-1.15.06-.142.21-.356.842-.777a2.751 2.751 0 0 0 1.106-3.19C10.558 3.978 9.488 3.111 8 3.111c-1.179 0-2.001.511-2.5 1.203a3.37 3.37 0 0 0-.611 1.908h1.778Zm2.222 6.667V11.11H7.11v1.778H8.89Z"></path></svg>
							<span class="new">NEW</span>
						</div>

						<ul class="project-grid grid-5">
							<li class="project-photo photo-0">
								<div class="project-img hide-on-error responsive-wrapper">
									<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto,t_portfolio_project_grid/v1/attachments/project_item/attachment/3f10e207a5e37f06393c99cf376f3919-1662737725876/screencapture-monicaallen-new-landing-page-2022-09-05-15_50_13.png">
								</div>
								<div class="project-title-wrapper responsive-wrapper">
									<span class="project-title">Wix website design</span>
								</div>
							</li>
							<li class="project-photo photo-1">
								<div class="project-img hide-on-error responsive-wrapper">
									<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto,t_portfolio_project_grid/v1/attachments/project_item/attachment/182ca86e49187a20778658e2ed06abc4-1662737834878/screencapture-exchain-ca-2022-09-04-22_11_27.png">
								</div>
								<div class="project-title-wrapper responsive-wrapper">
									<span class="project-title">Exchain</span>
								</div>
							</li>
							<li class="project-photo photo-2">
								<div class="project-img hide-on-error responsive-wrapper">
									<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto,t_portfolio_project_grid/v1/attachments/project_item/attachment/e19f5b1af107137c8c93cf226e5994db-1662738006470/screencapture-piletest-new-landing-page-2022-08-30-14_12_42.png">
								</div>
								<div class="project-title-wrapper responsive-wrapper">
									<span class="project-title">Piletest Landing Page</span>
								</div>
							</li>
							<li class="project-photo photo-3">
								<div class="project-img hide-on-error responsive-wrapper">
									<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto,t_portfolio_project_grid/v1/attachments/project_item/attachment/075a5a8452bf666c5e9a0963fe8c3bad-1662738317418/screencapture-revape-ca-2022-09-09-16_42_09.png">
								</div>
								<div class="project-title-wrapper responsive-wrapper">
									<span class="project-title">Revape</span>
								</div>
							</li>
							<li class="project-photo photo-4">
								<div class="project-img hide-on-error responsive-wrapper">
									<img src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto,t_portfolio_project_grid/v1/attachments/project_item/attachment/cc01a201977c285f21e2430c1258100f-1662738386958/screencapture-gshredsupplements-gshred-fat-burner-2022-09-09-16_45_36.png">
								</div>
								<div class="project-title-wrapper responsive-wrapper">
									<span class="project-title">Gshred</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row client-reviews">
				<div class="col-sm-8">
					<h2 class="title">Reviews</h2>
					<ul>
						<li>
							<div class="profile-img">
								<img src="https://dw3i9sxi97owk.cloudfront.net/uploads/thumbs/03ce687db333b4fdb14992e6c2d0df77_150x150.jpg" alt="Ripon K." />
							</div>
							<div class="review-right">
								<div class="review-name"><h4>Bayley Robertson</h4><span>3 years ago</span></div>
								<div class="review-star">
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
								</div>
								<div class="review-text"><p>Excellent service! 100% recommended</p></div>
							</div>
						</li>
						<li>
							<div class="profile-img">
								<img src="https://dw3i9sxi97owk.cloudfront.net/uploads/thumbs/03ce687db333b4fdb14992e6c2d0df77_150x150.jpg" alt="Ripon K." />
							</div>
							<div class="review-right">
								<div class="review-name"><h4>Bayley Robertson</h4><span>3 years ago</span></div>
								<div class="review-star">
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
									<i class="fas fa-star" aria-hidden="true"></i>
								</div>
								<div class="review-text"><p>Excellent service! 100% recommended</p></div>
							</div>
						</li>
					</ul>
				</div>
			</div>

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



		</div>
		<?php include ("include/footer.php") ?>

		<script type="text/javascript">
			$(document).ready(function() {
				if($('#datepicker').length){
					var today = new Date();
					$('#datepicker').multiDatesPicker({
          minDate: 0, // Ensure today's date can be selected
          onSelect: function(dateText, inst) {
          	var selectedDates = $('#datepicker').multiDatesPicker('getDates');
          	$('#selectedDates').val(selectedDates.join(','));
              //updateAvailabilityMessage();
          }
      });

      $('#datepicker').datepicker("option", "disabled", true); // Disable datepicker by default

      $('#yesCheckbox').on('change', function() {
      	if ($(this).is(':checked')) {
      		$('#noCheckbox').prop('checked', false);
      		$('#datepicker').datepicker("option", "disabled", true);
      		$('#datePickerDiv').hide();
      	}
      });

      $('#noCheckbox').on('change', function() {
      	if ($(this).is(':checked')) {
      		$('#yesCheckbox').prop('checked', false);
      		$('#datepicker').datepicker("option", "disabled", false);
      		$('#datePickerDiv').show();
      	}
      });

      var selectedDates = $('#datepicker').multiDatesPicker('getDates');
      if (!selectedDates.includes(today.toISOString().slice(0, 10))) {
          selectedDates.push(today.toISOString().slice(0, 10)); // Add current date if not already selected
      }
      $('#selectedDates').val(selectedDates.join(','));
      updateAvailabilityMessage();  
  }    
});
</script>