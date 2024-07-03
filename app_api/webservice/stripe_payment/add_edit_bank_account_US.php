<?php

include 'stripe_config.php';

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey($secret_key);


include '../con1.php';


if(empty($_POST['user_id'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}


if(empty($_POST['firstname'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['lastname'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['dateofbirth'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['user_account'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['user_routing'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_name'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_address_line_1'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_address_line_2'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_city_name'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_state_name'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}

if(empty($_POST['bank_zip_code'])){
    $record=array('success'=>'false', 'msg' =>'Please send data');
	echo json_encode($record);
	return false;
}


$user_id = $_POST['user_id'];
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$email = trim($_POST['email']);
$phone_number = trim($_POST['phone_number']);

$bank_name = trim($_POST['bank_name']);
$dateofbirth = $_POST['dateofbirth'];
$user_account = $_POST['user_account'];
$user_routing = $_POST['user_routing'];
$ssn_number = $_POST['ssn_number'];

$bank_address_line_1 = $_POST['bank_address_line_1'];
$bank_address_line_2 = $_POST['bank_address_line_2'];
$bank_city_name = $_POST['bank_city_name'];
$bank_state_name = $_POST['bank_state_name'];
$bank_zip_code = $_POST['bank_zip_code'];

$bank_country_name		    =	strtoupper($country_stripe);


if(empty($ssn_number)){
    $ssn_number = '0000';
}
$dateofbirth_exp 	=	explode("-",$dateofbirth);
$year 				=	$dateofbirth_exp[0];
$month 				=	$dateofbirth_exp[2];
$day 				=	$dateofbirth_exp[1];
$createtime			=	date('Y-m-d H:i:s');
$updatetime			=	date('Y-m-d H:i:s');
$date_in_strtime 	=	strtotime($createtime);

$global_ip_address  = $_SERVER['REMOTE_ADDR'];
$website_url        = $website_url_stripe;	
	
$user_token_id = '';

$seelct_data_all =$mysqli->prepare("SELECT id, user_token_id from stripe_bank_master where delete_flag = 0 AND user_id = ?");
$seelct_data_all->bind_param("i", $user_id);
$seelct_data_all->execute();
$seelct_data_all->store_result();
$seelct_data = $seelct_data_all->num_rows;  //0 1
if($seelct_data > 0)
{
    $seelct_data_all->bind_result($id,$user_token_id);
    $seelct_data_all->fetch();
}




if(empty($user_token_id)){
    //--------------- create bank account ---------
    try {
        //----------------------- bank array  -----------------------------
        $bank_arr_create = [
        	"type" 						=>	"custom",
        	"country" 					=>	$country_stripe,
        	"business_type"				=>	'individual',
        	//"requested_capabilities" => ["legacy_payments"],       
        	"requested_capabilities" => ["transfers"],    
        	
        	"external_account" => [
        	   "object" 				=>	"bank_account",
        	   "country" 				=>	$country_stripe,
        	   "currency"		 		=>	$currency,
        	   "routing_number" 		=>	$user_routing,
        	   "account_number" 		=>	$user_account,
        	   "account_holder_type"	=>	'individual',
        	   "account_holder_name"	=>	$firstname.' '.$lastname,
        
        
        	],
        	"business_profile" => [
             'url'=>$website_url
            ],
        	"individual" => [					 
        	"dob" => [
        		"day" 		=>	$day,
        		"month" 	=>	$month,
        		"year" 		=>	$year,
        	],
        	"address"=> [
			   "city"=>$bank_city_name,
			   "country"=> $bank_country_name,
			   "line1"=> $bank_address_line_1,
			   "line2"=> $bank_address_line_2,
			   "postal_code"=> $bank_zip_code,
			   "state"=> $bank_state_name
			 ],
        	"first_name"	=>	$firstname,
        	"last_name" 	=> 	$lastname,
        	"email"         => 	$email,
			"phone"         =>  $phone_number,
			"id_number" 	=>	$ssn_number,
        	//"ssn_last_4" 	=> 	$ssn_number,
        	],
        	"tos_acceptance" => [
        	   "date" 		=>	$date_in_strtime,
        	   "ip" 		=>	$global_ip_address,
        	],
        	   
        ];				
        //print_r($bank_arr_create);
        
        $account_response	=	\Stripe\Account::create($bank_arr_create);	
    	$user_token_id = $account_response->id;
    	
    	$createtime=date('Y-m-d H:i:s');
        $updatetime=date('Y-m-d H:i:s');
	    $delete_flag = 0;
	    $account_holder_name = $firstname.' '.$lastname;
	    $account_holder_type = 'individual';
	    $business_type = 'individual';
	    
	    $insert_all=$mysqli->prepare("INSERT INTO stripe_bank_master(user_id, user_token_id, country, currency, user_routing, user_account, account_holder_name, account_holder_type, business_type, dob_day, dob_month, dob_year, first_name, last_name, bank_name, address_line_1, address_line_2, city, country_short, state, zip_code, date_in_strtime, global_ip_address, ssn_number, delete_flag,  createtime, updatetime) VALUES  (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insert_all->bind_param("isssssssssssssssssssssssiss", $user_id, $user_token_id, $country_stripe, $currency, $user_routing, $user_account, $account_holder_name, $account_holder_type, $business_type, $day, $month, $year, $firstname, $lastname, $bank_name, $bank_address_line_1, $bank_address_line_2, $bank_city_name, $bank_country_name, $bank_state_name, $bank_zip_code, $date_in_strtime, $global_ip_address, $ssn_number, $delete_flag, $createtime, $updatetime);
        $insert_all->execute();
        //echo "Error =>".$mysqli->error;
        $insert=$mysqli->affected_rows;
        if($insert>0){ 
            $record=array('success'=>'true','msg' =>array('Bank Account Created', 'Bank Account Created', 'Bank Account Created', 'Bank Account Created'), 'user_token_id'=>$user_token_id); 
            echo json_encode($record);
	        return false;
        }else{
            $record=array('success'=>'false','msg' =>array('Bank Account Created Error on DB', 'Bank Account Created Error on DB', 'Bank Account Created Error on DB', 'Bank Account Created Error on DB')); 
            echo json_encode($record);
	        return false;
        }
        
    }
	catch (Stripe_InvalidRequestError $e) {			
		// Invalid parameters were supplied to Stripe's API
		$message 	=	array('Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage());
	} catch (Stripe_AuthenticationError $e) {
		// Authentication with Stripe's API failed
		$message 	=	array('Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage());
	} catch (Stripe_ApiConnectionError $e) {
		// Network communication with Stripe failed
		$message 	=	array('Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage());
	} catch (Stripe_Error $e) {
		// Display a very generic error to the user, and maybe send
		$message 	=	array('Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage());
	} 
	catch (Exception $e) {
		//	Something else happened, completely unrelated to Stripe
		$message 	=	array($e->getMessage(), $e->getMessage(), $e->getMessage(), $e->getMessage());			
	}
	$record		=	array('success'=>'false', 'msg'=>$message);
	echo json_encode($record);
	return false;
}else{
    //------------------- update bank account -------------------
    try {
        //----------------------- bank array  -----------------------------
        $bank_arr_update = [
        	//"type" 						=>	"custom",
        	//"country" 					=>	$country_stripe,
        	"business_type"				=>	'individual',
        	"requested_capabilities" => ["transfers"],         
        // 	'capabilities' => [
        //         'transfers' => ['requested' => true],
        //       ],     
        	
        	"external_account" => [
        	   "object" 				=>	"bank_account",
        	   "country" 				=>	$country_stripe,
        	   "currency"		 		=>	$currency,
        	   "routing_number" 		=>	$user_routing,
        	   "account_number" 		=>	$user_account,
        	   "account_holder_type"	=>	'individual',
        	   "account_holder_name"	=>	$firstname.' '.$lastname,
        
        
        	],
        	"business_profile" => [
             'url'=>$website_url
            ],
        	"individual" => [					 
        	"dob" => [
        		"day" 		=>	$day,
        		"month" 	=>	$month,
        		"year" 		=>	$year,
        	],
        	"address"=> [
			   "city"=>$bank_city_name,
			   "country"=> $bank_country_name,
			   "line1"=> $bank_address_line_1,
			   "line2"=> $bank_address_line_2,
			   "postal_code"=> $bank_zip_code,
			   "state"=> $bank_state_name
			 ],
        	"first_name"	=>	$firstname,
        	"last_name" 	=> 	$lastname,
        	"email"         => 	$email,
			"phone"         =>  $phone_number,
			"id_number" 	=>	$ssn_number,
        	//"ssn_last_4" 	=> 	$ssn_number,
        	],
        	"tos_acceptance" => [
        	   "date" 		=>	$date_in_strtime,
        	   "ip" 		=>	$global_ip_address,
        	],
        	   
        ];				
        //print_r($bank_arr_update);
        
        $account_response=\Stripe\Account::update($user_token_id, $bank_arr_update);
        //print_r($account_response);
        
    	$user_token_id = $account_response->id;
    	
    	$createtime=date('Y-m-d H:i:s');
        $updatetime=date('Y-m-d H:i:s');
	    $delete_flag = 0;
	    $account_holder_name = $firstname.' '.$lastname;
	    $account_holder_type = 'individual';
	    $business_type = 'individual';
	    
	    
	    
	    
	    $update_all=$mysqli->prepare("UPDATE stripe_bank_master SET  user_token_id=?, country=?, currency=?, user_routing=?, user_account=?, account_holder_name=?, account_holder_type=?, business_type=?, dob_day=?, dob_month=?, dob_year=?, first_name=?, last_name=?, bank_name=?, address_line_1=?, address_line_2=?, city=?, country_short=?, state=?, zip_code=?, date_in_strtime=?, global_ip_address=?, ssn_number=?,  updatetime=? WHERE user_id=?");
        $update_all->bind_param("ssssssssssssssssssssssssi", $user_token_id, $country_stripe, $currency, $user_routing, $user_account, $account_holder_name, $account_holder_type, $business_type, $day, $month, $year, $firstname, $lastname, $bank_name, $bank_address_line_1, $bank_address_line_2, $bank_city_name, $bank_country_name, $bank_state_name, $bank_zip_code, $date_in_strtime, $global_ip_address, $ssn_number, $updatetime, $user_id);
        $update_all->execute();
        //echo "Error =>".$mysqli->error;
        $update=$mysqli->affected_rows;
        if($update>0){ 
            $record=array('success'=>'true','msg' =>array('Bank Account Updated', 'Bank Account Updated', 'Bank Account Updated', 'Bank Account Updated'), 'user_token_id'=>$user_token_id); 
            echo json_encode($record);
	        return false;
        }else{
            $record=array('success'=>'false','msg' =>array('Bank Account Updated Error on DB', 'Bank Account Updated Error on DB', 'Bank Account Updated Error on DB', 'Bank Account Updated Error on DB')); 
            echo json_encode($record);
	        return false;
        }
    }
	catch (Stripe_InvalidRequestError $e) {			
		// Invalid parameters were supplied to Stripe's API
		$message 	=	array('Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage(), 'Invalid parameters were supplied to Stripes API '.$e->getMessage());
	} catch (Stripe_AuthenticationError $e) {
		// Authentication with Stripe's API failed
		$message 	=	array('Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage(), 'Authentication with Stripes API failed'.$e->getMessage());
	} catch (Stripe_ApiConnectionError $e) {
		// Network communication with Stripe failed
		$message 	=	array('Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage(), 'Network communication with Stripe failed'.$e->getMessage());
	} catch (Stripe_Error $e) {
		// Display a very generic error to the user, and maybe send
		$message 	=	array('Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage(), 'Display a very generic error to the user'.$e->getMessage());
	} 
	catch (Exception $e) {
		//	Something else happened, completely unrelated to Stripe
		$message 	=	array($e->getMessage(), $e->getMessage(), $e->getMessage(), $e->getMessage());			
	}
	$record		=	array('success'=>'false', 'msg'=>$message);
	echo json_encode($record);
	return false;
}
?>