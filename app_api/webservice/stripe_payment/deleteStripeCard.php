<?php
include 'stripe_config.php';
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient($secret_key);



// $stripe->customers->retrieve(
//   'cus_IquT45iSVR1J6u',
//   []
// );

// $stripe = new \Stripe\StripeClient(
//   'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
// );
$result = $stripe->customers->allSources(
  'cus_IquT45iSVR1J6u',
  ['object' => 'card', 'limit' => 3]
);
// $stripe = new \Stripe\StripeClient(
//   'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
// );
// $result =$stripe->customers->allSources(
//   'cus_IpqPqh0KKoSRlR',
//   ['object' => 'card']
// );

echo json_encode($result);

// $result = $stripe->customers->deleteSource(
//   "cus_IquT45iSVR1J6u",
//   "pm_1IFCejFJZLdxN2fuBHLlap8q",
//   []
// );


?>