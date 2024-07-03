<?php

include('paypal_config.php');

include('paypal_create_token.php');



if(!$_POST)

{

$record=array('success'=>'false',

'msg' =>array('Please use post method !!!','Please use post method !!!','Please use post method !!!')); 

$data = json_encode($record);

echo $data;

return;

}





if(empty($_POST['user_id'])){

$record=array('success'=>'false',

'msg' =>array('Please send user_id','Please send user_id!','Please send user_id')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['event_id'])){

$record=array('success'=>'false',

'msg' =>array('Please send event_id','Please send event_id','Please send event_id')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['amount'])){

$record=array('success'=>'false',

'msg' =>array('Please send amount','Please send amount','Please send amount')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['payment_id'])){

$record=array('success'=>'false',

'msg' =>array('Please send payment_id','Please send payment_id','Please send payment_id')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['payer_id'])){

$record=array('success'=>'false',

'msg' =>array('Please send payer_id','Please send payer_id','Please send payer_id')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['token_return'])){

$record=array('success'=>'false',

'msg' =>array('Please send token_return','Please send token_return','Please send token_return')); 

$data = json_encode($record);

echo $data;

return;

}



if(empty($_POST['execute_url'])){

$record=array('success'=>'false',

'msg' =>array('Please send execute_url','Please send execute_url','Please send execute_url')); 

$data = json_encode($record);

echo $data;

return;

}





$user_id=$_POST['user_id'];

$event_id=$_POST['event_id'];

$total_amount=$_POST['amount'];

$payment_id=$_POST['payment_id'];

$payer_id=$_POST['payer_id'];

$token_return=$_POST['token_return'];

$execute_url=$_POST['execute_url'];





//-------------------- get token ------------------

$token=getPayPalToken();

if($token == 'error_token'){

	$record=array('success'=>'false',

	'msg' =>array('Internal serve error in PayPal Authentication','Internal serve error in PayPal Authentication','Internal serve error in PayPal Authentication')); 

	$data = json_encode($record);

	echo $data;

	return;

}else if($token == 'error'){

	$record=array('success'=>'false',

	'msg' =>array('Internal serve error','Internal serve error','Internal serve error')); 

	$data = json_encode($record);

	echo $data;

	return;

}else{

	//echo 'token='.$token;



	$data = array('payer_id'=>$payer_id);

	$dataSend= json_encode($data);

	

	$ch = curl_init();



	curl_setopt($ch, CURLOPT_URL, $execute_url);

	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(

	  "Content-Type: application/json",

	  "Authorization: Bearer $token ", 

	  "Content-length: ".strlen($dataSend))

	);



	$result = curl_exec($ch);

	

	//print_r($result);



	if(empty($result)){

		$record=array('success'=>'false',

		'msg' =>array('Internal serve error in PayPal Approved','Internal serve error in PayPal Approved','Internal serve error in PayPal Approved')); 

		$data = json_encode($record);

		echo $data;

		return;

	}else{

		$json = json_decode($result);

		$error=isset($json->error);

		//$error=property_exists($result, 'name');

		//echo 'tokennn='.$token=$json->access_token;



		//$message=property_exists($result, 'message');

		if($error != ''){



			$error=$json->name;

			$message=$json->message;



			if($error == 'INVALID_PAYER_ID'){

				$record=array('success'=>'false',

				'msg' =>array('Internal serve error in PayPal, '.$message,'Internal serve error in PayPal, '.$message,'Internal serve error in PayPal, '.$message)); 

				$data = json_encode($record);

				echo $data;

				return;

			}else if($error == 'PAYMENT_ALREADY_DONE'){

				$record=array('success'=>'false',

				'msg' =>array('Internal serve error in PayPal, '.$message,'Internal serve error in PayPal, '.$message,'Internal serve error in PayPal, '.$message)); 

				$data = json_encode($record);

				echo $data;

				return;

			}else{

				$record=array('success'=>'false',

				'msg' =>array('Internal serve error in PayPal.','Internal serve error in PayPal.','Internal serve error in PayPal.')); 

				$data = json_encode($record);

				echo $data;

				return;

			}

		}else{

		

			$state=$json->state;

			//$state=property_exists($result, 'state');

			if($state != 'approved'){

				$record=array('success'=>'false',

				'msg' =>array('Internal serve error in PayPal, payment not approved','Internal serve error in PayPal, payment not approved','Internal serve error in PayPal, payment not approved')); 

				$data = json_encode($record);

				echo $data;

				return;

			}else{

				//--------------------- insert payment details in database --------------

				$token='';

				$payment_status=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);

				if($payment_status == 'error'){

					$payment_status_again=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);

					if($payment_status_again == 'error'){

						$record=array('success'=>'false',

						'msg' =>array('Internal serve error, payment insert','Internal serve error, payment insert','Internal serve error, payment insert')); 

						$data = json_encode($record);

						echo $data;

						return;

					}else{

						$record=array('success'=>'true',

						'msg' =>array('Payment successfully','Payment successfully','Payment successfully'),'data'=> $json); 

						$data = json_encode($record);

						echo $data;

						return;

					}

				}else{

					$record=array('success'=>'true',

					'msg' =>array('Payment successfully','Payment successfully','Payment successfully'),'data'=> $json); 

					$data = json_encode($record);

					echo $data;

					return;

				}

			}

		}

	}

}





function insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token){

include('con1.php');

	

	

$createtime=date('Y-m-d H:i:s');

$inserttime=date('Y-m-d H:i:s');

$send_key=$user_id.'-'.$event_id;

$amount=$total_amount;

$payment_status='success';

$payment_type='paypal';





$insert=$mysqli->prepare("insert into event_payment_master(event_id, user_id, amount, payment_status, payment_type, send_key, createtime, inserttime) values(?,?,?,?,?,?,?,?)");

$insert->bind_param("iissssss",$event_id, $user_id, $amount, $payment_status, $payment_type, $send_key, $createtime, $inserttime);

$insert->execute();

//echo 'error'.mysqli_error($mysqli);

$insert_check=$mysqli->affected_rows;

if($insert_check <= 0)

{

	return 'error';		

}else{

	$event_payment_id=$mysqli->insert_id;



	//--------------------- insert payment type details --------------

	$insert_details=$mysqli->prepare("insert into event_payment_paypal_master(event_payment_id, total_amount, payment_id, payer_id, execute_url, token, token_return, createtime, inserttime) values(?,?,?,?,?,?,?,?,?)");

	$insert_details->bind_param("issssssss",$event_payment_id, $total_amount, $payment_id, $payer_id, $execute_url, $token, $token_return, $createtime, $inserttime);

	$insert_details->execute();

	//echo 'error'.mysqli_error($mysqli);

	$insert_details_check=$mysqli->affected_rows;

	if($insert_details_check<=0)

	{

		$delete=$mysqli->prepare("Delete from event_payment_paypal_master where event_payment_id =?");

		$delete->bind_param("i",$event_payment_id);

		$delete->execute();

		$delete_check=$mysqli->affected_rows;

		if($delete_check<=0)

		{

			return 'error';

		}else{

			return 'success';

		}

	}else{

		return 'success';	

	}

}

		

}//function closed



/*

echo $payment_status=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);

*/







?>