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
                      <h1>Payment &amp; Financials</h1>
                        <!-- Edit-section-->
                        <div class="edit-user-section">
                          <div class="col-sm-12">
                          <h2>  Payment Methods </h2>
                            </div>
                            <div class="row nomargin">
                              <div class="col-sm-12">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <a type="button" class="btn btn-default" data-target="#Post-Project" data-toggle="modal">+ Payment Method</a>
                                    </div>
                                 </div>                                 
                            </div>
                          
                            
                        </div>                        
                        <!-- Edit-section-->  
                        
                        <div class="edit-user-section">
                          <div class="col-sm-12">
                          <h2>  Finance Settings  </h2>
                            </div>
                          <div class="row">
                              <div class="col-sm-6">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-12 control-label" for="">  My Currency  </label>  
                                      <div class="col-md-12">
                                      <select class="form-control input-md" id="currency" name="currency">
                                
                                    <option value="1">
                                        USD
                                    </option>
                                
                                    <option value="3">
                                        AUD
                                    </option>
                                
                                    <option value="9">
                                        CAD
                                    </option>
                                
                                    <option value="8">
                                        EUR
                                    </option>
                                
                                    <option value="4">
                                        GBP
                                    </option>
                                
                                    <option value="21">
                                        CNY
                                    </option>
                                
                                    <option value="5">
                                        HKD
                                    </option>
                                
                                    <option selected="" value="11">
                                        INR
                                    </option>
                                
                                    <option value="12">
                                        JMD
                                    </option>
                                
                                    <option value="13">
                                        CLP
                                    </option>
                                
                                    <option value="18">
                                        JPY
                                    </option>
                                
                                    <option value="17">
                                        SEK
                                    </option>
                                
                                    <option value="16">
                                        MYR
                                    </option>
                                
                                    <option value="15">
                                        IDR
                                    </option>
                                
                                    <option value="14">
                                        MXN
                                    </option>
                                
                                    <option value="2">
                                        NZD
                                    </option>
                                
                                    <option value="7">
                                        PHP
                                    </option>
                                
                                    <option value="19">
                                        PLN
                                    </option>
                                
                                    <option value="6">
                                        SGD
                                    </option>
                                
                                    <option value="20">
                                        BRL
                                    </option>
                                
                                    <option value="10">
                                        ZAR
                                    </option>
                                
                            </select>
                                        
                                      </div>
                                    </div>
                                 </div>
                              </div>
                          <div class="row">
                                 <div class="col-sm-12">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <label class="col-md-12 control-label" for="">Taxes</label>  
                                      <div class="col-md-12">
                                        <div class="row">
                                          <div class="col-sm-4">
                                              <input id="textinput" name="textinput" placeholder="Tax Type" class="form-control input-md" type="text">
                                            </div>
                                          <div class="col-sm-4">
                                              <input id="textinput" name="textinput" placeholder="Rate" class="form-control input-md" type="number">
                                            </div>
                                          <div class="col-sm-4">
                                              <input id="textinput" name="textinput" placeholder="Tax ID or Company No" class="form-control input-md" type="text">
                                            </div>
                                        </div>                                        
                                      </div>
                                    </div>
                                 </div>
                            </div>
                            
                            
                            
                            <div class="row nomargin">
                              <div class="col-sm-12">                                                    
                                    <!-- Text input-->
                                    <div class="form-group">
                                      <a type="button" class="btn btn-default" data-target="#Post-Project" data-toggle="modal">+ Another Tax</a>
                                    </div>
                                 </div>                                 
                            </div>
                            
                        </div>
                        
                        
                        
                        
                                              
                        
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