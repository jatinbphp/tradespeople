<?php 
  include 'include/header.php';
  $user_id = $this->session->userdata('user_id');
  //print_r($this->common_model->check_postalcode('W22SZ'));
?>
<style>
.tox-toolbar__primary{
	display:none !important;
}
.add-top-border {
	border-top: 1px solid #e1e1e1;
}

.liskk2 li a {
	padding: 6px 10px;
	color: #000!important;
	width: 100%;
	display: inline-block;
	border:none;
}

.liskk2 li a:hover{
	color:#3d78cb;
}
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}

</style>
<div class="">
	<div  class="imgbbg">
		<div class="main_bg_line">
			<div class="container">
				<ul class="page_linkk ul_set">
        <li>
          Find tradesman
        </li>
        <li>
          <?php echo ucfirst($user_profile['county']); ?>
        </li>
				<li>
          <?php echo ucfirst($user_profile['city']); ?>
        </li>
				<li>
          <?php
					$len = (strlen($user_profile['postal_code'])>=7)?4:3;
									
					echo strtoupper(substr($user_profile['postal_code'],0,$len));
					?>
        </li>
				<li>
          <?php echo ucfirst($user_profile['trading_name']); ?>
        </li>
      </ul>
			</div>
		</div>
		<!-- <img src="<?php echo site_url(); ?>img/profile-cover.png" class="img_r"> -->
		<div class="uerr_hire">
			<div class="container">
				<div class="row">
					<div class="col-sm-9 my_cs_col_9">
						<div class="profile-edit-white dashboard-white set-dashboardnw">
							<div class="row">
								<div class="col-sm-2  col-xs-4 text-center">
									<div class="profile-pic over-profile" style="margin-bottom: 20px;width: 100%;height: 95px;border-radius: 5px;">
										<?php if($user_profile['profile']){ ?>
										<img src="<?= site_url(); ?>img/profile/<?= $user_profile['profile']; ?>" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
										<?php } else { ?>
										<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
										<?php } ?>
										
										<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>  
										<a href="" data-target="#edit_profile" data-toggle="modal">
											<div class="status-user pro-pic-edit">
												<i class="fa fa-camera" aria-hidden="true"></i>
											</div>
										</a>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-10 col-xs-8" style="padding-left:0px;">
									<div class="detaii_hh">
										<ul class="ul_set list_user">
											<li class="profile_user_name">
												<h4> <?php echo $user_profile['trading_name']; ?></h4>
											</li>
											<li>
												<i class="fa fa-map-marker"></i>
												<?=$user_profile['city'];?>
												
											</li>
											<li>
												<i class="fa fa-calendar"></i> 
													<?=date('M Y', strtotime($user_profile['cdate']));?>
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
												<span> <b>(<?=$user_profile['total_reviews'];?> reviews)</b></span>
											</li>										
										</ul>										
									</div>
								</div>
							</div>

							<?php if($this->session->flashdata('error1')) { ?>
								<script>swal("<?php echo $this->session->flashdata('error1'); ?>");</script>
							<?php } if($this->session->flashdata('success1')) { ?>
								<script>swal("<?php echo $this->session->flashdata('success1'); ?>");</script>
							<?php } ?>

							<div class="liskk2">
								<ul class="ul_set w3-bar w3-black">
									<li class="active"><a href="javascript:void(0)" onclick="openProfileTab('about-me')">Abount Me</a></li>
									<li><a href="javascript:void(0)" onclick="openProfileTab('my-services')">My Services</a></li>
									<li><a href="javascript:void(0)" onclick="openProfileTab('portfolio')">Portfolio</a></li>
									<li><a href="javascript:void(0)" onclick="openProfileTab('reviews')">Reviews</a></li>
								</ul>
							</div>

							<div id="about-me" class="w3-container sTab">
								<?php if(!empty($user_profile['about_business'])){?>
									<div class="setskil-padding add-border" style="border-top:0!important; margin-top: 0;">
										<div class="row">
											<div class="col-sm-12">
												<div class="user_stext5">
													 <p><?=$user_profile['about_business']; ?> </p>
												</div>
											</div>
										</div>
										<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?> 
										<div class="row">
											<div class="col-md-12">
												<div class="pull-right" style="display: inline-block; margin-top: 10px;">   
													<a class="btn btn-warning" href="" data-target="#profile_summary" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
												</div>
											</div>
										</div>
										<div class="modal fade popup" id="profile_summary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">About your business</h4>
													</div>
													<form method="POST" id="imageEdit" action="<?php echo base_url('users/update_data/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data" onsubmit="return update_profile2();">
														<div class="modal-body">
															<fieldset>
																<!-- Text input-->
																<div class="form-group">
																	<textarea class="form-control textarea" placeholder="About your business" name="about_business"><?=$user_profile['about_business']; ?></textarea>
																	
																</div> 
															</fieldset>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-warning submit_btn13">Update</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<?php } ?>
									</div>
								<?php } ?>						
										
								<div class="dashboard-prot edit-pro89 slidergg setskil-padding <?php if(empty($user_profile['about_business'])){ echo 'add-top-border'; } ?> ">
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
											
										<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>
										<div class="col-md-12">
											<div class="pull-right margintop10">
												<a class="btn btn-warning" href="<?= base_url() ?>trades" >+ Add Skills</a>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>

								<?php if($user_profile['is_qualification'] == 1 || $user_profile['insurance_liability'] == 'yes'){ ?>
									<div class="insurance-education-section setskil-padding">
										<div class="row">
											<?php if($user_profile['is_qualification'] == 1){ ?>
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
						  
									<?php if($user_profile['insurance_liability'] == 'yes'){ ?>
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
																						<span class="pub_inss3" style="width: 155px;">Valid until :</span> 
																						<span class="pub_inss3">
					                                    <?=date("d M Y", strtotime($user_profile['insurance_date']));?></span>
					                                </p>
					                                  <!--
					                                  <p>Insured by : <small><b><?php echo $user_profile['insured_by']; ?></b></small></p>
					                                  -->
					                                <p>
					                                	<span class="pub_inss3" style="width: 155px;">Limit of indemnity : </span>
					                                	<span class="pub_inss3"><!-- <i class="fa fa-gbp"></i> -->£<?php echo $user_profile['insurance_amount']; ?></span>
					                                </p>
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
				                        <?php } ?>
				                      </div>
				                    </div>
				                    <?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ 
				                    	if(empty($user_profile['insurance_liability'])){ ?>
					                     	<div class="col-md-12">
					                        <div class="pull-right margintop10">
					                           <a class="btn btn-warning" href="" data-target="#insurance_liability" data-toggle="modal">+ Public Insurance</a>
					                        </div>
					                    	</div>
				                    <?php } }?>
				                  </div>
				               	</div>
				              </div>
				            </div>
		              <?php } ?>
		            <?php } ?>
							</div>

							<div id="my-services" class="w3-container sTab client-reviews profile-service-list pt-4" style="display:none">
								<?php if(!empty($my_services)):?>
									<ul id="reviewList" style="margin-top:0">
										<?php foreach($my_services as $service):?>
											<li>
												<div class="profile-img">
													<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
													<?php if (file_exists($image_path) && $service['image']): ?>
													<?php
						                $mime_type = get_mime_by_extension($image_path);
						                $is_image = strpos($mime_type, 'image') !== false;
						                $is_video = strpos($mime_type, 'video') !== false;
						              ?>
													<?php 
														if(isset($service['image']) && !empty($service['image'])){
															$serviceImg = base_url('img/services/'.$service['image']);
														}else{
															$serviceImg = base_url('img/default-img.png');
														}														
													?>
													<?php if ($is_image): ?>
														<img src="<?php echo $serviceImg; ?>" alt="<?php echo $service['service_name']; ?>" />
													<?php elseif ($is_video): ?>
														<video src="<?php echo base_url('img/services/') . $service['image']; ?>" 
                                type="<?php echo $mime_type; ?>" loop controls class="profileServiceVideo">
                            </video>
                          <?php endif; ?>  
                          <?php endif; ?>  
												</div>
												<div class="review-right">
													<div class="review-name">
														<p>
															<?php
																$totalChr = strlen($service['description']);
																if($totalChr > 180 ){
																	echo substr($service['description'], 0, 180).'...';		
																}else{
																	echo $service['description'];
																}
															?>
														</p>														
													</div>
													<div class="star-total">
														<span><?php echo time_ago($service['created_at']); ?></span>
														<?php if($service['total_reviews'] > 0): ?>
															<div>
															<div class="review-star">
																<?php
																	for($i=1; $i<=$service['average_rating']; $i++){
																		echo '<i class="fa fa-star" aria-hidden="true"></i>';
																	}
																?>										
															</div>
															<div class="review-text"><p><?php echo $service['total_reviews']; ?></p></div>
															</div>
														<?php endif; ?>	
													</div>													
												</div>
											</li>
										<?php endforeach;?>	
									</ul>
								<?php endif;?>	
							</div>

							<div id="portfolio" class="w3-container sTab pt-4" style="display:none">
								<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>
									<div class="edit-pro89 slidergg pro-imgad">
										 <!-- <div class="dashboard-profile">
												<h2>Portfolio</h2>
										 </div> -->
										 <div class="row">
												<?php if(!empty($portfolio)){  ?>
													<?php foreach($portfolio as $port){ ?>
														<div class="col-sm-3">
															 <div class="pro-port change_image_d">
																	<div class="pro-port-img">
																		 <img src="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" class="img-responsive">
																		 <div class="pro-port-ablt">
																				<p>
																					 <?php if($user_id==$this->uri->segment(2)){ ?> 
																					 <a href="javascript:void(0);" class="btn btn-default btn-sm" data-target="#edit_portfolio-popup<?php echo $port['id']; ?>" data-toggle="modal"><i class="fa fa-pencil-square-o"></i></a> 
																					 <a href="<?php echo base_url(); ?>users/delete_portfolio/<?php echo $port['id']; ?>" onclick="return confirm('Are you sure you want to delete this portfolio?');"  class="btn btn-default btn-sm">
																					 <i class="fa fa-trash-o"></i>
																					 </a> 
																					 <?php } ?>
																					 <a href="" data-target="#portfolio-popup<?php echo $port['id']; ?>" data-toggle="modal" class="btn btn-default btn-sm">
																					 <i class="fa fa-eye"></i>
																					 </a>
																				</p>
																		 </div>
																	</div>
															 </div>
														</div>
														<div class="modal fade popup" id="edit_portfolio-popup<?php echo $port['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	 <div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																			<h4 class="modal-title" id="myModalLabel">Edit Portfolio</h4>
																	 </div>
																	 <form method="POST" action="<?php echo base_url('users/edit_portfolio/'.$port['id']); ?>" enctype="multipart/form-data" onsubmit="return edit_portfolio();">
																			<div class="modal-body">
																				 <div class="port_msg<?php echo $port['id']; ?>"></div>
																				 <fieldset>
																						<div class="form-group">
																							 <label class="col-md-12 control-label" for="textinput">Upload File <small>(Maximum file size: 20MB)</small></label>  
																							 <div class="col-md-12">
																									<input type="file" onchange="check_file_size(this,<?php echo $port['id']; ?>);" class=" input-md upload_size" name="port_image" <?php if(empty($port['port_image'])){ ?> required="" <?php } ?>>   
																									<input type="hidden" name="port_image_old" value="<?= $port['port_image']; ?>">  
																							 </div>
																							 <div class="col-md-12">
																									<img src="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" class="img-responsive" width="100" height="80">
																							 </div>
																						</div>
																				 </fieldset>
																			</div>
																			<div class="modal-footer">
																				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																				 <button type="submit" class="btn btn-warning submit_btn5 port_btn<?php echo $port['id']; ?>">Save</button>
																			</div>
																	 </form>
																</div>												
															</div>
														</div>
														<div class="modal fade" id="portfolio-popup<?php echo $port['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
															<div class="modal-dialog modal-lg" role="document">
																<div class="modal-content">
																	 <div class="modal-header" style="border:0px; padding:0px">
																			<button type="button" class="close lg-popu" data-dismiss="modal" aria-label="Close" style="margin: 5px 13px; position: static;"><span aria-hidden="true">&times;</span></button>
																	 </div>
																	 <div class="modal-body port-deatil" style="padding:0px;">
																			<div class="row">
																				 <div class="col-sm-12 popu-div-width">
																						<div class="pop-img">
																							 <img src="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" class="img-responsive" />
																						</div>
																				 </div>
																			</div>
																	 </div>
																</div>
															</div>
														</div>
												<?php } }?>
										 </div>
										<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>  
										 <div class="row">
												<div class="col-md-12">
													 <div class="pull-right margintop10"> 
															<a class="btn btn-warning" href="" data-target="#portfolio" data-toggle="modal">+ Add Portfolio</a>
													 </div>
												</div>
										 </div>
										<?php } ?>
									</div>
								<?php } else { ?>
									<?php if(!empty($portfolio)){  ?>						
										<div class="dashboard-prot edit-pro89 slidergg setskil-padding">
											<div class="dashboard-profile">
												<h2>Portfolio</h2>
										 	</div>
										 	<div class="img_container owl-carousel owl-theme other-post-view">
												<?php foreach($portfolio as $port){ ?>
												<a href="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" data-caption="" data-fancybox="images">
												<img class="owl-lazy" data-src="<?= site_url(); ?>img/profile/<?= $port['port_image']; ?>" alt="">
												</a>
												<?php } ?>
										 	</div>
										</div>
									<?php }?>
								<?php } ?>
							</div>

							<div id="reviews" class="w3-container sTab" style="display:none">
								<div class="setskil-padding review-mail" id="search_data">

									<div class="rating">
										<ul>
											<li>
												<p>Overall Rating</p><div class="star"><span></span> <?php echo number_format($overallRating,2); ?></div>
											</li>

											<li>
												<p>Recommend to a friend</p>
												<div class="star"><span></span> 
													<?php echo $referalRating; ?>
												</div>
											</li>

											<li>
												<p>Service as described</p>
												<div class="star"><span></span>
													<?php echo !empty($serviceAvgRating[0]['average_rating']) ? number_format($serviceAvgRating[0]['average_rating'],2) : 0; ?>
												</div>
											</li>
										</ul>
									</div>

			            <?php if(count($get_reviews)>0){ ?>
			            	<div class="review-pro">
			               <!--  <div class=" dashboard-profile edit-pro89">
			                   <h2>Reviews</h2>
			                </div>		 -->		  
			                <div class="min_h3">
			                  <?php foreach ($get_reviews as $r) {
												 	$job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
			                    $get_users = $this->common_model->get_single_data('users',array('id'=>$r['rt_rateBy']));
			                  ?>
								
													<div class="tradesman-feedback">
													  <div class="set-gray-box reviews">
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
													  			<?php $time_ago = $this->common_model->time_ago($r['rt_create']); ?>
										          		<?=$time_ago;  ?>
																</em>
										          </p>
										        </div>
										      </div>
												  <div class="reviewmarg" style="display:none;">
								             <div class="row">
								                <div class="col-sm-12">
								                   <div class="img-name1 set-ct">
								                      <?php if($get_users['profile']){  ?>                                 
								                      <img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img">
								                      <?php } else { ?>
								                      <img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img">
								                      <?php } ?> 
								                      <div class="names1">
								                         <h5><b><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?> </b></h5>
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
								                         <p><?php echo $r['rt_comment']; ?></p>
								                      </div>
								                   </div>
								                </div>
								                <div class="col-sm-12">
								                   <?php 	
								                      $time_ago = $this->common_model->time_ago($r['rt_create']); 
								                      ?>
								                   <p class="pull-right time-ago"><?=$time_ago;  ?></p>
								                </div>
								             </div>
								          </div>
			                  <?php } ?>
			                  <hr>
			                </div>
			             	</div>
									 	<?= $this->ajax_pagination->create_links(); ?>
			            <?php } ?>
			            <div style="display:none;">
			              <a href="#" class="btn btn-default"> Leave a Review</a>
			            </div>
						   	</div>
							</div>
	          </div>
	               
						<div class="modal fade popup" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	              <div class="modal-dialog" role="document">
	                 <div class="modal-content">
	                    <div class="modal-header">
	                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                       <h4 class="modal-title" id="myModalLabel">Edit Profile Image</h4>
	                    </div>
	                    <form method="POST" id="imageEdit" action="<?php echo base_url('users/update_image/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data" onsubmit="return update_profile1();">
	                       <div class="modal-body">
	                          <fieldset>
	                             <!-- Text input-->
	                             <div class="form-group">
	                                <label class="col-md-12 control-label" for="textinput">Image</label>  
	                                <div class="col-md-12">
	                                   <input type="file" onchange="check_file_size(this,'_0');" class="upload_size" name="u_profile" id="u_profile" accept="image/*">
	                                   <input type="hidden" name="u_profile_old" value="<?= $user_profile['profile']; ?>">  
	                                </div>
	                             </div>
	                             <div class="col-md-12">
	                                <div class="perview_pro_img"></div>
	                             </div>
	                          </fieldset>
	                       </div>
	                       <div class="modal-footer">
	                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                          <button type="submit" class="btn btn-warning submit_btn7 port_btn_0">Update</button>
	                       </div>
	                    </form>
	                 </div>
	              </div>
	          </div>
								 
						<div class="modal fade popup" id="portfolio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								 <div class="modal-content">
										<div class="modal-header">
											 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											 <h4 class="modal-title" id="myModalLabel">Add Portfolio</h4>
										</div>
										<form method="POST" action="<?php echo base_url('users/add_portfolio'); ?>" enctype="multipart/form-data" onsubmit="return add_portfolio();">
											 <div class="modal-body">
													<div class="port_msg0"></div>
													<fieldset>
														
														 <div class="form-group">
																<label class="col-md-12 control-label" for="textinput">Upload File <small>(Maximum file size: 20MB)</small></label>  
																<div class="col-md-12">
																	 <input type="file" onchange="check_file_size(this,0);" class=" input-md upload_size" name="port_image" id="port_image"  accept="image/*" required="">   
																</div>
																<div class="col-md-12">
																	 <div class="perview_pro_img1"></div>
																</div>
														 </div>
													</fieldset>
											 </div>
											 <div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-warning submit_btn port_btn0 submit_btn1">Save</button>
											 </div>
										</form>
								 </div>
							</div>
						</div>
	              
						<?php if($this->session->flashdata('error2')) { ?>
	          	<script>swal("<?php echo $this->session->flashdata('error2'); ?>");</script>
	           <?php } if($this->session->flashdata('success2')) { ?>
	          	<script>swal("<?php echo $this->session->flashdata('success2'); ?>");</script>
	          <?php  } ?>

	               
						<?php if($this->session->flashdata('error3')){ ?>
		        	<script>swal("<?php echo $this->session->flashdata('error3'); ?>");</script>
		        <?php } if($this->session->flashdata('success3')) { ?>
		        	<script>swal("<?php echo $this->session->flashdata('success3'); ?>");</script>
		        <?php } ?>

	          <div class="dashboard-white edit-pro89" style="display: none;">
	              <div class="row dashboard-profile">
	                 <div class="col-md-12">
	                    <div class="experience-edit">
	                       <h2>Publications</h2>
	                       <!--<p>No Certifications Added</p>-->
	                       <?php if(!empty($publications)){ ?>
	                       <?php foreach ($publications as $p) { ?>
	                       <div class="row position-edit-re">
	                          <div class="col-sm-12">
	                             <div class="riggg_e">
	                                <h4><?php echo $p['heading']; ?></h4>
	                                <p><small><?php echo $p['title']; ?></small></p>
	                                <p><small><?php echo $p['description']; ?></small></p>
	                                <div class="edit-action">
	                                   <?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>   
	                                   <a href="" data-target="#edit_certificate-popup<?php echo $p['id']; ?>" data-toggle="modal"><i class="fa fa-pencil"></i></a>
	                                   <a href="<?php echo base_url(); ?>users/delete_publication/<?php echo $p['id']; ?>" onclick="return confirm('Are you sure you want to delete this publication?');" ><i class="fa fa-trash-o"></i></a>
	                                   <?php } ?>
	                                </div>
	                             </div>
	                          </div>
	                       </div>
	                       <div class="modal fade popup" id="edit_certificate-popup<?php echo $p['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	                          <div class="modal-dialog" role="document">
	                             <div class="modal-content">
	                                <div class="modal-header">
	                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                                   <h4 class="modal-title" id="myModalLabel">Edit Publication</h4>
	                                </div>
	                                <form method="POST" action="<?php echo base_url('users/edit_publication/'.$p['id']); ?>" enctype="multipart/form-data" onsubmit="return edit_certificate();">
	                                   <div class="modal-body">
	                                      <div class="form-group">
	                                         <label class="col-md-12 control-label" for="textinput">Publication Name</label>  
	                                         <div class="col-md-12">
	                                            <input id="textinput" name="heading" value="<?php echo $p['heading']; ?>"  class="form-control input-md" type="text" required="">                
	                                         </div>
	                                      </div>
	                                      <!-- Text input-->
	                                      <div class="form-group">
	                                         <label class="col-md-12 control-label" for="textinput">Publication Title</label>  
	                                         <div class="col-md-12">
	                                            <input id="textinput" name="title"  class="form-control input-md" value="<?php echo $p['title']; ?>" type="text" required="">
	                                         </div>
	                                      </div>
	                                      <div class="form-group">
	                                         <label class="col-md-12 control-label" for="textinput">Describe Publication</label>  
	                                         <div class="col-md-12">
	                                            <textarea id="textinput" name="description"  class="form-control input-md"><?php echo $p['description']; ?></textarea>                
	                                         </div>
	                                      </div>
	                                   </div>
	                                   <div class="modal-footer">
	                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                                      <button type="submit" class="btn btn-warning submit_btn6">Save</button>
	                                   </div>
	                                </form>
	                             </div>
	                          </div>
	                       </div>
	                       <?php } }else { ?>
	                       <div class="row">
	                          <div class="col-sm-1"></div>
	                          <div class="col-sm-3">
	                             <p>No Publication Added.</p>
	                          </div>
	                       </div>
	                       <?php } ?>   
	                    </div>
	                 </div>
	                       <?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>
	                 <div class="col-md-12">
	                    <div class="pull-right margintop10">
	                       <a class="btn btn-warning" href="" data-target="#Certifications" data-toggle="modal">+ Publication</a>
	                    </div>
	                 </div>
	                       <?php } ?>
	              </div>
	          </div>
	          
	          <?php  if($this->session->flashdata('error4'))  { ?>
	          	<script>swal("<?php echo $this->session->flashdata('error4'); ?>");</script>
	          <?php } ?>
	          <?php if($this->session->flashdata('success4'))  { ?>
	          	<script>swal("<?php echo $this->session->flashdata('success4'); ?>");</script>
	          <?php } ?>
	               
	         	<div class="dashboard-white edit-pro89" style="display:none;">
	            <div class="row dashboard-profile">
	               <div class="col-md-12">
	                  <div class="experience-edit">
	                     <h2>Company Details</h2>
	                     <?php if($user_profile['company']) { ?>
	                     <div class="row position-edit-re">
	                        <div class="col-sm-12">
	                           <div class="riggg_e">
	                              <p>Title : <b><?php echo $user_profile['company']; ?></b></p>
	                              <p>Business Type : <small><b><?php $type=$this->common_model->get_single_data('business_types',array('id'=>$user_profile['business_type'])); echo $type['business_name']; ?></b></small></p>
	                              <p>No. of Employees : <b><small> <?php echo $user_profile['no_of_employee']; ?></small></b></p>
	                              <div class="edit-action">
	                                 <?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>
	                                 <a href="<?php echo base_url('company'); ?>"><i class="fa fa-pencil"></i></a>
	                                 <?php } ?>
	                              </div>
	                           </div>
	                        </div>
	                     </div>
	                     <?php } else{ ?>
	                     <div class="row">
	                        <div class="col-sm-1"></div>
	                        <div class="col-sm-3">
	                           <p>No Company Details Added.</p>
	                        </div>
	                     </div>
	                     <?php  } ?>
	                  </div>
	               </div>
	            </div>
	         	</div>
	        </div>

	        <div class="modal fade popup" id="insurance_liability" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	           <div class="modal-dialog" role="document">
	              <div class="modal-content">
	                 <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="myModalLabel">Add Insurance</h4>
	                 </div>
	                 <form method="POST" action="<?php echo base_url('users/add_insurance'); ?>" enctype="multipart/form-data" onsubmit="return add_certification();">
	                    <div class="modal-body">
	                       <fieldset>
	                          <!-- Text input-->
	                          <div class="form-group">
	                             <label class="col-md-12 control-label" for="textinput">Insurance Title</label>  
	                             <div class="col-md-12">
	                                <input id="textinput" name="insurance_liability"  class="form-control input-md" value="<?php echo $user_profile['insurance_liability']; ?>" type="text" required="">                
	                             </div>
	                          </div>
	                          <input type="hidden" name="test123" value="<?php echo $user_profile['insurance_liability']; ?>">
	                          <!-- Text input-->
	                          <div class="form-group">
	                             <label class="col-md-12 control-label" for="textinput"> Insured By</label>  
	                             <div class="col-md-12">
	                                <input id="textinput" name="insured_by" value="<?php echo $user_profile['insured_by']; ?>"  class="form-control input-md" type="text" required="">
	                             </div>
	                          </div>
	                          <!-- Text input-->
	                          <div class="form-group">
	                             <label class="col-md-12 control-label" for="textinput">Insurance Amount</label>  
	                             <div class="col-md-12">
	                                <input id="textinput" name="insurance_amount"  value="<?php echo $user_profile['insurance_amount']; ?>" class="form-control input-md" type="number" required="">                
	                             </div>
	                          </div>
	                          <div class="form-group">
	                             <label class="col-md-12 control-label" for="textinput">Insurance Date</label>  
	                             <div class="col-md-12">
	                                <input id="textinput" name="insurance_date" value="<?php echo $user_profile['insurance_date']; ?>"  class="form-control input-md" type="date" required="">                
	                             </div>
	                          </div>
	                       </fieldset>
	                    </div>
	                    <div class="modal-footer">
	                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                       <button type="submit" class="btn btn-warning submit_btn4">Save</button>
	                    </div>
	                 </form>
	              </div>
	           </div>
	        </div>

	        <div class="col-sm-3 my_cs_col_3">
	           <?php if($user_id!=$this->uri->segment(2)){ ?>  
	           <div class="dashboard-white edit-pro89 dark_Contact">
	              <div class="dashboard-profile ">
	                 <div id="msg"></div>
	                 <h2>Contact <?php echo $user_profile['trading_name']; ?> about your job</h2>
	                 <form method="post" id="direct_hire" enctype="multipart/form-data" onsubmit="return direct_send_msg();">
	                    <div class="from-group">
	                       <label>Send a private message</label>
	                       <!-- <textarea class="form-control" style="height: 120px;" name="message" required>Hi <?php echo $user_profile['trading_name']; ?>, I noticed your profile and would like to offer you my project. We can discuss any details over chat.</textarea> -->
	                       <textarea class="form-control" style="height: 120px;" id="direct_msg" name="ch_msg" required>Hi <?php echo $user_profile['trading_name']; ?>, I noticed your profile and would like to offer you my project. We can discuss any details over chat.</textarea>
	                    </div>
	                    <input type="hidden" name="hire_to" value="<?php echo $user_profile['id']; ?>">
	                    <input name="post_id" id="private_post_id-footer" type="hidden" value="0">
        							<input name="type" id="type" type="hidden" value="<?=$this->session->userdata('type'); ?>">
        							<input type="hidden"  name="check" id="private_check" autofocus>
        							<input name="rid" id="private_rid-footer" type="hidden" value="<?php echo $user_profile['id']; ?>">
	                    <!-- <div class="from-group">
	                       <label>Category</label>
	                       <div class="Hire_b">
	                          <select class="form-control" required name="main_cate">
	                             <option value="">Select Category</option>
	                             <?php
	                                //$main_categorys = $this->common_model->GetColumnName('category',array('is_delete'=>0,'cat_parent'=>0),array('cat_name','cat_id'),true);
	                                //foreach($main_categorys as $row){
	                                	//echo '<option value="'.$row['cat_id'].'">'.$row['cat_name'].'</option>';
	                                //}
	                                ?>
	                          </select>
	                       </div>
	                    </div> -->
	                    <!-- <div class="from-group Budget2">
	                       <div class="row">
	                          <div class="col-xs-7">
	                             <label>Budget</label>
	                             <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
	                                <input type="number" class="form-control" placeholder="" value="100" name="budget" required min="10">
	                             </div>
	                          </div>
	                          <div class="col-xs-5">
	                             <label>Delivery Days</label>
	                             <div class="input-group">
	                                <input type="number" class="form-control" placeholder="" value="1" required name="delivery_days" min="1">
	                             </div>
	                          </div>
	                       </div>
	                    </div> -->

	                    <div>
												<span>Last Seen: </span>
												<b><?php echo !empty($user_profile['is_active']) && $user_profile['is_active'] == 1 ? 'Online' : 'Offline'; ?></b>
											</div>

	                    <div class="from-group"  style="margin-top: 20px;">
	                       <?php if($user_id){ ?>
	                       <?php
	                          $check_last_request = $this->common_model->get_single_data('tbl_jobs',array('direct_hired'=>1,'userid'=>$user_id,'awarded_to'=>$user_profile['id'],'status'=>4));
	                          ?>
	                       <?php if($check_last_request){ ?>

	                       <!-- <a href="javascript:void(0);" onclick="swal('You had aleady sent a hiring request for the job Id: <?php echo $check_last_request['project_id']; ?>');" class="btn btn-primary btn-lg btn-block hire_me">Contact Me</a> -->

	                       <a href="javascript:void(0);" onclick="direct_send_msg()" class="btn btn-primary btn-lg btn-block hire_me">Contact Me</a>

	                       <?php } else { ?>

	                       <button type="submit" class="btn btn-primary btn-lg btn-block hire_me">Contact Me</button>

	                       <?php } ?>
	                       <?php } else { ?>

	                       <a href="<?php echo site_url().'login'; ?>" class="btn btn-primary btn-lg btn-block hire_me">Contact Me</a>

	                       <?php } ?>
	                    </div>
	                 </form>
	                 <!--<p>
	                    By clicking the button, you have read and agree to our <a href="<?php //echo site_url().'terms-and-conditions'; ?>">Terms & Conditions</a> and <a href="<?php //echo site_url().'privacy-policy'; ?>">Privacy Policy</a>
	                 </p>-->

	                <div>
										<span>Average Reponse Time: </span>

										<?php 
											if(round($responseTime['avg_response_time_hours']) > 0){
												$response = round($responseTime['avg_response_time_hours']).' hours';
											}else{
												$response = 'Not Responded'; 	
											}
										?>

										<b><?php echo $response;?></b>
									</div>

	              </div>
	           </div>
	           <?php } ?>
	           <div class="dashboard-white edit-pro89">
	              <div class=" dashboard-profile ">
	                 <h2>Verifications</h2>
	                 <ul class="lisss ul_set">
	                    <li class="active">
	                       <a href="javascript:void(0);">
	                       <i class="fa fa-phone left_iiicon"></i> 
	                       Phone Verified 
	                       <?php 
	                       		//if(!empty($user_profile['phone_no'])){ 
	                       		if($user_profile['is_phone_verified'] != 0){
	                       ?>
	                       <i class="fa fa-check right_iiicon"></i> 
	                       <?php } else{ ?>
	                       <i class="fa fa-close right_iiicon"></i> 
	                       <?php } ?>
	                       </a>
	                    </li>
	                    <li class="active">
	                       <a href="javascript:void(0);">
	                       <i class="fa fa-user-circle-o left_iiicon"></i> 
	                       Identity Verified
	                       <?php if($user_profile['u_id_card_status']==2){ ?>
	                       <i class="fa fa-check right_iiicon"></i> 
	                       <?php }else{ ?>
	                       <i class="fa fa-close right_iiicon"></i> 
	                       <?php } ?>
	                       </a>
	                    </li>
	                    <li class="active">
	                       <a href="javascript:void(0);">
	                       <i class="fa fa-envelope left_iiicon"></i> 
	                       Address Verified 
	                       <?php if($user_profile['u_status_add']==2){ ?>
	                       <i class="fa fa-check right_iiicon"></i> 
	                       <?php }else{ ?>
	                       <i class="fa fa-close right_iiicon"></i> 
	                       <?php } ?>
	                       </a>
	                    </li>
	                 </ul>
	              </div>
	           </div>
	           <div class="dashboard-white edit-pro89 hide">
	              <div class="row dashboard-profile">
	                 <div class="col-md-12">
	                    <div class="">
	                       <h2>Certifications</h2>
	                       <p>You do not have any certifications.</p>
	                    </div>
	                 </div>
	                 <div class="col-md-12">
	                    <div class="pull-right margintop10">
	                       <a class="btn btn-warning" href="">Get Certified</a>
	                    </div>
	                 </div>
	              </div>
	           </div>
	           <div class="modal fade popup" id="category-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	              <div class="modal-dialog" role="document">
	                 <div class="modal-content">
	                    <div class="modal-header">
	                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                       <h4 class="modal-title" id="myModalLabel">Skills</h4>
	                    </div>
	                    <form method="POST" id="skilledit" action="<?php echo base_url('users/update_catgory/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data" onsubmit="return update_category();">
	                       <div class="modal-body">
	                          <fieldset>
	                             <!-- Text input-->
	                             <div class="form-group">
	                                <label class="col-md-12 control-label" for="textinput">Select Skills</label>  
	                                <div class="col-md-12">
	                                   <select data-placeholder="Select Category" class="form-control input-md chosen-select" multiple style="width:350px;" tabindex="4" name="category[]">
	                                      <?php 
	                                         $selected_lang = ($user_profile['category'])?explode(',',$user_profile['category']):array();
	                                         
	                                         foreach($category as $row) { 
	                                         $selected = (in_array($row['cat_id'],$selected_lang))?'selected':'';
	                                         ?>
	                                      <option <?= $selected; ?> value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
	                                      <?php } ?>
	                                   </select>
	                                </div>
	                             </div>
	                          </fieldset>
	                       </div>
	                       <div class="modal-footer">
	                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                          <button type="submit" class="btn btn-warning submit_btn11">Update</button>
	                       </div>
	                    </form>
	                 </div>
	              </div>
	           </div>
	        </div>
        </div>
      </div>
      </div>
   </div>
