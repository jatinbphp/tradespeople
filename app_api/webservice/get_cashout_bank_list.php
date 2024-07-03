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


$user_id             = $_GET['user_id'];
$wd_arr 			=   array();

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_get_id,$user_type);
	$check_user_all->fetch();


/// Settings 
if($user_type==1){
$settings2 = adminsettings(3);
} else if($user_type==2) {
$settings2 = adminsettings(2);	
} else if($user_type==3) {
$settings2 = adminsettings(1);	
}

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT id,wd_account_holder,wd_bank,wd_account,wd_ifsc_code,account_holder_address,paypal_email_address FROM wd_bank_details where wd_user_id=? ORDER BY id DESC");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$wd_account_holder,$wd_bank,$wd_account,$wd_ifsc_code,$account_holder_address,$paypal_email_address);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
			
	if(!empty($settings2) && $settings2['payment_method']=='both'){
	   $payment_type="both";		
	} elseif(!empty($settings2) && $settings2['payment_method']=='bank_transfer'){
		$payment_type="bank_transfer";		
	} elseif(!empty($settings2) && $settings2['payment_method']=='paypal' && $paypal_email_address != '') {
	   $payment_type="paypal";
	} else {
		$payment_type="Please fill the Bank Account details";
	}
			
	     $transfer_type=($paypal_email_address!='')? 'Paypal Transfer':'Bank Transfer';
		 $transaction_arr[] = array(
			'id'=>$id,
			'user_id'=>$user_id,
			 'holder_name'=>$wd_account_holder,
			 'bank_name'=>$wd_bank,
			 'ac_no'=>$wd_account,
			 'ifsc_code'=>$wd_ifsc_code,
			 'account_holder_address'=>$account_holder_address,
			 'paypal_email_address'=>$paypal_email_address,
			 'transfer_type'=>$transfer_type,
			 'payment_type'=>$payment_type,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'bank_arr'=>$transaction_arr); 
jsonSendEncode($record);