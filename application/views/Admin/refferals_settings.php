<?php 
include_once('include/header.php');
?>
<style>
	.settings-frm{
		margin-top: 15px;
	}
	.edit-user-section{
		border: none;
		padding: 0;
	}
	hr{
	border-top: 1px solid #000;
	}
	.edit-user-section input{
		font-weight: 900;	 
	}
</style> 
<?php

	if($settings[0]->type == 'marketers'){
		$referral_links_homeowner_m =  $settings[0]->referral_links_homeowner;
		$referral_links_tradsman_m =  $settings[0]->referral_links_tradsman;
		$comission_ref_homeowner_m =  $settings[0]->comission_ref_homeowner;
		$comission_ref_tradsman_m =  $settings[0]->comission_ref_tradsman;
	}
	if($settings[1]->type == 'homeowners'){
		$referral_links_homeowner_h =  $settings[1]->referral_links_homeowner;
		$referral_links_tradsman_h =  $settings[1]->referral_links_tradsman;
		$comission_ref_homeowner_h =  $settings[1]->comission_ref_homeowner;
		$comission_ref_tradsman_h =  $settings[1]->comission_ref_tradsman;
	}
	if($settings[2]->type == 'tradsman'){
		$referral_links_homeowner_t =  $settings[2]->referral_links_homeowner;
		$referral_links_tradsman_t =  $settings[2]->referral_links_tradsman;
		$comission_ref_homeowner_t =  $settings[2]->comission_ref_homeowner;
		$comission_ref_tradsman_t =  $settings[2]->comission_ref_tradsman;
	}
	


?>
<div class="content-wrapper" style="min-height: 933px;">
	  <section class="content-header">
    <h1>Referral Settings</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> 
			<li class="active">Referral Settings</li>
		</ol>
  </section>
	<div class="container" style="width:100%">
		<div class="user-setting col-xs-12">
			<div class="row">
				<?php
			        $message = '';
			        if (isset($this->session->message)) {
			          $message = $this->session->message;
			          if ($message == 'Settings Updated Successfully') { ?>
			                <div class="col-lg-12 alert alert-success mt-3 close_message" style="margin-bottom: 0px;margin-top: 10px;">
			                  <button class="close" data-dismiss="alert">×</button>
			                  <?php echo htmlspecialchars($message); ?>
			                </div>
			           <?php }}
			        ?>
			</div>
			<div class="row">
				<div class="col-sm-9 box settings-frm" style="padding-left:1px;">
					<div class="user-right-side" style="margin-top:30px;">
						<form action="<?= site_url().'Admin/Admin/update_refferal_satting'; ?>" id="update_profile" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								
								<div class="col-sm-12" style="height:31px;margin-bottom: 10px;"><h2>Marketer</h2></div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Tradsman Shareable Links</strong></label>  
												<input name="referral_links_tradsman_m" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_tradsman_m; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_tradsman_m" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_tradsman_m; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Homeowner Shareable Links</strong></label>  
												<input name="referral_links_homeowner_m" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_homeowner_m; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_homeowner_m" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_homeowner_m; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>
							</div>
							<div class="edit-user-section">
								
								<div class="col-sm-12" style="height:31px;margin-bottom: 10px;"><h2>Homeowner</h2></div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Tradsman Shareable Links</strong></label>  
												<input name="referral_links_tradsman_h" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_tradsman_h; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_tradsman_h" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_tradsman_h; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Homeowner Shareable Links</strong></label>  
												<input name="referral_links_homeowner_h" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_homeowner_h; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_homeowner_h" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_homeowner_h; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>
							</div>

							<div class="edit-user-section">
								
								<div class="col-sm-12" style="height:31px;margin-bottom: 10px;"><h2>Tradsman</h2></div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Tradsman Shareable Links</strong></label>  
												<input name="referral_links_tradsman_t" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_tradsman_t; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_tradsman_t" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_tradsman_t; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>

								<div class="col-sm-6">
										<div class="col-sm-10">
											<div class="form-group">
												<label for=""><strong>Homeowner Shareable Links</strong></label>  
												<input name="referral_links_homeowner_t" placeholder="" class="form-control input-md" type="text" value="<?= $referral_links_homeowner_t; ?>" required=""></b>
	                 		</div>
	               		</div>
	               		<div class="col-sm-2">
											<div class="form-group">
												<label for=""><strong>Amount</strong></label>  
												<input name="comission_ref_homeowner_t" placeholder="" class="form-control input-md" type="text" value="<?= $comission_ref_homeowner_t; ?>" required=""></b>
												
	                 		</div>
	               		</div>
								</div>
							</div>
							
							
							<div class="edit-user-section gray-bg">
								<div class="row nomargin" style="background: #fff; padding: 10px 0;">
									<div class="col-sm-12">
										<button class="btn btn-primary" style="width: 10%;">SAVE</button>
                           
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
<?php include_once('include/footer.php'); ?>
<script>
	jQuery(document).ready(function(){
		jQuery(document).on('click','.add_inputs',function(){
			var value=jQuery(this).attr('attr-type');
			if(value == 'marketer_homeowner'){
				var name="marketer_homeowner[]";
			}if(value == 'marketer_tradsman'){
				var name="marketer_tradsman[]";
			}if(value == 'homeowner_homeowner'){
				var name="homeowner_homeowner[]";
			}if(value == 'homeowner_tradsman'){
				var name="homeowner_tradsman[]";
			}if(value == 'tradsman_homeowner'){
				var name="tradsman_homeowner[]";
			}if(value == 'tradsman_tradsman'){
				var name="tradsman_tradsman[]";
			}
			var parentclass=jQuery(this).parent().parent();
			var parent=jQuery(this).parent().parent().parent();
			jQuery(parentclass).find(".plus_div").html('<i class="fa fa-trash" style="margin-top: 16px;font-size: 19px;"></i>');
			jQuery(parentclass).removeClass(".plus_div");
			var html='<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input  name="'+name+'" placeholder="" class="form-control input-md" type="text" value="" required></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" class="badge add_inputs" attr-type="'+value+'">+</span></div></div>';
			jQuery(parent).append(html);
		});
		jQuery(document).on('click','.fa-trash',function(){
			if(confirm('Please Confirm The Deletion') == true){
				var parentclass=jQuery(this).parent().parent();
				jQuery(parentclass).remove();
			}
			
		});
	});
</script>