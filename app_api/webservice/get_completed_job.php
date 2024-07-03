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
 $check_status = $_GET['check_status'];
  
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

  


$getcompletejobid=$mysqli->prepare("SELECT `job_id`,posted_by  FROM `tbl_jobpost_bids` WHERE bid_by=? and status=4");
$getcompletejobid->bind_param('i',$user_id);
$getcompletejobid->execute();
$getcompletejobid->store_result();
$getcompletejobid_count=$getcompletejobid->num_rows;  //0 1
if($getcompletejobid_count > 0){
	$getcompletejobid->bind_result($job_id_get,$posted_by);
	while ($getcompletejobid->fetch()) {
		
		$getcompletejob=$mysqli->prepare("SELECT job_id,title,userid FROM tbl_jobs where job_id=? ORDER BY c_date DESC");
		$getcompletejob->bind_param('i',$job_id_get);
		$getcompletejob->execute();
		$getcompletejob->store_result();
		$getcompletejob_count=$getcompletejob->num_rows;  //0 1
		if($getcompletejob_count > 0){
			$getcompletejob->bind_result($cat_id,$cat_name,$post_create_by);
			while ($getcompletejob->fetch()) {
			
			
				$get_details=getUserDetails($post_create_by);
				$email_comp=$get_details['email'];
				$f_name=$get_details['f_name'];
				$l_name=$get_details['l_name'];
				
					$complete_arr[] = array(
						'cat_id' =>  $cat_id,
						'cat_name' =>  $cat_name,
						'status'=>false,
						'l_name'=>$l_name,
						'f_name'=>$f_name,
						'email_comp'=>$email_comp,
						
						
					);
				
			}
		}

	}
}





if(empty($complete_arr)){

    $complete_arr='NA';

}





$record=array('success'=>'true','msg' =>$msg_data_found,'categroy_data_arr'=>$complete_arr); 

jsonSendEncode($record);



?>