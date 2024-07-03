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
 
$user_id			   	    =	$_GET['user_id'];

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();
//-------------------------------------------------------------------------

//get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT `tr_id`, `tr_userid`, `tr_message`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`, `tr_paid_by`, `tr_reward`, `tr_plan`, `is_deposit`, `is_admin_read` FROM `transactions` where tr_userid=? and tr_type=1  order by tr_id desc");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($tr_id, $tr_userid, $tr_message, $tr_amount, $tr_type, $tr_transactionId, $tr_status, $tr_created, $tr_update, $tr_paid_by, $tr_reward, $tr_plan, $is_deposit, $is_admin_read);
	while ($tran_get->fetch()) {
		 $transaction_arr[] = array(
			'tr_id'=>$tr_id,
			'tr_userid'=>$tr_userid,
			'tr_message'=>$tr_message,
			'tr_amount'=>$tr_amount,
			'tr_type'=>$tr_type,
			'tr_transactionId'=>$tr_transactionId,
			'tr_status'=>$tr_status,
			'tr_created'=>$tr_created,
			'tr_update'=>$tr_update,
			'tr_paid_by,'=>$tr_paid_by, 
			'tr_reward'=>$tr_reward,
			'tr_plan'=>$tr_plan,
			'is_deposit,'=>$is_deposit, 
			'is_admin_read'=>$is_admin_read,
		 );
	}
}


//get transction data========
$bank_history_arr = array();
$bank_history_get = $mysqli->prepare("SELECT `id`, `userId`, `contryId`, `amount`, `admin_percent`, `user_amount`, `admin_amt`, `bank_account_name`, `date_of_deposit`, `reference`, `create_date`, `update_date`, `status`, `reject_reason`, `is_admin_read` FROM `bank_transfer` WHERE userId=? order by id desc");
$bank_history_get->bind_param("i",$user_id);
$bank_history_get->execute();
$bank_history_get->store_result();
$bank_history_get_row = $bank_history_get->num_rows;
if($bank_history_get_row>0){
	$bank_history_get->bind_result($id,$userId,$contryId,$amount,$admin_percent,$user_amount,$admin_amt,$bank_account_name,$date_of_deposit,$reference,$create_date,$update_date,$status,$reject_reason,$is_admin_read);
	while ($bank_history_get->fetch()) {
		 $bank_history_arr[] = array(
			'id'		=>	  $id,
			'userId'	=>	  $userId,
			'contryId'	=>	  $contryId,
			'amount'	=>	  $amount,
			'admin_percent'	=>	  $admin_percent,
			'user_amount'	=>	  $user_amount,
			'admin_amt'	=>	  $admin_amt,
			'bank_account_name'	=>	  $bank_account_name,
			'date_of_deposit'	=>	  $date_of_deposit,
			'reference'	=>	  $reference,
			'create_date'=>	  $create_date,
			'update_date'=>	  $update_date,
			'status'	=>	  $status,
			'reject_reason'=>	  $reject_reason,
			'is_admin_rea'=>	  $is_admin_read
		 );
	}
}
 
$sql = 'SELECT `status` FROM `bank_transfer` where userId='.$user_id.' ORDER BY id DESC LIMIT 1';
$bank_approvae_status  =   getSingleDataBySql($sql);



$last_txn_ref  =   getSingleDataBySql('SELECT `id` FROM `bank_transfer` ORDER BY id DESC LIMIT 1');
if($last_txn_ref=='NA'){
	$last_txn_ref = 0;
}
$last_txn_ref=$last_txn_ref+1;
$last_txn_ref = sprintf("%06d", $last_txn_ref);

$user_details 		= 		getUserDetails($user_id);
$admin_details      =       getAdminDetails();
$username = '';
$name = '';
if($user_details!='NA'){
	$user_email=$user_details['email'];
	$name=$user_details['f_name'].' '.$user_details['l_name'];
	$username_arr = explode('@',$user_email);
	$username = $username_arr[0];
}
$last_txn_ref1 = $last_txn_ref;
$last_txn_ref = $username.'-'.$last_txn_ref;

if(empty($transaction_arr)){
	$transaction_arr='NA';
}

if(empty($bank_history_arr)){
	$bank_history_arr='NA';
}

$record   =  array('success'=>'true','msg'=>$data_found,'user_details'=>$user_details,'transaction_arr'=>$transaction_arr,'admin_details'=>$admin_details,'last_txn_ref'=>$last_txn_ref,'last_txt_id'=>$last_txn_ref1,'name'=>$name,'bank_history_arr'=>$bank_history_arr,'bank_approvae_status'=>$bank_approvae_status); 
jsonSendEncode($record);

?>