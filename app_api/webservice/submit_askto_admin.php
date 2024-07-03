<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'mailFunctions.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_GET['dispute_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id            = $_GET['user_id'];
$dispute_id         = $_GET['dispute_id'];

$setting = getAdminDetails();
$dispute = get_dispute($dispute_id);
$user = getUserDetails($user_id);

if($dispute=='NA'){
 $record=array('success'=>'false','msg'=>'Something went wrong, try again later.'); 
 jsonSendEncode($record);
}
if($dispute['ds_buser_id'] != $user_id && $dispute['ds_puser_id'] != $user_id) {
	$record=array('success'=>'false','msg'=>'Something went wrong, try again later.'); 
    jsonSendEncode($record);
}

$check = ask_admin_data($user_id,$dispute_id);
if ($check!='NA') {
	$record=array('success'=>'false','msg'=>'You already submitted your request to step in1.'); 
    jsonSendEncode($record);
}

    $user_type = $user['type'];
    if($user['u_wallet'] < $setting['step_in_amount']){
	$record=array('success'=>'false','msg'=>'Your last updated wallet amount is £'.$user['u_wallet'],'wallet'=>$user['u_wallet']); 
    jsonSendEncode($record);
	}
	$now = date('Y-m-d H:i:s');
	$expire_time = date('Y-m-d H:i:s',strtotime($now.' +'.$setting['arbitration_fee_deadline'].' day'));
    $amount = $setting['step_in_amount'];
	$created_at = $now;
	$updated_at = $now;
    $is_admin_read=0;
// insert Admin Step IN
$step_add = $mysqli->prepare("INSERT INTO `ask_admin_to_step`(`user_id`, `user_type`, `dispute_id`, `amount`, `created_at`, `updated_at`, `expire_time`, `is_admin_read`) VALUES (?,?,?,?,?,?,?,?)");
$step_add->bind_param("isssssss",$user_id,$user_type,$dispute_id,$amount,$created_at,$updated_at,$expire_time,$is_admin_read);	
	$step_add->execute();
    $run=$mysqli->affected_rows;

