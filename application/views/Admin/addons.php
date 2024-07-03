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

          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          	    	  
          </div> 
          <div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										
										<th>S.No</th> 
										<th>Type</th>
										<th>Amount</th>
										<th>Quantity</th>
										<th>Description</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($addons as $key => $row) {
									?>   
									<tr>
										<td><?php  echo $key+1; ?></td>
										<td><?php echo ($row['type']==1) ? 'Credit' : 'SMS'; ?></td>
										<td><i class="fa fa-gbp"></i><?php echo $row['amount']; ?></td>
										<td><?php echo $row['quantity']; ?></td>
										<td><?php echo $row['description']; ?></td>
									
										<td>   
											<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_adons<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
											<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/addon/delete_addon/'.$row['id']); ?>" onclick="return confirm('Are you sure! you want to delete this addon?');">Delete</a> 
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
foreach($addons as $key=>$row) {
?>

<div class="modal fade in" id="edit_adons<?php echo $row['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="<?php echo site_url().'Admin/addon/edit_addon'; ?>">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit Addon</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="email"> Select type:</label>
							<select type="text" name="type"  class="form-control" required>
								<option value="">select</option>
								<option <?php echo ($row['type']==1)?'selected':'';?> value="1">Credit</option>
								<option <?php echo ($row['type']==2)?'selected':'';?> value="2">SMS</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Amount:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" value="<?php echo $row['amount']; ?>" min="0.01" step="0.01" name="amount" required class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label for="email">Quantity:</label>
							<input type="number" min="1" value="<?php echo $row['quantity']; ?>" step="1" name="quantity" required class="form-control">
							<input type="hidden" value="<?php echo $row['id']; ?>" name="id" required>
						</div>
						<div class="form-group">
							<label for="email"> Description:</label>
							<textarea rows="5" required placeholder="" name="description" class="form-control"><?php echo $row['description']; ?></textarea>
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
				<form method="post" action="<?php echo site_url().'Admin/addon/add_addon'; ?>">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Add Addon</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="email"> Select type:</label>
							<select type="text" name="type"  class="form-control" required>
								<option value="">select</option>
								<option value="1">Credit</option>
								<option value="2">SMS</option>
							</select>
						</div>
						<div class="form-group">
							<label for="email">Amount:</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
								<input type="number" min="0.01" step="0.01" name="amount" required class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label for="email">Quantity:</label>
							<input type="number" min="1" step="1" name="quantity" required class="form-control">
						</div>
						<div class="form-group">
							<label for="email"> Description:</label>
							<textarea rows="5" required placeholder="" name="description" class="form-control"></textarea>
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn<?= $list['cat_id']; ?>" >Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include_once('include/footer.php'); ?>