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
			<div class="row" style="display:flex;flex-wrap: wrap;">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>         
				</div>
				<div class="col-sm-9" >
					<?php if($this->session->flashdata('error1')) { ?>
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
					<?php } ?>
					<?php if($this->session->flashdata('success1')) { ?>
					<p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
					<?php } ?>
					<?php echo $this->session->flashdata('my_msg'); ?>
					
					<div class="mjq-sh" style="height: 45px;"> 
						<h2>
							<strong>New Jobs</strong>
							<?php if($user_data['type']==1){ ?>
							<?php if($user_data['notification_status']==1){ ?>
							<a onclick="return confirm('Are you sure you want to stop receiving new job emails & sms notification?')" class="" href="<?php echo site_url().'users/update_notification_status/0?redirectUrl='.site_url().'recent-jobs'; ?>"><span class="always-hide-mobile btn btn-primary btn-xs">Deactivate job alerts</span></a>
							<?php } else { ?>
							<a onclick="return confirm('Are you sure you want to allow receiving new job emails & sms notification?')" href="<?php echo site_url().'users/update_notification_status/1?redirectUrl='.site_url().'recent-jobs'; ?>"><span class="always-hide-mobile btn btn-primary btn-xs">Activate job alerts</span></a>
							<?php } ?>
							<?php } ?>
							
						</h2>
                    
					</div>
					
					
				
					<?php if($this->session->flashdata('error')) { ?>
						
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
					<?php } ?>
							<?php if(!empty($bids)) { ?>
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
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$get_commision=$this->common_model->get_commision(); 
		$closed_date=$get_commision[0]['closed_date'];


		foreach($bids as $key=>$list) {
		
		$get_user=$this->common_model->get_single_data('users',array('id'=>$list['userid']));
		
		if($get_user){
		
		$get_trades=$this->common_model->get_trades_status($this->session->userdata('user_id'),$list['job_id']);
		$date111=date('Y-m-d H:i:s');
		$dates12= date('Y-m-d H:i:s', strtotime($date111. ' + 7 days'));
		
		if(empty($get_trades) && (date('Y-m-d H:i:s')< $dates12)){
		
		$datesss= date('Y-m-d H:i:s', strtotime($list['c_date']. ' + '.$closed_date.' days'));
		

		?>
		<tr>
			<td style="display: none;"><?php  echo $key+1; ?></td>
			<td><?php echo $list['project_id']; ?></td>
			<td><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php   echo $list['title']; ?></a>
			</td>
			<td><?php $get_category=$this->common_model->get_category('category',$list['category']); echo $get_category[0]['cat_name']; ?></td>
			<td><?php echo $get_user['f_name'].' '.$get_user['l_name']; ?>
			</td>
				<?php 
				$get_post_jobs=$this->common_model->get_single_data('tbl_jobpost_bids',array('bid_by'=>$this->session->userdata('user_id'),'job_id'=>$list['job_id'],'status'=>7)); ?>
				<?php if($show_buget==1){ ?>
			<td>
				<?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?>
			</td>
				<?php } ?>
			<?php
			 ?>
			<td>
				<?php 
				$len = (strlen($list['post_code'])>=7)?4:3;
									
				echo strtoupper(substr($list['post_code'],0,$len));
				$distance = getDistanceByLatLng($list['latitude'],$list['longitude'],$user_data['latitude'],$user_data['longitude']);
									
									
									
									echo '<br>'.$distance.' miles';
									
				?>
			</td>
			<td>
				<?php if(empty($get_trades)){?>
				<?php if(($list['status']==0 || $list['status']==1 || $list['status']==2 || $list['status']==3) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Open</span>
				<?php }else if(($list['status']==4) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-danger">Closed</span>
				<?php  }else if(($list['status']==7) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-danger">Closed</span>
				<?php }else if(($list['status']==8) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Open</span>
				<?php }else if(($list['status']==5) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-danger">Closed</span>
				<?php }else if((date('Y-m-d H:i:s')>=$datesss) && ($list['status']!=4 || $list['status']!=5 || $list['status']==7)){ ?>
				<span class="label label-danger">Closed</span>
				<?php } ?>

				<?php }else{ ?>
				<?php if(($list['status']==0 || $list['status']==1 || $list['status']==2 || $list['status']==3) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Open</span>
				<?php }else if(($list['status']==4) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Awaiting Acceptance</span>
				<?php  }else if(($list['status']==7) && (date('Y-m-d')< $datesss)){ ?>
				<span class="label label-success">In Progress</span>
				<?php }else if(($list['status']==8) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Open</span>
				<?php }else if(($list['status']==5) && (date('Y-m-d H:i:s')< $datesss)){ ?>
				<span class="label label-success">Completed</span>
				<?php }else if((date('Y-m-d H:i:s')>=$datesss) && ($list['status']!=4 || $list['status']!=5 || $list['status']==7)){ ?>
				<span class="label label-danger">Closed</span>
				<?php } ?>
				<?php } ?>
			</td>

			<td>
			
				<?php if((date('Y-m-d') >= $datesss) || $list['status']==4 || $list['status']==7 || $list['status']==5){
					$disabled = 'disabled';
				} else {
					$disabled = '';
				} ?>
				
				<?php 
				$check_my_bid = $this->common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$list['job_id'],'bid_by'=>$user_data['id']));
				?>
						
				<?php if($check_my_bid){ ?>
				<button class="btn btn-warning" <?= $disabled; ?> onclick="window.location.href='<?php echo base_url('details/?post_id='.$list['job_id']); ?>'">Update Quote</button>
				<?php } else { ?>
				<button class="btn btn-warning" <?= $disabled; ?> onclick="window.location.href='<?php echo base_url('details/?post_id='.$list['job_id']); ?>'">Quote</button>
				<?php } ?>
			
        </td>
                   
      </tr>
					<?php } } } ?>
					
		</tbody>
	</table>

							</div>
							
						<?php } else { ?>
							<div class="verify-page">
								<div  style="background-color:#fff;padding: 10px;" class="">
									<div class="margin-top">
									<br>
									<br>
									<div class="text-center">There are no jobs within your choosen radius.</div>
									<br>
									<br>
									<div class="text-center"><img style="width: 25%;" src="<?php echo site_url().'img/tools.png'; ?>"></div>
									
									<br>
									<br>
									
									<div class="text-center">Please go to your profile and increase your travelling distance.</div>
									
									<br>
									<br>
									
									<p class="text-center"><a href="<?php echo site_url().'edit-profile'; ?>" class="btn btn-warning">Increase your travel distance</a></p>
						
									</div>
								</div>
							</div>
							<br>
							<br>
							<?php } ?>
                     
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
			"pageLength": 25,
			"oLanguage": {
        "sEmptyTable": "There are no jobs currently found within your choosen radius. Please go to your profile and inscrease your travelling distance."
			}
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
  </script>
<style>
.verify-page {
	height: calc(100% - 50px);
	background: #fff;
} 
.margin-top {
    
}
</style>
<?php include 'include/footer.php'; ?>
  