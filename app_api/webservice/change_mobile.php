<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	include 'mailFunctions.php';
	include 'twiliosms/sendMessageTwilioApi.php';
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}

	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	if(empty($_GET['mobile'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	 
	//-------------------------------- get all value in variables -----------------------
	$user_id_post 	=	$_GET['user_id'];
	$mobile 		=	$_GET['mobile'];
	    


	$check_user_mobile=$mysqli->prepare("SELECT `id`, `email` FROM `users` WHERE phone_no=? and id!=?");
	$check_user_mobile->bind_param("si", $mobile,$user_id_post);
	$check_user_mobile->execute();
	$check_user_mobile->store_result();
	$check_user__mobile_num_rows=$check_user_mobile->num_rows;  //0 1
	if($check_user__mobile_num_rows > 0){
		 $record=array('success'=>'false','msg' =>array("Mobile number already registered with us")); 
		jsonSendEncode($record);
	}
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i", $user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false','msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();
	
 
	//----------------Update Account Details
	
 

	$update_all=$mysqli->prepare("UPDATE users set phone_no=? WHERE id=? ");
	$update_all->bind_param("si", $mobile, $user_id_post);
	$update_all->execute();
	$update=$mysqli->affected_rows;
	if($update<=0){	
		$record=array('success'=>'false','msg' =>array('Mobile number not updated')); 
		jsonSendEncode($record); 
	}
	 

	$message =  "Your verification code is: ".$otp." \r\n Tradespeoplehub.co.uk";
	$phone_number = "".$mobile."";
	$SMSresponse = sendSMSTwilio($phone_number, $message);
	if($SMSresponse['status'] == 'false'){ 
		$SMSresponse['message'];
	}
 

	  
	$user_details	=	getUserDetails($user_id_post);
	$record=array('success'=>'true','msg' =>array("Data found"), 'user_details'=>$user_details); 
	jsonSendEncode($record);

?>