<!DOCTYPE html>
<html>
	<head>
		<title>Stripe Bank Account Add/Edit</title>
	</head>
		<body>
			<form method="post" action="add_edit_bank_account.php" enctype="multipart/form-data">
				<table align="center" cellpadding="6" cellspacing="4" border="1"  width="">
					<tr>
						<th>Stripe Bank Account Add/Edit</th>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="user_id" placeholder="Enter user_id">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="firstname" placeholder="Enter firstname">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="text" name="lastname" placeholder="Enter lastname">	
						</td>
					</tr>
					<tr>
						<td>
						  <input type="date" name="dateofbirth" placeholder="Enter dateofbirth" value="2002-02-05">	
						</td>
					</tr>
				
				<tr>
						<td>
						  <input type="text" name="user_account" placeholder="Enter user_account" value="000444444440">	
						</td>
					</tr>
					
						<tr>
						<td>
						  <input type="text" name="user_routing" placeholder="Enter user_routing" maxlenght="22" value="110000000">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="ssn_number" placeholder="Enter ssn_number" maxlenght="22" value="123456789">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="bank_name" placeholder="Enter bank_name" maxlenght="22" value="City Bank">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="address_line_1" placeholder="Enter address_line_1" maxlenght="22" value="5613 Meritage street">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="address_line_2" placeholder="Enter address_line_2" maxlenght="22" value="No suite number or apt number">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="user_state" placeholder="Enter user_state" maxlenght="22" value="Tx">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="city" placeholder="Enter city" maxlenght="22" value="McKinney">	
						</td>
					</tr>
					
					<tr>
						<td>
						  <input type="text" name="zip_code" placeholder="Enter zip_code" maxlenght="22" value="75061">	
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