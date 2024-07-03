<!DOCTYPE html>
<html>
<head>
	<title>Test Form</title>
</head>
<body>
	<form method="post" action="../offer_accept.php" enctype="multipart/form-data">
		<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
			<tr>
				<th>Offer Accept</th>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="user_id_post" placeholder="user id">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="text" name="booking_offer_id" placeholder="booking offer id">	
				</td>
    		</tr>
    		
    		<tr>
				<td>
				  <input type="text" name="txn_id" placeholder="Enter txn id">	
				</td>
    		</tr>
    		<tr>
				<td>
				  <input type="date" name="txn_date" placeholder="Enter txn date">	
				</td>
    		</tr>

    		<tr>
				<td>
				  <input type="text" name="booking_amt" placeholder="Enter booking amt">	
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