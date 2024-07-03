<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
	
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

	function addeditorimage(){

		$url = array(
			site_url()
		);

		reset($_FILES);
		$temp = current($_FILES);

		if (is_uploaded_file($temp['tmp_name'])) {
			if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name,Bad request");
        return;
			}
    
			// Validating File extensions
			if (! in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif","jpg", "png"))) {
        header("HTTP/1.1 400 Not an Image");
        return;
			}
    
			$filesname = site_url()."img/common/" . $temp['name'];
			$fileName = "img/common/" . $temp['name'];
			move_uploaded_file($temp['tmp_name'], $fileName);
    
			// Return JSON response with the uploaded file path.
			echo json_encode(array(
        'file_path' => $filesname
			));
		}
	} 


	public function index() { 
		//  $result['categorylist']=$this->My_model->alldata('category');
		$result['listing']=$this->Common_model->newgetRows('tbl_blogs','','b_id');
		if($result['listing']==''){
			$result['listing']  =array();     
		}
		
		$this->load->view('Admin/blog',$result);		
	}

	 public function add_blog(){
	 	$json['status'] = 0;
		$this->form_validation->set_rules('b_title','Title','required');
		$this->form_validation->set_rules('b_description','Description','required');
		$this->form_validation->set_rules('slug','Slug name','trim|required|alpha_dash|is_unique[tbl_blogs.slug]',array('is_unique'=>'This slug already exist'));
		if ($this->form_validation->run()==false){
		   $json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
		$file_check=false;
	    if($_FILES['b_image']['name']!=''){	 
			$config['upload_path']   = './img/blog/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';  
			$config['remove_spaces'] = TRUE;	
			$config['encrypt_name'] = TRUE;	 
			$this->load->library('upload', $config);
			  
			//$this->upload->do_upload('cat_image');
			 if($this->upload->do_upload('b_image'))
	         {
	            $data = $this->upload->data();  
	            $file_check = true;    
	         }
	         else
	         {
	            $json['msg'] = '<div class="alert alert-danger">'.$this->upload->display_errors().'<div>';
       
	         }
			
		}
		if($file_check==true)
		{
				      $insert_arr = array(
							'b_title' => $this->input->post('b_title'),
							'b_description'=>$this->input->post('b_description'),
							'b_image'=>$data['file_name'],
							'b_cdate'=>date('Y-m-d h:i:s'),
							'slug'=>$this->input->post('slug'),
							'b_meta_title'=>$this->input->post('b_meta_title'),
							'b_meta_key'=>$this->input->post('b_meta_key'),
							'b_meta_description'=>$this->input->post('b_meta_description')
							/*'footer_b_meta_title'=>$this->input->post('footer_b_meta_title'),
							'footer_b_meta_key'=>$this->input->post('footer_b_meta_key'),
							'footer_b_meta_description'=>$this->input->post('footer_b_meta_description')*/
						); 
		}
		else
		{

			
				      $insert_arr = array(
							'b_title' => $this->input->post('b_title'),
							'b_description'=>$this->input->post('b_description'),
							'b_cdate'=>date('Y-m-d h:i:s'),
							'slug'=>$this->input->post('slug'),
							'b_meta_title'=>$this->input->post('b_meta_title'),
							'b_meta_key'=>$this->input->post('b_meta_key'),
							'b_meta_description'=>$this->input->post('b_meta_description')
							/*'footer_b_meta_title'=>$this->input->post('footer_b_meta_title'),
							'footer_b_meta_key'=>$this->input->post('footer_b_meta_key'),
							'footer_b_meta_description'=>$this->input->post('footer_b_meta_description')*/
						); 
		}
		$result=$this->My_model->insert_entry('tbl_blogs',$insert_arr);	
		  if($result){
		    $json['status'] = 1;	
		    $this->session->set_flashdata('success', 'Success!  Blog has been added successfully.');
		  }
		  else
		  {
		  	$json['status']=0;
		  	$this->session->set_flashdata('error', 'Something went wrong.Please try again');
		  }
		  
		} 
		//echo $this->db->last_query();
	 	echo json_encode($json);
	 }
	public function edit_blog(){
		$b_id=$this->input->post('b_id');
		$json['status'] = 0;
		
		$slug = $this->input->post('slug');
		
		$check = $this->Common_model->get_data_count('tbl_blogs',array('b_id != '=>$b_id,'slug'=>$slug),'b_id');
		
		if($check > 0){
			$this->form_validation->set_rules('slug','Slug name','trim|required|alpha_dash|is_unique[tbl_blogs.slug]',array('is_unique'=>'This slug already exist'));
		} else {
			$this->form_validation->set_rules('slug','slug','trim|required|alpha_dash');
		}
		
		
		$this->form_validation->set_rules('b_title','Title','trim|required');
		$this->form_validation->set_rules('b_description','Description','trim|required');
		if ($this->form_validation->run()==false){
		 $json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
			
			
			
			$file_check=false;
			if($_FILES['b_image1']['name']!=''){	 
				$config['upload_path']   = './img/blog/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';  
				$config['remove_spaces'] = TRUE;	
				$config['encrypt_name'] = TRUE;	 
				$this->load->library('upload', $config);
				
				//$this->upload->do_upload('cat_image');
				if($this->upload->do_upload('b_image1'))
				{
					$data = $this->upload->data();  
					$file_check = true;    
				}
				else
				{
					$json['msg'] = '<div class="alert alert-danger">'.$this->upload->display_errors().'<div>';
				}
			
			}
			$where_array=array('b_id'=>$b_id);  
			if($file_check==true)
			{
				$update_array = array(
					'b_title' => $this->input->post('b_title'),
					'b_description'=>$this->input->post('b_description'),
					'b_cdate'=>date('Y-m-d h:i:s'),
					'slug'=>$this->input->post('slug'),
					'b_meta_title'=>$this->input->post('b_meta_title'),
					'b_meta_key'=>$this->input->post('b_meta_key'),
					'b_meta_description'=>$this->input->post('b_meta_description'),
					'footer_b_meta_title'=>$this->input->post('footer_b_meta_title'),
					'footer_b_meta_key'=>$this->input->post('footer_b_meta_key'),
					'footer_b_meta_description'=>$this->input->post('footer_b_meta_description')

				); 
				if($_FILES['b_image1']['name']!=''){
					$update_array['b_image']=$data['file_name'];
				}
			}
			else
			{
				$update_array = array(
					'b_title' => $this->input->post('b_title'),
					'b_description'=>$this->input->post('b_description'),
					'b_cdate'=>date('Y-m-d h:i:s'),
					'slug'=>$this->input->post('slug'),
					'b_meta_title'=>$this->input->post('b_meta_title'),
					'b_meta_key'=>$this->input->post('b_meta_key'),
					'b_meta_description'=>$this->input->post('b_meta_description'),
					'footer_b_meta_title'=>$this->input->post('footer_b_meta_title'),
					'footer_b_meta_key'=>$this->input->post('footer_b_meta_key'),
					'footer_b_meta_description'=>$this->input->post('footer_b_meta_description')
				); 
			}
			$result=$this->My_model->update_entry('tbl_blogs',$update_array,$where_array); 
			if($result){
				$json['status'] = 1;	
				$this->session->set_flashdata('success', 'Success!  Blog has been updated successfully.');
			}
			else
			{
				$json['status']=0;
				$this->session->set_flashdata('error', 'Something went wrong.Please try again');
			}
			
		} 
		//echo $this->db->last_query();
	 	echo json_encode($json);
	 }

	 function delete_blog($id){
	      $id=$this->uri->segment(4);
	      $result=$this->Common_model->delete(array('b_id'=>$id),'tbl_blogs'); 	
	      if($result){
            $this->session->set_flashdata('success', 'Success!  Blog has been deleted successfully.');
	      }else{
            $this->session->set_flashdata('error', 'error!  something went wrong.');
	      }
	      redirect('blog_management');
	 }
} ?>