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
									echo $this->common_model->make_all_image($service_details['image'], $service_images);										
									?>
								</div>
								<div class="slider slider-nav">
									<?php
									echo $this->common_model->make_all_image($service_details['image'], $service_images);										
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

							<div class="order-hourlie-addons">
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
							<?php endif; ?>
						</div>

						<div class="col-sm-4">
							<div class="sidebar-main" id="sidebar">
								<div class="service-detail-sidebar">
									<!-- <h2 class="title"><?php echo '£'.number_format($service_details['price'],2); ?></h2>
									<p>15s Social Media Ad in 1 format of your choice: Landscape, Square or Vertical</p> -->

									<div class="sidebar-icons">
										<button class="menu" type="button" data-toggle="tooltip" data-placement="top" title="list">
											<svg fill="#b5b6ba" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
												<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
											</svg>
										</button>
										<div class="">
											<button class="save" type="button" data-toggle="tooltip" data-placement="top" title="Save to list"><svg fill="#b5b6ba" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M14.4469 1.95625C12.7344 0.496875 10.1875 0.759375 8.61561 2.38125L7.99999 3.01562L7.38436 2.38125C5.81561 0.759375 3.26561 0.496875 1.55311 1.95625C-0.409388 3.63125 -0.512513 6.6375 1.24374 8.45312L7.29061 14.6969C7.68124 15.1 8.31561 15.1 8.70624 14.6969L14.7531 8.45312C16.5125 6.6375 16.4094 3.63125 14.4469 1.95625Z"></path></svg></button>
											<span class="collect-count">3,922</span>
										</div>
										<button type="button" class="btn btn-outline" data-toggle="tooltip" data-placement="top" title="Share this Gig">
											<svg width="16" height="16" viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg" fill="currentFill"><path d="M11 10c-.707 0-1.356.244-1.868.653L5.929 8.651a3.017 3.017 0 0 0 0-1.302l3.203-2.002a3 3 0 1 0-1.06-1.696L4.867 5.653a3 3 0 1 0 0 4.694l3.203 2.002A3 3 0 1 0 11 10Z"></path></svg>
										</button>
										<button type="button" class="btn btn-outline" data-toggle="tooltip" data-placement="top" title="Share this Gig">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
												<path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
											</svg>
										</button>
									</div>

									<?php 
									$basicAtt = isset($package_data) ? $package_data->basic->attributes : [];
									$standardAtt = isset($package_data) ? $package_data->standard->attributes : [];
									$premiumAtt = isset($package_data) ? $package_data->premium->attributes : [];
									?>

									<?php if($service_details['package_type'] == 1):?>
										<div class="sidebar-tabs">
											<ul  class="nav nav-pills">
												<li class="active"><a href="#Basic" data-toggle="tab">Basic</a></li>
												<li><a href="#Standard" data-toggle="tab">Standard</a></li>
												<li><a href="#Premium" data-toggle="tab">Premium</a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="Basic">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
													</h2>
													<!-- <p>15s Social Media Ad in 1 format of your choice: Landscape, Square or Vertical</p> -->
													<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->basic->days; ?>-day delivery
													</h4>
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
													<form action="" method="post" id="serviceOrder" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="basic">
														<p class="text-left">
															Price is based on 
															<?php echo lcfirst($service_details['price_per_type']); ?>.
														</p>
														<input type="hidden" name="main_price" class="main_price" id="main_price_basic" value="<?php echo isset($package_data) ? $package_data->basic->price : 0;?>"> 
														<div class="row text-left mb-3">
															<div class="col-md-8">
																<p>
																	Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																</p>
															</div>
															<div class="col-md-4">
																<input type="number" class="form-control" name="qty_of_type" class="qty_of_type" id="qty_of_type_basic" min="1" value="1">
															</div>
														</div>
														<input class="orderBtn btn btn-warning btn-lg " type="submit" id="orderBasicBtn" data-package="basic" value="Order (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>)">
													</form>
												</div>

												<div class="tab-pane" id="Standard">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?>
													</h2>
													<!-- <p>15s Social Media Ad in 1 format of your choice: Landscape, Square or Vertical</p> -->
													<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->standard->days; ?>-day delivery
													</h4>
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
													<form action="" method="post" id="serviceOrder" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="standard">
														<p class="text-left">
															Price is based on 
															<?php echo lcfirst($service_details['price_per_type']); ?>.
														</p>
														<input type="hidden" name="main_price" class="main_price" id="main_price_standard" value="<?php echo isset($package_data) ? $package_data->standard->price : 0;?>"> 
														<div class="row text-left mb-3">
															<div class="col-md-8">
																<p>
																	Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																</p>
															</div>
															<div class="col-md-4">
																<input type="number" class="form-control" name="qty_of_type" class="qty_of_type" id="qty_of_type_stndard" min="1" value="1">
															</div>
														</div>
														<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderStandardBtn" data-package="standard" value="Order (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->standard->price,2)) : '';?>)">
													</form>
												</div>

												<div class="tab-pane" id="Premium">
													<h2 class="title">
														<?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?>
													</h2>
													<!-- <p>15s Social Media Ad in 1 format of your choice: Landscape, Square or Vertical</p> -->
													<h4>
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->premium->days; ?>-day delivery
													</h4>
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
													<form action="" method="post" id="serviceOrder" style="margin-top:0">
														<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
														<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
														<input type="hidden" name="package_type" value="premium">
														<p class="text-left">
															Price is based on 
															<?php echo lcfirst($service_details['price_per_type']); ?>.
														</p>
														<input type="hidden" name="main_price" class="main_price" id="main_price_premium" value="<?php echo isset($package_data) ? $package_data->premium->price : 0;?>"> 
														<div class="row text-left mb-3">
															<div class="col-md-8">
																<p>
																	Number of <?php echo lcfirst($service_details['price_per_type']); ?>
																</p>
															</div>
															<div class="col-md-4">
																<input type="number" class="form-control" name="qty_of_type" class="qty_of_type" id="qty_of_type_premium" min="1" value="1">
															</div>
														</div>
														<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderPremiumBtn" data-package="premium" value="Order (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->premium->price,2)) : '';?>)">
													</form>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if($service_details['package_type'] == 0):?>
										<h2 class="title">
											<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>
										</h2>
										<h4><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $package_data->basic->days; ?>-day delivery</h4>
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

										<form action="" method="post" id="serviceOrder" style="margin-top:0">
											<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_details['id']; ?>">
											<input type="hidden" name="selected_exsIds" class="selected_exsIds" id="selected_exsIds">
											<input type="hidden" name="package_type" value="basic">
											<p class="text-left">
												Price is based on 
												<?php echo lcfirst($service_details['price_per_type']); ?>.
											</p>
											<input type="hidden" name="main_price" class="main_price" id="main_price_basic" value="<?php echo isset($package_data) ? $package_data->basic->price : 0;?>"> 
											<div class="row text-left mb-3">
												<div class="col-md-8">
													<p>
														Number of <?php echo lcfirst($service_details['price_per_type']); ?>
													</p>
												</div>
												<div class="col-md-4">
													<input type="number" class="form-control" name="qty_of_type" id="qty_of_type_basic" class="qty_of_type" min="1" value="1">
												</div>
											</div>
											<input class="orderBtn btn btn-warning btn-lg" type="submit" id="orderBasicBtn" data-package="basic" value="Order (<?php echo isset($package_data) ? '£'.trim(number_format($package_data->basic->price,2)) : '';?>)">
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

											<ul>
												<li><p>seller communication level</p><div class="star"><span></span> 4.9</div></li>
												<li><p>Recommend to a friend</p><div class="star"><span></span> 4.9</div></li>
												<li><p>Service as described</p><div class="star"><span></span> 5.0</div></li>
											</ul>
										</div>

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
								<div id="notAvailablMsg" style="border-top:1px solid #b0c0d3; padding: 10px 0; display: none;">
								</div>
								<input class="btn btn-warning btn-lg col-md-12" type="button" id="openChat" value="Select & Continue">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if(!empty($browse_history)): ?>
	<div class="container" id="browseHistory">
		<div class="row">
			<h2 class="title">
				Your Browsing History
			</h2>
			<?php
			$data['all_services'] = $browse_history;
			$this->load->view('site/service_list',$data);
			?>
		</div>
	</div>
