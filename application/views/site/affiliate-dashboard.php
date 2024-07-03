<?php include 'include/header.php'; 
	//$referral_links_homeowner =  $settings->referral_links_homeowner;
	//$referral_links_tradsman =  $settings->referral_links_tradsman;

?>

<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>



<style type="text/css">
.tradsman-banner .card{
background:#fff;
border-radius:5px;
padding:20px 10px 10px 30px;
margin-bottom: 10px;
}
.tradsman-banner .card p{
font-size:18px;
font-weight:500;
}
#vote_buttons :hover {
	cursor:pointer;  
} 

.emailmsg{
    text-align: center;
    background: green;
    color: white;
    padding: 10px;
    font-size: 15px;
		display: none;
}
</style>
	<style>
	.referal-copy{
padding-top:5px;
}
	.reffer-share{
/*padding-top:18px;*/
}
hr{
margin:10px 0px;
}
	.row{
		margin-top: 15px;
	}
	.reffer-share img{
		padding: 0 8px;
	}
	.well {
    background: rgba(61,120,203,1) url(../img/wallet.png);
    border: 1px solid #3d78cb;
    color: #fff;
    padding: 22px 15px;
    min-height: 110px !important;
    background-repeat: no-repeat;
    background-size: 25%;
    background-position: center;
}
	.earn-bnts{
padding-top:25px;
}
	.earn-bnts .btn-warning{
background: #3d78cb;
    border-color: #3d78cb;
margin:0px 10px
}
	/* The Modal (background) */

	  /*.cashout-popup{
		  margin: 25px;
		  text-align: center;
	  }
	  .cashout-popup button{
		width: 80%;
		margin: 20px 0;
		padding: 20px;
	  }
	  .cashout-popup input{
		  padding: 28px;
		  font-size: 23px;
		  margin: auto;
		  width: 80%;
	  }*/
	  .social_icons_styles{
	  	padding-left: 0px !important;
    	padding-right: 0px !important;
    	width: 10%;
	  }

	.w-100 {
		width: 100% !important;
	}

	.m-0 {
		margin: 0 !important;
	}

	.p-0 {
		padding: 0 !important;
	}

	button.btn.copied_url {
		position: absolute;
		right: 5px;
		top: 50%;
		background: transparent;
		color: #404040;
		transform: translateY(-50%);

	}
</style>
<?php $unique_id = $this->session->unique_id; ?>
	<div class="acount-page membership-page affiliate-page">
		<div class="container">
			<!-- <div id="sidebar-button"><span><i class="fa fa-bars" aria-hidden="true"></i></span></div> -->
			<div class="man_nan">
						<button type="button" class="navbar-toggle" id="man_bbbon">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
				    </div>
			<div class="user-setting">   
				<div class="row">
					<div class="col-sm-3">
						<div class="sidebarnav" id="sidd_cll">
							<div class="user-page-menu">
								<p class="marketers_menu referral-links-menu" attr-value="referral_links" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-info-circle" aria-hidden="true"></i></span>Shareable Links</a>
								</p>
								<p class="marketers_menu referral-table-menu" attr-value="referral_table" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-list" aria-hidden="true"></i></span>Report</a>
								</p>
								<p class="marketers_menu my-details-menu marketer_profile_edit" attr-value="my_details" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-pencil" aria-hidden="true"></i></span>My Details</a>
								</p>
								<p class="marketers_menu balance-cashout-menu" attr-value="balance_cashout" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-cc-visa" aria-hidden="true"></i></span>Cashout</a>
								</p>
								<p class="marketers_menu payment-settings-menu account_settings_edit" attr-value="payment_settings" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-credit-card" aria-hidden="true"></i></span>Payment Setting</a>
								</p>
								<p class="marketers_menu view-payout-request-menu view_payout_request_edit" attr-value="view_payout_request_settings" style="cursor:pointer">
									<a>
					        	<span><i class="fa fa-credit-card" aria-hidden="true"></i></span>Payment History</a>
								</p>
								<p class="marketers_menu password-change-menu" attr-value="password_change" style="cursor:pointer">
									<a>
					        		<span><i class="fa fa-lock" aria-hidden="true"></i></span>Password</a>
								</p>
								<!-- <p class="marketers_menu contact-us-menu" attr-value="contact_us" style="cursor:pointer">
									<a><span><i class="fa fa-home" aria-hidden="true"></i></span>Contact Us</a>
								</p> -->

								<p class="marketers_menu" attr-value="support_center" style="cursor:pointer">
									<a href="<?= base_url('Support/tickets') ?>"><i class="fa fa-envelope" aria-hidden="true"></i>
										 <span>Support center</span> <span style="background:red;color:#fff; width: 30px" class="badge" id="support_msg_unread"></span></a>
								</p>
							</div>
						</div>	 
					</div>
					<!-- referral links........... -->
					<div class="col-sm-9 custom_cla referral_links">
						 <?php 
 // if($this->session->userdata('type')==1){
