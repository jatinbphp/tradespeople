<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="asset/admin/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="asset/admin/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="asset/admin/plugins/iCheck/square/blue.css">
  <style type="text/css">
			.error{color:red;}

		</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <span class="logo-lg"><img src="<?php echo base_url(); ?>img/logo.png" height="40"></span>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <div id="error"></div>
    <form method="post" id="login-form" action="Admin">
	 <?php if($this->session->flashdata('error'))
       {
        ?>
        <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
        <?php
       }
      ?>						
      <div class="form-group has-feedback">

        <input type="text" class="form-control" name="email" id = "email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">   
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <a href="#" data-toggle="modal" data-target="#modal-default" style="display: none;">I forgot my password</a><br>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="login" value="login" class="btn btn-info btn-block btn-flat" name="btn-login" id="btn-login">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->
  </div>
</div>

<!-- /Forget password Model -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Forget Password</h4>
      </div>
	  
      <form class="form-horizontal" id="form_reset_pwd" onsubmit="return forgotpass()">
	  
      <div class="modal-body">
              <p>Enter your e-mail address below to reset your password.</p>
            <input type="email" id="email" name="email" placeholder="Email" autocomplete="off" class="form-control" required>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		 <input type="submit" class="btn btn-primary" value="Send"/>
      </div>
    </form>

    </div>
  </div>
</div>
        

<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="asset/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="asset/admin/plugins/iCheck/icheck.min.js"></script>
<script src="asset/admin/custom/js/validation.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> -->
<script src="custom/custom.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script type="text/javascript">
  $('document').ready(function()
{ 
    
   $("#login-form").validate({
      rules:
    {
      password: {
      required: true,
      },
      username: {
            required: true,
            
            },
     },
       messages:
     {
            password:{
                      required: "please enter your password"
                     },
            username: "please enter your Email ",
       },
     submitHandler: submitForm  
       });
   });
</script>

	<script>
	function forgotpass()
  {
	  //alert('ok');
     $.ajax({
      type : 'POST',
      url  : 'process/process.php?action=forgotpass',
      data : $("#form_reset_pwd").serialize(),
      success:function(response)
      { 
	  
	  if(response==1){
	     $('#modal-default').fadeIn();
		$('#pass').show();
		$('#passerror').hide();
		 $("#modal-default").modal("hide");
		$('#email').val('');
		
		
      }else{
		  
		  $('#modal-default').fadeIn();
		  $('#passerror').show();
		  $('#pass').hide();
		  $("#modal-default").modal("hide");
		  $('#email').val('');
	  }
	  return false;
	  }
    });
    return false;
  
  }     
	</script>
</body>
</html>