if($run > 0){
	$u_wallet=$user['u_wallet']-$setting['step_in_amount'];
	$other_user_id = ($user_id == $dispute['ds_buser_id']) ? $dispute['ds_puser_id'] : $dispute['ds_buser_id'];
	$other_user = getUserDetails($other_user_id);
	
   $checkOtherPay = ask_admin_data($other_user_id,$dispute_id);
	
	 
	$update3 = $mysqli->prepare('UPDATE `users` SET `u_wallet`=? WHERE id=?');
	$update3->bind_param('si',$u_wallet,$user_id);
	$update3->execute();
	
	$transactionid = md5(rand(1000,999).time());
	$tr_message='£'.$setting['step_in_amount'].' has been debited to your wallet for asking our arbitration team to step in.';
	 $tr_amount=$setting['step_in_amount'];
	 $tr_type=2;
	 $tr_transactionId=$transactionid;
	 $tr_status=1;
	 $tr_created= $now;
	 $tr_update = $now;
					
// insert Transaction
$trans_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_message`, `tr_status`, `tr_created`, `tr_update`) VALUES (?,?,?,?,?,?,?,?)");
	$trans_add->bind_param("isssssss",$user_id,$tr_amount,$tr_type,$tr_transactionId,$tr_message,$tr_status,$tr_created,$tr_update);	
$trans_add->execute();		
	
$name = ($user['type']==1) ? $user['trading_name'] : $user['f_name'] . ' ' . $user['l_name'];
$other_name = ($other_user['type']==1) ? $other_user['trading_name'] : $other_user['f_name'] . ' ' . $other_user['l_name'];	
	

	
	
if($checkOtherPay!='NA'){
	$dct_msg = '<p>'. $name.' has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.</br></br>Both of you have paid and asked us to step in and resolve the case.Please note that any decision reached by our team is final and irreversable.</p>';
	} else {
	$dct_msg = '<p>'. $name.' has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.</br></br>'.$other_name.' has '.$setting['arbitration_fee_deadline'].' day(s) to pay the fee - failure to do so will result in deciding the case in the favour of '.$name.'</p>';
	}	
	
$dct_disputid =  $dispute_id;
$dct_userid = -1;
$dct_msg = $dct_msg;
$dct_isfinal = 0;	
$message_to = ($checkOtherPay=='NA') ? $other_user['id'] : 0;	
$is_reply_pending = ($checkOtherPay=='NA') ? 1 : 0;	
$dct_update = $now;	
$end_time = ($checkOtherPay=='NA') ? $expire_time : NULL;	
	
// insert disput conversation
$idct_add = $mysqli->prepare("INSERT INTO `disput_conversation_tbl`(`dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`, `message_to`, `is_reply_pending`, `dct_update`, `end_time`) VALUES (?,?,?,?,?,?,?,?)");
	$idct_add->bind_param("isssssss",$dct_disputid,$dct_userid,$dct_msg,$dct_isfinal,$message_to,$is_reply_pending,$dct_update,$end_time);	
$idct_add->execute();	

$submit_msg = 'Your request to ask to admin is submitted successfully.';	

$event_name = 'ask-step-in';
$event_data = [
				
			];
$data = serialize($event_data);	
if($user['type']==1){
	$event_message = 'Tradesman has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.';
	} else {
	$event_message = 'Homeowner has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.';
  }	
$message = $event_message;	
	
// insert Event Data
$evnt_add = $mysqli->prepare("INSERT INTO `dispute_events`(`dispute_id`, `event_name`, `user_id`, `data`, `message`) VALUES (?,?,?,?,?)");
$evnt_add->bind_param("issss",$dispute_id,$event_name,$user_id,$data,$message);	
$evnt_add->execute();	
	
if($user['type']==1){
	$nt_userId = $dispute['ds_puser_id'];
	if($checkOtherPay!='NA'){
		$message = 'We have received '.$user['trading_name'].' arbitration fee payment. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View Now</a>';
	} else {
		$message = 'We have received '.$user['trading_name'].' arbitration fee and awaits yours. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View & Respond</a>';
	}
$nt_satus = 0;
$nt_apstatus = 2;
$nt_create = date('Y-m-d H:i:s');
$nt_update = date('Y-m-d H:i:s');
$job_id = $dispute['ds_job_id'];
$posted_by = $dispute['ds_puser_id'];	

// insert notification
$action_id 	 =    $job_id ;
$action  =	'Dispute_arbitrate';
$title   =	'Dispute Arbitrate';	
$sender_id      =   $user_id;
$receive_id 	=	$dispute['ds_puser_id'];
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}		
if (!empty($notification_arr)) {
        oneSignalNotificationSendtrades($notification_arr);
}	
	
if($checkOtherPay!='NA'){
					
					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

//send to trademen
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($user['email'], $user['trading_name'], $subject, $mailBody);	

					$subject = "Arbitration fees payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['trading_name'].' arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
		
	// send to homeowner
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($other_user['email'], $user['trading_name'], $subject, $mailBody);		
					
				} else {
	
					$subject = "Arbitration fee payment for dispute team to step-in received!";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration payment and awaits for '.$other_name.' payment. Once the other party make a payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">'.$other_name.' has until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make payment. If their payment is not received before this time, the case will automtiaclly closed and decided in your favour.</p>';

					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
	//send to trademen
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($user['email'], $user['trading_name'], $subject, $mailBody);	

					$subject = "Reminder:Arbitration payment for dispute team to step-in not received";
					$html = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$html .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['trading_name'].' arbitration fee payment and awaits yours. Once you have made a payment, our arbitration team will step in and decides on the case.</p>';
					$html .= '<br><p style="margin:0;padding:10px 0px">You have until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make a payment. If your payment is not received before this time, the case will automtiaclly close and decided in '.$user['trading_name'].' favour. </p>';
					$html .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen</p>';
					$html .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

// send to homeowner
$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($other_user['email'], $user['trading_name'], $subject, $mailBody);	
	
	 }
	
	
} else {
	
//send to trademen	
$nt_userId = $dispute['ds_buser_id'];
if($checkOtherPay!='NA'){
$message = 'We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee payment. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View Now</a>';
	} else {
$message = 'We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee and awaits yours. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View & Respond</a>';

  }	
	
$nt_satus = 0;
$nt_apstatus = 2;
$nt_create = date('Y-m-d H:i:s');
$nt_update = date('Y-m-d H:i:s');
$job_id = $dispute['ds_job_id'];
$posted_by = $dispute['ds_puser_id'];	
	
// insert notification
$action_id 	 =    $job_id ;
$action  =	'Dispute_arbitrate';
$title   =	'Dispute Arbitrate';	
$sender_id      =   $user_id;
$receive_id 	=	$dispute['ds_puser_id'];
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if (!empty($notification_arr)) {
        oneSignalNotificationSendtrades($notification_arr);
}	
	
/// Notification	
	
$nt_userId = $dispute['ds_puser_id'];
if($checkOtherPay!='NA'){
	$nt_message = 'You and '.$other_name.' have paid the arbitration fee and our team will now step in. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View Now</a>';
				} else {
	$nt_message = 'We have received your arbitration payment and awaits for '.$other_name.' payment. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$dispute['ds_id'].'">View Now</a>';
	}	
	
$nt_satus = 0;
$nt_apstatus = 2;
$nt_create = date('Y-m-d H:i:s');
$nt_update = date('Y-m-d H:i:s');
$job_id = $dispute['ds_job_id'];
$posted_by = $dispute['ds_puser_id'];
	
	
// insert notification
$action_id 	 =    $job_id ;
$action  =	'Dispute_arbitrate';
$title   =	'Dispute Arbitrate';	
$sender_id      =   $user_id;
$receive_id 	=	$dispute['ds_puser_id'];
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}		
if (!empty($notification_arr)) {
        oneSignalNotificationSendtrades($notification_arr);
}		
if($checkOtherPay!='NA'){

					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
//send to homeowner
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($user['email'], $user['trading_name'], $subject, $mailBody);		
					
					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		//send to trademen
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($other_user['email'], $user['trading_name'], $subject, $mailBody);			


				} else {
					$subject = "Reminder:Arbitration fee payment for dispute team to step-in not received!";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['f_name'].' '.$user['l_name'].' arbitration payment and awaits yours. Once you make your payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">You have until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make payment. If your payment is not received before this time, the case will automtiaclly closed and decided in '.$user['f_name'].' '.$user['l_name'].' favour. </p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		//send to trademen
$mailBody = send_mail_app($contant);
$mailResponse  =  mailSend($other_user['email'], $user['trading_name'], $subject, $mailBody);			



					$subject = "Arbitration payment for dispute team to step in received";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration payment and awaits for ' . $other_user['f_name'] . ' payment. Once they´ve made a payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">' . $other_user['f_name'] . ' has until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make a payment. If their payment is not received before this time, the case will automtiaclly closed and decided in your favour. </p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
	// send to home
	$mailBody = send_mail_app($contant);
    $mailResponse  =  mailSend($user['email'], $user['trading_name'], $subject, $mailBody);
	
	     }
     }
	
} else {
	$record=array('success'=>'false','msg'=>'You already submitted your request to step in.'); 
    jsonSendEncode($record);
}

$record=array('success'=>'true','msg'=>'Your request to ask to admin is submitted successfully.'); 
jsonSendEncode($record);