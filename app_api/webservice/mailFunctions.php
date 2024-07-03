<?php

    include("mail/PHPMailerAutoload.php");
    function mailSend($email, $fromName, $subject, $mailBody, $mail_file='NA')
    {
		
		include('con1.php');
		
		//-------------------------------- php mail functions ---------------------------------------
		$mail = new PHPMailer;
		
		$mail->SMTPOptions = array(
		   'ssl' => array(
			   'verify_peer' => false,
			   'verify_peer_name' => false,
			   'allow_self_signed' => true
		   )
		);
		
        
		
		$mail->isSMTP();     // Set mailer to use SMTP
		$mail->Host 		=	$mail_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth 	=	true;                               // Enable SMTP authentication
		$mail->Username 	=	$mail_username;                 // SMTP username
		$mail->Password 	=	$mail_password;                 // SMTP password
		$mail->SMTPSecure 	=	$mail_SMTPSecure;               // Enable TLS encryption, `ssl` also accepted
		$mail->Port 		=	$mail_port;                     // TCP port to connect to
		$mail->From 		=	$mail_from;
		$mail->FromName 	=	$fromName;
		$mail->addAddress($email);    // Add a recipient
		//$mail->SMTPDebug = 1;
		
		$mail->isHTML(true);   // Add a recipient
		$mail->Subject = $subject;
		$mail->Body    = $mailBody;
	//	$mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
		//$mail->MsgHTML($body);

		// if($mail_file != 'NA'){
		// 	$mail->addAttachment('images/'.$mail_file);
		// }
		
		//-------------------------------------- check mail response send or not in proper ----------------------------
		if($mail->send()) {
			$mailResponse = 'yes';
		}
		else {
			$mailResponse = 'no';
		}
		return $mailResponse; 
		
		
		
		/*
		// ==================================
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		//$headers .= 'From: <info@tradespeoplehub.co.uk>' . "\r\n";		
		$headers .= 'From: '.ucwords('Tradespeoplehub').' <info@tradespeoplehub.co.uk>' . "\r\n".'X-Mailer: PHP/' . phpversion();

		
		//$subject = 'Tradespeoplehub';
		$response = mail($email,$subject,$mailBody,$headers);
		if($response==1) {
			$mailResponse = 'yes';
		}
		else {
			$mailResponse = 'no';
		}
		return $response;
		// ==================================
		*/
		
    
    }
	//-------------------- mailsend function closed 
	
	
