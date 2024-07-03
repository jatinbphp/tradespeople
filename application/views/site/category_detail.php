<?php include ("include/header.php") ?>
<style type="text/css">
	
</style>
<div class="detail-cat acount-page membership-page">
	<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
		<div class="top-cat">
			<div class="row">
				<div class="col-sm-3">	
					<div class="categy-img">
						<img src="<?php echo site_url('img/category/'.$category_details['cat_image']); ?>" class="img-responsive">
					</div>
				</div>
				<div class="col-sm-9">
					<h1><?php echo $category_details['cat_name']; ?></h1>				
					<p><?php echo $category_details['cat_description']; ?></p>
				</div>
			</div>
		</div>
		
		<div class="cat-user">
		<div class="cat-he-user">
			<h1>User List</h1>
		</div>
			<div class="row">
			<div class="col-sm-12">
				<?php $cat_id=$this->uri->segment(2); $get_users_cat=$this->common_model->get_user_category('users',$cat_id); 
				?>
				<?php if($get_users_cat){ foreach ($get_users_cat as $get) {
					?>
								<div class="tradesmen-box">
					<div class="tradesmen-top">
						<div class="pull-left">	
							<div class="img-name">
								 <?php if($get['profile']){ ?>                                 
                                                   		<img src="<?php echo site_url('img/profile/'.$get['profile']); ?>">
                                                    <?php } else { ?>
                                                    <img src="<?= site_url(); ?>img/profile/dummy_profile.jpg">
                                                    <?php } ?>  
						
								<div class="names">
								<a href="<?php echo base_url('profile/'.$get['id']); ?>"><h4> <?php echo $get['f_name'].' '.$get['l_name']; ?> </h4></a>
								<h5> 0 Feedback reviews </h5>
								</div>
							</div>
						</div>
						<div class="pull-right">
							<h3>£0 <span>EUR/hour</span></h3>
							<div class="from-group text-right">
								<a href="<?php echo base_url('profile/'.$get['id']); ?>" class="btn btn-warning">Hire Me</a>
							</div>
						</div>
					</div>	
					<div class="tradesmen-bottom">						
						<div class="tradesmen-member">
							<div class="pull-left">
								<span class="from-group">
								<span class="btn btn-warning btn-xs">0
								</span>
								<span class="star_r">
							<i class="fa fa-star active"></i>
							<i class="fa fa-star active"></i>
							<i class="fa fa-star active"></i>
							<i class="fa fa-star active"></i>
							<i class="fa fa-star"></i>
						</span>(0 reviews)
								</span>
							</div>
						
							<div class="pull-right">
								<span class="from-group">
									<i class="fa fa-map-marker"></i> <?php  $data_set=$this->common_model->newgetRows('tbl_city',array('id'=>$get['city'])); echo $data_set[0]['city_name'];?> , <?php $data_set1=$this->common_model->newgetRows('tbl_region',array('id'=>$get['county'])); echo $data_set1[0]['region_name']; ?>
								</span>
							 
							</div>
				
							<p class="nnntab">
								<i class="fa fa-tag"></i> <?php
                        
                        $selected_lang = explode(',',$get['category']);
                	$cat_data='';
                                                foreach($all_category as $row) { 
                                                    if(in_array($row['cat_id'],$selected_lang))
                                                    {
                                                     

                                                     $cat_data .= '<a href="'.site_url('find-tradesmen/'.$row['cat_id']).'">'.$row['cat_name'].'</a>, ';
                                                    }
                                                }
                                                echo rtrim($cat_data,', ');
                                                ?>
							</p>
						</div>
						<div class="tradesmen-desc">
						<p><?php echo $get['profile_summary']; ?></p>
						</div>	
				
				
					</div>
				</div>
					<?php 
				} } else{ ?>
					 <p class="alert alert-danger">No users found for this category.</p>
				<?php } ?>
	

	
				
				
			</div>
		
		</div>
		</div>
	</div>
	</div>
	</div>
</div>
<?php include ("include/footer.php") ?>