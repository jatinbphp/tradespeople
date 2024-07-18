<?php include 'include/header.php'; ?>

<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
		.trads-offer{
	    color:#FF3500;
	}
	.tradsman-banner .card {
		background:#fff;
		border-radius:5px;
		padding:10px !important;
		margin-bottom:10px;
		position: relative;
		overflow: hidden;
		padding: 10px 10px 10px 0px !important;
	}
	.tradsman-banner .card:before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 18%;
		background-color: #fff;
		height: 100%;
	}

	.tradsman-banner .card p{
		font-size:18px;
		font-weight:500;
		margin: 0;
	}
	#vote_buttons:hover {
		cursor:pointer;  
	}
	/*
	.modal {
	  display: none;
	  position: fixed;
	  z-index: 1; 
	  padding-top: 100px;
	  left: 0;
	  top: 0;
	  width: 100%;
	  height: 100%;
	  overflow: auto; 
	  background-color: rgb(0,0,0);
	  background-color: rgba(0,0,0,0.4); 
	}
	.modal-content {
	  background-color: #fefefe;
	  margin: auto;
	  padding: 20px;
	  border: 1px solid #888;
	  width: 43%;
	}*/
	.emailmsg{
	  text-align: center;
	  background: green;
	  color: white;
	  padding: 10px;
	  font-size: 15px;
		display: none;
	}

	.animate-text {
		-webkit-backface-visibility: hidden;
	  -webkit-perspective: 1000;
	  -webkit-transform: translate3d(0,0,0);
	}

	.animate-text > span {
	  overflow:hidden;
	  white-space:nowrap;
	}

	.animate-text > span:first-of-type {
	  animation: showup 7s;
	/*  background-color: #FFF;*/
	}

	.animate-text > span:last-of-type {
	  width:0px;
	/*  animation: reveal 7s;*/
	}

	.animate-text > span:last-of-type {
	  animation: slidein 7s;
	}

	@keyframes showup {
	  0% {opacity:0; padding-left: 40%;}
	  20% {opacity:1; padding-left: 40%}
	  35% {opacity:1; padding-left: 0%}
	  100% {opacity:1; padding-left: 0%}
	}

	@keyframes slidein {
	  0% { margin-left:-150%; }
	  20% { margin-left:-150%; }
	  35% { margin-left:0%; }
	  100% { margin-left:0%; }
	}

	/*@keyframes slidein {
	  0% { margin-left:40%; }
	  20% { margin-left:40%; }
	  35% { margin-left:0%; }
	  100% { margin-left:0%; }
	}*/

	/*@keyframes slidein {
	  0% { margin-left:-800px; }
	  20% { margin-left:-800px; }
	  35% { margin-left:0px; }
	  100% { margin-left:0px; }
	}*/

	@keyframes reveal {
	  0% {opacity:0;width:0px;}
	  20% {opacity:1;width:0px;}
	  30% {width:355px;}
	  100% {opacity:1;}
	/*  100% {opacity:0;width:355px;}*/
	}
