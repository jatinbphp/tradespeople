<?php

include 'con1.php';

include 'function_app_common.php'; 

include 'function_app.php'; 

include 'language_message.php'; 







if(!$_GET){

    $record=array('success'=>'false','msg' =>$msg_get_method); 

    jsonSendEncode($record);

}

if(empty($_GET['user_id'])){

    $record=array('success'=>'false','msg' =>$msg_empty_param); 

    jsonSendEncode($record);

}

 $user_id=$_GET['user_id'];
 
  
   // ------------------- check user mobile ------------------- //


    $check_user_all = $mysqli->prepare("SELECT id,type from users where id =?");

    $check_user_all->bind_param("i", $user_id);

    $check_user_all->execute();

    $check_user_all->store_result();

    $check_user = $check_user_all->num_rows;

    if($check_user <= 0) {

        $record = array('success'=>'true', 'msg'=>$user_not_found); 

        jsonSendEncode($record);

    }
           $check_user_all->bind_result($user_id,$user_type);
           $check_user_all->fetch();

    // // ---------- check user account active/deactive status start ---------- //

  








$checklocation_all=$mysqli->prepare("SELECT `id`, `milestone_name`, `milestone_amount`, `userid`, `post_id`, `cdate`, `status`, `posted_user`, `created_by`, `reason_cancel`, `dct_image`, `decline_reason`, `bid_id`, `is_requested`, `is_dispute_to_traders`, `is_suggested`, `admin_commission`, `updated_at` FROM `tbl_milestones` WHERE  status=2 and userid=? order by id desc ");
  $checklocation_all->bind_param("i", $user_id);

  $checklocation_all->execute();

  $checklocation_all->store_result();

 $check_location=  $checklocation_all->num_rows;  //0 1

  if($check_location > 0){
$checklocation_all->bind_result($id,$milestone_name,$milestone_amount,$userid,$post_id,$cdate,$status, $posted_user,$created_by,$reason_cancel,$dct_image,$decline_reason,$bid_id,$is_requested, $is_dispute_to_traders,$is_suggested,$admin_commission,$updated_at);

        while($checklocation_all->fetch()){
       $other_details=getUserDetails($posted_user);
		$get_job_details=getJobDetails($post_id);
	      $name=	 $other_details['name'];
			if($get_job_details!='NA')
			{
          $location_arr[]=array(
              'milestone_name'=>$milestone_name,
              'milestone_id'=>$id,
			  'milestone_amount'=>$milestone_amount,
			  'project_id'=>$get_job_details['project_id'],
			  'name'=>$name,
			  'title'=>$get_job_details['title'],
			  'status'=>'false'                     
            );
			}
    }

}



if(empty($location_arr)){

    $location_arr='NA';

}




$record=array('success'=>'true','msg' =>$msg_data_found,'invoice_arr'=>$location_arr); 

jsonSendEncode($record);



?>