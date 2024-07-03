<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		//date_default_timezone_set('Europe/London');
		$this->load->model('Admin_model');
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->check_login();
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId')) {
			redirect('Admin');
		}
	}
	public function make_job_page_publicly(){
		$status = $this->input->post('status');
		
		$this->Common_model->update('show_page',array('id'=>1),array('status'=>$status));
		
		if($status==1){
			$msg = "Search job page marked as public.";
		} else {
			$msg = "Search job page marked as private.";
		}
		
		echo json_encode(array('msg'=>$msg));
	}
	public function show_hide_budget_on_while_posting_job(){
		$status = $this->input->post('status');
		
		$this->Common_model->update('show_page',array('id'=>2),array('status'=>$status));
		
		/*if($status==1){
			$msg = "Budget status has been updated successfully.";
		} else {
			$msg = "Budget status has been updated successfully.";
		}*/
		
		$msg = "Budget status has been updated successfully.";
		
		echo json_encode(array('msg'=>$msg));
	}
	
	public function job_amount() {
		
		$page['lists'] = $this->Common_model->newgetRows('job_amount',null,'amount1','asc');
	
		$this->load->view('Admin/job_amount',$page);
		
	}
	public function add_job_amount() {
		
		$insert['amount1'] = $this->input->post('amount1');
		$insert['amount2'] = $this->input->post('amount2');
		
		$this->Common_model->insert('job_amount',$insert);
		
		$this->session->set_flashdata('msg','<div class="alert alert-success">Amount has been added successfully.</div>');
		
		redirect('Admin/job-amount');
		
	}
	
	public function edit_job_amount() {
		
		$id = $this->input->post('id');
		$insert['amount1'] = $this->input->post('amount1');
		$insert['amount2'] = $this->input->post('amount2');
		
		$this->Common_model->update_data('job_amount',array('id'=>$id),$insert);
		
		$this->session->set_flashdata('msg','<div class="alert alert-success">Amount has been updated successfully.</div>');
		
		redirect('Admin/job-amount');
		
	}
	
	public function delete_job_amount($id) {
		
		
		$this->Common_model->delete(array('id'=>$id),'job_amount');
		
		$this->session->set_flashdata('msg','<div class="alert alert-success">Amount has been deleted successfully.</div>');
		
		redirect('Admin/job-amount');
		
	}
	
	public function edit($id=null) {
		
		$post = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$id));
		if($post) {
			$page['category'] = $this->Common_model->get_parent_category('category');
			$page['post'] = $post;
			$page['cate_arr'] = explode(',',$post['subcategory_1']);
			
			$this->load->view('Admin/edit_posts',$page);
		} else {
			redirect('user_jobs');
		}
	}
	
	public function update_job(){
		$job_id = $this->input->post('id');
		$title = $this->input->post('title');
		$budget = $this->input->post('budget');
		$budget2 = $this->input->post('budget2');
		$description = $this->input->post('description');
		$category = $this->input->post('category');
		$subcategory = $this->input->post('subcategory');
		$subcategory_2 = $this->input->post('subcategory_2');
		$post_code = $this->input->post('post_code');
		
		$post_code1 = str_replace(" ","",$post_code);
		
		$check_postcode = $this->Common_model->check_postalcode($post_code1);
		
		if($check_postcode['status']==1){
			
			if($this->input->post('subcategory_3')){
				
				$subcategory = $this->input->post('subcategory_3');
				
			} else if($this->input->post('subcategory_2')){
				
				$subcategory = $this->input->post('subcategory_2');
				
			} else if($this->input->post('subcategory')){
				
				$subcategory = $this->input->post('subcategory');
				
			} else {
				
				$subcategory = $this->input->post('category');
				
			}
			
			$subcategory_3 = $this->input->post('subcategory_3');
			$subcategory_2 = $this->input->post('subcategory_2');
			$subcategory_1 = $this->input->post('subcategory');
			$category = $this->input->post('category');
			
			$comma_cate = '';
			
			$comma_cate .= ($category) ? $category . ',' : '';
			$comma_cate .= ($subcategory_1) ? $subcategory_1 . ',' : '';
			$comma_cate .= ($subcategory_2) ? $subcategory_2 . ',' : '';
			$comma_cate .= ($subcategory_3) ? $subcategory_3 . ',' : '';
			
			$comma_cate = rtrim($comma_cate,',');
			
			$update['title'] = $title;
			$update['budget'] = $budget;
			$update['budget2'] = $budget2;
			$update['description'] = $description;
			$update['category'] = $category;
			$update['subcategory'] = $subcategory;
			$update['subcategory_1'] = $comma_cate;
			$update['post_code'] = $post_code;
			
			$run = $this->Common_model->update('tbl_jobs',array('job_id'=>$job_id),$update);
			
			if($run){
				$this->session->set_flashdata('msg','<div class="alert alert-success">Job has been updated successfully.</div>');
				$json['status'] = 1;
			} else {
				$json['msg'] = '<div class="alert alert-danger">We did not find any changes.</div>';
				$json['status'] = 0;
			}
			
			
		} else {
			$json['status'] = 2;
		}
		
		echo json_encode($json);
		
	}
	
	public function check_postcode(){
		
		$post_code = $this->input->post('post_code');
			
		$post_code = str_replace(" ","",$post_code);
		
		$check_postcode = $this->Common_model->check_postalcode($post_code);
		
		if($check_postcode['status']==1){
			$json['status'] = 1;
		} else {
			$json['status'] = 0;
		}
		
		echo json_encode($json);
	}
}