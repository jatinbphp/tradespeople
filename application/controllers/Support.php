<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->db->query("set sql_mode = ''");
		$this->load->model('common_model');
		date_default_timezone_set('Europe/London');
		$this->perPage = 10;
	}

  public function check_login() {
    if(!$this->session->userdata('user_logIn')){
      redirect('login');
    }
  }

  public function new_ticket(){
    $this->check_login();

    // $whereUnread['receiver_id'] = $this->session->userdata('user_id');
    // $updateRead['is_read'] = 1;
    // $this->common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['user_id'] = $this->session->userdata('user_id');
    $adminChats = $this->common_model->newgetRows('admin_chats', $where);
    foreach($adminChats as $key => $adminChat){
      $whereChat['admin_chat_id'] = $adminChat['id'];
      $admin_chat_details = $this->common_model->newgetRows('admin_chat_details', $whereChat, 'id');
      $adminChats[$key]['message'] = $admin_chat_details;
    }
    $pageData['adminChats'] = $adminChats;
    $pageData['logged_in_user'] = $where['user_id'];
    $pageData['receiverData']['f_name'] = 'Support';
    $pageData['receiverData']['l_name'] = 'Team';
    $pageData['receiverData']['id'] = 0;
    $pageData['admin_chat_id'] = 0;

    $this->load->view('site/new_ticket', $pageData);
  }

  public function tickets(){
    $this->check_login();

    // $whereUnread['receiver_id'] = $this->session->userdata('user_id');
    // $updateRead['is_read'] = 1;
    // $this->common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['user_id'] = $this->session->userdata('user_id');
    $adminChats = $this->common_model->newgetRows('admin_chats', $where,'id');

    foreach($adminChats as $key => $adminChat){
      $whereChat['admin_chat_id'] = $adminChat['id'];
      $admin_chat_details = $this->common_model->newgetRows('admin_chat_details', $whereChat, 'id');
      $adminChats[$key]['message'] = $admin_chat_details;
    }
    $pageData['adminChats'] = $adminChats;
    $pageData['logged_in_user'] = $where['user_id'];
    $pageData['receiverData']['f_name'] = 'Support';
    $pageData['receiverData']['l_name'] = 'Team';
    $pageData['receiverData']['id'] = 0;
    $pageData['admin_chat_id'] = 0;

    $this->load->view('site/support_center_view', $pageData);
  }

  public function details($id){
    $this->check_login();

    $whereUnread['receiver_id'] = $this->session->userdata('user_id');
    $updateRead['is_read'] = 1;
    $this->common_model->update('admin_chat_details', $whereUnread, $updateRead);

    $where['user_id'] = $this->session->userdata('user_id');
    $where['id'] = $id;
    $pageData['logged_in_user'] = $where['user_id'];
    $pageData['receiverData']['f_name'] = 'Support';
    $pageData['receiverData']['l_name'] = 'Team';
    $pageData['receiverData']['id'] = 0;
    $pageData['admin_chat_id'] = 0;

    $pageData['adminChats'] = $this->common_model->newgetRows('admin_chats', $where);

    if(!empty($id)){
      $whereChatDetails['admin_chat_id'] = $id;
      $pageData['admin_chat_id'] = $whereChatDetails['admin_chat_id'];
      // $chatDetailsArr = $this->common_model->newgetRows('admin_chat_details', $whereChatDetails);
      $pageData['chatDetails'] = $this->common_model->newgetRows('admin_chat_details', $whereChatDetails);
      $LastChatDetails = $this->db->where($whereChatDetails)->order_by('id',"desc")->limit(1)->get('admin_chat_details')->row_array();
    }else{
      redirect('Support/tickets');
      /* Admin not started chat yet. */
    }
    $this->session->set_userdata('admin_chat_id', $pageData['admin_chat_id']);
    // echo "<pre>"; print_r($pageData['adminChats']);
    //  exit();

    $this->load->view('site/message_center_details_view', $pageData);
  }

  public function send_message(){
    $response['status'] = 0;
    $sender_id = $this->session->userdata('user_id');
    $admin_chat_id = $this->input->post('admin_chat_id');
    $insert['message'] = $this->input->post('message');
    $insert['receiver_id'] = $this->input->post('receiver_id');
    $insert['sender_id'] = $sender_id;
    $insert['is_read'] = 0;
    $insert['create_time'] = date("Y-m-d H:i:s");
    $insert['admin_chat_id'] = $admin_chat_id;
    $insert['is_admin'] = 0;
    if($admin_chat_id == 0){
      $insertAdminChat['user_id'] = $insert['sender_id'];
      $insertAdminChat['admin_id'] = $insert['receiver_id'];
      $insertAdminChat['ticket_id'] = uniqid();
      $insertAdminChat['created'] = date("Y-m-d H:i:s");
      $insert['admin_chat_id'] = $this->common_model->insert('admin_chats', $insertAdminChat);
      if($insert['admin_chat_id']){
        if($this->common_model->insert('admin_chat_details', $insert)){
          $response['status'] = 1;
          $response['responseMessage'] = 'Message sent successfully.';
          $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissible">' .$response['responseMessage'] .'</div>');
        }
      }
    }else{
      if($this->common_model->insert('admin_chat_details', $insert)){
        $response['status'] = 1;
        $response['responseMessage'] = 'Message sent successfully.';
        $this->session->set_flashdata('responseMessage', '<div class="alert alert-success alert-dismissible">' .$response['responseMessage'] .'</div>');
      }
    }
    $this->session->set_userdata('admin_chat_id', $insert['admin_chat_id']);
    $response['admin_chat_id'] = $insert['admin_chat_id'];

    // $email = $this->input->post('email');
    // $name = $this->input->post('username');
    // $this->send_chat_notification($email, $name);

    echo json_encode($response);
  }

  private function send_chat_notification($to, $name){
    $subject = 'You´ve got a new message from Tradespeople Hub';
    $content = '<p style="margin:0;padding:10px 0px">Hi ' .$name .',</p>';
    $content .= '<p style="margin:0;padding:10px 0px">You´ve got a message from our support team. Please log in to your account to read the message or click the view message below.</p>';
    $content .= '<br><div style="text-align:center"><a href="'.site_url().'Chat/details" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Message</a></div><br>';
    $content .= '<p style="margin:0;padding:10px 0px">Visit our help page or contact our customer service if you have any specific questions using our service.</p>';

    $this->Common_model->send_mail($to, $subject, $content);
  }

}
?>