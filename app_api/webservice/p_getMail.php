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
 

	$user_id 	 = $_GET['user_id'];
	 
	
	//get user id chweck==========================
    $check_user_all	=	$mysqli->prepare("SELECT unique_id,f_name,l_name,id,email,email_code FROM `users` WHERE id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	} 
    $check_user_all->bind_result($unique_id,$f_name,$l_name,$user_id_get,$user_email,$email_code);
    $check_user_all->fetch(); 

	 
	$email_verification_link      = $app_url_verify.'verify_email.php?unique_id='.$unique_id;
	$mailContent = 'Welcome to '.$app_name.' Please verify your email account. If this was a mistake, just ignore this email and nothing will happen.<br/>To verify your Email account, visit the following link: <a href="'.$email_verification_link.'" style="float: unset; width: 25%; display: block; margin: 26px auto 0; background:#d52076; text-align: center; vertical-align: middle; user-select: none; border: 1px solid transparent; padding: .375rem .75rem; font-size: .875rem; line-height: 1.5; border-radius: .25rem; transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; color: #fff;text-decoration:none;">Verify Email Account</a>';
	// ------------------- mail Function call ------------------- //
	$email_arr                  = array();
	$name                       = $f_name.' '.$l_name;
	$subject  					=	'Verify your Email Address - Tradespeoplehub.co.uk';
	$heading  					=	'Verify your Email Address - Tradespeoplehub.co.uk';
	$postData['mail_heading'] 	=	$heading;
	$postData['mailContent'] 	=	'<a style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">'.$email_code.'</a>';
	$postData['subject'] 		=	'Verify your Email Address - Tradespeoplehub.co.uk';
	$postData['name'] 			=	$f_name.' '.$l_name;
	$postData['email']			=	$user_email;
	$postData['fromName']		=	$app_name;
	$postData['app_name'] 		=	$app_name;
	$postData['app_logo'] 		=	$app_logo;
	
	$mailBody					=	mailBodySendDataEmailVerification($postData);
//	$email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody); 

	if(empty($email_arr)){
	    $email_arr='NA';
	}
   	// Send Email OTP
    $mailResponse  =  mailSend($user_email,$f_name, $subject, $mailBody);
 
	$record	=	array('success'=>'true', 'msg'=>$data_found,'email_arr'=>'Email has been send'); 
	jsonSendEncode($record);   
?>