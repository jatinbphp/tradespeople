<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_GET['job_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	if(empty($_GET['tradesman_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

  

	

	//---------------------------get all variables--------------------------
	$user_id_post				= $_GET['user_id_post'];
	$job_id     				= $_GET['job_id'];
	$bid_id     				= $_GET['bid_id'];
	$tradesman_id				= $_GET['tradesman_id'];
	$bid_by						= $tradesman_id;
	$milestone_amt				= $_GET['milestone_amt'];
	$payment_with_amount		= $_GET['payment_with_amount'];
	$status						= 4;
	$status_bid					= 3;
	$cdate						= date("Y-m-d H:i:s");
 	$updatetime					= date("Y-m-d H:i:s");
 	 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,spend_amount,u_wallet from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet);
 	$check_user_all->fetch();

   //check bid id=====================
	$where        = 'id='.$bid_id;
 	$chek_bid_id  =   getSingleData('id','tbl_jobpost_bids',$where);
 	if($chek_bid_id=='NA'){
		$record		=	array('success'=>'false', 'msg'=>$bid_id_not_found); 
		jsonSendEncode($record);
 	}
 	
 	if($payment_with_amount=='yes'){
 		if($milestone_amt>$u_wallet){
			$record		=	array('success'=>'true', 'error'=>'unable_amount','u_wallet'=>$u_wallet); 
			jsonSendEncode($record);
 		}	
 	}


 	//get job details======================
	$job_arr = array();
	$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where job_id=?");
	$getjobdetail->bind_param('i',$job_id);
	$getjobdetail->execute();
	$getjobdetail->store_result();
	$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
	// echo $getjobdetail_count;die();
	if($getjobdetail_count > 0){
			$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete);
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


  $job_status = 4;

 	$update_plan = $mysqli->prepare("UPDATE `tbl_jobs` SET `status`=?, `awarded_to`=? ,awarded_time=? WHERE  job_id=?");
	$update_plan->bind_param("iisi",$job_status,$tradesman_id,$cdate,$job_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}

	$total_milestone_amount=0;
	if($payment_with_amount=='yes'){
		$total_milestone_amount=$milestone_amt;
	}

 	$update_plan = $mysqli->prepare("UPDATE `tbl_jobpost_bids` SET total_milestone_amount=?,`status`=?, update_date=? WHERE  id=?");
	$update_plan->bind_param("sisi",$total_milestone_amount,$status_bid,$cdate,$bid_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}

 	  
 //-------------------------------update job bid-----------------
 	
	if($payment_with_amount=='yes'){
		$remaining_amount  =  $milestone_amt;
		$milestone_arr     =  getMileStone($bid_id,'all');


		if($milestone_arr=='NA'){
			$milestone_arr=array();
		}

		
		if(count($milestone_arr) > 0){
			foreach ($milestone_arr as $key => $value){

				if($remaining_amount >= $value['milestone_amt']){ 
					$key = 'created_by='.$user_id_post;
					$where = 'id='.$value['id'];
					$update_milestone1_affect_row = updatesingledata($key, 'tbl_milestones', $where);
					$remaining_amount = $remaining_amount-$value['milestone_amt'];
				} else {
					if($remaining_amount > 0){
						$cdate             = date('Y-m-d');
						$milestone_name    = 'First milestone';
						$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `posted_user`, `created_by`,`bid_id`) VALUES (?,?,?,?,?,?,?,?)");
						$milestorneadd->bind_param("ssiisiii",$milestone_name,$remaining_amount,$tradesman_id,$job_id,$cdate,$user_id_post,$user_id_post,$bid_id);	
						$milestorneadd->execute();
						$milestorneadd_affect_row=$mysqli->affected_rows;
						$remaining_amount = 0;
					}
				break;
				}
			}
			if($remaining_amount > 0){
				$cdate             = date('Y-m-d');
				$milestone_name    = 'First milestone';
				$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `posted_user`, `created_by`,`bid_id`) VALUES (?,?,?,?,?,?,?,?)");
				$milestorneadd->bind_param("ssiisiii",$milestone_name,$remaining_amount,$tradesman_id,$job_id,$cdate,$user_id_post,$user_id_post,$bid_id);	
				$milestorneadd->execute();
				$milestorneadd_affect_row=$mysqli->affected_rows;
			}
		}else {
			$cdate             = date('Y-m-d');
			$milestone_name    = 'First milestone';
			$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `posted_user`, `created_by`,`bid_id`) VALUES (?,?,?,?,?,?,?,?)");
			$milestorneadd->bind_param("ssiisiii",$milestone_name,$remaining_amount,$tradesman_id,$job_id,$cdate,$user_id_post,$user_id_post,$bid_id);	
			$milestorneadd->execute();
			$milestorneadd_affect_row=$mysqli->affected_rows;
		}

		// update transaction table======================
		$tr_type = 2;
		$tr_status = 1;
		$updatetime =  date("Y-m-d H:i:s");
		$transactionid = md5(rand(1000,999).time());

		$tr_message='£'.$milestone_amt.' has been debited from your wallet for create master the job <a href="https://www.tradespeoplehub.co.uk/proposals?post_id='.$job_id.'">'.$job_arr['title'].'</a> on date '.date('d-m-Y h:i:s A');

		$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
		$transaction_add->bind_param("isiissss",$user_id_post,$milestone_amt,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid);	
		$transaction_add->execute();
		$transaction_add_affect_row=$mysqli->affected_rows;
		if($transaction_add_affect_row<=0){
			$record=array('success'=>'false','msg'=>$p_transaction_err); 
			jsonSendEncode($record);
		}

		//update home owner wallet=================
		$spend_amount1 = $spend_amount+$milestone_amt;
		$u_wallet1 = $u_wallet-$milestone_amt;
		$signup_add = $mysqli->prepare("UPDATE `users` SET u_wallet=?,spend_amount=?  WHERE id=?");
		$signup_add->bind_param("ssi",$u_wallet1,$spend_amount1,$user_id_post);	
		$signup_add->execute();
		$signup_add_affect_row=$mysqli->affected_rows;
		if($signup_add_affect_row<=0){
			// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
			// jsonSendEncode($record);
		}
		
	}

