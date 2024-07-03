<!DOCTYPE html>
<html>
	<head>
		<title>refund_amount</title>
	</head>
		<body>
			<form method="post" action="refund_amount.php" enctype="multipart/form-data">
				<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
					<tr>
						<th>refund_amount</th>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="user_id" placeholder="Enter user_id">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="amount" placeholder="Enter amount">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="payment_id" placeholder="Enter payment_id">	
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