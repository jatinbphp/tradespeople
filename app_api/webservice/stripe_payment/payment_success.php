<?php
include 'stripe_config.php';
include '../con1.php';
include '../function_app_common.php';
include '../function_app.php';
include '../mailFunctions.php';

require 'vendor/autoload.php';

// This is your real test secret API key.
//\Stripe\Stripe::setApiKey($secret_key);
$stripe = new \Stripe\StripeClient($secret_key);


$user_id            =   $_GET['user_id'];
$order_id           =   $_GET['order_id'];
$payment_id         =   $_GET['payment_id'];
$payment_method		=   $_GET['payment_method'];
$paymentIntent      =   $_GET['paymentIntent'];
$amount             =   $_GET['amount'];
$descriptor_suffix  =   $_GET['descriptor_suffix'];
$transfer_user_id   =   $_GET['transfer_user_id'];
$transfer_amount    =   $_GET['transfer_amount'];
$check_flag         =   $_GET['check_flag'];
$plan_id            =   $_GET['plan_id'];
$user_plan_id       =   $_GET['user_plan_id'];
$add_on_id          =   $_GET['add_on_id'];
$one_time          =   $_GET['one_time'];
$add_on_check      =   $_GET['add_on_check'];
$card_u_name      =   $_GET['card_u_name'];
$previous_card_id = $_GET['previous_card_id'];
	 
