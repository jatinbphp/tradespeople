<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
 
$user_id             =   $_GET['user_id'];
$acc_no             =   $_GET['acc_no'];
$bank_name          =   $_GET['bank_name'];
$sort_code          =   $_GET['sort_code'];
$acc_holder         =   $_GET['acc_holder'];
$home_withd_id      =   $_GET['home_withd_id'];


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,f_name,l_name from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$f_name,$l_name);
$check_user_all->fetch();





$check_home_withd	=	$mysqli->prepare("SELECT status from homeowner_fund_withdrawal where id=?");
$check_home_withd->bind_param("i",$home_withd_id);
$check_home_withd->execute();
$check_home_withd->store_result();
$check_user11		=	$check_home_withd->num_rows;  //0 1
if($check_user11 <= 0){
	$record		=	array('success'=>'false', 'msg'=>array("Something went wrong, please try again later")); 
	jsonSendEncode($record);
}
$check_home_withd->bind_result($h_status);
$check_home_withd->fetch();
if($h_status>0){
	$record		=	array('success'=>'false', 'msg'=>array("Your bank detail has been submitted successfully and awaits our team confirmation.")); 
	jsonSendEncode($record);
}



 // update user master=======
$status = 3;
echo "";
$update_home_withdraw = $mysqli->prepare("UPDATE `homeowner_fund_withdrawal` SET status=?,account_holder_name=?,bank_name=?,account_number=?,short_code=?  WHERE id=?");
$update_home_withdraw->bind_param("sssssi",$status,$acc_holder,$bank_name,$acc_no,$sort_code,$home_withd_id);	
$update_home_withdraw->execute();
$update_home_withdraw_affect_row=$mysqli->affected_rows;
if($update_home_withdraw_affect_row<=0){
	$record=array('success'=>'false','msg'=>array("Something went wrong, Please try again later")); 
	jsonSendEncode($record);
}
 
 


$record=array('success'=>'true','msg'=>array('Your bank detail has been submitted successfully and awaits our team confirmation.')); 
jsonSendEncode($record);

?>