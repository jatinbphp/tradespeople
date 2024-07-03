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
	// Email
	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
  	
	  
	//---------------------------get all variables--------------------------
	$user_id_post			=  $_GET['user_id'];
	$updatetime				=  date("Y-m-d H:i:s");
 	
 	 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,profile from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_ge,$profile_image);
 	$check_user_all->fetch();
 	  
	 $insurance_liability    =  'no';
	 $insurance_date         =  null;
	 $insurance_by           =  null;
	 $insurance_amount       =  null;
	// -------------------------insert data------------------
    $signup_add = $mysqli->prepare("UPDATE `users` SET  `insurance_liability`=?, `insurance_date`=?, `insured_by`=?, `insurance_amount`=? WHERE id=?");
	$signup_add->bind_param("ssssi",$insurance_liability,$insurance_date,$insurance_by,$insurance_amount,$user_id_post);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
// 		$record=array('success'=>'false','msg'=>$msg_error_profile_update); 
// 		jsonSendEncode($record);
	}
	 
	$user_details	=	getUserDetails($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>$delete_success, 'user_details'=>$user_details); 
	jsonSendEncode($record); 
?>
 