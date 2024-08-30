<?php 
include_once('include/header.php');
if(!in_array(22,$my_access)) { redirect('Admin_dashboard'); }
?>

<style>
	.switch {
		position: relative;
		display: inline-block;
		width: 53px;
		height: 26px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.switch-slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.switch-slider:before {
		position: absolute;
		content: "";
		height: 22px;
		width: 22px;
		left: 3px;
		bottom: 2px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .switch-slider {
		background-color: #2196F3;
	}

	input:focus + .switch-slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .switch-slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded switch-sliders */
	.switch-slider.round {
		border-radius: 34px;
	}

	.switch-slider.round:before {
		border-radius: 50%;
	}
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Service Category Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Service Category Management</li>
		</ol>
	  
  </section>
	<section class="content-header text-right">
	  <button type="button" onclick="openCategoryModel(0)" class="btn btn-success">
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
									<th>Slug</th>
									<th>Action</th>
								</tr>
              </thead>
							<tfoot>
                <tr>                  
									<th>S.No</th> 
									<th>Category</th>
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

<div id="modal-div"></div>

<?php $this->load->view('Admin/service_category_modal', ['form' => $serviceData, 'url' => site_url()."users/updateServices2/{$id}"]); ?>

<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

<script>
	function submitServiceCategory(formType, catId){	
		var formData = $('#service_category_form').serialize();
		var formUrl = site_url+'Admin/Admin/add_service_category';

		if(formType == 1){
			formUrl = site_url+'Admin/Admin/update_service_category/'+catId;
		}

		$.ajax({
			url:formUrl,
			type:'POST',
			data: formData,
			cache: false,
			beforeSend:function(){       
				$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
				$('.signup_btn').prop('disabled',true);
				$('.msg').html('');
			},
			success:function(resp){
				var data = JSON.parse(resp);
				if(data.status==1){
					window.location.href = site_url+'service_category';
				} else {
	        //window.location.href="#msg";
					$('.msg').html(data.msg);
					$('.signup_btn').html('Save');
					$('.signup_btn').prop('disabled',false);

					$('.msg').attr('tabindex', '-1');

          $('html, body').animate({
          	scrollTop: $('.msg').offset().top - 20  // Add offset if needed
          }, 500, function() {
            $('.msg').focus();
          });
				}
			}
		});
		return false;
	}

	function create_slug(id,v,eleId){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/Admin/create_service_category_slug/'+id,
			data:{title:v},
			async:false,
			success:function(res){
				$('#slug'+eleId).val(res);				
			}
		})
	}

	function create_slug2(id, v, callback) {
    $.ajax({
        type: 'POST',
        url: site_url + 'Admin/Admin/create_service_category_slug/' + id,
        data: { title: v },
        async: false,
        success: function(res) {
            if (callback) callback(res);
        }
    });
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

	function myfunction(no){
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
		openCategoryModel(no);
	}	

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

  function getSubCategory(cat_id){  	
  	var ser_cat_id = $('#service_cat_id').val();
  	$.ajax({
  		url:site_url+'Admin/Admin/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_id, 'ser_cat_id':ser_cat_id},
			success:function(data){
				if(data != ""){
					$('#sub_category').empty().html(data);
					$('#service_type').empty();
					if(cat_id > 0){
						var selectedValues = $('#sub_category').val();
			      getServiceType(selectedValues);			      
					}
				}else{
					$('#sub_category').empty();
					$('#service_type').empty();					
				}
			}
		});
  }

	/*function getServiceType(cat_ids){
		var ser_cat_id = $('#service_cat_id').val();
		$.ajax({
  		url:site_url+'Admin/Admin/getSubCategory',
			type:"POST",
			data:{'cat_id':cat_ids, 'ser_cat_id':ser_cat_id, 'is_service_type':1},
			success:function(data){
				if (data != "") {
          $('#service_type_category').empty(); // Clear the existing options
          $('#service_type_category').append(data); // Append the new options
        } else {
          $('#service_type_category').empty(); // Clear if no data
        }
			}
		});
  };*/

  function getServiceType(cat_ids) {
    var ser_cat_id = $('#service_cat_id').val();
    var selectedOptions = $('#service_type_category').val(); // Get currently selected options

    $.ajax({
        url: site_url + 'Admin/Admin/getSubCategory',
        type: "POST",
        data: { 'cat_id': cat_ids, 'ser_cat_id': ser_cat_id, 'is_service_type': 1 },
        success: function (data) {
            if (data != "") {
                var newOptions = $(data); // Convert the returned HTML to a jQuery object
                var retainedOptions = []; // Array to store retained selected options

                // Check if currently selected options should be retained
                newOptions.each(function () {
                    var optionValue = $(this).val();
                    if (selectedOptions.includes(optionValue)) {
                        retainedOptions.push(optionValue);
                    }
                });

                $('#service_type_category').empty(); // Clear the existing options
                $('#service_type_category').append(newOptions); // Append the new options

                // Retain the previously selected options
                //$('#service_type_category').val(retainedOptions).trigger('change');
            } else {
                $('#service_type_category').empty(); // Clear if no data
            }
        }
    });
}
  

  var totalAttribute = 0;
  var totalExService = 0;
  var totalPriceUnit = 0;

  function openCategoryModel(catId = 0){
  	$.ajax({
			url:site_url+'Admin/Admin/openModal',
			type:'POST',
			data:{'catId':catId},
			success:function(response){
				$('#modal-div').html(response.html);
				$('#service_category_modal').modal('show');
				$('.select2').select2();
				$('#service_category_modal').on('shown.bs.modal', function() {
					$('#main_category').select2();
					$('#sub_category').select2();
					$('#service_type_category').select2();

					totalAttribute = $('.attributeList').length;
				  totalExService = $('.exServiceList').length;
				  totalPriceUnit = $('.priceUnitList').length;

					if(catId > 0){
						$('.modal-title').text('Edit Service Category');
						$('#main_category').trigger('change');		
					}else{
						$('.modal-title').text('Add Service Category');
					}
        });

			},
	    error: function(xhr, status, error) {
	        console.error('AJAX Error: ' + status, error);
	    }
		});
  }

  // function initializeTagsInput() {
  //   $('#service_type_category').tagsinput({
  //       minTags: 5
  //   });

  //   $('#service_type_category').on('beforeItemAdd', function(event) {
  //       var tag = event.item;
  //       console.log(tag);
  //       var regex = /^[a-zA-Z0-9\s]+$/;
  //       if (!regex.test(tag)) {
  //           event.cancel = true; // Cancel adding the tag
  //       }
  //   });
	// }

  function addAttribute(){
  	var style= '';
  	if(totalAttribute > 0){
  		style="margin-top:10px;";
  	}
  	var html = '<div class="attributeList" id="attribute_'+totalAttribute+'" style="'+style+'">'+
									'<input type="text" name="attributes[]" placeholder="Enter attribute name" class="form-control" style="width: 92%; float: left;">'+
									'<button class="btn btn-danger removeAttribute" data-id="'+totalAttribute+'" type="button" style="margin-left: 8px;">'+
										'<i class="fa fa-trash"></i>'+
									'</button>'+
								'</div>';

		$('#attributeList').append(html);
		totalAttribute++;
  }

  $(document).on('click', '.removeAttribute', function() {
    var id = $(this).data('id');
    removeAttribute(id);
	});

  function removeAttribute(attId) {
  	$('#attribute_'+attId).remove();
  	if(totalAttribute > 0){
  		totalAttribute--;	
  	}else{
  		totalAttribute = $('.attributeList').length;	  		
  	}
  }

  function addextraService(){	
  	var style= '';
  	if(totalExService > 0){
  		style="margin-top:10px;";
  	}
  	var html = '<div class="row exServiceList" id="exService_'+totalExService+'" style="'+style+' margin-right:0">'+
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
  };

  $(document).on('click', '.removeExService', function() {
    var id = $(this).data('id');
    removeExService(id);
	});

  function removeExService(attId) {
  	$('#exService_'+attId).remove();
  	if(totalAttribute > 0){
  		totalAttribute--;	
  	}else{
  		totalAttribute = $('.exServiceList').length;	  		
  	}
  }  

  function addPriceUnit(){
  	var style= '';
  	console.log(totalPriceUnit);
  	if(totalPriceUnit > 0){
  		style="margin-top:10px;";
  	}
  	var html = '<div class="priceUnitList" id="priceUnit_'+totalPriceUnit+'" style="'+style+'">'+
									'<input type="text" name="priceUnit[]" placeholder="Enter price unit name" class="form-control" style="width: 92%; float: left;">'+
									'<button class="btn btn-danger removePriceUnit" data-id="'+totalPriceUnit+'" type="button" style="margin-left: 8px;">'+
										'<i class="fa fa-trash"></i>'+
									'</button>'+
								'</div>';

		$('#priceUnitList').append(html);
		totalPriceUnit++;
  }

  $(document).on('click', '.removePriceUnit', function() {
    var id = $(this).data('id');
    removePriceUnit(id);
	});

  function removePriceUnit(attId) {
  	$('#priceUnit_'+attId).remove();
  	if(totalPriceUnit > 0){
  		totalPriceUnit--;	
  	}else{
  		totalPriceUnit = $('.priceUnitList').length;	  		
  	}
  }

  $(document).ready(function(){
	  $('#memListTable').DataTable({
	    "processing": true,
	    "serverSide": true,
	    "stateSave": true,
	    "order": [],
	    "ajax": {
	        "url": site_url+"Admin/Admin/getServiceCategoryLists",
	        "type": "POST"
	    },
	    "columnDefs": [{ 
	        "targets": [0],
	        "orderable": false
	    }] 
	  });	  

	  $(document).on('change', '#sub_category', function() {
        var selectedValues = $(this).val();
        getServiceType(selectedValues);
    });

    function toggleDiv() {
  	  if ($('#price_type').is(':checked')) {
  	  	$('#priceUnitListDiv').removeClass('hide');
      } else {
        $('#priceUnitListDiv').addClass('hide');
      }
    }

    $(document).on('change', '#price_type', function() {
    	toggleDiv();
    });

    $('#service_category_modal').on('shown.bs.modal', function() {
			toggleDiv();
			$('#main_category').trigger('change');
    });
	});
</script>	
<?php include_once('include/footer.php'); ?>