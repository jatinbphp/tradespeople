<?php include ("include/header.php") ?>
<style>
	.payment_method{
		margin-right: 10px!important;
	}

	/*----------LOADER CSS START----------*/
	.loader_ajax_small {
		display: none;
		border: 2px solid #f3f3f3 !important;
		border-radius: 50%;
		border-top: 2px solid #2D2D2D !important;
		width: 29px;
		height: 29px;
		margin: 0 auto;
		-webkit-animation: spin_loader_ajax_small 2s linear infinite;
		animation: spin_loader_ajax_small 2s linear infinite;
	}

	@-webkit-keyframes spin_loader_ajax_small {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin_loader_ajax_small {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	/*----------LOADER CSS END----------*/

	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
	.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
	.imgUp{margin-bottom:15px}
	.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
	.boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;}
	.boxImage img { height: 100%;object-fit: contain;}
	#imgpreview {
		padding-top: 15px;
	}
	.boxImage {
		margin: 0;
	}
	.imagePreviewPlus {
		height: 150px;
		box-shadow: none;
	}
</style>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="thank-purchase-msg alert alert-success">
					<span class="icon">
						<i class="fa fa-check" aria-hidden="true"></i>
					</span>
					<div>
						<h2>Thank You for your Purchase</h2>
						<p><b>A recept wes sent to your email address</b></p>
					</div>
					<button type="button" class="btn-close" aria-label="Close">&times;</button>
				</div>
			</div>

			<div class="col-sm-8">
					<div class="submit-requirements">
					<h4 class="submit-title">Submit Requirements to Start Your Order</h4>
					<div class="p-4">

						<h4>The seller needs the following information to start working on your order:</h4>
						<form>
						<div class="form-group">
							<label>1. website link</label>

							<textarea rows="3"></textarea>
						</div>
						<div class="form-check">
								<div class="check-box">
									<input class="checkbox-effect" id="the" type="checkbox" value="1" name="terms">
									<label for="the">By clicking at the button you agreed to our<a href="http://localhost/tradespeople/terms-and-conditions" target="_blank" class="ml-1">terms &amp; conditions</a>.</label>
								</div>
							</div>
							<div class="btn-group-div">
							<p>Remind Me Latter</p>
							<button class="btn btn-success btn-lg sendbtn1" type="submit" >Start Order</button>
						</div>
							</form>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="box-border p-4 submit-requirements-sidebar">
					<h4>I will fix block website domain URL form facebook</h4>
					<ul class="fix-block-website">
						<li><i class="fa fa-check" aria-hidden="true"></i> 1 Revision</li>
					</ul>

					<ul class="status-order">
						<li><span>Status</span> <span class="bg-warning">Status</span></li>
						<li><span>Order</span> <span>#F06115ACCoPBc6</span></li>
						<li><span>Order Date</span> <span>Jul 10, 2020</span></li>
						<li><span>Quantity</span> <span>X1</span></li>
						<li><span>Price</span> <span>$9.31</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>