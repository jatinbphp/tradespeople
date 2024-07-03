<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include('mailFunctions.php');
if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id_post'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_GET['bid_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$user_id	     	=	$_GET['user_id_post'];
$bid_id			    =	$_GET['bid_id'];
$job_id			    =	$_GET['job_id'];
$canccel_reson	    =	$_GET['canccel_reson'];

//get user details==================
$check_user_all	=	$mysqli->prepare("SELECT id,trading_name,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$trading_name,$type_new);
$check_user_all->fetch();
	  
//get bid details==================
$get_bid_record	=	$mysqli->prepare("SELECT id,total_milestone_amount,bid_by from tbl_jobpost_bids where id=?");
$get_bid_record->bind_param("i",$bid_id);
$get_bid_record->execute();
$get_bid_record->store_result();
$get_bid_record1		=	$get_bid_record->num_rows;  //0 1
if($get_bid_record1 <= 0){
	$record		=	array('success'=>'false',  'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$get_bid_record->bind_result($bid_id,$total_milestone_amount,$bid_by);
$get_bid_record->fetch();

//get bid details==================

$get_job_record1	=	$mysqli->prepare("SELECT userid,title from tbl_jobs where job_id=?");
$get_job_record1->bind_param("i",$job_id);
$get_job_record1->execute();
$get_job_record1->store_result();
$get_job_record11		=	$get_job_record1->num_rows;  //0 1
if($get_job_record11 <= 0){
	$record		=	array('success'=>'false',  'msg'=>array('Something went wrong, please try again later')); 
	jsonSendEncode($record);
}
$get_job_record1->bind_result($homeuser_id,$title);
$get_job_record1->fetch();


$update_job = $mysqli->prepare("UPDATE `tbl_jobs` SET `status`=8  WHERE  job_id=?");
$update_job->bind_param("i",$job_id);	
$update_job->execute();
$update_job_affect_row=$mysqli->affected_rows;
if($update_job_affect_row<=0){
	//$record=array('success'=>'false','msg'=>array('Something went wrong, please try again later')); 
	//jsonSendEncode($record);
}

 
$update_job1 = $mysqli->prepare("UPDATE `tbl_jobpost_bids` SET `status`=8 ,reject_reason=?  WHERE  id=?");
$update_job1->bind_param("si",$canccel_reson,$bid_id);	
$update_job1->execute();
$update_job1_affect_row=$mysqli->affected_rows;
if($update_job1_affect_row<=0){
	//$record=array('success'=>'false','msg'=>array('Something went wrong, please try again later')); 
	//jsonSendEncode($record);
}
	
$homeOwner = getUserDetails($homeuser_id);
$traders   = getUserDetails($bid_by);
		

$subject = "Unfortunately! ".$traders['trading_name']." has declined your direct job offer!";
$html = '<p style="margin:0;padding:10px 0px">Hi '.$homeOwner['f_name'].',</p>';
$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! '.$traders['trading_name'].' has declined your direct job offer!</p>';
$html .= '<p style="margin:0;padding:10px 0px">Reason: '.$canccel_reson.'</p>';
$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can edit and re-award the job or offer the job to another tradesperson.</p>';
$html .= '<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit & Award</a></div>';
$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

$mailBody = send_mail_app($html);
$mailResponse  =  mailSend($homeOwner['email'], $traders['trading_name'], $subject, $mailBody);


// notification====================
$notification_arr  = array();
$action 		=	'reject_direct_hire_award';
$action_id 		=    $job_id;
$title 			=	'Award reject';
$title_push     =     'Unfortunately! Your job offer has was declined!';
$message_push   =     'Unfortunately! '.$traders['trading_name'].' has declined your job offer. Post the job to the public. ';
$message 		=	$traders['trading_name'].' rejected your ! <a>direct job offer.</a>';
$sender_id      =   $user_id;
$receive_id 	=	$homeuser_id; 
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get_self	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);

if($notification_arr_get_self != 'NA'){
	$player_id 			=	getUserPlayerId($receive_id);
	
	if($player_id !='no'){
	    	$notification_arr_self[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					if (!empty($notification_arr_self)) {
       oneSignalNotificationSendCall($notification_arr_self);
    }
				}
}

if($type_new==1)
{

$notification_arr_sewnd  = array();
    $action 		    =	'reject_offer';
	$action_id 		    =    $job_id;
	$title_get 			=	'Offer Reject';
    $message_get        =   'You rejected '.$homeOwner['f_name'].' offer successfully';
    $sender_id_trade      =    $user_id;
    $receive_id     =    $user_id; 
    $job_id         =    $job_id;
    $action_data    =   array('user_id'=>$sender_id_trade, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
    $notification_arr_get   =   getNotificationArrSingle($sender_id_trade, $receive_id, $action, $action_id, $message_get,$job_id, $action_data);

    if($notification_arr_get != 'NA'){
        $player_id          =   getUserPlayerId($receive_id);
            if($player_id !='no'){
            $notification_arr_sewnd[] =   array('player_id'=>$player_id, 'message'=>$message_get, 'action_json'=>$action_data,'title'=>$title_get);
                    
                };
    }
     if (!empty($notification_arr_sewnd)) {
     	 oneSignalNotificationSendtrades($notification_arr_sewnd);
    }
}


if(empty($notification_arr)){
	$notification_arr	=	'NA';
}
   $record=array('success'=>'true','msg'=>array('Job offer has been rejected successfully'), 'notification_arr'=>'NA'); 
    jsonSendEncode($record);

?>