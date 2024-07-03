<?php
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php';  
	include 'language_message.php';
	
	if(!$_POST){
		$record		=	array('success'=>'false', 'msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}
	// get user_id
	if(empty($_POST['user_id'])){
		$record		=	array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	if(empty($_POST['password_old'])){
		$record		=	array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	if(empty($_POST['password'])){
		$record		=	array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	//-------------------------------- get all value in variables -----------------------
	$user_id_post	=	$_POST['user_id'];
	$password_old 	=	$_POST['password_old'];
	$password_new	=	$_POST['password'];

	
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT id from users where  id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();

	//----------------------------- check account activate or not ----------------------
	// $active_status = checkAccountActivateDeactivate($user_id_get);
	// if($active_status == 0){
	// 	$record=array('success'=>'false','msg' =>$msg_error_activation, 'account_active_status'=>'deactivate'); 
	// 	jsonSendEncode($record); 
	// }
	
	// ==============	
	$check_password_all=$mysqli->prepare("SELECT id from users where id=? and password=?");
	$check_password_all->bind_param("is",$user_id_get, $password_old);
	$check_password_all->execute();
	$check_password_all->store_result();
	$check_password=$check_password_all->num_rows;  //0 1	
	if($check_password <= 0){
		$record=array('success'=>'false', 'msg' =>$msg_error_password_old_wrong); 
		jsonSendEncode($record);
	}

	// Now check old and new password is not same
	if($password_old==$password_new){
		$record=array('success'=>'false', 'msg' =>$msg_error_password_new); 
		jsonSendEncode($record);
	}


	//--------------------- update otp -----------------------------
	$updatetime	=	date('Y-m-d H:i:s');
	$update_all	=	$mysqli->prepare("UPDATE users set password=? where id=?");
	$update_all->bind_param("si",$password_new, $user_id_get);
	$update_all->execute();
	$update		=	$mysqli->affected_rows;	
	if($update<=0){	
		$record	=	array('success'=>'false', 'msg' =>$msg_error_password_update); 
		jsonSendEncode($record); 
	}
	
	$user_details	=	array();

	//-------------------------------- get user complete details --------------------------
	//$user_details	=	getUserDetails($user_id_get);
	$record			=	array('success'=>'true', 'msg' =>$msg_success_password_update);
	jsonSendEncode($record);
?>