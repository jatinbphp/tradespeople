<?php
include 'stripe_config.php';

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);

/*
sample card to check conditions
4000 0025 0000 3155 -require 3d authentication anyCVV any postalcode any future year and month
4242 4242 4242 4242 payment will sucuess without 3d secure
4000 0000 0000 9995 payment will cancel 
*/

function calculateOrderAmount() {
  // Replace this constant with a calculation of the order's amount
  // Calculate the order total on the server to prevent
  // customers from directly manipulating the amount on the client
  return 1400;
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
    
    $user_id = $json_obj->user_id;
    $order_id = $json_obj->order_id;
    
    $amount            = $json_obj->amount;
    $transfer_amount   = $json_obj->transfer_amount;
    $descriptor_suffix = $json_obj->descriptor_suffix;
    $check_flag        = $json_obj->check_flag;
	$one_time        = $json_obj->one_time;
    $check_flag        = "new_card12";
    
    if(!empty($descriptor_suffix)){
        $statement_descriptor_suffix=$descriptor_suffix;
    }
    $customer_bank_id = '';
    $transfer_user_id = $json_obj->transfer_user_id;
    
    //echo '$transfer_user_id=='.$transfer_user_id;
    
    if(!empty($transfer_user_id)){
        $response = getStripeBankIdForTransferUser($transfer_user_id);
        //echo print_r($response); die;
        
        if($response['status']=='false'){
    		
    		$record=array('success'=>'false', 'msg' =>$response['msg']);
    		echo json_encode($record);
    		return false;
    	}else{
    	   $customer_bank_id =   $response['user_token_id']; 
    	}
    }
    
    //echo '$user_id='.$user_id;
    //echo '$order_id='.$order_id;

    //check on user ID if customer ID is created before then get it from database otherwise create it
    //$customer = \Stripe\Customer::create();
    
    //------------------------ check customer on db -----------
    $response = getStripeCustomerId($user_id);
    if($response['status']=='true'){
		
		$customer_id =   $response['customer_id'];
	}else{
		include '../con1.php';
    	$email = 'NA';
		$seelct_data_all =$mysqli->prepare("SELECT email  from users where id = ?");
		$seelct_data_all->bind_param("i", $user_id);
		$seelct_data_all->execute();
		$seelct_data_all->store_result();
		$seelct_data = $seelct_data_all->num_rows;  //0 1
		if($seelct_data > 0)
		{
			$seelct_data_all->bind_result($email);
			$seelct_data_all->fetch();
		}
		
	    //-------------- create id no db --------------
	    $customer = \Stripe\Customer::create([
			'email' => $email
		]);
	    $customer_id = $customer->id;
	    
	    $response = createStripeCustomerId($user_id,$customer_id);
	    //echo print_r($response); die;
	    
        if($response['status']=='false'){
	        $record=array('success'=>'false', 'msg' =>$response['msg']);
    		echo json_encode($record);
    		return false;
        }
	}
	
	//print_r($response);

if(!empty($customer_bank_id)){
    
    $comission=($amount*2.9)/100;
    $comission=$comission+0.35;
    $transfer_amount = round($transfer_amount-$comission);
    $amount = $amount*100;
    
    $transfer_amount = $transfer_amount*100;
  
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => $amount,//amount must be multiple of 100
    'currency' => $currency,
    'customer' => $customer_id,
    'setup_future_usage' => 'off_session',
    'transfer_data' => [
         'destination' => $customer_bank_id, 'amount' => $transfer_amount 
         ],
    'description'=>$description, //max 22 charcaters
    'statement_descriptor_suffix'=>$statement_descriptor_suffix //max 22 charcaters
    
  ]);
}else{

  $amount = $amount*100;
  if($check_flag=='new_card'){
    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount'             => $amount,//amount must be multiple of 100
      'currency'           => $currency,
      'customer'           => $customer_id,
      'setup_future_usage' => 'off_session',
      'description'        =>$description, //max 22 charcaters
      'statement_descriptor_suffix'=>$statement_descriptor_suffix //max 22 charcaters
    ]);
  }else{
	 
	  if($one_time == 1)
	  {
		  
			   $paymentIntent = \Stripe\SetupIntent::create([

		  'customer' => $customer_id,

		]);
	  }else{
	  
		$paymentIntent = \Stripe\PaymentIntent::create([
		  'amount' => $amount,//amount must be multiple of 100
		  'currency' => $currency,
		  'customer' => $customer_id,
		  'payment_method_types' => ['card'],
		  //'capture_method' => 'manual',
		  'setup_future_usage' => 'off_session',
		  'description'=>$description, //max 22 charcaters
		  'statement_descriptor_suffix'=>$statement_descriptor_suffix, //max 22 charcaters
			'payment_method_options' => [
						"card" => [
							"request_three_d_secure" => "any"
						]
					 ]
		]);
	  }
  }
  
}
  
  //Payment intent can be used four type
  //1.Simple as above example without connected account //no comission case
  //2.when we want to send direct money to connected account  add parameter On behalf  //when you want to send fund immedietly to provider
  //3.when wnat to deduct comision use 'transfer_data' => [
   // 'destination' => '{{CONNECTED_STRIPE_ACCOUNT_ID}}', 'amount' => 877 ],//when you want to send fund immedietly to provider
   //4.Seperate charge and seperate transfer ,,when payment want to send after job /work is completed
   
		include   '../con1.php';
    	$name = '';
		$seelct_save_card_all =$mysqli->prepare("SELECT u_name  from save_cards where user_id = ?");
		$seelct_save_card_all->bind_param("i", $user_id);
		$seelct_save_card_all->execute();
		$seelct_save_card_all->store_result();
		$seelct_save_card = $seelct_save_card_all->num_rows;  //0 1
		if($seelct_save_card > 0)
		{
			$seelct_save_card_all->bind_result($name);
			$seelct_save_card_all->fetch();
		}

  $output = [
    'success'=>'true','clientSecret' => $paymentIntent->client_secret,'customer_id'=>$customer_id, 'name'=>$name
  ];
  
  echo json_encode($output);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['success'=>'false','error' => $e->getMessage()]);
}

