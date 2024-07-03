 <?php
// session_start();
include("con1.php");
include("function_app.php");
include 'language_message.php';
include 'mailFunctions.php';
if(isset($_GET['unique_id']))
{
    $user_id = ($_GET['unique_id']);
     
    $updatetime = date('Y-m-d H:i:s');
    $check_email_all=$mysqli->prepare("SELECT `id`,f_name,email FROM `users` WHERE `unique_id`=?");
    $check_email_all->bind_param("i",$user_id);
    $check_email_all->execute();
    $check_email_all->store_result();
    $check_email=$check_email_all->num_rows;
    if($check_email > 0){
		
    		//--------------------- update email status -----------------------------
				$update_all = $mysqli->prepare("UPDATE users set u_email_verify =1 where unique_id =?");
				$update_all->bind_param("i",  $user_id);
				$update_all->execute();
				$update = $mysqli->affected_rows;
				if($update > 0){	
					 
					   ?>
                          <script type="text/javascript">
				             setTimeout(function(){
				            	//alert('This link is deactivated');
				                window.top.close();
				            },5000);
				        </script>
				        <?php
				}
		
		
		
       }
	$check_email_all->bind_result($unique_id,$f_name,$email);
	$check_email_all->fetch();
	 $subject	=	'Email verified successfully';

    $html = '<p style="margin:0;padding:10px 0px">Hi ' .$f_name .',</p>';
    $html .= '<p style="margin:0;padding:10px 0px">Your email address has successfully been verified. 
</p>';

$html .= '<br><p style="margin:0;padding:10px 0px">View our Help page or contact our customer services if you have any specific questions using our service.</p>';
$mailBody = send_mail_app_logo($html);


$email_arr[]				=	array('email'=>$email, 'fromName'=>$f_name, 'mailsubject'=>$subject, 'mailcontent'=>$mailBody);
$mailResponse  =  mailSend($email,$f_name, $subject, $mailBody);
}
?>
 <!DOCTYPE html>
   <head>
       <meta name="viewport" content="width=device-width, initial-scale=1" />
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <title>Welcome to <?php echo $app_name; ?></title>
   </head>
   <body style="margin: 0; padding: 0; background-color:#FFFFFF; font-size:13px; color:#444; font-family:Arial, Helvetica, sans-serif; padding-top:70px; padding-bottom:70px;">
    <table  cellspacing="0" cellpadding="0" align="center" width="768" class="outer-tbl" style="margin:0 auto;">
      <tr>
        <td class="pad-l-r-b" style="background-color:#FFFFFF; padding:0 70px 40px;">
          <table cellpadding="0" cellspacing="0" class="full-wid"> 
          </table> 
            <table cellpadding="0" cellspacing="0"  style="width:100%; background-color:#FFFFFF; border-radius:4px;box-shadow:0 0 20px #ccc;margin-top:40px">
              <tr>
                <td>
                  <table border="0" style="margin:0; width:100%" cellpadding="0" cellspacing="0">
                    <tr style="background:#FFFFFF;">
                      <td class="logo" style="padding:40px 0 30px 0; text-align:center">
                        <img src="<?php echo $app_logo; ?>" alt="" width="200px" height="60px" >
                        <h2 style="color:black;">Thank You for Email Verification</h2>
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
</html>