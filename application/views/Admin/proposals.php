<?php  
include ("include/header.php");
include ("include/top.php");
$get_jobs=$this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post_id']));

$get_commision=$this->Common_model->get_commision();

$bank_Pay_info = '';
$strip_Pay_info = '';
$paypal_Pay_info = '';

$paypal_comm_per = $get_commision[0]['paypal_comm_per'];
$paypal_comm_fix = $get_commision[0]['paypal_comm_fix'];

$stripe_comm_per = $get_commision[0]['stripe_comm_per'];
$stripe_comm_fix = $get_commision[0]['stripe_comm_fix'];

if($this->session->userdata('type')==2){
	$strip_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Strip charges ('.$stripe_comm_per.'%+'.$stripe_comm_fix.') processing fee and processes your payment immediately ." data-original-title="" class="red-tooltip toll stripe-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$paypal_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Paypal charges ('.$paypal_comm_per.'%+'.$paypal_comm_fix.') processing fee and processes your payment immediately." data-original-title="" class="red-tooltip toll paypal-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$bank_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="We charge 0% processing fee and process your payment within 1-2 working days." data-original-title="" class="red-tooltip toll bank-tooltip"><i class="fa fa-info-circle"></i></a>';
}

$credit_amount=$get_commision[0]['credit_amount'];
?>
<style>
.ppprogg {
	text-align: center;
	padding: 100px 0;
}
</style>
 <!-- instant paymet-->
