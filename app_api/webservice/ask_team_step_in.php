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
$dispute_id         = $_GET['dispute_id'];

$dispute = get_dispute($dispute_id);
$checkOtherUserReply = checkOtherUserReply($dispute['ds_id'],$dispute['dispute_to']);	
$setting = getAdminDetails();

$owner = getUserDetails($dispute['ds_puser_id']);
$tradmen = getUserDetails($dispute['ds_buser_id']);



$home_stepin = false;
$trades_stepin = false;
$showStepIn = false;
$new = date('Y-m-d H:i:s');

if($owner!='NA'){
	$home_stepin = ask_admin_data($owner['id'],$dispute['ds_id']);
	
}
if($tradmen!='NA'){ 
	$trades_stepin = ask_admin_data($tradmen['id'],$dispute['ds_id']);
}


if ($checkOtherUserReply!='NA') {
 $stepINTime = date('Y-m-d H:i:s', strtotime($checkOtherUserReply['dct_created'] . ' +' . $setting['step_in_day'] . ' days'));
	
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
			$showStepIn = $timeString . 'left to ask team to step in';
		} else {
			$showStepIn = (strtotime($stepINTime) - strtotime($new)) . ' Seconds left to ask team to step in';
		}
	}
}
$ask_button = false;
$pay_arbitration_button=false;
$pay_btn_msg=false;
$pay_btn=false;
$submitAsktoAdmin=false;


if ($dispute['ds_status'] == '0') {
if ($checkOtherUserReply!='NA') {

	 if ($showStepIn) {
		$teammsg = 'You can ask our dispute team to step in after '.date('d-m-Y h:i A', strtotime($stepINTime)); 
		 $ask_button = true;
		 $pay_arbitration_button=false;
		 $agreedmsg='Agreed: £0.00'; 
		 $pay_btn_msg=false;
		 $pay_btn=false;
		 $submitAsktoAdmin=false;
	 } else {
		 if (($home_stepin=='NA' && $owner['id'] == $user_id) || ($trades_stepin=='NA' && $tradmen['id'] == $user_id)) {
			$teammsg = 'If you can´t reach an agreement with the other party, you can ask our dispute team to step in after paying an arbitration fee of £'. $setting['step_in_amount'] .'.The fee will be returned upon wining the case.';
			$ask_button = true;
			$pay_arbitration_button=true;
			$agreedmsg='Agreed: £0.00'; 
			$pay_btn_msg = 'You want to pay an arbitration of £ '.$setting['step_in_amount'];
			$pay_btn='Pay Now';
			$submitAsktoAdmin=true;
		 }
	 }
}
} else {
$agreed_amount = ($dispute['caseCloseStatus'] == 5) ? (($dispute['last_offer_by']==$tradmen['id']) ? $dispute['tradesmen_offer'] : $dispute['homeowner_offer']) : '0.00';
$agreedmsg = 'Agreed: £ '.$agreed_amount;
if ($dispute['caseCloseStatus'] == 1) {
  $resolvemsg =   "Resolved, Not Responded";
} else if ($dispute['caseCloseStatus'] == 2) {
   $resolvemsg =  "Resolved, Cancelled";
} else if ($dispute['caseCloseStatus'] == 3) {
  $resolvemsg =    "Resolved, Arbitration Fees Not Paid";
} else if ($dispute['caseCloseStatus'] == 4) {
  $resolvemsg =   "Resolved By Dispute Team";
} else if ($dispute['caseCloseStatus'] == 5) {
 $resolvemsg =  "Resolved, Offer Accepted";
} else {
 $resolvemsg =  "Resolved, Dispute Closed";
}	
	
}
if(empty($agreedmsg)){
	$agreedmsg="NA";
}
if(empty($resolvemsg)){
	$resolvemsg="NA";
}


$record=array('success'=>'true','showStepIn'=>$showStepIn,'ask_button'=>$ask_button,'teammsg'=>$teammsg,'agreedmsg'=> $agreedmsg,'resolvemsg'=>$resolvemsg,'pay_arbitration_button'=>$pay_arbitration_button,'pay_btn_msg'=>$pay_btn_msg,'pay_btn'=>$pay_btn,'submitAsktoAdmin'=>$submitAsktoAdmin); 
jsonSendEncode($record);
