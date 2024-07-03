<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
   include 'mailFunctions.php';
	include 'language_message.php';
	
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}
 	
 	$plan_id 		=	$_GET['plan_id'];
	$plan_arr		= 	array();
	$updatetime 	=	date('Y-m-d H:i:s');


	$check_plan_id=$mysqli->prepare("SELECT `up_id`,up_planName,up_user,up_enddate FROM `user_plans` WHERE up_id=?");
	$check_plan_id->bind_param("i",$plan_id);
	$check_plan_id->execute();
	$check_plan_id->store_result();
	$check_plan_id_count=$check_plan_id->num_rows;  //0 1	
	if($check_plan_id_count <= 0){
		$record=array('success'=>'false','msg'=>array("Unable to find plan id","Unable to find plan id")); 
		jsonSendEncode($record);
	}
$check_plan_id->bind_result($user_planid,$up_planName,$up_user,$up_enddate);
	$check_plan_id->fetch();
	$upadte_plan = 0;
	// update plan ---------------------------------
	$update_plan = $mysqli->prepare("UPDATE `user_plans` set `up_update`=?,auto_update=? where up_id = ?");
	$update_plan->bind_param("ssi",$updatetime,$upadte_plan,$plan_id);   
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to update plan","Unable to update plan")); 
		jsonSendEncode($record);
	}
$postData_new = getUserDetails($up_user);
$subject	=	$up_planName.' plan has been deactivated';
$html .='<p style="margin:0;padding:10px 0px">We are sad to see you go.
</p>';
	$html .='<p style="margin:0;padding:10px 0px">You have cancelled your Tradespeople Hub monthly subscription which will end on '.$up_enddate.' .
</p>';


	$html .='<p style="margin:0;padding:10px 0px">You can continue to access your membership benefits until your subscription ends.
</p>';
$html .='	<p style="margin:0;padding:10px 0px">When your subscription ends, you will not be able to provide quotes, receive instant job notification and respond to special job offer.
</p>';
$html .='<p style="margin:0;padding:10px 0px">We want to keep seeing you on our platform, so if the price is the problem for wanting to leave us, we would like to invite you to use our "Pay As You Go" option. You can easily activate it now by clicking.
</p>';
$html .='<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Pay as you go</a>
    </div>';


	$html .='<p style="margin:0;padding:10px 0px">If you want to come back, our membership plan is just a click away. All you have to do is to reactivate your subscription.
 </p>';
$html .='<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Reactivate the subscription</a>
    </div>';
	
	$html .='<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.
 </p>';	

$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($postData_new['email'],$postData_new['fromName'], $subject, $mailBody);
	$msg = array('Subscription Plan has been deactivated successfully.','Subscription Plan has been deactivated successfully.','Subscription Plan has been deactivated successfully.');

	$record=array('success'=>'true','msg'=>$msg); 
	jsonSendEncode($record);
?>