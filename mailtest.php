<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
$mail->isSMTP();

/*$mail->Host     =  'ssl0.ovh.net';
$mail->SMTPAuth = true;
$mail->Username = 'verify@tradespeoplehub.co.uk';
$mail->Password = 'nTrK!2$LS@xb';
$mail->SMTPSecure = 'tsl';
$mail->Port     = 587;*/

$mail->Host     =  'smtp.office365.com';
$mail->SMTPAuth = true;
$mail->Username = 'info@friendmypet.com';
$mail->Password = 'Reemby01@@';
$mail->SMTPSecure = 'STARTTLS';
$mail->Port     = 587;
$mail->CharSet = 'UTF-8';

$mail->setFrom('info@friendmypet.com', 'test');

//$to = 'softanz.webcreator@gmail.com';
$to = 'anil.webwiders@gmail.com'; 


$subject = "HTML email";

$mail->addAddress($to);
			
$mail->Subject = $subject;

$mail->isHTML(true);

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

$mail->Body = $message;
			
if(!$mail->send()) {
	//print_r($mail);
	echo "Mailer Error: " . $mail->ErrorInfo;

	echo 'error';
	
} else {
	echo 'success';
}

?>