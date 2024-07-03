
<?php 
// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

function sendSMSTwilio($mobile_number, $message){
    
	// Your Account SID and Auth Token from twilio.com/console
	
	//----------------live keys ----------------
	$sid = 'ACab5b64078d1cb3634491ff491d05ddbb';
	$token = 'f599e5ee1891e5c45cbbac3f56144cd2'; 
	$client =	new Client($sid, $token);
	
	
    if($mobile_number == '7049413779' || $mobile_number == '8839875046'){
        $mobile_number = '+91'.$mobile_number;
    }
    else{
        $mobile_number = '+44'.$mobile_number;    
    }
    
    
	try {
		$client->messages->create($mobile_number, array('from' => 'TRADEPPLHUB','body' => $message));
		//$client->messages->create($mobile_number, array('body' => $message));
		//echo 'client===';print_r($client);
		//echo 'client sid===';print_r($client->sid);
		$response = array('status'=> 'true', 'message'=>'success');
	}
	catch(Exception $e) {
	    //echo 'client===';print_r($client);
		$response	=	array('status'=> 'false', 'message'=>$e->getMessage());
		// $response	=	array('status'=> 'false', 'message'=>'error');
	}
	return $response;
}




// //$mobile_number  =   '7354341437';
// $mobile_number  =   '7049413779';
// $message        =   'This is a test message by young decade';   
// $response       =   sendSMSTwilio($mobile_number, $message);
// echo 'response===';print_r($response);



?>