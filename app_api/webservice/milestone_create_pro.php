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
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status FROM tbl_jobpost_bids WHERE id=? and (status = 7 or status = 3 or status = 5 or status = 10)");
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
		'delivery_days'=>$delivery_days,
		'bid_by'=>$bid_by,
		'bid_status'=>$status,
		'total_milestone_amount'=>$total_milestone_amount,
	);
}

//get job details======================
$job_arr = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where  job_id=?");
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
		$bid_amount  	= $bid_arr['bid_amount'];
		$total_amt 		= $milestone_amount+$mile_amount;
		if($total_amt > $bid_amount) {
			$record		=	array('success'=>'false', 'msg'=> array('Sum of the total milestone amount should not be greater than total bid amount.')); 
			jsonSendEncode($record);
		}else{

			// update mile stone table==============
			$cdate             = date('Y-m-d');
			$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `posted_user`, `created_by`,`bid_id`) VALUES (?,?,?,?,?,?,?,?)");
			$milestorneadd->bind_param("ssiisiii",$milestone_name,$milestone_amount,$bid_by,$job_id,$cdate,$bid_arr['posted_by'],$user_id,$bid_id);	
			$milestorneadd->execute();
			$milestorneadd_affect_row=$mysqli->affected_rows;
		}
}else{
	$record=array('success'=>'false1','msg'=>array('Something went wrong try agin later.')); 
	jsonSendEncode($record);
}


  //$user_details  =   getUserDetails($otheruserid);
$has_email_noti = getUserDetails($user_id);
$trades         = getUserDetails($posted_by);					


	$subject = "Milestone Payment requested successfully!"; 
	

	
	$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $has_email_noti['f_name'] .',</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Your milestone payment request was successfully. </p>';
 $html .= '<p style="margin:0;padding:0px 0px">Milestone name: '.$milestone_name.'</p>';
  $html .= '<p style="margin:0;padding:0px 0px">Milestone payment amount:  £'.$milestone_amount.'</p>';
  $html .= '<br><div style="text-align:center"><a href="' .$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div><br>';
$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
	$mailBody = send_mail_app($html);

	$mailResponse  =  mailSend($has_email_noti['email'], $trades['trading_name'], $subject, $mailBody);



//------------------------for homeowner--------------------------------------------

	$subjectH = " Milestone Payment Creation request by ".$has_email_noti['trading_name']." for the job ".$job_arr['title']; 
	
	$htmlH .= '<p style="margin:0;padding:10px 0px">Request to create a milestone payment! </p>';
	
	$htmlH .= '<p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] .',</p>';

	$htmlH .= '<p style="margin:0;padding:10px 0px"> '.$has_email_noti['trading_name'].' has requested the creation of milestone payment for the job '.$job_arr['title'].'.</p>';
	$htmlH .= '<p style="margin:0;padding:0px 0px">Milestone Amount:  £'.$milestone_amount.'</p>';
    $htmlH .= '<p style="margin:0;padding:0px 0px>"Days to Complete:   day(s)'.$delivery_days.'</p>';
    $htmlH .= '<p style="margin:0;padding:10px 0px">Create a Milestone payment to guarantee you want to work with '.$has_email_noti['trading_name'].'. Tradespeople are 150% more likely to accept your project when you create a Milestone Payment. </p>';
$htmlH .= '<br><div style="text-align:center"><a href="' .$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create Milestone Now!</a></div><br>';
$htmlH .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
	$mailBody = send_mail_app($htmlH);

	$mailResponse  =  mailSend($trades['email'], $trades['f_name'], $subjectH, $mailBody);


	$get_user_details         = getUserDetails($bid_arr['bid_by']);	

	// notification====================
	$notification_arr  = array();
    $action 		=	'request_milestone';
	$action_id 		=    $job_id;
	$title 			=	'Request milestone';
    $title_push			=	'Request to create a milestone payment!';
    $message_push   =     $has_email_noti['trading_name'].' requested you create a milestone payment for the job being offered.
';
	$message 		=	 $has_email_noti['trading_name'].' has requested a milestone payment: <a>Amount £' .$milestone_amount .'</a>';
	$sender_id      =   $user_id;
	$receive_id 	=	$bid_arr['posted_by']; 
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
       oneSignalNotificationSendCall($notification_arr);
    }
	if(empty($notification_arr)){
		$notification_arr	=	'NA';
	}



$record=array('success'=>'true','msg'=>array('Success! Milestone request has been sent successfully.'),'notification_arr'=>'NA'); 
jsonSendEncode($record);

