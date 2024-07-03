<?php 
include_once('include/header.php');
?>
<style>
	.referal-copy{
padding-top:24px;
}
	.reffer-share{
padding-top:18px;
}
hr{
margin:10px 0px;
}
	.row{
		margin-top: 10px;
	}
	.reffer-share img{
		padding: 0 8px;
	}
	.well {
    background: rgba(61,120,203,1) url(../img/wallet.png);
    border: 1px solid #3d78cb;
    color: #fff;
    padding: 22px 15px;
    min-height: 110px !important;
    background-repeat: no-repeat;
    background-size: 25%;
    background-position: center;
}
	.earn-bnts{
padding-top:25px;
}
	.earn-bnts .btn-warning{
background: #3d78cb;
    border-color: #3d78cb;
margin:0px 10px
}
	/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 43%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
	  .cashout-popup{
		  margin: 70px;
		  text-align: center;
	  }
	  .cashout-popup button{
		width: 80%;
		margin: 20px 0;
		padding: 20px;
	  }
	  .cashout-popup input{
		  padding: 28px;
		  font-size: 23px;
		  margin: auto;
		  width: 80%;
	  }
</style>
<div class="content-wrapper" style="min-height: 933px;">
	  <section class="content-header">
    <h1>Marketers Referrals</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Marketers Referrals</li>
		</ol>
  </section>
	<section class="content">   
    <div class="row">

      <div class="col-xs-12">
        <div class="box">

          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          	    	  
          </div> 
          <div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
			  
			  <div class="container">
				   <div class="row" >
        <div class="col-lg-6">
<div class="col-lg-9">
            <label for="">Home owner</label><br> 
<span type="text" placeholder="" value="" name="" class="form-control input-md">https://www.tradespeoplehub.co.uk/new-referral</span>  
   </div>
<div class="col-lg-3 referal-copy">
            <button class="btn btn-primary">Copy</button>   
</div>      
        </div>
<div class="col-lg-6 reffer-share">
 <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/facebook.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/twitter.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/insta.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/whatsapp.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/mail.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/Blogger.png" alt="">
</div>
    </div>
				  
	  <div class="row" >
        <div class="col-lg-6">
<div class="col-lg-9">
            <label for="">Home owner</label><br> 
<span type="text" placeholder="" value="" name="" class="form-control input-md">https://www.tradespeoplehub.co.uk/new-referral</span>    
   </div>
<div class="col-lg-3 referal-copy">
            <button class="btn btn-primary">Copy</button>   
</div>      
        </div>
<div class="col-lg-6 reffer-share">
 <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/facebook.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/twitter.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/insta.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/whatsapp.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/mail.png" alt="">
            <img src="https://www.tradespeoplehub.co.uk/asset/admin/img/Blogger.png" alt="">
</div>
    </div>
<section class="referar-earnings">
 <!--  <h1 style="font-size:18px;border-bottom: 1px solid #dadada;padding: 14px 20px;">Balance</h1>-->
<div class="row" style="padding:25px">
<div class="col-lg-4 ">
<div class="referar-earnings-wallet">
<div class="Wallet_1 well wel-main">
<h3 class="text text-center"> <i class="fa fa-money"></i> Balance <span><i class="fa fa-gbp"></i>0.00</span> </h3>
</div>
</div>
</div>
<div class="col-lg-8  earn-bnts">
<p><button id="myBtn2" class="btn btn-warning btn-lg">Cash out</button></p>
<p>if want to cash out, it must reach £25  </p>
</div>


</div>
</section>	
<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										
										<th>Refereed Name</th> 
										<th>User Type</th>
										<th>Signed-Up</th>
										<th>Quote Provide/Received</th>
										<th>Job Posted</th>
										<th>Earnings</th>
									</tr>
								</thead>
								<tbody>   
									<tr>
										<td>John Doe</td>
										<td>Home Owner</td>
										<td><input type="checkbox" checked></td>
										<td>1</td>
										<td>1</td>
										<td>£10</td>
									</tr> 
									<tr>
										<td>John Doe</td>
										<td>Home Owner</td>
										<td><input type="checkbox" ></td>
										<td>1</td>
										<td>1</td>
										<td>£10</td>
									</tr> 
									<tr>
										<td>John Doe</td>
										<td>Home Owner</td>
										<td><input type="checkbox" checked></td>
										<td>1</td>
										<td>1</td>
										<td>£10</td>
									</tr> 
								</tbody>
							</table>
						</div>
