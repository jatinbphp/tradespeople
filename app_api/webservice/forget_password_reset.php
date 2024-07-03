<?php
session_start();
include("con1.php");
include("function_app.php");

if(isset($_GET['uniqcode']))
{
    $uniqcode = $_GET['uniqcode'];
    $check_email_all=$mysqli->prepare("SELECT `forgot_id` FROM `forgot_password_master` WHERE `active_flag`='1' AND `forgot_pass_identity`='$uniqcode'");
    //$check_email_all->bind_param("i",$uniqcode);
    $check_email_all->execute();
    $check_email_all->store_result();
    $check_email=$check_email_all->num_rows;
    if($check_email > 0)
    {
        ?>
        
        <script type="text/javascript">
            alert('This link is deactivated');
            setTimeout(function(){
                window.top.close();
            },1000);
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reset Password</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<style type="text/css">
		body{
			background: url(img/Fruits-HD-Wallpaper.jpg);
			background-repeat: no-repeat;
			background-size: cover; 
		}
		html body .was-validated .himansnu {
		    border-color: #dc3545 !important;
		    padding-right: calc(1.5em + .75rem) !important;
		    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
		    background-repeat: no-repeat !important;
		    background-position: right calc(.375em + .1875rem) center !important;
		    background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
		}
		html body .was-validated .himansnu:focus {
		    border-color: #dc3545 !important;
		    box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25) !important;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-4">
				
			</div>
			<div class="col-lg-4 mt-5">
				<div class="card">
					<div class="card-header">
						<img src="logo/logo.png" class="img-fluid mx-auto d-block" height="80px;" width="50%">
						<h4 class="text-center"><?php echo $app_name; ?></h4>
					</div>
					<div class="card-body">	
						<form method="post" class="needs-validation" novalidate action="reset_password_new.php">
							<?php
							if ($_SESSION['sucess'] == 'false') {
							?>
							<h5 style="color: red" class="message"><?=$_SESSION['message']?></h5>
							<?php
							}else{
							?>
							<h5 style="color: green" class="message"><?=$_SESSION['message']?></h5>
							<?php
							}
							?>
						<div class="form-row">
						<div class="col-md-12 mb-3">
							<input type="hidden" name="uniqcode" value="<?=$_GET['uniqcode']?>">
						  <label for="validationCustom01">New Password</label>
						  <input type="password" class="form-control" id="validationCustom01" placeholder="New Password" name="password" value="" required maxlength="20" minlength="6" oninput="password_new_match()">
						  <div id="validate_new" class="valid-feedback">
					          Password must be of minimum 6 characters
					       </div>
						</div>
						</div>
						<div class="form-row">
						<div class="col-md-12 mb-3">
						  <label for="validationCustom02">Confirm Password</label>
						  <input type="password" class="form-control" id="validationCustom02" placeholder="Confirm Password" name="cpassword" value="" required maxlength="20" minlength="6" oninput="password_match()">
						  <!-- <div class="valid-feedback">
						    Looks good!
						  </div> -->
						  <div id="validate" class="valid-feedback">
					          Password matched
					       </div>
						</div>
						</div>
						<button class="btn btn-primary btn-sm mx-auto d-block" type="submit">Reset Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
(function() {
	'use strict';
	window.addEventListener('load', function() {
	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.getElementsByClassName('needs-validation');
	// Loop over them and prevent submission
	var validation = Array.prototype.filter.call(forms, function(form) {
	form.addEventListener('submit', function(event) {
	if (form.checkValidity() === false) {
		console.log("himanshu");
		event.preventDefault();
		event.stopPropagation();
	}
	// console.log("himanshu3");
	form.classList.add('was-validated');
	}, false);
	});
	}, false);
})();
</script>

<script type="text/javascript">
	function password_new_match()
	{
		$('#validationCustom01').addClass('himansnu');
		var password = $("#validationCustom01").val();
    	if(password.length<=5){
			console.log('New pass <= 5');
    		$('#validate_new').removeClass("valid-feedback");
    		// $('#validationCustom02').removeClass("form-control");
    		$('#validate_new').html("Password must be of minimum 6 characters");
    		$('#validate_new').css("color","red");
    		$('button').css("pointer-events","none");
    		console.log(confirmpassword+'--'+password);
			return false;
    	}
		else{
    		$('#validationCustom01').removeClass('himansnu');			
			$('#validate_new').addClass("valid-feedback");
			$('#validate_new').html("");
    		$('#validate_new').css("color","green");
			
    		$('button').css("pointer-events","auto");
    	}
	}
	
	function password_match()
	{
		$('#validationCustom02').addClass('himansnu');
		$('#validationCustom01').addClass('himansnu');

		var password = $("#validationCustom01").val();
    	var confirmpassword = $("#validationCustom02").val();
    	if(password.length<=5){
			console.log('New pass <= 5');
    		$('#validate_new').removeClass("valid-feedback");
    		// $('#validationCustom02').removeClass("form-control");
    		$('#validate_new').html("Password must be of minimum 6 characters");
    		$('#validate_new').css("color","red");
    		$('button').css("pointer-events","none");
    		console.log(confirmpassword+'--'+password);
			return false;
    	}
		else if(confirmpassword.length<=5){
			console.log('pass <= 5');
			
			$('#validate_new').addClass("valid-feedback");
    		$('#validate_new').css("color","green");
			
    		$('#validate').removeClass("valid-feedback");
    		// $('#validationCustom02').removeClass("form-control");
    		$('#validate').html("Password must be of minimum 6 characters");
    		$('#validate').css("color","red");
    		$('button').css("pointer-events","none");
    		console.log(confirmpassword+'--'+password);
			return false;
    	}
		else if(password != confirmpassword){
    		$('#validate').removeClass("valid-feedback");
    		// $('#validationCustom02').removeClass("form-control");
    		$('#validate').html("Password Not Match");
    		$('#validate').css("color","red");
    		$('button').css("pointer-events","none");
    		console.log(confirmpassword+'--'+password);
			return false;

    	}
		else{
    		$('#validationCustom01').removeClass('himansnu');
    		$('#validationCustom02').removeClass('himansnu');
    		$('#validate').addClass("valid-feedback");
    		$('#validate').html("Password Match");
    		$('#validate').css("color","green");
			
			$('#validate_new').addClass("valid-feedback");
			$('#validate_new').html("");
    		$('#validate_new').css("color","green");
			
    		$('button').css("pointer-events","auto");
    	}
	}
</script>

<script type="text/javascript">
	$(document).ready(function()
	{
		setTimeout(function(){
			$('.message').css("display","none");
		},2000);
	});
</script>

<script type="text/javascript">
	$(document).ready(function()
	{
	    var message = '<?=$_SESSION["message"]?>';
	    if(message == 'This link is not valid...')
	    {
	         <?php
	        //session_unset(); 
            //session_destroy();
	        ?>
            setTimeout(function(){
                window.top.close();
            },3000); 
	    }
		else if(message == 'Password Updated Successfully')
	    {
	         <?php
	        //session_unset(); 
           // session_destroy();
	        ?>
	        setTimeout(function(){
                window.top.close();
            },3000);
	    }
	});
</script>

</body>
</html>

<?php
if(isset($_GET['session_remove'])){
    session_destroy();
}
?>