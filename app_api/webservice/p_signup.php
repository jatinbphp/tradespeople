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
	if(empty($_POST['f_name']) || empty($_POST['l_name']) || empty($_POST['trading_name']) || empty($_POST['type']) || empty($_POST['email']) || empty($_POST['type']) || empty($_POST['phone_no']) || empty($_POST['password']) || empty($_POST['about_business']))
	{
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	$otp         = generateRandomOTP(4);
	$unique_id 				= date("ismy");
	$f_name 				= $_POST['f_name'];
	$l_name 				= $_POST['l_name'];
	$trading_name 			= $_POST['trading_name'];
	$type 					= $_POST['type'];
	$email 				    = $_POST['email'];
	$phone_no 				= $_POST['phone_no'];
	$password 				= $_POST['password'];
	$about_business 		= $_POST['about_business'];
	$is_qualification 		= $_POST['is_qualification'];
	$qualification 			= $_POST['qualification'];
	$county 				= $_POST['county'];
	$city 					= $_POST['city'];
	$max_distance 			= $_POST['max_distance'];
	$max_distance 			= $_POST['max_distance'];
	$postal_code 			= $_POST['postal_code'];
	$latitude 				= $_POST['latitude'];
	$longitude 				= $_POST['longitude'];
	$category 				= $_POST['category'];
	$insurance_liability 	= $_POST['insurance_liability'];
	$selected_sub_cat 		= $_POST['selected_sub_cat'];
	$insurance_date 		= $_POST['insurance_date'];
	$insurance_amount 		= $_POST['insurance_amount'];
	$e_address 				= $_POST['e_address'];
    $referral_code         = $_POST['referral_code'];
	$notification_status 	= 1;
	$player_id 		            = $_POST['player_id'];
	$device_type 				= $_POST['device_type'];
	$cdate 					= date('Y-m-d h:i:s');
	$user_details		    = array();	
    $about_business = '<p>'.$about_business.'</p>';
 
	
	
	// Now Check the user registration ============		
	$check_user_regis=$mysqli->prepare("SELECT id,email FROM users WHERE is_phone_verified=1 and email=?");
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


	$check_user_mobile=$mysqli->prepare("SELECT `id`, `email` FROM `users` WHERE is_phone_verified=1 and  phone_no=?");
    $check_user_mobile->bind_param("s", $phone_no);
    $check_user_mobile->execute();
    $check_user_mobile->store_result();
    $check_user__mobile_num_rows=$check_user_mobile->num_rows;  //0 1
    if($check_user__mobile_num_rows > 0){
       	$record=array('success'=>'false','msg'=>$msg_mobile_exist); 
		jsonSendEncode($record);
    }





	$signup_add = $mysqli->prepare("INSERT INTO `users`(`unique_id`, `f_name`, `l_name`, `trading_name`, `type`, `email`, `phone_no`, `password`, `about_business`, `is_qualification`, `qualification`, `county`, `city`, `max_distance`, `cdate`, `postal_code`, `latitude`, `longitude`,`category`, `insurance_liability`, `insurance_date`, `insurance_amount`,  `e_address`, `notification_status`,subcategory,phone_code,referral_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$signup_add->bind_param("ssssissssissssssssssssssss",$unique_id,$f_name,$l_name,$trading_name,$type,$email,$phone_no,$password,$about_business,$is_qualification,$qualification,$county,$city,$max_distance,$cdate,$postal_code,$latitude,$longitude,$category,$insurance_liability,$insurance_date,$insurance_amount,$e_address,$notification_status,$selected_sub_cat,$otp,$referral_code);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_signup); 
		jsonSendEncode($record);
	}
	$user_id_get	=	$mysqli->insert_id;
	 	
/// Reffer System

$refusers = getUserDetails($user_id_get);

if($refusers['referral_code']!=''){
	$referred_by=$refusers['referral_code'];					
	$referred_link = 'https://www.tradespeoplehub.co.uk/signup-step1';
	
	//-------------------------- check user_id --------------------------
$ref_user	=	$mysqli->prepare("SELECT id,type from users where unique_id=?");
$ref_user->bind_param("i",$referred_by);
$ref_user->execute();
$ref_user->store_result();
$check_user	 = $ref_user->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$ref_user->bind_result($user_id_get,$type);
$ref_user->fetch();
	
$user_type=2;	
$insert_ref=$mysqli->prepare("INSERT INTO referrals_earn_list(user_id,user_type,referred_by,referred_type,referred_link) VALUES (?,?,?,?,?)");
$insert_ref->bind_param("iisss",$userid,$user_type,$user_id_get,$type,$referred_link);
$insert_ref->execute();
$insert_ref_rows = $mysqli->affected_rows;
if($insert_ref_rows<=0){  
	$record=array('success'=>'false', 'msg' =>"Reffer not insert");
	jsonSendEncode($record);
}	
}


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

    
    



	// $email_verification_link      = $webservice_url.'verify_email.php?unique_id='.$unique_id;
 
	// // ------------------- mail Function call ------------------- //
	// $email_arr = array();
	// $name      = $f_name.' '.$l_name;
 
	// $postData['mailContent'] 	=	'<a href="'.$email_verification_link.'" style="background-color: #fe8a0f ; color: #fff ; padding: 8px 22px ; text-align: center ; display: inline-block ; line-height: 25px ; border-radius: 3px ; font-size: 17px ; text-decoration: none" target="_other" rel="nofollow">Verify Email Address</a>';
	// $postData['subject'] 		=	"Verify your Email Address - Tradespeoplehub.co.uk";
	// $postData['name'] 			=	$f_name.' '.$l_name;
	// $postData['email']			=	$email;
	// $postData['fromName']		=	$app_name;
	// $postData['app_name'] 		=	$app_name;
	// $postData['app_logo'] 		=	$app_logo;
	
	// $mailBody					=	mailBodySendDataEmailVerification($postData);
	// $email_arr[]				=	array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody); 

	// if(empty($email_arr)){
	//     $email_arr='NA';
	// }
 
    $user_details	=	getUserDetails($user_id_get); 	
 
	$record	=	array('success'=>'true', 'msg'=>$Signup_success,'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>