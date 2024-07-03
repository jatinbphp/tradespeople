<?php

include 'stripe_config.php';

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);


include '../con1.php';


if(empty($_POST['user_id'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}


if(empty($_POST['amount'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}

if(empty($_POST['user_token_id'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}

if(empty($_POST['description'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}


$user_id = $_POST['user_id'];
$user_token_id = trim($_POST['user_token_id']);
$amount = $_POST['amount'];
$description = $_POST['description'];

$pay_amount = $amount*100;

try {
    $transfer = \Stripe\Transfer::create([
    	"amount" 		=>	$pay_amount,
    	"currency" 		=> $currency,
    	"destination" 	=> $user_token_id,
    	"description" 	=> $description
    ]);
    
    // 			echo 'transfer====';print_r($transfer);
    //die;
    $payment_txn_id	=	$transfer->id;
    $message =	array('Success', 'Success', 'Success', 'Success'); 
    $record	=	array('status'=>true, 'msg'=>$message, 'id'=>$payment_txn_id);
    echo json_encode($record);
    return false;
}  
catch(\Stripe\Error\Card $e) {
	$message	=	array('Insufficient amount in account','Insufficient amount in account', 'Insufficient amount in account', 'Insufficient amount in account');
} 
catch (Stripe_InvalidRequestError $e) {
	// Invalid parameters were supplied to Stripe's API
	$message	=	array('Invalid parameters were supplied to Stripes API','Invalid parameters were supplied to Stripes API', 'Invalid parameters were supplied to Stripes API','Invalid parameters were supplied to Stripes API');
} 
catch (Stripe_AuthenticationError $e) {
	// Authentication with Stripe's API failed
	$message	=	'Authentication with Stripes API failed';
  
} catch (Stripe_ApiConnectionError $e) {
	// Network communication with Stripe failed
	$message	=	array('Network communication with Stripe failed', 'Network communication with Stripe failed', 'Network communication with Stripe failed','Network communication with Stripe failed');
} catch (Stripe_Error $e) {
	// Display a very generic error to the user, and maybe send
	$message	=	array('Display a very generic error to the user', 'Display a very generic error to the user','Display a very generic error to the user', 'Display a very generic error to the user');
  // yourself an email
} catch (Exception $e) {
	// Something else happened, completely unrelated to Stripe
	$message	=	array('completely unrelated to Stripe userid'.$e, 'completely unrelated to Stripe userid', 'completely unrelated to Stripe userid', 'completely unrelated to Stripe userid');
}
//echo 'catch message====';print_r($message[0]);die;

$record		=	array('status'=>false, 'msg'=>$message);
echo json_encode($record);
return false;		
?>