<?php

include 'stripe_config.php';

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);


include '../con1.php';


if(empty($_POST['user_id'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}


if(empty($_POST['action'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}

if(empty($_POST['card_number'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}

if(empty($_POST['card_month'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}

if(empty($_POST['card_year'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}

if(empty($_POST['card_cvv'])){
    $record=array('success'=>'false', 'msg' =>array('Please send data','Please send data' ));
	echo json_encode($record);
	return false;
}


$user_id = $_POST['user_id'];
$card_number = trim($_POST['card_number']);
$card_month = trim($_POST['card_month']);
$card_year = trim($_POST['card_year']);
$card_cvv = trim($_POST['card_cvv']);
$user_name = trim($_POST['user_name']);

$createtime			=	date('Y-m-d H:i:s');
$updatetime			=	date('Y-m-d H:i:s');

//------------------------ check customer on db -----------
$response = getStripeCustomerId($user_id);
//print_($response);
if($response['status']=='true'){
	
	$customer_id =   $response['customer_id'];
}else{
    try
    {
        //-------------- create id no db --------------
        $customer = \Stripe\Customer::create();
        $customer_id = $customer->id;
        
        $response = createStripeCustomerId($user_id,$customer_id);
        //echo print_r($response); die;
        
        if($response['status']=='false'){
            $record=array('success'=>'false', 'msg' =>array($response['msg']));
    		echo json_encode($record);
    		return false;
        }
    }catch (Exception $e) {
      // Something else happened, completely unrelated to Stripe
        //echo 'Message is:' . $e->getError()->message . '\n';
        $message = $e->getError()->message;

        $output = [
        'success'=>'false','msg'=>array($message,$message)
        ];
        echo json_encode($output);
        return false;

    }
}


//------------------- card create on stripe --------------
if(!empty($customer_id)){
    
    $card_data = [
        'number' => $card_number,
        'exp_month' => $card_month,
        'exp_year' => $card_year,
        'cvc' => $card_cvv
    ];

    //print_r($source_data); die;
     try
    {
        $stripe_card = \Stripe\Token::create([
                'card' => $card_data,
            ]);
        //print_r($stripe_card);
        $token_id = $stripe_card->id;
        
        $card_id = $stripe_card->card->id;
        $exp_month = $stripe_card->card->exp_month;
        $exp_year = $stripe_card->card->exp_year;
        $last4 = $stripe_card->card->last4;
        
        //echo 'last4='.$last4; die;
        //echo '$card_id='.$card_id; die;
	
		 $stripe_card1 = array(
		 'customerID'=>$customer_id,
			'response'=>$stripe_card
		 );
		 
		 $stripe_card1 = json_encode($stripe_card1);
        
        $response = updateStripeCustomerTokenCard($user_id,$customer_id,$card_id,$token_id, $exp_month,$exp_year,$last4, $card_number, $card_cvv, $stripe_card1,$user_name);
        //echo print_r($response); die;
        
        if($response['status']=='false'){
            $record=array('success'=>'false', 'msg' =>array($response['msg']));
    		echo json_encode($record);
    		return false;
        }
        
        
         $record=array('success'=>'true', 'msg' =>array($response['msg']),'token_id'=>$token_id,'stripe_card'=>$stripe_card);
		echo json_encode($record);
		return false;
        
        
        
    
    }catch (Exception $e) {
      // Something else happened, completely unrelated to Stripe
        //echo 'Message is:' . $e->getError()->message . '\n';
        $message = $e->getError()->message;

        $output = [
        'success'=>'false','msg'=>array($message,$message)
        ];
        echo json_encode($output);
        return false;

    }
    
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


function updateStripeCustomerTokenCard($user_id, $customer_id, $card_id, $token_id,$exp_month,$exp_year,$last4, $card_number, $card_cvv,$stripe_data,$user_name){
    include '../con1.php';
    $createtime=date('Y-m-d H:i:s');
    $updatetime=date('Y-m-d H:i:s');
    
    $exp_month = (string)$exp_month;
    $exp_year = (string)$exp_year;
    
    $is_verified   = 1;
    $signup_add = $mysqli->prepare("INSERT INTO `billing_details`(`name`, `card_number`, `card_exp_month`, `card_exp_year`, `card_cvc`, `user_id`, `updated_at`, `created_at`, `is_payment_verify`,stripe_data) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $signup_add->bind_param("sssssissis",$user_name,$card_number,$exp_month,$exp_year,$card_cvv,$user_id,$createtime,$updatetime,$is_verified,$stripe_data); 
    $signup_add->execute();
    $signup_add_affect_row=$mysqli->affected_rows;
    if($signup_add_affect_row<=0){
        $record=array('status'=>'false','msg' =>array('Card not created','Card not created')); 
        return $record;
    }

    $record=array('status'=>'true','msg' =>'Card created'); 
    return $record;


    //$card_number = string_encrypt($card_number);
    //$card_cvv = string_encrypt($card_cvv);
	    
	    // $insert_all=$mysqli->prepare("INSERT INTO stripe_card_master(user_id, customer_id, card_id, token, exp_month, exp_year, last4,card_number, card_cvv, createtime, updatetime) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
     //    $insert_all->bind_param("issssssssss", $user_id, $customer_id, $card_id, $token_id, $exp_month, $exp_year, $last4, $card_number,$card_cvv, $createtime, $updatetime);
     //    $insert_all->execute();
     //    //echo "Error =>".$mysqli->error;
     //    $insert=$mysqli->affected_rows;
     //    if($insert<=0){ 
     //        $record=array('status'=>'false','msg' =>array('Card not created','Card not created')); 
            	
     //    }
        
     //    $record=array('status'=>'true','msg' =>'Card created'); 
     //    return $record;
}


function string_encrypt($string_text){
  $cipher_method = 'aes-128-ctr';
  $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
  $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
  $encrypt_data = openssl_encrypt($string_text, $cipher_method, $enc_key, 0, $enc_iv) . "@" . bin2hex($enc_iv);
  unset($string_text, $cipher_method, $enc_key, $enc_iv);
  
  return $encrypt_data;
}

function string_decrypt($encrypt_string_text){
  list($encrypt_string_text, $enc_iv) = explode("@", $encrypt_string_text);
  $cipher_method = 'aes-128-ctr';
  $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
  $decrypt_data = openssl_decrypt($encrypt_string_text, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
  unset($encrypt_string_text, $cipher_method, $enc_key, $enc_iv);
  return $decrypt_data;
}


?>