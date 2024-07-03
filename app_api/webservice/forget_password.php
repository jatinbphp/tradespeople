<?php
		
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'mailFunctions.php';
	include 'language_message.php';

	if(!$_POST){
		$record 	=	array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}

	if(empty($_POST['email'])){
		$record 	=	array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	//------------------------get all value in variables------------------
	$user_email = $_POST['email'];

//-------------------------- check user_id --------------------------
	 

$check_user_all	=	$mysqli->prepare("SELECT id,password from users where email=?");
$check_user_all->bind_param("s",$user_email);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
    $record		=	array('success'=>'false', 'msg'=>$msg_invalid_email); 
    jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$password);
$check_user_all->fetch();
	// ------------------------ check user email end ------------------------ //
	
	//----------------------------- check account activate or not ----------------------
	// $active_status = checkAccountActivateDeactivate($user_id_get);
	// if($active_status == 0){
	// 	$record=array('success'=>'false','msg'=>$msg_error_activation, 'account_active_status' => 'deactivate'); 
	// 	jsonSendEncode($record);
	// }
	

	// ----------------------- Mail Function start ----------------------- //
	// $forgot_pass_identity 	=	uniqid();
	$resetPassLink 			=	$webservice_url.'forget_password_reset.php?uniqcode='.$forgot_pass_identity;
    	
	$mailContent 			=	'This is an automated message . If you did not recently initiate the Forgot Password process, please disregard this email.<br/><br/>

You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.<br/><br/>Password : '.$password;

	$active_flag			=	0;
	$delete_flag			=	0;
	$createtime				=	date('Y-m-d H:i:s');
	$updatetime				=	date('Y-m-d H:i:s');


	// -------------- Now Insert Data Into Request Table -------------- //
	// $forgot_insert 	=	$mysqli->prepare("INSERT INTO forgot_password_master (user_id, email, user_type, forgot_pass_identity, active_flag, delete_flag, createtime, updatetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
	// $forgot_insert->bind_param("isisiiss", $user_id_get, $user_email, $user_type, $forgot_pass_identity, $active_flag, $delete_flag, $createtime, $updatetime);
	// $forgot_insert->execute();
	// $insert_id = $forgot_insert->affected_rows;
	// if($insert_id <= 0) {	
	// 	$record 	=	array('success'=>'false', 'msg'=>$msg_error_forgot_email_update); 
	// 	jsonSendEncode($record); 
	// }
	
	// Start send mail
	$email_arr	=	array();	
	
	$subject  					=	'TradespeopleHub: Forget Password!';
	$heading  					=	'';
	$postData['mail_heading'] 	=	'';
	$postData['mailContent'] 	=	'<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">'.$mailContent.'</p>';
	$postData['subject'] 		=	$subject;
	$postData['name'] 			=	$user_name;
	$postData['email']			=	$user_email;
	$postData['fromName']		=	$app_name;
	$postData['app_name'] 		=	$app_name;
	$postData['app_logo'] 		=	$app_logo;
	
	$mailBody					=	mailBodySendData($postData);
	$email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody);

	if(empty($email_arr)){
		$email_arr	=	'NA';
	}
	// End send mail

	$record			=	array('success'=>'true', 'msg'=>$msg_success_forgot_password, 'email_arr'=>$email_arr); 
	jsonSendEncode($record);

?>