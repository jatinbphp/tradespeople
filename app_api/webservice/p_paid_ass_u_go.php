<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_get_method); 
		jsonSendEncode($record); 
	}
 
	// Email
	if(empty($_POST['txn_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	


	if(empty($_POST['amount'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
if(!empty($_POST['status'])){
	$status 				= $_POST['status'];
	}
else{
$status = 0;
}
	
	 

	$amount 				= $_POST['amount'];
	$user_id 				= $_POST['user_id'];
	
	$updatetime	 			= date('Y-m-d h:i:s');
	$txn_id 				= $_POST['txn_id'];
 	$tr_type = 1;
	$spend_amount1 = 0;
	$wallet_amount = 0;
		//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,category,spend_amount,u_wallet from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$category,$spend_amount,$u_wallet);
	$check_user_all->fetch(); 	
	$wallet_amount = $amount+$u_wallet;



 
    $signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=?  WHERE id=?");
	$signup_add->bind_param("si",$wallet_amount,$user_id);	
	$signup_add->execute();
	$signup_add_affect_row=$mysqli->affected_rows;
	if($signup_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
		jsonSendEncode($record);
	}
	 

	$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_transactionId`, `tr_status`, `tr_created`, `tr_update`) VALUES (?,?,?,?,?,?,?)");
			$transaction_add->bind_param("isisiss",$user_id,$amount,$tr_type,$txn_id,$tr_type,$updatetime,$updatetime);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>$p_transaction_err); 
		jsonSendEncode($record);
	}
 

	$update_user_master = $mysqli->prepare("UPDATE `users` SET `free_trial_taken`=1 WHERE  id=?");
		$update_user_master->bind_param("i",$user_id);	
		$update_user_master->execute();
		$update_user_master_affect_row=$mysqli->affected_rows;


	$credit_amt  	=  getToCreditAmount($user_id);
    $debit_amt   	=  getToDebitAmount($user_id);
	$total_balance  =  getWalletBalance($user_id);
	$user_details	=	getUserDetails($user_id);

if($status==0)
{
	$subject = 'Thank you for Signing up to Tradespeoplehub.co.uk';
       $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_details['f_name'].',</p>';
	$html .= '<p style="margin:0;padding:10px 0px;font-size:20px"> Welcome to TradespeopleHub! .</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local jobs.</p>';
	$html .= '<p style="margin:0;padding:10px 0px"> We are excited to have you on board, and now you have access to the core functionality you need to build your business with us.</p>';

$html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Pay as you Go Plan
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">With pay as you go option, you can add credit to your wallet and use it at any time you wish to enjoy our service.
 </p>';
 $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Changing to Subscription Plan:
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">If you would like to switch to the monthly plan, log in to your account and click on the “Upgrade tab” link in the upper left-hand corner. 
 </p>';

 $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Tradespeoplehub provides access to over 100K jobs posted by homeowners.
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">
Here are a few steps of what we require you to do to start winning and doing those jobs.
 </p>';

 $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Complete your profile
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Get the homeowner to know you by completing your profile page. Tradespeople that did this have seen 30% more success. So, give yourself a head start by uploading your photo and images of your past projects.
 </p>';	

$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Complete Profile</a>
    </div>';
    
    
    
     $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Verify account
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">To verify your account, upload a copy of your proof of address document and ID on to-do list part of your account. We accept UK/EU valid driving license or passport as proof of ID.

 </p>';	

$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Verify account now
</a>
    </div>';
    $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;font-weight: bold">
Start winning & doing jobs. 
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">We will begin to send you job leads in your area if we have not started already. When homeowners post a new job on TradespeopleHub which is within your selected distance of travelling, we will send you an email and text message with a link to view and quote the post.</p>';	

$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">View job leads  
</a>
    </div>';
$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you are unsure how to verify your account or have any specific questions using our service.</p>';
     	$mailBody = send_mail_app($html);
		//end email temlete================
		$mailResponse  =  mailSend($user_details['email'], 'Admin', $subject, $mailBody);
}

else{

	$subjectF = 'Your TradespeopleHub account funded successfully.';
       $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_details['f_name'].',</p>';
	$html .= '<p style="margin:0;padding:10px 0px"> A fund has been deposited to your Tradespeoplehub account. You can now  You can now quote jobs using those funds. </p>';
	$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £ '.$amount.' </p>';
   $html .= '<p style="margin:0;padding:10px 0px">Deposit method: PayPal  </p>';
$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
     	$mailBody = send_mail_app($html);
		//end email temlete================
		$mailResponse  =  mailSend($user_details['email'], 'Admin', $subjectF, $mailBody);

}




	$record	=	array('success'=>'true', 'msg'=>$p_transaction_succ,'credit_amt'=>$credit_amt,'debit_amt'=>$credit_amt,'total_balance'=>$total_balance,'user_details'=>$user_details,'mailResponse'=>$mailResponse); 
	jsonSendEncode($record);   
?>