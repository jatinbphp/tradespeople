<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Banner Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Banner Management</li>
		</ol>
	  
  </section>
<section class="content-header text-right">
    
	  <a href="javascript:void(0);"  data-toggle="modal" data-target="#add_blog" class="btn btn-success">Add Banner</a> 
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
										<th>Banner</th>
										<th>Day</th>
										<!-- <th>Start Date</th>
										<th>End Date</th> -->		
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
									<td><?php echo $key+1; ?></td>
									<td>
									<?php if($list['hb_banner']!=''){ ?><img src="<?php echo base_url();?>img/HomeBanner/<?php echo $list['hb_banner'];?>" width='100px' height='100px'>
									<?php } ?>
									</td>

									<td><?=$list['hb_day'];?></td>
									
									<!-- <td><?php echo ($list['start_date'])?date('d-m-Y',strtotime($list['start_date'])):'-'; ?></td>
									<td><?php echo ($list['end_date'])?date('d-m-Y',strtotime($list['end_date'])):'-'; ?></td> -->
									
									<td> 
										
										<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_open<?php echo $list['hb_id']; ?>" class="btn btn-success btn-xs">Edit</a>
										<?php if($list['hb_id']!=1){ ?>
										<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Admin/delete_homebanner/'.$list['hb_id']); ?>" onclick="return confirm('Are you sure! you want to delete this Banner?');">Delete</a> 
										 <a target="_blank" class="btn btn-primary btn-xs" href="<?php echo site_url().'?perview_banner='.$list['hb_id']; ?>">View</a>
										<?php } ?>
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

<div class="modal fade in" id="edit_open<?php echo $list['hb_id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">

				<form onsubmit="return edit_count(<?= $list['hb_id']; ?>);" id="edit_count<?= $list['hb_id']; ?>" method="post"  enctype="multipart/form-data">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					 <h4 class="modal-title">Edit banner</h4>
				</div>
				<div class="modal-body">	
					<div class="editmsg<?= $list['hb_id']; ?>" id="editmsg<?= $list['hb_id']; ?>"></div>
								<!-- <div class="form-group">
				<label for="email">Banner:</label>
				<input type="text" name="hb_banner" id="b_title" class="form-control" value="<?php echo $list['hb_banner']; ?>">
			</div> -->
            <div class="form-group">
			<label for="email">Banner:</label>
						<input type="file" name="hb_banner" id="b_image1" class="form-control">
						<p style="color:red;">Image dimension range should be in between 1920X750 to 1320X540 (Px)</p>
			<input type="hidden" name="bannerimage" id="bannerimage" value="<?php echo $list['hb_banner']; ?>">
				<?php if($list['hb_banner']!=''){ ?><img src="<?php echo base_url();?>img/HomeBanner/<?php echo $list['hb_banner'];?>" width='100px' height='100px'>
			    <?php } ?>

			 </div>

			<div class="form-group">
				<label for="email">Day:</label>
				<select required="" name='hb_day' class="form-control" required="">
					<?php if($list['hb_id']==1){ ?>
					<option value="Default">Default</option>
					<?php } else { ?>
					 <option value="">Select day</option>
					 <option value="Monday" <?=($list['hb_day']=='Monday')?'selected':''; ?>>Monday</option>
					 <option value="Tuesday" <?=($list['hb_day']=='Tuesday')?'selected':''; ?>>Tuesday</option>
					 <option value="Wednesday" <?=($list['hb_day']=='Wednesday')?'selected':''; ?>>Wednesday</option>
					 <option value="Thursday" <?=($list['hb_day']=='Thursday')?'selected':''; ?>>Thursday</option>
					 <option value="Friday" <?=($list['hb_day']=='Friday')?'selected':''; ?>>Friday</option>
					 <option value="Saturday" <?=($list['hb_day']=='Saturday')?'selected':''; ?>>Saturday</option>
					 <option value="Sunday" <?=($list['hb_day']=='Sunday')?'selected':''; ?>>Sunday</option>
				 <?php } ?>
				</select>
			</div>
			<!-- <div class="form-group">
				<label for="email"> Start Date:</label>
				<input type="date" onchange="change_date(this.value,<?php echo $list['hb_id']; ?>)" min="<?php echo date('Y-m-d');?>" name="start_date" id="start_date<?php echo $list['hb_id']; ?>" class="form-control" value="<?php echo ($list['start_date'])?$list['start_date']:''; ?>" required>
				</div>
			<div class="form-group">
				<label for="email"> End Date:</label>
				<input type="date" min="<?php echo date('Y-m-d');?>" name="end_date" id="end_date<?php echo $list['hb_id']; ?>" class="form-control" value="<?php echo ($list['end_date'])?$list['end_date']:''; ?>" required>
				</div> -->
           
			 <input type="hidden" name="hb_id" id="hb_id"  value="<?php echo $list['hb_id']; ?>" required class="form-control">
               </div>
               <div class="modal-footer">
				<button type="submit" class="btn btn-info edit_btn<?= $list['hb_id']; ?>" >Save</button>
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
      <div class="modal-dialog">
	 
         <div class="modal-content">
         	
		  <form method="post" id="add_blogsss" enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Add Banner</h4>
            </div>
            <div class="modal-body form_width100">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
            <div class="form-group">
			 <label for="email">Banner Image:</label>
			 <input type="file" name="hb_banner" id="hb_banner" class="form-control">
			 <p style="color:red;">Image dimension range should be in between 1920X750 to 1320X540 (Px)</p>
			</div>
			<div class="form-group">
				<label for="email">Day:</label>
				<select required="" name='hb_day' class="form-control">
					 <option value="">Select day</option>
					 <option value="Monday">Monday</option>
					 <option value="Tuesday">Tuesday</option>
					 <option value="Wednesday">Wednesday</option>
					 <option value="Thursday">Thursday</option>
					 <option value="Friday">Friday</option>
					 <option value="Saturday">Saturday</option>
					 <option value="Sunday">Sunday</option>
				</select>
			</div>
			<!-- <div class="form-group">
				<label for="email"> Start Date:</label>
				<input type="date" onchange="change_date(this.value,0)" min="<?php echo date('Y-m-d');?>" name="start_date" id="start_date0" class="form-control" value="<?php echo ($list['start_date'])?$list['start_date']:''; ?>" >
				</div>
			<div class="form-group">
				<label for="email"> End Date:</label>
				<input type="date" name="end_date" min="<?php echo date('Y-m-d');?>" id="end_date0" class="form-control" value="<?php echo ($list['end_date'])?$list['end_date']:''; ?>" >
				</div> -->

            <div class="modal-footer">
				<button type="submit" class="btn btn-info signup_btn" >Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
             </div>
		 </form>
            </div>
			
         </div>
      </div>
   </div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_blogsss").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/AddHomeBanner',
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
     
function edit_count(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/EditHomeBanner',
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

function change_date(date,id){
	$('#end_date'+id).html('');
	$('#end_date'+id).attr('min',date);
}
</script>
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
<?php include_once('include/footer.php'); ?>

  


