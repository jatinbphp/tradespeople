<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../edit_profile.php" enctype="multipart/form-data">
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
    		<tr>
				<td>
				  <input type="text" name="username" placeholder="user name">	
				</td>
    		</tr>
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
				  <input type="text" name="country" value='1' placeholder="Germany" readonly="true">	
				</td>
    		</tr>
    		<tr>
				<td>
				   <select name="state">
				      <option value="0">Select state</option>
				      <option value="1">Berlin</option>
				      <option value="2">Bremen</option>
			      </select>	
				</td>
    		</tr>
    		<tr>
				<td>
				   <select name="city">
				      <option value="0">Select city</option>
				      <option value="1">Berlin1</option>
				      <option value="2">Berlin2</option>
			      </select>	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="date" name="dob" placeholder="Enter  dob">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="music" placeholder="Enter music">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="favourite_club" placeholder="Enter favourite_club">	
				</td>
    		</tr>	
    		<tr>
				<td>
				  <input type="text" name="about" placeholder="Enter about">	
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