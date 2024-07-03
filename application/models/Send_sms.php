<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('application/libraries/Twilio/autoload.php');
use Twilio\Rest\Client;

class Send_sms extends CI_Model {
	
	public function send($phone,$msg){
		error_reporting(0);
		$sid = 'ACab5b64078d1cb3634491ff491d05ddbb';
		 
		$token = 'f599e5ee1891e5c45cbbac3f56144cd2'; 
		
		$client = new Client($sid, $token);
		
		$code = "+44";
		
		$status = true;
		
		$phones = $code.$phone;
	
		$encoded = rawurlencode("$phones");
		
		try {
			$run = $client->messages->create(
				$phones,
				array(
					//'from' => '+16306570701',
					'from' => 'TRADEPPLHUB',
					'body' => $msg
				)
			);
    } catch (Twilio\Exceptions\RestException $e) {
			
			$status = false;
			
    }
		
		return $status;
	}
	
	public function send_india($phone,$msg){
		
		$sid = 'AC163e5904682a402c6ca4ef0ff3a641eb';
		
		$token = 'eeec7b2cb99df7377d3e216d5edde012';
		
		$client = new Client($sid, $token);
		
		$code = "+91";
		
		$status = true;
		
		$phones = $code.$phone;
	
		$encoded = rawurlencode("$phones");
		
		try {
			$run = $client->messages->create(
				$phones,
				array(
					'from' => '+12568297206',
					'body' => $msg
				)
			);
    } catch (Twilio\Exceptions\RestException $e) {
			echo '<pre>'; print_r($e); echo '</pre>';
			$status = false;
    }
		
		return $status;
	}

}