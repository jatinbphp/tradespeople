<?php 
include_once('include/header.php');
?>
<style>
	.settings-frm{
		margin-top: 15px;
	}
	.edit-user-section{
		border: none;
		padding: 0;
	}
	hr{
	border-top: 1px solid #000;
	}
	.edit-user-section input{
		font-weight: 900;	 
	}
</style> 
<?php
foreach($settings as $setting){
	if($setting->type == 'marketers'){
		$min_cashout_marketer =  $setting->min_amount_cashout;
		$min_quotes_received_homeowner_m =  $setting->min_quotes_received_homeowner;
		$min_quotes_approved_tradsman_m =  $setting->min_quotes_approved_tradsman;
		$comission_ref_homeowner_m =  $setting->comission_ref_homeowner;
		$comission_ref_tradsman_m =  $setting->comission_ref_tradsman;
		$payment_method =  $setting->payment_method;
		$participating_bid =  $setting->participating_bid;
		$banner =  $setting->banner;
		$referral_links_homeowner =  $setting->referral_links_homeowner;
		$referral_links_tradsman =  $setting->referral_links_tradsman;
		$marketer_ref_links_hm = explode(",",$referral_links_homeowner);
		$marketer_ref_links_tm = explode(",",$referral_links_tradsman);
	}
	
}
?>
<div class="content-wrapper" style="min-height: 933px;">
	<section class="content-header">
		<h1>Affiliate setting</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> 
			<li class="active">Marketers Sharable </li>
		</ol>
  </section>
	<div class="container" style="width:100%">
		<div class="user-setting col-xs-12">
			<div class="row">
				<?php
				$message = '';
				if (isset($this->session->message)) {
					$message = $this->session->message;
					if ($message == 'Affiliate setting Updated Successfully') { ?>
						<div class="col-lg-12 alert alert-success mt-3 close_message" style="margin-bottom: 0px;margin-top: 10px;">
							<button class="close" data-dismiss="alert">×</button>
							<?php echo htmlspecialchars($message); ?>
						</div>
				 <?php } ?>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-sm-9 box settings-frm" style="padding-left:1px;">
					<div class="user-right-side" style="margin-top:30px;">
						<form action="<?= site_url().'Admin/Admin/update_settings'; ?>" id="update_profile" method="post" enctype="multipart/form-data">  <input type="hidden" name="shareable" value="marketers-setting">
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-5">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-7 control-label" for="">Payment Method</label>  
											<div class="col-md-5">
												<select class="form-control" name="payment_method">
													<option value="bank_transfer"<?php echo $payment_method == 'bank_transfer' ?'selected' : ''?>>Bank transfer</option>
													<option value="paypal" <?php echo $payment_method == 'paypal' ?'selected' : ''?>>Paypal</option>
													<option value="both" <?php echo $payment_method == 'both' ?'selected' : ''?>>Both</option>
												</select>
                      						</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-6 control-label" for="">Minimum Cashout Amount</label>  
											<div class="col-md-4">
												<div class="input-group">
													<span class="input-group-addon">£</span>
													<input name="min_amount_cashout_m" placeholder="" class="form-control input-md" type="number" step="0.01" min="0" value="<?php echo $min_cashout_marketer;?>" required="">
												</div>
                      						</div>
										</div>
									</div>
									
									
								</div>
								<div class="col-sm-12" style="height:31px;margin-bottom: 10px;">
									<!-- <h2>Marketer</h2> -->
								</div>
								
								<div class="col-sm-5" style="padding-left:2px;">
									<div class="row">
										<p style="margin-top:0px;margin-bottom:15px;margin-left: 29px;font-size: 14px;font-weight: 600;">Homeowner : </p>				
									</div>
									<div class="row">
										<div class="col-sm-12">
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-7 control-label" for="">
													<?php 
														if($paymentSettings[0]['payment_method'] == 0){
															echo 'Minimum Milestone Release';
														}else{
															echo 'No. of quotes a job must receives to earn';
														}
													?>
												</label>  
												<div class="col-md-5">
													<input  name="min_quotes_received_m" placeholder="" class="form-control input-md" type="number" step="1" min="0" value="<?php echo $min_quotes_received_homeowner_m;?>" required >
                                        
												</div>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-sm-12">
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-7 control-label" for="">
													<?php 
														if($paymentSettings[0]['payment_method'] == 0){
															echo 'Amount to earn after milestore release';
														}else{
															echo 'Amount to earn after job post receive quotes';
														}
													?>
												</label>
												<div class="col-md-5">
													<div class="input-group">
														<span class="input-group-addon">£</span>
														<input  name="comission_ref_hm" placeholder="" class="form-control input-md"  type="number" step="0.01" min="0" value="<?php echo $comission_ref_homeowner_m;?>" required >
                                        
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-sm-5">
									<div class="row">
										<p style="margin-top:0px;margin-bottom:15px;margin-left: 29px;font-size:14px;font-weight: 600;">Tradsman :</p>				
									</div>
									<div class="row">
										<div class="col-sm-12">
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-7 control-label" for="">
													<?php 
														if($paymentSettings[0]['payment_method'] == 0){
															echo 'Minimum Milestone Release';
														}else{
															echo 'No. of quotes a trade must provide to earn';
														}
													?>
												</label>
												<div class="col-md-5">
													<input  name="min_quotes_approved_m" placeholder="" class="form-control input-md" type="number" step="1" min="0" value="<?php echo $min_quotes_approved_tradsman_m;?>" required >
                                        
												</div>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-sm-12">
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-7 control-label" for="">
													<?php 
														if($paymentSettings[0]['payment_method'] == 0){
															echo 'Amount to earn after milestone release';
														}else{
															echo 'Amount to receive after a trade provide quotes';
														}
													?>
												</label>
												<div class="col-md-5">
													<div class="input-group">
														<span class="input-group-addon">£</span>
														<input  name="comission_ref_tm" placeholder="" class="form-control input-md"  type="number" step="0.01" min="0" value="<?php echo $comission_ref_tradsman_m;?>" required >
                                        
													</div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>  
							<!-- <div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-md-3 control-label" for="">Banner</label>  
										<div class="col-md-2">
											<select class="form-control" name="banner">
												<option value="disable" <?php echo $banner == 'disable' ?'selected' : ''?>>Disable</option>
												<option value="enable" <?php echo $banner == 'enable' ?'selected' : ''?>>Enable </option>
											</select>
	              						</div>
									</div>
								</div>
							</div> -->
							
							
							<div class="edit-user-section gray-bg">
								<div class="row nomargin" style="background: #fff; padding: 10px 0;">
									<div class="col-sm-12">
										<button class="btn btn-primary" style="width: 10%;">SAVE</button>
                           
									</div>                                 
								</div>
							</div>                        
							<!-- Edit-section-->  
                        
						</form>
                        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once('include/footer.php'); ?>
<script>
	jQuery(document).ready(function(){
		jQuery(document).on('click','.add_inputs',function(){
			var value=jQuery(this).attr('attr-type');
			if(value == 'marketer_homeowner'){
				var name="marketer_homeowner[]";
			}if(value == 'marketer_tradsman'){
				var name="marketer_tradsman[]";
			}if(value == 'homeowner_homeowner'){
				var name="homeowner_homeowner[]";
			}if(value == 'homeowner_tradsman'){
				var name="homeowner_tradsman[]";
			}if(value == 'tradsman_homeowner'){
				var name="tradsman_homeowner[]";
			}if(value == 'tradsman_tradsman'){
				var name="tradsman_tradsman[]";
			}
			var parentclass=jQuery(this).parent().parent();
			var parent=jQuery(this).parent().parent().parent();
			jQuery(parentclass).find(".plus_div").html('<i class="fa fa-trash" style="margin-top: 16px;font-size: 19px;"></i>');
			jQuery(parentclass).removeClass(".plus_div");
			var html='<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input  name="'+name+'" placeholder="" class="form-control input-md" type="url" value="" required></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" class="badge add_inputs" attr-type="'+value+'">+</span></div></div>';
			jQuery(parent).append(html);
		});
		jQuery(document).on('click','.fa-trash',function(){
			if(confirm('Please Confirm The Deletion') == true){
				var parentclass=jQuery(this).parent().parent();
				jQuery(parentclass).remove();
			}
			
		});
	});
</script>