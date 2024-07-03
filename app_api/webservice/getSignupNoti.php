 <?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_get_method); 
		jsonSendEncode($record); 
	}
    
   

	$user_id 	 = $_GET['user_id'];
 
	//get user id chweck==========================
    $check_user_all	=	$mysqli->prepare("SELECT `id`,f_name,l_name,phone_no FROM `users` WHERE id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
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

	$record=array('success'=>'false','msg' =>array("Dta Found"),'notification'=>$notification_arr); 
	jsonSendEncode($record); 
?>