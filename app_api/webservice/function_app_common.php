<?php 
	ini_set('display_errors', 1);
	/*************************Static functions don't any change*****************************/
	//header('Access-Control-Allow-Origin: *');
	
	// function for check app version
	
	
	function checkCurrentlyAppVersion($app_version, $device_type='') {
		include('con1.php');
		
		$app_version_status	=	'true';
		
		$query_result=$mysqli->prepare("SELECT android_version, ios_version, browser_version FROM app_version_master WHERE version_status='on' AND delete_flag='no' ");
		$query_result->execute();
		$query_result->store_result();
		$query_num_rows=$query_result->num_rows;
		if($query_num_rows > 0){
			$query_result->bind_result($android_version, $ios_version, $browser_version);
			$query_result->fetch();
			
			if($device_type=="android" && $app_version == $android_version){
				$app_version_status	=	'true';
			}
			else if($device_type=="ios" && $app_version == $ios_version){
				$app_version_status	=	'true';
			}
			else if($device_type=="browser" && $app_version == $browser_version){
				$app_version_status	=	'true';
			}
			else{
				$app_version_status	=	'false';
			}
		}
		$mysqli->close();
		return $app_version_status;
	}
	

	//---------------------------- generate random number string  ----------
	function generateRandomOTP($length = 6) {
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		$hash = '';
		$chars = '123456789';
		$max = strlen($chars) - 1;
		For($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}

	//echo $mobile_code = generateRandomOTP(4);

	function generateRandomString($length =10) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	//echo $mobile_code = generateRandomString(4);
	
	function referralCodeCreate($length =10) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return 'GOGOKar'.$randomString;
	}
	//echo $referral_code = referralCodeCreate(6);
	
	function promotCodeCreate($length =10) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return 'GOGOKar'.$randomString;
	}
	//echo $promocode = promotCodeCreate(6);
	function oneSignalNotificationSendCall($notification_arr)
{
	require_once '1_signal_final.php';

	//echo 'oneSignalNotificationSendCall'.print_r($notification_arr);
	if ($notification_arr != 'NA') {
		foreach ($notification_arr as $key) {

			$player_id_arr = array();

			if ($key['player_id'] != '') {
				$player_id_arr[] = $key['player_id'];

				$title = $key['title'];
				$message = $key['message'];
				$action_json = $key['action_json'];

				oneSignalNotificationSend($title, $message, $action_json, $player_id_arr);
			}
		}
	}
}



	//------------------------- check user activate or not ---------------------
