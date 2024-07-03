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
foreach($settings as $setting){
	
	if($setting->type == 'tradsman'){
		$min_quotes_received_homeowner_t =  $setting->min_quotes_received_homeowner;
		$min_quotes_approved_tradsman_t =  $setting->min_quotes_approved_tradsman;
		$comission_ref_homeowner_t =  $setting->comission_ref_homeowner;
		$comission_ref_tradsman_t =  $setting->comission_ref_tradsman;
		$referral_links_homeowner =  $setting->referral_links_homeowner;
		$referral_links_tradsman =  $setting->referral_links_tradsman;
		$tradsman_ref_links_hm = explode(",",$referral_links_homeowner);
		$tradsman_ref_links_tm = explode(",",$referral_links_tradsman);
	}
}
?>
<div class="content-wrapper" style="min-height: 933px;">
	<section class="content-header">
		<h1>Tradesman Sharable Links</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li> 
			<li class="active">Tradesman Sharable</li>
		</ol>
  </section>
	<div class="container" style="width:100%">
		<div class="user-setting col-xs-12">
			<div class="row">
				<?php
				$message = '';
				if (isset($this->session->message)) {
					$message = $this->session->message;
					if ($message == 'Tradesman Sharable Links Updated Successfully') { ?>
						<div class="col-lg-12 alert alert-success mt-3 close_message" style="margin-bottom: 0px;margin-top: 10px;">
							<button class="close" data-dismiss="alert">×</button>
							<?php echo htmlspecialchars($message); ?>
						</div>
				 <?php } ?>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-sm-9 box settings-frm" style="padding-left:1px;">
					<div class="user-right-side" style="margin-top:30px;">
						<form action="<?= site_url().'Admin/Admin/update_trads_sharable'; ?>" id="update_profile" method="post" enctype="multipart/form-data">
							<input type="hidden" name="shareable" value="shareable-link">
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="col-sm-12" style="height:31px;margin-bottom: 10px;">
									<h2>Tradsman</h2>
								</div>
								<div class="col-sm-5" style="padding-left:2px;">
									
									<div class="row">
										<div class="col-sm-12" style="padding-right: 0px;">
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-4 control-label" for="" style="padding-right: 0px;"> <b>Homeowner sharable links</b></label>  
												<div class="col-md-8 append_input">
													<?php
													if(!empty($tradsman_ref_links_hm)){
														for($m=0;$m<count($tradsman_ref_links_hm);$m++){
															if(($m+1) == count($tradsman_ref_links_hm)){?>
																<div class="row" style="margin-top:10px;">
																	<div class="col-lg-11" style="padding-right: 0px;">
																		<input name="tradsman_homeowner[]" placeholder="" class="form-control input-md" type="url" value="<?php echo $tradsman_ref_links_hm[$m]?>" required="">
																	</div>
																	<div class="col-lg-1 plus_div" style="padding-left: 4px;">
																		<span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" attr-type="tradsman_homeowner" class="badge add_inputs">+</span>
																	</div>
																</div>
																<?php
																}else{?>
																<div class="row" style="margin-top:10px;">
																	<div class="col-lg-11" style="padding-right: 0px;">
																		<input name="tradsman_homeowner[]" placeholder="" class="form-control input-md" type="text" value="<?php echo $tradsman_ref_links_hm[$m]?>" required="">
																	</div>
																	<div class="col-lg-1 plus_div" style="padding-left: 4px;"><i class="fa fa-trash" style="margin-top: 16px;font-size: 19px;"></i></div>
																</div>
															<?php
															}
														}
													}else{?>
														<div class="row" style="margin-top:10px;">
															<div class="col-lg-11" style="padding-right: 0px;">
																<input name="tradsman_homeowner[]" placeholder="" class="form-control input-md" type="text" value="" required="">
															</div>
															<div class="col-lg-1 plus_div" style="padding-left: 4px;">
																<span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" attr-type="tradsman_homeowner" class="badge add_inputs">+</span>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-5">
									
								<div class="row">
									<div class="col-sm-12" style="padding-right: 0px;">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-4 control-label" for="" style="padding-right: 0px;"> <b>Tradsman shareable link</b></label>  
											<div class="col-md-8 append_input">
												<?php
												if(!empty($tradsman_ref_links_tm)){
													for($n=0;$n<count($tradsman_ref_links_tm);$n++){
														if(($n+1) == count($tradsman_ref_links_tm)){?>
															<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input name="tradsman_tradsman[]" placeholder="" class="form-control input-md" type="url" value="<?php echo $tradsman_ref_links_tm[$n]?>" required=""></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" attr-type="tradsman_tradsman" class="badge add_inputs">+</span></div></div>
														<?php
														}else{?>
															<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input name="tradsman_tradsman[]" placeholder="" class="form-control input-md" type="text" value="<?php echo $tradsman_ref_links_tm[$n]?>" required=""></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><i class="fa fa-trash" style="margin-top: 16px;font-size: 19px;"></i></div></div>
														<?php
														}
													}
												}else{?>
														<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input name="tradsman_tradsman[]" placeholder="" class="form-control input-md" type="text" value="" required=""></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" attr-type="tradsman_tradsman" class="badge add_inputs">+</span></div></div>
												<?php
												}
												?>
												</div>
										</div>
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
			var html='<div class="row" style="margin-top:10px;"><div class="col-lg-11" style="padding-right: 0px;"><input  name="'+name+'" placeholder="" class="form-control input-md" type="url" value="" required></div><div class="col-lg-1 plus_div" style="padding-left: 4px;"><span style="background: #222d32;color:#fff;margin-top: 15px;cursor: pointer;" class="badge add_inputs" attr-type="'+value+'">+</span></div></div>';
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