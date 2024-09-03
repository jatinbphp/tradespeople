<?php
include 'include/header.php';
$get_commision = $this->common_model->get_commision();

$closed_date = $get_commision[0]['closed_date'];
?>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
	.trads-offer {
		color: #FF3500;
	}

	.tradsman-banner .card {
		background: #fff;
		border-radius: 5px;
		padding: 20px 10px 10px 0px !important;
		margin-bottom: 10px;
		position: relative;
		overflow: hidden;
	}

	.tradsman-banner .card p {
		font-size: 18px;
		font-weight: 500;
	}

	#vote_buttons :hover {
		cursor: pointer;
	}

	.pull-left {
		float: right !important;
	}

	.tox-toolbar__primary,
	.tox-editor-header {
		display: none !important;
	}


	.animate-text {
		-webkit-backface-visibility: hidden;
		-webkit-perspective: 1000;
		-webkit-transform: translate3d(0, 0, 0);
	}

	.animate-text>span {
		overflow: hidden;
		white-space: nowrap;
	}

	.animate-text>span:first-of-type {
		animation: showup 7s;
		/*  background-color: #FFF;*/
	}

	.animate-text>span:last-of-type {
		width: 0px;
		/*  animation: reveal 7s;*/
	}

	.animate-text>span:last-of-type {
		animation: slidein 7s;
	}

	@keyframes showup {
		0% {
			opacity: 0;
			padding-left: 40%;
		}

		20% {
			opacity: 1;
			padding-left: 40%
		}

		35% {
			opacity: 1;
			padding-left: 0%
		}

		100% {
			opacity: 1;
			padding-left: 0%
		}
	}

	@keyframes slidein {
		0% {
			margin-left: -150%;
		}

		20% {
			margin-left: -150%;
		}

		35% {
			margin-left: 0%;
		}

		100% {
			margin-left: 0%;
		}
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
		0% {
			opacity: 0;
			width: 0px;
		}

		20% {
			opacity: 1;
			width: 0px;
		}

		30% {
			width: 355px;
		}

		100% {
			opacity: 1;
		}

		/*  100% {opacity:0;width:355px;}*/
	}
