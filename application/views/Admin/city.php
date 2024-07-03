<?php 
include_once('include/header.php');
if(!in_array(6,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>City Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">City Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_county" class="btn btn-success">Add City</a> 
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
										<th>City</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($listing as $key=>$list) { ?>
									<tr>
										<td><?php  echo $key+1; ?></td>
									
										<td><?php echo $list['city_name'];?></td>
										<td>   
											<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_open<?php echo $list['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
											<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Region/delete_city/'.$list['id']); ?>" onclick="return confirm('Are you sure! you want to delete this City?');">Delete</a>  
											<a class="btn btn-primary btn-xs" href="<?php echo site_url('local-category/?location='.$list['id']); ?>">Local Category</a>
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

<?php foreach($listing as $key=>$list) { ?>

<div class="modal fade in" id="edit_open<?php echo $list['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">

				<form onsubmit="return edit_city(<?= $list['id']; ?>);" id="edit_city<?= $list['id']; ?>" method="post"  enctype="multipart/form-data">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit</h4>
					</div>
					
					<div class="modal-body">	
						<div class="editmsg<?= $list['id']; ?>" id="editmsg<?= $list['id']; ?>"></div>
						
						<div class="form-group">
							<label for="email"> Name:</label>
							<input type="text" name="city_name" id="cat_name1"  value="<?php echo $list['city_name']; ?>" class="form-control" >
							<input type="hidden" name="city_id" id="cat_name1"  value="<?php echo $list['id']; ?>" required class="form-control">
						</div>
						<div class="form-group">
							<label for="meta_title">Title (For find tradesmen page):</label>
							<input type="text" value="<?php echo $list['meta_title']; ?>" name="meta_title" id="meta_title" class="form-control">
						</div>
						<div class="form-group hide">
							<label for="meta_key">Meta Keywords (For find tradesmen page):</label>
							<input type="text" value="<?php echo $list['meta_key']; ?>" name="meta_key" id="meta_key" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description">Descritption (For find tradesmen page):</label>
							<textarea rows="12"  name="meta_description" id="meta_description" class="form-control"><?php echo $list['meta_description']; ?></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title3">Meta Title (For find tradesmen page):</label>
							<input type="text"  value="<?php echo $list['meta_title3']; ?>" name="meta_title3" id="meta_title3" class="form-control">
						</div>
						<div class="form-group">
							<label for="meta_key3">Meta Keywords (For find tradesmen page):</label>
							<input type="text" value="<?php echo $list['meta_key3']; ?>" name="meta_key3" id="meta_key3" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description3">Meta Descritption (For find tradesmen page):</label> 
							<textarea rows="12"  name="meta_description3" id="meta_description3" class="form-control"><?php echo $list['meta_description3']; ?></textarea>
						</div>

						<div class="form-group">
							<label for="tradesmen_footer_description">Footer Descritption (For find tradesmen page):</label>
							<textarea rows="12"  name="tradesmen_footer_description" id="tradesmen_footer_description" class="form-control textarea"><?php echo $list['tradesmen_footer_description']; ?></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title2">Title (For find job page):</label>
							<input type="text"  value="<?php echo $list['meta_title2']; ?>" name="meta_title2" id="meta_title2" class="form-control">
						</div>
						<div class="form-group hide">
							<label for="meta_key2">Meta Keywords (For find job page):</label>
							<input type="text" value="<?php echo $list['meta_key2']; ?>" name="meta_key2" id="meta_key2" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description2">Descritption (For find job page):</label>
							<textarea rows="12"  name="meta_description2" id="meta_description2" class="form-control"><?php echo $list['meta_description2']; ?></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title4">Meta Title (For find job page):</label>
							<input type="text"  value="<?php echo $list['meta_title4']; ?>" name="meta_title4" id="meta_title4" class="form-control">
						</div>
						<div class="form-group">
							<label for="meta_key4">Meta Keywords (For find job page):</label>
							<input type="text" value="<?php echo $list['meta_key4']; ?>" name="meta_key4" id="meta_key4" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description4">Meta Descritption (For find job page):</label>
							<textarea rows="12"  name="meta_description4" id="meta_description4" class="form-control"><?php echo $list['meta_description4']; ?></textarea>
						</div>

						

						<div class="form-group">
							<label for="jobpage_footer_description">Footer Descritption (For find job page):</label>
							<textarea rows="12" name="jobpage_footer_description" id="jobpage_footer_description" class="form-control textarea"><?php echo $list['jobpage_footer_description']; ?></textarea>
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn<?= $list['id']; ?>" >Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

<?php } ?>
<div class="modal fade in" id="add_county">
	<div class="modal-body" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" id="add_county1" enctype="multipart/form-data">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Add County</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
					
						<div class="form-group">
							<label for="email"> Name:</label>
							<input type="text" required name="city_name" id="region_name" class="form-control" >
						</div>
						
						<div class="form-group">
							<label for="meta_title">Title (For find tradesmen page):</label>
							<input type="text"  name="meta_title" id="meta_title" class="form-control">
						</div>
						<div class="form-group hide">
							<label for="meta_key">Meta Keywords (For find tradesmen page):</label>
							<input type="text" name="meta_key" id="meta_key" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description">Descritption (For find tradesmen page):</label>
							<textarea rows="12"  name="meta_description" id="meta_description" class="form-control"></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title3">Meta Title (For find tradesmen page):</label>
							<input type="text"  value="" name="meta_title3" id="meta_title3" class="form-control">
						</div>
						<div class="form-group">
							<label for="meta_key3">Meta Keywords (For find tradesmen page):</label>
							<input type="text" value="" name="meta_key3" id="meta_key3" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description3">Meta Descritption (For find tradesmen page):</label>
							<textarea rows="12"  name="meta_description3" id="meta_description3" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="tradesmen_footer_description">Footer Descritption (For find tradesmen page):</label>
							<textarea rows="12"  name="tradesmen_footer_description" id="tradesmen_footer_description" class="form-control textarea"></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title2">Title (For find job page):</label>
							<input type="text"  name="meta_title2" id="meta_title2" class="form-control">
						</div>
						<div class="form-group hide">
							<label for="meta_key2">Meta Keywords (For find job page):</label>
							<input type="text" name="meta_key2" id="meta_key2" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description2">Descritption (For find job page):</label>
							<textarea rows="12"  name="meta_description2" id="meta_description2" class="form-control"></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title4">Meta Title (For find job page):</label>
							<input type="text"  value="" name="meta_title4" id="meta_title4" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_key4">Meta Keywords (For find job page):</label>
							<input type="text" value="" name="meta_key4" id="meta_key4" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="meta_description4">Meta Descritption (For find job page):</label>
							<textarea rows="12"  name="meta_description4" id="meta_description4" class="form-control"></textarea>
						</div>

						

						<div class="form-group">
							<label for="jobpage_footer_description">Footer Descritption (For find job page):</label>
							<textarea rows="12"  name="jobpage_footer_description" id="jobpage_footer_description" class="form-control textarea"></textarea>
						</div>


					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info signup_btn" >Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		
		</div>
	</div>
</div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_county1").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Region/add_city',
		 data: new FormData(this),
		dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
		beforeSend:function(){       
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.signup_btn').prop('disabled',true);
			$('.msg').html('');
		},
		success:function(resp){
			if(resp.status==1){
				//window.location.href = site_url+'category';
				location.reload();
			} else {
				$('.msg').html(resp.msg);
				$('.signup_btn').html('Save');
				$('.signup_btn').prop('disabled',false);
			}
		}
	});
	return false;
});
     
function edit_city(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Region/add_city/',
		data: new FormData($('#edit_city'+id)[0]),
		dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
		beforeSend:function(){
			$('.edit_btn'+id).prop('disabled',true);
			$('.edit_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
			$('.editmsg'+id).html('');
		},
		success:function(resp){
			if(resp.status==1){
				location.reload();
			} else {
				$('.edit_btn'+id).prop('disabled',false);
				$('.edit_btn'+id).html('Save');
				$('.editmsg'+id).html(resp.msg);
			}
		}
	});
	return false;
}
</script>
<?php include_once('include/footer.php'); ?>