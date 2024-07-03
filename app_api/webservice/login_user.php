<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php';
include("mailFunctions.php"); 
include 'language_message.php'; 
include 'twiliosms/sendMessageTwilioApi.php';

if(!$_POST){
	$record = array('success'=>'false', 'msg'=>$msg_post_method); 
	jsonSendEncode($record);

}

if(empty($_POST['email'])){
	$record = array('success'=>'false', 'msg'=>$msg_empty_param); 
	jsonSendEncode($record);
}



if(empty($_POST['device_type'])){
	$record = array('success'=>'false', 'msg'=>$msg_empty_param); 
	jsonSendEncode($record);
}

if(empty($_POST['player_id'])){
	$record = array('success'=>'false', 'msg'=>$msg_empty_param); 
	jsonSendEncode($record);
}

   

$login_type	=	$_POST['login_type'];

if($login_type==0){

	if(empty($_POST['password'])){

		$record=array('success'=>'false','msg' =>$msg_empty_param); 

		jsonSendEncode($record);

	}

}	

$password			=	'';

if($login_type==0){

	$login_password    =	$_POST['password'];

	$password 		   =	$login_password;

} 

// ------------------- get all value in variables start ------------------- //

$email        	= 	$_POST['email'];
$device_type  	= 	$_POST['device_type'];
$player_id    	= 	$_POST['player_id'];
$action_login 	= 	$_POST['action_type'];
$otp            =   generateRandomOTP(6);
$updatetime     =	date('Y-m-d H:i:s');

// -------------------- get all value in variables end -------------------- //


$email_arr = array();
$notification_arr  = array();

// ------------------------  check email ------------------------ //

$check_mobile_all = $mysqli->prepare("SELECT id from users where email=?");
$check_mobile_all->bind_param("s", $email);
$check_mobile_all->execute();
$check_mobile_all->store_result();
$check_mobile = $check_mobile_all->num_rows;  //0 1
if($check_mobile <= 0){
	$record = array('success'=>'false', 'msg'=>$msg_invalid_email); 
	jsonSendEncode($record);   

}
// -------------------------  check email end ------------------------- //


// ------------------ check username and password start ------------------ //

if($login_type==0){
	$check_login_all	=	$mysqli->prepare("SELECT id,type,f_name,l_name,is_phone_verified,phone_code from users where type=2 and email=? and password=?");
	$check_login_all->bind_param("ss",$email, $password);
}else{		
	$check_login_all	=	$mysqli->prepare("SELECT id,type,f_name,l_name,is_phone_verified,phone_code from users where type=2 and email=? ");		

	$check_login_all->bind_param("si",$email, $login_type);
}


$check_login_all->execute();
$check_login_all->store_result();
$check_login = $check_login_all->num_rows;
if($check_login <= 0){
    $record = array('success'=>'false', 'msg'=>$msg_invalid_email_pass); 
	jsonSendEncode($record);    
}

$check_login_all->bind_result($user_id,$type,$f_name,$l_name,$is_phone_verified,$otp);
$check_login_all->fetch();

// ------------------- check username and password end ------------------- //



if($is_phone_verified==0){ 
	
	if(empty($otp)){
		$otp	=	generateRandomOTP(4);

		//--------------------- update new otp -----------------------------	
		$update_all=$mysqli->prepare("UPDATE users set phone_code=? where id=?");
		$update_all->bind_param("ii",$otp, $user_id);
		$update_all->execute();
		$update=$mysqli->affected_rows;
		// if($update<=0){	
		// 	$record=array('success'=>'false', 'msg'=>$msg_error_otp_send); 
		// 	jsonSendEncode($record); 
		// }

	}

	$message =  "Your verification code is: ".$otp." \r\n Tradespeoplehub.co.uk";
	$phone_number = "".$phone_no."";
	$SMSresponse = sendSMSTwilio($phone_number, $message);
	if($SMSresponse['status'] == 'false'){
		$SMSresponse['message'];
	}	
}

 if($player_id!='123456' || $device_type != 'browser'){

 	$result 	=	DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);

 }

$user_details  = getUserDetails($user_id);
	$notification_arr = array();
		
		
	


$record	=	array('success'=>'true', 'msg'=>$msg_success_login, 'user_details'=>$user_details,'notification_arr'=>$notification_arr,'SMSresponse'=>$SMSresponse,'user_id'=>$user_id,'$message'=>$message);
jsonSendEncode($record);

?>