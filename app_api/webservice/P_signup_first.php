<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	include 'twiliosms/sendMessageTwilioApi.php';
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
	 
// empty($_POST[''])
	if(empty($_POST['f_name']) || empty($_POST['l_name']) || empty($_POST['trading_name']) || empty($_POST['type']) || empty($_POST['email']) || empty($_POST['type']) || empty($_POST['phone_no']) || empty($_POST['password']))
	{
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	$otp         = '';
	$unique_id 				= date("ismy");
    $unique_id1 		    = time();
	$f_name 				= $_POST['f_name'];
	$l_name 				= $_POST['l_name'];
	$trading_name 			= $_POST['trading_name'];
	$type 					= $_POST['type'];
	$email 				    = $_POST['email'];
	$phone_no 				= $_POST['phone_no'];
	$password 				= $_POST['password'];
	$about_business 		= '';
	$is_qualification 		= '';
	$qualification 			= '';
	$county 				= $_POST['county'];
	$city 					= $_POST['city'];
	$max_distance 			= $_POST['max_distance'];
	$max_distance 			= $_POST['max_distance'];
	$postal_code 			= $_POST['postal_code'];
	$latitude 				= $_POST['latitude'];
	$longitude 				= $_POST['longitude'];
	$category 				= '';
	$insurance_liability 	= '';
	$selected_sub_cat 		= '';
	$insurance_date 		= '';
	$insurance_amount 		= '';
	$e_address 				= $_POST['e_address'];
	$notification_status 	= 1;
	$referral_code          = $_POST['referral_code'];
	$cdate 					= date('Y-m-d h:i:s');
	$user_details		    = array();	
    $device_type 			= $_POST['device_type'];
    $player_id 		        = $_POST['player_id'];
 
	
	
	// Now Check the user registration ============		
	$check_user_regis=$mysqli->prepare("SELECT id,email FROM users WHERE email=?");
    $check_user_regis->bind_param("s", $email);
    $check_user_regis->execute();
    $check_user_regis->store_result();
    $check_user_num_rows=$check_user_regis->num_rows;  //0 1
    if($check_user_num_rows > 0){
        $record=array('success'=>'false','msg'=>$msg_email_exist); 
		jsonSendEncode($record);
    }  
    $check_user_regis->bind_result($user_id_get,$user_email);
    $check_user_regis->fetch();


	$check_user_mobile=$mysqli->prepare("SELECT `id`, `email` FROM `users` WHERE phone_no=?");
    $check_user_mobile->bind_param("s", $phone_no);
    $check_user_mobile->execute();
    $check_user_mobile->store_result();
    $check_user__mobile_num_rows=$check_user_mobile->num_rows;  //0 1
    if($check_user__mobile_num_rows > 0){
       	$record=array('success'=>'false','msg'=>$msg_mobile_exist); 
		jsonSendEncode($record);
    }




$signup_step=0;

	$signup_add = $mysqli->prepare("INSERT INTO `users`(`unique_id`, `unique_id1`, `f_name`, `l_name`, `trading_name`, `type`, `email`, `phone_no`, `password`, `about_business`, `is_qualification`, `qualification`, `county`, `city`, `max_distance`, `cdate`, `postal_code`, `latitude`, `longitude`,`category`, `insurance_liability`, `insurance_date`, `insurance_amount`,  `e_address`, `notification_status`,subcategory,phone_code,signup_step,referral_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$signup_add->bind_param("sssssissssissssssssssssssssis",$unique_id,$unique_id1,$f_name,$l_name,$trading_name,$type,$email,$phone_no,$password,$about_business,$is_qualification,$qualification,$county,$city,$max_distance,$cdate,$postal_code,$latitude,$longitude,$category,$insurance_liability,$insurance_date,$insurance_amount,$e_address,$notification_status,$selected_sub_cat,$otp,$signup_step,$referral_code);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_signup); 
		jsonSendEncode($record);
	}
	$user_id_get	=	$mysqli->insert_id;
	 	


  $settings = getAdminDetails();
  if($settings['payment_method']==0) {
		$update44 = $mysqli->query("UPDATE users SET free_trial_taken=1 WHERE id='$user_id_get'");
	} else {
		$update44 = $mysqli->query("UPDATE users SET free_trial_taken=0 WHERE id='$user_id_get'");
	}



		
	if($player_id!='123456' || $device_type != 'browser'){
	// 	//----------------update user player_id for push notifications---------------------//
	 	$result 		=	 DeviceTokenStore_1_Signal($user_id_get, $device_type, $player_id);
	}



 
    $user_details	=	getUserDetails($user_id_get); 	
 
	$record	=	array('success'=>'true', 'msg'=>$Signup_success,'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>