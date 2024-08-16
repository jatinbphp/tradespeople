<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Europe/London');
		$this->db->query('SET sql_mode=""');
		error_reporting(0);
	}
	public function reject_cashout_payouts($reject_mgs, $user_id, $payment_id, $request_amount)
	{
		$data1 = array(
			"status" => 'Rejected',
			"reason_for_reject" => $reject_mgs
		);
		$this->db->where("id", $payment_id);
		$this->db->update("payout_requests", $data1);
		$query = $this->db->query("SELECT * FROM `users_earnings` WHERE user_id=$user_id");
		if ($query->num_rows() > 0) {
			$query_result = $query->result();
			$ini_balance = $query_result[0]->balance;
			$ini_cashout_request_amount = $query_result[0]->cashout_request_amount;
			$cashout_request_amount_after = (float)$ini_cashout_request_amount - (float)$request_amount;
			$ini_balance_amount_after = (float)$ini_balance + (float)$request_amount;
		}
		$data2 = array(
			"balance" => $ini_balance_amount_after,
			"cashout_request_amount" => $cashout_request_amount_after
		);
		// echo json_encode($request_amount);
		// print_r(json_encode($data2));
		// die();
		$this->db->where("user_id", $user_id);
		$v = $this->db->update("users_earnings", $data2);
		echo json_encode($v);
		die();
	}
	public function accept_cashout_payouts($user_id, $payment_id, $request_amount)
	{
		$data1 = array(
			"status" => 'Accepted'
		);
		$this->db->where("id", $payment_id);
		$this->db->update("payout_requests", $data1);
		$query = $this->db->query("SELECT * FROM `users_earnings` WHERE user_id=$user_id");
		if ($query->num_rows() > 0) {
			$query_result = $query->result();
			$ini_balance = $query_result[0]->balance;
			$ini_cashout_request_amount = $query_result[0]->cashout_request_amount;
			$cashout_request_amount_after = (float)$ini_cashout_request_amount - (float)$request_amount;
		}
		$data2 = array(
			"cashout_request_amount" => $cashout_request_amount_after
		);
		// echo json_encode($request_amount);
		// print_r(json_encode($data2));
		// die();
		$this->db->where("user_id", $user_id);
		$v = $this->db->update("users_earnings", $data2);
		echo json_encode($v);
		die();
	}
	// public function get_marketer_payouts(){
	// 	$query = $this->db->query("SELECT payout_requests.id,payout_requests.user_id,payout_requests.request_amount,payout_requests.payment_method,payout_requests.account_number,payout_requests.bank_name,payout_requests.sort_code,payout_requests.account_holder_name,payout_requests.paypal_email_address,payout_requests.status,users.f_name,users.l_name FROM `payout_requests` join users on users.id = payout_requests.user_id where users.type=3");
	// 	if($query->num_rows() > 0){
	// 		return $query->result();
	// 	}else{
	// 		return $data = '';
	// 	}
	// }
	public function get_marketer_payouts($userType)
	{
		$query = $this->db->query("SELECT referral_payout_requests.id,referral_payout_requests.user_id,referral_payout_requests.request_amount, referral_payout_requests.reason_for_reject,referral_payout_requests.payment_method, referral_payout_requests.trans_id, referral_payout_requests.paypal_email_address,referral_payout_requests.status,users.f_name,users.l_name FROM `referral_payout_requests` join users on users.id = referral_payout_requests.user_id where users.type=" . $userType . " order by referral_payout_requests.id desc");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return $data = '';
		}
	}


	public function get_marketer_payouts_pending($userType)
	{
		$query = $this->db->query("SELECT referral_payout_requests.id,referral_payout_requests.user_id, referral_payout_requests.status FROM `referral_payout_requests` join users on users.id = referral_payout_requests.user_id where users.type=" . $userType . " and referral_payout_requests.status='0' order by referral_payout_requests.id desc");
		if ($query->num_rows() > 0) {
			$d = $query->result();
			return count($d);
		} else {
			return $data = '';
		}
	}


	// 	public function marketers_payouts_old($transfer_type,$amount,$account_number,$bank_name,$sort_code,$account_holder_name,$paypal_email_address){
	// echo "<pre>"; print_r($_POST); exit;


	// 		$user_id = $this->session->userdata('user_id');
	// 		if($transfer_type == 'Paypal Transfer'){
	// 			$data = array(
	// 						"request_amount" => $amount,
	// 						"payment_method" => $transfer_type,
	// 						"user_id" => $user_id,
	// 						"paypal_email_address" => $paypal_email_address
	// 						);
	// 		}else{
	// 			$data = array(
	// 						"request_amount" => $amount,
	// 						"payment_method" => $transfer_type,
	// 						"user_id" => $user_id, 
	// 						"account_number" => $account_number,
	// 						"bank_name" => $bank_name,
	// 						"sort_code" => $sort_code,
	// 						"account_holder_name" => $account_holder_name
	// 						);
	// 		}
	// 		$result = $this->db->insert("payout_requests",$data);
	// 		$query = $this->db->query("SELECT * FROM `users_earnings` WHERE user_id=$user_id");
	// 		if($query->num_rows() > 0){
	// 			$query_result = $query->result();
	// 			$ini_balance = $query_result[0]->balance;
	// 			$ini_cashout_request_amount = $query_result[0]->cashout_request_amount;
	// 			$balance=$ini_balance-$amount;
	// 			$cashout_request_amount = $ini_cashout_request_amount+$amount;
	// 			$data1 = array(
	// 						"balance" => $balance,
	// 						"cashout_request_amount" => $cashout_request_amount
	// 						);
	// 			$this->db->where("user_id",$user_id);
	// 			$this->db->update("users_earnings",$data1);
	// 			echo json_encode('1');
	// 			die();
	// 		}
	// 	}

	public function marketers_payouts($transfer_type, $amount, $account_number, $bank_name, $sort_code, $account_holder_name, $paypal_email_address)
	{
		// echo "<pre>"; print_r($_POST); exit;


		$user_id = $this->session->userdata('user_id');
		if ($transfer_type == 'Paypal Transfer') {
			$data = array(
				"request_amount" => $amount,
				"payment_method" => $transfer_type,
				"user_id" => $user_id,
				// "paypal_email_address" => $paypal_email_address
				'trans_id' => mt_rand(10000, 99999)
			);
		} else {
			$data = array(
				"request_amount" => $amount,
				"payment_method" => $transfer_type,
				"user_id" => $user_id,
				'trans_id' => mt_rand(10000, 99999)
			);
		}
		$result = $this->db->insert("referral_payout_requests", $data);
		$ref_earn = $this->db->select('referral_earning')->where('id', $user_id)->get('users')->row();
		if (!empty($ref_earn)) {
			$ini_balance = $ref_earn->referral_earning;
			$balance = $ini_balance - $amount;
			$this->db->where('id', $user_id)->update('users', ['referral_earning' => $balance]);
		}
		// echo json_encode('1');
		// die();


	}

	public function users_payouts($transfer_type, $amount)
	{
		// echo "<pre>"; print_r($_POST); exit;


		$user_id = $this->session->userdata('user_id');

		if ($transfer_type == 'Paypal Transfer') {
			$data = array(
				"request_amount" => $amount,
				"payment_method" => $transfer_type,
				"user_id" => $user_id,
				'trans_id' => mt_rand(10000, 99999)
			);
		} else {

			$data = array(
				"request_amount" => $amount,
				"payment_method" => $transfer_type,
				"user_id" => $user_id,
				'trans_id' => mt_rand(10000, 99999)
			);
		}
		if ($transfer_type == 'Wallet request') {
			$data['status'] = 1;
		}

		$result = $this->db->insert("referral_payout_requests", $data);
		$ref_earn = $this->db->select('referral_earning, u_wallet')->where('id', $user_id)->get('users')->row();
		// echo "<pre>"; print_r($ref_earn); exit;

		if (!empty($ref_earn)) {
			$ini_balance = $ref_earn->referral_earning;
			$balance = $ini_balance - $amount;

			if ($transfer_type == 'Wallet request') {
				$wallet = $ref_earn->u_wallet + $amount;
				$this->db->where('id', $user_id)->update('users', ['referral_earning' => $balance, 'u_wallet' => $wallet]);
			} else {
				$this->db->where('id', $user_id)->update('users', ['referral_earning' => $balance]);
			}
		}
	}

	public function get_min_cashout($user_id)
	{
		$user_type = $this->session->userdata('type');
		$query = $this->db->query("SELECT * FROM `admin_settings` WHERE referred_type=$user_type");
		if ($query->num_rows() > 0) {
			$query_result = $query->result();
			$min_amount = $query_result[0]->min_amount_cashout;
			$final_min_amount = ltrim($min_amount, '£');
		} else {
			$final_min_amount = 0;
		}
		return $final_min_amount;
	}
	public function get_balance_amount($user_id)
	{

		// $query = $this->db->query("SELECT * FROM `referrals_earn_list` WHERE user_id=$user_id");
		$query = $this->db->select('id, u_wallet, referral_earning')->where('id', $user_id)->get('users')->row();

		// echo "<pre>"; print_r($query); exit;
		// if($query->num_rows() > 0){
		if (!empty($query)) {
			return $query;
			// return $query->result();
		} else {
			return $data = '';
		}
	}
	public function get_reff_homeowner()
	{
		$query = $this->db->query("SELECT * FROM `referrals_list` join users on users.id= referrals_list.user_id where users.type=2");
		$homeowners = array();
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$id = $row->user_id;
				$homeowners[$i]['id'] = $id;
				$homeowners[$i]['f_name'] = $row->f_name;
				$homeowners[$i]['cdate'] = $row->cdate;
				$referred_by = $row->referred_by;
				$homeowners[$i]['referred_by'] = $referred_by;
				$quote_query = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where posted_by=$id");
				$quote_result = $quote_query->result();
				$homeowners[$i]['tot_quotes'] = $quote_result[0]->count;
				$ref_query = $this->db->query("SELECT * FROM `users` where id=$referred_by");
				if ($ref_query->num_rows() > 0) {
					$ref_result = $ref_query->result();
					$homeowners[$i]['referee'] = $ref_result[0]->f_name;
					$homeowners[$i]['referee_email'] = $ref_result[0]->email;
					$i++;
				}
			}
			return $homeowners;
		} else {
			return $data = array();
		}
	}
	public function get_reff_tradsman()
	{
		$query = $this->db->query("SELECT * FROM `referrals_list` join users on users.id= referrals_list.user_id where users.type=1");
		$homeowners = array();
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$id = $row->user_id;
				$homeowners[$i]['id'] = $id;
				$homeowners[$i]['f_name'] = $row->f_name;
				$homeowners[$i]['cdate'] = $row->cdate;
				$referred_by = $row->referred_by;
				$homeowners[$i]['referred_by'] = $referred_by;
				$quote_query = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where bid_by=$id");
				$quote_result = $quote_query->result();
				$homeowners[$i]['tot_quotes'] = $quote_result[0]->count;
				$ref_query = $this->db->query("SELECT * FROM `users` where id=$referred_by");
				if ($ref_query->num_rows() > 0) {
					$ref_result = $ref_query->result();
					$homeowners[$i]['referee'] = $ref_result[0]->f_name;
					$homeowners[$i]['referee_email'] = $ref_result[0]->email;
					$i++;
				}
			}
			return $homeowners;
		} else {
			return $data = array();
		}
	}
	public function get_marketers()
	{
		$query = $this->db->query("SELECT * FROM `users` WHERE type = 3");
		$marketers = array();
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$id = $row->id;
				$marketers[$i]['id'] = $id;
				$marketers[$i]['email'] = $row->email;
				$marketers[$i]['f_name'] = $row->f_name;
				$marketers[$i]['l_name'] = $row->l_name;
				$ref_query = $this->db->query("SELECT * FROM `referrals_earn_list` left join users on users.id=referrals_earn_list.user_id where referrals_earn_list.referred_by=$id");
				// $ref_query = $this->db->query("SELECT * FROM `referrals_list` join users on users.id=referrals_list.user_id where referrals_list.referred_by=$id");
				$mar_reff = array();
				if ($ref_query->num_rows() > 0) {
					$k = 0;
					foreach ($ref_query->result() as $ref_row) {
						$user_id = $ref_row->user_id;
						$mar_reff[$k]['user_id'] = $user_id;
						$mar_reff[$k]['type'] = $ref_row->type;
						$mar_reff[$k]['f_name'] = $ref_row->f_name;
						$mar_reff[$k]['l_name'] = $ref_row->l_name;
						$mar_reff[$k]['cdate'] = $ref_row->cdate;
						if ($mar_reff[$k]['type'] == 1) {
							$quote_query = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where bid_by=$user_id");
						} else if ($mar_reff[$k]['type'] == 2) {
							$quote_query = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where posted_by=$user_id");
						}
						$quote_result = $quote_query->result();
						$mar_reff[$k]['tot_quotes'] = $quote_result[0]->count;
						$k++;
					}
					$marketers[$i]['referrals']	= $mar_reff;
				}
				$i++;
			}
			return $marketers;
		} else {
			return $data = array();
		}
	}
	public function get_countries()
	{
		$query = $this->db->query("SELECT * FROM `country`");
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return $data = array();
		}
	}

	public function earn_refer_to_tradsman($user_id = 0)
	{
		$invited = $this->get_single_data("referrals_earn_list", ['user_id' => $user_id, 'earn_status' => 0]);
		if ($invited) {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];

			$referred_by_user = $this->GetColumnName('users', ['id' => $referred_by], ['id', 'referral_earning']);
			if ($referred_by_user) {

				if ($referred_type == 1) { //invited by tradesmen
					$setting = $this->get_single_data("admin_settings", ['id' => 3]);
				} else if ($referred_type == 2) { //invited by homeowners
					$setting = $this->get_single_data("admin_settings", ['id' => 2]);
				} else if ($referred_type == 3) { //invited by marketer
					$setting = $this->get_single_data("admin_settings", ['id' => 1]);
				} else {
					$setting = false;
				}

				if ($setting) {

					$min_quotes = $setting['min_quotes_approved_tradsman'];
					$comission = $setting['comission_ref_tradsman'];

					$checkBidCount = $this->GetColumnName('tbl_jobpost_bids', ['bid_by' => $user_id], ['count(id) as total']);

					if ($checkBidCount && $checkBidCount['total']) {
						$applyBid = $checkBidCount['total'] * 1;

						if ($applyBid >= $min_quotes) {
							$data = array(
								'earn_status' => 1,
								'earn_amount' => $comission,
							);

							$this->update('referrals_earn_list', ['id' => $invited['id']], $data);

							$referral_earning = $referred_by_user['referral_earning'] + $comission;

							$update2 = [
								'referral_earning' => $referral_earning
							];
							$this->update('users', ['id' => $referred_by], $update2);
						}
					}
				}
			}
		}
	}

	public function earn_refer_to_homeowner($user_id = 0)
	{
		$invited = $this->get_single_data("referrals_earn_list", ['user_id' => $user_id, 'earn_status' => 0]);
		if ($invited) {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];

			$referred_by_user = $this->GetColumnName('users', ['id' => $referred_by], ['id', 'referral_earning']);
			if ($referred_by_user) {

				if ($referred_type == 1) { //invited by tradesmen
					$setting = $this->get_single_data("admin_settings", ['id' => 3]);
				} else if ($referred_type == 2) { //invited by homeowners
					$setting = $this->get_single_data("admin_settings", ['id' => 2]);
				} else if ($referred_type == 3) { //invited by marketer
					$setting = $this->get_single_data("admin_settings", ['id' => 1]);
				} else {
					$setting = false;
				}

				if ($setting) {

					$min_quotes = $setting['min_quotes_received_homeowner'];
					$comission = $setting['comission_ref_homeowner'];

					$checkBidCount = $this->GetColumnName('tbl_jobpost_bids', ['posted_by' => $user_id], ['count(id) as total']);

					if ($checkBidCount && $checkBidCount['total']) {
						$applyBid = $checkBidCount['total'] * 1;

						if ($applyBid >= $min_quotes) {
							$data = array(
								'earn_status' => 1,
								'earn_amount' => $comission,
							);

							$this->update('referrals_earn_list', ['id' => $invited['id']], $data);

							$referral_earning = $referred_by_user['referral_earning'] + $comission;

							$update2 = [
								'referral_earning' => $referral_earning
							];
							$this->update('users', ['id' => $referred_by], $update2);
						}
					}
				}
			}
		}
	}


	public function earn_refer_to_tradsman_pd($user_id = 0, $amount = 0)
	{
		$invited = $this->get_single_data("referrals_earn_list", ['user_id' => $user_id, 'earn_status' => 0]);
		if ($invited) {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];

			$referred_by_user = $this->GetColumnName('users', ['id' => $referred_by], ['id', 'referral_earning']);
			if ($referred_by_user) {

				if ($referred_type == 1) { //invited by tradesmen
					$setting = $this->get_single_data("admin_settings", ['id' => 3]);
				} else if ($referred_type == 2) { //invited by homeowners
					$setting = $this->get_single_data("admin_settings", ['id' => 2]);
				} else if ($referred_type == 3) { //invited by marketer
					$setting = $this->get_single_data("admin_settings", ['id' => 1]);
				} else {
					$setting = false;
				}

				if ($setting) {

					$min_quotes = $setting['min_quotes_approved_tradsman'];
					$comission = $setting['comission_ref_tradsman'];

					if ($amount >= $min_quotes) {
						$data = array(
							'earn_status' => 1,
							'earn_amount' => $comission,
						);

						$this->update('referrals_earn_list', ['id' => $invited['id']], $data);

						$referral_earning = $referred_by_user['referral_earning'] + $comission;

						$update2 = [
							'referral_earning' => $referral_earning
						];
						$this->update('users', ['id' => $referred_by], $update2);
					}
				}
			}
		}
	}

	public function earn_refer_to_homeowner_pd($user_id = 0, $amount = 0)
	{
		$invited = $this->get_single_data("referrals_earn_list", ['user_id' => $user_id, 'earn_status' => 0]);
		if ($invited) {
			$referred_type = $invited['referred_type'];
			$referred_by = $invited['referred_by'];

			$referred_by_user = $this->GetColumnName('users', ['id' => $referred_by], ['id', 'referral_earning']);
			if ($referred_by_user) {

				if ($referred_type == 1) { //invited by tradesmen
					$setting = $this->get_single_data("admin_settings", ['id' => 3]);
				} else if ($referred_type == 2) { //invited by homeowners
					$setting = $this->get_single_data("admin_settings", ['id' => 2]);
				} else if ($referred_type == 3) { //invited by marketer
					$setting = $this->get_single_data("admin_settings", ['id' => 1]);
				} else {
					$setting = false;
				}

				if ($setting) {

					$min_quotes = $setting['min_quotes_received_homeowner'];
					$comission = $setting['comission_ref_homeowner'];

					if ($amount >= $min_quotes) {
						$data = array(
							'earn_status' => 1,
							'earn_amount' => $comission,
						);

						$this->update('referrals_earn_list', ['id' => $invited['id']], $data);

						$referral_earning = $referred_by_user['referral_earning'] + $comission;

						$update2 = [
							'referral_earning' => $referral_earning
						];
						$this->update('users', ['id' => $referred_by], $update2);
					}
				}
			}
		}
	}

	public function getRows($table, $id = null)
	{
		if (!empty($id)) {
			$this->db->where('id', $id);
			$query = $this->db->get($table);
			return $query->row_array();
		} else {
			$query = $this->db->get($table);
			return $query->result_array();
		}
	}
	public function marketers_account_info($user_id)
	{

		// $this->db->where('user_id',$user_id);
		// $query = $this->db->get('marketers_account_info');
		// if($query->num_rows() > 0){
		// 	return $query->result();
		// }else{
		// 	return $data="";
		// }

		$this->db->where('wd_user_id', $user_id);
		$query = $this->db->get('wd_bank_details');
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return $data = "";
		}
	}
	public function marketers_referrals_list_old()
	{
		$type = $this->session->userdata('type');
		$user_type = $this->session->userdata('user_id');
		$query = $this->db->query("SELECT referrals_list.user_id,referrals_list.earn_amount,referrals_list.referred_by,users.f_name,users.cdate,users.type FROM `referrals_list` join users on users.id =referrals_list.user_id where referrals_list.referred_type=$type and referrals_list.referred_by=$user_type");
		if ($query->num_rows() > 0) {
			$i = 0;
			$marketers_referrals = array();
			foreach (($query->result()) as $row) {
				$user_id = $row->user_id;
				$marketers_referrals[$i]['user_id'] = $user_id;
				$marketers_referrals[$i]['referred_by'] = $row->referred_by;
				$marketers_referrals[$i]['f_name'] = $row->f_name;
				$type = $row->type;
				if ($type == '1') {
					$marketers_referrals[$i]['type'] = 'Tradsman';
					$queryt = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` WHERE bid_by=$user_id");
					$result_t = $queryt->result();
					$marketers_referrals[$i]['quotes'] = $result_t[0]->count;
					$marketers_referrals[$i]['jobs'] = 0;
				} else {
					$marketers_referrals[$i]['type'] = 'Home Owner';
					$queryc = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where posted_by=$user_id");
					$result = $queryc->result();
					$marketers_referrals[$i]['quotes'] = $result[0]->count;
					$queryh = $this->db->query("SELECT count(*) as count FROM `tbl_jobs` where userid=$user_id");
					$result_h = $queryh->result();
					$marketers_referrals[$i]['jobs'] = $result_h[0]->count;
				}
				$marketers_referrals[$i]['earn_amount'] = $row->earn_amount;
				$marketers_referrals[$i]['signed_up'] = $row->cdate;
				$i++;
			}
			return $marketers_referrals;
		} else {
			return $marketers_referrals[] = array();
		}
	}

	public function marketers_referrals_list()
	{
		$type = $this->session->userdata('type');
		$user_type = $this->session->userdata('user_id');
		$query = $this->db->query("SELECT referrals_earn_list.user_id,referrals_earn_list.referred_link,referrals_earn_list.earn_amount,referrals_earn_list.referred_by,users.f_name, users.l_name,users.cdate,users.type FROM `referrals_earn_list` join users on users.id =referrals_earn_list.user_id where referrals_earn_list.referred_type=$type and referrals_earn_list.referred_by=$user_type");
		$adminSetting = $this->common_model->get_all_data('admin');
		if ($query->num_rows() > 0) {
			$i = 0;
			$marketers_referrals = array();
			foreach (($query->result()) as $row) {
				$user_id = $row->user_id;
				$marketers_referrals[$i]['user_id'] = $user_id;
				$marketers_referrals[$i]['referred_by'] = $row->referred_by;
				$marketers_referrals[$i]['referred_link'] = $row->referred_link;
				$marketers_referrals[$i]['f_name'] = $row->f_name;
				$marketers_referrals[$i]['l_name'] = $row->l_name;
				$type = $row->type;
				if ($type == '1') {
					$marketers_referrals[$i]['type'] = 'Tradesman';
					$queryt = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` WHERE bid_by=$user_id");
					$result_t = $queryt->result();

				//	$firstMilestone = $this->common_model->get_single_data("tbl_milestones", array("userid"=>$user_id));
				$firstMilestone =	$this->get_single_data("tbl_milestones", ['userid' => $user_id, 'status' => 2]);
					
					if($adminSetting[0]['payment_method'] == 1){
						$marketers_referrals[$i]['quotes'] = $result_t[0]->count;	
					}else{
						$marketers_referrals[$i]['quotes'] = $firstMilestone['milestone_amount'];
					}
					
					$marketers_referrals[$i]['jobs'] = 0;
				} else {
					$marketers_referrals[$i]['type'] = 'Homeowner';
					$queryc = $this->db->query("SELECT count(*) as count FROM `tbl_jobpost_bids` where posted_by=$user_id");
					$result = $queryc->result();

				 // $firstMilestone = $this->common_model->get_single_data("tbl_milestones", array("posted_user"=>$user_id));
					$firstMilestone =	$this->get_single_data("tbl_milestones", ['posted_user' => $user_id, 'status' => 2]);
					if($adminSetting[0]['payment_method'] == 1){
						$marketers_referrals[$i]['quotes'] = $result[0]->count;
					}else{
						$marketers_referrals[$i]['quotes'] = $firstMilestone['milestone_amount'];
					}					
					
					$queryh = $this->db->query("SELECT count(*) as count FROM `tbl_jobs` where userid=$user_id");
					$result_h = $queryh->result();
					$marketers_referrals[$i]['jobs'] = $result_h[0]->count;
				}
				$marketers_referrals[$i]['earn_amount'] = $row->earn_amount;
				$marketers_referrals[$i]['signed_up'] = $row->cdate;
				$i++;
			}
			return $marketers_referrals;
		} else {
			return $marketers_referrals[] = array();
		}
	}

	function newgetRows($table, $id = null, $orderby = null, $ordercol = null, $orwhere = null)
	{
		if ($id) {
			$this->db->where($id);
		}
		if ($orwhere) {
			$this->db->or_where($orwhere);
		}
		if ($orderby) {
			if ($ordercol) {
				$ord = 'ASC';
			} else {
				$ord = 'desc';
			}
			$this->db->order_by($orderby, $ord);
		}
		$query = $this->db->get($table);
		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		}
	}
	public function get_userDataByid($value)
	{
		$this->db->where('id', $value);
		$obj = $this->db->get('users');
		if ($obj->num_rows() > 0) {
			return $obj->row_array();
		} else {
			return false;
		}
	}
	public function possitve_reviews_percent_given($id)
	{
		$run = $this->db->query("select COUNT(tr_id) as total from rating_table where rt_rateTo = '" . $id . "'");

		$row = $run->row_array();
		$total = $row['total'];

		if ($total > 0) {
			$run2 = $this->db->query("select COUNT(tr_id) as total from rating_table where rt_rateTo = '" . $id . "' and rt_rate >= 3");

			$row2 = $run2->row_array();
			$total2 = $row2['total'];

			return $percent = ($total2 / $total) * 100;
		} else {
			return 0;
		}
	}

	public function possitve_reviews_percent($id)
	{
		$run = $this->db->query("select COUNT(tr_id) as total from rating_table where rt_rateTo = '" . $id . "'");

		$row = $run->row_array();
		$total = $row['total'];

		if ($total > 0) {
			$run2 = $this->db->query("select COUNT(tr_id) as total from rating_table where rt_rateTo = '" . $id . "' and rt_rate >= 3");

			$row2 = $run2->row_array();
			$total2 = $row2['total'];

			return $percent = ($total2 / $total) * 100;
		} else {
			return 0;
		}
	}
	public function get_organizationbyID($value)
	{
		$this->db->where('og_id', $value);
		$obj = $this->db->get('organization');
		if ($obj->num_rows() > 0) {
			return $obj->row_array();
		} else {
			return false;
		}
	}

	public function insert($table, $data)
	{
		$insert = $this->db->insert($table, $data);
		if ($insert) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function get_all_data($table, $id = null, $ob = null, $obc = 'desc', $limit = null, $select = null)
	{
		if ($id) {
			$this->db->where($id);
		}
		if ($ob) {
			$this->db->order_by($ob, $obc);
		}
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		$query = $this->db->get($table);

		if ($query->num_rows()) {
			return $query->result_array();
		} else {
			return array();
		}
	}

	public function get_single_data($table, $id = null)
	{
		if ($id) {
			$this->db->where($id);
		}
		$query = $this->db->get($table);
		if ($query->num_rows()) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	public function get_total_milestone($id)
	{
		$query =  $this->db->query("SELECT * FROM tbl_milestones WHERE post_id= '" . $id . "'");
		if ($query->num_rows()) {
			return $query->num_rows();
		} else {
			return false;
		}
	}
	
	public function get_completed_milestone($id)
	{
		$query =  $this->db->query("SELECT * FROM `tbl_milestones` WHERE (status=2 OR status=6) AND post_id='" . $id . "'");
		if ($query->num_rows()) {
			return $query->num_rows();
		} else {
			return false;
		}
	}
	

	public function get_data_count($table, $id = null, $col)
	{
		$this->db->select("COUNT(" . $col . ") as total_recodes");
		if ($id) {
			$this->db->where($id);
		}
		$query = $this->db->get($table);
		if ($query->num_rows()) {
			$row = $query->row_array();
			return $row['total_recodes'];
		} else {
			return 0;
		}
	}

	public function update($table, $where, $data)
	{
		$this->db->where($where);
		$obj = $this->db->update($table, $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	public function update_data($table, $where, $data)
	{
		$this->db->where($where);
		$obj = $this->db->update($table, $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_active_plan($userid)
	{
		$today = date('Y-m-d');

		$where = "up_status = 1 and up_remaining_post > 0 and DATE(up_enddate) >= DATE('" . $today . "') and up_user = '" . $userid . "' and up_plan != '8'";

		$this->db->where($where);
		$query = $this->db->get('user_plans');
		if ($query->num_rows()) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function check_postalcode($postcode)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.postcodes.io/postcodes/" . $postcode,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$return = array();

		if ($err) {
			$return['status'] = 0;
			$return['data'] = "cURL Error #:" . $err;
		} else {

			$response = json_decode($response);

			//echo '<pre>'; print_r($response); echo '</pre>';

			if ($response->status == '200') {

				$admin_county = $response->result->admin_county;

				if (!$admin_county) {
					$admin_county = $response->result->region;
				}

				$return['longitude'] = $response->result->longitude;
				$return['latitude'] = $response->result->latitude;
				$return['primary_care_trust'] = $response->result->admin_district;
				$return['country'] = $admin_county;
				$return['address'] = $response->result->european_electoral_region;
				$return['region'] = $response->result->region;
				$return['status'] = 1;
			} else {
				$return['status'] = 1;
				$return['msg'] = "Please enter valid UK postcode";
			}
		}

		return $return;
	}

	public function delete($where, $table)
	{
		$this->db->where($where);
		$obj = $this->db->delete($table);
		return $obj;
	}

	public function insert_notification($userid, $message)
	{
		$data = array(
			'nt_userId' => $userid,
			'nt_message' => $message,
			'nt_satus' => 0,
			'posted_by' => $userid,
		);
		$insert = $this->db->insert('notification', $data);
		if ($insert) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function insert_notification_json($userid, $message, $title, $action, $action_id)
	{
		
		$action_data	=	array('user_id'=>$userid, 'other_user_id'=>$userid, 'job_id'=>$action_id, 'action_id'=>$action_id, 'action'=>$action);
		$action_json = json_encode($action_data);
		
		$data = array(
			'nt_userId' => $userid,
			'nt_message' => $message,
			'nt_satus' => 0,
			'posted_by' => $userid,
			'action_json' => $action_json,
			'action' => $action,
			'action_id' => $action_id,
		);
		$insert = $this->db->insert('notification', $data);
		if ($insert) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function get_coloum_value($table, $where, $name)
	{
		$this->db->select($name);
		$this->db->where($where);
		$query = $this->db->get($table);

		if ($query) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	public function get_customer_reviews()
	{

		$data = array();

		$this->db->query("set sql_mode = ''");

		$this->db->select('rating_table.tr_id, rating_table.rt_rateBy, rating_table.rt_rateTo, rating_table.rt_jobid, rating_table.rt_rate, rating_table.rt_comment, users.id, users.f_name, users.l_name, users.profile');
		//$this->db->select_max('rating_table.tr_id' , 'max_tr_id');
		$this->db->from('rating_table');
		$this->db->join('users', 'users.id = rating_table.rt_rateBy', 'inner');
		//$this->db->having('rating_table.tr_id','MAX(rating_table.tr_id)');
		$this->db->where('users.type', '2');
		$this->db->where('rating_table.rt_rate >', '0');

		//$this->db->group_by('rating_table.rt_rateBy');
		$this->db->order_by('rating_table.tr_id', 'DESC');

		$query = $this->db->get();
		//echo '<pre>'; echo $this->db->last_query(); echo '</pre>';
		if ($query->num_rows() > 0) {
			$data = $query->result_array();
		}
		return $data;
	}
	public function check_email_notification($user_id)
	{

		$return = false;

		$is_phone_verified = $this->common_model->GetColumnName('users', array('id' => $user_id), array('email', 'f_name', 'l_name', 'trading_name', 'type'));

		if ($is_phone_verified) {
			$return['email'] = $is_phone_verified['email'];
			$return['f_name'] = $is_phone_verified['f_name'];
			$return['l_name'] = $is_phone_verified['l_name'];
			$return['trading_name'] = $is_phone_verified['trading_name'];
			$return['type'] = $is_phone_verified['type'];
		}


		/*if($is_phone_verified){
		
			$check_plan = $this->GetColumnName('user_plans',array('up_user'=>$user_id,'up_enddate >= '=>date('Y-m-d'),'up_status'=>1),array('up_plan'));
			
			if($check_plan){
				$plan_id = $check_plan['up_plan'];
				
				$has_email_notification = $this->GetColumnName('tbl_package',array('id'=>$plan_id,'email_notification'=>1),array('id'));
				
				if($has_email_notification){
					
					$return['email'] = $is_phone_verified['email'];
					$return['f_name'] = $is_phone_verified['f_name'];
					$return['type'] = $is_phone_verified['type'];
					
				}
				
			}
		
		}*/

		return $return;
	}

	public function check_sms_notification($user_id)
	{

		$return = false;

		$is_phone_verified = $this->common_model->GetColumnName('users', array('id' => $user_id, 'is_phone_verified' => 1, 'type' => 1), array('phone_no'));

		if ($is_phone_verified) {

			$check_plan = $this->GetColumnName('user_plans', array('up_user' => $user_id, 'up_enddate >= ' => date('Y-m-d'), 'up_status' => 1), array('up_plan', 'used_sms_notification', 'total_sms'));

			if ($check_plan) {
				$plan_id = $check_plan['up_plan'];

				$has_email_notification = $this->GetColumnName('tbl_package', array('id' => $plan_id, 'sms_notification' => 1), array('id', 'total_notification'));

				if ($has_email_notification) {
					if ($check_plan['total_sms'] > $check_plan['used_sms_notification']) {

						$return['phone_no'] = $is_phone_verified['phone_no'];
						$return['used_sms_notification'] = $check_plan['used_sms_notification'] + 1;
					}
				}
			}
		}
		return $return;
	}
	public function check_admin_unread($table, $where, $count_id)
	{
		$this->db->select("count($count_id) as countss");
		$this->db->where($where);
		$sql = $this->db->get($table);
		$data = $sql->row_array();
		return $data['countss'];
	}
	public function GetColumnName($table, $where = null, $name = null, $double = null, $ob = null, $obc = 'desc')
	{
		if ($name) {
			$this->db->select(implode(',', $name));
		} else {
			$this->db->select('*');
		}

		if ($where) {
			$this->db->where($where);
		}

		if ($obc && $ob) {
			$this->db->order_by($ob, $obc);
		}

		$sql = $this->db->get($table);

		$data = false;

		if ($sql->num_rows() > 0) {
			if ($double) {
				$data = $sql->result_array();
			} else {
				$data = $sql->row_array();
			}
		}
		return $data;
	}

	public function CustomQuery($table, $where = null,$columm=null,$double = null)
	{
		if(is_array($columm)){
			$columm = implode(',',$columm);
		}
		$sql = "select $columm from $table $where";

		$query = $this->db->query($sql);

		$data = false;

		if ($query->num_rows() > 0) {
			if ($double) {
				$data = $query->result_array();
			} else {
				$data = $query->row_array();
			}
		}
		return $data;
	}


	public function admin_login($data)
	{
		$this->db->where('email', $data['email']);
		$this->db->where('password', $data['password']);
		$query = $this->db->get('admin');
		if ($query->num_rows()) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	public function Latest_five_notif($id)
	{
		$this->db->order_by("nt_id", 'desc');
		$this->db->limit(5);
		$this->db->where('nt_userId', $id);
		$run = $this->db->get('notification');
		if ($run->num_rows()) {
			return $run->result_array();
		} else {
			return false;
		}
	}

	public function Latest_five_notiftrades($id)
	{
		$this->db->order_by("nt_id", 'desc');
		$this->db->limit(5);
		$this->db->where('userid', $id);
		$run = $this->db->get('notification');
		if ($run->num_rows()) {
			return $run->result_array();
		} else {
			return false;
		}
	}

	public function updates($table, $column, $value, $data)
	{
		$this->db->where($column, $value);
		$obj = $this->db->update($table, $data);
		return $obj;
	}

	public function get_data($table, $where, $o_c = null, $o_v = null)
	{
		if ($where != "") {
			$this->db->where($where);
		}

		if ($o_c && $o_v) {
			$this->db->order_by($o_c, $o_v);
		}

		$obj = $this->db->get($table);

		$data = array();
		if ($obj->num_rows() > 0) {
			$data = $obj->result_array();
		}
		return $data;
	}
	public function get_id_data()
	{
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$json = file_get_contents("http://ipinfo.io/" . $ip_address);
		$details    = json_decode($json);
		return $details;
	}

	public function custume_query($sql)
	{
		$result_sql = $this->db->query($sql);

		if ($result_sql) {
			return $result_sql;
		} else {
			return false;
		}
	}

	function get_city()
	{
		$city = array();
		$this->db->select('e_city as city');
		$this->db->group_by('e_city');
		$this->db->order_by('city', 'desc');

		$sql1 = $this->db->get('events');
		if ($sql1->num_rows() > 0) {
			$city1 = $sql1->result_array();
			foreach ($city1 as $row1) {
				$city[] = $row1['city'];
			}
		}

		$this->db->select('j_city as city');
		$this->db->group_by('j_city');
		$this->db->order_by('city', 'desc');

		$sql2 = $this->db->get('jobs');
		if ($sql2->num_rows() > 0) {
			$city2 = $sql2->result_array();
			foreach ($city2 as $row2) {
				$city[] = $row2['city'];
			}
		}

		$this->db->select('co_city as city');
		$this->db->group_by('co_city');
		$this->db->order_by('city', 'desc');

		$sql3 = $this->db->get('cources');
		if ($sql3->num_rows() > 0) {
			$city3 = $sql3->result_array();
			foreach ($city3 as $row3) {
				$city[] = $row3['city'];
			}
		}

		return array_unique($city);
	}
	function send_mail_simple($toz, $sub, $body, $bcc = null, $via = null)
	{
		$this->load->library('phpmailer_lib');

		$mail = $this->phpmailer_lib->load();

		$mail->isSMTP();
		$mail->Host     = 'ex4.mail.ovh.net';
		$mail->SMTPAuth = true;
		$mail->Username = 'info@tradespeoplehub.co.uk';
		// $mail->Password = '8QFlJNfx$%oH';
		$mail->Password = 'hcIb36fN';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->Port     = 587;
		$mail->CharSet = 'UTF-8';


		if ($via) {
			$mail->setFrom(EMAIL_ID, $via);
		} else {
			$mail->setFrom(EMAIL_ID, 'Tradespeoplehub');
		}

		$mail->addAddress($toz);

		$mail->Subject = $sub;

		$mail->isHTML(true);

		if ($bcc) {
			$mail->addBCC($bcc);
		}
		$mail->Body = $body;
		if (!$mail->send()) {
			return 0;
		} else {
			return 1;
		}
	}

	function send_mail_new($toz, $sub, $body, $bcc = null, $via = null)
	{
		$is_blocked = true;
		$users = $this->GetColumnName('users', array('email' => $toz), array('status', 'id', 'type'));
		if ($users) {
			if ($users['status'] == 1) {
				$is_blocked = false;
			}
            if($users['type'] == 1){
                    $androidLink = 'https://play.google.com/store/apps/details?id=com.tradesprovider';
                    $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-trades/id6450201899';
            }
            if($users['type'] == 2){
                $androidLink = 'https://play.google.com/store/apps/details?id=com.tradespeoplehub';
                $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-homeowners/id6450202456 ';
            }
		}
		if ($is_blocked) {
			$this->load->library('phpmailer_lib');
			$mail = $this->phpmailer_lib->load();
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
			$mail->isSMTP();
			$mail->Host     = 'ex4.mail.ovh.net';
			$mail->SMTPAuth = true;
			$mail->Username = 'info@tradespeoplehub.co.uk';
			// $mail->Password = '8QFlJNfx$%oH';
			$mail->Password = 'hcIb36fN';
			$mail->SMTPSecure = 'STARTTLS';
			$mail->Port     = 587;
			$mail->CharSet = 'UTF-8';

			if ($via) {
				$mail->setFrom(EMAIL_ID, $via);
			} else {
				$mail->setFrom('info@tradespeoplehub.co.uk', 'Tradespeoplehub');
			}
			$mail->addAddress($toz);
			$mail->Subject = $sub;
			$mail->isHTML(true);
			if ($bcc) {
				$mail->addBCC($bcc);
			}

			$msg = '<!DOCTYPE html>
					<html>
						<head>
							<title>New Jobs</title>
							<meta name="viewport" content="width=device-width, initial-scale=1.0" />
							<style type="text/css" media="only screen and (max-width: 480px)">
								/* Mobile styles */
								@media only screen and (max-width: 480px) {

									[class="w320"] {
										width: 320px !important;
									}

									[class="mobile-block"] {
										width: 100% !important;
										display: block !important;
									}
								}
							</style>
						</head>
						<body style="margin:0">
							<div data-section-wrapper="1">
								<center>
									<table data-section="1" style="width: 600;" width="600" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td>
													<div data-slot-container="1" style="min-height: 30px">
														<div data-slot="text">
															<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
																<tbody>
																	<tr>
																		<td align="center" valign="top">
																			<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
																				<tbody>
																					<tr>
																						<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
																							<table border="0" cellpadding="0" cellspacing="10" width="100%">
																								<tbody>
																									<tr>
																										<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="' . site_url() . '"><img src="' . site_url() . 'img/logo_invert.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																					<tr>
																						<td align="center" valign="top">
																							<table border="0" cellpadding="0" cellspacing="10" width="100%">
																								<tbody>
																									<tr>
																										<td align="left" valign="top" style="color:#444;font-size:14px">
																											' . $body . '
																											 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																											 <p style="margin:0;padding:10px 0px">The ' . Project . ' Team</p>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																					<tr>
																					    <td style="background-color:#f1f1f1;">
																					    <div style="text-align:center">
																					    	<p style="margin:0;font-size:15px;">
																					    		Never miss an update with the Tradespeoplehub App
																					    	</p>
																					    	<p style="margin:0;font-size:15px;padding-bottom: 10px; margin-top:10px;">
																					    		Download our App now
																					    	</p>
																						    <a href="'.$iosLink.'" style="text-align:center;display:inline-block; text-decoration:none!important; margin-right12px;" target="_blank">
																						        <img src="'.site_url().'/img/ios-appStore-black.png" style="max-width: 125px; width: 100%">
																						    </a>
																						    <a href="'.$androidLink.'" style="text-align:center;display:inline-block;text-decoration:none!important;" target="_blank">
																						        <img src="'.site_url().'/img/google-appStore-black.png" style="max-width: 125px; width: 100%">
																						    </a>
																						</div>
                                                                                        </td>
                                                                                     </tr>
																					<tr>
																						<td align="center" valign="top" style="background-color:#2b3133;color:white">
																							<table border="0" cellpadding="0" cellspacing="10" width="100%">
																								<tbody>
																									<tr>
																										<td align="left" valign="top" width="80%">
																											<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © ' . date('Y') . ' <a href="' . site_url() . '" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																										</td>																										
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</center>
							</div>
						</body>
					</html>';

			$mail->Body = $msg;

			if (!$mail->send()) {
				return 0;
			} else {
				return 1;
			}
		} else {
			return 0;
		}
	}

	function send_mail($toz, $sub, $body, $bcc = null, $via = null, $send_from = null)
	{

		try {
			$is_blocked = true;

			$users = $this->GetColumnName('users', array('email' => $toz), array('status', 'id', 'type'));

			if ($users) {
				if ($users['status'] == 1) {
					$is_blocked = false;
				}
                    if($users['type'] == 1){
                            $androidLink = 'https://play.google.com/store/apps/details?id=com.tradesprovider';
                            $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-trades/id6450201899';
                    }
                    if($users['type'] == 2){
                            $androidLink = 'https://play.google.com/store/apps/details?id=com.tradespeoplehub';
                            $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-homeowners/id6450202456 ';
                    }
			}

			// print_r($users); 
			if ($is_blocked) {

				$this->load->library('phpmailer_lib');


				$mail = $this->phpmailer_lib->load();


				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->CharSet = 'UTF-8';

				if ($send_from == 'support') {

					$mail->Host     = 'ssl0.ovh.net';
					$mail->Username = 'support@tradespeoplehub.co.uk';
					// $mail->Password = 'nTrK!2$LS@xb';
					$mail->Password = '8tmlFjHkWF';
					$mail->SMTPSecure = 'TSL';
					$mail->Port     = 587;
					$mail->setFrom('support@tradespeoplehub.co.uk', 'Tradespeoplehub');
				} else {

					$mail->Host     = 'ex4.mail.ovh.net';
					$mail->Username = 'info@tradespeoplehub.co.uk';
					// $mail->Password = '8QFlJNfx$%oH';
					//$mail->Password = 'hcIb36fN';
					$mail->Password = '@u)MXi,OM#g';
					$mail->SMTPSecure = 'STARTTLS';
					$mail->Port     = 587;

					if ($via) {
						$mail->setFrom('info@tradespeoplehub.co.uk', $via);
					} else {
						$mail->setFrom('info@tradespeoplehub.co.uk', 'Tradespeoplehub');
					}
				}

				$mail->addAddress($toz);

				$mail->Subject = $sub;

				$mail->isHTML(true);

				if ($bcc) {
					$mail->addBCC($bcc);
				}

				$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
											<tbody>
												<tr>
													<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="' . site_url() . '"><img src="' . site_url() . 'img/logo_invert.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" style="color:#444;font-size:14px">
																		' . $body . '
																		 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																		 <p style="margin:0;padding:10px 0px">The ' . Project . ' Team</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
	                                                <td style="background-color:#f1f1f1;">
													    <div style="text-align:center">
													    	<p style="margin:0;font-size:15px;">
													    		Never miss an update with the Tradespeoplehub App
													    	</p>
													    	<p style="margin:0;font-size:15px;padding-bottom: 10px; margin-top:10px;">
													    		Download our App now
													    	</p>
														    <a href="'.$iosLink.'" style="text-align:center;display:inline-block; text-decoration:none!important; margin-right12px;" target="_blank">
														        <img src="'.site_url().'/img/ios-appStore-black.png" style="max-width: 125px; width: 100%">
														    </a>
														    <a href="'.$androidLink.'" style="text-align:center;display:inline-block;text-decoration:none!important" target="_blank">
														        <img src="'.site_url().'/img/google-appStore-black.png" style="max-width: 125px; width: 100%">
														    </a>
														</div>
                                                    </td>
                                                </tr>
												<tr>
													<td align="center" valign="top" style="background-color:#2b3133;color:white">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" width="80%">
																		<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © ' . date('Y') . ' <a href="' . site_url() . '" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																	</td>
																	
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>';

				$mail->Body = $msg;

				if (!$mail->send()) {
					return 0;
				} else {
					return 1;
				}
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return false;
			//print_r($e);
		}
	}

	function send_mail_verifyemail($toz, $sub, $body, $bcc = null, $via = null)
	{

		$is_blocked = true;

		$users = $this->GetColumnName('users', array('email' => $toz), array('status', 'id', 'type'));

		if ($users) {
			if ($users['status'] == 1) {
				$is_blocked = false;
			}
                if($users['type'] == 1){
                        $androidLink = 'https://play.google.com/store/apps/details?id=com.tradesprovider';
                        $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-trades/id6450201899';
                }
                if($users['type'] == 2){
                        $androidLink = 'https://play.google.com/store/apps/details?id=com.tradespeoplehub';
                        $iosLink = 'https://apps.apple.com/us/app/tradespeoplehub-for-homeowners/id6450202456 ';
                }
		}


		if ($is_blocked) {

			$this->load->library('phpmailer_lib');


			$mail = $this->phpmailer_lib->load();


			$mail->isSMTP();
			$mail->Host =  'ssl0.ovh.net';
			$mail->SMTPAuth = true;
			$mail->Username = 'verify@tradespeoplehub.co.uk';
			// $mail->Password = 'nTrK!2$LS@xb';
			$mail->Password = '57Aw2qxFJI';
			$mail->SMTPSecure = 'tsl';
			$mail->Port     = 587;



			if ($via) {
				$mail->setFrom('info@tradespeoplehub.co.uk', $via);
			} else {
				$mail->setFrom('info@tradespeoplehub.co.uk', 'Tradespeoplehub');
			}

			$mail->addAddress($toz);

			$mail->Subject = $sub;

			$mail->isHTML(true);

			if ($bcc) {
				$mail->addBCC($bcc);
			}

			$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
											<tbody>
												<tr>
													<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="' . site_url() . '"><img src="' . site_url() . 'img/logo_invert.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" style="color:#444;font-size:14px">
																		' . $body . '
																		 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																		 <p style="margin:0;padding:10px 0px">The ' . Project . ' Team</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
                                                    <td style="background-color:#f1f1f1;">
													    <div style="text-align:center">
													    	<p style="margin:0;font-size:15px;">
													    		Never miss an update with the Tradespeoplehub App
													    	</p>
													    	<p style="margin:0;font-size:15px;padding-bottom: 10px; margin-top:10px;">
													    		Download our App now
													    	</p>
														    <a href="'.$iosLink.'" style="text-align:center;display:inline-block; text-decoration:none!important; margin-right12px;" target="_blank">
														        <img src="'.site_url().'/img/ios-appStore-black.png" style="max-width: 125px; width: 100%">
														    </a>
														    <a href="'.$androidLink.'" style="text-align:center;display:inline-block;text-decoration:none!important;" target="_blank">
														        <img src="'.site_url().'/img/google-appStore-black.png" style="max-width: 125px; width: 100%">
														    </a>
														</div>
                                                    </td>
                                                </tr>
												<tr>
													<td align="center" valign="top" style="background-color:#2b3133;color:white">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" width="80%">
																		<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © ' . date('Y') . ' <a href="' . site_url() . '" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																	</td>
																	
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>';

			$mail->Body = $msg;

			if (!$mail->send()) {
				return 0;
			} else {
				return 1;
			}
		} else {
			return 0;
		}
	}

	function send_mail_old($toz, $sub, $body, $bcc = null, $via = null)
	{

		//$this->load->library('email',null);

		$config = array();
		$config['protocol'] = "SMTP";
		$config['smtp_host'] = 'ex4.mail.ovh.net';
		$config['smtp_user'] = 'info@tradespeoplehub.co.uk';
		$config['smtp_pass'] = 'Uppsala20';
		$config['smtp_port'] = 587;
		$config['smtp_crypto'] = 'STARTTLS';
		$config['_smtp_auth'] = TRUE;
		$config['mailtype'] = "html";
		$config['charset'] = "utf-8";
		//$config['newline'] = "\r\n";
		//$config['wordwrap'] = TRUE;
		//$config['validate'] = FALSE;

		$this->email->initialize($config);

		if ($via) {
			$this->email->from(EMAIL_ID, $via);
		} else {
			$this->email->from(EMAIL_ID, 'Tradespeoplehub');
		}


		$this->email->to($toz);
		//$this->email->set_crlf("\r\n");	
		//$this->email->set_mailtype("html");	
		$this->email->subject($sub);

		if ($bcc) {
			$this->email->bcc($bcc);
		}

		$subject = $sub;
		$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
            <tbody>
              <tr>
                <td align="center" valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
                    <tbody>
                      <tr>
                        <td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr>
                                <td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="' . site_url() . '"><img src="' . site_url() . 'img/logo_invert.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" valign="top">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr>
                                <td align="left" valign="top" style="color:#444;font-size:14px">
																	' . $body . '
																	 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																	 <p style="margin:0;padding:10px 0px">The ' . Project . ' Team</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" style="background-color:#2b3133;color:white">
                          <table border="0" cellpadding="0" cellspacing="10" width="100%">
                            <tbody>
                              <tr>
                                <td align="left" valign="top" width="80%">
                                  <div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © ' . date('Y') . ' <a href="' . site_url() . '" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
                                </td>
                                
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>';

		$this->email->message($msg);

		$run  = $this->email->send();

		if ($run) {
			return 1;
		} else {
			return 0;
		}
	}

	function send_mail_file($mailto, $subject, $message, $mail_file, $bcc = null)
	{
		$filename = $mail_file;
		$path = '' . site_url() . 'img/verify';
		$file = $path . "/" . $mail_file;

		$content = file_get_contents($file);
		$content = chunk_split(base64_encode($content));

		// a random hash will be necessary to send mixed content
		$separator = md5(time());

		$eol = "\n";
		$from = EMAIL_ID;
		// main header (multipart mandatory)
		$headers = "From: $from" . $eol;

		$headers .= "MIME-Version: 1.0" . $eol;
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
		$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
		$headers .= "This is a MIME encoded message." . $eol;

		// message
		$body = "--" . $separator . $eol;
		$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
		$body .= "Content-Transfer-Encoding: 8bit" . $eol;
		$body .= $message . $eol;

		// attachment
		$body .= "--" . $separator . $eol;
		$body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
		$body .= "Content-Transfer-Encoding: base64" . $eol;
		$body .= "Content-Disposition: attachment" . $eol;
		$body .= $content . $eol;
		$body .= "--" . $separator . "--";


		if (mail($mailto, $subject, $body, $headers)) {
			//echo "mail send ... OK"; // or use booleans here
			return 1;
		} else {
			// echo "mail send ... ERROR!";
			//print_r( error_get_last() );
			return 0;
		}
	}
	public function get_education($table, $id)
	{
		$result = array();
		$sql = "SELECT * from $table where userid=$id  order by id desc";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	public function get_service_image($table, $id)
	{
		$result = array();
		$sql = "SELECT * from $table where service_id=$id order by id desc";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function get_service_files($table, $id, $type)
	{
		$id = intval($id);
    	$type = $this->db->escape($type); 

		$result = array();
		$sql = "SELECT * from $table where service_id=$id AND type=$type order by id desc";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getAllTypeServiceImage($table, $id)
	{
		$result = array();
		$sql = "SELECT * from $table where service_id=$id order by id desc";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function make_all_image($mainImg, $sliderImgs)
	{
		$slider = '';
		$image_path = FCPATH . 'img/services/' . $mainImg;
		if(isset($mainImg) && file_exists($image_path)){
			$mime_type = get_mime_by_extension($image_path);
            $is_image = strpos($mime_type, 'image') !== false;
            $is_video = strpos($mime_type, 'video') !== false;

			$main_image = base_url('img/services/').$mainImg;

			if ($is_image){
				$slider .= '<div><img src="'.$main_image.'" class="img-responsive"></div>';
			}

			if($is_video){
				$slider .= '<div><video controls autoplay src="'.$main_image.'" type="'.$mime_type.'"loop class="serviceVideo"></video></div>';
			}
		}

		if(count($sliderImgs)){
			foreach($sliderImgs as $img){
				$sliderImgPath = FCPATH . 'img/services/' . $img['image'];
				if(isset($img['image']) && file_exists($sliderImgPath)){
					$slider_mage = base_url('img/services/').$img['image'];
					$slider .= '<div><img src="'.$slider_mage.'" class="img-responsive"></div>';
				}
			}
		}
		return $slider;
	}

	public function get_extra_service($table, $ids, $sId)
	{
		$query = $this->db->query("SELECT * FROM $table WHERE id IN ($ids) and service_id = $sId");
		return $query->result_array();
	}	

	public function getAdminRow($table)
	{
		$query = $this->db->query("select * from $table where status=1");
		return $query->row_array();
	}

	public function get_all_tradesmen()
	{
		$query = $this->db->query("select * from users where type=1 order by id desc");
		return $query->result_array();
	}

	public function get_all_homeowner()
	{
		$query = $this->db->query("select * from users where type=2 order by id desc");
		return $query->result_array();
	}

	public function get_user_category($table, $cat_id)
	{
		$query = $this->db->query("select * from $table where FIND_IN_SET($cat_id, category)");
		return $query->result_array();
	}

	public function get_last_job()
	{
		$query = $this->db->query("SELECT * FROM `tbl_jobs` ORDER BY job_id DESC LIMIT 1");
		return $query->result_array();
	}

	public function get_user_jobs_bycatid($table, $category, $user_id = null, $limit = null)
	{

		if ($user_id) {
			$q = " and (direct_hired = 0 or (direct_hired = 1 and awarded_to = '" . $user_id . "'))";
		}

		$today = date('Y-m-d H:i:s');

		$sql = "SELECT * FROM tbl_jobs WHERE category IN ($category) and (status=0 or status=1 or status=2 or status=3) and is_delete=0 and direct_hired = 0 and DATE(job_end_date) >= DATE('" . $today . "') order by c_date desc";

		if ($limit) {
			$sql .= " limit " . $limit;
		}

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function get_user_jobs_bycatid1($table, $category)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobs WHERE category IN ($category) and (status=0 or status=1 or status=2 or status=3 or status=8 or status=9 or status=4 or status=7 or status=5) and is_delete=0 order by job_id desc");
		return $query->result_array();
	}
	public function get_trades_status($userid, $jobid)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobpost_bids WHERE bid_by=$userid and job_id=$jobid and (status=3 || status=7 || status=4)");
		return $query->result_array();
	}
	function get_trades_recent($userid)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobpost_bids WHERE bid_by=$userid and (status=3 || status=7 || status=4)");
		return $query->result_array();
	}

	public function get_complete_job_byid($table, $category)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobs WHERE category IN ($category) and status=5 and is_delete=0 order by job_id desc");
		return $query->result_array();
	}
	public function get_trades_working_progress($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table WHERE bid_by=$userid and (status=7 or status=3 or (status=0 and (select count(job_id) from tbl_jobs where tbl_jobs.job_id = $table.job_id and tbl_jobs.status=1) = 1)) order by id desc");
		return $query->result_array();
	}
	public function get_trades_completed($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table WHERE bid_by=$userid and status=4 order by id desc");
		return $query->result_array();
	}
	public function get_user_progress_bycatid($table, $category)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobs WHERE category IN ($category) and (status=7 or status=4) and is_delete=0 order by job_id desc");
		return $query->result_array();
	}
	public function get_user_jobs_bycat_id($table, $category)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobs WHERE category IN ($category) order by job_id desc");
		return $query->result_array();
	}
	public function get_job_posts_in_progress($table, $userid)
	{
		$query = $this->db->query("Select * from $table where userid=$userid and is_delete=0 and (status=7 or status=4) order by job_id desc");
		return $query->result_array();
	}

	public function get_job_bids($table, $job_id, $userid)
	{
		$query = $this->db->query("Select * from $table where posted_by=$userid and (status=7 or status=3 or status=4) and job_id=$job_id order by id desc");

		return $query->result_array();
	}
	public function get_trades_job_bids($table, $job_id, $userid)
	{
		$query = $this->db->query("Select * from $table where bid_by=$userid and job_id=$job_id order by id desc");
		return $query->result_array();
	}

	public function get_all_feedback($userid)
	{
		$query = $this->db->query("SELECT * FROM `rating_table` where rt_rateTo='$userid' ORDER BY tr_id DESC");
		return $query->result_array();
	}
	public function get_user_rewards($userid)
	{
		$query = $this->db->query("SELECT * FROM `transactions` where tr_userid='$userid' and tr_reward=1 ORDER BY tr_id DESC");
		return $query->result_array();
	}
	public function get_milestones_notpaid($post_id)
	{
		$query = $this->db->query("SELECT * FROM `tbl_milestones` where post_id='$post_id' and (status!=2 && status!=5 && status!=6) ORDER BY id DESC");
		return $query->result_array();
	}
	public function get_trade_feed($userid, $post_id)
	{
		$query = $this->db->query("SELECT * FROM `rating_table` where rt_rateBy='$userid' and rt_jobid=$post_id ORDER BY tr_id DESC");
		return $query->result_array();
	}
	public function get_home_feed($userid, $post_id)
	{
		$query = $this->db->query("SELECT * FROM `rating_table` where rt_rateBy='$userid' and rt_jobid=$post_id ORDER BY tr_id DESC");
		return $query->result_array();
	}
	public function get_last_feedback($id)
	{
		$query = $this->db->query("SELECT * FROM `rating_table` where rt_rateTo='$id' ORDER BY tr_id DESC LIMIT 1");
		return $query->result_array();
	}
	public function get_max_rate_user($table)
	{
		$query = $this->db->query("Select * from $table where average_rate = (select max(average_rate) from $table) and type=1 ORDER BY id DESC LIMIT 4");
		return $query->result_array();
	}
	public function get_feed_count($id)
	{
		$query = $this->db->query("SELECT count(*) as count FROM `rating_table` where rt_rateTo=$id");
		return $query->result_array();
	}

	public function get_cheild($id)
	{
		$clields = $this->common_model->get_all_data('category', array('cat_parent' => $id), 'cat_id');
		if (count($clields)) {
			echo '<ul >';
			foreach ($clields as $row) {
				echo '<li><a href="' . site_url('category_detail/' . $row['cat_id']) . '"><img src="' . site_url() . 'img/category/' . $row['cat_image'] . '"> ' . $row['cat_name'] . '</a>';
				$this->common_model->get_cheild($row['cat_id']);
				echo '</li>';
			}
			echo '</ul>';
		}
	}
	public function get_child_cat($id)
	{
		$clields = $this->common_model->GetAllData('category', array('cat_parent' => $id, 'is_delete' => 0), 'cat_id');
		if (count($clields)) {

			foreach ($clields as $row) {
				if (strtolower(trim($row['cat_name'])) == "others" || strtolower(trim($row['cat_name'])) == "other") {
					continue;
				}

				echo '<li><a href="' . site_url('' . $row['slug']) . '">' . $row['cat_name'] . '</a>';
				$this->common_model->get_child_cat($row['cat_id']);
				echo '</li>';
			}
		}
	}
	public function get_all_child($id, $arr = false)
	{
		$clields = $this->common_model->GetAllData('category', "cat_parent=$id and is_delete = 0", 'cat_id');
		//return $this->db->last_query();
		if (!$arr) {
			$arr = [];
		}

		if (count($clields)) {

			foreach ($clields as $row) {
				array_push($arr, $row['cat_id']);

				$this->common_model->get_all_child($row['cat_id'], $arr);
			}
		}
		//return $this->db->last_query();
		return $arr;
	}



	function get_all_category($table)
	{
		$this->db->where('is_delete', 0);
		if($table != 'service_category'){
			$this->db->order_by("cat_parent", "asc");	
		}		
		$this->db->order_by("cat_id", "asc");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	public function get_sub_category($table, $id, $is_active = 0)
	{
		$idType = gettype($id);

		$this->db->where('is_delete', 0);
		
		if($idType != 'array'){
			$this->db->where('cat_parent', $id);	
		}else{
			$this->db->where_in('cat_parent', $id);
		}
		
		if($is_active > 0){
			$this->db->where('is_activate', 1);
		}

		$this->db->order_by("cat_id", "asc");
		$this->db->select(['cat_id','cat_name','slug']);
		$query = $this->db->get($table);
		return $query->result_array();
	}

	public function get_ex_service($table, $id)
	{
		$this->db->where('category', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	public function get_faqs($table, $id)
	{
		$this->db->where('category_id', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	public function getTradesExService($id)
	{
		$this->db->where('service_id', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get('tradesman_extra_service');
		return $query->result_array();
	}

	public function getServiceFaqs($id)
	{
		$this->db->where('service_id', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get('service_faqs');
		return $query->result_array();
	}

	public function getServiceAvailability($id)
	{
		$this->db->where('service_id', $id);
		$this->db->order_by("id", "asc");
		$query = $this->db->get('service_availability');
		return $query->row_array();
	}

	function get_all_local_category($table)
	{

		$this->db->order_by("cat_parent", "asc");
		$this->db->order_by("cat_id", "asc");
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function get_parent_category($table, $limit=0, $is_active=0)
	{
		$this->db->where('is_delete', 0);
		$this->db->where('cat_parent', 0);
		if($is_active > 0){
			$this->db->where('is_activate', 1);
		}
		$this->db->order_by("cat_id", "asc");
		if($limit > 0){
			$this->db->limit($limit);
			$this->db->select(['cat_id','cat_name','slug']);
		}
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function getFullPathId($categoryId) {
		if (!$categoryId) {
            return '';
        }
        
        $category = $this->db->get_where('service_category', ['cat_id' => $categoryId])->row_array();
        
        if (!$category) {
            return '';
        }
        
        if (!$category['cat_parent']) {
            return $category['cat_name'];
        }
        
        $parentFullPath = $this->getFullPathId($category['cat_parent']);
        return $parentFullPath ? $parentFullPath . '-> ' . $category['cat_name'] : $category['cat_name'];
    }

	public function getAllChiledCat($table = 'category', $id)
	{
		return $this->common_model->GetAllData($table, array('cat_parent' => $id, 'is_delete' => 0), 'cat_id');
	}

	public function get_single_parent_category($table = 'category', $parent_id) {
		 $this->db->select('cat_id, cat_name, cat_parent, slug');
        $query = $this->db->get_where($table, array('cat_id' => $parent_id));
        return $query->row_array();
    }

	public function get_breadcrumb($table = 'category', $category_id) {
        $breadcrumb = [];
        $category = $this->common_model->GetSingleData($table,['cat_id'=>$category_id]);

        while ($category) {
            array_unshift($breadcrumb, $category);
            $category = $this->get_single_parent_category('service_category',$category['cat_parent']);
        }

        return $breadcrumb;
    }

	function get_all_packages($table)
	{
		$query = $this->db->query("Select * from $table where is_delete=0 and status=0 and id!=44 order by id asc");
		return $query->result_array();
	}

	function get_category($table, $id)
	{
		$query = $this->db->query("Select * from $table where cat_id=$id and is_delete=0 order by cat_id asc");
		return $query->result_array();
	}
	public function get_user_posts($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 order by job_id desc");
		return $query->result_array();
	}
	public function get_job_in_progress($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and (status=7 or status=4) order by job_id desc");
		return $query->result_array();
	}
	public function recent_work_in_progress($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and (status=7 or status=4) order by job_id desc");
		return $query->result_array();
	}
	public function get_open_projects($table, $id = null)
	{
		if ($id) {
			$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and (status=0 or status=1 or status=3 or status=8 or status=9) and direct_hired = 0 order by job_id desc");
		} else {
			$query = $this->db->query("Select * from $table where is_delete=0 and (status=0 or status=1 or status=3 or status=8 or status=9) and direct_hired = 0 order by job_id desc");
		}
		return $query->result_array();
	}
	public function get_posted_milestones($userid, $job_id)
	{
		$query = $this->db->query("SELECT count(*) as count FROM `tbl_milestones` where post_id=$job_id and created_by=$userid");
		return $query->result_array();
	}
	function get_completed_jobs($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and status=5 order by job_id desc");
		return $query->result_array();
	}
	function get_user_all_bids($table, $id)
	{
		$query = $this->db->query("Select * from $table where bid_by=$id order by id desc LIMIT 5");
		return $query->result_array();
	}
	function get_post_jobs($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and (status=0 or status=1 or status=2 or status=3 or status=8 or status=9) and direct_hired = 0 order by c_date desc");
		return $query->result_array();
	}
	function get_posted_jobs($table, $id)
	{
		$query = $this->db->query("Select * from $table where userid=$id and is_delete=0 and (status=0 or status=1 or status=2 or status=3 or status=4 or status=8) order by job_id desc");
		return $query->result_array();
	}
	function get_dispute_milestones()
	{
		$query = $this->db->query("SELECT * FROM `tbl_dispute` where ds_puser_id='" . $this->session->userdata('user_id') . "'");
		return $query->result_array();
	}
	function get_tradesdispute_milestones()
	{
		$query = $this->db->query("SELECT * FROM `tbl_dispute` where ds_buser_id='" . $this->session->userdata('user_id') . "'");
		return $query->result_array();
	}
	function get_total_bids($userid, $job_id)
	{
		$query = $this->db->query("SELECT count(*) as bids FROM `tbl_jobpost_bids` where posted_by=$userid and job_id=$job_id");
		return $query->result_array();
	}
	function get_job_posts($userid, $job_id)
	{
		$query = $this->db->query("SELECT * FROM `tbl_jobpost_bids` where posted_by=$userid and job_id=$job_id order by id desc");
		return $query->result_array();
	}
	function get_file_typedoc($job_id)
	{
		$query = $this->db->query("SELECT count(*) as doc FROM `job_files` where job_id=1 and type='text'");
		return $query->result_array();
	}
	function get_file_typevideo($job_id)
	{
		$query = $this->db->query("SELECT count(*) as video FROM `job_files` where job_id=1 and type='video'");
		return $query->result_array();
	}
	function get_file_typeimg($job_id)
	{
		$query = $this->db->query("SELECT count(*) as image FROM `job_files` where job_id=1 and type='image'");
		return $query->result_array();
	}

	function get_jobs_posts($userid, $job_id)
	{
		$query = $this->db->query("SELECT * FROM `tbl_jobpost_bids` where posted_by=$userid and job_id=$job_id and status=0 order by id desc");
		return $query->result_array();
	}
	function get_trades_proposalbyjobid($userid, $job_id)
	{
		$query = $this->db->query("SELECT * FROM `tbl_jobpost_bids` where job_id=$job_id and status=0 and bid_by = $userid order by id desc");
		return $query->result_array();
	}
	function get_avg_bid($userid, $job_id)
	{
		$query = $this->db->query("SELECT avg(bid_amount)as average_amt FROM `tbl_jobpost_bids` where job_id=$job_id");
		return $query->result_array();
	}
	function get_jobs_bid($post_id)
	{
		$query = $this->db->query("Select * from tbl_jobpost_bids where id=$post_id");
		return $query->result_array();
	}
	function get_all_categories($table, $id)
	{
		$query = $this->db->query("Select * from $table where cat_id!=$id and is_delete=0 order by cat_id asc");
		return $query->result_array();
	}
	function get_main_categories($table, $id)
	{
		$query = $this->db->query("Select * from $table where cat_id!=$id and cat_parent=0 and is_delete=0 order by cat_id asc");
		return $query->result_array();
	}
	function get_all_users($table, $count, $city, $amount1, $amount2)
	{
		$query = $this->db->query("SELECT * FROM $table where county=$count or city=$city or hourly_rate BETWEEN $amount1 AND ");
		return $query->result_array();
	}
	function get_job_users($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM `tbl_jobpost_bids` where posted_by=$userid order by id desc");
		return $query->result_array();
	}
	function get_job_details($job_id)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobs where job_id=$job_id");
		return $query->result_array();
	}
	function get_user_bids($table, $id)
	{
		$query = $this->db->query("SELECT * FROM $table where up_user='$id' and up_status=1 order by up_id DESC LIMIT 1");
		return $query->result_array();
	}
	function get_category_detailsbyname($table = 'category', $name, $limit = 0)
	{
		if($limit == 0){
			$query = $this->db->query("SELECT * FROM $table WHERE cat_name LIKE '%" . $this->db->escape_like_str($name) . "%'");
		}else{
			$query = $this->db->query("SELECT cat_id, cat_name FROM $table WHERE cat_parent = 0 AND cat_name LIKE '%" . $this->db->escape_like_str($name) . "%' LIMIT 3");
		}
		
		return $query->result_array();
	}

	function get_child_category($pId, $name){
		$query = $this->db->query("SELECT cat_id, cat_name FROM `service_category` where cat_parent = $pId AND cat_name LIKE '%" . $name . "%'");
		return $query->row_array();
	}

	function get_all_files($id)
	{
		$query = $this->db->query("SELECT * FROM `job_files` where job_id=$id");
		return $query->result_array();
	}
	function get_all_job_posts($table)
	{
		$query = $this->db->query("SELECT * FROM $table where (status=1 or status=2) and is_delete=0 ORDER BY id DESC LIMIT 10");
		return $query->result_array();
	}
	function get_user_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM users where id=$id");
		return $query->result_array();
	}
	function get_post_bids($table, $job_id = NULL, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where bid_by=$userid and job_id=$job_id");
		return $query->result_array();
	}
	function get_milestone_paid($userid, $post_id)
	{
		$query = $this->db->query("SELECT SUM(milestone_amount) as amount FROM `tbl_milestones` where userid=$userid and post_id=$post_id and (status=2 or is_dispute_to_traders = 1)");
		return $query->result_array();
	}
	function get_active_milestone($bid_id)
	{
		$query = $this->db->query("SELECT SUM(milestone_amount) as amount FROM `tbl_milestones` where bid_id=$bid_id");
		return $query->row_array();
	}
	function get_milestone_pending($userid, $post_id)
	{
		$query = $this->db->query("SELECT SUM(milestone_amount)as amount FROM `tbl_milestones` where userid=$userid and post_id=$post_id and (status=0 or status=3)");
		return $query->result_array();
	}
	function get_post_bidss($table, $job_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where posted_by=$userid and job_id=$job_id and (status=7 || status=3 || status=5 || status=10 || status=4)");
		return $query->result_array();
	}
	function get_all_userwithdrawal($userid)
	{
		$query = $this->db->query("SELECT * FROM tbl_withdrawal where wd_userid=$userid order by wd_id desc");
		return $query->result_array();
	}
	function get_all_withdrawal($table)
	{
		$query = $this->db->query("SELECT * FROM $table order by wd_id desc");
		// $query=$this->db->query("SELECT * FROM tbl_withdrawal order by wd_id desc");
		return $query->result_array();
	}
	function get_all_milestone_byjob_id($job_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM tbl_milestones where post_id=$job_id and created_by=$userid order by id desc");
		return $query->result_array();
	}

	function get_user_amount($userid, $job_id)
	{
		$query = $this->db->query("SELECT SUM(milestone_amount) as sum FROM tbl_milestones where post_id=$job_id and created_by=$userid order by id desc");
		return $query->result_array();
	}
	function get_milestone_request($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where userid=$userid and status=3 order by id desc");
		return $query->result_array();
	}
	function get_post_data($table, $id, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where id=$id and bid_by=$userid and (status=7 || status=3 || status=5 || status=10)");

		return $query->result_array();
	}
	function get_job_post($table, $job_id)
	{
		$query = $this->db->query("SELECT * FROM $table where job_id=$job_id");
		return $query->result_array();
	}

	function get_posts_by_id($table, $id)
	{
		$query = $this->db->query("SELECT * FROM $table where job_id=$id");
		return $query->result_array();
	}
	function get_commision()
	{
		$query = $this->db->query("SELECT * FROM `admin` where id=1");
		return $query->result_array();
	}
	function get_user_plans()
	{
		$query = $this->db->query("SELECT * FROM `user_plans` where up_user='" . $this->session->userdata('user_id') . "' and up_status=1 and DATE(up_enddate) >= DATE('" . date('Y-m-d') . "') ORDER BY up_id DESC LIMIT 1");
		return $query->result_array();
	}
	function get_awarded_trades($job_id)
	{
		$query = $this->db->query("SELECT * FROM tbl_jobpost_bids where  job_id=$job_id and status!=0 order by id desc");
		return $query->result_array();
	}
	function get_accepted_post($table, $job_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where  job_id=$job_id and posted_by=$userid and status!=0 order by id desc");
		return $query->result_array();
	}
	function get_post_release($table, $post_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where  post_id=$post_id and userid=$userid and status=2 order by id desc");
		return $query->result_array();
	}
	function get_bids($table, $job_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where  job_id=$job_id and posted_by=$userid order by id desc");
		return $query->result_array();
	}
	function get_paybids($table, $job_id, $userid = null)
	{
		$query = $this->db->query("SELECT * FROM $table where  job_id=$job_id and (status=7 || status=3 || status=5 || status=10 || status=4) order by id desc");
		return $query->result_array();
	}
	function get_rating($post, $userid)
	{
		$query = $this->db->query("SELECT * FROM rating_table where rt_jobid=$post and rt_rateBy=$userid order by tr_id desc");
		return $query->result_array();
	}
	function get_all_rating($post_id)
	{
		$query = $this->db->query("SELECT * FROM rating_table where  rt_jobid=$post_id order by tr_id desc");
		return $query->result_array();
	}

	function get_avg_rating($bid_by)
	{

		$query = $this->db->query("SELECT AVG(rt_rate)as avg FROM `rating_table` where rt_rateTo=$bid_by");
		return $query->result_array();
	}
	function get_milestone_byid($id)
	{
		$query = $this->db->query("SELECT * FROM tbl_milestones where id=$id");
		return $query->result_array();
	}
	function get_users_of_post($table, $id)
	{
		$query = $this->db->query("SELECT * FROM $table where id=$id");
		return $query->result_array();
	}
	function get_users_reviews($userid)
	{
		$query = $this->db->query("SELECT * FROM rating_table where rt_rateTo=$userid ORDER BY tr_id desc");
		return $query->result_array();
	}
	function get_bid_milestone($post_id, $userid)
	{
		$query = $this->db->query("SELECT * FROM tbl_milestones where post_id=$post_id and userid=$userid ORDER BY `id` DESC");
		return $query->result_array();
	}
	function get_all_chats($receiver_id, $sender_id, $post_id)
	{
		if($post_id == 0){
			$query = $this->db->query("SELECT * FROM chat WHERE ((sender_id = '$sender_id' and receiver_id = '$receiver_id') or (sender_id = '$receiver_id' and receiver_id = '$sender_id'))");	
		}else{
			$query = $this->db->query("SELECT * FROM chat WHERE ((sender_id = '$sender_id' and receiver_id = '$receiver_id') or (sender_id = '$receiver_id' and receiver_id = '$sender_id')) AND post_id = '$post_id'");
		}
		
		return $query->result_array();
	}
	function time_ago($timestamp)
	{
		$time_ago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60); // value 60 is seconds  
		$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
		$days = round($seconds / 86400); //86400 = 24 * 60 * 60;  
		$weeks = round($seconds / 604800); // 7*24*60*60;  
		$months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
		$years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
		if ($seconds <= 60) {
			return "Just Now";
		} else if ($minutes <= 60) {
			if ($minutes == 1) {
				return "one minute ago";
			} else {
				return "$minutes minutes ago";
			}
		} else if ($hours <= 24) {
			if ($hours == 1) {
				return "an hour ago";
			} else {
				return "$hours hrs ago";
			}
		} else if ($days <= 7) {
			if ($days == 1) {
				return "yesterday";
			} else {
				return "$days days ago";
			}
		} else if ($weeks <= 4.3) //4.3 == 52/12  
		{
			if ($weeks == 1) {
				return "a week ago";
			} else {
				return "$weeks weeks ago";
			}
		} else if ($months <= 12) {
			if ($months == 1) {
				return "a month ago";
			} else {
				return "$months months ago";
			}
		} else {
			if ($years == 1) {
				return "one year ago";
			} else {
				return "$years years ago";
			}
		}
	}
	function get_unread_msg($userid, $post_id, $rid)
	{
		$query = $this->db->query("select * from chat where post_id ='" . $post_id . "' and receiver_id = '" . $userid . "' and sender_id='" . $rid . "' and is_read='0'");
		return $query->result_array();
	}
	function get_unread_msges($userid, $post_id)
	{
		$query = $this->db->query("select count(*)as count from chat where post_id ='" . $post_id . "' and receiver_id = '" . $userid . "' and is_read='0'");
		return $query->result_array();
	}
	function get_trades_chat($table, $userid, $post_id)
	{
		$query = $this->db->query("SELECT * FROM $table where receiver_id=$userid and post_id=$post_id");
		return $query->result_array();
	}
	function get_all_notification($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where posted_by=$userid order by nt_id desc");
		return $query->result_array();
	}
	function get_total_spend()
	{
		$query = $this->db->query("SELECT SUM(tr_amount)as sum FROM transactions where tr_userid=" . $this->session->userdata('user_id') . " and tr_type=2");

		$amountSpend = $query->result_array();

		if (!empty($amountSpend) && $amountSpend[0]['sum']) {

			$amountSpend1 = $amountSpend[0]['sum'];
		} else {
			$amountSpend1 = 0;
		}
		$this->update('users', array('id' => $this->session->userdata('user_id')), array('spend_amount' => $amountSpend1));


		return $amountSpend;
	}
	function get_spend_amount_hisotry()
	{
		$query = $this->db->query("SELECT * FROM transactions where tr_userid=" . $this->session->userdata('user_id') . " and tr_type=2 ORDER BY tr_id DESC");
		return $query->result_array();
	}

	function get_notification_trades($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where nt_userId=$userid order by nt_id desc limit 15");
		return $query->result_array();
	}
	function get_notification_trades1($table, $userid)
	{
		$query = $this->db->query("SELECT * FROM $table where nt_userId=$userid order by nt_id desc limit 500");
		return $query->result_array();
	}
	function get_my_service($table, $userid, $status = 'all')
	{
		$statusWhere = '';
		if(!empty($status) && $status != 'all'){
			$statusWhere = 'AND ms.status = "'.$status.'"';
		}

		$query = $this->db->query("SELECT ms.*, c.cat_name, AVG(srt.rating) AS average_rating, COUNT(srt.rating) AS total_reviews
                           FROM $table ms
                           LEFT JOIN service_category c ON ms.category = c.cat_id
                           LEFT JOIN service_rating srt ON ms.id = srt.service_id
                           WHERE ms.user_id = $userid $statusWhere
                           GROUP BY ms.id
                           ORDER BY ms.id DESC 
                           LIMIT 500");

		return $query->result_array();
	}
	function get_all_service($table, $limit, $search = '')
	{
		$where_clause = "WHERE ms.status = 'active'";
		if (!empty($search)) {
		    $where_clause .= " AND (ms.service_name LIKE '%$search%' OR c.cat_name LIKE '%$search%' OR u.trading_name LIKE '%$search%')";
		}

		if($limit == 0){
			$query = $this->db->query("SELECT ms.*, c.cat_name, u.trading_name, u.profile, AVG(srt.rating) AS average_rating, COUNT(srt.rating) AS total_reviews
                           FROM $table ms
                           LEFT JOIN service_category c ON ms.category = c.cat_id
                           LEFT JOIN users u ON ms.user_id = u.id
                           LEFT JOIN service_rating srt ON ms.id = srt.service_id
                            $where_clause
                           GROUP BY ms.id, c.cat_name, u.trading_name, u.profile
                           ORDER BY average_rating DESC 
                           LIMIT 500");
		}else{
			$query = $this->db->query("SELECT ms.*, c.cat_name, u.trading_name, u.profile, AVG(srt.rating) AS average_rating, COUNT(srt.rating) AS total_reviews
                           FROM $table ms
                           LEFT JOIN service_category c ON ms.category = c.cat_id
                           LEFT JOIN users u ON ms.user_id = u.id
                           LEFT JOIN service_rating srt ON ms.id = srt.service_id
                            $where_clause
                           GROUP BY ms.id, c.cat_name, u.trading_name, u.profile
                           ORDER BY average_rating DESC 
                           LIMIT ".$limit);
		}
		return $query->result_array();
	}

	function get_service_main_category(){
		$query = $this->db->query("
		    SELECT sc.*, c.cat_id, c.cat_name
		    FROM service_category sc
		    LEFT JOIN category c ON sc.main_category = c.cat_id
		    WHERE sc.is_activate = ?
		    ORDER BY sc.main_category ASC
		    LIMIT 500
		",[1]);
		return $query->result_array();
	}

	public function getFirstRecord($table, $conditions = [], $joins = [], $select = '*') {
	    // Start building the query
	    $this->db->select($select); // Use the provided select statement or default to '*'
	    $this->db->from($table);

	    // Add joins
	    foreach ($joins as $join) {
	        $this->db->join($join['table'], $join['condition'], $join['type'] ?? 'LEFT');
	    }

	    // Add conditions
	    if (!empty($conditions)) {
	        $this->db->where($conditions);
	    }

	    // Add LIMIT 1 to get a single record
	    $this->db->limit(1);

	    // Execute the query
	    $query = $this->db->get();

	    // Return the result as an associative array
	    return $query->row_array();
	}

	function get_all_service_for_admin($table, $limit, $status = null){
	    $query = "SELECT ms.*, c.cat_name, u.trading_name, u.profile, AVG(srt.rating) AS average_rating, COUNT(srt.rating) AS total_reviews
	              FROM $table ms
	              LEFT JOIN service_category c ON ms.category = c.cat_id
	              LEFT JOIN users u ON ms.user_id = u.id
	              LEFT JOIN service_rating srt ON ms.id = srt.service_id";

	    if ($status !== null) {
	        $query .= " WHERE ms.status = '$status'";
	    }

	    $query .= " GROUP BY ms.id, c.cat_name, u.trading_name, u.profile
	                ORDER BY average_rating DESC 
	                LIMIT 500";

	    $result = $this->db->query($query);
	    return $result->result_array();
	}



	public function getServiceByCategoriesId($categoryId, $step, $sIds='')
	{
		$this->db->select('ms.*, c.cat_name, u.trading_name, u.profile, AVG(srt.rating) AS average_rating, COUNT(srt.rating) AS total_reviews');
		$this->db->from('my_services ms');
		$this->db->join('service_category c', 'ms.category = c.cat_id', 'left');
		$this->db->join('users u', 'ms.user_id = u.id', 'left');
		$this->db->join('service_rating srt', 'ms.id = srt.service_id', 'left');
		$this->db->where('ms.status', 'active');
		/*if($step == 1){
			$this->db->where('ms.category', $categoryId);
		}elseif($step == 2){
			$this->db->where('ms.sub_category', $categoryId);
		}else{
			$this->db->where('ms.service_type', $categoryId);
		}*/

		if($step == 1){
		    $this->db->where('ms.category', $categoryId);
		}elseif($step == 2){
		    $this->db->where('FIND_IN_SET('.$this->db->escape($categoryId).', ms.sub_category) > 0');
		}else{
		    $this->db->where('FIND_IN_SET('.$this->db->escape($categoryId).', ms.service_type) > 0');
		}	

		if(!empty($sIds)){
			$this->db->where_in('ms.id', $sIds);
		}		

		$this->db->group_by('ms.id, c.cat_name, u.trading_name, u.profile');
		$this->db->order_by('average_rating', 'DESC');
		$this->db->limit(500);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getRatingsWithUsers($service_id, $limit=0, $offset = 0) {
        $this->db->select('service_rating.*, users.f_name as rate_by_fname, users.l_name as rate_by_lname, users.profile as rate_by_profile, users2.f_name as rate_to_fname, users2.l_name as rate_to_lname,, users2.profile as rate_to_profile');

        $this->db->from('service_rating');
        $this->db->where('service_rating.service_id', $service_id);
        $this->db->join('users', 'service_rating.rate_by = users.id', 'left');
        $this->db->join('users as users2', 'service_rating.rate_to = users2.id', 'left');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

	function get_chat_list($id)
	{
		// $query = $this->db->query("SELECT *, MAX(id) FROM `chat` WHERE sender_id = $id or receiver_id = $id group by post_id order by MAX(id) desc");

		$query = $this->db->query("SELECT *, MAX(id) FROM `chat` WHERE sender_id = $id or receiver_id = $id order by MAX(id) desc");
		return $query->result_array();
	}
	function get_unread_by_sid_rid($sender, $receiver, $post_id)
	{
		$query = $this->db->query("select COUNT(id) as total from chat where is_read = 0 and receiver_id = $sender and sender_id = $receiver and post_id=$post_id");
		return $query->result_array();
	}

	function sumcollum_value($sumC, $table, $where = null)
	{
		$this->db->select_sum($sumC);
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		$query = $this->db->get();
		$this->db->last_query();
		return $query->row_array();
	}
	function get_dispute_count($mile_in, $disputed_by)
	{
		$query = $this->db->query("SELECT count(*) as counts FROM `tbl_dispute` where mile_id=$mile_in and disputed_by=$disputed_by");
		return $query->result_array();
	}
	function get_admin_settings()
	{
		$query = $this->db->query("SELECT * FROM admin_settings");
		return $query->result();
	}
	function get_all_milestone_invoice($userid, $type)
	{
		if ($type == 1) {
			$query = $this->db->query("select tbl_milestones.*, tbl_jobs.title as job_title, tbl_jobs.project_id, tbl_jobs.userid as puserid from tbl_milestones inner join tbl_jobs on tbl_milestones.post_id = tbl_jobs.job_id where tbl_milestones.userid = $userid and (tbl_milestones.status = 2 or (tbl_milestones.status = 6 and tbl_milestones.is_dispute_to_traders = 1)) order by tbl_milestones.updated_at desc, tbl_milestones.id desc");
			//$query=$this->db->query("SELECT * from tbl_milestones where userid = $userid and (status = 2 or (status = 6 and is_dispute_to_traders = 1)) order by id desc");
		} else {
			$query = $this->db->query("select tbl_milestones.*, tbl_jobs.title as job_title, tbl_jobs.project_id, tbl_jobs.userid as puserid from tbl_milestones inner join tbl_jobs on tbl_milestones.post_id = tbl_jobs.job_id where tbl_milestones.posted_user = $userid and (tbl_milestones.status = 2 or (tbl_milestones.status = 6 and tbl_milestones.is_dispute_to_traders = 1)) order by tbl_milestones.updated_at desc, tbl_milestones.id desc");
			//$query=$this->db->query("SELECT * from tbl_milestones where posted_user = $userid and (status = 2 or (status = 6 and is_dispute_to_traders = 1)) order by id desc");
		}
		return $query->result_array();
	}

	function join_records($table, $joins, $where = false, $select = '*', $ob = false, $obc = 'DESC')
	{
		/* https://github.com/rahimnagori/cheat-sheet/blob/master/ci_dynamic_join.php */
		$this->db->select($select);
		$this->db->from($table);
		foreach ($joins as $join) {
			$this->db->join($join[0], $join[1], $join[2]);
		}
		if ($where) $this->db->where($where);
		if ($ob) $this->db->order_by($ob, $obc);
		$query = $this->db->get();
		return $query->result_array();
	}

	function fetch_records($table, $where = false, $select = false, $singleRecords = false, $orderBy = false, $orderDirection = 'DESC', $groupBy = false, $where_in_key = false, $where_in_value = false)
	{
		if ($where) $this->db->where($where);
		if ($where_in_key) $this->db->where_in($where_in_key, $where_in_value);
		if ($select) $this->db->select($select);
		if ($groupBy) $this->db->group_by($groupBy);
		if ($orderBy) $this->db->order_by($orderBy, $orderDirection);
		$query = $this->db->get($table);
		return ($singleRecords) ? $query->row_array() : $query->result_array();
	}

	function get_pagination_records($table, $limit, $start, $where = false)
	{
		if ($where) $this->db->where($where);
		$this->db->limit($limit, $start);
		$query = $this->db->get($table);
		return $query->result_array();
	}

	function check_review_invitation_count($invite_by)
	{
		$where['job_id'] = 0;
		$where['invite_by'] = $invite_by;
		$where['status'] = 1;
		$invitationReviewCount = $this->newgetRows('review_invitation', $where);
		return (count($invitationReviewCount) >= 3) ? true : false;
	}
	public function GetSingleData($table, $where = null, $ob = null, $obc = 'desc')
	{
		if ($where) {
			$this->db->where($where);
		}
		if ($ob) {
			$this->db->order_by($ob, $obc);
		}
		$query = $this->db->get($table);
		if ($query->num_rows()) {
			return $query->row_array();
		} else {
			return false;
		}
	}
	public function GetAllData($table, $where = null, $ob = null, $obc = 'DESC', $limit = null, $offset = null, $select = null)
	{

		if ($select) {
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}

		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		if ($ob) {
			$this->db->order_by($ob, $obc);
		}
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get();
		// echo   $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}

	// public function send_and_insert_notifi($table , $dataArr = array()){

	//      if(!empty($dataArr)){ 
	//         // print_r($dataArr); die;
	//          $other = (@$dataArr['other']) ? $dataArr['other'] : array('click_action' => base_url());
	//          $user = $this->get_single_data('web_notification' , ['user_id' => $dataArr['user_id'] ]);

	//          if(isset($dataArr['device_id']) && !empty($dataArr['device_id']))
	//          {
	//            	$user['device_id'] = $dataArr['device_id'];
	//          }
	//          $insert['user_id'] = $dataArr['user_id'];
	//          $insert['message'] = $dataArr['message'];
	//          $insert['behalf_of'] = ($dataArr['behalf_of']) ? $dataArr['behalf_of'] : 0;

	//          $insert['other'] = serialize($other);
	//          $insert['is_read'] = $dataArr['is_read'];
	//          $insert['create_date'] = date('Y-m-d H:i:s');
	//          //$insert['updated_at'] = date('Y-m-d H:i:s');
	// 			//echo '<pre>';
	// 			//print_r($insert);

	//          if(isset($dataArr['onlyPushNot']) && $dataArr['onlyPushNot']==true) {
	//              $run = true;
	//          } else {
	//              $run = $this->insert('notifications',$insert);
	//          }

	//          if($run){
	//              if(isset($user['device_id']) && !empty($user['device_id'])){

	//                  $arr['title'] = $insert['message'];
	//                  $arr['deviceToken'] = $user['device_id'];
	//                  $arr['other'] = $other;
	//                  $this->AndroidNotification($arr);

	// 		// $user_device_ids = $this->GetColumnName('device_ids',['user_id'=>$dataArr['user_id']],['device_id'],true);
	// 		// //echo '<pre>';
	// 		// //print_r($user_device_ids); 

	// 		// if(!empty($user_device_ids)){
	// 		// 	foreach($user_device_ids as $user_device_id){
	// 		// 		if($user['device_id'] != $user_device_id->device_id){
	// 		// 			$arr['deviceToken'] = $user_device_id->device_id;
	// 		// 			$this->AndroidNotification($arr);
	// 		// 		}
	// 		// 		//array_push($device_ids,$user_device_id->device_id);

	// 		// 	}
	// 		// }
	//              }
	//              return true;
	//          } else {
	//              return false;
	//          }
	//      }
	//  }

	public function AndroidNotification($data = array())
	{
		if (!empty($data)) {

			try {

				$users = $this->get_single_data('users', ['id' => $data['behalf_of']]);
				if (!empty($users['profile'])) {
					$image = site_url() . 'img/profile/' . $users['profile'];
				} else {
					$image = site_url() . 'img/profile/dummy_profile.jpg';
				}

				$signal_array['notification'] = array(
					'title' => $data['title'],
					'body' => $data['message'],
					'click_action' => $data['link'],
					'sound' => 'default',
					//'image'=>$image,
					'icon' => $image,
				);

				$signal_array['webpush'] = array(
					'fcm_options' => array(
						'link' => $data['link']
					)
				);

				$other['openURL'] = $data['link'];
				$devices = $this->get_all_data('web_notification', ['user_id' => $data['user_id']]);
				$device_id = [];
				foreach ($devices as $key => $value) {
					array_push($device_id, $value['device_id']);
				}
				// echo $data['link'];
				// print_r($device_id);
				if (!empty($device_id)) {

					$signal_array['registration_ids'] = $device_id;
					$signal_array['data'] = $data['other'];
					$signal_array1 = $signal_array;
					//print_r($signal_array1);
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => json_encode($signal_array1),
						CURLOPT_HTTPHEADER => array(
							"authorization: key=AAAAHsNmzs4:APA91bFi3lRrjuM7-ODueFuMeWjhHmk-PlM8M2WROyMShkgfs0RnVckw87mrSVE5udX9exW_PzU5H5TQm-AT_64_-oufXfh49reaK__MPrnFwjwAVvACFbplCA0Gf4SMxMjelQSd4YhS",
							"content-type: application/json"
						),
					));

					$response = curl_exec($curl);

					$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
					$txt = $response;
					fwrite($myfile, $txt);
					fclose($myfile);

					//print_r($signal_array1); print_r($response);

					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
						return false;
					} else {
						//echo $response;
						return $response;
					}
				}
			} catch (Exception $e) {
				print_r($e);
			}
		} else {
			return false;
		}
	}

	public function OneSignalNotification($data = array())
	{
		if (!empty($data)) {
			$content = array(
				"en" => $data['message']
			);

			$headings = array(
				"en" => $data['title']
			);
		

			$appID = ($data['is_customer']) ? CustomerOneSignalAppID : ProviderOneSignalAppID;
			$keyvalue = ($data['is_customer']) ? CustomerRestAPIKey : ProviderRestAPIKey;
			$hashes_array = array();

			$pushdata = $data['pushdata'];

			if((!isset($data['player_id']) || empty($data['player_id'])) && isset($data['user_id']) && !empty($data['user_id'])){ //either send player id or user id
				$playerdata = $this->GetColumnName('user_notification', ['user_id' => $data['user_id']], ['player_id']);
				if($playerdata && $playerdata['player_id']){
					$data['player_id'] = $playerdata['player_id'];
				}
			}

			if(!isset($data['player_id']) || empty($data['player_id'])){
				return false;
			}

			$fields = array(
				'app_id' => $appID,
				'contents' => $content,
				'headings' => $headings,
				'include_player_ids' => [$data['player_id']],
				'data' => array("action_json" => $pushdata),
				"ios_badgeType" => 'Increase',
				"ios_badgeCount" => 1,
				"priority" => 10,
			);
			//print_r($fields);
			$fields = json_encode($fields);
			//print_r($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Content-Type: application/json; charset=utf-8",
				"Authorization: Basic $keyvalue"
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$response = curl_exec($ch);
			curl_close($ch);
			return json_decode($response);
		} else {
			return false;
		}
	}

	public function checkFile($image){
		$image_path = FCPATH . $image;

		if (isset($image) && file_exists($image_path)) {
		    $mimeType = mime_content_type($image_path);

		    // Define allowed image and video MIME types
		    $imageMimeTypes = ['image/jpg','image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];
		    $videoMimeTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime', 'video/webm'];

		    if (in_array($mimeType, $imageMimeTypes)) {
		        // It's an image
		        $mediaTag = '<img src="' . base_url() . $image . '" alt="service" style="width: 65px;" />';
		        $type = 'image';
		    } elseif (in_array($mimeType, $videoMimeTypes)) {
		        // It's a video
		        $mediaTag = '<video width="100" height="62" controls autoplay>
		                        <source src="' . base_url() . $image . '" type="' . $mimeType . '">
		                        Your browser does not support the video tag.
		                     </video>';
		        $type = 'video';
		    } else {
		        // It's neither an image nor a video
		        $mediaTag = '<img src="' . base_url('img/default-image.jpg') . '" alt="service" style="width: 65px;" />';
		        $type = 'image';
		    }
		} else {
		    // File does not exist, show default image
		    $mediaTag = '<img src="' . base_url('img/default-image.jpg') . '" alt="service" style="width: 65px;" />';
		    $type = 'image';
		}

		echo json_encode(['file_type' => $type,'mediaTag' => $mediaTag]);
	}

	public function get_total_sale($user_id){
		$query = $this->db->query("
	        SELECT
	            SUM(so.total_price - so.service_fee) AS total_net_price
	        FROM
	            service_order so
	        JOIN
	            my_services s ON so.service_id = s.id
	        WHERE
	            s.user_id = $user_id");

    	return $query->row_array();
	}

	public function get_total_open_order($user_id){
		$query = $this->db->query("
        SELECT
            COUNT(*) AS total_orders
        FROM
            service_order so
        JOIN
            my_services s ON so.service_id = s.id
        WHERE
            s.user_id = $user_id
            AND so.status IN ('placed', 'pending')");

    	return $query->row_array();
	}

	public function getActiveOrder($table, $user_id, $limit=0){
		if($limit != 0){
			$query = $this->db->query("SELECT so.*, u.f_name, u.l_name, u.profile, ms.service_name
                           FROM $table so
                           LEFT JOIN users u ON so.user_id = u.id
                           LEFT JOIN my_services ms ON ms.id = so.service_id
                           WHERE so.status IN ('placed', 'pending') AND ms.user_id = $user_id
                           ORDER BY so.id DESC
                           LIMIT 500");		
		}else{
			$query = $this->db->query("SELECT so.*, u.f_name, u.l_name, u.profile, ms.service_name
                           FROM $table so
                           LEFT JOIN users u ON so.user_id = u.id
                           LEFT JOIN my_services ms ON ms.id = so.service_id
                           WHERE so.status IN ('placed', 'pending') AND ms.user_id = $user_id
                           ORDER BY so.id DESC
                           LIMIT $limit");	
		}
		return $query->result_array();
	}

	public function getAllOrder($table, $user_id, $status='', $limit=0){
		$statusWhere = '';
		if(!empty($status) && $status != 'all'){
			$statusWhere = 'AND so.status = "'.$status.'"';
		}

		if($limit != 0){
			$query = $this->db->query("SELECT so.*, u.f_name, u.l_name, u.profile, ms.service_name, ms.image, ms.video
               	FROM $table so
               	LEFT JOIN users u ON so.user_id = u.id
               	LEFT JOIN my_services ms ON ms.id = so.service_id
               	WHERE ms.user_id = $user_id $statusWhere
               	ORDER BY so.id DESC
               	LIMIT $limit");		
		}else{
			$query = $this->db->query("SELECT so.*, u.f_name, u.l_name, u.profile, ms.service_name, ms.image, ms.video
               	FROM $table so
               	LEFT JOIN users u ON so.user_id = u.id
               	LEFT JOIN my_services ms ON ms.id = so.service_id
               	WHERE ms.user_id = $user_id $statusWhere
               	ORDER BY so.id DESC
               	LIMIT 500");	
		}
		return $query->result_array();
	}

	public function getAllOrderForAdmin($table){
		$query = $this->db->query("SELECT so.*, u.f_name, u.l_name, u.profile, ms.service_name, ms.image, ms.video
               	FROM $table so
               	LEFT JOIN users u ON so.user_id = u.id
               	LEFT JOIN my_services ms ON ms.id = so.service_id
               	ORDER BY so.id DESC
               	LIMIT 500");
		return $query->result_array();
	}

	public function getTotalStatusOrder($user_id){
		$query = $this->db->query("
			    SELECT
			    	COUNT(*) AS total_all,
			        SUM(CASE WHEN so.status IN ('placed', 'pending') THEN 1 ELSE 0 END) AS total_placed,
			        SUM(CASE WHEN so.status = 'active' THEN 1 ELSE 0 END) AS total_active,
			        SUM(CASE WHEN so.status = 'complete' THEN 1 ELSE 0 END) AS total_completed,
			        SUM(CASE WHEN so.status = 'cancel' THEN 1 ELSE 0 END) AS total_cancelled
			    FROM
			        service_order so
			    JOIN
			        my_services s ON so.service_id = s.id
			    WHERE
			        s.user_id = $user_id");

			return $query->row_array();
	}

	public function getTotalStatusService($user_id){
		$query = $this->db->query("
			    SELECT
			    	COUNT(*) AS total_all,
			        SUM(CASE WHEN ms.status = 'approval_pending' THEN 1 ELSE 0 END) AS total_approval_pending,
			        SUM(CASE WHEN ms.status = 'required_modification' THEN 1 ELSE 0 END) AS total_required_modification,
			        SUM(CASE WHEN ms.status = 'draft' THEN 1 ELSE 0 END) AS total_draft,
			        SUM(CASE WHEN ms.status = 'denied' THEN 1 ELSE 0 END) AS total_denied,
			        SUM(CASE WHEN ms.status = 'paused' THEN 1 ELSE 0 END) AS total_paused,
			        SUM(CASE WHEN ms.status = 'active' THEN 1 ELSE 0 END) AS total_active
			    FROM
			        my_services ms
			    WHERE
			        ms.user_id = $user_id");

			return $query->row_array();
	}

	public function changeDateFormat($targetDateString){
		$now = time();
		$targetDate = strtotime($targetDateString);
		$differenceInSeconds = $targetDate - $now;

		// Calculate years, days, hours, minutes
		$years = floor($differenceInSeconds / (365 * 24 * 60 * 60));
		$days = floor(($differenceInSeconds % (365 * 24 * 60 * 60)) / (24 * 60 * 60));
		$hours = floor(($differenceInSeconds % (24 * 60 * 60)) / (60 * 60));
		$minutes = floor(($differenceInSeconds % (60 * 60)) / 60);

		// Construct the readable string
		if ($years > 0) {
		    $remainingTime = "$years years, $days days to submit";
		} elseif ($days > 0) {
		    $remainingTime = "$days days, $hours hours to submit";
		} elseif ($hours > 0) {
		    $remainingTime = "$hours hours, $minutes minutes to submit";
		} elseif ($minutes > 0) {
		    $remainingTime = "$minutes minutes to submit";
		} else {
		    $remainingTime = "Less than a minute to submit";
		}

		echo $remainingTime;
	}

	public function recentlyViewedService($user_id){
		$this->db->select('ms.*');
		$this->db->from('my_services ms');
		$this->db->join('recently_viewed_service rvs', 'ms.id = rvs.service_id', 'LEFT');
		$this->db->where('DATE(rvs.created_at)', 'CURDATE()', false);
		$this->db->where('ms.user_id',$user_id);
		$this->db->order_by('rvs.id', 'DESC');
		$this->db->group_by('ms.id');
		$this->db->limit(6);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_service_details($table, $slug){
		$query = $this->db->query("SELECT ms.*, 
                                  c.cat_name,
                                  l.city_name,
                                  u.trading_name, 
                                  u.profile, 
                                  AVG(srt.rating) AS average_rating, 
                                  COUNT(DISTINCT srt.id) AS total_reviews, 
                                  (SELECT COUNT(*) FROM recently_viewed_service rvs WHERE rvs.service_id = ms.id) AS total_views,
                                  (SELECT COUNT(*) FROM service_likes serl WHERE serl.service_id = ms.id) AS total_likes,
                                  (SELECT COUNT(*) FROM service_order sero WHERE sero.service_id = ms.id) AS total_orders
                           FROM $table ms
                           LEFT JOIN service_category c ON ms.category = c.cat_id
                           LEFT JOIN location l ON ms.location = l.id
                           LEFT JOIN users u ON ms.user_id = u.id
                           LEFT JOIN service_rating srt ON ms.id = srt.service_id
                           WHERE ms.slug = '$slug' AND ms.status = 'active'
                           GROUP BY ms.id, c.cat_name, u.trading_name, u.profile
                           ORDER BY average_rating DESC");

		return $query->row_array();
	}

	public function get_service_sub_category($id){
		$query = $this->db->query("
		    SELECT sc.*, c.cat_id, c.cat_name
		    FROM service_category c
		    WHERE sc.cat_id = ?
		    ORDER BY sc.main_category ASC
		    LIMIT 500
		", array($id));

		return $query->result_array();
	}

	function findMatchingItem($item, $secondArray) {
	    foreach ($secondArray as $secondItem) {
	        if ($item['id'] == $secondItem['ex_service_id']) {
	            return $secondItem;
	        }
	    }
	    return null;
	}

	public function getAttributes($aIds)
	{
		$this->db->select('sa.*');
		$this->db->from('service_attribute sa');
		
		if(!empty($aIds)){
			$this->db->where_in('sa.id', $aIds);
		}		
		$this->db->limit(500);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function countResponseTime($rId){
	    $query = $this->db->query("
		    SELECT AVG(TIMESTAMPDIFF(SECOND, ch1.create_time, ch2.create_time)) / 3600 AS avg_response_time_hours
		    FROM chat ch1
		    INNER JOIN chat ch2 
		        ON ch1.receiver_id = ch2.sender_id 
		        AND ch1.sender_id = ch2.receiver_id 
		        AND ch2.create_time > ch1.create_time
		    WHERE ch1.receiver_id = $rId 
		    AND ch1.is_read = 1
		    AND ch2.id = (
		        SELECT MIN(id) 
		        FROM chat 
		        WHERE receiver_id = ch2.receiver_id 
		        AND sender_id = ch2.sender_id 
		        AND create_time > ch1.create_time
		    )
		");

		return $query->row_array();
	}

	public function getServiceType($sIds)
	{
		$this->db->select('c.*');
		$this->db->from('category c');
		
		if(!empty($sIds)){
			$this->db->where_in('c.cat_id', $sIds);
		}		

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_last_order_record($table, $id, $column, $ordType){
		if(!empty($id)){
			$this->db->where_in('service_id', $id);		
			$this->db->where('status', 'completed');
			$this->db->order_by($column, $ordType);
			$this->db->limit(1);
			$query = $this->db->get($table);
			return $query->result_array();	
		}else{
			return [];
		}
	}

	public function get_service_avg_rating($id){
		$query = $this->db->query("SELECT avg(rating)as average_rating FROM `service_rating` where rate_to=$id");
		return $query->result_array();
	}

    public function get_referral_code_rating($user_id) {
        // Get the referral code of the specific user
        $this->db->select('unique_id');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $referral_code = $result->unique_id;

            // Count the number of times this referral code has been used
            $this->db->select('COUNT(*) as total_usage');
            $this->db->from('users');
            $this->db->where('referral_code', $referral_code); // assuming 'referred_by' stores the referral code used during registration
            $query = $this->db->get();
            $usage_result = $query->row();

            // Get the total number of users
            $this->db->select('COUNT(*) as total_users');
            $this->db->from('users');
            $query = $this->db->get();
            $total_users_result = $query->row();

            // Calculate the rating out of 5
            $rating = 0;
            if ($usage_result && $total_users_result && $total_users_result->total_users > 0) {
                $average_usage = $usage_result->total_usage / $total_users_result->total_users;
                $rating = $average_usage * 5;
            }

            return round($rating, 2); // rounding to 2 decimal places
        }

        return 0;
    }
}
