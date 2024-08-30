<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wallet extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->check_login();
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		//require_once('application/libraries/stripe/init.php');
		require_once('application/libraries/stripe-php-7.49.0/init.php');
	}
	
	public function check_login() {
		if(!$this->session->userdata('user_logIn')){
			redirect('login');
		}
	}

  public function newStripeSuccess(){
		
		$data = $this->input->post('data');
		$actual_amt = $this->input->post('actual_amt');
		
		$user_id = $this->session->userdata('user_id');
		$email = $this->session->userdata('email');
		
		$paymentStatus = 'error';
		
		
		
		if(isset($_POST['cardID'])){
			$user = $this->common_model->get_userDataByid($user_id);
			
			$cardData = $this->common_model->GetColumnName('save_cards',['id'=>$_POST['cardID'],'user_id'=>$user_id]);
			
			if(!$cardData){
				$subject = "Unable to fund Your Tradespeople Hub account."; 
						
				$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

				$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Declined reason: We did not found valid payment method</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$this->common_model->send_mail($user['email'],$subject,$html);
				
				$response = array(
					'status' => 0,
					'msg' => 'Transaction has been failed.'
				);
				
				echo json_encode($response); exit();
			}
			
			//charge saved card
			$secret_key = $this->config->item('stripe_secret');
			$statement_descriptor = 'Diposit in wallet';
			\Stripe\Stripe::setApiKey($secret_key);
			
			try {
              
        
        $data = \Stripe\PaymentIntent::create([
          'amount' => $actual_amt*100,
          'currency' => 'GBP',
          'customer' => $cardData['customer_id'],
          'description' => $statement_descriptor,
          'payment_method' => $cardData['payment_method'],
          'off_session' => true,
          'confirm' => true,
        ]);
				
				$data = $data->jsonSerialize();
        //$output['chargeJson'] = $chargeJson.$id;
				//$data = json($data);
				
				if(!empty($data) && $data['status']=='succeeded'){
					$paymentStatus = 'succeeded';
				}
				
				
			} catch(Exception $e) {
        
        $subject = "Unable to fund Your Tradespeople Hub account."; 
						
				$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

				$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">Declined reason: We did not found valid payment method</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
				
				$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
				
				$this->common_model->send_mail($user['email'],$subject,$html);
				
				$response = array(
					'status' => 0,
					'msg' => 'Transaction has been failed.'
				);
				
				echo json_encode($response); exit();
        
      }
			
		} else if(isset($_POST['data'])){
			$data = $this->input->post('data');
			if(!empty($data) && $data['paymentIntent']['status']=='succeeded'){
				$paymentStatus = 'succeeded';
				$customerID = $this->input->post('customerID');
				
				
				$payment_method = $data['paymentIntent']['payment_method'];
			
				$stripe_data['customerID'] = $customerID;
				$stripe_data['payment_method'] = $payment_method;
			}
		}
		
		if($paymentStatus=='succeeded'){
			
			
			
			//$itemPrice = $data['paymentIntent']['amount']/100;
			$itemPrice = $actual_amt;
			$txnID = md5(rand(1000,999).time());
			
			
			$user = $this->common_model->get_userDataByid($user_id);
		
			$itemId  = 'Diposit in wallet';
 
			$setting = $this->common_model->get_single_data('admin',array('id'=>1));
			
			$type = $this->session->userdata('type');
			
					
			// Order details    
			$amount = $itemPrice;
			$status = 1;
					
			$insert['tr_userid'] = $user_id;
			$insert['tr_message'] = '<i class="fa fa-gbp"></i>'.$amount.' has deposited in your wallet by credit card.</b>';
			$insert['tr_amount'] = $amount;
			$insert['tr_type'] = 1;
			$insert['tr_transactionId'] = $txnID;
			$insert['tr_status'] = $status;
			$insert['tr_paid_by']='Stripe';
			$insert['is_deposit']=1;
					
			$run = $this->common_model->insert('transactions',$insert);
					
			$amount1 = $user['u_wallet']+$amount;
			$u_data['u_wallet'] = $amount1;
			$this->common_model->update('users',array('id'=>$user_id),$u_data);
			
			$store = '2';//0
			$store .= '&Card';//1
			$store .= '&'.$amount;//2
			$store .= '&'.$user_id;//3
			$store .= '&'.date('Y-m-d');//4
			$store .= '&'.$txnID;//5
			$store .= '&<i class="fa fa-gbp"></i>'.$amount.' was credited to your account.';//6
						
			$inv = $this->common_model->insert('invoice',array('data'=>$store));
			
			$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' was credited to your account. <a target="_blank" href="'.site_url().'view-invoice/'.$inv.'">View invoice!</a>';
		
			$this->common_model->insert_notification($user_id,$nt_message);
			
			$subject = "Your TradespeopleHub account funded successfully.";

			$html = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
			
			if($type==1){
			
				$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now quote jobs using those funds.</p>';
			
			} else {
				$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now create milestones and pay your tradesperson on our platform using those funds.</p>';
			}
			
			$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$amount.'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
			
			if($type==1){
				$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
			} else {
				$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			}
			
			$runs1=$this->common_model->send_mail($user['email'],$subject,$html);
			
			if($user['is_pay_as_you_go']==1){
	
				$this->session->set_flashdata('errorss','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully. You can now start winning jobs. Don´t also forget to verify your account.</div>');
				
				$this->common_model->update('users',array('id' => $user_id), array('is_pay_as_you_go'=>2,'free_trial_taken'=>1));
				
				$this->send_pay_as_you_go_welcome_email($user['email'],$user['f_name'], $user['u_token']);
				
			} else {
				$this->session->set_flashdata('errorss','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully!</div>');
			}
			//echo $this->session->flashdata('errorss');
			/*$serialize = serialize($stripe_data);
			
			$check_card = $this->common_model->GetColumnName('billing_details',array('user_id' => $user_id), array('id'));
			
			if($check_card){
				$this->common_model->update('billing_details',array('user_id'=>$user_id),array('stripe_data'=>$serialize));
			} else {
				$this->common_model->insert('billing_details',array('stripe_data'=>$serialize,'user_id'=>$user_id));
			}*/
			
			if($user['type']==1){
				$check_card = $this->common_model->GetColumnName('save_cards',array('user_id' => $user_id), array('id'));
				
				if($check_card==false){
					$this->Add_a_Card_to_Verify_your_Account($user['email'],$user['f_name']);
				}
			}
			
			$response = array(
				'status' => 1,
				'tranId' => $run
			);
			
			
		} else {
			
			$subject = "Unable to fund Your Tradespeople Hub account."; 
						
			$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

			$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Declined reason: We did not found valid payment method</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$this->common_model->send_mail($user['email'],$subject,$html);
			
			$response = array(
				'status' => 0,
				'msg' => 'Transaction has been failed.'
			);
		}
		
		// Return response
		echo json_encode($response);
		
	}

  public function saveCards(){
		
		$payment_method = $this->input->post('payment_method');
		$customerID = $this->input->post('customerID');

		$card_u_name = $this->input->post('card_u_name');
		$user_id = $this->session->userdata('user_id');
		$email = $this->session->userdata('email');
		$cardDetail = GetCardDetailByApi($payment_method);


		if($cardDetail && $user_id){
			$saveCard = [];
			$saveCard['user_id'] = $user_id;
			$saveCard['exp_year'] = $cardDetail['exp_year'];
			$saveCard['exp_month'] = $cardDetail['exp_month'];
			$saveCard['last4'] = $cardDetail['last4'];
			$saveCard['brand'] = $cardDetail['brand'];
			
			$checkCard = $this->common_model->GetColumnName('save_cards',$saveCard,array('id'));
			
			
			$saveCard['u_name'] = (!empty($cardDetail['card_u_name']))? $cardDetail['card_u_name'] : $card_u_name;
			$saveCard['customer_id'] = $customerID;
			$saveCard['payment_method'] = $payment_method;
			$saveCard['country'] = $cardDetail['country'];
			$saveCard['status'] = 1;
			$saveCard['updated_at'] = date('Y-m-d H:i:s');
			$saveCard['email'] = $email;
			
			if($checkCard){
				$this->common_model->update_data('save_cards',['id'=>$checkCard['id']],$saveCard);
			} else {
				$saveCard['created_at'] = $saveCard['updated_at'];
				$this->common_model->insert('save_cards',$saveCard);
			}
			
			
		}
			
		
		echo json_encode(array('status'=>'error'));
		
	}




  public function newStripeError(){
		
		$data = $this->input->post('data');
			
		$error = $data['error']['message'];
			
		$user_id = $this->session->userdata('user_id');
		$user = $this->common_model->get_userDataByid($user_id);
		
		$subject = "Unable to fund Your Tradespeople Hub account."; 
						
		$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

		$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Declined reason: '.$error.'</p>';
		$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
		
		$this->common_model->send_mail($user['email'],$subject,$html);
		
		$response = array(
			'status' => 0,
			'msg' => 'Transaction has been failed.'
		);
	
		// Return response
		echo json_encode($response);
		
	}
		
  public function BankTransfer(){
    // $this->form_validation->set_rules('contryId', 'Country Name','trim|required');
    $this->form_validation->set_rules('bank_account_name','Bank account name','trim|required');
    $this->form_validation->set_rules('date_of_deposit','Date of deposit','trim|required');
    $this->form_validation->set_rules('reference','Reference number','trim|required');
    
    if($this->form_validation->run()){
      // $insert['contryId'] = $this->input->post('contryId');
      $insert['bank_account_name'] = $this->input->post('bank_account_name');
      $insert['date_of_deposit'] = $this->input->post('date_of_deposit');
      $insert['reference'] = $this->input->post('reference');
      $insert['amount'] = $this->input->post('bank_amount');
      $insert['create_date'] = date('Y-m-d H:i:s');
      $insert['update_date'] = date('Y-m-d H:i:s');
      $insert['status'] = 0;
      $admin = $this->common_model->GetColumnName('admin',array('id'=>1), array('processing_fee'));
      $comission = ($insert['amount']*$admin['processing_fee'])/100;
      $insert['admin_percent'] = $admin['processing_fee'];
      $insert['user_amount'] = $insert['amount']-$comission;
      $insert['admin_amt'] = $comission;
      $insert['userId'] = $this->session->userdata('user_id');
      $run = $this->common_model->insert('bank_transfer',$insert);

      if($run){
        $json['status'] = 1;
        $this->session->set_flashdata('msg1','<div class="alert alert-success">Bank transfer deposit request has been submitted successfully. Head over to your bank account and pay to Tradespeoplehub account. Our account information is given below. Your money will be available for milestones payments with 24-48 hrs of payment.</div>');
      } else {
        $json['status'] = 0;
        $json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
      }
    } else {
      $json['status'] = 0;
      $json['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
    }

    echo json_encode($json);
  }

  public function wallet(){
  	$setting=$this->common_model->get_all_data('admin');
		if($setting[0]['payment_method'] == 0){
			redirect('dashboard');
		}
    if(isset($_GET['reject_reason']) && !isset($_GET['type'])){
      $whereRejectReason['id'] = $_GET['reject_reason'];
      $result = $this->common_model->fetch_records('homeowner_fund_withdrawal', $whereRejectReason);
      if(!empty($result)){
        $this->session->set_flashdata('reject_reason', $result[0]['reason']);
      }
      redirect('wallet');
    }
    if(isset($_GET['reject_reason']) && isset($_GET['type'])){
      if($_GET['type'] == 'bank_transfer'){
        $whereRejectReason['id'] = $_GET['reject_reason'];
        $result = $this->common_model->fetch_records('bank_transfer', $whereRejectReason);
        if(!empty($result)){
          $this->session->set_flashdata('reject_reason', $result[0]['reject_reason']);
        }
        redirect('wallet');
      }
    }
    $data['user_profile']=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
    $data['setting'] = $this->common_model->get_single_data('admin',array('id'=>1));
    $data['get_region'] = $this->common_model->getRows('tbl_region');
    
    $data['bank_transfer_history'] = $this->common_model->get_all_data('bank_transfer',array('userId'=>$this->session->userdata('user_id')),'id');
		
		$amountSpend = $this->common_model->get_total_spend($user_id);
		
		if(!empty($amountSpend) && $amountSpend[0]['sum']){
	
			$amountSpend = $amountSpend[0]['sum'];
		} else {
			$amountSpend = 0;
		}
		$data['amountSpend'] = $amountSpend;
		
    $this->load->view('site/wallet',$data);
  }

	public function transaction_history(){ 
		$user_id = $this->session->userdata('user_id');
		
		$page['transactions'] = $this->common_model->get_all_data('transactions',array('tr_userid'=>$user_id),'tr_id');
		$this->load->view('site/transaction_history',$page);
	}
	public function spendamount_history()
	{
		$user_id = $this->session->userdata('user_id');
		
		$page['transactions'] = $this->common_model->get_spend_amount_hisotry($user_id);
		
		$this->load->view('site/transaction_history1',$page);
	}
	public function plan_purchase_history()
	{
			$user_id = $this->session->userdata('user_id');
		
		$page['plans'] = $this->common_model->get_all_data('user_plans',array('up_user'=>$user_id),'up_id');
		$this->load->view('site/purchase_plan_history',$page);
	}

	public function paypal_deposite(){
		$response = array();
   
		// Get token, card and item info
		$itemPrice  = $this->input->post('itemPrice');
		$itemId  = $this->input->post('itemId');
		$orderID  = $this->input->post('orderID');
		$txnID  = $this->input->post('txnID');
	
		// Order details    
		$amount = $itemPrice;
		$user_id = $this->session->userdata('user_id');
		$token = md5(rand(1000,999).time());
							
		$user = $this->common_model->get_userDataByid($user_id);
    //if($user['is_payment_verified'] != 1) $u_data['is_payment_verified'] = 1;
		$amount1 = $user['u_wallet']+$amount;
		$u_data['u_wallet'] = $amount1;
		$run = $this->common_model->update('users',array('id'=>$user_id),$u_data);
		
		// If order inserted successfully
		if($run){
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payment/".$txnID,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					'accept: application/json',
					'accept-language: en_US',
					'authorization: Bearer A21AAFRndsFs96xicJBC3a6cLtb6XKJcrkdV4arUyC4DKcW_Q3XbapDUcNKrl5eIjTvdSJ35ZM-c1gU6Bjw1Prsbezj0yWeTA',
					'content-type: application/json'
				),
			));

			$response1 = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				$curl_status = false;
			} else {
				$curl_status = true;
			}
			
			if($curl_status){
				$response1 = json_decode($response1);
				
				$payer_e = $response1->payer->payer_info->email;
				
				$isExist = $this->common_model->GetColumnName('billing_details', array('user_id' => $user_id),array('id'));
				
				if($isExist){
				$run = $this->common_model->update('billing_details',array('id' => $isExist['id']), array('paypal_id'=>$payer_e));
				}else{
					$data['user_id'] = $user_id;
					$data['paypal_id'] = $payer_e;
					$data['created_at'] = date("Y-m-d H:i:s");
					$run = $this->common_model->insert('billing_details', $data);
				}
			}
			
			
			
			
			$insert['tr_userid'] = $user_id;
			$insert['tr_message'] = '<i class="fa fa-gbp"></i>'.$amount.' has deposited in your wallet by PayPal.</b>';
			$insert['tr_amount'] = $amount;
			$insert['tr_type'] = 1;
			$insert['tr_transactionId'] = $txnID;
			$insert['tr_status'] = 1;
			$insert['tr_paid_by']='Paypal';
			$insert['is_deposit']=1;
			
			$run2 = $this->common_model->insert('transactions',$insert);
								
			$store = '2';//0
			$store .= '&Paypal';//1
			$store .= '&'.$amount;//2
			$store .= '&'.$user_id;//3
			$store .= '&'.date('Y-m-d');//4
			$store .= '&'.$txnID;//5
			$store .= '&<i class="fa fa-gbp"></i>'.$amount.' was credited to your account.';//6
						
			$inv = $this->common_model->insert('invoice',array('data'=>$store));
			
			$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' was credited to your account. <a target="_blank" href="'.site_url().'view-invoice/'.$inv.'">View invoice!</a>';
			
			$subject = "Your TradespeopleHub account funded successfully.";
		
			$html = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now create milestones and pay your tradesperson on our platform using those funds.</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$amount.'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Paypal</p>';
			$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$runs1=$this->common_model->send_mail($user['email'],$subject,$html);
			
			if($user['is_pay_as_you_go']==1){
			
				$this->session->set_userdata('succ123','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully. You can now start winning jobs. Don´t also forget to verify your account.</div>');
				
				$this->common_model->update('users',array('id' => $user_id), array('is_pay_as_you_go'=>2,'free_trial_taken'=>1));
				
				$this->send_pay_as_you_go_welcome_email($user['email'],$user['f_name'], $user['u_token']);
				
			} else {
				$this->session->set_userdata('succ123','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully!</div>');
			}
			
			if($user['type']==1){
				
				$check_card = $this->common_model->GetColumnName('billing_details',array('user_id' => $user_id,'card_number !=' => ''), array('id'));
				
				if($check_card==false){
					$this->Add_a_Card_to_Verify_your_Account($user['email'],$user['f_name']);
				}
			}
			
			$response = array(
				'status' => 1,
				'tranId' => $run2
			);
		}else{
			$response = array(
				'status' => 0,
				'msg' => 'Transaction has been failed',
			);
		}
		// Return response
		echo json_encode($response);
			
	}
		function activate_plan($uid,$status)
	{
		$userdata['plan_status']=$status;
			$where_array=array('up_id'=>$uid);
		$result=$this->common_model->update('user_plans',$where_array,$userdata); 
		redirect('plan-purchase-history');
	}

	public function deposite_stripe() {
		
		$secret_key = $this->config->item('stripe_secret');
		$response = array();
		
		$user_id = $this->session->userdata('user_id');
		$user = $this->common_model->get_userDataByid($user_id);
		
		if(!empty($_POST['stripeToken'])){
			// Get token, card and item info
			$token  = $this->input->post('stripeToken');
			$itemPrice  = $this->input->post('itemPrice');
			$currency  = $this->input->post('currency');
			$itemId  = $this->input->post('itemId');
    
			// Include Stripe PHP library
			//require_once('application/libraries/stripe/init.php');
    
			// Set api key
			\Stripe\Stripe::setApiKey($secret_key);
    
			// Add customer to stripe
			$customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
			));
			
			$setting = $this->common_model->get_single_data('admin',array('id'=>1));
			
			$type = $this->session->userdata('type');
			
			if($setting['processing_fee'] > 0 && $type == 2){
				$fee = $itemPrice*$setting['processing_fee']/100;
				$itemPrice2 = $fee + $itemPrice;
			} else {
				$itemPrice2 = $itemPrice;
			}
			
			try {
				// Charge a credit or a debit card
				$charge = \Stripe\Charge::create(array(
					'customer' => $customer->id,
					'amount'   => $itemPrice2*100,
					'currency' => $currency,
					'description' => $itemId,
				));
    
				// Retrieve charge details
				$chargeJson = $charge->jsonSerialize();
			
				//print_r($chargeJson);
				// Check whether the charge is successful
				if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
					
					// Order details    
					$amount = $itemPrice;
					$currency = $chargeJson['currency'];
					$txnID = $chargeJson['balance_transaction'];
					$status = ($chargeJson['status']=='succeeded')?1:0;
					$orderID = $chargeJson['id'];
					$payerName = $chargeJson['source']['name'];
					$session_user = $this->session->userdata('user_id');
					$token = md5(rand(1000,999).time());
									
					
					$insert['tr_userid'] = $user_id;
					$insert['tr_message'] = '<i class="fa fa-gbp"></i>'.$amount.' has deposited in your wallet by credit card.</b>';
					$insert['tr_amount'] = $amount;
					$insert['tr_type'] = 1;
					$insert['tr_transactionId'] = $txnID;
					$insert['tr_status'] = $status;
					$insert['tr_paid_by']='Stripe';
					$insert['is_deposit']=1;
					
					$run = $this->common_model->insert('transactions',$insert);
					
					// If order inserted successfully
					if($run && $status){
						
						
						//if($user['is_payment_verified'] != 1) $u_data['is_payment_verified'] = 1;
						$amount1 = $user['u_wallet']+$amount;
						$u_data['u_wallet'] = $amount1;
						$this->common_model->update('users',array('id'=>$user_id),$u_data);
						
						$store = '2';//0
						$store .= '&Paypal';//1
						$store .= '&'.$amount;//2
						$store .= '&'.$user_id;//3
						$store .= '&'.date('Y-m-d');//4
						$store .= '&'.$txnID;//5
						$store .= '&<i class="fa fa-gbp"></i>'.$amount.' was credited to your account.';//6
									
						$inv = $this->common_model->insert('invoice',array('data'=>$store));
						
						$nt_message = '<i class="fa fa-gbp"></i>'.$amount.' was credited to your account. <a target="_blank" href="'.site_url().'view-invoice/'.$inv.'">View invoice!</a>';
					
						
						$this->common_model->insert_notification($user_id,$nt_message);
						
						$subject = "Your TradespeopleHub account funded successfully.";
			
						$html = '<p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
						
						$html .= '<p style="margin:0;padding:10px 0px">A fund has been deposited to your TradespeopleHub account. You can now create milestones and pay your tradesperson on our platform using those funds.</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Deposited amount: £'.$amount.'</p>';
						$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
						$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
						
						$runs1=$this->common_model->send_mail($user['email'],$subject,$html);
						
						if($user['is_pay_as_you_go']==1){
				
							$this->session->set_userdata('succ123','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully. You can now start winning jobs. Don´t also forget to verify your account.</div>');
							
							$this->common_model->update('users',array('id' => $user_id), array('is_pay_as_you_go'=>2,'free_trial_taken'=>1));
							
							$this->send_pay_as_you_go_welcome_email($user['email'],$user['f_name'], $user['u_token']);
							
						} else {
							$this->session->set_userdata('succ123','<div class="alert alert-success"><i class="fa fa-gbp"></i>'.$amount.' has been added to your wallet successfully!</div>');
						}
						
						if($user['type']==1){
					
							$check_card = $this->common_model->GetColumnName('billing_details',array('user_id' => $user_id,'card_number !=' => ''), array('id'));
							
							if($check_card==false){
								$this->Add_a_Card_to_Verify_your_Account($user['email'],$user['f_name']);
							}
						}
						
						$response = array(
							'status' => 1,
							'tranId' => $run
						);
					}else{
						$response = array(
							'status' => 0,
							'msg' => 'Transaction has been failed'
						);
					}
				}else{
					$response = array(
						'status' => 0,
						'msg' => 'Transaction has been failed.'
					);
					
					$err_s = $chargeJson['failure_code'];
				}
			
			} catch(Stripe_CardError $e) {
				$err_s = $e->getMessage();
			} catch (Stripe_InvalidRequestError $e) {
				// Invalid parameters were supplied to Stripe's API
				$err_s = $e->getMessage();
			} catch (Stripe_AuthenticationError $e) {
				// Authentication with Stripe's API failed
				$err_s= $e->getMessage();
			} catch (Stripe_ApiConnectionError $e) {
				// Network communication with Stripe failed
				$err_s = $e->getMessage();
			} catch (Stripe_Error $e) {
				// Display a very generic error to the user, and maybe send
				// yourself an email
				$err_s = $e->getMessage();
			} catch (Exception $e) {
				// Something else happened, completely unrelated to Stripe
				$err_s = $e->getMessage();
			}
			
		}else{
			$response = array(
				'status' => 0,
				'msg' => 'Transaction has been failed.'
			);
			$err_s = "Invalid stripe token.";
		}
		
		if($response['status']==0){
			
			$subject = "Unable to fund Your Tradespeople Hub account."; 
						
			$html = '<p style="margin:0;padding:10px 0px">Hi ' . $user['f_name'] .',</p>';

			$html .= '<p style="margin:0;padding:10px 0px">Unfortunately! We unable to deposit fund to your Tradespeople Hub account. You can´t be able to create milestones and pay your tradesperson on our platform.</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">Declined reason: '.$err_s.'</p>';
			$html .= '<p style="margin:0;padding:10px 0px">Deposit method: Card</p>';
			
			$html .= '<p style="margin:0;padding:10px 0px">View our Homeowner Help page or contact our customer services if you have any specific questions using our service.</p>';
			
			$this->common_model->send_mail($user['email'],$subject,$html);
		}

		// Return response
		echo json_encode($response);
		
	}
	function withdraw_fund()
	{
		$get_user=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		
		$get_commision=$this->common_model->get_commision(); 
		
		$get_commision = $get_commision[0]; 
		
		
		$amount=$this->input->post('amount');
		$u_wallet = $get_user['u_wallet'];
		$withdrawable_balance = $get_user['withdrawable_balance'];
		
	
		if($amount > $withdrawable_balance)
		{
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">Please check your wallet amount first. Your withdrawal amount can not be more than £'.$withdrawable_balance.'</div>';

		}
		else
		{
			
			if($amount > $get_commision['p_max_w'] || $amount < $get_commision['p_min_w']){
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Withdrawal amount must be more than £'.$get_commision['p_min_w'].' and less than £'.$get_commision['p_max_w'].'!</div>';
				
			} else {
			
				$user_id=$this->session->userdata('user_id');
			
				
				//$userdata1['u_wallet']=$get_user['u_wallet']-$amount;
				$userdata1['withdrawable_balance']=$get_user['withdrawable_balance']-$amount;
				$where_array1=array('id'=>$user_id);
				
				$results=$this->common_model->update_data('users',$where_array1,$userdata1);
				
				$insert3['tr_userid'] = $user_id;
				$insert3['tr_message'] = 'You have withdrawal <i class="fa fa-gbp"></i>'.$amount.' from your wallet.</b>';
				$insert3['tr_amount'] = $amount;
				$insert3['tr_type'] = 2;
				$insert3['tr_status'] = 1;
					
				$run2 = $this->common_model->insert('transactions',$insert3);
				$u_name=$get_user['f_name'].' '.$get_user['l_name'];
				
				$email=$get_commision['email'];
				$username=$get_commision['username'];
				$subject = $u_name." has requested to withdraw amount"; 
				$contant= 'Hello '.$username.'<br><br>';
			
				$contant.='<p class="text-center">'.$u_name.' has requested to withdraw £'.$amount.' amount.<a href="'.site_url().'withdrawal-history"> Click Here </a>to accept or reject the request.</p>';
					
				$json['sf'] = $this->common_model->send_mail($email,$subject,$contant);
		
				$insert['wd_userid'] = $this->session->userdata('user_id');
				$insert['wd_amount'] = $amount;
				$insert['wd_create'] = date('Y-m-d H:i:s');
				$insert['wd_payment_type'] = 1;
				$insert['wd_pay_email'] = $this->input->post('email');
				$run2 = $this->common_model->insert('tbl_withdrawal',$insert);
				
				$subject = 'You recently requested a withdrawal of funds to your paypal account';  
				$html = '<p style="margin:0;padding:20px 0px">Fund Withdrawal Request!</p>';
				$html .= '<p style="margin:0;padding:20px 0px">Hi '.$get_user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:20px 0px">We’ve received your request to withdraw money from your Tradespeoplehub account to your Paypal account and are on it.</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Requested withdrawal amount: £'.$amount.'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Paypal username: '.$insert['wd_pay_email'].'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Transaction ID: '.md5($run2).'</p>';
		
				
				$html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
						
				$runsss=$this->common_model->send_mail($get_user['email'],$subject,$html);
				
				
				$json['status'] = 1;
				$this->session->set_userdata('success121','<p class="alert alert-success">Your request of withdrawal has been submitted successfully. Please wait for admin response.</p>');
			}
		}

				
		echo json_encode($json);
	}
	function bank_transfer()
	{
		$get_users=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
		
		$get_commision=$this->common_model->get_commision(); 
		
		$get_commision = $get_commision[0];
		
		$amount=$this->input->post('amount');
		
		$u_wallet = $get_users['u_wallet'];
		$withdrawable_balance = $get_users['withdrawable_balance'];
	
		
		if($amount > $withdrawable_balance)
		{
			$json['status'] = 0;
			$json['msg'] = '<div class="alert alert-danger">Please check your wallet amount first. Your withdrawal amount can not be more than £'.$withdrawable_balance.'</div>';
		}
		else
		{
			if($amount > $get_commision['p_max_w'] || $amount < $get_commision['p_min_w']){
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Withdrawal amount must be more than £'.$get_commision['p_min_w'].' and less than £'.$get_commision['p_max_w'].'!</div>';
				
			} else {
				$user_id=$this->session->userdata('user_id');
		
				//$userdata1['u_wallet']=$get_users['u_wallet']-$amount;
				$userdata1['withdrawable_balance']=$get_users['withdrawable_balance']-$amount;
				$where_array1=array('id'=>$user_id);
				
				$results=$this->common_model->update_data('users',$where_array1,$userdata1);
				
				$insert3['tr_userid'] = $user_id;
				$insert3['tr_message'] = 'You have withdrawal <i class="fa fa-gbp"></i>'.$amount.' from your wallet.</b>';
				$insert3['tr_amount'] = $amount;
				$insert3['tr_type'] = 2;
				$insert3['tr_status'] = 1;
					
				$run2 = $this->common_model->insert('transactions',$insert3);
					
					
					
				$u_name=$get_users['f_name'].' '.$get_users['l_name'];
	
				$email=$get_commision['email'];
				$username=$get_commision['username'];
				$subject = $u_name." has requested to withdraw amount"; 
				$contant= 'Hello '.$username.'<br><br>';

				$contant.='<p class="text-center">'.$u_name.' has requested to withdraw £'.$amount.' amount.<a href="'.site_url().'withdrawal-history"> Click Here </a>to accept or reject the request.</p>';

				$this->common_model->send_mail($email,$subject,$contant);
				
				$wd_bankid = $this->input->post('wd_bankid');
				
				$bank_detail=$this->common_model->get_single_data('wd_bank_details',array('id'=>$wd_bankid,'wd_user_id'=>$user_id));
				//print_r($wd_bankid);
				
				$insert['wd_userid'] = $this->session->userdata('user_id');
				$insert['wd_amount'] = $amount;
				$insert['wd_create'] = date('Y-m-d H:i:s');
				$insert['wd_payment_type'] = 2;
				$insert['wd_bankid'] = $wd_bankid;
				//$insert['wd_account_holder'] = $this->input->post('wd_account_holder');
				//$insert['wd_bank'] = $this->input->post('wd_bank');
				//$insert['wd_account'] = $this->input->post('wd_account');
				//$insert['wd_ifsc_code'] = $this->input->post('wd_ifsc_code');
				$run2 = $this->common_model->insert('tbl_withdrawal',$insert);
				
				$subject = "Withdrawal Request Processed: Payment on the way."; 
				$html = '<p style="margin:0;padding:20px 0px"><b>Withdrawal request processed!</b></p>';
				$html .= '<p style="margin:0;padding:20px 0px">Hi '.$get_users['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:20px 0px">The request to withdraw money from your Tradespeoplehub account to your bank account is processed and the money paid.</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Paid amount: £'.$amount.'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Bank name: '.$bank_detail['wd_bank'].'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Sort code: '.$bank_detail['wd_ifsc_code'].'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Bank account: '.$bank_detail['wd_account'].'</p>';
				$html .= '<p style="margin:0;padding:5px 0px">Transaction ID: '.md5($run2).'</p>';

				$html .= '<p style="margin:0;padding:20px 0px">It could take 1-2 business days for the money to appear in your bank account, depending on your bank. If it takes longer, please contact your bank.</p>';
				$html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';
						
				$runsss=$this->common_model->send_mail($get_users['email'],$subject,$html);
				
				
				$json['status'] = 1;
				$this->session->set_userdata('success121','<p class="alert alert-success">Your request of withdrawal has been submitted successfully. Please wait for admin response.</p>');
			}
		}

				
		echo json_encode($json);
	}

	function add_bank()
	{
	
		
		
		$user_id=$this->session->userdata('user_id');

		$insert = [];
		// $insert['wd_user_id'] = $user_id;
		$insert['wd_account_holder'] = $this->input->post('wd_account_holder');
		$insert['wd_bank'] = $this->input->post('wd_bank');
		$insert['wd_account'] = $this->input->post('wd_account');
		$insert['wd_ifsc_code'] = $this->input->post('wd_ifsc_code');
		$insert['account_holder_address'] = $this->input->post('account_holder_address');
		$insert['paypal_email_address'] = $this->input->post('paypal_email_address');

		$insert['created_at'] = date('Y-m-d H:i:s');
		$insert['updated_at'] = date('Y-m-d H:i:s');

		$check =$this->common_model->get_single_data('wd_bank_details', array('wd_user_id'=>$user_id));
		if(!empty($check)){
				$this->common_model->update('wd_bank_details',array('wd_user_id'=>$user_id),$insert);
				$this->session->set_flashdata('message','<p class="alert alert-success">Bank detail updated successfully.</p>');
		}else{
			$insert['wd_user_id'] =$user_id;
			$this->common_model->insert('wd_bank_details', $insert);
			$this->session->set_flashdata('message','<p class="alert alert-success">Bank detail added successfully.</p>');

		}


		// $this->common_model->insert('wd_bank_details',$insert);
		
		
		$json['status'] = 1;
			
				
		echo json_encode($json);
	}
	function delete_bank($id=null)
	{
	
		
		$user_id=$this->session->userdata('user_id');

		$insert = [];
		$insert['wd_user_id'] = $user_id;
		$insert['id'] = $id;
		$this->common_model->delete($insert,'wd_bank_details');
		
		
		$json['status'] = 1;
		$this->session->set_flashdata('message','<p class="alert alert-success">Bank detail deleted successfully.</p>');
		redirect('manage-bank');
	}
	
	function edit_bank()
	{
		
		
		
		$user_id=$this->session->userdata('user_id');

		$insert = [];
		$id = $this->input->post('id');
		$insert['wd_account_holder'] = $this->input->post('wd_account_holder');
		$insert['wd_bank'] = $this->input->post('wd_bank');
		$insert['wd_account'] = $this->input->post('wd_account');
		$insert['wd_ifsc_code'] = $this->input->post('wd_ifsc_code');
		$insert['created_at'] = date('Y-m-d H:i:s');
		$insert['updated_at'] = date('Y-m-d H:i:s');
		$this->common_model->update_data('wd_bank_details',['wd_user_id'=>$user_id,'id'=>$id],$insert);
		
		
		$json['status'] = 1;
		$this->session->set_flashdata('message','<p class="alert alert-success">Bank detail updated successfully.</p>');
			
				
		echo json_encode($json);
	}

  public function Add_a_Card_to_Verify_your_Account($email,$name){
    $subject = "Add a Card to verify your Tradespeoplehub account";

    $html = '<p style="margin:0;padding:20px 0px">Add a Card to Verify your Account</p>';

    $html .= '<p style="margin:0;padding:20px 0px">Hi '.$name.',</p>';
    $html .= '<p style="margin:0;padding:20px 0px">We noticed that you recently signed up with us but have not yet added a card to verify your account fully. Until you have added a card to your account, we wouldn´t be able to establish your identity.</p>';

    $html .= '<div style="text-align:center"><a href="'.site_url().'membership-plans" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none"> Add Card</a></div>';

    $html .= '<p style="margin:0;padding:20px 0px">Note we will not charge the card as it only for account verification and not billing.</p>';
    $html .= '<p style="margin:0;padding:20px 0px">View our Tradespeople Help page or contact our customer services if you have any specific questions using our service.</p>';

    $sent = $this->common_model->send_mail($email,$subject,$html);
  }
	public function send_pay_as_you_go_welcome_email($to, $f_name, $token){
		
    $user_id = $this->session->userdata('user_id');
		
		$subject = "Thank you for Signing up to Tradespeoplehub.co.uk";
		
    $html = '<p style="margin:0;padding:10px 0px">Hi '.$f_name.'!</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">Welcome to TradespeopleHub!</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">Thank you for signing up to Tradespeoplehub–The UK most innovative platform for finding local jobs.</p>';
		
    $html .= '<p style="margin:0;padding:10px 0px">We are excited to have you on board, and now you have access to the core functionality you need to build your business with us.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Pay as you Go Plan</p>';
    
		$html .= '<p style="margin:0;padding:10px 0px">With pay as you go option, you can add credit on your wallet and use it at any time you wish to enjoy our service. </p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Changing to Subscription Plan:</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">If you would like to switch to the monthly plan, log in to your account and click on the “Upgrade tab” link in the upper left-hand corner.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Tradespeoplehub provides access to over 100K jobs posted by homeowners.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Here are a few steps of what we require you to do to start winning and doing those jobs.</p>';
		
    $html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Complete your profile</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Get the homeowner to know you by completing your profile page. Tradespeople that did this have seen 30% more success. So, give yourself a head start by uploading your photo and images of your past projects.</p>';
		
    $html .= '<div style="text-align:center"><a href="'.site_url().'edit-profile" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Complete profile</a></div>';
		
		$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Verify account</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">Quickly verify your account, phone number, ID, address, and even public insurance cover to help build trust in the Tradespeople Hub community.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">To verify your account, upload a copy of your proof of address document and ID on to-do list part of your account. We accept UK/EU valid driving license or passport as proof of ID.</p>';
		
		$html .= '<div style="text-align:center"><a href="'.site_url().'email-verified/'.$user_id.'/'.$token.'" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Verify account now</a></div>';
		
		$html .= '<br><p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Start winning & doing jobs.</p>';
		
		$html .= '<p style="margin:0;padding:10px 0px">We will begin to send you job leads in your area if we have not started already. When homeowners post a new job on TradespeopleHub which is within your selected distance of travelling, we will send you an email and text message with a link to view and quote the post.</p>';
		
		$html .= '<div style="text-align:center"><a href="'.site_url().'find-jobs" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">View job leads</a></div>';
		
		$html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
	
		return $sent = $this->common_model->send_mail($to,$subject,$html);
  }


public function saveCardList()
{
	$setting=$this->common_model->get_all_data('admin');
	if($setting[0]['payment_method'] == 0){
		redirect('dashboard');
	}
	$user_id = $this->session->userdata('user_id');
	$data['cards'] = $this->common_model->GetAllData('save_cards',['user_id'=>$user_id]);
  $this->load->view('site/card-list',$data);
}

	public function deleteCard($id="")
	{
			$this->common_model->delete(['id'=>$id], 'save_cards');
			$this->session->set_flashdata('message','<div class="alert alert-success">Crads detail has been deleted successfully!!</div>');
			redirect('save-card-list');
	}

	public function cardInfo($id="")
	{

		if($this->session->userdata('user_id')) {
      require_once('application/libraries/stripe-php-7.49.0/init.php');
			$secret_key = $this->config->item('stripe_secret');
			$email = $this->session->userdata('email');			
			$user_id = $this->session->userdata('user_id');


			\Stripe\Stripe::setApiKey($secret_key);			
			
			// $customer = \Stripe\Customer::create(['email' => $email]);
			
			$checkCustomer = $this->common_model->GetColumnName('save_cards',['email'=>$email, 'id'=>$id], array('customer_id'));
			
			if($checkCustomer && $checkCustomer['customer_id']){
				$customer_id = $checkCustomer['customer_id'];
			} else {
				$customer = \Stripe\Customer::create(['email' => $email]);
				$customer_id = $customer->id;
			}



			$intent = \Stripe\SetupIntent::create([
				'customer' => $customer_id
			]);
			$data['intent'] = $intent;
			$data['customerID'] = $customer_id;
			$data['cards'] = $this->common_model->GetSingleData('save_cards',['user_id'=>$user_id, 'id'=>$id]);
		  $this->load->view('site/card-info',$data);
			
			
    } 

	}


	// public function homeOwnerSaveCard()
	// {
	// 	if($this->session->userdata('user_id')) {
 //      require_once('application/libraries/stripe-php-7.49.0/init.php');
	// 		$secret_key = $this->config->item('stripe_secret');
	// 		$email = $this->session->userdata('email');			
	// 		$user_id = $this->session->userdata('user_id');


	// 		\Stripe\Stripe::setApiKey($secret_key);			
			
	// 		// $customer = \Stripe\Customer::create(['email' => $email]);
			
	// 		$checkCustomer = $this->common_model->GetColumnName('save_cards',['email'=>$email, 'id'=>$id], array('customer_id'));
			
	// 		if($checkCustomer && $checkCustomer['customer_id']){
	// 			$customer_id = $checkCustomer['customer_id'];
	// 		} else {
	// 			$customer = \Stripe\Customer::create(['email' => $email]);
	// 			$customer_id = $customer->id;
	// 		}



	// 		$intent = \Stripe\SetupIntent::create([
	// 			'customer' => $customer_id
	// 		]);
	// 		$data['intent'] = $intent;
	// 		$data['customerID'] = $customer_id;
	// 		// $data['cards'] = $this->common_model->GetSingleData('save_cards',['user_id'=>$user_id, 'id'=>$id]);
	// 	  $this->load->view('site/home-owner-save-card',$data);
			
			
 //    } 

	// }





	public function updateCards(){
		
			$payment_method = $this->input->post('payment_method');
			$customerID = $this->input->post('customerID');
			$card_id = $this->input->post('card_id');
			$card_u_name = $this->input->post('card_u_name');
			$user_id = $this->session->userdata('user_id');
			$email = $this->session->userdata('email');
			$cardDetail = GetCardDetailByApi($payment_method);



			$saveCard['u_name'] = (!empty($cardDetail['card_u_name']))? $cardDetail['card_u_name'] : $card_u_name;
			$saveCard['payment_method'] = $payment_method;
			$saveCard['country'] = $cardDetail['country'];

			$saveCard['exp_year'] = $cardDetail['exp_year'];
			$saveCard['exp_month'] = $cardDetail['exp_month'];
			$saveCard['last4'] = $cardDetail['last4'];
			$saveCard['brand'] = $cardDetail['brand'];
			$saveCard['updated_at'] = date('Y-m-d H:i:s');

			if(isset($card_id)&&!empty($card_id)){
				$this->common_model->update_data('save_cards',['id'=>$card_id], $saveCard);
				$this->session->set_flashdata('message','<div class="alert alert-success">Crads detail has been updated successfully!!</div>');
			}else{
				$saveCard['customer_id'] = $customerID;
				$saveCard['user_id'] = $user_id;
				$saveCard['email'] = $email;
				$this->common_model->insert('save_cards',$saveCard);
				$this->session->set_flashdata('message','<div class="alert alert-success">Crads detail has been inserted successfully!!</div>');
			}
			
		
		echo json_encode(array('status'=>1));
		
	}


}


?>