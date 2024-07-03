 <?php 
function getUserDetails($user_id){
	include('con1.php');
	$check_data_all =$mysqli->prepare("SELECT `id`, `unique_id`, `f_name`, `l_name`, `trading_name`, `type`, `email`, `phone_no`,phone_code ,`is_phone_verified`, `password`, `about_business`, `work_history`, `is_qualification`, `qualification`, `business_address`, `county`, `city`, `max_distance`, `business_type`, `cdate`, `u_token`, `postal_code`, `latitude`, `longitude`, `u_email_verify`, `hourly_rate`, `profile`, `profile_summary`, `professional_head`, `skills`, `status`, `company`, `category`, `average_rate`, `insurance_liability`, `insurance_date`, `insured_by`, `insurance_amount`, `u_wallet`, `spend_amount`, `commision`, `total_reviews`, `u_photo_id`, `u_bill`, `u_insurrance_certi`, `u_status_photo_id`, `u_status_bill`, `u_status_insure`, `document_updated`, `u_address`, `u_status_add`, `u_pay_verify`, `u_website`, `e_address`, `locality`, `u_id_card`, `u_id_card_status`, `free_trial_taken`, `is_pay_as_you_go`, `is_admin_read`, `notification_status`, `admin_update`,subcategory,review_invitation_status,withdrawable_balance,password,signup_step,referral_earning,referral_code FROM `users` WHERE id=?");
	$check_data_all->bind_param("i", $user_id);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($id, $unique_id, $f_name, $l_name, $trading_name, $type, $email, $phone_no,$phone_code, $is_phone_verified, $password, $about_business,$work_history, $is_qualification, $qualification, $business_address, $county, $city, $max_distance, $business_type, $cdate, $u_token, $postal_code, $latitude, $longitude, $u_email_verify, $hourly_rate, $profile, $profile_summary, $professional_head, $skills, $status, $company, $category, $average_rate, $insurance_liability, $insurance_date, $insured_by, $insurance_amount, $u_wallet, $spend_amount, $commision, $total_reviews, $u_photo_id,$u_bill, $u_insurrance_certi, $u_status_photo_id, $u_status_bill, $u_status_insure, $document_updated, $u_address, $u_status_add, $u_pay_verify, $u_website, $e_address, $locality, $u_id_card, $u_id_card_status, $free_trial_taken, $is_pay_as_you_go, $is_admin_read, $notification_status, $admin_update,$subcategory,$review_invitation_status,$withdrawable_balance,$password,$signup_step,$referral_earning,$referral_code);
		$check_data_all->fetch(); 
		if(empty($county)){
			$county = "NA";
		}
		if(is_null($insured_by)){
			$insured_by='';
		}
			
		if(empty($e_address)){
			$e_address = "NA";
		}
		if(empty($city)){
			$city = "NA";
		}
		if(empty($profile)){
			$profile = "NA";
		}

		$insurance_date1 = date('d M Y',strtotime($insurance_date));

		$name = $f_name.' '.$l_name;
		$user_arr = array(
			'id'            =>  $id, 
			'unique_id'     =>  $unique_id, 
			'name'          =>  $name, 
			'f_name'        =>  trim($f_name), 
			'l_name'        =>  trim($l_name), 
			'trading_name'  =>  $trading_name,
			'type'          =>  $type,
			'email'         =>  $email,
			'phone_no'        =>  $phone_no,
			'phone_code'=>$phone_code,
			'subcategory'=>$subcategory,
			'is_phone_verified'  =>  $is_phone_verified,
			'password'         =>  $password,
			'about_business'       =>  $about_business,
			'work_history'              =>  $work_history,
			'is_qualification'         =>  $is_qualification,
			'qualification'        =>  $qualification,
			'business_address'            =>  $business_address,
			'county'             =>  $county,
			'city'          =>  $city,
			'max_distance'            =>  $max_distance,
			'business_type'               =>  $business_type,
			'cdate'        =>  $cdate,
			'postal_code'             =>  $postal_code,
			'latitude'       =>  $latitude,
			'longitude'           =>  $longitude,
			'u_email_verify'       =>  $u_email_verify,
			'hourly_rate'       =>  $hourly_rate,
			'profile'      =>  $profile,
			'profile_summary'  =>  $profile_summary,
			'professional_head'              =>  $professional_head,
			'skills'               =>  $skills,
			'status'               =>  $status,
			'latitude'                 =>  $latitude,
			'longitude'                =>  $longitude,
			'category'             =>  $category,
			'average_rate'             =>  $average_rate,
			'insurance_liability'                =>  $insurance_liability,
			'insurance_date'      =>  $insurance_date,
			'insurance_date1'      =>  $insurance_date1,
			'insured_by'          =>  $insured_by,
			'insurance_amount'                  =>  $insurance_amount,  
			'max_age'                  =>  $max_age,  
			'u_wallet'                 =>  $u_wallet,
			'spend_amount'                  =>  $spend_amount,
			'commision'                     =>  $commision,
			'total_reviews'                  =>  $total_reviews,
			'u_photo_id'                     =>  $u_photo_id,
			'u_bill'  =>  $u_bill,
			'u_status_photo_id'    =>  $u_status_photo_id,
			'u_status_bill'            =>  $u_status_bill,
			'u_status_insure'      =>  $u_status_insure,
			'u_address'           =>  $u_address,
			'u_status_add'        =>  $u_status_add,
			'u_pay_verify'       =>  $u_pay_verify,
			'e_address'        =>  $e_address,
			'locality'              =>  $locality, 
			'u_id_card'          =>  $u_id_card,
			'u_id_card_status'                  =>  $u_id_card_status,  
			'free_trial_taken'                  =>  $free_trial_taken,  
			'distance'                 =>  $distance_range,
			'is_pay_as_you_go'                  =>  $is_pay_as_you_go,
			'kids'                     =>  $kids,
			'is_admin_read'                  =>  $is_admin_read,
			'notification_status'                     =>  $notification_status,
			'admin_update'  =>  $admin_update,
			'password'=>$password,
			'signup_step'=>$signup_step,
			'withdrawable_balance'=>$withdrawable_balance,
			'review_invitation_status'=>$review_invitation_status,
			'referral_code'=>$referral_code,
			'referral_earning'=>$referral_earning,

		);    
	}
	if(empty($user_arr)){
		$user_arr = "NA";
	}
	$mysqli->close();
	return $user_arr;
}

function getreferralsearndetails($user_id){
	include('con1.php');
	$earnstatus=0;
	$check_data_all =$mysqli->prepare("SELECT id,user_id,referred_by,referred_type,earn_status,earn_amount,referred_link,user_type FROM referrals_earn_list WHERE user_id=? AND earn_status=?");
	$check_data_all->bind_param("ss",$user_id,$earnstatus);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($id, $user_id, $referred_by, $referred_type, $earn_status, $earn_amount, $referred_link, $user_type);
		$check_data_all->fetch(); 
		
		$user_arr = array(
			'id'  =>$id, 
			'user_id'   =>$user_id, 
			'referred_by' =>$referred_by, 
			'referred_type' =>$referred_type, 
			'earn_status'  =>$earn_status, 
			'earn_amount' =>$earn_amount,
			'referred_link' =>$referred_link,
			'user_type' =>$user_type,
		);    
	}
	if(empty($user_arr)){
		$user_arr = "NA";
	}
	$mysqli->close();
	return $user_arr;
}

function adminsettings($id){
	include('con1.php');
	$earn_status=0;
	$check_data_all =$mysqli->prepare("SELECT id,type,min_amount_cashout,min_quotes_received_homeowner,min_quotes_approved_tradsman,comission_ref_homeowner,comission_ref_tradsman,referred_type,payment_method,participating_bid FROM `admin_settings` WHERE id=?");
	$check_data_all->bind_param("i", $id);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($id, $type, $min_amount_cashout, $min_quotes_received_homeowner, $min_quotes_approved_tradsman, $comission_ref_homeowner,$comission_ref_tradsman,$referred_type,$payment_method,$participating_bid);
		$check_data_all->fetch(); 
		
		$user_arr = array(
			'id'   =>  $id, 
			'type'    =>  $type, 
			'min_amount_cashout'  => $min_amount_cashout, 
			'min_quotes_received_homeowner' => $min_quotes_received_homeowner, 
			'min_quotes_approved_tradsman' =>  $min_quotes_approved_tradsman, 
			'comission_ref_homeowner'    =>  $comission_ref_homeowner,
			'comission_ref_tradsman'   =>  $comission_ref_tradsman,
			'referred_type'  =>  $referred_type,
			'payment_method' => $payment_method,
			'participating_bid' => $participating_bid,
		);    
	}
	if(empty($user_arr)){
		$user_arr = "";
	}
	$mysqli->close();
	return $user_arr;
}

function get_bids_by_status($bid_by,$job_id,$status){
	include('con1.php');
	$rct_jobs=$mysqli->query("select * from tbl_jobpost_bids where bid_by=$bid_by AND job_id=$job_id AND status=$status");
if ($rct_jobs->num_rows > 0) {		
 $row = $rct_jobs->fetch_array(MYSQLI_ASSOC);
	   $bids_arr[] = $row;
  }
  if(empty($bids_arr)){
		$bids_arr = "";
	}	
	return $bids_arr;
}

function get_trades_status($userid, $jobid){
	include('con1.php');
		$query = $mysqli->query("SELECT * FROM tbl_jobpost_bids WHERE bid_by=$userid and job_id=$jobid and (status=3 || status=7 || status=4)");
	if ($query->num_rows > 0) {	
		while($row = $query->fetch_array(MYSQLI_ASSOC)){
			$bids_arr[] = $row;
		}
	}
	if(empty($bids_arr)){
		$bids_arr = "";
	}	
	return $bids_arr;
}

function get_bids_by_id($id){
	include('con1.php');
	$bids_arr=array();
		$query = $mysqli->query("SELECT * FROM tbl_jobpost_bids WHERE id=$id");
	if ($query->num_rows > 0) {	
		while($row = $query->fetch_array(MYSQLI_ASSOC)){
			$bids_arr = $row;
		}
	}
	if(empty($bids_arr)){
		$bids_arr = "";
	}	
	return $bids_arr;
}

function gettotalMilestone($job_id){
	include('con1.php');
	$query = $mysqli->query("SELECT * FROM tbl_milestones WHERE post_id=$job_id");
	$num_rows = $query->num_rows;
	return $num_rows;
}

function gettotalcompletedMilestone($job_id){
	include('con1.php');
	$query = $mysqli->query("SELECT * FROM `tbl_milestones` WHERE (status=2 OR status=6) AND post_id=$job_id");
	$num_rows = $query->num_rows;
	return $num_rows;
}


function getrecentJobs($category,$user_id){
	include('con1.php');
	$user_profile=getUserDetails($user_id);
	$get_commision=getAdminDetails(); 
	$closed_date=$get_commision['closed_date'];
    $today = date('Y-m-d H:i:s');
	
	$sql = "SELECT * FROM tbl_jobs WHERE category IN ($category) and (status=0 or status=1 or status=2 or status=3) and is_delete=0 and direct_hired = 0 and DATE(job_end_date) >= DATE('" . $today . "') order by c_date desc";
	$query = $mysqli->query($sql);
	if ($query->num_rows > 0) {	
	  while($row = $query->fetch_array(MYSQLI_ASSOC)){
		$len = (strlen($row['post_code'])>=7)?4:3;
	   $post_code = strtoupper(substr($row['post_code'],0,$len));
	   $home_ouwner=getownerDetails($row['userid']);
	   if($home_ouwner!='NA'){
		$homeowner_name=$home_ouwner['name'];
	   }	
		$get_post_jobs = get_bids_by_status($user_id,$row['job_id'],7);
	    $get_trades=get_trades_status($user_id,$row['job_id']);
	    $dateTimestamp2 = strtotime($row['job_end_date']);
	   if($dateTimestamp2<$dateTimestamp1){
          $expire_status=1;
        }	
		  
	$datesss= date('Y-m-d H:i:s', strtotime($row['c_date']. ' + '.$closed_date.' days'));
	if(empty($get_trades)){
	if(($row['status']==0 || $row['status']==1 || $row['status']==2 || $row['status']==3) && (date('Y-m-d H:i:s')< $datesss)){
		$status_job='Open';
	} else if(($row['status']==4) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){
		$status_job='Closed';
	} else if(($row['status']==7) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){
		$status_job='Closed';
	} else if(($row['status']==8) && (date('Y-m-d H:i:s')< $datesss)){
		$status_job='Open';
	} else if(($row['status']==5) && (date('Y-m-d H:i:s')< $datesss) && empty($get_post_jobs)){
		$status_job='Closed';
	} else if((date('Y-m-d H:i:s')>=$datesss) && ($row['status']!=4 || $row['status']!=5 || $row['status']==7) && empty($get_post_jobs) ){
		$status_job='Closed';
	}
	} else {
		if(($row['status']==0 || $row['status']==1 || $row['status']==2 || $row['status']==3) && (date('Y-m-d H:i:s')< $datesss)){
			$status_job='Open';
		} else if(($row['status']==4) && (date('Y-m-d H:i:s')< $datesss)){
			$status_job='Awaiting Acceptance';
		} else if(($row['status']==7) && (date('Y-m-d H:i:s')< $datesss)){
			$status_job='In Progress';
		} else if(($row['status']==8) && (date('Y-m-d H:i:s')< $datesss)){
			$status_job='Open';
		} else if(($row['status']==5) && (date('Y-m-d H:i:s')< $datesss)){
			$status_job='Completed';
		} else if((date('Y-m-d H:i:s')>=$datesss) && ($row['status']!=4 || $row['status']!=5 || $row['status']==7) && empty($get_post_jobs)){
			$status_job='Closed';
		}
	}	 
		  
$distance= distanceCalculation($row['latitude'],$row['longitude'], $user_profile['latitude'],$user_profile['longitude'], 'mi', $decimals = 2) ; 
		  
	$job_detailrecent[] = array(
	'job_id' =>  $row['job_id'],
	'project_id' =>  $row['project_id'],
	'title'   => $row['title'],
	'budget'   => $row['budget'],
	'budget2'   => $row['budget2'],
	'category_name' => $row['category_name'],
	'description' => $row['description'],
	'userid' => $row['userid'],
	'status' => $row['status'],
	'quotes' =>  $row['quotes'],
	'status_job' =>  $status_job,
	'avg_quotes' =>  $avg_quotes,
	'distance'	=> round($distance,1).' miles',
	'homeowner_name' =>  $homeowner_name,
	'post_code'=>$post_code,
	'expire_status'=>$expire_status,
	'job_end_date'=>$row['job_end_date']
);
		}
	}
	if(empty($job_detailrecent)){
		$job_detailrecent = "NA";
	}	
	return $job_detailrecent;	
}


