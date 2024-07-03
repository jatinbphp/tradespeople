<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../change_password.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Change password Form</th>
    		</tr>
    	    <tr>
				<td>	
				  <input type="text" name="user_id" placeholder="Enter user id">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="password" placeholder="Enter new password">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="password_old" placeholder="Enter old password">	
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