$settingss = $this->db->where('id', 1)->get('admin_settings')->row();
//print_r($settings);
 if($settingss->banner == 'enable'){
	 ?>
<!-- <section class="row tradsman-banner">
    <div class="card">
        
        <p><img src="<?php echo base_url('asset/admin/img/Gas.png')?>" alt=""><span class="trads-offer">Did you know ?</span>   Refer another trade and earn free leads once they purchase their first job</p>
    </div>
</section> -->
 <?php
} 
// } 
?>

						<div class="row " style="background-color:#fff; padding: 5px;width: 100%; margin: 4px 0px;">
						<h3 class="block-header" style="margin: 10px;">Shareable links</h3>
						<?= $this->session->flashdata('success');?>
		    		</div>
				   	<div class="row" style="background-color: white;padding: 25px;margin:4px 0px;">
					
				   		<?php	  
				   		if(isset($settings)){
				   				?>
				   		 <label style="font-size: 17px;">Homeowner</label>
				   				<?php
				   				$parts = array();
				   				$parts = explode(",", $settings["referral_links_homeowner"]);
				   				foreach ($parts as $key212 => $value212) { 
				   			 ?>
				   		 		<div class="row m-0 w-100" style="padding-bottom: 15px;">
										<div class="col-lg-7 p-0">
										   <label style="position: absolute;right: 6px;top: -22px; font-size: 14px;font-weight: bold;">Copy</label>
											<span type="text" placeholder="" value="" name="" class="form-control input-md" style="font-size:11px;height:100%;">
												<?= $value212; ?>/?referral=<?= $unique_id; ?></span> 
											<input type="hidden" id="shared_url_hm_<?= 'h'.$key212 ?>" value="<?= $value212; ?>/?referral=<?= $unique_id; ?>">
											<button style="padding:0px 4px" class="btn copied_url" attr-id="shared_url_hm_<?= 'h'.$key212; ?>"   data-toggle="popover" data-content="Copied!" data-placement="top" data-trigger="focus"><i class="fa fa-clipboard" aria-hidden="true"></i></button> 
										</div>
										<div class="col-lg-5 reffer-share">
										<span><strong>Share on</strong></span>
							            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?= $value212; ?>?referral=<?= $unique_id; ?>" data-a2a-title=" -">
							                <a class="a2a_button_facebook"></a>
							                <a class="a2a_button_twitter"></a>
							                <a class="a2a_button_email"></a>
							                <a class="a2a_button_whatsapp"></a>
							            </div>
										<!-- <a href="https://www.facebook.com/sharer.php?u=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
											<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/facebook.png" alt="">
										</a>
							 			<a href="https://twitter.com/share?url=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
							 				<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/twitter.png" alt="">
							 			</a> 
							            <a href="https://www.instagram.com/url=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
							            <img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/insta.png" alt=""></a>
							            <a href="https://api.whatsapp.com/send?text=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
							            	<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/whatsapp.png" alt="">
							            </a>
							            <a href="mailto:?body=<?= $value212; ?>?referral=<?= $user_id; ?>">
							            <img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/mail.png" alt=""></a> -->
							            <!-- <a href="https://www.blogger.com/blog-this.g?u=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
							            <img  class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/Blogger.png" alt=""></a> -->
												</div>
					    			</div>	
				   		<?php } 
				   		} ?>
							</div>
				   					
				   		<div class="row" style="background-color: white;padding: 25px;;width: 100%; margin: 4px 0px;">
				   			 	<?php	  
				   		if(isset($settings)){
				   				?>
						
						<label style="font-size: 17px;">Tradesman</label>
				   				<?php
				   				$parts = array();
				   				$parts = explode(",", $settings["referral_links_tradsman"]);
				   				foreach ($parts as $key212 => $value212) { 
				   			 ?>
				   		 		<div class="row m-0 w-100" style="padding-bottom: 15px;">
										<div class="col-lg-7 p-0">	
										<label style="position: absolute;right: 6px;top: -22px; font-size: 14px;font-weight: bold;">Copy</label>
											<span type="text" placeholder="" value="" name="" class="form-control input-md" style="font-size:11px;height:100%;">
												<?= $value212; ?>/?referral=<?= $unique_id; ?></span> 
											<input type="hidden" id="shared_url_hm_<?= 't'.$key212 ?>" value="<?= $value212; ?>/?referral=<?= $unique_id; ?>"> 
											<button style="padding:0px 4px" class="btn copied_url" attr-id="shared_url_hm_<?= 't'.$key212; ?>"    data-toggle="popover" data-content="Copied!" data-placement="top" data-trigger="focus"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
										</div>
										<div class="col-lg-5 reffer-share">
											<span><strong>Share on</strong></span>
								            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?= $value212; ?>?referral=<?= $unique_id; ?>" data-a2a-title=" -">
								                <a class="a2a_button_facebook"></a>
								                <a class="a2a_button_twitter"></a>
								                <a class="a2a_button_email"></a>
								                <a class="a2a_button_whatsapp"></a>
								            </div>
											<!-- <a href="https://www.facebook.com/sharer.php?u=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
												<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/facebook.png" alt="">
											</a>
								 			<a href="https://twitter.com/share?url=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
								 				<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/twitter.png" alt="">
								 			</a> 
								            <a href="https://www.instagram.com/url=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
								            <img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/insta.png" alt=""></a>
								            <a href="https://api.whatsapp.com/send?text=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
								            	<img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/whatsapp.png" alt="">
								            </a>
								            <a href="mailto:?body=<?= $value212; ?>?referral=<?= $user_id; ?>">
								            <img class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/mail.png" alt=""></a> -->
								            <!-- <a href="https://www.blogger.com/blog-this.g?u=<?= $value212; ?>?referral=<?= $user_id; ?>" target="_blank">
								            <img  class="social_icons_styles" src="<?= base_url(); ?>asset/admin/img/Blogger.png" alt=""></a> -->
										</div>
					    			</div>	
				   		<?php } 
				   		} ?>
				   		</div>
						</div>
						<!-- referrals..... -->
						<div class="col-sm-9 custom_cla referral_table" style="display:none;background-color: white;">
							<div class="table-responsive">
							<table id="boottable1" class="table table-bordered table-striped">
								<thead>
									<tr>
										
										<th>Customer Name</th> 
										<th>Customer Type</th>
										<th>Signup Date</th>										
										<th>
											<?php 
					                            if($paymentSettings[0]['payment_method'] == 1){
					                                echo 'Provided/Received Quotes';
					                            }else{
					                                echo 'Milestone Released(£)';
					                            }
					                        ?>											
										</th>
										<!-- <th>Job Posted</th> -->
										<th>Earnings</th>
										<!-- <th>Referred Link</th> -->
									</tr>
								</thead>
								<tbody> 
								<?php
									if(!empty($marketers_referrals_list)){
										foreach($marketers_referrals_list as $marketers_referrals){
											//print_r($marketers_referrals);
											if($marketers_referrals['earn_amount'] == ''){
												$marketers_referrals['earn_amount'] = 0;
											}
											 	$signed=$marketers_referrals['signed_up'];
											 	$final_signed = date_create($signed);
            						$signed_on = date_format($final_signed,"d/m/Y");
										?>
									<tr>
										<td><?php echo $marketers_referrals['f_name'].' '.$marketers_referrals['l_name']; ?></td>
										<td><?php echo $marketers_referrals['type']?></td>
										<td><?php echo $signed_on; ?></td>
										<td><?php echo $marketers_referrals['quotes']?></td>
										<!-- <td><?php echo $marketers_referrals['jobs']?></td> -->
										<td><?php echo $marketers_referrals['earn_amount']?></td>
										<!-- <td><?php echo ($marketers_referrals['referred_link']) ? $marketers_referrals['referred_link'].'?referral='.$user_id : ''; ?></td> -->
									</tr> 
								<?php		
									}
									}
								?> 
								</tbody>
							</table>
							</div>
						</div>
						<!--Account Details........ -->
						<div class="col-sm-9 custom_cla my_details" style="display:none;">
							<div class="user-right-side">
							<h1>Account Details</h1> <hr>
							<form  method="post" enctype="multipart/form-data" class="update_marketers_details">  
							<div class="edit-user-section">
								<div class="msg"></div>
								<div class="col-sm-12">
									<h2>Name</h2>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">First Name*</label>  
											<div class="col-md-12">
												<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md f_name" <?php echo ($user_profile['type']==3) ? 'readonly' : ''; ?> type="text" value="<?php echo $user_profile['f_name']; ?>">
                                        
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Last Name*</label>  
											<div class="col-md-12">
												<input id="l_name" <?php echo ($user_profile['type']==3) ? 'readonly' : ''; ?> name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $user_profile['l_name']; ?>">
                                        
											</div>
										</div>
									</div>
								</div>
							</div>                        
							<!-- Edit-section-->
                        
                        
							<!-- Edit-section-->
							<div class="edit-user-section">
								<div class="col-sm-12">
									<h2>Address</h2>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="row">
											<div class="col-sm-12">     
												<div class="form-group">
												
													<div class="col-md-12">
														<input type="text" name="e_address" id="e_address" class="form-control" value="<?php echo $user_profile['e_address']; ?>" placeholder="Enter a address" autocomplete="off">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Country* </label>  
													<div class="col-md-12">
														<select class="form-control input-lg"  name="country" id="countryus1">
															<option value=""></option>
															<?php
															foreach($county as $key => $val){
																$value_country = strtolower($val->name);
																$country_name = ucfirst($value_country);
																$selected = ($user_profile['county'] == $val->name) ? 'selected' : '';
																echo '<option '.$selected.' value="'.$val->name.'">'.$country_name.'</option>';
															}
															?>
														</select>
													</div>
												</div>
											</div>                                         
                                                                              
											<!-- Text input-->
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Town/City* </label>  
													<div class="col-md-12">
														<input type="text" placeholder="Town/City" name="locality" id="e_city" value="<?php echo $user_profile['city']; ?>" class="form-control">
												
													</div>
												</div>
											</div> 
										</div>
                                    
										<div class="row">
                        
											<div class="col-sm-6">                                                    
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">PostCode</label>  
														<div class="col-md-12">
														<input type="text" placeholder="PostCode" value="<?php echo $user_profile['postal_code']; ?>" name="postal_code" class="form-control input-md">
														
													</div>
												</div>
                                       
											</div>
											<div class="col-sm-6">     
											<?php
												if($user_profile['profile'] == ''){
													$value=0;
												}else{
													$value=1;
												}
											?>                                         
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Profile Picture*</label>  
													<div class="col-md-12">
														<input type="file" name="profile" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();" value="<?= $user_profile['profile']; ?>" >
														<input type="hidden" name="u_profile_old" value="<?= $user_profile['profile']; ?>" >  
														<div id="imgpreview">
															<?php if($user_profile['profile']){ ?>
															<img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='100px' height='100px'>
															<?php } ?>
														</div>
                                    
													</div>
												</div>
                                       
											</div>
										</div>  
										<div class="row">
											<div class="col-sm-6">                             
													<!-- Text input-->
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Email*</label>  
															<div class="col-md-12">
															<input type="text" value="<?php echo $user_profile['email']; ?>" id="email" name="email" class="form-control input-md" readonly>
															
														</div>
													</div>        
											</div>
											<!-- <div class="col-sm-6">                             
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Number*</label>  
															<div class="col-md-12">
															<input type="text"  value="<?php echo $user_profile['phone_no']; ?>" id="phone_no" name="phone_no" class="form-control input-md">
															
														</div>
													</div>        
											</div> -->
											<div class="col-sm-6">                             
													<!-- Text input-->
													<div class="form-group">
														<label class="col-md-12 control-label" for="">Traffic source</label>  
															<div class="col-md-12">
															<input type="url"  value="<?php echo $user_profile['u_website']; ?>" name="u_website" class="form-control input-md" placeholder="Enter your traffic source">
															
														</div>
													</div>        
											</div>
										</div>
										</div>
										</div>
										</div> 
										<div class="edit-user-section">
											<div class="row nomargin" style="background: #fff; padding: 10px 0;">
												<div class="col-sm-12">
													<button type="submit" class="btn btn-primary" style="width: 10%;">SAVE</button>
												</div>                                 
											</div>
										</div> 
									</form>
									</div>
								</div>
							<!-- Cashout............. -->
							<?php
							  if(isset($balance_amount)){
							  	// $credit_amounts = $balance_amount[0]->balance;
							  	$credit_amounts = $balance_amount->referral_earning;
							  }if(empty($balance_amount)){
							  	$credit_amounts = '0';
							  }
							?>
							<div class="col-sm-9 custom_cla balance_cashout" style="display:none;background-color: white;">
						        <!-- <div class="text-center" style="border:2px solid #3D78CB; margin: 0; padding: 0;"><h3 class="card-header">Payment History</h3></div> -->
								
								<section class="referar-earnings">
								   
								<div class="row" style="padding:25px">
								<div class="col-lg-4 ">
								<div class="referar-earnings-wallet">
								<div class="Wallet_1 well wel-main">
								<h3 class="text text-center"> <i class="fa fa-money"></i> Balance <span><i class="fa fa-gbp"></i><?php echo $credit_amounts; ?></span> </h3>
								</div>
								</div>
								</div>
								<div class="col-lg-8  earn-bnts">
								<p><button id="myBtn" class="btn btn-warning btn-lg">Cash out</button></p>
								<!-- <p>if want to cash out, it must reach £<?php echo $min_cashout?> <a class="view_payout_request" style="cursor:pointer;margin-top: 10px;text-align: left;">View payment</a> </p> -->
								</div>
								</div>
								</section> 
							</div>
							<!-- payment setting................ -->
							<div class="col-sm-9 custom_cla payment_settings" style="display:none">
								<div class="user-right-side">
									<h1 style="padding-left: 41px;">Payment Details</h1><hr>
									<form  method="post" enctype="multipart/form-data" class="update_marketers_account_details">  
										<div class="edit-user-section" style="border-bottom: 0px solid #e1e1e1;padding: 30px 43px;">
											<div class="row">
												<div class="col-lg-4">
													<p>Account holder's Name</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="account_holder_name" name="account_holder_name" class="form-control" value="<?php echo $marketers_account_info->wd_account_holder; ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Account holder address</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="account_holder_address" name="account_holder_address" class="form-control" value="<?php echo $marketers_account_info->account_holder_address; ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Bank account number</p>
												</div>
												<div class="col-lg-5">
													<input type="number" id="account_number" name="account_number" class="form-control" value="<?php echo $marketers_account_info->wd_account; ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Sort code</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="sort_code" name="sort_code" class="form-control" value="<?php echo $marketers_account_info->wd_ifsc_code; ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Bank name</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="bank_name" name="bank_name" class="form-control" value="<?php echo $marketers_account_info->wd_bank; ?>">
												</div>
											</div>
											<?php if($settingss->payment_method=='both'){ ?>
											<div class="row">
												<div class="col-lg-4">
													<p>Paypal email address</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="paypal_email_address" name="paypal_email_address" class="form-control" value="<?php echo $marketers_account_info->paypal_email_address?>">
												</div>
											</div>
										<?php }  ?>
											<div class="row">
												<p style="padding-left: 16px;">
													Note : Any transaction fees charged by your bank or Paypal will be deducted from the total transfer amount.Funds will be credited to your balance on the next business day after the funds are received by bank.If you have any questions please contact us.
												</p>
											</div>
											<div class="">
											<div class="row nomargin" style="background: #fff; padding: 10px 0;">
												<div class="col-sm-12" style="padding-left: 0px;">
													<button type="submit" class="btn btn-primary" style="width: 10%;">SAVE</button>
												</div>                                 
											</div>
										</div>
										</div>
									</form>
								</div>
							</div>

							<!-- payment setting................ -->
							<div class="col-sm-9 custom_cla view_payout_request_settings" style="display:none">
								<div class="user-right-side">
									<div class="card">
										<h1 style="padding-left: 41px;">Payment History</h1>
						    		</div>
						     <section class="tradsman" style="margin:0px 20px 20px 20px"> 
        <div class="box">
            <div class="box-body">
                <div class="table-responsive" id="pending_table">
                 
                    <div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="boottable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
                                    <thead>
                                        <tr>
                                            <!-- <th>Id</th>  -->
                                            <th style="padding-right: 0px">Transaction ID</th> 
                                            <!-- <th>Name</th> -->
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php if(isset($payout_requests) && !empty($payout_requests)){ $sn= 1;  foreach ($payout_requests as $key => $payout) { $user= $this->db->select('f_name, l_name')->where('id', $payout['user_id'])->get('users')->row();
                                         ?>  
                                            <tr>
                                                <td style="width: 15%"><?= $payout['trans_id']; ?></td>
                                                <!-- <td><?php if(!empty($user)){ echo $user->f_name.' '.$user->l_name; } ?></td> -->
                                                <td style="width: 20%"><?php echo date('d-m-Y h:i a', strtotime($payout['created_at'])); ?></td>
                                                <td>£<?= $payout['request_amount']; ?></td>
                                                <td><?= (!empty($payout['payment_method']))? $payout['payment_method']:"Wallet request"; ?></td>
                                                <td>
                                                	<?php if($payout['status']==1){ ?>
                                                   		<span class="label label-success">Paid</span>
                                                	<?php }elseif($payout['status']==2){ ?>
                                                   		<span class="label label-danger">Rejected</span>
                                                   		<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_reasion<?=$payout['id']; ?>" class="btn btn-primary  btn-xs">View Reason</a>
                                                   	<?php }else{ ?>
                                                   		<span class="label label-warning">Pending</span>
                                                   <?php } ?>
                                                </td>
                                               
                                            </tr> 
                                    	<?php } } ?>
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </section>




								
								</div>
							</div>