<?php endif; ?>

<?php if(!empty($people_history)): ?>
	<div class="container" id="peopleHistory">
		<div class="row">
			<h2 class="title">
				People Who Viewed This Service Also Viewed
			</h2>
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
		var exPrice =  $(this).attr('data-price');
		var exId =  $(this).attr('data-id');
	    updateTotalPrice(exPrice, exId);
	});

	function updateTotalPrice(exPrice, exId) {
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
	        var priceText = 'Order (£' + newPrice.toFixed(2) + ')';
	        orderBtn.val(priceText);
	        mainPriceInput.closest('form').find('.selected_exsIds').val(selectedIds.join(','));	        
	    });
	}

	function capitalizeFirstLetter(string) {
	    return string.charAt(0).toUpperCase() + string.slice(1);
	}

	// document.getElementById('qty_of_type').addEventListener('input', function() {
	// 	countPrice(this.value);
	// });

	// document.getElementById('qty_of_type').addEventListener('change', function() {
	// 	countPrice(this.value);
	// });

	// function countPrice(qty){
	// 	var price = <?php echo $service_details['price']; ?>;
	// 	var mainPrice = parseFloat(price) * qty;
	// 	updateTotalPrice();
	// };

	$(document).ready(function() {
	    $('.orderBtn').click(function(e) {
	        e.preventDefault(); // Prevent the default button click behavior

	        var packageType = $(this).data('package'); // Get the package type from the data attribute
	        var form = $(this).closest('form'); // Find the closest form element

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
	        });
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

	$(document).ready(function() {
		var $window = $(window);  
		var $sidebar = $(".sidebar-main"); 
		var $sidebarHeight = $sidebar.innerHeight();   
		var $footerOffsetTop = $("#browseHistory").offset().top; 
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

</script>