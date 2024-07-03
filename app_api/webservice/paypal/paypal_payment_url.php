<?php
include('paypal_config.php');
include('paypal_create_token.php');

if(!$_GET){
    $record=array('success'=>'false','msg' =>array('Please use get method !!!','Please use get method !!!')); 
    $data = json_encode($record);
    echo $data;
    return;
}

if(empty($_GET['user_id'])){
    $record=array('success'=>'false','msg' =>array('Please send user_id','Please send user_id')); 
    $data = json_encode($record);
    echo $data;
    return;
}

// if(empty($_GET['event_id'])){
//     $record=array('success'=>'false','msg' =>'Please send event_id'); 
//     $data = json_encode($record);
//     echo $data;
//     return;
// }

if(empty($_GET['amount'])){
    $record=array('success'=>'false','msg' =>array('Please send amount','Please send amount')); 
    $data = json_encode($record);
    echo $data;
    return;
}

if(empty($_GET['currency'])){
    $record=array('success'=>'false','msg' =>array('Please send currency','Please send currency')); 
    $data = json_encode($record);
    echo $data;
    return;
}

$event_id = date('ymdhis');
$user_id    =   $_GET['user_id'];
// $event_id   =   $_GET['event_id'];
$amount     =   $_GET['amount'];
$currency   =   $_GET['currency'];

$currency  = 'GBP'; // USD//GBP
//$country_stripe  = 'gb';  // us//gb

//-------------------- get token ------------------

$token=getPayPalToken();

if($token == 'error_token'){
	$record=array('success'=>'false','msg' =>array('Internal server error in PayPal Authentication','Internal server error in PayPal Authentication')); 
	$data = json_encode($record);
	echo $data;
	return;
}else if($token == 'error'){
	$record=array('success'=>'false','msg' =>array('Internal server error','Internal server error')); 
	$data = json_encode($record);
	echo $data;
	return;
}else{
	//echo 'token='.$token;
	$total= $amount;
	$transactions[]=array('amount'=>array('total'=>$total,'currency'=>$currency,'details'=>array('subtotal'=>$total)));
    $data=array('intent'=>'sale','payer'=>array('payment_method'=>'paypal'),'transactions'=>$transactions,'note_to_payer'=>'Contact us for any questions on your order.','redirect_urls'=>array('return_url'=>$return_url,'cancel_url'=>$cancel_url));
	$dataSend= json_encode($data);
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $paypal_payment_url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	  "Content-Type: application/json",
	  "Authorization: Bearer $token ", 
	  "Content-length: ".strlen($dataSend))
	);

	$result = curl_exec($ch);
	// print_r($result);
	if(empty($result)){
		$record=array('success'=>'false','msg' =>array('Internal server error in PayPal','Internal server error in PayPal')); 
		$data = json_encode($record);
		echo $data;
		return;
	}else{
		$json = json_decode($result);
		$error=isset($json->error);
		//$error=property_exists($result, 'error');
		if($error != ''){
			$record=array('success'=>'false','msg' =>array('Internal server error in PayPal2','Internal server error in PayPal2')); 
			$data = json_encode($record);
			echo $data;
			return;
		}else{
			$execute_url='no';
			$payment_id=$json->id;
			$links_arr=$json->links;
			//print_r($links_arr);
			foreach( $links_arr as $key ) {
				$href=$key->href;
				$rel=$key->rel;
				//echo '<br>rel='.$rel;
				$method=$key->method;
				if($rel == 'execute'){
					$execute_url=$href;
				}
			}
			// echo $execute_url;
			if($execute_url == 'no'){
				$record=array('success'=>'false','msg' =>array('Internal server error, temp url','Internal server error, temp url')); 
				$data = json_encode($record);
				echo $data;
				return;
			}else{
				//-------------- paypal data insert in temp table ----------
				$paypal_json=json_encode($json);
				$payment_temp_status=insertPaypalTempTable($user_id, $event_id, $payment_id, $execute_url, $paypal_json, $amount, $currency);
				if($payment_temp_status == 'error'){
					$record=array('success'=>'false','msg' =>array('Internal server error, temp','Internal server error, temp')); 
					$data = json_encode($record);
					echo $data;
					return;
				}
			}

			$record=array('success'=>'true','msg' =>array('Payment url create successfully','Payment url create successfully'),'data'=> $json); 
			$data = json_encode($record);
			echo $data;
			return;
		}

	}

}





//---------------------------- function paypal insert on temp table -----------------



