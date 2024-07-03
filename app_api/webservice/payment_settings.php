<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['status'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$status             = $_GET['status'];
$wd_arr 			=   array();

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT id,payment_method,status FROM payment_settings where status=?");
$tran_get->bind_param("i",$status);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$payment_method,$status);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	     
		 $transaction_arr[] = array(
			'id'=>$id,
			'payment_method'=>$payment_method,
			'status'=>$status,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'payment_arr'=>$transaction_arr); 
jsonSendEncode($record);