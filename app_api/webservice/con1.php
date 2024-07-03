<?php
     /* Database config */
    $hostname   =   'localhost';
    $username   =   'tradespeoplehub';
    $password =   '*k8WRi2SILD@LCu&';
//$db_password = 'bGlcOiHjOZ%F';
    $dbname     =   'tradespeoplehub';
    // $dbname     =   'youngiw2_trades_people_hub';


    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    if($mysqli->connect_error) {
        echo 'Database Connection Failed '; exit;
    }
    
    $app_name           =   'Tradespeoplehub';
    $website_url         = 	'https://www.tradespeoplehub.co.uk/'; 
    $app_url          	=	'https://www.tradespeoplehub.co.uk/app_api/';
    $app_url_verify          	=	'https://www.tradespeoplehub.co.uk/app_api/webservice/';
    $webservice_url   	=	$app_url.'webservice/';
    $image_upload_url 	=	$webservice_url.'images';
    $app_logo         	=	$webservice_url.'logo/logo_invert.png';
    $onerror          	=   $app_url.'admin/assets/images/users/placeholder.png';
    $homeowner          =   'https://www.tradespeoplehub.co.uk/app_api/shareurllink.php/?link=trademan://Notification_user/1';
$homeownerNew          = 'https://www.tradespeoplehub.co.uk/app_api/shareurllink.php/?link=trademan://Notification_user/1';
 $provider          = 'https://www.tradespeoplehub.co.uk/app_api/shareurllink.php/?link=tradeprovider://Notification/1';
   // Don't delete it, use for app side.
/**** 3.Extra Varaible Desclare like Project Name,URL etc END **/

/** 4.Set_charset for use multiple languages data store in DB START **/
    $mysqli->set_charset('utf8mb4');
/** 4.Set_charset for use multiple languages data store in DB END**/

/** 5.Set time zone START **/
	/***** 1.India ******/
	//date_default_timezone_set('Asia/Kolkata');
	date_default_timezone_set('Europe/London');
/** 5.Set time zone END**/

/**  6.Encode /Decode Key START **/
    $skey   = "5SuPerEncKey2012"; // you can change it
/**  6.Encode /Decode Key END **/

/** 7.E-Mail informations START **/
//-------------------- E-Mail informations ----------------------
//$mail_host = 'mail.youngdecade.org';
//$mail_username = 'info@youngdecade.org';
//$mail_password = 'Nileshyd@@26';
//$mail_SMTPSecure = 'ssl';
//$mail_port = '465';
//$mail_from = 'info@youngdecade.org';

$mail_host = 'ex4.mail.ovh.net';
$mail_username = 'info@tradespeoplehub.co.uk';
$mail_password = '@u)MXi,OM#g';
$mail_SMTPSecure = 'STARTTLS';
$mail_port = '587';
$mail_from = 'info@tradespeoplehub.co.uk';

//$mail_host = 'ssl0.ovh.net';
//$mail_username = 'support@tradespeoplehub.co.uk';
//$mail_password = '8tmlFjHkWF';
//$mail_SMTPSecure = 'TSL';
//$mail_port = '587';
//$mail_from = 'support@tradespeoplehub.co.uk';

$fromName           =   $app_name;

?>