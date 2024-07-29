<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Direct_hire extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
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

	function reject_direct_hired()
	{
		$reject_reason = $this->input->post('reject_reason');
		$job_id = $this->input->post('job_id');
		$bid_id = $this->input->post('bid_id');

		$this->common_model->update_data('tbl_jobs', array('job_id' => $job_id), array('status' => 8));
		$this->common_model->update_data('tbl_jobpost_bids', array('id' => $bid_id), array('status' => 8, 'reject_reason' => $reject_reason));

		$job_data = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

		$homeOwner = $this->common_model->get_single_data('users', array('id' => $job_data['userid']));

		$traders = $this->common_model->get_single_data('users', array('id' => $job_data['awarded_to']));

		$insertn['nt_userId'] = $homeOwner['id'];

		$insertn['nt_message'] = $traders['trading_name'] . ' rejected your offer! <a href="' . site_url() . 'proposals?post_id=' . $job_id . '&reject_reason=' . $bid_id . '&type=direct_hire"> View reason </a>';

		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['job_id'] = $job_id;
		$insertn['posted_by'] = $traders['id'];
		$this->common_model->insert('notification', $insertn);


		$subject = "Unfortunately! " . $traders['trading_name'] . " has declined your direct job offer!";

		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] . ',</p>';

		$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! ' . $traders['trading_name'] . ' has declined your direct job offer!</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Reason: ' . $reject_reason . '</p>';

		$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can edit and re-award the job or offer the job to another tradesperson.</p>';

		$html .= '<br><div style="text-align:center"><a href="' . site_url() . 'proposals/?post_id=' . $job_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Edit & Award</a></div>';


		$html .= '<br><p style="margin:0;padding:10px 0px">Visit our homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

		$this->common_model->send_mail($homeOwner['email'], $subject, $html);


		$this->session->set_flashdata('success1', '<div class="alert alert-success">Job offer has been rejected successfully</div>');

		redirect('proposals?post_id=' . $job_id);
	}
	function edit_budget()
	{
		$budget = $this->input->post('budget');
		$job_id = $this->input->post('job_id');
		$bid_id = $this->input->post('bid_id');
		$delivery_days = $this->input->post('delivery_days');

		$this->common_model->update_data('tbl_jobs', array('job_id' => $job_id), array('budget' => $budget));
		$this->common_model->update_data('tbl_jobpost_bids', array('id' => $bid_id), array('bid_amount' => $budget, 'delivery_days' => $delivery_days));

		$job_data = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

		$homeOwner = $this->common_model->get_single_data('users', array('id' => $job_data['userid']));

		$traders = $this->common_model->get_single_data('users', array('id' => $job_data['awarded_to']));

		$insertn['nt_userId'] = $homeOwner['id'];

		$insertn['nt_message'] = 'You have update the budget of the job <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">' . $job_data['project_id'] . '</a>';

		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['job_id'] = $job_id;
		$insertn['posted_by'] = $traders['id'];
		$this->common_model->insert('notification', $insertn);


		$insertn1['nt_userId'] = $traders['id'];
		$insertn1['nt_message'] = '<a href="' . site_url() . 'profile/' . $homeOwner['id'] . '">' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . '</a> has update the budget of the job <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">' . $job_data['project_id'] . '</a>. Please <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">Accept</a> and request milestone creation.';
		$insertn1['nt_satus'] = 0;
		$insertn1['nt_apstatus'] = 2;
		$insertn1['nt_create'] = date('Y-m-d H:i:s');
		$insertn1['nt_update'] = date('Y-m-d H:i:s');
		$insertn1['job_id'] = $job_id;
		$insertn1['posted_by'] = $homeOwner['id'];
		$this->common_model->insert('notification', $insertn1);

		$subject = $homeOwner['f_name'] . " " . $homeOwner['l_name'] . " has update the budget of the job " . $job_data['project_id'] . "";

		$content = 'Hello ' . $traders['f_name'] . ' ' . $traders['l_name'] . ', <br><br>';

		$content .= '<p class="text-center"><a href="' . site_url() . 'profile/' . $homeOwner['id'] . '">' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . '</a> has update budget of the job <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">' . $job_data['project_id'] . '</a>. Please <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">accept</a> and request milestone creation.</p>';
		$this->common_model->send_mail($traders['email'], $subject, $content);


		$this->session->set_flashdata('success1', '<div class="alert alert-success">Job budget has been updated successfully</div>');

		redirect('proposals?post_id=' . $job_id);
	}
	function reopen_trademens()
	{

		$get_commision = $this->common_model->get_commision();
		$closed_date = $get_commision[0]['closed_date'];
		$c_date = date('Y-m-d H:i:s');

		$job_end_date = date('Y-m-d H:i:s', strtotime($c_date . ' + ' . $closed_date . ' days'));

		$budget = $this->input->post('budget');
		$job_id = $this->input->post('job_id');
		$bid_id = $this->input->post('bid_id');
		$delivery_days = $this->input->post('delivery_days');

		$this->common_model->update_data('tbl_jobs', array('job_id' => $job_id), array('budget' => $budget, 'status' => 4));
		$this->common_model->update_data('tbl_jobpost_bids', array('id' => $bid_id), array('bid_amount' => $budget, 'delivery_days' => $delivery_days, 'status' => 3));

		$job_data = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

		$homeOwner = $this->common_model->get_single_data('users', array('id' => $job_data['userid']));

		$traders = $this->common_model->get_single_data('users', array('id' => $job_data['awarded_to']));

		$insertn['nt_userId'] = $homeOwner['id'];

		$insertn['nt_message'] = 'You have re-offer the job <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">' . $job_data['project_id'] . '</a>';

		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['job_id'] = $job_id;
		$insertn['posted_by'] = $traders['id'];
		$this->common_model->insert('notification', $insertn);


		$insertn1['nt_userId'] = $traders['id'];

		$insertn1['nt_message'] = $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . ' worked on your feedback & re-offered you the job! <a href="' . site_url() . 'proposals/?post_id=' . $job_id . '">Please respond now!</a>';
		$insertn1['nt_satus'] = 0;
		$insertn1['nt_apstatus'] = 2;
		$insertn1['nt_create'] = date('Y-m-d H:i:s');
		$insertn1['nt_update'] = date('Y-m-d H:i:s');
		$insertn1['job_id'] = $job_id;
		$insertn1['posted_by'] = $homeOwner['id'];
		$this->common_model->insert('notification', $insertn1);

		$subject = "Direct job re-offered and awaits your respond!";

		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $traders['f_name'] . ' ' . $traders['l_name'] . ',</p>';

		$html .= '<p style="margin:0;padding:10px 0px">' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . '  has worked on your feedback and re-offered you the job.</p>';
		$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can respond to the offer by clicking below buttons.</p>';

		$html .= '<br><div style="text-align:center"><a href="' . site_url() . 'proposals/?post_id=' . $job_id . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Respond now!</a></div>';

		$html .= '<br><p style="margin:0;padding:10px 0px">If you have any question regarding the offer, don\'t hesitate to contact ' . $homeOwner['f_name'] . ' through the chat section of the job page.</p>';
		$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

		$this->common_model->send_mail($traders['email'], $subject, $html);

		$this->session->set_flashdata('success1', '<div class="alert alert-success">Job budget has been re-opened successfully</div>');

		redirect('proposals?post_id=' . $job_id);
	}

	public function direct_hire()
	{
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_rules('hire_to', 'hire_to', 'required');
		// $this->form_validation->set_rules('main_cate', 'main category', 'required');
		// $this->form_validation->set_rules('budget', 'budget', 'required');
		// $this->form_validation->set_rules('delivery_days', 'delivery day', 'required');

		if ($this->form_validation->run()) {

			$get_commision = $this->common_model->get_commision();
			$closed_date = $get_commision[0]['closed_date'];
			$c_date = date('Y-m-d H:i:s');

			$job_end_date = date('Y-m-d H:i:s', strtotime($c_date . ' + ' . $closed_date . ' days'));

			$message = $this->input->post('message');
			$hire_to = $this->input->post('hire_to');
			$main_cate = $this->input->post('main_cate');
			$budget = $this->input->post('budget');
			$delivery_days = $this->input->post('delivery_days');
			$user_id = $this->session->userdata('user_id');

			$homeOwner = $this->common_model->get_single_data('users', array('id' => $user_id));

			$traders = $this->common_model->get_single_data('users', array('id' => $hire_to));

			if ($traders['u_email_verify'] == 1) {
				$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' . time();
				$project_id = substr(str_shuffle($str_result), 0, 12);

				//$insert['title'] = 'Job: '.$project_id;
				$insert['title'] = $project_id;
				$insert['description'] = $message;
				$insert['budget'] = $budget;
				$insert['userid'] = $user_id;
				$insert['status'] = 4;
				$insert['category'] = $main_cate;
				$insert['c_date'] = date('Y-m-d H:i:s');
				$insert['awarded_time'] = date('Y-m-d H:i:s');
				$insert['subcategory'] = $main_cate;
				$insert['post_code'] = $homeOwner['postal_code'];
				$insert['job_end_date'] = $job_end_date;

				$check_postcode = $this->common_model->check_postalcode($homeOwner['postal_code']);

				$insert['longitude'] = $check_postcode['longitude'];
				$insert['latitude'] = $check_postcode['latitude'];
				$insert['city'] = $check_postcode['primary_care_trust'];
				$insert['address'] = $check_postcode['address'];
				$insert['country']  = $check_postcode['country'];
				$insert['project_id'] = $project_id;
				$insert['awarded_to'] = $hire_to;
				$insert['direct_hired'] = 1;

				$run = $this->common_model->insert('tbl_jobs', $insert);

				if ($run) {
					$insert2['bid_amount'] = !empty($budget) ? $budget : 0.00;
					$insert2['delivery_days'] = $delivery_days;
					$insert2['propose_description'] = $homeOwner['f_name'] . ' has direct hire to ' . $traders['f_name'] . ' ' . $traders['l_name'] . ' for this job.';
					$insert2['bid_by'] = $hire_to;
					$insert2['job_id'] = $run;
					$insert2['cdate'] = date('Y-m-d H:i:s');
					$insert2['posted_by'] = $user_id;
					$insert2['status'] = 3;
					$insert2['awarded_date'] = date('Y-m-d H:i:s');
					$insert2['hiring_type'] = 1;
					$insert2['paid_total_miles'] = 0;

					$run2 = $this->common_model->insert('tbl_jobpost_bids', $insert2);

					$insertn = [];
					$insertn['nt_userId'] = $user_id;

					// $insertn['nt_message']='Your request for direct hire to <a href="'.site_url().'profile/'.$traders['id'].'">'.$traders['f_name'].' '.$traders['l_name'].'</a> has been sent for the job <a href="'.site_url().'proposals/?post_id='.$run.'">'.$project_id.'</a>';
					$insertn['nt_message'] = 'Your direct job offer was sent to ' . $traders['trading_name'] . ' and <a href="' . site_url() . 'proposals/?post_id=' . $run . '">awaits their acceptance!</a>';

					$insertn['nt_satus'] = 0;
					$insertn['nt_create'] = date('Y-m-d H:i:s');
					$insertn['nt_update'] = date('Y-m-d H:i:s');
					$insertn['job_id'] = $run;
					$this->common_model->insert('notification', $insertn);					

					$notArr['title'] = 'Direct job offer';
					$notArr['message'] = 'Congratulations! ' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . ' has offered you their job';
					$notArr['link'] = site_url() . 'proposals/?post_id=' . $run;
					$notArr['user_id'] = $hire_to;
					$notArr['behalf_of'] = $user_id;
					$this->common_model->AndroidNotification($notArr);

					$OneSignalNoti = [];
					$OneSignalNoti['title'] = 'Direct job offer';
					$OneSignalNoti['message'] = 'Congratulations! ' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . ' has offered you their job';
					$OneSignalNoti['is_customer'] = false;
					$OneSignalNoti['user_id'] = $hire_to;
					/*$OneSignalNoti['pushdata']['message_type'] = 'direct_hire';
					$OneSignalNoti['pushdata']['link'] = site_url() . 'proposals/?post_id=' . $run; //in push data array you can send any data
					$OneSignalNoti['pushdata']['customer_id'] = $user_id;
					$OneSignalNoti['pushdata']['job_id'] = $run; 
					$OneSignalNoti['pushdata']['tradesmen_id'] = $hire_to; */

					$OneSignalNoti['pushdata']['action'] = 'Request';
					$OneSignalNoti['pushdata']['other_user_id'] = $hire_to;
					$OneSignalNoti['pushdata']['user_id'] = $user_id;
					$OneSignalNoti['pushdata']['action_id'] = $run; 

					//print_r($OneSignalNoti);
					$return = $this->common_model->OneSignalNotification($OneSignalNoti);
					//print_r($return);

					$insertn1 = [];
					$insertn1['nt_userId'] = $hire_to;
					$insertn1['nt_message'] = 'Congratulations! ' . $homeOwner['f_name'] . ' ' . $homeOwner['l_name'] . ' has offered you their job. <a href="' . site_url() . 'proposals/?post_id=' . $run . '">View & respond.</a>';
					$insertn1['nt_satus'] = 0;
					$insertn1['nt_apstatus'] = 2;
					$insertn1['nt_create'] = date('Y-m-d H:i:s');
					$insertn1['nt_update'] = date('Y-m-d H:i:s');
					$insertn1['job_id'] = $run;
					$insertn1['posted_by'] = $user_id;
					$insertn1['action']=$OneSignalNoti['pushdata']['action'];
					$insertn1['action_id']=$OneSignalNoti['pushdata']['action_id'];
					$insertn1['action_json']=json_encode($OneSignalNoti['pushdata']);
					$this->common_model->insert('notification', $insertn1);

					$subject = "You're hired: Congratulations for your New Job offer.";
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">You\'re directly hired!</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $traders['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! ' . $homeOwner['f_name'] . ' has directly hired you for their new job. These are the next steps to get your work started:</p>';

					$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Accept the offer</p>';

					$html .= '<p style="width:60%;float: left;">Happy with the offer</p>';
					$html .= '<p style="width:40%;float: left;"><a href="' . site_url() . 'proposals/?post_id=' . $run . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Accept Now</a></p>';

					$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Communicate</p>';

					$html .= '<p style="width:60%;float: left;">If you have any question</p>';
					$html .= '<p style="width:40%;float: left;"><a href="' . site_url() . 'proposals/?post_id=' . $run . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Chat Now</a></p>';

					$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Milestone payment</p>';

					$html .= '<p style="width:60%;float: left;">If no milestone were made </p>';
					$html .= '<p style="width:40%;float: left;"><a href="' . site_url() . 'payments/?post_id=' . $run . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:15px;border-radius:3px;font-size:17px;text-decoration:none">Request Now</a></p>';

					$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->common_model->send_mail($traders['email'], $subject, $html);


					$subject = "Thanks for your direct job offer to " . $traders['trading_name'];

					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $homeOwner['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Thank you for your direct job offer to ' . $traders['trading_name'] . '.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">As your next step, you can wait for ' . $traders['trading_name'] . ' to respond to the offer.</p>';


					$html .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->common_model->send_mail($homeOwner['email'], $subject, $html);

					$json['status'] = 1;
					$this->session->set_flashdata('msg', '<p class="alert alert-success">Direct hiring request has been sent successfully.</p>');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
			} else {

				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">' . $traders['trading_name'] . ' email is not verified, so you can\'t hire to ' . $traders['trading_name'] . '.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}
		echo json_encode($json);
	}
}
