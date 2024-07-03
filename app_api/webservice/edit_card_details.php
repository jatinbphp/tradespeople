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

		if(empty($_POST['name'])){
		$record=array('success'=>'false codr', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	



	// Get All Post Parameter
    $name		     =	$_POST['name'];
    $card_number	 =	$_POST['card_number'];
    $card_exp_month  =	$_POST['card_exp_month'];
    $card_exp_year   =	$_POST['card_exp_year'];
    $card_cvc		 =	$_POST['card_cvc'];
    $userid          = $_POST['user_id'];
    $bill_id         = $_POST['id'];
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


//-------------------------------------------------------------------------

$update_user_details = $mysqli->prepare("UPDATE billing_details SET name=?,card_number=?,card_exp_month=?,card_exp_year=?,card_cvc=?,updated_at=? WHERE id=?");
$update_user_details->bind_param("ssssssi",$name,$card_number,$card_exp_month,$card_exp_year,$card_cvc,$update_date,$bill_id );
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Card Details not Updated'); 
jsonSendEncode($record);
}

$record=array('success'=>'true','msg'=>'Card Details Updated'); 
jsonSendEncode($record);

?>
