<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        //$this->email->initialize($config);
        $this->load->library('form_validation');

        $this->load->library('pagination');
        $this->load->model('user');
        $this->perPage = 200;

        //$this->lang->load('message','english');
        $this->load->model('Admin_model');
        $this->load->model('Common_model');
        $this->load->model('My_model');
        $this->check_login();
    }
    public function check_login()
    {
        if (!$this->session->userdata('session_adminId')) {
            redirect('Admin');
        }
    }
    public function accept_cashout_payouts()
    {
        $user_id        = $_POST['user_id'];
        $payment_id     = $_POST['payment_id'];
        $request_amount = $_POST['request_amount'];
        $this->Common_model->accept_cashout_payouts($user_id, $payment_id, $request_amount);
    }
    public function reject_cashout_payouts()
    {
        $reject_mgs     = $_POST['reject_mgs'];
        $user_id        = $_POST['user_id'];
        $payment_id     = $_POST['payment_id'];
        $request_amount = $_POST['request_amount'];
        $this->Common_model->reject_cashout_payouts($reject_mgs, $user_id, $payment_id, $request_amount);
    }
    public function Admin_dashboard()
    {
        $adminId               = $this->session->userdata('session_adminId');
        $admininfo             = $this->Common_model->getRows('admin', $adminId);
        $pagedata['my_access'] = explode(',', $admininfo['roles']);
        $this->load->view('Admin/admin_dashboard', $pagedata);
    }
    public function mark_read_in_admin()
    {
        $table = $this->input->post('table');
        $where = $this->input->post('where');
        $run   = $this->Common_model->update($table, $where, ['is_admin_read' => 1]);
        // echo $this->db->last_query();
        echo json_encode(['status' => 1]);
    }

    public function update_admin_note()
    {

        $json['status'] = 0;
        $json['msg']    = 'Something went wrong, try again later.';
        $json['date']   = '';

        $id         = $this->input->post('id');
        $admin_note = $this->input->post('admin_note');

        $update['admin_note']   = $admin_note;
        $update['admin_update'] = date('Y-m-d H:i:s');

        $run = $this->Common_model->update('users', ['id' => $id], $update);

        if ($run) {
            $json['status'] = 1;
            $json['msg']    = 'User note has been update successfully.';

            if ($admin_note) {
                $json['date'] = 'Last updated: ' . date('d M Y h:i A', strtotime($update['admin_update']));
            }
        }

        echo json_encode($json);
    }

    public function tradesmen_user($segment = null)
    {
        // $result['users']=$this->Common_model->get_all_tradesmen();
        /*$where['type']   = 1;
        $search = 'id,unique_id,f_name,l_name,u_status_add,u_id_card,u_id_card_status,u_status_insure,cdate,trading_name,email,phone_no,
        e_address,county,city,postal_code,u_email_verify,status,review_invitation_status,u_address,u_insurrance_certi,admin_note';
        $result['users'] = $this->Common_model->fetch_records('users', $where, $search, false, 'id,document_updated');
        $this->load->view('Admin/tradesmen_user', $result);*/

        $data = $conditions = array();
        $conditions = array(
            'returnType' => 'count', 
            'where' => ['type' => 1],
        );
        $totalRec = $this->user->getDBRows($conditions);
        
        $config['base_url']    = base_url().'tradesmen_user/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        //$config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = 'Next';
        $config['next_tag_close'] = '</li>';         
        
        $this->pagination->initialize($config);

        $page = ($segment) ? $segment : 0;
        $offset = !$page ? 0 : $page;

        $conditions = array(
            'where' => ['type' => 1],
            'start' => $offset, 
            'limit' => $this->perPage
        );

        $data['users'] = $this->user->getDBRows($conditions);
        $this->load->view('Admin/tradesmen_user', $data);
    }

    public function homeowners_users($segment = null)
    {
        // $result['users']=$this->Common_model->get_all_homeowner();
        //$where['type']   = 2;
        // $result['users'] = $this->Common_model->fetch_records('users', $where, false, false, 'id,document_updated');
        // $this->load->view('Admin/homeowners_users', $result);

        $data = $conditions = array();
        $conditions = array(
            'returnType' => 'count',
            'where' => ['type' => 2],
        );
        $totalRec = $this->user->getDBRows($conditions);

        $config['base_url']    = base_url().'homeowners_users/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        //$config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = 'Previous';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = 'Next';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($segment) ? $segment : 0;
        $offset = !$page ? 0 : $page;

        $conditions = array(
            'where' => ['type' => 2],
            'start' => $offset,
            'limit' => $this->perPage
        );

        $data['users'] = $this->user->getDBRows($conditions);
        $this->load->view('Admin/homeowners_users', $data);
    }

    public function remove_category_image()
    {
        $id    = $this->input->post('id');
        $image = $this->input->post('image');

        $run = $this->Common_model->update_data('category', ['cat_id' => $id], ['cat_image' => '']);

        if ($run) {
            if ($image) {
                unlink('img/category/' . $image);
            }
            $json['status'] = 1;
            $json['msg']    = 'Image has been removed successfully.';
        } else {
            $json['status'] = 0;
            $json['msg']    = 'Something went wrong, try again later.';
        }
        echo json_encode($json);
    }
    public function getCategoryLists()
    {
        $data = $row = [];
        $this->load->model('category');
        // Fetch member's records
        $memData = $this->category->getRows($_POST);

        //$listing = $this->My_model->get_all_category1('category');
        $newCategory = getParent();

        $i = $_POST['start'];
        foreach ($memData as $member) {
            $i++;
            $main_cate = '';
            if ($member->cat_parent && !empty($member->cat_parent)) {
                $get_cat = $this->Admin_model->get_parent_cates('category', $member->cat_parent);

                $main_cate = (count($get_cat)) ? $get_cat[0]['cat_name'] : '';

            }

            $img = '';

            if ($member->cat_image) {

                $img = '<img id="image-id-' . $member->cat_id . '" src="' . base_url() . 'img/category/' . $member->cat_image . '" width="80px" height="80px">';
            }

            if ($member->show_at_job_search == 1) {

                $show_at_job_search = '<div class="checkbox"><label><input onchange="show_at_job_search(this.value,' . $member->cat_id . ');" checked type="checkbox" id="show_at_job_search' . $member->cat_id . '" value="1"></label></div>';
            } else {
                $show_at_job_search = '<div class="checkbox"><label><input onchange="show_at_job_search(this.value,' . $member->cat_id . ');" type="checkbox" id="show_at_job_search' . $member->cat_id . '" value="1"></label></div>';
            }

            $action = '<a href="' . base_url($member->slug) . '" target="_blank" class="btn btn-warning btn-xs">View Category</a> ';

            $action .= '<a href="' . base_url() . 'child_category/' . $member->cat_id . '" class="btn btn-info btn-xs">Child Category</a> ';

            $action .= '<a href="javascript:void(0);"  onclick="myfunction()" data-toggle="modal" data-target="#edit_category' . $member->cat_id . '" class="btn btn-success btn-xs">Edit</a> ';

            $action .= '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/delete_cat/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to delete this category?\');">Delete</a> ';

            if ($member->is_activate == 1) {
                $action .= '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/deactivate_category/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to deactivate this category?\');">Deactivate</a> ';
            } else {
                $action .= '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/activate_category/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to activate this category?\');">Activate</a> ';
            }

            if ($member->cat_image) {

                $action .= '<a id="image-remove-btn-' . $member->cat_id . '" class="btn btn-primary btn-xs" href="" onclick="return remove_category_image(' . $member->cat_id . ',\'' . $member->cat_image . '\');">Delete image</a> ';

            }

            $action .= '
<div class="modal fade in" id="edit_category' . $member->cat_id . '">
	<div class="modal-body" >
		<div class="modal-dialog">

			<div class="modal-content" id="editMsg_' . $member->cat_id . '">

				<form onsubmit="return edit_category(' . $member->cat_id . ');" id="edit_category1' . $member->cat_id . '" method="post"  enctype="multipart/form-data">
					<div class="modal-header">
						<div class="editmsg' . $member->cat_id . '" id="editmsg' . $member->cat_id . '"></div>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit Category</h4>
					</div>
					<div class="modal-body">

										<div class="form-group">
							<label for="email"> Select category:</label>
							<select type="text" name="cat_parent1" id="cat_parent' . $member->cat_id . '"  class="form-control" onchange="InsertTitle(this ,\'title_ft' . $member->cat_id . '\',' . $member->cat_id . ')" >
								<option value="">select</option>';

            foreach ($newCategory as $newCategoryKey => $newCategoryVal) {
                $newCategoryselected = ($newCategoryVal['cat_id'] == $member->cat_parent) ? 'selected' : '';

                $action .= '<optgroup label="' . $newCategoryVal['cat_name'] . '">
									<option ' . $newCategoryselected . ' value="' . $newCategoryVal['cat_id'] . '">' . $newCategoryVal['cat_name'] . ' (Main)</option>';

                if (!empty($newCategoryVal['child'])) {
                    foreach ($newCategoryVal['child'] as $childKey => $childVal) {

                        $childCategoryselected = ($childVal['cat_id'] == $member->cat_parent) ? 'selected' : '';

                        $action .= '<option ' . $childCategoryselected . ' value="' . $childVal['cat_id'] . '">' . $childVal['cat_name'] . '</option>';

                    }

                }

                $action .= '</optgroup>';

            }

            /*foreach($listing as $categorylistss){

            if($member->cat_parent != 0){

            if($categorylistss['cat_id'] != $member->cat_id){

            $select = ($member->cat_parent == $categorylistss['cat_id'])?'selected':'';
            $parent = (getCatName($categorylistss['cat_parent'])) ? getCatName($categorylistss['cat_parent'])['cat_name'].'-> ' : '' ;
            $action .= '<option value='.$categorylistss['cat_id'].' '.$select.' >'.$parent.$categorylistss['cat_name'].'</option>';

            }
            } else {

            if($categorylistss['cat_id'] != $member->cat_id){

            $select = ($member->cat_parent == $categorylistss['cat_id'])?'selected':'';
            $parent = (getCatName($categorylistss['cat_parent'])) ? getCatName($categorylistss['cat_parent'])['cat_name'].'-> ' : '' ;
            $action .= '<option value="'.$categorylistss['cat_id'].'" '.$select.' >'.$parent.$categorylistss['cat_name'].'</option>';

            }
            }
            } */
            $action .= '</select>
						</div>
			<div class="form-group">
				<label for="email"> Category Name:</label>
				<input type="text" name="cat_name1" onkeyup="changeQues(this , ' . $member->cat_id . '); create_slug(' . $member->cat_id . ',this.value);"  id="cat_name' . $member->cat_id . '"  value="' . $member->cat_name . '" required class="form-control" >
			 </div>
			 <div class="form-group">
				<label for="cat_ques' . $member->cat_id . '">  Category Question:</label>
				<input type="text" name="cat_ques"  id="cat_ques' . $member->cat_id . '"  value="' . $member->cat_ques . '" class="form-control" >
			 </div>
			 <div class="form-group utitle_ft title_ft' . $member->cat_id . '" style="display:none">
				<label for="email">  Category title for find tradesmen page:</label>
				<input type="text" name="title_ft1"  id="title_ft' . $member->cat_id . '"  value="' . $member->title_ft . '"  class="form-control" >
			 </div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug1" id="slug' . $member->cat_id . '"  value="' . $member->slug . '" required class="form-control" >
				<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
			 </div>
			 <div class="form-group">
				<label for="email"> Description:</label>
				<textarea rows="5" placeholder="" name="cat_description1" id="cat_description' . $member->cat_id . '" class="form-control">' . $member->cat_description . '</textarea>
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Title:</label>
				<input type="text" name="meta_title1" id="meta_title' . $member->cat_id . '" class="form-control" value="' . $member->meta_title . '">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Keywords:</label>
				<input type="text" name="meta_key1" id="meta_key' . $member->cat_id . '" class="form-control" value="' . $member->meta_key . '">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Description:</label>
				<textarea rows="5" placeholder="" name="meta_description1" id="meta_description' . $member->cat_id . '" class="form-control">' . $member->meta_description . '</textarea>
			 </div>

			 <div class="form-group">
				<label for="email"> Footer Description:</label>
				<textarea rows="5" placeholder="" name="footer_description" id="footer_description' . $member->cat_id . '" class="form-control textarea">' . $member->footer_description . '</textarea>
			 </div>

			 <div class="form-group">
				<label for="email"> Thumbnail Image:</label>
			<input type="file" name="cat_image1" id="cat_image' . $member->cat_id . '" class="form-control">
			<input type="hidden" name="catimage" id="catimage' . $member->cat_id . '" value="' . $member->cat_image . '"></div>


             </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn' . $member->cat_id . '" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
			   </form>
            </div>

         </div>
      </div>
   </div>
</div>';

            $data[] = [$member->cat_id, $member->cat_name, $main_cate, $member->slug, $img, $action];
        }

        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->category->countAll(),
            "recordsFiltered" => $this->category->countFiltered($_POST),
            "data"            => $data,
        ];

        // Output to JSON format
        echo json_encode($output);
    }
    public function category()
    {
        //  $result['categorylist']=$this->My_model->alldata('category');
        $result['listing'] = $this->Common_model->get_all_category('category');

        $this->load->view('Admin/category', $result);

    }

    public function add_category()
    {
        $json['status'] = 0;

        $this->form_validation->set_rules('slug', 'Slug name', 'trim|required|alpha_dash|is_unique[category.slug]', ['is_unique' => 'This slug already exist']);
        $this->form_validation->set_rules('cat_name', 'Category Name', 'required');
        //$this->form_validation->set_rules('cat_description','Category Description','required');
        //$this->form_validation->set_rules('meta_title','Meta Title','required');
        //$this->form_validation->set_rules('meta_description','Meta Description','required');
        /*if(!$_FILES['cat_image']['name']){
        $this->form_validation->set_rules('cat_image','Image','required');
        }
         */

        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $file_check = false;
            $fileError  = false;
            if ($_FILES['cat_image']['name'] != '') {
                $file_check              = true;
                $config['upload_path']   = './img/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 50000;
                $config['min_width']     = 1300;
                $config['min_height']    = 400;
                $config['remove_spaces'] = true;
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);

                //$this->upload->do_upload('cat_image');
                if ($this->upload->do_upload('cat_image')) {
                    $data = $this->upload->data();
                } else {
                    $fileError = true;
                }
            }

            if ($fileError) {
                $json['msg']    = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                $json['status'] = 2;
            } else {
                $insert_arr = [
                    'cat_name'           => $this->input->post('cat_name'),
                    'find_job_title'     => $this->input->post('cat_name'),
                    'cat_ques'           => $this->input->post('cat_ques'),
                    'title_ft'           => ($this->input->post('title_ft')) ? $this->input->post('title_ft') : $this->input->post('cat_name'),
                    'slug'               => $this->input->post('slug'),
                    'cat_parent'         => $this->input->post('cat_parent'),
                    'cat_create'         => date('Y-m-d h:i:s'),
                    'cat_description'    => $this->input->post('cat_description'),
                    'description'        => $this->input->post('description'),
                    'meta_title'         => $this->input->post('meta_title'),
                    'meta_key2'          => $this->input->post('meta_key2'),
                    'meta_key'           => $this->input->post('meta_key'),
                    'meta_description'   => $this->input->post('meta_description'),
                    'meta_title2'        => $this->input->post('meta_title2'),
                    'meta_description2'  => $this->input->post('meta_description2'),
                    'footer_description' => $this->input->post('footer_description'),
                    'is_activate'        => 1,
                ];

                if ($file_check) {
                    $insert_arr['cat_image'] = $data['file_name'];
                }

                $result = $this->My_model->insert_entry('category', $insert_arr);
                if ($result) {
                    $this->session->set_flashdata('success', 'Success! category added successfully.');
                    $json['status'] = 1;
                } else {
                    $json['msg'] = 'Error! something went wrong.';
                    $this->session->set_flashdata('error', 'Error! something went wrong.');
                }
            }

        }
        echo json_encode($json);
    }

    public function update_category($id)
    {
        $json['status'] = 0;

        $slug1 = $this->input->post('slug1');

        $slug1 = url_title($slug1);

        $categories = $this->Common_model->get_single_data('category', ['slug' => $slug1, 'cat_id != ' => $id]);

        $this->form_validation->set_rules('slug1', 'Slug name', 'trim|required|alpha_dash');

        if ($categories) {
            $this->form_validation->set_rules('slug1', 'Slug name', 'trim|required|alpha_dash|is_unique[category.slug]', ['is_unique' => 'This slug already exist']);
        }

        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $file_check = false;
            $fileError  = false;
            if ($_FILES['cat_image1']['name'] != '') {
                $file_check              = true;
                $config['upload_path']   = './img/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 50000;
                $config['min_width']     = 1300;
                $config['min_height']    = 400;
                $config['remove_spaces'] = true;
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                $data = $this->upload->data();
                if ($this->upload->do_upload('cat_image1')) {
                    $data = $this->upload->data();
                } else {
                    $fileError = true;
                }
            }
            if ($fileError) {
                $json['status'] = 2;
                $json['msg']    = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                $this->session->set_flashdata('error', $this->upload->display_errors());
            } else {
                $update_array = [
                    'cat_name'                  => $this->input->post('cat_name1'),
                    'cat_ques'                  => $this->input->post('cat_ques'),
                    'title_ft'                  => ($this->input->post('title_ft1') != '') ? $this->input->post('title_ft1') : $this->input->post('cat_name1'),
                    'slug'                      => $slug1,
                    'cat_parent'                => $this->input->post('cat_parent1'),
                    'cat_update'                => date('Y-m-d h:i:s'),
                    'cat_description'           => $this->input->post('cat_description1'),
                    //'description'=>$this->input->post('description'),
                    'meta_title'                => $this->input->post('meta_title1'),
                    'meta_key'                  => $this->input->post('meta_key1'),
                    'meta_description'          => $this->input->post('meta_description1'),
                    'footer_description'        => $this->input->post('footer_description'),
                    'child_footer_description1' => $this->input->post('child_footer_description1'),
                    //'meta_title2'=>$this->input->post('meta_title2'),
                    //'meta_description2'=>$this->input->post('meta_description2')
                ];
                if ($file_check) {
                    $update_array['cat_image'] = $data['file_name'];
                }
                $where_array = ['cat_id' => $id];
                $result      = $this->My_model->update_entry('category', $update_array, $where_array);
                if ($result) {
                    $json['status'] = 1;
                    $this->session->set_flashdata('success', 'Success! Category updated successfully.');
                } else {
                    $json['status'] = 2;
                    $this->session->set_flashdata('error', 'Some error occured.');
                }
            }
        }
        echo json_encode($json);
    }

    public function show_at_job_search($id)
    {
        $json['status'] = 0;

        $status = $this->input->post('status');

        $update_array = [
            'show_at_job_search' => $this->input->post('status'),
        ];

        $where_array = ['cat_id' => $id];
        $result      = $this->My_model->update_entry('category', $update_array, $where_array);

        echo json_encode($json);
    }

    public function update_address($uid, $status)
    {
        $userdata['u_status_add'] = $status;

        if ($status == 0) {
            $userdata['u_address'] = '';
        }

        $where_array = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($result) {
            $users = $this->Common_model->GetColumnName('users', ['id' => $uid], ['f_name', 'l_name', 'email']);

            $name  = $users['f_name'] . ' ' . $users['l_name'];
            $email = $users['email'];

            if ($status == 2) {
                $subject = "Your Documents has been verified.";

                $html = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';

                $html .= '<p style="margin:0;padding:10px 0px">Document verified successfully! </p>';

                $html .= '<p style="margin:0;padding:10px 0px">Your Address Document has been verified. If you´ve not uploaded all the documents, please do it now to complete your account verification.</p>';

                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $insertn1['nt_userId'] = $uid;

                $insertn1['nt_message']  = 'Your documents have been successfully verified!';
                $insertn1['nt_satus']    = 0;
                $insertn1['nt_apstatus'] = 2;
                $insertn1['nt_create']   = date('Y-m-d H:i:s');
                $insertn1['nt_update']   = date('Y-m-d H:i:s');
                $insertn1['job_id']      = 0;
                $insertn1['posted_by']   = 0;
                $this->Common_model->insert('notification', $insertn1);

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! Address Document has been verified successfully.</p>');

            } else {
                $reason = $this->input->post('reason');

                $insert['nt_userId']   = $uid;
                $insert['nt_message']  = 'Unable to verify your documents. <a href="' . site_url('dashboard?reject_reason=' . $reason) . '">View reason!</a>';
                $insert['nt_satus']    = 0;
                $insert['nt_apstatus'] = 2;
                $insert['nt_create']   = date('Y-m-d H:i:s');
                $insert['nt_update']   = date('Y-m-d H:i:s');
                $insert['job_id']      = 0;
                $insert['posted_by']   = 0;
                $this->Common_model->insert('notification', $insert);

                $subject = "Your Documents has been rejected.";
                $html    = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Document not accepted! </p>';
                $html .= '<p style="margin:0;padding:10px 0px">Your Address Document has been rejected.</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Reason: ' . $reason . '</p>';
                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! Address Document has been rejected successfully.</p>');
            }

            $this->Common_model->send_mail($email, $subject, $html, null, null, 'support');

        } else {
            $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-danger">Something went wrong.Please try again later.</p>');
        }

        return redirect('tradesmen_user?open_doc=' . $uid);
    }
    public function update_bill($uid, $status)
    {
        $userdata['u_status_bill'] = $status;
        $where_array               = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Document has been verified successfully');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.Please try again');
        }

        return redirect('tradesmen_user');
    }
    public function update_photo($uid, $status)
    {
        $userdata['u_status_photo_id'] = $status;
        $where_array                   = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Document has been verified successfully');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.Please try again');
        }

        return redirect('tradesmen_user');
    }
    public function update_insurance($uid, $status)
    {
        $userdata['u_status_insure'] = $status;
        if ($status == 0) {
            $userdata['u_insurrance_certi'] = '';
        }
        $where_array = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($result) {
            $users = $this->Common_model->GetColumnName('users', ['id' => $uid], ['f_name', 'l_name', 'email']);

            $name  = $users['f_name'] . ' ' . $users['l_name'];
            $email = $users['email'];

            if ($status == 2) {
                $subject = "Your Documents has been verified.";

                $html = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';

                $html .= '<p style="margin:0;padding:10px 0px">Document verified successfully! </p>';

                $html .= '<p style="margin:0;padding:10px 0px">Your Insurance Document has been verified. If you´ve not uploaded all the documents, please do it now to complete your account verification.</p>';

                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $insertn1['nt_userId'] = $uid;

                $insertn1['nt_message']  = 'Your documents have been successfully verified!';
                $insertn1['nt_satus']    = 0;
                $insertn1['nt_apstatus'] = 2;
                $insertn1['nt_create']   = date('Y-m-d H:i:s');
                $insertn1['nt_update']   = date('Y-m-d H:i:s');
                $insertn1['job_id']      = 0;
                $insertn1['posted_by']   = 0;
                $this->Common_model->insert('notification', $insertn1);

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! Insurance Document has been verified successfully.</p>');

            } else {
                $reason = $this->input->post('reason');

                $insert['nt_userId']   = $uid;
                $insert['nt_message']  = 'Unable to verify your documents. <a href="' . site_url('dashboard?reject_reason=' . $reason) . '">View reason!</a>';
                $insert['nt_satus']    = 0;
                $insert['nt_apstatus'] = 2;
                $insert['nt_create']   = date('Y-m-d H:i:s');
                $insert['nt_update']   = date('Y-m-d H:i:s');
                $insert['job_id']      = 0;
                $insert['posted_by']   = 0;
                $this->Common_model->insert('notification', $insert);

                $subject = "Your Documents has been rejected.";
                $html    = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Document not accepted! </p>';
                $html .= '<p style="margin:0;padding:10px 0px">Your Insurance Document has been rejected.</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Reason: ' . $reason . '</p>';
                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! Insurance Document has been rejected successfully</p>');
            }

            $this->Common_model->send_mail($email, $subject, $html, null, null, 'support');

        } else {
            $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-danger">Something went wrong.Please try again later.</p>');
        }

        return redirect('tradesmen_user?open_doc=' . $uid);
    }
    public function update_idcard($uid, $status)
    {
        $userdata['u_id_card_status'] = $status;
        if ($status == 0) {
            $userdata['u_id_card'] = '';
        }
        $where_array = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($result) {

            $users = $this->Common_model->GetColumnName('users', ['id' => $uid], ['f_name', 'l_name', 'email']);

            $name  = $users['f_name'] . ' ' . $users['l_name'];
            $email = $users['email'];

            if ($status == 2) {
                $subject = "Your Documents has been verified.";

                $html = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';

                $html .= '<p style="margin:0;padding:10px 0px">Document verified successfully! </p>';

                $html .= '<p style="margin:0;padding:10px 0px">Your ID Card Document has been verified. If you´ve not uploaded all the documents, please do it now to complete your account verification.</p>';

                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $insertn1['nt_userId'] = $uid;

                $insertn1['nt_message']  = 'Your documents have been successfully verified!';
                $insertn1['nt_satus']    = 0;
                $insertn1['nt_apstatus'] = 2;
                $insertn1['nt_create']   = date('Y-m-d H:i:s');
                $insertn1['nt_update']   = date('Y-m-d H:i:s');
                $insertn1['job_id']      = 0;
                $insertn1['posted_by']   = 0;
                $this->Common_model->insert('notification', $insertn1);

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! ID Card Document has been verified successfully.</p>');

            } else {
                $reason = $this->input->post('reason');

                $insert['nt_userId']   = $uid;
                $insert['nt_message']  = 'Unable to verify your documents. <a href="' . site_url('dashboard?reject_reason=' . $reason) . '">View reason!</a>';
                $insert['nt_satus']    = 0;
                $insert['nt_apstatus'] = 2;
                $insert['nt_create']   = date('Y-m-d H:i:s');
                $insert['nt_update']   = date('Y-m-d H:i:s');
                $insert['job_id']      = 0;
                $insert['posted_by']   = 0;
                $this->Common_model->insert('notification', $insert);

                $subject = "Your Documents has been rejected.";

                $html = '<p style="margin:0;padding:10px 0px">Hi ' . $users['l_name'] . ',</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Document not accepted! </p>';
                $html .= '<p style="margin:0;padding:10px 0px">Your ID Card Document has been rejected.</p>';
                $html .= '<p style="margin:0;padding:10px 0px">Reason: ' . $reason . '</p>';
                $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

                $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-success">Success! ID Card Document has been rejected successfully.</p>');
            }

            $this->Common_model->send_mail($email, $subject, $html, null, null, 'support');

        } else {
            $this->session->set_flashdata('my_msg_doc' . $uid, '<p class="alert alert-danger">Something went wrong.Please try again later.</p>');
        }

        return redirect('tradesmen_user?open_doc=' . $uid);

    }

    public function send_direct_mail($id)
    {
        $users = $this->Common_model->GetColumnName('users', ['id' => $id], ['f_name', 'l_name', 'email', 'type']);

        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $html = '<p style="margin:0;padding:10px 0px">Hi ' . $users['f_name'] . ',</p>';

        $html .= '<p style="margin:0;padding:10px 0px">' . $message . '</p>';

        $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

        $this->session->set_flashdata('my_msg', '<p class="alert alert-success">Success! Message has been sent successfully.</p>');

        $this->Common_model->send_mail($users['email'], $subject, $html, null, null, 'support');

        if ($user['type'] == 1) {
            return redirect('tradesmen_user');
        } else {
            return redirect('homeowners_users');
        }
    }

    public function delete_cat($id)
    {
        $session_user = $this->session->userdata('session_userId');
        $update_array = [
            'is_delete' => 1,
            'slug'      => '',
        ];
        $where_array = ['cat_id' => $id];
        $result      = $this->My_model->update_entry('category', $update_array, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Category has been deleted Successfully.');

        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        return redirect('category');
    }

    public function Blockuser1($uid, $status)
    {
        $userdata['status'] = $status;
        $where_array        = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($status) {
            $vars = "Blocked";
        } else {
            $vars = "Unblocked";
        }
        $this->session->set_flashdata('success', 'Success! User has been ' . $vars . ' Successfully');
        return redirect('homeowners_users');

    }

    public function Blockuser2($uid, $status)
    {
        $userdata['status'] = $status;
        $where_array        = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($status) {
            $vars = "Blocked";
        } else {
            $vars = "Unblocked";
        }
        $this->session->set_flashdata('my_msg', '<div class="alert alert-success">Success! User has been ' . $vars . ' Successfully</div>');
        return redirect('affiliaters');

    }

    public function mark_read($uid, $status, $page)
    {
        $userdata['status'] = $status;
        $where_array        = ['id' => $uid];
        $result             = $this->My_model->update_entry('contact_request', $userdata, $where_array);
        $this->session->set_flashdata('success', 'Success! Request email has been read successfully.');
        return redirect($page);
    }
    public function Blockuser($uid, $status)
    {
        $userdata['status'] = $status;
        $where_array        = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($status) {
            $vars = "Blocked";
        } else {
            $vars = "Unblocked";
        }

        $this->session->set_flashdata('success', 'Success! User has been ' . $vars . ' Successfully');

        $users = $this->Common_model->GetColumnName('users', ['id' => $uid], ['type']);

        if ($users['type'] == 1) {
            return redirect('tradesmen_user');
        } else {
            return redirect('homeowners_users');
        }

    }
    public function review_invitation_status($uid, $status)
    {
        $userdata['review_invitation_status'] = $status;
        $where_array                          = ['id' => $uid];

        $result = $this->My_model->update_entry('users', $userdata, $where_array);
        if ($status) {
            $vars = "Blocked";
        } else {
            $vars = "Unblocked";
        }
        $this->session->set_flashdata('success', 'Success! Review invitation has been ' . $vars . ' Successfully');
        return redirect('tradesmen_user');

    }
    public function delete_user($uid, $redirect = 'tradesmen_user')
    {

        $result = $this->Common_model->delete(['id' => $uid], 'users');

        if ($result) {

            $this->Common_model->delete(['up_user' => $uid], 'user_plans');

            $this->session->set_flashdata('my_msg', '<div class="alert alert-success">User has been deleted successfully.</div>');
        } else {
            $this->session->set_flashdata('my_msg', '<div class="alert alert-danger">Something went wrong, try again later.</div>');
        }

        return redirect($redirect);

    }

    public function edit_marketer($uid)
    {
        if (!empty($uid)) {
            $data['marketer'] = $this->Common_model->get_single_data('users', ['id' => $uid]);
            $data['country']  = $this->Common_model->get_countries();
            $this->load->view('Admin/edit_affiliaters', $data);
        } else {
            return redirect('affiliaters');
        }

    }

    public function update_marketer_profile()
    {
        // $user_id = $this->session->userdata('user_id');
        $user_id               = $this->input->post('user_id');
        $insert['u_website']   = $this->input->post('u_website');
        $insert['f_name']      = $this->input->post('f_name');
        $insert['l_name']      = $this->input->post('l_name');
        $insert['e_address']   = $this->input->post('e_address');
        $insert['county']      = $this->input->post('country');
        $insert['city']        = $this->input->post('locality');
        $insert['postal_code'] = $this->input->post('postal_code');
        $insert['email']       = $this->input->post('email');
        $insert['phone_no']    = $this->input->post('phone_no');
        $u_profile_old         = $this->input->post('u_profile_old');

        if ($_FILES['profile']['name']) {
            $config['upload_path']   = "img/profile";
            $config['allowed_types'] = 'jpeg|gif|jpg|png';
            $config['encrypt_name']  = true;
            $this->load->library("upload", $config);
            if ($this->upload->do_upload('profile')) {
                $profile           = $this->upload->data("file_name");
                $insert['profile'] = $profile;
            }
        }
        $this->Common_model->update('users', ['id' => $user_id], $insert);
        $this->session->set_flashdata('success', 'Success! Profile updated Successfully');
        echo json_encode('1');
        die();
    }
    public function accept_withdraw($uid, $status, $amount, $userid)
    {
        $userdata['wd_status'] = $status;
        $where_array           = ['wd_id' => $uid];
        $result                = $this->My_model->update_entry('tbl_withdrawal', $userdata, $where_array);

        $data = $this->Common_model->get_single_data('tbl_withdrawal', ['wd_id' => $uid]);

        $get_users = $this->Common_model->get_single_data('users', ['id' => $userid]);

        if ($data['wd_payment_type'] == 2) {
            $type = 'bank';
        } else {
            $type = 'paypal';
        }

        $subject = "You recently requested a withdrawal of funds to your bank account";
        $html    = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Withdrawal request processed!</p>';
        $html .= '<p style="margin:0;padding:20px 0px">Hi ' . $get_users['f_name'] . ',</p>';
        $html .= '<p style="margin:0;padding:20px 0px">The request to withdraw money from your Tradespeoplehub account to your ' . $type . ' account is processed and the money paid. </p>';
        $html .= '<p style="margin:0;padding:5px 0px">Requested withdrawal amount: £' . $data['wd_amount'] . '</p>';

        if ($data['wd_payment_type'] == 2) {
            $html .= '<p style="margin:0;padding:5px 0px">Bank name: ' . $data['wd_bank'] . '</p>';
            $html .= '<p style="margin:0;padding:5px 0px">Sort code: ' . $data['wd_ifsc_code'] . '</p>';
            $html .= '<p style="margin:0;padding:5px 0px">Bank account: ' . $data['wd_account'] . '</p>';
        } else {
            $html .= '<p style="margin:0;padding:5px 0px">Paypal username: ' . $data['wd_pay_email'] . '</p>';
        }

        $html .= '<p style="margin:0;padding:5px 0px">Transaction ID: ' . md5($uid) . '</p>';
        $html .= '<p style="margin:0;padding:20px 0px">It could take 1-2 business days for the money to appear in your bank account, depending on your bank. If it takes longer, please contact your bank.</p>';
        $html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

        $runsss = $this->Common_model->send_mail($get_users['email'], $subject, $html, null, null, 'support');

        $insertn['nt_userId'] = $userid;

        $insertn['nt_message'] = '£' . $amount . '  withdrawal processed & credited to your ' . $type . ' account.';

        $insertn['nt_satus']    = 0;
        $insertn['nt_create']   = date('Y-m-d H:i:s');
        $insertn['nt_update']   = date('Y-m-d H:i:s');
        $insertn['nt_apstatus'] = 4;
        $run2                   = $this->Common_model->insert('notification', $insertn);

        $this->session->set_flashdata('success', 'Success! Withdrawal Request Accepted Successfully');
        return redirect('withdrawal_history');
    }
    public function reject_post()
    {
        $wd_id                 = $this->input->post('wd_id');
        $amount                = $this->input->post('wd_amount');
        $userid                = $this->input->post('wd_userid');
        $userdata['wd_status'] = 2;
        $userdata['wd_reason'] = $this->input->post('reject_mgs');
        $where_array           = ['wd_id' => $wd_id];
        $result                = $this->My_model->update_entry('tbl_withdrawal', $userdata, $where_array);
        $get_users             = $this->Common_model->get_single_data('users', ['id' => $userid]);
        //$userdata1['u_wallet']=$get_users['u_wallet']+$amount;
        $userdata1['withdrawable_balance'] = $get_users['withdrawable_balance'] + $amount;
        $where_array1                      = ['id' => $userid];
        $results                           = $this->My_model->update_entry('users', $userdata1, $where_array1);
        $insert['tr_userid']               = $userid;
        $insert['tr_message']              = 'Your withdrawal request has been cancelled';
        $insert['tr_amount']               = $amount;
        $insert['tr_type']                 = 1;
        $insert['tr_status']               = 1;

        $run2   = $this->Common_model->insert('transactions', $insert);
        $reason = $this->input->post('reject_mgs');

        $subject = "Withdrawal Request Decline!";

        $html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Withdrawal request Decline!</p>';
        $html .= '<p style="margin:0;padding:20px 0px">Hi ' . $get_users['f_name'] . ',</p>';
        $html .= '<p style="margin:0;padding:20px 0px">Unfortunately, we´re unable to process the request to withdraw money from your Tradespeoplehub account to your bank account.</p>';
        $html .= '<p style="margin:0;padding:5px 0px">Requested withdrawal amount: £' . $amount . '</p>';
        $html .= '<p style="margin:0;padding:5px 0px">Transaction ID: ' . md5($wd_id) . '</p>';
        $html .= '<p style="margin:0;padding:5px 0px">Decline reason: ' . $userdata['wd_reason'] . '</p>';
        $html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

        $runsss = $this->Common_model->send_mail($get_users['email'], $subject, $html, null, null, 'support');

        $insertn['nt_userId'] = $userid;

        $insertn['nt_message']  = 'Your withdrawal request was declined. <a href="' . site_url() . 'fund-withdrawal?show_reason=' . $wd_id . '">View reason.</a>';
        $insertn['nt_satus']    = 0;
        $insertn['nt_create']   = date('Y-m-d H:i:s');
        $insertn['nt_update']   = date('Y-m-d H:i:s');
        $insertn['nt_apstatus'] = 4;
        $run2                   = $this->Common_model->insert('notification', $insertn);

        if ($results) {
            $json['status'] = 1;
            $this->session->set_flashdata('success', 'Success! Withdrawal Request Rejected Successfully');
        }

        echo json_encode($json);

    }
    public function child_category($id)
    {
        $result['category'] = $this->My_model->get_all_category1('category');
        if ($result['category'] == '') {
            $result['category'] = [];
        }
        $result['listing'] = $this->Admin_model->get_parent_cat($id);

        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/child_category', $result);

    }
    public function user_rewards()
    {
        $result['rewards'] = $this->Admin_model->get_user_rewards();

        $this->load->view('Admin/rewards', $result);

    }

    public function Manage_profile()
    {
        $adminId               = $this->session->userdata('session_adminId');
        $results1['admininfo'] = $this->Common_model->getRows('admin', $adminId);
        $this->load->view('Admin/include/header', $results1);
        $results = [];
        $this->load->view('Admin/profile', $results);

    }
    public function update_profile()
    {
        $adminId              = $this->session->userdata('session_adminId');
        $userdata['username'] = $this->input->post('Username');
        $userdata['email']    = $this->input->post('email');
        $where_array          = ['id' => $adminId];

        $check = $this->Common_model->get_single_data('admin', ['email' => $userdata['email'], 'id != ' => $adminId]);

        if ($check) {
            $this->session->set_flashdata('error', 'Error! This email address already used.');
        } else {

            $result = $this->My_model->update_entry('admin', $userdata, $where_array);
            if ($result) {
                $this->session->set_flashdata('success', 'Success! Profile Updated Successfully');
            } else {
                $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
            }
        }

        return redirect('Admin/Manage_profile');
    }
    public function dochange_password()
    {
        $session_user = $this->session->userdata('session_adminId');
        $where_array  = ['id' => $session_user];
        $data         = $this->Common_model->getRows('admin', $session_user);
        if ($data['password'] == $this->input->post('oldpassword')) {
            $userdata['password'] = $this->input->post('password');
            $result               = $this->My_model->update_entry('admin', $userdata, $where_array);
            $this->session->set_flashdata('success1', 'Success! Password has been changed successfully.');
            $res['result'] = 1;

        } else {
            $res['result'] = 0;
        }
        echo json_encode($res);
    }
    public function skills_management()
    {
        $result['listing'] = $this->My_model->alldata('tbl_skills');
        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/skills_page', $result);

    }
    public function add_skills()
    {
        $today      = date('Y-m-d h:i:s');
        $insert_arr = [
            'skills' => $this->input->post('skills'),
        ];

        $result = $this->My_model->insert_entry('tbl_skills', $insert_arr);
        if ($result) {
            $this->session->set_flashdata('success', 'Success!  send successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error!  something went wrong.');
        }
        return redirect('skills_management');
    }
    public function update_skill($id)
    {
        $update_array = [
            'skills' => $this->input->post('skills'),
        ];
        $where_array = ['id' => $id];

        $result = $this->My_model->update_entry('tbl_skills', $update_array, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success!  Skill has been edited successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error!  Skill went wrong.');
        }
        return redirect('skills_management');
    }
    public function delete_skill($id)
    {
        $session_user = $this->session->userdata('session_userId');
        $result       = $this->Common_model->delete(['id' => $id], 'tbl_skills');
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Skill has been deleted Successfully.');

        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        return redirect('skills_management');
    }
    public function business_types()
    {
        $result['listing'] = $this->My_model->alldata('business_types');
        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/business_types', $result);

    }
    public function add_type()
    {
        $insert_arr = [
            'business_name' => $this->input->post('business_name'),
        ];

        $result = $this->My_model->insert_entry('business_types', $insert_arr);
        if ($result) {
            $this->session->set_flashdata('success', 'Success!  send successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error!  something went wrong.');
        }
        return redirect('business_types');

    }
    public function update_type($id)
    {
        $update_array = [
            'business_name' => $this->input->post('business_name'),
        ];
        $where_array = ['id' => $id];

        $result = $this->My_model->update_entry('business_types', $update_array, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success!  Business Type has been edited successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error!  Something went wrong.');
        }
        return redirect('business_types');
    }
    public function delete_type($id)
    {
        $session_user = $this->session->userdata('session_userId');
        $result       = $this->Common_model->delete(['id' => $id], 'business_types');
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Type has been deleted Successfully.');

        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        return redirect('business_types');
    }

    public function logout()
    {
        $this->session->unset_userdata('session_adminId');
        return redirect('Admin');
    }
    public function contact_requests()
    {
        $result['listing'] = $this->My_model->alldata('contact_request');
        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/contacts', $result);

    }
    public function delete_request($id, $redirect = 'Admin_dashboard')
    {
        $result = $this->Common_model->delete(['id' => $id], 'contact_request');
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Contact Request has been deleted Successfully.');

        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        return redirect($redirect);
    }
    public function edit_profile($id)
    {
        $results['userinfo'] = $this->Common_model->getRows('users', $id);
        $results['country']  = $this->Common_model->newgetRows('tbl_region', ['is_delete' => 0]);
        $this->load->view('Admin/edit_page', $results);

    }
    public function tradesmen_contacts()
    {
        $result['listing'] = $this->Admin_model->get_trades_request();
        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/contacts', $result);

    }
    public function homeowners_contacts()
    {
        $result['listing1'] = $this->Admin_model->get_home_request();
        if ($result['listing1'] == '') {
            $result['listing1'] = [];
        }

        $this->load->view('Admin/contacts', $result);

    }

    public function marketers_contacts()
    {
        $result['listing2'] = $this->Admin_model->get_marketer_request();
        if ($result['listing2'] == '') {
            $result['listing2'] = [];
        }
        $this->load->view('Admin/contacts', $result);
    }

    public function update_user_profile()
    {
        $u_type  = $this->input->post('type');
        $user_id = $this->input->post('id');

        $user_profile = $this->Common_model->get_data('users', ['phone_no' => $this->input->post('phone_no')]);

        $userprofile = $this->Common_model->get_single_data('users', ['phone_no' => $this->input->post('phone_no')]);

        $this->form_validation->set_rules('f_name', 'First Name', 'required');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');

        $this->form_validation->set_rules('locality', 'City', 'required');
        $this->form_validation->set_rules('e_address', 'Address', 'required');

        if (count($user_profile) >= 0 && $userprofile['id'] != $user_id) {
            $this->form_validation->set_rules('phone_no', 'Phone number', 'required|integer|is_unique[users.phone_no]', ['is_unique' => 'This phone number is already registered']);
        } else {
            $this->form_validation->set_rules('phone_no', 'Phone number', 'required|integer');
        }

        $this->form_validation->set_rules('postal_code', 'Postal Code', 'required');

        if ($u_type == 1) {
            $this->form_validation->set_rules('trading_name', 'Trading Name', 'required');
        }
        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . validation_errors() . '</div>');
        } else {
            if ($_FILES['profile']['name']) {
                $config['upload_path']   = "img/profile";
                $config['allowed_types'] = 'jpeg|gif|jpg|png';
                $config['encrypt_name']  = true;
                $this->load->library("upload", $config);
                if ($this->upload->do_upload('profile')) {
                    $profile           = $this->upload->data("file_name");
                    $insert['profile'] = $profile;
                }
            }

            if ($userprofile['phone_no'] != $this->input->post('phone_no')) {
                $insert['is_phone_verified'] = 0;
            }

            $insert['f_name']      = $this->input->post('f_name');
            $insert['l_name']      = $this->input->post('l_name');
            $insert['county']      = $this->input->post('country');
            $insert['city']        = $this->input->post('locality');
            $insert['postal_code'] = str_replace(" ", "", $this->input->post('postal_code'));
            if ($u_type == 1) {
                $insert['about_business'] = $this->input->post('about_business');
                $insert['category']       = implode(',', $this->input->post('category'));
                $insert['subcategory']    = implode(',', $this->input->post('subcategory'));
                $insert['trading_name']   = $this->input->post('trading_name');
                //$insert['work_history'] = $this->input->post('work_history');
                $insert['qualification'] = $this->input->post('qualification');
            }
            $insert['max_distance']   = $this->input->post('distance');
            $insert['phone_no']       = $this->input->post('phone_no');
            $insert['e_address']      = $this->input->post('e_address');
            $insert['primary_lang']   = $this->input->post('userLanguage');
            $insert['secondary_lang'] = $this->input->post('second_lang');
            $insert['hourly_rate']    = $this->input->post('hourly_rate');

            $run = $this->Common_model->update('users', ['id' => $user_id], $insert);

            if ($run) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Your profile has been updated successfully.</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
            }
        }

        redirect('edit-profile/' . $user_id);
    }
    public function send_mail($id, $page)
    {

        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $f_name  = $this->input->post('first_name');
        $l_name  = $this->input->post('last_name');
        $email   = $this->input->post('email');
        $contant = 'Hi ' . $f_name . ', <br><br>';
        $contant .= $message;
        $send = $this->Common_model->send_mail($email, $subject, $contant);
        if ($send) {
            $this->session->set_flashdata('success', 'Success! Request has been replied successfully.');

        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        return redirect($page);
    }
    public function homepage_content()
    {
        $result['listing'] = $this->My_model->alldata('home_content');

        $this->load->view('Admin/home_page', $result);

    }
    public function affiliaters()
    {

        // $data['get_marketers'] = $this->Common_model->get_marketers();
        // $data['get_marketers'] = $this->common_model->GetAllData('users', array('type'=>3));

        $data['get_marketers'] = $this->db->where('type', 3)->order_by('id', 'desc')->get('users')->result_array();
        $data['total_earnig']  = $this->db->select_sum('referral_earning')->from('users')->where('type', 3)->get()->row()->referral_earning;
        // echo $this->db->last_query();

// echo "<pre>"; print_r($data['total_earnig']); exit;
        $this->load->view('Admin/affiliaters', $data);

    }
// function payouts()
    // {
    //         $data['marketer_payouts'] = $this->Common_model->get_marketer_payouts();
    //         $this->load->view('Admin/payouts',$data);

// }
    public function refferals_old()
    {

        $data['get_reff_homeowner'] = $this->Common_model->GetAllData("referrals_list", "1=1 and (select count(id) from users where users.id= referrals_list.referred_by and users.type =2 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_homeowner();
        $data['get_reff_tradsman']  = $this->Common_model->GetAllData("referrals_list", "1=1 and (select count(id) from users where users.id= referrals_list.referred_by and users.type = 1 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_tradsman();
        $data['get_reff_marketer']  = $this->Common_model->GetAllData("referrals_list", "1=1 and (select count(id) from users where users.id= referrals_list.referred_by and users.type = 3 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_marketer();
        $this->load->view('Admin/refferals', $data);

    }

    public function refferals()
    {

        $data['get_reff_homeowner'] = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type =2 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_homeowner();
        $data['get_reff_tradsman']  = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type = 1 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_tradsman();
        $data['get_reff_marketer']  = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type = 3 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_marketer();
        $this->load->view('Admin/refferals', $data);

    }

    public function view_referrals($uid)
    {
        $data['get_reff_homeowner'] = $this->db->where('referred_by', $uid)->where('user_type', 2)->order_by('id', 'desc')->get('referrals_earn_list')->result_array();
        $data['get_reff_tradsman']  = $this->db->where('referred_by', $uid)->where('user_type', 1)->order_by('id', 'desc')->get('referrals_earn_list')->result_array();
        $data['total_earnig']       = $this->db->select_sum('earn_amount')->from('referrals_earn_list')->where('referred_by', $uid)->get()->row_array();
        // echo $this->db->last_query();
        // print_r($data['get_reff_homeowner']); exit;
        $data['paymentSettings']=$this->Common_model->get_all_data('admin');
        $this->load->view('Admin/refferals', $data);

    }

    public function marketer_refferals()
    {
        $this->load->view('Admin/marketer_refferals');

    }

    public function refferalsSetting()
    {
        $data['settings'] = $this->db->get('referral_setting')->result();
        $this->load->view('Admin/refferals_settings', $data);

    }

    public function update_refferal_satting()
    {
        if ($this->input->post('referral_links_tradsman_m') && $this->input->post('referral_links_homeowner_m')) {
            $data3['type']                     = 'marketers';
            $data3['referred_type']            = 3;
            $data3['referral_links_tradsman']  = $this->input->post('referral_links_tradsman_m');
            $data3['comission_ref_tradsman']   = $this->input->post('comission_ref_tradsman_m');
            $data3['referral_links_homeowner'] = $this->input->post('referral_links_homeowner_m');
            $data3['comission_ref_homeowner']  = $this->input->post('comission_ref_homeowner_m');
            $marketer                          = $this->db->where('id', 1)->where('type', 'marketers')->get('referral_setting')->row();
            if (!empty($marketer)) {
                $this->db->where('id', 1)->where('type', 'marketers')->update('referral_setting', $data3);
            } else {
                $this->db->insert('referral_setting', $data3);
            }
        }

        if ($this->input->post('referral_links_tradsman_h') && $this->input->post('referral_links_homeowner_h')) {
            $data2['type']                     = 'homeowners';
            $data2['referred_type']            = 2;
            $data2['referral_links_tradsman']  = $this->input->post('referral_links_tradsman_h');
            $data2['comission_ref_tradsman']   = $this->input->post('comission_ref_tradsman_h');
            $data2['referral_links_homeowner'] = $this->input->post('referral_links_homeowner_h');
            $data2['comission_ref_homeowner']  = $this->input->post('comission_ref_homeowner_h');
            $homewner                          = $this->db->where('id', 2)->where('type', 'homeowners')->get('referral_setting')->row();
            if (!empty($homewner)) {
                $this->db->where('id', 2)->where('type', 'homeowners')->update('referral_setting', $data2);
            } else {
                $this->db->insert('referral_setting', $data2);
            }

        }
        if ($this->input->post('referral_links_tradsman_t') && $this->input->post('referral_links_homeowner_t')) {
            $data1['type']                     = 'tradsman';
            $data1['referred_type']            = 1;
            $data1['referral_links_tradsman']  = $this->input->post('referral_links_tradsman_t');
            $data1['comission_ref_tradsman']   = $this->input->post('comission_ref_tradsman_t');
            $data1['referral_links_homeowner'] = $this->input->post('referral_links_homeowner_t');
            $data1['comission_ref_homeowner']  = $this->input->post('comission_ref_homeowner_t');
            $tradsman                          = $this->db->where('id', 3)->where('type', 'tradsman')->get('referral_setting')->row();
            if (!empty($tradsman)) {
                $this->db->where('id', 3)->where('type', 'tradsman')->update('referral_setting', $data1);
            } else {
                $this->db->insert('referral_setting', $data1);
            }
        }

        // echo "<pre>"; print_r($_POST); exit;

        // $min_amount_cashout_m=$this->input->post('min_amount_cashout_m');
        // $min_quotes_received_m=$this->input->post('min_quotes_received_m');
        // $min_quotes_approved_m=$this->input->post('min_quotes_approved_m');
        // $comission_ref_hm=$this->input->post('comission_ref_hm');
        // $comission_ref_tm=$this->input->post('comission_ref_tm');
        // $min_amount_cashout_h=$this->input->post('min_amount_cashout_h');
        // $min_quotes_received_h=$this->input->post('min_quotes_received_h');
        // $min_quotes_approved_h=$this->input->post('min_quotes_approved_h');
        // $comission_ref_hh=$this->input->post('comission_ref_hh');
        // $comission_ref_th1=$this->input->post('comission_ref_th1');
        // $min_quotes_received_t=$this->input->post('min_quotes_received_t');
        // $min_quotes_approved_t=$this->input->post('min_quotes_approved_t');
        // $comission_ref_th=$this->input->post('comission_ref_th');
        // $comission_ref_tt=$this->input->post('comission_ref_tt');
        // $payment_method=$this->input->post('payment_method');
        // $banner=$this->input->post('banner');
        // $participating_bid=$this->input->post('participating_bid');
        // $marketer_homeowner=$this->input->post('marketer_homeowner[]');
        // $marketer_tradsman=$this->input->post('marketer_tradsman[]');
        // $homeowner_homeowner=$this->input->post('homeowner_homeowner[]');
        // $homeowner_tradsman=$this->input->post('homeowner_tradsman[]');
        // $tradsman_homeowner=$this->input->post('tradsman_homeowner[]');
        // $tradsman_tradsman=$this->input->post('tradsman_tradsman[]');
        // if($marketer_homeowner != ''){
        //     $marketer_homeowner_f = implode(",",$marketer_homeowner);
        // }if($marketer_tradsman != ''){
        //     $marketer_tradsman_f = implode(",",$marketer_tradsman);
        // }if($homeowner_homeowner != ''){
        //     $homeowner_homeowner_f = implode(",",$homeowner_homeowner);
        // }if($homeowner_tradsman != ''){
        //     $homeowner_tradsman_f = implode(",",$homeowner_tradsman);
        // }if($tradsman_homeowner != ''){
        //     $tradsman_homeowner_f = implode(",",$tradsman_homeowner);
        // }if($tradsman_tradsman != ''){
        //     $tradsman_tradsman_f = implode(",",$tradsman_tradsman);
        // }
        // $data1 = array(
        //     'min_amount_cashout'=>$min_amount_cashout_m,
        //     'min_quotes_received_homeowner'=>$min_quotes_received_m,
        //     'min_quotes_approved_tradsman'=>$min_quotes_approved_m,
        //     'comission_ref_homeowner'=>$comission_ref_hm,
        //     'comission_ref_tradsman'=>$comission_ref_tm,
        //     'payment_method'=>$payment_method,
        //     'banner'=>$banner,
        //     'participating_bid'=>$participating_bid,
        //     'referral_links_homeowner'=>$marketer_homeowner_f,
        //     'referral_links_tradsman'=>$marketer_tradsman_f
        // );
        // $data2 = array(
        //     'min_amount_cashout'=>$min_amount_cashout_h,
        //     'min_quotes_received_homeowner'=>$min_quotes_received_h,
        //     'min_quotes_approved_tradsman'=>$min_quotes_approved_h,
        //     'comission_ref_homeowner'=>$comission_ref_hh,
        //     'comission_ref_tradsman'=>$comission_ref_th1,
        //     'referral_links_homeowner'=>$homeowner_homeowner_f,
        //     'referral_links_tradsman'=>$homeowner_tradsman_f
        // );
        // $data3 = array(
        //     'min_quotes_received_homeowner'=>$min_quotes_received_t,
        //     'min_quotes_approved_tradsman'=>$min_quotes_approved_t,
        //     'comission_ref_homeowner'=>$comission_ref_th,
        //     'comission_ref_tradsman'=>$comission_ref_tt,
        //     'referral_links_homeowner'=>$tradsman_homeowner_f,
        //     'referral_links_tradsman'=>$tradsman_tradsman_f
        // );
        // $this->db->where('id','1');
        // $this->db->update('admin_settings',$data1);
        // $this->db->where('id','2');
        // $this->db->update('admin_settings',$data2);
        // $this->db->where('id','3');
        // $this->db->update('admin_settings',$data3);
        $this->session->set_flashdata('message', 'Settings Updated Successfully');
        redirect('refferals-setting');
    }

    public function referral_payouts()
    {

        // echo "<pre>"; echo $this->uri->segment(1); exit();
        if ($this->uri->segment(1) == 'pending_referral_payouts') {
            $data['payout_requests'] = $this->Common_model->GetAllData('referral_payout_requests', ['status' => 0]);
        }
        if ($this->uri->segment(1) == 'approved_referral_payouts') {
            $data['payout_requests'] = $this->Common_model->GetAllData('referral_payout_requests', ['status' => 1]);
        }
        if ($this->uri->segment(1) == 'reject_referral_payouts') {
            $data['payout_requests'] = $this->Common_model->GetAllData('referral_payout_requests', ['status' => 2]);
        }
        // echo "<pre>"; print_r($data['payout_requests']); exit;
        $this->load->view('Admin/referral_payouts', $data);

    }

    public function payout_request_status($id, $status, $uid, $p)
    {
        if (!empty($id) && $status == 1 && !empty($uid)) {
            $this->db->where('id', $id)->where('user_id', $uid)->update('referral_payout_requests', ['status' => $status]);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Payment request accepted Successfully</div>');

            $rows     = $this->db->where('id', $id)->where('user_id', $uid)->get('referral_payout_requests')->row();
            $get_user = $this->Common_model->get_single_data('users', ['id' => $uid]);

            $subject = "Earnings Cashout Request Processed: Payment on the way.";
            $html    = '<p style="margin:0;padding:10px 0px">Hi ' . $get_user['f_name'] . '!</p><br>';
            $html .= '<p style="margin:0;padding:10px 0px">The request to payout your earnings has been processed and the money paid.</p><br>';
            $html .= 'Payoutout amount: £ ' . $rows->request_amount . '<br>';
            $html .= 'Payment method: ' . $rows->payment_method . '<br>';
            $html .= '<p style="margin:0;padding:10px 0px">It could take 1-2 business days for the money to get to you. If it takes longer, please contact your payment institution.</p>';
            $html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';

            $this->Common_model->send_mail($get_user['email'], $subject, $html);

        }
        if ($p == 'ac') {
            return redirect('pending_referral_payouts');
        } elseif ($p == 'hom') {
            return redirect('payouts?v=h');
        } elseif ($p == 'trads') {
            return redirect('payouts?v=t');
        } elseif ($p == 'af') {
            return redirect('payouts');
        }
    }

    public function wallet_request_status($id, $status, $uid, $p)
    {
        if (!empty($id) && $status == 1 && !empty($uid)) {
            $amount = $this->db->where('id', $id)->where('user_id', $uid)->get('referral_payout_requests')->row();
            $user   = $this->db->where('id', $uid)->get('users')->row();

            // update referral_payout_requests table
            $this->db->where('id', $id)->where('user_id', $uid)->update('referral_payout_requests', ['status' => $status]);

            // update user table
            $this->db->where('id', $uid)->update('users', ['u_wallet' => $amount->request_amount + $user->u_wallet]);

            // insert transactions table
            $this->db->insert('transactions', ['tr_userid' => $uid, 'tr_message' => '<i class="fa fa-gbp"></i>' . $amount->request_amount . ' has been credited by referral cashout.</b>', 'tr_amount' => $amount->request_amount, 'tr_type' => 1, 'tr_transactionId' => md5(time()), 'tr_status' => 1, 'tr_created' => date('Y-m-d H:i:s')]);

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Payment request accepted Successfully</div>');
        }
        if ($p == 'ac') {
            return redirect('pending_referral_payouts');
        } elseif ($p == 'hom') {
            return redirect('payouts?v=h');
        } elseif ($p == 'trads') {
            return redirect('payouts?v=t');
        } elseif ($p == 'af') {
            return redirect('payouts');
        }
    }

    public function payout_request_rejection()
    {
        $reason_for_reject = $this->input->post('reason_for_reject');
        $user_id           = $this->input->post('user_id');
        $status            = $this->input->post('status');
        $id                = $this->input->post('id');
        if (!empty($id) && $status == 2 && !empty($user_id) && !empty($reason_for_reject)) {
            $rows         = $this->db->where('id', $id)->where('user_id', $user_id)->get('referral_payout_requests')->row();
            $rows1        = $this->db->where('id', $user_id)->get('users')->row();
            $total_amount = $rows->request_amount + $rows1->referral_earning;
            $this->db->where('id', $id)->where('user_id', $user_id)->update('referral_payout_requests', ['status' => $status, 'reason_for_reject' => $reason_for_reject]);
            $this->db->where('id', $user_id)->update('users', ['referral_earning' => $total_amount]);

            $get_user = $this->Common_model->get_single_data('users', ['id' => $user_id]);
            $subject  = "Payout request Declined!";
            $html     = '<p style="margin:0;padding:10px 0px">Hi ' . $get_user['f_name'] . '!</p><br>';
            $html .= '<p style="margin:0;padding:10px 0px">Unfortunately, we´re unable to process your payout request.</p><br>';
            $html .= 'Payoutout amount: £ ' . $rows->request_amount . '<br>';
            $html .= 'Payment method: ' . $rows->payment_method . '<br>';
            $html .= 'Declined reason: ' . $reason_for_reject . '<br>';
            $html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';

            $this->Common_model->send_mail($get_user['email'], $subject, $html);

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Payment request rejected Successfully</div>');
        }
        echo json_encode(['status' => 1, 'msg' => 'Payment request rejected Successfully']);

    }

    public function admin_settings()
    {

        $data['settings'] = $this->Common_model->get_admin_settings();
        $this->load->view('Admin/admin_settings', $data);

    }
    public function marketers_sharable()
    {

        $data['settings'] = $this->Common_model->get_admin_settings();
        $data['paymentSettings'] = $this->Common_model->get_all_data('admin');
        $this->load->view('Admin/admin_settings', $data);
    }

    public function marketers_sharable_link()
    {
        $data['settings'] = $this->Common_model->get_admin_settings();
        $this->load->view('Admin/marketers-sharable-link', $data);
    }

    public function homeowner_sharable()
    {
        $data['settings'] = $this->Common_model->get_admin_settings();
        $this->load->view('Admin/homeowner_sharable', $data);

    }

    public function homeowner_setting()
    {
        $data['settings'] = $this->Common_model->get_admin_settings();
        $data['paymentSettings'] = $this->Common_model->get_all_data('admin');
        $this->load->view('Admin/homeowner-setting', $data);
    }

// function refferals()
    // {

//         $data['get_reff_homeowner'] = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type =2 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_homeowner();
    //         $data['get_reff_tradsman'] = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type = 1 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_tradsman();
    //         $data['get_reff_marketer'] = $this->Common_model->GetAllData("referrals_earn_list", "1=1 and (select count(id) from users where users.id= referrals_earn_list.referred_by and users.type = 3 limit 1) > 0", "id", "desc"); //$this->Common_model->get_reff_marketer();
    //         $this->load->view('Admin/refferals',$data);

// }

    public function invertees()
    {
        if ($this->uri->segment(2) == 'homeowner-invertees') {

            $query = $this->db->query("SELECT referrals_earn_list.id, referred_by FROM `referrals_earn_list` WHERE `referred_type` = 2 AND (select count(id) from users where users.id = referrals_earn_list.user_id) > 0 GROUP by referred_by order by referrals_earn_list.id desc");
            // echo $this->db->last_query();
            $data['get_reff_homeowner'] = $query->result_array();
            // echo "<pre>"; print_r($data['get_reff_homeowner']);
            // exit;

            // echo $this->db->last_query();
            $data['total_earnig2'] = $this->db->select_sum('earn_amount')->from('referrals_earn_list')->where('user_type', 2)->get()->row()->earn_amount;
            // echo $this->db->last_query();

        } else {

            $query                     = $this->db->query("SELECT referrals_earn_list.id, referred_by FROM `referrals_earn_list` WHERE `referred_type` = 1 AND (select count(id) from users where users.id = referrals_earn_list.user_id) > 0 GROUP by referred_by order by referrals_earn_list.id desc");
            $data['get_reff_tradsman'] = $query->result_array();

            $data['total_earnig2'] = $this->db->select_sum('earn_amount')->from('referrals_earn_list')->where('user_type', 1)->get()->row()->earn_amount;
        }

        // echo "<pre>"; print_r($data['get_reff_tradsman']); exit;
        $this->load->view('Admin/invertees-list', $data);

    }
    public function tradesman_sharable()
    {
        $data['settings'] = $this->Common_model->get_admin_settings();
        $this->load->view('Admin/tradesman_sharable', $data);
    }
    public function tradesman_setting()
    {
        $data['settings'] = $this->Common_model->get_admin_settings();
        $data['paymentSettings'] = $this->Common_model->get_all_data('admin');
        $this->load->view('Admin/tradesman-setting', $data);
    }

    public function cost_guide_management()
    {
        $costGuides         = $this->My_model->alldata_custom('cost_guides', ['is_deleted !=' => 1]);
        $data['costGuides'] = $costGuides->result_array();
        $this->load->view('Admin/cost_guide_management', $data);
    }

    public function addCostGuide()
    {

        $this->form_validation->set_rules('slug', 'Slug name', 'trim|required|alpha_dash|is_unique[cost_guides.slug]', ['is_unique' => 'This slug already exist']);

        if ($this->form_validation->run() == false) {
            $json['status'] = 0;
            $json['msg']    = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {

            $insertData['title']       = $this->input->post('title');
            $insertData['description'] = $this->input->post('description');
            $insertData['price']       = $this->input->post('price');
            $insertData['slug']        = $this->input->post('slug');
            $insertData['meta_title']  = $this->input->post('meta_title');
            $insertData['meta_desc']   = $this->input->post('meta_desc');
            $insertData['meta_key']    = $this->input->post('meta_key');
            $insertData['price2']      = $this->input->post('price2');
            $insertData['created_at']  = date("Y-m-d H:i:s");
            $insertData['updated_at']  = date("Y-m-d H:i:s");
            if ($_FILES['image']['name']) {
                $config['upload_path']   = './img/costguide/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                // $config['max_width'] = 1920;
                // $config['min_width'] = 1348;
                // $config['max_height'] = 750;
                // $config['min_height'] = 540;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $data                = $this->upload->data();
                    $insertData['image'] = $data['file_name'];
                }
            }
            $result = $this->My_model->insert_entry('cost_guides', $insertData);
            if ($result) {
                $json['status'] = 1;
                $this->session->set_flashdata('success', 'Success! Cost guide successfully added.');
            } else {
                $json['status'] = 0;
                $json['msg']    = '<div class="alert alert-danger"> Error to add Cost Guide!! <div>';
            }
        }
        echo json_encode($json);
    }

    public function get_cost_guide()
    {
        $id        = $this->input->post('id');
        $costGuide = $this->Common_model->get_single_data('cost_guides', ['id' => $id]);

        $output = '';
        if (!empty($costGuide)) {
            $output = '
			<div class="mmss"></div>
			<div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title' . $costGuide['id'] . '" onkeyup="create_slug(' . $costGuide['id'] . ',this.value);" value="' . $costGuide['title'] . '" class="form-control" required>
      </div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug" id="slug' . $costGuide['id'] . '" value="' . $costGuide['slug'] . '" class="form-control" required>
			 </div>
      <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" name="price" id="price_1" min="0.1" step="0.1" class="form-control" value="' . $costGuide['price'] . '" required>
      </div>

				<div class="form-group">
					<label for="price">Price 2:</label>
					<input type="number" name="price2" id="price2_1" id="price2" min="0.1" step="0.1" class="form-control" value="' . $costGuide['price2'] . '" required>
				</div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" class="form-control textarea" >' . $costGuide['description'] . '</textarea>
        <p class="text-danger" id="editDescriptionError">This field is required.</p>
      </div>
			<div class="form-group">
				<label for="email"> Meta Title:</label>
				<input type="text" name="meta_title" class="form-control" value="' . $costGuide['meta_title'] . '">
			</div>
			<div class="form-group">
				<label for="email"> Meta keywords:</label>
				<input type="text" name="meta_key" class="form-control" value="' . $costGuide['meta_key'] . '">
			</div>
			<div class="form-group">
				<label for="meta_desc">Meta Description:</label>
				<textarea name="meta_desc" class="form-control">' . $costGuide['meta_desc'] . '</textarea>
			</div>
      <input type="hidden" name="id" value="' . $costGuide['id'] . '" />
      <div class="form-group">
        <label for="image">Image:</label>
        <img class="cost-image1" width="200" src="img/costguide/' . $costGuide['image'] . '" id="oldImage">
        <img class="cost-image" id="newImage" style="display:none;">
        <input type="file" name="image" class="form-control" accept="image/*"  onchange="readURL(this);">
      </div>';
        }
        echo json_encode(['output' => $output, 'description' => $costGuide['description']]);
    }

    public function update_cost_guide()
    {
        $id = $this->input->post('id');

        $slug = $this->input->post('slug');

        $check = $this->Common_model->get_data_count('cost_guides', ['id != ' => $id, 'slug' => $slug], 'id');

        if ($check > 0) {
            $this->form_validation->set_rules('slug', 'Slug name', 'trim|required|alpha_dash|is_unique[cost_guides.slug]', ['is_unique' => 'This slug already exist']);
        } else {
            $this->form_validation->set_rules('slug', 'slug', 'trim|required|alpha_dash');
        }

        if ($this->form_validation->run() == false) {
            $json['status'] = 0;
            $json['msg']    = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {

            $where = [
                'id' => $id,
            ];
            $costGuide = $this->Common_model->get_single_data('cost_guides', ['id' => $id]);

            $update['title']       = $this->input->post('title');
            $update['description'] = $this->input->post('description');
            $update['price']       = $this->input->post('price');
            $update['slug']        = $this->input->post('slug');
            $update['meta_title']  = $this->input->post('meta_title');
            $update['meta_key']    = $this->input->post('meta_key');
            $update['meta_desc']   = $this->input->post('meta_desc');
            $update['price2']      = $this->input->post('price2');
            $update['updated_at']  = date("Y-m-d H:i:s");

            if ($_FILES['image']['name']) {
                $config['upload_path']   = './img/costguide/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    unlink('img/costguide/' . $costGuide['image']);
                    $data            = $this->upload->data();
                    $update['image'] = $data['file_name'];
                }
            }

            $result = $this->My_model->update_entry('cost_guides', $update, $where);
            if ($result) {
                $json['status'] = 1;
                $this->session->set_flashdata('success', 'Success! Cost guide successfully updated.');
            } else {
                $json['status'] = 0;
                $json['msg']    = '<div class="alert alert-danger"> Error updating Cost Guide!! <div>';
            }
        }
        echo json_encode($json);
    }

    public function delete_cost_guide()
    {
        $id                   = $this->input->post('id');
        $update['is_deleted'] = 1;
        $update['updated_at'] = date("Y-m-d H:i:s");
        $result               = $this->My_model->update_entry('cost_guides', $update, ['id' => $id]);
        $response['status']   = ($result) ? 1 : 0;
        echo json_encode($response);
    }

    public function add_content()
    {
        $insert_arr = [
            'meta_title'       => $this->input->post('meta_title'),
            'meta_description' => $this->input->post('meta_description'),
        ];

        $result = $this->My_model->insert_entry('home_content', $insert_arr);
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Content has been added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

        }
        redirect('homepage_content');
    }
    public function update_content($id)
    {
        $update_array = [
            'meta_title'       => $this->input->post('meta_title'),
            'meta_key'         => $this->input->post('meta_key'),
            'meta_description' => $this->input->post('meta_description'),
        ];

        $where_array = ['id' => $id];

        $result1 = $this->My_model->update_entry('home_content', $update_array, $where_array);
        if ($result1) {
            $this->session->set_flashdata('success', 'Success!  Home Content has been updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'We have not found any changes');
        }
        return redirect('homepage_content');
    }
    public function update_script($id)
    {
        $update_array = [
            'header_script' => $this->input->post('header_script'),
            'body_script'   => $this->input->post('body_script'),
            //'footer_script'=>$this->input->post('footer_script')
        ];

        $where_array = ['id' => $id];

        $result1 = $this->My_model->update_entry('home_content', $update_array, $where_array);
        if ($result1) {
            $this->session->set_flashdata('success', 'Success!  Script has been updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'We have not found any changes');
        }
        return redirect('homepage_content');
    }

    public function update_blog($id)
    {
        $update_array = [
            'blog_title'              => $this->input->post('blog_title'),
            'blog_description'        => $this->input->post('blog_description'),
            'blog_footer_title'       => $this->input->post('blog_footer_title'),
            'blog_footer_key'         => $this->input->post('blog_footer_key'),
            'blog_footer_description' => $this->input->post('blog_footer_description'),
        ];

        $where_array = ['id' => $id];

        $result1 = $this->My_model->update_entry('home_content', $update_array, $where_array);
        if ($result1) {
            $this->session->set_flashdata('success', 'Success!  Blog details has been updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'We have not found any changes');
        }
        return redirect('homepage_content');

    }

    public function update_cost($id)
    {
        $update_array = [
            'cost_title'            => $this->input->post('cost_title'),
            'cost_description'      => $this->input->post('cost_description'),
            'cost_meta_title'       => $this->input->post('cost_meta_title'),
            'cost_meta_key'         => $this->input->post('cost_meta_key'),
            'cost_meta_description' => $this->input->post('cost_meta_description'),
        ];

        $where_array = ['id' => $id];

        $result1 = $this->My_model->update_entry('home_content', $update_array, $where_array);
        if ($result1) {
            $this->session->set_flashdata('success', 'Success!  Cost details has been updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'We have not found any changes');
        }
        return redirect('homepage_content');

    }

    public function transactions()
    {
        $result['trasactions'] = $this->Common_model->get_all_data('transactions', '', 'tr_id');

        $this->load->view('Admin/transactions', $result);

    }

    public function user_plans()
    {
        $result['user_plans'] = $this->Common_model->get_all_data('user_plans', 'up_transId!=1', 'up_update');

        $this->load->view('Admin/user_plans', $result);

    }

    public function user_jobs()
    {
        $result['user_jobs'] = $this->Common_model->get_all_data('tbl_jobs', ['is_delete!=' => 1], 'job_id');

        $this->load->view('Admin/user_jobs', $result);

    }

    public function user_bid_jobs()
    {
        $result['bid_user_jobs'] = $this->Common_model->get_all_data('tbl_jobpost_bids', "(select count(id) from tbl_jobs where tbl_jobs.job_id = tbl_jobpost_bids.job_id) > 0", 'id');

        $this->load->view('Admin/user_bid_jobs', $result);

    }

    public function package_status()
    {
        $json['result']   = 0;
        $id               = $this->input->post('id') . '</br>';
        $status           = $this->input->post('status');
        $update['status'] = $status;
        $update_data      = $this->Common_model->updates('tbl_package', 'id', $id, $update);
        if ($update_data) {
            $json['result'] = 1;
        }
        echo json_encode($json);
    }
    public function payment_setting()
    {
        $data['setting'] = $this->Common_model->get_all_data('admin');

        $this->load->view('Admin/payment_setting', $data);

    }
    // public function update_settings_old(){

    //         $min_amount_cashout_m=$this->input->post('min_amount_cashout_m');
    //         $min_quotes_received_m=$this->input->post('min_quotes_received_m');
    //         $min_quotes_approved_m=$this->input->post('min_quotes_approved_m');
    //         $comission_ref_hm=$this->input->post('comission_ref_hm');
    //         $comission_ref_tm=$this->input->post('comission_ref_tm');
    //         // $min_amount_cashout_h=$this->input->post('min_amount_cashout_h');
    //         // $min_quotes_received_h=$this->input->post('min_quotes_received_h');
    //         // $min_quotes_approved_h=$this->input->post('min_quotes_approved_h');
    //         // $comission_ref_hh=$this->input->post('comission_ref_hh');
    //         // $comission_ref_th1=$this->input->post('comission_ref_th1');
    //         // $min_quotes_received_t=$this->input->post('min_quotes_received_t');
    //         // $min_quotes_approved_t=$this->input->post('min_quotes_approved_t');
    //         // $comission_ref_th=$this->input->post('comission_ref_th');
    //         // $comission_ref_tt=$this->input->post('comission_ref_tt');
    //         $payment_method=$this->input->post('payment_method');
    //         //$banner=$this->input->post('banner');
    //         // $participating_bid=$this->input->post('participating_bid');
    //         $marketer_homeowner=$this->input->post('marketer_homeowner[]');
    //         $marketer_tradsman=$this->input->post('marketer_tradsman[]');
    //         // $homeowner_homeowner=$this->input->post('homeowner_homeowner[]');
    //         // $homeowner_tradsman=$this->input->post('homeowner_tradsman[]');
    //         // $tradsman_homeowner=$this->input->post('tradsman_homeowner[]');
    //         // $tradsman_tradsman=$this->input->post('tradsman_tradsman[]');
    //         if($marketer_homeowner != ''){
    //             $marketer_homeowner_f = implode(",",$marketer_homeowner);
    //         }if($marketer_tradsman != ''){
    //             $marketer_tradsman_f = implode(",",$marketer_tradsman);
    //         }
    //         // if($homeowner_homeowner != ''){
    //         //     $homeowner_homeowner_f = implode(",",$homeowner_homeowner);
    //         // }if($homeowner_tradsman != ''){
    //         //     $homeowner_tradsman_f = implode(",",$homeowner_tradsman);
    //         // }if($tradsman_homeowner != ''){
    //         //     $tradsman_homeowner_f = implode(",",$tradsman_homeowner);
    //         // }if($tradsman_tradsman != ''){
    //         //     $tradsman_tradsman_f = implode(",",$tradsman_tradsman);
    //         // }
    //         $data1 = array(
    //             'min_amount_cashout'=>$min_amount_cashout_m,
    //             'min_quotes_received_homeowner'=>$min_quotes_received_m,
    //             'min_quotes_approved_tradsman'=>$min_quotes_approved_m,
    //             'comission_ref_homeowner'=>$comission_ref_hm,
    //             'comission_ref_tradsman'=>$comission_ref_tm,
    //             'payment_method'=>$payment_method,
    //             'banner'=>'enable',
    //             'participating_bid'=>$participating_bid,
    //             'referral_links_homeowner'=>$marketer_homeowner_f,
    //             'referral_links_tradsman'=>$marketer_tradsman_f
    //         );

    //         $this->Common_model->updates('admin_settings','id',1,$data1);

    //     //     $data2 = array(
    //     //         'min_amount_cashout'=>$min_amount_cashout_h,
    //     //         'min_quotes_received_homeowner'=>$min_quotes_received_h,
    //     //         'min_quotes_approved_tradsman'=>$min_quotes_approved_h,
    //     //         'comission_ref_homeowner'=>$comission_ref_hh,
    //     //         'comission_ref_tradsman'=>$comission_ref_th1,
    //     //         'referral_links_homeowner'=>$homeowner_homeowner_f,
    //     //         'referral_links_tradsman'=>$homeowner_tradsman_f
    //     //     );

    //         // $this->Common_model->updates('admin_settings','id',2,$data2);

    //     //     $data3 = array(
    //     //         'min_quotes_received_homeowner'=>$min_quotes_received_t,
    //     //         'min_quotes_approved_tradsman'=>$min_quotes_approved_t,
    //     //         'comission_ref_homeowner'=>$comission_ref_th,
    //     //         'comission_ref_tradsman'=>$comission_ref_tt,
    //     //         'referral_links_homeowner'=>$tradsman_homeowner_f,
    //     //         'referral_links_tradsman'=>$tradsman_tradsman_f
    //     //     );

    //         // $this->Common_model->updates('admin_settings','id',3,$data3);

    //         $this->session->set_flashdata('message','Marketers Sharable Links Updated Successfully');
    //             redirect('Admin/marketers-sharable');
    //  }

    public function update_settings()
    {

        $min_amount_cashout_m  = $this->input->post('min_amount_cashout_m');
        $min_quotes_received_m = $this->input->post('min_quotes_received_m');
        $min_quotes_approved_m = $this->input->post('min_quotes_approved_m');
        $comission_ref_hm      = $this->input->post('comission_ref_hm');
        $comission_ref_tm      = $this->input->post('comission_ref_tm');

        $payment_method = $this->input->post('payment_method');
        $banner         = $this->input->post('banner');

        $marketer_homeowner = $this->input->post('marketer_homeowner[]');
        $marketer_tradsman  = $this->input->post('marketer_tradsman[]');

        if ($marketer_homeowner != '') {
            $marketer_homeowner_f = implode(",", $marketer_homeowner);
        }if ($marketer_tradsman != '') {
            $marketer_tradsman_f = implode(",", $marketer_tradsman);
        }

        if (isset($min_amount_cashout_m) && !empty($min_amount_cashout_m)) {
            $data1['min_amount_cashout'] = $min_amount_cashout_m;
        }

        if (isset($min_quotes_received_m) && !empty($min_quotes_received_m)) {
            $data1['min_quotes_received_homeowner'] = $min_quotes_received_m;
        }

        if (isset($min_quotes_approved_m) && !empty($min_quotes_approved_m)) {
            $data1['min_quotes_approved_tradsman'] = $min_quotes_approved_m;
        }
        if (isset($comission_ref_hm) && !empty($comission_ref_hm)) {
            $data1['comission_ref_homeowner'] = $comission_ref_hm;
        }

        if (isset($comission_ref_tm) && !empty($comission_ref_tm)) {
            $data1['comission_ref_tradsman'] = $comission_ref_tm;
        }

        if (isset($payment_method) && !empty($payment_method)) {
            $data1['payment_method'] = $payment_method;
        }

        $data1['banner'] = 'enable';
        if (isset($participating_bid) && !empty($participating_bid)) {
            $data1['participating_bid'] = $participating_bid;
        }

        if (isset($marketer_homeowner_f) && !empty($marketer_homeowner_f)) {
            $data1['referral_links_homeowner'] = $marketer_homeowner_f;
        }
        if (isset($marketer_tradsman_f) && !empty($marketer_tradsman_f)) {
            $data1['referral_links_tradsman'] = $marketer_tradsman_f;
        }
        if (isset($banner) && !empty($banner)) {
            $data1['banner'] = $banner;
        }

        $this->Common_model->updates('admin_settings', 'id', 1, $data1);
        if ($this->input->post('shareable') == 'shareable-link') {
            $this->session->set_flashdata('message', 'Marketers Sharable Links Updated Successfully');
            redirect('Admin/marketers-sharable-link');
        } else {
            $this->session->set_flashdata('message', 'Affiliate setting Updated Successfully');
            redirect('Admin/marketers-setting');
        }
    }

    public function payouts()
    {
        if (isset($_GET['v']) && $_GET['v'] == 'h') {
            $userType                = 2;
            $data['user_text']       = 'hom';
            $data['payment_setting'] = $this->Common_model->get_single_data('admin_settings', ['id' => 2]);
        } elseif (isset($_GET['v']) && $_GET['v'] == 't') {
            $userType                = 1;
            $data['user_text']       = 'trads';
            $data['payment_setting'] = $this->Common_model->get_single_data('admin_settings', ['id' => 3]);
        } else {
            $userType                = 3;
            $data['user_text']       = 'af';
            $data['payment_setting'] = $this->Common_model->get_single_data('admin_settings', ['id' => 1]);
        }
        $data['marketer_payouts'] = $this->Common_model->get_marketer_payouts($userType);
        // echo $this->db->last_query();
        // echo "<pre>"; print_r($data['marketer_payouts']); exit;
        $this->load->view('Admin/payouts', $data);

    }

    public function update_homeowner_sharable()
    {
        $min_amount_cashout_h  = $this->input->post('min_amount_cashout_h');
        $min_quotes_received_h = $this->input->post('min_quotes_received_h');
        $min_quotes_approved_h = $this->input->post('min_quotes_approved_h');
        $comission_ref_hh      = $this->input->post('comission_ref_hh');
        $comission_ref_th1     = $this->input->post('comission_ref_th1');
        $payment_method        = $this->input->post('payment_method');
        $banner                = $this->input->post('banner');

        $homeowner_homeowner = $this->input->post('homeowner_homeowner[]');
        $homeowner_tradsman  = $this->input->post('homeowner_tradsman[]');

        if ($homeowner_homeowner != '') {
            $homeowner_homeowner_f = implode(",", $homeowner_homeowner);
        }if ($homeowner_tradsman != '') {
            $homeowner_tradsman_f = implode(",", $homeowner_tradsman);
        }

        if (isset($min_amount_cashout_h) && !empty($min_amount_cashout_h)) {
            $data2['min_amount_cashout'] = $min_amount_cashout_h;
        }
        if (isset($min_quotes_received_h) && !empty($min_quotes_received_h)) {
            $data2['min_quotes_received_homeowner'] = $min_quotes_received_h;
        }
        if (isset($min_quotes_approved_h) && !empty($min_quotes_approved_h)) {
            $data2['min_quotes_approved_tradsman'] = $min_quotes_approved_h;
        }
        if (isset($comission_ref_hh) && !empty($comission_ref_hh)) {
            $data2['comission_ref_homeowner'] = $comission_ref_hh;
        }
        if (isset($comission_ref_th1) && !empty($comission_ref_th1)) {
            $data2['comission_ref_tradsman'] = $comission_ref_th1;
        }
        if (isset($homeowner_homeowner_f) && !empty($homeowner_homeowner_f)) {
            $data2['referral_links_homeowner'] = $homeowner_homeowner_f;
        }
        if (isset($homeowner_tradsman_f) && !empty($homeowner_tradsman_f)) {
            $data2['referral_links_tradsman'] = $homeowner_tradsman_f;
        }
        if (isset($banner) && !empty($banner)) {
            $data2['banner'] = $banner;
        }
        $data2['payment_method'] = $payment_method;

        $this->Common_model->updates('admin_settings', 'id', 2, $data2);
        if ($this->input->post('shareable') == 'shareable-link') {
            $this->session->set_flashdata('message', 'Homeowner Sharable Links Updated Successfully');
            redirect('Admin/homeowner-sharable');
        } else {
            $this->session->set_flashdata('message', 'Homeowner setting Updated Successfully');
            redirect('Admin/homeowner-setting');
        }

    }
    public function update_trads_sharable()
    {
        $min_amount_cashout_t  = $this->input->post('min_amount_cashout_t');
        $min_quotes_received_t = $this->input->post('min_quotes_received_t');
        $min_quotes_approved_t = $this->input->post('min_quotes_approved_t');
        $comission_ref_th      = $this->input->post('comission_ref_th');
        $comission_ref_tt      = $this->input->post('comission_ref_tt');
        $payment_method        = $this->input->post('payment_method');
        $banner                = $this->input->post('banner');

        $tradsman_homeowner = $this->input->post('tradsman_homeowner[]');
        $tradsman_tradsman  = $this->input->post('tradsman_tradsman[]');

        if ($tradsman_homeowner != '') {
            $tradsman_homeowner_f = implode(",", $tradsman_homeowner);
        }if ($tradsman_tradsman != '') {
            $tradsman_tradsman_f = implode(",", $tradsman_tradsman);
        }

        if (isset($min_amount_cashout_t) && !empty($min_amount_cashout_t)) {
            $data3['min_amount_cashout'] = $min_amount_cashout_t;
        }

        if (isset($min_quotes_received_t) && !empty($min_quotes_received_t)) {
            $data3['min_quotes_received_homeowner'] = $min_quotes_received_t;
        }

        if (isset($min_quotes_approved_t) && !empty($min_quotes_approved_t)) {
            $data3['min_quotes_approved_tradsman'] = $min_quotes_approved_t;
        }

        if (isset($comission_ref_th) && !empty($comission_ref_th)) {
            $data3['comission_ref_homeowner'] = $comission_ref_th;
        }

        if (isset($comission_ref_tt) && !empty($comission_ref_tt)) {
            $data3['comission_ref_tradsman'] = $comission_ref_tt;
        }

        if (isset($tradsman_homeowner_f) && !empty($tradsman_homeowner_f)) {
            $data3['referral_links_homeowner'] = $tradsman_homeowner_f;
        }

        if (isset($tradsman_tradsman_f) && !empty($tradsman_tradsman_f)) {
            $data3['referral_links_tradsman'] = $tradsman_tradsman_f;
        }

        if (isset($banner) && !empty($banner)) {
            $data3['banner'] = $banner;
        }

        $data3['payment_method'] = $payment_method;

        // $data3 = array(
        //     'min_quotes_received_homeowner'=>$min_quotes_received_t,
        //     'min_quotes_approved_tradsman'=>$min_quotes_approved_t,
        //     'comission_ref_homeowner'=>$comission_ref_th,
        //     'comission_ref_tradsman'=>$comission_ref_tt,
        //     'referral_links_homeowner'=>$tradsman_homeowner_f,
        //     'referral_links_tradsman'=>$tradsman_tradsman_f
        // );

        $this->Common_model->updates('admin_settings', 'id', 3, $data3);

        if ($this->input->post('shareable') == 'shareable-link') {
            $this->session->set_flashdata('message', 'Tradesman Sharable Links Updated Successfully');
            redirect('Admin/tradesman-sharable');
        } else {
            $this->session->set_flashdata('message', 'Tradesman Setting Updated Successfully');
            redirect('Admin/tradesman-setting');
        }

    }
    public function update_payment()
    {
        $this->form_validation->set_rules('p_max_w', 'Max Withdraw', 'trim|required');
        $this->form_validation->set_rules('p_min_w', 'Min Withdraw', 'trim|required');
        $this->form_validation->set_rules('p_max_d', 'Max Deposit', 'trim|required');
        $this->form_validation->set_rules('p_min_d', 'Step In Amount', 'trim|required');
        $this->form_validation->set_rules('step_in_amount', 'Min Deposit', 'trim|required');
        $this->form_validation->set_rules('step_in_day', 'Step In Day(s)', 'trim|required');
        $this->form_validation->set_rules('arbitration_fee_deadline', 'Arbitration fee deadline', 'trim|required');
        $this->form_validation->set_rules('commision', 'Commission', 'trim|required|numeric');
        $this->form_validation->set_rules('invite_to_review_status', 'invite to review', 'trim|required|integer');
        $this->form_validation->set_rules('waiting_time_accept_offer', 'waiting time accept offer', 'trim|required|integer');
        $this->form_validation->set_rules('waiting_time', 'Wating time', 'trim|required|integer');
        $this->form_validation->set_rules('processing_fee', 'Processing fee', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('paypal_comm_per', 'Paypal percent', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('paypal_comm_fix', 'Paypal fixed', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('stripe_comm_per', 'Stripe percent', 'trim|required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('stripe_comm_fix', 'Stripe fixed', 'trim|required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('feedback_day_limit', 'Feedback/Review validity', 'trim|required|integer');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">' . validation_errors() . '</div>');
        } else {
            $update['p_max_w']                   = $this->input->post('p_max_w');
            $update['p_min_w']                   = $this->input->post('p_min_w');
            $update['p_max_d']                   = $this->input->post('p_max_d');
            $update['p_min_d']                   = $this->input->post('p_min_d');
            $update['arbitration_fee_deadline']  = $this->input->post('arbitration_fee_deadline');
            $update['step_in_amount']            = $this->input->post('step_in_amount');
            $update['step_in_day']               = $this->input->post('step_in_day');
            $update['commision']                 = $this->input->post('commision');
            $update['processing_fee']            = $this->input->post('processing_fee');
            $update['feedback_day_limit']        = $this->input->post('feedback_day_limit');
            $update['paypal_comm_per']           = $this->input->post('paypal_comm_per');
            $update['paypal_comm_fix']           = $this->input->post('paypal_comm_fix');
            $update['stripe_comm_per']           = $this->input->post('stripe_comm_per');
            $update['stripe_comm_fix']           = $this->input->post('stripe_comm_fix');
            $update['credit_amount']             = $this->input->post('credit_amount');
            $update['closed_date']               = $this->input->post('closed_date');
            $update['waiting_time']              = $this->input->post('waiting_time');
            $update['invite_to_review_status']   = $this->input->post('invite_to_review_status');
            $update['waiting_time_accept_offer'] = $this->input->post('waiting_time_accept_offer');
            $update['acc_name']                  = $this->input->post('acc_name');
            $update['sort_code']                 = $this->input->post('sort_code');
            $update['acc_number']                = $this->input->post('acc_number');
            $update['bank_name']                 = $this->input->post('bank_name');
            $update['search_api_key']            = $this->input->post('search_api_key');
            $update['payment_method']            = $this->input->post('payment_method');
            $update['service_fees']              = $this->input->post('service_fees');

            $id     = $this->input->post('admin_id');
            $result = $this->Common_model->update('admin', ['id' => $id], $update);
            if ($result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Updated Successfully.</div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
            }

        }
        redirect('payment_setting');
    }
    public function withdrawal_history()
    {
        $data['withdrawal'] = $this->Common_model->get_all_withdrawal('tbl_withdrawal');

        $this->load->view('Admin/withdrawal_history', $data);

    }

    public function HamePageBanner()
    {
        //  $result['categorylist']=$this->My_model->alldata('category');
        $result['listing'] = $this->Common_model->newgetRows('hamepage_banner', '', 'hb_id');
        if ($result['listing'] == '') {
            $result['listing'] = [];
        }

        $this->load->view('Admin/hame_page_banner', $result);
    }

    public function AddHomeBanner()
    {
        $json['status'] = 0;
        $this->form_validation->set_rules('hb_day', 'Day', 'trim|required');
        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $insertData['hb_day'] = $this->input->post('hb_day');
            if ($_FILES['hb_banner']['name']) {
                $config['upload_path']   = './img/HomeBanner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_width']     = 1920;
                $config['min_width']     = 1348;
                $config['max_height']    = 750;
                $config['min_height']    = 540;
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                //$this->upload->do_upload('cat_image');
                if ($this->upload->do_upload('hb_banner')) {
                    $data                    = $this->upload->data();
                    $insertData['hb_banner'] = $data['file_name'];
                    $result                  = $this->My_model->insert_entry('hamepage_banner', $insertData);
                    $json['status']          = 1;
                    $this->session->set_flashdata('success', 'Success!  Banner has been added successfully.');
                } else {
                    $json['msg'] = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                }
            } else {
                $json['msg'] = '<div class="alert alert-danger"> banner is required! <div>';
            }
        }
        echo json_encode($json);
    }

    public function EditHomeBanner()
    {
        $json['status'] = 0;

        $json['status'] = 0;
        $this->form_validation->set_rules('hb_day', 'Day', 'trim|required');
        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $check = true;
            /*$insertData['start_date'] = date('Y-m-d',strtotime($this->input->post('start_date')));
            $insertData['end_date'] = date('Y-m-d',strtotime($this->input->post('end_date')));*/
            $insertData['hb_day'] = $this->input->post('hb_day');
            if ($_FILES['hb_banner']['name']) {
                $config['upload_path']   = './img/HomeBanner/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['remove_spaces'] = true;
                $config['encrypt_name']  = true;
                $config['max_width']     = 1920;
                $config['min_width']     = 1348;
                $config['max_height']    = 750;
                $config['min_height']    = 540;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('hb_banner')) {
                    $data                    = $this->upload->data();
                    $insertData['hb_banner'] = $data['file_name'];
                } else {
                    $check       = false;
                    $json['msg'] = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                }
            }

            //$this->upload->do_upload('cat_image');
            if ($check) {

                $hb_id = $this->input->post('hb_id');

                $result         = $this->My_model->update_entry('hamepage_banner', $insertData, ['hb_id' => $hb_id]);
                $json['status'] = 1;
                $this->session->set_flashdata('success', 'Success!  Banner has been added successfully.');
            }
        }
        //echo $this->db->last_query();
        echo json_encode($json);
    }

    public function delete_homebanner($id)
    {
        $id = $this->uri->segment(4);

        if ($id == 1) {
            $this->session->set_flashdata('error', 'error!  something went wrong.');
        } else {
            $hamepage_banner = $this->Common_model->get_single_data('hamepage_banner', ['hb_id' => $id]);
            $result          = $this->Common_model->delete(['hb_id' => $id], 'hamepage_banner');

            /*$this->db->last_query();*/
            if ($result) {
                if ($hamepage_banner) {
                    unlink('img/HomeBanner/' . $hamepage_banner['hb_banner']);
                }
                $this->session->set_flashdata('success', 'Success!  Banner has been deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'error!  something went wrong.');
            }
        }
        redirect('homepage_banner');
    }

    public function deactivate_category($id)
    {
        $update['is_activate'] = 0;
        $this->My_model->update_entry('category', $update, ['cat_id' => $id]);
        $this->session->set_flashdata('success', 'Success! Category deactivated successfully.');
        redirect('category');
    }

    public function activate_category($id)
    {
        $update['is_activate'] = 1;
        $this->My_model->update_entry('category', $update, ['cat_id' => $id]);
        $this->session->set_flashdata('success', 'Success! Category activated successfully.');
        redirect('category');
    }

    public function ratings_management()
    {
        $pageData = [];

        $joins[0][0]         = 'users AS by_user';
        $joins[0][1]         = 'ratings.rt_rateBy = by_user.id';
        $joins[0][2]         = 'left';
        $joins[1][0]         = 'users AS to_user';
        $joins[1][1]         = 'ratings.rt_rateTo = to_user.id';
        $joins[1][2]         = 'left';
        $joins[2][0]         = 'tbl_jobs';
        $joins[2][1]         = 'ratings.rt_jobid = tbl_jobs.job_id';
        $joins[2][2]         = 'left';
        $select              = "ratings.*, by_user.id AS by_userId, CONCAT(by_user.f_name, ' ', by_user.l_name) AS by_username, to_user.id AS to_userId, to_user.trading_name AS trading_name, CONCAT(to_user.f_name, ' ', to_user.l_name) AS to_username, tbl_jobs.job_id, tbl_jobs.title";
        $pageData['ratings'] = $this->Common_model->join_records('rating_table as ratings', $joins, false, $select, 'tr_id');

        /*
        $joins[0][0] = 'tbl_jobs';
        $joins[0][1] = 'rating_table.rt_jobid = tbl_jobs.job_id';
        $joins[0][2] = 'left';
        $ratings = $this->Common_model->join_records('rating_table', $joins);

        $ratings = $this->Common_model->get_all_data('rating_table');
        foreach($ratings as $key => $rating){
        $where['id'] = $rating['rt_rateBy'];
        $user = $this->Common_model->get_single_data('users', $where);
        $ratings[$key]['rateBy'] = $user['f_name'] .' ' .$user['l_name'];

        $where['id'] = $rating['rt_rateTo'];
        $user = $this->Common_model->get_single_data('users', $where);
        $ratings[$key]['rateTo'] = $user['f_name'] .' ' .$user['l_name'];
        }
        $pageData['ratings'] = $ratings;
         */

        $this->load->view('Admin/include/header');
        $this->load->view('Admin/ratings-management', $pageData);
        $this->load->view('Admin/include/footer');
    }

    public function update_rating()
    {
        $response['status']   = 0;
        $where['tr_id']       = $this->input->post('ratingId');
        $update['rt_rate']    = $this->input->post('rt_rate');
        $update['rt_comment'] = $this->input->post('rt_comment');
        $rating               = $this->Common_model->get_single_data('rating_table', $where);
        if ($this->My_model->update_entry('rating_table', $update, $where)) {

            $get_avg_rating = $this->Common_model->get_avg_rating($rating['rt_rateTo']);
            $avg            = $get_avg_rating[0]['avg'];

            $update2['average_rate'] = $avg;
            $runss1                  = $this->Common_model->update('users', ['id' => $rating['rt_rateTo']], $update2);

            $response['status']    = 1;
            $response['newRating'] = $update['rt_rate'];
        }
        echo json_encode($response);
    }

    public function delete_rating()
    {
        $response['status'] = 0;
        $ratingId           = $this->input->post('ratingId');

        $rating = $this->Common_model->GetColumnName('rating_table', ['tr_id' => $ratingId], ['rt_rateTo']);

        if ($this->Common_model->delete(['tr_id' => $ratingId], 'rating_table')) {

            $get_avg_rating = $this->Common_model->get_avg_rating($rating['rt_rateTo']);
            $avg            = $get_avg_rating[0]['avg'];

            $get_user = $this->Common_model->GetColumnName('users', ['id' => $rating['rt_rateTo']], ['total_reviews']);

            $review = $get_user['total_reviews'];

            $update2['average_rate']  = $avg;
            $update2['total_reviews'] = $review - 1;
            $runss1                   = $this->Common_model->update('users', ['id' => $rating['rt_rateTo']], $update2);

            $response['status'] = 1;
            $response['sql']    = $this->db->last_query();
        }
        echo json_encode($response);
    }

    public function delete_job()
    {
        $response['status'] = 0;
        $this->session->set_flashdata('responseMessage', '<div class="alert alert-danger">Something went wrong. Please try again later.</div>');
        $job_id = $this->input->post('job_id');

        if ($this->Common_model->delete(['job_id' => $job_id], 'tbl_jobs')) {
            $this->session->set_flashdata('responseMessage', '<div class="alert alert-success">Post deleted successfully.</div>');
            $response['status'] = 1;

            $this->Common_model->delete(['job_id' => $job_id], 'tbl_jobpost_bids');
            $this->Common_model->delete(['post_id' => $job_id], 'chat');
            $disputeDetails = $this->Common_model->fetch_records('tbl_dispute', ['ds_job_id' => $job_id]);
            if (!empty($disputeDetails)) {
                $this->Common_model->delete(['dct_disputid' => $disputeDetails[0]['ds_id']], 'disput_conversation_tbl');
                $this->Common_model->delete(['ds_job_id' => $job_id], 'tbl_dispute');
            }
        }
        echo json_encode($response);
    }

    public function update_ticket_status()
    {

        $tecketsList = $this->Common_model->get_all_data('admin_chats', ['ticket_status' => 0]);
        // $messages = $this->common_model->get_all_data('admin_chat_details', array('admin_chat_id' => $response['admin_chat_id']));

        echo "<pre>";

        foreach ($tecketsList as $key => $ticket) {
            $chats = $this->Common_model->GetSingleData('admin_chat_details', ['admin_chat_id' => $ticket['id']], 'id', 'desc');
            if (!empty($chats)) {

                if ($chats['is_admin'] == 1) {
                    $time = date('Y-m-d H:i:s');

                    $expaire = date('Y-m-d H:i:s', strtotime($chats['create_time'] . ' + 48 hours'));
                    if (strtotime($time) > strtotime($expaire)) {
                        print_r($chats);
                    }

                }

            }

        }

        exit('test');

    }

    public function job_report()
    {
        $query             = $this->db->query("SELECT * FROM `report_job` join tbl_jobs on tbl_jobs.job_id= report_job.job_id");
        $result['reports'] = $query->result_array();
        $this->load->view('Admin/job_report', $result);

    }

    public function remove_report_job()
    {
        $id     = $this->input->post('id');
        $job_id = $this->input->post('job_id');
        $this->Common_model->delete(['job_id' => $job_id], 'report_job');
        $this->Common_model->delete(['job_id' => $job_id], 'tbl_jobs');
        echo "success";
    }

    public function deleted_accounts(){
        $where['user_type'] = $_GET['user'];
        //$where['delete_request >'] = 0;
        $result['deletedAccount'] = $this->Common_model->fetch_records('delete_account_request', $where, false, false, 'id,user_id,name,email,user_type,delete_request,delete_reason');
        

        $this->load->view('Admin/delete_account', $result);
    }

    public function update_status(){
        $id = $this->input->post('id');
		$getrequest = $this->Common_model->get_single_data('delete_account_request',array('id'=>$id));

        $update['delete_request'] = $this->input->post('status');
        if($this->input->post('status') == 0){
            $update['delete_reason'] = '';
        }
        $updateRequest = $this->Common_model->update('delete_account_request', ['id' => $id], $update);
        if($updateRequest){
			$userName = $getrequest['name'];
			$userEmail = $getrequest['email'];
            if($this->input->post('status') == 2){
				/*------------Delete records of the requested user from the database code start------------*/
				$sql = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA. COLUMNS WHERE COLUMN_NAME IN('user_id') AND TABLE_SCHEMA = 'tradespeoplehub'";
				$query = $this->db->query($sql);
				$allTables = $query->result_array();
                if(!empty($allTables)){
					foreach ($allTables as $table){
                        if($table['TABLE_NAME'] != 'delete_account_request'){
                            $result = $this->Common_model->delete(['user_id' => $getrequest['user_id']], $table['TABLE_NAME']);    
                        }						
					}
				}

				$sql1 = "SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA. COLUMNS WHERE COLUMN_NAME IN('userId') AND TABLE_SCHEMA = 'tradespeoplehub'";
				$query1 = $this->db->query($sql1);
				$allTables1 = $query1->result_array();
				if(!empty($allTables1)){
					foreach ($allTables1 as $table1){
						$result1 = $this->Common_model->delete(['userId' => $getrequest['user_id']], $table1['TABLE_NAME']);
					}
				}

                $userDelete = $this->Common_model->delete(['id' => $getrequest['user_id']], 'users');
                $bidDelete = $this->Common_model->delete(['bid_by' => $getrequest['user_id']], 'tbl_jobpost_bids');
				$chatDelete1 = $this->Common_model->delete(['sender_id' => $getrequest['user_id']], 'chat');
				$chatDelete2 = $this->Common_model->delete(['receiver_id' => $getrequest['user_id']], 'chat');
               

				/*------------Delete records of the requested user from the database code end------------*/

                $subject = "Your delete account request is approved.";
                $msg = 'Your request to permanently delete your account has been approved by Admin. Now you are not able to access your account.';

				$html = 'Hi ' .$userName.',<br><br>';
				$html.= $msg;
				$this->Common_model->send_mail($userEmail,$subject,$html);
            }
            if($this->input->post('status') == 3){
				$update1['delete_request'] = 0;
				$update1['delete_reason'] = '';
				$this->Common_model->update('users', ['id' => $getrequest['user_id']], $update1);

                $subject1 = "Your delete account request is rejected.";
                $msg1 = 'Your request to permanently delete your account has been rejected.';

				$html1 = 'Hi ' .$userName.',<br><br>';
				$html1.= $msg1;
				$this->Common_model->send_mail($userEmail,$subject1,$html1);
            }
			if($this->input->post('status') == 0){
				$chatDelete3 = $this->Common_model->delete(['id' => $id], 'delete_account_request');
				$chatDelete4 = $this->Common_model->delete(['id' => $getrequest['user_id']], 'users');
			}
        }
        echo "success";
    }

    public function settings(){
        $result['settings'] = $this->Common_model->get_single_data('settings', ['id' => 1]);
        $this->load->view('Admin/settings', $result);
    }

    public function update_common_settings(){
        $update['search_api_key'] = $this->input->post('search_api_key');

        $result = $this->Common_model->update('settings', ['id' => 1], $update);
        if ($result) {
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Updated Successfully.</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
        }
        redirect('settings');
    }

    public function deleteUsers(){
        $seleceted_users = (!empty($this->input->post('seleceted_users'))) ? $this->input->post('seleceted_users') : '';
		$sanitized_user_ids = array_map('intval', explode(',', $seleceted_users));
        if(!empty($seleceted_users) && count($sanitized_user_ids) > 0){
            $this->db->where_in('id', $sanitized_user_ids);
            $this->db->delete('users');            
        }      
        $json['status'] = 1;
        $json['msg'] = 'Selected users have been deleted successfully.';
		
        echo json_encode($json); 
    }

    public function getExService($catId=""){
        $exServices = $this->Common_model->get_ex_service('extra_service',$catId);
        $tr = '';
        if(!empty($exServices)){
            $i = 1;
            foreach($exServices as $list){
                $tr .= '<tr id="ex'.$list['id'].'">
                        <td>'.$i.'</td>
                        <td>'.$list['ex_service_name'].'</td>
                        <td><button class="btn btn-danger" onclick="removeExService('.$list['id'].')"><i class="fa fa-trash"></i></button></td>
                        </tr>';
                $i++;
            }
        }
        echo $tr;
    }

    public function addExService($catId=""){
        $data = array(
            'category'=>$catId,
            'ex_service_name'=>$this->input->post('ex_service_name'),             
        );        
        $run = $this->Common_model->insert('extra_service',$data);
        $tr = '';
        if($run){
            $exServices = $this->Common_model->get_ex_service('extra_service',$catId);
            if(!empty($exServices)){
                $i = 1;
                foreach($exServices as $list){
                    $tr .= '<tr id="ex'.$list['id'].'">
                            <td>'.$i.'</td>
                            <td>'.$list['ex_service_name'].'</td>
                            <td><button class="btn btn-danger" onclick="removeExService('.$list['id'].')"><i class="fa fa-trash"></i></button></td>
                            </tr>';
                    $i++;
                }
            }            
        }
        echo $tr;
    }

    public function removeExService($exId=''){
        $run = $this->Common_model->delete(['id' => $exId], 'extra_service');
        if($run){
            echo 'Extra service deleted successfully.';
        }else{
            echo 'Something is wrong!!!';
        }
    }

    public function getFAQS($catId=""){
        $faqs = $this->Common_model->get_faqs('category_faqs',$catId);
        $tr = '';
        if(!empty($faqs)){
            $i = 1;
            foreach($faqs as $list){
                $tr .= '<tr id="faqs'.$list['id'].'">
                            <td>'.$i.'</td>
                            <td>
                            <h5 class="text-bold">Question:</h5>
                            '.$list['question'].'
                            <br><h5 class="text-bold">Answer:</h5>
                            '.$list['answer'].'
                            </td>
                            <td><button class="btn btn-danger" onclick="removeFAQs('.$list['id'].')"><i class="fa fa-trash"></i></button></td>
                            </tr>';
                    $i++;
            }
        }
        echo $tr;
    }

    public function addFAQs($catId=""){
        $data = array(
            'category_id'=>$catId,
            'question'=>$this->input->post('question'),             
            'answer'=>$this->input->post('answer'),             
        );        
        $run = $this->Common_model->insert('category_faqs',$data);
        $tr = '';
        if($run){
            $faqs = $this->Common_model->get_faqs('category_faqs',$catId);
            if(!empty($faqs)){
                $i = 1;
                foreach($faqs as $list){
                    $tr .= '<tr id="faqs'.$list['id'].'">
                            <td>'.$i.'</td>
                            <td>
                            <h5 class="text-bold">Question:</h5>
                            '.$list['question'].'
                            <br><h5 class="text-bold">Answer:</h5>
                            '.$list['answer'].'
                            </td>
                            <td><button class="btn btn-danger" onclick="removeFAQs('.$list['id'].')"><i class="fa fa-trash"></i></button></td>
                            </tr>';
                    $i++;
                }
            }            
        }
        echo $tr;
    }

    public function removeFAQs($faqId=''){
        $run = $this->Common_model->delete(['id' => $faqId], 'category_faqs');
        if($run){
            echo 'FAQS deleted successfully.';
        }else{
            echo 'Something is wrong!!!';
        }
    }

    public function service_list(){
        $result['service_list'] = $this->Common_model->get_all_service_for_admin('my_services',0);
        $this->load->view('Admin/service_list', $result);
    }

    public function getServiceDetails(){
        $sId = $this->input->post('id');
        $data['service_details'] = $this->Common_model->GetSingleData('my_services',['id'=>$sId]);
        $uId = $data['service_details']['user_id'];
        $data['service_images']=$this->Common_model->get_service_files('service_images',$sId,'image');
        $data['service_docs']=$this->Common_model->get_service_files('service_images',$sId, 'file');
        $data['service_availability'] = $this->Common_model->GetSingleData('service_availability',['service_id'=>$sId]);
        $data['service_faqs'] = $this->Common_model->get_all_data('service_faqs',['service_id'=>$sId]);
        $data['extra_services'] = $this->Common_model->get_all_data('tradesman_extra_service',['service_id'=>$sId]);
        $data['service_rating'] = $this->Common_model->getRatingsWithUsers($sId);
        $data['service_user'] = $this->Common_model->GetSingleData('users',['id'=>$uId]);
        $data['user_profile'] = $this->Common_model->get_all_data('user_portfolio',['userid'=>$uId],'','',5);

        $serviceDetailsView = $this->load->view('Admin/serviceDetails', $data);
        return $serviceDetailsView;        
    }

    public function service_orders(){
        $result['order_list'] = $this->Common_model->getAllOrderForAdmin('service_order');
        $this->load->view('Admin/service_order_list', $result);
    }

    public function service_category(){
        $result['listing'] = $this->Common_model->get_all_category('service_category');
        $result['parent_category']=$this->Common_model->get_parent_category('category');
        $this->load->view('Admin/service_category', $result);        
    }

    public function getServiceCategoryLists(){
        $data = $row = [];
        $this->load->model('ServiceCategory');
        $memData = $this->ServiceCategory->getRows($_POST);

        $newCategory = getParent(0, 'category');

        $i = $_POST['start'];
        foreach ($memData as $member) {
            $i++;
            $main_cate = '';
            if ($member->main_category && !empty($member->main_category)) {
                $get_cat = $this->Admin_model->get_parent_cates('category', $member->main_category);
                $main_cate = (count($get_cat)) ? $get_cat[0]['cat_name'] : '';
            }

            $sub_cate = '';
            if ($member->sub_category && !empty($member->sub_category)) {
                $get_cat = $this->Admin_model->get_parent_cates('category', $member->sub_category);
                $sub_cate = (count($get_cat)) ? $get_cat[0]['cat_name'] : '';
            }
            
            // $action = '<a href="' . base_url($member->slug) . '" target="_blank" class="btn btn-warning btn-xs">View Category</a> ';

            // $action .= '<a href="' . base_url() . 'child_category/' . $member->cat_id . '" class="btn btn-info btn-xs">Child Category</a> ';

            // $action .= '<a href="javascript:void(0);"  onclick="myfunction()" data-toggle="modal" data-target="#edit_category' . $member->cat_id . '" class="btn btn-success btn-xs">Edit</a> ';

            $action = '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/delete_service_category/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to delete this service category?\');">Delete</a> ';

            // if ($member->is_activate == 1) {
            //     $action .= '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/deactivate_service_category/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to deactivate this service category?\');">Deactivate</a> ';
            // } else {
            //     $action .= '<a class="btn btn-danger btn-xs" href="' . site_url() . 'Admin/Admin/activate_service_category/' . $member->cat_id . '" onclick="return confirm(\'Are you sure! you want to activate this service category?\');">Activate</a> ';
            // }

            // $action .= '<a href="javascript:void(0);" class="btn btn-warning btn-xs" style="margin-top:1px" onclick="openFAQModal('.$member->cat_id.')">FAQs</a> ';

            $action .= '<div class="modal fade in" id="edit_category' . $member->cat_id . '">
                        <div class="modal-body" >
                            <div class="modal-dialog">
                                <div class="modal-content" id="editMsg_' . $member->cat_id . '">
                                    <form onsubmit="return edit_category(' . $member->cat_id . ');" id="edit_category1' . $member->cat_id . '" method="post"  enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <div class="editmsg' . $member->cat_id . '" id="editmsg' . $member->cat_id . '"></div>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                             <h4 class="modal-title">Edit Service Category</h4>
                                        </div>
                                        <div class="modal-body">
                                                            <div class="form-group">
                                                <label for="email"> Select category:</label>
                                                <select type="text" name="cat_parent1" id="cat_parent' . $member->cat_id . '"  class="form-control" onchange="InsertTitle(this ,\'title_ft' . $member->cat_id . '\',' . $member->cat_id . ')" >
                                                    <option value="">select</option>';
                                foreach ($newCategory as $newCategoryKey => $newCategoryVal) {
                                    $newCategoryselected = ($newCategoryVal['cat_id'] == $member->cat_parent) ? 'selected' : '';
                                    $action .= '<optgroup label="' . $newCategoryVal['cat_name'] . '">
                                                        <option ' . $newCategoryselected . ' value="' . $newCategoryVal['cat_id'] . '">' . $newCategoryVal['cat_name'] . ' (Main)</option>';

                                    if (!empty($newCategoryVal['child'])) {
                                        foreach ($newCategoryVal['child'] as $childKey => $childVal) {

                                            $childCategoryselected = ($childVal['cat_id'] == $member->cat_parent) ? 'selected' : '';

                                            $action .= '<option ' . $childCategoryselected . ' value="' . $childVal['cat_id'] . '">' . $childVal['cat_name'] . '</option>';
                                        }
                                    }
                                    $action .= '</optgroup>';
                                }
                                
                                $action .= '</select>
                                            </div>
                                <div class="form-group">
                                    <label for="email"> Category Name:</label>
                                    <input type="text" name="cat_name1" onkeyup="changeQues(this , ' . $member->cat_id . '); create_slug(' . $member->cat_id . ',this.value);"  id="cat_name' . $member->cat_id . '"  value="' . $member->cat_name . '" required class="form-control" >
                                 </div>
                                 <div class="form-group">
                                    <label for="cat_ques' . $member->cat_id . '">  Category Question:</label>
                                    <input type="text" name="cat_ques"  id="cat_ques' . $member->cat_id . '"  value="' . $member->cat_ques . '" class="form-control" >
                                 </div>
                                 <div class="form-group utitle_ft title_ft' . $member->cat_id . '" style="display:none">
                                    <label for="email">  Category title for find tradesmen page:</label>
                                    <input type="text" name="title_ft1"  id="title_ft' . $member->cat_id . '"  value="' . $member->title_ft . '"  class="form-control" >
                                 </div>
                                <div class="form-group">
                                    <label for="email"> Slug:</label>
                                    <input type="text" name="slug1" id="slug' . $member->cat_id . '"  value="' . $member->slug . '" required class="form-control" >
                                    <p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Description:</label>
                                    <textarea rows="5" placeholder="" name="cat_description1" id="cat_description' . $member->cat_id . '" class="form-control">' . $member->cat_description . '</textarea>
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Meta Title:</label>
                                    <input type="text" name="meta_title1" id="meta_title' . $member->cat_id . '" class="form-control" value="' . $member->meta_title . '">
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Meta Keywords:</label>
                                    <input type="text" name="meta_key1" id="meta_key' . $member->cat_id . '" class="form-control" value="' . $member->meta_key . '">
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Meta Description:</label>
                                    <textarea rows="5" placeholder="" name="meta_description1" id="meta_description' . $member->cat_id . '" class="form-control">' . $member->meta_description . '</textarea>
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Footer Description:</label>
                                    <textarea rows="5" placeholder="" name="footer_description" id="footer_description' . $member->cat_id . '" class="form-control textarea">' . $member->footer_description . '</textarea>
                                 </div>
                                 <div class="form-group">
                                    <label for="email"> Thumbnail Image:</label>
                                <input type="file" name="cat_image1" id="cat_image' . $member->cat_id . '" class="form-control">
                                <input type="hidden" name="catimage" id="catimage' . $member->cat_id . '" value="' . $member->cat_image . '"></div>
                                 </div>
                                   <div class="modal-footer">
                                    <button type="submit" class="btn btn-info edit_btn' . $member->cat_id . '" >Save</button>
                                      <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
                                   </div>
                                   </form>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>';

            $data[] = [$member->cat_id, $main_cate, $sub_cate, $member->slug, $action];
        }

        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->ServiceCategory->countAll(),
            "recordsFiltered" => $this->ServiceCategory->countFiltered($_POST),
            "data"            => $data,
        ];

        // Output to JSON format
        echo json_encode($output);
    }

    public function add_service_category(){
        $json['status'] = 0;

        $this->form_validation->set_rules('slug', 'Slug name', 'trim|required|alpha_dash|is_unique[category.slug]', ['is_unique' => 'This slug already exist']);        
        
        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $fileError  = false;
            
            if ($fileError) {
                $json['msg']    = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                $json['status'] = 2;
            } else {
                $service_type = '';

                if(!empty($this->input->post('service_type'))){
                    $service_type = implode(',', $this->input->post('service_type'));
                }

                $insert_arr = [
                    'main_category' => $this->input->post('category'),
                    'sub_category' => $this->input->post('sub_category'),
                    'service_type' => $service_type,
                    'slug' => $this->input->post('slug'),
                    'cat_create' => date('Y-m-d h:i:s'),
                    'cat_description' => $this->input->post('cat_description'),
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_key' => $this->input->post('meta_key'),
                    'meta_description' => $this->input->post('meta_description'),
                    'footer_description' => $this->input->post('footer_description'),
                    'is_activate' => 1,
                ];

                $result = $this->My_model->insert_entry('service_category', $insert_arr);
                if ($result) {
                    $attribute = $this->input->post('attributes');
                    if(!empty($attribute)){
                        foreach ($attribute as $key => $value) {
                            $insert_attribute = [
                                'service_cat_id' => $result,
                                'attribute_name' => $value,
                            ];
                            $this->My_model->insert_entry('service_attribute', $insert_attribute);
                        }
                    }

                    $exService = $this->input->post('exService');
                    if(!empty($exService['name'])){
                        foreach ($exService['name'] as $key => $value) {
                            $insert_exService = [
                                'category' => $result,
                                'ex_service_name' => $value,
                                'price' => $exService['price'][$key],
                                'days' => $exService['days'][$key],
                            ];
                            $this->My_model->insert_entry('extra_service', $insert_exService);
                        }
                    }

                    $this->session->set_flashdata('success', 'Success! service category added successfully.');
                    $json['status'] = 1;
                } else {
                    $json['msg'] = 'Error! something went wrong.';
                    $this->session->set_flashdata('error', 'Error! something went wrong.');
                }
            }

        }
        echo json_encode($json);
    }

    public function update_service_category($id){
        $json['status'] = 0;
        $slug1 = $this->input->post('slug1');
        $slug1 = url_title($slug1);

        $categories = $this->Common_model->get_single_data('service_category', ['slug' => $slug1, 'cat_id != ' => $id]);

        $this->form_validation->set_rules('slug1', 'Slug name', 'trim|required|alpha_dash');

        if ($categories) {
            $this->form_validation->set_rules('slug1', 'Slug name', 'trim|required|alpha_dash|is_unique[category.slug]', ['is_unique' => 'This slug already exist']);
        }

        if ($this->form_validation->run() == false) {
            $json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
        } else {
            $file_check = false;
            $fileError  = false;
            if ($_FILES['cat_image1']['name'] != '') {
                $file_check              = true;
                $config['upload_path']   = './img/category/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 50000;
                $config['min_width']     = 1300;
                $config['min_height']    = 400;
                $config['remove_spaces'] = true;
                $config['encrypt_name']  = true;
                $this->load->library('upload', $config);
                $data = $this->upload->data();
                if ($this->upload->do_upload('cat_image1')) {
                    $data = $this->upload->data();
                } else {
                    $fileError = true;
                }
            }
            if ($fileError) {
                $json['status'] = 2;
                $json['msg']    = '<div class="alert alert-danger">' . $this->upload->display_errors() . '<div>';
                $this->session->set_flashdata('error', $this->upload->display_errors());
            } else {
                $update_array = [
                    'cat_name'                  => $this->input->post('cat_name1'),
                    'cat_ques'                  => $this->input->post('cat_ques'),
                    'title_ft'                  => ($this->input->post('title_ft1') != '') ? $this->input->post('title_ft1') : $this->input->post('cat_name1'),
                    'slug'                      => $slug1,
                    'cat_parent'                => $this->input->post('cat_parent1'),
                    'cat_update'                => date('Y-m-d h:i:s'),
                    'cat_description'           => $this->input->post('cat_description1'),
                    'meta_title'                => $this->input->post('meta_title1'),
                    'meta_key'                  => $this->input->post('meta_key1'),
                    'meta_description'          => $this->input->post('meta_description1'),
                    'footer_description'        => $this->input->post('footer_description'),
                    'child_footer_description1' => $this->input->post('child_footer_description1'),
                ];
                if ($file_check) {
                    $update_array['cat_image'] = $data['file_name'];
                }
                $where_array = ['cat_id' => $id];
                $result      = $this->My_model->update_entry('service_category', $update_array, $where_array);
                if ($result) {
                    $json['status'] = 1;
                    $this->session->set_flashdata('success', 'Success! Service category updated successfully.');
                } else {
                    $json['status'] = 2;
                    $this->session->set_flashdata('error', 'Some error occured.');
                }
            }
        }
        echo json_encode($json);
    }

    public function delete_service_category($id){
        $session_user = $this->session->userdata('session_userId');
        $update_array = [
            'is_delete' => 1,
            'slug'      => '',
        ];
        $where_array = ['cat_id' => $id];
        $result = $this->My_model->update_entry('service_category', $update_array, $where_array);
        if ($result) {
            $this->session->set_flashdata('success', 'Success! Service category has been deleted Successfully.');
        } else {
            $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
        }
        return redirect('service_category');
    }

    public function deactivate_service_category($id){
        $update['is_activate'] = 0;
        $this->My_model->update_entry('service_category', $update, ['cat_id' => $id]);
        $this->session->set_flashdata('success', 'Success! Service category deactivated successfully.');
        redirect('service_category');
    }

    public function activate_service_category($id){
        $update['is_activate'] = 1;
        $this->My_model->update_entry('service_category', $update, ['cat_id' => $id]);
        $this->session->set_flashdata('success', 'Success! Service category activated successfully.');
        redirect('service_category');
    }

    public function getSubCategory(){
        $id = $this->input->post('cat_id');
        $subCategory=$this->Common_model->get_sub_category('category',$id);
        $option = '';
        if(!empty($subCategory)){
            $option .= '<option value="">Please Select</option>';
            foreach($subCategory as $sCat){
                $option .= '<option value="'.$sCat['cat_id'].'">'.$sCat['cat_name'].'</option>';
            }
        }
        echo $option;
    }
}
