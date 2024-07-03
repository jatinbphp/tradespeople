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
if(empty($_GET['post_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id             = $_GET['user_id'];
$post_id            = $_GET['post_id'];
$wd_arr 			=   array();

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT id,milestone_name FROM tbl_milestones where post_id=? AND userid=? AND (status!=2 && status!=5 && status!=6) ORDER BY id DESC");
$tran_get->bind_param("ii",$post_id,$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$milestone_name);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	     
		 $transaction_arr[] = array(
			'id'=>$id,
			'milestone_name'=>$milestone_name,
			);
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'milestone_arr'=>$transaction_arr); 
jsonSendEncode($record);