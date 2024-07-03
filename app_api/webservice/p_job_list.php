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
 
$getjobdetailrecent=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,post_code,longitude,latitude ,c_date,job_end_date FROM tbl_jobs where direct_hired = 0 and DATE(job_end_date) >= DATE(NOW()) and  category IN($category_ids) and (status=1 or status=2 or status=8) and is_delete=0  ORDER BY job_id DESC");
$getjobdetailrecent->execute();
$getjobdetailrecent->store_result();
$getjobdetailrecent_count=$getjobdetailrecent->num_rows;  //0 1
if($getjobdetailrecent_count > 0){
	$getjobdetailrecent->bind_result($job_id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$post_code,$longitude_job,$latitude_job,$c_date,$job_end_date);
	while ($getjobdetailrecent->fetch()) {
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
		$key='cat_name';
		$tablename='category';
		$where='cat_id='.$category;
		$category_name	=	getSingleData($key, $tablename, $where);
		$home_ouwner	=	getownerDetails($userid);
		$bid_status 	= 	checkProviderBid($job_id,$user_id);
		$budget_show        =   getSingleDataBySql("select status from show_page where id=2");
		$postal_code = '';
		if($home_ouwner!='NA'){
			$homeowner_name=$home_ouwner['name'];
			$postal_code=$home_ouwner['postal_code']; 
			$postal_code_arr = explode(" ",$postal_code);
			$postal_code = $postal_code_arr[0];
			$distance= distanceCalculation($latitude_job, $longitude_job, $latitude_user, $longitude_user, 'mi', $decimals = 2) ; 
		}
		$status_job='';

		if($distance<=$max_distance_user){
			if(($status==1 || $status==2 || $status==8) && $bid_status==-1){
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
					'postal_code'=>$postal_code,
					'homeowner_name' =>  $homeowner_name,
					'bid_status'=>$bid_status,
					'show_status'=>$show_status,
					'c_date'=>time_ago($c_date),
					'budget_show'=>$budget_show,
					'expire_status'=>$expire_status,
				); 
				}
			}else if ($status==4 || $status==7) {
				 $show_status = "";
				 if($bid_status==0){
				 	$show_status = 'Open';
				 }else if($bid_status==3){
				 	$show_status = 'Awaiting Acceptance';
				 }else{
					$show_status = 'In Progress';
				 }
				$status_job='In Progress';
				$in_progress_arr[] = array(
					'job_id' =>  $job_id,
					'project_id' =>  $project_id,
					'title'   => $title,
					'budget'   => $budget,
					'budget2'   => $budget2,
					'category_name' => $category_name,
					'description' => $description,
					'postal_code'=>$postal_code,
					'userid' => $userid,
					'status' => $status,
					'quotes' =>  $quotes,
					'status_job' =>  $status_job,
					'avg_quotes' =>  $avg_quotes,
					'distance'	=>   $distance,
					'homeowner_name' =>  $homeowner_name,
					'bid_status'=>$bid_status,
					'show_status'=>$show_status,
					'budget_show'=>$budget_show,
				);
			}else if ($status==5) {
				# code...
				$status_job='Completed';
			}
		}
	}
}
$job_detailrecent = getrecentJobs($category_ids,$user_id);

//-------------------------------------
if(empty($job_detailrecent)){
	$job_detailrecent	=	'NA';
}
if(empty($in_progress_arr)){
	$in_progress_arr	=	'NA';
}
if(empty($open_job_arr)){
	$open_job_arr	=	'NA';
}
$user_details	=	getUserDetails($user_id);

$record	=	array('success'=>'true', 'msg'=>$data_found,'user_details'=>$user_details,'job_detailrecent'=>$job_detailrecent,'open_job_arr'=>$open_job_arr,'in_progress_arr'=>$in_progress_arr); 
jsonSendEncode($record);   
?>