<?php
	ini_set('display_errors', 1);	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include('language_message.php');
	
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}
	
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 	
		jsonSendEncode($record);
	}
	
	if(empty($_GET['notification_status']) && $GET['notification_status']!=0){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 	
		jsonSendEncode($record);
	}
	
	
	// Now Get Post Data
	$user_id_post 			=	$_GET['user_id_post'];
	$notification_status 	=	$_GET['notification_status'];

	 	
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT  id from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}	

	
	// ====== Define Variable
	$updatetime 	=	date('Y-m-d');
	// ==============
	$update_all	=	$mysqli->prepare("UPDATE `users` SET `notification_status`=?  WHERE `id`=? ");
	$update_all->bind_param("ii", $notification_status, $user_id_post);
	$update_all->execute();
	$update_all_aff_rows=$mysqli->affected_rows;
	if($update_all_aff_rows<=0){ 
		//$record=array('success'=>'false', 'msg' =>$msg_error_notification_update, 'notification_status'=>$notification_status);
		//jsonSendEncode($record);
	}
	
	if($notification_status==0){
		$sms_res    =   $msg_success_notification_off;
	}
	else{
		$sms_res    =   $msg_success_notification_on;
	}	
	$user_details  = getUserDetails($user_id_post);
	$record=array('success'=>'true', 'msg' =>$sms_res, 'notification_status'=>$notification_status,'user_details'=>$user_details);
	jsonSendEncode($record);

?>