<?php
	ini_set('display_errors', 0);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	include 'twiliosms/sendMessageTwilioApi.php';

   if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_GET['status'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id            = $_GET['user_id'];
$status            = $_GET['status'];

  $settings = getAdminDetails();
  
  $update44 = $mysqli->query("UPDATE users SET free_trial_taken='$status' WHERE id='$user_id'");

 $record=array('success'=>'true','msg'=>'Free Trail Plan Status Changed Successfully.'); 
jsonSendEncode($record);
   
   
