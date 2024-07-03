<?php
include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_POST){
  $record=array('success'=>'false','msg' =>$msg_post_method); 
  jsonSendEncode($record);
}

if(empty($_POST['user_id'])){
  $record=array('success'=>'false','msg' =>$msg_for_user_id); 
  jsonSendEncode($record);
}

// if(empty($_POST['file_type'])){
//  $record=array('success'=>'false','msg' =>$chat_file_type); 
//  jsonSendEncode($record);
// }

// if(empty($_FILES['file']['name'])){
//  $record=array('success'=>'false','msg' =>$chat_file); 
//  jsonSendEncode($record);  
// }


//-------------------------------- get all value in variables -----------------------
$user_id= $_POST['user_id'];
$file_type= $_POST['file_type'];
$createtime= date('Y-m-d H:i:s');
$updatetime= date('Y-m-d H:i:s');


//-------------------------- check  user --------------------------
$check_user=$mysqli->prepare("SELECT user_id FROM user_master WHERE user_id=? AND delete_flag='no'");
$check_user->bind_param("i",$user_id);
$check_user->execute();
$check_user->store_result();
$check_user_all=$check_user->num_rows;  //0 1
if($check_user_all <= 0){
    $record=array('success'=>'false','msg' =>$msg_not_user_id); 
    jsonSendEncode($record);
}

//----------------------------- check account activate or not ----------------------
$active_status = checkAccountActivateDeactivate($user_id);
if($active_status == 'deactivate'){
    $record=array('success'=>'false','msg' =>$msg_activation, 'account_active_status'=>'deactivate'); 
    jsonSendEncode($record); 
}

$check_user->bind_result($user_id_get);
$check_user->fetch();
// ------------------------------- add user gallery  code ---------------------------
$file=$_FILES['image'];
$folder_name='images';
$file_type='image';//if we select image then type=image otherwise file.
$upload_status=uploadFile($file, $folder_name, $file_type);
       /*$upload_status=uploadFileMultiple($file, $folder_name, $file_type);
if($upload_status== 'error'){
      $record=array('success'=>'false','msg' =>$msg_gallery_failed); 
  jsonSendEncode($record); 
}

$uploaded_image_string = implode(',',$upload_status);

if(count($upload_profile) != $insert_image_affected){
  $record=array('success'=>'false','msg' =>array($msg_image_insert_error[0],$msg_image_insert_error[1],$msg_image_insert_error[2]),'user_id'=>$user_id_get); 
  jsonSendEncode($record);
}*/
           
$insert_all=$mysqli->prepare("INSERT INTO  chat_file_master(user_id, file_type, file, createtime, updatetime) VALUES (?,?,?,?,?)");
$insert_all->bind_param("issss",$user_id, $file_type, $upload_status, $createtime, $updatetime);
$insert_all->execute();
$insert=$mysqli->affected_rows; //
if($insert<=0){ 
  $record=array('success'=>'false','msg' =>$file_not_upload); 
  jsonSendEncode($record); 
}

$record=array('success'=>'true','msg' =>$file_upload_suc,'file'=>$upload_status); 
jsonSendEncode($record);

?>