</style>
<?php if($this->session->userdata('type')==1) { ?>
<div class="acount-page membership-page">	
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<!-- sidebar here -->
				<?php include 'include/sidebar.php'; ?> 
				<!-- sidebar here -->
			</div> 
			<div class="col-md-9">
				 <?php 
 if($this->session->userdata('type')==1){
	$settings = $this->db->where('id', 3)->get('admin_settings')->row();
	if($settings->banner == 'enable'){
		 ?>
		 <section class="tradsman-banner">
		    <div class="card">
	        <p class="animate-text">
	        	<span style="background-color: #fff;"><img style="width: 20px; vertical-align: middle;margin-left: 10px;" src="<?php echo base_url('asset/admin/img/Gas.png')?>" alt="">
	        	<span class="trads-offer">Did you know?</span></span>
	        	<span>You can refer another users and earn. Find out <a href="<?= base_url('new-referral'); ?>">here!</a></span>
        	 	<!-- <span>Refer another trade and earn free leads once they purchase their first job</span> -->
	        </p>
		    </div>
		</section> 
<?php }  }


 ?>
                 
				<?php if($this->session->userdata('type')==1){?>
				
				<div class="mjq-sh">
					<h2><strong>Key Metrics</strong>  </h2>
				</div>
				
				<?php if($this->session->flashdata('error')) { ?>
         
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
          
				<?php } if($this->session->flashdata('success')) { ?>
				<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
				<?php } ?>
       
				<div class="verification-checklist key-metrics mb-5">
					<ul class="list">
						<li>
							<div class="title">Sale</div>
							<div class="sub-title">
								<i class="fa fa-gbp"></i> 
								<?php echo number_format($total_sale['total_net_price'],2)?>
							</div>
						</li>

						<li>
							<div class="title">Open Orders</div>
							<div class="sub-title">
								<i class="fa fa-cart-plus"></i>
								<?php echo $total_open_order['total_orders']; ?>
							</div>
						</li>

						<li>
							<div class="title">Buyer Messages</div>
							<div class="sub-title">
								<i class="fa fa-comment"></i>
								0
							</div>
						</li>
						<li>
							<div class="title">Total Balance</div>
							<div class="sub-title">
								<i class="fa fa-gbp"></i>
								<?php echo number_format($user_profile['u_wallet'],2)?>
							</div>
						</li>

						<div class="modal fade popup" id="address_verify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Address Verification</h4>
									</div>
									<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_address/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data">
										<div class="modal-body">
											<fieldset>
            
												<!-- Text input-->
												<div class="form-group">
										 
													<div class="col-md-12">
													 <p style="text-align: center;font-size: 15px;"><b>To verify your address, upload either your utility bill or driving license or recent bank statement  as proof of address.</b></p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2"></div>
													<div class="col-sm-8">
														<div class="form-group">
               
															<input type="file" onchange="check_file_size(this,0);" name="u_address" required="" id="u_address" class="form-control">
              
														</div>
													</div>
													<div class="col-sm-2"></div>
												</div>
             
       
											</fieldset>
   
										</div>
 
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-warning port_btn0">Upload</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--<li>
							<div class="title">Verification ID card</div>
							<?php if($user_profile['u_id_card_status']==0){ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a data-target="#idcard_verify" href="" data-toggle="modal">Verify Now</a></div>
							<?php }else if($user_profile['u_id_card_status']==1){ ?>
							<i class="fa fa-hourglass" aria-hidden="true"></i>
							<div class="sub-title"><p>Under Review</p></div>
							<?php }else if($user_profile['u_id_card_status']==2){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php } ?>

						</li>-->
						<div class="modal fade popup" id="idcard_verify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Verification ID card</h4>
									</div>
									<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_idcard/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data">
										<div class="modal-body">
											<fieldset>
            
												<!-- Text input-->
												<div class="form-group">
										 
													<div class="col-md-12">
													 <p style="text-align: center;font-size: 15px;"><b>To verify your ID card, upload a passport or driving license,or other valid document.</b></p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2"></div>
													<div class="col-sm-8">
														<div class="form-group">
               
															<input type="file" onchange="check_file_size(this,2);" name="u_id_card" required="" id="u_id_card" class="form-control">
              
														</div>
													</div>
													<div class="col-sm-2"></div>
												</div>
             
       
											</fieldset>
   
										</div>
 
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-warning port_btn2">Upload</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--<li>
							<div class="title">Public Liability</div>
							<?php if($user_profile['u_status_insure']==0){ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a data-target="#public_liability" href="" data-toggle="modal">Upload</a> (Optional)</div>
							<?php }else if($user_profile['u_status_insure']==1){ ?>
							<i class="fa fa-hourglass" aria-hidden="true"></i>
							<div class="sub-title"><p>Under Review</p></div>
							<?php }else if($user_profile['u_status_insure']==2){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php } ?>
						</li>-->
						<div class="modal fade popup" id="public_liability" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Public Liability Verification</h4>
									</div>
									<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_insurance/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data">
										<div class="modal-body">
											<fieldset>
							
												<!-- Text input-->
												<div class="form-group">
										 
													<div class="col-md-12">
													 <p style="text-align: center;font-size: 15px;"><b>To verify public liability, upload your insurance certificate.</b></p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2"></div>
													<div class="col-sm-8">
														<div class="form-group">
									 
															<input type="file" name="u_insurrance_certi" onchange="check_file_size(this,1);" required="" id="u_insurrance_certi" class="form-control">
									
														</div>
													</div>
													<div class="col-sm-2"></div>
												</div>
											</fieldset>
		 
										</div>
	 
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-warning port_btn1">Upload</button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<?php if($setting[0]['payment_method'] == 1){?>
							<!--<li>
								<div class="title">Payment method</div>
								<?php
								$Payment_method = $this->common_model->GetColumnName('billing_details',array('user_id'=>$user_data['id']),array('is_payment_verify'));
								if($Payment_method && $Payment_method['is_payment_verify'] == 1){ ?>
									<i class="fa fa-check" aria-hidden="true"></i>
									<div class="sub-title">Verified</div>
								<?php }else{ ?>
									<i class="fa fa-times" aria-hidden="true"></i>
									<div class="sub-title"><a href="<?php echo base_url('billing-info/?verify=1'); ?>">Payment Method</a></div>
								<?php } ?>
							</li>-->
						<?php }?>
						
					</ul>
				</div>

				<?php } ?>

				<div class="mjq-sh">
					
					<?php if($this->session->userdata('type')==1){ ?> 

					<h2>
						<strong>Your recent jobs</strong>
						<a href="<?php echo base_url('my-jobs'); ?>"> <span class="always-hide-mobile" style="display: none;"> View all of your jobs</span></a>
					</h2>
					<?php }else{ ?>
						

					<h2>
						<strong>Your recent jobs</strong>
						<a href="<?php echo base_url('my-posts'); ?>"> <span class="always-hide-mobile"> View all of your jobs</span></a>
					</h2>
					<?php } ?>
                    
				</div>
	
				<?php if($this->session->userdata('type')==1){  ?>
				<?php
				$userid=$this->session->userdata('user_id');
				$get_commision=$this->common_model->get_commision(); 
				$closed_date=$get_commision[0]['closed_date'];       
				if($bids)  { ?> 
					<div class="table-responsive">
				<table class="table table_nw trade-recent-job-tbl" id="boottable">
					<thead>
						<tr class="th_class">
							<th style="display: none;"></th>
							<th>Job Id</th>
							<th>Job Title</th>
							<th style="width: 120px;">Category</th>
							<th>Posted By</th>
							<?php if($show_buget==1){ ?>
							<th style="width: 115px;">Budget</th>
							<?php } ?>
							<th>Postcode / Distance</th>
							<th>Status</th>
							<th>Action</th>       
						</tr>
					</thead>
					<tbody>
						<?php 
						$ks = 0;
						foreach($bids as $key=>$list) {
						$get_user=$this->common_model->get_single_data('users',array('id'=>$list['userid'])); 
						
						if($get_user){
						
						$get_trades=$this->common_model->get_trades_status($this->session->userdata('user_id'),$list['job_id']);
						$date111=date('Y-m-d H:i:s');
						$dates12= date('Y-m-d H:i:s', strtotime($date111. ' + '.$closed_date.' days'));
						?>
						<?php 
						if(empty($get_trades) && (date('Y-m-d H:i:s')< $dates12)){ 
						$ks++;
						?>
						<tr class="tr_class">
							<td style="display: none;"><?php  echo $key+1; ?></td>
							<td><?php echo $list['project_id']; ?></td>
							<td>
								<i class="fa fa-wrench" aria-hidden="true"></i>
								<br><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php   echo $list['title']; ?></a>
							</td>
							<td>
								<?php $get_category=$this->common_model->get_category('category',($list['subcategory']) ? $list['subcategory'] : $list['category']); echo $get_category[0]['cat_name']; ?>
							</td>
							<td>
								<i class="fa fa-user" aria-hidden="true"></i>
								<br>
								<?php 
								echo $get_user['f_name'].' '.$get_user['l_name']; ?>
							</td>
								<?php $get_post_jobs=$this->common_model->get_single_data('tbl_jobpost_bids',array('bid_by'=>$this->session->userdata('user_id'),'job_id'=>$list['job_id'],'status'=>7)); ?>
								<?php if($show_buget==1){ ?>
								<td style="width: 115px;">
								
								<?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?>
								</td>
								<?php } ?>
							
							<td>
									<?php 
									
									$len = (strlen($list['post_code'])>=7)?4:3;
									
									echo strtoupper(substr($list['post_code'],0,$len));
									
									/*$distance = getDistance($user_data['postal_code'],$list['post_code']); //print_r($distance);
									
									if($distance['status']){
										echo '<br>'.$distance['duration_in_traffic']->text;
									}*/
									
									echo '<br>'.round($list['distance_in_km'],1).' miles';
									
									?>
							</td>
								
							<?php $datesss= date('Y-m-d H:i:s', strtotime($list['c_date']. ' + '.$closed_date.' days')); ?>
							<td>
								<?php if(empty($get_trades)){ ?>
								<?php if(($list['status']==0 || $list['status']==1 || $list['status']==2 || $list['status']==3) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Open</span>
									
								<?php }else if(($list['status']==4) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){ ?>
								
								<span class="label label-danger">Closed</span>
								
								<?php  }else if(($list['status']==7) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){ ?>
								
								<span class="label label-danger">Closed</span>
								
								<?php }else if(($list['status']==8) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Open</span>
								
								<?php }else if(($list['status']==5) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){ ?>
								
								<span class="label label-danger">Closed</span>
								
								<?php }else if((date('Y-m-d H:i:s')>=$datesss) && ($list['status']!=4 || $list['status']!=5 || $list['status']==7) && empty($get_post_jobs) ){ ?>
								
								<span class="label label-danger">Closed</span>
								
								<?php } ?>

							<?php }else{ ?>
							
								<?php if(($list['status']==0 || $list['status']==1 || $list['status']==2 || $list['status']==3) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Open</span>
								
								<?php }else if(($list['status']==4) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Awaiting Acceptance</span>
								
								<?php  }else if(($list['status']==7) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">In Progress</span>
								
								<?php }else if(($list['status']==8) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Open</span>
								
								<?php }else if(($list['status']==5) && (date('Y-m-d H:i:s')< $datesss)){ ?>
								
								<span class="label label-success">Completed</span>
								
								<?php }else if((date('Y-m-d H:i:s')>=$datesss) && ($list['status']!=4 || $list['status']!=5 || $list['status']==7) && empty($get_post_jobs)){ ?>
								
								<span class="label label-danger">Closed</span>
								
								<?php } ?>
							<?php } ?>
							</td>

							<td>
								
								<?php if((date('Y-m-d') >= $datesss) || $list['status']==4 || $list['status']==7 || $list['status']==5){
									$disabled = 'disabled';
								} else {
									$disabled = '';
								} ?>
								
								<?php 
								$check_my_bid = $this->common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$list['job_id'],'bid_by'=>$user_data['id']));
								?>
										
								<?php if($check_my_bid){ ?>
								<button class="btn btn-anil_btn" <?= $disabled; ?> onclick="window.location.href='<?php echo base_url('details/?post_id='.$list['job_id']); ?>'">Update Quote</button>
								<?php } else { ?>
								<button class="btn btn-anil_btn" <?= $disabled; ?> onclick="window.location.href='<?php echo base_url('details/?post_id='.$list['job_id']); ?>'">Quote</button>
								<?php } ?>
								

							</td>
 
						</tr>
						<?php } ?>
						<?php } ?>


						<?php } ?>
					</tbody>
				</table>
			</div>
				<?php if($ks==0) { ?>
				<div class="verify-page mb-5">
					<div style="background-color:#fff;padding: 10px;" class="">
						<p>No jobs found.</p>
					</div>
				</div>
				
				<script>
					$('.trade-recent-job-tbl').remove();
				</script>
				<?php } ?>
				<?php } else { ?>
				<div class="verify-page mb-5">
					<div  style="background-color:#fff;padding: 10px;" class="">
						<p>No jobs found.</p>
					</div>
				</div>				
				
        <?php  } ?>

				<?php echo $this->session->flashdata('success1');  ?>
         
				<?php if($this->session->flashdata('error1')) { ?>
					
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
				<?php } ?>
				
				<div class="mjq-sh">
					<h2><strong>Active Orders</strong> </h2>
				</div> 

				<div class="row mb-5" id="OrderList">
					<div class="col-sm-12">
						<?php if(!empty($all_active_order) && count($all_active_order)): ?>
							<div class="row">
								<?php foreach($all_active_order as $order):?>
									<div class="col-sm-6" id="activeOrder<?php echo $order['id']; ?>">
										<div class="member-summary mjq-sh">
											<div class="summary member-summary-section">
												<div class="member-image-container">
													 <?php $image_path = FCPATH . 'img/profile/' . ($order['profile'] ?? ''); ?>
            										<?php if (file_exists($image_path) && $order['profile']): ?>
														<img src="<?php echo base_url('img/profile/') . $order['profile']; ?>" class="img-border-round member-image">
													<?php else: ?>
														<img src="<?php echo base_url('img/default-img.png'); ?>" class="img-border-round member-image">
													<?php endif; ?>
												</div>
												<div class="member-information-container">
													<div class="member-name-container crop">
														<h4 class="m-0 pb-1">
															<?php echo $order['f_name'].' '.$order['l_name']; ?>
														</h5>
														<div class="member-job-title crop text-muted">
															<?php echo $order['service_name']; ?>
														</div>
														<h3 class="mt0">
															<?php echo '£'.number_format($order['total_price'] - $order['service_fee'],2); ?>
														</h3>
													</div>
												</div>							
											</div>
											<div class="summary member-summary-section">
												<div class="member-information-container date-submit-order">
													<div>
													<div class="member-job-title crop">
														<i class="fa fa-calendar"></i>
														<?php 
															$date = new DateTime($order['created_at']);
															echo $date->format('F j, Y');
														?>
													</div>
													<div class="member-job-title crop text-muted">
														<!-- <?php 
															$CI = &get_instance();
															$CI->load->model('Common_model');
															echo $CI->Common_model->changeDateFormat($order['created_at']);
														?> -->
														3 days to submit
														
													</div>
													</div>
													<button type="button" class="btn btn-warning submitProject" data-pid="<?php echo $order['id']; ?>">
															<i class="fa fa-upload"></i>
															Submit Order
														</button>													
												</div>
											</div>						
										</div>
									</div>
								<?php endforeach; ?>	
							</div>
						<?php else: ?>
							<div class="verify-page mb-5">
								<div  style="background-color:#fff;padding: 10px;" class="">
									<p>No active order found.</p>
								</div>
							</div>
						<?php endif; ?>	
					</div>
				</div>

				<div class="mjq-sh">
					<h2><strong>Recently Vied Services</strong> </h2>
				</div>

				<div class="row mb-5" id="recentlyView">
					<div class="col-sm-12">
						<?php if(!empty($recently_viewed) && count($recently_viewed)): ?>
							<div class="row">
								<?php foreach($recently_viewed as $list):?>
									<div class="col-sm-4 recently-view">
										<div class="tradespeople-box bg-white p-3">
											<div class="tradespeople-box-img radius-none">
												<a href="<?php echo base_url().'edit-service/'.$list['id']?>">
													<img src="<?php echo  base_url().'img/services/'.$list['image']; ?>">
												</a>
											</div>
											<div class="tradespeople-box-desc mb-0">
												<a href="<?php echo base_url().'edit-service/'.$list['id']?>" style="height: fit-content;">
													<p class="mb-0">
														<?php
														$totalChr = strlen($list['service_name']);
														if($totalChr > 60 ){
															echo substr($list['service_name'], 0, 60).'...';		
														}else{
															echo $list['service_name'];
														}
														?>
														<b class="pull-right pr-1">
															<?php echo '£'.$list['price']; ?>	
														</b>
													</p>
												</a>
											</div>											
										</div>									
									</div>
								<?php endforeach; ?>	
							</div>
						<?php else: ?>
							<div class="verify-page mb-5">
								<div  style="background-color:#fff;padding: 10px;" class="">
									<p>No active order found.</p>
								</div>
							</div>
						<?php endif; ?>	
					</div>
				</div>
				
				<?php if($work_progress){ ?> 
					<!--<div class="table-responsive">
						<table class="table table_nw DataTable">
							<thead>
								<tr class="th_class">
								 <th style="display: none;"></th>
									<th>Job Id</th> 
									<th>Job Title</th>
									<th style="width: 120px;">Category</th>
									<th>Posted By</th>
									<?php if($show_buget==1){ ?>
									<th style="width: 115px;">Budget</th>
									<?php } ?>
									<th style="width: 97px;">Postcode / Distance</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
		   
							<tbody>
								<?php 
								foreach($work_progress as $key=>$list) { 
								$get_job_detail = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$list['job_id']));
								$get_users=$this->common_model->GetColumnName('users',array('id'=>$get_job_detail['userid']),array('f_name','l_name')); 
								$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['bid_by']),array('trading_name')); 
								?>
								<tr class="tr_class">
									<td style="display: none;"><?php  echo $key+1; ?></td>
									<td><?php echo $get_job_detail['project_id']; ?></td>
									<td>
									<?php
									if($get_job_detail['direct_hired']==1){
											$job_title = 'Work for '.$tradesment['trading_name'];
											} else {
											$job_title = $get_job_detail['title'];
									 }
									?>
										<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
									</td>
									<td>
										<?php
										$selected_lang = explode(',',$get_job_detail['category']);
										$cat_data='';
										foreach($category as $row) { 
											if(in_array($row['cat_id'],$selected_lang)) {
												$cat_data .= $row['cat_name'].', ';
											}
										} 
										echo rtrim($cat_data,', '); ?>
									</td>
									
									<td>
										<?php 
										
										echo $get_users['f_name'].' '.$get_users['l_name']; ?>
									</td>
									<?php if($show_buget==1){ ?>
									<td style="width: 115px;"><?php echo ($get_job_detail['budget'])?'£'.$get_job_detail['budget']:''; ?><?php echo ($get_job_detail['budget2'])?' - £'.$get_job_detail['budget2']:''; ?></td>
									<?php } ?>
									<td>
											<?php 
											
											$len = (strlen($get_job_detail['post_code'])>=7)?4:3;
											
											echo strtoupper(substr($get_job_detail['post_code'],0,$len));
											
											/*$distance = getDistance($user_data['postal_code'],$get_job_detail['post_code']);
											
											if($distance['status']){
												echo '<br>'.$distance['duration_in_traffic']->text;
											} */
											
											$distance = getDistanceByLatLng($get_job_detail['latitude'],$get_job_detail['longitude'],$user_data['latitude'],$user_data['longitude']);
											
											
											
											echo '<br>'.$distance.' miles';
											
											
											?>
									</td>
									<td> 
										<?php if($get_job_detail['status']==0 || $get_job_detail['status']==1 || $get_job_detail['status']==3){ ?>
										
										<span class="label label-success">Open</span>
										
										<?php } if($get_job_detail['status']==7){ ?>
										
										<span class="label label-success">In Progress</span>
										
										<?php } if($get_job_detail['status']==8){?>
										
										<span class="label label-danger">Rejected Award</span>
										
										<?php }if($get_job_detail['status']==5){ ?>
										
										<span class="label label-success">Completed</span>
										
										<?php }if($get_job_detail['status']==4){ ?>
										
										<span class="label label-success">Awaiting Acceptance</span>
										<?php } ?>
									</td>
									<td>									
										<?php if($get_job_detail['status']==7){?>
							
										<a class="btn btn-anil_btn" href="<?php echo base_url('payments?post_id='.$get_job_detail['job_id']); ?>">View milestones</a> 
										
										<?php } else { ?>
										
										<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$get_job_detail['job_id']); ?>">View Quotes</a>
										
										<?php } ?>									
									</td>
								</tr> 
								<?php } ?>
							</tbody>
						</table>
					</div>-->
				<?php }else{ ?>					
					<!--<div class="verify-page">
						<div  style="background-color:#fff;padding: 10px;" class="">
							<p>No jobs found.</p>
						</div>
					</div>
					<br> <br>-->				
				<?php  } ?>

				<?php  }else{ if($posts){  ?>
					<div class="table-responsive">
				<table class="table table_nw">
					<thead>
						<tr class="th_class">
							<th>Added</th>
							<th>Title</th>
							<th>Posted By</th>
							<?php if($show_buget==1){ ?>
							<th style="width: 115px;">Budget</th>
							<?php } ?>
							<th>Action</th>
							<th style="width: 120px;">Category</th>
						</tr>
					</thead>
   
					<tbody>
						<?php foreach($posts as $key=>$list) { ?>
						<tr id="vote_buttons" class="tr_class" onclick="window.location='<?php echo base_url('details/?post_id='.$list['job_id']); ?>';">
							<td>
								<br><?php $cdate=strtotime($list['c_date']); echo date('d',$cdate); echo ' '.date('M', $cdate); ?><br><?php  echo date('h:i A', strtotime($list['cdate'])); ?>
							</td>
							<td>
								<i class="fa fa-wrench" aria-hidden="true"></i>
								<br><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php   echo $list['title']; ?></a>
							</td>
							<td>
								<i class="fa fa-user" aria-hidden="true"></i>
								<br><?php $get_user=$this->common_model->get_single_data('users',array('id'=>$list['userid'])); echo $get_user['f_name'].' '.$get_user['l_name']; ?>
							</td>
							<?php if($show_buget==1){ ?>
							<td style="width: 115px;">
								<?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?>
							</td>
							<?php } ?>
        
							<td>View Now</td>
							<td><?php $get_category=$this->common_model->get_category('category',$list['category']); echo $get_category[0]['cat_name']; ?></td>
						</tr>
						<?php } ?>

					</tbody>
				</table>
				</div>
				<?php }else{ ?>
					<div class="verify-page">
						<div style="background-color:#fff;padding: 10px;" class="">
							<p>No jobs found.</p>
						</div>
					</div>
					<br> <br>
												
				<?php }  }?>

				<div class="mjq-sh" style="margin-top: -5px;">
					<h2><strong>News Feed</strong> </h2>
				</div>
				
				<?php if($this->session->userdata('type')==1){ ?> 
				<?php if($trade_news){ ?>
				<div class="row">
					<div class="col-md-12 col-sm-12"> 
            <div class="dashboard-white"> 
							<div class="row dashboard-profile dhash-news">
								<div class="col-md-12">
									
									<?php foreach ($trade_news as $key => $list) { 
									$get_users=$this->common_model->get_single_data('users',array('id'=>$list['posted_by']));
									?>
									<div class="dhash-news-main">
										<div class="row">
											<div class="col-md-1 col-xs-2">
												<?php if($get_users['profile']){ ?>   
												
												<a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="img-resposive" style="width: 50px;height: 50px;"></a>
												
												<?php } else { ?>
												
												<a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-resposive" style="width: 50px;height: 50px;"></a>
                 
												<?php } ?> 
														
											</div>
                                
											<div class="col-md-11 col-xs-10">
                        
												<p><?php echo $list['nt_message']; ?><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
												<?php if($list['job_id']!=''){
													$get_job_bids=$this->common_model->get_post_bids('tbl_jobpost_bids',$list['job_id'],$list['nt_userId']); 
												} ?>     
											</div>
										</div>
										
										<?php if($list['nt_apstatus']==1){ ?>
										
										<div class="row">
											<div class="col-md-1 col-xs-2"> </div>
											<div class="col-md-11 col-xs-10">
  
												<p><b><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?> quote £ <?php echo $get_job_bids[0]['bid_amount']; ?> GBP to complete in <?php echo $get_job_bids[0]['delivery_days']; ?> day(s)</b><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
                                   
												<?php echo $get_job_bids[0]['propose_description'];  ?>  
											</div>   
                 
										</div> 
                        
										<?php }else if($list['nt_apstatus']==3){ /*?>
										
										<div class="row">
											<div class="col-md-1 col-xs-2"> </div>
											<div class="col-md-11 col-xs-10">
  
												<p><b>Reason of rejection</b><br></p>
												<?php echo $get_job_bids[0]['reject_reason'];  ?>  
											</div>   
										</div> 
															 
										<?php */} ?>
                
									</div>
                    
									<?php } ?>
								</div>
							</div>
            
						</div>   
					</div>
        </div>
				
				<?php }else{ ?>
                            
				<div class="verify-page">
					<div style="background-color:#fff;padding: 20px;" class="">
						<p>No news feed found.</p>
					</div>
				</div> <br> <br>
				<?php } ?>

				<?php }else{ ?>
					<div class="row">

						<div class="col-md-6">
							<div class="message-block">
								<i class="fa fa-list-ul" aria-hidden="true" style="margin-top: -5px;"></i>
								<h3 style="margin-top: -5px;">
								 <a href="" >My Jobs</a>
								</h3>
								<p>
									 View a list of recent job quotes submitted by you. <a href="<?php echo base_url('my-posts'); ?>">Click here</a>.
								</p>
							</div>
						</div>
						
						<div class="col-md-6" style="padding-right: 5px;">
							<div class="message-block">
								<i class="fa fa-pencil" aria-hidden="true" style="margin-top: -5px;"></i>
								<h3 style="margin-top: -5px;">
									<a href="<?php echo base_url('edit_profile'); ?>">Update My Details</a>
								</h3>
								<p>
										Keep your details up to date by altering your <a href="<?php echo base_url('edit_profile'); ?>">account settings</a>.
								</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="message-block">
								<i class="fa fa-book" aria-hidden="true" style="margin-top: -5px;"></i>
								<h3 style="margin-top: -5px;">
									<a href="#">Learn More About Our Service</a>
								</h3>
								<p>
								Read more about what MyJobQuote provides by visiting our <a href="<?php echo base_url('faq'); ?>">FAQ page</a>.
								</p>
							</div>
						</div>
					</div>

				<?php } ?> 
				
			</div>
		</div>

	</div>
