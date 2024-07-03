<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 


if(!$_GET){
	$record=array('success'=>'false','msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['user_id'])){
	$user_id=0;
}else{
	//-------------------------------- get all value in variables -----------------------
	$user_id=$_GET['user_id'];
}

if($user_id>0){
	//-------------------------- check user_id --------------------------
	$check_user_id = $mysqli->prepare("SELECT user_id from user_master where delete_flag =0 and user_id =?");
	$check_user_id->bind_param('i', $user_id);
	$check_user_id->execute();
	$check_user_id->store_result();
	$check_user = $check_user_id->num_rows;  //0 1
	if($check_user <= 0){
		$record = array('success'=>'false', 'msg'=>1); 
		jsonSendEncode($record);
	}

	// ---------------------- check user account end ---------------------- //

	// ---------- check user account active/deactive status start ---------- //
	$active_status = checkAccountActivateDeactivate($user_id);
	if($active_status == 0) {
	    $record = array('success'=>'false', 'msg' =>$account_deactivate, 'active_status'=>$active_status); 
	    jsonSendEncode($record); 
	}
}



//-------------------------- get all content --------------------------

$check_content_all=$mysqli->prepare("SELECT `content_id`, `content_type`, content_1,`content_1`, `content_2`,`delete_flag` FROM `content_master` WHERE delete_flag=0");
//$check_slider_all->bind_param("s",$user_id);
$check_content_all->execute();
$check_content_all->store_result();
$check_content=$check_content_all->num_rows;  //0 1
if($check_content > 0){
	$check_content_all->bind_result($content_id, $content_type,$content, $content_1, $content_2, $delete_flag);
	while($check_content_all->fetch()){
		$content_2	=	 ($content_2==null) ? 'NA' : $content_2;
		$content_1	=	 ($content_1==null) ? 'NA' : $content_1;
		$content	=	 ($content==null)   ? 'NA' : $content;
		$content_arr[]	=	array(
			'content_id'	=>	$content_id, 
			'content_type'	=>	$content_type, 
			'content'		=>	array($content,$content_1,$content_2),
			'delete_flag'	=>	$delete_flag,
		);
	}
}
if(empty($content_arr)){
	$content_arr='NA';
}

$record=array('success'=>'true','msg' =>$data_found,'content_arr'=>$content_arr); 
jsonSendEncode($record);

?>