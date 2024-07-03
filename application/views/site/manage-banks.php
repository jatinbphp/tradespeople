<?php include 'include/header.php'; ?>
<style type="text/css">
  table{
    width: 100%;
  }
</style>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="mjq-sh">
							<h2 class=""><strong>Edit payment details</strong></h2>
							<?php if(empty($banks)){ ?>
							<h2 class="text-right"><a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal" href="javascript:;">Add</a></h2>

							<?php } ?>
					</div>
					<div class="row">
						
						<div class="col-md-12 col-sm-12"> 
						
							<div class="dashboard-white"> 
								<div class="row dashboard-profile dhash-news">
									<div class="col-md-12">
									<?= $this->session->flashdata('message'); ?>
										<?php if($banks){ ?>
										<table class="Paging table table-bordered">
											<thead>
												<th>Sn.</th>
												<th>Account Holder</th>
												<th>Bank Name</th>
												<th>Account number</th>
												<th>Sort Code</th>
												<th>Paypal</th>
												<th>Account holder address</th>
												<th>Action</th>
											</thead>
											<tbody>
												<?php $sn=1; foreach ($banks as $key => $val) { ?>
												<tr>
													<td><?= $sn++; ?></td>
													<td><?= $val['wd_account_holder']; ?></td>
													<td><?= $val['wd_bank']; ?></td>
													<td><?= $val['wd_account']; ?></td>
													<td><?= $val['wd_ifsc_code']; ?></td>
													<td><?= $val['paypal_email_address']; ?></td>
													<td><?= $val['account_holder_address']; ?></td>
													<td>
														<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $val['id']; ?>" href="javascript:;">Edit</a>
														<!-- <a class="btn btn-danger btn-sm" href="<?= base_url('wallet/delete_bank/'.$val['id']); ?>" onclick="confirm('Are you sure want to delete this bank?')">Delete</a> -->
													</td>
												</tr>
<div id="myModal<?= $val['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Bank</h4>
      </div>
			<form method="post" id="edit_bank_transfer<?= $val['id']; ?>" enctype="multipart/form-data"  onsubmit="return edit_bank_transfer(<?= $val['id']; ?>);">
				<div class="modal-body">
					<div class="msg2-<?= $val['id']; ?>"></div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter account holder name</label>
								<input type="text" name="wd_account_holder" value="<?= $val['wd_account_holder']; ?>" class="form-control quantity" required>
								<input type="hidden" name="id" value="<?= $val['id']; ?>">
					
							</div>
						</div>
				
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter bank name </label>
								<input type="text" name="wd_bank" value="<?= $val['wd_bank']; ?>" class="form-control quantity" required>
							</div>
						</div>
						<div class="col-sm-12">
					 
							<div class="form-group text-left">
								<label>Enter account number</label>
								<input type="text" name="wd_account" value="<?= $val['wd_account']; ?>"  class="form-control quantity" required>
				
							</div>
						</div>
				

						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter Sort Code</label>
								<input type="text" value="<?= $val['wd_ifsc_code']; ?>" name="wd_ifsc_code"  class="form-control quantity" required>
				
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Account holder address</label>
								<input type="text" value="<?= $val['account_holder_address']; ?>" name="account_holder_address"  class="form-control quantity" required>
				
							</div>
						</div>
						<?php 
							if($this->session->userdata('type')==1){
								$setingsId= 3;
							}else{
								$setingsId= 2;
							}
							$settingss = $this->common_model->get_single_data("admin_settings", array("id"=>$setingsId)); if($settingss['payment_method']=='both'){ ?>
							<div class="col-sm-12">
								<div class="form-group text-left">
									<label>Paypal email address</label>
									<input type="text" value="<?= $val['paypal_email_address']; ?>" name="paypal_email_address"  class="form-control quantity">
					
								</div>
							</div>
						</div>
 
					<?php } ?>		
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success bank_transfer<?= $val['id']; ?>">Submit</button>
				</div>
			</form>
    </div>

  </div>
</div>

												<?php } ?>
											</tbody>
										</table>
										<?php }else{ ?>
										<div class="verify-page">
											<div  style="background-color:#fff;padding: 10px;" class="">
												<p>No records found.</p>
											</div>
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
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Bank</h4>
      </div>
			<form method="post" id="bank_transfer" enctype="multipart/form-data"  onsubmit="return bank_transfer();">
				<div class="modal-body">
					<div class="msg2"></div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter account holder name</label>
								<input type="text" name="wd_account_holder" value="" id="wd_account_holder" class="form-control quantity" required>
					
							</div>
						</div>
				
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter bank name </label>
								<input type="text" name="wd_bank" value="" id="wd_bank" class="form-control quantity" required>
							</div>
						</div>
						<div class="col-sm-12">
					 
							<div class="form-group text-left">
								<label>Enter account number</label>
								<input type="text" name="wd_account" value="" id="wd_account" class="form-control quantity" required>
				
							</div>
						</div>
				

						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Enter Sort Code</label>
								<input type="text" value="" name="wd_ifsc_code" id="wd_ifsc_code" class="form-control quantity" required>
				
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Account holder address</label>
								<input type="text" value="<?= $val['account_holder_address']; ?>" name="account_holder_address"  class="form-control quantity" required>
				
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group text-left">
								<label>Paypal email address</label>
								<input type="email" value="<?= $val['paypal_email_address']; ?>" name="paypal_email_address"  class="form-control quantity">
				
							</div>
						</div>
					</div>
 
									
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success bank_transfer">Submit</button>
				</div>
			</form>
    </div>

  </div>
</div>

<?php include 'include/footer.php'; ?>
<script>
  $(function () {
$('.Paging').DataTable({
 // "searching": false,
 // "lengthChange": false,
 "ordering": false,
 // "pageLength": 15,
 // "info": false,
fnDrawCallback: function() {
// $(".Paging thead").remove();
}
});
});
function bank_transfer(){
  $.ajax({
    type:'POST',
    url:site_url+'wallet/add_bank',
    data:$('#bank_transfer').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.bank_transfer').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.bank_transfer').prop('disabled',true);
      $('.msg2').html('');
    },
    success:function(resp){
      if(resp.status==1){
       location.reload();
      } else {
        $("#bank_account").show();
        $('.msg2').html(resp.msg);
        $('.bank_transfer').html('Submit');
        $('.bank_transfer').prop('disabled',false);
      }
    }
  });
  return false;
}

function edit_bank_transfer(id){
  $.ajax({
    type:'POST',
    // url:site_url+'wallet/edit_bank',
    url:site_url+'wallet/add_bank',
    data:$('#edit_bank_transfer'+id).serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.bank_transfer'+id).html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.bank_transfer'+id).prop('disabled',true);
      $('.msg2-'+id).html('');
    },
    success:function(resp){
      if(resp.status==1){
       location.reload();
      } else {
        $('.msg2-'+id).html(resp.msg);
        $('.bank_transfer').html('Submit');
        $('.bank_transfer').prop('disabled',false);
      }
    }
  });
  return false;
}

</script>
	