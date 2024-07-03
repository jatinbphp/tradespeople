<?php

    include 'con1.php';
    include 'function_app_common.php'; 
    include 'function_app.php';
    include('language_message.php');
    include('mailFunctions.php');

    if(!$_POST){
        $record=array('success'=>'false','msg' =>$msg_post_method); 
        jsonSendEncode($record); 
    }

    // for first name
    if(empty($_POST['contact_us_name'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    }
    
    // for email
    if(empty($_POST['contact_email'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    }
    
    // for message
    if(empty($_POST['contact_message'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    }
    
    if(empty($_POST['user_id_post'])){
        $record=array('success'=>'false','msg' =>$msg_empty_param); 
        jsonSendEncode($record); 
    }


    //-------------------------------- get all value in variables -----------------------
    $contact_us_name   =   $_POST['contact_us_name'];
    $contact_email      =   $_POST['contact_email'];
    $contact_message    =   $_POST['contact_message'];
    $type               =   $_POST['type'];
    $user_id_post       =   $_POST['user_id_post'];
    
    
    //-------------------------- check user user id --------------------------
    $check_user_id_all=$mysqli->prepare("SELECT id,f_name, l_name,type, phone_no FROM users WHERE id=?");
    $check_user_id_all->bind_param("i",$user_id_post);
    $check_user_id_all->execute();
    $check_user_id_all->store_result();
    $check_user_id=$check_user_id_all->num_rows;  //0 1
    if($check_user_id <= 0){
        $record=array('success'=>'false', 'msg' =>$msg_error_user_id); 
        jsonSendEncode($record); 
    }

    $check_user_id_all->bind_result($user_id_get,$first_name, $last_name,$type, $phone_no);
    $check_user_id_all->fetch();

    //--------------- check account activate or not ----------------------
    // $active_status = checkAccountActivateDeactivate($user_id_get);
    // if($active_status == 0){
    //     $record=array('success'=>'false','msg' =>$msg_error_activation, 'account_active_status'=>'deactivate'); 
    //     jsonSendEncode($record); 
    // }

    $updatetime     =   date("Y-m-d H:i:s");
    $createtime     =   date("Y-m-d H:i:s");
   
   // echo "INSERT INTO `contact_request`(`first_name`, `last_name`, `email`, `message`, ` phone_no`, `cdate`, `type`) VALUES ($first_name, $last_name, $contact_email,$contact_message,$phone_no, $createtime,$type)";
      
    $contact_add = $mysqli->prepare("INSERT INTO `contact_request`(`first_name`, `last_name`, `email`, `message`, `phone_no`, `cdate`, `type`) VALUES (?,?,?,?,?,?,?)");
    $contact_add->bind_param("ssssssi",$first_name, $last_name, $contact_email,$contact_message,$phone_no, $createtime,$type);
    $contact_add->execute();
    $contact_count=$mysqli->affected_rows;
    if($contact_count<=0){
        $record=array('success'=>'false','msg'=>$msg_error_contact_us); 
        jsonSendEncode($record);
    }
    
    $email_arr  =   array();

    $admin_details      =   getAdminDetails();
        
    // Send mail to admin for contact us        
    if($admin_details != 'NA'){
        $admin_email    =   $admin_details['email'];
        $admin_name     =   $admin_details['name'];
        // Start send mail
        $mail_content   =   '';
        
        $mail_content   .=  '<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">Contact name: '.$contact_us_name.' </p>';
        $mail_content   .=  '<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">Contact Email: '.$contact_email.'</p>';
        $mail_content   .=  '<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">Contact Message: '.$contact_message.'</p>';   

        $subject    =   'Contact us';
        $heading    =   'Contact us';

        $postData['subject']        =   $subject;
        $postData['mail_heading']   =   $heading;
        $postData['mailContent']    =   $mail_content;
        $postData['name']           =   $admin_name;
        $postData['email']          =   $admin_email;
        $postData['fromName']       =   $app_name;
        $postData['app_name']       =   $app_name;
        $postData['app_logo']       =   $app_logo;

        $mailBody                   =   mailBodySendData($postData);
        $email_arr[]                =   array('email'=>$postData['email'], 'fromName'=>$postData['fromName'], 'mailsubject'=>$postData['subject'], 'mailcontent'=>$mailBody, 'file'=>$contact_image);       
        // End send mail    
    }
    
    if(empty($email_arr)){
        $email_arr  =   'NA';
    }
    //-------------------------------- get user complete details --------------------------
    $record=array('success'=>'true','msg'=>$msg_success_contact_us, 'email_arr'=>$email_arr); 
    jsonSendEncode($record);
?>
