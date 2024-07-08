<?php 
include_once('include/header.php');
if(!in_array(3,$my_access)) { redirect('Admin_dashboard'); }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Category Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Category Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"   data-toggle="modal" data-target="#add_category" class="btn btn-success">Add Category</a> 
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
            <table id="memListTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
									<th>S.No</th> 
									<th>Category</th>
									<th>Parent Category</th>
									<th>Slug</th>
									<th>Image</th>
									<th>Action</th>
								</tr>
              </thead>
							<tfoot>
                <tr>
                  
									<th>S.No</th> 
									<th>Category</th>
									<th>Parent Category</th>
									<th>Slug</th>
									<th>Image</th>
									<th>Action</th>
								</tr>
              </tfoot>
            </table>
			</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade in" id="extra_service">
  <div class="modal-body" id="msg">
    <div class="modal-dialog">	 
      <div class="modal-content">
      	<div class="modal-header">
      		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          	<span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">Add Extra Service</h4>
      	</div>
      	<div class="modal-body form_width100">
      		<input type="hidden" name="catId" id="catId">
      		<div class="exServiceMsg"></div>
      		<div class="form-group">
						<label for="email"> Service Name:</label>
						<input type="text" name="ex_service_name" id="ex_service_name" class="form-control" >
				 	</div>
				 	<div class="text-right">
				 		<button type="button" class="btn btn-info signup_btn" id="storeExService">Save</button>
				 	</div>
					<div class="row" style="margin-top: 15px;">
						<div class="col-sm-12">
							<table id="serviceListTable" class="table table-bordered table-striped">
	              <thead>
	                <tr>                  
										<th>S.No</th> 
										<th>Service Name</th>
										<th>Action</th>
									</tr>
	              </thead>
	              <tbody id="serviceList"></tbody>							
	            </table>
						</div> 	
					</div>
	      </div>
      	<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade in" id="add_category">
   <div class="modal-body" id="msg">
      <div class="modal-dialog">	 
         <div class="modal-content">         	
		  		<form method="post" id="add_category1" enctype="multipart/form-data">
            <div class="modal-header">
              <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body form_width100">
						<div class="form-group">
							<label for="email"> Select category:</label>
							<select type="text" name="cat_parent" id="cat_parent"  class="form-control" onchange="InsertTitle(this,'','')" >
								
								<option value=''>Select</option>
								
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
								
								
								<?php /*<option value=''>select</option>
								<?php foreach($listing as $categorylistss){?>
								<option value='<?php echo $categorylistss['cat_id'];?>'><?= (getCatName($categorylistss['cat_parent'])) ? getCatName($categorylistss['cat_parent'])['cat_name'].'-> ' : '' ?><?php echo $categorylistss['cat_name'];?></option>  ?>

								<?php } */ ?>
							</select>
						</div>
			<div class="form-group">
				<label for="email"> Category Name:</label>
				<input type="text" name="cat_name" onkeyup="create_slug(0,this.value);" id="cat_name"  class="form-control" >
			 </div>
			 <div class="form-group">
				<label for="cat_ques"> Category Question:</label>
				<input type="text" name="cat_ques" value="What type of category_name job do you need?" id="cat_ques" class="form-control" >
			 </div>
			 <div class="form-group title_ft">
				<label for="email"> Category title for find tradesmen page:</label>
				<input type="text"  name="title_ft"  id="title_ft" class="form-control" >
			 </div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug" id="slug0" class="form-control" required>
				<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
			 </div>
			 	 <div class="form-group">
				<label for="email"> Description:</label>
				<textarea rows="5" placeholder="" name="cat_description" id="cat_description" class="form-control"></textarea>
			 </div>
			 	 <div class="form-group hide">
				<label for="description0"> Description (For find job page):</label>
				<textarea rows="5" placeholder="" name="description" id="description0" class="form-control"></textarea>
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Title:</label>
				<input type="text" name="meta_title" id="meta_title" class="form-control" >
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Keywords:</label>
				<input type="text" name="meta_key" id="meta_key" class="form-control" >
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Description:</label>
				<textarea rows="5" placeholder="" name="meta_description" id="meta_description" class="form-control"></textarea>
			 </div>

			 <div class="form-group">
				<label for="email"> Footer Description:</label>
				<textarea rows="5" placeholder="" name="footer_description" id="footer_description" class="form-control textarea"></textarea>
			 </div>


			 <div class="form-group hide">
				<label for="email"> Meta Title (For find job page):</label>
				<input type="text" name="meta_title2" id="meta_title2" class="form-control" >
			 </div>
			 <div class="form-group hide">
				<label for="email"> Meta Keywords (For find job page):</label>
				<input type="text" name="meta_key2" id="meta_key2" class="form-control" >
			 </div>
			 <div class="form-group hide">
				<label for="email"> Meta Description (For find job page):</label>
				<textarea rows="5" placeholder="" name="meta_description2" id="meta_description2" class="form-control"></textarea>
			 </div>
			 <div class="form-group">
				<label for="email"> Thumbnail Image:</label>
			<input type="file" name="cat_image" id="cat_image" class="form-control" accept="image/*">
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
					window.location.href = site_url+'category';
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
	function create_slug(id,v){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/slug/create_cate_slug/'+id,
			data:{title:v},
			async:false,
			success:function(res){
				$('#slug'+id).val(res);
			}
		})
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
	        "url": site_url+"Admin/Admin/getCategoryLists",
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

	function openExServiceModdal(catId){
		$('#catId').val(catId);
		$.ajax({
			url:site_url+'Admin/Admin/getExService/'+catId,
			type:'POST',			
			success:function(data){
				$('#serviceList').empty().html(data);
				$('#extra_service').modal('show');
			}
		});
	}

	$('#storeExService').on('click', function(){
		var catId = $('#catId').val();
		var ex_service_name = $('#ex_service_name').val();
		$.ajax({
			url:site_url+'Admin/Admin/addExService/'+catId,
			type:'POST',
			data:{ex_service_name:ex_service_name},			
			success:function(data){
				if(data != ""){
					$('.exServiceMsg').html('<p class="alert alert-success" style="padding:7px;">Extra service addedd suvvessfully</p>').show();
					$('#ex_service_name').val('');
					$('#serviceList').empty().html(data);
					hideMsg();
				}				
			}
		});
	});

	function removeExService(exId){
		if(confirm('Are you sure you want to remove this service?')){
			$.ajax({
				url:site_url+'Admin/Admin/removeExService/'+exId,
				type:'POST',			
				success:function(data){
					if(data != ""){
						$('.exServiceMsg').html('<p class="alert alert-success" style="padding:7px;">'+data+'</p>').show();
						$('#ex'+exId).remove();
						hideMsg();
					}				
				}
			});
		}
	}

	function hideMsg(){
    setTimeout(function() {
      $('.exServiceMsg').fadeOut('slow', function() {
        $(this).hide();
      });
    }, 3000);
  };
</script>	
<?php include_once('include/footer.php'); ?>