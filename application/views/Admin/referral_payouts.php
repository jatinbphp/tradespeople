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
										<th>Id</th> 
										<th>Name</th>
										<th>Requested Amount</th>
										<th>Payment Method</th>
										<th>status</th>
										<?php if($this->uri->segment(1)=='reject_referral_payouts'){ ?>
											<th>Reason</th>
										<?php } ?>
										<?php if($this->uri->segment(1)=='pending_referral_payouts' || $this->uri->segment(1)=='reject_referral_payouts'){ ?>
										<th>Action</th>
										<?php } ?>

									</tr>
								</thead>
								<tbody> 
									<?php if(isset($payout_requests) && !empty($payout_requests)){ $sn= 1;  foreach ($payout_requests as $key => $payout) { $user= $this->db->select('f_name, l_name')->where('id', $payout['user_id'])->get('users')->row(); ?>  
											<tr>
												<td><?= $sn++; ?></td>
												<td><?php if(!empty($user)){ echo $user->f_name.' '.$user->l_name; } ?></td>
												<td>£<?= $payout['request_amount']; ?></td>
												<td><?= $payout['payment_method']; ?></td>
												<td>
													<?php if($payout['status']=='0'){ ?><span class="label label-warning">Pending</span> <?php }elseif($payout['status']==1){ ?><span class="label label-success">Approved</span> <?php }if($payout['status']==2){ ?><span class="label label-danger">Rejected</span> <?php } ?>
												</td>
												<?php if($this->uri->segment(1)=='reject_referral_payouts'){ ?>
													<td><?= $payout['reason_for_reject']; ?></td>
												<?php } ?>
												
													<?php if($this->uri->segment(1)=='pending_referral_payouts'){ ?>
														<td> 
														<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_note<?= $payout['id']; ?>" class="btn btn-danger  btn-xs">Reject</a> 
														<a class="btn btn-success btn-xs" href="<?php echo site_url('Admin/Admin/payout_request_status/'.$payout['id'].'/1/'.$payout['user_id'].'/ac'); ?>" onclick="return confirm('Are you sure! you want to accept this request?');">Accept</a>
														</td>
													<?php } ?>  
													<?php if($this->uri->segment(1)=='reject_referral_payouts'){ ?>
														<td> 
														<a href="javascript:void(0);"  data-toggle="modal" data-target="#view_reasion<?=$payout['id']; ?>" class="btn btn-primary  btn-xs">View more</a>
														</td>
													<?php } ?> 
												
											</tr> 

											<div class="modal fade popup" id="view_note<?=$payout['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel">Save Reasion</h4>
											      </div>
											    
											        <div class="modal-body">
																<div class="form-group">
																	<label>Reasion </label>
																	<textarea  id="reason_for_reject<?=$payout['id'];?>" rows="7" class="form-control"></textarea>
																	<input type="hidden" id="user_id<?=$payout['id'];?>" value="<?=$payout['user_id'];?>" required="" >
																</div>        
																
											        </div>
											        <div class="modal-footer">
											          <button type="submit" onclick="return add_reasion(<?=$payout['id'];?>);" class="btn btn-success note-save-btn<?=$payout['id'];?>">Save</button>
											          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											        </div>
											    </div>
											  </div>
											</div>

											<!-- View Reasion -->
											<div class="modal fade popup" id="view_reasion<?=$payout['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											  <div class="modal-dialog" role="document">
											    <div class="modal-content">
											      <div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title" id="myModalLabel">View Reasion</h4>
											      </div>
											    
											        <div class="modal-body">
																<div class="form-group">
																	<label>Reasion </label>
																	<textarea rows="7" class="form-control" readonly><?= $payout['reason_for_reject']; ?></textarea>
																</div>        
																
											        </div>
											        <div class="modal-footer">
											          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											        </div>
											    </div>
											  </div>
											</div>


									<?php } } ?>
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