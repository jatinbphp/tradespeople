<?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';


	// check method here
	if(!$_GET){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}


	if(empty($_GET['user_id'])){
		$record=array('success'=>'false detail', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

		if(empty($_GET['job_id'])){
		$record=array('success'=>'false codr', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	



	// Get All Post Parameter
 
    $userid			   	=	$_GET['user_id'];
    $job_id			   	=	$_GET['job_id'];
    $title		     	=	$_GET['title'];
    // define variable
	$update_date			=	date("Y-m-d H:i:s");

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,f_name,l_name,category from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id_get,$f_name,$l_name,$category);
	$check_user_all->fetch();


//-------------------------------------------------------------------------

$admindetails=getAdminDetails();
$closedate=$admindetails['closed_date'];
$closedate_new='+ '.$closedate.'day';
$job_end_date=date('Y-m-d H:i:s', strtotime($c_date. ''. $closedate_new.''));


   
$update_user_details = $mysqli->prepare("UPDATE tbl_jobs SET status=1, c_date=?,job_end_date=?,update_date=? WHERE job_id=?");
$update_user_details->bind_param("sssi",$update_date,$job_end_date,$update_date,$job_id);
$update_user_details->execute();
$update_user_details_count	=	$mysqli->affected_rows;
if($update_user_details_count<=0)
{
$record=array('success'=>'false','msg'=>$msg_error_jobadd); 
jsonSendEncode($record);
}

$postData_new = getUserDetails($userid);
    $subject ='Congratulations! Your job was posted successfully!';
    $html .= '<p style="margin:0;padding:10px 0px">Hi ' . $postData_new['f_name'] .',</p>';
	$html .= '<p style="margin:0;padding:10px 0px">Your job '.$title.' was successfully posted on Tradespeoplehub.co.uk. You will start receiving quotes from our vetted tradespeople near you soon.
</p>';
$html.='<br><div style="text-align:center">  <a href='.$homeowner.' style="background-color:#fe8a0f;color:#fff;padding:6px 10px;text-align:center;display:inline-block;border-radius:4px;font-size:15px;text-decoration:none;">View Quotes</a> </div>';
$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app($html);


$email_arr[]				=	array('email'=>$postData_new['email'], 'fromName'=>$postData_new['fromName'], 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
//$mailResponse  =  mailSend($postData_new['email'],$postData_new['fromName'], $subject, $mailBody);
			
		
	
if(empty($email_arr)){
	$email_arr	=	'NA';
}



$distance = 0;
$notification_arr = array();
$sql = "select id,f_name,l_name,max_distance,email, 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(51.495373)) * COS(RADIANS(users.latitude)) * COS(RADIANS(-0.147421 - users.longitude)) + SIN(RADIANS(51.495373)) * SIN(RADIANS(users.latitude))))) AS distance_in_km from users where users.type=1 and users.u_email_verify=1 and users.notification_status = 1";
$select_distance = $mysqli->prepare($sql);
$select_distance->execute();
$select_distance->store_result();
$select_dis = $select_distance->num_rows;
if($select_dis > 0) {
    $select_distance->bind_result($id, $f_name1, $l_name1,$max_distance,$email,$distance);
    while($select_distance->fetch()){
    
    	if($distance <= $max_distance){
	    	// notification====================
			$notification_arr  = array();
		    $action 		=	'new_job';
			$action_id 		=    $job_id;
			$title 			=	'New job posted';
			$message 		=	$f_name.' '.$l_name.' posted a new job. <a >View & Quote now!</a>';
			$message_push	=	$f_name.' '.$l_name.' posted a new job. View & Quote now!';
			$sender_id      =   $user_id_get;
			$receive_id 	=	$id; 
			$job_id			=   $job_id;
			$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
			$player_id 			=	getUserPlayerId($receive_id);
			$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
				if($player_id !='no'){
	    	$notification_arr[]	=	array('player_id'=>$player_id, 'message'=>$message_push, 'action_json'=>$action_data,'title'=>$title);
					
				}
			if($notification_arr != 'NA'){
			
					 if (!empty($notification_arr)) {
				 oneSignalNotificationSendtrades($notification_arr);
								
         
              }
			}
		}}
	
	}
	
			if(empty($notification_arr)){
				$notification_arr	=	'NA';
			}
$user_details	=	getUserDetails($user_id_get); 	
$record=array('success'=>'true','msg'=>$msg_job_pot_succ,'notification_arr'=>$notification_arr,'notification_arr_self'=>$notification_arr_self, 'user_details'=>$user_details,'project_id'=>$project_id,'email_arr'=>$email_arr); 
	jsonSendEncode($record);    
?>
