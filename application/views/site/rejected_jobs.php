<?php include ("include/header.php") ?>
<?php include ("include/top.php") ?>
<?php $page_name=$this->uri->segment(1); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
.table-responsive {
	overflow: auto;
}
@media (max-width:575.98px){
	.table-responsive-sm{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-sm>.table-bordered{
		border:0
	}
}
@media (max-width:767.98px){
	.table-responsive-md{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-md>.table-bordered{
		border:0
	}
}
@media (max-width:991.98px){
	.table-responsive-lg{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-lg>.table-bordered{
		border:0
	}
}
@media (max-width:1199.98px){
	.table-responsive-xl{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-xl>.table-bordered{
		border:0
	}
}


</style>

<div class="acount-page membership-page project-list">
     
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 style="font-size: 20px;"><b>Jobs</b></h3>
				<?php include("include/top_project.php") ?>
				<div class="acount-page membership-page">
					<div class="container">
						<div class="user-setting">
							<div class="row">
								<div class="col-sm-12">
                  <div class="user-right-side" style="margin-top: -30px;">
										<div class="setbox2">
											<?php if($this->session->flashdata('error1')) { ?>
											<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
											<?php } ?>
											<?php if($this->session->flashdata('success1')) { ?>
											<p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
											<?php } ?>
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
															<th>Job Id</th> 
															<th>Job Title</th>
															<th>Quotes</th>
															<?php if($show_buget==1){ ?>
															<th>Budget</th>
															<?php } ?>
															<th>Average Quote</th>
															<th style="display: none;">Category</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach($posts as $list) { ?>
														<tr>
															<td><?php  echo $list['project_id']; ?></td>
															<td><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $list['title']; ?></a></td>
															<td><?php $get_total_bids=$this->common_model->get_total_bids($this->session->userdata('user_id'),$list['job_id']); echo $get_total_bids[0]['bids']; ?></td>
															<?php if($show_buget==1){ ?>	
															<td><?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?></td>
															<?php } ?>
															<td><i class="fa fa-gbp"></i><?php $get_avg_bid=$this->common_model->	get_avg_bid($this->session->userdata('user_id'),$list['job_id']); echo number_format($get_avg_bid[0]['average_amt'],2); ?> GBP</td>
															<td style="display: none;">
															
															<?php
                        
																$selected_lang = explode(',',$list['category']);
																$cat_data='';
																foreach($category as $row) { 
																if(in_array($row['cat_id'],$selected_lang)) {
																	$cat_data .= $row['cat_name'].', ';
																}
																}  echo rtrim($cat_data,', '); ?>
															</td>
															<td>
																<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a>
																
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php /* foreach($posts as $list) { ?>
<div class="modal fade in" id="edit_post<?php echo $list['job_id']; ?>">
  <div class="modal-body" >
    <div class="modal-dialog">
   
      <div class="modal-content">

        <form onsubmit="return edit_post(<?= $list['job_id']; ?>);" id="edit_post1<?= $list['job_id']; ?>" method="post"  enctype="multipart/form-data">
          <div class="modal-header">
            <div class="editmsg<?= $list['job_id']; ?>" id="editmsg<?= $list['job_id']; ?>"></div>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             <h4 class="modal-title">Edit Posts</h4>
          </div>
          <div class="modal-body">
                    <div class="form-group">
        <label for="email"> Category:</label>
       <select data-placeholder="Select Category" class="form-control" name="category" onchange="return changecategory($(this).val(),<?php echo $list['job_id']; ?>)">
                       
                                       
                                                <?php  foreach($category as $row) { ?>
                          <option value="<?= $row['cat_id']; ?>" <?php if($list['category']==$row['cat_id']){ echo "selected"; } ?>> <?= $row['cat_name']; ?> </option>
                          <?php } ?>
                                          
                                            
                          </select>  
       </div>
                           <div class="form-group">
    
      <div id="subcategories<?php echo $list['job_id']; ?>">
               <label for="email"> Subcategory:</label>
                  <div class="row">
               <?php $data_set=$this->common_model->newgetRows('category',array('cat_parent'=>$list['category'])); 
               if($data_set)
                {
                  foreach($data_set as $subcategory){
               ?>
                <div class="col-sm-6"><?php if($subcategory['cat_id']==$list['subcategory']){ ?><input type="radio" name="subcategory" id="subcategory" checked value="<?php echo $subcategory['cat_id']; ?>"><?php echo $subcategory['cat_name']; ?><?php }else{ ?><input type="radio" name="subcategory" id="subcategory<?php echo $subcategory['cat_id']; ?>"  value="<?php echo $subcategory['cat_id']; ?>"><?php echo $subcategory['cat_name']; ?><?php } ?></div>
             <?php }  }else{ ?>

              <p class="alert alert-danger">No subcategories found for this category.</p>
             <?php } ?>
                 </div>
              
            </div> 
       </div>
      <div class="form-group">
        <label for="email"> Title:</label>
        <input type="text" name="title"  value="<?php echo $list['title']; ?>"  class="form-control" >
       </div>
           <div class="form-group">
        <label for="email"> Description:</label>
        <textarea rows="5" placeholder="" name="description" class="form-control"><?php echo $list['description']; ?></textarea>
       </div>
           <div class="form-group">
        <label for="email"> Document:</label>
        <input type="file" name="post_doc[]" id="post_doc" multiple>
       </div>
           <div class="form-group">
               
        <?php 
        $attachment=$this->common_model->get_all_files($list['job_id']);
        if($attachment){
      foreach ($attachment as $doc) {
        ?>
        <div id="del_doc<?php echo $doc['id']; ?>">
             <div class="row">
          <div class="col-sm-4">
          <a href="<?php echo base_url('img/jobs/'.$doc['post_doc']); ?>" download><i class="fa fa-paperclip"></i> <?php echo $doc['post_doc']; ?></a>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-danger btn-xs" onclick="delenquiry(<?php echo $doc['id'];?>)"><i class="fa fa-close"></i></button> 
          </div>
            </div>
        </div>

        
        <?php
      } }
     ?>
   
       </div>

       <div class="form-group">
       <input type="number" name="price" id="price" class="form-control" value="<?php echo $list['budget']; ?>">
       </div>
             <div class="form-group">
        <label for="email"> Postcode:</label>
        <input type="text" name="post_code"  value="<?php echo $list['post_code']; ?>"  class="form-control" >
       </div>


       
             </div>
               <div class="modal-footer">
        <button type="submit" class="btn btn-primary edit_btn<?= $list['cat_id']; ?>" >Save</button>
                  <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
               </div>
         </form>
			</div>
      
		</div>
	</div>
</div>
<?php }*/ ?>

                       
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>  
  /*  $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});*/
  $(function(){
    $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
  </script>
<script>/*
function changecategory(val,id)
{

  $.ajax({
      url:site_url+'home/get_subcategory',
      type:"POST",
      dataType:'json',
      data:{'val':val,'id':id},
      success:function(datas)
      {
      
          $('#subcategories'+id).html(datas.subcategory);
  
        return false;
      }
  });
  return false;
}
  $(function(){
  
  $("#geocomplete").geocomplete({
    details: "form",
    types: ["geocode", "establishment"],
  });
  $("#find").click(function(){
    $("#geocomplete").trigger("geocode");
  });
});
  function update_profile(){
  $('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
  $('.submit_btn').prop('disabled',true);
}
function getcity(val)
{
  $.ajax({
      url:site_url+'home/get_city',
      type:"POST",
      dataType:'json',
      data:{'val':val},
      success:function(datas)
      {
      
       $('#city').html(datas.cities);
  
        return false;
      }
  });
  return false;
  
}
function edit_post(id){
  $.ajax({
   type:'POST',
    url:site_url+'posts/edit_post/'+id,
   data: new FormData($('#edit_post1'+id)[0]),
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
      }
      else if(resp.status==2)
      {
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
function delenquiry(id) {
   if (confirm("Are you sure?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_file/'+id,
            dataType: 'JSON',
             success:function(resp){
              $('#del_doc'+id).remove();
            } 
        });
    } 
  }
*/
</script>
<?php include 'include/footer.php'; ?>