<?php if(isset($payout_requests) && !empty($payout_requests)){ $sn= 1;  foreach ($payout_requests as $key => $payout) { ?>
		<!-- View Reasion -->
		<div class="modal fade popup" id="view_reasion<?=$payout['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Reason </h4>
		      </div>
		    
		        <div class="modal-body">
		            <p><?= $payout['reason_for_reject']; ?></p>   
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		    </div>
		  </div>
		</div>

		<?php } } ?>








							
							<!-- password change................ -->
							<div class="col-sm-9 custom_cla password_change" style="display:none;">
								<div class="user-right-side">
									<h1 style="padding-left: 41px;">Reset Password</h1><hr>
									<form  method="post" enctype="multipart/form-data" class="reset_password">  
										<div class="edit-user-section" style="border-bottom: 0px solid #e1e1e1;padding: 30px 43px;">
											<div class="row">
												<div class="col-lg-3">
													<p>Password</p>
												</div>
												<div class="col-lg-5">
													<input type="password" id="password" name="password" class="form-control" value="<?php echo $user_profile['password']; ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<p>Confirm Password</p>
												</div>
												<div class="col-lg-5">
													<input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $user_profile['password']; ?>">
												</div>
											</div>
											<div class="">
											<div class="row nomargin" style="background: #fff; padding: 10px 0;">
												<div class="col-sm-12" style="padding-left: 0px;">
													<button type="submit" class="btn btn-primary" style="width: 10%;">SAVE</button>
												</div>                                 
											</div>
										</div>
										</div>
										</form>
									</div>
							</div>
							<!-- contact us................ -->
							<!-- <div class="col-sm-9 custom_cla contact_us" style="display:none;">
								<div class="user-right-side">
									<h1 style="padding-left: 34px;">Contact Us</h1> <hr>
									<form  method="post" enctype="multipart/form-data" class="">  
									<div class="edit-user-section">
										<div class="emailmsg">Message was Sent To Administrator
											<button type="button" class="close" data-dismiss="modal" style="color:white !important;opacity:1 !important;margin-top:-3px" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										</div>
										
										<div class="col-lg-12">
											<div class="form-group">
												<label class="control-label" for="">Message*</label> <div class=""><textarea class="form-control contact_msg" style="width: 756px; height: 137px;"></textarea></div>

											</div>
										</div>
									</div> 
									<div class="row nomargin" style="background: #fff; padding: 10px 0;">
										<div class="col-sm-12" style="padding-left: 38px;">
											<button type="button" class="btn btn-primary contact_admin" style="width: 10%;">Send</button>
										</div>                                 
									</div>
								</form>
							</div> -->
							


						</div>
					</div>
			</div>
		</div>
	</div>
