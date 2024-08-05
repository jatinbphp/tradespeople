<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller
{ 
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('search_model');
		$this->words = array('gmail.com','yahoo.com','yahoo','gmail','skype','hotmail','live','phone numbers','phone number','outlook','icloud mail','yahoo! mail','yahoo mail','aol mail','gmx','yandex','mail','lycos','protonmail','proton mail','tutanota','zoho mail','zohomail','077','074','020','0','1','2','3','4','5','6','7','8','9','@','www','http://','https://','.com','.uk','.co.uk','.gov.uk','.me.uk','.ac.uk','.org.uk','.Itd.uk','.mod.uk ','.mil.uk','.net.uk','.nic.uk','.nhs.uk','.pic.uk','.sch.uk','.pic.uk:','.info','.io','.cloud','.online','.ai','.net','.org');
			error_reporting(0);
			if($this->session->userdata('user_id')){
				$user_id = $this->session->userdata('user_id');
				if(!empty($user_id)){
					$user_profile = $this->common_model->get_single_data('users',array('id'=>$user_id));

					if(empty($user_profile)){
						$this->session->sess_destroy();
						redirect('login');
					}
				}
			}
	}
	public function check_login() {
		if(!$this->session->userdata('user_logIn')){
			redirect('login?redirectUrl='.base64_encode($_SERVER['REDIRECT_SCRIPT_URI'].'?'.$_SERVER['QUERY_STRING']));
		}
	}


	public function check_profile_content(){
		
		$post_code = $this->input->post('post_code');
			
		$post_code = str_replace(" ","",$post_code);
		
		$check_postcode = $this->common_model->check_postalcode($post_code);
		
		if($check_postcode['status']==1){
			
			$work_history = strtolower($this->input->post('work_history'));
			$about_business = strtolower($this->input->post('about_business'));
		
			$status = 1;
			
			foreach ($this->words as $url) {
				
				if (strpos($about_business, $url) !== FALSE) {
					$json['block_word'] = $url;
					$status = 2; break;
				}
				
				if(!in_array($url,['0','1','2','3','4','5','6','7','8','9'])){
					if (strpos($work_history, $url) !== FALSE) {
						$json['block_word'] = $url;
						$status = 3; break;
					}	
				}
			}			
			
			$json['status'] = $status;
			
		} else {
			$json['status'] = 0;
		}
		
		echo json_encode($json);
	}
	public function marketers_payouts(){
		$transfer_type = $_POST['transfer_type'];
		$amount = $_POST['amount'];
		$paypal_email_address = $_POST['paypal_email_address'];
		$user_id = $this->session->userdata('user_id');
		
		$check = $this->db->where('user_id', $user_id)->where('status', 0)->get('referral_payout_requests')->row();

		if(!empty($check)){
			$this->session->set_flashdata('success', '<div class="alert alert-danger">You can not make new request while your previous request is pending..</div>');
			echo json_encode('2'); die;
		}
		$this->common_model->marketers_payouts($transfer_type,$amount,$account_number='',$bank_name='',$sort_code='',$account_holder_name='',$paypal_email_address);
		$get_user=$this->common_model->get_single_data('users', array('id'=>$user_id));
		$subject = "Your earnings withdrawal request has been received!";
		$html = '<p style="margin:0;padding:10px 0px">Hi '.$get_user['f_name'].'!</p><br>';
		$html .= '<p style="margin:0;padding:10px 0px">We’ve received your earnings payout request and are on it.</p><br>';
		$html.='Requested amoun: £ '.$amount.'<br>';
		$html.='Payment method: '.$transfer_type.'<br>';
		$html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';
		
		$this->common_model->send_mail($get_user['email'],$subject,$html);

		$this->session->set_flashdata('success', '<div class="alert alert-success">Your payout requested has been received and will be processed within 48 hours</div>');
		
		echo json_encode(1); die;
	}

	public function users_payouts(){
		$transfer_type = $_POST['transfer_type'];
		$amount = $_POST['amount'];
		$user_id = $this->session->userdata('user_id');
		$check = $this->db->where('user_id', $user_id)->where('status', 0)->get('referral_payout_requests')->row();

		if(!empty($check)){
			$this->session->set_flashdata('success', '<div class="alert alert-danger">You can not make new request while your previous request is pending..</div>');
			echo json_encode('2'); die;
		}
		$this->common_model->users_payouts($transfer_type,$amount);

		$get_user=$this->common_model->get_single_data('users', array('id'=>$user_id));
		$subject = "Your earnings withdrawal request has been received!";
		$html = '<p style="margin:0;padding:10px 0px">Hi '.$get_user['f_name'].'!</p><br>';
		$html .= '<p style="margin:0;padding:10px 0px">We’ve received your earnings payout request and are on it.</p><br>';
		$html.='Requested amoun: £ '.$amount.'<br>';
		$html.='Payment method: '.$transfer_type.'<br>';
		$html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';
		
		$this->common_model->send_mail($get_user['email'],$subject,$html);
		
		$this->session->set_flashdata('success', '<div class="alert alert-success">Your payout requested has been received and will be processed within 48 hours</div>');
		echo json_encode(1); die;
	}

	public function user_wallet_payouts(){
		$amount = $this->input->post('amount');
		$user_id = $this->session->userdata('user_id');
		
		$type = $this->session->userdata('type');
		$this->common_model->users_payouts('Wallet request',$amount);
		if($type==1){
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Your referral earnings has been added to your wallet successfully. You can now use it to pay for your quote</div>');
		}elseif($type==2){
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Your referral earnings has been added to your wallet successfully. You can now pay for your job using them</div>');
		}else{
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Request has been submitted successfully..</div>');
		}

		echo json_encode('1'); die;
	}

	public function give_invited_review() {

		$userid = $this->session->userdata('user_id');
		$posted_by=$this->input->post('posted_by');
		$is_invited=$this->input->post('is_invited');
		$bid_by=$this->input->post('bid_by');
		
		if($userid == $bid_by) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">You can\'t review to your self.</div>';
		} else {
		
			$id=$this->input->post('job_id');
			
			 
			$rt_rate=$this->input->post('rt_rate');
			 
			$rt_comment=$this->input->post('rt_comment');
			 
			$data = array(
				'rt_rateBy'=>$userid, 
				'rt_rateTo'=>$bid_by,
				'rt_jobid'=>$id,
				'rt_rate'=> $rt_rate,
				'rt_comment'=> $rt_comment,
				'rt_create' =>date('Y-m-d H:i:s')
			);
							
			$run1 = $this->common_model->insert('rating_table',$data);
			if($run1) {
				
				$get_avg_rating=$this->common_model->get_avg_rating($bid_by);
				$avg= $get_avg_rating[0]['avg'];
				$get_user=$this->common_model->get_single_data('users',array('id'=>$bid_by));
				$review=$get_user['total_reviews'];
				$update2['average_rate']=$avg;
				$update2['total_reviews']=$review+1;
				$runss1 = $this->common_model->update('users',array('id'=>$bid_by),$update2);
				$this->common_model->update('review_invitation',array('id'=>$is_invited),array('status'=>1,'invite_to'=>$userid));
				
				$json['status'] = 1;
				$this->session->set_flashdata('success1', 'Success! Rating has been submitted successfully.');
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong.Please try again later.</div>';
			}	
		
		}

		
		echo json_encode($json);
	}

  public function get_home_email_by_job_id() {
		$id = $this->input->post('id');
		$data = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$id),array('title','job_id','userid','(select f_name from users where users.id = tbl_jobs.userid) as f_name','(select l_name from users where users.id = tbl_jobs.userid) as l_name','(select email from users where users.id = tbl_jobs.userid) as email'));
		
		if($data){
			$json['status'] = 1;
			$json['userid'] = $data['userid'];
			$json['f_name'] = $data['f_name'];
			$json['l_name'] = $data['l_name'];
			$json['email'] = $data['email'];
		} else {
			$json['status'] = 0;
		}
		echo json_encode($json);
	}	

  
 
  public function review_invitation() {
		
		if($this->session->userdata('user_id')){
			$invite_by = $_GET['invite_by'];
			$id = $_GET['is_invited'];


			$page['status'] = 0;
			
			$data = $this->common_model->get_single_data('review_invitation',array('id'=>$id));
			
			if($data){
				/*if($data['status']==0){
					
					$page['status'] = 1;
					$page['invite_by'] = $invite_by;
					$page['data'] = $data;
					
				} else {
					$page['msg'] = '<div class="alert alert-danger">You have aleady submitted your reviews</div>';
				}*/
				
				$page['status'] = 1;
				$page['invite_by'] = $invite_by;
				$page['data'] = $data;
				
			} else {
				$page['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
			}
			
			$this->load->view('site/review-invitation',$page);
			
		} else {
			redirect('login?redirectUrl='.base64_encode($_SERVER['REDIRECT_SCRIPT_URI'].'?'.$_SERVER['QUERY_STRING']));
		}
	}
 
	public function send_review_invitation() {
		$review_email = $this->input->post('review_email');
		$review_id = $this->input->post('review_id');
		$f_name = $this->input->post('f_name');
		$l_name = $this->input->post('l_name');
		$id = $this->input->post('review_job');
		
		$user_id = $this->session->userdata('user_id');
		
		$job = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$id),array('title','awarded_time'));
		
		//if($job){
			$today = date('Y-m-d');
			$check_date = date('Y-m-d',strtotime($today.' - 3 day'));
			
			if($job){
				$awarded_time = date('Y-m-d',strtotime($job['awarded_time']));
				
				//14-06-22
				//12-16-22
				
				if(strtotime($check_date) <= strtotime($awarded_time)){
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">You can´t send the invitation until after 3 days of job acceptance</div>';
					
					echo json_encode($json);
					exit();
				}
				
			}
			
			
			$reciever = $this->common_model->GetColumnName('users',array('email'=>$review_email),array('f_name','id'));
				
			$sender = $this->common_model->GetColumnName('users',array('id'=>$user_id),array('f_name','l_name','trading_name'));
					
			$insert['invite_by'] = $user_id;
			$insert['invite_to'] = ($reciever) ? $reciever['id'] : 0;
			$insert['email'] = $review_email;
			$insert['job_id'] = $id;
			$insert['status'] = 0;
			$insert['create_date'] = date('Y-m-d H:i:s');
			$insert['update_date'] = date('Y-m-d H:i:s');
				
			$run = $this->common_model->insert('review_invitation',$insert);
				
				/*if($id){
					$link = site_url().'reviews/?post_id='.$id.'&is_invited='.$run;
				} else {
					$link = site_url().'review-invitation/?invite_by='.$user_id.'&is_invited='.$run;
				}*/
			$link = site_url().'review-invitation/?invite_by='.$user_id.'&is_invited='.$run;
				
			$subject = "Provide feedback for ".$sender['trading_name'];

			$html = '<p style="margin:0;padding:10px 0px">Hi '.$f_name.' '.$l_name.'!</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Congratulations on completing your job with '.$sender['trading_name'].'. Please leave feedback for them to help other TradespeopleHub members know what it was like to work with them.</p>';
 
			$html .= '<br><div style="text-align:center"><a href="'.$link.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div><br>';

			$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($review_email,$subject,$html);
				
			$json['status'] = 1;
			$json['msg'] = '<div class="alert alert-success">Invitation has been sent successfully.</div>';
			
		/*} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">Something went wrong, try gain later.</div>';
		}*/
		
		echo json_encode($json);
		
	}
  	public function dashboard(){
    	if(isset($_GET['reject_reason'])){
      		$this->session->set_flashdata('reject_reason', $_GET['reject_reason']);
      		redirect('dashboard');
    	}
    	if(!$this->session->userdata('user_id')){
      		redirect('login');
    	} else {
			
			if($this->session->userdata('type')==3){
				redirect('affiliate-dashboard');
				exit();
			}
			
	  	$user_id = $this->session->userdata('user_id');
	  	$data['category']=$this->common_model->get_all_category('category');
	  	$user_profile=$this->common_model->get_single_data('users',array('id'=>$user_id));
	  	$data['user_profile']=$user_profile;

	  	$category = $user_profile['category'];			
			$postal_code1 = $data['user_profile']['postal_code'];
			$postal_code2 = str_replace(" ","",$postal_code1);
				
		  if($category) {
					
				$get_commision=$this->common_model->get_commision(); 
				$closed_date=$get_commision[0]['closed_date'];
				$today = date('Y-m-d');				
				$datesss= date('Y-m-d', strtotime($today. ' - '.$closed_date.' days'));
					
				//$where = "category IN ($category) and (status=0 or status=1 or status=2 or status=3 or  status=4 or status=7 or status=5 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and DATE(c_date) > DATE('".$datesss."')";
					
					
				$where = "(status=0 or status=1 or status=2 or status=3 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and DATE(c_date) > DATE('".$datesss."')";
					
				$latitude = ($user_profile['latitude'] == '')?0:$user_profile['latitude'];
				$longitude = ($user_profile['longitude'] == '')?0:$user_profile['longitude'];
				$max_distance = $user_profile['max_distance'];
					
				$distance = ", 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(".$latitude.")) * COS(RADIANS(tbl_jobs.latitude)) * COS(RADIANS(".$longitude." - tbl_jobs.longitude)) + SIN(RADIANS(".$latitude.")) * SIN(RADIANS(tbl_jobs.latitude))))) AS distance_in_km";
					
				$sql ="select *$distance from tbl_jobs where $where HAVING distance_in_km <= '".$max_distance."' order by c_date desc limit 15";
					
				$run = $this->db->query($sql);
					
				$bids = array();
					
				if($run->num_rows() > 0){  
					$bids = $run->result_array(); 
				}
					//echo '<pre>'; print_r($bids); echo '</pre>';
		    	//$data['bids']=$this->common_model->get_all_data('tbl_jobs',$where,'c_date','desc',15);
	    	$data['bids']=$bids;
				
	    	$data['bidsss']=$this->common_model->get_user_jobs_bycatid1('tbl_jobs',$category);
	    	$data['work_progress']=$this->common_model->get_trades_working_progress('tbl_jobpost_bids',$user_id); 
	    	$data['complete']=$this->common_model->get_complete_job_byid('tbl_jobs',$category);
	    	$data['dispute_miles']=$this->common_model->get_tradesdispute_milestones(); 
		  }    
   
  		$data['progress']=$this->get_progress_data();
  		$data['posts']=$this->common_model->get_post_jobs('tbl_jobs',$this->session->userdata('user_id'));
  		//$data['notification']=$this->common_model->get_all_notification('notification',$this->session->userdata('user_id'));
  		$data['trade_news']=$this->common_model->get_notification_trades('notification',$this->session->userdata('user_id'));     
   		// $data['referrals_earn_list'] = $this->db->get('referrals_earn_list')->result();	
   		$data['setting']=$this->common_model->get_all_data('admin');
   		$data['total_sale'] = $this->common_model->get_total_sale($user_id);
   		$data['total_open_order'] = $this->common_model->get_total_open_order($user_id);
   		$data['all_active_order'] = $this->common_model->getActiveOrder('service_order',$user_id,6);
   		$data['recently_viewed'] = $this->common_model->recentlyViewedService($user_id);

  		$this->load->view('site/dashboard',$data);
  	}
	}
	
	public function affiliate_dashboard(){
    
    if(!$this->session->userdata('user_id')){
      redirect('login');
    } else {
			
			if($this->session->userdata('type')!=3){
				redirect('dashboard');
				exit();
			}
			
      $user_id = $this->session->userdata('user_id');
      $user_profile=$this->common_model->get_single_data('users',array('id'=>$user_id));
      $data['user_profile']=$user_profile;
    
			
      $data['marketers_account_info']=$this->common_model->marketers_account_info($user_id);
			
      $data['min_cashout']=$this->common_model->get_min_cashout($user_id);
      $data['balance_amount']=$this->common_model->get_balance_amount($user_id);
      $data['marketers_referrals_list']=$this->common_model->marketers_referrals_list();
   
      
      $data['county']=$this->common_model->get_countries();
 			
       $data['settings'] = $this->common_model->get_single_data("admin_settings", array("id"=>1)); 

			$data['payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id], 'id', 'desc');
			$data['affilateMeata'] = $this->common_model->get_single_data('other_content',array('id'=>5));
			$data['contact_list']=$this->db->query("SELECT * from contact_request where user_id=$user_id OR user_id=0 AND reply_id=$user_id OR reply_id=0 order by id desc")->result_array();
			// echo $this->db->last_query();
      //  echo "<pre>"; print_r($data['contact_list']); exit;

			$data['paymentSettings']=$this->common_model->get_all_data('admin');	
      $this->load->view('site/affiliate-dashboard',$data);
    }
  }
  public function support_msg_unread()
  {
  	$unreadMessages = $this->common_model->check_admin_unread('admin_chat_details', array('is_read' => 0, 'receiver_id' => $this->session->userdata('user_id')), 'is_read');
  	echo json_encode(['status'=>1, 'unreadMessages'=>$unreadMessages]);
  }

  public function mark_read()
	{
		$result=$this->db->where('id', $this->input->post('row_id'))->update('contact_request', ['status'=>1]); 
		echo json_encode(1);
	}

	public function delete_request()
	{
		$this->db->where('id', $this->input->post('row_id'))->delete('contact_request');
		echo json_encode(1);
	}

	function send_mail()
	{
		

		$user_data = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
		$admin = $this->common_model->get_single_data('admin', array('id' =>1));
		
		$subject = $this->input->post('subject');
		$message=$this->input->post('message');
		$f_name=$user_data['f_name'];
		$l_name=$user_data['l_name'];
		$email=$user_data['email'];
		$phone_no=$user_data['phone_no'];
		$contant= 'Hi '.$f_name.', <br><br>';
		$contant.=$message;	
		// echo "<pre>";
	

		// $send = $this->common_model->send_mail($admin['email'],$subject,$contant);
		// print_r($send); 
		// exit;
		// 	if($send)
		// 	{
				$this->db->insert('contact_request', ['first_name'=>$f_name, 'last_name'=>$l_name, 'email'=>$email, 'user_id'=>$user_data, 'user_id'=>$this->session->userdata('user_id'), 'phone_no'=>$phone_no, 'cdate'=>date('Y-m-d H:i:s'), 'message'=>$message, 'type'=>3, 'status'=>0]);

				$this->session->set_flashdata('success', 'Success! Request has been replied successfully.');
			// }    
			// else     
			// {
			// 	$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');
				
			// }
			return redirect('affiliate-dashboard');
	} 


	public function update_notification_status($status){
		
		$id = $this->session->userdata('user_id');
		
		$insert['notification_status'] = $status;
		
		$run = $this->common_model->update('users',array('id'=>$id),$insert);

		if($status==1) {
			$this->session->set_flashdata('my_msg','<p class="alert alert-success">Notifications are activated successfully.</p>');
		} else {
			$this->session->set_flashdata('my_msg','<p class="alert alert-success">Notifications are deactivated successfully.</p>');
		}
		
		if(isset($_GET['redirectUrl']) && !empty($_GET['redirectUrl'])){
			redirect($_GET['redirectUrl']);
		} else {
			redirect('dashboard');
		}
	}
	public function update_notification(){
	
		$insert['nt_satus']=1;
		$run = $this->common_model->update('notification',array('nt_userId'=>$this->session->userdata('user_id')),$insert);
		$json['status']=1;
		if($run) {
			$json['status']=1;
		} else {
			$json['status']=0;
		}

		echo json_encode($json);
	}
	public function notifications() {
		// echo $this->session->userdata('user_id'); exit;
		if($this->session->userdata('user_id')) {
			$data['trade_news']=$this->common_model->get_notification_trades1('notification',$this->session->userdata('user_id'));
			$this->load->view('site/notifications',$data);
		} else {
			redirect('login');
		}
	}
	
	public function submit_verify_phone() {
		
    $verification_code = $this->input->post('verification_code');
		$user_id = $this->session->userdata('user_id');
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		
    if($verification_code == $user_data['phone_code']){
      $user_id = $this->session->userdata('user_id');
      $update['is_phone_verified'] = 1;
      $run = $this->common_model->update('users', array('id' => $user_id), $update);
			$subject = "Phone number verified successfully";
			$html = '<h2 style="margin:0;font-size:22px;padding-bottom:5px;color:#2875d7">Phone number verified successfully</h2><p style="margin:0;padding:20px 0px">This is mail to informed you that your phone number has been verified successfully.</p>';
			$sent = $this->common_model->send_mail($user_data['email'],$subject,$html);
			if($this->session->userdata('homeowner_signup')){
				$json['status'] = 2;
			} else {
				$json['status'] = 1;
			}
      
    }else{
      $json['status'] = 0;
    }
    echo json_encode($json);
  }

	public function verify_phone($id=null) {
		$user_id = $this->session->userdata('user_id');
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		if($user_data && $user_data['is_phone_verified'] != 1){
			$code = rand(1000,9999);
			$msg = "Your verification code is: ".$code." \r\n Tradespeoplehub.co.uk";
			$this->common_model->update("users",array('id'=>$user_data['id']),array('phone_code'=>$code));
			$this->load->model('send_sms');
			//$this->send_sms->send_india($user_data['phone_no'],$msg);
			$this->send_sms->send($user_data['phone_no'],$msg);	
			$this->load->view('site/verify_phone');
		}else{
			redirect('dashboard');
		}
   }
   public function not_verify_phone() {
			redirect('dashboard');
   }
		
	public function get_unread_ontification() {
		$where = array('nt_userId'=>$this->session->userdata('user_id'),'nt_satus'=>0);     
		$unread_notCount =  $this->common_model->get_data('notification',$where);
		$json['unread'] = (count($unread_notCount))?count($unread_notCount):'';
		$json['data'] = "";
	
		$Latest_five_notif = $this->common_model->Latest_five_notif($this->session->userdata('user_id'));
             	
		if($Latest_five_notif) {
			$json['status']=1;
			foreach($Latest_five_notif as $row){
				$style = ($row['nt_satus']==0)?'unread':'';
				$json['data'] .= '<li class="'.$style.' notification-box">
					<div class="row">
						<div class="col-lg-11 col-sm-11 col-11" style="margin-left: 10px;">
							'.$row['nt_message'].'
						</div>    
					</div>
				</li>';
			}
		} else {
			$json['status']=0;
		}
		$json['status']=0;
		echo json_encode($json);
	}

	public function my_account() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$data['category']=$this->common_model->get_all_category('category');
			
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			$category=$data['user_profile']['category'];
			if($category) {
				$data['bids']=$this->common_model->get_user_jobs_bycatid('tbl_jobs',$category);
			}
			$data['setting'] = $this->common_model->get_single_data('admin',array('id'=>1));
			$data['work_progress']=$this->common_model->recent_work_in_progress('tbl_jobs',$this->session->userdata('user_id'));
			$data['completed_jobs']=$this->common_model->get_completed_jobs('tbl_jobs',$this->session->userdata('user_id'));
			$data['dispute_miles']=$this->common_model->get_dispute_milestones();
			//$data['progress']=$this->get_progress_data();
			$data['posts']=$this->common_model->get_post_jobs('tbl_jobs',$this->session->userdata('user_id'));
			$data['notification']=$this->common_model->get_all_notification('notification',$this->session->userdata('user_id'));
			$this->load->view('site/my_account',$data);
		}
	}

  public function profiles($id){
    $data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$id));
    $data['education']=$this->common_model->get_education('user_education',$id);
    $data['certificate']=$this->common_model->get_education('user_certification',$id);
    $data['portfolio']=$this->common_model->get_education('user_portfolio',$id);
    $data['skills']=$this->common_model->getRows('tbl_skills');
    $data['category']=$this->common_model->getRows('category');
    $data['check']=$check;
    $this->load->view('site/profile',$data);
  }

  public function profile($id){
    $pagedata['user_profile']=$this->common_model->get_single_data('users',array('id'=>$id));
    if(empty($pagedata['user_profile'])) redirect ('find-tradesmen');
    $pagedata['my_services']=$this->common_model->get_my_service('my_services',$id);

    

    $pagedata['publications']=$this->common_model->get_education('user_publication',$id);
    $pagedata['portfolio']=$this->common_model->get_education('user_portfolio',$id);
    $pagedata['category']=$this->common_model->GetAllData('category');
    $pagedata['check']=$check;
		
		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		$perPage = 5;
		
		$conditions['search']['userid'] = $id;
		
		$totalRec = count($this->search_model->get_rating($conditions));
		
		$pagedata['totalRec'] = $totalRec;
		
		$base_url = site_url().'users/find_rating_ajax';
		
		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		$conditions['start'] = 0;
		$conditions['limit'] = $perPage;
		
		$pagedata['get_reviews'] = $this->search_model->get_rating($conditions);
		if($pagedata['user_profile']['type']==1){
			$this->load->view('site/profile2',$pagedata);
		} else {
			$this->load->view('site/profile',$pagedata);
		}
  }
	
	public function show_tradesment_profile($id=null) {
		$pagedata['user_profile']=$this->common_model->get_single_data('users',array('id'=>$id));
		
    $pagedata['portfolio']=$this->common_model->get_education('user_portfolio',$id);
    // $pagedata['category']=$this->common_model->get_parent_category('category');
    $pagedata['category']=$this->common_model->GetAllData('category');
    

		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		$perPage = 5;
		
		$conditions['search']['userid'] = $id;
		
		$totalRec = count($this->search_model->get_rating($conditions));
		
		$pagedata['totalRec'] = $totalRec;
		
		$base_url = site_url().'users/find_rating_ajax';
		
		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		$conditions['start'] = 0;
		$conditions['limit'] = $perPage;
		
		$pagedata['get_reviews'] = $this->search_model->get_rating($conditions);
		
		
		$this->load->view('site/side_profile_view',$pagedata);
	}
	
	public function find_rating_ajax($x=null) {
		
		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		
		$pagedata = array();
		$conditions = array();
		
		$page = $this->input->post('page_num');
		if(!$page){
				$offset = 0;
		}else{
				$offset = $page;
		}
		
		//$category_details = $this->common_model->get_single_data('category',array('slug'=>$cat_name));
		
		$userid = $this->input->post('userid');
		
		$user_profile = $this->common_model->get_single_data('users',array('id'=>$userid));
		
		$conditions['search']['userid'] = $userid;
		
		$totalRec = count($this->search_model->get_rating($conditions));
		
		$pagedata['totalRec'] = $totalRec;
		
		$base_url = site_url().'users/find_rating_ajax';

		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = 5;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		$conditions['start'] = $offset;
		$conditions['limit'] = 5;
		
		$get_reviews = $this->search_model->get_rating($conditions);
	
		$json['data'] = '';
		
		if(count($get_reviews)>0){ 
		$json['data'] .= '<div class="review-pro">
                  <div class=" dashboard-profile edit-pro89">
                     <h2>Reviews</h2>
                  </div>
				  
                  <div class="min_h3">';
		
		foreach ($get_reviews as $r) {
			
		$job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
		
		$get_users = $this->common_model->get_single_data('users',array('id'=>$r['rt_rateBy']));
		
		$trading_name = ($get_users['type']==1) ? $get_users['trading_name'] : $user_profile['trading_name'] ;
                      
						
			$json['data'] .= '<div class="tradesman-feedback">
			  <div class="set-gray-box">
			  <p class="recent-feedback">';
				if($job_title['direct_hired']==1){
				$json['data'] .= '<h4>Work for '.$trading_name.'</h4>';	
				} else if($job_title['title']){
					$json['data'] .= '<h4>'.$job_title['title'].'</h4>';
				} else { 
					$json['data'] .= '<h4>Work for '.$trading_name.'</h4>';
					 } 
					$json['data'] .= '</p>
				 <div class="from-group revie">
					<span class="btn btn-warning btn-xs">';
					
					if($r['rt_rate']!=''){ 
					$json['data'] .= $r['rt_rate']; 
					} 
					$json['data'] .= '</span>
					<span class="star_r">';
					 
					   for($i=1;$i<=5;$i++){
								   if($r['rt_rate']) {
					   if($i<=$r['rt_rate']) {  
					$json['data'] .= '<i class="fa fa-star active"></i>';
					  } else{ 
					$json['data'] .= '<i class="fa fa-star"></i>';
				 } } else  {  
					$json['data'] .= '<i class="fa fa-star"></i>';
				 } 
					 } 
					$json['data'] .= '</span>
				 </div>
                <div cite="/job/view/5059288" class="summary">
                  <p>'.$r['rt_comment'].'</p>
                </div>
                <p class="tradesman-feedback__meta">By <strong class="job-author">'.$get_users['f_name'].' '.$get_users['l_name'].'</strong>&nbsp;on
                 
                  <em class="job-date">';
				
                     $time_ago = $this->common_model->time_ago($r['rt_create']); 
                 
                    $json['data'] .= $time_ago;
					$json['data'] .= '</em>
                </p>
              </div>
              </div>';
				}	
				
		
		$json['data'] .= '<hr>
                  </div>
               </div>';
		$json['data'] .= $this->ajax_pagination->create_links();
		}else{
			$json['data'] .= '<p class="alert alert-danger">No data found.</p>';
		}
		
		
		echo json_encode($json);

	}
	
	
	public function find_rating_ajax_project_detail($x=null) {
		
		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		
		$pagedata = array();
		$conditions = array();
		
		$page = $this->input->post('page_num');
		if(!$page){
				$offset = 0;
		}else{
				$offset = $page;
		}
		
		//$category_details = $this->common_model->get_single_data('category',array('slug'=>$cat_name));
		
		$userid = $this->input->post('userid');
		
		$user_profile = $this->common_model->get_single_data('users',array('id'=>$userid));
		
		$conditions['search']['userid'] = $userid;
		
		$totalRec = count($this->search_model->get_rating($conditions));
		
		$pagedata['totalRec'] = $totalRec;
		
		$base_url = site_url().'users/find_rating_ajax';

		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = 1;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		$conditions['start'] = $offset;
		$conditions['limit'] = 1;
		
		$get_reviews = $this->search_model->get_rating($conditions);
	
		$json['data'] = '';
		
		if(count($get_reviews)>0){ 
		$json['data'] .= '<div class=" dashboard-profile ">
						<h2>Recent reviews</h2>
							<div class="min_h3">';
		
		foreach ($get_reviews as $r) {
			
		$job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
		
		$get_users = $this->common_model->get_single_data('users',array('id'=>$r['rt_rateBy']));
		
		$trading_name = ($get_users['type']==1) ? $get_users['trading_name'] : $user_profile['trading_name'] ;
                      
						
			$json['data'] .= '<div class="tradesman-feedback">
			  <div class="set-gray-box">
				 <div class="from-group revie">
					<span class="btn btn-warning btn-xs">';
					
					if($r['rt_rate']!=''){ 
					$json['data'] .= $r['rt_rate']; 
					} 
					$json['data'] .= '</span>
					<span class="star_r">';
					 
					   for($i=1;$i<=5;$i++){
								   if($r['rt_rate']) {
					   if($i<=$r['rt_rate']) {  
					$json['data'] .= '<i class="fa fa-star active"></i>';
					  } else{ 
					$json['data'] .= '<i class="fa fa-star"></i>';
				 } } else  {  
					$json['data'] .= '<i class="fa fa-star"></i>';
				 } 
					 } 
					$json['data'] .= '</span>
				 </div>
                <div cite="/job/view/5059288" class="summary">';
                 
                        if(strlen(strip_tags($r['rt_comment'])) > 100){
                    
						$json['data'] .= '<p class="short_review_'.$serialNumber.'">'.substr(strip_tags($r['rt_comment']),0,100).'... 
                            <a onclick="$(\'.short_review_'.$serialNumber.'\').hide(); $(\'.long_review_'.$serialNumber.'\').show();" href="javascript:void(0);">read more</a>
                          </p>
                          <p class="long_review_'.$serialNumber.'" style="display:none;">'.$r['rt_comment'].'</p>';
											
                        } else {
                      
                          $json['data'] .= '<p class="long_review_'.$serialNumber.'">'.$r['rt_comment'].'</p>';
											}
                $json['data'] .= '</div>
                <p class="tradesman-feedback__meta">By <strong class="job-author">'.$get_users['f_name'].' '.$get_users['l_name'].'</strong>&nbsp;on
                 
                  <em class="job-date">';
				
                     $time_ago = $this->common_model->time_ago($r['rt_create']); 
                 
                    $json['data'] .= $time_ago;
					$json['data'] .= '</em>
                </p>
              </div>
              </div>';
				}	
				
		
			$json['data'] .= '</div>
					</div>
        </div>';
			$json['ajax_link'] = $this->ajax_pagination->create_links();
			
	}else{
			
		$json['ajax_link'] = '';
		$json['data'] .= '<p class="alert alert-danger">No data found.</p>';
	}
		
		
		echo json_encode($json);

	}
	

	public function success(){
		$type=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$page['type']=$type;
		$page['id']=$id;
		$page['payment_detail']=false;

     if($type==1  || $type==3 || $type==4 || $type==5){

	     if($type==1  || $type==3 || $type==4){
	      $where='ua_id = '.$id.'';
	      $table='users_applied';
	     }else if($type==5){
	      $where='tr_id = '.$id.'';
	      $table='transactions';
	     }

	     $payment_detail=$this->common_model->get_single_data($table,$where);
	     if($payment_detail){
					$page['payment_detail']=$payment_detail;
	     }else{
					$page['msg']="Something went wrong try again later.";
	     } 

     }else{
       $page['msg']="Something went wrong try again later.";
     }	
     //print_r($page);
     $this->load->view('site/success_payment',$page);
    }
	public function get_progress_data() {
		$user_profile=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
	
		$percentage='';
		if($user_profile['u_email_verify']==1) {
			$percentage=20; 
		}
	
		if(!empty($user_profile['phone_no'])) {
		
			$percentage=$percentage+20;
		}
		if(!empty($user_profile['profile'])) {
			
			$percentage=$percentage+15;
		}
		$get_certification=$this->common_model->get_education('user_certification',$this->session->userdata('user_id'));
		if($get_certification) {
			$percentage=$percentage+15;
		}
		$get_education=$this->common_model->get_education('user_education',$this->session->userdata('user_id'));
		if($get_education) {
			$percentage=$percentage+15;
		}
		$get_portfolio=$this->common_model->get_education('user_portfolio',$this->session->userdata('user_id'));
		if($get_portfolio) {
			$percentage=$percentage+15;
		}
		return $percentage;

	}
	public function verify() {
		$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		$this->load->view('site/account_verify',$data);
	}

	public function rejected_jobs() {
		$user_id = $this->session->userdata('user_id');
		if(!$user_id){
			redirect('login');
		} else {
			$data['category']=$this->common_model->get_all_category('category');

			$data['posts']=$this->common_model->get_all_data('tbl_jobs',array('direct_hired'=>1,'userid'=>$user_id,'is_delete'=>0,'status'=>8),'job_id');
			$this->load->view('site/rejected_jobs',$data);
		}

	}
	public function my_posts() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			//	$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts']=$this->common_model->get_open_projects('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/my_post_page',$data);
		}
	}
	public function in_progress() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			//$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts']=$this->common_model->get_job_in_progress('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/in_progress_jobs',$data);
		}
	}
	public function completed_jobs() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			//	$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts']=$this->common_model->get_completed_jobs('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/completed-jobs',$data);
		}
	}
	public function disputed_milestones() {
		if($this->session->userdata('user_id')) {
			if($this->session->userdata('type')==1) {
				$data['dispute_miles']=$this->common_model->get_tradesdispute_milestones();
			} else {
				$data['dispute_miles']=$this->common_model->get_dispute_milestones();
			}
		
			$this->load->view('site/disputed_milestones',$data);
		} else {
			redirect('login');
		}
	}
	public function rewards(){
		if($this->session->userdata('user_id')) {
			$data['rewards']=$this->common_model->get_user_rewards($this->session->userdata('user_id'));
			$this->load->view('site/rewards',$data);
		} else {
			redirect('login');
		}
	}
	public function jobs_completed() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['posts']=$this->common_model->get_completed_jobs('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress',$data);
		}
	}
	public function jobs_rejected() {
		$user_id = $this->session->userdata('user_id');
		if(!$user_id){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['posts']=$this->common_model->get_all_data('tbl_jobs',array('direct_hired'=>1,'userid'=>$user_id,'is_delete'=>0,'status'=>8),'job_id');
			$this->load->view('site/work_in_progress',$data);
		}
	}
	public function new_jobs() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['posts1']=$this->common_model->get_open_projects('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress',$data);
		}
	}
	public function recent_jobs() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {

			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			$category=$data['user_profile']['category']; 
			if($category) {
				//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
				$data['category']=$this->common_model->get_all_category('category');
				$data['bids']=$this->common_model->get_user_jobs_bycatid('tbl_jobs',$category,null,25);
				$data['bidsss']=$this->common_model->get_user_jobs_bycatid1('tbl_jobs',$category);
				$this->load->view('site/recent_jobs',$data);
			}
		}
	} 
