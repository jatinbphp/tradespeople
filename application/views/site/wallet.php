<?php include 'include/header.php';

$bank_Pay_info = '';
$strip_Pay_info = '';
$paypal_Pay_info = '';

$paypal_comm_per = $setting['paypal_comm_per'];
$paypal_comm_fix = $setting['paypal_comm_fix'];

$stripe_comm_per = $setting['stripe_comm_per'];
$stripe_comm_fix = $setting['stripe_comm_fix'];

$bank_processing_fee = $setting['processing_fee'];

if($this->session->userdata('type')==2){
	$strip_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Strip charges ('.$stripe_comm_per.'%+'.$stripe_comm_fix.') processing fee and processes your payment immediately ." data-original-title="" class="red-tooltip toll stripe-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$paypal_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Paypal charges ('.$paypal_comm_per.'%+'.$paypal_comm_fix.') processing fee and processes your payment immediately." data-original-title="" class="red-tooltip toll paypal-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$bank_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="We charge '.$bank_processing_fee.'% processing fee and process your payment within 1-2 working days." data-original-title="" class="red-tooltip toll bank-tooltip"><i class="fa fa-info-circle"></i></a>';
}


?>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Wallet</h1>
						<div class="edit-user-section">
							<div>
							<?php if($this->session->userdata('succ123')){
								echo $this->session->userdata('succ123');
								$this->session->unset_userdata('succ123');
							} ?>
							</div>
							<?php echo $this->session->flashdata('succ');  ?>
							<?php echo $this->session->flashdata('errorss');  ?>
							<div class="msg"><?= $this->session->flashdata('msg');?></div>
							<ul class="nav nav-tabs">
								<?php if($this->session->userdata('type')==2){ ?>
									<li class="active"><a data-toggle="tab" href="#home">Wallet</a></li>
									<li><a data-toggle="tab" id="bank-menu-tab" href="#menu1">Bank Transfer</a></li>
									<?php if(count($bank_transfer_history) > 0){ ?>
									<li><a data-toggle="tab" href="#menu2">Bank Transfer History</a></li>
									<?php } ?>
								
								<?php } else { ?>
									<li class="active"><a data-toggle="tab" href="#home">Pay as you go</a></li>
								<?php } ?>
							</ul>
