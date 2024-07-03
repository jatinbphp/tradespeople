<?php	
ini_set('display_errors', 1);
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
$milestone_id	    =	$_GET['milestone_id'];
$dispute_id 	    =   $_GET['dispute_id'];

$users = getUserDetails($user_id);
if($users== 'NA'){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}

$row = get_dispute($dispute_id);

if($row== 'NA'){
	$record		=	array('success'=>'false', 'msg'=>'Dispute Not found.'); 
	jsonSendEncode($record);
}

if ($row['ds_buser_id'] != $user_id && $row['ds_puser_id'] != $user_id) {
$record	= array('success'=>'false', 'msg'=>'You are not authorized to add offer for this dispute.'); 
jsonSendEncode($record);
}

$dipute_by = $row['disputed_by'];
$dipute_to = $row['dispute_to'];
$job_id = $row['ds_job_id'];
$tradesman = $row['ds_buser_id'];
$homeowner = $row['ds_puser_id'];
$dispute_ids = $row['ds_id'];

$home = getUserDetails($homeowner);
$trades = getUserDetails($tradesman);
$milestones = getallmilestone($dispute_id);


if ($user_id == $tradesman) {
	$accname = $trades['trading_name'];
	$dispute_finel_user = $home['id'];
} else {
	$accname = $home['f_name'];
	$dispute_finel_user = $trades['id'];
}

$favo = getUserDetails($dispute_finel_user);

$massage = 'Dispute resolved as ' . $accname . ' accept and close.';
$dct_disputid = $dispute_ids;
$dct_userid = 0;
$dct_msg = $massage;
$dct_isfinal = 1;

$insert_dispute_conver = $mysqli->prepare("INSERT INTO `disput_conversation_tbl`( `dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`) VALUES (?,?,?,?)");
$insert_dispute_conver->bind_param("ssss",$dct_disputid,$dct_userid,$dct_msg,$dct_isfinal);	
$insert_dispute_conver->execute();
$insert_dispute_conver_affect_row=$mysqli->affected_rows;
$run = $mysqli->insert_id;
if($insert_dispute_conver_affect_row<=0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong.')); 
	jsonSendEncode($record);
}