</div>
<?php } elseif($this->session->userdata('type')==2) { ?>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}
th {
  color: grey;
}
th, td {
  padding: 8px;
  text-align: left; 
  border-bottom: 1px solid #ddd;
}
</style>


<?php include 'include/top.php'; ?>
<div class="acount-page membership-page">
	<div class="container">
    <div class="row">
			<div class="col-md-12 col-sm-12"> 
				<div class="dashboard-white"> 
					<div class="row dashboard-profile dhash-news">
						<div class="col-md-12">
							<h3>Recent Jobs</h3>
							<a href="<?php echo base_url('my-posts'); ?>"><p class="pull-right" style="margin-top: -29px;margin-bottom: 10px;">View All </p></a>
						</div>
                        
						<div class="dhash-news-main">
							<div class="row">
                
								<div class="col-md-12 col-xs-12">
									<div class="table-responsive">
									<?php if($posts){  ?>
<table>
	<tr>
		<th>Job / Contest Title</th>
	<th>Quotes/Entries</th>
		<th>Average Quote</th>
		<th>Close Date</th>
		<th>Status</th>
	</tr>
	<?php 
	$get_commision=$this->common_model->get_commision(); 
	
	$closed_date=$get_commision[0]['closed_date'];  
	foreach($posts as $key=>$list) {
		$datesss= date('Y-m-d H:i:s', strtotime($list['c_date']. ' + '.$closed_date.' days'));
	?>
	<tr>
		<td>
			<a href="<?php echo base_url('proposals/?post_id='.$list['job_id']); ?>"><b><?php echo $list['title']; ?></b></a>
		</td>
		
		<td>
			<?php 
			$get_total_bids=$this->common_model->get_total_bids($this->session->userdata('user_id'),$list['job_id']);
			echo $get_total_bids[0]['bids']; 
			?>
		</td>
		<td><i class="fa fa-gbp"></i>
			<?php 
			$get_avg_bid=$this->common_model->get_avg_bid($this->session->userdata('user_id'),$list['job_id']); 
		
			if($get_avg_bid[0]['average_amt']){ 
		
				echo number_format($get_avg_bid[0]['average_amt'],2);
			} else { 
				echo "0.00"; 
			} 
			?> 
			GBP
		</td>
		<td>
			<?php  
			
			$time_ago = $this->common_model->time_ago($list['c_date']); 
			echo date('d, M Y',strtotime($datesss)); 

			?>
		</td>
		<td>
		
			<?php if(($list['status']==3 || $list['status']==1 || $list['status']==0) && (date('Y-m-d') < $datesss)){ ?>
			
			OPEN
			
			<?php } else if($list['status']==4){ ?>
			
			IN PROGRESS
			
			<?php }else if($list['status']==5){ ?>
				
			COMPLETED
			
			<?php }else if(($list['status']==7) && (date('Y-m-d')<$datesss)){ ?>
				
			ACCEPTED
			
			<?php }else if($list['status']==6 || $list['status']==10){ ?>
			
			DISPUTE
			
			<?php }else if($list['status']==8){ ?>
			
			REJECTED
			
			<?php }else if(date('Y-m-d')>=$datesss && $get_total_bids[0]['bids'] == 0){ ?>
				
			CLOSED

			<?php }else if($get_total_bids > 0){ ?>
				
			OPEN
			
			<?php } ?>
			
		</td>
	</tr>
	<?php } ?>
</table>

									<?php }else{ ?>

									<div class="verify-page">
										<div  style="background-color:#fff;padding: 10px;" class="">
											<p>No jobs found.<a href="<?php echo base_url('post-job'); ?>">Click here</a> to post a new job.</p>
										</div>
									</div>
									<br>
									<br>
									<?php } ?>
									</div>
								</div>
							</div>
						</div> 
					</div>
				</div>
			</div>
            
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12"> 
				<div class="dashboard-white"> 
					<div class="row dashboard-profile dhash-news">
						<div class="col-md-12">
							<h3>News Feed</h3>
							<div class="table-responsive">
							<?php if($trade_news){ ?>
							<?php foreach ($trade_news as $key => $list) { 
							//echo '<pre>'; print_r(print_r($list)); echo '</pre>';
							$get_users=$this->common_model->get_single_data('users',array('id'=>$list['posted_by']));
							?>
							<div class="dhash-news-main">
								<div class="row">
									<div class="col-md-1 col-xs-2">
										<?php if($get_users['profile']){ ?>   
										<a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="img-resposive" style="width: 50px;height: 50px;"></a>
										<?php } else { ?>
										<a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-resposive" style="width: 50px;height: 50px;"></a>
										<?php } ?> 
									</div>
									<div class="col-md-11 col-xs-10">
										<p><?php echo $list['nt_message']; ?><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
										    
									</div>
								</div>
								<?php if($list['nt_apstatus']==1){ ?>
								<?php $get_job_bids=$this->common_model->get_post_bids('tbl_jobpost_bids',$list['job_id'],$list['nt_userId']); ?> 
								<div class="row">
									<div class="col-md-1 col-xs-2"> </div>
									<div class="col-md-11 col-xs-10">
  
										<p><b><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?> quote £ <?php echo $get_job_bids[0]['bid_amount']; ?> GBP to complete in <?php echo $get_job_bids[0]['delivery_days']; ?> day(s)</b><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
										<?php echo $get_job_bids[0]['propose_description'];  ?>  
									</div>   
                 
								</div> 
								
								<?php }else if($list['nt_apstatus']==3){ ?>
								<?php /*$get_job_bids=$this->common_model->get_post_bids('tbl_jobpost_bids',$list['job_id'],$list['nt_userId']); ?> 
								<div class="row">
									<div class="col-md-1 col-xs-2"> </div>
									<div class="col-md-11 col-xs-10">
  
										<p><b>Reason of rejection</b><br></p>
										<?php echo $get_job_bids[0]['reject_reason'];  ?>  
									</div>   
								</div> 
							 <?php */} ?>
                
							</div>
						<?php } ?> 
							<?php }else{ ?>
							<div class="verify-page">
								<div style="background-color:#fff;padding: 10px;" class="">
									<p>No news feed found.</p>
								</div>
							</div>
							<br>
							<br>
						 <?php } ?>
						 </div>
						</div>
					</div>
            
				</div>   
			</div>
		</div>

	</div>
