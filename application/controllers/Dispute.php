<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dispute extends CI_Controller
{
	public $common_model;
	public function __construct()
	{
		Parent::__construct();
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
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
	public function cancel_dispute($id = null, $post_id = null)
	{

		$user_id = $this->session->userdata('user_id');

		$data = $this->common_model->GetColumnName('tbl_dispute', array('ds_id' => $id, 'disputed_by' => $user_id), array('ds_id', 'ds_job_id', 'ds_buser_id', 'ds_puser_id','total_amount'));

		if ($id && $post_id && $data) {

			$user_id = $this->session->userdata('user_id');

			$run = $this->common_model->update_data('tbl_dispute',array('ds_id' => $id), ['ds_status'=>1,'caseCloseStatus'=>2]);
			//$run = $this->common_model->delete(array('ds_id' => $id), 'tbl_dispute');

			$milestones = $this->common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '".$id."'","tbl_milestones.*",true);

			if ($run) {
				//$this->common_model->delete(array('dct_disputid' => $id), 'disput_conversation_tbl');
				//$this->common_model->delete(array('dispute_id' => $id), 'dispute_milestones');

				$this->common_model->update_data('tbl_milestones', array('dispute_id' => $id), array('status' => 0,'dispute_id'=>NULL));

				$job = $this->common_model->GetColumnName('tbl_jobs', array('job_id' => $post_id), array('title'));


				if ($user_id == $data['ds_buser_id']) {

					$disput_user = $this->common_model->GetColumnName('users', array('id' => $data['ds_buser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));

					$other_user = $this->common_model->GetColumnName('users', array('id' => $data['ds_puser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name'));
				} else {

					$disput_user = $this->common_model->GetColumnName('users', array('id' => $data['ds_puser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name','u_wallet','withdrawable_balance'));

					$other_user = $this->common_model->GetColumnName('users', array('id' => $data['ds_buser_id']), array('email', 'f_name', 'l_name', 'type', 'id', 'trading_name','u_wallet','withdrawable_balance'));
				}


				$checkStepIn = $this->common_model->GetColumnName('ask_admin_to_step', array('user_id' => $disput_user['id'],'dispute_id'=>$id), array('amount'));
				if($checkStepIn){
					$data1 = array(
						'tr_userid' => $disput_user['id'],
						'tr_amount' => $checkStepIn['amount'],
						'tr_type' => 1,
						'tr_transactionId' => md5(rand(1000, 999) . time()),
						'tr_message' => '£' . $checkStepIn['amount'] . ' arbitration fee has been credited to your wallet as dispute has been cancelled and closed.',
						'tr_status' => 1,
						'tr_created' => date('Y-m-d H:i:s'),
						'tr_update' => date('Y-m-d H:i:s')
					);
					$this->common_model->insert('transactions', $data1);
					$update1 = [];
					$update1['u_wallet']=$disput_user['u_wallet']+$checkStepIn['amount'];
					if($disput_user['type'] == 1){
						$update1['withdrawable_balance']=$disput_user['withdrawable_balance']+$checkStepIn['amount'];
					}
					$this->common_model->update_data('users', array('id' => $disput_user['id']), $update1);
					
				}

				$checkStepIn = $this->common_model->GetColumnName('ask_admin_to_step', array('user_id' => $other_user['id'],'dispute_id'=>$id), array('amount'));
				if($checkStepIn){
					$data1 = array(
						'tr_userid' => $other_user['id'],
						'tr_amount' => $checkStepIn['amount'],
						'tr_type' => 1,
						'tr_transactionId' => md5(rand(1000, 999) . time()),
						'tr_message' => '£' . $checkStepIn['amount'] . ' arbitration fee has been credited to your wallet as dispute was cancelled and closed.',
						'tr_status' => 1,
						'tr_created' => date('Y-m-d H:i:s'),
						'tr_update' => date('Y-m-d H:i:s')
					);
					$this->common_model->insert('transactions', $data1);
					$update1 = [];
					$update1['u_wallet']=$other_user['u_wallet']+$checkStepIn['amount'];
					if($other_user['type'] == 1){
						$update1['withdrawable_balance']=$other_user['withdrawable_balance']+$checkStepIn['amount'];
					}
					$this->common_model->update_data('users', array('id' => $other_user['id']), $update1);
					
				}

				$insertn1['nt_userId'] = $other_user['id'];
				$insertn1['nt_message'] = $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled the milestone payment dispute. <a href="'.site_url().'dispute/'.$data['ds_id'].'">View Now</a>';
				$insertn1['nt_satus'] = 0;
				$insertn1['nt_apstatus'] = 0;
				$insertn1['nt_create'] = date('Y-m-d H:i:s');
				$insertn1['nt_update'] = date('Y-m-d H:i:s');
				$insertn1['job_id'] = $post_id;
				$insertn1['posted_by'] = 0;
				$run2 = $this->common_model->insert('notification', $insertn1);

				$insertn1 = [];
				$insertn1['nt_userId'] = $disput_user['id'];
				$insertn1['nt_message'] = 'You have cancelled and close the milestone payment dispute successfully.  <a href="'.site_url().'dispute/'.$data['ds_id'].'">View Now</a>';
				$insertn1['nt_satus'] = 0;
				$insertn1['nt_apstatus'] = 0;
				$insertn1['nt_create'] = date('Y-m-d H:i:s');
				$insertn1['nt_update'] = date('Y-m-d H:i:s');
				$insertn1['job_id'] = $post_id;
				$insertn1['posted_by'] = 0;
				$run2 = $this->common_model->insert('notification', $insertn1);

				if ($disput_user['type'] == 1) { //cancelled by tradesmen


					$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"';
					$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['trading_name'] . ' has cancelled the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p>';

					$contant .= '<div style="text-align:center"><a href="' . site_url('dispute/' . $data['ds_id']) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';

					$contant .= '<p style="margin:0;padding:10px 0px">View our homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant);


					$subject = 'Milestone Payment Dispute was cancelled:"' . $job['title'] . '"'; 
					$contant = '<p style="margin:0;padding:10px 0px">Hi '.$disput_user['f_name'] .',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">You have cancelled and closed the milestone payment dispute claim for the job ' . $job['title'] . '.</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to request milestone release if you have not yet done that..</p> <br>';
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div>';
					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$this->common_model->send_mail($disput_user['email'],$subject,$contant);
				} else { //cancelled by home owner

					$subject = 'Milestone Payment Dispute was cancelled and closed: "' . $job['title'] . '"';
					$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . ',</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">' . $disput_user['f_name'] . ' ' . $disput_user['l_name'] . ' has cancelled and closed the milestone payment dispute claim for the job "' . $job['title'] . '"</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to ask them to release the milestone if they have not yet done that.</p>';

					$contant .= '<div style="text-align:center"><a href="' . site_url('payments/?post_id=' . $post_id) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Request milestone release</a></div>';

					$contant .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant);


					$subject = 'Milestone Payment Dispute was  cancelled and closed:"' . $job['title'] . '"'; 
					$contant = 'Hi '.$disput_user['f_name'] .',<br><br>';
					$contant .= '<p style="margin:0;padding:10px 0px">You have cancelled and closed the milestone payment dispute claim for the job ' . $job['title'] . '.</p><br><br>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $data['total_amount'] . '</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">All you have to do is to release the milestone if you have not yet done that.</p> <br><br>';
					$contant .= '<div style="text-align:center"><a href="'.site_url('payments/?post_id='.$post_id).'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Release milestone</a></div>';
					$contant .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$this->common_model->send_mail($disput_user['email'],$subject,$contant);


				}

				$this->session->set_userdata('message', '<div class="alert alert-success">The case has been cancelled and closed successfully.</div>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Something went wrong, try again later.</div>');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Something went wrong, try again later.</div>');
		}

		redirect('payments/?post_id=' . $post_id);
	}

	public function accept_and_close($id = null, $post_id = null)
	{
		//echo '<pre>';
		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('type');

		$row = $this->common_model->get_single_data('tbl_dispute', array('ds_id' => $id));

		if (!$row) {
			$this->session->set_flashdata('error1', 'Something went wrong.');
			return redirect('payments?post_id=' . $post_id);
		}

		if ($row['ds_buser_id'] != $user_id && $row['ds_puser_id'] != $user_id) {
			$this->session->set_flashdata('error1', 'You are not authorized to add offer for this dispute.');
			return redirect('payments?post_id=' . $post_id);
		}

		
		$dipute_by = $row['disputed_by'];
		$dipute_to = $row['dispute_to'];
		$job_id = $row['ds_job_id'];

		

		$tradesman = $row['ds_buser_id'];
		$homeowner = $row['ds_puser_id'];

		$dispute_ids = $row['ds_id'];



		$home = $this->common_model->get_userDataByid($homeowner);
		$trades = $this->common_model->get_userDataByid($tradesman);
		$milestones = $this->common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '".$id."'","tbl_milestones.*",true);


		if ($user_id == $tradesman) {
			$accname = $trades['trading_name'];
			$dispute_finel_user = $home['id'];
		} else {
			$accname = $home['f_name'];
			$dispute_finel_user = $trades['id'];
		}

		$favo = $this->common_model->get_userDataByid($dispute_finel_user);

		$massage = 'Dispute resolved as  ' . $accname . ' accept and close.';
		$insert['dct_disputid'] = $dispute_ids;
		$insert['dct_userid'] = 0;
		$insert['dct_msg'] = $massage;
		$insert['dct_isfinal'] = 1;

		$run = $this->common_model->insert('disput_conversation_tbl', $insert);
		//$run =true;
		if ($run) {

			foreach($milestones as $milestone){
				$bid_update = [];
				$bid_update['status'] = 6;
				$where = "id = '" . $milestone['id'] . "'";
	
				$this->common_model->update('tbl_milestones', $where, $bid_update);
			}

			

			$disput_update['ds_status'] = 1;
			$disput_update['ds_favour'] = $dispute_finel_user;


			$get_job_post = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

			if ($user_id == $trades['id']) {
				$amount = $row['homeowner_offer']*1;
			} else if ($user_id == $home['id']) {
				$amount = $row['tradesmen_offer']*1;
			} else {
				$amount = $row['total_amount'];
			}

			//echo $amount;
			

			$disput_update['agreed_amount'] = ($amount > 0) ? $amount : $row['total_amount'];
			$disput_update['caseCloseStatus'] = 5;
			/*echo '<pre>';
			print_r($disput_update);
			print_r($row);
			die();*/

			$this->common_model->update('tbl_dispute', array('ds_id' => $dispute_ids), $disput_update);


			//if ($trades['id'] == $dispute_finel_user && $amount > 0) {
			if ($amount > 0) {
				$setting = $this->common_model->get_coloum_value('admin', array('id' => 1), array('waiting_time', 'commision'));

				$commision = $setting['commision'];

				$get_post_job = $this->common_model->get_single_data('tbl_jobpost_bids', array('id' => $milestones[0]['bid_id']));



				$pamnt = $get_post_job['paid_total_miles'];
				$final_amount = $pamnt + $amount;

				$sql3 = "update tbl_jobpost_bids set paid_total_miles = '" . $final_amount . "' where id = '" . $milestones[0]['bid_id'] . "'";
				$this->db->query($sql3);


				$total = ($amount * $commision) / 100;

				$amounts = $amount - $total;

				$u_wallet = $trades['u_wallet'];
				$withdrawable_balance = $trades['withdrawable_balance'];

				//$update1['u_wallet']=$u_wallet+$amounts;
				$update1['withdrawable_balance'] = $withdrawable_balance + $amounts;

				$this->common_model->update_data('users', array('id' => $trades['id']), $update1);
				$transactionid = md5(rand() . time());
				$data1 = array(
					'tr_userid' => $trades['id'],
					'tr_amount' => $amounts,
					'tr_type' => 1,
					'tr_transactionId' => $transactionid,
					'tr_message' => $massage,
					'tr_status' => 1,
					'tr_created' => date('Y-m-d H:i:s'),
					'tr_update' => date('Y-m-d H:i:s')
				);
				$this->common_model->insert('transactions', $data1);

				foreach($milestones as $milestone){
					$this->common_model->update('tbl_milestones', array('id' => $milestone['id']), array('is_dispute_to_traders' => 1, 'admin_commission' => $commision));
				}

				
				if ($row['total_amount'] > $amount) {
					$remainingAmount = $row['total_amount'] - $amount;
					$update3['u_wallet'] = $home['u_wallet'] + $remainingAmount;
					$this->common_model->update_data('users', array('id' => $home['id']), $update3);

					$transactionid = md5(rand(1000, 999) . time());
					$data1 = array(
						'tr_userid' => $home['id'],
						'tr_amount' => $remainingAmount,
						'tr_type' => 1,
						'tr_transactionId' => $transactionid,
						'tr_message' => 'Dispute resolved as  ' . $accname . ' accept and close and the remaining amount credited in your wallet.',
						'tr_status' => 1,
						'tr_created' => date('Y-m-d H:i:s'),
						'tr_update' => date('Y-m-d H:i:s')
					);
					$this->common_model->insert('transactions', $data1);
				}
				
				$total_milestone =  $this->common_model->get_total_milestone($job_id);
                $completed_milestone =  $this->common_model->get_completed_milestone($job_id);
				if($total_milestone==$completed_milestone){
					$runss12 = $this->common_model->update_data('tbl_jobs', array('job_id' => $job_id), array('status' => 5));

					$runss123 = $this->common_model->update_data('tbl_jobpost_bids', array('id' => $get_post_job['id']), array('status' => 4));
				}

				if ($final_amount >= $get_post_job['bid_amount']) {

					

					$post_title = $get_job_post['title'];

					$insertn['nt_userId'] = $get_post_job['bid_by'];

					$insertn['nt_message'] = 'Congratulation this project has been completed successfully.<a href="' . site_url() . 'profile/' . $home['id'] . '">' . $home['f_name'] . ' ' . $home['l_name'] . '</a> has released all the milestone amount of <a href="' . site_url() . 'payments/?post_id=' . $get_post_job['job_id'] . '"> ' . $post_title . '</a> project and this project has been completed.Now you can go for rating by <a href="' . site_url() . 'reviews/?post_id=' . $get_post_job['job_id'] . '">clicking here</a>.';

					$insertn['nt_satus'] = 0;
					$insertn['nt_apstatus'] = 2;
					$insertn['nt_create'] = date('Y-m-d H:i:s');
					$insertn['nt_update'] = date('Y-m-d H:i:s');
					$insertn['job_id'] = $get_post_job['job_id'];
					$insertn['posted_by'] = $get_post_job['posted_by'];
					$run2 = $this->common_model->insert('notification', $insertn);


					/*mail to homeOwner*/
					$subject = "Congratulations on Job Completion: “" . $post_title . "”";

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Your Job completed and Milestone payments released.</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $home['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Congratulations! Your Job “' . $post_title . '”! completed successfully and milestone payments released to ' . $trades['trading_name'] . '.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback to ' . $trades['trading_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';

					$html .= '<div style="text-align:center"><a href="' . site_url() . 'reviews/?post_id=' . $get_post_job['job_id'] . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Leave feedback</a></div>';

					$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

					$runs1 = $this->common_model->send_mail($home['email'], $subject, $html);
					/*mail to homeOwner*/

					$subject = 'Congratulations on Completing the Job:' . $post_title;

					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Congratulations! Job completed and Milestone payment released.</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] . ',</p>';

					$html .= '<p style="margin:0;padding:10px 0px">Congratulations for completing the job “' . $post_title . '”! Your milestone payments has now been released and can be withdrawn. </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Please leave feedback for ' . $home['f_name'] . ' to help other Tradespeoplehub members know what it was like to work with them.</p>';

					$html .= '<div style="text-align:center"><a href="' . site_url() . 'reviews/?post_id=' . $get_post_job['job_id'] . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Leave feedback</a></div>';

					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$runs1 = $this->common_model->send_mail($trades['email'], $subject, $html);


					$insertn1['nt_userId'] = $get_post_job['posted_by'];
					// $insertn1['nt_message']='Congratulation this project has been completed successfully.You have released all the milestone amount of <a href="'.site_url().'payments/?post_id='.$get_post_job['job_id'].'"> '.$post_title.'</a> project and this project has been completed. Now you can go for rating by <a href="'.site_url().'reviews/?post_id='.$get_post_job['job_id'].'">clicking here</a>.';
					$insertn1['nt_message'] = 'Congratulations! Your job has been completed. <a href="' . site_url() . 'reviews/?post_id=' . $get_post_job['job_id'] . '">Rate ' . $trades['trading_name'] . '!</a>';

					$insertn1['nt_satus'] = 0;
					$insertn1['nt_apstatus'] = 2;
					$insertn1['nt_create'] = date('Y-m-d H:i:s');
					$insertn1['nt_update'] = date('Y-m-d H:i:s');
					$insertn1['job_id'] = $get_post_job['job_id'];
					$insertn1['posted_by'] = $get_post_job['bid_by'];
					$this->common_model->insert('notification', $insertn1);

					$insertn2['nt_userId'] = $get_post_job['bid_by'];
					$insertn2['nt_message'] = 'Congratulation this project has been completed successfully. Homeowner has released all the milestone amount of <a href="' . site_url() . 'payments/?post_id=' . $get_post_job['job_id'] . '"> ' . $post_title . '</a> project and this project has been completed. Now you can go for rating by <a href="' . site_url() . 'reviews/?post_id=' . $get_post_job['job_id'] . '">clicking here</a>.';

					$insertn2['nt_satus'] = 0;
					$insertn2['nt_apstatus'] = 2;
					$insertn2['nt_create'] = date('Y-m-d H:i:s');
					$insertn2['nt_update'] = date('Y-m-d H:i:s');
					$insertn2['job_id'] = $get_post_job['job_id'];
					$insertn2['posted_by'] = $get_post_job['posted_by'];
					$this->common_model->insert('notification', $insertn2);
				}
			} else {

				$amounts = $row['total_amount'];
				$u_wallet = $home['u_wallet'];
				$update1['u_wallet'] = $u_wallet + $amounts;
				$this->common_model->update_data('users', array('id' => $home['id']), $update1);
				$transactionid = md5(rand(1000, 999) . time());
				$data1 = array(
					'tr_userid' => $home['id'],
					'tr_amount' => $amounts,
					'tr_type' => 1,
					'tr_transactionId' => $transactionid,
					'tr_message' => $massage,
					'tr_status' => 1,
					'tr_created' => date('Y-m-d H:i:s'),
					'tr_update' => date('Y-m-d H:i:s')
				);
				$this->common_model->insert('transactions', $data1);
			}


			$subject = "Milestone payment dispute accepted and closed.";

			$contant = '<p style="margin:0;padding:10px 0px">Hi ' . $favo['f_name'] . ',</p>';

			$contant .= '<p style="margin:0;padding:10px 0px">' . $accname . ' has accepted and closed the milestone payment dispute.</p>';
			$contant .= '<p style="margin:0;padding:10px 0px">You don\'t need to do anything else - we wanted to keep you updated.</p>';

			$contant .= '<p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($favo['email'], $subject, $contant);


			//$this->release_milestone($job_id,$dispute_finel_user);

			$insert_envet = [];
			$insert_envet['dispute_id'] = $dispute_ids;
			$insert_envet['event_name'] = 'accept_and_close';
			$insert_envet['user_id'] = $user_id;
			$event_data = [
				
			];
			$insert_envet['data'] = serialize($event_data);
			if($this->session->userdata("type")==1){
				$event_message = 'Tradesman accepted the offer of amount £'.$amount;
			} else {
				$event_message = 'Homeowner accepted the offer of amount £'.$amount;
			}
			$insert_envet['message'] = $event_message;

			$this->common_model->insert('dispute_events', $insert_envet);


			if($user_type == 1){
				$insertn = [];
				$insertn['nt_userId'] = $home['id'];
				
				if ($amount > 0) {
					$insertn['nt_message'] = $trades['trading_name'].' has accepted your new offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$row['ds_id'].'">View Now</a>';
				} else {
					$insertn['nt_message'] = $trades['trading_name'].' has accepted your offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$row['ds_id'].'">View Now</a>';	
				}

				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 2;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $row['ds_job_id'];
				$insertn['posted_by'] = $row['ds_puser_id'];
				$this->common_model->insert('notification', $insertn);


				if ($amount > 0) {
					$subject = $trades['trading_name']." accepted your new offer on the milestone dispute for the ".$get_job_post['title'];
				} else {
					$subject = $trades['trading_name']." accepted your offer on the milestone dispute for the ".$get_job_post['title'];
				}

				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $home['f_name'] . '</p>';
				if ($amount > 0) {
					$contant .= '<br><p style="margin:0;padding:10px 0px">'.$trades['trading_name'].' has accepted your new offer to settle the milestone dispute.</p>';
				} else {
					$contant .= '<br><p style="margin:0;padding:10px 0px">'.$trades['trading_name'].' has accepted your offer to settle the milestone dispute</p>';
				}
				$contant .= '<br><p style="margin:0;padding:10px 0px">They have accepted to settle for payment of:  £'.$row['homeowner_offer'].'</p>';
				if ($amount > 0) {
					$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed and the funds available to '.$trades['trading_name'].'</p>';
				} else {
					$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed and the funds returned to you.</p>';
				}

				$contant .= '<br><p style="margin:0;padding:10px 0px">Visit our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($home['email'], $subject, $contant);

			} else {

				//send to trademen

				$insertn = [];
				$insertn['nt_userId'] = $trades['id'];
				
				$insertn['nt_message'] = $home['f_name'].' '.$home['l_name'].' has accepted your offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$row['ds_id'].'">View Now</a>';

				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 2;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $row['ds_job_id'];
				$insertn['posted_by'] = $row['ds_puser_id'];
				$this->common_model->insert('notification', $insertn);


				
				$subject = $home['f_name'].' '.$home['l_name']." accepted your offer on the milestone dispute for the ".$get_job_post['title'];

				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $trades['f_name'] . '</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">'.$home['f_name'].' '.$home['l_name'].' has accepted your new offer to settle the milestone dispute.</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">They have accepted to settle for payment of:  £'.$row['tradesmen_offer'].'</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">The case is now closed. The funds is now available to you.</p>';

				$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($trades['email'], $subject, $contant);

			}

		}

		$this->session->set_userdata('message', '<div class="alert alert-success">Dispute has been closed successfully.</div>');
		redirect('payments/?post_id=' . $post_id);
	}

	private function generateDisputeID(){
		$id = rand(100000,9999999);
		$check = $this->common_model->GetColumnName('tbl_dispute', array('caseid' => $id),['ds_id']);
		if($check){
			return $this->generateDisputeID();
		} else {
			return $id;
		}
	}

	function dispute_job()
	{

		if(!isset($_REQUEST['post_id']) && empty($_REQUEST['post_id'])){
			//return redirect('payments?post_id=' . $get_users['post_id']);
			return redirect('/');
			
		}

		$userid = $this->session->userdata('user_id');
		$post_id = $_REQUEST['post_id'];

		$job = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $post_id));
		$login_user = $this->common_model->get_userDataByid($userid);
		

		if(!$job){
			$this->session->set_flashdata('error1', 'Something went wrong, try again later.');
			return redirect('payments?post_id=' . $post_id);
		}

		$milestones = $this->input->post('milestones');

		if(!$milestones || empty($milestones)){
			$this->session->set_flashdata('error1', 'Something went wrong, try again later.');
			return redirect('payments?post_id=' . $post_id);
		}

		

		if($userid != $job['userid'] && $userid != $job['awarded_to']){
			$this->session->set_flashdata('error1', 'Something went wrong, try again later.');
			return redirect('payments?post_id=' . $post_id);
		}


		$dispute_to = ($userid == $job['userid']) ? $job['awarded_to'] : $job['userid'];

		$insert['ds_in_id'] =  $userid;
		$insert['ds_job_id'] = $post_id;
		$insert['ds_buser_id'] = $job['awarded_to'];
		$insert['ds_puser_id'] = $job['userid'];
		$insert['caseid'] = $this->generateDisputeID();
		$insert['ds_status'] = 0;
		$insert['disputed_by'] = $userid;
		$insert['dispute_to'] = $dispute_to;
		$insert['ds_comment'] = $this->input->post('dispute_reason');
		if ($this->session->userdata('type') == 1) {
			$insert['tradesmen_offer'] = $this->input->post('offer_amount');
		} else {
			$insert['homeowner_offer'] = $this->input->post('offer_amount');
		}

		$insert['last_offer_by'] = $userid;
		$insert['ds_create_date'] = date('Y-m-d H:i:s');
		
		//$insert['offer_expire_in'] = date('Y-m-d H:i:s', strtotime($insert['ds_create_date'] . ' + 3 days'));
		$run = $this->common_model->insert('tbl_dispute', $insert);

		if(!$run){
			$this->session->set_flashdata('error1', 'Something went wrong, try again later.');
			return redirect('payments?post_id=' . $post_id);
		}

		$setting = $this->common_model->get_coloum_value('admin', array('id' => 1), array('waiting_time'));
		$posted_users = $this->common_model->get_single_data('users', array('id' => $job['userid']));
		$bid_users = $this->common_model->get_single_data('users', array('id' => $job['awarded_to']));

		
		$today = date('Y-m-d H:i:s');

		$newTime = date('Y-m-d H:i:s', strtotime($today . ' +' . $setting['waiting_time'] . ' days'));

		if (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
			foreach ($_POST['file_name'] as $key => $file) {
				$file_name = $_POST['file_name'][$key];
				$file_original_name = $_POST['file_original_name'][$key];
				
				$insertDoc = [];
				$insertDoc['uploaded_by'] = $userid;
				$insertDoc['dispute_id'] = $run;
				$insertDoc['file'] = $file_name;
				$insertDoc['original_name'] = $file_original_name;
				$insertDoc['created_at'] = date('Y-m-d H:i:s');
				$insertDoc['updated_at'] = date('Y-m-d H:i:s');
				$this->common_model->insert('dispute_file', $insertDoc);
				
			}
		}

		$insertn = [];
		$insertn['posted_by'] = $userid;
		$insertn['nt_satus'] = 0;
		$insertn['nt_create'] = date('Y-m-d H:i:s');
		$insertn['nt_update'] = date('Y-m-d H:i:s');
		$insertn['nt_apstatus'] = 0;
		$insertn['job_id'] = $post_id;
		
		if ($userid == $job['userid']) {
			
			$insertn['nt_userId'] = $job['awarded_to'];
			$insertn['nt_message'] = '' . $login_user['f_name'] . ' ' . $login_user['l_name'] . ' has opened a milestone dispute. <a href="' . site_url('dispute/' . $run) . '">View & respond!</a>';
		} else {
			
			$insertn['nt_userId'] = $job['userid'];
			$insertn['nt_message'] = '' . $login_user['trading_name'] . ' opened a milestone dispute. <a href="' . site_url('dispute/' . $run) . '">View & respond!</a>';
		}

		$this->common_model->insert('notification', $insertn);

		
		$dispute_mile = implode(',', $milestones);
		$text = explode(',', $dispute_mile);

		$total_amount = 0;

		foreach ($text as $t) {

			$get_users = $this->common_model->GetColumnName('tbl_milestones',['id'=>$t],['milestone_amount','milestone_name']);

			if ($get_users) {

				$total_amount += $get_users['milestone_amount'];

				$insert = [];
				$insert['dispute_id'] = $run;
				$insert['milestone_id'] = $t;
				$insert['created_at'] = $today;
				$insert['updated_at'] = $today;
				$this->common_model->insert('dispute_milestones',$insert);

				if ($job['userid'] == $userid) { // open by home owner

					$by_name = $posted_users['f_name'] . ' ' . $posted_users['l_name'];

					$subject = "Action required: Milestone Payment is being Disputed, Job “" . $job['title'] . "”";
					$contant = '<p style="margin:0;padding:10px 0px">Your Milestone Payment is being Disputed and required your response!</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Hi ' . $bid_users['f_name'] . ',</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px"> ' . $by_name . ' is disputing their Milestone payment for job “' . $job['title'] . '”</p>';
					$contant .= '<p style="margin:0;padding:10px 0px">Milestone Dispute Amount: £' . $get_users['milestone_amount'] . '</p>';

					$contant .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with the ' . $by_name . '. If you can\'t solve this problem, you or  ' . $by_name . ' can ask us to step in.</p>';

					$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $run) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';

					$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date("d-M-Y H:i:s", strtotime($newTime)) . ' will result in closing this case and deciding in the client favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p>';

					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

					$this->common_model->send_mail($bid_users['email'], $subject, $contant);


					$subject = "Your milestone payment dispute has been opened: “" . $job['title'] . "”.";
					$contant = 'Hi ' . $posted_users['f_name'] . ',<br><br>';
					$contant .= 'Your milestone payment dispute against ' . $bid_users['trading_name'] . ' has been opened successfully and awaits their response.<br><br>';
					$contant .= 'Milestone name: ' . $get_users['milestone_name'] . '<br>';
					$contant .= 'Milestone Dispute Amount: £' . $get_users['milestone_amount'] . '<br><br>';
					$contant .= "We encourage to respond and resolve this issue you amicably. If you can't solve it, you or " . $bid_users['trading_name'] . " can ask us to step in.<br>";
					$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $run) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View  dispute</a></div><br>';
					$contant .= $bid_users['trading_name'] . ' not responding within ' . date("d-M-Y H:i:s", strtotime($newTime)) . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in your favour.<br><br>';
					$contant .= 'If you receive a reply from  ' . $bid_users['trading_name'] . ', please respond as soon as you can as not responding within 2 days closes the case automatically and decided in favour of ' . $bid_users['trading_name'] . '.<br><br>';
					$contant .= "Any decision reached is final and irrevocable. Once a case is close, it can't reopen.<br><br>";

					$contant .= "Visit our Milestone Payment system on the homeowner help page or contact our customer services if you have any specific questions using our service.<br>";
					$this->common_model->send_mail($posted_users['email'], $subject, $contant);
				} else {


					$by_name = $bid_users['f_name'] . ' ' . $bid_users['l_name'];


					$subject = "Action required: Your Milestone Payment is being Disputed: “" . $job['title'] . "”";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $posted_users['f_name'] . ',</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px"> ' . $bid_users['trading_name'] . ' is disputing your Milestone payment to them & need your response.</p>';

					$contant .= '<p style="margin:0;padding:0px 0px">Job title: ' . $job['title'] . '</p>';
					$contant .= '<p style="margin:0;padding:0px 0px">Milestone Dispute Amount: £' . $get_users['milestone_amount'] . '</p>';

					$contant .= '<p style="margin:0;padding:10px 0px">We encourage you to respond and resolve this issue with ' . $bid_users['trading_name'] . '. If you can\'t solve it, you or  ' . $bid_users['trading_name'] . ' can ask us to step in.</p>';

					$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $run) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View Reason and Respond</a></div><br>';

					$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date("d-M-Y H:i:s", strtotime($newTime)) . ' will result in closing this case and deciding in ' . $bid_users['trading_name'] . ' favour.  Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';

					$contant .= '<br><p style="margin:0;padding:10px 0px">Visit our Milestone Payment system on homeowner help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($posted_users['email'], $subject, $contant);



					$subject = "Your milestone payment dispute has been opened: “" . $job['title'] . "”.";
					$contant = 'Hi ' . $bid_users['f_name'] . ',<br><br>';
					$contant .= 'Your milestone payment dispute against ' . $posted_users['trading_name'] . ' has been opened successfully and awaits their response.<br><br>';
					$contant .= 'Milestone name: ' . $get_users['milestone_name'] . '<br>';
					$contant .= 'Milestone Dispute Amount: £' . $get_users['milestone_amount'] . '<br><br>';
					$contant .= "We encourage " . $posted_users['trading_name'] . " to respond and resolve this issue with you amicably. If you can't solve it, you or '" . $posted_users['trading_name'] . "' can ask us to step in.<br><br>";
					$contant .= '<div style="text-align:center"><a href="' . site_url('dispute/' . $run) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View dispute</a></div><br>';
					$contant .= 'Please note: ' . $posted_users['trading_name'] . ' not responding within ' . date("d-M-Y H:i:s", strtotime($newTime)) . ' (i.e. ' . $setting['waiting_time'] . ' days) will result in closing this case and deciding in your favour. <br><br>';
					$contant .= 'If you receive a reply from ' . $posted_users['trading_name'] . ', please respond as soon as you can as not responding within 2 days closes the case automatically and decides in favour of ' . $posted_users['trading_name'] . '. <br><br>';
					$contant .= "Any decision reached is final and irrevocable. Once a case is closed, it can't reopen.<br><br>";
					$contant .= "Visit our Milestone Payment system on the tradespeople  help page or contact our customer services if you have any specific questions using our service.<br>";

					$this->common_model->send_mail($bid_users['email'], $subject, $contant);
				}
				
				$bid_update['status'] = 5;
				$bid_update['dispute_id'] = $run;
				$this->common_model->update('tbl_milestones', ['id'=>$t], $bid_update);
				
			}
			$this->common_model->update('tbl_dispute', ['ds_id'=>$run], ['total_amount'=>$total_amount]);
		}
		$this->session->set_flashdata('success1', 'Success! Milestone Disputed successfully.');
		redirect('payments?post_id=' . $post_id);
	}

	function submit_offer()
	{

		$dispute_id = $_REQUEST['dispute_id'];
		$user_id = $_REQUEST['user_id'];
		$job_id = $_REQUEST['job_id'];
		
		$offer_amount = $_REQUEST['offer'];

		$dispute = $this->common_model->get_single_data('tbl_dispute', ['ds_id' => $dispute_id]);

		if (!$dispute) {
			$this->session->set_flashdata('error1', 'Something went wrong.');
			return redirect('payments?post_id=' . $job_id);
		}

		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('type');

		if ($dispute['ds_buser_id'] != $user_id && $dispute['ds_puser_id'] != $user_id) {
			$this->session->set_flashdata('error1', 'You are not authorized to add offer for this dispute.');
			return redirect('payments?post_id=' . $job_id);
		}

		$update = [];

		if ($user_type == 1) {
			$update['tradesmen_offer'] = $offer_amount;
			$update['offer_rejected_by_homeowner'] = 0;
		} else {
			$update['homeowner_offer'] = $offer_amount;
			$update['offer_rejected_by_tradesmen'] = 0;
		}

		$update['last_offer_by'] = $user_id;
		//$update['offer_expire_in'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 3 days'));

		//echo '<pre>'; print_r($update); die();

		$this->common_model->update('tbl_dispute', ['ds_id' => $dispute_id], $update);


		$insert_envet = [];
		$insert_envet['dispute_id'] = $dispute_id;
		$insert_envet['event_name'] = 'new_offer';
		$insert_envet['user_id'] = $user_id;
		$event_data = [
			'amount'=>$offer_amount
		];
		$insert_envet['data'] = serialize($event_data);
		if($this->session->userdata("type")==1){
			$event_message = 'Tradesman created the new offer of amount £'.$offer_amount;
		} else {
			$event_message = 'Homeowner created the new offer of amount £'.$offer_amount;
		}
		$insert_envet['message'] = $event_message;

		$run = $this->common_model->insert('dispute_events', $insert_envet);

		$userdata = $this->common_model->GetColumnName('users', ['id' => $user_id],['f_name','l_name','trading_name']);

		$job_data = $this->common_model->GetColumnName('tbl_jobs', ['job_id' => $dispute['ds_job_id']],['title']);

		if($user_type == 1){
			$insertn = [];
			$insertn['nt_userId'] = $dispute['ds_puser_id'];
			
			$insertn['nt_message'] = $userdata['trading_name'].' has made a new offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';

			$insertn['nt_satus'] = 0;
			$insertn['nt_apstatus'] = 2;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $dispute['ds_job_id'];
			$insertn['posted_by'] = $dispute['ds_puser_id'];
			$this->common_model->insert('notification', $insertn);

			$reciever = $this->common_model->GetColumnName('users', ['id' => $dispute['ds_puser_id']],['f_name','l_name','trading_name','email']);
			$subject = $userdata['trading_name']." made an offer regarding the milestone dispute for ".$job_data['title'];

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['trading_name'].' has made a new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are willing to settle for payment of:  £'.$offer_amount.'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the offer by clicking the respond button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $dispute['ds_id']) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($reciever['email'], $subject, $contant);

		} else {

			//send to trademen

			$insertn = [];
			$insertn['nt_userId'] = $dispute['ds_buser_id'];
			
			$insertn['nt_message'] = $userdata['f_name'].' '.$userdata['l_name'].' has made a new offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';

			$insertn['nt_satus'] = 0;
			$insertn['nt_apstatus'] = 2;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $dispute['ds_job_id'];
			$insertn['posted_by'] = $dispute['ds_puser_id'];
			$this->common_model->insert('notification', $insertn);

			$reciever = $this->common_model->GetColumnName('users', ['id' => $dispute['ds_buser_id']],['f_name','l_name','trading_name','email']);
			$subject = $userdata['f_name'].' '.$userdata['l_name']." made an offer regarding the milestone dispute for ".$job_data['title'];

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['f_name'].' '.$userdata['l_name'].' has made a new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are willing to settle for payment of:  £'.$offer_amount.'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can accept or reject the offer by clicking the respond button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $dispute['ds_id']) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Respond Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($reciever['email'], $subject, $contant);

		}


		$this->session->set_flashdata('msg', '<div class="alert alert-success">Your offer has been submitted successfully.</div>');
		return redirect('dispute/' . $dispute_id);
	}

	function reject_offer()
	{

		$dispute_id = $_REQUEST['dispute_id'];
		$user_id = $_REQUEST['user_id'];
		$job_id = $_REQUEST['job_id'];

		$dispute = $this->common_model->get_single_data('tbl_dispute', ['ds_id' => $dispute_id]);

		if (!$dispute) {
			$this->session->set_flashdata('error1', 'Something went wrong.');
			return redirect('payments?post_id=' . $job_id);
		}

		$user_id = $this->session->userdata('user_id');
		$user_type = $this->session->userdata('type');

		if ($dispute['ds_buser_id'] != $user_id && $dispute['ds_puser_id'] != $user_id) {
			$this->session->set_flashdata('error1', 'You are not authorized to add offer for this dispute.');
			return redirect('payments?post_id=' . $job_id);
		}

		$update = [];

		if ($user_type == 1) {
			$update['offer_rejected_by_tradesmen'] = 2;
		} else {
			$update['offer_rejected_by_homeowner'] = 2;
		}


		$this->common_model->update('tbl_dispute', ['ds_id' => $dispute_id], $update);

		$this->session->set_flashdata('msg', '<div class="alert alert-success">Your offer has been rejected successfully.</div>');


		$insert_envet = [];
		$insert_envet['dispute_id'] = $dispute_id;
		$insert_envet['event_name'] = 'new_offer';
		$insert_envet['user_id'] = $user_id;
		$event_data = [
			'amount'=>$dispute['homeowner_offer']
		];
		$insert_envet['data'] = serialize($event_data);
		if($this->session->userdata("type")==1){
			$event_message = 'Tradesman rejected Homeowner offer of amount £'.$dispute['homeowner_offer'];
		} else {
			$event_message = 'Homeowner rejected Tradesman offer of amount £'.$dispute['homeowner_offer'];
		}
		$insert_envet['message'] = $event_message;

		$this->common_model->insert('dispute_events', $insert_envet);

		$userdata = $this->common_model->GetColumnName('users', ['id' => $user_id],['f_name','l_name','trading_name']);
		
		if($user_type == 1){
			$insertn = [];
			$insertn['nt_userId'] = $dispute['ds_puser_id'];
			
			$insertn['nt_message'] = $userdata['trading_name'].' has rejected your new offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';

			$insertn['nt_satus'] = 0;
			$insertn['nt_apstatus'] = 2;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $dispute['ds_job_id'];
			$insertn['posted_by'] = $dispute['ds_puser_id'];
			$this->common_model->insert('notification', $insertn);

			$job_data = $this->common_model->GetColumnName('tbl_jobs', ['job_id' => $dispute['ds_job_id']],['title']);
			$reciever = $this->common_model->GetColumnName('users', ['id' => $dispute['ds_puser_id']],['f_name','l_name','trading_name','email']);
			$subject = $userdata['trading_name']." rejected a new offer on the milestone dispute for the ".$job_data['title'];

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['trading_name'].' has rejected your new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are not willing to settle for payment of:  £'.$dispute['homeowner_offer'].'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can adjust your offer by clicking on the adjust offer button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $dispute['ds_id']) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Adjust Offer Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($reciever['email'], $subject, $contant);

		} else {

			//send to trademen

			$insertn = [];
			$insertn['nt_userId'] = $dispute['ds_buser_id'];
			
			$insertn['nt_message'] = $userdata['f_name'].' '.$userdata['l_name'].' has rejected your new offer to settle the milestone dispute. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';

			$insertn['nt_satus'] = 0;
			$insertn['nt_apstatus'] = 2;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $dispute['ds_job_id'];
			$insertn['posted_by'] = $dispute['ds_puser_id'];
			$this->common_model->insert('notification', $insertn);


			$job_data = $this->common_model->GetColumnName('tbl_jobs', ['job_id' => $dispute['ds_job_id']],['title']);
			$reciever = $this->common_model->GetColumnName('users', ['id' => $dispute['ds_buser_id']],['f_name','l_name','trading_name','email']);
			$subject = $userdata['f_name'].' '.$userdata['l_name']." rejected an offer on the milestone dispute for the ".$job_data['title'];

			$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $reciever['f_name'] . '</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">'.$userdata['f_name'].' '.$userdata['l_name'].' has rejected your new offer to settle the milestone dispute.</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">They are not willing to settle for payment of:  £'.$dispute['tradesmen_offer'].'</p>';
			$contant .= '<br><p style="margin:0;padding:10px 0px">As your next step, you can adjust your offer by clicking on the adjust button below.</p>';

			$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $dispute['ds_id']) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Adjust Offer Now</a></div><br>';

			$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

			$this->common_model->send_mail($reciever['email'], $subject, $contant);

		}


		return redirect('dispute/' . $dispute_id);
	}

	function submitAsktoAdmin(){
		$dispute_id = $_REQUEST['id'];
		$user_id = $this->session->userdata('user_id');

		$setting = $this->common_model->GetColumnName('admin', array('id' => 1));

		$dispute = $this->common_model->get_single_data('tbl_dispute', ['ds_id' => $dispute_id]);

		if (!$dispute) {
			echo json_encode([
				'status' => 0,
				'message' => 'Something went wrong, try again later.',
			]);
			exit();
		}

		if ($dispute['ds_buser_id'] != $user_id && $dispute['ds_puser_id'] != $user_id) {
			echo json_encode([
				'status' => 0,
				'message' => 'Something went wrong, try again later.',
			]);
			exit();
		}

		$check = $this->common_model->get_single_data('ask_admin_to_step', ['dispute_id' => $dispute_id,'user_id'=>$user_id]);

		if ($check) {
			echo json_encode([
				'status' => 0,
				'message' => 'You already submitted your request to step in.',
			]);
			exit();
		}

		$setting = $this->common_model->GetColumnName('admin', array('id' => 1));
		$user_type = $this->session->userdata('type');
		$user=$this->common_model->get_single_data('users',array('id'=>$user_id));

		if($user['u_wallet'] < $setting['step_in_amount']){
			echo json_encode([
				'status' => 2,
				'wallet' => $user['u_wallet'],
			]);
			exit();
		}
		$now = date('Y-m-d H:i:s');
		$expire_time = date('Y-m-d H:i:s',strtotime($now.' +'.$setting['arbitration_fee_deadline'].' day'));

		$insert = [];
		$insert['user_id'] = $user_id;
		$insert['user_type'] = $user_type;
		$insert['dispute_id'] = $dispute_id;
		$insert['expire_time'] = $expire_time;
		$insert['amount'] = $setting['step_in_amount'];
		$insert['created_at'] = $now;
		$insert['updated_at'] = $now;
		
		$run = $this->common_model->insert('ask_admin_to_step',$insert);

		if($run){
			$update = [];
			$update['u_wallet']=$user['u_wallet']-$setting['step_in_amount'];

			$other_user_id = ($user_id == $dispute['ds_buser_id']) ? $dispute['ds_puser_id'] : $dispute['ds_buser_id'];
			$other_user=$this->common_model->get_single_data('users',array('id'=>$other_user_id));
							
			$this->common_model->update('users',array('id'=>$user_id),$update);
				
			$transactionid = md5(rand(1000,999).time());
			
			$tr_message='£'.$setting['step_in_amount'].' has been debited to your wallet for asking our arbitration team to step in.';
			
			$data112 = array(
				'tr_userid'=>$user_id, 
				'tr_amount'=>$setting['step_in_amount'],
				'tr_type'=>2,
				'tr_transactionId'=>$transactionid,
				'tr_message'=>$tr_message,
				'tr_status'=>1,
				'tr_created'=>$now,
				'tr_update' =>$now
			);
			
			$this->common_model->insert('transactions',$data112);

			$name = ($user['type']==1) ? $user['trading_name'] : $user['f_name'] . ' ' . $user['l_name'];
			$other_name = ($other_user['type']==1) ? $other_user['trading_name'] : $other_user['f_name'] . ' ' . $other_user['l_name'];

			$checkOtherPay = $this->common_model->get_single_data('ask_admin_to_step', ['dispute_id' => $dispute_id,'user_id'=>$other_user_id]);

			if($checkOtherPay){
				$dct_msg = '<p>'.$name.' has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.</p><p>Both of you have paid and asked us to step in and resolve the case.</p><p>Please note that any decision reached by our team is final and irreversable.</p>';
			} else {
				$dct_msg = '<p>'.$name.' has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.</p><p>'.$other_name.' has '.$setting['arbitration_fee_deadline'].' day(s) to pay the fee - failure to do so will result in deciding the case in the favour of '.$name.'.</p>';
			}

			$this->common_model->update_data('disput_conversation_tbl',array('dct_disputid'=>$dispute_id),array('is_reply_pending'=>0));
			
			$insert2 = [];
			$insert2['dct_disputid'] =  $dispute_id;
			$insert2['dct_userid'] = -1;
			$insert2['dct_msg'] = $dct_msg;
			$insert2['dct_isfinal'] = 0;	
			$insert2['message_to'] = (!$checkOtherPay) ? $other_user['id'] : 0;	
			$insert2['is_reply_pending'] = (!$checkOtherPay) ? 1 : 0;	
			$insert2['dct_update'] = $now;	
			$insert2['end_time'] = (!$checkOtherPay) ? $expire_time : NULL;	
			
						
			$this->common_model->insert('disput_conversation_tbl',$insert2);

			$this->session->set_flashdata('msg','<p class="alert alert-success">Your request to ask to admin is submitted successfully.</p>');

			$insert_envet = [];
			$insert_envet['dispute_id'] = $dispute_id;
			$insert_envet['event_name'] = 'ask-step-in';
			$insert_envet['user_id'] = $user_id;
			$event_data = [
				
			];
			$insert_envet['data'] = serialize($event_data);
			if($this->session->userdata("type")==1){
				$event_message = 'Tradesman has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.';
			} else {
				
				$event_message = 'Homeowner has paid £'.$setting['step_in_amount'].' to escalate the dispute to arbitration.';
			}
			$insert_envet['message'] = $event_message;

			$this->common_model->insert('dispute_events', $insert_envet);


			if($user_type == 1){
				$insertn = [];
				$insertn['nt_userId'] = $dispute['ds_puser_id'];
				
				

				if($checkOtherPay){
					$insertn['nt_message'] = 'We have received '.$user['trading_name'].' arbitration fee payment. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				} else {
					$insertn['nt_message'] = 'We have received '.$user['trading_name'].' arbitration fee and awaits yours. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';
				}

				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 2;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $dispute['ds_job_id'];
				$insertn['posted_by'] = $dispute['ds_puser_id'];
				$this->common_model->insert('notification', $insertn);


				$insertn1 = [];
				$insertn1['nt_userId'] = $dispute['ds_buser_id'];
				
				if($checkOtherPay){
					$insertn1['nt_message'] = 'You and '.$other_name.' have paid the arbitration fee and our team will now step in. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				} else {
					$insertn1['nt_message'] = 'We have received your arbitration payment and awaits for '.$other_name.' payment. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				}

				$insertn1['nt_satus'] = 0;
				$insertn1['nt_apstatus'] = 2;
				$insertn1['nt_create'] = date('Y-m-d H:i:s');
				$insertn1['nt_update'] = date('Y-m-d H:i:s');
				$insertn1['job_id'] = $dispute['ds_job_id'];
				$insertn1['posted_by'] = $dispute['ds_puser_id'];
				$this->common_model->insert('notification', $insertn1);


				$job_data = $this->common_model->GetColumnName('tbl_jobs', ['job_id' => $dispute['ds_job_id']],['title']);

				
				if($checkOtherPay){
					
					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($user['email'], $subject, $contant); //send to trademen


					$subject = "Arbitration fees payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['trading_name'].' arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant);  // send to homeowner
					
				} else {
					$subject = "Arbitration fee payment for dispute team to step-in received!";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration payment and awaits for '.$other_name.' payment. Once the other party make a payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">'.$other_name.' has until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make payment. If their payment is not received before this time, the case will automtiaclly closed and decided in your favour.</p>';

					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($user['email'], $subject, $contant); //send to trademen


					$subject = "Reminder:Arbitration payment for dispute team to step-in not received";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['trading_name'].' arbitration fee payment and awaits yours. Once you have made a payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">You have until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make a payment. If your payment is not received before this time, the case will automtiaclly close and decided in '.$user['trading_name'].' favour. </p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant);  // send to homeowner
				}

			} else {

				//send to trademen

				$insertn = [];
				$insertn['nt_userId'] = $dispute['ds_buser_id'];
				
				//$insertn['nt_message'] = 'We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee payment. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';

				if($checkOtherPay){
					$insertn['nt_message'] = 'We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee payment. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				} else {
					$insertn['nt_message'] = 'We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee and awaits yours. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View & Respond</a>';
				}

				$insertn['nt_satus'] = 0;
				$insertn['nt_apstatus'] = 2;
				$insertn['nt_create'] = date('Y-m-d H:i:s');
				$insertn['nt_update'] = date('Y-m-d H:i:s');
				$insertn['job_id'] = $dispute['ds_job_id'];
				$insertn['posted_by'] = $dispute['ds_puser_id'];
				$this->common_model->insert('notification', $insertn);



				$insertn1 = [];
				$insertn1['nt_userId'] = $dispute['ds_puser_id'];
				
				

				if($checkOtherPay){
					$insertn1['nt_message'] = 'You and '.$other_name.' have paid the arbitration fee and our team will now step in. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				} else {
					$insertn1['nt_message'] = 'We have received your arbitration payment and awaits for '.$other_name.' payment. <a href="'.site_url().'dispute/'.$dispute['ds_id'].'">View Now</a>';
				}

				$insertn1['nt_satus'] = 0;
				$insertn1['nt_apstatus'] = 2;
				$insertn1['nt_create'] = date('Y-m-d H:i:s');
				$insertn1['nt_update'] = date('Y-m-d H:i:s');
				$insertn1['job_id'] = $dispute['ds_job_id'];
				$insertn1['posted_by'] = $dispute['ds_puser_id'];
				$this->common_model->insert('notification', $insertn1);


				if($checkOtherPay){

					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($user['email'], $subject, $contant); //send to homeowner
					
					$subject = "Arbitration payment for dispute team to step in completed";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['f_name'].' '.$user['l_name'].' arbitration fee payment. Our dispute team will now step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant);  //send to trademen


				} else {
					$subject = "Reminder:Arbitration fee payment for dispute team to step-in not received!";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $other_user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received '.$user['f_name'].' '.$user['l_name'].' arbitration payment and awaits yours. Once you make your payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">You have until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make payment. If your payment is not received before this time, the case will automtiaclly closed and decided in '.$user['f_name'].' '.$user['l_name'].' favour. </p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">Please be advised: Any decision reached is final, irrevocable and can\'t reopen</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($other_user['email'], $subject, $contant); //send to trademen


					$subject = "Arbitration payment for dispute team to step in received";
					$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">We have received your arbitration payment and awaits for ' . $other_user['f_name'] . ' payment. Once they´ve made a payment, our arbitration team will step in and decides on the case.</p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">' . $other_user['f_name'] . ' has until the '. date('d-m-y h:i A',strtotime($expire_time)) .' to make a payment. If their payment is not received before this time, the case will automtiaclly closed and decided in your favour. </p>';
					$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
					$this->common_model->send_mail($user['email'], $subject, $contant); // send to home
				}

				

			}
			
			echo json_encode([
				'status' => 1,
			]);
			

		} else {
			echo json_encode([
				'status' => 0,
				'message' => 'You already submitted your request to step in.',
			]);
			exit();
		}

		

	}

	function dispute($dispute_id)
	{
		//die('under maintenance');
		/*$disputes = $this->common_model->GetAllData('tbl_dispute');

		echo '<pre>';
		
		
		foreach($disputes as $key => $dispute) {
			print_r($dispute);
			$get_mile = $this->common_model->GetColumnName('tbl_milestones',['id'=>$dispute['mile_id']]);
			if($get_mile){
				print_r($get_mile);
				//$this->common_model->update_data('tbl_milestones',['id'=>$dispute['mile_id']],['dispute_id'=>$dispute['ds_id']]);
				//$this->common_model->update_data('tbl_dispute',['ds_id'=>$dispute['ds_id']],['total_amount'=>$get_mile['milestone_amount']]);
				$insert = [];
				$insert['dispute_id'] = $dispute['ds_id'];
				$insert['milestone_id'] = $dispute['mile_id'];
				$insert['created_at'] = $dispute['ds_create_date'];
				$insert['updated_at'] = $dispute['ds_create_date'];
				//$this->common_model->insert('dispute_milestones',$insert);
			}
			
		}

		echo '</pre>';

		die();*/

		if ($this->session->userdata('user_id')) {
			$dispute = $this->common_model->get_single_data('tbl_dispute', array('ds_id' => $dispute_id));


			if (!$dispute) {
				return redirect('/' );
			}


			$page['dispute'] = $dispute;
			$page['setting'] = $this->common_model->GetColumnName('admin', array('id' => 1));
			//$page['job_details'] = $this->common_model->get_single_data('tbl_milestones', array('id' => $mile));
			$milestones = $this->common_model->CustomQuery('tbl_milestones', "inner join dispute_milestones on dispute_milestones.milestone_id = tbl_milestones.id where dispute_milestones.dispute_id = '".$dispute_id."'","tbl_milestones.*",true);
			//$page['job_files'] = $this->common_model->get_single_data('job_files', array('job_id' => $job_id));
			$page['milestones'] = $milestones;
			$page['owner'] = $owner = $this->common_model->get_single_data('users', array('id' => $dispute['ds_puser_id']));
			$page['tradmen'] = $tradmen = $this->common_model->get_single_data('users', array('id' => $dispute['ds_buser_id']));

			/*echo '<pre>';
			print_r($owner);
			//print_r($tradmen);
			echo '</pre>';*/

			$home_stepin = false;
			$trades_stepin = false;
			if($owner){
				$home_stepin = $this->common_model->get_single_data('ask_admin_to_step', array('user_id' => $owner['id'],'dispute_id'=>$dispute['ds_id']));
				
			}
			if($tradmen){
				$trades_stepin = $this->common_model->get_single_data('ask_admin_to_step', array('user_id' => $tradmen['id'],'dispute_id'=>$dispute['ds_id']));
			}

			$page['home_stepin'] = $home_stepin;
			$page['trades_stepin'] = $trades_stepin;
			//echo '<pre>'; print_r($page); echo '</pre>'; die();


			//$page['pending_amount'] = $this->common_model->sumcollum_value('milestone_amount', 'tbl_milestones', array('post_id' => $dispute['ds_job_id'], 'status' => 0, 'status' => 3, 'status' => 4, 'status' => 5));
			//$page['release_amount'] = $this->common_model->sumcollum_value('milestone_amount', 'tbl_milestones', array('id' => $mile, 'status' => 2));
			$page['disput_comment'] = $this->common_model->get_all_data('disput_conversation_tbl', array('dct_disputid' => $dispute['ds_id'],'dct_userid >='=>'0'), 'dct_id', 'ASC');
			$page['disput_comment_arbitration'] = $this->common_model->get_all_data('disput_conversation_tbl', array('dct_disputid' => $dispute['ds_id'],'dct_userid <'=>'0'), 'dct_id', 'ASC');
			$page['checkOtherUserReply'] = $this->common_model->GetColumnName('disput_conversation_tbl', array('dct_disputid' => $dispute['ds_id'], 'dct_userid' => $dispute['dispute_to']), ['dct_created'], false, 'dct_id', 'asc');
			//echo $this->db->last_query();
			$page['files'] = $this->common_model->get_all_data('dispute_file',"dispute_id = '".$dispute['ds_id']."' and conversation_id is null", 'id', 'DESC');
			$page['post_id'] = $dispute['ds_job_id'];
			$page['bid_amont'] = $this->common_model->get_single_data('tbl_jobpost_bids', array('job_id' => $dispute['ds_job_id'], 'bid_by' => $dispute['ds_buser_id']));
			$this->load->view('site/dispute', $page);
		} else {
			redirect('login');
		}
	}
	function add_dispute_files()
	{
		$files = [];
		//print_r($_FILES);
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

	function send_massege()
	{
		$userid = $this->session->userdata('user_id');
		$login_user = $this->common_model->get_userDataByid($userid);
		$from = $login_user['f_name'] . ' ' . $login_user['l_name'];
		$ds = $this->input->post('ds_id');
		$buser = $this->input->post('bid_by');
		$puser = $this->input->post('post_by');
		$dct_msg = $this->input->post('dct_msg');
		$job_id = $this->input->post('job_id');
		
		$jobDetails = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $job_id));

		if ($buser != $userid) {
			$user = $this->common_model->get_userDataByid($buser);
			$to_mail = $user['email'];
			$type = $user['type'];
		} else if ($puser != $userid) {
			$user = $this->common_model->get_userDataByid($puser);
			$to_mail = $user['email'];
			$type = $user['type'];
		}

		/*if ($_FILES['dct_image']['name'] != '') {
			$config['upload_path'] = 'img/dispute/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);

			//$this->upload->do_upload('cat_image');
			if ($this->upload->do_upload('dct_image')) {
				$data = $this->upload->data();
				$insert['dct_image'] = $data['file_name'];
				$insert['original_image_name'] = $_FILES['dct_image']['name'];
			} else {
				$this->upload->display_errors();
				$file_check = false;
			}
		}*/

		
		$admin = $this->common_model->get_single_data('admin', ['id' => 1]);
		$message_to = $user['id'];

		$current = date('Y-m-d H:i:s');

		$end_time = date('Y-m-d H:i:s', strtotime($current . ' +' . $admin['waiting_time'] . ' days'));

		$insert['dct_disputid'] =  $ds;
		$insert['dct_userid'] = $userid;
		$insert['dct_msg'] = $dct_msg;
		$insert['dct_isfinal'] = 0;
		$insert['message_to'] = $message_to;
		$insert['is_reply_pending'] = 1;
		$insert['dct_update'] = date('Y-m-d H:i:s');
		$insert['end_time'] = $end_time;


		$run = $this->common_model->insert('disput_conversation_tbl', $insert);
		if ($run) {

			if (isset($_POST['file_name']) && !empty($_POST['file_name'])) {
				foreach ($_POST['file_name'] as $key => $file) {
					$file_name = $_POST['file_name'][$key];
					$file_original_name = $_POST['file_original_name'][$key];
					
					$insertDoc = [];
					$insertDoc['uploaded_by'] = $userid;
					$insertDoc['dispute_id'] = $ds;
					$insertDoc['conversation_id'] = $run;
					$insertDoc['file'] = $file_name;
					$insertDoc['original_name'] = $file_original_name;
					$insertDoc['created_at'] = date('Y-m-d H:i:s');
					$insertDoc['updated_at'] = date('Y-m-d H:i:s');
					$this->common_model->insert('dispute_file', $insertDoc);
					
				}
			}

			$this->common_model->update_data('disput_conversation_tbl', array('dct_disputid' => $ds, 'dct_id != ' => $run, 'dct_userid >= ' => 0), array('is_reply_pending' => 0));

			$this->common_model->update_data('disput_conversation_tbl', array('dct_disputid' => $ds, 'message_to' => $userid, 'dct_userid >= ' => 0), array('is_reply_pending' => 0));

			$insertn['nt_userId'] = $user['id'];
			if ($login_user['trading_name']) {
				$insertn['nt_message'] = $login_user['trading_name'] . ' responded to the milestone payment dispute. <a href="' . site_url('dispute/' . $ds) . '">View & reply!</a>';
			} else {
				$insertn['nt_message'] = '' . $login_user['f_name'] . ' ' . $login_user['l_name'] . ' responded to the milestone payment dispute. <a href="' . site_url('dispute/' . $ds) . '">View & reply!</a>';
			}
			$insertn['nt_satus'] = 0;
			$insertn['nt_apstatus'] = 0;
			$insertn['nt_create'] = date('Y-m-d H:i:s');
			$insertn['nt_update'] = date('Y-m-d H:i:s');
			$insertn['job_id'] = $job_id;
			$insertn['posted_by'] = $puser;
			$run2 = $this->common_model->insert('notification', $insertn);

			if ($type == 1) {
				$subject = $login_user['f_name'] . " has replied to the milestone payment dispute “" . $jobDetails['title'] . "”";

				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">You´ve received a new reply from ' . $login_user['f_name'] . ' on the milestone payment dispute for job “' . $jobDetails['title'] . '”. We encourage you to respond as soon as possible to resolve your issue.</p>';

				$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $ds) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Reply Now</a></div><br>';

				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A', strtotime($end_time)) . ' will result in closing this case and deciding in the client favour.  Any decision reached is final and irrevocable. Once a case has been closed, it can\'t be reopened.</p>';

				$contant .= '<br><p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($to_mail, $subject, $contant);
			} else {

				$subject = $login_user['trading_name'] . " has replied to the milestone payment dispute: “" . $jobDetails['title'] . "”";

				$contant = '<br><p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] . '</p>';
				$contant .= '<br><p style="margin:0;padding:10px 0px">You\'ve received a new reply from ' . $login_user['trading_name'] . ' on the milestone payment dispute for job “' . $jobDetails['title'] . '”. We encourage you to respond as soon as possible to resolve the issue.</p>';

				$contant .= '<br><div style="text-align:center"><a href="' . site_url('dispute/' . $ds) . '" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View and reply now</a></div><br>';

				$contant .= '<p style="margin:0;padding:10px 0px">Please be advised: Not responding within ' . date('d M Y h:i:s A', strtotime($end_time)) . ' will result in closing this case and deciding in favour of ' . $login_user['trading_name'] . '. Any decision reached is final and irrevocable. Once a case is close, it can\'t reopen.</p>';

				$contant .= '<br><p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';

				$this->common_model->send_mail($to_mail, $subject, $contant);
			}
			$_SESSION['succ'] = 'Your comment has been submitted successfully.';

			//$db->redirect('dispute.php?tsr_id='.$tsr_id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Your comment has been added successfully.</div>');
			redirect('dispute/' . $ds);
		}
	}
}
