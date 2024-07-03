<?php
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';

	// ============= For Facebook Login
	$msg_post_method 			=	array('Please used post method','Please used post method');
	$msg_social_type 			=	array('Please send social type','Please send social type');
	$msg_social_id 				=	array('Please send social id','Please send social id');
	$msg_social_email 			=	array('Please send social email','Please send social email');
	$msg_device_type 			=	array('Please send device type','Please send device type');
	$msg_player_id 				=	array('Please send player id','Please send player id');
	$msg_login 					=	array('Login successfully','Login successfully');
	$msg_account_deactivated 	=	array('Account deactived','Account deactived');

	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}

	if(empty($_POST['social_type'])){
		$record=array('success'=>'false','msg' =>$msg_social_type); 
		jsonSendEncode($record);
	}

	if(empty($_POST['social_id'])){
		$record=array('success'=>'false','msg' =>$msg_social_id); 
		jsonSendEncode($record);
	}


	if(empty($_POST['device_type'])){
		$record=array('success'=>'false','msg' =>$msg_device_type); 
		jsonSendEncode($record);
	}

	if(empty($_POST['player_id'])){
		$record=array('success'=>'false','msg' =>$msg_player_id); 
		jsonSendEncode($record);
	}

	//----------------------- get all value in variables -----------------------

	// $social_name =$_POST['social_name'];
	// $social_first_name =$_POST['social_first_name'];
	// $social_middle_name =$_POST['social_middle_name'];
	// $social_last_name =$_POST['social_last_name'];
	// $social_image =$_POST['social_image'];

	$social_type	=	$_POST['social_type'];
	$social_id 		=	$_POST['social_id'];
	$social_email 	=	$_POST['social_email'];
	$device_type 	=	$_POST['device_type'];
	$player_id 		=	$_POST['player_id'];


	//------------------------------ check user social id ---------------------------------------
	$check_social_id_all	=	$mysqli->prepare("SELECT user_id FROM user_master WHERE delete_flag=0 and user_type != '0' and (facebook_id=? or google_id=? or instagram_id=? or twitter_id=? or apple_id=?) ");
	$check_social_id_all->bind_param("sssss",$social_id, $social_id, $social_id, $social_id,$social_id);
	$check_social_id_all->execute();
	$check_social_id_all->store_result();
	$check_social_id=$check_social_id_all->num_rows;  //0 1
	if($check_social_id <= 0){		
		//-------------------------- check user email exit or not ------------------------------
		$check_email_all=$mysqli->prepare("SELECT user_id FROM user_master WHERE delete_flag=0 and user_type != 0 and email=?");
		$check_email_all->bind_param("s",$social_email);
		$check_email_all->execute();
		$check_email_all->store_result();
		$check_email=$check_email_all->num_rows;  //0 1
		if($check_email<=0){
			//------------------------------ user not exit insert user details ---------------------------
			$user_details='NA';
			$record=array('success'=>'true','msg' =>$msg_login, 'user_exist'=>'no', 'user_details'=>$user_details); 
			jsonSendEncode($record);
		}
		$check_email_all->bind_result($user_id);
		$check_email_all->fetch();
		//--------------- This function for update social details -----------
		$update_status = updateSocialDetails($user_id, $social_type, $social_id);
	}

	$check_social_id_all->bind_result($user_id);
	$check_social_id_all->fetch();

	//--------------- This function for update social details -----------
	$update_status = updateSocialDetails($user_id, $social_type, $social_id);
	
	//------------------------- user already in database update and send user data ----------------------------

	//---------- check account activate or not ----------------------
	$active_status	   =	checkAccountActivateDeactivate($user_id);
	
	if($active_status == 0){
		$record=array('success'=>'false','msg' =>$msg_account_deactivated, 'account_active_status'=>'deactivate');
		jsonSendEncode($record); 
	}

	//----- update user player_id for push notifications ---------------------
	$result =  DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);
	if($result == 'no'){
		$result =  DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);
	}

	$user_details	=	getUserDetails($user_id);
	$record			=	array('success'=>'true','msg' =>$msg_login, 'user_exist'=>'yes', 'user_details'=>$user_details); 
	jsonSendEncode($record);
	
	
	

	//--------------------- Function for update user login_type and social id ------------------
	function updateSocialDetails($user_id, $social_type, $social_id){
		include 'con1.php';
		$updatetime		=	date("Y-m-d H:i:s");
	
		if($social_type == 1){//for face book
			$update=$mysqli->prepare("UPDATE user_master SET login_type=?, facebook_id=?, updatetime=? WHERE user_id=?");
			
		}else if($social_type == 2){//for google
			$update=$mysqli->prepare("UPDATE user_master SET login_type=?, google_id=?, updatetime=? WHERE user_id=?");
			
		}else if($social_type == 3){//for twitter
			$update=$mysqli->prepare("UPDATE user_master SET login_type=?, twitter_id=?, updatetime=? WHERE user_id=?");
			
		}else if($social_type == 4){//for instagram
			$update=$mysqli->prepare("UPDATE user_master SET login_type=?, instagram_id=?, updatetime=? WHERE user_id=?");
		}else if($social_type == 5){//for apple
			$update=$mysqli->prepare("UPDATE user_master SET login_type=?, apple_id=?, updatetime=? WHERE user_id=?");
		}

		
		$update->bind_param("sssi", $social_type, $social_id, $updatetime, $user_id);
		$update->execute();
		$update_check=$mysqli->affected_rows; 
		if($update_check <= 0){
			return 'no';
		}
		return 'yes';
	}
?>