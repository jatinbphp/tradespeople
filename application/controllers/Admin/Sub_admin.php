<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sub_admin extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->check_login();
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	public function index(){
		$page['roles'] = $this->Common_model->get_all_data('roles',array('id != '=>15,'id')); 
		$page['sub_admin'] = $this->Common_model->get_all_data('admin',array('id != '=>1,'id')); 
		$this->load->view('Admin/sub_admin',$page);		
	}
	public function edit_suadmin(){
		
		$id = $this->input->post('id');
		
		$this->form_validation->set_rules('username','Name','required');
		$this->form_validation->set_rules('roles[]','Rules','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required|min_length[6]|matches[password]');
		
		if($this->form_validation->run()){
			
			$insert['email'] = $this->input->post('email');
			
			$check = $this->Common_model->get_single_data('admin',array('email'=>$insert['email'],'id != '=>$id));
			
			if($check==false){
			
				$insert['username'] = $this->input->post('username');
				
				$insert['password'] = $this->input->post('password');
				$insert['roles'] = implode(',',$this->input->post('roles'));
				$insert['status'] = 1;
				$insert['type'] = 2;
				
				$run = $this->Common_model->update_data('admin',array('id'=>$id),$insert);
				//echo $this->db->last_query();
				if($run){
					
					$json['status'] = 1;
					$this->session->set_flashdata('success','Sub admin account has been updated successfully');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">We did not found any changes.</div>';
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">This email address already used.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}
		echo json_encode($json);
	}

	public function delete_subadmin($id){
		
		$session_adminId = $this->session->userdata('session_adminId');
		if($session_adminId == 1 && $id){
			
			$run = $this->Common_model->delete(array('id'=>$id),'admin');
			
			if($run){
				$this->session->set_flashdata('success','Sub admin has been deleted successfully.');
			} else {
				$this->session->set_flashdata('error','Something went wrong, try again later.');
			}
			
		} else {
			$this->session->set_flashdata('error','1Something went wrong, try again later.');
		}
		redirect('Admin/sub_admin/');
	}

	public function add_suadmin(){
		$this->form_validation->set_rules('username','Name','required');
		$this->form_validation->set_rules('roles[]','Rules','required');
		$this->form_validation->set_rules('email','Email','required|is_unique[admin.email]|valid_email');
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required|min_length[6]|matches[password]');
		
		if($this->form_validation->run()){
			$insert['username'] = $this->input->post('username');
			$insert['email'] = $this->input->post('email');
			$insert['password'] = $this->input->post('password');
			$insert['roles'] = implode(',',$this->input->post('roles'));
			$insert['status'] = 1;
			$insert['type'] = 2;
			
			$run = $this->Common_model->insert('admin',$insert);
			
			if($run){
				
				$subject = "Congratulation: Your account have been created as sub admin";
				
				$content = '<p class="text-center">Hello '.$insert['username'].',</p>';
				$content .= '<p class="text-center">Congratulation: You account have been created as sub admin at <a href="'.site_url().'">Traderspeoplehub</a></p>';
				$content .= '<p class="text-center">Login details are as follow:</p>';
				$content .= '<p class="text-center">username: '.$insert['email'].'</p>';
				$content .= '<p class="text-center">password: '.$insert['password'].'</p>';
				$content .= '<p class="text-center">url: <a href="'.site_url().'Admin">'.site_url().'Admin</a></p>';
				
				$this->Common_model->send_mail($insert['email'],$subject,$content,null,null,'support');
				
				$json['status'] = 1;
				$this->session->set_flashdata('success','Sub admin account has been created successfully');
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}
		echo json_encode($json);
	}
}