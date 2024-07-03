<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

$plan_arr = array();
$user_id = $_GET['user_id'];
$cdate = date('Y-m-d');
 

 
$get_wallet_history=$mysqli->prepare("SELECT `tr_id`, `tr_userid`, `tr_message`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`, `tr_paid_by`, `tr_reward`, `tr_plan`, `is_deposit`, `is_admin_read` FROM `transactions` WHERE tr_userid=? and tr_type=2 and tr_status=1 order by tr_id desc");
$get_wallet_history->bind_param('i',$user_id);
$get_wallet_history->execute();
$get_wallet_history->store_result();
$get_wallet_history_count=$get_wallet_history->num_rows;  //0 1	
if($get_wallet_history_count > 0){
	$get_wallet_history->bind_result($tr_id, $tr_userid, $tr_message, $tr_amount, $tr_type, $tr_transactionId, $tr_status, $tr_created, $tr_update, $tr_paid_by, $tr_reward, $tr_plan, $is_deposit, $is_admin_read);
	while ($get_wallet_history->fetch()) { 
		$date = date('d-m-Y h:i:s A',strtotime($tr_created));
		$wallet_history_arr[] = array(
			'tr_id'			=>		$tr_id,
			'tr_userid'		=>		$tr_userid,
			'tr_message'	=>		$tr_message,
			'tr_amount'		=>		$tr_amount,
			'tr_type'		=>		$tr_type,
			'tr_transactionId'=>		$tr_transactionId,
			'tr_status'		=>		$tr_status,
			'tr_created'	=>		$tr_created,
			'tr_update'		=>		$tr_update,
			'tr_paid_by'	=>		$tr_paid_by,
			'tr_reward'		=>		$tr_reward,
			'tr_plan'		=>		$tr_plan,
			'is_deposit'	=>		$is_deposit,
			'is_admin_read' =>		$is_admin_read,
			'date'			=>		$date,
		);
	}
}	
if(empty($wallet_history_arr)){
	$wallet_history_arr = "NA";
} 
 
$record=array('success'=>'true','msg'=>$data_found,'wallet_history_arr'=>$wallet_history_arr); 
jsonSendEncode($record);
?>