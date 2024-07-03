<?php include ("include/header.php");?>
<div class="pre-body">
<!--<div class="costy-topbg" style="background:url(../img/costguide/<?=$costGuide['image'];?>)"></div>-->
<div class="all-main">
  <div class="container">
    <div class="row">
      <div class="col-sm-8" id="content">
        <div class="cost-aside">
          <div class="cost-upnav">
            <ul>
              <li><a href="/">Home</a> > </li>
              <li><a href="../cost-guides">Cost Guides</a> > </li>
              <li><a href="javascript:void(0);"><?=$costGuide['title'];?></a></li>
            </ul>
          </div>
          <div class="cost-section1">
            <h1><?=$costGuide['title'];?></h1>
            <p style="display:none;">Everything you may want to know about installing a steam shower, including the costs involved and the time frames you should expect.</p>
            <img src="../img/costguide/<?=$costGuide['image'];?>">
          </div>
          <div class="cost cost-guid-price">
            <div class="text">
              <h3>The average <?=ucfirst($costGuide['title']);?> is around</h3>
              <!--
              <h4>Depending on the your bathroom and chosen shower, it usually takes: 1-2 Days</h4>
              -->
            </div>
            <div class="price"><h5>£<?=round($costGuide['price'], 0);?><?= ($costGuide['price2']>0)?' - £'.round($costGuide['price2']):'';?></td>
                  <td class=""></h5></div>
            <div style="clear:both;"></div>
          </div>
          <div class="cost-section4">
            <?php
							echo str_replace("img/common/",site_url()."img/common/",$costGuide['description']);?>
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
							foreach($costGuides as $row){
							if($row['id']!=$costGuide['id']){
						?>
            <div class="stp-1 set-all">
							<a href="<?php echo site_url(); ?>cost-guides/<?=$row['slug'];?>">
								<div class="row">
									<div class="col-sm-5">
										<?php  if($row['image']){ ?>
										<img src="<?php echo site_url(); ?>img/costguide/<?=$row['image'];?>">
										<?php  }else{ ?>
										<img src="../img/bside1.jpg">
										<?php  } ?>
										
									</div>
									<div class="col-sm-7">
										<p><?=$row['title'];?></p>
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