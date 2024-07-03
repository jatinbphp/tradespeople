<?php
ini_set('display_errors', 0);
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


//get user id chweck==========================
$check_user_all	=	$mysqli->prepare("SELECT f_name,l_name,`id`, `email`,category,longitude,latitude,max_distance FROM `users` WHERE id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
} 
$check_user_all->bind_result($f_name,$l_name,$user_id_get,$user_email,$category_ids,$longitude_user,$latitude_user,$max_distance_user);
$check_user_all->fetch(); 
//---------------------------------------jobs-----------------------------

$open_job_arr=array();
$in_progress_arr=array();
$complete_arr = array();

$getjobdetailrecent=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,post_code,longitude,latitude,direct_hired,job_end_date FROM tbl_jobs WHERE (status=0 or status=1 or status=2 or status=3 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and DATE(job_end_date) >= DATE(NOW()) and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and category IN($category_ids) ORDER BY c_date DESC");
$getjobdetailrecent->execute();
$getjobdetailrecent->store_result();
$getjobdetailrecent_count=$getjobdetailrecent->num_rows;  //0 1
if($getjobdetailrecent_count > 0){
	$getjobdetailrecent->bind_result($job_id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$post_code,$longitude_job,$latitude_job,$direct_hired,$job_end_date);
	while ($getjobdetailrecent->fetch()) {
		
		$time_current=date('Y-m-d H:i:s');
	
     	
		$time_current=date('Y-m-d H:i:s');
	    $dateTimestamp1 = strtotime($time_current);
        $dateTimestamp2 = strtotime($job_end_date);
		$expire_status=0;

		 if($dateTimestamp2<$dateTimestamp1){
		  $expire_status=1;
		 }
		$key='cat_name';
		$tablename='category';
		$where='cat_id='.$category;
		$category_name	=	getSingleData($key, $tablename, $where);
		$home_ouwner	=	getownerDetails($userid);
		$bid_status 	= 	checkProviderBid($job_id,$user_id);
        $review_status1 = getReviewJob($user_id,$job_id);
		$review_status  = false;
		if($review_status1!='NA'){
			$review_status = true;
		}
		$postal_code = '';
		if($home_ouwner!='NA'){
			$homeowner_name=$home_ouwner['name'];
			$homeowner_profile=$home_ouwner['profile'];
			$postal_code=$home_ouwner['postal_code']; 
			
			$postal_code_arr = explode(" ",$postal_code);
		
			$postal_code = $postal_code_arr[0];
				
			$distance= distanceCalculation($latitude_job, $longitude_job, $latitude_user, $longitude_user, 'mi', $decimals = 2) ; 
		}
		$status_job='';


	
	$len = (strlen($postal_code) >= 7) ? 4 : 4;
    $post_code = strtoupper(substr($postal_code, 0, $len));
		
		if($distance<=$max_distance_user){
			
			if(($status==1 ||  $status==8) && $expire_status ==0){
				$show_status='Open';
				if($expire_status!=1)
				{
				$open_job_arr[]=array(
					'job_id' =>  $job_id,
					'project_id' =>  $project_id,
					'title'   => $title,
					'budget'   => $budget,
					'budget2'   => $budget2,
					'category_name' => $category_name,
					'description' => $description,
					'userid' => $userid,
					'status' => $status,
					'quotes' =>  $quotes,
					'status_job' =>  $status_job,
					'avg_quotes' =>  $avg_quotes,
					'distance'	=>   $distance,
					'postal_code'=>$post_code,
					'homeowner_name' =>  $homeowner_name,
					'homeowner_profile'=>$homeowner_profile,
					'bid_status'=>$bid_status,
					'show_status'=>$show_status,
					'review_status'=>$review_status,
					'direct_hired'=>$direct_hired,
					'job_end_date'=>$job_end_date,
					'expire_status'=>$expire_status,
				); 
				}
			}
		}
	}
}
//-------------------------------------


//---------------  in progress job  -------------------- 
$getinprogressjobid=$mysqli->prepare("SELECT job_id FROM tbl_jobpost_bids WHERE bid_by=? and (status=7 or status=3 or (status=0 and (select count(job_id) from tbl_jobs where tbl_jobs.job_id = tbl_jobpost_bids.job_id and (tbl_jobs.status=1 or tbl_jobs.status=8)) = 1)) order by id desc");
$getinprogressjobid->bind_param('i',$user_id);
$getinprogressjobid->execute();
$getinprogressjobid->store_result();
$getinprogressjobid_count=$getinprogressjobid->num_rows;  //0 1
if($getinprogressjobid_count > 0){
	$getinprogressjobid->bind_result($job_id_get);
	while ($getinprogressjobid->fetch()) {
		$getinprogjob=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,post_code,longitude,latitude,job_end_date FROM tbl_jobs where job_id=? ORDER BY c_date DESC");
		$getinprogjob->bind_param('i',$job_id_get);
		$getinprogjob->execute();
		$getinprogjob->store_result();
		$getinprogjob_count=$getinprogjob->num_rows;  //0 1
		if($getinprogjob_count > 0){
			$getinprogjob->bind_result($job_id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$post_code,$longitude_job,$latitude_job,$job_end_date);
			while ($getinprogjob->fetch()) {
				$key='cat_name';
				$tablename='category';
				$where='cat_id='.$category;
				$category_name	=	getSingleData($key, $tablename, $where);
				$home_ouwner	=	getownerDetails($userid);
				$bid_status 	= 	checkProviderBid($job_id,$user_id);
		        $review_status1 = getReviewJob($user_id,$job_id);
				$review_status  = false;
				if($review_status1!='NA'){
					$review_status = true;
				}
				$postal_code = '';
				if($home_ouwner!='NA'){
					$homeowner_name=$home_ouwner['name'];
					$homeowner_profile=$home_ouwner['profile'];
					$postal_code=$home_ouwner['postal_code']; 
					$postal_code_arr = explode(" ",$postal_code);
					$postal_code = $postal_code_arr[0];
					$distance= distanceCalculation($latitude_job, $longitude_job, $latitude_user, $longitude_user, 'mi', $decimals = 2) ; 
				}
				$status_job='';
				
				
				$time_current=date('Y-m-d H:i:s');
	
     	$expire_status=0;
		if(!empty($job_end_date))
		{
        $dateTimestamp1 = strtotime($time_current);
        $dateTimestamp2 = strtotime($job_end_date);
       if($dateTimestamp2<$dateTimestamp1){
       $expire_status=1;
      }
		}
				

					$len = (strlen($postal_code) >= 7) ? 4 : 4;
					$post_code = strtoupper(substr($postal_code, 0, $len));
					$show_status = "";
					$show_status = 'In Progress';
					 if($bid_status==0){
						$show_status = 'Open';
					 }else if($bid_status==3){
						$show_status = 'Awaiting Acceptance';
					 }else if($bid_status==7){
						$show_status = 'In Progress';
					 }else{
						$show_status = 'In Progress';
					 }
					//$status_job='In Progress';
					$in_progress_arr[] = array(
						'job_id' =>  $job_id,
						'project_id' =>  $project_id,
						'title'   => $title,
						'budget'   => $budget,
						'budget2'   => $budget2,
						'category_name' => $category_name,
						'description' => $description,
						'postal_code'=>$post_code,
						'userid' => $userid,
						'status' => $status,
						'quotes' =>  $quotes,
						'status_job' =>  $status_job,
						'avg_quotes' =>  $avg_quotes,
						'distance'	=>   $distance,
						'homeowner_name' =>  $homeowner_name,
						'homeowner_profile'=>$homeowner_profile,
						'bid_status'=>$bid_status,
						'show_status'=>$show_status,
						'review_status'=>$review_status,
						'direct_hired'=>$direct_hired,
						'job_end_date'=>$job_end_date,
						'expire_status'=>$expire_status,
					);
				}
			}
		}

	}



//---------------  completed job -------------------- 
$getcompletejobid=$mysqli->prepare("SELECT `job_id`  FROM `tbl_jobpost_bids` WHERE bid_by=? and status=4 order by update_date desc");
$getcompletejobid->bind_param('i',$user_id);
$getcompletejobid->execute();
$getcompletejobid->store_result();
$getcompletejobid_count=$getcompletejobid->num_rows;  //0 1
if($getcompletejobid_count > 0){
	$getcompletejobid->bind_result($job_id_get);
	while ($getcompletejobid->fetch()) {
		$getcompletejob=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,post_code,longitude,latitude,job_end_date FROM tbl_jobs where job_id=? ORDER BY c_date DESC");
		$getcompletejob->bind_param('i',$job_id_get);
		$getcompletejob->execute();
		$getcompletejob->store_result();
		$getcompletejob_count=$getcompletejob->num_rows;  //0 1
		if($getcompletejob_count > 0){
			$getcompletejob->bind_result($job_id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$post_code,$longitude_job,$latitude_job,$job_end_date);
			while ($getcompletejob->fetch()) {
				$key='cat_name';
				$tablename='category';
				$where='cat_id='.$category;
				$category_name	=	getSingleData($key, $tablename, $where);
				$home_ouwner	=	getownerDetails($userid);
				$bid_status 	= 	checkProviderBid($job_id,$user_id);
		        $review_status1 = getReviewJob($user_id,$job_id);
				$review_status  = false;
				if($review_status1!='NA'){
					$review_status = true;
				}
				$postal_code = '';
				if($home_ouwner!='NA'){
					$homeowner_name=$home_ouwner['name'];
					$homeowner_profile=$home_ouwner['profile'];
					$postal_code=$home_ouwner['postal_code']; 
					$postal_code_arr = explode(" ",$postal_code);
					$postal_code = $postal_code_arr[0];
					$distance= distanceCalculation($latitude_job, $longitude_job, $latitude_user, $longitude_user, 'mi', $decimals = 2) ; 
				}
				$status_job='';

				$len = (strlen($postal_code) >= 7) ? 4 : 4;
		    	$post_code = strtoupper(substr($postal_code, 0, $len));
				if ($status==5) {
					$status_job='Completed';
					$complete_arr[] = array(
						'job_id' =>  $job_id,
						'project_id' =>  $project_id,
						'title'   => $title,
						'budget'   => $budget,
						'budget2'   => $budget2,
						'category_name' => $category_name,
						'description' => $description,
						'postal_code'=>$post_code,
						'userid' => $userid,
						'status' => $status,
						'quotes' =>  $quotes,
						'status_job' =>  $status_job,
						'avg_quotes' =>  $avg_quotes,
						'distance'	=>   $distance,
						'homeowner_name' =>  $homeowner_name,
						'homeowner_profile'=>$homeowner_profile,
						'bid_status'=>$bid_status,
						'show_status'=>$show_status,
						'review_status'=>$review_status,
						'direct_hired'=>$direct_hired,
						'job_end_date'=>$job_end_date
					);
				}
			}
		}

	}
}


$job_detailrecent = getrecentJobs($category_ids,$user_id);

$arr_count=count($in_progress_arr);

if(empty($in_progress_arr)){
	$in_progress_arr	=	'NA';
}

if(empty($job_detailrecent)){
	$job_detailrecent	=	'NA';
}

if(empty($open_job_arr)){
	$open_job_arr	=	'NA';
}

if(empty($complete_arr)){
	$complete_arr	=	'NA';
}

$user_details	=	getUserDetails($user_id);

$record	=	array('success'=>'true', 'msg'=>$data_found,'in_progress_arr_count'=>$arr_count, 'user_details'=>$user_details,'job_detailrecent'=>$job_detailrecent,'open_job_arr'=>$open_job_arr,'in_progress_arr'=>$in_progress_arr,'complete_arr'=>$complete_arr); 
jsonSendEncode($record);   
?>