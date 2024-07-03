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
									<th>Image</th>
									<th>Show at Find-job</th>
									<th>Action</th>
								</tr>
              </thead>
							<tfoot>
                <tr>
                  
									<th>S.No</th> 
									<th>Category</th>
									<th>Slug</th>
									<th>Image</th>
									<th>Show at Find-job</th>
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

<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>

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

function edit_category(id){
	$.ajax({
		type:'POST',
		url:site_url+'/Admin/slug/update_category/'+id,
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
            "url": site_url+"Admin/slug/getCategoryLists",
            "type": "POST",
            /*"success": function () {
                alert("Done!");
            } */ 
        },
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    });
});


</script>


<script>
	function myfunction() {
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


	
	<?php include_once('include/footer.php'); ?>