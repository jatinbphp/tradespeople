<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
.table-responsive {
	overflow: auto;
}
@media (max-width:575.98px){
	.table-responsive-sm{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-sm>.table-bordered{
		border:0
	}
}
@media (max-width:767.98px){
	.table-responsive-md{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-md>.table-bordered{
		border:0
	}
}
@media (max-width:991.98px){
	.table-responsive-lg{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-lg>.table-bordered{
		border:0
	}
}
@media (max-width:1199.98px){
	.table-responsive-xl{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-xl>.table-bordered{
		border:0
	}
}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>         
				</div>
				<div class="col-sm-9">
					<?php echo $this->session->flashdata('success1');  ?>
					<div class="user-right-side">
						<h1>Invoices</h1>
						<div class="setbox2">
							<div class="table-responsive">
								<table id="boottable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th style="display: none;"></th>
											<th>Project Id</th> 
											<th>Project Name</th>
											<th style="width: 120px;">Milestone Name</th>
											<th>Amount</th>
											<th>
												<?php echo ($this->session->userdata('type')==1) ? 'Paid By' : 'Paid To' ?>
											</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($invoices as $key=>$list) { ?>
										<tr>
											<td style="display: none;"><?php  echo $key+1; ?></td>
											<td><?php echo $list['project_id']; ?></td>
											<td><a href="<?php echo base_url('details/?post_id='.$list['post_id']); ?>"><?php echo $list['job_title']; ?></a></td>
											<td><?php echo $list['milestone_name']; ?></td>
											<td>
									 
												<?php
												if($this->session->userdata('type')==1){ 
													$admin_commission = ($list['milestone_amount']*$list['admin_commission'])/100;
													$total = $list['milestone_amount'] - $admin_commission;
												} else {
													$total = $list['milestone_amount'];
												}
			
												?>
									 
												<i class="fa fa-gbp"></i><?php echo $total; ?>
											</td>
											<td>
												<?php 
												if($this->session->userdata('type')==1){
													$get_users=$this->common_model->get_single_data('users',array('id'=>$list['puserid']));
													echo $get_users['f_name'].' '.$get_users['l_name'];
												}else{
													$get_users=$this->common_model->get_single_data('users',array('id'=>$list['userid']));
													echo $get_users['f_name'].' '.$get_users['l_name'];
												}
												?>
											</td>
											<td>
												<a href="<?php echo base_url(); ?>mile-invoice/<?php echo $list['id']; ?>" class="btn btn-primary btn-sm">View Invoice</a>
											</td>
										</tr> 
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script> 
 
  $(function(){
    $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
  </script>
<script>




 
</script>

<?php include 'include/footer.php'; ?>
  