<?php 
include_once('include/header.php');
if(!in_array(3,$my_access)) { redirect('Admin_dashboard'); }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1> Local Category <?php echo ($locations!=false) ? 'Of '.$locations['city_name'] : 'Management' ?></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Local Category <?php echo ($locations!=false) ? 'Of '.$locations['city_name'] : 'Management' ?></li>
		</ol>
 </section>
 
	


  <section class="content">

   <?php echo $this->session->flashdata('msg'); ?>

   <div class="row">

   <div class="col-xs-12">

      <div class="box box-primary">

         <div class="box-header">

            <h3 class="box-title">All Categories</h3>

            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">Add Local Category</button>


         </div>

         <div class="box-body">

            <div class="table-responsive">

               <table  class="table table-striped table-bordered example">

                  <thead>

                     <tr>

                        <th>S.No</th>

                       <!--  <th>Category</th> -->

                         <th>Parent Category</th>


                        <th>Slug</th>

                         <th>Image</th>

                   		<th>Location</th>
                        
                        <th>Action</th>

                     </tr>

                  </thead>

                  

                    <tbody>
                      <?php  $i = 1; foreach($listing as $data){   ?>
                    <tr>

                        <td><?php echo $i++;?></td>

                        <!-- <td><?php echo $data['cat_name'];?></td> -->
                        <td><?php 
                        	$main_category = $this->Common_model->GetSingleData('category',array('cat_id'=>$data['cat_parent']));
                        	echo $main_category['cat_name'];

                        ?></td>
                        <td><?php echo $data['slug'];?></td>
                        <td>
						  <?php if(!empty($data["image"])) { ?>
						    <img style="height: 100px;width: 100px;" src="<?php echo base_url("img/category/".$data["image"]);?>">
						    <?php } ?>
						    <?php if(empty($data["image"])) { ?>
						    <img style="height: 100px;width: 100px;" src="<?php echo base_url("img/default-image.jpg");?>">
						    <?php } ?>
                       </td>
                        <td><?php 
                          	$location = $this->Common_model->GetSingleData('tbl_city',array('id'=>$data['location']));
                          	echo $location['city_name'];
                          ?>
                          </td>

                    <td>
                    	<a href="<?= base_url().$data['slug']?>" target="_blank" style="font-size:16px" class="btn btn-warning btn-xs">View</i></a>

                    	 <a  style="font-size:16px"  data-toggle="modal" data-target="#editmyModal<?php echo $data['cat_id'];?>" class="btn btn-primary btn-xs">Edit</i></a>


                       <a style="font-size:16px" onclick="return  confirm('Are you sure want to delete this Category?');" href="<?php echo base_url();?>Admin/Local_Category/delete_category/<?php echo $data['cat_id'];?>?redirect_location=<?= ($locations) ? $locations['id'] : ''?>" tyle="float: right;" class="btn btn-danger btn-xs">Delete</a>
                       <?php if($data['enabled']) {?>
					   <a style="font-size:16px" onclick="return  confirm('Are you sure want to disable this Category?');" href="<?php echo base_url();?>Admin/Local_Category/disable_category/<?php echo $data['cat_id'];?>?redirect_location=<?= ($locations) ? $locations['id'] : ''?>" tyle="float: right;" class="btn btn-warning btn-xs">Disable</a>
					 	<?php } else {?>  
					   <a style="font-size:16px" onclick="return  confirm('Are you sure want to enable this Category?');" href="<?php echo base_url();?>Admin/Local_Category/enable_category/<?php echo $data['cat_id'];?>?redirect_location=<?= ($locations) ? $locations['id'] : ''?>" tyle="float: right;" class="btn btn-success btn-xs">Enable</a>
						<?php } ?>
                    </td>

                     </tr>


                       <!-- Modal -->
                       <div class="modal fade slug-modal" id="editmyModal<?php echo $data['cat_id'];?>" role="dialog">
          	<div class="modal-dialog">
            <!-- Modal content-->
        			<div class="modal-content">
        				<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Edit Local Category</h4>
        				</div>
      					<form action="<?php echo base_url(); ?>Admin/Local_Category/edit_category?redirect_location=<?= ($locations) ? $locations['id'] : ''?>" method="post" enctype="multipart/form-data" autocomplete="off">
      						<input type="hidden" name="cat_id"  value="<?php echo $data['cat_id'];?>">
             			<div class="modal-body form_width100">
										<div class="form-group">
											<label for="email"> Select category:</label>
											<select type="text" name="cat_parent" id="cat_parent<?php echo $data['cat_id']; ?>"  class="form-control cat-slug-edit" required onchange="create_slug(<?php echo $data['cat_id']; ?>);">
											<?php
												$newCategory = getParent();											
												foreach($newCategory as $newCategoryKey => $newCategoryVal){
												?>
													<optgroup label="<?php echo $newCategoryVal['cat_name']; ?>">
													<?php
													$selected = ($data['cat_parent']==$newCategoryVal['cat_id']) ? 'selected' : '';
													?>
													<option <?= $selected; ?> value="<?php echo $newCategoryVal['cat_id']; ?>"><?php echo $newCategoryVal['cat_name']; ?> (Main)</option>
													<?php
													if(!empty($newCategoryVal['child'])){
														foreach($newCategoryVal['child'] as $childKey => $childVal){														
															$selected = ($data['cat_parent']==$childVal['cat_id']) ? 'selected' : '';
															?>														
															<option <?= $selected; ?> value="<?php echo $childVal['cat_id']; ?>"><?php echo $childVal['cat_name']; ?></option>
															<?php
														}													
													}
													?>												
												</optgroup>											
												<?php } ?>
											</select>
										</div>
										<div class="form-group">
											<label for="email">Select city:</label>
											<select type="text" name="city" id="location<?php echo $data['cat_id']; ?>" onchange="create_slug(<?php echo $data['cat_id']; ?>);"  class="form-control loc-slug-edit" required>
												<?php
													$location = $this->Common_model->GetSingleData('tbl_city',array('id'=>$data['location']));
												?>                          
												<option value='<?php echo $location['id']; ?>'><?php echo $location['city_name'];?></option>
												<?php
													$city = $this->Common_model->GetAllData('tbl_city');								
														foreach($city as $Key => $value){									
														$selected = ($data['location']==$value['id']) ? 'selected' : '';
												?>									
												<option <?= $selected; ?> value="<?php echo $value['id']; ?>"><?php echo $value['city_name']; ?></option>								
												<?php } ?>								
											</select>
				 						</div>

										<!-- <div class="form-group">
											<label for="email"> Category Name:</label>
											<input type="text" name="cat_name" onkeyup="create_slug(<?php echo $data['cat_id']; ?>,this.value);" id="cat_name"  class="form-control" value="<?php echo $data['cat_name']; ?>" required >
										 </div> -->
										<div class="form-group">
											<label for="email"> Slug:</label>
											<input type="text" name="slug" data-slug="<?=$data['slug']?>" id="slug<?php echo $data['cat_id']; ?>" class="form-control" required value="<?php echo $data['slug']; ?>"  >
											<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
										</div>
										<div class="form-group">
											<label for="email">Title:</label>
											<input type="text" name="title" id="title<?php echo $data['cat_id']; ?>" class="form-control" value="<?php echo $data['title']; ?>">
										</div>
				  					<div class="form-group">
											<label for="email">Description:</label>
											<textarea rows="5" placeholder="" name="description" id="cat_description" class="form-control"><?php echo $data['description']; ?></textarea>
				 						</div>			 	 
										<div class="form-group">
											<label for="email">Meta Title:</label>
											<input type="text" name="meta_title" id="meta_title" class="form-control" value="<?php echo $data['meta_title']; ?>" >
										</div>
				 						<div class="form-group">
											<label for="email">Meta Keywords:</label>
											<input type="text" name="keyword" id="meta_key" class="form-control" value="<?php echo $data['keyword']; ?>" >
										</div>
										<div class="form-group">
											<label for="email">Meta Description</label>
											<textarea rows="5" placeholder="" name="meta_description" id="meta" class="form-control"><?php echo $data['meta_description']; ?></textarea>
										</div>
										<div class="form-group">
											<label for="email">Footer Description:</label>
											<textarea rows="5" placeholder="" name="footer_description" id="footer_description" class="form-control textarea" ><?php echo $data['footer_description']; ?></textarea>
										</div>
										<div class="form-group">
											<label for="email">Thumbnail Image:</label>
											<input type="file" name="cat_image" id="" class="form-control" accept="image/*">
										</div>
										<div class="form-group">
											<?php if(!empty($data["image"])) { ?>
											    <img style="height: 100px;width: 100px;" src="<?php echo base_url("img/category/".$data["image"]);?>">
											    <?php } ?>
											    <?php if(empty($data["image"])) { ?>
											    <img style="height: 100px;width: 100px;" src="<?php echo base_url("img/default-image.jpg");?>">
											    <?php } ?>
										</div>
										<div class="modal-footer">
	            				<button  class="btn btn-default addBtn<?php echo $data['cat_id']; ?>">Update</button>
	          					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	          				</div>
									</div>        
       					</form>
      				</div>
    				</div>
  				</div> 

          
        <?php
            }
           ?>
                  </tbody> 
               </table>
               </div>
               </div>
            </div>
         </div>
      </div>
