<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../booking_create.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Booking Create Form</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="user_id_post" placeholder="user id">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="other_user_id" placeholder="other user id">	
				</td>
    		</tr>
    		 <tr>
				<td>
				  <input type="text" name="address" placeholder="Enter address">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="country" value='82' placeholder="Germany" readonly="true">	
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
				  <input type="date" name="date" placeholder="Enter  date">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="time" name="time" placeholder="Enter  time">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="club" placeholder="Enter club">	
				</td>
    		</tr>	
    		<tr>
				<td>
				  <input type="text" name="music" placeholder="Enter music">	
				</td>
    		</tr>
    	

 
    		
    		<tr>
				<td>
				  <input type="text" name="message" placeholder="Enter message">	
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