<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
	include 'mailFunctions.php';
if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_post_method); 
	jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_POST['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$user_id	     	=	$_POST['user_id'];
$other_id     	    =	$_POST['other_id'];
$user_id_mail	    =	$_POST['user_id'];
$job_id			 	=	$_POST['job_id'];
$bid_id			 	=	$_POST['bid_id'];
$milestone_id_arr	=	$_POST['milestone_ids'];
$dispute_reason 	=   $_POST['dispute_reason'];
$dispute_reason     = '<p>'.$dispute_reason.'</p>';
$reason2            =  $_POST['reason2'];     
$offer_amount        = $_POST['offer_amount'];

 

$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,type,email from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$type_new,$emailSelf);
$check_user_all->fetch();


//bid======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status,paid_total_miles FROM tbl_jobpost_bids WHERE  id= ? and (status = 7 or status = 3 or status = 5 or status = 10)");
$get_bid_details->bind_param('i',$bid_id);
$get_bid_details->execute();
$get_bid_details->store_result();
$get_bid_details_count=$get_bid_details->num_rows;  //0 1	
if($get_bid_details_count > 0){
	$get_bid_details->bind_result($id,$posted_by,$bid_by,$total_milestone_amount,$bid_amount,$propose_description,$delivery_days,$bid_by,$status,$paid_total_miles);
	$get_bid_details->fetch();
	$bid_arr = array(
		'id'=>$id,
		'posted_by'=>$posted_by,
		'bid_by'=>$bid_by,
		'bid_amount'=>$bid_amount,
		'bid_by'=>$bid_by,
		'total_milestone_amount'=>$total_milestone_amount,
		'bid_status'=>$status,
		'paid_total_miles'=>$paid_total_miles,
	);
}

//get job details======================
$job_arr = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete,awarded_to FROM  tbl_jobs  where job_id=?");
$getjobdetail->bind_param('i',$job_id);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
// echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
	$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete,$awarded_to);
	$getjobdetail->fetch();
	$job_arr = array(
		'job_id'		=>  $id, 
		'project_id'    =>  $project_id, 
		'title'  		=>	$title, 
		'budget'  		=>	$budget, 
		'budget2'  		=>	$budget2, 
		'category'		=>	$category, 
		'description'	=>	$description, 
		'userid'		=>	$userid, 
		'status'		=>	$status,
		'post_code'		=>  $post_code		
	);
}
$total_mile_amount=0;
$milestonearr = explode(',', $milestone_id_arr);
foreach($milestonearr as $mid) {
	$getmile = getMileStoneById($mid);
	$total_mile_amount += $getmile['milestone_amt'];
}	
if($total_mile_amount < $offer_amount){
   $record = array('success'=>'false', 'msg'=>'Offer Amount must be equal to £'.$total_mile_amount.' or less'); 
   jsonSendEncode($record);
}



