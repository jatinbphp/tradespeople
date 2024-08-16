<?php 
include_once('include/header.php');
if(!in_array(22,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Location Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Location Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_country" class="btn btn-success">Add Location</a> 
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
										<th>Location</th>
										<th>Area</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($listing as $key=>$list) { ?>
									<tr>
										<td><?php echo $key+1; ?></td>									
										<td><?php echo $list['city_name'];?></td>
										<td>
											<?php
												if(!empty($list['area'])){
													$area = explode(',', $list['area']);
													if(!empty($area)){
														foreach($area as $aName){
															echo '<label class="badge bg-aqua-active margin-r-5">'.$aName.'</label>';
														}
													}													
												}
											?>
										</td>
										<td>   
											<a href="javascript:void(0);" onclick="openModal(<?php echo $list['id']; ?>)" class="btn btn-success btn-xs">Edit</a>

											<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Admin/delete_location/'.$list['id']); ?>" onclick="return confirm('Are you sure! you want to delete this Location?');">Delete</a>  
											<a class="btn btn-primary btn-xs" href="<?php echo site_url('location-local-category/?location='.$list['id']); ?>">Local Category</a>
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

<div class="modal fade in" id="add_country">
	<div class="modal-body" >
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" id="add_country1" enctype="multipart/form-data">
					<input type="hidden" name="location_id" id="location_id" value="" class="form-control">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title" id="modalTitle">Add Location</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
					
						<div class="form-group">
							<label for="region_name"> Name:</label>
							<select name="city_name" id="city_id" class="form-control" required>
								<option value="">Please Select</option>	
								<?php if(!empty($main_location)):?>
									<?php foreach($main_location as $ml):?>
										<option value="<?php echo $ml['id']; ?>"><?php echo $ml['city_name']; ?></option>
									<?php endforeach;?>	
								<?php endif;?>	
							</select>
							<!-- <input type="text" required name="city_name" id="region_name" class="form-control">-->
						</div>

						<div class="form-group">
              <label for="area">Area</label>
              <input id="area" value="" name="area" placeholder="Area" class="form-control area input-md" data-role="tagsinput" type="text" value="">              
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
						<button type="submit" class="btn btn-info signup_btn">Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>		
		</div>
	</div>
</div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_country1").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/add_location',
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

function openModal(lId){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/get_location_data',
		data: {lid:lId},
		dataType: 'JSON',
    success:function(resp){
    	$('#modalTitle').text('Update Location');
    	var location = resp.location;
  	 	for (var key in location) {
  	 		if (location.hasOwnProperty(key)) {
  	 			$('#location_id').val(location['id']);
  	 			var $field = $('#' + key);
  	 			if (key === 'area'){
  	 				$field.tagsinput('removeAll');
 						if (location[key] !== null && location[key] !== undefined && location[key] !== "") {
              var tags = location[key].split(',');

              tags.forEach(function(tag) {
                  $field.tagsinput('add', tag.trim());
              });
            }            
  	 			}else {
            $field.val(location[key]);
          }
        }
      }
      $('#add_country').modal('show');
		}
	});
}

</script>
<?php include_once('include/footer.php'); ?>