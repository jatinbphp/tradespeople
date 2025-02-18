<?php include("include/header.php") ?>
<?php
$get_commision = $this->common_model->get_commision();

$bank_Pay_info = '';
$strip_Pay_info = '';
$paypal_Pay_info = '';

$paypal_comm_per = $setting['paypal_comm_per'];
$paypal_comm_fix = $setting['paypal_comm_fix'];

$stripe_comm_per = $setting['stripe_comm_per'];
$stripe_comm_fix = $setting['stripe_comm_fix'];
$bank_processing_fee = $setting['processing_fee'];

if ($this->session->userdata('type') == 2) {
	$strip_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Strip charges (' . $stripe_comm_per . '%+' . $stripe_comm_fix . ') processing fee and processes your payment immediately ." data-original-title="" class="red-tooltip toll stripe-tooltip"><i class="fa fa-info-circle"></i></a>';

	$paypal_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Paypal charges (' . $paypal_comm_per . '%+' . $paypal_comm_fix . ') processing fee and processes your payment immediately." data-original-title="" class="red-tooltip toll paypal-tooltip"><i class="fa fa-info-circle"></i></a>';

	$bank_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="We charge ' . $bank_processing_fee . '% processing fee and process your payment within 1-2 working days." data-original-title="" class="red-tooltip toll bank-tooltip"><i class="fa fa-info-circle"></i></a>';
}

$Claimant = $this->common_model->GetColumnName('users', array('id' => $dispute['disputed_by']), array('f_name', 'l_name', 'type', 'trading_name', 'profile'));
$showStepIn = false;
$new = date('Y-m-d H:i:s');
if ($checkOtherUserReply) {
	$stepINTime = date('Y-m-d H:i:s', strtotime($checkOtherUserReply['dct_created'] . ' +' . $setting['step_in_day'] . ' days'));
	if (strtotime($stepINTime) > strtotime($new)) {
		$diff = date_difference($new, $stepINTime);
		$timeString = '';
		if ($diff['days'] > 0) {
			$timeString .= $diff['days'] > 1 ? $diff['days'] . ' days ' : $diff['days'] . ' day ';
		} else if ($diff['hours'] > 0) {
			$timeString .= $diff['hours'] > 1 ? $diff['hours'] . ' hours ' : $diff['hours'] . ' hour ';
			$timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
		} else if ($diff['minutes'] > 0) {
			$timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
		}

		if ($timeString) {
			$showStepIn = '<h3 class="text-primary text-center">' . $timeString . '</h3><h5 class="text-primary text-center">left to ask team to step in</h5>';
		} else {
			$showStepIn = '<h3 class="text-primary text-center">' . (strtotime($stepINTime) - strtotime($new)) . ' Seconds</h3><h5 class="text-primary text-center">left to ask team to step in</h5>';
		}
	}
}

