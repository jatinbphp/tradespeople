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
							Qualifications
						</h1>
					</div>
					
					<div class="sing-body">
						<form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup2();">
							
							<p>Please list your qualifications and accreditations (with the relevant registration number) in this section. If you're time served tradesman, leave this section blank.</p>
					
							<textarea class="form-control" name="qualification" id="work_history" rows="14"><?php echo $user_data['qualification']; ?></textarea>
							
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
function signup2(){
	$.ajax({
		type:'POST',
		url:site_url+'home/submit_signup6/',
		data:$('#signup').serialize(),
		dataType:'JSON',
		beforeSend:function(){
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.signup_btn').prop('disabled',true);
			$('.msg').html('');
		},
		success:function(resp){
			if(resp.status==1){
				window.location.href = site_url+'signup-step7';
				//window.location.href = site_url+'signup-step6';
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
