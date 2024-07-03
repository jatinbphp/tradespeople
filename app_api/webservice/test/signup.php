<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../signup.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Signup Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="name" placeholder="name">	
				</td>
    		</tr>
    			<tr>
				<td>
				  <input type="text" name="phone_code" placeholder="Phone code" value="1">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="mobile" placeholder="" value="8839875046">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="email" name="email" placeholder="email">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="password" name="password" placeholder="password" value="123456">	
				</td>
    		</tr>

			
    		<tr>
				<td>
				  <input type="text" name="country" value='1' placeholder="Germany" readonly="true">	
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
				   <select name="login_type">
				      <option value="0">app</option>
				      <option value="1">google</option>
				      <option value="2">facebook</option>
			      </select>	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="player_id" value="123456" readonly="true">	
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