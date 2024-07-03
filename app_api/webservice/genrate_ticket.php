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


// ------------------- check user mobile ------------------- //










$createtime       =   date('Y-m-d H:i:s');
$ticket_id= generateRandomString(12);
 

$insert_all=$mysqli->prepare("INSERT INTO `admin_chats`( `is_admin`, `admin_id`, `user_id`, `created`, `sender_id`, `receiver_id`,ticket_id)  VALUES (?,?,?,?,?,?,?)");
$insert_all->bind_param("iiisiis", $is_admin,$admin_id,$user_id,$createtime,$sender_id,$receiver_id,$ticket_id);
$insert_all->execute();
$insert=$mysqli->affected_rows;
if($insert<=0){
$record=array('success'=>'false','msg' =>$device_add_one_unsuccess); 
    jsonSendEncode($record); 
}
$id_insert=$mysqli->insert_id;

$is_read=0;
//------------------------------------insert other tables-----------------
$other_data_add=$mysqli->prepare("INSERT INTO `admin_chat_details`( `admin_chat_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `is_admin`, `create_time`) VALUES (?,?,?,?,?,?,?)");
$other_data_add->bind_param("iiisiis", $id_insert,$user_id,$receiver_id,$message,$is_read,$is_admin,$createtime );
$other_data_add->execute();
$other=$mysqli->affected_rows;
if($other<=0){
$record=array('success'=>'false','msg' =>$device_add_one_unsuccess); 
    jsonSendEncode($record); 
}

//
  

   
// ------------------ Notification array end ------------------ //
    
$user_details  = getUserDetails($user_id);
	$notification_arr = array();
		$action 		=	'Ticket_created';
		$action_id 		=	$id_insert;
		$title 			=	'Ticket created';
		$message 		=	'You´ve created a new support ticket. Click Here to view the message';
		$sender_id 		=	$user_id;
		$receive_id 	=	$user_id;//($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $job_id='',$action_data='')
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		} 
if(empty($notification_arr)){
    $notification_arr='NA';
}

$mysqli->close();

$record=array('success'=>'true','msg' =>$device_add_one_success,'id'=>$id_insert,'notification_arr'=>$notification_arr);  
jsonSendEncode($record);

?>

