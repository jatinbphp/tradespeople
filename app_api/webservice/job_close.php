<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';


	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}




	// Get All Post Parameter

    $userid			   	    =	$_GET['user_id'];
    $job_id			   	    =	$_GET['job_id'];
	// define variable
	$update_date			=	date("Y-m-d H:i:s");

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();


//-------------------------------------------------------------------------


 if(empty($subcategory) && empty($subcategory_1))
{
$arr = $category;
$sub=$arr;
}
elseif(!empty($subcategory) && empty($subcategory_1))
{
$arr = array($category,$subcategory);
$sub=implode(",",$arr);
}
elseif (!empty($subcategory) && !empty($subcategory)) {
$arr = array($category,$subcategory,$subcategory_1);
$sub=implode(",",$arr);
}


// echo $arr;die();
// echo $arr ;die();
// print_r($sub);

   
$update_user_details = $mysqli->prepare("UPDATE tbl_jobs SET status=9 WHERE job_id=?");
$update_user_details->bind_param("i",$job_id);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>$msg_error_jobadd); 
jsonSendEncode($record);
}


///----------------------------job upload file--------------------		
		
		
	// if($player_id!='123456' || $device_type != 'browser'){
	// 	//----------------update user player_id for push notifications---------------------//
	// 	$result 		=	 DeviceTokenStore_1_Signal($user_id_get, $device_type, $player_id);
	// }



//	if(empty($email_arr)){
	//	$email_arr	=	'NA';
//	}
	
	// $notification_arr = array();
	// // if($login_type>0){
	// // 	$action 		=	'Signup';
	// // 	$action_id 		=	0;
	// // 	$title 			=	'Singup success';
	// // 	$title_2 		=	$title;
	// // 	$title_3 		=	$title;
	// // 	$title_4 		=	$title;
	// // 	$message 		=	'Welcome to '.$app_name.', Your signup successfully done.';
	// // 	$message_2 		=	$message;
	// // 	$message_3 		=	$message;
	// // 	$message_4 		=	$message;
	// // 	$sender_id 		=	$user_id_get;
	// // 	$receive_id 	=	$user_id_get;
	// // 	$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
	// // 	$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $title, $title_2, $title_3, $title_4, $message, $message_2, $message_3, $message_4, $action_data);
	// // 	if($notification_arr_get != 'NA'){
	// // 		$notification_arr[]	=	$notification_arr_get;
	// // 	}
	// // }
	
	// if(empty($notification_arr)){
	// 	$notification_arr	=	'NA';
	// }    
    // Get user complete details
    $user_details	=	getUserDetails($user_id_get); 	
	// response here
	$record	=	array('success'=>'true', 'msg'=>$msg_job_pot_succ, 'user_details'=>$user_details); 
	jsonSendEncode($record);   
?>
