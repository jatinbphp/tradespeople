<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_GET){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_GET['post_code'])){
	$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$post_code = $_GET['post_code'];

$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.postcodes.io/postcodes/".$post_code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$return = array();

		if ($err) {
			$return['status'] = 0;
			$return['data'] = "cURL Error #:" . $err;
		} else {

			$response = json_decode($response);

			//echo '<pre>'; print_r($response); echo '</pre>';

			if ($response->status == '200') {

				$admin_county = $response->result->admin_county;

				if (!$admin_county) {
					$admin_county = $response->result->region;
				}

				$return['longitude'] = $response->result->longitude;
				$return['latitude'] = $response->result->latitude;
				$return['primary_care_trust'] = $response->result->admin_district;
				$return['country'] = $admin_county;
				$return['address'] = $response->result->european_electoral_region;
				$return['region'] = $response->result->region;
				$return['status'] = 1;
			} else {
				$return['status'] = 0;
				$return['msg'] = "Please enter valid UK postcode";
			}
			
		}

$record=array('success'=>'true','conversation_arr'=>$return); 
jsonSendEncode($return);