function get_post_bids($bid_by,$job_id){
include('con1.php');
$post_all =$mysqli->prepare("SELECT `id`, `bid_amount`, `delivery_days`, `propose_description`, `total_milestone_amount`, `bid_by`, `job_id`, `cdate`, `posted_by`, `status`, `reject_reason`, `awarded_date`, `hiring_type`, `update_date`, `paid_total_miles`, `nn_status`, `miles_noti_status_to_home`, `miles_noti_status_by_trades`, `is_admin_read` FROM `tbl_jobpost_bids` WHERE bid_by=? AND job_id=? ");
	$post_all->bind_param("ii", $bid_by,$job_id);
	$post_all->execute();
	$post_all->store_result();
	$check_data = $post_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$post_all->bind_result($id, $bid_amount, $delivery_days, $propose_description, $total_milestone_amount, $bid_by, $job_id, $cdate, $posted_by, $status, $reject_reason, $awarded_date, $hiring_type, $update_date, $paid_total_miles, $nn_status, $miles_noti_status_to_home, $miles_noti_status_by_trades, $is_admin_read);
	//	$post_all->fetch(); 
		while($post_all->fetch()){
		$bids_arr[] = array(
			'id'            =>  $id, 
			'bid_amount'       =>  $bid_amount, 
			'delivery_days'     =>  $delivery_days, 
			'propose_description'    =>  $propose_description, 
			'total_milestone_amount' =>  $total_milestone_amount, 
			'bid_by'    =>  $bid_by,
			'job_id'   =>  $job_id,
			'cdate'  =>  $cdate,
			'posted_by' => $posted_by,
			'status' => $status,
			'reject_reason' => $reject_reason,
			'awarded_date' => $awarded_date,
			'hiring_type' => $hiring_type,
			'update_date' => $update_date,
			'paid_total_miles' => $paid_total_miles,
			'nn_status' => $nn_status,
			'miles_noti_status_to_home' => $miles_noti_status_to_home,
			'miles_noti_status_by_trades' => $miles_noti_status_by_trades,
			'is_admin_read' => $is_admin_read,
		 );    
		}	
	}
	if(empty($bids_arr)){
		$bids_arr = "NA";
	}
	$mysqli->close();
	return $bids_arr;		
}




function get_accepted_post($posted_by,$job_id){
include('con1.php');
$post_all =$mysqli->prepare("SELECT `id`, `bid_amount`, `delivery_days`, `propose_description`, `total_milestone_amount`, `bid_by`, `job_id`, `cdate`, `posted_by`, `status`, `reject_reason`, `awarded_date`, `hiring_type`, `update_date`, `paid_total_miles`, `nn_status`, `miles_noti_status_to_home`, `miles_noti_status_by_trades`, `is_admin_read` FROM `tbl_jobpost_bids` WHERE posted_by=? AND job_id=? AND status!=0 order by id desc");
	$post_all->bind_param("ii",$posted_by,$job_id);
	$post_all->execute();
	$post_all->store_result();
	$check_data = $post_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$post_all->bind_result($id, $bid_amount, $delivery_days, $propose_description, $total_milestone_amount, $bid_by, $job_id, $cdate, $posted_by, $status, $reject_reason, $awarded_date, $hiring_type, $update_date, $paid_total_miles, $nn_status, $miles_noti_status_to_home, $miles_noti_status_by_trades, $is_admin_read);
		$post_all->fetch(); 
		
		$bids_arr = array(
			'id'            =>  $id, 
			'bid_amount'       =>  $bid_amount, 
			'delivery_days'     =>  $delivery_days, 
			'propose_description'    =>  $propose_description, 
			'total_milestone_amount' =>  $total_milestone_amount, 
			'bid_by'    =>  $bid_by,
			'job_id'   =>  $job_id,
			'cdate'  =>  $cdate,
			'posted_by' => $posted_by,
			'status' => $status,
			'reject_reason' => $reject_reason,
			'awarded_date' => $awarded_date,
			'hiring_type' => $hiring_type,
			'update_date' => $update_date,
			'paid_total_miles' => $paid_total_miles,
			'nn_status' => $nn_status,
			'miles_noti_status_to_home' => $miles_noti_status_to_home,
			'miles_noti_status_by_trades' => $miles_noti_status_by_trades,
			'is_admin_read' => $is_admin_read,
		 );    
		
	}
	if(empty($bids_arr)){
		$bids_arr = "NA";
	}
	$mysqli->close();
	return $bids_arr;	
	
}

function ask_admin_data($user_id,$dispute_id){
	include('con1.php');
	$check_data_all =$mysqli->prepare("SELECT `id`, `user_id`, `user_type`, `dispute_id`, `amount`, `created_at`, `expire_time`, `is_admin_read` FROM `ask_admin_to_step` WHERE user_id=? AND dispute_id=?");
	$check_data_all->bind_param("ii",$user_id,$dispute_id);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($id, $user_id, $user_type, $dispute_id, $amount, $created_at, $expire_time, $is_admin_read);
		$check_data_all->fetch(); 
		$user_arr = array(
			'id'            =>  $id, 
			'user_id'       =>  $user_id, 
			'user_type'     =>  $user_type, 
			'dispute_id'    =>  $dispute_id, 
			'amount'        =>  $amount, 
			'created_at'    =>  $created_at,
			'expire_time'   =>  $expire_time,
			'is_admin_read'  =>  $is_admin_read,
		);    
	}
	if(empty($user_arr)){
		$user_arr = "NA";
	}
	$mysqli->close();
	return $user_arr;
}

function get_dispute($dispute_id){
	include('con1.php');
	$earnstatus=0;
	$check_data_all =$mysqli->prepare("SELECT ds_id,ds_in_id,ds_job_id,ds_buser_id,ds_puser_id,ds_status,ds_favour,ds_comment,caseid,ds_create_date,disputed_by,dispute_to,is_admin_read,is_accept,reason2,homeowner_offer,tradesmen_offer,last_offer_by,offer_rejected_by_homeowner,offer_rejected_by_tradesmen,total_amount,agreed_amount,caseCloseStatus,mile_id FROM tbl_dispute WHERE ds_id=?");
	$check_data_all->bind_param("i",$dispute_id);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($ds_id, $ds_in_id, $ds_job_id, $ds_buser_id, $ds_puser_id, $ds_status, $ds_favour, $ds_comment, $caseid, $ds_create_date, $disputed_by, $dispute_to, $is_admin_read, $is_accept, $reason2, $homeowner_offer, $tradesmen_offer, $last_offer_by, $offer_rejected_by_homeowner, $offer_rejected_by_tradesmen, $total_amount, $agreed_amount, $caseCloseStatus, $mile_id);
		$check_data_all->fetch(); 
		 $dis_arr = array(
			'ds_id'  =>$ds_id, 
			'ds_in_id'   =>$ds_in_id, 
			'ds_job_id' =>$ds_job_id, 
			'ds_buser_id' =>$ds_buser_id, 
			'ds_puser_id'  =>$ds_puser_id, 
			'ds_status' =>$ds_status,
			'ds_favour' =>$ds_favour,
			'ds_comment' =>$ds_comment,
			'caseid' => $caseid,
			'ds_create_date'=>$ds_create_date,
			'disputed_by'=>$disputed_by,
			'dispute_to'=>$dispute_to,
			'is_admin_read'=>$is_admin_read,$is_admin_read,
			'is_accept'=>$is_accept,
			'reason2'=>$reason2,
			'homeowner_offer'=>$homeowner_offer,
			'tradesmen_offer'=>$tradesmen_offer,
			'last_offer_by'=>$last_offer_by,
			'offer_rejected_by_homeowner'=>$offer_rejected_by_homeowner,
			'offer_rejected_by_tradesmen'=>$offer_rejected_by_tradesmen,
			'total_amount'=>$total_amount,
			'agreed_amount'=>$agreed_amount,
			'caseCloseStatus'=>$caseCloseStatus,
			'mile_id'=>$mile_id,
		);    
	}
	if(empty($dis_arr)){
		$dis_arr = "NA";
	}
	$mysqli->close();
	return $dis_arr;
}

