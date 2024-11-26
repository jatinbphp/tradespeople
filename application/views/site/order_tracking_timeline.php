<?php if(!empty($all_conversation)):?>
	<?php 
		$total_deliveries1 = 0;
	    foreach($all_conversation as $clist1) {
	        if($clist1['status'] == 'delivered') {
	            $total_deliveries1++;
	        }
	    }
	?>
	<?php foreach($all_conversation as $ckey => $list):?>
		<li class="timeline-item">
			<span class="timeline-item-icon | faded-icon">
				<?php if($list['sender'] == 0 && $list['receiver'] == 0 && $list['is_cancel'] == 1):?>
					<i class="fa fa-times-circle faicon"></i>
				<?php elseif($list['sender'] == 0 && $list['receiver'] == 0 && $list['status'] == 'completed'):?>
					<i class="fa fa-check-square-o faicon"></i>
				<?php elseif($list['sender'] == 0 && $list['receiver'] == 0 && $order['is_cancel'] == 8):?>
					<i class="fa fa-check-square-o faicon"></i>	
				<?php else:?>
					<?php if($list['sender'] == $tradesman['id']): ?>
						<?php if($list['status'] == 'cancelled' && $order['is_cancel'] == 1):?>
							<i class="fa fa-times-circle faicon"></i>
						<?php elseif($list['status'] == 'declined'):?>
							<i class="fa fa-times-circle faicon"></i>	
						<?php else:?>	
							<i class="fa fa-truck faicon"></i>
						<?php endif; ?>
					<?php endif;?>

					<?php if($list['sender'] == $homeowner['id']): ?>
						<?php if($list['status'] == 'completed'):?>
							<i class="fa fa-check-square-o faicon"></i>
						<?php elseif($list['status'] == 'cancelled' && $order['is_cancel'] == 1):?>
							<i class="fa fa-times-circle faicon"></i>
						<?php elseif($list['status'] == 'declined'):?>
							<i class="fa fa-times-circle faicon"></i>
						<?php else:?>
							<i class="fa fa-edit faicon"></i>
						<?php endif;?>
					<?php endif;?>	
				<?php endif;?>
			</span>
			<div class="timeline-item-description">
				<?php 
				$conDate = new DateTime($list['created_at']);
				$conversation_date = $conDate->format('D jS F, Y H:i');
				?>

				<?php if($list['sender'] == 0 && $list['receiver'] == 0 && $list['is_cancel'] == 1):?>
					<h5>
						Your order has been cancelled itself
						<span class="text-muted" style="font-size: 12px;">
							<i><?php echo $conversation_date ?></i>
						</span>
					</h5>
				<?php elseif($list['sender'] == 0 && $list['receiver'] == 0 && $list['status'] == 'completed'):?>
					<h5>
						Your order has been completed itself
						<span class="text-muted" style="font-size: 12px;">
							<i><?php echo $conversation_date ?></i>
						</span>
					</h5>	
				<?php elseif($list['sender'] == 0 && $list['receiver'] == 0 && $order['is_cancel'] == 8):?>
					<h5>
						Your order has been completed itself due to dispute cancel itself
						<span class="text-muted" style="font-size: 12px;">
							<i><?php echo $conversation_date ?></i>
						</span>
					</h5>		
				<?php else: ?>
					<?php if($list['sender'] == $tradesman['id']): ?>
						<?php if($this->session->userdata('type')==1):?>
							<?php if($list['status'] == 'delivered'):?>
			            <h4 class="mt-1 mb-0"><b>Deliver <?php echo '#'.$total_deliveries1--; ?></b></h4>
			            <h5>
										You delivered your order 
										<span class="text-muted" style="font-size: 12px;">
											<i><?php echo $conversation_date ?></i>
										</span>
									</h5>
			        <?php endif;?>

			        <?php if($list['status'] == 'disputed'):?>
								<h5>
									You order disputed
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>					

							<?php if($list['status'] == 'disputed_cancelled'):?>
								<h5>
									You order disputed cancelled
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'disputed_accepted'):?>
								<h5>
									You order disputed accepted
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								<h5>
							<?php endif;?>

							<?php if($list['status'] == 'cancelled' && $list['is_cancel'] == 2):?>
								<h5>
									You ask to cancel this order
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'withdraw_cancelled' && $list['is_cancel'] == 4):?>
								<h5>
									You havebeen withdraw order cancellation request
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>																			
							<?php endif;?>

							<?php if($list['status'] == 'declined' && $list['is_cancel'] == 3):?>
								<h5>
									You declined order request
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'cancelled' && $list['is_cancel'] == 1):?>
								<h5>
									You accepted order cancellation request
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>
						<?php else:?>
							<?php if($list['status'] == 'delivered'):?>
			            <h4 class="mt-1 mb-0"><b>Deliver <?php echo '#'.$total_deliveries1--; ?></b></h4>
			            <h5>
										<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a>
										delivered your order 
										<span class="text-muted" style="font-size: 12px;">
											<i><?php echo $conversation_date ?></i>
										</span>
									</h5>
			        <?php endif;?>

			        <?php if($list['status'] == 'disputed'):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> order disputed
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'disputed_accepted'):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> order disputed accepted
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'disputed_cancelled'):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> order disputed rejected
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>

							<?php if($list['status'] == 'cancelled' && $list['is_cancel'] == 2):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> ask to cancel this order
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>	

							<?php if($list['status'] == 'withdraw_cancelled' && $list['is_cancel'] == 4):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
										<?php echo $tradesman['trading_name']; ?>
										</a> has been withdraw order cancellation request
										<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>	
							<?php endif;?>

							<?php if($list['status'] == 'declined' && $list['is_cancel'] == 3):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> declined order cancellation request
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>						

							<?php if($list['status'] == 'cancelled' && $list['is_cancel'] == 1):?>
								<h5>
									<a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
											<?php echo $tradesman['trading_name']; ?>
										</a> is accepted order cancellation request
									<span class="text-muted" style="font-size: 12px;">
										<i><?php echo $conversation_date ?></i>
									</span>
								</h5>
							<?php endif;?>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($list['sender'] == $homeowner['id']): ?>
						<?php if($this->session->userdata('type')==1):?>
							<h5>
								<?php if($list['status'] == 'completed'):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> approved order
								<?php elseif($list['status'] == 'disputed'):?>
										<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed
								<?php elseif($list['status'] == 'disputed_cancelled'):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed cancelled
								<?php elseif($list['status'] == 'disputed_accepted'):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed accepted
								<?php elseif($list['status'] == 'cancelled' && $list['is_cancel'] == 2):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> ask to cancel this order
								<?php elseif($list['status'] == 'cancelled' && $list['is_cancel'] == 1):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order is cancelled
								<?php elseif($list['status'] == 'withdraw_cancelled' && $list['is_cancel'] == 4):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> has been withdraw order cancellation request
								<?php elseif($list['status'] == 'declined' && $list['is_cancel'] == 3):?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> declined order cancellation request
								<?php else:?>
									<?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> requested a modification
								<?php endif;?>		
								<span class="text-muted" style="font-size: 12px;">
									<i><?php echo $conversation_date ?></i>
								</span>
							</h5>
						<?php else:?>
							<h5>
								<?php if($list['status'] == 'completed'):?>
									You approved order
								<?php elseif($list['status'] == 'disputed'):?>
									You dispute order
								<?php elseif($list['status'] == 'disputed_cancelled'):?>
									You order disputed cancelled
								<?php elseif($list['status'] == 'disputed_accepted'):?>
									You order disputed accepted
								<?php elseif($list['status'] == 'cancelled' && $list['is_cancel'] == 2):?>
									You ask to cancel this order
								<?php elseif($list['status'] == 'cancelled' && $list['is_cancel'] == 1):?>
									You order is cancelled
								<?php elseif($list['status'] == 'withdraw_cancelled' && $list['is_cancel'] == 4):?>
									You have been withdraw order cancellation request
								<?php elseif($list['status'] == 'declined' && $list['is_cancel'] == 3):?>
									You declined order cancellation request
								<?php else:?>
									You requested a modification 
								<?php endif;?>		
								<span class="text-muted" style="font-size: 12px;">
									<i><?php echo $conversation_date ?></i>
								</span>
							</h5>
						<?php endif;?>
					<?php endif; ?>	
				<?php endif; ?>				

				<?php
					if(in_array($list['status'],['completed','cancelled']) && empty($list['description'])){
					$style = 'display:none;';
					}else{
						$style = 'display:block;';
					}
				?>

				<span class="delivery-conversation text-left" style="<?php echo $style; ?>">
					<p><?php echo $list['description']; ?></p>

					<?php 
					$conAttachments = $this->common_model->get_all_data('order_submit_attachments',['conversation_id'=>$list['id']])
					?>

					<?php if(!empty($conAttachments)):?>
						<h5 style="width: 100%; font-size: 15px;">Attachments</h5>

						<div class="row other-post-view" id="con_attachments">
							<?php foreach ($conAttachments as $con_key => $con_value): ?>
								<?php $image_path = FCPATH . 'img/services/' . ($con_value['attachment'] ?? ''); ?>
								<?php if (file_exists($image_path) && $con_value['attachment']): ?>
									<?php
									$mime_type = get_mime_by_extension($image_path);
									$is_image = strpos($mime_type, 'image') !== false;
									$is_video = strpos($mime_type, 'video') !== false;
									?>
									<div class="col-md-4 pr-3 pl-3">
										<?php if ($is_image): ?>
											<a href="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
											<img src="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" alt="">
											</a>
										<?php elseif ($is_video): ?>	
											<a href="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
												<video controls src="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" type="<?php echo $mime_type; ?>" loop class="serviceVideo">
												</video>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>	
							<?php endforeach; ?>
						</div>																	
					<?php endif; ?>
				</span>
				<?php //if($list['status'] == 'cancelled' && !in_array($order['is_cancel'], [1,3,4]) && $order['status'] != 'declined'):?>
				<?php if($ckey == 0 && !in_array($order['is_cancel'], [0,1,3,4,6,7,8])):?>
					<p class="alert alert-danger mb-0">
						<?php 
							if($list['sender'] == $tradesman['id']){
								$ocruName = $this->session->userdata('type')==1 ? $homeowner['f_name'].' '.$homeowner['l_name'].' has' : 'You have';
								$oppoName = $this->session->userdata('type')==1 ? 'your' : $tradesman['trading_name'];
							}

							if($list['sender'] == $homeowner['id']){
								$ocruName = $this->session->userdata('type')==1 ? 'You have' : $tradesman['trading_name'].' has';
								$oppoName = $this->session->userdata('type')==1 ? $homeowner['f_name'].' '.$homeowner['l_name'] : 'your';
							}
						?>
						<?php if($order['is_cancel'] == 5):?>
							<?php if($list['sender'] == $homeowner['id']): ?>
								<i class="fa fa-info-circle"></i> 
								<?php echo $ocruName; ?> until <?php echo $newTime; ?> to respond. Not responding within the time frame will result in closing the case and deciding in <?php echo $oppoName; ?> favour.
							<?php else: ?>
								<i class="fa fa-info-circle"></i> 
								Not responding before <?php echo $newTime; ?> will result in closing this case and deciding in the <?php echo $oppoName; ?> favour. Any decision reached is final and irrevocable. Once a case has been closed, it can't be reopened.
							<?php endif; ?>	
						<?php else:?>
							<i class="fa fa-info-circle"></i> 
							<?php echo $ocruName; ?> have until <?php echo $newTime; ?> to respond to this request or the order will be cancelled. Cancelled orders will be credited to your Tradespeople Wallet. Need another tradesman? We can help?
						<?php endif;?>	
					</p>
						<div class="text-right width-100">
							<?php if($user['id'] != $list['sender'] && $list['is_cancel'] == 2 && $order['is_cancel'] == 2):?>
								<a class="btn btn-default" href="#" data-target="#decline_request_modal" onclick="return decliensss()" data-toggle="modal">Decline</a>
								<button class="btn btn-warning" onclick="accept_decision(<?php echo $order['id']; ?>)">
									Accept Request
								</button>
							<?php else: ?>
								<?php if($list['is_cancel'] == 2 && $order['is_cancel'] == 2):?>
									<button class="btn btn-warning" onclick="withdraw_request(<?php echo $order['id']; ?>)">
										Withdraw Request
									</button>
									<?php endif;?>
							<?php endif;?>
						</div>																
				<?php endif;?>

				<?php //if($this->session->userdata('type')==2 && $ckey == 0 && !in_array($list['status'],['disputed','request_modification','completed','cancelled','declined','withdraw_cancelled'])):?>
				<?php if($this->session->userdata('type')==2 && $ckey == 0 && $order['status'] == 'delivered'):?>
					<form id="approved_order_form" style="width:100%">
						<input type="hidden" name="order_id" value="<?php echo $order['id']?>">
						<input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
						<input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
						<input type="hidden" name="status" value="completed">
						<!-- <textarea rows="7" class="form-control" id="approve-decription" name="approve_decription"></textarea> -->
					</form>

					<p class="alert alert-info mb-0">
						<i class="fa fa-info-circle"></i> 
						Keep in mind that you have untill <?php echo $newTime; ?> to approve this delivery or request a revision. After this date, the order will be finalized and marked as complete.
					</p>

					<div id="approved-btn-div">
						<button type="button" id="approved-order-btn" class="btn btn-warning mr-3">
							Approve
						</button>
						<button type="button" id="modification-btn" class="btn btn-default">
							Request Modification
						</button>
					</div>
					<div id="modification-div" style="display:none; width: 100%;">
						<form id="request_modification_form">
							<input type="hidden" name="order_id" value="<?php echo $order['id']?>">
							<input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
							<input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
							<input type="hidden" name="status" value="request_modification">
							<textarea rows="7" class="form-control" id="modification-decription" name="modification_decription"></textarea>
							<div class="row">
								<div id="loader2" class="loader_ajax_small"></div>
								<div class="col-md-6 col-xs-12 imgAdd" id="imageContainer1">
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
				<?php endif;?>
			</div>
		</li>
	<?php endforeach;?>
<?php endif;?>