<div class="tab-content">
	<div id="home" class="tab-pane fade in active">
		<h3>Balance</h3>
		<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-5">
			<div class="loop_itm">
				<div class="profile_detaillls">
					<div class="row">
						<div class="col-sm-12">
							
							<div class="msg" id="msg">
							<?= $this->session->flashdata('msg'); ?>
							</div>
							<div class="row">
								<div class="col-sm-12  text-center">
									<div class="Wallet_1 well wel-main">
										<h3 class="text"> <i class="fa fa-money" ></i> Balance <span><i class="fa fa-gbp"></i><?php echo $user_profile['u_wallet']; ?></span> </h3>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 text-center">
									<div class="form-group text-left">
										<label>Please enter amount in 
											<i class="fa fa-gbp"></i> 
											<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Deposit amount must be more than £<?= $setting['p_min_d']; ?> and less than £<?= $setting['p_max_d']; ?>!" data-original-title="" class="red-tooltip toll"><i class="fa fa-info-circle"></i></a>
										</label>
										<input type="text" name="amount" id="amount" class="form-control quantity" value="" onkeyup="check_value(this.value)" onblur="check_value(this.value)" required>
									</div>
									<p class="instant-err alert alert-danger" style="display:none;"></p>
							
									<div class="card pay_btns all-pay-tooltip" style="display:none; text-align: center;">
										<div class="row">
											<div class="set-twolsbtn">
												<div class="col-sm-5 col-xs-12ol">
													<div class="bonnnttlllo1">
														<div class="pay_btn strip_btn pull-left" id="strip_btn"><img style="width: 100%;height: 40px;" src="<?= base_url(); ?>img/pay_with.png"></div> <?= $strip_Pay_info; ?>
													</div>
													
												</div>
												<div class="col-sm-7 col-xs-12"  style="padding: 0;">
													<div class="bonnnttlllo2">
														<div class="pay_btn paypal_btn" id="paypal_btn"></div> <?= $paypal_Pay_info; ?>
													<input type="hidden" id="payProcess" value="0">
													</div>
													
												</div>
											</div>
										</div>
										<?php if($this->session->userdata('type')==2){ ?>
										<div class="row">
											<div class="col-sm-12">
												<div class="pt-btn15">
													<div class="bonnnttlllo3">
													<button onclick="show_bannk_transfer_tab()" class="pay_btn btn btn-primary" type="button" style="width: 100%;">Bank Transfer</button> <?= $bank_Pay_info; ?></div>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
									<div class="pay_btns_laoder text-center" style="display:none;"> 
										<i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="loop_itm">
				<div class="profile_detaillls">
					<div class="row">
						<div class="col-sm-12">
							<div class="msg" id="msg"><?= $this->session->flashdata('msg'); ?></div>
							<div class="row">
								<div class="col-sm-12 text-center">
									<div class="Wallet_1 well wel-main">
										<h3 class="text"> <i class="fa fa-money" ></i> Spent Amount
										<br><span><i class="fa fa-gbp"></i><?php echo $amountSpend; ?></span>
										</h3>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<!-- <div class="col-sm-6"></div> -->
								<div class="col-sm-12 text-center">
									<div class="form-group text-left">
										<a href="<?php echo base_url('spendamount-history'); ?>"><button class="btn btn-primary" style="width: 100%;">View History</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<?php if($this->session->userdata('type')==1){?>
		<p class="wallet-info" style="font-size: 15px;">Here is your current pay  as you go account. You need to have at least £2 on your balance to be able to discuss job spec, provide quotes, chat and  reply messages. </p>
		
		<?php } ?>
	</div>

	<?php 
		$username_arr = explode('@',$user_profile['email']);
		//print_r($username_arr);
		$username = $username_arr[0];
							
		$lastRefId = $this->common_model->get_all_data('bank_transfer',null,'id','desc',1);
		
		if($lastRefId){
			$lastRefId = $lastRefId[0]['id']+1;
		} else {
			$lastRefId = 1;
		}
							
		$Trxn = sprintf("%06d", $lastRefId);
							
							
	?>

	<div id="menu1" class="tab-pane fade">
		<!-- <h3>Bank Transfer</h3> -->
		<form id="BankTransfer" onsubmit="return BankTransfer();">
			<div class="brmsg"><?php echo $this->session->flashdata('msg1'); ?></div>

			<div class="form-group">
				<div class="form-group bank_bg">
					<h4>Our bank information</h4>
				</div>
				<div class="form-group bank_bg">
					<p>Account Name: <?= $setting['acc_name']; ?></p>
				  <p>Bank Name: <?= $setting['bank_name']; ?></p>
			   	<p>Sort Code: <?= $setting['sort_code']; ?> </p>
				  <p>Account Number: <?= $setting['acc_number']; ?></p>
		  		<h4>Reference ID: <?php echo $Trxn; ?></h4>
				</div>
				
			
				<div class="bank_bg">
					<h2>What to do next</h2>
				<p>
				Log in to your bank account and follow the bank's instructions to make a transfer. Copy our above banking information into the bank's forms. Please make sure to add your reference ID into your bank's payment description. 
</p>
<p>When you're done with the bank transfer come back here, fill in below detail and click submit.We will credit your Tradespeoplehub`s wallet  once we have received your payment. </p>
				<!-- <p>Enter you deposit details so we can identify your payment and finish the deposit faster. Please take a receipt or reference number from your bank after deposit amount</p> -->
				</div>
			</div>
			
			<?php 
				$hide = isset($_GET['bank-transfer']) && $_GET['bank-transfer'] == 1 ? 'none' : 'block';
			?>
			<div id="formDiv" style="display:<?php echo $hide; ?>">
				<div class="form-group bank_bg">
						<div class="form-group">
							<label>Amount:</label>
							<input type="number" class="form-control" name="bank_amount" id="bank_amount" value="<?php echo (isset($_GET['amount']) && $_GET['amount'] >= $setting['p_min_d']) ?$_GET['amount'] : $setting['p_min_d']; ?>" step="any" onkeyup="countCommision(this.value)">
						</div>
						<div class="form-group">
							<label>Full name:</label>
							<input type="text" name="bank_account_name" placeholder="Bank account name you are depositing from" required class="form-control" value="<?=$user_profile['f_name'] ." " .$user_profile['l_name']; ?>"> 
						</div>
						<div class="form-group">
							<label>Date of deposit:</label>
							<input type="date" name="date_of_deposit" placeholder="Date of deposit" required class="form-control"> 
						</div>
						<div class="form-group">
							<label>Diposit reference(reciept or reference number):</label>
							<input type="text" readonly name="reference" placeholder="Diposit reference" required value="<?php echo $username.'-'.$Trxn; ?>" class="form-control"> 
						</div>
				</div>		
				<div class="form-group bank_bg">
					<p>Note: Any transaction fees charged by your bank will be deducted from the total transfer amount. Funds will be credited to your balance on the next bussiness day after the funds are received by bank. If you have any questions please <a href="<?php echo site_url().'contact' ?>">contact us</a></p>
				</div>
			
				<div class="form-group text-center">
					<!-- <button class="btn btn-primary btn_prop">Submit</button> -->
					<button class="btn btn-warning btn_prop" id="bankBtn">Submit</button>
					<br><span id="adminCommision" style="font-size:11px; font-style: italic;"></span>
				</div>	
			</div>		
		</form>
		
	</div>
	<div id="menu2" class="tab-pane fade">
		<h3>Bank Transfer History</h3>
		<div class="table-responsive">
			<table class="table table_nw DataTable">
				<thead>
					<tr class="th_class">
						<th style="display: none;"></th>
						<th>Id</th>
						<th>Amount</th>
						<th>Comission</th>
						<th>Bank account name</th>
						<th>Date of deposit</th>
						<th>Reference Number</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($bank_transfer_history as $key => $row){ ?>
					<tr class="tr_class">
						<td style="display:none;"><?php echo $key+1; ?></td>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo ($row['amount'] > 0)?$row['amount']:'-'; ?></td>
						<td><?php echo  $row['admin_amt']; ?></td>						
						<td><?php echo $row['bank_account_name']; ?></td>
						<td><?php echo date('d-m-Y',strtotime($row['date_of_deposit'])); ?></td>
						<td><?php echo $row['reference']; ?></td>
						<td>
							<?php if($row['status']==1) { ?>
							<span class="label label-success">Accepted</span>
							<?php } else if($row['status']==2) { ?>
							<span class="label label-danger">Rejected</span> 
							<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#bank_reject<?php echo $row['id']; ?>">View Reason</button>
							<!-- Modal -->
							<div id="bank_reject<?php echo $row['id']; ?>" class="modal fade" role="dialog">
								 <div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
											 <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Reject Reason</h4>
											 </div>
											 <div class="modal-body">
													<p style="color:#000"><?php echo $row['reject_reason']; ?></p>
											 </div>
											 <div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											 </div>
										</div>
								 </div>
							</div>
							<?php } else { ?>
							<span class="label label-warning">Pending</span>
							<?php } ?>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>

						</div>
						
                  <!-- Edit-section-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade popup" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rejectionModal">Rejection Reason</h4>
      </div>
      <div class="modal-body">
        <p style="color:#000"><?=$this->session->flashdata('reject_reason');?></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php include 'include/footer.php'; ?>
<?php
if(isset($_REQUEST['bank-transfer']) && !empty($_REQUEST['bank-transfer'])){ ?>
<script>
  $(document).ready(function(){
    $('#bank-menu-tab').trigger('click'); 
    //$('.nav-tabs a[href=\"#menu1\"]').tab('show');
  });
</script>
<?php } ?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  <?php
    if($this->session->flashdata('reject_reason')){
  ?>
      $("#rejectModal").modal('show');
  <?php
    }
  ?>

  var amounts = $('#amount').val();
  var mainAmt = 0;
  function show_bannk_transfer_tab(){
    var bank_amount = $('#amount').val();
    var commision = parseFloat(<?php echo $bank_processing_fee; ?>);
	  var newAmt = (bank_amount * commision) / 100;
	  var mainAmt = parseFloat(bank_amount) + parseFloat(newAmt);
	  
    $('#bank_amount').val(bank_amount);
    $('#bankBtn').html('Confirm & Transfer <i class="fa fa-gbp"></i>'+ mainAmt.toFixed(2));
    $('#adminCommision').html('<i class="fa fa-gbp"></i>'+newAmt.toFixed(2)+' bank transfer fee included');
    $('.nav-tabs a[href="#menu1"]').tab('show');
    $('#formDiv').show();
  }

  function countCommision(amt) {
  	var commision = parseFloat(<?php echo $bank_processing_fee; ?>);
	  var newAmt = (amt * commision) / 100;
	  var mainAmt = parseFloat(amt) + parseFloat(newAmt);
	  $('#bankBtn').html('Confirm & Transfer <i class="fa fa-gbp"></i>'+ mainAmt.toFixed(2));
    $('#adminCommision').html('<i class="fa fa-gbp"></i>'+newAmt.toFixed(2)+' bank transfer fee included');
  }

   function BankTransfer(){
   	$.ajax({
   		type:'POST',
   		url:site_url+'wallet/BankTransfer',
   		data:$('#BankTransfer').serialize(),
   		dataType:'JSON',
   		beforeSend:function(){
   			$('.btn_prop').prop('disabled',true);
   			$('.btn_prop').html('Processing....');
   		},
   		success:function(res){
   			if(res.status==1){
   				window.location.href = site_url+"wallet/?bank-transfer=1";
   			} else {   				
   				$('.btn_prop').prop('disabled',false);
   				$('.btn_prop').html('Submit');
   				$('.brmsg').html(res.msg)
   				$('#county_id').focus();
   			}
   		}
   	});
   	return false;
   }
   function check_value(value){
     var min = <?= $setting['p_min_d']; ?>;
     var max = <?= $setting['p_max_d']; ?>;
     if(value >= min && value <= max){
		 //$('.show_btn').prop('disabled',false);
		 $('.instant-err').hide();
		 $('.instant-err').html('');
			 
		var stripe_comm_per = <?= $stripe_comm_per; ?>;
		var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
		var type = <?= $this->session->userdata('type'); ?>;
		var processing_fee = 0;
		var actual_amt = parseFloat(value);
		
		if(type == 2){
			if(stripe_comm_per > 0 || stripe_comm_fix == 0){
				processing_fee = (1 * actual_amt * stripe_comm_per)/100;
				amounts = actual_amt + processing_fee + stripe_comm_fix;
			} else {
				amounts = actual_amt;
			}
		} else {
			amounts = actual_amt;
		}
		
		var amounts = amounts.toFixed(2);
			 
		$('#strip_btn').attr('onclick','show_lates_stripe_popup('+amounts+','+actual_amt+',1);');
		show_main_btn();
		//amounts = value;
     } else {
       $('.card').hide();
       //$('.show_btn').prop('disabled',true);
       $('.instant-err').show();
       $('.instant-err').html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+min+' and less than <i class="fa fa-gbp"></i>'+max+'!');
       $('.pay_btns').hide();
     }
   }
   function show_main_btn(){
       $('.pay_btns').show();
       $('.paypal_btn').html('');
			 
			var type = <?= $this->session->userdata('type'); ?>;
			var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
			var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
			var processing_fee = 0;
			var actual_amt = parseFloat($('#amount').val());
			
			if(type == 2){
				if(paypal_comm_per > 0 || paypal_comm_fix > 0){
					processing_fee = ((actual_amt * paypal_comm_per)/100);
					var amounts = processing_fee+actual_amt+paypal_comm_fix;
					 
				} else {
					var amounts = actual_amt;
				}
			} else {
				var amounts = actual_amt;
			}
			
			var amounts = amounts.toFixed(2);
			 
       paypal.Button.render({
         env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
         client: {
           sandbox:    '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
           production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
         },
   
         // Show the buyer a 'Pay Now' button in the checkout flow
         commit: true,
   
         // payment() is called when the button is clicked
         payment: function(data, actions) {
   				
   				// Make a call to the REST api to create the payment
           return actions.payment.create({
             payment: {
               transactions: [
                 {
                   amount: { total: amounts, currency: 'GBP' }
                 }
               ]
             }
           });
         },
   
         // onAuthorize() is called when the buyer approves the payment
         onAuthorize: function(data, actions) {  
           // Make a call to the REST api to execute the payment
           return actions.payment.execute().then(function() {
             console.log('Payment Complete!');
             $.ajax({
               type:'POST',
               url:site_url+'wallet/paypal_deposite',
               data:{
                 itemPrice : $('#amount').val(),
                 itemId : 'Deposit in wallet',
                 orderID : data.orderID,
                 txnID : data.paymentID,
               },
               dataType:'JSON',
               beforeSend:function(){
                 $('.pay_btns').hide();
                 $('.pay_btns_laoder').show();
               },
               success:function(resp){ 
                 if(resp.status == 1) {
                   location.reload();
                   //window.location.href=site_url+'Users/success/5/'+resp.tranId;
                 } else {
                   $('.pay_btns').show();
                   $('.pay_btns_laoder').hide();
                   swal(resp.msg);
                 }
               }
             });
           });
         }
       }, '#paypal_btn');
   
   }
</script>
