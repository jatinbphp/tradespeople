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
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_GET['bid_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$user_id	     	=	$_GET['user_id'];
$bid_id			    =	$_GET['bid_id'];
$job_id			    =	$_GET['job_id'];
$delivery_days      =   $_GET['delivery_days'];
$budget             =   $_GET['budget'];

//get user details==================
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();
	  
//get bid details==================
$get_bid_record	=	$mysqli->prepare("SELECT id,total_milestone_amount from tbl_jobpost_bids where id=?");
$get_bid_record->bind_param("i",$bid_id);
$get_bid_record->execute();
$get_bid_record->store_result();
$get_bid_record1		=	$get_bid_record->num_rows;  //0 1
if($get_bid_record1 <= 0){
	$record		=	array('success'=>'false',  'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$get_bid_record->bind_result($bid_id,$total_milestone_amount);
$get_bid_record->fetch();

//get bid details==================

$get_job_record1	=	$mysqli->prepare("SELECT userid from tbl_jobs where job_id=?");
$get_job_record1->bind_param("i",$job_id);
$get_job_record1->execute();
$get_job_record1->store_result();
$get_job_record11		=	$get_job_record1->num_rows;  //0 1
if($get_job_record11 <= 0){
	$record		=	array('success'=>'false',  'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$get_job_record1->bind_result($homeuser_id);
$get_job_record1->fetch();

// ======================
$update_job = $mysqli->prepare("UPDATE `tbl_jobs` SET `status`=4,budget=? WHERE  job_id=?");
$update_job->bind_param("si",$budget,$job_id);	
$update_job->execute();
$update_job_affect_row=$mysqli->affected_rows;
if($update_job_affect_row<=0){
	//$record=array('success'=>'false','msg'=>array('Something went wrong, please try again later')); 
	//jsonSendEncode($record);
}

 
$update_job1 = $mysqli->prepare("UPDATE `tbl_jobpost_bids` SET `status`=3,bid_amount=?,delivery_days=? WHERE  id=?");
$update_job1->bind_param("ssi",$budget,$delivery_days,$bid_id);	
$update_job1->execute();
$update_job1_affect_row=$mysqli->affected_rows;
if($update_job1_affect_row<=0){
	//$record=array('success'=>'false','msg'=>array('Something went wrong, please try again later')); 
	//jsonSendEncode($record);
}
	
$record=array('success'=>'true','msg'=>array('Job budget has been re-opened successfully')); 
jsonSendEncode($record);

?>