/*
$app_name 	=	'test App';
$app_logo 	=	'test App';
$name 		=	'Nilesh';
$mailContent 		=	'hello';
$postData['mailContent'] =$mailContent; 
$email 		=	'jonpro@mailinator.com';
$fromName 	=	'Sign Up Email';
$subject 	=	'Sign Up Email ';
$mailBody 	=	mailBodySendDataEmailVerification($postData);
$mail_file 	=	'NA';
echo $mailResponse = mailSend($email, $fromName, $subject, $mailBody, $mail_file);
	*/

	


	function mailBodySendData($postData)
	{
		
		$body	=	'';
		$body .= '<!DOCTYPE html>
			<head>
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Welcome to '.$postData['app_name'].'</title>
			</head>

			<body style="margin: 0;	padding: 0; background-color:#fff; font-size:13px; color:#444; font-family:Arial, Helvetica, sans-serif;	padding-top:70px; padding-bottom:70px;">
				<table  cellspacing="0" cellpadding="0" align="center" width="768" class="outer-tbl" style="margin:0 auto;">
				<tr>
					<td class="pad-l-r-b" style="background-color:#ECEFF1; padding:0 70px 40px;">
						<table cellpadding="0" cellspacing="0" class="full-wid">
				
						</table>

					<table cellpadding="0" cellspacing="0"  style="width:100%; background-color:#FFFFFF; border-radius:4px;box-shadow:0 0 20px #ccc;margin-top:40px">
				<tr>
				<td>
					<table border="0" style="margin:0; width:100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="logo" style="padding:40px 0 30px 0; text-align:center; border-bottom:2px solid #fe8a0f">
								<img src="'.$postData['app_logo'].'" alt="" width="40%" >
								<h1>'.ucwords($postData['mail_heading']).'</h1>
							</td>
						</tr>
						<tr><td></td></tr>	
						<tr>
							<td class="content" style="padding:40px 40px;">
								<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0">
								Hello, '.ucwords($postData['name']).'</p>
								
								'.$postData['mailContent'].'
								
								<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0; font-weight:bold">
								Kind Regards,
								</p>
								<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333333; margin-top:0; font-weight:bold">The 
								'.ucwords($postData['app_name']).'
								</p>
							</td>
						</tr>
					
		 <tr> 
                                <td align="center" valign="top" style="background-color: #2b3133 ; color: white"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="center" valign="top" width="80%"> 
                                    <div style="margin: 0 ; padding: 0 ; color: #fff ; font-size: 13px">
                                    Copyright Â© 2022 
                                    <a href="https://www.mailinator.com/linker?linkid=899f9358-b0b5-4ec0-92c1-6c4801fff840" style="color: white ; text-decoration: none" target="_other" rel="nofollow">tradespeoplehub.co.uk</a>. All rights reserved.
                                    </div> </td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 							
								
					</table>
					</td>
				</tr>              
		</table>
		</td>
		</tr>        
		</table>
		</td>
		</tr>   
		</table>
		</body>
		</html>';
		return $body;
	}
	
	
	function mailBodySendDataEmailVerification($postData){
        $body = '';
        $body.=	'<html><head></head><body marginheight="0"><table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                        <tbody> 
                            <tr> 
                            <td align="center" valign="top"> 
                            <table border="0" cellpadding="10" cellspacing="0" width="700" style="border: 1px solid #ddd ; margin: 50px 0px 100px 0px ; text-align: center ; color: #363636 ; font-family: &quot;montserrat&quot; , &quot;arial&quot; , &quot;helvetica&quot; , sans-serif ; background-color: white"> 
                            <tbody> 
                                <tr> 
                                <td align="center" valign="top" style="border-bottom: 2px solid #fe8a0f ; padding: 0px ; background: -moz-linear-gradient(top , #fff , #f6f6f6) ; background: -webkit-linear-gradient(top , #fff , #f6f6f6)"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="center" style="text-align: center" valign="middle"><a style="font-family: &quot;ubuntu&quot; , sans-serif ; color: #ff3000 ; font-weight: 300 ; display: block ; letter-spacing: -1.5px ; text-decoration: none ; margin-top: 2px" href="https://www.mailinator.com/linker?linkid=62015647-6c7f-4b71-8d77-71e5653ee031" target="_other" rel="nofollow"><img src="https://www.tradespeoplehub.co.uk/img/logo_invert.png" style="padding-top: 0 ; display: inline-block ; vertical-align: middle ; margin-right: 0px ; height: 55px" class="CToWUd"></a></td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                                <tr> 
                                <td align="center" valign="top"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="left" valign="top" style="color: #444 ; font-size: 14px">
						
									<p style="margin: 0 ; font-size: 20px ; padding-bottom: 5px ; color: #2875d7">Please verify your email address.</p> <p style="margin: 0 ; padding: 10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email address using below code on the verification page.</p> 
                                    <div style="text-align: center">
                                        
                                   '.$postData['mailContent'].'

                                    </div>
									<p style="margin: 0 ; padding: 10px 0px">The code will expire three hours after the email was sent.</p>  
								<p style="margin: 0 ; padding: 10px 0px">Kind regards,</p> <p style="margin: 0 ; padding: 10px 0px">The Tradespeople Hub Team</p> </td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                                <tr> 
                                <td align="center" valign="top" style="background-color: #2b3133 ; color: white"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="left" valign="top" width="80%"> 
                                    <div style="margin: 0 ; padding: 0 ; color: #fff ; font-size: 13px">
                                    Copyright 2021 
                                    <a href="https://www.mailinator.com/linker?linkid=899f9358-b0b5-4ec0-92c1-6c4801fff840" style="color: white ; text-decoration: none" target="_other" rel="nofollow">tradespeoplehub.co.uk</a>. All rights reserved.
                                    </div> </td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                            </tbody> 
                            </table> </td> 
                            </tr> 
                        </tbody> 
                        </table> 
                        
                        <br><br><br><br><br><br><br></body></html>';
                        return $body;
    }

