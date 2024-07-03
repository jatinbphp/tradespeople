<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_POST['address_search'])){
	$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$add_query = $_POST['address_search'];


$id=1;
$check_user_all	    =	$mysqli->prepare("SELECT search_api_key from admin where id=?");
$check_user_all->bind_param("i",$id);
$check_user_all->execute();
$check_user_all->store_result();
$check_user		=	$check_user_all->num_rows;  //0 1
if($check_user <= 0){
	$record		=	array('success'=>'false', 'msg'=>$msg_error_user_id); 
	jsonSendEncode($record);
}
$check_user_all->bind_result($search_api_key);
$check_user_all->fetch();

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.addressy.com/Capture/Interactive/Find/v1.10/json3.ws',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('Key' => $search_api_key,'Text' => $search_api_key,'Countries' => 'GB'),
  CURLOPT_HTTPHEADER => array(
    'Cookie: GCLB=CJan9vnu3OrZ3AE'
  ),
));

$response = curl_exec($curl);

		curl_close($curl);

		$return = array();

		if ($err) {
			$return['status'] = 0;
			$return['data'] = "cURL Error #:" . $err;
		} else {

			$data = json_decode($response);

			//echo '<pre>'; print_r($response); echo '</pre>';

			if ($data->Status == 'OK') {
				
                $record=array('success'=>'true','output'=>$response); 
			} else {
				$record=array('success'=>'false','output'=>$response); 
			}
			
		}

echo $response;