function getStripeCustomerId($user_id){
    include '../con1.php';
    
	$seelct_data_all =$mysqli->prepare("SELECT stripe_customer_id, customer_id from stripe_customer_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
	    $seelct_data_all->bind_result($stripe_customer_id,$customer_id);
	    $seelct_data_all->fetch();
	    
	    $record = array('status'=>'true', 'msg'=>'data found', 'stripe_customer_id'=>$stripe_customer_id,'customer_id'=>$customer_id);
			return $record;
	}else{
	    $record = array('status'=>'false', 'msg'=>'customer not available');
		return $record;
	}
}

function createStripeCustomerId($user_id, $customer_id){
    include '../con1.php';
    $createtime=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i:s');
	    
	    $insert_all=$mysqli->prepare("INSERT INTO stripe_customer_master(user_id, customer_id, createtime, updatetime) VALUES (?,?,?,?)");
        $insert_all->bind_param("isss", $user_id, $customer_id, $createtime, $updatetime);
        $insert_all->execute();
        //echo "Error =>".$mysqli->error;
        $insert=$mysqli->affected_rows;
        if($insert<=0){ 
            $record=array('status'=>'false','msg' =>'Customer not created'); 
            	return $record;
        }
        
        $record=array('status'=>'true','msg' =>'Customer created'); 
        return $record;
}

function getStripeBankIdForTransferUser($user_id){
    include '../con1.php';
    
 
	$seelct_data_all =$mysqli->prepare("SELECT id, user_token_id from stripe_bank_master where delete_flag = 0 AND user_id = ?");
	$seelct_data_all->bind_param("i", $user_id);
	$seelct_data_all->execute();
	$seelct_data_all->store_result();
	$seelct_data = $seelct_data_all->num_rows;  //0 1
	if($seelct_data > 0)
	{
	    $seelct_data_all->bind_result($id,$user_token_id);
	    $seelct_data_all->fetch();
	    
	    $record = array('status'=>'true', 'msg'=>'data found', 'id'=>$id,'user_token_id'=>$user_token_id);
			return $record;
	}else{
	    $record = array('status'=>'false', 'msg'=>'Provider account is not connected with out platform, bank account not connected');
		return $record;
	}
}


