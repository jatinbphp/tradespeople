<?php

require 'vendor/autoload.php';

// This is your real test secret API key.
\Stripe\Stripe::setApiKey('sk_test_1Cf21TjwImZKGI8bY2aS6xbW00Es13tavF');

// $stripe->refunds->create([
//   'charge' => 'ch_1HuIh6B98kAf1brYjpbPUuN0', //payment charge id
//   'reason'=>'Refund from appname for reasontype',//Type app name with refund reason
//   'refund_application_fee'=>'TRUE', // if application fee need to return if any fee between connected account
//   'reverse_transfer'=>'TRUE' // if any transfer made to connected account
// ]);

$refund = \Stripe\Refund::create([
            'charge' => 'ch_1HuIh6B98kAf1brYjpbPUuN0',
        'reason'=>'requested_by_customer',//duplicate, fraudulent, and requested_by_customer =Types
        ]); 

  $output = [
    'success'=>'true','refundstatus' => $refund
  ];
  
    echo json_encode($output);
  
  return;

// // Store whole refund json into database for ref.
//{
//   "id": "re_1HuFYYFJZLdxN2fuWFPXmqkH",
//   "object": "refund",
//   "amount": 100,
//   "balance_transaction": null,
//   "charge": "ch_1FHmRsFJZLdxN2fuOA0Ukg3f",
//   "created": 1606993262,
//   "currency": "usd",
//   "metadata": {},
//   "payment_intent": null,
//   "reason": null,
//   "receipt_number": null,
//   "source_transfer_reversal": null,
//   "status": "succeeded",
//   "transfer_reversal": null
// }

?>