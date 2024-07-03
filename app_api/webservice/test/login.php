<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../login_user.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Login Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="email" placeholder="Enter  email">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="password" placeholder="Enter  password">	
				</td>
    		</tr>
    		<tr>
				<td>
				   <select name="login_type">
				      <option value="normal_login">normal login</option>
			      </select>	
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
				  <input type="text" name="player_id" placeholder="123456" value="123456">	
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