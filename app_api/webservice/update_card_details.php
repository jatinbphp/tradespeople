	
<?php
 

    include 'con1.php';
    include 'function_app_common.php'; 
    include 'function_app.php';
    include('language_message.php');
    include('mailFunctions.php');

    if(!$_GET){
        $record=array('success'=>'false','msg' =>$msg_get_method); 
        jsonSendEncode($record); 
    }

    if(empty($_GET['txn_id'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    }
    
    if(empty($_GET['user_id'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    } 
    //-------------------------------- get all value in variables -----------------------
 
    $txn_id        =   $_GET['txn_id'];
    $user_id       =   $_GET['user_id'];
$payment_method = $_GET['payment_method'];
	$is_verified   =   1;
	$cdate 		   =   date('Y-m-d h:i:s');

	$seelct_data_all =$mysqli->prepare("SELECT stripe_customer_id, customer_id from stripe_customer_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data <= 0){

	}
	$seelct_data_all->bind_result($stripe_customer_id,$customer_id);
	$seelct_data_all->fetch();

	$arr = array('customerID'=>$customer_id,'payment_method'=>$payment_method);
	
	$serialize = serialize($arr);

	//$arr = json_encode($arr);

 	$seelct_data_all1 =$mysqli->prepare("SELECT `id` from billing_details WHERE is_payment_verify=1 and user_id=?");
		$seelct_data_all1->bind_param("i", $user_id);
		$seelct_data_all1->execute();
		$seelct_data_all1->store_result();
		$seelct_data1 = $seelct_data_all1->num_rows;  //0 1
		if($seelct_data1 <= 0){
			$signup_add = $mysqli->prepare("INSERT INTO `billing_details`(stripe_data, `is_payment_verify`,user_id) VALUES (?,?,?)");
			$signup_add->bind_param("sii",$serialize,$is_verified,$user_id);	
			$signup_add->execute();
			$signup_add_affect_row=$mysqli->affected_rows;
			if($signup_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again laters")); 
				jsonSendEncode($record);
			}
		}
	$u_pay_verify=1;
 
	$update_user_details = $mysqli->prepare("UPDATE `users` SET u_pay_verify=? WHERE id=?");
	$update_user_details->bind_param("ii",$u_pay_verify,$user_id);
	$update_user_details->execute();
	$update_affected_rows	=	$mysqli->affected_rows;
	if($update_affected_rows<=0){
		 
	}
	$record=array('success'=>'true','msg'=>array("Success")); 
	jsonSendEncode($record);
?>