<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';
if(!$_POST){
	$record=array('success'=>'false', 'msg' =>'Please use post'); 
	jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
	$record=array('success'=>'false', 'msg' =>'1'); 
	jsonSendEncode($record); 
}

$reciever_id	    =	$_POST['reciever_id'];
$user_id	     	=	$_POST['user_id'];
$job_id 	     	=	$_POST['job_id'];
$msg 	         	=	$_POST['msg'];



$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount,f_name,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>'error'); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$f_namesend,$type);
$check_user_all->fetch();
 
$create_time 	 = date('Y-m-d h:i:s');
$update_chat_msg = $mysqli->prepare("INSERT INTO `chat`(`post_id`, `sender_id`, `receiver_id`, `mgs`,  `create_time`) VALUES (?,?,?,?,?)");
$update_chat_msg->bind_param("iiiss",$job_id,$user_id,$reciever_id,$msg,$create_time);
$update_chat_msg->execute();
$update_chat_msg_rows = $mysqli->affected_rows;
if($update_chat_msg_rows<=0){
	$record=array('success'=>'true','msg'=>array('data found')); 
	jsonSendEncode($record);
}

 
	$notification_arr = array();
		$action 		=	'chat_msg';
		$action_id 		=	0;
		$title 			=	'New message';
        $title_push   =      'You´ve got a new message. Please reply!';
        $message_push   =   $f_namesend.' has just sent you a new message. Please respond now!';
		$message 		=	$f_namesend.' has sent you a message. View & Reply!';
		$sender_id 		=	$user_id;
		$receive_id 	=	$reciever_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			
			$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
		}
if (!empty($notification_arr)) {
if($type==1)
{
oneSignalNotificationSendCall($notification_arr);
 }
else{
	oneSignalNotificationSendtrades($notification_arr);
}
}

	

	$get_user_details = getUserDetails($user_id);
	$get_user_details_other = getUserDetails($reciever_id);
$user_id=0;
if($type==1)
{
	$linkopen=$homeowner;
	$last_msg='Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.';
}
else{
	$linkopen=$provider;
		$last_msg='Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.';

}
if($type==1)
{
$nameshow=$get_user_details['trading_name'];
}
else{
$nameshow=$get_user_details['f_name'];
}
$subject = " New Messages from " . $get_user_details['f_name']  ;
$html .= '<br><p style="margin:0;padding:10px 0px">Hi '. $get_user_details_other['f_name']. '</p>';
$html .= '<br><p style="margin:0;padding:10px 0px">You have received a new message from  '. $nameshow. '</p>';
$html .= '<br><div style="text-align:center"> 
 	<a href="'.$linkopen.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">  View Messages & Reply now</a>
    </div>';

$html .= '<br><p style="margin:0;padding:10px 0px">'.$last_msg.'</p>';
$mailBody = send_mail_app($html);
$email_arr[]				=	array('email'=>$get_user_details_other['email'], 'fromName'=>$get_user_details_other['f_name'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($get_user_details_other['email'],$get_user_details_other['f_name'], $subject, $mailBody);

$record=array('success'=>'true','msg'=>array('data found'),'notification_arr'=>'NA'); 
jsonSendEncode($record);



 ?>