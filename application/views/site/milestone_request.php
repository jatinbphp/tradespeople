<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style>
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
<?php if($this->session->userdata('type')==1){ ?>
<div class="acount-page membership-page">
<div class="container">
    	<div class="user-setting">
        	<div class="row">
            	<div class="col-sm-3">
                	<?php include 'include/sidebar.php'; ?>         
                </div>
            	<div class="col-sm-9">
                	<div class="user-right-side">
                    	<h1>Your Milestone Requests</h1> 
                            <div class="setbox2">
                              <div class="table-responsive">
                                <?php  if($milestones){  ?>
                     <table id="boottable" class="table table-bordered table-striped">
            
    <thead>
      <tr>
        <th>S.no</th>
        <th>Title</th>
        <th>Milestone Name</th>
        <th>Milestone Amount</th>
        <th>Added</th>
        <th>Status</th>
      </tr>
    </thead>
   
    <tbody>
      <?php 
       $x=1;
                foreach($milestones as $key=>$list) {
                  $get_jobs_detail=$this->common_model->get_job_details($list['post_id']);
                ?>
      <tr>
             <td><?php echo $x; ?></td>
                 <td><a href="<?php echo base_url('payments/?post_id='.$list['post_id']); ?>"><?php   echo $get_jobs_detail[0]['title']; ?></a></td>
                 <td><?php echo $list['milestone_name']; ?></td>
                 <td><?php echo "£".$list['milestone_amount']." GBP"; ?></td>
        <td><?php $cdate=strtotime($list['cdate']); echo date('d',$cdate); echo ' '.date('M', $cdate); ?><br><?php  echo date('h:i A', strtotime($list['cdate'])); ?></td>
        <td><?php if($list['status']==0){ ?><span class="label label-success">Pending</span><?php }else if($list['status']==2){ ?><span class="label label-success">Released</span><?php }else if($list['status']==3){ ?><span class="label label-success">Requested</span><?php }  ?></td>
      
      </tr>
    <?php } ?>

    </tbody>
  </table>
<?php }else{ ?>
       <div class="verify-page">
                            <div class="message-block verification-message">
                                <p>You do not yet have any requested milestone to display.</p>
                            </div>
                        </div>
<?php } ?>
                              </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<?php }else{ ?>

                  <?php include 'include/top.php'; ?>     
  <div class="acount-page membership-page">
<div class="container">
      <div class="user-setting">
          <div class="row">
              <div class="col-sm-3" style="display: none;">    
                </div>
              <div class="col-sm-12">
                  <div class="user-right-side">
                      <h1>Projects Awaiting Feedback</h1> 
                            <div class="setbox2">
                                <?php if($this->session->flashdata('error1')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success1')) { ?>
            <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
            <?php } ?>
                              <div class="table-responsive">
                                <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
                  <th>S.No</th> 
                  <th>Project Name</th>
                  <th>To User</th>
                  <th>Leave Feedback</th>
                </tr>
              </thead>
              <tbody>
     <?php if($reviews){
                foreach($reviews as $key=>$list) {
                ?>
                <tr>
                  <td><?php  echo $key+1; ?></td>
                  <td><?php $get_jobs=$this->common_model->get_job_details($list['rt_jobid']); ?><a href="<?php echo base_url('job-detail/?post_id='.$list['rt_jobid']); ?>"><?php echo $get_jobs[0]['title']; ?></a></td>
                  <td><a href="<?php echo base_url('profile'.$list['rt_rateBy']) ?>"><?php $get_users=$this->common_model->get_single_data('users',array('id'=>$list['rt_rateBy'])); echo $get_users['f_name'].' '.$get_users['l_name']; ?></td>
                  <td><?php $get_job_bids=$this->common_model->get_post_bids('tbl_jobpost_bids',$list['rt_jobid'],$list['rt_rateBy']);?>
                  <?php  $ratecount=$this->common_model->get_rating($list['rt_jobid'],$this->session->userdata('user_id')); if($ratecount){ ?>
                     <button class="btn btn-success" style="margin-top: 10px;" onclick="viewRatingOnModal('<?php echo $list['rt_jobid']; ?>');">View Rating</button>
                  <?php }else{ ?>
                    <a href="#" data-target="#mark_as_complete<?php echo $list['rt_jobid']; ?>" data-toggle="modal"><button class="btn btn-warning" style="margin-top: 10px;">Rate Now</button></a>
                    <?php 
                  } ?>
                
                  </td>        
          </tr> 
            <div class="modal fade" id="viewRatingModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ratings</h4>
      </div>
      <div class="modal-body" id="viewRatingData">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>

                     <div class="modal fade popup" id="mark_as_complete<?php echo $list['rt_jobid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel" style="text-align: left">Mark as Complete</h4>
                </div>
                      <form method="post" id="marks_as_complete<?php echo $list['rt_jobid']; ?>" onsubmit="return mark_complete(<?php echo $list['rt_jobid']; ?>);">
                  <div class="modal-body">
                    <fieldset>
            
                      <!-- Text input-->
                      <div class="form-group">
                        <div class="col-md-12" style="text-align: left;">
                         <div class='rating-stars text-center'>
    <ul id='stars'>
      <li class='star' title='Poor' data-value='1'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' title='Fair' data-value='2'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' title='Good' data-value='3'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' title='Excellent' data-value='4'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' title='WOW!!!' data-value='5'>
        <i class='fa fa-star fa-fw'></i>
      </li>
    </ul>
    <input type="hidden" name="rt_rate" class="rating" value="0" required="" />
    <input type="hidden" name="bid_by" value="<?php echo $list['rt_rateBy']; ?>">
  </div>
                        </div>
                      </div>
                      <div class="form-group">
            <label>Feedback:</label>
            <textarea required class="form-control" name="rt_comment" required=""></textarea>
          </div>
                    </fieldset>
   
                  </div>
                    <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="wrbtn">Submit<i class="fa fa-spinner fa-spin wrbtnloader" style="font-size:24px;display:none;"></i></button>
        </div>
                </form>
              </div>
            </div>
          </div>
          <?php 
        } }else{ ?>
             <div class="verify-page">
                            <div class="message-block verification-message">
                                <p>No reviews found.</p>
                            </div>
                        </div>
        <?php }
        
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
<?php  } ?>
<script>  
    function viewRatingOnModal(job_id) {
  if(job_id) {
    
    $.ajax({
      type : 'POST',
      url:site_url+'posts/getRating',
      data :{job_id:job_id},
      dataType:'json',
      success :  function(response) { 
        $("#viewRatingModal").modal('show');
        $("#viewRatingData").html(response.data);
      }
    });
  }
  return false;
}
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
    function mark_complete(job_id)
  {
        $.ajax({
            type:'POST',
            url:site_url+'posts/mark_completed/'+job_id,
            dataType: 'JSON',
            data:$('#marks_as_complete'+job_id).serialize(),
             success:function(resp){
            if(resp.status==1)
           {
                                        
             location.reload();
           }
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
$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
 $('.rating').val(ratingValue);
    
  });
  
});
</script>
<?php include 'include/footer.php'; ?>
	