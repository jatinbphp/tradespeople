<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style>
/* The container */
.paymrnt_div {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background: #fff;
  box-shadow: 0 1px 2px #d0d0d0;
  padding: 20px;
  width: 100%;
  border-radius: 6px;
}
.modal-backdrop.fade.in {
  opacity: 0.5;
}

/* Hide the browser's default radio button */
.paymrnt_div input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 24px;
  left: 15px;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.paymrnt_div:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.paymrnt_div input:checked ~ .checkmark {
  background-color: #FE8A0F;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.paymrnt_div input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.paymrnt_div .checkmark:after {
  top: 3px;
  left: 3px;
  width: 19px;
  height: 19px;
  border-radius: 50%;
  background: white;
}
.contant_lable img {
  width: 100px;
  margin-left: 39px;
}
</style>
<style>
.fade {
  opacity: 0;
  -webkit-transition: opacity .15s linear;
  transition: opacity .15s linear;
  display: none;
}
.fade.in {
  opacity: 1;
  display: block;
}
#zoid-paypal-button-1c5cec317c {
		font-size: 0;
		width: 100%;
		overflow: hidden;
		min-width: 75px;
}

#zoid-paypal-button-1c5cec317c.paypal-button-size-responsive {
		text-align: center;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet {
		display: inline-block;
		min-width: 75px;
		max-width: 750px;
		position: relative;
}

