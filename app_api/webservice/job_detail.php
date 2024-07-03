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

if(empty($_GET['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$userid			 =	$_GET['user_id'];
$user_id_get     =  $userid;
$job_id			 =	$_GET['job_id'];


//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();
//-------------------------------------------------------------------------
$portfolio = array();
$portfolio=getjobPortfolio($job_id);	
//----------------------------trades man----------------------------------------------------------------------
$get_admin_set_time=getAdminDetails();
$waiting_time=$get_admin_set_time['waiting_time_accept_offer'];
$hours=0;
$job_detail = array();
$skil_name = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete,c_date,direct_hired,awarded_time,job_end_date FROM  tbl_jobs  where  userid=? and job_id=?");
$getjobdetail->bind_param('ii',$userid,$job_id);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
// echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
	$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete,$c_date,$direct_hire,$awarded_time,$job_end_date);
	while ($getjobdetail->fetch()) {
		if($is_delete==0){
			$key='cat_name';
			$tablename='category';
			$where='cat_id='.$category;
			$category_name=getSingleDataBySql("select cat_name from category where cat_id=".$category."");
			$skil_name[]=$category_name;
			$sub_cat=explode(",",$subcategory_1);
			$len=count($sub_cat);
			$i=1;
			while ( $i < $len) {
				$key='cat_name';
				$tablename='category';
				$where='cat_id='.$sub_cat[$i];
				$skil_name[]=getSingleDataBySql("select cat_name from category where cat_id=".$sub_cat[$i]."");
				$i++;
			}
			if(empty($skil_name)){
				$skil_name = "NA";
			} 
$date1=date('Y-m-d H:i:s');
			
//$dateDiff = intval((strtotime($date1)-strtotime($awarded_time))/60);
//$awarded_time = '2023-04-20 12:00:00';
			//echo '$awarded_time='.$awarded_time;
$now = time(); // or your date as well
$your_date = strtotime($awarded_time);
$datediff = $now - $your_date;

$get_time= round($datediff / (60 * 60 * 24));

			//echo '$waiting_time='.$waiting_time;			
			//echo '$get_time='.$get_time;
			
if($get_time >= $waiting_time)
{
$hours=24;
	
}
		//	$hours=24;             
//$hours = intval($dateDiff/60);

			
			$key='cat_name';
			$tablename='category';
			$where='cat_id='.$category;
			$category_name=getSingleDataBySql("select cat_name from category where cat_id=".$category."");
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
			$job_detail = array(
				'job_id'		=>  $id, 
				'project_id'    =>  $project_id, 
				'title'  		=>	$title, 
				'budget'  		=>	$budget, 
				'c_date'=>$c_date,
				'awarded_time'=>$awarded_time,
				'budget2'  		=>	$budget2, 
				'category_name'	=>	$category_name, 
				'category'		=>	$category, 
				'description'	=>	$description, 
				'userid'		=>	$userid, 
				'status'		=>	$status,
				'post_code'		=>  $post_code,
				'direct_hire'=>$direct_hire,
				'hours'=>$hours ,
				'skill_name'	=>  $skil_name,
				'expire_status'=>$expire_status,


			);
		}
	}
}
if($is_delete==0){


	//----------quotes------------
	$avg_quotes = getBidsAvg($job_id);
	$avg_quotes=round($avg_quotes,2);
	$avg_quotes =number_format($avg_quotes, 2, '.', '');
	$avg_quotes= '£'.$avg_quotes.' ';
	//-----------------average quotes
	//--quotes
	$quotes=0;
	$quotes=getBidsCount($job_id);
	//--------------------quotes----------------------
	$awarded_status = 'no';
	$quotes_arr = array();
	$awarded_quote = array();
	$awarded_milestone = 0;
	$getquotes=$mysqli->prepare("SELECT id,posted_by,bid_by,bid_amount,propose_description,delivery_days,bid_by,status,update_date FROM tbl_jobpost_bids WHERE job_id=?");
	$getquotes->bind_param('i',$job_id);
	$getquotes->execute();
	$getquotes->store_result();
	$getquotes_count=$getquotes->num_rows;  //0 1	
	// echo $getquotes_count;die();
	if($getquotes_count > 0){
$getquotes->bind_result($id,$posted_by,$bid_by,$bid_amount,$propose_description,$delivery_days,$bid_by,$status,$update_date);
		while ($getquotes->fetch()) {
			$trademan_detail=getownerDetails($bid_by);
			if($status>0){
				$awarded_milestone = $id;
			}
         $sum_of_total_milestones = getMileStoneAMOUNTtoatal($id);
			$currentdate=date('Y-m-d H:i:s');
			
	
			if($trademan_detail!='NA'){
				
				$requested_milestoen_arr = getMileStoneHomeOwner($id,$bid_by,$job_id,$user_id_get);
				$milestone_arr_cre       = getMileStoneHomeOwner($id,$posted_by,$job_id,$user_id_get);
				$mile_segge = getMileStone($id,'suggested');
				$trademan_name=$trademan_detail['name'];
				$trademan_profile=$trademan_detail['profile'];
				$trademan_rating=$trademan_detail['average_rate'];
				$trademan_ratecount=$trademan_detail['rate_count'];
				$trading_name=$trademan_detail['trading_name'];

				if($status>0){
					$awarded_status = 'yes';
					$awarded_quote = array(
						'bid_id'				=>  $id, 
						'milestone_arr_sugg'    =>  $requested_milestoen_arr,
						'milestone_arr_cre'     =>  $milestone_arr_cre,
						'bid_amount'  		 	=>	$bid_amount, 
						'posted_by' 			=>	$posted_by,
						'propose_description'  	=>	$propose_description, 
						'delivery_days'  		=>	$delivery_days, 
						'bid_by'				=>	$bid_by, 
						'description'			=>	$description, 
						'userid'				=>	$userid, 
						'bid_status'		    =>	$status,
						'skill_name'			=>  $skil_name,
						'trademan_name'			=>  $trademan_name,
						'trademan_profile'		=>  $trademan_profile,
						'trademan_rating'		=>  $trademan_rating,
						'trademan_ratecount'	=>  $trademan_ratecount,
						'trading_name'          =>  $trading_name,
						
						'hours'=>$hours ,
						'sum_of_total_milestones'=>$sum_of_total_milestones,
					);
				}
				$quotes_arr[] = array(
					'bid_id'				=>  $id, 
					'job_id'				=>  $id, 
					'milestone_arr_sugg'    =>  $mile_segge,
					'bid_amount'  		 	=>	$bid_amount, 
					'propose_description'  	=>	$propose_description, 
					'delivery_days'  		=>	$delivery_days, 
					'bid_by'				=>	$bid_by, 
					'description'			=>	$description, 
					'userid'				=>	$userid, 
					'bid_status'		    =>	$status,
					'skill_name'			=>  $skil_name,
					'trademan_name'			=>  $trademan_name,
					'trademan_profile'		=>  $trademan_profile,
					'trademan_rating'		=>  $trademan_rating,
					'trademan_ratecount'	=>  $trademan_ratecount,
					'trading_name'          =>  $trading_name,
					'hours'=>$hours ,
					'sum_of_total_milestones'=>$sum_of_total_milestones,
				);
			}
		}
	}
}
//---------------------------------------------------------------------------------------------
   $milestones_notpaid = array();
   $getAvgBids =$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested` FROM `tbl_milestones` WHERE post_id=? and (status!=2 && status!=5 && status!=6) ORDER BY id DESC");
	$getAvgBids->bind_param("i",$job_id);
	$getAvgBids->execute();
	$getAvgBids->store_result();
	$getAvgBids_row = $getAvgBids->num_rows;  //0 1
	if($getAvgBids_row > 0){
		$getAvgBids->bind_result($id, $milestone_name, $milestone_amount, $userid, $post_id, $cdate, $status, $posted_user, $created_by, $reason_cancel, $dct_image, $decline_reason, $bid_id, $is_requested, $is_dispute_to_traders, $is_suggested);
		while ($getAvgBids->fetch()) {
				$milestones_notpaid[] = array(
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
					'checked'=> false,
				);
		}
	}

if(empty($milestones_notpaid)){
	$milestones_notpaid = 'NA';
}
//---------------------------------------------------------------------------------------
if(empty($job_detail)){
	$job_detail = "NA";
} 
if(empty($quotes_arr)){
	$quotes_arr = "NA";
} 
if(empty($portfolio)){
	$portfolio = "NA";
} 
$home_ouwner=getownerDetails($userid);
if(empty($home_ouwner)){
	$home_ouwner = "NA";
} 

$job_portfolio=getjobPortfolio($job_id);
$home_feedback = 'NA';
$provider_feedback = 'NA';
if(empty($awarded_quote)){
	$awarded_quote = 'NA';
}else{
	$provider_feedback     = getReviewJob($awarded_quote['bid_by'],$job_id);
	$home_feedback         = getReviewJob($user_id_get,$job_id);
}

//echo $job_id;
//exit();
//$conversation 		= 	getdisputconversation($ds_id);
//$milestone_arr_cre 
$admin_details      =       getAdminDetails();
$mysqli->close();

if($is_delete==0){
	$record=array('success'=>'true','msg'=>$data_found,'delete'=>'0','job_detail'=>$job_detail,'portfolio'=>$portfolio,'home_ouwner'=>$home_ouwner,'quotes_arr'=>$quotes_arr,'avg_quotes'=>$avg_quotes,	'quotes'=>  $quotes,'awarded_status'=>$awarded_status,'awarded_quote'=>$awarded_quote,'admin_details'=>$admin_details,'milestones_notpaid'=>$milestones_notpaid,'home_feedback'=>$home_feedback,'provider_feedback'=>$provider_feedback,'job_portfolio'=>$job_portfolio); 

}else{
	$record=array('success'=>'true','msg'=>$data_found,'delete'=>'1','job_detail'=>$job_detail,'portfolio'=>$portfolio,'home_ouwner'=>$home_ouwner,'quotes_arr'=>$quotes_arr,'avg_quotes'=>$avg_quotes,	'quotes'=>  $quotes,'awarded_status'=>$awarded_status,'awarded_quote'=>$awarded_quote,'admin_details'=>$admin_details,'milestones_notpaid'=>$milestones_notpaid,'home_feedback'=>$home_feedback,'provider_feedback'=>$provider_feedback,'job_portfolio'=>$job_portfolio); 
}
jsonSendEncode($record);




?>