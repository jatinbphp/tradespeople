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
		$record=array('success'=>'false', 'msg' =>$msg_empty_param); 
		jsonSendEncode($record); 
	}
	 


	$trades_man = array();
    $user_id			   	    =	$_GET['user_id'];


	//-------------------------- check user_id --------------------------
	$check_user_all	=	$mysqli->prepare("SELECT id,category from users where id=?");
	$check_user_all->bind_param("i",$user_id);
	$check_user_all->execute();
	$check_user_all->store_result();
	$check_user		=	$check_user_all->num_rows;  //0 1
	if($check_user <= 0){
		$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
		jsonSendEncode($record);
	}
	$check_user_all->bind_result($user_id_get,$category);
	$check_user_all->fetch();


  
	$user_skill	    = getSkills($category);
	$portfolio      = getPortfolio($user_id);
	$rating_arr		= getReview($user_id);
	//------------------------------------------------------------------------------------------------------------
	 

	$record=array('success'=>'true','msg'=>$data_found,'portfolio'=>$portfolio,'rating_arr'=>$rating_arr,'user_skill'=>$user_skill);
	jsonSendEncode($record);

?>