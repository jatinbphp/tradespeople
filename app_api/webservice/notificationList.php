<?php
    ini_set('display_errors', 1);
    //include files
	include('con1.php');
	include('function_app.php');
	include('function_app_common.php'); 
	include('language_message.php');   
	
    //--------- check method ---------------------//
    if(!$_GET) {
    	$record=array('success'=>'false','msg' =>$msg_get_method); 
    	jsonSendEncode($record); 
    } 
	
    if(empty($_GET['user_id_post'])) {
		$record=array('success'=>'false','msg' =>$msg_empty_param); 
	    jsonSendEncode($record);
	}
	
	$last_id		=	0;	
	if(isset($_GET['last_id'])){
		$last_id	=	$_GET['last_id'];
	}
	$user_id_post		=	$_GET['user_id_post'];
	
					
				
		
 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id, ); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get);
	$check_user_all->fetch();

	//----------------------------- check account activate or not ----------------------
	// $active_status 	=	checkAccountActivateDeactivate($user_id_get);
	// if($active_status == 0){
	// 	$record		=	array('success'=>'false', 'msg' =>$msg_error_activation, 'account_active_status'=>'deactivate'); 
	// 	jsonSendEncode($record); 
	// }
		
		 
	$notification_arr		=	array();
	$booking_date_time = '';
    $booking_user_name = '';
	if($last_id==0){
		$query_notification_data	=	$mysqli->prepare("SELECT nt_id, nt_userId, action, action_id, action_json, nt_message, nt_satus, nt_create,  job_id, posted_by FROM notification WHERE   nt_userId=? ORDER BY nt_id DESC ");
		$query_notification_data->bind_param("i",$user_id_get);
	}else{
		$query_notification_data	=	$mysqli->prepare("SELECT nt_id, nt_userId, action, action_id, action_json, nt_message, nt_satus, nt_create,  job_id, posted_by FROM notification WHERE  nt_userId=? and nt_id < ? ORDER BY nt_id  DESC LIMIT 8");
		$query_notification_data->bind_param("ii",$user_id_get,$last_id);
	}
	

    $query_notification_data->execute();
    $query_notification_data->store_result();
	//echo "num rows===";print_r($query_notification_data->num_rows);die;
    if($query_notification_data->num_rows > 0){    	
    	$query_notification_data->bind_result($notification_message_id,$other_user_id, $action, $action_id, $action_json,$message, $read_status,$createtime, $job_id, $posted_by,);
    	while($query_notification_data->fetch()){		
    		
$content = $message;
$result=preg_replace('/(<a .*href=["\'])([^> ]*)([\'"]>)([^<]*)(<\/a>)/i', '\1\3\4\5', $content); 

			$user_name						=	'NA';
			$user_image						=	'NA';						
			$user_type						=	 0;						
		
			$user_name_where    		    =   getUserDetails($posted_by);
			if($user_name_where!='NA'){
				if($posted_by){
					$user_name     				=	$user_name_where['name'];	
					$user_image     			=   $user_name_where['profile'];
					$user_type                  =   $user_name_where['type'];
				}		
				
			}
			
			$createtime_ago					=	 $time_ago = timeAgoCustomer($createtime);;
			$notification_details			=	"NA";
		
				$notification_arr[]	            =	array(
					'notification_message_id'	=>	$notification_message_id, 
					'other_user_id' 			=>	$other_user_id, 
					'user_id_me' 				=>	$user_id_me, 
					'user_name' 				=>	$user_name, 
					// 'booking_user_name' 		=>	$booking_user_name, 
					'user_image' 				=>	$user_image, 
					'action' 					=>	$action, 
					'action_id' 				=>	$action_id, 
					'action_json' 				=>	$action_json, 
					//'title' 					=>	array($title, $title_2, $title_3, $title_4), 
					'message' 					=>	$result, 
					'read_status' 				=>	$read_status, 
					// 'delete_flag' 				=>	$delete_flag, 
					'createtime' 				=>	$createtime, 
					'createtime_ago'			=>	$createtime_ago, 
					'notification_details'		=>	$notification_details, 
					'posted_by'       			 =>  $posted_by,
					'user_type'       		    =>  $user_type,
				);
			}
    
    }
		
    $read_status	=	1;
    $updatetime		=	date('Y-m-d H:i:s');
	// Now update read notification status			
	$update_all	=	$mysqli->prepare("UPDATE notification SET nt_satus=?, nt_update=? WHERE nt_userId=? ");
	$update_all->bind_param("isi", $read_status, $updatetime, $user_id_post);
	$update_all->execute();
	$update_affected_rows	=	$mysqli->affected_rows;

    if(empty($notification_arr)){
    	$notification_arr	=	'NA';
    } 

    $notification_count = getUserNotificationCount($user_id_post);

	$record		=	array('success'=>'true', 'msg' =>$data_found, 'notification_arr'=>$notification_arr,'notification_count'=>$notification_count);
    jsonSendEncode($record);
?>