<?php

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'mailFunctions.php';
include 'language_message.php';
// include 'authorized.php'; 

if(!$_POST){
	$record=array('success'=>'false','msg' =>$msg_post_method); 
	jsonSendEncode($record);
}

//for email
if(empty($_POST['email'])){
	$record=array('success'=>'false','msg' =>array('Mail email required')); 
	jsonSendEncode($record);
}
if(empty($_POST['mailsubject'])){
	$record=array('success'=>'false','msg' =>array('Mail subject required')); 
	jsonSendEncode($record);
}
if(empty($_POST['mailcontent'])){
	$record=array('success'=>'false','msg' =>array('Mail content required')); 
	jsonSendEncode($record);
}
if(empty($_POST['fromName'])){
    $record=array('success'=>'false','msg' =>array('Mail fromName required')); 
    jsonSendEncode($record);
}

//-------------------------------- get all value in variables -----------------------
$email      = $_POST['email'];
$mailBody   = $_POST['mailcontent'];
$subject    = $_POST['mailsubject'];
$fromName   = $_POST['fromName'];

$mailResponse  =  mailSend($email, $fromName, $subject, $mailBody);

if($mailResponse == 'yes'){
    $record =  array('success'=>'true', 'msg'=>array("Email send successfully"), 'mailResponse'=>$mailResponse); 
    jsonSendEncode($record);
}else{
    
  $record =  array('success'=>'false', 'msg'=>array("Email not send"), 'mailResponse'=>$mailResponse); 
    jsonSendEncode($record);   
}



?>