public function exists_refferals() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$user_id = $this->session->userdata('user_id');
			$data['balance_amount']=$this->common_model->get_balance_amount($user_id);
			$data['min_cashout']=$this->common_model->get_min_cashout($user_id);
			$data['marketers_referrals_list']=$this->common_model->marketers_referrals_list();
			// echo $this->db->last_query();
			$data['account_info']=$this->common_model->marketers_account_info($user_id);
			$data['settings'] = $this->common_model->get_single_data("admin_settings", array("id"=>2));
			// echo "<pre>"; print_r($data); exit;
			$data['admin_settings']=$this->common_model->get_all_data('admin');
			$this->load->view('site/exists_refferals',$data);
		}
	}

	public function payout_request_list()
	{
		$user_id = $this->session->userdata('user_id');
		$data['pending_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id], 'id','desc');
		// $data['pending_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>0]);
		// $data['approved_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>1]);
		// $data['rejected_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>2]);
		$this->load->view('site/referral_payout', $data);

	}
	public function payment_settings() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			// $user_id = $this->session->userdata('user_id');
			// $data['balance_amount']=$this->common_model->get_balance_amount($user_id);
			// $data['min_cashout']=$this->common_model->get_min_cashout($user_id);
			// $data['marketers_referrals_list']=$this->common_model->marketers_referrals_list();
			$this->load->view('site/payment_settings');
		}
	}

	public function new_referral() {
		// $data['get_referral_links']=$this->common_model->get_admin_settings(); 
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$user_id = $this->session->userdata('user_id');
			$userData = $this->common_model->GetColumnName("users", array("id"=>$user_id), array("type"));
			if ($userData["type"] == 1) {
     		$data['linkSettings'] = $this->common_model->get_single_data("admin_settings", array("id"=>3));//$this->db->get('referral_setting')->first_row();
			} else if ($userData["type"] == 2) {
				$data['linkSettings'] = $this->common_model->get_single_data("admin_settings", array("id"=>2));//$this->db->get('referral_setting')->first_row();
			} 
			$this->load->view('site/new_referral',$data);
		}
	}
	public function work_in_progress() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$data['category']=$this->common_model->get_all_category('category');
			$data['work_progress']=$this->common_model->get_trades_working_progress('tbl_jobpost_bids',$this->session->userdata('user_id'));

			$this->load->view('site/trades_work_progress',$data);
		}
	}
	public function completed() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			$data['category']=$this->common_model->get_all_category('category');
			$data['completed']=$this->common_model->get_trades_completed('tbl_jobpost_bids',$this->session->userdata('user_id'));

			$this->load->view('site/trades_completed_work',$data);
		}
	}

	public function my_jobs() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			$category=$data['user_profile']['category'];
			$data['bids']=$this->common_model->get_user_jobs_bycat_id('tbl_jobs',$category);
			//$data['bids']=$this->common_model->get_user_all_bids('tbl_jobpost_bids',$this->session->userdata('user_id'));
			$this->load->view('site/my_jobs',$data);
		}
	}
	public function jobs_in_progress() {
		if(!$this->session->userdata('user_id')){
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['posts']=$this->common_model->get_job_posts_in_progress('tbl_jobs',$this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress',$data);
		}
	}
	public function my_job_bids() {
		if(!$this->session->userdata('user_id')){ 
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category']=$this->common_model->get_all_category('category');
			$data['bids']=$this->common_model->get_user_all_bids('tbl_jobpost_bids',$this->session->userdata('user_id'));
			$this->load->view('site/my_job_bids',$data);
		}
	}

  public function edit_profile(){
    if($this->session->userdata('user_id')){
      $data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
      $data['portfolio']=$this->common_model->get_education('user_portfolio',$this->session->userdata('user_id'));
	  	$data['country']=$this->common_model->newgetRows('tbl_region',array('is_delete'=>0));
      $this->load->view('site/edit_profile',$data);
    }else{
      redirect('login');
    }
  }

	public function update_profile(){
		$u_type = $this->session->userdata('type');
		 $user_id = $this->session->userdata('user_id');
		 $postal_code = $this->input->post('postal_code');


		$check_postcode = $this->common_model->check_postalcode($postal_code);

		 if($check_postcode['status']==1)
		 {		
		  	$insert['longitude'] = $check_postcode['longitude'];
			$insert['latitude'] = $check_postcode['latitude'];
		
	 	$user_profile=$this->common_model->get_data('users',array('phone_no'=>$this->input->post('phone_no')));
		
		$userprofile=$this->common_model->get_single_data('users',array('phone_no'=>$this->input->post('phone_no')));
		
		$this->form_validation->set_rules('f_name','First Name','required');
		$this->form_validation->set_rules('l_name','Last Name','required');
		// $this->form_validation->set_rules('country','Country','required');

		$this->form_validation->set_rules('locality','City','required');
		$this->form_validation->set_rules('e_address','Address','required');
// print_r($_POST); exit;

		if(count($user_profile)>=0 && $userprofile['id']!=$user_id) {
	 		$this->form_validation->set_rules('phone_no','Phone number','required|integer|is_unique[users.phone_no]',array('is_unique'=>'This phone number is already registered'));
	 	} else {
	 		$this->form_validation->set_rules('phone_no','Phone number','required|integer');
	 	}
			
		$this->form_validation->set_rules('postal_code','Postal Code','required');
			
		if($u_type==1){
			//$this->form_validation->set_rules('about_business','About Business','required');
			$this->form_validation->set_rules('trading_name','Trading Name','required');
			//$this->form_validation->set_rules('work_history','Work history','required');
		}
		
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">' .validation_errors() . '</div>');
		} else {
			
			if($_FILES['profile']['name']){ 
				$config['upload_path']="img/profile";
				$config['allowed_types'] = 'jpeg|gif|jpg|png';
				$config['encrypt_name']=true;
				$this->load->library("upload",$config);
				if ($this->upload->do_upload('profile')) {
					$profile=$this->upload->data("file_name");
					$insert['profile'] = $profile;
				} 
			}
			
			$user_id = $this->session->userdata('user_id');
				
			if($userprofile['phone_no']!=$this->input->post('phone_no')){
				$insert['is_phone_verified'] = 0;
			}
				
			$insert['f_name'] = $this->input->post('f_name');
			$insert['l_name'] = $this->input->post('l_name');
			$insert['county'] = $this->input->post('country');
			$insert['city'] = $this->input->post('locality');
			$insert['postal_code'] = $this->input->post('postal_code');
			// $insert['latitude'] = $this->input->post('latitude');
			// $insert['longitude'] = $this->input->post('longitude');

			if($u_type==1){
				
				$is_qualification = $this->input->post('is_qualification');
				
				if($is_qualification == '1'){
					$insert['qualification'] = $this->input->post('qualification');
				}
				$insurance_liability = $this->input->post('insurance_liability');
				if($insurance_liability == 'yes'){
					$insert['insurance_amount'] = $this->input->post('insurance_amount');
					$insert['insurance_date'] = $this->input->post('insurance_date');
				}
				$insert['is_qualification'] = $is_qualification;
				$insert['insurance_liability'] = $insurance_liability;
				$insert['about_business'] = $this->input->post('about_business');
				$insert['trading_name'] = $this->input->post('trading_name');
				//$insert['work_history'] = $this->input->post('work_history');
				$insert['qualification'] = $this->input->post('qualification');
			}
			
			$insert['max_distance'] = $this->input->post('distance');
			$insert['phone_no'] = $this->input->post('phone_no');
			$insert['e_address'] = $this->input->post('e_address'); 
			$insert['primary_lang'] = $this->input->post('userLanguage'); 
			$insert['secondary_lang'] = $this->input->post('second_lang');
			$insert['hourly_rate']=$this->input->post('hourly_rate');
			
			$run = $this->common_model->update('users',array('id'=>$user_id),$insert);

			if($run){
				$this->session->set_flashdata('msg','<div class="alert alert-success">Your profile has been updated successfully.</div>');
			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">We have not found any changes.</div>');
			}
		}

	     } else 
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Please enter valid UK postcode</div>');
			}
			
		redirect('edit-profile'); 
	
	}
	public function update_marketer_profile(){
		$user_id = $this->session->userdata('user_id');
		$insert['u_website'] = $this->input->post('u_website');
		$insert['f_name'] = $this->input->post('f_name');
		$insert['l_name'] = $this->input->post('l_name');
		$insert['e_address'] = $this->input->post('e_address');
		$insert['county'] = $this->input->post('country');
		$insert['city'] = $this->input->post('locality');
		$insert['postal_code'] = $this->input->post('postal_code');
		$insert['email'] = $this->input->post('email');
		$insert['phone_no'] = $this->input->post('phone_no');
		$u_profile_old = $this->input->post('u_profile_old');
		 	if($_FILES['profile']['name']){ 
				$config['upload_path']="img/profile";
				$config['allowed_types'] = 'jpeg|gif|jpg|png';
				$config['encrypt_name']=true;
				$this->load->library("upload",$config);
				if ($this->upload->do_upload('profile')) {
					$profile=$this->upload->data("file_name");
					$insert['profile'] = $profile;
				} 
			}
		 	$this->common_model->update('users',array('id'=>$user_id),$insert);
		 	echo json_encode('1');
		 		die(); 
	}	
	public function update_marketers_account_details_old(){
		$user_id = $this->session->userdata('user_id');
		$insert['account_holder_name'] = $this->input->post('account_holder_name');
		$insert['account_holder_address'] = $this->input->post('account_holder_address');
		$insert['account_number'] = $this->input->post('account_number');
		$insert['sort_code'] = $this->input->post('sort_code');
		$insert['bank_name'] = $this->input->post('bank_name');
		$insert['paypal_email_address'] = $this->input->post('paypal_email_address');
		$this->common_model->update('marketers_account_info',array('user_id'=>$user_id),$insert);

		 	echo json_encode('1');
		 		die();
	}

	public function update_marketers_account_details(){
		$user_id = $this->session->userdata('user_id');
		$insert['wd_account_holder'] = $this->input->post('account_holder_name');
		$insert['wd_bank'] = $this->input->post('bank_name');
		$insert['wd_account'] = $this->input->post('account_number');
		$insert['wd_ifsc_code'] = $this->input->post('sort_code');
		
		$insert['account_holder_address'] = $this->input->post('account_holder_address');
		$insert['paypal_email_address'] = $this->input->post('paypal_email_address');
		$check =$this->common_model->get_single_data('wd_bank_details', array('wd_user_id'=>$user_id));
		if(!empty($check)){
				$this->common_model->update('wd_bank_details',array('wd_user_id'=>$user_id),$insert);
					$this->session->set_flashdata('success', '<div class="alert alert-success">Success! payment setting has been updated successfully..</div>');
		}else{
			$insert['wd_user_id'] =$user_id;
			$this->common_model->insert('wd_bank_details', $insert);
			$this->session->set_flashdata('success', '<div class="alert alert-success">Success! payment setting has been inserted successfully..</div>');
		}
	 	echo json_encode('1');
	 	die();
	}


	public function reset_password(){
		$user_id = $this->session->userdata('user_id');
		$insert['password'] = $this->input->post('password');
		 	$this->common_model->update('users',array('id'=>$user_id),$insert);
		 	echo json_encode('1');
		 		die();
	}
	public function trades() {
		if($this->session->userdata('user_id')) {
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			 $data['parent_category']=$this->common_model->get_parent_category('category');
			 $data['category']=$this->common_model->GetAllData('category');
			$this->load->view('site/user_category',$data);
		} else {
			redirect('login');
		}
	}
	public function company() {
		if($this->session->userdata('user_id')) {
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
			$this->load->view('site/company_page',$data);
		} else {
			redirect('login');
		}
	}
	public function update_company() {
		$user_id=$this->session->userdata('user_id');
		$insert['company'] = $this->input->post('company');
		$insert['business_type'] = $this->input->post('business_type');
		$insert['no_of_employee']=$this->input->post('no_of_employee');
		$insert['active_since']=$this->input->post('active_since');
		$insert['u_website']=$this->input->post('u_website');
		$run = $this->common_model->update('users',array('id'=>$user_id),$insert);
		if($run){
			$this->session->set_flashdata('msg','<div class="alert alert-success">Company Details updated successfully.</div>');
		} else {
			$this->session->set_flashdata('msg','<div class="alert alert-danger">We have not found any changes.</div>');
		}
		redirect('company');
	}
	public function change_password() {
		$this->load->view('site/change-password');
	}
	public function upload_address($userid,$page=null) {
		if($_FILES['u_address']['name']) {
			$ext=end(explode(".",$_FILES['u_address']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['u_address']['tmp_name'],'img/verify/'.$files)) {
				$insert['u_address']=$files;
				$insert['u_status_add']=1;
				$insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users',array('id'=>$userid),$insert);
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		if($run) {
			$sub='New document uploaded for address verification';
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>".$get_users['f_name'].' '.$get_users['l_name']."</p><p><b>Email ID : </b>".$get_users['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p>";
			if($files){
				$mail_responce=$this->common_model->send_mail_file($to,$sub,$body,$files); 
			}else{
				$mail_responce=$this->common_model->send_mail($to,$sub,$body); 
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if($page){
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}

	public function upload_idcard($userid,$page=null) {
		if($_FILES['u_id_card']['name']) {
			$ext=end(explode(".",$_FILES['u_id_card']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['u_id_card']['tmp_name'],'img/verify/'.$files)) {
				$insert['u_id_card']=$files;
				$insert['u_id_card_status']=1;
        $insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users',array('id'=>$userid),$insert);
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		if($run) {
			$sub='New document uploaded for address verification';
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>".$get_users['f_name'].' '.$get_users['l_name']."</p><p><b>Email ID : </b>".$get_users['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p>";
			if($files){
				$mail_responce=$this->common_model->send_mail_file($to,$sub,$body,$files); 
			}else{
				$mail_responce=$this->common_model->send_mail($to,$sub,$body); 
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if($page){
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}

	public function upload_insurance($userid,$page=null) {
		if($_FILES['u_insurrance_certi']['name']) {
			$ext=end(explode(".",$_FILES['u_insurrance_certi']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['u_insurrance_certi']['tmp_name'],'img/verify/'.$files)) {
				$insert['u_insurrance_certi']=$files;
				$insert['u_status_insure']=1;
        $insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users',array('id'=>$userid),$insert);
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		if($run) {
			$sub='New document uploaded for insurrance verification';
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>".$get_users['f_name'].' '.$get_users['l_name']."</p><p><b>Email ID : </b>".$get_users['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p>";
			if($files){
				$mail_responce=$this->common_model->send_mail_file($to,$sub,$body,$files); 
			}else{
				$mail_responce=$this->common_model->send_mail($to,$sub,$body); 
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if($page){
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}
	public function upload_bill($userid) {
		if($_FILES['u_bill']['name']) {
			$ext=end(explode(".",$_FILES['u_bill']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['u_bill']['tmp_name'],'img/verify/'.$files)) {
				$insert['u_bill']=$files;
				$insert['u_status_bill']=1;
			}
		}
		$run = $this->common_model->update('users',array('id'=>$userid),$insert);
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		if($run) {
			$sub='New document uploaded for billing verification';
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>".$get_users['f_name'].' '.$get_users['l_name']."</p><p><b>Email ID : </b>".$get_users['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p>";
			if($files){
				$mail_responce=$this->common_model->send_mail_file($to,$sub,$body,$files); 
			}else{
				$mail_responce=$this->common_model->send_mail($to,$sub,$body); 
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		redirect('verify');
	}
	public function upload_photo($userid) {
		if($_FILES['u_photo_id']['name']) {
			$ext=end(explode(".",$_FILES['u_photo_id']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['u_photo_id']['tmp_name'],'img/verify/'.$files)) {
				$insert['u_photo_id']=$files;
				$insert['u_status_photo_id']=1;
			}
		}
		$run = $this->common_model->update('users',array('id'=>$userid),$insert);
		$get_users=$this->common_model->get_single_data('users',array('id'=>$userid));
		if($run) {
			$sub='New document uploaded for photo ID verification';
			$data=$this->common_model->getAdminRow('admin');
			$to=$data['email'];
			$body="<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>".$get_users['f_name'].' '.$get_users['l_name']."</p><p><b>Email ID : </b>".$get_users['email']."</p><p><b>Phone No. : </b>".$insert['phone_no']."</p>";
			if($files){
				$mail_responce=$this->common_model->send_mail_file($to,$sub,$body,$files); 
			}else{
				$mail_responce=$this->common_model->send_mail($to,$sub,$body); 
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		redirect('verify');
	}
	public function update_password() {
		$this->form_validation->set_rules('old_pass', 'Password','required');
		$this->form_validation->set_rules('new_pass', 'New Password','required|min_length[6]');
		$this->form_validation->set_rules('confirm_pass', 'Confirm Password','required|matches[new_pass]');
		if($this->form_validation->run()==false){

			$json['msg'] = '<div class="alert alert-danger">'. validation_errors() .'</div>';
			$json['status'] = 0;
	
		} else {
			
			$u_password = $this->input->post('old_pass');
			$new_password = $this->input->post('new_pass');
				
			$user_id = $this->session->userdata('user_id');
			$userdata = $this->common_model->get_userDataByid($user_id);
			if($userdata['password'] === $u_password){
				
				$run = $this->common_model->update('users',array('id'=>$user_id),array('password'=>$new_password));
				
				if($run){				
					$json['msg'] = '<div class="alert alert-success">Your password has been changed successfully.</div>';
					$json['status'] = 1;						
				} else {					
					$json['msg'] = '<div class="alert alert-danger">We have not found any change in your password.</div>';
					$json['status'] = 0;						
				}
			} else {					
				$json['msg'] = '<div class="alert alert-danger">Your old password is incorrect.</div>';
				$json['status'] = 0;	
			}				
		}
		echo json_encode($json);
	
	  }
	public function update_image($id) {
		if($_FILES['u_profile']['name']){ 
			$config['upload_path']="img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('u_profile')) {
				$u_profile=$this->upload->data("file_name");
				$insert['profile'] = $u_profile;
						
				$u_profile_old = $this->input->post('u_profile_old');
				if($u_profile_old){
					unlink('img/profile/'.$u_profile_old);
				}
						
			} else {
				$this->session->set_flashdata('msg2','<div class="alert alert-danger">'. $this->upload->display_errors() .'</div>');
			}
		}
				
		$run = $this->common_model->update('users',array('id'=>$id),$insert);
		if($run) {
			$this->session->set_flashdata('success', 'Success! Profile Image Updated Successfully.');
		} else {
			$this->session->set_flashdata('error', 'We have not found any changes.');
		}
		redirect('profile/'.$id);		
	}
	public function portfolio() {
	  	$this->load->view('site/add-portfolio');
	}
	public function update_data($id) {
		$update['about_business'] = $this->input->post('about_business');
		$run = $this->common_model->update('users',array('id'=>$id),$update);
		if($run) {
			$this->session->set_flashdata('success1', 'Success! Profile Updated Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'We have not found any changes.');
		}
		redirect('profile/'.$id);
	}
	public function add_portfolio() {
		$id=$this->session->userdata['user_id'];
		$insert['userid']=$id;
		if($_FILES['port_image']['name']) {
			$ext=end(explode(".",$_FILES['port_image']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['port_image']['tmp_name'],'img/profile/'.$files)) {
						
				$insert['port_image']=$files;
					
				$run = $this->common_model->insert('user_portfolio',$insert);
						
				if($run) {
					$this->session->set_flashdata('success1', 'Success! Portfolio Added Successfully.');
				} else {
					$this->session->set_flashdata('error1', 'Something went wrong please try again later.');
				}
			} else {
				$this->session->set_flashdata('error1', 'Something went wrong please try again later.');
			}
				
		} else {
			$this->session->set_flashdata('error1', 'Please select an image.');
		}
			
		redirect('profile/'.$id.'/?edit_portfolio=1');
	}

	public function edit_portfolio($id) {
		$ids=$this->session->userdata['user_id'];
		if($_FILES['port_image']['name']){ 
			$config['upload_path']="img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('port_image')) {
				$u_profile=$this->upload->data("file_name");
				$insert['port_image'] = $u_profile;
						
				$u_profile_old = $this->input->post('port_image_old');
				if($u_profile_old){
					unlink('img/profile/'.$u_profile_old);
				}
						
			} else {
				$this->session->set_flashdata('msg2','<div class="alert alert-danger">'. $this->upload->display_errors() .'</div>');
			}
		}

		$run = $this->common_model->update('user_portfolio',array('id'=>$id),$insert);
		//$insert1['category']=implode(',',$this->input->post('category'));
		//$run = $this->common_model->update('users',array('id'=>$ids),$insert1);
		 if($run) {
			$this->session->set_flashdata('success1', 'Success! Portfolio Updated Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'We have not found any changes.');
		}
		redirect('profile/'.$ids);
	}
	public function update_skills($id) {
		$insert1['skills']=implode(',',$this->input->post('skills'));
		$run = $this->common_model->update('users',array('id'=>$id),$insert1);
		if($run) {
			$this->session->set_flashdata('success1', 'Success! Skills Added Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'Something went wrong,please try again later!');
		}
		redirect('profile/'.$id);
	}
	public function update_catgory($id) {
		$insert1['category']=implode(',',$this->input->post('category'));
		$run = $this->common_model->update('users',array('id'=>$id),$insert1);

		if($this->input->post('trades')=='trades') {
			if($run) {
				$this->session->set_flashdata('msg','<div class="alert alert-success">Category Added Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">We have not found any changes.</div>');
			}
			redirect('trades');
		} else {
			if($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Category Updated Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something went wrong,please try again later!</div>');
			}                                         

			redirect('profile/'.$id);
		}
	}
	public function update_subcatgory($id) {
		$insert1['subcategory']=implode(',',$this->input->post('subcategory'));
		$run = $this->common_model->update('users',array('id'=>$id),$insert1);

		if($this->input->post('trades')=='trades') {
			if($run) {
				$this->session->set_flashdata('msg','<div class="alert alert-success">Category Added Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg','<div class="alert alert-danger">We have not found any changes.</div>');
			}
			redirect('trades');
		} else {
			if($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Category Updated Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something went wrong,please try again later!</div>');
			}                                         

			redirect('profile/'.$id);
		}
	}
	public function my_reviews() {
		if($this->session->userdata('user_id')) {
			$data['reviews']=$this->common_model->get_all_feedback($this->session->userdata('user_id'));
			$this->load->view('site/user_review',$data);
		} else {
			redirect('login');
		}
	}
	public function delete_portfolio($id) {
		$ida=$this->session->userdata('user_id');
		$result=$this->common_model->delete(array('id'=>$id),'user_portfolio'); 
		if($result) {
			$this->session->set_flashdata('success1', 'Success! Portfolio Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'Something went wrong please try again later.');
		}

		redirect('profile/'.$ida);
	}
	public function add_education() {
		$id=$this->session->userdata('user_id');
		$insert['institute'] = $this->input->post('institute');
		$insert['degree'] = $this->input->post('degree');
		$insert['start_year'] = $this->input->post('start_year');
		$insert['end_year'] = $this->input->post('end_year');
		$insert['summary'] = $this->input->post('summary');
		$insert['userid']=$this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_education',$insert);
		if($run) {
			$this->session->set_flashdata('success2', 'Success! Qualification Added Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'Something went wrong please try again later.');
		}
		redirect('profile/'.$id);
	}
	public function edit_education($id) {
		$ida=$this->session->userdata('user_id');
		$insert['institute'] = $this->input->post('institute');
		$insert['degree'] = $this->input->post('degree');
		$insert['start_year'] = $this->input->post('start_year');
		$insert['end_year'] = $this->input->post('end_year');
		$insert['summary'] = $this->input->post('summary');
		$run = $this->common_model->update('user_education',array('id'=>$id),$insert);
		if($run) {
			$this->session->set_flashdata('success2', 'Success! Qualification Updated Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'We have not found any changes.');
		}
		redirect('profile/'.$ida);
	}
	public function delete_education($id) {
		$ida=$this->session->userdata('user_id');
		$result=$this->common_model->delete(array('id'=>$id),'user_education');
		if($result) {
			$this->session->set_flashdata('success2', 'Success! Qualification Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'Something went wrong please try again later.');
		} 
		redirect('profile/'.$ida);
	}
	public function add_publication() {
		$id=$this->session->userdata('user_id');
		$insert['heading'] = $this->input->post('heading');
		$insert['title'] = $this->input->post('title');
		$insert['description'] = $this->input->post('description');
		$insert['userid']=$this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_publication',$insert);
		if($run) {
			$this->session->set_flashdata('success3', 'Success! Publication Added Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/'.$id);
	}
	public function edit_publication($id) {
		$ids=$this->session->userdata('user_id');
		$insert['heading'] = $this->input->post('heading');
		$insert['title'] = $this->input->post('title');
		$insert['description'] = $this->input->post('description');

		$run = $this->common_model->update('user_publication',array('id'=>$id),$insert);
		if($run) {
			$this->session->set_flashdata('success3', 'Success! Publication Updated Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'We have not found any changes.');
		}
		redirect('profile/'.$ids);
	}
	public function delete_publication($id) {
		$ida=$this->session->userdata('user_id');
		$result=$this->common_model->delete(array('id'=>$id),'user_publication'); 
		if($result) {
			$this->session->set_flashdata('success3', 'Success! Publication Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/'.$ida);
	}
	public function add_insurance() {
		$ids=$this->session->userdata('user_id');
		$insert['insurance_liability'] = $this->input->post('insurance_liability');
		$insert['insured_by'] = $this->input->post('insured_by');
		$insert['insurance_amount'] = $this->input->post('insurance_amount');
		$insert['insurance_date']=$this->input->post('insurance_date');
		$test=$this->input->post('test123');

		$run = $this->common_model->update('users',array('id'=>$ids),$insert);
		if($run) {
			if($test=='') {
				$this->session->set_flashdata('success4', 'Success! Insurance Added Successfully.');
			} else {
				$this->session->set_flashdata('success4', 'Success! Insurance Updated Successfully.');
			}
		} else  {
			if($test=='') {
				$this->session->set_flashdata('error4', 'Something went wrong please try again later.');
			} else {
				$this->session->set_flashdata('error4', 'We have not found any changes.');
			}
		}
		redirect('profile/'.$ids);
	}
	public function delete_insurance() {
		$ids=$this->session->userdata('user_id');
	  	$insert['insurance_liability'] = '';
			$insert['insured_by'] = '';
			$insert['insurance_amount'] = '';
			$insert['insurance_date']='';
			$run = $this->common_model->update('users',array('id'=>$ids),$insert);
		if($run) {
			$this->session->set_flashdata('success4', 'Success! Insurance Deleted Successfully.');	
		} else {
			$this->session->set_flashdata('error4', 'Something went wrong please try again later.');
		}
		redirect('profile/'.$ids);
	}
	public function add_certification() {
		$id=$this->session->userdata('user_id');
		$insert['title'] = $this->input->post('title');
		$insert['organization'] = $this->input->post('organization');
		$insert['description'] = $this->input->post('description');
		$insert['year'] = $this->input->post('year');
		if($_FILES['certificate']['name']) {
			$ext=end(explode(".",$_FILES['certificate']['name']));
			$files=rand(10,1000).time().".".$ext;
			if(move_uploaded_file($_FILES['certificate']['tmp_name'],'img/profile/'.$files)) {
				$insert['certificate']=$files;
			}
		}
		$insert['userid']=$this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_certification',$insert);
		if($run) {
			$this->session->set_flashdata('success3', 'Success! Certificate Added Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/'.$id);
	}
	public function edit_certification($id) {
		$ids=$this->session->userdata('user_id');
		$insert['title'] = $this->input->post('title');
		$insert['organization'] = $this->input->post('organization');
		$insert['description'] = $this->input->post('description');
		$insert['year'] = $this->input->post('year');
		if($_FILES['certificate']['name']){ 
			$config['upload_path']="img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('certificate')) {
				$u_profile=$this->upload->data("file_name");
				$insert['certificate'] = $u_profile;
						
				$u_profile_old = $this->input->post('certificate_image_old');
				if($u_profile_old){
					unlink('img/profile/'.$u_profile_old);
				}
						
			} else {
				$this->session->set_flashdata('msg2','<div class="alert alert-danger">'. $this->upload->display_errors() .'</div>');
			}
		}
		$run = $this->common_model->update('user_certification',array('id'=>$id),$insert);
		if($run) {
			$this->session->set_flashdata('success3', 'Success! Certificate Updated Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'We have not found any changes.');
		}
		redirect('profile/'.$ids);
	}
	public function delete_certificate($id) {
		$ida=$this->session->userdata('user_id');
		$result=$this->common_model->delete(array('id'=>$id),'user_certification');
		if($result) {
			$this->session->set_flashdata('success3', 'Success! Certificate Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		} 
		redirect('profile/'.$ida);
	}
	public function milestone_requests() {
		$data['milestones']=$this->common_model->get_milestone_request('tbl_milestones',$this->session->userdata('user_id'));
		$this->load->view('site/milestone_request',$data);
	}
	
	public function fund_withdrawal() {
		if($this->session->userdata('user_id')) {
			
			$user_id = $this->session->userdata('user_id');
			
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$user_id));
			
			$data['withdrawal']=$this->common_model->get_all_userwithdrawal($user_id);
			
			$data['last_paypal']=$this->common_model->GetColumnName('tbl_withdrawal',array('wd_userid'=>$user_id, 'wd_pay_email !='=>''),array('wd_pay_email'),null,'wd_id');
			
			$data['last_bank']=$this->common_model->GetColumnName('tbl_withdrawal',array('wd_userid'=>$user_id, 'wd_account !='=>''),array('wd_account_holder','wd_bank','wd_account','wd_ifsc_code'),null,'wd_id');
			
			$data['banks'] = $this->common_model->GetAllData('wd_bank_details',['wd_user_id'=>$user_id],'id','desc');
			
			$data['setting'] = $this->common_model->get_single_data('admin',array('id'=>1));
			
			$this->load->view('site/fund_withdrawal',$data);
		} else {
			redirect('login');
		}

	}
	
	public function earnings() {
		if($this->session->userdata('user_id')) {
			
			$user_id = $this->session->userdata('user_id');
			
			$data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$user_id));
			
			$sql = "select tbl_milestones.*, tbl_jobs.title as job_title from tbl_milestones inner join tbl_jobs on tbl_milestones.post_id = tbl_jobs.job_id where tbl_milestones.userid = $user_id and (tbl_milestones.status = 2 or (tbl_milestones.status = 6 and tbl_milestones.is_dispute_to_traders = 1)) order by tbl_milestones.updated_at desc, tbl_milestones.id desc";
			$run = $this->db->query($sql);
			
			$lists = array();
			if($run->num_rows() > 0){
				$lists = $run->result_array();
			}
			
			//echo '<pre>'; print_r($lists); die();
			
			$data['lists']=$lists;
			
		
			$this->load->view('site/earnings',$data);
		} else {
			redirect('login');
		}

	}
	
	public function invoices() {
		if($this->session->userdata('user_id')) {
			$type=$this->session->userdata('type');
			$data['invoices'] = $this->common_model->get_all_milestone_invoice($this->session->userdata('user_id'),$type);
			$this->load->view('site/milestone_invoice',$data);
		} else {
			redirect('login');
		}
	} 
		public function contact_admin() {
			$user_id = $this->session->userdata('user_id');
			$get_user=$this->common_model->get_single_data('users',array('id'=>$user_id));
			$fullname=$get_user['f_name'].''.$get_user['l_name'];
			$phone_no=$get_user['phone_no'];
			$email=$get_user['email'];
			$contact_msg=$_POST['contact_msg'];
			$cdate= date('Y-m-d H:i:s');
			$query = $this->db->query('SELECT * FROM `admin`');
			if($query->num_rows() > 0 ){
				$query_res = $query->result();
				$review_email = $query_res[0]->email;
			}else{
				$review_email='';
			}

			$this->common_model->insert('contact_request', ['first_name' => $get_user['f_name'], 'last_name' => $get_user['l_name'], 'email' => $get_user['email'], 'phone_no' => $get_user['phone_no'], 'message'=>$contact_msg, 'type'=>$get_user['type'], 'cdate'=>$cdate]);

			$subject = "Marketer Message";

			$html = '<div class="row"><span>Marketer Message </span><span>:</span><span>'.$contact_msg.'</span></div>';
			$html .= '<p>Marketer Details</p>';
			$html .= '<div class="row"><span>Name </span><span>:</span><span>'.$fullname.'</span></div>';
 			$html .= '<div class="row"><span>Phone no </span><span>:</span><span>'.$phone_no.'</span></div>';
			$html .= '<div class="row"><span>Email </span><span>:</span><span>'.$email.'</span></div>';
			$this->common_model->send_mail($review_email,$subject,$html);
			echo json_encode(1);
			die();
		}

	public function manageBank()
	{
		$user_id = $this->session->userdata('user_id');
		$data['banks'] = $this->common_model->GetAllData('wd_bank_details',['wd_user_id'=>$user_id],'id','desc');
		
		$this->load->view('site/manage-banks',$data);
	}

	public function delete_account(){
		$this->load->view('site/deleteAccount');
	}

	public function send_delete_request(){
		$user_id = $this->session->userdata('user_id');
		$user = $this->common_model->get_single_data('users',array('id'=>$user_id));

		if($user['delete_request'] == 1){
			echo 2; exit;
		}

		if(in_array($user['delete_request'],[0,3])){
			$insert1['delete_request'] = 1;
			$insert1['delete_reason'] = $this->input->post('reason');
			$run = $this->common_model->update('users',array('id'=>$user_id),$insert1);

			/*New entry for manage delete request history*/
			$insert['user_id'] = $user_id;
			$insert['user_type'] = $user['type']; //1=>Tradesman, 2=> Homeowner
			$insert['name'] = $user['f_name'].' '.$user['l_name'];
			$insert['email'] = $user['email'];
			$insert['delete_request'] = 1;
			$insert['delete_reason'] = $this->input->post('reason');
			$this->common_model->insert('delete_account_request',$insert);
			/*New entry for manage delete request history*/
			
			if($run) {
				echo 1; exit;
			} else {
				echo 0; exit;
			}
		}
	}

	/*public function dragDrop(){
		$user_id = $this->session->userdata('user_id');
		$existUser = $this->common_model->get_single_data('users',array('id'=>$user_id));
		$imgList = !empty($existUser['work_images']) ? $existUser['work_images'].',' : '';
		
		if(!empty($_FILES) && !empty($_POST)){
			foreach ($_FILES['file']['tmp_name'] as $key => $value) {
				$tempFile = $_FILES['file']['tmp_name'][$key];
				$targetFile = 'img/profile/'. $_FILES['file']['name'][$key];
				$fileName = $_FILES['file']['name'][$key];
				move_uploaded_file($tempFile, $targetFile);
				$imgList .= $fileName.',';

				$insert['userid']=$user_id;
				$insert['port_image']=$fileName;
				$this->common_model->insert('user_portfolio',$insert);
			}
			// $insert['work_images'] = rtrim($imgList,',');
			// $this->common_model->update('users',array('id'=>$user_id),$insert);
		}
		return rtrim($imgList,',');
	}*/

	public function dragDrop(){
		$data['status'] = 0;
		$user_id = $this->session->userdata('user_id');
		if(!empty($_FILES)){
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/profile/'. $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['userid']=$user_id;
			$insert['port_image']=$fileName;
			$uploaded = $this->common_model->insert('user_portfolio',$insert);
			if($uploaded){
				/*$content = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv'.$uploaded.'">
						<div class="boxImage imgUp">
						<div class="imagePreviewPlus">
						<div class="text-right">
						<button type="button" class="btn btn-danger removeImage" onclick="removeImage('.$uploaded.')"><i class="fa fa-trash"></i></button>
						</div>
						<img style="width: inherit; height: inherit;" src="'.base_url().'img/profile/'.$fileName.'" alt="">
						</div></div></div>';*/
				$data['status'] = 1;
				$data['id'] = $uploaded;
				$data['imgName'] = base_url().'img/profile/'.$fileName;
			}
		}
		echo json_encode($data);
	}

	public function dragDropService(){
		$data['status'] = 0;
		$service_id = $this->input->post('service_id');
		$type = $this->input->post('type');
		if(!empty($_FILES)){
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/services/'. $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['service_id']=$service_id;
			$insert['image']=$fileName;
			$uploaded = $this->common_model->insert('service_images',$insert);
			if($uploaded){				
				$data['status'] = 1;
				$data['id'] = $uploaded;
				$data['imgName'] = base_url().'img/services/'.$fileName;
				$serviceData = $this->session->userdata('service_data');
				if($type == 'file'){
					if(isset($serviceData['multi_files']) && $serviceData['multi_files']){
						$multiFiles = $serviceData['multi_files'];
						$multiFiles[$uploaded] = $data['imgName'];
					}else{
						$multiFiles[$uploaded] = $data['imgName'];
					}
					$this->setServiceData(['multi_files' => $multiFiles]);
				} else {
					if(isset($serviceData['multi_images']) && $serviceData['multi_images']){
						$multiImages = $serviceData['multi_images'];
						$multiImages[$uploaded] = $data['imgName'];
					}else{
						$multiImages[$uploaded] = $data['imgName'];
					}
					$this->setServiceData(['multi_images' => $multiImages]);
				}
			}
		}
		echo json_encode($data);
	}

	public function removePortfolio(){
		$user_id = $this->session->userdata('user_id');
		$this->db->where('id',$this->input->post('pImgId'))->where('userid', $user_id)->delete('user_portfolio');
		exit;
	}

	public function my_services(){
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		if($this->session->userdata('user_id')) {
			$data['my_services']=$this->common_model->get_my_service('my_services',$this->session->userdata('user_id'),$status);
			$data['statusArr'] = ['active', 'approval_pending', 'required_modification', 'draft', 'denied', 'paused'];
			$data['totalStatusService'] = $this->common_model->getTotalStatusService($this->session->userdata('user_id'));
			$this->load->view('site/my_services',$data);
		} else {
			redirect('login');
		}	
	}

	public function getAllServices() {
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
	    if($this->session->userdata('user_id')) {
	        $services = $this->common_model->get_my_service('my_services', $this->session->userdata('user_id'), $status);
	        $data = [];

	        foreach($services as $service) {        	 
	          $data[] = [
	              'id' => $service['id'],
	              'status' => $service['status'],
	              'image' => $service['image'],
	              'service_name' => $service['service_name'],
	              'created_at' => $service['created_at'],
	              'price' => $service['price']
	          ];
	        }

	        echo json_encode(['data' => $data]);
	    } else {
	        echo json_encode(['data' => []]);
	    }
	}

	public function my_orders(){
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		if($this->session->userdata('user_id')) {
			$data['my_orders'] = $this->common_model->getAllOrder('service_order',$this->session->userdata('user_id'),$status,0);
			$data['totalStatusOrder'] = $this->common_model->getTotalStatusOrder($this->session->userdata('user_id'));
			$data['statusArr'] = ['placed', 'completed', 'cancelled', 'all'];
			$this->load->view('site/my_orders',$data);
		} else {
			redirect('login');
		}	
	}

	public function getAllOrders() {
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
	    if($this->session->userdata('user_id')) {
	        $orders = $this->common_model->getAllOrder('service_order', $this->session->userdata('user_id'), $status);
	        $data = [];


	        foreach($orders as $order) {
	        	$date = new DateTime($order['created_at']);

	          	$data[] = [
		          	'service_name' => array('file' => !empty($order['image']) ? $order['image'] : $order['video'] ,'service_name'=>$order['service_name']),
		            'created_at' => $date->format('F j, Y'),
		            'total_price' => '£'.number_format($order['total_price'],2),
		            'status' => ucfirst($order['status'])
	          	];
	        }

	        echo json_encode(['data' => $data]);
	    } else {
	        echo json_encode(['data' => []]);
	    }
	}

	public function addServices(){
		if($this->session->userdata('user_id')) {
			$data['cities'] = $this->search_model->getJobCities();
			$data['category']=$this->common_model->get_parent_category('service_category',0,1);
			$sesData = $this->session->userdata('store_service1');
			$data['price_per_type'] = ['Hour','Service','Meter','Square Meter','Kilogram','Mile','Consultation'];
			$data['attributes'] = $this->common_model->get_all_data('service_attribute',['service_cat_id'=>$sesData['category']]);
			$data['ex_service'] = $this->common_model->get_all_data('extra_service',['category'=>$sesData['category']]);
			$data['service_category'] = $this->common_model->GetSingleData('service_category',['cat_id'=>$sesData['category']]);
      		$this->load->view('site/add-service',$data);
    	} 
	}

	public function addServices2(){
		if($this->session->userdata('store_service1')) {
			$data['category']=$this->common_model->get_parent_category('service_category',0,1);
      		$this->load->view('site/add-service2',$data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices3(){
		if($this->session->userdata('store_service2')) {
			$sesData = $this->session->userdata('store_service2');
			$data['ex_service']=$this->common_model->get_ex_service('extra_service',$sesData['category']);
			$this->load->view('site/add-service3',$data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices4(){
		if($this->session->userdata('store_service2')) {
			$this->load->view('site/add-service4',$data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices5(){
		if($this->session->userdata('latest_service')) {
			$this->load->view('site/add-service5',$data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices6(){
		if($this->session->userdata('latest_service')) {
			$this->load->view('site/add-service6',$data);
		} else {
			redirect('dashboard');
		}
	}

	public function storeServices($value=''){
		$this->form_validation->set_rules('service_name','Service Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('location','Location','required');
		// $this->form_validation->set_rules('price','Price','required|numeric');
		// $this->form_validation->set_rules('delivery_in_days','Delivery in days','required|numeric');
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Sub Category','required');
				
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('next_step',1);
			redirect('add-service');
		}
		$newImg = '';
		if($_FILES['image']['name']){ 
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('image')) {
				$profile=$this->upload->data("file_name");
				$newImg = $profile;
			} 
		}
		$insert['user_id'] = $this->session->userdata('user_id');
		$insert['service_name'] = $this->input->post('service_name');
		$insert['slug'] = str_replace(' ','-',strtolower($this->input->post('service_name')));
		$insert['description'] = trim($this->input->post('description'));
		$insert['positive_keywords'] = trim($this->input->post('positive_keywords'));
		$insert['location'] = trim($this->input->post('location'));
		$insert['price_per_type'] = trim($this->input->post('price_per_type'));
		//$insert['price'] = trim($this->input->post('price'));
		$insert['image'] = $newImg;
		$insert['status'] = 'draft';
		//$insert['delivery_in_days'] = $this->input->post('delivery_in_days');
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if(!empty($this->input->post('plugins'))){
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}

		$this->session->set_userdata('store_service1',$insert);
		$this->session->set_userdata('next_step',7);
		$this->session->set_flashdata('success',"Service details added successfully.");
		$this->setServiceData($insert);
		redirect('add-service');
	}

	public function storeServices2($value=''){
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Sub Category','required');
				
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('next_step',2);
			redirect('add-service');
		}	
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if(!empty($this->input->post('plugins'))){
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}
		$this->session->set_userdata('store_service2',$insert);
		$this->setServiceData($insert);

		$this->session->set_userdata('next_step',3);
		$this->session->set_flashdata('success',"Category details added successfully.");
		redirect('add-service');
	}

	public function storeServices3($value=''){
		$newExS = $this->input->post('newExS', []);
		$this->setServiceData(['newExService' => $newExS]);
		$this->session->set_userdata('next_step',4);
		$this->session->set_flashdata('success',"Extra service details added successfully.");
		redirect('add-service'); 			
	}

	public function storeServices4($value=''){
		$step1 = $this->session->userdata('store_service1');
		$step2 = $this->session->userdata('store_service7');
		$step3 = $this->session->userdata('store_service3');
		
		if ($step2 !== null) {
		  $insert = array_merge($step1, $step2);
		}else{
			$this->session->set_flashdata('error','The Package Data field is required.');
			$this->session->set_userdata('next_step',7);
			redirect('add-service');
		}

		if ($step3 !== null) {
		  $insert = array_merge($insert, $step3);
		}

		$mImgs = !empty($this->input->post('multiImgIds')) ? explode(',', $this->input->post('multiImgIds')) : [];
		$mDocs = !empty($this->input->post('multiDocIds')) ? explode(',', $this->input->post('multiDocIds')) : [];

		$newVid = '';

		if($_FILES['video']['name']){ 
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('video')) {
				$video=$this->upload->data("file_name");
				$newVid = $video;
			} 
		}

		$insert['video'] = $newVid;
		$run = $this->common_model->insert('my_services', $insert);		

		if($run){
			$this->session->set_userdata('latest_service',$run);
			$input['service_id'] = $run;
			if(count($mImgs) > 0){
				$input['type'] = 1;
				foreach($mImgs as $imgId){					
					$run = $this->common_model->update('service_images',array('id'=>$imgId),$input);
				}
			}
			if(count($mDocs) > 0){
				$input['type'] = 2;
				foreach($mDocs as $docId){
					$run = $this->common_model->update('service_images',array('id'=>$docId),$input);
				}
			}

			$allSessionData = $this->session->userdata('service_data');
			if(!empty($allSessionData['newExService']) && count($allSessionData['newExService']) > 0){
				foreach($allSessionData['newExService']	 as $list){
					if(isset($list['id']) && !empty($list['id'])){
						$insertExs['service_id'] = $run;
						$insertExs['category'] = $list['category'];
						$insertExs['ex_service_id'] = $list['id'];
						$insertExs['ex_service_name'] = $list['ex_service_name'];
						$insertExs['price'] = $list['price'];
						$insertExs['additional_working_days'] = $list['additional_working_days'];

						$this->common_model->insert('tradesman_extra_service', $insertExs);	
					}
				}			
			}	

			$this->setServiceData($insert);
		}
		$this->session->set_userdata('next_step',5);
		$this->session->set_flashdata('success',"Gallary details added successfully.");
		redirect('add-service');
	}

	public function storeServices5($value=''){
		$faqs = $this->input->post('faq', []);
		$latestServiceId = $this->session->userdata('latest_service');
		$this->common_model->delete(['service_id'=>$latestServiceId],'service_faqs');
		$this->setServiceData(['faqs' => $faqs]);
		if(!empty($faqs) && count($faqs) > 0){
			foreach ($faqs as $key => $list) {
				$insert['service_id'] = $latestServiceId;
				$insert['question'] = $list['question'];
				$insert['answer'] = $list['answer'];
				$run = $this->common_model->insert('service_faqs', $insert);
			}
		}
		$this->session->set_userdata('next_step',6);
		$this->session->set_flashdata('success',"FAQ details added successfully.");
		redirect('add-service');
	}

	public function storeServices6($value=''){
		$this->form_validation->set_rules('available_mon_fri','Available Monday to Friday','required');
		$this->form_validation->set_rules('weekend_available','Available On Weekends','required');
		
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('next_step',6);
			redirect('add-service');
		}
		$insert['service_id'] = $this->session->userdata('latest_service');
		$insert['available_mon_fri'] = $this->input->post('available_mon_fri');
		$insert['selected_dates'] = $this->input->post('selected_dates');
		$insert['time_slot'] = $this->input->post('time_slot');
		$insert['weekend_available'] = $this->input->post('weekend_available');
		$insert['not_available_days'] = $this->input->post('not_available_days');
		$run = $this->common_model->insert('service_availability', $insert);

		$input['status'] = 'approval_pending';
		$result = $this->common_model->update('my_services',array('id'=>$this->session->userdata('latest_service')),$input);
	
		if($run){
			$this->session->unset_userdata('store_service1');
			$this->session->unset_userdata('store_service2');
			$this->session->unset_userdata('store_service3');
			$this->session->unset_userdata('latest_service');
			$this->reserServiceTabData();							

			$this->session->set_flashdata('success','Your service has been saved successfully.');
		} else {
			$this->session->set_flashdata('error','Something is wrong. Your Service is not saved successfully!!!');
		}			
		redirect('my-services');
	}

	public function storeServices7($value=''){
		$package = $this->input->post('package');
		$result = $this->validateArray($package);
		if (!$result['isValid']) {
			$this->session->set_flashdata('error',$result['message']);
			$this->session->set_userdata('next_step',7);
			redirect('add-service');
		}

		if($this->input->post('package_type')){
			$insert['package_type'] = 1;
		}else{
			$insert['package_type'] = 0;
		}

		if($this->input->post('package')){
			$insert['package_data'] = json_encode($this->input->post('package'));
		}else{
			$insert['package_data'] = '';
		}		

		$this->session->set_userdata('store_service7',$insert);
		$this->setServiceData($insert);		

		$this->session->set_userdata('next_step',3);
		$this->session->set_flashdata('success',"Package details added successfully.");
		redirect('add-service');		
	}

	public function editServices($id=""){
		if($this->session->userdata('user_id')) {
      		$user_id = $this->session->userdata('user_id');
			$serviceData = $this->common_model->GetSingleData('my_services',['user_id'=>$user_id, 'id'=>$id]);
			if(!$serviceData){
				return ;
			}

			$this->setEditServiceData($serviceData);
			$data['category'] = $this->common_model->get_parent_category('service_category',0,1);
			$data['cities'] = $this->search_model->getJobCities();			
			$trades_ex_service = $this->common_model->getTradesExService($id);
			$faqs = $this->common_model->getServiceFaqs($id);
			$serviceAvailiblity = $this->common_model->getServiceAvailability($id);
			$this->setEditServiceData(['trades_ex_service'=>$trades_ex_service, 'faqs' => $faqs, 'service_availiblity' => $serviceAvailiblity]);
			$service_images=$this->common_model->getAllTypeServiceImage('service_images',$id);

			foreach($service_images as $imageData){
				$image = $imageData['image'] ?? '';
				$imgId = $imageData['id'] ?? '';
				$file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
				if($file_extension == 'pdf'){
					if(isset($serviceData['multi_files']) && $serviceData['multi_files']){
						$multiFiles = $serviceData['multi_files'];
						$multiFiles[$imgId] = site_url()."img/defaultDoc.png";
					}else{
						$multiFiles[$imgId] = site_url()."img/defaultDoc.png";
					}
					$this->setEditServiceData(['multi_files' => $multiFiles]);
				} else {
					if(isset($serviceData['multi_images']) && $serviceData['multi_images']){
						$multiImages = $serviceData['multi_images'];
						$multiImages[$imgId] = site_url()."img/services/".$image;
					}else{
						$multiImages[$imgId] = site_url()."img/services/".$image;
					}
					$this->setEditServiceData(['multi_images' => $multiImages]);
				}
			}
			$data['id'] = $id;			

			$service_category = $this->common_model->GetSingleData('service_category',['cat_id'=>$serviceData['category']]);

			$data['price_per_type'] = ['Hour','Service','Meter','Square Meter','Kilogram','Mile','Consultation'];

			$data['attributes'] = $this->common_model->get_all_data('service_attribute',['service_cat_id'=>$service_category['cat_id']]);

			$data['ex_service'] = $this->common_model->get_all_data('extra_service',['category'=>$service_category['cat_id']]);

			$serviceData1 = $this->session->userdata('edit_service_data');

			$data['package_data'] = !empty($serviceData['package_data']) ? json_decode($serviceData['package_data']) : [];

			$data['service_category'] = $service_category;

			$this->load->view('site/edit-service',$data);
    	} 
	}

	public function updateServices($id=""){
		if(!$id){
			redirect(base_url());
			return;
		}
		$this->form_validation->set_rules('service_name','Service Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('location','Location','required');
		//$this->form_validation->set_rules('price','Price','required|numeric');
		//$this->form_validation->set_rules('delivery_in_days','Delivery in days','required|numeric');
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Subcategory','required');
		
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('update_next_step',1);
			redirect("edit-service/{$id}");
		}
		$insert = [];
		$newImg = '';
		if($_FILES['image']['name']){ 
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('image')) {
				$profile=$this->upload->data("file_name");
				$newImg = $profile;
			}
		}

		if($newImg){
			$insert['image'] = $newImg;
		}
		$insert['service_name'] = $this->input->post('service_name');
		$insert['slug'] = str_replace(' ','-',strtolower($this->input->post('service_name')));
		$insert['description'] = trim($this->input->post('description'));
		$insert['price_per_type'] = trim($this->input->post('price_per_type'));
		//$insert['price'] = $this->input->post('price');
		$insert['location'] = $this->input->post('location');
		$insert['positive_keywords'] = trim($this->input->post('positive_keywords'));
		//$insert['delivery_in_days'] = $this->input->post('delivery_in_days');
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if(!empty($this->input->post('plugins'))){
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}

		$this->common_model->update('my_services', ['id'=>$id], $insert);
		$this->session->set_flashdata('success','Service details updated succesfully.');
		$this->session->set_userdata('update_next_step',7);
		redirect("edit-service/{$id}");
	}

	public function updateServices2($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Subcategory','required');
				
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('update_next_step',2);
			redirect("edit-service/{$id}");
		}	
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if(!empty($this->input->post('plugins'))){
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}
		$this->common_model->update('my_services', ['id'=>$id], $insert);
		$ex_service=$this->common_model->get_ex_service('extra_service',$insert['category']);
		$this->session->set_userdata('update_next_step',7);
		redirect("edit-service/{$id}");					
	}

	public function updateServices3($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}

		$newExS = $this->input->post('newExS', []);
		$this->setEditServiceData(['newExService' => $newExS]);
		$serviceData = $this->session->userdata('edit_service_data');
		$this->session->set_flashdata('success','Extra Service details updated succesfully.');
		$this->session->set_userdata('update_next_step',4);
		redirect("edit-service/{$id}");		
	}

	public function updateServices4($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}
		$mImgs = !empty($this->input->post('multiImgIds')) ? explode(',', $this->input->post('multiImgIds')) : [];
		$mDocs = !empty($this->input->post('multiDocIds')) ? explode(',', $this->input->post('multiDocIds')) : [];

		$newVid = '';

		if($_FILES['video']['name']){ 
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('video')) {
				$video=$this->upload->data("file_name");
				$newVid = $video;
			} 
		}

		$insert['video'] = $newVid;
		$this->common_model->update('my_services',array('id'=>$id),$insert);		

		if($id){
			$input['service_id'] = $id;
			if(count($mImgs) > 0){
				foreach($mImgs as $imgId){					
					$run = $this->common_model->update('service_images',array('id'=>$imgId),$input);
				}
			}
			if(count($mDocs) > 0){
				foreach($mDocs as $docId){
					$run = $this->common_model->update('service_images',array('id'=>$docId),$input);
				}
			}

			$allSessionData = $this->session->userdata('edit_service_data');

			if(!empty($allSessionData['newExService']) && count($allSessionData['newExService']) > 0){
				foreach($allSessionData['newExService']	 as $list){
					if(isset($list['id']) && !empty($list['id'])){
						$insertExs['service_id'] = $id;
						$insertExs['category'] = $list['category'];
						$insertExs['ex_service_id'] = $list['id'];
						$insertExs['ex_service_name'] = $list['ex_service_name'];
						$insertExs['price'] = $list['price'];
						$insertExs['additional_working_days'] = $list['additional_working_days'];

						$tradesExs = $this->common_model->GetSingleData('tradesman_extra_service',array('service_id'=>$id, 'ex_service_id'=>$list['id']));	

						if(!empty($tradesExs)){
							$this->common_model->update('tradesman_extra_service',array('service_id'=>$id, 'ex_service_id'=>$list['id']),$insertExs);
						}else{
							$this->common_model->insert('tradesman_extra_service', $insertExs);	
						}
					}
				}			
			}		
		}
		$this->session->set_userdata('update_next_step',5);
		$this->session->set_flashdata('success','Gallary details updated succesfully.');
		redirect("edit-service/{$id}");
	}

	public function updateServices5($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}
		$this->common_model->delete(['service_id'=>$id],'service_faqs');
		$faqs = $this->input->post('faq', []);
		if(!empty($faqs) && count($faqs) > 0){
			foreach ($faqs as $key => $list) {
				$insert['service_id'] = $id;
				$insert['question'] = $list['question'];
				$insert['answer'] = $list['answer'];
				$this->common_model->insert('service_faqs',$insert);		
			}
		}
		$this->session->set_userdata('update_next_step',6);
		$this->session->set_flashdata('success','FAQs details updated succesfully.');
		redirect("edit-service/{$id}");
	}

	public function updateServices6($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}
		$this->form_validation->set_rules('available_mon_fri','Available Monday to Friday','required');
		$this->form_validation->set_rules('weekend_available','Available On Weekends','required');
		
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			$this->session->set_userdata('update_next_step',6);
			redirect("edit-service/{$id}");
		}

		$insert['service_id'] = $id;
		$insert['available_mon_fri'] = $this->input->post('available_mon_fri') ? 'yes' : 'no';
		$insert['selected_dates'] = $this->input->post('selected_dates');
		$insert['time_slot'] = $this->input->post('time_slot');
		$insert['weekend_available'] = $this->input->post('weekend_available') ? 'yes' : 'no';
		$insert['not_available_days'] = $this->input->post('not_available_days');

		$serviceAvailible = $this->common_model->GetSingleData('service_availability',array('service_id'=>$id));

		$insert1['status'] = 'approval_pending';
		$this->common_model->update('my_services',array('id'=>$id),$insert1);

		if(!empty($serviceAvailible)){
			$this->common_model->update('service_availability',array('id'=>$id),$insert);	
		}else{
			$this->common_model->insert('service_availability', $insert);				
		}
	
		if($id){
			$this->session->set_flashdata('success','Your service has been updated successfully.');
		} else {
			$this->session->set_flashdata('error','Something is wrong.');
		}
		$this->resetEditServiceTabData();
		redirect("my-services");				
	}

	public function updateServices7($id=''){
		if(!$id){
			redirect(base_url());
			return;
		}

		if($this->input->post('package_type')){
			$insert['package_type'] = 1;
		}else{
			$insert['package_type'] = 0;
		}

		if($this->input->post('package')){
			$insert['package_data'] = json_encode($this->input->post('package'));
		}else{
			$insert['package_data'] = '';
		}
		$this->common_model->update('my_services',array('id'=>$id),$insert);

		$this->session->set_userdata('update_next_step',3);
		redirect("edit-service/{$id}");							
	}

	public function removeServiceImage(){
		$user_id = $this->session->userdata('user_id');
		$imageId = $this->input->post('imgId');
		$serviceImages = $this->common_model->GetSingleData('service_images',['id'=>$imageId]);
		if(!empty($serviceImages)){
			unlink('img/services/'.$serviceImages['image']);
			$this->db->where('id',$this->input->post('imgId'))->delete('service_images');
			$serviceData = $this->session->userdata('service_data');

			if(isset($serviceData['multi_files'][$imageId])){
				unset($serviceData['multi_files'][$imageId]);
			}

			if(isset($serviceData['multi_images'][$imageId])){
				unset($serviceData['multi_images'][$imageId]);
			}

			$this->setServiceData($serviceData);
		}
		exit;
	}

	public function deleteServices($id=""){
		$service = $this->common_model->GetSingleData('my_services',['id'=>$id]);
		if(!empty($service)){
			unlink('img/services/'.$service['image']);
			$service_images=$this->common_model->get_service_image('service_images',$id);
			if(!empty($service_images)){
				foreach($service_images as $list){
					unlink('img/services/'.$list['image']);				
					$this->common_model->delete(['id'=>$list['id']], 'service_images');
				}
			}
			$this->common_model->delete(['id'=>$id], 'my_services');
			$this->common_model->delete(['service_id'=>$id], 'service_availability');
			$this->common_model->delete(['service_id'=>$id], 'service_faqs');			
			$this->common_model->delete(['service_id'=>$id], 'service_rating');			
			$this->session->set_flashdata('msg','<div class="alert alert-success">Service has been deleted successfully!!</div>');
		}else{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">Something is wrong!!</div>');
		}
		redirect('my-services');		
	}	

	public function getSubCategory(){
		$id = $this->input->post('cat_id');
		$subCategory=$this->common_model->get_sub_category('service_category',$id);
		$option = '';
		if(!empty($subCategory)){
			$option .= '<option value="">Please Select</option>';
			foreach($subCategory as $sCat){
				$option .= '<option value="'.$sCat['cat_id'].'">'.$sCat['cat_name'].'</option>';
			}
		}
		echo $option;
	}

	public function getPriceType(){
		$id = $this->input->post('cat_id');
		$service_category = $this->common_model->GetSingleData('service_category',['cat_id'=>$id]);
		$price_type = 0;
		if(!empty($service_category)){
			$price_type = !empty($service_category['price_type']) && $service_category['price_type'] == 1 ? 1 : 0;
		}
		echo $price_type;
	}

	public function setServiceData($data) {
		$serviceData = $this->session->userdata('service_data');
		if($serviceData){
			if($data){
				$allData = array_merge($serviceData, $data);
			}
		} else {
			$allData = $data;
		}

		$this->session->set_userdata('service_data', $allData);
	}

	public function setEditServiceData($data) {
		$serviceData = $this->session->userdata('edit_service_data');
		if($serviceData){
			if($data){
				$allData = array_merge($serviceData, $data);
			}
		} else {
			$allData = $data;
		}

		$this->session->set_userdata('edit_service_data', $allData);
	}

	public function reserServiceTabData() {
		$this->session->unset_userdata('service_data');
		$this->session->unset_userdata('next_step');
	}

	public function resetEditServiceTabData() {
		$this->session->unset_userdata('update_service_data');
		$this->session->unset_userdata('update_next_step');
	}

	public function deleteAllServices(){
		$ids = $this->input->post('servicesIds');
		if(count($ids) > 0){
			foreach($ids as $id){
				$service = $this->common_model->GetSingleData('my_services',['id'=>$id]);
				if(!empty($service)){
					unlink('img/services/'.$service['image']);
					$service_images=$this->common_model->get_service_image('service_images',$id);
					if(!empty($service_images)){
						foreach($service_images as $list){
							unlink('img/services/'.$list['image']);				
							$this->common_model->delete(['id'=>$list['id']], 'service_images');
						}
					}
					$this->common_model->delete(['id'=>$id], 'my_services');
					$this->common_model->delete(['service_id'=>$id], 'service_availability');
					$this->common_model->delete(['service_id'=>$id], 'service_faqs');			
					$this->common_model->delete(['service_id'=>$id], 'service_rating');	
				}
			}
			echo json_encode(['status' => 'success']);
		}else{
			echo json_encode(['status' => 'error', 'message' => 'No services selected']);
		}
	}

	public function submitProject(){
		$oId = $this->input->post('orderId');
		$serviceOrder = $this->common_model->GetSingleData('service_order',['id'=>$oId]);
		if(!empty($serviceOrder)){
			$input['status'] = 'completed';
			$this->common_model->update('service_order',array('id'=>$oId),$input);
			echo json_encode(['status' => 'success', 'message' => 'Order Submited']);
		}else{
			echo json_encode(['status' => 'error', 'message' => 'Order Not Submitted']);
		}
	}

	public function getServiceList(){
		$uId = $this->input->post('tradesMan');
		$services = $this->common_model->get_my_service('my_services', $uId);
		if(!empty($services)){
			echo json_encode(array('status'=>1, 'services'=>$services));
			exit;
		}else{
			echo json_encode(array('status'=>0));
			exit;
		}
	}

	public function getServiceDetail(){
		$sId = $this->input->post('sId');
		$service = $this->common_model->GetSingleData('my_services',['id'=>$sId]);
		if(!empty($service)){
			$exServices = $this->common_model->get_all_data('tradesman_extra_service',['service_id'=>$sId]);

			echo json_encode(array('status'=>1,'service'=>$service, 'exServices'=>$exServices));
			exit;
		}
		if(!empty($service)){
			echo json_encode(array('status'=>0));
			exit;
		}
	}

	public function sendCustomOffer(){
	    $userid = $this->session->userdata('user_id');
	    $service_id = $this->input->post('chatServiceId');
	    $receiver = $this->input->post('chatUserId');
	    $paymentType = $this->input->post('paymentType');
	    $description = $this->input->post('description');
	    $is_expiry = $this->input->post('is_expiry') ? 1 : 0; 
	    $offer_expiry_day = $this->input->post('offer_expiry_day');
	    $delivery_days = $this->input->post('delivery_days');
	    $price = $this->input->post('price');
	    $included_offer = $this->input->post('ex_service') ? implode(',', $this->input->post('ex_service')) : '';

	    // Preparing data for insertion
	    $insert = [
	        'offer_by' => $userid,
	        'receiver' => $receiver,
	        'service_id' => $service_id,
	        'payment_type' => $paymentType,
	        'description' => $description,
	        'is_expiry' => $is_expiry,
	        'offer_expiry_day' => $offer_expiry_day,
	        'delivery_days' => $delivery_days,
	        'price' => $price,
	        'included_offer' => $included_offer
	    ];

	    // Inserting data into the service_custom_offer table
	    $run = $this->common_model->insert('service_custom_offer', $insert);

	    if ($run) {
	        $get_users = $this->common_model->get_single_data('users', ['id' => $userid]);
	        $check_last = $this->common_model->GetColumnName('chat', ["post_id" => $service_id, "type" => 'service', "receiver_id" => $receiver], ['create_time'], null, 'id');
	        
	        if ($check_last == false) {                
	            $has_email_noti = $this->common_model->check_email_notification($receiver);
	                        
	            if ($has_email_noti) {
	                $user_namess = $get_users['f_name'];
	                $subject = "New Messages from " . $user_namess;
	                $msg = "You have received a new message"; // Add this line for the $msg variable

	                if ($has_email_noti['type'] == 1) {
	                    $html = '<p style="margin:0;padding:10px 0px">' . $msg . '</p>
	                             <div style="text-align:center">
	                             <a href="' . $link . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div>
	                             <br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
	                } else {
	                    $user_namess = $get_users['trading_name'];
	                    $subject = "New Messages from " . $user_namess;
	                    $html = '<p style="margin:0;padding:10px 0px">' . $msg . '</p>
	                             <br><div style="text-align:center">
	                             <a href="' . $link . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div>
	                             <br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
	                }                

	                try {
	                    $sent = $this->common_model->send_mail($has_email_noti['email'], $subject, $html, null, $user_namess . ' via Tradespeoplehub');
	                    
	                    // Log successful email sending
	                    $file = 'logFile.txt';
	                    $handle = fopen($file, 'a');
	                    $data = date('Y-m-d h:i:s') . '-----' . $has_email_noti['email'] . "\n";
	                    if (fwrite($handle, $data) === false) {
	                        die('Could not write to file');
	                    }
	                    fclose($handle);
	                } catch (Exception $e) {
	                    // Log email sending error
	                    $file = 'errorLogFile.txt';
	                    $handle = fopen($file, 'a');
	                    $data = date('Y-m-d h:i:s') . '-----' . "Error In send chat msg===>" . $e->getMessage();
	                    if (fwrite($handle, $data) === false) {
	                        die('Could not write to file');
	                    }
	                    fclose($handle);
	                }
	            }
	        }

	        // Preparing data for chat insertion
	        $insert1 = [
	            'post_id' => $service_id,
	            'type' => 'service',
	            'offer_id' => $run,
	            'sender_id' => $userid,
	            'receiver_id' => $receiver,
	            'mgs' => 'You are receive a new service offer',
	            'is_read' => 0,
	            'create_time' => date('Y-m-d H:i:s')
	        ];
	        
	        // Inserting data into the chat table
	        $chatInsert = $this->common_model->insert('chat', $insert1);
	        
	        echo json_encode(['status' => 1]);
	        exit;
	    } else {
	        echo json_encode(['status' => 0]);
	        exit;
	    }
	}

	public function sendInquiry(){
		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}
    	$userid = $this->session->userdata('user_id');
	    $sId = $this->input->post('serviceId');
	    $message = $this->input->post('message');
	    $service = $this->common_model->GetSingleData('my_services',['id'=>$sId]);
	    if(!empty($service)){
	    	$receiver = $service['user_id'];
	    	$msg = str_replace('Request', 'Are you available', $message);
			$insert1 = [
	            'post_id' => $sId,
	            'type' => 'service',
	            'sender_id' => $userid,
	            'receiver_id' => $receiver,
	            'mgs' => $msg,
	            'is_read' => 0,
	            'create_time' => date('Y-m-d H:i:s')
	        ];
	        
	        // Inserting data into the chat table
	        $chatInsert = $this->common_model->insert('chat', $insert1);

	        if($chatInsert){
	        	$get_users = $this->common_model->get_single_data('users', ['id' => $userid]);
		        $check_last = $this->common_model->GetColumnName('chat', ["post_id" => $service_id, "type" => 'service', "receiver_id" => $receiver], ['create_time'], null, 'id');
		        
		        if ($check_last == false) {
		            $has_email_noti = $this->common_model->check_email_notification($receiver);
		                        
		            if ($has_email_noti) {
		                $user_namess = $get_users['f_name'];
		                $subject = "New Messages from " . $user_namess;
		                $msg = "You have received a new message"; // Add this line for the $msg variable

		                if ($has_email_noti['type'] == 1) {
		                    $html = '<p style="margin:0;padding:10px 0px">' . $msg . '</p>
		                             <div style="text-align:center">
		                             <a href="' . $link . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div>
		                             <br><p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
		                } else {
		                    $user_namess = $get_users['trading_name'];
		                    $subject = "New Messages from " . $user_namess;
		                    $html = '<p style="margin:0;padding:10px 0px">' . $msg . '</p>
		                             <br><div style="text-align:center">
		                             <a href="' . $link . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Messages & Reply now</a></div>
		                             <br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
		                }                

		                try {
		                    $sent = $this->common_model->send_mail($has_email_noti['email'], $subject, $html, null, $user_namess . ' via Tradespeoplehub');
		                    
		                    // Log successful email sending
		                    $file = 'logFile.txt';
		                    $handle = fopen($file, 'a');
		                    $data = date('Y-m-d h:i:s') . '-----' . $has_email_noti['email'] . "\n";
		                    if (fwrite($handle, $data) === false) {
		                        die('Could not write to file');
		                    }
		                    fclose($handle);
		                } catch (Exception $e) {
		                    // Log email sending error
		                    $file = 'errorLogFile.txt';
		                    $handle = fopen($file, 'a');
		                    $data = date('Y-m-d h:i:s') . '-----' . "Error In send chat msg===>" . $e->getMessage();
		                    if (fwrite($handle, $data) === false) {
		                        die('Could not write to file');
		                    }
		                    fclose($handle);
		                }
		            }
		        }

		        $json['status'] = 1;
		    	$json['message'] = 'Inquiry send successfully';
	      		echo json_encode($json);
	      		exit;
	        }else{
	        	$json['status'] = 1;
		    	$json['message'] = 'Something is wrong';
	      		echo json_encode($json);
	      		exit;
	        }
	    }else{
	    	$json['status'] = 0;
	    	$json['message'] = 'Service not found';
      		echo json_encode($json);
      		exit;
	    }
	}

	public function validateArray($array) {
		foreach ($array as $key => $value) {
			if (!isset($value['attributes']) || empty($value['attributes'])) {
			    return [
	                'isValid' => false,
	                'message' => "Please check at least 1 attribute is required and cannot be empty for ".ucfirst($key)."."
	            ];
	        }

	        foreach ($value as $subKey => $subValue) {
	        	if (is_array($subValue)) {
	                // Recursively validate the nested array
	        		if($subKey != 'attributes'){
	        			$result = $this->validateArray($subValue);
		                if (!$result['isValid']) {
		                    return $result;
		                }	
	        		}
	            } else {
	                // Check if the value is empty
	                if (empty($subValue) && $subValue !== 0) {
	                    return [
	                        'isValid' => false,
	                        'message' => "The value for '$subKey' in ".ucfirst($key)." is required."
	                    ];
	                }
	            }
	        }
	    }
	    return ['isValid' => true, 'message' => 'Validation passed'];
	}
}