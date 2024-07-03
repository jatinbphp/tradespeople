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
							$redirect = ($this->session->userdata('signup')) ? 'signup-step8' : 'dashboard';
							if($this->session->userdata('signup') && $this->session->userdata('type')==1){ ?>
							<a href="<?php echo base_url("signup-step7"); ?>"><i class="fa fa-caret-left"></i> Back</a> 
							<?php } ?>
							Email verification 
							<?php $email_satus = $this->common_model->get_single_data('users',['id'=>$this->session->userdata('user_id')]);
								if(($this->session->userdata('type')==1 || $this->session->userdata('type')==2) && $email_satus['u_email_verify'] == 1){?>
									<a style="float:right;" href="<?= site_url().$redirect;?>">Next <i class="fa fa-caret-right"></i></a>
							<?php
								}
							?>
						</h1>
					</div>
					<?php
						if(isset($errMsg) && !empty($errMsg)){
							echo '<p id="emailErrMsg" class="alert alert-danger">'.$errMsg.'</p>';
						}
					?>
					<p id="emailSecurityCode" class="alert alert-danger">Wrong Security Code</p>
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
						
						<form method="post" id="signup" enctype="multipart/form-data" onsubmit="return verifyEmail();">
					 		<p>You need to verify your email address. We've sent an email to <b><u><?php echo $email; ?></u></b> to verify your address. Please enter below, the code you received in the email to continue.</p>
							<p>Click <a href="javascript:void(0);" onclick="resend_verification_link();">here</a> to resend verification code.</p>
							<p>If the email is not right click <a href="javascript:;" data-toggle="modal" data-target="#change_email">here</a> to change</p>
						  <div class="input_very">
								<span><input class="form-control quantity" type="text" name="first" maxlength="1"></span>
								<span><input class="form-control quantity" type="text" name="second" maxlength="1"></span>
								<span><input class="form-control quantity" type="text" name="third" maxlength="1"></span>
								<span><input class="form-control quantity" type="text" name="fourth" maxlength="1"></span>
						  </div>
						  <!--
						  <input type="number" class="form-control" name="verification_code" />
						  -->
						  <div class="start-btn maggg1">
								<button type="submit" class="btn btn-warning btn-lg signup_btn">Verify</button>
						  </div>
						</form>
					</div>
				</div>

				<?php
				
				$email_satus = $this->common_model->get_single_data('users',['id'=>$this->session->userdata('user_id')]);
				$do_this_later = ($this->session->userdata('type')==2 && $email_satus['u_email_verify'] == 1) ? true : false;
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
<div class="modal fade" id="change_email" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter New Email</h4>
        </div>
        <form method="post" onsubmit="return changeEmail(event)" enctype="multipart/form-data" id="changeEmail">
	        <div class="modal-body">
				<div class="changeEmailError"></div>
	          	<input type="email" class="form-control" name="email">
	          	<input type="hidden" class="form-control" name="id" value="<?=$this->session->userdata('user_id')?>">
	        </div>
	        <div class="modal-footer">
	          <button type="submit" class="btn btn-success">Submit</button>
	          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </form>
      </div>
    </div>
  </div>

</body>
<?php include 'include/footer.php';  ?>
<script>
  $("#emailSecurityCode").hide();
  function verifyEmail(){
    $("#emailSecurityCode").hide();
    var first = $("#signup input[name=first]").val();
    var second = $("#signup input[name=second]").val();
    var third = $("#signup input[name=third]").val();
    var fourth = $("#signup input[name=fourth]").val();
    if(!first || !second || !third || !fourth){
      alert('Please enter 4 digit code.');
      return false;
    }
    var verification_code = first + second + third + fourth;
    $.ajax({
      type:'POST',
      url:site_url+'home/submit_email_verify/',
      // data:$('#signup').serialize(),
      data: {
        'verification_code' : verification_code
      },
      dataType:'JSON',
      beforeSend:function(){
        $(".signup_btn[type='submit']").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $(".signup_btn[type='submit']").prop('disabled', true);
        $('.msg').html('');
      },
      success:function(resp){
        if(resp.status == 1){
          window.location.href = site_url+''+resp.url;
          //window.location.href = site_url + 'email-verify';
        } else {
          $("#emailSecurityCode").text(resp.message).show();
          $(".signup_btn[type='submit']").html('Verify');
          $(".signup_btn[type='submit']").prop('disabled', false);
        }
      }
    });
    return false;
  }

  $('input.quantity').on('keyup', function(e) {
    // console.log(e.which);
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      /* 96 - 105 */
      return false;
    }
    if ($(this).val()) {
      $(this).parent().next().find('.quantity').focus();
    }
  });

  $('input.quantity').on('focus', function() {
    if ($(this).val()) {
      $(this).val('');
    }
  });

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
				$('.msg').html('<div class="alert alert-success">Verification code has been sent successfully, please check your email</div>');
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

function changeEmail(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		contentType : false,
		chache : false,
		processData : false,
		data : new FormData($('#changeEmail')[0]),
		url:site_url+'home/change_verification_email',
		beforeSend: function () {
			$('.loading-overlay').show();
			$('.changeEmailError').html('');
		},
		success: function (resp) {
			$('.loading-overlay').hide();
			
			if (resp.status == 1) {
				location.reload();
			} else if (resp.status == 3) {
				$('.changeEmailError').html('<div class="alert alert-danger">Your account is already verified, please contact to administration</div>');
			} else if (resp.status == 2) {
				$('.changeEmailError').html('<div class="alert alert-danger">Your account is blocked, please contact to administration</div>');
			} else if (resp.status == 4) {
				$('.changeEmailError').html('<div class="alert alert-danger">This email is already linked with another account, please contact to administration</div>');
			} else {
				$('.changeEmailError').html('<div class="alert alert-danger">Something went wrong, Please try again</div>');
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