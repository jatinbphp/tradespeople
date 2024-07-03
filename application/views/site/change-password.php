<?php include 'include/header.php'; ?>

<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Password</h1>
						<form  onsubmit="return change_password();" id="change_password" method="post" enctype="multipart/form-data">
							<!-- Edit-section-->
							<div class="edit-user-section">
								<div class="col-sm-12">
									<h2> Change Password </h2>
								</div>
											 
									
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="msg3"><?= $this->session->flashdata('msg3');?></div>  
								<div class="row">
									<div class="col-sm-6">                                                    
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for=""> Current Password </label> 
																	
											<div class="col-md-12">
												<input id="old_pass" name="old_pass" placeholder="Current Password" class="form-control input-md" type="password">
																				
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">                                                    
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for=""> New Password </label>  

											<div class="col-md-12">
												<input id="new_pass" name="new_pass" placeholder="New Password" class="form-control input-md" type="password">
																			
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">                                                    
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for=""> Confirm Password </label>  
																	
											<div class="col-md-12">
												<input id="confirm_pass" name="confirm_pass" placeholder="Confirm Password" class="form-control input-md" type="password">
																				
											</div>
										</div>
									</div>
								</div>
							</div>                        
							<!-- Edit-section-->                        
													
							<!-- Edit-section-->
							<div class="edit-user-section gray-bg">
								<div class="row nomargin">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-warning pass_btn">Change Password</button>
																
									</div>                                 
								</div>
							</div>   
							<!-- Edit-section--> 
						</form>							
                        
                        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script >
  function change_password(){
  $.ajax({
    type:'POST',
    url:site_url+'users/update_password',
    data:$('#change_password').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.pass_btn').prop('disabled',true);
      $('.pass_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
    },
    success:function(resp){
      $('.pass_btn').prop('disabled',false);
      $('.pass_btn').html('Change Password');
      $('.msg3').html(resp.msg);
      $('#change_password')[0].reset();
    }
  });
  return false;
}
  
</script>
<?php include 'include/footer.php'; ?>
	