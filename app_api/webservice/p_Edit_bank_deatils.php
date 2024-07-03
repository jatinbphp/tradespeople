<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';

if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_post_method); 
	jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
 

$user_id	     	=	$_POST['user_id'];
$amount 			=	$_POST['amount']; 
$acc_no             =   $_POST['acc_no'];
$bank_name          =   $_POST['bank_name'];
$sort_code          =   $_POST['sort_code'];
$acc_holder         =   $_POST['acc_holder'];
 



$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,f_name,l_name,email from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$f_name,$l_name,$u_email);
$check_user_all->fetch();

$get_commision = getAdminDetails();





		// update transaction table======================
		$tr_type = 2;
		$tr_status = 1;
		$updatetime =  date("Y-m-d H:i:s");
		$tr_message='You have withdrawal <i class="fa fa-gbp"></i>'.$amount.' from your wallet.</b>';
		$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message) VALUES (?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiisss",$user_id,$amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>array("Something went wrong, please try again later")); 
			jsonSendEncode($record);
		}





		$u_name  		=	$f_name.' '.$l_name;
		$email  		=	$get_commision['email'];
		$username 		=	$get_commision['username'];
		$mail_content 	= 	'Hello '.$username.'<br><br>';

		$mail_content.='<p class="text-center">'.$u_name.' has requested to withdraw £'.$amount.' amount.<a href="'.$website_url.'withdrawal-history"> Click Here </a>to accept or reject the request.</p>';

		$subject 		=	$u_name." has requested to withdraw amount";
		$postData['mail_heading'] 	=	"Withdraw amount";
		$postData['mailContent'] 	=	$mail_content;
		$postData['name'] 			=	$username;
		$postData['fromName']       =   $u_name;
		$postData['email']			=	$email;
		$postData['app_url']        =   $website_url;
		$postData['app_logo'] 		=	$app_logo;
		$mailBody					=	send_mail_withdraw_admin($postData);
		$email_arr[]				=	array('mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($email, $u_name, $subject, $mailBody);
 

		// insert widhdraw=========
		$updatetime = date('Y-m-d H:i:s');
		$wd_payment_type = 2;
		
		//echo "INSERT INTO `tbl_withdrawal`( `wd_userid`, `wd_amount`, `wd_create`, `wd_payment_type`, `wd_pay_email`,wd_account_holder,wd_bank,wd_account,wd_ifsc_codev) VALUES ($user_id,$amount,$updatetime,$wd_payment_type,$wd_pay_email,$acc_holder,$bank_name,$acc_no,$sort_code)";
		//exit();
		$insert_withdraw = $mysqli->prepare("INSERT INTO `tbl_withdrawal`( `wd_userid`, `wd_amount`, `wd_create`, `wd_payment_type`, `wd_pay_email`,wd_account_holder,wd_account,wd_ifsc_code,wd_bank) VALUES (?,?,?,?,?,?,?,?,?)");
$insert_withdraw->bind_param("sssssssss",$user_id,$amount,$updatetime,$wd_payment_type,$u_email,$acc_holder,$acc_no,$sort_code,$bank_name);	
		$insert_withdraw->execute();
		$insert_withdraw_affect_row=$mysqli->affected_rows;
		if($insert_withdraw_affect_row<=0){
			$record=array('success'=>'false','msg'=>array("Something went wrong, please try again later")); 
			jsonSendEncode($record);
		}

		$last_id = $mysqli->insert_id;
		$subject1 = "You recently requested a withdrawal of funds to your bank account."; 

		$html .= '<p style="margin:0;padding:20px 0px">Hi '.$f_name.',</p>';
		$html .= '<p style="margin:0;padding:20px 0px">We’ve received your request to withdraw money from your Tradespeoplehub account to your bank account and are on it.</p>';
		$html .= '<p style="margin:0;padding:5px 0px">Requested withdrawal amount: £'.$amount.'</p>';
		$html .= '<p style="margin:0;padding:5px 0px">Bank name: '.$bank_name.'</p>';
		$html .= '<p style="margin:0;padding:5px 0px">Sort code: '.$sort_code.'</p>';
		$html .= '<p style="margin:0;padding:5px 0px">Bank account: '.$acc_no.'</p>';
		$html .= '<p style="margin:0;padding:5px 0px">Transaction ID: '.md5($last_id).'</p>';
        $html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
		$mailBody = send_mail_app($html);
		//end email temlete================
		//$mailResponse  =  mailSend($u_email,'Admin', $subject1, $mailBody);

	

 



 
if(empty($email_arr)){
	$email_arr  =  'NA';
}

$record=array('success'=>'true','msg'=>array('Your request of withdrawal has been submitted successfully. Please wait for admin response.'),'email_arr'=>$email_arr); 
jsonSendEncode($record);

