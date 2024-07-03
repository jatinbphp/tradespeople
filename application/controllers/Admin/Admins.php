<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
	   
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
	}
	
	public function adminlog()
	{
		if($this->session->userdata('session_user_id')){
			return redirect('user-dashboard','refresh');
		}else{
			 
			$this->load->view('admin/index');
		}
	}   
	 public function signup(){
		if($this->session->userdata('session_user_id')){
			return redirect('profile','refresh');
		}
		else
		{
			
			if(isset($_POST['submit']) && ($_POST['submit']!='')){
			
				$this->form_validation->set_rules('fname', 'First Name', 'required');
				$this->form_validation->set_rules('lname', 'Last Name', 'required');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[16]',array('required' => 'You must provide a %s.'));  
				$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'required|matches[password]');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
				//$this->form_validation->set_rules('phone', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
				//$this->form_validation->set_rules('referral_by', 'Referral By', 'required');
				//$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
				//$this->form_validation->set_rules('address', 'Address', 'required');
				//$this->form_validation->set_rules('country', 'Country', 'required');
				if ($this->form_validation->run() == FALSE)
				{ 
					
					$this->load->view('site/signup');
				}     
				else  
				{
					$code=rand(1000,10000); 
					$today= date('Y-m-d h:i:s');	
					$insert_arr = array(
						'fname' => $this->input->post('fname'),
						'lname' => $this->input->post('lname'),
						'password' => $this->input->post('password'),
						'email' => $this->input->post('email'),
						'create_date'=>$today,
						'code'=>$code,
						'profile'=>'noimg.png'
					);
					
				
					$result=$this->My_model->insert_entry('users',$insert_arr);	
					if($result){
						$this->session->set_userdata(array('session_user_id'=>$result,'session_email'=>$this->input->post('email'),'session_user_plan'=>0,'logged_in' => TRUE));	
								 
						$sid=$this->session->userdata('session_user_id');
						$to_email=$this->input->post('email');
						$subject="Email Verification";
						$body='<p style="text-align: center;color: black">Congratulation! '.$this->input->post('fname').',</p><p style="text-align: center;color: black">Thank you for signing up, you are almost there. Click on the link below to confirm your email.</p><br><br><p style="text-align: center;"> <a style="background-color:#f9d048;padding: 8px 57px 6px 63px;color: black;text-decoration: none;" class="btn btn-theme"  href="'.base_url().'site/emailverification/'.$sid.'/'.$code.'">Confirm your account</a></p>';
			
	   
						$send=$this->My_model->SendEmail($to_email,$subject,$body);
						if($send==1){
							return redirect('emailverify','refresh');
							//return redirect('','refresh');
						}else{

							$this->load->view('site/emailverify');
						}	   	  
					}   
				}			
			}else{
			
				$this->load->view('site/signup');
			}
		}
	}
	public function login()
	{
		if($this->session->userdata('session_user_id')){
		return redirect('user-dashboard','refresh');
		}else{
		$this->load->view('site/login');
		}
	}
	 public function checkemail(){
		  
		  $data_arr=array('email'=>$_REQUEST['email']);
		  $result=$this->My_model->get_entry_by_data('users',false,$data_arr);
		  if($result){
			echo 1;  
		  }
		  else{
			  echo 0;   
		  }
	  }
	  
	  public function emailverification(){
		$userid=$this->uri->segment(3);
		$code=$this->uri->segment(4); 		
		$codeext=$this->My_model->get_entry_by_data('users',true,array('id'=>$userid));
		

		if($codeext['email_verified']==0){
			if($codeext['code']==$code){
		$update_array=array('code'=>0,'email_verified'=>1);
		$where_array=array('id'=>$userid);
		$result=$this->My_model->update_entry('users',$update_array,$where_array);
	
		if($result==1){  

		
		
         if($this->session->userdata('session_user_id')){
			 
		/* if($this->session->userdata('session_user_type')==0 && $this->session->userdata('session_user_plan')==0)
		{
			return redirect('User_dash/plans/','refresh');
		}  
		else
		{ */
		$this->session->set_flashdata('flashmessage', 'Success ! Your Email has been verified successfully.'); 
		
		return redirect('user-dashboard','refresh');
		
		// }  
		
		 }else{
			 $this->session->set_flashdata('flashmessage', 'Success ! Your Email has been verified successfully. Now you can login');  
		return redirect('login','refresh');
		 }
		  
		  
		  
		
		}else{
			$this->session->set_flashdata('flashmessageerror', 'Error ! Please try again');
			return redirect('emailverify','refresh');
			}}else{  
				$this->session->set_flashdata('flashmessageerror', 'Error! Invailied Code');
				return redirect('emailverify','refresh');
			}
		}else{  
		if($this->session->userdata('session_user_id')){
		$this->session->set_flashdata('flashmessage', 'Your Email is already verified.');
			return redirect('user-dashboard','refresh');
			
		}else{
			$this->session->set_flashdata('flashmessage', 'Your Email is already verified. You can login now.');
			return redirect('login','refresh');
		}
		}  
	}
	 
	  
	public function logout()  
	{
		$this->session->set_userdata(array('session_user_id' => '', 'logged_in' => ''));

        return redirect('','refresh'); 
	}
	public function emailverify(){
		
		$data_arr=array('id'=>$this->session->userdata('session_user_id'));
		$result=$this->My_model->get_entry_by_data('users',true,$data_arr);
		
		if($this->session->userdata('session_user_id')){
		if($result['email_verified']==1){
			return redirect('user-dashboard','refresh');
		}else{
		$this->load->view('site/emailverify',$result);
		}
		}else{
			  return redirect('login','refresh');
		}
	}
	
		public function dashboard(){
		/* if($this->session->userdata('session_user_type')==0 && $this->session->userdata('session_user_plan')==0)
		{
			return redirect('User_dash/plans/','refresh');
		}
		else
		{ */	
	if($this->session->userdata('session_user_id')){
		$data_arr=array('id'=>$this->session->userdata('session_user_id'));
		$result=$this->My_model->get_entry_by_data('users',true,$data_arr);
		
		$this->load->view('site/profile',$result);
		}
		else{  
			return redirect('login','refresh');
		}
		//}
	}
	
	
	public function forgot(){
			if(isset($_POST['submit']) && ($_POST['submit']=='submit')){
			   $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			   
			   if ($this->form_validation->run() == FALSE)
                { 
		    $this->load->view('site/forgot');
				}
				else{
					$where['email']=$this->input->post('email');
			   $result=$this->My_model->get_entry_by_data('users',true, $where);
			   if($result['id']!=''){
				   
				   $to_email=$this->input->post('email');
				$subject="Forgot Password";
		        $body='<p style="text-align: center;color: black">Hello! '.$result['fname'].' '.$result['lname'].',</p>

   	<p style="text-align: center;color: black">Your Password is '.$result['password'].'</p><br><br>';
				   
				    $send=$this->My_model->SendEmail($to_email,$subject,$body);
		    if($send==1){
				
				  $this->session->set_flashdata('flashmessage', 'Success ! Your password has been sent to your email id. Please check.');  
		        return redirect('forgot','refresh');
			
			}else{
	    $this->session->set_flashdata('flashmessageerror', 'Error ! Something went wrong.');  
		        return redirect('forgot','refresh');
			}
				   
				   
				   
				   
				   
			   }else{
				   
				   $this->session->set_flashdata('flashmessageerror', 'Error ! Please Enter registered Email Id.');  
		        return redirect('forgot','refresh');
			   }
		}
		
		}else{
		$this->load->view('site/forgot');
		}
		
	}
	
} 
?>
