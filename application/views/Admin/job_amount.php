<?php 
include_once('include/header.php');
if(!in_array(4,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Addons</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Addons</li>
		</ol>
	  
  </section>
  <section class="content-header text-right">
		<button  data-toggle="modal" data-target="#add_adons" class="btn btn-success">Add</button>
  </section>
  <section class="content">   
    <div class="row">

      <div class="col-xs-12">
        <div class="box">
					<?php
					$first_checkbox = $this->Common_model->get_single_data('show_page',array('id'=>2));
					?>
          <div class="div-action text-right" style="padding-bottom:10px;padding-top:10px; margin-right: 25px;"> 
						<b>Show Budget:</b> 
						<label class="radio-inline"><input type="radio" onchange="change_budget_status(1);" <?php echo ($first_checkbox['status']==1) ? 'checked':''; ?> name="first_checkbox">Yes</label>
						<label class="radio-inline"><input type="radio" onchange="change_budget_status(0);" <?php echo ($first_checkbox['status']==0) ? 'checked':''; ?> name="first_checkbox">No</label>
						<div class="checkbox">
							
						</div>
					</div> 

          <div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										
										<th>S.No</th> 
										<th>Amount 1</th>
										<th>Amount 2</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($lists as $key => $row) {
									?>   
									<tr>
										<td><?php  echo $key+1; ?></td>
										<td><i class="fa fa-gbp"></i><?php echo $row['amount1']; ?></td>
										<td><i class="fa fa-gbp"></i><?php echo $row['amount2']; ?></td>
									
										<td>   
											<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_adons<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
											<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/post/delete_job_amount/'.$row['id']); ?>" onclick="return confirm('Are you sure! you want to delete this?');">Delete</a> 
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
  </section>
</div>
<?php 
foreach($lists as $key=>$row) {
?>

<div class="modal fade in" id="edit_adons<?php echo $row['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?php echo site_url().'Admin/post/edit_job_amount'; ?>">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit Amount</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="email">Amount 1:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" onchange="$('#amount2_<?php echo $row['id']; ?>').attr('min',this.value);" id="amount1_<?php echo $row['id']; ?>" min="1" step="1" name="amount1" value="<?php echo $row['amount1']; ?>" required class="form-control" >
								<input type="hidden" name="id" value="<?php echo $row['id']; ?>" required >
							</div>
						</div>	
						<div class="form-group">
							<label for="email">Amount 2:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" id="amount2_<?php echo $row['id']; ?>" min="<?php echo $row['amount1']; ?>" step="1" name="amount2" value="<?php echo $row['amount2']; ?>" required class="form-control" >
							</div>
						</div>
					</div>
						
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn<?= $row['id']; ?>" >Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div class="modal fade in" id="add_adons">
	<div class="modal-body" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?php echo site_url().'Admin/post/add_job_amount'; ?>">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Add Addon</h4>
					</div>
					<div class="modal-body">
						
						<div class="form-group">
							<label for="email">Amount1:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" onchange="$('#amount2_0').attr('min',this.value);" id="amount1_0" min="1" step="1" name="amount1" required class="form-control" >
							</div>
						</div>	
						<div class="form-group">
							<label for="email">Amount 2:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" id="amount2_0" min="1" step="1" name="amount2" required class="form-control" >
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn0" >Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
function change_budget_status(status){
		
	$.ajax({
		type:'POST',
		url:site_url + 'Admin/post/show_hide_budget_on_while_posting_job',
		data: {
			'status' : status
		},
		dataType: 'JSON',
		success:function(response){
			toastr.success(response.msg);
		}
	});
}
</script>
<?php include_once('include/footer.php'); ?>