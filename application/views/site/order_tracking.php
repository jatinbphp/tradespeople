	<?php
	include 'include/header.php';
	$get_commision = $this->common_model->get_commision();

	function ordinal($number) {
		$suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
		if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
			return $number . 'th';
		} else {
			return $number . $suffixes[$number % 10];
		}
	}

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
			width: 95%;
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
			/*padding-top: 6px;*/
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
														<?php if($order['status'] == 'offer_created'):?>
															<span>
																<h4 style="color: #000;">Your custom offer is now created</h4>
																<span class="text-muted">
																	You should respond by <b class="text-b"><?php echo $delivery_date; ?></b>
																	<br>
																	We notified <?php echo $tradesman['trading_name']; ?> about your respond.
																</span>
															</span>
														<?php else:?>
															<?php if(empty($requirements) && $order['is_cancel'] == 0):?>
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

																			<?php if($order['is_exten_delivery_accepted'] == 1):?>
					                              You should receive your delivery by <b class="text-b"><?php echo $expected_delivery_date; ?></b>
					                            <?php else:?>
					                              You should receive your delivery by <b class="text-b"><?php echo $delivery_date; ?></b>
					                            <?php endif;?>																			
																		</span>
																	</span>
																<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == 1):?>	
																	<span>
																		<h4 style="color: #000;">Your order has been cancelled</h4>
																		<?php if($order['is_custom'] == 0 || $order['is_accepted'] == 1):?>
																			<span class="text-muted">
																				Your payment has been creadited to your Tradespeople Wallet and can be used or refunded at any time.
																			</span>
																		<?php endif; ?>
																	</span>
																<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == 2):?>	
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
														<?php endif;?>
													</span>
													<span class="pull-right">
														<?php if($this->session->userdata('type')==1):?>
															<?php if($order['status'] == 'request_modification'):?>
																<?php if($order['is_custom'] == 1):?>
																	<?php if($order['order_type'] == 'single'):?>
																		<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Re-deliver Work</button>
																	<?php endif;?>
																<?php else:?>	
																	<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Re-deliver Work</button>
																<?php endif; ?>
															<?php endif; ?>

															<?php if($order['status'] == 'active' && $is_extended == 0):?>	
																<?php if($order['is_custom'] == 1):?>
																	<?php if($order['order_type'] == 'single'):?>
																		<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Deliver Work</button>
																	<?php endif;?>
																<?php else:?>	
																	<button type="button" class="btn btn-warning " data-id="<?php echo $order['user_id']?>" data-toggle="modal" data-target="#order_submit_modal">Deliver Work</button>
																<?php endif; ?>	
															<?php endif; ?>

															<?php if($order['status'] == 'disputed' || $order['is_cancel'] == 8):?>
																<a href="<?php echo base_url().'order-dispute/'.$order['id']?>">
																	<button type="button" class="btn btn-outline-warning ">View Dispute</button>
																</a>
															<?php endif; ?>

															<?php if($order['status'] == 'completed'):?>
																<a href="<?php echo base_url('orderCompleted/'.$order['id']); ?>">
																	<button type="button" class="btn btn-warning">
																		View Review 
																	</button>
																</a>
															<?php endif; ?>

															<button type="button" class="btn btn-outline-warning" data-id="<?php echo $order['user_id']?>" onclick="openChat(<?php echo $order['user_id']?>)">Chat</button>

															<?php if($is_extended == 1 && in_array($order['status'], ['active','extened_decline'])):?>
																<button type="button" class="btn btn-warning" id="extendedDelivery">
																	Extend Delivery Time
																</button>
															<?php endif; ?>															
														<?php else: ?>
															<?php if($order['status'] == 'disputed' || $order['is_cancel'] == 8):?>
																<a href="<?php echo base_url().'order-dispute/'.$order['id']?>">
																	<button type="button" class="btn btn-outline-warning">View Dispute</button>
																</a>
															<?php endif; ?>

															<?php if($order['status'] == 'completed'):?>
																<a href="<?php echo base_url('orderCompleted/'.$order['id']); ?>">
																	<button type="button" class="btn btn-warning">
																		View Review
																	</button>
																</a>	
															<?php endif; ?>
															<button class="btn btn-outline-warning" data-id="<?php echo $service['user_id']?>" onclick="openChat(<?php echo $service['user_id']?>)">
																Chat
															</button>

															<?php if($order['status'] == 'offer_created'):?>
																<?php if($order['is_accepted'] == 1 && empty($requirements)):?>
																	<button class="btn btn-warning" class="openRequirementModal btn btn-warning" data-toggle="modal" data-target="#order_requirement_modal">Submit Requirement</button>
																<?php endif; ?>
															<?php else: ?>
																<?php if(empty($requirements) && $order['is_cancel'] == 0):?>
																	<button class="btn btn-warning" class="openRequirementModal btn btn-warning" data-toggle="modal" data-target="#order_requirement_modal">Submit Requirement</button>
																<?php endif; ?>
															<?php endif; ?>
														<?php endif; ?>
													</span>										
												</div>									
											</div>
										</div>
									</div>
									<div class="timeline-div bg-white p-4">
										<ol class="timeline">
											<?php if(in_array($order['status'], ['active','offer_created','extened_request'])):?>
												<li class="timeline-item">
													<span class="timeline-item-icon | faded-icon">
														<i class="fa fa-clock-o faicon"></i>
													</span>
													<div class="timeline-item-description">
														<?php if(!empty($order['extended_date']) && !empty($order['extended_time']) && $order['is_exten_delivery_accepted'] == 0):?>
															<h5>Delivery time extension requested</h5>
															<h5>Expected <?php echo $order['is_custom'] == 0 && $order['is_accepted'] == 0 ? 'delivery' : 'response'; ?>  <?php echo $expected_delivery_date; ?></h5>
														<?php elseif($order['is_exten_delivery_accepted'] == 1):?>
															<h5>Expected <?php echo $order['is_custom'] == 0 && $order['is_accepted'] == 0 ? 'delivery' : 'response'; ?>  <?php echo $expected_delivery_date; ?></h5>
														<?php else:?>
															<h5>Expected <?php echo $order['is_custom'] == 0 && $order['is_accepted'] == 0 ? 'delivery' : 'response'; ?>  <?php echo $delivery_date; ?></h5>
														<?php endif;?>
														
														<ul class="delivery-time">
															<li><b><?php echo $rDays; ?></b><br/>Days</li>
															<li><b><?php echo $rHours; ?></b><br/>Hours</li>
															<li><b><?php echo $rMinutes; ?></b><br/>Minutes</li>
														</ul>
														
													</div>
												</li>
											<?php endif;?>

											<?php if($order['is_custom'] == 1 && $order['order_type'] == 'milestone' && !empty($milestones)): ?>
												<li class="timeline-item" id="milestoneList">
													<span class="timeline-item-icon | faded-icon">
														<i class="fa fa-clock-o faicon"></i>
													</span>
													<div style="max-width: 100%;">
														<h4>Created Milestones</h4>
														<div class="">
															<table class="table milestoneTable table-responsive nowrap">
																<thead>
																	<th>Milestone Name</th>
																	<th>Delivery Date</th>
																	<th><?php echo $milestones[0]['price_per_type']; ?></th>
																	<th>Description</th>
																	<th>Amount</th>
																	<th>Status</th>
																	<?php if($this->session->userdata('type')==1):?>
																		<th>Action</th>
																	<?php endif; ?>	
																</thead>
																<tbody>
																	<?php foreach($milestones as $list):?>
																		<tr>
																			<td><?php echo $list['milestone_name']; ?></td>
																			<td>
																				<?php
																					$days = $list['delivery'];
																					$currentDate = new DateTime($list['cdate']);
																					$currentDate->modify("+$days days");
																					$milestone_delivery_date = $currentDate->format('jS F, Y');	
																					echo $milestone_delivery_date;
																				?>																				
																			</td>
																			<td><?php echo $list['quantity']; ?></td>
																			<td>
																				<?php 
																					$totalDescriptionChr = strlen($list['description']);
																					if($totalDescriptionChr > 50){
																						echo substr($list['description'], 0, 50).'...';
																					}else{
																						echo $list['description'];
																					}
																				?>
																			</td>
																			<td><?php echo '£'.number_format($list['total_amount'],2); ?></td>
																			<td><?php echo $list['service_status']; ?></td>
																			<td>
																				<?php if($this->session->userdata('type')==1):?>
																					<?php if(!empty($requirements) && $order['is_cancel'] == 0):?>
																						<?php if(!in_array($list['service_status'],['delivered','request_modification','completed','offer_created'])):?>
																							<button type="button" class="btn btn-warning btn-sm milestoneBtn" data-id="<?php echo $order['user_id']?>" data-mId="<?php echo $list['id']; ?>">
																								Deliver Work
																							</button>
																						<?php elseif($list['service_status'] == 'request_modification'):?>	
																							<button type="button" class="btn btn-warning milestoneBtn" data-id="<?php echo $order['user_id']?>" data-mId="<?php echo $list['id']; ?>" >Re-deliver Work</button>
																						<?php elseif($list['service_status'] == 'completed'):?>	
																							<span class="text-info">Completed</span>
																						<?php elseif($list['service_status'] == 'offer_created'):?>	
																							<span class="text-info">Awaiting Response</span>
																						<?php else:?>
																							<span class="text-info">Delivered</span>
																						<?php endif;?>
																					<?php else:?>
																							<span class="text-info">Awaiting Requirement</span>
																					<?php endif;?>
																				<?php else: ?>
																					<!--<button type="button" class="btn btn-warning btn-sm" data-id="<?php echo $order['user_id']?>">View Work</button>-->
																				<?php endif; ?>	
																			</td>
																		</tr>
																		<?php if(!empty($list['order_submit_conversation']) && count($list['order_submit_conversation']) > 0):?>
																			<tr>
																				<?php
																					$colspan = 6;
																				?>	
																				<td colspan="6" class="pl-0">
																					<h6 class="mt-1 mb-0" style="width:100%; cursor:pointer" onclick="togglemilestoneDeliveryData(<?php echo $list['id']?>);"> 
																	          <b><?php echo ordinal($list['milestone_level']);?> Milestone Delivery</b>
																	          <i class="fa fa-angle-down pull-right"></i>
																	        </h6>
																	        <div class="mt-4" id="milestoneDeliveryData_<?php echo $list['id']?>" style="width: 100%; border-top: 1px solid #eee;">
																						<?php include 'milestone_tracking_timeline.php'; ?>	
																					</div>
																				</td>
																			</tr>
																		<?php endif;?>	
																	<?php endforeach;?>
																</tbody>
															</table>
														</div>

														<?php if($order['is_custom'] == 1 && $order['is_accepted'] == 0):?>
															<?php if($this->session->userdata('type')==1):?>
																<div id="approved-btn-div">
																	<button type="button" id="withdraw-offer-btn" class="btn btn-default">
																		Withdraw Offer
																	</button>
																</div>
															<?php else: ?>
																<div id="approved-btn-div">
																	<button type="button" id="accept-offer-btn" class="btn btn-warning mr-3">
																		Accept
																	</button>
																	<button type="button" id="reject-offer-btn" class="btn btn-default">
																		Reject
																	</button>
																</div>
															<?php endif; ?>
														<?php elseif($this->session->userdata('type') == 2 && !empty($order['extended_date']) && !empty($order['extended_time']) && $order['is_exten_delivery_accepted'] == 0):?>
																<div id="approved-btn-div">
																	<button type="button" id="accept-extended-btn" class="btn btn-warning mr-3">
																		Accept
																	</button>
																	<button type="button" id="reject-extended-btn" class="btn btn-default">
																		Decline
																	</button>
																</div>
														<?php endif; ?>	

													</div>
													
													
												</li>
											<?php endif; ?>

											<?php
												if($order['is_custom'] == 0 || $order['is_custom'] == 1 && $order['order_type'] == 'single' ){
													include 'order_tracking_timeline.php';
												}
											?>

											<?php if(!empty($delivery_date)):?>
												<?php if($order['is_custom'] == 0):?>
													<li class="timeline-item">
														<span class="timeline-item-icon | faded-icon">
															<i class="fa fa-file-text-o faicon" aria-hidden="true"></i>
														</span>
														<div class="timeline-item-description">
															<?php if($order['is_exten_delivery_accepted'] == 1):?>
																<h5>Your delivery data was updated to <?php echo $expected_delivery_date; ?></h5>
															<?php else:?>
																<h5>Your delivery data was updated to <?php echo $delivery_date; ?></h5>
															<?php endif;?>
														</div>
													</li>
												<?php endif;?>
												<li class="timeline-item | extra-space">
													<span class="timeline-item-icon | filled-icon ">
														<i class="fa fa-paper-plane faicon" aria-hidden="true"></i>
													</span>
													<div class="timeline-item-wrapper">
														<div class="timeline-item-description">
															<h5>
																<?php echo $order['is_custom'] == 1 ? 'Offer Sent' : 'Order Started'; ?>
															</h5>
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
														<?php if($order['is_custom'] == 1 && empty($requirements)):?>
															Order Requirement Requested
														<?php else: ?>	
															Order Requirement Submitted
															<i class="fa fa-angle-down pull-right"></i>
														<?php endif;?>
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
																			<div class="col-md-4 pr-3 pl-3">
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
														<?php echo $order['is_custom'] == 1 ? 'Offer Created' : 'Order Created'; ?>
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
										<div class="row ml-0 mr-0" style="border-bottom:1px solid #f1f1f1; ">
											<div class="col-md-12 pl-0">
												<h4 class="mt-1"><?php echo $service['service_name']; ?></h4>
											</div>
											<?php if(!empty($description)):?>
												<div class="col-md-12 p-3" style="border: 1px solid #eee;">
													<?php echo $description; ?>
												</div>
											<?php endif?>
										</div>
										<div class="row pt-4 ml-0 mr-0" <?php if(!empty($attributes) && !empty($order['offer_includes_ids']) || !empty($order['ex_services'])):?> style="border-bottom:1px solid #f1f1f1;" <?php endif;?> >
											<div class="col-md-12 pl-0">
												<?php if(!empty($attributes) && !empty($order['offer_includes_ids'])): ?>
													<b>Offer Includes</b>
													<ul class="pl-4">
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
														<ul class="pl-4">
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
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-md-12">
												<table class="table table-striped">
													<thead class="bg-gray">
														<?php if($order['is_custom'] == 1 && $order['order_type'] == 'milestone' && !empty($milestones)): $i=0;?>
															<?php foreach($milestones as $list): $i++; ?>
																<tr>
																	<th colspan="2"><?php echo ordinal($i); ?> Milestone</th>
																</tr>
																<!--<tr>
																	<th>Milestone Name</th>
																	<th class="text-right"><?php echo $list['milestone_name']; ?> </th>
																</tr>-->
																<tr>
																	<th class="font-12">Price</th>                     
																	<th class="text-right font-12">
																		<?php echo '£'.number_format($list['milestone_amount'],2); ?><?php echo !empty($list['price_per_type']) ? '/'.$list['price_per_type'] : ''; ?>
																	</th>
																</tr>
																<tr>
																	<th class="font-12">Duration</th>
																	<th class="text-right font-12">
																		<?php echo $list['delivery'].' Days'; ?>
																	</th>
																</tr>
																<tr>
																	<th class="font-12">Total no. of <?php echo !empty($list['price_per_type']) ? $list['price_per_type'] : ''; ?></th>
																	<th class="text-right font-12">
																		<?php echo $list['quantity']; ?>
																	</th>
																</tr>
																<tr>
																	<th class="font-12">Sub Total</th>                     
																	<th class="text-right font-12">
																		<?php echo '£'.number_format($list['total_amount'],2); ?>
																	</th>
																</tr>
															<?php endforeach; ?>
														<?php else: ?>
															<tr>
																<th>Price</th>                     
																<th class="text-right">
																	<?php
																		$servicePrice = $order['price'];
																		if($order['is_custom'] == 1 && $order['order_type'] == 'single'){
																			$servicePrice = $order['price'] / $order['service_qty'];
																		}
																	?>
																	<?php echo '£'.number_format($servicePrice,2); ?><?php echo !empty($order['price_per_type']) ? '/'.$order['price_per_type'] : ''; ?>
																</th>
															</tr>

															<tr>
																<th>Duration</th>                     
																<th class="text-right">
																	<?php echo $duration.' Days'; ?>
																</th>
															</tr>

															<tr>
																<th>Total no. of <?php echo !empty($order['price_per_type']) ? $order['price_per_type'] : ''; ?></th>
																<th class="text-right">
																	<?php echo $order['service_qty']; ?>
																</th>
															</tr>

															<tr>
																<th>Sub Total</th>                     
																<th class="text-right">
																	<?php 
																		$subTotal = $order['total_price'] - $order['service_fee'];
																		echo '£'.number_format($subTotal,2); 
																		?>
																</th>
															</tr>
														<?php endif; ?>	
														<?php if($this->session->userdata('type')==2):?>
														<tr>
															<th>Service Fee</th>
															<th class="text-right">
																<?php echo '£'.number_format($order['service_fee'],2); ?>
															</th>
														</tr>
													<?php endif; ?>
														<tr>
															<th>Total</th>                     
															<th class="text-right">
																<?php if($this->session->userdata('type')==2):?>
																	<?php echo '£'.number_format($order['total_price'],2); ?>
																<?php else:?>	
																	<?php echo '£'.number_format($order['total_price']-$order['service_fee'],2); ?>
																<?php endif;?>
															</th>
														</tr>
													</thead>
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
												<?php if($order['is_custom'] == 1 && $order['order_type'] == 'milestone' && !empty($milestones)): ?>
													<?php foreach($milestones as $list):?>
														<?php if(!empty($list['order_submit_conversation']) && count($list['order_submit_conversation']) > 0):?>
															<h4 class="mt-1 mb-0"> 
											          <b><?php echo ordinal($list['milestone_level']);?> Milestone Delivery</b>
											        </h4>
											        <div class="mt-4">
																<?php include 'milestone_tracking_timeline.php'; ?>	
															</div>
														<?php endif; ?>	
													<?php endforeach;?>
												<?php else: ?>	
													<?php include 'order_tracking_timeline.php'; ?>
												<?php endif; ?>
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
													<?php if(!in_array($order['status'], ['disputed','placed','pending','active']) || in_array($order['status'],[ 'delivered', 'request_modification'])):?>
														<li>
															<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_dispute_modal">Dispute</a>
														</li>
													<?php endif; ?>
													<?php if(!in_array($order['status'], ['request_modification', 'delivered', 'disputed'])):?>
														<li style="margin-top: 0;"><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_cancel_modal">Order Cancellation</a></li>	
													<?php endif; ?>
												</ul>
											</div>
										<?php else: ?>
											<?php if(!in_array($order['status'], ['cancelled','completed'])):?>
												<div class="ellipsis-btn">
													<button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
													</button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<?php if(!in_array($order['status'], ['disputed','placed','pending','active']) || in_array($order['status'], ['delivered', 'request_modification'])):?>
															<li>
																<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_dispute_modal">Dispute</a>
															</li>
														<?php endif; ?>
														<?php if(!in_array($order['status'], ['request_modification', 'delivered', 'disputed'])):?>
															<li style="margin-top: 0;"><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_cancel_modal">Order Cancellation</a></li>
														<?php endif; ?>
													</ul>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									</div>

									<div class="summary-feature-article">
										<a href="<?php echo base_url().'service/'.$service['slug']?>">
											<?php 
												$image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); 
												$mime_type = get_mime_by_extension($image_path);
				                $is_image = strpos($mime_type, 'image') !== false;
				                $is_video = strpos($mime_type, 'video') !== false;
											?>
											<?php if (file_exists($image_path) && $service['image']): ?>
												<?php if ($is_image): ?>
													<img src="<?php echo base_url('img/services/') . $service['image']; ?>" class="img-responsive">
												<?php else: ?>
													<video width="80" controls autoplay><source src="<?php echo base_url('img/services/') . $service['image']; ?>" type="video/mp4">Your browser does not support the video tag.</video>
												<?php endif; ?>
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
													<?php if($order['status'] == 'offer_created'):?>
														Awaiting Response
													<?php else: ?>
														<?php if($this->session->userdata('type')==1):?>
															<?php if(empty($requirements) && count($all_conversation) == 0):?>
																Awaiting Requirement 
															<?php else: ?>
																<?php if($order['status'] == 'active'):?>
																	In Progress
																<?php elseif($order['status'] == 'request_modification'):?>
																	Revision
																<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '2'):?>
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
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '2'):?>
																Cancellation pending
															<?php elseif($order['status'] == 'cancelled' && $order['is_cancel'] == '1'):?>
																Cancelled
															<?php else: ?>	
																<?php echo ucfirst(str_replace('_', ' ', $order['status'])) ?>
															<?php endif; ?>
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
											<p>
												<b>
													<?php if($this->session->userdata('type')==2):?>
														<?php echo '£'.number_format($order['total_price'],2); ?>
													<?php else:?>	
														<?php echo '£'.number_format($order['total_price']-$order['service_fee'],2); ?>
													<?php endif;?>	
												</b>
											</p>
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

              <div class="from-group">
                <label class="control-label" for="textinput"><b>Select the milestone you want to dispute</b></label><br>
                <?php
                	$get_milestones_notpaid=$this->common_model->get_milestones_notpaid($mile['post_id']);
                 	foreach($milestones as $m){ ?>
                 		<input data-amount="<?php echo $m['total_amount']; ?>" class="dispute_milestones" type="checkbox" onchange="selectMilesForDispute(this,<?php echo $order['id']; ?>)" name="milestones[]" <?php if($mile['id']==$m['id']){ ?>checked<?php } ?> value="<?php echo $m['id']; ?>"> <?php echo $m['milestone_name']; ?><br>
                <?php } ?>
              </div>

							<label class="control-label mt-4" for="textinput"><b>Total Amount In dispute: <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $order['id']; ?>"><?php echo $order['price']*$order['service_qty']; ?></span></b></label>

							<label class="control-label" for="textinput"><b>Offer the amount you are prepared to pay:</b></label>

							<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
                <input type="number" id="offer_amount<?php echo $order['id']; ?>" required="" min="0" name="offer_amount" max="<?php echo $order['price']*$order['service_qty']; ?>" class="form-control" placeholder="Amount">
             	</div>

             	<p>Please enter an amount between <i class="fa fa-gbp"></i>0 to <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $order['id']; ?>"><?php echo $order['price']*$order['service_qty']; ?></span>.</p>

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

							
							<div class="from-group">
								<label class="control-label" for="textinput"><b>Select the milestone you want to cancel</b></label><br>
								<?php
									$get_milestones_notpaid=$this->common_model->get_milestones_notpaid($mile['post_id']);
									foreach($milestones as $m){ ?>
										<input data-amount="<?php echo $m['total_amount']; ?>" class="cancellation_milestones" type="checkbox" onchange="selectMilesForCancel(this,<?php echo $order['id']; ?>)" name="milestones[]" <?php if($mile['id']==$m['id']){ ?>checked<?php } ?> value="<?php echo $m['id']; ?>"> <?php echo $m['milestone_name']; ?><br>
								<?php } ?>

								<br>
								<p>Total amount to cancel: <span class="totalCancellation<?php echo $order['id']; ?>"><i class="fa fa-gbp"></i> 0</span></p>
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
						<input type="hidden" name="milestoneId" id="milestoneId" value="0">
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

	<div class="modal fade" id="extendedDeliveryModal" tabindex="-1" role="dialog" aria-labelledby="sellerAvailabilityTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="modal-body">
					<h3 class="sharing-title" style="margin-top:0!important">Extened Delivery Time</h3>
					<div class="sharing-description">
						<p>Choose your date & time</p>
					</div>

					<div class="order-hourlie-addons-sidebar p-0" id="sellerAvailability">
						<div id="datepickerAvailability"></div>
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
					</div>
					<input type="hidden" id="packageType">
					<input class="btn btn-warning btn-lg col-md-12 mt-4" type="button" id="extenedBtn" value="Submit">
				</div>
			</div>											
		</div>
	</div>
