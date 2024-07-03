<?php 
include_once('include/header.php');
if(!in_array(6,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Blog Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Blog Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_blog" class="btn btn-success">Add Blog</a> 
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
					<th>Title</th>
					<th>Slug</th>
					<th>Description</th>
					<th>Image</th>
					<th>Action</th>
				</tr>
              </thead>
              <tbody>
								<?php 
								foreach($listing as $key=>$list) {
								//$where=array('id'=>$list['cat_id']);
								//$recordbyid=recordbyid('category',$where);
								
								?>
								<tr>
									<td><?php  echo $key+1; ?></td>
									<td><?php echo $list['b_title']; ?></td>
									<td><?php echo $list['slug']; ?></td>
									<td><?php echo substr(strip_tags($list['b_description']),0,250); ?></td>
									<td>		<?php if($list['b_image']!=''){ ?><img src="<?php echo base_url();?>img/blog/<?php echo $list['b_image'];?>" width='100px' height='100px'>
			<?php } ?></td>
									<td>   
										<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_open<?php echo $list['b_id']; ?>" class="btn btn-success btn-xs">Edit</a> 
										<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Blog/delete_blog/'.$list['b_id']); ?>" onclick="return confirm('Are you sure! you want to delete this Blog?');">Delete</a>
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

<?php 
foreach($listing as $key=>$list) {
//$where=array('id'=>$list['cat_id']);
//$recordbyid=recordbyid('category',$where);

?>

<div class="modal fade in" id="edit_open<?php echo $list['b_id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog modal-lg">
	 
			<div class="modal-content">

				<form onsubmit="return edit_count(<?= $list['b_id']; ?>);" id="edit_count<?= $list['b_id']; ?>" method="post"  enctype="multipart/form-data">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					 <h4 class="modal-title">Edit County</h4>
				</div>
				<div class="modal-body">	
					<div class="editmsg<?= $list['b_id']; ?>" id="editmsg<?= $list['b_id']; ?>"></div>
			<div class="form-group">
				<label for="email"> Title:</label>
				<input type="text" name="b_title"  id="b_title<?= $list['b_id']; ?>" onkeyup="create_slug(<?= $list['b_id']; ?>,this.value);" class="form-control" value="<?php echo $list['b_title']; ?>">
			</div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug" id="slug<?= $list['b_id']; ?>" value="<?php echo $list['slug']; ?>" class="form-control" required>
			 </div>
			<div class="form-group">
				<label for="email">Description</label>
				   <textarea name="b_description" class="form-control textarea" cols="6" style="height: 120px;"><?php echo $list['b_description']; ?></textarea>
            </div>
            <div class="form-group">
			<label for="email">Image:</label>
						<input type="file" name="b_image1" class="form-control">
			<input type="hidden" name="blogimage" value="<?php echo $list['b_image']; ?>">
				<?php if($list['b_image']!=''){ ?><img src="<?php echo base_url();?>img/blog/<?php echo $list['b_image'];?>" width='100px' height='100px'>
			<?php } ?>

			 </div>
			<div class="form-group">
			<label for="email"> Meta Title:</label>
				<input type="text" name="b_meta_title" class="form-control" value="<?php echo $list['b_meta_title']; ?>">
            </div>
			<div class="form-group">
			<label for="email"> Meta Keywords:</label>
				<input type="text" name="b_meta_key" class="form-control" value="<?php echo $list['b_meta_key']; ?>">
            </div>
            <div class="form-group">
				<label for="email">Meta Description</label>
				   <textarea name="b_meta_description" class="form-control" cols="6" style="height: 120px;"><?php echo $list['b_meta_description']; ?></textarea>
            </div>

            <!-- <div class="form-group">
				<label for="email">Footer Meta Title </label>
				   <textarea name="footer_b_meta_title" class="form-control" cols="6" style="height: 120px;"><?php echo $list['footer_b_meta_title']; ?></textarea>
            </div>
            <div class="form-group">
				<label for="email">Footer Meta Keywords </label>
				   <textarea name="footer_b_meta_key" class="form-control" cols="6" style="height: 120px;"><?php echo $list['footer_b_meta_key']; ?></textarea>
            </div>
            <div class="form-group">
				<label for="email">Footer Meta Description</label>
				   <textarea name="footer_b_meta_description" class="form-control" cols="6" style="height: 120px;"><?php echo $list['footer_b_meta_description']; ?></textarea>
            </div> -->


						<input type="hidden" name="b_id"  value="<?php echo $list['b_id']; ?>" required class="form-control">
               </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn<?= $list['b_id']; ?>" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
			   </form>
            </div>
			
         </div>
      </div>
   </div>
</div>
<?php } ?>
<div class="modal fade in" id="add_blog">
   <div class="modal-body" >
      <div class="modal-dialog modal-lg">
	 
         <div class="modal-content">
         	
		  		<form method="post" id="add_blogsss" enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Add Blog</h4>
            </div>
            <div class="modal-body form_width100">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
			<div class="form-group">
				<label for="email"> Title:</label>
				<input type="text" name="b_title" onkeyup="create_slug(0,this.value);" id="b_title" class="form-control" >
			</div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug" id="slug0" class="form-control" required>
			 </div>
			<div class="form-group">
				<label for="email">Description</label>
				   <textarea name="b_description" class="form-control textarea" cols="6" style="height: 120px;"></textarea>
            </div>
            <div class="form-group">
			<label for="email">Image:</label>
			<input type="file" name="b_image" id="b_image" class="form-control">
			 </div>
			<div class="form-group">
			<label for="email"> Meta Title:</label>
				<input type="text" name="b_meta_title" id="b_meta_title" class="form-control" >
            </div>
			<div class="form-group">
			<label for="email"> Meta Keywords:</label>
				<input type="text" name="b_meta_key" id="b_meta_key" class="form-control" >
            </div>
            <div class="form-group">
				<label for="email">Meta Description</label>
				   <textarea name="b_meta_description" class="form-control" cols="6" style="height: 120px;"></textarea>
            </div>
            <!-- <div class="form-group">
				<label for="email">Footer Meta Title </label>
				   <textarea name="footer_b_meta_title" class="form-control" cols="6" style="height: 120px;"></textarea>
            </div>
            <div class="form-group">
				<label for="email">Footer Meta Keywords </label>
				   <textarea name="footer_b_meta_key" class="form-control" cols="6" style="height: 120px;"></textarea>
            </div>
            <div class="form-group">
				<label for="email">Footer Meta Description</label>
				   <textarea name="footer_b_meta_description" class="form-control" cols="6" style="height: 120px;"></textarea>
            </div> -->
            <div class="modal-footer">
				<button type="submit" class="btn btn-info signup_btn" >Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			   </form>
            </div>
			
         </div>
      </div>
   </div>
 </div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_blogsss").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Blog/add_blog',
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
function create_slug(id,v){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/slug/create_blog_slug/'+id,
		data:{title:v},
		async:false,
		success:function(res){
			$('#slug'+id).val(res);
		}
	})
}
function edit_count(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Blog/edit_blog/',
		data: new FormData($('#edit_count'+id)[0]),
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
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

<script>
tinymce.init({
  selector: '.textarea',
  height:480,
  plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
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
</script> 
<?php include_once('include/footer.php'); ?>