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
    $userid			   	    = $_POST['user_id'];
    $bank_id                = $_POST['bank_id']; 
    $wd_account_holder      = $_POST['wd_account_holder'];
    $wd_bank                = $_POST['wd_bank'];
    $wd_account             = $_POST['wd_account'];
    $wd_ifsc_code           = $_POST['wd_ifsc_code'];
    $action                 = $_POST['action'];
    $paypal_email_address   = $_POST['paypal_email_address'];
    $account_holder_address = $_POST['account_holder_address'];
    $created_at			    = date("Y-m-d H:i:s");
    $update_date			= date("Y-m-d H:i:s");
    
	// define variable
 
//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,email,type,f_name,l_name,u_wallet,referral_earning,trading_name from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id,$email,$type,$f_name,$l_name,$u_wallet,$referral_earning,$trading_name);
	$check_user_all->fetch();


//-------------------------------------------------------------------------
//// EDIT bank Account
if($action=='edit') {
$transaction_add = $mysqli->prepare("UPDATE wd_bank_details SET wd_account_holder=?,wd_bank=?,wd_account=?,wd_ifsc_code=?,account_holder_address=?,paypal_email_address=? WHERE id=?");
	$transaction_add->bind_param("ssssssi",$wd_account_holder,$wd_bank,$wd_account,$wd_ifsc_code,$account_holder_address,$paypal_email_address,$bank_id);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}
	$message = 'Bank Detail updated successfully.';

} elseif($action=='add') {
	//// ADDD Bank Details
	$transaction_add = $mysqli->prepare("INSERT INTO `wd_bank_details`(`wd_user_id`, `wd_account_holder`, `wd_bank`, `wd_account`, `wd_ifsc_code`, `paypal_email_address`, `account_holder_address`, `created_at`) VALUES (?,?,?,?,?,?,?,?)");
	$transaction_add->bind_param("isssssss",$user_id,$wd_account_holder,$wd_bank,$wd_account,$wd_ifsc_code,$paypal_email_address,$account_holder_address,$created_at);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}
	
	$message = 'Bank Added successfully.';
	
}

   
	// response here
	$record	=	array('success'=>'true', 'msg'=> $message); 
	jsonSendEncode($record);   
?>
