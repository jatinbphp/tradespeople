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



	$cat_arr = array();

    $userid			   	    =	$_GET['user_id'];


//-------------------------- check user_id --------------------------
$check_user_all	=	$mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();


//-------------------------------------------------------------------------


//-------------------------- get categorydata --------------------------


//----------------------------category----------------------------------------------------------------------


$getCounty=$mysqli->prepare("SELECT cat_id, cat_name, slug, cat_parent, cat_description, description, cat_image, meta_title, meta_description FROM category WHERE cat_parent=0 and is_delete=0 and is_activate=1 order by cat_name asc limit 15");
$getCounty->execute();
$getCounty->store_result();
$getCounty_count=$getCounty->num_rows;  //0 1	
if($getCounty_count > 0){
$getCounty->bind_result($cat_id, $cat_name, $slug, $cat_parent, $cat_description, $description,$cat_image, $meta_title, $meta_description);

while ($getCounty->fetch()) {
	$cat_arr[] = array(
		'cat_id'=>$cat_id, 
		'cat_name'=>$cat_name, 
		'slug'=>$slug, 
		'cat_parent'=>$cat_parent, 
		'cat_description'=>$cat_description, 
		'cat_image'=>$cat_image, 
		'meta_title'=>$meta_title, 
		'meta_description'=>$meta_description, 
		'status'=>false,
	);
}
}	
//----------------------------trades man----------------------------------------------------------------------
// $trades_man=array();
// $gettradesman=$mysqli->prepare("SELECT id,f_name,l_name,profile FROM users where type=1  order by f_name asc limit 5");
// $gettradesman->execute();
// $gettradesman->store_result();
// $gettradesman_count=$gettradesman->num_rows;  //0 1	
// if($gettradesman_count > 0){
// $gettradesman->bind_result($id, $f_name, $l_name, $profile);
// while ($gettradesman->fetch()) {

// 	$rating=getRatingAverage($id);

// 	$trades_man[] = array(
// 		'id'=>$id, 
// 		'f_name'=>$f_name, 
// 		'l_name'=>$l_name, 
// 		'profile'=>$profile, 
// 		'rating'=>$rating, 
		
// 	);
// }
// }

$trades_man=array();
// SELECT DISTINCT rt_rateTo FROM `rating_table` ORDER BY `rt_rateTo` DESC
$gettradesman=$mysqli->prepare("SELECT DISTINCT rt_rateTo FROM `rating_table` ORDER BY `rt_rateTo` DESC limit 3 ");
$gettradesman->execute();
$gettradesman->store_result();
$gettradesman_count=$gettradesman->num_rows;  //0 1	
if($gettradesman_count > 0){
$gettradesman->bind_result($rt_rateTo);
while ($gettradesman->fetch()) {

	$rating=getRatingAverage($rt_rateTo);
	$tradesman_detail=getownerDetails($rt_rateTo);
//print_r($tradesman_detail);die;
	if($tradesman_detail!='NA'){
		$trades_manprofile=$tradesman_detail['profile'];
		$trades_mantrading_name=$tradesman_detail['trading_name'];
		
	}
	 $rating_detail  =   getSingleReview($rt_rateTo);
//print_r($rating_detail);die;
	if($rating_detail!='NA'){
		$rt_rateBy=$rating_detail['rt_rateBy'];
		$rt_comment=$rating_detail['rt_comment'];
		$owner_name=$rating_detail['name'];
	}
	  $ratecount= rateCount($rt_rateTo);
	  $avgrate= getRatingAverage($rt_rateTo);
	  $ratepercent=($avgrate*100)/5;

	$trades_man[] = array(
		 
		'rating'=>$rating, 
		'trades_manprofile'=>$trades_manprofile, 
		'trades_mantrading_name'=>$trades_mantrading_name, 
		'rt_rateBy'=>$rt_rateBy, 
		'rt_comment'=>$rt_comment, 
		'owner_name'=>$owner_name, 
		'ratepercent'=>$ratepercent, 
		'ratecount'=>$ratecount, 	
		'$avgrate'=>$avgrate,	
		'tradesman_id'=>$rt_rateTo, 
 



		
	);
}

}

//------------------------------------------------------------------------------------------------------------
if(empty($cat_arr)){

$cat_arr = "NA";

} 

$notification_count = getNotificationMsgCount($user_id_get);

	$record=array('success'=>'true','msg'=>$data_found,'cat_arr'=>$cat_arr,'notification_count'=>$notification_count,'tradesman_arr'=>$trades_man); 

	jsonSendEncode($record);



?>