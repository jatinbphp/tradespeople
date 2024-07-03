<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../social_login.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>social login</th>
    		</tr>
    		
			<tr>
				<td>
				  <input type="text" name="social_id" placeholder="Enter social_id">	
				</td>
    		</tr><tr>
				<td>
				  <input type="email" name="social_email" placeholder="Enter social email">	
				</td>
    		</tr>
    		
    		<tr>
				<td>
				   <select name="device_type">
				      <option value="browser">Browser</option>
				      <option value="android">Android</option>
				      <option value="ios">IOS</option>
			      </select>	
				</td>
    		</tr>
    		<tr>
				<td>
				   <select name="social_type">
				      <option value="0">App</option>
				      <option value="1">Facebook</option>
				      <option value="2">Google</option>
			      </select>	
				</td>
    		</tr>
    		
    		<tr>
				<td>
				  <input type="text" name="player_id" placeholder="123456">	
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