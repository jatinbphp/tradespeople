 <?php include 'include/header.php'; ?>
	<style type="text/css">
		.row{
			margin-bottom: 7px;
		}
	</style>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
			<div class="acount-page membership-page">
				<div class="container"> 
					<div class="user-setting">
						<div class="row" >
							<div class="col-sm-3">
								<?php include 'include/sidebar.php'; ?>         
							</div>
							<div class="col-sm-9 payment_settings">
								<div class="user-right-side">
									<h1 style="padding-left: 41px;">Payment Details</h1><hr>
									<form  method="post" enctype="multipart/form-data" class="update_marketers_account_details">  
										<div class="edit-user-section" style="border-bottom: 0px solid #e1e1e1;padding: 30px 43px;">
											<div class="row">
												<div class="col-lg-4">
													<p>Account holder's Name</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="account_holder_name" name="account_holder_name" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Account holder address</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="account_holder_address" name="account_holder_address" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Bank account number</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="account_number" name="account_number" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Sort code</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="sort_code" name="sort_code" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Bank name</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="bank_name" name="bank_name" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4">
													<p>Paypal email address</p>
												</div>
												<div class="col-lg-5">
													<input type="text" id="paypal_email_address" name="paypal_email_address" class="form-control" value="">
												</div>
											</div>
											<div class="row">
												<p style="padding-left: 16px;">
													Note : Any transaction fees charged by your bank or Paypal will be deducted from the total transfer amount.Funds will be credited to your balance on the next business day after the funds are received by bank.If you have any questions please contact us.
												</p>
											</div>
											<div class="">
											<div class="row nomargin" style="background: #fff; padding: 10px 0;">
												<div class="col-sm-12" style="padding-left: 0px;">
													<button type="submit" class="btn btn-primary" style="width: 10%;">SAVE</button>
												</div>                                 
											</div>
										</div>
										</div>
									</form>
								</div>
							</div>			
						</div>
					</div>
				</div>
			</div>
<?php include 'include/footer.php'; ?>