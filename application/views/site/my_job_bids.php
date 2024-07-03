<?php include 'include/header.php'; ?>
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
<div class="acount-page membership-page">
<div class="container">
    	<div class="user-setting">
        	<div class="row">
            	<div class="col-sm-3">
                	<?php include 'include/sidebar.php'; ?>         
                </div>
            	<div class="col-sm-9">
                  <div id="msg"><?= $this->session->flashdata('msg'); ?></div>
                	<div class="user-right-side">
                    	<h1>Job Bids</h1> 
                            <div class="setbox2">
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
                  <th>Category</th>
                  <th>Posted By</th>
                  <th>Budget</th>
                  <th>Duration</th>
                  <th>Description</th>
                  <th>Status</th>
                  <td>Action</td>
                </tr>
              </thead>
              <tbody>
     <?php 
                foreach($bids as $key=>$list) {
                  $get_jobs_detail=$this->common_model->get_job_details($list['job_id']);
                ?>
                <tr>
                  <td><?php  echo $key+1; ?></td>
                   <td><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php   echo $get_jobs_detail[0]['title']; ?></a></td>
                  <td><?php $get_category=$this->common_model->get_category('category',$get_jobs_detail[0]['category']); echo $get_category[0]['cat_name']; ?></td>
                  <td><?php $get_user=$this->common_model->get_single_data('users',array('id'=>$list['posted_by'])); echo $get_user['f_name'].' '.$get_user['l_name']; ?></td>
                  <td><i class="fa fa-gbp"></i><?php echo $list['bid_amount'];  ?></td>
                  <td><?php echo $list['delivery_days'].' days';  ?></td>
                  <td><?php $len=strlen($list['propose_description']); if($len>100){
                     echo substr($list['propose_description'],0,100); ?>  <a href="javascript:void(0);" class="btn btn-warning btn-xs"  data-toggle="modal" data-target="#add_category<?php echo $list['id']; ?>">Read More</a><?php
                    } else{ echo $list['propose_description']; } ?></td>
                  <td><?php if($get_jobs_detail[0]['status']==0 || $get_jobs_detail[0]['status']==1 || $get_jobs_detail[0]['status']==3 ){ ?><span class="label label-success">Open</span><?php } if($get_jobs_detail[0]['status']==4){?><span class="label label-success">In Progress</span><?php }if($get_jobs_detail[0]['status']==5){ ?><span class="label label-success">Completed</span><?php }if($get_jobs_detail[0]['status']==7){ ?><span class="label label-success">Closed</span><?php } if($list['status']==8){?><span class="label label-danger">Rejected Award</span><?php } ?></td>
               <td>
                    <a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>" class="btn btn-info btn-xs">View Now</a>  
                        </td>
          </tr> 
                   <div class="modal fade popup" id="create_miles<?php echo $list['job_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Create Milestones</h4>
                    </div>
                    <div id="msg"><?= $this->session->flashdata('msg'); ?></div>
                     <form method="post" id="post_mile<?php echo $list['job_id']; ?>" enctype="multipart/form-data"  onsubmit="return update_milestones(<?php echo $list['job_id']; ?>);">
                      <div class="modal-body">
                        <fieldset>
                         <div id="milessss">
                    <div class="row">
          <div class="col-sm-8">
            <div class="from-group">
             <input type="text" class="form-control miname_1" name="tsm_name1" placeholder="Project Milestone" >
            </div>
          </div>
          <div class="col-sm-4">
            <div class="from-group">
              <input type="hidden" name="total_bids_amount" id="total_bids_amount" value="<?php echo $list['bid_amount']; ?>">
           <input type="number" class="form-control miamount_1" placeholder="Project Amount" min="1" name="tsm_amount1">
            </div>
          </div>
        </div>
        </div> 
        <div class="input-append1">
          <div id="fields">
                     <input type="hidden" name="post_id" id="post_id" value="<?php echo $list['id']; ?>">
                         <input type="hidden" name="bid_by" id="bid_by" value="<?php echo $list['bid_by']; ?>">
                         <input type="hidden" name="amounts" id="amounts" value="<?php echo $list['bid_amount']; ?>">
        </div>
      </div>
        <div class="from-group" style="display: none;">
          <a href="javascript:void(0);" class="btn btn-primary" onclick="add_more_miles1();">Add another milestone </a>
        </div>
                
                        </fieldset>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning submit_btn5">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
                                  <div class="modal fade in" id="add_category<?php echo $list['id']; ?>">
   <div class="modal-body" >
      <div class="modal-dialog">
   
         <div class="modal-content">
          
     
            <div class="modal-header">
              <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Description</h4>
            </div>
            <div class="modal-body form_width100">
    
 <p> <?php echo $list['propose_description']; ?></p>
             </div>
               <div class="modal-footer">
 
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
 
            </div>
      
         </div>
      </div>
   </div>
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
        </div>
</div>

</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>  
    $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});
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
<script>
  function update_milestones(id){
  $.ajax({
    type:'POST',
    url:site_url+'posts/update_milestones/'+id,
    data:$('#post_mile'+id).serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('#msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
        location.reload();
         
      } else {
        $('#msg').html(resp.msg);
      }
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

</script>
<?php include 'include/footer.php'; ?>
	