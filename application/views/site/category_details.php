<?php 

include ("include/header.php");

$get_home=$this->common_model->get_all_data('home_content',''); 
if($local_category_data && $local_category_data['image']){

	//$default_image_class = 'banner-unique-class';
	$default_svg_opcity = '0.8';
	//$default_svg_fill = '#f9f9f9';
	
	$default_image_class = 'banner-unique-default';
	$default_svg_fill = '#FFFFFF';
	
	$cat_img = base_url().'img/category/'.$local_category_data['image'];

} else if($category_details['cat_image']){
	//$default_image_class = 'banner-unique-class';
	$default_svg_opcity = '0.8';
	//$default_svg_fill = '#f9f9f9';
	
	$default_image_class = 'banner-unique-default';
	$default_svg_fill = '#FFFFFF';
	
	$cat_img = base_url().'img/category/'.$category_details['cat_image'];
} else {
	$default_image_class = 'banner-unique-default';
	$default_svg_opcity = '0.8';
	$default_svg_fill = '#FFFFFF';
	$cat_img = base_url().'img/find-tradesmen-new.png';
}
	

$url_segement2 = $this->uri->segment(1);

if($url_segement2){
	$post_url = site_url().'find-tradesmen/'.$url_segement2;

} else {
	$post_url = site_url().'find-tradesmen';
}
$get_all_categories=$this->common_model->GetColumnName('category',array('show_at_job_search'=>1,'is_delete'=>0,'cat_parent'=>0),null,true,'cat_id','asc');
?>


<script src="<?php echo site_url(); ?>js/rating.js"></script>
<link rel="stylesheet" href="<?php echo site_url(); ?>css/rating.css"/>
<style>
.clear-rating.clear-rating-active {
    display: none !important;
}
.caption {
    display: none !important;
}
.set-slide.banner-unique-class{
    background-position: right !important;
    background-size: 54% 100% !important;
}
.textEditorClass {
    padding: 15px;
    background: #f1f1f1;
}
.textEditorClass1 {
    padding: 15px;
}
.fat-side-item ul ul {
    height: 100%;
    margin-left: 30px;
}
.fat-side-item ul ul a
{
    font-size:15px
}
.Locations_list11 i.fa {
    color: #4f78cb;
    position: absolute;
    top: 5px;
    font-size: 18px;
    cursor: pointer;
}
.Locations_list11 .lislocc1 li a:after {
    content: " ";
}
.Locations_list11 ul li ul {
	display: none;
}
.Locations_list11 ul li ul.active {
	display: block;
}
.Locations_list11 .lislocc1 > li > a {
    position: relative;
    margin-left: 23px;
    padding: 0;
    width: 100%;
    display: inline-block;
}
/*.set-slide.banner-unique-class svg {
	width: 53%;
}*/

