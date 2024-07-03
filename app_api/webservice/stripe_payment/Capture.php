<?php
include 'stripe_config.php';
include '../con1.php';
require 'vendor/autoload.php';
$select = $mysqli->prepare("SELECT stripe_payment_id,payment_id, payment_status, paymentIntent FROM stripe_payment_master WHERE user_id=132");
$select->execute();
$select->store_result();
$select_row = $select->num_rows;  //0 1
if($check_user <= 0){
	$record = array('success'=>'false', 'msg'=>array('data not found','data not found','data not found')); 
	json_encode($record);
	echo $record;
}
$select->bind_result($stripe_payment_id, $payment_id, $payment_status, $paymentIntent);
$select->fetch();

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);
$intent = \Stripe\PaymentIntent::retrieve('pi_1IGMFSFJZLdxN2fuGrenc9eb');
$result = $intent->capture(['amount_to_capture' => 700]);
print_r($result);
?>