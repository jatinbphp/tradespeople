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


$check_user_all	    =	$mysqli->prepare("SELECT id,u_wallet,spend_amount,withdrawable_balance from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$withdrawable_balance);
$check_user_all->fetch();


$wd_bank = array();
$withdrawal_HISTORY	    =	$mysqli->prepare("SELECT `wd_id`, `wd_userid`, `wd_amount`, `wd_account_holder`, `wd_bank`, `wd_account`, `wd_ifsc_code`, `wd_reason`, `wd_status`, `wd_create`, `wd_payment_type`, `wd_pay_email`, `is_admin_read` FROM `tbl_withdrawal` WHERE wd_userid=? order by wd_id desc");
$withdrawal_HISTORY->bind_param("i",$user_id);
$withdrawal_HISTORY->execute();
$withdrawal_HISTORY->store_result();
$check_withdrawal_HISTORY		=	$withdrawal_HISTORY->num_rows;  //0 1
if($check_withdrawal_HISTORY > 0){
	$withdrawal_HISTORY->bind_result($wd_id, $wd_userid, $wd_amount, $wd_account_holder, $wd_bank1, $wd_account, $wd_ifsc_code, $wd_reason, $wd_status, $wd_create, $wd_payment_type, $wd_pay_email, $is_admin_read);
	while($withdrawal_HISTORY->fetch()){
		if($wd_payment_type==2 && empty($wd_bank)){
			$wd_bank = array(
				'wd_id'=>$wd_id,
				'wd_userid'=>$wd_userid,
				'wd_amount'=>$wd_amount,
				'wd_account_holder'=>$wd_account_holder,
				'wd_bank'=>$wd_bank1,
				'wd_account'=>$wd_account,
				'wd_ifsc_code'=>$wd_ifsc_code,
				'wd_reason'=>$wd_reason,
				'wd_status'=>$wd_status,
				'wd_create'=>$wd_create,
				'wd_payment_type'=>$wd_payment_type,
				'wd_pay_email'=>$wd_pay_email,
				'is_admin_read'=>$is_admin_read,
			);
		}
		$wd_arr[] = array(
			'wd_id'=>$wd_id,
			'wd_userid'=>$wd_userid,
			'wd_amount'=>$wd_amount,
			'wd_account_holder'=>$wd_account_holder,
			'wd_bank'=>$wd_bank1,
			'wd_account'=>$wd_account,
			'wd_ifsc_code'=>$wd_ifsc_code,
			'wd_reason'=>$wd_reason,
			'wd_status'=>$wd_status,
			'wd_create'=>$wd_create,
			'wd_payment_type'=>$wd_payment_type,
			'wd_pay_email'=>$wd_pay_email,
			'is_admin_read'=>$is_admin_read,
		);
	}
}




$checklocation_all=$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`, `admin_commission`, `updated_at` FROM `tbl_milestones` WHERE  status=2 and userid=? order by id desc ");
  $checklocation_all->bind_param("i", $user_id);

  $checklocation_all->execute();

  $checklocation_all->store_result();

 $check_location=  $checklocation_all->num_rows;  //0 1

  if($check_location > 0){
$checklocation_all->bind_result($id,$milestone_name,$milestone_amount,$userid,$post_id,$cdate,$status, $posted_user,$created_by,$reason_cancel,$dct_image,$decline_reason,$bid_id,$is_requested, $is_dispute_to_traders,$is_suggested,$admin_commission,$updated_at);

        while($checklocation_all->fetch()){
			$other_details=getUserDetails($posted_user);
		     $name = $other_details['name'];
           $get_job_details=getJobDetails($post_id);
			if($get_job_details!='NA')
			{
			 	
              $location_arr[]=array(
              'milestone_name'=>$milestone_name,
              'milestone_id'=>$id,
			  'milestone_amount'=>$milestone_amount,
			  'project_id'=>$get_job_details['project_id'],
			  'name'=>$name,
			  'title'=>$get_job_details['title'],
			   'job_id'=>$get_job_details['job_id'],
			  'status'=>'false',
			  'posted_user' => $posted_user,
			  'updated_at'=> date('d-M-Y',strtotime($updated_at))
            );
			}
    }

}

 

if(empty($location_arr)){

    $location_arr='NA';

}


if(empty($wd_arr)){
	$wd_arr = "NA";
}
if(empty($wd_bank)){
	$wd_bank="NA";
}

$record=array('success'=>'true','msg'=>array('data found'),'email_arr'=>$email_arr,'u_wallet'=>$withdrawable_balance,'wd_arr'=>$wd_arr,'wd_bank'=>$wd_bank,'invoice_arr'=>$location_arr); 
jsonSendEncode($record);

