<?php include ("include/header.php") ?>
<div class="acount-page membership-page">
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="categry_mm">
                <ul>
                    <?php  
                     if(count($all_category)){
                      foreach ($all_category as $key => $all_row) {  
                     ?>

                    <li class="suubmm">

                         <a href="<?php echo site_url('find-tradesmen/'.$all_row['cat_id']);?>" target="_blank"><img src="<?php echo site_url();?>img/category/<?php echo $all_row['cat_image']; ?>">  <?php echo $all_row['cat_name']; ?></a>
                         <?php $this->common_model->get_cheild($all_row['cat_id']); ?>
                     
                    
                    </li> 
                    <?php }} ?> 
                </ul>

                
            </div>
        </div>
    </div>
</div>
</div>		
<?php include ("include/footer.php") ?>