</div>
<?php include 'include/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link href="css/tagmanager.css" rel="stylesheet">
<script src="js/tagmanager.js"></script>
<script type="text/javascript">
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		height:250,
		menubar: false,
		branding: false,
		statusbar: false,
		//toolbar: 'bold | alignleft alignjustify | numlist',
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}
   function check_file_size(e,id){
   	var size = e.files[0].size;
   	
   	var ext = e.value.split('.').pop().toLowerCase();
   	
   	if(ext=='jpeg' || ext=='png' || ext=='jpg' || ext=='gif'){
   		$('.port_btn'+id).prop('disabled',false);
   	} else {
   		$('.port_btn'+id).prop('disabled',true);
   		swal('This file type is not allowed, Allow types are jpeg, png, jpg, gif.');
   		return false;
   	}
   	
   	var max = 1024*20*1024;
   	if(max >= size){
   		$('.port_btn'+id).prop('disabled',false);
   	} else {
   		$('.port_btn'+id).prop('disabled',true);
   		swal('File too large. File must be less than 20 MB.');
   		return false;
   	}
   		
   	
   }
   function update_profile1(){
       $('.submit_btn7').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn7').prop('disabled',true);
   }
   function update_profile2()
   {
         $('.submit_btn13').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn13').prop('disabled',true);
   }
   function update_category()
   {
        $('.submit_btn11').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn11').prop('disabled',true);
   }
   function update_skills1(){
       $('.submit_btn10').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn10').prop('disabled',true);
   }
   function update_profile(){
       $('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn').prop('disabled',true);
   }
   function add_portfolio(){
       $('.submit_btn1').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn1').prop('disabled',true);
   }
   function edit_portfolio(){
       $('.submit_btn5').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn5').prop('disabled',true);
   }
   function edit_certificate(){
       $('.submit_btn6').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn6').prop('disabled',true);
   }
   
   
   function add_education(){
       $('.submit_btn2').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn2').prop('disabled',true);
   }
   function edit_education()
   {
        $('.submit_btn3').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn3').prop('disabled',true);
   }
   function add_certification()
   {
        $('.submit_btn4').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn4').prop('disabled',true);
   }
   
   $("#u_profile").change(function () {
       filePreview(this);
   });
   $("#port_image").change(function () {
       filePreview1(this);
   });
   function filePreview(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.perview_pro_img').html('');
               $('.perview_pro_img').html('<img src="'+e.target.result+'" width="100" height="80"/>');
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   function filePreview1(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.perview_pro_img1').html('');
               $('.perview_pro_img1').html('<img src="'+e.target.result+'" width="100" height="80"/>');
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   
   (function($) {
       $.fn.chosenImage = function(options) {
           return this.each(function() {
   
               var $select = $(this),
               imgMap  = {};
   
               $select.find('option').filter(function(){
                   return $(this).text();
               }).each(function(i) {
                   var imgSrc   = $(this).attr('data-img-src');
                   imgMap[i]    = imgSrc;
               });
   
               $select.chosen(options);
   
               var chzn_id = $select.attr('id');
               chzn_id += "_chzn";
               console.log('before class addition');
               var  chzn      = '#' + chzn_id,            
               $chzn = $(chzn).addClass('chznImage-container');
       
               $chzn.find('.chzn-results li').each(function(i) {
                   $(this).css(cssObj(imgMap[i]));
               });
   
               $select.change(function() {
                   var imgSrc = ($select.find('option:selected').attr('data-img-src')) ? $select.find('option:selected').attr('data-img-src') : '';
                   $chzn.find('.chzn-single span').css(cssObj(imgSrc));
               });
   
               $select.trigger('change');
   
               function cssObj(imgSrc) {
                   if(imgSrc) {
                       return {
                           'background-image': 'url(' + imgSrc + ')',
                           'background-repeat': 'no-repeat'
                   }
                   } else {
                       return {
                           'background-image': 'none'
                       }
                   }
               }
           });
       }
   })(jQuery);
   
   
</script>
<script>
   $(document).ready(function(e) {
     $(".user-pic-click").click(function(e) {
     $(".right-side-user").addClass("right-side-user-0");
   });
     $(".close-right-menu").click(function(e) {
     $(".right-side-user").removeClass("right-side-user-0");
   });
     $(".acount-page .container").click(function(e) {
     $(".right-side-user").removeClass("right-side-user-0");
   });
     $(".portfolio-show").click(function(e) {
     $(".show-project-fill").addClass("show-portfolio");   
   }); 
     $(".hide-port-sect").click(function(e) {  
     $(".show-project-fill").removeClass("show-portfolio");
   });
   
   });
   
</script>
<script>
   jQuery(".tm-input.tm-input-01").tagsManager({
     prefilled: ["Real State", "Graphic Design"],
     blinkBGColor_1: '#FE7508',
     blinkBGColor_2: '#CDE69C'//,
   });
   
</script>
<script type="text/javascript">
   $(function() {
   $('#form-tags-1').tagsInput();
   
   $('#form-tags-2').tagsInput({
     'onAddTag': function(input, value) {
       console.log('tag added', input, value);
     },
     'onRemoveTag': function(input, value) {
       console.log('tag removed', input, value);
     },
     'onChange': function(input, value) {
       console.log('change triggered', input, value);
     }
   });
   
   $('#form-tags-3').tagsInput({
     'unique': true,
     'minChars': 2,
     'maxChars': 10,
     'limit': 5,
     'validationPattern': new RegExp('^[a-zA-Z]+$')
   });
   
   $('#form-tags-4').tagsInput({
     'autocomplete': {
       source: [
         'apple',
         'banana',
         'orange',
         'pizza'
       ]
     }
   });
   
   $('#form-tags-5').tagsInput({
     'delimiter': ';'
   });
   
   $('#form-tags-6').tagsInput({
     'delimiter': [',', ';']
   });
   });
   
   
   
   /* jQuery Tags Input Revisited Plugin
   *
   * Copyright (c) Krzysztof Rusnarczyk
   * Licensed under the MIT license */
   
   (function($) {
   var delimiter = [];
   var inputSettings = [];
   var callbacks = [];
   
   $.fn.addTag = function(value, options) {
     options = jQuery.extend({
       focus: false,
       callback: true
     }, options);
     
     this.each(function() {
       var id = $(this).attr('id');
   
       var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
       if (tagslist[0] === '') tagslist = [];
   
       value = jQuery.trim(value);
       
       if ((inputSettings[id].unique && $(this).tagExist(value)) || !_validateTag(value, inputSettings[id], tagslist, delimiter[id])) {
         $('#' + id + '_tag').addClass('error');
         return false;
       }
       
       $('<span>', {class: 'tag'}).append(
         $('<span>', {class: 'tag-text'}).text(value),
         $('<button>', {class: 'tag-remove'}).click(function() {
           return $('#' + id).removeTag(encodeURI(value));
         })
       ).insertBefore('#' + id + '_addTag');
   
       tagslist.push(value);
   
       $('#' + id + '_tag').val('');
       if (options.focus) {
         $('#' + id + '_tag').focus();
       } else {
         $('#' + id + '_tag').blur();
       }
   
       $.fn.tagsInput.updateTagsField(this, tagslist);
   
       if (options.callback && callbacks[id] && callbacks[id]['onAddTag']) {
         var f = callbacks[id]['onAddTag'];
         f.call(this, this, value);
       }
       
       if (callbacks[id] && callbacks[id]['onChange']) {
         var i = tagslist.length;
         var f = callbacks[id]['onChange'];
         f.call(this, this, value);
       }
     });
   
     return false;
   };
   
   $.fn.removeTag = function(value) {
     value = decodeURI(value);
     
     this.each(function() {
       var id = $(this).attr('id');
   
       var old = $(this).val().split(_getDelimiter(delimiter[id]));
   
       $('#' + id + '_tagsinput .tag').remove();
       
       var str = '';
       for (i = 0; i < old.length; ++i) {
         if (old[i] != value) {
           str = str + _getDelimiter(delimiter[id]) + old[i];
         }
       }
   
       $.fn.tagsInput.importTags(this, str);
   
       if (callbacks[id] && callbacks[id]['onRemoveTag']) {
         var f = callbacks[id]['onRemoveTag'];
         f.call(this, this, value);
       }
     });
   
     return false;
   };
   
   $.fn.tagExist = function(val) {
     var id = $(this).attr('id');
     var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
     return (jQuery.inArray(val, tagslist) >= 0);
   };
   
   $.fn.importTags = function(str) {
     var id = $(this).attr('id');
     $('#' + id + '_tagsinput .tag').remove();
     $.fn.tagsInput.importTags(this, str);
   };
   
   $.fn.tagsInput = function(options) {
     var settings = jQuery.extend({
       interactive: true,
       placeholder: 'Add a tag',
       minChars: 0,
       maxChars: null,
       limit: null,
       validationPattern: null,
       width: 'auto',
       height: 'auto',
       autocomplete: null,
       hide: true,
       delimiter: ',',
       unique: true,
       removeWithBackspace: true
     }, options);
   
     var uniqueIdCounter = 0;
   
     this.each(function() {
       if (typeof $(this).data('tagsinput-init') !== 'undefined') return;
   
       $(this).data('tagsinput-init', true);
   
       if (settings.hide) $(this).hide();
       
       var id = $(this).attr('id');
       if (!id || _getDelimiter(delimiter[$(this).attr('id')])) {
         id = $(this).attr('id', 'tags' + new Date().getTime() + (++uniqueIdCounter)).attr('id');
       }
   
       var data = jQuery.extend({
         pid: id,
         real_input: '#' + id,
         holder: '#' + id + '_tagsinput',
         input_wrapper: '#' + id + '_addTag',
         fake_input: '#' + id + '_tag'
       }, settings);
   
       delimiter[id] = data.delimiter;
       inputSettings[id] = {
         minChars: settings.minChars,
         maxChars: settings.maxChars,
         limit: settings.limit,
         validationPattern: settings.validationPattern,
         unique: settings.unique
       };
   
       if (settings.onAddTag || settings.onRemoveTag || settings.onChange) {
         callbacks[id] = [];
         callbacks[id]['onAddTag'] = settings.onAddTag;
         callbacks[id]['onRemoveTag'] = settings.onRemoveTag;
         callbacks[id]['onChange'] = settings.onChange;
       }
   
       var markup = $('<div>', {id: id + '_tagsinput', class: 'tagsinput'}).append(
         $('<div>', {id: id + '_addTag'}).append(
           settings.interactive ? $('<input>', {id: id + '_tag', class: 'tag-input', value: '', placeholder: settings.placeholder}) : null
         )
       );
   
       $(markup).insertAfter(this);
   
       $(data.holder).css('width', settings.width);
       $(data.holder).css('min-height', settings.height);
       $(data.holder).css('height', settings.height);
   
       if ($(data.real_input).val() !== '') {
         $.fn.tagsInput.importTags($(data.real_input), $(data.real_input).val());
       }
       
       // Stop here if interactive option is not chosen
       if (!settings.interactive) return;
       
       $(data.fake_input).val('');
       $(data.fake_input).data('pasted', false);
       
       $(data.fake_input).on('focus', data, function(event) {
         $(data.holder).addClass('focus');
         
         if ($(this).val() === '') {
           $(this).removeClass('error');
         }
       });
       
       $(data.fake_input).on('blur', data, function(event) {
         $(data.holder).removeClass('focus');
       });
   
       if (settings.autocomplete !== null && jQuery.ui.autocomplete !== undefined) {
         $(data.fake_input).autocomplete(settings.autocomplete);
         $(data.fake_input).on('autocompleteselect', data, function(event, ui) {
           $(event.data.real_input).addTag(ui.item.value, {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         });
         
         $(data.fake_input).on('keypress', data, function(event) {
           if (_checkDelimiter(event)) {
             $(this).autocomplete("close");
           }
         });
       } else {
         $(data.fake_input).on('blur', data, function(event) {
           $(event.data.real_input).addTag($(event.data.fake_input).val(), {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         });
       }
       
       // If a user types a delimiter create a new tag
       $(data.fake_input).on('keypress', data, function(event) {
         if (_checkDelimiter(event)) {
           event.preventDefault();
           
           $(event.data.real_input).addTag($(event.data.fake_input).val(), {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         }
       });
       
       $(data.fake_input).on('paste', function () {
         $(this).data('pasted', true);
       });
       
       // If a user pastes the text check if it shouldn't be splitted into tags
       $(data.fake_input).on('input', data, function(event) {
         if (!$(this).data('pasted')) return;
         
         $(this).data('pasted', false);
         
         var value = $(event.data.fake_input).val();
         
         value = value.replace(/\n/g, '');
         value = value.replace(/\s/g, '');
         
         var tags = _splitIntoTags(event.data.delimiter, value);
         
         if (tags.length > 1) {
           for (var i = 0; i < tags.length; ++i) {
             $(event.data.real_input).addTag(tags[i], {
               focus: true,
               unique: settings.unique
             });
           }
           
           return false;
         }
       });
       
       // Deletes last tag on backspace
       data.removeWithBackspace && $(data.fake_input).on('keydown', function(event) {
         if (event.keyCode == 8 && $(this).val() === '') {
            event.preventDefault();
            var lastTag = $(this).closest('.tagsinput').find('.tag:last > span').text();
            var id = $(this).attr('id').replace(/_tag$/, '');
            $('#' + id).removeTag(encodeURI(lastTag));
            $(this).trigger('focus');
         }
       });
   
       // Removes the error class when user changes the value of the fake input
       $(data.fake_input).keydown(function(event) {
         // enter, alt, shift, esc, ctrl and arrows keys are ignored
         if (jQuery.inArray(event.keyCode, [13, 37, 38, 39, 40, 27, 16, 17, 18, 225]) === -1) {
           $(this).removeClass('error');
         }
       });
     });
   
     return this;
   };
   
   $.fn.tagsInput.updateTagsField = function(obj, tagslist) {
     var id = $(obj).attr('id');
     $(obj).val(tagslist.join(_getDelimiter(delimiter[id])));
   };
   
   $.fn.tagsInput.importTags = function(obj, val) {
     $(obj).val('');
     
     var id = $(obj).attr('id');
     var tags = _splitIntoTags(delimiter[id], val); 
     
     for (i = 0; i < tags.length; ++i) {
       $(obj).addTag(tags[i], {
         focus: false,
         callback: false
       });
     }
     
     if (callbacks[id] && callbacks[id]['onChange']) {
       var f = callbacks[id]['onChange'];
       f.call(obj, obj, tags);
     }
   };
   
   var _getDelimiter = function(delimiter) {
     if (typeof delimiter === 'undefined') {
       return delimiter;
     } else if (typeof delimiter === 'string') {
       return delimiter;
     } else {
       return delimiter[0];
     }
   };
   
   var _validateTag = function(value, inputSettings, tagslist, delimiter) {
     var result = true;
     
     if (value === '') result = false;
     if (value.length < inputSettings.minChars) result = false;
     if (inputSettings.maxChars !== null && value.length > inputSettings.maxChars) result = false;
     if (inputSettings.limit !== null && tagslist.length >= inputSettings.limit) result = false;
     if (inputSettings.validationPattern !== null && !inputSettings.validationPattern.test(value)) result = false;
     
     if (typeof delimiter === 'string') {
       if (value.indexOf(delimiter) > -1) result = false;
     } else {
       $.each(delimiter, function(index, _delimiter) {
         if (value.indexOf(_delimiter) > -1) result = false;
         return false;
       });
     }
     
     return result;
   };
   
   var _checkDelimiter = function(event) {
     var found = false;
     
     if (event.which === 13) {
       return true;
     }
   
     if (typeof event.data.delimiter === 'string') {
       if (event.which === event.data.delimiter.charCodeAt(0)) {
         found = true;
       }
     } else {
       $.each(event.data.delimiter, function(index, delimiter) {
         if (event.which === delimiter.charCodeAt(0)) {
           found = true;
         }
       });
     }
     
     return found;
    };
    
    var _splitIntoTags = function(delimiter, value) {
      if (value === '') return [];
      
      if (typeof delimiter === 'string') {
        return value.split(delimiter);
      } else {
        var tmpDelimiter = '∞';
        var text = value;
        
        $.each(delimiter, function(index, _delimiter) {
          text = text.split(_delimiter).join(tmpDelimiter);
        });
        
        return text.split(tmpDelimiter);
      }
      
      return [];
    };
   })(jQuery);
   
   $('.chosen-select').chosen({}).change( function(obj, result) {
     console.debug("changed: %o", arguments);
     
     console.log("selected: " + result.selected);
   });
</script>
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
   function direct_hiring(){
     $.ajax({
       type:'POST',
       url:site_url+'direct_hire/direct_hire',
       data:$('#direct_hire').serialize(),
       dataType:'JSON',
       beforeSend:function(){
         $('#msg').html('');
   			$('.hire_me').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
   			$('.hire_me').prop('disabled',true);
       },
       success:function(resp){
         if(resp.status==1){
           window.location.href=site_url+"my-account";
         } else {
					 $('.hire_me').html('Contact me');
					$('.hire_me').prop('disabled',false);
           $('#msg').html(resp.msg);
         }
       }
     });
     return false;
   }

   function direct_send_msg(){
    var post = 0;
    var id = <?php echo $user_profile['id']; ?>;
    $('#rid-footer').val(id);

    $.ajax({
      type:'POST',
      url:site_url+'chat/send_msg',
      data:$('#direct_hire').serialize(),
      dataType:'JSON',
      success:function(resp)
      {
        if(resp.status==1)
        {
          //$('#direct_msg').val('');

          $.ajax({
		        type:'POST',
		        url:site_url+'chat/get_chats',
		        data:{id:id,post:0},
		        dataType:'JSON',
		        success:function(resp) {
		          if(resp.status==1) {
		            $('#rid-footer').val(id);
		            $('#userdetail').html(resp.userdetail);
		            var oldscrollHeight = $("#usermsg").prop("scrollHeight");         
		            $('.user_chat').html(resp.data);  
		            var newscrollHeight = $("#usermsg").prop("scrollHeight");
		            if (newscrollHeight > oldscrollHeight) {
		              $("#usermsg").animate({
		                scrollTop: newscrollHeight
		              }, 'normal');
		            }
		          } else {
		            $('#userdetail').html(resp.userdetail);
		            $('.user_chat').html(resp.data); 
		          }
		        }
		      });
        }
        showdiv()
      }
    });
    return false;
  }

  function show_hide_more(){
    $(".hide-skill").slideToggle();
    if ($("#show-more-btn").text() == "hide") {
      $("#show-more-btn").text('View all');
    }else {
      $("#show-more-btn").text('hide');
    }
  }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css">

<script>
$('p').each(function() {
    var $this = $(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
        $this.remove();
});
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var userid = '<?php echo $this->uri->segment(2); ?>';
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

function openProfileTab(tabName) {
    var i;
    var x = document.getElementsByClassName("sTab");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    document.getElementById(tabName).style.display = "block"; 

    var liTab = document.querySelectorAll('.w3-bar li');
    liTab.forEach(function(liLink) {
      liLink.classList.remove('active');
    });
    
    var activeTab = document.querySelector('a[onclick="openProfileTab(\'' + tabName + '\')"]').parentElement;
    activeTab.classList.add('active');
  }
</script>