</section>
</div>


<!-- Add Modal -->
   <div class="modal fade slug-modal" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Local Category</h4>
        </div>
       	<form action="<?php echo base_url(); ?>Admin/Local_Category/add_category?redirect_location=<?= ($locations) ? $locations['id'] : ''?>" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="modal-body form_width100">
						<div class="form-group">
							<label for="email">Select category:</label>							
							<select type="text" name="cat_parent" id="cat_parent0"  class="form-control cat-slug-edit" required onchange="create_slug(0);">								
								<option value=''>Select category</option>								
								<?php
								$newCategory = getParent();								
								foreach($newCategory as $newCategoryKey => $newCategoryVal){
								?>
									<optgroup label="<?php echo $newCategoryVal['cat_name']; ?>">
									<option value="<?php echo $newCategoryVal['cat_id']; ?>"><?php echo $newCategoryVal['cat_name']; ?> (Main)</option>
									<?php
									if(!empty($newCategoryVal['child'])){
										foreach($newCategoryVal['child'] as $childKey => $childVal){
											?>
											<option value="<?php echo $childVal['cat_id']; ?>"><?php echo $childVal['cat_name']; ?></option>
											<?php
										}
									}
									?>									
								</optgroup>								
								<?php } ?>								
							</select>
						</div>
						<div class="form-group">
							<label for="email">Select city:</label>
							<select type="text" name="city" id="location0" onchange="create_slug(0);" class="form-control loc-slug-edit" required>
								
								<option value=''>Select city</option>
								
								<?php
								$city = $this->Common_model->GetAllData('tbl_city',array('is_delete'=>0));
								
								foreach($city as $Key => $value){
									
									$selected = ($locations && $locations['id']==$value['id']) ? 'selected' : '';
								?>
								
								
									<option <?= $selected; ?> value="<?php echo $value['id']; ?>"><?php echo $value['city_name']; ?></option>
								
								<?php } ?>
								
							</select>
			    	</div>
						<!-- <div class="form-group">
						<label for="email"> Category Name:</label>
						<input type="text" name="cat_name" onkeyup="create_slug(0,this.value);" id="cat_name"  class="form-control" required>
					 </div> -->
						<div class="form-group">
							<label for="email"> Slug:</label>
							<input type="text" name="slug" id="slug0" class="form-control" required>
							<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
						</div>
				 		<div class="form-group">
							<label for="email">Title:</label>
							<input type="text" name="title" id="title0" class="form-control">
						</div>
						<div class="form-group">
							<label for="email">Description:</label>
							<textarea rows="5" placeholder="" name="description" id="cat_description" class="form-control"></textarea>
						</div>
				 	 
						<div class="form-group">
							<label for="email">Meta Title:</label>
							<input type="text" name="meta_title" id="meta_title" class="form-control">
						</div>
					 	<div class="form-group">
							<label for="email">Meta Keywords:</label>
							<input type="text" name="keyword" id="meta_key" class="form-control">
					 	</div>
				 		<div class="form-group">
							<label for="email">Meta Description:</label>
							<textarea rows="5" placeholder="" name="meta_description" id="cat_description" class="form-control"></textarea>
				 		</div>
				 	 
				 		<div class="form-group">
							<label for="email"> Footer Description:</label>
							<textarea rows="5" placeholder="" name="footer_description1" id="" class="form-control textarea"></textarea>
				 		</div>

						<div class="form-group">
							<label for="email"> Thumbnail Image:</label>
							<input type="file" name="cat_image" id="" class="form-control" accept="image/*">
						</div>
					</div>
          <div class="modal-footer">
            <button  class="btn btn-default addBtn0">Add</button>  
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
       	</form>
      </div>
    </div>
  </div> 
  <!-- Add Modal -->
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_category1").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/add_category',
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
				window.location.href = site_url+'local-category';
			} else {
        window.location.href="#msg";
				$('.msg').html(resp.msg);
				$('.signup_btn').html('Save');
				$('.signup_btn').prop('disabled',false);
			}
		}
	});
	return false;
});
function create_slug(id){
//console.log($('.slug-modal:visible').find('.cat-slug-edit').val());
//console.log($('.slug-modal:visible').find('.loc-slug-edit').val());
var cat_id = $('#cat_parent'+id).val();
var location = $('#location'+id).val();

	if(cat_id && location){


		$.ajax({
			type:'POST',
			url:site_url+'Admin/slug/create_local_cate_slug/'+id,
			data:{
				cat_id:cat_id,
				location:location
			},
			dataType:'JSON',
			async:false,
			success:function(res){
				if(res.status == 0) {
					$('.error-slug').remove();
					$('.cat-slug-edit:visible').after('<p class="text-danger error-slug">Selected Category Already exits for this city. PLease choose another category or city.</p>');
					$('.addBtn'+id).prop('disabled',true);
					$('#slug'+id).val('');
				}
				else {
					$('.addBtn'+id).prop('disabled',false);
					$('.error-slug').remove();
					$('#slug'+id).val(res.slug);
					$('#title'+id).val(res.title);
				}
			}
		})
	}

	
	
}
function show_at_job_search(status,id){
	
	if($('#show_at_job_search'+id).is(':checked')){
		status = 1;
	} else {
		status = 0;
	}
	$.ajax({
		type:'POST',
		url:site_url+'Admin/admin/show_at_job_search/'+id,
		data:{status:status},
		async:false,
		success:function(res){
			toastr.success('Category status updated successfully.');
		}
	})
}
function remove_category_image(id,image){
	if(confirm('Are you sure you want to remove this image?')){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/admin/remove_category_image',
			data:{
				id:id,
				image:image,
			},
			dataType:'JSON',
			async:false,
			success:function(res){
				if(res.status==1){
					$('#image-id-'+id).remove();
					$('#image-remove-btn-'+id).remove();
					toastr.success(res.msg);
				} else {
					toastr.error(res.msg);
				}
			}
		});
	}
	return false;
}
function edit_category(id){
	$.ajax({
		type:'POST',
		url:site_url+'/Admin/Admin/update_category/'+id,
		data: new FormData($('#edit_category1'+id)[0]),
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
        window.location.href="#editMsg_"+id;
				$('.edit_btn'+id).prop('disabled',false);
				$('.edit_btn'+id).html('Save');
				$('.editmsg'+id).html(resp.msg);
			}
		}
	});
	return false;
}


