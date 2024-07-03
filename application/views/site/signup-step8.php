<?php 
include ("include/header1.php");

if($this->session->userdata('type')==2){
	redirect('dashboard');
}

$billing_details = $this->common_model->get_single_data("billing_details", array("user_id" => $user_data['id']));
if(isset($_GET['verify']) && $_GET['verify']==1){
	$check = true;
} else {
	$check = false;
}

$first_price = '';
$first_plan = '';

?>
<style>
html {
  scroll-behavior: smooth;
}
.contt_tab ul li {
	text-align: justify;
	white-space: nowrap;
}
</style>
<!-- how-it-work -->
<div class="start-sign" id="start-sign">
  <div class="container">
    <div class="row">
      <div class="col-sm-10 col-sm-offset-1">
        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
        <div class="white-start">
          <div class="sing-top">
            <h1> 
							<?php  if($this->uri->segment(1) == 'billing-info'){ ?>
							
								<?php  if($check){ ?>
								
								Hi <?=$user_data['f_name'];?>! Enter your card information!
								
								<?php } else { ?>
								
								Hi <?=$user_data['f_name'];?>! Select Plan!
								
								<?php } ?>
								
							
							
							<?php } else { ?>
              Hi <?=$user_data['f_name'];?>! Thanks for signing up!
							<?php } ?>
            </h1>
          </div>
					<?php if($user_data['free_trial_taken']==0 && $check==false){ ?>
          <div class="sing-body plan_body">
            <div class="mjq-sh">
              <h2><strong>Select Your Subscription Plan</strong></h2>
            </div>
            <div class="user-right-side list-tradesmen">
              <h1 style="margin-bottom: 20px;margin-top: -40px;">Membership Plans</h1> 
              <div class="container">
                <?php if($this->session->flashdata('error1')) { ?>
                <p class="alert alert-danger"><?=$this->session->flashdata('error1'); ?></p>
                <?php } if($this->session->flashdata('success123')) { ?>
                <p class="alert alert-success"><?=$this->session->flashdata('success123'); ?></p>
                <?php } ?>
                <div class="row fixed3">
                  <?php
									
									if($user_data['free_trial_taken']==0){
										$where1['is_free'] = 1;
									}
									
									$where1['status'] = 0;
									$where1['is_delete'] = 0;
									
									$get_all_packages=$this->common_model->newgetRows('tbl_package',$where1);
									
									if(count($get_all_packages) > 0) { 
						
												
									foreach ($get_all_packages as $p) {
										
										if($first_plan==''){
											$first_price = $p['amount'];
											$first_plan = $p['id'];
											$class = 'active';
										} else {
											$class = '';
										}
									
									?>
									<div class="col-sm-4">
										<div class="box_member plan_div <?php echo $class; ?>" id="plan_div<?= $p['id']; ?>">
											<div class="member_hh">
												<h5><?=$p['package_name']; ?></h5>
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
													<?php if($user_data['free_trial_taken']==0){

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
														<i class='fa fa-check-circle' style='color: #2875D7;'></i> <?= trim($p['description']); ?>
													</li>
													<?php if($p['free_bids_per_month']){ ?>
													<li>
														<i class='fa fa-check-circle' style='color: #2875D7;'></i> 
														<?php 
														echo explode(' ',$p['free_bids_per_month'])[0].' Credits'; 
														/*if($p['unlimited_limited']==0){ 
															echo explode(' ',$p['bids_per_month'])[0].' Credits'; 
														}else{ 
															echo "Unlimited".' Credits'; 
														} */ ?> 
													</li>
													<?php } ?>
													<li>
														<?php 
														if($p['email_notification']==1){ 
															echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Email Notification"; 
														} ?>
													</li>
													<li>
														<?php 
															if($p['free_sms'] > 0){ 
																echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> ".$p['free_sms']." SMS Notification"; 
															} 
														?>
													</li>
													<li>
														<?php 
														if($p['category_listing']==1){ 
															echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Category Listing"; 
														} 
														?>
													</li>
													<li>
														<?php 
														if($p['directory_listing']==1){ 
															echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Directory Listing"; 
														} 
														?>
													</li>
													<li>
														<?php 
														if($p['unlimited_trade_category']==1){ 
															echo "<i class='fa fa-check-circle' style='color: #2875D7;'></i> Unlimited trade category"; 
														} 
														?>
													</li>
													<li>
														<?php if($p['reward']==1){ ?>
															<i class='fa fa-check-circle' style='color: #2875D7;'></i> 
															<i class="fa fa-gbp"></i><?=$p['reward_amount'].' GBP reward'; 
														} ?>
													</li>
												</ul>
												<br>
												<div class="text-center">
													<button type="button" onclick="select_plan(<?= $p['id']; ?>,<?= $p['amount']; ?>);" class="btn btn-warning">Start Free Trial</button>
												</div>
											</div>
										</div>
									</div>
                  <?php } ?>
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
										
									<?php } else{ ?>
									<div class="alert alert-warning">Currently plans are not available</div>
                  <?php } ?>

                </div>
              </div>
            </div>
            <!--div class="start-btn maggg1 text-right">
              <button type="button" class="btn btn-warning btn-lg signup_btn" onclick="show_card_div();">Start Free Trial</button> 
            </div-->
						
						<br>
						
						<div class="">
             
              <p class="intro">
                1 free trial per user. Trial activated upon adding a valid payment method. Free trial will last for the number of days specified in the plan from the date of signup and will auto renew upon expiry date if not cancelled. Free trial offer cannot be used in conjunction with any other offer or promotion.
                <br><br>
								You’re offered free credits to try out our service. The credits can be found on your membership page.
                <br><br>
                Your first specified days will be free. We will take your first payment after your trial period on the <?= date('d-m-Y')?><!-- for £<span class="price_text"><?php echo $first_price; ?></span>(EX VAT)-->. You may cancel your subscription before then.
              </p>
            </div> 
          
					</div>
					<?php } ?>
					
					<div class="sing-body set-mynform card_body " id="card_body" style="display:<?= ($user_data['free_trial_taken']==1 || $check)?'block':'none';?>">
						<form method="post" id="paymentFrm" data-secret="<?= $intent->client_secret ?>">
							<input type="hidden" name="plan_id" id="plan_id" value="<?php echo $first_plan; ?>" >
              <div class="row">
								
                <div class="col-sm-12">
									<div class="payment-status"></div>
								</div>
							</div>
							<div class="row ">
                <div class="col-sm-offset-2  col-sm-6">
                  <div class="form-group">
                    <label>Name on Card </label>
                    <input type="text" name="name"  id="cardholder-name" placeholder="Enter name" required="" value="<?= ($billing_details) ? $billing_details['name'] : '';?>" class="form-control" autofocus="">
                  </div>
                </div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-2 ">
									<div id="card-element"><!--Stripe.js injects the Card Element--></div>
									
									
									<p id="latest-stripe-card-error" class="text-danger" role="alert"></p>
									
								</div>
							</div>
							<input type='hidden' name='customerID' value='<?php echo $customerID; ?>' />
							<div class="row">
								<div class="col-sm-6 col-sm-offset-2 ">
									<div class="start-btn maggg1">
										<button type="button" id="payBtn" class="btn btn-warning btn-lg signup_btn"><?=($billing_details) ? ($check) ? 'Update' : 'Save' : 'Add';?> Card</button> 
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
<script src="https://js.stripe.com/v3/"></script>

<?php if($check){
	$successUrl = site_url().'verify';
} else {
	$successUrl = site_url().'subscription-plan';
}?>
<script>
$(document).ready(function() {
  $('#cardholder-name').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
$(document).ready(function(){
var stripe = Stripe('<?php echo $this->config->item('stripe_key'); ?>');
$('#card-element').show();
var elements = stripe.elements();
var style = {
	base: {
		color: "#32325d",
		fontFamily: 'Arial, sans-serif',
		fontSmoothing: "antialiased",
		fontSize: "16px",
		"::placeholder": {
			color: "#32325d"
		}
	},
	invalid: {
		fontFamily: 'Arial, sans-serif',
		color: "#fa755a",
		iconColor: "#fa755a"
	}
};

var cardElement = elements.create("card", { style: style });
// Stripe injects an iframe into the DOM
cardElement.mount("#card-element");

cardElement.on("change", function (event) {
	// Disable the Pay button if there are no card details in the Element
	$("#payBtn").prop('disabled',false);
	
	//$("#latest-stripe-card-error").html(event.error ? event.error.message : "");
});

var cardholderName = document.getElementById('cardholder-name');
var form = document.getElementById("paymentFrm");
var payBtn = document.getElementById("payBtn");
var clientSecret = form.dataset.secret;

payBtn.addEventListener("click", function(ev) {
	event.preventDefault();

  stripe.confirmCardSetup(
    clientSecret,
    {
      payment_method: {
        card: cardElement,
        billing_details: {
          name: cardholderName.value,
        },
      },
    }
  ).then(function(result) { 
    if (result.error) {
			$("#latest-stripe-card-error").html(result.error ? result.error.message : "");
    } else {
			
			after_success(result.setupIntent.payment_method )
      // The setup has succeeded. Display a success message.
    }
  });
});
});
function after_success(payment_method){
	
	$("#paymentFrm").append('<input type="hidden" name="payment_method" value="' + payment_method + '">');
	
	$.ajax({
		type: 'POST',
		url: site_url + 'home/submit_signup9',
		data: $('#paymentFrm').serialize(),
		dataType: 'JSON',
		beforeSend:function(){
			$('#payBtn').prop('disabled',true);
			$('.payment-status').html('');
		},
		success:function(resp){
			if(resp.status == 1){
				window.location.href = '<?php echo $successUrl; ?>';
			} else {
				$('#payBtn').prop('disabled',false);
				$('.payment-status').html(resp.msg);
			}
		}
	});
	return false;
}

function show_card_div(){
	var plan_id = $('#plan_id').val();
	
	if(plan_id){
		$('.plan_body').hide();
		$('.card_body').show();
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0;
		
	} else {
		swal('Please select a plan!');
		$('.plan_body').show();
		$('.card_body').hide();
	}
}

function select_plan(id,amount){
	$('.plan_div').removeClass('active');
	$('#plan_div'+id).addClass('active');
	$('#plan_id').val(id);
	//$('.price_text').html(amount);
	show_card_div();
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
