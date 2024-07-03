<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';
	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_get_method); 
		jsonSendEncode($record); 
	}
 
	$user_id 	 = $_GET['user_id'];

    $user_profile=getUserDetails($user_id);
    $category = $user_profile['category'];
    if($category) {
	  $get_commision=getAdminDetails(); 
	  $closed_date=$get_commision['closed_date'];
	  $today = date('Y-m-d');				
	  $datesss= date('Y-m-d', strtotime($today. ' - '.$closed_date.' days'));
	  $time_current=date('Y-m-d H:i:s');
	  $dateTimestamp1 = strtotime($time_current);
	  $expire_status=0;	
	  $latitude = ($user_profile['latitude'] == '')?0:$user_profile['latitude'];
	  $longitude = ($user_profile['longitude'] == '')?0:$user_profile['longitude'];
	  $max_distance = $user_profile['max_distance'];
	 	
	 
	  $where = "(status=0 or status=1 or status=2 or status=3 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and DATE(c_date) > DATE('".$datesss."')";
		
	$distance = ", 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$latitude.")) * COS(RADIANS(tbl_jobs.latitude)) * COS(RADIANS(".$longitude." - tbl_jobs.longitude)) + SIN(RADIANS(".$latitude.")) * SIN(RADIANS(tbl_jobs.latitude))))) AS distance_in_km";
		
	$rct_jobs=$mysqli->query("select *$distance from tbl_jobs where $where HAVING distance_in_km <= '".$max_distance."' order by c_date desc limit 15");
if ($rct_jobs->num_rows > 0) {		
while($row = $rct_jobs->fetch_array(MYSQLI_ASSOC)){
	
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
	'distance'	=> round($row['distance_in_km'],1).' miles',
	'homeowner_name' =>  $homeowner_name,
	'post_code'=>$post_code,
	'expire_status'=>$expire_status,
	'job_end_date'=>$row['job_end_date']
);
	
	
}
}
  
if(empty($job_detailrecent)){
		$job_detailrecent	=	'NA';
	}		
}
 $user_details	=	getUserDetails($user_id);
 $notification_count = getNotificationMsgCount($user_id);    

	$record	=	array('success'=>'true', 'msg'=>$data_found,'user_details'=>$user_profile,'job_detailrecent'=>$job_detailrecent,'notification_count'=>$notification_count); 
	jsonSendEncode($record);   