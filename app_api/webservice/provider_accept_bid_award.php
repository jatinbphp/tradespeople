<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	//echo "string";
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	// Email
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_GET['job_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	 
	//---------------------------get all variables--------------------------
	$user_id_post				= $_GET['user_id_post'];
	$job_id     				= $_GET['job_id'];
	$bid_id     				= $_GET['bid_id'];
	$status						= 7;
	$cdate						= date("Y-m-d H:i:s");
 	$tradesman_id = 0;
 	 
	//-------------------------- check user_id --------------------------

	$check_user_all	=	$mysqli->prepare("SELECT id,spend_amount,u_wallet,trading_name,email from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet,$trading_name,$email);
	$check_user_all->fetch();

	
 	//get job details======================
	$job_arr = array();
	$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete,direct_hired FROM  tbl_jobs  where  job_id=?");
	$getjobdetail->bind_param('i',$job_id);
	$getjobdetail->execute();
	$getjobdetail->store_result();
	$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
	// echo $getjobdetail_count;die();
	if($getjobdetail_count > 0){
		$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete,$direct_hired);
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
			'post_code'		=>  $post_code,
			'direct_hired'  => $direct_hired,
		);
	}
 	  

 	// ======================================
	$bid_arr = array();
	$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status FROM tbl_jobpost_bids WHERE id=? and (status = 7 or status = 3 or status = 5 or status = 10)");
	$get_bid_details->bind_param('i',$bid_id);
	$get_bid_details->execute();
	$get_bid_details->store_result();
	$get_bid_details_count=$get_bid_details->num_rows;  //0 1	
	if($get_bid_details_count > 0){
		$get_bid_details->bind_result($id,$posted_by,$bid_by,$total_milestone_amount,$bid_amount,$propose_description,$delivery_days,$bid_by,$status);
		$get_bid_details->fetch();
		$bid_arr = array(
			'id'=>$id,
			'posted_by'=>$posted_by,
			'bid_by'=>$bid_by,
			'bid_amount'=>$bid_amount,
			'bid_by'=>$bid_by,
			'bid_status'=>$status,
			'total_milestone_amount'=>$total_milestone_amount
		);
	}
	 
 	
	if($job_arr['direct_hired']==1){
		$check = false;
		$plan = false;
		$plan_arr = getPlanDetails($user_id_post);
		
		$admin_arr  =  getAdminDetails();
		$credit_amount = $admin_arr['credit_amount'];
		
		 
       if($admin_arr['payment_method']==1){
		if($plan_arr!='NA'){
			if($plan_arr['up_used_bid']<$plan_arr['up_bid'] && $plan_arr['up_status']==1 && strtotime($plan_arr['up_enddate'])>=strtotime(date('Y-m-d')) || $plan_arr['valid_type']==1){
				$check = true;
				$plan = true;	
			}else{
				$check = true;
				$plan = false;
			}
		
		}else if($u_wallet >= $credit_amount){
			$check = true;
			$plan = false;
		}
		
	} else {
		$check = true;
		$plan = false;	 
	}
		
		
		if(!$check){
			$record		=	array('success'=>'false', 'msg'=>array("You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.")); 
			jsonSendEncode($record);
		}

		if($plan){
			$up_used_bid=$plan_arr['up_used_bid']+1;
			$up_id = $plan_arr['up_id'];
			
			$update_u_plan = $mysqli->prepare("UPDATE `user_plans` SET up_used_bid=?  WHERE up_id=?");
			$update_u_plan->bind_param("si",$up_used_bid,$up_id);	
			$update_u_plan->execute();
			$update_u_plan_affect_row=$mysqli->affected_rows;
			if($update_u_plan_affect_row<=0){
				// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
				// jsonSendEncode($record);
			}
		}else{
			
		  if($admin_arr['payment_method']==1){
			$u_wallet1 =$u_wallet-$credit_amount;
			$spend_amount1  =  $spend_amount  + $credit_amount;
			$update_wallet = $mysqli->prepare("UPDATE `users` SET u_wallet=?,spend_amount=?  WHERE id=?");
			$update_wallet->bind_param("ssi",$u_wallet1,$spend_amount1,$user_id_post);	
			$update_wallet->execute();
			$update_wallet_affect_row=$mysqli->affected_rows;
			if($update_wallet_affect_row<=0){
				// $record=array('success'=>'false','msg'=>array("Unable to update wallet")); 
				// jsonSendEncode($record);
			}
		 }
          $get_posted_user = getUserDetails($job_arr['userid']);
			$transactionid = md5(rand(1000,999).time());
			// update transaction table======================
			$tr_type = 2;
			$tr_status = 1;
			$updatetime =  date("Y-m-d H:i:s");
		//	$tr_message='£'.$credit_amount.' has been debited from your wallet for accept award on <a href="'.$website_url.'proposals/?post_id='.$job_id.'">'.$job_arr['title'].'</a> on date '.date('d-m-Y h:i:s A');
			$tr_message='£'.$credit_amount.' has been debited to your wallet for responding to '.$get_posted_user['f_name'].' '.$get_posted_user['l_name'].' private job offer.';

			$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
			$transaction_add->bind_param("isiissss",$user_id_post,$credit_amount,$tr_type,$tr_status,$updatetime,$updatetime,$tr_message,$transactionid);	
			$transaction_add->execute();
			$transaction_add_affect_row=$mysqli->affected_rows;
			if($transaction_add_affect_row<=0){
				$record=array('success'=>'false','msg'=>$p_transaction_err); 
				jsonSendEncode($record);
			}
		}
	}

 
	$status	= 7;
  //-------------------------------update job bid-----------------
 	$update_plan = $mysqli->prepare("UPDATE `tbl_jobs` SET `status`=? WHERE  job_id=?");
	$update_plan->bind_param("ii",$status,$job_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}
