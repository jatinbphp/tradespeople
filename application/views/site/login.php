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
								<input class="form-control input-lg" type="password" placeholder="Password" name="password">
								<input type="hidden" name="redirectUrl" value="<?php echo (isset($_GET['redirectUrl']) && !empty($_GET['redirectUrl'])) ? $_GET['redirectUrl'] : '';?>">
							</div>							
							<div class="login-box">
								<button type="submit" class="btn btn-primary  btn-block btn-lg login_btn" >Login </button>					
								<a href="<?php echo base_url('forgot-password'); ?>" class="for-link">Need help logging in?</a>
							</div>

							<div class="row mt20">
								<!-- <div class="col-md-6"><img src="img/ios-btn.png" class="ios" alt="ios"></div>
								<div class="col-md-6"><img src="img/android-btn2.png" class="android" alt="android"></div> -->
								<div class="col-md-12">
									<ul class="nav login d-sm-none">
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<img src="<?php echo base_url('img/ios-appStore-black.png'); ?>">
											</a>
											<ul class="dropdown-menu">
							                  <li>
							                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-homeowners/id6450202456">Homeowner's app</a>
							                  </li>
							                  <li>
							                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-provider/id6450201899">Tradespeople's app</a>
							                  </li>
							                </ul>
										</li>
										<li class="dropdown">
							                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							                  <img src="<?php echo base_url('img/google-appStore-black.png'); ?>">
							                </a>
							                <ul class="dropdown-menu">
							                  <li>
							                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradespeoplehub">Homeowner's app</a>
							                  </li>
							                  <li>
							                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradesprovider">Tradespeople's app</a>
							                  </li>
							                </ul>
							             </li>
									</ul>
								</div>
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

								<!-- <h3 style="margin-bottom: 12px;">Sign up as a marketer</h3> -->
								<!-- <p>Over 100,000 homeowners post jobs on our platform. We only need tradespeople like you to do them.</p> -->
								<!-- <a href="<?php echo base_url('marketers'); ?>" class="text-href">Sign up now</a> -->
							</div>
							<ul class="nav login d-lg-none">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img src="<?php echo base_url('img/ios-appStore-black.png'); ?>">
									</a>
									<ul class="dropdown-menu">
					                  <li>
					                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-homeowners/id6450202456">Homeowner's app</a>
					                  </li>
					                  <li>
					                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-provider/id6450201899">Tradespeople's app</a>
					                  </li>
					                </ul>
								</li>
								<li class="dropdown">
					                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
					                  <img src="<?php echo base_url('img/google-appStore-black.png'); ?>">
					                </a>
					                <ul class="dropdown-menu">
					                  <li>
					                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradespeoplehub">Homeowner's app</a>
					                  </li>
					                  <li>
					                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradesprovider">Tradespeople's app</a>
					                  </li>
					                </ul>
					             </li>
							</ul>
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
				if(resp.redirectUrl){
					window.location.href=resp.redirectUrl;  
				} else {
					window.location.href=site_url+"dashboard";  
				} 
			} else if(resp.status==2){
				window.location.href=site_url+"email-verify"; 
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