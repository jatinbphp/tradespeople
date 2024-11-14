<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dispute extends CI_Controller
{
	public $load;
	public $session;
	public $form_validation;
	public $input;
	public $Common_model;
	public $db;
	public function __construct()
	{
		Parent::__construct();
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		//$this->email->initialize($config);
		$this->load->library('form_validation');
		//date_default_timezone_set('UTC');
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

	public function reject_bank_transer()
	{
		$this->form_validation->set_rules('reject_reason', 'Reject reason', 'trim|required');

		if ($this->form_validation->run()) {

			$id = $this->input->post('id');
			$reject_reason = $this->input->post('reject_reason');

			$data = $this->Common_model->getRows('bank_transfer', $id);

			if ($data) {

				$user_id = $data['userId'];

				$update = $this->Common_model->update('bank_transfer', array('id' => $id), array('status' => 2, 'reject_reason' => $reject_reason));

				if ($update) {


					$nt_message = 'Bank transfer request declined. <a href="' . site_url('wallet?reject_reason=' . $id . '&type=bank_transfer') . '" >View reason</a>';

				//	$this->Common_model->insert_notification($user_id, $nt_message);
					
					$action_title = 'Bank Transfer';
					$action = 'bank_transfer';
					
					$this->Common_model->insert_notification_json($user_id, $nt_message, $action_title, $action, $id);

					$user = $this->Common_model->get_userDataByid($user_id);

					$subject = "Unable to fund Your Tradespeople Hub account.";

					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Declined reason: ' . $reject_reason . '</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Bank Transfer</p>';

					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->Common_model->send_mail($user['email'], $subject, $html, null, null, 'support');

					$json['status'] = 1;

					$this->session->set_flashdata('msg', '<div class="alert alert-success">Request has been reject successfully.</div>');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($json);
	}

	public function approve_bank_transer()
	{
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');

		if ($this->form_validation->run()) {

			$id = $this->input->post('id');
			$amount = $this->input->post('amount');

			$data = $this->Common_model->getRows('bank_transfer', $id);

			if ($data) {

				$user_id = $data['userId'];

				$update = $this->Common_model->update('bank_transfer', array('id' => $id), array('status' => 1, 'user_amount' => $amount));

				if ($update) {
					$txnID = time() . rand();

					$insert['tr_userid'] = $user_id;
					$insert['tr_message'] = '<i class="fa fa-gbp"></i>' . $amount . ' has deposited in your wallet by Bank Transfer.</b>';
					$insert['tr_amount'] = $amount;
					$insert['tr_type'] = 1;
					$insert['tr_transactionId'] = $txnID;
					$insert['tr_status'] = 1;
					$insert['tr_paid_by'] = 'Bank Transfer';
					$insert['is_deposit'] = 1;

					$run2 = $this->Common_model->insert('transactions', $insert);


					$user = $this->Common_model->get_userDataByid($user_id);
					$amount1 = $user['u_wallet'] + $amount;
					$u_data['u_wallet'] = $amount1;
					$this->Common_model->update('users', array('id' => $user_id), $u_data);


					//$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' were successfully credited to your wallet, TransactionId: <b>'.$txnID.'</b>';

					$store = '2'; //0
					$store .= '&Bank transfer'; //1
					$store .= '&' . $amount; //2
					$store .= '&' . $user_id; //3
					$store .= '&' . date('Y-m-d'); //4
					$store .= '&' . $txnID; //5
					$store .= '&<i class="fa fa-gbp"></i>' . $amount . ' was credited to your account.'; //6

					$inv = $this->Common_model->insert('invoice', array('data' => $store));

					$nt_message = '<i class="fa fa-gbp"></i>' . $amount . ' was credited to your account. <a target="_blank" href="' . site_url() . 'view-invoice/' . $inv . '">View invoice!</a>';

				//	$this->Common_model->insert_notification($user_id, $nt_message);
					
					$action_title = 'Bank Transfer';
					$action = 'bank_transfer';
					
					$this->Common_model->insert_notification_json($user_id, $nt_message, $action_title, $action, $id);

					$subject = "Your TradespeopleHub account funded successfully.";

					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . ',</p>';

					if ($user['type'] == 1) {

						$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now quote jobs using those funds.</p>';
					} else {
						$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now create milestones and pay your tradesperson on our platform using those funds.</p>';
					}


					$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £' . $amount . '</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Bank transfer</p>';
					if ($user['type'] == 1) {
						$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					} else {
						$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					}

					//$user['email'] = 'anil.webwiders@gmail.com';

					$runs1 = $this->Common_model->send_mail($user['email'], $subject, $html, null, null, 'support');

					$json['status'] = 1;

					$this->session->set_flashdata('msg', '<div class="alert alert-success">Request has been accpeted successfully.</div>');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
			}
		} else {
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">' . validation_errors() . '</div>';
		}

		echo json_encode($json);
	}

	public function banner_transfer_request()
	{
		$page['bank_transfer_history'] = $this->Common_model->get_all_data('bank_transfer', null, 'id');

		$this->load->view('Admin/banner_transfer_request', $page);
	}
	public function dispute()
	{
		$page['dispute_user'] = $this->Common_model->get_all_data('tbl_dispute', '', 'ds_id');
		// print_r($page['dispute_user']);

		$this->load->view('Admin/dispute_job', $page);
	}
	public function ask_to_step_in()
	{
		$dispute_user = $this->Common_model->GetColumnName('tbl_dispute', "ds_status = 0 and (select count(id) from ask_admin_to_step where ask_admin_to_step.dispute_id = tbl_dispute.ds_id) >= 2", ['tbl_dispute.*'], true, 'tbl_dispute.ds_id', 'desc');
		$page['dispute_user'] = $dispute_user;
		$page['page_title'] = 'Ask Stap In';
		// print_r($page['dispute_user']);

		$this->load->view('Admin/dispute_job', $page);
	}

	public function dispute_details($dispute_ids)
	{
		//echo $dispute_id;
		$dispute = $this->Common_model->get_single_data('tbl_dispute', array('ds_id' => $dispute_ids));

		$job_id = $dispute['ds_job_id'];
		$page['dispute'] = $dispute;
		$page['setting'] = $this->Common_model->GetColumnName('admin', array('id' => 1));
		$milestones = $this->Common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '" . $dispute_ids . "'", "tbl_milestones.*", true);
		$page['milestones'] = $milestones;

		$page['owner'] = $owner = $this->Common_model->get_single_data('users', array('id' => $dispute['ds_puser_id']));
		$page['tradmen'] = $tradmen = $this->Common_model->get_single_data('users', array('id' => $dispute['ds_buser_id']));

		$home_stepin = false;
		$trades_stepin = false;
		if ($owner) {
			$home_stepin = $this->Common_model->get_single_data('ask_admin_to_step', array('user_id' => $owner['id'], 'dispute_id' => $dispute['ds_id']));
		}
		if ($tradmen) {
			$trades_stepin = $this->Common_model->get_single_data('ask_admin_to_step', array('user_id' => $tradmen['id'], 'dispute_id' => $dispute['ds_id']));
		}

		$page['home_stepin'] = $home_stepin;
		$page['trades_stepin'] = $trades_stepin;

		$page['disput_comment'] = $this->Common_model->get_all_data('disput_conversation_tbl', array('dct_disputid' => $dispute['ds_id'],'dct_userid >='=>'0'), 'dct_id', 'ASC');
		$page['disput_comment_arbitration'] = $this->Common_model->get_all_data('disput_conversation_tbl', array('dct_disputid' => $dispute['ds_id'],'dct_userid <'=>'0'), 'dct_id', 'ASC');
		$page['dispute_events'] = $this->Common_model->CustomQuery('dispute_events', "inner join users on users.id = dispute_events.user_id where dispute_events.dispute_id = $dispute_ids order by dispute_events.id desc", "dispute_events.*,users.f_name,users.l_name,users.trading_name,users.type as user_type", true);

		$page['files'] = $this->Common_model->get_all_data('dispute_file',"dispute_id = '".$dispute['ds_id']."' and conversation_id is null", 'id', 'DESC');

		$this->load->view('Admin/dispute_details', $page);
	}

	public function makedisputefinal()
	{

		$job_id = $this->input->post('job_id');
		$tradesman = $this->input->post('tradesman_id');
		$homeowner = $this->input->post('homeowner_id');
		$dispute_ids = $this->input->post('ds_id');
		$dispute_finel_user = $this->input->post('ds_favour');

		$massage = $this->input->post('massage');

		$milestones = $this->Common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '" . $dispute_ids . "'", "tbl_milestones.*", true);
		$dispute = $this->Common_model->get_single_data('tbl_dispute', array('ds_id' => $dispute_ids));
		$order = $this->Common_model->get_single_data('service_order', array('id' => $dispute['ds_job_id']));

		//print_r($dispute); die();

		$diputeType = $dispute['dispute_type'];

		$insert['dct_disputid'] = $dispute_ids;
		$insert['dct_userid'] = 0;
		$insert['dct_msg'] = $massage;
		$insert['dct_isfinal'] = 1;

		$run = $this->Common_model->insert('disput_conversation_tbl', $insert);

		if ($run) {
			foreach ($milestones as $milestone) {
				$bid_update = [];
				$bid_update['status'] = 6;
				$where = "id = '" . $milestone['id'] . "'";
				$this->Common_model->update('tbl_milestones', $where, $bid_update);
			}

			$disput_update['ds_status'] = 1;
			$disput_update['ds_favour'] = $dispute_finel_user;

			$home = $this->Common_model->get_userDataByid($homeowner);
			$trades = $this->Common_model->get_userDataByid($tradesman);
			$favo = $this->Common_model->get_userDataByid($dispute_finel_user);


			/*if ($dispute['last_offer_by'] == $tradesman && $dispute['tradesmen_offer']) {
				$amount = $dispute['tradesmen_offer'];
			} else if ($dispute['last_offer_by'] == $homeowner && $dispute['homeowner_offer']) {
				$amount = $dispute['homeowner_offer'];
			} else {
				$amount = $dispute['total_amount'];
			}*/
			$amount = $dispute['total_amount'];

			$disput_update['agreed_amount'] = $amount;
			$disput_update['caseCloseStatus'] = 4;

			$run1 = $this->Common_model->update('tbl_dispute', array('ds_id' => $dispute_ids), $disput_update);

			if ($trades['id'] == $dispute_finel_user) {

				$get_commision = $this->Common_model->get_single_data('admin', array('id' => 1));

				$commision = $get_commision['commision'];

				if($diputeType == 1){
					$get_post_job = $this->Common_model->get_single_data('tbl_jobpost_bids', array('id' => $milestones[0]['bid_id']));

					$get_job_post = $this->Common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

					$pamnt = $get_post_job['paid_total_miles'];
					$final_amount = $pamnt + $amount;

					$main_amount = $get_post_job['bid_amount'];

					$sql3 = "update tbl_jobpost_bids set paid_total_miles = '" . $final_amount . "' where id = '" . $milestone['bid_id'] . "'";
					$this->db->query($sql3);	
				}else{
					$get_post_job = $this->Common_model->get_single_data('service_order', array('id' => $dispute['ds_job_id']));
					$main_amount = $get_post_job['price'];

					$pamnt = $get_post_job['price'];
					$final_amount = $pamnt + $amount;
				}

				$total = ($amount * $commision) / 100;
				$amounts = $amount - $total;

				$u_wallet = $trades['u_wallet'];
				
				$withdrawable_balance = $trades['withdrawable_balance'];
				$update1['withdrawable_balance'] = $withdrawable_balance + $amounts;

				foreach ($milestones as $milestone) {

					$this->Common_model->update('tbl_milestones', array('id' => $milestone['id']), array('is_dispute_to_traders' => 1, 'admin_commission' => $commision));
				}

				if ($final_amount >= $main_amount) {

					if($diputeType == 1){
						$runss12 = $this->Common_model->update_data('tbl_jobs', array('job_id' => $job_id), array('status' => 5));
						$runss123 = $this->Common_model->update_data('tbl_jobpost_bids', array('id' => $get_post_job['id']), array('status' => 4));

						$post_title = $get_job_post['title'];
						$subject = "Congratulations on Completing the Job: “" . $post_title . "”";
						$post_id = $get_post_job['posted_by'];
						$pageType = 'job';
						$pageUrl = 'reviews/?post_id=' . $get_post_job['job_id'];
						$ntMsg = 'Congratulations! Your job has been completed. <a href="'.site_url().$pageUrl.'">Rate '.$trades['trading_name'].'!</a>';
					}else{
						$post_title = $get_job_post['order_id'];
						$subject = "Congratulations on Completing the order: “" . $post_title . "”";
						$post_id = $get_post_job['user_id'];
						$pageUrl = 'order_tracking/' . $get_post_job['job_id'];
						$pageType = 'order';
						$ntMsg = 'Congratulations! Your order has been completed. <a href="'.site_url().$pageUrl.'">Rate '.$trades['trading_name'].'!</a>';
					}

					/*$insertn['nt_userId']=$get_post_job['bid_by'];
						$insertn['nt_message']='Congratulations for your recent job completion! Please rate <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">Max Tommy.</a>';
						
						$insertn['nt_message']='Congratulation this project has been completed successfully.<a href="'.site_url().'profile/'.$home['id'].'">'.$home['f_name'].' '.$home['l_name'].'</a> has released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed.Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
						$insertn['nt_satus']=0;
						$insertn['nt_apstatus']=2;
						$insertn['nt_create']=date('Y-m-d H:i:s');
						$insertn['nt_update']=date('Y-m-d H:i:s');   
						$insertn['job_id']=$get_post_job['job_id'];
						$insertn['posted_by']=$get_post_job['posted_by'];
						$run2 = $this->Common_model->insert('notification',$insertn);*/					

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! '.ucfirst($pageType).' completed and Milestone payment released.</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the '.$pageType.' “' . $post_title . '”! Your milestone payments has now been released and can be withdrawn. </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for ' . $home['f_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';

					$html .= '<div style="text-align:center"><a href="'.site_url().$pageUrl.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';

					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$runs1 = $this->Common_model->send_mail($trades['email'], $subject, $html, null, null, 'support');


					$subject = "Congratulations on ".ucfirst($pageType)." Completion: “" . $post_title . "”";

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your '.$pageType.' completed and Milestone payments released.</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $home['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your '.ucfirst($pageType).' “' . $post_title . '”! completed successfully and milestone payments released to ' . $trades['trading_name'] . '.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to ' . $trades['trading_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';

					$html .= '<div style="text-align:center"><a href="'.site_url().$pageUrl.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';

					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

					$runs1 = $this->Common_model->send_mail($home['email'], $subject, $html, null, null, 'support');


					$insertn1['nt_userId'] = $trades['id'];
					// $insertn1['nt_message']='Congratulation this project has been completed successfully.You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
					$insertn1['nt_message'] = $ntMsg;

					$insertn1['nt_satus'] = 0;
					$insertn1['nt_apstatus'] = 2;
					$insertn1['nt_create'] = date('Y-m-d H:i:s');
					$insertn1['nt_update'] = date('Y-m-d H:i:s');
					$insertn1['job_id'] = $get_post_job['job_id'];
					$insertn1['posted_by'] = 0;
					$this->Common_model->insert('notification', $insertn1);

					$insertn2['nt_userId'] = $home['id'];
					$insertn2['nt_message'] = $ntMsg;

					$insertn2['nt_satus'] = 0;
					$insertn2['nt_apstatus'] = 2;
					$insertn2['nt_create'] = date('Y-m-d H:i:s');
					$insertn2['nt_update'] = date('Y-m-d H:i:s');
					$insertn2['job_id'] = $get_post_job['job_id'];
					$insertn2['posted_by'] = 0;
					$this->Common_model->insert('notification', $insertn2);
				}
			} else {
				$amounts = $amount;
				$u_wallet = $home['u_wallet'];
				$update1['u_wallet'] = $u_wallet + $amounts;				
			}

			if($diputeType == 1){
				$post_title = $get_job_post['title'];
				$subject = "Congratulations on Completing the Job: “" . $post_title . "”";
				$post_id = $get_post_job['posted_by'];
				$pageType = 'job';
				$pageUrl = 'reviews/?post_id=' . $get_post_job['job_id'];
				$disputeUrl = 'dispute/'.$dispute_ids;
			}else{
				$post_title = $get_job_post['order_id'];
				$subject = "Congratulations on Completing the order: “" . $post_title . "”";
				$post_id = $get_post_job['user_id'];
				$pageUrl = 'order_tracking/' . $get_post_job['job_id'];
				$pageType = 'order';
				$disputeUrl = 'order-dispute/'.$dispute_ids;
			}


			$transactionid = md5(rand(1000, 999) . time());
			$tr_message = '£' . $amounts . ' credited to your wallet as <a href="'.site_url($disputeUrl).'">Case ID: ' . $dispute['caseid'] . '</a> dispute was decided in your favour.';
			$data1 = array(
				'tr_userid' => $dispute_finel_user,
				'tr_amount' => $amounts,
				'tr_type' => 1,
				'tr_transactionId' => $transactionid,
				'tr_message' => $tr_message,
				'tr_status' => 1,
				'tr_created' => date('Y-m-d H:i:s'),
				'tr_update' => date('Y-m-d H:i:s')
			);
			$this->Common_model->insert('transactions', $data1);

			$checkStepIn = $this->Common_model->GetColumnName('ask_admin_to_step', array('user_id' => $dispute_finel_user,'dispute_id'=>$dispute_ids), array('amount'));
			if($checkStepIn){
				$data1 = array(
					'tr_userid' => $dispute_finel_user,
					'tr_amount' => $checkStepIn['amount'],
					'tr_type' => 1,
					'tr_transactionId' => md5(rand(1000, 999) . time()),
					'tr_message' => '£' . $checkStepIn['amount'] . ' arbitration fee has been credited to your wallet for winning the dispute.',
					'tr_status' => 1,
					'tr_created' => date('Y-m-d H:i:s'),
					'tr_update' => date('Y-m-d H:i:s')
				);
				$this->Common_model->insert('transactions', $data1);
				$update1['u_wallet']=$update1['u_wallet']+$checkStepIn['amount'];
				if(isset($update1['withdrawable_balance'])){
					$update1['withdrawable_balance']=$update1['withdrawable_balance']+$checkStepIn['amount'];
				}				
			}

			$this->Common_model->update_data('users', array('id' => $dispute_finel_user), $update1);

			$job = $this->Common_model->GetColumnName('tbl_jobs', array('job_id' => $job_id), array('title'));

			$insertn4['nt_userId'] = $home['id'];
			$insertn4['nt_message'] = 'Milestone payment dispute decided. <a href="' . site_url($disputeUrl) . '">View outcome!</a>';

			$insertn4['nt_satus'] = 0;
			$insertn4['nt_apstatus'] = 0;
			$insertn4['nt_create'] = date('Y-m-d H:i:s');
			$insertn4['nt_update'] = date('Y-m-d H:i:s');
			$insertn4['job_id'] = $job_id;
			$insertn4['posted_by'] = 0;
			$this->Common_model->insert('notification', $insertn4);

			$insertn5['nt_userId'] = $trades['id'];
			$insertn5['nt_message'] = 'Milestone payment dispute decided. <a href="' . site_url($disputeUrl) . '">View outcome!</a>';

			$insertn5['nt_satus'] = 0;
			$insertn5['nt_apstatus'] = 0;
			$insertn5['nt_create'] = date('Y-m-d H:i:s');
			$insertn5['nt_update'] = date('Y-m-d H:i:s');
			$insertn5['job_id'] = $job_id;
			$insertn5['posted_by'] = 0;
			$this->Common_model->insert('notification', $insertn5);

			$subject = "We've decided on the Milestone Payment Dispute & Closed the case: “" . $get_job_post['title'] . "”";

			$traing_name = ($favo['type'] == 1) ? $favo['trading_name'] : $favo['f_name'] . ' ' . $favo['f_name'];

			$html = '<br><p style="margin:0;padding:10px 0px">Hi, ' . $home['f_name'] . '</p>';
			$html .= '<br><p style="margin:0;padding:10px 0px">We\'ve completed our review on the milestone dispute and decided in favour of the ' . $traing_name . '. We have therefore returned the Milestone payment to them and close the case.</p>';

			$html .= '<p style="margin:0;padding:10px 0px">Returned amount: £' . $amount . '</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and closed case can\'t be reopened.</p>';

			$html .= '<br><div style="text-align:center"><a href="' . site_url($disputeUrl) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View reason</a></div><br>';

			$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->Common_model->send_mail($home['email'], $subject, $html, null, null, 'support');

			$html = '<br><p style="margin:0;padding:10px 0px">Hi, ' . $trades['f_name'] . '</p>';
			$html .= '<br><p style="margin:0;padding:10px 0px">We\'ve completed our review on the milestone dispute and decided in favour of the ' . $favo['f_name'] . ' ' . $favo['l_name'] . '. We have therefore returned the Milestone payment to them and close the case.</p>';

			$html .= '<p style="margin:0;padding:10px 0px">Returned  amount: £' . $amount . '</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and closed case can\'t be reopened.</p>';

			$html .= '<br><div style="text-align:center"><a href="' . site_url($disputeUrl) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div><br>';

			$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->Common_model->send_mail($trades['email'], $subject, $html, null, null, 'support');


			$this->session->set_flashdata('msg', '<div class="alert alert-success">Dispute has been resolved successfully.</div>');

			if($diputeType == 2){
				$od['is_cancel'] = 6;
				$od['status'] = 'completed';
				$od['reason'] = '';
				$od['status_update_time'] = date('Y-m-d H:i:s');
				$run = $this->Common_model->update('service_order',array('id'=>$order['id']),$od);

				/*Manage Order History*/
			  $insert1 = [
		      'user_id' => $order['user_id'],
		      'is_cancel' => 6,
		      'service_id' => $order['service_id'],
		      'order_id' => $order['id'],
		      'status' => 'completed'
		    ];
		    $this->Common_model->insert('service_order_status_history', $insert1);

		    $insert2['sender'] = 0;
				$insert2['receiver'] = 0;
				$insert2['order_id'] = $order['id'];
				$insert2['status'] = 'completed';
				$insert2['is_cancel'] = 6;
				$insert2['description'] = 'Your order dispute has been closed by admin';
				$run = $this->Common_model->insert('order_submit_conversation', $insert2);				
			}

			//$this->release_milestone($job_id,$dispute_finel_user);
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something went wrong, try again later</div>');
		}

		redirect('dispute_details/' . $dispute_ids);
	}

	function add_dispute_comment()
	{

		$job_id = $this->input->post('job_id');
		$buser = $this->input->post('tradesman_id');
		$puser = $this->input->post('homeowner_id');
		$ds = $this->input->post('dispute_id');
		$dct_msg = $this->input->post('massage');

		$message_to = $this->input->post('message_to');

		$current = date('Y-m-d H:i:s');
		$admin = $this->Common_model->get_single_data('admin', ['id' => 1]);
		$end_time = date('Y-m-d H:i:s', strtotime($current . ' + ' . $admin['waiting_time'] . ' days'));

		$insert['dct_disputid'] =  $ds;
		$insert['dct_userid'] = 0;
		$insert['dct_msg'] = $dct_msg;
		$insert['dct_isfinal'] = 0;
		$insert['message_to'] = $message_to;
		$insert['is_reply_pending'] = 1;
		$insert['dct_update'] = date('Y-m-d H:i:s');
		$insert['end_time'] = $end_time;

		$run = $this->Common_model->insert('disput_conversation_tbl', $insert);
		if ($run) {

			$traduser = $this->Common_model->GetColumnName('users', array('id' => $message_to), array('email', 'f_name', 'l_name', 'type'));

			if ($message_to == $buser) {
				$favor = $this->Common_model->GetColumnName('users', array('id' => $puser), array('f_name', 'trading_name'));
			} else {
				$favor = $this->Common_model->GetColumnName('users', array('id' => $buser), array('f_name', 'trading_name'));
			}

			$jobTitle = $this->Common_model->GetColumnName('tbl_jobs', array('job_id' => $job_id), array('title'));

			$this->Common_model->update_data('disput_conversation_tbl', array('dct_disputid' => $ds, 'dct_id != ' => $run), array('is_reply_pending' => 0));

			if ($traduser['type'] == 1) {

				$subject = "Action required: Provide Additional information: Milestone Payment Dispute: " . $jobTitle['title'];

				$contant = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Additional information needed!</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">Hi ' . $traduser['f_name'] . ',</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">We are contacting you because we need additional information that supports your claim. Please log in to your account to take the next action to provide the required information.</p>';

				$contant .= '<div style="text-align:center"><a href="' . site_url('dispute/' . $ds) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View the message and respond</a></div>';

				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A', strtotime($end_time)) . ' will result in closing this case and deciding in the ' . $favor['f_name'] . ' favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t reopen.</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->Common_model->send_mail($traduser['email'], $subject, $contant, null, null, 'support');
			} else {

				$subject = "Action required: Milestone Payment Dispute: Provide Additional information " . $jobTitle['title'];

				$contant = '<p style="margin:0;padding:10px 0px">Additional information needed!</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">Hi ' . $traduser['f_name'] . ',</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">We are contacting you because we need additional information that supports your claim. Please log in to your account to take the next action to provide the required information.</p>';

				$contant .= '<div style="text-align:center"><a href="' . site_url('dispute/' . $ds) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View the message and respond</a></div>';

				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A', strtotime($end_time)) . ' will result in closing this case and deciding in the favour of ' . $favor['trading_name'] . '.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t reopen.</p>';

				$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->Common_model->send_mail($traduser['email'], $subject, $contant, null, null, 'support');
			}
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
		} else {

			$this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
		}
		redirect('dispute_details/' . $ds);
	}

	function release_milestone($jobId, $userId)
	{
		$release_milestone = $this->Common_model->get_all_data('tbl_milestones', array('post_id' => $jobId, 'status' => 0));
		/* print_r($release_milestone);*/
		if ($release_milestone) {
			foreach ($release_milestone as $miles) {
				$user = $this->Common_model->get_userDataByid($userId);
				$u_update['u_wallet'] = $user['u_wallet'] + $miles['milestone_amount'];
				$update_result = $this->Common_model->update('users', array('id' => $user['id']), $u_update);
				if ($update_result) {
					$tr_update['tr_userid'] = $user['id'];
					$tr_update['tr_message'] = '<i class="fa fa-gbp"></i>' . $miles['milestone_amount'] . ' has been credited in your wallet for ' . $miles['milestone_name'] . ' milestone.';
					$tr_update['tr_amount'] = '<i class="fa fa-gbp"></i>' . $miles['milestone_amount'];
					$tr_update['tr_type'] = 1;
					$tr_update['tr_transactionId'] = md5(rand(1000, 999) . time());
					$tr_update['tr_status'] = 1;
					$tr_update['tr_created'] = date('Y-m-d H:i:s');
					$tr_update['tr_update'] = date('Y-m-d H:i:s');
					$run = $this->Common_model->insert('transactions', $tr_update);
					//$miles_update['status']=2;
					//$update_result=$this->Common_model->update('tbl_milestones',array('id'=>$miles['id']),$miles_update);
				}
			}
		}
	}

	public function cancel_dispute($id = null, $post_id = null)
	{

		die('coming soon');


		$user_id = $this->session->userdata('session_adminId');

		$data = $this->Common_model->GetColumnName('tbl_dispute', array('ds_id' => $id), array('ds_id', 'ds_job_id', 'ds_buser_id', 'ds_puser_id'));

		if ($id && $post_id && $data) {

			$user_id = $this->session->userdata('session_adminId');

			$run = $this->Common_model->delete(array('ds_id' => $id), 'tbl_dispute');

			if ($run) {
				$this->Common_model->delete(array('dct_disputid' => $id), 'disput_conversation_tbl');
				$this->Common_model->delete(array('dispute_id' => $id), 'dispute_milestones');


				$this->Common_model->update_data('tbl_milestones', array('dispute_id' => $id), array('status' => 0, 'dispute_id' => NULL));
				$job = $this->Common_model->GetColumnName('tbl_jobs', array('job_id' => $post_id), array('title'));


				if ($user_id == $data['ds_buser_id']) {

					$disput_user = $this->Common_model->GetColumnName('users', array('id' => $data['ds_buser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));

					$other_user = $this->Common_model->GetColumnName('users', array('id' => $data['ds_puser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));
				} else {

					$disput_user = $this->Common_model->GetColumnName('users', array('id' => $data['ds_puser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));

					$other_user = $this->Common_model->GetColumnName('users', array('id' => $data['ds_buser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));
				}

				$insertn1['nt_userId'] = $other_user['id'];
				$insertn1['nt_message'] = $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled <a href="' . site_url('payments/?post_id=' . $post_id) . '">the milestone payment dispute.</a>';
				$insertn1['nt_satus'] = 0;
				$insertn1['nt_apstatus'] = 0;
				$insertn1['nt_create'] = date('Y-m-d H:i:s');
				$insertn1['nt_update'] = date('Y-m-d H:i:s');
				$insertn1['job_id'] = $post_id;
				$insertn1['posted_by'] = 0;
				$run2 = $this->Common_model->insert('notification', $insertn1);

				$milestones = $this->Common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '" . $id . "'", "tbl_milestones.*", true);

				if ($disput_user['type'] == 1) { //cancelled by tradesmen


					$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"';
					$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['trading_name'] . ' has cancelled the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p>';

					$contant .= '<div style="text-align:center"><a href="' . site_url('payments/?post_id=' . $post_id) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';

					$contant .= '<p style="margin:0;padding:10px 0px">View our homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->Common_model->send_mail($other_user['email'], $subject, $contant);


					/*$subject = 'Your milestone payment dispute has been cancelled: "' .$job['title'] .'"'; 
					$contant = 'Hi '.$disput_user['f_name'] .',<br><br>';
					$contant .= 'Your milestone payment dispute against '.$other_user['f_name'].' has been cancelled successfully.<br><br>';
					$contant .= 'Milestone name: ' .$milestone['milestone_name'] .'<br>';
					$contant .= 'Milestone Dispute Amount: ' .$milestone['milestone_amount'] .' <br><br>';
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div><br>';
					$contant .= 'Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.<br><br>';
					
					$this->common_model->send_mail($disput_user['email'],$subject,$contant);*/
				} else { //cancelled by home owner

					$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"';
					$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to ask them to release the milestone if they have not yet done that.</p>';

					$contant .= '<div style="text-align:center"><a href="' . site_url('payments/?post_id=' . $post_id) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';

					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->Common_model->send_mail($other_user['email'], $subject, $contant);


					$subject = 'Your milestone payment dispute has been cancelled: "' . $job['title'] . '"';
					$contant = 'Hi ' . $disput_user['f_name'] . ',<br><br>';
					$contant .= 'Your milestone payment dispute against ' . $other_user['trading_name'] . ' has been cancelled successfully.<br><br>';

					foreach ($milestones as $milestone) {
						$contant .= 'Milestone name: ' . $milestone['milestone_name'] . '<br>';
						$contant .= 'Milestone Dispute Amount: ' . $milestone['milestone_amount'] . ' <br><br>';
					}


					$contant .= '<div style="text-align:center"><a href="' . site_url('payments/?post_id=' . $post_id) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div><br>';
					$contant .= 'Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.<br><br>';

					$this->Common_model->send_mail($disput_user['email'], $subject, $contant);
				}

				$this->session->set_flashdata('message', '<div class="alert alert-success">Dispute has been cancelled successfully.</div>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Something went wrong, try again later.</div>');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Something went wrong, try again later.</div>');
		}

		redirect('dispute');
	}
}
