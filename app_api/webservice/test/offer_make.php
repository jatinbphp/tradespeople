<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../offer_make.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Offer Make</th>
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
				  <input type="text" name="booking_offer_id" placeholder="booking offer id">	
				</td>
    		</tr>
    		
    		<tr>
				<td>
				   <select name="offer_type">
				      <option value="0">Money type</option>
				      <option value="1">Entrance</option>
				      <option value="2">Money</option>
				      <option value="3">Entrance + Money</option>
				      <option value="4">Nothing</option>
			      </select>	
				</td>
    		</tr>
    	
    		<tr>
				<td>
				  <input type="text" name="offer_amount" placeholder="Enter offer amount">	
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