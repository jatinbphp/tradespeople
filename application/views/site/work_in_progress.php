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
					
					<?php if($this->uri->segment(1)=='jobs-completed'){ ?>
						<h1>Completed Jobs</h1>
					<?php }else if($this->uri->segment(1)=='jobs-rejected'){ ?>
						<h1>Rejected Jobs</h1>
					<?php }else if($this->uri->segment(1)=='new_jobs'){ ?>
						<h1>New Jobs</h1>
					<?php }else{ ?>
						<h1>Work In Progress</h1> 
					<?php } ?> 
					<div class="setbox2">
						<?php if($this->session->flashdata('error')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
            <?php } ?>
						<div class="table-responsive">
							<?php if($this->uri->segment(1)=='new_jobs'){ ?>
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="display: none;"></th>
										<th>Job Id</th> 
										<th>Job Title</th>
										<th>Bids</th>
										<?php if($show_buget==1){ ?>
										<th>Budget</th>
										<?php } ?>
										<th>Average Bid</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php  
									$get_commision=$this->common_model->get_commision(); 
									$closed_date=$get_commision[0]['closed_date'];  
									foreach($posts1 as $key=>$list) {
									?>
									<tr>
										<?php
										$datesss= date('Y-m-d', strtotime($list['c_date']. ' + '.$closed_date.' days')); ?>
										<td style="display: none;"><?php  echo $key+1; ?></td>
										<td><?php  echo $list['project_id']; ?></td>
										<td>
										<?php
										if($list['direct_hired']==1){
												$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['awarded_to']),array('trading_name'));
												$job_title = 'Work for '.$tradesment['trading_name'];
												} else {
												$job_title = $list['title'];
										 }
										?>
										<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
										
										</td>
										<td><?php $get_total_bids=$this->common_model->get_total_bids($this->session->userdata('user_id'),$list['job_id']); echo $get_total_bids[0]['bids']; ?></td>
										<?php if($show_buget==1){ ?>
										<td><?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?></td>
										<?php } ?>
										<td><i class="fa fa-gbp"></i><?php $get_avg_bid=$this->common_model->get_avg_bid($this->session->userdata('user_id'),$list['job_id']); if($get_avg_bid[0]['average_amt']){ ?><?php echo number_format($get_avg_bid[0]['average_amt'],2); } else { echo "0"; } ?> GBP


										</td>
									
										<td>
											<?php if($list['status']==7){?>
								
											<a class="btn btn-anil_btn" href="<?php echo base_url('payments?post_id='.$list['job_id']); ?>">View milestones</a> 
											
											<?php } else { ?>
											
											<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a>
											
											<?php } ?>
											<?php /*
											<?php if($list['status']==0){ ?>
											<a href="<?php echo base_url(); ?>posts/approve_post/<?php echo $list['job_id'];?>/1" onclick="return confirm('Are you sure! you want to approve this post?');" class="btn btn-success btn-xs">Approve</a>  
											<?php }  ?>
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
													<span class="caret"></span></button>
													<ul class="dropdown-menu" style="text-align: left;">
														<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a></li>
														<li><a href="<?php echo site_url('posts/delete_post/'.$list['job_id']); ?>" onclick="return confirm('Are you sure! you want to delete this post?');">Delete</a></li>
														<li><a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_post<?php echo $list['job_id']; ?>" >Upgrade</a></li>
														<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">Chat</a></li>
														<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">Award</a></li>
													</ul>
											</div>
											*/ ?>
										</td>
									</tr> 
									<?php  } ?>
								</tbody>
							</table>

							<?php }else if($this->uri->segment(1)=='jobs-rejected'){ ?>


							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="display: none;"></th>
										<th>Job Id</th> 
										<th>Job Title</th>
										<th>Bids</th>
										<?php if($show_buget==1){ ?>
										<th>Budget</th>
										<?php } ?>
										<th>Average Bid</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php  
									$get_commision=$this->common_model->get_commision(); 
								 
									foreach($posts as $key=>$list) {
									?>
									<tr>
										
										<td style="display: none;"><?php  echo $key+1; ?></td>
										<td><?php  echo $list['project_id']; ?></td>
										<td>
											<?php
											if($list['direct_hired']==1){
												$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['awarded_to']),array('trading_name'));
												$job_title = 'Work for '.$tradesment['trading_name'];
												} else {
												$job_title = $list['title'];
										 }
										?>
											<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
										</td>
										<td><?php $get_total_bids=$this->common_model->get_total_bids($this->session->userdata('user_id'),$list['job_id']); echo $get_total_bids[0]['bids']; ?></td>
										<?php if($show_buget==1){ ?>
										<td><?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?></td>
										<?php } ?>
										<td><i class="fa fa-gbp"></i><?php $get_avg_bid=$this->common_model->get_avg_bid($this->session->userdata('user_id'),$list['job_id']); if($get_avg_bid[0]['average_amt']){ ?><?php echo number_format($get_avg_bid[0]['average_amt'],2); } else { echo "0"; } ?> GBP


										</td>
										
										<td>
										<a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a>
											
											<?php /*
											<?php if($list['status']==0){ ?>
											<a href="<?php echo base_url(); ?>posts/approve_post/<?php echo $list['job_id'];?>/1" onclick="return confirm('Are you sure! you want to approve this post?');" class="btn btn-success btn-xs">Approve</a>  
											<?php }  ?>
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
													<span class="caret"></span></button>
													<ul class="dropdown-menu" style="text-align: left;">
														<li><a href="<?php echo base_url('proposals?post_id='.$list['job_id'].'&re_open=1'); ?>">Re-open</a></li>
														<li><a href="<?php echo site_url('posts/delete_post/'.$list['job_id']); ?>" onclick="return confirm('Are you sure! you want to delete this post?');">Delete</a></li>

													</ul>
											</div>
											*/ ?>
										</td>
									</tr> 
									<?php  } ?>
								</tbody>
							</table>

							<?php } else { ?>


							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th style="display: none;"></th>
										<th>Job Id</th> 
										<th>Job Title</th>
										<th>Quotes By</th>
										<th>Quotes Amount</th>
										<th>Deliver In</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
							<?php 
                foreach($posts as $key=>$list) {
                ?>
                <tr>
                  <td style="display: none;"><?php  echo $key+1; ?></td>
                  <td><?php echo $list['project_id']; ?></td>
                  <td>
											<?php
											if($list['direct_hired']==1){
												$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['awarded_to']),array('trading_name'));
												$job_title = 'Work for '.$tradesment['trading_name'];
												} else {
												$job_title = $list['title'];
											}
											?>
										<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
									</td>
         
                  <td>
										<?php 
										//$get_job_bids=$this->common_model->get_job_bids('tbl_jobpost_bids',$list['job_id'],$this->session->userdata('user_id')); 
										
										$get_job_bids=$this->common_model->GetColumnName('tbl_jobpost_bids',"posted_by=".$user_data['id']." and (status=7 or status=3 or status=4 or status=8) and job_id=".$list['job_id']."",array('bid_by','bid_amount','delivery_days'));
										
										$get_users=$this->common_model->get_single_data('users',array('id'=>$get_job_bids['bid_by']));
										
										echo $get_users['trading_name']; 
										?>
									</td>
                  <td><?php if($get_job_bids['bid_amount']){ ?><i class="fa fa-gbp"></i><?php echo $get_job_bids['bid_amount'];  } else{ ?><i class="fa fa-gbp"></i><?php echo "0"; } ?> </td>
                  <td><?php if($get_job_bids['delivery_days']){ echo $get_job_bids['delivery_days'].' in day(s)'; } ?></td>
                         
                   
                    <td>
										<a class="btn btn-anil_btn" href="<?php echo base_url('payments?post_id='.$list['job_id']); ?>">View milestone</a>
									        
                       
                    </td>
						
					</tr> 
          <?php 
        }
        
        ?>
              </tbody>
            </table>
							<?php } ?>
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
//setInterval(function(){ get_chat_history_interwal(); }, 5000);

</script>
<?php include 'include/footer.php'; ?>
  