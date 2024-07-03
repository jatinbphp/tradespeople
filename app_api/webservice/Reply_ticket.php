<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php';
include 'mailFunctions.php'; 
include 'language_message.php';


if(!$_POST){
    $record=array('success'=>'false','msg' =>$msg_post_method); 
    jsonSendEncode($record);
}
if(empty($_POST['user_id'])){
    $record=array('success'=>'false','msg' =>$msg_empty_param); 
    jsonSendEncode($record);
}




//-------------------------------- get all value in variables -----------------------
$user_id             =   $_POST['user_id'];
$message             =   $_POST['message'];
$is_admin            =   0;
$admin_id            =   0;
$sender_id           =   0;
$receiver_id         =   0;
$chat_id             =   $_POST['chat_id'];


// ------------------- check user mobile ------------------- //

$createtime       =   date('Y-m-d H:i:s');

$is_read=0;
//------------------------------------insert other tables-----------------
$other_data_add=$mysqli->prepare("INSERT INTO `admin_chat_details`( `admin_chat_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `is_admin`, `create_time`) VALUES (?,?,?,?,?,?,?)");
$other_data_add->bind_param("iiisiis", $chat_id,$user_id,$receiver_id,$message,$is_read,$is_admin,$createtime );
$other_data_add->execute();
$other=$mysqli->affected_rows;
if($other<=0){
$record=array('success'=>'false','msg' =>$device_add_one_unsuccess); 
    jsonSendEncode($record); 
}

//

    $get_users     = getUserDetails($user_id);
$usertype=$get_users['type'];
if($usertype=2)
{
	$linkopen=$homeowner;
}
else{
	$linkopen=$provider;
}
  	$subject =  "You´ve got a new message from Tradespeople Hub";
			$content .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_users['f_name'] .',</p>';
		$content .= '<p style="margin:0;padding:10px 0px">You´ve got a message from our support team. Please log in to your account to read the message or click the view message below. 
</p>';

$content .='<br><div style="text-align:center"><a href="'.$linkopen.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;"> View Message</a></div>';
$content .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content);

	$email_arr[]				=	array('email'=>$get_users['email'], 'fromName'=>$get_users['f_name'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($get_users['email'], $get_users['f_name'], $subject, $mailBody);

   
// ------------------ Notification array end ------------------ //
    


$mysqli->close();

$record=array('success'=>'true','msg' =>$reply_sucess,'id'=>$id_insert);  
jsonSendEncode($record);

?>

