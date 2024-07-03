 <?php
	ini_set('display_errors', 1);
	include 'con1.php';
	include 'function_app_common.php'; 
	include 'function_app.php'; 
	include 'language_message.php';	
	include 'mailFunctions.php';

	if(!$_POST){
		$record=array('success'=>'false','msg' =>$msg_post_method); 
		jsonSendEncode($record); 
	}
	
	if(empty($_POST['user_id'])){
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}

	//---------------------------get all variables--------------------------
	$user_id 				=	$_POST['user_id']; 	 
	$file_type1				=	$_POST['file_type']; 	 	
	$job_id 				= 	$_POST['job_id'];
	$updatetime				=	date("Y-m-d H:i:s");
 
	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
 	$check_user_all->bind_result($user_id_get);
 	$check_user_all->fetch(); 



	$profile_image	=	NULL;   

	if(isset($_FILES['profile_img'])){		
		if(!empty($_FILES['profile_img']['name'])){			
			$file			=	$_FILES['profile_img'];
			$folder_name	=	'../../img/jobs';
			$file_type		=	'file'; //if we select image then type=image otherwise file.
			$profile_image	=	uploadFile($file, $folder_name, $file_type);
			if($profile_image=="error"){
				$record=array('success'=>'false','msg' =>$msg_error_profile_image);
				jsonSendEncode($record);			
			}
		}
	}

	$types=$_FILES['profile_img']['type'];
	$type=   substr($types[0], 0, strpos($types[0], "/"));

	$insert_into_gallary=$mysqli->prepare("INSERT INTO job_files(job_id,post_doc,userid,type) VALUES (?,?,?,?)");
	$insert_into_gallary->bind_param("isis",$job_id,$profile_image,$user_id,$file_type1);
	$insert_into_gallary->execute();
	$insert_affected_rows = $mysqli->affected_rows;
	if($insert_affected_rows<=0){  
		$record=array('success'=>'false', 'msg' =>"Something went wrong, Please try again later");
		jsonSendEncode($record);
	}

	 
	$record			=	array('success'=>'true','profil'=>array('File uploaded successfully','File uploaded successfully')); 
	jsonSendEncode($record); 

?>

 