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
	if(empty($_GET['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	 
	//---------------------------get all variables--------------------------
	$user_id			=	 $_GET['user_id'];
	$job_id     		=	 $_GET['job_id'];
	$review_email     	=	 $_GET['review_email'];
	$review_id     		=	 $_GET['review_id'];
	$f_name     		=	 $_GET['f_name'];	
	$l_name     		=	 $_GET['l_name'];	
	$cdate				=	 date("Y-m-d H:i:s");
 	 
	//-------------------------- check user_id --------------------------
   $check_user_all	=	$mysqli->prepare("SELECT id,spend_amount,u_wallet,trading_name,f_name,l_name from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$spend_amount,$u_wallet,$trading_name,$s_f_name,$s_l_name);
	$check_user_all->fetch();

	
 	$job_arr = array();
	$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,awarded_time FROM  tbl_jobs  where  job_id=?");
	$getjobdetail->bind_param('i',$job_id);
	$getjobdetail->execute();
	$getjobdetail->store_result();
	$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
	// echo $getjobdetail_count;die();
	if($getjobdetail_count > 0){
		$getjobdetail->bind_result($id,$project_id,$title,$awarded_time);
		$getjobdetail->fetch();
		$job_arr = array(
			'job_id'		=>  $id, 
			'project_id'    =>  $project_id, 
			'title'  		=>	$title, 
			'awarded_time'  =>  $awarded_time
		);
	}

	$today = date('Y-m-d');
	$check_date = date('Y-m-d',strtotime($today.' - 3 day'));


	if($getjobdetail_count>0){
		$awarded_time = date('Y-m-d',strtotime($job['awarded_time']));
		if(strtotime($check_date) <= strtotime($awarded_time)){
			$record		=	array('success'=>'false', 'msg'=>array('You can´t send the invitation until after 3 days of job acceptance')); 
			jsonSendEncode($record);
		}
	}

 

	$reciever_id=0;
 	$check_u_by_email	=	$mysqli->prepare("SELECT id,f_name,l_name from users where email=?");
 	$check_u_by_email->bind_param("s",$review_email);
 	$check_u_by_email->execute();
 	$check_u_by_email->store_result();
 	$check_u_by_email_count		=	$check_u_by_email->num_rows;  //0 1
 	if($check_u_by_email_count > 0){
 		$check_u_by_email->bind_result($reciever_id,$r_f_name,$r_l_name);
 		$check_u_by_email->fetch(); 
 	}
 	

	// insert_review=============
	

	$status = 0;
	$update_date = date('Y-m-d H:i:s');

	$transaction_add = $mysqli->prepare("INSERT INTO `review_invitation`(`invite_by`, `invite_to`, `email`, `job_id`, `status`, `create_date`,update_date) VALUES (?,?,?,?,?,?,?)");
	$transaction_add->bind_param("sssssss",$user_id,$reciever_id,$review_email,$job_id,$status,$update_date,$update_date);	
	$transaction_add->execute();
	$transaction_add_affect_row=$mysqli->affected_rows;
	if($transaction_add_affect_row<=0){
		$record=array('success'=>'false','msg'=>array("Something went wrong, please try again later")); 
		jsonSendEncode($record);
	}
 	$last_review_id = $mysqli->insert_id;
	 

	$link = $website_url.'review-invitation/?invite_by='.$user_id.'&is_invited='.$last_review_id;
	 	
	$subject = "Provide feedback for ".$trading_name;

	$html = '<p style="margin:0;padding:10px 0px">Hi '.$f_name.' '.$l_name.'!</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Congratulations on completing your job with '.$trading_name.'. Please leave feedback for them to help other TradespeopleHub members know what it was like to work with them.</p>';
	$html .= '<br><div style="text-align:center"><a href="'.$link.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div><br>';
	$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

	$mailBody = send_mail_app($html);
	$mailResponse  =  mailSend($review_email, $trading_name, $subject, $mailBody);

	$record			=	array('success'=>'true', 'msg'=>array('Job award accepted successfully'),'notification_arr'=>$notification_arr,'mailResponse'=>$mailResponse  ); 
	jsonSendEncode($record); 
?>
 