</div>

	<?php include 'include/footer.php'; ?>

	<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
	<script>
		$(document).ready(function () {
			$('#milestoneDataTable').DataTable({
	      paging: false,
        searching: false,
        ordering: false,
        info: false,
	      responsive: true,
	      columnDefs: [
            { width: "10%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "10%", targets: 2 },
            { width: "30%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "10%", targets: 5 },
        ]
	    });

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

		if(el1 && el1.length > 0){
			console.log('inini');
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

			$('.approved-order-btn').on('click', function(){
				var cId = $(this).data('id');
				swal({
					title: "Confirm?",
					text: "Are you sure you want to approved this order?",
					type: "warning",
					showCancelButton: true,
					confirmButtonText: 'Yes, Approved',
					cancelButtonText: 'Cancel'
				}, function() {
					submitModification('approved_order_form_'+cId);
				});
			});

			/*function submitModification(frmId){
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
							//if(frmId == 'approved_order_form'){
							if(result.is_review == 1){
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
			}*/

			function submitModification(frmId) {
			    // Show the loader
			    $('#loader').removeClass('hide');

			    // Get the form element
			    var form = $("#" + frmId);
			    
			    if (frmId.startsWith('request_modification_form_')) {
			    	form.find(".error-message").remove();
		        // Validation for Request Modification Form
		        var isValid = true;

		        var description = form.find("textarea[name='modification_decription']");
		        if (description.val().trim() === "") {
		            isValid = false;
		            description.after("<span class='error-message' style='color: red;'>Modification description is required.</span>");
		        }

		        var fileInput = form.find("input[name='modification_attachments']");
		        if (fileInput.length && fileInput[0].files.length === 0) {
		            isValid = false;
		            var fileInputDiv = form.find(".addWorkImage1");
		            fileInputDiv.after("<span class='error-message' style='color: red;'>Please upload at least one image.</span>");
		        }

		        if (!isValid) {
		            $('#loader').addClass('hide');
		            return;
		        }
			    }

			    // If validation passed, proceed with AJAX submission
			    var formData = new FormData(form[0]); // Use FormData for file uploads

			    $.ajax({
		        url: '<?= site_url().'users/submitModification'; ?>',
		        type: 'POST',
		        data: formData,
		        processData: false, // Required for file uploads
		        contentType: false, // Required for file uploads
		        dataType: 'json',
		        success: function (result) {
		            $('#loader').addClass('hide');
		            if (result.status == 0) {
		                swal({
		                    title: "Error",
		                    text: result.message,
		                    icon: "error"
		                }, function () {
		                    window.location.reload();
		                });
		            } else if (result.status == 2) {
		                swal({
		                    title: "Login Required!",
		                    text: "If you want to order, please login first!",
		                    icon: "warning"
		                }, function () {
		                    window.location.href = '<?php echo base_url().'login'; ?>';
		                });
		            } else {
		                if (result.is_review == 1) {
		                    window.location.href = '<?php echo base_url().'orderCompleted/'.$order['id']; ?>';
		                } else {
		                    swal({
		                        title: "Success",
		                        text: result.message,
		                        icon: "success"
		                    }, function () {
		                        window.location.reload();
		                    });
		                }
		            }
		        },
		        error: function (xhr, status, error) {
		            $('#loader').addClass('hide');
		            swal({
		                title: "Error",
		                text: "Something went wrong.",
		                icon: "error"
		            }, function () {
		                window.location.reload();
		            });
		        }
		    });
			}
		}	

		$('#reject-offer-btn').on('click', function(){
			swal({
				title: "Confirm?",
				text: "Are you sure you want to reject this offer?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: 'Yes, Reject',
				cancelButtonText: 'Cancel'
			}, function() {
				cancelOffer();
			});
		});

		$('#withdraw-offer-btn').on('click', function(){
			swal({
				title: "Confirm?",
				text: "Are you sure you want to withdraw this offer?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: 'Yes, Withdraw',
				cancelButtonText: 'Cancel'
			}, function() {
				cancelOffer();
			});
		});

		$('#accept-offer-btn').on('click', function(){
			swal({
				title: "Confirm?",
				text: "Are you sure you want to accept this offer?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: 'Yes, Accept',
				cancelButtonText: 'Cancel'
			}, function() {
				window.location.href = '<?php echo base_url().'serviceCheckout?offer='.substr($order['order_id'],1); ?>';
				acceptOffer();
			});
		});

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

		/* Start Code For Cancel Order */
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
		/* End Code For Cancel Order */

		/* Start Code For Cancel Offer */
		function cancelOffer(){
			$('#loader').removeClass('hide');
			formData = $("#order_cancel_form").serialize();

			$.ajax({
				url: '<?= site_url().'users/offerCancel'; ?>',
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
		/* End Code For Cancel Offer */

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

		function togglemilestoneDeliveryData(id){
			$("#milestoneDeliveryData_"+id).slideToggle(); // Toggle the visibility with sliding effect
		    $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
		}

		function openChat(uId){
			get_chat_onclick(uId, <?php echo $service['id'];?>);
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
			swal({
				title: "Accept Request",
				text: "Are you sure you want to accept cancellation request for this order?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: 'Yes, Accept',
				cancelButtonText: 'Cancel'
			}, function() {
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
			});	
		}
		
		function withdraw_request(id) {
			swal({
				title: "Withdraw Request",
				text: "Are you sure you want to withdraw cancellation request for this order?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: 'Yes, Withdraw',
				cancelButtonText: 'Cancel'
			}, function() {
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

	$('.milestoneBtn').on('click', function(){
   	var mId = $(this).data('mid');
   	$('#milestoneId').val(mId);
   	$('#order_submit_modal').modal('show');
  });

  $('#extendedDelivery').on('click', function(){
  	$('#extendedDeliveryModal').modal('show');  		
  });

  $('#extenedBtn').on('click', function(){
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
  		var date = $('#selectedDates').val();
  		var time = $('#timeSlot').val();
  		var oId = <?php echo $order['id'];?>;

  		$.ajax({
  			url: "<?= site_url().'users/extenedTime'; ?>", 
  			data: {ex_date:date,ex_time:time,oId:oId}, 
  			type: "POST", 
  			dataType: 'json',
  			success: function (data) {
  				if (data.status == 1) {
  					window.location.reload();
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
  	}
  });

  $('#accept-extended-btn').on('click', function(){
  	acceptExtenedTime(1);
	});

	$('#reject-extended-btn').on('click', function(){
  	acceptExtenedTime(2);
	});

	function acceptExtenedTime(exType){
		if(exType == 1){
			var exTitle = 'Accept';
			var exTitle1 = 'accept';
		}else{
			var exTitle = 'Decline';
			var exTitle1 = 'decline';
		}		

		swal({
			title: "Confirm?",
			text: "Are you sure you want to "+exTitle1+" this extended time?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: 'Yes, '+exTitle,
			cancelButtonText: 'Cancel'
		}, function() {				
			var oId = <?php echo $order['id'];?>;
  		$.ajax({
  			url: "<?= site_url().'users/acceptExtenedTime'; ?>", 
  			data: {type:exType,oId:oId}, 
  			type: "POST", 
  			dataType: 'json',
  			success: function (data) {
  				if (data.status == 1) {
  					window.location.reload();
  				} else if (data.status == 2) {
  					swal({
  						title: "Login Required!",
  						text: "If you want to "+exTitle1+" this extended time then please login first!",
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
	}

	function selectMilesForDispute(e,id) {
		var mId = e.value;
		var total = 0;
		$('.dispute_milestones').each((index,item)=>{
			if($(item).is(':checked')){
				let amount = $(item).data('amount');
				total += amount;
			}
		})
		$('.totalDispute'+id).html(total);
		$('#offer_amount'+id).attr('max',total);
	}

  	function selectMilesForCancel(e,id){
		var mId = e.value;
		var total = 0;
		
		$('.cancellation_milestones').each((index,item)=>{
			if($(item).is(':checked')){
				let amount = $(item).data('amount');
				total += amount;
			}
		});

		console.log(total);

		$('.totalCancellation'+id).html('<i class="fa fa-gbp"></i>'+total);
	}

	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.min.js"></script>
	
