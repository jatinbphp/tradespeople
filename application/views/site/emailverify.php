<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Tradespeople Hub</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content=""> 
  <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet">
  <link rel="shortcut icon" href="img/favi.png">
  <script type="text/javascript" >
    var site_url='<?php echo base_url(); ?>';

</script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/scripts.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
</head>
<body>

	<div class="top_bar email-verify">
	
		<div class="container">
			
			<div class="left-logo pull-left">
				
				<a href="<?= site_url(); ?>"><img class="img_r" src="<?php echo base_url(); ?>img/logo.png">
				
				</a>
			</div> 
			<?php 
			if($this->session->userdata('type')==1 || $this->session->userdata('type')==2){?>
			<div class="profile_user pull-right">
				<ul class="ul_set nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->session->userdata('u_name'); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= site_url().'home/logout'?>">
								<i title="Logout" data-placement="left" class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
						 
						</ul>
					</li>					
				</ul>
			</div>
			<?php
			}
			?>
			

		</div>
	</div>
	<!-- Menu-->
	<!-- top header -->

	<!-- top header -->
	<div class="loading-overlay"></div>
	
<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 bgemail" id="top">
				<div class="white-start">
					<div class="sing-top">
						<h1>
							<?php 
							$redirect = ($this->session->userdata('signup') && $setting == 1) ? 'signup-step8' : 'dashboard';
							if($this->session->userdata('signup') && $this->session->userdata('type')==1){ ?>
							<a href="<?php echo base_url("signup-step7"); ?>"><i class="fa fa-caret-left"></i> Back</a> 
							<?php } ?>
							Email verification 
							<?php 
								if($this->session->userdata('type')==1 || $this->session->userdata('type')==2){?>
									<a style="float:right;" href="<?= site_url().$redirect;?>">Next <i class="fa fa-caret-right"></i></a>
							<?php
								}
							?>
						</h1>
					</div>
					
					<div class="sing-body email_verification">
						
				<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
				<div class="row"></div>
				<div style="">
					<div class="">
						<!--div class="message_img">
							<img src="<?= base_url(); ?>img/message_1.png">
						</div-->
						<?php 
						$email = $this->session->userdata('email');
						
						$arr = explode('@',$email);
						
						$domain = end($arr);
						
						?>
						<p>You need to verify your email address. We've sent an email to <b><u><?php echo $email; ?></u></b> to verify your address. Please click the link in that email to continue.</p>
						<p>Click <a href="javascript:void(0);" onclick="resend_verification_link();">here</a> to resend verification link.</p>
					</div>
				</div>
				<?php
				
				
				$do_this_later = ($this->session->userdata('type')==2) ? true : false;
				?>
				<div class="row">
					<div class="<?php echo ($do_this_later) ? 'col-sm-6' : 'col-sm-12'; ?>">
						<div class="start-btn maggg1">
							<a style="color:#fff;" target="_blank" class="btn btn-warning btn-lg signup_btn" href="https://<?=$domain;?>">Check Email</a>
						</div>
					</div>
					<div class="<?php echo ($do_this_later) ? 'col-sm-6' : 'hide'; ?>">
						<div class="start-btn maggg1">
							<a style="color:#fff;" class="btn btn-warning btn-lg signup_btn" href="<?= site_url().$redirect;?>">Do This Later</a>
						</div>
					</div>
					
				</div>
			
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
<?php include 'include/footer.php';  ?>
<script>
function resend_verification_link() {
	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url:site_url+'home/resend_verification_link',
		beforeSend: function () {
			$('.loading-overlay').show();
			$('.msg').html('');
		},
		success: function (resp) {
			$('.loading-overlay').hide();
			if (resp.status == 1) {
				$('.msg').html('<div class="alert alert-success">Verification link has been sent successfully, please check your email</div>');
			} else if (resp.status == 3) {
				$('.msg').html('<div class="alert alert-danger">Your account is already verified, please contact to administration</div>');
			} else if (resp.status == 2) {
				$('.msg').html('<div class="alert alert-danger">Your account is blocked, please contact to administration</div>');
			} else {
				$('.msg').html('<div class="alert alert-danger">Something went wrong, Please try again</div>');
			}
		}

	})
}
function check_email_verified(){
	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url:site_url+'home/check_email_verified',
		success:function(resp){
			if (resp.status == 1){
				location.reload();
			}
		}
	});
}
setInterval(function(){
	//check_email_verified();
},3000);
</script>

<style>
.left-logo {
  padding: 5px 0;
}
.top_bar {
	background: #3d78cb;
  border-bottom: 1px solid #e1e1e1;
}
.profile_user .navbar-nav > li > a {
  padding: 20px 15px;
	color: #fff;
  background:none;
}
.profile_user .navbar-nav > li > a.dropdown-toggle:hover, .profile_user .navbar-nav > li > a.dropdown-toggle:focus, .profile_user .navbar-nav > li.open > a.dropdown-toggle:hover, .profile_user .navbar-nav > li.open > a:focus, .profile_user .navbar-nav > li:hover a.dropdown-toggle, .profile_user .navbar-nav > li:focus a.dropdown-toggle, .profile_user .navbar-nav li.open:hover a.dropdown-toggle, .profile_user .navbar-nav > li.open:focus a.dropdown-toggle{
  background:#376cb6
}
body  {
	position:relative;
}
.loading-overlay{
	position:fixed;
	top:0;
	left:0;
	width:100%;
	height:100%;
	display:none;
	background-color:rgba(00,00,00,0.6);
	z-index:9999;
}

  
.email_verification .col-sm-2 i {
	border: 1px solid #696969;
	border-radius: 50%;
	color: #696969;
	font-size: 50px;
	height: 110px;
	line-height: 102px;
	transition: all 0.5s ease 0s;
	width: 110px;
	margin-bottom: 15px;
}
 

.nav .caret {
    border-top-color: #fff !important;
    border-bottom-color: #fff !important;
}

.bgemail {
	box-sizing: border-box;
	margin-top: 50px;
	padding: 0px;
	text-align: center;
}
.bgemail p{ font-size: 16px; }

.back-button a {
	color: #fff;
	margin-right: 5px;
	font-size: 42px;
}
.back-button {
	position: absolute;
	margin: 0 auto;
	margin-left: 44px;
}
.left-logo.pull-left {
	padding-left: 60px;
}

.bgemail h1{color: #fe8a0f;}
body{ background: #f1f1f1; }
</style>
</html>