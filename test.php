<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<style>
		/* Variables */
		* {
			box-sizing: border-box;
		}
		body {
			font-family: -apple-system, BlinkMacSystemFont, sans-serif;
			font-size: 16px;
			-webkit-font-smoothing: antialiased;
			display: flex;
			justify-content: center;
			align-content: center;
			height: 100vh;
			width: 100vw;
		}
		form {
			width: 30vw;
			min-width: 500px;
			align-self: center;
			box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
				0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
			border-radius: 7px;
			padding: 40px;
		}
		input {
			border-radius: 6px;
			margin-bottom: 6px;
			padding: 12px;
			border: 1px solid rgba(50, 50, 93, 0.1);
			height: 44px;
			font-size: 16px;
			width: 100%;
			background: white;
		}
		.result-message {
			line-height: 22px;
			font-size: 16px;
		}
		.result-message a {
			color: rgb(89, 111, 214);
			font-weight: 600;
			text-decoration: none;
		}
		.hidden {
			display: none;
		}
		#card-error {
			color: rgb(105, 115, 134);
			text-align: left;
			font-size: 13px;
			line-height: 17px;
			margin-top: 12px;
		}
		#card-element {
			border-radius: 4px 4px 0 0 ;
			padding: 12px;
			border: 1px solid rgba(50, 50, 93, 0.1);
			height: 44px;
			width: 100%;
			background: white;
		}
		#payment-request-button {
			margin-bottom: 32px;
		}
		/* Buttons and links */
		button {
			background: #5469d4;
			color: #ffffff;
			font-family: Arial, sans-serif;
			border-radius: 0 0 4px 4px;
			border: 0;
			padding: 12px 16px;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			display: block;
			transition: all 0.2s ease;
			box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
			width: 100%;
		}
		button:hover {
			filter: contrast(115%);
		}
		button:disabled {
			opacity: 0.5;
			cursor: default;
		}
		/* spinner/processing state, errors */
		.spinner,
		.spinner:before,
		.spinner:after {
			border-radius: 50%;
		}
		.spinner {
			color: #ffffff;
			font-size: 22px;
			text-indent: -99999px;
			margin: 0px auto;
			position: relative;
			width: 20px;
			height: 20px;
			box-shadow: inset 0 0 0 2px;
			-webkit-transform: translateZ(0);
			-ms-transform: translateZ(0);
			transform: translateZ(0);
		}
		.spinner:before,
		.spinner:after {
			position: absolute;
			content: "";
		}
		.spinner:before {
			width: 10.4px;
			height: 20.4px;
			background: #5469d4;
			border-radius: 20.4px 0 0 20.4px;
			top: -0.2px;
			left: -0.2px;
			-webkit-transform-origin: 10.4px 10.2px;
			transform-origin: 10.4px 10.2px;
			-webkit-animation: loading 2s infinite ease 1.5s;
			animation: loading 2s infinite ease 1.5s;
		}
		.spinner:after {
			width: 10.4px;
			height: 10.2px;
			background: #5469d4;
			border-radius: 0 10.2px 10.2px 0;
			top: -0.1px;
			left: 10.2px;
			-webkit-transform-origin: 0px 10.2px;
			transform-origin: 0px 10.2px;
			-webkit-animation: loading 2s infinite ease;
			animation: loading 2s infinite ease;
		}
		@-webkit-keyframes loading {
			0% {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
		@keyframes loading {
			0% {
				-webkit-transform: rotate(0deg);
				transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
				transform: rotate(360deg);
			}
		}
		@media only screen and (max-width: 600px) {
			form {
				width: 80vw;
			}
		}
	</style>
</head>
<body>
<?php
  # vendor using composer
  require_once('application/libraries/stripe-php-7.49.0/init.php');

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_BA5v4UfqqAC5aPhdh675ijTd');

$customer = \Stripe\Customer::create();

$intent = \Stripe\SetupIntent::create([
  'customer' => $customer->id
]);
?>
<div class="container">
  <h1>Check stripe is live now</h1>
  <p>This is the page created only for stripe live test</p>
	<div class="row">
		<input id="cardholder-name" type="text">
<!-- placeholder for Elements -->
<form id="setup-form" data-secret="<?= $intent->client_secret ?>">
  <div id="card-element"></div>
  <button type="button" id="card-button">
    Save Card
  </button>
</form>

	</div>
</div>
<script>
var stripe = Stripe('pk_test_393IAsXCfg8dt9UkOGz13zNy');

var elements = stripe.elements();
var cardElement = elements.create('card');
cardElement.mount('#card-element');

var cardholderName = document.getElementById('cardholder-name');
var cardButton = document.getElementById('card-button');
var clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', function(ev) {

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
			console.log(result);
			return false;
      // Display error.message in your UI.
    } else {
			console.log(result);
			return false;
      // The setup has succeeded. Display a success message.
    }
  });
	return false;
	return false;
});
</script>
</body>
</html>