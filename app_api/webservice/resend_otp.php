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
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	// Get all value in variables 
	$user_id_post	=	$_POST['user_id_post'];
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT user_id, otp, otp_verify, name, email from user_master where delete_flag=0 and user_id=? ");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	
	if($check_user <= 0){
		$record=array('success'=>'false','msg' =>$user_not_found); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$otp, $otp_verify, $user_name, $user_email);
	$check_user_all->fetch();
	$verification_otp	=	generateRandomOTP(4);
	$updatetime			=	date('Y-m-d H:i:s');		
	//--------------------- update new otp -----------------------------	
	$update_all=$mysqli->prepare("UPDATE user_master set otp=?, updatetime=?  where user_id=?");
	$update_all->bind_param("isi",$verification_otp, $updatetime, $user_id_get);
	$update_all->execute();
	$update=$mysqli->affected_rows;
	if($update<=0){	
		$record=array('success'=>'false', 'msg'=>$msg_error_otp_send); 
		jsonSendEncode($record); 
	}

	
	// Start send mail
	$email_arr	=	array();	
    $postData['otp_code']		=	$verification_otp;
	$resnt_otp 					=	messageResntOTP($postData);
	$mailContent 				=	'';
	$mailContent 				.=	'<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">'.$resnt_otp.'</p>';
	$subject  					=	'Resend OTP verification';
	$heading  					=	'Resend OTP verification';
	$postData['mail_heading'] 	=	$heading;
	$postData['mailContent']	=	$mailContent;	
	$postData['subject'] 		=	$subject;	
	$postData['name'] 			=	$user_name;
	$postData['email']			=	$user_email;
	$postData['fromName']		=	$app_name;
	$postData['app_name'] 		=	$app_name;
	$postData['app_logo'] 		=	$app_logo;
	$fromName                   =   '';
    $mailBody					=	mailBodySendData($postData);
    $email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody);
	if(empty($email_arr)){
		$email_arr	=	'NA';
	}
	// End send mail
	$user_details  = getUserDetails($user_id_get);
	$record	=	array('success'=>'true', 'msg'=>$msg_success_otp_send, 'otp'=>$verification_otp, 'email_arr'=>$email_arr,'user_details'=>$user_details);
	jsonSendEncode($record);
	
?> 