<script src="https://checkout.stripe.com/checkout.js"></script>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
var processing_perc = <?= $get_commision[0]['processing_fee']; ?>;
var type = <?= $this->session->userdata('type'); ?>;
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Post a job</h1>
		<ol class="breadcrumb">
		  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		  <li class="active">Post a job</li>
		</ol>
		<?=$this->session->flashdata('responseMessage');?>
	</section>
	<section class="content">
	<div class="container">
		<div class="row">
			<?php
			if($this->session->userdata('type')==2){
				$col_sm_8 = 'col-sm-8';
			} else {
      ?>
        <div class="col-sm-1">
        </div>
      <?php
				$col_sm_8 = 'col-sm-10';
			}
			?>
			<div class="<?php echo $col_sm_8; ?>">
				<?php echo $this->session->flashdata('msg2');  ?>
				<?php echo $this->session->flashdata('success1');  ?>
				<?php if($this->session->flashdata('error1')) { ?>
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
				<?php } ?>
				<?php if($this->session->flashdata('success1123')) { ?>
					<p class="alert alert-success">Success! Proposal has been accepted successfully.</p>
				<?php } ?>
				
				<?php if(empty($proposals) && empty($tradespropose) && empty($awarded)){ ?>
				<div class="dashboard-white dashboard-white2">
					
					<div class="row">
						<div class="col-sm-12">
							<div class="ppprogg">
									<?php if($type==2){ ?>
									
									<p style="text-align: center;"><b>Thank you for posting your job, our vetted professionals will quote soon.</b></p>
									
									<?php } else{ ?>
                                
									<p style="text-align: center;"><b>You have not yet quoted this job. Please quote now.</b></p>
                             
									<?php } ?>
							</div>
						</div>

					</div>
				</div>

				<?php } ?>
         
				<?php if($this->session->userdata('type')==1){ ?>

				<?php  if($awarded){ ?>
					
				
					
				<?php foreach ($awarded as $key => $a) { ?>
				<?php if ($a['bid_by']==$this->session->userdata('user_id')) { ?>
				
				<?php $get_users=$this->Common_model->get_single_data('users',array('id'=>$a['bid_by'])); ?>
				
				
				
				<h3 style="font-size: 20px;"><b>Awarded Tradesmen</b></h3>
                
				<div class="dashboard-white dashboard-white2">
					<div class="row">
						<div class="col-sm-5">
							<div class="img-name1">
								<?php if($get_users['profile']){ ?>                                 
								<img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img">
																	
								<?php } else { ?>
                     
								<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
                               
								<?php } ?> 
                    
								<div class="names1">
									<h4><b><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><?php echo $get_users['trading_name']; ?></a></b></h4>
									<div class="from-group revie">
										<?php if($get_users['average_rate']){ ?>  
											<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?> </span>
										<?php } ?>


										<span class="star_r">
											<?php for($i=1;$i<=5;$i++){
											if($get_users['average_rate']) {
												if($i<=$get_users['average_rate']) { ?>  
												
											<i class="fa fa-star active"></i>
												
												<?php }  else{ ?>
											
											<i class="fa fa-star"></i>
											<?php } ?>

											<?php } else { ?> 
											
											<i class="fa fa-star"></i>
											
											<?php } ?>
											<?php } ?>
										</span>(<?php echo $get_users['total_reviews']; ?> reviews) 
									
									</div>

									
									<?php if($a['status']==8 && $a['hiring_type']==1){ ?>
									<p><b>Reject Reason:</b> <?php echo $a['reject_reason']; ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
						
						<div class="col-sm-7">
							<div class="text-right">
								<p><b><i class="fa fa-gbp"></i><?php echo $a['bid_amount']; ?> GBP</b> in <?php echo $a['delivery_days']; ?> day(s)</p>
									
									<?php  if($this->session->userdata('user_id')==$a['bid_by']){  ?>
									<?php if($a['status']==1 || $a['status']==3 || $a['status']==5 || $a['status']==7 || $a['status']==10){ ?>
									
									<?php
									$get_plan_bids=$this->Common_model->get_single_data('user_plans',array('up_user'=>$this->session->userdata('user_id'),'up_status'=>1),'up_id');	
			
									$get_chat_paid=$this->Common_model->get_single_data('chat_paid',array('user_id'=>$this->session->userdata('user_id'),'post_id'=>$a['job_id']));
									
									if($a['hiring_type']==0 || ($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) || $get_chat_paid){ ?>
									
									<a class="btn btn-primary" onclick="get_chat_onclick(<?php echo $a['posted_by']; ?>,<?php echo $_REQUEST['post_id']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a> 
									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
										},5000);
									</script>
									
									
									<?php } else { ?>
									<a class="btn btn-primary" href="javascript:void(0);" onclick="pay_chat_first(<?php echo $get_jobs['userid']; ?>,<?php echo $get_jobs['job_id']; ?>,'<?php echo $credit_amount; ?>');" class=" my-chat-<?php echo $get_jobs['userid']; ?>">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a> 
									
									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
										},5000);
									</script>
									
									<?php } ?>
									<?php } ?>
									
									<?php if($a['status']==3){ ?>
									
										<?php if($a['hiring_type']==1){ ?>
										
										<a  class="btn btn-warning" onclick="accept_award123(<?php echo $a['id'];?>,7)">Accept</a>   

										<?php } else { ?>
										
										<a class="btn btn-warning" onclick="accept_award(<?php echo $a['id'];?>,7)">Accept</a> 
										
										<?php } ?>
										
										
										<?php if($a['hiring_type']==1){ ?>
										
										<a class="btn btn-danger" data-toggle="modal" data-target="#reject_direct_hired<?php echo $a['id']; ?>">Reject</a> 
										
										
										

<?php if(isset($_GET['reject_award']) && $_GET['reject_award']==1){?>
<script>
$(function(){
	var new_budget_edit_id = <?php echo $a['id']; ?>;
	$('#reject_direct_hired'+new_budget_edit_id).modal('toggle');
})
</script>
<?php } ?>

										<?php } else { ?>
										 <a  class="btn btn-danger" href="<?php echo site_url('posts/reject_award/'.$a['id'].'/'.$a['job_id']); ?>" onclick="return confirm('Are you sure! you want to reject this awarded request?');">Reject</a>
										<?php } ?>
										
									<?php } } ?>
									
								<?php /*
								<div class="req-btn proposal-dropdown">
									
									<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
											
										
									
									<?php  if($this->session->userdata('user_id')==$a['bid_by']){  ?>
									<?php if($a['status']==1 || $a['status']==3 || $a['status']==5 || $a['status']==7 || $a['status']==10){ ?>
									
									<?php
									$get_plan_bids=$this->Common_model->get_single_data('user_plans',array('up_user'=>$this->session->userdata('user_id'),'up_status'=>1),'up_id');	
			
									$get_chat_paid=$this->Common_model->get_single_data('chat_paid',array('user_id'=>$this->session->userdata('user_id'),'post_id'=>$a['job_id']));
									
									if($a['hiring_type']==0 || ($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) || $get_chat_paid){
									
									?>
									
									
									<li><a onclick="get_chat_onclick(<?php echo $a['posted_by']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a></li>
									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
										},5000);
									</script>
									
									
									<?php } else { ?>
									<li><a href="javascript:void(0);" onclick="pay_chat_first(<?php echo $get_jobs['userid']; ?>,<?php echo $get_jobs['job_id']; ?>,'<?php echo $credit_amount; ?>');" class=" my-chat-<?php echo $get_jobs['userid']; ?>">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a></li>
									
									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
										},5000);
									</script>
									
									<?php } ?>
									<?php } ?>
									<?php if($a['status']==8){ ?>
										<li><a type="button" class="btn btn-danger">Rejected</a></li> 
									<?php } ?>
									<?php if($a['status']==3){ ?>
									
										<?php if($a['hiring_type']==1){ ?>
										
										<li><a onclick="accept_award123(<?php echo $a['id'];?>,7)">Accept</a></li>  

										<?php } else { ?>
										
										<li><a onclick="accept_award(<?php echo $a['id'];?>,7)">Accept</a></li>
										
										<?php } ?>
										
										
										<?php if($a['hiring_type']==1){ ?>
										
										<li><a data-toggle="modal" data-target="#reject_direct_hired<?php echo $a['id']; ?>">Reject</a></li>
										
										
										

<?php if(isset($_GET['reject_award']) && $_GET['reject_award']==1){?>
<script>
$(function(){
	var new_budget_edit_id = <?php echo $a['id']; ?>;
	$('#reject_direct_hired'+new_budget_edit_id).modal('toggle');
})
</script>
<?php } ?>

										<?php } else { ?>
										<li><a href="<?php echo site_url('posts/reject_award/'.$a['id'].'/'.$a['job_id']); ?>" onclick="return confirm('Are you sure! you want to reject this awarded request?');">Reject</a></li>
										<?php } ?>
										
									<?php } } ?>
									
									</ul>
									</div>
								</div> */?>
<?php if($a['hiring_type']==1){ ?>
<!-- Modal -->
<div id="reject_direct_hired<?php echo $a['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reject Offer</h4>
      </div>
			<form method="post" onsubmit="return confirm('Are you sure you want to reject this job?');" action="<?php echo site_url().'direct_hire/reject_direct_hired'; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label><b>Reason</b>: <span>If low budget and time are among the reasons for not accepting the offer, please suggest your acceptable budget and time.</span></label>
						<textarea class="form-control"name="reject_reason" min="1" value="<?php echo $a['reject_reason']; ?>" required></textarea>
						<input type="hidden" name="job_id" value="<?php echo $a['job_id']; ?>">
						<input type="hidden" name="bid_id" value="<?php echo $a['id']; ?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Reject Now</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
    </div>

  </div>
</div>

<?php } ?>

							</div>
						</div>

					</div>
          <p><?=$a['propose_description']; ?></p>
					
					<hr>
					<?php 
					$get_user_suggest = $this->Common_model->get_all_data('tbl_milestones',array('bid_id'=>$a['id'],'is_suggested'=>1));
					if(count($get_user_suggest) > 0){ ?>
					<h4>
						<b>Suggested Milestone</b>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>Milestone Name</th>
								<th>Milestone Amount</th>
							</tr>
						</thead>
						<tbody>
					<?php 	
						foreach($get_user_suggest as $key1 => $row1){
					?>
							<tr>
								<td><?php echo $row1['milestone_name']; ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row1['milestone_amount']; ?></td>
							</tr>
							
					<?php } ?>
						</tbody>
					</table>
					<?php } ?>
					
				</div>

				<?php } else { ?>
				<?php if(empty($proposals) && empty($tradespropose) && empty($awarded)){ ?>
				<div class="dashboard-white dashboard-white2">
					<div class="row">
						<div class="col-sm-12">
							<div class="img-name1">
								<div class="names1">
                                
									<p style="text-align: center;"><b>This project has no proposals yet.</b></p>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				
				<?php if($tradespropose){ ?>
				
				<?php foreach ($tradespropose as $key => $a) {  ?>
					
				<?php $get_users=$this->Common_model->get_single_data('users',array('id'=>$a['bid_by'])); ?>
					
				<?php if($this->session->flashdata('error2')) { ?>
				
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error2'); ?></p>
           
				<?php } ?>
           
				<?php if($this->session->flashdata('success2')) { ?>
           
				<p class="alert alert-success"><?php echo $this->session->flashdata('success2'); ?></p>
            
				<?php } ?>
             
				<?php if($awarded){ ?>  
				
				<h3 style="font-size: 20px;"><b>Your Quote</b></h3>
				
				<?php } ?>
				
				<div class="dashboard-white dashboard-white2">

					<div class="row">
						<div class="col-sm-5">
							<div class="img-name1">
								<?php if($get_users['profile']){ ?>                                 
								<img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img">
								
								<?php } else { ?>
																	
								<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
                               
								<?php } ?> 
                    
								<div class="names1">
									
									<h4><b><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><?php echo $get_users['trading_name']; ?></a></b></h4>
									<div class="from-group revie">
										<?php if($get_users['average_rate']){ ?>
										
										<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?></span>
										
										<?php } ?>
																		
										<span class="star_r">
										<?php for($i=1;$i<=5;$i++){ ?>
											
										<?php if($get_users['average_rate']) { ?> 
										
										<?php if($i<=$get_users['average_rate']) { ?>  
										 
										<i class="fa fa-star active"></i>
										 
										<?php }  else { ?>
										
										<i class="fa fa-star"></i>
							 
										<?php } ?>

										<?php } else { ?> 
										
										<i class="fa fa-star"></i>
										
										<?php } ?>
										<?php } ?>
										</span>(<?php echo $get_users['total_reviews']; ?> reviews) 
									</div>

								</div>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="text-right">
								<p><b><i class="fa fa-gbp"></i><?php echo $a['bid_amount']; ?> GBP</b> in <?php echo $a['delivery_days']; ?> day(s)</p>
								
								<?php if($this->session->userdata('user_id')==$a['bid_by'] && $a['status']==0 && $get_jobs['status']!=7 && $get_jobs['status']!=5 && $get_jobs['status']!=4 && $get_jobs['hiring_type']==0){ ?>
                         
								<a class="btn btn-primary" onclick="get_chat_onclick(<?php echo $a['posted_by']; ?>,<?php echo $_REQUEST['post_id']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a> 
                              
								<script type="text/javascript">
                  setInterval(function(){
                    get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
                  },5000);
                </script>
								
                <?php } ?>
								
								<?php /*
								<div class="req-btn proposal-dropdown">
								<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
								<?php if($this->session->userdata('user_id')==$a['bid_by'] && $a['status']==0 && $get_jobs['status']!=7 && $get_jobs['status']!=5 && $get_jobs['status']!=4 && $get_jobs['hiring_type']==0){ ?>
                         
								<li><a onclick="get_chat_onclick(<?php echo $a['posted_by']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['posted_by']; ?>"></span></a></li>
                              
								<script type="text/javascript">
                  setInterval(function(){
                    get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['posted_by']; ?>);
                  },5000);
                </script>
								
								<li><a href="<?php echo base_url('details?post_id='.$a['job_id']); ?>" >Edit</a></li>
								<li><a href="<?php echo site_url('posts/delete_bid/'.$a['id'].'/'.$a['job_id']); ?>" onclick="return confirm('Are you sure! you want to retract your quote?');">Retract</a></li>
                <?php } ?>
							
								</ul>
								</div>
								</div> */?>
							</div>
						</div>
					</div>
          <p><?php echo $a['propose_description']; ?></p>
					
					<hr>
					<?php 
					$get_user_suggest = $this->Common_model->get_all_data('tbl_milestones',array('bid_id'=>$a['id'],'is_suggested'=>1));
					if(count($get_user_suggest) > 0){ ?>
					<h4>
						<b>Suggested Milestone</b>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>Milestone Name</th>
								<th>Milestone Amount</th>
							</tr>
						</thead>
						<tbody>
					<?php 	
						foreach($get_user_suggest as $key1 => $row1){
					?>
							<tr>
								<td><?php echo $row1['milestone_name']; ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row1['milestone_amount']; ?></td>
							</tr>
							
					<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>
				
	


				<?php } ?>          
				<?php } ?>          
				<?php } ?>          
			
			
				<?php if($this->session->userdata('type')==2){ ?>
                     
				<?php if($accepted_proposal){ ?>
									
					<h3 style="font-size: 20px;"><b>Awarded Tradesmen</b></h3>
												 
					<?php foreach ($accepted_proposal as $key => $a) { ?>
					
					<?php $get_users=$this->Common_model->get_single_data('users',array('id'=>$a['bid_by'])); ?>

					<div class="dashboard-white dashboard-white2">
						<div class="row">
							<div class="col-sm-5">
								<div class="img-name1">
									<?php if($get_users['profile']){ ?>                                 
									<img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img">
									<?php } else { ?>
									<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
																	 
									<?php } ?> 
												
									<div class="names1">
										
										<h4><b><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><?php echo $get_users['trading_name']; ?></a></b></h4>
															 
										<div class="from-group revie">
											<?php if($get_users['average_rate']){ ?>
											
											<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?> </span>
											
											<?php } ?>
																						 
											<span class="star_r">
												<?php 
												for($i=1;$i<=5;$i++){
												if($get_users['average_rate']) {
												if($i<=$get_users['average_rate']) { ?>  
												
												<i class="fa fa-star active"></i>
												
												<?php  } else{ ?>
												
												<i class="fa fa-star"></i><?php 
											 
												} } else { ?> 
												
												<i class="fa fa-star"></i>
												
												<?php } ?>
												<?php } ?>
											</span>(<?php echo $get_users['total_reviews']; ?> reviews) 
											
											<p style="display: none;"> $ 
												<span class="loder-pro">
													<ul class="ul_set">
															<li class="active"></li>
															<li class="active"></li>
															<li class="active"></li>
															<li class="active"></li>
															<li></li>
													</ul>
												</span>
											</p>
																		
										</div>

									</div>
								</div>
							</div>
							
							<div class="col-sm-7">
								<div class="text-right">
									<p><b><i class="fa fa-gbp"></i><?php echo $a['bid_amount']; ?> GBP</b> in <?php echo $a['delivery_days']; ?> day(s)</p>
									
									<a class="btn btn-primary" onclick="get_chat_onclick(<?php echo $a['bid_by']; ?>,<?php echo $_REQUEST['post_id']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['bid_by']; ?>"></span></a> 
													 
									<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
																			
									<?php if($a['status']==0){ ?> 
										
									<a class="btn btn-warning" data-toggle="modal" data-target="#award_modal<?php echo $a['id']; ?>">Award</a>
										
									<?php } ?>
																				
									<?php } ?>
																		
									<?php if($a['status']==3){ ?>
										
									<a  class="btn btn-warning" href="<?php echo site_url('newPost/reject_award_homeowner/'.$a['id'].'/'.$a['job_id']); ?>" onclick="return confirm('Are you sure! you want to cancel this awarded?');">Revoke </a> 
										
									<?php if($a['hiring_type']==1){ ?>
										
									<a  class="btn btn-info" data-toggle="modal" data-target="#edit_budget<?php echo $a['id']; ?>">Edit Budget</a>
										
									<?php if(isset($_GET['edit_budget']) && $_GET['edit_budget']==1){?>
									<script>
									$(function(){
										var new_budget_edit_id = <?php echo $a['id']; ?>;
										$('#edit_budget'+new_budget_edit_id).modal('toggle');
									})
									</script>
									<?php } ?>
									<?php } ?>
										
										
									<?php } ?>	
										
									<?php if($a['status']==8 && $a['hiring_type']==1){ ?>
																						 
									<a class="btn btn-warning"  data-toggle="modal" data-target="#reopen_trademens<?php echo $a['id']; ?>">Re-Offer</a>

									<?php } ?>

									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['bid_by']; ?>);
										},5000);
									</script>
									
									<?php /*
									<div class="req-btn proposal-dropdown">
									<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
										<li><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);">View Profile</a></li>
										<li><a onclick="get_chat_onclick(<?php echo $a['bid_by']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $a['bid_by']; ?>"></span></a></li>
													 
										<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
																			
										<?php if($a['status']==0){ ?> 
										
										<li><a data-toggle="modal" data-target="#award_modal<?php echo $a['id']; ?>">Award</a></li>
										
										<?php } ?>
																				
										<?php } ?>
																		
										<?php if($a['status']==3){ ?>
										
										<li><a href="<?php echo site_url('newPost/reject_award_homeowner/'.$a['id'].'/'.$a['job_id']); ?>" onclick="return confirm('Are you sure! you want to cancel this awarded?');">Revoke </a></li>
										
										<?php if($a['hiring_type']==1){ ?>
										
										<li><a data-toggle="modal" data-target="#edit_budget<?php echo $a['id']; ?>">Edit Budget</a></li>
										
<?php if(isset($_GET['edit_budget']) && $_GET['edit_budget']==1){?>
<script>
$(function(){
	var new_budget_edit_id = <?php echo $a['id']; ?>;
	$('#edit_budget'+new_budget_edit_id).modal('toggle');
})
</script>
<?php } ?>
										<?php } ?>
										
										
										
										<li><a class="text-info">Awarded </a></li>
										<?php } ?>
																			 
										<?php if($a['status']==7){ ?>
																						 
										<li><a class="text-success">Accepted </a></li>
																	
										<?php } ?>	
										
										<?php if($a['status']==8 && $a['hiring_type']==1){ ?>
																						 
										<li><a class="btn btn-warning"  data-toggle="modal" data-target="#reopen_trademens<?php echo $a['id']; ?>">Re-Offer</a></li>

<!-- Modal -->

										<?php } ?>

										<script type="text/javascript">
											setInterval(function(){
												get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $a['bid_by']; ?>);
											},5000);
										</script>
									</ul>
									</div>
									</div> */ ?>
<?php if($a['status']==8 && $a['hiring_type']==1){ ?>
<div id="reopen_trademens<?php echo $a['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Re-Open</h4>
      </div>
			<form method="post" action="<?php echo site_url().'direct_hire/reopen_trademens'; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label>Budget</label>
						<input class="form-control" type="number" name="budget" min="1" value="<?php echo $a['bid_amount']; ?>" required>
						<input type="hidden" name="job_id" value="<?php echo $a['job_id']; ?>">
						<input type="hidden" name="bid_id" value="<?php echo $a['id']; ?>">
					</div>
					<div class="form-group">
						<label>This project will be delivered in</label>
						<input class="form-control" type="number" name="delivery_days" min="1" value="<?php echo $a['delivery_days']; ?>" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Re-Open</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
    </div>

  </div>
</div>

<?php } ?>

<?php if($a['hiring_type']==1){ ?>
<!-- Modal -->
<div id="edit_budget<?php echo $a['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Budget</h4>
      </div>
			<form method="post" action="<?php echo site_url().'direct_hire/edit_budget'; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label>Budget</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
							<input class="form-control" type="number" name="budget" min="1" value="<?php echo $a['bid_amount']; ?>" required>
						</div>
						<input type="hidden" name="job_id" value="<?php echo $a['job_id']; ?>">
						<input type="hidden" name="bid_id" value="<?php echo $a['id']; ?>">
					</div>
					<div class="form-group">
						<label>This project will be delivered in</label>
						<input class="form-control" type="number" name="delivery_days" min="1" value="<?php echo $a['delivery_days']; ?>" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Edit Budget</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
    </div>

  </div>
</div>

<?php } ?>
								</div>
							</div>

						</div>
						<p><?php echo $a['propose_description']; ?></p>
						
						<hr>
					<?php 
					$get_user_suggest = $this->Common_model->get_all_data('tbl_milestones',array('bid_id'=>$a['id'],'is_suggested'=>1));
					if(count($get_user_suggest) > 0){ ?>
					<h4>
						<b>Suggested Milestone</b>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>Milestone Name</th>
								<th>Milestone Amount</th>
							</tr>
						</thead>
						<tbody>
					<?php 	
						foreach($get_user_suggest as $key1 => $row1){
					?>
							<tr>
								<td><?php echo $row1['milestone_name']; ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row1['milestone_amount']; ?></td>
							</tr>
							
					<?php } ?>
						</tbody>
					</table>
					<?php } ?>
						
						<?php if($a['status']==8 && $a['hiring_type']==1){ ?>
							<p><b>Reject Reason:</b> <?php echo $a['reject_reason']; ?></p>
						<?php } ?>

					</div>
	
<!-- instant paymet-->				
				<?php } } ?>
				
					<!-- Loop-->
				<?php if($proposals){ ?>
				<?php foreach ($proposals as $key => $p) { ?>
				
				<?php $get_users=$this->Common_model->get_single_data('users',array('id'=>$p['bid_by'])); ?>
							
				<?php if($accepted_proposal){ ?>
				
					<h3  style="font-size: 20px;"><b>Other Proposals</b></h3>
					
				<?php } ?>
				
				<div class="dashboard-white dashboard-white2">
					<div class="row">
						<div class="col-sm-5">
							<div class="img-name1">
								<?php if($get_users['profile']){ ?>                                 
									<img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img">
								<?php } else { ?>
									<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
																 
								<?php } ?> 
											
								<div class="names1">
									<h4><b><a  onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><?php echo $get_users['trading_name']; ?></a></b></h4>
									<div class="from-group revie">
										
										<?php if($get_users['average_rate']){ ?>
										<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?> </span>
										<?php } ?>
										
										<span class="star_r">
											<?php for($i=1;$i<=5;$i++){ ?>
											
											<?php if($get_users['average_rate']) { ?>
											
											<?php if($i<=$get_users['average_rate']) {  ?>  
											
											<i class="fa fa-star active"></i>
											<?php } else{ ?>
											 
											<i class="fa fa-star"></i>
											<?php  } ?>

											<?php } else { ?> 
											
											<i class="fa fa-star"></i>
											
											<?php } ?>
											
											<?php } ?>
																	
										</span>(<?php echo $get_users['total_reviews']; ?> reviews) 
										<p style="display: none;"> $ 
											<span class="loder-pro">
													<ul class="ul_set">
															<li class="active"></li>
															<li class="active"></li>
															<li class="active"></li>
															<li class="active"></li>
															<li></li>
													</ul>
											</span>
										</p>
									</div>

								</div>
							</div>
						</div>
						<div class="col-sm-7">
							<div class="text-right">
								<p><b><i class="fa fa-gbp"></i><?php echo $p['bid_amount']; ?> GBP</b> in <?php echo $p['delivery_days']; ?> day(s)</p>
									
								<?php $get_jobs=$this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post_id']));  ?>
								
								<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
								
								<button class="btn btn-primary" onclick="get_chat_onclick(<?php echo $p['bid_by']; ?>,<?php echo $_REQUEST['post_id']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $p['bid_by']; ?>"></span></button> 
								<?php } ?>
												 
								<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
								<button class="btn btn-warning" data-toggle="modal" data-target="#awaaad_moal<?php echo $p['id']; ?>">Award</button> 
								<?php } ?>
								 
												
								<script type="text/javascript">
									setInterval(function(){
										get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $p['bid_by']; ?>);
									},5000);
								</script>
								
								<?php /*
								<div class="req-btn proposal-dropdown">
									<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
									<li><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);">View Profile</a></li>
								
									<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
									<li><a onclick="get_chat_onclick(<?php echo $p['bid_by']; ?>);showdiv();">Chat <span class="count_un_msg<?php echo $p['bid_by']; ?>"></span></a></li>
									<?php } ?>
													 
									<?php if($get_jobs['status']==3 || $get_jobs['status']==8 || $get_jobs['status']==1){ ?>
									<li><a data-toggle="modal" data-target="#awaaad_moal<?php echo $p['id']; ?>">Award</a></li>
									<?php } ?>
									 
									<?php if($p['status']==3){ ?>
									 <li><a class="text-info">Awarded</a></li>
									<?php } ?>
														
									<?php if($p['status']==7){ ?>
										<li><a class="text-success">Accepted </a></li>
									<?php } ?>
														
									<script type="text/javascript">
										setInterval(function(){
											get_unread_msg_count(<?php echo $_REQUEST['post_id']; ?>,<?php echo $p['bid_by']; ?>);
										},5000);
									</script>
								</ul>
								</div>
								</div> */ ?>

							</div>
						</div>
					</div>
          <p><?=$p['propose_description']; ?></p>
					<hr>
					<?php 
					$get_user_suggest = $this->Common_model->get_all_data('tbl_milestones',array('bid_id'=>$p['id'],'is_suggested'=>1));
					if(count($get_user_suggest) > 0){ ?>
					<h4>
						<b>Suggested Milestone</b>
					</h4>
					<table class="table">
						<thead>
							<tr>
								<th>Milestone Name</th>
								<th>Milestone Amount</th>
							</tr>
						</thead>
						<tbody>
					<?php 	
						foreach($get_user_suggest as $key1 => $row1){
					?>
							<tr>
								<td><?php echo $row1['milestone_name']; ?></td>
								<td><i class="fa fa-gbp"></i><?php echo $row1['milestone_amount']; ?></td>
							</tr>
							
					<?php } ?>
						</tbody>
					</table>
					<?php } ?>
				</div>

								
				<div class="modal fade awaddd" id="awaaad_moal<?php echo $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<div class="modal-body">
								<div class="box_SetPayments">
									<div class="row mmm0">
										<div class="col-sm-7">
											<div class="box_SetPayments2">
												
											
												<h3>
													<b> Set up Milestone Payments</b>
												</h3>
												<p>
													 You only have to pay for work when it has been completed and you're 100% satisfied.
												</p>
												
												<p class="img_ab">
													<?php if($get_users['profile']){ ?>   
														<a  onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>"></a>
													<?php } else { ?>
													
														<a  onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg"></a>
													<?php } ?>
													
													<b><?php echo $get_users['trading_name']; ?></b> has requested the following Milestone Payment:
												</p>
												<hr>
												
												<div class="Milestone2">		 
													<div class="checkbox">
														<label class="radio-inline" style="width:auto;">
															<input name="checkboxes" id="checkboxes-<?php echo $p['id']; ?>" value="1" type="radio" checked onchange="create_ms_checkbox(<?php echo $p['id']; ?>);">
															Award with milestone
														</label>
														
														<label class="radio-inline" style="width:auto;">
															<input name="checkboxes" id="checkboxes1-<?php echo $p['id']; ?>" value="0" type="radio" onchange="create_ms_checkbox(<?php echo $p['id']; ?>);">
															Award without milestone
														</label>
														<div class="row insert_amount_div<?php echo $p['id']; ?>">
															<div class="col-sm-8">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
																	<input class="form-control" placeholder="" value="<?php echo $p['bid_amount']; ?>" onkeyup="change_ms_amount(this.value,<?php echo $p['id']; ?>);" type="number" id="first_milestone<?php echo $p['id']; ?>">
																	
																	<input value="1" type="hidden" name="check_create_ms" id="check_create_ms<?php echo $p['id']; ?>">
																	<input value="<?php echo $p['bid_amount']; ?>" type="hidden" id="total_bid_amount<?php echo $p['id']; ?>">
																	
																</div>
															</div>
														</div>
													</div>

												</div>
												<hr>
												<?php 
												$get_user_suggest = $this->Common_model->get_all_data('tbl_milestones',array('bid_id'=>$p['id'],'is_suggested'=>1));
												if(count($get_user_suggest) > 0){ ?>
												<h4>
													<b>Suggested Milestone</b>
												</h4>
												<table class="table">
													<thead>
														<tr>
															<th>Milestone Name</th>
															<th>Milestone Amount</th>
														</tr>
													</thead>
													<tbody>
												<?php 	
													foreach($get_user_suggest as $key1 => $row1){
												?>
														<tr>
															<td><?php echo $row1['milestone_name']; ?></td>
															<td><i class="fa fa-gbp"></i><?php echo $row1['milestone_amount']; ?></td>
														</tr>
														
												<?php } ?>
													</tbody>
												</table>
												<hr>
												<?php } ?>
												
											 
												<h3><b>Total: <i class="fa fa-gbp"></i><?php echo $p['bid_amount']; ?> GBP</b></h3>
												
												<p class="show_100_msg<?php echo $p['id']; ?>">
													<b>If <?php echo $get_users['trading_name']; ?></b> accepts your job and you're 100% satisfied, then you can release the milestone as per the work completed.
												</p>
												<p class="show_100_msg2_<?php echo $p['id']; ?>" style="display:none;">
													<b>If <?php echo $get_users['trading_name']; ?></b> accepts your job, then you can create a milestone and release it when the job is completed and you're 100% satisfied.
												</p>
									 
												<p>Milestone Payments are refundable subject to our <a href="<?=base_url('terms-and-conditions'); ?>" target="_blank">terms and conditions.</a></p>
												
												<div class="common_pay_main_div instant-payment-button<?php echo $p['id'];?>" style="display:none;">
													<div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet. <span class="Current_wallet_amount"></span></div> <br>
													
													<div class="form-group">
														<label>Enter Amount</label>
														
										<?php
										$required_amount = $p['bid_amount']-$user_data['u_wallet'];
										
										$required_amount = ($required_amount > $get_commision[0]['p_min_d'])?$required_amount:$get_commision[0]['p_min_d'];
										?>
														
														<input type="number" class="form-control" value="<?php echo $required_amount; ?>" onkeyup="check_value(<?php echo $p['id'];?>,this.value);" id="amount<?php echo $p['id'];?>">
													</div>
													
													<p class="instant-err<?php echo $p['id'];?> alert alert-danger" style="display:none;"></p>
													
													<div class="card pay_btns<?php echo $p['id'];?> all-pay-tooltip">
														<div class="col-sm-4" style="padding: 0;">
															<div data-id="<?php echo $p['id'];?>" class="pay_btn<?php echo $p['id'];?> strip_btn" id="strip_btn<?php echo $p['id'];?>"><img src="<?= base_url(); ?>img/pay_with.png"></div>  <?= $strip_Pay_info; ?>
														</div>
														<div class="col-sm-4"  style="padding: 0;">
															<div class="pay_btn<?php echo $p['id'];?> paypal_btn" id="paypal_btn<?php echo $p['id'];?>"></div>  <?= $paypal_Pay_info; ?>
															<input type="hidden" id="payProcess" value="0">
														</div>
                            <div class="col-sm-4">
															<div class="pay_btn<?=$p['id'];?>">
                               
                                <a href="<?php echo site_url().'wallet?bank-transfer=1&amount='.$required_amount; ?>" class="btn btn-primary bkd_url">Bank Transfer</a>  <?= $bank_Pay_info; ?>
                              </div>
                            </div>
													</div>
															
													<div class="common_pay_loader pay_btns_laoder<?php echo $p['id'];?> text-center" style="display:none;"> 
														<i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
													</div>
												</div>
														
													
												<div class="text-right award_btn_div<?php echo $p['id'];?>">
													<button class="btn btn-primary" id="main_award_btn<?php echo $p['id'];?>" onclick="accept_post(<?php echo $p['id'];?>,3)">Award and Create <i class="fa fa-gbp"></i><span id="changes_amount_btn<?php echo $p['id'];?>"><?php echo $p['bid_amount']; ?></span> GBP Milestone</button>
												</div>
											</div>
										</div> 
										<div class="col-sm-5">
											<div class="box_SetPayments3">
												<h3><b> What are Milestone Payments </b></h3>
												<p>
													Milestone Payments allow to securely pay your tradesmen. <a  target="_blank" href="<?php echo site_url().'homeowner-help-centre#Payment-1'; ?>"> Read more</a>
												</p>
												<div class="img_uspau1">
													<img src="<?php echo base_url(); ?>img/mod_img1.png" class="img_r">
												</div>
												<p>
													To create a Milestone Payment, you are required to deposit funds. 
												</p>
												<div class="img_uspau1">
													<img src="<?php echo base_url(); ?>img/mod_img2.png" class="img_r">
												</div>
												<p>
													Your Milestone Payment will be securely held while your tradesmen works.
												</p>
												<div class="img_uspau1">
													<img src="<?php echo base_url(); ?>img/mod_img3.png" class="img_r">
												</div>
												<p>
													Only release the Milestone Payment when you are 100% satisfied with your tradesmen work.
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>


