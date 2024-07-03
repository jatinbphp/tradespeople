<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
 
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_get_method); 
		jsonSendEncode($record); 
	}
 
	 
	if(empty($_GET['email'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
  

	$email 				    = $_GET['email'];
	$phone_no				= $_GET['phone_no'];
	$cdate 					= date('Y-m-d h:i:s');
	$user_details		    = array();	
 
	
	$exit=false;
	$phone_exit=false;
$msg=array('','');
	// Now Check the user registration ============		
	$check_user_regis=$mysqli->prepare("SELECT `id`, `email` FROM `users` WHERE is_phone_verified=1 and email=?");
    $check_user_regis->bind_param("s", $email);
    $check_user_regis->execute();
    $check_user_regis->store_result();
    $check_user_num_rows=$check_user_regis->num_rows;  //0 1
    if($check_user_num_rows > 0){
       	$exit=true;
		$msg = $msg_email_exist;
    }  

	// Now Check the user registration ============		
	$check_user_mobile=$mysqli->prepare("SELECT `id`, `email` FROM `users` WHERE is_phone_verified=1 and  phone_no=?");
	$check_user_mobile->bind_param("s", $phone_no);
	$check_user_mobile->execute();
	$check_user_mobile->store_result();
	$check_user__mobile_num_rows=$check_user_mobile->num_rows;  //0 1
	if($check_user__mobile_num_rows > 0){
		$phone_exit=true;
		$msg = $msg_mobile_exist;
	}

    $record=array('success'=>'true','msg'=>$msg,'exit'=>$exit,'phone_exit'=>$phone_exit); 
	jsonSendEncode($record);


?>