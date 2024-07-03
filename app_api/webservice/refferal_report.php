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
 
$user_id	     	=	$_GET['user_id'];
$wd_arr 			=   array();


$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,referral_earning,type from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$referral_earning,$user_type);
$check_user_all->fetch();

/// Admin Settings
$settings = getAdminDetails();


 //get transction data========
$transaction_arr = array();
$tran_get = $mysqli->prepare("SELECT referrals_earn_list.id,referrals_earn_list.user_id,referrals_earn_list.referred_link,referrals_earn_list.earn_amount,referrals_earn_list.referred_by,users.f_name, users.l_name,users.cdate,users.type FROM `referrals_earn_list` join users on users.id =referrals_earn_list.user_id where referrals_earn_list.referred_type=? AND referrals_earn_list.referred_by=?");
$tran_get->bind_param("ii",$user_type,$user_id);
$tran_get->execute();
$tran_get->store_result();
$tran_get_row = $tran_get->num_rows;
if($tran_get_row>0){
	$tran_get->bind_result($id,$userid,$referred_link,$earn_amount,$referred_by,$f_name,$l_name,$cdate,$type);
	while ($tran_get->fetch()) {
		if(!empty($id))
		{
	     $usertype= ($type==1) ? 'Tradesman' : 'Homeowner'; 
		 if($type==1){
			 
$jb =	$mysqli->prepare("SELECT count(*) as quotes FROM `tbl_jobpost_bids` WHERE bid_by=?");
$jb->bind_param("i",$userid);
$jb->execute();
$jb->store_result();
$jb->bind_result($quotes);
$jb->fetch(); 
	
$jobs=0;	
if($settings['payment_method'] == 1){	
  $quote_n_milestone=$quotes;	
} else {
  $firstMilestone = getMileStoneByUserId(2,$userid,$type);		
}
			 
 } else {
			 
$jb = $mysqli->prepare("SELECT count(*) as quotes FROM `tbl_jobpost_bids` WHERE posted_by=?");
$jb->bind_param("i",$userid);
$jb->execute();
$jb->store_result();
$jb->bind_result($quotes);
$jb->fetch(); 
			 
$pj = $mysqli->prepare("SELECT count(*) as jobs FROM `tbl_jobs` where userid=?");
$pj->bind_param("i",$userid);
$pj->execute();
$pj->store_result();
$pj->bind_result($jobs);
$pj->fetch();			
			 
if($settings['payment_method'] == 1){	
  $quote_n_milestone=$jobs;	
} else {
  $firstMilestone = getMileStoneByUserId(2,$userid,$type);		 
}		 
			 
 }
		


			
	if($settings['payment_method'] == 1){
        $column_text = 'Quote Provide/Received';
		$quote_n_milestone=$quotes;
     }else{
        $column_text = 'Milestone Released(£)';
		$quote_n_milestone=$firstMilestone['milestone_amt'];
    }		
			
			
		 $transaction_arr[] = array(
			'id'=>$id,
			'type'=>$usertype,
			'user_id'=>$userid,
			'f_name'=>$f_name,
			'l_name'=>$l_name,
			'signed_up'=>date('d/m/Y', strtotime($cdate)),
			'quotes'=>$quote_n_milestone,
			'jobs'=>$jobs,
			'column_text'=>$column_text,
			'earn_amount'=>$earn_amount,
			'referred_by'=>$referred_by,
			'referred_link'=>$referred_link,
		  );
		}
	}
}
 
if(empty($transaction_arr)){
	$transaction_arr="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'refferal_arr'=>$transaction_arr); 
jsonSendEncode($record);