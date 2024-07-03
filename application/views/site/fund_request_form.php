<?php 
include ("include/header1.php");
?>
<style>
.form-group-us1 {
	margin-bottom: 15px;
}
</style>
<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="msg"><?= $this->session->flashdata('msg123'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						
						<?php if($data['pay_method']=='Bank Transfer'){ ?>
						<h1>Banking details</h1>
						
						<?php if($data['status']==0){ ?>
						<h4 style="padding-bottom: 20px;" class="text-center">Please enter the bank details where you want the payment to be made.</h4>
						<?php } ?>
						
						<?php } else if($data['pay_method']=='Paypal'){ ?>
						<h1> Paypal account details</h1>
						
						<?php if($data['status']==0){ ?>
						<h4 style="padding-bottom: 20px;" class="text-center">Please enter the Paypal account details where you want the payment to be made.</h4>
						<?php } ?>
						
						<?php } else { ?>
						<h1>Card details</h1>
						
						<?php if($data['status']==0){ ?>
						<h4 style="padding-bottom: 20px;" class="text-center">Please enter the card details where you want the payment to be made.</h4>
						<?php } ?>
						
						<?php } ?>
						
					</div>
					
					<div class="sing-body">
						<?php if($status==1){ ?>
						
						<?php if($data['status']==0){ ?>
						<form method="post" id="signup" enctype="multipart/form-data" >
							
							<p class="error"></p>
							
							<?php if($data['pay_method']=='Bank Transfer'){
							$last_entry = $this->common_model->GetColumnName('homeowner_fund_withdrawal', array('user_id' => $data['user_id'],'account_holder_name != '=>''),array('account_holder_name','bank_name','account_number','short_code'),false,'id','desc');
							?>
							
							<div class="form-group-us1">
								<label>Account holder name</label>
								<input type="text" class="form-control" value="<?= ($last_entry) ? $last_entry['account_holder_name'] : '';?>" name="account_holder_name" required>
							</div>
							
							<div class="form-group-us1">
								<label>Bank name</label>
								<input type="text" class="form-control" value="<?= ($last_entry) ? $last_entry['bank_name'] : '';?>" name="bank_name" required>
							</div>
							
							<div class="form-group-us1">
								<label>Account number</label>
								<input type="text" class="form-control" value="<?= ($last_entry) ? $last_entry['account_number'] : '';?>" name="account_number" required>
							</div>
							
							<div class="form-group-us1">
								<label>Sort code</label>
								<input type="text" class="form-control" value="<?= ($last_entry) ? $last_entry['short_code'] : '';?>" name="short_code" required>
							</div>
							
							<?php } else if($data['pay_method']=='Paypal'){
							$isExist = $this->common_model->GetColumnName('billing_details', array('user_id' => $data['user_id']),array('paypal_id'));
							?>
							<div class="form-group-us1">
								<label>Paypal account detail</label>
								<input type="email" class="form-control" value="<?php echo ($isExist) ?  $isExist['paypal_id'] : ''; ?>" name="paypal_id" required>
							</div>
							<?php } else {
							$isExist = $this->common_model->GetColumnName('billing_details', array('user_id' => $data['user_id']),array('name','card_number','card_exp_month','card_exp_year','card_cvc','postcode','address'));
							?>
							
                <div class="col-sm-12">
									<div class="payment-status"></div>
								</div>
                <div class="col-sm-6">
                  <div class="form-group-us1">
                    <label>Name on Card </label>
                    <input type="text" name="name" id="name" placeholder="Enter name" required="" value="<?= ($isExist) ? $isExist['name'] : '';?>" class="form-control" autofocus="">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group-us1">
                    <label>16 Digit Card Number </label>
                    <input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" value="<?=($isExist) ? $isExist['card_number'] : '';?>" class="form-control" autocomplete="off" required="">
                  </div>
                </div>
								
								<input type="hidden" class="form-control" name="card_exp_month" id="card_exp_month" value="05" autocomplete="off">
								
								<input type="hidden" class="form-control" name="card_exp_year" id="card_exp_year" value="<?= date('Y')+1;?>" autocomplete="off">

								<input type="hidden" class="form-control" name="card_cvc" id="card_cvc" value="123" autocomplete="off">
                
                <div class="col-sm-6">
                  <div class="form-group-us1">
                    <label>Billing Postcode </label>
                    <input type="text" class="form-control" name="postcode" class="form-control" value="<?=($isExist) ? $isExist['postcode'] : '';?>" placeholder="" required />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group-us1">
                    <label>Address </label>
                    <input type="text" class="form-control" name="address" class="form-control" value="<?=($isExist) ? $isExist['address'] : '';?>" placeholder=""  required />
                  </div>
                </div>
              
							<?php } ?>
							
							
							<div class="start-btn text-center">
								<button type="submit" class="btn btn-warning btn-lg signup_btn">Confirm</button>
							</div>
							<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							<input type="hidden" name="pay_method" id="pay_method" value="<?php echo $data['pay_method']; ?>">
							<input type="hidden" name="submit" value="submit">
						</form>
						<?php } else if($data['status']==1){ ?>
						<div class="alert alert-success">Your withdrawal request of amount <i class="fa fa-gbp"></i><?php echo $data['amount']; ?> already accepted</div>
						<?php } else if($data['status']==2){ ?>
						<div class="alert alert-success">Your withdrawal request has been rejected</div>
						<p><b>Reject reason:</b> <?php echo $data['reason']; ?></p>
						<?php } else if($data['status']==3){ ?>
						
							<?php if($data['pay_method']=='Bank Transfer'){ ?>
							
							<p>Your bank detail has been submitted successfully and awaits our team confirmation.</p>
							
							<?php } else if($data['pay_method']=='Paypal'){ ?>
							
							<p>Your Paypal account detail has been submitted successfully and awaits our team confirmation.</p>
							
							<?php } else { ?>
							
							<p>Your card detail has been submitted successfully and awaits our team confirmation.</p>
							
							<?php } ?>
						
						<?php } ?>
						
						
						<?php } else { ?>
						<div class="alert alert-danger"><?php echo $msg; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://js.stripe.com/v2/"></script>
<script>
// Set your publishable key
Stripe.setPublishableKey('<?php echo $this->config->item('stripe_key'); ?>');

// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        // Enable the submit button
        $('.signup_btn').removeAttr("disabled");
        // Display the errors on the form
        $(".payment-status").html('<p class="alert alert-danger">'+response.error.message+'</p>');
    } else {
        var form$ = $("#signup");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
				signup2();
				return false;
    }
}
$(document).ready(function() {
    // On form submit
    $("#signup").submit(function() {
				var pay_method = $('#pay_method').val();
				
				if(pay_method == 'Stripe'){
					// Disable the submit button to prevent repeated clicks
					$('.signup_btn').attr("disabled", "disabled");
					$(".payment-status").html('');
					// Create single-use token to charge the user
					Stripe.createToken({
							number: $('#card_number').val(),
							exp_month: $('#card_exp_month').val(),
							exp_year: $('#card_exp_year').val(),
							cvc: $('#card_cvc').val()
					}, stripeResponseHandler);
				} else {
					signup2();
				}
        // Submit from callback
        return false;
    });
});

  function signup2(){
    $.ajax({
      type:'POST',
      url:site_url+'home/submit_fund_request_form/',
      data:$('#signup').serialize(),
      dataType:'JSON',
      beforeSend:function(){
        $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $('.signup_btn').prop('disabled',true);
        $('.error').html('');
      },
      success:function(resp){
        if(resp.status==1){
          location.reload();
        } else {
					$('.error').html(resp.msg);
          $('.signup_btn').html('Confirm');
          $('.signup_btn').prop('disabled',false);
        }
      }
    });

    return false;
  }
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
