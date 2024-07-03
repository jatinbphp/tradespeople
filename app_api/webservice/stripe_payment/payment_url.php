<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stipe Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui" />

    <link rel="stylesheet" href="global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1%26features=fetch"></script>
    <!--<script src="client.js" defer></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>

  <body>
      
      <div class="stripe_logo">
          <img src="../logo/logo.png" class="logo_img" />
        </div>
    <!-- Display a payment form -->
    <form id="payment-form">
		<input type="text" id="card_u_name" placeholder="Name on Card"  required="required" />	
      <div id="card-element"><!--Stripe.js injects the Card Element--></div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Add Card</span>
      </button>
      <p id="card-error" role="alert"></p>
      <p class="result-message hidden">
        Payment succeeded,Please wait we are processing.
      </p>
    </form>
    
     <ul class="payment-list payment_description"  id="payment_description">
        <!--<li> All of our subscriptions comes with a monthly allowance job credits which you can be used to to provide quotes, discuss project requirements, reply to messages. If you wish to save up to 50% on credits, we recommend subscribing to our monthly plans.</li>-->  
        <!--<li>Easy super fast payment process</li>
        <li>Stripes inbuilt machine learning fraud prevention</li>
		-->      
	</ul>
      
    
    <?php
    include 'payment_url_js.php';
    ?>
	 
  </body>
</html>
