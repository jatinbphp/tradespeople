<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Default Content Management</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category Default Content</li>
      </ol>
  </section>

  <section class="content">   
    <div class="row">
			<div class="col-md-12">
        <div class="box">
					<div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
						<p id="msg"></p>
					</div> 
            <!-- /.box-header -->
            <!-- form start -->
 
					<form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/slug/update_category_default_content/'); ?>" enctype="multipart/form-data">
						<div class="box-body">
						
							<div class="box-header with-border">
								<h3 class="box-title">For Find Tradesmen Page</h3>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" id="title" required value="<?php echo $find_trades['title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_title" id="meta_title" required value="<?php echo $find_trades['meta_title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_description" id="meta_description" required value="<?php echo $find_trades['meta_description']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_key" id="meta_key" required value="<?php echo $find_trades['meta_key']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10">
									<textarea name="description" required class="form-control" rows="12" style="height: 120px;"><?php echo $find_trades['description']; ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Footer Description</label>
								<div class="col-sm-10">
									<textarea name="footer_description" class="form-control textarea" rows="12" style="height: 120px;"><?php echo $find_trades['footer_description']; ?></textarea>
								</div>
							</div>

						</div>     
						
						<div class="box-header with-border">
							<h3 class="box-title">For Find Job Page</h3>
						</div>
						
						<div class="form-group">  
							<label for="Username" class="col-sm-2 control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title2" id="title2" required value="<?php echo $find_job['title']; ?>">
							</div>
						</div>
						<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_title2" id="meta_title" required value="<?php echo $find_job['meta_title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_description2" id="meta_description" required value="<?php echo $find_job['meta_description']; ?>">
								</div>
							</div>
						<div class="form-group">  
							<label for="Username" class="col-sm-2 control-label">Meta Keywords</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="meta_key2" id="meta_key2" required value="<?php echo $find_job['meta_key']; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea name="description2" required class="form-control" rows="12" style="height: 120px;"><?php echo $find_job['description']; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Footer Description</label>
							<div class="col-sm-10">
								<textarea name="footer_description2" class="form-control textarea" rows="12" style="height: 120px;"><?php echo $find_job['footer_description']; ?></textarea>
							</div>
						</div>
						       
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
						</div>
					</form>
        </div>
      </div>
    </section>
</div>
  <?php include_once('include/footer.php'); ?>