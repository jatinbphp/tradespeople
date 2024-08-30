<?php 
include ("include/header1.php");
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
							<a href="https://www.tradespeoplehub.co.uk/signup-step4"><i class="fa fa-caret-left"></i> Back</a>
              <?=($user_data['is_phone_verified'] == 1 ) ? 'Phone Verified' : 'Phone Verification';?>
            </h1>
          </div>
          <p class="alert alert-danger">Wrong Security Code</p>
          <div class="sing-body">
            <?php
              if($user_data['is_phone_verified'] != 1 ){
            ?>
                <form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup7();">
                  <p>We send job notifications via SMS. As a result, we need to verify your phone number.</p>
                  <p>We've just sent you an SMS containing a 4 digit code. Please enter it below.</p>
                  <div class="input_very">
                    <span><input class="form-control quantity" type="text" name="first" maxlength="1"></span>
                    <span><input class="form-control quantity" type="text" name="second" maxlength="1"></span>
                    <span><input class="form-control quantity" type="text" name="third" maxlength="1"></span>
                    <span><input class="form-control quantity" type="text" name="fourth" maxlength="1"></span>
                  </div>
                  <!--
                  <input type="number" class="form-control" name="verification_code" />
                  -->
                  <div class="start-btn maggg1">
                    <button type="submit" class="btn btn-warning btn-lg signup_btn">Verify</button>
                    <a href="email-verify">Do This Later</a>
                  </div>
                </form>
            <?php
              }else{
            ?>
                <a href="email-verify" class="start-btn text-center"> Next </a>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(".alert").hide();
  function signup7(){
    $(".alert").hide();
    var first = $("#signup input[name=first]").val();
    var second = $("#signup input[name=second]").val();
    var third = $("#signup input[name=third]").val();
    var fourth = $("#signup input[name=fourth]").val();
    if(!first || !second || !third || !fourth){
      alert('Please enter 4 digit code.');
      return false;
    }
    var verification_code = first + second + third + fourth;
    $.ajax({
      type:'POST',
      url:site_url+'home/submit_signup7/',
      // data:$('#signup').serialize(),
      data: {
        'verification_code' : verification_code
      },
      dataType:'JSON',
      beforeSend:function(){
        $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $('.signup_btn').prop('disabled', true);
        $('.msg').html('');
      },
      success:function(resp){
        if(resp.status == 1){
          // window.location.href = site_url+'signup-step8';
          window.location.href = site_url + 'email-verify';
        } else {
          $(".alert").show();
          $('.signup_btn').html('Verify');
          $('.signup_btn').prop('disabled', false);
        }
      }
    });
    return false;
  }

  $('input.quantity').on('keyup', function(e) {
    // console.log(e.which);
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      /* 96 - 105 */
      return false;
    }
    if ($(this).val()) {
      $(this).parent().next().find('.quantity').focus();
    }
  });

  $('input.quantity').on('focus', function() {
    if ($(this).val()) {
      $(this).val('');
    }
  });
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>