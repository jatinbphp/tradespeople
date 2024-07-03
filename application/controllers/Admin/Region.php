<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Region extends CI_Controller {
	
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

	public function county() { 
		//  $result['categorylist']=$this->My_model->alldata('category');
		$result['listing']=$this->My_model->get_all_category('tbl_region');
		if($result['listing']==''){
			$result['listing']  =array();     
		}
		
		$this->load->view('Admin/county',$result);
		
		
	}

	 public function add_county(){
	 	$json['status'] = 0;
	 	$id=$this->input->post('county_id');
	 	$this->form_validation->set_rules('region_name','County','required');
	 	
		if ($this->form_validation->run()==false){
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
			$insert_arr = array(
				'region_name' => $this->input->post('region_name'),
			);  
			$id=$this->input->post('county_id');
		  if($id){
			  $region_name=$this->Common_model->get_single_data('tbl_region',array('is_delete'=>0,'region_name'=>$this->input->post('region_name')));
				if($region_name){
					$json['msg'] = '<div class="alert alert-danger">County name already exists</div>';
					$result=false;
				}else{
					$result=$this->Common_model->update('tbl_region',array('id'=>$id),$insert_arr);
					$this->session->set_flashdata('success', 'Success!  County has been updated successfully.');
					$json['status'] = 1;
					$json['msg'] = '<div class="alert alert-danger">County name already exists</div>';
				}
		  }else{	

				$region_name=$this->Common_model->get_single_data('tbl_region',array('is_delete '=>0,'region_name'=>$this->input->post('region_name')));
				if($region_name){
					$json['msg'] = '<div class="alert alert-danger">County name already exists</div>';
					$result=false;
				}else{
					$result=$this->My_model->insert_entry('tbl_region',$insert_arr);
					$this->session->set_flashdata('success', 'Success!  County has been added successfully.');
				}
				
		  }

		  if($result){
		    $json['status'] = 1;	
		  }
		} 
		//echo $this->db->last_query();
	 	echo json_encode($json);
	 }

	 function delete_county(){
	      $id=$this->uri->segment(4);	
	       $insert_arr = array(
							'is_delete' => 1,
						);  
	      $delete=$this->Common_model->update('tbl_region',array('id'=>$id),$insert_arr);
	      if($delete){
            $this->session->set_flashdata('success', 'Success!  County has been deleted successfully.');
	      }else{
            $this->session->set_flashdata('error', 'error!  something went wrong.');
	      }
	      redirect('admin_county');
	 }

	public function city() { 
		
		$result['listing']=$this->My_model->get_all_category('tbl_city');
		if($result['listing']==''){
			$result['listing']  =array();     
		}
		
		$this->load->view('Admin/city',$result);
		
	}

	public function add_city(){
		$json['status'] = 0;
		$json['msg'] = '<div class="alert alert-danger">Error!  something went wrong.</div>';
		$id=$this->input->post('city_id');
		
		if($id){
			$this->form_validation->set_rules('city_name','City name','required');
		}else{
			$this->form_validation->set_rules('city_name','City name','required|is_unique[tbl_city.city_name]');
		}
	 	
		if ($this->form_validation->run()==false){
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		}else{
			
			$insert_arr = array(
				'city_name' => $this->input->post('city_name'),
				'meta_title' => $this->input->post('meta_title'),
				'meta_key' => $this->input->post('meta_key'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_title2' => $this->input->post('meta_title2'),
				'meta_key2' => $this->input->post('meta_key2'),
				'meta_description2' => $this->input->post('meta_description2'),
				'meta_title3' => $this->input->post('meta_title3'),
				'meta_key3' => $this->input->post('meta_key3'),
				'meta_description3' => $this->input->post('meta_description3'),
				'meta_title4' => $this->input->post('meta_title4'),
				'meta_key4' => $this->input->post('meta_key4'),
				'meta_description4' => $this->input->post('meta_description4'),
				'tradesmen_footer_description' => $this->input->post('tradesmen_footer_description'),
				'jobpage_footer_description' => $this->input->post('jobpage_footer_description')
			);  
	     
		  if($id){
				
				$city_name=$this->Common_model->get_single_data('tbl_city',array('id!='=>$id,'city_name'=>$this->input->post('city_name')));
				if($city_name){
					$json['msg'] = '<div class="alert alert-danger">City name already exists</div>';
					$result=false;
		    }else{
		    	$result=$this->Common_model->update('tbl_city',array('id'=>$id),$insert_arr);
					$this->session->set_flashdata('success', 'Success!  City has been updated successfully.');
					$json['status'] = 1;
				}
		  }else{		
				$result=$this->My_model->insert_entry('tbl_city',$insert_arr);
				$this->session->set_flashdata('success', 'Success!  City has been added successfully.');
		  }
		  
		  if($result){
		    $json['status'] = 1;	
		  }
		} 
		//echo $this->db->last_query();
	 	echo json_encode($json);
	 }

	 function delete_city(){
	      $id=$this->uri->segment(4);
	     
	      $delete=$this->Common_model->delete(array('id'=>$id),'tbl_city');	
	      if($delete){
            $this->session->set_flashdata('success', 'Success!  City has been deleted successfully.');
	      }else{
            $this->session->set_flashdata('error', 'error!  something went wrong.');
	      }
	      redirect('admin_city');
	 }
} ?>