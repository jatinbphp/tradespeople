<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subcription_plan extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->check_login();
		// date_default_timezone_set('UTC');
		date_default_timezone_set('Europe/London');
		$this->load->model('common_model');
		require_once('application/libraries/stripe-php-7.49.0/init.php');
	}
	
	public function check_login() {
		if(!$this->session->userdata('user_logIn')){
			redirect('login');
		}
	}
	public function start_free_trial(){
		
		$traId = time().rand();
		$user_id = $this->session->userdata('user_id');
		
		$plan_detail = $this->common_model->get_single_data('tbl_package',array('id'=>44));
		
		$insert2['up_user'] = $user_id;
		$insert2['up_plan'] = 44;
		$insert2['up_planName'] = $plan_detail['package_name'];
		$insert2['up_amount'] = $plan_detail['amount'];
		
		if($plan_detail['unlimited_limited']==0) {
			$bid=$plan_detail['bids_per_month']; 
			$insert2['up_bid']=trim($bid,' bids');
			$insert2['bid_type']=1;
		} else {
			$insert2['up_bid']='Unlimited';
			$insert2['bid_type']=2;
		}

		$insert2['up_startdate'] = date('Y-m-d');
		$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_startdate']. '+ '.$plan_detail['validation_type']));
		$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_enddate']. '- 1 day'));
		$insert2['up_status'] = 1;
		$insert2['up_transId'] = $traId;
		$this->common_model->insert('user_plans',$insert2);
		
		redirect('dashboard');
	}
	public function buy_plan(){
		$user_id = $this->session->userdata('user_id');
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
			$id = $_REQUEST['id'];
			
			$plan_detail = $this->common_model->get_single_data('tbl_package',array('id'=>$id));
			$user = $this->common_model->get_userDataByid($user_id);
			
			if($user['u_wallet'] >= $plan_detail['amount']){
				
				
				if($plan_detail['reward']==1)
				{
					$amount1 = $user['u_wallet']-$plan_detail['amount'];
					$amount2 = $amount1+$plan_detail['reward_amount'];
					$u_data['u_wallet']=$amount2;
				}
				else
				{
				$amount1 = $user['u_wallet']-$plan_detail['amount'];
				$u_data['u_wallet'] = $amount1;
				}
				
				$run = $this->common_model->update('users',array('id'=>$user_id),$u_data);
				
				if($run){
					if($plan_detail['reward']==1)
					{
					$traId = time().rand();
					//insert in transactions history
					$insert['tr_userid'] = $user_id;
					$insert['tr_message'] = 'You had purchased a new subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].' and you have been rewarded <i class="fa fa-gbp"></i>'.$plan_detail['reward_amount'].' for '.$plan_detail['package_name']. 'plan.</b>';
					$insert['tr_amount'] = $plan_detail['amount'];
					$insert['tr_type'] = 2;
					$insert['tr_transactionId'] = $traId;
					$insert['tr_status'] = 1;
					$insert['tr_reward']=1;
					$insert['tr_plan']=$plan_detail['id'];
					
					}
					else
					{
							$traId = time().rand();
					//insert in transactions history
					$insert['tr_userid'] = $user_id;
					$insert['tr_message'] = 'You had purchased a new subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].'.</b>';
					$insert['tr_amount'] = $plan_detail['amount'];
					$insert['tr_type'] = 2;
					$insert['tr_transactionId'] = $traId;
					$insert['tr_status'] = 1;
					
					}
					$this->common_model->insert('transactions',$insert);
				
					
					
					//insert in transactions history
					
					//insert in notification history
					$nt_message = 'Your new subcription plan has been successfully activated.';
			
					$this->common_model->insert_notification($user_id,$nt_message);
					//insert in notification history
					
					//insert in plan history
					$insert2['up_user'] = $user_id;
					$insert2['up_plan'] = $plan_detail['id'];
					$insert2['up_planName'] = $plan_detail['package_name'];
					//$insert2['up_planCate'] = $plan_detail['p_cate'];
					$insert2['up_amount'] = $plan_detail['amount'];
					if($plan_detail['unlimited_limited']==0)
					{
					$bid=$plan_detail['bids_per_month']; 
					$insert2['up_bid']=trim($bid,' bids');
					$insert2['bid_type']=1;
					}
					else
					{
						$insert2['up_bid']='Unlimited';
						$insert2['bid_type']=2;
					}

					$insert2['up_startdate'] = date('Y-m-d');
					$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_startdate']. '+ '.$plan_detail['validation_type']));
					$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_enddate']. '- 1 day'));
					$insert2['up_status'] = 1;
					$insert2['up_transId'] = $traId;


					$run2 = $this->common_model->insert('user_plans',$insert2);

					if($run2){
				$this->common_model->delete(array('up_user'=>$user_id,'up_id != '=>$run2),'user_plans');
			}
					//insert in plan history
					
					$json['status'] = 1;
					$this->session->set_flashdata('success1','<p class="alert alert-success">Your subscription plan has been activated successfully.</p>');
				} else {
					$json['status'] = 0;
					$json['msg'] = '<div class="alert alert-danger">Something went wrong, try again later.</div>';
				}
				
			} else {
				$json['status'] = 0;
				$json['msg'] = '<div class="alert alert-danger">Insufficient amount in your wallet.</div>';
			}
				
			echo json_encode($json);
		} else {
			//$page['category'] = $this->common_model->get_all_data('market_place_cat',null,'mpc_id','asc');
			$page['packages'] = $this->common_model->get_all_data('packages',"p_id!=8",'p_id');
			$this->load->view('site/buy_plan',$page);
		}		 
	}


  public function pay_membership_plan($value=''){
		
		$data = $this->input->post('data');
		$actual_amt = $this->input->post('actual_amt');
		$user_id = $this->session->userdata('user_id');
		$email = $this->session->userdata('email');
// echo "<pre>"; 
// print_r($_POST); exit;
		$paymentStatus = 'error';
		
		if(isset($_POST['cardID'])){
			$user = $this->common_model->get_userDataByid($user_id);
			
			$cardData = $this->common_model->GetColumnName('save_cards',['id'=>$_POST['cardID'],'user_id'=>$user_id]);
			
			if(!$cardData){
				$response = array(
					'status' => 0,
					'msg' => 'Something went wrong. Please try again later.'
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
        
       	$response = array(
					'status' => 0,
					'msg' => 'Something went wrong. Please try again later.'
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














		
    $response = array();

    // if(!empty($data) && $data['paymentIntent']['status']=='succeeded'){
    if($paymentStatus=='succeeded'){
			
			
			$isPlanUpgrage = $this->common_model->get_single_data('user_plans', array('up_user' => $user_id));
			
			$get_user = $this->common_model->get_single_data('users',array('id'=>$user_id));
       
			$itemId  = $this->input->post('plan_id');
			
			$plan_detail = $this->common_model->get_single_data('tbl_package',array('id'=>$itemId));

			$itemPrice  = $plan_detail['amount'];
		

			// Order details    
			$amount = $plan_detail['amount'];
			$currency = 'GBP';
			$status = 1;
			$traId = md5(rand(1000,999).time());

			if($plan_detail['reward']==1){
				$wallet = $get_user['u_wallet'] + $plan_detail['reward_amount'];

				$this->common_model->update('users',array('id'=>$get_user['id']),array('u_wallet'=>$wallet));
				//insert in transactions history
				$insert['tr_userid'] = $get_user['id'];
				$insert['tr_message'] = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].' has been renewed and you have been rewarded <i class="fa fa-gbp"></i>'.$plan_detail['reward_amount'].' of '.$plan_detail['package_name']. 'plan.';
				$insert['tr_amount'] = $plan_detail['amount'];
				$insert['tr_transactionId'] = $traId;
				$insert['tr_status'] = $status;
				$insert['tr_reward']=1;
				$insert['tr_plan']=$plan_detail['id'];
				$insert['tr_paid_by']='Stripe';
			}else{

				$insert['tr_userid'] = $get_user['id'];
				$insert['tr_message'] = 'Your subcription plan of amount <i class="fa fa-gbp"></i>'.$plan_detail['amount'].' has been renewed';
				$insert['tr_amount'] = $plan_detail['amount'];
				$insert['tr_transactionId'] = $traId;
				$insert['tr_status'] = $status;
				$insert['tr_plan']=$plan_detail['id'];
				$insert['tr_paid_by']='Stripe';
			}
				
			$run = $this->common_model->insert('transactions',$insert);

			$insert2['up_user'] = $user_id;
			$insert2['up_plan'] = $plan_detail['id'];
			$insert2['up_planName'] = $plan_detail['package_name'];
			$insert2['up_amount'] = $plan_detail['amount'];

			if($plan_detail['unlimited_limited']==0){
				$bid = $plan_detail['bids_per_month']; 
				
				$up_bid = trim($bid,' bids')*1;
				
				//$insert2['up_bid'] = $up_bid + $isPlanUpgrage['up_bid'];
				$insert2['up_bid'] = $up_bid;
				$insert2['bid_type'] = 1;
			}else{
				$insert2['up_bid'] = 'Unlimited';
				$insert2['bid_type'] = 2;
			}

			$insert2['up_startdate'] = date('Y-m-d');
			$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_startdate']. '+ '.$plan_detail['validation_type']));
			$insert2['up_enddate'] = date('Y-m-d',strtotime($insert2['up_enddate']. '- 1 day'));
			$insert2['up_status'] = 1;
			//$insert2['up_used_bid'] = 0;
			//$insert2['total_sms'] = $plan_detail['total_notification'] + $isPlanUpgrage['total_sms'];
			$insert2['total_sms'] = $plan_detail['total_notification'];
			//$insert2['used_sms_notification'] = 0;
			$insert2['up_transId'] = $traId;

			$run2 = $this->common_model->insert('user_plans',$insert2);

			if($run2){
				$this->common_model->delete(array('up_user'=>$user_id,'up_id != '=>$run2),'user_plans');
			}

			/*$isExist = $this->common_model->get_single_data('billing_details', array('user_id' => $user_id));
			
			$serialize = serialize($stripe_data);

			$dataU['stripe_data'] = $serialize;
			$dataU['updated_at'] = date("Y-m-d H:i:s");

			if($isExist){
				$run = $this->common_model->update('billing_details',array('id' => $isExist['id']), $dataU);
			}else{
				$dataU['user_id'] = $user_id;
				$dataU['created_at'] = date("Y-m-d H:i:s");
				$run = $this->common_model->insert('billing_details', $dataU);
			}*/

			// $nt_message = 'Your '.$plan_detail['package_name'].' subcription plan has been successfully activated, TransactionId: <b>'.$traId.'</b>';
			$nt_message = 'Your '.$plan_detail['package_name'].' subcription plan has been successfully activated. <a href='.base_url('subscription-plan').'>View plan</a>';

			$this->common_model->insert_notification($get_user['id'],$nt_message);

			if($get_user['is_pay_as_you_go'] == 1 && !$isPlanUpgrage){
							
				$subject = 'Welcome Back-Your Membership Plan has been Activated.';
				$html = '<p style="margin:0;padding:10px 0px">Monthly membership plan activated successfully!</p><br>';
				$html .= '<p style="margin:0;padding:10px 0px">Hi '.$get_user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Thanks for coming back to your Tradespeoplehub monthly subscription plan. Your plan is now active.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">There\'s nothing more you need to do other than to continue using our service to grow your business.</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
							
			}else if($isPlanUpgrage){
							
				$subject = 'Your Membership Plan has Updated Successfully. ';
				$html = '<p style="margin:0;padding:10px 0px">Monthly Membership Plan Updated Successfully!</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">Hi '.$get_user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Thanks for updating your monthly subscription plan. Your new plan is now active, and you can now enjoy the benefits associated to it.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">There\'s nothing more you need to do other than to continue using our service to grow your business.</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
							
			}else{
							
				$subject = 'Welcome Back-Your Membership Plan has been Activated.';
				$html = '<p style="margin:0;padding:10px 0px">Monthly membership plan activated successfully!</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">Hi '.$get_user['f_name'].',</p>';
				$html .= '<p style="margin:0;padding:10px 0px">Thanks for coming back to your Tradespeoplehub monthly subscription plan. Your plan is now active.</p>';
				$html .= '<p style="margin:0;padding:10px 0px">There\'s nothing more you need to do other than to continue using our service to grow your business.</p>';
				$html .= '<br><p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
			}

			$sent = $this->common_model->send_mail($get_user['email'],$subject,$html);
			$response = array(
				'status' => 1,
				'msg' => 'Subscription plan successfully activated'
			);
			$this->session->set_flashdata('success1123','<p class="alert alert-success">Your subscription plan has been activated successfully. You can now start winning jobs. Don´t also forget to verify your account.</p>');
			
    } else {
      $response = array(
				'status' => 0,
				'msg' => 'Something went wrong. Please try again later.'
			);
    }

    echo json_encode($response);
  }


	public function my_plans_history(){
		if($this->session->userdata('user_id'))
		{
			$user_id = $this->session->userdata('user_id');
		
		$page['plans'] = $this->common_model->get_all_data('user_plans',array('up_user'=>$user_id),'up_id');
		$this->load->view('site/my_plans_history',$page); 
		}
		else{
			redirect('login');
		}
		
	}

  public function cancel_plan($planid) {
    $update2['auto_update'] = 0;
    $runss1 = $this->common_model->update('user_plans',array('up_id'=>$planid),$update2);	
    if($runss1) {
      $user_plans = $this->common_model->get_single_data('user_plans', array('up_id' => $planid));
      $plan_detail = $this->common_model->get_single_data('tbl_package',array('id' => $user_plans['up_plan']));
      $nt_message = 'Your '.$plan_detail['package_name'].' subcription plan has been deactivated successfully.';

      $this->common_model->insert_notification($this->session->userdata('user_id'),$nt_message);
      $get_user=$this->common_model->get_single_data('users',array('id'=>$this->session->userdata('user_id')));
      $subject = $plan_detail['package_name']." plan has been deactivated"; 
      
      /*
      $content= 'Hello '.$get_user['f_name'].' '.$get_user['l_name'].', <br><br>';

      $content.='<p class="text-center">Your '.$plan_detail['package_name'].' subcription plan has been deactivated successfully.<a href="'.site_url().'membership-plans'.'">Click here</a> to purchase subscription plan. </p>';
      */
      $html = "<p style='margin:0; padding:10px 0px'>We're sad to see you go.</p>";
      $html .= '<p style="margin:0;padding:10px 0px">You\'ve cancelled your Tradespeople Hub monthly subscription which will end on ' .date("d-M-Y", strtotime($user_plans['up_enddate'])) .'.</p>';
      $html .= '<p style="margin:0;padding:10px 0px">You can continue to access your membership benefits until your subscription ends.</p>';
      $html .= '<p style="margin:0;padding:10px 0px">When your subscription ends, you will not be able to provide quotes, receive instant job notification and respond to special job offer.</p>';
      $html .= '<p style="margin:0;padding:10px 0px">We want to keep seeing you on our platform, so if the price is the problem for wanting to leave us, we would like to invite you to use our "Pay As You Go" option. You can easily activate it now by clicking.</p>';

      $html .= '<div style="text-align:center"><a href="'.site_url().'membership-plans" style="background-color:#fe8a0f;color:#fff;padding:8px 22px;text-align:center;display:inline-block;line-height:25px;border-radius:3px;font-size:17px;text-decoration:none">Pay As You Go</a></div>';
      $html .= '<p style="margin:0;padding:10px 0px">If you want to come back, our membership plan is just a click away. All you have to do is to reactivate your subscription.</p>';

      $html .= '<div style="text-align:center"><a href="'.site_url().'membership-plans" style="background-color:#fe8a0f;color:#fff;padding:8px 22px; text-align:center; display:inline-block; line-height:25px; border-radius:3px; font-size:17px; text-decoration:none">Reactivate the subscription</a></div>';

      $html .= '<p style="margin:0;padding:10px 0px">We hope to welcome you back soon! Your historical data will be waiting for you when you get back.</p>';
      $html .= '<p style="margin:0;padding:10px 0px">View our Tradesperson Help page or contact our customer services if you have any specific questions using our service.</p>';
      $runs1 = $this->common_model->send_mail($get_user['email'], $subject, $html);
      $json['status']=1;
      $this->session->set_flashdata('success2', 'Success! Your plan has been deactivated successfully.');
    } else {
      $json['status']=0;
      $this->session->set_flashdata('error2', 'Error! Something went wrong.');
    }
    echo json_encode($json);
  }

}
?>