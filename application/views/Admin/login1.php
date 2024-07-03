<?php include ("include/header.php") ?>
<!-- how-it-work -->
<div class="login-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="row">
					<div class="col-sm-6">
						<div class="login-box">
							<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
							<h2>Welcome back</h2>	
								<form id="login_form" onsubmit="return login_form();">						
							<div class="login-box">
								<i class="fa fa-envelope"></i>
								<input class="form-control input-lg" type="text" placeholder="Email" name="email" id="email">
							</div>
							<div class="login-box">
								<i class="fa fa-lock"></i>
								<input class="form-control input-lg" type="password" placeholder="Password" name="password" name="password">
							</div>							
							<div class="login-box">
								<button type="submit" class="btn btn-primary  btn-block btn-lg login_btn" >Login </button>					
								<a href="<?php echo base_url('forgot_password'); ?>" class="for-link">Need help logging in?</a>
							</div>
						</form>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="login-box">
							<h2>New to Traders People Hub?</h2>
							<div class="text-sign">
								<h3>Looking for a builder or tradesman?</h3>
								<p>Post your job here and get quick responses from local, reputable tradespeople.</p>
								<a href="" class="text-href">Post a job</a>
								<h3>Sign up as a trade</h3>
								<p>We help tradesmen get the right kind of work, in the most affordable way.</p>
								<a href="<?php echo base_url('signup_step1'); ?>" class="text-href">Signup</a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

function login_form(){
	$.ajax({
		type:'POST',
		url:site_url+'home/login_form',
		data:$('#login_form').serialize(),
		dataType:'JSON',
		beforeSend:function (){
			$('.login_btn').prop('disabled',true);
			$('.login_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			$('.msg').html('');
		},
		success:function(resp){
			if(resp.status==1){
				window.location.href=site_url+"dashboard";  
			} else if(resp.status==2){
				window.location.href=site_url+"email_verify"; 
			} else {
				$('.login_btn').prop('disabled',false);
				$('.login_btn').html('Login </i>');
				$('.msg').html(resp.msg);
				window.location.href="#msg"; 
			}
		}
	});
	return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>