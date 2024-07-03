<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

if(empty($_GET['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$user_id	     	=	$_GET['user_id'];
$job_id			 	=	$_GET['job_id'];
$bid_id			 	=	$_GET['bid_id'];
$dispute_id 	    =   $_GET['dispute_id'];

// Get Dispute

$get_dispute_data=$mysqli->prepare("SELECT `ds_id`,ds_buser_id,ds_puser_id,total_amount FROM `tbl_dispute` WHERE ds_id=? AND disputed_by=?");
$get_dispute_data->bind_param('ii',$dispute_id,$user_id);
$get_dispute_data->execute();
$get_dispute_data->store_result();
$get_dispute_data_count=$get_dispute_data->num_rows;  //0 1	
// echo $get_dispute_data_count;die();
if($get_dispute_data_count <= 0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong please try again later.')); 
	jsonSendEncode($record);
}
$get_dispute_data->bind_result($ds_id,$ds_buser_id,$ds_puser_id,$total_amount);
$get_dispute_data->fetch();

//$dispute = get_dispute($dispute_id);
$milestones = getallmilestone($dispute_id);

if ($dispute_id && $job_id && $ds_id) {
$ds_status=1;
$caseCloseStatus=2;	
	
$update3  = $mysqli->prepare('UPDATE `tbl_dispute` SET `ds_status`=?,`caseCloseStatus`=? WHERE ds_id=?');
$update3->bind_param('iii',$ds_status,$caseCloseStatus,$dispute_id);
$update3->execute();	
$update3_affect_row=$mysqli->affected_rows;	
if($update3_affect_row){
	
$update4 = $mysqli->prepare('UPDATE `tbl_milestones` SET `status`=0,`dispute_id`=NULL WHERE dispute_id=?');
$update4->bind_param('i',$dispute_id);
$update4->execute();
	
$job = getJobDetails($job_id);	

if ($user_id == $ds_buser_id) {
    $disput_user = getUserDetails($ds_buser_id);
	$other_user = getUserDetails($ds_puser_id);
 } else {
    $disput_user = getUserDetails($ds_puser_id);
	$other_user = getUserDetails($ds_buser_id);
}	
	
$checkStepIn = ask_admin_data($disput_user['id'],$dispute_id);	

if($checkStepIn!='NA'){
	$tr_userid = $disput_user['id'];
	$tr_amount = $checkStepIn['amount'];
	$tr_type = 1;
	$tr_transactionId = md5(rand(1000, 999) . time());
	$tr_message = '£' . $checkStepIn['amount'] . ' arbitration fee has been credited to your wallet as dispute has been cancelled and closed.';
	$tr_status = 1;
	$tr_created = date('Y-m-d H:i:s');
	$tr_update = date('Y-m-d H:i:s');
	
	$trns_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_message`, `tr_status`,`tr_created`,`tr_update`) VALUES (?,?,?,?,?,?,?,?)");
	$trns_add->bind_param("isssssss",$tr_userid,$tr_amount,$tr_type,$tr_transactionId,$tr_message,$tr_status,$tr_created,$tr_update);	
$trns_add->execute();
$trns_add=$mysqli->affected_rows;
	
	$dispute_user_id=$disput_user['id'];
	$u_wallet=$disput_user['u_wallet']+$checkStepIn['amount'];
	 $update6 = $mysqli->prepare('UPDATE `users` SET `u_wallet`=? WHERE id=?');
     $update6->bind_param('si',$u_wallet,$dispute_user_id);
     $update6->execute();
	
	if($disput_user['type'] == 1){
      $withdrawable_balance=$disput_user['withdrawable_balance']+$checkStepIn['amount'];
	   $update7 = $mysqli->prepare('UPDATE `users` SET `withdrawable_balance`=? WHERE id=?');
       $update7->bind_param('si',$withdrawable_balance,$dispute_user_id);
       $update7->execute();
	}
	
}
	  
	$checkStepIn1 = ask_admin_data($other_user['id'],$dispute_id);	
	 if($checkStepIn1!='NA'){
		$tr_userid = $other_user['id'];
		$tr_amount = $checkStepIn1['amount'];
		$tr_type = 1;
		$tr_transactionId = md5(rand(1000, 999) . time());
		$tr_message = '£' . $checkStepIn1['amount'] . ' arbitration fee has been credited to your wallet as dispute was cancelled and closed.';
		$tr_status = 1;
		$tr_created = date('Y-m-d H:i:s');
		$tr_update = date('Y-m-d H:i:s');
			
$trns_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_message`, `tr_status`,`tr_created`,`tr_update`) VALUES (?,?,?,?,?,?,?,?)");
$trns_add->bind_param("isssssss",$tr_userid,$tr_amount,$tr_type,$tr_transactionId,$tr_message,$tr_status,$tr_created,$tr_update);	
$trns_add->execute();

$other_user_id=$other_user['id'];		 
$u_wallet=$other_user['u_wallet']+$checkStepIn1['amount'];
$update1 = $mysqli->prepare('UPDATE `users` SET `u_wallet`=? WHERE id=?');
$update1->bind_param('si',$u_wallet,$other_user_id);
$update1->execute();
		 
if($other_user['type'] == 1){
 $withdrawable_balance=$other_user['withdrawable_balance']+$checkStepIn1['amount'];
 $update1 = $mysqli->prepare('UPDATE `users` SET `withdrawable_balance`=? WHERE id=?');
 $update1->bind_param('si',$withdrawable_balance,$other_user_id);
 $update1->execute();	
 }
 				
    } 
	
///////// Notification

$nt_message = $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled the milestone payment dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View Now</a>';

// notification====================
$notification_arr  = array();
$action 		=	'dispute_cancel';
$action_id 		=    $job_id;
$title 			=	'Dispute cancelled';
$message 		=	$nt_message;
$sender_id      =   $user_id;
$receive_id 	=	$other_user['id'];
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if(empty($notification_arr)){
	$notification_arr	=	'NA';
}
	
/// Ohter Notification
$nt_message = 'You have cancelled and close the milestone payment dispute successfully.  <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View Now</a>';
$notification_arr  = array();
$action 		=	'dispute_cancel';
$action_id 		=    $job_id;
$title 			=	'Dispute cancelled';
$message 		=	$nt_message;
$sender_id      =   $disput_user['id'];
$receive_id 	=	$user_id;
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if(empty($notification_arr)){
	$notification_arr	=	'NA';
}
	
if ($disput_user['type'] == 1) { //cancelled by tradesmen
	
$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"';
$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['trading_name'] . ' has cancelled the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $total_amount . '</p>';
$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p>';
$contant .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/dispute/' . $ds_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';
$contant .= '<p style="margin:0;padding:10px 0px">View our homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contant);
$sender = $disput_user['trading_name'];	
$mailResponse  =  mailSend($other_user['email'], $sender, $subject, $mailBody);	

$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"'; 
$contant = '<p style="margin:0;padding:10px 0px">Hi '.$disput_user['f_name'] .',</p>';
$contant .= '<p style="margin:0;padding:10px 0px">You have cancelled and closed the milestone payment dispute claim for the job ' . $job['title'] . '.</p>';
$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $total_amount . '</p>';
$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to request milestone release if you have not yet done that..</p> <br>';
$contant .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div>';
$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';	
$mailBody = send_mail_app($contant);
$sender = $disput_user['trading_name'];	
$mailResponse  =  mailSend($disput_user['email'], $sender, $subject, $mailBody);		
	
	
} else { //cancelled by home owner

$subject = 'Milestone Payment Dispute was cancelled and closed: "' . $job['title'] . '"';
$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled and closed the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $total_amount . '</p>';
$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to ask them to release the milestone if they have not yet done that.</p>';
$contant .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/payments/?post_id=' . $job_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div>';
$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contant);
$sender = $disput_user['trading_name'];	
$mailResponse  =  mailSend($other_user['email'], $sender, $subject, $mailBody);	


$subject = 'Milestone Payment Dispute was  cancelled and closed:"' . $job['title'] . '"'; 
$contant = 'Hi '.$disput_user['f_name'] .',<br><br>';
$contant .= '<p style="margin:0;padding:10px 0px">You have cancelled and closed the milestone payment dispute claim for the job ' . $job['title'] . '.</p><br><br>';
$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $total_amount . '</p>';
$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p> <br><br>';
$contant .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';
$contant .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
	
$mailBody = send_mail_app($contant);
$sender = $disput_user['trading_name'];	
$mailResponse  =  mailSend($disput_user['email'], $sender, $subject, $mailBody);			
 
}
	
	
	
	
} else {
	$record=array('success'=>'false','msg'=>'Something went wrong, try again later.'); 
	jsonSendEncode($record);
}	
} else {
	$record=array('success'=>'false','msg'=>'Something went wrong, try again later.'); 
	jsonSendEncode($record);
}

$record=array('success'=>'true','msg'=>array('The case has been cancelled and closed successfully.'),'notification_arr'=>$notification_arr); 
jsonSendEncode($record);