$postData['app_name']		=	$app_name;
// $otp_message 				=	$verification_otp.' is your '.$app_name.' verification code';
// Start send mail
//$mail_content 				=	'Your job  was successfully posted on Tradespeoplehub.co.uk. You will start receiving quotes from our vetted tradespeople near you soon.';
$postData_new = getUserDetails($userid);
$otheruserDetails = getUserDetails($tradesman_id);

    $subjectM	=	'Thanks for awarding your job ' .$title. ' to  ' .$otheruserDetails['trading_name'];
    $html .= '<p style="margin:0;padding:10px 0px">Hi ' . $postData_new['f_name'] .',</p>';
$html .= '<p style="margin:0;padding:10px 0px">Thank you for awarding '.$otheruserDetails['trading_name'].' your job ' .$title.'</p>';    
$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can wait for '.$otheruserDetails['trading_name'].' to accept or reject the offer.</p>';
$html .='<br><div style="text-align:center"> 
 	<a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Chat
</a>
    </div>';
$html .= '<p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);


$email_arr[]				=	array('email'=>$postData_new['email'], 'fromName'=>$postData_new['fromName'], 'mailsubject'=>$subjectM, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($postData_new['email'],$postData_new['fromName'], $subjectM, $mailBody);
			
		
	//echo $mailBody;
if(empty($email_arr)){
	$email_arr	=	'NA';
}
if($payment_with_amount=='yes')
{

    $subjectN	=	'Congratulations! '.$postData_new['f_name'].' Awarded ' .$title. ' and  awaits your acceptance';
    $content .= '<p style="margin:0;padding:10px 0px">Hi ' . $otheruserDetails['f_name'] .',</p>';
	$content .= '<p style="margin:0;padding:10px 0px">Congratulations!  '.$postData_new['f_name']. ' has awarded you the job ' .$title. ' with milestone payment, after accepting your quote. 
</p>';
$content .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept the job by clicking the accept button below.</p>';
$content .='<br><div style="text-align:center"> 
 	<a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Accept Job Now
</a>
    </div>';
$content .= '<p style="margin:0;padding:10px 0px">If you have any question regarding the offer, dont hesitate to contact '.$otheruserDetails['f_name'].' through the chat section of the job page.</p>';
$content .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.
</p>';
$mailBody = send_mail_app($content);


$email_arr[]				=	array('email'=>$otheruserDetails['email'], 'fromName'=>$otheruserDetails['f_name'], 'mailsubject'=>$subjectN, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($otheruserDetails['email'],$otheruserDetails['f_name'], $subjectN, $mailBody);
}



	
$notification_arr = array();
		$action 		=	'Offer_job';
		$action_id 		=	 $job_id;
		$title 			=	'Offer job';
$title_push 			=	'Congratulations! You´ve got the job!';
$message_push='Congratulations!'.$postData_new['f_name'].' has offered you their job. Please accept now!';
		$message 		=	'Congratulations! '.$postData_new['f_name']. ' offered you the job. Accept now';
		$sender_id 		=	$user_id;
		$receive_id 	=	$tradesman_id;
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

$Trades_destails = getUserDetails($tradesman_id);

		$action_accept 	=	'Await_acceptance';
		$action_id 		=	 $job_id;
		$title 			=	'Await acceptance';
		$message 		=	'Your direct job offer was sent to '.$Trades_destails['f_name'].' and . <a >awaits their acceptance!</a>';
		$sender_id 		=	$user_id_post;
		$receive_id 	=	$user_id_post;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'action_id'=>$action_id, 'action'=>$action_accept);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action_accept, $action_id,$message,$title, $action_data);
		