#zoid-paypal-button-1c5cec317c.paypal-button-layout-vertical > .zoid-outlet {
		min-width: 75px;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet {
		width:  150px;
		height: 25px;
}

 #zoid-paypal-button-1c5cec317c.paypal-button-size-responsive > .zoid-outlet {
		width: 100%;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe {
		min-width: 100%;
		max-width: 100%;
		width: 75px;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-component-frame {
		z-index: 100;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-prerender-frame {
		transition: opacity .2s linear;
		z-index: 200;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-visible {
		opacity: 1;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-invisible {
		opacity: 0;
		pointer-events: none;
}
.table-responsive {
	overflow: auto;
}
@media (max-width:575.98px){
	.table-responsive-sm{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-sm>.table-bordered{
			border:0
	}
}
@media (max-width:767.98px){
	.table-responsive-md{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-md>.table-bordered{
		border:0
	}
}
@media (max-width:991.98px){
	.table-responsive-lg{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-lg>.table-bordered{
		border:0
	}
}
@media (max-width:1199.98px){
	.table-responsive-xl{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-xl>.table-bordered{
		border:0
	}
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
						<h2><strong>Your Withdrawals</strong></h2>
					</div>
					<?php if($this->session->flashdata('error')) { ?>
          
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
          
					<?php } ?> 
				
					<?php if($this->session->userdata('success121')){ ?>
					<p class="alert alert-success">Your request of withdrawal has been submitted successfully. Please wait for admin response.</p>
					<?php $this->session->unset_userdata('success121'); } ?>

					<div class="user-right-side">
						<div class="container">
							<br>
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#select">Withdrawal</a></li>
								<li><a data-toggle="tab" href="#withdraw_history" id="withdraw-history-tab">Withdrawal History</a></li> 
							</ul>
						</div>
						<div id="withdraw_history" class="tab-pane fade">
							<h1>Withdrawal History</h1> 
							<div class="setbox2">
								<div class="table-responsive">
<table id="boottable" class="table table-bordered table-striped">
            
	<thead>

		<tr> 
			<th>S.NO</th> 
			<th>Date</th> 
			<th>Amount</th>
			<th>Payment By</th>
			<th>Status</th> 
			<th>Action</th>              
		</tr>
                
	</thead>
              
	<tbody>
						
		<?php
                
		$x=1;
                
		foreach($withdrawal as $lists){
 
		?>
             
		<tr role="row" class="odd">
			<td><?php echo $x; ?></td>  
			
			<td>
				<?php 
				$cdate=strtotime($lists['wd_create']); 
				echo date('d',$cdate); 
				echo ' '.date('M', $cdate); ?><br>
				<?php  echo date('h:i A', strtotime($lists['wd_create'])); ?>
			</td>
			<td><i class="fa fa-gbp"></i><?php if($lists['wd_amount']){ echo $lists['wd_amount']; }else{ echo "0"; } ?></td>
                 
			<td><?php if($lists['wd_payment_type']==1){ echo "Paypal"; }else{ echo "Bank Transfer"; } ?></td>
              
			<td>
				<?php if($lists['wd_status']==0){ ?>
				
				<span class="label label-success">Pending</span>
				
				<?php }else if($lists['wd_status']==1){ ?>
				
				<span class="label label-success">Accepted</span>
				
				<?php }else{ ?>
				
				<span class="label label-danger">Rejected</span>
				
				<?php } ?>
                     
			</td>   
			<td>    
				<a data-target="#view_document<?php echo $lists['wd_id']; ?>" href="" data-toggle="modal" class="btn btn-warning btn-xs">View More</a>
				<?php if($lists['wd_status']==2){ ?>
				<a href="#" data-target="#viewrejectreason1<?php echo $lists['wd_id']; ?>" data-toggle="modal"><button class="btn btn-danger btn-xs">View Reason</button></a>   
				<?php } ?>
			</td>
			<div class="modal fade popup" id="viewrejectreason1<?php echo $lists['wd_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel" style="text-align: left">Rejection Reason</h4>
						</div>
						<div class="modal-body">
							<fieldset>
									
								<!-- Text input-->
								<div class="form-group">
									<div class="col-md-12" style="text-align: left;">
										<?php echo $lists['wd_reason']; ?>
									</div>
								</div>
								<div class="col-md-12">
									<div class="perview_pro_img"></div>
								</div>
							</fieldset>
				 
						</div>
					</div>
				</div>
			</div>
                                                  
			<div class="modal fade popup" id="view_document<?php echo $lists['wd_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">MORE INFORMATION</h4>
						</div>
						<div class="modal-body">
							<fieldset>
									
								<!-- Text input-->
								<div class="form-group">
												 
									<div class="col-md-12">
										
										<div class="row">
											<div class="col-sm-8">          
												<div class="form-group">
													<p style="font-size: 15px;"><b>Payment Method :</b>
													<?php if($lists['wd_payment_type']==1){ ?>
													
													PayPal 
													
													<?php }else{ ?>
													
													Bank Transfer
													
													<?php } ?>
													
													</p>
													
													<?php if($lists['wd_payment_type']==1){ ?>
													
													<p><b>PayPal Email : </b><?php echo $lists['wd_pay_email']; ?></p>
													
													<?php }else{ 
													$bank_detail=$this->common_model->get_single_data('wd_bank_details',array('id'=>$lists['wd_bankid']));
													?>
													
													<p><b>Account Holder Name : </b><?php echo $bank_detail['wd_account_holder']; ?></p>
													
													
													<p><b>Bank Name : </b><?php echo $bank_detail['wd_bank']; ?></p>
													<p><b>Account Name: </b><?php echo $bank_detail['wd_account']; ?></p>
													<p><b>Sort Code : </b><?php echo $bank_detail['wd_ifsc_code']; ?></p>
																		 
													<?php } ?>
												</div>
												
											</div>
											 
										</div>
									</div>
								</div>
							</fieldset>
				 
						</div>
					</div>
				</div>
			</div>
					
		</tr>

                
		<?php $x++; } ?>
              
	</tbody>
              
</table> 
								</div>
							</div>
						</div>
						
						<div id="select" class="tab-pane fade in active">
							<h1>Please select withdrawal method</h1> 
							<div class="setbox2">
												
								<div class="row">
									<div class="col-sm-4">
										<div class="paymrnt_div">
											<label class="contant_lable">
												<img src="<?php echo base_url(); ?>img/bank.png">
												<input id="watch-me1" checked type="radio" name="test" value="xyz1">
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="paymrnt_div">
											<!--  <input id="watch-me" name="test" type="radio" /> <br /> -->
											<label class="contant_lable">
												<img src="<?php echo base_url(); ?>img/paypal.png">
												<input id="watch-me" value="xyz" type="radio" name="test">
												<span class="checkmark"></span>
											</label>
										</div>
															
									</div>
									
								</div>
							</div>
							<div class="setbox2" id="paypal" style="display: none;">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3 text-center">
							 
										<h3 class="text"> Withdrawal By Paypal </h3>
										<div class="Wallet_1 well wel-main">
											<h3 class="text"> <i class="fa fa-money" ></i> Balance
											<span><i class="fa fa-gbp"></i><?php if($user_profile['withdrawable_balance']!=''){ echo $user_profile['withdrawable_balance']; }else{ echo "0"; } ?></span>
											</h3>
										</div>
									</div>
								</div>
								<div class="row">
									<form method="post" id="withdraw_paypal" enctype="multipart/form-data"  onsubmit="return withdraw_pay();">
										<div class="col-sm-6 col-sm-offset-3 text-center">
											<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
											<div class="form-group text-left">
												<label>Please enter amount in 
													<i class="fa fa-gbp"></i> 
													<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Withdrawal amount must be more than £<?= $setting['p_min_w']; ?> and less than £<?= $setting['p_max_w']; ?>!" data-original-title="" class="red-tooltip toll"><i class="fa fa-info-circle"></i></a>
												</label>
												<input type="text" name="amount" id="amount" class="form-control quantity" onkeyup="check_value(this.value)" onblur="check_value(this.value)" required>
												<p class="instant-err alert alert-danger" style="display:none;"></p>
											</div>
											<div class="form-group text-left">
												<label>Enter your Paypal email</label>
												<input type="email" value="<?php echo ($last_paypal) ? $last_paypal['wd_pay_email'] : ''; ?>" name="email" id="email" class="form-control quantity" required>
									
											</div>
											<div class="pay_btns_laoder text-center"> 
												<div class="paypalBtnDesign card pay_btns" style="display: none;">
													<button type="submit" class="paypal btn btn-warning paypal_btn_div text-center paypal-button paypal-button-context-iframe paypal-button-label-checkout paypal-button-size-small paypal-button-layout-horizontal signup_btn" style="height: 38px;">Withdraw Now</button>
												</div>
											</div>
										</div>
														
									</form>
								</div>
							</div>
							<div class="setbox2" id="bank_account">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3 text-center">
										<h3 class="text"> Bank Transfer</h3>
										<div class="Wallet_1 well wel-main">
											<h3 class="text"> <i class="fa fa-money" ></i> Balance
												<span><i class="fa fa-gbp"></i><?php if($user_profile['withdrawable_balance']!=''){ echo $user_profile['withdrawable_balance']; }else{ echo "0"; } ?></span>
											</h3>

										</div>
										<!-- <h3 class="text"> Your Bank Details </h3> -->
									</div>
								</div>
			 
								<div class="msg2"><?= $this->session->flashdata('msg'); ?></div>
								<form method="post" id="bank_transfer" enctype="multipart/form-data"  onsubmit="return bank_transfer();">
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
											<div class="form-group text-left">
												<label>Please enter amount in 
													<i class="fa fa-gbp"></i> 
													<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Withdrawal amount must be more than £<?= $setting['p_min_w']; ?> and less than £<?= $setting['p_max_w']; ?>!" data-original-title="" class="red-tooltip toll"><i class="fa fa-info-circle"></i></a>
												</label>
												<input type="text" name="amount" id="amount" class="form-control quantity" onkeyup="check_value(this.value)" onblur="check_value(this.value)" required>
												<p class="instant-err alert alert-danger" style="display:none;"></p>
											</div>
										</div>
										<div class="col-sm-3"></div>

									</div>
									<div class="row">
										<div class="col-sm-3"></div>

										<div class="col-sm-6">
											<?php if(!empty($banks)){ ?>
										
											
											<?php foreach($banks as $key => $bank){ ?>
										
													<div>
														<input type="radio" <?= ($key==0) ? 'checked="checked"' : ''?> name="wd_bankid" id="<?= $bank['id']; ?>" value="<?= $bank['id']; ?>">
														<label for="<?= $bank['id']; ?>"><?= $bank['wd_bank']; ?> ....<?= mb_substr($bank['wd_account'],-4); ?></label>
													</div>
											
											
											
											<?php } ?>
											<?php } else {
												echo '<div class="alert alert-warning">Please add bank detail <a href="'.site_url('manage-bank').'">here</a></div>';
											} ?>

											
										</div>
										<div class="col-sm-3"></div>

									</div>
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3 text-center">
											<div class="pay_btns_laoder text-center"> 
											<div class="paypalBtnDesign card pay_btns" style="display: none;">
												<button type="submit" class="paypal btn btn-warning paypal_btn_div text-center paypal-button paypal-button-context-iframe paypal-button-label-checkout paypal-button-size-small paypal-button-layout-horizontal bank_transfer" style="height: 38px;">Withdraw Now</button>
											</div>
											</div>
										</div>
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
<script>  
    $(function(){
    $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
$(document).ready(function () { 
$("#watch-me").click(function() {
 $("#paypal").show();
 $("#bank_account").hide();
 });
$("#watch-me1").click(function() {
 $("#bank_account").show();
 $("#paypal").hide();
 });
});
function check_value(value){
  var min = <?= $setting['p_min_w']; ?>;
  var max = <?= $setting['p_max_w']; ?>;
  if(value >= min && value <= max){
    //$('.show_btn').prop('disabled',false);
    $('.instant-err').hide();
    $('.instant-err').html('');
    $('.pay_btns').show();
    amount = value;
  } else {
    $('.card').hide();
    //$('.show_btn').prop('disabled',true);
    $('.instant-err').show();
    $('.instant-err').html('Withdrawal amount must be more than £'+min+' and less than £'+max+'!');
    $('.pay_btns').hide();
  }
}
function withdraw_pay(){
  $.ajax({
    type:'POST',
    url:site_url+'wallet/withdraw_fund',
    data:$('#withdraw_paypal').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.signup_btn').prop('disabled',true);
      $('.msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
       window.location.href=site_url+"fund-withdrawal";
      } else {
        $("#paypal").show();
        $('.msg').html(resp.msg);
        $('.signup_btn').html('Paypal');
        $('.signup_btn').prop('disabled',false);
      }
    }
  });
  return false;
}
function bank_transfer(){
  $.ajax({
    type:'POST',
    url:site_url+'wallet/bank_transfer',
    data:$('#bank_transfer').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.bank_transfer').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.bank_transfer').prop('disabled',true);
      $('.msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
       window.location.href=site_url+"fund-withdrawal";
      } else {
        $("#bank_account").show();
        $('.msg2').html(resp.msg);
        $('.bank_transfer').html('Deposit');
        $('.bank_transfer').prop('disabled',false);
      }
    }
  });
  return false;
}
</script>
<?php if(isset($_GET['show_reason']) && !empty($_GET['show_reason'])){ ?>
<script>
$(document).ready(function(){
	var wd_id = '<?php echo $_GET['show_reason']; ?>';
	$('#withdraw-history-tab').trigger('click');
	$('#viewrejectreason1'+wd_id).modal('show');
});
</script>
<?php } ?>
<?php include 'include/footer.php'; ?>
	