<?php include 'include/header.php'; ?>

<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
#vote_buttons :hover {
	cursor:pointer;
}
</style><br>
				<br>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<!-- sidebar here -->
				<?php include 'include/sidebar.php'; ?>
				<!-- sidebar here -->
			</div>
			<div class="col-md-9">
				<div class="mjq-sh"> 
					<h2>
						<strong>Extra Job Credits</strong>
					</h2>
				</div>
	
				<?php
				
				if(!empty($credit_addon)) { ?> 
				<div class="table-responsive">
					<table class="table  " >
						<thead>
							<tr class="th_class">
								<th style="display: none;"></th>
								<th>SUBSCRIPTION</th>
								<th>COST</th>
								<th>Action</th>       
							</tr>
						</thead>
						<tbody>
							<?php foreach($credit_addon as $key => $row){ ?>
							<tr class="tr_class">
								<td style="display: none;"><?php echo $key; ?></td>
								<td><?php echo strip_tags($row['description']); ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row['amount']; ?></td>
								<td><a href="<?php echo site_url().'make-addon-payment/'.$row['id']; ?>" class="text-danger">Add</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php } else { ?>
				<div class="verify-page">
					<div style="background-color:#fff;padding: 10px;" class="">
						<p>We did not find any addons.</p>
					</div>
				</div>
				<br>
				<br>
				<script>
					$('.trade-recent-job-tbl').remove();
				</script>
				<?php } ?>
				<div class="mjq-sh"> 
					<h2>
						<strong>Extra SMS Credits</strong>
					</h2>
				</div>
	
				<?php
				
				if(!empty($sms_addon)) { ?> 
				<div class="table-responsive">
					<table class="table  " >
						<thead>
							<tr class="th_class">
								<th style="display: none;"></th>
								<th>SUBSCRIPTION</th>
								<th>COST</th>
								<th>Action</th>       
							</tr>
						</thead>
						<tbody>
							<?php foreach($sms_addon as $key1 => $row){ ?>
							<tr class="tr_class">
								<td style="display: none;"><?php echo $key; ?></td>
								<td><?php echo strip_tags($row['description']); ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row['amount']; ?></td>
								<td><a href="<?php echo site_url().'make-addon-payment/'.$row['id']; ?>" class="text-danger">Add</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php } else { ?>
				<div class="verify-page">
					<div style="background-color:#fff;padding: 10px;" class="">
						<p>We did not find any addons.</p>
					</div>
				</div>
				<br>
				<br>
				<script>
					$('.trade-recent-job-tbl').remove();
				</script>
				<?php } ?>
				
			</div>
		</div>

	</div>
</div>



<?php include 'include/footer.php'; ?>
<script type="text/javascript">
$(function(){
	$(".DataTable").DataTable({
		stateSave: true,
		lengthChange: false,
		searching: false,
			"pageLength": 5
	});
	$('.dataTables_filter').addClass('pull-left');
});
</script>