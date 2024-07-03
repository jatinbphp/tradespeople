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
$tran_get = $mysqli->prepare("SELECT id,user_id,trans_id,request_amount,payment_method,paypal_email_address,status,reason_for_reject,created_at FROM referral_payout_requests where user_id=? ORDER BY id DESC");
$tran_get->bind_param("i",$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$user_id,$trans_id,$request_amount,$payment_method,$paypal_email_address,$status,$reason_for_reject,$created_at);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	     
		if($status==0){
          $p_status='Pending';
		} else if($status==1) {
			$p_status='Paid';
		} else if($status==2) {
			$p_status='Rejected';
		}
			
			
		 $transaction_arr[] = array(
			'id'=>$id,
			'user_id'=>$user_id,
			 'trans_id'=>$trans_id,
			 'request_amount'=>$request_amount,
			 'payment_method'=>$payment_method,
			 'status'=>$p_status,
			 'reason_for_reject'=>$reason_for_reject,
			 'created_at'=>$created_at,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'req_arr'=>$transaction_arr); 
jsonSendEncode($record);