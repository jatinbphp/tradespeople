<?php
include 'include/header.php';
$get_commision = $this->common_model->get_commision();
?>
<style type="text/css">
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
	.boxImage img { height: 100%;object-fit: contain;}
	#imgpreview {
		padding-top: 15px;
	}
	.boxImage {
		margin: 0;
	}
	.imagePreviewPlus {
		height: 150px;
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
	
	.timeline-div{border-radius: 5px;}
	
	.faicon{
		font-size: 30px;
		color: #2875D7;
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
			background: #dddddd;
			margin: 0;
			list-style: none;
			display: flex;
			align-items: center;
			justify-content: space-around;
			border-radius: 10px;
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
							<?php if($order['status'] == 'completed'):?>
								<li>
									<a data-toggle="tab" href="#Rating">Review & Rating</a>
								</li>
							<?php endif;?>
						</ul>
					</div>
				</div>

				<div class="tab-content">
					<div id="Timeline" class="tab-pane fade active in">
						<div class="tradesmen-box mt-4">
							<div class="tradesmen-top" style="border-bottom:0">
								<div class="img-name">
									<a href="<?php echo base_url('service/'.$service['slug']); ?>">
										<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
										<?php if (file_exists($image_path) && $service['image']): ?>
											<img src="<?php echo  base_url().'img/services/'.$service['image']; ?>" style="border-radius: 0!important;">
										<?php else: ?>
											<img src="<?php echo  base_url().'img/default-image.jpg'; ?>" style="border-radius: 0!important;">
										<?php endif; ?>
									</a>
									<div class="names" style="width:100%">
										<span class="services-description">
											<a href="<?php echo base_url().'service/'.$service['slug']?>">
												<p>
													<?php
													$totalChr = strlen($service['description']);
													if($totalChr > 50 ){
														echo substr($service['description'], 0, 50).'...';		
													}else{
														echo $service['description'];
													}
													?>
													<?php echo '£'.number_format($order['total_price'],2); ?>
												</p>
											</a>
											<div class="ellipsis-btn">
												<button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
													<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
												</button>
												<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
													<li><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_dispute_modal">Dispute</a></li>
													<li><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#order_cancel_modal">Order Cancellation</a></li>
												</ul>
											</div>											
										</span>
										
										<span class="badge bg-dark p-2 pl-4 pr-4">
											<?php echo ucfirst(str_replace('_', ' ', $order['status'])) ?>
										</span>
										<span class="pull-right">
											<span class="mr-3" id="openChat" data-id="<?php echo $service['user_id']?>">Chat</span>
											<span class="openRequirementModal" data-toggle="modal" data-target="#order_requirement_modal">Submit Requirement</span>
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

								<?php if($order['status'] == 'delivered'):?>
									<li class="timeline-item">
										<span class="timeline-item-icon | faded-icon">
											<i class="fa fa-truck faicon"></i>
										</span>
										<div class="timeline-item-description">
											<h5>Here is you delivery</h5>
											<span class="delivery-conversation text-left">
												<?php echo $conversation['description']; ?>
											</span>
											<form id="approved_order_form" style="width:100%">
												<input type="hidden" name="order_id" value="<?php echo $order['id']?>">
												<input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
												<input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
												<input type="hidden" name="status" value="completed">
												<textarea rows="7" class="form-control" id="approve-decription" name="approve_decription"></textarea>
											</form>
											<div id="approved-btn-div">
												<button type="button" id="approved-btn" class="btn btn-warning mr-3" onclick="submitModification('approved_order_form');">
													Approve
												</button>
												<button type="button" id="modification-btn" class="btn btn-default">
													Request Modification
												</button>
											</div>
											<div id="modification-div" style="display:none;">
												<p>
													Lorem ipsum dolor sit amet . The graphic and typographic operators know this well, in reality all the professions dealing with the universe of communication have a stable relationship with these words, but what is it? Lorem ipsum is a dummy text without any sense.
												</p>
												<form id="request_modification_form">
													<input type="hidden" name="order_id" value="<?php echo $order['id']?>">
													<input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
													<input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
													<input type="hidden" name="status" value="request_modification">
													<textarea rows="7" class="form-control" id="modification-decription" name="modification_decription"></textarea>
													<div class="row">
														<div id="loader2" class="loader_ajax_small"></div>
														<div class="col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer1">
															<div class="file-upload-btn addWorkImage1 imgUp">
																<div class="btn-text main-label">Attachments</div>
																<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
																<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
																<input type="file" name="modification_attachments" id="modification_attachments">	
															</div>
														</div>
													</div>
													<input type="hidden" name="multiModificationImgIds" id="multiModificationImgIds">	
													<div class="row" id="previousModificationImg">
													</div>
													<div class="text-center">
														<button type="button" onclick="submitModification('request_modification_form')" class="btn btn-warning mr-3">
															Submit request
														</button>
													</div>
												</form>												
											</div>
										</div>
									</li>
									<!--<li class="timeline-item">
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
									</li>-->
								<?php endif;?>

								<?php if(!empty($all_conversation)):?>
									<?php foreach($all_conversation as $list):?>
										<li class="timeline-item">
											<span class="timeline-item-icon | faded-icon">
												<?php if($user['id'] == $list['sender']):?>
													<?php if($list['status'] == 'completed'):?>
														<i class="fa fa-check-square-o faicon"></i>
													<?php else:?>
														<i class="fa fa-edit faicon"></i>
													<?php endif;?>
												<?php else: ?>
													<i class="fa fa-truck faicon"></i>
												<?php endif; ?>	
											</span>
											<div class="timeline-item-description">
												<?php 
												$conDate = new DateTime($list['created_at']);
												$conversation_date = $conDate->format('D jS F, Y H:i');
												?>

												<?php if($user['id'] == $list['sender']):?>
													<h5>
														<?php if($list['status'] == 'completed'):?>
															You approved order
														<?php else:?>
															You requested a modification 
														<?php endif;?>		
														<span class="text-muted" style="font-size: 12px;">
															<i><?php echo $conversation_date ?></i>
														</span>
													</h5>
												<?php else: ?>
													<h5>
														<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
															<?php echo $tradesman['trading_name']; ?>
														</a>
														delivered your order 
														<span class="text-muted" style="font-size: 12px;">
															<i><?php echo $conversation_date ?></i>
														</span>
													</h5>
												<?php endif; ?>

												<span class="delivery-conversation text-left">
													<?php echo $list['description']; ?>
												</span>

												<?php 
												$conAttachments = $this->common_model->get_all_data('order_submit_attachments',['conversation_id'=>$list['id']])
												?>

												<?php if(!empty($conAttachments)):?>
													<h4 style="width: 100%;">Attachments</h4>
													<div class="row" style="width: 100%;" id="con_attachments">
														<?php foreach ($conAttachments as $con_key => $con_value): ?>
															<?php $image_path = FCPATH . 'img/services/' . ($con_value['attachment'] ?? ''); ?>
															<?php if (file_exists($image_path) && $con_value['attachment']):?>
																<div class="col-md-4 col-sm-6 col-xs-12">
																	<div class="boxImage imgUp">
																		<div class="imagePreviewPlus">
																			<img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/').$con_value['attachment']?>" alt="<?php echo $con_value['id']; ?>">
																		</div>
																	</div>
																</div>
															<?php endif; ?>
														<?php endforeach; ?>
													</div>
												<?php endif; ?>
											</div>
										</li>
									<?php endforeach;?>
								<?php endif;?>	

								<?php if($order['status'] == 'request_modification'):?>
									<!--<li class="timeline-item">
										<span class="timeline-item-icon | faded-icon">
											<i class="fa fa-edit faicon"></i>
										</span>
										<div class="timeline-item-description">
											<h5>Requested Modification</h5>
											<span class="delivery-conversation text-left">
												<?php echo $conversation['description']; ?>
											</span>											
										</div>
									</li>-->
								<?php endif;?>

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
						<div class="timeline-div bg-white p-5">
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
					<div class="timeline-div bg-white p-5">
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
					</div>
				</div>
				<div id="Delivery" class="tab-pane fade">
					<div class="timeline-div bg-white p-5" style="height:400px;">
						<div class="text-center">
							<img src="<?php echo base_url(); ?>img/delivery_icon.png" style="width: 20%;">
						</div>
						<?php if(!empty($delivery_date)):?>
							<div class="text-center">
								<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>">
									<?php echo $tradesman['trading_name'];?> 
								</a>
								should deliver this order by <?php echo $delivery_date; ?>
							</div>
						<?php else:?>
							<div class="text-center">
								<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>">
									<?php echo $tradesman['trading_name'];?>
								</a> 
								should deliver this order as soon as
							</div>
						<?php endif; ?>	
					</div>
				</div>
				<div id="Rating" class="tab-pane fade">
					<div class="timeline-div bg-white p-5">
						<div class="row pb-4 ml-0 mr-0" style="border-bottom:1px solid #f1f1f1; ">
							<div class="col-md-12 pl-0 text-center">
								<div class="member-summary">
									<div class="summary member-summary-section">
										<div class="member-image-container">
											<?php 
											if(isset($tradesman['profile']) && !empty($tradesman['profile'])){
												$uprofileImg = base_url('img/profile/'.$tradesman['profile']);
											}else{
												$uprofileImg = base_url('img/default-img.png');
											}
											$suserName = ($tradesman['f_name'] ?? '').' '.($tradesman['l_name'] ??  '');
											?>
											<img class="img-border-round member-image" src="<?php echo $uprofileImg;?>" alt="<?php echo $suserName;?>">
										</div>											
									</div>
								</div>
								<span class="mt-3">
									Based on your expectations, how would you rate the quality of this delivery?
								</span>
								<form class="mt-3" id="order_service_review_form" style="width:100%">
									<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
									<input type="hidden" name="service_id" value="<?php echo $order['service_id']; ?>">
									<input type="hidden" name="rate_to" value="<?php echo $tradesman['id']; ?>">
									<div class="rating">
										<input type="hidden" name="rating" id="ratingValue">
										<i class="fa fa-star star" style="--i: 0;" onclick="handleStarClick(0)"></i>
										<i class="fa fa-star star" style="--i: 1;" onclick="handleStarClick(1)"></i>
										<i class="fa fa-star star" style="--i: 2;" onclick="handleStarClick(2)"></i>
										<i class="fa fa-star star" style="--i: 3;" onclick="handleStarClick(3)"></i>
										<i class="fa fa-star star" style="--i: 4;" onclick="handleStarClick(4)"></i>
									</div>
									<div class="review-div">
										<textarea name="reviews" class="form-control" rows="5" placeholder="Your review..."></textarea>
									</div>
									<div class="btn-group mt-3">
										<button type="button" id="give-rating" class="btn btn-warning mr-3" onclick="giveRating();">
											Submit
										</button>											
									</div>
								</form>
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
					</div>
					<div class="modal-body form_width100">
						<div class="form-group">
							<label for="reason"> Reason of Dispute</label>
							<textarea rows="5" placeholder="" name="reason" id="reason" class="form-control"></textarea>
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
						<h4 class="modal-title">Cancel Order</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="form-group">
							<label for="reason"> Reason of Cancel</label>
							<textarea rows="5" placeholder="" name="reason" id="reason" class="form-control"></textarea>
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

<?php include 'include/footer.php'; ?>
<script>
	const el = document.getElementById('imageContainer1');
	if (el) {
		document.getElementById('imageContainer1').addEventListener('click', function() {
			document.getElementById('modification_attachments').click();
		});
	}	

	document.getElementById('imageContainer2').addEventListener('click', function() {
		document.getElementById('attachments').click();
	});

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
					var portElement = '<div class="col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
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
						var portElement = '<div class="col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
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

		function submitModification(frmId){
			$('#loader').removeClass('hide');
			formData = $("#"+frmId).serialize();

			$.ajax({
				url: '<?= site_url().'users/submitModification'; ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',		                
				success: function(result) {
					console.log(result);
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

	$('#openChat').on('click', function(){
		get_chat_onclick(<?php echo $service['user_id'];?>, <?php echo $service['id'];?>);
		showdiv();
	});

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
</script>