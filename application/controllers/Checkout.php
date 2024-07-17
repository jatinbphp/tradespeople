<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller
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

	public function addToCart(){
		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}

		$uId = $this->session->userdata('user_id');
		$sId = $this->input->post('service_id');
		$this->common_model->delete(['user_id'=>$uId, 'service_id'=>$sId],'cart');

		$insert['user_id'] = $uId;
		$insert['service_id'] = $sId;
		$insert['ex_service_ids'] = $this->input->post('selected_exsIds');
		$newCart = $this->common_model->insert('cart', $insert);

		if($newCart){
			$this->session->set_userdata('latest_catId',$newCart);
			$json['status'] = 1;
		} else {
			$json['status'] = 0;
		}	
		echo json_encode($json);
	}

	public function serviceCheckout(){
		if(in_array($this->session->userdata('type'),[1,3])){
			redirect('dashboard');
		}

		$this->session->set_userdata('previous_url', current_url());

		$latestCartId = $this->session->userdata('latest_catId');
		$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));

		$sId = $cartData['service_id'];
		$prices = 0;
		$totalPrice = 0;
		$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));
		$data['service_fee'] = $setting['service_fees'];
		$data['service_details'] = $this->common_model->GetSingleData('my_services',['id'=>$sId]);
		if(!empty($exsId)){
			$data['ex_services'] = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $sId);	
		}else{
			$data['ex_services'] = [];
		}
		
		if(!empty($data['ex_services']) && count($data['ex_services']) > 0){
			$prices = array_column($data['ex_services'], 'price');
			$totalPrice = array_sum($prices);	
		}
		$data['exIds'] = $exsId;
		$data['totalPrice'] = $totalPrice + $data['service_details']['price'];
		$this->load->view('site/checkout',$data);
	}

	public function checkPromoCode(){
		$total_amount = 0;
		$totalPrice = 0;
		$discount = 0;
		$discounted_amount = 0;

		$latestCartId = $this->session->userdata('latest_catId');
		$pcode = $this->input->post('promo_code');
		$promo_code = $this->common_model->get_single_data('promo_code',array('code'=>$pcode,'status'=>'active'));
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));

		if(empty($promo_code)){
			$data['status'] = 0;
			$data['message'] = 'Invalid Promo Code';
			echo json_encode($data);
			exit;
		}else{
			$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));
			$service_details = $this->common_model->get_single_data('my_services', array('id'=>$cartData['service_id']));
			$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
			if(!empty($exsId)){
				$ex_services = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $cartData['service_id']);	
				if(!empty($ex_services) && count($ex_services) > 0){
					foreach($ex_services as $list){
						$extraService .= $list['id'].'-'.$list['price'].',';
					}
					$prices = array_column($ex_services, 'price');
					$totalPrice = array_sum($prices);
				}
			}
			$total_amount = $totalPrice + $service_details['price'];

			if($promo_code['is_limited'] == 'yes'){
				$is_allowed = $promo_code['limited_user'] > $promo_code['exceeded_limit'] ? 1 : 0;
			}else{
				$is_allowed = 1;
			}

			if($is_allowed == 1){
				if($promo_code['discount_type'] == 'flat'){
					$discount = $promo_code['discount'];
					$msg = ' Enjoy £'.$discount.' on your order!';
					$msg = 'Enjoy a discount of £'.$discount.' on your order!';
				}else{
					$discount = ($total_amount * $promo_code['discount']) / 100;
					$msg = 'Enjoy a discount of '.$promo_code['discount'].'% on your order!';
				}
				$discounted_amount = $total_amount - $discount;

				$data['status'] = 1;
				$data['message'] = $msg;
				$data['discount'] = number_format($discount,2);
				$data['discounted_amount'] = number_format(($discounted_amount+ $setting['service_fees']),2);
				echo json_encode($data);
				exit;
			}else{
				$data['status'] = 0;
				$data['message'] = 'Invalid Promo Code';
				echo json_encode($data);
				exit;
			}
		}		
	}

	public function placeOrder(){
		if(in_array($this->session->userdata('type'),[1,3])){
			redirect('dashboard');
		}

		$this->form_validation->set_rules('payment_method','Payment Method','required');
				
		if ($this->form_validation->run()==false) {
			$this->session->set_flashdata('error',validation_errors());
			redirect('serviceCheckout');
		}

		$previous_url = $this->session->userdata('previous_url');
		$uId = $this->session->userdata('user_id');
		$users=$this->common_model->get_single_data('users',array('id'=>$uId));
		$latestCartId = $this->session->userdata('latest_catId');
		$pcode = $this->input->post('promo_code');
		$payment_method = $this->input->post('payment_method');

		$setting = $this->common_model->get_single_data('admin',array('id'=>1));
		$promo_code = $this->common_model->get_single_data('promo_code',array('code'=>$pcode,'status'=>'active'));
		$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));
		$service_details = $this->common_model->get_single_data('my_services', array('id'=>$cartData['service_id']));

		$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
		$extraService = '';
		$total_amount = 0;
		$totalPrice = 0;
		$discount = 0;
		$discounted_amount = 0;
		$is_proceed = 0;

		if(!empty($exsId)){
			$ex_services = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $cartData['service_id']);	

			if(!empty($ex_services) && count($ex_services) > 0){
				foreach($ex_services as $list){
					$extraService .= $list['id'].'-'.$list['price'].',';
				}
				$prices = array_column($ex_services, 'price');
				$totalPrice = array_sum($prices);
			}
		}
		$total_amount = $totalPrice + $service_details['price'];
		$is_allowed = 0;

		if(!empty($promo_code)){
			if($promo_code['is_limited'] == 'yes'){
				$is_allowed = $promo_code['limited_user'] > $promo_code['exceeded_limit'] ? 1 : 0;

				if($is_allowed == 1){
					$input['exceeded_limit'] = $promo_code['exceeded_limit'] + 1;
					$this->common_model->update('promo_code',array('id'=>$promo_code['id']),$input);
				}
			}else{
				$is_allowed = 1;
			}

			if($is_allowed == 1){
				if($promo_code['discount_type'] == 'flat'){
					$discount = $promo_code['discount'];				
				}else{
					$discount = ($total_amount * $promo_code['discount']) / 100;
				}
				$discounted_amount = $total_amount - $discount;	
			}
		}else{
			$discounted_amount = $total_amount;
		}

		if($payment_method == 'wallet'){
			if($discounted_amount > $users['u_wallet']) {
				$this->session->set_flashdata('error','Insufficient amount in your wallet please recharge you wallet.');

				redirect('serviceCheckout');
			} else {
				$transactionid = md5(rand(1000,999).time());
				$is_proceed = 1;
			}	
		}else{
			//stripe code
		}

		if($is_proceed == 1){
			$mainPrice = $discounted_amount + $setting['service_fees'];
			$insert['user_id'] = $uId;
			$insert['service_id'] = $cartData['service_id'];
			$insert['ex_services'] = rtrim($extraService,',');
			$insert['price'] = $service_details['price'];
			$insert['service_fee'] = $setting['service_fees'];
			$insert['promo_code'] = $promo_code['code'];
			$insert['discount_type'] = $promo_code['discount_type'];
			$insert['discount'] = $discount;
			$insert['total_price'] = $mainPrice;
			$insert['payment_method'] = $payment_method;
			$insert['payment_status'] = $payment_method == 'wallet' ? 'paid' : 'pending';
			$insert['transaction_id'] = $transactionid;
			$insert['status'] = 'placed';
			$newOrder = $this->common_model->insert('service_order', $insert);

			if($newOrder){

				/*Update User Wallet*/
				$update12['u_wallet']=$users['u_wallet']-$mainPrice;
				$update12['spend_amount']=$users['spend_amount']+$mainPrice;						
				$this->common_model->update('users',array('id'=>$uId),$update12);
									
				$tr_message='£'.$mainPrice.'  has been debited to your wallet for ordering a service <a href="'.site_url().'service/'.$cartData['service_id'].'">'.$service_details['service_name'].'.</a>';
					
				$data1 = array(
					'tr_userid'=>$users['id'], 
					'tr_amount'=>$mainPrice,
					'tr_type'=>2,
					'tr_transactionId'=>$transactionid,
					'tr_message'=>$tr_message,
					'tr_status'=>1,
					'tr_created'=>date('Y-m-d H:i:s'),
					'tr_update' =>date('Y-m-d H:i:s')
				);				 
				$this->common_model->insert('transactions',$data1);

				/*Homeowner Email Code*/
				$has_email_noti1 = $this->common_model->check_email_notification($users['id']);
				if($has_email_noti1){
					$subject = "Order Payment Made for “".$service_details['service_name']."”";				
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Order Payment Made Successfully!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$has_email_noti1['f_name'].'!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">'.$get_users['f_name'].' '.$get_users['l_name'].' has made a milestone payment for the job “'.$post_title.'.” </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service payment amount:  £'.$mainPrice.'</p>';					
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$sent = $this->common_model->send_mail($has_email_noti1['email'],$subject,$html);
				}

				/*Tradesman Email Code*/
				$has_email_noti = $this->common_model->check_email_notification($service_details['user_id']);
				if($has_email_noti){
					$subject = "Your Service Payment created successfully: “".$service_details['service_name']."”"; 
					$html = '<p style="margin:0;padding:10px 0px">Service Payment Made Successfully!</p>';
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $has_email_noti['f_name'] .',</p>';		
					$html .= '<p style="margin:0;padding:10px 0px">Your service payment to '.$has_email_noti1['trading_name'].' created successfully.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service title: '.$service_details['service_name'].'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service Amount: £'.$discounted_amount.'</p>';
					$this->common_model->send_mail($has_email_noti['email'],$subject,$html);
				}
				
				$this->common_model->delete(['id'=>$latestCartId],'cart');

				redirect('thakyou');
			}
		}
	}	

	public function thankyou(){
		$this->load->view('site/thankyou');
	}
}