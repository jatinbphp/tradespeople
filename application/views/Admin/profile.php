<?php include_once('include/header.php'); ?>
 <style>
 .form-group {
    display: inline-block;
    width: 100%;
  }
 </style>
 <div class="content-wrapper">
    <section class="content-header">
      <h1>Profile<small>Control panel</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>
    <section class="content">
     	<div class="row">
       	<div class="col-md-6"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Update Profile</h3>
            </div>
			
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal"  id="techform" action="<?php echo site_url('Admin/Admin/update_profile'); ?>" method="post">
			<?php 
			if($this->session->flashdata('error'))
			{
				?>
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
				<?php
			}
			if($this->session->flashdata('success'))
			{
				?>
				<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
				<?php
			}
			?>
              <div class="changeUsenrameMessages"></div>
              <div class="box-body">
								<div class="form-group">
                  <label for="Username" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="Username" id="Username" placeholder="Username" value="<?php  echo $admininfo['username']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                  <input type="email" <?php echo ($admininfo['type']==2)?'readonly':''; ?> class="form-control" name="email" id="email" placeholder="" value="<?php  echo $admininfo['email']; ?>">
                  </div>
                </div>
               
             	</div>
              <div class="box-footer">
              
                <button type="submit" name="submit"  value="submit" class="btn btn-info pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
              </div>     
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <form method="POST" onsubmit="return changePassword();" id="change_passoword" action="" >
              <div class="err_msg"></div>
                  <?php 
     
      if($this->session->flashdata('success1'))
      {
        ?>
        <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
        <?php
      }
      ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Current Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="oldpassword" placeholder="Current Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="newpassword" class="col-sm-2 control-label">New Password</label>
                  <div class="col-sm-10">
                    <input type="password" minlength="6" name="password" required id="newpassword" placeholder="New Password" name="password" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="repassword" class="col-sm-2 control-label">Confirm Password</label>
                  <div class="col-sm-10">
                    <input type="password" placeholder="Confirm Password" required id="repassword" class="form-control">
                  </div>
                </div>
              </div>
              <div class="box-footer">
					<button type="submit" class="btn btn-info btn-loads">
                         Submit <i style="display:none;" class="fa fa-spinner fa-spin fa-fw fs_prop"></i>
                        </button>
              </div>
            </form>      
          </div>
        </div>
      </div>
    </section>
  </div>
<?php include_once('include/footer.php'); ?>
 <script>
function changePassword(){
	$('.err_msg').html('');
	var newpassword = $('#newpassword').val();
	var repassword = $('#repassword').val();
	var formdata = $('#change_passoword').serialize();
	if(newpassword.length<6)
	{
		$('.err_msg').html('<p class="alert alert-danger">Error! Passwords must be atleast 6 characters long.</p>');
		$('#newpassword').focus();
		return false;
	}
	else if(newpassword!= repassword){
		$('.err_msg').html('<p class="alert alert-danger">Error! Password and confirm password should be same.</p>');
		$('#repassword').focus();
		return false;
	}
	else{
	   $.ajax({
	   type : 'post',
	   data : formdata,
	   url  : '<?php echo site_url(); ?>/Admin/Admin/dochange_password',
	   dataType:'json',
	   beforeSend:function()
	   {
			$('.btn-loads').prop('disabled',true);
			$('.fs_prop').show();
	   },
	   success : function(data){
		   $('.btn-loads').prop('disabled',false);
		   $('.fs_prop').hide();
		   if(data.result==1){
			   location.reload();
				return false;
			}
			else{
				$('.err_msg').html('<p class="alert alert-danger">Error! Invalid Current password.</p>');
				
				 return false;
			}				
	   }
	});
	return false;
	}
	

} 
</script>