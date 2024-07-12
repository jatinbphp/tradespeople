<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('getDistance')) {
	function getDistance($addressFrom, $addressTo) {
		
		// Google API key
    $apiKey = 'AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c';
    
    // Change address format
    $formattedAddrFrom = str_replace(' ', '+', $addressFrom);
		$formattedAddrTo = str_replace(' ', '+', $addressTo);
		
		$link = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$formattedAddrFrom."&destinations=".$formattedAddrTo."&sensor=false&key=".$apiKey."&mode=driving&departure_time=now&units=imperial"; 
		
		$api = file_get_contents($link);
		
		$data = json_decode($api);
		//$result['all'] = $data;
		$status = $data->status;
		
		if($status=='OK'){
			
			$result['status'] = 1;
			
			/*$distance = $data->rows[0]->elements[0]->distance;
			
			$meter = $distance->value;
			
			$miles = 0.000621371*$meter;
			$miles = $miles-2;
			
			$new_value = round($miles,1);
			
			if($new_value <= 1){
				$distance->text = 'within 1 mile';
			} else {
				$distance->text = $new_value.' miles';
			}
			
			$distance->value = $new_value;
			
			
			
			$result['short'] = get_shortest_route($data->routes);
			$result['distance'] = $distance;*/
			$result['distance'] = $data->rows[0]->elements[0]->distance;
			$result['duration_in_traffic'] = $data->rows[0]->elements[0]->duration_in_traffic;
			$result['duration'] = $data->rows[0]->elements[0]->duration;
		
		} else {
			$result['status'] = 0;	
		}
		/*
		
		// Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
    $outputFrom = json_decode($geocodeFrom);
    if(!empty($outputFrom->error_message)){
        $result['status'] = 0;
				
				return $result;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        $result['status'] = 0;
				
				return $result;
    }
    
    // Get latitude and longitude from the geodata
    $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
    $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo    = $outputTo->results[0]->geometry->location->lng;
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    $miles    = $dist * 60 * 1.1515;
    
		$text = round($miles, 2).' miles';
		
   
		$result['status'] = 1;
		
		$distance->text = $text;
		$distance->value = $miles;
		
		$result['distance'] = $distance;*/
		return $result;
	}
}
if(!function_exists('date_difference')){
	function date_difference($date1=null,$date2=null){
		if(!$date1){
			$date1  = date('Y-m-d H:i:s');
		}

		if(!$date2){
			$date2  = date('Y-m-d H:i:s');
		}
		$diff = strtotime($date2) - strtotime($date1);

		$days = floor($diff / 86400);
		$hours = floor(($diff % 86400) / 3600);
		$minutes = floor(($diff % 3600) / 60);
		return [
			'days' => $days > 0 ? $days : 0,
			'hours' => $hours > 0 ? $hours : 0,
			'minutes' => $minutes > 0 ? $minutes : 0,
		];
	}
}
if (!function_exists('getDistanceByLatLng')) {
	function getDistanceByLatLng($lat1, $lon1, $lat2, $lon2,$unit='M') { 
		
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
				$return = ($miles * 1.609344);
		} else if ($unit == "N") {
				$return = ($miles * 0.8684);
		} else {
				$return = $miles;
		}
		
		return round($return,1);
	}
}
if (!function_exists('get_shortest_route')) {
function get_shortest_route($routes)
{
    if(!$routes){
        return null;
    }

    $shortest_route = $routes[0];
    foreach($routes as $index => $route){

        if(!isset($routes[$index+1])){
            break;
        }

        $totalDistance1 = 0;
        foreach($route->legs as $leg){
            $totalDistance1 += $leg->distance->value;
        }

        $totalDistance2 = 0;
        foreach($route[$index+1]->legs as $leg){
            $totalDistance2 += $leg->distance->value;
        }

        $shortest_route = $totalDistance1 < $totalDistance2 ? $route : $routes[$index+1];

    }

    return $shortest_route;
}
}
if (!function_exists('short_number')) {
	function short_number($n) {
		if ($n < 1000) {
			$n_format = number_format($n);
		} else if ($n < 1000000) {
			$n_format = number_format($n / 1000, 1) . 'K';
			// Anything less than a million
		} else if ($n < 1000000000) {
			// Anything less than a billion
			$n_format = number_format($n / 1000000, 1) . 'M';
		} else {
			// At least a billion
			$n_format = number_format($n / 1000000000, 1) . 'B';
		}
		
		return $n_format;
	}
}

