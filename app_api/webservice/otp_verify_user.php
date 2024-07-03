<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	include("mailFunctions.php"); 
	if(!$_POST){
		$record=array('success'=>'false', 'msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}

	if(empty($_POST['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	if(empty($_POST['otp'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	//echo "<pre>";print_r($_POST);die;

	//-------------------------------- get all value in variables -----------------------
	$user_id_post 	=	$_POST['user_id'];
	$user_otp 		=	$_POST['otp'];
	// $otp_verify_for =	$_POST['otp_verify_for'];
	// $device_type	=	$_POST['device_type'];
	// $player_id 		=	$_POST['player_id'];
	// $delete_flag    =	0;
	$mail_arr 		=	array();   
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT id ,f_name,l_name,email,unique_id from users where id=?");
	$check_user_all->bind_param("i", $user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false','msg' =>array($user_id_post,'')); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$f_name,$l_name,$email,$unique_id);
	$check_user_all->fetch();
	
	//-------------------------- check otp --------------------------
	$check_otp_all=$mysqli->prepare("SELECT phone_code  from users where id=? and phone_code=?");
	$check_otp_all->bind_param("ii",$user_id_get, $user_otp);
	$check_otp_all->execute();
	$check_otp_all->store_result();
	$check_otp=$check_otp_all->num_rows;  //0 1	
	if($check_otp <= 0){
		$record=array('success'=>'false', 'msg' =>$invalid_otp); 
		jsonSendEncode($record);
	}	
	//----------------Update Account Details
	
	$is_phone_verified		=1;
	$signup_step	=	1;
	$profile_complete	=	1;
	// $updatetime		=	date('Y-m-d H:i:s');

	$update_all=$mysqli->prepare("UPDATE users set is_phone_verified=? WHERE id=? ");
	$update_all->bind_param("ii", $is_phone_verified,  $user_id_get);
	$update_all->execute();
	$update=$mysqli->affected_rows;
	if($update<=0){	
		$record=array('success'=>'false','msg' =>$otp_not_verify); 
		jsonSendEncode($record); 
	}
	// if($player_id!='123456' || $device_type != 'browser'){
	// 	//----------------update user player_id for push notifications---------------------//
	// 	$result 	=	DeviceTokenStore_1_Signal($user_id_get, $device_type, $player_id);
	// }

	$notification_arr = array();
		$action 		=	'Signup';
		$action_id 		=	0;
		$title 			=	'Singup success';
		$message 		=	'Welcome to '.$app_name.', Your signup successfully done.';
		$sender_id 		=	$user_id_get;
		$receive_id 	=	$user_id_get;//($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $job_id='',$action_data='')
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}

	if(empty($notification_arr)){
    $notification_arr='NA';
}
//    $email_verification_link      = $webservice_url.'verify_email.php?unique_id='.$unique_id;
	 // ------------------- mail Function call ------------------- //
	 $email_arr = array();
$get_post_user = getUserDetails($user_id_get);
	 $name      = $f_name.' '.$l_name;
 
	 $postData['mailContent'] 	=	'<a href="'.$email_verification_link.'" style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">Verify Email Address</a>';
	  $subject		=	"Verify your Email Address - Tradespeoplehub.co.uk";
	 $postData['name'] 			=	$f_name.' '.$l_name;
	 $postData['email']			=	$email;
	 $postData['fromName']		=	$app_name;
	 $postData['app_name'] 		=	$app_name;
	 $postData['app_logo'] 		=	$app_logo;
	
//	 $mailBody					=	mailBodySendDataEmailVerification($postData);
//	 $email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody); 
//	$mailResponse  =  mailSend($get_post_user['email'],$get_post_user['f_name'], $subject, $mailBody);
	
	$subject = "Thank you for Signing up to Tradespeoplehub.co.uk.";
	$html .= '<h style="margin:0;padding:10px 0px"> Welcome to Tradespeople Hub! </h>';
	$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_post_user['f_name'] .',</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local tradespeople.</p>';
	$html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to get local trade professionals to do any job around your home.</p>';
$html.='<br><div style="text-align:center"> 
  <a href='.$homeowner.' style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">See how it works</a></div>';
$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);
$email_arr[]				=	array('email'=>$get_post_user['email'], 'fromName'=>$get_post_user['f_name'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
	$mailResponse  =  mailSend($get_post_user['email'],$get_post_user['f_name'], $subject, $mailBody);


	$user_details	=	getUserDetails($user_id_get);
	$record=array('success'=>'true','msg' =>$msg_success_otp_verify, 'user_details'=>$user_details,'notification_arr'=>$notification_arr,'email_arr'=>$email_arr); 
	jsonSendEncode($record);

?>