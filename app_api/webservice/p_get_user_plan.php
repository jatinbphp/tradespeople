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
	$user_buy_plan = 0;

 
 

	$user_plan=$mysqli->prepare("SELECT `up_id`, `up_user`, `up_plan`, `up_planName`, `up_amount`, `up_startdate`, `up_enddate`, `up_status`, `up_update`, `up_create`, `up_transId`, `up_bid`, `up_used_bid`, `bid_type`, `plan_status`, `valid_type`, `used_sms_notification`, `total_sms`, `auto_update`, `auto_renewed`, `is_admin_read` FROM `user_plans` WHERE up_user=? and up_status=1 and DATE(up_enddate) >= DATE('".date('Y-m-d')."')  order by up_id DESC limit 1");
	$user_plan->bind_param("i",$user_id);
	$user_plan->execute();
	$user_plan->store_result();
	$user_plan_count=$user_plan->num_rows;  //0 1	
	if($user_plan_count > 0){
		$user_plan->bind_result($up_id, $up_user, $up_plan,$up_planName, $up_amount, $up_startdate, $up_enddate, $up_status, $up_update, $up_create, $up_transId, $up_bid, $up_used_bid, $bid_type, $plan_status, $valid_type, $used_sms_notification, $total_sms, $auto_update, $auto_renewed, $is_admin_read);
	 	$user_plan->fetch();
	 	$expire_date = date('d M\, Y',strtotime($up_enddate));
	 	$plan_arr = array(
	 		'up_id'=>$up_id,
	 		'up_user'=>$up_user,
	 		'up_plan'=>$up_plan,
	 		'up_planName'=>$up_planName,
	 		'up_amount'=>$up_amount,
	 		'up_startdate'=>$up_startdate,
	 		'up_enddate'=>$up_enddate,
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
			'expire_date'=>$expire_date,
	 	); 
	}

	 if(empty($plan_arr)){
	 	$plan_arr = 'NA';
	 }

	$notification_arr = array();
	$action = 'Signup';
	$action_id = 0;
	$title = 'Singup success';
	$message = 'Welcome to '.$app_name.', Your signup successfully done.';
	$sender_id = $user_id;
	$receive_id = $user_id; 
	$action_data = array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
	$notification_arr_get = getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
	if($notification_arr_get != 'NA'){
		$notification_arr[] = $notification_arr_get;
	}
	 
	if(empty($notification_arr)){
		$notification_arr = 'NA';
	} 

	$record=array('success'=>'true','msg'=>$data_found,'plan_arr'=>$plan_arr,'notification_arr'=>$notification_arr); 
	jsonSendEncode($record);
?>