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
	
	
	if(empty($_POST['f_name'])){
		$record=array('success'=>'false ', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	if(empty($_POST['l_name'])){
		$record=array('success'=>'false ', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
		if(empty($_POST['postal_code'])){
		$record=array('success'=>'false ', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	


	// Email
	if(empty($_POST['phone_no'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	// if(empty($_POST['email'])){
	// 	$record=array('success'=>'false email', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }
	
	// if(empty($_POST['address'])){
	// 	$record=array('success'=>'false adr', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }

	// if(empty($_POST['latitude'])){
	// 	$record=array('success'=>'false lat', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }

	// if(empty($_POST['longitude'])){
	// 	$record=array('success'=>'false long ', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }

	// if(empty($_POST['county'])){
	// 	$record=array('success'=>'false county', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }
	// if(empty($_POST['city'])){
	// 	$record=array('success'=>'false city', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }
	if(empty($_POST['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}


	//---------------------------get all variables--------------------------
	$user_id_post			=	$_POST['user_id_post'];
  	$f_name			  	    =	$_POST['f_name'];
    $l_name			 	    =	$_POST['l_name'];
    $postal_code			=	$_POST['postal_code'];
    $phone_no				=	$_POST['phone_no']; 	
    $email					=	$_POST['email']; 	
	// $latitude				=	$_POST['latitude'];
	// $longitude				=	$_POST['longitude'];
	$address				=	$_POST['address'];//address
	$city				=	$_POST['city'];
	$county				=	$_POST['county'];
	$updatetime				=	date("Y-m-d H:i:s");
 

 	 

	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	// if($check_user <= 0){
	// 	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	// 	jsonSendEncode($record);
	// }
 	$check_user_all->bind_result($user_id_get);
 	$check_user_all->fetch();

 	//----------------------------- check account activate or not ----------------------
 	// $active_status = checkAccountActivateDeactivate($user_id_get);
 	// if($active_status == 0){
 	//     $record=array('success'=>'false','msg' =>$msg_error_activation, 'account_active_status'=>'deactivate'); 
 	//     jsonSendEncode($record); 
 	// }



$profile_image	=	'NA';   

	if(isset($_FILES['profile_img'])){		
		if(!empty($_FILES['profile_img']['name'])){			
			$file			=	$_FILES['profile_img'];
			$folder_name	=	'../../img/profile';
			$file_type		=	'file'; //if we select image then type=image otherwise file.
			$profile_image	=	uploadFile($file, $folder_name, $file_type);
			if($profile_image=="error"){
				$record=array('success'=>'false','msg' =>$msg_error_profile_image);
				jsonSendEncode($record);			
			}
		}
	}

	// -------------------------insert data------------------
	$update_user_details = $mysqli->prepare("UPDATE users SET f_name=?,l_name=?,postal_code=?,phone_no=?,e_address=?,county=?,city=?,profile=? WHERE id=?");
	$update_user_details->bind_param("ssssssssi",$f_name,$l_name,$postal_code,$phone_no,$address,$county,$city,$profile_image,$user_id_post);
	$update_user_details->execute();
	$update_affected_rows	=	$mysqli->affected_rows;
	// if($update_affected_rows<=0){
	// 	$record		=	array('success'=>'false', 'msg'=>$msg_error_profile_update); 
	// 	jsonSendEncode($record);
	// }

	 
	$user_details	=	getUserDetails($user_id_get);
	$record			=	array('success'=>'true','profil'=>$profile_image, 'msg'=>$msg_success_profile_update, 'user_details'=>$user_details); 
	jsonSendEncode($record); 

?>

 