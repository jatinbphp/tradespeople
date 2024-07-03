<?php 

	// Require the bundled autoload file - the path may need to change
	// based on where you downloaded and unzipped the SDK
	require __DIR__ . '/twilio-php-master/Twilio/autoload.php';

	// Use the REST API Client to make requests to the Twilio REST API
	use Twilio\Rest\Client;

	function sendSMSTwilio($mobile_number, $message){
		// Your Account SID and Auth Token from twilio.com/console
		$sid	=	'AC089edaab59e8a4d1a93527e7b14d89cb';
		$token 	=	'7b5d61a20622d3d10d6cc720d0b79b5a';
		$client =	new Client($sid, $token);


		try {
			$client->messages->create($mobile_number, array('from' => '+18123018025','body' => $message));
			echo 'client===';print_r($client);
			echo 'client sid===';print_r($client->sid);
			return 'success';
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			return 'error';
		}
	}

	//$mobile_number='+917697632354' //----------- nielsh idea;
	//$mobile_number='+919009081085' //----------- prabal sir;
	//$mobile_number='+919340809455' //------------ nilesh jio;
	//$mobile_number='+919644441113'; //------------- sumit sir;
	//$message='Your OTP is: 125463';
	//echo $sms_status=sendSMSTwilio($mobile_number, $message);




?>