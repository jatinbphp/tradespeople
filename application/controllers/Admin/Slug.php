<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slug extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->load->model('Admin_model');
		$this->check_login();
	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	
	public function create_cate_slug($id=null){
		$value = $this->input->post('title');
		
		$slug = url_title($value);
		
		$slugcheck = $this->Common_model->GetColumnName('category',array('cat_id != '=>$id,'cat_name'=>$value),array('slug') , false , 'cat_id' , 'desc');
		
		
		if($slugcheck){

			$slug_arr = explode('-',$slugcheck['slug']);
			$end = end($slug_arr);
			
			if(is_numeric($end)){
				$end = $end+1;
				
				$slug = $slug.'-'.$end;
				
			} else {
				
				$slug = $slug.'-1';
			}
	
	} 	
		//echo $this->db->last_query();
		echo strtolower($slug);
	}

	public function create_local_cate_slug($id=null){
		$cat_id = $this->input->post('cat_id');
		$location_id = $this->input->post('location');


		$category = $this->Common_model->GetColumnName('category',array('cat_id'=>$cat_id),array('slug','cat_name'));
		$location = $this->Common_model->GetColumnName('tbl_city',array('id'=>$location_id),array('city_name'));




		$slug = url_title($category['slug'].'-'.$location['city_name']);
	
		$title = $category['cat_name'].' in '.$location['city_name'];
		
		$slugcheck = $this->Common_model->GetColumnName('local_category',array('cat_id != '=>$id,'slug'=>$slug),array('slug'));
		
		$check = $this->Common_model->GetColumnName('local_category',array('cat_parent'=>$cat_id,'location'=>$location_id,'cat_id != '=>$id),array('slug'));
		
		if($check){
			$output['status'] = 0;
			echo json_encode($output);
			exit();
		}


		if($slugcheck){
			
				
			$slug_arr = explode('-',$slugcheck['slug']);
			$end = end($slug_arr);
			
			if(is_numeric($end)){
				$end = $end+1;
				
				$slug = $slug.'-'.$end;
				
			} else {
				
				$slug = $slug.'-1';
			}
	
		}
		//echo $this->db->last_query();
	
		$output['slug'] = strtolower($slug);
		$output['title'] = $title;
		$output['status'] = 1;
		echo json_encode($output);
		exit();
	}
	
	
	public function create_blog_slug($id=null){
		$value = $this->input->post('title');
		
		$slug = url_title($value);
		
		$check = $this->Common_model->get_data_count('tbl_blogs',array('b_id != '=>$id,'slug'=>$slug),'b_id');
		
		if($check > 0){
			
			$slug_arr = explode('-',$slug);
			
			$end = end($slug_arr);
			
			if(is_numeric($end)){
				$end2 = $end+1;
				
				
				//$new_slug = implode('-',$slug_arr);
				
				$slug = $slug.'-'.$end2;
				
			} else {
				$slug = $slug.'-1';
			}
			
		}
		
		echo strtolower($slug);
	}
	
	public function create_cost_guide_slug($id=null){
		$value = $this->input->post('title');
		
		$slug = url_title($value);
		
		$check = $this->Common_model->get_data_count('cost_guides',array('id != '=>$id,'slug'=>$slug),'id');
		
		if($check > 0){
			
			$slug_arr = explode('-',$slug);
			
			$end = end($slug_arr);
			
			if(is_numeric($end)){
				$end2 = $end+1;
				
				//array_pop($slug_arr);
				
				//$new_slug = implode('-',$slug_arr);
				
				$slug = $slug.'-'.$end2;
				
			} else {
				$slug = $slug.'-1';
			}
			
		}
		
		echo strtolower($slug);
	}
	
	public function getCategoryLists(){
			$data = $row = array();
			$this->load->model('category');
			// Fetch member's records
			$memData = $this->category->getRows($_POST,1);
			
			$i = $_POST['start'];
			foreach($memData as $member){
					$i++;
					
					$img = '';
					
					if($member->cat_image){
					
						$img = '<img id="image-id-'.$member->cat_id .'" src="'.base_url().'img/category/'.$member->cat_image . '" width="80px" height="80px">';
					} 
					
					if($member->show_at_job_search==1){
					
						$show_at_job_search = '<div class="checkbox"><label><input onchange="show_at_job_search(this.value,'.$member->cat_id .');" checked type="checkbox" id="show_at_job_search'.$member->cat_id .'" value="1"></label></div>';
					} else {
						$show_at_job_search = '<div class="checkbox"><label><input onchange="show_at_job_search(this.value,'.$member->cat_id .');" type="checkbox" id="show_at_job_search'.$member->cat_id .'" value="1"></label></div>';
					}

					$action = '<a href="'.base_url().'find-jobs/'. $member->slug .'" target="_blank" class="btn btn-warning btn-xs">View Category</a> ';
					
					$action .= '<a href="javascript:void(0);"   onclick="myfunction()" data-toggle="modal" data-target="#edit_category'.$member->cat_id .'" class="btn btn-success btn-xs">Edit</a> ';
					
$action .= '<div class="modal fade in" id="edit_category'.$member->cat_id .'">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content" id="editMsg_'.$member->cat_id .'">

				<form onsubmit="return edit_category('.$member->cat_id .');" id="edit_category1'.$member->cat_id .'" method="post"  enctype="multipart/form-data">
					<div class="modal-header">
						<div class="editmsg'.$member->cat_id .'" id="editmsg'.$member->cat_id .'"></div>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit Category</h4>
					</div>
					<div class="modal-body">
			
						
			 <div class="form-group">
				<label for="email"> Find job page title:</label>
				<input type="text" placeholder="Find job page title" name="find_job_title" id="find_job_title'.$member->cat_id . '" value="'.$member->find_job_title . '" class="form-control" required>
			 </div>
			 <div class="form-group">
				<label for="email"> Description:</label>
				<textarea rows="5" placeholder="" name="description" id="description'.$member->cat_id . '" class="form-control">'.$member->description . '</textarea>
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Title:</label>
				<input type="text" name="meta_title2" id="meta_title-'.$member->cat_id . '" class="form-control" value="'.$member->meta_title2 . '">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Keywords:</label>
				<input type="text" name="meta_key2" id="meta_key-'.$member->cat_id . '" class="form-control" value="'.$member->meta_key2 . '">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Description:</label>
				<textarea rows="5" placeholder="" name="meta_description2" id="meta_description-'.$member->cat_id . '" class="form-control">'.$member->meta_description2 . '</textarea>
			 </div>

			 <div class="form-group">
				<label for="email"> Footer Description:</label>
				<textarea rows="5" placeholder="" name="slug_footer_description" id="slug_footer_description-'.$member->cat_id . '" class="form-control textarea ">'.$member->slug_footer_description . '</textarea>
			 </div>
			 

			 
             </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn'.$member->cat_id . '" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
			   </form>
            </div>
			
         </div>
      </div>
   </div>
</div>';     
					$data[] = array($member->cat_id, $member->find_job_title, $member->slug, $img, $show_at_job_search, $action);
			}
			
			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->category->countAll(1),
					"recordsFiltered" => $this->category->countFiltered($_POST,1),
					"data" => $data,
			);
			
			// Output to JSON format
			echo json_encode($output);
	}
	public function category_find_job() { 
		//  $result['categorylist']=$this->My_model->alldata('category');
		$result['listing']=$this->Common_model->GetColumnName('category',array('is_delete'=>0,'cat_parent'=>0),null,true,'cat_id','asc');
		
		$this->load->view('Admin/category_find_job', $result);
	}
	
	public function category_default_content() { 
		//  $result['categorylist']=$this->My_model->alldata('category');
		$result['find_trades']=$this->Common_model->GetColumnName('other_content',array('id'=>1));
		$result['find_job']=$this->Common_model->GetColumnName('other_content',array('id'=>2));
		
		$this->load->view('Admin/category_default_content', $result);
	}

	public function affiliateMetadata() { 
		// $result['affilate_login_metadata']=$this->Common_model->GetColumnName('other_content',array('id'=>3));
		// $result['affilate_signup_metadata']=$this->Common_model->GetColumnName('other_content',array('id'=>4));
		$result['affilate_page_metadata']=$this->Common_model->GetColumnName('other_content',array('id'=>5));
		// echo "<pre>"; print_r($result); exit;
		$this->load->view('Admin/affiliate-metadata', $result);
	}

	
	public function update_category($id){
    $json['status'] = 0;
		
		$update_array = array(
			'cat_update' => date('Y-m-d h:i:s'),
			'find_job_title'=>$this->input->post('find_job_title'),
			'description'=>$this->input->post('description'),
			'meta_title2'=>$this->input->post('meta_title2'),
			'meta_key2'=>$this->input->post('meta_key2'),
			'meta_description2'=>$this->input->post('meta_description2'),
			'slug_footer_description'=>$this->input->post('slug_footer_description')
		);
		
		$where_array = array('cat_id'=>$id);
		$result=$this->My_model->update_entry('category', $update_array,$where_array);
		if($result){
			$json['status'] = 1;
			$this->session->set_flashdata('success', 'Success! Category updated successfully.');
		} else {
			$json['status'] = 2;
			$this->session->set_flashdata('error', 'Some error occured.');
		}
    echo json_encode($json);
  }

	
	public function update_category_default_content(){
    $json['status'] = 0;
		
		$update_array = array(
			'title'=>$this->input->post('title'),
			'meta_title'=>$this->input->post('meta_title'),
			'meta_description'=>$this->input->post('meta_description'),
			'meta_key'=>$this->input->post('meta_key'),
			'description'=>$this->input->post('description'),
			'footer_description'=>$this->input->post('footer_description')
		);
		$where_array = array('id'=>1);
		$result = $this->My_model->update_entry('other_content', $update_array,$where_array);
		
		$update_array2 = array(
			'title'=>$this->input->post('title2'),
			'meta_title'=>$this->input->post('meta_title2'),
			'meta_description'=>$this->input->post('meta_description2'),
			'meta_key'=>$this->input->post('meta_key2'),
			'description'=>$this->input->post('description2'),
			'footer_description'=>$this->input->post('footer_description2')
		);
		$where_array2 = array('id'=>2);
		$result2 = $this->My_model->update_entry('other_content', $update_array2,$where_array2);
		
		if($result or $result2){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Content updated successfully.</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">We did not find any changes.</div>');
		}
    redirect('Admin/category-default-content');
  }



  public function update_affiliate_metadata_content(){
    // $json['status'] = 0;
		// $update_array = array(
		// 	// 'title'=>$this->input->post('title'),
		// 	'meta_title'=>$this->input->post('meta_title'),
		// 	'meta_description'=>$this->input->post('meta_description'),
		// 	'meta_key'=>$this->input->post('meta_key')
		// 	// 'description'=>$this->input->post('description')
		// 	// 'footer_description'=>$this->input->post('footer_description')
		// );
		// $where_array = array('id'=>3);
		// $result = $this->My_model->update_entry('other_content', $update_array,$where_array);
		
		// $update_array2 = array(
		// 	// 'title'=>$this->input->post('title2'),
		// 	'meta_title'=>$this->input->post('meta_title2'),
		// 	'meta_description'=>$this->input->post('meta_description2'),
		// 	'meta_key'=>$this->input->post('meta_key2')
		// 	// 'description'=>$this->input->post('description2')
		// 	// 'footer_description'=>$this->input->post('footer_description2')
		// );
		// $where_array2 = array('id'=>4);
		// $result2 = $this->My_model->update_entry('other_content', $update_array2,$where_array2);
  	$file_check = false;
      $fileError = false;
      if($_FILES['image']['name']!=''){
        $file_check = true;
        $config['upload_path']   = './img/common/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
        $config['max_size']      = 50000;
        $config['min_width']     = 1300;
        $config['min_height']    = 400;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        //$this->upload->do_upload('cat_image');
        if($this->upload->do_upload('image')){
          $data = $this->upload->data();
        }else{
          $fileError = true;
        }
      }

		$update_array3 = array(
			'title'=>$this->input->post('title3'),
			'meta_title'=>$this->input->post('meta_title3'),
			'meta_description'=>$this->input->post('meta_description3'),
			'meta_key'=>$this->input->post('meta_key3'),
			'description'=>$this->input->post('description3')
			// 'footer_description'=>$this->input->post('footer_description3')
		);
		if($file_check) $update_array3['image'] = $data['file_name'];
		$where_array3 = array('id'=>5);
		$result3 = $this->My_model->update_entry('other_content', $update_array3,$where_array3);

		if($result or $result2 or $result3){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Content updated successfully.</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">We did not find any changes.</div>');
		}
    redirect('Admin/affiliate-metadata');
  }

	
}