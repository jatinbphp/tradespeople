<?php 
include_once('include/header.php');
if(!in_array(3,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
  	<?php $seg=$this->uri->segment(2);

  	 $get_cat=$this->Common_model->get_single_data('category',array('cat_id'=>$seg));  ?>
  
    <h1>Child Category of <?php echo $get_cat['cat_name']; ?></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Child Category</li>
		</ol>
	  
  </section>
  <section class="content-header text-right">
    <a href="<?php echo base_url('category'); ?>" class="btn btn-success">Back</a> 
	
  </section>
  <section class="content">   
    <div class="row"> 
      <div class="col-xs-12">
		
        <div class="box">

         
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
									<th>Category</th>
									<th>Slug</th>
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
									<td><?php echo $list['cat_name']; ?></td>
									<td><?php echo $list['slug']; ?></td>
									<td>
										<?php if($list['cat_image']!=''){ ?>
										<img  id="image-id-<?php echo $list['cat_id']; ?>" src="<?php echo base_url();?>img/category/<?php echo $list['cat_image'];?>" width='100px' height='100px'>
										<?php } ?>
									</td>	
									<td>   
										<a href="<?php echo site_url($list['slug']);?>" target="_blank" class="btn btn-warning btn-xs">View Category</a>
										<a href="<?php echo base_url('child_category/'.$list['cat_id']); ?>" class="btn btn-info btn-xs">Child Category</a> 
											<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_category<?php echo $list['cat_id']; ?>" class="btn btn-success btn-xs">Edit</a> 
										 <a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Admin/delete_cat/'.$list['cat_id']); ?>" onclick="return confirm('Are you sure! you want to delete this category?');">Delete</a> 
								<?php if($list['cat_image']!=''){ ?>
										<a id="image-remove-btn-<?php echo $list['cat_id']; ?>" class="btn btn-primary btn-xs" href="" onclick="return remove_category_image(<?php echo $list['cat_id']; ?>,'<?php echo $list['cat_image']; ?>');">Delete image</a>
										<?php } ?>
					  

					</td>
					</tr> 
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
<?php 
$newCategory = getParent();
foreach($listing as $key=>$list) {
//$where=array('id'=>$list['cat_id']);
//$recordbyid=recordbyid('category',$where);

?>

<div class="modal fade in" id="edit_category<?php echo $list['cat_id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">

				<form onsubmit="return edit_category(<?= $list['cat_id']; ?>);" id="edit_category1<?= $list['cat_id']; ?>" method="post"  enctype="multipart/form-data">
					<div class="modal-header">
						<div class="editmsg<?= $list['cat_id']; ?>" id="editmsg<?= $list['cat_id']; ?>"></div>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Edit Category</h4>
					</div>
					<div class="modal-body">
			
										<div class="form-group">
							<label for="email"> Select category:</label>
							<select type="text" name="cat_parent1" id="cat_parent<?php echo $list['cat_id']; ?>"  class="form-control" onchange="InsertTitle(this,'title_ft<?=$list['cat_id']?>',<?=$list['cat_id']?>)">
							
								<?php
								
								
								foreach($newCategory as $newCategoryKey => $newCategoryVal){
									$newCategoryselected = ($newCategoryVal['cat_id']==$list['cat_parent']) ? 'selected' : '';
								?>
								
								<optgroup label="<?php echo $newCategoryVal['cat_name']; ?>">
									<option <?php echo $newCategoryselected; ?> value="<?php echo $newCategoryVal['cat_id']; ?>"><?php echo $newCategoryVal['cat_name']; ?> (Main)</option>
									<?php
									if(!empty($newCategoryVal['child'])){
										foreach($newCategoryVal['child'] as $childKey => $childVal){
											
											$childCategoryselected = ($childVal['cat_id']==$list['cat_parent']) ? 'selected' : '';
											?>
											<option <?php echo $childCategoryselected; ?> value="<?php echo $childVal['cat_id']; ?>"><?php echo $childVal['cat_name']; ?></option>
											<?php
										}
										
									}
									?>
									
								</optgroup>
									
								<?php } ?>
								
								<option value=''>select</option>
								<?php /*foreach($category as $categorylistss){ if($list['cat_parent']!=0){ if($categorylistss['cat_id']!=$list['cat_id']){ ?>
								<option value='<?php echo $categorylistss['cat_id']; ?>' <?php if($list['cat_parent']==$categorylistss['cat_id']){ echo "selected"; } ?>><?php  echo $categorylistss['cat_name']; ?></option>
								<?php } }else { if($categorylistss['cat_id']!=$list['cat_id']){ ?><option value='<?php echo $categorylistss['cat_id']; ?>' <?php if($list['cat_parent']==$categorylistss['cat_id']){ echo "selected"; } ?>><?php  echo $categorylistss['cat_name']; ?></option><?php } } } */ ?>
							</select>
						</div>
			<div class="form-group">
				<label for="email"> Category Name:</label>
				<input type="text" onkeyup="create_slug(<?php echo $list['cat_id']; ?>,this.value);" name="cat_name1" id="cat_name<?php echo $list['cat_id']; ?>"  value="<?php echo $list['cat_name']; ?>" required class="form-control" >
			 </div>
			 <div class="form-group utitle_ft title_ft<?=$list['cat_id']?>">
				<label for="email"> Category title for find tradesmen page:</label>
				<input type="text" name="title_ft1" id="title_ft<?php echo $list['cat_id']; ?>"  value="<?php echo $list['title_ft']; ?>" required class="form-control" >
			 </div>
			<div class="form-group">
				<label for="email"> Slug:</label>
				<input type="text" name="slug1" id="slug<?php echo $list['cat_id']; ?>"  value="<?php echo $list['slug']; ?>" required class="form-control" >
				<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
			 </div>
				 	 <div class="form-group">
				<label for="email"> Description:</label>
				<textarea rows="5" placeholder="" name="cat_description1" id="cat_description<?php echo $list['cat_id']; ?>" class="form-control"><?php echo $list['cat_description']; ?></textarea>
			 </div>
				 	 <div class="form-group">
				<label for="email"> Description (For find job page):</label>
				<textarea rows="5" placeholder="" name="description" id="description<?php echo $list['cat_id']; ?>" class="form-control"><?php echo $list['description']; ?></textarea>
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Title:</label>
				<input type="text" name="meta_title1" id="meta_title<?php echo $list['cat_id']; ?>" class="form-control" value="<?php echo $list['meta_title']; ?>">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Keywords:</label>
				<input type="text" name="meta_key1" id="meta_key<?php echo $list['cat_id']; ?>" class="form-control" value="<?php echo $list['meta_key']; ?>">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Description:</label>
				<textarea rows="5" placeholder="" name="meta_description1" id="meta_description<?php echo $list['cat_id']; ?>" class="form-control"><?php echo $list['meta_description']; ?></textarea>
			 </div>

			 <div class="form-group">
				<label for="email"> Footer Description:</label>
				<textarea rows="5" placeholder="" name="child_footer_description1" id="child_footer_description1<?php echo $list['cat_id']; ?>" class="form-control textarea"><?php echo $list['child_footer_description1']; ?></textarea>
			 </div>


			 <?php /*
			 <div class="form-group">
				<label for="email"> Meta Title (For find job page):</label>
				<input type="text" name="meta_title2" id="meta_title-<?php echo $list['cat_id']; ?>" class="form-control" value="<?php echo $list['meta_title2']; ?>">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Keywords (For find job page):</label>
				<input type="text" name="meta_key2" id="meta_key-<?php echo $list['cat_id']; ?>" class="form-control" value="<?php echo $list['meta_key2']; ?>">
			 </div>
			 <div class="form-group">
				<label for="email"> Meta Description (For find job page):</label>
				<textarea rows="5" placeholder="" name="meta_description2" id="meta_description-<?php echo $list['cat_id']; ?>" class="form-control"><?php echo $list['meta_description2']; ?></textarea>
			 </div> */ ?>
			 <div class="form-group">
				<label for="email"> Thumbnail Image:</label>
			<input type="file" name="cat_image1" id="cat_image<?php echo $list['cat_id']; ?>" class="form-control">
			<input type="hidden" name="catimage" id="catimage<?php echo $list['cat_id']; ?>" value="<?php echo $list['cat_image']; ?>">
				
			 </div>

			 
             </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn<?= $list['cat_id']; ?>" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
			   </form>
            </div>
			
         </div>
      </div>
   </div>
</div>
<?php } ?>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

<script>
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
</script>	
<script>
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
				$('.edit_btn'+id).prop('disabled',false);
				$('.edit_btn'+id).html('Save');
				$('.editmsg'+id).html(resp.msg);
			}
		}
	});
	return false;  
}


function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('boottable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>    


<script>
function seepreview(id){
	var fileUploads = $("#image"+id)[0];
	var reader = new FileReader();
	reader.readAsDataURL(fileUploads.files[0]);
	reader.onload = function (e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function () {
			var height = this.height;
			var width = this.width;
				$('#imgpreview'+id).attr('src', image.src);	
				$('#imgpreview'+id).show();
		}
	}   
	
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


function InsertTitle(elem , clsname=null) {
	var parent = $(elem).val();
	
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
  </script>
	
	<?php include_once('include/footer.php'); ?>