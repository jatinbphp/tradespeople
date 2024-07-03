<?php 
include 'stripe_config.php';
require 'vendor/autoload.php';
include '../con1.php';
include '../language_message.php';
include '../function_app_common.php';
include '../function_app.php';

if(!$_POST){
    $record=array('success'=>'false','msg' =>$msg_post_method); 
    jsonSendEncode($record); 
}
if(empty($_POST['user_id_post'])){
    $record = array('success'=>'false', 'msg' =>$msg_empty_param); 
    jsonSendEncode($record);
}
if(empty($_POST['appointment_id'])){
    $record = array('success'=>'false', 'msg' =>$msg_empty_param); 
    jsonSendEncode($record);
}

if(empty($_POST['cancel_status'])){
    $record = array('success'=>'false', 'msg' =>$msg_empty_param); 
    jsonSendEncode($record);
}
if(empty($_POST['appointment_number'])){
    $record = array('success'=>'false', 'msg' =>$msg_empty_param); 
    jsonSendEncode($record);
}

// ------------------- get value from field ------------------- //
$user_id_post        =   $_POST['user_id_post']; 
$appointment_id_post =   $_POST['appointment_id'];
$cancel_reason       =   'NA';
if(isset($_POST['cancel_reason'])){
	$cancel_reason   =   $_POST['cancel_reason'];
}

$cancel_status       =   $_POST['cancel_status'];
$appointment_number  =   $_POST['appointment_number'];
$user_car_pickup_status       =   $_POST['user_car_pickup_status'];
$garage_id           =   $_POST['garage_id'];
$createtime          =   date('Y-m-d H:i:s');
$updatetime          =   date('Y-m-d H:i:s');
$notification_arr    =   array();

