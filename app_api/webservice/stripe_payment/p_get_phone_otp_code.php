<?php
	ini_set('display_errors', 1);
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
    
    print_r($_GET);

	$user_id 	 = $_GET['user_id'];
// 	$otp         = generateRandomOTP(4);
	echo $user_id;
	exit();
	//get user id chweck==========================
    $check_user_all	=	$mysqli->prepare("SELECT `id` FROM `users` WHERE id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	} 
	
    $check_user_all->bind_result($user_id_get);
    $check_user_all->fetch(); 

	$signup_add = $mysqli->prepare("UPDATE `users` SET phone_code=? WHERE id=?");
	$signup_add->bind_param("si",$otp,$user_id);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to verify phone number please try again later","Unable to verify phone number please try again later")); 
		jsonSendEncode($record);
	}
	 
 
	$record	=	array('success'=>'true', 'msg'=>$data_found,'otp'=>$otp); 
	jsonSendEncode($record);   
?>