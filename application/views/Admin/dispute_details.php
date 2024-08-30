<?php 
include_once('include/header.php');
if(!in_array(10,$my_access)) { redirect('Admin_dashboard'); }

$Claimant=$this->Common_model->GetColumnName('users',array('id'=>$dispute['disputed_by']),array('f_name','l_name','type','trading_name','profile'));
?>
<style type="text/css">
.reply-btn .btn{
	margin: 0 3px;
}
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
	
    <h1>Dispute Detail</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dispute Detail</li>
		</ol>
	</section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="col-sm-9">
              <div class="manage-profile">
                <!--<h1 class="heading-inner">DISPUT CONVERSATION</h1>-->
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

														<p>Claimant: <span class="bol_c2 pull-right"><?php echo ($Claimant['type']==2) ? $Claimant['f_name'].' '.$Claimant['l_name']:$Claimant['trading_name']; ?></span></p>

														<p>Client: <span class="bol_c2 pull-right"><?php echo $owner['f_name'].' '.$owner['l_name']; ?></span></p>

														<p>Tradesperson: <span class="bol_c2 pull-right"><?php echo $tradmen['trading_name']; ?></span></p>
												
														<p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>
														<p>Case status: <span class="bol_c2 pull-right">
															<?php if($dispute['ds_status'] == '0'){
															echo 'Open';
															} else {
															echo 'Closed';
															}
															; ?>
															</span></p>
														<?php if($dispute['ds_status'] == '1'){ ?>
														<p>Decided in: <span class="bol_c2 pull-right">
															<?php 
															$favorOf=$this->Common_model->GetColumnName('users',array('id'=>$dispute['ds_favour']),array('f_name','l_name','type','trading_name'));
															
															
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
																		
																		<p class="rbefff1"><?php echo $owner['f_name'].' '.$owner['l_name']; ?></p>
																	</div>
																	<div class="panel-body">
																	 <?php echo $dispute['ds_comment']; ?>										
																	</div>
																	<div class="panel-heading">
																		
																	</div>
																</div>
															</div>
															<!--loop-->
															<?php 
															if($disput_comment){
																$k = 1;
																$profile="dummy_profile.jpg"; 
																foreach ($disput_comment as $value) {
																	$class="default";
																	if($value['dct_isfinal']==1){
																		$class="success";
																	}
																	if($value['dct_userid']!=0){
																		$user=$this->Common_model->get_userDataByid($value['dct_userid']);
																		
																		if($user['profile']){
																			$profile = $user['profile'];
																		} else {
																			$profile = 'dummy_profile.jpg';											 
																		}
																		$name=($user['type']==1)?$user['trading_name']:$user['f_name'].' '.$user['l_name'];
																	
																	}else{
																		
																		$user=$this->Common_model->get_single_data('admin',array('id'=>1));
																		$profile='admin-img.png';
																		$name='Dispute team';
																	
																	}
                                ?>
                              <div class="dis_div chan_dess">

                                <div class="user-imge">
                                      <?php if($profile){?>
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
																		$favorOf=$this->Common_model->GetColumnName('users',array('id'=>$dispute['ds_favour']),array('f_name','l_name','type','trading_name'));
																		?>
																		<p class="rbefff1">Case close & Decide in <?php echo ($favorOf['type']==2) ? $favorOf['f_name'].' '.$favorOf['l_name']:$favorOf['trading_name']; ?> favour</p>
																		<?php } */?>
																	</div>
                                  <div class="panel-body">
                                   <?php echo  $value['dct_msg']; ?>   <br><br>                   
                                  </div>
                                  <div class="panel-heading">
                                    <h3>
																			<?php 
																			if($value['message_to'] != 0){
																			$reply_to=$this->Common_model->GetColumnName('users',array('id'=>$value['message_to']),array('f_name','l_name','type','trading_name'));
																			?>
																			<p class="rrrdd">
																				Message for: <?php echo ($reply_to['type']==2) ? $reply_to['f_name'].' '.$reply_to['l_name']:$reply_to['trading_name']; ?>,  
																				<?php if($value['is_reply_pending']==1){ ?>
																				reply before: <?php echo date('d M Y h:i:s A',strtotime($value['end_time']));?> 
																				<?php } ?>
																			</p> 
																			<?php } ?>
																			<span class="pull-right"><?php echo date('d-M-Y h:i:s A',strtotime($value['dct_created']));?></span></h3>
                                  </div>
                                </div>
                              </div>
                              <?php $k++; }} ?>
                              <!--loop--> 
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                <?php } ?>
                </div>
								<div class="reppll">
                          
                          
                    
                        <?php if($dispute['ds_status'] == '0') { ?>
                          <div class="reply-btn">
                           <a class="btn btn-info pull-right" data-toggle="modal" data-target="#disputework">Reply</a> &nbsp;
                           <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#FinalDecision">Make Final Decision</a> 
                         </div>
                        <?php } ?>
                       
                        
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
<?php if($dispute['ds_status'] == '0') { ?>

<div class="modal fade" id="FinalDecision" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form method="post" onsubmit="return check_from(1);" action="<?php echo site_url('makedisputefinal'); ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reply on Dispute</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">In Favor of: </label>
            <div class="">    
              <select class="form-control" name="ds_favour" required>
                <option value="">Select </option>
                <option value="<?php echo $owner['id']; ?>" ><?php echo $owner['f_name'].' '.$owner['l_name']; ?>(Homeowner)</option>
                <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'].' '.$tradmen['l_name']; ?>(Tradesman )</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Comment : </label>
            <div class="">    
              <textarea cols="45" rows="5" name="massage" id="dct_msg1" class="form-control textarea"></textarea>
            </div>
          </div>

            <input type="hidden" name="ds_id" value="<?php echo $dispute['ds_id'];?>">
						<input type="hidden" name="homeowner_id" value="<?php echo $dispute['ds_puser_id']; ?>">
						<input type="hidden" name="tradesman_id" value="<?php echo $dispute['ds_buser_id']; ?>">
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
<div class="modal fade" id="disputework" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form method="post" onsubmit="return check_from(2);" action="<?php echo site_url('add_dispute_comment'); ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reply on Dispute</h4>
        </div>
        <div class="modal-body">
					<div class="form-group">
            <label class="control-label">Message to: </label>
            <div class="">    
              <select class="form-control" name="message_to" required>
                <option value="">Select </option>
                <option value="<?php echo $owner['id']; ?>" ><?php echo $owner['f_name'].' '.$owner['l_name']; ?>(Homeowner)</option>
                <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'].' '.$tradmen['l_name']; ?>(Tradesman )</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Comment : </label>
            <div class="">    
              <textarea cols="45" rows="5" name="massage" id="dct_msg2" class="form-control textarea" ></textarea>
            </div>
          </div>

          <input type="hidden" name="dispute_id" value="<?php echo $dispute['ds_id'];?>">
          <input type="hidden" name="job_id" value="<?php echo  $dispute['ds_job_id'] ?>">
          <input type="hidden" name="serid" value="<?php echo  $dispute['caseid']; ?>">
          <input type="hidden" name="tradesman_id" value="<?php echo  $dispute['ds_buser_id']; ?>">
          <input type="hidden" name="homeowner_id" value="<?php echo  $dispute['ds_puser_id']; ?>">
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


<?php include_once('include/footer.php'); ?>
<script>
function check_from(id){
	var msg = $('#dct_msg'+id).val();
	if(!msg){
		alert('Add you comment!');
		return false;
	}
}
</script>