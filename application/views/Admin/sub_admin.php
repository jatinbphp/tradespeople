<?php 
include_once('include/header.php');
if(!in_array(15,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
.chosen-container.chosen-container-multi {
	width: 100% !important;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Sub Admin Management</h1>
		<ol class="breadcrumb">
			<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Sub Admin Management</li>
		</ol>
  </section>
	<section class="content-header text-right">
	  <button  data-toggle="modal" data-target="#add_suadmin_modal" class="btn btn-success">Add Sub Admin</button> 
  </section>

  <section class="content">   
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
						<?php if($this->session->flashdata('error')) { ?>
						<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
						<?php } ?>
						<?php if($this->session->flashdata('success')) { ?>
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php } ?>
						<div class="table-responsive">
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
									<th>S.No</th> 
									<th>Name</th>
									<th>Email</th>
									<th>Password</th>
									<th>Roles</th>
									<th>Action</th>
								</tr>
							
              </thead>
							<tbody>
								<?php
								$i = 1;
								foreach($sub_admin as $row){ ?>
								<tr>
									<td><?php echo $i++; ?></td> 
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['password']; ?></td>
									<td>
									<?php 
									$where = " id in (".$row['roles'].")";
									$single_role = $this->Common_model->get_all_data('roles',$where,'id','asc');
									
									if(count($single_role)){
										foreach($single_role as $row2){
											echo '<span class="roles label label-default">'.$row2['role_name'].'</span> ';
										}
									}
									
									?>
									
									</td>
									<td>
										<button  data-toggle="modal" data-target="#edit_suadmin_modal<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Edit</button> 
										<a onclick="return confirm('Are you sure you want to delete this sub admin?');" href="<?php echo site_url().'Admin/sub_admin/delete_subadmin/'.$row['id']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
										</td>
								</tr>
								<?php } ?>
							</tbody>
              <tbody>
								
								
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
$i = 1;
foreach($sub_admin as $row){ ?>
<div class="modal fade in" id="edit_suadmin_modal<?php echo $row['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">
         	
				<form method="post" id="edit_suadmin<?php echo $row['id']; ?>" onsubmit="return edit_suadmin(<?php echo $row['id']; ?>);">
					<div class="modal-header">
						
						<h4 class="modal-title">Edit Sub Admin</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="msg<?php echo $row['id']; ?>"></div>
						<div class="form-group">
							<label> Name:</label>
							<input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Name" class="form-control" required>
						</div>
						<div class="form-group">
							<label> Email:</label>
							<input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Email" required>
						</div>
						<div class="form-group">
							<label > Password:</label>
							<input type="password" value="<?php echo $row['password']; ?>" name="password" placeholder="Password" class="form-control" required>
						</div>
						<div class="form-group">
							<label> Confirm Password:</label>
							<input type="password" name="confirm_password" class="form-control"  placeholder="Confirm Password" value="<?php echo $row['password']; ?>" required>
							
							<input type="hidden" name="id" value="<?php echo $row['id']; ?>"  required>
							
						</div>
						<div class="form-group">
							<label> Roles:</label>
							<select name="roles[]" multiple="multiple" id="roles<?php echo $row['id']; ?>" class="form-control chosen">
								<?php 
								$last_array = explode(',',$row['roles']);
								foreach($roles as $row12){
									
									$selected = in_array($row12['id'],$last_array)?'selected':'';
									
									echo '<option '.$selected.' value="'.$row12['id'].'">'.$row12['role_name'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn<?php echo $row['id']; ?>" >Update</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

<?php } ?>
<div class="modal fade in" id="add_suadmin_modal">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">
         	
				<form method="post" id="add_suadmin" onsubmit="return add_suadmin();">
					<div class="modal-header">
						
						<h4 class="modal-title">Add Sub Admin</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="msg"></div>
						<div class="form-group">
							<label for="username"> Name:</label>
							<input type="text"  placeholder="Name" name="username" id="username" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="email"> Email:</label>
							<input type="email" placeholder="Email" name="email" id="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password"> Password:</label>
							<input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="confirm_password"> Confirm Password:</label>
							<input type="password" placeholder="Confirm Password" name="confirm_password" id="confirm_password" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="roles"> Roles:</label>
							<select name="roles[]" multiple="multiple" id="roles" class="form-control chosen">
								<?php 
								foreach($roles as $row){
									echo '<option value="'.$row['id'].'">'.$row['role_name'].'</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info add_btn" >Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

<?php include_once('include/footer.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>     

<script>
$(function(){
	$(".chosen").chosen();
})
function edit_suadmin(id){
	var roles = $('#roles'+id).val();
	if(roles.length>0){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/sub_admin/edit_suadmin',
			data:$('#edit_suadmin'+id).serialize(),
			dataType:'JSON',
			beforeSend:function(){
				$('.msg'+id).html('');
				$('.edit_btn'+id).html('Processing...');
				$('.edit_btn'+id).prop('disabled',true);
			},
			success:function(resp){
				if(resp.status==1){
					location.reload();
				} else {
					$('.msg'+id).html(resp.msg);
					$('.edit_btn'+id).html('Add');
					$('.edit_btn'+id).prop('disabled',false);
				}
			}
		});
	} else {
		$('.msg'+id).html('<div class="alert alert-danger">Select Role for sub admin</div>');
	}
	return false;
}

function add_suadmin(){
	var roles = $('#roles').val();
	if(roles.length>0){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/sub_admin/add_suadmin',
			data:$('#add_suadmin').serialize(),
			dataType:'JSON',
			beforeSend:function(){
				$('.msg').html('');
				$('.add_btn').html('Processing...');
				$('.add_btn').prop('disabled',true);
			},
			success:function(resp){
				if(resp.status==1){
					location.reload();
				} else {
					$('.msg').html(resp.msg);
					$('.add_btn').html('Add');
					$('.add_btn').prop('disabled',false);
				}
			}
		});
	} else {
		$('.msg').html('<div class="alert alert-danger">Select Role for sub admin</div>');
	}
	return false;
}
</script>
   

