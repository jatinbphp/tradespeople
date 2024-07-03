<?php 
include_once('include/header.php');
if(!in_array(6,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Country Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Country Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_county" class="btn btn-success">Add Country</a> 
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
					<th>County</th>
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
									<td><?php echo $list['region_name']; ?></td>
									<td>   
										<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_open<?php echo $list['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
										<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Region/delete_county/'.$list['id']); ?>" onclick="return confirm('Are you sure! you want to delete this County?');">Delete</a>
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

<div class="modal fade in" id="edit_open<?php echo $list['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">

				<form onsubmit="return edit_count(<?= $list['id']; ?>);" id="edit_count<?= $list['id']; ?>" method="post"  enctype="multipart/form-data">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					 <h4 class="modal-title">Edit County</h4>
				</div>
				<div class="modal-body">	
					<div class="editmsg<?= $list['id']; ?>" id="editmsg<?= $list['id']; ?>"></div>
					<div class="form-group">
						<label for="email"> Coutny Name:</label>
						<input type="text" name="region_name" id="cat_name1"  value="<?php echo $list['region_name']; ?>" required class="form-control" >
						<input type="hidden" name="county_id" id="cat_name1"  value="<?php echo $list['id']; ?>" required class="form-control">
					</div>
               </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn<?= $list['id']; ?>" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
			   </form>
            </div>
			
         </div>
      </div>
   </div>
</div>
<?php } ?>
<div class="modal fade in" id="add_county">
   <div class="modal-body" >
      <div class="modal-dialog">
	 
         <div class="modal-content">
         	
		  		<form method="post" id="add_county1" enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Add County</h4>
            </div>
            <div class="modal-body form_width100">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
			<div class="form-group">
				<label for="email"> County Name:</label>
				<input type="text" name="region_name" id="region_name" class="form-control" >
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
$("#add_county1").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Region/add_county',
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
     
function edit_count(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Region/add_county/',
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
<?php include_once('include/footer.php'); ?>

  


