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
 
$user_id	     	=	$_GET['user_id'];
$wd_arr 			=   array();


$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount,u_email_verify from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$u_email_verify);
$check_user_all->fetch();
$wd_bank = array();

$refund_status = 'no';
$withdrawal_HISTORY	    =	$mysqli->prepare("SELECT  `status` FROM `homeowner_fund_withdrawal` WHERE status=0 and user_id=? ORDER BY id DESC");
$withdrawal_HISTORY->bind_param("i",$user_id);
$withdrawal_HISTORY->execute();
$withdrawal_HISTORY->store_result();
$check_withdrawal_HISTORY		=	$withdrawal_HISTORY->num_rows;  //0 1
if($check_withdrawal_HISTORY > 0){
	$refund_status ='yes';
}

 

$record=array('success'=>'true','msg'=>array('data found'),'refund_status'=>$refund_status,'u_email_verify'=>$u_email_verify); 
jsonSendEncode($record);

