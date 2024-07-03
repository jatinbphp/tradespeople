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
 $id=$_GET['id'];

 // echo $check_status;die;

  
   // ------------------- check user mobile ------------------- //


    // // ---------- check user account active/deactive status start ---------- //

  
$check_message_all=$mysqli->prepare("SELECT `id`, `message`,create_time FROM `admin_chat_details` WHERE admin_chat_id=$id ORDER BY id DESC");

//$check_message_all->bind_param("i",$user_id);

$check_message_all->execute();
$check_message_all->store_result();
$check_msg=$check_message_all->num_rows;  //0 1

  if($check_msg > 0){



  $check_message_all->bind_result($id_get,$message,$create_time);

  while($check_message_all->fetch()){
	
	   $ticket_get_arr[]=array('id_get'=>$id_get,'message'=>$message,'create_time'=>$create_time);

    }
  }

    


// echo $check_status;die;



if(empty($ticket_get_arr)){

    $ticket_get_arr='NA';

}





$record=array('success'=>'true','msg' =>$msg_data_found,'ticket_get_arr'=>$ticket_get_arr,); 

jsonSendEncode($record);



?>