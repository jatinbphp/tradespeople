<?php

include 'con1.php';

include 'function_app_common.php'; 

include 'function_app.php'; 

include 'language_message.php'; 







if(!$_GET){

    $record=array('success'=>'false','msg' =>$msg_get_method); 

    jsonSendEncode($record);

}

if(empty($_GET['user_id'])){

    $record=array('success'=>'false','msg' =>$msg_empty_param); 

    jsonSendEncode($record);

}

 $user_id=$_GET['user_id'];
 $check_status = $_GET['check_status'];
  
   // ------------------- check user mobile ------------------- //


    $check_user_all = $mysqli->prepare("SELECT id,type from users where id =?");

    $check_user_all->bind_param("i", $user_id);

    $check_user_all->execute();

    $check_user_all->store_result();

    $check_user = $check_user_all->num_rows;

    if($check_user <= 0) {

        $record = array('success'=>'true', 'msg'=>$user_not_found); 

        jsonSendEncode($record);

    }
           $check_user_all->bind_result($user_id,$user_type);
           $check_user_all->fetch();

    // // ---------- check user account active/deactive status start ---------- //

  







$check_categroy_data_all=$mysqli->prepare("SELECT `cat_id`, `cat_name`  FROM `category`  WHERE is_delete =0 and cat_parent=0");


  $check_categroy_data_all->execute();

  $check_categroy_data_all->store_result();

  $check_categroy_data=$check_categroy_data_all->num_rows;  //0 1

  if($check_categroy_data > 0){
$check_categroy_data_all->bind_result($cat_id,$cat_name);

        while($check_categroy_data_all->fetch()){
 
          $categroy_data_arr[]=array(
              'cat_name'=>$cat_name,
              'cat_id'=>$cat_id,
			  'status'=>'false'                     
            );
    }

}

$checklocation_all=$mysqli->prepare("SELECT `id`, `county_id`, `city_name` FROM `tbl_city` WHERE is_delete =0");


  $checklocation_all->execute();

  $checklocation_all->store_result();

 $check_location=  $checklocation_all->num_rows;  //0 1

  if($check_location > 0){
$checklocation_all->bind_result($id,$county_id,$city_name);

        while($checklocation_all->fetch()){
 
          $location_arr[]=array(
              'city_name'=>$city_name,
              'id'=>$id,
			  'status'=>'false'                     
            );
    }

}

if(empty($categroy_data_arr)){

    $categroy_data_arr='NA';

}

if(empty($location_arr)){

    $location_arr='NA';

}




$record=array('success'=>'true','msg' =>$msg_data_found,'categroy_data_arr'=>$categroy_data_arr,'location_arr'=>$location_arr); 

jsonSendEncode($record);



?>