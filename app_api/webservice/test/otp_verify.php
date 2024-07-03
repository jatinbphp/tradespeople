<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../otp_verify_user.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>OTP Verify</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="user_id" placeholder="Enter  userid">	
				</td>
    		</tr>
            <tr>
				<td>
				  <input type="text" name="otp" placeholder="Enter  otp">	
				</td>
    		</tr>  
    		
    		
    		<tr>
				<td>
					<input type="submit" name="Submit" value="Submit">
				</td>
    		</tr>
    	</table>
    </form>
</body>
</html>