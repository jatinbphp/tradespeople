<?php 
if($user_data['type']==1 && $user_data['u_email_verify']==0) {
	//redirect('email-verify');
}
$page_name=$this->uri->segment(1); 

$user_profile=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
  
$percentage=0;
if($user_profile['u_email_verify']==1) {
	$percentage=20; 
}
  
if(!empty($user_profile['phone_no'])) {  
	$percentage=$percentage+20;
}
    
if(!empty($user_profile['profile'])) {
  $percentage=$percentage+15;
}

$get_certification=$this->common_model->get_education('user_certification',$this->session->userdata('user_id'));
    
if($get_certification) {
	$percentage=$percentage+15;
}
   
$get_education=$this->common_model->get_education('user_education',$this->session->userdata('user_id'));

if($get_education) {
	$percentage=$percentage+15;
}
   
$get_portfolio=$this->common_model->get_education('user_portfolio',$this->session->userdata('user_id'));

if($get_portfolio) {
	$percentage=$percentage+15;
}
$isUrlExpired = $this->common_model->check_review_invitation_count($user_profile['id']);

$required = ($isUrlExpired) ? 'required=""' : '';
$settings = $this->common_model->get_all_data('admin');
?>




<div class="man_nan">
	<button type="button" class="navbar-toggle" id="man_bbbon">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
