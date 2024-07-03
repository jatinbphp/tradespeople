<?php  include ("include/header1.php"); ?>
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
							<?php  if($this->uri->segment(1) == 'card-info'){ ?>
								<?php  if($check){ ?>Hi <?=$user_data['f_name'];?>! Enter your card information! <?php } ?>
							<?php }  ?>
            </h1>
          </div>

          <!--No Have free trail -->
				
					<div class="sing-body set-mynform card_body " id="card_body">
						<form method="post" id="paymentFrm" data-secret="<?= $intent->client_secret ?>">
              <div class="row">
								<input type="hidden" name="card_id" value="<?= $cards['id']; ?>">
                <div class="col-sm-12">
									<div class="payment-status"></div>
								</div>
							</div>
							<div class="row ">
                <div class="col-sm-offset-2  col-sm-6">
                  <div class="form-group">
                    <label>Name on Card</label>
                    <input type="text" name="card_u_name"  id="cardholder-name" placeholder="Enter name" required="" value="<?= ($cards) ? $cards['u_name'] : '';?>" class="form-control" autofocus="">
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
										<button type="button" id="payBtn" class="btn btn-warning btn-lg signup_btn">Update Card</button> 
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
console.log(stripe);

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
	console.log(event);
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
	// console.log(payment_method);
	$("#paymentFrm").append('<input type="hidden" name="payment_method" value="' + payment_method + '">');
	
	$.ajax({
		type: 'POST',
		url: site_url +'wallet/updateCards',
		data: $('#paymentFrm').serialize(),
		dataType: 'JSON',
		beforeSend:function(){
			$('#payBtn').prop('disabled',true);
			$('.payment-status').html('');
		},
		success:function(resp){
			if(resp.status == 1){
				window.location.href = '<?= base_url('save-card-list'); ?>';
			} else {
				$('#payBtn').prop('disabled',false);
				$('.payment-status').html(resp.msg);
			}
		}
	});
	return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
