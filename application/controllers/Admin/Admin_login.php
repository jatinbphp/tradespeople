<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_login extends CI_Controller {
	
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
		$this->check_login();
	}
	public function check_login() {
		if($this->session->userdata('session_adminId'))
		{
			redirect('Admin_dashboard');
		}
	}
	public function index()
	{	
		if(isset($_POST['login']) && ($_POST['login']=='login')){	
   			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('password','Password','required|trim');
			
			if($this->form_validation->run() ==FALSE){	  
				$this->session->set_userdata('error',validation_errors());
				return redirect('Admin');
			} else {
				$data_arr=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password')); 
				$result=$this->Common_model->admin_login($data_arr);
		           
				if($result){
					$this->session->set_userdata(array('session_adminId'=>$result['id'],'type_admin'=>$result['type']));
					return redirect('Admin_dashboard','refresh');
				}else{
					$this->session->set_flashdata('error', 'Invalid Email or Password!');
					return redirect('Admin');
				}
			}
		} else {		
				$this->load->view('Admin/index');
		}   
	} 
}
?>