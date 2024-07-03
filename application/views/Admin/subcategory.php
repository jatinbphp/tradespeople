<?php 
include_once('include/header.php');
if(!in_array(3,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>SubCategory Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">SubCategory Management</li>
		</ol>
	  
  </section>
  <section class="content">   
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_subcategory" class="btn btn-success pull-right">Add SubCategory</a>  
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
									<th>Main Category</th>
									<th>SubCategory Name</th>
									<th>Create Date</th>
									<th>Update Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 			  
								foreach($listing as $key=>$list) {
									$get_cat_name=$this->Common_model->getRows('category',$list['cat_parent']);  
								?>
								<tr>
									<td><?php  echo $key+1; ?></td>
									<td><?php echo $get_cat_name['category_name']; ?></td>
									<td><?php echo $list['cat_name']; ?></td>
									<td><?php echo $list['cat_create']; ?></td>
									<td><?php echo $list['cat_update']; ?> </td>
									<td>   
										<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_allsubcat<?php echo $list['cat_id']; ?>" class="btn btn-success btn-xs">Edit</a> 
										<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Admin/delete_subcat/'.$list['cat_id']); ?>" onclick="return confirm('Are you sure! you want to delete this subcategory?');">Delete</a>
					



									</td>
								</tr> 
								<?php  } ?>
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

?>
<div class="modal fade in" id="edit_allsubcat<?php echo $list['cat_id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">
				<form method="POST" action="<?php echo site_url('Admin/Admin/update_subcat/'.$list['cat_id']); ?>" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Edit SubCategory</h4>
					</div>
					<div class="modal-body form_width100">
			
			
						<div class="form-group">
							<label for="email"> Select category:</label>
							<select type="text" name="category"  required class="form-control" >
								<option value=''>select</option>
								<?php foreach($categorylist as $categorylistss){?>
								<option value='<?php echo $categorylistss['id'];?>' <?php if($categorylistss['id']==$list['cat_parent']){?> selected <?php }?>><?php echo $categorylistss['category_name'];?></option>
								<?php } ?>
							</select>  
						</div>  
				 
			
			
						<div class="form-group">
							<label for="email">SubCategory Name:</label>
							<input type="text" name="cat_name" value="<?php echo $list['cat_name']; ?>" required class="form-control" >
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info" >Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

<?php } ?>
<div class="modal fade in" id="add_subcategory">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">
				<form method="POST" action="<?php echo site_url('Admin/Admin/add_subcategory'); ?>"  enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Add SubCategory</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="form-group">
							<label for="email"> Select category:</label>
							<select type="text" name="category"  required class="form-control" >
								<option value=''>select</option>
								<?php foreach($categorylist as $categorylistss){?>
								<option value='<?php echo $categorylistss['id'];?>'><?php echo $categorylistss['category_name'];?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label for="email"> SubCategory Name:</label>
							<input type="text" name="cat_name"  required class="form-control" >
						</div>
						</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info" >Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>

<?php include_once('include/footer.php'); ?>
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
			$('#imgpreview'+id).show();
				$('#imgpreview'+id).attr('src', image.src);	
				$('#imgpreview'+id).show();
		}
	}   
	
}

  </script>

  