function getallmilestone($dispute_id){
include('con1.php');
$mile_all =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`,`status`,`posted_user`,`created_by`,`reason_cancel`,`dct_image`,`decline_reason`,`bid_id`,`is_requested`,`is_dispute_to_traders`,`is_suggested`,`admin_commission`,`updated_at`,`dispute_id`  FROM `tbl_milestones` WHERE dispute_id=?");
	$mile_all->bind_param("i", $dispute_id);
	$mile_all->execute();
	$mile_all->store_result();
	$check_data = $mile_all->num_rows;  //0 1
	if($check_data > 0)
	{
	$mile_all->bind_result($id,$milestone_name,$milestone_amount,$userid,$post_id,$cdate,$status,$posted_user,$created_by,$reason_cancel,$dct_image,$decline_reason,$bid_id,$is_requested,$is_dispute_to_traders,$is_suggested,$admin_commission,$updated_at,$dispute_id);
	//	$post_all->fetch(); 
		while($mile_all->fetch()){
		$mil_arr[] = array(
			'id'            =>  $id, 
			'milestone_name'       =>  $milestone_name, 
			'milestone_amount'     =>  $milestone_amount, 
			'userid'    =>  $userid, 
			'post_id' =>  $post_id, 
			'cdate'    =>  $cdate,
			'job_id'   =>  $job_id,
			'cdate'  =>  $cdate,
			'status' => $status,
			'posted_user' => $posted_user,
			'created_by' => $created_by,
			'reason_cancel' => $reason_cancel,
			'dct_image' => $dct_image,
			'decline_reason' => $decline_reason,
			'bid_id' => $bid_id,
			'is_requested' => $is_requested,
			'is_dispute_to_traders' => $is_dispute_to_traders,
			'is_suggested' => $is_suggested,
			'admin_commission' => $admin_commission,
			'updated_at'=>$updated_at,
			'dispute_id'=>$dispute_id,
		 );    
		}	
	}
	if(empty($mil_arr)){
		$mil_arr = "NA";
	}
	$mysqli->close();
	return $mil_arr;	
	
}

function get_unread_msg_count($userid,$post_id,$rid) {
	include('con1.php');
	$count = 0;
	$get_unreadMsgCount=$mysqli->prepare("select COUNT(id) as total from chat where post_id ='".$post_id."' and receiver_id = '".$userid."' and sender_id='".$rid."' and is_read='0'");
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
		$get_unreadMsgCount->bind_result($count);
		$get_unreadMsgCount->fetch();
	}
 
	$mysqli->close();
	return $count;
}

function get_dispute_id($job_id) {
	include('con1.php');
	$ds_id = 0;
	$get_unreadMsgCount=$mysqli->prepare("SELECT `ds_id` FROM `tbl_dispute` WHERE  `ds_status`=0  and ds_job_id =$job_id");
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
		$get_unreadMsgCount->bind_result($ds_id);
		$get_unreadMsgCount->fetch();
	}
 
	$mysqli->close();
	return $ds_id;
}

function get_dispute_close_status($disput_id) {
	include('con1.php');
	$status_close=0;
	$get_unreadMsgCount=$mysqli->prepare("SELECT `dct_id` FROM `disput_conversation_tbl` WHERE  `is_reply_pending`=1 and dct_disputid =$disput_id and DATE(end_time) < DATE(NOW()) order by dct_id desc limit 1 ");
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
	$status_close=1;
	}
 
	$mysqli->close();
	return $status_close;
}

function get_category_list($cat_id) {
	include('con1.php');
	$count = 0;
	$cat_arr = array();
	
	$get_unreadMsgCount=$mysqli->prepare("select cat_name from category where cat_id IN('".$cat_id."')");
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
		$get_unreadMsgCount->bind_result($cat_name);
		while ($get_unreadMsgCount->fetch()) {
			$cat_arr[] = $cat_name;
		}
	}
 
	if(empty($cat_arr)){
		$cat_arr  =   "NA";
	}
	$mysqli->close();
	return $cat_arr;
}

function disput_close($dispute_id,$user_id,$job_id,$bid_id){

include('con1.php');

$get_dispute_details=$mysqli->prepare("SELECT dct_id FROM  disput_conversation_tbl  where 	is_reply_pending=1 and dct_disputid=? order by dct_id desc limit 1");
$get_dispute_details->bind_param('i',$dispute_id);
$get_dispute_details->execute();
$get_dispute_details->store_result();
$get_dispute_details_count=$get_dispute_details->num_rows;  //0 1	

if($get_dispute_details_count > 0){
	$get_dispute_details->bind_result($dct_id);
	$get_dispute_details->fetch();
	{
	
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


// check dispute id ==========
$get_dispute_data=$mysqli->prepare("SELECT `ds_id`, `ds_in_id`, `ds_job_id`, `ds_buser_id`, `ds_puser_id`, `ds_status`, `ds_favour`, `ds_comment`, `caseid`, `ds_create_date`, `mile_id`, `disputed_by`, `dispute_to`, `is_admin_read`, `is_accept` FROM `tbl_dispute` WHERE ds_id=?");
$get_dispute_data->bind_param('i',$dispute_id);
$get_dispute_data->execute();
$get_dispute_data->store_result();
$get_dispute_data_count=$get_dispute_data->num_rows;  //0 1	
if($get_dispute_data_count <= 0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong please try again later.')); 
	jsonSendEncode($record);
}
$get_dispute_data->bind_result($ds_id, $ds_in_id, $ds_job_id, $ds_buser_id, $ds_puser_id, $ds_status, $ds_favour, $ds_comment, $caseid, $ds_create_date, $mile_id, $disputed_by, $dispute_to, $is_admin_read, $is_accept);
$get_dispute_data->fetch();

$dipute_by 		= $disputed_by;
$dipute_to  	= $dispute_to;
$job_id 		= $job_id;
$tradesman 		= $ds_buser_id;
$homeowner 		= $ds_puser_id;
$dispute_ids 	= $ds_id;
$dispute_finel_user = $dipute_by;

$home 		=	getUserDetails($homeowner);
$trades 	=	getUserDetails($tradesman);
$favo 		=	getUserDetails($dispute_finel_user);
$mile_id    =   $mile_id;
$milestone  =   getMileStoneById($mile_id);

if($dipute_by==$tradesman){
	$accname = $home['f_name'];
} else {
	$accname = $trades['trading_name'];
}

	
$massage = '<p>Dispute resolved as  '.$accname.' accept and close.</p>';
$dct_userid = 0;
$dct_isfinal= 1;


$insert_dispute_conver = $mysqli->prepare("INSERT INTO `disput_conversation_tbl`( `dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`, `mile_id`) VALUES (?,?,?,?,?)");
$insert_dispute_conver->bind_param("sssss",$dispute_ids,$dct_userid,$massage,$dct_isfinal,$mile_id);	
$insert_dispute_conver->execute();
$insert_dispute_conver_affect_row=$mysqli->affected_rows;
if($insert_dispute_conver_affect_row<=0){
	$record=array('success'=>'false','msg'=>array('Error! Something went wrong.')); 
	jsonSendEncode($record);
}


//update milestone = 
$milestaone_update = $mysqli->prepare("UPDATE `tbl_milestones` SET `status`=6 WHERE  id=?");
$milestaone_update->bind_param("i",$mile_id);	
$milestaone_update->execute();
$milestaone_update_affect_row=$mysqli->affected_rows;
if($milestaone_update_affect_row<=0){
	$record=array('success'=>'false','msg'=>$msg_error_update); 
	jsonSendEncode($record);
}
 

$tbl_dispute_update = $mysqli->prepare("UPDATE `tbl_dispute` SET `ds_status`=1,ds_favour=? WHERE  ds_id=?");
$tbl_dispute_update->bind_param("ii",$dispute_finel_user,$dispute_ids);	
$tbl_dispute_update->execute();
$tbl_dispute_update_affect_row=$mysqli->affected_rows;
if($tbl_dispute_update_affect_row<=0){
	$record=array('success'=>'false','msg'=>$msg_error_update); 
	jsonSendEncode($record);
}	

//echo $trades['id'].' '. $dispute_finel_user;
$amount = $milestone['milestone_amt'];
if($trades['id']==$dispute_finel_user){
	$setting 		=  	getAdminDetails();
	$commision 		= 	$setting['commision'];

	$pamnt 			= 	$bid_arr['paid_total_miles'];
	$final_amount   = 	$pamnt + $amount;

	$key = 'paid_total_miles='.$final_amount;
	$where = 'id='.$bid_id;
	$update_milestone1_affect_row = updatesingledata($key, 'tbl_jobpost_bids', $where);

	$total  	= 	($amount*$commision)/100;
	$amounts  	= 	$amount-$total;
	$u_wallet 	=	$trades['u_wallet'];
	$update1 	=	$u_wallet+$amounts;
		
	$key1 = 'is_dispute_to_traders=1';
	$where1 = 'id='.$mile_id;
	$update_milestone1_affect_row1 = updatesingledata($key1, 'tbl_milestones', $where1);
			

	if($final_amount >= $bid_arr['bid_amount']) {

		$key2    = 'status=5';
		$where2  = 'job_id='.$milestone['post_id'];
		$runss12 = updatesingledata($key2, 'tbl_jobs', $where2);
			
		
		$key3    = 'status=4';
		$where3  = 'id='.$bid_id;
		$runss123 = updatesingledata($key3, 'tbl_jobpost_bids', $where3);
	}
}else {
	$amounts 	=  	$amount;
	$u_wallet 	= 	$home['u_wallet'];
	$update1 	= 	$u_wallet+$amounts;
}

$key4      = 'u_wallet='.$update1;
$where4    = 'id='.$dispute_finel_user;
$runss1234 = updatesingledata($key4, 'users', $where4);

// update transacion========
$transactionid = md5(rand(1000,999).time());
$tr_type = 1;
$tr_status = 1;
$updatetime =  date("Y-m-d H:i:s");
$transaction_add = $mysqli->prepare("INSERT INTO `transactions`(`tr_userid`, `tr_amount`, `tr_type`, `tr_status`, `tr_created`, `tr_update`,tr_message,tr_transactionId) VALUES (?,?,?,?,?,?,?,?)");
$transaction_add->bind_param("isiissss",$dispute_finel_user,$amounts,$tr_type,$tr_status,$updatetime,$updatetime,$massage,$transactionid);	
$transaction_add->execute();
$transaction_add_affect_row=$mysqli->affected_rows;
if($transaction_add_affect_row<=0){
	$record=array('success1'=>'false','msg'=>$p_transaction_err); 
	jsonSendEncode($record);
}


	}
	
}
$cat_arr ='NA';
	return $cat_arr;

}

 

function get_unread_by_sid_rid($sender,$receiver,$post_id){
	include('con1.php');
	$count = 0;
	$get_unreadMsgCount=$mysqli->prepare("select COUNT(id) as total from chat where is_read = 0 and receiver_id = ? and sender_id = ? and post_id=?");
	$get_unreadMsgCount->bind_param('iii',$sender,$receiver,$post_id);
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
		$get_unreadMsgCount->bind_result($count);
		$get_unreadMsgCount->fetch();
	}
 
	$mysqli->close();
	return $count;
}

function gettotaltodaysms($user_id){
	include('con1.php');
	$count = 0;
	$get_unreadMsgCount=$mysqli->prepare("SELECT COUNT(`id`) FROM `daily_sms_records` WHERE user_id=?");
	$get_unreadMsgCount->bind_param('i',$user_id);
	$get_unreadMsgCount->execute();
	$get_unreadMsgCount->store_result();
	$get_unreadMsgCount_count=$get_unreadMsgCount->num_rows;  //0 1	
	if($get_unreadMsgCount_count > 0){
		$get_unreadMsgCount->bind_result($count);
		$get_unreadMsgCount->fetch();
	}
 
	$mysqli->close();
	return $count;
}

function getJobDetails($job_id){
	include('con1.php');
	$job_detail = array();
	
	$getjobdetail=$mysqli->prepare("SELECT `job_id`, `title`, `description`, `budget`, `budget2`, `userid`, `status`, `category`, `is_delete`, `c_date`, `subcategory`, `post_code`, `project_id`, `update_date`, `awarded_to`, `direct_hired`, `is_admin_read`, `awarded_time`, `subcategory_1`, `is_email_sent`, `latitude`, `longitude`, `city`, `address`, `country`, `job_end_date` FROM `tbl_jobs` where job_id=?");
	$getjobdetail->bind_param('i',$job_id);
	$getjobdetail->execute();
	$getjobdetail->store_result();
	$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
	if($getjobdetail_count > 0){
		$getjobdetail->bind_result($job_id, $title, $description, $budget, $budget2, $userid, $status, $category, $is_delete, $c_date, $subcategory, $post_code, $project_id, $update_date, $awarded_to, $direct_hired, $is_admin_read, $awarded_time, $subcategory_1, $is_email_sent, $latitude, $longitude, $city, $address, $country, $job_end_date);
		while ($getjobdetail->fetch()) {
			$job_detail = array(
				'job_id'=>$job_id,
				'title'=>$title,
				'description'=>$description,
				'budget'=>$budget,
				'budget2'=>$budget2,
				'userid'=>$userid,
				'status'=>$status,
				'category'=>$category,
				'is_delete'=>$is_delete,
				'c_date'=>$c_date,
				'subcategory'=>$subcategory,
				'post_code'=>$post_code,
				'project_id'=>$project_id,
				'update_date'=>$update_date,
				'awarded_to'=>$awarded_to,
				'direct_hired'=>$direct_hired,
				'is_admin_read'=>$is_admin_read,
				'awarded_time'=>$awarded_time,
				'subcategory_1'=>$subcategory_1,
				'is_email_sent'=>$is_email_sent,
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'city'=>$city,
				'address'=>$address,
				'country'=>$country,
				'job_end_date'=>$job_end_date,
			);
		}
	}

	if(empty($job_detail)){
		$job_detail  =   "NA";
	}
	$mysqli->close();
	return $job_detail;
}





function getAdminDetails() {
	include('con1.php');
	$admin_data=$mysqli->prepare("SELECT `id`, `username`, `email`, `password`, `create_date`, `status`, `type`, `roles`, `p_max_d`, `p_min_d`, `p_max_w`, `p_min_w`, `commision`, `credit_amount`, `closed_date`, `waiting_time`, `feedback_day_limit`, `processing_fee`, `invite_to_review_status`, `waiting_time_accept_offer`, `paypal_comm_per`, `paypal_comm_fix`, `stripe_comm_per`, `stripe_comm_fix`, `acc_name`, `acc_number`, `sort_code`, `bank_name`, `payment_method`,`step_in_day`,`step_in_amount`,`arbitration_fee_deadline`  FROM `admin`");
	$admin_data->execute();
	$admin_data->store_result();
	$check_admin_data=$admin_data->num_rows;  //0 1
	if($check_admin_data > 0)
	{
		$admin_data->bind_result($id,$username,$email,$password,$create_date,$status,$type,$roles,$p_max_d,$p_min_d,$p_max_w,$p_min_w,$commision,$credit_amount,$closed_date,$waiting_time,$feedback_day_limit,$processing_fee,$invite_to_review_status,$waiting_time_accept_offer,$paypal_comm_per,$paypal_comm_fix,$stripe_comm_per,$stripe_comm_fix,$acc_name,$acc_number,$sort_code,$bank_name,$payment_method, $step_in_day,$step_in_amount,$arbitration_fee_deadline);
		$admin_data->fetch();
		$admin_arr  =   array(
			'id'		=>	$id,
			'username'	=>	$username,
			'email'		=>	$email,
			'password'	=>	$password,
			'create_date'=>	$create_date,
			'status'	=>	$status,
			'type'		=>	$type,
			'roles'		=>	$roles,
			'p_max_d'	=>	$p_max_d,
			'p_min_d'	=>	$p_min_d,
			'p_max_w'	=>	$p_max_w,
			'p_min_w'	=>	$p_min_w,
			'commision'	=>	$commision,
			'credit_amount'	=>	$credit_amount,
			'closed_date'	=>	$closed_date,
			'waiting_time'	=>	$waiting_time,
			'feedback_day_limit'=>	$feedback_day_limit,
			'processing_fee'	=>	$processing_fee,
			'invite_to_review_status'	=>	$invite_to_review_status,
			'waiting_time_accept_offer'	=>	$waiting_time_accept_offer,
			'paypal_comm_per'	=>	$paypal_comm_per,
			'paypal_comm_fix'	=>	$paypal_comm_fix,
			'stripe_comm_per'	=>	$stripe_comm_per,
			'stripe_comm_fix'	=>	$stripe_comm_fix,
			'bank_comm_per'	=>	$processing_fee,
			'bank_comm_fix'	=>	0,
			 'acc_name'=>$acc_name,
			 'acc_number'=>$acc_number,
			 'sort_code'=>$sort_code,
			 'bank_name'=>$bank_name,
			'payment_method' => $payment_method,
			'step_in_day' => $step_in_day,
			'step_in_amount'=>$step_in_amount,
			'arbitration_fee_deadline'=>$arbitration_fee_deadline,
		);
	}

	if(empty($admin_arr)){
		$admin_arr  =   "NA";
	}
	$mysqli->close();
	return $admin_arr;
}


function ageCalculator($dob){
	if(!empty($dob)){
		$birthdate = new DateTime($dob);
		$today     = new DateTime('today');
		$age       = $birthdate->diff($today)->y;
		return $age;
	}else{
		return 0;
	}
}
function timeAgoCustomer($time_ago) {
	$time_ago       =   strtotime($time_ago);
	$cur_time       =   time();
	$time_elapsed   =   $cur_time - $time_ago;
	$seconds        =   $time_elapsed ;
	$minutes        =   round($time_elapsed / 60 );
	$hours          =   round($time_elapsed / 3600);
	$days           =   round($time_elapsed / 86400 );
	$weeks          =   round($time_elapsed / 604800);
	$months         =   round($time_elapsed / 2600640 );
	$years          =   round($time_elapsed / 31207680 );

	$time_response  =   '';

	// Seconds
	if($seconds <= 60){
		$time_response  =   "just now";
	}//Minutes
	else if($minutes <=60){
		if($minutes==1){
			$time_response  =   "one minute";
		}
		else{
			$time_response  =   "$minutes minutes";
		}
	}//Hours
	else if($hours <=24){
		if($hours==1){
			$time_response  =   "an hour";
		}else{
			$time_response  =   "$hours hrs";
		}
	}//Days
	else if($days <= 7){
		if($days==1){
			$time_response  =   "yesterday";
		}else{
			$time_response  =   "$days days";
		}
	}//Weeks
	else if($weeks <= 4.3){
		if($weeks==1){
			$time_response  =   "a week";
		}else{
			$time_response  =   "$weeks weeks";
		}
	}//Months
	else if($months <=12){
		if($months==1){
			$time_response  =   "a month";
		}else{
			$time_response  =   "$months months";
		}
	}//Years
	else{
		if($years==1){
			$time_response  =   "one year";
		}else{
			$time_response  =   "$years years";
		}
	}
	return $time_response;
}  


function distanceCalculation1($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'M', $decimals = 2) 
{  
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
			$return = ($miles * 1.609344);
	} else if ($unit == "N") {
			$return = ($miles * 0.8684);
	} else {
			$return = $miles;
	}
	
	return round($return,1);
}


function distanceCalculation($lat1=0, $lon1=0, $lat2=0, $lon2=0,$unit='M',$unit1=2) { 
		
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
			$return = ($miles * 1.609344);
	} else if ($unit == "N") {
			$return = ($miles * 0.8684);
	} else {
			$return = $miles;
	}
	
	return round($return,1);
}


function FormatDateAllPattern($datetime, $format_date) {
	if($format_date=="day_month_year"){
		$datetime   =   date('d-M-y', strtotime($datetime));
	}
	else if($format_date=="month_date_year"){
		$datetime   =   date('m-d-Y', strtotime($datetime));
	}
	else if($format_date=="year_month_date"){
		$datetime   =   date('Y-m-d', strtotime($datetime));
	}
	else if($format_date=="date_am_pm"){
		$datetime   =   date('d/m/Y H:i', strtotime($datetime));
	}
	else if($format_date=="date_am_pm_at"){
		$datetime   =   date('D jS M Y \a\t h:i A', strtotime($datetime));//this.....
	}
	else if($format_date=="date_am_pm_at1"){
		$datetime   =   date('D M j \a\t h:i A', strtotime($datetime));
	}
	else if($format_date=="date_am_pm_at2"){
		$datetime   =   date('l\, F j', strtotime($datetime));
	}
	else if($format_date=="date_am_pm_at3"){
		$datetime   =   date('l\, F d', strtotime($datetime));
	}
	else if($format_date=="date_am_pm_at4"){
		$datetime   =   date('F d', strtotime($datetime));
	}
	else if($format_date=="join_date"){
		$datetime   =   date('j F Y', strtotime($datetime));
	}
	else if($format_date=="am_pm"){
		$datetime   =   date('h:i A', strtotime($datetime));
	}
	return $datetime;       
}


function getTodayLikeCount($user_id_post){
	include('con1.php');
	$count = 0;
	$createdate = date('Y-m-d');
	$check_count =$mysqli->prepare("SELECT COUNT(`like_id`) as like_count FROM `like_master` WHERE `createdate`=? and status=1 and user_id=?");
	$check_count->bind_param("si",$createdate,$user_id_post);
	$check_count->execute();
	$check_count->store_result();
	$check_rate_count = $check_count->num_rows;  //0 1
	if($check_rate_count > 0){
		$check_count->bind_result($count);
		$check_count->fetch();
	}
	$mysqli->close();
	return $count;
}   


function getTodayLikeSuperDisCount($user_id_post){
	include('con1.php');
	$count = 0;
	$createdate = date('Y-m-d');
	$check_count =$mysqli->prepare("SELECT COUNT(`like_id`) as like_count FROM `like_master` WHERE `createdate`=? and user_id=? and delete_flag=0");
	$check_count->bind_param("si",$createdate,$user_id_post);
	$check_count->execute();
	$check_count->store_result();
	$check_rate_count = $check_count->num_rows;  //0 1
	if($check_rate_count > 0){
		$check_count->bind_result($count);
		$check_count->fetch();
	}
	$mysqli->close();
	return $count;
}

function getTodaySuperLikeCount($user_id_post){
	include('con1.php');
	$count = 0;
	$createdate = date('Y-m-d'); 
	$check_count =$mysqli->prepare("SELECT COUNT(`like_id`) as like_count FROM `like_master` WHERE status=2 and `createdate`=?  and user_id=?");
	$check_count->bind_param("si",$createdate,$user_id_post);
	$check_count->execute();
	$check_count->store_result();
	$check_rate_count = $check_count->num_rows;  //0 1
	if($check_rate_count > 0){
		$check_count->bind_result($count);
		$check_count->fetch();
	}
	$mysqli->close();
	return $count;
}



function getPackageDetails($tr_plan){
	include('con1.php');
	$plan_arr = array();
	$chek_plan = $mysqli->prepare("SELECT package_name, amount,reward_amount  FROM `tbl_package` WHERE id=?");
	$chek_plan->bind_param("i", $tr_plan) ; 
	$chek_plan->execute();
	$chek_plan->store_result();
	$check_plan_count = $chek_plan->num_rows;  //0 1
	if($check_plan_count > 0){
		$chek_plan->bind_result($package_name, $amount,$reward_amount);
		$chek_plan->fetch();
		$plan_arr = array(
			'package_name'=>$package_name,
			'amount'=>$amount,
			'reward_amount'=>$reward_amount,
		);
	}

	if(empty($plan_arr)){
		$plan_arr='NA';
	}
	$mysqli->close();
	return $plan_arr;
}

function getPlanDetails($user_id){
	include('con1.php');
	$plan_arr = array();
	$user_plan=$mysqli->prepare("SELECT `up_id`, `up_user`, `up_plan`, `up_planName`, `up_amount`, `up_startdate`, `up_enddate`, `up_status`, `up_update`, `up_create`, `up_transId`, `up_bid`, `up_used_bid`, `bid_type`, `plan_status`, `valid_type`, `used_sms_notification`, `total_sms`, `auto_update`, `auto_renewed`, `is_admin_read` FROM `user_plans` where up_user='".$user_id."' and up_status=1 and DATE(up_enddate) >= DATE('".date('Y-m-d')."') ORDER BY up_id DESC LIMIT 1");
	$user_plan->execute();
	$user_plan->store_result();
	$user_plan_count=$user_plan->num_rows;
	if($user_plan_count > 0){
		$user_plan->bind_result($user_plan_id, $up_user, $user_buy_plan,$up_planName, $up_amount, $up_startdate, $expire_date, $up_status, $up_update, $up_create, $up_transId, $up_bid, $up_used_bid, $bid_type, $plan_status, $valid_type, $used_sms_notification, $total_sms, $auto_update, $auto_renewed, $is_admin_read);
		$user_plan->fetch();
	 	$plan_arr = array(
	 		'up_id'=>$user_plan_id,
	 		'up_user'=>$up_user,
	 		'up_plan'=>$user_buy_plan,
	 		'up_planName'=>$up_planName,
	 		'up_amount'=>$up_amount,
	 		'up_startdate'=>$up_startdate,
	 		'up_enddate'=>$expire_date,
	 		'up_status'=>$up_status,
	 		'up_update'=>$up_update,
	 		'up_create'=>$up_create,
	 		'up_transId'=>$up_transId,
	 		'up_bid'=>$up_bid,
	 		'up_used_bid'=>$up_used_bid,
	 		'bid_type'=>$bid_type,
	 		'plan_status'=>$plan_status,
	 		'valid_type'=>$valid_type,
	 		'used_sms_notification'=>$used_sms_notification,
	 		'total_sms'=>$total_sms,
	 		'auto_update'=>$auto_update,
	 		'auto_renewed'=>$auto_renewed,
	 		'is_admin_read'=>$is_admin_read,
			'expire_date'=>$expire_date,
	 	);  
	}

	if(empty($plan_arr)){
		$plan_arr='NA';
	}
	$mysqli->close();
	return $plan_arr;
}


function getRatingStatus($user_id,$booking_id){
	include('con1.php');
	$rating_status = 'no';
	$check_rating =$mysqli->prepare("SELECT `user_id`, `booking_id` FROM `rating_master` WHERE user_id = ? and booking_id=?");
	$check_rating->bind_param("ii", $user_id,$booking_id);
	$check_rating->execute();
	$check_rating->store_result();
	$check_rate_count = $check_rating->num_rows;  //0 1
	if($check_rate_count > 0){
		$rating_status = 'yes';
	}

	$mysqli->close();
	return $rating_status;
}


function getBlockStatus($user_id_post,$other_user_id){
	include('con1.php');
	$block_status = 2;
	$check_rating =$mysqli->prepare("SELECT  `block_status` FROM `user_block_master` WHERE other_user_id=? and user_id=?");
	$check_rating->bind_param("ii", $other_user_id,$user_id_post);
	$check_rating->execute();
	$check_rating->store_result();
	$check_rate_count = $check_rating->num_rows;  //0 1
	if($check_rate_count > 0){
		$check_rating->bind_result($block_status);
		$check_rating->fetch();
	}

	$mysqli->close();
	return $block_status;
}


function getUserNotificationCount($user_id) {
	include('con1.php');
	$notification_count =   0;      
	$get_user_detail    =   $mysqli->prepare("SELECT nt_id FROM `notification` WHERE `nt_userId`=? AND nt_satus=0  AND action != 'login'");
	$get_user_detail->bind_param("i",$user_id);
	$get_user_detail->execute();
	$get_user_detail->store_result();
	$user_num_rows      =   $get_user_detail->num_rows;  //0 1
	if($user_num_rows > 0){
		$notification_count =   $user_num_rows;
	}
	$mysqli->close();       
	return $notification_count;     
}


function updateNotificationReadStatus($notification_message_id, $delete_type='NA', $user_id='') {
	include('con1.php');

	$notification_update_status =   'yes';
	$read_status    =   1;
	$delete_flag    =   1;
	$updatetime     =   date('Y-m-d H:i:s');        

	if($delete_type=='NA'){         
		$update_all =   $mysqli->prepare("UPDATE `user_notification_message` SET `read_status`=?, `updatetime`=? WHERE `notification_message_id`=? ");
		$update_all->bind_param("isi", $read_status, $updatetime, $notification_message_id);
		$update_all->execute();
		$update_affected_rows   =   $mysqli->affected_rows;
		if($update_affected_rows<=0){   
			$notification_update_status =   'no';
		}
	}
	else if($delete_type=='read_status'){           
		$update_all =   $mysqli->prepare("UPDATE `user_notification_message` SET `read_status`=?, `updatetime`=? WHERE `other_user_id`=? ");
		$update_all->bind_param("isi", $read_status, $updatetime, $user_id);
		$update_all->execute();
		$update_affected_rows   =   $mysqli->affected_rows;
		if($update_affected_rows<=0){   
			$notification_update_status =   'no';
		}
	}
	else if($delete_type=='single'){            
		$update_all =   $mysqli->prepare("UPDATE `user_notification_message` SET `delete_flag`=?, `updatetime`=? WHERE `notification_message_id`=? ");
		$update_all->bind_param("isi", $delete_flag, $updatetime, $notification_message_id);
		$update_all->execute();
		$update_affected_rows   =   $mysqli->affected_rows;
		if($update_affected_rows<=0){   
			$notification_update_status =   'no';
		}
	}
	else if($delete_type=='all'){
		$update_all =   $mysqli->prepare("UPDATE `user_notification_message` SET `delete_flag`=?, `updatetime`=? WHERE `other_user_id`=? ");
		$update_all->bind_param("isi", $delete_flag, $updatetime, $user_id);
		$update_all->execute();
		$update_affected_rows   =   $mysqli->affected_rows;
		if($update_affected_rows<=0){   
			$notification_update_status =   'no';
		}
	}       
	$mysqli->close();       
	return $notification_update_status;     
}


// --------------- get android version start --------------- //
function get_app_version(){
	include('con1.php');
	$get_version = $mysqli->prepare("SELECT app_version_id, browser_version, android_version, ios_version, browser_status, android_status, ios_status FROM app_version_master WHERE delete_flag =0");
	/*$get->bind_param('i',$user_id);*/
	$get_version->execute();
	$get_version->store_result();
	$count = $get_version->num_rows;
	if($count >0) {
		$get_version->bind_result($app_version_id, $browser_version, $android_version, $ios_version, $browser_status, $android_status, $ios_status);
		$get_version->fetch();
		$version_arr = array('app_version_id'=>$app_version_id, 'browser_version'=>$browser_version, 'android_version'=>$android_version, 'ios_version'=>$ios_version, 'browser_status'=>$browser_status, 'android_status'=>$android_status, 'ios_status'=>$ios_status);
	}
	if(empty($version_arr)){
		$version_arr = 'NA';
	}
	$mysqli->close();
	return $version_arr;
}





function getCommitionFee() {
	include('con1.php');
	$price =   0;      
	$get_comission    =   $mysqli->prepare("SELECT `price`  FROM `fees_master` WHERE delete_flag=0");
	$get_comission->execute();
	$get_comission->store_result();
	$comission_rows      =   $get_comission->num_rows;  //0 1
	if($comission_rows > 0){
		$get_comission->bind_result($price);
		$get_comission->fetch();
	}
	$mysqli->close();       
	return $price;     
}

function getbookingComplete(){
	include('con1.php');
	$hours =   0;      
	$get_comission    =   $mysqli->prepare("SELECT `id`, `hours` FROM `booking_end_time_master`");
	$get_comission->execute();
	$get_comission->store_result();
	$comission_rows      =   $get_comission->num_rows;  //0 1
	if($comission_rows > 0){
		$get_comission->bind_result($id,$hours);
		$get_comission->fetch();
	}
	$mysqli->close();       
	return $hours; 
}

//------------------------------trade home-------------------------------------------------------trade home------------------------

///////------------------------Average rating---------------------------------------------------
function getRatingAverage($rt_rateTo)
{
	include('con1.php');
	$select_all = $mysqli->prepare("SELECT AVG(rt_rate) as avg_rating FROM `rating_table` WHERE rt_rateTo=?");
	$select_all->bind_param("i", $rt_rateTo);
	$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($avg_rating);
		$select_all->fetch();
		$avg_rating = round($avg_rating,1);
	}

	if(empty($avg_rating)) {
		$avg_rating = 0;
	}
	$mysqli->close();
	return $avg_rating;
}  

function rateCount($rt_rateTo){
	include('con1.php');

	$ratcountuser  = $mysqli->prepare("SELECT COUNT(tr_id) AS rate_count from rating_table WHERE  rt_rateTo=? ");
	$ratcountuser->bind_param('i', $rt_rateTo);
	$ratcountuser->execute();
	$ratcountuser->store_result();
	$ratcount =  $ratcountuser->num_rows;
	if( $ratcount > 0) {
		$ratcountuser->bind_result($rate_count);
		$ratcountuser->fetch();
	}
	$mysqli->close();
	return $rate_count;

}
//---------------------tradesman port--------------------------------------

function getPortfolio($user_id){
	// SELECT `id`,`userid`,`port_image` FROM `user_portfolio` WHERE`userid`=4
	include('con1.php');
	$select_all = $mysqli->prepare("SELECT id,userid,port_image FROM user_portfolio WHERE userid =?");
	$select_all->bind_param("i", $user_id);
	$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($id,$userid,$port_image);
		while($select_all->fetch()){
			$portfolio[] = array(
				'id'=>$id, 
				'userid'=>$userid, 
				'port_image'=>$port_image, 

			);
		} 
	}
	if(empty($portfolio)) {
		$portfolio = 'NA';
	}
	$mysqli->close();
	return $portfolio;
}
//---------------------job port--------------------------------------
function getjobPortfolio($job_id){
	// echo "SELECT id,userid,post_doc FROM  job_files WHERE job_id =$job_id";
	include('con1.php');
	$select_all = $mysqli->prepare("SELECT id,userid,post_doc,type,job_id FROM  job_files WHERE job_id =?");
	$select_all->bind_param("i", $job_id);
	$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($id,$userid,$port_image,$type,$job_id);
		while($select_all->fetch()){
			$portfolio[] = array(
				'id'=>$id, 
				'userid'=>$userid, 
				'port_image'=>$port_image, 
				'status'=>true,
				'type'=>$type,
				'job_id'=>$job_id,
			);
		} 
	}
	if(empty($portfolio)) {
		$portfolio = 'NA';
	}
	$mysqli->close();
	return $portfolio;
}

//------------------------------------------------------------------------------------------

function getReview($rt_rateTo){
	include('con1.php');
	$rating_arr = array();
	$select_all = $mysqli->prepare("SELECT tr_id,rt_rateBy,rt_rateTo,rt_postid,rt_jobid,rt_rate,rt_comment,rt_create FROM rating_table WHERE rt_rateTo =?");
	$select_all->bind_param("i", $rt_rateTo);
	$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($tr_id,$rt_rateBy,$rt_rateTo,$rt_postid,$rt_jobid,$rt_rate,$rt_comment,$rt_create);
		while($select_all->fetch()){
			$time_ago = timeAgoCustomer($rt_create);
	 

			$title        =   getSingleDataBySql("select trading_name from users where id=".$rt_rateTo.""); 
			$fname        =   getSingleDataBySql("select f_name from users where id=".$rt_rateBy."");
			$lname        =   getSingleDataBySql("select l_name from users where id=".$rt_rateBy."");
			$profile      =   getSingleDataBySql("select profile from users where id=".$rt_rateBy."");
			$job_title    =   getSingleDataBySql("select title from tbl_jobs where job_id=".$rt_jobid."");
			$direct_hired =   getSingleDataBySql("select direct_hired from tbl_jobs where job_id=".$rt_jobid."");
			$main_title = '';
			if($jobTitle['direct_hired']==1){
				$main_title = 'Work for '.$title;
			} else if($job_title!='NA'){
				$main_title= $job_title;
			} else {
				$main_title = 'Work for '.$title;
			}

			$rating_arr[] = array(
				'tr_id'      =>$tr_id, 
				'rt_rateBy'  => $rt_rateBy, 
				'rt_rateTo'  => $rt_rateTo, 
				'rt_postid'  => $rt_postid, 
				'rt_jobid'   => $rt_jobid, 
				'rt_rate'    => $rt_rate, 
				'rt_comment' => $rt_comment, 
				'rt_create'  => $rt_create,  
				'time_ago'   => $time_ago,  
				'trading_name'      => $title,
				'name'       => $fname.' '.$lname,
				'direct_hired'=>$direct_hired,
				'profile'=>$profile,
				'job_title'=>$job_title,
				'main_title'=>$main_title,
			);
		}
	}
	if(empty($rating_arr)) {
		$rating_arr = 'NA';
	}
	$mysqli->close();
	return $rating_arr;
}



function getSingleReview($rt_rateTo){
	include('con1.php');
	$rating_arr = array();
	$select_all = $mysqli->prepare("SELECT tr_id,rt_rateBy,rt_rateTo,rt_postid,rt_jobid,rt_rate,rt_comment,rt_create FROM rating_table WHERE rt_rateTo =? order by tr_id desc LIMIT 1");
	$select_all->bind_param("i", $rt_rateTo);
$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($tr_id,$rt_rateBy,$rt_rateTo,$rt_postid,$rt_jobid,$rt_rate,$rt_comment,$rt_create);
		while($select_all->fetch()){
			$time_ago = timeAgoCustomer($rt_create);
	 

			$title        =   getSingleDataBySql("select trading_name from users where id=".$rt_rateTo.""); 
			$fname        =   getSingleDataBySql("select f_name from users where id=".$rt_rateBy."");
			$lname        =   getSingleDataBySql("select l_name from users where id=".$rt_rateBy."");
			$profile      =   getSingleDataBySql("select profile from users where id=".$rt_rateBy."");
			$job_title    =   getSingleDataBySql("select title from tbl_jobs where job_id=".$rt_jobid."");
			$direct_hired =   getSingleDataBySql("select direct_hired from tbl_jobs where job_id=".$rt_jobid."");
			$main_title = '';
			if($jobTitle['direct_hired']==1){
				$main_title = 'Work for '.$title;
			} else if($job_title!='NA'){
				$main_title= $job_title;
			} else {
				$main_title = 'Work for '.$title;
			}
		$read_more = false;
		if(strlen($rt_comment) > 120){
			$read_more = true;
			$rt_comment = substr($rt_comment,0,120);
		}
			$rating_arr = array(
				'tr_id'      =>$tr_id, 
				'rt_rateBy'  => $rt_rateBy, 
				'rt_rateTo'  => $rt_rateTo, 
				'rt_postid'  => $rt_postid, 
				'rt_jobid'   => $rt_jobid, 
				'rt_rate'    => $rt_rate, 
				'rt_comment' => $rt_comment, 
				'rt_create'  => $rt_create,  
				'rt_create1'=>date('d-M-y',strtotime($rt_create)),
				'time_ago'   => $time_ago,  
				'trading_name'      => $title,
				'name'       => $fname.' '.$lname,
				'read_more'=>$read_more,
				'direct_hired'=>$direct_hired,
				'profile'=>$profile,
				'job_title'=>$job_title,
				'main_title'=>$main_title,
			);
		}
	}
	if(empty($rating_arr)) {
		$rating_arr = 'NA';
	}
	$mysqli->close();
	return $rating_arr;
}



function getSkills($skill_ids){
	include('con1.php');
	$cat_arr = array();
	if($skill_ids!=null){
		$getCounty=$mysqli->prepare("SELECT `cat_id`, `cat_name`, `slug`, `cat_parent`, `cat_description`, `description`, `cat_image`, `meta_title`, `meta_description` FROM `category` WHERE cat_parent=0 and is_delete=0 and is_activate=1 and cat_id IN($skill_ids) order by cat_name asc");
		$getCounty->execute();
		$getCounty->store_result();
		$getCounty_count=$getCounty->num_rows;  //0 1   
		if($getCounty_count > 0){
			$getCounty->bind_result($cat_id, $cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);
			while ($getCounty->fetch()) {
				$cat_arr[] = array(
					'cat_id'=>$cat_id, 
					'cat_name'=>$cat_name, 
					'slug'=>$slug, 
					'cat_parent'=>$cat_parent, 
					'cat_description'=>$cat_description, 
					'cat_image'=>$cat_image, 
					'meta_title'=>$meta_title, 
					'meta_description'=>$meta_description, 
					'status'=>false,
				);
			}
		}    
	}

	if(empty($cat_arr)) {
		$cat_arr = 'NA';
	}
	$mysqli->close();
	return $cat_arr;
}


//------------------------------fewdetail---------------------------------------
function getownerDetails($user_id){
	include('con1.php');
	// echo "SELECT `id`, `f_name`, `l_name`, `trading_name`, `business_address`, `county`, `city`, `cdate`, `postal_code`, `average_rate`, `u_address`, `e_address`, `locality` FROM `users` WHERE id=$user_id and type=1";
	$check_data_all =$mysqli->prepare("SELECT id, f_name, l_name, trading_name, business_address, county, city, cdate, postal_code, average_rate, u_address, e_address, locality,profile FROM users WHERE id=?");
	$check_data_all->bind_param("i", $user_id);
	// $check_data_all->bind_param("i", $user_id);
	$check_data_all->execute();
	$check_data_all->store_result();
	$check_data = $check_data_all->num_rows;  //0 1
	if($check_data > 0)
	{
		$check_data_all->bind_result($id,$f_name, $l_name, $trading_name, $business_address, $county, $city,$cdate, $postal_code, $average_rate, $u_address, $e_address, $locality,$profile);
		$check_data_all->fetch();  
		$city =  ($city!=null)? $city : 'NA';
		$county =  ($county!=null)? $county : 'NA';

		if(empty($profile)){
			$profile = "NA";
		}

		$since=date('M Y', strtotime($cdate));
		$avg_rate=getRatingAverage($user_id);
		$rate_count=rateCount($user_id);
		if(empty($avg_rate)){
			$avg_rate = 0;
		}
		if(empty($rate_count)){
			$rate_count = 0;
		}
		$name = $f_name.' '.$l_name;
		$user_arr = array(
			'id'                 =>  $id, 
			'name'               =>  $name, 
			'f_name'             =>  $f_name, 
			'l_name'             =>  $l_name, 
			'trading_name'       =>  $trading_name,
			'type'               =>  $type,
			'about_business'     =>  $about_business,
			'business_address'   =>  $business_address,
			'county'             =>  $county,
			'city'               =>  $city,
			'cdate'              =>  $cdate,
			'postal_code'        =>  $postal_code,
			'average_rate'       =>  $avg_rate,
			'since'              =>  $since,
			'profile'            =>  $profile,
			'rate_count'          =>  $rate_count,


		);    
	}
	if(empty($user_arr)){
		$user_arr = "NA";
	}
	$mysqli->close();
	return $user_arr;
}
//-------------------Single data-----------------------------------------------------
function getSingleData($key, $tablename, $where) {
	include 'con1.php';   
	//echo "SELECT $key FROM $tablename WHERE $where";
	//exit();
	$find_count     =   $mysqli->prepare("SELECT $key FROM $tablename WHERE $where");

	$find_count->execute();
	$find_count->store_result();
	$select_all     =   $find_count->num_rows;
	if($select_all>0)
	{
		$find_count->bind_result($key);
		$find_count->fetch();
		if($key==null || $key==0){
			$key    =   'NA';
		}
	}
	else{
		$key        =   'NA'; 
	}
	$mysqli->close();
	return $key;
}

function updatesingledata($key, $tablename, $where) {
	include 'con1.php';   
//	echo "UPDATE $tablename SET $key  WHERE $where";
//	exit();
	$update     =   $mysqli->prepare("UPDATE $tablename SET $key  WHERE $where");
	$update->execute();
	$update_affect_row=$mysqli->affected_rows;
	$mysqli->close();
	//echo $update_affect_row;
	return $update_affect_row;
}

function updatesingledata12($sql) {
	include 'con1.php';   
	$update     =   $mysqli->prepare($sql);
	$update->execute();
	$update_affect_row=$mysqli->affected_rows;
	$mysqli->close();
	return $update_affect_row;
}



function getSingleDataBySql($sql) {
	include 'con1.php';   
//echo  $sql;
//exit();
	$find_count     =   $mysqli->prepare($sql);
	$find_count->execute();
	$find_count->store_result();
	$select_all     =   $find_count->num_rows;
	if($select_all>0)
	{
		$find_count->bind_result($key);
		$find_count->fetch();
		if($key==null && $key !=0){
			$key    =   'NA';
		}
	}
	else{
		$key        =   'NA'; 
	}
	$mysqli->close();
	return $key;
}




function getReviewJob($rt_rateBy,$job_id){
	include('con1.php');
	$rating_arr = array();
	//echo $job_id;
	//exit();
	$select_all = $mysqli->prepare("SELECT tr_id,rt_rateBy,rt_rateTo,rt_postid,rt_jobid,rt_rate,rt_comment,rt_create FROM rating_table WHERE rt_rateBy =? and rt_jobid=?");
	$select_all->bind_param("ii", $rt_rateBy,$job_id);
	$select_all->execute();
	$select_all->store_result();
	$select = $select_all->num_rows;
	if($select > 0) {
		$select_all->bind_result($tr_id,$rt_rateBy,$rt_rateTo,$rt_postid,$rt_jobid,$rt_rate,$rt_comment,$rt_create);
		while($select_all->fetch()){
			$time_ago = timeAgoCustomer($rt_create);
			$title  =   getSingleDataBySql("select trading_name from users where id=".$rt_rateBy.""); 
			$fname  =   getSingleDataBySql("select f_name from users where id=".$rt_rateBy."");
			$lname  =   getSingleDataBySql("select l_name from users where id=".$rt_rateBy."");
			$profile  =   getSingleDataBySql("select profile from users where id=".$rt_rateBy."");
			$rating_arr = array(
				'tr_id'=>$tr_id, 
				'rt_rateBy'  => $rt_rateBy, 
				'rt_rateTo'  => $rt_rateTo, 
				'rt_postid'  => $rt_postid, 
				'rt_jobid'   => $rt_jobid, 
				'rt_rate'    => $rt_rate, 
				'rt_comment' => $rt_comment, 
				'rt_create'  => $rt_create,  
				'time_ago'   => $time_ago,  
				'trading_name'      => $title,
				'name'       => $fname.' '.$lname,
				'profile'=>$profile,
			);
		}
	}
	if(empty($rating_arr)) {
		$rating_arr = 'NA';
	}
	$mysqli->close();
	return $rating_arr;
}


//===========Wallet Amount================
function getToCreditAmount($user_id_post){
	include('con1.php');
	$amount =  0;
	$get_CreditAmount =$mysqli->prepare("SELECT SUM(`tr_amount`) FROM `transactions` WHERE tr_type=1 and tr_userid=?");
	$get_CreditAmount->bind_param("i", $user_id_post);
	$get_CreditAmount->execute();
	$get_CreditAmount->store_result();
	$get_CreditAmount_row = $get_CreditAmount->num_rows;  //0 1
	if($get_CreditAmount_row > 0){
		$get_CreditAmount->bind_result($amount);
		$get_CreditAmount->fetch();
		if($amount==null){
			$amount=0;
		}
	}
	$mysqli->close();
	return $amount;
}

function getToDebitAmount($user_id_post){
	include('con1.php');
	$amount =  0;
	$get_DebitAmount =$mysqli->prepare("SELECT SUM(`tr_amount`) FROM `transactions` WHERE tr_type=2 and tr_userid=?");
	$get_DebitAmount->bind_param("i", $user_id_post);
	$get_DebitAmount->execute();
	$get_DebitAmount->store_result();
	$get_DebitAmount_row = $get_DebitAmount->num_rows;  //0 1
	if($get_DebitAmount_row > 0){
		$get_DebitAmount->bind_result($amount);
		$get_DebitAmount->fetch();
		if($amount==null){
			$amount=0;
		}
	}
	$mysqli->close();
	return $amount;
}

function getWalletBalance($user_id_post){
	$credit  = getToCreditAmount($user_id_post);
	$debit   = getToDebitAmount($user_id_post);
	$tot = $credit - $debit;
	return $tot;
}   


function getTotalBuyBids($user_id_post){
	include('con1.php');
	$sum =  0;
	$getTotBuyBids =$mysqli->prepare("SELECT sum(`up_bid`) FROM `user_plans` WHERE `up_user`=?");
	$getTotBuyBids->bind_param("i", $user_id_post);
	$getTotBuyBids->execute();
	$getTotBuyBids->store_result();
	$getTotBuyBids_row = $getTotBuyBids->num_rows;  //0 1
	if($getTotBuyBids_row > 0){
		$getTotBuyBids->bind_result($sum);
		$getTotBuyBids->fetch();
		if($sum==null){
			$sum=0;
		}
	}
	$mysqli->close();
	return $sum;
}
function getTotalExpenditureBids($user_id_post){
	include('con1.php');
	$sum =  0;
	$getTotBuyBids =$mysqli->prepare("SELECT sum(`up_used_bid`) FROM `user_plans` WHERE `up_user`=?");
	$getTotBuyBids->bind_param("i", $user_id_post);
	$getTotBuyBids->execute();
	$getTotBuyBids->store_result();
	$getTotBuyBids_row = $getTotBuyBids->num_rows;  //0 1
	if($getTotBuyBids_row > 0){
		$getTotBuyBids->bind_result($sum);
		$getTotBuyBids->fetch();
		if($sum==null){
			$sum=0;
		}
	}
	$mysqli->close();
	return $sum;
}

function getBidsAvg($job_id){
	include('con1.php');
	$avg =  0;
	$getAvgBids =$mysqli->prepare("SELECT AVG(bid_amount) FROM `tbl_jobpost_bids` WHERE `job_id`=?");
	$getAvgBids->bind_param("i", $job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($avg);
		$getAvgBids->fetch();
		if($avg==null){
			$avg=0;
		}
	}
	$mysqli->close();
	return $avg;
}

function getBidsCount($job_id){
	include('con1.php');
	$count =  0;
	$getAvgBids =$mysqli->prepare("SELECT count(job_id) FROM `tbl_jobpost_bids` WHERE job_id=?");
	$getAvgBids->bind_param("i", $job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($count);
		$getAvgBids->fetch();
		if($count==null){
			$count=0;
		}
	}
	$mysqli->close();
	return $count;
}

function checkProviderBid($job_id,$user_id){
	include('con1.php');
	$status =  -1;
	$getAvgBids =$mysqli->prepare("SELECT status FROM `tbl_jobpost_bids` WHERE bid_by=? and job_id=?");
	$getAvgBids->bind_param("ii",$user_id,$job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($status);
		$getAvgBids->fetch();
	}
	$mysqli->close();
	return $status;
}


function checkJobBidDetails($job_id){
	include('con1.php');
	$awarded_status = 'no';
	$getAvgBids =$mysqli->prepare("SELECT status FROM `tbl_jobpost_bids` WHERE job_id=?");
	$getAvgBids->bind_param("i",$job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($status);
		while($getAvgBids->fetch()){
			if($status>0){
				$awarded_status = 'yes';
			}
		}
	}
	$mysqli->close();
	return $awarded_status;
}

function getMileStoneAMOUNTtoatal($bid_id){
	include('con1.php');
	$total =  0;
	$getAvgBids =$mysqli->prepare("SELECT SUM(milestone_amount) as amount FROM `tbl_milestones` where bid_id=$bid_id");
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($total);
		$getAvgBids->fetch();
	}
	if($total==null){
		$total=0;
	}
	return $total;
}



function getMileStone($bid_id,$type){
	include('con1.php');
	$milestone_arr =  array();
	if($type=='all'){
		$getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE bid_id=?");
	}else if($type=='suggested'){
		$getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE bid_id=? and is_suggested=1");
	}else{
		$getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE bid_id=? and is_suggested=0");
	}
	
	$getAvgBids->bind_param("i",$bid_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested);
		while ($getAvgBids->fetch()) {
			$milestone_arr[] = array(
				 'id'=> $id,
				 'milestone_name'=> $milestone_name,
				 'milestone_amt'=> $milestone_amount,
				 'userid'=> $userid,
				 'post_id'=> $post_id,
				 'cdate'=> $cdate,
				 'status'=> $status, 
				 'posted_user'=> $posted_user,
				 'created_by'=> $created_by,
				 'reason_cancel'=> $reason_cancel,
				 'dct_image'=> $dct_image,
				 'decline_reason'=> $decline_reason,
				 'bid_id'=> $bid_id,
				 'is_requested'=> $is_requested,
				 'is_dispute_to_traders'=> $is_dispute_to_traders,
				 'is_suggested'=> $is_suggested,
			);
		}
	}
	
	if(empty($milestone_arr)){
		$milestone_arr='NA';
	}
	
	$mysqli->close();
	return $milestone_arr;
}

function getMileStoneHomeOwner($bid_id,$created_by,$job_id,$user_id1=0){
	include('con1.php');
	$milestone_arr =  array();
	
	$getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`,`dispute_id` FROM `tbl_milestones` WHERE bid_id=? and created_by=? and post_id=? order by id desc");
	
	$getAvgBids->bind_param("iii",$bid_id,$created_by,$job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested, $dispute_id);
		while ($getAvgBids->fetch()) {
			$disputed_status = getDisputedStatus($id,$user_id1);

			$milestone_arr[] = array(
				 'id'=> $id,
				 'milestone_name'=> $milestone_name,
				 'milestone_amt'=> $milestone_amount,
				 'userid'=> $userid,
				 'post_id'=> $post_id,
				 'disputed_status'=>$disputed_status,
				 'cdate'=> $cdate,
				 'status'=> $status, 
				 'posted_user'=> $posted_user,
				 'created_by'=> $created_by,
				 'reason_cancel'=> $reason_cancel,
				 'dct_image'=> $dct_image,
				 'decline_reason'=> $decline_reason,
				 'bid_id'=> $bid_id,
				 'is_requested'=> $is_requested,
				 'is_dispute_to_traders'=> $is_dispute_to_traders,
				 'is_suggested'=> $is_suggested,
				 'dispute_id'=>$dispute_id,
			);
		}
	}
	
	if(empty($milestone_arr)){
		$milestone_arr='NA';
	}
	
	$mysqli->close();
	return $milestone_arr;
}
function getMileStoneHomeOwner1($bid_id){
	include('con1.php');
	$milestone_arr =  array();
	
	$getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`,`dispute_id` FROM `tbl_milestones` WHERE  id=? and is_requested=1 order by id desc");
	
	$getAvgBids->bind_param("i",$bid_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested, $dispute_id);
		while ($getAvgBids->fetch()) {
			$milestone_arr[] = array(
				 'id'=> $id,
				 'milestone_name'=> $milestone_name,
				 'milestone_amt'=> $milestone_amount,
				 'userid'=> $userid,
				 'post_id'=> $post_id,
				 'cdate'=> $cdate,
				 'status'=> $status, 
				 'posted_user'=> $posted_user,
				 'created_by'=> $created_by,
				 'reason_cancel'=> $reason_cancel,
				 'dct_image'=> $dct_image,
				 'decline_reason'=> $decline_reason,
				 'bid_id'=> $bid_id,
				 'is_requested'=> $is_requested,
				 'is_dispute_to_traders'=> $is_dispute_to_traders,
				 'is_suggested'=> $is_suggested,
				'dispute_id'=>$dispute_id,
			);
		}
	}
	
	if(empty($milestone_arr)){
		$milestone_arr='NA';
	}
	
	$mysqli->close();
	return $milestone_arr;
}

function getMileStoneById($milestone_id){
	include('con1.php');
	$milestone_arr =  array();
	$getMileStone =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`, `dispute_id` FROM `tbl_milestones` WHERE  id=?");
	$getMileStone->bind_param("i",$milestone_id);
	$getMileStone->execute();
	$getMileStone->store_result();
	$getMileStone_row = $getMileStone->num_rows;  //0 1
	if($getMileStone_row > 0){
		$getMileStone->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested, $dispute_id);
		$getMileStone->fetch();
		$milestone_arr = array(
			 'id'=> $id,
			 'milestone_name'=> $milestone_name,
			 'milestone_amt'=> $milestone_amount,
			 'userid'=> $userid,
			 'post_id'=> $post_id,
			 'cdate'=> $cdate,
			 'status'=> $status, 
			 'posted_user'=> $posted_user,
			 'created_by'=> $created_by,
			 'reason_cancel'=> $reason_cancel,
			 'dct_image'=> $dct_image,
			 'decline_reason'=> $decline_reason,
			 'bid_id'=> $bid_id,
			 'is_requested'=> $is_requested,
			 'is_dispute_to_traders'=> $is_dispute_to_traders,
			 'is_suggested'=> $is_suggested,
			 'dispute_id'=>$dispute_id,
		);
	}
	
	if(empty($milestone_arr)){
		$milestone_arr='NA';
	}
	
	$mysqli->close();
	return $milestone_arr;
}

