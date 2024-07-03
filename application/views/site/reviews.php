<?php include ("include/header.php"); ?>
<?php include ("include/top.php"); ?>

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
<div class="acount-page membership-page project-list">
  <?php 
	$get_bid_post=$this->common_model->get_paybids('tbl_jobpost_bids',$_REQUEST['post_id']); 
	
	$get_users=$this->common_model->get_single_data('users',array('id'=>$get_bid_post[0]['bid_by'])); 
	
	$get_users_post=$this->common_model->get_single_data('users',array('id'=>$get_bid_post[0]['posted_by'])); 
	
	?>
	
	<?php
	$my_id = $this->session->userdata('user_id');
	if($my_id != $get_bid_post[0]['posted_by'] && $my_id != $get_bid_post[0]['bid_by']){
		redirect('dashboard');
	}
	?>
	<div class="container">
		<div class="row">
			 
			<?php if($this->session->flashdata('error1')) { ?>
        
			<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
          
			<?php } ?>
         
			<?php if($this->session->flashdata('success1')) { ?>
					
			<p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
          
			<?php } ?>
			  
			<div class="col-sm-9">
				<?php 
							 
				$ratecount=$this->common_model->get_rating($_REQUEST['post_id'],$this->session->userdata('user_id'));
				//echo $this->db->last_query();
				//print_r($ratecount);
				if(count($ratecount)==0){ ?>
				
				<div class="dashboard-white">
         
					<div class="row">
						<div class="col-sm-10">
							<div class="hide"><?php echo $this->session->flashdata('success2'); ?></div>
							<?php if($this->session->userdata('type')==1){ ?>
							<p class=""><b>Share your experience and help thousands of people make a smarter choice on Tradespeoplehub. </b></p>
							<?php } else { ?>
							<p class=""><b>Share your experience and help thousands of people make a smarter choice on Tradespeoplehub. </b></p>
							<?php } ?>
							
							
						</div>
						
						<div class="col-sm-2">
							<div class="pull-right">
							  
							 <?php if(strtotime($review_close_date) >= strtotime(date('Y-m-d'))){ ?>
							 <a href="#" data-target="#mark_as_complete<?php echo $_REQUEST['post_id']; ?>" data-toggle="modal"><button class="btn btn-primary">Please leave a review</button></a>
<?php if(isset($_GET['is_invited']) && !empty($_GET['is_invited'])){ ?>
<script>
$(document).ready(function(){
	$('#mark_as_complete<?php echo $_REQUEST['post_id']; ?>').modal('toggle');
});
</script>
<?php } ?>							 
							 <?php } ?>
							</div>
						</div>
						
						
					
<div class="modal fade popup" id="mark_as_complete<?php echo $_REQUEST['post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: left">Please leave your feedback and rating for this project</h4>
			</div>
			<form method="post" id="marks_as_complete<?php echo $_REQUEST['post_id']; ?>" onsubmit="return mark_complete(<?php echo $_REQUEST['post_id']; ?>);">
				<div class="modal-body">
					<?php if(isset($_GET['is_invited']) && !empty($_GET['is_invited'])){ ?>
					<p>Leave a review here if you have hired this tradesperson to complete any work around your home and would like to share your thought with other customers.</p>
					<?php } ?>
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
									<input type="hidden" name="bid_by" value="<?php echo $get_bid_post[0]['bid_by']; ?>">
									<input type="hidden" name="posted_by" value="<?php echo $get_bid_post[0]['posted_by']; ?>">
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
					</div>
      
				</div>
				<?php } ?>
				<?php  
				if($reviews){ 
				
				$get_jobs=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$_REQUEST['post_id'])); 
				
				$get_homeowner=$this->common_model->get_single_data('users',array('id'=>$reviews[0]['rt_rateBy'])); 
				
				?>
				<h3 style="font-size: 20px;"><b>Your Review</b></h3>
				<div class="dashboard-white dashboard-white2">
					<div class="row">
						<div class="col-sm-8">
							<div class="img-name1">
								<?php if($get_homeowner['profile']){ ?>                                 
								<img src="<?= site_url(); ?>img/profile/<?= $get_homeowner['profile']; ?>" class="pro-img">
															
								<?php } else { ?>
												 
								<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
														 
								<?php } ?> 
											 
								<div class="names1">
									<h4><b><?php echo $get_homeowner['f_name'].' '.$get_homeowner['l_name']; ?></b></h4>
									<div class="from-group revie">
										<span class="btn btn-warning btn-xs"><?php echo $reviews[0]['rt_rate']; ?>
										</span>
										<span class="star_r">
										<?php for($i=1;$i<=5;$i++){ ?>
										<?php if($reviews[0]['rt_rate']) { ?>
										<?php if($i<=$reviews[0]['rt_rate']) { ?>  
										
										<i class="fa fa-star active"></i>
										
										<?php } else { ?>
								 
										<i class="fa fa-star"></i>
										
										<?php } ?>

										<?php } else { ?> 
										
										<i class="fa fa-star"></i>
										
										<?php } ?>
										
										<?php } ?>
										</span>
									</div>

									<p><?php echo $reviews[0]['rt_comment']; ?></p>
								</div>
							</div>
						</div>
								 
						<div class="col-sm-4">
							<div class="text-right">
								<p>
								<?php  
								$time_ago = $this->common_model->time_ago($reviews[0]['rt_create']); 
								echo $time_ago; ?>
								</p>
							 

							</div>
						</div>
					</div>
				</div>
				<?php } ?>
             
				<?php if($this->session->userdata('type')==1){ 
				
				$getreviews=$this->common_model->get_trade_feed($get_bid_post[0]['posted_by'],$_REQUEST['post_id']);
				
				if($getreviews){ ?>
				
				<h3 style="font-size: 20px;"><b>Review from <?php echo $get_users_post['f_name'].' '.$get_users_post['l_name']; ?></b></h3>
                
				<div class="dashboard-white dashboard-white2">
					<div class="row">
						<div class="col-sm-8">
							<div class="img-name1">
								<?php $link = ($get_users_post['type']==1)?base_url('profile/'.$get_users_post['id']):'javascript:void(0);'; ?>
								<?php if($get_users_post['profile']){
								?>   
								
                <a href="<?php echo $link; ?>"><img src="<?= site_url(); ?>img/profile/<?= $get_users_post['profile']; ?>" class="pro-img"></a>
								
								<?php } else { ?>
								
								<a href="<?php echo $link; ?>"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img"></a>
								<?php } ?>
                       
								<div class="names1">
									
									<h4><b><?php echo $get_users_post['f_name'].' '.$get_users_post['l_name']; ?></b></h4>
									<div class="from-group revie">
										<span class="btn btn-warning btn-xs"><?php echo $getreviews[0]['rt_rate']; ?> </span>
										<span class="star_r">
											<?php for($i=1;$i<=5;$i++){ ?>
                      <?php if($getreviews[0]['rt_rate']) { ?>
                      <?php if($i<=$getreviews[0]['rt_rate']) { ?>  
											
											<i class="fa fa-star active"></i>
											
											<?php  } else{ ?>
                     
											<i class="fa fa-star"></i>
											
											<?php } ?>

											<?php }  else { ?> 
											
											<i class="fa fa-star"></i>
											
											<?php } ?>
											
											<?php } ?>

										</span>
									</div>

									<p><?php echo $getreviews[0]['rt_comment']; ?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="text-right">
								<p>
								<?php  
								$time_ago = $this->common_model->time_ago($getreviews[0]['rt_create']); 
								
								echo $time_ago; 

								?>
								</p>
                 

							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php }else { 
				
				$getreviews=$this->common_model->get_trade_feed($get_bid_post[0]['bid_by'],$_REQUEST['post_id']); 
				
				if($getreviews){  ?>
                             
					<h3 style="font-size: 20px;"><b>Review from <?php echo $get_users['trading_name']; ?></b></h3>
                 
					<div class="dashboard-white dashboard-white2">
						<div class="row">
							<div class="col-sm-8">
								<div class="img-name1">
									<?php $link = ($get_users['type']==1)?base_url('profile/'.$get_users['id']):'javascript:void(0);'; ?>
									<?php if($get_users['profile']){ ?>   
									<a href="<?php echo $link; ?>"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img"></a>
									<?php } else { ?>
                  <a href="<?php echo $link; ?>"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img"></a>
                  <?php } ?>
									<div class="names1">
										<h4><b><?php echo $get_users['trading_name']; ?></b></h4>
										<div class="from-group revie">
											<span class="btn btn-warning btn-xs"><?php echo $getreviews[0]['rt_rate']; ?></span>
											<span class="star_r">
												<?php for($i=1;$i<=5;$i++){ ?>
												<?php if($getreviews[0]['rt_rate']) { ?>
												<?php if($i<=$getreviews[0]['rt_rate']) { ?>
												
												<i class="fa fa-star active"></i>
												
												<?php  } else{ ?>
												
												<i class="fa fa-star"></i>
												<?php } ?>

												<?php } else { ?> 
												
												<i class="fa fa-star"></i>
												
												<?php } ?>
												
												<?php } ?>
											</span>
										</div>

										<p><?php echo $getreviews[0]['rt_comment']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="text-right">
									<p><?php  $time_ago = $this->common_model->time_ago($getreviews[0]['rt_create']); 
                  echo $time_ago; 
									?></p>
                 

								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php } ?>

			</div>
            
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>
<script type="text/javascript">
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
</script>