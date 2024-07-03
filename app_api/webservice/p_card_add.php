<?php
	ini_set('display_errors', 1);	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include('language_message.php');
 
 
	if(!$_POST){
		$record=array('success'=>'false', 'msg' =>$msg_post_method); 
		jsonSendEncode($record);
	}
	
	if(empty($_POST['number'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param);
		jsonSendEncode($record);
	}

	if(empty($_POST['expMonth'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	if(empty($_POST['expYear'])){
	    
	    
	    
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
		jsonSendEncode($record);	
	    
	}	
	
	if(empty($_POST['cvc'])){
		$record = array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	if(empty($_POST['user_id'])){
		$record = array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	
	

	//----------------- get all value in variables -----------------------
	$number			=	trim($_POST['number']);
	$expMonth    	=	$_POST['expMonth'];
	$expYear		=	$_POST['expYear'];
	$cvc			=	$_POST['cvc'];
	$user_id		=	$_POST['user_id'];
	$name    		=	$_POST['name'];


    $postData['number']					=	$number;	
    $postData['expMonth']				=	$expMonth;	
    $postData['expYear']				=	$expYear;	
    $postData['cvc']			    	=	$cvc;	
    $postData['user_id']		        =	$user_id;
	// Connect card detail into Stripe
	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT  id from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}

	
	$cdate 		   = date('Y-m-d h:i:s');
	$signup_add = $mysqli->prepare("INSERT INTO `billing_details`(`name`, `card_number`, `card_exp_month`, `card_exp_year`, `card_cvc`, `user_id`, `updated_at`, `created_at`) VALUES (?,?,?,?,?,?,?,?)");
	$signup_add->bind_param("sssssiss",$name,$number,$expMonth,$expYear,$cvc,$user_id,$cdate,$cdate);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
		jsonSendEncode($record);
	}


	

	// $u_pay_verify=1;
	// $update_user_details = $mysqli->prepare("UPDATE `users` SET u_pay_verify=? WHERE id=?");
	// $update_user_details->bind_param("ii",$u_pay_verify,$user_id);
	// $update_user_details->execute();
	// $update_affected_rows	=	$mysqli->affected_rows;
	// if($update_affected_rows<=0){
	// 	$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
	// 	jsonSendEncode($record);
	// }
  
    $record=array('success'=>'true', 'msg' =>array("Your card is added successfully","Your card is added successfully")); 
   jsonSendEncode($record);

?>
