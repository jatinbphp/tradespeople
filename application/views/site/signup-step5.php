<?php 
include ("include/header1.php");
?>
<!-- how-it-work -->
<?php
  $signup_step5 = false;
  $work_history = '';
  if($this->session->userdata('signup_step5')){
    $signup_step5 = $this->session->userdata('signup_step5');
    $work_history = $signup_step5['work_history'];
  }
?>

<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						<h1>
              <a href="<?=base_url("signup-step4"); ?>"><i class="fa fa-caret-left"></i> Back</a>
							Work History
						</h1>
					</div>
					
					<div class="sing-body">
						<form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup2();">
							
							<p> Since when have you been doing your trade? How has your business and the type of work you do evolved over time?</p>
					
							<textarea class="form-control" name="work_history" id="work_history" required rows="14"><?=$work_history; ?></textarea>
							
							<p><b>Please don't include contact details or your website in this section.</b></p>

							<hr>
							
							<div class="start-btn text-center">
								<button type="submit" class="btn btn-warning btn-lg signup_btn">Save and Continue</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
  /*
  $(function(){
    $("#geocomplete").geocomplete({
      details: "form",
      types: ["geocode", "establishment"],
    });
    $("#find").click(function(){
      $("#geocomplete").trigger("geocode");
    });
  });
  */

  function signup2(){
    $.ajax({
      type:'POST',
      url:site_url+'home/submit_signup5/',
      data:$('#signup').serialize(),
      dataType:'JSON',
      beforeSend:function(){
        $('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $('.signup_btn').prop('disabled',true);
        $('.msg').html('');
      },
      success:function(resp){
        if(resp.status==1){
          //window.location.href = site_url+'email-verify';
          window.location.href = site_url+'signup-step7';
        } else {
          $('.signup_btn').html('Save and Continue');
          $('.signup_btn').prop('disabled',false);
        }
      }
    });

    return false;
  }
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
