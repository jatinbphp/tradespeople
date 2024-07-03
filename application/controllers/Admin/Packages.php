<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Packages extends CI_Controller {
	
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

	public function index() { 
		$result['listing']=$this->My_model->get_all_category('tbl_package');
		if($result['listing']==''){
			$result['listing']  =array();     
		}
		
		$this->load->view('Admin/packages',$result);
		   
		
	}
	
	public function send_bulk_mail() {
		
		$data['users'] = $this->Common_model->GetColumnName('users',null,array('id','f_name','l_name','email','type'),true);
		$data['users1'] = $this->Common_model->GetColumnName('users',array('type'=>1),array('id','f_name','l_name','email','type'),true);
		$data['users2'] = $this->Common_model->GetColumnName('users',array('type'=>2),array('id','f_name','l_name','email','type'),true);
		
		$this->load->view('Admin/send-bulk-mail',$data);
		   
		
	}
	public function submit_send_bulk_mail() {
		$subject = $this->input->post('subject');
		$messages = $this->input->post('messages');
		$users_id = $this->input->post('users');
		
		$users_id = implode(',',$users_id); 
		
		$users = $this->Common_model->GetColumnName('users',"id in (".$users_id.")",array('f_name','l_name','email','id'),true);
		
	
		if(!empty($users)){
			foreach($users as $key => $value){
				
				//if($value['id']==11 or $value['id']==9){
				
				$html = '<p style="margin:0;padding:10px 0px">Hi '.$value['f_name'].' '.$value['l_name'].',</p><br>';
				
				$html .= '<p style="margin:0;padding:10px 0px">'.$messages.'</p><br>';
				$sent = $this->Common_model->send_mail($value['email'],$subject,$html,null,null,'support');
				/*echo $html;
				echo $value['email'];
				echo $sent;*/
				
				//}
			}
		}
		
		$this->session->set_flashdata('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		Success!  Notification has been sent successfully.</div>');
		
		
		echo json_encode(array('status'=>1));
	}

	public function get_users_option($type=null) {
		
		if($type==1){
			$when['type'] = 1;
		} else if($type==2){
			$when['type'] = 2;
		} else {
			$when['type'] = null;
		}
		
		$users = $this->Common_model->GetColumnName('users',$when,array('id','f_name','email','type'),true);
		
		$option = '';
		
		foreach($users as $row){
			$type = ($row['type']==1) ? '(T)' : '(H)'; 
			$option .= '<option value="'.$row['id'].'">'.$row['f_name'].' '.$type.' </option>';
		}
		
		echo json_encode(array('data'=>$option));
	}

	public function add_package(){
		$this->form_validation->set_rules('package_name','Plan Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('amount','Amount','required');
	 
	  if($this->input->post('sms_notification')==1) {
			$this->form_validation->set_rules('total_notification','No of notification','trim|required|integer|greater_than_equal_to[1]');
		}
        
		if($this->input->post('unlimited_limited')==0) {
			$this->form_validation->set_rules('bids_per_month','Bids Per Month','required');
		}
		
		if($this->input->post('duration_type')==0){
			$this->form_validation->set_rules('number_count','Plan Duration','required');
		}
       
		if ($this->form_validation->run()==false){
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		
		}else{
		
			if($this->input->post('unlimited_limited')==0) {
				$unlimited_limited=0;
				$bid= $this->input->post('bids_per_month').' bids';
			} else {
				$bid='';
				$unlimited_limited=1;
			}
			
			if($this->input->post('duration_type')==0) {
				$valid_type=$this->input->post('number_count').' '.$this->input->post('validation_type');
				$duration_type=0;
			} else {
				$duration_type=$this->input->post('duration_type');
				$valid_type='';
			}
			
			if($this->input->post('reward_check')==0) {
				$reward=0;
				$reward_amount='';
			} else {
				$reward=1;
				$reward_amount=$this->input->post('reward_amount');
			}
					
			if($this->input->post('is_free')){
				
				$is_free=1;
				$number_count2 = $this->input->post('number_count2');
				$validation_type2 = $this->input->post('validation_type2');
				$free_bids_per_month = $this->input->post('free_bids_per_month').' bids';
				$free_plan_exp = $number_count2.' '.$validation_type2;
				$free_sms = $this->input->post('free_sms');
			} else {
				$free_bids_per_month='';
				$is_free=0;
				$free_plan_exp='';
				$free_sms=0;
			}

			$insert_arr = array(
				'package_name' => $this->input->post('package_name'),
				'description' => $this->input->post('description'),
				'amount' => $this->input->post('amount'),
				'unlimited_limited' => $unlimited_limited,
				'bids_per_month' => $bid,
				'email_notification' => $this->input->post('email_notification'),
				'sms_notification'=>$this->input->post('sms_notification'),
				'total_notification'=>$this->input->post('total_notification'),
				'category_listing'=>$this->input->post('category_listing'),
				'directory_listing'=>$this->input->post('directory_listing'),
				'unlimited_trade_category'=>$this->input->post('unlimited_trade_category'),
				'is_free'=>$is_free,
				'free_plan_exp'=>$free_plan_exp,
				'free_bids_per_month' => $free_bids_per_month,
				'validation_type'=>$valid_type,
				'duration_type'=>$duration_type,
				'free_sms'=>$free_sms,
				'reward_amount'=>$reward_amount,
				'reward'=>$reward
			);  
			
			$plan_id=$this->input->post('plan_id');
			
			if($plan_id){
				$result=$this->Common_model->update('tbl_package',array('id'=>$plan_id),$insert_arr);
        $this->session->set_flashdata('success', 'Success!  Membership Plan has been updated successfully.');
			
			}else{		
		 
				$result=$this->My_model->insert_entry('tbl_package',$insert_arr);
				$this->session->set_flashdata('success', 'Success! Membership Plan has been added successfully.');
				if($result){
					$json['status'] = 1;	
				}else{
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Error!  something went wrong.</div>';
				}
		  }
		     
		}

	 	echo json_encode($json);
	}
	public function edit_package($id){
		$this->form_validation->set_rules('package_name','Plan Name','required');
		$this->form_validation->set_rules('description','Description','required');
		if($this->input->post('sms_notification')==1){
			$this->form_validation->set_rules('total_notification','No of notification','trim|required|integer|greater_than_equal_to[1]');
		}
		
		if($id!=44){
			$this->form_validation->set_rules('amount','Amount','required');
		}
         
		if($this->input->post('unlimited_limited')==0) {
			$this->form_validation->set_rules('bids_per_month','Bids Per Month','required');
		}
           
		if($this->input->post('duration_type')==0) {
			$this->form_validation->set_rules('number_count','Plan Duration','required');
		}

		if ($this->form_validation->run()==false){
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		} else {
			
			$valid_type=$this->input->post('number_count').' '.$this->input->post('validation_type');
			if($this->input->post('unlimited_limited')==0) {
				$unlimited_limited=0;
				$bid= $this->input->post('bids_per_month').' bids';
			} else {
				$bid='';
				$unlimited_limited=1;
			}
			
			if($this->input->post('duration_type')==0) {
				$valid_type=$this->input->post('number_count').' '.$this->input->post('validation_type');
				$duration_type=0;
			} else {
				$duration_type=$this->input->post('duration_type');
				$valid_type='';
			}
			
			if($this->input->post('reward_check')==0 || $id==44) {
				$reward=0;
				$reward_amount='';
			} else {
				$reward=1;
				$reward_amount=$this->input->post('reward_amount');
			}
			
			if($this->input->post('is_free')){
				$is_free=1;
				$number_count2 = $this->input->post('number_count2');
				$validation_type2 = $this->input->post('validation_type2');
				$free_bids_per_month = $this->input->post('free_bids_per_month').' bids';
				$free_plan_exp = $number_count2.' '.$validation_type2;
				$free_sms = $this->input->post('free_sms');
			} else {
				$is_free=0;
				$free_bids_per_month='';
				$free_plan_exp='';
				$free_sms=0;
			}
			
			$insert_arr = array(
				'package_name' => $this->input->post('package_name'),
				'description' => $this->input->post('description'),
				'amount' => ($id==44)?0:$this->input->post('amount'),
				'unlimited_limited' => $unlimited_limited,
				'bids_per_month' => $bid,
				'email_notification' => $this->input->post('email_notification'),
				'sms_notification'=>$this->input->post('sms_notification'),
				'total_notification'=>$this->input->post('total_notification'),
				'category_listing'=>$this->input->post('category_listing'),
				'directory_listing'=>$this->input->post('directory_listing'),
				'unlimited_trade_category'=>$this->input->post('unlimited_trade_category'),
				'is_free'=>$is_free,
				'free_plan_exp'=>$free_plan_exp,
				'free_bids_per_month'=>$free_bids_per_month,
				'validation_type'=>$valid_type,
				'duration_type'=>$duration_type,
				'free_sms'=>$free_sms,
				'reward_amount'=>$reward_amount,
				'reward'=>$reward
			);  
			
			$result=$this->Common_model->update('tbl_package',array('id'=>$id),$insert_arr);
        

			if($result){
		    $json['status'] = 1;
		    $this->session->set_flashdata('success', 'Success!  Membership Plan has been updated successfully.');	
		  }else{
		  	$json['status'] = 2;
				$this->session->set_flashdata('error', 'Error!  We have not found any changes.');
		  }
	
		     
		}

	 	echo json_encode($json);
	}

	 function delete_package($id){
		$insert_arr = array('is_delete' => 1); 

			
			$delete=$this->Common_model->update('tbl_package',array('id'=>$id),$insert_arr);
			if($delete){
				$this->session->set_flashdata('success', 'Success!  Membership Plan has been deleted successfully.');
			}else{
				$this->session->set_flashdata('error', 'error!  something went wrong.');
			}
			
		
		redirect('packages');
	 }
	 
	 public function cancel_user_plan($id,$user_id){
		 
		$insert_arr = array('up_id' => $id);

		$update['up_status'] = 0;
		$update['auto_update'] = 0;

			
		$delete=$this->Common_model->update('user_plans',$insert_arr,$update);
		if($delete){
			
			$user=$this->Common_model->get_single_data('users',array('id'=>$user_id));
			
			//$user['email'] = 'anil.webwiders@gmail.com';
			
			$subject = "Your monthly subscription has been cancelled";
				
			$html = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p><br>';
			$html .= '<p style="margin:0;padding:10px 0px">Your monthly subscription has been cancelled and you will no longer have access to your membership benefits. This means you will not be able to provide quotes, receive SMS job notification and respond to a special job offer.</p>';
			$html .= '<p style="margin:0;padding:10px 0px">We want to keep seeing you on our platform, so if the price is the problem for wanting to leave us, we would like to invite you to use our "Pay As You Go" option. You can easily activate it now by clicking. </p>';
			
				
			$html .= '<br><div style="text-align:center"><a href="'.site_url().'wallet" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Get Pay As You Go </a></div><br>';
			
			$html .= '<p style="margin:0;padding:10px 0px">If you want to come back, our membership plan is just a click away. All you have to do is to reactivate your subscription.</p>';
			
			
			$html .= '<br><div style="text-align:center"><a href="'.site_url().'membership-plans" style="background-color:#fe8a0f;color:#fff;padding:8px 22px; text-align:center; display:inline-block; line-height:25px; border-radius:3px; font-size:17px; text-decoration:none">Reactivate the subscription</a></div><br>';
			
			$html .= '<p style="margin:0;padding:10px 0px">We hope to welcome you back soon! Your historical data will be waiting for you when you get back.</p>';
				
			$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->Common_model->send_mail($user['email'], $subject, $html,null,null,'support');
				
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Success!  Membership Plan has been cancelled successfully.</div>');
		}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Error!  something went wrong.</div>');
		}
			
		
		redirect('user_plans');
	 }

} ?>