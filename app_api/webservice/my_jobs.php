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
$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
jsonSendEncode($record); 
}

$userid                 =   $_GET['user_id'];
$usertype               =   $_GET['usertype'];


$settings = getAdminDetails();
//-------------------------- check user_id --------------------------
$check_user_all =   $mysqli->prepare("SELECT id,type from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user     =   $check_user_all->num_rows;  //0 1
if($check_user <= 0){
$record     =   array('success'=>'false', 'msg'=>$msg_error_user_id); 
jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$type);
$check_user_all->fetch();
//-------------------------------------------------------------------------
//----------------------------trades man----------------------------------------------------------------------
if($usertype=='user'){
$job_detail = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,job_end_date,awarded_to,	budget2,direct_hired FROM tbl_jobs where is_delete=0 and userid=? order by job_id Desc ");
$getjobdetail->bind_param('i',$userid);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1 
 // echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
    $getjobdetail->bind_result($id,$project_id,$title,$description,$otheruserid,$status,$category,$budget,$budget2,$job_end_date,$awarded_to,$budget2, $direct_hired);
    while ($getjobdetail->fetch()) { 
	
        $key='cat_name';
        $tablename='category';
        $where='cat_id='.$category;
        $category_name=getSingleData($key, $tablename, $where);
        //--quotes
        $key2='COUNT(job_id)';
        $tablename2='tbl_jobpost_bids';
        $where2='job_id='.$id;
        $quotes=getSingleData($key2, $tablename2, $where2);
        if($quotes=='NA'){
            $quotes=0;
        }
        //--avg quotes
        $key2='AVG(bid_amount)';
        $tablename2='tbl_jobpost_bids';
        $where2='job_id='.$id;
        $avg_quotes=getSingleData($key2, $tablename2, $where2);
        $avg_quotes=round($avg_quotes,2);
        $avg_quotes =number_format($avg_quotes, 2, '.', '');
        $avg_quotes= '£'.$avg_quotes.' GBP';
        $awarded_status = checkJobBidDetails($id);
		
	    $time_current=date('Y-m-d H:i:s');
		$today = date('Y-m-d H:i:s'); 
		/// Award Status
		$a = get_accepted_post($userid,$id);
		if($a!='NA'){ 
		if($a['status']==3){
			$awarded_time = date('Y-m-d H:i:s',strtotime($a['awarded_date']));
			$revoke_time = date('Y-m-d  H:i:s',strtotime($awarded_time.'+24 hours'));
			if(strtotime($today) > strtotime($revoke_time) && $a['status'] != 7) {
				$revoke_status=1;
			} else {
				$revoke_status=0;
			}
		  }
		} else {
			$revoke_status=0;
		}
		
		$expire_status=0;
		if(!empty($job_end_date))
		{
			$dateTimestamp1 = strtotime($time_current);
			$dateTimestamp2 = strtotime($job_end_date);
		   if($dateTimestamp2<=$dateTimestamp1){
			$expire_status=1;
		  }
		}
	
        if($status==0 || $status==1 || $status==3 || $status==8 || $status==9){
            // echo "string";
			if($expire_status == 0 || $quotes == 1)
			{   $status_job='open';}
			else{
			   $status_job='closed';
			}
			
         
        }
		
		if ($status==4 || $status==7) {
            # code...

			   $status_job='In Progress';
		
			if($status==4)
			{
				   $status_job='Awaiting acceptance';
			}
	
        }
		if ($status==5) {
         
            $status_job='Completed';
        }
		
		if ($status==8 && $direct_hired == 1) {
			
            # code...
            $status_job='Rejected';
        }
		
		
        $trademan_detail=getownerDetails($awarded_to);
        if($trademan_detail!='NA')
        {
            $homeowner_name=$trademan_detail['name'];
			 $homeowner_image=$trademan_detail['image'];
			
        }

        if($status_job=='open' || $status_job=='closed'){
            $job_detail_open[] = array(
                'job_id'        =>  $id, 
                'project_id'    =>  $project_id, 
                'title'         =>  $title, 
                'budget'        =>  $budget, 
                'budget2'       =>  $budget2, 
                'category_name' =>  $category_name, 
                'description'   =>  $description, 
                'userid'        =>  $userid, 
                'status'        =>  $status,
                'quotes'        =>  $quotes,
                'status_job'        =>  $status_job,
                'avg_quotes'        =>  $avg_quotes,
                'distance'  =>   $distance,
                'homeowner_name'        =>  $homeowner_name,
                'awarded_status'=>$awarded_status,
				'revoke_status' =>$revoke_status,
            
            );
        }elseif($status_job=='In Progress' || $status_job=='Awaiting acceptance') {
			//$status_job='In Progress';
            $job_detail_progresss[] = array(
                'job_id'        =>  $id, 
                'project_id'    =>  $project_id, 
                'title'         =>  $title, 
                'budget'        =>  $budget, 
                'budget2'       =>  $budget2, 
                'category_name' =>  $category_name, 
                'description'   =>  $description, 
                'userid'        =>  $userid, 
                'status'        =>  $status,
                'quotes'        =>  $quotes,
                'status_job'        =>  $status_job,
                'avg_quotes'        =>  $avg_quotes,
                'homeowner_name'        =>  $homeowner_name,
				'homeowner_image'=>$homeowner_image,
                'awarded_status'=>$awarded_status,
				'awarded_to'=>$awarded_to,
				'revoke_status' =>$revoke_status,
            );
        }
		elseif ($status_job=='Completed') {
            # code...
			$status_com=='Completed';
            $job_detail_completd[] = array(
                'job_id'        =>  $id, 
                'project_id'    =>  $project_id, 
                'title'         =>  $title, 
                'budget'        =>  $budget, 
                'budget2'       =>  $budget2, 
                'category_name' =>  $category_name, 
                'description'   =>  $description, 
                'userid'        =>  $userid, 
                'status'        =>  $status,
                'quotes'        =>  $quotes,
                'status_job'        => 'Completed',
                'avg_quotes'        =>  $avg_quotes,
                'homeowner_name'        =>  $homeowner_name,
                'awarded_status'=>$awarded_status,
				'revoke_status' =>$revoke_status,
            );
        }elseif ($status_job=='Rejected') {

			 $status_job=='Rejected';
            $job_detail_reject[] = array(
                'job_id'        =>  $id, 
                'project_id'    =>  $project_id, 
                'title'         =>  $title, 
                'budget'        =>  $budget, 
                'budget2'       =>  $budget2, 
                'category_name' =>  $category_name, 
                'description'   =>  $description, 
                'userid'        =>  $userid, 
                'status'        =>  $status,
                'quotes'        =>  $quotes,
                'status_job'        =>  $status_job,
                'avg_quotes'        =>  $avg_quotes,
                'homeowner_name'        =>  $homeowner_name,
                'awarded_status'=>$awarded_status,
				'revoke_status' =>$revoke_status,
            );
        }
    }
    }
}
////////////----------------------------------------------------------


//------------------------------------------------------------------------------------------------------------
if(empty($job_detail_open)){
    $job_detail_open = "NA";
}
if(empty($job_detail_progresss)){
    $job_detail_progresss = "NA";
} 
if(empty($job_detail_completd)){
    $job_detail_completd = "NA";
} 
if(empty($job_detail_reject)){
    $job_detail_reject = "NA";
} 


    // $record=array('success'=>'true','msg'=>$data_found,'job_detailrecent'=>$job_detailrecent); 

    $record=array('success'=>'true','msg'=>$data_found,'job_detail_open'=>$job_detail_open,'job_detail_progresss'=>$job_detail_progresss,'job_detail_completd'=>$job_detail_completd,'job_detail_reject'=>$job_detail_reject); 

jsonSendEncode($record);



?>