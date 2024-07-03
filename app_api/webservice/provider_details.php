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
if(empty($_GET['provider_id'])){
  $record=array('success'=>'false', 'msg' =>$msg_empty_param); 
  jsonSendEncode($record); 
}
$userid       = $_GET['user_id'];
$provider_id    = $_GET['provider_id'];


//-------------------------- check user_id --------------------------
$check_user_all = $mysqli->prepare("SELECT id from users where id=?");
$check_user_all->bind_param("i",$userid);
$check_user_all->execute();
$check_user_all->store_result();
$check_user   = $check_user_all->num_rows;  //0 1
if($check_user <= 0){
  $record   = array('success'=>'false', 'msg'=>$msg_error_user_id); 
  jsonSendEncode($record);
}
$check_user_all->bind_result($user_id_get);
$check_user_all->fetch();
//-------------------------------------------------------------------------

//-------------------- -trades provider details--------------------------------------------
$job_detail            =   array();
$skill_arr             =   array();
$portfolio             =   array();
$portfolio_arr         = getPortfolio($provider_id);
$provider_avg_rate     =   getRatingAverage($provider_id);
$provider_rating_count = rateCount($provider_id);


$check_provider_arr = $mysqli->prepare("SELECT `trading_name`, `category` ,subcategory,cdate,county,city,profile,about_business,`insurance_liability`, `insurance_date`, `insured_by`, `insurance_amount`,qualification FROM `users` WHERE id=?");
$check_provider_arr->bind_param("i",$provider_id);
$check_provider_arr->execute();
$check_provider_arr->store_result();
$check_user_count   = $check_provider_arr->num_rows;  //0 1
if($check_user_count <= 0){
  $record   = array('success'=>'false', 'msg'=>$msg_error_user_id); 
  jsonSendEncode($record);
}
$check_provider_arr->bind_result($trading_name,$category,$subcategory,$cdate,$country,$city,$profile,$about_business,$insurance_liability, $insurance_date, $insured_by, $insurance_amount,$qualification);
$check_provider_arr->fetch();

$provider_details  = array();
$provider_avg_rate     = is_null($provider_avg_rate)?'0':$provider_avg_rate;
$provider_rating_count = is_null($provider_rating_count)?'0':$provider_rating_count;
$create_date = 'Member since '.date("M", strtotime($cdate)).' '.date("Y", strtotime($cdate));

    $insurance_date1 = date('d M Y',strtotime($insurance_date));
$provider_details = array(
  'trading_name'  =>  $trading_name,
  'category'    =>  $category,
  'provider_avg_rate'=>$provider_avg_rate,
  'country'=>$country,
  'city'=>$city,
  'create_date'=>$create_date,
  'provider_rating_count' =>$provider_rating_count,
  'profile'=>$profile,
  'insurance_liability'=>$insurance_liability,
  'description'=>$about_business,
  'insurance_date'=>$insurance_date1,
  'insured_by'=>$insured_by,
  'insurance_amount'=>$insurance_amount,
  'qualification'        =>  $qualification,
);

$skill_arr = array();
if(!is_null($category)){
  $category_arr = 'NA';

  $cat_arr1 = explode(",",$_GET['cat_id']);
  $subcat_id1 = explode(",",$_GET['subcat_id']);
  $getCounty=$mysqli->prepare("SELECT `cat_id`, `cat_name` FROM `category` WHERE cat_id IN($category) and cat_parent=0 and is_delete=0 and is_activate=1");
  $getCounty->execute();
  $getCounty->store_result();
  $getCounty_count=$getCounty->num_rows;  //0 1 
  if($getCounty_count > 0){
    $getCounty->bind_result($cat_id,$cat_name);
    while ($getCounty->fetch()) { 
      $skill_arr[] = array(
        'cat_id'=>$cat_id,
        'cat_name'=>$cat_name,
      );
    }
  }
} 

if(!empty($subcategory)){
	
  $get_sub_cat=$mysqli->prepare("SELECT `cat_id`, `cat_name` FROM `category` WHERE cat_id IN($subcategory)  and is_delete=0 and is_activate=1");
  $get_sub_cat->execute();
  $get_sub_cat->store_result();
  $get_sub_cat_count=$get_sub_cat->num_rows;  //0 1 
  if($get_sub_cat_count > 0){
    $get_sub_cat->bind_result($cat_id,$cat_name);
    while ($get_sub_cat->fetch()) { 
      $skill_arr[] = array(
        'cat_id'=>$cat_id,
        'cat_name'=>$cat_name,
      );
    }
  }
} 


$rating_arr  =  getReview($provider_id);
$p_user_arr    =  getUserDetails($provider_id);
if(empty($skill_arr)){
  $skill_arr = 'NA';
}
if(empty($provider_details)){
  $provider_details = 'NA';
}
if(empty($portfolio_arr)){
  $portfolio_arr = 'NA';
}
$record=array('success'=>'true','msg'=>$data_found,'skill_arr'=>$skill_arr,'portfolio_arr'=>$portfolio_arr,'provider_details'=>$provider_details,'rating_arr'=>$rating_arr,'p_user_arr'=>$p_user_arr); 
jsonSendEncode($record);



?>