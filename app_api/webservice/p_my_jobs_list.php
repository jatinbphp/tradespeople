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
$getjobdetailrecent=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,post_code,longitude,latitude FROM tbl_jobs where (status=1 or status=3 or status=4 OR status=5) and  category IN($category_ids) and direct_hired=1  ORDER BY c_date DESC");
$getjobdetailrecent->execute();
$getjobdetailrecent->store_result();
$getjobdetailrecent_count=$getjobdetailrecent->num_rows;  //0 1
if($getjobdetailrecent_count > 0){
	$getjobdetailrecent->bind_result($job_id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$post_code,$longitude_job,$latitude_job);
	while ($getjobdetailrecent->fetch()) {
		$key='cat_name';
		$tablename='category';
		$where='cat_id='.$category;
		$category_name=getSingleData($key, $tablename, $where);
		$home_ouwner=getownerDetails($userid);
		if($home_ouwner!='NA'){
			$homeowner_name=$home_ouwner['name'];
			$distance= distanceCalculation($latitude_job, $longitude_job, $latitude_user, $longitude_user, 'M', $decimals = 2) ;

		}
		$status_job='';
		if($status==1||$status==3){
			$status_job='Open';
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
				'homeowner_name' =>  $homeowner_name,

			); 
		}elseif ($status==4) {
			# code...
			$status_job='In Progress';
		}else if ($status==5) {
			# code...
			$status_job='Completed';
		}

		if($distance<=$max_distance_user){
			$job_detailrecent[] = array(
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
				'homeowner_name' =>  $homeowner_name,
			);
		}
	}
}
//-------------------------------------
if(empty($job_detailrecent)){
	$job_detailrecent	=	'NA';
}
if(empty($open_job_arr)){
	$open_job_arr	=	'NA';
}
$user_details	=	getUserDetails($user_id);

$record	=	array('success'=>'true', 'msg'=>$data_found,'user_details'=>$user_details,'job_detailrecent'=>$job_detailrecent,'open_job_arr'=>$open_job_arr); 
jsonSendEncode($record);   
?>