</div>

<?php }?>

<div class="modal fade popup" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rejectionModal">Rejection Reason</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="col-md-12">
            <p style="font-size: 15px;">
              <?=$this->session->flashdata('reject_reason');?>
            </p>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>
<script type="text/javascript">
  <?php
    if($this->session->flashdata('reject_reason')){
  ?>
      $("#rejectModal").modal('show');
  <?php
    }
  ?>
  $(function(){
    $("#boottable").DataTable({
      stateSave: true,
     lengthChange: false, 
      searching: false,
        "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]],
        "pageLength": 5
    });
    $(".DataTable").DataTable({
      stateSave: true,
     lengthChange: false,
      searching: false,
   //     "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]],
         "pageLength": 5
    });
    $('.dataTables_filter').addClass('pull-left');
  });
</script>
<script>  
  $(function(){
    $("#boottable1").DataTable({
			stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
		});
  });
  function seepreview(){
  var fileUploads = $("#profile")[0];
  var reader = new FileReader();
  reader.readAsDataURL(fileUploads.files[0]);
  reader.onload = function (e) {
    var image = new Image();
    image.src = e.target.result;
    image.onload = function () {
      var height = this.height;
      var width = this.width;
      $('#imgpreview').html('<img src="'+image.src+'"  width="100px" height="100px">'); 
    }
  }     
} 
  </script> 
