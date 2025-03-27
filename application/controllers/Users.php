<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('search_model');
		$this->words = array('gmail.com', 'yahoo.com', 'yahoo', 'gmail', 'skype', 'hotmail', 'live', 'phone numbers', 'phone number', 'outlook', 'icloud mail', 'yahoo! mail', 'yahoo mail', 'aol mail', 'gmx', 'yandex', 'mail', 'lycos', 'protonmail', 'proton mail', 'tutanota', 'zoho mail', 'zohomail', '077', '074', '020', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '@', 'www', 'http://', 'https://', '.com', '.uk', '.co.uk', '.gov.uk', '.me.uk', '.ac.uk', '.org.uk', '.Itd.uk', '.mod.uk ', '.mil.uk', '.net.uk', '.nic.uk', '.nhs.uk', '.pic.uk', '.sch.uk', '.pic.uk:', '.info', '.io', '.cloud', '.online', '.ai', '.net', '.org');
		error_reporting(0);
		if ($this->session->userdata('user_id')) {
			$user_id = $this->session->userdata('user_id');
			if (!empty($user_id)) {
				$user_profile = $this->common_model->get_single_data('users', array('id' => $user_id));

				if (empty($user_profile)) {
					$this->session->sess_destroy();
					redirect('login');
				}
			}
		}
	}

	public function check_login()
	{
		if (!$this->session->userdata('user_logIn')) {
			redirect('login?redirectUrl=' . base64_encode($_SERVER['REDIRECT_SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING']));
		}
	}

	public function check_profile_content()
	{

		$post_code = $this->input->post('post_code');

		$post_code = str_replace(" ", "", $post_code);

		$check_postcode = $this->common_model->check_postalcode($post_code);

		if ($check_postcode['status'] == 1) {

			$work_history = strtolower($this->input->post('work_history'));
			$about_business = strtolower($this->input->post('about_business'));

			$status = 1;

			foreach ($this->words as $url) {

				if (strpos($about_business, $url) !== FALSE) {
					$json['block_word'] = $url;
					$status = 2;
					break;
				}

				if (!in_array($url, ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'])) {
					if (strpos($work_history, $url) !== FALSE) {
						$json['block_word'] = $url;
						$status = 3;
						break;
					}
				}
			}

			$json['status'] = $status;
		} else {
			$json['status'] = 0;
		}

		echo json_encode($json);
	}

	public function marketers_payouts()
	{
		$transfer_type = $_POST['transfer_type'];
		$amount = $_POST['amount'];
		$paypal_email_address = $_POST['paypal_email_address'];
		$user_id = $this->session->userdata('user_id');

		$check = $this->db->where('user_id', $user_id)->where('status', 0)->get('referral_payout_requests')->row();

		if (!empty($check)) {
			$this->session->set_flashdata('success', '<div class="alert alert-danger">You can not make new request while your previous request is pending..</div>');
			echo json_encode('2');
			die;
		}
		$this->common_model->marketers_payouts($transfer_type, $amount, $account_number = '', $bank_name = '', $sort_code = '', $account_holder_name = '', $paypal_email_address);
		$get_user = $this->common_model->get_single_data('users', array('id' => $user_id));
		$subject = "Your earnings withdrawal request has been received!";
		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $get_user['f_name'] . '!</p><br>';
		$html .= '<p style="margin:0;padding:10px 0px">We’ve received your earnings payout request and are on it.</p><br>';
		$html .= 'Requested amoun: £ ' . $amount . '<br>';
		$html .= 'Payment method: ' . $transfer_type . '<br>';
		$html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';

		$this->common_model->send_mail($get_user['email'], $subject, $html);

		$this->session->set_flashdata('success', '<div class="alert alert-success">Your payout requested has been received and will be processed within 48 hours</div>');

		echo json_encode(1);
		die;
	}

	public function users_payouts()
	{
		$transfer_type = $_POST['transfer_type'];
		$amount = $_POST['amount'];
		$user_id = $this->session->userdata('user_id');
		$check = $this->db->where('user_id', $user_id)->where('status', 0)->get('referral_payout_requests')->row();

		if (!empty($check)) {
			$this->session->set_flashdata('success', '<div class="alert alert-danger">You can not make new request while your previous request is pending..</div>');
			echo json_encode('2');
			die;
		}
		$this->common_model->users_payouts($transfer_type, $amount);

		$get_user = $this->common_model->get_single_data('users', array('id' => $user_id));
		$subject = "Your earnings withdrawal request has been received!";
		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $get_user['f_name'] . '!</p><br>';
		$html .= '<p style="margin:0;padding:10px 0px">We’ve received your earnings payout request and are on it.</p><br>';
		$html .= 'Requested amoun: £ ' . $amount . '<br>';
		$html .= 'Payment method: ' . $transfer_type . '<br>';
		$html .= '<p style="margin:0;padding:10px 0px">Contact our customer services if you have any specific questions using our service.</p>';

		$this->common_model->send_mail($get_user['email'], $subject, $html);

		$this->session->set_flashdata('success', '<div class="alert alert-success">Your payout requested has been received and will be processed within 48 hours</div>');
		echo json_encode(1);
		die;
	}

	public function user_wallet_payouts()
	{
		$amount = $this->input->post('amount');
		$user_id = $this->session->userdata('user_id');

		$type = $this->session->userdata('type');
		$this->common_model->users_payouts('Wallet request', $amount);
		if ($type == 1) {
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Your referral earnings has been added to your wallet successfully. You can now use it to pay for your quote</div>');
		} elseif ($type == 2) {
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Your referral earnings has been added to your wallet successfully. You can now pay for your job using them</div>');
		} else {
			$this->session->set_flashdata('success1234', '<div class="alert alert-success">Request has been submitted successfully..</div>');
		}

		echo json_encode('1');
		die;
	}

	public function give_invited_review()
	{

		$userid = $this->session->userdata('user_id');
		$posted_by = $this->input->post('posted_by');
		$is_invited = $this->input->post('is_invited');
		$bid_by = $this->input->post('bid_by');

		if ($userid == $bid_by) {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">You can\'t review to your self.</div>';
		} else {

			$id = $this->input->post('job_id');


			$rt_rate = $this->input->post('rt_rate');

			$rt_comment = $this->input->post('rt_comment');

			$data = array(
				'rt_rateBy' => $userid,
				'rt_rateTo' => $bid_by,
				'rt_jobid' => $id,
				'rt_rate' => $rt_rate,
				'rt_comment' => $rt_comment,
				'rt_create' => date('Y-m-d H:i:s')
			);

			$run1 = $this->common_model->insert('rating_table', $data);
			if ($run1) {

				$get_avg_rating = $this->common_model->get_avg_rating($bid_by);
				$avg = $get_avg_rating[0]['avg'];
				$get_user = $this->common_model->get_single_data('users', array('id' => $bid_by));
				$review = $get_user['total_reviews'];
				$update2['average_rate'] = $avg;
				$update2['total_reviews'] = $review + 1;
				$runss1 = $this->common_model->update('users', array('id' => $bid_by), $update2);
				$this->common_model->update('review_invitation', array('id' => $is_invited), array('status' => 1, 'invite_to' => $userid));

				$json['status'] = 1;
				$this->session->set_flashdata('success1', 'Success! Rating has been submitted successfully.');
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong.Please try again later.</div>';
			}
		}


		echo json_encode($json);
	}

	public function get_home_email_by_job_id()
	{
		$id = $this->input->post('id');
		$data = $this->common_model->GetColumnName('tbl_jobs', array('job_id' => $id), array('title', 'job_id', 'userid', '(select f_name from users where users.id = tbl_jobs.userid) as f_name', '(select l_name from users where users.id = tbl_jobs.userid) as l_name', '(select email from users where users.id = tbl_jobs.userid) as email'));

		if ($data) {
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

	public function review_invitation()
	{

		if ($this->session->userdata('user_id')) {
			$invite_by = $_GET['invite_by'];
			$id = $_GET['is_invited'];


			$page['status'] = 0;

			$data = $this->common_model->get_single_data('review_invitation', array('id' => $id));

			if ($data) {
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

			$this->load->view('site/review-invitation', $page);
		} else {
			redirect('login?redirectUrl=' . base64_encode($_SERVER['REDIRECT_SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING']));
		}
	}

	public function send_review_invitation()
	{
		$review_email = $this->input->post('review_email');
		$review_id = $this->input->post('review_id');
		$f_name = $this->input->post('f_name');
		$l_name = $this->input->post('l_name');
		$id = $this->input->post('review_job');

		$user_id = $this->session->userdata('user_id');

		$job = $this->common_model->GetColumnName('tbl_jobs', array('job_id' => $id), array('title', 'awarded_time'));

		//if($job){
		$today = date('Y-m-d');
		$check_date = date('Y-m-d', strtotime($today . ' - 3 day'));

		if ($job) {
			$awarded_time = date('Y-m-d', strtotime($job['awarded_time']));

			//14-06-22
			//12-16-22

			if (strtotime($check_date) <= strtotime($awarded_time)) {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">You can´t send the invitation until after 3 days of job acceptance</div>';

				echo json_encode($json);
				exit();
			}
		}

		$reciever = $this->common_model->GetColumnName('users', array('email' => $review_email), array('f_name', 'id'));

		$sender = $this->common_model->GetColumnName('users', array('id' => $user_id), array('f_name', 'l_name', 'trading_name'));

		$insert['invite_by'] = $user_id;
		$insert['invite_to'] = ($reciever) ? $reciever['id'] : 0;
		$insert['email'] = $review_email;
		$insert['job_id'] = $id;
		$insert['status'] = 0;
		$insert['create_date'] = date('Y-m-d H:i:s');
		$insert['update_date'] = date('Y-m-d H:i:s');

		$run = $this->common_model->insert('review_invitation', $insert);

		/*if($id){
					$link = site_url().'reviews/?post_id='.$id.'&is_invited='.$run;
				} else {
					$link = site_url().'review-invitation/?invite_by='.$user_id.'&is_invited='.$run;
				}*/
		$link = site_url() . 'review-invitation/?invite_by=' . $user_id . '&is_invited=' . $run;

		$subject = "Provide feedback for " . $sender['trading_name'];

		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $f_name . ' ' . $l_name . '!</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Congratulations on completing your job with ' . $sender['trading_name'] . '. Please leave feedback for them to help other TradespeopleHub members know what it was like to work with them.</p>';

		$html .= '<br><div style="text-align:center"><a href="' . $link . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div><br>';

		$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

		$this->common_model->send_mail($review_email, $subject, $html);

		$json['status'] = 1;
		$json['msg'] = '<div class="alert alert-success">Invitation has been sent successfully.</div>';

		/*} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">Something went wrong, try gain later.</div>';
		}*/

		echo json_encode($json);
	}

	public function dashboard()
	{
		if (isset($_GET['reject_reason'])) {
			$this->session->set_flashdata('reject_reason', $_GET['reject_reason']);
			redirect('dashboard');
		}
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {

			if ($this->session->userdata('type') == 3) {
				redirect('affiliate-dashboard');
				exit();
			}

			$user_id = $this->session->userdata('user_id');
			$data['category'] = $this->common_model->get_all_category('category');
			$user_profile = $this->common_model->get_single_data('users', array('id' => $user_id));
			$data['user_profile'] = $user_profile;

			$category = $user_profile['category'];
			$postal_code1 = $data['user_profile']['postal_code'];
			$postal_code2 = str_replace(" ", "", $postal_code1);

			if ($category) {

				$get_commision = $this->common_model->get_commision();
				$closed_date = $get_commision[0]['closed_date'];
				$today = date('Y-m-d');
				$datesss = date('Y-m-d', strtotime($today . ' - ' . $closed_date . ' days'));

				//$where = "category IN ($category) and (status=0 or status=1 or status=2 or status=3 or  status=4 or status=7 or status=5 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and DATE(c_date) > DATE('".$datesss."')";


				$where = "(status=0 or status=1 or status=2 or status=3 or status=8 or status=9) and is_delete=0 and direct_hired = 0 and (select count(id) from tbl_jobpost_bids where tbl_jobpost_bids.job_id = tbl_jobs.job_id and tbl_jobpost_bids.bid_by=$user_id) = 0 and DATE(c_date) > DATE('" . $datesss . "')";

				$latitude = ($user_profile['latitude'] == '') ? 0 : $user_profile['latitude'];
				$longitude = ($user_profile['longitude'] == '') ? 0 : $user_profile['longitude'];
				$max_distance = $user_profile['max_distance'];

				$distance = ", 69.0 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(" . $latitude . ")) * COS(RADIANS(tbl_jobs.latitude)) * COS(RADIANS(" . $longitude . " - tbl_jobs.longitude)) + SIN(RADIANS(" . $latitude . ")) * SIN(RADIANS(tbl_jobs.latitude))))) AS distance_in_km";

				$sql = "select *$distance from tbl_jobs where $where HAVING distance_in_km <= '" . $max_distance . "' order by c_date desc limit 15";

				$run = $this->db->query($sql);

				$bids = array();

				if ($run->num_rows() > 0) {
					$bids = $run->result_array();
				}
				//echo '<pre>'; print_r($bids); echo '</pre>';
				//$data['bids']=$this->common_model->get_all_data('tbl_jobs',$where,'c_date','desc',15);
				$data['bids'] = $bids;

				$data['bidsss'] = $this->common_model->get_user_jobs_bycatid1('tbl_jobs', $category);
				$data['work_progress'] = $this->common_model->get_trades_working_progress('tbl_jobpost_bids', $user_id);
				$data['complete'] = $this->common_model->get_complete_job_byid('tbl_jobs', $category);
				$data['dispute_miles'] = $this->common_model->get_tradesdispute_milestones();
			}

			$data['progress'] = $this->get_progress_data();
			$data['posts'] = $this->common_model->get_post_jobs('tbl_jobs', $this->session->userdata('user_id'));
			//$data['notification']=$this->common_model->get_all_notification('notification',$this->session->userdata('user_id'));
			$data['trade_news'] = $this->common_model->get_notification_trades('notification', $this->session->userdata('user_id'));
			// $data['referrals_earn_list'] = $this->db->get('referrals_earn_list')->result();	
			$data['setting'] = $this->common_model->get_all_data('admin');
			$data['total_sale'] = $this->common_model->get_total_sale($user_id);
			$data['total_open_order'] = $this->common_model->get_total_open_order($user_id);
			$data['all_active_order'] = $this->common_model->getActiveOrder('service_order', $user_id, 6);
			$data['recently_viewed'] = $this->common_model->recentlyViewedService($user_id);

			$this->load->view('site/dashboard', $data);
		}
	}

	public function affiliate_dashboard()
	{

		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {

			if ($this->session->userdata('type') != 3) {
				redirect('dashboard');
				exit();
			}

			$user_id = $this->session->userdata('user_id');
			$user_profile = $this->common_model->get_single_data('users', array('id' => $user_id));
			$data['user_profile'] = $user_profile;


			$data['marketers_account_info'] = $this->common_model->marketers_account_info($user_id);

			$data['min_cashout'] = $this->common_model->get_min_cashout($user_id);
			$data['balance_amount'] = $this->common_model->get_balance_amount($user_id);
			$data['marketers_referrals_list'] = $this->common_model->marketers_referrals_list();


			$data['county'] = $this->common_model->get_countries();

			$data['settings'] = $this->common_model->get_single_data("admin_settings", array("id" => 1));

			$data['payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id' => $user_id], 'id', 'desc');
			$data['affilateMeata'] = $this->common_model->get_single_data('other_content', array('id' => 5));
			$data['contact_list'] = $this->db->query("SELECT * from contact_request where user_id=$user_id OR user_id=0 AND reply_id=$user_id OR reply_id=0 order by id desc")->result_array();
			// echo $this->db->last_query();
			//  echo "<pre>"; print_r($data['contact_list']); exit;

			$data['paymentSettings'] = $this->common_model->get_all_data('admin');
			$this->load->view('site/affiliate-dashboard', $data);
		}
	}

	public function support_msg_unread()
	{
		$unreadMessages = $this->common_model->check_admin_unread('admin_chat_details', array('is_read' => 0, 'receiver_id' => $this->session->userdata('user_id')), 'is_read');
		echo json_encode(['status' => 1, 'unreadMessages' => $unreadMessages]);
	}

	public function mark_read()
	{
		$result = $this->db->where('id', $this->input->post('row_id'))->update('contact_request', ['status' => 1]);
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
		$admin = $this->common_model->get_single_data('admin', array('id' => 1));

		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		$f_name = $user_data['f_name'];
		$l_name = $user_data['l_name'];
		$email = $user_data['email'];
		$phone_no = $user_data['phone_no'];
		$contant = 'Hi ' . $f_name . ', <br><br>';
		$contant .= $message;
		// echo "<pre>";


		// $send = $this->common_model->send_mail($admin['email'],$subject,$contant);
		// print_r($send); 
		// exit;
		// 	if($send)
		// 	{
		$this->db->insert('contact_request', ['first_name' => $f_name, 'last_name' => $l_name, 'email' => $email, 'user_id' => $user_data, 'user_id' => $this->session->userdata('user_id'), 'phone_no' => $phone_no, 'cdate' => date('Y-m-d H:i:s'), 'message' => $message, 'type' => 3, 'status' => 0]);

		$this->session->set_flashdata('success', 'Success! Request has been replied successfully.');
		// }    
		// else     
		// {
		// 	$this->session->set_flashdata('error', 'Error! Something went wrong, Try again.');

		// }
		return redirect('affiliate-dashboard');
	}

	public function update_notification_status($status)
	{

		$id = $this->session->userdata('user_id');

		$insert['notification_status'] = $status;

		$run = $this->common_model->update('users', array('id' => $id), $insert);

		if ($status == 1) {
			$this->session->set_flashdata('my_msg', '<p class="alert alert-success">Notifications are activated successfully.</p>');
		} else {
			$this->session->set_flashdata('my_msg', '<p class="alert alert-success">Notifications are deactivated successfully.</p>');
		}

		if (isset($_GET['redirectUrl']) && !empty($_GET['redirectUrl'])) {
			redirect($_GET['redirectUrl']);
		} else {
			redirect('dashboard');
		}
	}

	public function update_notification()
	{

		$insert['nt_satus'] = 1;
		$run = $this->common_model->update('notification', array('nt_userId' => $this->session->userdata('user_id')), $insert);
		$json['status'] = 1;
		if ($run) {
			$json['status'] = 1;
		} else {
			$json['status'] = 0;
		}

		echo json_encode($json);
	}

	public function notifications()
	{
		// echo $this->session->userdata('user_id'); exit;
		if ($this->session->userdata('user_id')) {
			$data['trade_news'] = $this->common_model->get_notification_trades1('notification', $this->session->userdata('user_id'));
			$this->load->view('site/notifications', $data);
		} else {
			redirect('login');
		}
	}

	public function submit_verify_phone()
	{

		$verification_code = $this->input->post('verification_code');
		$user_id = $this->session->userdata('user_id');
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));

		if ($verification_code == $user_data['phone_code']) {
			$user_id = $this->session->userdata('user_id');
			$update['is_phone_verified'] = 1;
			$run = $this->common_model->update('users', array('id' => $user_id), $update);
			$subject = "Phone number verified successfully";
			$html = '<h2 style="margin:0;font-size:22px;padding-bottom:5px;color:#2875d7">Phone number verified successfully</h2><p style="margin:0;padding:20px 0px">This is mail to informed you that your phone number has been verified successfully.</p>';
			$sent = $this->common_model->send_mail($user_data['email'], $subject, $html);
			if ($this->session->userdata('homeowner_signup')) {
				$json['status'] = 2;
			} else {
				$json['status'] = 1;
			}
		} else {
			$json['status'] = 0;
		}
		echo json_encode($json);
	}

	public function verify_phone($id = null)
	{
		$user_id = $this->session->userdata('user_id');
		$user_data = $this->common_model->get_single_data('users', array('id' => $user_id));
		if ($user_data && $user_data['is_phone_verified'] != 1) {
			$code = rand(1000, 9999);
			$msg = "Your verification code is: " . $code . " \r\n Tradespeoplehub.co.uk";
			$this->common_model->update("users", array('id' => $user_data['id']), array('phone_code' => $code));
			$this->load->model('send_sms');
			//$this->send_sms->send_india($user_data['phone_no'],$msg);
			$this->send_sms->send($user_data['phone_no'], $msg);
			$this->load->view('site/verify_phone');
		} else {
			redirect('dashboard');
		}
	}
	public function not_verify_phone()
	{
		redirect('dashboard');
	}

	public function get_unread_ontification()
	{
		$where = array('nt_userId' => $this->session->userdata('user_id'), 'nt_satus' => 0);
		$unread_notCount =  $this->common_model->get_data('notification', $where);
		$json['unread'] = (count($unread_notCount)) ? count($unread_notCount) : '';
		$json['data'] = "";

		$Latest_five_notif = $this->common_model->Latest_five_notif($this->session->userdata('user_id'));

		if ($Latest_five_notif) {
			$json['status'] = 1;
			foreach ($Latest_five_notif as $row) {
				$style = ($row['nt_satus'] == 0) ? 'unread' : '';
				$json['data'] .= '<li class="' . $style . ' notification-box">
					<div class="row">
						<div class="col-lg-11 col-sm-11 col-11" style="margin-left: 10px;">
							' . $row['nt_message'] . '
						</div>    
					</div>
				</li>';
			}
		} else {
			$json['status'] = 0;
		}
		$json['status'] = 0;
		echo json_encode($json);
	}

	public function my_account()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			$data['category'] = $this->common_model->get_all_category('category');

			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$category = $data['user_profile']['category'];
			if ($category) {
				$data['bids'] = $this->common_model->get_user_jobs_bycatid('tbl_jobs', $category);
			}
			$data['setting'] = $this->common_model->get_single_data('admin', array('id' => 1));
			$data['work_progress'] = $this->common_model->recent_work_in_progress('tbl_jobs', $this->session->userdata('user_id'));
			$data['completed_jobs'] = $this->common_model->get_completed_jobs('tbl_jobs', $this->session->userdata('user_id'));
			$data['dispute_miles'] = $this->common_model->get_dispute_milestones();
			//$data['progress']=$this->get_progress_data();
			$data['posts'] = $this->common_model->get_post_jobs('tbl_jobs', $this->session->userdata('user_id'));
			$data['notification'] = $this->common_model->get_all_notification('notification', $this->session->userdata('user_id'));
			$data['active_orders'] = $this->common_model->getAllOrder('service_order', $this->session->userdata('user_id'), 'active', 0, 1);
			$this->load->view('site/my_account', $data);
		}
	}

	public function profiles($id)
	{
		$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $id));
		$data['education'] = $this->common_model->get_education('user_education', $id);
		$data['certificate'] = $this->common_model->get_education('user_certification', $id);
		$data['portfolio'] = $this->common_model->get_education('user_portfolio', $id);
		$data['skills'] = $this->common_model->getRows('tbl_skills');
		$data['category'] = $this->common_model->getRows('category');
		$data['check'] = $check;
		$this->load->view('site/profile', $data);
	}

	public function profile($id)
	{
		$pagedata['user_profile'] = $this->common_model->get_single_data('users', array('id' => $id));
		if (empty($pagedata['user_profile'])) redirect('find-tradesmen');
		$pagedata['my_services'] = $this->common_model->get_my_service('my_services', $id);
		$pagedata['responseTime'] = $this->common_model->countResponseTime($id);
		$pagedata['serviceAvgRating'] = $this->common_model->get_service_avg_rating($id);
		$pagedata['referalRating'] = $this->common_model->get_referral_code_rating($id);

		$serviceRating = min($pagedata['serviceAvgRating'][0]['average_rating'], 5);
		$referralRating = min($pagedata['referalRating'], 5);
		$pagedata['overallRating'] = ($serviceRating + $referralRating) / 2;

		$sIds = [];
		foreach ($pagedata['my_services'] as $ser) {
			$sIds[] = $ser['id'];
		}

		$lastDelivery = $this->common_model->get_last_order_record('service_order', $sIds, 'id', 'DESC');

		$pagedata['last_delivery_time'] = !empty($lastDelivery) && !empty($lastDelivery['status_update_time']) ? $this->common_model->time_ago($lastDelivery['status_update_time']) : '';
		$pagedata['publications'] = $this->common_model->get_education('user_publication', $id);
		$pagedata['portfolio'] = $this->common_model->get_education('user_portfolio', $id);
		$pagedata['category'] = $this->common_model->GetAllData('category');
		$pagedata['check'] = $check;

		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		$perPage = 5;

		$conditions['search']['userid'] = $id;

		$totalRec = count($this->search_model->get_rating($conditions));

		$pagedata['totalRec'] = $totalRec;

		$base_url = site_url() . 'users/find_rating_ajax';

		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);

		$conditions['start'] = 0;
		$conditions['limit'] = $perPage;

		$pagedata['get_reviews'] = $this->search_model->get_rating($conditions);
		if ($pagedata['user_profile']['type'] == 1) {
			$this->load->view('site/profile2', $pagedata);
		} else {
			$this->load->view('site/profile', $pagedata);
		}
	}

	public function show_tradesment_profile($id = null)
	{
		$pagedata['user_profile'] = $this->common_model->get_single_data('users', array('id' => $id));

		$pagedata['portfolio'] = $this->common_model->get_education('user_portfolio', $id);
		// $pagedata['category']=$this->common_model->get_parent_category('category');
		$pagedata['category'] = $this->common_model->GetAllData('category');


		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');
		$perPage = 5;

		$conditions['search']['userid'] = $id;

		$totalRec = count($this->search_model->get_rating($conditions));

		$pagedata['totalRec'] = $totalRec;

		$base_url = site_url() . 'users/find_rating_ajax';

		$config['target']      = '#search_data';
		$config['base_url']    = $base_url;
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);

		$conditions['start'] = 0;
		$conditions['limit'] = $perPage;

		$pagedata['get_reviews'] = $this->search_model->get_rating($conditions);


		$this->load->view('site/side_profile_view', $pagedata);
	}

	public function find_rating_ajax($x = null)
	{
		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');

		$pagedata = array();
		$conditions = array();

		$page = $this->input->post('page_num');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		//$category_details = $this->common_model->get_single_data('category',array('slug'=>$cat_name));

		$userid = $this->input->post('userid');

		$user_profile = $this->common_model->get_single_data('users', array('id' => $userid));

		$conditions['search']['userid'] = $userid;

		$totalRec = count($this->search_model->get_rating($conditions));

		$pagedata['totalRec'] = $totalRec;

		$base_url = site_url() . 'users/find_rating_ajax';

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

		if (count($get_reviews) > 0) {
			$json['data'] .= '<div class="review-pro">
                  <div class=" dashboard-profile edit-pro89">
                     <h2>Reviews</h2>
                  </div>
				  
                  <div class="min_h3">';

			foreach ($get_reviews as $r) {

				$job_title = $this->common_model->GetColumnName('tbl_jobs', array('job_id' => $r['rt_jobid']), array('title', 'direct_hired'));

				$get_users = $this->common_model->get_single_data('users', array('id' => $r['rt_rateBy']));

				$trading_name = ($get_users['type'] == 1) ? $get_users['trading_name'] : $user_profile['trading_name'];


				$json['data'] .= '<div class="tradesman-feedback">
			  <div class="set-gray-box">
			  <p class="recent-feedback">';
				if ($job_title['direct_hired'] == 1) {
					$json['data'] .= '<h4>Work for ' . $trading_name . '</h4>';
				} else if ($job_title['title']) {
					$json['data'] .= '<h4>' . $job_title['title'] . '</h4>';
				} else {
					$json['data'] .= '<h4>Work for ' . $trading_name . '</h4>';
				}
				$json['data'] .= '</p>
				 <div class="from-group revie">
					<span class="btn btn-warning btn-xs">';

				if ($r['rt_rate'] != '') {
					$json['data'] .= $r['rt_rate'];
				}
				$json['data'] .= '</span>
					<span class="star_r">';

				for ($i = 1; $i <= 5; $i++) {
					if ($r['rt_rate']) {
						if ($i <= $r['rt_rate']) {
							$json['data'] .= '<i class="fa fa-star active"></i>';
						} else {
							$json['data'] .= '<i class="fa fa-star"></i>';
						}
					} else {
						$json['data'] .= '<i class="fa fa-star"></i>';
					}
				}
				$json['data'] .= '</span>
				 </div>
                <div cite="/job/view/5059288" class="summary">
                  <p>' . $r['rt_comment'] . '</p>
                </div>
                <p class="tradesman-feedback__meta">By <strong class="job-author">' . $get_users['f_name'] . ' ' . $get_users['l_name'] . '</strong>&nbsp;on
                 
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
		} else {
			$json['data'] .= '<p class="alert alert-danger">No data found.</p>';
		}
		echo json_encode($json);
	}

	public function find_rating_ajax_project_detail($x = null)
	{
		$this->load->library('Ajax_pagination');
		$this->load->model('search_model');

		$pagedata = array();
		$conditions = array();

		$page = $this->input->post('page_num');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		//$category_details = $this->common_model->get_single_data('category',array('slug'=>$cat_name));

		$userid = $this->input->post('userid');

		$user_profile = $this->common_model->get_single_data('users', array('id' => $userid));

		$conditions['search']['userid'] = $userid;

		$totalRec = count($this->search_model->get_rating($conditions));

		$pagedata['totalRec'] = $totalRec;

		$base_url = site_url() . 'users/find_rating_ajax';

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

		if (count($get_reviews) > 0) {
			$json['data'] .= '<div class=" dashboard-profile ">
							<h2>Recent reviews</h2>
								<div class="min_h3">';

			foreach ($get_reviews as $r) {

				$job_title = $this->common_model->GetColumnName('tbl_jobs', array('job_id' => $r['rt_jobid']), array('title', 'direct_hired'));

				$get_users = $this->common_model->get_single_data('users', array('id' => $r['rt_rateBy']));

				$trading_name = ($get_users['type'] == 1) ? $get_users['trading_name'] : $user_profile['trading_name'];


				$json['data'] .= '<div class="tradesman-feedback">
				  <div class="set-gray-box">
					 <div class="from-group revie">
						<span class="btn btn-warning btn-xs">';

				if ($r['rt_rate'] != '') {
					$json['data'] .= $r['rt_rate'];
				}
				$json['data'] .= '</span>
						<span class="star_r">';

				for ($i = 1; $i <= 5; $i++) {
					if ($r['rt_rate']) {
						if ($i <= $r['rt_rate']) {
							$json['data'] .= '<i class="fa fa-star active"></i>';
						} else {
							$json['data'] .= '<i class="fa fa-star"></i>';
						}
					} else {
						$json['data'] .= '<i class="fa fa-star"></i>';
					}
				}
				$json['data'] .= '</span>
					 </div>
	                <div cite="/job/view/5059288" class="summary">';

				if (strlen(strip_tags($r['rt_comment'])) > 100) {

					$json['data'] .= '<p class="short_review_' . $serialNumber . '">' . substr(strip_tags($r['rt_comment']), 0, 100) . '... 
	                            <a onclick="$(\'.short_review_' . $serialNumber . '\').hide(); $(\'.long_review_' . $serialNumber . '\').show();" href="javascript:void(0);">read more</a>
	                          </p>
	                          <p class="long_review_' . $serialNumber . '" style="display:none;">' . $r['rt_comment'] . '</p>';
				} else {

					$json['data'] .= '<p class="long_review_' . $serialNumber . '">' . $r['rt_comment'] . '</p>';
				}
				$json['data'] .= '</div>
	                <p class="tradesman-feedback__meta">By <strong class="job-author">' . $get_users['f_name'] . ' ' . $get_users['l_name'] . '</strong>&nbsp;on
	                 
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
		} else {

			$json['ajax_link'] = '';
			$json['data'] .= '<p class="alert alert-danger">No data found.</p>';
		}


		echo json_encode($json);
	}

	public function success()
	{
		$type = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$page['type'] = $type;
		$page['id'] = $id;
		$page['payment_detail'] = false;

		if ($type == 1  || $type == 3 || $type == 4 || $type == 5) {

			if ($type == 1  || $type == 3 || $type == 4) {
				$where = 'ua_id = ' . $id . '';
				$table = 'users_applied';
			} else if ($type == 5) {
				$where = 'tr_id = ' . $id . '';
				$table = 'transactions';
			}

			$payment_detail = $this->common_model->get_single_data($table, $where);
			if ($payment_detail) {
				$page['payment_detail'] = $payment_detail;
			} else {
				$page['msg'] = "Something went wrong try again later.";
			}
		} else {
			$page['msg'] = "Something went wrong try again later.";
		}
		//print_r($page);
		$this->load->view('site/success_payment', $page);
	}

	public function get_progress_data()
	{
		$user_profile = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));

		$percentage = '';
		if ($user_profile['u_email_verify'] == 1) {
			$percentage = 20;
		}

		if (!empty($user_profile['phone_no'])) {

			$percentage = $percentage + 20;
		}
		if (!empty($user_profile['profile'])) {

			$percentage = $percentage + 15;
		}
		$get_certification = $this->common_model->get_education('user_certification', $this->session->userdata('user_id'));
		if ($get_certification) {
			$percentage = $percentage + 15;
		}
		$get_education = $this->common_model->get_education('user_education', $this->session->userdata('user_id'));
		if ($get_education) {
			$percentage = $percentage + 15;
		}
		$get_portfolio = $this->common_model->get_education('user_portfolio', $this->session->userdata('user_id'));
		if ($get_portfolio) {
			$percentage = $percentage + 15;
		}
		return $percentage;
	}

	public function verify()
	{
		$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
		$this->load->view('site/account_verify', $data);
	}

	public function rejected_jobs()
	{
		$user_id = $this->session->userdata('user_id');
		if (!$user_id) {
			redirect('login');
		} else {
			$data['category'] = $this->common_model->get_all_category('category');

			$data['posts'] = $this->common_model->get_all_data('tbl_jobs', array('direct_hired' => 1, 'userid' => $user_id, 'is_delete' => 0, 'status' => 8), 'job_id');
			$this->load->view('site/rejected_jobs', $data);
		}
	}

	public function my_posts()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			//	$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts'] = $this->common_model->get_open_projects('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/my_post_page', $data);
		}
	}

	public function in_progress()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			//$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts'] = $this->common_model->get_job_in_progress('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/in_progress_jobs', $data);
		}
	}

	public function completed_jobs()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			//	$data['posts']=$this->common_model->get_user_posts('tbl_jobs',$this->session->userdata('user_id'));
			$data['posts'] = $this->common_model->get_completed_jobs('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/completed-jobs', $data);
		}
	}

	public function disputed_milestones()
	{
		if ($this->session->userdata('user_id')) {
			if ($this->session->userdata('type') == 1) {
				$data['dispute_miles'] = $this->common_model->get_tradesdispute_milestones();
			} else {
				$data['dispute_miles'] = $this->common_model->get_dispute_milestones();
			}

			$this->load->view('site/disputed_milestones', $data);
		} else {
			redirect('login');
		}
	}

	public function rewards()
	{
		if ($this->session->userdata('user_id')) {
			$data['rewards'] = $this->common_model->get_user_rewards($this->session->userdata('user_id'));
			$this->load->view('site/rewards', $data);
		} else {
			redirect('login');
		}
	}

	public function jobs_completed()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['posts'] = $this->common_model->get_completed_jobs('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress', $data);
		}
	}

	public function jobs_rejected()
	{
		$user_id = $this->session->userdata('user_id');
		if (!$user_id) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['posts'] = $this->common_model->get_all_data('tbl_jobs', array('direct_hired' => 1, 'userid' => $user_id, 'is_delete' => 0, 'status' => 8), 'job_id');
			$this->load->view('site/work_in_progress', $data);
		}
	}

	public function new_jobs()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['posts1'] = $this->common_model->get_open_projects('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress', $data);
		}
	}

	public function recent_jobs()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {

			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$category = $data['user_profile']['category'];
			if ($category) {
				//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
				$data['category'] = $this->common_model->get_all_category('category');
				$data['bids'] = $this->common_model->get_user_jobs_bycatid('tbl_jobs', $category, null, 25);
				$data['bidsss'] = $this->common_model->get_user_jobs_bycatid1('tbl_jobs', $category);
				$this->load->view('site/recent_jobs', $data);
			}
		}
	}

	public function exists_refferals()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			$user_id = $this->session->userdata('user_id');
			$data['balance_amount'] = $this->common_model->get_balance_amount($user_id);
			$data['min_cashout'] = $this->common_model->get_min_cashout($user_id);
			$data['marketers_referrals_list'] = $this->common_model->marketers_referrals_list();
			// echo $this->db->last_query();
			$data['account_info'] = $this->common_model->marketers_account_info($user_id);
			$data['settings'] = $this->common_model->get_single_data("admin_settings", array("id" => 2));
			// echo "<pre>"; print_r($data); exit;
			$data['admin_settings'] = $this->common_model->get_all_data('admin');
			$this->load->view('site/exists_refferals', $data);
		}
	}

	public function payout_request_list()
	{
		$user_id = $this->session->userdata('user_id');
		$data['pending_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id' => $user_id], 'id', 'desc');
		// $data['pending_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>0]);
		// $data['approved_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>1]);
		// $data['rejected_payout_requests'] = $this->common_model->GetAllData('referral_payout_requests', ['user_id'=>$user_id, 'status'=>2]);
		$this->load->view('site/referral_payout', $data);
	}

	public function payment_settings()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			// $user_id = $this->session->userdata('user_id');
			// $data['balance_amount']=$this->common_model->get_balance_amount($user_id);
			// $data['min_cashout']=$this->common_model->get_min_cashout($user_id);
			// $data['marketers_referrals_list']=$this->common_model->marketers_referrals_list();
			$this->load->view('site/payment_settings');
		}
	}

	public function new_referral()
	{
		// $data['get_referral_links']=$this->common_model->get_admin_settings(); 
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			$user_id = $this->session->userdata('user_id');
			$userData = $this->common_model->GetColumnName("users", array("id" => $user_id), array("type"));
			if ($userData["type"] == 1) {
				$data['linkSettings'] = $this->common_model->get_single_data("admin_settings", array("id" => 3)); //$this->db->get('referral_setting')->first_row();
			} else if ($userData["type"] == 2) {
				$data['linkSettings'] = $this->common_model->get_single_data("admin_settings", array("id" => 2)); //$this->db->get('referral_setting')->first_row();
			}
			$this->load->view('site/new_referral', $data);
		}
	}

	public function work_in_progress()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			$data['category'] = $this->common_model->get_all_category('category');
			$data['work_progress'] = $this->common_model->get_trades_working_progress('tbl_jobpost_bids', $this->session->userdata('user_id'));

			$this->load->view('site/trades_work_progress', $data);
		}
	}

	public function completed()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			$data['category'] = $this->common_model->get_all_category('category');
			$data['completed'] = $this->common_model->get_trades_completed('tbl_jobpost_bids', $this->session->userdata('user_id'));

			$this->load->view('site/trades_completed_work', $data);
		}
	}

	public function my_jobs()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$category = $data['user_profile']['category'];
			$data['bids'] = $this->common_model->get_user_jobs_bycat_id('tbl_jobs', $category);
			//$data['bids']=$this->common_model->get_user_all_bids('tbl_jobpost_bids',$this->session->userdata('user_id'));
			$this->load->view('site/my_jobs', $data);
		}
	}

	public function jobs_in_progress()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['posts'] = $this->common_model->get_job_posts_in_progress('tbl_jobs', $this->session->userdata('user_id'));
			$this->load->view('site/work_in_progress', $data);
		}
	}

	public function my_job_bids()
	{
		if (!$this->session->userdata('user_id')) {
			redirect('login');
		} else {
			//$data['posts']=$this->common_model->get_data('tbl_jobs',array('userid'=>$this->session->userdata('user_id'),'status'=>1));
			$data['category'] = $this->common_model->get_all_category('category');
			$data['bids'] = $this->common_model->get_user_all_bids('tbl_jobpost_bids', $this->session->userdata('user_id'));
			$this->load->view('site/my_job_bids', $data);
		}
	}

	public function edit_profile()
	{
		if ($this->session->userdata('user_id')) {
			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$data['portfolio'] = $this->common_model->get_education('user_portfolio', $this->session->userdata('user_id'));
			$data['country'] = $this->common_model->newgetRows('tbl_region', array('is_delete' => 0));
			$this->load->view('site/edit_profile', $data);
		} else {
			redirect('login');
		}
	}

	public function update_profile()
	{
		$u_type = $this->session->userdata('type');
		$user_id = $this->session->userdata('user_id');
		$postal_code = $this->input->post('postal_code');


		$check_postcode = $this->common_model->check_postalcode($postal_code);

		if ($check_postcode['status'] == 1) {
			$insert['longitude'] = $check_postcode['longitude'];
			$insert['latitude'] = $check_postcode['latitude'];

			$user_profile = $this->common_model->get_data('users', array('phone_no' => $this->input->post('phone_no')));

			$userprofile = $this->common_model->get_single_data('users', array('phone_no' => $this->input->post('phone_no')));

			$this->form_validation->set_rules('f_name', 'First Name', 'required');
			$this->form_validation->set_rules('l_name', 'Last Name', 'required');
			// $this->form_validation->set_rules('country','Country','required');

			$this->form_validation->set_rules('locality', 'City', 'required');
			$this->form_validation->set_rules('e_address', 'Address', 'required');
			// print_r($_POST); exit;

			if (count($user_profile) >= 0 && $userprofile['id'] != $user_id) {
				$this->form_validation->set_rules('phone_no', 'Phone number', 'required|integer|is_unique[users.phone_no]', array('is_unique' => 'This phone number is already registered'));
			} else {
				$this->form_validation->set_rules('phone_no', 'Phone number', 'required|integer');
			}

			$this->form_validation->set_rules('postal_code', 'Postal Code', 'required');

			if ($u_type == 1) {
				//$this->form_validation->set_rules('about_business','About Business','required');
				$this->form_validation->set_rules('trading_name', 'Trading Name', 'required');
				//$this->form_validation->set_rules('work_history','Work history','required');
			}

			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">' . validation_errors() . '</div>');
			} else {

				if ($_FILES['profile']['name']) {
					$config['upload_path'] = "img/profile";
					$config['allowed_types'] = 'jpeg|gif|jpg|png';
					$config['encrypt_name'] = true;
					$this->load->library("upload", $config);
					if ($this->upload->do_upload('profile')) {
						$profile = $this->upload->data("file_name");
						$insert['profile'] = $profile;
					}
				}

				$user_id = $this->session->userdata('user_id');

				if ($userprofile['phone_no'] != $this->input->post('phone_no')) {
					$insert['is_phone_verified'] = 0;
				}

				$insert['f_name'] = $this->input->post('f_name');
				$insert['l_name'] = $this->input->post('l_name');
				$insert['county'] = $this->input->post('country');
				$insert['city'] = $this->input->post('locality');
				$insert['postal_code'] = $this->input->post('postal_code');
				// $insert['latitude'] = $this->input->post('latitude');
				// $insert['longitude'] = $this->input->post('longitude');

				if ($u_type == 1) {

					$is_qualification = $this->input->post('is_qualification');

					if ($is_qualification == '1') {
						$insert['qualification'] = $this->input->post('qualification');
					}
					$insurance_liability = $this->input->post('insurance_liability');
					if ($insurance_liability == 'yes') {
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
				$insert['hourly_rate'] = $this->input->post('hourly_rate');

				$run = $this->common_model->update('users', array('id' => $user_id), $insert);

				if ($run) {
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Your profile has been updated successfully.</div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
				}
			}
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Please enter valid UK postcode</div>');
		}

		redirect('edit-profile');
	}

	public function update_marketer_profile()
	{
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
		if ($_FILES['profile']['name']) {
			$config['upload_path'] = "img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('profile')) {
				$profile = $this->upload->data("file_name");
				$insert['profile'] = $profile;
			}
		}
		$this->common_model->update('users', array('id' => $user_id), $insert);
		echo json_encode('1');
		die();
	}

	public function update_marketers_account_details_old()
	{
		$user_id = $this->session->userdata('user_id');
		$insert['account_holder_name'] = $this->input->post('account_holder_name');
		$insert['account_holder_address'] = $this->input->post('account_holder_address');
		$insert['account_number'] = $this->input->post('account_number');
		$insert['sort_code'] = $this->input->post('sort_code');
		$insert['bank_name'] = $this->input->post('bank_name');
		$insert['paypal_email_address'] = $this->input->post('paypal_email_address');
		$this->common_model->update('marketers_account_info', array('user_id' => $user_id), $insert);

		echo json_encode('1');
		die();
	}

	public function update_marketers_account_details()
	{
		$user_id = $this->session->userdata('user_id');
		$insert['wd_account_holder'] = $this->input->post('account_holder_name');
		$insert['wd_bank'] = $this->input->post('bank_name');
		$insert['wd_account'] = $this->input->post('account_number');
		$insert['wd_ifsc_code'] = $this->input->post('sort_code');

		$insert['account_holder_address'] = $this->input->post('account_holder_address');
		$insert['paypal_email_address'] = $this->input->post('paypal_email_address');
		$check = $this->common_model->get_single_data('wd_bank_details', array('wd_user_id' => $user_id));
		if (!empty($check)) {
			$this->common_model->update('wd_bank_details', array('wd_user_id' => $user_id), $insert);
			$this->session->set_flashdata('success', '<div class="alert alert-success">Success! payment setting has been updated successfully..</div>');
		} else {
			$insert['wd_user_id'] = $user_id;
			$this->common_model->insert('wd_bank_details', $insert);
			$this->session->set_flashdata('success', '<div class="alert alert-success">Success! payment setting has been inserted successfully..</div>');
		}
		echo json_encode('1');
		die();
	}

	public function reset_password()
	{
		$user_id = $this->session->userdata('user_id');
		$insert['password'] = $this->input->post('password');
		$this->common_model->update('users', array('id' => $user_id), $insert);
		echo json_encode('1');
		die();
	}

	public function trades()
	{
		if ($this->session->userdata('user_id')) {
			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$data['parent_category'] = $this->common_model->get_parent_category('category');
			$data['category'] = $this->common_model->GetAllData('category');
			$this->load->view('site/user_category', $data);
		} else {
			redirect('login');
		}
	}

	public function company()
	{
		if ($this->session->userdata('user_id')) {
			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));
			$this->load->view('site/company_page', $data);
		} else {
			redirect('login');
		}
	}

	public function update_company()
	{
		$user_id = $this->session->userdata('user_id');
		$insert['company'] = $this->input->post('company');
		$insert['business_type'] = $this->input->post('business_type');
		$insert['no_of_employee'] = $this->input->post('no_of_employee');
		$insert['active_since'] = $this->input->post('active_since');
		$insert['u_website'] = $this->input->post('u_website');
		$run = $this->common_model->update('users', array('id' => $user_id), $insert);
		if ($run) {
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Company Details updated successfully.</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
		}
		redirect('company');
	}

	public function change_password()
	{
		$this->load->view('site/change-password');
	}

	public function upload_address($userid, $page = null)
	{
		if ($_FILES['u_address']['name']) {
			$ext = end(explode(".", $_FILES['u_address']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['u_address']['tmp_name'], 'img/verify/' . $files)) {
				$insert['u_address'] = $files;
				$insert['u_status_add'] = 1;
				$insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users', array('id' => $userid), $insert);
		$get_users = $this->common_model->get_single_data('users', array('id' => $userid));
		if ($run) {
			$sub = 'New document uploaded for address verification';
			$data = $this->common_model->getAdminRow('admin');
			$to = $data['email'];
			$body = "<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>" . $get_users['f_name'] . ' ' . $get_users['l_name'] . "</p><p><b>Email ID : </b>" . $get_users['email'] . "</p><p><b>Phone No. : </b>" . $insert['phone_no'] . "</p>";
			if ($files) {
				$mail_responce = $this->common_model->send_mail_file($to, $sub, $body, $files);
			} else {
				$mail_responce = $this->common_model->send_mail($to, $sub, $body);
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if ($page) {
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}

	public function upload_idcard($userid, $page = null)
	{
		if ($_FILES['u_id_card']['name']) {
			$ext = end(explode(".", $_FILES['u_id_card']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['u_id_card']['tmp_name'], 'img/verify/' . $files)) {
				$insert['u_id_card'] = $files;
				$insert['u_id_card_status'] = 1;
				$insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users', array('id' => $userid), $insert);
		$get_users = $this->common_model->get_single_data('users', array('id' => $userid));
		if ($run) {
			$sub = 'New document uploaded for address verification';
			$data = $this->common_model->getAdminRow('admin');
			$to = $data['email'];
			$body = "<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>" . $get_users['f_name'] . ' ' . $get_users['l_name'] . "</p><p><b>Email ID : </b>" . $get_users['email'] . "</p><p><b>Phone No. : </b>" . $insert['phone_no'] . "</p>";
			if ($files) {
				$mail_responce = $this->common_model->send_mail_file($to, $sub, $body, $files);
			} else {
				$mail_responce = $this->common_model->send_mail($to, $sub, $body);
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if ($page) {
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}

	public function upload_insurance($userid, $page = null)
	{
		if ($_FILES['u_insurrance_certi']['name']) {
			$ext = end(explode(".", $_FILES['u_insurrance_certi']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['u_insurrance_certi']['tmp_name'], 'img/verify/' . $files)) {
				$insert['u_insurrance_certi'] = $files;
				$insert['u_status_insure'] = 1;
				$insert['document_updated'] = date("Y-m-d H:i:s");
			}
		}
		$run = $this->common_model->update('users', array('id' => $userid), $insert);
		$get_users = $this->common_model->get_single_data('users', array('id' => $userid));
		if ($run) {
			$sub = 'New document uploaded for insurrance verification';
			$data = $this->common_model->getAdminRow('admin');
			$to = $data['email'];
			$body = "<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>" . $get_users['f_name'] . ' ' . $get_users['l_name'] . "</p><p><b>Email ID : </b>" . $get_users['email'] . "</p><p><b>Phone No. : </b>" . $insert['phone_no'] . "</p>";
			if ($files) {
				$mail_responce = $this->common_model->send_mail_file($to, $sub, $body, $files);
			} else {
				$mail_responce = $this->common_model->send_mail($to, $sub, $body);
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		if ($page) {
			redirect($page);
		} else {
			redirect('dashboard');
		}
	}

	public function upload_bill($userid)
	{
		if ($_FILES['u_bill']['name']) {
			$ext = end(explode(".", $_FILES['u_bill']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['u_bill']['tmp_name'], 'img/verify/' . $files)) {
				$insert['u_bill'] = $files;
				$insert['u_status_bill'] = 1;
			}
		}
		$run = $this->common_model->update('users', array('id' => $userid), $insert);
		$get_users = $this->common_model->get_single_data('users', array('id' => $userid));
		if ($run) {
			$sub = 'New document uploaded for billing verification';
			$data = $this->common_model->getAdminRow('admin');
			$to = $data['email'];
			$body = "<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>" . $get_users['f_name'] . ' ' . $get_users['l_name'] . "</p><p><b>Email ID : </b>" . $get_users['email'] . "</p><p><b>Phone No. : </b>" . $insert['phone_no'] . "</p>";
			if ($files) {
				$mail_responce = $this->common_model->send_mail_file($to, $sub, $body, $files);
			} else {
				$mail_responce = $this->common_model->send_mail($to, $sub, $body);
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		redirect('verify');
	}

	public function upload_photo($userid)
	{
		if ($_FILES['u_photo_id']['name']) {
			$ext = end(explode(".", $_FILES['u_photo_id']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['u_photo_id']['tmp_name'], 'img/verify/' . $files)) {
				$insert['u_photo_id'] = $files;
				$insert['u_status_photo_id'] = 1;
			}
		}
		$run = $this->common_model->update('users', array('id' => $userid), $insert);
		$get_users = $this->common_model->get_single_data('users', array('id' => $userid));
		if ($run) {
			$sub = 'New document uploaded for photo ID verification';
			$data = $this->common_model->getAdminRow('admin');
			$to = $data['email'];
			$body = "<p><b>New document uploaded and waiting for verification.</b></p><p>Details are given below : </p><p><b>Name : </b>" . $get_users['f_name'] . ' ' . $get_users['l_name'] . "</p><p><b>Email ID : </b>" . $get_users['email'] . "</p><p><b>Phone No. : </b>" . $insert['phone_no'] . "</p>";
			if ($files) {
				$mail_responce = $this->common_model->send_mail_file($to, $sub, $body, $files);
			} else {
				$mail_responce = $this->common_model->send_mail($to, $sub, $body);
			}

			$this->session->set_flashdata('success', 'Your document has been uploaded successfully.Please wait for admin response.');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong.Please try again.');
		}
		redirect('verify');
	}

	public function update_password()
	{
		$this->form_validation->set_rules('old_pass', 'Password', 'required');
		$this->form_validation->set_rules('new_pass', 'New Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[new_pass]');
		if ($this->form_validation->run() == false) {

			$json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
			$json['status'] = 0;
		} else {

			$u_password = $this->input->post('old_pass');
			$new_password = $this->input->post('new_pass');

			$user_id = $this->session->userdata('user_id');
			$userdata = $this->common_model->get_userDataByid($user_id);
			if ($userdata['password'] === $u_password) {

				$run = $this->common_model->update('users', array('id' => $user_id), array('password' => $new_password));

				if ($run) {
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

	public function update_image($id)
	{
		if ($_FILES['u_profile']['name']) {
			$config['upload_path'] = "img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('u_profile')) {
				$u_profile = $this->upload->data("file_name");
				$insert['profile'] = $u_profile;

				$u_profile_old = $this->input->post('u_profile_old');
				if ($u_profile_old) {
					unlink('img/profile/' . $u_profile_old);
				}
			} else {
				$this->session->set_flashdata('msg2', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			}
		}

		$run = $this->common_model->update('users', array('id' => $id), $insert);
		if ($run) {
			$this->session->set_flashdata('success', 'Success! Profile Image Updated Successfully.');
		} else {
			$this->session->set_flashdata('error', 'We have not found any changes.');
		}
		redirect('profile/' . $id);
	}

	public function portfolio()
	{
		$this->load->view('site/add-portfolio');
	}

	public function update_data($id)
	{
		$update['about_business'] = $this->input->post('about_business');
		$run = $this->common_model->update('users', array('id' => $id), $update);
		if ($run) {
			$this->session->set_flashdata('success1', 'Success! Profile Updated Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'We have not found any changes.');
		}
		redirect('profile/' . $id);
	}

	public function add_portfolio()
	{
		$id = $this->session->userdata['user_id'];
		$insert['userid'] = $id;
		if ($_FILES['port_image']['name']) {
			$ext = end(explode(".", $_FILES['port_image']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['port_image']['tmp_name'], 'img/profile/' . $files)) {

				$insert['port_image'] = $files;

				$run = $this->common_model->insert('user_portfolio', $insert);

				if ($run) {
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

		redirect('profile/' . $id . '/?edit_portfolio=1');
	}

	public function edit_portfolio($id)
	{
		$ids = $this->session->userdata['user_id'];
		if ($_FILES['port_image']['name']) {
			$config['upload_path'] = "img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('port_image')) {
				$u_profile = $this->upload->data("file_name");
				$insert['port_image'] = $u_profile;

				$u_profile_old = $this->input->post('port_image_old');
				if ($u_profile_old) {
					unlink('img/profile/' . $u_profile_old);
				}
			} else {
				$this->session->set_flashdata('msg2', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			}
		}

		$run = $this->common_model->update('user_portfolio', array('id' => $id), $insert);
		//$insert1['category']=implode(',',$this->input->post('category'));
		//$run = $this->common_model->update('users',array('id'=>$ids),$insert1);
		if ($run) {
			$this->session->set_flashdata('success1', 'Success! Portfolio Updated Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'We have not found any changes.');
		}
		redirect('profile/' . $ids);
	}

	public function update_skills($id)
	{
		$insert1['skills'] = implode(',', $this->input->post('skills'));
		$run = $this->common_model->update('users', array('id' => $id), $insert1);
		if ($run) {
			$this->session->set_flashdata('success1', 'Success! Skills Added Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'Something went wrong,please try again later!');
		}
		redirect('profile/' . $id);
	}

	public function update_catgory($id)
	{
		$insert1['category'] = implode(',', $this->input->post('category'));
		$run = $this->common_model->update('users', array('id' => $id), $insert1);

		if ($this->input->post('trades') == 'trades') {
			if ($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Category Added Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
			}
			redirect('trades');
		} else {
			if ($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Category Updated Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something went wrong,please try again later!</div>');
			}

			redirect('profile/' . $id);
		}
	}

	public function update_subcatgory($id)
	{
		$insert1['subcategory'] = implode(',', $this->input->post('subcategory'));
		$run = $this->common_model->update('users', array('id' => $id), $insert1);

		if ($this->input->post('trades') == 'trades') {
			if ($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Category Added Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">We have not found any changes.</div>');
			}
			redirect('trades');
		} else {
			if ($run) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Success! Category Updated Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something went wrong,please try again later!</div>');
			}

			redirect('profile/' . $id);
		}
	}

	public function my_reviews()
	{
		if ($this->session->userdata('user_id')) {
			$data['reviews'] = $this->common_model->get_all_feedback($this->session->userdata('user_id'));
			$this->load->view('site/user_review', $data);
		} else {
			redirect('login');
		}
	}

	public function delete_portfolio($id)
	{
		$ida = $this->session->userdata('user_id');
		$result = $this->common_model->delete(array('id' => $id), 'user_portfolio');
		if ($result) {
			$this->session->set_flashdata('success1', 'Success! Portfolio Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error1', 'Something went wrong please try again later.');
		}

		redirect('profile/' . $ida);
	}

	public function add_education()
	{
		$id = $this->session->userdata('user_id');
		$insert['institute'] = $this->input->post('institute');
		$insert['degree'] = $this->input->post('degree');
		$insert['start_year'] = $this->input->post('start_year');
		$insert['end_year'] = $this->input->post('end_year');
		$insert['summary'] = $this->input->post('summary');
		$insert['userid'] = $this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_education', $insert);
		if ($run) {
			$this->session->set_flashdata('success2', 'Success! Qualification Added Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $id);
	}

	public function edit_education($id)
	{
		$ida = $this->session->userdata('user_id');
		$insert['institute'] = $this->input->post('institute');
		$insert['degree'] = $this->input->post('degree');
		$insert['start_year'] = $this->input->post('start_year');
		$insert['end_year'] = $this->input->post('end_year');
		$insert['summary'] = $this->input->post('summary');
		$run = $this->common_model->update('user_education', array('id' => $id), $insert);
		if ($run) {
			$this->session->set_flashdata('success2', 'Success! Qualification Updated Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'We have not found any changes.');
		}
		redirect('profile/' . $ida);
	}

	public function delete_education($id)
	{
		$ida = $this->session->userdata('user_id');
		$result = $this->common_model->delete(array('id' => $id), 'user_education');
		if ($result) {
			$this->session->set_flashdata('success2', 'Success! Qualification Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error2', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $ida);
	}

	public function add_publication()
	{
		$id = $this->session->userdata('user_id');
		$insert['heading'] = $this->input->post('heading');
		$insert['title'] = $this->input->post('title');
		$insert['description'] = $this->input->post('description');
		$insert['userid'] = $this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_publication', $insert);
		if ($run) {
			$this->session->set_flashdata('success3', 'Success! Publication Added Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $id);
	}

	public function edit_publication($id)
	{
		$ids = $this->session->userdata('user_id');
		$insert['heading'] = $this->input->post('heading');
		$insert['title'] = $this->input->post('title');
		$insert['description'] = $this->input->post('description');

		$run = $this->common_model->update('user_publication', array('id' => $id), $insert);
		if ($run) {
			$this->session->set_flashdata('success3', 'Success! Publication Updated Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'We have not found any changes.');
		}
		redirect('profile/' . $ids);
	}

	public function delete_publication($id)
	{
		$ida = $this->session->userdata('user_id');
		$result = $this->common_model->delete(array('id' => $id), 'user_publication');
		if ($result) {
			$this->session->set_flashdata('success3', 'Success! Publication Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $ida);
	}

	public function add_insurance()
	{
		$ids = $this->session->userdata('user_id');
		$insert['insurance_liability'] = $this->input->post('insurance_liability');
		$insert['insured_by'] = $this->input->post('insured_by');
		$insert['insurance_amount'] = $this->input->post('insurance_amount');
		$insert['insurance_date'] = $this->input->post('insurance_date');
		$test = $this->input->post('test123');

		$run = $this->common_model->update('users', array('id' => $ids), $insert);
		if ($run) {
			if ($test == '') {
				$this->session->set_flashdata('success4', 'Success! Insurance Added Successfully.');
			} else {
				$this->session->set_flashdata('success4', 'Success! Insurance Updated Successfully.');
			}
		} else {
			if ($test == '') {
				$this->session->set_flashdata('error4', 'Something went wrong please try again later.');
			} else {
				$this->session->set_flashdata('error4', 'We have not found any changes.');
			}
		}
		redirect('profile/' . $ids);
	}

	public function delete_insurance()
	{
		$ids = $this->session->userdata('user_id');
		$insert['insurance_liability'] = '';
		$insert['insured_by'] = '';
		$insert['insurance_amount'] = '';
		$insert['insurance_date'] = '';
		$run = $this->common_model->update('users', array('id' => $ids), $insert);
		if ($run) {
			$this->session->set_flashdata('success4', 'Success! Insurance Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error4', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $ids);
	}

	public function add_certification()
	{
		$id = $this->session->userdata('user_id');
		$insert['title'] = $this->input->post('title');
		$insert['organization'] = $this->input->post('organization');
		$insert['description'] = $this->input->post('description');
		$insert['year'] = $this->input->post('year');
		if ($_FILES['certificate']['name']) {
			$ext = end(explode(".", $_FILES['certificate']['name']));
			$files = rand(10, 1000) . time() . "." . $ext;
			if (move_uploaded_file($_FILES['certificate']['tmp_name'], 'img/profile/' . $files)) {
				$insert['certificate'] = $files;
			}
		}
		$insert['userid'] = $this->session->userdata['user_id'];
		$run = $this->common_model->insert('user_certification', $insert);
		if ($run) {
			$this->session->set_flashdata('success3', 'Success! Certificate Added Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $id);
	}

	public function edit_certification($id)
	{
		$ids = $this->session->userdata('user_id');
		$insert['title'] = $this->input->post('title');
		$insert['organization'] = $this->input->post('organization');
		$insert['description'] = $this->input->post('description');
		$insert['year'] = $this->input->post('year');
		if ($_FILES['certificate']['name']) {
			$config['upload_path'] = "img/profile";
			$config['allowed_types'] = 'jpeg|gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('certificate')) {
				$u_profile = $this->upload->data("file_name");
				$insert['certificate'] = $u_profile;

				$u_profile_old = $this->input->post('certificate_image_old');
				if ($u_profile_old) {
					unlink('img/profile/' . $u_profile_old);
				}
			} else {
				$this->session->set_flashdata('msg2', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
			}
		}
		$run = $this->common_model->update('user_certification', array('id' => $id), $insert);
		if ($run) {
			$this->session->set_flashdata('success3', 'Success! Certificate Updated Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'We have not found any changes.');
		}
		redirect('profile/' . $ids);
	}

	public function delete_certificate($id)
	{
		$ida = $this->session->userdata('user_id');
		$result = $this->common_model->delete(array('id' => $id), 'user_certification');
		if ($result) {
			$this->session->set_flashdata('success3', 'Success! Certificate Deleted Successfully.');
		} else {
			$this->session->set_flashdata('error3', 'Something went wrong please try again later.');
		}
		redirect('profile/' . $ida);
	}

	public function milestone_requests()
	{
		$data['milestones'] = $this->common_model->get_milestone_request('tbl_milestones', $this->session->userdata('user_id'));
		$this->load->view('site/milestone_request', $data);
	}

	public function fund_withdrawal()
	{
		if ($this->session->userdata('user_id')) {

			$user_id = $this->session->userdata('user_id');

			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $user_id));

			$data['withdrawal'] = $this->common_model->get_all_userwithdrawal($user_id);

			$data['last_paypal'] = $this->common_model->GetColumnName('tbl_withdrawal', array('wd_userid' => $user_id, 'wd_pay_email !=' => ''), array('wd_pay_email'), null, 'wd_id');

			$data['last_bank'] = $this->common_model->GetColumnName('tbl_withdrawal', array('wd_userid' => $user_id, 'wd_account !=' => ''), array('wd_account_holder', 'wd_bank', 'wd_account', 'wd_ifsc_code'), null, 'wd_id');

			$data['banks'] = $this->common_model->GetAllData('wd_bank_details', ['wd_user_id' => $user_id], 'id', 'desc');

			$data['setting'] = $this->common_model->get_single_data('admin', array('id' => 1));

			$this->load->view('site/fund_withdrawal', $data);
		} else {
			redirect('login');
		}
	}

	public function earnings()
	{
		if ($this->session->userdata('user_id')) {

			$user_id = $this->session->userdata('user_id');

			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $user_id));

			//$sql = "select tbl_milestones.*, tbl_jobs.title as job_title from tbl_milestones inner join tbl_jobs on tbl_milestones.post_id = tbl_jobs.job_id where tbl_milestones.userid = $user_id and (tbl_milestones.status = 2 or (tbl_milestones.status = 6 and tbl_milestones.is_dispute_to_traders = 1)) order by tbl_milestones.updated_at desc, tbl_milestones.id desc";

			$sql = "
		    SELECT 
		        tbl_milestones.*, 
		        tbl_jobs.title AS job_title, 
		        my_services.service_name AS service_title
		    FROM 
		        tbl_milestones
		    LEFT JOIN 
		        tbl_jobs 
		        ON tbl_milestones.post_id = tbl_jobs.job_id
		    LEFT JOIN 
		        service_order 
		        ON tbl_milestones.post_id = service_order.id
		    LEFT JOIN 
		        my_services 
		        ON service_order.service_id = my_services.id
		    WHERE 
		        tbl_milestones.userid = $user_id 
		        AND (
		            tbl_milestones.status = 2 OR 
		            (tbl_milestones.status = 6 AND tbl_milestones.is_dispute_to_traders = 1)
		        )
		    ORDER BY 
		        tbl_milestones.updated_at DESC, 
		        tbl_milestones.id DESC";

			$run = $this->db->query($sql);


			$lists = array();
			if ($run->num_rows() > 0) {
				$lists = $run->result_array();
			}

			//echo '<pre>'; print_r($lists); die();

			$data['lists'] = $lists;

			$this->load->view('site/earnings', $data);
		} else {
			redirect('login');
		}
	}

	public function invoices()
	{
		if ($this->session->userdata('user_id')) {
			$type = $this->session->userdata('type');

			$data['invoices'] = $this->common_model->get_all_milestone_invoice($this->session->userdata('user_id'), $type);

			// echo '<pre>';
			// print_r($data['invoices']);
			// exit;

			$this->load->view('site/milestone_invoice', $data);
		} else {
			redirect('login');
		}
	}
	public function contact_admin()
	{
		$user_id = $this->session->userdata('user_id');
		$get_user = $this->common_model->get_single_data('users', array('id' => $user_id));
		$fullname = $get_user['f_name'] . '' . $get_user['l_name'];
		$phone_no = $get_user['phone_no'];
		$email = $get_user['email'];
		$contact_msg = $_POST['contact_msg'];
		$cdate = date('Y-m-d H:i:s');
		$query = $this->db->query('SELECT * FROM `admin`');
		if ($query->num_rows() > 0) {
			$query_res = $query->result();
			$review_email = $query_res[0]->email;
		} else {
			$review_email = '';
		}

		$this->common_model->insert('contact_request', ['first_name' => $get_user['f_name'], 'last_name' => $get_user['l_name'], 'email' => $get_user['email'], 'phone_no' => $get_user['phone_no'], 'message' => $contact_msg, 'type' => $get_user['type'], 'cdate' => $cdate]);

		$subject = "Marketer Message";

		$html = '<div class="row"><span>Marketer Message </span><span>:</span><span>' . $contact_msg . '</span></div>';
		$html .= '<p>Marketer Details</p>';
		$html .= '<div class="row"><span>Name </span><span>:</span><span>' . $fullname . '</span></div>';
		$html .= '<div class="row"><span>Phone no </span><span>:</span><span>' . $phone_no . '</span></div>';
		$html .= '<div class="row"><span>Email </span><span>:</span><span>' . $email . '</span></div>';
		$this->common_model->send_mail($review_email, $subject, $html);
		echo json_encode(1);
		die();
	}

	public function manageBank()
	{
		$user_id = $this->session->userdata('user_id');
		$data['banks'] = $this->common_model->GetAllData('wd_bank_details', ['wd_user_id' => $user_id], 'id', 'desc');

		$this->load->view('site/manage-banks', $data);
	}

	public function delete_account()
	{
		$this->load->view('site/deleteAccount');
	}

	public function send_delete_request()
	{
		$user_id = $this->session->userdata('user_id');
		$user = $this->common_model->get_single_data('users', array('id' => $user_id));

		if ($user['delete_request'] == 1) {
			echo 2;
			exit;
		}

		if (in_array($user['delete_request'], [0, 3])) {
			$insert1['delete_request'] = 1;
			$insert1['delete_reason'] = $this->input->post('reason');
			$run = $this->common_model->update('users', array('id' => $user_id), $insert1);

			/*New entry for manage delete request history*/
			$insert['user_id'] = $user_id;
			$insert['user_type'] = $user['type']; //1=>Tradesman, 2=> Homeowner
			$insert['name'] = $user['f_name'] . ' ' . $user['l_name'];
			$insert['email'] = $user['email'];
			$insert['delete_request'] = 1;
			$insert['delete_reason'] = $this->input->post('reason');
			$this->common_model->insert('delete_account_request', $insert);
			/*New entry for manage delete request history*/

			if ($run) {
				echo 1;
				exit;
			} else {
				echo 0;
				exit;
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

	public function dragDrop()
	{
		$data['status'] = 0;
		$user_id = $this->session->userdata('user_id');
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/profile/' . $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['userid'] = $user_id;
			$insert['port_image'] = $fileName;
			$uploaded = $this->common_model->insert('user_portfolio', $insert);
			if ($uploaded) {
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
				$data['imgName'] = base_url() . 'img/profile/' . $fileName;
			}
		}
		echo json_encode($data);
	}

	public function dragDropService()
	{
		$data['status'] = 0;
		$service_id = $this->input->post('service_id');
		$type = $this->input->post('type');
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/services/' . $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['service_id'] = $service_id;
			$insert['image'] = $fileName;
			$insert['type'] = $type;
			$uploaded = $this->common_model->insert('service_images', $insert);
			if ($uploaded) {
				$data['status'] = 1;
				$data['id'] = $uploaded;
				$data['imgName'] = base_url() . 'img/services/' . $fileName;
				$serviceData = $this->session->userdata('service_data');
				if ($type == 'file') {
					if (isset($serviceData['multi_files']) && $serviceData['multi_files']) {
						$multiFiles = $serviceData['multi_files'];
						$multiFiles[$uploaded] = $data['imgName'];
					} else {
						$multiFiles[$uploaded] = $data['imgName'];
					}
					$this->setServiceData(['multi_files' => $multiFiles]);
				} else {
					if (isset($serviceData['multi_images']) && $serviceData['multi_images']) {
						$multiImages = $serviceData['multi_images'];
						$multiImages[$uploaded] = $data['imgName'];
					} else {
						$multiImages[$uploaded] = $data['imgName'];
					}
					$this->setServiceData(['multi_images' => $multiImages]);
				}
			}
		}
		echo json_encode($data);
	}

	public function dragDropRequirementAttachment()
	{
		$data['status'] = 0;
		$requirement_id = $this->input->post('requirement_id');
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/services/' . $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['requirement_id'] = $requirement_id;
			$insert['attachment'] = $fileName;
			$uploaded = $this->common_model->insert('order_requirement_attachment', $insert);
			if ($uploaded) {
				$data['status'] = 1;
				$data['id'] = $uploaded;
				$data['imgName'] = base_url() . 'img/services/' . $fileName;
			}
		}
		echo json_encode($data);
	}

	public function dragDropProjectSubmitAttachment()
	{
		$data['status'] = 0;
		$conversation_id = $this->input->post('conversation_id');
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetFile = 'img/services/' . $_FILES['file']['name'];
			$fileName = $_FILES['file']['name'];
			move_uploaded_file($tempFile, $targetFile);
			$insert['conversation_id'] = $conversation_id;
			$insert['attachment'] = $fileName;
			$uploaded = $this->common_model->insert('order_submit_attachments', $insert);
			if ($uploaded) {
				$data['status'] = 1;
				$data['id'] = $uploaded;
				$data['imgName'] = base_url() . 'img/services/' . $fileName;
			}
		}
		echo json_encode($data);
	}

	public function removePortfolio()
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->where('id', $this->input->post('pImgId'))->where('userid', $user_id)->delete('user_portfolio');
		exit;
	}

	public function my_services()
	{
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		if ($this->session->userdata('user_id')) {
			$data['my_services'] = $this->common_model->get_my_service('my_services', $this->session->userdata('user_id'), $status);
			$data['statusArr'] = ['active', 'approval_pending', 'required_modification', 'draft', 'denied', 'paused'];
			$data['totalStatusService'] = $this->common_model->getTotalStatusService($this->session->userdata('user_id'));
			$this->load->view('site/my_services', $data);
		} else {
			redirect('login');
		}
	}

	public function getAllServices()
	{
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		if ($this->session->userdata('user_id')) {
			$services = $this->common_model->get_my_service('my_services', $this->session->userdata('user_id'), $status);
			$data = [];

			foreach ($services as $service) {
				$statusSwitch = '';
				if (in_array($service['status'], ['active', 'paused'])) {
					$checked = $service['status'] == 'paused' ? 'checked' : '';
					$statusSwitch = '<br><label class="switch">
							<input type="checkbox" class="serviceSwitch" data-id="' . $service['id'] . '" name="paused" ' . $checked . ' id="sp_' . $service['id'] . '">
							<span class="switch-slider round"></span>						  
						</label>';
				} else {
					if (in_array($service['status'], ['denied', 'required_modification'])) {
						$statusSwitch = '<br><span class="viewReason text-danger" data-id="' . $service['id'] . '">View Reason</span>';
					}
				}

				$data[] = [
					'id' => $service['id'],
					'status' => ucwords(str_replace('_', ' ', $service['status'])) . $statusSwitch,
					'image' => $service['image'],
					'service_name' => $service['service_name'],
					'created_at' => $service['created_at'],
					'price' => $service['price'],
					'slug' => $service['slug']
				];
			}

			echo json_encode(['data' => $data]);
		} else {
			echo json_encode(['data' => []]);
		}
	}

	public function my_orders()
	{
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		if ($this->session->userdata('user_id')) {
			$flashMessage = '';
			if ($this->session->flashdata('false_message')) {
				$flashMessage = $this->session->flashdata('false_message');
				$this->session->unset_userdata('false_message');
			}
			$data['flashMessage'] = $flashMessage;
			$data['my_orders'] = $this->common_model->getAllOrder('service_order', $this->session->userdata('user_id'), $status, 0);
			$data['totalStatusOrder'] = $this->common_model->getTotalStatusOrder($this->session->userdata('user_id'));
			$data['statusArr'] = ['placed', 'active', 'delivered', 'completed', 'cancelled', 'disputed', 'all'];
			$this->load->view('site/my_orders', $data);
		} else {
			redirect('login');
		}
	}

	public function getAllOrders()
	{
		$status = isset($_GET['status']) && !empty($_GET['status']) ? $_GET['status'] : '';
		$type = $this->session->userdata('type');
		if ($this->session->userdata('user_id')) {
			$orders = $this->common_model->getAllOrder('service_order', $this->session->userdata('user_id'), $status);

			$data = [];

			$statusArr = ['placed', 'active', 'delivered', 'completed', 'cancelled', 'disputed', 'all'];
			foreach ($orders as $order) {
				$date = new DateTime($order['created_at']);

				if ($this->session->userdata('type') == 1) {
					$selected1 = $order['status'] == 'pending' ? 'selected' : '';
					$selected2 = $order['status'] == 'active' ? 'selected' : '';
					$selected3 = $order['status'] == 'completed' ? 'selected' : '';
					$selected4 = $order['status'] == 'cancelled' ? 'selected' : '';
					$selected5 = $order['status'] == 'request_modification' ? 'selected' : '';
					$selected6 = $order['status'] == 'disputed' ? 'selected' : '';

					$status = '<select class="form-control orderStatus" data-id="' . $order['id'] . '">
	                            <option value="pending" ' . $selected1 . '>Pending</option>
	                            <option value="active" ' . $selected2 . '>Started</option>
	                            <option value="completed" ' . $selected3 . '>Completed</option>
	                            <option value="cancelled" ' . $selected4 . '>Cancelled</option>
	                            <option value="request_modification" ' . $selected5 . '>Request Modification</option>
	                            <option value="disputed" ' . $selected6 . '>Disputed</option>
	                        </select>';
				} else {
					if ($order['status'] == 'completed') {
						$status = '<button class="btn btn-success orderAgain" type="button" data-id="' . $order['id'] . '">Order Again</button>';
					} else {
						$status = '<label class="badge bg-dark p-3">' . ucfirst(str_replace('_', ' ', $order['status'])) . '</label>';
					}
				}

				$requirements = '<button class="btn btn-warning requirements" data-id="' . $order['id'] . '">Requirements</button>';

				if ($type == 1) {
					$btnName = $order['status'] == 'offer_created' ? 'Withdraw Offer' : 'View Order';
				} else {
					$btnName = $order['status'] == 'offer_created' ? 'Respond Now' : 'View Order';
				}

				$viewOrder = '<a class="btn btn-anil_btn nx_btn" href="' . base_url('order-tracking/' . $order['id']) . '">' . $btnName . '</a>';

				$link = base_url('order-tracking/' . $order['id']);

				$data[] = [
					'id' => $order['id'],
					'order_id' => $order['order_id'],
					'service_name' => array('file' => !empty($order['image']) ? $order['image'] : $order['video'], 'service_name' => $order['service_name'], 'link' => $link),
					'created_at' => $date->format('F j, Y'),
					'total_price' => '£' . number_format($order['price'], 2),
					'status' => $status,
					'requirements' => $requirements,
					'viewOrder' => $viewOrder
				];
			}

			echo json_encode(['data' => $data]);
		} else {
			echo json_encode(['data' => []]);
		}
	}

	public function addServices()
	{
		if ($this->session->userdata('user_id')) {
			$this->reserServiceTabData();
			$this->resetEditServiceTabData();

			$this->openAddServiceForm();
		}
	}

	public function openAddServiceForm()
	{
		if ($this->session->userdata('user_id')) {
			$data['cities'] = $this->common_model->get_all_data('location', ['is_delete' => 0]);
			$data['category'] = $this->common_model->get_parent_category('service_category', 0, 1);
			$sesData = $this->session->userdata('store_service1');

			$sub_category = !empty($sesData['sub_category']) ? explode(',', $sesData['sub_category']) : [];
			$service_type = !empty($sesData['service_type']) ? explode(',', $sesData['service_type']) : [];

			$this->session->set_userdata('sub_category_data', $sub_category);
			$this->session->set_userdata('service_type_data', $service_type);

			$data['price_per_type'] = !empty($data['category']['price_type_list']) ? explode(',', $data['category']['price_type_list']) : [];

			$data['service_type'] = $this->common_model->getServiceType($service_type);

			$data['attributes'] = $this->common_model->get_all_data('service_attribute', ['service_cat_id' => $sesData['category']]);
			$data['ex_service'] = $this->common_model->get_all_data('extra_service', ['category' => $sesData['category']]);
			$data['service_category'] = $this->common_model->GetSingleData('service_category', ['cat_id' => $sesData['category']]);
			$data['price_per_type'] = !empty($data['service_category']['price_type_list']) ? explode(',', $data['service_category']['price_type_list']) : [];

			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));

			$data['portfolio'] = $this->common_model->get_education('user_portfolio', $this->session->userdata('user_id'));

			$data['serviceId'] = 0;
			$this->load->view('site/add-service', $data);
		}
	}

	public function addServices2()
	{
		if ($this->session->userdata('store_service1')) {
			$data['category'] = $this->common_model->get_parent_category('service_category', 0, 1);
			$this->load->view('site/add-service2', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices3()
	{
		if ($this->session->userdata('store_service2')) {
			$sesData = $this->session->userdata('store_service2');
			$data['ex_service'] = $this->common_model->get_ex_service('extra_service', $sesData['category']);
			$this->load->view('site/add-service3', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices4()
	{
		if ($this->session->userdata('store_service2')) {
			$this->load->view('site/add-service4', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices5()
	{
		if ($this->session->userdata('latest_service')) {
			$this->load->view('site/add-service5', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function addServices6()
	{
		if ($this->session->userdata('latest_service')) {
			$this->load->view('site/add-service6', $data);
		} else {
			redirect('dashboard');
		}
	}

	public function storeServices($value = '')
	{
		//$submitBtn = $this->input->post('submit_listing');
		$this->form_validation->set_rules('service_name', 'Service Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('area', 'City/Town', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('sub_category[]', 'Sub Category', 'required');
		$this->form_validation->set_rules('service_type[]', 'Service Type', 'required');
		$this->form_validation->set_rules('positive_keywords[]', 'Positive Keywords', 'required');
		//$this->form_validation->set_rules('image','Image/Video','required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 1);
			redirect('open-add-service');
		}

		if (count($this->input->post('service_type')) > 3) {
			$this->session->set_flashdata('error', "You need to select only 3 service types");
			$this->session->set_userdata('next_step', 1);
			redirect('open-add-service');
		}

		/*$newImg = '';
		if($_FILES['image']['name']){ 
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('image')) {
				$profile=$this->upload->data("file_name");
				$newImg = $profile;
			} 
		}*/

		$subCat = !empty($this->input->post('sub_category')) ? implode(',', $this->input->post('sub_category')) : '';

		$sType = !empty($this->input->post('service_type')) ? implode(',', $this->input->post('service_type')) : '';

		$insert['user_id'] = $this->session->userdata('user_id');
		$insert['service_name'] = $this->input->post('service_name');
		$insert['slug'] = str_replace(' ', '-', strtolower($this->input->post('service_name')));
		$insert['description'] = trim($this->input->post('description'));
		$insert['positive_keywords'] = implode(',', $this->input->post('positive_keywords'));
		$insert['location'] = $this->input->post('location');
		$insert['area'] = $this->input->post('area');
		//$insert['image'] = $newImg;
		$insert['status'] = 'draft';
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $subCat;
		$insert['service_type'] = $sType;
		if (!empty($this->input->post('plugins'))) {
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}

		$serviceId = $this->input->post('serviceId');

		if ($serviceId > 0) {
			$run = $this->common_model->update('my_services', ['id' => $serviceId], $insert);
			$sessionServiceId = $serviceId;
		} else {
			$run = $this->common_model->insert('my_services', $insert);
			$sessionServiceId = $run;
		}

		$this->session->set_userdata('latest_service', $sessionServiceId);
		$this->session->set_userdata('store_service1', $insert);
		$this->setServiceData($insert);

		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',2);
			$this->session->set_flashdata('success',"Service details added successfully.");			
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 2);
		redirect('open-add-service');
	}

	public function storeServices2BKP($value = '')
	{
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('sub_category', 'Sub Category', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 2);
			redirect('open-add-service');
		}
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if (!empty($this->input->post('plugins'))) {
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}
		$this->session->set_userdata('store_service2', $insert);
		$this->setServiceData($insert);

		$this->session->set_userdata('next_step', 3);
		$this->session->set_flashdata('success', "Category details added successfully.");
		redirect('open-add-service');
	}

	public function storeServices2($value = '')
	{
		//$submitBtn = $this->input->post('submit_listing');

		$this->form_validation->set_rules('price_per_type', 'How do you charge your service', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 2);
			redirect('open-add-service');
		}

		$package = $this->input->post('package');
		$result = $this->validateArray($package);
		if (!$result['isValid']) {
			$this->session->set_flashdata('error', $result['message']);
			$this->session->set_userdata('next_step', 2);
			redirect('open-add-service');
		}

		if ($this->input->post('package_type')) {
			$insert['package_type'] = 1;
		} else {
			$insert['package_type'] = 0;
		}

		if ($this->input->post('package')) {
			$insert['package_data'] = json_encode($this->input->post('package'));
		} else {
			$insert['package_data'] = '';
		}

		$insert['price_per_type'] = trim($this->input->post('price_per_type'));

		$latestServiceId = $this->session->userdata('latest_service');

		$run = $this->common_model->update('my_services', ['id' => $latestServiceId], $insert);

		$this->setServiceData($insert);

		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',3);
			$this->session->set_flashdata('success',"Package details added successfully.");			
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 3);
		redirect('open-add-service');
	}

	public function storeServices3($value = '')
	{
		//$submitBtn = $this->input->post('submit_listing');
		$newExS = $this->input->post('newExS', []);
		$this->setServiceData(['newExService' => $newExS]);
		$latestServiceId = $this->session->userdata('latest_service');
		$allSessionData = $this->session->userdata('service_data');

		if (!empty($allSessionData['newExService']) && count($allSessionData['newExService']) > 0) {
			foreach ($allSessionData['newExService']	 as $list) {
				$allTexs = $this->common_model->get_all_data('tradesman_extra_service');

				$insertExs['service_id'] = $latestServiceId;
				$insertExs['type'] = $list['type'];
				$insertExs['category'] = $list['category'];
				$insertExs['ex_service_id'] = $list['id'] != 0 ? $list['id'] : count($allTexs) + 1;
				$insertExs['ex_service_name'] = $list['ex_service_name'];
				$insertExs['price'] = $list['price'];
				$insertExs['additional_working_days'] = $list['additional_working_days'];

				$this->common_model->insert('tradesman_extra_service', $insertExs);
			}
		}

		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',4);
			$this->session->set_flashdata('success',"Extra service details added successfully.");
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 4);
		redirect('open-add-service');
	}

	public function storeServices4($value = '')
	{
		/*$step1 = $this->session->userdata('store_service1');
		$step2 = $this->session->userdata('store_service7');
		$step3 = $this->session->userdata('store_service3');
		
		if ($step2 !== null) {
		  $insert = array_merge($step1, $step2);
		}else{
			$this->session->set_flashdata('error','The Package Data field is required.');
			$this->session->set_userdata('next_step',7);
			redirect('open-add-service');
		}

		if ($step3 !== null) {
		  $insert = array_merge($insert, $step3);
		}*/

		//$submitBtn = $this->input->post('submit_listing');

		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'Main image', 'required');
		}

		$this->form_validation->set_rules('video', 'Video', 'callback_check_video_size');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 4);
			redirect('open-add-service');
		}

		$newImg = '';
		if ($_FILES['image']['name']) {
			$config['upload_path'] = "img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('image')) {
				$profile = $this->upload->data("file_name");
				$newImg = $profile;
			}
		}

		$mImgs = !empty($this->input->post('multiImgIds')) ? explode(',', $this->input->post('multiImgIds')) : [];
		$mDocs = !empty($this->input->post('multiDocIds')) ? explode(',', $this->input->post('multiDocIds')) : [];

		$newVid = '';
		if ($_FILES['video']['name']) {
			$config['upload_path'] = "img/services";
			$config['allowed_types'] = 'mp4|avi|wmv|mkv';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('video')) {
				$video = $this->upload->data("file_name");
				$newVid = $video;
			}
		}

		$insert['image'] = $newImg;
		$insert['video'] = $newVid;
		$latestServiceId = $this->session->userdata('latest_service');
		$run = $this->common_model->update('my_services', array('id' => $latestServiceId), $insert);

		$input['service_id'] = $latestServiceId;
		if (count($mImgs) > 0) {
			$input['type'] = 'image';
			foreach ($mImgs as $imgId) {
				$this->common_model->update('service_images', array('id' => $imgId), $input);
			}
		}
		if (count($mDocs) > 0) {
			$input['type'] = 'file';
			foreach ($mDocs as $docId) {
				$this->common_model->update('service_images', array('id' => $docId), $input);
			}
		}

		$this->setServiceData($insert);

		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',5);
			$this->session->set_flashdata('success',"Gallary details added successfully.");
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 5);
		redirect('open-add-service');
	}

	public function storeServices5($value = '')
	{
		//$submitBtn = $this->input->post('submit_listing');
		$faqs = $this->input->post('faq', []);
		$latestServiceId = $this->session->userdata('latest_service');
		$this->common_model->delete(['service_id' => $latestServiceId], 'service_faqs');
		$this->setServiceData(['faqs' => $faqs]);
		if (!empty($faqs) && count($faqs) > 0) {
			foreach ($faqs as $key => $list) {
				$insert['service_id'] = $latestServiceId;
				$insert['question'] = $list['question'];
				$insert['answer'] = $list['answer'];
				$run = $this->common_model->insert('service_faqs', $insert);
			}
		}
		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',6);
			$this->session->set_flashdata('success',"FAQ details added successfully.");
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 6);
		redirect('open-add-service');
	}

	public function storeServices6($value = '')
	{
		//$submitBtn = $this->input->post('submit_listing');
		$this->form_validation->set_rules('available_mon_fri', 'Available Monday to Friday', 'required');
		$this->form_validation->set_rules('weekend_available', 'Available On Weekends', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 6);
			redirect('open-add-service');
		}
		$insert['service_id'] = $this->session->userdata('latest_service');
		$insert['available_mon_fri'] = $this->input->post('available_mon_fri');
		$insert['selected_dates'] = $this->input->post('selected_dates');
		$insert['time_slot'] = $this->input->post('time_slot');
		$insert['time_slot_2'] = $this->input->post('time_slot_2');
		$insert['weekend_available'] = $this->input->post('weekend_available');
		$insert['not_available_days'] = $this->input->post('not_available_days');

		$run = $this->common_model->insert('service_availability', $insert);

		/*if(empty($submitBtn)){
			$this->session->set_userdata('next_step',7);
			$this->session->set_flashdata('success',"Service availability details added successfully.");
			redirect('open-add-service');
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('next_step', 7);
		redirect('open-add-service');
	}

	public function storeServices7($value = '')
	{
		$user_id = $this->session->userdata('user_id');
		$userData = $this->common_model->GetSingleData('users', ['id' => $user_id]);

		if (empty($userData['profile']) && empty($_FILES['profile']['name'])) {
			$this->form_validation->set_rules('profile', 'Profile', 'required');
		}

		$this->form_validation->set_rules('about_business', 'About Business', 'required');
		$this->form_validation->set_rules('trading_name', 'Trading Name', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('next_step', 8);
			redirect('open-add-service');
		} else {

			if ($_FILES['profile']['name']) {
				$config['upload_path'] = "img/profile";
				$config['allowed_types'] = 'jpeg|gif|jpg|png';
				$config['encrypt_name'] = true;
				$this->load->library("upload", $config);
				if ($this->upload->do_upload('profile')) {
					$profile = $this->upload->data("file_name");
					$insert['profile'] = $profile;
				}
			}

			$insert['about_business'] = $this->input->post('about_business');
			$insert['trading_name'] = $this->input->post('trading_name');

			$run = $this->common_model->update('users', ['id' => $user_id], $insert);
			$input['status'] = 'approval_pending';
			$result = $this->common_model->update('my_services', array('id' => $this->session->userdata('latest_service')), $input);

			$this->session->unset_userdata('store_service1');
			$this->session->unset_userdata('store_service2');
			$this->session->unset_userdata('store_service3');
			$this->session->unset_userdata('latest_service');
			$this->reserServiceTabData();

			$pageUrl = site_url() . 'my-services';

			$insertn['nt_userId'] = $user_id;
			$insertn['nt_message'] = 'Your listing has been submitted. <a href="' . $pageUrl . '">View now!</a>';
			$insertn['nt_satus'] = 0;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $list['id'];
			$insertn['posted_by'] = $uId;
			$run2 = $this->common_model->insert('notification', $insertn);

			$subject1 = "Confirmation of Your Service Gig Listing Submission.";

			$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $userData['trading_name'] . ', </p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Thank you for submitting your service gig on our platform. We have received your listing, and it is currently under review by our team. Once your submission has been approved, your gig will go live and be visible to potential clients to order.</p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Please note that the review process typically takes one business days. We will notify you once your gig has been approved or if we require any further information.</p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($userData['email'], $subject1, $content1);

			$this->session->set_flashdata('success', 'Your listing has been submitted to approval and will go live shortly if approved.');

			redirect('my-services');
		}
	}

	public function editServices($id = "")
	{
		if ($this->session->userdata('user_id')) {
			$this->reserServiceTabData();
			$this->resetEditServiceTabData();

			$this->openEditServiceForm($id);
		}
	}

	public function openEditServiceForm($id = "")
	{
		if ($this->session->userdata('user_id')) {
			$user_id = $this->session->userdata('user_id');
			$serviceData = $this->common_model->GetSingleData('my_services', ['user_id' => $user_id, 'id' => $id]);
			if (!$serviceData) {
				return;
			}

			$this->setEditServiceData($serviceData);
			$data['category'] = $this->common_model->get_parent_category('service_category', 0, 1);
			$data['cities'] = $this->common_model->get_all_data('location', ['is_delete' => 0]);
			$trades_ex_service = $this->common_model->getTradesExService($id);
			$faqs = $this->common_model->getServiceFaqs($id);
			$serviceAvailiblity = $this->common_model->getServiceAvailability($id);
			$this->setEditServiceData(['trades_ex_service' => $trades_ex_service, 'faqs' => $faqs, 'service_availiblity' => $serviceAvailiblity]);
			$service_images = $this->common_model->getAllTypeServiceImage('service_images', $id);

			foreach ($service_images as $imageData) {
				$image = $imageData['image'] ?? '';
				$imgId = $imageData['id'] ?? '';
				$file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
				if ($file_extension == 'pdf') {
					if (isset($serviceData['multi_files']) && $serviceData['multi_files']) {
						$multiFiles = $serviceData['multi_files'];
						$multiFiles[$imgId] = site_url() . "img/defaultDoc.png";
					} else {
						$multiFiles[$imgId] = site_url() . "img/defaultDoc.png";
					}
					$this->setEditServiceData(['multi_files' => $multiFiles]);
				} else {
					if (isset($serviceData['multi_images']) && $serviceData['multi_images']) {
						$multiImages = $serviceData['multi_images'];
						$multiImages[$imgId] = site_url() . "img/services/" . $image;
					} else {
						$multiImages[$imgId] = site_url() . "img/services/" . $image;
					}
					$this->setEditServiceData(['multi_images' => $multiImages]);
				}
			}
			$data['id'] = $id;

			$service_category = $this->common_model->GetSingleData('service_category', ['cat_id' => $serviceData['category']]);

			$data['attributes'] = $this->common_model->get_all_data('service_attribute', ['service_cat_id' => $service_category['cat_id']]);

			$data['ex_service'] = $this->common_model->get_all_data('extra_service', ['category' => $service_category['cat_id']]);

			$serviceData1 = $this->session->userdata('edit_service_data');

			$updatedCat = $this->common_model->GetSingleData('service_category', ['cat_id' => $serviceData1['category']]);

			$data['price_per_type'] = !empty($updatedCat['price_type_list']) ? explode(',', $updatedCat['price_type_list']) : [];

			$data['package_data'] = !empty($serviceData['package_data']) ? json_decode($serviceData['package_data']) : [];

			$data['service_category'] = $service_category;

			$data['all_area'] = $this->getArea($serviceData1['location'], $serviceData1['area'], 1);

			// echo '<pre>';
			// print_r($data['all_area']);
			// exit;

			$sub_category = !empty($serviceData1['sub_category']) ? explode(',', $serviceData1['sub_category']) : [];
			$service_type = !empty($serviceData1['service_type']) ? explode(',', $serviceData1['service_type']) : [];

			$this->session->set_userdata('sub_category_data', $sub_category);
			$this->session->set_userdata('service_type_data', $service_type);

			$data['service_type'] = $this->common_model->getServiceType($service_type);
			$data['user_profile'] = $this->common_model->get_single_data('users', array('id' => $this->session->userdata('user_id')));

			$data['portfolio'] = $this->common_model->get_education('user_portfolio', $this->session->userdata('user_id'));

			$data['suggestion'] = ['bathroom', 'test', 'reparing', '123', '456', '789'];
			$data['serviceId'] = $id;

			$this->load->view('site/edit-service', $data);
		}
	}

	public function updateServices($id = "")
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');

		if ($this->input->post('service_status') != 1) {
			$this->form_validation->set_rules('category', 'Category', 'required');
			$this->form_validation->set_rules('sub_category[]', 'Sub Category', 'required');
			$this->form_validation->set_rules('service_type[]', 'Service Type', 'required');
		}

		$this->form_validation->set_rules('service_name', 'Service Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('area', 'City/Town', 'required');
		$this->form_validation->set_rules('positive_keywords[]', 'Positive Keywords', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 1);
			redirect("open-edit-service/{$id}");
		}

		if ($this->input->post('service_status') != 1) {
			if (count($this->input->post('service_type')) > 3) {
				$this->session->set_flashdata('error', "You need to select only 3 service types");
				$this->session->set_userdata('next_step', 1);
				redirect("open-edit-service/{$id}");
			}
		}

		$insert = [];
		/*$newImg = '';
		if($_FILES['image']['name']){
			$config['upload_path']="img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name']=true;
			$this->load->library("upload",$config);
			if ($this->upload->do_upload('image')) {
				$profile=$this->upload->data("file_name");
				$newImg = $profile;
			}
		}else{
			$serviceData = $this->common_model->GetSingleData('my_services',['id'=>$id]);
			if(!empty($serviceData)){
				if(empty($serviceData['image'])){
					$this->form_validation->set_rules('image','Image/Video','required');
			
					if ($this->form_validation->run()==false) {
						$this->session->set_flashdata('error',validation_errors());
						$this->session->set_userdata('update_next_step',1);
						redirect("open-edit-service/{$id}");
					}
				}
			}
		}

		if($newImg){
			$insert['image'] = $newImg;
		}*/

		$subCat = !empty($this->input->post('sub_category')) ? implode(',', $this->input->post('sub_category')) : '';

		$sType = !empty($this->input->post('service_type')) ? implode(',', $this->input->post('service_type')) : '';

		$insert['service_name'] = $this->input->post('service_name');
		$insert['slug'] = str_replace(' ', '-', strtolower($this->input->post('service_name')));
		$insert['description'] = trim($this->input->post('description'));
		$insert['location'] = $this->input->post('location');
		$insert['area'] = $this->input->post('area');
		$insert['positive_keywords'] = implode(',', $this->input->post('positive_keywords'));

		if ($this->input->post('service_status') != 1) {
			$insert['category'] = $this->input->post('category');
			$insert['sub_category'] = $subCat;
			$insert['service_type'] = $sType;
		}
		$insert['status'] = 'approval_pending';
		$insert['is_view'] = 0;
		if (!empty($this->input->post('plugins'))) {
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}

		$this->common_model->update('my_services', ['id' => $id], $insert);
		$this->setApprovalPending($id);

		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','Service details updated succesfully.');
			$this->session->set_userdata('update_next_step',2);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 2);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices2BKP($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('sub_category', 'Subcategory', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 2);
			redirect("open-edit-service/{$id}");
		}
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $this->input->post('sub_category');
		$insert['service_type'] = $this->input->post('service_type');
		if (!empty($this->input->post('plugins'))) {
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}
		$this->common_model->update('my_services', ['id' => $id], $insert);
		$ex_service = $this->common_model->get_ex_service('extra_service', $insert['category']);
		$this->session->set_userdata('update_next_step', 7);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices2($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');

		$this->form_validation->set_rules('price_per_type', 'How do you charge your service', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 2);
			redirect("open-edit-service/{$id}");
		}

		$package = $this->input->post('package');
		$result = $this->validateArray($package);
		if (!$result['isValid']) {
			$this->session->set_flashdata('error', $result['message']);
			$this->session->set_userdata('update_next_step', 2);
			redirect("open-edit-service/{$id}");
		}

		if ($this->input->post('package_type')) {
			$insert['package_type'] = 1;
		} else {
			$insert['package_type'] = 0;
		}

		if ($this->input->post('package')) {
			$insert['package_data'] = json_encode($this->input->post('package'));
		} else {
			$insert['package_data'] = '';
		}

		$insert['price_per_type'] = trim($this->input->post('price_per_type'));

		$this->common_model->update('my_services', array('id' => $id), $insert);
		$this->setApprovalPending($id);

		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','Service package data updated succesfully');
			$this->session->set_userdata('update_next_step',3);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 3);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices3($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');

		$newExS = $this->input->post('newExS', []);
		$this->setEditServiceData(['newExService' => $newExS]);

		$allSessionData = $this->session->userdata('edit_service_data');
		$newExIds = [];

		if (!empty($newExS) && count($newExS)) {
			foreach ($newExS	 as $list) {
				$lastTexs = end($allSessionData['trades_ex_service']);
				$insertExs = [];

				if ($list['type'] == 1) {
					if (isset($list['id']) && $list['id']) {
						$insertExs['service_id'] = $id;
						$insertExs['type'] = $list['type'];
						$insertExs['category'] = $list['category'];
						$insertExs['ex_service_id'] = $list['id'];
						$insertExs['ex_service_name'] = $list['ex_service_name'];
						$insertExs['price'] = $list['price'];
						$insertExs['additional_working_days'] = $list['additional_working_days'];

						$newExIds[] = $list['id'];
					}
				} else {
					$insertExs['service_id'] = $id;
					$insertExs['type'] = $list['type'];
					$insertExs['category'] = $list['category'];
					$insertExs['ex_service_id'] = $lastTexs['id'] + 1;
					$insertExs['ex_service_name'] = $list['ex_service_name'];
					$insertExs['price'] = $list['price'];
					$insertExs['additional_working_days'] = $list['additional_working_days'];
				}

				if ($list['type'] == 1) {
					$tradesExs = $this->common_model->GetSingleData('tradesman_extra_service', array('service_id' => $id, 'type' => $list['type'], 'ex_service_id' => $list['id']));
					$whereArr = array('service_id' => $id, 'ex_service_id' => $list['id']);
				} else {
					$tradesExs = $this->common_model->GetSingleData('tradesman_extra_service', array('service_id' => $id, 'type' => $list['type'], 'id' => $list['id']));
					$whereArr = array('service_id' => $id, 'id' => $list['id']);
				}

				if (!empty($insertExs)) {
					if (!empty($tradesExs)) {
						$this->common_model->update('tradesman_extra_service', $whereArr, $insertExs);
					} else {
						$this->common_model->insert('tradesman_extra_service', $insertExs);
					}
				}
			}
		}

		if (!empty($newExIds)) {
			$this->common_model->deleteTradesManExs(['service_id' => $id], 'ex_service_id', $newExIds, 'tradesman_extra_service');
		} else {
			$this->common_model->delete(['service_id' => $id], 'tradesman_extra_service');
		}

		$this->setApprovalPending($id);
		$serviceData = $this->session->userdata('edit_service_data');

		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','Extra Service details updated succesfully.');
			$this->session->set_userdata('update_next_step',4);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 4);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices4($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');

		$user_id = $this->session->userdata('user_id');
		$serviceData = $this->common_model->GetSingleData('my_services', ['user_id' => $user_id, 'id' => $id]);

		if (empty($serviceData['image']) && empty($_FILES['image']['name'])) {
			$this->form_validation->set_rules('image', 'Main image', 'required');
		}

		$this->form_validation->set_rules('video', 'Video', 'callback_check_video_size');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 4);
			redirect("open-edit-service/{$id}");
		}

		$mImgs = !empty($this->input->post('multiImgIds')) ? explode(',', $this->input->post('multiImgIds')) : [];
		$mDocs = !empty($this->input->post('multiDocIds')) ? explode(',', $this->input->post('multiDocIds')) : [];

		$newImg = '';
		if ($_FILES['image']['name']) {
			$config['upload_path'] = "img/services";
			$config['allowed_types'] = 'jpeg|gif|jpg|png|mp4|avi|wmv|mkv';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('image')) {
				$profile = $this->upload->data("file_name");
				$newImg = $profile;
			}
		} else {
			$serviceData = $this->common_model->GetSingleData('my_services', ['id' => $id]);
			if (!empty($serviceData)) {
				if (empty($serviceData['image'])) {
					$this->form_validation->set_rules('image', 'Image/Video', 'required');

					if ($this->form_validation->run() == false) {
						$this->session->set_flashdata('error', validation_errors());
						$this->session->set_userdata('update_next_step', 1);
						redirect("open-edit-service/{$id}");
					}
				}
			}
		}

		if ($newImg) {
			$insert['image'] = $newImg;
		}

		$newVid = '';
		if ($_FILES['video']['name']) {
			$config['upload_path'] = "img/services";
			$config['allowed_types'] = 'mp4|avi|wmv|mkv';
			$config['encrypt_name'] = true;
			$this->load->library("upload", $config);
			if ($this->upload->do_upload('video')) {
				$video = $this->upload->data("file_name");
				$newVid = $video;
			}
		}

		$insert['video'] = $newVid;
		$this->common_model->update('my_services', array('id' => $id), $insert);

		if ($id) {
			$input['service_id'] = $id;
			if (count($mImgs) > 0) {
				foreach ($mImgs as $imgId) {
					$run = $this->common_model->update('service_images', array('id' => $imgId), $input);
				}
			}
			if (count($mDocs) > 0) {
				foreach ($mDocs as $docId) {
					$run = $this->common_model->update('service_images', array('id' => $docId), $input);
				}
			}
		}

		$this->setApprovalPending($id);
		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','Gallary details updated succesfully.');
			$this->session->set_userdata('update_next_step',5);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 5);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices5($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');
		$this->common_model->delete(['service_id' => $id], 'service_faqs');
		$faqs = $this->input->post('faq', []);
		if (!empty($faqs) && count($faqs) > 0) {
			foreach ($faqs as $key => $list) {
				$insert['service_id'] = $id;
				$insert['question'] = $list['question'];
				$insert['answer'] = $list['answer'];
				$this->common_model->insert('service_faqs', $insert);
			}
		}
		$this->setApprovalPending($id);
		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','FAQs details updated succesfully.');
			$this->session->set_userdata('update_next_step',6);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 6);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices6($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}
		//$submitBtn = $this->input->post('submit_listing');
		$this->form_validation->set_rules('available_mon_fri', 'Available Monday to Friday', 'required');
		$this->form_validation->set_rules('weekend_available', 'Available On Weekends', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 6);
			redirect("open-edit-service/{$id}");
		}

		$insert['service_id'] = $id;
		$insert['available_mon_fri'] = $this->input->post('available_mon_fri');
		$insert['selected_dates'] = $this->input->post('selected_dates');
		$insert['time_slot'] = $this->input->post('time_slot');
		$insert['time_slot_2'] = $this->input->post('time_slot_2');
		$insert['weekend_available'] = $this->input->post('weekend_available');
		$insert['not_available_days'] = $this->input->post('not_available_days');

		$serviceAvailible = $this->common_model->GetSingleData('service_availability', array('service_id' => $id));

		//$insert1['status'] = 'approval_pending';
		//$this->common_model->update('my_services',array('id'=>$id),$insert1);

		if (!empty($serviceAvailible)) {
			$this->common_model->update('service_availability', array('service_id' => $id), $insert);
		} else {
			$this->common_model->insert('service_availability', $insert);
		}
		$this->setApprovalPending($id);

		/*if(empty($submitBtn)){
			$this->session->set_flashdata('success','Service availability details updated succesfully.');
			$this->session->set_userdata('update_next_step',7);
			redirect("open-edit-service/{$id}");
		}else{
			$this->session->set_flashdata('success','Your listing has been submitted to approval and will go live shortly if approved.');
			redirect("my-services");
		}*/
		$this->session->set_userdata('update_next_step', 7);
		redirect("open-edit-service/{$id}");
	}

	public function updateServices7($id = '')
	{
		if (!$id) {
			redirect(base_url());
			return;
		}

		$user_id = $this->session->userdata('user_id');
		$userData = $this->common_model->GetSingleData('users', ['id' => $user_id]);

		if (empty($userData['profile']) && empty($_FILES['profile']['name'])) {
			$this->form_validation->set_rules('profile', 'Profile image', 'required');
		}

		$this->form_validation->set_rules('about_business', 'About Business', 'required');
		$this->form_validation->set_rules('trading_name', 'Trading Name', 'required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			$this->session->set_userdata('update_next_step', 7);
			redirect("open-edit-service/{$id}");
		} else {

			if ($_FILES['profile']['name']) {
				$config['upload_path'] = "img/profile";
				$config['allowed_types'] = 'jpeg|gif|jpg|png';
				$config['encrypt_name'] = true;
				$this->load->library("upload", $config);
				if ($this->upload->do_upload('profile')) {
					$profile = $this->upload->data("file_name");
					$insert['profile'] = $profile;
				}
			}

			$insert['about_business'] = $this->input->post('about_business');
			$insert['trading_name'] = $this->input->post('trading_name');

			$run = $this->common_model->update('users', array('id' => $user_id), $insert);

			$serviceData = $this->common_model->GetSingleData('my_services', ['user_id' => $user_id, 'id' => $id]);

			if (!empty($serviceData)) {
				if ($serviceData['status'] == 'draft') {
					$insert1['status'] = 'approval_pending';
					$this->common_model->update('my_services', array('id' => $id), $insert1);
				}
			}

			if ($id) {
				$this->session->set_flashdata('success', 'Your listing has been submitted to approval and will go live shortly if approved.');
			} else {
				$this->session->set_flashdata('error', 'Something is wrong.');
			}
			$this->setApprovalPending($id);
			$this->resetEditServiceTabData();
			redirect("my-services");
		}
	}

	public function setApprovalPending($id)
	{
		$serviceData = $this->common_model->GetSingleData('my_services', ['id' => $id]);

		if ($serviceData['status'] != 'draft') {
			$insert['status'] = 'approval_pending';
			$insert['is_view'] = 0;
			$this->common_model->update('my_services', ['id' => $id], $insert);
		}

		return;
	}

	public function removeServiceImage()
	{
		$user_id = $this->session->userdata('user_id');
		$imageId = $this->input->post('imgId');
		$serviceImages = $this->common_model->GetSingleData('service_images', ['id' => $imageId]);
		if (!empty($serviceImages)) {
			unlink('img/services/' . $serviceImages['image']);
			$this->db->where('id', $this->input->post('imgId'))->delete('service_images');
			$serviceData = $this->session->userdata('service_data');

			if (isset($serviceData['multi_files'][$imageId])) {
				unset($serviceData['multi_files'][$imageId]);
			}

			if (isset($serviceData['multi_images'][$imageId])) {
				unset($serviceData['multi_images'][$imageId]);
			}

			$this->setServiceData($serviceData);
		}
		exit;
	}

	public function removeAttachment()
	{
		$user_id = $this->session->userdata('user_id');
		$imageId = $this->input->post('imgId');
		$serviceImages = $this->common_model->GetSingleData('order_requirement_attachment', ['id' => $imageId]);
		if (!empty($serviceImages)) {
			unlink('img/services/' . $serviceImages['image']);
			$this->db->where('id', $this->input->post('imgId'))->delete('order_requirement_attachment');
		}
		exit;
	}

	public function removeOrderSubmitAttachment()
	{
		$imageId = $this->input->post('imgId');
		$orderImages = $this->common_model->GetSingleData('order_submit_attachments', ['id' => $imageId]);
		if (!empty($orderImages)) {
			unlink('img/services/' . $orderImages['image']);
			$this->db->where('id', $this->input->post('imgId'))->delete('order_submit_attachments');
		}
		exit;
	}

	public function removeServiceVideo()
	{
		$sid = $this->input->post('sId');
		$type = $this->input->post('type');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $sid]);
		if (!empty($service)) {
			if ($type == 'video') {
				unlink('img/services/' . $service['video']);
				$insert['video'] = '';
			}

			if ($type == 'image') {
				unlink('img/services/' . $service['image']);
				$insert['image'] = '';
			}

			$this->common_model->update('my_services', ['id' => $sid], $insert);
			$serviceData = $this->common_model->GetSingleData('my_services', ['id' => $sid]);
			$this->setServiceData($serviceData);
		}
		exit;
	}

	public function deleteServices($id = "")
	{
		$service = $this->common_model->GetSingleData('my_services', ['id' => $id]);
		if (!empty($service)) {
			unlink('img/services/' . $service['image']);
			unlink('img/services/' . $service['video']);
			$service_images = $this->common_model->get_service_image('service_images', $id);
			if (!empty($service_images)) {
				foreach ($service_images as $list) {
					unlink('img/services/' . $list['image']);
					$this->common_model->delete(['id' => $list['id']], 'service_images');
				}
			}
			$this->common_model->delete(['id' => $id], 'my_services');
			$this->common_model->delete(['service_id' => $id], 'service_availability');
			$this->common_model->delete(['service_id' => $id], 'service_faqs');
			$this->common_model->delete(['service_id' => $id], 'service_rating');
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Service has been deleted successfully!!</div>');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something is wrong!!</div>');
		}
		redirect('my-services');
	}

	public function getSubCategory()
	{
		$id = $this->input->post('cat_id');
		$type = $this->input->post('type');
		$subCategory = $this->common_model->get_sub_category('service_category', $id);
		$option = '';

		$existSCat = $this->session->userdata('sub_category_data');
		$existSType = $this->session->userdata('service_type_data');

		if (!empty($subCategory)) {
			$option .= '<div class="row">';
			$jsFunction = $type == 1 ? 'onclick="return changesub($(this).val())"' : '';
			$chkName = $type == 1 ? 'sub_category[]' : 'service_type[]';
			$inputType = $type == 1 ? 'radio' : 'checkbox';
			$className = $type == 1 ? '' : 'serviceCheck';
			$disabledVar = $this->input->post('status_approved') == 1 ? 'disabled' : '';

			// $option .= '<option value="">Please Select</option>';
			foreach ($subCategory as $sCat) {
				// $option .= '<option value="'.$sCat['cat_id'].'">'.$sCat['cat_name'].'</option>';

				if ($type == 1) {
					$checked = in_array($sCat['cat_id'], $existSCat) ? 'checked' : '';
				} else {
					$checked = in_array($sCat['cat_id'], $existSType) ? 'checked' : '';
				}

				$option .= '<div class="col-sm-6"><div class=""><label><input type="' . $inputType . '" name="' . $chkName . '" class="subCategory ' . $className . '" ' . $jsFunction . ' id="subcategory' . $sCat['cat_id'] . '" value="' . $sCat['cat_id'] . '" ' . $checked . ' ' . $disabledVar . '>' . $sCat['cat_name'] . '<span class="outside"><span class="inside"></span></span></label></div></div>';
			}
			$option .= '</div>';
		}
		echo $option;
	}

	public function getPriceType()
	{
		$id = $this->input->post('cat_id');
		$service_category = $this->common_model->GetSingleData('service_category', ['cat_id' => $id]);
		$price_type = 0;
		if (!empty($service_category)) {
			$price_type = !empty($service_category['price_type']) && $service_category['price_type'] == 1 ? 1 : 0;
		}
		echo $price_type;
	}

	public function setServiceData($data)
	{
		$serviceData = $this->session->userdata('service_data');
		if ($serviceData) {
			if ($data) {
				$allData = array_merge($serviceData, $data);
			}
		} else {
			$allData = $data;
		}

		$this->session->set_userdata('service_data', $allData);
	}

	public function setEditServiceData($data)
	{
		$serviceData = $this->session->userdata('edit_service_data');
		if ($serviceData) {
			if ($data) {
				$allData = array_merge($serviceData, $data);
			}
		} else {
			$allData = $data;
		}

		$this->session->set_userdata('edit_service_data', $allData);
	}

	public function reserServiceTabData()
	{
		$this->session->unset_userdata('service_data');
		$this->session->unset_userdata('next_step');
		$this->session->unset_userdata('sub_category_data');
		$this->session->unset_userdata('service_type_data');
	}

	public function resetEditServiceTabData()
	{
		$this->session->unset_userdata('update_service_data');
		$this->session->unset_userdata('update_next_step');
		$this->session->unset_userdata('sub_category_data');
		$this->session->unset_userdata('service_type_data');
	}

	public function deleteAllServices()
	{
		$ids = $this->input->post('servicesIds');
		if (count($ids) > 0) {
			foreach ($ids as $id) {
				$service = $this->common_model->GetSingleData('my_services', ['id' => $id]);
				if (!empty($service)) {
					unlink('img/services/' . $service['image']);
					$service_images = $this->common_model->get_service_image('service_images', $id);
					if (!empty($service_images)) {
						foreach ($service_images as $list) {
							unlink('img/services/' . $list['image']);
							$this->common_model->delete(['id' => $list['id']], 'service_images');
						}
					}
					$this->common_model->delete(['id' => $id], 'my_services');
					$this->common_model->delete(['service_id' => $id], 'service_availability');
					$this->common_model->delete(['service_id' => $id], 'service_faqs');
					$this->common_model->delete(['service_id' => $id], 'service_rating');
				}
			}
			echo json_encode(['status' => 'success', 'message' => 'Selected services are deleted successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Please select at least one service']);
		}
	}

	public function pausedServices()
	{
		$id = $this->input->post('servicesIds');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $id]);
		if (!empty($service)) {
			$input['status'] = $this->input->post('status');
			$this->common_model->update('my_services', array('id' => $id), $input);
			echo json_encode(['status' => 'success', 'message' => 'Service status has been updated.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Something is wrong.']);
		}
	}

	public function submitProject()
	{
		$oId = $this->input->post('orderId');
		$mId = $this->input->post('milestoneId');
		$tuser_id = $this->session->userdata('user_id');
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		$milestone = $this->common_model->GetSingleData('tbl_milestones', ['id' => $mId]);

	
		/* CHECK ORDER IS CUSTOM ORDER OR NORMAL ORDER */
		if(!empty($serviceOrder) && $serviceOrder['is_custom'] == 1 && $serviceOrder['order_type'] == "milestone"){ 
			
					
			$milestone = $this->common_model->GetSingleData('tbl_milestones', ['id' => $mId]);
	
			/* UPDATE MILESTONE DATA */
			if ($mId > 0) {				
				$inputMilestone['status'] = '10';
				$inputMilestone['service_status'] = 'delivered';
				$inputMilestone['service_previous_status'] = 'delivered';
				$inputMilestone['status_update_time'] = date('Y-m-d H:i:s');
				$this->common_model->update('tbl_milestones', array('id' => $mId), $inputMilestone);


				/*Manage Order History*/
				$insert1 = [
					'user_id' => $tuser_id,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'milestone_id' => $mId,
					'milestone_level' => $mId > 0 ? $milestone['milestone_level'] : 0,
					'status' => 'delivered'
				];
				$this->common_model->insert('service_order_status_history', $insert1);
	
				$insert['sender'] = $tuser_id;
				$insert['receiver'] = $serviceOrder['user_id'];
				$insert['order_id'] = $oId;
				$insert['milestone_id'] = $mId;
				$insert['milestone_level'] = $mId > 0 ? $milestone['milestone_level'] : 0;
				$insert['status'] = 'delivered';
				$insert['description'] = $this->input->post('description');
				$run = $this->common_model->insert('order_submit_conversation', $insert);
				if ($run) {
					$mImgs = !empty($this->input->post('multiImgIds1')) ? explode(',', $this->input->post('multiImgIds1')) : [];
	
					$input1['conversation_id'] = $run;
					if (count($mImgs) > 0) {
						foreach ($mImgs as $imgId) {
							$this->common_model->update('order_submit_attachments', array('id' => $imgId), $input1);
						}
					}
				}

				$getAllMilestoneCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service']);

				$getAllDeliverdMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service', 'status' => 10]);


				if(count($getAllMilestoneCount) == count($getAllDeliverdMilestonesCount)){
					/* CHECK IF ALL MISTONE DELIVERD THEN ORDER ALSO DELIVERD */
					$input['status'] = 'delivered';
					$input['previous_status'] = $serviceOrder['status'];
					$input['status_update_time'] = date('Y-m-d H:i:s');
					$this->common_model->update('service_order', array('id' => $oId), $input);
				}


				echo json_encode(['status' => 1, 'message' => 'Your work has been successfully delivered.']);
			}else{
				echo json_encode(['status' => 0, 'message' => 'Order Not Submitted']);
			}
			
		}else{

			if (!empty($serviceOrder)) {
				$milestone = $this->common_model->GetSingleData('tbl_milestones', ['id' => $mId]);
	
				$input['status'] = 'delivered';
				$input['previous_status'] =  $serviceOrder['status'];
				$input['status_update_time'] = date('Y-m-d H:i:s');
				$this->common_model->update('service_order', array('id' => $oId), $input);
				if ($mId > 0) {
					$inputMilestone['service_status'] = $input['status'];
					$inputMilestone['service_previous_status'] = $input['previous_status'];
					$inputMilestone['status_update_time'] = $input['status_update_time'];
					$this->common_model->update('tbl_milestones', array('id' => $mId), $inputMilestone);
				}
	
				/*Manage Order History*/
				$insert1 = [
					'user_id' => $tuser_id,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'milestone_id' => $mId,
					'milestone_level' => $mId > 0 ? $milestone['milestone_level'] : 0,
					'status' => 'delivered'
				];
				$this->common_model->insert('service_order_status_history', $insert1);
	
				$insert['sender'] = $tuser_id;
				$insert['receiver'] = $serviceOrder['user_id'];
				$insert['order_id'] = $oId;
				$insert['milestone_id'] = $mId;
				$insert['milestone_level'] = $mId > 0 ? $milestone['milestone_level'] : 0;
				$insert['status'] = 'delivered';
				$insert['description'] = $this->input->post('description');
				$run = $this->common_model->insert('order_submit_conversation', $insert);
				if ($run) {
					$mImgs = !empty($this->input->post('multiImgIds1')) ? explode(',', $this->input->post('multiImgIds1')) : [];
	
					$input1['conversation_id'] = $run;
					if (count($mImgs) > 0) {
						foreach ($mImgs as $imgId) {
							$this->common_model->update('order_submit_attachments', array('id' => $imgId), $input1);
						}
					}
				}
	
				$homeOwner = $this->common_model->check_email_notification($serviceOrder['user_id']);
				$tradesman = $this->common_model->GetSingleData('users', ['id' => $tuser_id]);
				$homeUser = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
	
				$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];
	
				if ($homeOwner) {
					$subject = "Great news: Your order is ready!";
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Order Payment Made Successfully!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . '!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">We’re excited to let you know that your order with ' . $tradesman['trading_name'] . ' has been delivered!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">You can now:</p>';
	
					$html .= '<p style="margin:0;padding:0px 0px"><img src="' . site_url() . 'img/check.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:20px" class="CToWUd"> Review the delivery to ensure it meets your expectations.</p>';
					$html .= '<p style="margin:0;padding:0px 0px"><img src="' . site_url() . 'img/check.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:20px" class="CToWUd"> Approve it if everything looks perfect.</p>';
					$html .= '<p style="margin:0;padding:0px 0px"><img src="' . site_url() . 'img/check.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:20px" class="CToWUd"> Provide feedback to help the pro improve and guide others.</p>';
	
					$html .= '<p style="margin:0;padding:10px 0px">If you have any questions, need revisions, request one, or reach out to the Pro through the chat if you need an assistant. They’re here to make sure you’re 100% satisfied with the results!</p>';
	
					$html .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review Order Now</a></div>';
					$html .= '<p style="margin:0;padding:10px 0px">Visit our Customer help page or contact our customer services if you have any specific questions using our service.</p>';
	
					$sent = $this->common_model->send_mail($homeOwner['email'], $subject, $html);
	
					$insertn['nt_userId'] = $homeUser['id'];
					$insertn['nt_message'] = "Great news! Your order has been delivered. <a href='" . $pageUrl . "'>Review Now!</a>";
					$insertn['nt_satus'] = 0;
					$insertn['nt_apstatus'] = 0;
					$insertn['nt_create'] = date('Y-m-d H:i:s');
					$insertn['nt_update'] = date('Y-m-d H:i:s');
					$insertn['job_id'] = $serviceOrder['id'];
					$insertn['posted_by'] = $tradesMan['id'];
					$run2 = $this->common_model->insert('notification', $insertn);
				}
	
				echo json_encode(['status' => 1, 'message' => 'Your work has been successfully delivered.']);
			} else {
				echo json_encode(['status' => 0, 'message' => 'Order Not Submitted']);
			}
		}
		
	}

	public function getServiceList()
	{
		$uId = $this->input->post('tradesMan');
		$services = $this->common_model->get_my_service('my_services', $uId, 'active');
		if (!empty($services)) {
			echo json_encode(array('status' => 1, 'services' => $services));
			exit;
		} else {
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	public function getServiceDetail()
	{
		$sId = $this->input->post('sId');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $sId]);
		if (!empty($service)) {
			$exServices = $this->common_model->get_all_data('tradesman_extra_service', ['service_id' => $sId]);

			echo json_encode(array('status' => 1, 'service' => $service, 'exServices' => $exServices));
			exit;
		}
		if (!empty($service)) {
			echo json_encode(array('status' => 0));
			exit;
		}
	}

	public function sendCustomOffer()
	{
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
						/*$file = 'logFile.txt';
	                    $handle = fopen($file, 'a');
	                    $data = date('Y-m-d h:i:s') . '-----' . $has_email_noti['email'] . "\n";
	                    if (fwrite($handle, $data) === false) {
	                        die('Could not write to file');
	                    }
	                    fclose($handle);*/
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

	public function sendInquiry()
	{
		if (!$this->session->userdata('user_id')) {
			$json['status'] = 2;
			echo json_encode($json);
			exit;
		}
		$userid = $this->session->userdata('user_id');
		$sId = $this->input->post('serviceId');
		$message = $this->input->post('message');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $sId]);
		if (!empty($service)) {
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

			if ($chatInsert) {
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
			} else {
				$json['status'] = 1;
				$json['message'] = 'Something is wrong';
				echo json_encode($json);
				exit;
			}
		} else {
			$json['status'] = 0;
			$json['message'] = 'Service not found';
			echo json_encode($json);
			exit;
		}
	}

	public function validateArray($array)
	{
		foreach ($array as $key => $value) {
			if (!isset($value['attributes']) || empty($value['attributes'])) {
				return [
					'isValid' => false,
					'message' => "Please check at least 1 attribute is required and cannot be empty for " . ucfirst($key) . "."
				];
			}

			foreach ($value as $subKey => $subValue) {
				if (is_array($subValue)) {
					// Recursively validate the nested array
					if ($subKey != 'attributes') {
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
							'message' => "The value for '$subKey' in " . ucfirst($key) . " is required."
						];
					}
				}
			}
		}
		return ['isValid' => true, 'message' => 'Validation passed'];
	}

	public function getSuggestedCategory()
	{
		$title = $this->input->post('title');
		$suggestedCategories = $this->common_model->get_category_detailsbyname('service_category', $title, 1);
		$catArr = [];
		if (!empty($suggestedCategories)) {
			foreach ($suggestedCategories as $sCat) {
				$childcat = $this->common_model->get_child_category($sCat['cat_id'], $title);
				if (!empty($childcat)) {
					$catArr[] = [
						'cat_id' => $sCat['cat_id'],
						'cat_name' => $sCat['cat_name'],
						'child_cat_id' => $childcat['cat_id'],
						'child_cat_name' => $childcat['cat_name']
					];
				} else {
					$catArr[] = [
						'cat_id' => $sCat['cat_id'],
						'cat_name' => $sCat['cat_name'],
						'child_cat_id' => '',
						'child_cat_name' => ''
					];
				}
			}
		}
		echo json_encode($catArr);
	}

	public function getArea($lo_Id = 0, $exist_area = '', $type = 0)
	{
		$lId = $lo_Id == 0 ? $this->input->post('location') : $lo_Id;
		$location = $this->common_model->get_single_data('location', array('id' => $lId));
		$option = '';
		$areaArr = [];
		if (!empty($location)) {
			if (!empty($location['area'])) {
				$option = '<option value="">Select City/town</option>';
				$areas = explode(',', $location['area']);
				$areaArr = $areas;
				foreach ($areas as $area) {
					$selected = !empty($exist_area) && $exist_area == $area ? 'selected' : '';
					$option .= '<option value="' . $area . '" ' . $selected . '>' . $area . '</option>';
				}
			}
		}
		if ($type == 0) {
			echo $option;
		} else {
			return $areaArr;
		}
	}

	public function updateStatus()
	{
		$oId = $this->input->post('id');
		$status = $this->input->post('status');
		$userid = $this->session->userdata('user_id');
		$order = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		if (!empty($order)) {
			$update_array = [
				'status' => $status
			];
			$where_array = ['id' => $oId];
			$result = $this->common_model->update('service_order', array('id' => $oId), $update_array);

			if ($result) {
				/*Manage Order History*/
				$insert1 = [
					'user_id' => $userid,
					'service_id' => $order['service_id'],
					'order_id' => $oId,
					'status' => $status,
				];
				$this->common_model->insert('service_order_status_history', $insert1);

				/*Home Owner Email Code*/
				$homeOwner = $this->common_model->GetSingleData('users', ['id' => $order['user_id']]);
				$service = $this->common_model->GetSingleData('my_services', ['id' => $order['service_id']]);
				$newStatus = ucwords(str_replace('_', ' ', $status));

				if ($homeOwner) {
					$subject = "Your service order status updated for: “" . $service['service_name'] . "”";
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] . ',</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Your order status has been updated</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Order status is ' . $newStatus . '</p>';
					$this->common_model->send_mail($homeOwner['email'], $subject, $html);
				}
			}
			echo 1;
			exit;
		} else {
			echo 0;
			exit;
		}
	}

	public function updateWishlist()
	{
		$userid = $this->session->userdata('user_id');
		$json['status'] = 0;
		if ($userid) {
			$sId = $this->input->post('sId');
			$service = $this->common_model->GetSingleData('my_services', ['id' => $sId]);
			if (!empty($service)) {
				$wishlist = $this->common_model->GetSingleData('service_wishlist', ['user_id' => $userid, 'service_id' => $sId]);
				if (empty($wishlist)) {
					$insert['service_id'] = $sId;
					$insert['user_id'] = $userid;
					$run = $this->common_model->insert('service_wishlist', $insert);
					$json['status'] = 1;
				} else {
					$this->common_model->delete(['user_id' => $userid, 'service_id' => $sId], 'service_wishlist');
					$json['status'] = 2;
				}
				$totalLikes = $this->common_model->totalLikes($sId);
				$json['totalLikes'] = $totalLikes;
			} else {
				$json['status'] = 0;
			}
		}

		echo json_encode($json);
	}

	public function orderAgain()
	{
		$userid = $this->session->userdata('user_id');
		$json['status'] = 0;
		if ($userid) {
			$oId = $this->input->post('oId');
			$order = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
			if (!empty($order)) {
				$exIds = '';
				$oldExIds = !empty($order['ex_services']) ? explode(',', $order['ex_services']) : [];
				if (count($oldExIds) > 0) {
					foreach ($oldExIds as $exs) {
						$exId = explode('-', $exs);
						$exIds .= $exId[0] . ',';
					}
				}

				$insert['user_id'] = $userid;
				$insert['service_id'] = $order['service_id'];
				$insert['package_type'] = $order['package_type'];
				$insert['service_qty'] = $order['service_qty'];
				$insert['ex_service_ids'] = substr(trim($exIds), 0, -1);

				$newCart = $this->common_model->insert('cart', $insert);
				if ($newCart) {
					$this->session->set_userdata('latest_cartId', $newCart);
					$json['status'] = 1;
				}
			}
		}
		echo json_encode($json);
	}

	public function my_faviourits($value = '')
	{
		if ($this->session->userdata('user_id')) {
			$data['my_favourites'] = $this->common_model->get_my_favorite('my_services', $this->session->userdata('user_id'));

			$this->load->view('site/my_favorite', $data);
		} else {
			redirect('login');
		}
	}

	public function getPositiveKeywords()
	{
		$keywords = $_GET['term'];
		$suggestions = $this->common_model->get_keyword_suggestions($keywords);
		return $suggestions;
	}

	public function check_video_size()
	{
		// Maximum file size allowed (in bytes), 60MB = 60 * 1024 * 1024 bytes
		$max_size = 60 * 1024 * 1024;

		if (isset($_FILES['video']) && $_FILES['video']['size'] > $max_size) {
			// Set custom error message for file size validation
			$this->form_validation->set_message('check_video_size', 'The video file exceeds the maximum allowed size of 60MB.');
			return false;
		}
		return true;
	}

	public function autoSaveService()
	{
		$subCat = !empty($this->input->post('sub_category')) ? implode(',', $this->input->post('sub_category')) : '';

		$sType = !empty($this->input->post('service_type')) ? implode(',', $this->input->post('service_type')) : '';
		$serviceId = $this->input->post('serviceId');

		if ($serviceId > 0) {
			$serviceData = $this->common_model->GetSingleData('my_services', ['id' => $serviceId]);
			$status = $serviceData['status'];
		} else {
			$status = "draft";
		}

		$insert['user_id'] = $this->session->userdata('user_id');
		$insert['service_name'] = $this->input->post('service_name');
		$insert['slug'] = str_replace(' ', '-', strtolower($this->input->post('service_name')));
		$insert['description'] = trim($this->input->post('description'));
		$insert['location'] = $this->input->post('location');
		$insert['area'] = $this->input->post('area');
		$insert['positive_keywords'] = implode(',', $this->input->post('positive_keywords'));
		$insert['category'] = $this->input->post('category');
		$insert['sub_category'] = $subCat;
		$insert['service_type'] = $sType;
		$insert['status'] = $status;
		if (!empty($this->input->post('plugins'))) {
			$insert['plugins'] = implode(',', $this->input->post('plugins'));
		} else {
			$insert['plugins'] = '';
		}

		if ($serviceId > 0) {
			$this->common_model->update('my_services', ['id' => $serviceId], $insert);
			$sId = $serviceId;
		} else {
			$run = $this->common_model->insert('my_services', $insert);
			$sId = $run;
		}
		echo $sId;
	}

	public function submitRequirement()
	{
		if (!$this->session->userdata('user_id')) {
			$json['status'] = 2;
			echo json_encode($json);
			exit;
		}

		$uId = $this->session->userdata('user_id');
		$oId = $this->input->post('order_id');

		$insert['user_id'] = $uId;
		$insert['order_id'] =  $oId;
		$insert['requirement'] =  $this->input->post('requirement');
		// $insert['location'] =  $this->input->post('location');

		$existRequirement = $this->common_model->GetSingleData('order_requirement', ['user_id' => $uId, 'order_id' => $oId]);
		$order = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		if (!empty($existRequirement)) {
			$data['status'] = 0;
			$data['message'] = 'Order requirement is already submitted';
			echo json_encode($data);
			exit;
		}

		$requirement = $this->common_model->insert('order_requirement', $insert);

		$mImgs = !empty($this->input->post('multiImgIds')) ? explode(',', $this->input->post('multiImgIds')) : [];

		if ($requirement) {
			$input['requirement_id'] = $requirement;
			if (count($mImgs) > 0) {
				foreach ($mImgs as $imgId) {
					$this->common_model->update('order_requirement_attachment', array('id' => $imgId), $input);
				}
			}

			$update_array = [
				'status' => 'active',
				'previous_status' => 'active'
			];
			$where_array = ['id' => $oId];
			$result = $this->common_model->update('service_order', array('id' => $oId), $update_array);

			if ($order['is_custom'] == 1 && $order['order_type'] == 'milestone') {
				$updateMilestone['service_status'] = 'active';
				$updateMilestone['service_previous_status'] = 'active';
				$this->common_model->update('tbl_milestones', array('milestone_type' => 'service', 'post_id' => $order['id']), $updateMilestone);
			}

			/*Manage Order History*/
			$insert1 = [
				'user_id' => $uId,
				'service_id' => $order['service_id'],
				'order_id' => $oId,
				'status' => 'active',
			];
			$this->common_model->insert('service_order_status_history', $insert1);

			$data['status'] = 1;
			$data['message'] = 'Order requirement submitted succesfully';
			echo json_encode($data);
			exit;
		} else {
			$data['status'] = 0;
			$data['message'] = 'Something is wrong. Order requirement not submitted';
			echo json_encode($data);
			exit;
		}
	}

	public function getRequirements()
	{
		$oId =  $this->input->post('oId');
		$user_id = $this->session->userdata('user_id');
		$requirements = $this->common_model->GetSingleData('order_requirement', ['order_id' => $oId]);
		$data['status'] = 0;
		if (!empty($requirements)) {
			$attachements = $this->common_model->get_all_data('order_requirement_attachment', ['requirement_id' => $requirements['id']]);
			$attch = '';
			if (!empty($attachements)) {
				foreach ($attachements as $key => $value) {
					$image_path = FCPATH . 'img/services/' . ($value['attachment'] ?? '');
					if (file_exists($image_path) && $value['attachment']) {
						$attch .= '<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="boxImage imgUp">
						<div class="imagePreviewPlus">
						<img style="width: inherit; height: inherit;" src="' . base_url('img/services/') . $value['attachment'] . '" alt="' . $value['id'] . '">
						</div></div></div>';
					}
				}
			}

			$data['requirements'] = '<div class="col-md-12"><p>' . $requirements['requirement'] . '</p></div>';
			$data['location'] = '<div class="col-md-12"><p>' . $requirements['location'] . '</p></div>';
			$data['attachements'] = $attch;
			$data['status'] = 1;
		}
		echo json_encode($data);
	}

	public function getOrderReason()
	{
		$oId =  $this->input->post('oId');
		$user_id = $this->session->userdata('user_id');
		$order = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		$data['status'] = 0;
		if (!empty($order)) {
			$data['order_status'] = $order['status'];
			$data['reason'] = '<div class="col-md-12"><p>' . $order['reason'] . '</p></div>';
			$data['status'] = 1;
		}
		echo json_encode($data);
	}

	public function order_tracking($id = "")
	{
		if (!$id) {
			redirect(base_url());
			return;
		}

		if (!$this->session->userdata('user_id')) {
			redirect('login');
		}

		$user_id = $this->session->userdata('user_id');
		$order = $this->common_model->GetSingleData('service_order', ['id' => $id]);
		$data['user'] = $this->common_model->GetSingleData('users', ['id' => $user_id]);

		if (!empty($order)) {
			$data['service'] = $this->common_model->GetSingleData('my_services', ['id' => $order['service_id']]);

			$ouid = $order['user_id'];
			$suid = $data['service']['user_id'];

			if (!in_array($user_id, [$ouid, $suid])) {
				redirect(base_url());
				return;
			}

			$data['taskAddress'] = $this->common_model->GetSingleData('task_addresses', ['id' => $order['task_address_id']]);
			$data['orderReview'] = $this->common_model->GetSingleData('service_rating', ['order_id' => $order['id'], 'rate_by' => $order['user_id']]);

			$package_data = json_decode($data['service']['package_data'], true);
			$data['tradesman'] = $this->common_model->GetSingleData('users', ['id' => $data['service']['user_id']]);
			$data['homeowner'] = $this->common_model->GetSingleData('users', ['id' => $order['user_id']]);

			$statusHistory = $this->common_model->GetSingleData('service_order_status_history', ['order_id' => $order['id'], 'status' => 'active']);

			$today = date('Y-m-d');
			$delivery_date = '';
			$rDays = '';
			$rHours = '';
			$rMinutes = '';
			$days = 0;
			$data['is_extended'] = 1;
			$data['is_delivery'] = 1;
			$exten_delivery_date = '';

			// echo '<pre>';
			// print_r($statusHistory);
			// exit;

			if($order['is_custom'] == 1 && $order['order_type'] == "milestone"){
				$data['is_extended'] = 0;
			}

			if (!empty($statusHistory)) {
				$days = $order['is_custom'] == 0 ? $package_data[$order['package_type']]['days'] : $order['delivery'];
				$currentDate = new DateTime($statusHistory['created_at']);
				$currentDate->modify("+$days days");
				$exten_delivery_date = $currentDate->format('Y-m-d');
			}

			if(!empty($exten_delivery_date) && (in_array($order['is_exten_delivery_accepted'], [0,2]) || $order['status'] == 'extened_decline')){
				if($today > $exten_delivery_date ){
					$data['is_extended'] = 1;
					// $data['is_delivery'] = 0;
				}else{
					$exten_delivery_date_obj = new DateTime($exten_delivery_date);
	        $today_obj = new DateTime($today);
	        
	        $diff = $exten_delivery_date_obj->diff($today_obj);
	        $totalHours = $diff->days * 24;

	        $data['is_extended'] = $totalHours <= 24 ? 1 : 0;
				}
			}

			$data['requirements'] = $order['is_custom'] == 1 && $order['is_requirements'] == 0 ? [0 => ''] : [];

			if ($order['is_custom'] == 1) {
				$days = $order['delivery'];
				$currentDate = new DateTime($statusHistory['created_at']);
				$currentDate->modify("+$days days");
				$delivery_date = $currentDate->format('l, jS F Y, H:i');
				$currentDate1 = new DateTime();
				$interval = $currentDate1->diff($currentDate);
				$rDays = $interval->days;
				$rHours = $interval->h;
				$rMinutes = $interval->i;
			}

			if ($order['is_custom'] == 0 && !empty($statusHistory)) {
				$days = $package_data[$order['package_type']]['days'];
				$currentDate = new DateTime($statusHistory['created_at']);
				$currentDate->modify("+$days days");
				$delivery_date = $currentDate->format('l, jS F Y, H:i');
				$currentDate1 = new DateTime();
				$interval = $currentDate1->diff($currentDate);

				$rDays = $interval->days;
				$rHours = $interval->h;
				$rMinutes = $interval->i;
			}

			if (!empty($order['extended_date']) && !empty($order['extended_time']) || $order['is_exten_delivery_accepted'] == 1) {
				$passedDate = $order['extended_date'];
				$passedTime = $order['extended_time'];

				$passedDateTime = $passedDate . ' ' . $passedTime;
				$targetDateTime = new DateTime($passedDateTime);
				$currentDateTime = new DateTime();
				$interval = $currentDateTime->diff($targetDateTime);

				$expected_delivery_date = $targetDateTime->format('l, jS F Y, H:i');

				$rDays = $interval->days;
				$rHours = $interval->h;
				$rMinutes = $interval->i;
			}

			$requirements = $this->common_model->GetSingleData('order_requirement', ['order_id' => $id]);
			if (!empty($requirements)) {
				$data['requirements'] = $requirements;
				$data['attachements'] = $this->common_model->get_all_data('order_requirement_attachment', ['requirement_id' => $requirements['id']]);
			}

			$data['duration'] = $days;
			$data['order'] = $order;
			$data['delivery_date'] = $delivery_date;
			$data['rDays'] = $rDays;
			$data['rHours'] = $rHours;
			$data['rMinutes'] = $rMinutes;
			$data['expected_delivery_date'] = $expected_delivery_date;

			$ocDate = new DateTime($order['created_at']);
			$data['created_date'] = $ocDate->format('D jS F, Y H:i');

			if ($order['is_custom'] == 0) {
				$data['description'] = $package_data[$order['package_type']]['description'];
				$attributesArray = $package_data[$order['package_type']]['attributes'];
			} else {
				$data['description'] = $order['description'];
				if (!empty($order['offer_includes_ids'])) {
					$attributes = json_decode($order['offer_includes_ids'], true);
					foreach ($attributes as $key => $value) {
						if (!empty($value)) {
							foreach ($value as $v) {
								$attributesArray[] = $v;
							}
						}
					}
				}
				$attributesArray = array_unique($attributesArray);
			}

			$data['attributes'] = $this->common_model->getAttributes($attributesArray);
			$data['extra_services'] = $this->common_model->get_all_data('tradesman_extra_service', ['service_id' => $order['service_id']]);

			$selectedExs = !empty($order['ex_services']) ? explode(',', $order['ex_services']) : [];

			$existExs = [];

			foreach ($selectedExs as $exs) {
				$exIds = explode('-', $exs);
				$existExs[] = $exIds[0];
			}

			$data['selectedExs'] = $existExs;
			$data['conversation'] = $this->common_model->GetSingleData('order_submit_conversation', ['order_id' => $order['id']]);

			if ($order['is_custom'] == 0 || ($order['is_custom'] == 1 && $order['order_type'] == 'single')) {
				$data['all_conversation'] = $this->common_model->get_all_data(
					'order_submit_conversation',
					['order_id' => $order['id']],
					'order_submit_conversation.id'
				);
			} else {
				$data['all_conversation'] = $this->common_model->get_all_data(
					'order_submit_conversation',
					['order_id' => $order['id']],
					'order_submit_conversation.id', // Specify table name to avoid ambiguity
					'desc',
					null,
					'order_submit_conversation.*, tbl_milestones.milestone_name, tbl_milestones.service_status', // Example selected columns
					[
						'tbl_milestones' => 'order_submit_conversation.milestone_id = tbl_milestones.id'
					]
				);
			}

			$setting = $this->common_model->GetColumnName('admin', array('id' => 1));

			$newTime = '';
			$newTime = date('jS F Y', strtotime($order['status_update_time'] . ' +' . $setting['waiting_time'] . ' days'));
			$data['newTime'] = $newTime;

			$milestones = [];
			$cancelMilestoneExist = [];
			$disputeMilestoneExist = [];
			$deliveredMilestoneExist = [];
			if ($order['is_custom'] == 1 && $order['order_type'] == 'milestone') {
				$milestones = $this->common_model->get_all_data('tbl_milestones', ['milestone_type' => 'service', 'post_id' => $order['id']]);

				foreach ($milestones as &$milestone) {

					if($milestone['status'] == '3'){
						$cancelMilestoneExist[] = $milestone['id'];
					}

					if($milestone['status'] == '5'){
						$disputeMilestoneExist[] = $milestone['id'];
					}

					if($milestone['service_status'] == 'delivered'){
						$deliveredMilestoneExist[] = $milestone['id'];
					}

					$milestone['order_submit_conversation'] = $this->common_model->get_all_data('order_submit_conversation', ['milestone_id' => $milestone['id']], 'id');
				}
			}

			
			$data['milestones'] = $milestones;
			$data['cancelMilestoneExist'] = $cancelMilestoneExist;
			$data['disputeMilestoneExist'] = $disputeMilestoneExist;
			$data['deliveredMilestoneExist'] = $deliveredMilestoneExist;

			// echo '<pre>';
			// print_r($data);
			// exit;

			$this->load->view('site/order_tracking', $data);
		} else {
			redirect(base_url());
			return;
		}
	}

	public function getReason()
	{
		$sId = $this->input->post('id');
		$service = $this->common_model->get_single_data('my_services', array('id' => $sId));
		$json['status'] = 0;
		if (!empty($service)) {
			if (!empty($service['reason'])) {
				$json['status'] = 1;
				$json['reason'] = $service['reason'];
			}
		}
		echo json_encode($json);
	}

	public function promo_code($value = '')
	{
		if ($this->session->userdata('user_id')) {
			$user_id = $this->session->userdata('user_id');
			$data['promo_code'] = $this->common_model->get_my_service('my_services', $this->session->userdata('user_id'), $status);

			$data['promo_code'] = $this->common_model->get_all_data('promo_code', ['type' => 'tradesman', 'user_id' => $user_id]);

			$this->load->view('site/promo_code', $data);
		} else {
			redirect('login');
		}
	}

	public function getAllPromoCode()
	{
		if ($this->session->userdata('user_id')) {
			$user_id = $this->session->userdata('user_id');
			$promo_code = $this->common_model->get_all_data('promo_code', ['type' => 'tradesman', 'user_id' => $user_id]);
			$data = [];

			foreach ($promo_code as $pcode) {
				if ($pcode['is_limited'] && $pcode['is_limited'] == 'yes') {
					$is_limited = '<span class="label label-success">Yes</span>';
				} else {
					$is_limited = '<span class="label label-danger">No</span>';
				}

				$data[] = [
					'id' => $pcode['id'],
					'code' => $pcode['code'],
					'is_limited' => $is_limited,
					'limited_user' => $pcode['limited_user'],
					'exceeded_limit' => $pcode['exceeded_limit'],
					'discount' => $pcode['discount'],
					'discount_type' => $pcode['discount_type'],
					'status' => ucfirst($pcode['status']),
				];
			}

			echo json_encode(['data' => $data]);
		} else {
			echo json_encode(['data' => []]);
		}
	}

	public function add_coupon()
	{

		$this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
		$this->form_validation->set_rules('discount', 'Discount', 'required|numeric');
		$this->form_validation->set_rules('is_limited', 'Is Limited', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');

		if ($this->input->post('is_limited') == 'yes') {
			$this->form_validation->set_rules('limited_user', 'Limited User', 'required|numeric');
		}

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('promo-code');
		}

		$discountType = $this->input->post('discount_type');
		$discount = $this->input->post('discount');

		if ($discountType == 'percentage' && $discount > 100) {
			$this->session->set_flashdata('error', 'You cannot add discount percentage more then 100%.');
			redirect('promo-code');
		}

		$isLimited = $this->input->post('is_limited');
		$limitedUser = $this->input->post('limited_user');

		if ($isLimited == 'no') {
			$limitedUser = 0;
		}

		$user_id = $this->session->userdata('user_id');

		$insert['type']          = 'tradesman';
		$insert['user_id'] 		 = $user_id;
		$insert['code']          = $this->input->post('code');
		$insert['is_limited']    = $isLimited;
		$insert['limited_user']  = $limitedUser;
		$insert['discount_type'] = $discountType;
		$insert['discount']      = $discount;
		$insert['status']        = $this->input->post('status');

		$run = $this->common_model->insert('promo_code', $insert);
		if ($run) {
			$this->session->set_flashdata('success', 'Coupon has been added successfully.');
		} else {
			$this->session->set_flashdata('error', 'You cannot add discount percentage more then 100%.');
		}

		redirect('promo-code');
	}

	public function edit_coupon($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'Something went wrong.');
		}

		$this->form_validation->set_rules('discount_type', 'Discount Type', 'required');
		$this->form_validation->set_rules('discount', 'Discount', 'required|numeric');
		$this->form_validation->set_rules('is_limited', 'Is Limited', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');

		if ($this->input->post('is_limited') == 'yes') {
			$this->form_validation->set_rules('limited_user', 'Limited User', 'required|numeric');
		}

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('promo-code');
		}

		$discountType = $this->input->post('discount_type');
		$discount     = $this->input->post('discount');

		if ($discountType == 'percentage' && $discount > 100) {
			$this->session->set_flashdata('error', 'You cannot add discount percentage more then 100%.');
			redirect('promo-code');
		}

		$isLimited   = $this->input->post('is_limited');
		$limitedUser = $this->input->post('limited_user');

		if ($isLimited == 'no') {
			$limitedUser = 0;
		}

		$insert['code']          = $this->input->post('code');
		$insert['is_limited']    = $isLimited;
		$insert['limited_user']  = $limitedUser;
		$insert['discount_type'] = $discountType;
		$insert['discount']      = $discount;
		$insert['status']        = $this->input->post('status');

		$this->common_model->update_data('promo_code', ['id' => $id], $insert);
		$this->session->set_flashdata('success', 'Coupon has been updated successfully.');
		redirect('promo-code');
	}

	public function delete_coupons($id = null)
	{
		$insert['id'] = $id;
		$this->common_model->delete($insert, 'promo_code');
		$this->session->set_flashdata('success', 'Coupon has been deleted successfully.');
		redirect('promo-code');
	}

	public function submitModification()
	{
		$oId = $this->input->post('order_id');
		$mId = $this->input->post('milestone_id');
		$tuser_id = $this->input->post('tradesman_id');
		$homeowner_id = $this->input->post('homeowner_id');
		$status = $this->input->post('status');

		$milestone = $this->common_model->GetSingleData('tbl_milestones', ['id' => $mId]);
		$homeOwner = $this->common_model->GetSingleData('users', ['id' => $homeowner_id]);
		$tradesman = $this->common_model->GetSingleData('users', ['id' => $tuser_id]);
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		$is_review = 0;

		if (!empty($serviceOrder)) {
			if ($status == 'request_modification') {
				$description = $this->input->post('modification_decription');
				$subject = $homeOwner['f_name'] . " has Requested a Revision of your Delivered Work: " . $serviceOrder['order_id'];
				$flashMsg = 'Modification Request Submited';
				$flashErrMsg = 'Modification Request Not Submitted';
			} else {
				$description = $this->input->post('approve_decription');
				$subject = "Your Order Is Complete – Great Work!";
				$subject2 = "Your Order was Approved and Completed!";
				$flashMsg = 'Order Approved';
				$flashErrMsg = 'Order Not Approved';
				$is_review = $mId == 0 ? 1 : 0;
				$this->session->set_userdata('completedFlashMessage', 1);

				if ($serviceOrder['is_custom'] == 0) {
					$in['status'] = 2;
					$this->common_model->update('tbl_milestones', array('post_id' => $serviceOrder['id']), $in);
				}
			}

			$input['status'] = $status;
			$input['previous_status'] = $serviceOrder['status'];
			$input['status_update_time'] = date('Y-m-d H:i:s');
			$this->common_model->update('service_order', array('id' => $oId), $input);

			if ($mId > 0 && $serviceOrder['is_custom'] == 1) {
				if ($status == 'completed') {
					$mInput['status'] = 2;
				}
				$mInput['service_status'] = $status;
				$mInput['service_previous_status'] = $serviceOrder['status'];
				$mInput['status_update_time'] = $input['status_update_time'];
				$this->common_model->update('tbl_milestones', array('id' => $mId), $mInput);

				$totleMilestone = $this->common_model->getCountMilestone($oId);
				$totleCompletedMilestone = $this->common_model->getCountCompletedMilestone($oId);

				if ($totleMilestone == $totleCompletedMilestone && $status == 'completed') {
					$input['status'] = $status;
					$this->common_model->update('service_order', array('id' => $oId), $input);
					$is_review = 1;
				}
			}

			if ($status != 'request_modification') {
				$withdrawable_balance = $tradesman['withdrawable_balance'];

				if ($mId > 0) {
					$update1['withdrawable_balance'] = $withdrawable_balance + $milestone['total_amount'];
				} else {
					$update1['withdrawable_balance'] = $withdrawable_balance + $serviceOrder['price'];
				}

				$runss1 = $this->common_model->update('users', array('id' => $tradesman['id']), $update1);

				$transactionid = md5(rand(1000, 999) . time());
				$tr_message = '£' . $serviceOrder['price'] . ' has been credited to your wallet for order number ' . $serviceOrder['order_id'] . ' on date ' . date('d-m-Y h:i:s A') . '.';
				$data1 = array(
					'tr_userid' => $tradesman['id'],
					'tr_amount' => $serviceOrder['price'],
					'tr_type' => 1,
					'tr_transactionId' => $transactionid,
					'tr_message' => $tr_message,
					'tr_status' => 1,
					'tr_created' => date('Y-m-d H:i:s'),
					'tr_update' => date('Y-m-d H:i:s')
				);
				$run1 = $this->common_model->insert('transactions', $data1);
			}

			/*Manage Order History*/
			$insert1 = [
				'user_id' => $tuser_id,
				'service_id' => $serviceOrder['service_id'],
				'order_id' => $oId,
				'milestone_id' => $mId,
				'milestone_level' => $mId > 0 ? $milestone['milestone_level'] : 0,
				'status' => $status
			];
			$this->common_model->insert('service_order_status_history', $insert1);

			$insert['sender'] = $homeowner_id;
			$insert['receiver'] = $tuser_id;
			$insert['order_id'] = $oId;
			$insert['milestone_id'] = $mId;
			$insert['milestone_level'] = $mId > 0 ? $milestone['milestone_level'] : 0;
			$insert['status'] = $status;
			$insert['description'] = $description;
			$run = $this->common_model->insert('order_submit_conversation', $insert);
			if ($run) {
				$mImgs = !empty($this->input->post('multiModificationImgIds')) ? explode(',', $this->input->post('multiModificationImgIds')) : [];

				$input1['conversation_id'] = $run;
				if (count($mImgs) > 0) {
					foreach ($mImgs as $imgId) {
						$this->common_model->update('order_submit_attachments', array('id' => $imgId), $input1);
					}
				}

				/*Tradesman Email Code*/

				$newStatus = ucwords(str_replace('_', ' ', $status));
				$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

				if ($tradesman) {
					if ($status == 'completed') {
						$html = '<p style="margin:0;padding:10px 0px">Hi ' . $tradesman['trading_name'] . ',</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Congratulations! The order [Order ID: ' . $serviceOrder['order_id'] . '] with ' . $homeOwner['f_name'] . ' has been successfully completed. The customer has reviewed and accepted your delivery. Amazing job!</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Your hard work and professionalism keep our platform thriving, and your efforts are truly appreciated.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">What happens next?</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Payment Processing: Your earnings from this order are now being processed and will be added to your account balance shortly.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Customer Feedback: Leave a review for the customer and keep an eye out for the their review to see what they loved about your work.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Feel free to showcase this completed work as part of your portfolio to attract more clients. Don’t forget to update your profile with any new skills or achievements!</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Thank you for being an outstanding Pro on our platform. Keep up the fantastic work!</p>';
						$html .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave Review Now</a></div>';
						$html .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

						$this->common_model->send_mail($tradesman['email'], $subject, $html);

						$insertn['nt_userId'] = $tradesman['id'];
						$insertn['nt_message'] = "Your work was approved and completed. <a href='" . $pageUrl . "'>Leave Review Now!</a>";
						$insertn['nt_satus'] = 0;
						$insertn['nt_apstatus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $serviceOrder['id'];
						$insertn['posted_by'] = $homeOwner['id'];
						$run2 = $this->common_model->insert('notification', $insertn);
					} else {
						$html = '<p style="margin:0;padding:10px 0px">Hi ' . $tradesman['trading_name'] . ',</p>';
						$html .= "<p style='margin:0;padding:10px 0px'>Your client, " . $homeOwner['f_name'] . ", has requested a revision for the work you recently delivered. Here's what you need to know to ensure a smooth process:";

						$html .= "<p style='margin:0;padding:0px 0px'>1. Review the client's comments carefully to understand their expectations.</p>";
						$html .= "<p style='margin:0;padding:0px 0px'>2. Reach out to the client via our messaging system if you need clarification.</p>";
						$html .= "<p style='margin:0;padding:0px 0px; padding-bottom:10px'>3. Submit the revised work as soon as possible within the agreed timeline.</p>";

						$html .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Request Now</a></div>';

						$html .= '<p style="margin:0;padding:10px 0px">Revisions are a great opportunity to strengthen your professional relationship with the client and deliver outstanding results.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Thank you for your dedication to providing high-quality service! </p>';
						$html .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

						$this->common_model->send_mail($tradesman['email'], $subject, $html);

						$insertn['nt_userId'] = $tradesman['id'];
						$insertn['nt_message'] = $homeOwner['f_name'] . " has requested a revision. <a href='" . $pageUrl . "'>View Request Now!</a>";
						$insertn['nt_satus'] = 0;
						$insertn['nt_apstatus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $serviceOrder['id'];
						$insertn['posted_by'] = $homeOwner['id'];
						$run2 = $this->common_model->insert('notification', $insertn);
					}
				}

				if ($homeOwner) {
					if ($status == 'completed') {
						$html = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ',</p>';
						$html .= '<p style="margin:0;padding:10px 0px">We’re excited to inform you that your order has been successfully completed.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">We’re thrilled to see that the final delivery met your expectations and was approved by you. We hope this experience has been smooth and rewarding!</p>';
						$html .= '<p style="margin:0;padding:10px 0px">If you’d like to Leave a review, it only takes few minutes and helps other customers find top-notch services.</p>';
						$html .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave Review Now</a></div>';
						$html .= '<p style="margin:0;padding:10px 0px">Thank you for being part of our community. We look forward to helping you achieve even more in the future.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Visit our Customer help page or contact our customer services if you have any specific questions using our service.</p>';

						$this->common_model->send_mail($homeOwner['email'], $subject2, $html);

						$insertn['nt_userId'] = $homeOwner['id'];
						$insertn['nt_message'] = "Great news! You order has been approved and completed. <a href='" . $pageUrl . "'>Leave Review Now!</a>";
						$insertn['nt_satus'] = 0;
						$insertn['nt_apstatus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $serviceOrder['id'];
						$insertn['posted_by'] = $homeOwner['id'];
						$run2 = $this->common_model->insert('notification', $insertn);
					}
				}
			}
			echo json_encode(['status' => 'success', 'message' => $flashMsg, 'is_review' => $is_review]);
		} else {
			echo json_encode(['status' => 'error', 'message' => $flashErrMsg]);
		}
	}

	public function submitReviewRating()
	{
		$hId = $this->session->userdata('user_id');
		$tId = $this->input->post('rate_to');
		$oId = $this->input->post('order_id');
		$rate = $this->input->post('rating');
		$tRate = $this->input->post('seller_communication_rating');
		$recommandedRate = $this->input->post('recommanded_service_rating');
		$review = $this->input->post('reviews');

		$getRating = $this->common_model->get_single_data('service_rating', array('rate_to' => $tId, 'order_id' => $oId));

		$input = [];

		if (!empty($getRating)) {
			$input['rating'] = $rate;
			$input['seller_communication_rating'] = $tRate;
			$input['recommanded_service_rating'] = $recommandedRate;
			$input['review'] = $review;
			$run = $this->common_model->update('service_rating', array('id' => $getRating['id']), $input);
		} else {
			$insert1 = [
				'rate_by' => $hId,
				'rate_to' => $tId,
				'order_id' => $oId,
				'service_id' => $this->input->post('service_id'),
				'rating' => $rate,
				'seller_communication_rating' => $tRate,
				'recommanded_service_rating' => $recommandedRate,
				'review' => $review
			];
			$run = $this->common_model->insert('service_rating', $insert1);
		}

		if ($run) {
			$input1['is_review'] = 1;
			$this->common_model->update('service_order', array('id' => $this->input->post('order_id')), $input1);

			$data = array(
				'rt_rateBy' => $hId,
				'rt_rateTo' => $tId,
				'rate_type' => 'order',
				'rt_jobid' => $oId,
				'rt_rate' => $tRate,
				'rt_comment' => $review,
				'rt_create' => date('Y-m-d H:i:s')
			);
			$this->common_model->insert('rating_table', $data);

			$get_avg_rating = $this->common_model->get_avg_rating($tId);
			$avg = $get_avg_rating[0]['avg'];
			$get_user = $this->common_model->get_single_data('users', array('id' => $tId));
			$review = $get_user['total_reviews'];
			$update2['average_rate'] = $avg;
			$update2['total_reviews'] = $review + 1;

			$this->common_model->update('users', array('id' => $tId), $update2);

			$reviewPageUrl = site_url() . 'orderCompleted/' . $oId;
			$tradesman = $this->common_model->get_single_data('users', array('id' => $tId));
			$homeOwner = $this->common_model->get_single_data('users', array('id' => $hId));

			$insertn['nt_userId'] = $tId;
			$insertn['nt_message'] = 'You´ve received customer feedback. <a href="' . $reviewPageUrl . '">View now!</a>';
			$insertn['nt_satus'] = 0;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $oId;
			$insertn['posted_by'] = $hId;
			$run2 = $this->common_model->insert('notification', $insertn);

			//---------Homeowner Mail Code---------
			$subject1 = "You Got a Feedback on your Recent Completed Order!";

			$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Your recently completed order with ' . $homeOwner['f_name'] . ' has received a feedback.</p>';

			$content1 .= '<div style="text-align:center"><a href="' . $reviewPageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Now</a></div>';

			$content1 .= '<p style="margin:0;padding:10px 0px">If you’d like, you can respond to the review directly. Engaging with your buyers is a great way to build trust and strengthen relationships.</p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Visit our Pro help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($tradesman['email'], $subject1, $content1);

			echo json_encode(['status' => 'success', 'message' => 'Review & Rating submitted successfully']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Review & Rating not submitted']);
		}
	}

	public function add_dispute_files()
	{
		$files = [];
		if ($this->session->userdata('user_id')) {
			if (isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])) {
				foreach ($_FILES['files']['name'] as $key => $file) {
					$newName = explode('.', $_FILES['files']['name'][$key]);
					$size = $_FILES['files']['size'][$key];
					$ext = end($newName);
					$fileName = 'img/dispute/' . rand() . time() . '.' . $ext;
					if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $fileName)) {
						$insertDoc = [];
						$insertDoc['name'] = $fileName;

						$insertDoc['original_name'] = $file;

						$kb = round(($size / 1024), 2);
						$mb = round(($size / (1024 * 1024)), 2);
						$gb = round(($size / (1024 * 1024 * 1024)), 2);
						if ($gb >= 1) {
							$size = $gb . ' KB';
						} else if ($mb >= 1) {
							$size = $mb . ' MB';
						} else {
							$size = $kb . ' KB';
						}
						$insertDoc['size'] = $size;
						array_push($files, $insertDoc);
					}
				}

				echo json_encode([
					'status' => 1,
					'files' => $files,
				]);
				exit();
			} else {
				echo json_encode([
					'status' => 0,
					'message' => 'Something went wrong, try again later.',
				]);
				exit();
			}
		} else {
			echo json_encode([
				'status' => 0,
				'message' => 'Something went wrong, try again later.',
			]);
			exit();
		}
	}

	public function orderDisputeOLD()
	{
		$oId = $this->input->post('order_id');
		$reason = $this->input->post('reason');
		$dispute_milestones = $this->input->post('milestones');
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		
		
		$userid = $this->session->userdata('user_id');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
		$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);
		$pageUrl = base_url() . 'order-dispute/' . $oId;

		$setting = $this->common_model->GetColumnName('admin', array('id' => 1));
		$newTime = '';
		$newTime = date('jS F Y', strtotime($input['status_update_time'] . ' +' . $setting['waiting_time'] . ' days'));
		$oPrice = $serviceOrder['total_price'] - $serviceOrder['service_fee'];

		/*Manage Order History*/
		if ($userid == $homeOwner['id']) {
			$senderId = $userid;
			$receiverId = $tradesman['id'];

			$content = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ',</p>';

			$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $homeOwner['f_name'] . ' and awaits your response.</p>';

			$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

			$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

			$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

			$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $homeOwner['f_name'] . " can ask us to step in.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $homeOwner['f_name'] . '.</p>';

			$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $homeOwner['f_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $homeOwner['f_name'] . '.</p>';

			$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $tradesman['email'];
		}
		if ($userid == $tradesman['id']) {
			$senderId = $userid;
			$receiverId = $homeOwner['id'];

			$content = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ',</p>';

			$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $tradesman['trading_name'] . ' and awaits your response.</p>';

			$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

			$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

			$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

			$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $tradesman['trading_name'] . " can ask us to step in.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $tradesman['trading_name'] . '.</p>';

			$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $tradesman['trading_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $tradesman['trading_name'] . '.</p>';

			$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $homeOwner['email'];
		}
		
		$getAllDisputesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service']);
					
		$getAllDisputedMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service', 'status' => 5]);

		/* CHECK IF ORDER ALL MILSTONE CANCELLED THEN ORDER WILL BE CANCELLED */
		if(count($getAllDisputesCount) == count($getAllDisputedMilestonesCount)){
			$input['status'] = 'disputed';
			$input['is_cancel'] = 5;
			$input['status_update_time'] = date('Y-m-d H:i:s');
			$input['reason'] = $reason;
			$run = $this->common_model->update('service_order', array('id' => $oId), $input);
			if ($run) {
				

				/*Manage Order History*/
				$insert1 = [
					'user_id' => $senderId,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'status' => 'disputed'
				];
				$this->common_model->insert('service_order_status_history', $insert1);

				$insert2['sender'] = $senderId;
				$insert2['receiver'] = $receiverId;
				$insert2['order_id'] = $oId;
				$insert2['status'] = 'disputed';
				$insert2['description'] = $reason;
				$this->common_model->insert('order_submit_conversation', $insert2);

				/*Entry in Dispute Table*/

				if ($userid == $homeOwner['id']) {
					$dispute_to	= $tradesman['id'];
				}

				if ($userid == $tradesman['id']) {
					$dispute_to	= $homeOwner['id'];
				}

				$insert['ds_in_id'] = $userid;
				$insert['dispute_type'] = 2;
				$insert['ds_job_id'] = $serviceOrder['id'];
				$insert['ds_buser_id'] = $service['user_id'];
				$insert['ds_puser_id'] = $serviceOrder['user_id'];
				$insert['caseid'] = time();
				$insert['ds_status'] = 0;
				// $insert['total_amount'] = $serviceOrder['price'] * $serviceOrder['service_qty'];
				$insert['disputed_by'] = $userid;
				$insert['dispute_to'] = $dispute_to;
				$insert['ds_comment'] = $reason;
				$insert['ds_create_date'] = date('Y-m-d H:i:s');
				if ($this->session->userdata('type') == 1) {
					$insert['tradesmen_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
					
				} else {
					$insert['homeowner_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
				}

				if ($userid == $service['user_id']) {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($homeOwner['id']);
				} else {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($tradesman['id']);
				}

				$today = date('Y-m-d H:i:s');

				if(!empty($dispute_milestones)){
					/* DISPUTE SELECTED MILESTONE */
					foreach ($dispute_milestones as $key => $value) {
						$in['status'] = 5;
						$in['service_status'] = "disputed";
						$in['dispute_id'] = $run1;
						$this->common_model->update('tbl_milestones', array('id' => $value), $in);

						$insert0 = [];
						$insert0['dispute_id'] = $run1;
						$insert0['milestone_id'] = $value;
						$insert0['created_at'] = $today;
						$insert0['updated_at'] = $today;
						$this->common_model->insert('dispute_milestones', $insert0);
					}				
				}
				
				
			
				// $milestones = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $serviceOrder['id']]);

				// foreach ($milestones as $miles) {
				// 	$insert0 = [];
				// 	$insert0['dispute_id'] = $run1;
				// 	$insert0['milestone_id'] = $miles['id'];
				// 	$insert0['created_at'] = $today;
				// 	$insert0['updated_at'] = $today;
				// 	$this->common_model->insert('dispute_milestones', $insert0);
				// }

				if (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
					foreach ($_POST['file_name'] as $key => $file) {
						$file_name = $_POST['file_name'][$key];
						$file_original_name = $_POST['file_original_name'][$key];

						$insertDoc = [];
						$insertDoc['uploaded_by'] = $userid;
						$insertDoc['dispute_id'] = $run1;
						$insertDoc['file'] = $file_name;
						$insertDoc['original_name'] = $file_original_name;
						$insertDoc['created_at'] = date('Y-m-d H:i:s');
						$insertDoc['updated_at'] = date('Y-m-d H:i:s');
						$this->common_model->insert('dispute_file', $insertDoc);
					}
				}

				$login_users = $this->common_model->get_single_data('users', array('id' => $userid));
				$bid_users = $this->common_model->get_single_data('users', array('id' => $service['user_id']));
				$setting = $this->common_model->get_coloum_value('admin', array('id' => 1), array('waiting_time'));

				$newTime = date('Y-m-d H:i:s', strtotime($today . ' +' . $setting['waiting_time'] . ' days'));

				$insertn['nt_userId'] = $receiverId;
				$insertn['nt_message'] = "Your order has been disputed. <a href='" . $pageUrl . "'>Act Now!..</a>";
				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $serviceOrder['id'];
				$insertn['posted_by'] = $senderId;
				$run2 = $this->common_model->insert('notification', $insertn);

				$subject = "Urgent Action needed: Your order is been disputed - " . $service['service_name'] . ".";
				$sent = $this->common_model->send_mail($uMail, $subject, $content);

				echo json_encode(['status' => 'error', 'message' => 'Order disputed successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order is not disputed.']);
			}
		} else {
			
			$input['reason'] = $reason;
			$runfull = $this->common_model->update('service_order', array('id' => $oId), $input);
			
			if ($userid == $homeOwner['id']) {
				$dispute_to	= $tradesman['id'];
			}

			if ($userid == $tradesman['id']) {
				$dispute_to	= $homeOwner['id'];
			}

			$insert['ds_in_id'] = $userid;
			$insert['dispute_type'] = 2;
			$insert['ds_job_id'] = $serviceOrder['id'];
			$insert['ds_buser_id'] = $service['user_id'];
			$insert['ds_puser_id'] = $serviceOrder['user_id'];
			$insert['caseid'] = time();
			$insert['ds_status'] = 0;
			// $insert['total_amount'] = $serviceOrder['price'] * $serviceOrder['service_qty'];
			$insert['disputed_by'] = $userid;
			$insert['dispute_to'] = $dispute_to;
			$insert['ds_comment'] = $reason;
			$insert['ds_create_date'] = date('Y-m-d H:i:s');
			if ($this->session->userdata('type') == 1) {
				$insert['tradesmen_offer'] = $this->input->post('offer_amount');
				$insert['total_amount'] = $this->input->post('offer_amount');
				
			} else {
				$insert['homeowner_offer'] = $this->input->post('offer_amount');
				$insert['total_amount'] = $this->input->post('offer_amount');
			}

			if ($userid == $service['user_id']) {
				$run1 = $this->common_model->insert('tbl_dispute', $insert);
				$login_user = $this->common_model->get_userDataByid($homeOwner['id']);
			} else {
				$run1 = $this->common_model->insert('tbl_dispute', $insert);
				$login_user = $this->common_model->get_userDataByid($tradesman['id']);
			}

			$today = date('Y-m-d H:i:s');

			if(!empty($dispute_milestones)){
				/* DISPUTE SELECTED MILESTONE */
				foreach ($dispute_milestones as $key => $value) {
					$in['status'] = 5;
					$in['service_status'] = "disputed";
					$in['dispute_id'] = $run1;
					$this->common_model->update('tbl_milestones', array('id' => $value), $in);

					$insert0 = [];
					$insert0['dispute_id'] = $run1;
					$insert0['milestone_id'] = $value;
					$insert0['created_at'] = $today;
					$insert0['updated_at'] = $today;
					$this->common_model->insert('dispute_milestones', $insert0);
				}				
			}
			
			echo json_encode(['status' => 'error', 'message' => 'Milestone disputed successfully.']);
		}
	}

	public function orderDispute()
	{
		$oId = $this->input->post('order_id');
		$reason = $this->input->post('reason');
		$dispute_milestones = $this->input->post('milestones');
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

			
		$userid = $this->session->userdata('user_id');
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
		$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);
		$pageUrl = base_url() . 'order-dispute/' . $oId;

		$setting = $this->common_model->GetColumnName('admin', array('id' => 1));
		$newTime = '';
		$newTime = date('jS F Y', strtotime($input['status_update_time'] . ' +' . $setting['waiting_time'] . ' days'));

		if(!empty($dispute_milestones)){

			$totalAmountOfMilestones = $this->db->select_sum('total_amount')
			->where(['post_id' => $oId, 'milestone_type' => 'service'])
			->get('tbl_milestones')
			->row()
			->total_amount;


			$oPrice = $totalAmountOfMilestones;

			/*Manage Order History*/
			if ($userid == $homeOwner['id']) {
				$senderId = $userid;
				$receiverId = $tradesman['id'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ',</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $homeOwner['f_name'] . ' and awaits your response.</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

				$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

				$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $homeOwner['f_name'] . " can ask us to step in.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $homeOwner['f_name'] . '.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $homeOwner['f_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $homeOwner['f_name'] . '.</p>';

				$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $tradesman['email'];
			}
			if ($userid == $tradesman['id']) {
				$senderId = $userid;
				$receiverId = $homeOwner['id'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ',</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $tradesman['trading_name'] . ' and awaits your response.</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

				$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

				$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $tradesman['trading_name'] . " can ask us to step in.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $tradesman['trading_name'] . '.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $tradesman['trading_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $tradesman['trading_name'] . '.</p>';

				$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $homeOwner['email'];
			}

			$getAllDisputesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service']);
					
			$getAllDisputedMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service', 'status' => 5]);

			/* CHECK IF ORDER ALL MILSTONE DISPUTED THEN ORDER WILL BE DISPUTED */
			if(count($getAllDisputesCount) == count($getAllDisputedMilestonesCount)){
				$input['status'] = 'disputed';
				$input['is_cancel'] = 5;
				$input['status_update_time'] = date('Y-m-d H:i:s');
				$input['reason'] = $reason;
				$run = $this->common_model->update('service_order', array('id' => $oId), $input);
				if ($run) {


					

					/*Entry in Dispute Table*/

					if ($userid == $homeOwner['id']) {
						$dispute_to	= $tradesman['id'];
					}

					if ($userid == $tradesman['id']) {
						$dispute_to	= $homeOwner['id'];
					}

					$insert['ds_in_id'] = $userid;
					$insert['dispute_type'] = 2;
					$insert['ds_job_id'] = $serviceOrder['id'];
					$insert['ds_buser_id'] = $service['user_id'];
					$insert['ds_puser_id'] = $serviceOrder['user_id'];
					$insert['caseid'] = time();
					$insert['ds_status'] = 0;
					// $insert['total_amount'] = $serviceOrder['price'] * $serviceOrder['service_qty'];
					$insert['disputed_by'] = $userid;
					$insert['dispute_to'] = $dispute_to;
					$insert['ds_comment'] = $reason;
					$insert['ds_create_date'] = date('Y-m-d H:i:s');
					if ($this->session->userdata('type') == 1) {
						$insert['tradesmen_offer'] = $this->input->post('offer_amount');
						$insert['total_amount'] = $this->input->post('offer_amount');
						
					} else {
						$insert['homeowner_offer'] = $this->input->post('offer_amount');
						$insert['total_amount'] = $this->input->post('offer_amount');
					}

					if ($userid == $service['user_id']) {
						$run1 = $this->common_model->insert('tbl_dispute', $insert);
						$login_user = $this->common_model->get_userDataByid($homeOwner['id']);
					} else {
						$run1 = $this->common_model->insert('tbl_dispute', $insert);
						$login_user = $this->common_model->get_userDataByid($tradesman['id']);
					}

					$today = date('Y-m-d H:i:s');

					if(!empty($dispute_milestones)){
						/* DISPUTE SELECTED MILESTONE */
						foreach ($dispute_milestones as $key => $value) {

							// $getMilestone = $this->common_model->get_single_data('tbl_milestones', array('id' => $value));

							/*Manage Order History*/
							$insert1 = [
								'user_id' => $senderId,
								'service_id' => $serviceOrder['service_id'],
								'order_id' => $oId,
								'milestone_id' => "",
								'status' => 'disputed'
							];
							$this->common_model->insert('service_order_status_history', $insert1);

							$insert2['sender'] = $senderId;
							$insert2['receiver'] = $receiverId;
							$insert2['order_id'] = $oId;
							$insert2['status'] = 'disputed';
							$insert2['description'] = $reason;
							$this->common_model->insert('order_submit_conversation', $insert2);


							$in['sender_id'] = $senderId;
							$in['receiver_id'] = $receiverId;
							$in['status'] = 5;
							$in['service_status'] = "disputed";
							$in['dispute_id'] = $run1;
							$this->common_model->update('tbl_milestones', array('id' => $value), $in);

							$insert0 = [];
							$insert0['dispute_id'] = $run1;
							$insert0['milestone_id'] = $value;
							$insert0['created_at'] = $today;
							$insert0['updated_at'] = $today;
							$this->common_model->insert('dispute_milestones', $insert0);
						}				
					}
					
					
				

					if (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
						foreach ($_POST['file_name'] as $key => $file) {
							$file_name = $_POST['file_name'][$key];
							$file_original_name = $_POST['file_original_name'][$key];

							$insertDoc = [];
							$insertDoc['uploaded_by'] = $userid;
							$insertDoc['dispute_id'] = $run1;
							$insertDoc['file'] = $file_name;
							$insertDoc['original_name'] = $file_original_name;
							$insertDoc['created_at'] = date('Y-m-d H:i:s');
							$insertDoc['updated_at'] = date('Y-m-d H:i:s');
							$this->common_model->insert('dispute_file', $insertDoc);
						}
					}

					$login_users = $this->common_model->get_single_data('users', array('id' => $userid));
					$bid_users = $this->common_model->get_single_data('users', array('id' => $service['user_id']));
					$setting = $this->common_model->get_coloum_value('admin', array('id' => 1), array('waiting_time'));

					$newTime = date('Y-m-d H:i:s', strtotime($today . ' +' . $setting['waiting_time'] . ' days'));

					$insertn['nt_userId'] = $receiverId;
					$insertn['nt_message'] = "Your order has been disputed. <a href='" . $pageUrl . "'>Act Now!..</a>";
					$insertn['nt_satus'] = 0;
					$insertn['nt_apstatus'] = 0;
					$insertn['nt_create'] = date('Y-m-d H:i:s');
					$insertn['nt_update'] = date('Y-m-d H:i:s');
					$insertn['job_id'] = $serviceOrder['id'];
					$insertn['posted_by'] = $senderId;
					$run2 = $this->common_model->insert('notification', $insertn);

					$subject = "Urgent Action needed: Your order is been disputed - " . $service['service_name'] . ".";
					$sent = $this->common_model->send_mail($uMail, $subject, $content);

					echo json_encode(['status' => 'error', 'message' => 'Order disputed successfully.']);

				} else {
					echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order is not disputed.']);
				}
			}else{

				$input['reason'] = $reason;
				$runfull = $this->common_model->update('service_order', array('id' => $oId), $input);
				
				if ($userid == $homeOwner['id']) {
					$dispute_to	= $tradesman['id'];
				}

				if ($userid == $tradesman['id']) {
					$dispute_to	= $homeOwner['id'];
				}

				$insert['ds_in_id'] = $userid;
				$insert['dispute_type'] = 2;
				$insert['ds_job_id'] = $serviceOrder['id'];
				$insert['ds_buser_id'] = $service['user_id'];
				$insert['ds_puser_id'] = $serviceOrder['user_id'];
				$insert['caseid'] = time();
				$insert['ds_status'] = 0;
				// $insert['total_amount'] = $serviceOrder['price'] * $serviceOrder['service_qty'];
				$insert['disputed_by'] = $userid;
				$insert['dispute_to'] = $dispute_to;
				$insert['ds_comment'] = $reason;
				$insert['ds_create_date'] = date('Y-m-d H:i:s');
				if ($this->session->userdata('type') == 1) {
					$insert['tradesmen_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
					
				} else {
					$insert['homeowner_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
				}

				if ($userid == $service['user_id']) {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($homeOwner['id']);
				} else {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($tradesman['id']);
				}

				$today = date('Y-m-d H:i:s');

				if(!empty($dispute_milestones)){
					/* DISPUTE SELECTED MILESTONE */
					foreach ($dispute_milestones as $key => $value) {
						$in['sender_id'] = $senderId;
						$in['receiver_id'] = $receiverId;
						$in['status'] = 5;
						$in['service_status'] = "disputed";
						$in['dispute_id'] = $run1;
						$this->common_model->update('tbl_milestones', array('id' => $value), $in);

						$insert0 = [];
						$insert0['dispute_id'] = $run1;
						$insert0['milestone_id'] = $value;
						$insert0['created_at'] = $today;
						$insert0['updated_at'] = $today;
						$this->common_model->insert('dispute_milestones', $insert0);
					}				
				}
				
				echo json_encode(['status' => 'error', 'message' => 'Milestone disputed successfully.']);
			}

		}else{

			
			$oPrice = $serviceOrder['total_price'] - $serviceOrder['service_fee'];

			/*Manage Order History*/
			if ($userid == $homeOwner['id']) {
				$senderId = $userid;
				$receiverId = $tradesman['id'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ',</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $homeOwner['f_name'] . ' and awaits your response.</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

				$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

				$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $homeOwner['f_name'] . " can ask us to step in.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $homeOwner['f_name'] . '.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $homeOwner['f_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $homeOwner['f_name'] . '.</p>';

				$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $tradesman['email'];
			}
			if ($userid == $tradesman['id']) {
				$senderId = $userid;
				$receiverId = $homeOwner['id'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ',</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Your order is been disputed by ' . $tradesman['trading_name'] . ' and awaits your response.</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Number:</b> ' . $serviceOrder['order_id'] . '</p>';

				$content .= '<p style="margin:0;padding:0px 0px"><b>Order Dispute Amount:</b> £' . number_format($oPrice, 2) . '</p>';

				$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Dispute</a></div>';

				$content .= "<p style='margin:0;padding:10px 0px'>We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $tradesman['trading_name'] . " can ask us to step in.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Note: You not responding before ' . $newTime . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in the favour of ' . $tradesman['trading_name'] . '.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">If you receive a reply from ' . $tradesman['trading_name'] . ', please respond as soon as you can as not responding within the given time closes the case automatically and decided in favour of ' . $tradesman['trading_name'] . '.</p>';

				$content .= "<p style='margin:0;padding:10px 0px'>Any decision reached is final and irrevocable. Once a case is close, it can't reopen.</p>";

				$content .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $homeOwner['email'];
			}
			
			$getAllDisputesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service']);
						
			$getAllDisputedMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $oId, 'milestone_type' => 'service', 'status' => 5]);

			$input['status'] = 'disputed';
			$input['is_cancel'] = 5;
			$input['status_update_time'] = date('Y-m-d H:i:s');
			$input['reason'] = $reason;
			$run = $this->common_model->update('service_order', array('id' => $oId), $input);
			if ($run) {
				

				/*Manage Order History*/
				$insert1 = [
					'user_id' => $senderId,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'status' => 'disputed'
				];
				$this->common_model->insert('service_order_status_history', $insert1);

				$insert2['sender'] = $senderId;
				$insert2['receiver'] = $receiverId;
				$insert2['order_id'] = $oId;
				$insert2['status'] = 'disputed';
				$insert2['description'] = $reason;
				$this->common_model->insert('order_submit_conversation', $insert2);

				/*Entry in Dispute Table*/

				if ($userid == $homeOwner['id']) {
					$dispute_to	= $tradesman['id'];
				}

				if ($userid == $tradesman['id']) {
					$dispute_to	= $homeOwner['id'];
				}

				$insert['ds_in_id'] = $userid;
				$insert['dispute_type'] = 2;
				$insert['ds_job_id'] = $serviceOrder['id'];
				$insert['ds_buser_id'] = $service['user_id'];
				$insert['ds_puser_id'] = $serviceOrder['user_id'];
				$insert['caseid'] = time();
				$insert['ds_status'] = 0;
				// $insert['total_amount'] = $serviceOrder['price'] * $serviceOrder['service_qty'];
				$insert['disputed_by'] = $userid;
				$insert['dispute_to'] = $dispute_to;
				$insert['ds_comment'] = $reason;
				$insert['ds_create_date'] = date('Y-m-d H:i:s');
				if ($this->session->userdata('type') == 1) {
					$insert['tradesmen_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
					
				} else {
					$insert['homeowner_offer'] = $this->input->post('offer_amount');
					$insert['total_amount'] = $this->input->post('offer_amount');
				}

				if ($userid == $service['user_id']) {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($homeOwner['id']);
				} else {
					$run1 = $this->common_model->insert('tbl_dispute', $insert);
					$login_user = $this->common_model->get_userDataByid($tradesman['id']);
				}

				$today = date('Y-m-d H:i:s');

				if(!empty($dispute_milestones)){
					/* DISPUTE SELECTED MILESTONE */
					foreach ($dispute_milestones as $key => $value) {
						$in['sender_id'] = $senderId;
						$in['receiver_id'] = $receiverId;
						$in['status'] = 5;
						$in['service_status'] = "disputed";
						$in['dispute_id'] = $run1;
						$this->common_model->update('tbl_milestones', array('id' => $value), $in);

						$insert0 = [];
						$insert0['dispute_id'] = $run1;
						$insert0['milestone_id'] = $value;
						$insert0['created_at'] = $today;
						$insert0['updated_at'] = $today;
						$this->common_model->insert('dispute_milestones', $insert0);
					}				
				}
				
				
			
				// $milestones = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $serviceOrder['id']]);

				// foreach ($milestones as $miles) {
				// 	$insert0 = [];
				// 	$insert0['dispute_id'] = $run1;
				// 	$insert0['milestone_id'] = $miles['id'];
				// 	$insert0['created_at'] = $today;
				// 	$insert0['updated_at'] = $today;
				// 	$this->common_model->insert('dispute_milestones', $insert0);
				// }

				if (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
					foreach ($_POST['file_name'] as $key => $file) {
						$file_name = $_POST['file_name'][$key];
						$file_original_name = $_POST['file_original_name'][$key];

						$insertDoc = [];
						$insertDoc['uploaded_by'] = $userid;
						$insertDoc['dispute_id'] = $run1;
						$insertDoc['file'] = $file_name;
						$insertDoc['original_name'] = $file_original_name;
						$insertDoc['created_at'] = date('Y-m-d H:i:s');
						$insertDoc['updated_at'] = date('Y-m-d H:i:s');
						$this->common_model->insert('dispute_file', $insertDoc);
					}
				}

				$login_users = $this->common_model->get_single_data('users', array('id' => $userid));
				$bid_users = $this->common_model->get_single_data('users', array('id' => $service['user_id']));
				$setting = $this->common_model->get_coloum_value('admin', array('id' => 1), array('waiting_time'));

				$newTime = date('Y-m-d H:i:s', strtotime($today . ' +' . $setting['waiting_time'] . ' days'));

				$insertn['nt_userId'] = $receiverId;
				$insertn['nt_message'] = "Your order has been disputed. <a href='" . $pageUrl . "'>Act Now!..</a>";
				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $serviceOrder['id'];
				$insertn['posted_by'] = $senderId;
				$run2 = $this->common_model->insert('notification', $insertn);

				$subject = "Urgent Action needed: Your order is been disputed - " . $service['service_name'] . ".";
				$sent = $this->common_model->send_mail($uMail, $subject, $content);

				echo json_encode(['status' => 'error', 'message' => 'Order disputed successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order is not disputed.']);
			}

		}
		
		
	}

	public function orderCancel()
	{
		$oId = $this->input->post('order_id');
		$reason = $this->input->post('reason');
		$cancel_milestones = $this->input->post('milestones');
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
		$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);
		$hId = $this->session->userdata('user_id');

		$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];
		if ($hId == $homeOwner['id']) {
			$senderId = $hId;
			$receiverId = $tradesman['id'];
			$nMessage = $homeOwner['f_name'] . ' sent you an milestone cancellation request. <a href="' . $pageUrl . '">Review Now!</a>';
		}
		if ($hId == $tradesman['id']) {
			$senderId = $hId;
			$receiverId = $homeOwner['id'];
			$nMessage = $tradesman['trading_name'] . ' sent you an milestone cancellation request. <a href="' . $pageUrl . '">Review Now!</a>';
		}

		
		if(!empty($cancel_milestones)){

			/* IF ANY SELECTED MILESTONE THEN CANCELLED ONLY SELECTED.. */
			if(!empty($cancel_milestones)){

				/* CANCEL SELECTED MILESTONE */
				$dct_image = "";
				if ($_FILES['dct_image']['name'] != '') {
					$config['upload_path']   = 'img/request_cancel/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['remove_spaces'] = TRUE;
					$config['encrypt_name'] = TRUE;
					$this->load->library('upload', $config);
	
					if ($this->upload->do_upload('dct_image')) {
						$data = $this->upload->data();
						$dct_image = $data['file_name']; // Set the filename here
					}
				}

				foreach ($cancel_milestones as $key => $value) {
					
					$in['status'] = 3;
					$in['service_status'] = 'cancel';
					$in['dispute_id'] = null;
					$in['reason_cancel'] = $reason;
					$in['dct_image'] = $dct_image;
					$in['sender_id'] = $senderId;
					$in['receiver_id'] = $receiverId;
					$in['status_update_time'] = date('Y-m-d H:i:s');
					$this->common_model->update('tbl_milestones', array('id' => $value), $in);
				}

				$insertn['nt_userId'] = $receiverId;
				$insertn['nt_message'] = $nMessage;
				$insertn['nt_satus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $oId;
				$insertn['posted_by'] = $senderId;
				$run2 = $this->common_model->insert('notification', $insertn);

				echo json_encode(['status' => 'error', 'message' => 'Milestone cancelled successfully.']);
			}

		}else{
		
			$input['status'] = 'cancelled';
			$input['is_cancel'] = 2;
			$input['reason'] = $reason;
			$input['status_update_time'] = date('Y-m-d H:i:s');

			if ($_FILES['dct_image']['name'] != '') {
				$config['upload_path']   = 'img/request_cancel/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('dct_image')) {
					$data = $this->upload->data();
					$input['order_cancel_file'] = $data['file_name']; // Set the filename here
				}
			}

			$run = $this->common_model->update('service_order', array('id' => $oId), $input);
			if ($run) {
				

				$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

				if ($hId == $homeOwner['id']) {
					$senderId = $hId;
					$receiverId = $tradesman['id'];

					$subject = $homeOwner['f_name'] . ', Request to Cancel ' . $serviceOrder['order_id'] . '!';

					$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

					$content1 .= '<p style="margin:0;padding:10px 0px">' . $homeOwner['f_name'] . ', has requested your consent to cancel order ' . $serviceOrder['order_id'] . ' for the service titled "' . $service['service_name'] . '"</p>';

					$content1 .= "<p style='margin:0;padding:10px 0px'>To review the reason for this cancellation, please click below.</p>";

					$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review Reason</a></div>';

					$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

					$uMail = $tradesman['email'];

					$nMessage = $homeOwner['f_name'] . ' sent you an order cancellation request. <a href="' . $pageUrl . '">Review Now!</a>';
				}
				if ($hId == $tradesman['id']) {
					$senderId = $hId;
					$receiverId = $homeOwner['id'];

					$subject = $tradesman['trading_name'] . ', Request to Cancel ' . $serviceOrder['order_id'] . '!';

					$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ', </p>';

					$content1 .= '<p style="margin:0;padding:10px 0px">' . $tradesman['trading_name'] . ', has requested your consent to cancel order ' . $serviceOrder['order_id'] . ' for the service titled "' . $service['service_name'] . '"</p>';

					$content1 .= "<p style='margin:0;padding:10px 0px'>To review the reason for this cancellation, please click below.</p>";

					$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review Reason</a></div>';

					$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

					$uMail = $homeOwner['email'];

					$nMessage = $tradesman['trading_name'] . ' sent you an order cancellation request. <a href="' . $pageUrl . '">Review Now!</a>';
				}

				/*Manage Order History*/
				$insert1 = [
					'user_id' => $senderId,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'status' => 'cancelled'
				];
				$this->common_model->insert('service_order_status_history', $insert1);

				$insert['sender'] = $senderId;
				$insert['receiver'] = $receiverId;
				$insert['order_id'] = $oId;
				$insert['is_cancel'] = 2;
				$insert['status'] = 'cancelled';
				$insert['description'] = $reason;
				$run = $this->common_model->insert('order_submit_conversation', $insert);

				if(!empty($cancel_milestones)){
					/* CANCEL SELECTED MILESTONE */
					foreach ($cancel_milestones as $key => $value) {
						$in['status'] = 4;
						$in['service_status'] = 'cancelled';
						$in['dispute_id'] = null;
						$this->common_model->update('tbl_milestones', array('id' => $value), $in);
					}
				}

				$this->common_model->send_mail($uMail, $subject, $content1);

				$insertn['nt_userId'] = $receiverId;
				$insertn['nt_message'] = $nMessage;
				$insertn['nt_satus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $oId;
				$insertn['posted_by'] = $senderId;
				$run2 = $this->common_model->insert('notification', $insertn);

				echo json_encode(['status' => 'error', 'message' => 'Order cancelled successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order is not cancelled.']);
			}
		}
	}

	public function offerCancel()
	{
		$oId = $this->input->post('order_id');
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		$input['status'] = 'cancelled';
		$input['is_cancel'] = 1;
		$input['is_accepted'] = 2;
		$input['status_update_time'] = date('Y-m-d H:i:s');

		$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

		$run = $this->common_model->update('service_order', array('id' => $oId), $input);
		if ($run) {
			$hId = $this->session->userdata('user_id');
			$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
			$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
			$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);

			if ($hId == $homeOwner['id']) {
				$senderId = $hId;
				$receiverId = $tradesman['id'];

				$subject = "Your Custom Offer to " . $homeOwner['f_name'] . " Has Been Rejected!";

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

				$content .= '<p style="margin:0;padding:10px 0px">Your custom offer to ' . $homeOwner['f_name'] . ' has been rejected. While this is not the outcome you had hoped for, it provides an opportunity to revisit and refine your proposal to better align with the buyer\'s needs.</p>';

				$content .= '<ul style="margin:0;padding:10px 0px; list-style-type: decimal;">
					<li><b>Review the Offer:</b> Take another look at the details of your custom offer. Consider whether the budget, scope, or timelines could be adjusted to better suit the customer´s expectations.</li>
					<li><b>Engage in a Discussion:</b> Reach out to David directly through the platform\'s messaging system to clarify any specific concerns or requirements they may have had regarding your initial proposal. Open communication can help ensure the next offer is a perfect fit.</li>
					<li><b>Create a Revised Offer:</b> After gathering feedback, prepare a revised custom offer that addresses any points of concern and demonstrates your commitment to delivering exceptional results.</li>
					</ul>';

				$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reach Out Now</a></div>';

				$content .= '<p style="margin:0;padding:10px 0px">We’re confident that with these adjustments, you’ll have a better chance of securing the project.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Visit our Pro help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $tradesman['email'];

				$ntMessgae = 'Your custom offer has been rejected. <a href="' . $pageUrl . '">View offer!</a>';
			}
			if ($hId == $tradesman['id']) {
				$senderId = $hId;
				$receiverId = $homeOwner['id'];

				$subject = "Your custom offer was withdrawn!";

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ', </p>';

				$content .= '<p style="margin:0;padding:10px 0px">' . $tradesman['trading_name'] . ' has withdrawn their custom offer.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $homeOwner['email'];

				$ntMessgae = 'Your custom offer was withdrawn.';
			}

			/*Manage Order History*/
			$insert1 = [
				'user_id' => $senderId,
				'service_id' => $serviceOrder['service_id'],
				'order_id' => $oId,
				'status' => 'cancelled'
			];
			$this->common_model->insert('service_order_status_history', $insert1);

			$insert['sender'] = $senderId;
			$insert['receiver'] = $receiverId;
			$insert['order_id'] = $oId;
			$insert['is_cancel'] = 1;
			$insert['status'] = 'cancelled';
			$insert['description'] = $reason;
			$run = $this->common_model->insert('order_submit_conversation', $insert);

			$this->common_model->send_mail($uMail, $subject, $content);

			$insertn1['nt_userId'] = $receiverId;
			$insertn1['nt_message'] = $ntMessgae;
			$insertn1['nt_satus'] = 0;
			$insertn1['nt_create'] = date('Y-m-d H:i:s');
			$insertn1['nt_update'] = date('Y-m-d H:i:s');
			$insertn1['job_id'] = $oId;
			$insertn1['posted_by'] = $senderId;
			$run2 = $this->common_model->insert('notification', $insertn1);

			echo json_encode(['status' => 'success', 'message' => 'Offer cancelled successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Offer is not cancelled.']);
		}
	}

	public function approve_decision($id)
	{
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $id]);
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);

		$get_users = $this->common_model->get_single_data('users', array('id' => $serviceOrder['user_id']));
		$get_users1 = $this->common_model->get_single_data('users', array('id' => $service['user_id']));
		$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

		$user_id = $this->session->userdata('user_id');

		if ($user_id == $get_users['id']) {
			$senderId = $user_id;
			$receiverId = $get_users1['id'];

			$subject = 'Your order has been cancelled';

			$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $get_users1['trading_name'] . ', </p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Your order was cancelled by ' . $get_users['f_name'] . '.</p>';

			$content1 .= '<p style="margin:0;padding:0px 0px">Order ID: ' . $serviceOrder['order_id'] . '</p>';
			$content1 .= '<p style="margin:0;padding:0px 0px">Service name: ' . $service['service_name'] . '</p>';

			$content1 .= "<p style='margin:0;padding:10px 0px'>Review the reason for this cancellation by clicking below.</p>";

			$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review Reason</a></div>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $get_users1['email'];

			$nMessage = 'Your order was cancelled. <a href="' . $pageUrl . '" >View Now!</a>';
		}
		if ($user_id == $get_users1['id']) {
			$senderId = $user_id;
			$receiverId = $get_users['id'];

			$subject = 'Your order has been cancelled';

			$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $get_users['f_name'] . ', </p>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Your order was cancelled by ' . $get_users1['trading_name'] . ' and payment refunded to your wallet.</p>';

			$content1 .= '<p style="margin:0;padding:0px 0px">Order ID: ' . $serviceOrder['order_id'] . '</p>';
			$content1 .= '<p style="margin:0;padding:0px 0px">Service name: ' . $service['service_name'] . '</p>';

			$content1 .= "<p style='margin:0;padding:10px 0px'>Review the reason for this cancellation by clicking below.</p>";

			$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Review Reason</a></div>';

			$content1 .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $get_users['email'];

			$nMessage = 'Your order was cancelled. <a href="' . $pageUrl . '" >View Now!</a>';
		}

		$update2['u_wallet'] = $get_users['u_wallet'] + $serviceOrder['price'];

		$runss1 = $this->common_model->update('users', array('id' => $serviceOrder['user_id']), $update2);

		$insertn['nt_userId'] = $receiverId;
		$insertn['nt_message'] = $nMessage;
		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['job_id'] = $id;
		$insertn['posted_by'] = $senderId;
		$run2 = $this->common_model->insert('notification', $insertn);

		$transactionid = md5(rand(1000, 999) . time());
		$tr_message = '£' . $serviceOrder['price'] . ' has been credited to your wallet for order number' . $serviceOrder['order_id'] . ' on date ' . date('d-m-Y h:i:s A') . '.';
		$data1 = array(
			'tr_userid' => $serviceOrder['user_id'],
			'tr_amount' => $serviceOrder['price'],
			'tr_type' => 1,
			'tr_transactionId' => $transactionid,
			'tr_message' => $tr_message,
			'tr_status' => 1,
			'tr_created' => date('Y-m-d H:i:s'),
			'tr_update' => date('Y-m-d H:i:s')
		);
		$run1 = $this->common_model->insert('transactions', $data1);

		$od['is_cancel'] = 1;
		$od['status'] = 'cancelled';
		$od['reason'] = '';
		$od['status_update_time'] = date('Y-m-d H:i:s');
		$run = $this->common_model->update('service_order', array('id' => $id), $od);

		/*Manage Order History*/
		$insert1 = [
			'user_id' => $user_id,
			'is_cancel' => 1,
			'service_id' => $service['id'],
			'order_id' => $id,
			'status' => 'cancelled'
		];
		$this->common_model->insert('service_order_status_history', $insert1);

		$insert2['sender'] = $senderId;
		$insert2['receiver'] = $receiverId;
		$insert2['order_id'] = $id;
		$insert2['status'] = 'cancelled';
		$insert2['is_cancel'] = 1;
		$insert2['description'] = $get_users1['trading_name'] . ' has been approved your order cancellation request';
		$run = $this->common_model->insert('order_submit_conversation', $insert2);

		$runMail = $this->common_model->send_mail($uMail, $subject, $content1);

		if ($runMail) {
			echo json_encode(['status' => 1, 'message' => 'Success! Request cancellation of order has been approved successfully.']);
		} else {
			echo json_encode(['status' => 0, 'message' => 'Something is wrong.']);
		}
	}

	public function withdraw_request($oId)
	{
		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		$input['status'] = $serviceOrder['previous_status'];
		$input['reason'] = '';
		$input['is_cancel'] = 4;
		$input['status_update_time'] = date('Y-m-d H:i:s');

		$run = $this->common_model->update('service_order', array('id' => $oId), $input);
		if ($run) {
			$hId = $this->session->userdata('user_id');
			$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
			$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
			$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);

			if ($hId == $homeOwner['id']) {
				$senderId = $hId;
				$receiverId = $tradesman['id'];
				$reason = $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . 'has been withdraw order cancellation request';
				$uname = $tradesman['trading_name'];
				$wuname = $homeOwner['f_name'] . ' ' . $homeOwner['l_name'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

				$content .= '<p style="margin:0;padding:10px 0px">' . $homeOwner['f_name'] . ' has withdrawn the cancellation request for your order ' . $serviceOrder['order_id'] . '. This means the cancellation will no longer be processed. As a result, the order will continue as originally planned.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Visit our Customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $tradesman['email'];
			}
			if ($hId == $tradesman['id']) {
				$senderId = $hId;
				$receiverId = $homeOwner['id'];
				$reason = $tradesman['trading_name'] . ' has been withdraw order cancellation request';
				$uname = $homeOwner['f_name'] . ' ' . $homeOwner['l_name'];
				$wuname = $tradesman['trading_name'];

				$content = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ', </p>';

				$content .= '<p style="margin:0;padding:10px 0px">' . $tradesman['trading_name'] . ' has withdrawn the cancellation request for your order ' . $serviceOrder['order_id'] . '. This means the cancellation will no longer be processed. As a result, the order will continue as originally planned.</p>';

				$content .= '<p style="margin:0;padding:10px 0px">Visit our Customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$uMail = $homeOwner['email'];
			}

			/*Manage Order History*/
			$insert1 = [
				'user_id' => $senderId,
				'service_id' => $serviceOrder['service_id'],
				'order_id' => $oId,
				'status' => 'withdraw_cancelled'
			];
			$this->common_model->insert('service_order_status_history', $insert1);

			$insert['sender'] = $senderId;
			$insert['receiver'] = $receiverId;
			$insert['order_id'] = $oId;
			$insert['is_cancel'] = 4;
			$insert['status'] = 'withdraw_cancelled';
			$insert['description'] = $reason;
			$run = $this->common_model->insert('order_submit_conversation', $insert);

			/*Email Code*/
			$subject = "Order Cancellation Request Withdrawn!";
			$this->common_model->send_mail($uMail, $subject, $content);

			$insertn1['nt_userId'] = $receiverId;
			$insertn1['nt_message'] = 'Your order cancellation request was withdrawn.';
			$insertn1['nt_satus'] = 0;
			$insertn1['nt_create'] = date('Y-m-d H:i:s');
			$insertn1['nt_update'] = date('Y-m-d H:i:s');
			$insertn1['job_id'] = $oId;
			$insertn1['posted_by'] = $senderId;
			$run2 = $this->common_model->insert('notification', $insertn1);

			echo json_encode(['status' => 'error', 'message' => 'Withdraw order cancellation request successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order cancellation request is not withdraw.']);
		}
	}

	public function declineCancel()
	{
		$id = $this->input->post('order_id');

		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $id]);
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

		$updatem['status'] = $serviceOrder['previous_status'];
		$updatem['is_cancel'] = 3;
		$updatem['cancel_decline_reason'] = $this->input->post('decline_reason');
		$runs = $this->common_model->update('service_order', array('id' => $id), $updatem);

		$user_id = $this->session->userdata('user_id');
		$get_users = $this->common_model->get_single_data('users', array('id' => $serviceOrder['user_id']));
		$get_users1 = $this->common_model->get_single_data('users', array('id' => $service['user_id']));

		if ($user_id == $get_users['id']) {
			$senderId = $user_id;
			$receiverId = $get_users1['id'];

			$content = '<p style="margin:0;padding:10px 0px">Dear ' . $get_users1['trading_name'] . ', </p>';

			$content .= '<p style="margin:0;padding:10px 0px">Your request to cancel the order has been reviewed but was unfortunately rejected by ' . $get_users['f_name'] . '. I understand that you may have concerns on reasons for the rejection. </p>';

			$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason</a></div>';

			$content .= "<p style='margin:0;padding:10px 0px'>We´re committed to working together to reach a resolution.If you are unable to come to a mutual agreement, please be aware that you have the option to deliver the work completed so far and proceed with opening a formal dispute on the order. This will allow both parties to present their perspectives and seek a fair resolution through the platform.</p>";

			$content .= "<p style='margin:0;padding:10px 0px'>If you would like to discuss this matter further, please don't hesitate to reach out. We´re happy to assist in resolving this in a way that benefits both of you.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $get_users1['email'];
		}
		if ($user_id == $get_users1['id']) {
			$senderId = $user_id;
			$receiverId = $get_users['id'];

			$content = '<p style="margin:0;padding:10px 0px">Dear ' . $get_users['f_name'] . ', </p>';

			$content .= '<p style="margin:0;padding:10px 0px">Your request to cancel the order has been reviewed but was unfortunately rejected by ' . $get_users1['trading_name'] . '. I understand that you may have concerns on reasons for the rejection.</p>';

			$content .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason</a></div>';

			$content .= "<p style='margin:0;padding:10px 0px'>We´re committed to working together to reach a resolution.If you are unable to come to a mutual agreement, please be aware that you have the option to get " . $get_users1['trading_name'] . " to deliver the work completed so far and proceed with opening a formal dispute on the order. This will allow both parties to present their perspectives and seek a fair resolution through the platform.</p>";

			$content .= "<p style='margin:0;padding:10px 0px'>If you would like to discuss this matter further, please don't hesitate to reach out. We´re happy to assist in resolving this in a way that benefits both of you.</p>";

			$content .= '<p style="margin:0;padding:10px 0px">Visit our Customer help page or contact our customer services if you have any specific questions using our service.</p>';

			$uMail = $get_users['email'];
		}

		/*Manage Order History*/
		$insert1 = [
			'user_id' => $user_id,
			'service_id' => $service['id'],
			'order_id' => $id,
			'status' => 'declined'
		];

		$this->common_model->insert('service_order_status_history', $insert1);

		$insert2['sender'] = $senderId;
		$insert2['receiver'] = $receiverId;
		$insert2['order_id'] = $id;
		$insert2['is_cancel'] = 3;
		$insert2['status'] = 'declined';
		$insert2['description'] = $this->input->post('decline_reason');
		$run = $this->common_model->insert('order_submit_conversation', $insert2);

		$insertn['nt_userId'] = $receiverId;
		$insertn['nt_message'] = 'Your order cancellation request was declined. <a href="' . $pageUrl . '">View Reason!</a>';
		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['job_id'] = $id;
		$insertn['posted_by'] = $senderId;
		$run2 = $this->common_model->insert('notification', $insertn);

		$subject = "Order Cancellation Request Rejected - Next Steps";
		$run = $this->common_model->send_mail($uMail, $subject, $content);

		if ($run) {
			echo json_encode(['status' => 1, 'message' => 'Success! Request cancellation of order has been declined successfully.']);
		} else {
			echo json_encode(['status' => 0, 'message' => 'Something is wrong.']);
		}
	}

	public function orderCompleted($id = null)
	{
		$oId = $id;
		$user_id = $this->session->userdata('user_id');

		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);

		$ouid = $serviceOrder['user_id'];
		$suid = $service['user_id'];

		if (!in_array($user_id, [$ouid, $suid])) {
			redirect(base_url());
			return;
		}

		$data['homeOwner'] = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);

		$data['tradesman'] = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);

		$data['orderReview'] = $this->common_model->GetSingleData('service_rating', ['order_id' => $serviceOrder['id'], 'rate_by' => $serviceOrder['user_id']]);

		$data['taskAddress'] = $this->common_model->GetSingleData('task_addresses', ['id' => $serviceOrder['task_address_id']]);

		$data['review'] = $this->common_model->GetSingleData('service_rating', ['order_id' => $serviceOrder['id'], 'service_id' => $service['id'], 'rate_by' => $serviceOrder['user_id'], 'rate_to' => $service['user_id']]);

		$data['tRate'] = $this->common_model->GetSingleData('rating_table', ['rate_type' => 'order', 'rt_rateBy' => $serviceOrder['user_id'], 'rt_rateTo' => $service['user_id']]);

		$data['service'] = $service;

		$data['order'] = $serviceOrder;

		$ocDate = new DateTime($serviceOrder['created_at']);

		$data['created_date'] = $ocDate->format('D jS F, Y H:i');

		$data['user_type'] = $this->session->userdata('type');

		$data['completedFlashMessage'] = $this->session->userdata('completedFlashMessage');
		$this->session->unset_userdata('completedFlashMessage');

		$this->load->view('site/completedOrder', $data);
	}

	public function submitRespond()
	{
		$tId = $this->input->post('rate_to');
		$oId = $this->input->post('order_id');
		$seller_review = $this->input->post('seller_review');
		$homeowner_rating = $this->input->post('homeowner_rating');
		$is_respond = $this->input->post('is_respond') ?? 0;

		$getRating = $this->common_model->get_single_data('service_rating', array('rate_to' => $tId, 'order_id' => $oId));

		$order = $this->common_model->get_single_data('service_order', array('id' => $oId));
		$homwowner = $this->common_model->get_single_data('users', array('id' => $order['user_id']));
		$tradesman = $this->common_model->get_single_data('users', array('id' => $tId));

		if (!empty($getRating)) {
			if ($is_respond == 1) {
				$input['seller_response'] = $seller_review;
				$input['is_responded'] = 1;
			} else {
				$input['homeowner_rating'] = $homeowner_rating;
				$input['seller_review'] = $seller_review;
			}

			$run = $this->common_model->update('service_rating', array('id' => $getRating['id']), $input);

			$reviewPageUrl = site_url() . 'orderCompleted/' . $order['id'];

			if ($run) {
				$insertn['nt_userId'] = $order['user_id'];
				$insertn['nt_message'] = 'You´ve received a feedback.  <a href="' . $reviewPageUrl . '">Review now!</a>';
				$insertn['nt_satus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $id;
				$insertn['posted_by'] = $tId;
				$run2 = $this->common_model->insert('notification', $insertn);

				//---------Homeowner Mail Code---------
				$subject1 = "You Got a Feedback on your Recent Completed Order!";

				$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $homwowner['f_name'] . ', </p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Your recently completed order with ' . $tradesman['trading_name'] . ' has received a feedback.</p>';

				$content1 .= '<div style="text-align:center"><a href="' . $reviewPageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Now</a></div>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Visit our Pro help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($homwowner['email'], $subject1, $content1);

				echo json_encode(['status' => 'success', 'message' => 'Your respond submitted successfully']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Your respond not submitted']);
			}
		} else {
			$insert1 = [
				'rate_by' => $order['user_id'],
				'rate_to' => $tId,
				'order_id' => $oId,
				'service_id' => $order['service_id'],
				'homeowner_rating' => $homeowner_rating,
				'seller_review' => $seller_review
			];
			$run = $this->common_model->insert('service_rating', $insert1);
			if ($run) {
				echo json_encode(['status' => 'success', 'message' => 'Your review submitted successfully']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Your review not submitted']);
			}
		}
	}

	public function ratingHelpful()
	{
		$rateId = $this->input->post('rateId');
		$serviceId = $this->input->post('serviceId');
		$help = $this->input->post('help');
		$userId = $this->session->userdata('user_id');

		if ($this->session->userdata('user_id')) {
			$helpfulRate = $this->common_model->get_single_data('rating_helpful', array('rating_id' => $rateId, 'service_id' => $serviceId, 'user_id' => $userId));

			if (!empty($helpfulRate)) {
				$update2['is_helpFul'] = strtolower($help);
				$runss1 = $this->common_model->update('rating_helpful', array('rating_id' => $rateId, 'service_id' => $serviceId, 'user_id' => $userId), $update2);
			} else {
				$data = array(
					'rating_id' => $rateId,
					'service_id' => $serviceId,
					'user_id' => $userId,
					'is_helpFul' => strtolower($help),
				);
				$run1 = $this->common_model->insert('rating_helpful', $data);
			}

			$totalCount = $this->common_model->getTotalHelpfulReview($rateId, $serviceId, strtolower($help));
			if (strtolower($help) == 'yes') {
				$totalPerson = $totalCount . ' person found this helpful';
			} else {
				$totalPerson = $totalCount . ' person found this unhelpful';
			}
			echo json_encode(['status' => 1, 'help' => strtolower($help), 'totalPerson' => $totalPerson]);
			exit;
		} else {
			echo json_encode(['status' => 0]);
			exit;
		}
	}

	public function extenedTime()
	{
		if (!$this->session->userdata('user_id')) {
			$json['status'] = 2;
			echo json_encode($json);
			exit;
		}

		$oId = $this->input->post('oId');
		$extended_date = date('Y-m-d', strtotime($this->input->post('ex_date')));
		$extended_time = $this->input->post('ex_time');

		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);
		$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
		$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
		$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);
		$pageUrl = site_url() . 'order-tracking/' . $oId;

		if (!empty($serviceOrder)) {
			$reason = 'Exteneded delivery time requested';

			$input['extended_date'] = $extended_date;
			$input['extended_time'] = $extended_time;
			$input['status'] = 'extened_request';
			$input['is_cancel'] = 10;
			$input['reason'] = $reason;
			$input['is_exten_delivery_accepted'] = 0;
			$run = $this->common_model->update('service_order', array('id' => $oId), $input);
			if ($run) {
				$insertn['nt_userId'] = $serviceOrder['user_id'];
				$insertn['nt_message'] = 'You´ve received an extension request. <a href="' . $pageUrl . '">View now!</a>';
				$insertn['nt_satus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $oId;
				$insertn['posted_by'] = $serviceOrder['user_id'];
				$run2 = $this->common_model->insert('notification', $insertn);

				$subject1 = "Request for Order Delivery Extension: " . $serviceOrder['order_id'];

				$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $homeOwner['f_name'] . ', </p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">The ' . $tradesman['trading_name'] . ' has requested an extension as they are unable to deliver the order by the originally agreed deadline. They have proposed extending the delivery date.</p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">We kindly ask you to review this request and respond as soon as possible.</p>';

				$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Visit our customer help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($homeOwner['email'], $subject1, $content1);

				echo json_encode(['status' => 1, 'message' => 'Delivery time exteneded successfully.']);
			} else {
				echo json_encode(['status' => 3, 'message' => 'Something is wrong. Delivery time is not exteneded.']);
			}
		} else {
			echo json_encode(['status' => 3, 'message' => 'Something is wrong. Delivery time is not exteneded.']);
		}
	}

	public function acceptExtenedTime()
	{
		if (!$this->session->userdata('user_id')) {
			$json['status'] = 2;
			echo json_encode($json);
			exit;
		}

		$oId = $this->input->post('oId');
		$is_accepted = $this->input->post('type');

		$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $oId]);

		if (!empty($serviceOrder)) {
			$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
			$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
			$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);

			$input['is_exten_delivery_accepted'] = $is_accepted;
			$input['status'] = 'active';

			$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

			if ($is_accepted == 2) {
				$reason = 'Exteneded delivery time is not accepted';

				$input['status'] = 'active';
				$input['is_cancel'] = 0;
				$input['reason'] = $reason;
				$input['status_update_time'] = date('Y-m-d H:i:s');

				$hId = $this->session->userdata('user_id');

				if ($hId == $homeOwner['id']) {
					$senderId = $hId;
					$receiverId = $tradesman['id'];
				}
				if ($hId == $tradesman['id']) {
					$senderId = $hId;
					$receiverId = $homeOwner['id'];
				}

				/*Manage Order History*/
				$insert1 = [
					'user_id' => $senderId,
					'service_id' => $serviceOrder['service_id'],
					'order_id' => $oId,
					'status' => 'extened_decline'
				];
				$this->common_model->insert('service_order_status_history', $insert1);

				$insert['sender'] = $senderId;
				$insert['receiver'] = $receiverId;
				$insert['order_id'] = $oId;
				$insert['is_cancel'] = 9;
				$insert['status'] = 'extened_decline';
				$insert['description'] = $reason;
				$run = $this->common_model->insert('order_submit_conversation', $insert);

				$ntMessage = 'Delivery Extension request Rejected. <a href="' . $pageUrl . '">View now!</a>';

				$subject1 = "Your Order Delivery Extension request was rejected.";

				$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">' . $homeOwner['f_name'] . ' has rejected your request to extend the order delivery time.</p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">To ensure the smooth completion of this order and maintain a positive experience for both you and the customer, we recommend reaching out to the customer directly to discuss and agree upon a new delivery timeline.</p>';

				$content1 .= '<div style="text-align:center"><a href="' . $pageUrl . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reach out Now</a></div>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Once an updated timeline is agreed upon, please navigate to the order details page and submit a new request for the extension. This will help keep everything documented and ensure the customer’s approval for the updated schedule.</p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';
			} else {
				$ntMessage = 'Your extension request was accepted. <a href="' . $pageUrl . '">View now!</a>';

				$subject1 = "Order Delivery Extension Accepted.";

				$content1 = '<p style="margin:0;padding:10px 0px">Dear ' . $tradesman['trading_name'] . ', </p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">' . $homeOwner['f_name'] . ' has accepted your order delivery time extension.</p>';

				$content1 .= '<p style="margin:0;padding:10px 0px">Visit our PRO help page or contact our customer services if you have any specific questions using our service.</p>';
			}

			$run = $this->common_model->update('service_order', array('id' => $oId), $input);
			if ($run) {
				$insertn['nt_userId'] = $tradesman['id'];
				$insertn['nt_message'] = $ntMessage;
				$insertn['nt_satus'] = 0;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $list['id'];
				$insertn['posted_by'] = $homeOwner['id'];
				$run2 = $this->common_model->insert('notification', $insertn);

				$this->common_model->send_mail($tradesman['email'], $subject1, $content1);

				echo json_encode(['status' => 1, 'message' => 'Delivery time exteneded successfully.']);
			} else {
				echo json_encode(['status' => 3, 'message' => 'Something is wrong. Delivery time is not exteneded.']);
			}
		} else {
			echo json_encode(['status' => 3, 'message' => 'Something is wrong. Delivery time is not exteneded.']);
		}
	}

	public function acceptCancellationMilestone(){
		
		if($_POST){
		
			$orderId = $_POST['order_id'];

			
			
			/* CANCELLED SELECTED MILESTONE AFTER APPROVE REQUEST */
			$getMilestones = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $orderId, 'milestone_type' => 'service', 'status' => 3]);

			$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $orderId]);

			if(!empty($getMilestones)){

				$this->db->select_sum('total_amount');
				$this->db->where(['post_id' => $orderId, 'milestone_type' => 'service', 'status' => 3, 'service_status' => 'cancel']);
				$query = $this->db->get('tbl_milestones');
				$result = $query->row();
				$totalAmountOfActiveMilestone = $result->total_amount ?? 0; 				

				/* CANCELLED MILESTONE PRICE UPDATE IN SERVICE ORDERS */				
				$input['total_price'] = (($serviceOrder['price'] + $serviceOrder['service_fee']) - $totalAmountOfActiveMilestone);
				$input['status_update_time'] = date('Y-m-d H:i:s');
				$run = $this->common_model->update('service_order', array('id' => $orderId), $input);

				foreach ($getMilestones as $key => $value) {
					
					$in['status'] = 4;
					$in['service_status'] = 'cancelled';
					$in['sender_id'] = 0;
					$in['receiver_id'] = 0;
					$in['process_by'] = $this->session->userdata('user_id');
					$in['status_update_time'] = date('Y-m-d H:i:s');
					$this->common_model->update('tbl_milestones', array('id' => $value['id']), $in);


					/* ADD TRANSACTION HISTORY FOR CANCELLED MILSTONE */
					$transactionid = md5(rand(1000,999).time());
				    $tr_message='£'.$value['total_amount'].' has been credited to your wallet for '.$value['milestone_name'].' milestone on date '.date('d-m-Y h:i:s A').'.';
				   	$data1 = array(
						'tr_userid'=>$serviceOrder['user_id'], 
						'tr_amount'=>$value['total_amount'],
						'tr_type'=>1,
						'tr_transactionId'=>$transactionid,
						'tr_message'=>$tr_message,
						'tr_status'=>1,
						'tr_created'=>date('Y-m-d H:i:s'),
						'tr_update' =>date('Y-m-d H:i:s')
					);
					$run1 = $this->common_model->insert('transactions',$data1);

				}

				$getAllMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $orderId, 'milestone_type' => 'service']);
				
				$getAllCancelledMilestonesCount = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $orderId, 'milestone_type' => 'service', 'status' => 4]);

						
			
				/* CHECK IF ORDER ALL MILSTONE CANCELLED THEN ORDER WILL BE CANCELLED */
				if(count($getAllMilestonesCount) == count($getAllCancelledMilestonesCount)){

					$serviceOrder = $this->common_model->GetSingleData('service_order', ['id' => $orderId]);
					$service = $this->common_model->GetSingleData('my_services', ['id' => $serviceOrder['service_id']]);
					$homeOwner = $this->common_model->GetSingleData('users', ['id' => $serviceOrder['user_id']]);
					$tradesman = $this->common_model->GetSingleData('users', ['id' => $service['user_id']]);

					$hId = $this->session->userdata('user_id');
					if ($hId == $homeOwner['id']) {
						$senderId = $hId;
						$receiverId = $tradesman['id'];
					}
					if ($hId == $tradesman['id']) {
						$senderId = $hId;
						$receiverId = $homeOwner['id'];
					}

					$input['status'] = 'cancelled';
					$input['is_cancel'] = 1;
					$input['reason'] = '';
					$input['status_update_time'] = date('Y-m-d H:i:s');

					$run = $this->common_model->update('service_order', array('id' => $orderId), $input);
					if ($run) {

						$pageUrl = site_url() . 'order-tracking/' . $serviceOrder['id'];

						if ($hId == $homeOwner['id']) {
							$nMessage = 'Your order was cancelled. <a href="' . $pageUrl . '" >View Now!</a>';
						}

						if ($hId == $tradesman['id']) {
							$nMessage = 'Your order was cancelled. <a href="' . $pageUrl . '" >View Now!</a>';
						}

						/*Manage Order History*/
						$insert1 = [
							'user_id' => $senderId,
							'is_cancel' => 1,
							'service_id' => $serviceOrder['service_id'],
							'order_id' => $orderId,
							'status' => 'cancelled'
						];
						$this->common_model->insert('service_order_status_history', $insert1);


						$insert2['sender'] = $senderId;
						$insert2['receiver'] = $receiverId;
						$insert2['order_id'] = $orderId;
						$insert2['status'] = 'cancelled';
						$insert2['is_cancel'] = 1;
						$insert2['description'] = '';
						$run = $this->common_model->insert('order_submit_conversation', $insert2);


						$insertn['nt_userId'] = $receiverId;
						$insertn['nt_message'] = $nMessage;
						$insertn['nt_satus'] = 0;
						$insertn['nt_create'] = date('Y-m-d H:i:s');
						$insertn['nt_update'] = date('Y-m-d H:i:s');
						$insertn['job_id'] = $orderId;
						$insertn['posted_by'] = $senderId;
						$run2 = $this->common_model->insert('notification', $insertn);			


					} else {
						echo json_encode(['status' => 'error', 'message' => 'Something is wrong. Order is not cancelled.']);
					}

				}

				echo json_encode(['status' => '1', 'message' => 'Milestone cancelled successfully.']);
				exit;
			}

			echo json_encode(['status' => '0', 'message' => 'Somthing went wrong.']);
			exit;
		}	
	}

	public function rejectCancellationMilestone(){
		
		if($_POST){
		
			$orderId = $_POST['order_id'];

			$getMilestones = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $orderId, 'milestone_type' => 'service', 'status' => 3]);

			if(!empty($getMilestones)){
				foreach ($getMilestones as $key => $value) {
					
					$in['status'] = 0;
					$in['service_status'] = 'active';
					$in['sender_id'] = 0;
					$in['receiver_id'] = 0;
					$in['process_by'] = $this->session->userdata('user_id');
					$in['status_update_time'] = date('Y-m-d H:i:s');
					$this->common_model->update('tbl_milestones', array('id' => $value['id']), $in);

				}

				echo json_encode(['status' => '1', 'message' => 'Milestone rejected successfully.']);
				exit;
			}
			echo json_encode(['status' => '0', 'message' => 'Somthing went wrong.']);
			exit;
		}	
	}

	public function withdrawCancellationMilestone(){
		
		if($_POST){
		
			$orderId = $_POST['order_id'];

			$getMilestones = $this->common_model->get_all_data('tbl_milestones', ['post_id' => $orderId, 'milestone_type' => 'service', 'status' => 3]);

			if(!empty($getMilestones)){
				foreach ($getMilestones as $key => $value) {
					
					$in['status'] = 9;
					$in['service_status'] = 'withdraw';
					$in['sender_id'] = 0;
					$in['receiver_id'] = 0;
					$in['process_by'] = $this->session->userdata('user_id');
					$in['status_update_time'] = date('Y-m-d H:i:s');
					$this->common_model->update('tbl_milestones', array('id' => $value['id']), $in);

				}

				echo json_encode(['status' => '1', 'message' => 'Cancel request withdraw successfully.']);
				exit;
			}
			echo json_encode(['status' => '0', 'message' => 'Somthing went wrong.']);
			exit;
		}	
	}
}
