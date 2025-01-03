<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

$plan_arr = array();
$user_id = $_GET['user_id'];
$cdate = date('Y-m-d');
$expire_date = date('Y-m-d');
$user_plan_id1 = 0;
$user_buy_plan = 0;
$up_amount = 0;
$free_trial_taken = 0;
$user_plan_arr = array();
if($user_id!=0){
	
	$check_user_all	=	$mysqli->prepare("SELECT free_trial_taken from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($free_trial_taken);
	$check_user_all->fetch();

	
	$cdate1 = date('Y-m-d'); 
	/*echo "SELECT `up_id`, `up_user`, `up_plan`, `up_planName`, `up_amount`, `up_startdate`, `up_enddate`, `up_status`, `up_update`, `up_create`, `up_transId`, `up_bid`, `up_used_bid`, `bid_type`, `plan_status`, `valid_type`, `used_sms_notification`, `total_sms`, `auto_update`, `auto_renewed`, `is_admin_read` FROM `user_plans` where up_user='".$user_id."' and up_status=1 and DATE(up_enddate) >= DATE('".date('Y-m-d')."') ORDER BY up_id DESC LIMIT 1";
	die();*/
	$user_plan=$mysqli->prepare("SELECT `up_id`, `up_user`, `up_plan`, `up_planName`, `up_amount`, `up_startdate`, `up_enddate`, `up_status`, `up_update`, `up_create`, `up_transId`, `up_bid`, `up_used_bid`, `bid_type`, `plan_status`, `valid_type`, `used_sms_notification`, `total_sms`, `auto_update`, `auto_renewed`, `is_admin_read` FROM `user_plans` where up_user='".$user_id."' and up_status=1 and DATE(up_enddate) >= DATE('".date('Y-m-d')."') ORDER BY up_id DESC LIMIT 1");
	//$user_plan->bind_param("i",$user_id);
	$user_plan->execute();
	$user_plan->store_result();
	$user_plan_count=$user_plan->num_rows;  //0 1
	 
	if($user_plan_count > 0){
		$user_plan->bind_result($user_plan_id, $up_user, $user_buy_plan,$up_planName, $up_amount, $up_startdate, $expire_date, $up_status, $up_update, $up_create, $up_transId, $up_bid, $up_used_bid, $bid_type, $plan_status, $valid_type, $used_sms_notification, $total_sms, $auto_update, $auto_renewed, $is_admin_read);
		$user_plan->fetch();

			$user_plan_id1=$user_plan_id;
			$expire_date = date('d-m-Y',strtotime($expire_date));
		 	$expire_date1 = date('d M\, Y',strtotime($expire_date));
			
			$c_date           =  date('Y-m-d h:i:s');
		 	$plan_create_date =  date('Y-m-d h:i:s', strtotime($up_create. ' + 30 day'));
			 
			//if(strtotime($c_date)>=$plan_create_date){
			//	$up_planName = 'Free Trial';
			//}
			 
          if($free_trial_taken==0){
              $up_amount = 'Free Trial';
           }
		    //$auto_update = 1;
			
		 	$user_plan_arr = array(
					 
		 		'up_id'=>$user_plan_id,
		 		'up_user'=>$up_user,
		 		'up_plan'=>$user_buy_plan,
		 		'up_planName'=>$up_planName,
		 		'up_amount'=>$up_amount,
		 		'up_startdate'=>$up_startdate,
		 		'up_enddate'=>$expire_date,
		 		'up_status'=>$up_status,
		 		'up_update'=>$up_update,
		 		'up_create'=>$up_create,
		 		'up_transId'=>$up_transId,
		 		'up_bid'=>$up_bid,
		 		'up_used_bid'=>$up_used_bid,
		 		'bid_type'=>$bid_type,
		 		'plan_status'=>$plan_status,
		 		'valid_type'=>$valid_type,
		 		'used_sms_notification'=>$used_sms_notification,
		 		'total_sms'=>$total_sms,
		 		'auto_update'=>$auto_update,
		 		'auto_renewed'=>$auto_renewed,
		 		'is_admin_read'=>$is_admin_read,
				'expire_date'=>$expire_date1,
				'plan_create_date'=>$plan_create_date,
		 	);  
	}
}

//$settings = getAdminDetails();
//if($free_trial_taken==0){
//    if($settings['payment_method']==0) {
//		$free_trial_taken=1;	
//		$update44 = $mysqli->query("UPDATE users SET free_trial_taken=1 WHERE id='$user_id'");
//	} else {
//		$up_amount = 'Free Trial';
//	    $free_trial_taken=0;
//	}
//}

//-------------------------- get county --------------------------
if($free_trial_taken == 0)
{
	$getCounty=$mysqli->prepare("SELECT `id`, `package_name`, `description`, `amount`, `bids_per_month`, `email_notification`, `sms_notification`, `unlimited_limited`, `is_delete`, `validation_type`, `status`, `duration_type`, `reward_amount`, `reward`, `category_listing`, `directory_listing`, `unlimited_trade_category`, `total_notification`, `is_free`, `free_plan_exp`, `free_bids_per_month`, `free_sms` FROM `tbl_package` WHERE  is_delete=0 and status=0 AND is_free=1 ORDER BY is_free DESC");
}else{
	 	 
		$getCounty=$mysqli->prepare("SELECT `id`, `package_name`, `description`, `amount`, `bids_per_month`, `email_notification`, `sms_notification`, `unlimited_limited`, `is_delete`, `validation_type`, `status`, `duration_type`, `reward_amount`, `reward`, `category_listing`, `directory_listing`, `unlimited_trade_category`, `total_notification`, `is_free`, `free_plan_exp`, `free_bids_per_month`, `free_sms` FROM `tbl_package` WHERE  is_delete=0 and status=0   ORDER BY is_free DESC");

}
$getCounty->execute();
$getCounty->store_result();
$getCounty_count=$getCounty->num_rows;  //0 1	
if($getCounty_count > 0){
	$getCounty->bind_result($id, $package_name, $description, $amount, $bids_per_month, $email_notification, $sms_notification, $unlimited_limited, $is_delete, $validation_type, $status, $duration_type, $reward_amount, $reward, $category_listing, $directory_listing, $unlimited_trade_category, $total_notification, $is_free, $free_plan_exp, $free_bids_per_month, $free_sms);
	while ($getCounty->fetch()) { 

		$bids = explode(" ",$bids_per_month);
		$bids_free = explode(" ",$free_bids_per_month);
		$credits_per_month = $bids[0];
		$credits_per_month_free = $bids_free[0];
		$upgrade_btn = 'hide';
		$already_have_plan='no';
		// if($id==$user_buy_plan){
		// 	$upgrade_btn = 'show';
		// 	$already_have_plan='yes';
		// }
		$plan_arr[] = array(
			'id'					=>$id, 
			'package_name'			=>$package_name, 
			'package_name'			=>$package_name, 
			'description'			=>$description, 
			'amount'				=>$amount, 
			'upgrade_btn'			=>$upgrade_btn,
			'bids_per_month'		=>$bids_per_month, 
			'credits_per_month_free'=>$credits_per_month_free, 
			'credits_per_month'		=>$credits_per_month, 
			'email_notification'	=>$email_notification, 
			'sms_notification'		=>$sms_notification, 
			'unlimited_limited'		=>$unlimited_limited, 
			'validation_type'		=>$validation_type, 
			'duration_type'			=>$duration_type, 
			'expire_date'			=>$expire_date, 
			'reward_amount'			=>$reward_amount, 
			'reward'				=>$reward, 
			'category_listing'		=>$category_listing, 
			'directory_listing'		=>$directory_listing, 
			'unlimited_trade_category'=>$unlimited_trade_category, 
			'already_have_plan'=>$already_have_plan, 
			'total_notification'	=>$total_notification, 
			'is_free'				=>$is_free, 
			'free_plan_exp'			=>$free_plan_exp, 
			'free_bids_per_month'   =>$free_bids_per_month, 
			'free_sms'				=>$free_sms, 
			'status'				=>false,
			'package_type'			=>0,
		);
	}
}





$add_on_arr = array();
$get_addons=$mysqli->prepare("SELECT `id`, `amount`, `type`, `description`, `quantity` FROM `addons`");
$get_addons->execute();
$get_addons->store_result();
$get_addons_count=$get_addons->num_rows;  //0 1	
if($get_addons_count > 0){
	$get_addons->bind_result($id, $amount, $type, $description, $quantity);
	while ($get_addons->fetch()) { 
		$add_on_arr[] = array(
			'id'	        =>	$id, 
			'amount'	    =>	$amount, 
			'type'	        =>	$type, 
			'description'	=>	$description, 
			'quantity'	    =>	$quantity, 
		);
	}
}	
if(empty($plan_arr)){
	$plan_arr = "NA";
} 


 
if(empty($add_on_arr)){
	$add_on_arr = "NA";
} 

if(empty($user_plan_arr)){
	$user_plan_arr = "NA";
} 

$min_amt = 0;
$max_amt = 0;


$get_admin_data=$mysqli->prepare("SELECT p_max_d,p_min_d FROM `admin`");
$get_admin_data->execute();
$get_admin_data->store_result();
$get_admin_data_count=$get_admin_data->num_rows;  //0 1	
if($get_admin_data_count > 0){
	$get_admin_data->bind_result($max_amt,$min_amt);
	$get_admin_data->fetch();
}	

$credit_amt  	=  getToCreditAmount($user_id);
$debit_amt   	=  getToDebitAmount($user_id);
$total_balance  =  getWalletBalance($user_id);
$user_details	=	getUserDetails($user_id); 	

$record=array('success'=>'true','msg'=>$data_found,'plan_arr'=>$plan_arr,'user_plan_id'=>$user_plan_id1,'add_on_arr'=>$add_on_arr,'user_buy_plan'=>$user_buy_plan,'debit_amt'=>$debit_amt,'credit_amt'=>$credit_amt,'total_balance'=>$total_balance,'min_amt'=>$min_amt,'max_amt'=>$max_amt,'user_details'=>$user_details,'user_plan_arr'=>$user_plan_arr,'already_by_plan'=>'yes'); 
jsonSendEncode($record);
?>