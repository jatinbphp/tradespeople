<?php 
include 'include/header.php';

?>

<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
       
				<div class="col-sm-9">
					<div class="mjq-sh">
						<h2><strong>Your Membership Plan</strong> </h2>

					</div>
					<?php 
					if($user_plans){ 
					
						$get_all_packages=$this->common_model->get_single_data('tbl_package',array('id'=>$user_plans[0]['up_plan']));
						
						$auto_update = $user_plans[0]['auto_update'];
						
						//$class = ($auto_update==1)?'col-md-3':'col-md-4';
						
					?>
					<div class="row subscription-hp">
						<div class="col-md-3 margin-right5">
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
						<div class="col-md-3 margin-right5">
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
						<div class="col-md-3 margin-right5">
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
						<div class="col-md-3 margin-right5">
							<div class="section">
								<div class="pos_bbplan1">
									<?php if($auto_update==1){ ?>
								<button type="button" class="btn btn-primary" style="background-color: #FF7353;color: #fff;margin-bottom: 7px;" onclick="cancel_plan(<?php echo $user_plans[0]['up_id']; ?>)"><b>Deactivate Plan</b></button> 
								<?php } ?>
								
								<a href="<?= site_url().'membership-plans'; ?>" class="btn btn-primary" style="background-color: #FF7353;color: #fff;"><b>Change Plan</b></a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12"> 
							<div class="dashboard-white"> 
								<div class="row dashboard-profile dhash-news">
									<div class="col-md-12">

										<?php echo $this->session->flashdata('success1123'); ?>
										
										<p>Your current plan will auto renew upon expiring date if not cancelled. You can change your plan at any time, note when you change your plan the new plan charges apply immediately and you will lose the benefit of the old plan.</p>
										<?php if($auto_update==1){ ?>
										<p>Click deactivate to cancel the plan renewal.</p>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php }else{ ?>
					
					<?php if($this->session->flashdata('error2')) { ?>
					
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error2'); ?></p>
					
					<?php } if($this->session->flashdata('success2')) { ?>
					
					<p class="alert alert-success"><?php echo $this->session->flashdata('success2'); ?></p>
					
					<?php } ?>
					
					<div class="verify-page">

						<div style="background-color:#fff;padding: 10px;">
							<p>You do not have any active membership plan. Please <a href="<?php echo base_url('membership-plans'); ?>">click here</a> to subscribe.</p>
						</div>
					</div>
					
					<?php } ?>

				</div>

			</div>


                                       
		</div>
	</div>
</div>

<?php include ("include/footer.php") ?>
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
    