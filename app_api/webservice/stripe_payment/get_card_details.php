<?php
include 'stripe_config.php';
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient($secret_key);

if(empty($_GET['user_id_post'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data','Please send data'));
	echo json_encode($record);
	return false;
}
$user_post_id = $_GET['user_id_post'];
$response = getStripeCustomerId($user_post_id);
if($response['status']=='true'){
	
	$customer_id =   $response['customer_id'];
	
    $data=$stripe->paymentMethods->all([
        'customer' => $customer_id,
        'type' => 'card',
    ]);
    
    $output = [
    'success'=>'true','msg' =>array('Data found','Data found','Data found'),'card_arr' => $data
    ];
    echo json_encode($output);
    return;
}else{
    $record=array('success'=>'false', 'msg' =>array('Customer not cretaed on stripe','Customer not cretaed on stripe','Customer not cretaed on stripe'),'card_arr'=>"NA");
	echo json_encode($record);
	return false;
}
	    
	    
function getStripeCustomerId($user_post_id){
    include '../con1.php';
    
	$seelct_data_all =$mysqli->prepare("SELECT stripe_customer_id, customer_id from stripe_customer_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_post_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
	    $seelct_data_all->bind_result($stripe_customer_id,$customer_id);
	    $seelct_data_all->fetch();
	    
	    $record = array('status'=>'true', 'msg'=>array('Data found','Data found','Data found'), 'stripe_customer_id'=>$stripe_customer_id,'customer_id'=>$customer_id);
		return $record;
	}else{
	    $record = array('status'=>'false', 'msg'=>array('customer not available','customer not available','customer not available','card_arr'=>"NA"));
		return $record;
	}
}
?>