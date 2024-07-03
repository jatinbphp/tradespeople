<?php
// UK  =https://stripe.com/docs/connect/required-verification-information#GB-full-individual--transfers
//https://stripe.com/docs/connect/testing


// ------------- test payment key -------------- 
//$publishable_key = 'pk_test_9XOL80fSiPEAXXu4dD9rPjGk00bDcCkL0I';
//$secret_key = 'sk_test_gWf97OpjdYHpSKEa5x6aubCV00T5oAZHei';

//------------ live payment keys 
$publishable_key = 'pk_live_LYxxLKg0xDCDZE6zB0VUwgpg00aUjBXQoI';
$secret_key = 'sk_live_z9wt0Q1QS5IcW8vz1pVXA9LK00Yh9fBgG3';


//---------- US case
$description = 'Trades People Hub'; //max 22 charcaters
$statement_descriptor_suffix = 'Trades People Hub'; //max 22 charcaters
$currency  = 'gbp'; // usd//gbp
$country_stripe  = 'gb';  // us//gb
 
$website_url_stripe = 'https://www.tradespeoplehub.co.uk';
// $mcc_code = '5947';


//--------------- return urls 
$return_url='https://www.tradespeoplehub.co.uk/app_api/webservice/stripe_payment/payment_success.php';
$cancel_url='https://www.tradespeoplehub.co.uk/app_api/webservice/stripe_payment/payment_cancel.php';
?>