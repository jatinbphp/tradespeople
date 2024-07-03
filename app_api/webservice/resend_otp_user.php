<?php
    
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	include 'mailFunctions.php';
     include 'twiliosms/sendMessageTwilioApi.php';

	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	if(empty($_POST['user_id'])){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	// Get all value in variables 
	$user_id_post	=	$_POST['user_id'];
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT id,phone_no  from users where  id=? ");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	
	if($check_user <= 0){
		$record=array('success'=>'false','msg' =>$user_not_found); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$phone_no);
	$check_user_all->fetch();
	$verification_otp	=	generateRandomOTP(4);
	$updatetime			=	date('Y-m-d H:i:s');		
	//--------------------- update new otp -----------------------------	
	$update_all=$mysqli->prepare("UPDATE users set phone_code=? where id=?");
	$update_all->bind_param("ii",$verification_otp, $user_id_get);
	$update_all->execute();
	$update=$mysqli->affected_rows;
	// if($update<=0){	
	// 	$record=array('success'=>'false', 'msg'=>$msg_error_otp_send); 
	// 	jsonSendEncode($record); 
	// }


	$message =  "Your verification code is: ".$verification_otp." \r\n Tradespeoplehub.co.uk";
	$phone_number = "".$phone_no."";
	$SMSresponse = sendSMSTwilio($phone_number, $message);
	if($SMSresponse['status'] == 'false'){
	$SMSresponse['message'];
	}
	$user_details  = getUserDetails($user_id_get);
	$record	=	array('success'=>'true', 'msg'=>$msg_success_otp_send, 'otp'=>$verification_otp, 'SMSresponse'=>$SMSresponse,'user_details'=>$user_details);
	jsonSendEncode($record);
	
?> 