</script>
<script>
function myfunction(){
tinymce.init({
	selector: '.textarea',
	height:250,
	plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	setup: function (editor) {
		editor.on('change', function () {
			tinymce.triggerSave();
		});
	}
});
}
</script>	
<script>


</script>    


<script>
$(document).ready(function(){
    $('#memListTable').DataTable({
        // Processing indicator
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        "stateSave": true,
        // Initial no order.
        "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": site_url+"Admin/Local_Category/getLocalCategory",
            "type": "POST"
        },
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    });
});
$('.title_ft').hide();
$('.utitle_ft').hide();
function InsertTitle(elem, clsname=null,Id='') {
	var parent = $(elem).val();
	$('#cat_name'+Id).val('');
	$('#cat_name'+Id).keyup();
	var text = $(elem).find("option:selected").text();
	if(parent && text){
		$('#cat_ques'+Id).val('What type of '+text+' work do you need?')
	}
	
	if (parent.trim() == '') 
	{
		if (clsname){
			$('.'+clsname).hide();
		}else {
			$('.title_ft').hide();
		}
		$('#cat_ques'+Id).val('What type of category_name job do you need?')
	}
	else
	{
		if (clsname){
			$('.'+clsname).show();
		}else {
			$('.title_ft').show();
		}

	}
}
$('#memListTable').on('click' , '.btn' , function() {
	//alert('button click')
	//$('select[name="cat_parent1"]').trigger('change');
})
$('#cat_name').on('keyup' , function()
{
	elem = $(this);
	changeQues(elem);
})
 function changeQues(elem , Id=''){
 	if ($('#cat_parent'+Id).val() == '') 
 	{

 		var cat_name  = $(elem).val().trim();
 		var ques = 'What type of '+cat_name+' job do you need?';
 		if (cat_name == '') 
 		{
 			var ques = 'What type of category_name job do you need?';
 		}
		
		$('#cat_ques'+Id).val(ques);
 	}
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.date-picker').datepicker({
    	dateFormat: 'yy-mm-dd' ,
      minDate: "0"
    });
    $('.example').DataTable({
			"order": [],
		});
      
  });
</script>	
<?php include_once('include/footer.php'); ?>