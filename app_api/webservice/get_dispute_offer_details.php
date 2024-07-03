<?php	
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}
if(empty($_GET['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_GET['dispute_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id            = $_GET['user_id'];
$dispute_id            = $_GET['dispute_id'];
$wd_arr 			=   array();

 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT ds_id,ds_comment,ds_create_date,total_amount,dispute_to,ds_status,disputed_by,ds_buser_id,ds_puser_id,caseid,tradesmen_offer,offer_rejected_by_homeowner,offer_rejected_by_tradesmen,ds_job_id,homeowner_offer,reason2,caseCloseStatus,last_offer_by,agreed_amount FROM tbl_dispute where ds_id=? ORDER BY ds_id DESC");
$tran_get->bind_param("i",$dispute_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($ds_id,$ds_comment,$ds_create_date,$total_amount,$dispute_to,$ds_status,$disputed_by,$ds_buser_id,$ds_puser_id,$caseid,$tradesmen_offer,$offer_rejected_by_homeowner,$offer_rejected_by_tradesmen,$ds_job_id,$homeowner_offer,$reason2,$caseCloseStatus,$last_offer_by,$user_agreed_amount);
	while ($tran_get->fetch()) {
		if(!empty($ds_id))
		{
			
		// Get Time Details
$check_user_all	=	$mysqli->prepare("SELECT dct_disputid,dct_userid,dct_created from disput_conversation_tbl where dct_disputid=? AND dct_userid=? ORDER BY dct_id ASC");
$check_user_all->bind_param("ii",$ds_id,$dispute_to);
$check_user_all->execute();
$check_user_all->store_result();
$check_user_all->bind_result($dct_disputid,$dct_userid,$dct_created);
$check_user_all->fetch();
			
// Settings
$admin_id=1;		
$settings_q	= $mysqli->prepare("SELECT id,step_in_day,waiting_time from admin where id=?");
$settings_q->bind_param("i",$admin_id);
$settings_q->execute();
$settings_q->store_result();
$settings_q->bind_result($id,$step_in_day,$waiting_time);
$settings_q->fetch();	
			
$tradmen = getUserDetails($ds_buser_id);	
$owner = getUserDetails($ds_puser_id);		
			
$Claimant = getUserDetails($disputed_by);
			
$showStepIn = false;
$home_stepin = false;
$trades_stepin = false;		
			
if($owner!='NA'){
  $home_stepin = ask_admin_data($owner['id'],$ds_id);
  $home_stepin = ($home_stepin=='NA') ? false : $home_stepin;	
}
if($tradmen!='NA'){
 $trades_stepin = ask_admin_data($tradmen['id'],$ds_id);
 $trades_stepin = ($trades_stepin=='NA') ? false : $trades_stepin;		
}
 	
$new = date('Y-m-d H:i:s');	
$showStepIn = false;		
if($dct_created) {			
$stepINTime = date('Y-m-d H:i:s', strtotime($dct_created . ' +' . $step_in_day . ' days'));	
if (strtotime($stepINTime) > strtotime($new)) {
		$diff = date_difference($new, $stepINTime);
	   
	    $timeString = '';
		if ($diff['days'] > 0) {
			$timeString .= $diff['days'] > 1 ? $diff['days'] . ' days ' : $diff['days'] . ' day ';
		} else if ($diff['hours'] > 0) {
			$timeString .= $diff['hours'] > 1 ? $diff['hours'] . ' hours ' : $diff['hours'] . ' hour ';
			$timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
		} else if ($diff['minutes'] > 0) {
			$timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
		}

		if ($timeString) {
			$remaining_time = $timeString;
			$showStepIn = $timeString . 'left to ask team to step in';
		} else {
			$remaining_time = $timeString;
			$showStepIn = (strtotime($stepINTime) - strtotime($new)) . ' Seconds left to ask team to step in';
		}
	}	
}	
if ($ds_status == '0') {			
if (!$dct_created) {
$newTime = date('Y-m-d H:i:s', strtotime($ds_create_date . ' +' . $waiting_time . ' days'));
$diff = date_difference($new, $newTime);
$remaining_time = $diff['days'].' days '.$diff['hours'].' hours';
$username = ($disputed_by == $tradmen['id']) ? $owner['f_name'] . ' ' . $owner['l_name'] : $tradmen['trading_name'];	
$remain_msg = 'left ' . $username .' to respond';
} else if ($showStepIn) {
  $remaining_time = $remaining_time;	
  $remain_msg =	$showStepIn;
} else if ($home_stepin && $trades_stepin) {
	
} else if ($home_stepin) {
  $newTime = $home_stepin['expire_time'];
  $diff = date_difference($new, $newTime);
  $remaining_time = $diff['days'].' days '.$diff['hours'].' hours';
  $username = ($tradmen['id'] == $user_id) ? 'you' : $tradmen['trading_name'];	
	$remain_msg = 'left for ' . $username .' to pay arbitration fee';	
	
} else if ($trades_stepin) { 
$newTime = $trades_stepin['expire_time'];
$diff = date_difference($new, $newTime);	
$remaining_time = $diff['days'].' days '.$diff['hours'].' hours';
$username = ($owner['id'] == $user_id) ? 'you' : $owner['f_name'] . ' ' . $owner['l_name'] ;	
$remain_msg = 'left for' . $username .'to pay arbitration fee';		
	
 } else {
	 $remaining_time = '0 days 0 hours';
	 $remain_msg = '0 days 0 hours left to ask team to step in.';
}
}
 			
			
	    
		$case_status = ($ds_status==0) ? 'Open' : 'Close';	
		$tradesmenoffer = ($tradesmen_offer) ? $tradesmen_offer : "You've not made an offer yet";
		if ($ds_status == '0') {
			if ($tradesmen_offer && $offer_rejected_by_homeowner == 0) {
				$homeowner_response= 'Awaiting homeowner response';
			} else if ($tradesmen_offer && $offer_rejected_by_homeowner == 2) {
				$homeowner_response= 'Homeowner rejected your offer';
			}
			}
			
	if ($owner['id'] == $user_id) {
		
		// Left Box 
		
		$dispute_left_text ='Homeowner (you) wants to pay';
		if ($homeowner_offer) {
	      $left_offer_amount = '£ '.$homeowner_offer;	
	   } else {
		  $left_offer_amount = "You've not made an offer yet";
	   }
		
		if ($ds_status == '0') {
			if ($homeowner_offer && $offer_rejected_by_tradesmen == 0) {
				$left_dispute_response = 'Awaiting tradesman response';
			} else if ($homeowner_offer && $offer_rejected_by_tradesmen == 2) {
				$left_dispute_response = 'Tradesman rejected your offer';
			}
		}
		
		// Right Box 
		
		$dispute_right_text ='Tradesman ( '. $tradmen['trading_name'] .') want to receive:';
		if ($tradesmen_offer) {
			$right_box_offer = '£ '.$tradesmen_offer;
		} else {
			$right_box_offer = $tradmen['trading_name'] .' has not made an offer yet';
		}
		
		if ($ds_status == '0') {
			if ($tradesmen_offer && $offer_rejected_by_homeowner == 0) {
				$action_accept='Accept';
				$accept_btn = 'Accept and close';
				if($dct_created){
				  $action_reject='Reject';
			    } else {
				  $action_reject='Reject';
			   }
			} else if ($tradesmen_offer && $offer_rejected_by_homeowner == 2) {
				$accept_btn='You rejected tradesman offer';
			}
		}	
		
		
	  } else {	
	
	   $dispute_left_text = 'Tradesman (you) want to receive:';		
	    if ($tradesmen_offer) {
	      $left_offer_amount = '£ '.$tradesmen_offer;	
	   } else {
		  $left_offer_amount = "You've not made an offer yet";
	   }
		
		if ($ds_status == '0') {
			if ($tradesmen_offer && $offer_rejected_by_homeowner == 0) {
				$left_dispute_response = 'Awaiting homeowner response';
			} else if ($tradesmen_offer && $offer_rejected_by_homeowner == 2) {
				$left_dispute_response = 'Homeowner rejected your offer';
			}
		}
		
		// Right Box 
		
		$dispute_right_text ='Homeowner ( '. $owner['f_name'] . ' ' . $owner['l_name'] .') wants to pay:';
		if ($homeowner_offer) {
			$right_box_offer = '£ '.$homeowner_offer;
		} else {
			$right_box_offer = $owner['f_name'] . ' ' . $owner['l_name'] .' has not made an offer yet';
		}
		
		if ($ds_status == '0') {
			if ($homeowner_offer && $offer_rejected_by_tradesmen == 0) {
				$action_accept='Accept';
				$accept_btn = 'Accept and close';
				if($dct_created){
				  $action_reject='Reject';
			    } else {
				  $action_reject='Reject';
			   }
			} else if ($homeowner_offer && $offer_rejected_by_tradesmen == 2) {
				$accept_btn='You rejected tradesman offer';
			}
		}
		
	  }
	$submit_offer_txt =	($tradmen['id'] == $user_id) ? 'Make offer you wish to receive' : 'Make a new offer you wish to pay';	
			
	if (!$dct_created && $dispute['dispute_to'] == $user_id) {
		$submit_button_status='Disabled';
		$submit_error_msg = 'Please reply before submitting offer';
	} else {
		$submit_button_status='Submit';
		$submit_error_msg='';
	}
			
	// Min Amount 
	$minAmount = 0;
	$maxAmount = $total_amount;
	if ($owner['id'] == $user_id && $homeowner_offer) {
		$minAmount = $homeowner_offer;
	} else if ($tradmen['id'] == $user_id && $tradesmen_offer) {
		$maxAmount = $tradesmen_offer;
	}
			
	$buttom_text = 'Enter an amount between £ '.$minAmount.' and £'.$maxAmount.' GBP';	
			
	if ($ds_status == '0') {
		$agreed_amount = '0.00';
	} else {
	//  $agreed_amount =	($caseCloseStatus == 5) ? (($last_offer_by==$tradmen['id']) ? $tradesmen_offer : $homeowner_offer) : '0.00';
		$agreed_amount = ($caseCloseStatus == 5) ? $user_agreed_amount : '0.00';
		
	if ($caseCloseStatus == 1) {
        $case_close_status = "Resolved, Not Responded";
	 } else if ($caseCloseStatus == 2) {
       $case_close_status = "Resolved, Cancelled";
	} else if ($caseCloseStatus == 3) {
      $case_close_status = "Resolved, Arbitration Fees Not Paid";
	} else if ($caseCloseStatus== 4) {
      $case_close_status ="Resolved By Dispute Team";
	} else if ($caseCloseStatus == 5) {
      $case_close_status = "Resolved, Offer Accepted";
	} else {
		$case_close_status = "Resolved, Dispute Closed";
	}	
		
	}
	$cancel_button = ($ds_status==0) ? 'visible' : 'imvisible';			
	$agreed_txt ='Agreed: £ '.$agreed_amount;		
	$total_disputed_amount='Total amount disputed: £'.$total_amount; 

		 $transaction_arr[] = array(
			'id'=>$ds_id,
			 'case_id'=>$caseid,
			 'ds_status'=>$case_status,
			 'remaining_time'=>$remaining_time,
			 'remain_msg'=>$remain_msg,
			 'total_disputed_amount'=>$total_disputed_amount,
			 'dispute_left_text'=>$dispute_left_text,
			 'left_dispute_response'=>$left_dispute_response,
			 'left_offer_amount'=>$left_offer_amount,
			 'dispute_right_text'=>$dispute_right_text,
			 'right_box_offer'=>$right_box_offer,
			 'homeowner_offer'=>$homeowneroffer,
			 'ds_job_id'=>$ds_job_id,
			 'action_accept'=>$action_accept,
			 'accept_btn'=>$accept_btn,
			 'action_reject'=>$action_reject,
			 'submit_offer_txt'=>$submit_offer_txt,
			 'submit_button_status'=>$submit_button_status,
			 'submit_error_msg'=>$submit_error_msg,
			 'minAmount'=>$minAmount,
			 'maxAmount'=>$maxAmount,
			 'buttom_text'=>$buttom_text,
			 'agreed_txt'=>$agreed_txt,
			 'case_close_status'=>$case_close_status,
			 'cancel_button'=>$cancel_button,
			);
		}
	}
}

$file_arr = array();
$file_all	=	$mysqli->prepare("SELECT original_name,file from dispute_file where dispute_id=? and conversation_id is null ORDER BY id DESC");
$file_all->bind_param("i",$dispute_id);
$file_all->execute();
$file_all->store_result();
$file_all->bind_result($original_name,$file);
while ($file_all->fetch()) {
	$file_arr[] = array(
		   'original_name'=>$original_name,
		   'file'=>'https://www.tradespeoplehub.co.uk/'.$file,
		   );
}

$Claimant_arr = array();
if (!$Claimant['profile']) {
	$profile = $Claimant['profile'];
} else {
	$profile = "dummy_profile.jpg";
}
$Claimant_name = ($Claimant['type'] == 2) ? $Claimant['f_name'] . ' ' . $Claimant['l_name'] : $Claimant['trading_name'];
$Claimant_arr[] = array(
		   'user_id'=>$user_id,
	       'name'=>'Claimant',
		   'profile_name'=>$Claimant_name,
		   'profile'=>'https://www.tradespeoplehub.co.uk/img/profile/'.$profile,
		   'comment'=>$ds_comment,
		    'reason2'=>$reason2,
	        'file'=>$file_arr,
		    );

// Comment
$comment_arr = array();
$check_user_all	=	$mysqli->prepare("SELECT dc.dct_id,dc.dct_userid,dc.dct_msg,dc.dct_created,df.file,dc.message_to,dc.end_time from disput_conversation_tbl dc LEFT JOIN dispute_file df ON df.conversation_id=dc.dct_id  where dc.dct_disputid=? ORDER BY dc.dct_id ASC");
$check_user_all->bind_param("i",$dispute_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user_all->bind_result($dct_id,$dct_userid,$dct_msg,$dct_created,$file,$message_to,$end_time);
while ($check_user_all->fetch()) {
	if($dct_userid=='-1'){
	  $name='Arbitrate team';
	} else if($dct_userid=='0'){
	  $name='Dispute team';
	} else {
	 $user = getUserDetails($dct_userid);	
	 $name = ($user['type']==1) ? $user['trading_name'] : $user['f_name'] . ' ' . $user['l_name'];
	}
	
	if ($message_to != 0) {
		$reply_to = getUserDetails($message_to);
		$reply_name = ($reply_to['type'] == 2) ? $reply_to['f_name'] . ' ' . $reply_to['l_name'] : $reply_to['trading_name'];
		$message_to_txt='Message for: '.$reply_name;
		if ($end_time) {
			$reply_message = 'reply before: '. date('d M Y h:i:s A', strtotime($end_time));
		}
		
	}
	
	$comment_arr[] = array(
		   'dct_id'=>$dct_id,
		   'name'=>$name,
		   'file'=>'https://www.tradespeoplehub.co.uk/'.$file,
		   'comment'=>$dct_msg,
		    'reason2'=>$reason2,
		    'message_to'=>$message_to_txt,
		    'reply_message'=>$reply_message,
		    'dct_created'=>$dct_created,
		    );
}

// Milestone
$milestone_arr = array();
$milestone_all	=	$mysqli->prepare("SELECT tbl_milestones.milestone_name,tbl_milestones.milestone_amount  from tbl_milestones inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = ?");
$milestone_all->bind_param("i",$dispute_id);
$milestone_all->execute();
$milestone_all->store_result();
$milestone_all->bind_result($milestone_name,$milestone_amount);
while ($milestone_all->fetch()) {
	$milestone_arr[] = array(
		   'milestone_amount'=>$milestone_amount,
		   'milestone_name'=>$milestone_name,
		   );
}



if(empty($comment_arr)){
	$comment_arr="NA";
}
if(empty($Claimant_arr)){
	$Claimant_arr="NA";
}
if(empty($milestone_arr)){
	$milestone_arr="NA";
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'dispute_arr'=>$transaction_arr,'Claimant_arr'=>$Claimant_arr,'comment_arr'=>$comment_arr,'milestone_arr'=>$milestone_arr); 
jsonSendEncode($record);