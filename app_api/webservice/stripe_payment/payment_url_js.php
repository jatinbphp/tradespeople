<?php
include 'stripe_config.php';
?>

<script type="text/javascript">
// A reference to Stripe.js initialized with your real test publishable API key.
var publishable_key = '<?php echo $publishable_key; ?>';
var return_url = '<?php echo $return_url; ?>';
var cancel_url = '<?php echo $cancel_url; ?>';

var user_id = '<?php echo $_GET['user_id']; ?>';
var order_id = '<?php echo $_GET['order_id']; ?>';
var amount = '<?php echo $_GET['amount']; ?>';
var descriptor_suffix = '<?php echo $_GET['descriptor_suffix']; ?>';
var transfer_user_id = '<?php echo $_GET['transfer_user_id']; ?>';
var transfer_amount = '<?php echo $_GET['transfer_amount']; ?>';
var check_flag ='<?php echo $_GET['flag_check']; ?>';
var plan_id ='<?php echo $_GET['plan_id']; ?>';
var user_plan_id ='<?php echo $_GET['user_plan_id']; ?>';
var add_on_id ='<?php echo $_GET['add_on_id']; ?>';
var previous_card_id ='<?php echo $_GET['previous_card_id']; ?>';	
var one_time ='<?= isset($_GET['one_time']) ? $_GET['one_time'] : 0 ?>';
var add_on_check ='<?= isset($_GET['add_on_check']) ? $_GET['add_on_check'] : 0 ?>';

	
	

if(check_flag=='pay_as_go' || check_flag=='buy_addon' || check_flag=='user_waalet_add'){
 
	$('#payment_description').css('display','none'); 
	$('#button-text').text('Pay Now');
}else if(check_flag=='update_card'){
	$('#button-text').text('Update Card');
}else{
	$('#button-text').text('Add Card');
}


var stripe = Stripe(publishable_key);

// The items the customer wants to buy
var purchase = {
  //items: [{ id: "xl-tshirt" }],
  user_id: user_id,
  order_id: order_id,
  amount: amount,
  descriptor_suffix: descriptor_suffix,
  transfer_user_id: transfer_user_id,
  transfer_amount: transfer_amount,
  check_flag:check_flag,
  one_time:one_time,
};

// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;
fetch("payment_card_create.php", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    'Accept': 'application/json'
       
  },
  body: JSON.stringify(purchase)
  //body: purchase
})
  .then(function(result) {
   //  alert(JSON.stringify(result));
	
	//console.log('result',result);

    return result.json();
  })
  .then(function(data) {
      
      //if data is having error then show alert error 
      //add alert here and redirect user with msg
      //"Error to genereate payment intent"
      if(data.success=='false')
      {
          alert("Error to genereate payment intent");
          //redirect to error page
          var error_msg = data.msg;
          setTimeout(function() {
           // window.location.href=cancel_url+'?error='+error_msg;
            }, 1000);
          return;
      }else{
	  	if(check_flag=='update_card'){
			$('#card_u_name').val(data.name);
		}
	  }
      
      
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

    var card = elements.create("card", { style: style });
    // Stripe injects an iframe into the DOM
    card.mount("#card-element");

    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      document.querySelector("button").disabled = event.empty;
      document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
    });

    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      // Complete payment when the submit button is clicked
		
		if(one_time == 1)
		{
			payWithCardOne(stripe, card, data.clientSecret);
		}else{
			payWithCard(stripe, card, data.clientSecret);
		}
      
    });
  });

// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
var payWithCard = function(stripe, card, clientSecret) {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: {
        card: card
      }
    })
    .then(function(result) {
      if (result.error) {
        // Show error to your customer
        //redirect customer to failed page/error
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderComplete(result);
      }
    });
};
	
var payWithCardOne = function(stripe, card, clientSecret) {
  loading(true);
  stripe
    .confirmCardSetup(clientSecret, {
      payment_method: {
        card: card
      }
    })
    .then(function(result) {
      if (result.error) {
        // Show error to your customer
        //redirect customer to failed page/error
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderCompleteOne(result);
      }
    });
};

/* ------- UI helpers ------- */

// Shows a success message when the payment is complete
var orderComplete = function(result) {
    console.log('orderComplete',result);
    console.log('orderComplete id',result.paymentIntent.id);
  loading(false);
//   document
//     .querySelector(".result-message a")
//     .setAttribute(
//       "href",
//       "https://dashboard.stripe.com/test/payments/" + paymentIntentId
//     );
  document.querySelector(".result-message").classList.remove("hidden");
  document.querySelector("button").disabled = true;
  //result.paymentIntent.id
  //store whole result json to database and 
  // redirect customer to successpage
    
	var card_u_name = $('#card_u_name').val();
	
    var paymentIntent = result
    var paymentIntent = JSON.stringify(paymentIntent);
	
    var payment_id = result.paymentIntent.id;
    var payment_method = result.paymentIntent.payment_method;
    return_url = return_url+'?user_id='+user_id+'&transfer_user_id='+transfer_user_id+'&order_id='+order_id+'&payment_id='+payment_id+'&amount='+amount+'&transfer_amount='+transfer_amount+'&descriptor_suffix='+descriptor_suffix+'&paymentIntent='+paymentIntent+'&check_flag='+check_flag+'&plan_id='+plan_id+'&user_plan_id='+user_plan_id+'&add_on_id='+add_on_id+'&payment_method='+payment_method+'&one_time='+one_time+'&add_on_check='+add_on_check+'&card_u_name='+card_u_name+'&previous_card_id='+previous_card_id;
    
    setTimeout(function() {
       window.location.href=return_url;
    }, 1000);
  
  
};
	
var orderCompleteOne = function(result) {
    console.log('orderComplete',result);
    console.log('orderComplete id',result.setupIntent.id);
  loading(false);
//   document
//     .querySelector(".result-message a")
//     .setAttribute(
//       "href",
//       "https://dashboard.stripe.com/test/payments/" + paymentIntentId
//     );
  document.querySelector(".result-message").classList.remove("hidden");
  document.querySelector("button").disabled = true;
  //result.paymentIntent.id
  //store whole result json to database and 
  // redirect customer to successpage
    
	var card_u_name = $('#card_u_name').val();
	
    var paymentIntent = result
    var paymentIntent = JSON.stringify(paymentIntent);
	
    var payment_id = result.setupIntent.id;
    var payment_method = result.setupIntent.payment_method;
    return_url = return_url+'?user_id='+user_id+'&transfer_user_id='+transfer_user_id+'&order_id='+order_id+'&payment_id='+payment_id+'&amount='+amount+'&transfer_amount='+transfer_amount+'&descriptor_suffix='+descriptor_suffix+'&paymentIntent='+paymentIntent+'&check_flag='+check_flag+'&plan_id='+plan_id+'&user_plan_id='+user_plan_id+'&add_on_id='+add_on_id+'&payment_method='+payment_method+"&one_time="+one_time+'&card_u_name='+card_u_name+'&previous_card_id='+previous_card_id;
    
    setTimeout(function() {
       window.location.href=return_url;
    }, 1000);
  
  
};

// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText) {
    console.log('errorMsgText',errorMsgText);
  loading(false);
  var errorMsg = document.querySelector("#card-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(function() {
    errorMsg.textContent = "";
  }, 4000);
  
  setTimeout(function() {
        //window.location.href=cancel_url;
    }, 1000);
    
};

// Show a spinner on payment submission
var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};


</script>



