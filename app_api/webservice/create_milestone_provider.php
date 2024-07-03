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
$bid_by			 	=	$_GET['bid_by'];
$bid_id			 	=	$_GET['bid_id'];
$milestone_amount	=	$_GET['milestone_amount'];
$milestone_name	    =	$_GET['milestone_name'];


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


// ======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status FROM tbl_jobpost_bids WHERE  id= ? and status = 4");
$get_bid_details->bind_param('i',$bid_id);
$get_bid_details->execute();
$get_bid_details->store_result();
$get_bid_details_count=$get_bid_details->num_rows;  //0 1	
if($get_bid_details_count > 0){
	$get_bid_details->bind_result($id,$posted_by,$bid_by,$total_milestone_amount,$bid_amount,$propose_description,$delivery_days,$bid_by,$status);
	$get_bid_details->fetch();
	$bid_arr = array(
		'id'=>$id,
		'posted_by'=>$posted_by,
		'bid_by'=>$bid_by,
		'bid_amount'=>$bid_amount,
		'bid_by'=>$bid_by,
		'total_milestone_amount'=>$total_milestone_amount,
		'bid_status'=>$status,
		'delivery_days'=>$delivery_days,
	);
}

//get job details======================
$job_arr = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where job_id=?");
$getjobdetail->bind_param('i',$job_id);
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

if(count($bid_arr)>0 && count($job_arr)>0){
		$mile_amount  	= $bid_arr['total_milestone_amount'];
		$total_amt 		= $mile_amount+$milestone_amount;
		if($milestone_amount > $u_wallet) {
			$record		=	array('success'=>'false', 'msg'=> array('Insufficient amount in your wallet please recharge you wallet.','Insufficient amount in your wallet please recharge you wallet.'),'unable_amt'=>false); 
			jsonSendEncode($record);
		}else{
			// update mile stone table==============
			$cdate             = date('Y-m-d');
			$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `posted_user`, `created_by`,`bid_id`) VALUES (?,?,?,?,?,?,?,?)");
			$milestorneadd->bind_param("ssiisiii",$milestone_name,$milestone_amount,$user_id_get,$job_id,$cdate,$bid_arr['posted_by'],$user_id_get,$bid_id);	
			$milestorneadd->execute();
			$milestorneadd_affect_row=$mysqli->affected_rows;
            // update bid master==================
			$total_amt = $mile_amount+$milestone_amount;
			$key = 'total_milestone_amount='.$total_amt;
			$where = 'id='.$bid_id;
			$update_milestone1_affect_row = updatesingledata($key, 'tbl_jobpost_bids', $where);

			// update user master=======
			$u_wallet1      =  $u_wallet     - $milestone_amount;
			$spend_amount1  =  $spend_amount  + $milestone_amount;
			$signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=?,spend_amount=?  WHERE id=?");
			$signup_add->bind_param("ssi",$u_wallet1,$spend_amount1,$user_id);	
			$signup_add->execute();
			$signup_add_affect_row=$mysqli->affected_rows;
			if($signup_add_affect_row<=0){
				// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
				// jsonSendEncode($record);
			}

			$transactionid = md5(rand(1000,999).time());
			// update transaction table======================
			$tr_type = 2;
			$tr_status = 1;
			$updatetime =  date("Y-m-d H:i:s");
			$tr_message='£'.$milestone_amount.' has been debited to your wallet for creating a milestone to <a href="https://www.tradespeoplehub.co.uk/proposals?post_id='.$job_id.'">'.$job_arr['title'].'</a>';

			$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
			$transaction_add->bind_param("isiissss",$user_id,$milestone_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid);	
			$transaction_add->execute();
			$transaction_add_affect_row=$mysqli->affected_rows;
			if($transaction_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>$p_transaction_err); 
				jsonSendEncode($record);
			}

		}
}else{
	$record=array('success'=>'false','msg'=>array('Something went wrong try agin later.')); 
	jsonSendEncode($record);
}

$postData_new = getUserDetails($userid);
$otheruserDetails = getUserDetails($bid_by);


    $subject	=	'Your Milestone Payment created successfully: ' .$title;
    $html .= '<h style="margin:0;padding:10px 0px">Milestone Payment Made Successfully!</h>';
    $html .= '<p style="margin:0;padding:10px 0px">Hi ' . $postData_new['f_name'] .',</p>';
    $html .= '<p style="margin:0;padding:10px 0px">Your milestone payment to '.$otheruserDetails['trading_name'] .' created successfully. 
</p>';
  $html .= '<p style="margin:0;padding:10px 0px">Job title: '.$title.'</p>';
  $html .= '<p style="margin:0;padding:10px 0px">Milestone amount: £'.$milestone_amount.'</p>';
$html .= '<p style="margin:0;padding:0px 0px">Days to Complete: '.$bid_arr['delivery_days'].' day(s)</p>';
  $html .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to wait for the job completion. Once the task has been completed, and your 100% satisfied, release the milestone.  
</p>';
$html .= '<br><p style="margin:0;padding:10px 0px">View our Milestone Payment System page on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app_logo($html);


$email_arr[]=	array('email'=>$postData_new['email'], 'fromName'=>$postData_new['fromName'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($postData_new['email'],$postData_new['fromName'], $subject, $mailBody);
	
	


$subjectH = "Milestone Payment Made for ".$title; 
	
	$htmlH .= '<p style="margin:0;padding:10px 0px">Milestone Payment Made Successfully! </p>';
	
	$htmlH .= '<p style="margin:0;padding:10px 0px">Hi ' . $otheruserDetails['f_name'] .',</p>';

	$htmlH .= '<p style="margin:0;padding:10px 0px"> '.$postData_new['f_name'].' has made a milestone payment for the job '.$title.'.</p>';
	$htmlH .= '<p style="margin:0;padding:0px 0px">Milestone payment amount: £'.$milestone_amount.'</p>';
    $htmlH .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to complete the job for which the milestone was created. Once the task has been completed, the payment will be released to you. </p>';

$htmlH .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.
</p>';
	$mailBody = send_mail_app($htmlH);

	$mailResponse  =  mailSend($otheruserDetails['email'], $otheruserDetails['f_name'], $subjectH, $mailBody);

 $name=trim($postData_new['f_name']);

$notification_arr  = array();
    $action 		=	'request_milestone';
	$action_id 		=    $job_id;
	$title 			=	'You´ve received a milestone payment!';
    $title_push		=	'You´ve received a milestone payment!';
    $message_push   = $name.' has created a milestone payment.';
	$message 		= $name.' has created a milestone payment: <a>Amount £' .$milestone_amount .'</a>';
	$sender_id      =   $user_id;
	$receive_id 	=	$bid_by	; 
	$job_id			=   $job_id;
	$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
	$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
	if($notification_arr_get != 'NA'){
		$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
	}
 if (!empty($notification_arr)) {
       oneSignalNotificationSendtrades($notification_arr);
    }


$record=array('success'=>'true','msg'=>array('Success! Milestone has been created successfully.')); 
jsonSendEncode($record);

