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

	if(empty($_FILES['profile_pic']['name'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	 
	
	 
	//---------------------------get all variables--------------------------
	$user_id_post			= $_POST['user_id_post'];
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
 	  
	if(isset($_FILES['profile_pic'])){		
		if(!empty($_FILES['profile_pic']['name'])){			
			$file			=	$_FILES['profile_pic'];
			$folder_name	=	'../../img/profile';
			$file_type		=	'file'; //if we select image then type=image otherwise file.
			$profile_image	=	uploadFile($file, $folder_name, $file_type);
			if($profile_image=="error"){
				$record=array('success'=>'false','msg' =>$p_img_add_err);
				jsonSendEncode($record);			
			}
		}
	}
	
	// -------------------------insert data------------------
    
	$img_add = $mysqli->prepare("INSERT INTO `user_portfolio`(`userid`,`port_image`) VALUES (?,?)");
	$img_add->bind_param("is",$user_id_post,$profile_image);	
	$img_add->execute();
	$img_add_affect_row=$mysqli->affected_rows;
	if($img_add_affect_row<=0){
		// $record=array('success'=>'false','msg'=>$p_skill_added_err); 
		// jsonSendEncode($record);
	}
	 
	 
	$portfolio      = getPortfolio($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>$p_img_add_suc, 'portfolio'=>$portfolio); 
	jsonSendEncode($record); 
?>
 