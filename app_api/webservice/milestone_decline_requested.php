<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
include 'mailFunctions.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

if(empty($_GET['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id	     	=	$_GET['user_id'];
$job_id			 	=	$_GET['job_id'];
$milestone_id	    =	$_GET['milestone_id'];


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,f_name,l_name,email,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$f_name,$l_name,$email,$type_hide);
$check_user_all->fetch();

$mileData = getMileStoneById($milestone_id);


/*
$delete_milestone = $mysqli->prepare("DELETE FROM `tbl_milestones` WHERE id=?");
$delete_milestone->bind_param("i",$milestone_id);	
$delete_milestone->execute();
$delete_milestone_affect_row=$mysqli->affected_rows;
if($delete_milestone_affect_row<=0){
	$record=array('success'=>'false','msg'=>$msg_error_update); 
	jsonSendEncode($record);
}

*/
$f_name=trim($f_name);
// notification====================
$notification_arr  = array();
$action 		=	'decline_milestone_request';
$action_id 		=    $job_id;
$title 			=	'Decline request';
$title_push     =   $f_name.' declined your milestone creation request!';
$message_push   =   $f_name.' has declined your milestone creation request.';
$message 		=	$f_name.' declined your milestone cancellation request.!';
$sender_id      =   $user_id;
$receive_id 	=	$mileData['created_by'];
$job_id			=   $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	if($player_id !='no'){
			$player_id 			=	getUserPlayerId($receive_id);
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
}
if (!empty($notification_arr)) {
	if($type_hide==2)
	{
       oneSignalNotificationSendtrades($notification_arr);
	}
	else{
	  oneSignalNotificationSendCall($notification_arr);
	}
    }

$has_email_noti =  getUserDetails($mileData['created_by']);				
$trades =  getUserDetails($mileData['userid']);	
	$subject = "Your milestone creation request has been declined by ".$f_name;
	$html .='<p>Your request to create a milestone has been declined by '.$f_name.'</p>';
	$html .='<p>Milestone name: '.$mileData['milestone_name'].'</p>';
	$html .='<p>Milestone amount: £'.$mileData['milestone_amt'].'</p>';
	$html .= '<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">View Milestone</a>
    </div>';
		$html .='<p>We encourage you to discuss with '.$f_name.' and explain why the milestone needs to be created.
</p>';
	$html .='<p>View our  tradespeople help page or contact our customer services if you have any specific questions using our service.
</p>';
	
	$mailBody1 = send_mail_app($html);
	$mailResponse  =  mailSend($trades['email'], $f_name, $subject, $mailBody1);

  $subjectH = " You´ve declined Milestone Payment Creation request by ".$trades['f_name']." for the job";
	$htmlH .='<p>Request to create a milestone payment declined successfully! </p>';
	$htmlH .='<p>Hi '.$f_name.' </p>';
	$htmlH .='<p>You have declined '.$trades['trading_name'].' milestone payment creation requested for the job.</p>';
			
	$htmlH .='<p>Milestone name: '.$mileData['milestone_name'].'</p>';
	$htmlH .='<p>Milestone amount: £'.$mileData['milestone_amt'].'</p>';
	$htmlH .='<p>Creating a Milestone payment to guarantee you want to work with  '.$trades['trading_name'].'. Tradespeople are 150% more likely to accept your offer when you create a Milestone Payment. 
</p>';
$htmlH .= '<br><div style="text-align:center"> 
 	<a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none"> Create Milestone Now!</a>
    </div>';
	$htmlH .='<p>Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.
</p>';
	$mailBody1 = send_mail_app($htmlH);
	$mailResponse  =  mailSend($email, $f_name, $subjectH, $mailBody1);

if(empty($notification_arr)){
	$notification_arr	=	'NA';
}

$record=array('success'=>'true','msg'=>array('Milestone request has been decline successfully.'),'notification_arr'=>$notification_arr); 
jsonSendEncode($record);

