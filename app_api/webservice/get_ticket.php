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


 // echo $check_status;die;

  
   // ------------------- check user mobile ------------------- //


    // // ---------- check user account active/deactive status start ---------- //

  





$check_ticket_get_all=$mysqli->prepare("SELECT `id`, `ticket_id`, `is_admin`, `admin_id`, `user_id`, `created`, `sender_id`, `receiver_id` FROM `admin_chats` where user_id=? ORDER BY id DESC ");

  $check_ticket_get_all->bind_param("i",$user_id);

  $check_ticket_get_all->execute();

  $check_ticket_get_all->store_result();

  $check_ticket_get=$check_ticket_get_all->num_rows;  //0 1

  if($check_ticket_get > 0){



    $check_ticket_get_all->bind_result($id,$ticket_id,$is_admin,$admin_id,$user_id,$created, $sender_id, $receiver_id);

   while($check_ticket_get_all->fetch()){
	
$check_message_all=$mysqli->prepare("SELECT `id`, `message` FROM `admin_chat_details` WHERE admin_chat_id=$id ");

//$check_message_all->bind_param("i",$user_id);

$check_message_all->execute();
$check_message_all->store_result();
$check_msg=$check_message_all->num_rows;  //0 1

  if($check_msg > 0){



  $check_message_all->bind_result($id_get,$message);

$check_message_all->fetch();
	  }
	   $ticket_get_arr[]=array('id'=>$id,'ticket_id'=>$ticket_id,'is_admin'=>$is_admin,'admin_id'=>$admin_id,'created'=>$created,'sender_id'=> $sender_id,'receiver_id'=>$receiver_id,'ticket_message'=>$message);

  

    }

}
// echo $check_status;die;



if(empty($ticket_get_arr)){

    $ticket_get_arr='NA';

}





$record=array('success'=>'true','msg' =>$msg_data_found,'ticket_get_arr'=>$ticket_get_arr,); 

jsonSendEncode($record);



?>