function checkAccountActivateDeactivate($user_id){
	include 'con1.php';
	$active_status = 0;
	$check_active_all=$mysqli->prepare("SELECT active_flag FROM user_master WHERE user_id=? AND delete_flag ='0'");
	$check_active_all->bind_param("i",$user_id);
	$check_active_all->execute();
	$check_active_all->store_result();
	$check_active=$check_active_all->num_rows;
	if($check_active>0){
		$check_active_all->bind_result($active_flag_get);
		$check_active_all->fetch();
		//echo '$active_flag_get=='.$active_flag_get;
		if($active_flag_get == '1'){
			$active_status='1';
		}
	}
	if(empty($active_status)){
		$active_status='0';
	}
	return $active_status;
}

	// $user_id=1;
	// echo $active_status = checkAccountActivateDeactivate($user_id);

	//------------------------------Notification all functios here -----------------------
	function DeviceTokenStore_1_Signal($user_id, $device_type, $player_id)
	{
	include('con1.php');

	$inserttime=date("Y-m-d H:i:s");
	//---------------------------------- check device token -----------------------
	$check_player_id_all=$mysqli->prepare("SELECT `player_id` FROM `user_notification` WHERE player_id=?");
	$check_player_id_all->bind_param('s', $player_id);
	$check_player_id_all->execute();
	$check_player_id_all->store_result();
	$check_player_id=$check_player_id_all->num_rows;
	if($check_player_id>0)
	{
		
		//-------------- delete all record of this player_id -----------------------
		$delete_device_details=$mysqli->prepare("delete from user_notification where player_id=? or user_id=?");
		$delete_device_details->bind_param('si', $player_id, $user_id);
		$delete_device_details->execute();
		$delete_device=$mysqli->affected_rows;
		if($delete_device<=0)
		{

			//--------------- 2nd attemp to deleet -------------------
			$delete_device_details1=$mysqli->prepare("delete from user_notification where player_id=? or user_id=?");
			$delete_device_details1->bind_param('si', $player_id, $user_id);
			$delete_device_details1->execute();
			$delete_device1=$mysqli->affected_rows;
			if($delete_device1<=0)
			{
				$result = "no";
			}
			else
			{
				$insert_device_details=$mysqli->prepare("insert into user_notification (user_id, device_type, player_id, inserttime) values(?,?,?,?)");
				$insert_device_details->bind_param('isss', $user_id, $device_type, $player_id, $inserttime);
				$insert_device_details->execute();
				$insert_check = $mysqli->affected_rows;
				if($insert_check>0)
				{
					$result = "yes";
				}else
				{
					$result  = "no";
				}//insert else closed
			  }//insert else closed
		   }//insert else closed
		else
		{
			$insert_device_details=$mysqli->prepare("insert into user_notification (user_id, device_type, player_id, inserttime) values(?,?,?,?)");
			$insert_device_details->bind_param('isss', $user_id, $device_type, $player_id, $inserttime);
			$insert_device_details->execute();
			$insert_check=$mysqli->affected_rows;
			if($insert_check>0)
			{
				$result = "yes";
			}else
			{
				$result  = "no";
			}//insert else closed
		}
	}
	else
	{
		//----------------------- check user_id ------------------------
		$check_player_id_all=$mysqli->prepare("SELECT `user_id` FROM `user_notification` WHERE user_id=?");
		$check_player_id_all->bind_param('i', $user_id);
		$check_player_id_all->execute();
		$check_player_id_all->store_result();
		$check_player_id=$check_player_id_all->num_rows;
		if($check_player_id>0){
			//---------------------- delete all record of this player_id -----------------------

			$delete_device_details=$mysqli->prepare("delete from user_notification where user_id=?");
			$delete_device_details->bind_param('i', $user_id);
			$delete_device_details->execute();
			$delete_device=$mysqli->affected_rows;
			if($delete_device<=0){
				//--------------- 2nd attemp to deleet -------------------
				$delete_device_details1=$mysqli->prepare("delete from user_notification where user_id=?");
				$delete_device_details1->bind_param('i',  $user_id);
				$delete_device_details1->execute();
				$delete_device1=$mysqli->affected_rows;
				if($delete_device1<=0){
					$result = "no";
				}else{
					$insert_device_details=$mysqli->prepare("insert into user_notification(user_id, device_type, player_id, inserttime) values(?,?,?,?)");
					$insert_device_details->bind_param('isss', $user_id, $device_type, $player_id, $inserttime);
					$insert_device_details->execute();
					$insert_check=$mysqli->affected_rows;
					if($insert_check>0){
						$result = "yes";
					}else{
						$result  = "no";
					}//insert else closed
				}//insert else closed
			}//insert else closed
			else{
				$insert_device_details=$mysqli->prepare("insert into user_notification (user_id, device_type, player_id, inserttime) values(?,?,?,?)");
				$insert_device_details->bind_param('isss', $user_id, $device_type, $player_id, $inserttime);
				$insert_device_details->execute();
				$insert_check=$mysqli->affected_rows;
				if($insert_check>0){
					$result = "yes";
				}else{
					$result  = "no";
				}//insert else closed
			}
		}else{
			//------------------------------ insert new record -------------------
			$insert_device_details=$mysqli->prepare("insert into user_notification (user_id, device_type, player_id, inserttime) values(?,?,?,?)");
			$insert_device_details->bind_param('isss', $user_id, $device_type, $player_id, $inserttime);
			$insert_device_details->execute();
			$insert_check=$mysqli->affected_rows;
			if($insert_check>0){
				$result = "yes";
			} else{
				$result  = "no";
			 }//insert else closed
		   }
		 }//esle closed of delete

		return $result;

	  }
	/* user fetch(select) record*/
	//echo $result = DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);

	function getUserPlayerId($user_id)
	{
		include('con1.php');
		
		$select_all=$mysqli->prepare("SELECT player_id from user_notification where user_id=?");
		$select_all->bind_param("i",$user_id);
		$select_all->execute();
		$select_all->store_result();
		$select=$select_all->num_rows;
		//echo "select===";print_r($select);die();
		if($select>0){
			$select_all->bind_result($player_id);
			$select_all->fetch();
			//echo "select===";print_r($player_id);die();
			if($player_id == '123456'){
				$player_id = 'no';
			}
		}else{
			 $player_id = 'no';
		}

		return $player_id;
	}

	/*$user_id='27';
	$player_id = getUserPlayerId($user_id);
	print_r($player_id);*/

	// get notification
	function getNotificationStatus($user_id)
	{
		include('con1.php');
		// echo "select id  from users where id=? and notification_status=1";die();
		$select_all=$mysqli->prepare("select id  from users where id=? and notification_status=1 ");
		$select_all->bind_param("i",$user_id);
		$select_all->execute();
		$select_all->store_result();
		$select=$select_all->num_rows;
		if($select>0){
			$notification='yes';
		}
		else
		{
			$notification='no';
		}
		// echo $notification;die();
		// $notification='on';
		return $notification;
	}

	/*
	$user_id='210';
	echo $notification=getNotificationStatus($user_id)
	*/

 
	// InsertNotification('6', 6,'text', 3, 'sdfsdf', 'hey',8);
	function InsertNotification($user_id, $other_user_id, $action, $action_id, $action_json, $message,$job_id ){
 

		include('con1.php');
		
		$read_status	=	0;
		$nt_apstatus	=	0;
		$delete_flag	=	0;
		$updatetime		=	date("Y-m-d H:i:s");
		$createtime		=	date("Y-m-d H:i:s");
		$insert			=	$mysqli->prepare("insert into notification(nt_userId, action, action_id, action_json, nt_message, nt_satus,job_id,posted_by,nt_apstatus, nt_create, nt_update) values(?,?,?,?,?,?,?,?,?,?,?)");
		$insert->bind_param('isissiiiiss', $other_user_id, $action, $action_id, $action_json,$message, $read_status,$job_id,$user_id,$nt_apstatus, $createtime, $updatetime);
		$insert->execute();
		$insert_check=$mysqli->affected_rows;
		// echo $insert_check;
		if($insert_check<=0){
			$status = 'no';
		}
		else{
			$status = 'yes';
		}
		return $status;
	}


	/*
	$user_id='2';
	$other_user_id='210';
	$action = 'request_sent';
	$action_id = '0';
	$action_data=array('user_id'=>$user_id,'other_user_id'=>$other_user_id);
	$action_json=json_encode($action_data);
	$title = 'Sent a request';
	$message = 'Amit sent a friend request';
	echo $insert_status=InsertNotification($user_id, $other_user_id, $action, $action_id, $action_json, $title, $message);
	*/
	//----------------------------------  Notification all functions here -----------------------


	function getNotificationArrSingle($user_id='', $other_user_id='', $action='', $action_id='',  $message='', $title='',$action_data=''){
		$notification_arr 	=	array();
	
		$action_json		=	json_encode($action_data);
		
		// print_r($action_json);
		$insert_status		=	InsertNotification($user_id, $other_user_id, $action, $action_id, $action_json, $message,$title,$action_id);
		//echo $insert_status;die();

		if($insert_status == 'yes')
		{
			$notification_status=getNotificationStatus($other_user_id);
			// echo "notification_status==".$notification_status;die();
			if($notification_status == 'yes')
			{   
				$player_id 			=	getUserPlayerId($other_user_id);
				// echo "player_id==".$player_id;die();
				if($player_id !='no'){
						$notification_arr	=	array('player_id'=>$player_id, 'message'=>$message, 'action_json'=>$action_data,'title'=>$title);
					// }
					// print_r($notification_arr);
				}
			}
		}

		if(empty($notification_arr)){
			$notification_arr	=	'NA';
		}
		return $notification_arr;
	}

	function getUserLanguageId($user_id)
	{
		include('con1.php');

		$select_all=$mysqli->prepare("select language_id  from user_master where user_id=?");
		$select_all->bind_param("i",$user_id);
		$select_all->execute();
		$select_all->store_result();
		$select=$select_all->num_rows;
		if($select>0){
			$select_all->bind_result($language_id);
			$select_all->fetch();
		}else{
			$language_id=0;
		}

		return $language_id;
	}


	/*$user_id='1';
	$other_user_id='2';
	$action = 'request_sent';
	$action_id = '0';
	$action_data=array('user_id'=>$user_id,'other_user_id'=>$other_user_id);
	$action_json=json_encode($action_data);
	$title = 'Sent a request';
	$title2 = 'Sent a request';
	$title3 = 'Sent a request';
	$title4 = 'Sent a request';
	$message = 'Amit sent a friend request';
	$message2 = 'Amit sent a friend request';
	$message3 = 'Amit sent a friend request';
	$message4 = 'Amit sent a friend request';
	echo $insert_status=InsertNotification(
	$user_id, $other_user_id, $action, $action_id, $action_json, $title, $title_2, $title_3, $title_4, $message, $message_2, $message_3, $message_4);*/

	//------------------------------------------------  Notification all functios here -----------------------

	//----------------------------------------- safe json functions -------------------------
	function jsonSendEncode($record){
		$data = safe_json_encode($record);
		echo $data;
		exit;
	}

	// for safe_json_encode
	function safe_json_encode($value){

		if (version_compare(PHP_VERSION, '5.4.0') >= 0){
			$encoded = json_encode($value, JSON_PRETTY_PRINT);
		}else{
			$encoded = json_encode($value);
		}

		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				return $encoded;
			case JSON_ERROR_DEPTH:
				return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_STATE_MISMATCH:
				return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_CTRL_CHAR:
				return 'Unexpected control character found';
			case JSON_ERROR_SYNTAX:
				return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
			case JSON_ERROR_UTF8:
				$clean = utf8ize($value);
				return safe_json_encode($clean);
			default:
				return 'Unknown error'; // or trigger_error() or throw new Exception()
		}
	}


	function utf8ize($mixed) {
		if(is_array($mixed)){
			foreach ($mixed as $key => $value){
				$mixed[$key] = utf8ize($value);
			}
		}else if(is_string ($mixed)){
			return utf8_encode($mixed);
		}
		return $mixed;
	}



	//---------------------------  upload file function --------------------
	function uploadFileName($file, $folder_name, $file_type,$pdf_name){
		
		require_once('image_resize.php');

		$file_extension = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
		$str= $pdf_name.generateRandomString(15);
		$str2= rand();
		$image_name= $str.$str2.'.'.$file_extension;
		$upload_target = $folder_name."/".$image_name; 

		if(move_uploaded_file($file['tmp_name'],$upload_target)){
			
			if($file_type == 'image'){

				//-------------- IMAGE CROP 200X200 -------------------------------
					$new_width = '200';
					$new_height = '200';
					$uploadDir =$folder_name;
					$moveToDir  =$folder_name.'/200X200';
					$img_result=createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
		
					//-------------- IMAGE CROP 400X400 -------------------------------
					$new_width = '400';
					$new_height = '400';
					$uploadDir =$folder_name;
					$moveToDir  =$folder_name.'/400X400';
					$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
		
					//-------------- IMAGE CROP 700X700 -------------------------------
					$new_width = '700';
					$new_height = '700';
					$uploadDir =$folder_name;
					$moveToDir  =$folder_name.'/700X700';
					$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
				}
		
				return $image_name;
			}else{
				return 'error';
			}
		}

	//-------------------------------- safe json functions end -------------------------

	//---------------------------  upload file function --------------------
	function uploadFile($file, $folder_name, $file_type){
		
		require_once('image_resize.php');

		$file_extension = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));

		$str= generateRandomString(15);
		$str2= rand();
		$image_name= $str.$str2.'.'.$file_extension;
		$upload_target = $folder_name."/".$image_name; 

		if(move_uploaded_file($file['tmp_name'],$upload_target)){
			
			if($file_type == 'image'){

				//-------------- IMAGE CROP 200X200 -------------------------------
				$new_width = '200';
				$new_height = '200';
				$uploadDir =$folder_name;
				$moveToDir  =$folder_name.'/200X200';
				$img_result=createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);

				//-------------- IMAGE CROP 400X400 -------------------------------
				$new_width = '400';
				$new_height = '400';
				$uploadDir =$folder_name;
				$moveToDir  =$folder_name.'/400X400';
				$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);

				//-------------- IMAGE CROP 700X700 -------------------------------
				$new_width = '700';
				$new_height = '700';
				$uploadDir =$folder_name;
				$moveToDir  =$folder_name.'/700X700';
				$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
			}

			return $image_name;
		}
		else{
			return 'error';
		}
	}
		
		// $file=$_FILES['image'];
		// $folder_name='images';
		// $file_type='image';
		// echo $upload_status=uploadFile($file, $folder_name, $file_type);
		
		
		
		
		function uploadFileMultiple($file_arr, $folder_name, $file_type)
		{
			require_once('image_resize.php');
			//print_r($file_arr);
		   
			$image_name_arr=array();
			for($i=0; $i<count($file_arr["name"]);$i++) 
			{
				if($file_arr["name"][$i] != ''){
				   $file_extension = strtolower(pathinfo(basename($file_arr["name"][$i]),PATHINFO_EXTENSION));
			
					$str= generateRandomString(15);
					$str2= rand();
					$image_name= $str.$str2.'.'.$file_extension;
					$upload_target = $folder_name."/".$image_name; 
				
					if(move_uploaded_file($file_arr['tmp_name'][$i],$upload_target))
					{
						//echo 'in upload';
						if($file_type == 'image'){
				
						//-------------- IMAGE CROP 200X200 -------------------------------
						$new_width = '200';
						$new_height = '200';
						$uploadDir =$folder_name;
						$moveToDir  =$folder_name.'/200X200';
						$img_result=createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
			
						//-------------- IMAGE CROP 400X400 -------------------------------
						$new_width = '400';
						$new_height = '400';
						$uploadDir =$folder_name;
						$moveToDir  =$folder_name.'/400X400';
						$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
			
						//-------------- IMAGE CROP 700X700 -------------------------------
						$new_width = '700';
						$new_height = '700';
						$uploadDir =$folder_name;
						$moveToDir  =$folder_name.'/700X700';
						$img_result= createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir);
						}
						$image_name_arr[]=$image_name;
						//return $image_name;
				}else{
					 //return 'error';
					//$image_name_arr[]='error';
				} 
			}
			
		}
		// for loop closed
		// print_r($file_arr["name"]);
		if(count($file_arr["name"]) == count($image_name_arr)){
			return $image_name_arr;
		}else{
		   return 'error'; 
		}
	}

	// $file_arr=$_FILES['image'];
	// $folder_name='images';
	// $file_type='image';
	// echo $upload_status=uploadFileMultiple($file_arr, $folder_name, $file_type);



	// -----here date-time conversion --------------//
	function time_elapsed_string($datetime){
	 $fatch_date = date ("Y-m-d", strtotime($datetime));
	 $current_date = date("Y-m-d");
	 //echo date ("H:i", $datetime);
	if($current_date==$fatch_date){
		$fatch_date =  "Today ".date("h:i A", strtotime($datetime));
	}
	else{
		//$fatch_date = date ("d-M-Y H:i A", strtotime($datetime));;
		$fatch_date = "Yesterday ".date ("h:i A", strtotime($datetime));;
	}
	return $fatch_date;
	}

	// -----here date-time conversion --------------//
	function date_elapsed_string($datetime){
	 $fatch_date = date ("Y-m-d", strtotime($datetime));
	 $current_date = date("Y-m-d");
	 //echo date ("H:i", $datetime);
	if($current_date==$fatch_date){
		$fatch_date =  "Today";
	}
	else{
		$fatch_date = date ("d-M-Y", strtotime($datetime));
	}
	return $fatch_date;
	}

	function getNotificationMsgCount($user_id)
	{
		include('con1.php');
		$count = 0 ; 
		$select_all=$mysqli->prepare("SELECT nt_id FROM notification WHERE nt_userId=?
		and nt_satus = 0 ");
		$select_all->bind_param("i",$user_id);
		$select_all->execute();
		$select_all->store_result();
		$select=$select_all->num_rows;
		if($select>0){
			$count = $select;
		}
		return $count;
	}

	// $user_id=2;
	// $notification_count=getNotificationMsgCount($user_id);

	function oneSignalNotificationSendtrades($notification_arr)
{
	require_once '1_signal_final.php';

	//echo 'oneSignalNotificationSendCall'.print_r($notification_arr);
	if ($notification_arr != 'NA') {
		foreach ($notification_arr as $key) {

			$player_id_arr = array();

			if ($key['player_id'] != '') {
				$player_id_arr[] = $key['player_id'];

				$title = $key['title'];
				$message = $key['message'];
				$action_json = $key['action_json'];

				oneSignalNotificationProvider($title, $message, $action_json, $player_id_arr);
			}
		}
	}
}


	/*$title = 'Test Title';
	$message = 'test new message by developer';
	$action_data=array('user_id'=>'1','other_user_id'=>'1', 'action_id'=>'0', 'action'=>'login');
	$jsonData=json_encode($action_data);
	$player_id_arr = array('1702eb58-618a-4faf-bf58-8a2334b7605d');
	echo $response = oneSignalNotificationSend($title, $message, $jsonData, $player_id_arr);*/
?>