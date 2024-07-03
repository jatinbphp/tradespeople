<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
 
$user_id	     	=	$_GET['user_id'];
$wd_arr 			=   array();


$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount);
$check_user_all->fetch();


 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT `id`, `user_id`, `customer_id`, `u_name`, `email`, `payment_method`, `status`, `created_at`, `exp_year`, `exp_month`, `country`, `last4`, `brand` FROM `save_cards` where user_id=? order by id desc");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id, $user_id, $customer_id, $u_name, $email, $payment_method, $status, $created_at, $exp_year, $exp_month, $country, $last4, $brand);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
		 $transaction_arr[] = array(
			'id'=>$id,
			'user_id'=>$user_id,
			'customer_id'=>$customer_id,
			'name'=>$u_name,
			'email'=>$email,
			'payment_method'=>$payment_method,
			'status'=>$status,
			'exp_year'=>$exp_year,
			'exp_month'=>$exp_month,
			'country'=>$country,
			'last4'=>$last4, 
			'brand'=>$brand, 
		  );
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'card_arr'=>$transaction_arr); 
jsonSendEncode($record);

