<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Posts extends CI_Controller {
  
  public function __construct() {
    parent::__construct();
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
	
	public function sendEmailToUser(){
		$email = $this->input->post('email');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		
		$run = $this->Common_model->send_mail($email,$subject,$message,null,null,'support');
		
		if($run){
			echo 1;
		} else {
			echo 0;
		}
	}

  public function index() {
    $result['user_jobs'] = $this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1,'status'=>1),'job_id');

    $this->load->view('Admin/edit_posts',$result);
  }

}