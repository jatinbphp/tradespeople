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



$gt_post_ids	    =	$mysqli->prepare("SELECT GROUP_CONCAT(DISTINCT post_id) from chat where sender_id=? or receiver_id=?");
$gt_post_ids->bind_param("ii",$user_id,$user_id);
$gt_post_ids->execute();
$gt_post_ids->store_result();
$check_user1		=	$gt_post_ids->num_rows;  //0 1
if($check_user1 <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$gt_post_ids->bind_result($post_ids);
$gt_post_ids->fetch();
$post_id_arr =array();
if(!is_null($post_ids)){
	$post_id_arr = explode(",",$post_ids);
}

 
$chat_inbox_arr = array();
for ($i=0; $i<count($post_id_arr) ; $i++) { 

	$chat_data	    =	$mysqli->prepare("SELECT `id`, `post_id`, `sender_id`, `receiver_id`, `mgs`, `is_read`, `create_time` FROM `chat` WHERE (sender_id = ? or receiver_id = ?) and post_id=? order by id desc limit 1");
	$chat_data->bind_param("iii",$user_id,$user_id,$post_id_arr[$i]);
	$chat_data->execute();
	$chat_data->store_result();
	$check_chat_data		=	$chat_data->num_rows;  //0 1
	if($check_chat_data > 0){
		$chat_data->bind_result($id, $post_id, $sender_id, $receiver_id, $mgs, $is_read, $create_time);
		$chat_data->fetch();
		$job_arr = getJobDetails($post_id);
	
		$rid = ($sender_id==$user_id) ? $receiver_id:$sender_id;
		$unread_msg = get_unread_msg_count($user_id,$post_id,$rid);
		
		$user_arr = getUserDetails($rid);
		$u_name='NA';		
		$u_profile='NA';

		if($user_arr != 'NA'){
			if($user_arr['type']==1){
				$u_name = $user_arr['trading_name'];
			}else{
				$u_name = $user_arr['f_name'].' '.$user_arr['l_name'];
			}
			$u_profile  = $user_arr['profile'];
		}
		
		$job_title='NA';
		if($job_arr!='NA')
		{	$job_title  = $job_arr['title'];}
	
		$chat_inbox_arr[] = array(
			'id'=>$id,
			'post_id'=>$post_id,
			'sender_id'=>$sender_id,
			'receiver_id'=>$receiver_id,
			'mgs'=>$mgs,
			'is_read'=>$is_read,
			'create_ago'=>time_ago($create_time),
			'job_title'=>$job_title,
			'u_profile'=>$u_profile,
			'u_name'=>$u_name,
			'unread_msg'=>$unread_msg,
			'rid'=>$rid,
		);
	}
}

  

if(empty($chat_inbox_arr)){
	$chat_inbox_arr='NA';
}

 

$record=array('success'=>'true','msg'=>array('data found'),'chat_inbox_arr'=>$chat_inbox_arr); 
jsonSendEncode($record);



