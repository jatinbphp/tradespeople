<?php
include_once 'include/header.php';
if (!in_array(13, $my_access)) {redirect('Admin_dashboard');}
?>
<style>
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
<div class="content-wrapper">
	<section class="content-header">
		<?php
			$userType = '';
			if(isset($_GET['user']) && !empty($_GET['user'])){
				$userType = $_GET['user'] == 1 ? 'Trades Man' : 'Home Owner';
			}
		?>
		<h1>Delete Account Of <?php echo $userType;?></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Delete Account</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>S.NO</th>
										<th>Name</th>
										<th>Email</th>
										<th>Delete Reason</th>
										<th>Request Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($deletedAccount as $key => $lists) {?>
									<tr role="row" class="odd" id="request_<?php echo $lists['id']; ?>">
										<td><?php echo $key + 1; ?></td>
										<td><?php echo $lists['name']; ?></td>
										<td><?php echo $lists['email']; ?></td>
										<td><?php echo $lists['delete_reason']; ?></td>
										<td>
											<select name="status" class="form-control deleteRequest" data-id="<?php echo $lists['id'] ?>">
												<option value="1" <?php echo $lists['delete_request'] == 1 ? 'selected' : ''; ?> >Requested</option>
												<option value="2" <?php echo $lists['delete_request'] == 2 ? 'selected' : ''; ?>>Approved</option>
												<option value="3" <?php echo $lists['delete_request'] == 3 ? 'selected' : ''; ?>>Rejected</option>
											</select>
										</td>
										<td><?php if($lists['delete_request'] != 3){?>
											<a href="javascript:void(0)" onclick="deleteRequest(<?php echo $lists['id'] ?>)"><i class="fa fa-trash"></i></a>
											<?php }?></td>
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
<?php include_once 'include/footer.php';?>

<script type="text/javascript">
	$('.deleteRequest').on('change', function(){
		var id = $(this).attr('data-id');
		var status = $(this).val();
		if(confirm('Are you sure you want to update status of delete request?')){
			$.ajax({
				type:'POST',
				url:site_url+'Admin/admin/update_status',
					data:{id:id, status:status},
				success:function(res){
					console.log(res);
					toastr.success('Delete request has been updated.');
				}
			});
		}
	})

	function deleteRequest(id) {
		if(confirm('Are you sure you want to remove this request?')){
			$.ajax({
				type:'POST',
				url:site_url+'Admin/admin/update_status',
				data:{id:id, status:0},
				success:function(res){
					toastr.success('Account successfully deleted');
					$("#request_"+id).remove();
				}
			});
		}
	}
</script>

