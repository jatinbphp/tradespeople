<?php
	// Start file use for Stripe
	include 'stripe_config.php';
	require 'vendor/autoload.php';
	\Stripe\Stripe::setApiKey($secret_key);
	// End file use for Stripe
	include '../con1.php';
	include '../function_app.php';
 
 
	if(!$_POST){
		$record=array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data')); 
		echo json_encode($record);
		return false;
	}
	
	if(empty($_POST['number'])){
		$record=array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data'));
		echo json_encode($record);
		return false;
	}

	if(empty($_POST['expMonth'])){
		$record=array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data')); 
		echo json_encode($record);
		return false;
	}
	
	if(empty($_POST['expYear'])){
		$record=array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data')); 
		echo json_encode($record);
		return false;
	}	
	
	if(empty($_POST['cvc'])){
		$record = array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data')); 
		echo json_encode($record);
		return false;
	}
	
	if(empty($_POST['user_id'])){
		$record = array('success'=>'false', 'msg' =>array('Please send all data','Please send all data','Please send all data')); 
		echo json_encode($record);
		return false;
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
	$response=	verifyCardDeatil($postData); 
	// $record=array('success'=>'false', 'msg' =>$response); 
	//	echo json_encode($record);
	//exit();

	if($response['status']=='false'){
		$record=array('success'=>'false', 'msg' =>$response['msg']); 
		echo json_encode($record);
		return false;
	} 


	//$is_verified   = 1;
	$cdate 		   = date('Y-m-d h:i:s');
	//$signup_add = $mysqli->prepare("INSERT INTO `billing_details`(`name`, `card_number`, `card_exp_month`, `card_exp_year`, `card_cvc`, `user_id`, `updated_at`, `created_at`, `is_payment_verify`) VALUES (?,?,?,?,?,?,?,?,?)");
	//$signup_add->bind_param("sssssissi",$name,$number,$expMonth,$expYear,$cvc,$user_id,$cdate,$cdate,$is_verified);	
	//$signup_add->execute();
	//$signup_add_affect_row=$mysqli->affected_rows;
	//if($signup_add_affect_row<=0){
	//	$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
		//jsonSendEncode($record);
	//}


	

	$u_pay_verify=1;
	$update_user_details = $mysqli->prepare("UPDATE `users` SET u_pay_verify=? WHERE id=?");
	$update_user_details->bind_param("ii",$u_pay_verify,$user_id);
	$update_user_details->execute();
	$update_affected_rows	=	$mysqli->affected_rows;
	if($update_affected_rows<=0){
		$record=array('success'=>'false','msg'=>array("Unable to verify card now,Please try again later","Unable to verify card now,Please try again later")); 
		jsonSendEncode($record);
	}
 
	$user_token_id 				=	$response['user_token_id']; 
	$postData['user_token_id']	=	$user_token_id;
	$postData['user_id']		=	$user_id;
    $user_details=getUserDetails($user_id); 
    $record=array('success'=>'true', 'msg' =>array("Your card is added successfully","Your card is added successfully"), 'user_token_id'=>$user_token_id,'user_details'=>$user_details); 
    echo json_encode($record);
	return false;
	
	
   function verifyCardDeatil($postData){
        try {
           $account_response=Stripe\Token::create(
                 [
                         'card' => [
                         'number' => $postData['number'],
                         'exp_month' => $postData['expMonth'],
                         'exp_year' => $postData['expYear'],
                         'cvc' => $postData['cvc'],
                     ],
             ]);
			//$account_response=\Stripe\Account::create($arra);
			$user_token_id = $account_response->id;
			$message 	=	array('Success', 'Success', 'Success', 'Success');
			$record	    =	array('status'=>'true', 'msg'=>$message, 'user_token_id'=>$account_response);
			return $record;
    
		}
		catch (Stripe_InvalidRequestError $e) {			
			// Invalid parameters were supplied to Stripe's API
	    	
	    	
	    	$msg_sumit=$e->getMessage();
			$message=array($msg_sumit,$msg_sumit, $msg_sumit,$msg_sumit);

		} catch (Stripe_AuthenticationError $e) {
			
 $msg_sumit=$e->getMessage();
			$message=array($msg_sumit,$msg_sumit, $msg_sumit,$msg_sumit);
		} catch (Stripe_ApiConnectionError $e) {
			
 $msg_sumit=$e->getMessage();
			$message=array($msg_sumit,$msg_sumit, $msg_sumit,$msg_sumit);
		} catch (Stripe_Error $e) {
		    
 $msg_sumit=$e->getMessage();
			$message=array($msg_sumit,$msg_sumit, $msg_sumit,$msg_sumit);
		} 
		catch (Exception $e) {
		   
 $msg_sumit=$e->getMessage();
			$message=array($msg_sumit,$msg_sumit, $msg_sumit,$msg_sumit);
		}
		//$mysqli->close(); 
		$record		=	array('status'=>'false', 'msg'=>$message);
		return $record;
       
   }	

    
?>
