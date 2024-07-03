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

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT id,unique_id,withdrawable_balance,referral_earning FROM users where id=?");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$unique_id,$withdrawable_balance,$referral_earning);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	     
		 $transaction_arr[] = array(
			'id'=>$id,
			'refferal_code'=>$unique_id,
			'withdrawable_balance'=>$withdrawable_balance,
			 'referral_earning'  => $referral_earning,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'reffer_arr'=>$transaction_arr); 
jsonSendEncode($record);