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
	
	
	//user name
	if(empty($_POST['f_name'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	if(empty($_POST['l_name'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
		if(empty($_POST['postal_code'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	


	// Email
	if(empty($_POST['phone_no'])){
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


	// Sign Type
	if(empty($_POST['login_type']) && $_POST['login_type']!=0){//app,fb,google,twiter......
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	// Device Type
	if(empty($_POST['device_type'])){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	// Player ID
	if(empty($_POST['player_id'])){
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	$user_password			=	'NA';
	if($_POST['login_type']==0){
		if(empty($_POST['password'])){
			$record=array('success'=>'false','msg' =>$msg_param_send_all); 
			jsonSendEncode($record); 
		}
		$password			=	$_POST['password'];
		$user_password		=	$password;
	}	

	// Get All Post Parameter
    $f_name			  	    =	$_POST['f_name'];
    $l_name			 	    =	$_POST['l_name'];
    $postal_code			=	$_POST['postal_code'];
    $phone_no				=	$_POST['phone_no']; 	
    // $state				    =	0; 	
    $email					=	$_POST['email']; 	
    $login_type				=	$_POST['login_type'];
    $device_type			=	$_POST['device_type'];
    $player_id				=	$_POST['player_id'];
    $latitude			    =	$_POST['latitude'];
    $longitude			    =	$_POST['longitude'];
     $city			   	    =	$_POST['city'];
    $address		   	    =	$_POST['address'];
	$verification_otp		=	generateRandomOTP(4);
	$unique_id				=	generateRandomOTP(6);
    $email_otp              = generateRandomOTP(4);
    $createtime				=	date("Y-m-d H:i:s");
    $updatetime				=	date("Y-m-d H:i:s");
    $boost_profile_date	    =   date('Y-m-d H:i:s', strtotime('+1000 years'));
	$type				=	2; // for user
	$login_type_first		=	$login_type; // for App
	$facebook_id			=	'NA';
	$google_id				=	'NA';
	$twitter_id				=	'NA';
	$apple_id				=	'NA';
	$profile_complete		=	0;
	$signup_step			=	0;
	$language_id			=	0;
	$notification_status	=	1;
	$active_flag			=	1;
	$approved_unapproved	=	1;
	$delete_flag			=	0;
	$otp_verify				=	0;
    $reffer_code   = $_POST['referral_code'];
	$is_phone_verified=0;

	

	if($login_type==1){
		if(!empty($_POST['social_id'])){
			$facebook_id	=	$_POST['social_id'];
			$signup_step 	=  1;
			$profile_complete = 1;
			$otp_verify 	= 1;
		}
	}
	
	if($login_type==2){
		if(!empty($_POST['social_id'])){
			$google_id		=	$_POST['social_id'];
			$signup_step 	=   1;
			$signup_step 	=   1;
			$profile_complete = 1;
			$otp_verify 	=   1;
		}
	}	
	
	$user_id_post = 0;

	if(isset($_POST['user_id_post'])){
		$user_id_post = $_POST['user_id_post'];
		$user_id_get =$user_id_post;
	}


	$user_details		=	array();	
	$notification_arr 	=	array();
	$mail_arr			=	array();
	$email_arr			=	array();
	
	// ========= Profile Picture	
	$profile_image	=	'NA';   

//=======check for unique mobile=====================

	
//=====check for mobile end============================
 
	
	// Now Check the user registration ============		
	$check_user_regis=$mysqli->prepare("SELECT id,email,is_phone_verified,cdate,phone_code,phone_no FROM users WHERE email=?");
    $check_user_regis->bind_param("s", $email);
    $check_user_regis->execute();
    $check_user_regis->store_result();
    $check_user_num_rows=$check_user_regis->num_rows;  //0 1
    if($check_user_num_rows > 0){
        $check_user_regis->bind_result($id_get,$email_get,$is_phone_verified,$cdate,$phone_code,$reg_phoneno);
        $check_user_regis->fetch();
		// Now Check OTP is verify yes or not	
		
		// Now check OTP verify
		if($is_phone_verified==1 ){
			// Already Account exist
			$record		=	array('success'=>'false', 'msg'=>$msg_email_exist,); 
			jsonSendEncode($record);
		}
			$check_mob_regis=$mysqli->prepare("SELECT id FROM users WHERE phone_no=? ");
			$check_mob_regis->bind_param("s", $phone_no);
			$check_mob_regis->execute();
			$check_mob_regis->store_result();
			$check_mob_num_rows=$check_mob_regis->num_rows;  //0 1
			if($check_mob_num_rows > 0){
				
				$check_mob_regis->bind_result($id_phone);
		        $check_mob_regis->fetch();
					
				

			if($id_phone!=$id_get){
					$record		=	array('success'=>'false', 'msg'=>array('This phone number is already registered'),); 
					jsonSendEncode($record);
			}
			}
		
		$update_all	=	$mysqli->prepare('UPDATE users SET f_name=?,l_name=?,postal_code=?,phone_no=?,phone_code=?,email=?,password=?,email_code=? WHERE id=?');
		$update_all->bind_param("ssssssssi",$f_name,$l_name,$postal_code,$phone_no,$verification_otp,$email,$password,$email_otp,$id_get);
		$update_all->execute();
		$update_affected_rows	=	$mysqli->affected_rows;

		$user_id_get = $id_get;

		if($is_phone_verified==0){
	
		if($phone_no){
					
				 $message =  "Your verification code is: ".$verification_otp." \r\n Tradespeoplehub.co.uk";
			$phone_number = "".$phone_no."";
			$SMSresponse = sendSMSTwilio($phone_number, $message);		
			if($SMSresponse['status'] == 'false'){
				$SMSresponse['message'];
				}
			
			}
		}
    }
	
	else{
		$user_id_get = 0;
		
		if($user_id_post == 0){

			$check_mob_regis=$mysqli->prepare("SELECT id FROM users WHERE phone_no=? ");
			$check_mob_regis->bind_param("s", $phone_no);
			$check_mob_regis->execute();
			$check_mob_regis->store_result();
			$check_mob_num_rows=$check_mob_regis->num_rows;  //0 1
			if($check_mob_num_rows > 0){		
	
					$record		=	array('success'=>'false', 'msg'=>array('This phone number is already registered'),); 
					jsonSendEncode($record);
			
			}
		
			$signup_add = $mysqli->prepare("INSERT INTO users(type, unique_id, f_name,l_name, email, phone_code,phone_no,password, cdate, postal_code,latitude,longitude,city,county,email_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$signup_add->bind_param("issssssssssssss", $type, $unique_id, $f_name,$l_name,$email,$verification_otp,$phone_no,$password,$createtime,$postal_code,$latitude,$longitude,$city,$address,$email_otp);	
			$signup_add->execute();
			$signup_add_affect_row=$mysqli->affected_rows;
			if($signup_add_affect_row<=0)
			{
				$record=array('success'=>'false','msg'=>$msg_error_signup); 
				jsonSendEncode($record);
			}
			$user_id_get	=	$mysqli->insert_id;
		}else{

			$check_mob_regis=$mysqli->prepare("SELECT id FROM users WHERE phone_no=? ");
			$check_mob_regis->bind_param("s", $phone_no);
			$check_mob_regis->execute();
			$check_mob_regis->store_result();
			$check_mob_num_rows=$check_mob_regis->num_rows;  //0 1
			if($check_mob_num_rows > 0){	
				$check_mob_regis->bind_result($id_phone);
		        $check_mob_regis->fetch();
					if($id_phone!=$user_id_get){
					$record		=	array('success'=>'false', 'msg'=>array('This phone number is already registered'),); 
					
					}
				
			
			}

			$update_all	=	$mysqli->prepare('UPDATE users SET f_name=?,l_name=?,email=?,phone_no=?,password=?,postal_code=? WHERE id=?');
			$update_all->bind_param("ssssssi", $f_name,$l_name,$email,$phone_no,$password,$postal_code,$user_id_post);	
			$update_all->execute();
			$update_affected_rows	=	$mysqli->affected_rows;
			if($update_affected_rows<=0){	
				$record=array('success'=>'false', 'msg' =>$msg_error_signup); 
				jsonSendEncode($record); 
			}
			$user_id_get	=	$user_id_post;
		}
		
					// echo $login_type;die();
	if($phone_no){
				
			 $message =  "Your verification code is: ".$verification_otp." \r\n Tradespeoplehub.co.uk";
			$phone_number = "".$phone_no."";
		$SMSresponse = sendSMSTwilio($phone_no, $message);
				if($SMSresponse['status'] == 'false'){
				$SMSresponse['message'];
				}
			}

	if($player_id!='123456' || $device_type != 'browser'){
		//----------------update user player_id for push notifications---------------------//
		$result 		=	 DeviceTokenStore_1_Signal($user_id_get, $device_type, $player_id);
	}

//// Reffer System ==============================		
if(!empty($reffer_code)){
$check_ruser_all	= $mysqli->prepare("SELECT id,type from users where unique_id=?");
$check_ruser_all->bind_param("i",$reffer_code);
$check_ruser_all->execute();
$check_ruser_all->store_result();
$check_ref_user		=	$check_ruser_all->num_rows;  //0 1
if($check_ref_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>'Reffer Code Invalid'); 
	jsonSendEncode($record);
}
$check_ruser_all->bind_result($referred_by,$referred_type);
$check_ruser_all->fetch();
	
$user_type=2;
$referred_link='https://www.tradespeoplehub.co.uk/signup-step1/';
$reffer_add = $mysqli->prepare("INSERT INTO `referrals_earn_list`(`user_id`, `referred_by`, `referred_type`, `referred_link`, `user_type`) VALUES (?,?,?,?,?)");
	$reffer_add->bind_param("issss",$user_id_get,$referred_by,$referred_type,$referred_link,$user_type);	
	$reffer_add->execute();
	$reffer_add_affect_row=$mysqli->affected_rows;
	if($reffer_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}	
 } 

// end refferal code		


	// echo $user_id_get;die();
	$notification_arr = array();
		$action 		=	'Signup';
		$action_id 		=	0;
		$title 			=	'Singup success';
		$message 		=	'Welcome to '.$app_name.', Your signup successfully done.';
		$sender_id 		=	$user_id_get;
		$receive_id 	=	$user_id_get;//($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $job_id='',$action_data='')
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}
	}
	if(empty($notification_arr)){
		$notification_arr	=	'NA';
	}    
    // Get user complete details
    $user_details	=	getUserDetails($user_id_get); 	
	// response here
	$record	=	array('success'=>'true', 'msg'=>$Signup_success, 'user_details'=>$user_details,'otp'=>$verification_otp, 'notification_arr'=>$notification_arr, 'SMSresponse'=>$SMSresponse,'user_id'=>$user_id_get,'$message'=>$message); 
	jsonSendEncode($record);   
?>
