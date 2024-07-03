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
    if(empty($_POST['transfer_type'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	


	// Get All Post Parameter
    $userid			   	    = $_POST['user_id'];
    $transfer_type          = $_POST['transfer_type']; 
    $amount                 = $_POST['amount'];
    $trans_id               = mt_rand(10000, 99999);
	// define variable
	$update_date			=	date("Y-m-d H:i:s");
   if($transfer_type == 'Wallet request') {
		$status = 1;
	}

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,email,type,f_name,l_name,u_wallet,referral_earning from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id,$email,$type,$f_name,$l_name,$u_wallet,$referral_earning);
	$check_user_all->fetch();


//-------------------------------------------------------------------------

if($type==1){
			$message = 'Your referral earnings has been added to your wallet successfully. You can now use it to pay for your quote';
		}elseif($type==2){
			$message = 'Your referral earnings has been added to your wallet successfully. You can now pay for your job using them';
		}else{
			$message = 'Request has been submitted successfully..';
		}


if($referral_earning == 0){
	$record=array('success'=>'false','msg'=>'There is no balance to cashout'); 
	jsonSendEncode($record);
} else {
	if($amount > $referral_earning){
		$record=array('success'=>'false','msg'=>'There is not enough balance'); 
	   jsonSendEncode($record);
	}
}


$transaction_add = $mysqli->prepare("INSERT INTO `referral_payout_requests`(`user_id`, `trans_id`, `request_amount`, `payment_method`, `status`) VALUES (?,?,?,?,?)");
	$transaction_add->bind_param("iisss",$user_id,$trans_id,$amount,$transfer_type,$status);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		jsonSendEncode($record);
	}

$ini_balance = $referral_earning;
$balance = $ini_balance - $amount;

if ($transfer_type == 'Wallet request') {
	 $wallet = $u_wallet + $amount;
	
$update_user_details = $mysqli->prepare("UPDATE users SET referral_earning=?, u_wallet=? WHERE id=?");
$update_user_details->bind_param("ssi",$balance,$wallet,$userid);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
jsonSendEncode($record);	
}
	
	} else {

$update_user_details = $mysqli->prepare("UPDATE users SET referral_earning=? WHERE id=?");
$update_user_details->bind_param("si",$balance,$userid);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
jsonSendEncode($record);	
}
	
}




	// response here
	$record	=	array('success'=>'true', 'msg'=> $message); 
	jsonSendEncode($record);   
?>
