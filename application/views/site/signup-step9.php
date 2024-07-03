<?php 
include ("include/header1.php");
?>
<?php
  $billing_details = $this->common_model->get_single_data("billing_details", array("user_id" => $user_data['id']));
?>
<!-- how-it-work -->
<div class="start-sign">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
        <div class="white-start">
          <div class="sing-top">
            <h1> 
              Last Step - Billing Details
            </h1>
          </div>
          
          <div class="sing-body set-mynform">
            <form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup9();">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Name on Card </label>
                    <input type="text" name="name" class="form-control" placeholder="" value="<?=($billing_details) ? $billing_details['name'] : '';?>" required  />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>16 Digit Card Number </label>
                    <input type="number" name="number" class="form-control" placeholder="" value="<?=($billing_details) ? $billing_details['number'] : '';?>" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Expiry Date </label>
                    <input type="date" name="expiry" class="form-control" placeholder="" value="<?=($billing_details) ? date("Y-m-d", strtotime($billing_details['expiry'])) : '';?>" min="today" required />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>CVC - Last 3 Digits on back of card </label>
                    <input type="text" name="cvc" class="form-control" placeholder=""  value="<?=($billing_details) ? $billing_details['cvc'] : '';?>" required />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Billing Postcode </label>
                    <input type="text" name="postcode" class="form-control" placeholder="" value="<?=($billing_details) ? $billing_details['postcode'] : '';?>" required />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Enter Manually </label>
                    <input type="text" name="address" class="form-control" placeholder=""  value="<?=($billing_details) ? $billing_details['address'] : '';?>"required />
                  </div>
                </div>
              </div>
              <div class="start-btn maggg1">
                <?php
                  if($billing_details){
                ?>
                    <button type="submit" class="btn btn-warning btn-lg signup_btn">Save Card</button>
                <?php
                  }else{
                ?>
                    <button type="submit" class="btn btn-warning btn-lg signup_btn">Add Card</button>
                <?php
                  }
                ?>
                <a href="email-verify">Do This Later</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    $("#geocomplete").geocomplete({
      details: "form",
      types: ["geocode", "establishment"],
    });
    $("#find").click(function(){
      $("#geocomplete").trigger("geocode");
    });
  });
</script>
<script>
function signup9(){
  $.ajax({
    type: 'POST',
    url: site_url + 'home/submit_signup9/',
    data: $('#signup').serialize(),
    dataType: 'JSON',
    beforeSend:function(){
      $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.signup_btn').prop('disabled',true);
      $('.msg').html('');
    },
    success:function(resp){
      if(resp.status == 1){
        window.location.href = site_url + 'email-verify';
      } else {
        $('.signup_btn').html('Save Card');
        $('.signup_btn').prop('disabled',false);
      }
    }
  });
  return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