function getRefferalCount($user_id,$type){
  include('con1.php');
   $earn_status=1;
  $jb =	$mysqli->prepare("SELECT count(*) as total_earning FROM `referrals_earn_list` WHERE user_id=? AND referred_type=? AND earn_status=?");
  $jb->bind_param("iii",$user_id,$type,$earn_status);
  $jb->execute();
  $jb->store_result();
  $jb->bind_result($total_earning);	
  $jb->fetch(); 
  return $total_earning; 

}

function getMileStoneByUserId($status,$user_id,$user_type){
	include('con1.php');
	$milestone_arr =  array();
	$column = ($user_type==1) ? 'userid' : 'posted_user';
	$getMileStone =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`, `dispute_id` FROM `tbl_milestones` WHERE status=? AND $column=?");
	$getMileStone->bind_param("ii",$status,$user_id);
	$getMileStone->execute();
	$getMileStone->store_result();
	$getMileStone_row = $getMileStone->num_rows;  //0 1
	if($getMileStone_row > 0){
		$getMileStone->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested, $dispute_id);
		$getMileStone->fetch();
		$milestone_arr = array(
			 'id'=> $id,
			 'milestone_name'=> $milestone_name,
			 'milestone_amt'=> $milestone_amount,
			 'userid'=> $userid,
			 'post_id'=> $post_id,
			 'cdate'=> $cdate,
			 'status'=> $status, 
			 'posted_user'=> $posted_user,
			 'created_by'=> $created_by,
			 'reason_cancel'=> $reason_cancel,
			 'dct_image'=> $dct_image,
			 'decline_reason'=> $decline_reason,
			 'bid_id'=> $bid_id,
			 'is_requested'=> $is_requested,
			 'is_dispute_to_traders'=> $is_dispute_to_traders,
			 'is_suggested'=> $is_suggested,
			 'dispute_id'=>$dispute_id,
		);
	}
	
	if(empty($milestone_arr)){
		$milestone_arr=0;
	}
	
	$mysqli->close();
	return $milestone_arr;
}


function getDisputedStatus($mile_id,$dispute_id){
	include('con1.php');
	$flag =  0;
	$getTotBuyBids =$mysqli->prepare("SELECT ds_id FROM `tbl_dispute` WHERE `mile_id`=? and disputed_by=?");
	$getTotBuyBids->bind_param("ii", $mile_id,$dispute_id);
	$getTotBuyBids->execute();
	$getTotBuyBids->store_result();
	$getTotBuyBids_row = $getTotBuyBids->num_rows;  //0 1
	if($getTotBuyBids_row > 0){
		$getTotBuyBids->bind_result($ds_id);
		$getTotBuyBids->fetch();
		 $flag=$ds_id;
	}	
	$mysqli->close();
	return $flag;
}

function getChatPaid($user_id,$post_id){
	include('con1.php');
	$flag =  'no';
	$get_chat_paid =$mysqli->prepare("SELECT `id` FROM `chat_paid` WHERE user_id=? and post_id=?");
	$get_chat_paid->bind_param("ii", $user_id,$post_id);
	$get_chat_paid->execute();
	$get_chat_paid->store_result();
	$get_chat_paid_row = $get_chat_paid->num_rows;  //0 1
	if($get_chat_paid_row > 0){
		$flag='yes';
	}	
	$mysqli->close();
	return $flag;
}

function getJobFiles($job_id){
	include('con1.php');
 	$job_file_arr = array();
	$get_job_details =$mysqli->prepare("SELECT `id`, `job_id`, `post_doc`, `userid`, `type` FROM `job_files` WHERE job_id=?");
	$get_job_details->bind_param("i", $job_id);
	$get_job_details->execute();
	$get_job_details->store_result();
	$get_job_details_row = $get_job_details->num_rows;  //0 1
	if($get_job_details_row > 0){
		$get_job_details->bind_result($id, $job_id, $post_doc, $userid, $type);
		while($get_job_details->fetch()){
		  $job_file_arr = array(
			'id'=>$id,
			'job_id'=>$job_id,
			'post_doc'=>$post_doc,
			'userid'=>$userid,
			'type'=>$type,
		  );
		}
	}	

	if(empty($job_file_arr)){
		$job_file_arr = 'NA';
	}
	$mysqli->close();
	return $job_file_arr;
}

function getdisputconversation($dispute_id){
	include('con1.php');
 	$job_file_arr      = array();
	$get_job_details   = $mysqli->prepare("SELECT `dct_id`, `dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`, `dct_created`, `dct_update`, `mile_id`, `dct_image`, `message_to`, `is_reply_pending`, `end_time` FROM `disput_conversation_tbl` WHERE dct_disputid=? order by dct_id desc");
	$get_job_details->bind_param("i", $dispute_id);
	$get_job_details->execute();
	$get_job_details->store_result();
	$get_job_details_row = $get_job_details->num_rows;  //0 1
	if($get_job_details_row > 0){
		$get_job_details->bind_result($dct_id, $dct_disputid, $dct_userid, $dct_msg, $dct_isfinal, $dct_created, $dct_update, $mile_id, $dct_image, $message_to, $is_reply_pending, $end_time);
		while($get_job_details->fetch()){
		  $job_file_arr[] = array(
			'dct_id'=>$dct_id,
			'dct_disputid'=>$dct_disputid,
			'dct_userid'=>$dct_userid,
			'dct_msg'=>$dct_msg,
			'dct_isfinal'=>$dct_isfinal,
			'dct_created'=>$dct_created,
			'dct_update'=>$dct_update,
			'mile_id'=>$mile_id,
			'dct_image'=>$dct_image,
			'message_to'=>$message_to,
			'is_reply_pending'=>$is_reply_pending,
			'end_time'=>$end_time,
		  );
		}
	}	

	if(empty($job_file_arr)){
		$job_file_arr = 'NA';
	}
	$mysqli->close();
	return $job_file_arr;
}

function checkOtherUserReply($dispute_id,$dispute_to){
include('con1.php');
 	$dis_conv_arr      = array();
	$get_job_details   = $mysqli->prepare("SELECT `dct_id`, `dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`, `dct_created`, `dct_update`, `mile_id`, `dct_image`, `message_to`, `is_reply_pending`, `end_time` FROM `disput_conversation_tbl` WHERE dct_disputid=? AND dct_userid=? order by dct_id ASC");
	$get_job_details->bind_param("ii", $dispute_id, $dispute_to);
	$get_job_details->execute();
	$get_job_details->store_result();
	$get_job_details_row = $get_job_details->num_rows;  //0 1
	if($get_job_details_row > 0){
		$get_job_details->bind_result($dct_id, $dct_disputid, $dct_userid, $dct_msg, $dct_isfinal, $dct_created, $dct_update, $mile_id, $dct_image, $message_to, $is_reply_pending, $end_time);
		$get_job_details->fetch();
		  $dis_conv_arr = array(
			'dct_id'=>$dct_id,
			'dct_disputid'=>$dct_disputid,
			'dct_userid'=>$dct_userid,
			'dct_msg'=>$dct_msg,
			'dct_isfinal'=>$dct_isfinal,
			'dct_created'=>$dct_created,
			'dct_update'=>$dct_update,
			'mile_id'=>$mile_id,
			'dct_image'=>$dct_image,
			'message_to'=>$message_to,
			'is_reply_pending'=>$is_reply_pending,
			'end_time'=>$end_time,
		  );
		
	}	

	if(empty($dis_conv_arr)){
		$dis_conv_arr = 'NA';
	}
	$mysqli->close();
	return $dis_conv_arr;
}





function time_ago($timestamp){  
	$time_ago = strtotime($timestamp);  
	$current_time = time();  
	$time_difference = $current_time - $time_ago;  
	$seconds = $time_difference;  
	$minutes = round($seconds / 60 );// value 60 is seconds  
	$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
	$days = round($seconds / 86400); //86400 = 24 * 60 * 60;  
	$weeks = round($seconds / 604800);// 7*24*60*60;  
	$months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
	$years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
	if($seconds <= 60)  {  
		return "Just Now";  
	}  
	else if($minutes <=60)  
	{  
		if($minutes==1)  {  
			return "one minute ago";  
		}  
		else  {  
		 return "$minutes minutes ago";  
		}  
	}  
	else if($hours <=24)  
	{  
		if($hours==1)  {  
			return "an hour ago";  
		}  
		else  {  
			return "$hours hrs ago";  
		}  
	}  
	else if($days <= 7)  
	{  
		if($days==1)  {  
			return "yesterday";  
		}  else  {  
			return "$days days ago";  
		}  
	}  
	else if($weeks <= 4.3) //4.3 == 52/12  
	{  
		if($weeks==1)  {  
		 return "a week ago";  
		}  else  {  
			return "$weeks weeks ago";  
		}  
	}  
	else if($months <=12)  
	{  
		if($months==1)  {  
			return "a month ago";  
		}  else  {  
			return "$months months ago";  
		}  
	}  else  {  
		if($years==1)  {  
			return "one year ago";  
		}  else  {  
			return "$years years ago";  
		}  
	}  
}


function check_postalcode($postcode){
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "http://api.postcodes.io/postcodes/".$postcode,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	
	$return = array();

	if ($err) {
		$return['status'] = 0;
		$return['data'] = "cURL Error #:" . $err; 
	} else {
		
		$response = json_decode($response);
		
		//echo '<pre>'; print_r($response); echo '</pre>';
		
		if($response->status=='200'){
			
			$admin_county = $response->result->admin_county;
			
			if(!$admin_county){
				$admin_county = $response->result->region;
			}
			
			$return['longitude'] = $response->result->longitude;
			$return['latitude'] = $response->result->latitude;
			$return['primary_care_trust'] = $response->result->admin_district;
			$return['country'] = $admin_county;
			$return['address'] = $response->result->european_electoral_region;
			$return['region'] = $response->result->region;
			$return['status'] = 1;
		} else {
			$return['status'] = 0;
			$return['msg'] = "Please enter valid UK postcode";
		}
		
		
	}
	
	return $return; 
}

function  getColumnValue($query){
	include('con1.php');
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if(empty($row)){
		$row = 'NA';
	}
	return $row;
}

function check_sms_notification($user_id){
	include('con1.php');
	$return =false;
	$user_arr =  getUserDetails($user_id);
	if($user_arr!="NA" && $user_arr['is_phone_verified']==1 && $user_arr['type']==1){
		$user_plan = getPlanDetails($user_id);

		if($user_plan!='NA'){
			$plan_id = $user_plan['up_plan'];
			$package_arr = getColumnValue("select id, total_notification from tbl_package where id=$plan_id and sms_notification=1");
			if($package_arr!='NA'){
				if($user_plan['total_sms'] > $user_plan['used_sms_notification']){
					$return = $user_arr['phone_no'];
				}
			}
		}
	}
	$mysqli->close();
	return $return;
}

function date_difference($date1,$date2){
	  if(!$date1){
			$date1  = date('Y-m-d H:i:s');
		}
        if(!$date2){
			$date2  = date('Y-m-d H:i:s');
		}
		$diff = strtotime($date2) - strtotime($date1);
        $days = floor($diff / 86400);
		$hours = floor(($diff % 86400) / 3600);
		$minutes = floor(($diff % 3600) / 60);
	    $time_arr = array(
			             'days' => $days > 0 ? $days : 0,
			              'hours' => $hours > 0 ? $hours : 0,
			              'minutes' => $minutes > 0 ? $minutes : 0,
		                 );
		return $time_arr;
	}

function check_email_notification($user_id,$post_id=0){
	include('con1.php');
	$return = false;
	$user_arr =  getUserDetails($user_id);
	if($user_arr!='NA'){
		$return['email']  = $is_phone_verified['email'];
		$return['f_name'] = $is_phone_verified['f_name'];
		$return['l_name'] = $is_phone_verified['l_name'];
		$return['trading_name'] = $is_phone_verified['trading_name'];
		$return['type']   = $is_phone_verified['type'];
	}

	$mysqli->close();
	return $return;
}
 

function get_profile_loop($user_id=null,$job_id=null,$price=null,$sender=null){
	include('con1.php');
		$userdata = getColumnValue("select trading_name, city,county,cdate,total_reviews,average_rate,profile from users where id=$user_id");
		
		$profile = $website_url.'img/profile/dummy_profile.jpg';
		
		if($userdata['profile']){
			$profile = $website_url.'img/profile/'.$userdata['profile'];
		}
		
		$html = '<tr>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; width: 100px; vertical-align: top;" >
							<img src="'.$profile.'" style="width: 100%; height: 122px; object-fit: cover; border-radius: 5px;">
						</td>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; color: #464c5b; vertical-align: top;">
							<span style="font-size: 20px; font-weight: 600; display: inline-block; margin-bottom: 7px;">'.$userdata['trading_name'].'</span><br>
							<span style="font-size: 15px; display: inline-block; margin-bottom: 7px;"><img src="https://www.tradespeoplehub.co.uk/img_us_1.png" style="margin-right: 5px; vertical-align: middle;"> '.$userdata['city'].', '.$userdata['county'].' </span><br>
							<span style="font-size: 15px; display: inline-block; margin-bottom: 7px;"><img src="https://www.tradespeoplehub.co.uk/img_us_2.png" style="margin-right: 5px; vertical-align: middle;">  Member since '.date('M Y',strtotime($userdata['cdate'])).'  </span><br>
							<span style="font-size: 14px; display: inline-block; margin-bottom: 7px;">
								<span style="background: #e77803; color: #fff; display: inline-block; padding: 2px 6px; border-radius: 3px;">'.$userdata['average_rate'].'</span> <img src="https://www.tradespeoplehub.co.uk/star_active'.$userdata['average_rate'].'.png" style=" vertical-align: middle;"> ('.$userdata['total_reviews'].' reviews)
							</span>

						</td>
						<td style="border-top:2px solid #2875d7; padding:15px 10px; text-align: center;">
							<span style="font-size: 18px; display: inline-block; margin-bottom: 10px;">£'.$price.'</span>
							<br>
							<a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Chat</a>
							<a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">Award</a>
						</td>
					</tr>';
		return $html;
	}

function earn_refer_to_tradsman($user_id){
	include('con1.php');
	$invited = getreferralsearndetails($user_id); 
if ($invited!='NA') {
	$referred_type = $invited['referred_type'];
	$referred_by = $invited['referred_by'];	
    $referred_by_user = getUserDetails($referred_by);	
	if ($referred_by_user!='NA') {
		if ($referred_type == 1) { //invited by tradesmen
			        $admin_id=3;
					$setting = adminsettings($admin_id);
				} else if ($referred_type == 2) { //invited by homeowners
			        $admin_id=2;
					$setting = adminsettings($admin_id);
				} else if ($referred_type == 3) { //invited by marketer
			        $admin_id=1;
					$setting = adminsettings($admin_id);
				} else {
					$setting = false;
				}
		if ($setting) {
			$min_quotes = $setting['min_quotes_approved_tradsman'];
		    $comission = $setting['comission_ref_tradsman'];
			$bid_all	=	$mysqli->prepare("SELECT count(id) as total from tbl_jobpost_bids where bid_by=?");
		$bid_all->bind_param("i",$user_id);
		$bid_all->execute();
		$bid_all->store_result();
		$check_bid		=	$bid_all->num_rows;  //0 1
		if($check_bid <= 0){
			$record		=	array('success'=>'false', 'msg'=>'total count not found'); 
			jsonSendEncode($record);
		}
		$bid_all->bind_result($checkBidCount);
		$bid_all->fetch();
		
			if ($checkBidCount) {
				$applyBid = $checkBidCount * 1;
				if ($applyBid >= $min_quotes) {
							$earn_status = 1;
							$earn_amount = $comission;
							$invited_id = $invited['id']; 
 $update3 = $mysqli->prepare('UPDATE `referrals_earn_list` SET `earn_status`=?,`earn_amount`=? WHERE id=?');	
$update3->bind_param('isi',$earn_status,$earn_amount,$invited_id);
$update3->execute();					
					
	 $referral_earning = $referred_by_user['referral_earning'] + $comission;
 
//// Update User Refferal
 $update4 = $mysqli->prepare('UPDATE `users` SET `referral_earning`=? WHERE id=?');	
$update4->bind_param('si',$referral_earning,$referred_by);
$update4->execute();	
					
						 
				 }
			}
			
			
		}
		
	}
 }

}

function earn_refer_to_homeowner($posted_by){
	include('con1.php');
	$invited = getreferralsearndetails($posted_by); 
if ($invited!='NA') {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];
	
$referred_by_user = getUserDetails($referred_by);	
	if ($referred_by_user!='NA') {
		if ($referred_type == 1) { //invited by tradesmen
			$admin_id=3;
			$setting = adminsettings($admin_id);
		} else if ($referred_type == 2) { //invited by homeowners
			$admin_id=2; 
			$setting = adminsettings($admin_id);
		} else if ($referred_type == 3) { //invited by marketer
			$admin_id=1;
			$setting = adminsettings($admin_id);
		} else {
			$setting = false;
		}
		
		if ($setting) {
			$min_quotes = $setting['min_quotes_received_homeowner'];
			$comission = $setting['comission_ref_homeowner'];
			$bid_all	=	$mysqli->prepare("SELECT count(id) as total from tbl_jobpost_bids where posted_by=?");
		$bid_all->bind_param("i",$posted_by);
		$bid_all->execute();
		$bid_all->store_result();
		$check_bid		=	$bid_all->num_rows;  //0 1
		if($check_bid <= 0){
			$record		=	array('success'=>'false', 'msg'=>'total count not found'); 
			jsonSendEncode($record);
		}
		$bid_all->bind_result($checkBidCount);
		$bid_all->fetch();
		
			if ($checkBidCount) {
				$applyBid = $checkBidCount * 1;
				if ($applyBid >= $min_quotes) {
							$earn_status = 1;
							$earn_amount = $comission;
							$invited_id = $invited['id']; 
 $update3 = $mysqli->prepare('UPDATE `referrals_earn_list` SET `earn_status`=?,`earn_amount`=? WHERE id=?');	
$update3->bind_param('isi',$earn_status,$earn_amount,$invited_id);
$update3->execute();					
					
$referral_earning = $referred_by_user['referral_earning'] + $comission;

//// Update User Refferal
$update4 = $mysqli->prepare('UPDATE `users` SET `referral_earning`=? WHERE id=?');	
$update4->bind_param('si',$referral_earning,$referred_by);
$update4->execute();	
	
            }
	      }
        }
	 }
 }
}
			
function earn_refer_to_tradsman_pd($user_id,$amount) {
	include('con1.php');
		$invited = getreferralsearndetails($user_id); 
        if ($invited!='NA') {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];

			$referred_by_user = getUserDetails($referred_by);	
	        if ($referred_by_user!='NA') {
              if ($referred_type == 1) { //invited by tradesmen
			        $admin_id=3;
					$setting = adminsettings($admin_id);
				} else if ($referred_type == 2) { //invited by homeowners
			        $admin_id=2;
					$setting = adminsettings($admin_id);
				} else if ($referred_type == 3) { //invited by marketer
			        $admin_id=1;
					$setting = adminsettings($admin_id);
				} else {
					$setting = false;
				}

				if ($setting) {

					$min_quotes = $setting['min_quotes_approved_tradsman'];
					$comission = $setting['comission_ref_tradsman'];

					if ($amount >= $min_quotes) {
						$earn_status = 1;
						$earn_amount = $comission;
					    $invited_id = $invited['id'];
$update3 = $mysqli->prepare('UPDATE `referrals_earn_list` SET `earn_status`=?,`earn_amount`=? WHERE id=?');	
$update3->bind_param('isi',$earn_status,$earn_amount,$invited_id);
$update3->execute();					
					
	$referral_earning = $referred_by_user['referral_earning'] + $comission;
 
//// Update User Refferal
 $update4 = $mysqli->prepare('UPDATE `users` SET `referral_earning`=? WHERE id=?');	
$update4->bind_param('si',$referral_earning,$referred_by);
$update4->execute();

			      }
				}
			}
		}
	}


 function earn_refer_to_homeowner_pd($user_id,$amount){
	 include('con1.php');
		$invited = getreferralsearndetails($user_id); 
        if ($invited!='NA') {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];
			 $invited_id = $invited['id']; 
            $referred_by_user = getUserDetails($referred_by);	
	        if ($referred_by_user!='NA') {
		      if ($referred_type == 1) { //invited by tradesmen
			      $admin_id=3;
			      $setting = adminsettings($admin_id);
		      } else if ($referred_type == 2) { //invited by homeowners
			       $admin_id=2; 
			       $setting = adminsettings($admin_id);
		       } else if ($referred_type == 3) { //invited by marketer
			       $admin_id=1;
			       $setting = adminsettings($admin_id);
		       } else {
			       $setting = false;
		       }

				if ($setting) {
                     $min_quotes = $setting['min_quotes_received_homeowner'];
					 $comission = $setting['comission_ref_homeowner'];
                  if($amount >= $min_quotes) {
						$earn_status = 1;
						$earn_amount = $comission;
				       
$up_ref = $mysqli->prepare('UPDATE `referrals_earn_list` SET earn_status=?,earn_amount=? WHERE id=?');	
$up_ref->bind_param('isi', $earn_status,$earn_amount,$invited_id);
$up_ref->execute();	
					  
$referral_earning = $referred_by_user['referral_earning'] + $comission;

//// Update User Refferal
$update4 = $mysqli->prepare('UPDATE `users` SET `referral_earning`=? WHERE id=?');	
$update4->bind_param('si',$referral_earning,$referred_by);
$update4->execute();

						
					}
				}
			}
		}
	}

?>
 