</style>
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

				if ($this->session->userdata('type') == 2) {
					$settings = $this->db->where('id', 2)->get('admin_settings')->row();
					if ($settings->banner == 'enable') {
				?>
						<section class="tradsman-banner">
							<div class="card">
								<p class="animate-text">
									<span style="background-color: #fff;">
										<img style="margin-left:30px;" src="<?php echo base_url('asset/admin/img/Gas.png') ?>" alt="">
										<span class="trads-offer">Did you know ?</span>
									</span>
									<span>You can refer another users and earn. Find out <a href="<?= base_url('new-referral'); ?>">here!</a></span>
								</p>
							</div>
						</section>
				<?php }
				}
				?>
				<?php echo $this->session->flashdata('msg'); ?>
				<?php if ($this->session->flashdata('error1')) { ?>
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
				<?php } ?>
				<?php if ($this->session->flashdata('success1')) { ?>
					<p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
				<?php } ?>

				<div class="mjq-sh">
					<h2><strong>Your recent jobs</strong>
						<span class="always-hide-mobile"> </span>
					</h2>
				</div>
				
				<?php if ($posts) {  ?>
							<table class="table table_nw" id="boottable">
								<thead>
									<tr class="th_class">
										<th style="display: none;"></th>
										<th>Job Id</th>
										<th>Job Title</th>
										<th>Quotes</th>
										<?php if ($show_buget == 1) { ?>
											<th style="width:115px;">Budget</th>
										<?php } ?>
										<th>Average Quote</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$x = 1;
									$get_commision = $this->common_model->get_commision();
									//print_r($get_commision);
									$closed_date = $get_commision[0]['closed_date']; 
									foreach ($posts as $key => $list) {
									?>
										<tr class="tr_class">
											<td style="display: none;"><?php echo $key + 1; ?></td>
											<td><?php echo $list['project_id']; ?></td>
											<td>
												<a href="<?php echo base_url('details/?post_id=' . $list['job_id']); ?>"><?php echo $list['title']; ?></a>
											</td>
											<td><?php $get_total_bids = $this->common_model->get_total_bids($this->session->userdata('user_id'), $list['job_id']);
												echo $get_total_bids[0]['bids']; ?></td>
											<?php if ($show_buget == 1) { ?>
												<td>
													<?php echo ($list['budget']) ? '£' . $list['budget'] : ''; ?><?php echo ($list['budget2']) ? ' - £' . $list['budget2'] : ''; ?>
												</td>
											<?php } ?>
											<td><i class="fa fa-gbp"></i>

												<?php
												$get_avg_bid = $this->common_model->get_avg_bid($this->session->userdata('user_id'), $list['job_id']); //print_r($get_avg_bid);

												if ($get_avg_bid[0]['average_amt']) { ?>

												<?php echo number_format($get_avg_bid[0]['average_amt'], 2);
													$editable = false;
												} else {
													echo "0";
													$editable = true;
												} ?> GBP
											</td>
											<?php $datesss = date('Y-m-d H:i:s', strtotime($list['c_date'] . ' + ' . $closed_date . ' days')); ?>
											<?php $admin = $this->common_model->get_single_data('admin', ['id' => 1]); ?>
											<?php $exp_date = date('Y-m-d H:i:s', strtotime($list['c_date'] . ' + ' . $admin['waiting_time_accept_offer'] . ' days')); ?>
											<td> 
												<?php 
												//echo 'created at -'; echo $list['c_date'].'<br>';
												//echo '/';
												//echo $datesss;
												//echo $list['status'];
												$get_total_bidd = $this->common_model->get_single_data('tbl_jobpost_bids', ['job_id' => $list['job_id']]); ?>

												<?php if (($list['status'] == 0 || $list['status'] == 1 || $list['status'] == 2 || $list['status'] == 3) && empty($get_total_bidd)) { ?>

													<span class="label label-success">Open</span>

												<?php } else if (($list['status'] == 4) && (date('Y-m-d H:i:s') < $datesss)) { ?>

													<span class="label label-success">Awaiting Acceptance</span>

												<?php  } else if (($list['status'] == 7) && (date('Y-m-d H:i:s') < $datesss)) { ?>

													<span class="label label-success">In Progress</span>

												<?php } else if (($list['status'] == 8) && !empty($get_total_bidd)) { ?>

													<span class="label label-danger">Open</span>

												<?php } else if (($list['status'] == 5) && (date('Y-m-d H:i:s') < $datesss)) { ?>

													<span class="label label-success">Completed</span>

												<?php } else if (($list['status'] != 3 || $list['status'] != 4 || $list['status'] != 5 || $list['status'] != 7) && empty($get_total_bidd) && (date('Y-m-d') > $exp_date)) { ?>

													<span class="label label-danger">Closed</span>

												<?php } else if ($get_total_bids > 0) { ?>

													<span class="label label-success">Open</span>

												<?php } ?>
											</td>

											<td>
												<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id=' . $list['job_id']); ?>">View Quotes</a>

												<?php /*
										<div class="dropdown">
											<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select <span class="caret"></span></button>
											<ul class="dropdown-menu" style="text-align: left;">
												<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a></li>
												<li><a href="<?php echo site_url('posts/delete_post/'.$list['job_id']); ?>" onclick="return confirm('Are you sure! you want to delete this post?');">Delete</a></li>
												<li><a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_post<?php echo $list['job_id']; ?>" >Edit</a></li>
												
												<?php 
												
												$datesss= date('Y-m-d', strtotime($list['c_date']. ' + '.$closed_date.' days')); 
												
												if(date('Y-m-d') > $datesss){
												
												?>
												<li><a href="<?php echo site_url().'newPost/repost/'.$list['job_id'].'/my-account'; ?>">Repost</a></li>
												
												<?php } ?>
												
												<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">Chat</a></li>
												<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">Award</a></li>
											</ul>
										</div>
										*/ ?>
											</td>
											<?php /*
									<div class="modal fade in" id="edit_post<?php echo $list['job_id']; ?>">
										<div class="modal-body" >
											<div class="modal-dialog">
										 
												<div class="modal-content">

													<form onsubmit="return edit_post(<?= $list['job_id']; ?>);" id="edit_post1<?= $list['job_id']; ?>" method="post"  enctype="multipart/form-data">
														<div class="modal-header">
															<div class="editmsg<?= $list['job_id']; ?>" id="editmsg<?= $list['job_id']; ?>"></div>
															 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
															 <h4 class="modal-title">Edit Posts</h4>
														</div>
														<div class="modal-body">
															<div class="form-group">
																<label for="email"> Category:</label>
																<select data-placeholder="Select Category" class="form-control" name="category" onchange="return changecategory($(this).val(),<?php echo $list['job_id']; ?>)">
																	<?php  foreach($category as $row) { 
																	
																	$selected = ($row['cat_id']==$list['category'])?'selected':'';
																	
																	if($editable){
																	?>
																	<option value="<?= $row['cat_id']; ?>" <?= $selected; ?> > <?= $row['cat_name']; ?> </option>
																	<?php
																	} else {
																	
																	if($row['cat_id']==$list['category']) {
																	?>
																	<option value="<?= $row['cat_id']; ?>" <?= $selected; ?>> <?= $row['cat_name']; ?> </option>
																	<?php } ?>


																	<?php } ?>
																	
																	<?php } ?>
																	
																</select>  
															</div>
															<div class="form-group">
											
																<div id="subcategories<?= $list['job_id']; ?>">
																	<label for="email"> Subcategory:</label>
																	<div class="row">
																		<?php 
																		$data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$list['category'])); 
																		if($data_set) {
																		foreach($data_set as $subcategory){
																		?>
																		<div class="col-sm-6">
																			<?php 
																			if($editable){
																				
																			$checked = ($subcategory['cat_id']==$list['subcategory'])?'checked':'';
																			?>
																			
																			<input type="radio" name="subcategory" id="subcategory" <?= $checked; ?> read value="<?php echo $subcategory['cat_id']; ?>">
																			<?php echo $subcategory['cat_name']; ?>
																			
																			<?php } else { ?>
																			
																			<?php if($subcategory['cat_id']==$list['subcategory']){ ?>
																			
																			<input type="radio" checked name="subcategory" id="subcategory" <?= $checked; ?> read value="<?php echo $subcategory['cat_id']; ?>">
																			<?php echo $subcategory['cat_name']; ?>
																			
																			<?php } ?>
																			
																			<?php } ?>

																		
																		</div>
																		<?php }  } ?>
																	 </div>
																
																</div> 
															</div>
															<div class="form-group">
																<label for="email"> Title:</label>
																<input type="text" name="title"  value="<?php echo $list['title']; ?>" <?php echo ($editable==false)?'readonly':''; ?> class="form-control" >
															</div>
															<div class="form-group">
																<label for="email"> Description:</label>
																<textarea rows="5" placeholder="" name="description" class="form-control textarea"><?php echo $list['description']; ?></textarea>
															</div>
															<div class="form-group">
																<label for="email"> Document:</label>
																<input type="file" name="post_doc[]" id="post_doc" multiple>
															</div>
															<div class="form-group">
																 
																<?php 
																$attachment=$this->common_model->get_all_files($list['job_id']);
																if($attachment){
																foreach ($attachment as $doc) {
																?>
																<div id="del_doc<?php echo $doc['id']; ?>">
																	<div class="row">
																		<div class="col-sm-4">
																			<a href="<?php echo base_url('img/jobs/'.$doc['post_doc']); ?>" download><i class="fa fa-paperclip"></i> <?php echo $doc['post_doc']; ?></a>
																		</div>
																		<div class="col-sm-2">
																			<button type="button" class="btn btn-danger btn-xs" onclick="delenquiry(<?php echo $doc['id'];?>)"><i class="fa fa-close"></i></button> 
																		</div>
																	</div>
																</div>

													
																<?php } } ?>
										 
															</div>

															<div class="form-group">
																<input type="number" name="price" id="price" class="form-control" <?php echo ($editable==false)?'readonly':''; ?> value="<?php echo $list['budget']; ?>">
															</div>
															<div class="form-group">
																<label for="email"> Postcode:</label>
																<input type="text" name="post_code"  value="<?php echo $list['post_code']; ?>"  class="form-control" >
																<p class="text-danger postcode-err<?= $list['job_id']; ?>" style="display:none;">Please enter valid UK postcode</p>
															</div>


												 
														</div>
														<div class="modal-footer">
															<button type="submit" class="btn btn-primary edit_btn<?= $list['cat_id']; ?>" >Save</button>
															<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
														</div>
													</form>
												</div>
												
											</div>
										</div>
									</div>
									*/ ?>
										</tr>
									<?php  } ?>

								</tbody>
							</table>
						<?php } else { ?>
							<div class="verify-page">
								<div style="background-color:#fff;padding: 20px;" class="">
									<p>No jobs found.<a href="<?php echo base_url('post-job'); ?>">Click here</a> to post a new job.</p>
								</div>
							</div> <br><br>
						<?php }  ?>
				
				<div class="mjq-sh">
					<h2><strong>Active Orders</strong>
						<span class="always-hide-mobile"> </span>
					</h2>
				</div>
				
				<?php if ($active_orders) {  ?>
							<table class="table table_nw" id="activeOrderTable">
								<thead>
									<tr class="th_class">
										<th style="display: none;"></th>
										<th>Image/Video</th>                     
                                        <th>Service Name</th>                     
                                        <th>Order Date</th>                     
                                        <th>Total</th> 
                                        <th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($active_orders)):?>
										<?php foreach ($active_orders as $okey => $list): ?>
											<?php 
												$date = new DateTime($order['created_at']);

												$image_path = FCPATH . 'img/services/' . ($list['image'] ?? '');
												$mime_type = get_mime_by_extension($image_path);
								                $is_image = strpos($mime_type, 'image') !== false;
								                $is_video = strpos($mime_type, 'video') !== false;
											?>
											<tr class="tr_class">
												<td style="display: none;"><?php echo $okey + 1; ?></td>
												<td>
													<?php if ($is_image): ?>
														<img class="mr-4" src="<?php echo base_url('img/services/') . $list['image']; ?>" alt="Service Image" width="100">               
									                <?php elseif ($is_video): ?>
									                	<video class="mr-4" width="100" controls autoplay><source src="<?php echo base_url('img/services/') . $list['image']; ?>" type="video/mp4">Your browser does not support the video tag.</video>
									                <?php else:?>
									                	<img class="mr-4" src="<?php echo base_url('img/default-image.jpg'); ?>" alt="Service Image" width="100">
									                <?php endif; ?>	
												</td>
												<td><?php echo $list['service_name']; ?></td>
												<td><?php echo $date->format('F j, Y'); ?></td>
												<td><?php echo '£'.number_format($list['total_price'],2); ?></td>
												<td><?php echo ucfirst($list['status']); ?></td>
												<td>
													<a class="btn btn-anil_btn nx_btn" href="<?php echo base_url('order-tracking/'.$list['id']); ?>">View Orders</a>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif;?>
								</tbody>
							</table>
						<?php } else { ?>
							<div class="verify-page">
								<div style="background-color:#fff;padding: 20px;" class="">
									<p>No active orders found.</p>
								</div>
							</div> <br><br>
						<?php }  ?>	

				<div class="mjq-sh">
					<h2><strong>Work in Progress</strong> </h2>
				</div>

				<?php if ($work_progress) {  ?>
					<table class="table table_nw DataTable">
						<thead>
							<tr class="th_class">
								<th style="display: none;"></th>
								<th>Job Id</th>
								<th>Job Title</th>
								<th>Quote By</th>
								<th>Quote Amount</th>
								<th>Deliver In</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach ($work_progress as $key => $list) {  ?>
								<tr class="tr_class">
									<td style="display: none;"><?php echo $key + 1; ?></td>
									<td><?php echo $list['project_id']; ?></td>

									<?php
									if ($list['direct_hired'] == 1) {
										$tradesment = $this->common_model->GetColumnName('users', array('id' => $list['awarded_to']), array('trading_name'));
										$job_title = 'Work for ' . $tradesment['trading_name'];
									} else {
										$job_title = $list['title'];
									}
									?>
									<td><a href="<?php echo base_url('details/?post_id=' . $list['job_id']); ?>"><?php echo $job_title; ?></a></td>


									<td>
										<?php
										$get_job_bids = $this->common_model->get_job_bids('tbl_jobpost_bids', $list['job_id'], $this->session->userdata('user_id'));
										$get_users = $this->common_model->get_single_data('users', array('id' => $get_job_bids[0]['bid_by']));
										?>
										<a href="<?php echo base_url('profile/' . $get_users['id']); ?>"><?php echo $get_users['trading_name']; ?></a>
									</td>

									<td>
										<?php if ($get_job_bids[0]['bid_amount']) { ?>

											<i class="fa fa-gbp"></i>

										<?php echo $get_job_bids[0]['bid_amount'];
										} else { ?>

											<i class="fa fa-gbp"></i>

										<?php echo "0";
										} ?>

									</td>

									<td>

										<?php if ($get_job_bids[0]['delivery_days']) {
											echo $get_job_bids[0]['delivery_days'] . ' in day(s)';
										} ?>
									</td>



									<td>
										<?php if ($list['status'] == 0 || $list['status'] == 1 || $list['status'] == 3) { ?>

											<span class="label label-success">Open</span>

										<?php }
										if ($list['status'] == 4) { ?>

											<span class="label label-success">Awaiting Acceptance</span>

										<?php }
										if ($list['status'] == 7) { ?>

											<span class="label label-success">In Progress</span>

										<?php }
										if ($list['status'] == 8) { ?>

											<span class="label label-danger">Rejected Award</span>

										<?php }
										if ($list['status'] == 5) { ?>

											<span class="label label-success">Completed</span><?php } ?>
									</td>

									<td>



										<?php if ($list['status'] == 7) { ?>

											<a class="btn btn-anil_btn" href="<?php echo base_url('payments?post_id=' . $list['job_id']); ?>">View milestones</a>

										<?php } else { ?>

											<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id=' . $list['job_id']); ?>">View Quotes</a>

										<?php } ?>



										<?php /*
								<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
									<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" style="text-align: left;">
										<li style="display: none;"><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View</a></li>
										<li style="display: none;">
											<a href="javascript:void(0);" onclick="get_chat_onclick(<?php echo $get_job_bids[0]['bid_by']; ?>,<?php echo $list['job_id']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $get_job_bids[0]['bid_by']; ?>"></span></a>
											<script type="text/javascript">
												setInterval(function(){
													get_unread_msg_count(<?php echo $list['job_id']; ?>,<?php echo $get_job_bids[0]['bid_by']; ?>);
												},3000);
											</script>
										</li>
										<?php if($list['direct_hired']==1){ ?>
										<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id'].'&edit_budget=1'); ?>">Edit Budget</a></li>
										<?php } ?>
										<li><a href="<?php echo base_url('payments?post_id='.$list['job_id']); ?>">Create Milestone</a></li>
										<li><a href="<?php echo base_url('payments?post_id='.$list['job_id']); ?>">Release Milestone</a></li>
										<li><a href="<?php echo base_url('payments?post_id='.$list['job_id']); ?>">Request Milestone Cancellation</a></li>
									</ul>
								</div>
								*/ ?>
									</td>

									<?php /*
							<div class="modal fade popup" id="mark_as_complete<?php echo $list['job_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel" style="text-align: left">Please leave your feedbakc and rating for this job</h4>
										</div>
										<form method="post" id="marks_as_complete<?php echo $list['job_id']; ?>" onsubmit="return mark_complete(<?php echo $list['job_id']; ?>);">
											<div class="modal-body">
												<fieldset>
							
													<!-- Text input-->
													<div class="form-group">
														<div class="col-md-12" style="text-align: left;">
															<div class='rating-stars text-center'>
																<ul id='stars'>
																	<li class='star' title='Poor' data-value='1'>
																		<i class='fa fa-star fa-fw'></i>
																	</li>
																	<li class='star' title='Fair' data-value='2'>
																		<i class='fa fa-star fa-fw'></i>
																	</li>
																	<li class='star' title='Good' data-value='3'>
																		<i class='fa fa-star fa-fw'></i>
																	</li>
																	<li class='star' title='Excellent' data-value='4'>
																		<i class='fa fa-star fa-fw'></i>
																	</li>
																	<li class='star' title='WOW!!!' data-value='5'>
																		<i class='fa fa-star fa-fw'></i>
																	</li>
																</ul>
																<input type="hidden" name="rt_rate" class="rating" value="0" required="" />
																<input type="hidden" name="bid_by" value="<?php echo $get_job_bids[0]['bid_by']; ?>">
																<input type="hidden" name="posted_by" value="<?php echo $get_job_bids[0]['posted_by']; ?>">
															</div>
														</div>
													</div>
													<div class="form-group">
														<label>Feedback:</label>
														<textarea required class="form-control" name="rt_comment" required=""></textarea>
													</div>
												</fieldset>
		 
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" id="wrbtn">Submit<i class="fa fa-spinner fa-spin wrbtnloader" style="font-size:24px;display:none;"></i></button>
											</div>
										</form>
									</div>
								</div>
							</div>


							<div class="modal fade popup" id="create_miles<?php echo $list['job_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Create Milestone</h4>
                    </div>
                    <div id="msg"><?= $this->session->flashdata('msg'); ?></div>
										<form method="post" id="post_mile<?php echo $list['job_id']; ?>" enctype="multipart/form-data"  onsubmit="return update_milestones(<?php echo $list['job_id']; ?>);">
											<div class="modal-body">
												<fieldset>
													<div id="milessss">
														<div class="row">
															<div class="col-sm-8">
																<div class="from-group">
																 <input type="text" class="form-control miname_1" name="tsm_name1" placeholder="Project Milestone" >
																</div>
															</div>
															<div class="col-sm-4">
																<div class="from-group">
																	<input type="hidden" name="total_bids_amount" id="total_bids_amount" value="<?php echo $get_job_bids[0]['bid_amount']; ?>">
																	<input type="number" class="form-control miamount_1" placeholder="Project Amount" min="1" name="tsm_amount1">
																</div>
															</div>
														</div>
													</div> 
													<div class="input-append1">
														<div id="fields">
															<input type="hidden" name="post_id" id="post_id" value="<?php echo $get_job_bids[0]['id']; ?>">
															<input type="hidden" name="bid_by" id="bid_by" value="<?php echo $get_job_bids[0]['bid_by']; ?>">
															<input type="hidden" name="amounts" id="amounts" value="<?php echo $get_job_bids[0]['bid_amount']; ?>">
														</div>
													</div>
													<div class="from-group" style="display: none;">
														<a href="javascript:void(0);" class="btn btn-primary" onclick="add_more_miles1();">Add another milestone </a>
													</div>
								
												</fieldset>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-warning submit_btn5">Save</button>
											</div>
										</form>
									</div>
                </div>
              </div>


							<div class="modal fade in" id="add_category<?php echo $list['job_id']; ?>">
								<div class="modal-body" >
									<div class="modal-dialog">
   
										<div class="modal-content">
          
     
											<div class="modal-header">
												<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
												 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												 <h4 class="modal-title">Description</h4>
											</div>
											<div class="modal-body form_width100">
			
												<p> <?php echo $get_job_bids[0]['propose_description']; ?></p>
											</div>
											<div class="modal-footer">
	 
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
 
										</div>
      
									</div>
								</div>
							</div>
							*/ ?>
								</tr>
							<?php } ?>

						</tbody>
					</table>
				<?php } else { ?>

					<div class="verify-page">
						<div style="background-color:#fff;padding: 20px;" class="">
							<p>No jobs found.</p>
						</div>
					</div>
				<?php }  ?>


			</div>
		</div>


	</div>