//==============================change bid status========================
 	$update_plan = $mysqli->prepare("UPDATE `tbl_jobpost_bids` SET `status`=? WHERE  id=?");
	$update_plan->bind_param("ii",$status,$bid_id);	
	$update_plan->execute();
	$update_plan_affect_row=$mysqli->affected_rows;
	if($update_plan_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_error_update); 
		jsonSendEncode($record);
	}


//------------------update wallet--------------------------------------

	$home_arr = getUserDetails($job_arr['userid']);
	// email=============================
	if($job_arr['direct_hired']==1){
		$subjectH = "Congratulations! ".$trading_name." has accepted your direct job offer.";
				
		$htmlH .= '<p style="margin:0;padding:10px 0px">Hi '.$home_arr['f_name'].',</p>';
		
		$htmlH .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$trading_name.' has accepted your direct job offer!</p>';
		
		$htmlH .= '<p style="margin:0;padding:10px 0px">As your next step, you can create Milestone Payments if you have not yet created one.</p>';
		
		$htmlH .= '<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create a Milestone Payment</a></div><br>';
		
		$htmlH .= '<p style="margin:0;padding:10px 0px">What\'s a Milestone Payment?</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">It is our safe payment system! Using them, you break-down payments for your job. Funds do not get released until the tradesperson completes the agreed task and you choose to release them.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Additionally, in the unlikely event that something does go wrong, you can use our Dispute Resolution System to get your money back, but only if you use Milestone Payments.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Never make a payment off-site, always use Milestone Payments!<br>We cannot protect you if you make payments directly to the tradespeople.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
		


		// notification====================
		$notification_arr  = array();
	    $action 		=	'award_accept';
		$action_id 		=    $job_id;
		$title 			=	'Award accept';
		$message 		=	$trading_name.' accepted your <a>direct job offer.</a>';
		$title_push     =    'Your job offer has been accepted.Create milestone!';
		$message_push 		=	'Congratulations! '.$trading_name.' has accepted your job offer. Create milestone.';
	//	$message 		=	$trading_name .' accepted your direct job offer ';
		$sender_id      =   $user_id_post;
		$receive_id 	=	$job_arr['userid']; 
		$job_id			=   $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		
		
		$notification_arr_get_send	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		if($notification_arr_get_send != 'NA'){
					$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr_show[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
		if (!empty($notification_arr_show)) {
       oneSignalNotificationSendCall($notification_arr_show);
       }
					
				}
		}
	
	}else{
		$subjectH = "Congratulations! ".$trading_name." has accepted your offer for the job: “".$job_arr['title']."”!";
				
		$htmlH .= '<p style="margin:0;padding:10px 0px">Hi '.$home_arr['f_name'].',</p>';
		
		$htmlH .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$trading_name.' has accepted to begin work on your project “'.$job_arr['title'].'”!</p>';
			
		$htmlH .= '<p style="margin:0;padding:10px 0px">As your next step, you can create Milestone Payments if you have not yet created one.</p>';
			
		$htmlH .= '<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create a Milestone Payment</a></div><br>';
			
		$htmlH .= '<p style="margin:0;padding:10px 0px">What\'s a Milestone Payment?</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">It is our safe payment system! Using them, you break-down payments for your job. Funds do not get released until the tradesperson completes the agreed task and you choose to release them.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Additionally, in the unlikely event that something does go wrong, you can use our Dispute Resolution System to get your money back, but only if you use Milestone Payments.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Never make a payment off-site, always use Milestone Payments! We cannot protect you if you make payments directly to the tradespeople.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
		// end emai=============================
		
		// notification====================
		$notification_arr  = array();
	    $action 		=	'award_accept';
		$action_id 		=    $job_id;
		$title 			=	'Award accept';
		$title_push   =     'Your job offer has been accepted.Create milestone!';
		$message_push   =     'Your job offer has been accepted.Create milestone!';
		$message 		=	$trading_name .' has accepted your job offer.';
		$sender_id      =   $user_id_post;
		$receive_id 	=	$job_arr['userid']; 
		$job_id			=   $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		if($notification_arr_get != 'NA'){
			$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
		}
	}
  if (!empty($notification_arr)) {
       oneSignalNotificationSendCall($notification_arr);
    }
	
	$mailBody = send_mail_app($htmlH);
	$mailResponse  =  mailSend($home_arr['email'], $trading_name, $subjectH, $mailBody);
	
 
	if(empty($notification_arr)){
		$notification_arr	=	'NA';
	}
$tradesman_arr = getUserDetails($user_id_post);
$subjectP = "Job offer accepted successfully!";
				
		$htmlP = '<p style="margin:0;padding:10px 0px">Hi '.$tradesman_arr['f_name'].',</p>';
		$htmlP .= '<p style="margin:0;padding:10px 0px">Thank you for accepting to work with '.$home_arr['f_name'].' on their project '.$job_arr['title'].'</p>';

		$htmlP .= '<p style="margin:0;padding:10px 0px">As your next step, you can ask them to set up Milestone Payments if they  have not yet created one.</p>';
			
		$htmlP .= '<br><div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request Milestone Creation
</a></div><br>';
	   $htmlP .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.
</p>';

     $mailBody = send_mail_app($htmlP);
	$mailResponse  =  mailSend($tradesman_arr['email'], $trading_name, $subjectP, $mailBody);



	 	
	

	$record			=	array('success'=>'true', 'msg'=>array('Job award accepted successfully'),'notification_arr'=>'NA','mailResponse'=>$mailResponse  ); 
	jsonSendEncode($record); 
?>
 