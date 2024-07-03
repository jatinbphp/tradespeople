<?php 

// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

function sendSMSTwilio($mobile_number, $message){
// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACfbed8525be29a91b941a25b97e3e2921';
$token = 'db3735a316d0934b019a1c1b951d32fc';
$client = new Client($sid, $token);


try {
	
$client->messages->create($mobile_number, 
	array('from' => '+15702859617','body' => $message)
);

//echo $client;
//print_r($client);
return 'success';
}

//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
  return 'error';
}
}



$mobile_number='+919340809455';
//$mobile_number='+966550681870';
$message='Your OTP is: 125463';
echo $sms_status=sendSMSTwilio($mobile_number, $message);




?>