$dispute_to = ($user_id == $userid) ? $awarded_to : $userid;
$cdate = date('Y-m-d H:i:s');
$ds_job_id = $job_id;
$ds_buser_id = $awarded_to;
$ds_puser_id = $userid;
$caseid = time();
$ds_status = 0;
if ($type_new == 1) {
	$tradesmen_offer = $offer_amount;
	$sql_offer_col = 'tradesmen_offer';
  } else {
	$homeowner_offer = $offer_amount;
	$sql_offer_col = 'homeowner_offer';
}
/// milestone dispute 
$disput_milestone = $mysqli->prepare("INSERT INTO tbl_dispute(ds_in_id,ds_job_id,ds_buser_id,ds_puser_id,caseid,ds_status,mile_id,disputed_by,dispute_to,ds_comment,reason2,$sql_offer_col,ds_create_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$disput_milestone->bind_param("sssssssssssss",$user_id,$ds_job_id,$ds_buser_id,$ds_puser_id,$caseid,$ds_status,$m_id,$user_id,$dispute_to,$dispute_reason,$reason2,$offer_amount,$cdate);	
$disput_milestone->execute();
$disput_milestone_affect_row=$mysqli->affected_rows;
$run = $mysqli->insert_id;
 
$milestone_id_arr = explode(',', $milestone_id_arr);
$notification_arr  = array();
$total_amount = 0;
foreach($milestone_id_arr as $m_id) {
	
	$milestone_get = getMileStoneById($m_id);
	
	//if($milestone_get['milestone_amt'] < $offer_amount){
	//	$record		=	array('success'=>'false', 'msg'=>'Offer Amount must be equal to £'.$milestone_get['milestone_amt'].' or less'); 
//	    jsonSendEncode($record);
//	}
	
	if($milestone_get!='NA'){
		
        $total_amount += $milestone_get['milestone_amt'];
		
	  // add dispute file
			 $uploaded_by = $user_id;
			 $dispute_id  = $run;
			 $created_at    = date('Y-m-d H:i:s');
			 $updated_at    = date('Y-m-d H:i:s');
			if (!empty($_FILES['files']['name'])) {
				foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
					$newName = explode('.', $_FILES['files']['name'][$key]);
					$size = $_FILES['files']['size'][$key];
					$file_tmp = $_FILES['files']['tmp_name'][$key];
					$file_name = $_FILES['files']['name'][$key];
					$ext = end($newName);
					$file_str = rand() . time() . '.' . $ext;
					$fileName = 'img/dispute/' . $file_str;
					$api_path = '../../img/dispute/' . $file_str;
					if (move_uploaded_file($file_tmp, $api_path)) {
					   $original_name = $file_name;
		$disput_file = $mysqli->prepare("INSERT INTO dispute_file(uploaded_by,dispute_id,file,original_name,created_at,updated_at) VALUES (?,?,?,?,?,?)");
$disput_file->bind_param("ssssss",$uploaded_by,$dispute_id,$fileName,$original_name,$created_at,$updated_at);	
$disput_file->execute();
$insert_affected_rows = $mysqli->affected_rows;
if($insert_affected_rows <= 0){
	$record		=	array('success'=>'false', 'msg'=>'file not uploaded'); 
	jsonSendEncode($record);
}					
					
					}
				}			
			}
			
 /////////////// End file upload
$update5 = $mysqli->prepare('UPDATE `tbl_dispute` SET `total_amount`=? WHERE ds_id=?');
$update5->bind_param('ii',$total_amount,$run);
$update5->execute();
		
		
/// Dispute Milestone
$insrt_dis = $mysqli->prepare("INSERT INTO dispute_milestones(dispute_id,milestone_id,created_at,updated_at) VALUES (?,?,?,?)");
$insrt_dis->bind_param("ssss",$run,$m_id,$created_at,$updated_at);	
$insrt_dis->execute();
		
		
		// if($userid==$milestone_get['posted_user']) {} else {}  for notification============
		$mil_status=5;
		$update3     =   $mysqli->prepare('UPDATE `tbl_milestones` SET `status`=?, `dispute_id`=? WHERE id=?');
		$update3->bind_param('iii',$mil_status,$dispute_id,$m_id);
		$update3->execute();
		$update3_affect_row=$mysqli->affected_rows;

		if($user_id == $milestone_get['posted_user']){
			
$login_user = getUserDetails($milestone_get['posted_user']);
			if($login_user['type']==1)
			{
				$show_name=$login_user['trading_name'];
			}
			else{
			$show_name=$login_user['f_name'].' '.$login_user['l_name'];
			}
			
			// notification====================
			
		    $action 		=	'milestone_dispute';
			$action_id 		=    $job_id;
			$title_push     =    'A milestone dispute has been opened: Respond now.';
			$message_push   =    $show_name.' has opened a dispute against your milestone payment. Please respond now!';
			$title 			=	'Dispute milestone';
			$message 		=	$show_name.' opened a milestone payment dispute. <a>View & respond!</a>';
			$sender_id      =   $user_id;
			$receive_id 	=	$milestone_get['userid']; 
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_get != 'NA'){
			$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
			}
			if (!empty($notification_arr)) {
              oneSignalNotificationSendCall($notification_arr);
             }
			
		}else{
			$login_user = getUserDetails($milestone_get['userid']);
			
			if($login_user['type']==1)
			{
				$show_name=$login_user['trading_name'];
			}
			else{
			$show_name=$login_user['f_name'].' '.$login_user['l_name'];
			}
			// notification====================
		    $action 		=	'milestone_dispute';
			$action_id 		=    $job_id;
			$title 			=	'Dispute milestone';
			$title_push     =    'Milestone dispute opened against you!';
			$message_push   =    $show_name.' has opened a milestone payment dispute against you.Respond now!';
			$message 		=	$show_name.' opened a milestone payment dispute. <a>View & respond!</a>';
			$sender_id      =   $user_id;
			$receive_id 	=	$milestone_get['posted_user']; 
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_get != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
			}
			if (!empty($notification_arr)) {
                oneSignalNotificationSendCall($notification_arr);
            }
			 
		}


		
		    $action 		=	'milestone_dispute';
			$action_id 		=    $job_id;
	    	$title 			=	'Dispute milestone';
			$message 		=	'Your milestone payment dispute was opened successfully View dispute!';
			$sender_id      =   $user_id;
			$receive_id 	=	$milestone_get['posted_user'];
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
			$notification_arr_self	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
			if($notification_arr_self != 'NA'){
				$player_id 			=	getUserPlayerId($receive_id);
			   if($player_id !='no'){
		      $notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
			  }
			}
		
		
		if (!empty($notification_arr)) {
                oneSignalNotificationSendCall($notification_arr);
            }
		
		$posted_users  =	getUserDetails($milestone_get['posted_user']);
		$bid_users     = 	getUserDetails($milestone_get['userid']);
		if($user_id == $milestone_get['posted_user']){
			$to_mail= $bid_users['email'];
			$to_name= $bid_users['f_name'];	
			$type= $bid_users['type'];	
			$by_name= $posted_users['f_name'].' '.$posted_users['l_name'];
			$trading_name = $bid_users['trading_name'];
		}else{
			$to_mail= $posted_users['email'];	
			$to_name= $posted_users['f_name'];
			$type= $posted_users['type'];
			$by_name= $bid_users['f_name'].' '.$bid_users['l_name'];
			$trading_name = $bid_users['trading_name'];
		}

		$admin_arr = getAdminDetails();
		$today     = date('Y-m-d H:i:s');
		$newTime   = date('Y-m-d H:i:s',strtotime($today.' +'.$admin_arr['waiting_time'].' days'));

		$get_user=getUserDetails($user_id_mail);
		$other_details  =	getUserDetails($other_id);
	if($type_new==2)
	{
			$subjectH = "Action required: Milestone Payment is being Disputed, Job “" .$job_arr['title']."”"; 
			$contantH .= '<p style="margin:0;padding:10px 0px">Your Milestone Payment is being Disputed and required your response!
</p>';
			$contantH .= '<br><p style="margin:0;padding:10px 0px">Hi ' .$to_name .',</p>';
			$contantH .= '<br><p style="margin:0;padding:10px 0px"> ' .$get_user['f_name'] .' is disputing their Milestone payment for job “' .$job_arr['title'] .'”</p>';
			$contantH .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' .$milestone_get['milestone_amt'] .'</p>';
			
			$contantH .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with the '.$get_user['f_name'] .'. If you can\'t solve this problem, you or  '  .$get_user['f_name'] .' can ask us to step in.</p>';
			
			$contantH .= '<br><div style="text-align:center"><a href="' .$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';
			
			$contantH .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in the client favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p>';
			
			$contantH .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contantH);
		//end email temlete================
	$mailResponse  =  mailSend($to_mail,$other_details['name'], $subjectH, $mailBody);
	}
	if($type_new==1)
	{
		$subject = "Action required: Your Milestone Payment is being Disputed: “" .$job_arr['title']."”"; 
		$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' .$other_details['name'] .',</p>';
		$contant .= '<br><p style="margin:0;padding:10px 0px"> ' .$trading_name .' is disputing your Milestone payment to them & need your response.</p>';
			
			$contant .= '<p style="margin:0;padding:0px 0px">Job title: ' .$job_arr['title'] .'</p>';
			$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £' .$milestone_get['milestone_amt'] .'</p>';
			
			$contant .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with ' .$trading_name .'. If you can\'t solve it, you or  '.$trading_name.' can ask us to step in.</p>';
			
			$contant .= '<br><div style="text-align:center"><a href="' .$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';
			
			$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in '.$trading_name.' favour.  Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';
			
			$contant .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
			$mailBody = send_mail_app($contant);
	     	$mailResponse  =  mailSend($other_details['email'],$other_details['name'], $subject, $mailBody);
		}
	
	}
	

	
}
$Self_user_details  =	getUserDetails($user_id_get);
if($Self_user_details['type']==2)
{
$subjectSelf = "Your milestone payment dispute has been opened : “" .$job_arr['title']."”"; 	$contantSelf .= '<br><p style="margin:0;padding:10px 0px">Hi ' .$Self_user_details['f_name'] .',</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px">Your milestone payment dispute against '.$trading_name.' has been opened successfully and awaits their response.</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Milestone name: ' .$milestone_get['milestone_name'] .'</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$milestone_get['milestone_amt'] .'</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">We encourage '.$trading_name.' to respond and resolve this issue with you amicably. If you can not solve it, you or  '.$trading_name.' can ask us to step in.</p>';
$contantSelf .= '<br><div style="text-align:center"><a href="' .$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View dispute</a></div><br>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Please note: '.$trading_name.'  not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in your favour. </p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px">If you receive a reply from '.$trading_name.', please respond as soon as you can as not responding within 2 days closes the case automatically and decides in favour of '.$trading_name.'.</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px"> Any decision reached is final and irrevocable. Once a case is closed, it can not reopen.</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px"> Visit our Milestone Payment system on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contantSelf);
		//end email temlete================
$mailResponse  =  mailSend($Self_user_details['email'], $Self_user_details['f_name'], $subjectSelf, $mailBody);
		
}


