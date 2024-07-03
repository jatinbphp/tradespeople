<?php
ini_set('display_errors', 1);
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php'; 
include 'mailFunctions.php';

include './stripe_payment/stripe_config.php';
require './stripe_payment/vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);




$paymentIntent = \Stripe\PaymentIntent::create([
	'type' => 'card',
  'card' => [
    'number' => '4242424242424242',
    'exp_month' => 12,
    'exp_year' => 2022,
    'cvc' => '314',
  ],
]);



print_r($paymentIntent);

     
?>