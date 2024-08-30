<?php 
include ("include/header1.php");
$step1 = $this->session->userdata('signup_step1');
$step2 = $this->session->userdata('signup_step2');
//print_r($category);
if(!$step1){
	redirect('signup-step1');
}
?>
<!-- how-it-work -->

<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2" id="top">
				<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						<h1>
							<a href="<?php echo base_url("signup-step1"); ?>"><i class="fa fa-caret-left"></i> Back</a> 
							Which trades do you cover?
						</h1>
						<p class="text-center">
						<a style="opacity:0;" href="<?php echo base_url("signup-step1"); ?>"><i class="fa fa-caret-left"></i> Back</a>
						Please select only those trades that you have experience.</p>
					</div>
					
					<div class="sing-body">
						<form method="post" id="signup" enctype="multipart/form-data" onsubmit="return signup2();">
						
							<?php 
							foreach($category as $key => $value){
							//print_r($value);
							$checked = ($step2 && in_array($value['cat_id'],$step2['category']))?'checked':'';
							$child =$this->common_model->GetColumnName('category',array('is_delete'=>0,'cat_parent'=>$value['cat_id']),null,true,'cat_id','asc');
							?>
							<div class="checkbox">
								<label><input <?php echo $checked; ?> type="checkbox" name="category[]" onchange="expandSub('sub_<?= $value['cat_id'] ?>' , this)" value="<?php echo $value['cat_id']; ?>"> <?php echo $value['cat_name']?></label>
								<div class="child sub_<?= $value['cat_id'] ?>">
									<?php foreach($child as $cvalue){ 

										$cchecked = ($step2 && in_array($cvalue['cat_id'],$step2['subcategory']))?'checked':'';
									?>

									<div class="checkbox">
										<label><input <?php echo $cchecked; ?> type="checkbox" name="subcategory[]" value="<?php echo $cvalue['cat_id']; ?>"> <?php echo $cvalue['cat_name']?></label>
									</div>
								<?php } ?>
								</div>
							</div>
										
							<?php } ?>
									
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
	
	if($('[name="category[]"]').is(":checked") ){
	  
		$.ajax({
			type:'POST',
			url:site_url+'home/submit_signup2/',
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
					// window.location.href = site_url + 'signup-step3';
					window.location.href = site_url + 'signup-step4';
				} else {
					//alert('please select cetegory!');
					$('.msg').html(resp.msg);
					$('.signup_btn').html('Save and Continue');
					$('.signup_btn').prop('disabled',false);
					window.location.href="#top";
				}
			}
		});
	   
		
	} else {
		alert('please select category');
	}
	
	return false;
}
$('.child').hide();
function expandSub(clsName , elem)
{
	if($(elem).is(":checked"))
	{
		$('.'+clsName).show();
	}
	else
	{
		
		$('.'+clsName).hide();
	}
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
