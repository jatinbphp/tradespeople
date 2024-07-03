<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	//echo "string";
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	// Email
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_GET['job_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	//---------------------------get all variables--------------------------
	$user_id_post				= $_GET['user_id_post'];
	$job_id     				= $_GET['job_id'];
	$bid_id     				= $_GET['bid_id'];
	$status						=  $_GET['status'];
	$cdate						= date("Y-m-d H:i:s");
 	$tradesman_id               = 0;
 	 
	//get bid details==================
	$check_user_all	=	$mysqli->prepare("SELECT id,type,email,f_name from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get,$type_new,$email,$f_name);
 	$check_user_all->fetch();
 	  
		if(empty($status) && $type_new==1)
	 {
		 $status=0;
		 $msg_send = 'Job offer rejected successfully';
	 }else{
		//	$status=8;
		$status=1;	
	 	$msg_send = 'Job bid revoked successfully';
	 }

	//get bid details==================
 	$get_bid_record	=	$mysqli->prepare("SELECT id,total_milestone_amount,bid_by,hiring_type from tbl_jobpost_bids where id=?");
	$get_bid_record->bind_param("i",$bid_id);
	$get_bid_record->execute();
	$get_bid_record->store_result();
	$get_bid_record1		=	$get_bid_record->num_rows;  //0 1
	if($get_bid_record1 <= 0){
		$record		=	array('success'=>'false', 'msg'=>$bid_id_not_found); 
		jsonSendEncode($record);
	}
 	$get_bid_record->bind_result($bid_id,$total_milestone_amount,$bid_by,$hiring_type);
 	$get_bid_record->fetch();

 	//get bid details==================
	$get_job_record	=	$mysqli->prepare("SELECT userid,title from tbl_jobs where job_id=?");
	$get_job_record->bind_param("i",$job_id);
	$get_job_record->execute();
	$get_job_record->store_result();
	$get_job_record1		=	$get_job_record->num_rows;  //0 1
	if($get_job_record1 <= 0){
		$record		=	array('success'=>'false', 'msg'=>$job_id_not_found); 
		jsonSendEncode($record);
	}
 	$get_job_record->bind_result($homeuser_id,$title);
 	$get_job_record->fetch();
   //get home owner details==================
	$check_home_owner	=	$mysqli->prepare("SELECT spend_amount,u_wallet from users where id=?");
	$check_home_owner->bind_param("i",$homeuser_id);
	$check_home_owner->execute();
	$check_home_owner->store_result();
	$check_home_owner1	=	$check_home_owner->num_rows;  //0 1
	if($check_home_owner1 <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_home_owner->bind_result($spend_amount,$u_wallet);
 	$check_home_owner->fetch();
 //-------------------------------update job bid-----------------
 	$update_plan = $mysqli->prepare("UPDATE `tbl_jobs` SET `status`=?, `awarded_to`=? ,awarded_time=? WHERE  job_id=?  ");
	$update_plan->bind_param("iisi",$status,$tradesman_id,$cdate,$job_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}
 

 	$update_plan = $mysqli->prepare("DELETE FROM `tbl_jobpost_bids` WHERE id=?");
	$update_plan->bind_param("i",$bid_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}
	$delete = $mysqli->prepare("DELETE FROM `tbl_milestones` WHERE `bid_id`=?");
	$delete->bind_param("i",$bid_id);	
	$delete->execute();
	$delete_affect_row=$mysqli->affected_rows;
	if($delete_affect_row<=0){

	}

	if($total_milestone_amount>0){
		// update transaction ============
		$tr_type = 1;
		$tr_status = 1;
		$updatetime = date('Y-m-d h:i:s');
		if ($hiring_type == 1) {
			$tr_message = '£' . $total_milestone_amount . ' has been credited to your wallet as a result of '.$trading_name.' rejecting your job offer on <a href="https://www.tradespeoplehub.co.uk/details/?post_id=' . $job_id . '">' . $title . '.</a>';
		} else {
			$tr_message = '£' . $total_milestone_amount . ' has been credited to your wallet as a result of '.$trading_name.' rejecting your job offer on ' . $title . '';
		}
		$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_message`, `tr_created`, `tr_update`) VALUES (?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiisss",$homeuser_id,$total_milestone_amount,$tr_type,$tr_status,$tr_message,$updatetime,$updatetime);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>$p_transaction_err); 
			jsonSendEncode($record);
		}
		//update home owner wallet=================
		$spend_amount1 = $spend_amount-$total_milestone_amount;
		$u_wallet1 = $u_wallet+$total_milestone_amount;
		$signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=?,spend_amount=?  WHERE id=?");
		$signup_add->bind_param("ssi",$u_wallet1,$spend_amount1,$homeuser_id);	
		$signup_add->execute();
		$signup_add_affect_row=$mysqli->affected_rows;
		if($signup_add_affect_row<=0){
			// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
			// jsonSendEncode($record);
		}
	}
//------------------check bid--------------------------------------
	$homeOwner    = getUserDetails($homeuser_id);
	$provider_arr = getUserDetails($bid_by);
if($type_new==1)
	{
	$subject = "Unfortunately! ".$provider_arr['trading_name']." has declined your job offer for the job: “".$title."”";
					
	$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';

	$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! '.$provider_arr['trading_name'].' has declined to begin work on your project “'.$title.'”!</p>';

	$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can award the job to another tradesperson or increase your budget to attract more skilled tradespeople.</p>';

	$html .= '<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit</a> &nbsp; &nbsp; <a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Award</a></div>';

	$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
	$mailBody = send_mail_app($html);
    $mailResponse  =  mailSend($homeOwner['email'], $provider_arr['trading_name'], $subject, $mailBody);
}
//----------------provider---------------------------
	if($type_new==2)
	{
$subjectS = "Job offer on ".$title." has been retracted";
					
	$htmlS = '<p style="margin:0;padding:10px 0px">Hi ' . $provider_arr['f_name'] .',</p>';

	$htmlS .= '<p style="margin:0;padding:10px 0px">Your job offer by '.$homeOwner['f_name'].' has been retracted as you did not respond on time.</p>';

	$htmlS .= '<p style="margin:0;padding:10px 0px">Job: '.$title.'</p>';

	$htmlS .= '<p style="margin:0;padding:10px 0px">As your next step, you can discuss and ask  '.$homeOwner['f_name'].' to re-award you the job.</p>';
	$htmlS .= '<br><div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Discuss Now</a></div>';

	$htmlS .= '<br><p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service</p>';
	$mailBody = send_mail_app($htmlS);
    $mailResponse  =  mailSend($provider_arr['email'], $provider_arr['trading_name'], $subjectS, $mailBody);

	}

if($type_new==1)
{
	$subjectp = "Job offer declined successfully! ";
					
	$htmlP = '<p style="margin:0;padding:10px 0px">Hi ' . $provider_arr['f_name'] .',</p>';
    $htmlP .= '<p style="margin:0;padding:10px 0px">You have successfully declined the job offer '.$job_data['title'].'.</p>';
   $htmlP .= '<br><p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
	

	$mailBody = send_mail_app($htmlP);
  
		//end email temlete================
	$email_arr[]	=	array('email'=>$provider_arr['email'], 'fromName'=>$provider_arr['trading_name'], 'mailsubject'=>$subjectp, 'mailcontent'=>$mailBody);
	$mailResponse  =  mailSend($provider_arr['email'], $provider_arr['trading_name'], $subjectp, $mailBody);
}
	// notification====================
	$notification_arr  = array();
    $action 		=	'award_reject';
	$action_id 		=    $job_id;
	$title 			=	'Award reject';
    $title_push='Unfortunately! Your job offer has been declined!';
    $message_push ='Unfortunately!  '.$provider_arr['trading_name']. ' has declined to begin work on your project Job !';

	$message 		=	$provider_arr['trading_name'] .' has rejected your job offer.';
	$sender_id      =   $user_id_post;
	$receive_id 	=	$homeuser_id; 
	$job_id			=   $job_id;
	$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
	$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);

	if($notification_arr_get != 'NA'){
		$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				};
	}
	 if (!empty($notification_arr)) {
       oneSignalNotificationSendCall($notification_arr);
    }

	$record			=	array('success'=>'true', 'msg'=>array($msg_send),'notification_arr'=>'NA','mailResponse'=>$mailResponse); 
	jsonSendEncode($record); 
?>
 