<script>
	$(document).ready(function(){
		setTimeout(function(){
			
			var amounts = $('#amount<?php echo $p['id']; ?>').val();
			
			var actual_amt = parseFloat(amounts);
			
			var stripe_comm_per = <?= $stripe_comm_per; ?>;
			var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
			var type = <?= $this->session->userdata('type'); ?>;
			var processing_fee = 0;
			var amount_wp = actual_amt;
			
			if(type == 2){
				if(stripe_comm_per > 0 || stripe_comm_fix == 0){
					processing_fee = (1 * actual_amt * stripe_comm_per)/100;
					amount_wp = actual_amt + processing_fee + stripe_comm_fix;
				}
			}
			
			var amount_wp = amount_wp.toFixed(2);
			
			show_main_btn(<?php echo $p['id']; ?>,amounts);
			$('#strip_btn<?php echo $p['id']; ?>').attr('onclick','show_lates_stripe_popup('+amount_wp+','+actual_amt+',4,<?php echo $p['id']; ?>);');
		},300);
	});
	
	var bid_id_to_accept = <?php echo $p['id']; ?>;
	var show_loader = false;
	
	var amounts = $('#amount'+bid_id_to_accept).val();
  
</script>	
<!-- instant paymet-->
												
				<?php } } ?>
				<!-- end loop -->
				
				<?php } ?>
			</div>  
			
			<?php /*if($this->session->userdata('type')==1){ ?>
			<div class="col-sm-4">
        <div class="dashboard-white edit-pro89"> 
					<div class=" dashboard-profile Locations_list11">
						<h2>About the Employer</h2>
						<?php $get_users=$this->Common_model->get_single_data('users',array('id'=>$project_details['userid'])); ?>
						
						<p><i class="fa fa-user"></i><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></p>
								
						 
					
						
					 <p><i class="fa fa-map-marker"></i><?php echo $get_users['city'].', '.$get_users['county'];?>
						 
						 <?php 
						 $data_set1=$this->Common_model->newgetRows('tbl_region',array('id'=>$get_users['county'])); 
							echo ($data_set1[0]['region_name'])?$data_set1[0]['region_name'].' ,':'';

						 ?>
						 </p>
						 
						<p class="pd-icon"><i class="fa fa-user-circle-o"></i>
							<?php if($get_users['average_rate']){ ?>
								<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?>
                </span>
								<?php } ?>
							<span class="star_r">
								
								<?php 
								for($i=1;$i<=5;$i++){
									if($get_users['average_rate']) {
									 if($i<=$get_users['average_rate']) { ?>  
										<i class="fa fa-star active"></i>
										<?php }  else {  ?>
										<i class="fa fa-star"></i><?php 
										} 
									} else { ?> 
									
									<i class="fa fa-star"></i>
									
									<?php } ?>
								<?php } ?>
							</span>
						</p>
						<p>
							<i class="fa fa-clock-o"></i>
							Member Since <?php $yrdata= strtotime($get_users['cdate']);
								echo date('M', $yrdata); ?>, <?php echo date('Y',$yrdata); ?>
						</p>
					</div>
        </div>

				<div class="dashboard-white edit-pro89"> 
					<div class=" dashboard-profile ">
						<h2>Verifications</h2>
						<ul class="lisss ul_set">

							<li class="active">
								<a href="#">
									<i class="fa fa-phone left_iiicon"></i> 
										Phone Verified 
									<?php if($get_users['phone_no']){ ?>
										<i class="fa fa-check right_iiicon"></i> 
									<?php } else{ ?>
										<i class="fa fa-close right_iiicon"></i> 
									<?php } ?>

								</a>
							</li>
							
							<li class="active">
								<a href="#">
									<i class="fa fa-user-circle-o left_iiicon"></i> 
										Identity Verified
										<?php if($get_users['u_status_photo_id']==2){ ?>
										<i class="fa fa-check right_iiicon"></i> 
										<?php }else{ ?>
										<i class="fa fa-close right_iiicon"></i> 
										<?php } ?>
								</a>
							</li>
							<li class="active">
								<a href="#">
									<i class="fa fa-envelope left_iiicon"></i> 
													Address Verified 
																	 <?php if($get_users['u_status_add']==2){ ?>
											<i class="fa fa-check right_iiicon"></i> 
									<?php }else{ ?>
										<i class="fa fa-close right_iiicon"></i> 
									<?php } ?>
									 </a>
							</li>
						</ul>
					</div>
				</div>

				<div class="dashboard-white edit-pro89" style="display: none;"> 
						<div class=" dashboard-profile Locations_list11">
							<h2>Empolyer Verification</h2>
							<p>Bride left<span class="pull-right">242/700</span></p>
							<p>Until next quote<span class="pull-right">10 min.</span></p>
							<p>Refeshb speed <span class="pull-right">1 X</span></p>
							<p>Average quotes <span class="pull-right">$214 USD</span></p>
						</div>
				</div>

				<div class="booknnn" style="display: none;">
					<button class="btn btn-primary btn-block btn-lg"><i class="fa fa-bookmark"></i><b> Bookmark Project</b></button>
				</div>
			</div>
			<?php } */?>
			
			<?php if($this->session->userdata('type')==2){ ?>
                    
			<div class="col-sm-4">
				<div class="dashboard-white">
					<p><b>Budget</b></p>
					<p>
						<?php 
						$get_jobs=$this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post_id'])); 
						echo ($get_jobs['budget'])?'<i class="fa fa-gbp"></i>'.$get_jobs['budget']:'NA'; ?>
					</p>
					<p><b>Quotes</b></p>
					<p><?php echo count($count_bids); ?></p>
					<p><b>Average Quotes</b></p>
					<p>
						<i class="fa fa-gbp"></i>
						<?php 
						$get_avg_bid=$this->Common_model->get_avg_bid($this->session->userdata('user_id'),$_REQUEST['post_id']); 
						if($get_avg_bid[0]['average_amt']){ ?>
						<?php echo number_format($get_avg_bid[0]['average_amt'],2); 
						} else { 
							echo "0"; 
						} ?> GBP
					</p>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
	</section>
</div>


<div class="modal fade" id="pay_when_accept_direct_hire_model" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Choose Type</h4>
			</div>
			<div class="modal-body">
				<div class="msgs1"></div>
				<div class="row">
					<div class="col-sm-6 plan_bid">
			
						<!--p>If you for <b>Pay as you go</b> option, then for every quote £<?php echo $credit_amount; ?> will be deducted from your wallet.</p-->
						<p>To add credits on your wallet click on pay as you button.</p>
						<button class="btn btn-warning" onclick="show_payment_options();">Pay as you go</button>
					</div>
					<div class="col-sm-6 plan_bid">
						<p>To become an active member click on monthly subscription button</p>
						<a href="<?php echo base_url('membership-plans'); ?>"><button class="btn btn-primary" style="position: absolute;bottom: 0;">Monthly Subscription</button></a> 
					</div>

				</div>
				<div class="common_pay_main_div instant-payment-button___1" style="display:none;">
					<div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet. <span class="Current_wallet_amount___1"></span></div> <br>
					
					<div class="form-group">
						<label>Enter Amount</label>
						<input type="number" class="form-control" value="<?php echo $get_commision[0]['p_min_d']; ?>" onkeyup="check_value___1(this.value);" id="amount___1">
					</div>
					
					<p class="instant-err___1 alert alert-danger" style="display:none;"></p>
					
					<div class="card pay_btns__1  all-pay-tooltip">
						<div class="col-sm-2"  style="padding: 0;"></div>
						<div class="col-sm-4" style="padding: 0;">
							<div onclick="show_lates_stripe_popup(<?php echo $get_commision[0]['p_min_d']; ?>,<?php echo $get_commision[0]['p_min_d']; ?>,5,<?php echo $a['id'];?>);" class="pay_btn___1 strip_btn" id="strip_btn___1"><img src="<?= base_url(); ?>img/pay_with.png"></div>  <?= $strip_Pay_info; ?>
						</div>
						<div class="col-sm-4"  style="padding: 0;">
							<div class="pay_btn___1 paypal_btn" id="paypal_btn___1"></div>  <?= $paypal_Pay_info; ?>
						</div>
						<?php /*if($this->session->userdata('type')==2){ ?>
						<div class="col-sm-4" style="padding: 0;">
							<a href="../wallet?bank-transfer=1" class="btn btn-primary">Bank Transfer</a>  <?= $bank_Pay_info; ?>
						</div>
						<?php } */?>
					</div>
							
					<div class="common_pay_loader pay_btns_laoder___1 text-center" style="display:none;"> 
						<i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
					</div>
					<br>
				</div>


		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<div class="modal fade popup" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rejectionModal">Rejection Reason</h4>
      </div>
      <div class="modal-body">
        <p style="font-size: 15px;">
          <?=$this->session->flashdata('reject_reason');?>
        </p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php include ("include/footer.php") ?>
<!-- Modal -->
<div id="View_profileman" class="modal fade right_mddal" role="dialog"></div>
<script>
  <?php
    if($this->session->flashdata('reject_reason')){
  ?>
      $("#rejectModal").modal('show');
  <?php
    }
  ?>

	var instantId = 0;
  var next = 100;
  function add_more_miles() {
  next = next + 1;
  $(".input-append").append('<div id="field'+next+'"><div class="row"><div class="col-sm-6""><div class="form-group"  style="margin-top:-10px;><label for="email"></label><input type="text" class="form-control miname_1" name="tsm_name[]" placeholder="Project Milestone" ></div></div><div class="col-sm-4"><div class="form-group"  style="margin-top:-10px;><label for="email"></label><input type="number" class="form-control miamount_1" min="1" name="tsm_amount[]"></div></div><div class="col-sm-2"><div class="form-group"><button class="btn btn-danger" onclick="removeadd('+next+')" type="button" style="margin-top: -10px;">Remove</button></div></div></div></div>');

}

function show_payment_options()
{
	
	$('.instant-payment-button___1').show();
}
function add_more_miles1() {
  next = next + 1;
  $(".input-append1").append('<div id="fields'+next+'"><div class="row" style="margin-top:10px;"><div class="col-sm-6""><div class="form-group"  style="margin-top:-10px;><label for="email"></label> <input type="text" class="form-control miname_1" name="tsm_name1[]" placeholder="Project Milestone" ></div></div><div class="col-sm-4"><div class="form-group"  style="margin-top:-10px;><label for="email"></label><input type="number" class="form-control miamount_1" min="1" name="tsm_amount1[]"></div></div><div class="col-sm-2"><div class="form-group"><button class="btn btn-danger" onclick="removeadd1('+next+')" type="button" style="margin-top: -10px;">Remove</button></div></div></div></div>');

}
function removeadd1(id)
{
   $("#fields"+id).remove();
}
function removeadd(id) {
  $("#field"+id).remove();
}


function update_milestones(id){
  $.ajax({
    type:'POST',
    url:site_url+'posts/update_milestones',
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

function accept_post(id,status) {
	var amountsa = parseFloat($('#first_milestone'+id).val());
	var check_create_ms = parseFloat($('#check_create_ms'+id).val());
	var total_bid_amount = parseFloat($('#total_bid_amount'+id).val());
	
	if(check_create_ms==1){
		
		var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
		var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;
		
		if(amountsa < min_amount || amountsa > max_amount){
			swal('Deposit amount must be more than £'+min_amount+' and less than £'+max_amount+'!');
			return false;
		}
		
		/*if(amountsa  < 10){
			swal('Milestone value must be more than or equal to £10');
			return false;
		}
		
		if(amountsa  > total_bid_amount){
			swal('Milestone value must not be more than quote amount.');
			return false;
		}*/
		
	}
	
	$.ajax({
		type:'POST',
		url:site_url+'posts/accept_post/'+id+'/'+status+'/'+amountsa+'/'+check_create_ms,
		dataType: 'JSON',
		beforeSend:function(){
			$('.pay_btns'+id).hide();
			$('.pay_btns_laoder'+id).show();
		},
		success:function(resp){
			if(resp.status==1) {
				location.reload();
			} else if(resp.status==2) {
				$('.instant-payment-button'+id).show();
				//amounts = resp.amount;
				$('.pay_btns'+id).show();
				$('.Current_wallet_amount').html('Your last updated wallet amount is <i class="fa fa-gbp"></i>'+resp.wallet);
				$('.pay_btns_laoder'+id).hide();
				$('.award_btn_div'+id).hide();
			}
		} 
	});
	
}

 
function viewRatingOnModal(post_id) {
  if(post_id) {
    
    $.ajax({
      type : 'POST',
      url:site_url+'posts/getRating',
      data :{post_id:post_id},
      dataType:'json',
      success :  function(response) { 
        $("#viewRatingModal").modal('show');
        $("#viewRatingData").html(response.data);
      }
    });
  }
  return false;
}
function viewRatingOnModal1(post_id)
{
    if(post_id) {
    
    $.ajax({
      type : 'POST',
      url:site_url+'posts/getRating',
      data :{post_id:post_id},
      dataType:'json',
      success :  function(response) { 
        $("#viewRatingModal1").modal('show');
        $("#viewRatingData1").html(response.data);
      }
    });
  }
  return false;
}

function accept_award(id,status) {
	if (confirm("Are you sure you want to accept this awarded request?")) {
		$.ajax({
			type:'POST',
			url:site_url+'posts/accept_award/'+id+'/'+status,
			dataType: 'JSON',
			success:function(resp){
				if(resp.status==1) {
					location.reload();
				}
			} 
		});
	} 
}
function accept_award123(id,status) { 
		$.ajax({
			type:'POST',
			url:site_url+'posts/accept_award123/'+id+'/'+status,
			dataType: 'JSON',
			beforeSend:function(){
				$('.pay_btns___1').hide();
				$('.pay_btns_laoder___1').show();
			},
			success:function(resp){
				if(resp.status==1) {
					location.reload();
				} else {
					$('#pay_when_accept_direct_hire_model').modal('show');
					//$('.instant-payment-button___1').show();
					//amounts = resp.amount;
					$('.pay_btns___1').show();
					$('.msgs1').html(resp.msg);
					$('.Current_wallet_amount___1').html('Your last updated wallet amount is <i class="fa fa-gbp"></i>'+resp.wallet);
					$('.pay_btns_laoder___1').hide();
					instantId = id;
				}
			} 
		});
 
}

 




function Rejectpost(post_id) {
  if(post_id) {
    $('#RejectPost').modal('show');
    $('#post_ids').val(post_id);
  }
}
function RejectReasonPosts() {

       if (confirm("Are you sure you want to reject this awarded request?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/accept_award/'+id+'/'+status,
            dataType: 'JSON',
             success:function(resp){
            if(resp.status==1)
            {
              location.reload();
            }
            } 
        });
    } 


  var formData = $("#RejectReasonPost").serialize();
  $.ajax({
   url:site_url+'posts/reject_post',
    type: "post",
    data: formData,
    dataType:'json',
    success:function(response) {            
      if(response.status==1)
      {
   
        location.reload();
        return false;
      }  else {
        return false;
      }
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
<script>
setInterval(function(){ get_chat_history_interwal(); }, 5000);

function check_value(id,value){
  var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
	var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;
	
	var u_wallet = <?php echo $user_data['u_wallet']; ?>;
	
	change_bank_transafer_url(value);
	
  if(value >= min_amount && value <= max_amount){
    //$('.show_btn').prop('disabled',false);
    $('.instant-err'+id).hide();
    $('.instant-err'+id).html('');
		
		var first_milestone123 = $('#first_milestone'+id).val();
		
		var required_amount = first_milestone123-u_wallet;
		
		if(required_amount > value){
			
			//$('.show_btn').prop('disabled',true);
			$('.instant-err'+id).show();
			$('.instant-err'+id).html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+ required_amount +' or equal to <i class="fa fa-gbp"></i>'+ required_amount +'!');
			
			$('.pay_btns'+id).hide();
			return false;
		} else {
			amounts = value;
			
			var processing_fee = 0;
			var actual_amt = parseFloat(amounts);
	
			var stripe_comm_per = <?= $stripe_comm_per; ?>;
			var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
			var type = <?= $this->session->userdata('type'); ?>;
			var processing_fee = 0;
			var amount_wp = actual_amt;
			
			if(type == 2){
				if(stripe_comm_per > 0 || stripe_comm_fix == 0){
					processing_fee = (1 * actual_amt * stripe_comm_per)/100;
					amount_wp = actual_amt + processing_fee + stripe_comm_fix;
				}
			}
			
			var amount_wp = amount_wp.toFixed(2);
			
			$('#strip_btn'+id).attr('onclick','show_lates_stripe_popup('+amount_wp+','+actual_amt+',4,'+id+');');
			
			show_main_btn(id,amounts);
		}
    
  } else {
    $('.card'+id).hide();
    //$('.show_btn').prop('disabled',true);
    $('.instant-err'+id).show();
    $('.instant-err'+id).html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+min_amount+' and less than <i class="fa fa-gbp"></i>'+max_amount+'!');
    $('.pay_btns'+id).hide();
		return false;
  }
}

function show_main_btn(id,amounts){
		$('.pay_btns'+id).show();
    $('#paypal_btn'+id).html('');
		
		var actual_amt = parseFloat(amounts);
		
		var type = <?= $this->session->userdata('type'); ?>;
		var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
		var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
		var processing_fee = 0;
		var amount_wp = actual_amt;
		
		if(type == 2){
			if(paypal_comm_per > 0 || paypal_comm_fix > 0){
				processing_fee = ((actual_amt * paypal_comm_per)/100);
				var amount_wp = processing_fee+actual_amt+paypal_comm_fix;
			}
		}
			
		var amount_wp = amount_wp.toFixed(2);
		
	

    paypal.Button.render({
      env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
      client: {
        sandbox:    '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
        production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
      },

      // Show the buyer a 'Pay Now' button in the checkout flow
      commit: true,

      // payment() is called when the button is clicked
      payment: function(data, actions) {
				
				// Make a call to the REST api to create the payment
        return actions.payment.create({
          payment: {
            transactions: [
              {
                amount: { total: amount_wp, currency: 'GBP' }
              }
            ]
          }
        });
      },

      // onAuthorize() is called when the buyer approves the payment
      onAuthorize: function(data, actions) {  
        // Make a call to the REST api to execute the payment
        return actions.payment.execute().then(function() {
          console.log('Payment Complete!');
          $.ajax({
            type:'POST',
            url:site_url+'wallet/paypal_deposite',
            data:{
              itemPrice : amounts,
              itemId : 'Deposit in wallet',
              orderID : data.orderID,
              txnID : data.paymentID,
            },
            dataType:'JSON',
            beforeSend:function(){
              $('.pay_btns'+id).hide();
              $('.pay_btns_laoder'+id).show();
            },
            success:function(resp){ 
              if(resp.status == 1) {
                //location.reload();
                //window.location.href=site_url+'Users/success/5/'+resp.tranId;
								accept_post(id,3)
              } else {
                $('.pay_btns'+id).show();
                $('.pay_btns_laoder'+id).hide();
                swal(resp.msg);
              }
            }
          });
        });
      }
    }, '#paypal_btn'+id);
}
function change_ms_amount(value,id){
	$('#changes_amount_btn'+id).html(value);
	$('.award_btn_div'+id).show();
	$('.instant-payment-button'+id).hide();
}
function create_ms_checkbox(id){
	
	var checked_value = $('input[name="checkboxes"]:checked').val();
	
	//alert(checked_value);return false;
	
	//if($('#checkboxes-'+id).is(':checked')){
	if(checked_value==1){

		$('#first_milestone'+id).attr('onkeyup','$("#changes_amount_btn'+id+'").html(this.value);');
		
		var first_milestone2 = $('#first_milestone'+id).val();
		
		$('#check_create_ms'+id).val(1);
		$('.insert_amount_div'+id).show();
		
		$('#main_award_btn'+id).html('Award and Create <i class="fa fa-gbp"></i><span id="changes_amount_btn'+id+'">'+first_milestone2+'</span> GBP Milestone');
		
		$('.award_btn_div'+id).show();
		$('.show_100_msg'+id).show();
		$('.show_100_msg2_'+id).hide();
		
	} else {
		$('.show_100_msg'+id).hide();
		$('.show_100_msg2_'+id).show();
		$('#check_create_ms'+id).val(0);
		$('.insert_amount_div'+id).hide();
		$('.instant-payment-button'+id).hide();
		$('#first_milestone'+id).removeAttr('onkeyup');
		$('#main_award_btn'+id).html('Award');
		$('.award_btn_div'+id).show();
	}
}

var amount___1 = $('#amount___1').val();
$(document).ready(function(){
	show_main_btn_two___1(amount___1);
	//show_main_btn_two___1(<?php echo $a['id']; ?>,7);
});


function check_value___1(value){
  var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
	var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;
  if(value >= min_amount && value <= max_amount){
    //$('.show_btn').prop('disabled',false);
    $('.instant-err___1').hide();
    $('.instant-err___1').html('');
    amount___1 = value;
		
		
		var processing_fee = 0;
		var actual_amt = parseFloat(amount___1);
		
		var stripe_comm_per = <?= $stripe_comm_per; ?>;
		var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
		var type = <?= $this->session->userdata('type'); ?>;
		var amount___1_wp = actual_amt;
		
		if(type == 2){
			if(stripe_comm_per > 0 || stripe_comm_fix == 0){
				processing_fee = (1 * actual_amt * stripe_comm_per)/100;
				amount___1_wp = actual_amt + processing_fee + stripe_comm_fix;
			}
		}
		
		amount___1_wp = amount___1_wp.toFixed(2);
		
		$('#strip_btn___1').attr('onclick','show_lates_stripe_popup('+amount___1_wp+','+actual_amt+',5,'+instantId+');');
	
    show_main_btn_two___1(amount___1);
  } else {
    $('.card___1').hide();
    //$('.show_btn').prop('disabled',true);
    $('.instant-err___1').show();
    $('.instant-err___1').html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+min_amount+' and less than <i class="fa fa-gbp"></i>'+max_amount+'!');
    $('.pay_btns___1').hide();
  }
}

function show_main_btn_two___1(amount___1){
		$('.pay_btns___1').show();
    $('#paypal_btn___1').html('');
		
		var processing_fee = 0;
		var actual_amt = parseFloat(amount___1);
		
		var type = <?= $this->session->userdata('type'); ?>;
		var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
		var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
		var processing_fee = 0;
		var amount___1_wp = actual_amt;
		
		if(type == 2){
			if(paypal_comm_per > 0 || paypal_comm_fix > 0){
				processing_fee = ((actual_amt * paypal_comm_per)/100);
				var amount___1_wp = processing_fee+actual_amt+paypal_comm_fix;
			}
		}
			
		var amount___1_wp = amount___1_wp.toFixed(2);
	

    paypal.Button.render({
      env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
      client: {
        sandbox: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
        production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
      },

      // Show the buyer a 'Pay Now' button in the checkout flow
      commit: true,

      // payment() is called when the button is clicked
      payment: function(data, actions) {
				
				// Make a call to the REST api to create the payment
        return actions.payment.create({
          payment: {
            transactions: [
              {
                amount: { total: amount___1_wp, currency: 'GBP' }
              }
            ]
          }
        });
      },

      // onAuthorize() is called when the buyer approves the payment
      onAuthorize: function(data, actions) {  
        // Make a call to the REST api to execute the payment
        return actions.payment.execute().then(function() {
          console.log('Payment Complete!');
          $.ajax({
            type:'POST',
            url:site_url+'wallet/paypal_deposite',
            data:{
              itemPrice : amount___1,
              itemId : 'Deposit in wallet',
              orderID : data.orderID,
              txnID : data.paymentID,
            },
            dataType:'JSON',
            beforeSend:function(){
              $('.pay_btns___1').hide();
              $('.pay_btns_laoder___1').show();
            },
            success:function(resp){ 
              if(resp.status == 1) {
								accept_award123(instantId,7);
              } else {
                $('.pay_btns___1').show();
                $('.pay_btns_laoder___1').hide();
                swal(resp.msg);
              }
            }
          });
        });
      }
    }, '#paypal_btn___1');
}
function change_bank_transafer_url(amt){
	$('.bkd_url').attr('href',site_url+'wallet?bank-transfer=1&amount='+amt);
}

function show_tradesment_profile(id){
	$.ajax({
		type:'post',
		url:site_url+'users/show_tradesment_profile/'+id,
		beforeSend:function(){
			
		},
		success:function(res){
			$('#View_profileman').html(res);
			$('#View_profileman').modal('show');
		}
	});
}
$('#View_profileman').on('hidden.bs.modal', function () {
  $('#View_profileman').html('');
})
</script>

<!-- Modal -->
<?php if(isset($_GET['chat']) && !empty($_GET['chat'])){ ?>
<script>
$('.count_un_msg<?php echo $_GET['chat']; ?>').parent().click();
</script>
<?php } ?>


