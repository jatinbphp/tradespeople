<?php	

include 'con1.php';
include 'function_app_common.php'; 
include 'function_app.php'; 
include 'language_message.php';

if(!$_POST){
	$record=array('success'=>'false', 'msg' =>$msg_get_method); 
	jsonSendEncode($record);
}

if(empty($_POST['postcode'])){
	$record=array('success'=>'false u', 'msg' =>$msg_empty_param); 
	jsonSendEncode($record); 
}

$add_query = $_POST['postcode'];
$result = $_POST['result'];
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
  CURLOPT_URL => 'https://api.everythinglocation.com/address/capture?geocode',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
   "lqtkey":"'.$search_api_key.'",
   "query":"'.$add_query.'",
   "country":"GB",
   "result":"'.$result.'",
   "filters": {
      "Locality": "",
      "AdministrativeArea": ""
   }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

echo $response;