function mailBodySendDataEmailVerificationuser($postData){
        $body = '';
        $body.=	'<html><head></head><body marginheight="0"><table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                        <tbody> 
                            <tr> 
                            <td align="center" valign="top"> 
                            <table border="0" cellpadding="10" cellspacing="0" width="700" style="border: 1px solid #ddd ; margin: 50px 0px 100px 0px ; text-align: center ; color: #363636 ; font-family: &quot;montserrat&quot; , &quot;arial&quot; , &quot;helvetica&quot; , sans-serif ; background-color: white"> 
                            <tbody> 
                                <tr> 
                                <td align="center" valign="top" style="border-bottom: 2px solid #fe8a0f ; padding: 0px ; background: -moz-linear-gradient(top , #fff , #f6f6f6) ; background: -webkit-linear-gradient(top , #fff , #f6f6f6)"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="center" style="text-align: center" valign="middle"><a style="font-family: &quot;ubuntu&quot; , sans-serif ; color: #ff3000 ; font-weight: 300 ; display: block ; letter-spacing: -1.5px ; text-decoration: none ; margin-top: 2px" href="https://www.mailinator.com/linker?linkid=62015647-6c7f-4b71-8d77-71e5653ee031" target="_other" rel="nofollow"><img src="https://www.tradespeoplehub.co.uk/img/logo_invert.png" style="padding-top: 0 ; display: inline-block ; vertical-align: middle ; margin-right: 0px ; height: 55px" class="CToWUd"></a></td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                                <tr> 
                                <td align="center" valign="top"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="left" valign="top" style="color: #444 ; font-size: 14px"> <p style="margin: 0 ; font-size: 20px ; padding-bottom: 5px ; color: #2875d7">Please verify your email address.</p> <p style="margin: 0 ; padding: 10px 0px">Thanks for registering with Tradespeople Hub! To finish your sign up, please verify your email  by entering below otp.</p> 
                                    <div style="text-align: center">
                                        
                                   '.$postData['mailContent'].'

                                    </div> <p style="margin: 0 ; padding: 10px 0px">Kind regards,</p> <p style="margin: 0 ; padding: 10px 0px">The Tradespeople Hub Team</p> </td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                                <tr> 
                                <td align="center" valign="top" style="background-color: #2b3133 ; color: white"> 
                                <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
                                <tbody> 
                                    <tr> 
                                    <td align="left" valign="top" width="80%"> 
                                    <div style="margin: 0 ; padding: 0 ; color: #fff ; font-size: 13px">
                                    Copyright Â© 2021 
                                    <a href="https://www.mailinator.com/linker?linkid=899f9358-b0b5-4ec0-92c1-6c4801fff840" style="color: white ; text-decoration: none" target="_other" rel="nofollow">tradespeoplehub.co.uk</a>. All rights reserved.
                                    </div> </td> 
                                    </tr> 
                                </tbody> 
                                </table> </td> 
                                </tr> 
                            </tbody> 
                            </table> </td> 
                            </tr> 
                        </tbody> 
                        </table> 
                        
                        <br><br><br><br><br><br><br></body></html>';
                        return $body;
    }
function mailBodySendJob($postData){
        $body = '';
        $body.='<html><head></head><body marginheight="0"><table border="0" cellpadding="0" cellspacing="0" width="100%"> 
   <tbody> 
    <tr> 
     <td align="center" valign="top"> 
      <table border="0" cellpadding="10" cellspacing="0" width="700" style="border: 1px solid #ddd ; margin: 50px 0px 100px 0px ; text-align: center ; color: #363636 ; font-family: &quot;montserrat&quot; , &quot;arial&quot; , &quot;helvetica&quot; , sans-serif ; background-color: white"> 
       <tbody> 
        <tr> 
         <td align="center" valign="top" style="border-bottom: 2px solid #fe8a0f ; padding: 0px ; background: -moz-linear-gradient(top , #fff , #f6f6f6) ; background: -webkit-linear-gradient(top , #fff , #f6f6f6)"> 
          <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
           <tbody> 
            <tr> 
             <td align="center" style="text-align: center" valign="middle"><a style="font-family: &quot;ubuntu&quot; , sans-serif ; color: #ff3000 ; font-weight: 300 ; display: block ; letter-spacing: -1.5px ; text-decoration: none ; margin-top: 2px" href="https://www.mailinator.com/linker?linkid=a560ef65-ecb2-41a5-8b13-8ddd52104c01" target="_other" rel="nofollow"><img src="https://www.tradespeoplehub.co.uk/img/logo_invert.png" style="padding-top: 0 ; display: inline-block ; vertical-align: middle ; margin-right: 0px ; height: 55px" class="CToWUd"></a></td> 
            </tr> 
           </tbody> 
          </table> </td> 
        </tr> 
        <tr> 
         <td align="center" valign="top"> 
          <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
           <tbody> 
            <tr> 
             <td align="left" valign="top" style="color: #444 ; font-size: 14px"> <p style="margin: 0 ; padding: 10px 0px">Hi '.$postData['name'].' ,</p><p style="margin: 0 ; padding: 10px 0px">Your job '.$postData['title'].' was successfully posted on Tradespeoplehub.co.uk. You will start receiving quotes from our vetted tradespeople near you soon.</p>
              <div style="text-align: center">
              
              </div><p style="margin: 0 ; padding: 10px 0px">Visit our Homeowner help page or contact our customer services if you have any specific questions using our service.</p> <p style="margin: 0 ; padding: 10px 0px">Kind regards,</p> <p style="margin: 0 ; padding: 10px 0px">The Tradespeople Hub Team</p> </td> 
            </tr> 
           </tbody> 
          </table> </td> 
        </tr> 
        <tr> 
         <td align="center" valign="top" style="background-color: #2b3133 ; color: white"> 
          <table border="0" cellpadding="0" cellspacing="10" width="100%"> 
           <tbody> 
            <tr> 
             <td align="left" valign="top" width="80%"> 
              <div style="margin: 0 ; padding: 0 ; color: #fff ; font-size: 13px">
               Copyright © 2021 
               <a href="https://www.mailinator.com/linker?linkid=91668f42-a3c3-4d95-9ca1-b6d24bc0891d" style="color: white ; text-decoration: none" target="_other" rel="nofollow">tradespeoplehub.co.uk</a>. All rights reserved.
              </div> </td> 
            </tr> 
           </tbody> 
          </table> </td> 
        </tr> 
       </tbody> 
      </table> </td> 
    </tr> 
   </tbody> 
  </table> 
 
<br><br><br><br><br><br><br></body></html>';
 return $body;
}

