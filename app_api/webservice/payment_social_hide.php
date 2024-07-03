<?php
ini_set('display_errors', 1);
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';	
include 'mailFunctions.php';
// check method here

//--------------------------status--------------------------
$payment_hide_show=0;
$social_hide_show=0;

$check_status_all = $mysqli->prepare("SELECT id,payment_method FROM admin WHERE 1=1");
$check_status_all->execute();
$check_status_all->store_result();
$check_status = $check_status_all->num_rows;  //0 1
if ($check_status > 0) {
	$check_status_all->bind_result($hide_show_id, $payment_method);
	$check_status_all->fetch();
    $payment_hide_show=$payment_method;
	$social_hide_show=0;
}



//---------------------------------------status-----------------------------
$record	=	array('success'=>'true','msg'=>$data_found,'payment_hide_show'=>$payment_hide_show, 'social_hide_show'=>$social_hide_show); 
jsonSendEncode($record);   
?>