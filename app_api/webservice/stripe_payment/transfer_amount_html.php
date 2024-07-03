<!DOCTYPE html>
<html>
	<head>
		<title>transfer_amount</title>
	</head>
		<body>
			<form method="post" action="transfer_amount.php" enctype="multipart/form-data">
				<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
					<tr>
						<th>transfer_amount</th>
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
						  <input type="text" name="user_token_id" placeholder="Enter user_token_id">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="description" placeholder="Enter description" maxlength="20">	
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