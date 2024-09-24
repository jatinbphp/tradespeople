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
					$breadcrumb = $this->common_model->get_breadcrumb('service_category',($service_details['service_type'] ?? 0));
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
									echo $this->common_model->make_all_image($service_details['image'], $service_details['video'], $service_images);										
									?>
								</div>
								<div class="slider slider-nav">
									<?php
									echo $this->common_model->make_all_image($service_details['image'], $service_details['video'], $service_images);
									?>									
								</div>
							</div>

							<div class="about-this">
								<h2 class="title">About this service</h2>
								<p>
									<?php echo $service_details['description']; ?>
								</p>

								<?php if($service_details['package_type'] == 0):?>
									<h2 class="title">What you get with this Offer</h2>
									<?php 
									$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
									?>
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<?php if(!empty($attributes)): ?>
													<?php foreach($attributes as $att):?>
														<?php
														$bchecked = !empty($basicAtt) && in_array($att['id'], $basicAtt) ? 'check' : 'times';		
														?>
														<tr>
															<td><?php echo $att['attribute_name']; ?></td>
															<td><i class="fa fa-<?php echo $bchecked; ?>" aria-hidden="true"></i></td>
														</tr>										
													<?php endforeach; ?>	
												<?php endif; ?>


												<?php $plugins = explode(',', $service_details['plugins']); ?>
												<?php foreach($plugins as $plugin): ?>
													<?php
													$pDetail = $this->common_model->GetSingleData('category',['cat_id'=>$plugin]); 											
													?>													
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>									
								<?php endif; ?>
							</div>
							
							<?php if(!empty($extra_services)): ?>
							<div class="order-hourlie-addons">								
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
																	<?php //if(!empty($exs['additional_working_days'])): ?>
																		<!--<span>
																			Additional Working Days <?php //echo $exs['additional_working_days'];?>
																		</span>-->
																	<?php //endif; ?>
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
							</div>
							<?php endif; ?>

							<?php if(!empty($service_faqs)): ?>
								<div class="faq-accordion help-center">

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
							<?php endif; ?>

							<?php if(!empty($user_profile)): ?>
								<div class="portfolio-presence">
									<div class="presence-header">
										<h2><a href="#">My portfolio</a></h2>
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
							<?php endif;?>

							<?php if(!empty($service_rating)): ?>
								<div class="client-reviews">
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
							<?php endif;?>

							<?php if($service_details['package_type'] == 1):?>
								<div class="container">
									<div class="compare-packages">
										<h2 class="title">Compare packages</h2>
										<div class="gig-page-packages-table">
											<table>
												<tbody>
													<tr class="package-type">
														<th class="package-row-label">Package</th>
														<th class="package-type-price">
															<div class="price-wrapper">
																<p class="price">
																	<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
																</p>
															</div>
															<b class="type">Basic</b>
														</th>
														<th class="package-type-price">
															<div class="price-wrapper">
																<p class="price"><?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?></p>
															</div>
															<b class="type">Standard</b>
														</th>
														<th class="package-type-price">
															<div class="price-wrapper">
																<p class="price"><?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?></p>
															</div>
															<b class="type">Premium</b>
														</th>
													</tr>
													<tr class="delivery-time">
														<td class="package-row-label">Delivery Time</td>
														<td><?php echo $package_data->basic->days; ?> Days</td>
														<td><?php echo $package_data->standard->days; ?> Days</td>
														<td><?php echo $package_data->premium->days; ?> Days</td>
													</tr>
													<?php 
													$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
													$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
													$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
													?>
													<?php if(!empty($attributes)): ?>
													<?php foreach($attributes as $att):?>
													<?php 

													$bchecked = !empty($basicAtt) && in_array($att['id'], $basicAtt) ? 'check' : 'times';
													$schecked = !empty($standardAtt) && in_array($att['id'], $standardAtt) ? 'check' : 'times';
													$pchecked = !empty($premiumAtt) && in_array($att['id'], $premiumAtt) ? 'check' : 'times';

													?>
													<tr>
														<td><?php echo $att['attribute_name']; ?></td>
														<td><i class="fa fa-<?php echo $bchecked; ?>" aria-hidden="true"></i></td>
														<td><i class="fa fa-<?php echo $schecked; ?>" aria-hidden="true"></i></td>
														<td><i class="fa fa-<?php echo $pchecked; ?>" aria-hidden="true"></i></td>
													</tr>
													<?php endforeach; ?>	
													<?php endif; ?>
													<tr class="select-package">
														<td class="package-row-label">Total</td>
														<td>
															Order <?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
														</td>
														<td>
															Order <?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?>
														</td>
														<td>
															Order <?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<?php endif; ?>

							
						</div>

						<div class="col-sm-4">
							<div class="sidebar-main" id="sidebar">
								<div class="service-detail-sidebar">
									<div class="sidebar-icons">
										<div class="">
											<button class="save" type="button" data-toggle="tooltip" data-placement="top" title="Save to list" data-id="<?php echo $service_details['id']; ?>" >
												<svg id="serId_<?php echo $service_details['id']; ?>" fill="<?php echo $service_details['is_liked'] == 1 ? '#ff0000' : '#b5b6ba'; ?>" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M14.4469 1.95625C12.7344 0.496875 10.1875 0.759375 8.61561 2.38125L7.99999 3.01562L7.38436 2.38125C5.81561 0.759375 3.26561 0.496875 1.55311 1.95625C-0.409388 3.63125 -0.512513 6.6375 1.24374 8.45312L7.29061 14.6969C7.68124 15.1 8.31561 15.1 8.70624 14.6969L14.7531 8.45312C16.5125 6.6375 16.4094 3.63125 14.4469 1.95625Z"></path></svg>
											</button>
											<span class="collect-count totalLikes"><?php echo $service_details['total_likes']; ?></span>
										</div>
										<button type="button" class="btn btn-outline service-share-button"  data-toggle="modal" data-target="#ShareThis">
											<span data-toggle="tooltip" data-placement="top" title="Share this service">
												<svg width="16" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill">
													<path d="M11 10c-.707 0-1.356.244-1.868.653L5.929 8.651a3.017 3.017 0 0 0 0-1.302l3.203-2.002a3 3 0 1 0-1.06-1.696L4.867 5.653a3 3 0 1 0 0 4.694l3.203 2.002A3 3 0 1 0 11 10Z"></path>
												</svg>
											</span>
										</button>										
									</div>

									<?php 
									$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
									$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
									$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
									$basicPackageName = isset($package_data) ? $package_data->basic->name : 'Basic';
									$standardPackageName = isset($package_data) ? $package_data->standard->name : 'Standad';
									$premiumPackageName = isset($package_data) ? $package_data->premium->name : 'Premium';
									?>

									<?php if($service_details['package_type'] == 1):?>
										<div class="sidebar-tabs">
											<ul  class="nav nav-pills">
												<li class="active packageTypes" data-days="<?php echo $package_data->basic->days; ?>"><a href="#Basic" data-toggle="tab"><?php echo $basicPackageName?></a></li>
												<li class="packageTypes" data-days="<?php echo $package_data->standard->days; ?>"><a href="#Standard" data-toggle="tab"><?php echo $standardPackageName?></a></li>
												<li class="packageTypes" data-days="<?php echo $package_data->premium->days; ?>"><a href="#Premium" data-toggle="tab"><?php echo $premiumPackageName?></a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="Basic">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
													</h2>
													<p><?php echo isset($package_data) ? $package_data->basic->description : '';?></p>
													<!--<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->basic->days; ?>-day delivery
													</h4>-->
													<ul>
														<?php if(!empty($attributes)): ?>
															<?php foreach($attributes as $att):?>
																<?php
																$bchecked = !empty($basicAtt) && in_array($att['id'], $basicAtt) ? 'check' : 'times';
																?>
																<?php if(in_array($att['id'], $basicAtt)):?>
																	<li>
																		<i class="fa fa-<?php echo $bchecked; ?>" aria-hidden="true"></i> 
																		<span>
																			<?php echo $att['attribute_name']; ?>
																		</span>
																	</li>
																<?php endif; ?>		
															<?php endforeach; ?>	
														<?php endif; ?>
													</ul>
													<form action="" method="post" id="basicForm" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="basic">

														<?php if(!empty($service_details['price_per_type'])):?>
															<ul>
																<li>
																	<i class="fa fa-check" aria-hidden="true"></i> 
																	<p class="text-left">
																		Price is based on 
																		<?php echo lcfirst($service_details['price_per_type']); ?>.
																	</p>
																</li>
															</ul>
															<div class="row text-left mb-3">
																<div class="col-md-8">
																	<p>
																		Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																	</p>
																</div>
																<div class="col-md-4">
																	<input type="number" class="form-control qty_of_type" name="qty_of_type" id="qty_of_type_basic" min="1" value="1">
																</div>
															</div>		
														<?php else: ?>
															<input type="hidden" name="qty_of_type" id="qty_of_type_basic" value="1">
														<?php endif; ?>	
														<input type="hidden" name="main_price" class="main_price" id="main_price_basic" value="<?php echo isset($package_data) ? $package_data->basic->price : 0;?>"> 
														
														<input class="orderBtn btn btn-warning btn-lg " type="submit" id="orderBasicBtn" data-package="basic" value="Buy Now (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>)">
													</form>
												</div>

												<div class="tab-pane" id="Standard">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?>
													</h2>
													<p><?php echo isset($package_data) ? $package_data->standard->description : '';?></p>
													<!--<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->standard->days; ?>-day delivery
													</h4>-->
													<ul>
														<?php if(!empty($attributes)): ?>
															<?php foreach($attributes as $att):?>
																<?php
																$schecked = !empty($standardAtt) && in_array($att['id'], $standardAtt) ? 'check' : 'times';					
																?>
																<?php if(in_array($att['id'], $standardAtt)):?>
																	<li>
																		<i class="fa fa-<?php echo $schecked; ?>" aria-hidden="true"></i>
																		<span>
																			<?php echo $att['attribute_name']; ?>
																		</span>
																	</li>
																<?php endif; ?>												
															<?php endforeach; ?>	
														<?php endif; ?>
													</ul>
													<form action="" method="post" id="standardForm" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="standard">
														<?php if(!empty($service_details['price_per_type'])): ?>
															<ul>
																<li>
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<p class="text-left">
																		Price is based on 
																		<?php echo lcfirst($service_details['price_per_type']); ?>.
																	</p>
																</li>
															</ul>

															<div class="row text-left mb-3">
																<div class="col-md-8">
																	<p>
																		Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																	</p>
																</div>
																<div class="col-md-4">
																	<input type="number" class="form-control qty_of_type" name="qty_of_type" id="qty_of_type_standard" min="1" value="1">
																</div>
															</div>
														<?php else:?>
															<input type="hidden" name="qty_of_type" id="qty_of_type_stndard" value="1">
														<?php endif;?>
														
														<input type="hidden" name="main_price" class="main_price" id="main_price_standard" value="<?php echo isset($package_data) ? $package_data->standard->price : 0;?>"> 
														
														<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderStandardBtn" data-package="standard" value="Buy Now (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?>)">
													</form>
												</div>

												<div class="tab-pane" id="Premium">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?>
													</h2>
													<p><?php echo isset($package_data) ? $package_data->premium->description : '';?></p>
													<!--<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->premium->days; ?>-day delivery
													</h4>-->
													<ul>
														<?php if(!empty($attributes)): ?>
															<?php foreach($attributes as $att):?>
																<?php
																$pchecked = !empty($premiumAtt) && in_array($att['id'], $premiumAtt) ? 'check' : 'times';
																?>
																<?php if(in_array($att['id'], $premiumAtt)):?>
																	<li>
																		<i class="fa fa-<?php echo $pchecked; ?>" aria-hidden="true"></i>
																		<span>
																			<?php echo $att['attribute_name']; ?>
																		</span>
																	</li>
																<?php endif; ?>		
															<?php endforeach; ?>	
														<?php endif; ?>
													</ul>
													<form action="" method="post" id="premiumForm" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="premium">
														<?php if(!empty($service_details['price_per_type'])): ?>
															<ul>
																<li>
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<p class="text-left">
																		Price is based on 
																		<?php echo lcfirst($service_details['price_per_type']); ?>.
																	</p>
																</li>
															</ul>
															<div class="row text-left mb-3">
																<div class="col-md-8">
																	<p>
																		Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																	</p>
																</div>
																<div class="col-md-4">
																	<input type="number" class="form-control qty_of_type" name="qty_of_type" id="qty_of_type_premium" min="1" value="1">
																</div>
															</div>
														<?php else: ?>
															<input type="hidden" name="qty_of_type" id="qty_of_type_premium" value="1">
														<?php endif; ?>
														
														<input type="hidden" name="main_price" class="main_price" id="main_price_premium" value="<?php echo isset($package_data) ? $package_data->premium->price : 0;?>"> 
														
														<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderPremiumBtn" data-package="premium" value="Buy Now (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?>)">
													</form>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if($service_details['package_type'] == 0):?>
										<h2 class="title">
											<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
										</h2>
										<p><?php echo isset($package_data) ? $package_data->basic->description : '';?></p>
										<!--<h4><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->basic->days; ?>-day delivery</h4>-->
										<ul>
											<?php if(!empty($attributes)): ?>
												<?php foreach($attributes as $att):?>
													<?php
													$bchecked = !empty($basicAtt) && in_array($att['id'], $basicAtt) ? 'check' : 'times';
													$schecked = !empty($standardAtt) && in_array($att['id'], $standardAtt) ? 'check' : 'times';
													$pchecked = !empty($premiumAtt) && in_array($att['id'], $premiumAtt) ? 'check' : 'times';
													?>
													<li>
														<i class="fa fa-<?php echo $bchecked; ?>" aria-hidden="true"></i> 
														<span>
															<?php echo $att['attribute_name']; ?>
														</span>
													</li>												
												<?php endforeach; ?>	
											<?php endif; ?>
										</ul>

										<form action="" method="post" id="basicForm" style="margin-top:0">
											<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
											<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
											<input type="hidden" name="package_type" value="basic">

											<?php if(!empty($service_details['price_per_type'])):?>
												<ul>
													<li>
														<i class="fa fa-check" aria-hidden="true"></i>
														<p class="text-left">
															Price is based on 
															<?php echo lcfirst($service_details['price_per_type']); ?>.
														</p>
													</li>
												</ul>

												<div class="row text-left mb-3">
													<div class="col-md-8">
														<p>
															Number of <?php echo lcfirst($service_details['price_per_type']); ?>
														</p>
													</div>
													<div class="col-md-4">
														<input type="number" class="form-control qty_of_type" name="qty_of_type" id="qty_of_type_basic" min="1" value="1">
													</div>
												</div>
											<?php else: ?>
												<input type="hidden" name="qty_of_type" id="qty_of_type_basic" value="1">
											<?php endif; ?>	
											
											<input type="hidden" name="main_price" class="main_price" id="main_price_basic" value="<?php echo isset($package_data) ? $package_data->basic->price : 0;?>">
											
											<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderBasicBtn" data-package="basic" value="Buy Now (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>)">
										</form>
									<?php endif; ?>
								</div>

								<div class="about-this-sidebar">
									<div class="row">
										<div class="col-sm-4 text-center no-padding">
											<div class="icon-container">
												<i class="fa fa-paper-plane" aria-hidden="true"></i>
											</div>
											<div class="label-container">Delivery in</div>
											<div class="value-container"><b id="delivery_in_days"><?php echo $package_data->basic->days; ?> days</b></div>
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
												<div class="widget-star-item ">
													<a class="action-entity-star save fa fa-heart" href="javascript:void(0)" id="serviceLike" data-id="<?php echo $service_details['id']; ?>" style="color:<?php echo $service_details['is_liked'] == 1 ? '#ff0000' : '#c6c7ca'; ?>">
													</a>
													<span class="count-stars totalLikes"><?php echo $service_details['total_likes']; ?></span>
												</div>
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
														<a class="crop member-short-name" rel="nofollow" title="<?php echo $suserName;?>" href="<?php echo base_url('profile/'.$service_user['id']); ?>">
															<?php echo $suserName;?>
														</a>
													</h5>
													<div class="member-job-title crop">
														<?php echo $service_user['trading_name'];?>
													</div>
												</div>
											</div>
										</div>
										<div class="about member-summary-section clearfix" style="border:1px solid #e1e1e1; padding:.625rem">
											<div class="about-container js-about-container" id="aboutUsText" style="border:0; padding:0">
												<p>
													<?php echo substr($service_user['about_business'], 0, 215);?>
												</p>
											</div>
											<p class="text-primary mb-0" style="margin-top: 6px; cursor: pointer;" id="readMoreAboutUs">
												Read More
											</p>
											<p class="text-primary mb-0" style="margin-top: 6px; display:none; cursor: pointer;" id="readLessAboutUs">
												Read Less
											</p>
										</div>
										<div class="location member-summary-section clearfix mt-3">
											<div class="location-container crop">
												<i class="fa fa-map-marker"></i>
												<?php //echo $service_user['city'];?>
												<?php echo !empty($service_details['area']) ? $service_details['area'].', ' : ''; ?>
												<?php echo $service_details['city_name']; ?>
											</div>
										</div>
										<div class="contact member-summary-section clearfix mt-3">
											<a class="btn btn-warning contact-button" id="contactBtn" rel="nofollow" href="javascript:void(0)">Contact</a>
										</div>
									</div>
								</div>

								<div class="rating">
									<ul>
										<li>
											<p>Overall Rating</p>
											<div class="star"><span></span> <?php echo number_format($overallRating,1); ?></div>
										</li>
										<li>
											<p>Seller communication level</p>
											<div class="star">
												<span></span> 
												<?php echo number_format($sellerCommunication[0]['average_rating'],1); ?>
											</div>
										</li>
										<li>
											<p>Recommend to a friend</p>
											<div class="star">
												<span></span> 
												<?php echo $referalRating; ?>
											</div>
										</li>
										<li>
											<p>Service as described</p>
											<div class="star">
												<span></span> 
												<?php echo number_format($serviceAsDescribed,1); ?>
											</div>
										</li>
									</ul>
								</div>

								<div class="about-this-sidebar">
									<div class="member-summary">
										<div class="about member-summary-section clearfix">
											<h4><b>How it works</b></h4>
											<div class="about-container js-about-container" style="background: #F1F1F1;">
												<div id="howItWorkText">
													<p style="margin-top: 10px;">
														Our platform operates much like purchasing a product on Amazon or eBay. Services or gigs are prelisted with comprehensive details, outlining exactly what the seller will provide and what is excluded.
													</p>
												</div>	
												<p class="text-primary" style="margin-top: 6px; cursor: pointer;" id="readMoreHowItWork">
													Read More
												</p>
												<p class="text-primary" style="margin-top: 6px; display:none; cursor: pointer;" id="readLessHowItWork">
													Read Less
												</p>
											</div>
										</div>										
									</div>
								</div>

								<?php if(count($similar_service) > 0):?>
									<div class="tradesmen-box">
										<div class="tradesmen-top" style="border-bottom:0">
											<p><b>Similar Services</b></p>
											<?php $i=1;?>
											<?php foreach($similar_service as $key => $list): ?>
												<?php 
													$package_data = json_decode($list['package_data'],true);
													$servicePrice = $package_data['basic']['price'];				
												?>										
												<div class="pull-left <?php echo $i != count($similar_service) ? 'similar-service' : ''?>">
													<div class="img-name">
														<a href="<?php echo base_url('service/'.$list['slug']); ?>">
															<?php $image_path = FCPATH . 'img/services/' . ($list['image'] ?? ''); ?>
															<?php if (file_exists($image_path) && $list['image']): ?>
																<?php
													                $mime_type = get_mime_by_extension($image_path);
													                $is_image = strpos($mime_type, 'image') !== false;
													                $is_video = strpos($mime_type, 'video') !== false;
													            ?>
													            <?php if ($is_image): ?>
																	<img src="<?php echo  base_url().'img/services/'.$list['image']; ?>" style="border-radius: 0!important;">
																<?php elseif ($is_video): ?>
																	<video src="<?php echo base_url('img/services/') . $list['image']; ?>" 
																	type="<?php echo $mime_type; ?>" loop controls class="profileServiceVideo">
																	</video>
																<?php endif; ?>
															<?php else: ?>
															<img src="<?php echo  base_url().'img/default-image.jpg'; ?>" style="border-radius: 0!important;">
															<?php endif; ?>
														</a>
														<div class="names">
															<a href="<?php echo base_url().'service/'.$list['slug']?>">
																<p class="mb-0">
																	<?php
																		$totalChr = strlen($list['description']);
																		if($totalChr > 50 ){
																			echo substr($list['description'], 0, 50).'...';		
																		}else{
																			echo $list['description'];
																		}
																	?>
																	<span class="badge bg-green">
																		<?php echo '£'.number_format($servicePrice,2); ?>
																	</span>
																</p>
															</a>
															
															<a class="text-muted" href="<?php echo base_url('profile/'.$list['user_id']); ?>">
																<?php echo $list['trading_name'];?>
															</a>
														</div>
													</div>
												</div>	
												<?php $i++;?>										
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>	



								<!-- <div class="order-hourlie-addons-sidebar hide" id="sellerAvailability">
									<h2 class="title">Availability Of Seller</h2>
									<div id="datepicker1"></div>
									<input type="hidden" name="selected_dates" id="selectedDates">
									<div class="mt-4">
										<select class="form-control input-md" name="time_slot" id="timeSlot">
										    <option value="">Select time slot from</option>
										    <?php for ($hour = 0; $hour <= 23; $hour++) {
										        $hour_padded = sprintf("%02d", $hour);  // Pad the hour to two digits
										        echo "<option value=\"{$hour_padded}:00\">{$hour_padded}:00</option>\n";  // Display in 24-hour format
										    }?>
										</select>
									</div>
									<div style="padding: 10px 0;">
										<span>
											Lorem Ipsum is simply dummy text of the printing and typesetting industry.
										</span>
									</div>
									<div id="notAvailablMsg" style="border-top:1px solid #b0c0d3; padding: 10px 0; display: none;">
									</div>
									<input type="hidden" id="packageType">
									<input class="btn btn-warning btn-lg col-md-12" type="button" id="openChat" value="Select & Continue">
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Social Media Modal -->
	<div class="modal fade" id="ShareThis" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				<div class="modal-body">
					<h3 class="sharing-title">Share This Service</h3>
					<div class="sharing-description">
						<p>Spread the word about this Service</p>
					</div>
					<div class="social-mediums-icons">
							<div class="social-medium">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url().'service/'.$service_details['slug']?>" target="_blank" onclick="window.open(this.href, '_blank', 'width=600,height=400'); return false;">
									<div>
										<svg class="social-medium-image" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><defs><circle id="path-1" cx="28" cy="28" r="28"></circle></defs><g fill="none" fill-rule="evenodd"><g transform="translate(-187 -369)"><g transform="translate(120 189)"><g transform="translate(54 180)"><g transform="translate(13)"><use fill="#3E5A99" xlink:href="#path-1"></use><use class="image-filter" fill-opacity="0.2" fill="#000" xlink:href="#path-1"></use><path d="M36.0548085,23.6101303 L31.1603782,23.6101303 L31.1603782,20.6914819 C31.1603782,19.5844084 31.9761166,19.2824792 32.485953,19.2824792 L35.9528412,19.2824792 L35.9528412,14.4516129 L31.1603782,14.4516129 C25.8580786,14.4516129 24.7364383,18.0747626 24.7364383,20.3895528 L24.7364383,23.6101303 L21.6774194,23.6101303 L21.6774194,28.6422827 L24.7364383,28.6422827 L24.7364383,42.7323095 L31.1603782,42.7323095 L31.1603782,28.6422827 L35.4430047,28.6422827 L36.0548085,23.6101303 Z" fill="#FFF"></path></g></g></g></g></g></svg>
									</div>
									<span class="social-medium-title">Facebook</span>
								</a>
							</div>
							<div class="social-medium">
								<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url().'service/'.$service_details['slug']?>" target="_blank" onclick="window.open(this.href, '_blank', 'width=600,height=400'); return false;">
									<div>
										<svg class="social-medium-image" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><circle id="path-1" cx="28" cy="28" r="28"></circle></defs><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-373.000000, -369.000000)"><g transform="translate(120.000000, 189.000000)"><g transform="translate(54.000000, 180.000000)"><g transform="translate(199.000000, 0.000000)"><use fill="#0677B5" xlink:href="#path-1"></use><use class="image-filter" fill-opacity="0.1" fill="#000000" xlink:href="#path-1"></use><g transform="translate(14.451613, 14.451613)" fill="#FFFFFF"><polygon id="Fill-3" points="0.341578453 27.0700924 6.14841215 27.0700924 6.14841215 8.79564516 0.341578453 8.79564516"></polygon><path d="M3.24482451,6.31920138 C1.28074841,6.31920138 -0.000170789226,4.95288757 -0.000170789226,3.15960069 C-0.000170789226,1.36631381 1.28074841,-3.55271368e-15 3.24482451,-3.55271368e-15 C5.20890062,-3.55271368e-15 6.4044252,1.36631381 6.48981981,3.15960069 C6.57521443,4.86749295 5.29429523,6.31920138 3.24482451,6.31920138" id="Fill-5"></path><path d="M27.0702632,26.9848686 L21.2634295,26.9848686 L21.2634295,17.2498827 C21.2634295,14.7734389 20.4094833,13.1509412 18.3600126,13.1509412 C16.736661,13.1509412 15.7981742,14.2610712 15.3712012,15.3703472 C15.2004119,15.7973203 15.2004119,16.3105419 15.2004119,16.8229096 L15.2004119,26.9848686 L9.39357824,26.9848686 C9.39357824,26.9848686 9.47811891,10.5037082 9.39357824,8.71042134 L15.2004119,8.71042134 L15.2004119,11.2722597 C15.9689635,9.99134053 17.3352773,8.28344827 20.4094833,8.28344827 C24.2522409,8.28344827 27.0702632,10.9306813 27.0702632,16.4813311 L27.0702632,26.9848686 Z" id="Fill-6"></path></g></g></g></g></g></g></svg>
									</div>
									<span class="social-medium-title">LinkedIn</span>
								</a>
							</div>
							<div class="social-medium">
								<a href="https://twitter.com/intent/tweet?url=<?php echo base_url().'service/'.$service_details['slug']?>&text=Check%20this%20out!" target="_blank" onclick="window.open(this.href, '_blank', 'width=600,height=400'); return false;">
									<div>
										<svg class="social-medium-image" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><defs><circle id="path-1" cx="28" cy="28" r="28"></circle></defs><g fill="none" fill-rule="evenodd"><g transform="translate(-280 -369)"><g transform="translate(120 189)"><g transform="translate(54 180)"><g transform="translate(106)"><use fill="#60A9DD" xlink:href="#path-1"></use><use class="image-filter" fill-opacity="0.2" fill="#000" xlink:href="#path-1"></use><path d="M42.1262216,19.1290952 C41.1407756,19.6357476 39.9910886,19.9735159 38.8414016,20.057958 C39.9910886,19.2979793 40.8944141,18.1157902 41.3050166,16.6802749 C40.2374501,17.3558115 39.0056426,17.862464 37.6917146,18.2002323 C36.6241481,17.0180432 35.1459791,16.2580645 33.5035691,16.2580645 C30.38299,16.2580645 27.8372545,18.960211 27.8372545,22.3378941 C27.8372545,22.8445466 27.919375,23.266757 28.0014955,23.6889674 C23.2385065,23.4356411 19.0503609,20.9868209 16.2582639,17.3558115 C15.7655409,18.2846744 15.5191794,19.2979793 15.5191794,20.3957263 C15.5191794,22.5067783 16.5046254,24.364504 18.0649149,25.462251 C17.1615894,25.462251 16.2582639,25.1244827 15.5191794,24.7022723 L15.5191794,24.7867144 C15.5191794,27.7421871 17.4900714,30.1918518 20.1179274,30.7821019 C19.6252044,30.950986 19.1324814,31.0362725 18.6397584,31.0362725 C18.3112764,31.0362725 17.9006739,31.0362725 17.5721919,30.950986 C18.3112764,33.3998063 20.364289,35.1730899 22.9100245,35.1730899 C20.9391325,36.7774894 18.4755174,37.7916388 15.8476614,37.7916388 C15.3549384,37.7916388 14.9443359,37.7916388 14.4516129,37.7063523 C16.9973484,39.3951938 19.9536864,40.4084988 23.156386,40.4084988 C33.6678101,40.4084988 39.3341246,31.1198702 39.3341246,23.0978728 L39.3341246,22.3378941 C40.4016911,21.4090313 41.3871371,20.3957263 42.1262216,19.1290952" fill="#FFF"></path></g></g></g></g></g></svg>
									</div>
									<span class="social-medium-title">Twitter</span>
								</a>
							</div>
							<div class="social-medium">
								<a href="https://api.whatsapp.com/send?text=Check%20this%20out!%20<?php echo base_url().'service/'.$service_details['slug']?>" target="_blank" onclick="window.open(this.href, '_blank', 'width=600,height=400'); return false;">
									<div>
										<svg class="social-medium-image" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><defs><circle id="path-1" cx="28" cy="28" r="28"></circle></defs><g fill="none" fill-rule="evenodd"><g transform="translate(-466 -369)"><g transform="translate(120 189)"><g transform="translate(54 180)"><g id="Whatsapp-hover" transform="translate(292)"><use fill="#0D9F16" xlink:href="#path-1"></use><use class="image-filter" fill-opacity="0.2" fill="#000" xlink:href="#path-1"></use><g transform="translate(13 12)"><path d="M17.642644,28.0096291 C16.9446524,28.1278206 16.2430562,28.1906038 15.8734156,28.182968 C13.1552465,28.1749406 10.9390414,27.5685806 8.90103721,26.3405891 C8.64032262,26.1829785 8.41277082,26.1434291 8.10827611,26.2224627 C6.73831205,26.6002059 5.35851712,26.9388564 3.98645581,27.3009364 C3.69782156,27.3876059 3.67029514,27.3246922 3.74356786,27.0646838 C4.10711332,25.7656859 4.44922748,24.4743891 4.82496321,23.1907933 C4.92943256,22.8287133 4.8921408,22.5530417 4.68444736,22.2300543 C1.86547907,17.7184122 1.98410486,12.0965133 5.13909218,7.92306484 C8.41676871,3.57673432 12.8726419,1.79720379 18.2041831,2.93089011 C23.4583882,4.03351116 26.8073712,7.41107537 28.0389167,12.6161385 C29.7211091,19.7341954 24.8697074,26.8127027 17.642644,28.0096291 M30.5651873,11.8836248 C28.8668723,4.86803116 22.8061429,0.0826101053 15.4799188,-1.30526316e-05 C14.5151175,0.0157153684 13.5050288,0.0942922105 12.5066715,0.303134316 C2.28650233,2.36401432 -3.00938562,13.6474269 1.97230782,22.7577722 C2.1006334,23.0017259 2.11079197,23.1988206 2.03955095,23.4508017 C1.37721268,25.8523554 0.720904017,28.2539091 0.060597463,30.6474354 C-0.0462312896,31.0412985 -0.0462312896,31.0412985 0.349297252,30.9389659 C2.85007315,30.2854206 5.34678562,29.6395764 7.84559535,28.9783954 C8.05283002,28.9231827 8.2151704,28.9465469 8.40464397,29.0413091 C11.6232698,30.6788922 15.0135425,31.1594901 18.5636651,30.4745533 C27.0461958,28.8365133 32.5894939,20.2457933 30.5651873,11.8836248" fill="#FCFCFC"></path><path d="M19.5243964,22.7735333 C18.9730159,22.7972891 18.44713,22.6711354 17.9191469,22.5292533 C14.3709905,21.513628 11.7082674,19.3012069 9.56900529,16.3875985 C8.7605148,15.2930701 8.01153383,14.1593838 7.76255074,12.7971459 C7.46382347,11.1591712 7.93629493,9.77356905 9.16010677,8.63949116 C9.54960571,8.28511221 10.7354049,8.12789326 11.209908,8.35605326 C11.3860116,8.442788 11.4986078,8.60039853 11.571815,8.76564484 C12.0204302,9.82878168 12.4633436,10.8757333 12.9021934,11.9388701 C12.9852315,12.1436659 12.9495782,12.3404343 12.8568404,12.5451648 C12.6313203,13.0333985 12.2694133,13.4268701 11.9018044,13.8127059 C11.6232632,14.0965354 11.6111385,14.3561522 11.8167347,14.6948027 C13.0701702,16.7734343 14.8038108,18.2852554 17.0713985,19.1907164 C17.4094493,19.3245712 17.6645275,19.2773859 17.8895888,18.9940133 C18.2673562,18.5295354 18.666555,18.0647312 19.0243985,17.5845901 C19.2693182,17.2459396 19.5503499,17.1987543 19.8960687,17.3559733 C20.6454429,17.6946238 21.3944239,18.0490027 22.1437981,18.4033817 C22.3118404,18.4743227 22.4777854,18.5609922 22.6438615,18.6396343 C23.4029355,19.0177691 23.3952674,19.0254048 23.3299905,19.8599248 C23.2033034,21.4898722 21.9757558,22.2933922 20.520722,22.6948912 C20.2004979,22.7811691 19.8604154,22.7892617 19.5243964,22.7735333" fill="#FDFDFD"></path></g></g></g></g></g></g></svg>
									</div>
									<span class="social-medium-title">WhatsApp</span>
								</a>
							</div>
							<div class="social-medium">
								<a href="javascript:void(0)" onclick="copyToClipboard(); return false;">
									<div>
										<svg class="social-medium-image" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><defs><circle id="path-1" cx="28" cy="28" r="28"></circle></defs><g fill="none" fill-rule="evenodd"><g transform="translate(-373 -556)"><g transform="translate(120 189)"><g transform="translate(54 260)"><g transform="translate(199 107)"><g class="circle-wrapper" fill="#FFF" stroke="#CCC"><circle class="background-circle" cx="28" cy="28" r="27.5" fill-opacity="0" fill="#000"></circle></g><path class="inner-image" d="M28.121892,24.7230821 C28.7203205,24.1246416 29.6823291,24.1176829 30.2824972,24.7161235 C30.8757068,25.3093451 30.8861445,26.2644145 30.2737991,26.8750326 L25.8795248,31.2711352 C25.2810963,31.8695757 24.3190877,31.8765344 23.7206592,31.2780938 C23.1257099,30.6831325 23.1152722,29.7298028 23.7276177,29.117445 L28.121892,24.7230821 Z M32.3996119,31.2085077 L30.2477048,29.0565572 L35.7014063,23.6010061 C36.2006766,23.1017257 35.9188585,21.6125829 34.6524169,20.3461157 C33.3946732,19.0883468 31.8916436,18.801304 31.402811,19.2901465 L25.942151,24.7509166 L23.7902439,22.5972264 L29.2491643,17.138196 C31.1766607,15.2106607 34.5341228,15.8508529 36.8408559,18.1593722 C39.1562871,20.47485 39.7877683,23.8202023 37.855053,25.7546962 L32.3996119,31.2085077 Z M28.0557865,31.24678 L30.2076936,33.4004702 L24.7539921,38.8542817 C22.8212768,40.7887756 19.4742524,40.1555419 17.1588212,37.8400641 C14.8520881,35.5332845 14.2101692,32.1774943 16.1376656,30.249959 L21.5983256,24.7891889 L23.7502327,26.9428791 L18.2895727,32.4036491 C17.8007401,32.8924916 18.0877771,34.3955516 19.3455207,35.6533205 C20.6119624,36.9197878 22.1028147,37.2016115 22.602085,36.7023312 L28.0557865,31.24678 Z" fill="#999"></path></g></g></g></g></g></svg>
									</div>
									<span class="social-medium-title copyTitle">Copy Link</span>
								</a>
							</div>
						

					</div>
				</div>
				
			</div>
		</div>
	</div>

	<!-- Social Media Modal -->
	<div class="modal fade" id="sellerAvailabilityModal" tabindex="-1" role="dialog" aria-labelledby="sellerAvailabilityTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="modal-body">
					<h3 class="sharing-title">Availability Of Seller</h3>
					<div class="sharing-description">
						<p>Choose your date & time</p>
					</div>

					<div class="order-hourlie-addons-sidebar p-0" id="sellerAvailability">
					<div id="datepickerAvailability"></div>
					<input type="hidden" name="selected_dates" id="selectedDates">
					<div class="mt-4">
						<!-- <select class="form-control input-md" name="time_slot" id="timeSlot">
							<option value="">Select time slot from</option>
							<?php for ($hour = 0; $hour <= 23; $hour++) {
								$hour_padded = sprintf("%02d", $hour % 12 == 0 ? 12 : $hour % 12);
								$ampm = $hour < 12 ? 'am' : 'pm';
								echo "<option value=\"$hour_padded:00 $ampm\">$hour_padded:00 $ampm</option>\n";
							}?>
						</select> -->

						<select class="form-control input-md" name="time_slot" id="timeSlot">
						    <option value="">Select time slot from</option>
						    <?php for ($hour = 0; $hour <= 23; $hour++) {
						        $hour_padded = sprintf("%02d", $hour);  // Pad the hour to two digits
						        echo "<option value=\"{$hour_padded}:00\">{$hour_padded}:00</option>\n";  // Display in 24-hour format
						    }?>
						</select>
					</div>												
					<!--<div style="padding: 10px 0;">
						<span>
							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						</span>
					</div>-->
					<div id="notAvailablMsg" style="border-top:1px solid #b0c0d3; padding: 10px 0; display: none;">
					</div>
					<input type="hidden" id="packageType">
					<input class="btn btn-warning btn-lg col-md-12 mt-4" type="button" id="openChat" value="Select & Continue">
					</div>
				</div>											
			</div>
		</div>
	</div>
	
	

	<?php if(!empty($browse_history)): ?>
		<div class="container mt-5" id="browseHistory">
			<h2 class="title">
				Your Browsing History
			</h2>
			<div class="row">
				<?php
				$data['all_services'] = $browse_history;
				$this->load->view('site/service_list',$data);
				?>
			</div>
		</div>
	<?php endif; ?>

	<?php if(!empty($people_history)): ?>
		<div class="container" id="peopleHistory">
			<h2 class="title">
				People Who Viewed This Service Also Viewed
			</h2>
			<div class="row">
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
		$('.main_price').each(function() {
			var totalPrice = 0;
			let selectedIds = [];

			var mainPriceInput = $(this);
			var packageType = mainPriceInput.attr('id').replace('main_price_', '');

			var orderBtn = $('#order' + capitalizeFirstLetter(packageType) + 'Btn');
			var qtyInput = $('#qty_of_type_' + packageType);

			var servicePrice = parseFloat(mainPriceInput.val());

			var qty = qtyInput.val();
			if (qty != "" && qty > 0) {
				var mainPrice = servicePrice * qty;
			} else {
				var mainPrice = servicePrice;
			}

			$('.order-hourlie-addons .checkbox-effect:checked').each(function() {
				var price = $(this).attr('data-price');
				totalPrice += parseFloat(price);
				selectedIds.push($(this).data('id'));
			});

			var newPrice = parseFloat(mainPrice) + parseFloat(totalPrice);
			var priceText = 'Buy Now (£' + newPrice.toFixed(2) + ')';
			orderBtn.val(priceText);
			mainPriceInput.closest('form').find('.selected_exsIds').val(selectedIds.join(','));	        
		});
	}

	function capitalizeFirstLetter(string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	// document.getElementsByClassName('qty_of_type').addEventListener('input', function() {
	// 	countPrice(this.value);
	// });

	$('.qty_of_type').on('input', function() {
		countPrice(this.value);
	});

	// document.getElementById('qty_of_type').addEventListener('change', function() {
	// 	countPrice(this.value);
	// });

	function countPrice(qty){
		updateTotalPrice();
	};

	$(document).ready(function() {
		$('.orderBtn').click(function(e) {
	        e.preventDefault(); // Prevent the default button click behavior

	        var packageType = $(this).data('package'); // Get the package type from the data attribute

	        $('#packageType').val(packageType);
	        $('#sellerAvailabilityModal').modal('show');

	        //return false;

	        /*var form = $(this).closest('form'); // Find the closest form element

	        // Validate and serialize the form data
	        var formData = form.serialize();

	        // Submit the form using AJAX
	        $.ajax({
	        	url: "<?= site_url().'checkout/addToCart'; ?>", 
	        	data: formData, 
	        	type: "POST", 
	        	dataType: 'json',
	        	success: function (data) {
	        		if (data.status == 1) {
	        			window.location.href = '<?php echo base_url().'serviceCheckout'; ?>';
	        		} else if (data.status == 2) {
	        			swal({
	        				title: "Login Required!",
	        				text: "If you want to order the please login first!",
	        				type: "warning"
	        			}, function() {
	        				window.location.href = '<?php echo base_url().'login'; ?>';
	        			});        
	        		} else {
	        			alert('Something is wrong. Please try again!!!');
	        		}            
	        	},
	        	error: function(e) {
	        		console.log(JSON.stringify(e));
	        	}
	        });*/
	    });
	});

	/*$("#serviceOrder").submit(function(){
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
	});*/

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

    $('#timeSlotTo').on('change', function() {
        updateAvailabilityMessage(); // Call formatSentence when time slot changes
    });

	$('#openChat').on('click', function(){
		$('#checkoutBtn').disabled = true;
		var selectedDates = $('#selectedDates').val();
		var timeSlot = $('#timeSlot').val();
		var timeSlotTo = $('#timeSlotTo').val();
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
			var formId = $('#packageType').val();
	        var formType = formId+'Form';

	        var formData = $('#'+formType).serialize();
			formData += '&date=' + encodeURIComponent($('#selectedDates').val());
			formData += '&time=' + encodeURIComponent($('#timeSlot').val());

	        // Submit the form using AJAX
	        $.ajax({
	        	url: "<?= site_url().'checkout/addToCart'; ?>", 
	        	data: formData, 
	        	type: "POST", 
	        	dataType: 'json',
	        	success: function (data) {
	        		if (data.status == 1) {
	        			window.location.href = '<?php echo base_url().'serviceCheckout'; ?>';
	        		} else if (data.status == 2) {
	        			swal({
	        				title: "Login Required!",
	        				text: "If you want to order the please login first!",
	        				type: "warning"
	        			}, function() {
	        				window.location.href = '<?php echo base_url().'login'; ?>';
	        			});        
	        		} else {
	        			alert('Something is wrong. Please try again!!!');
	        		}            
	        	},
	        	error: function(e) {
	        		console.log(JSON.stringify(e));
	        	}
	        });

			/*swal({
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
			});*/
		}
	});

	$('#contactBtn').on('click', function(){
		get_chat_onclick(<?php echo $service_details['user_id'];?>, <?php echo $service_details['id'];?>);
		showdiv();
	});

	$(document).ready(function() {
		var $comparePackage = $("#comparePackage");
		var $browseHistory = $("#browseHistory");
		var $peopleHistory = $("#peopleHistory");
		var $footer = $("#footer");

		if ($browseHistory.length) {
			var $footerOffsetTop = $("#browseHistory").offset().top; 
		}else if ($peopleHistory.length) {
			var $footerOffsetTop = $("#peopleHistory").offset().top; 
		}else{
			var $footerOffsetTop = $("#footer").offset().top; 
		}

		var $window = $(window);  
		var $sidebar = $(".sidebar-main"); 
		var $sidebarHeight = $sidebar.innerHeight();
		var $sidebarOffset = $sidebar.offset();
		var $sidebarwidth = $("#sidebar").width();

		$window.scroll(function() {
			if($window.scrollTop() > $sidebarOffset.top) {
				$sidebar.addClass("fixed");
				$sidebar.css('width', $sidebarwidth); 
			} else {
				$sidebar.removeClass("fixed");
				$sidebar.css('width', '100%');   
			}    
			if($window.scrollTop() + $sidebarHeight > $footerOffsetTop) {
				$sidebar.css({"top" : -($window.scrollTop() + $sidebarHeight - $footerOffsetTop)});        
			} else {
				$sidebar.css({"top": "0"});  
			}    
		});   
	});

	$('.save').on('click', function (){
	    var sId = $(this).data('id');
	    $.ajax({
	    	type:'POST',
	      	url:site_url+'users/updateWishlist',
	      	data:{sId:sId},
	      	dataType: 'json',
	      	success:function(response){
		      	if(response.status == 0){
		      		swal({
			            title: "Login Required!",
			            text: "If you want to add this service into your wishlist then please login first!",
			            type: "warning"
			        }, function() {
			            window.location.href = '<?php echo base_url().'login'; ?>';
			        });
		      	}else{
		      		if(response.status == 1){
			          $('#serId_'+sId).attr('fill', '#ff0000');
			          $('#serviceLike').css('color','#ff0000');
			        }else{
			          $('#serId_'+sId).attr('fill', '#b5b6ba');
			          $('#serviceLike').css('color','#c6c7ca');
			        }
			        $('.totalLikes').text(response.totalLikes);
		      	}
	      	}
	    });
	});

	function copyToClipboard() {
	    var link = "<?php echo base_url().'service/'.$service_details['slug']; ?>";
	    navigator.clipboard.writeText(link).then(function() {
	        $('.copyTitle').text('Link copied');	        
	    }).catch(function(err) {
	        console.error("Failed to copy: ", err);
	    });

	    setTimeout(function() {
            $('#ShareThis').modal('hide');
        }, 2000);
	}
	
	$('#readMoreHowItWork').on('click', function(){
		var howToWork = '<p style="margin-top: 10px;">Our platform operates much like purchasing a product on Amazon or eBay. Services or gigs are prelisted with comprehensive details, outlining exactly what the seller will provide and what is excluded.</p><p style="margin-top: 10px;">The process is straightforward: simply click the buy button, select the desired date and time for the service, make your payment, and submit any necessary details. Your payment is securely held in escrow until the job is completed.</p><p style="margin-top: 10px;">Once the task is finished and you are completely satisfied with the results, you can release the payment to the professional by accepting the delivery.</p>';					   
		$('#howItWorkText').empty().html(howToWork);
		$(this).hide();
		$('#readLessHowItWork').show();
	});
	
	$('#readLessHowItWork').on('click', function(){
		var howToWork = '<p style="margin-top: 10px;">Our platform operates much like purchasing a product on Amazon or eBay. Services or gigs are prelisted with comprehensive details, outlining exactly what the seller will provide and what is excluded.</p>';					   
		$('#howItWorkText').empty().html(howToWork);
		$(this).hide();
		$('#readMoreHowItWork').show();
	});
	
	$('#readMoreAboutUs').on('click', function(){
		var aboutUs = `<?php echo $service_user['about_business'];?>`;
		console.log(aboutUs);
		$('#aboutUsText').empty().html(aboutUs);
		$(this).hide();
		$('#readLessAboutUs').show();
	});
	
	$('#readLessAboutUs').on('click', function(){
		var aboutUs = `<?php echo substr($service_user['about_business'], 0, 215);?>`;
		console.log(aboutUs);
		$('#aboutUsText').empty().html(aboutUs);
		$(this).hide();
		$('#readMoreAboutUs').show();
	});
	
	$('.packageTypes').on('click', function(){
		var days = $(this).data('days');
		$('#delivery_in_days').text(days+' days');
	});
</script>												