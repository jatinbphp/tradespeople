<?php
include_once('include/header.php');
?>
<div class="content-wrapper" style="min-height: 933px;">
		  <section class="content-header">
    <h1>Payouts</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Payouts</li>
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
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>

										<th>Transaction ID</th>
										<th>Name</th>
										<th>Requested Amount</th>
										<th>Payment Method</th>
										<th>status</th>
										<?php if($_GET['v']!='t'){ ?>
											<!-- <th>Reason</th> -->
											<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($marketer_payouts)){
									$i=1;
									foreach($marketer_payouts as $payouts){ ?>
										<tr>
											<!-- <td><?php echo $payouts->user_id?></td> -->
											<td><?php echo $payouts->trans_id?></td>
											<td><?php echo $payouts->f_name?> <?php echo $payouts->l_name?></td>
											<td>£<?php echo $payouts->request_amount?></td>
											<td><?php if($payouts->payment_method!==''){ echo $payouts->payment_method; }else{ echo "Wallet request"; }  ?></td>
											<td>
												<?php 
												if($payouts->payment_method!=='Wallet request'){
													if($payouts->status=='0'){ ?><span class="label label-warning">Pending</span> <?php }elseif($payouts->status==1){ ?><span class="label label-success">Paid</span> <?php }elseif($payouts->status==2){ ?><span class="label label-danger">Rejected</span> <?php } 
												}else{ ?>
													<span class="label label-success">Paid</span>
												<?php } ?>
											</td>
											<?php if($_GET['v']!='t'){ ?>
												<!-- <td><?= $payouts->reason_for_reject; ?></td> -->

											
													<td> 
												<?php if($payouts->payment_method!=='Wallet request'){ if($payouts->status==2){ ?>
													<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_reasion<?=$payouts->id; ?>" class="btn btn-primary  btn-xs">View Reason</a>
												<?php } ?>
													<?php if($payouts->status=='0'){ ?>
															<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_note<?= $payouts->id; ?>" class="btn btn-danger  btn-xs">Reject</a> 
														<?php if($payouts->payment_method=='Wallet request'){ ?>
															<!-- <a class="btn btn-success btn-xs" href="<?php echo site_url('Admin/Admin/wallet_request_status/'.$payouts->id.'/1/'.$payouts->user_id.'/'.$user_text); ?>" onclick="return confirm('Are you sure! you want to accept this request?');">Accept</a> -->
														<?php }else{ ?>
															<a class="btn btn-success btn-xs" href="<?php echo site_url('Admin/Admin/payout_request_status/'.$payouts->id.'/1/'.$payouts->user_id.'/'.$user_text); ?>" onclick="return confirm('Are you sure! you want to accept this request?');">Accept</a>
														<?php }
															 $bank_detail=$this->Common_model->get_single_data('wd_bank_details',array('wd_user_id'=>$payouts->user_id));
														 ?>
															<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_bank<?= $payouts->id; ?>" class="btn btn-info  btn-xs">Bank Details</a> 
															
															
															<!-- popup............. -->
															<div class="modal fade popup" id="view_bank<?=$payouts->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
																  <div class="modal-dialog" role="document">
																    <div class="modal-content">
																      <div class="modal-header">
																        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																        <h4 class="modal-title" id="myModalLabel">
																        		<?php if(!empty($payment_setting) && $payment_setting['payment_method']=='both' || $payment_setting['payment_method']=='bank_transfer'){ echo "Bank"; }else{ echo "Paypal"; } ?> Details
																      	</h4>
																      </div>
																    
																        <div class="modal-body">
																        	<?php if(!empty($payment_setting) && $payment_setting['payment_method']=='both'){ ?>
																					<p><strong>Bank Name </strong> <?=  $bank_detail['wd_bank']; ?></p>
																					<p><strong>Account Holder </strong> <?=  $bank_detail['wd_account_holder']; ?></p>
																					<p><strong>Account number </strong> <?=  $bank_detail['wd_account']; ?></p> 
																					<p><strong>Sort Code </strong> <?=  $bank_detail['wd_ifsc_code']; ?></p> 
																					<p><strong>Paypal </strong> <?=  $bank_detail['paypal_email_address']; ?></p> 
																					<?php }elseif($payment_setting['payment_method']=='bank_transfer'){ ?>
																						<p><strong>Bank Name </strong> <?=  $bank_detail['wd_bank']; ?></p>
																						<p><strong>Account Holder </strong> <?=  $bank_detail['wd_account_holder']; ?></p>
																						<p><strong>Account number </strong> <?=  $bank_detail['wd_account']; ?></p> 
																						<p><strong>Sort Code </strong> <?=  $bank_detail['wd_ifsc_code']; ?></p> 
																					<?php }else{ ?>  
																						<p><strong>Paypal </strong> <?=  $bank_detail['paypal_email_address']; ?></p>     
																					<?php } ?>      
																					
																        </div>
																        <div class="modal-footer">
																          
																          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																        </div>
																    </div>
																  </div>
																</div>

														<?php } } ?> 
													</td>
												<?php } ?>


										<!-- popup............. -->
										<div class="modal fade popup" id="view_note<?=$payouts->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel">Reason</h4>
											      </div>
											    
											        <div class="modal-body">
																<div class="form-group">
																	<!-- <label>Reason </label> -->
																	<textarea  id="reason_for_reject<?=$payouts->id;?>" rows="7" class="form-control"></textarea>
																	<input type="hidden" id="user_id<?=$payouts->id;?>" value="<?=$payouts->user_id;?>" required="" >
																</div>        
																
											        </div>
											        <div class="modal-footer">
											          <button type="submit" onclick="return add_reasion(<?=$payouts->id;?>);" class="btn btn-success note-save-btn<?= $payouts->id; ?>">Save</button>
											          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											        </div>
											    </div>
											  </div>
											</div>



											<!-- View Reasion -->
											<div class="modal fade popup" id="view_reasion<?=$payouts->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel">Reason</h4>
											      </div>
											    
											        <div class="modal-body">
																<div class="form-group">
																	<p><?= $payouts->reason_for_reject; ?></p>
																</div>        
																
											        </div>
											        <div class="modal-footer">
											          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											        </div>
											    </div>
											  </div>
											</div>



									</tr>
								<?php
								$i++;
								}
								}
								?>
								</tbody>
							</table>
						</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include_once('include/footer.php'); ?>
<script type="text/javascript">

function add_reasion(id){
	$.ajax({
		type:'POST',
		url: site_url + 'Admin/admin/payout_request_rejection',
		data:  {
			reason_for_reject : $('#reason_for_reject'+id).val(),
			user_id : $('#user_id'+id).val(),
			status : 2,
			id : id,
		},
		dataType:'json',
		beforeSend:function(){
			$('.note-save-btn'+id).prop('disabled',true);
		},
		success:function(response){
			console.log(response);
			$('.note-save-btn'+id).prop('disabled',false);
			if(response.status == 1) {
				toastr.success(response.msg);
				$('#reason_for_reject'+id).val('');
				$('#view_note'+id).modal('hide');

				setTimeout(function(){
					location.reload();
				}, 3000);
			} else {
				toastr.error(response.msg);
				$('#view_note'+id).modal('hide');
				$('#reason_for_reject'+id).val('');

			}
		}
	});
	return false;
}
</script>
