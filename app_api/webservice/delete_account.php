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

	


	// Get All Post Parameter
    $userid			   	    =	$_POST['user_id'];
    $delete_request         = 1;
    $delete_reason          = $_POST['delete_reason'];
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

//$full_name = $f_name.' '.$l_name;

$update_user_details = $mysqli->prepare("UPDATE users SET delete_request=?, delete_reason=? WHERE id=?");
$update_user_details->bind_param("ssi",$delete_request,$delete_reason,$userid);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
jsonSendEncode($record);	
}

$transaction_add = $mysqli->prepare("INSERT INTO `delete_account_request`(`user_id`, `user_type`, `name`, `email`, `delete_request`, `delete_reason`) VALUES (?,?,?,?,?,?)");
	$transaction_add->bind_param("iissss",$user_id,$type,$f_name,$email,$delete_request,$delete_reason);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}

	// response here
	$record	=	array('success'=>'true', 'msg'=>'Deleted Successfully'); 
	jsonSendEncode($record);   
?>
