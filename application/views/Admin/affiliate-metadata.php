<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Affiliate Metadata Management</h1>
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
 
					<form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/slug/update_affiliate_metadata_content/'); ?>" enctype="multipart/form-data">
						<div class="box-body">
						
							<!-- <div class="box-header with-border">
								<h3 class="box-title">Affiliate Login Page</h3>
							</div>
							
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_title" id="meta_title"  value="<?php echo $affilate_login_metadata['meta_title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_description" id="meta_description"  value="<?php echo $affilate_login_metadata['meta_description']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Keywords</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_key" id="meta_key"  value="<?php echo $affilate_login_metadata['meta_key']; ?>">
								</div>
							</div>
						</div>     
						
						<div class="box-header with-border">
							<h3 class="box-title">Affiliate Signup Page</h3>
						</div>
						
						
						<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_title2" id="meta_title"  value="<?php echo $affilate_signup_metadata['meta_title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_description2" id="meta_description"  value="<?php echo $affilate_signup_metadata['meta_description']; ?>">
								</div>
							</div>
						<div class="form-group">  
							<label for="Username" class="col-sm-2 control-label">Meta Keywords</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="meta_key2" id="meta_key2"  value="<?php echo $affilate_signup_metadata['meta_key']; ?>">
							</div>
						</div> -->


						<div class="box-header with-border">
							<h3 class="box-title">Affiliate Pages</h3>
						</div>
						
						<div class="form-group">  
							<label for="Username" class="col-sm-2 control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title3" id="title3"  value="<?php echo $affilate_page_metadata['title']; ?>">
							</div>
						</div>
						<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_title3" id="meta_title3"  value="<?php echo $affilate_page_metadata['meta_title']; ?>">
								</div>
							</div>
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Meta Description</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="meta_description3" id="meta_description3"  value="<?php echo $affilate_page_metadata['meta_description']; ?>">
								</div>
							</div>
						<div class="form-group">  
							<label for="Username" class="col-sm-2 control-label">Meta Keywords</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="meta_key3" id="meta_key3"  value="<?php echo $affilate_page_metadata['meta_key']; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea name="description3"  class="form-control" rows="12" style="height: 120px;"><?php echo $affilate_page_metadata['description']; ?></textarea>
							</div>
						</div>

						<?php if(!empty($affilate_page_metadata['image'])) : ?>
						<div class="form-group">
							<label for="image" class="col-sm-2 control-label">
								
							</label>
							<div class="col-sm-10">
								<img src="<?=base_url()."/img/common/".$affilate_page_metadata['image']?>" width="350px">
							</div>
							
						</div>
						<?php endif ?>
						<div class="form-group">
							<label for="image" class="col-sm-2 control-label">Image</label>
							<div class="col-sm-10">
								<input type="file" name="image" id="image" class="form-control" accept="image/*">
							</div>
						</div>

						<!-- <div class="form-group">
							<label for="email" class="col-sm-2 control-label">Footer Description</label>
							<div class="col-sm-10">
								<textarea name="footer_description3" class="form-control textarea" rows="12" style="height: 120px;"><?php echo $affilate_page_metadata['footer_description']; ?></textarea>
							</div>
						</div> -->

						       
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
						</div>
					</form>
        </div>
      </div>
    </section>
</div>
  <?php include_once('include/footer.php'); ?>