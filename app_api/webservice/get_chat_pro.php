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
$other_user_id      =   $_GET['other_user_id'];

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

$plan_arr    =  getPlanDetails($user_id);
$job_arr     =  getJobDetails($job_id);
$chat_paid   =  getChatPaid($user_id,$job_id);
$admin_details = getAdminDetails();
$o_user_arr    = getUserDetails($other_user_id);
$up_status = 0;
$valid_type = 0;
if($plan_arr!='NA'){
	$up_status = $plan_arr['up_status'];
	$valid_type = $plan_arr['valid_type'];
}


$check_chat_show_status = false;
if ($job_arr['direct_hired']==0 || ($up_status==1 && $valid_type==1) || $chat_paid=='yes') {
	$check_chat_show_status = true;
}else{
	$check_chat_show_status = false;
}
	
if($check_chat_show_status==false){
	$credit_amount=$admin_details['credit_amount'];
	if($u_wallet >= $credit_amount) {
		$u_wallet1=$u_wallet-$credit_amount;

		$update3     =   $mysqli->prepare('UPDATE `users` SET `u_wallet`=? WHERE id=?');
		$update3->bind_param('si',$u_wallet1,$user_id);
		$update3->execute();
		$update3_affect_row=$mysqli->affected_rows;

		$transactionid = md5(rand(1000,999).time());
		$tr_message    = '£'.$credit_amount.' has been debited from your wallet to chat with '.$o_user_arr['f_name'].' '.$o_user_arr['l_name'].'';



		// update transaction table======================
		$tr_type = 2;
		$tr_status = 1;
		$updatetime =  date("Y-m-d H:i:s");
		$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiissss",$user_id,$credit_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>array('Something went wrong please try again later')); 
			jsonSendEncode($record);
		}

		$insert_chat_paid = $mysqli->prepare("INSERT INTO `chat_paid`(`user_id`, `post_id`, `posted_by`) VALUES (?,?,?)");
		$insert_chat_paid->bind_param("iii",$user_id,$job_id,$other_user_id);	
		$insert_chat_paid->execute();
		$insert_chat_paid_affect_row=$mysqli->affected_rows;
		if($insert_chat_paid_affect_row<=0){
			$record=array('success'=>'false','msg'=>array('Something went wrong please try again later')); 
			jsonSendEncode($record);
		}
	}else{
		$record=array('success'=>'true','msg'=>'chat_paid'); 
		jsonSendEncode($record);
	}
}
	 

$chat_arr = array();
$chat_data	    =		$mysqli->prepare("SELECT `id`, `post_id`, `sender_id`, `receiver_id`, `mgs`, `is_read`, `create_time` FROM `chat` WHERE post_id=? and ((sender_id = $user_id and receiver_id = $other_user_id) or (sender_id = $other_user_id and receiver_id = $user_id))");
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

?>

