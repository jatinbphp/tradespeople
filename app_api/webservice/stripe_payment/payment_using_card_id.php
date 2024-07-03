<?php
include 'stripe_config.php';
include '../con1.php';
include '../function_app_common.php';
include '../function_app.php';
include '../mailFunctions.php';
require 'vendor/autoload.php';


// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);

$msg = array('Please send data','Please send data','Please send data');
if(empty($_POST['user_id_post'])){
    $record=array('success'=>'false', 'msg'=>$msg);
	echo json_encode($record);
	return false;
}
        
if(empty($_POST['card_token_id'])){
    $record=array('success'=>'false', 'msg' =>$msg);
	echo json_encode($record);
	return false;
}

if(empty($_POST['customer_id'])){
  $record=array('success'=>'false', 'msg' =>$msg);
	echo json_encode($record);
	return false;
}

if(empty($_POST['amount'])){
  $record=array('success'=>'false', 'msg' =>$msg);
	echo json_encode($record);
	return false;
}

if(empty($_POST['descriptor_suffix'])){
  $record=array('success'=>'false', 'msg' =>$msg);
	echo json_encode($record);
	return false;
}
//if(empty($_POST['check_flag'])){
//  $record=array('success'=>'false', 'msg' =>$msg);
//  echo json_encode($record);
//  return false;
//}

$user_id            = $_POST['user_id_post'];
$card_token_id      = $_POST['card_token_id'];
$customer_id        = $_POST['customer_id'];
$plan_id            = $_POST['plan_id'];
$amount             = $_POST['amount'];
$check_flag         = $_POST['check_flag'];
$user_plan_id       = $_POST['user_plan_id'];
$plan_id            = $_POST['plan_id'];
// $transfer_amount    = $_POST['transfer_amount'];
$txn_id               = $card_token_id;
$updatetime=date('Y-m-d H:i:s');
$descriptor_suffix  = $_POST['descriptor_suffix'];
$add_on_id  =   $_POST['add_on_id'];
$pay_amount         = $amount*100;
$user_email_get     = '';
$payment_id = $card_token_id;

if(!empty($descriptor_suffix)){
  $statement_descriptor_suffix=$descriptor_suffix;
}


  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount'          => $pay_amount,//amount must be multiple of 100
    'currency'        => $currency,
    'description'     =>  $description, //max 22 charcaters
    'statement_descriptor_suffix'=>$statement_descriptor_suffix, //max 22 charcaters
    'customer'        => $customer_id,//pass customer ID
    'payment_method'  => $card_token_id,
    'off_session'     => true,
    'confirm'         => true
  ]);

