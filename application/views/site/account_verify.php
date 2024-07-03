<?php include 'include/header.php'; ?>
<style type="text/css">
  #vote_buttons :hover {
    cursor:pointer;
}
#verify_btn
{
  display: inline-block;
    font-size: 13px;
    line-height: 24px;
    width: auto;
    color: #fff;
    padding: 0 24px 0 24px;
    padding-top: 0px;
    padding-right: 24px;
    padding-bottom: 0px;
    padding-left: 24px;
    background-color: #FF7353;
    border: 0;
    margin: 0px 0 0px 0;
    border-bottom: 2px solid #FF3000;
    border-radius: 6px;
}

</style>
<div class="acount-page membership-page">
	<div class="container">

		<div class="row">

			<div class="col-md-3">
				<!-- sidebar here -->
				<?php include 'include/sidebar.php'; ?>
				<!-- sidebar here -->
			</div>


			<div class="col-md-9">
                  
				<div class="verify-messages">
					<div style="clear:both;"></div>
				</div>  

				<div class="mjq-sh">
					<h2><strong>Account Verification</strong></h2>
				</div>

			
				<?php if($this->session->flashdata('error')) { ?>
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
				<?php } if($this->session->flashdata('success')) { ?>
				<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
				<?php } ?>
				<?php echo $this->session->flashdata('success1123'); ?>

				<div class="verification-checklist">
					<ul class="list">
						<li>
							<div class="title">Email address</div>
							<?php if($user_profile['u_email_verify']==1){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>      
							<div class="sub-title">Verified</div>

			
							<?php }else{ ?> 
							<i class="fa fa-times" aria-hidden="true"></i>  
							<div class="sub-title"><a href="<?php echo site_url(); ?>email-verify">Verify Now</a></div>
							<?php } ?>
						</li>
						<li>
							<div class="title">Payment method</div>
							<?php 
							$Payment_method = $this->common_model->GetColumnName('billing_details',array('user_id'=>$user_data['id']),array('is_payment_verify'));
							if($Payment_method && $Payment_method['is_payment_verify'] == 1){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php }else{ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a href="<?php echo site_url().'billing-info/?verify=1'; ?>">Payment Method</a></div>
							<?php } ?>
						</li>
						<li>
							<div class="title">Phone number</div>
							<?php if($user_profile['is_phone_verified'] != 0){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php }else{ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a href="<?php echo site_url().'users/verify_phone'; ?>">Verify Now</a></div>
							<?php } ?>
						</li>
						<li>
							<div class="title">Address</div>
							<?php if($user_profile['u_status_add']==0){ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a data-target="#address_verify" href="" data-toggle="modal">Verify Now</a></div>
<div class="modal fade popup" id="address_verify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Address Verification</h4>
			</div>
			<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_address/'.$this->session->userdata('user_id')).'/verify'; ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<fieldset>

						<!-- Text input-->
						<div class="form-group">
				 
							<div class="col-md-12">
							 <p style="text-align: center;font-size: 15px;"><b>To verify your address, upload either your utility bill or driving license or recent bank statement  as proof of address.</b></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<div class="form-group">
	 
									<input type="file" onchange="check_file_size(this,0);" name="u_address" required="" id="u_address" class="form-control">
	
								</div>
							</div>
							<div class="col-sm-2"></div>
						</div>
 

					</fieldset>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-warning port_btn0">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
						
							
							<?php }else if($user_profile['u_status_add']==1){ ?>
							<i class="fa fa-hourglass" aria-hidden="true"></i>
							<div class="sub-title"><p>Under Review</p></div>
							<?php }else if($user_profile['u_status_add']==2){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php } ?>

						</li>
						
						<li>
							<div class="title">Verification ID card</div>
							<?php if($user_profile['u_id_card_status']==0){ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a data-target="#idcard_verify" href="" data-toggle="modal">Verify Now</a></div>
<div class="modal fade popup" id="idcard_verify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Verification ID card</h4>
			</div>
			<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_idcard/'.$this->session->userdata('user_id')).'/verify'; ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<fieldset>

						<!-- Text input-->
						<div class="form-group">
				 
							<div class="col-md-12">
							 <p style="text-align: center;font-size: 15px;"><b>To verify your ID card, upload a passport or driving license,or other valid document.</b></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<div class="form-group">
	 
									<input type="file" onchange="check_file_size(this,2);" name="u_id_card" required="" id="u_id_card" class="form-control">
	
								</div>
							</div>
							<div class="col-sm-2"></div>
						</div>
 

					</fieldset>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-warning port_btn2">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
							
							<?php }else if($user_profile['u_id_card_status']==1){ ?>
							<i class="fa fa-hourglass" aria-hidden="true"></i>
							<div class="sub-title"><p>Under Review</p></div>
							<?php }else if($user_profile['u_id_card_status']==2){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php } ?>

						</li>

						<li>
							<div class="title">Public Liability</div>
							<?php if($user_profile['u_status_insure']==0){ ?>
							<i class="fa fa-times" aria-hidden="true"></i>
							<div class="sub-title"><a data-target="#public_liability" href="" data-toggle="modal">Upload</a> (Optional)</div>
<div class="modal fade popup" id="public_liability" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Public Liability Verification</h4>
			</div>
			<form method="POST" id="imageEdit" action="<?php echo base_url('users/upload_insurance/'.$this->session->userdata('user_id')).'/verify'; ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<fieldset>
	
						<!-- Text input-->
						<div class="form-group">
				 
							<div class="col-md-12">
							 <p style="text-align: center;font-size: 15px;"><b>To verify public liability, upload your insurance certificate.</b></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<div class="form-group">
			 
									<input type="file" name="u_insurrance_certi" onchange="check_file_size(this,1);" required="" id="u_insurrance_certi" class="form-control">
			
								</div>
							</div>
							<div class="col-sm-2"></div>
						</div>
					</fieldset>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-warning port_btn1">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
	
							<?php }else if($user_profile['u_status_insure']==1){ ?>
							<i class="fa fa-hourglass" aria-hidden="true"></i>
							<div class="sub-title"><p>Under Review</p></div>
							<?php }else if($user_profile['u_status_insure']==2){ ?>
							<i class="fa fa-check" aria-hidden="true"></i>
							<div class="sub-title">Verified</div>
							<?php } ?>
						</li>

					</ul>
				</div>

			</div>
		</div>


	</div>
</div>
<?php include 'include/footer.php'; ?>
<script type="text/javascript">
function update_profile2()
{
      $('.submit_btn13').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
    $('.submit_btn13').prop('disabled',true);
}

function check_file_size(e,id){
	var size = e.files[0].size;
	
	var ext = e.value.split('.').pop().toLowerCase();
	
	if(ext=='jpeg' || ext=='png' || ext=='jpg' || ext=='gif'){
		$('.port_btn'+id).prop('disabled',false);
	} else {
		$('.port_btn'+id).prop('disabled',true);
		swal('This file type is not allowed, Allow types are jpeg, png, jpg, gif.');
		return false;
	}
	
	var max = 1024*20*1024;
	if(max >= size){
		$('.port_btn'+id).prop('disabled',false);
	} else {
		$('.port_btn'+id).prop('disabled',true);
		swal('File too large. File must be less than 20 MB.');
		return false;
	}
		
	
}
</script>