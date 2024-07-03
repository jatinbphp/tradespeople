<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
 
$user_id	     	=	$_GET['user_id'];
$job_id 	     	=	$_GET['job_id'];
$msg_last_id 	    =	$_GET['msg_last_id'];
$other_user_id 	    =	$_GET['other_user_id'];

$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount);
$check_user_all->fetch();

$chat_arr = array();
//$chat_data	    =	$mysqli->prepare("SELECT `id`, `post_id`, `sender_id`, `receiver_id`, `mgs`, `is_read`, `create_time` FROM `chat` WHERE post_id=? and id>".$msg_last_id."");

$chat_data = $mysqli->prepare("SELECT `id`, `post_id`, `sender_id`, `receiver_id`, `mgs`, `is_read`, `create_time` FROM `chat` WHERE post_id=? and ((sender_id = $user_id and receiver_id = $other_user_id) or (sender_id = $other_user_id and receiver_id = $user_id)) and id>".$msg_last_id."");

$chat_data->bind_param("i",$job_id);
$chat_data->execute();
$chat_data->store_result();
$check_chat_data		=	$chat_data->num_rows;  //0 1
if($check_chat_data > 0){
	$chat_data->bind_result($id, $post_id, $sender_id, $receiver_id, $mgs, $is_read, $create_time);
	while ($chat_data->fetch()) {
		
		
		if($user_id==$receiver_id){
			$update3     =   $mysqli->prepare('UPDATE `chat` SET is_read=1 where `id`=?');
			$update3->bind_param('i',$id);
			$update3->execute();
			$update3_affect_row=$mysqli->affected_rows;
		}
		
		
		$chat_arr[] = array(
			'id'=>$id,
			'post_id'=>$post_id,
			'sender_id'=>$sender_id,
			'receiver_id'=>$receiver_id,
			'mgs'=>$mgs,
			'is_read'=>$is_read,
			'create_ago'=>$create_time,
		);
	}
}

if(empty($chat_arr)){
	$chat_arr='NA';
}

 

$record=array('success'=>'true','msg'=>array('data found'),'chat_arr'=>$chat_arr); 
jsonSendEncode($record);



 