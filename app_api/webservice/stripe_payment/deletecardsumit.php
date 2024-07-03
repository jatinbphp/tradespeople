<?php
include 'stripe_config.php';
include '../con1.php';
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient($secret_key);

if(empty($_POST['user_id_post'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}
if(empty($_POST['payment_id'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}
if(empty($_POST['card_id'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}
$payment_id 	= $_POST['payment_id'];
$user_id_post 	= $_POST['user_id_post'];
$card_id        = $_POST['card_id'];



// print_r($payment_id);
// exit();
try {
$res=$stripe->paymentMethods->detach(
  $payment_id,
  []
);
}
catch (Exception $e) {
  $record=array('success'=>'false', 'msg' =>array('Card not found','Card not found','Card not found'),'data'=>$e);
  echo json_encode($record);
}

$update_user_details = $mysqli->prepare("DELETE FROM save_cards WHERE id=?");
$update_user_details->bind_param("i",$card_id);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
jsonSendEncode($record);
}

$record=array('success'=>'true', 'msg' =>array('Card deleted successfully','Card deleted successfully','Card deleted successfully'),'data'=>$res);
echo json_encode($record);
return;
