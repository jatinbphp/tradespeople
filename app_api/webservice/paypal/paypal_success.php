<?php
include('con1.php');
include('paypal_config.php');
include('paypal_create_token.php');
$paymentId=$_GET['paymentId'];
$token_return=$_GET['token'];
$PayerID=$_GET['PayerID'];
if($paymentId !='' && $token_return !='' && $PayerID !=''){
$payer_id=$PayerID;
//----------------------------- select temp payment details ----------------
//-------------------------- select token --------------------	
$select_check_all=$mysqli->prepare("select paypal_temp_id, user_id, event_id, amount, payment_id, execute_url, paypal_json, paypal_status from event_payment_paypal_temp_master where payment_id=?");
$select_check_all->bind_param("s",$paymentId);
$select_check_all->execute();
$select_check_all->store_result();
$select_check=$select_check_all->num_rows;
if($select_check<=0)
{
	echo "<b>Payment Failed-1.</b>";
}else{
	
	$select_check_all->bind_result($paypal_temp_id, $user_id, $event_id, $amount, $payment_id, $execute_url, $paypal_json, $paypal_status);
	$select_check_all->fetch();
	if($paypal_status == '0'){
		//-------------------- get token ------------------
		$token=getPayPalToken();
		//echo 'execute_url='.$execute_url;
		
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
			curl_close ($ch);
			
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
						$total_amount=$amount;
						//$token='';
						$payment_status=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);
						if($payment_status == 'error'){
							$payment_status_again=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);
							if($payment_status_again == 'error'){
								$record=array('success'=>'false','msg' =>array('Internal serve error, payment insert','Internal serve error, payment insert','Internal serve error, payment insert')); 
                                $data = json_encode($record);
                                echo $data;
								return;
							}else{
                                
								$record=array('success'=>'true','msg' =>array('Payment successfully','Payment successfully','Payment successfully'),'data'=> $json); 
                                $data = json_encode($record);
                                
                                echo $data;
                                return;
							}
						}else{
                            //$rsvp_status=insertORDERTable($user_id, $event_id);
                            // echo $rsvp_status;
                           $last_id= $paymentId;
                           
							   	
                               ?>
                               <script>window.location.href="paypal_success_final.php?paymentId=<?=$last_id?>"</script>
                               <?php
                                /*$record=array('success'=>'true','msg' =>array('Payment successfully','Payment successfully','Payment successfully'),'data'=> $json); 
                                $data = json_encode($record);
                                echo $data;*/
				                return;
				              /*  
							if($rsvp_status['status'] == 'success'){
							   $last_id= $paymentId;
							   	
                               ?>
                               <script>window.location.href="paypal_success_final.php?paymentId=<?=$last_id?>"</script>
                               <?php
                               
				                return;
							}else{
								echo "<b>payment success but, RSVP not Insert.</b>";	
							} 
							*/
						}
					}
				}
			}
		}
	}
}
}else{
	echo "<b>Payment Failed.</b>";
}




