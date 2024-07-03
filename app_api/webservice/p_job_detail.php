<?php
ini_set('display_errors', 0);
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
if(empty($_GET['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
$userid			   	    =	$_GET['user_id'];
$user_id_get = $userid	;
$job_id			        =	$_GET['job_id'];
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
$job_detail = array();
$skil_name = array();
$home_ouwner = array();
$bid_status = 0;
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete,direct_hired,job_end_date,c_date FROM  tbl_jobs  where job_id=?");
$getjobdetail->bind_param('i',$job_id);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
// echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
	$getjobdetail->bind_result($id,$project_id,$title,$description,$user_id,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete,$direct_hired,$job_end_date,$c_date);
	while ($getjobdetail->fetch()) {
		if($is_delete==0){
			$key='cat_name';
			$tablename='category';
			$where='cat_id='.$category;
			//$category_name=getSingleData($key, $tablename, $where);
			$category_name = getSingleDataBySql("select cat_name from category where cat_id=".$category."");
			$skil_name[]=$category_name;
			$sub_cat=explode(",",$subcategory_1);
			$len=count($sub_cat);
			$i=1;
				while ( $i < $len) {
					$key='cat_name';
					$tablename='category';
					$where='cat_id='.$sub_cat[$i];
					$skil_name[]= getSingleDataBySql("select cat_name from category where cat_id=".$sub_cat[$i]."");
						$i++;
				}
				if(empty($skil_name)){
					$skil_name = "NA";
				} 
			$key='cat_name';
			$tablename='category';
			$where='cat_id='.$category;
			
			$category_name = getSingleDataBySql("select cat_name from category where cat_id=".$category."");
			
			//$category_name=getSingleData($key, $tablename, $where);
			$home_ouwner=getownerDetails($user_id);
		    $review_arr = getSingleReview($user_id);
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
				'budget2'  		=>	$budget2, 
				'category_name'	=>	$category_name, 
				'category'		=>	$category, 
				'description'	=>	$description, 
				'userid'		=>	$user_id, 
				'status'		=>	$status,
				'skill_name'	=>  $skil_name,
				'post_code'		=>  $post_code,
				'recent_review_arr'   =>  $review_arr,
				'direct_hired'=>$direct_hired,
				'c_date'=>$c_date,
				
				
			);
		}
	}
}



if($is_delete==0){
//----------quotes------------
	$key2='AVG(bid_amount)';
	$tablename2='tbl_jobpost_bids';
	$where2='job_id='.$job_id;
	$avg_quotes=getSingleData($key2, $tablename2, $where2);
	$avg_quotes=round($avg_quotes,2);
//-----------------average quotes
	//--quotes
	$key2='COUNT(job_id)';
	$tablename2='tbl_jobpost_bids';
	$where2='job_id='.$job_id;
	$quotes=getSingleData($key2, $tablename2, $where2);
	if($quotes='NA'){
		$quotes=0;
	}
//--------------------quotes----------------------
$quate_added_status = 'no';
$bid_id=0;
$user_quotes_arr = array();

	
$milestone_arr = array();
$milestone_arr_sugg = array();
$milestone_arr_sugg_a = array();
$milestone_arr_cre  = array();
$getquotes=$mysqli->prepare("SELECT id,posted_by,bid_by,bid_amount,propose_description,delivery_days,bid_by,status FROM tbl_jobpost_bids WHERE job_id=? and bid_by=?");
$getquotes->bind_param('ii',$job_id,$user_id_get);
$getquotes->execute();
$getquotes->store_result();
$getquotes_count=$getquotes->num_rows;  //0 1	
// echo $getquotes_count;die();
if($getquotes_count > 0){
	$getquotes->bind_result($id,$posted_by,$bid_by,$bid_amount,$propose_description,$delivery_days,$bid_by,$status);
	while ($getquotes->fetch()) {
		$disput_id=get_dispute_id($job_id);
		if($disput_id!=0){
		 $close_status=get_dispute_close_status($disput_id);
	
			if($close_status==1)
			{
		      // $close_disput=disput_close($disput_id,$user_id,$job_id,$id);
			}
		}
		$trademan_detail=getownerDetails($bid_by);
		$milestone_arr = getMileStone($id,'all');
		$milestone_arr_sugg = getMileStoneHomeOwner($id,$bid_by,$job_id,$user_id_get);
		$milestone_arr_sugg_a = getMileStone($id,'suggested');
		$milestone_arr_cre  = getMileStoneHomeOwner($id,$posted_by,$job_id,$user_id_get);
		//	echo $bid_by;die();
		         $sum_of_total_milestones = getMileStoneAMOUNTtoatal($id);
		if($trademan_detail!='NA'){
			$trademan_name=$trademan_detail['name'];
			$trading_name = $trademan_detail['trading_name'];
			$trademan_profile=$trademan_detail['profile'];
			$trademan_rating=$trademan_detail['average_rate'];
			$trademan_ratecount=$trademan_detail['rate_count'];

			$bid_status = $status;
			$user_quotes_arr = array(
				'job_bid_id'				=>  $id, 
				'bid_amount'  		 	=>	$bid_amount, 
				'propose_description'  	=>	$propose_description, 
				'delivery_days'  		=>	$delivery_days, 
				'posted_by'=>$posted_by,
				'bid_by'				=>	$bid_by, 
				'description'			=>	$description, 
				'userid'				=>	$userid, 
				'bid_status'			=>	$status,
				'skill_name'			=>  $skil_name,
				'trading_name'          =>  $trading_name,
				'trademan_name'			=>  $trademan_name,
				'trademan_profile'		=>  $trademan_profile,
				'trademan_rating'		=>  $trademan_rating,
				'trademan_ratecount'	=>  $trademan_ratecount,
				'sum_of_total_milestones' => $sum_of_total_milestones,
				'expire_status'=>$expire_status
			);
		}
		}
	}
}


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


//---------------------------------------------------------------------------------------------
$cdate = date('Y-m-d');

//---------------------------------------------------------------------------------------

if(empty($milestone_arr_cre)){
	$milestone_arr_cre = "NA";
} 
if(empty($milestone_arr_sugg)){
	$milestone_arr_sugg = "NA";
} 
if(empty($job_detail)){
	$job_detail = "NA";
} 

if(empty($milestone_arr)){
	$milestone_arr = 'NA';
}

 
if(empty($portfolio)){
	$portfolio = "NA";
} 
if(empty($home_ouwner)){
	$home_ouwner = "NA";
} 

if(empty($milestone_arr_sugg_a)){
	$milestone_arr_sugg_a = "NA";
} 

 
$home_feedback     ='NA';
$provider_feedback = "NA";
if(empty($user_quotes_arr)){
	$user_quotes_arr = "NA";
}else{
	$home_feedback        = getReviewJob($user_quotes_arr['posted_by'],$job_id);
	$provider_feedback    = getReviewJob($user_id_get,$job_id);
}

$job_portfolio=getjobPortfolio($job_id);
$total_balance  =  getWalletBalance($userid);
$min_amount_for_quate = 10;

$mysqli->close();

if($is_delete==0){
	if(empty($milestone_arr_cre)){
	$milestone_arr_cre = "NA";
} 

$rating_arr=getReview($user_id);

if(empty($milestone_arr_sugg)){
	$milestone_arr_sugg = "NA";
} 
	$record=array('success'=>'true','msg'=>$data_found,'delete'=>'0','job_detail'=>$job_detail,'portfolio'=>$portfolio,'home_ouwner'=>$home_ouwner,'avg_quotes'=>$avg_quotes,	'quotes'=>  $quotes,'bid_id'=>$bid_id,'quate_added_status'=>$quate_added_status,'user_quotes_arr'=>$user_quotes_arr,'total_balance'=>$total_balance,'min_amount_for_quate'=>$min_amount_for_quate,'bid_status'=>$bid_status,'milestone_arr'=>$milestone_arr,'milestone_arr_cre'=>$milestone_arr_cre,'milestone_arr_sugg'=>$milestone_arr_sugg,'rating_arr'=>$rating_arr,'milestone_arr_sugg_a'=>$milestone_arr_sugg_a,'milestones_notpaid'=>$milestones_notpaid,'home_feedback'=>$home_feedback,'provider_feedback'=>$provider_feedback,'job_portfolio'=>$job_portfolio); 
}else{
	$record=array('success'=>'true','msg'=>$data_found,'delete'=>'1','job_detail'=>$job_detail,'portfolio'=>$portfolio,'home_ouwner'=>$home_ouwner,'avg_quotes'=>$avg_quotes,	'quotes'=>  $quotes,'quate_added_status'=>$quate_added_status,'bid_id'=>$bid_id,'user_quotes_arr'=>$user_quotes_arr,'total_balance'=>$total_balance,'min_amount_for_quate'=>$min_amount_for_quate,'bid_status'=>$bid_status,'milestone_arr'=>$milestone_arr,'milestone_arr_cre'=>$milestone_arr_cre,'milestone_arr_sugg'=>$milestone_arr_sugg,'rating_arr'=>$rating_arr,'milestone_arr_sugg_a'=>$milestone_arr_sugg_a,'milestones_notpaid'=>$milestones_notpaid,'home_feedback'=>$home_feedback,'provider_feedback'=>$provider_feedback,'job_portfolio'=>$job_portfolio); 
}
	jsonSendEncode($record);
?>