<script>
    jQuery(document).ready(function(){
        jQuery(document).on('click','.cashout_close',function(){
            jQuery('.cashout_popup').hide();
        });
         jQuery(document).on('click','.close',function(){
            jQuery('.emailmsg').hide();
        });
		var modal = document.getElementById("myModal");
		var btn = document.getElementById("myBtn");
		btn.onclick = function() {
		  modal.style.display = "block";
		}
		// window.onclick = function(event) {
		//     if (event.target == modal_wallet) {
		//     modal_wallet.style.display = "none";
		//   }
		//   if (event.target == modal) {
		//     modal.style.display = "none";
		//   }
		  
		// }
	});

    $('.submitProject').on('click', function(){
    	var orderId = $(this).attr('data-pid');

    	swal({
		    title: "Submit Order",
		    text: "Are you sure you want to submit this order?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonText: 'Yes, Submit',
		    cancelButtonText: 'Cancel'
		}, function(isConfirm) {
		    if (isConfirm) {
		        orderSubmit(orderId);
		    } else {
		        swal({
		            title: "Error",
		            text: "Order is not submitted.",
		            type: "error"
		        });
		    }
		});
    });

	function orderSubmit(orderId){
		$.ajax({
            url: '<?= site_url().'users/submitProject'; ?>',
            type: 'POST',
            data: {
                orderId: orderId
            },
            dataType: 'json',
            success: function(response) {
            	if(response.status == 'success'){
                    swal({
                        title: "Success",
                        text: "Order has been submitted.",
                        type: "success"
                    },function() {
                        $('#activeOrder'+orderId).remove();
                    });
                } else {
                    swal({
                        title: "Error",
                        text: "Order is not submitted.",
                        type: "error"
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
</script>
