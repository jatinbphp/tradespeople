<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../edit_profile_user.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Edit Profile Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="user_id_post" placeholder="user id">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="file" name="profile_pic">	
				</td>
    		</tr>
    		<!-- <tr>
				<td>
				  <input type="text" name="username" placeholder="user name">	
				</td>
    		</tr> -->
    		<tr>
				<td>
				  <input type="text" name="f_name" placeholder="f_name">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="l_name" placeholder="l_name">	
				</td>
    		</tr>
    	


	

    		<tr>
				<td>
				  <input type="text" name="postal_code"  placeholder="postal_code" >	
				</td>
    		</tr>
    		
    		
    		<tr>
				<td>
				  <input type="text" name="phone_no" placeholder="Mobile">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="postal_code" placeholder="Enter Postal code">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="latitude" placeholder="Enter latitude">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="longitude" placeholder="Enter longitude">	
				</td>
    		</tr>	
    		<tr>
				<td>
				  <input type="text" name="address" placeholder="Enter address">	
				</td>
    		</tr>	
    		<tr>
				<td>
				  <input type="text" name="city" placeholder="Enter city">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="county" placeholder="Enter county">	
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