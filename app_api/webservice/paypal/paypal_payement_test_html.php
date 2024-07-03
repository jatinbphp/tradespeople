<html>
<head>
<title></title>
</head>
<body>
<form method="get" action="paypal_payment_url.php" enctype="multipart/form-data">

<table border="1" cellspacing="7" cellpadding="5" align="center">
<tr>
<td align="center" >Create Payment URL</td></tr>

<td><input type="text" name="user_id" placeholder="Enter user_id" ></td></tr>
<td><input type="text" name="event_id" placeholder="Enter event_id" ></td></tr>
<td><input type="text" name="amount" placeholder="Enter amount" ></td></tr>
<td><input type="text" name="currency" placeholder="Enter currency" ></td></tr>

<td align="center" ><input type="Submit" value=" Submit " name="sub">
<input type="Reset" value=" Cancel "></td></tr>
</table>
</form>


<form method="post" action="paypal_payment_url_approval.php" enctype="multipart/form-data">

<table border="1" cellspacing="7" cellpadding="5" align="center">
<tr>
<td align="center" >Execute Payment URL</td></tr>

<td><input type="text" name="user_id" placeholder="Enter user_id" ></td></tr>

<td><input type="text" name="event_id" placeholder="Enter event_id" ></td></tr>

<td><input type="text" name="amount" placeholder="Enter amount" ></td></tr>

<td><input type="text" name="payment_id" placeholder="Enter payment_id" ></td></tr>

<td><input type="text" name="payer_id" placeholder="Enter payer_id" ></td></tr>

<td><input type="text" name="token_return" placeholder="Enter token_return" ></td></tr>

<td><input type="text" name="execute_url" placeholder="Enter execute_url" ></td></tr>

<td align="center" ><input type="Submit" value=" Submit " name="sub">
<input type="Reset" value=" Cancel "></td></tr>
</table>
</form>

</body>


</html>