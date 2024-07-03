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
		$record=array('success'=>'false detail', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

	




    $userid			   	=	$_POST['user_id'];
    $selected_sub_cat		   	=	$_POST['selected_sub_cat'];
    $category		        	=	$_POST['category'];  
    $signup_step=1;


	// define variable
	$update_date			=	date("Y-m-d H:i:s");

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();


   
$update_user_details = $mysqli->prepare("UPDATE users SET category=?,subcategory=?,	signup_step=? WHERE id=?");
$update_user_details->bind_param("ssii",$category,$selected_sub_cat,$signup_step,$userid);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>$msg_error_jobadd); 
jsonSendEncode($record);
}


///----------------------------job upload file--------------------


/// Reffer System

  //--------------------------------------


    $user_details	=	getUserDetails($user_id_get); 	
	// response here
	$record	=	array('success'=>'true', 'msg'=>$msg_job_pot_succ, 'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>