<?php include 'include/footer.php'; ?>
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
<div id="myModal" class="modal cashout_popup">

  <!-- Modal content -->
	<div class="modal-dialog" role="document">
  <div class="modal-content">
    <!-- <span class="close">&times;</span> -->

	  <div class="cashout-popup">
        <div class="modal-header"><div style="padding:5px;"><i class="fa fa-times-circle fa-3 cashout_close" aria-hidden="true" style="text-align: right;float: right;font-size: 17px;color: #3d78cb;cursor: pointer;"></i></div></div>
		<div class="modal-body">  
		<p class="text-center">Available Balance: £<?php echo $credit_amounts;?></p>
		  <input type="text" placeholder="Enter Amount to Cashout" value="" name="" class="form-control input-md text-center marketer_cashout_value">
		  <input type="hidden"class="balance_marketer" value="<?php echo $credit_amounts;?>">
		  <input type="hidden"class="balance_min" value="<?php echo $min_cashout?>">
		  <p class="text-center"></p>
		  <!-- <p class="text-center">If you want to cash out,it must reach £<?php echo $min_cashout; ?></p> -->
		  	<?php if(!empty($marketers_account_info)){ 
			  	$payout_bank_name = $marketers_account_info->wd_bank;
				$payout_account_number = $marketers_account_info->wd_account;
				$payout_sort_code = $marketers_account_info->wd_ifsc_code;
				$payout_account_holder_name = $marketers_account_info->wd_account_holder;
				$payout_paypal_email_address = $marketers_account_info->paypal_email_address;
				if(isset($settings) && $settings['payment_method']=='both'){ 
					if($marketers_account_info->wd_account!=''){ $a = 1; ?>
						<div class="row" style="text-align: left;">
						  <input type="radio" style="margin-left:25px;margin-top: 18px;" name="account_details" value="Bank Transfer">
						  <label>Send Payout to <?php echo $marketers_account_info->wd_bank;   $account = (string)$marketers_account_info->wd_account; echo ' *********'.substr($account, -5); ?> </label>
						</div>
					<?php }
					if($marketers_account_info->paypal_email_address != ''){
						$b = 1; $paypal_email_address=$marketers_account_info->paypal_email_address; ?>
						<div class="row" style="text-align: left; margin-top:0px;">
						  <input type="radio" style="margin-left:25px;" class="paypal_details" name="account_details" value="Paypal Transfer">
						  <label>Send Payout to Paypal <?php echo $paypal_email_address?></label>
						</div> 
					<?php } ?>

				<?php }elseif(isset($settings) && $settings['payment_method']=='bank_transfer'){ $a = 1; ?>
					<div class="row" style="text-align: left;">
					  <input type="radio" style="width: 10%;margin-top: 18px;" name="account_details" value="Bank Transfer">
					  <label>Send Payout to <?php echo $marketers_account_info->wd_bank;   $account = (string)$marketers_account_info->wd_account; echo ' *********'.substr($account, -5); ?> </label>
					</div>
				<?php }elseif(isset($settings) && $settings['payment_method']=='paypal' && $marketers_account_info->paypal_email_address!==''){ $b = 1; $paypal_email_address=$marketers_account_info->paypal_email_address; 

				?>
					<div class="row" style="text-align: left;margin-top:0px;">
					  <input type="radio" style="width: 10%;" class="paypal_details" name="account_details" value="Paypal Transfer">
					  <label>Send Payout to Paypal <?php echo $paypal_email_address?></label>
					</div>
			<?php } ?>


		  	<input type="hidden" class="is_account_fill" value="<?php echo $a?>">
			<input type="hidden" class="is_paypall_fill" value="<?php echo $b?>">
			<input type="hidden" class="p_paypal_email_address" value="<?php echo $payout_paypal_email_address; ?>">
			<input type="hidden" class="p_account_holder_name" value="<?php echo $payout_account_holder_name; ?>">
			<input type="hidden" class="p_sort_code" value="<?php echo $payout_sort_code?>">
			<input type="hidden" class="p_account_number" value="<?php echo $payout_account_number; ?>">
			<input type="hidden" class="p_bank_name" value="<?php echo $payout_bank_name; ?>">
			<p class="text-center" id="payErr" style="color:red;"></p>
		  <?php }else{  ?>
				<p class="account_settings" style="cursor:pointer;margin-top: 10px;text-align: left;margin-left: 124px;"><a href="javascript:void(0)">Please fill the Bank Account details</a></p>
			<?php } ?>
		  	
			<div class="modal-footer">
				<button class="btn btn-primary marketer_cashout_request">SUBMIT</button>
			</div>  
	  </div>
  </div> 
		  </div>
 
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>






