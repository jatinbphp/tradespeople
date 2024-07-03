<?php
$key = "AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c";
$postal_code = 'SW1A 1AA';
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($postal_code)."&sensor=false&key=".$key;
$result_string = file_get_contents($url);
$result = json_decode($result_string, true);
 print_r($result);
?>