<?php 
include 'include/header.php';
if($this->session->userdata('type')==2){
	redirect('dashboard');
}
$billing_details = $this->common_model->get_single_data("billing_details", array("user_id" => $user_data['id']));
?>
<style>
html {
  scroll-behavior: smooth;
}
.contt_tab ul li {
	text-align: justify;
}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="mjq-sh">
						<h2><strong>Change Your Subscription Plan</strong></h2>
					</div>
					<?php 
					if($user_plans){ 
					
						$get_all_packages=$this->common_model->get_single_data('tbl_package',array('id'=>$user_plans[0]['up_plan']));
						
						$auto_update = $user_plans[0]['auto_update'];
						
						$class = ($auto_update==1)?'col-md-3':'col-md-4';
					?>
					<div class="row subscription-hp">
						<div class="<?= $class; ?> margin-right5">
							<div class="section">
								<h3>Current Plan</h3>
								<h2 style="font-size: 20px;"><?php echo $user_plans[0]['up_planName']; ?></h2>
								<?php if($user_plans[0]['up_amount'] > 0){ ?>
								<p><i class="fa fa-gbp"></i><?php echo number_format($user_plans[0]['up_amount']); ?></p>
								<?php } else { ?>
								<p>Free trial</p>
								<?php } ?>
							</div>
						</div>  
						<div class="<?= $class; ?> margin-right5">
							<div class="section">
								<h3>Valid till</h3>
								<h2 style="padding: 0;font-size: 20px;">
								<?php 
								$yrdata= strtotime($user_plans[0]['up_enddate']);
								echo date('d',$yrdata); echo ' '.date('M', $yrdata); ?>, <?php echo date('Y',$yrdata); ?></h2>

								<?php /*if($user_plans[0]['auto_renewed'] == 1){ ?>
									<p>Auto Renewed at (<?= date('d-m-y',strtotime($user_plans[0]['up_startdate']))?>)</p>
								<?php }*/ ?>
							</div>
						</div>
						<div class="<?= $class; ?> margin-right5">
						
							<?php 
							$show_credit = '';
							if($user_plans[0]['bid_type']==1){ 
								$show_credit = $user_plans[0]['up_bid']-$user_plans[0]['up_used_bid'];
								if($show_credit <= 0){
									$show_credit = '0 : <a style="color:#FF7353;font-size: medium; font-weight: 600;" href="'.site_url('addon').'">Recharge</a>';
								}
							}else{ 
								$show_credit = "Unlimited Bids"; 
							} ?>
							
							<?php 
							$show_sms = ''; 
							$show_sms = $user_plans[0]['total_sms']-$user_plans[0]['used_sms_notification'];
							if($show_sms <= 0){
								$show_sms = '0 : <a style="color:#FF7353;font-size: medium; font-weight: 600;" href="'.site_url('addon').'">Recharge</a>';
							}
								?>
							
							<div class="section">
								<h3>Remaining Credits</h3>
								<h2 style="padding: 0;font-size: 20px;margin-top: 3px;">
									<?php echo $show_credit; ?>
									<br>
									
								</h2>   
								<br>
								<h3>Remaining SMS</h3>
								<h2 style="padding: 0;font-size: 20px;margin-top: 3px;">
									<?php echo $show_sms; ?>
									<br>
									
								</h2>                          
							</div>
						</div>
						<?php if($auto_update==1){ ?>
						<div class="<?= $class; ?> margin-right5">
							<div class="section">
								<div class="pos_bbplan1">
									<button type="button" class="btn btn-primary" style="background-color: #FF7353;color: #fff;" onclick="cancel_plan(<?php echo $user_plans[0]['up_id']; ?>)"><b>Deactivate Plan</b></button> 
								</div>
								
							</div>
						</div>
						<?php } ?>
					</div>

					<?php } ?>
					<div class="user-right-side list-tradesmen plan_body">
						<h1 style="margin-bottom: 20px;margin-top: -40px;">Membership Plans</h1> 
						<div class="container">
						
							<?php if($this->session->flashdata('error1')) { ?>
							<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
							<?php } ?>
							
							<?php echo $this->session->flashdata('success1'); ?>
							
							<div class="row fixed3">

							<?php 
								//echo '<pre>'; print_r($logged_user_profile);
							if($logged_user_profile['free_trial_taken']==0){
								$where1['is_free'] = 1;
							}
									
							$where1['status'] = 0;
							$where1['is_delete'] = 0;
									
							$get_all_packages=$this->common_model->newgetRows('tbl_package',$where1);
							$active_plan = '';
							if(count($get_all_packages) > 0) {  
							foreach ($get_all_packages as $p) {
								
							$today = date('Y-m-d');
							$where = "up_status = 1 and DATE(up_enddate) >= DATE('".$today."') and up_user = '".$logged_user_profile['id']."' and up_plan = '".$p['id']."'";
							$check = $this->common_model->get_single_data('user_plans',$where);
							
							if($active_plan==0 && $check){
								$active_plan = $p['id'];
							}
								?>

								<div class="col-sm-4 ">
									<div class="box_member plan_div <?= ($check)?'active':'';?>" id="plan_div<?= $p['id']; ?>">
										<div class="member_hh">
											<h5><?php echo $p['package_name']; ?></h5>
										</div>
										<div class="contt_tab">
											
											<h1>
											
												<?php
												$show_arr = explode(' ',$p['validation_type']);
												$show_day = end($show_arr);
												$show_num = $show_arr[0];
												
												$show_day = strtolower($show_day);
												
												if($show_num > 1){
													$show_day = $show_num.' '.$show_day;
												} else {
													if($show_day=='days'){
														$show_day = 'day';
													} else if($show_day=='months'){
														$show_day = 'month';
													} else if($show_day=='weeks'){
														$show_day = 'week';
													}
												}
												
												?>
												<i class="fa fa-gbp"></i> <?php echo $p['amount']; ?>/<?php echo $show_day;?>
												<?php
													if($logged_user_profile['free_trial_taken']==0){													
														$show_arr1 = explode(' ',$p['free_plan_exp']);
														$show_day1 = end($show_arr1);
														$show_num2 = $show_arr1[0];												
														$show_day1 = strtolower($show_day1);												
														if($show_num2 > 1){
															$show_day1 = $show_num2.' '.$show_day1;
														} else {
															if($show_day1=='days'){
																$show_day1 = $show_num2.' '.'day';
															} else if($show_day1=='months'){
																$show_day1 = $show_num2.' '.'month';
															} else if($show_day1=='weeks'){
																$show_day1 = 'week';
															}
														}
												?>
													<span class="price_cross123"><?php echo $show_day1; ?> Free Trial</span>
													<!--span class="price_cross"><i class="fa fa-gbp"></i> <?php //echo $p['amount']; ?></span-->
												<?php } ?>
											</h1>
											<ul class="ul_set">
												<li>
													<i class='fa fa-check-circle' style='color: #2875D7;'></i> <?php echo $p['description']; ?>
												</li>
												<li>
													<i class='fa fa-check-circle' style='color: #2875D7;'></i> 
													<?php 
													if($p['unlimited_limited']==0){ 
														echo explode(' ',$p['bids_per_month'])[0].' Credits'; 
													}else{ 
														echo "Unlimited".' Credits'; 
													} ?>  
												</li>
												<li>
													<?php if($p['email_notification']==1){ echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i>  Email Notification"; } ?>
												</li>
												<li>
													<?php if($p['sms_notification']==1){ echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> ".$p['total_notification']." SMS Notification"; } ?>
												</li>
												<li>
													<?php if($p['category_listing']==1){ echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Category Listing"; } ?>
												</li>
												<li>
													<?php if($p['directory_listing']==1){ echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Directory Listing"; } ?>
												</li>
												<li>
													<?php if($p['unlimited_trade_category']==1){ echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Unlimited trade category"; } ?>
												</li>
												<li>
													<?php if($p['reward']==1){ ?><i class='fa fa-check-circle' style='color: #2875D7;'></i> <i class="fa fa-gbp"></i><?php echo $p['reward_amount'].' GBP reward'; } ?>
												</li>
            
											</ul>
											<br>	
											<!-- Sctipt bay   -->
											<div class="text-center">											
												<?php if($setting['payment_method'] == 1){?>
													<button type="button" onclick="show_lates_stripe_popup(<?= $p['amount']; ?>,<?= $p['amount']; ?>,2,<?= $p['id']; ?>);" class="btn btn-warning">Upgrade</button>
												<?php }else{
													if($user_data['free_trial_taken']==1){ ?>
													<button type="button" onclick="show_lates_stripe_popup(<?= $p['amount']; ?>,<?= $p['amount']; ?>,2,<?= $p['id']; ?>);" class="btn btn-warning">Upgrade</button>
												<?php } else { ?>
													<button type="button" onclick="select_plan(<?= $p['id']; ?>);" class="btn btn-warning">Start Free Trial</button>
												<?php } }?>
											</div>
										</div>
									</div>
								</div>
								<?php } } else{ ?>
								<div class="alert alert-warning">Currently plans are not available</div>
								<?php } ?>
                <?php
                  if($logged_user_profile['free_trial_taken'] == 0 && $logged_user_profile['is_pay_as_you_go'] == 0){
                ?>
                    <div class="col-sm-4">
                      <div class="box_member plan_div" id="plan_div0">
                        <div class="member_hh">
                          <h5>Pay as you go</h5>
                        </div>
                        <div class="contt_tab">
                          <h1>
                            <i class="fa fa-gbp"></i>0/month
                          </h1>
                          <ul class="ul_set">
                            <li>
                              <i class='fa fa-check-circle' style='color: #2875D7;'></i>  No monthly payment
                            </li>
                            <li>
                              <i class='fa fa-check-circle' style='color: #2875D7;'></i>  Category listing
                            </li>
                            <li>
                              <i class='fa fa-check-circle' style='color: #2875D7;'></i>  Directory listing
                            </li>
                            <li>
                              <i class='fa fa-check-circle' style='color: #2875D7;'></i>  Email notification
                            </li>
                          </ul>
                          <br>
                          <div class="text-center">
                            <a href="<?php echo site_url().'home/select_pay_as_you_go';?>" onclick="return confirm('Are you sure you want to choose Pay as you go?');" class="btn btn-warning">Pay as you go</a>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                ?>
								
							</div>
							<br>
							<!--div class="text-right">
								<?php if($user_data['free_trial_taken']==1){ ?>
									<button type="button" class="btn btn-warning btn-lg signup_btn" onclick="show_card_div();">Upgrade</button>
								<?php } else { ?>
									<button type="button" class="btn btn-warning btn-lg signup_btn" onclick="show_card_div2();">Start Free Trial</button>
								<?php } ?>
							</div-->
							<p class="membership-plan-description">All of our subscriptions comes with a monthly allowance  job credits which you can be used to to provide quotes, discuss project requirements, reply to messages. If you wish to save up to 50% on credits, we recommend subscribing to our monthly plans.</p>
						</div>
					</div>
					
					<br>
					<div class="row card_body" id="card_body" style="display:none;">
						<div class="col-md-12 col-sm-12"> 
							<div class="dashboard-white"> 
								<div class="row dashboard-profile dhash-news">
									<div class="col-md-12">
										<form method="post" id="paymentFrm">
											<input type="hidden" name="plan_id" id="plan_id" value="<?= $active_plan; ?>">
											<div class="row">
												
												<div class="col-sm-12">
													<div class="payment-status"></div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Name on Card </label>
														<input type="text" name="name" id="name" placeholder="Enter name" required="" value="<?= ($billing_details) ? $billing_details['name'] : '';?>" class="form-control" autofocus="">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>16 Digit Card Number </label>
														<input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" value="<?=($billing_details) ? $billing_details['card_number'] : '';?>" class="form-control" autocomplete="off" required="">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label>EXPIRY DATE</label>
														<div class="row">
															<div class="col-sm-3">
																	<input type="text" class="form-control" name="card_exp_month" id="card_exp_month" value="<?=($billing_details) ? $billing_details['card_exp_month'] : '';?>" placeholder="MM" required="">
															</div>
															<div class="col-sm-4">
																	<input type="text" class="form-control" name="card_exp_year" id="card_exp_year" value="<?=($billing_details) ? $billing_details['card_exp_year'] : '';?>" placeholder="YYYY" required="">
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>CVC - Last 3 Digits on back of card </label>
														<input type="text" class="form-control" name="card_cvc" id="card_cvc" placeholder="CVC" value="<?=($billing_details) ? $billing_details['card_cvc'] : '';?>" autocomplete="off" required="">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label>Billing Postcode </label>
														<input type="text" class="form-control" name="postcode" class="form-control" value="<?=($billing_details) ? $billing_details['postcode'] : '';?>" placeholder="" required />
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Address </label>
														<input type="text" class="form-control" name="address" class="form-control" value="<?=($billing_details) ? $billing_details['address'] : '';?>" placeholder=""  required />
													</div>
												</div>
											</div>
											<div class="start-btn maggg1">
												<button type="submit" id="payBtn" class="btn btn-warning btn-lg signup_btn"><?=($billing_details) ? 'Save & Upgrade' : 'Add Card';?></button> 
												
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
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
function cancel_plan(id) {
	Swal.fire({
		title: 'Confirm Cancellation of Plan',
		text: "Are you sure you want to cancel the plan renewal?.",
		type: 'warning',
		showCancelButton: true,
		showCloseButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'OK'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type:'POST',
				url:site_url+'Subcription_plan/cancel_plan/'+id,
				dataType: 'JSON',
				success:function(resp){
					if(resp.status==1) {
						Swal.fire(
							'Deactivated!',
							'Subscription Plan has been deactivated successfully.',
							'success'
						)
						setTimeout(function(){
							location.reload();
						},2000);
					} else {
						location.reload();
					}

								
				} 
			});

		}
	}) 

}

</script>
<?php include ("include/footer.php") ?>
    