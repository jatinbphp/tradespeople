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
	// Email
	if(empty($_POST['email'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	// Validate email
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		//echo("$email is a valid email address");
	} 
	else{
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}	
	 
 
	if(empty($_POST['f_name'])|| empty($_POST['l_name']) || empty($_POST['about_business']) || empty($_POST['postal_code'])){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	
	 
	//---------------------------get all variables--------------------------
	$user_id_post			= $_POST['user_id_post'];
	$f_name 				= $_POST['f_name'];
	$l_name 				= $_POST['l_name'];
	$trading_name 			= $_POST['trading_name']; 
	$email 				    = $_POST['email'];
	$phone_no 				= $_POST['phone_no']; 
	$about_business 		= $_POST['about_business'];
	$is_qualification 		= $_POST['is_qualification'];
	$qualification 			= $_POST['qualification'];
	$county 				= $_POST['county'];
	$miles 				    = $_POST['miles'];
	$city 					= $_POST['city']; 
	$postal_code 			= $_POST['postal_code']; 
	$insurance_liability 	= $_POST['insurance_liability'];
	$insurance_date 		= $_POST['insurance_date'];
	$insurance_amount 		= $_POST['insurance_amount'];
	$insurance_by 		    = $_POST['insured_by'];
	$e_address 				= $_POST['e_address'];
	$updatetime				=	date("Y-m-d H:i:s");
    $about_business = ($about_business!='') ? '<p>'.$about_business.'</p>':'';
 
 	 
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
    $signup_add = $mysqli->prepare("UPDATE `users` SET `f_name`=?, `l_name`=?, `trading_name`=?, `email`=?, `phone_no`=?, `about_business`=?,`is_qualification`=?, `qualification`=?, `county`=?, `city`=?,`postal_code`=?, `profile`=?, `insurance_liability`=?, `insurance_date`=?, `insured_by`=?, `insurance_amount`=?, `e_address`=?,max_distance=? WHERE id=?");
	$signup_add->bind_param("ssssssisssssssssssi",$f_name,$l_name,$trading_name,$email,$phone_no,$about_business,$is_qualification,$qualification,$county,$city,$postal_code,$profile_image,$insurance_liability,$insurance_date,$insurance_by,$insurance_amount,$e_address,$miles,$user_id_post);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
// 		$record=array('success'=>'false','msg'=>$msg_error_profile_update); 
// 		jsonSendEncode($record);
	}
	 
	$user_details	=	getUserDetails($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>$msg_success_profile_update, 'user_details'=>$user_details); 
	jsonSendEncode($record); 
?>
 