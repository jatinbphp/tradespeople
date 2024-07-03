<?php
	ini_set('display_errors', 0);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';


	// check method here
	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	
	
	//user name
	if(empty($_POST['jobheadline'])){
		$record=array('success'=>'false head', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	if(empty($_POST['detail'])){
		$record=array('success'=>'false detail', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record);
	}

		if(empty($_POST['postcodejob'])){
		$record=array('success'=>'false codr', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}	


	// Email
	// if(empty($_POST['budget_id'])){
	// 	$record=array('success'=>'false budgetr', 'msg' =>$msg_empty_param); 
	// 	jsonSendEncode($record); 
	// }

	
	

	
	if(empty($_POST['min_budget'])){
		$record=array('success'=>'false mih','msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	
	// Player ID
	if(empty($_POST['max_budget'])){
		$record=array('success'=>'false max','msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}


	// Get All Post Parameter
    $title			  	    =	$_POST['jobheadline'];
    $description		    =	$_POST['detail'];
    $post_code				=	$_POST['postcodejob'];
    $phone_no				=	$_POST['budget_id']; 	
    // $state				    =	0; 	
    $budget					=	$_POST['min_budget']; 	
    $budget2				=	$_POST['max_budget'];
    $latitude			    =	$_POST['latitude'];
    $longitude			    =	$_POST['longitude'];
    $userid			   	    =	$_POST['user_id'];
    $status			   	    =	$_POST['status'];
    $category		   	    =	$_POST['category'];
    $subcategory	   	    =	$_POST['subcategory'];
    $subcategory_1	   	    =	$_POST['subcategory_1'];
    $city			   	    =	$_POST['city'];
    $address		   	    =	$_POST['address'];
    $country		   	    =	$_POST['country'];
	$filetype		   	    =	json_decode($_POST['filetype']);
	// define variable
	$c_date					=	date("Y-m-d H:i:s");
	$update_date			=	date("Y-m-d H:i:s");
	$project_id				=	generateRandomString(12);
	$is_delete				=	0;

//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id,f_name,l_name,email,city,type from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
	$check_user_all->bind_result($user_id_get,$f_name,$l_name,$email,$city,$user_type);
	$check_user_all->fetch();

//-------------------------------------------------------------------------
$f_name=trim($f_name);
$l_name=trim($l_name);
if(empty($subcategory) && empty($subcategory_1)){
	$arr = $category;
	$sub=$arr;
}elseif(!empty($subcategory) && empty($subcategory_1)){
	$arr = array($category,$subcategory);
	$sub=implode(",",$arr);
}elseif (!empty($subcategory) && !empty($subcategory)) {
	$arr = array($category,$subcategory,$subcategory_1);
	$sub=implode(",",$arr);
}
$admindetails=getAdminDetails();
$closedate=$admindetails['closed_date'];
$closedate_new='+ '.$closedate.'day';
$job_end_date=date('Y-m-d H:i:s', strtotime($c_date. ''. $closedate_new.''));

// echo $arr;die();
// echo $arr ;die();
// print_r($sub);

  // echo " SELECT id FROM users WHERE `category`REGEXP $category";die();

$job_add = $mysqli->prepare("INSERT INTO tbl_jobs(title,description,budget,budget2,userid,status, category,is_delete,c_date,subcategory,post_code,project_id,update_date,subcategory_1,latitude,longitude,city,address,country,job_end_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$job_add->bind_param("ssiiiiiissssssssssss",$title,$description,$budget,$budget2,$userid,$status,$category,$is_delete,$c_date,$subcategory,$post_code,$project_id,$update_date,$sub,$latitude,$longitude,$city,$address,$country,$job_end_date);	
$job_add->execute();
$job_add_affect_row=$mysqli->affected_rows;
if($job_add_affect_row<=0)
{
	$record=array('success'=>'false','msg'=>$msg_error_jobadd); 
	jsonSendEncode($record);
}
$job_id		=	$mysqli->insert_id;


///----------------------------job upload file--------------------
$type='image';
if(!empty($_FILES['image']['name'][0])){
	if(!empty($_FILES['image']['name'])){
		$file = $_FILES['image'];
		$folder_name = '../../img/jobs';
		$file_type = 'file'; //if we select image then type=image otherwise file.
		$job_pic = uploadFileMultiple($file, $folder_name, $file_type);
		//print_r($job_pic);
		if($job_pic=="error"){
			$record=array('success'=>'false','msg' =>$msg_image_err);
			jsonSendEncode($record);
		}

   
		for($i=0; $i<count($job_pic);$i++){
			$imagename= $job_pic[$i];
			$type= $filetype[$i];
			$insert_into_gallary=$mysqli->prepare("INSERT INTO job_files(job_id,post_doc,userid,type) VALUES (?,?,?,?)");
			$insert_into_gallary->bind_param("isis",$job_id,$imagename,$userid,$type);
			$insert_into_gallary->execute();
			$insert_affected_rows = $mysqli->affected_rows;
			if($insert_affected_rows<=0){  
			$record=array('success'=>'false', 'msg' =>"image not insert");
			jsonSendEncode($record);
			}
			$post_image_id=$mysqli->insert_id;

		}
	}
}

/// Reffer System

//$reffer = getRefferalCount($userid,$user_type);		

$refusers = getUserDetails($userid);

if($refusers['referral_code']!=''){
	$referred_by=$refusers['referral_code'];					
	$referred_link = 'https://www.tradespeoplehub.co.uk/?referral='.$referred_by;
	
	//-------------------------- check user_id --------------------------
$ref_user	=	$mysqli->prepare("SELECT id,type from users where unique_id=?");
$ref_user->bind_param("i",$referred_by);
$ref_user->execute();
$ref_user->store_result();
$check_user	 = $ref_user->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$ref_user->bind_result($user_id_get,$type);
$ref_user->fetch();
	
$user_type=2;	
$insert_ref=$mysqli->prepare("INSERT INTO referrals_earn_list(user_id,user_type,referred_by,referred_type,referred_link) VALUES (?,?,?,?,?)");
$insert_ref->bind_param("iisss",$userid,$user_type,$user_id_get,$type,$referred_link);
$insert_ref->execute();
$insert_ref_rows = $mysqli->affected_rows;
if($insert_ref_rows<=0){  
	$record=array('success'=>'false', 'msg' =>"Reffer not insert");
	jsonSendEncode($record);
}	
}


//--------------------------------------
$postData['otp_code']		=	$verification_otp;
$postData['app_name']		=	$app_name;
// $otp_message 				=	$verification_otp.' is your '.$app_name.' verification code';
// Start send mail
//$mail_content 				=	'Your job  was successfully posted on Tradespeoplehub.co.uk. You will start receiving quotes from our vetted tradespeople near you soon.';
$postData_new = getUserDetails($userid);
    $subject					=	'Congratulations! Your job was posted successfully!';
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



$job_post_link      = $website_url."/details/?post_id=".$job_id;





$show_budget_text=$budget.'-'.$budget2;
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
    	$catName = getSingleDataBySql("select cat_name from category where cat_id=".$category."");
    	if($distance <= $max_distance){
	    	// notification====================
			$notification_arr  = array();
		    $action 		=	'new_job';
			$action_id 		=    $job_id;
			$title 			=	'New job posted';
			$message 		=	$f_name.' '.$l_name.' posted a new job. <a  href="'.$job_post_link.'">View & Quote now!</a>';
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
			
	
		
			if(empty($notification_arr)){
				$notification_arr	=	'NA';
			}


			$today_sms = gettotaltodaysms($id);
			 
			if($today_sms <= 0){
				$has_sms_noti = check_sms_notification($id);
				if($has_sms_noti){
					$user_plan = getPlanDetails($id);
					$used_sms_notification = $user_plan['used_sms_notification'];
					$used_sms_notification = $used_sms_notification+1;
					$update_plan = updatesingledata12("UPDATE user_plans SET used_sms_notification=".$used_sms_notification." WHERE up_id=".$user_plan['up_id']."");
					
				}
			}
			$city='';
			
$subjectA = "New ".$catName." Job Posted: ".$city.": Quote now!";
$htmlA = '<p style="margin:0;padding:10px 0px">Hi '.$f_name1.',</p><br>';
$htmlA .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p><br>';
$htmlA .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job title</td><td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">'.$show_budget_text.'</td></tr>';

$htmlA .= '<tr><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 75%; vertical-align: top;">';



$htmlA .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">' .$title .'</h4><p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">'.$f_name.' '.$l_name.' has just posted a job that matches your profile and awaits your quote.</p></td><td style="border:1px solid #E1E1E1; padding:10px 15px; width: 25%;  vertical-align: top;"><h4 style="font-size: 15px ; margin: 0 ; margin-bottom: 8px ; color: #000">'.$show_budget_text.'</h4><a href="'.$provider.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a></td></tr>';

$htmlA .= '</table>';

$htmlA .= '<br><br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
	//	$mailBody = send_mail_app($htmlA);	
//	$mailResponse  =  mailSend($email,$f_name, $subjectA, $mailBody);		
			
    	}
    }
}


	// if($login_type>0){
		
	    /*$select_all = $mysqli->prepare("SELECT id FROM users WHERE `category` In($category) ");
        // $select_all->bind_param("s", $category);
        $select_all->execute();
        $select_all->store_result();
        $select = $select_all->num_rows;
        if($select > 0) {
            $select_all->bind_result($notification_id);
            while($select_all->fetch()){
               
         $action 		=	'JobPost';
		$action_id 		=	 $job_id;
		$title 			=	'Job Post success';
		$message 		=	$f_name." ".$l_name.' posted a new job.';
		$sender_id 		=	$user_id_get;
		$receive_id 	=	$notification_id;//($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $job_id='',$action_data='')
		$job_id			= $job_id;
		$action_data	=	array('user_id'=>$sender_id, 'other_user_id'=>$receive_id, 'job_id'=>$job_id, 'action_id'=>$action_id, 'action'=>$action);
		$notification_arr_get	=	getNotificationArrSingle($sender_id, $receive_id, $action, $action_id, $message,$job_id, $action_data);
		if($notification_arr_get != 'NA'){
			$notification_arr[]	=	$notification_arr_get;
		}
            } 
        }//Max Tommy posted a new job.


    
        $select_all = $mysqli->prepare("SELECT id,phone_no FROM users WHERE `category` In($category) ");
        $select_all->execute();
        $select_all->store_result();
        $select = $select_all->num_rows;
        if($select > 0) {
            $select_all->bind_result($smsid_id,$phone_no);
            while($select_all->fetch()){              
            $cdate = date('Y-m-d');
				
            $user_plan_sms=$mysqli->prepare("SELECT up_id,up_user,used_sms_notification FROM `user_plans` WHERE up_user=? and up_enddate>$cdate and used_sms_notification<total_sms order by up_id limit 1");
            $user_plan_sms->bind_param("i",$smsid_id);
            $user_plan_sms->execute();
            $user_plan_sms->store_result();
            $user_plan_sms_count=$user_plan_sms->num_rows;  //0 1				
            if($user_plan_sms_count > 0){  
             $user_plan_sms->bind_result($smsid_id,$up_user,$phone_no);
             $user_plan_sms->fetch();                  
                $message =  $f_name." ".$l_name.' posted a new job.';
                // $phone_number = "".$phone_no."";
                // $SMSresponse = sendSMSTwilio($phone_number, $message);
                // if($SMSresponse['status'] == 'false'){
                // $SMSresponse['message'];
                // }
                // if($SMSresponse['status'] == 'true'){
                  
                // }

            }

            } 
        }*/

    // -----------self notification------------------
        $action_self 		=	'JobPost';
		$action_id_self 		=$job_id;
		$title_self 		=	'Job Post success';
	    $message_self 		=	'Your job has been posted successfully . <a>View quote!</a>';
		
		$sender_id_self 		=$user_id_get;
		$receive_id_self 	=	$user_id_get;
		$job_id_self			= $job_id;
		$action_data_self	=	array('user_id'=>$sender_id_self, 'other_user_id'=>$receive_id_self, 'job_id'=>$job_id_self, 'action_id'=>$action_id_self, 'action'=>$action_self);
		$notification_arr_get_self	=	getNotificationArrSingle($sender_id_self, $receive_id_self, $action_self, $action_id_self, $message_self,$job_id, $action_data_self);
		if($notification_arr_get_self != 'NA'){
			$notification_arr_self[]	=	$notification_arr_get_self;
		}
	
	if(empty($notification_arr)){
		$notification_arr	=	'NA';
	}
	if(empty($notification_arr_self)){
		$notification_arr_self	=	'NA';
	}    
    // Get user complete details
    $user_details	=	getUserDetails($user_id_get); 	
	// response here
	$record	=	array('success'=>'true', 'msg'=>$msg_job_pot_succ, 'notification_arr'=>$notification_arr,'notification_arr_self'=>$notification_arr_self, 'user_details'=>$user_details,'project_id'=>$project_id,'email_arr'=>$email_arr); 
	jsonSendEncode($record);   
?>
