<?php include ("include/header.php") ?>
<?php include ("include/top.php") ?>
<?php
$Claimant=$this->common_model->GetColumnName('users',array('id'=>$dispute['disputed_by']),array('f_name','l_name','type','trading_name','profile'));
?>
<style>
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
</style>
<div class="acount-page membership-page project-list">
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<div class="dispute">
				<div class="manage-profile">
					<h1 class="heading-inner">Milestone payment dispute</h1>
					<p><?php echo $this->session->flashdata('msg');?></p>
					<?php if(count($job_details)>0){ ?>
					<div class="inner-box">
						<div class="inner-body">
							<div class="dispute">
								<div class="">
									<div class="lislll_ideaa">
										<div class="listr_uuusdisp2">
											<p>Milestone payment being disputed: <span class="bol_c2 pull-right"><?php echo $job_details['milestone_name']; ?></span></p>

											<p>Milestone amount: <span class="bol_c2 pull-right">£<?php echo $job_details['milestone_amount']; ?></span></p>

											<!--p>Claimant: <span class="bol_c2 pull-right"><?php echo ($dispute['disputed_by']==$owner['id']) ? $owner['f_name'].' '.$owner['l_name']:$tradmen['trading_name']; ?></span></p>

											<p>Client: <span class="bol_c2 pull-right"><?php echo $owner['f_name'].' '.$owner['l_name']; ?></span></p>

											<p>Tradesperson: <span class="bol_c2 pull-right"><?php echo $tradmen['trading_name']; ?></span></p-->
												
											<p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>
											
											<?php 
											if($value['dct_isfinal']==1){ 
												
											
											} else {
												$winner = '';
											} 
											?>
											
											<p>Case status: <span class="bol_c2 pull-right">
												<?php if($dispute['ds_status'] == '0'){
												echo 'Open';
												} else {
												echo 'Closed';
												} ?>
												</span>
											</p>
											<?php if($dispute['ds_status'] == '1'){ ?>
											<p>Decided in: <span class="bol_c2 pull-right">
												<?php 
												$favorOf=$this->common_model->GetColumnName('users',array('id'=>$dispute['ds_favour']),array('f_name','l_name','type','trading_name'));
												
												
												$winner = ($favorOf['type']==2) ? $favorOf['f_name'].' '.$favorOf['l_name']:$favorOf['trading_name'];
												
												
												echo $winner.' favour';
												?>
												</span>
											</p>
												<?php } ?>
											
										</div>
										<div class="row" style="display: none;">
											<!-- <div class="col-sm-3">
												<div class="pro-pic hard_fix_1">
													<img src="<?php echo site_url('img/jobs/'.$job_files['post_doc']); ?>" class="img-responsive">
												</div>
											</div> -->
										</div>
										
									</div>
								
									<div class="dis-section">
										<div class="row">
											<div class="col-sm-12">
												<div class="dis_div chan_dess">
													<div class="user-imge">
														<?php
														if($Claimant['profile']){
															$profile = $Claimant['profile'];
														} else {
															$profile="dummy_profile.jpg";
														}
														?>
														<img src="<?php echo site_url('img/profile/'.$profile);?>">
													</div>
													<div class="panel panel-default panel-final">
														<div class="panel-heading">	
															<h1>
																Claimant: 
															</h1>
															
															<p class="rbefff1"><?php echo ($Claimant['type']==2) ? $Claimant['f_name'].' '.$Claimant['l_name']:$Claimant['trading_name']; ?></p>
														</div>
														<div class="panel-body">
														 <?php echo $dispute['ds_comment']; ?>										
														</div>
														<div class="panel-heading">
															
														</div>
													</div>
												</div>
												<!--loop-->
												<?php if(count($disput_comment)>0){ 
												
												 foreach ($disput_comment as $value) {
												 $class="default";
												 if($value['dct_isfinal']==1){
                                                   $class="success";
												 }
												 if($value['dct_userid']!=0){
												   $user=$this->common_model->get_userDataByid($value['dct_userid']);
													 
												   if($user['profile']){
														$profile = $user['profile'];
												   }
												   else
												   {
												   	 $profile="dummy_profile.jpg";
												   }
													 
													 $name=($user['type']==1)?$user['trading_name']:$user['f_name'].' '.$user['l_name'];
												 }else{
												   $user=$this->common_model->get_single_data('admin',array('id'=>1));
												   $profile='admin-img.png';
												   $name='Dispute team';
												 }
												?>
												<div class="dis_div chan_dess">

													<div class="user-imge">
														<?php 
															if($profile){?>
														<img src="<?php echo site_url('img/profile/'.$profile);?>">
														<?php } ?>
													</div>
													<div class="panel panel-<?php echo $class; ?> panel-final">
														<div class="panel-heading">	
															<h1>
																<?php  echo $name; ?> 
																<?php if($value['dct_isfinal']==1 && $value['is_reply_pending']==1){ ?>
																<span class="ddell">Deadline: No reply</span> 
																<?php } ?>
															</h1>
															
															<?php /*if($value['dct_isfinal']==1){ 
															$favorOf=$this->common_model->GetColumnName('users',array('id'=>$dispute['ds_favour']),array('f_name','l_name','type','trading_name'));
															?>
															<p class="rbefff1">Case close & Decide in <?php echo ($favorOf['type']==2) ? $favorOf['f_name'].' '.$favorOf['l_name']:$favorOf['trading_name']; ?> favour</p>
															<?php } */?>
														</div>
														<div class="panel-body">
														 <?php echo  $value['dct_msg']; ?>	<br><br>
														
														 <?php if($value['dct_image']!=''){ ?>
														 	<a href="<?php echo base_url('img/dispute/'.$value['dct_image']); ?>" target="_blank"><img src="<?php echo site_url('img/dispute/'.$value['dct_image']);?>" width='100' height='100'></a>
														 <?php } ?>										
														</div>
														<div class="panel-heading">
															<?php 
															if($value['message_to'] != 0){
															$reply_to=$this->common_model->GetColumnName('users',array('id'=>$value['message_to']),array('f_name','l_name','type','trading_name'));
															?>
															<p class="rrrdd">
															Message for: <?php echo ($reply_to['type']==2) ? $reply_to['f_name'].' '.$reply_to['l_name']:$reply_to['trading_name']; ?>, 
															<?php if($value['end_time']){ ?>
															reply before: <?php echo date('d M Y h:i:s A',strtotime($value['end_time']));?>
															<?php } ?>	
															</p>
															<?php } ?>
															<h3> <?php echo date('d-M-Y H:i:s a',strtotime($value['dct_created']));?></h3>
														</div>
													</div>
												</div>
											  
												<?php }} ?>
												<!--loop-->	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="reppll">
					<?php if($dispute['ds_status'] == '0') { ?>
					<div class="reply-btn text-right">
						<?php if($dispute['is_accept']=='0' && $dispute['dispute_to']==$user_data['id']){ ?>
						<a class="btn btn-primary" onclick="return confirm('Are are sure, you want to accept and close this dispute?');" href="<?php echo site_url().'dispute/accept_and_close/'.$dispute['ds_id'].'/'.$dispute['ds_job_id']; ?>">Accept and close</a>
						<?php } ?>
						<a class="btn btn-primary" data-toggle="modal" data-target="#disputework">Reply</a>
					</div>
					<?php } ?>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
										
<?php if($dispute['ds_status'] == '0') { ?>
<div class="modal fade" id="disputework" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<!-- <form method="post" action="process/process1.php?action=add_dispute_comment"> -->
			<form method="post" onsubmit="return check_from();" action="<?php echo site_url('sen_comment');?>" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Reply on Dispute</h4>
				</div>
				<div class="modal-body" id="PublishDetailshow">
					<div class="form-group">
						<label class="control-label">Comment : </label>
						<div class="">    
							<textarea cols="45" rows="5" name="dct_msg" id="dct_msg" class="form-control textarea"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Image : </label>
						<div class="">    
							<input type="file" name="dct_image" class="form-control">
						</div>
					</div>
													
					<input type="hidden" name="ds_id" value="<?php echo $dispute['ds_id'];?>">
					<input type="hidden" name="post_by" value="<?php echo $dispute['ds_puser_id']; ?>">
					<input type="hidden" name="bid_by" value="<?php echo $dispute['ds_buser_id']; ?>">
					<input type="hidden" name="job_id" value="<?php echo $dispute['ds_job_id']; ?>">
					<input type="hidden" name="mile_id" value="<?php echo $dispute['mile_id']; ?>">
												
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-theme disput_btn" value="submit">Submit <i class="fa fa-spin fa-spinner disput_loader" style="font-size:24px;display:none;"></i></button>
				</div>
			</form>
		</div>
										
	</div>
</div>
<?php } ?>
									
<script> 
tinymce.init({ 
	selector: '.textarea', 
	height: 200, 
	plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	setup: function (editor) { 
		editor.on('change', function () { 
			tinymce.triggerSave(); 
		}); 
	} 
}); 
function check_from(){
	var msg = $('#dct_msg').val();
	if(!msg){
		alert('Add you comment!');
		return false;
	}
}
</script>
<?php include ("include/footer.php") ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
