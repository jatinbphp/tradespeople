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
                      <h1>Account</h1>
                        <!-- Edit-section-->
                        <div class="edit-user-section">
                          <div class="col-sm-12">
                          <h2>  Directory and Follow Settings </h2>
                            </div>
                          <div class="row">
                              <div class="col-sm-6">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-12 control-label" for=""> Current Password </label>  
                                      <div class="col-md-12">
                                      <input id="textinput" name="textinput" placeholder="First Name" class="form-control input-md" type="text">
                                        
                                      </div>
                                    </div>
                                 </div>
                              </div>
                          
                            
                        </div>                        
                        <!-- Edit-section-->                        
                        
                        
                        
                        
                        <!-- Edit-section-->
                        <div class="edit-user-section">
                          <div class="col-sm-12">
                          <h2> Account Type </h2>
                            </div>
                          <div class="row">
                              <div class="col-sm-6">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-12 control-label" for="">  I'm looking to: </label>  
                                      <div class="col-md-12"> 
                                                <label class="radio-inline" for="radios-0">
                                                  <input name="radios" id="radios-0" value="1" checked="checked" type="radio">
                                                   Work   
                                                </label> 
                                                <label class="radio-inline" for="radios-1">
                                                  <input name="radios" id="radios-1" value="2" type="radio">
                                                  Hire
                                                </label>
                                              </div>
                                    </div>
                                 </div>
                              </div>
                          
                            
                        </div>                        
                        <!-- Edit-section-->                        
                        
                        
                        <!-- Edit-section-->
                        <div class="edit-user-section">
                          <div class="col-sm-12">
                          <h2> Close Account </h2>
                            </div>
                          <div class="row">
                              <div class="col-sm-6">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <div class="col-md-12"> 
                                          <a class="btn btn-default" type="button" data-target="#Post-Project" data-toggle="modal">Manage</a>
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
                                    <a class="btn btn-warning" type="button" data-target="#Post-Project" data-toggle="modal">Save Settings</a>
                                 </div>                                 
                            </div>
                        </div>                        
                        <!-- Edit-section--> 
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<?php include 'include/footer.php'; ?>
	
  <div class="modal fade" id="Post-Project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel"></h3>
      </div>
      <div class="modal-body text-center success-bg-button">
        <h1><i class="fa fa-check-circle fs-5x" aria-hidden="true"></i></h1>
       <h3 class="">Your Request has been Processed Please Wait for Admin Approval</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>