</div>
<?php include 'include/footer.php'; ?>
<script>
	/*
function get_chat_onclick(id,post) {
    $.ajax({
    type:'POST',
    url:site_url+'chat/get_chats',
    data:{id:id,post:post},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#rid').val(id);
        $('#post_ids').val(post);
        $('#userdetail').html(resp.userdetail);
        var oldscrollHeight = $("#usermsg").prop("scrollHeight");         
          $('.user_chat').html(resp.data);  
        var newscrollHeight = $("#usermsg").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $("#usermsg").animate({
              scrollTop: newscrollHeight
          }, 'normal');
        }

      } 
                 else
      {
         $('#userdetail').html(resp.userdetail);
         $('.user_chat').html(resp.data); 
      }
 
    }
  });
  return false;
}
function showdiv() {
   $('#chat_user').show();
}
function get_chat_history_interwal() {
  var id = $('#rid').val();
   var post = $('#post_ids').val();
  if(id)
  {
    get_chat_onclick(id,post);
  }
}
function send_msg() {
    var post='<?php echo $_REQUEST['post_id']; ?>';
  $.ajax({
    type:'POST',
     url:site_url+'chat/send_msg',
    data:$('#send_msg').serialize(),
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#ch_msg').val('');
      }
    }
  });
  return false;
}
function get_unread_msg_count(post_id, rid) {
  
  $.ajax({
    type:'POST',
   url:site_url+'chat/get_unread_msg_count',
    data:{post:post_id,rid:rid},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.count_un_msg'+rid).html('('+resp.count+')');
           get_chat_onclick(rid,post_id);
        showdiv();
      }
      else
      {
        $('.count_un_msg'+rid).html('');
      }
    }
  });
  return false;
}
*/
</script>
<script>
	//setInterval(function(){ get_chat_history_interwal(); }, 3000);

	$(function() {
		$("#boottable").DataTable({
			stateSave: true,
			lengthChange: false,
			searching: false,
			//     "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]],
			"pageLength": 5
		});
		$("#activeOrderTable").DataTable({
			stateSave: true,
			lengthChange: false,
			searching: false,
			//     "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]],
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
	/*
  function edit_post(id){

  $.ajax({
   type:'POST',
    url:site_url+'posts/edit_post/'+id,
   data: new FormData($('#edit_post1'+id)[0]),
    dataType: 'JSON',
        processData: false,           
        contentType: false,
        cache: false,
    beforeSend:function(){
      $('.edit_btn'+id).prop('disabled',true);
      $('.edit_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
      $('.editmsg'+id).html('');
			$('.postcode-err'+id).hide();
    },
    success:function(resp){
      if(resp.status==1){
        location.reload();
			} else if(resp.status==3){
				$('.postcode-err'+id).show();
				$('.edit_btn'+id).prop('disabled',false);
        $('.edit_btn'+id).html('Edit');
      } else {
        //location.reload();
        $('.edit_btn'+id).prop('disabled',false);
        $('.edit_btn'+id).html('Edit');
        $('.editmsg'+id).html(resp.msg);
      }
    }
  });
  return false;
}
function changecategory(val,id)
{
  $.ajax({
      url:site_url+'home/get_subcategory',
      type:"POST",
      dataType:'json',
      data:{'val':val,'id':id},
      success:function(datas)
      {
      
          $('#subcategories'+id).html(datas.subcategory);
  
        return false;
      }
  });
  return false;
}

function delenquiry(id) {
   if (confirm("Are you sure?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_file/'+id,
            dataType: 'JSON',
             success:function(resp){
              $('#del_doc'+id).remove();
            } 
        });
    } 
  }
*/
</script>

<script>
	/*
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		menubar: false,
		branding: false,
		statusbar: false,
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}*/
</script>