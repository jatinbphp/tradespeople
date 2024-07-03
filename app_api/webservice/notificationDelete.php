<?php
    ini_set('display_errors', 1);
    //include files
	include('con1.php');
	include('function_app.php');
	include('function_app_common.php'); 
	include('language_message.php');   
	
    //--------- check method ---------------------//
    if(!$_GET) {
    	$record=array('success'=>'false', 'msg'=>$msg_get_method); 
    	jsonSendEncode($record); 
    } 
	
    if(empty($_GET['user_id_post'])) {
		$record=array('success'=>'false', 'msg'=>$msg_empty_param); 
	    jsonSendEncode($record);
	}
	
	if(empty($_GET['delete_type'])) {
		$record=array('success'=>'false', 'msg'=>$msg_empty_param); 
	    jsonSendEncode($record);
	}
	
	if($_GET['delete_type']=="single"){
		if(empty($_GET['notification_message_id'])) {
			$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
			jsonSendEncode($record);
		}
	}
	
	$notification_message_id		=	0;	
	if($_GET['delete_type']=="single"){
		$notification_message_id	=	$_GET['notification_message_id'];
	}
	
	$user_id_post		=	$_GET['user_id_post'];
	$delete_type		=	$_GET['delete_type'];
	
	
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id from users where  users=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id, );
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();
	//----------------------------- check account activate or not ----------------------
	// $active_status 	=	checkAccountActivateDeactivate($user_id_get);
	// if($active_status == 0){
	// 	$record		=	array('success'=>'false', 'msg' =>$msg_error_activation, 'account_active_status'=>'deactivate');
	// 	jsonSendEncode($record); 
	// }
	
	// Now update read notification status			
	$notification_status	=	updateNotificationReadStatus($notification_message_id, $delete_type, $user_id_post);   
	
    if($notification_status=="yes"){
    	$record		=	array('success'=>'true', 'msg' =>$msg_success_notification_delete);
    }
	else{
		$record		=	array('success'=>'false', 'msg' =>$msg_error_notification_delete);
	}
    jsonSendEncode($record);
?>