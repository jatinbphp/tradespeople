<?php
//Header("Content-type:text/html; charset=UTF-8");

//Request data to SMS interface, check if the environment has curl init enabled.
Function Post($curlPost,$url){
        $curl = curl_init();
        Curl_setopt($curl, CURLOPT_URL, $url);
        Curl_setopt($curl, CURLOPT_HEADER, false);
        Curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        Curl_setopt($curl, CURLOPT_NOBODY, true);
        Curl_setopt($curl, CURLOPT_POST, true);
        Curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        Curl_close($curl);
        Return $return_str;
}

// Convert xml data to array format.
Function xml_to_array($xml){
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    If(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        For($i = 0; $i < $count; $i++){
        $subxml= $matches[2][$i];
        $key = $matches[1][$i];
            If(preg_match( $reg, $subxml )){
                $arr[$key] = xml_to_array( $subxml );
            }else{
                $arr[$key] = $subxml;
            }
        }
    }
    Return $arr;
}


//The random() function returns a random integer.
Function random($length = 6 , $numeric = 0) {
    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
    If($numeric) {
        $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
    } Else {
        $hash = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
        $max = strlen($chars) - 1;
        For($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
    }
    Return $hash;
}
//$mobile_code = random(4,1);

/*
http://106.ihuyi.com/webservice/sms.php?method=Submit&account=C09461422&password=
aacec3b0b83e725bba96f09a731e4d17&mobile=15618534993&content=您的验证码是：123456。请不要把验证码泄露给其他人。
*/


function sendSMSChina($mobile,$otp){
	
// SMS interface address
$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
// Get the phone number
//$mobile = '15618534993';
$send_code = $otp;
$account = 'C09461422';
$password = 'aacec3b0b83e725bba96f09a731e4d17';
 
$post_data = "account=".$account."&password=".$password."&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$send_code."。请不要把验证码泄露给其他人。");
//The username is the login ihuyi.com account name (example: cf_demo123)
//Check password, please login user center -> verification code, notification SMS -> account and signature settings -> APIKEY
$gets = xml_to_array(Post($post_data, $target));
If($gets['SubmitResult']['code']==2){
    return 'success';
}else{
	//Echo $gets['SubmitResult']['msg'];
	return 'error';
}

}

/*
//$mobile = '15618534993';//success;
$mobile = '13651809921‬';//The phone format is incorrect, the format is 11 digits. error;
//$mobile = '13671767402';//success;
//$mobile = ' 13437820993';//success;
//$mobile = ' 13681664579';//success;
$otp='1234';
echo $sms_status = sendSMSChina($mobile,$otp);
*/



?>