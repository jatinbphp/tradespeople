<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stripe extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Europe/London');
		require_once('application/libraries/stripe-php-7.49.0/init.php');
	}
	
	public function PaymentIntent($amount){
		
		$secret_key = $this->config->item('stripe_secret');
		\Stripe\Stripe::setApiKey('sk_test_BA5v4UfqqAC5aPhdh675ijTd');
		try {
		
			$customer = \Stripe\Customer::create();
			
			$paymentIntent = \Stripe\PaymentIntent::create([
				'amount' => $amount*1,
				'currency' => 'usd',
				'customer' => $customer->id,
				'setup_future_usage' => 'off_session',
			]);
			
			return $intent;
			
			$output = array(
									'status' => 1, 
									'clientSecret' => $paymentIntent->client_secret
								);
			
		} catch (Error $e) {
			
			$output = array(
				'status' => 0, 
				'msg' => $e->getMessage()
			);
			
		}
		return $output;
		
	}
	private function calculateOrderAmount(array $items): int {
		// Replace this constant with a calculation of the order's amount
		// Calculate the order total on the server to prevent
		// customers from directly manipulating the amount on the client
		return 1400;
	}
}