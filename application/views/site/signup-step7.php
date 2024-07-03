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
                  <!--<p>We send job notifications via SMS. As a result, we need to verify your phone number.</p>-->
                  <p>We've just sent you an SMS containing a 4 digit code to <span id="userPhoneNo"><?php echo $user_data['phone_no'];?></span> <a href="javascript:void(0);" data-toggle="modal" data-target="#updatePhoneModal" style="color: #3d78cb;">Edit</a>. Please enter it below.</p>
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
                    <!-- <a href="email-verify">Do This Later</a> -->
                    <a href="javascript:void(0);" id="codeResend" style="color: #3d78cb;">Resend Code</a>
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

<div class="modal fade" id="updatePhoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Phone No.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="col-md-12 control-label"> Phone number *</label>
          <div class="col-md-12 input-group">
            <span class="input-group-addon">+44</span>
            <input type="text" class="form-control input-lg" name="phone_no" id="phone_no" value="" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updatePhone">Update</button>
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

  $('#updatePhone').on('click', function(){
    var phone_no = $('#phone_no').val();
    $.ajax({
      type:'POST',
      url:site_url+'home/update_phone/',
      data: {
        'phone_no' : phone_no
      },
      success:function(resp){
        $('#updatePhoneModal').modal('hide');
        if(resp == 1){
          $('#userPhoneNo').html(phone_no);
          swal("Success", "Your phone number has been updated successfully. And We've just sent you an SMS containing a 4 digit code to "+phone_no, "success");
        }else if(resp == 2){
          swal("Error", "This phone number "+phone_no+" is already registered.", "error");
        }else{
          swal("Error", "Something is wrong.", "error");
        }
      }
    });
  });

  $('#codeResend').on('click', function(){
    $.ajax({
      type:'POST',
      url:site_url+'home/codeResend/',
      success:function(resp){
        var old_phone_no = $('#userPhoneNo').text();
        if(resp == 1){
          swal("Success", "We've just sent you an SMS containing a 4 digit code to "+old_phone_no, "success");
        }else{
          swal("Error", "Something is wrong.", "error");
        }
      }
    });
  });
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>