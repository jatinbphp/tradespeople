<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';


$id=1;
$check_user_all	    =	$mysqli->prepare("SELECT search_api_key from admin where id=?");
$check_user_all->bind_param("i",$id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($search_api_key);
$check_user_all->fetch();


$record=array('success'=>'true','msg'=>array('data found'),'api_key'=>$search_api_key); 
jsonSendEncode($record);
