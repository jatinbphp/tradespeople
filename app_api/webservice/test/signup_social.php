<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../signup_social.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Signup Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="social_id" placeholder="Enter  emailid">	
				</td>
    		</tr>
    		<tr>
				<td>
				   <select name="login_type">
				      <option value="apple">choose</option>
				      <option value="facebook">Facebook</option>
				      <option value="google">Google</option>
			      </select>	
				</td>
    		</tr>
			<tr>
				<td>
				  <input type="text" name="player_id" placeholder="Enter  player id">	
				</td>
    		</tr>

			<tr>
				<td>
				   <select name="device_type">
				      <option value="browse">Browse</option>
				      <option value="android">Android</option>
				      <option value="ios">IOS</option>
			      </select>	
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