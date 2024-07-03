<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Cost Guide Management</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Cost Guide Management</li>
    </ol>
  </section>
  <section class="content-header text-right">
    <a href="javascript:void(0);"  data-toggle="modal" data-target="#addCostGuide" class="btn btn-success">Add Cost Guide</a> 
  </section>

  <section class="content">   
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
            <?php if($this->session->flashdata('error')) { ?>
            <p class="alert alert-danger"><?=$this->session->flashdata('error'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success')) { ?>
            <p class="alert alert-success"><?=$this->session->flashdata('success'); ?></p>
            <?php } ?>
            <div class="table-responsive">
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th> 
                  <th>Title</th>
									<th>Slug</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Image</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach($costGuides as $key => $costGuide) {
                ?>
                <tr>
                  <td><?=$key+1;?></td>
                  <td><?=$costGuide['title'];?></td>
									<td><?php echo $costGuide['slug']; ?></td>
                  <td>£<?=$costGuide['price'];?><?= ($costGuide['price2']>0)?' - £'.$costGuide['price2']:'';?></td>
                  <td class=""><?=($costGuide['description'])?substr(strip_tags($costGuide['description']), 0, 47).'...':'';?></td>
                  <td><img class="cost-image" src="img/costguide/<?=$costGuide['image'];?>" ></td>
                  <td><?=date("d M Y", strtotime($costGuide['updated_at']));?></td>
                  <td>
                    <button type="button" onclick="get_cost_guide(<?=$costGuide['id'];?>);" class="btn btn-success btn-xs">Edit </button>

                    <button type="button" class="btn btn-danger btn-xs" onclick="delete_cost_guide(<?=$costGuide['id'];?>);" > Delete </button>
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

<div class="modal fade in" id="editCostGuide">
  <div class="modal-body" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="post" enctype="multipart/form-data" id="updateCostGuide" onsubmit="update_cost_guide(event);">
          <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             <h4 class="modal-title">Edit Cost Guide</h4>
          </div>
          <div class="modal-body" id="editCostGuide_content">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info" >Save</button>
            <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade in" id="addCostGuide">
  <div class="modal-body" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="post" id="add_cost_guide" enctype="multipart/form-data" onsubmit="addCostGuide(event);">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Add Cost Guide</h4>
          </div>
          <div class="modal-body form_width100">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" name="title" id="title0" onkeyup="create_slug(0,this.value);" class="form-control" required>
            </div>
						<div class="form-group">
							<label for="email"> Slug:</label>
							<input type="text" name="slug" id="slug0" value="" class="form-control" required>
						 </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" name="price" id="price" min="0.1" step="0.1" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="price">Price 2:</label>
              <input type="number" name="price2" id="price2" min="0.1" step="0.1" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea name="description" class="form-control textarea" ></textarea>
              <p class="text-danger" id="descriptionError"> This field is required </p>
            </div>
						<div class="form-group">
							<label for="email"> Meta Title:</label>
							<input type="text" name="meta_title" class="form-control">
            </div>
						<div class="form-group">
							<label for="email"> Meta Keywords:</label>
							<input type="text" name="meta_key" class="form-control">
            </div>
						<div class="form-group">
              <label for="meta_desc">Meta Description:</label>
              <textarea name="meta_desc" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label for="image">Image:</label>
              <input type="file" name="image" class="form-control" required accept="image/*">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info signup_btn signup_btn12" >Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $("#descriptionError").hide();
  function addCostGuide(e){
    e.preventDefault();
    $("#descriptionError").hide();
    let content = tinyMCE.activeEditor.getContent();
    if(content == '' || content == null){
      $("#descriptionError").show();
      return false;
    }
		
		var price = parseFloat($('#price').val());
		var price2 = parseFloat($('#price2').val());
		
		if(price >= price2){
			alert('second price can not be more than first price.');
			return false;
		}
		
    var form = $('#add_cost_guide')[0];
    var formData = new FormData(form);
    $.ajax({
      type:'POST',
      url:site_url+'Admin/Admin/addCostGuide',
      data: formData,
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
          $('#addCostGuide').modal('toggle');
          location.reload();
        } else {
          $('.msg').html(resp.msg);
          $('.signup_btn').html('Save');
          $('.signup_btn').prop('disabled',false);
        }
      }
    });
  }
	function create_slug(id,v){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/slug/create_cost_guide_slug/'+id,
		data:{title:v},
		async:false,
		success:function(res){
			$('#slug'+id).val(res);
		}
	})
}
  function get_cost_guide(cost_guide_id){
    $.ajax({
      type:'POST',
      url:site_url+'Admin/Admin/get_cost_guide',
      data: {
        id : cost_guide_id,
      },
      dataType: 'JSON',
      beforeSend:function(){
      },
      success:function(response){
        $("#editCostGuide_content").html('');
        $("#editCostGuide_content").html(response.output);
        $("#editDescriptionError").hide();
        init_tinymce();
        tinymce.activeEditor.setContent(response.description);
        $('#editCostGuide').modal('toggle');
      }
    });
  }

  function update_cost_guide(e){
    $("#editDescriptionError").hide();
    e.preventDefault();
    let content = tinyMCE.activeEditor.getContent();
    if(content == '' || content == null){
      $("#editDescriptionError").show();
      return false;
    }
		
		var price = parseFloat($('#price_1').val());
		var price2 = parseFloat($('#price2_1').val());
		
		if(price >= price2){
			alert('second price can not be more than first price.');
			return false;
		}
		
		
    var form = $('#updateCostGuide')[0];
    var formData = new FormData(form);
    $.ajax({
      type:'POST',
      url:site_url+'Admin/Admin/update_cost_guide',
      dataType: 'JSON',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend:function(){
				$('.mmss').html('');
				$('.signup_btn12').prop('disabled',true);
      },
      success:function(response){
				
				if(response.status==1){
          location.reload();
        } else {
          $('.mmss').html(response.msg);
					$('.signup_btn12').prop('disabled',false);
        }
      }
    });
  }
  
  function delete_cost_guide(cost_guide_id){
    if(confirm("Are you sure want to delete this Cost Guide?")){
      $.ajax({
        type:'POST',
        url:site_url+'Admin/Admin/delete_cost_guide',
        dataType: 'JSON',
        data: {
          id : cost_guide_id
        },
        beforeSend:function(){
        },
        success:function(response){
          if(response.status == 1) location.reload();
        }
      });
    }
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#newImage').attr('src', e.target.result);
        $("#oldImage").hide();
        $("#newImage").show();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

</script>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

<script>
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		height:480,
		plugins: [ 
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table paste"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		document_base_url: site_url,images_upload_handler : function(blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false; 
			xhr.open('POST', '<?php echo site_url(); ?>Admin/blog/addeditorimage');

			xhr.onload = function() {
				var json;

				if (xhr.status != 200) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}

				json = JSON.parse(xhr.responseText);

				if (!json || typeof json.file_path != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.file_path);
				console.log(json.file_path);
			};

				formData = new FormData();
				formData.append('file', blobInfo.blob(), blobInfo.filename());

				xhr.send(formData);
		}, 
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}
</script> 
<?php include_once('include/footer.php'); ?>