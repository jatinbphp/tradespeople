<?php	
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';
	
	if(!$_GET){
		$record=array('success'=>'false', 'msg' =>$msg_get_method); 
		jsonSendEncode($record);
	}
 	
 	if(empty($_GET['plan_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
 	}
 	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
 	}

	$plan_arr  = array();
	$plan_id   = $_GET['plan_id'];
	$user_id   = $_GET['user_id'];
	$plan_type = $_GET['plan_type'];
	$cdate     = date('Y-m-d');


	//-------------------------- check user_id --------------------------
	$check_user_all=$mysqli->prepare("SELECT  id from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user=$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
		jsonSendEncode($record);
	}



	//-------------------------- get county --------------------------
	$getCounty=$mysqli->prepare("SELECT `id`, `package_name`, `description`, `amount`, `bids_per_month`, `email_notification`, `sms_notification`, `unlimited_limited`, `is_delete`, `validation_type`, `status`, `duration_type`, `reward_amount`, `reward`, `category_listing`, `directory_listing`, `unlimited_trade_category`, `total_notification`, `is_free`, `free_plan_exp`, `free_bids_per_month`, `free_sms` FROM `tbl_package` WHERE  is_delete=0 and id=?");
	$getCounty->bind_param("i",$plan_id);
	$getCounty->execute();
	$getCounty->store_result();
	$getCounty_count=$getCounty->num_rows;  //0 1	
	if($getCounty_count <= 0){
		$record=array('success'=>'true','msg'=>$p_plan_id_err); 
		jsonSendEncode($record);
	}	
	$getCounty->bind_result($id, $package_name, $description, $amount, $bids_per_month, $email_notification, $sms_notification, $unlimited_limited, $is_delete, $validation_type, $status, $duration_type, $reward_amount, $reward, $category_listing, $directory_listing, $unlimited_trade_category, $total_notification, $is_free, $free_plan_exp, $free_bids_per_month, $free_sms);
	$getCounty->fetch();



	
	$upstatus = 0;
	$txn_id = 1;
	$auto_update = 1;
	$unlimited_limited = ($unlimited_limited==0) ? 1:2;

    if($plan_type==0){
		$bids = explode(" ",$bids_per_month);
    	$credits_per_month = $bids[0];
    	$free_sms = $sms_notification;

    	$up_startdate = date('Y-m-d');
		$expire_date_time = date('Y-m-d',strtotime($up_startdate. '+ '.$free_plan_exp));
		$expire_date_time = date('Y-m-d',strtotime($expire_date_time. '- 1 day'));
	}else{
		$bids = explode(" ",$free_bids_per_month);
    	$credits_per_month = $bids[0];
    	$free_sms = $free_sms;

    	$up_startdate = date('Y-m-d');
		$expire_date_time = date('Y-m-d',strtotime($up_startdate. '+ '.$validation_type));
		$expire_date_time = date('Y-m-d',strtotime($expire_date_time. '- 1 day'));
	}
  

	// insert plan in user account
	$plan_add = $mysqli->prepare("INSERT INTO `user_plans`(`up_user`, `up_plan`, `up_planName`, `up_amount`, `up_startdate`, `up_enddate`, `up_status`, `up_update`, `up_create`, `up_transId`, `up_bid`,`bid_type`, `valid_type`, `total_sms`,auto_update) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$plan_add->bind_param("iissssissssiiii",$user_id,$id,$package_name,$amount,$cdate,$expire_date_time,$upstatus,$cdate,$cdate,$txn_id,$credits_per_month,$unlimited_limited,$duration_type,$free_sms,$auto_update);	
	$plan_add->execute();
	$plan_add_affect_row=$mysqli->affected_rows;
	if($plan_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>$p_plan_add_err); 
		jsonSendEncode($record);
	}
	$last_insert_id = $mysqli->insert_id;
	 
	$notification_arr = array();
		$action 		=	'plan_active';
		$action_id 		=	0;
		$title 			=	'Plan Activated';
		$message 		=	'Your ' .$package_name.' subcription plan has been successfully activated. View plan!';
		$sender_id 		=	$user_id;
		$receive_id 	=	$user_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}
		if(empty($notification_arr)){
    $notification_arr='NA';
}$record=array('success'=>'true','msg'=>$p_plan_add_succ,'plan_amount'=>$amount,'last_insert_id'=>$last_insert_id,'plan_id'=>$id,'notification_arr'=>$notification_arr); 
	jsonSendEncode($record);
?>