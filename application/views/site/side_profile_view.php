	<script type="text/javascript" src="https://www.tradespeoplehub.co.uk/js/jquery.min.js"></script>
	
	<script type="text/javascript" src="https://www.tradespeoplehub.co.uk/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.tradespeoplehub.co.uk/js/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="https://www.tradespeoplehub.co.uk/js/scripts.js"></script>
	<script type="text/javascript" src="https://www.tradespeoplehub.co.uk/js/owl.carousel.min.js"></script>
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="profile-edit-white dashboard-white set-dashboardnw" >
      <div class="row">
        <div class="col-sm-3  col-xs-4 text-center">
          <div class="profile-pic over-profile" style="margin-bottom: 20px;width: 100%;height: 95px;border-radius: 5px;">
						<?php if($user_profile['profile']){ ?>
						<img src="<?= site_url(); ?>img/profile/<?= $user_profile['profile']; ?>" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
						<?php } else { ?>
						<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
						<?php } ?>
          </div>
        </div>
        <div class="col-sm-9 col-xs-8" style="padding-left:0px;">
          <div class="detaii_hh">
            <ul class="ul_set list_user">
              <li class="profile_user_name">
                <a target="_blank" href="<?php echo site_url().'profile/'.$user_profile['id']; ?>"><h4><?php echo $user_profile['trading_name']; ?></h4></a>
              </li>
              <li>
                <i class="fa fa-map-marker"></i>
                <?=$user_profile['city'];?>, <?=$user_profile['county'];?>
              </li>
              <li>
                <i class="fa fa-calendar"></i> Member since <?=date('M Y', strtotime($user_profile['cdate']));?>
              </li>
              <li>
								<span class="btn btn-warning btn-xs"><?=$user_profile['average_rate'];?></span>
								<span class="star_r">
									<?php
									for($i=1;$i<=5;$i++){
									if($i<=$user_profile['average_rate']) {
									?>
									<i class="fa fa-star active"></i>
									<?php }else{ ?>
									<i class="fa fa-star"></i>
									<?php } } ?>
								</span>
								<span> (<?=$user_profile['total_reviews'];?> reviews)</span>
							</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="setskil-padding add-border" >
        <div class="row">
          <div class="col-sm-12">
            <div class="">
              <div class="tabrrr_man">
                <ul class="ul_set mn_tab" role="tablist">
                  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">About Me</a></li>
                  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Portfolio Items</a></li>
                  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Reviews</a></li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="abouss dashboard-prot slidergg setskil-padding">
                      <div class="dashboard-profile">
                        
                      </div> 
											<?php if(!empty($user_profile['about_business'])){?>
												<div class="about_dmodal">
													<p><?=$user_profile['about_business']; ?></p>
					              </div>
											<?php }?>
											<div class="dashboard-prot edit-pro89 slidergg setskil-padding">
												<div class="row dashboard-profile">
													<div class="col-sm-12">
														<h2>Skills</h2>
													</div>
													<div class="col-md-11 setskill-pedi">
									<div class="">
										<?php if(!empty($user_profile['category'])){ ?>
										<div class="skills">
											<div class="row fix_col">
												<?php
												$selected_lang = explode(',',$user_profile['category']);
												$subcat = explode(',',$user_profile['subcategory']);
												$index = 0;

												foreach($category as $row) {
												if(in_array($row['cat_id'],array_merge($selected_lang , $subcat))) {
													$meta = str_replace(' ','-',$row['cat_name']);
													$meta = str_replace('&','-',$meta);
													$meta = str_replace('---','-',$meta);
													$meta = str_replace('--','-',$meta);
													$index++;
													$class = '';
													
													if($index > 19){
														$class = ' hide-skill';
													}
													?>
												<div class="col-sm-6<?=$class;?>">
														 
													<p class="set-tags12">
														<img src="<?= site_url(); ?>img/micn12.png" class="pro-img11"><span><?= $row['cat_name']; ?></span>
													</p>
												</div>
												<?php } ?>
												<?php } ?>
												<?php
												if($class == ' hide-skill'){
												?>
												<div class="col-sm-6">
													<img src="<?= site_url(); ?>img/micn12.png" class="pro-img11"><a id="show-more-btn" href="javascript:void(0)" onclick="show_hide_more();"> View all </a>
												</div>
												<?php } ?>
											</div>
										</div>
										<?php } else{ ?>
											<p>No Category Added</p>
										<?php } ?>
									</div>
								</div>
													<div class="col-sm-2"></div>
												</div>
											</div>
											<?php
											if($user_profile['is_qualification'] == 1 || $user_profile['insurance_liability'] == 'yes'){
											?>
											<div class="insurance-education-section setskil-padding">
												<div class="row">
													<?php
													if($user_profile['is_qualification'] == 1){
													?>
													<div class="dashboard-prot edit-pro89 slidergg ">
														<div class="dashboard-profile">
															<div class="col-md-12">
																<div class="experience-edit">
																	<h2>Qualifications</h2>
																	<div class="row">
																		<div class="col-sm-12">
																			<p><?=$user_profile['qualification'];?></p>
																		</div>
																	</div>
																		
																</div>
															</div>
																
														</div>
													</div>
													<?php } ?>
												</div>
											</div>
											
												<?php
												if($user_profile['insurance_liability'] == 'yes'){
												?>
												<div class="insurance-education-section setskil-padding">
													<div class="row">
														<div class="dashboard-prot edit-pro89 slidergg setmy-div">
															<div class="dashboard-profile">
																<div class="col-md-12">
																	<div class="experience-edit">
																		<h2>Public Insurance</h2>
																		<?php if($user_profile['insurance_liability'] == 'yes') { ?>
																		<div class="row position-edit-re">
																			<div class="col-sm-12">
																				<div class="riggg_e">
																					<div class="pub_inss1">
																						<p>
																							<span class="pub_inss3" style="width: 155px;">Valid until :</span> <span class="pub_inss3">
																								<?=date("d M Y", strtotime($user_profile['insurance_date']));?></span>
																							</p>
																							<!--
																							<p>Insured by : <small><b><?php echo $user_profile['insured_by']; ?></b></small></p>
																							-->
																							<p><span class="pub_inss3" style="width: 155px;">Limit of indemnity : </span><span class="pub_inss3"><!-- <i class="fa fa-gbp"></i> -->£<?php echo $user_profile['insurance_amount']; ?></span></p>
																					</div>
																							<div class="edit-action">
																								<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>
																								<a href="" data-target="#insurance_liability" data-toggle="modal"><i class="fa fa-pencil"></i></a>
																								<a href="<?php echo base_url(); ?>users/delete_insurance" onclick="return confirm('Are you sure you want to delete this insurance?');" ><i class="fa fa-trash-o"></i></a>
																								<?php } ?>
																							</div>
																						</div>
																					</div>
																				</div>
																			 <?php } else{ ?>
																			 <div class="row">
																					<div class="col-sm-1"></div>
																					<div class="col-sm-3">
																						 <p>No Insurance Added.</p>
																					</div>
																			 </div>
																			 <?php  } ?>
																		</div>
																 </div>
															</div>
													 </div>
													</div>
												</div>
												<?php } } ?>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="profile">
											<div class="dashboard-prot edit-pro89 slidergg setskil-padding">
												 <div class="dashboard-profile">
														
												 </div>
												<?php if(!empty($portfolio)){  ?>
												 <div class="img_container owl-carousel owl-theme other-post-view">
														<?php foreach($portfolio as $port){ ?>
														<a href="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" data-caption="" data-fancybox="images">
														<img class="owl-lazy" data-src="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" alt="">
														</a>
														<?php } ?>
												 </div>
												<?php } ?>
											</div>
									</div>
                  <div role="tabpanel" class="tab-pane" id="messages">
                    <div class="setskil-padding review-mail" id="search_data">
				
               <?php 
                  //$get_reviews=$this->common_model->get_users_reviews($this->uri->segment(2)); ?>
               <?php if(count($get_reviews)>0){ ?>
               <div class="review-pro">
                  <div class=" dashboard-profile edit-pro89">
                 
                  </div>
				  
                  <div class="min_h3">
                     <?php foreach ($get_reviews as $r) {
											 $job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
                        $get_users = $this->common_model->get_single_data('users',array('id'=>$r['rt_rateBy']));
                        ?>
						
			<div class="tradesman-feedback">
			  <div class="set-gray-box">
			  <p class="recent-feedback">
					<?php if($job_title['direct_hired']==1){ ?>
					<h4>Work for <?= $user_profile['trading_name'];?></h4>	
					<?php } else if($job_title['title']){ ?>
					<h4><?= $job_title['title'];?></h4>
					<?php } else { ?>
					<h4>Work for <?= $user_profile['trading_name'];?></h4>
					<?php } ?>
					</p>
				 <div class="from-group revie">
					<span class="btn btn-warning btn-xs"><?php if($r['rt_rate']!=''){ echo $r['rt_rate']; } ?>
					</span>
					<span class="star_r">
					<?php 
					   for($i=1;$i<=5;$i++){
								   if($r['rt_rate']) {
					   if($i<=$r['rt_rate']) { ?>  
					<i class="fa fa-star active"></i>
					<?php   } else{  ?>
					<i class="fa fa-star"></i>
					<?php  } } else  { ?> 
					<i class="fa fa-star"></i>
					<?php } ?>
					<?php } ?>
					</span>
				 </div>
                <div cite="/job/view/5059288" class="summary">
                  <p><?php echo $r['rt_comment']; ?></p>
                </div>
                <p class="tradesman-feedback__meta">By <strong class="job-author"><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></strong>&nbsp;on
                  <!--
                  <em class="job-date">13<sup>th</sup> Jul, 2019</em>
                  -->
                  <em class="job-date">
				  <?php 	
                     $time_ago = $this->common_model->time_ago($r['rt_create']); 
                   ?>
                    <?=$time_ago;  ?>
					</em>
                </p>
              </div>
              </div>
						
						
                     <?php } ?>
                     <hr>
                  </div>
               </div>
							 <?= $this->ajax_pagination->create_links(); ?>
               <?php } ?>
               
			   </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
		</div>
    <!--  <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
  </div>
