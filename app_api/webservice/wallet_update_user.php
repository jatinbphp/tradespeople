<?php
	//ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_get_method); 
		jsonSendEncode($record); 
	}
 	
	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	// Email
	if(empty($_GET['txn_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	


	if(empty($_GET['amount'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	 

	$amount 				= $_GET['amount'];
	$user_id 				= $_GET['user_id'];
	$payment_type 			= $_GET['payment_type'];
	$updatetime	 			= date('Y-m-d h:i:s');
	$txn_id 				= $_GET['txn_id'];
 	$tr_type = 1;
	$spend_amount1 = 0;
	$wallet_amount = 0;

		//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,category,spend_amount,u_wallet,f_name,email from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$category,$spend_amount,$u_wallet,$f_name,$email);
	$check_user_all->fetch(); 	
	$wallet_amount = $amount+$u_wallet;



 
    $signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=?  WHERE id=?");
	$signup_add->bind_param("si",$wallet_amount,$user_id);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
		jsonSendEncode($record);
	}
	

	$description = '';
	if($payment_type=='stripe'){
		$description = "£". $amount." has been deposited to your wallet via card payment.";
	}
	if($payment_type=='paypal'){
		$description = "£".$amount." has been deposited to your wallet via Paypal";
	}
	if($payment_type=='bank'){
		$description = "£".$amount." has been deposited to your wallet via Bank Transfer";
	}

	$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`,tr_message) VALUES (?,?,?,?,?,?,?,?)");
	$transaction_add->bind_param("isisisss",$user_id,$amount,$tr_type,$txn_id,$tr_type,$updatetime,$updatetime,$description);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>$p_transaction_err); 
		jsonSendEncode($record);
	}
 $notification_arr = array();
		$action 		=	'Payment';
		$action_id 		=	0;
		$title 			=	'Payment success';
		$message 		=	'Payment was made successfully.';
		$sender_id 		=	$user_id;
		$receive_id 	=	$user_id;//($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $job_id='',$action_data='')
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}

if($payment_type=='paypal'){
$subjectT = 'Your TradespeopleHub account funded successfully.'; 
$contantT .= '<p style="margin:0;padding:10px 0px">Hi ' .$f_name .',</p>';
$contantT .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your Tradespeoplehub account. You can now  You can now quote jobs using those funds.</p>';

$contantT .= '<p style="margin:0;padding:10px 0px">Deposited amount: £' .$amount.'</p>';
$contantT .= '<p style="margin:0;padding:10px 0px">Deposit method: Paypal</p>';



$contantT .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contantT);
		//end email temlete================

$mailResponse  =  mailSend($email, $f_name, $subjectT, $mailBody);
}

	     

if(empty($notification_arr)){
    $notification_arr='NA';
}
	$record	=	array('success'=>'true','msg'=>$p_transaction_succ,'notification_arr'=>$notification_arr); 
	jsonSendEncode($record);   
?>