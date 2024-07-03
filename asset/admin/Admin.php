<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	
	public function __construct() {
       parent::__construct();
	   $this->load->library('form_validation');
	   $this->lang->load('message','english');
	   //$this->load->model('common_model');
	   $this->load->model('Admin_model');
    }
	public function index()
	{
		
	    if($this->session->userdata('session_adminId'))
		{
			return redirect('Admin_dashboard');
		}
		else{
			
		if(isset($_POST['login']) && ($_POST['login']=='login')){	

		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('password','Password','required|trim|min_length[6]|max_length[12]');
		
		
		    if($this->form_validation->run() ==FALSE){	  
		              $this->load->view('Admin/index');
			}
			else  
			{
				   $data_arr=array('email'=>$this->input->post('email'),'password'=>$this->input->post('password')); 
                   $result=$this->common_model->admin_login($data_arr);
		           
				   if($result){
				$this->session->set_userdata(array('session_adminId'=>$result['id']));
				   return redirect('Admin_dashboard','refresh');
				   }else{
					   $this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			        	return redirect('Admin_dashboard');
				   }
		    }
		}else{		
		$this->load->view('Admin/index');
		}  
		}
	} 
	
	public function Manage_profile()
	{
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);  
		$this->load->view('Admin/include/header',$results1);
		$results=[];
		$this->load->view('Admin/profile',$results);
		$this->load->view('Admin/include/footer');
		}else{    
			return redirect('Admin'); 
		}
		
	}
	public function update_profile()
	{
		$adminId=$this->session->userdata('session_adminId');
		$userdata['username']=$this->input->post('Username');
		$result=$this->common_model->update('admin',$userdata,$adminId); 
		if($result)
		{
			$this->session->set_flashdata('success', 'Success! Profile Updated Successfully');
		}
		else 
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
		}
		
		return redirect('Admin/Manage_profile');
	}
	public function Admin_dashboard()
	{
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);
		$results['active_user1']=$this->common_model->newgetRows('user_tbl',array('approve'=>1),'id');
		//$results2['active_user2']=$this->common_model->newgetRows('user_tbl',array('approve'=>0),'id'); 
		//$results=[];		
		$this->load->view('Admin/include/header',$results1);
		$this->load->view('Admin/admin_dashboard',$results);		
		$this->load->view('Admin/include/footer');
		}
		else
		{    
			return redirect('Admin');
		}
		
	} 
	 public function update_plan($id)
	 {
		 if($this->session->userdata('session_adminId'))
		{
		 $userdata=$this->input->post();
		 $result=$this->common_model->update('subscription_plan',$userdata,$id);
		 $this->session->set_flashdata('success', 'Success! Plan has been updated successfully.');
		 return redirect('Admin/Plan_management');
		 }
		else
		{    
			return redirect('Admin');
		}
	 }
	 
	public function Add_customers()
	{
	    
	   $get_result = $this->Admin_model->check_email_availablity();
	      if (!$get_result) { 
			
			//$this->active_users();
			echo "2";
         } 
         else {
		 
		$userdata=$this->input->post();
		$session_user=$this->session->userdata('session_userId');
		//$userdata['added_by']=$session_user;
		$userdata['cdate']=date('Y-m-d');
		 if($_FILES['profile_img']['name'])
		{
			$ext=end(explode(".",$_FILES['profile_img']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['profile_img']['tmp_name'],'assets/img/profile/'.$files))
			{
				$userdata['profile_img']=$files;
			}
		}
		$result=$this->common_model->insert('user_tbl',$userdata); 
		if($result)
		{
	            $to=$this->input->post('email');
				$sub="Account Information";
				$body="<p><b>Welcome</b> ".$this->input->post('f_name')." ,</p><p>Your account has been created by System Admin, Your login detail</p><p> Email: ".$this->input->post('email')." </p> <p>Your password: ".$this->input->post('password')." </p> <p><a href='".base_url('home/email_verify/'.$result.'/'.$rand_codes)."'>Click Here</a> To verify Your email Address.</p>";
				$this->common_model->send_mail($to,$sub,$body);
			   $this->session->set_flashdata('success', 'Success! User has been Added successfully.');
			    echo "1";
		}
		else 
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			echo "0";
		}
		return redirect('Admin/active_user');
	  }
	}
	 
	 public function edit_user($id)
	 {
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);  
		$results['userinfo']=$this->common_model->getRows('user_tbl',$id);  
		$this->load->view('Admin/include/header',$results1);
		//$results=[];
		$this->load->view('Admin/edit_page',$results);
		$this->load->view('Admin/include/footer');
		}else{    
			return redirect('Admin'); 
		}
		
	}
	 public function update_activeuser($id) 
	 {
		 if($this->session->userdata('session_adminId'))
		{ 
	       
	      $get_result = $this->Admin_model->check_email_availablity();
	      if (!$get_result) { 
			
			echo "2";
          } 
          else {
		 $userdata=$this->input->post();
		 if($_FILES['profile_img']['name'])
		{
			$ext=end(explode(".",$_FILES['profile_img']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['profile_img']['tmp_name'],'assets/img/profile/'.$files))
			{
				$userdata['profile_img']=$files;
			}
		}
		 $result=$this->common_model->update('user_tbl',$userdata,$id);
		 $this->session->set_flashdata('success', 'Success! User has been updated successfully.');
		  echo "1";
		 }
	 }
		else
		{    
			return redirect('Admin');
		}
	 }
	 
	 public function delete_activeuser($id)
	{
		$session_user=$this->session->userdata('session_userId');
		$result=$this->common_model->newdelete('user_tbl',array('id'=>$id)); 
		if($result)
		{
			$this->session->set_flashdata('success', 'Success! Deleted Successfully.');
			
		}
		else 
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			
		}
		return redirect('Admin/active_user');
	}
	 
	public function dochange_password()
	{
		$session_user=$this->session->userdata('session_adminId');
		$data=$this->common_model->getRows('admin',$session_user);
		if($data['password']==$this->input->post('oldpassword'))
		{
			$userdata['password']=$this->input->post('password');
			$result=$this->common_model->update('admin',$userdata,$session_user);
			$this->session->set_flashdata('success', 'Success! Password has been changed successfully.');
			$res['result']=1;
			
		}
		else 
		{
			$res['result']=0;
		}
		echo json_encode($res);
	}
	public function active_users()
	{
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);  
		$results['active_user']=$this->common_model->newgetRows('user_tbl',array('approve'=>1),'id');  
		$this->load->view('Admin/include/header',$results1);
		$this->load->view('Admin/active_users',$results);
		$this->load->view('Admin/include/footer'); 
		}
		else
		{    
			return redirect('Admin');
		}
		
	}
	public function incoming_users()
	{
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);  
		$results['active_user']=$this->common_model->newgetRows('user_tbl',array('approve'=>0,'payment_status'=>1),'id');  
		$this->load->view('Admin/include/header',$results1);
		$this->load->view('Admin/incoming_users',$results);
		$this->load->view('Admin/include/footer'); 
		}
		else
		{    
			return redirect('Admin');
		}
		
	}
	public function Approve_user($uid)
	{
		if($this->session->userdata('session_adminId'))
		{
			$userdata['approve']=1;
			$result=$this->common_model->update('user_tbl',$userdata,$uid);
			$this->session->set_flashdata('success', 'Success! User Profile has been Approved Successfully');
			
			$data=$this->common_model->getRows('user_tbl',$uid);
			$to=$data['email'];
			$sub="Profile Approved";
			
			$body="<p><b>Congrates</b> ".$data['f_name']." ,</p><p>This is an email to inform you that your profile has been approved by System Admin, Now You can access your account.</p>";
			$this->common_model->send_mail($to,$sub,$body);
			
			return redirect('Admin/incoming_user');
		}
		else 
		{
			return redirect('/');
		}
	}
	
	public function transaction_history()
	{
		if($this->session->userdata('session_adminId'))
		{
		
			$adminId=$this->session->userdata('session_adminId');
			$results1['admininfo']=$this->common_model->getRows('admin',$adminId);
			$this->load->model('Admin_model');
			$results['listing']=$this->Admin_model->get_transaction_history('purchase_transaction');
			$this->load->view('Admin/include/header',$results1);
			$this->load->view('Admin/transaction_page',$results);
			$this->load->view('Admin/include/footer');
		}
	}
	function Plan_management()
	{
		
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);
		$results['listing']=$this->common_model->getRows('subscription_plan');
		$this->load->view('Admin/include/header',$results1);
		$this->load->view('Admin/planmanage_page',$results);
		$this->load->view('Admin/include/footer');
		
	}
	public function Add_plan()
	{
		$userdata=$this->input->post();
		$session_user=$this->session->userdata('session_userId');
		//$userdata['added_by']=$session_user;
		$userdata['cdate']=date('Y-m-d');
		$result=$this->common_model->insert('subscription_plan',$userdata); 
		if($result)
		{
			$this->session->set_flashdata('success', 'Success! Plans has been Added successfully.');
			
		}
		else 
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			
		}
		return redirect('Admin/Plan_management');
		
	}
	
	 public function delete_plan($id)
	{
		$session_user=$this->session->userdata('session_userId');
		$result=$this->common_model->newdelete('subscription_plan',array('id'=>$id)); 
		if($result)
		{
			$this->session->set_flashdata('success', 'Success! Deleted Successfully.');
			
		}
		else 
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			
		}
		return redirect('Admin/Plan_management');
	}
	
	public function Blockuser($uid,$status)
	{
		if($this->session->userdata('session_adminId'))
		{
			$userdata['status']=$status;
			$result=$this->common_model->update('user_tbl',$userdata,$uid);
			if($status)
			{
				$vars="UnBlocked";
			}
			else 
			{
				$vars="Blocked";
			}
			$this->session->set_flashdata('success', 'Success! User has been '.$vars.' Successfully');
			return redirect('Admin/active_user');
		}
		else 
		{
			return redirect('/');
		}
	}
	
	public function default_setting()
	{
		if($this->session->userdata('session_adminId'))
		{
		$adminId=$this->session->userdata('session_adminId');
		$results1['admininfo']=$this->common_model->getRows('admin',$adminId);
		$results['defaultinfo']=$this->common_model->getRows('admin_setting'); 
		//$results=[];		
		$this->load->view('Admin/include/header',$results1);
		$this->load->view('Admin/default_setting',$results);
		$this->load->view('Admin/include/footer');
		}
		else
		{    
			return redirect('Admin');
		}
		
	} 
	
	public function admin_setting($id) 
	 {
		 if($this->session->userdata('session_adminId'))
		{	 
	      if($this->input->post('renew_mode')==1){
		   $userdata1=1;
		  } else {
		   $userdata1=0;
		 }
		 if($this->input->post('live_mode')==1){
			 $userdata2=1;
		  } else {
		   $userdata2=0;
		 }
		 
		 $userdata=$this->input->post();
		 $userdata['renew_mode']=$userdata1;
		 $userdata['live_mode']=$userdata2;
		 $result=$this->common_model->update('admin_setting',$userdata,$id);
		// print_r($userdata);die;
		 $this->session->set_flashdata('success', 'Success!  updated successfully.');
		 return redirect('Admin/default_setting');
		 }
		else
		{    
			return redirect('Admin');
		}
	 }
	
	function logout()
	{
		$this->session->unset_userdata('session_adminId');
		return redirect('Admin');
	}  
	
	public function send_sms() 
	 {
	 if($this->session->userdata('session_adminId'))
		{	
	     $mobile='0774340855';
         $message = 'hii';
		 $userdata=$this->input->post();
		 $result=$this->common_model->smssend($mobile,$message);
		 $result1=$this->common_model->insert('new_sms',$userdata); 
		// print_r($userdata);die;
		if($result){		
		 $this->session->set_flashdata('success', 'Success!  send successfully.');	
		 }else {
		 $this->session->set_flashdata('error', 'Error!  something went wrong.');
		 }
		  return redirect('Admin/active_user');
		} else
		{    
			return redirect('Admin');
		}
	 }
	 
	 public function import_csv()
	{
		
		$filename=$_FILES["client_csv"]["tmp_name"];
		$session_user=$this->session->userdata('session_userId');
		if($_FILES["client_csv"]["size"] > 0)
		  {
			$file = fopen($filename, "r");
			 while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			 {
				    if($emapData[1]!='Profile')
					{
						
					$userdata = array(
						'added_by'=>$session_user,
						'profile' => '',
						'f_name' => $emapData[2],
						'l_name' => $emapData[3],
						'email' => $emapData[4],
						'phone' => $emapData[5],
						'bussiness_name' =>$emapData[6],
						'cdate' => date('Y-m-d'),						
						);
					$insertId = $this->common_model->insert('user_tbl',$userdata);
					}
					$this->session->set_flashdata('success_msg', 'Success! Imported Successfully.');
			 }
			 fclose($file);
			//redirect('welcome/index');
		  }
		return redirect('Admin/active_user');
	}
}
  