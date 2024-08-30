<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Posts extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		$this->load->model('search_model');
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020');
		error_reporting(0);

	}
	public function check_contact_info(){
		
		$description = strtolower($this->input->post('description'));
		
		$status = 1;
		
		foreach ($this->words as $url) {
			if (strpos($description, $url) !== FALSE) {
				$status = 0; break;
			}
		}
		echo $status;
	}
	public function cancel_requested_milestone($id,$postid){
		
		$milestone_data = $this->common_model->get_single_data('tbl_milestones',array('id'=>$id));
		
		$this->common_model->delete(array('id'=>$id),'tbl_milestones');
		$this->session->set_flashdata('success1','Milestone request has been deleted successfully.');
		
		
		$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$postid));
		
		$has_email_noti = $this->common_model->check_email_notification($get_job_post['awarded_to']);
		if($has_email_noti){
		
			// $subject = "Milestone Request cancelled";
			
			// $content= 'Hello '.$has_email_noti['f_name'].', <br><br>';
	
			// $content.='<p class="text-center">You have cancelled milestone for the job post <b>'.$get_job_post['title'].'</b> of amount £'.$milestone_data['milestone_amount'].' .</p>';
			// $content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$postid.'" style="color:grey">'.site_url().'payments/?post_id='.$postid.'</a></p>';

			$subject = "Milestone Payment cancellation request for Job ".$get_job_post['title']."  accepted!";
			
			// $content= 'Milestone payment request cancelled successfully <br><br>';
			$content= 'Hi '.$has_email_noti['f_name'].', <br><br>';
			$content.= 'Your milestone payment cancellation request was successfully.<br><br>';
			$content.= 'Milestone name: '.$milestone_data['milestone_name'].'<br>';
			$content.= 'Milestone amount: £'.$milestone_data['milestone_amount'].'<br>';
			$content.= '<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request a new milestone</a></div><br>';
			$content.= 'View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.<br><br>';
			
			// $content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$postid.'" style="color:grey">'.site_url().'payments/?post_id='.$postid.'</a></p>';

			// $content.= '<p style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;">Request a new milestone</p>';
	
			// $content.='<p class="text-center">You have cancelled milestone for the job post <b>'.$get_job_post['title'].'</b> of amount £'.$milestone_data['milestone_amount'].' .</p>';
			// $content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$postid.'" style="color:grey">'.site_url().'payments/?post_id='.$postid.'</a></p>';

			$this->common_model->send_mail($has_email_noti['email'],$subject,$content);
		
		}
		
		$has_email_noti = $this->common_model->check_email_notification($get_job_post['userid']);
			
		if($has_email_noti){
			
			$trades = $this->common_model->get_userDataByid($get_job_post['awarded_to']);
		
			$subject = "Milestone Request";
			
			$content= 'Hello '.$has_email_noti['f_name'].', <br><br>';
	
			$content.='<p class="text-center">'.$trades['trading_name'].' has cancelled requested milestone for the job post <b>'.$get_job_post['title'].'</b> of amount £'.$milestone_data['milestone_amount'].' .</p>';
			$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$postid.'" style="color:grey">'.site_url().'payments/?post_id='.$postid.'</a></p>';
			$this->common_model->send_mail($has_email_noti['email'],$subject,$content);
		
		}
			
		redirect('payments/?post_id='.$postid);
	}
	
	public function decline_requested_milestone($id,$postid){
		$mileData = $this->common_model->get_single_data('tbl_milestones',array('id'=>$id));
		
		$bidData = $this->common_model->get_single_data('tbl_milestones',array('id'=>$mileData['bid_id']));
		$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		
		$JobData = $this->common_model->get_single_data('tbl_milestones',array('id'=>$mileData['post_id']));
		$has_email_noti = $this->common_model->check_email_notification($mileData['created_by']);

		$this->common_model->delete(array('id'=>$id),'tbl_milestones');
		
		
		$insertn['nt_userId']=$mileData['created_by'];
		$insertn['nt_message']= $get_users['f_name'] .' declined your milestone request!';
		$insertn['nt_satus']=0;
		$insertn['nt_apstatus']=2;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');   
		$insertn['job_id']=$JobData['job_id'];
		$insertn['posted_by']=$this->session->userdata('user_id');
		$run2 = $this->common_model->insert('notification',$insertn);
		
						
		if($has_email_noti){
			$subject1 = "Your milestone creation request has been declined by ".$get_users['f_name'];

			$html1 = 'Hi '.$get_users['f_name'].'<br><br>';
			$html1.= 'Your request to create a milestone has been declined by '.$get_users['f_name'].'<br><br>';
			$html1.= 'Milestone name: '.$mileData['milestone_name'].'<br>';
			$html1.= 'Milestone amount: £'.$mileData['milestone_amount'].'<br>';
			$html1.= '<div style="text-align:center"><a href="'.site_url().'details/?post_id='.$mileData['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div><br>';
			$html1.= 'We encourage you to discuss with '.$get_users['f_name'].' and explain why the milestone needs to be created.<br><br>';
			$html1.= 'View our  tradespeopöe help page or contact our customer services if you have any specific questions using our service.<br><br>';

			$this->common_model->send_mail($has_email_noti['email'],$subject1,$html1);



			$subject = "Milestone declined";
		
			$html = '<h2 style="margin:0;font-size:22px;padding-bottom:5px;color:#2875d7">Milestone released successfully</h2><p style="margin:0;padding:10px 0px">'.$get_users['f_name'].' has declined the milestone of amount £'.$mileData['milestone_amount'].'</p><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$postid.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$postid.'" style="color:grey">'.site_url().'payments/?post_id='.$postid.'</a></p>';
			$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html);
		}
		
		$this->session->set_flashdata('success1','Milestone request has been deleted successfully.');
		redirect('payments/?post_id='.$postid);
	}

	public function job_a_post() {
		
		//echo '<pre>'; print_r($_FILES); print_r($_POST);
		
		$description = strtolower($this->input->post('description'));
		
		$is_block = true;
		
		foreach ($this->words as $url) {
			if (strpos($description, $url) !== FALSE) {
				$is_block = false; 
				break;
			}
		}
		
		if($is_block){
			
			$get_commision=$this->common_model->get_commision(); 
			$closed_date=$get_commision[0]['closed_date'];
			$c_date = date('Y-m-d H:i:s');
			
			$job_end_date= date('Y-m-d H:i:s', strtotime($c_date. ' + '.$closed_date.' days'));
		
			$account_type=$this->input->post('account');
			$length_of_string=12;
			$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'.time();
			$project_id=substr(str_shuffle($str_result),0, $length_of_string);
			
			$post_code1 = $this->input->post('post_code');
			$check_postcode = $this->common_model->check_postalcode($post_code1);

			// if($check_postcode['status']==1)
			 // {		
			$longitude = $check_postcode['longitude'];
			$latitude  = $check_postcode['latitude'];
			$primary_care_trust  = $check_postcode['primary_care_trust'];
			$address  = $check_postcode['address'];
			$country  = $check_postcode['country'];
			
			if($account_type==1)
			{
				$this->form_validation->set_rules('f_name','First Name','required');
				$this->form_validation->set_rules('l_name','Last Name','required');
				$this->form_validation->set_rules('phone_no','Phone number','required|integer|is_unique[users.phone_no]',array('is_unique'=>'This phone number is already registered'));
				$this->form_validation->set_rules('email1','Email','required|valid_email|is_unique[users.email]',array('is_unique'=>'This email is already registered'));
				$this->form_validation->set_rules('password1','Password','required|min_length[6]');
				$this->form_validation->set_rules('checkboxes','Terms and Conditions','required');
				//$this->form_validation->set_rules('country_code','Country code','required');
				//$this->form_validation->set_rules('e_address','Address','required');
				//$this->form_validation->set_rules('country','Country','required');
				//$this->form_validation->set_rules('locality','City','required');

				if($this->form_validation->run()==false){
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
				} else {
					$insert['type'] = 2;
					$insert['f_name'] = $this->input->post('f_name');
					$insert['l_name'] = $this->input->post('l_name');
					$insert['phone_no'] = $this->input->post('phone_no');
					$insert['email'] = $this->input->post('email1');
					$insert['password']=$this->input->post('password1');		
					//$insert['e_address'] = $this->input->post('e_address');
					//$insert['country_code'] = $this->input->post('country_code');
					//$insert['county'] = $this->input->post('country');
					//$insert['city'] = $this->input->post('locality');
					$insert['county'] = $country;
					$insert['city'] = $primary_care_trust;
					$insert['postal_code'] = $this->input->post('post_code');
					$insert['u_token'] = md5(rand(1000,9999).time());
					$insert['cdate']=date('Y-m-d H:i:s');
				
					$run = $this->common_model->insert('users',$insert);	
					if($run){


						$referred_by = $this->session->userdata('referred_by');
					// $referred_type = $this->input->post('referred_type');
					if($referred_by){
						
						$referred_link = $this->session->userdata('referred_link');

						$users = $this->db->where('id', $referred_by)->get('users')->row();
						$referal_data = array(
							'user_id'=> $run,
							'user_type'=> 2,
							'referred_by'=> $referred_by,
							'referred_type'=> $users->type,
							'referred_link'=> $referred_link
						);
						$this->db->insert('referrals_earn_list',$referal_data);
					}
						
						$time = time();
						$degit = substr($time,-5);
						
						$this->common_model->update('users',array('id'=>$run),array('unique_id'=>$run.$degit));
						
						
						$this->session->set_userdata('user_logIn',true);
						$this->session->set_userdata('user_id',$run);
						$this->session->set_userdata('type',$insert['type']);
						$this->session->set_userdata('email',$insert['email']);
						$get_name=$insert['f_name'].' '.$insert['l_name'];
						$this->session->set_userdata('u_name',$get_name);

						// $subject = Project.": Registration!";
						$subject = "Verify your Email Address - Tradespeoplehub.co.uk";
						$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7"><b>Please verify your email address.</b></p>';
						$contant .= '<p style="margin:0;padding:10px 0px">Thanks for creating an account with Tradespeople Hub! To finish your registration, please verify your email address by clicking the button below.</p>';
						$contant .= '<div style="text-align:center"><a href="'.site_url().'email-verified/'.$run.'/'.$insert['u_token'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify Email Address</a></div>';
						$contant .= '<p style="margin:0;padding:10px 0px">View our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

						// $contant.='<p class="text-center">Congratulations! This is an email to informed you that your account has been created successfully. Please click below to verify your email.</p>';
						// $contant.='<p>Please <a href="'.site_url().'email-verified/'.$run.'/'.$insert['u_token'].'">Click Here</a></p>'; 

						$json['sf'] = $this->common_model->send_mail($this->session->userdata('email'),$subject,$contant);

						$json['msg']=$this->session->set_flashdata('msg','<div class="alert alert-success">Your registration has been done successfully, We have sent verification link to your email!</div>');
						
						$budget = $this->input->post('budget');
						$budget2 = $this->input->post('static_amount2');
						
						if($budget=='Custom'){
							$budget = $this->input->post('custom_budget');
							$budget2 = $this->input->post('custom_budget2');
						} else if(!$budget){
							$budget = 0;
							$budget2 = 0;
						}
						
						
						
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
						
						$insert1['subcategory_1'] = $comma_cate;
						
						$insert1['category'] = $this->input->post('category');
						$insert1['subcategory'] = $subcategory;
						$insert1['description'] = $this->input->post('description');
						$insert1['title'] = $this->input->post('title');
						$insert1['budget'] = $budget;		
						$insert1['budget2'] = $budget2;		
						$insert1['userid'] = $run;
						$insert1['status'] = 1;
						$insert1['c_date']=date('Y-m-d H:i:s');
						$insert1['post_code']=$this->input->post('post_code');
						$insert1['project_id']=$project_id;
						$insert1['job_end_date']=$job_end_date;
						$run1 = $this->common_model->insert('tbl_jobs',$insert1);
						
						

						//$cpt = count($_FILES['post_doc']['name']);
						//$types=$_FILES['post_doc']['type'];
						//$type= substr($types[0], 0, strpos($types[0], "/"));
						/*if(count($_FILES['post_doc'])>0)
						{
							for ($i = 0; $i < $cpt; $i ++) {

								if($_FILES['post_doc']['name'])
								{
									$ext=end(explode(".",$_FILES['post_doc']['name'][$i]));
									$files=rand(10,1000).time().".".$ext;
									if(move_uploaded_file($_FILES['post_doc']['tmp_name'][$i],'img/jobs/'.$files))
									{
										$insert2['post_doc']=$files;
										$insert2['userid']=$run;
										$insert2['type']='image';
										$insert2['job_id']=$run1;
										$run1 = $this->common_model->insert('job_files',$insert2);
									}
								}
							}
						}*/

						if(isset($_POST['post_doc']) && count($_POST['post_doc']) > 0){
							foreach($_POST['post_doc'] as $key11 => $value11){
								
								/*$data1 = $value11;
								list($type, $data1) = explode(';', $data1);
								list(, $data1)      = explode(',', $data1);
								$data1 = base64_decode($data1);
								$files = rand(10000,99999).time().'.png';
							
								$path = 'img/jobs/'.$files;*/
								
								$insert2['post_doc']=$value11;
								$insert2['userid']=$run;
								$insert2['type']='image';
								$insert2['job_id']=$run1;
								$run1 = $this->common_model->insert('job_files',$insert2);
								
								//file_put_contents($path, $data1);
								
							}
						}
						$json['status'] = 1;
						$json['job_id']=$run1;
						$this->session->set_flashdata('success2', '<p class="alert alert-success">Thank you for posting your job, our vetted professionals will quote soon.</p>');
					} else {
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger">Something went wrong please try again later.</div>';
					}

				}
			}
			else if($account_type==2)
			{
				$this->form_validation->set_rules("email","Email address","required|valid_email");
				$this->form_validation->set_rules("password","Password", "required");

				if ($this->form_validation->run()==false) 
				{
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
				} else {
					$u_password = $this->input->post("password");
					$u_email = $this->input->post("email");
				
					$data = $this->common_model->get_single_data('users',array('email'=>$u_email,'password'=>$u_password,'type'=>2));

					if($data)
					{
						if($data['status']==1)
						{
							$json['status'] = 0;
							$json['msg'] = '<div class="alert alert-danger">Your account is blocked by Super Admin!</div>';
						
						} else {
							$this->session->set_userdata('user_logIn',true);
							$this->session->set_userdata('type',$data['type']);
							$this->session->set_userdata('user_id',$data['id']);
							$this->session->set_userdata('email',$data['email']);
							$get_name=$data['f_name'].' '.$data['l_name'];
							$this->session->set_userdata('u_name',$get_name);
							
						
							$budget = $this->input->post('budget');
							$budget2 = $this->input->post('static_amount2');
							
							if($budget=='Custom'){
								$budget = $this->input->post('custom_budget');
								$budget2 = $this->input->post('custom_budget2');
							} else if(!$budget){
								$budget = 0;
								$budget2 = 0;
							}
							
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
							
							$insert3['subcategory_1'] = $comma_cate;
						
							$insert3['category'] = $this->input->post('category');
							$insert3['subcategory'] = $subcategory;
							$insert3['description'] = $this->input->post('description');
							$insert3['title'] = $this->input->post('title');
							$insert3['budget']=$budget;		
							$insert3['budget2']=$budget2;		
							$insert3['userid'] = $data['id'];
							$insert3['status'] = 1;
							$insert3['c_date']=date('Y-m-d H:i:s');
							$insert3['post_code']=$this->input->post('post_code');
							$insert3['project_id']=$project_id;
							$insert3['job_end_date']=$job_end_date;
							$run3 = $this->common_model->insert('tbl_jobs',$insert3);

							//$cpt = count($_FILES['post_doc']['name']);
							//$types=$_FILES['post_doc']['type'];
							//$type= substr($types[0], 0, strpos($types[0], "/"));
							/*if(count($_FILES['post_doc'])>0)
							{
								for ($i = 0; $i < $cpt; $i ++) {

									if($_FILES['post_doc']['name'])
									{
										$ext=end(explode(".",$_FILES['post_doc']['name'][$i]));
										$files=rand(10,1000).time().".".$ext;
										if(move_uploaded_file($_FILES['post_doc']['tmp_name'][$i],'img/jobs/'.$files))
										{
											$insert4['post_doc']=$files;
											$insert4['job_id']=$run3;
											$insert4['userid']=$data['id'];
											$insert4['type']=$type;
											$run4 = $this->common_model->insert('job_files',$insert4);
										}
									}
								}
							} */
							
							if(isset($_POST['post_doc']) && count($_POST['post_doc']) > 0){
								foreach($_POST['post_doc'] as $key11 => $value11){
									/*$data1 = $value11;
									list($type, $data1) = explode(';', $data1);
									list(, $data1)      = explode(',', $data1);
									$data1 = base64_decode($data1);
									$files = rand(10000,99999).time().'.png';
								
									$path = 'img/jobs/'.$files;*/
									
									$insert4['post_doc']=$value11;
									$insert4['job_id']=$run3;
									$insert4['userid']=$data['id'];
									$insert4['type']='image';
									$run1 = $this->common_model->insert('job_files',$insert4);
									
									//file_put_contents($path, $data1);
									
								}
							}

							$json['status'] = 1;
							$json['job_id']=$run3;
							$this->session->set_flashdata('success2', '<p class="alert alert-success">Thank you for posting your job, our vetted professionals will quote soon.</p>');
							$json['user_id']=$this->session->set_userdata('user_id',$data['id']);

						}
					
					}
					else
					{
						$json['status'] = 0;
						$json['msg'] = '<div class="alert alert-danger">Username or password invalid!</div>';
					}
			
				}
		
			}
			else
			{
				
				$budget = $this->input->post('budget');
				$budget2 = $this->input->post('static_amount2');
				
				if($budget=='Custom'){
					$budget = $this->input->post('custom_budget');
					$budget2 = $this->input->post('custom_budget2');
				} else if(!$budget){
					$budget = 0;
					$budget2 = 0;
				}
				
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
				
				$insert5['subcategory_1'] = $comma_cate;
				$insert5['category'] = $this->input->post('category');
				$insert5['subcategory'] = $subcategory;
				$insert5['description'] = $this->input->post('description');
				$insert5['title'] = $this->input->post('title');
				$insert5['budget'] = $budget;		
				$insert5['budget2'] = $budget2;		
				$insert5['userid'] = $this->session->userdata('user_id');
				$insert5['status'] = 1;
				$insert5['c_date']=date('Y-m-d H:i:s');
				$insert5['post_code']=$this->input->post('post_code');
				$insert5['project_id']=$project_id;
				$insert5['job_end_date']=$job_end_date;
				
				$run5 = $this->common_model->insert('tbl_jobs',$insert5);	

				
				/*$cpt = count($_FILES['post_doc']['name']);
				$types=$_FILES['post_doc']['type'];
				$type= substr($types[0], 0, strpos($types[0], "/"));
				if(count($_FILES['post_doc'])>0)
				{
					for ($i = 0; $i < $cpt; $i ++) {

						if($_FILES['post_doc']['name'])
						{
							$ext=end(explode(".",$_FILES['post_doc']['name'][$i]));
							$files=rand(10,1000).time().".".$ext;
							if(move_uploaded_file($_FILES['post_doc']['tmp_name'][$i],'img/jobs/'.$files))
							{
								$insert6['post_doc']=$files;
								$insert6['job_id']=$run5;
								$insert6['type']=$type;
								$insert6['userid']= $this->session->userdata('user_id');
								$run4 = $this->common_model->insert('job_files',$insert6);
							}
						}

					}

				}*/
				
				if(isset($_POST['post_doc']) && count($_POST['post_doc']) > 0){
								foreach($_POST['post_doc'] as $key11 => $value11){
									/*$data1 = $value11;
									list($type, $data1) = explode(';', $data1);
									list(, $data1)      = explode(',', $data1);
									$data1 = base64_decode($data1);
									$files = rand(10000,99999).time().'.png';
								
									$path = 'img/jobs/'.$files;*/
									
									$insert6['post_doc']=$value11;
									$insert6['job_id']=$run5;
									$insert6['type']='image';
									$insert6['userid']= $this->session->userdata('user_id');
									$run1 = $this->common_model->insert('job_files',$insert6);
									
									//file_put_contents($path, $data1);
									
								}
							}

				
				$this->session->set_flashdata('success2', '<p class="alert alert-success">Thank you for posting your job, our vetted professionals will quote soon.</p>');
				$json['status'] = 1;
				$json['job_id']=$run5;

			}
			
			if($json['status']==1){
				$user_id = $this->session->userdata('user_id');
				$title = $this->input->post('title');
				$budget = $this->input->post('budget');
				$description = $this->input->post('description');
				$insertn = array(); 
				$insertn['nt_userId']=$user_id;
				// $insertn['nt_message']= '<a href="'.site_url().'details/?post_id='.$json['job_id'].'">'.$title.'</a> job has has been posted successfully.';
				$insertn['nt_message'] = 'Your job has been posted successfully. <a href="'.site_url().'proposals/?post_id='.$json['job_id'].'">View Quotes!</a>';
				$insertn['nt_satus']=0; 
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$json['job_id'];
				$run2 = $this->common_model->insert('notification',$insertn);
				
				$category = $this->input->post('category');

				/* Email confirmation to homeowner */
				$subjectToHomeOwner = 'Congratulations! Your job was posted successfully!';
				$contentToHomeOwner = '<p style="margin:0;padding:10px 0px">Hi ' .$this->session->userdata('u_name') .',</p>';
				$contentToHomeOwner .= '<p style="margin:0;padding:10px 0px">Your job “' .$title .'” was successfully posted on Tradespeoplehub.co.uk. You will start receiving quotes from our vetted tradespeople near you soon.</p>';
				$contentToHomeOwner .= '<div style="text-align:center"><a href="'.site_url('proposals?post_id=' .$insertn['job_id']) .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Quotes</a></div>';
				$contentToHomeOwner .= '<p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($this->session->userdata('email'), $subjectToHomeOwner, $contentToHomeOwner);
				/* Email confirmation to homeowner */

				$post_code1 = $this->input->post('post_code');
				$check_postcode = $this->common_model->check_postalcode($post_code1);

				// if($check_postcode['status']==1)
				 // {		
				$longitude = $check_postcode['longitude'];
				$latitude  = $check_postcode['latitude'];
				$primary_care_trust  = $check_postcode['primary_care_trust'];
				$address  = $check_postcode['address'];
				$country  = $check_postcode['country'];

				//}

				$this->common_model->update('tbl_jobs',array('job_id'=>$json['job_id']),array('latitude'=>$latitude,'longitude'=>$longitude,'city'=>$primary_care_trust,'address'=>$address,'country'=>$country));
				//$trades = $this->common_model->GetColumnName('users',"id = 11",array('phone_no','id','f_name','email'),true);

				 $sql = "select *, 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$latitude.")) * COS(RADIANS(users.latitude)) * COS(RADIANS(".$longitude." - users.longitude)) + SIN(RADIANS(".$latitude.")) * SIN(RADIANS(users.latitude))))) AS distance_in_km from users where users.type=1 and users.u_email_verify=1 and users.notification_status = 1 HAVING distance_in_km <= users.max_distance";				 

				 $run = $this->db->query($sql);

				//$trades = $this->common_model->GetColumnName('users',"type = 1 and u_email_verify = 1 and notification_status = 1 and (FIND_IN_SET($category,category) != 0 or postal_code = '".$post_code1."' or postal_code = '".$post_code2."')",array('phone_no','id','f_name','email'),true);
				
				if($run->num_rows() > 0){
					
					$trades = $run->result_array();
					//print_r($trades);	die; 		
					$this->load->model('send_sms');

					$userdataaa = $this->common_model->GetColumnName('users',array("id"=>$user_id),array('f_name','l_name','city'));
					
					$cateName = $this->common_model->GetColumnName('category',array("cat_id"=>$category),array('cat_name'));
					
					$link = site_url()."details?post_id=".$json['job_id'];
					
					$respSL = file_get_contents('https://cutt.ly/api/api.php?key=69d958cf7b30dd3bef9485886a1d820bdcd57&short='.$link);

					$respSLJ = json_decode($respSL);
					
					$shortLink = $respSLJ->url->shortLink;
					
					$sms = $userdataaa['f_name']." ".$userdataaa['l_name']." posted a new job. View & Quote now! \r\n".$shortLink."\r\n\r\nTradespeoplehub.co.uk";
					
					foreach($trades as $key => $value){
						
						$insertn = array(); 
						$insertn['nt_userId']=$value['id'];
						$insertn['nt_message']= $userdataaa['f_name'].' '.$userdataaa['l_name'].' posted a new job. <a href="'.site_url().'details/?post_id='.$json['job_id'].'">View & Quote now!</a>';
						$insertn['nt_satus']=0;
						$insertn['nt_create']=date('Y-m-d H:i:s');
						$insertn['nt_update']=date('Y-m-d H:i:s');
						$insertn['job_id']=$json['job_id'];
						$run2 = $this->common_model->insert('notification',$insertn);
						
						$today_sms = $this->common_model->get_data_count('daily_sms_records',array('date'=>date('Y-m-d'),'user_id'=>$value['id']),'id');
						
						if($today_sms <= 0){
							$has_sms_noti = $this->common_model->check_sms_notification($value['id']);
							
							if($has_sms_noti){
								
								//$delivered = $this->send_sms->send_india($has_sms_noti['phone_no'],$sms);
								$delivered = $this->send_sms->send($has_sms_noti['phone_no'],$sms);
								if($delivered){
									
									$this->common_model->update('user_plans',array('up_user'=>$value['id']),array('used_sms_notification'=>$has_sms_noti['used_sms_notification']));
									
									$this->common_model->insert('daily_sms_records',array('user_id'=>$value['id'],'date'=>date('Y-m-d')));
								}
							}
						}
						
					}
				}
			}
		} else {
			$json['status'] = 3;
			$json['msg'] = '<div class="alert alert-danger">Username or password invalid!</div>';
		}
		echo json_encode($json);

	}
	
	public function approve_post($uid,$status) {
		$userdata['status']=$status;
		$where_array=array('job_id'=>$uid);
		$result=$this->common_model->update('tbl_jobs',$where_array,$userdata); 
		redirect('my-posts');
	}
	
	public function accept_post($uid,$status,$amount,$check_create_ms){
		// echo '<pre>'; print_r($_REQUEST); echo '</pre>'; die;
		$user_id = $this->session->userdata('user_id');
		
		$user = $this->common_model->get_userDataByid($user_id); 
		
		$get_jobs=$this->common_model->get_jobs_bid($uid);
		
		$get_users=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['bid_by']));
		
		//print_r($get_jobs); die;
		
		$check = true;
		
		$check_balance = false;
		
		if($check_create_ms==1 && $user['u_wallet'] < $amount){
			$check = false;
		}
		
		
		if($check) {
			
			$get_job_details=$this->common_model->get_job_details($get_jobs[0]['job_id']);
			
			$where_array=array('id'=>$uid);
			
			$userdata['status']=$status;
			
			$userdata['awarded_date']=date('Y-m-d H:i:s');
			
			if($check_create_ms==1){
				$userdata['total_milestone_amount']=$amount;
			}
			
			$result=$this->common_model->update('tbl_jobpost_bids',$where_array,$userdata); 
			
			$get_jobs=$this->common_model->get_jobs_bid($uid);
			
			$update['awarded_to']=$get_jobs[0]['bid_by'];
			$update['status']=4;
			$update['awarded_time'] = date('Y-m-d H:i:s');
			
			$where_array1=array('job_id'=>$get_jobs[0]['job_id']);
			$results=$this->common_model->update('tbl_jobs',$where_array1,$update);
				
			$has_email_noti = $this->common_model->check_email_notification($get_jobs[0]['bid_by']);
						
			if($has_email_noti){
				
				if($check_create_ms==1){
				
					$subject = "Congratulations! ".$user['f_name']." Awarded “".$get_job_details[0]['title']."” and awaits your acceptance";
					
					$html = '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$user['f_name'].' has awarded you the job “'.$get_job_details[0]['title'].'” with milestone payment, after accepting your quote. </p>';
					$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept the job by clicking the accept button below.</p>';
				
					$html .= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$get_jobs[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept Job Now</a></div>';
					
					$html .= '<p style="margin:0;padding:10px 0px">If you have any question regarding the offer, don\'t hesitate to contact '.$user['f_name'].' through the chat section of the job page</p>';
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					
				} else { 
				
					$subject = "Congratulations! ".$user['f_name']." Awarded “".$get_job_details[0]['title']."” and awaits your acceptance";
					
					$html = '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$user['f_name'].' has awarded you the job '.$get_job_details[0]['title'].' without milestone payment, after accepting your quote.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can accept the job by clicking the accept button below.</p>';
				
					$html .= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$get_jobs[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept Job Now</a></div>';
					
					$html .= '<br><p style="margin:0;padding:10px 0px">If you have any question regarding the offer, don\'t hesitate to contact '.$user['f_name'].' through the chat section of the job page</p>';
					$html .= '<p style="margin:0;padding:10px 0px">What\'s a  Milestone Payment? </p>';
					$html .= '<p style="margin:0;padding:10px 0px">The Milestone Payment System is the recommended set of payment on our platform. Creating a milestone payment shows that your homeowner is committed and financially capable of completing the project.</p>';
					
					$html .= '<div style="text-align:center"><a href="'.site_url().'proposals/?post_id='.$get_jobs[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request Milestone Payment</a></div>';
					
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
				}
				
				$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html);
			}
			
			
			$subjectH = "Thanks for awarding your job “".$get_job_details[0]['title']."” to ".$get_users['trading_name'].".";
				
			$htmlH = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].' '.$user['l_name'].',</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">Thank you for awarding '.$get_users['trading_name'].' your job “'.$get_job_details[0]['title'].'”</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">As your next step, you can wait for '.$get_users['trading_name'].' to accept or reject the offer.</p>';
			
			
			$htmlH .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($user['email'],$subjectH,$htmlH);
			
			
			$insertn['nt_userId']=$get_jobs[0]['bid_by'];
			
			$insertn['nt_message']='Congratulations! ' .$user['f_name'].' '.$user['l_name'] .' offered you the job. <a href="'.site_url().'proposals/?post_id='.$get_jobs[0]['job_id'].'">Accept now</a>';
			$insertn['nt_satus']=0;
			$insertn['nt_apstatus']=2;
			$insertn['nt_create']=date('Y-m-d H:i:s');
			$insertn['nt_update']=date('Y-m-d H:i:s');   
			$insertn['job_id']=$get_jobs[0]['job_id'];
			$insertn['posted_by']=$get_jobs[0]['posted_by'];
			$run2 = $this->common_model->insert('notification',$insertn);
			
			if($result)
			{
				if($check_create_ms==1){
					
					$remaining_amount = $amount;
					
					$get_user_suggest = $this->common_model->get_all_data('tbl_milestones',array('bid_id'=>$get_jobs[0]['id']),'milestone_amount');
					
					if(count($get_user_suggest) > 0){
						foreach ($get_user_suggest as $key => $value){
							
							if($remaining_amount >= $value['milestone_amount']){
								
								$this->common_model->update('tbl_milestones',array('id'=>$value['id']),array('created_by'=>$user_id));
								
								$remaining_amount = $remaining_amount-$value['milestone_amount'];
								
							} else {
								
								if($remaining_amount > 0){
								
									$data = array(
										'milestone_name'=>'First milestone', 
										'milestone_amount'=>$remaining_amount,
										'userid'=>$get_jobs[0]['bid_by'],
										'post_id'=>$get_jobs[0]['job_id'],
										'cdate' =>date('Y-m-d H:i:s'),
										'posted_user'=>$get_jobs[0]['posted_by'],   
										'bid_id'=>$get_jobs[0]['id'],   
										'created_by'=>$user_id
									);
									
									$this->common_model->insert('tbl_milestones',$data);
									
									$remaining_amount = 0;
								
								}
								break;
							}
							
						}
						
						if($remaining_amount > 0){
							$data = array(
								'milestone_name'=>'First milestone', 
								'milestone_amount'=>$remaining_amount,
								'userid'=>$get_jobs[0]['bid_by'],
								'post_id'=>$get_jobs[0]['job_id'],
								'cdate' =>date('Y-m-d H:i:s'),
								'posted_user'=>$get_jobs[0]['posted_by'],   
								'bid_id'=>$get_jobs[0]['id'],   
								'created_by'=>$user_id
							);
								
							$this->common_model->insert('tbl_milestones',$data);
						}
						
						
					} else {
						$data = array(
							'milestone_name'=>'First milestone', 
							'milestone_amount'=>$amount,
							'userid'=>$get_jobs[0]['bid_by'],
							'post_id'=>$get_jobs[0]['job_id'],
							'cdate' =>date('Y-m-d H:i:s'),
							'posted_user'=>$get_jobs[0]['posted_by'],   
							'bid_id'=>$get_jobs[0]['id'],   
							'created_by'=>$this->session->userdata('user_id')
						);
						
						$this->common_model->insert('tbl_milestones',$data);
					
					}
					
					$update12['u_wallet']=$user['u_wallet']-$amount;
					$update12['spend_amount']=$user['spend_amount']+$amount;
						
					$this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$update12);
				
					$transactionid = md5(rand(1000,999).time());
				
					$tr_message='£'.$amount.' has been debited from your wallet for create master the job <a href="'.site_url().'proposals/?post_id='.$get_jobs[0]['job_id'].'">'.$get_job_details[0]['title'].'</a> on date '.date('d-m-Y h:i:s A');
				
					$data1 = array(
						'tr_userid'=>$this->session->userdata('user_id'), 
						'tr_amount'=>$amount,
						'tr_type'=>2,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
					);
			 
					$run1 = $this->common_model->insert('transactions',$data1);
					
				} 
				
				$json['status'] = 1;
					$this->session->set_flashdata('success1', '<p class="alert alert-success">Success! Project has been awarded successfully.</p>');
			}
			else
			{
				$json['status'] = 0;
			}
		} else {
			$json['wallet'] = $user['u_wallet'];
			$json['amount'] = $amount-$user['u_wallet'];
			$json['status'] = 2;
		}
		echo json_encode($json);

	}
	
	public function mark_completed($id) {

	 $userid=$this->input->post('posted_by');
	 $bid_by=$this->input->post('bid_by');
	 if($this->session->userdata('user_id')==$userid)
	 {
	 	$userid1=$userid;
	 	$bid_by1=$bid_by;
	 }
	 else
	 {
	 	$userid1=$bid_by;
	 	$bid_by1=$userid;
	 }
	

	 $rt_rate=$this->input->post('rt_rate');
	 $rt_comment=$this->input->post('rt_comment');
	 $data = array(
   					  'rt_rateBy'=>$userid1, 
    				  'rt_rateTo'=>$bid_by1,
    				  'rt_jobid'=>$id,
    				  'rt_rate'=> $rt_rate,
    				  'rt_comment'=> $rt_comment,
    				  'rt_create' =>date('Y-m-d H:i:s')
   					  );
					 $run1 = $this->common_model->insert('rating_table',$data);
					 if($run1)
					 {
					 	 $json['status'] = 1;
					 	 	$this->session->set_flashdata('success1', 'Success! Rating has been submitted successfully.');
					 }
					 else
					 {
					 		$json['status'] = 0;
					 		$this->session->set_flashdata('error1', 'Something went wrong.Please try again later.');

					 }

		//$userdata['status']=4;
			//$where_array=array('id'=>$id);
		//$result=$this->common_model->update('tbl_jobpost_bids',$where_array,$userdata); 
		$get_avg_rating=$this->common_model->get_avg_rating($bid_by1);
		$avg= $get_avg_rating[0]['avg'];
		$get_user=$this->common_model->get_single_data('users',array('id'=>$bid_by1));
		$review=$get_user['total_reviews'];
		$update2['average_rate']=$avg;
		$update2['total_reviews']=$review+1;
		$runss1 = $this->common_model->update('users',array('id'=>$bid_by1),$update2);
		echo json_encode($json);
	}
	
	public function reviews(){
		if($this->session->userdata('user_id'))
		{
			$data['reviews']=$this->common_model->get_home_feed($this->session->userdata('user_id'),$_REQUEST['post_id']);
	
		$this->load->view('site/reviews',$data);
		}
		else
		{
			//echo '<pre>'; print_r($_SERVER);
			redirect('login?redirectUrl='.base64_encode(site_url().'reviews?'.$_SERVER['QUERY_STRING']));
		}

		
	}
	
	public function getRating(){
		$post_id=$_REQUEST['job_id'];
		$get_rating=$this->common_model->get_all_rating($post_id);
		$json['data'] = '<div class="onnnnn_1" id="">';
		if($get_rating){
		foreach ($get_rating as $r) {
		 $RateUser = $this->common_model->get_single_data('users',array('id'=>$r['rt_rateBy']));
		$RateUser['username']=$RateUser['f_name'].' '.$RateUser['l_name'];
		$json['data'] .= '<h3>Rating given by: '.$RateUser['username'].' </h3>';
		 $json['data'] .= '<p>
                <span class="pro-star">';
            
                for($i=1; $i<=5; $i++) {
                  if($i <= $r['rt_rate']) {
                    $json['data'] .= '<i class="fa fa-star"></i>';
                  } else {
                    $json['data'] .= '<i class="fa fa-star-o"></i>';
                  }
                }
                $json['data'] .= '</span>
            </p>
            <p><b>Feedback:</b> '.$r['rt_comment'].'</p><hr>';
		}
	}else
	{
		$json['data'] .= '<div class="alert alert-warning">No record found...</div>';
	}
	 $json['data'] .= '</div>';
  echo json_encode($json);
		
	}

	public function accept_award123($uid,$status) {
		
		$user_id = $this->session->userdata('user_id');
		
		$get_jobs=$this->common_model->get_jobs_bid($uid);
		
		$get_users=$this->common_model->get_single_data('users',array('id'=>$user_id));
		
		$get_commision=$this->common_model->get_commision();
						
		$credit_amount=$get_commision[0]['credit_amount'];
		
		$get_plan_bids=$this->common_model->get_single_data('user_plans',array('up_user'=>$user_id,'up_status'=>1),'up_id');

		$get_chat_paid=$this->common_model->get_single_data('chat_paid',array('user_id'=>$this->session->userdata('user_id'),'post_id'=>$get_jobs[0]['job_id']));
		
		$check = false;
		$plan=false;
		$wallet=false;
		$chat_paid=false;
		$setting = $this->common_model->get_all_data('admin');

		if($setting[0]['payment_method'] == 1){		
			if($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1){
				$plan = true;
				$check = true;
			} else if($get_chat_paid){
				$chat_paid = true;
				$check = true;
			} else if($get_users['u_wallet'] >= $credit_amount){
				$wallet = true;
				$check = true;
			}
		}else{
			$check = true;
		}
		
		if($check){
			
			$userdata['status']=$status;
			$userdata['update_date']=date('Y-m-d H:i:s');
			$where_array=array('id'=>$uid);
			
			$result=$this->common_model->update('tbl_jobpost_bids',$where_array,$userdata); 
			
			$get_posted_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['posted_by']));
			
			$get_job_details=$this->common_model->get_job_details($get_jobs[0]['job_id']);

			$insertn['nt_userId']=$get_jobs[0]['posted_by'];
			// $insertn['nt_message'] = 'Your offer has been accepted by <a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> for <a href="'.site_url().'details/?post_id='.$get_jobs[0]['job_id'].'">'.$get_job_details[0]['title'].'</a>.Please <a href="'.site_url().'payments/?post_id='.$get_jobs[0]['job_id'].'"> create a milestone</a>.';
			$insertn['nt_message'] = $get_users['trading_name'] .' accepted your <a href="'.site_url().'details/?post_id='.$get_jobs[0]['job_id'].'">direct job offer.</a>';
				
			$insertn['nt_satus']=0;
			$insertn['nt_apstatus']=2;
			$insertn['nt_create']=date('Y-m-d H:i:s');
			$insertn['nt_update']=date('Y-m-d H:i:s');
			$insertn['job_id']=$get_jobs[0]['job_id'];
			$insertn['posted_by']=$get_jobs[0]['bid_by'];
			$run2 = $this->common_model->insert('notification',$insertn);
			
			

			$subjectH = "Congratulations! ".$get_users['trading_name']." has accepted your direct job offer.";
				
			$htmlH = '<p style="margin:0;padding:10px 0px">Hi '.$get_posted_user['f_name'].',</p>';
			
			$htmlH .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$get_users['trading_name'].' has accepted your direct job offer!</p>';
			
			$htmlH .= '<p style="margin:0;padding:10px 0px">As your next step, you can create Milestone Payments if you have not yet created one.</p>';
			
			$htmlH .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_jobs[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create a Milestone Payment</a></div><br>';
			
			$htmlH .= '<p style="margin:0;padding:10px 0px">What\'s a Milestone Payment?</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">It is our safe payment system! Using them, you break-down payments for your job. Funds do not get released until the tradesperson completes the agreed task and you choose to release them.</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">Additionally, in the unlikely event that something does go wrong, you can use our Dispute Resolution System to get your money back, but only if you use Milestone Payments.</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">Never make a payment off-site, always use Milestone Payments!<br>We cannot protect you if you make payments directly to the tradespeople.</p>';
			$htmlH .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($get_posted_user['email'],$subjectH,$htmlH);
			
		
			$update['status']=7;
			
			$where_array1=array('job_id'=>$get_jobs[0]['job_id']);
			$results=$this->common_model->update('tbl_jobs',$where_array1,$update); 
			
			$json['status'] = 1;

			
			
			if($wallet){
				$update['u_wallet']=$get_users['u_wallet']-$credit_amount;
							
				$runs = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$update);
					
				$get_post_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['userid']));
				
				$transactionid = md5(rand(1000,999).time());
				
				$tr_message='£'.$credit_amount.' has been debited from your wallet for accept award on <a href="'.site_url().'proposals/?post_id='.$job_id.'">'.$get_jobs[0]['title'].'</a> on date '.date('d-m-Y h:i:s A');
				
				$data112 = array(
					'tr_userid'=>$this->session->userdata('user_id'), 
					'tr_amount'=>$credit_amount,
					'tr_type'=>2,
					'tr_transactionId'=>$transactionid,
					'tr_message'=>$tr_message,
					'tr_status'=>1,
					'tr_created'=>date('Y-m-d H:i:s'),
					'tr_update' =>date('Y-m-d H:i:s')
				);
				
				$run1 = $this->common_model->insert('transactions',$data112);
			}
			
			if($plan){
						
				$update12['up_used_bid']=$get_plan_bids['up_used_bid']+1;
				$runs = $this->common_model->update('user_plans',array('up_id'=>$get_plan_bids['up_id']),$update12);
				
			}
			
			$this->session->set_flashdata('success1123','<p class="alert alert-success">Success! Proposal has been accepted successfully.</p>');
			
			//$this->session->set_flashdata('success1','<p class="alert alert-success">Success! Proposal has been accepted successfully.</p>');
		} else {
			$json['status'] = 0;
			$json['wallet'] = $get_users['u_wallet'];
			$json['msg'] = '<div class="alert alert-danger">You´re neither an active member nor have funds in your wallet to quote this job. To quote this job you need to either recharge your wallet by choosing pay as you go method or become an active member.</div>';
		}
		
		echo json_encode($json);

	}
	
	public function accept_award($uid,$status) {
		$get_jobs=$this->common_model->get_jobs_bid($uid);
		
		$userdata['status']=$status;
		$userdata['update_date']=date('Y-m-d H:i:s');
		$where_array=array('id'=>$uid);
		
		$result=$this->common_model->update('tbl_jobpost_bids',$where_array,$userdata); 
		
		$get_users=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['bid_by']));
		
		$get_posted_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['posted_by']));
		
		$get_job_details=$this->common_model->get_job_details($get_jobs[0]['job_id']);

		$insertn['nt_userId']=$get_jobs[0]['posted_by'];
		// $insertn['nt_message']='Your offer has been accepted by <a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> for <a href="'.site_url().'details/?post_id='.$get_jobs[0]['job_id'].'">'.$get_job_details[0]['title'].'</a>.Please <a href="'.site_url().'payments/?post_id='.$get_jobs[0]['job_id'].'"> create a milestone</a>.';
    	$insertn['nt_message'] = $get_users['trading_name'] .' has accepted your job offer.';
			
		$insertn['nt_satus']=0;
		$insertn['nt_apstatus']=2;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['job_id']=$get_jobs[0]['job_id'];
		$insertn['posted_by']=$get_jobs[0]['bid_by'];
		$run2 = $this->common_model->insert('notification',$insertn);

		$subjectH = "Congratulations! ".$get_users['trading_name']." has accepted your offer for the job: “".$get_job_details[0]['title']."”!";
				
		$htmlH = '<p style="margin:0;padding:10px 0px">Hi '.$get_posted_user['f_name'].',</p>';
		
		$htmlH .= '<p style="margin:0;padding:10px 0px">Congratulations! '.$get_users['trading_name'].' has accepted to begin work on your project “'.$get_job_details[0]['title'].'”!</p>';
			
		$htmlH .= '<p style="margin:0;padding:10px 0px">As your next step, you can create Milestone Payments if you have not yet created one.</p>';
			
		$htmlH .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_jobs[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create a Milestone Payment</a></div><br>';
			
		$htmlH .= '<p style="margin:0;padding:10px 0px">What\'s a Milestone Payment?</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">It is our safe payment system! Using them, you break-down payments for your job. Funds do not get released until the tradesperson completes the agreed task and you choose to release them.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Additionally, in the unlikely event that something does go wrong, you can use our Dispute Resolution System to get your money back, but only if you use Milestone Payments.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Never make a payment off-site, always use Milestone Payments! We cannot protect you if you make payments directly to the tradespeople.</p>';
		$htmlH .= '<p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
			

		$this->common_model->send_mail($get_posted_user['email'],$subjectH,$htmlH);



		$subjectH = "Job offer accepted successfully!";
		$htmlH = 'Hi '.$get_users['f_name'].',<br><br>';
		$htmlH.= 'Thank you for accepting to work with '.$get_posted_user['f_name'].' on their project “'.$get_job_details[0]['title'].'”.<br><br>';
		$htmlH.= 'As your next step, you can ask them to set up Milestone Payments if they  have not yet created one.<br><br>';
		$htmlH .= '<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_job_details[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request Milestone Creation</a></div><br>';

		$htmlH .= 'Visit our Milestone Payment system on tradespeople help page or contact our customer services if you have any specific questions using our service.<br>';
		$this->common_model->send_mail($get_users['email'],$subjectH,$htmlH);

		$update['status']=7;
		
		$where_array1=array('job_id'=>$get_jobs[0]['job_id']);
		$results=$this->common_model->update('tbl_jobs',$where_array1,$update); 
		if($result) {
			$json['status'] = 1;

			$this->session->set_flashdata('success1123','<p class="alert alert-success">Success! Proposal has been accepted successfully.</p>');
			
		} else {
			$json['status'] = 0;
			
		}
		echo json_encode($json);

	}
	
	public function delete_post($id){
			$update_array = array(
				'is_delete'=>1
		);
			$where_array=array('job_id'=>$id);
					$result=$this->common_model->update('tbl_jobs',$where_array,$update_array);    
		$result=$this->common_model->delete(array('job_id'=>$id),'job_files'); 

		if($result)
		{
			$this->session->set_flashdata('success', 'Success! Project has been deleted Successfully.');
			
		}    
		else     
		{
			$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
			
		}
		return redirect('my-posts');

	}
	
	public function accept_requested_milestone() {
		
		$this->form_validation->set_rules('post_id','Post Id','required');
		$this->form_validation->set_rules('tsm_name1','Milestone Name','required');
		$this->form_validation->set_rules('tsm_amount1','Milestone Amount','required');
		$this->form_validation->set_rules('miles_id','Milestone Id','required');
		
		if ($this->form_validation->run()==false) {
			
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
						
		}	else {
		
			$id=$this->input->post('post_id');
			
			$bid_by=$this->input->post('bid_by');
			
			$miles_id=$this->input->post('miles_id');
			
			$user_id=$this->session->userdata('user_id');
			
			$tsm_name1=$this->input->post('tsm_name1');
			$tsm_amount1=$this->input->post('tsm_amount1');
		
			$where = "id = '".$id."' and bid_by = '".$bid_by."' and (status = 7 or status = 3 or status = 5 or status = 10)";
			$get_post_data = $this->common_model->get_single_data('tbl_jobpost_bids',$where);
			
			$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_post_data['job_id']));
			
			if($get_post_data && $get_job_post){

				$mile_amount = $get_post_data['total_milestone_amount'];

				$get_users=$this->common_model->get_single_data('users',array('id'=>$user_id));
			
				$post_title=$get_job_post['title'];
				 
				$total_amt = $mile_amount+$_POST['tsm_amount1'];

				if($tsm_amount1 > $get_users['u_wallet']) {
					
					$json['status'] = 2;
					$json['amount'] = $tsm_amount1 - $get_users['u_wallet'];
					$json['msg'] = '<div class="alert alert-danger">Insufficient amount in your wallet please recharge you wallet.</div>';
					
				} else {
					
					$data = array(
						'milestone_name'=>$tsm_name1, 
						'milestone_amount'=>$tsm_amount1,
						'userid'=>$bid_by,
						'post_id'=>$get_job_post['job_id'],
						'cdate' =>date('Y-m-d H:i:s'),
						'posted_user'=>$get_post_data['posted_by'], 
						'bid_id'=>$get_post_data['id'],  						
						'created_by'=>$user_id
					);
					
					
					$run1 = $this->common_model->insert('tbl_milestones',$data);
					
					$total_amt=$mile_amount+$tsm_amount1;
					
					$update1['total_milestone_amount']=$total_amt;
					
					$this->common_model->update('tbl_jobpost_bids',array('id'=>$id),$update1);
					
					$update12['u_wallet']=$get_users['u_wallet']-$tsm_amount1;
					$update12['spend_amount']=$get_users['spend_amount']+$tsm_amount1;
							
					$this->common_model->update('users',array('id'=>$user_id),$update12);
					
					$transactionid = md5(rand(1000,999).time());
					
					$tr_message='£'.$tsm_amount1.' has been debited from your wallet for accept a milestone for the job <a href="'.site_url().'proposals/?post_id='.$get_job_post['job_id'].'">'.$get_job_post['title'].'</a> on date '.date('d-m-Y h:i:s A');
					
					$data1 = array(
						'tr_userid'=>$user_id, 
						'tr_amount'=>$tsm_amount1,
						'tr_type'=>2,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
					);
				 
					$this->common_model->insert('transactions',$data1);
					
					$has_email_noti1 = $this->common_model->check_email_notification($bid_by);
						
					if($has_email_noti1){
						
						$subject = "Milestone Payment Made for “".$post_title."”";
					
						$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone Payment Made Successfully!</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti1['f_name'].'!</p>';
						$html .= '<p style="margin:0;padding:10px 0px">'.$get_users['f_name'].' '.$get_users['l_name'].' has made a milestone payment for the job “'.$post_title.'.” </p>';
						$html .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$tsm_amount1.'</p>';
						$html .= '<p style="margin:0;padding:10px 0px">There´s nothing more d to do other than to complete the job for which the milestone was created. Once the task has been complete, the payment will be released to you. </p>';
						$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$sent = $this->common_model->send_mail($has_email_noti1['email'],$subject,$html);
					}
					
					
					$has_email_noti = $this->common_model->check_email_notification($user_id);
						
					if($has_email_noti){
						
						$subject = "Your Milestone Payment created successfully: “".$post_title."”"; 
						
						$html = '<p style="margin:0;padding:10px 0px">Milestone Payment Made Successfully!</p>';
						$html = '<p style="margin:0;padding:10px 0px">Hi ' . $has_email_noti['f_name'] .',</p>';
		
						$html .= '<p style="margin:0;padding:10px 0px">Your milestone payment to '.$has_email_noti1['trading_name'].' created successfully.</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Job title: '.$post_title.'</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Milestone Amount: £'.$tsm_amount1.'</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Days to Complete: '.$get_post_data['delivery_days'].' day(s)</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to wait for the job completion. Once the task has been completed, and your 100% satisfied, release the milestone.</p>';
						
						$html .= '<br><p style="margin:0;padding:10px 0px">View our Milestone Payment System page on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$this->common_model->send_mail($has_email_noti['email'],$subject,$html);
					
					}
					
					
					
					
					$insertn['nt_userId']=$bid_by;
					$insertn['nt_message']=$get_users['f_name'].' '.$get_users['l_name'].' accepted your request and made a milestone payment. <a href="'.site_url().'payments/?post_id='.$get_post_data['job_id'].'">Amount £'.$tsm_amount1.'!</a>';
					$insertn['nt_satus']=0;
					$insertn['nt_apstatus']=2;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');   
					$insertn['job_id']=$get_post_data['job_id'];
					$insertn['posted_by']=$get_post_data['posted_by'];
					$run2 = $this->common_model->insert('notification',$insertn);
					
					$this->common_model->delete(array('id'=>$miles_id),'tbl_milestones');

					$json['status'] = 1;
					$this->session->set_flashdata('success1', 'Success! Milestone has been created successfully.');
					
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong try agin later.</div>';
			}	
				
		}
		
		echo json_encode($json);
	}
	
	public function update_milestones() {
		
		$this->form_validation->set_rules('post_id','Post Id','required');
		$this->form_validation->set_rules('tsm_name1','Milestone Name','required');
		$this->form_validation->set_rules('tsm_amount1','Milestone Amount','required');
		
		if ($this->form_validation->run()==false) {
			
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
						
		}	else {
		
			$id=$this->input->post('post_id');
			
			$bid_by=$this->input->post('bid_by');
			
			$user_id=$this->session->userdata('user_id');
			
			$tsm_name1=$this->input->post('tsm_name1');
			$tsm_amount1=$this->input->post('tsm_amount1');
		
			$where = "id = '".$id."' and bid_by = '".$bid_by."' and (status = 7 or status = 3 or status = 5 or status = 10)";
			$get_post_data = $this->common_model->get_single_data('tbl_jobpost_bids',$where);
			
			$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_post_data['job_id']));
			
			if($get_post_data && $get_job_post){

				$mile_amount = $get_post_data['total_milestone_amount'];

				$get_users=$this->common_model->get_single_data('users',array('id'=>$user_id));
			
				$post_title=$get_job_post['title'];
				 
				$total_amt = $mile_amount+$tsm_amount1;

				$total_amt=$mile_amount+$_POST['tsm_amount1'];

				if($tsm_amount1 > $get_users['u_wallet']) {
					
					$json['status'] = 2;
					$json['amount'] = $tsm_amount1 - $get_users['u_wallet'];
					$json['msg'] = '<div class="alert alert-danger">Insufficient amount in your wallet please recharge you wallet.</div>';
					
				} else {
					
					$data = array(
						'milestone_name'=>$tsm_name1, 
						'milestone_amount'=>$tsm_amount1,
						'userid'=>$bid_by,
						'post_id'=>$get_job_post['job_id'],
						'cdate' =>date('Y-m-d H:i:s'),
						'posted_user'=>$get_post_data['posted_by'], 
						'bid_id'=>$get_post_data['id'],  						
						'created_by'=>$user_id
					);
					
					
					$run1 = $this->common_model->insert('tbl_milestones',$data);
					
					$total_amt=$mile_amount+$tsm_amount1;
					
					$update1['total_milestone_amount']=$total_amt;
					
					$this->common_model->update('tbl_jobpost_bids',array('id'=>$id),$update1);
					
					$update12['u_wallet']=$get_users['u_wallet']-$tsm_amount1;
					$update12['spend_amount']=$get_users['spend_amount']+$tsm_amount1;
							
					$this->common_model->update('users',array('id'=>$user_id),$update12);
					
					$transactionid = md5(rand(1000,999).time());
					
					$tr_message='£'.$tsm_amount1.' has been debited from your wallet for create a milestone for the job <a href="'.site_url().'proposals/?post_id='.$get_job_post['job_id'].'">'.$get_job_post['title'].'</a> on date '.date('d-m-Y h:i:s A');
					
					$data1 = array(
						'tr_userid'=>$user_id, 
						'tr_amount'=>$tsm_amount1,
						'tr_type'=>2,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
					);
				 
				 $this->common_model->insert('transactions',$data1);
					
				$has_email_noti1 = $this->common_model->check_email_notification($bid_by);
						
				if($has_email_noti1){
					
					$subject = "Milestone Payment Made for “".$post_title."”";
					
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone Payment Made Successfully!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti1['f_name'].'!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">'.$get_users['f_name'].' '.$get_users['l_name'].' has made a milestone payment for the job “'.$post_title.'.” </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$tsm_amount1.'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to complete the job for which the milestone was created. Once the task has been complete, the payment will be released to you. </p>';
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$sent = $this->common_model->send_mail($has_email_noti1['email'],$subject,$html);
				}
				
				
				$has_email_noti = $this->common_model->check_email_notification($user_id);
					
				if($has_email_noti){
					
					$subject = "Your Milestone Payment created successfully: “".$post_title."”"; 
						
					$html = '<p style="margin:0;padding:10px 0px">Milestone Payment Made Successfully!</p>';
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $has_email_noti['f_name'] .',</p>';
	
					$html .= '<p style="margin:0;padding:10px 0px">Your milestone payment to '.$has_email_noti1['trading_name'].' created successfully.</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">Job title: '.$post_title.'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Milestone Amount: £'.$tsm_amount1.'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Days to Complete: '.$get_post_data['delivery_days'].' day(s)</p>';
					
					$html .= '<p style="margin:0;padding:10px 0px">There´s nothing more to do other than to wait for the job completion. Once the task has been completed, and your 100% satisfied, release the milestone.</p>';
					
					$html .= '<br><p style="margin:0;padding:10px 0px">View our Milestone Payment System page on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$this->common_model->send_mail($has_email_noti['email'],$subject,$html);
					
				}
					
					$insertn['nt_userId']=$bid_by;
					$insertn['nt_message']=$get_users['f_name'].' '.$get_users['l_name'].' made a milestone payment. <a href="'.site_url().'details/?post_id='.$get_post_data['job_id'].'">Amount £'.$tsm_amount1.'!</a>';
					$insertn['nt_satus']=0;
					$insertn['nt_apstatus']=2;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');   
					$insertn['job_id']=$get_post_data['job_id'];
					$insertn['posted_by']=$get_post_data['posted_by'];
					$run2 = $this->common_model->insert('notification',$insertn);

					$json['status'] = 1;
					$this->session->set_flashdata('success1', 'Success! Milestone has been created successfully.');
					
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong try agin later.</div>';
			}	
				
		}
		
		echo json_encode($json);
	}
	
	public function update_milestones1() {
		
		$this->form_validation->set_rules('post_id','Post Id','required');
		$this->form_validation->set_rules('tsm_name1','Milestone Name','required');
		$this->form_validation->set_rules('tsm_amount1','Milestone Amount','required');
			
		if ($this->form_validation->run()==false) {
			
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' .validation_errors() . '</div>';
						
		}	else {
			
			$id=$this->input->post('post_id');
		
			$bid_by = $this->session->userdata('user_id');
	
			$tsm_name1=$this->input->post('tsm_name1');
			$tsm_amount1=$this->input->post('tsm_amount1');
			
			$where = "id = '".$id."' and bid_by = '".$bid_by."' and (status = 7 or status = 3 or status = 5 or status = 10)";
			$get_post_data = $this->common_model->get_single_data('tbl_jobpost_bids',$where);
			
			$get_job_post = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_post_data['job_id']));
			
			if($get_post_data && $get_job_post){
			
				$mile_amount = $get_post_data['total_milestone_amount'];
				
				$get_users=$this->common_model->get_single_data('users',array('id'=>$bid_by));
				
				$post_title=$get_job_post['title'];
				 
				$total_amt = $mile_amount+$tsm_amount1;
				
				if($total_amt > $get_post_data['bid_amount']) {
					
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Sum of the total milestone amount should not be greater than total bid amount.</div>';
					
				} else {
					
					$data = array(
						'milestone_name'=>$tsm_name1, 
						'milestone_amount'=>$tsm_amount1,
						'userid'=>$bid_by,
						'post_id'=>$get_job_post['job_id'],
						'cdate' =>date('Y-m-d H:i:s'),
						'posted_user'=>$get_post_data['posted_by'],   
						'bid_id'=>$get_post_data['id'],   
						'created_by'=>$this->session->userdata('user_id')
					);
						
					$run1 = $this->common_model->insert('tbl_milestones',$data);
					
					/*$has_email_noti = $this->common_model->check_email_notification($get_post_data['bid_by']);
						
					if($has_email_noti){
					
						$subject = "Milestone Request";
						
						$content= 'Hello '.$has_email_noti['f_name'].', <br><br>';
				
						$content.='<p class="text-center">You have requested milestone for the job post <b>'.$post_title.'</b> of amount £'.$tsm_amount1.' .</p>';
						$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_job_post['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Open job</a></div><p>if the button above does not work, please click the following link instead:<br><a style="color: #2875d7;" href="'.site_url().'payments/?post_id='.$get_job_post['job_id'].'" style="color:grey">'.site_url().'payments/?post_id='.$get_job_post['job_id'].'</a></p>';
						$this->common_model->send_mail($has_email_noti['email'],$subject,$content);
					
					}*/
					
					$has_email_noti = $this->common_model->check_email_notification($get_post_data['posted_by']);
						
					if($has_email_noti){
						
						$trades = $this->common_model->get_userDataByid($bid_by);
						
						$subject = "Milestone Payment Creation request by ".$trades['trading_name']." for the job: “".$post_title."”."; 
						
						$html = '<p style="margin:0;padding:10px 0px">Request to create a milestone payment! </p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $has_email_noti['f_name'] .',</p>';
		
						$html .= '<p style="margin:0;padding:10px 0px">'.$trades['trading_name'].' has requested the creation of milestone payment for the job “'.$post_title.'”.</p>';
						
						$html .= '<p style="margin:0;padding:0px 0px">Milestone Amount: £'.$tsm_amount1.'</p>';
						$html .= '<p style="margin:0;padding:0px 0px">Days to Complete: '.$get_post_data['delivery_days'].' day(s)</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">Create a Milestone payment to guarantee you want to work with '.$trades['trading_name'].'. Tradespeople are 150% more likely to accept your project when you create a Milestone Payment.</p>';
						
						$html .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_job_post['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Create Milestone Now!</a></div>';
						
						$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$this->common_model->send_mail($has_email_noti['email'],$subject,$html);
					
					}
					
					$insertn['nt_userId']=$get_post_data['posted_by'];
					
					// $insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a> has requested '.$tsm_name1.' milestone for <a href="'.site_url().'payments?post_id='.$get_post_data['job_id'].'">'.$post_title.'</a> of amount £'.$tsm_amount1.'.';
					$insertn['nt_message'] = $get_users['trading_name'] .' has requested a milestone payment: <a href="'.site_url().'payments?post_id='.$get_post_data['job_id'].'">Amount £' .$tsm_amount1 .'</a>';
					
					$insertn['nt_satus']=0;
					
					$insertn['nt_apstatus']=2;
					$insertn['nt_create']=date('Y-m-d H:i:s');
					$insertn['nt_update']=date('Y-m-d H:i:s');
					$insertn['job_id']=$get_post_data['job_id'];
					
					$insertn['posted_by']=$bid_by;
					
					$run2 = $this->common_model->insert('notification',$insertn);
		
					$json['status'] = 1;
					$this->session->set_flashdata('success1', 'Success! Milestone request has been created successfully.');
					
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong try agin later.</div>';
			}	
				
		}
		echo json_encode($json);
	}

	public function delete_mile($id,$amount,$name,$job_id,$post_id){
		$get_job_post=$this->common_model->get_posts_by_id('tbl_jobs',$job_id);
		$post_title=$get_job_post[0]['title'];
		$get_post_data=$this->common_model->get_post_data('tbl_jobpost_bids',$post_id);
		$mile_amount=$get_post_data[0]['total_milestone_amount'];
		if($mile_amount==0)
		{
			$update1['total_milestone_amount']=0;
		}
		else
		{
			$mile_remove=$mile_amount-$amount;
			$update1['total_milestone_amount']=$mile_remove;
		}

	$runss = $this->common_model->update('tbl_jobpost_bids',array('id'=>$post_id),$update1);

	$result=$this->common_model->delete(array('id'=>$id),'tbl_milestones'); 
	$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
	$u_wallet=$get_users['u_wallet'];
	$update2['u_wallet']=$get_users['u_wallet']+$amount;
	$runss1 = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$update2);


		    $transactionid = md5(rand(1000,999).time());
				    $tr_message='£'.$amount.' has been credited to your wallet for '.$name.' milestone for the job post <a href="'.site_url().'details/?post_id='.$job_id.'"> '.$post_title.'</a> on date '.date('d-m-Y h:i:s A');
				   $data1 = array(
   					  'tr_userid'=>$this->session->userdata('user_id'), 
    				  'tr_amount'=>$amount,
     				  'tr_type'=>1,
    				  'tr_transactionId'=>$transactionid,
    				  'tr_message'=>$tr_message,
    				  'tr_status'=>1,
    				  'tr_created'=>date('Y-m-d H:i:s'),
    				  'tr_update' =>date('Y-m-d H:i:s')
   					  );
					 $run1 = $this->common_model->insert('transactions',$data1);
					 if($run1)
					 {
					 		$this->session->set_flashdata('success1', 'Success! Milestone has been deleted successfully.');
					 }
					 else
					 {
					 	$this->session->set_flashdata('error1', 'Error! Something went wrong.');
					 }
			redirect('payments/?post_id='.$job_id);
}

	public function request_mile($id,$job_id){

	$get_milestones=$this->common_model->get_milestone_byid($id);
	$name=$get_milestones[0]['milestone_name'];
	$amount=$get_milestones[0]['milestone_amount'];
	$updatea['status']=3;
	$updatea['is_requested']=1;
	$runss1 = $this->common_model->update('tbl_milestones',array('id'=>$get_milestones[0]['id']),$updatea);
	$get_post_data=$this->common_model->get_job_post('tbl_jobs',$job_id);
	$post_by=$get_post_data[0]['userid'];
	$get_jobs=$this->common_model->get_jobs_bid($get_milestones[0]['post_id']);
	$get_job_post=$this->common_model->get_posts_by_id('tbl_jobs',$job_id);
	$get_user_details=$this->common_model->get_single_data('users',array('id'=>$get_milestones[0]['userid']));
				$insertn['nt_userId']=$get_milestones[0]['posted_user'];

				$insertn['nt_message']='<a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_user_details['trading_name'].'</a> has requested to release milestone payment of £'.$amount.' GBP for <a href="'.site_url().'payments/?post_id='.$job_id.'">'.$get_job_post[0]['title'].'</a>';
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$get_milestones[0]['post_id'];
				$insertn['posted_by']=$get_milestones[0]['userid'];
				$insertn['nt_apstatus']=4;
				$run2 = $this->common_model->insert('notification',$insertn);


			$get_users=$this->common_model->get_single_data('users',array('id'=>$post_by));
			
			$bid_data = $this->common_model->GetColumnName('tbl_jobpost_bids',array('id'=>$get_milestones[0]['bid_id']),array('delivery_days'));
			
			$subject = "Request to release Milestone Payment for Job: “".$get_job_post[0]['title']."”"; 
						
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Request to release milestone payment!</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $get_users['f_name'] .',</p>';

			$html .= '<p style="margin:0;padding:10px 0px">'.$get_user_details['trading_name'].' has requested the release of their milestone payment for the job. “'.$get_job_post[0]['title'].'” Please, release the milestone if the task has been completed and you´re satisfied. </p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Milestone Amount: £'.$amount.'</p>';
			
			$html .= '<br><div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_job_post[0]['job_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Release milestone now</a></div>';
			
			$html .= '<br><p style="margin:0;padding:10px 0px">View our Milestone Payment System page on the homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$this->common_model->send_mail($get_users['email'],$subject,$html);
			
			
			
				 if($run)
				 {
				 	$json['status']=1;
				 		$this->session->set_flashdata('message', '<p class="alert alert-success">Success! Your request has been submitted successfully.</p>');
				 }
				 else
				 {
				 	$json['status']=0;
				 	$this->session->set_flashdata('error1', 'Error! Something went wrong.');
				 }
				 echo json_encode($json);

}

  public function payments(){
    if($this->session->userdata('user_id')){
      if(isset($_GET['reject_reason'])){
        $whereReason['id'] = $_GET['reject_reason'];
        $reject_reason = $this->common_model->fetch_records('tbl_milestones', $whereReason);
        if(!empty($reject_reason)){
          $this->session->set_flashdata('reject_reason', $reject_reason[0]['decline_reason']);
          redirect('payments?post_id=' .$_GET['post_id']);
        }
      }
      $this->load->view('site/payment-inner');
    }else{
      redirect('login');
    }
  }

  public function proposals() {



    if($this->session->userdata('user_id')) {
      if( isset($_GET['reject_reason']) && isset($_GET['type']) ){
        $whereReason['id'] = $_GET['reject_reason'];
        $reject_reason = $this->common_model->fetch_records('tbl_jobpost_bids', $whereReason);
        if(!empty($reject_reason)){
          $this->session->set_flashdata('reject_reason', $reject_reason[0]['reject_reason']);
          redirect('proposals?post_id=' .$_GET['post_id']);
        }
      }
			
      $post_id=$_REQUEST['post_id'];
			
      $data['project_details']=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$post_id));
			
      $data['proposals'] = $this->common_model->get_jobs_posts($this->session->userdata('user_id'),$post_id);
			
      $data['count_bids']=$this->common_model->get_all_data('tbl_jobpost_bids',array('job_id'=>$post_id));
			
			
      $data['tradespropose']=$this->common_model->get_trades_proposalbyjobid($this->session->userdata('user_id'),$post_id);
			
      $data['accepted_proposal']=$this->common_model->get_accepted_post('tbl_jobpost_bids',$post_id,$this->session->userdata('user_id'));
			
      $data['awarded']=$this->common_model->get_awarded_trades($post_id);
			
			$data['setting']=$this->common_model->get_all_data('admin');
			
      $this->load->view('site/proposals',$data);
    } else {
      redirect('login');
    }
  }

  public function details(){
    if(!$_REQUEST['post_id']) redirect('dashboard');
    if($this->session->userdata('user_id')){
      $post_id = $_REQUEST['post_id'];
      $data['category']=$this->common_model->get_all_category('category');
      $data['project_details']=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$post_id));
      $data['attachment']=$this->common_model->get_all_files($post_id);
			
      $data['get_users']=$this->common_model->get_single_data('users',array('id'=>$data['project_details']['userid']));
			
			
			$this->load->library('Ajax_pagination');
			$this->load->model('search_model');
			$perPage = 1;
			
			$conditions['search']['userid'] = $data['get_users']['id'];
			
			$totalRec = count($this->search_model->get_rating($conditions));
			
			$data['totalRec'] = $totalRec;
			
			$base_url = site_url().'users/find_rating_ajax';
			
			$config['target']      = '#search_data';
			$config['base_url']    = $base_url;
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			$conditions['start'] = 0;
			$conditions['limit'] = $perPage;
			
			$data['get_reviews'] = $this->search_model->get_rating($conditions);
			
			//print_r($data['get_reviews']);
			
      $this->load->view('site/project-detail',$data);
    }else{
      redirect('login');
    }
  }

	public function delete_bid($post_id,$job_id){
		
		$result=$this->common_model->delete(array('id'=>$post_id),'tbl_jobpost_bids'); 
		if($result) {
			$this->common_model->delete(array('bid_id'=>$post_id),'tbl_milestones');
			$user_id=$this->session->userdata('user_id');
			$get_users=$this->common_model->get_single_data('users',array('id'=>$user_id));
			$jobs = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$job_id));


			$subject = "Your quote was withdrawn successfully!"; 
			$content= 'Hi '.$get_users['f_name'].', <br><br>';
			$content.= 'Your quote on the job “'.$jobs['title'].'” was withdrawn successfully. We encourage you to resubmit your quote.<br><br>';
			$content.='<div style="text-align:center"><a href="'.site_url().'details?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Send new quote</a></div><br>';
			$content.= 'Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.<br><br>';

			$runs1=$this->common_model->send_mail($get_users['email'], $subject,$content);

			redirect('details?post_id='.$job_id);

		} else {
				$this->session->set_flashdata('error2', 'Error! Something went wrong.');
				redirect('proposals?post_id='.$job_id);

		}

	}

	public function files(){
		if($this->session->userdata('user_id'))
		{
					$data['attachment']=$this->common_model->get_all_files($_REQUEST['post_id']);
		$data['image']=$this->common_model->get_file_typeimg($_REQUEST['post_id']);
		$data['doc']=$this->common_model->get_file_typedoc($_REQUEST['post_id']);
		$data['video']=$this->common_model->get_file_typevideo($_REQUEST['post_id']);
		$this->load->view('site/files',$data);
		}
		else
		{
			redirect('login');
		}

	}
	
	public function delete_file($id){	
		$result=$this->common_model->delete(array('id'=>$id),'job_files'); 
			if($result)
			{
				$json['status'] = 1;
			}
			else
			{
				$json['status'] = 2;
			}
			echo json_encode($json);

	}
	
	public function delete_category($id){
		$get_user_category=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		$category=explode( ',', $get_user_category['category']);
		$oldsubcat = '';
		if ($get_user_category['subcategory']) {
			$oldsubcat=explode( ',', $get_user_category['subcategory']);
		}
		
		$match=array_diff($category,array('category'=>$id));
			$insert1['category']=implode(',',$match);
	  	 
	  	 $get_user_category=$this->common_model->get_single_data('users',array('id'=>$run));
		 $category =  $this->common_model->GetColumnName('category' ,array('cat_parent' => $id ) , array('cat_id') , true);
		 $subcategories = [];
		 foreach($category as $parent)
	      {
	      	if (in_array($parent['cat_id'], $oldsubcat)) {
	      		$oldsubcat =array_diff($oldsubcat,array('category'=>$parent['cat_id']));
	      	}

	      }
	      
	      if (count($oldsubcat) > 0) {
	      	$insert1['subcategory']=implode(',',$oldsubcat);
	      }
	      else
	      {
	      	$insert1['subcategory'] = '';
	      }
	      
	      //print_r($oldsubcat);
	      $run = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$insert1);
			if($run)
			{
				$json['status'] = 1;
			}
			else
			{
				$json['status'] = 2;
			}
			echo json_encode($json);
	}
	public function delete_subcategory($id){
		$get_user_category=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		$category=explode( ',', $get_user_category['subcategory']);
		$match=array_diff($category,array('category'=>$id));
			$insert1['subcategory']=implode(',',$match);
	  	 $run = $this->common_model->update('users',array('id'=>$this->session->userdata('user_id')),$insert1);
	
			if($run)
			{
				$json['status'] = 1;
			}
			else
			{
				$json['status'] = 2;
			}
			echo json_encode($json);
	}

	public function upload_file($post_id){
		$types=$_FILES['post_doc']['type'];
		$type= substr($types[0], 0, strpos($types[0], "/"));
		$cpt = count($_FILES['post_doc']['name']);
        if(count($_FILES['post_doc'])>0)
        {

        	for ($i = 0; $i < $cpt; $i ++) {

           	if($_FILES['post_doc']['name'])
		{
			$ext=end(explode(".",$_FILES['post_doc']['name'][$i]));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['post_doc']['tmp_name'][$i],'img/jobs/'.$files))
			{
				 $insert1['post_doc']=$files;
					$insert1['job_id']=$post_id;
					$insert1['userid']=$this->session->userdata('user_id');
					$insert1['type']=$type;
			 $run = $this->common_model->insert('job_files',$insert1);
			}
		
			if($run)
			{
				$this->session->set_flashdata('success2', 'Success! File has been uploaded successfully.');
			}
			else
			{
				
				$this->session->set_flashdata('error2', 'Error! Something went wrong.');

			}

		}

        }

        } 
        redirect('files/?post_id='.$post_id); 
	}
	
	public function edit_post($id) {

		// echo "<pre>"; print_r($_POST); exit;
		// [title] => New building planner wanted
  //   [description] => New building planner wanted
  //   [budget] => 100
  //   [budget2] => 499

		//$this->form_validation->set_rules("title","Title","required");
		$this->form_validation->set_rules("description","Description", "required");
		$this->form_validation->set_rules("budget","Price","required");
		// $this->form_validation->set_rules("post_code","postal code","required");
		if ($this->form_validation->run()==false) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
		} else {
			


			// $post_code = $this->input->post('post_code');
			
			// $post_code = str_replace(" ","",$post_code);
			
			// $check_postcode = $this->common_model->check_postalcode($post_code);
			
			// if($check_postcode['status']==1){

				//$insert['title'] = $this->input->post('title');
				$insert['description'] = $this->input->post('description');
				$insert['budget'] = $this->input->post('budget');
				$insert['budget2'] = $this->input->post('budget2');
				//$insert['category']=$this->input->post('category');
				$insert['userid']=$this->session->userdata('user_id');
				// $insert['post_code']=$this->input->post('post_code');
				//$insert['subcategory']=$this->input->post('subcategory');
				

				$budgetCheck = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$id));

				if($budgetCheck['budget']<= $insert['budget'] && $budgetCheck['budget2']<= $insert['budget2']){
					if($insert['budget']< $insert['budget2']){ }else{
						$this->session->set_flashdata('msg2', '<p class="alert alert-danger">Please add amount greater than price 1 from price 2 .</p>');
						$json['status'] = 1;
						echo json_encode($json);  exit;
					}

				 }else{ 
					$this->session->set_flashdata('msg2', '<p class="alert alert-danger">Please increase bid amount .</p>');
					$json['status'] = 1;
					echo json_encode($json);  exit;
				}

				if(isset($_POST['iss_repost']) && $_POST['iss_repost']==1){
					$insert['c_date'] = date('Y-m-d H:i:s');
				}
				
				//$insert['status']=1;
				$where_array=array('job_id'=>$id);
				$run1 = $this->common_model->update('tbl_jobs',$where_array,$insert); 	
				$cpt = count($_FILES['post_doc']['name']);
				
				$check = false;
				
				if(count($_FILES['post_doc']['name'])>0) {
					for ($i = 0; $i < $cpt; $i ++) {

						if($_FILES['post_doc']['name']) {
							$ext=end(explode(".",$_FILES['post_doc']['name'][$i]));
							$files=rand(10,1000).time().".".$ext;
							if(move_uploaded_file($_FILES['post_doc']['tmp_name'][$i],'img/jobs/'.$files)) {
								$insert1['post_doc']=$files;
								$insert1['job_id']=$id;
								$run = $this->common_model->insert('job_files',$insert1);
								$check = true;
							}
						}
					}
				}
				
				
					
				if($run1 || $check) {
					$json['status'] = 1;
					
					if(isset($_POST['iss_repost']) && $_POST['iss_repost']==1){
						$this->session->set_flashdata('msg2', '<p class="alert alert-success">Success! Job has been re-posted successfully.</p>');
					} else {
						$this->session->set_flashdata('msg2', '<p class="alert alert-success">Success! Job has been updated Successfully.</p>');
					}
				} else {
					$json['status'] = 2;
					$this->session->set_flashdata('error1', 'We have not found any change in the post edit.');

				}

			// } else {
			// 	$json['status'] = 3;
			// }
		}
		echo json_encode($json);

	}
	
	public function save_image_for_post_job(){
	
	$data1 = $this->input->post('post_doc');
	
	list($type, $data1) = explode(';', $data1);
	list(, $data1)      = explode(',', $data1);
	$data1 = base64_decode($data1);
	$files = rand(10000,99999).time().'.png';

	$path = 'img/jobs/'.$files;
	
	file_put_contents($path, $data1);
	
	echo json_encode(array('status'=>1,'name'=>$files));
}
	
	public function reject_award($post_id,$job_id) {
		
		$job_data = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$job_id));
		$bid_data = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$post_id));
		
		$homeOwner = $this->common_model->get_single_data('users',array('id'=>$job_data['userid']));
		
		$tradeMen = $this->common_model->get_single_data('users',array('id'=>$bid_data['bid_by']));
		
		if($bid_data['total_milestone_amount'] > 0){
	
			$update2['u_wallet']=$homeOwner['u_wallet']+$bid_data['total_milestone_amount'];
			$update2['spend_amount']=$homeOwner['spend_amount']-$bid_data['total_milestone_amount'];
		
			$runss1 = $this->common_model->update('users',array('id'=>$job_data['userid']),$update2);
			
		 	$transactionid = md5(rand(1000,999).time());
			
			$tr_message = '£'.$bid_data['total_milestone_amount'].' has been credited to your wallet.  <a href="'.site_url().'profile/'.$tradeMen['id'].'">'.$tradeMen['trading_name'].'</a> has rejected your proposal for <a href="'.site_url().'details/?post_id='.$job_data['job_id'].'">'.$job_data['title'].'</a>';
		 
			$data1 = array(
				'tr_userid'=>$homeOwner['id'], 
				'tr_amount'=>$bid_data['total_milestone_amount'],
				'tr_type'=>1,
				'tr_transactionId'=>$transactionid,
				'tr_message'=>$tr_message,
				'tr_status'=>1,
				'tr_created'=>date('Y-m-d H:i:s'),
				'tr_update' =>date('Y-m-d H:i:s')
			);
			
			$run1 = $this->common_model->insert('transactions',$data1);
			
		}

		$insertn['nt_message'] = $tradeMen['trading_name'].' rejected your offer!';
				
		$insertn['nt_userId']=$homeOwner['id'];
		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['job_id']=$bid_data['job_id'];
		$insertn['posted_by']=$homeOwner['id'];
		$insertn['nt_apstatus']=3;
			
		$this->common_model->insert('notification',$insertn);	
		
		$update['status'] = 1;
		
		$where_array1=array('job_id'=>$bid_data['job_id']);
		
		if($job_data['direct_hired']==1){
			$this->common_model->delete($where_array1,'tbl_jobs');
		} else {
			$this->common_model->update('tbl_jobs',$where_array1,$update);
		}
		
		$this->common_model->delete(array('id'=>$bid_data['id']),'tbl_jobpost_bids'); 
		$this->common_model->delete(array('bid_id'=>$bid_data['id']),'tbl_milestones'); 
		
		$subject = "Unfortunately! ".$tradeMen['trading_name']." has declined your job offer for the job: “".$job_data['title']."”";
						
		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] .',</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! '.$tradeMen['trading_name'].' has declined to begin work on your project “'.$job_data['title'].'”!</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can award the job to another tradesperson or increase your budget to attract more skilled tradespeople.</p>';
		
		$html .= '<br><div style="text-align:center"><a href="'.site_url().'details?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit</a> &nbsp; &nbsp; <a href="'.site_url().'proposals/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Award</a></div>';
		
		$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
		

		$this->common_model->send_mail($homeOwner['email'],$subject,$html);


		$subject1 = "Job offer declined successfully!";
		$content1='Hi '.$tradeMen['f_name'].', <br><br>';
		$content1.='You have successfully declined the job offer “'.$job_data['title'].'”. <br><br>';
		$content1.='Visit our Tradespeople help page or contact our customer services if you have any specific questions using our service.<br><br>';
		$this->common_model->send_mail($tradeMen['email'],$subject1,$content1);


		
		$this->session->set_flashdata('success1', '<p class="alert alert-success">Success! Project has been rejected successfully.</p>');
		
		redirect('dashboard');
	

}

	public function reject_post($post_id,$job_id) {
		
		$job_data = $this->common_model->get_single_data('tbl_jobs',array('id'=>$job_id));
		$bid_data = $this->common_model->get_single_data('tbl_jobpost_bids',array('id'=>$post_id));
		
		$homeOwner = $this->common_model->get_single_data('users',array('id'=>$job_data['userid']));
		
		$tradeMen = $this->common_model->get_single_data('users',array('id'=>$bid_data['posted_by']));
	
		$update2['u_wallet']=$homeOwner['u_wallet']+$bid_data['bid_amount'];
		
		$runss1 = $this->common_model->update('users',array('id'=>$job_data['userid']),$update2);
		
		if($runss1) {
		 	$transactionid = md5(rand(1000,999).time());
			$tr_message='£'.$bid_data['bid_amount'].' has been credited to your wallet for milestone on date '.date('d-m-Y h:i:s A').'.';
			$data1 = array(
				'tr_userid'=>$get_jobs['bid_by'], 
				'tr_amount'=>$get_amount[0]['sum'],
				'tr_type'=>1,
				'tr_transactionId'=>$transactionid,
				'tr_message'=>$tr_message,
				'tr_status'=>1,
				'tr_created'=>date('Y-m-d H:i:s'),
				'tr_update' =>date('Y-m-d H:i:s')
				);
			$run1 = $this->common_model->insert('transactions',$data1);
		}

		$get_amounts=$this->common_model->get_user_amount($get_jobs['posted_by'],$job_id);
		$get_users1=$this->common_model->get_single_data('users',array('id'=>$get_jobs['posted_by']));
		$wallet=$get_users1['u_wallet'];
		$update22['u_wallet']=$wallet+$get_amounts[0]['sum'];
		$runss11 = $this->common_model->update('users',array('id'=>$get_jobs['posted_by']),$update22);
		if($runss11) {
		 	$transactionid = md5(rand(1000,999).time());
			$tr_message='£'.$get_amounts[0]['sum'].' has been credited to your wallet for milestone on date '.date('d-m-Y h:i:s A').'.';
			$data1 = array(
				'tr_userid'=>$get_jobs['posted_by'], 
				'tr_amount'=>$get_amounts[0]['sum'],
				'tr_type'=>1,
				'tr_transactionId'=>$transactionid,
				'tr_message'=>$tr_message,
				'tr_status'=>1,
				'tr_created'=>date('Y-m-d H:i:s'),
				'tr_update' =>date('Y-m-d H:i:s')
			);
			$run1 = $this->common_model->insert('transactions',$data1);
		}

		$result=$this->common_model->delete(array('post_id'=>$job_id),'tbl_milestones'); 

		$get_jobs=$this->common_model->get_jobs_bid($post_id);
		$get_user_details=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['bid_by']));
		$get_posted_user=$this->common_model->get_single_data('users',array('id'=>$get_jobs[0]['posted_by']));
		$get_job_details=$this->common_model->get_job_details($get_jobs[0]['job_id']);
		$insertn['nt_userId']=$get_jobs[0]['posted_by'];

		$insertn['nt_message']='<a href="'.site_url().'profile/'.$get_user_details['id'].'">'.$get_user_details['trading_name'].'</a> has rejected your proposal for <a href="'.site_url().'details/?post_id='.$get_jobs[0]['job_id'].'">'.$get_job_details[0]['title'].'</a>';
		$insertn['nt_satus']=0;
		$insertn['nt_create']=date('Y-m-d H:i:s');
		$insertn['nt_update']=date('Y-m-d H:i:s');
		$insertn['job_id']=$get_jobs[0]['job_id'];
		$insertn['posted_by']=$get_jobs[0]['bid_by'];
		$insertn['nt_apstatus']=3;
		$run2 = $this->common_model->insert('notification',$insertn);
		$update['status']=3;
		
		$where_array1=array('job_id'=>$get_jobs[0]['job_id']);
		
		
		$results=$this->common_model->update('tbl_jobs',$where_array1,$update); 
		
		$result=$this->common_model->delete(array('id'=>$post_id),'tbl_jobpost_bids'); 

			
		
		if($result) {
			$subject = "You proposal has been rejected for the ".$get_job_details[0]['title']." job post"; 
			$content= 'Hello '.$get_posted_user['f_name'].' '.$get_posted_user['l_name'].', <br><br>';
		
			$content.='<p class="text-center"><a href="'.site_url().'profile/'.$get_user_details['id'].'">'.$get_user_details['trading_name'].'</a> has rejected your proposal for <a href="'.site_url().'details/?post_id='.$get_jobs[0]['job_id'].'">'.$get_job_details[0]['title'].'</a>.</p>';
			$runs1=$this->common_model->send_mail($get_posted_user['email'],$subject,$content);
				
				redirect('details?post_id='.$job_id);
				
			}
			else
			{
					$this->session->set_flashdata('error2', 'Error! Something went wrong.');
							redirect('proposals?post_id='.$job_id);

			}
	

	}

	public function mile_invoice($mile){	
		require_once('application/libraries/pdflayer.class.php');
		$miles=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mile));


		//Instantiate the class
		$html2pdf = new pdflayer();

		//set the URL to convert
		$html2pdf->set_param('document_url',site_url().'invoice/'.$mile);


		//start the conversion
		$html2pdf->convert();

		//display the PDF file
		$html2pdf->download_pdf('invoice_'.$miles['milestone_name'].'.pdf');

	}
	
	public function invoice($mile){

		$data['miles']=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mile));
		$this->load->view('site/invoice',$data);


	}
	
	public function cancel_request($id,$job_id) {
		
	$get_milestones=$this->common_model->get_milestone_byid($id);
		
	$name=$get_milestones[0]['milestone_name'];
	$amount=$get_milestones[0]['milestone_amount'];
	$get_post_data=$this->common_model->get_job_post('tbl_jobs',$job_id);

	$post_by=$get_milestones[0]['userid'];
	
	    if($_FILES['dct_image']['name']!=''){	 
			$config['upload_path']   = 'img/request_cancel/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';  
			$config['remove_spaces'] = TRUE;	
			$config['encrypt_name'] = TRUE;	 
			$this->load->library('upload', $config);
			  
			//$this->upload->do_upload('cat_image');
			 if($this->upload->do_upload('dct_image'))
	         {
	            $data = $this->upload->data();      
	         }
	         else
	         {
	            $this->upload->display_errors();
                $file_check = false;
	         }
			
		}
		$updatea['dct_image']=$data['file_name'];
	$updatea['status']=4;
	$updatea['reason_cancel']=$this->input->post('reason_cancel');
	$runss1 = $this->common_model->update('tbl_milestones',array('id'=>$get_milestones[0]['id']),$updatea);
		$get_users1=$this->common_model->get_single_data('users',array('id'=>$get_milestones[0]['posted_user']));
			$insertn['nt_userId']=$get_milestones[0]['userid'];
				$insertn['nt_message']=$get_users1['f_name'].' requested a milestone cancellation. <a href="'.site_url().'payments/?post_id='.$job_id.'">View & respond!</a>';
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');   
				$insertn['job_id']=$job_id;
				$insertn['posted_by']=$get_milestones[0]['posted_user'];
				$run2 = $this->common_model->insert('notification',$insertn);
				$reason=$this->input->post('reason_cancel');
	
			$has_email_noti = $this->common_model->check_email_notification($post_by); 
	
						
			if($has_email_noti){
				
				$subject = "Milestone Payment cancellation request for Job “".$get_post_data[0]['title']."” Accept/Reject";
				
				$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Request to cancel a milestone payment! </p>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti['f_name'].'!</p>';
				$html .= '<p style="margin:0;padding:10px 0px">'.$get_users1['f_name'].' has requested the cancellation of milestone payment made for the job “'.$get_post_data[0]['title'].'.” </p>';
				$html .= '<p style="margin:0;padding:10px 0px">Milestone payment amount:  £'.$get_milestones[0]['milestone_amount'].'</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">All you have to do is to either accept or reject the request. In the event of rejection, please state your reasons and supply any evidence that will help our team make a decision.</p>';
				
				$html .= '<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Accept</a> &nbsp; &nbsp; <a href="'.site_url().'payments/?post_id='.$job_id.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reject</a></div>';
				
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
				$sent = $this->common_model->send_mail($has_email_noti['email'],$subject,$html);

			}
				 
			$this->session->set_flashdata('success1', 'Success! Request cancelled successfully.');		 
			redirect('payments/?post_id='.$job_id);
	}

	public function approve_decision($mileid){
		$get_milestones=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mileid));
		$jobs = $this->common_model->get_single_data('tbl_jobs',array('job_id'=>$get_milestones['post_id']));
		$get_users=$this->common_model->get_single_data('users',array('id'=>$get_milestones['created_by']));
		$get_users1=$this->common_model->get_single_data('users',array('id'=>$get_milestones['userid']));
		$update2['u_wallet']=$get_users['u_wallet']+$get_milestones['milestone_amount'];
	
		$runss1 = $this->common_model->update('users',array('id'=>$get_milestones['created_by']),$update2);
		$get_bid_post=$this->common_model->get_paybids('tbl_jobpost_bids',$get_milestones['post_id'],$get_milestones['userid']);
		$updatem['total_milestone_amount']=$get_bid_post[0]['total_milestone_amount']-$get_milestones['milestone_amount'];
		$runs = $this->common_model->update('tbl_jobpost_bids',array('job_id'=>$get_milestones['post_id']),$updatem);
		

				$result=$this->common_model->delete(array('id'=>$mileid),'tbl_milestones'); 

				$insertn['nt_userId']=$get_milestones['posted_user'];
				// $insertn['nt_message'] = 'Your request for cancellation of <a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'">'.$get_milestones['milestone_name'].'</a> milestone has been approved by <a href="'.site_url().'profile/'.$get_users1['id'].'">'.$get_users1['trading_name'].'</a>.';
				$insertn['nt_message'] = $get_users1['trading_name'] .' accepted your <a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'">milestone cancellation request!</a>';
				$insertn['nt_satus']=0;
				$insertn['nt_create']=date('Y-m-d H:i:s');
				$insertn['nt_update']=date('Y-m-d H:i:s');
				$insertn['job_id']=$get_milestones['post_id'];
				$insertn['posted_by']=$get_milestones['created_by'];
				$run2 = $this->common_model->insert('notification',$insertn);

				    $transactionid = md5(rand(1000,999).time());
				    $tr_message='£'.$get_milestones['milestone_amount'].' has been credited to your wallet for '.$get_milestones['milestone_name'].' milestone on date '.date('d-m-Y h:i:s A').'.';
				   $data1 = array(
   					  'tr_userid'=>$get_milestones['created_by'], 
    				  'tr_amount'=>$get_milestones['milestone_amount'],
     				  'tr_type'=>1,
    				  'tr_transactionId'=>$transactionid,
    				  'tr_message'=>$tr_message,
    				  'tr_status'=>1,
    				  'tr_created'=>date('Y-m-d H:i:s'),
    				  'tr_update' =>date('Y-m-d H:i:s')
   					  );
					 $run1 = $this->common_model->insert('transactions',$data1);

		

				$subject1 = "Your milestone cancellation request has been approved!"; 
				$content1= 'Hi '.$get_users['f_name'].', <br><br>';
				$content1.='Your request to cancel your milestone payment has been approved by '.$get_users1['trading_name'].'<br><br>';
				$content1.='Milestone name: '.$get_milestones['milestone_name'].'<br>';
				$content1.='Milestone amount: £'.$get_milestones['milestone_amount'].'<br>';
				$content1.='<div style="text-align:center"><a href="'.site_url().'details/?post_id='.$get_milestones['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View milestone</a></div><br>';

				$content1.='Visit our Homeowner help page or contact our customer services if you have any specific questions using our services';
				$this->common_model->send_mail($get_users['email'],$subject1,$content1);




		// $get_userss=$this->common_model->get_single_data('users',array('id'=>$get_milestones['posted_user']));
		// $u_name=$get_userss['f_name'].' '.$get_userss['l_name'];
	
		// $subject = "Request for cancellation of milestone has been approved"; 
		// $content= 'Hello '.$u_name.', <br><br>';
		// $content.='<p class="text-center">This is the mail to inform you that your request for cancelling the milestone name '.$get_milestones['milestone_name'].' of £'.$get_milestones['milestone_amount'].' has been approved by <a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a>.</p><p></p>';

		//  $run = $this->common_model->send_mail($get_userss['email'],$subject,$content);


	
		$subject = "Milestone Payment cancellation request for Job “".$jobs['title']."” accepted"; 
		$content= 'Hi '.$get_users1['f_name'].', <br><br>';
		$content.= 'Your milestone payment cancellation request was successfully.<br><br>';
		$content.= 'Milestone name:'.$get_milestones['milestone_name'].'.<br>';
		$content.= 'Milestone amount: £'.$get_milestones['milestone_amount'].'.<br><br>';
		$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request new milestone</a></div><br>';

		$content.='View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.<br><br>';

		 $run = $this->common_model->send_mail($get_users1['email'],$subject,$content);


		if($run)
		{
			$json['status'] = 1;
			$this->session->set_flashdata('success1', 'Success! Request cancellation of milestone has been approved successfully.');
		}
		else
		{
			$json['status'] = 0;
		}
		echo json_encode($json);
	}

	public function decline_request($mileid){
		$get_milestones=$this->common_model->get_single_data('tbl_milestones',array('id'=>$mileid));
		$get_users=$this->common_model->get_single_data('users',array('id'=>$get_milestones['userid']));
		$updatem['status']=8;
		$updatem['decline_reason']=$this->input->post('decline_reason');
		$runs = $this->common_model->update('tbl_milestones',array('id'=>$mileid),$updatem);

    $insertn['nt_userId']=$get_milestones['posted_user'];

    // $insertn['nt_message']='<p>Your request for cancellation of <a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'">'.$get_milestones['milestone_name'].'</a> milestone has been declined by <a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a>.<br><b>Reason:</b>'.$this->input->post('decline_reason').'</p>';

    $insertn['nt_message'] = $get_users['trading_name'] .' rejected your milestone cancellation request. <a href="' .site_url('payments?post_id=' .$get_milestones['post_id'] .'&reject_reason=' .$mileid) .'" >View reason</a>';
    $insertn['nt_satus']=0;
    $insertn['nt_create']=date('Y-m-d H:i:s');
    $insertn['nt_update']=date('Y-m-d H:i:s');
    $insertn['job_id']=$get_milestones['post_id'];
    $insertn['posted_by']=$get_milestones['userid'];
    $run2 = $this->common_model->insert('notification',$insertn);

	$get_userss=$this->common_model->get_single_data('users',array('id'=>$get_milestones['posted_user']));
	$u_name=$get_userss['f_name'].' '.$get_userss['l_name'];
	
		// $subject = "Request for cancellation of milestone has been declined"; 
		// $content= 'Hello '.$u_name.', <br><br>';
		// $content.='<p class="text-center">This is the mail to inform you that your request for cancelling the milestone name '.$get_milestones['milestone_name'].' of £'.$get_milestones['milestone_amount'].' has been declined by <a href="'.site_url().'profile/'.$get_users['id'].'">'.$get_users['trading_name'].'</a>.</p><p></p>';

		$subject = "Your milestone cancellation request has been declined"; 
		$content.='Your request to cancel your milestone has been declined by '.$get_users['trading_name'].'<br><br>';
		$content.='Milestone name: '.$get_milestones['milestone_name'].'<br>';
		$content.='Milestone amount: £'.$get_milestones['milestone_amount'].'<br>';

		$content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View reason</a></div><br>';
		// $content.='<div style="text-align:center"><a href="'.site_url().'payments/?post_id='.$get_milestones['post_id'].'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View resion for declined</a></div><br>';

		$content.='We encourage you to discuss with '.$get_users['trading_name'].' and resolve the issue amicably. If however you  believe you can´t come to a resolution, you can open a milestone dispute.<br><br>';

		$content.='View our <a href="'.site_url().'homeowner-help-centre#Dispute-Resolution-1">Milestone Dispute</a> section on the homeowner help page or contact our customer services if you have any specific questions using our service.';
		$run = $this->common_model->send_mail($get_userss['email'],$subject,$content);
		if($run)
		{
			$json['status'] = 1;
			$this->session->set_flashdata('success1', 'Success! Request cancellation of milestone has been declined successfully.');
		}
		else
		{
			$this->session->set_flashdata('error1', 'Error! Something went wrong.');
						
		}
		redirect('payments?post_id='.$get_milestones['post_id']);
		
	}

  public function job_email_body($job){
    return '<table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 75%">Job description</td>
        <td style="border:1px solid #2875D7; background:#2875d7; color:#fff;  padding:10px 15px; width: 25%;">Budget</td>
      </tr>
      <tr>
        <td style="border:1px solid #E1E1E1; padding:10px 15px; width: 75%; vertical-align: top;">
          <h4 style="font-size:15px; margin: 0; margin-bottom: 8px; color: #2875D7;">' .$job['title'] .'</h4>
          <p style="font-size: 14px; color: #333; margin: 0; margin-bottom: 8px; ">
            ' .$job['description'] .'
          </p>
          <p style="font-size: 14px; color: #666; margin: 0; margin-bottom: 8px; ">
            <b style="color: #333;">Skills:</b> ' .$job['cat_name'] .' | ' .$job['subcategory_name'] .'
          </p>
        </td>
        <td style="border:1px solid #E1E1E1; padding:10px 15px; width: 25%;  vertical-align: top;">
          <h4 style="font-size:18px; margin: 0; margin-bottom: 8px; color: #333;">£' .$job['budget'] .' GBP</h4>
          <a href="' .site_url() .'proposals?post_id=' .$job['job_id'] .'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Quote Now</a>
        </td>
      </tr>
    </table>';
  }




}	