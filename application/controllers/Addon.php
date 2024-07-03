<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Addon extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		require_once('application/libraries/stripe-php-7.49.0/init.php');

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
	public function index(){
		$setting=$this->common_model->get_all_data('admin');
		if($setting[0]['payment_method'] == 0){
			redirect('dashboard');
		}
		$page['credit_addon'] = $this->common_model->newgetRows('addons',array('type'=>1),'id');
		$page['sms_addon'] = $this->common_model->newgetRows('addons',array('type'=>2),'id');
		$this->load->view('site/addons',$page);
	}
	public function make_addon_payment($id=null){
		
		$addon = $this->common_model->get_single_data('addons',array('id'=>$id));
		
		if($addon){
		
			$page['addon'] = $addon;
			$page['user_plans']=$this->common_model->get_user_plans();
		
			$this->load->view('site/make-addon-payment',$page);
		} else {
			redirect();
		}
	}
	
	public function buy_addons(){
		
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('user_id');
		$user = $this->common_model->get_single_data('users',array('id'=>$user_id));
		$addon = $this->common_model->get_single_data('addons',array('id'=>$id));
		$plan = $this->common_model->get_single_data('user_plans',array('up_user'=>$user_id));


		$data = $this->input->post('data');
		$actual_amt = $this->input->post('actual_amt');
		
		$paymentStatus = 'error';
		
		if(isset($_POST['cardID'])){
			$user = $this->common_model->get_userDataByid($user_id);
			$cardData = $this->common_model->GetColumnName('save_cards',['id'=>$_POST['cardID'],'user_id'=>$user_id]);
			if(!$cardData){
				$json['status'] = 0;
	      		$this->session->set_flashdata('success1123','<p class="alert alert-danger">Something went wrong. Please try again later.</p>');
				echo json_encode($json); exit();
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
				if(!empty($data) && $data['status']=='succeeded'){
					$paymentStatus = 'succeeded';
				}
			} catch(Exception $e) {
		       $json['status'] = 0;
	      		$this->session->set_flashdata('success1123','<p class="alert alert-danger">Something went wrong. Please try again later.</p>');
				echo json_encode($json); exit();
		        
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
			if($plan && $addon && $user){
				
				$amount = $addon['amount'];
				$currency = 'GBP';
				$status = 1;
				$traId = md5(rand(1000,999).time());
				
				
				if($addon['type']==1){
					$update['up_bid'] = $plan['up_bid'] + $addon['quantity'];
				} else {
					$update['total_sms'] = $plan['total_sms'] + $addon['quantity'];
				}
				
				$update['up_update'] = date('Y-m-d H:i:s');
				
				$run = $this->common_model->update_data('user_plans',array('up_id'=>$plan['up_id']),$update);
				
				$insert['tr_userid'] = $user['id'];
				$insert['tr_message'] = 'Your have purchased addon of amount <i class="fa fa-gbp"></i>'.$amount;
				$insert['tr_amount'] = $amount;
				$insert['tr_transactionId'] = $traId;
				$insert['tr_status'] = $status;
				$this->common_model->insert('transactions',$insert);
				
				$subject = 'Your Addon has been added. ';
				$html = '<p style="margin:0;padding:10px 0px">Addon added in your plan!</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">Hi '.$user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Thanks for adding addon at your monthly subscription plan. You can now enjoy the benefits associated to it.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">There\'s nothing more you need to do other than to continue using our service to grow your business.</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
				$this->common_model->send_mail($user['email'],$subject,$html);
					
				$this->session->set_flashdata('success1123','<p class="alert alert-success">Addon has been added to your plan successfully.</p>');
				$json['status'] = 1;
				
			} else {
				$json['status'] = 0;
			}
		}else {
			$json['status'] = 0;
	      	$this->session->set_flashdata('success1123','<p class="alert alert-danger">Something went wrong. Please try again later.</p>');
	    }
		echo json_encode($json);
	}
}