function insertORDERTable($user_id, $event_id){
	
    include('con1.php');
    $delete_flag=0;
    $payment_id=$_GET['paymentId'];
    //-------------------------- check user_id --------------------------
    $check_user_all=$mysqli->prepare("SELECT user_id FROM user_master WHERE delete_flag=? AND user_id=?");
    $check_user_all->bind_param("ii",$delete_flag,$user_id);
    $check_user_all->execute();
    $check_user_all->store_result();
    $check_user=$check_user_all->num_rows;  //0 1
    if($check_user <= 0){
    	$record=array('status'=>'error','last_id'=>0);
		return $record;
    }else{
        $check_user_all->bind_result($user_id);
		$check_user_all->fetch();
    }
    //-------------------------- check job --------------------------

    $get_all_jobs = $mysqli->prepare("SELECT job_id,`job_number`, `user_id`, `titile`, `location_address`, `latitude`, `longitude`, `service_id`,`price`,`online_amount`, `wallet_amount`, `payment_mode`,txn_id,`provider_id`,instruction,`payment_status`, `status`,`createtime`, `updatetime` FROM `job_master_temp` WHERE job_id=? and delete_flag=0");
    $get_all_jobs->bind_param("i",$event_id);
    $get_all_jobs->execute();
    $get_all_jobs->store_result();
    $get_all = $get_all_jobs->num_rows;
    if($get_all<=0){
    	$record=array('status'=>'error','last_id'=>0);
		return $record;
    }else{
    	$get_all_jobs->bind_result($job_id,$job_number, $user_id, $titile, $location_address, $latitude, $longitude, $service_id, $price,$online_amount, $wallet_amount, $payment_mode, $txn_id, $provider_id, $instruction, $payment_status, $status, $createtime, $updatetime);
    	$get_all_jobs->fetch();
    }


    $payment_status = 1;
    $add_job = $mysqli->prepare("INSERT INTO `job_master`(`job_number`, `user_id`, `titile`, `location_address`, `latitude`, `longitude`, `service_id`,`price`,`online_amount`, `wallet_amount`, `payment_mode`,txn_id,`provider_id`,instruction,`payment_status`, `status`,`createtime`, `updatetime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $add_job->bind_param('sissssssssisisiiss',$job_number, $user_id, $titile, $location_address, $latitude, $longitude, $service_id, $price,$online_amount, $wallet_amount, $payment_mode, $payment_id, $provider_id, $instruction, $payment_status, $status, $createtime, $updatetime);
    $add_job->execute();
    $add_job_row = $mysqli->affected_rows;
   	$last_insert_id	=	$mysqli->insert_id;
    if ($add_job_row<=0) {
    	$record=array('status'=>'error','last_id'=>0);
		return $record;
    }


    $job_update_image = $mysqli->prepare("UPDATE job_image_master SET job_id=?, updatetime=? WHERE job_id=?");
	$job_update_image->bind_param("isi",$last_insert_id,$updatetime,$job_id);
	$job_update_image->execute();
	$job_update_image_count=$mysqli->affected_rows;
	 


	$job_update_job_available_image = $mysqli->prepare("UPDATE job_available_master SET job_id=?, updatetime=? WHERE job_id=?");
	$job_update_job_available_image->bind_param("isi",$last_insert_id,$updatetime,$job_id);
	$job_update_job_available_image->execute();
	$job_update_job_available_image_count=$mysqli->affected_rows;
	if ($job_update_job_available_image_count <= 0) {
		$record=array('status'=>'error','last_id'=>0);
		return $record;
	}

	if($payment_mode==2 || $payment_mode==3){
		$job_update_wallet = $mysqli->prepare("UPDATE wallet_master SET job_id=?, updatetime=? WHERE job_id=?");
		$job_update_wallet->bind_param("isi",$last_insert_id,$updatetime,$job_id);
		$job_update_wallet->execute();
		$job_update_wallet_count=$mysqli->affected_rows;
		if($job_update_wallet_image_count<=0){
			$record=array('status'=>'error','last_id'=>0);
			return $record;
		}
	}
	
	 
    $record=array('status'=>'success','last_id'=>$payment_id);
    return $record;

}



function insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token){
include('con1.php');
	
$createtime=date('Y-m-d H:i:s');
$inserttime=date('Y-m-d H:i:s');
$send_key=$user_id.'-'.$event_id;
$amount=$total_amount;
$payment_status='1';
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
			//--------------------------------- update payment status --------------
			$paypal_status='1';
			$update_check_all=$mysqli->prepare("update event_payment_paypal_temp_master set paypal_status=?, inserttime=? where user_id=? and event_id=?");
			$update_check_all->bind_param("ssii",$paypal_status, $inserttime, $user_id, $event_id);
			$update_check_all->execute();
			$update_check=$mysqli->affected_rows;
			if($update_check<=0){
				$update_check_all1=$mysqli->prepare("update event_payment_paypal_temp_master set paypal_status=?, inserttime=? where user_id=? and event_id=?");
				$update_check_all1->bind_param("ssii",$paypal_status, $inserttime, $user_id, $event_id);
				$update_check_all1->execute();
				$update_check1=$mysqli->affected_rows;
				if($update_check1<=0){
					return 'error';
				}else{
					return 'success';
				}
			}else{
				return 'success';
			}
		}
	}else{
		//--------------------------------- update payment status --------------
		$paypal_status='1';
		$update_check_all=$mysqli->prepare("update event_payment_paypal_temp_master set paypal_status=?, inserttime=? where user_id=? and event_id=?");
		$update_check_all->bind_param("ssii",$paypal_status, $inserttime, $user_id, $event_id);
		$update_check_all->execute();
		$update_check=$mysqli->affected_rows;
		if($update_check<=0){
			$update_check_all1=$mysqli->prepare("update event_payment_paypal_temp_master set paypal_status=?, inserttime=? where user_id=? and event_id=?");
			$update_check_all1->bind_param("ssii",$paypal_status, $inserttime, $user_id, $event_id);
			$update_check_all1->execute();
			$update_check1=$mysqli->affected_rows;
			if($update_check1<=0){
				return 'error';
			}else{
				return 'success';
			}
		}else{
			return 'success';
		}
	}
}
		
}//function closed
/*
echo $payment_status=insertPayPalPayment($user_id, $event_id, $total_amount, $payment_id, $payer_id, $token_return, $execute_url, $token);
*/
?>