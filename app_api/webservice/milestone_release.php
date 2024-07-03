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
	$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
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


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
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



//milestone======================================
$milestone_arr = array();
$getMileStone =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE  id=?");
$getMileStone->bind_param("i",$milestone_id);
$getMileStone->execute();
$getMileStone->store_result();
$getMileStone_row = $getMileStone->num_rows;  //0 1
if($getMileStone_row > 0){
	$getMileStone->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested);
	$getMileStone->fetch();
 
	$milestone_arr = array(
		 'id'=> $id,
		 'milestone_name'=> $milestone_name,
		 'milestone_amt'=> $milestone_amount,
		 'userid'=> $userid,
		 'post_id'=> $post_id,
		 'cdate'=> $cdate,
		 'status'=> $status, 
		 'posted_user'=> $posted_user,
		 'created_by'=> $created_by,
		 'reason_cancel'=> $reason_cancel,
		 'dct_image'=> $dct_image,
		 'decline_reason'=> $decline_reason,
		 'bid_id'=> $bid_id,
		 'is_requested'=> $is_requested,
		 'is_dispute_to_traders'=> $is_dispute_to_traders,
		 'is_suggested'=> $is_suggested,
	);
}


//bid======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status,paid_total_miles FROM tbl_jobpost_bids WHERE  id= ? and (status = 4 or status = 7 or status = 3 or status = 5 or status = 10)");
$get_bid_details->bind_param('i',$bid_id);
$get_bid_details->execute();
$get_bid_details->store_result();
$get_bid_details_count=$get_bid_details->num_rows;  //0 1	
if($get_bid_details_count > 0){
	$get_bid_details->bind_result($id,$posted_by,$bid_by,$total_milestone_amount,$bid_amount,$propose_description,$delivery_days,$bid_by,$status,$paid_total_miles);
	$get_bid_details->fetch();
	$bid_arr = array(
		'id'=>$id,
		'posted_by'=>$posted_by,
		'bid_by'=>$bid_by,
		'bid_amount'=>$bid_amount,
		'bid_by'=>$bid_by,
		'total_milestone_amount'=>$total_milestone_amount,
		'bid_status'=>$status,
		'paid_total_miles'=>$paid_total_miles,
	);
}

//get job details======================
$job_arr = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where  userid=? and job_id=?");
$getjobdetail->bind_param('ii',$user_id,$job_id);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
// echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
	$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete);
	$getjobdetail->fetch();
	$job_arr = array(
		'job_id'		=>  $id, 
		'project_id'    =>  $project_id, 
		'title'  		=>	$title, 
		'budget'  		=>	$budget, 
		'budget2'  		=>	$budget2, 
		'category'		=>	$category, 
		'description'	=>	$description, 
		'userid'		=>	$userid, 
		'status'		=>	$status,
		'post_code'		=>  $post_code		
	);
}

$bid_by             =       $bid_arr['bid_by'];
$notification_arr   =       array();