if($payment_with_amount=='no')
{
 $subjectH	='Congratulations! '.$postData_new['f_name'].' Awarded ' .$title. ' and  awaits your acceptance';
    $contentH .= '<p style="margin:0;padding:10px 0px">Hi ' . $otheruserDetails['f_name'] .',</p>';
  $contentH .= '<p style="margin:0;padding:10px 0px">Congratulations!  '.$postData_new['f_name']. ' has awarded you their job without milestone and awaits your acceptance. 
</p>';
$contentH .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept the job by clicking the accept button below and request a milestone payment.</p>';
$contentH .='<br><div style="text-align:center"> 
  <a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Accept Job Now
</a>
    </div>';
$contentH .= '<p style="margin:0;padding:10px 0px">If you have any question regarding the offer, dont hesitate to contact '.$otheruserDetails['f_name'].' through the chat section of the job page.</p>';

$contentH .= '<p style="margin:0;padding:10px 0px">What s a  Milestone Payment? 
</p>';
$contentH .= '<p style="margin:0;padding:10px 0px">The Milestone Payment System is the recommended set of payment on our platform. Creating a milestone payment shows that your homeowner is committed and financially capable of completing the project. 

</p>';


$contentH .='<br><div style="text-align:center"> 
  <a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none">Request Milestone Payment

</a>
    </div>';

$contentH .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.
</p>';
$mailBody = send_mail_app($contentH);
$email_arr[]        = array('email'=>$otheruserDetails['email'], 'fromName'=>$otheruserDetails['f_name'], 'mailsubject'=>$subjectH, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($otheruserDetails['email'],$otheruserDetails['f_name'], $subjectH, $mailBody);
}
 
	 
$record	=	array('success'=>'true', 'msg'=>$job_awarded,'notification_arr'=>$notification_arr,  ); 
	jsonSendEncode($record); 
?>
