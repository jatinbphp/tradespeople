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


	if(empty($_POST['user_id'])){
		$record=array('success'=>'false detail', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	

if(empty($_POST['device_type'])){
	$record = array('success'=>'false', 'msg'=>$msg_empty_param); 
	jsonSendEncode($record);
}

if(empty($_POST['player_id'])){
	$record = array('success'=>'false', 'msg'=>$msg_empty_param); 
	jsonSendEncode($record);
}



    $userid			   	   =	$_POST['user_id'];
    $signup_step=2;
    $otp                    = generateRandomOTP(4);
    $email_otp              = generateRandomOTP(4);
	$unique_id 				= date("ismy");
	$about_business 		= $_POST['about_business'];
	$is_qualification 		= $_POST['is_qualification'];
	$qualification 			= $_POST['qualification'];
    $insurance_liability 	= $_POST['insurance_liability'];
    $insurance_date 		= $_POST['insurance_date'];
	$insurance_amount 		= $_POST['insurance_amount'];
	$device_type  	= 	$_POST['device_type'];
	$player_id    	= 	$_POST['player_id'];
    $cdate 					= date('Y-m-d h:i:s');
    $reffer_code   = $_POST['reffer_code'];
	$user_details		    = array();	
    $about_business = ($about_business!='') ? '<p>'.$about_business.'</p>':'';

	// define variable
	$update_date			=	date("Y-m-d H:i:s");

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,email,f_name,l_name,phone_no from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id_get,$email,$f_name,$l_name,$phone_no);
	$check_user_all->fetch();

$record=array('success'=>'true','msg'=>$msg_error_jobadd); 
//jsonSendEncode($record);
   
$update_user_details = $mysqli->prepare("UPDATE users SET  `about_business`=?, `is_qualification`=?, `qualification`=?,`insurance_liability`=?, `insurance_date`=?, `insurance_amount`=?,signup_step=?,phone_code=?,email_code=? WHERE id=?");
$update_user_details->bind_param("sissssissi",$about_business,$is_qualification,$qualification,$insurance_liability,$insurance_date,$insurance_amount,$signup_step,$otp,$email_otp,$userid);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>$msg_error_jobadd); 
jsonSendEncode($record);
}


// Reffer Link
if($reffer_code) {
$check_ruser_all	= $mysqli->prepare("SELECT id,type from users where unique_id=?");
$check_ruser_all->bind_param("i",$reffer_code);
$check_ruser_all->execute();
$check_ruser_all->store_result();
$check_ref_user		=	$check_ruser_all->num_rows;  //0 1
if($check_ref_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_ruser_all->bind_result($referred_by,$referred_type);
$check_ruser_all->fetch();

$user_type=1;
$referred_link='https://www.tradespeoplehub.co.uk/signup-step1/';
$reffer_add = $mysqli->prepare("INSERT INTO `referrals_earn_list`(`user_id`, `referred_by`, `referred_type`, `referred_link`, `user_type`) VALUES (?,?,?,?,?)");
	$reffer_add->bind_param("issss",$userid,$referred_by,$referred_type,$referred_link,$user_type);	
	$reffer_add->execute();
	$reffer_add_affect_row=$mysqli->affected_rows;
	if($reffer_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}
}
///----------------------------job upload file--------------------




$message =  "Your verification code is: ".$otp." \r\n Tradespeoplehub.co.uk";

//$record=array('success'=>'false','msg'=>$message); 
//		jsonSendEncode($record);
	$phone_number = "".$phone_no."";
	$SMSresponse = sendSMSTwilio($phone_number, $message);
	if($SMSresponse['status'] == 'false'){ 
		$SMSresponse['message'];
	}
		
	if($player_id!='123456' || $device_type != 'browser'){
	// 	//----------------update user player_id for push notifications---------------------//
	 	$result 		=	 DeviceTokenStore_1_Signal($user_id_get, $device_type, $player_id);
	}

  // Send OTP to Email
   $subject='Verify your Email Address - Tradespeoplehub.co.uk'; 
//  $mailBody="Your verification code is: ".$email_otp;
  
     $postData['subject'] 		=	"Verify your Email Address - Tradespeoplehub.co.uk";
     $postData['mail_heading'] 	=	"Verify your Email Address - Tradespeoplehub.co.uk";
     $postData['mailContent'] 	=	'<a style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">'.$email_otp.'</a>';
	 $postData['name'] 			=	$f_name.' '.$l_name;
	 $postData['email']			=	$email;
	 $postData['fromName']		=	$app_name;
	 $postData['app_name'] 		=	$app_name;
	 $postData['app_logo'] 		=	$app_logo;

     $mailBody  =  mailBodySendDataEmailVerification($postData);
 //  $email_arr[]				=	array('email'=>$email, 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody); 

	 if(empty($email_arr)){
	     $email_arr='NA';
	 }
 
     $user_details	=	getUserDetails($user_id_get); 	
     // Send Email OTP
    $mailResponse  =  mailSend($email,$f_name, $subject, $mailBody);
 
	$record	=	array('success'=>'true', 'msg'=>$Signup_success,'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>
