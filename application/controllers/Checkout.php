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
		$insert['service_qty'] = $this->input->post('qty_of_type');
		$insert['ex_service_ids'] = $this->input->post('selected_exsIds');
		$newCart = $this->common_model->insert('cart', $insert);

		if($newCart){
			$this->session->set_userdata('latest_cartId',$newCart);
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

		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}

		$uId = $this->session->userdata('user_id');

		$this->session->set_userdata('previous_url', current_url());

		$latestCartId = $this->session->userdata('latest_cartId');
		$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));

		$sId = $cartData['service_id'];
		$prices = 0;
		$totalPrice = 0;
		$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
		$serviceQty = !empty($cartData['service_qty']) ? $cartData['service_qty'] : 1;
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

		$servicePrice = $data['service_details']['price'] * $serviceQty;

		$data['exIds'] = $exsId;
		$data['totalPrice'] = $totalPrice + $servicePrice;
		$data['serviceQty'] = $serviceQty;
		$data['userCardData'] = $this->getCardData($uId);

		$this->load->view('site/checkout',$data);
	}

	public function checkPromoCode(){
		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}		

		$total_amount = 0;
		$totalPrice = 0;
		$discount = 0;
		$discounted_amount = 0;

		$latestCartId = $this->session->userdata('latest_cartId');
		$pcode = $this->input->post('promo_code');
		$promo_code = $this->common_model->get_single_data('promo_code',array('code'=>$pcode,'status'=>'active'));
		
		if(empty($promo_code)){
			$data['status'] = 0;
			$data['message'] = 'Invalid Promo Code';
			echo json_encode($data);
			exit;
		}else{
			$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));
			$service_id = $cartData['service_id'];
			$service_details = $this->common_model->get_single_data('my_services', array('id'=>$service_id));
			$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
			$serviceQty = !empty($cartData['service_qty']) ? $cartData['service_qty'] : 1;
			if(!empty($exsId)){
				$ex_services = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $service_id);	
				if(!empty($ex_services) && count($ex_services) > 0){
					foreach($ex_services as $list){
						$extraService .= $list['id'].'-'.$list['price'].',';
					}
					$prices = array_column($ex_services, 'price');
					$totalPrice = array_sum($prices);
				}
			}

			$servicePrice = $service_details['price'] * $serviceQty;
			$total_amount = $totalPrice + $servicePrice;

			$result = $this->getDiscount($promo_code, $total_amount, 0);

			echo json_encode($result);
			exit;
		}		
	}

	public function getDiscount($promo_code, $total_amount, $serviceFee=0){
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
			$data['discounted_amount'] = number_format(($discounted_amount + $serviceFee),2);
		}else{
			$data['status'] = 0;
			$data['message'] = 'Invalid Promo Code';			
		}
		return $data;
	}

	public function placeOrder(){
		if(in_array($this->session->userdata('type'),[1,3])){
			redirect('dashboard');
		}

		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}

		$this->form_validation->set_rules('payment_method','Payment Method','required');
				
		if ($this->form_validation->run()==false) {
			$data['status'] = 0;
			$data['message'] = 'Please select payment method';
			echo json_encode($data);
			exit;
		}

		$previous_url = $this->session->userdata('previous_url');
		$uId = $this->session->userdata('user_id');
		$latestCartId = $this->session->userdata('latest_cartId');
		$pcode = $this->input->post('promo_code');
		$payment_method = $this->input->post('payment_method');

		$users=$this->common_model->get_single_data('users',array('id'=>$uId));
		$setting = $this->common_model->get_single_data('admin',array('id'=>1));
		$promo_code = $this->common_model->get_single_data('promo_code',array('code'=>$pcode,'status'=>'active'));
		$cartData = $this->common_model->get_single_data('cart',array('id'=>$latestCartId));
		$service_id = $cartData['service_id'];
		$service_details = $this->common_model->get_single_data('my_services', array('id'=>$service_id));

		$exsId = !empty($cartData['ex_service_ids']) ? $cartData['ex_service_ids'] : '';
		$serviceQty = !empty($cartData['service_qty']) ? $cartData['service_qty'] : 1;
		$extraService = '';
		$total_amount = 0;
		$totalPrice = 0;
		$discount = 0;
		$discounted_amount = 0;
		$is_proceed = 0;

		if(!empty($exsId)){
			$ex_services = $this->common_model->get_extra_service('tradesman_extra_service',$exsId, $service_id);	

			if(!empty($ex_services) && count($ex_services) > 0){
				foreach($ex_services as $list){
					$extraService .= $list['id'].'-'.$list['price'].',';
				}
				$prices = array_column($ex_services, 'price');
				$totalPrice = array_sum($prices);
			}
		}
		$servicePrice = $service_details['price'] * $serviceQty;
		$total_amount = $totalPrice + $servicePrice;
		$discounted_amount = $total_amount;
		$is_allowed = 0;

		if(!empty($pcode)){
			$result = $this->getDiscount($promo_code, $total_amount, $setting['service_fees']);

			if($result['status'] == 1){
				$discount = $result['discount'];
				$discounted_amount = $result['discounted_amount'];
			}else{
				echo json_encode($result);
				exit;
			}
		}

		$mainPrice = $discounted_amount + $setting['service_fees'];

		if($payment_method == 'wallet'){
			if($mainPrice > $users['u_wallet']) {
				$data['status'] = 0;
				$data['message'] = 'Insufficient amount in your wallet please recharge you wallet';
				echo json_encode($data);
				exit;
			} else {
				$transactionid = md5(rand(1000,999).time());
				$is_proceed = 1;
			}	
		}else{
			$is_proceed = 1;
		}

		if($is_proceed == 1){

			$pmtype = !in_array($payment_method, ['card','wallet']) ? 'card' : $payment_method;

			$insert['user_id'] = $uId;
			$insert['service_id'] = $service_id;
			$insert['ex_services'] = rtrim($extraService,',');
			$insert['price'] = $service_details['price'];
			$insert['service_qty'] = $serviceQty;
			$insert['service_fee'] = $setting['service_fees'];
			$insert['promo_code'] = $promo_code['code'];
			$insert['discount_type'] = $promo_code['discount_type'];
			$insert['discount'] = $discount;
			$insert['total_price'] = $mainPrice;
			$insert['payment_method'] = $pmtype; 
			$insert['payment_status'] = 'paid';
			$insert['transaction_id'] = $transactionid ?? '';
			$insert['payment_intent_id'] = !empty($this->input->post('pay_intent')) ? $this->input->post('pay_intent') : '';
			$insert['status'] = 'placed';
			$newOrder = $this->common_model->insert('service_order', $insert);

			if($newOrder){

				/*Update User Wallet*/
				$update12['u_wallet']=$users['u_wallet']-$mainPrice;
				$update12['spend_amount']=$users['spend_amount']+$mainPrice;						
				$this->common_model->update('users',array('id'=>$uId),$update12);
									
				$tr_message='£'.$mainPrice.'  has been debited to your wallet for ordering a service <a href="'.site_url().'service/'.$service_id.'">'.$service_details['service_name'].'.</a>';
					
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
				$homeOwner = $this->common_model->check_email_notification($users['id']);
				if($homeOwner){
					$subject = "Order Payment Made for “".$service_details['service_name']."”";				
					$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Order Payment Made Successfully!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Hi '.$homeOwner['f_name'].'!</p>';
					$html .= '<p style="margin:0;padding:10px 0px">'.$get_users['f_name'].' '.$get_users['l_name'].' has made a milestone payment for the job “'.$post_title.'.” </p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service payment amount:  £'.$mainPrice.'</p>';					
					$html .= '<p style="margin:0;padding:10px 0px">View our Tradespeople help page or contact our customer services if you have any specific questions using our service.</p>';
					
					$sent = $this->common_model->send_mail($homeOwner['email'],$subject,$html);
				}

				/*Tradesman Email Code*/
				$tradesMan = $this->common_model->check_email_notification($service_details['user_id']);
				if($tradesMan){
					$subject = "Your Service Payment created successfully: “".$service_details['service_name']."”"; 
					$html = '<p style="margin:0;padding:10px 0px">Service Payment Made Successfully!</p>';
					$html = '<p style="margin:0;padding:10px 0px">Hi ' . $tradesMan['f_name'] .',</p>';		
					$html .= '<p style="margin:0;padding:10px 0px">Your service payment to '.$tradesMan1['trading_name'].' created successfully.</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service title: '.$service_details['service_name'].'</p>';
					$html .= '<p style="margin:0;padding:10px 0px">Service Amount: £'.$discounted_amount.'</p>';
					$this->common_model->send_mail($tradesMan['email'],$subject,$html);
				}
				
				$this->common_model->delete(['id'=>$latestCartId],'cart');

				$data['status'] = 1;
				$data['message'] = 'Your order placed succesfully';
				echo json_encode($data);
				exit;
			}else{
				$data['status'] = 0;
				$data['message'] = 'Something is wrong. Your order is not placed';
				echo json_encode($data);
				exit;
			}
		}
	}

	public function placeOrderWithStripe($value=''){
		if(!$this->session->userdata('user_id')){
			$json['status'] = 2;
      		echo json_encode($json);
      		exit;
    	}

		//stripe code
		require_once('application/libraries/stripe-php-7.49.0/init.php');
		header('Content-Type: application/json');

		$uId = $this->session->userdata('user_id');
		$users=$this->common_model->get_single_data('users',array('id'=>$uId));

		$json_obj = (object) $this->input->post();

        $stripeSecretKey = $this->config->item('stripe_secret');
        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $userName =  $users['f_name'] ?? '' .' '. $users['l_name'] ?? '' ;
        $userEmail = $users['email'] ?? '';

        if(isset($users['stripe_customer_id']) && $users['stripe_customer_id']){
        	$stripeCustomerId = $users['stripe_customer_id'];
        } else {
            // Add customer to stripe
            try {  
                $customer = \Stripe\Customer::create([ 
                    'name' => $userName, 
                    'email' => $userEmail
                ]); 
            }catch(Exception $e) {  
                $api_error = $e->getMessage();  
            }

            if(empty($api_error) && $customer){
                $stripeCustomerId = $customer->id;
                $input['stripe_customer_id'] = $customer->id;
                $this->common_model->update('users',array('id'=>$users['id']),$input);

            }else{
                http_response_code(500);
                echo json_encode(['error' => $api_error]);
            }
        }

        $intent = null;
    	try {
            if (isset($json_obj->payment_method_id) && $json_obj->mainPrice) {
                $amount = ($json_obj->mainPrice * 100);

                $isAddNewCard = $this->getAllowToAddNewCard($json_obj, $stripeCustomerId);

                if($isAddNewCard){
                    $paymentMethod = \Stripe\PaymentMethod::retrieve($json_obj->payment_method_id);
                    $paymentMethod->attach(['customer' => $stripeCustomerId]);
                }

                # Create the PaymentIntent
                $intent = \Stripe\PaymentIntent::create([
                    'payment_method' => $json_obj->payment_method_id,
                    'amount' => $amount,
                    'description' => 'Service purchase from Tradespeople Hub',
                    'currency' => 'usd',
                    'confirm' => true,
                    'customer' => $stripeCustomerId,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ]
                ]);
            }
            if (isset($json_obj->payment_intent_id)) {
                $intent = \Stripe\PaymentIntent::retrieve(
                    $json_obj->payment_intent_id
                );
            }
            $this->generateResponse($intent);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            # Display error on client
            echo json_encode([
                'error' => $e->getMessage(),
            ]);
        }
	}

	public function getAllowToAddNewCard($json_obj, $customerId) {
        $saveForLater = isset($json_obj->saveCard) ? $json_obj->saveCard : false;
        if(!$saveForLater || $saveForLater == 'false'){
            return false;
        }
        $paymentId = $json_obj->payment_method_id;       

        require_once('application/libraries/stripe-php-7.49.0/init.php');
        $stripeSecretKey = $this->config->item('stripe_secret');
        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentId);

        if(empty($paymentMethod) || !isset($paymentMethod['card'])){
            return false;
        }

        $currentCardNumber = $paymentMethod['card']['last4'] ?? 0;
        
        if(!$currentCardNumber){
            return false;
        }

        $existingCards = $this->existingCardData($customerId);

        if(in_array($currentCardNumber, $existingCards)){
            return false;
        }

        return true;
    }

    public function generateResponse($intent)
    {
        # Note that if your API version is before 2019-02-11, 'requires_action'
        # appears as 'requires_source_action'.
        if ($intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
            ]);
        } else if ($intent->status == 'requires_capture') {
            # The payment didn’t complated yed need to capture letter with intent id!
            # Handle post-payment fulfillment
            echo json_encode([
                "success" => true,
                "intent" => $intent->id
            ]);
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            echo json_encode([
                "success" => true,
                "intent" => $intent->id
            ]);
        } else {
            # Invalid status
            http_response_code(500);
            echo json_encode(['error' => 'Invalid PaymentIntent status','instent_status'=> $intent->status]);
        }
    }

	public function thankyou(){
		$this->load->view('site/thankyou');
	}

	public function getCardData($userId) {
        if(!$userId){
            return [];
        }
        $userData = $this->common_model->get_single_data('users',array('id'=>$userId));
        $customerId = $userData['stripe_customer_id'] ?? '';
        if(!$customerId){
            return [];
        }
        require_once('application/libraries/stripe-php-7.49.0/init.php');
        $stripeSecretKey = $this->config->item('stripe_secret');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $paymentMethods = $stripe->paymentMethods->all([
            'customer' => $customerId,
            'type' => 'card',
        ]);

        if(empty($paymentMethods)){
            return [];
        }

        $cardData = [];

        foreach ($paymentMethods as $payment) {
            $paymentId = $payment['id'] ?? 0;
            if(!$paymentId){
                continue;
            }
            
            $brand = $payment['card']['brand'] ?? '';
            $last4 = $payment['card']['last4'] ?? '';

            $cardData[$paymentId]['brand'] = ucfirst($brand);
            $cardData[$paymentId]['last4'] = $last4;
        }
        
        return $cardData;
    }

    public function existingCardData($customerId) {
        require_once('application/libraries/stripe-php-7.49.0/init.php');
        $stripeSecretKey = $this->config->item('stripe_secret');
        $stripe = new \Stripe\StripeClient($stripeSecretKey);

        $allPayments = $stripe->paymentMethods->all([
            'customer' => $customerId,
            'type' => 'card',
        ]);

        if(empty($allPayments)){
            return [];
        }

        $cardNumbers = [];

        foreach ($allPayments as $cardData) {
            $cardData = $cardData['card'] ?? [];
            if(!count($cardData)){
                continue;
            }

            $cardNumbers[] = $cardData['last4'];
        }

        return $cardNumbers;
    }
}