</div>
<script>
   $('.owl-carousel').owlCarousel({
   		loop:false,
           pagination: false,
           slideSpeed: 700,
           paginationSpeed: 700,
           rewindSpeed: 700,
           lazyLoad: true,
   		margin:5,		
   		responsive:{
   			0:{
   				items:1
   			},
   			600:{
   				items:3
   			},
   			1000:{
   				items:6
   			}
   		}
   });
   
   $().fancybox({
     selector : '.owl-item:not(.cloned) a',
     hash   : false,
     thumbs : {
       autoStart : true
     },
   	beforeShow : function(){
      this.title =  this.title + " - " + $(this.element).data("caption");
     },
     buttons : [
       'zoom',
       'download',
       'close'
     ]
   });


  function show_hide_more(){
    $(".hide-skill").slideToggle();
    if ($("#show-more-btn").text() == "hide") {
      $("#show-more-btn").text('View all');
    }else {
      $("#show-more-btn").text('hide');
    }
  }
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var userid = '<?php echo $user_profile['id']; ?>';
	$.ajax({ 
		type:'POST',
		url:site_url+'users/find_rating_ajax/'+page_num,
		data:'page_num='+page_num+'&userid='+userid,
		dataType:'JSON',
		beforeSend:function()
		{
			$('.search_btn').prop('disabled',true);
			$('.btn_loader').show();
		},
		success:function(resp)
		{
			$('.search_btn').prop('disabled',false);
			$('.btn_loader').hide();
			$('#search_data').html(resp.data);
		}
	});
	return false;
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css">

