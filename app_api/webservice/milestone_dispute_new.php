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
if(empty($_POST['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$userid	     	=	$_POST['user_id'];
$other_id     	    =	$_POST['other_id'];
$user_id_mail	    =	$_POST['user_id'];
$job_id			 	=	$_POST['job_id'];
$bid_id			 	=	$_POST['bid_id'];
$milestone_id_arr	=	$_POST['milestone_ids'];
$dispute_reason 	=   $_POST['dispute_reason'];
$dispute_reason     = '<p>'.$dispute_reason.'</p>';
$reason2            =  $_POST['reason2'];     
$offer_amount        = $_POST['offer_amount'];

if(!$milestone_id_arr || empty($milestone_id_arr)){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$job = getJobDetails($job_id);
$login_user = getUserDetails($userid);
$setting = getAdminDetails();

if($userid != $job['userid'] && $userid != $job['awarded_to']){
$record=array('success'=>'false', 'msg' =>'Something went wrong, try again later.'); 
jsonSendEncode($record); 		
}

$dispute_to = ($userid == $job['userid']) ? $job['awarded_to'] : $job['userid'];

$ds_in_id =  $userid;
$ds_job_id = $job_id;
$ds_buser_id = $job['awarded_to'];
$ds_puser_id = $job['userid'];
$caseid = time();
$ds_status = 0;
$disputed_by = $userid;
$dispute_to = $dispute_to;
$ds_comment = $dispute_reason;
if ($login_user['type'] == 1) {
	$tradesmen_offer = $offer_amount;
	$sql_offer_col = 'tradesmen_offer';
} else {
	$homeowner_offer = $offer_amount;
	$sql_offer_col = 'homeowner_offer';
}
$last_offer_by = $userid;
$ds_create_date = date('Y-m-d H:i:s');

/// Insert Dispute
$disp_mile = $mysqli->prepare("INSERT INTO tbl_dispute(ds_in_id,ds_job_id,ds_buser_id,ds_puser_id,caseid,ds_status,disputed_by,dispute_to,ds_comment,$sql_offer_col,last_offer_by,ds_create_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
$disp_mile->bind_param("ssssssssssss",$ds_in_id,$ds_job_id,$ds_buser_id,$ds_puser_id,$caseid,$ds_status,$disputed_by,$dispute_to,$ds_comment,$offer_amount,$last_offer_by,$ds_create_date);	
$disp_mile->execute();
$disp_mile_row=$mysqli->affected_rows;
$run = $mysqli->insert_id;
if($disp_mile_row <= 0){
	$record		=	array('success'=>'false', 'msg'=>'Something went wrong, try again later.'); 
	jsonSendEncode($record);
}

$bid_users = getUserDetails($job['awarded_to']);
$today = date('Y-m-d H:i:s');
$newTime = date('Y-m-d H:i:s', strtotime($today . ' +' . $setting['waiting_time'] . ' days'));
if (!empty($_FILES['files']['name'])) {
	foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
		$newName = explode('.', $_FILES['files']['name'][$key]);
		$size = $_FILES['files']['size'][$key];
		$file_tmp = $_FILES['files']['tmp_name'][$key];
		$file_name = $_FILES['files']['name'][$key];
		$ext = end($newName);
		$file_str = rand() . time() . '.' . $ext;
		$fileName = 'img/dispute/' . $file_str;
		$api_path = '../../img/dispute/' . $file_str;
		$original_name = $file_name;
		$uploaded_by = $userid;
		$dispute_id = $run;
		$created_at = date('Y-m-d H:i:s');
		$updated_at = date('Y-m-d H:i:s');
		
		if (move_uploaded_file($file_tmp, $api_path)) {
		  $disput_file = $mysqli->prepare("INSERT INTO dispute_file(uploaded_by,dispute_id,file,original_name,created_at,updated_at) VALUES (?,?,?,?,?,?)");
$disput_file->bind_param("ssssss",$uploaded_by,$dispute_id,$fileName,$original_name,$created_at,$updated_at);	
$disput_file->execute();
$insert_affected_rows = $mysqli->affected_rows;
if($insert_affected_rows <= 0){
	$record		=	array('success'=>'false', 'msg'=>'file not uploaded'); 
	jsonSendEncode($record);
  }					
					
		 }
	 }
}

$record=array('success'=>'false', 'msg' =>$bid_users); 
jsonSendEncode($record); 	


