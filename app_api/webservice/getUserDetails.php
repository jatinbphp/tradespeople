<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}

	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	//---------------------------get all variables--------------------------
	$user_id		=	 $_GET['user_id'];
	$user_details = getUserDetails($user_id);
$admin_details = getAdminDetails();
	$record			=	array('success'=>'true', 'msg'=>array('data found'),'user_details'=>$user_details,'admin_details'=>$admin_details); 
	jsonSendEncode($record); 
?>
 