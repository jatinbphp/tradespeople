<?php include ("include/header.php") ?>
<div class="graty_bg">
  <div class="inner_list">
    <div class="container">
      <ul class="page_linkk ul_set">
        <li>
          <a href="/">Home</a>
        </li>
        <li class="active">
          Cost guides
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
        <h1 class="head-home"><?php echo $home['cost_title']; ?></h1>
        <p class="text-center">
          <?php echo $home['cost_description']; ?>
        </p>
      </div>
    </div>
    <div class="row">
      <?php
        foreach($costGuides as $costGuide){
      ?>
          <div class="col-sm-4">
            <a href="<?php echo site_url(); ?>cost-guides/<?=$costGuide['slug'];?>" class="boxus_1">
              <img src="<?php echo site_url(); ?>img/costguide/<?=$costGuide['image'];?>" class="img_r">
              <div class="contt">
                <div class="set-onlytext">
                  <h4><?=$costGuide['title'];?></h4>  
                  <h5>£<?=round($costGuide['price'], 0);?><?= ($costGuide['price2']>0)?' - £'.round($costGuide['price2']):'';?></h5>
                </div> 
                <p><?=($costGuide['description'])?substr(strip_tags($costGuide['description']), 0, 47).'...':'';?></p>
              </div>
            </a>
          </div>
      <?php
        }
      ?>
    </div>
    <!--
    <div class="row">
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_2.png" class="img_r">
          <div class="contt">
            <h4>Planning permission</h4>
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_3.png" class="img_r">
          <div class="contt">
            <h4>Permitted development</h4>
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_1.png" class="img_r">
          <div class="contt">
            <h4>Building regulations</h4>
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_2.png" class="img_r">
          <div class="contt">
            <h4>Planning permission</h4>
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_3.png" class="img_r">
          <div class="contt">
            <h4>Permitted development</h4>
          </div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_1.png" class="img_r">
          <div class="contt">
            <h4>Building regulations</h4>
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_2.png" class="img_r">
          <div class="contt">
            <h4>Planning permission</h4>
          </div>
        </a>
      </div>
      <div class="col-sm-4">
        <a class="boxus_1">
          <img src="img/img_3.png" class="img_r">
          <div class="contt">
            <h4>Permitted development</h4>
          </div>
        </a>
      </div>
    </div>
    -->
  </div>
</div>
</div>
<!-- Slider -->



<?php include ("include/footer.php") ?>