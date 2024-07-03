<?php 
include ("include/header.php");
include ("include/top.php");

$user_id2 = $this->session->userdata('user_id');
if(!$post_id || $get_job_detail==false || ($user_id2 != $get_job_detail['userid'] && $user_id2 != $get_job_detail['awarded_to'])){
	redirect('dashboard');
}
?>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<?php if($this->session->flashdata('error2')) { ?>
        <p class="alert alert-danger"><?php echo $this->session->flashdata('error2'); ?></p>
        <?php } ?>
				
				<?php if($this->session->flashdata('success2')) { ?>
        <p class="alert alert-success"><?php echo $this->session->flashdata('success2'); ?></p>
        <?php } ?>
				
				<div class="dashboard-white">
					<div class="dashboard-profile dhash-news Upload_ss">
						<h3>
							<span>Files</span>  
							<button class="btn btn-primary pull-right" href="" data-target="#edit_profile" data-toggle="modal">Upload File</button>
						</h3>
					</div>
					<div class="modal fade popup" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Upload File</h4>
								</div>
								<form method="POST" id="imageEdit" action="<?php echo base_url('posts/upload_file/'.$_REQUEST['post_id']); ?>" enctype="multipart/form-data" onsubmit="return update_profile1();">
									<div class="modal-body">
										<fieldset>
            
											<!-- Text input-->
											<div class="form-group">
												<label class="col-md-12 control-label" for="textinput">Image</label>  
												<div class="col-md-12">
													<input type="file" name="post_doc[]" id="post_doc" class=" upload_size" multiple>
										
													
												</div>
											</div>
											<div class="col-md-12">
												<div class="perview_pro_img"></div>
											</div>
										</fieldset>
   
									</div>
 
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-warning submit_btn7">Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="dhash-news-main">
						<?php if($attachment){ ?>
						<div class="table-responsive">
		
							<table class="table">
								<thead>
									<tr>
										<th>Name</th>
										<th style="display: none;">Size</th>
										<th>Owner</th>
										<th>Modified</th>
									</tr>
								</thead>
								<tbody>
								
									<?php foreach($attachment as $a){ ?> 
									<tr>
										<td><i class="fa fa-file"></i>&nbsp; <?php echo $a['post_doc']; ?></td>
										<td style="display: none;">511 bytes</td>
										<td>
											<?php if($this->session->userdata('user_id')==$a['userid']){ ?>
												Me
											<?php }else{ 
											
											$get_users=$this->common_model->get_single_data('users',array('id'=>$a['userid'])); 
											if($get_users['type']==1){
											echo $get_users['trading_name']; 
											} else {
											echo $get_users['f_name'].' '.$get_users['l_name']; 
											}
											} ?>
										</td>
										<td>25 days ago</td>
										<td><a href="<?php echo base_url('img/jobs/'.$a['post_doc']); ?>" download><button class="btn btn-primary">Download</button></a></td>
									</tr>
									<?php } ?>
			
								</tbody>
							</table>
						</div>
						<?php }else{ ?>
						<p style="text-align: center;"><b>No files uploaded.</b></p>
						<?php } ?>
					</div>
				</div>
				
			</div>
			<div class="col-sm-4 hide" >
				
				<div class="dashboard-white edit-pro89"> 
					<div class=" dashboard-profile Locations_list11">
						<h2>Empolyer Verification</h2>
						<p><i class="fa fa-file"></i>All Files (<?php echo count($attachment); ?>)</p>
						<p><i class="fa fa-file-text"></i>Documents(<?php  echo $doc[0]['doc'];  ?>)</p>
						<p><i class="fa fa-file-image-o"></i>Image(<?php  echo $image[0]['image'];  ?>)</p>
						<p><i class="fa fa-film"></i>Video(<?php echo $video[0]['video']; ?>)</p>
					</div>
        </div>

			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>


<!-- Certifications -->
<div class="modal fade popup" id="Upload_ff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
      </div>
      <form >
				<div class="modal-body">
					
					<div class="form-group">
						<label>Size Bytes</label>
						<input type="text" name="" placeholder="" class="form-control">
					</div>

					<div class="form-group">
						<label>Owner</label>
						<input type="text" name="" placeholder="" class="form-control">
					</div>
					<div class="form-group">
						<label>Modified</label>
						<input type="date" name="" placeholder="" class="form-control">
					</div>
					<div class="form-group">
						<label>File</label>
						<input type="file" name="" placeholder="" class="form-control">
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-warning">Save</button>
				</div>
			</form>
    </div>
  </div>
</div>
