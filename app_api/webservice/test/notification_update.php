<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="get" action="../notification_update.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Notification update Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="user_id" placeholder="enter user id">	
				</td>
    		</tr>
    		
    		<!-- <tr>
				<td>
				  <input type="radio" name="notification_status" value="1">	ON
				  <input type="radio" name="notification_status" value="0">OFF	
				</td>
    		</tr> -->
    		
    		<tr>
				<td>
					<input type="submit" name="Submit" value="Submit">
				</td>
    		</tr>
    	</table>
    </form>
</body>
</html>