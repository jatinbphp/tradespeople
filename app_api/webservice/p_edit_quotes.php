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
	// Email
	if(empty($_POST['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_POST['amount'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	if(empty($_POST['time'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_POST['detail'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	
	 
 

	 
	//---------------------------get all variables--------------------------
	$user_id_post			= $_POST['user_id_post'];
	$bid_id					= $_POST['bid_id'];
	$bid_amount 			= $_POST['amount']; 
	$delivery_days 		    = $_POST['time'];
	$propose_description 	= $_POST['detail']; 
	$cdate				    = date("Y-m-d H:i:s");
    $job_id					= $_POST['job_id'];
    $quate_by				= $_POST['quate_by'];
    $posted_by              = $_POST['posted_by'];
 	$milestone_arr 		    = $_POST['milestone_arr']; 
	if($milestone_arr!='NA'){
		$milestone_arr = json_decode($milestone_arr);
	}
 
	$removed_milestone 		        = $_POST['removed_milestone']; 
	if($removed_milestone!='NA'){
		$removed_milestone = json_decode($removed_milestone);
	}

	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,f_name,trading_name from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get,$f_name,$trading_name);
 	$check_user_all->fetch();
 	  

	
	// -------------------------insert data------------------
    $update_bid = $mysqli->prepare("UPDATE `tbl_jobpost_bids` SET `bid_amount`=?, `delivery_days`=?, `propose_description`=? WHERE id=?");
	$update_bid->bind_param("sisi",$bid_amount,$delivery_days,$propose_description,$bid_id);	
	$update_bid->execute();
	$update_bid_affect_row=$mysqli->affected_rows;
	if($update_bid_affect_row<=0){
		//$record=array('success'=>'false','msg'=>$msg_error_profile_update); 
		//jsonSendEncode($record);
	}


	$milestole_status  = 0;
	$is_suggested      = 1;
	$cdate             = date('Y-m-d');
	if($milestone_arr!='NA'){
		foreach ($milestone_arr as $value) {
			if($value->id==0){
				$milestorneadd = $mysqli->prepare("INSERT INTO `tbl_milestones`(`milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`,`bid_id`,`is_suggested`) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$milestorneadd->bind_param("ssiisiiiii",$value->milestone_name,$value->milestone_amt,$quate_by,$job_id,$cdate,$milestole_status,$posted_by,$user_id_post,$bid_id,$is_suggested);	
				$milestorneadd->execute();
				$milestorneadd_affect_row=$mysqli->affected_rows;
			}else{
				$update_bid_milestone = $mysqli->prepare("UPDATE `tbl_milestones` SET `milestone_name`=?, `milestone_amount`=? WHERE id=?");
				$update_bid_milestone->bind_param("ssi",$value->milestone_name,$value->milestone_amt,$value->id);	
				$update_bid_milestone->execute();
				$update_bid_milestone_affect_row=$mysqli->affected_rows;
				if($update_bid_affect_row<=0){
					//$record=array('success'=>'false','msg'=>$msg_error_profile_update); 
					//jsonSendEncode($record);
				}
			}
		}
	}

		$job_arr = array();
		$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where   job_id=?");
		$getjobdetail->bind_param('i',$job_id);
		$getjobdetail->execute();
		$getjobdetail->store_result();
		$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
		// echo $getjobdetail_count;die();
		if($getjobdetail_count > 0){
			$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete);
			$getjobdetail->fetch();
		}
	if($removed_milestone!='NA'){
		foreach ($removed_milestone as $value) {
			$delete = $mysqli->prepare("DELETE FROM `tbl_milestones` WHERE id=?");
			$delete->bind_param("i",$value);	
			$delete->execute();
			$delete_affect_row=$mysqli->affected_rows;
			if($delete_affect_row<=0){

			}
		}
	}
	$get_post_user = getUserDetails($user_id_post);
	$get_post_other = getUserDetails($posted_by);
  
	$subject = "Your quote was updated successfully!";
			$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $f_name .',</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Your quote on the job '.$title.' was updated successfully. ' . $get_post_other['f_name'] .' will review and discuss with you. 
</p>';
	$html .= '<p style="margin:0;padding:10px 0px">We encourage you to follow up the quote by initiating a conversation with ' . $get_post_other['f_name'] .'. 
 
</p>';

	$html .='<br><div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Chat now</a></div>';
$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);

	$email_arr[]				=	array('email'=>$get_post_user['email'], 'fromName'=>$trading_name, 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($get_post_user['email'], $trading_name, $subject, $mailBody);




	$subject =    $get_post_user['trading_name']." has updated their Quote!";
			$content .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_post_other['f_name'] .',</p>';
		$content .= '<p style="margin:0;padding:10px 0px">'.$trading_name.'  has updated their quote on the job '.$title.' . 
</p>';
$content .= '<p style="margin:0;padding:10px 0px">We encourage you to review the update and  initiating a conversation with '.$trading_name.'.  </p>';
$content .='<br><div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Review quote now</a></div>';
$content .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content);

	$email_arr[]				=	array('email'=>$get_post_other['email'], 'fromName'=>$trading_name, 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($get_post_other['email'], $trading_name, $subject, $mailBody);
	 
	// $user_details	=	getUserDetails($user_id_post);
	$record			=	array('success'=>'true', 'msg'=>array('Quote updated successfully','Quote updated successfully')); 
	jsonSendEncode($record); 
?>
 