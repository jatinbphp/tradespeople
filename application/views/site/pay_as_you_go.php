<?php include 'include/header.php'; ?>

<div class="acount-page membership-page">
<div class="container">
        <div class="user-setting">
            <div class="row">
                <div class="col-sm-3">
                    <?php include 'include/sidebar.php'; ?>
                </div>
                <div class="col-sm-9">
                      <div class="mjq-sh">
                    <h2><strong>Pay as you go</strong>
                    </h2>
           </div>
           <?php  if($user_plans){ $get_all_packages=$this->common_model->get_single_data('tbl_package',array('id'=>$user_plans[0]['up_plan'])); ?>
<div class="row subscription-hp">
    <div class="col-md-4 margin-right5">
        <div class="section">
            <h3>Your Plan</h3>
                            <h2 style="font-size: 20px;"><?php echo $user_plans[0]['up_planName']; ?></h2>
                            <p><i class="fa fa-gbp"></i><?php echo $get_all_packages['amount']; ?></p>
                           
                          
                           
                       
        </div>
    </div>  
    <div class="col-md-4 margin-right5">
        <div class="section">
            <h3>Renewal Date</h3>
                            <h2 style="padding: 0;font-size: 20px;"><?php $yrdata= strtotime($user_plans[0]['up_enddate']);
                                    echo date('d',$yrdata); echo ' '.date('M', $yrdata); ?>, <?php echo date('Y',$yrdata); ?></h2>                          
        </div>
    </div>
    <div class="col-md-4 margin-right5">
        <div class="section remaining-credits">
            <h3>Remaining Bids</h3>
            <h2 style="font-size: 20px;"><?php if($user_plans[0]['bid_type']==1){ echo $user_plans[0]['up_bid']-$user_plans[0]['up_used_bid'];  }else{ echo "Unlimited Bids"; } ?></h2>
  
           
        </div>
    </div>
</div>

<?php }else{
    ?>
      <div class="verify-page">
                            <div class="message-block verification-message">
                                <p>You do not have any credit quote, chat and reply to your messages. Please <a href="<?php echo base_url('membership-plans'); ?>">click here</a> to purchase one.</p>
                            </div>
                        </div>
    <?php
} ?>

</div>

</div>

              </form>
                        
                    
            </div>
        </div>
</div>
</div>
<?php include ("include/footer.php") ?>
    