<?php 
 try {
  echo $_POST['stripeToken']; 
die;  
 require_once('Stripe/lib/Stripe.php');
  Stripe::setApiKey("sk_test_SW1pI9wAORL8kjKfRDOd2Hoh"); //Replace with your Secret Key

  $charge = Stripe_Charge::create(array(
  "amount" => 1500,
  "currency" => "usd",
  "card" => $_POST['stripeToken'],
  "description" => "Charge for Facebook Login code."
));
 }
?>