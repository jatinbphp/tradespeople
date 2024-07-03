<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['type'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}


$type             = $_GET['type'];
$wd_arr 			=   array();

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT id,type,referral_links_homeowner,referral_links_tradsman FROM admin_settings WHERE type=? ORDER BY id DESC");
$tran_get->bind_param("s", $type);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$type,$referral_links_homeowner,$referral_links_tradsman);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	    $tradsman_ref_links_hm = explode(",",$referral_links_homeowner);
		 $tradsman_ref_links_tm = explode(",",$referral_links_tradsman);
		 $transaction_arr[] = array(
			'id'=>$id,
			'type'=>$type,
			 'trans_id'=>$trans_id,
			 'referral_links_homeowner'=>$tradsman_ref_links_hm,
			 'referral_links_tradsman'=>$tradsman_ref_links_tm,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'share_arr'=>$transaction_arr); 
jsonSendEncode($record);