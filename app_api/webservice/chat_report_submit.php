<?php
    include 'con1.php';
    include 'function_app_common.php';
    include 'function_app.php';
    include 'language_message.php';
   
    if(!$_GET){
        $record = array('success'=>'false', 'msg'=>$msg_get_method);
        jsonSendEncode($record);
    }
    if(empty($_GET['user_id'])){
        $record = array('success'=>'false', 'msg'=>$msg_empty_param);
        jsonSendEncode($record);
    }   

    if(empty($_GET['other_user_id'])){
        $record = array('success'=>'false', 'msg'=>$msg_empty_param);
        jsonSendEncode($record);
    }
   
   
    /****************** get all value in variables start ******************/
    $currentDate        =   date("Y-m-d H:i:s");
    $user_id            =   $_GET['user_id'];
    $other_user_id      =   $_GET['other_user_id'];
    $report_type        =   $_GET['report_type'];
    $delete_flag        =   0;
    /******************* get all value in variables end *******************/
   
    //-------------------------- check user user id --------------------------
    $check_user_id_all=$mysqli->prepare("SELECT user_id FROM user_master WHERE delete_flag=0 and user_id=?");
    $check_user_id_all->bind_param("i",$user_id);
    $check_user_id_all->execute();
    $check_user_id_all->store_result();
    $check_user_id=$check_user_id_all->num_rows;  //0 1
    if($check_user_id <= 0){
        $record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
        jsonSendEncode($record); 
    }

    $check_user_id_all->bind_result($user_id_get);
    $check_user_id_all->fetch();

    //--------------- check account activate or not ----------------------
    $active_status = checkAccountActivateDeactivate($user_id_get);
    if($active_status == 0){
        $record=array('success'=>'false','msg' =>$msg_error_activation, 'account_active_status'=>'deactivate'); 
        jsonSendEncode($record); 
    }


    $check_report = $mysqli->prepare("SELECT chat_report_id FROM chat_report WHERE user_id =? AND other_user_id =? AND delete_flag =0");
    $check_report->bind_param('ii',$user_id, $other_user_id);
    $check_report->execute();
    $check_report->store_result();
    $count_report = $check_report->num_rows;
    if($count_report > 0){
        $record = array('success'=>'false', 'msg'=>$reportallredySuccess);  
        jsonSendEncode($record);
    }else{
        $update_report = $mysqli->prepare("INSERT INTO chat_report(user_id, other_user_id, delete_flag, createtime, updatetime)VALUES(?,?,?,?,?) ");
        $update_report->bind_param('iisss', $user_id, $other_user_id, $delete_flag, $currentDate, $currentDate);
        $update_report->execute();
        $update_report_afected = $mysqli->affected_rows;
        if($update_report_afected <=0){
            $record = array('success'=>'false', 'msg'=>$report_error);  
            jsonSendEncode($record);
        }
    }
    $report_user = getUserDetails($other_user_id);
    $user_name = $report_user["name"];
    $record = array('success'=>'true', 'msg'=>$reportSuccess);  
    jsonSendEncode($record);

?>



