<?php include 'include/header.php'; ?>

<script>
/*setTimeout(function(){
	window.top.location.href = "<?php echo base_url(); ?>dashboard";
},5000);*/
</script>
	<div class="acount-page membership-page">
		<!-- loop -->
		<div class="container">        
			<div class="user-setting">
				<div class="row">
				  
					<div class="col-md-3">
						<?php include 'include/sidebar.php'; ?>
					</div>
					<div class="col-md-9">
						<div class="user-right-side">
							<a href="<?php echo base_url(); ?>dashboard" class="bbak2">Back To Dashboard</a>
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<div class="message_susseg">
										<div class="alert alert-success">
											$<?php echo $payment_detail['tr_amount']; ?> has been deposited in you wallet successfully.
										</div>
										<div class="icon_suu">
											<i class="fa fa-check-circle fa-2x"></i>
											<h3>Success</h3>
											<h4>Transaction Id: <span><?php echo $payment_detail['tr_transactionId']; ?></span></h4>
										</div>
										<div class="list_aaa">
											<p>Amount : <span> $<?php echo $payment_detail['tr_amount']; ?></span></p>
											<p>Time : <span> <?php echo date('d-m-Y H:i:s',strtotime($payment_detail['tr_created']))?></span></p>
											
										</div>
									</div>
								</div>
							</div>		
						</div>
						
					</div>
				</div>
			</div>
		</div>
			<!-- loop -->
	
	</div>
<!-- /.content-wrapper -->
<?php include 'include/footer.php'; ?>
