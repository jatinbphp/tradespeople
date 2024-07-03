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


$wd_bank = array();
$withdrawal_HISTORY	    =	$mysqli->prepare("SELECT `id`, `user_id`, `status`, `amount`, `account_holder_name`, `bank_name`, `account_number`, `short_code`, `create_date`, `update_date`, `token`, `reason`, `pay_method`, `is_admin_read` FROM `homeowner_fund_withdrawal` WHERE user_id=? ORDER BY id DESC");
$withdrawal_HISTORY->bind_param("i",$user_id);
$withdrawal_HISTORY->execute();
$withdrawal_HISTORY->store_result();
$check_withdrawal_HISTORY		=	$withdrawal_HISTORY->num_rows;  //0 1
if($check_withdrawal_HISTORY > 0){
	$withdrawal_HISTORY->bind_result($id, $user_id, $status, $amount, $account_holder_name, $bank_name, $account_number, $short_code, $create_date, $update_date, $token, $reason, $pay_method, $is_admin_read);
	while($withdrawal_HISTORY->fetch()){
		if($status>0 && empty($wd_bank)){
			$wd_bank = array(
				'id'=>$id,
				'user_id'=>$user_id,
				'status'=>$status, 
				'amount'=>$amount,
				'account_holder_name'=>$account_holder_name,
				'bank_name'=>$bank_name,
				'account_number'=>$account_number,
				'short_code'=>$short_code,
				'create_date'=>$create_date,
				'update_date'=>$update_date,
				'token'=>$token,
				'reason'=>$reason,
				'pay_method'=>$pay_method,
				'is_admin_read'=>$is_admin_read,
			);
		}
		if($status==0){
		$wd_arr[] = array(
			'id'=>$id,
			'user_id'=>$user_id,
			'status'=>$status, 
			'amount'=>$amount,
			'account_holder_name'=>$account_holder_name,
			'bank_name'=>$bank_name,
			'account_number'=>$account_number,
			'short_code'=>$short_code,
			'create_date'=>$create_date,
			'update_date'=>$update_date,
			'token'=>$token,
			'reason'=>$reason,
			'pay_method'=>$pay_method,
			'is_admin_read'=>$is_admin_read,
		);
		}
	}
}

if(empty($wd_arr)){
	$wd_arr = "NA";
}
if(empty($wd_bank)){
	$wd_bank="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'email_arr'=>$email_arr,'u_wallet'=>$u_wallet,'wd_arr'=>$wd_arr,'wd_bank'=>$wd_bank); 
jsonSendEncode($record);

