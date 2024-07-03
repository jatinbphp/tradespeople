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
							<h2>Forgot Password</h2>	
								<form id="forget_pass" onsubmit="return forget_pass();">						
							<div class="login-box">
								<i class="fa fa-envelope"></i>
								<input class="form-control input-lg" type="email" placeholder="Email Address" name="email" id="text">
							</div>
											
							<div class="login-box">
								<button class="btn btn-primary  btn-block btn-lg login_btn" type="submit">Forgot Your Password</button>
										
								<a href="<?php echo base_url('signup-step1'); ?>" class="for-link">Sign up?</a>
							</div>
						</form>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="login-box">
							<h2>New to Tradespeople Hub?</h2>
							<div class="text-sign">
								<h3 style="margin-bottom: 12px;">I´m a homeowner</h3>
								<p>Create an account here to access and get quick responses from over 20,000 local, reputable tradespeople.</p>
								<a href="<?php echo base_url('signup'); ?>" class="text-href">Create an account</a>
								<h3 style="margin-bottom: 12px;">Sign up as a tradesperson</h3>
								<p>Over 100,000 homeowners post jobs on our platform. We only need tradespeople like you to do them.</p>
								<a href="<?php echo base_url('signup-step1'); ?>" class="text-href">Sign up now</a>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function forget_pass()
{
	$.ajax({	
		type:'POST',
		url:site_url+'home/forget_pass',
		data:$('#forget_pass').serialize(),
		dataType:'JSON',
		beforeSend:function()
		{
			$('.login_btn').prop('disabled',true);
			$('.login_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.msg').html('');
		},
		success:function(resp)
		{	
			$('.login_btn').prop('disabled',false);
			$('.login_btn').html('Forgot Your Password');
			if(resp.status==1)
			{
				$('#forget_pass')[0].reset();
				$('.msg').html('<div class="alert alert-success">Your password has been sent to your email address!</div>');
			}
			else if(resp.status==2)
			{
				$('.msg').html('<div class="alert alert-danger">This email is not registered with us!</div>');
			}
			else if(resp.status==3)
			{
				$('.msg').html('<div class="alert alert-danger">Your account has been blocked!</div>');
			}
			else
			{
				$('.msg').html(resp.msg);
			}

		}
	});
	return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>