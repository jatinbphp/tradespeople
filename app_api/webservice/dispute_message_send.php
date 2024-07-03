<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';
 include('mailFunctions.php');
if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_post_method); 
	jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}
if(empty($_POST['job_id'])){
	$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$user_id	     	=	$_POST['user_id'];
$job_id			 	=	$_POST['job_id'];
$bid_id			 	=	$_POST['bid_id'];
$comment    	    =   $_POST['comment'];
$mile_id 	        =   $_POST['mile_id'];
$dispute_id          =   $_POST['dispute_id'];
//$comment = '<p>'.$comment.'</p>';


$check_user_all	=	$mysqli->prepare("SELECT id,u_wallet,spend_amount,type,f_name,trading_name from users where id=?");
$check_user_all->bind_param("i",$user_id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get,$u_wallet,$spend_amount,$type_new,$f_name_self,$trading_name);
$check_user_all->fetch();


//bid======================================
$bid_arr = array();
$get_bid_details=$mysqli->prepare("SELECT id,posted_by,bid_by,total_milestone_amount,bid_amount,propose_description,delivery_days,bid_by,status,paid_total_miles,job_id FROM tbl_jobpost_bids WHERE  id= ?");
$get_bid_details->bind_param('i',$bid_id);
$get_bid_details->execute();
$get_bid_details->store_result();
$get_bid_details_count=$get_bid_details->num_rows;  //0 1	
if($get_bid_details_count > 0){
	$get_bid_details->bind_result($id,$posted_by,$bid_by,$total_milestone_amount,$bid_amount,$propose_description,$delivery_days,$bid_by,$status,$paid_total_miles,$job_id_new);
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

//get job details======================
$job_arr = array();
$getjobdetail=$mysqli->prepare("SELECT job_id,project_id,title,description,userid,status,category,budget,budget2,subcategory,subcategory_1,post_code,is_delete FROM  tbl_jobs  where  job_id=?");
$getjobdetail->bind_param('i',$job_id);
$getjobdetail->execute();
$getjobdetail->store_result();
$getjobdetail_count=$getjobdetail->num_rows;  //0 1	
// echo $getjobdetail_count;die();
if($getjobdetail_count > 0){
	$getjobdetail->bind_result($id,$project_id,$title,$description,$userid,$status,$category,$budget,$budget2,$subcategory,$subcategory_1,$post_code,$is_delete);
	$getjobdetail->fetch();
	$job_arr = array(
		'job_id'		=>  $id, 
		'project_id'    =>  $project_id, 
		'title'  		=>	$title, 
		'budget'  		=>	$budget, 
		'budget2'  		=>	$budget2, 
		'category'		=>	$category, 
		'description'	=>	$description, 
		'userid'		=>	$userid, 
		'status'		=>	$status,
		'post_code'		=>  $post_code		
	);
}
$buser 				=   $bid_arr['bid_by'];
$puser 				=	$bid_arr['posted_by'];
 


$user_trades  	=	getUserDetails($buser);

if($buser!=$user_id){
	$user  	=	getUserDetails($buser);
  	$type  	= 	$user['type'];
}else if($puser!=$user_id){
  	$user 	=  	getUserDetails($puser);
	$type 	= 	$user['type'];
}

/// Submit Dispute File

//if(isset($_FILES['image_url'])){		
//	if(!empty($_FILES['image_url']['name'])){			
//		$file			=	$_FILES['image_url'];
//		$folder_name	=	'../../img/dispute';
//		$file_type		=	'file'; //if we select image then type=image otherwise file.
//		$image_url	=	uploadFile($file, $folder_name, $file_type);
//		if($image_url=="error"){
//			$record=array('success'=>'false','msg'=>array('Error! Something went wrong try again later.')); 
//			jsonSendEncode($record);		
//		}
//	}
//}else{
//	$image_url = NULL;
//}



$setting = getAdminDetails();

$message_to	= $user['id'];
$current 	= date('Y-m-d H:i:s');
$end_time = date('Y-m-d H:i:s', strtotime($current . ' +' . $setting['waiting_time'] . ' days'));
//$end_time	= date('Y-m-d H:i:s',strtotime($current.' + 48 hours'));
$dct_isfinal = 0;
$is_reply_pending  = 1;

$get_dispute_details=$mysqli->prepare("SELECT dct_id FROM  disput_conversation_tbl  where 	is_reply_pending=1 and dct_disputid=?");
$get_dispute_details->bind_param('i',$dispute_id);
$get_dispute_details->execute();
$get_dispute_details->store_result();
$get_dispute_details_count=$get_dispute_details->num_rows;  //0 1	

if($get_dispute_details_count > 0){
	$get_dispute_details->bind_result($dct_id);
	while($get_dispute_details->fetch())
	{
	

		
$disput_update = $mysqli->prepare("UPDATE disput_conversation_tbl SET is_reply_pending=? WHERE  dct_id=?");
$disput_update->bind_param("ii",$rply,$dct_id);	
$disput_update->execute();
$disput_update_affect_row=$mysqli->affected_rows;
if($disput_update_affect_row<=0){
	$record=array('success'=>'false','msg'=>$msg_error_update); 
	jsonSendEncode($record);
}
	}
	
}


$insert_dispute_conver = $mysqli->prepare("INSERT INTO `disput_conversation_tbl`(`dct_disputid`, `dct_userid`, `dct_msg`, `dct_isfinal`, `dct_update`, `mile_id`, `message_to`, `is_reply_pending`, `end_time`) VALUES (?,?,?,?,?,?,?,?,?)");
$insert_dispute_conver->bind_param("sssssssss",$dispute_id,$user_id,$comment,$dct_isfinal,$current,$mile_id,$message_to,$is_reply_pending,$end_time);	
$insert_dispute_conver->execute();
$insert_dispute_conver_affect_row=$mysqli->affected_rows;
$run = $mysqli->insert_id;
if($insert_dispute_conver_affect_row<=0){
 	$record=array('success'=>'false','msg'=>array('Error! Something went wrong.')); 
 	jsonSendEncode($record);
}
$homeOwner_detaisl 		= getUserDetails($puser);
$traders 		= getUserDetails($user_id);

$uploaded_by=$user_id;
 $created_at    = date('Y-m-d H:i:s');
$updated_at    = date('Y-m-d H:i:s');
$conversation_id = $run;
/// Dispute FIle Upload
if (!empty($_FILES['files']['name'])) {
				foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
					$newName = explode('.', $_FILES['files']['name'][$key]);
					$size = $_FILES['files']['size'][$key];
					$file_tmp = $_FILES['files']['tmp_name'][$key];
					$file_name = $_FILES['files']['name'][$key];
					$ext = end($newName);
					$file_str = rand() . time() . '.' . $ext;
					$fileName = 'img/dispute/' . $file_str;
					$api_path = '../../img/dispute/' . $file_str;
					if (move_uploaded_file($file_tmp, $api_path)) {
					   $original_name = $file_name;
		$disput_file = $mysqli->prepare("INSERT INTO dispute_file(uploaded_by,dispute_id,file,original_name,created_at,updated_at,conversation_id) VALUES (?,?,?,?,?,?,?)");
$disput_file->bind_param("sssssss",$uploaded_by,$dispute_id,$fileName,$original_name,$created_at,$updated_at,$conversation_id);	
$disput_file->execute();
$insert_affected_rows = $mysqli->affected_rows;
if($insert_affected_rows <= 0){
	$record		=	array('success'=>'false', 'msg'=>'file not uploaded'); 
	jsonSendEncode($record);
}					
					
					}
				}			
			}


if($type_new==1){
   	     $subject = $traders['trading_name']. " has replied to the milestone payment dispute: ".$job_arr['title'];
		$content .= '<p style="margin:0;padding:10px 0px">Hi ' .$homeOwner_detaisl['f_name'] .',</p>';
		$content .= '<p style="margin:0;padding:10px 0px">You have received a new reply from '.$traders['trading_name'].' on the milestone payment dispute for job '.$job_arr['title'].'. We encourage you to respond as soon as possible to resolve the issue.
</p>';
$content .= '<div style="text-align:center"><a href="'.$homeowner.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reply now
</a></div>';
$content .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Not responding within '.$end_time.' will result in closing this case and deciding in favour of '.$traders['trading_name'].'. Any decision reached is final and irrevocable. Once a case is close, it can not reopen.
</p>';
$content .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($content);

	$email_arr[]				=	array('email'=>$homeOwner_detaisl['email'], 'fromName'=>$homeOwner_detaisl['f_name'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($homeOwner_detaisl['email'], $homeOwner_detaisl['f_name'], $subject, $mailBody);
}
if($type_new==2){
	$subjectp = $traders['f_name']. " has replied to the milestone payment dispute: ".$job_arr['title'];
		$contentp .= '<p style="margin:0;padding:10px 0px">Hi ' .$user_trades['f_name'] .',</p>';
		$contentp .= '<p style="margin:0;padding:10px 0px">You have received a new reply from '.$traders['f_name'].' on the milestone payment dispute for job '.$job_arr['title'].'. We encourage you to respond as soon as possible to resolve the issue.
</p>';
$contentp .= '<div style="text-align:center"><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reply now
</a></div>';
$contentp .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Not responding within '.$end_time.' will result in closing this case and deciding in the client favour. Any decision reached is final and irrevocable. Once a case is close, it can not reopen.
</p>';
$contentp .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.
</p>';
$mailBody = send_mail_app($contentp);

	$email_arr[]				=	array('email'=>$user_trades['email'], 'fromName'=>$user_trades['f_name'], 'mailsubject'=>$subjectp, 'mailcontent'=>$mailBody);
		$mailResponse  =  mailSend($user_trades['email'], $user_trades['f_name'], $subjectp, $mailBody);
	
}

 if($type_new==1)
 {
 $buser 				=	$bid_arr['posted_by'];
 $get_name      	 = getUserDetails($buser);
	$f_name_self= $trading_name;
 }
$notification_arr  = array();
$action 		=	'Dispute_reply';
$action_id 		=    $job_id;
$title 			=	'Dispute reply';
$message 		=	$f_name_self.' has replied to your milestone payment dispute. <a>View and respond!</a>';
$title_push 			=	'You got reply!';
$message_push 		=	$f_name_self .' has responded to the milestone payment dispute.View & reply now!';
$sender_id      =   $user_id;
$receive_id 	=	$buser;
$job_id			=  $job_id;
$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
if($notification_arr_get != 'NA'){
	$player_id 			=	getUserPlayerId($receive_id);
			if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title_push);
					
				}
}
if (!empty($notification_arr)) {
	if($type_new==1)
	{
       oneSignalNotificationSendCall($notification_arr);
	}
	else{
		   oneSignalNotificationSendtrades($notification_arr);
	}
    }

$record=array('success'=>'true','msg'=>array('Your comment has been submitted successfully.')); 
jsonSendEncode($record);