if($Self_user_details['type']==1)
{
$subjectSelf = "Your milestone payment dispute has been opened : “" .$job_arr['title']."”"; 	$contantSelf .= '<br><p style="margin:0;padding:10px 0px">Hi ' .$Self_user_details['f_name'] .',</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px">Your milestone payment dispute against '.$other_details['name'].' has been opened successfully and awaits their response.</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Milestone name: ' .$milestone_get['milestone_name'] .'</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £'.$milestone_get['milestone_amt'] .'</p>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">We encourage '.$other_details['name'].' to respond and resolve this issue with you amicably. If you can not solve it, you or  '.$other_details['name'].' can ask us to step in.</p>';
$contantSelf .= '<br><div style="text-align:center"><a href="' .$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View dispute</a></div><br>';
$contantSelf .= '<p style="margin:0;padding:10px 0px">Please note: '.$other_details['name'].'  not responding within ' .date("d-M-Y H:i:s", strtotime($newTime)) .' will result in closing this case and deciding in your favour. </p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px">If you receive a reply from '.$get_user['f_name'].', please respond as soon as you can as not responding within 2 days closes the case automatically and decides in favour of '.$other_details['name'] .'.</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px"> Any decision reached is final and irrevocable. Once a case is closed, it can not reopen.</p>';
$contantSelf .= '<br><p style="margin:0;padding:10px 0px"> Visit our Milestone Payment system on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($contantSelf);
		//end email temlete================
$mailResponse  =  mailSend($Self_user_details['email'], $Self_user_details['f_name'], $subjectSelf, $mailBody);
		
}

if(empty($notification_arr)){
	$notification_arr	=	'NA';
}

$record=array('success'=>'true','msg'=>array('Success! Milestone Disputed successfully.'),'notification_arr'=>'NA'); 
jsonSendEncode($record);
