<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= Project ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/dist/css/skins/_all-skins.min.css">

	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/bootstrap-daterangepicker/daterangepicker.css">
	
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="<?= site_url(); ?>assets/site/custom/style.css">
	<script> var site_url = '<?= site_url(); ?>';</script>
	<script src="<?= site_url(); ?>assets/site/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="<?= site_url(); ?>assets/site/bower_components/jquery-ui/jquery-ui.min.js"></script>

	<script src="<?= site_url(); ?>assets/site/dist/js/adminlte.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
	<script src="<?= site_url(); ?>assets/site/custom/custom.js"></script>
	
</head>
<body>

	<div class="top_bar">
		<div class="container">
			<div class="left-logo pull-left">
					<a href="<?= site_url(); ?>"><img class="img_r" src="<?= base_url(); ?>assets/site/img/logo5.png">
						
					</a>
				</div> 
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

		</div>
	</div>
      <!-- Menu-->
	<!-- top header -->

<!-- top header -->
<div class="loading-overlay"></div>


<div class="email_verification">
         <div class="container">
            <div class="col-sm-6 col-sm-offset-3 bgemail">
               <div class="row">
                  <div class="emailhead">
          
                     
                             </div>
                  <div style="margin:20px;">
                    
                     <div class="margintop15">
                      <div class="message_img">
                        <img src="<?= base_url(); ?>assets/site/img/message_1.png">
                      </div>
                        <h1><b>Verify Email</b></h1>
                        <p>You need to verify your email address. We've sent an email to
                         <b><u><?php echo $userdata['u_email']; ?></u></b> 
                     to verify your address. Please check the link in that email to continue.</p>
            <p>Click <a href="javascript:void(0);" onclick="resend_verification_link();">here</a> to resend verification link.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


<?php //include 'include/footer.php';  ?>
<script>
function resend_verification_link() {
	$.ajax({
		type: 'POST',
		dataType: 'JSON',
		url:site_url+'login/resend_verification_link',
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
				$('.msg').html('<div class="alert alert-danger">somthing went wrong, Please try again</div>');
			}
		}

	})
}
</script>

<style>
.left-logo {
  height: 80px;
  padding: 5px 0;
}
.top_bar {
  background: #f8f8f8 none repeat scroll 0 0;
  border-bottom: 1px solid #e1e1e1;
}
.profile_user .navbar-nav > li > a {
  padding: 30px 15px;
}


  body
  {
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
   .emailhead h2 { background: #f98793; color: #fff; margin-top: 20px; }
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
   .ar_minu .navbar-header {
   float: left;
   width: 40%;
   }
   .ar_minu .navbar-collapse {
   float: right;
   width: 60%;
   }
   .ar_minu .nav > li {
   display: inline-block;
   position: relative;
   }
   .navbar-brand{ top: 5px; }
   .ar_minu .navbar-nav > li > a{ padding-right: 5px; padding-left: 5px; }
   .navbar-collapse a{ background: transparent !important; color: #fff !important; }
   .navbar-nav > li, .navbar-nav > li:hover{ background: transparent !important; }
.bgemail {
    background: #fff none repeat scroll 0 0;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    box-sizing: border-box;
    margin-top: 50px;
    padding: 15px;
    text-align: center;
}
.bgemail p{ font-size: 16px; }
.message_img img {
  width: 180px;
}

.bgemail h1{color: #F98793;}
body{ background: #f1f1f1; }
</style>