<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title" id="mainTitle">
    	<?php if($pMethod == 1):?>
    		Create a single payment offer
    	<?php else:?>
    		Create a milestone offer
    	<?php endif;?>
    </h4>
</div>
<form method="POST" name="custom_offer_submit" id="custom_offer_submit" enctype="multipart/form-data">
  <div class="modal-body">
		<h3><?php echo $service['service_name']; ?></h3>
		<p><?php echo $service['description']; ?></p>		
		<input type="hidden" name="service_id" id="service_id" value="<?php echo $service_id; ?>">
		<input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $receiver_id; ?>">
		<input type="hidden" name="order_type" id="orderType" value="<?php echo $pMethod == 1 ? 'single' : 'milestone'; ?>">
		<input type="hidden" name="customOrderId" id="customOrderId" value="<?php echo !empty($custom_order) ? $custom_order['id'] : ''; ?>">
		<input type="hidden" name="milestoneIds" id="milestoneIds" value="<?php echo rtrim($mIds,','); ?>">
		<div class="form-group img-textarea">
			<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
			<?php if (file_exists($image_path) && $service['image']): ?>
				<?php
				$mime_type = get_mime_by_extension($image_path);
				$is_image = strpos($mime_type, 'image') !== false;
				$is_video = strpos($mime_type, 'video') !== false;
				?>
				<?php if ($is_image): ?>
					<img src="<?php echo  base_url().'img/services/'.$service['image']; ?>">
				<?php elseif ($is_video): ?>
					<video src="<?php echo base_url('img/services/') . $service['image']; ?>" 
						type="<?php echo $mime_type; ?>" loop controls class="profileServiceVideo">
					</video>
				<?php else: ?>
					<img src="<?php echo  base_url().'img/default-image.jpg'; ?>">
				<?php endif; ?>
			<?php else: ?>
				<img src="<?php echo  base_url().'img/default-image.jpg'; ?>">
			<?php endif; ?>
			<textarea class="form-control" rows="6" name="description" id="main_description" placeholder="Enter description"></textarea>
			<label class="error" id="description_error"></label>
			</br>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<?php $switch = isset($pMethod) && $pMethod == 2 ? 'Switch to single payment offer' : 'Switch to Miletones'; ?>

					<p>Set up your offer or <a href="javascript:void(0)" onclick="toggleMilestones()" id="toggle-milestones"><?php echo $switch; ?></a></p>
					<p>Define the terms of your offer and what it inclides.</p>
				</div>
			</div>
		</div>

		<?php 
			$milestoneArray = ['1st Milestone'];
			function ordinal($number) {
				$suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
				if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
					return $number . 'th';
				} else {
					return $number . $suffixes[$number % 10];
				}
			}
		?>

		<div class="row milestone_div" style="display: <?php echo isset($pMethod) && $pMethod == 2 ? 'block' : 'none'?>;">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div id="accordion" style="box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.08), 0 2px 4px 0 rgba(0, 0, 0, 0.12);border-radius: 10px;">
							
							<div id="milestoneList">
								<?php echo $milestoneList;?>
							</div>

							<div class="card card-primary" id="milestoneForm">
								<div class="card-header">
									<div class="row">
										<div class="col-md-6">
											<h4 class="w-100">
												<a class="d-block w-100 text-success" data-toggle="collapse" href="#collapse<?php echo count($milestones); ?>">
													<i class="fa fa-plus-circle"></i>
													Add a Milestone
												</a>
											</h4>
										</div>
										<div class="col-md-3 text-right">
											<h4 class="w-100" id="totalDays">
												Total: <?php echo $totalAmtDays[0]['totalDays'] > 0 ? $totalAmtDays[0]['totalDays'] : 0; ?> days
											</h4>
										</div>
										<div class="col-md-3 text-right">
											<h4 class="w-100" id="totalAmounts">
												<?php echo '£'.number_format($totalAmtDays[0]['mAmount'],2)?>
											</h4>
										</div>
									</div>										
								</div>

								<div id="collapse<?php echo count($milestones); ?>" class="<?php if (count($milestones)>0) { ?>collapse<?php } else { ?>in<?php } ?>" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="col-xs-3 col-sm-3">
												<div class="form-group">
													<label id="milestoneNumber">
														<?php echo ordinal(count($milestones) + 1); ?> Milestone Name
													</label>
													<input type="text" class="form-control" name="milestone_name" id="milestone_name" placeholder="Enter Milestone Name">
													<div class="error" id="milestone_name_error"></div>
												</div>
											</div>
											<div class="col-xs-2 col-sm-2">
												<div class="form-group">
													<label>Delivery In</label>
													<input type="number" class="form-control" name="milestone_delivery" id="milestone_delivery" step="1" min="1" pattern="^\d+(\.\d{1,2})?$" placeholder="No. of Days">
													<div class="error" id="milestone_delivery_error"></div>
												</div>
											</div>
											<div class="col-xs-2 col-sm-2">
												<div class="form-group">
													<label>Price</label>
													<input type="number" class="form-control" name="milestone_price" id="milestone_price" step="0.01" pattern="^\d+(\.\d{1,2})?$" placeholder="Enter price">
													<div class="error" id="milestone_price_error"></div>
												</div>
											</div>
											<?php if($service_category['price_type'] == 1):?>
												<div class="col-xs-2 col-sm-2">
							              <label>Charge Per</label>
						                <select class="form-control input-md" name="milestone_price_per_type" id="milestone_price_per_type">
						                    <option value="">Please Select</option>
						                    <?php if(!empty($price_per_type)): ?>
						                        <?php foreach ($price_per_type as $value): ?>
						                            <?php 
						                              $selected = $value == $serviceData['price_per_type'] ? 'selected' : '';
						                            ?>
						                            <option value="<?php echo $value; ?>" <?php echo $selected; ?> >
						                                <?php echo $value; ?>
						                            </option>
						                        <?php endforeach;?>
						                    <?php endif;?>    
						                </select>
						                <div class="error" id="price_per_type_error"></div>
							          </div>
							     		<?php endif; ?>

							     		<div class="col-xs-3 col-sm-3">
												<div class="form-group">
													<label id="milestoneTotalLabel">Total no. of</label>
													<input type="number" class="form-control" name="mQuantity" id="milestoneQty" min="1" step="1" pattern="^\d+(\.\d{1,2})?$" placeholder="Total no. of">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<textarea class="form-control" rows="4" name="milestone_details" id="milestone_details" placeholder="Describe your offer in details (options)"></textarea>
													<div class="error" id="milestone_details_error"></div>
													<p>Adding a description helps set expectations with buyers.</p>
												</div>
												<div class="pull-right">
													<button class="btn btn-success" type="button" id="milestoneSave">Save</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="youll-text">
									<p>You'll get paid for each milestone once it's marked as completed.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="box-bg regular_div" style="display: <?php echo isset($pMethod) && $pMethod == 1 ? 'block' : 'none'?>;">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Delivery In</label>
						<input type="number" class="form-control" name="delivery" step="1" min="1" pattern="^\d+(\.\d{1,2})?$" placeholder="No. of Days">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Price</label>
						<input type="number" class="form-control" name="price" step="0.01" pattern="^\d+(\.\d{1,2})?$" placeholder="Enter price">
					</div>
				</div>
				
				<?php if($service_category['price_type'] == 1):?>
					<div class="col-sm-3">
		          <label>Charge Per</label>
		          <select class="form-control input-md" name="price_per_type" id="price_per_type">
		              <option value="">Please Select</option>
		              <?php if(!empty($price_per_type)): ?>
		                  <?php foreach ($price_per_type as $value): ?>
		                      <?php 
		                          $selected = $value == $serviceData['price_per_type'] ? 'selected' : '';
		                      ?>
		                      <option value="<?php echo $value; ?>" <?php echo $selected; ?> >
		                          <?php echo $value; ?>
		                      </option>
		                  <?php endforeach;?>
		              <?php endif;?>    
		          </select>
		      </div>
		 		<?php endif; ?>

		 		<div class="col-sm-3">
					<div class="form-group">
						<label id="totalLabel">Total no. of</label>
						<input type="number" class="form-control" name="quantity" id="quantity" min="1" step="1" pattern="^\d+(\.\d{1,2})?$" placeholder="Total no. of">
					</div>
				</div>
			</div>
		</div>

		<ul class="mainUl">
			<li>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="is_offer_expires" name="is_offer_expires" value="1" onclick="toggleSelectBox(0)">
					<label class="form-check-label" for="is_offer_expires">Offer expires in</label>
				</div>
				<div class="form-group" style="margin-bottom: 0px;">
					<select class="form-control" id="offer_expires_days0" disabled name="offer_expires_days">
						<option value="">Select Days</option>
						<option value="1">1 day</option>
						<option value="3">3 days</option>
						<option value="6">6 days</option>
					</select>
				</div>
			</li>
			<li>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="is_requirements" name="is_requirements" value="1">
					<label class="form-check-label" for="is_requirements">Request for requirements</label>
				</div>
			</li>					
		</ul>

		<?php if(!empty($attributes) && !empty($package_data)):?>
			<div>
				<h4>Offer includes</h4>
				<?php 
					$basicAtt = isset($package_data) && isset($package_data->basic->attributes) ? $package_data->basic->attributes : [];
					$standardAtt = isset($package_data) && isset($package_data->standard->attributes) ? $package_data->standard->attributes : [];
					$premiumAtt = isset($package_data) && isset($package_data->premium->attributes) ? $package_data->premium->attributes : [];
					$allAttributes = array_unique(array_merge($basicAtt, $standardAtt, $premiumAtt));
				?>
				<ul class="pl-0 selectOffers">
					<?php foreach($attributes as $key => $value):?>
						<?php if(in_array($value['id'], $allAttributes)):?>
							<li>
								<div class="form-check">
									<input class="form-check-input" name="offer_includes_ids[basic][]" type="checkbox" value="<?php echo $value['id']?>" id="basic_<?php echo $value['id']?>">
									<label class="form-check-label" for="basic_<?php echo $value['id']?>">
										<?php echo $value['attribute_name']?>
									</label>
								</div>
							</li>
						<?php endif; ?>	
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif;?>
</div>
  <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button class="btn btn-warning sendbtn1" type="submit">Send Offer</button>      
  </div>
</form>