<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
// include 'authorized.php'; 


if(!$_GET){
	$record=array('success'=>'false','msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['language']) && $_GET['language']!=0){
	$record=array('success'=>'false','msg' =>$msg_empty_param); 
	jsonSendEncode($record);
}
if(empty($_GET['user_id_post'])){
	$record=array('success'=>'false','msg' =>$msg_empty_param); 
	jsonSendEncode($record);
}

$language   		=   $_GET['language'];
$user_id_post    	=   $_GET['user_id_post'];
$updatetime 		=   date('Y-m-d H:i:s');


//-------------------------- check user_id --------------------------
$check_user_all=$mysqli->prepare("SELECT user_id from user_master where delete_flag=0 and user_id=?");
$check_user_all->bind_param("i",$user_id_post);
$check_user_all->execute();
$check_user_all->store_result();
$check_user=$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
	jsonSendEncode($record);
}

$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();

//----------------------------- check account activate or not ----------------------
$active_status = checkAccountActivateDeactivate($user_id_get);
if($active_status == 0){
	$record=array('success'=>'false','msg' =>$msg_error_activation, 'account_active_status'=>$active_status); 
	jsonSendEncode($record); 
}


// ----------- update appointment parts ----------- //
$update_all = $mysqli->prepare("UPDATE user_master SET language_id=?, updatetime=? WHERE user_id =?");
$update_all->bind_param("isi", $language, $updatetime, $user_id_post);
$update_all->execute();
$update = $mysqli->affected_rows;
if($update <= 0){	
	$record = array('success'=>'false', 'msg'=>$msg_error_lang_change); 
	jsonSendEncode($record); 
}
// ========================= Response ========================= //
$record=array('success'=>'true', 'msg'=>$msg_success_lang_change,'language'=>$language); 
jsonSendEncode($record);
?>















