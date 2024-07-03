<!DOCTYPE html>
<html>
	<head>
		<title>Stripe Payment Using Card Tocken</title>
	</head>
		<body>
			<form method="post" action="payment_using_card_id.php" enctype="multipart/form-data">
				<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
					<tr>
						<th>Stripe Payment Using Card Tocken</th>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="user_id" placeholder="Enter user_id">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="customer_id" placeholder="Enter customer_id">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="card_token_id" placeholder="Enter card_token_id">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="amount" placeholder="Enter amount">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="transfer_user_id" placeholder="Enter transfer_user_id">	
						</td>
					</tr>
				
				<tr>
						<td>
						  <input type="text" name="transfer_amount" placeholder="Enter transfer_amount">	
						</td>
					</tr>
					
						<tr>
						<td>
						  <input type="text" name="descriptor_suffix" placeholder="Enter descriptor_suffix" maxlenght="22">	
						</td>
					</tr>
					
				    <tr>
						<td>
							<input type="submit" name="Submit" value="Submit" >
						</td>
					</tr>
				</table>
			</form>
		</body>
</html>