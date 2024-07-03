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
$cat_id	=	$_GET['cat_id'];
$location = 	$_GET['location'];	 
$average_rate = 	$_GET['rating'];	
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
  $check_condition='';
 $check_condition_location='';
$check_condition1='';

  if(!empty($cat_id)){
    $check_condition="AND FIND_IN_SET(".$cat_id.", category)";
  }
 if(!empty($location)){
    $check_condition_location="AND city LIKE '%$location%'";
  }
if(!empty($average_rate)){
    $check_rating_condition="AND average_rate >='$average_rate'";
  }

$cat_arr = array();

$get_cat = $mysqli->prepare("SELECT `cat_id`, `cat_name`, `title_ft` FROM `category` WHERE cat_parent=0 and is_delete=0");
$get_cat->execute();
$get_cat->store_result();
$get_cat_count=$get_cat->num_rows;  //0 1	
if($get_cat_count > 0){
	$get_cat->bind_result($cat_id,$cat_name,$title_ft);
	while ($get_cat->fetch()) {
	
		$cat_arr[] = array(
			'cat_id'=>$cat_id,
			'cat_name'=>$cat_name,
			'title_ft'=>$title_ft,
			'status'=>false,
		);
	}
}
 
$trades_man=array();

$gettradesman=$mysqli->prepare("select id,f_name,l_name,profile,trading_name,city,county,about_business,cdate,category from users where type = 1 and status = 0 and u_email_verify = 1  $check_rating_condition $check_condition_location $check_condition order by (select tr_id from rating_table where rating_table.rt_rateTo = users.id order by tr_id desc limit 1) desc");
$gettradesman->execute();
$gettradesman->store_result();
$gettradesman_count=$gettradesman->num_rows;  //0 1	
if($gettradesman_count > 0){
	$gettradesman->bind_result($id,$f_name,$l_name,$profile,$trading_name,$city,$county,$about_business,$cdate,$category);
	while ($gettradesman->fetch()) {

		$rating 	    =	getRatingAverage($id);
		$since 		    =	date('M Y', strtotime($cdate));
		
		$avg_rate     	=   getRatingAverage($id);
		$rate_count 	=   rateCount($id);
		$latest_review  =   getSingleReview($id);


		//$category_name=getSingleDataBySql("select cat_name from category where cat_id IN(".$category.")");
		$ca_arr = array();
		$categories  = explode(",",$category);
		for($i=0;$i<count($cat_arr);$i++){
			if(in_array($cat_arr[$i]['cat_id'], $categories)){
				$ca_arr[]=$cat_arr[$i]['cat_name'];
			}
		}
		

$ca_arr = implode(",",$ca_arr);

		$read_more = false;
		if(strlen($about_business) > 130){
			$read_more = true;
			$about_business = substr($about_business,0,130);
		}
		$trades_man[] = array(
			'id' 				=>  $id, 
			'f_name' 			=>  $f_name, 
			'l_name' 			=>  $l_name, 
			'profile' 			=>  $profile, 
			'trading_name' 		=>  $trading_name, 
			'category_name'=>$category_name,
			'city'  			=>  $city, 
			'ca_arr'=>$ca_arr,
			'category'=>$category,
			'county'       		=>  $county, 
			'about_business' 	=>  $about_business, 
			'average_rate'      =>  $avg_rate,
	        'since'             =>  $since,
	        'rate_count'        =>  $rate_count,
	        'status'            =>  false,
			'latest_review'=>$latest_review,
			'read_more'=>$read_more,
		);
	}
}



//------------------------------------------------------------------------------------------------------------
if(empty($trades_man)){
	$trades_man = "NA";
} 

if(empty($cat_arr)){
	$cat_arr = "NA";
} 

	$record=array('success'=>'true','msg'=>$data_found,'tradesman_arr'=>$trades_man,'cat_arr'=>$cat_arr); 
	jsonSendEncode($record);
?>