<script>
  function send_mail(){
    $('.signup_btn1').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
    $('.signup_btn1').prop('disabled',true);
}
</script>
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
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
    	ordering: false,
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

  $(function(){
    $("#boottable2").DataTable({
    	ordering: false,
      	stateSave: true,
     	lengthChange: false, 
      	// searching: false,
        // "lengthMenu": [[5, 50, 100, -1], [5, 50, 100, "All"]],
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
	function deleteRequestContact(row_id) {
		if(confirm("Are you sure want to delete?")){
			jQuery.ajax({
				url:'<?= base_url(); ?>Users/delete_request',
				type:"post",
				dataType:'json',
				data :{ row_id:row_id},
				cache: false,
				success: function(response)
				{ 
					console.log(response);
					if(response == 1){
						$('#row_id-'+row_id).remove();
					}
				} 
			});

		}
	}
  function mark_read(row_id, status) {
  	jQuery.ajax({
		url:'<?= base_url(); ?>Users/mark_read',
		type:"post",
		dataType:'json',
		data :
		{ row_id:row_id, status:status },
		cache: false,
		success: function(response)
		{ 
			console.log(response);
			if(response == 1){
				$('#read_btn-'+row_id).remove();
			}

		} 
	});
  }
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(document).on('click', '#man_bbbon', function() {
			jQuery('#sidd_cll').toggleClass('sidebar-show', '');
		});



		jQuery(document).on("click",".marketer_cashout_request",function(){
			var amount= jQuery('.marketer_cashout_value').val();
			var balance= jQuery('.balance_marketer').val();
			var is_account_fill= jQuery('.is_account_fill').val();
			var is_paypall_fill= jQuery('.is_paypall_fill').val();
			var paypal_email_address= jQuery('.p_paypal_email_address').val();
			var account_holder_name= jQuery('.p_account_holder_name').val();
			var sort_code= jQuery('.p_sort_code').val();
			var bank_name= jQuery('.p_bank_name').val();
			var account_number= jQuery('.p_account_number').val();
			var min_amount= jQuery('.balance_min').val();
			if(is_account_fill == 0 &&  is_paypall_fill == 0){
				alert('Please fill the account details');
			}else{
				if(amount == ''){
				$('#payErr').text('Please Enter Cashout Amount');

				}else{
					if(balance == '0'){
						$('#payErr').text('There is no balance to cashout');
						return;
					}else{
						if(parseInt(balance) >= parseInt(min_amount)){
							if(parseInt(amount) > parseInt(balance)){
								$('#payErr').text('There is not enough balance');
							}else{
								if(parseInt(amount) >= parseInt(min_amount)){
									if(jQuery('input[name="account_details"]').is(':checked')){
											var value= jQuery('input[name="account_details"]:checked').val();
											jQuery.ajax({
						    				url:'<?= base_url(); ?>Users/marketers_payouts',
								        type:"post",
								        dataType:'json',
								        data :
						            {
						            transfer_type:value,
						            amount:amount,
						            paypal_email_address:paypal_email_address,
						            account_holder_name:account_holder_name,
						            sort_code:sort_code,
						            bank_name:bank_name,
						            account_number:account_number
						            },
						            cache: false,
						            success: function(response)
						            { 
						            	console.log(response);
						            	if(response == 1){
						            		// alert('Successfully Send payout request to admin');
						            		setTimeout(function(){
							                      location.reload(true);
							                       }, 1000);
						            	}
						            	if(response == 2){
						            		// alert('You can not make new request until your previews request is pending!!');
						            		location.reload(true);
						            	}

						            } 
						    			});
									}else{
										$('#payErr').text('Please Select Transfer Account');
									}
								}else{
		                            $('#payErr').text('Minimum cashout amount must not be less than £'+min_amount);
		                        }
							}
						}else{
									$('#payErr').text('If you want to cash out,it must reach £'+min_amount+'');

							// alert('If you want to cash out,it must reach '+min_amount+'');
						}
					}
				}
			}

		});
		jQuery(document).on("click",".copied_url",function(){
		    var attr_id = jQuery(this).attr('attr-id');
		    
		    	var copyText = document.getElementById(attr_id);
		  
		    copyText.select();
		    navigator.clipboard.writeText(copyText.value);
		    // alert("Copied the Url");
		  });
		jQuery(document).on('click','.marketers_menu',function(){
			var value = jQuery(this).attr('attr-value');
			console.log(value);
			var menu_list = ['referral_links','referral_table','my_details','balance_cashout','payment_settings','password_change','contact_us', 'view_payout_request_settings'];
			for(var k=0;k<menu_list.length;k++){
				if(menu_list[k] == value){
					jQuery('.'+menu_list[k]+'').show();
				}else{
					jQuery('.'+menu_list[k]+'').hide();
				}
			}


		});
		jQuery('.update_marketers_details').submit(function(e){
   			 e.preventDefault();
    	var f_name= jQuery('#f_name').val();
			var l_name= jQuery('#l_name').val();
			var e_address= jQuery('#e_address').val();
			var countryus1= jQuery('#countryus1').val();
			var e_city= jQuery('#e_city').val();
			var profile= jQuery('#u_profile_old').val();
			var email= jQuery('#email').val();
			var phone_no= jQuery('#phone_no').val();
			if(f_name == '' || l_name == '' || e_address == '' || countryus1 == '' || e_city == '' || profile == '' || email == '' || phone_no == '' ){
				alert(' All Fields Are Mandatory');
			}
			else{ 
				    jQuery.ajax({
		             url:'<?= base_url(); ?>Users/update_marketer_profile',
		             type:"post",
		             dataType:'json',
		             data:new FormData(this),
		             processData:false,
		             contentType:false,
		             cache:false,  
		             async:false, 
		             success: function(data){
		                console.log(data);
		                if(data == 1){
		                	alert('Profile Updated Successfully');
		                	setTimeout(function(){
		                      location.reload(true);
		                       }, 1000);
		                }else{
		                	alert("Profile doesn't Updated");
		                }
		           },error:function(ts){
		             console.log(ts);
		           }
		         });
			}
    	});		
			jQuery('.reset_password').submit(function(e){
   			 e.preventDefault();
    	var password= jQuery('#password').val();
			var confirm_password= jQuery('#confirm_password').val();
			if(password == '' || confirm_password == ''){
				alert(' All Fields Are Mandatory');
			}
			else{
					if(password != confirm_password){
						alert('Password and Confirm password should be matched');
					}else{
							jQuery.ajax({
		             url:'<?= base_url(); ?>Users/reset_password',
		             type:"post",
		             dataType:'json',
		             data:new FormData(this),
		             processData:false,
		             contentType:false,
		             cache:false,  
		             async:false, 
		             success: function(data){
		                console.log(data);
		                if(data == 1){
		                	alert('Password Updated Successfully');
		                	setTimeout(function(){
		                      location.reload(true);
		                       }, 1000);
		                }else{
		                	alert("Password doesn't Updated");
		                }
		           },error:function(ts){
		             console.log(ts);
		           }
		         });
					} 
					}
    	}); 		
		jQuery('.update_marketers_account_details').submit(function(e){
   			 e.preventDefault();
    	var account_holder_name= jQuery('#account_holder_name').val();
			var account_holder_address= jQuery('#account_holder_address').val();
			var account_number= jQuery('#account_number').val();
			var sort_code= jQuery('#sort_code').val();
			var bank_name= jQuery('#bank_name').val();
			var paypal_email_address= jQuery('#paypal_email_address').val();
		 	if((account_holder_name == '' || account_holder_address == '' || account_number == '' || sort_code == '' || bank_name == '') && (paypal_email_address == '')){
				alert('Please fill Bank or Paypal details');
				
			}
			else{ 
				    jQuery.ajax({
		             url:'<?= base_url(); ?>Users/update_marketers_account_details',
		             type:"post",
		             dataType:'json',
		             data:new FormData(this),
		             processData:false,
		             contentType:false,
		             cache:false,  
		             async:false, 
		             success: function(data){
		                console.log(data);
		                if(data == 1){
		                	alert('Payment Settings Updated Successfully');
		                	setTimeout(function(){
		                      location.reload(true);
		                       }, 1000);
		                }else{
		                	alert("Payment Settings doesn't Updated");
		                }
		           },error:function(ts){
		             console.log(ts);
		           }
		         });
			}
    	});
    	jQuery(document).on('click','.edit_marketers',function(){
    		jQuery('.marketer_profile_edit').trigger('click');
    	});
    	jQuery(document).on('click','.account_settings',function(){
    		jQuery('#myModal').hide();
    		jQuery('.account_settings_edit').trigger('click');
    	}); 
    	jQuery(document).on('click','.view_payout_request',function(){
    		// jQuery('.view_payout_request_settings').show();
    		jQuery('.view_payout_request_edit').trigger('click');
    	}); 

    	jQuery(document).on('click','.contact_admin',function(){
    		var contact_msg= jQuery('.contact_msg').val();
    		// var phone_no= jQuery('.phone_no').val();
    		// var f_name= jQuery('.f_name').val();
    		// var l_name= jQuery('.l_name').val();
    		// var email= jQuery('.email').val();
    		if(contact_msg == ''){ 
    			alert('Please Enter the Message');
    		}
    		else{ 
	    			jQuery.ajax({
	    				url:'<?= base_url(); ?>Users/contact_admin',
			        type:"post",
			        dataType:'json',
			        data :
	            {
	            contact_msg:contact_msg,
	            // phone_no:phone_no,
	            // f_name:f_name,
	            // l_name:l_name,
	            // email:email
	            },
	            cache: false,
	            success: function(response)
	            { 
	            	console.log(response);
	            	if(response == 1){
	            		jQuery('.contact_msg').val('');
						jQuery('.emailmsg').show();
	            	}
	            } 
	    			});
    		}
    	}); 
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
		
 });
</script>
<script> 
	setInterval(function() {
		support_msg_unread();
	}, 1500);


	function support_msg_unread() {
		jQuery.ajax({
			url:"<?= base_url('users/support_msg_unread'); ?>",
			type:'get',
			dataType:'json',
			cache:false,
			success:function(res){
				if(res.unreadMessages){
					jQuery('#support_msg_unread').css('display', 'block');
					jQuery('#support_msg_unread').text(res.unreadMessages);
				}else{
					jQuery('#support_msg_unread').css('display', 'none');
				}
			}
		});
	}





    jQuery(document).ready(function(){
    	
    	


        jQuery(document).on('click','.pending_table',function(){
            jQuery('#pending_table').show();
            jQuery('#approved_table').hide();
            jQuery('#rejected_table').hide();
        });
        jQuery(document).on('click','.approved_table',function(){

            jQuery('#approved_table').show();
            jQuery('#pending_table').hide();
            jQuery('#rejected_table').hide();

        });
        jQuery(document).on('click','.rejected_table',function(){
            jQuery('#rejected_table').show();
            jQuery('#approved_table').hide();
            jQuery('#pending_table').hide();
        });
    });
  </script>

  <script type="text/javascript">
		$(document).ready(function(){
<?php if(isset($_GET['p']) && $_GET['p']=='referral_links'){ ?>
	$(".referral-links-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='referral_table'){ ?>
	$(".referral-table-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='my_details'){ ?>
	$(".my-details-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='balance_cashout'){ ?>
	 	$(".balance-cashout-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='payment_settings'){ ?>
	 	$(".payment-settings-menu").trigger("click");
	 	alert();
<?php }elseif(isset($_GET['p']) && $_GET['p']=='view_payout_request_settings'){ ?>
	 	 $(".view-payout-request-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='password_change'){ ?>
	 	$(".password-change-menu").trigger("click");
<?php }elseif(isset($_GET['p']) && $_GET['p']=='contact_us'){ ?>
	 	$(".contact-us-menu").trigger("click");
<?php } ?>
	})
	</script>
	