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
if(empty($_GET['dispute_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}


$user_id	     	=	$_GET['user_id'];
$job_id			 	=	$_GET['job_id'];
$dispute_id 	    =   $_GET['dispute_id'];



$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,type,email,f_name,l_name,	trading_name from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$user_type,$email,$f_name,$l_name,$trading_name);
$check_user_all->fetch();

// Ger Dispute ================================
$dis_all	=	$mysqli->prepare("SELECT ds_id,ds_in_id,ds_job_id,ds_buser_id,ds_puser_id,ds_status,ds_comment,dispute_to,homeowner_offer,tradesmen_offer from tbl_dispute where ds_id=?");
$dis_all->bind_param("i",$dispute_id);
$dis_all->execute();
$dis_all->store_result();
$check_user		=	$dis_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$dis_all->bind_result($dis_id,$ds_in_id,$ds_job_id,$ds_buser_id,$ds_puser_id,$ds_status,$ds_comment,$dispute_to,$homeowner_offer,$tradesmen_offer);
$dis_all->fetch();

/// Get First Reply===============
$repl_all	=	$mysqli->prepare("SELECT dct_id,dct_disputid,dct_userid,dct_msg,dct_created FROM disput_conversation_tbl where dct_disputid=? AND dct_userid=? ORDER BY dct_created,dct_id ASC ");
$repl_all->bind_param("ii",$dis_id,$dispute_to);
$repl_all->execute();
$repl_all->store_result();
$check_reply		=	$repl_all->num_rows;  //0 1
if($check_reply <= 0){
	$record		=	array('success'=>'false', 'is_reply'=> '0', 'msg'=>'Please reply before rejecting offer'); 
	jsonSendEncode($record);
}
$repl_all->bind_result($dct_id,$dct_disputid,$dct_userid,$dct_msg,$dct_created);
$repl_all->fetch();


//Dispute Reject======================================
if ($ds_buser_id != $user_id && $ds_puser_id != $user_id) {
		 $record =	array('success'=>'false', 'is_reply'=> '0', 'msg'=>'You are not authorized to add offer for this dispute.'); 
	jsonSendEncode($record);
	
   }



///// Dispute Update============================

if($user_type == 1) {
$offer_rejected = 2;
$update3 = $mysqli->prepare('UPDATE `tbl_dispute` SET `offer_rejected_by_tradesmen`=? WHERE ds_id=?');	
} else {
$update3 = $mysqli->prepare('UPDATE `tbl_dispute` SET `offer_rejected_by_homeowner`=? WHERE ds_id=?');	
$offer_rejected = 2;
}
$update3->bind_param('si',$offer_rejected,$dispute_id);
$update3->execute();
$update3_affect_row = $mysqli->affected_rows;
if($update3_affect_row <= 0){
	//$record=array('success'=>'false3','msg'=>array('Error! Something went wrong please try again later.')); 
//	jsonSendEncode($record);
}

/////////////
$event_name = 'new_offer';
$event_data = ['amount'=>$homeowner_offer];
$data = serialize($event_data);
if($user_type==1){
	$event_message = 'Tradesman rejected Homeowner offer of amount £'.$homeowner_offer;
} else {
	$event_message = 'Homeowner rejected Tradesman offer of amount £'.$homeowner_offer;
}
$message = $event_message;

	// insert Dispute Event
	$evnt_add = $mysqli->prepare("INSERT INTO `dispute_events`(`dispute_id`, `event_name`, `user_id`, `data`, `message`) VALUES (?,?,?,?,?)");
	$evnt_add->bind_param("isiss",$dispute_id,$event_name,$user_id,$data,$message);	
	$evnt_add->execute();
	$evnt_add_row = $mysqli->affected_rows;
	if($evnt_add_row<=0){
		//$record=array('success'=>'false','msg'=>'Something Went Wrong!!'); 
		//jsonSendEncode($record);
	}

/////////// Notification
$userdata = getUserDetails($user_id); 
if($user_type == 1){
$action  =	'Dispute_reject';
$action_id 	 =    $job_id ;
$title       =	'Dispute Reject';
$nt_userId = $ds_puser_id;
$message = $userdata['trading_name'].' has rejected your new offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View & Respond</a>';
$nt_satus = 0;
$nt_apstatus = 2;
$nt_create = date('Y-m-d H:i:s');
$nt_update = date('Y-m-d H:i:s');
$job_id = $ds_job_id;
$posted_by = $ds_puser_id;	
$sender_id      =   $user_id;
$receive_id 	=	$ds_puser_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}	
if (!empty($notification_arr)) {
        oneSignalNotificationSendtrades($notification_arr);
 }		
$job_data = getJobDetails($ds_job_id);	
$reciever = getUserDetails($ds_puser_id); 	
	
$subject = $userdata['trading_name']." rejected a new offer on the milestone dispute for the ".$job_data['title'];	
	
$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['trading_name'].' has rejected your new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are not willing to settle for payment of:  £'.$homeowner_offer.'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can adjust your offer by clicking on the adjust offer button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/dispute/' . $ds_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Adjust Offer Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';	
	
$mailBody = send_mail_app($contant);	
$mailResponse  =  mailSend($reciever['email'],$reciever['f_name'], $subject, $mailBody);	
	
	
} else {
	
$action  =	'Dispute_reject';
$action_id 	 =    $job_id ;
$title       =	'Dispute Reject';
$nt_userId = $ds_buser_id;
$message = $userdata['f_name'].' '.$userdata['l_name'].' has rejected your new offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View & Respond</a>';
$nt_satus = 0;
$nt_apstatus = 2;
$nt_create = date('Y-m-d H:i:s');
$nt_update = date('Y-m-d H:i:s');
$posted_by = $ds_puser_id;	
$sender_id      =   $user_id;
$receive_id 	=	$ds_buser_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}	
if (!empty($notification_arr)) {
        oneSignalNotificationSendtrades($notification_arr);
      }		
	
$job_data = getJobDetails($ds_job_id);	
$reciever = getUserDetails($ds_buser_id); 		

$subject = $userdata['f_name'].' '.$userdata['l_name']." rejected an offer on the milestone dispute for the ".$job_data['title'];

$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['f_name'].' '.$userdata['l_name'].' has rejected your new offer to settle the milestone dispute.</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">They are not willing to settle for payment of:  £'.$tradesmen_offer.'</p>';
$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can adjust your offer by clicking on the adjust button below.</p>';

$contant .= '<br><div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/dispute/' . $ds_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Adjust Offer Now</a></div><br>';

$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';	
	
$mailBody = send_mail_app($contant);	
$mailResponse  =  mailSend($reciever['email'],$reciever['f_name'], $subject, $mailBody);	
	
	
}
	

$record=array('success'=>'true','msg'=>'Your offer has been rejected successfully.','is_reply'=> '1'); 
jsonSendEncode($record);
