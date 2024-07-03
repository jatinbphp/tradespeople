<?php
include_once('include/header.php');
if(!in_array(12,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Common Settings</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Common Settings</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<form action="<?php echo site_url('Admin/Admin/update_common_settings'); ?>" method="post">
							<div class="col-sm-12">
								<?php
								if($this->session->flashdata('msg')){
									echo $this->session->flashdata('msg');
								}
								?>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="waiting_time_offer">Search API Key: <span data-toggle="tooltip" title="This API key used for search location"><i class="fa fa-info"></i></span></label>
									<input type="text" class="form-control" id="search_api_key" name="search_api_key" value="<?php echo $settings['search_api_key']; ?>">
								</div>
							</div>

							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary pull-right">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php include_once('include/footer.php'); ?>


