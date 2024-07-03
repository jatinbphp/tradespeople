<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}


$user_id	     	=	 $_GET['user_id'];
$dispute_id     	=    $_GET['dispute_id'];
$bid_id             =    $_GET['bid_id'];
$milestone_id       =    $_GET['milestone_id'];


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user	= $check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount);
$check_user_all->fetch();



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


//check dispute id=================================
$get_dispute_id	=	$mysqli->prepare("SELECT `ds_id`, `ds_in_id`, `ds_job_id`, `ds_buser_id`, `ds_puser_id`, `ds_status`, `ds_favour`, `ds_comment`, `caseid`, `ds_create_date`, `mile_id`, `disputed_by`, `dispute_to`, `is_admin_read`, `is_accept` FROM `tbl_dispute` WHERE ds_id=?");
$get_dispute_id->bind_param("i",$dispute_id);
$get_dispute_id->execute();
$get_dispute_id->store_result();
$get_dispute_num		=	$get_dispute_id->num_rows;  //0 1
if($get_dispute_num <= 0){
	$record		=	array('success'=>'false', 'msg'=>'milestone Id does not exists'); 
	jsonSendEncode($record);
}
$get_dispute_id->bind_result($ds_id, $ds_in_id, $ds_job_id, $ds_buser_id, $ds_puser_id, $ds_status, $ds_favour, $ds_comment, $caseid, $ds_create_date, $mile_id, $disputed_by, $dispute_to, $is_admin_read, $is_accept);
$get_dispute_id->fetch();
//disputed_by
$fname    =   getSingleDataBySql("select f_name from users where id=".$disputed_by."");
$lname    =   getSingleDataBySql("select l_name from users where id=".$disputed_by."");
$dispute = array(
	'ds_id'=>$ds_id,
	'ds_in_id'=>$ds_in_id,
	'ds_job_id'=>$ds_job_id,
	'ds_buser_id'=>$ds_buser_id,
	'ds_puser_id'=>$ds_puser_id,
	'ds_status'=>$ds_status,
	'ds_favour'=>$ds_favour,
	'ds_comment'=>$ds_comment,
	'caseid'=>$caseid,
	'ds_create_date'=>$ds_create_date,
	'mile_id'=>$mile_id,
	'disputed_by'=>$disputed_by,
	'dispute_to'=>$dispute_to,
	'is_admin_read'=>$is_admin_read,
	'is_accept'=>$is_accept,
	'disputed_by_name'=>$fname.' '.$lname,
);
if(empty($dispute)){
	$dispute = 'NA';
}
$dct_update='';

$job_files 			= 	getJobFiles($job_id);
$owner		        =	getUserDetails($ds_puser_id);
$tradmen        	=	getUserDetails($ds_buser_id);

$where 				= "SELECT SUM(milestone_amount) FROM tbl_milestones where post_id=".$ds_job_id." and (status=0 OR status=3 OR status=4 OR status=5)";
$pending_amount     =  	getSingleDataBySql($where);

$where1 			=	"SELECT SUM(milestone_amount) FROM tbl_milestones where post_id=".$ds_job_id." and (status=2)";
$release_amount  	=   getSingleDataBySql($where1);
$conversation 		= 	getdisputconversation($ds_id);

if($conversation!='NA'){
$dct_update =$conversation[0]['dct_update'];
}
$mile_arr 			=   getMileStoneById($milestone_id);
$conversation_arr = array(
	'conversation'=>$conversation,
	'pending_amount'=>$pending_amount,
	'release_amount'=>$release_amount,
	'owner'=>$owner,
	'tradmen'=>$tradmen,
	'job_files'=>$job_files,
	'bid_arr'=>$bid_arr,
	'dispute'=>$dispute,
	'mile_arr'=>$mile_arr,
);


$record=array('success'=>'true','msg'=>array(''),'conversation_arr'=>$conversation_arr); 
jsonSendEncode($record);