//echo $bid_by;
if($getMileStone_row > 0) {
	$amount         = $milestone_arr['milestone_amt'];
	$pamnt  		= $bid_arr['paid_total_miles'];
	$final_amount   = $amount+$pamnt;
	if($milestone_arr['status']==0 || $milestone_arr['status']==3) {
		// update paid amount in bid master==========

			$d = date('Y-m-d H:i:s');
			$update2     =   $mysqli->prepare('UPDATE tbl_jobpost_bids SET paid_total_miles=?  WHERE id=?');
			$update2->bind_param('si',$final_amount,$bid_id);
			$update2->execute();
			$update2_affect_row=$mysqli->affected_rows;
//update milestone=========
			$update2     =   $mysqli->prepare('UPDATE tbl_milestones SET status=2  WHERE id=?');
			$update2->bind_param('i',$milestone_id);
			$update2->execute();
			$update2_affect_row=$mysqli->affected_rows;

		// get admin detail======
		$admin_details      =       getAdminDetails();
		$commision          =       $admin_details['commision'];
		$total   			= 		($amount*$commision)/100;
		$amounts            = 		$amount-$total;

		$homeowner          =       $bid_arr['posted_by'];
		$homeowner_id       =       $bid_arr['posted_by'];
		$bid_by             =       $bid_arr['bid_by'];


		$get_homeuser       =       getUserDetails($homeowner_id);
		$bidder_user        =       getUserDetails($bid_by);
		
		$d = date('Y-m-d H:i:s');
		$milestone_total = gettotalMilestone($job_id);
	    $completed_milestone = gettotalcompletedMilestone($job_id);
		
		if($milestone_total==$completed_milestone){
		   	$runss123 = $mysqli->query("UPDATE tbl_jobpost_bids SET status=4,update_date='$d' WHERE id='$bid_id'"); 
	  
	 $runss12 = $mysqli->query("UPDATE tbl_jobs SET status=5,update_date='$d' WHERE job_id='$job_id'");  
		}
		
	
		if($final_amount >= $bid_arr['bid_amount']) {
			
			// notification======================
			$action 		=	'job_complete';
			$action_id 		=    $job_id;
			$title 			=	'Job completed';
			$message 		=	'Congratulations for your recent job completion! Please rate '.$get_homeuser['f_name'].' '.$get_homeuser['l_name'].'.';
			$sender_id      =   $bid_arr['posted_by'];
			$receive_id 	=	$bid_arr['bid_by'];
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'title'=>$title, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_get != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
				if($player_id !='no'){
				$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
				}
			}
         if (!empty($notification_arr)) {
         $notiarr = oneSignalNotificationSendCall($notification_arr);
      }	

			$action 		=	'job_complete';
			$action_id 		=    $job_id;
			$title 			=	'Job completed';
			$message 		=	'Congratulations! Your job has been completed. Rate ' .$bidder_user['trading_name'] .'!';
			$sender_id      =   $bid_arr['bid_by'];
			$receive_id 	=	$bid_arr['posted_by'];
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$title, $action_data);
			
			if($notification_arr_get != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
			}
			}
			
			if (!empty($notification_arr)) {
                 $notiarr = oneSignalNotificationSendCall($notification_arr);
              }	

			// end notification=======================================
			// mail==================================================
			$subject = "Congratulations on Completing the Job: “".$job_arr['title']."”";
		
			$html .= '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Hi '.$bidder_user['f_name'].',</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “'.$job_arr['title'].'”! Your milestone payments has now been released and can be withdrawn. </p>';
			$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for '.$get_homeuser['f_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
 $html .= '<br><div style="text-align:center"><a href="' .$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div><br>';
	$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$mailBody = send_mail_app($html);
			$mailResponse  =  mailSend($bidder_user['email'], $get_homeuser['f_name'], $subject, $mailBody);


			$subject1 = "Congratulations on Job Completion: “".$job_arr['title']."”";
			$html1 .= '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';
			
			$html1 .= '<p style="margin:0;padding:10px 0px">Hi '.$get_homeuser['f_name'].',</p>';
			
			$html1 .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “'.$job_arr['title'].'”! completed successfully and milestone payments released to '.$bidder_user['trading_name'].'.</p>';
			$html1 .= '<p style="margin:0;padding:10px 0px">Please leave feedback to '.$bidder_user['trading_name'].' to help other Tradespeoplehub members know what it was like to work with them.</p>';
			
			$html1 .= '<div style="text-align:center"><a href='.$homeownerNew.' style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';
			
			$html1 .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>'; 
			$mailBody1 = send_mail_app($html1);
			$mailResponse  =  mailSend($get_homeuser['email'], $bidder_user['f_name'], $subject1, $mailBody1);
			
		} 
		
		/// Reffer n Earn
		
		 $setting = adminsettings(3);
		
		// $record=array('success'=>'false','msg'=>$setting); 
		// jsonSendEncode($record);
		
		$settings = getAdminDetails();
		
		if($settings['payment_method'] == 0){
			
			earn_refer_to_tradsman_pd($bid_by, $amount); //checking tradesmen invited
		    earn_refer_to_homeowner_pd($bid_arr['posted_by'], $amount);//checking homeowner invited	
		
		}
		
		
		$user_bid_by = getUserDetails($bid_by);
		// wallet update=======
		$u_wallet1=$user_bid_by['withdrawable_balance']+$amounts;
		
		$update3     =   $mysqli->prepare('UPDATE users SET withdrawable_balance=?  WHERE id=?');
		$update3->bind_param('si',$u_wallet1,$bid_by);
		$update3->execute();
		$update3_affect_row=$mysqli->affected_rows;

		// update transaction master===============
		$transactionid = md5(rand(1000,999).time());
			// update transaction table======================
		$tr_type = 1;
		$tr_status = 1;
		$updatetime =  date("Y-m-d H:i:s");
	//	$tr_message='£'.$milestone_amount.' has been released and credited to your wallet .Job ID: <a>'.$job_arr['title'].'</a> on date '.date('d-m-Y h:i:s A');
		$tr_message = '£' . $milestone_amount . ' has been released and credited to your wallet .Job ID: <a href="https://www.tradespeoplehub.co.uk/payments/?post_id=' . $job_arr['job_id'] . '">'.$job_arr['title'].'</a>';
		
		$action 		=	'milestone_released';
		$action_id 		=    $job_id;
		$sender_id      =   $bid_arr['posted_by'];
		$receive_id 	=	$bid_arr['bid_by'];
		$job_id			=   $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		$action_json = json_encode($action_data);

		$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId,action,action_id,action_json) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiisssssss",$bid_by,$amounts,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid,$action,$action_id,$action_json);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>$p_transaction_err); 
			jsonSendEncode($record);
		}

        $has_email_noti = getUserDetails($bid_arr['bid_by']);
		$subjectT = $get_homeuser['f_name'].", Released the Milestone Payment for “".$job_arr['title']."”";
			
			$htmlT .= '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone Payment Released!</p>';
			$htmlT .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
			$htmlT .= '<p style="margin:0;padding:10px 0px">'.$get_homeuser['f_name'].' has released a milestone payment for the job “'.$job_arr['title'].'.” </p>';
			$htmlT .= '<p style="margin:0;padding:10px 0px">Milestone payment released amount:  £ '.$amount.'</p>';
			$htmlT .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to transfer the money to your UK bank account. </p>';
			$htmlT .= '<p style="margin:0;padding:10px 0px">View our Tradesperpeople help page or contact our customer services if you have any specific questions using our service.</p>';
			$mailBody = send_mail_app($htmlT);
			$mailResponse  =  mailSend($has_email_noti['email'], $get_homeuser['f_name'], $subjectT, $mailBody);
			
		
		
		$subjectR = "You´ve successfully released Milestone Payment to ".$bidder_user['trading_name']." for “".$job_arr['title']."”."; 
				
		
		$htmlR .= '<p style="margin:0;padding:10px 0px">Milestone Payment Released Successfully!</p>';
		
		$htmlR .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_homeuser['f_name'] .',</p>';

		$htmlR .= '<p style="margin:0;padding:10px 0px">Your milestone payment has been released successfully to '.$bidder_user['trading_name'].'.</p>';
		
		$htmlR .= '<p style="margin:0;padding:0px 0px">Job: '.$job_arr['title'].'</p>';
		
		$htmlR .= '<p style="margin:0;padding:0px 0px">Milestone released amount: £'.$amount.'</p>';
		
		
		$htmlR .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
		
		$mailBody = send_mail_app($htmlR);
		$mailResponse  =  mailSend($get_homeuser['email'], $bidder_user['f_name'], $subjectR, $mailBody);
        
		$action 		=	'milestone_released';
		$action_id 		=    $job_id;
		$title 			=	'Job completed';
		$message 		=	$get_homeuser['f_name'].' '.$get_homeuser['l_name'].' has released the milestone payment: <a>Amount £'.$amount.'</a>';
		$message_push =  $get_homeuser['f_name'].' has release your milestone payments.';
     	$title_push = 'You´ve received a milestone payment!';
		$sender_id      =   $bid_arr['posted_by'];
		$receive_id 	=	$bid_arr['bid_by'];
		$job_id			=   $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get_send	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		
		if($notification_arr_get_send != 'NA'){
		    $player_id 	 =	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr_diff[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
		}
		 if (!empty($notification_arr_diff)) {
           oneSignalNotificationSendtrades($notification_arr_diff);
         }


	}
	
	if(empty($notification_arr)){
		$notification_arr	=	'NA';
	}
	
	$record=array('success'=>'true','msg'=>array('Success! Amount has been released successfully.','Success! Amount has been released successfully.'),'notification_arr'=>$notification_arr); 
			jsonSendEncode($record);
	// here return success method=======

}else{
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong try again later.')); 
	jsonSendEncode($record);
}
 