if(empty($user_id) || empty($user_id) || empty($user_id) || empty($user_id)){
?>
<script type="text/javascript">
	var cancel_url = '<?php echo $cancel_url; ?>';
	var error_msg = 'data invalid';
	setTimeout(function() {

		window.location.href=cancel_url+'?error='+error_msg;
	}, 1000);
</script>
<?php
																			}else{
	//echo '$user_id=='.$user_id;

	//echo '$paymentIntent=='.$paymentIntent;

	$json_obj = json_decode($paymentIntent);

	
	if($one_time==1){
		$json_obj_new = $json_obj->setupIntent;
	}else{
		$json_obj_new = $json_obj->paymentIntent;
	}
	 


	$status = $json_obj_new->status;

	if($status == 'succeeded' || $status=='requires_capture'){

		//$amount = $json_obj_new->amount;

		//echo '$amount=='.$amount;

		$createtime=date('Y-m-d H:i:s');
		$updatetime=date('Y-m-d H:i:s');
		$payment_status=1;

		//echo '$amount='.$amount;
		$insert_all=$mysqli->prepare("INSERT INTO stripe_payment_master(user_id, order_id, amount, descriptor_suffix, payment_id, payment_status, paymentIntent, createtime, updatetime, transfer_user_id, transfer_amount) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$insert_all->bind_param("iisssisssis", $user_id, $order_id, $amount, $descriptor_suffix,  $payment_id, $payment_status, $paymentIntent, $createtime1, $updatetime1, $transfer_user_id, $transfer_amount);
		$insert_all->execute();

		//echo "Error =>".$mysqli->error;
		$insert=$mysqli->affected_rows;
		//echo 'inset'.$insert;
		if($insert<=0)
		{ 
?>
<script type="text/javascript">

	var cancel_url = '<?php echo $cancel_url; ?>';
	var error_msg = 'error on insert in database';
	setTimeout(function() {
		window.location.href=cancel_url+'?error='+error_msg;
	}, 1000);
</script>
<?php
		}else{
			
	
$user_arr   =  getUserDetails($user_id);		
		 

if($check_flag=='update_card'){
	$seelct_data_all =$mysqli->prepare("SELECT stripe_customer_id, customer_id from stripe_customer_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
		$seelct_data_all->bind_result($stripe_customer_id,$customer_id);
		$seelct_data_all->fetch();

		$stripe_data['customerID'] = $customer_id;
		$stripe_data['payment_method'] = $payment_method;
		$json_data = serialize($stripe_data);
		$cdate 		   = date('Y-m-d h:i:s');
		$very   = 1;

		$seelct_data_all1 =$mysqli->prepare("SELECT `id` from billing_details WHERE is_payment_verify=1 and user_id=?");
		$seelct_data_all1->bind_param("i", $user_id);
		$seelct_data_all1->execute();
		$seelct_data_all1->store_result();
		$seelct_data1 = $seelct_data_all1->num_rows;  //0 1
		if($seelct_data1 <= 0){
			$signup_add = $mysqli->prepare("INSERT INTO `billing_details`(`user_id`, `updated_at`, `created_at`, `is_payment_verify`,stripe_data) VALUES (?,?,?,?,?)");
			$signup_add->bind_param("issis",$user_id,$updatetime,$updatetime,$very,$json_data);	
			$signup_add->execute();
			$signup_add_affect_row=$mysqli->affected_rows;
			if($signup_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
				jsonSendEncode($record);
			} 
		}else{
			$seelct_data_all1->bind_result($billing_details_id);
			$seelct_data_all1->fetch();
			// update billing details=======================
			$update_billing_details = $mysqli->prepare("UPDATE `billing_details` SET stripe_data=?,updated_at=?,created_at=?  WHERE id=?");
			$update_billing_details->bind_param("sssi",$json_data,$cdate,$cdate,$billing_details_id);	
			$update_billing_details->execute();
			$update_billing_details_affect_row=$mysqli->affected_rows;
			if($update_billing_details_affect_row<=0){
				$record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
				jsonSendEncode($record);
			}
			
		}  
		
		
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
		
		// Card Update
		
	// $stripe_card_update=$stripe->paymentMethods->update(
    //     $payment_method,
    //   []
   //   );
		
		 
		
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
			$update = $mysqli->prepare("UPDATE save_cards SET customer_id=?, u_name=?, email=?, payment_method=?, updated_at=?, exp_year=?, exp_month=?, country=?, last4=?, brand=? WHERE user_id=? AND id=?");
			$update->bind_param("sssssiisisii",$customer, $card_u_name, $email, $payment_method, $updated_at, $exp_year, $exp_month, $country, $last4, $brand,$user_id,$previous_card_id);	
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
		
	}   
}
			
// check_flag
if($check_flag=='add_plan'){

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
	if($one_time == 1){
		$credits_per_month=0;
		if(!is_null($free_bids_per_month)){
		 	$bids = explode(" ",$free_bids_per_month);
			$credits_per_month = $bids[0];
		}
		$up_startdate = date('Y-m-d');
		$up_enddate = date('Y-m-d',strtotime($up_startdate. '+ '.$free_plan_exp));
			$up_enddate = date('Y-m-d',strtotime($up_enddate. '- 1 day'));
		$up_used_bid = 0;
		$used_sms_notification = 0;
		$up_status = 1;
		$bid_type = 1;
		$plan_add = $mysqli->prepare("UPDATE `user_plans` set `up_planName`=?, up_bid=?,`up_status`=?, `up_update`=?,up_transId=?,up_startdate=?,up_enddate=?,up_amount=0,bid_type = 1,up_status = 1,used_sms_notification = 0,up_used_bid = 0 where up_id = ?");
		$plan_add->bind_param("sisssssi",$package_name,$credits_per_month,$upstatus,$cdate,$payment_id,$up_startdate,$up_enddate,$order_id);


		$subject = 'Thank you for Signing up to Tradespeoplehub.co.uk';
       $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_arr['f_name'].',</p>';
	$html .= '<p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb"> Welcome to TradespeopleHub! .</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local jobs.
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have full access to the core functionality you need to build your business with us.
</p>';

$html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Free Trial</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Your first 30 days of unlimited access to Tradespeoplehub are free. The first subscription payment, for ( placeholder price ), will be processed in 30 days.
</p>';
$html .= '	<p style="margin:0;padding:10px 0px">Your subscription will automatically renew at the same rates unless you cancel before the end of the billing period.
</p>';
$html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Changing Your Subscription Plan:
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">If you would like to downgrade or upgrade plan, log in to your account and click on the “Your Subscription” link in the membership management tab of your account. Then click on the “Change plan”. 

</p>';
$html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Pay as you Go Plan
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">If you would like to switch to pay as you go plan, log in to your account and click on the “Pay as you go” link in the upper left-hand corner.
 </p>';
 $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Tradespeoplehub provides access to over 10K jobs.
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Here are a few steps of what we require you to do to start winning and doing those jobs.
 </p>';
 $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Complete your profile
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Get the homeowner to know you more by completing your profile page. Tradespeople that did this have seen 30% more success. So, give yourself a head start by uploading your photo and images of your past projects.
 </p>';	

$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Complete Profile</a>
    </div>';
    
    
    
     $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
Verify account
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">To verify your account, upload a copy of your proof of address document and ID on to-do list part of your account. We accept UK/EU valid driving license or passport as proof of ID.

 </p>';	

$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Verify account now
</a>
    </div>';
    $html .= '<br><p style="margin:0;padding:10px 0px;font-size:20px;color:#3d78cb">
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
		$mailResponse  =  mailSend($user_arr['email'], 'Admin', $subject, $mailBody);

	}else{


		$up_amount = $amount;
		if($unlimited_limited==0){
			$bid=$bids_per_month; 
			$up_bid=trim($bid,' bids');
			$bid_type=1;
		}
		else{
			$up_bid='Unlimited';
			$bid_type=2;
		}
		$up_startdate = date('Y-m-d');
		$up_enddate = date('Y-m-d',strtotime($up_startdate. '+ '.$validation_type));
		$up_enddate = date('Y-m-d',strtotime($up_enddate. '- 1 day'));
		$up_status = 1;


		$plan_add = $mysqli->prepare("UPDATE `user_plans` set `up_update`=?,up_transId=?,auto_update=1,up_amount=?,up_bid=?,bid_type=?,up_startdate=?,up_enddate=?,up_status=? where up_id = ?");
		$plan_add->bind_param("ssssssssi",$cdate,$payment_id,$up_amount,$up_bid,$bid_type,$up_startdate,$up_enddate,$up_status,$order_id);


		$subject = 'Your Membership Plan has Updated Successfully. ';             
		$html = '<p style="margin:0;padding:10px 0px">Monthly Membership Plan Updated Successfully!</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">Hi '.$user_arr['f_name'].',</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Thanks for updating your monthly subscription plan. Your new plan is now active, and you can now enjoy the benefits associated to it.</p>';
		$html .= '<p style="margin:0;padding:10px 0px">There\'s nothing more you need to do other than to continue using our service to grow your business.</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>'; 
		$mailBody = send_mail_app($html);
		//end email temlete================
		$mailResponse  =  mailSend($user_arr['email'], 'Admin', $subject, $mailBody);
	}
	
	$plan_add->execute();
	$plan_add_affect_row=$mysqli->affected_rows;
	if($plan_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to update plan","Unable to update plan")); 
		jsonSendEncode($record);
	}

	
	
	if($one_time==1){
		$update_user_master = $mysqli->prepare("UPDATE `users` SET `free_trial_taken`=1 WHERE  id=?");
		$update_user_master->bind_param("i",$user_id);	
		$update_user_master->execute();
		$update_user_master_affect_row=$mysqli->affected_rows;
	}
	
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
		$seelct_save_card_all =$mysqli->prepare("SELECT user_id from save_cards where user_id = ?");
		$seelct_save_card_all->bind_param("i", $user_id);
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
	
	//die;

	$seelct_data_all =$mysqli->prepare("SELECT stripe_customer_id, customer_id from stripe_customer_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
		$seelct_data_all->bind_result($stripe_customer_id,$customer_id);
		$seelct_data_all->fetch();


		$seelct_data_all1 =$mysqli->prepare("SELECT `id` from billing_details WHERE is_payment_verify=1 and user_id=?");
		$seelct_data_all1->bind_param("i", $user_id);
		$seelct_data_all1->execute();
		$seelct_data_all1->store_result();
		$seelct_data1 = $seelct_data_all1->num_rows;  //0 1
		if($seelct_data1 <= 0)
		{
			//$intent_data = array('customerID'=>$customer_id,'payment_method'=>$payment_method);
			//$json_data = json_encode($intent_data);
			
			$stripe_data['customerID'] = $customer_id;
			$stripe_data['payment_method'] = $payment_method;

			$json_data = serialize($stripe_data);

			$very   = 1;
			$cdate 		   = date('Y-m-d h:i:s');
			$signup_add = $mysqli->prepare("INSERT INTO `billing_details`(`user_id`, `updated_at`, `created_at`, `is_payment_verify`,stripe_data) VALUES (?,?,?,?,?)");
			$signup_add->bind_param("issis",$user_id,$updatetime,$updatetime,$very,$json_data);	
			$signup_add->execute();
			$signup_add_affect_row=$mysqli->affected_rows;
			if($signup_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
				jsonSendEncode($record);
			} 
		}   	
	}   
}

if($check_flag=='pay_as_go'){ 
	if($add_on_check == 0)
	{
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
	}
	
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
	$get_add_on->bind_result($id, $amount, $add_on_type, $description, $quantity);
	$get_add_on->fetch();
	//get addons end===========



	$no_of_bids = 0; 

	//get user plan==========================
	$get_user_plan=$mysqli->prepare("SELECT `up_transId`, `up_bid`, `total_sms`,up_user FROM `user_plans` WHERE up_id=?");
	$get_user_plan->bind_param("i",$order_id);
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
	if($add_on_type==1){
		$no_of_bids = $quantity+$up_bid;
		$plan_update = $mysqli->prepare("UPDATE `user_plans` set `up_bid`=?,up_transId=?,up_update=? where up_id = ?");
	}else{
		$no_of_bids = $quantity+$total_sms;
		$plan_update = $mysqli->prepare("UPDATE `user_plans` set `total_sms`=?,up_transId=?,up_update=? where up_id = ?");
	} 
	$plan_update->bind_param("sssi",$no_of_bids,$payment_id,$updatetime,$order_id);   
	$plan_update->execute();
	$plan_update_affect_row=$mysqli->affected_rows;
	if($plan_update_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Unable to add addon","Unable to add addon")); 
		jsonSendEncode($record);
	}
	
	$check_user_all = $mysqli->prepare("SELECT id,spend_amount,u_wallet,f_name,email from users where id=?");
    $check_user_all->bind_param("i",$up_user);
    $check_user_all->execute();
    $check_user_all->store_result();
    $check_user   = $check_user_all->num_rows;  //0 1
    $check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet,$fname,$email);
    $check_user_all->fetch();

	
	
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





function checkAlredyHaveDetails($user_id){
	include '../con1.php';
	$seelct_data_all =$mysqli->prepare("SELECT `id` WHERE is_payment_verify=1 and user_id=?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
		$seelct_data_all->bind_result($stripe_customer_id,$customer_id);
		$seelct_data_all->fetch();
		$record =  'true';
		return $record;
	}else{
		$record = 'false';
		return $record;
	}
}

?>
<script type="text/javascript">
	var return_url_final = 'payment_success_final.php';
	var payment_id = '<?php echo $payment_id; ?>';
	var payment_method = '<?php echo $payment_method; ?>';
	var error_msg = 'data invalid';
	setTimeout(function() {
		window.location.href=return_url_final+'?payment_id='+payment_id+'&payment_method='+payment_method;
	}, 1000);
</script>
<?php 
		}
	}

}
?>