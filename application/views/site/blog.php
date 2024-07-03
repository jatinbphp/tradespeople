<?php include ("include/header.php") ?>
<div class="graty_bg">
  <div class="inner_list">
    <div class="container">
      <ul class="page_linkk ul_set">
        <li>
          <a href="/">Home</a>
        </li>
        <li class="active">
          Blogs
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="Advice_c paddg_0">
  <div class="container">
    <div class="box_whitte set-pr">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <h1 class="head-home"><?php echo $home['blog_title']; ?></h1>
        <p class="text-center">
          <?php echo $home['blog_description']; ?>
        </p>
      </div>
    </div>
    <div class="row">
      <?php
        foreach($blogs as $blog){
      ?>
          <div class="col-sm-4">
            <a href="<?php echo site_url('blog/'.$blog['slug']); ?>" class="boxus_1">
							<?php if($blog['b_image']){ ?>
              <img src="<?= site_url(); ?>img/blog/<?= $blog['b_image']; ?>" class="img_r">
							<?php } else { ?>
							<img src="<?php echo site_url(); ?>img/blog.png" class="img_r">
							<?php } ?>
              <div class="contt">
                <div class="set-onlytext">
                  <h4><?=$blog['b_title'];?></h4>  
                </div>
                <p><?=substr(strip_tags($blog['b_description']), 0, 50);?></p>
              </div>
            </a>
          </div>
      <?php
        }
      ?>
    </div>
   </div>
</div>
</div>
<!-- Slider -->



<?php include ("include/footer.php") ?>