.fat-side-item2 ul {
  
    max-height: 300px !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
</style>
<!-- Custom banner -->
<div class="home-page catdtilslider">
	<div class="home-demo first-home" >
		<div class="">
			<div class="set-slide <?php echo $default_image_class; ?>" style="background-image: url(<?php echo $cat_img; ?>); background-position: right !important;">
				<svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon opacity="<?php echo $default_svg_opcity; ?>" fill="<?php echo $default_svg_fill; ?>" points="0 0 740 0 700 650 0 650"></polygon></svg>
				
				<div class="container">
					<div class="row set-m-10">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="slice-text slice-text_home">
										<?php 
										if($category_details){ 
										  if($category_details['cat_parent'] == 0){ ?>
											
											<p class="nomargin headHead1">Find local <?php  echo $category_details['cat_name']; ?> </p>
											
											<p style="margin-top: 17px;"> <?php  echo $category_details['cat_description']; ?></p>
											
											<?php } else { ?>
											
												<p class="nomargin headHead1">Find local <?php  echo $category_details['title_ft']; ?> </p>
												
												<p style="margin-top: 17px;"> <?php  echo $category_details['cat_description']; ?></p>
												
											<?php } ?>
											
										<?php } else if($local_category_data) { ?>
										
										<p class="nomargin headHead1"><?php  echo $local_category_data['title']; ?></p>
										
										<p style="margin-top: 17px;"> <?php  echo $local_category_data['description']; ?></p>
										
										<?php } else if($city_data) { ?>
										
										<p class="nomargin headHead1"><?php  echo $city_data['meta_title']; ?></p>
										
										<p style="margin-top: 17px;"> <?php  echo $city_data['meta_description']; ?></p>
										
										<?php } else { 
										
										$find_trae_content=$this->common_model->GetColumnName('other_content',array('id'=>1));
										
										?>  
										
										<p class="nomargin headHead1"><?php echo $find_trae_content['title']; ?> <?php //echo ($city_name) ? ucfirst($city_name) : 'near you'; ?></p>
										
										<p style="margin-top: 17px;"><?php echo $find_trae_content['description']; ?></p>
										
										<?php } ?>
				
		
										<div class="banner-btn">
											<a href="<?php echo base_url('post-job'); ?>" class="btn btn-warning btn-lg"><b>Post a job now</b></a>
										</div>
									</div>
								</div>
                <div class="col-sm-6">
                </div>
							</div>
						</div>
					</div>
				</div>
				<?php //print_r($category_details); ?>
				<!-- set-bg-img class add in next div -->
			</div>
		</div>
	</div>
</div>
<!-- Custom banner -->
<div class="list-tradesmen nwess1">
	<div class="container">
		<div class="row">
			
			<div class="col-sm-8 fflooot2">
				<div class="row">
					<div class="col-sm-12">
						<div class="top-search">
							<div class="input-group">
								<input type="text" placeholder="Search" onchange="searchFilter();" class="form-control" name="search" id="search">
								<input type="hidden" id="cate_id" value="<?php echo ($category_details)?$category_details['cat_id']:'';?>">

								<span class="input-group-btn">
									<button type="button" onclick="searchFilter();" class="button btn btn-default"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
						<div id="search_data">
						<?php 
						if($get_users_cat){ foreach ($get_users_cat as $get) {
						?>
						<div class="tradesmen-box">
							<div class="tradesmen-top">
								<div class="pull-left">	
									<div class="img-name">
										
										<a href="<?php echo base_url('profile/'.$get['id']); ?>">
											<?php if($get['profile']){ ?> 
											
											<img src="<?php echo site_url('img/profile/'.$get['profile']); ?>">
											
											<?php } else { ?>
											<img src="<?= site_url();?>img/profile/dummy_profile.jpg">
											
											<?php } ?> 
										</a>
										
										<div class="names">
											<a href="<?php echo base_url('profile/'.$get['id']); ?>"><h4> <?php echo $get['trading_name']; ?> </h4></a>
										
											<?php /*if($get['company']){ ?>
											<h5> Company: <?php echo $get['company']; ?> </h5>
											<?php }*/ ?>
											<span class="btn btn-warning btn-xs"><?php echo $get['average_rate']; ?> </span>

											<span class="star_r">
												<?php for($i=1;$i<=5;$i++){
												
													if($i<=$get['average_rate']) { ?>  
													
													<i class="fa fa-star active"></i>
													
													<?php }  else{ ?>
												
													<i class="fa fa-star"></i>
												
													<?php } ?>

												<?php } ?>
											</span>(<?php echo $get['total_reviews']; ?> reviews) 
									
										</div>
									</div>
								</div>
								<div class="pull-right">
									<?php /* if($get['hourly_rate']){ ?>
									<h3>£<?php echo $get['hourly_rate']; ?> <span style="margin-top: 10px;font-size: 15px">GBP/hour</span></h3>
									<?php } */ ?>
									<div class="from-group text-right hire-tn" style="margin: 18px 0;">
										<a href="<?php echo base_url('profile/'.$get['id']); ?>" class="btn btn-primary" ><img src="<?= site_url(); ?>img/hire-up.png"> Hire Me</a>
									</div>
								</div>
							</div>	
							<div class="tradesmen-bottom">						
								<div class="tradesmen-member">
									<div class="pull-left">
										<div class="from-group revie">
											Tradesperson in
										
										</div>
										
									</div>
									<div class="pull-right">
										<span class="from-group">
											<i class="fa fa-map-marker"></i>
											<?=$get['city'];?>
										
										</span>
									 
									</div>
							
								</div>
								<?php if($get['about_business']){ ?>
								<div class="tradesmen-desc">
									<p>
									<?php if(strlen($get['about_business']) > 150){ ?>
									<?php echo substr(strip_tags($get['about_business']),0,150); ?> <a href="<?php echo base_url('profile/'.$get['id']); ?>">Read More</a>
									<?php } else { ?>
									<?php echo $get['about_business']; ?>
									<?php }  ?>
									</p>
								</div>
								<?php } ?>
							
							</div>

							<?php
							$sql = "SELECT * FROM rating_table WHERE rt_rateTo = " .$get['id'] . " ORDER BY tr_id DESC LIMIT 1";
							$query = $this->db->query($sql);
							$rating = $query->result_array();

							if(count($rating)>0){
								$rating = $rating[0];
								$sql = "SELECT CONCAT(`f_name`, ' ', `l_name`) as `username` FROM `users` WHERE `id` = " .$rating['rt_rateBy'];
								$query = $this->db->query($sql);
								$user = $query->result_array();
								$user = $user[0];
								$sql = "SELECT title,direct_hired FROM tbl_jobs WHERE job_id = " .$rating['rt_jobid'];
								$query = $this->db->query($sql);
								$jobTitle = $query->result_array();
								$jobTitle = $jobTitle[0];
							?>
							<div class="tradesman-feedback">
								<div class="set-gray-box">
									
									<?php if($jobTitle['direct_hired']==1){ ?>
									<h4>Work for <?= $get['trading_name'];?></h4>	
									<?php } else if($jobTitle['title']){ ?>
									<h4><?= $jobTitle['title'];?></h4>
									<?php } else { ?>
									<h4>Work for <?= $get['trading_name'];?></h4>
									<?php } ?>
									<p class="recent-feedback">
										<em>Latest Review:</em>
									</p>
									<div cite="/job/view/5059288" class="summary">
										<p><?=$rating['rt_comment'];?></p>
									</div>
									<p class="tradesman-feedback__meta">By <strong class="job-author"><?=$user['username'];?></strong>&nbsp;on
										<!--
										<em class="job-date">13<sup>th</sup> Jul, 2019</em>
										-->
										<em class="job-date"><?=date("d M Y", strtotime($rating['rt_create']));?></em>
									</p>
								</div>
							</div>
							<?php } ?>
							
						</div>
							<?php 
						}  }else{ ?>
						<p class="alert alert-danger">No data found.</p>
						<?php } ?>
						<?= $this->ajax_pagination->create_links(); ?>
						</div>
						
						<?php $footerText = ''; ?>

						<?php if($category_details){
							if(strlen(strip_tags($category_details['footer_description']))>0){
								$footerText = $category_details['footer_description'];
							}
						} else if($local_category_data) {
							if(strlen(strip_tags($local_category_data['footer_description']))>0) {
								$footerText = $local_category_data['footer_description'];
							}
						 } else if($city_data) {
							if(strlen(strip_tags($city_data['jobpage_footer_description']))>0) {
								$footerText = $city_data['jobpage_footer_description'];
							}
						} else { 
						
						$find_trae_content=$this->common_model->GetColumnName('other_content',array('id'=>1));
						if($find_trae_content && strlen(strip_tags($find_trae_content['footer_description']))>0){

							$footerText = $find_trae_content['footer_description'];
							
						} } ?>
							
						<?php if($footerText) {
						
						$footerTextLen = strlen($footerText);
						$is_long_text = false;
						if($footerTextLen > 700){
							$is_long_text = true;
						}
						?>
						
						<div class="FooterTextFull" style="<?php echo ($is_long_text) ? 'display:none;' : '' ?>">
							<div style="padding:15px;" class="tradesmen-box">
								<div class="textEditorClass1">
								<?php echo $footerText; ?>
								</div> <br>
								<div class="text-center">
									<a style="display:none" class="btn text-center btn-default read-more-footer-btn2" href="javascript:void(0);" onclick="$('.FooterTextShort').show(); $('.FooterTextFull').hide();">Hide</a>
								</div>
								
							</div>
						</div>
						<div class="FooterTextShort" style="<?php echo ($is_long_text) ? '' : 'display:none;' ?>">
							<div style="padding:15px;" class="tradesmen-box">
								<div class="textEditorClass">
									<?php echo html_cut($footerText,700); ?>
								</div> <br>
								<div class="text-center">
									<a class="btn text-center btn-default read-more-footer-btn" href="javascript:void(0);" onclick="$('.FooterTextShort').hide(); $('.FooterTextFull').show(); $('.read-more-footer-btn2').show();">Read more</a>
								</div>
							</div>
						</div>

						
						<?php } ?>


					</div>
				</div>
		</div>
		<div class="col-sm-4 fflooot">
				<div class="fat-side-item fiilter">
					<h4>Narrow down your search</h4>
							
					<!-- <div class="from-group hide">
						<label>Location</label>
					
						<div class="input-group">
							<input placeholder="Location" class="form-control" type="text" name="location" id="location" onchange="searchFilter();">
							<span class="input-group-btn">
								<button type="submit" onclick="searchFilter();" class="button btn btn-default"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</div> -->
				
				
					<div class="from-group">
						<label>Category</label>
								
						<select class="form-control" name="category_id"  id="category_id" onchange="searchFilter();">
							<option value="">Select Category</option>
							<?php	foreach ($get_all_categories as $c) {
								$selected = (isset($searchCategoryId) && $searchCategoryId==$c['cat_id']) ? 'selected' : '';
							?>
							<option <?php echo $selected; ?> value="<?php echo $c['cat_id']; ?>"><?php echo $c['cat_name']; ?></option>
						<?php } ?>

							
						</select>
					</div>
					<div class="from-group ">
						<label>Location</label>
						<input id="location" name="location" placeholder="Location" class="form-control" onchange="searchFilter();"  value="<?php echo $searchCityName ?>" />
					</div>
					<div class="from-group border-top$">
						<label>Rating</label>
						<div class="set-review">
							<input id="input-1" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="1" onchange="searchFilter();">
						</div>
					</div>
					<div class="from-group nomargin" style="display: inline-block;width: 100%;">
						<button type="button" onclick="clearFilter();" class="btn btn-primary pull-left">Clear Filter</button>
						<!-- <a href="<?php echo $post_url; ?>" class="btn btn-primary pull-left" >Clear Filter</a> -->
						<!-- <button type="button" onclick="searchFilter();" class="btn btn-primary pull-right">Apply Filter</button> -->
								
					</div>
				</div>
			
				<div class="Locations_list11 fat-side-item open_omon1">
					<h4>How it works</h4>
					<h5 class="h4_size">
						1) Post a job
					</h5>
					<p>It's easy. Simply post your job and we'll notify our local tradespeople near you to provide you with quotes. </p>
					<h5 class="h4_size">
						2) Get quotes.
					</h5>
					<p>
						Compare the quotes. Read profiles, ratings & browse previous work history. Chat in real-time. Choose and award the job to the perfect tradesperson.
					</p>
					<h5 class="h4_size">
						3) Pay securely. 
					</h5>
					<p>
						Create a milestone payment. Pay only when you’re satisfied with the completed task and rate your tradesperson.</p>
				</div>
				<div class="Locations_list11 fat-side-item">
					<h4>Top Categories</h4>
					<ul class="ul_set lislocc1 ">

						<?php 
						$catttt_id=0;
						
						if($category_details){
							$catttt_id = $category_details['cat_id'];
						}
						//$get_all_categories=$this->common_model->get_all_categories('category',$_REQUEST['category_id']); 
						$get_all_categories=$this->common_model->get_main_categories('category',$catttt_id);
						//echo $this->db->last_query();
						foreach ($get_all_categories as $c) {
							$child =$this->common_model->GetColumnName('category',array('is_delete'=>0,'cat_parent'=>$c['cat_id']),null,true,'cat_id','asc');

              if($c['is_activate'] != 1) continue;
							?>
						<li><i class="fa fa-caret-right" onclick="expandSub('<?= $c['slug'] ?>')"></i><a href="<?=base_url($c['slug']); ?>"><?=$c['cat_name']; ?></a>
							<ul class="<?= $c['slug'] ?>">
								<?php foreach ($child as $cc) { ?>
									<?php if (strtolower(trim($cc['cat_name'])) == "others" || strtolower(trim($cc['cat_name'])) == "other") {
										continue;
									} ?>
									<li><a href="<?php echo base_url(''.$cc['slug']); ?>"><?php echo $cc['cat_name']; ?></a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>


					</ul>
				</div>
				<div class="Locations_list11 fat-side-item">
					<h4>Top Location</h4>
					<ul class="ul_set lislocc1">

					<?php 
						
						$whereCity = array('is_delete'=>0);
						
						if(isset($city_name) && !empty($city_name)){
							$whereCity['city_name != '] = $city_name;
						}
						
						$cites=$this->common_model->GetColumnName('tbl_city', $whereCity,null,true);
						//echo $this->db->last_query();
						
						foreach ($cites as $city) {

							?>
							<li><i class="fa fa-caret-right" onclick="expandSub('<?= $city['city_name'] ?>_<?= $city['id'] ?>')"></i><a href="<?php echo base_url('find-tradesmen/'.strtolower($city['city_name'])); ?>"><?=$city['city_name']?></a> 
							<?php
								$local_cat = $this->common_model->get_all_data('local_category', array('location'=>$city['id'], 'enabled'=>1));
								 ?>
									
									<ul class="<?= $city['city_name'] ?>_<?= $city['id'] ?>">
									<?php foreach ($local_cat as $lkey => $lv) {
										$cat_datails111 = $this->common_model->get_single_data('category', array('cat_id'=>$lv['cat_parent'])); ?>
										<li><a style="padding-left: 10px;" href="<?php echo base_url($lv['slug']); ?>"><?php echo $cat_datails111['cat_name']; ?> in <?= $city['city_name'] ?></a></li>

									<?php	} ?>
									</ul>
							</li>
								
						<?php } ?>


					</ul>
				</div>
				
				<?php 
				if($city_data){ 
				$local_cat2 = $this->common_model->get_all_data('local_category', array('location'=>$city_data['id'], 'enabled'=>1));
				if(!empty($local_cat2)){ 
				?>
				<div class="Locations_list11 fat-side-item fat-side-item2">
					<h4>Top <?= $city_data['city_name']; ?> Categories</h4>
					
					<ul class="ul_set lislocc1">

					<?php 
						
						foreach ($local_cat2 as $local_cat2in) {
							$cat_datails111 = $this->common_model->get_single_data('category', array('cat_id'=>$local_cat2in['cat_parent']));
							?>
							<li><i class="fa fa-caret-right"></i><a href="<?php echo base_url($local_cat2in['slug']); ?>"><?php echo $cat_datails111['cat_name']; ?> in <?= $city_data['city_name'] ?></a>
						<?php } ?>


					</ul>
				</div>
				
				<?php } ?>
				<?php } ?>
				
				<div class="Locations_list11 fat-side-item open_omon2">
					<h4>How it works</h4>
					<h5 class="h4_size">
						1) Post a job
					</h5>
					<p>It's easy. Simply post your job and we'll notify our local tradespeople near you to provide you with quotes. </p>
					<h5 class="h4_size">
						2) Get quotes.
					</h5>
					<p>
						Compare the quotes. Read profiles, ratings & browse previous work history. Chat in real-time. Choose and award the job to the perfect tradesperson.
					</p>
					<h5 class="h4_size">
						3) Pay securely. 
					</h5>
					<p>
						Create a milestone payment. Pay only when you’re satisfied with the completed task and rate your tradesperson.</p>
				</div>

			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>


<script type="text/javascript">

	
function clearFilter()
{
	var rating = $('#input-1').val(0);
	$(".filled-stars").css("width", "0%");
	$(".empty-stars").css("width", "100%");
	var search = $('#search').val('');
	var cate_id = $('#category_id').val('');
	var location = $('#location').val('');
	searchFilter();
}
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var rating = 0;
	var rating = $('#input-1').val();
	var search = $('#search').val();
	var cate_id = $('#category_id').val();
	var location = $('#location').val();
	$.ajax({ 
		type:'POST',
		url:site_url+'search/find_tradesman_ajax/'+page_num,
		data:'page_num='+page_num+'&rating='+rating+'&search='+search+'&cate_id='+cate_id+'&location='+location,
		dataType:'JSON',
		beforeSend:function()
		{
			//$('.search_btn').prop('disabled',true);
			//$('.btn_loader').show();
		},
		success:function(resp)
		{
			//$('.search_btn').prop('disabled',false);
			//$('.btn_loader').hide();
			$('#search_data').html(resp.data);
		}
	});
	return false;
}

function expandSub(catClass) {
	
	$('.'+catClass).toggleClass('active');
}
</script>