function send_mail_withdraw_admin($postData) {
	$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
			<tbody>
				<tr>
					<td align="center" valign="top">
						<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
							<tbody>
								<tr>
									<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
										<table border="0" cellpadding="0" cellspacing="10" width="100%">
											<tbody>
												<tr>
													<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="'.$postData['app_url'].'"><img src="'.$postData['app_url'].'img/logo_invert.png" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="10" width="100%">
											<tbody>
												<tr>
													<td align="left" valign="top" style="color:#444;font-size:14px">
														'.$postData['mailContent'].'
														 <p style="margin:0;padding:10px 0px">Kind regards,</p>
														 <p style="margin:0;padding:10px 0px">The Project Team</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center" valign="top" style="background-color:#2b3133;color:white">
										<table border="0" cellpadding="0" cellspacing="10" width="100%">
											<tbody>
												<tr>
													<td align="left" valign="top" width="80%">
														<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © '.date('Y').' <a href="'.$postData['app_url'].'" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
													</td>
													
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>';	
	return  $msg;
}


function send_mail_app($body) {
		include('con1.php');
	$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
											<tbody>
												<tr>
													<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="'.$website_url.'"><img src="'.$app_logo.'"  style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" style="color:#444;font-size:14px">
																		'.$body.'
																		 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																		 <p style="margin:0;padding:10px 0px">The Tradespeople Hub Team</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top" style="background-color:#2b3133;color:white">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" width="80%">
																		<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © '.date('Y').' <a href="'.$website_url.'" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																	</td>
																	
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>';
	return $msg;
}



function send_mail_app_logo($body) {
		include('con1.php');
		
	$msg = '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" name="mjqemailid" content="B0WB7P9VV27ACYA96DTTHDGYXR1I0SUB">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="10" cellspacing="0" width="700" style="border:1px solid #ddd;margin:50px 0px 100px 0px;text-align:center;color:#363636;font-family:\'Montserrat\',Arial,Helvetica,sans-serif;background-color:white">
											<tbody>
												<tr>
													<td align="center" valign="top" style="border-bottom:2px solid #fe8a0f;padding:0px;background:-moz-linear-gradient(top,#fff,#f6f6f6);background:-webkit-linear-gradient(top,#fff,#f6f6f6);">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="center" style="text-align: center;" valign="middle"><a style="font-family:\'Ubuntu\',sans-serif;color:#ff3000;font-weight:300;display:block;letter-spacing:-1.5px;text-decoration:none;margin-top:2px" href="'.$website_url.'"><img src="'.$app_logo.'" style="padding-top:0;display:inline-block;vertical-align:middle;margin-right:0px;height:55px" class="CToWUd"></a></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" style="color:#444;font-size:14px">
																		'.$body.'
																		 <p style="margin:0;padding:10px 0px">Kind regards,</p>
																		 <p style="margin:0;padding:10px 0px">The Tradespeople Hub Team</p>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td align="center" valign="top" style="background-color:#2b3133;color:white">
														<table border="0" cellpadding="0" cellspacing="10" width="100%">
															<tbody>
																<tr>
																	<td align="left" valign="top" width="80%">
																		<div style="margin:0;padding:0;color:#fff;font-size:13px">Copyright © '.date('Y').' <a href="'.$website_url.'" style="color:white;text-decoration:none">tradespeoplehub.co.uk</a>. All rights reserved.</div>
																	</td>
																	
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>';
	return $msg;
}

?>