if (!function_exists('time_ago')) {
	function time_ago($timestamp){  
		$time_ago = strtotime($timestamp);  
		$current_time = time();  
		$time_difference = $current_time - $time_ago;  
		$seconds = $time_difference;  
		$minutes = round($seconds / 60) ;// value 60 is seconds
		$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
		$days = round($seconds / 86400); //86400 = 24 * 60 * 60;
		$weeks = round($seconds / 604800);// 7*24*60*60;
		$months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
		$years = round($seconds / 31553280);//(365+365+365+365+366)/5 * 24 * 60 * 60  
		if($seconds <= 60) { 
		
			return "Just Now";
			
		} else if($minutes <=60) { 
		
			if($minutes==1) {  
				return "one minute ago";  
			} else {  
				return "$minutes minutes ago";  
			}  
			
		} else if($hours <=24) {  
			
			if($hours==1) {  
				return "an hour ago";  
			} else  {  
				return "$hours hrs ago";  
			}  
			
		} else if($days <= 7) {  
			if($days==1) {  
				return "yesterday";  
			} else  {  
				return "$days days ago";  
			}  
		} else if($weeks <= 4.3) {  
			
			if($weeks==1) {  
				return "a week ago";  
			}  else  {  
				return "$weeks weeks ago";  
			}  
		}  else if($months <=12) { 
		
			if($months==1) {  
				return "a month ago";  
			} else {  
				return "$months months ago";  
			}  
		}  else {  
			if($years==1) {  
				return "one year ago";  
			} else  {  
				return "$years years ago";  
			}  
		}  
	}
}

function html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text[$i];
        $result .= $symbol;

        switch ($symbol)
        {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes)
                   $in_double_quotes = false;
               else
                   $in_double_quotes = true;

            break;

            case "'":
              if ($in_single_quotes)
                  $in_single_quotes = false;
              else
                  $in_single_quotes = true;

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}
if (!function_exists('getRecordOnId'))
{
    function getRecordOnId($table, $where){
        $CI =& get_instance();
        $CI->db->from($table);
        $CI->db->where($where);
        $query = $CI->db->get();
        return $query->row_array();
    }
}

if (!function_exists('getCatName'))
{
    function getCatName($id){
        $CI =& get_instance();
        $CI->db->from('category');
        $CI->db->where('cat_id' , $id);
        $query = $CI->db->get();
        return $query->row_array();
    }
}

if (!function_exists('GetUserUniqueId'))
{
    function GetUserUniqueId(){
        $CI =& get_instance();
        $CI->db->from('users');
        $CI->db->limit(10);
		$CI->db->order_by('id','desc');
		$CI->db->select('unique_id');
        $query = $CI->db->get();
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			$unique_id = $data['unique_id'] + 1;
		} else {
			$unique_id = 100001;
		}
        return $unique_id;
    }
}

if (!function_exists('getParent'))
{
    function getParent($cat_parent=0){
        $CI =& get_instance();
        $CI->db->select('cat_id,cat_name,slug,cat_parent');
        $CI->db->from('category');
        $CI->db->where('cat_parent' , $cat_parent);
        $CI->db->where('is_delete' , 0);
        $query = $CI->db->get();
        $data = $query->result_array();
				$return = array();
				$i = 0;
				foreach($data as $key => $a){
					$return[$key] = $a;
					$return[$key]['child'] = [];
					if(checkChild($a['cat_id'])){
						$return[$key]['child'] = getChild($a['cat_id']);
					}
					
				}
				return $return;
    }
}

if (!function_exists('getChild'))
{
    function getChild($cat_parent=0,$result = array()){
        $CI =& get_instance();
        $CI->db->select('cat_id,cat_name,slug,cat_parent');
        $CI->db->from('category');
        $CI->db->where('cat_parent' , $cat_parent);
        $CI->db->where('is_delete' , 0);
        $query = $CI->db->get();
        $data = $query->result_array();
				$i = 0;
				foreach($data as $key => $a){
					array_push($result,$a);
					if(checkChild($a['cat_id'])){
						getChild($a['cat_id'],$result);
					}
					
				}
				return $result;
    }
}

if (!function_exists('checkChild'))
{
    function checkChild($cat_parent=0){
        $CI =& get_instance();
        $CI->db->select('count(cat_id) as total');
        $CI->db->from('category');
        $CI->db->where('cat_parent' , $cat_parent);
        $CI->db->where('is_delete' , 0);
        $query = $CI->db->get();
        $data = $query->row_array();
				$return = 0;
				if($data && $data['total'] > 0){
					$return = 1;
				}
				return $return;
    }
}

if (!function_exists('GetCardDetailByApi'))
{
	function GetCardDetailByApi($payment_method){
		$CI =& get_instance();
		// code...
		$url = 'https://api.stripe.com/v1/payment_methods/'.$payment_method;
		$stripe_secret = $CI->config->item('stripe_secret');
                
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer ".$stripe_secret
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

// echo "<pre>"; print_r($response->billing_details->name); exit;




		if(isset($response->id) && isset($response->card)){
		
			$row['card_u_name'] = $response->billing_details->name;
			$row['last4'] = $response->card->last4;
			$row['exp_month'] = $response->card->exp_month;
			$row['exp_year'] = $response->card->exp_year;
			$row['brand'] = $response->card->brand;
			$row['country'] = $response->card->country;
			return $row;
		} else {
			return false;
		}

	}
}

if (!function_exists('time_ago')) {
    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
