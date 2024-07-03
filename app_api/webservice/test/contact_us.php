<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../contact_us.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Contact us Form</th>
    		</tr>
			<tr>
				<td>
				  <input type="text" name="user_id_post" placeholder="Enter user id">	
				</td>
    		</tr>
    	    <tr>
				<td>
				  <input type="text" name="contact_us_name" placeholder="Enter name">	
				</td>
    		</tr>

			<tr>
				<td>
				  <input type="text" name="contact_email" placeholder="Enter email">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="contact_message" placeholder="Enter message">	
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