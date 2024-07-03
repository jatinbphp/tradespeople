<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
 include 'twiliosms/sendMessageTwilioApi.php';



	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	
	
	//user name
	if(empty($_GET['email'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
    if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	// Get All Post Parameter
    $user_id			    =	$_GET['user_id'];
    $email					=	$_GET['email']; 	
    $email_otp              = generateRandomOTP(4);
    $createtime				=	date("Y-m-d H:i:s");
    $updatetime				=	date("Y-m-d H:i:s");
    $boost_profile_date	    =   date('Y-m-d H:i:s', strtotime('+1000 years'));
	$u_email_verify      = 0;
    $user_details		=	array();	
	$notification_arr 	=	array();
	$mail_arr			=	array();
	$email_arr			=	array();
	
	// ========= Profile Picture	
	$profile_image	=	'NA';   

//=======check for unique mobile=====================

	
//=====check for mobile end============================
 
	
	// Now Check the user registration ============		
	$check_user_regis=$mysqli->prepare("SELECT id,email,f_name,l_name,is_phone_verified,cdate,phone_code,phone_no FROM users WHERE id=?");
    $check_user_regis->bind_param("s", $user_id);
    $check_user_regis->execute();
    $check_user_regis->store_result();
    $check_user_num_rows=$check_user_regis->num_rows;  //0 1
    if($check_user_num_rows > 0){
        $check_user_regis->bind_result($id_get,$email_get,$f_name,$l_name,$is_phone_verified,$cdate,$phone_code,$reg_phoneno);
        $check_user_regis->fetch();
		// Now Check OTP is verify yes or not	
		
		 
		$update_all	=	$mysqli->prepare('UPDATE users SET email=?,email_code=?,u_email_verify=? WHERE id=?');
		$update_all->bind_param("sssi",$email,$email_otp,$u_email_verify,$id_get);
		$update_all->execute();
		$update_affected_rows	=	$mysqli->affected_rows;

		$user_id_get = $id_get;
 
    } else {
		
		$record		=	array('success'=>'false', 'msg'=>'User does not Exists'); 
	    jsonSendEncode($record);
	 
	}
	 
    // Get user complete details
    $user_details	=	getUserDetails($user_id_get); 	

    $email_arr                  = array();
	$name                       = $f_name.' '.$l_name;
	$subject  					=	'Verify Email';
	$heading  					=	'Verify Email';
	$postData['mail_heading'] 	=	$heading;
	$postData['mailContent'] 	=	'<a style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">'.$email_otp.'</a>';
	$postData['subject'] 		=	'Verify your Email Address - Tradespeoplehub.co.uk';
	$postData['name'] 			=	$f_name.' '.$l_name;
	$postData['email']			=	$email;
	$postData['fromName']		=	$app_name;
	$postData['app_name'] 		=	$app_name;
	$postData['app_logo'] 		=	$app_logo;
	
	$mailBody					=	mailBodySendDataEmailVerification($postData);
   $email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'message'=>''); 
   if(empty($email_arr)){
	    $email_arr='NA';
	}
   	// Send Email OTP
    $mailResponse  =  mailSend($email,$f_name, $subject, $mailBody);

    $message='OTP has been send to your registered email';
	// response here
	$record	=	array('success'=>'true', 'msg'=>$message, 'user_details'=>$user_details,'otp'=>$email_otp,'user_id'=>$user_id_get); 
	jsonSendEncode($record);   
?>
