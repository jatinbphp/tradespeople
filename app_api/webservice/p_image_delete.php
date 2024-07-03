<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	 
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	if(empty($_GET['image_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	} 

	//---------------------------get all variables--------------------------
	$user_id_post			= $_GET['user_id_post'];
	$image_id			    = $_GET['image_id'];
	$updatetime				=	date("Y-m-d H:i:s");
 
 	 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_ge);
 	$check_user_all->fetch();
 	  
 	 // check image id===========================
	$check_image_id	=	$mysqli->prepare("SELECT id from users where id=?");
	$check_image_id->bind_param("i",$user_id_post);
	$check_image_id->execute();
	$check_image_id->store_result();
	$check_user1		=	$check_image_id->num_rows;  //0 1
	if($check_user1 <= 0){
		$record		=	array('success'=>'false', 'msg'=>$p_img_id_err); 
		jsonSendEncode($record);
	}
	
	// delete image===================================
    
	$delete_image = $mysqli->prepare("DELETE FROM `user_portfolio` WHERE id=?");
	$delete_image->bind_param("i",$image_id);	
	$delete_image->execute();
	$delete_image_affect_row=$mysqli->affected_rows;
	if($delete_image_affect_row<=0){
		$record=array('success'=>'false','msg'=>$delete_unsuccess); 
		jsonSendEncode($record);
	}
	 
	 
	$portfolio      =   getPortfolio($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>$delete_success, 'portfolio'=>$portfolio); 
	jsonSendEncode($record); 
?>
 