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
              <a href="<?=base_url("signup-step2"); ?>"><i class="fa fa-caret-left"></i> Back</a>
							Tell customers about your business
						</h1>
						<p class="text-center">
						Creating a good profile is vital to success on TradespeopleHub. The next section will take you through the process.</p>
					</div>
					
					<div class="sing-body">
						<div class="start-btn text-center">
							<a href="<?php echo site_url().'signup-step4';?>" class="btn btn-warning btn-lg signup_btn">OK, let's go</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
