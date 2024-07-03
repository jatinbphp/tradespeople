<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	// Email
	if(empty($_GET['user_id_post'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	if(empty($_GET['bid_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	
	 	//---------------------------get all variables--------------------------
	$user_id_post			= $_GET['user_id_post'];
	$bid_id					= $_GET['bid_id'];
    $otheruserid= $_GET['otheruserid'];
   $title= $_GET['title'];
 
 	 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,f_name,email from users where id=?");
	$check_user_all->bind_param("i",$user_id_post);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get,$name,$email);
 	$check_user_all->fetch();
 	  
	$where        = 'id='.$bid_id;
	$chek_bid_id  =   getSingleData('id','tbl_jobpost_bids',$where);
	if($chek_bid_id=='NA'){
		$record		=	array('success'=>'false', 'msg'=>$bid_id_not_found); 
		jsonSendEncode($record);
	}
	
	// -------------------------insert data------------------
    $update_bid = $mysqli->prepare("DELETE FROM `tbl_jobpost_bids` WHERE `id`=?");
	$update_bid->bind_param("i",$bid_id);	
	$update_bid->execute();
	$update_bid_affect_row=$mysqli->affected_rows;
	if($update_bid_affect_row<=0){
		$record=array('success'=>'false','msg'=>$msg_jobbid_notdlt); 
		jsonSendEncode($record);
	}
	 
	 $delete = $mysqli->prepare("DELETE FROM `tbl_milestones` WHERE id=?");
	$delete->bind_param("i",$bid_id);	
	$delete->execute();
	$delete_affect_row=$mysqli->affected_rows;
	if($delete_affect_row<=0){

	}

	 $user_details	=	getUserDetails($otheruserid);
		$quate_added_status="no";

	 $owner	=	getUserDetails($user_id_post);

		$subject = "The quote on the job ".$title." has been retracted";
		$html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_details['f_name'].',</p>';
		$html .= '<p style="margin:0;padding-bottom:5px">The quote on your job by'. $owner['trading_name'].' has been retracted.</p>';
		$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can wait for more quotes or edit your job post to attract more tradespeople.</p>';
		$html .= '<div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit job</a></div>';
    	$html .= '<p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.
</p>';
	$mailBody = send_mail_app($html);
	$mailResponse  =  mailSend($user_details['email'], $user_details['f_name'], $subject, $mailBody);


$subjecth = "Your quote was withdrawn successfully!";
	$htmlh .= '<p style="margin:0;padding:10px 0px">Hi '.$name.',</p>';
		$htmlh .= '<p style="margin:0;padding-bottom:5px">Your quote on the job '.$title.' was withdrawn successfully. We encourage you to resubmit your quote. </p>';
		
		$htmlh .= '<div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Send new quote</a></div>';
    	$htmlh .= '<p style="margin:0;padding:10px 0px">Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service
</p>';
	$mailBody = send_mail_app($htmlh);
	$mailResponse  =  mailSend($email, $name, $subjecth, $mailBody);




	$record			=	array('success'=>'true', 'msg'=>$bid_not_delt,'quate_added_status'=>$quate_added_status ); 
	jsonSendEncode($record); 
?>
 