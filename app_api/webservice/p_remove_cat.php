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
 
	 
 

	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	 
	 	
	 
	$category 				= $_GET['cat_id'];
	$user_id                = $_GET['user_id']; 
	$user_details		    = array();	
 
	if($category==0){
		$category=null;
	}
	
	 //-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,category from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$category1);
	$check_user_all->fetch();


	$signup_add = $mysqli->prepare("UPDATE `users` SET `category`=? WHERE id=?");
	$signup_add->bind_param("si",$category,$user_id);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		// $record=array('success'=>'false','msg'=>$p_skill_added_err); 
		// jsonSendEncode($record);
	}
	 $user_details	=	getUserDetails($user_id); 	
	$record	=	array('success'=>'true', 'msg'=>$p_skill_added_succe,'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>