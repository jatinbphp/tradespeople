<?php
function getPayPalToken(){
include('con1.php');
//-------------------------- select token --------------------	
$select_token_all=$mysqli->prepare("select token_id, token, expires_in, inserttime from paypal_token_master");
//$select_token_all->bind_param("i",$token_id);
$select_token_all->execute();
$select_token_all->store_result();
$select_token=$select_token_all->num_rows;
if($select_token > 0){
    $select_token_all->bind_result($token_id, $token, $expires_in, $inserttime);
	$select_token_all->fetch();
	//------------------- check token expires or not ---------------
	$nexttokentime = date("Y-m-d H:i:s", (strtotime(date($inserttime)) + $expires_in));
	$current_time_new = date("Y-m-d H:i:s");
	if($current_time_new < $nexttokentime){
		return $token;
	}else{
		//----------------------- crate a token again ------------------
		$token_status=createPayPayToken();
		if($token_status == 'error'){
			return 'error_token';
		}else{
			$token_status_data=explode('@#@',$token_status);
			$token=$token_status_data[0];
			$expires_in=$token_status_data[1];
			//------------------------ insert token -------------------
			$inserttime=date('Y-m-d H:i:s');
			$update=$mysqli->prepare("update paypal_token_master set token=?, expires_in=?, inserttime=? where token_id=?");
			$update->bind_param("sssi",$token, $expires_in, $inserttime, $token_id);
			$update->execute();
			$update_check=$mysqli->affected_rows;
			if($update_check<=0){
				return 'error';
			}else{
				return $token;
			}
		}
	}
}else{
	//----------------------- crate a token first time ------------------
	$token_status=createPayPayToken();
	if($token_status == 'error'){
		return 'error_token';
	}else{
		$token_status_data=explode('@#@',$token_status);
		$token=$token_status_data[0];
		$expires_in=$token_status_data[1];
		//------------------------ insert token -------------------
		$inserttime=date('Y-m-d H:i:s');
		$insert=$mysqli->prepare("insert into paypal_token_master(token, expires_in, inserttime)values(?,?,?)");
		$insert->bind_param("sss",$token, $expires_in, $inserttime);
		$insert->execute();
		$insert_check=$mysqli->affected_rows;
		if($insert_check<=0){
			return 'error';
		}else{
			return $token;
		}
	}
}				
}//function closed



/*
$token=getPayPalToken();
if($token == 'error_token'){
	echo 'error to create a token';
}else if($token == 'error'){
	echo 'error to mysql';
}else{
	echo 'token='.$token;
}
*/



function createPayPayToken(){
    include('paypal_config.php');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $paypal_token_url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $result = curl_exec($ch);
    //print_r($result);
    if(empty($result)){
    	return 'error';
    }else{
    	$json = json_decode($result);
    	//$error=property_exists($result, 'error');
    	//$error=$json->error;
    	$error=isset($json->error);
    	if($error != ''){
    		return 'error';
    	}else{
    		$token=$json->access_token;
    		//$token=property_exists($result, 'access_token');
    		$expires_in=$json->expires_in;
    		//$expires_in=property_exists($result, 'expires_in');
    		// $token='1234564546';
    		// $expires_in='100';
    		$token_expires_in=$token.'@#@'.$expires_in;
    		return $token_expires_in;
    	}
    }
}//function closed create token

//echo $token_status=createPayPayToken();

?>