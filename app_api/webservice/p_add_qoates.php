	<?php
		ini_set('display_errors', 0);
		include 'con1.php';
		include 'function_app_common.php'; 
		include 'function_app.php'; 
		include 'language_message.php';	
		include 'mailFunctions.php';


     	if(!$_POST){
			$record=array('success'=>'false','msg' =>$msg_post_method); 
			jsonSendEncode($record); 
		}
		// Email
		if(empty($_POST['user_id_post'])){
			$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
			jsonSendEncode($record); 
		}
		if(empty($_POST['amount'])){
			$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
			jsonSendEncode($record); 
		}

		if(empty($_POST['time'])){
			$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
			jsonSendEncode($record); 
		}
		if(empty($_POST['detail'])){
			$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
			jsonSendEncode($record); 
		}

     //---------------------------get all variables--------------------------
		$user_id_post				= $_POST['user_id_post'];
		$job_id     				= $_POST['job_id'];
		$quate_by     				= $_POST['quate_by'];

		$status						= 0;
		$posted_by					= $_POST['posted_by'];
		$bid_amount 				= $_POST['amount']; 
		$delivery_days 				= $_POST['time'];
		$propose_description 		= $_POST['detail']; 

		$milestone_arr 		        = $_POST['milestone_arr']; 
		if($milestone_arr!='NA'){
			$milestone_arr = json_decode($milestone_arr);
		}
		$cdate						= date("Y-m-d H:i:s");
        
    ///////// Get User Details
    $get_users = getUserDetails($user_id_post);
    $setting = getAdminDetails();
    if($get_users['u_email_verify']==1){
	if($setting['payment_method'] == 0 && empty($get_users['about_business'])){
		$profileUrl = 'https://www.tradespeoplehub.co.uk/edit-profile';
		$record	= array('success'=>'false', 'msg'=>'You can\'t submit a quote until you\'ve completed your profile. <a href="'.$profileUrl.'">Click here to complete it.</a>'); 
		jsonSendEncode($record);
		
		} else {
		
		$get_jobs = getJobDetails($job_id);
	    $get_commision=getAdminDetails();
	    $credit_amount=$get_commision['credit_amount'];
		$check = false;
		$update_wallet = false;
		$update_plan = false;
		$calculate_ref = true;
		if($user_id_post) {
			$get_plan_bids = getPlanDetails($user_id_post);
			$get_post_bid=get_post_bids($user_id_post,$job_id);
			if($get_post_bid!='NA'){
				$record	 = array('success'=>'false', 'msg'=>'You have already placed a quote on this job post.'); 
		jsonSendEncode($record);
				
			} else {
				if($setting['payment_method'] == 1){
								if($get_plan_bids!='NA') {
									if($get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) {
										if($get_plan_bids['bid_type']==2) {
											$check = true;
											if($get_plan_bids['up_amount']<=0){
												$calculate_ref = false;
											}
										} else if($get_plan_bids['bid_type']==1) {
											if($get_plan_bids['up_used_bid'] < $get_plan_bids['up_bid']) {
												$check = true;
												$update_plan = true;
												 
												if($get_plan_bids['up_amount']<=0){
													$calculate_ref = false;
												}

											} else if($get_users['u_wallet'] >= $credit_amount) {
												$check = true;
												$update_wallet = true;
												 
											} else {
										$record	 = array('success'=>'false', 'msg'=>'You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.'); 
		jsonSendEncode($record);		 
											}
										} else if($get_users['u_wallet'] >= $credit_amount){
											$check = true;
											$update_wallet = true;
											 
										} else {
											$record	 = array('success'=>'false', 'msg'=>'You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.'); 
		jsonSendEncode($record);		 
											
										}
									} else if($get_users['u_wallet'] >= $credit_amount){
										$check = true;
										$update_wallet = true;
										 
									} else {
										$record	 = array('success'=>'false', 'msg'=>'You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.'); 
		jsonSendEncode($record); 
										
									}
								} else if($get_users['u_wallet'] >= $credit_amount) {
									$check = true;
									$update_wallet = true;
									 
								} else {
									$record	 = array('success'=>'false', 'msg'=>'You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.'); 
		jsonSendEncode($record); 
									 
								}
							}else{
								$check = true;
							}
			       }
			
			if($check){
			   $paid_total_miles = 0;	
			// insert job bid =======================================
		$update_bid = $mysqli->prepare("INSERT INTO tbl_jobpost_bids(bid_amount, delivery_days, propose_description, bid_by, job_id, cdate, posted_by, status, update_date, paid_total_miles ) Values(?,?,?,?,?,?,?,?,?,?)");
		$update_bid->bind_param("sisiisiiss",$bid_amount,$delivery_days,$propose_description, $user_id_post, $job_id, $cdate, $posted_by, $status,$cdate, $paid_total_miles);	
		$update_bid->execute();
		$update_bid_affect_row=$mysqli->affected_rows;
		if($update_bid_affect_row<=0){
			$record=array('success'=>'false','msg'=>array('Job not inserted')); 
			jsonSendEncode($record);
		}

		$last_insert_id = $mysqli->insert_id;	
			
		if($calculate_ref){
			$earn_tradsman=earn_refer_to_tradsman($quate_by); //checking tradesmen invited
			$earn_homeowner=earn_refer_to_homeowner($posted_by);
		}
		 
		$get_post_user=getUserDetails($user_id_post);			
				
		// -----------self notification------------------
		$notification_arr  = array();
        $action 		=	'add_quote';
		$action_id 		=    $job_id;
		$title 			=	'New quote';
        $title_push='You´ve got a new quote. Review now!';      
        $message_push=''.$get_post_user['trading_name'] .' has just quoted your job post and awaits your responds. Please review the quote now!';
		$message 		=	'You have got a new quote from '.$get_post_user['trading_name'] .'. <a >View quote!</a>';
		$sender_id      =   $user_id_post;
		$receive_id 	=	$posted_by; 
		$job_id			=    $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		if($notification_arr_get != 'NA'){
			$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
			}
		}
				
	 if (!empty($notification_arr)) {
         $notiarr = oneSignalNotificationSendCall($notification_arr);
      }					
				
	////// Notification End ============================================
	
 /// Start Transaction	
if($update_wallet && $setting['payment_method'] == 1){	
	
$u_wallet=$get_users['u_wallet']-$credit_amount;
//// Update User Wallet
$upd_wall = $mysqli->prepare('UPDATE `users` SET `u_wallet`=? WHERE id=?');	
$upd_wall->bind_param('si',$u_wallet,$user_id_post);
$upd_wall->execute();
	
	
	$tr_type = 2;
	$tr_status = 1;
	$updatetime = date('Y-m-d h:i:s');
	$transactionid = md5(rand(1000,999).time());
	$tr_message='£'.$credit_amount.' has been debited to your wallet for placing a quote on <a href="https://www.tradespeoplehub.co.uk/proposals/?post_id='.$job_id.'">'.$get_jobs['title'].'.</a>';
	
			$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`, `tr_message`) VALUES (?,?,?,?,?,?,?,?)");
			$transaction_add->bind_param("ssssssss",$user_id_post,$credit_amount,$tr_type,$tr_transactionId,$tr_status,$updatetime,$updatetime,$tr_message);	
			$transaction_add->execute();
			$transaction_add_affect_row=$mysqli->affected_rows;
			if($transaction_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>$p_transaction_err); 
				jsonSendEncode($record);
			}
      }			
///// End ===============
if($update_plan){
$up_used_bid=$get_plan_bids['up_used_bid']+1;
$up_id=$get_plan_bids['up_id'];
$update4 = $mysqli->prepare('UPDATE `user_plans` SET `up_used_bid`=? WHERE up_id=?');	
$update4->bind_param('si',$up_used_bid,$up_id);
$update4->execute();	
}		
				
///// Email Send =================
	$get_post_user = getUserDetails($posted_by);			
		$subject = "You´ve got a new quote from ".$get_users['trading_name']." for the job:  ".$get_jobs['title'];
		$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_post_user['f_name'] .',</p>';
		$html .= '<p style="margin:0;padding:10px 0px">You´ve got a new quote from '.$get_users['trading_name'].'. Please review and discuss with them. If you think they´re the perfect fit for the work, award them the job.</p>';
		$html .= '<tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="10" width="100%"><tbody><tr><td align="left" valign="top" style="color:#444;font-size:14px"><tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">';
		$html .= get_profile_loop($quate_by,$job_id,$bid_amount);
		$html .= '</table></td></tr></td></tr></tbody></td></tr>';
		$html .= '<br><p style="margin:0;padding:10px 0px">We suggest not making decisions on price alone. Read their profiles and feedback to help you decide who to hire.</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($get_post_user['email'], $get_users['trading_name'], $subject, $mailBody);				
///// Owner Email Template				
				
$get_own_user = getUserDetails($user_id_post);
$subject = "Your quote was submitted successfully!";
$content .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_own_user['f_name'] .',</p>';
$content .= '<p style="margin:0;padding:10px 0px">Your quote on the job '.$get_jobs['title'].' was submitted successfully. '.$get_post_user['f_name'].' will review and discuss with you. </p>';
$content .= '<p style="margin:0;padding:10px 0px">We encourage you to follow the quote up by initiating a conversation with  '. $get_post_user['f_name'] .'. </p>';
$content .= '<br><div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/proposals/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Chat now
</a></div>';
$content .= '<br><p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.
</p>';
$mailBody = send_mail_app($content);			
$mailResponse  =  mailSend($get_own_user['email'], $get_users['trading_name'], $subject, $mailBody);				
//////////////////// Milestone 
$milestole_status  = 0;
$is_suggested      = 1;
$cdate             = date('Y-m-d');
if($milestone_arr!='NA'){
	foreach ($milestone_arr as $value) {
		$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`,`bid_id`,`is_suggested`) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$milestorneadd->bind_param("ssiisiiiii",$value->milestone_name,$value->milestone_amt,$quate_by,$job_id,$cdate,$milestole_status,$posted_by,$posted_by,$last_insert_id,$is_suggested);	
		$milestorneadd->execute();
		$milestorneadd_affect_row=$mysqli->affected_rows;
	}							
}		
				
////// End Milestone
				
		}
			
		 } else {
			
		$check = false;	
		$record	 = array('success'=>'false', 'msg'=>'Please login to place quote.'); 
		jsonSendEncode($record);
			
		 }
	  }
		
	} else {
		$record = array('success'=>'false', 'msg'=>'You can not submit a quote until you have verified your email address.'); 
		jsonSendEncode($record);
	}


$quate_added_status="yes";
$record	=array('success'=>'true','status'=>'noterror', 'msg'=>'Thank you for submitting your quote. The homeowner will review it and get back shortly.','quate_added_status'=>$quate_added_status,'last_insert_id'=>$last_insert_id,); 
		jsonSendEncode($record); 
?>