<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Payments using Stripe</title>	
</head>
<body>
<h1>Buy Facebook login Script</h1>
<p>Price: 15.00$</p>
<p>Name: How to Login with Facebook Graph API in PHP</p>

<form action="charge.php" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_tC2CJnEIgnCC7ZuyqjEbZptd" // your publishable keys
    data-image="logo.png" // your company Logo
    data-name="PHPGang.com"
    data-description="Download Script ($15.00)"
    data-amount="1500">
  </script>
</form>

</body>
</html>