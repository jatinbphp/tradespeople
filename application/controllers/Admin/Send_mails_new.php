<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Send_mails_new extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		//date_default_timezone_set('Europe/London');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Common_model');
		$this->load->model('My_model');
		$this->check_login();
		error_reporting(0);

	}
	public function check_login() {
		if(!$this->session->userdata('session_adminId'))
		{
			redirect('Admin');
		}
	}
	public function send_emails(){
		$where['type'] = 1;
		$data['tradesmans'] = $this->Common_model->fetch_records('users', $where);
		$data['jobs'] = $this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1),'job_id');
		$this->load->view('Admin/send_emails_new',$data);
	}
	public function add_tradesman(){
		$this->session->set_userdata('tradesman', $this->input->post('tradesman'));
		$selected_tradesman_list = '';
		if(count($this->input->post('tradesman'))>0){
			$where_in = $this->input->post('tradesman');
			$selected_tradesman_list=implode(',',$this->input->post('tradesman'));
		}else{
			$where_in = "";
		}
		$result_tradesmans = $this->Common_model->fetch_records('users', false, "id,f_name,l_name,email", false, false, false, false, "id", $where_in);
		$selected_tradesmans = '';
		if(count($result_tradesmans)>0){
			foreach ($result_tradesmans as $row){
				$selected_tradesmans .= '<p id="del_tradesman' . $row["id"] . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">' . $row["f_name"] . ' ' . $row["l_name"] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_tradesman(' . $row["id"] . ')"><i class="fa fa-close"></i></button> </p>';
			}
		}
		$json['sess_ids'] = json_encode($this->session->userdata('tradesman'));
		$json['selected_tradesman_list'] = $selected_tradesman_list;
		$json['selected_tradesmans'] = $selected_tradesmans;
		$json['status'] = 1;
		echo json_encode($json);
	}
	public function delete_tradesman($del_id=0){
		if($del_id>0){
			$sel_tradesman_arr = $this->input->post('tradesman');
			$is_set_tradsman = $this->input->post('is_set_tradsman');
			if($is_set_tradsman == 0){
				$this->session->set_userdata('tradesman', $sel_tradesman_arr);
				$sel_tradesman_arr = $this->session->userdata('tradesman');
			}else{
				$sel_tradesman_arr = $this->session->userdata('tradesman');
			}
			if (($key = array_search($del_id, $sel_tradesman_arr)) !== false) {
				unset($sel_tradesman_arr[$key]);
				$sel_tradesman_arr = array_values($sel_tradesman_arr);
				$this->session->set_userdata('tradesman', $sel_tradesman_arr);
			}
			
			/* $match=array_diff($sel_tradesman_arr,array('tradesman'=>$del_id));
			$sel_tradesman = $match; */
			
			$selected_tradesman_list=implode(',',$sel_tradesman_arr);
			if(count($sel_tradesman_arr)>0){
				$where_in = $sel_tradesman_arr;
			}
			else{
				$where_in = "";
			}
			$result_tradesmans = $this->Common_model->fetch_records('users', false, "id,f_name,l_name,email", false, false, false, false, "id", $where_in);
			$selected_tradesmans = '';
			if(count($result_tradesmans)>0){
				foreach ($result_tradesmans as $row){
					$selected_tradesmans .= '<p id="del_tradesman' . $row["id"] . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">' . $row["f_name"] . ' ' . $row["l_name"] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_tradesman(' . $row["id"] . ')"><i class="fa fa-close"></i></button> </p>';
				}
			}
			$json['sess_ids'] = json_encode($this->session->userdata('tradesman'));
			$json['selected_tradesman_list'] = $selected_tradesman_list;
			$json['selected_tradesmans'] = $selected_tradesmans;
			$json['status'] = 1;
		}else{
			$json['status'] = 0;
		}
		echo json_encode($json);
	}
	public function add_job(){
		$this->session->set_userdata('job_ids', $this->input->post('job_ids'));
		$selected_jobs_list = '';
		if(count($this->input->post('job_ids'))>0){
			$selected_jobs_list=implode(',',$this->input->post('job_ids'));
			$where_in = $this->input->post('job_ids');
		}else{
			$where_in = "";
		}
		$result_jobs = $this->Common_model->fetch_records('tbl_jobs', false, "job_id ,title", false, false, false, false, "job_id", $where_in);
		$selected_jobs = '';
		if(count($result_jobs)>0){
			foreach ($result_jobs as $row){
				$selected_jobs .= '<p id="del_job' . $row["job_id"] . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $row["title"] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_job(' . $row["job_id"] . ')"><i class="fa fa-close"></i></button> </p>';
			}
		}
		$json['sess_ids'] = json_encode($this->session->userdata('job_ids'));
		$json['selected_jobs_list'] = $selected_jobs_list;
		$json['selected_jobs'] = $selected_jobs;
		$json['status'] = 1;
		echo json_encode($json);
	}
	public function delete_job($del_id=0){
		if($del_id>0){
			$sel_jobs_arr = $this->input->post('job_ids');
			$is_set_job = $this->input->post('is_set_job');
			if($is_set_job == 0){
				$this->session->set_userdata('job_ids', $sel_jobs_arr);
				$sel_jobs_arr = $this->session->userdata('job_ids');
			}else{
				$sel_jobs_arr = $this->session->userdata('job_ids');
			}
			if (($key = array_search($del_id, $sel_jobs_arr)) !== false) {
				unset($sel_jobs_arr[$key]);
				$sel_jobs_arr = array_values($sel_jobs_arr);
				$this->session->set_userdata('job_ids', $sel_jobs_arr);
			}
			$selected_jobs_list=implode(',',$sel_jobs_arr);
			if(count($sel_jobs_arr)>0){
				$where_in = $sel_jobs_arr;
			}
			else{
				$where_in = "";
			}
			$result_jobs = $this->Common_model->fetch_records('tbl_jobs', false, "job_id ,title", false, false, false, false, "job_id", $where_in);
			$selected_jobs = '';
			if(count($result_jobs)>0){
				foreach ($result_jobs as $row){
					$selected_jobs .= '<p id="del_job' . $row["job_id"] . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $row["title"] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_job(' . $row["job_id"] . ')"><i class="fa fa-close"></i></button> </p>';
				}
			}
			$json['sess_ids'] = json_encode($this->session->userdata('job_ids'));
			$json['selected_jobs_list'] = $selected_jobs_list;
			$json['selected_jobs'] = $selected_jobs;
			$json['status'] = 1;
		}else{
			$json['status'] = 0;
		}
		echo json_encode($json);
	}
	public function add_tradsman_information(){
		$tradsman_email = $this->input->post('user_email');
		$tradsman_name = $this->input->post('user_name');
		$ext_tradesman_list = $this->input->post('ext_tradesman_list');
		$ext_tradesman_name_list = $this->input->post('ext_tradesman_name_list');
		$ext_tradesman_names_txt = '';
		$ext_tradesman_emails_txt = '';
		if($ext_tradesman_list != ""){
			$ext_tradesman_list_arr = explode(",",$ext_tradesman_list);
			for($i=0; $i<count($ext_tradesman_list_arr)-1; $i++){
				$ext_tradesman_emails_txt .= $ext_tradesman_list_arr[$i] . ',';
			}
			// for names
			$ext_tradesman_name_list_arr = explode(",",$ext_tradesman_name_list);
			for($i=0; $i<count($ext_tradesman_name_list_arr)-1; $i++){
				$ext_tradesman_names_txt .= $ext_tradesman_name_list_arr[$i] . ',';
			}
		}
		$ext_tradesman_emails_txt .= $tradsman_email . ',';
		$ext_tradesman_names_txt .= $tradsman_name . ',';
		$tradsman_count = $this->input->post('count_ext_tradsman');
		$tradsman_count +=1;
		$added_ext_tradsman = '';
		if($tradsman_email != ""){
			$added_ext_tradsman = '<p id="del_ext_tradsman' . $tradsman_count . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $tradsman_email . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_ext_tradsman(' . $tradsman_count . ')"><i class="fa fa-close"></i></button> </p>';
		}
		$json['added_ext_tradsman_count'] = $tradsman_count;
		$json['added_ext_tradsman_email'] = $ext_tradesman_emails_txt;
		$json['added_ext_tradsman_name'] = $ext_tradesman_names_txt;
		$json['added_ext_tradsmans'] = $added_ext_tradsman;
		$json['status'] = 1;
		echo json_encode($json);
	}
	public function upload_tradsman_file(){
		
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = "csv";
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);
		$error = "";
		$display_csv_emails = "";
		$status = 0;
		$data = array();
		if ( ! $this->upload->do_upload('tradsman_file')){
			$error = array('error' => $this->upload->display_errors());
			$status = 0;
		}
		else{
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data["upload_data"]["file_name"];
			$handle = fopen("./uploads/$file_name","r");
			$row = 0;
			if (($handle) !== FALSE) {
				while (($result = fgetcsv($handle, 10000, ",")) != FALSE) //get row vales
				{
					$num = count($result);
					$row++;
					if($row>1){
						for ($c=0; $c < 1; $c++) {
							$name = $result[0];
							$email = $result[2];
							$display_csv_emails .= '<p style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $email . '</p>';
						}
					}
				}
				$status = 1;
				//print_r($data_txt);
				fclose($handle);
			}
		}
		$json['data'] = $display_csv_emails;
		$json['csv_file_name'] = $file_name;
		$json['error'] = $error;
		$json['status'] = $status;
		echo json_encode($json);
	}
	public function bulk_emails_sending($csv_file=""){
			$csv_file = $this->input->post('csv_file_name');
			$handle = fopen("./uploads/$csv_file","r");
			$row = 1;
			$status = 0;
			if (($handle) !== FALSE) {
				while (($result = fgetcsv($handle, 10000, ",")) != FALSE) //get row vales
				{
					$num = count($result);
					$row++;
					for ($c=0; $c < 1; $c++) {
						$name = $result[0];
						$email = $result[2];
						
						$job_ids = $this->input->post('jobs_list');
						$job_ids_arr = explode(",", $job_ids);
						$jobList = "";
						if(count($job_ids_arr)>0){
							$jobList .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">
								  <tr>
									<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
									<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
								  </tr>';
							foreach($job_ids_arr as $jobs){
								$job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$jobs));
								$jobList .= $this->job_email_body($job_info);
							}
							$jobList .= '</table>';
						}
						if($email != ""){
							$html = '<p style="margin:0;padding:10px 0px">Hi '.$name.',</p>';
							$html .= '<p style="margin:0;padding:10px 0px">Here are the latest job posts that were posted in your area.</p>';
							$html .= $jobList;
							/*$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Who we are</h4></p>';
							$html .= '<p style="margin:0;padding:10px 0px">TradespeopleHub is a market-leading online platform that connects homeowners to professional tradespeople. We’ve helped many companies like yours find a massive pool of new customers, which is especially vital during these uncertain times of COVID-19.</p>';
							$html .= '<p><h4 style="font-size:15px; color: #2875D7;">How it works</h4></p>';
							$html .= '<ul>
										<li>Create an account</li>
										<li>Pick a job you want</li>
										<li>Send a proposal</li>
										<li>Complete the job</li>
										<li>Leave feedback</li>
									</ul>';
							$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Why choose us?</h4></p>';
							$html .= '<ul>
										<li>Our pay-as-you-go option which is a great budget option at just 3 GBP per lead.</li>
										<li>Use our service for 30-days without paying.</li>
										<li>Monthly plans which range from 10-20 GBP.</li>
									</ul>';
							$html .= '<br /><p style="margin:0;padding:10px 0px">If you have any more questions, I’d be delighted to jump on a quick call with you to run through the details?</p>';*/
							$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
							$subject = "Latest job posts near you : Fill the gap in your schedule";
							$status = $this->Common_model->send_mail_new($email, $subject, $html);
						}
					}
				}
				//print_r($data_txt);
				fclose($handle);
			}
			
		$json['status'] = $status;
		echo json_encode($json);
	}
	public function delete_external_tradesman($del_id=0){
		$ecount = 0;
		$ext_tradesman_email_list = '';
		$ext_tradesman_name_list = '';
		$added_ext_tradsman = '';
		$ext_tradesman_list_arr = explode(",",$this->input->post('ext_tradesman_list'));
		$ext_tradesman_name_list_arr = explode(",",$this->input->post('ext_tradesman_name_list'));
		if(count($ext_tradesman_list_arr)>0){
			for($i=0; $i<count($ext_tradesman_list_arr)-1; $i++){
				$did = $i+1;
				if($del_id != $did){
					$ecount++;
					$ext_tradesman_email_list .= $ext_tradesman_list_arr[$i] . ',';
					$ext_tradesman_name_list .= $ext_tradesman_name_list_arr[$i] . ',';
					$added_ext_tradsman .= '<p id="del_ext_tradsman' . $ecount . '" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm">'  . $ext_tradesman_list_arr[$i] . ' <button type="button" class="btn btn-danger btn-xs" onclick="del_ext_tradsman(' . $ecount . ')"><i class="fa fa-close"></i></button> </p>';
				}
			}
		}
		$json['added_ext_tradsman_count'] = $ecount;
		$json['added_ext_tradsman_email'] = $ext_tradesman_email_list;
		$json['added_ext_tradsman_name'] = $ext_tradesman_name_list;
		$json['added_ext_tradsmans'] = $added_ext_tradsman;
		$json['status'] = 1;
		echo json_encode($json);
	}
	public function get_internal_tradesman(){
		$where['type'] = 1;
		$tradesmans = $this->Common_model->fetch_records('users', $where);
		//print_r($tardesmans);
		$data = '<table id="ExportDatable" class="table table-bordered table-striped">
					<thead>
						<tr> 
							<th style="display:none;">S No.</th>
							<th><input type="checkbox" value="1" class="checkbox_header"></th>
							<th>ID</th>
							<th>Name</th>
							<th>Trading name</th>
							<th>Email</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>';			
		foreach($tradesmans as $trades){
			$data .= '<tr role="row" class="odd">
				<td><input type="checkbox" name="seleceted_users[]" value="' . $trades["id"] . '" class="checkbox_body"></td>
				<td>' . $trades["unique_id"] . '</td>
				<td>' . $trades["f_name"].' '.$trades["l_name"] . '</td>
				<td>' . $trades["trading_name"] . '</td>
				<td>' . $trades["email"] . '</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		$data .= '</tbody></table>';
		$json["tradesmans"] = $data;
		echo json_encode($json);
	}
	public function get_job_list(){
		$user_jobs=$this->Common_model->get_all_data('tbl_jobs',array('is_delete!='=>1),'job_id');
		
		$data = '<table id="ExportDatable" class="table table-bordered table-striped">
					<thead>
						<tr> 
						  <th>S.NO</th> 
						  <th>Job ID</th> 
						  <th>Job Title</th>
						  <th>Price</th> 
						  <th>Category</th>
						  <th>Subcategory</th>
						  <th>Postcode</th>
						  <th>Create Date</th>
						  <th>Action</th>
						</tr>
					</thead>
					<tbody>';			
		foreach($user_jobs as $lists){
			$category_name="";
			  if($lists['category']){
				$where='cat_id = '.$lists['category'].'';
				$category=$this->Common_model->get_all_data('category',$where);
				if(count($category)>0){
				 $category_name='';
				 foreach ($category as $key => $value) {
				  $category_name .= $value['cat_name'];
				 }
				}
			  }
			  $subcat="";
			  if($lists['subcategory'])
			  { 
				$where1='cat_id ='.$lists['subcategory'].'';
				$subcategory=$this->Common_model->get_all_data('category',$where1);
				if(count($subcategory)>0){
				 $subcat='';
				 foreach ($subcategory as $key => $value) {
				  $subcat .= $value['cat_name'];
				 }
				}

			  }
			$data .= '<tr role="row" class="odd">
				<td><input type="checkbox" name="seleceted_jobs[]" value="' . $trades["id"] . '" class="checkbox_body"></td>
				<td>' . $lists['project_id'] . '</td>
				<td>' . $lists['title'] . '</td>
				<td>' . $lists['budget'] . '</td>
				<td>' . $category_name . '</td>
				<td>' . $subcat . '</td>
				<td>' . $lists['post_code'] . '</td>
				<td>' . date('d-m-Y',strtotime($lists['c_date'])) . '</td>
				<td>&nbsp;</td>
			</tr>';
		}
		$data .= '</tbody></table>';
		$json["jobs"] = $data;
		echo json_encode($json);
	}
	public function email_sending(){
		$whereJob = "(tbl_jobs.status=1 or tbl_jobs.status=2 or tbl_jobs.status=3 or tbl_jobs.status=8) and tbl_jobs.direct_hired != 1 and tbl_jobs.is_delete=0";
		$jobs = $this->get_jobs($whereJob);

		if(count($jobs) > 0){
			$jobList = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tr>
			<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
			<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
		  </tr>';
		  foreach($jobs as $job){
			$jobList .= $this->job_email_body($job);
		  }
				$jobList .= '</table>';
		}
		$subject = "Job List";
		$this->Common_model->send_mail("pranotoshbe@gmail.com", $subject, $jobList);
	}
	public function get_jobs($whereJob = false){
    $join[0][0] = 'category';
    $join[0][1] = 'tbl_jobs.category = category.cat_id';
    $join[0][2] = 'left';
    $join[1][0] = 'users';
    $join[1][1] = 'tbl_jobs.userid = users.id';
    $join[1][2] = 'left';
    $join[2][0] = 'category AS subcategory';
    $join[2][1] = 'tbl_jobs.subcategory = subcategory.cat_id';
    $join[2][2] = 'left';
    $select = 'tbl_jobs.job_id, tbl_jobs.title, tbl_jobs.description, tbl_jobs.budget, tbl_jobs.post_code, category.cat_id, category.cat_name, users.id, users.county, users.city, subcategory.cat_id AS subcategory_id, subcategory.cat_name AS subcategory_name';

    
    return $this->Common_model->join_records('tbl_jobs', $join, $whereJob, $select);
  }
  public function job_email_body($job,$frequency=null){
    $return = '
      <tr>
        <td style="border:1px solid #E1E1E1; padding:10px 15px; width: 65%; vertical-align: top;">';
          $return .= '<h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">Job title: ' .$job['title'] .'</h4>
          <p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">
            Description: ' .$job['description'] .'
          </p>
          
        </td>
        <td style="border:1px solid #E1E1E1; padding:10px 10px; width: 35%;  vertical-align: top;">
          <h4 style="font-size:18px; margin: 0; margin-bottom: 8px; color: #333;">£' .$job['budget'] .' - £' . $job['budget2'] . ' GBP</h4>
          <a href="' .site_url() .'proposals?post_id=' .$job['job_id'] .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a>
        </td>
      </tr>';
			
			return $return;
  }
  /*public function send_emails_to_internal_tradesman(){
	  $job_ids = $this->input->post('jobs_list');
	  $job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$job_ids));
	  $user_ids = explode(",",$this->input->post('tradesman_list'));
	  foreach($user_ids as $users){
			$this->db->where('id',$users);
			$query = $this->db->get('users');
			if($query->num_rows()>0) {   
				$user_info = $query->row_array();
				$emails = $user_info['email'];
				$html = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
				  </tr>';
				  $html .= '</table>';
				  $html .= '<p style="margin:0;padding:10px 0px">Hi '.$user_info['f_name'].',</p>';
				  $html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p>';
				  $html .= $this->job_email_body($job_info);
				  $html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$subject = "Job Information";
					$status = $this->Common_model->send_mail($emails, $subject, $html);
			}
			
	  }
	  
	  $json["status"] = $status;
	  echo json_encode($json);
  }*/
  
  public function send_emails_to_internal_tradesman(){
		$status = 0;
		$job_ids = $this->input->post('jobs_list');
		$job_ids_arr = explode(",", $job_ids);
		$jobList = "";
		if(count($job_ids_arr)>0){
			$jobList .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
				  </tr>';
			foreach($job_ids_arr as $jobs){
				$job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$jobs));
				$jobList .= $this->job_email_body($job_info);
			}
			$jobList .= '</table>';
		}
		$user_ids = explode(",",$this->input->post('tradesman_list'));
		foreach($user_ids as $users){
			$this->db->where('id',$users);
			$query = $this->db->get('users');
			if($query->num_rows()>0) {
				$user_info = $query->row_array();
				$emails = $user_info['email'];
				$html = '<p style="margin:0;padding:10px 0px">Hi '.$user_info['f_name'].',</p>';
				if(count($job_ids_arr)==1){
					$job_category_id = $job_info["category"];
					$cat_info = $this->Common_model->get_single_data('category',array('cat_id '=>$job_category_id));
					$job_title = $job_info["title"];
					$job_category_name = $cat_info["cat_name"];
					$homeowner_info = $this->Common_model->get_single_data('users',array('id'=>$job_info["userid"]));
					$homeowner_county = $homeowner_info["county"];
					$subject = "Need more " . $job_category_name . " jobs in " . $homeowner_county . " to fill your schedule?";
					$html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted in the ' . $homeowner_county . ' area.</p>';
				}else{
					$html .= '<p style="margin:0;padding:10px 0px">Here are the latest job posts that were posted in your area.</p>';
					$subject = "Latest job posts near you : Fill the gap in your schedule";
				}
				
				$html .= $jobList;
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
				$status = $this->Common_model->send_mail_new($emails, $subject, $html);
			}
		}
		/*
		$find = array("<",">","&");
		$replace = array("&lt;","&gt;","&amp;");
		$htm = str_replace($find,$replace,$html);
		$html = "<pre>";
		$html .= $htm;
		$html .= "</pre>";
	  $json["html"] = $html;
		*/
	  $json["status"] = $status;
	  echo json_encode($json);
  }
  
  
  
  public function send_emails_to_external_tradesman(){
	  $status = 0;
	  $job_ids = $this->input->post('jobs_list');
		$job_ids_arr = explode(",", $job_ids);
		$jobList = "";
		if(count($job_ids_arr)>0){
			$jobList .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">
				  <tr>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
					<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
				  </tr>';
			foreach($job_ids_arr as $jobs){
				$job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$jobs));
				$jobList .= $this->job_email_body($job_info);
			}
			$jobList .= '</table>';
		}
	  $user_emails = explode(",",$this->input->post('ext_tradesman_list'));
	  $user_names = explode(",",$this->input->post('ext_tradesman_name_list'));
	  for($c=0; $c<count($user_emails); $c++){
			if($user_emails[$c] != ""){
				$uname = $user_names[$c];
				if($uname == "---"){
					$uname = '';
				}
				$html = '<p style="margin:0;padding:10px 0px">Hi ' . $uname . ',</p>';
				if(count($job_ids_arr)==1){
					$html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p>';
					$job_category_id = $job_info["category"];
					$cat_info = $this->Common_model->get_single_data('category',array('cat_id '=>$job_category_id));
					$job_title = $job_info["title"];
					$job_category_name = $cat_info["cat_name"];
					$homeowner_info = $this->Common_model->get_single_data('users',array('id'=>$job_info["userid"]));
					$homeowner_county = $homeowner_info["county"];
					$subject = "Need more " . $job_category_name . " jobs in " . $homeowner_county . " to fill your schedule?";
				}else{
					$html .= '<p style="margin:0;padding:10px 0px">Here are the latest job posts that were posted in your area.</p>';
					$subject = "Latest job posts near you : Fill the gap in your schedule";
				}
				$html .= $jobList;
				/*$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Who we are</h4></p>';
				$html .= '<p style="margin:0;padding:10px 0px">TradespeopleHub is a market-leading online platform that connects homeowners to professional tradespeople. We’ve helped many companies like yours find a massive pool of new customers, which is especially vital during these uncertain times of COVID-19.</p>';
				$html .= '<p><h4 style="font-size:15px; color: #2875D7;">How it works</h4></p>';
				$html .= '<ul>
							<li>Create an account</li>
							<li>Pick a job you want</li>
							<li>Send a proposal</li>
							<li>Complete the job</li>
							<li>Leave feedback</li>
						</ul>';
				$html .= '<p><h4 style="font-size:15px; color: #2875D7;">Why choose us?</h4></p>';
				$html .= '<ul>
							<li>Our pay-as-you-go option which is a great budget option at just 3 GBP per lead.</li>
							<li>Use our service for 30-days without paying.</li>
							<li>Monthly plans which range from 10-20 GBP.</li>
						</ul>';
				$html .= '<br /><p style="margin:0;padding:10px 0px">If you have any more questions, I’d be delighted to jump on a quick call with you to run through the details?</p>';*/
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
				$status = $this->Common_model->send_mail_new($user_emails[$c], $subject, $html);
			}
			
	  }
	  
	  $json["status"] = $status;
	  echo json_encode($json);
  }
  
  public function single_job_individual_external_tradesman(){
	  $job_id = $this->input->post('job_id2');
	  $user_emails = $this->input->post('user_email');
	  $user_names = $this->input->post('user_name');
	  $job_info = $this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$job_id));
	  $emails = "";
	  for($i=0; $i<count($user_emails); $i++){
		$email = $user_emails[$i];
		$name = $user_names[$i];
		$html = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tr>
			<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
			<td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
		  </tr>';
		  $html .= '</table>';
		  $html .= '<p style="margin:0;padding:10px 0px">Hi '.$name.',</p>';
		  $html .= '<p style="margin:0;padding:10px 0px">Here is the latest job that was posted near you.</p>';
		  $html .= $this->job_email_body($job_info);
		  $html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
			$subject = "Job Information";
			$status = $this->Common_model->send_mail($email, $subject, $html);
			$emails .= $email." | ";
	  }
	  
	  $json["emails"] = $emails;
	  $json["status"] = $status;
	  echo json_encode($json);
  }
}
?>