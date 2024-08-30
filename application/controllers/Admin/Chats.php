<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Chats extends CI_Controller {
  
  public function __construct() {
    parent::__construct();
    date_default_timezone_set('Europe/London');
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    //$this->email->initialize($config);
    $this->load->library('form_validation');
    //$this->lang->load('message','english');
    $this->load->model('Admin_model');
    $this->load->model('Common_model');
    $this->load->model('My_model');
    $this->check_login();
  }
  public function check_login() {
    if(!$this->session->userdata('session_adminId')){
      redirect('Admin');
    }
  }

  public function index() {
    $pageData['selectedUserChatId'] = (isset($_GET['admin_chat_id'])) ? $_GET['admin_chat_id'] : '';

    $where['sender_id'] = 0;
    // $where['sender_id'] = $this->session->userdata('session_adminId');
    $joins[0][] = 'users';
    if(isset($_GET['m']) && $_GET['m']==1){
      $joins[0][] = 'admin_chats.user_id = users.id and users.type=3';
    }else{
      $joins[0][] = 'admin_chats.user_id = users.id and users.type=1 OR users.type=2';
    }
    $joins[0][] = 'left';

    $select = 'users.id, users.f_name, users.l_name, users.type, users.email, users.profile, admin_chats.id AS admin_chat_id, admin_chats.user_id, admin_chats.ticket_id, admin_chats.ticket_status';

    $chatUsers = $this->Common_model->join_records('admin_chats', $joins, false, $select, 'admin_chats.id');

    $set_admin_chat_id = false;
    foreach($chatUsers as $key => $chatUser){
      if(!$chatUser['admin_chat_id']) continue;
      if(!$set_admin_chat_id){
        $set_admin_chat_id = ($chatUser['admin_chat_id']) ? $chatUser['admin_chat_id'] : 0;
        $this->session->set_userdata('admin_chat_id', $set_admin_chat_id);
      }
      $whereChatDetails = [];
      $whereChatDetails['admin_chat_id'] = $chatUser['admin_chat_id'];
      // $whereChatDetails['sender_id !='] = 0;
      $whereChatDetails['is_read'] = 0;
      $whereChatDetails['is_admin !='] = 1;
      $unreadCount = $this->Common_model->fetch_records('admin_chat_details', $whereChatDetails, false, false, 'id');
      $chatUsers[$key]['unreadCount'] = count($unreadCount);

      $whereMessage = [];
      $whereMessage['admin_chat_id'] = $chatUser['admin_chat_id'];
      $message = $this->Common_model->fetch_records('admin_chat_details', $whereMessage, false, false, 'id');
      $chatUsers[$key]['lastMessage'] = $message[0]['message'];
    }

    $pageData['chatUsers'] = $chatUsers;

    $this->load->view('Admin/message_center_view', $pageData);
  }

  public function details($id){
    $whereUnread['is_admin'] = 0;
    $whereUnread['sender_id'] = $id;
    // $whereUnread['sender_id'] = $this->session->userdata('session_adminId');
    $updateRead['is_read'] = 1;
    $this->Common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['receiver_id'] = $id;
    $whereReceiver['id'] = $id;
    $receiverData = $this->Common_model->newgetRows('users', $whereReceiver);
    $pageData['receiverData'] = $receiverData[0];
    $pageData['isNewChat'] = $this->Common_model->newgetRows('admin_chats', $where);
    $pageData['admin_chat_id'] = 0;
    if(!empty($pageData['isNewChat'])){
      $whereChatDetails['admin_chat_id'] = $pageData['isNewChat'][0]['id'];
      $pageData['admin_chat_id'] = $whereChatDetails['admin_chat_id'];
      $pageData['chatDetails'] = $this->Common_model->newgetRows('admin_chat_details', $whereChatDetails);
    }

    $this->load->view('Admin/message_center_details_view', $pageData);
  }

  public function send_message(){
    $response['status'] = 0;
    $response['responseMessage'] = 'Something went wrong, please try again later.';

    $sender_id = $this->session->userdata('session_adminId');
    // $sender_id = 0;
    $admin_chat_id = $this->input->post('admin_chat_id');
    $insert['message'] = $this->input->post('message');
    $email = $this->input->post('email');
    $name = $this->input->post('username');
    $insert['receiver_id'] = $this->input->post('receiver_id');
    $insert['sender_id'] = $sender_id;
    $insert['is_read'] = 0;
    // $insertAdminChat['is_admin'] = 1;
    $insert['is_admin'] = 1;
    $insert['create_time'] = date("Y-m-d H:i:s");
    if($admin_chat_id == 0){
      $insertAdminChat['admin_id'] = $insert['sender_id'];
      $insertAdminChat['user_id'] = $insert['receiver_id'];
      $insertAdminChat['ticket_id'] = uniqid();
      $insertAdminChat['created'] = date("Y-m-d H:i:s");
      $insert['admin_chat_id'] = $this->Common_model->insert('admin_chats', $insertAdminChat);
      if($insert['admin_chat_id']){
        $response['admin_chat_id'] = $insert['admin_chat_id'];
        if($this->Common_model->insert('admin_chat_details', $insert)){

          /* Notification */
          $insertNotification['nt_userId'] = $insert['receiver_id'];
          $insertNotification['nt_message'] = 'You´ve got a new message from the support team. <a href="'.site_url().'Support/details/' .$insert['admin_chat_id'] .'">View now</a>';
          $insertNotification['nt_satus'] = 0;
          $insertNotification['nt_apstatus'] = 0;
          $insertNotification['nt_create'] = date('Y-m-d H:i:s');
          $insertNotification['nt_update'] = date('Y-m-d H:i:s');
          $insertNotification['posted_by'] = $sender_id;
          $this->Common_model->insert('notification',$insertNotification);
          /* Notification */

          $response['status'] = 1;
          $response['responseMessage'] = 'Message sent successfully.';
          $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissible">' .$response['responseMessage'] .'</div>');
        }
      }
    }else{
      $insert['admin_chat_id'] = $admin_chat_id;
      if($this->Common_model->insert('admin_chat_details', $insert)){

        /* Notification */
        $insertNotification['nt_userId'] = $insert['receiver_id'];
        $insertNotification['nt_message'] = 'You´ve got a message from the support team. <a href="'.site_url().'Support/details/' .$insert['admin_chat_id'] .'"> View now</a>';
        $insertNotification['nt_satus'] = 0;
        $insertNotification['nt_apstatus'] = 0;
        $insertNotification['nt_create'] = date('Y-m-d H:i:s');
        $insertNotification['nt_update'] = date('Y-m-d H:i:s');
        $insertNotification['posted_by'] = $sender_id;
        $this->Common_model->insert('notification', $insertNotification);
        /* Notification */

        $response['status'] = 1;
        $response['responseMessage'] = 'Message sent successfully.';
        $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissable">' .$response['responseMessage'] .'</div>');
      }
      $response['admin_chat_id'] = $insert['admin_chat_id'];
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) $this->send_chat_notification($email, $name, $response['admin_chat_id']);

    echo json_encode($response);
  }

  private function send_chat_notification($to, $name, $chat_id){
    $subject = 'You´ve got a new message from Tradespeople Hub';
    $content = '<p style="margin:0;padding:10px 0px">Hi ' .$name .',</p>';
    $content .= '<p style="margin:0;padding:10px 0px">You´ve got a message from our support team. Please log in to your account to read the message or click the view message below.</p>';
    $content .= '<br><div style="text-align:center"><a href="' .site_url('Support/details/' .$chat_id) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Message</a></div><br>';
    $content .= '<p style="margin:0;padding:10px 0px">Visit our help page or contact our customer service if you have any specific questions using our service.</p>';

    $this->Common_model->send_mail($to, $subject, $content,null,null,'support');
  }

  public function get_messages(){
    // $this->load->helper('my_helper');
    $admin_chat_id = $this->input->post('admin_chat_id');
    $whereUnread['admin_chat_id'] = $admin_chat_id;
    $whereUnread['is_admin !='] = 1;
    $updateRead['is_read'] = 1;
    $this->Common_model->update('admin_chat_details', $whereUnread, $updateRead);
    $LastChatDetails = $this->db->where('id', $admin_chat_id)->get('admin_chats')->row_array();

    $response['status'] = 0;
    $response['admin_chat_id'] = 0;
    $response['messages'] = '';
    $response['totalMessages'] = 0;
    $response['ticket_status'] = $LastChatDetails['ticket_status'];
    

    $this->db->where('id', $admin_chat_id);
    $query = $this->db->get('admin_chats');
    $result = $query->result_array();

    if(!empty($result)){
      $result = $result[0];
      $response['admin_chat_id'] = $result['id'];
      $messages = $this->Common_model->get_all_data('admin_chat_details', array('admin_chat_id' => $response['admin_chat_id']));
      if(!empty($messages)){
        $response['totalMessages'] = count($messages);
        $response['btn_text'] = 'Reply'; 
        foreach($messages as $message){
          if($message['is_admin'] == 1){
            $content .= '<li class="recever">';
          }else{
            $content .= '<li class="sender">';
            $userDetails = $this->Common_model->get_all_data('users', array('id' => $message['sender_id']));
            $profile = 'img/profile/';
            $profile .= ($userDetails['profile']) ? $userDetails['profile'] : 'dummy_profile.jpg';
          }
          $content .= '<div class="message-data">';
          if($message['is_admin'] == 0){
            $content .= '<div class="mess_dat_img">
                <img src="' .site_url($profile) .'">
              </div>';
          }
          $content .= '<div class="messge_cont">
                <p>
                  <span class="message_box"> ' .$message['message'] .'</span>
                </p>
                <span class="time"><i class="fa fa-clock-o"></i> ' .date("h:i A", strtotime($message['create_time'])) .'</span>
              </div>
            </div>
          </li>

          ';
        }
        $response['messages'] = $content;
      }else{
        $response['btn_text'] = 'Send'; 

      }
     

      $response['status'] = 1;
    }
    $this->session->set_userdata('admin_chat_id', $response['admin_chat_id']);
    echo json_encode($response);
  }

  public function refresh_messages(){
    // $this->load->helper('my_helper');
    $response['status'] = 0;
    $response['admin_chat_id'] = $this->session->userdata('admin_chat_id');
    $response['messages'] = '';
    $response['totalMessages'] = 0;

    $messages = $this->Common_model->get_all_data('admin_chat_details', array('admin_chat_id' => $response['admin_chat_id']));
    if(!empty($messages)){
      $response['totalMessages'] = count($messages);
      foreach($messages as $message){
        if($message['is_admin'] == 1){
          $content .= '<li class="recever">';
        }else{
          $content .= '<li class="sender">';
          $userDetails = $this->Common_model->get_all_data('users', array('id' => $message['sender_id']));
          $profile = 'img/profile/';
          $profile .= ($userDetails['profile']) ? $userDetails['profile'] : 'dummy_profile.jpg';
        }
        $content .= '<div class="message-data">';
        if($message['is_admin'] == 0){
          $content .= '<div class="mess_dat_img">
              <img src="' .site_url($profile) .'">
            </div>';
        }
        $content .= '<div class="messge_cont">
              <p>
                <span class="message_box"> ' .$message['message'] .'</span>
              </p>
              <span class="time"><i class="fa fa-clock-o"></i> ' .date("h:i A", strtotime($message['create_time'])) .'</span>
            </div>
          </div>
        </li>';
      }
      $response['messages'] = $content;
    }

    echo json_encode($response);
  }

  public function close_ticket()
  {
    // print_r($_POST);
    $admin_chat_id = $this->input->post('admin_chat_id');
    $user_id = $this->input->post('user_id');

    $run = $this->Common_model->update('admin_chats', ['id'=>$admin_chat_id], ['ticket_status'=>1]);
    if($run){
      $response['status'] = 1;
      $response['responseMessage'] = 'Ticket closed successfully.';

      $user = $this->db->where('id', $user_id)->get('users')->row_array();
      $tickets = $this->db->where('id', $admin_chat_id)->get('admin_chats')->row_array();

      $subject = 'Your support ticket is now closed : '.$tickets['ticket_id'];
      $content = '<p style="margin:0;padding:10px 0px">Hi ' .$user['f_name'] .',</p>';
      $content .= '<p style="margin:0;padding:10px 0px">A solution was proposed for your support ticket '.$tickets['ticket_id'].' few days ago.</p>';
      $content .= '<p style="margin:0;padding:10px 0px">As we have not received a response, we have now closed the ticket. However should you require further assistance, please create a new support ticket.</p>';

      if($user['type']==1){ //tradsman
        $content .= '<p style="margin:0;padding:10px 0px">Visit our tradespeople help page or contact our customer service if you have any specific questions using our service.</p>';
      }else if($user['type']==2){ //homeowner
        $content .= '<p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer service if you have any specific questions using our service.</p>';
      }

      $this->Common_model->send_mail($user['email'], $subject, $content);




    }else{
      $response['responseMessage'] = 'Something wrong.';
      $response['status'] = 0;

    }
    echo json_encode($response);

  }


}