if($cancel_status!='decline_accept'){
	$appointment_details = $mysqli->prepare("SELECT `appointment_id`,`cancel_amount`,`appointment_status`,payment_intentent_id FROM `appointment_master` WHERE delete_flag=0  AND `appointment_id`=?");
	$appointment_details->bind_param('i',$appointment_id_post);
	$appointment_details->execute();
	$appointment_details->store_result();
	$select_appoitment_model = $appointment_details->num_rows;
	if($select_appoitment_model > 0){
	    $appointment_details->bind_result($appointment_id,$cancel_amount, $appointment_status,$payment_intentent_id);
	    $appointment_details->fetch();
	    if($appointment_status == 0){
	        $appoint_status = 10;
	        $update_all =   $mysqli->prepare("UPDATE `appointment_master` SET `appointment_status`=?,`user_cancel_date`=?,`user_cancel_reason`=?,`updatetime`=? WHERE appointment_id = ?");
	        $update_all->bind_param("isssi",$appoint_status,$updatetime,$cancel_reason,$updatetime,$appointment_id_post);
	        $update_all->execute();
	        $update_affected_rows   =   $mysqli->affected_rows;
	        if($update_affected_rows<=0){
	            $record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_error); 
	            jsonSendEncode($record);
	            return;
	        }else{
        		//Notification===========
        	    $user_details = getUserDetails1($user_id_post);
        	    $user_name = '';
        	    if($user_details != "NA"){
        	        $user_name  = $user_details['name'];
        	    }
        	    $action         =   'appointment_cancel';
        	    $action_id      =   $appointment_id_post;

        	    $tit            =   messageAppointCancelTitle();
        	    $title          =   $tit[0];
        	    $title_2        =   $tit[1];
        	    $title_3        =   $tit[2];
        	    $title_4        =   $title;

        	    $app_data['user_name'] =   $user_name;
        	    $msg            =   messageAppointCancel($app_data);

        	    $message        =   $msg[0];
        	    $message_2      =   $msg[1];
        	    $message_3      =   $msg[2];
        	    $message_4      =   $message;
        	    $sender_id      =   $user_id_post;
        	    $receive_id     =   $garage_id;
        	    $action_data    =   array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
        	    $notification_arr_get   =   getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $title, $title_2, $title_3, $title_4, $message, $message_2, $message_3, $message_4, $action_data);
        	    if($notification_arr_get != 'NA'){
        	        $notification_arr[] =   $notification_arr_get;
        	    }
        	    //notification=============
	        }
	    }
	    if($appointment_status == 1){
	    	 // cancel_amount,cancel_status,cancel_amount_date
	    	$cp_amt = $cancel_amount*100;
	    	$cp_amt1 = (int)$cp_amt; 
	        \Stripe\Stripe::setApiKey($secret_key);
			$intent = \Stripe\PaymentIntent::retrieve($payment_intentent_id);
			$result = $intent->capture(['amount_to_capture' => $cp_amt1]);
			if($result['status']=='succeeded'){
		        $appoint_status = 10;
		        $cancel_status  = 1 ;
		        $cancel_amount_date = $updatetime;
		        $update_all =   $mysqli->prepare("UPDATE `appointment_master` SET `appointment_status`=?,cancel_status=?,cancel_amount_date=?,`user_cancel_date`=?,`user_cancel_reason`=?,`updatetime`=? WHERE appointment_id = ?");
		        $update_all->bind_param("iissssi",$appoint_status,$cancel_status,$cancel_amount_date,$updatetime,$cancel_reason,$updatetime,$appointment_id_post);
		        $update_all->execute();
		        $update_affected_rows   =   $mysqli->affected_rows;
		        if($update_affected_rows<=0){
		            $record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_error); 
		            jsonSendEncode($record);
		            return;
		        }else{
		        	//Notification===========
			        $user_details = getUserDetails1($user_id_post);
			        $user_name = '';
			        if($user_details != "NA"){
			            $user_name  = $user_details['name'];
			        }
			        $action         =   'appointment_cancel';
			        $action_id      =   $appointment_id_post;

			        $tit            =   messageAppointCancelTitle();
			        $title          =   $tit[0];
			        $title_2        =   $tit[1];
			        $title_3        =   $tit[2];
			        $title_4        =   $title;

			        $app_data['user_name'] =   $user_name;
			        $msg            =   messageAppointCancel($app_data);

			        $message        =   $msg[0];
			        $message_2      =   $msg[1];
			        $message_3      =   $msg[2];
			        $message_4      =   $message;
			        $sender_id      =   $user_id_post;
			        $receive_id     =   $garage_id;
			        $action_data    =   array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
			        $notification_arr_get   =   getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $title, $title_2, $title_3, $title_4, $message, $message_2, $message_3, $message_4, $action_data);
			        if($notification_arr_get != 'NA'){
			            $notification_arr[] =   $notification_arr_get;
			        }
			       
			        //notification=============
		        }
			}else{
				$record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_error); 
		    	jsonSendEncode($record);
		    	return;
			}
	    }

    	if($appointment_status > 1){
		    $record=array('success'=>'false', 'msg'=>$msgcancelappointerr); 
		    jsonSendEncode($record);
		    return;
    	}
	}else{
	    $record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_id_err); 
	    jsonSendEncode($record);
	    return;
	}
}else{
	
	$appointment_details = $mysqli->prepare("SELECT `appointment_id`,`appointment_status` FROM `appointment_master` WHERE delete_flag=0  AND `appointment_id`=?");
	$appointment_details->bind_param('i',$appointment_id_post);
	$appointment_details->execute();
	$appointment_details->store_result();
	$select_appoitment_model = $appointment_details->num_rows;
	if($select_appoitment_model > 0){
	    $appointment_details->bind_result($appointment_id, $appointment_status);
	    $appointment_details->fetch();
	    if($appointment_status == 1){
	        $update_all =   $mysqli->prepare("UPDATE `appointment_master` SET `user_car_pickup_status`=?,`user_cancel_date`=?,`updatetime`=? WHERE appointment_id = ?");
	        $update_all->bind_param("issi",$user_car_pickup_status,$updatetime,$updatetime,$appointment_id_post);
	        $update_all->execute();
	        $update_affected_rows   =   $mysqli->affected_rows;
	        if($update_affected_rows<=0){
	            $record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_error); 
	            jsonSendEncode($record);
	            return;
	        }
	        // //Notification===========
	        $user_details = getUserDetails1($user_id_post);
	        $user_name = '';
	        if($user_details != "NA"){
	            $user_name  = $user_details['name'];
	        }
	        if($user_car_pickup_status==1){
	        	$app_data['appointment_number'] =   $appointment_number;
	        	$app_data['user_name'] 			=   $user_name;
	        	$action 						=  'accept_picup_date';
	        	$tit            				=   messageAppointPickUpAcceptTitle();
	        	$msg            				=   messageAppointPickUpAcceptmsg($app_data);
	        }else{
	        	$app_data['appointment_number'] =   $appointment_number;
	        	$app_data['user_name'] 			=   $user_name;
	        	$action 						=  'reject_picup_date';
	        	$tit            				=   messageAppointPickUpCancelTitle();
	        	$msg            				=   messageAppointPickUpCancelTitlemsg($app_data);
	        }	
	        $action         =   $action;
	        $action_id      =   $appointment_id_post;

	        $title          =   $tit[0];
	        $title_2        =   $tit[1];
	        $title_3        =   $tit[2];
	        $title_4        =   $title;

	        $app_data['user_name'] =   $user_name;

	        $message        =   $msg[0];
	        $message_2      =   $msg[1];
	        $message_3      =   $msg[2];
	        $message_4      =   $message;
	        $sender_id      =   $user_id_post;
	        $receive_id     =   $garage_id;
	        $action_data    =   array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
	        $notification_arr_get   =   getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $title, $title_2, $title_3, $title_4, $message, $message_2, $message_3, $message_4, $action_data);
	        if($notification_arr_get != 'NA'){
	            $notification_arr[] =   $notification_arr_get;
	        }
	        //notification=============
	    }else{
	        $record=array('success'=>'false', 'msg'=>$msgcancelappointerr); 
	        jsonSendEncode($record);
	        return;
	    }
	}else{
	    $record=array('success'=>'false', 'msg'=>$msg_cancel_appoint_id_err); 
	    jsonSendEncode($record);
	    return;
	}
}

if(empty($notification_arr)){
    $notification_arr =   'NA';
}

if($cancel_status!='decline_accept'){
	$mss = $msg_cancel_appoint_success;
}else{
	if($user_car_pickup_status==1){
		$mss = $messageAccept;
	}
	if($user_car_pickup_status==2){
		$mss = $messageDecline;
	}
}

$record = array('success'=>'true', 'msg'=>$mss,'notification_arr'=>$notification_arr); 
jsonSendEncode($record);
return ; 

?>