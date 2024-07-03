<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Local_Category extends CI_Controller {
	
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
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}	


  public function local_category() { 
		
		$where = "";
		
		$locations = false;
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$locations = $this->Common_model->GetColumnName('tbl_city',array('id'=>$_GET['location']));
			
			
			$where = "location = '".$_GET['location']."'";
		}
		
		$result['listing']=$this->Common_model->GetAllData('local_category',$where,'cat_id','desc');
		//$this->db->last_query();
		//print_r($locations);
		
		$result['locations'] = $locations;

		
		$this->load->view('Admin/local-category', $result);
		
	}

	public function add_category()
 	{
 		//echo "add";die;
 		$this->form_validation->set_rules('slug','Slug','required');
		//$this->form_validation->set_rules('title','Title','required');
		//$this->form_validation->set_rules('description','Description','required');
 		//$this->form_validation->set_rules('keyword','Keyword','required');
 		//$this->form_validation->set_rules('meta_description','Meta Description','required');
 		//$this->form_validation->set_rules('footer_description1','Footer Description','required');
 		if($this->form_validation->run()==true){

 			
 			$insert['cat_parent'] = $this->input->post('cat_parent');
 			$insert['slug'] = $this->input->post('slug');
			$insert['title'] = $this->input->post('title');
			$insert['description'] = $this->input->post('description');
			$insert['keyword'] = $this->input->post('keyword');
			$insert['meta_title'] = $this->input->post('meta_title');
			$insert['meta_description'] = $this->input->post('meta_description');
			$insert['location'] = $this->input->post('city');
			$insert['footer_description'] = $this->input->post('footer_description1');

	           if($_FILES['cat_image']['name']){                 
                    $config['upload_path']="./img/category";
                    $config['allowed_types'] = '*';
                    $config['encrypt_name']=true;
                    $this->load->library("upload",$config);
                    if ($this->upload->do_upload('cat_image')) {           
                    $u_profile=$this->upload->data("file_name");
                    $insert['image'] = $u_profile;
                }
             }
			
			$run=$this->Common_model->insert('local_category',$insert);

			//echo $this->db->last_query();
			
			if($run){
				
				$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Local Category has been added successfully.</div>');

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is Worng.</div>');
			}

			
		} else {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.validation_errors().'</div>');
		}
		
		$location = (isset($_GET['redirect_location'])) ? '?location='.$_GET['redirect_location'] : '';

		redirect('local-category'.$location);

 	}


public function edit_category()
 	{
 		//echo "add";die;
 		
 		$this->form_validation->set_rules('slug','Slug','required');
		//$this->form_validation->set_rules('title','Title','required');
		//$this->form_validation->set_rules('description','Description','required');
 		//$this->form_validation->set_rules('keyword','Keyword','required');
 		//$this->form_validation->set_rules('meta_description','Meta Description','required');
 		//$this->form_validation->set_rules('footer_description','Footer Description','required');
 		if($this->form_validation->run()==true){

 			$cat_id = $this->input->post('cat_id');
 			
 			$update['cat_parent'] = $this->input->post('cat_parent');
 			$update['slug'] = $this->input->post('slug');
			$update['title'] = $this->input->post('title');
			$update['description'] = $this->input->post('description');
			$update['keyword'] = $this->input->post('keyword');
			$update['meta_title'] = $this->input->post('meta_title');
			$update['meta_description'] = $this->input->post('meta_description');
			$update['location'] = $this->input->post('city');
			$update['footer_description'] = $this->input->post('footer_description');

			if($_FILES['cat_image']['name']){                 
                    $config['upload_path']="./img/category";
                    $config['allowed_types'] = '*';
                    $config['encrypt_name']=true;
                    $this->load->library("upload",$config);
                    if ($this->upload->do_upload('cat_image')) {           
                    $u_profile=$this->upload->data("file_name");
                    $update['image'] = $u_profile;
                }
             }
			
			
			$run=$this->Common_model->update_data('local_category',array('cat_id'=>$cat_id),$update);

			//echo $this->db->last_query();
			
			if($run){
				
				$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Local Category has been Updated successfully.</div>');

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is Worng.</div>');
			}

			
		} else {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.validation_errors().'</div>');
		}

		$location = (isset($_GET['redirect_location'])) ? '?location='.$_GET['redirect_location'] : '';

		redirect('local-category'.$location);

 	}

 	 public function disable_category()
 	{
 		//echo "add";die;
 		

 			$cat_id = $this->uri->segment(4);

			$run=$this->Common_model->update_data('local_category',array('cat_id'=>$cat_id),array('enabled'=>0));

			//echo $this->db->last_query();
			
			if($run){
				
				$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Local Category has been Disabled successfully.</div>');

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is Worng.</div>');
			}

			
		

		$location = (isset($_GET['redirect_location'])) ? '?location='.$_GET['redirect_location'] : '';

		redirect('local-category'.$location);

 	}

	 public function enable_category()
 	{
 		//echo "add";die;
 		

 			$cat_id = $this->uri->segment(4);

			$run=$this->Common_model->update_data('local_category',array('cat_id'=>$cat_id),array('enabled'=>1));

			//echo $this->db->last_query();
			
			if($run){
				
				$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Local Category has been Enabled successfully.</div>');

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is Worng.</div>');
			}

			
		

		$location = (isset($_GET['redirect_location'])) ? '?location='.$_GET['redirect_location'] : '';

		redirect('local-category'.$location);

 	}

	 public function delete_category()
 	{
 		//echo "add";die;
 		

 			$cat_id = $this->uri->segment(4);
			
			$run=$this->Common_model->delete(array('cat_id'=>$cat_id),'local_category');

			//echo $this->db->last_query();
			
			if($run){
				
				$this->session->set_flashdata('msg','<div class="alert alert-success">Success! Local Category has been Deleted successfully.</div>');

			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is Worng.</div>');
			}

			
		

		$location = (isset($_GET['redirect_location'])) ? '?location='.$_GET['redirect_location'] : '';

		redirect('local-category'.$location);

 	}
 

}