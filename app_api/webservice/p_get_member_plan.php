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
	$user_plan_id = 0;
	if($user_id!=0){
		$user_plan=$mysqli->prepare("SELECT up_plan,up_enddate FROM `user_plans` WHERE up_user=? and DATE(up_enddate) >= DATE('".date('Y-m-d')."')  order by up_id limit 1");
		$user_plan->bind_param("i",$user_id);
		$user_plan->execute();
		$user_plan->store_result();
		$user_plan_count=$user_plan->num_rows;  //0 1	
		if($user_plan_count > 0){
			$user_plan->bind_result($user_plan_id,$expire_date);
		 	$user_plan->fetch();
		 	$expire_date = date('d-m-Y',strtotime($expire_date));
		}
	}


	//-------------------------- get county --------------------------
	$getCounty=$mysqli->prepare("SELECT `id`, `package_name`, `description`, `amount`, `bids_per_month`, `email_notification`, `sms_notification`, `unlimited_limited`, `is_delete`, `validation_type`, `status`, `duration_type`, `reward_amount`, `reward`, `category_listing`, `directory_listing`, `unlimited_trade_category`, `total_notification`, `is_free`, `free_plan_exp`, `free_bids_per_month`, `free_sms` FROM `tbl_package` WHERE  is_delete=0 ORDER BY is_free DESC");
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
			if($id==$user_plan_id){
				$upgrade_btn = 'show';
			}


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
				'total_notification'	=>$total_notification, 
				'is_free'				=>$is_free, 
				'free_plan_exp'			=>$free_plan_exp, 
				'free_bids_per_month'=>$free_bids_per_month, 
				'free_sms'				=>$free_sms, 
				'status'				=>false,
			);
		}
	}	
	if(empty($plan_arr)){
		$plan_arr = "NA";
	} 
	$record=array('success'=>'true','msg'=>$data_found,'plan_arr'=>$plan_arr,'user_plan_id'=>$user_plan_id); 
	jsonSendEncode($record);
	?>