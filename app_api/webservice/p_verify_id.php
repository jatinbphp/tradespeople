<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	 
	if(empty($_POST['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
 	if(empty($_FILES['image_url']['name'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	
	 
	//---------------------------get all variables--------------------------
	$user_id_post			= $_POST['user_id_post'];
	$id_verification_status			= $_POST['id_verification_status'];




 
 	 
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
 	$check_user_all->bind_result($user_id_get);
 	$check_user_all->fetch();
 	  
	if(isset($_FILES['image_url'])){		
		if(!empty($_FILES['image_url']['name'])){			
			$file			=	$_FILES['image_url'];
			$folder_name	=	'../../img/verify';
			$file_type		=	'file'; //if we select image then type=image otherwise file.
			$profile_image	=	uploadFile($file, $folder_name, $file_type);
			if($profile_image=="error"){
				$record=array('success'=>'false','msg' =>$p_img_add_err);
				jsonSendEncode($record);			
			}
		}
	}
	
	$u_status_add=1;
	// -------------------------insert data------------------
	if($id_verification_status==3){
    	$signup_add = $mysqli->prepare("UPDATE `users` SET u_address=?,u_status_add=?  WHERE id=?");
	}
	if($id_verification_status==4){
    	$signup_add = $mysqli->prepare("UPDATE `users` SET u_id_card=?,u_id_card_status=?  WHERE id=?");
	}
	if($id_verification_status==5){
    	$signup_add = $mysqli->prepare("UPDATE `users` SET u_insurrance_certi=?,u_status_insure=?  WHERE id=?");
	}
	$signup_add->bind_param("sii",$profile_image,$u_status_add,$user_id_post);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
// 		$record=array('success'=>'false','msg'=>$msg_error_profile_update); 
// 		jsonSendEncode($record);
	}
	 
	$user_details	=	getUserDetails($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>$data_found, 'user_details'=>$user_details); 
	jsonSendEncode($record); 
?>
 