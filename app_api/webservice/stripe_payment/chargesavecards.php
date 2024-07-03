<?php

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey('sk_test_1Cf21TjwImZKGI8bY2aS6xbW00Es13tavF');


function calculateOrderAmount(): int {
  // Replace this constant with a calculation of the order's amount
  // Calculate the order total on the server to prevent
  // customers from directly manipulating the amount on the client
  return 1400;
}

header('Content-Type: application/json');

try {
  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);

 $payment_methods = \Stripe\PaymentMethod::all([
    'customer' => 'cus_IUtAbuzvPMjG91',//pass customer ID here
    'type' => 'card'
  ]);
  
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => 1400,//amount must be multiple of 100
    'currency' => 'usd',
     'customer' => 'cus_IUtAbuzvPMjG91',//pass customer ID
    'payment_method' => $payment_methods->data[0]->id,
    'off_session' => true,
    'confirm' => true
    
  ]);

if($paymentIntent->status=='succeeded')
{
  $output = [
    'success'=>'true','clientSecret' => $paymentIntent,'paymentIntent'=>$paymentIntent
  ];
}
else
{
      $output = [
    'success'=>'false','msg'=>'Payment failed'.$paymentIntent->status
  ];
}
  
  // "status": "succeeded", agar ye aayega matlab payment success ho gaya hai
  
  //requires_payment_method or required payment action aayega matlab user ko fir se 3d secure karna padega
  echo json_encode($output);
  
  return;


    
    
 
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['success'=>'false','error' => $e->getMessage()]);
}