<div class="row">
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Account Details</h1> <hr>
						<form action="<?= site_url().'users/update_profile'; ?>" onsubmit="return update_profile();" id="update_profile" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="col-sm-12">
									<h2>Name</h2>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">First Name*</label>  
											<div class="col-md-12">
												<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md" <?php echo ($user_profile['type']==1) ? 'readonly' : ''; ?> type="text" value="<?php echo $user_profile['f_name']; ?>" required readonly>
                                        
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Last Name*</label>  
											<div class="col-md-12">
												<input id="l_name" <?php echo ($user_profile['type']==1) ? 'readonly' : ''; ?> name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $user_profile['l_name']; ?>" required readonly>
                                        
											</div>
										</div>
									</div>
								</div>
								
								<?php if($this->session->userdata('type')==1){ ?>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
									
									</div>
								</div>
								<?php } ?>
							</div>                        
							<!-- Edit-section-->
                        
                        
							<!-- Edit-section-->
							<div class="edit-user-section">
								<div class="col-sm-12">
									<h2>Address</h2>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="row">
											<div class="col-sm-12">     
												<div class="form-group">
												
													<div class="col-md-12">
														<input type="text" name="e_address" id="geocomplete" class="form-control" value="<?php echo $user_profile['e_address']; ?>" placeholder="Enter a address" autocomplete="off" required readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Country* </label>  
													<div class="col-md-12">
														<select class="form-control input-lg" required name="country" id="countryus1" disabled>
															<option value=""></option>
															<?php
															foreach($country as $key => $val){
																$selected = ($user_profile['county'] == $val['region_name']) ? 'selected' : '';
																echo '<option '.$selected.' value="'.$val['region_name'].'">'.$val['region_name'].'</option>';
															}
															?>
														</select>
													</div>
												</div>
											</div>                                         
                                                                              
											<!-- Text input-->
											<div class="col-sm-6">     
												<div class="form-group">
													<label class="col-md-12 control-label" for=""> Town/City* </label>  
													<div class="col-md-12">
														<input type="text" placeholder="Town/City" name="locality" id="e_city" value="<?php echo $user_profile['city']; ?>" class="form-control" required readonly>
												
													</div>
												</div>
											</div> 
										</div>
                                    
										<div class="row">
                        
											<div class="col-sm-6">                                                    
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">PostCode*</label>  
											<div class="col-md-12">
							<input type="text" placeholder="PostCode" value="<?php echo $user_profile['postal_code']; ?>" id="postal_code" name="postal_code" class="form-control input-md" required onblur="check_postcode(this.value);" readonly>

					<!-- <input type="hidden" id="latitude" value="<?php echo $user_profile['latitude']; ?>" name="latitude" class="form-control input-lg">

                 <input type="hidden" id="longitude" value="<?php echo $user_profile['longitude']; ?>" name="longitude" class="form-control input-lg"> -->
										
														<p class="text-danger postcode-rec" style="display:none;">Post code is required</p>
														<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
													</div>
												</div>
                                       
											</div>
											<div class="col-sm-6">                                                    
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Profile Picture*</label>  
													<div class="col-md-12">
														<input type="file" name="profile" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();">
														<input type="hidden" name="u_profile_old" value="<?= $user_profile['profile']; ?>" >  
														<div id="imgpreview">
															<?php if($user_profile['profile']){ ?>
															<img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='100px' height='100px'>
															<?php } ?>
														</div>
                                    
													</div>
												</div>
                                       
											</div>
										</div>                                    
										
										
									</div>
								</div>
							</div>  
							
							<!-- Payment details -->
							
							<div class="edit-user-section">
								<div class="col-sm-12">
									<h2>Payment Details</h2>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="row">
											<div class="col-sm-12">     
												<div class="form-group">
												
													<div class="col-md-12">
														<label>Bank account name you are depositing from:</label>
														<input type="text" name="e_address" id="geocomplete" class="form-control" value="Account Name" placeholder="Enter a address" autocomplete="off" required readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">     
												<div class="form-group">
												
													<div class="col-md-12">
														<label>Deposit reference(Receipt or Reference number):</label>
														<input type="text" name="e_address" id="geocomplete" class="form-control" value="REF00012345" placeholder="Enter a address" autocomplete="off" required readonly>
													</div>
												</div>
											</div>
												<p>Note: Any transaction fees charged by your bank will be deducted from the total transfer amount. Funds will be credited to your balance on the next business day after the funds are recieved by bank. If you have any questions please contact us.</p>
										</div>
									
										
									</div>
								</div>
							</div> 
							<!-- Payment Details end -->
					</div>
				</div>
			</div>
			  </div>
			  				</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div id="myModal2" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <!-- <span class="close">&times;</span> -->
   
	  <div class="cashout-popup">
		   <p class="text-center">Available Credit: £10</p>
		  <input type="text" placeholder="Enter Amount to Withdraw" value="" name="" class="form-control input-md text-center">
		   <button class="btn btn-primary">SUBMIT</button>   
		  <p class="text-center">Requested Amount will be credited into your bank account</p>
		  <p class="text-center">if want to cash out, it must reach £25  </p>
	  </div>
  </div>

</div>
<script>
// Get the modal
var modal = document.getElementById("myModal2");

// Get the button that opens the modal
var btn = document.getElementById("myBtn2");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<?php include_once('include/footer.php'); ?>