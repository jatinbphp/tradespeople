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

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
 
$user_id	     	=	$_GET['user_id'];
$message			=	$_GET['message'];
$hire_to			=	$_GET['hire_to'];
$main_cate			=	$_GET['main_cate'];
$budget				=	$_GET['budget'];
$delivery_days	    =	$_GET['delivery_days'];
$f_namesend 	    =	$_GET['f_namesend'];

$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount);
$check_user_all->fetch();

$admin_arr 		= getAdminDetails();
$homeOwner 		= getUserDetails($user_id);
$traders 		= getUserDetails($hire_to);

$closed_date 	= $admin_arr['closed_date'];
$c_date 		= date('Y-m-d H:i:s');
$job_end_date 	= date('Y-m-d H:i:s', strtotime($c_date. ' + '.$closed_date.' days'));

$str_result  	=  '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'.time();
$project_id 	=  substr(str_shuffle($str_result),0, 12);

if($traders['u_email_verify']==1){
	$check_postcode = check_postalcode($homeOwner['postal_code']);
	$longitude 		= $check_postcode['longitude'];
	$latitude 		= $check_postcode['latitude'];
	$city 			= $check_postcode['primary_care_trust'];
	$address 		= $check_postcode['address'];
	$country  		= $check_postcode['country'];
	$status         = 4;
	$direct_hired   = 1;

	$job_add = $mysqli->prepare("INSERT INTO tbl_jobs(title,description,budget,userid,status, category,c_date,awarded_time,subcategory,post_code,job_end_date,longitude,latitude,city,address,country,       project_id,awarded_to,direct_hired) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$job_add->bind_param("sssssssssssssssssss",$project_id,$message,$budget,$user_id,$status,$main_cate,$c_date,$c_date,$main_cate,$homeOwner['postal_code'],$job_end_date,$longitude,$latitude,$city,$address,$country,$project_id,$hire_to,$direct_hired);	
	$job_add->execute();
	$job_add_affect_row=$mysqli->affected_rows;
	if($job_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array('Something went wrong, Please try again later')); 
		jsonSendEncode($record);
	}
	$job_id				=	$mysqli->insert_id;
	$cdate 				= 	date('Y-m-d H:i:s');
	$hiring_type 		= 	1;
	$paid_total_miles   = 	0;
	$status = 3;
	$propose_description = $homeOwner['f_name'].' has direct hire to '.$traders['f_name'].' '.$traders['l_name'].' for this job.';

	// insert job bid =======================================
	$update_bid = $mysqli->prepare("INSERT INTO tbl_jobpost_bids(bid_amount, delivery_days, propose_description,  bid_by, job_id, cdate, posted_by, status, update_date,awarded_date,hiring_type,paid_total_miles) Values(?,?,?,?,?,?,?,?,?,?,?,?)");
	$update_bid->bind_param("ssssssssssss",$budget,$delivery_days,$propose_description, $hire_to, $job_id, $cdate, $user_id, $status,$cdate,$cdate,$hiring_type,$paid_total_miles);	
	$update_bid->execute();
	$update_bid_affect_row=$mysqli->affected_rows;
	if($update_bid_affect_row<=0){
		$record=array('success'=>'false','msg'=>array('Something went wrong, Please try again later')); 
		jsonSendEncode($record);
	}
	
	$notification_arr = array();
		$action 		=	'Request';
		$action_id 		=	$job_id;
		$title 			=	'Request';
     	$title_push 	=	'Congratulations! You´ve got a new the offer!';
	    $message_push       = 'Congratulations! '.$f_namesend.' has offered you their job. Please respond now!';
		$message 		=	$f_namesend.' has sent you a direct job offer. <a>Accept or reject</a>';
		$sender_id 		=	$user_id;
		$receive_id 	=	$hire_to;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
		if($notification_arr_get != 'NA'){
			$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
		}
	 if (!empty($notification_arr)) {
       oneSignalNotificationSendtrades($notification_arr);
    }
	if(empty($notification_arr)){
    $notification_arr='NA';
	}
	$notification_arr_own = array();
      $action     =  'Send_Request';
      $action_id     = $job_id;
      $title         =  'Send Request';
      $message       =  'Your direct job offer was sent to '.$traders['trading_name'].' and <a>awaits their acceptance!</a>';
      $sender_id     =  $user_id;
      $receive_id    =  $user_id;
      $action_data   =  array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action);
      $notification_arr_self   =  getNotificationArrSingle($sender_id, $receive_id, $action, $action_id,$message,$title, $action_data);
      if($notification_arr_self  != 'NA'){
        $notification_arr_own= $notification_arr_self ;
      }
  
   if(empty($notification_arr_own)){
    $notification_arr_own='NA';
 }
	
	 
      	$subject =  "Thanks for your direct job offer to ".$traders['trading_name'];
		$content .= '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
		$content .= '<p style="margin:0;padding:10px 0px">Thank you for your direct job offer to '.$traders['trading_name'].'</p>';
	$content .= '<p style="margin:0;padding:10px 0px">As your next step, you can wait for '.$traders['trading_name'].' to respond to the offer.</p>';
$content .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content);

$mailResponse  =  mailSend($homeOwner['email'], $homeOwner['f_name'], $subject, $mailBody);
	
	
	 
      	$subject =  "You're hired: Congratulations for your New Job offer.";
	
		$content1 .= '<p style="margin:0;padding:10px 0px;font-size:18px;font-weight: bold">You are directly hired!</p>';
		$content1 .= '<p style="margin:0;padding:10px 0px">Hi ,</p>';
		$content1 .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$homeOwner['f_name'].' has directly hired you for their new job. These are the next steps to get your work started:
</p>';
$content1 .= '<p style="margin:0;padding:10px 0px;font-size:18px;font-weight: bold">Accept the offer</p>';
$content1 .= '<p style="margin:0;padding:10px 0px">Happy with the offer</p>';
$content1 .= '<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept Now</a>';	
	
$content1 .= '<p style="margin:0;padding:10px 0px;font-size:18px;font-weight: bold">Communicate</p>';
$content1 .= '<p style="margin:0;padding:10px 0px">If you have any question</p>';
$content1 .= '<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Chat Now</a>';	
	
$content1 .= '<p style="margin:0;padding:10px 0px;font-size:18px;font-weight: bold">Milestone payment</p>';
$content1 .= '<p style="margin:0;padding:10px 0px">If no milestone were made</p>';
$content1 .= '<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request Now</a>';	
	
	
$content1 .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content1);

	$email_arr[]				=	array('email'=>$traders['email'], 'fromName'=>$traders['f_name'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($traders['email'], $traders['f_name'], $subject, $mailBody);
	

	
	$record=array('success'=>'true','msg'=>array("Direct hiring request has been sent successfully."),'notification_arr'=>'NA'); 
	jsonSendEncode($record);
}else{
	$msg = $traders['trading_name'].' email is not verified, so you can\'t hire to '.$traders['trading_name'];
	$record=array('success'=>'false','msg'=>array($msg)); 
		jsonSendEncode($record);
}