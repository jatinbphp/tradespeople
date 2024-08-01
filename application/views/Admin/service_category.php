<?php 
include_once('include/header.php');
if(!in_array(3,$my_access)) { redirect('Admin_dashboard'); }
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Service Category Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Service Category Management</li>
		</ol>
	  
  </section>
	<section class="content-header text-right">
	  <button type="button" onclick="openCategoryModel('add_category',0)" class="btn btn-success">
		  Add Service Category
		</button> 
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
									<th>Sub Category</th>
									<th>Slug</th>
									<th>Action</th>
								</tr>
              </thead>
							<tfoot>
                <tr>
                  
									<th>S.No</th> 
									<th>Category</th>
									<th>Sub Category</th>
									<th>Slug</th>
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

<div class="modal fade in" id="FAQsModel">
  <div class="modal-body" id="msg">
    <div class="modal-dialog modal-lg">	 
      <div class="modal-content">
      	<div class="modal-header">
      		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          	<span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">Add Category FAQs</h4>
      	</div>
      	<div class="modal-body form_width100">
      		<input type="hidden" name="catId" id="faqCatId">
      		<div class="faqsMsg"></div>
      		<div class="form-group">
						<label for="question"> Question:</label>
						<textarea type="textarea" name="question" id="question" placeholder="Question" rows="3" class="form-control">
						</textarea>
				 	</div>
				 	<div class="form-group">
						<label for="question"> Answer:</label>
						<textarea type="textarea" name="answer" id="answer" placeholder="Answer" rows="3" class="form-control">
						</textarea>
				 	</div>
				 	<div class="text-right">
				 		<button type="button" class="btn btn-info signup_btn" id="storeFAQs">Save</button>
				 	</div>
					<div class="row" style="margin-top: 15px;">
						<div class="col-sm-12">
							<table id="serviceListTable" class="table table-bordered table-striped">
	              <thead>
	                <tr>                  
										<th>S.No</th> 
										<th>Question & Answer</th>
										<th>Action</th>
									</tr>
	              </thead>
	              <tbody id="faqList"></tbody>							
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
            <h4 class="modal-title">Add Service Category</h4>
          </div>
          <div class="modal-body form_width100">
						<div class="form-group">
							<label for="email"> Select category:</label>
							<select name="category" id="category" class="form-control">
								<option value=''>Select</option>								
								<?php foreach($parent_category as $key => $list){ ?>
									<option value="<?php echo $list['cat_id']; ?>"><?php echo $list['cat_name']; ?></option>
								<?php } ?>								
							</select>
						</div>

						<div class="form-group">
							<label for="email"> Select Sub Category:</label>
							<select type="text" name="sub_category" id="sub_category" class="form-control">
							</select>
						</div>

						<div class="form-group">
							<label for="email"> Select Service Type:</label>
							<select type="text" name="service_type[]" id="service_type" multiple class="form-control">
							</select>
						</div>

						<div class="form-group">
							<label id="addAttribute0" onclick="addAttribute(0)" ><i class="fa fa-plus"></i> Add Attributes:</label>							
							<div class="allAttributes" data-id="0" id="attributeList0">
							</div>
						</div>

						<div class="form-group">
							<label id="addExService"><i class="fa fa-plus"></i> Add Extra Service:</label>
							<div id="exServiceList">
							</div>
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
			url:site_url+'Admin/Admin/add_service_category',
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
					window.location.href = site_url+'service_category';
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
			url:site_url+'/Admin/Admin/update_service_category/'+id,
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
	function myfunction(eleId = '0', no){
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


		var modalId = 'add_category';
		if(eleId == 1){
			var modalId = 'edit_category';
		}

		openCategoryModel(modalId,no);
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
	        "url": site_url+"Admin/Admin/getServiceCategoryLists",
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

	$('#cat_name').on('keyup' , function(){
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

	function openFAQModal(catId){
		$('#faqCatId').val(catId);
		$.ajax({
			url:site_url+'Admin/Admin/getFAQS/'+catId,
			type:'POST',			
			success:function(data){
				$('#faqList').empty().html(data);
				$('#FAQsModel').modal('show');
			}
		});
	}

	$('#storeFAQs').on('click', function(){
		var catId = $('#faqCatId').val();
		var question = $('#question').val();
		var answer = $('#answer').val();
		$.ajax({
			url:site_url+'Admin/Admin/addFAQs/'+catId,
			type:'POST',
			data:{question:question,answer:answer},			
			success:function(data){
				if(data != ""){
					$('#question').val('');
					$('#answer').val('');
					$('.faqsMsg').html('<p class="alert alert-success" style="padding:7px;">FAQs addedd suvvessfully</p>').show();
					$('#faqsMsg').val('');
					$('#faqList').empty().html(data);
					hideMsg('faqsMsg');
				}				
			}
		});
	});

	function removeFAQs(faqId){
		if(confirm('Are you sure you want to remove this FAQs?')){
			$.ajax({
				url:site_url+'Admin/Admin/removeFAQs/'+faqId,
				type:'POST',			
				success:function(data){
					if(data != ""){
						$('.faqsMsg').html('<p class="alert alert-success" style="padding:7px;">'+data+'</p>').show();
						$('#faqs'+faqId).remove();
						hideMsg('faqsMsg');
					}				
				}
			});
		}
	}
	
	function hideMsg(cName){
    setTimeout(function() {
      $('.'+cName).fadeOut('slow', function() {
        $(this).hide();
      });
    }, 3000);
  };

  $('#category').on('change', function(){
  	var cat_id = $(this).val();
  	$.ajax({
  		url:site_url+'Admin/Admin/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id},
			success:function(data){
				if(data != ""){
					$('#sub_category').empty().html(data);
					$('#service_type').empty();
				}else{
					$('#sub_category').empty();
					$('#service_type').empty();
				}
			}
		});
  });

  $('#sub_category').on('change', function(){
  	var cat_id = $(this).val();
  	$.ajax({
  		url:site_url+'Admin/Admin/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id},
			success:function(data){
				if(data != ""){
					$('#service_type').empty().html(data);
				}else{
					$('#service_type').empty();
				}
			}
		});
  });

  var totalAttribute = 0;
  var totalExService = 1;

  function openCategoryModel(eleId, no){
  	if(eleId == 'edit_category'){
			$('#edit_category'+no).modal('show');
  	}else{
  		$('#'+eleId).modal('show');	
  	}  	
  	totalAttribute = $('.attributeList'+no).length;  
  }

  function addAttribute(id){
  	var style= '';
  	if(totalAttribute > 0){
  		style="margin-top:10px;";
  	}
  	var html = '<div class="attributeList0" id="attribute_'+id+'_'+totalAttribute+'" style="'+style+'">'+
										'<input type="text" name="attributes[]" placeholder="Enter attribute name" class="form-control" style="width: 92%; float: left;">'+
										'<button class="btn btn-danger removeAttribute" onclick="removeAttribute(0,'+totalAttribute+')" data-id="'+totalAttribute+'" data-id="'+totalAttribute+'" type="button" style="margin-left: 8px;">'+
											'<i class="fa fa-trash"></i>'+
										'</button>'+
									'</div>';

		$('#attributeList'+id).append(html);
		totalAttribute++;
  };

  $(document).ready(function(){ 
    $('.allAttributes').on('click', '.removeAttribute', function() {
    	  var containerId = $(this).closest('.allAttributes').attr('id');
        var eleId = $(this).parent().attr('id').split('_')[1];
        var no = $(this).data('id');
        alert(eleId + '_' + no);
        removeAttribute(containerId, eleId, no);
    });

    function removeAttribute(eleId, no){
      alert(eleId + '_' + no);
      $('#attribute_'+eleId+'_'+aId).remove();
	  	if(totalAttribute > 0){
	  		totalAttribute--;	
	  	}else{
	  		totalAttribute = $('.attributeList'+no).length;	  		
	  	} 
    }
	});


  $('#addExService').on('click', function(){
  	var style= '';
  	if(totalExService > 1){
  		style="margin-top:10px;";
  	}
  	var html = '<div class="row" id="exService'+totalExService+'" style="'+style+' margin-right:0">'+
									'<div class="col-md-5">'+
										'<input type="text" name="exService[name]['+totalExService+']" placeholder="Enter extra service name" class="form-control">'+
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="text" name="exService[price]['+totalExService+']" placeholder="Enter price" class="form-control">'+
									'</div>'+
									'<div class="col-md-3">'+
										'<input type="number" min="0" name="exService[days]['+totalExService+']" placeholder="Enter days" class="form-control">'+
									'</div>'+
									'<div class="col-md-1" style="padding-left:0px;">'+
  									'<button class="btn btn-danger removeExService" data-id="'+totalExService+'" type="button" style="margin-left: 8px;">'+
											'<i class="fa fa-trash"></i>'+
										'</button>'+
									'</div>'+
								'</div>';

		$('#exServiceList').append(html);
		totalExService++;
  });

  $('#exServiceList').on('click', '.removeExService', function (event) {
  	event.preventDefault();
  	var aId = $(this).data('id');
  	$('#exService'+aId).remove();
  	if(totalExService > 1){
  		totalExService--;	
  	}else{
  		totalExService = 1;
  	}  	
  });

</script>	
<?php include_once('include/footer.php'); ?>