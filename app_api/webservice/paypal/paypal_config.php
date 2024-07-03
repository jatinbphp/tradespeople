<?php
//----------------------------- paypal config details --------------

	

//----------------------------------------------- test details ------------------------
//---------------------- token test url------------------
//$paypal_token_url='https://api.sandbox.paypal.com/v1/oauth2/token';

//---------------------- payment test url------------------
//$paypal_payment_url='https://api.sandbox.paypal.com/v1/payments/payment';

//-------- yd(handy) details test key  -------------------------
//$clientId =  "AV325DaJ1zJR1wW56FvhBB9VHv8dgRNNLMvNPihdaudYlhEb5BKT3Xws284HOW-q4LVaEbBLY2H9Rh9C";
//$secret  =  "EC7MgilMdWNfMYowNPbz41dJWwX7lRj3kF5S6ZzMRXANO9sYkeBN-LR8ZGcXq0Dseo93ZS4j-njCw8WP";



 //---------------------- token live  url------------------
$paypal_token_url='https://api.paypal.com/v1/oauth2/token';
//---------------------- payment live url------------------
$paypal_payment_url='https://api.paypal.com/v1/payments/payment';
 
//-------- trades details live key  -------------------------
$clientId = 'AUtBfhiwmFyyxq92m2H4lKKQyXsJ_kkkBAdFkwDfyNgijEFm-rJg9Ksihk6A2NqbzQzrCQxhrzZRw7hZ';
$secret = 'ECKzDXA0w0IEU0qfwSGoMEBSwxrf3RnTF76WVmJ7PhTyfsMPOJLO8nqjQgX-PVWk7w208VbJEEBe7xQC';
//----------------------------------------------end live details -----------------------



//------------------ payment url ------------------

// $return_url='https://meribhiapp.com/apartmend/webservice/paypal/paypal_success.php';
$return_url='https://www.tradespeoplehub.co.uk/app_api/webservice/paypal/paypal_success.php';
$cancel_url='https://www.tradespeoplehub.co.uk/app_api/webservice/paypal/paypal_cancel.php';

?>