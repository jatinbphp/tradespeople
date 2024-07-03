<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';


	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
    if(empty($_POST['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
    if(empty($_POST['dispute_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
   if(empty($_POST['job_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}
	


	// Get All Post Parameter
    $user_id			  = $_POST['user_id'];
    $dispute_id          = $_POST['dispute_id']; 
    $job_id              = $_POST['job_id'];
    $offer_amount        = $_POST['offer_amount'];
    $trans_id           = mt_rand(10000, 99999);
	// define variable
	$update_date			=	date("Y-m-d H:i:s");
    

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT ds_id,ds_in_id,ds_buser_id,ds_puser_id,ds_job_id from tbl_dispute where ds_id=?");
$check_user_all->bind_param("s",$dispute_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user	= $check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($ds_id,$ds_in_id,$ds_buser_id,$ds_puser_id,$ds_job_id);
	$check_user_all->fetch();


//-------------------------------------------------------------------------

$users = getUserDetails($user_id);
$user_type = $users['type'];

if ($ds_buser_id != $user_id && $ds_puser_id != $user_id) {
$record=array('success'=>'false','msg'=>'You are not authorized to add offer for this dispute.'); 
jsonSendEncode($record);
}

$last_offer_by = $user_id;

if ($user_type == 1) {
	$tradesmen_offer = $offer_amount;
	$offer_rejected_by_homeowner = 0;
$dis_details = $mysqli->prepare("UPDATE tbl_dispute SET tradesmen_offer=?, offer_rejected_by_homeowner=?, last_offer_by=? WHERE ds_id=?");
$dis_details->bind_param("sssi",$tradesmen_offer,$offer_rejected_by_homeowner,$last_offer_by,$dispute_id);
$dis_details->execute();
$dis_details_count = $mysqli->affected_rows;
if($dis_details_count <= 0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later1'); 
// jsonSendEncode($record);	
}
	
} else {
	
	$homeowner_offer = $offer_amount;
	$offer_rejected_by_tradesmen = 0;
$dis_details = $mysqli->prepare("UPDATE tbl_dispute SET homeowner_offer=?, offer_rejected_by_tradesmen=?,last_offer_by=? WHERE ds_id=?");
$dis_details->bind_param("sssi",$homeowner_offer,$offer_rejected_by_tradesmen,$last_offer_by,$dispute_id);
$dis_details->execute();
$dis_details_count	=	$mysqli->affected_rows;
if($dis_details_count<=0)
{
$record=array('success'=>'false','msg'=>'Something Went Wrong try again later10'); 
// jsonSendEncode($record);	
}
	
}




//// Insert Event

$event_name = 'new_offer';
$event_data = [
			'amount'=>$offer_amount
		];
$data = serialize($event_data);
if($user_type==1){
		$event_message = 'Tradesman created the new offer of amount £'.$offer_amount;
	} else {
	$event_message = 'Homeowner created the new offer of amount £'.$offer_amount;
}

$dis_evn_add = $mysqli->prepare("INSERT INTO `dispute_events`(`dispute_id`, `event_name`, `user_id`, `data`, `message`) VALUES (?,?,?,?,?)");
	$dis_evn_add->bind_param("issss",$dispute_id,$event_name,$user_id,$data,$event_message);	
	$dis_evn_add->execute();
	$dis_evn_add_row=$mysqli->affected_rows;
	if($dis_evn_add_row<=0){
		$record=array('success'=>'false','msg'=>'Something Went Wrong try again later'); 
		//jsonSendEncode($record);
	}

 
//// Notification 
$job_all = $mysqli->prepare("SELECT title,description from tbl_jobs where job_id=?");
$job_all->bind_param("i",$ds_job_id);
$job_all->execute();
$job_all->store_result();
$job_all_user =	$job_all->num_rows;  //0 1
if($job_all_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$job_all->bind_result($title,$description);
$job_all->fetch();

if($user_type == 1){
   
   $nt_message = $users['trading_name'].' has made a new offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View & Respond</a>';
   $nt_satus = 0;
   $nt_apstatus = 2;
   $nt_create = date('Y-m-d H:i:s');
   $nt_update = date('Y-m-d H:i:s');
   $job_id = $ds_job_id;	
	
  ///// Notofication
	        $action 		=	'dispute_offer';
			$action_id 		=    $job_id;
			$title 			=	'Dispute Offer';
			$message 		=	$nt_message;
			$sender_id      =   $ds_buser_id;
			$receive_id 	=	$ds_puser_id;
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'title'=>$title, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_get != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
			    if($player_id !='no'){
				$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
				}
			}
	   if (!empty($notification_arr)) {
           oneSignalNotificationSendCall($notification_arr);
       }
	
	$reciever = getUserDetails($ds_puser_id);
	
	$trading_name = ($reciever['trading_name']) ? $reciever['trading_name'] : $reciever['f_name'].''.$reciever['l_name']; 
	
           $subject = $users['trading_name']." made an offer regarding the milestone dispute for ".$title;

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$users['trading_name'].' has made a new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are willing to settle for payment of:  £'.$offer_amount.'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the offer by clicking the respond button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/dispute/' . $ds_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';	
	
$mailResponse  =  mailSend($reciever['email'], $trading_name, $subject, $contant);
	
	
} else {
	//send to trademen
	$nt_userId = $ds_buser_id;
    $nt_message = $users['f_name'].' '.$users['l_name'].' has made a new offer to settle the milestone dispute. <a href="https://www.tradespeoplehub.co.uk/dispute/'.$ds_id.'">View & Respond</a>';
   $nt_satus = 0;
   $nt_apstatus = 2;
   $nt_create = date('Y-m-d H:i:s');
   $nt_update = date('Y-m-d H:i:s');
   $job_id = $ds_job_id;
   $posted_by = $ds_puser_id;	
	
	///// Notofication
	        $action 		=	'dispute_offer';
			$action_id 		=    $job_id;
			$title 			=	'Dispute Offer';
			$message 		=	$nt_message;
			$sender_id      =   $ds_puser_id;
			$receive_id 	=	$ds_buser_id;
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'title'=>$title, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_get != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
				$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
			}
	      if (!empty($notification_arr)) {
             oneSignalNotificationSendCall($notification_arr);
          }
	
	$reciever = getUserDetails($ds_buser_id);
	$trading_name = ($reciever['trading_name']) ? $reciever['trading_name'] : $reciever['f_name'].''.$reciever['l_name']; 
	
$subject = $users['f_name'].' '.$users['l_name']." made an offer regarding the milestone dispute for ".$title;

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$users['f_name'].' '.$users['l_name'].' has made a new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are willing to settle for payment of:  £'.$offer_amount.'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the offer by clicking the respond button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="https://www.tradespeoplehub.co.uk/dispute/' . $ds_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
	
$mailResponse  =  mailSend($reciever['email'], $trading_name, $subject, $contant);
	
}


/// Email Send

   $message = 'Your offer has been submitted successfully.';
	// response here
	$record	=	array('success'=>'true', 'msg'=> $message); 
	jsonSendEncode($record);   
?>
