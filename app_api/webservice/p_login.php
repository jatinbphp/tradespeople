<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php';
include("mailFunctions.php"); 
include 'language_message.php'; 
// include 'authorized.php'; 


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
$updatetime     =	date('Y-m-d H:i:s');
// -------------------- get all value in variables end -------------------- //


$email_arr = array();
$notification_arr  = array();

 
// ------------------------  check email ------------------------ //
$check_mobile_all = $mysqli->prepare("SELECT id from users where email=? and type=1");
$check_mobile_all->bind_param("s", $email);
$check_mobile_all->execute();
$check_mobile_all->store_result();
$check_mobile = $check_mobile_all->num_rows;  //0 1
if($check_mobile <= 0){
	$record = array('success'=>'false', 'msg'=>$msg_invalid_email); 
	jsonSendEncode($record);    
}

// -------------------------  check email end ------------------------- //
 
$check_email	=	$mysqli->prepare("SELECT id from users where email=? and password=? and type=1");
$check_email->bind_param("ss",$email, $password);
$check_email->execute();
$check_email->store_result();
$check_email_rows = $check_email->num_rows;
if($check_email_rows<= 0){
    $record = array('success'=>'false', 'msg'=>$msg_invalid_email_pass); 
	jsonSendEncode($record);    
}
// ------------------ check username and password start ------------------ //
 
$check_login_all	=	$mysqli->prepare("SELECT id from users where email=? and password=? and type=1");
$check_login_all->bind_param("ss",$email, $password);
$check_login_all->execute();
$check_login_all->store_result();
$check_login = $check_login_all->num_rows;
if($check_login <= 0){
    $record = array('success'=>'false', 'msg'=>$msg_invalid_email_pass); 
	jsonSendEncode($record);    
}
$check_login_all->bind_result($user_id);
$check_login_all->fetch();
// ------------------- check username and password end ------------------- //



if($player_id!='123456' || $device_type != 'browser'){
 	$result 	=	DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);
}


$user_details  = getUserDetails($user_id);

	
$record	=	array('success'=>'true', 'msg'=>$msg_success_login, 'user_details'=>$user_details,'user_id'=>$user_id);
jsonSendEncode($record);


?>






