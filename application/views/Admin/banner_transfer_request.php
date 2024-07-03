<?php 
include_once('include/header.php');
if(!in_array(16,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Bank Transfer Homeowner</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Bank Transfer</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
  </section>

  <section class="content">   
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
          	<div class="table-responsive">
						<?php if($this->session->flashdata('error')) { ?>
						<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
						<?php } ?>
						<?php if($this->session->flashdata('success')) { ?>
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php } ?>
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                	<th style="display: none;"></th>
									<th>Id</th> 
									<th>User</th>
									<th>Amount</th>
									<th>Comission</th>
									<th>User Amount</th>
									<th>City</th>
									<th>Bank account name</th>
									<th>Date of deposit</th>
									<th>Reference Number</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
              </thead>
              <tbody>
								<?php foreach($bank_transfer_history as $key => $row){
								$user = $this->Common_model->get_coloum_value('users',array('id'=>$row['userId']),array('f_name','l_name'));
								$city = $this->Common_model->get_coloum_value('tbl_region',array('id'=>$row['contryId']),array('region_name'));
								?>
								
								<tr class="tr_class">
									<td style="display:none;"><?php echo $key+1; ?></td>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $user['f_name'].' '.$user['l_name']; ?></td>
									<td><?php echo ($row['amount'] > 0)?'<i class="fa fa-gbp"></i>'.$row['amount']:'-'; ?></td>
									<td><?php echo $row['admin_amt']; ?></td>
									<td><?php echo $row['user_amount']; ?></td>
									<td><?php echo $city['region_name']; ?></td>
									<td><?php echo $row['bank_account_name']; ?></td>
									<td><?php echo date('d-m-Y',strtotime($row['date_of_deposit'])); ?></td>
									<td><?php echo $row['reference']; ?></td>
									<td>
										<?php if($row['status']==1) { ?>
										<span class="label label-success">Accepted</span>
										<?php } else if($row['status']==2) { ?>
										<span class="label label-danger">Rejected</span> 
										

										<?php } else { ?>
										<span class="label label-warning">Pending</span>
										<?php } ?>
									</td>
									<td>
										<?php if($row['status']==0) {?>
										
										<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#accept_<?php echo $row['id']; ?>">Approve</button> 
										<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#reject_<?php echo $row['id']; ?>">Reject</button> 
										
<!-- Modal -->
<div id="accept_<?php echo $row['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Approve</h4>
      </div>
			<form method="post" id="approve_bank_transer<?php echo $row['id']; ?>" onsubmit="return approve_bank_transer(<?php echo $row['id']; ?>);">
				<div class="modal-body">
					<div class="editmsg<?php echo $row['id']; ?>"></div>
					<div class="form-group">
						<label>Enter Amount</label>
						<input type="number" step="0.01" name="amount" value="<?php echo $row['user_amount']; ?>" class="form-control" required>
					</div>
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary accept_btn<?php echo $row['id']; ?>">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
    </div>

  </div>
</div>
										
<!-- Modal -->
<div id="reject_<?php echo $row['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Approve</h4>
      </div>
			<form method="post" id="reject_bank_transer<?php echo $row['id']; ?>" onsubmit="return reject_bank_transer(<?php echo $row['id']; ?>);">
				<div class="modal-body">
					<div class="Reditmsg<?php echo $row['id']; ?>"></div>
					<div class="form-group">
						<label>Enter Reason</label>
			
						<textarea name="reject_reason" class="form-control" required required></textarea>
					</div>
					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary reject_btn<?php echo $row['id']; ?>">Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
    </div>

  </div>
</div>
			
										<?php } else if($row['status']==2) { ?>
										
										<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#bank_reject<?php echo $row['id']; ?>">View Reason</button>
<!-- Modal -->
<div id="bank_reject<?php echo $row['id']; ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Reject Reason</h4>
			</div>
			<div class="modal-body">
				<p style="color:#000"><?php echo $row['reject_reason']; ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>										
										<?php } ?>
										
										
									</td>
									
								</tr>
							<?php }?>
              </tbody>
            </table>
			</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<script>

function approve_bank_transer(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/dispute/approve_bank_transer',
		data: $('#approve_bank_transer'+id).serialize(),
		dataType: 'JSON',
		beforeSend:function(){
			$('.accept_btn'+id).prop('disabled',true);
			$('.accept_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
			$('.editmsg'+id).html('');
		},
		success:function(resp){
			if(resp.status==1){
				location.reload();
			} else {
				$('.accept_btn'+id).prop('disabled',false);
				$('.accept_btn'+id).html('Submit');
				$('.editmsg'+id).html(resp.msg);
			}
		}
	});
	return false;
}

function reject_bank_transer(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/dispute/reject_bank_transer',
		data: $('#reject_bank_transer'+id).serialize(),
		dataType: 'JSON',
		beforeSend:function(){
			$('.reject_btn'+id).prop('disabled',true);
			$('.reject_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
			$('.Reditmsg'+id).html('');
		},
		success:function(resp){
			if(resp.status==1){
				location.reload();
			} else {
				$('.reject_btn'+id).prop('disabled',false);
				$('.reject_btn'+id).html('Submit');
				$('.Reditmsg'+id).html(resp.msg);
			}
		}
	});
	return false;
}


</script>
<script>
$(document).ready(function(){
	mark_read_in_admin('bank_transfer',"1=1");
});
</script>
<?php include_once('include/footer.php'); ?>