function insertPaypalTempTable($user_id, $event_id, $payment_id, $execute_url, $paypal_json, $amount, $currency){
    include('con1.php');
    $delete_flag='0';
    $paypal_status='0';
    $createtime = date("Y-m-d H:i:s");
    $inserttime = date("Y-m-d H:i:s");
    
    //-------------------------- select token --------------------	
    $select_check_all=$mysqli->prepare("select user_id from event_payment_paypal_temp_master where user_id=? and event_id=?");
    $select_check_all->bind_param("ii",$user_id, $event_id);
    $select_check_all->execute();
    $select_check_all->store_result();
    $select_check=$select_check_all->num_rows;
    if($select_check<=0){
    	//-------------------------- insert record ---------------------
        // echo "insert into event_payment_paypal_temp_master(user_id, event_id, amount, currency, payment_id, execute_url, paypal_json, paypal_status, delete_flag, createtime, inserttime) values ($user_id, $event_id, $amount, $currency, $payment_id, $execute_url, $paypal_json, $paypal_status, $delete_flag, $createtime, $inserttime)";
    	$insert_check_all=$mysqli->prepare("insert into event_payment_paypal_temp_master(user_id, event_id, amount, currency, payment_id, execute_url, paypal_json, paypal_status, delete_flag, createtime, inserttime) values (?,?,?,?,?,?,?,?,?,?,?)");
    	$insert_check_all->bind_param("iisssssssss",$user_id, $event_id, $amount, $currency, $payment_id, $execute_url, $paypal_json, $paypal_status, $delete_flag, $createtime, $inserttime);
    	$insert_check_all->execute();
    	//echo 'error='.mysql_error($mysqli);
    	$insert_check=$mysqli->affected_rows;
    	if($insert_check<=0){
    		return 'error';
    	}else{
    		return 'success';
    	}
    }else{
    	//-------------------------- update old record -------------------
    	$update_check_all=$mysqli->prepare("update event_payment_paypal_temp_master set amount=?, currency=?,  payment_id=?, execute_url=?, paypal_json=?, inserttime=? where user_id=? and event_id=?");
    	$update_check_all->bind_param("ssssssii",$amount, $currency, $payment_id, $execute_url, $paypal_json, $inserttime, $user_id, $event_id);
    	$update_check_all->execute();
    	$update_check=$mysqli->affected_rows;
    	if($update_check<=0){
    		return 'error';
    	}else{
    		return 'success';
    	}
    }
}//function closed 



/*

//-------------------------- sample response in send to curl --------------

  $data = '{"intent": "sale",

  "payer": {

  "payment_method": "paypal"

  },

  "transactions": [

  {

    "amount": {

    "total": "10.11",

    "currency": "USD",

    "details": {

      "subtotal": "10.00",

      "tax": "0.07",

      "shipping": "0.03",

      "handling_fee": "1.00",

      "shipping_discount": "-1.00",

      "insurance": "0.01"

    }

    }

  }

  ],

  "note_to_payer": "Contact us for any questions on your order.",

  "redirect_urls": {

  "return_url": "http://youngdecadeprojects.biz/testing/paypal_restapi/success.php",

  "cancel_url": "http://youngdecadeprojects.biz/testing/paypal_restapi/cancel.php"

  }

}';



//-------------------------------------------- output response ---------------------

 ============ out put =========== 

{

    "id": "PAY-9MD629635T732425KLJDCQLQ",

    "intent": "sale",

    "state": "created",

    "payer": {

        "payment_method": "paypal"

    },

    "transactions": [

        {

            "amount": {

                "total": "11.11",

                "currency": "USD",

                "details": {

                    "subtotal": "11.00",

                    "tax": "0.07",

                    "shipping": "0.03",

                    "insurance": "0.01",

                    "handling_fee": "1.00",

                    "shipping_discount": "-1.00"

                }

            },

            "related_resources": []

        }

    ],

    "note_to_payer": "Contact us for any questions on your order.",

    "create_time": "2017-12-29T11:34:06Z",

    "links": [

        {

            "href": "https://api.paypal.com/v1/payments/payment/PAY-9MD629635T732425KLJDCQLQ",

            "rel": "self",

            "method": "GET"

        },

        {

            "href": "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-1VS70996AR990954M",

            "rel": "approval_url",

            "method": "REDIRECT"

        },

        {

            "href": "https://api.paypal.com/v1/payments/payment/PAY-9MD629635T732425KLJDCQLQ/execute",

            "rel": "execute",

            "method": "POST"

        }

    ]

}

*/

?>