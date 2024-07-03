<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include('mailFunctions.php');
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


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,email,f_name,trading_name,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$email,$f_name_show,$trading_name,$type_new);
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
		 'milestone_amount'=> $milestone_amount,
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
}else{
	$record		=	array('success'=>'false', 'msg'=>array('Something went wrong')); 
	jsonSendEncode($record);
}


//bid======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status,paid_total_miles FROM tbl_jobpost_bids WHERE  id= ?");
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
 
$created_by = $milestone_arr['created_by'];
$userid     = $milestone_arr['userid'];

$u_wallet1  = $u_wallet+$milestone_arr['milestone_amount'];

$update     =   $mysqli->prepare('UPDATE users SET u_wallet=?  WHERE id=?');
$update->bind_param('si',$u_wallet1,$created_by);
$update->execute();
$update_affect_row=$mysqli->affected_rows;

$total_milestone_amount1 = $bid_arr['total_milestone_amount']-$milestone_arr['milestone_amount'];

$update1     =   $mysqli->prepare('UPDATE tbl_jobpost_bids SET total_milestone_amount=? WHERE id=?');
$update1->bind_param('si',$total_milestone_amount1,$bid_id);
$update1->execute();
$update_affect_row1=$mysqli->affected_rows;

// delete milestone==============
$delete     =   $mysqli->prepare('DELETE FROM `tbl_milestones` WHERE id=?');
$delete->bind_param('i',$milestone_id);
$delete->execute();
$delete_affect_row1=$mysqli->affected_rows;

// update transaction master=========================================
$transactionid = md5(rand(1000,999).time());
$tr_type = 1;
$tr_status = 1;
$updatetime =  date("Y-m-d H:i:s");

$tr_message='£'.$milestone_arr['milestone_amount'].' has been credited to your wallet for '.$milestone_arr['milestone_name'].' milestone on date '.date('d-m-Y h:i:s A').'.';

$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
$transaction_add->bind_param("isiissss",$created_by,$milestone_arr['milestone_amount'],$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid);	
$transaction_add->execute();
$transaction_add_affect_row=$mysqli->affected_rows;
if($transaction_add_affect_row<=0){
	$record=array('success'=>'false','msg'=>$p_transaction_err); 
	jsonSendEncode($record);
}

$get_users       = getUserDetails($milestone_arr['created_by']);
if($type_new==1)
{
$name_show=$trading_name;
}
else{
	$name_show=$f_name_show;
}
// notification====================
$notification_arr  = array();
$action 		=	'accept_milesstone_cancel_req';
$action_id 		=    $job_id;
$title 			=	'Accept milestone cancellation request';
$message 		=	$name_show.' accepted your milestone cancellation request!';
$sender_id      =   $user_id;
$receive_id 	=	$milestone_arr['posted_user']; 
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if(empty($notification_arr)){
	$notification_arr	=	'NA';
}


$get_users1     = getUserDetails($milestone_arr['posted_user']);
$u_name = $get_users1['f_name'].' '.$get_users1['l_name'];
// mail========================
$subject = "You have approved milestone cancellation request!"; 
$content .= 'Hello '.$f_name_show.', <br><br>';
$content .='<p class="text-center">You have approved  '.$u_name. ' request to cancel their milestone payment.</p>';
$content .='<p class="text-center">Milestone name: '.$milestone_arr['milestone_name'].'</p>';
$content .='<p class="text-center">Milestone amount £: '.$milestone_arr['milestone_amount'].'</p>';
$content .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none"> View milestone
</a>
    </div>';
$content .='<p class="text-center">View our tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content);
$mailResponse  =  mailSend($email, $f_name_show, $subject, $mailBody);
//end email temlete================
//-----------------------------homeowner mail----------------------------------
$get_users_home     = getUserDetails($milestone_arr['posted_user']);
$u_name1 = $get_users_home['f_name'].' '.$get_users_home['l_name'];
$email_home=$get_users_home['email'];
$subject1 = "Your milestone cancellation request has been approved!"; 
$content1 .= 'Hello '.$u_name1.', <br><br>';
$content1 .='<p class="text-center">Your request to cancel your milestone payment has been approved by '.$f_name_show.'.</p>';
$content1 .='<p class="text-center">Milestone name: '.$milestone_arr['milestone_name'].'</p>';
$content1 .='<p class="text-center">Milestone amount £: '.$milestone_arr['milestone_amount'].'</p>';
$content1 .= '<br><div style="text-align:center"> 
 	<a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none"> View milestone
</a>
    </div>';
$content1 .='<p class="text-center">Visit our Homeowner help page or contact our customer services if you have any specific questions using our servicece.</p>';
$mailBody = send_mail_app($content1);
$mailResponse  =  mailSend($email_home, $u_name1, $subject1, $mailBody);

//echo $mailBody;
$record=array('success'=>'true','msg'=>array('Success! Request cancellation of milestone has been approved successfully.','Success! Request cancellation of milestone has been approved successfully.'),'notification_arr'=>$notification_arr,'mailResponse'=>$mailResponse); 
jsonSendEncode($record);