if($run){
	////// Update Milestone
foreach($milestones as $milestone){
		$mile_status = 6;
		$mile_id = $milestone['id'];
    $mileupdate = $mysqli->query("UPDATE tbl_milestones SET status='$mile_status' WHERE id=$mile_id");
	}
	
	$ds_status = 1;
	$ds_favour = $dispute_finel_user;
	
	$get_job_post = getJobDetails($job_id);
	
	if ($user_id == $trades['id']) {
		   $amount = $row['homeowner_offer']*1;
		} else if ($user_id == $home['id']) {
			$amount = $row['tradesmen_offer']*1;
		} else {
			$amount = $row['total_amount'];
	   }
	
	 
	
	  $agreed_amount = ($amount > 0) ? $amount : $row['total_amount'];
	  $caseCloseStatus = 5;
	
	 $mileupdate = $mysqli->query("UPDATE `tbl_dispute` SET `ds_status`='$ds_status',ds_favour='$ds_favour',agreed_amount='$agreed_amount',caseCloseStatus='$caseCloseStatus' WHERE ds_id=$dispute_ids");
	
  if ($amount > 0) {
	  $setting = getAdminDetails();
	  $commision = $setting['commision'];
	  $get_post_job = get_bids_by_id($milestones[0]['bid_id']);
	   
	  $pamnt = $get_post_job['paid_total_miles'];
	  $final_amount = $pamnt + $amount;
	  
	  $sql3 = "update tbl_jobpost_bids set paid_total_miles = '" . $final_amount . "' where id = '" . $milestones[0]['bid_id'] . "'";
	 $mysqli->query($sql3);
	  
	$total = ($amount * $commision) / 100;
	$amounts = $amount - $total;
    $u_wallet = $trades['u_wallet'];
	$withdrawable_balance = $trades['withdrawable_balance'];
    $withdrawable_balance = $withdrawable_balance + $amounts;  
	  
	$userWlUpdate = $mysqli->query("UPDATE users SET withdrawable_balance='$withdrawable_balance' WHERE id='".$trades['id']."'");  
	  
	//////// Transaction 
	  $transactionid = md5(rand() . time());
	  $tr_userid = $trades['id'];
	  $tr_amount = $amounts;
	  $tr_type = 1;
	  $tr_transactionId = $transactionid;
	  $tr_message = $massage;
	  $tr_status = 1;
	  $tr_created = date('Y-m-d H:i:s');
	  $tr_update = date('Y-m-d H:i:s');
	  
	  $trans_query = $mysqli->query("INSERT INTO transactions SET tr_userid='$tr_userid',tr_amount='$tr_amount',tr_type='$tr_type',tr_transactionId='$tr_transactionId',tr_message='$tr_message',tr_status='$tr_status',tr_created='$tr_created',tr_update='$tr_update'");
	  
foreach($milestones as $milestone){
	$milesss = $mysqli->query("UPDATE tbl_milestones SET is_dispute_to_traders=1,admin_commission='$commision' WHERE id='".$milestone['id']."'");
	 } 
	  
	 if ($row['total_amount'] > $amount) {
		$remainingAmount = $row['total_amount'] - $amount;
		$u_wallet = $home['u_wallet'] + $remainingAmount;
	
	$userWlUpdate = $mysqli->query("UPDATE users SET u_wallet='$u_wallet' WHERE id='".$home['id']."'");   
	
	//////////////// Transaction	 
		 
    $transactionid = md5(rand(1000, 999) . time());
		$tr_userid = $home['id'];
		$tr_amount = $remainingAmount;
		$tr_type = 1;
		$tr_transactionId = $transactionid;
		$tr_message = 'Dispute resolved as ' . $accname . ' accept and close and the remaining amount credited in your wallet.';
		$tr_status = 1;
		$tr_created = date('Y-m-d H:i:s');
		$tr_update = date('Y-m-d H:i:s');
				
		$trans_query = $mysqli->query("INSERT INTO transactions SET tr_userid='$tr_userid',tr_amount='$tr_amount',tr_type='$tr_type',tr_transactionId='$tr_transactionId',tr_message='$tr_message',tr_status='$tr_status',tr_created='$tr_created',tr_update='$tr_update'");
	   
	}
	  
	$milestone_total = gettotalMilestone($job_id);
	$completed_milestone = gettotalcompletedMilestone($job_id);
	
	if($milestone_total==$completed_milestone){
		
	 $runss123 = $mysqli->query("UPDATE tbl_jobpost_bids SET status=4 WHERE id='".$get_post_job['id']."'"); 
	  
	 $runss12 = $mysqli->query("UPDATE tbl_jobs SET status=5 WHERE job_id='$job_id'");  
	
	}  
	  
	  
if ($final_amount >= $get_post_job['bid_amount']) {  
	
	////////////// Notification
$notification_arr  = array();
$action 		=	'Dispute_closed';
$action_id 		=    $job_id ;
$title 			=	'Dispute closed';
//$message 		=	'Congratulation this project has been completed successfully.<a href="https://www.tradespeoplehub.co.uk/profile/' . $home['id'] . '">' . $home['f_name'] . ' ' . $home['l_name'] . '</a> has released all the milestone amount of <a href="https://www.tradespeoplehub.co.uk/payments/?post_id=' . $get_post_job['job_id'] . '"> ' . $post_title . '</a> project and this project has been completed.Now you can go for rating by <a href="https://www.tradespeoplehub.co.uk/reviews/?post_id=' . $get_post_job['job_id'] . '">clicking here</a>.';
$message = 'Congratulations for your recent job completion! Please rate <a>'.$home['f_name'].' '.$home['l_name'].'.</a>';		
$sender_id      =   $get_post_job['posted_by'];
$receive_id 	=	$get_post_job['bid_by'];
$job_id			=   $job_id ;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if (!empty($notification_arr)) {
     oneSignalNotificationSendtrades($notification_arr);
}			
$post_title = $get_job_post['title'];		
/*mail to homeOwner*/
$subject = "Congratulations on Job Completion: “" . $post_title . "”";
$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';
$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $home['f_name'] . ',</p>';
$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “' . $post_title . '”! completed successfully and milestone payments released to ' . $trades['trading_name'] . '.</p>';
$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to ' . $trades['trading_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';
$html .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/reviews/?post_id=' . $get_post_job['job_id'] . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';
$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
		
$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($home['email'],$home['f_name'], $subject, $mailBody);		
		
/*mail to Tradesman*/
$subject = 'Congratulations on Completing the Job:' . $post_title;
$html1 = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
$html1 .= '<p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] . ',</p>';
$html1 .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “' . $post_title . '”! Your milestone payments has now been released and can be withdrawn. </p>';
$html1 .= '<p style="margin:0;padding:10px 0px">Please leave feedback for ' . $home['f_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';
$html1 .= '<div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/reviews/?post_id=' . $get_post_job['job_id'] . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';
$html1 .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';	
		
$mailBody = send_mail_app($html1);
$mailResponse  =  mailSend($trades['email'],$trades['f_name'], $subject, $mailBody);			
	
	////////////// Notification to Homeoner
$notification_arr  = array();
$action 		=	'Dispute_closed';
$action_id 		=    $job_id ;
$title 			=	'Dispute closed';
$message 		=	'Congratulations! Your job has been completed. <a href="https://www.tradespeoplehub.co.uk/reviews/?post_id=' . $get_post_job['job_id'] . '">Rate ' . $trades['trading_name'] . '!</a>';
$sender_id      =   $get_post_job['bid_by'];
$receive_id 	=	$get_post_job['posted_by'];
$job_id			=   $job_id ;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}	
if (!empty($notification_arr)) {
     oneSignalNotificationSendtrades($notification_arr);
}			
////////////// Notification to Tradesman
$notification_arr  = array();
$action 		=	'Dispute_closed';
$action_id 		=    $job_id ;
$title 			=	'Dispute closed';
//$message 		=	'Congratulation this project has been completed successfully. Homeowner has released all the milestone amount of <a href="https://www.tradespeoplehub.co.uk/payments/?post_id=' . $get_post_job['job_id'] . '"> ' . $post_title . '</a> project and this project has been completed. Now you can go for rating by <a href="https://www.tradespeoplehub.co.uk/reviews/?post_id=' . $get_post_job['job_id'] . '">clicking here</a>.';
		
$message = $home['f_name'].' '. $home['l_name'].' has released the milestone payment: <a>Amount £' . $amounts.'</a>';		
$sender_id      =   $get_post_job['posted_by'];
$receive_id 	=	$get_post_job['bid_by'];
$job_id			=   $job_id ;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if (!empty($notification_arr)) {
     oneSignalNotificationSendtrades($notification_arr);
}		
	 }  
  } else {
	  
	  $amounts = $row['total_amount'];
	  $u_wallet = $home['u_wallet'];
	  $u_wallet = $u_wallet + $amounts;
	 $userWlUpdate = $mysqli->query("UPDATE users SET u_wallet='$u_wallet' WHERE id='".$home['id']."'");      $transactionid = md5(rand(1000, 999) . time());
	 $tr_userid = $home['id'];
	 $tr_amount = $amounts;
	 $tr_type = 1;
	 $tr_transactionId = $transactionid;
	 $tr_message = $massage;
	 $tr_status = 1;
	 $tr_created = date('Y-m-d H:i:s');
	 $tr_update = date('Y-m-d H:i:s');
	  
	  /////////////// Transaction
	  
	 $trans_query = $mysqli->query("INSERT INTO transactions SET tr_userid='$tr_userid',tr_amount='$tr_amount',tr_type='$tr_type',tr_transactionId='$tr_transactionId',tr_message='$tr_message',tr_status='$tr_status',tr_created='$tr_created',tr_update='$tr_update'");
	   
	}
	
$subject = "Milestone payment dispute accepted and closed.";
$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $favo['f_name'] . ',</p>';
$contant .= '<p style="margin:0;padding:10px 0px">' . $accname . ' has accepted and closed the milestone payment dispute.</p>';
$contant .= '<p style="margin:0;padding:10px 0px">You don\'t need to do anything else - we wanted to keep you updated.</p>';
$contant .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
	
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($favo['email'],$favo['f_name'], $subject, $mailBody);	
	
$dispute_id = $dispute_ids;
$event_name = 'accept_and_close';
$event_data = [];
$data = serialize($event_data);
	
if($users['type']==1){
	$event_message = 'Tradesman accepted the offer of amount £'.$amount;
} else {
	$event_message = 'Homeowner accepted the offer of amount £'.$amount;
}	

$event_insert = $mysqli->query("INSERT INTO dispute_events SET dispute_id='$dispute_id',event_name='$event_name',data='$data',message='$event_message'");	

if($users['type'] == 1){
if ($amount > 0) {
	$nt_message = $trades['trading_name'].' has accepted your new offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$row['ds_id'].'">View Now</a>';
} else {
	$nt_message = $trades['trading_name'].' has accepted your offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$row['ds_id'].'">View Now</a>';	
}
  ////////////// Notification
$notification_arr  = array();
$action 		=	'Dispute_closed';
$action_id 		=    $job_id ;
$title 			=	'Dispute closed';
$message 		=	$nt_message;
$sender_id      =   $row['ds_buser_id'];
$receive_id 	=	$row['ds_puser_id'];
$job_id			=   $job_id ;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$player_id 			=	getUserPlayerId($receive_id);
	if($player_id !='no'){
	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
	}
}
if (!empty($notification_arr)) {
     oneSignalNotificationSendCall($notification_arr);
}	
if ($amount > 0) {
 $subject = $trades['trading_name']." accepted your new offer on the milestone dispute for the ".$get_job_post['title'];
} else {
	$subject = $trades['trading_name']." accepted your offer on the milestone dispute for the ".$get_job_post['title'];
 }

	$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $home['f_name'] . '</p>';
	if ($amount > 0) {
		$contant .= '<br><p style="margin:0;padding:10px 0px">'.$trades['trading_name'].' has accepted your new offer to settle the milestone dispute.</p>';
	} else {
		$contant .= '<br><p style="margin:0;padding:10px 0px">'.$trades['trading_name'].' has accepted your offer to settle the milestone dispute</p>';
	}
	$contant .= '<br><p style="margin:0;padding:10px 0px">They have accepted to settle for payment of:  £'.$row['homeowner_offer'].'</p>';
	if ($amount > 0) {
		$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed and the funds available to '.$trades['trading_name'].'</p>';
	} else {
	$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed and the funds returned to you.</p>';
	}
$contant .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
	

$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($favo['email'],$favo['f_name'], $subject, $mailBody);	
	
} else {
	//send to trademen
 ////////////// Notification
$nt_message = $home['f_name'].' '.$home['l_name'].' has accepted your offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$row['ds_id'].'">View Now</a>';	
$notification_arr  = array();
$action 		=	'Dispute_closed';
$action_id 		=    $job_id ;
$title 			=	'Dispute closed';
$message 		=	$nt_message;
$sender_id      =   $row['ds_puser_id'];
$receive_id 	=	$row['ds_buser_id'];
$job_id			=   $job_id ;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if (!empty($notification_arr)) {
     oneSignalNotificationSendtrades($notification_arr);
}	
$subject = $home['f_name'].' '.$home['l_name']." accepted your offer on the milestone dispute for the ".$get_job_post['title'];
$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] . '</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">'.$home['f_name'].' '.$home['l_name'].' has accepted your new offer to settle the milestone dispute.</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">They have accepted to settle for payment of:  £'.$row['tradesmen_offer'].'</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed. The funds is now available to you.</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';	
	
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($trades['email'],$trades['f_name'], $subject, $mailBody);		
		
  }
}

$record = array('success'=>'true', 'msg'=>'Dispute has been closed successfully.'); 
jsonSendEncode($record);