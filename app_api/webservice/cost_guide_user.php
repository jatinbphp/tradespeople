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
	$check_user_id = $mysqli->prepare("SELECT id from users where id =?");
	$check_user_id->bind_param('i', $user_id);
	$check_user_id->execute();
	$check_user_id->store_result();
	$check_user = $check_user_id->num_rows;  //0 1
	if($check_user <= 0){
		$record = array('success'=>'false', 'msg'=>'User not found'); 
		jsonSendEncode($record);
	}

	// ---------------------- check user account end ---------------------- //

// 	// ---------- check user account active/deactive status start ---------- //
// 	$active_status = checkAccountActivateDeactivate($user_id);
// 	if($active_status == 0) {
// 	    $record = array('success'=>'false', 'msg' =>$account_deactivate, 'active_status'=>$active_status); 
// 	    jsonSendEncode($record); 
// 	}


}

// echo "SELECT id, title, slug,price, description,meta_title,meta_desc,image,price2,created_at FROM cost_guides WHERE is_deleted=0";
// die();

//-------------------------- get all content --------------------------
$check_content_all=$mysqli->prepare("SELECT id, title, slug,price, description,meta_title,meta_desc,image,price2,created_at FROM cost_guides WHERE is_deleted=0");
//$check_slider_all->bind_param("s",$user_id);
$check_content_all->execute();
$check_content_all->store_result();
$check_content=$check_content_all->num_rows;  //0 1
if($check_content > 0){
	$check_content_all->bind_result($id, $title,$slug,$price, $description, $meta_title, $meta_desc, $image, $price2, $created_at);
	while($check_content_all->fetch()){
		$title	=	 ($title==null) ? 'NA' : $title;
		$description	=	 ($description==null) ? 'NA' : $description;
		$content_arr[]	=	array(
			'id'			=>	$id, 
			'title'			=>	$title, 
			'price'			=>	$price,
			'price2'		=>	$price2,
			'description'	=>	$description,
			'meta_title'	=>	$meta_title,
			'meta_desc'		=>	$meta_desc,
			'image'			=>	$image,
			'created_at'	=>	$created_at,
			'slug'			=>	$slug,
			'status'		=> false,
		);
	}
}
if(empty($content_arr)){
	$content_arr='NA';
}

$record=array('success'=>'true','msg' =>$data_found,'content_arr'=>$content_arr); 
jsonSendEncode($record);

?>