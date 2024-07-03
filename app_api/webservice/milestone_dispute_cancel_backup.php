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
$bid_id			 	=	$_GET['bid_id'];
$milestone_id	    =	$_GET['milestone_id'];
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
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$type_new,$email,$f_name,$l_name,$trading_name);
$check_user_all->fetch();


//bid======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status,paid_total_miles FROM tbl_jobpost_bids WHERE  id= ? and (status = 7 or status = 3 or status = 5 or status = 10)");
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



// check dispute id ==========


$get_dispute_data=$mysqli->prepare("SELECT `ds_id`,ds_buser_id,ds_puser_id FROM `tbl_dispute` WHERE ds_id=?");
$get_dispute_data->bind_param('i',$dispute_id);
$get_dispute_data->execute();
$get_dispute_data->store_result();
$get_dispute_data_count=$get_dispute_data->num_rows;  //0 1	
// echo $get_dispute_data_count;die();
if($get_dispute_data_count <= 0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong please try again later.')); 
	jsonSendEncode($record);
}
$get_dispute_data->bind_result($ds_id,$ds_buser_id,$ds_puser_id);
$get_dispute_data->fetch();

$Homemade =  getUserDetails($ds_puser_id);				
$tradesprovider =  getUserDetails($ds_buser_id);
if($tradesprovider['type']==1)
{
	$sendlink=$provider;
}
else{	
	$sendlink=$homeowner;
}
if($type_new==1)
{
	$send_name=$trading_name;
}
else{
$send_name=$f_name.' '.$l_name;
}
// delete dispute data=======
$dispute_delete     =   $mysqli->prepare('DELETE FROM `tbl_dispute` WHERE ds_id=?');
$dispute_delete->bind_param('i',$dispute_id);
$dispute_delete->execute();
$dispute_delete_affect_row=$mysqli->affected_rows;
if($dispute_delete_affect_row <= 0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong please try again later.')); 
	jsonSendEncode($record);
}

$update3     =   $mysqli->prepare('UPDATE `tbl_milestones` SET `status`=0 WHERE id=?');
$update3->bind_param('i',$milestone_id);
$update3->execute();
$update3_affect_row=$mysqli->affected_rows;
if($update3_affect_row <= 0){
	$record=array('success'=>'false3','msg'=>array('Error! Something went wrong please try again later.')); 
	jsonSendEncode($record);
}

if($user_id == $ds_buser_id){
	$sql1 = "select email,f_name,l_name,type,id,email from users where id=$ds_buser_id";
	$sql2 = "select email,f_name,l_name,type,id,email from users where id=$ds_puser_id";
	$disput_user = getColumnValue($sql1);
	$other_user = getColumnValue($sql2);
} 
/*else {
	$sql1 = "select email,f_name,l_name,type,id,email, from users where id=$ds_buser_id";
	$sql2 = "select email,f_name,l_name,type,id,email from users where id=$ds_puser_id";
	$disput_user = getColumnValue($sql2);
	$other_user = getColumnValue($sql1);
}*/

			
// notification====================
$notification_arr  = array();
$action 		=	'dispute_cancel';
$action_id 		=    $job_id;
$title 			=	'Dispute cancelled';
/*$message 		=	$disput_user['f_name'].' '.$disput_user['l_name'].' has cancelled <a href="'.$website_url.'payments/?post_id='.$post_id.'">the milestone payment dispute.</a>';*/
$message 		=	$send_name.' has cancelled the milestone payment dispute.</a>';
$sender_id      =   $user_id;
$receive_id 	=	$other_user['id'];
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$notification_arr[]	=	$notification_arr_get;
}
if(empty($notification_arr)){
	$notification_arr	=	'NA';
}

$milestone_get = getMileStoneById($milestone_id);
// email=============================
$subject = 'Milestone Payment Dispute was cancelled:"'.$job_arr['title'] .'"'; 
$contant .= '<p style="margin:0;padding:10px 0px">Hi ' .$tradesprovider['f_name'] .',</p>';
$contant .= '<p style="margin:0;padding:10px 0px">'.$f_name.' '.$l_name.'  has cancelled the milestone payment dispute claim for the job "' .$job_arr['title'] .'"</p>';
$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$milestone_get['milestone_amt'] .'</p>';
$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to ask them to release the milestone if they have not yet done that.</p>';

$contant .= '<div style="text-align:center"><a href="'.$sendlink.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div>';

$contant .= '<p style="margin:0;padding:10px 0px">View our homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contant);
		//end email temlete================
$sender = $f_name.' '.$l_name;
$mailResponse  =  mailSend($tradesprovider['email'], $sender, $subject, $mailBody);



$subjectT = 'Your milestone payment dispute has been cancelled : "'.$job_arr['title'] .'"'; 
$contantT .= '<p style="margin:0;padding:10px 0px">Hi ' .$f_name .',</p>';
$contantT .= '<p style="margin:0;padding:10px 0px">Your milestone payment dispute against ' .$other_user['trading_name'] .' has been cancelled successfully.
</p>';
$contantT .= '<p style="margin:0;padding:10px 0px">Milestone Name : ' .$milestone_get['milestone_name'] .'</p>';
$contantT .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$milestone_get['milestone_amt'] .'</p>';


$contantT .= '<div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div>';

$contantT .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on our tradespeople help page or contact our customer services if you have any specific questions using our service.
</p>';
$mailBody = send_mail_app($contantT);
		//end email temlete================

$mailResponse  =  mailSend($email, $f_name, $subjectT, $mailBody);



$record=array('success'=>'true','msg'=>array('Success! Milestone Dispute canceeled successfully.'),'notification_arr'=>$notification_arr,'$mailResponse'=>$mailResponse); 
jsonSendEncode($record);
