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


$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
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


 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT `tr_id`, `tr_userid`, `tr_message`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`, `tr_paid_by`, `tr_reward`, `tr_plan`, `is_deposit`, `is_admin_read`, `action`, `action_id`, `action_json`  FROM `transactions` where tr_userid=?   order by tr_id desc");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($tr_id, $tr_userid, $tr_message, $tr_amount, $tr_type, $tr_transactionId, $tr_status, $tr_created, $tr_update, $tr_paid_by, $tr_reward, $tr_plan, $is_deposit, $is_admin_read, $action, $action_id, $action_json);
	while ($tran_get->fetch()) {
		if(!empty($tr_message))
		{
		$amt_txt = ($tr_type==1) ? '+' : '-';		
		$tr_status = ($tr_status==1) ? 'Success' : 'Failed';	
		$tr_message = str_replace('<i class="fa fa-gbp"></i>', '£', $tr_message);
		$rep_message = 	$tr_message;
		 $transaction_arr[] = array(
			'tr_id'=>$tr_id,
			'tr_userid'=>$tr_userid,
			'tr_message'=>$rep_message,
			 'amt_txt'=>$amt_txt,
			'tr_amount'=>$tr_amount,
			'tr_type'=>$tr_type,
			'tr_transactionId'=>$tr_transactionId,
			'tr_status'=>$tr_status,
			'tr_created'=>date('d-m-Y h:i:s A',strtotime($tr_created)),
			'tr_update'=>$tr_update,
			'tr_paid_by,'=>$tr_paid_by, 
			'tr_reward'=>$tr_reward,
			'tr_plan'=>$tr_plan,
			'is_deposit,'=>$is_deposit, 
			'is_admin_read'=>$is_admin_read,
			 'action'=>$action,
			'action_id'=>$action_id,
			'action_json'=>$action_json,
		 );
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'transaction_arr'=>$transaction_arr); 
jsonSendEncode($record);

