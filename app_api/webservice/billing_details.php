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
 

$user_id	     	=	$_GET['user_id']; 



$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,f_name,l_name from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$f_name,$l_name);
$check_user_all->fetch();


//get rewards===========================
$rewards_arr    = array();
$get_rewards	=	$mysqli->prepare("SELECT `tr_id`, `tr_userid`, `tr_message`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`, `tr_paid_by`, `tr_reward`, `tr_plan`, `is_deposit`, `is_admin_read` FROM `transactions` where tr_userid=? and tr_reward=1 ORDER BY tr_id");
$get_rewards->bind_param("i",$user_id);
$get_rewards->execute();
$get_rewards->store_result();
$get_rewards_c		=	$get_rewards->num_rows;  //0 1
if($get_rewards_c > 0){
	$get_rewards->bind_result($tr_id, $tr_userid, $tr_message, $tr_amount, $tr_type, $tr_transactionId, $tr_status, $tr_created, $tr_update, $tr_paid_by, $tr_reward, $tr_plan, $is_deposit, $is_admin_read);
	while($get_rewards->fetch()){
			$package_name="";
			$amount="";
			$reward_amount="";
		
		if(!is_null($tr_plan)){
			$plan_arr = getPackageDetails($tr_plan);
			if($plan_arr!='NA'){
				$package_name=$plan_arr['package_name'];
				$amount=$plan_arr['amount'];
				$reward_amount=$plan_arr['reward_amount'];
			}
		}
		
		$rewards_arr[]  = array(
				'tr_id'=>$tr_id,
				'tr_userid'=>$tr_userid,
				'tr_message'=>$tr_message,
				'tr_amount'=>$tr_amount,
				'tr_type'=>$tr_type,
				'tr_transactionId'=>$tr_transactionId,
				'tr_status'=>$tr_status,
				'tr_created'=>$tr_created,
				'tr_update'=>$tr_update,
				'tr_paid_by'=>$tr_paid_by,
				'tr_reward'=>$tr_reward,
				'tr_plan'=>$tr_plan,
				'is_deposit'=>$is_deposit,
				'is_admin_read'=>$is_admin_read,
				'package_name'=>$package_name,
				'amount'=>$amount,
				'reward_amount'=>$reward_amount,
		);
	}
}


if(empty($rewards_arr)){
	$rewards_arr = 'NA';
}
$wd_bank = array();
$withdrawal_HISTORY	    =	$mysqli->prepare("SELECT `wd_id`, `wd_userid`, `wd_amount`, `wd_account_holder`, `wd_bank`, `wd_account`, `wd_ifsc_code`, `wd_reason`, `wd_status`, `wd_create`, `wd_payment_type`, `wd_pay_email`, `is_admin_read` FROM `tbl_withdrawal` WHERE wd_userid=? order by wd_id desc");
$withdrawal_HISTORY->bind_param("i",$user_id);
$withdrawal_HISTORY->execute();
$withdrawal_HISTORY->store_result();
$check_withdrawal_HISTORY		=	$withdrawal_HISTORY->num_rows;  //0 1
if($check_withdrawal_HISTORY > 0){
	$withdrawal_HISTORY->bind_result($wd_id, $wd_userid, $wd_amount, $wd_account_holder, $wd_bank1, $wd_account, $wd_ifsc_code, $wd_reason, $wd_status, $wd_create, $wd_payment_type, $wd_pay_email, $is_admin_read);
$withdrawal_HISTORY->fetch();
		if($wd_payment_type==2 ){
			$wd_bank = array(
				'wd_id'=>$wd_id,
				'wd_userid'=>$wd_userid,
				'wd_amount'=>$wd_amount,
				'wd_account_holder'=>$wd_account_holder,
				'wd_bank'=>$wd_bank1,
				'wd_account'=>$wd_account,
				'wd_ifsc_code'=>$wd_ifsc_code,
				'wd_reason'=>$wd_reason,
				'wd_status'=>$wd_status,
				'wd_create'=>$wd_create,
				'wd_payment_type'=>$wd_payment_type,
				'wd_pay_email'=>$wd_pay_email,
				'is_admin_read'=>$is_admin_read,
			);
		
		
	}
}


if(empty($wd_bank)){
	$wd_bank="NA";
}

 

$user_details    = getUserDetails($user_id_get);
$admin_details   = getAdminDetails();

$record=array('success'=>'true','msg'=>array('Data found'),'user_details'=>$user_details,'admin_details'=>$admin_details,'rewards_arr'=>$rewards_arr,'wd_bank'=>$wd_bank); 
jsonSendEncode($record);