</div>
<?php  if($this->session->userdata('type')==3){ ?>
	<div class="sidebarnav" id="sidd_cll">
	<div class="sub-sidebar-container">
		<div class="user-page-menu">
<!-- Affiliate Routes -->

	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=referral_links">
		<i class="fa fa-info-circle" aria-hidden="true"></i>Shareable Links</a></p>
	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=referral_table"><i class="fa fa-list" aria-hidden="true"></i>Report</a></p>
	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=my_details"><i class="fa fa-pencil" aria-hidden="true"></i>My Details</a></p>
	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=balance_cashout"><i class="fa fa-cc-visa" aria-hidden="true"></i>Cashout</a></p>
	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=payment_settings"><i class="fa fa-credit-card" aria-hidden="true"></i>Payment Setting</a></p>
	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=view_payout_request_settings"><i class="fa fa-credit-card" aria-hidden="true"></i></span>Payment History</a></p>

	<p><a href="<?= site_url('affiliate-dashboard'); ?>?p=password_change"><i class="fa fa-lock" aria-hidden="true"></i>Password</a></p>
	<!-- <p><a href="<?= site_url('affiliate-dashboard'); ?>?p=contact_us"><i class="fa fa-home" aria-hidden="true"></i>Contact Us</a></p> -->


</div>
</div>
</div>
<?php }else{ ?>


<div class="sidebarnav" id="sidd_cll">
	<div class="sub-sidebar-container">
		<?php
			if($settings[0]['payment_method'] == 1){
				if($this->session->userdata('type')==1){
		?>
			<div class="sub-sidebar">
				<a href="<?php echo base_url('wallet'); ?>"><i class="fa fa-cog" aria-hidden="true"></i>
					<span>Pay as you go</span>
					<a href="<?php echo base_url('membership-plans'); ?>"><b>Upgrade</b></a>
				</a>                    
			</div>
		<?php } }?>
		
		<div class="meter blue">
			<span style="width: <?php echo $percentage; ?>%; line-height:30px; font-weight:600;">
				<?php echo $percentage; ?>%
			</span>
		</div>
	
	</div>
	<div class="user-page-menu">
		<?php if($this->session->userdata('type')==1){ ?>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
							<span><i class="fa fa-th" aria-hidden="true"></i></span> My Services
							</a>
						</h4>
					</div>
					<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
                  
							<p><a href="<?php echo base_url('my-services'); ?>"> <span><i class="fa fa-list-ul" aria-hidden="true"></i></span> List Service</a></p>
                   
							<p><a href="<?php echo base_url('my-services'); ?>"> <span><i class="fa fa-gear" aria-hidden="true"></i></span> Manage Service</a></p>
                      
							<p><a href="<?php echo base_url('my-orders'); ?>"> <span><i class="fa fa-cart-plus" aria-hidden="true"></i></span> Orders</a></p>
									
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if($page_name=='dashboard'){ ?>
      <p>
				<a href="<?php echo base_url('dashboard'); ?>" class="active"><span><i class="fa fa-home" aria-hidden="true"></i></span> My Account</a>
			</p>
		<?php }else{ ?>
		
			<p>
				<a href="<?php echo base_url('dashboard'); ?>">
        <span><i class="fa fa-home" aria-hidden="true"></i></span>Dashboard</a>
			</p>
        
		<?php } ?>
							
		<?php if($this->session->userdata('type')==1){ ?>
		
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			
			<div class="panel panel-default">
				
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							 <span><i class="fa fa-pencil" aria-hidden="true"></i></span> My Details
						</a>
					</h4>
				</div>

				<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						<p><a href="<?php echo base_url('edit-profile'); ?>"> <span><i class="fa fa-user" aria-hidden="true"></i></span> Personal Details</a></p>
						
						<p><a href="<?php echo base_url('company'); ?>"> <span><i class="fa fa-info-circle" aria-hidden="true"></i></span> Company</a></p>
						
						<p><a href="<?php echo base_url('trades') ?>"> <span><i class="fa fa-wrench" aria-hidden="true"></i></span> Category </a></p>
						
						<p><a onclick="update_noti();" href="<?php echo base_url('notifications'); ?>"> <span><i class="fa fa-bell" aria-hidden="true"></i></span> Notifications <?php echo ($count > 0) ?  '<span style="background:red;color:#fff;" class="badge">'.$count.'</span>' : '';?></a></p>
						
						<p style="display: none;"><a href="#"> <span><i class="fa fa-users" aria-hidden="true"></i></span> Directory Details</a></p>
						
						<p><a href="<?php echo base_url('change-password'); ?>"> <span><i class="fa fa-lock" aria-hidden="true"></i></span> Password</a></p>

						<p><a href="<?php echo base_url('delete-account'); ?>"> <span><i class="fa fa-trash" aria-hidden="true"></i></span> Delete My Account</a></p>
						
					</div>
				</div>
			</div>
		</div> 
		<?php } ?>
		
		<?php if($this->session->userdata('type')==1){ ?>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
							<span><i class="fa fa-list" aria-hidden="true"></i></span> My Jobs
							</a>
						</h4>
					</div>
					<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
                  
							<p><a href="<?php echo base_url('work-in-progress'); ?>"> <span><i class="fa fa-user" aria-hidden="true"></i></span> Work in Progress</a></p>
                   
							<p><a href="<?php echo base_url('recent-jobs'); ?>"> <span><i class="fa fa-info-circle" aria-hidden="true"></i></span> New Job</a></p>
                      
							<p><a href="<?php echo base_url('completed'); ?>"> <span><i class="fa fa-wrench" aria-hidden="true"></i></span> Completed Jobs</a></p>
									
						</div>
					</div>
				</div>
			</div>
			<p><a href="<?php echo base_url('verify'); ?>"><span><i class="fa fa-unlock-alt" aria-hidden="true"></i></span> Account Verification</a></p>

			<?php if($settings[0]['payment_method'] == 1){?>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
									<span><i class="fa fa-cog" aria-hidden="true"></i></span> Membership Manag.
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
											
								<p><a href="<?php echo base_url('wallet'); ?>"> <span><i class="fa fa-money" aria-hidden="true"></i></span> Paid as you go</a></p>
	                     
								<p><a href="<?php echo base_url('subscription-plan'); ?>"> <span><i class="fa fa-cubes" aria-hidden="true"></i></span> Subscription</a></p>
								<p><a href="<?php echo base_url('addons'); ?>"> <span><i class="fa fa-plus" aria-hidden="true"></i></span> Addons</a></p>
							</div>
						</div>
					</div>
				</div>
			<?php }?>	

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
								<span><i class="fa fa-credit-card" aria-hidden="true"></i></span> Billing
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<?php if($settings[0]['payment_method'] == 1){?>
							<p>
								<a href="<?php echo base_url('wallet'); ?>"> <span><i class="fa fa-cc-visa" aria-hidden="true"></i></span> Wallet</a>
							</p>							
							<!-- <p><a href="<?php echo site_url().'billing-info/?verify=1'; ?>"> <span><i class="fa fa-cc-visa" aria-hidden="true"></i></span> Update debit/credit card</a></p> -->
							<p><a href="<?php echo site_url().'save-card-list'; ?>"> <span><i class="fa fa-cc-visa" aria-hidden="true"></i></span> Update debit/credit card</a></p>
							
							<?php }?>
							
							<p>
								<a href="<?php echo base_url('manage-bank'); ?>"><span><i class="fa fa-bank" aria-hidden="true"></i></span> Manage Bank Account</a>
							</p>
                 
							<p><a href="<?php echo base_url('invoices'); ?>"> <span><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span> Invoice</a></p>
                   
							<p><a href="<?php echo base_url('transaction-history'); ?>"> <span><i class="fa fa-calendar" aria-hidden="true"></i></span> History</a></p> 
                   
							<p><a href="<?php echo base_url('rewards'); ?>"> <span><i class="fa fa-bullhorn" aria-hidden="true"></i></span> Rewards </a></p> 

						</div>
						
					</div>
				</div>
			</div>
  
			<p><a href="<?php echo base_url('profile/'.$this->session->userdata('user_id')); ?>"><span><i class="fa fa-wrench" aria-hidden="true"></i></span> My Profile</a></p>
			
			<!--p><a href="<?php echo base_url('my_reviews'); ?>"><span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> My review</a></p--> 
			
			<p style="display: none;"><a href="#"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span> My Ticket</a></p>
			
			<p style="display: none;">
				<a href="<?php echo base_url('milestone-requests'); ?>"><span><i class="fa fa-comment" aria-hidden="true"></i></span>Milestone Request</a>
			</p>
   
   
			<p>
				<a href="<?php echo base_url('earnings'); ?>"><span><i class="fa fa-google-wallet" aria-hidden="true"></i></span> Earnings</a>
			</p>
			
		<?php } ?> 
		
		<?php if($this->session->userdata('type')==2){ ?>
    <p>
			<a href="<?php echo base_url('edit-profile'); ?>"><span><i class="fa fa-pencil" aria-hidden="true"></i></span> My Details</a>
		</p> 
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
						 <span><i class="fa fa-list" aria-hidden="true"></i></span> My Jobs
						</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
									 
						<p><a href="<?php echo base_url('jobs-in-progress'); ?>"> <span><i class="fa fa-user" aria-hidden="true"></i></span> Work in Progress</a></p>
										
						<!--p><a href="<?php echo base_url('new-jobs'); ?>"> <span><i class="fa fa-info-circle" aria-hidden="true"></i></span> New Job</a></p-->
						<p><a href="<?php echo base_url('my-account'); ?>"> <span><i class="fa fa-info-circle" aria-hidden="true"></i></span> New Job</a></p>
									 
						<p><a href="<?php echo base_url('jobs-completed'); ?>"> <span><i class="fa fa-wrench" aria-hidden="true"></i></span> Completed Jobs</a></p>
						
						<p><a href="<?php echo base_url('jobs-rejected'); ?>"> <span><i class="fa fa-wrench" aria-hidden="true"></i></span> Rejected Jobs</a></p>
									 
						<p style="display: none;"><a href="<?php echo base_url('disputed-milestones'); ?>"> <span><i class="fa fa-users" aria-hidden="true"></i></span> Disputed Milestones</a></p>
								 
					</div>
				</div>
			</div>
		</div>
            
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
							<span><i class="fa fa-credit-card" aria-hidden="true"></i></span> Billing
						</a>
					</h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
							<p><a href="<?php echo base_url('wallet'); ?>"> <span><i class="fa fa-cc-visa" aria-hidden="true"></i></span> Wallet</a></p>
						<?php if($settings[0]['payment_method'] == 1){?>
							<p><a href="<?php echo site_url().'save-card-list'; ?>"> <span><i class="fa fa-cc-visa" aria-hidden="true"></i></span> Update debit/credit card</a></p>
						<?php }?>	
						<!-- <p>
								<a href="<?php echo base_url('manage-bank'); ?>"><span><i class="fa fa-bank" aria-hidden="true"></i></span> Manage Bank Account</a>
							</p> -->
						<p><a href="<?php echo base_url('invoices'); ?>"> <span><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span> Invoice</a></p>
                   
						<p><a href="<?php echo base_url('transaction-history'); ?>"> <span><i class="fa fa-calendar" aria-hidden="true"></i></span> History</a></p> 
						
						<p><a href="<?php echo base_url('spendamount-history'); ?>"> <span><i class="fa fa-calendar" aria-hidden="true"></i></span> Spend History</a></p> 
                    
					</div>
				</div>
			</div>
		</div>
         
		<p style="display: none;"><a href="#"><span><i class="fa fa-money" aria-hidden="true"></i></span> Deposit fund</a></p> 
           
		<p style="display: none;"><a href="#"><span><i class="fa fa-money" aria-hidden="true"></i></span> Create Milestone</a></p> 
                  
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="display: none;">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3">
							<span><i class="fa fa-comment" aria-hidden="true"></i></span> Message
						</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
						
						<p><a href="#"> <span><i class="fa fa-money" aria-hidden="true"></i></span> Read</a></p>
                      
						<p><a href="<?php echo base_url('membership-plans'); ?>"> <span><i class="fa fa-cubes" aria-hidden="true"></i></span> Unread</a></p>
					
					</div>
								
				</div>
            
			</div>
		</div>
             
		<p><a href="<?php echo base_url('change-password'); ?>"><span><i class="fa fa-lock" aria-hidden="true"></i></span> Password</a></p>

		<p><a href="<?php echo base_url('delete-account'); ?>"> <span><i class="fa fa-trash" aria-hidden="true"></i></span> Delete My Account</a></p>
             
		<!--p><a href="<?php echo base_url('my_reviews'); ?>"><span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> Reviews</a></p--> 
              
		<p style="display: none;"><a href="#"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span> My ticket</a></p> 
          
		 
         
		<?php } ?>
		
		<p><a href="<?php echo base_url('inbox'); ?>"><span><i class="fa fa-comment" aria-hidden="true"></i></span> Messenger</a></p>
		
		<?php  if($user_profile['u_email_verify']==0){ ?>
		<p>
			<a href="<?php echo base_url('email-verify'); ?>">
			<span><i class="fa fa-check-square-o	" aria-hidden="true"></i></span>Verify your email</a>
		</p>
		<?php } ?>

		<?php if($this->session->userdata('type')==1){ ?>
		
		<?php 
		$check_invitation = $this->common_model->GetColumnName('admin',array('invite_to_review_status'=>1,'id'=>1),array('id'));
		if($check_invitation){ ?>
		<?php if($user_profile['review_invitation_status']==1){ ?>
		<p><a  data-toggle="modal" data-target="#invite_review"> <i class="fa fa-handshake-o" aria-hidden="true"></i></span> Invite to review</a></p>
		<?php } ?>
		<?php } ?>
		
		<?php } ?>
    <?php
      $unreadMessages = $this->common_model->check_admin_unread('admin_chat_details', array('is_read' => 0, 'receiver_id' => $user_data['id']), 'is_read');

     
    ?>
    <p><a href="<?= site_url().'Support/tickets'?>"> <i class="fa fa-envelope" aria-hidden="true"></i></span> Support Center <?=($unreadMessages > 0) ?  '<span style="background:red;color:#fff;" class="badge">' .$unreadMessages.'</span>' : '';?> </a></p>

     <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5">
							<span><i class="fa fa-list" aria-hidden="true"></i></span> Invite & Earn
							</a>
						</h4>
					</div>
					<div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
              <p><a href="<?php echo base_url('new-referral'); ?>"> <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>Referral Links</a></p>
							<p><a href="<?php echo base_url('exists-refferals'); ?>"> <span><i class="fa fa-user" aria-hidden="true"></i></span>Referral report</a></p>
						</div>
					</div>
				</div>
			</div>

		<p><a href="<?= site_url().'home/logout'?>"> <i class="fa fa-unlock" aria-hidden="true"></i></span> Logout</a></p>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
  $("#man_bbbon").click(function(){
    $("#sidd_cll").toggleClass("opn_d");
  });
});
</script>


<?php  } ?>