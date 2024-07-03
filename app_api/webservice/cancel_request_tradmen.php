<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';

if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_post_method); 
	jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id	     	=	$_POST['user_id'];
$job_id			 	=	$_POST['job_id'];
$bid_id			 	=	$_POST['bid_id'];
$milestone_id	    =	$_POST['milestone_id'];



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



//milestone======================================
$milestone_arr = array();
$getMileStone =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE  id=?");
$getMileStone->bind_param("i",$milestone_id);
$getMileStone->execute();
$getMileStone->store_result();
$getMileStone_row = $getMileStone->num_rows;  //0 1
if($getMileStone_row > 0){
	$getMileStone->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel1, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested);
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
		 'reason_cancel'=> $reason_cancel1,
		 'dct_image'=> $dct_image,
		 'decline_reason'=> $decline_reason,
		 'bid_id'=> $bid_id,
		 'is_requested'=> $is_requested,
		 'is_dispute_to_traders'=> $is_dispute_to_traders,
		 'is_suggested'=> $is_suggested,
	);
}

// image uploade======

//$cancel_img1 = 'UPDATE tbl_milestones SET status=4,reason_cancel='.$reason_cancel.',dct_image='.$cancel_img.'  WHERE id='.$milestone_id;
//$record=array('success'=>'false','msg'=>array($cancel_img1)); 
//jsonSendEncode($record);

$d = date('Y-m-d H:i:s');

$update2     =   $mysqli->prepare('Delete from tbl_milestones  WHERE id=?');
$update2->bind_param('i',$milestone_id);
$update2->execute();
$update2_affect_row=$mysqli->affected_rows;
if($update2_affect_row<=0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong try again later.')); 
	jsonSendEncode($record); 
}

$get_users1=getUserDetails($milestone_arr['posted_user']);
$Homeuser=getUserDetails($posted_user);
// notification====================
$notification_arr  = array();
$action 		=	'milestone_request_cancel';
$action_id 		=    $job_id;
$title 			=	'Requested a milestone cancellation';
$message 		=	$get_users1['f_name'].' requested a milestone cancellation. <a>View & respond!</a>';
$sender_id      =   $milestone_arr['posted_user'];
$receive_id 	=	$milestone_arr['userid'];
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
//$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
//if($notification_arr_get != 'NA')

	//$notification_arr[]	=	$notification_arr_get;




$has_email_noti = getUserDetails($milestone_arr['userid']); 
$ownuser = getUserDetails($user_id); 
			

	
	$subject = "Milestone Payment cancellation request for Job “".$job_arr['title']."” Accept/Reject";
	
	$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Request to cancel a milestone payment! </p>';
	$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
	$html .= '<p style="margin:0;padding:10px 0px">'.$get_users1['f_name'].' has requested the cancellation of milestone payment made for the job “'.$job_arr['title'].'.” </p>';
	$html .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$milestone_arr['milestone_amt'].'</p>';
	
	$html .= '<p style="margin:0;padding:10px 0px">All you have to do is to either accept or reject the request. In the event of rejection, please state your reasons and supply any evidence that will help our team make a decision.</p>';

	
		$html .= '<div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept</a> &nbsp; &nbsp; <a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reject</a></div>';
	
	$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
	
	$mailBody1 = send_mail_app($html);
	$mailResponse  =  mailSend($has_email_noti['email'], $get_users1['f_name'], $subject, $mailBody1);
	
//------------------------confirmation own-------------------------------------------


$subjectN = "Your milestone cancellation request was submitted successfully!";
$htmlN .= '<p style="margin:0;padding:10px 0px">Hi '.$ownuser['f_name'].'!</p>';
$htmlN .= '<p style="margin:0;padding:10px 0px">Your milestone cancellation request for job: '.$job_arr['title'].' was submitted successfully. </p>';
$htmlN .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$milestone_arr['milestone_amt'].'</p>';
$htmlN .= '<div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View request</a></div>';
	
	$htmlN .= '<p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
	
	$mailBody1 = send_mail_app($htmlN);
	$mailResponse  =  mailSend($ownuser['email'], $ownuser['f_name'], $subjectN, $mailBody1);
	


	

$subjectH = "Milestone Payment Request Withdrawn !";
$htmlH .= '<p style="margin:0;padding:10px 0px">Hi '.$Homeuser['f_name'].'!</p>';
$htmlH .= '<p style="margin:0;padding:10px 0px">'.$ownuser['trading_name'].' has withdrawn their milestone payment creation request. </p>';
$htmlH .= '<p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
    
    $mailBody1 = send_mail_app($htmlH);
    $mailResponse  =  mailSend($Homeuser['email'], $Homeuser['f_name'], $subjectH, $mailBody1);
    


$action_s 		=	'milestone_request_cancel';
$action_id_s 		=    $job_id;
$title_s 			=	'Requested a milestone cancellation';
$message_s 		=	$ownuser['trading_name'].' has withdrawn their milestone creation request. ';
$sender_id_s      =  $user_id;
$receive_id_s 	=	$Homeuser['id'];
$job_id_s			=   $job_id;
$action_data_s	=	array('user_id'=>$sender_id_s, 'other_user_id'=>$receive_id_s, 'job_id'=>$job_id_s, 'action_id'=>$action_id_s, 'action'=>$action_s);
$notification_arr_get_s	=	getNotificationArrSingle($sender_id_s, $receive_id_s, $action_s, $action_id_s, $message_s,$job_id_s, $action_data_s);
if($notification_arr_get_s != 'NA'){
	$notification_arr_send[]	=	$notification_arr_get_send;
}
if(empty($notification_arr_send)){
	$notification_arr_send	=	'NA';
}


$record=array('success'=>'true','msg'=>array('Success! Request cancelled successfully.'),'notification_arr'=>$notification_arr_send); 
jsonSendEncode($record);
 


