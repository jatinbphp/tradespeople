<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	// Email
	if(empty($_POST['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

		 
	//---------------------------get all variables--------------------------
	$user_id     				= $_POST['user_id'];
	$bank_date     				= $_POST['bank_date'];
	$bank_date                  = date('Y-m-d',strtotime($bank_date));
	$bank_name     				= $_POST['bank_name'];
	$bank_amount 				= $_POST['bank_amount']; 
	$last_txn_ref 				= $_POST['last_txn_ref'];
	$cdate						= date("Y-m-d H:i:s");
 
 	
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,spend_amount,u_wallet from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet);
 	$check_user_all->fetch();
 	    
 	    
 	   
 	//===========================get admin==================
    $processing_fee  =   getSingleDataBySql('SELECT `processing_fee` FROM `admin` ORDER BY id DESC LIMIT 1');
	//$processing_amt  = $bank_amount*$processing_fee/100;
  	$user_amt        = $bank_amount;

    $comission = ($bank_amount*$processing_fee)/100;
    $mainAmt = $bank_amount + $comission;
    $main_amount = number_format($mainAmt,2);

  	$status = 0;
	// insert bank data =======================================
	$bank_transfer_add = $mysqli->prepare("INSERT INTO `bank_transfer`( `userId`, `amount`, `admin_percent`, `user_amount`, `admin_amt`, `bank_account_name`, `date_of_deposit`,reference, `create_date`, `update_date`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

    	      $bank_transfer_add->bind_param("isssssssssi",$user_id,$main_amount,$processing_fee,$user_amt,$comission,$bank_name,$bank_date,$last_txn_ref,$cdate,$cdate,$status);	
    $bank_transfer_add->execute();
    $bank_transfer_add_affect_row=$mysqli->affected_rows;
    if($bank_transfer_add_affect_row<=0){
        $record=array('success'=>'false','msg'=>array('Unable to insert please try again later')); 
        jsonSendEncode($record);
    }
 


//get transction data========
$bank_history_arr = array();
$bank_history_get = $mysqli->prepare("SELECT `id`, `userId`, `contryId`, `amount`, `admin_percent`, `user_amount`, `admin_amt`, `bank_account_name`, `date_of_deposit`, `reference`, `create_date`, `update_date`, `status`, `reject_reason`, `is_admin_read` FROM `bank_transfer` WHERE userId=?");
$bank_history_get->bind_param("i",$user_id);
$bank_history_get->execute();
$bank_history_get->store_result();
$bank_history_get_row = $bank_history_get->num_rows;
if($bank_history_get_row>0){
	$bank_history_get->bind_result($id,$userId,$contryId,$amount,$admin_percent,$user_amount,$admin_amt,$bank_account_name,$date_of_deposit,$reference,$create_date,$update_date,$status,$reject_reason,$is_admin_read);
	while ($bank_history_get->fetch()) {
		 $bank_history_arr[] = array(
			'id'		=>	  $id,
			'userId'	=>	  $userId,
			'contryId'	=>	  $contryId,
			'amount'	=>	  $amount,
			'admin_percent'	=>	  $admin_percent,
			'user_amount'	=>	  $user_amount,
			'admin_amt'	=>	  $admin_amt,
			'bank_account_name'	=>	  $bank_account_name,
			'date_of_deposit'	=>	  $date_of_deposit,
			'reference'	=>	  $reference,
			'create_date'=>	  $create_date,
			'update_date'=>	  $update_date,
			'status'	=>	  $status,
			'reject_reason'=>	  $reject_reason,
			'is_admin_rea'=>	  $is_admin_read
		 );
	}
}







	
	$last_txn_ref  =   getSingleDataBySql('SELECT `id` FROM `bank_transfer` ORDER BY id DESC LIMIT 1');
	if($last_txn_ref=='NA'){
		$last_txn_ref = 0;
	}
	$last_txn_ref=$last_txn_ref+1;
	$last_txn_ref = sprintf("%06d", $last_txn_ref);

	$user_details 		= 		getUserDetails($user_id);
	$username = '';
	$name = '';
	if($user_details!='NA'){
		$user_email=$user_details['email'];
		$name=$user_details['f_name'].' '.$user_details['l_name'];
		$username_arr = explode('@',$user_email);
		$username = $username_arr[0];
	}
	$last_txn_ref1 = $last_txn_ref;
	$last_txn_ref = $username.'-'.$last_txn_ref;

if(empty($bank_history_arr)){
$bank_history_arr='NA';
}

	$record   =  array('success'=>'true','msg'=>$data_found,'last_txn_ref'=>$last_txn_ref,'last_txt_id'=>$last_txn_ref1,'name'=>$name,'bank_history_arr'=>$bank_history_arr); 
	jsonSendEncode($record);
?>
 