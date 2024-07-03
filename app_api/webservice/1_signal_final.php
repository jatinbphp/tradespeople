<?php

function oneSignalNotificationSend($title, $message, $jsonData, $player_id_arr)
{
	$oneSignalAppId = "6fbd7b72-33f8-4e1a-8d7e-a0bca344cde9";
	$oneSignalAuthorization = "NDIzNDQ1ZTYtYTM4NS00NzZlLThmMTctZWNmNzRjM2RmOWMw";

	/*
	//------------------------------- push notification off ---------------------
	$final_result = 'Success';
	return $final_result ;
	*/

		// echo '$title='.$title;
	 // 	echo '$message='.$message;

	//print_r($player_id_arr);	
	$fields = array(
		"app_id" => $oneSignalAppId,
		"contents" => array("en" => $message),
		"headings" => array("en" => $title),
		//"included_segments"=>["All"],
		"include_player_ids" => $player_id_arr,
		"data" => array("action_json" => $jsonData),
		"ios_badgeType" => 'Increase',
		"ios_badgeCount" => 1,
		"priority" => 10,
	);


	$fields = json_encode($fields);
	// 	print("\nJSON sent:\n");

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Authorization: Basic ' . $oneSignalAuthorization
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);

	//print($response);

	$resultData = json_decode($response, true);

	$resultDataError = $resultData['errors'];
	$resultDataSuccess = $resultData['id'];

	if ($resultDataSuccess != '') {
		$final_result = 'success';
	} else {
		$final_result =  'error';
	}
	//return $final_result ;
}
	


/*$title = 'Truck Around';
$message = 'Truck Around Message';
//$action_data=array('user_id'=>'1','other_user_id'=>'1', 'action_id'=>'0', 'action'=>'login');
//$jsonData=json_encode($action_data);
$jsonData='NA';
$player_id_arr = array('d7de74c7-c8f5-4746-8a29-fa58b65374f4');
//$player_id_arr = 'NA';
echo $response = oneSignalNotificationSend($title, $message, $jsonData, $player_id_arr);
*/



function oneSignalNotificationProvider($title, $message, $jsonData, $player_id_arr)
{
	$oneSignalAppId = "97edcd66-3a73-4af3-9e5c-df59acc86fe1";
	$oneSignalAuthorization = "Y2JkYmI3NGMtMTdmMS00NzkzLTg5NWEtYzY4OTBkMjgxMGNj";

	/*
	//------------------------------- push notification off ---------------------
	$final_result = 'Success';
	return $final_result ;
	*/

	// 	echo '$title='.$title;
	// 	echo '$message='.$message;

	//print_r($player_id_arr);	
	$fields = array(
		"app_id" => $oneSignalAppId,
		"contents" => array("en" => $message),
		"headings" => array("en" => $title),
		//"included_segments"=>["All"],
		"include_player_ids" => $player_id_arr,
		"data" => array("action_json" => $jsonData),
		"ios_badgeType" => 'Increase',
		"ios_badgeCount" => 1,
		"priority" => 10,
	);


	$fields = json_encode($fields);
	// 	print("\nJSON sent:\n");

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Authorization: Basic ' . $oneSignalAuthorization
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);
	curl_close($ch);

	//print($response);

	$resultData = json_decode($response, true);

	$resultDataError = $resultData['errors'];
	$resultDataSuccess = $resultData['id'];

	if ($resultDataSuccess != '') {
		$final_result = 'success';
	} else {
		$final_result =  'error';
	}
	//return $final_result ;
}
