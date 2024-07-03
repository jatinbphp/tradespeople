<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	include 'mailFunctions.php';
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}

	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	if(empty($_GET['otp'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	 
	//-------------------------------- get all value in variables -----------------------
	$user_id_post 	=	$_GET['user_id'];
	$user_otp 		=	$_GET['otp'];
	 //   echo "SELECT id from users where id=$user_id_post";
	//--ec------------------------ check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i", $user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false','msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();

	//-------------------------- check otp --------------------------
	$check_otp_all=$mysqli->prepare("SELECT `unique_id`, `f_name`, `l_name`, phone_code,email from users where id=? and phone_code=?");
	$check_otp_all->bind_param("ii",$user_id_post, $user_otp);
	$check_otp_all->execute();
	$check_otp_all->store_result();
	$check_otp=$check_otp_all->num_rows;  //0 1	
	if($check_otp <= 0){
		$record=array('success'=>'false', 'msg' =>$invalid_otp); 
		jsonSendEncode($record);
	}	
	$check_otp_all->bind_result($unique_id, $f_name, $l_name, $phone_code,$email);
	$check_otp_all->fetch();
	//----------------Update Account Details
	
	$is_phone_verified		=	1; 

	$update_all=$mysqli->prepare("UPDATE users set is_phone_verified=? WHERE id=? ");
	$update_all->bind_param("ii", $is_phone_verified,$user_id_post);
	$update_all->execute();
	$update=$mysqli->affected_rows;
	if($update<=0){	
		$record=array('success'=>'false','msg' =>$otp_not_verify); 
		jsonSendEncode($record); 
	}
	 

 $email_verification_link      = $webservice_url.'verify_email.php?unique_id='.$unique_id;
	 // ------------------- mail Function call ------------------- //
	 $email_arr = array();
	 $name      = $f_name.' '.$l_name;
 
	 $postData['mailContent'] 	=	'<a href="'.$email_verification_link.'" style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">Verify Email Address</a>';
	 $postData['subject'] 		=	"Verify your Email Address - Tradespeoplehub.co.uk";
	 $postData['name'] 			=	$f_name.' '.$l_name;
	 $postData['email']			=	$email;
	 $postData['fromName']		=	$app_name;
	 $postData['app_name'] 		=	$app_name;
	 $postData['app_logo'] 		=	$app_logo;
	
	 $mailBody					=	mailBodySendDataEmailVerification($postData);
	 $email_arr[]				=	array('email'=>$email, 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody); 

	 if(empty($email_arr)){
	     $email_arr='NA';
	 }
$notification_arr = array();
		$action 		=	'Signup';
		$action_id 		=	0;
		$title 			=	'Singup success';
		$message 		=	'Welcome to '.$app_name.', Your signup successfully done.';
		$sender_id 		=	$user_id_post;
		$receive_id 	=	$user_id_post;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}
		if(empty($notification_arr)){
    $notification_arr='NA';
}

$postData_new = getUserDetails($userid);


    $subject	=	'Phone number verified successfully';

    $html = '<p style="margin:0;padding:10px 0px">Hi ' .$f_name.',</p>';
    $html .= '<p style="margin:0;padding:10px 0px">Your Phone number has been verified successfully. 
</p>';

$html .= '<br><p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);


$email_arr[]				=	array('email'=>$email, 'fromName'=>$f_name, 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($email,$f_name, $subject, $mailBody);
	






	  
	$user_details	=	getUserDetails($user_id_post);
	$record=array('success'=>'true','msg' =>$msg_success_otp_verify, 'user_details'=>$user_details,'email_arr'=>$email_arr,'notification_arr'=>$notification_arr); 
	jsonSendEncode($record);

?>