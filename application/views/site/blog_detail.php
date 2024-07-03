<?php include ("include/header.php") ?>

<?php
$share_link_to_social = true;
?>
<div class="pre-body">
<!--<div class="costy-topbg" style="background:url(../img/costguide/<?=$costGuide['image'];?>)"></div>-->
<div class="all-main">
  <div class="container">
    <div class="row">
      <div class="col-sm-8" id="content">
        <div class="cost-aside">
          <div class="cost-upnav">
            <ul>
                <li><a href="<?php echo site_url(''); ?>">Home</a> > </li>
  <li><a href="<?php echo site_url('blog'); ?>">Blog</a> > </li>
  <li><?php echo $blogDetail['b_title']; ?></li>
            </ul>
          </div>
          <div class="cost-section1">
            <h1><?php echo $blogDetail['b_title']; ?></h1>
						<?php /*<p class="tradesman-feedback__meta"><strong class="job-author"><i class="fa fa-calendar"></i> Last updated:</strong><em class="job-date"><?php echo date('d F',strtotime($blogs['b_cdate'])).','.date('Y',strtotime($blogs['b_cdate'])); ?></em></p> */ ?>
            <?php if($blogDetail['b_image']){ ?><img data-a2a-overlay="false" src="<?= site_url(); ?>img/blog/<?= $blogDetail['b_image']; ?>"><?php } ?>
          </div>
          <div class="cost-section4">
            <?php 
						
						echo str_replace("img/common/",site_url()."img/common/",$blogDetail['b_description']);
 ?>
          </div>
         
        </div>
      </div>
      <div class="col-sm-4">
        <div class="cost-bside">
          <div class="cobside-section1">
            <div class="cosup-head">
              <h2>READY TO GET A QUOTE?</h2>
            </div>
            <img src="../img/post-cost.png">
            <p>Post your job in minutes and get quotes from local and reliable trades.</p>
            <!--form>
              <div class="input-group">
                  <input type="text" class="form-control" name="email" placeholder="Enter your postcode">
                  <span class="input-group-addon">Find Trades</span>
              </div>
            </form-->
						<div class="text-center">
							<a href="<?php echo site_url(); ?>post-job" post-job"="" class="btn btn-warning btn-lg">Get a Quote</a>
						</div>
          </div>
         <div class="cobside-section2">
            <div class="cosup-head">
              <h2>RELATED ARTICLES</h2>
            </div>
						<?php
							foreach($related as $row){
							if($row['b_id']!=$blogDetail['b_id']){
						?>
            <div class="stp-1 set-all">
							<a href="<?php echo site_url(); ?>blog/<?=$row['slug'];?>">
								<div class="row">
									<div class="col-sm-5">
										<?php  if($row['b_image']){ ?>
										<img src="<?= site_url(); ?>img/blog/<?= $row['b_image']; ?>">
										<?php  }else{ ?>
										<img src="<?php echo site_url(); ?>img/blog.png">
										<?php  } ?>
										
									</div>
									<div class="col-sm-7">
										<p><?=$row['b_title'];?></p>
									</div>
								</div>
              </a>
            </div>
					 <?php
									}
									}
								?>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

</div>
<?php include ("include/footer.php") ?>