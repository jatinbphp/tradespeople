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


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,trading_name,type,email,f_name from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$trading_name,$type_new,$email_get,$f_name_get);
$check_user_all->fetch();


// ======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status FROM tbl_jobpost_bids WHERE  id= ? and (status = 7 or status = 3 or status = 5 or status = 10)");
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
		'bid_status'=>$status
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



$status = 3;
$is_requested = 1;			 
$milestaone_update = $mysqli->prepare("UPDATE `tbl_milestones` SET is_requested=?,status=? WHERE  id=?");
$milestaone_update->bind_param("iii",$is_requested,$status,$milestone_id);	
$milestaone_update->execute();
$milestaone_update_affect_row=$mysqli->affected_rows;
if($milestaone_update_affect_row<=0){
	$record=array('success'=>'false','msg'=>array("Error! Something went wrong.")); 
	jsonSendEncode($record);
}

$get_users = getUserDetails($job_arr['userid']);
$milestone_arr = getMileStoneById($milestone_id);

$subject = "Request to release Milestone Payment for Job: “".$job_arr['title']."”"; 						
$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Request to release milestone payment!</p>';
$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_users['f_name'] .',</p>';

$html .= '<p style="margin:0;padding:10px 0px">'.$trading_name.' has requested the release of their milestone payment for the job. “'.$job_arr['title'].'” Please, release the milestone if the task has been completed and you´re satisfied. </p>';

$html .= '<p style="margin:0;padding:10px 0px">Milestone Amount: £'.$milestone_arr['milestone_amt'].'</p>';

$html .= '<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Release milestone now</a></div>';
$html .= '<br><p style="margin:0;padding:10px 0px">View our Milestone Payment System page on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($get_users['email'], $trading_name, $subject, $mailBody);
 

if($type_new==1)
{
$subjectOwn = " Milestone Payment requested successfully.Job id: “".$job_arr['title']."”"; 				$htmlOwn .= '<p style="margin:0;padding:10px 0px">Hi ' . $f_name_get .',</p>';

$htmlOwn .= '<p style="margin:0;padding:10px 0px">Your milestone payment request was successfully. </p>';
$htmlOwn .= '<p style="margin:0;padding:10px 0px">Milestone name: '.$milestone_arr['milestone_name'].'</p>';
$htmlOwn .= '<p style="margin:0;padding:10px 0px">Milestone Amount: £'.$milestone_arr['milestone_amt'].'</p>';

$htmlOwn .= '<br><div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div>';
$htmlOwn .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

$mailBody = send_mail_app($htmlOwn);
$mailResponse  =  mailSend($email_get, $trading_name, $subjectOwn, $mailBody);
 
}
//notification====================
$notification_arr  = array();
$action 		=	'request_milestone';
$action_id 		=    $job_id;
$title 			=	'Request milestone release';
$title_push 	=	'Request to release milestone payment!';
$message_push 	=	$trading_name.' requested you release their milestone payment. Release now!
';
$message 		=	$trading_name.'has requested to release milestone payment of £'.$milestone_arr['milestone_amt'].' GBP for <a>'.$job_arr['title'].'</a>';
$sender_id      =   $user_id;
$receive_id 	=	$job_arr['userid']; 
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
//end notification==================

$record=array('success'=>'true','msg'=>array('Success! Your request has been submitted successfully.'),'mailResponse'=>$mailResponse,'notification_arr'=>'NA'); 
jsonSendEncode($record);

?>