//$showStepIn = false;
?>
<style>
	.tox-toolbar__primary,
	.tox-editor-header {
		display: none !important;
	}

	.p-0 {
		padding: 0 !important
	}

	.p-1 {
		padding: .25rem !important
	}

	.p-2 {
		padding: .5rem !important
	}

	.p-3 {
		padding: 1rem !important
	}

	.p-4 {
		padding: 1.5rem !important
	}

	.p-5 {
		padding: 3rem !important
	}

	.px-0 {
		padding-right: 0 !important;
		padding-left: 0 !important
	}

	.px-1 {
		padding-right: .25rem !important;
		padding-left: .25rem !important
	}

	.px-2 {
		padding-right: .5rem !important;
		padding-left: .5rem !important
	}

	.px-3 {
		padding-right: 1rem !important;
		padding-left: 1rem !important
	}

	.px-4 {
		padding-right: 1.5rem !important;
		padding-left: 1.5rem !important
	}

	.px-5 {
		padding-right: 3rem !important;
		padding-left: 3rem !important
	}

	.py-0 {
		padding-top: 0 !important;
		padding-bottom: 0 !important
	}

	.py-1 {
		padding-top: .25rem !important;
		padding-bottom: .25rem !important
	}

	.py-2 {
		padding-top: .5rem !important;
		padding-bottom: .5rem !important
	}

	.py-3 {
		padding-top: 1rem !important;
		padding-bottom: 1rem !important
	}

	.py-4 {
		padding-top: 1.5rem !important;
		padding-bottom: 1.5rem !important
	}

	.py-5 {
		padding-top: 3rem !important;
		padding-bottom: 3rem !important
	}

	.pt-0 {
		padding-top: 0 !important
	}

	.pt-1 {
		padding-top: .25rem !important
	}

	.pt-2 {
		padding-top: .5rem !important
	}

	.pt-3 {
		padding-top: 1rem !important
	}

	.pt-4 {
		padding-top: 1.5rem !important
	}

	.pt-5 {
		padding-top: 3rem !important
	}

	.pe-0 {
		padding-right: 0 !important
	}

	.pe-1 {
		padding-right: .25rem !important
	}

	.pe-2 {
		padding-right: .5rem !important
	}

	.pe-3 {
		padding-right: 1rem !important
	}

	.pe-4 {
		padding-right: 1.5rem !important
	}

	.pe-5 {
		padding-right: 3rem !important
	}

	.pb-0 {
		padding-bottom: 0 !important
	}

	.pb-1 {
		padding-bottom: .25rem !important
	}

	.pb-2 {
		padding-bottom: .5rem !important
	}

	.pb-3 {
		padding-bottom: 1rem !important
	}

	.pb-4 {
		padding-bottom: 1.5rem !important
	}

	.pb-5 {
		padding-bottom: 3rem !important
	}

	.ps-0 {
		padding-left: 0 !important
	}

	.ps-1 {
		padding-left: .25rem !important
	}

	.ps-2 {
		padding-left: .5rem !important
	}

	.ps-3 {
		padding-left: 1rem !important
	}

	.ps-4 {
		padding-left: 1.5rem !important
	}

	.ps-5 {
		padding-left: 3rem !important
	}

	.step-main {
		background: #fff;
		margin-top: 30px;
		border: 1px solid #e1e1e1;
	}

	.files {
		margin: 0px;
		padding: 0px;
	}

	.step-main .col-sm-6.text-center {
		position: relative;
		min-height: 210px;
		padding-bottom: 100px;
	}

	/*.myBtag {
		padding: 5px;
		position: absolute;
		bottom: 0px;
		left: 50%;
		transform: translateX(-50%);
		white-space: normal;
    	width: 90%;
		cursor: context-menu;
	}*/

	.myBtag {

		padding: 5px;
		color: #fff;
		position: absolute;
		bottom: 0px;
		left: 50%;
		background: #3d78cb;
		border-radius: 5px;
		font-size: 11px;
		transform: translateX(-50%);
		width: 88%;
		font-weight: 500;
		font-style: italic;
	}

	.btn-mytab-1 {
		position: absolute;
		bottom: 9px;
		left: 20px;
	}

	.reply-btn {
		margin-bottom: 10px;
	}

	.border-top {
		border-top: 1px solid #c5c5c5;
	}

	.border_dashed_top {
		border-bottom: 1px dashed #c5c5c5;
	}

	.border_dashed_bottom {
		border-bottom: 1px dashed #c5c5c5;
	}

	.btn_show_milestone {
		font-style: italic;
		cursor: pointer;
		margin-bottom: 10px;
	}

	.ShowMilestones {
		width: 70%;
		margin: 0 auto;
	}

	.ShowMilestones ul {
		padding: 15px;
	}

	.ShowMilestones ul li {
		display: flex;
		gap: 8px;
	}

	.ShowMilestones ul li p {
		margin: 0;
	}

	.p_left {
		text-align: right;
		width: 30%;

	}

	.p_right {
		text-align: left;
		width: 70%;
	}

	.mx-auto {
		margin-right: auto;
		margin-left: auto;
	}

	.w-70 {
		width: 70%
	}

	/* .panel-success>.panel-heading {
		color: #3c763d;
		background-color: #FEE0CC !important;
	}
	.panel-success>.panel-body {
		color: #3c763d;
		background-color: #FFEFE4 !important;
	} */
	.btn-mytab-1 a {
		margin-top: 5px;
	}

	.top_manin_he1 {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	.top-project-status {
		margin: 0;
	}

	.step-main {
		padding: 0 15px;
	}

	.dispute.d_sm_block {
		display: none;
	}

	h1.heading-inner.d_sm_block {
		display: none;
	}

	@media screen and (max-width:767px) {
		.treadman_50 {
			display: flex;
			justify-content: center;
			align-items: flex-start;
		}

		.treadman_50 .col-sm-6 {
			width: 50%;
		}

		.btn-mytab-1 {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 5px;
			width: 100%;
			flex-wrap: wrap;
		}

		.width-40 {
			width: 80%;
			float: left;
			margin-left: 5%;
		}

		.dispute.d_sm_block {
			display: block;
		}

		.row.row_for_mobile {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			flex-flow: column-reverse;
		}

		.step-main {
			margin-top: 0px;
		}

		.d_lg_block {
			display: none;
		}

		h1.heading-inner.d_sm_block {
			font-size: 25px;
			padding: 0 15px;
		}

		.dis-section {
			margin-top: 20px;
		}

		h1.heading-inner.d_sm_block {
			display: block;
		}
	}


	@media screen and (max-width:600px) {
		.width-40 {
			width: 70%;
			margin-left: 5%;
		}

		.btn-mytab-1 {
			justify-content: unset;
			gap: 0;
			width: unset;
		}
	}

	@media screen and (max-width:375px) {
		.width-40 {
			margin-left: 0;
		}
		form .width-40 {
		    margin-left: 0;
		    width: 60%;
		}
		.m-1 {
		    margin: 2px;
		}
	}

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
	/*----------LOADER CSS END----------*/s
</style>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="acount-page membership-page project-list">
	<div class="container">
		<div class="row row_for_mobile">
			<div class="col-md-3">
				<?php include 'include/sidebar.php'; ?>				
			</div>
			<?php if (count($dispute) > 0) { ?>
				<div class="col-sm-5">
					<h2 class="heading-inner d_lg_block" style="margin-top:0!important">Order payment dispute</h2>
					<div class="dispute">
						<div class="manage-profile">
							<div class="inner-box">
								<div class="inner-body">
									<div class="dispute">
										<div class="">
											<div class="lislll_ideaa d_lg_block">
												<div class="listr_uuusdisp2">
													<p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>
													<?php
													if ($value['dct_isfinal'] == 1) {
													} else {
														$winner = '';
													}
													?>

													<p>Case status: <span class="bol_c2 pull-right">
															<?php if ($dispute['ds_status'] == '0') {
																echo 'Open';
															} else {
																echo 'Closed';
															} ?>
														</span>
													</p>
													<?php if ($dispute['ds_status'] == '1') { ?>
														<p>Decided in: <span class="bol_c2 pull-right">
																<?php
																$favorOf = $this->common_model->GetColumnName('users', array('id' => $dispute['ds_favour']), array('f_name', 'l_name', 'type', 'trading_name'));


																$winner = ($favorOf['type'] == 2) ? $favorOf['f_name'] . ' ' . $favorOf['l_name'] : $favorOf['trading_name'];


																echo $winner . ' favour';
																?>
															</span>
														</p>
													<?php } ?>
												</div>
											</div>
											<div class="dis-section">
												<div class="row">
													<div class="col-sm-12">
														<div class="dis_div chan_dess">
															<div class="user-imge">
																<?php
																if ($Claimant['profile']) {
																	$profile = $Claimant['profile'];
																} else {
																	$profile = "dummy_profile.jpg";
																}
																?>
																<img src="<?php echo site_url('img/profile/' . $profile); ?>">
															</div>
															<div class="panel panel-default panel-final">
																<div class="panel-heading">
																	<h1>
																		Claimant:
																	</h1>

																	<p class="rbefff1"><?php echo ($Claimant['type'] == 2) ? $Claimant['f_name'] . ' ' . $Claimant['l_name'] : $Claimant['trading_name']; ?></p>
																</div>
																<div class="panel-body">
																	<?php echo $dispute['ds_comment']; ?>
																	<br>
																	<br>
																	<?php echo $dispute['reason2'];
																	if (!empty($files)) {
																		foreach ($files as $file) {
																			echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
																		}
																	} ?>
																</div>
																<div class="panel-heading">

																</div>
															</div>
														</div>
														<!--loop-->
														<?php if (count($disput_comment) > 0) {

															foreach ($disput_comment as $value) {
																$class = "default";
																if ($value['dct_isfinal'] == 1) {
																	//$class = "success";
																}
																if ($value['dct_userid'] == 0) {

																	$profile = 'admin-img.png';
																	$name = 'Dispute team';
																} else {
																	$user = $this->common_model->get_userDataByid($value['dct_userid']);

																	if ($user['profile']) {
																		$profile = $user['profile'];
																	} else {
																		$profile = "dummy_profile.jpg";
																	}

																	$name = ($user['type'] == 1) ? $user['trading_name'] : $user['f_name'] . ' ' . $user['l_name'];
																}

																$c_files = $this->common_model->get_all_data('dispute_file', "dispute_id = '" . $dispute['ds_id'] . "' and conversation_id = '" . $value['dct_id'] . "'", 'id', 'ASC');
														?>
																<div class="dis_div chan_dess">

																	<div class="user-imge">
																		<?php
																		if ($profile) { ?>
																			<img src="<?php echo site_url('img/profile/' . $profile); ?>">
																		<?php } ?>
																	</div>
																	<div class="panel panel-<?php echo $class; ?> panel-final">
																		<div class="panel-heading" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FEE0CC"' : '' ?>>
																			<h1>
																				<?php echo $name; ?>
																				<?php if ($value['dct_isfinal'] == 1 && $value['is_reply_pending'] == 1) { ?>
																					<span class="ddell">Deadline: No reply</span>
																				<?php } ?>
																			</h1>


																		</div>
																		<div class="panel-body" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FFEFE4"' : '' ?>>
																			<?php echo  $value['dct_msg']; ?>
																			<br>

																			<?php echo $dispute['reason2'];
																			if (!empty($c_files)) {
																				foreach ($c_files as $file) {
																					echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
																				}
																			} ?>

																			<?php if ($value['dct_image']) { ?>
																				<p class="files"><a download href="<?php echo base_url('img/dispute/' . $value['dct_image']); ?>" target="_blank"><?= $value['original_image_name'] ?></a></a>
																				<?php } ?>
																		</div>
																		<div class="panel-heading" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FEE0CC"' : '' ?>>
																			<?php
																			if ($value['message_to'] != 0) {
																				$reply_to = $this->common_model->GetColumnName('users', array('id' => $value['message_to']), array('f_name', 'l_name', 'type', 'trading_name'));
																			?>
																				<p class="rrrdd">
																					Message for: <?php echo ($reply_to['type'] == 2) ? $reply_to['f_name'] . ' ' . $reply_to['l_name'] : $reply_to['trading_name']; ?>,
																					<?php if ($value['end_time']) { ?>
																						reply before: <?php echo date('d M Y h:i:s A', strtotime($value['end_time'])); ?>
																					<?php } ?>
																				</p>
																			<?php } ?>
																			<h3> <?php echo date('d-M-Y H:i:s a', strtotime($value['dct_created'])); ?></h3>
																		</div>
																	</div>
																</div>

														<?php }
														} ?>
														<!--loop-->
														<!--loop-->
														<?php if (count($disput_comment_arbitration) > 0) {

															foreach ($disput_comment_arbitration as $value) {
																$class = "default";
																if ($value['dct_isfinal'] == 1) {
																	$class = "success";
																}

																$profile = 'admin-img.png';
																$name = 'Arbitrate team';


																$c_files = $this->common_model->get_all_data('dispute_file', "dispute_id = '" . $dispute['ds_id'] . "' and conversation_id = '" . $value['dct_id'] . "'", 'id', 'ASC');
														?>
																<div class="dis_div chan_dess">

																	<div class="user-imge">
																		<?php
																		if ($profile) { ?>
																			<img src="<?php echo site_url('img/profile/' . $profile); ?>">
																		<?php } ?>
																	</div>
																	<div class="panel panel-<?php echo $class; ?> panel-final">
																		<div class="panel-heading" style="background:#FEE0CC">
																			<h1>
																				<?php echo $name; ?>
																				<?php if ($value['dct_isfinal'] == 1 && $value['is_reply_pending'] == 1) { ?>
																					<span class="ddell">Deadline: No reply</span>
																				<?php } ?>
																			</h1>


																		</div>
																		<div class="panel-body" style="background:#FFEFE4">
																			<?php echo  $value['dct_msg']; ?>
																			<br>

																			<?php echo $dispute['reason2'];
																			if (!empty($c_files)) {
																				foreach ($c_files as $file) {
																					echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
																				}
																			} ?>

																			<?php if ($value['dct_image']) { ?>
																				<p class="files"><a download href="<?php echo base_url('img/dispute/' . $value['dct_image']); ?>" target="_blank"><?= $value['original_image_name'] ?></a></a>
																				<?php } ?>
																		</div>
																		<div class="panel-heading" style="background:#FEE0CC">
																			<?php
																			if ($value['message_to'] != 0) {
																				//echo '<pre>'; print_r($value); echo '</pre>';
																				$reply_to = $this->common_model->GetColumnName('users', array('id' => $value['message_to']), array('f_name', 'l_name', 'type', 'trading_name'));
																			
																			if ($value['is_reply_pending']==1) { ?>
																				<p class="rrrdd">
																					Message for: <?php echo ($reply_to['type'] == 2) ? $reply_to['f_name'] . ' ' . $reply_to['l_name'] : $reply_to['trading_name']; ?>,
																						pay before: <?php echo date('d M Y h:i:s A', strtotime($value['end_time'])); ?>
																					</p>
																				<?php } ?>
																			<?php } ?>
																			<h3> <?php echo date('d-M-Y H:i:s a', strtotime($value['dct_created'])); ?></h3>
																		</div>
																	</div>
																</div>

														<?php }
														} ?>
														<!--loop-->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="reppll">
							<?php if ($dispute['ds_status'] == '0' && (!$home_stepin || !$trades_stepin)) { ?>
								<div class="reply-btn text-right">
									<a class="btn btn-primary" data-toggle="modal" data-target="#disputework">Reply</a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-sm-4 p-sm-0">
					<a href="<?php echo base_url().'order-tracking/'.$dispute['ds_job_id']?>">Go Back to Order Details</a>
					<!-- <h1 class="heading-inner d_sm_block">Order payment dispute</h1> -->
					<div class="dispute d_sm_block">
						<div class="lislll_ideaa">
							<div class="listr_uuusdisp2">
								<p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>

								<?php
								if ($value['dct_isfinal'] == 1) {
								} else {
									$winner = '';
								}
								?>

								<p>Case status: <span class="bol_c2 pull-right">
										<?php if ($dispute['ds_status'] == '0') {
											echo 'Open';
										} else {
											echo 'Closed';
										} ?>
									</span>
								</p>
								<?php if ($dispute['ds_status'] == '1') { ?>
									<p>Decided in: <span class="bol_c2 pull-right">
											<?php
											$favorOf = $this->common_model->GetColumnName('users', array('id' => $dispute['ds_favour']), array('f_name', 'l_name', 'type', 'trading_name'));


											$winner = ($favorOf['type'] == 2) ? $favorOf['f_name'] . ' ' . $favorOf['l_name'] : $favorOf['trading_name'];


											echo $winner . ' favour';
											?>
										</span>
									</p>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="step-main">
						<div class="bg-light p-3">
							<?php if ($dispute['ds_status'] == '0') {
								if (!$checkOtherUserReply) {
									$newTime = date('Y-m-d H:i:s', strtotime($dispute['ds_create_date'] . ' +' . $setting['waiting_time'] . ' days'));
									$diff = date_difference($new, $newTime);
							?>
									<h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
									<h5 class="text-primary text-center">left for <?= ($dispute['disputed_by'] == $tradmen['id']) ? $owner['f_name'] . ' ' . $owner['l_name'] : $tradmen['trading_name'] ?> to respond</h5>

								<?php } else if ($showStepIn) {
									  echo $showStepIn;
								} else if ($home_stepin && $trades_stepin) { ?>
								<?php } else if ($home_stepin) {
									$newTime = $home_stepin['expire_time'];
									$diff = date_difference($new, $newTime);
								?>
									<h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
									<h5 class="text-primary text-center">left for <?= ($tradmen['id'] == $user_id) ? 'you' : $tradmen['trading_name'] ?> to pay arbitration fee</h5>
								<?php } else if ($trades_stepin) {
									$newTime = $trades_stepin['expire_time'];
									$diff = date_difference($new, $newTime);
								?>
									<h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
									<h5 class="text-primary text-center">left for <?= ($owner['id'] == $user_id) ? 'you' : $owner['f_name'] . ' ' . $owner['l_name'] ?> to pay arbitration fee</h5>
								<?php } ?>
							<?php } ?>

							<h5 class="text-center border_dashed_top py-3 mx-auto w-70">Total amount disputed: <font style="font-size: 24px;">£<?php echo $dispute['total_amount']; ?></font>
							</h5>
							<div class="row">
								<div class="col-sm-12 ">
									<div class="ShowMilestones hide border_dashed_bottom pb-3">
										<ul style="text-align: center;">
											<?php foreach ($milestones as $milestone) {
												echo '<li style="list-style: none;" ><p class="p_left">£' . $milestone['milestone_amount'] . ':</p><p class="p_right" >' . $milestone['milestone_name'] . '</p></li>';
											} ?> 
										</ul>
										<p style="text-align:center; margin-bottom: 0;">Project will be closed upon resolution</p>
									</div>
									<a class="pull-right btn_show_milestone pt-2" onclick="$('.ShowMilestones').toggleClass('hide')">
										Show Milestones
									</a>					
								</div>
							</div>
							<div class="row pt-3 border-top treadman_50">
								<?php if ($owner['id'] == $user_id) { ?>
									<!--main browser-->
									<div class="col-sm-6 text-center">
										Homeowner (you) wants to pay:<br>
										<?php if ($dispute['homeowner_offer']) { ?>

											<font style="font-size: 30px">£<?= $dispute['homeowner_offer'] ?></font>
										<?php } else { ?>
											<p class="myBtag">You've not made an offer yet</p>
										<?php } ?>


										<br>

										<?php
										if ($dispute['ds_status'] == '0') {
											if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 0) {
												echo '<p class="myBtag">Awaiting tradesman response</p>';
											} else if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 2) {
												echo '<p class="myBtag">Tradesman rejected your offer</p>';
											}
										}
										?>

									</div>
									<div class="col-sm-6 text-center" style="border-left: 1px solid #c5c5c5;">

										Tradesman (<?= $tradmen['trading_name']; ?>) want to receive:<br>
										<?php if ($dispute['tradesmen_offer']) { ?>
											<font style="font-size: 30px">£<?= $dispute['tradesmen_offer'] ?></font>
										<?php } else { ?>
											<p class="myBtag"><?= $tradmen['trading_name']; ?> has not made an offer yet</p>
										<?php } ?>
										<br>

										<?php
										if ($dispute['ds_status'] == '0') {
											if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 0) {
												echo '<div class="btn-mytab-1"><a class="btn btn-warning btn-xs" onclick="return confirm(\'Are are sure, you want to accept and close this dispute?\');" href="' . site_url() . 'order_dispute_accept_and_close/' . $dispute['ds_id'] . '/' . $dispute['ds_job_id'] . '">Accept and close</a>';
												if($checkOtherUserReply){
													echo ' &nbsp;<a class="btn btn-danger btn-xs" onclick="return confirm(\'Are are sure, you want to reject this?\');" href="' . site_url() . 'order_reject_dispute_offer?dispute_id=' . $dispute['ds_id'] . '&user_id=' . $user_id . '&job_id=' . $dispute['ds_job_id'] . '">Reject</a>';
												} else {
													echo ' &nbsp;<a class="btn btn-danger btn-xs" onclick="return swal.fire(\'Please reply before rejecting offer\'); return false;" href="javascript:;">Reject</a>';
												}

												echo '</div>';
												
											} else if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 2) {
												echo '<p class="myBtag">You rejected tradesman offer</p>';
											}
										}
										?>


									</div>


								<?php } else { ?>
									<!--private browser-->
									<div class="col-sm-6 text-center">

										Tradesman (you) want to receive:<br>
										<?php if ($dispute['tradesmen_offer']) { ?>
											<font style="font-size: 30px">£<?= $dispute['tradesmen_offer'] ?></font>
										<?php } else { ?>
											<p class="myBtag">You've not made an offer yet</p>
										<?php } ?>
										<br>

										<?php
										if ($dispute['ds_status'] == '0') {
											if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 0) {
												echo '<p class="myBtag">Awaiting homeowner response</p>';
											} else if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 2) {
												echo '<p class="myBtag">Homeowner rejected your offer</p>';
											}
										}
										?>


									</div>
									<div class="col-sm-6 text-center" style="border-left: 1px solid #c5c5c5;">

										Homeowner (<?= $owner['f_name'] . ' ' . $owner['l_name']; ?>) wants to pay:<br>
										<?php if ($dispute['homeowner_offer']) { ?>
											<font style="font-size: 30px">£<?= $dispute['homeowner_offer'] ?></font>
										<?php } else { ?>
											<p class="myBtag"><?= $owner['f_name'] . ' ' . $owner['l_name']; ?> has not made an offer yet</p>
										<?php } ?>


										<br>

										<?php
										if ($dispute['ds_status'] == '0') {
											if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 0) {
												echo '<div class="btn-mytab-1"><a class="btn btn-warning btn-xs" onclick="return confirm(\'Are are sure, you want to accept and close this dispute?\');" href="' . site_url() . 'order_dispute_accept_and_close/' . $dispute['ds_id'] . '/' . $dispute['ds_job_id'] . '">Accept and close</a>';
												if($checkOtherUserReply){
												echo ' &nbsp;<a class="btn btn-danger btn-xs" onclick="return confirm(\'Are are sure, you want to reject this?\');" href="' . site_url() . 'order_reject_dispute_offer?dispute_id=' . $dispute['ds_id'] . '&user_id=' . $user_id . '&job_id=' . $dispute['ds_job_id'] . '">Reject</a>';

											} else {
												echo ' &nbsp;<a class="btn btn-danger btn-xs" onclick="return swal.fire(\'Please reply before rejecting offer\'); return false;" href="javascript:;">Reject</a>';
											}

												echo '</div>';
											} else if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 2) {
												echo '<p class="myBtag">You rejected homeowner offer</p>';
											}
										}
										?>

									</div>


								<?php } ?>

							</div>
							<?php if ($dispute['ds_status'] == '0') { ?>
								<div class="col-sm-12 text-center" style="margin-bottom: 10px;"> or<br> <?= ($tradmen['id'] == $user_id) ? 'Make offer you wish to receive' : 'Make a new offer you wish to pay' ?>:</div>
								<div class="row">
									<div class="col-sm-2"></div>
									<form method="post" onsubmit="return checkValidation();" action="<?php echo site_url() . 'order_submit_dispute_offer/?dispute_id=' . $dispute['ds_id'] . '&user_id=' . $user_id . '&job_id=' . $dispute['ds_job_id'] ?>">

										<?php
										$minAmount = 0;
										$maxAmount = $dispute['total_amount'];
										if ($owner['id'] == $user_id && $dispute['homeowner_offer']) {
											$minAmount = $dispute['homeowner_offer'];
										} else if ($tradmen['id'] == $user_id && $dispute['tradesmen_offer']) {
											$maxAmount = $dispute['tradesmen_offer'];
										}
										?>

										<div class="col-sm-4 width-40">
											<div class="input-group mb-3" style="display: flex; align-items: center;">
												<span class="input-group-text bg-light border-0" id="basic-addon1"> £ </span>
												<input type="number" required data-min="<?= $minAmount ?>" name="offer" id="offer_amount" data-max="<?php echo $maxAmount; ?>" class="form-control w-50">
											</div>
										</div>
										<?php
										//print_r($checkOtherUserReply);
										if (!$checkOtherUserReply && $dispute['dispute_to'] == $user_id) { ?>
											<div class="col-sm-12 mt-3 me-auto">
												<button type="button" disabled class="disabled btn btn-primary w-100 rounded-0">SUBMIT</button>
												<p class="text text-danger" style="text-align:center">Please reply before submitting offer</p>
											</div>
										<?php } else { ?>
											<!-- <div class="col-sm-4 mt-3 me-auto"> -->
												<button type="submit" class="btn btn-primary w-100 rounded-0">SUBMIT</button>
											<!-- </div> -->
										<?php } ?>
									</form>
								</div>
								<div class="col-sm-12 text-center" style="margin-top: 20px;">
									Enter an amount between £<?= $minAmount ?> and £<?php echo $maxAmount; ?> GBP
								</div>
								<div class="col-sm-3"></div>
								<div class="col-sm-6" style="margin-top: 10px; margin-bottom: 20px;">
									<!--button type="submit" class="btn btn-primary w-100 rounded-0">CANCEL DISPUTE</button-->
								</div>
							<?php } ?>

							<div class="reppll">
								<?php if ($dispute['ds_status'] == '0') { ?>
									<div class="reply-btn text-center">
										<?php if ($dispute['disputed_by'] == $user_data['id']) { ?>
											<a class="btn btn-primary p-2 m-1" onclick="return confirm('Are are sure, you want to cancel this dispute?');" href="<?php echo site_url() . 'order_cancel_dispute/' . $dispute['ds_id'] . '/' . $dispute['ds_job_id']; ?>">Cancel Dispute</a>
										<?php } ?>
										<?php
										if ($checkOtherUserReply) {
											if ($showStepIn) {

										?>
												<a class="btn btn-primary p-2 m-1" onclick="swal.fire({'title':'Warning','type':'info','text':'You can ask our dispute team to step in after <?php echo date('d-m-Y h:i A', strtotime($stepINTime)); ?>.'})" href="javascript:;">Ask team to step in</a>
												<?php } else {

												if ((!$home_stepin && $owner['id'] == $user_id) || (!$trades_stepin && $tradmen['id'] == $user_id)) {
												?>
													<a class="btn btn-primary ask-admin-button1 p-2 m-1" onclick="askAdminToStepIn1();" href="javascript:;">Ask team to step in</a>
													<div class="ask-admin-div2" style="display:none">
														<br>
														<p style="border: 1px solid #c5c5c5;display: inline-block;margin: 0 0px 10px 0px;padding: 5px;">If you can´t reach an agreement with the other party, you can ask our dispute team to step in after paying an arbitration fee of £<?= $setting['step_in_amount'] ?>.The fee will be returned upon wining the case. </p>
														<a class="btn btn-primary ask-admin-button2 p-2 m-1" onclick="askAdminToStepIn();" href="javascript:;">Pay and continue to arbitration</a>
													</div>
													<script>
														function askAdminToStepIn1() {
															$('.ask-admin-button1').hide();
															$('.ask-admin-div2').show();
														}

														function askAdminToStepIn() {
															Swal.fire({
																type: "warning",
																title: 'Are you sure?',
																showCancelButton: true,
																confirmButtonText: 'Pay Now',
																html: '<h3>You want to pay an arbitration of £<?= $setting['step_in_amount'] ?></h3>'
															}).then((result) => {
																console.log(result);
																if (result.value === true) {
																	submitAsktoAdmin();
																}
															})
														}
													</script>
												<?php } ?>
											<?php } ?>
										<?php } ?>


									</div>


									<hr style="width: 100%;">
									<div style=" text-align:center">
										<p style=""><strong>Agreed: </strong>£0.00</p>
									</div>
								<?php } else { ?>
									<hr>
									<div style=" text-align:center">
										<p style=""><strong>Agreed: </strong>£<?php // echo ($dispute['caseCloseStatus'] == 5) ? (($dispute['last_offer_by']==$tradmen['id']) ? $dispute['tradesmen_offer'] : $dispute['homeowner_offer']) : '0.00'; ?>
										<?php echo ($dispute['caseCloseStatus'] == 5) ? (($dispute['last_offer_by']==$tradmen['id']) ? $dispute['agreed_amount'] : $dispute['agreed_amount']) : '0.00'; ?></p>
										<p style="color:red; text-transform:uppercase;"><strong>

												<?php
												if ($dispute['caseCloseStatus'] == 1) {

													echo "Resolved, Not Responded";
												} else if ($dispute['caseCloseStatus'] == 2) {

													echo "Resolved, Cancelled";
												} else if ($dispute['caseCloseStatus'] == 3) {

													echo "Resolved, Arbitration Fees Not Paid";
												} else if ($dispute['caseCloseStatus'] == 4) {

													echo "Resolved By Dispute Team";
												} else if ($dispute['caseCloseStatus'] == 5) {

													echo "Resolved, Offer Accepted";
												} else {
													echo "Resolved, Dispute Closed";
												}
												?>
											</strong></p>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
</div>

<?php if ($dispute['ds_status'] == '0') { ?>
	<div class="modal fade" id="pay_when_accept_direct_hire_model" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Choose Type</h4>
				</div>
				<div class="modal-body">
					<div class="msgs1"></div>

					<div class="common_pay_main_div ">
						<div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet. <span class="Current_wallet_amount___1"></span></div> <br>

						<div class="form-group">
							<label>Enter Amount</label>
							<input type="number" class="form-control" value="<?php echo $setting['step_in_amount']-$user_data['u_wallet']; ?>" onkeyup="check_value___1(this.value);" id="amount___1">
						</div>

						<p class="instant-err___1 alert alert-danger" style="display:none;"></p>

						<div class="card pay_btns__1  all-pay-tooltip">
							<div class="col-sm-2" style="padding: 0;"></div>
							<div class="col-sm-4" style="padding: 0;">
								<div onclick="show_lates_stripe_popup(<?php echo $setting['step_in_amount']-$user_data['u_wallet']; ?>,<?php echo $setting['step_in_amount']-$user_data['u_wallet']; ?>,10,<?php echo $dispute['ds_id']; ?>);" class="pay_btn___1 strip_btn" id="strip_btn___1"><img src="<?= base_url(); ?>img/pay_with.png"></div> <?= $strip_Pay_info; ?>
							</div>
							<div class="col-sm-4" style="padding: 0;">
								<div class="pay_btn___1 paypal_btn" id="paypal_btn___1"></div> <?= $paypal_Pay_info; ?>
							</div>

						</div>

						<div class="common_pay_loader pay_btns_laoder___1 text-center" style="display:none;">
							<i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
						</div>
						<br>
					</div>



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<div class="modal fade" id="disputework" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<!-- <form method="post" action="process/process1.php?action=add_dispute_comment"> -->
				<form method="post" onsubmit="return check_from();" id="replyForm" action="<?php echo site_url('order_sen_comment'); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Reply to Dispute</h4>
					</div>
					<div class="modal-body" id="PublishDetailshow">
						<div class="form-group">
							<label class="control-label">Comment : </label>
							<div class="">
								<textarea cols="45" rows="8" name="dct_msg" id="dct_msg" class="form-control "></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Image : </label>
							<div class="">
								<input type="file" onchange="uploadImageForDispute()" id="dispute-file-upload-input" name="files[]" accept="image/*,pdf" multiple class="form-control">
							</div>
						</div>
						<div class="col-sm-12" style="margin-top: 10px; padding: 0px;">
							<table class="table">
								<thead>
									<tr>
									</tr>
								</thead>
								<tbody class="disputeUploadFilesHtml">

								</tbody>
							</table>
						</div>

						<input type="hidden" name="ds_id" value="<?php echo $dispute['ds_id']; ?>">
						<input type="hidden" name="post_by" value="<?php echo $dispute['ds_puser_id']; ?>">
						<input type="hidden" name="bid_by" value="<?php echo $dispute['ds_buser_id']; ?>">
						<input type="hidden" name="job_id" value="<?php echo $dispute['ds_job_id']; ?>">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-theme disput_btn" value="submit">Submit <i class="fa fa-spin fa-spinner disput_loader" style="font-size:24px;display:none;"></i></button>
					</div>
				</form>
			</div>

		</div>
	</div>
<?php } ?>

<script>
	function checkValidation(){

		let amount = $('#offer_amount').val();
		let min = $('#offer_amount').attr('data-min')*1;
		let max = $('#offer_amount').attr('data-max')*1;

		

		if(!amount){
			
			swal.fire({
				'title': '',
				'type': 'error',
				'text': 'Please enter offer amount'
			})
			return false;
		}

		amount = amount*1;

		

		if(amount > max){
			
			swal.fire({
				'title': '',
				'type': 'error',
				'text': 'The offer amount must be less than or equal to '+max
			})
			return false;
		}
		if(amount < min){
			
			swal.fire({
				'title': '',
				'type': 'error',
				'text': 'The offer amount must be more than or equal to '+min
			})
			return false;
		}

	}
	function check_value___1(value) {
		var min_amount = <?php echo $setting['step_in_amount']-$user_data['u_wallet']; ?>;
		var max_amount = <?php echo $setting['p_max_d']; ?>;
		if (value >= min_amount && value <= max_amount) {
			//$('.show_btn').prop('disabled',false);
			$('.instant-err___1').hide();
			$('.instant-err___1').html('');

			var processing_fee = 0;
			var actual_amt = parseFloat(value);

			var stripe_comm_per = <?= $stripe_comm_per; ?>;
			var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
			var type = <?= $this->session->userdata('type'); ?>;
			var amount___1_wp = actual_amt;

			if (type == 2) {
				if (stripe_comm_per > 0 || stripe_comm_fix == 0) {
					processing_fee = (1 * actual_amt * stripe_comm_per) / 100;
					amount___1_wp = actual_amt + processing_fee + stripe_comm_fix;
				}
			}

			amount___1_wp = amount___1_wp.toFixed(2);

			var instantId = '<?php echo $dispute['ds_id'] ?>';

			$('#strip_btn___1').attr('onclick', 'show_lates_stripe_popup(' + amount___1_wp + ',' + actual_amt + ',10,' + instantId + ');');

			show_main_btn_two___1(amount___1);
		} else {
			$('.card___1').hide();
			//$('.show_btn').prop('disabled',true);
			$('.instant-err___1').show();
			$('.instant-err___1').html('Deposit amount must be more than <i class="fa fa-gbp"></i>' + min_amount + ' and less than <i class="fa fa-gbp"></i>' + max_amount + '!');
			$('.pay_btns___1').hide();
		}
	}

	function show_main_btn_two___1(amount___1) {
		$('.pay_btns___1').show();
		$('#paypal_btn___1').html('');

		var processing_fee = 0;
		var actual_amt = parseFloat(amount___1);

		var type = <?= $this->session->userdata('type'); ?>;
		var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
		var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
		var processing_fee = 0;
		var amount___1_wp = actual_amt;

		if (type == 2) {
			if (paypal_comm_per > 0 || paypal_comm_fix > 0) {
				processing_fee = ((actual_amt * paypal_comm_per) / 100);
				var amount___1_wp = processing_fee + actual_amt + paypal_comm_fix;
			}
		}

		var amount___1_wp = amount___1_wp.toFixed(2);


		paypal.Button.render({
			env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
			client: {
				sandbox: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
				production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
			},

			// Show the buyer a 'Pay Now' button in the checkout flow
			commit: true,

			// payment() is called when the button is clicked
			payment: function(data, actions) {

				// Make a call to the REST api to create the payment
				return actions.payment.create({
					payment: {
						transactions: [{
							amount: {
								total: amount___1_wp,
								currency: 'GBP'
							}
						}]
					}
				});
			},

			// onAuthorize() is called when the buyer approves the payment
			onAuthorize: function(data, actions) {
				// Make a call to the REST api to execute the payment
				return actions.payment.execute().then(function() {
					console.log('Payment Complete!');
					$.ajax({
						type: 'POST',
						url: site_url + 'wallet/paypal_deposite',
						data: {
							itemPrice: amount___1,
							itemId: 'Deposit in wallet',
							orderID: data.orderID,
							txnID: data.paymentID,
						},
						dataType: 'JSON',
						beforeSend: function() {
							$('.pay_btns___1').hide();
							$('.pay_btns_laoder___1').show();
						},
						success: function(resp) {
							if (resp.status == 1) {
								submitAsktoAdmin();
							} else {
								$('.pay_btns___1').show();
								$('.pay_btns_laoder___1').hide();

								swal.fire({
									'title': 'Opps',
									'type': 'error',
									'text': resp.msg
								})
							}
						}
					});
				});
			}
		}, '#paypal_btn___1');
	}

	function submitAsktoAdmin() {
		$('#pay_when_accept_direct_hire_model').modal('hide');
		$.ajax({
			type: 'POST',
			url: site_url + 'ordersubmitAsktoAdmin',
			data: {
				id: <?php echo $dispute['ds_id'] ?>
			},
			dataType: 'JSON',
			async: false,
			beforeSend: function() {
				$('.ask-admin-button2').prop('disabled', true);
				$('.ask-admin-button2').html('<i class="fa fa-spin fa-spinner"></i> Processing');
			},
			success: function(resp) {
				$('.ask-admin-button2').prop('disabled', false);
				$('.ask-admin-button2').html('Pay and continue to arbitration');
				console.log(resp);
				if (resp.status == 1) {

					//$(".close").trigger("click");
					//get_chat_onclick(id);
					//showdiv();
					location.reload();
				} else if (resp.status == 2) {

					$('#pay_when_accept_direct_hire_model').modal('show');
					//$('.instant-payment-button___1').show();
					show_main_btn_two___1(<?php echo $setting['step_in_amount']; ?>-parseFloat(resp.wallet));
					//amounts = resp.amount;

					//$('.msgs1').html(resp.msg);
					$('.Current_wallet_amount___1').html('Your last updated wallet amount is <i class="fa fa-gbp"></i>' + resp.wallet);
					$('.pay_btns_laoder___1').hide();
					//instantId = id;

				} else {
					swal.fire({
						'title': 'Opps',
						'type': 'error',
						'text': 'Something went wrong play try again later.'
					})
				}
			}
		});
	}

	$(function() {
		tinymce.init({
			selector: '.textarea',
			height: 200,
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			setup: function(editor) {
				editor.on('change', function() {
					tinymce.triggerSave();
				});
			}
		});
	})



	function check_from() {
		var msg = $('#dct_msg').val();
		if (!msg) {
			alert('Add you comment!');
			return false;
		}
	}

	function uploadImageForDispute() {
		var formData = new FormData($('#replyForm')[0]);

		$.ajax({
			url: '<?= base_url() ?>Order_dispute/add_dispute_files',
			type: 'POST',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType: 'json',
			beforeSend: function() {
				$('.disput_btn').prop('disabled', true)
				$('.disput_btn').html('Files uploading...')
			},
			success: function(res) {
				$('.disput_btn').prop('disabled', false)
				$('.disput_btn').html('Submit <i class="fa fa-spin fa-spinner disput_loader" style="font-size:24px;display:none;"></i>')

				if (res.status == 1) {
					$(`#dispute-file-upload-input`).val('');
					for (let i = 0; i < res.files.length; i++) {
						let fileData = res.files[i];
						let html = `<tr>
                                 <td>${fileData.original_name}</td>
                                 <td>${fileData.size}</td>
                                 <td><button onclick="$(this).parent('td').parent('tr').remove()" type="button" class="btn btn-default" style=" padding: 1px 11px;">Delete</button></td>
                                 <input type="hidden" name="file_name[]" value="${fileData.name}">
                                 <input type="hidden" name="file_original_name[]" value="${fileData.original_name}">
                              </tr>`;

						$('.disputeUploadFilesHtml').append(html);
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
<?php include("include/footer.php") ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>