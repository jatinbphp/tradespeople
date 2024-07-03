<?php 
include 'include/header.php';
?>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
       
				<div class="col-sm-9">
					<div class="mjq-sh">
						<h2><strong>Buy Addon</strong> </h2>
					</div>
					
					<?php if($user_plans){ ?>
					
					<div class="verify-page">
						<div style="background-color:#fff;padding: 10px;">
							<?php if($addon['type']==1){ ?>
							<p>Please note that any unused credits at the end of the billing cycle will be transferred to your next monthly plan credits. If for example, you added 3 extra credits and used 2, the remaining 1 credit will be added to your future credits.</p>
							<?php } else { ?>
							<p>Please note that any unused sms at the end of the billing cycle will be transferred to your next monthly plan sms. If for example, you added 3 extra sms and used 2, the remaining 1 sms will be added to your future credits.</p>
							<?php } ?>
						</div>
					</div>

					<div class="mjq-sh" style="opacity: 0;">
						<h2><strong></strong> </h2>
					</div>
					
					<div class="verify-page">
						<div class="text-center1" style="background-color:#fff;padding: 10px;">
							<p><input type="checkbox" name="confirm" id="confirm" value="1"> Please confirm you wish to add <?php echo $addon['description']; ?> for <i class="fa fa-gbp"></i><?php echo $addon['amount']; ?></p>
							
							<div class="pay_btn strip_btn " id="strip_btn"><img style="width: 147px;height: 40px;" src="<?= base_url(); ?>img/pay_with.png"></div>
							
						</div>
						
					</div>
					
					<?php } else { ?>
					<div class="verify-page">
						<div style="background-color:#fff;padding: 10px;">
							<p>You do not have any membership plan. Please <a href="<?php echo base_url('membership-plans'); ?>">click here</a> to subscribe.</p>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<?php if($user_plans){ ?>
<script>
var amounts = <?php echo $addon['amount']; ?>;
$(document).ready(function(){
	$('#strip_btn').attr('onclick','check_confirm()');
});

function check_confirm(){
	if($('#confirm').is(':checked')){
		show_lates_stripe_popup(amounts,amounts,9,<?php echo $addon['id']; ?>);
	} else {
		alert('Please confirm checkbox!');
	}
}
// data:{plan_id:onSuccess, cardID:cardID,actual_amt:actual_amt},
function buy_addons(id, cardID, actual_amt){
	// console.log(id, cardID, actual_amt);

	$.ajax({
		type:'post',
		url:site_url+'addon/buy_addons',
		dataType:'JSON',
		data:{id:id, cardID:cardID, actual_amt:actual_amt},
		success:function(res){
			if(res.status == 1){
			 window.location.href = site_url + 'subscription-plan';
			} else {
				loading(false);
				swal('Some problem occurred, please try again.');
			}
		}
	});
}
</script>
<?php } ?>
<?php include ("include/footer.php") ?>
    