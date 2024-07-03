<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';


	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}

	if(empty($_POST['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
    if(empty($_POST['job_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	


	// Get All Post Parameter
    $userid			   	    =	$_POST['user_id'];
    $job_id			   	    =	$_POST['job_id'];
    $reason			        =	$_POST['reason'];
    
	// define variable
	$update_date			=	date("Y-m-d H:i:s");

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,email,type,f_name,l_name from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id,$email,$type,$f_name,$l_name);
	$check_user_all->fetch();


//-------------------------------------------------------------------------

$transaction_add = $mysqli->prepare("INSERT INTO `report_job`(`user_id`, `job_id`, `reason`, `created_at`) VALUES (?,?,?,?)");
	$transaction_add->bind_param("iiss",$user_id,$job_id,$reason,$update_date);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}

	// response here
	$record	=	array('success'=>'true', 'msg'=>'Job Reported Successfully'); 
	jsonSendEncode($record);   
?>
