<?php

include '../con1.php';
    
if(empty($_GET['user_id'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

$user_id = $_GET['user_id'];
 
$check_bank_all=$mysqli->prepare("SELECT stripe_payment_id, payment_id FROM stripe_payment_master WHERE user_id=? and delete_flag ='0' order by stripe_payment_id DESC LIMIT 1");
$check_bank_all->bind_param("i",$user_id);
$check_bank_all->execute();
$check_bank_all->store_result();
$check_bank_all_num=$check_bank_all->num_rows;
if($check_bank_all_num>0){
    $check_bank_all->bind_result($stripe_payment_id,$payment_id);
    $check_bank_all->fetch();
    
    $payment_details=array('stripe_payment_id'=>$stripe_payment_id,'payment_id'=>$payment_id);
    
    $record=array('success'=>'true', 'msg' =>array('data not found'), 'payment_details'=>$payment_details);
	echo json_encode($record);
	return false;
    	
}else{
    $record=array('success'=>'false', 'msg' =>array('data not found'));
	echo json_encode($record);
	return false;
}





?>