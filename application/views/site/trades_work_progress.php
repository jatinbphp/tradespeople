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

             <?php echo $this->session->flashdata('success1');  ?>
                  <div class="user-right-side">
                    <h1>Work In Progress</h1>
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
				<th style="width: 97px;">Postcode / Distance</th>
        <th>Status</th>
        <th>Action</th>
                </tr>
              </thead>
    <tbody>
      <?php 
                foreach($work_progress as $key=>$list) { 
                  $get_job_detail=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$list['job_id']));
									$get_users=$this->common_model->GetColumnName('users',array('id'=>$get_job_detail['userid']),array('f_name','l_name')); 
						$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['bid_by']),array('trading_name'));
                ?>
      <tr>
        <td style="display: none;"><?php  echo $key+1; ?></td>
                  <td><?php echo $get_job_detail['project_id']; ?></td>
                  <td>
										<?php
										if($get_job_detail['direct_hired']==1){
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
                  <td><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></td>
									
									<?php if($show_buget==1){ ?>
										 <td><?php echo ($get_job_detail['budget'])?'£'.$get_job_detail['budget']:''; ?><?php echo ($get_job_detail['budget2'])?' - £'.$get_job_detail['budget2']:''; ?></td>
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
                    <td>
										<?php if($get_job_detail['status']==7){?>
					
										<a class="btn btn-anil_btn" href="<?php echo base_url('payments?post_id='.$get_job_detail['job_id']); ?>">View milestones</a> 
										
										<?php } else { ?>
										
										<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$get_job_detail['job_id']); ?>">View Quotes</a>
										
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
        </div>
</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>
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
</script>
<script>
//setInterval(function(){ get_chat_history_interwal(); }, 5000);
</script>
<?php include 'include/footer.php'; ?>
  