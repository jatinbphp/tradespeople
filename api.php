<?php

$data = array(
    'username' => 'SaiBhaskar',
    'password' => 'Sbss@123'
  );
  $datamain=json_encode($data);
   $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://external-api.polytex.cloud/api/v1/Identity/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_POSTFIELDS =>$datamain       
        
        ));
        
        $response = curl_exec($curl);
        if($e = curl_error($curl)) {
            print_r( $e);
        }
        else
        {
            echo 'else  g';
            $re = json_decode($response);
			print_r($re);
        }
        curl_close($curl);
       

?>