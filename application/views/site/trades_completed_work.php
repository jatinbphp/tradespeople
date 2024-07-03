<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <style type="text/css">
      .rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
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

                                    <?php if($this->session->flashdata('error1')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success1')) { ?>
            <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
            <?php } ?>
                  <div class="user-right-side">
                    <h1>Completed Jobs</h1>
                            <div class="setbox2">
  
                              <div class="table-responsive">
                      <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
       <th style="display: none;"></th>
        <th>Job Id</th> 
                  <th>Job Title</th>
        <th style="width: 120px;">Category</th>
        <th>Posted By</th>
				<?php if($show_buget==1){ ?>
        <th>Budget</th>
				<?php } ?>
				<th>Postcode / Distance</th>
        <th>Status</th>
        <!-- <th>Action</th> -->
                </tr>
              </thead>
    <tbody>
      <?php 
                foreach($completed as $key=>$list) { 
                  $get_job_detail=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$list['job_id']));
                ?>
      <tr>
        <td style="display: none;"><?php  echo $key+1; ?></td>
                  <td><?php echo $get_job_detail['project_id']; ?></td>
                  <td>
									
									<?php
										if($get_job_detail['direct_hired']==1){
												$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['bid_by']),array('trading_name'));
												$job_title = 'Work for '.$tradesment['trading_name'];
												} else {
												$job_title = $get_job_detail['title'];
										 }
										?>
									
										<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
									
									</td>
                   <td>      <?php
                        
                        $selected_lang = explode(',',$get_job_detail['category']);
                        $cat_data='';
                                                foreach($category as $row) { 
                                                    if(in_array($row['cat_id'],$selected_lang))
                                                    {
                                                     $cat_data .= $row['cat_name'].', ';
                                                    }
                                              }  echo rtrim($cat_data,', '); ?></td>
                  <td><?php $get_users=$this->common_model->get_single_data('users',array('id'=>$get_job_detail['userid'])); echo $get_users['f_name'].' '.$get_users['l_name']; ?></td>
									<?php if($show_buget==1){ ?>
									<?php echo ($get_job_detail['budget'])?'£'.$get_job_detail['budget']:''; ?><?php echo ($get_job_detail['budget2'])?' - £'.$get_job_detail['budget2']:''; ?></td>
									<?php } ?>
									<td>
									<?php 
									
									$len = (strlen($get_job_detail['post_code'])>=7)?4:3;
									
									echo strtoupper(substr($get_job_detail['post_code'],0,$len));
									
				$distance = getDistanceByLatLng($get_job_detail['latitude'],$get_job_detail['longitude'],$user_data['latitude'],$user_data['longitude']);
									
									
									
									echo '<br>'.$distance.' miles';
									
									?>
							</td>
                     <td> <?php if($list['status']==0 || $list['status']==1 || $list['status']==2){ ?><span class="label label-success">Open</span><?php } if($list['status']==7){ ?><span class="label label-success">In Progress</span><?php } if($list['status']==8){?><span class="label label-danger">Rejected Award</span><?php }if($list['status']==4){ ?><span class="label label-success">Completed</span><?php }if($list['status']==3){ ?><span class="label label-success">Awaiting Acceptance</span><?php } ?></td>
                     <td>  <?php if($list['status']==4){ ?><?php $ratecount=$this->common_model->get_rating($list['job_id'],$list['bid_by']); if(count($ratecount)==0){  ?> <a href="#" data-target="#mark_as_complete<?php echo $list['job_id']; ?>" data-toggle="modal"><button class="btn btn-success btn-xs">Leave Feedback</button></a><?php } else{  ?><a href="<?php echo base_url('reviews?post_id='.$list['job_id']); ?>"><button class="btn btn-primary btn-xs">View Feedback</button></a><?php } }?></td>
          <div class="modal fade popup" id="mark_as_complete<?php echo $list['job_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel" style="text-align: left">Please leave your feedback and rating for this job</h4>
                </div>
                      <form method="post" id="marks_as_complete<?php echo $list['job_id']; ?>" onsubmit="return mark_complete(<?php echo $list['job_id']; ?>);">
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
    <input type="hidden" name="bid_by" value="<?php echo $list['bid_by']; ?>">
    <input type="hidden" name="posted_by" value="<?php echo $list['posted_by']; ?>">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script> 
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
      } else {
        $('.edit_btn'+id).prop('disabled',false);
        $('.edit_btn'+id).html('Save');
        $('.editmsg'+id).html(resp.msg);
         location.reload();
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
  function get_chat_onclick(id,post)
{
    $.ajax({
    type:'POST',
    url:site_url+'chat/get_chats',
    data:{id:id,post:post},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#rid').val(id);
        $('#post_ids').val(post);
        $('#userdetail').html(resp.userdetail);
        var oldscrollHeight = $("#usermsg").prop("scrollHeight");         
          $('.user_chat').html(resp.data);  
        var newscrollHeight = $("#usermsg").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $("#usermsg").animate({
              scrollTop: newscrollHeight
          }, 'normal');
        }

      } 
                 else
      {
         $('#userdetail').html(resp.userdetail);
         $('.user_chat').html(resp.data); 
      }
 
    }
  });
  return false;

}
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
function showdiv()
{
   $('#chat_user').show();
  
}

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
function get_chat_history_interwal()
{
  var id = $('#rid').val();
   var post = $('#post_ids').val();
  if(id)
  {
    get_chat_onclick(id,post);
  }
}
function send_msg()
{
    var post='<?php echo $_REQUEST['post_id']; ?>';
  $.ajax({
    type:'POST',
     url:site_url+'chat/send_msg',
    data:$('#send_msg').serialize(),
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#ch_msg').val('');
      }
    }
  });
  return false;
}
function get_unread_msg_count(post_id, rid)
{
  
  $.ajax({
    type:'POST',
   url:site_url+'chat/get_unread_msg_count',
    data:{post:post_id,rid:rid},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.count_un_msg'+rid).html('('+resp.count+')');
            get_chat_onclick(rid,post_id);
        showdiv();
      }
      else
      {
        $('.count_un_msg'+rid).html('');
      }
    }
  });
  return false;
}
  function accept_award(id,status)
  {
           if (confirm("Are you sure you want to accept this awarded request?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/accept_award/'+id+'/'+status,
            dataType: 'JSON',
             success:function(resp){
            if(resp.status==1)
            {
              location.reload();
            }
            else
            {
              location.reload();
            }

            } 
        });
    } 
  }
</script>
<script>
setInterval(function(){ get_chat_history_interwal(); }, 5000);

</script>
<?php include 'include/footer.php'; ?>
  