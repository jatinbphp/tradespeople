	<?php
	include 'include/header.php';
	$get_commision = $this->common_model->get_commision();
	?>
	<style type="text/css">
		.width-100{
			width: 100%;
		}
		.other-post-view img{
			height: 110px;
			width: 100%;
			object-fit: cover;
			border: 1px solid #dfdfdf;
			padding: 5px;
		}

		.other-post-view video{
			height: 110px;
			width: 100%;
			object-fit: cover;
			border: 1px solid #dfdfdf;
			padding: 5px;			
		}

		.member-summary .member-image{
			width: 165px;
			height: 165px;
			max-width: none;
			max-height: none;
		}
		.order-details{
			cursor: pointer;
		}
		.names{
			color: #3d78cb;
		}
		#openChat, .openRequirementModal{cursor: pointer;}

		/*----------LOADER CSS START----------*/
		.loader_ajax_small {
			display: none;
			border: 2px solid #f3f3f3 !important;
			border-radius: 50%;
			border-top: 2px solid #2D2D2D !important;
			width: 29px;
			height: 29px;
			margin: 0 auto;
			-webkit-animation: spin_loader_ajax_small 2s linear infinite;
			animation: spin_loader_ajax_small 2s linear infinite;
		}

		@-webkit-keyframes spin_loader_ajax_small {
			0% { -webkit-transform: rotate(0deg); }
			100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin_loader_ajax_small {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		/*----------LOADER CSS END----------*/

		.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
		.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
		.imgUp{margin-bottom:15px}
		.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
		.boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;}
		.boxImage img { height: 100%;object-fit: contain; border-radius: 10px;}
		
		.videoPreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
		.boxImage video { height: 100%;object-fit: contain;}

		#imgpreview {
			padding-top: 15px;
		}
		.boxImage {
			margin: 0;
			padding: 3px;
		}
		.imagePreviewPlus {
			height: 140px;
			box-shadow: none;
		}

		.tradesmen-top{
			padding: 15px 15px 10px;
		}
		.img-name{
			display: flex;
			gap: 75px;
		}
		.img-name img{
			width: 130px;
			height: 75px;
			display: block;
			max-width: 100%;	
		}
		
		.faicon{
			font-size: 30px;
			color: #2875D7;
		}

		.order-faicon{
			font-size: 20px;
			color: #35a311;
		}

		.filled-icon svg {
			fill: #2875D7;
		}

		.timeline {
			width: 85%;
			max-width: 700px;
			margin-left: auto;
			margin-right: auto;
			display: flex;
			flex-direction: column;
			padding: 0 0 0 32px;
			border-left: 3px solid #ddd;		
		}

		#Timeline .tradesmen-box{
			box-shadow: none;
			border: 0;
		}

		#track-order-div .timeline {
			width: 85%;
			max-width: 700px;
			margin-left: auto;
			margin-right: auto;
			display: flex;
			flex-direction: column;
			padding: 0 0 0 32px;
			border-left: 3px solid #35a311;		
		}

		.timeline li{
			border-bottom: 1px solid #dbd6d6;
			padding-bottom: 1.5rem;
		}

		.delivery-time li{
			padding-bottom: 0;	
		}

		.timeline-item {
			display: flex;
			gap: 24px;
			& + * {
				margin-top: 6px;
			}		
		}

		.new-comment {
			width: 100%;
			input {
				border: 1px solid #f1f1f1 ;
				border-radius: 6px;
				height: 48px;
				padding: 0 16px;
				width: 100%;
				&::placeholder {
					color: var(--c-grey-300);
				}

				&:focus {
					border-color: var(--c-grey-300);
					outline: 0; // Don't actually do this
					box-shadow: 0 0 0 4px var(--c-grey-100);
				}
			}
		}

		.timeline-item-icon {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 30px;
			height: 30px;
			margin-left: -48px;
			flex-shrink: 0;
			overflow: hidden;
			/*box-shadow: 0 0 0 6px #fff;*/
			svg {
				width: 20px;
				height: 20px;
			}

			&.faded-icon {
				background-color: #fff;
				color: var(--c-grey-400);
			}

			&.filled-icon {
				background-color: #fff;
				color: #fff;
			}
		}

		#track-order-div .timeline-item-icon {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 30px;
			height: fit-content;
			margin-left: -48px;
			flex-shrink: 0;
			overflow: hidden;
			/*box-shadow: 0 0 0 6px #fff;*/
			svg {
				width: 20px;
				height: 20px;
			}

			&.faded-icon {
				background-color: #fff;
				color: var(--c-grey-400);
			}

			&.filled-icon {
				background-color: #fff;
				color: #fff;
			}
		}

		.timeline-item-description {
			display: flex;
			padding-top: 6px;
			gap: 8px;
			color: var(--c-grey-400);
			flex-wrap: wrap;
			.delivery-time {
				width: 100%;
				background: #dddddd;
				margin: 0;
				list-style: none;
				display: flex;
				align-items: center;
				justify-content: space-around;
				border-radius: 10px;
				padding: 10px;
				text-align: center;
				font-size: 15px;
			}
			.delivery-conversation {
				width: 100%;
				/*background: #dddddd;*/
				margin: 0;
				list-style: none;
				/*display: flex;*/
				align-items: center;
				justify-content: space-around;
				/*border-radius: 10px;*/
				border: 1px solid #dfdfdf;
				padding: 10px;		    
				font-size: 15px;
			}
			img {
				flex-shrink: 0;
			}
			a {
				color: var(--c-grey-500);
				font-weight: 500;
				text-decoration: none;
				&:hover,
				&:focus {
					outline: 0; // Don't actually do this
					color: var(--c-blue-500);
				}
			}
		}

		.avatar {
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			overflow: hidden;
			aspect-ratio: 1 / 1;
			flex-shrink: 0;
			width: 40px;
			height: 40px;
			&.small {
				width: 28px;
				height: 28px;
			}

			img {
				object-fit: cover;
			}
		}

		.comment {
			border: 1px solid #d5d5d5;
			box-shadow: 0 4px 4px 0 #f1f1f1;
			border-radius: 6px;
			padding: 10px;
		}

		.button {
			border: 0;
			padding: 0;
			display: inline-flex;
			vertical-align: middle;
			margin-right: 4px;
			margin-top: 12px;
			align-items: center;
			justify-content: center;
			font-size: 1rem;
			height: 32px;
			padding: 0 8px;
			background-color: var(--c-grey-100);
			flex-shrink: 0;
			cursor: pointer;
			border-radius: 99em;

			&:hover {
				background-color: var(--c-grey-200);
			}

			&.square {
				border-radius: 50%;
				color: var(--c-grey-400);
				width: 32px;
				height: 32px;
				padding: 0;
				svg {
					width: 24px;
					height: 24px;
				}

				&:hover {
					background-color: var(--c-grey-200);
					color: var(--c-grey-500);
				}
			}
		}

		.show-replies {
			color: var(--c-grey-300);
			background-color: transparent;
			border: 0;
			padding: 0;
			margin-top: 16px;
			display: flex;
			align-items: center;
			gap: 6px;
			font-size: 1rem;
			cursor: pointer;
			svg {
				flex-shrink: 0;
				width: 24px;
				height: 24px;
			}

			&:hover,
			&:focus {
				color: var(--c-grey-500);
			}
		}

		.avatar-list {
			display: flex;
			align-items: center;
			& > * {
				position: relative;
				box-shadow: 0 0 0 2px #fff;
				margin-right: -8px;
			}
		}

		.timeline-item-description h5{
			margin-top: 0!important;
			width: 100%;
		}

		.verification-checklist{
			margin-bottom: 0;
		}

		.verification-checklist.order-metrics .list{
			border-bottom: 0;
			padding-bottom: 0;
			margin-bottom: 0;
			font-weight: 600;
		}

		.verification-checklist.order-metrics .list li a{
			color: #000;
		}

		.verification-checklist.order-metrics .list .active a{
			color: #3d78cb;
			/*border-bottom: 2px solid #fe8a0f;*/
			padding-bottom: 8px;
		}

		#Details table{
			border: 1px solid #ddd;
		}

		#approved-btn-div{
			width: 100%;
			text-align: center;
		}

		.rating {
			display: flex;
			justify-content: center;
			align-items: center;
			grid-gap: .5rem;
			font-size: 2rem;
			color: var(--yellow);
			margin-bottom: 2rem;
		}

		.rating .star {
			cursor: pointer;
		}

		.rating .star.active {
			color: gold;
			animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
		}

		@keyframes animate {
			0% {
				opacity: 0;
				transform: scale(1);
			}
			50% {
				opacity: 1;
				transform: scale(1.2);
			}
			100% {
				opacity: 1;
				transform: scale(1);
			}
		}

		.rating .star:hover {
			transform: scale(1.1);
		}
	</style>
	<div class="loader-bg hide" id='loader'>
		<span class="loader"></span>
	</div>
	<div class="acount-page membership-page">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php include 'include/sidebar.php'; ?>				
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<div class="mjq-sh p-4">
								<div class="verification-checklist order-metrics">
									<ul class="list">
										<li class="active">
											<a data-toggle="tab" href="#Timeline">Timeline</a>
										</li>
										<li>
											<a data-toggle="tab" href="#Details">Details</a>
										</li>
										<li>
											<a data-toggle="tab" href="#Requirements">Requirements</a>
										</li>
										<li>
											<a data-toggle="tab" href="#Delivery">Delivery</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="tab-content">
								<div id="Timeline" class="tab-pane fade active in">
									<div class="tradesmen-box mt-4">
										<div class="tradesmen-top" style="border-bottom:0">
											<div class="img-name p-0">
												<div class="names" style="width:100%">
													<span class="services-description">
														<?php if(empty($requirements)):?>
															<span>
																<h4 style="color: #000;">One last step to get your order started!</h4>
																<span class="text-muted">
																	We notified <?php echo $tradesman['trading_name']; ?> about your order. Submit your requirement to get your order started.
																</span>
															</span>	
														<?php elseif($order['status'] == 'disputed'):?>
															<span>
																<h4 style="color: #000;">Your Order is disputed</h4>
															</span>
														<?php else:?>	
															<?php if(!in_array($order['status'],['completed','cancelled'])):?>
																<span>
																	<h4 style="color: #000;">Your order is now in the works</h4>
																	<span class="text-muted">
																		We notified <?php echo $tradesman['trading_name']; ?> about your order. <br>
																		You should receive your delivery by <b class="text-b"><?php echo $delivery_date; ?></b>
																	</span>
																</span>
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == 1):?>	
																<span>
																	<h4 style="color: #000;">Your order has been cancelled</h4>
																	<span class="text-muted">
																		Your payment has been creadited to your Tradespeople Wallet and can be used or refunded at any time.
																	</span>
																</span>
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == 0):?>	
																<span>
																	<h4 style="color: #000;">Order cancellation requested</h4>
																	<span class="text-muted">
																		<?php
																			if($this->session->userdata('type')==1){
																				if($all_conversation[0]['sender'] == $user['id']){
																					$cUserName = 'You';
																				}else{
																					$cUserName = $homeowner['f_name'].' '.$homeowner['l_name'];
																				}	
																			}else{
																				if($all_conversation[0]['sender'] == $user['id']){
																					$cUserName = 'You';
																				}else{
																					$cUserName = $tradesman['trading_name'];
																				}	
																			}																			
																		?>
																		<?php echo $cUserName; ?> has requested the cancellation of your order.
																		<br>
																		Please respond to the request before the <?php echo $orderCancelDateLimit; ?>.
																	</span>
																</span>
															<?php else: ?>
																<span>
																	<h4 style="color: #000;">Your order is completed</h4>
																</span>
															<?php endif;?>	
														<?php endif; ?>
													</span>
													<span class="pull-right">
														<?php if($this->session->userdata('type')==1):?>
															<?php if($order['status'] == 'request_modification'):?>
																<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Re-deliver Work</button>
															<?php endif; ?>

															<?php if($order['status'] == 'active'):?>	
																<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Deliver Work</button>
															<?php endif; ?>

															<?php if($order['status'] == 'disputed'):?>
																<a href="<?php echo base_url().'order-dispute/'.$order['id']?>">
																	<button type="button" class="btn btn-warning ">View Dispute</button>
																</a>
															<?php endif; ?>

															<?php if($order['status'] == 'completed'):?>
																<a href="<?php echo base_url('orderCompleted/'.$order['id']); ?>">
																	<button type="button" class="btn btn-warning">
																		View Review
																	</button>
																</a>
															<?php endif; ?>

															<button type="button" class="btn btn-warning" data-id="<?php echo $order['user_id']?>" onclick="openChat()">Chat</button>
														<?php else: ?>
															<?php if($order['status'] == 'completed'):?>
																<a href="<?php echo base_url('orderCompleted/'.$order['id']); ?>">
																	<button type="button" class="btn btn-warning">
																		View Review
																	</button>
																</a>	
															<?php endif; ?>

															<?php if($order['status'] == 'disputed'):?>
																<a href="<?php echo base_url().'order-dispute/'.$order['id']?>">
																	<button type="button" class="btn btn-warning ">View Dispute</button>
																</a>
															<?php endif; ?>

															<button class="btn btn-warning" data-id="<?php echo $service['user_id']?>" onclick="openChat()">Chat</button>

															<?php if(empty($requirements)):?>
																<button class="btn btn-warning" class="openRequirementModal btn btn-warning" data-toggle="modal" data-target="#order_requirement_modal">Submit Requirement</button>
															<?php endif; ?>
														<?php endif; ?>
													</span>										
												</div>									
											</div>
										</div>
									</div>
									<div class="timeline-div bg-white p-4">
										<ol class="timeline">
											<?php if($order['status'] == 'active'):?>
												<li class="timeline-item">
													<span class="timeline-item-icon | faded-icon">
														<i class="fa fa-clock-o faicon"></i>
													</span>
													<div class="timeline-item-description">
														<h5>Expected delivery <?php echo $delivery_date; ?></h5>						
														<ul class="delivery-time">
															<li><b><?php echo $rDays; ?></b><br/>Days</li>
															<li><b><?php echo $rHours; ?></b><br/>Hours</li>
															<li><b><?php echo $rMinutes; ?></b><br/>Minutes</li>
														</ul>
													</div>
												</li>
											<?php endif;?>

											<?php include 'order_tracking_timeline.php'; ?>

											<?php if(!empty($delivery_date)):?>
												<li class="timeline-item">
													<span class="timeline-item-icon | faded-icon">
														<i class="fa fa-file-text-o faicon" aria-hidden="true"></i>
													</span>
													<div class="timeline-item-description">
														<h5>Your delivery data was updated to <?php echo $delivery_date; ?></h5>
													</div>
												</li>
												<li class="timeline-item | extra-space">
													<span class="timeline-item-icon | filled-icon ">
														<i class="fa fa-paper-plane faicon" aria-hidden="true"></i>
													</span>
													<div class="timeline-item-wrapper">
														<div class="timeline-item-description">
															<h5>Order Started</h5>
														</div>
													</div>
												</li>
											<?php endif; ?>

											<li class="timeline-item order-details">
												<span class="timeline-item-icon | faded-icon">
													<i class="fa fa-file-text-o faicon" aria-hidden="true"></i>
												</span>
												<div class="timeline-item-description" style="width:100%">
													<h5 id="order-requirement" onclick="toggleOrderReq();"> 
														Order Requirement Submitted
														<i class="fa fa-angle-down pull-right"></i>
													</h5>

													<?php if(!empty($requirements)): ?>
														<div class="comment" id="requirement-div"  style="display:none; width: 100%;">
															<h4 style="margin-top:0px">Order Requirements</h4>
															<p><?php echo $requirements['requirement']; ?></p>

															<?php if(!empty($requirements['location'])):?>
																<h4 style="margin-top:0px">Order Location</h4>
																<p><?php echo $requirements['location']; ?></p>
															<?php endif;?>

															<?php if(!empty($attachements)):?>
																<h4>Order Attachments</h4>

																<div class="row other-post-view" id="con_attachments">
																	<?php foreach ($attachements as $key => $value): ?>
																		<?php $image_path = FCPATH . 'img/services/' . ($value['attachment'] ?? ''); ?>
																		<?php if (file_exists($image_path) && $value['attachment']): ?>
																			<?php
																			$mime_type = get_mime_by_extension($image_path);
																			$is_image = strpos($mime_type, 'image') !== false;
																			$is_video = strpos($mime_type, 'video') !== false;
																			?>
																			<div class="col-md-3 pr-3 pl-3">
																				<?php if ($is_image): ?>
																					<a href="<?php echo base_url('img/services/') . $value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
																					<img src="<?php echo base_url('img/services/') . $value['attachment']; ?>" alt="">
																					</a>
																				<?php elseif ($is_video): ?>	
																					<a href="<?php echo base_url('img/services/') . $value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
																						<video controls src="<?php echo base_url('img/services/') . $value['attachment']; ?>" type="<?php echo $mime_type; ?>" loop class="serviceVideo">
																						</video>
																					</a>
																				<?php endif; ?>
																			</div>
																		<?php endif; ?>	
																	<?php endforeach; ?>
															 	</div>
															<?php endif; ?>
														</div>
													<?php endif; ?>
												</div>
											</li>

											<li class="timeline-item | extra-space order-details" style="padding-bottom: 0; border-bottom: 0;">
												<span class="timeline-item-icon | filled-icon ">
													<i class="fa fa-calendar faicon" aria-hidden="true"></i>
												</span>
												<div class="timeline-item-description" style="width:100%">
													<h5 id="order-created" onclick="toggleOrderCreated();">
														Order Created
														<i class="fa fa-angle-down pull-right"></i>
													</h5>
													<div class="comment" id="order-created-div"  style="display:none; width: 100%;">
														<p><?php echo $created_date; ?></p>
													</div>
												</div>
											</li>
										</ol>
									</div>
								</div>

								<div id="Details" class="tab-pane fade">
									<div class="timeline-div bg-white mt-4 p-5">
										<div class="row pb-4 ml-0 mr-0" style="border-bottom:1px solid #f1f1f1; ">
											<div class="col-md-10 pl-0">
												<h4 class="mt-1"><?php echo $service['service_name']; ?></h4>
											</div>
											<div class="col-md-2 text-right pr-0">
												<span>Total Price</span>
											</div>
											<div class="col-md-10 pl-0">
												<span>
													Ordered From 
													<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>">
														<?php echo $tradesman['trading_name']; ?>
													</a>
													<?php if(!empty($delivery_date)): ?>
														| Delivery Date <?php echo $delivery_date; ?>
													<?php endif;?>	
												</span>
											</div>
											<div class="col-md-2 text-right pr-0">
												<span><b><?php echo '£'.number_format($order['total_price'],2); ?></b></span>
											</div>
										</div>
										<div class="row pb-4 pt-4 ml-0 mr-0" style="border-bottom:1px solid #f1f1f1; ">
											<div class="col-md-6 pl-0">
												Order number: <?php echo $order['order_id']; ?>
											</div>
											<div class="col-md-6 text-right pr-0">
												<span>View billing history</span>
											</div>
										</div>
										<h4 class="mt-3 mb-0"><?php echo $service['service_name']; ?></h4>
										<div class="row mt-3">
											<div class="col-md-12">
												<table class="table table-striped">
													<thead class="bg-gray">
														<tr>
															<td colspan="4">
																<b>Your Order</b>
																<span class="ml-2" style="font-size:12px;">
																	<i><?php echo $created_date; ?></i>
																</span>
															</td>
														</tr>
														<tr>
															<th>Item</th>                     
															<th>Qty</th>                     
															<th class="text-right">Duration</th> 
															<th class="text-right">Price</th>                                                 
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<b><?php echo $service['service_name']; ?></b>
																<?php if(!empty($attributes)): ?>
																	<ul>
																		<?php foreach($attributes as $att):?>
																			<li>
																				<?php echo $att['attribute_name']; ?>
																			</li>
																		<?php endforeach; ?>
																	</ul>
																<?php endif; ?>
																<?php if(!empty($order['ex_services'])):?>
																	<b>Extra Services</b>
																	<?php if(!empty($extra_services) && !empty($selectedExs)): ?>
																	<ul>
																		<?php foreach($extra_services as $exs):?>
																			<?php if(in_array($exs['id'], $selectedExs)): ?>
																				<li>
																					<?php echo $exs['ex_service_name']; ?>
																				</li>
																			<?php endif;?>
																		<?php endforeach; ?>
																	</ul>
																<?php endif; ?>
															<?php endif;?>	
														</td>
														<td class="text-center">
															<?php echo $order['service_qty'];?>
														</td>
														<td class="text-right"><?php echo $duration.' Days'; ?></td>
														<td class="text-right"><?php echo '£'.number_format($order['total_price'],2); ?></td>
													</tr>                                        	
												</tbody>
												<tfoot>
													<tr class="bg-gray">
														<td><b>Sub Total</b></td>
														<td colspan="3" class="text-right">
															<b>
																<?php 
																$subTotal = $order['total_price'] - $order['service_fee'];
																echo '£'.number_format($subTotal,2); 
																?>
															</b>
														</td>
													</tr>
													<tr class="bg-gray">
														<td><b>Service Fee</b></td>
														<td colspan="3" class="text-right">
															<b>
																<?php echo '£'.number_format($order['service_fee'],2); ?>
															</b>
														</td>
													</tr>
													<tr class="bg-gray">
														<td>
															<b>Total</b>
														</td>
														<td colspan="3" class="text-right">
															<b>
																<?php echo '£'.number_format($order['total_price'],2); ?>
															</b>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
								</div>
								</div>

								<div id="Requirements" class="tab-pane fade">
									<div class="timeline-div bg-white mt-4 p-5">
										<?php if(!empty($requirements)): ?>
											<div class="comment">
												<h4 style="margin-top:0px">Order Requirements</h4>
												<p><?php echo $requirements['requirement']; ?></p>

												<?php if(!empty($requirements['location'])):?>
													<h4 style="margin-top:0px">Order Location</h4>
													<p><?php echo $requirements['location']; ?></p>
												<?php endif;?>

												<?php if(!empty($attachements)):?>
													<h4>Order Attachments</h4>
													<div class="row" id="attachments">
														<?php foreach ($attachements as $key => $value): ?>
															<?php $image_path = FCPATH . 'img/services/' . ($value['attachment'] ?? ''); ?>
															<?php if (file_exists($image_path) && $value['attachment']):?>
																<div class="col-md-4 col-sm-6 col-xs-12">
																	<div class="boxImage imgUp">
																		<div class="imagePreviewPlus">
																			<img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/').$value['attachment']?>" alt="<?php echo $value['id']; ?>">
																		</div>
																	</div>
																</div>
															<?php endif; ?>
														<?php endforeach; ?>
													</div>
												<?php endif; ?>											
											</div>
										<?php else:?>
											<div class="comment">
												<h4 style="margin-top:0px">Order Requirements Not Submitted</h4>
											</div>
										<?php endif; ?>

										<?php if(!empty($taskAddress)):?>
											<div class="comment mt-3">
												<h4 style="margin-top:0px">Task Address</h4>
												<p>
													<?php echo $taskAddress['address']; ?>,
													<?php echo $taskAddress['city'].'-'.$taskAddress['zip_code']; ?>														
												</p>
											</div>
										<?php endif; ?>
									</div>
								</div>

								<div id="Delivery" class="tab-pane fade">
									<?php if(empty($delivery_date)): ?>
										<div class="timeline-div bg-white mt-4 p-5" style="height:400px;">
											<div class="text-center">
												<img src="<?php echo base_url(); ?>img/delivery_icon.png" style="width: 20%;">
											</div>
											<div class="text-center">
												<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>">
													<?php echo $tradesman['trading_name'];?>
												</a> 
												should deliver this order as soon as
											</div>
										</div>
									<?php else: ?>
										<?php if(empty($all_conversation)):?>
											<div class="timeline-div bg-white mt-4 p-5" style="height:400px;">
												<div class="text-center">
													<img src="<?php echo base_url(); ?>img/delivery_icon.png" style="width: 20%;">
												</div>
												<div class="text-center">
													<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>">
														<?php echo $tradesman['trading_name'];?>
													</a> 
													should deliver this order as soon as
												</div>
											</div>
										<?php endif; ?>

										<div class="timeline-div bg-white mt-4 p-4">
											<ol class="timeline">
												<?php include 'order_tracking_timeline.php'; ?>
											</ol>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="col-md-4 mt-4">
							<div class="card-summary">
								<div class="order-detail-box">
									<div class="summary-box-heding">
										<h4>Order Details</h4>
										<?php if($this->session->userdata('type')==1 && !in_array($order['status'], ['cancelled','completed'])):?>
											<div class="ellipsis-btn">
												<button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
													<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
												</button>
												<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
													<?php if($order['status'] == 'disputed'):?>
														<li><a class="dropdown-item" href="<?php echo base_url().'order-dispute/'.$order['id']?>">View Dispute</a></li>
														<li><a class="dropdown-item" href="javascript:void(0)">Cancel Dispute</a></li>
													<?php else: ?>
														<?php if($order['status'] == 'cancelled'):?>
															<li>
																<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_decision_modal">Make Decision</a>
															</li>
														<?php else: ?>
															<li>
																<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_dispute_modal">Dispute</a>
															</li>															
														<?php endif; ?>
													<?php endif; ?>
													<li><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_cancel_modal">Order Cancellation</a></li>	
												</ul>
											</div>
										<?php else: ?>
											<?php if(!in_array($order['status'], ['cancelled','completed'])):?>
												<div class="ellipsis-btn">
													<button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
													</button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<?php if($order['status'] == 'disputed'):?>
															<li><a class="dropdown-item" href="<?php echo base_url().'order-dispute/'.$order['id']?>">View Dispute</a></li>
														<?php else: ?>
															<li>
																<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_dispute_modal">Dispute</a>
															</li>
															<?php if($order['status'] == 'declined'):?>
																<li>
																	<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#declined_reason_modal">View Reason</a>
																</li>
															<?php endif; ?>															
														<?php endif; ?>
														<li style="margin-top: 0;"><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_cancel_modal">Order Cancellation</a></li>
													</ul>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									</div>

									<div class="summary-feature-article">
										<a href="<?php echo base_url().'service/'.$service['slug']?>">
											<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
											<?php if (file_exists($image_path) && $service['image']): ?>
												<img src="<?php echo base_url('img/services/') . $service['image']; ?>" class="img-responsive">
											<?php else: ?>	
												<img src="<?php echo base_url('img/default-image.jpg'); ?>" class="img-responsive">
											<?php endif; ?>										
											<span>
												<p>
													<?php
													$totalChr = strlen($service['description']);
													if($totalChr > 15){
														echo substr($service['description'], 0, 15).'...';
													}else{
														echo $service['description'];
													}
													?>
												</p>
												<span class="badge bg-warning p-2 pl-4 pr-4 mt-4">
													<?php if($this->session->userdata('type')==1):?>
														<?php if(empty($requirements)):?>
															Awaiting Requirement 
														<?php else: ?>	
															<?php if($order['status'] == 'active'):?>
																In Progress
															<?php elseif($order['status'] == 'request_modification'):?>
																Revision
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '0'):?>
																Cancellation pending
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '1'):?>
																Cancelled
															<?php else: ?>	
																<?php echo ucfirst(str_replace('_', ' ', $order['status'])) ?>
															<?php endif; ?>
														<?php endif; ?>
													<?php else: ?>
														<?php if($order['status'] == 'active'):?>
															In Progress
														<?php elseif($order['status'] == 'request_modification'):?>
															Revision
														<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '0'):?>
															Cancellation pending
														<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '1'):?>
															Cancelled
														<?php else: ?>	
															<?php echo ucfirst(str_replace('_', ' ', $order['status'])) ?>
														<?php endif; ?>
													<?php endif; ?>
												</span>								
											</span>
										</a>
									</div>
									<ul style="border-bottom: 1px solid #f1f1f1;">
										<li>
											<p>Ordered From</p>
											<p>
												<b>
													<?php $dotColor = !empty($tradesman['is_active']) && $tradesman['is_active'] == 1 ? '#35a311' : '#dbd5d5'; ?>
													<i class="fa fa-circle" style="font-size: 8px; color: <?php echo $dotColor?>;"></i>
													<?php echo $tradesman['f_name']; ?>
												</b>
												<br>
												<span class="text-muted"><?php echo $tradesman['trading_name']; ?></span>
											</p>
										</li>
										<li>
											<p>Delivery Date</p>
											<p class="text-right">
												<b>
													<?php if(!empty($delivery_date)): ?>
														<?php echo $delivery_date; ?>
													<?php else:?>	
														To be determined
													<?php endif; ?>
												</b>
											</p>
										</li>
										<li>
											<p>Total Price</p>
											<p><b><?php echo '£'.number_format($order['total_price'],2); ?></b></p>
										</li>
										<li class="mb-3">
											<p>Order Number</p>
											<p><b><?php echo $order['order_id']; ?></b></p>
										</li>
									</ul>

									<div class="timeline-div bg-white pt-2">
										<h5 id="order-created" onclick="toggleTrackOrder();">
											<b>Track Order</b>
											<i class="fa fa-angle-up pull-right"></i>
										</h5>
										<div id="track-order-div"  style=" width: 100%;">
											<ol class="timeline mb-0">
												<li class="timeline-item | extra-space order-details" style="padding-bottom: 0; border-bottom: 0;">
													<span class="timeline-item-icon | filled-icon ">
														<i class="fa fa-check-circle-o order-faicon" aria-hidden="true"></i>
													</span>
													<div class="timeline-item-description">
														<h5>Order Placed</h5>
													</div>												
												</li>
												<li class="timeline-item | extra-space order-details" style="padding-bottom: 0; border-bottom: 0;">
													<?php if(empty($requirements)):?>
														<span class="timeline-item-icon | filled-icon pb-1">
															<i class="fa fa-circle-o order-faicon" aria-hidden="true"></i>
														</span>
														<div class="timeline-item-description">
															<h5 class="mb-0">Submit Requirement</h5>
														</div>
													<?php else: ?>
														<span class="timeline-item-icon | filled-icon pb-1">
															<i class="fa fa-check-circle-o order-faicon" aria-hidden="true"></i>
														</span>
														<div class="timeline-item-description">
															<h5 class="mb-0">Requirement Submitted</h5>
														</div>
													<?php endif; ?>
												</li>
											</ol>
										</div>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade in" id="order_requirement_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_requirement_form" enctype="multipart/form-data">
						<div class="modal-header">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Add Order Requirement</h4>
						</div>
						<div class="modal-body form_width100">
							<div class="form-group">
								<label for="requirement"> What do you need for this order?</label>
								<textarea rows="5" placeholder="" name="requirement" id="requirement" class="form-control"></textarea>
							</div>
							<!-- <div class="form-group">
								<label for="location"> Where is task located?</label>
								<textarea rows="5" placeholder="" name="location" id="location" class="form-control"></textarea>
							</div> -->
							<div class="row">
								<div id="loader1" class="loader_ajax_small"></div>
								<div class="col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer2">
									<div class="file-upload-btn addWorkImage imgUp">
										<div class="btn-text main-label">Attachments</div>
										<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
										<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
										<input type="file" name="attachments" id="attachments">		
									</div>
								</div>
							</div>
							<input type="hidden" name="multiImgIds" id="multiImgIds">	
							<div class="row" id="previousImg">
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" id="order_id">
							<button type="button" class="btn btn-info signup_btn" onclick="submitRequirement()">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade in" id="order_dispute_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_dispute_form" enctype="multipart/form-data">
						<div class="modal-header">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Dispute Order</h4>
							<div class="alert alert-warning">
                  <ul>
                     <li> Most disputes are the result of a simple misunderstanding.</li>
                     <li> Our dispute resolution system is designed to allow both parties to resolve the issue amongst themselves.</li>
                     <li> Most disputes are resolved without arbitration.</li>
                     <li> If an agreement cannot be reached, either party may elect to pay an arbitration fee for our dispute team to resolve the matter.</li>
                  </ul>
               </div>
						</div>
						<div class="modal-body form_width100">
							<div class="form-group">
								<label for="reason"> Please describe in detail what the requirements were for the milestone(s) you wish to dispute.</label>
								<textarea rows="5" placeholder="" name="reason" id="reason" class="form-control"></textarea>
							</div>

							<div class="form-group">
								<label for="reason"> Please describe in detail which of these requirements were not completed.</label>
								<textarea rows="5" placeholder="" name="reason2" id="reason2" class="form-control"></textarea>
							</div>

							<label class="control-label" for="textinput"><b>Please include evidence of how the milestone requirements we communicated, as well as any other evidence that supports your case.</b></label>
							<input type="file" onchange="uploadImageForDispute(<?php echo $order['id']; ?>)" id="dispute-file-upload-input-<?php echo $order['id']; ?>" name="files[]" accept="image/*,pdf" multiple="" class="form-control">

							<table class="table">
                 <thead>
                    <tr>
                    </tr>
                 </thead>
                 <tbody class="disputeUploadFilesHtml<?php echo $order['id']; ?>">
                 </tbody>
              </table>

							<label class="control-label mt-4" for="textinput"><b>Total Amount In dispute: <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $order['id']; ?>"><?php echo $order['price']; ?></span></b></label>

							<label class="control-label" for="textinput"><b>Offer the amount you are prepared to pay:</b></label>

							<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
                <input type="number" id="offer_amount<?php echo $order['id']; ?>" required="" min="0" name="offer_amount" max="<?php echo $order['price']; ?>" class="form-control" placeholder="Amount">
             	</div>

             	<p>Please enter an amount between <i class="fa fa-gbp"></i>0 to <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $order['id']; ?>"><?php echo $order['price']; ?></span>.</p>

             	<div class="caution-txt">
                <b class="text-danger">Caution!</b> You are entering the amount of the order that you are happy for the other
                party to receive.
                You may increase your offer in the future but you may not lower it.
             	</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" id="order_id">
							<button type="button" class="btn btn-info signup_btn" onclick="disputeOrder()">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade in" id="order_cancel_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_cancel_form" enctype="multipart/form-data">
						<div class="modal-header">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Order Cancellation Request</h4>						
						</div>
						<div class="modal-body form_width100">
							<p>
								In order to cancel a order, you nee to send a cancellation request to your tradesmen. Once they accept the request, the order will be cancelled and the funds will be returned to you. If the request is denied, you can initiate a dispute. 
							</p>

							<hr>

							<div class="Milestone2">
                <div class="row">
                   <div class="col-sm-8">
                      <p><b>Order Id</b><span style="float: right;"><?php echo $order['order_id']; ?></span></p>
                      <p><b>Tradesmen Name</b><span style="float: right;"><?php echo $tradesman['trading_name']; ?></span></p>
                      <p><b>Order Amount</b><span style="float: right;"><i class="fa fa-gbp"></i><?php echo $order['price']; ?></span></p>
                      <p><b>Date Created</b><span style="float: right;"><?php echo $created_date; ?></span></p>
                   </div>
                </div>
             </div>

							<div class="form-group mt-4">
								<label for="reason"> <b>Why do you want to cancel this order?</b></label>
								<textarea rows="5" placeholder="Reason of Cancel" name="reason" id="reason" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label for="attachment"> Upload Image (Optional)</label>
								<input type="file" name="dct_image" class="form-control" id="attachment">
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" id="order_id">
							<button type="button" class="btn btn-info signup_btn" onclick="cancelOrder()">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade popup" id="order_decision_modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="close<?php echo $mile['id']; ?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Take a Decision</h4>
				</div>
				<div class="modal-body">
					<fieldset>
						<div id="milessss">
							<div class="row">
								<div class="col-md-12">
									<p><b>Reason of Cancellation:</b></p>
									<p><?php echo $order['reason']; ?>
								</div>
							</div>						
							<div class="row">
								<div class="col-md-12">
									<p style="text-align: center;">If you approve this request of cancellation, then the order amount that you have created will be added to your wallet.</p>
									<div class="col-sm-3"></div>
									<div class="col-sm-4">
										<div class="from-group">
											<button class="btn btn-warning btn-lg" onclick="accept_decision(<?php echo $order['id']; ?>)">
												Approve
											</button>
										</div>
									</div>
									<div class="col-sm-4">
										<a class="btn btn-danger btn-lg" href="#" data-target="#decline_request_modal" onclick="return decliensss()" data-toggle="modal">Decline</a>
									</div>
								</div>
							</div>
						</div> 

						<div class="input-append1">
							<div id="fields">
								<input type="hidden" name="order_id" id="order_id" value="<?php echo $order['id']; ?>">
								<input type="hidden" name="order_id" id="order_id" value="<?php echo $order['user_id']; ?>">
								<input type="hidden" name="amounts" id="amounts" value="<?php echo $order['total_price']; ?>">
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade in" id="decline_request_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_cancel_decline_form" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Order Decline Cancellation</h4>						
						</div>
						<div class="modal-body form_width100">
							<div class="form-group">
								<label for="reason"> Why do you want to decline this request?</label>
								<textarea rows="5" placeholder="Reason of decline" name="decline_reason" id="reason" class="form-control"></textarea>
							</div>						
						</div>
						<div class="modal-footer">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" id="order_id">
							<button type="button" class="btn btn-info signup_btn" onclick="declineOrder()">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade in" id="declined_reason_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_dispute_form" enctype="multipart/form-data">
						<div class="modal-header">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Order Cancellation Declined Reason</h4>
						</div>
						<div class="modal-body form_width100">
							<div class="form-group">
								<label for="reason"> Reason of Declined</label>
								<p><?php echo $order['cancel_decline_reason']; ?></p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<div class="modal fade in" id="order_submit_modal">
		<div class="modal-body" id="msg">
			<div class="modal-dialog modal-lg">	 
				<div class="modal-content">         	
					<form method="post" id="order_submit_form" enctype="multipart/form-data">
						<input type="hidden" name="orderId" id="orderId" value="<?php echo $order['id']; ?>">
						<div class="modal-header">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Deliver Order</h4>
						</div>
						<div class="modal-body form_width100">
							<div class="form-group">
								<label for="email"> Description:</label>
								<textarea rows="5" placeholder="" name="description" id="description" class="form-control"></textarea>
							</div>
							<div class="row" id="attachmentRow">
								<div id="loader3" class="loader_ajax_small"></div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer3">
									<div class="file-upload-btn addWorkImage3 imgUp">
										<div class="btn-text main-label">Attachments</div>
										<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
										<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
										<input type="file" name="attachments" id="attachments3">		
									</div>
								</div>
							</div>
							<input type="hidden" name="multiImgIds1" id="multiImgIds3">	
							<div class="row" id="previousImg3">
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" id="reqFormSubmitBtn" class="btn btn-info">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>

	<?php include 'include/footer.php'; ?>
	
	<script>
		$(document).ready(function () {
			$.validator.addMethod("requiredHidden", function(value, element) {
		        return $(element).val() !== ""; // Validate that the value is not empty
		    }, "This field is required.");

			$("#order_submit_form").validate({
				ignore: [],
				rules: {
					description: {
						required: true,
					},
					multiImgIds1: {
						requiredHidden: true
					}
				},
				messages: {
					description: "Please enter a description.",
					multiImgIds1: "Please upload at least one image.",
				},
				errorPlacement: function (error, element) {
					if (element.attr("id") == "multiImgIds3") {
		                error.insertAfter("#attachmentRow"); // Adjust error placement
		            } else {
		            	error.insertAfter(element);
		            }
		        },
		        submitHandler: function (form) {
		            orderSubmit(); // Ensure this function is defined
		        }
		    });
		});

		const el = document.getElementById('imageContainer1');
		if (el) {
			document.getElementById('imageContainer1').addEventListener('click', function() {
				document.getElementById('modification_attachments').click();
			});
		}	

		document.getElementById('imageContainer2').addEventListener('click', function() {
			document.getElementById('attachments').click();
		});

		document.getElementById('imageContainer3').addEventListener('click', function() {
			document.getElementById('attachments3').click();
		});

		const dropArea3 = document.querySelector(".addWorkImage3"),
		button3 = dropArea3.querySelector("img"),
		input3 = dropArea3.querySelector("input");
		let file3;
		var filename3;

		button3.onclick = () => {input.click();};

		input3.addEventListener("change", function (e) {
			e.preventDefault();
			var multiImgIds = $('#multiImgIds3').val();

			var idsArray = multiImgIds.split(',');
			var totalCount = idsArray.length;
			var file_data = $('#attachments3').prop('files')[0];

			var fileSizeInMB = file_data.size / (1024 * 1024);
			if (fileSizeInMB > 60) {
				$('#loader3').hide();
				alert("File size exceeds 60MB. Please upload a smaller file.");
				return;
			}		

			var validFileTypes = [
			    "image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp", // Image types
			    "video/mp4", "video/avi", "video/mpeg", "video/quicktime", "video/x-ms-wmv", "video/webm", "video/3gpp", "video/x-flv" // Video types
			    ];

			if (validFileTypes.indexOf(file_data.type) == -1) {
				alert("Please upload a valid image or video file (GIF, JPEG, JPG, PNG, WEBP, MP4, AVI, MPEG, MOV, WMV, WebM, 3GP, FLV).");
				return false;
			}

			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('conversation_id', 0);
			$('#loader3').show();
			$('#previousImg3').css('opacity', '0.6');
			$.ajax({
				url:site_url+'users/dragDropProjectSubmitAttachment',
				type: "POST",
				data: form_data,
				contentType: false,
				cache: false,
				processData:false,
				dataType:'json',
				success: function(response){
					if(response.status == 1){
						if(multiImgIds != ""){
							var ids = multiImgIds+','+response.id;
							$('#multiImgIds3').val(ids);
						}else{
							$('#multiImgIds3').val(response.id);
						}
						
						if (file_data.type.startsWith('video/')) {
							var reader = new FileReader();
							reader.readAsDataURL(file_data);
							reader.onload = function (e) {
								var videoElement = '<div class="col-md-6 col-xs-12" id="portDiv' + response.id + '">' +
								'<div class="boxImage imgUp">' +
								'<div class="imagePreviewPlus">' +
								'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage3(' + response.id + ', 1)"><i class="fa fa-trash"></i></button></div>' +
								'<video src="' + e.target.result + '" controls style="width:inherit; height:113px;"></video>' +
								'</div></div></div>';
								$('#previousImg3').append(videoElement);
								$('#loader3').hide();
								$('#previousImg3').css('opacity', '1');
								$('#multiImgIds3-error').remove();
							};
						} else {
							var portElement = '<div class="col-md-6 col-xs-12" id="portDiv' + response.id + '">' +
							'<div class="boxImage imgUp">' +
							'<div class="imagePreviewPlus">' +
							'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage3(' + response.id + ', 1)"><i class="fa fa-trash"></i></button></div>' +
							'<img style="width: inherit; height: inherit;" src="' + response.imgName + '" alt="' + response.id + '">' +
							'</div></div></div>';
							$('#previousImg3').append(portElement);
							$('#loader3').hide();
							$('#previousImg3').css('opacity', '1');
							$('#multiImgIds3-error').remove();
						}
					}
				}
			});
		});

		function removeImage3(imgId, type){
			$.ajax({
				url:site_url+'users/removeAttachment',
				type:"POST",
				data:{'imgId':imgId},
				success:function(data){
					$('#portDiv'+imgId).remove();
					removeIdFromHiddenField(imgId.toString(), 'multiImgIds3');
					alert('Attachment deleted successfully');				
				}
			});
		}

		/*Start Code For Submit Requirement */
		const dropArea = document.querySelector(".addWorkImage"),
		button = dropArea.querySelector("img"),
		input = dropArea.querySelector("input");
		let file;
		var filename;

		button.onclick = () => {input.click();};

		input.addEventListener("change", function (e) {
			e.preventDefault();
			var multiImgIds = $('#multiImgIds').val();    	
			var file_data = $('#attachments').prop('files')[0];

			var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp"];
			if (validImageTypes.indexOf(file_data.type) == -1) {
				alert("Please upload a valid image file (GIF, JPEG, JPG, PNG, or WEBP).");
				return false;
			}

			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('requirement_id', 0);
			$('#loader1').show();
			$('#previousImg').css('opacity', '0.6');
			$.ajax({
				url:site_url+'users/dragDropRequirementAttachment',
				type: "POST",
				data: form_data,
				contentType: false,
				cache: false,
				processData:false,
				dataType:'json',
				success: function(response){
					if(response.status == 1){
						if(multiImgIds != ""){
							var ids = multiImgIds+','+response.id;
							$('#multiImgIds').val(ids);
						}else{
							$('#multiImgIds').val(response.id);
						}
						var portElement = '<div class="col-md-6 col-xs-12" id="portDiv'+response.id+'">' +
						'<div class="boxImage imgUp">'+
						'<div class="imagePreviewPlus">'+
						'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage('+response.id+', 1)"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
						'</div></div></div>';
						$('#previousImg').append(portElement);
						$('#loader1').hide();
						$('#previousImg').css('opacity', '1');
					}
				}
			});
		});

		function removeImage(imgId, type){
			$.ajax({
				url:site_url+'users/removeAttachment',
				type:"POST",
				data:{'imgId':imgId},
				success:function(data){
					$('#portDiv'+imgId).remove();
					removeIdFromHiddenField(imgId.toString(), 'multiImgIds');
					alert('Attachment deleted successfully');				
				}
			});
		}

		function removeIdFromHiddenField(idToRemove, divId) {
			var hiddenFieldValue = $('#'+divId).val();
			var idsArray = hiddenFieldValue.split(',');
			var newIdsArray = idsArray.filter(function(id) {
				return id !== idToRemove.toString();
			});
			var newHiddenFieldValue = newIdsArray.join(',');
			$('#'+divId).val(newHiddenFieldValue);        
		}

		function submitRequirement(){
			$('#loader').removeClass('hide');
			formData = $("#order_requirement_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/submitRequirement'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					console.log(result);
					$('#loader').addClass('hide');
					if(result.status == 0){
						$('#order_requirement_modal').modal('hide');
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						$('#order_requirement_modal').modal('hide');
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});
		}

		/*End Code For Submit Requirement */

		/* Start Code For Submit Request Modification & Approved Order */
		const el1 = document.getElementsByClassName('addWorkImage1');
		if(el1){
			const dropArea1 = document.querySelector(".addWorkImage1"),
			button1 = dropArea1.querySelector("img"),
			input1 = dropArea1.querySelector("input");
			let file1;
			var filename1;

			button1.onclick = () => {input1.click();};

			input1.addEventListener("change", function (e) {
				e.preventDefault();
				var multiImgIds = $('#multiModificationImgIds').val();    	
				var file_data = $('#modification_attachments').prop('files')[0];

				var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp"];
				if (validImageTypes.indexOf(file_data.type) == -1) {
					alert("Please upload a valid image file (GIF, JPEG, JPG, PNG, or WEBP).");
					return false;
				}

				var form_data = new FormData();
				form_data.append('file', file_data);
				form_data.append('conversation_id', 0);
				$('#loader2').show();
				$('#previousModificationImg').css('opacity', '0.6');
				$.ajax({
					url:site_url+'users/dragDropProjectSubmitAttachment',
					type: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData:false,
					dataType:'json',
					success: function(response){
						if(response.status == 1){
							if(multiImgIds != ""){
								var ids = multiImgIds+','+response.id;
								$('#multiModificationImgIds').val(ids);
							}else{
								$('#multiModificationImgIds').val(response.id);
							}
							var portElement = '<div class="col-md-6 col-xs-12" id="portDiv'+response.id+'">' +
							'<div class="boxImage imgUp">'+
							'<div class="imagePreviewPlus">'+
							'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeModificationImage('+response.id+', 1)"><i class="fa fa-trash"></i></button></div>'+
							'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
							'</div></div></div>';
							$('#previousModificationImg').append(portElement);
							$('#loader2').hide();
							$('#previousModificationImg').css('opacity', '1');
						}
					}
				});
			});

			function removeModificationImage(imgId, type){
				$.ajax({
					url:site_url+'users/removeOrderSubmitAttachment',
					type:"POST",
					data:{'imgId':imgId},
					success:function(data){
						$('#portDiv'+imgId).remove();
						removeIdFromHiddenField(imgId.toString(), 'multiModificationImgIds');
						alert('Attachment deleted successfully');				
					}
				});
			}

			$('#approved-order-btn').on('click', function(){
				swal({
					title: "Confirm?",
					text: "Are you sure you want to approved this order?",
					type: "warning",
					showCancelButton: true,
					confirmButtonText: 'Yes, Approved',
					cancelButtonText: 'Cancel'
				}, function() {
					submitModification('approved_order_form');
				});
			});

			function submitModification(frmId){
				$('#loader').removeClass('hide');
				formData = $("#"+frmId).serialize();

				$.ajax({
					url: '<?= site_url().'users/submitModification'; ?>',
					type: 'POST',
					data: formData,
					dataType: 'json',		                
					success: function(result) {
						$('#loader').addClass('hide');
						if(result.status == 0){
							swal({
								title: "Error",
								text: result.message,
								type: "error"
							}, function() {
								window.location.reload();
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
							if(frmId == 'approved_order_form'){
								window.location.href = '<?php echo base_url().'orderCompleted/'.$order['id']; ?>';
							}else{
								swal({
									title: "Success",
									text: result.message,
									type: "success"
								}, function() {								
									window.location.reload();
								});	
							}							
						}		                    
					},
					error: function(xhr, status, error) {
						swal({
							title: "Error",
							text: "Something is wrong.",
							type: "error"
						}, function() {
							window.location.reload();
						});
					}
				});
			}	
		}	

		/* End Code For Submit Request Modification & Approved Order */

		/* Start Code For Submit Review & Rating */
		function giveRating(){
			$('#loader').removeClass('hide');
			formData = $("#order_service_review_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/submitReviewRating'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});
		}
		/* End Code For Submit Review & Rating */

		/* Start Code For Dispute Order */

		function disputeOrder(){
			$('#loader').removeClass('hide');
			formData = $("#order_dispute_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/orderDispute'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						$('#order_dispute_modal').modal('hide');
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});
		}
		/* End Code For Dispute Order */

		/* Start Code For Dispute Order */

		function cancelOrder(){
			$('#loader').removeClass('hide');
			formData = $("#order_cancel_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/orderCancel'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});
		}
		/* End Code For Dispute Order */

		function toggleOrderReq(){
			$("#requirement-div").slideToggle(); // Toggle the visibility with sliding effect
		    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
		}

		function toggleOrderCreated(){
			$("#order-created-div").slideToggle(); // Toggle the visibility with sliding effect
		    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
		}

		function toggleTrackOrder(){
			$("#track-order-div").slideToggle(); // Toggle the visibility with sliding effect
		    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
		}

		function openChat(){
			get_chat_onclick(<?php echo $service['user_id'];?>, <?php echo $service['id'];?>);
			showdiv();
		}

		$('#modification-btn').on('click', function (){
			$('#modification-div').show();
		});

		function handleStarClick(index) {
			const allStar = document.getElementsByClassName('star');
			const ratingValue = document.querySelector('.rating input');

			if (allStar && ratingValue) {
				ratingValue.value = index + 1;

				for (let i = 0; i < allStar.length; i++) {
					allStar[i].classList.remove('active');
				}

				for (let i = 0; i <= index; i++) {
		            allStar[i].classList.add('active');  // Mark as active
		        }
		    } else {
		    	console.error('Rating stars or input element not found.');
		    }

		    const activeStars = document.getElementsByClassName('star active').length;
		    $('#ratingValue').val(activeStars);        
		}

		function accept_decision(id) {
			// if (confirm("Are you sure you want to approve this request cancellation?")) {
			// 	$.ajax({
			// 		type:'POST',
			// 		url:site_url+'users/approve_decision/'+id,
			// 		dataType: 'JSON',
			// 		success:function(resp){
			// 			if(resp.status==1) {
			// 				location.reload();
			// 			}
			// 		} 
			// 	});
			// } 

			$('#loader').removeClass('hide');
			formData = $("#order_cancel_decline_form").serialize();

			$.ajax({
				url:site_url+'users/approve_decision/'+id,
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});		
		}
		
		function withdraw_request(id) {
			$('#loader').removeClass('hide');
			
			$.ajax({
				url:site_url+'users/withdraw_request/'+id,
				type: 'POST',
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});		
		}

		function decliensss() {
			$('#order_decision_modal').modal('hide');
			$('#decline_request_modal').modal('show');
		}

		function declineOrder(){
			$('#loader').removeClass('hide');
			formData = $("#order_cancel_decline_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/declineCancel'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader').addClass('hide');
					if(result.status == 0){
						swal({
							title: "Error",
							text: result.message,
							type: "error"
						}, function() {
							window.location.reload();
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
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
	                // Handle error
				}
			});
		}

		function orderSubmit(){
			formData = $("#order_submit_form").serialize();
			var orderId = $('#orderId').val();
			$.ajax({
				url: '<?= site_url().'users/submitProject'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					$('#loader3').addClass('hide');
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
						$('#order_submit_modal').modal('hide');
						swal({
							title: "Success",
							text: result.message,
							type: "success"
						}, function() {
							window.location.reload();
						});
					}		                    
				},
				error: function(xhr, status, error) {
					swal({
						title: "Error",
						text: "There was an error submitting your order: " + error,
						type: "error"
					});
				}
			});
		}

		function uploadImageForDispute(id) {
      var formData = new FormData($('#order_dispute_form')[0]);

      $.ajax({
         url: '<?= base_url() ?>Order_dispute/add_dispute_files',
         type: 'POST',
         cache: false,
         contentType: false,
         processData: false,
         data: formData,
         dataType: 'json',
         success: function(res) {            
            if (res.status == 1){               
               $(`#dispute-file-upload-input-`+id).val('');
               for(let i =0 ; i < res.files.length; i++){
                  let fileData = res.files[i];
                  let html = `<tr>
                                 <td>${fileData.original_name}</td>
                                 <td>${fileData.size}</td>
                                 <td><button onclick="$(this).parent('td').parent('tr').remove()" type="button" class="btn btn-default" style=" padding: 1px 11px;">Delete</button></td>
                                 <input type="hidden" name="file_name[]" value="${fileData.name}">
                                 <input type="hidden" name="file_original_name[]" value="${fileData.original_name}">
                              </tr>`;
                     $('.disputeUploadFilesHtml'+id).append(html)
               }
            } else {
               swal({
                  html: true,
                  title: res.message,
                  type: "warning"
               });
            }
         }
      });
      return false;
   }
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.min.js"></script>
	