if($paymentIntent->status=='succeeded')
{
//  $payment_txn_id = $paymentIntent->id;
  $payment_status = 1;
  $payment_txn_id =  $paymentIntent->charges->data[0]->balance_transaction;
	
	$paymentIntent_resp = ['paymentIntent'=>$paymentIntent];
	
	$paymentIntent_status = json_encode($paymentIntent_resp);
	
 // $update_all =   $mysqli->prepare("UPDATE `appointment_master` SET `txn_id`=?,`payment_status`=?,`payment_date`=?,`updatetime`=? WHERE appointment_id = ?");
	
$update_all =  $mysqli->prepare("INSERT INTO stripe_payment_master(user_id, amount, descriptor_suffix, payment_id,payment_status,paymentIntent,updatetime) VALUES (?,?,?,?,?,?,?)");
	
  $update_all->bind_param("issssss", $user_id, $amount, $descriptor_suffix, $payment_txn_id,$payment_status,$paymentIntent_status,$updatetime);
  $update_all->execute();
  $update_affected_rows   =   $mysqli->affected_rows;
  if($update_affected_rows<=0){
      $record=array('success'=>'false', 'msg'=>array('Unable to update','Unable to update','Unable to update')); 
      jsonSendEncode($record);
  }
if($check_flag=='update_plan'){
//////// addd Plan 
if($user_plan_id!=''){	
		$getCounty=$mysqli->prepare("SELECT `id`, `package_name`, `description`, `amount`, `bids_per_month`, `email_notification`, `sms_notification`, `unlimited_limited`, `is_delete`, `validation_type`, `status`, `duration_type`, `reward_amount`, `reward`, `category_listing`, `directory_listing`, `unlimited_trade_category`, `total_notification`, `is_free`, `free_plan_exp`, `free_bids_per_month`, `free_sms` FROM `tbl_package` WHERE  is_delete=0 and id=?");
	$getCounty->bind_param("i",$plan_id);
	$getCounty->execute();
	$getCounty->store_result();
	$getCounty_count=$getCounty->num_rows;  //0 1   
	if($getCounty_count <= 0){
		$record=array('success'=>'true','msg'=>array("Plan id not found","Plan id not found")); 
		jsonSendEncode($record);
	}   
	$getCounty->bind_result($id, $package_name, $description, $amount, $bids_per_month, $email_notification, $sms_notification, $unlimited_limited, $is_delete, $validation_type, $status, $duration_type, $reward_amount, $reward, $category_listing, $directory_listing, $unlimited_trade_category, $total_notification, $is_free, $free_plan_exp, $free_bids_per_month, $free_sms);
	$getCounty->fetch();
	$cdate = date('Y-m-d h:i:s');
	$upstatus = 1; 
	$one_time = 1;
	if($one_time == 1){
		$credits_per_month=0;
		if(!is_null($free_bids_per_month)){
		 	$bids = explode(" ",$free_bids_per_month);
			$credits_per_month = $bids[0];
		}
		$up_startdate = date('Y-m-d');
		
		if($free_plan_exp!=''){
		$bids = explode(" ",$bids_per_month);
    	$credits_per_month = $bids[0];
    	$free_sms = $sms_notification;
 
		$up_enddate = date('Y-m-d',strtotime($up_startdate. '+ '.$free_plan_exp));
		$up_enddate = date('Y-m-d',strtotime($up_enddate. '- 1 day'));
	}else{
		$bids = explode(" ",$free_bids_per_month);
    	$credits_per_month = $bids[0];
    	$free_sms = $free_sms;
        $up_enddate = date('Y-m-d',strtotime($up_startdate. '+ '.$validation_type));
		$up_enddate = date('Y-m-d',strtotime($up_enddate. '- 1 day'));
	}
	//	$up_enddate = date('Y-m-d',strtotime($up_startdate. '+ '.$free_plan_exp));
	//	$up_enddate = date('Y-m-d',strtotime($up_enddate. '- 1 day'));
		$up_used_bid = 0;
		$used_sms_notification = 0;
		$up_status = 1;
		$bid_type = 1;
        
		$plan_add = $mysqli->prepare("UPDATE `user_plans` set `up_status`=?, `up_update`=?,up_transId=?,bid_type = 1,used_sms_notification = 0,up_used_bid = 0 where up_id = ?");
		$plan_add->bind_param("issi",$upstatus,$cdate,$payment_id,$user_plan_id);	
$plan_add->execute();		
	
	}	
	$updatetime=date("Y-m-d H:i:s");
	$get_user = getUserDetails($user_id);
	if($reward==1){
		$wallet = $get_user['u_wallet'] + $reward_amount;
		
		$update3 =   $mysqli->prepare('UPDATE users SET u_wallet=?  WHERE id=?');
		$update3->bind_param('si',$wallet,$user_id);
		$update3->execute();
		
		$tr_userid = $get_user['id'];
		$tr_message = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$amount.' has been renewed and you have been rewarded <i class="fa fa-gbp"></i>'.$reward_amount.' of '.$package_name. 'plan.';
		$tr_amount = $amount;
		$tr_transactionId = $traId;
		$tr_status = $status;
		$tr_reward=1;
		$tr_plan=$id;
		$tr_paid_by='Stripe';
	} else {
		$tr_userid = $get_user['id'];
		$tr_message = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$amount.' has been renewed';
		$tr_amount = $amount;
		$tr_transactionId = $payment_txn_id;
		$tr_status = 1;
		$tr_plan=$id;
		$tr_paid_by='Stripe';
	}
	$tr_type=1;
	$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,`tr_message`,`tr_transactionId`,`tr_plan`,`tr_paid_by`) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiissssss",$tr_userid,$tr_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid,$tr_plan,$tr_paid_by);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>$p_transaction_err); 
			jsonSendEncode($record);
		}
	
	

}
	
}
if($check_flag=='buy_addon'){ 
	//get addons===========
    
	$get_add_on=$mysqli->prepare("SELECT `id`, `amount`, `type`, `description`, `quantity` FROM `addons` WHERE id=?");
	$get_add_on->bind_param("i",$add_on_id);
	$get_add_on->execute();
	$get_add_on->store_result();
	$get_add_on_count=$get_add_on->num_rows;  //0 1   
	if($get_add_on_count <= 0){
		$record=array('success'=>'true','msg'=>array("Addon id not found","Addon id not found")); 
		jsonSendEncode($record);
	}   
	$get_add_on->bind_result($id,$amount,$add_on_type,$description,$quantity);
	$get_add_on->fetch();
	//get addons end===========



	$no_of_bids = 0; 

	//get user plan==========================
	$get_user_plan=$mysqli->prepare("SELECT `up_transId`, `up_bid`, `total_sms`,up_user FROM `user_plans` WHERE up_id=?");
	$get_user_plan->bind_param("i",$user_plan_id);
	$get_user_plan->execute();
	$get_user_plan->store_result();
	$get_user_plan_count=$get_user_plan->num_rows;  //0 1   
	if($get_user_plan_count <= 0){
		$record=array('success'=>'true','msg'=>array("User plan id not found","User plan id not found")); 
		jsonSendEncode($record);
	}   
	$get_user_plan->bind_result($up_transId, $up_bid, $total_sms,$up_user);
	$get_user_plan->fetch();
	//update plan================== 
	$up_bid=($up_bid!='') ? $up_bid: 0;
	if($add_on_type==1){
		$no_of_bids = $quantity+$up_bid;
		$plan_update = $mysqli->prepare('UPDATE user_plans SET up_bid=?,up_transId=?,up_update=? WHERE up_id=?');
	}else{
		$no_of_bids = $quantity+$total_sms;
		$plan_update = $mysqli->prepare('UPDATE user_plans SET total_sms=?,up_transId=?,up_update=? WHERE up_id=?');
	} 
	$plan_update->bind_param("sssi",$no_of_bids,$payment_id,$updatetime,$user_plan_id);   
	$plan_update->execute();
	$plan_update_affect_row = $mysqli->affected_rows;
	if($plan_update_affect_row<=0){
		 $record=array('success'=>'false','msg'=>"Unable to add addon"); 
		 jsonSendEncode($record);
	}
	
	$check_user_all = $mysqli->prepare("SELECT id,spend_amount,u_wallet,f_name,email from users where id=?");
    $check_user_all->bind_param("i",$user_id);
    $check_user_all->execute();
    $check_user_all->store_result();
    $check_user   = $check_user_all->num_rows;  //0 1
    $check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet,$fname,$email);
    $check_user_all->fetch();
	
	//// Transaction ADD
	
	$tr_userid = $user_id_get;
	$tr_message = 'Your have purchased addon of amount <i class="fa fa-gbp"></i>'.$amount;
	$tr_amount = $amount;
	$tr_transactionId = md5(rand(1000,999).time());
	$tr_status = 1;
	$tr_type = 1;
	$updatetime =  date("Y-m-d H:i:s");
	
	$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,`tr_message`,`tr_transactionId`) VALUES (?,?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiissss",$tr_userid,$tr_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$tr_transactionId);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>$p_transaction_err); 
			jsonSendEncode($record);
		}
	

	$subject = 'Your TradespeopleHub account funded successfully.';
	
		$html .= '<p style="margin:0;padding:10px 0px">Hi '.$fname.',</p>';
		$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now quote jobs using those funds.</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$amount.'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		$mailBody = send_mail_app($html);
		//end email temlete================
		$mailResponse  =  mailSend($email, $fname, $subject, $mailBody);
	//update plan end================
}
if($check_flag=='wallet_update'){ 
	
	  //-------------------------- check user_id --------------------------
		$u_wallet = 0;
		$u_wallet1 = 0;
		$check_user_all	=	$mysqli->prepare("SELECT id,spend_amount,u_wallet,f_name,email from users where id=?");
		$check_user_all->bind_param("i",$user_id);
		$check_user_all->execute();
		$check_user_all->store_result();
		$check_user		=	$check_user_all->num_rows;  //0 1
		$check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet,$fname,$email);
		$check_user_all->fetch();

		$u_wallet1 = $amount+$u_wallet;

		$signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=? WHERE id=?");
		$signup_add->bind_param("si",$u_wallet1,$user_id);	
		$signup_add->execute();
		$signup_add_affect_row=$mysqli->affected_rows;
		if($signup_add_affect_row<=0){
			// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
			// jsonSendEncode($record);
		}
		$subject = 'Your TradespeopleHub account funded successfully.';
	
		$html .= '<p style="margin:0;padding:10px 0px">Hi '.$fname.',</p>';
		$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now quote jobs using those funds.</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$spend_amount.'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		$mailBody = send_mail_app($html);
		//end email temlete================
		$mailResponse  =  mailSend($email, $fname, $subject, $mailBody);
	
	$update_user_master = $mysqli->prepare("UPDATE `users` SET `free_trial_taken`=1 WHERE  id=?");
	$update_user_master->bind_param("i",$user_id);	
	$update_user_master->execute();
	$update_user_master_affect_row=$mysqli->affected_rows;
	
	// Save Card
	$stripe_card=$stripe->paymentMethods->retrieve(
          $payment_method,
          []
        ) ;
        
        //print_r($stripe_card);
		//echo $json_obj = json_encode($stripe_card);
        $token_id = $stripe_card->id;
    
        $card_id = $stripe_card->id;
        $exp_month = $stripe_card->card->exp_month;
        $exp_year = $stripe_card->card->exp_year;
        $last4 = $stripe_card->card->last4;
		$customer = $stripe_card->customer;
        $country = $stripe_card->card->country;
		$brand = $stripe_card->card->brand;
	
		$email='NA';
		$user_arr   =  getUserDetails($user_id);	
		if($user_arr != 'NA'){
			$email = $user_arr['email'];
		}
		
		//echo '$customer='.$customer;
	//echo '$user_id='.$user_id;
		$seelct_save_card_all =$mysqli->prepare("SELECT user_id from save_cards where user_id = ? AND id=?");
		$seelct_save_card_all->bind_param("is", $user_id, $previous_card_id);
		$seelct_save_card_all->execute();
		$seelct_save_card_all->store_result();
		$seelct_save_card = $seelct_save_card_all->num_rows;  //0 1
	//echo '$seelct_save_card='.$seelct_save_card;
		if($seelct_save_card > 0)
		{
			//--------------- update card details ------------------	
			$update = $mysqli->prepare("UPDATE save_cards SET customer_id=?, u_name=?, email=?, payment_method=?, updated_at=?, exp_year=?, exp_month=?, country=?, last4=?, brand=? WHERE user_id=?");
			$update->bind_param("sssssiisisi",$customer, $card_u_name, $email, $payment_method, $updated_at, $exp_year, $exp_month, $country, $last4, $brand,$user_id);	
			$update->execute();
			$update_row=$mysqli->affected_rows;
			//echo '$update_row='.$update_row;
			
		}else{
			//--------------- insert card details ------------------	
			
			$status   = 1;
			$created_at 		   = date('Y-m-d H:i:s');			
			$updated_at 		   = date('Y-m-d H:i:s');

			$insert = $mysqli->prepare("INSERT INTO save_cards(user_id, customer_id, u_name, email, payment_method, status, created_at, updated_at, exp_year, exp_month, country, last4, brand) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$insert->bind_param("issssissiisis",$user_id, $customer, $card_u_name, $email, $payment_method, $status, $created_at, $updated_at, $exp_year, $exp_month, $country, $last4, $brand);	
			$insert->execute();
			$insert_row=$mysqli->affected_rows;
			//echo '$insert_row='.$insert_row;
			
		}
	
	      // update transaction table======================
			$tr_userid = $user_id;
			$tr_message = '£'.$amount.' has been deposited to your wallet via card payment.</b>';
			$tr_amount = $amount;
			$tr_type = 1;
			$tr_transactionId = $payment_txn_id;
			$tr_status = $status;
			$tr_paid_by='Stripe';
			$is_deposit=1;
	        $tr_status=1;
            $updatetime = date('Y-m-d H:i:s');
			$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`, tr_message, tr_transactionId,is_deposit,tr_paid_by) VALUES (?,?,?,?,?,?,?,?,?,?)");
			$transaction_add->bind_param("isiissssss",$tr_userid,$tr_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$tr_transactionId,$is_deposit,$tr_paid_by);	
			$transaction_add->execute();
			$transaction_add_affect_row=$mysqli->affected_rows;
			if($transaction_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>$p_transaction_err); 
				jsonSendEncode($record);
			}
}	
	
	

  $output = [
    'success'=>'true','msg'=>'Payment success', 'clientSecret' => $paymentIntent,'paymentIntent'=>$paymentIntent
  ];
  echo json_encode($output);
	return false;
}
else
{
  $output = [
    'success'=>'false','msg'=>'Payment failed'.$paymentIntent->status
  ];
  echo json_encode($output);
	return false;
}



?>