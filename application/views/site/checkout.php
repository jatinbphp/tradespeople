<?php include ("include/header.php") ?>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row checkout-form">
			<form action="<?= site_url().'checkout/placeOrder'; ?>" id="checkoutForm" method="post">
				<input type="hidden" name="service_id" value="<?php echo $service_details['id']; ?>">
				<input type="hidden" name="ex_service_id" value="<?php echo $exIds; ?>">

				<?php if($this->session->flashdata('error')): ?>
					<div class="col-md-12">
						<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
						<?php unset($_SESSION['error']) ?>
					</div>	
				<?php endif; ?>
				<?php if($this->session->flashdata('success')): ?>
					<div class="col-md-12">
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php unset($_SESSION['success']) ?>
					</div>
				<?php endif; ?>

				<div class="col-sm-12">
                    <div class="form-group">
                        <span id='formErrors' class='text-danger'></span>
                    </div>
                </div>

				<div class="col-sm-8">
					<h2 class="title">Select your payment method</h2>
					<div class="row">
						<div class="col-sm-12">
							<?php if(isset($userCardData) && count($userCardData)): ?>
								<h4>Your Saved Card</h4>
                                    <?php $i=1; ?>
                                    <div class="user-card-box">
                                    <?php foreach($userCardData as $key => $data): ?>
                                    	
                                        <div>
                                            <input id="card_<?php echo $key; ?>" class='user-card' type="radio" name="payment_method" value="<?php echo $key; ?>">
                                            <label class="article-lable" for="card_<?php echo $key; ?>"><h5><?php echo ($data['brand'] ?? '').' - '. ($data['last4'] ?? ''); ?></h5></label>
                                        </div>
                                        
                                        <?php $i++; ?>
                                    <?php endforeach; ?>                                   
                                </div>
                            <?php endif; ?>


							<div class="form__radio">
								<label for="stripe"><svg class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
										<path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z" stroke="#fe8a0f" stroke-width="1.5"/>
										<path d="M10 16H6" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M14 16H12.5" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M2 10L22 10" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
									</svg>
								</svg>New Card</label>
								<input id="stripe" name="payment_method" class="payment_method" type="radio" value="card">
							</div>
							<!-- <p><b>Tradespeople Hub accepts all Visa, MasterCard and Maestro cards.</b></p> -->
						</div>
						<div class="col-sm-12">
							<div class="form__radio">
								<label for="wallet"><svg class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
										<path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z" stroke="#fe8a0f" stroke-width="1.5"/>
										<path d="M10 16H6" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M14 16H12.5" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M2 10L22 10" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
									</svg>
								</svg>Wallet</label>
								<input id="wallet" name="payment_method" class="payment_method" type="radio" value="wallet">
							</div>
							<!-- <p><b>Tradespeople Hub allows you to payment from your wallet</b></p> -->
						</div>
					</div>
					<div id="card-detail" style="display:none; margin-bottom: 15px;">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
                                    <div class="form-group">
                                        <span id='StripePaymentErrors' class='text-danger'></span>
                                    </div>
                                </div>

								<div class="col-sm-12">
									<label class="control-label">Card number</label>
									<!-- <input type="text" class="form-control input-lg" minlength="16" maxlength="16" id="card-number-element" name="card" placeholder="0000 0000 0000 0000"> -->
									<div class='form-control input-lg ' id="card-number-element"></div>
									<span class='incomplete_number text-danger error-card'></span>
								</div>
							</div>
						</div>
						<!-- <div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label class="control-label">Name on card</label>
									<input type="text" name="name" class="form-control input-lg" placeholder="Name on card">
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<div class="row">
								<div class="col-sm-4">
									<label class="control-label">Expiry date</label>
									<!-- <input class="form-control input-lg" name="expiry" id="expiry" type="text" placeholder="MM/YY"> -->
									<div class='form-control input-lg' id="card-expiry-element"></div>
                                    <span class='incomplete_expiry invalid_expiry_year_past text-danger error-card'></span>
								</div>
								<div class="col-sm-4">
									<label class="control-label">CVV <i class="fa fa-info-circle" aria-hidden="true"></i></label>
									<!-- <input type="text" class="form-control input-lg" minlength="3" maxlength="4" id="cvc" name="cvc" placeholder="123"> -->
									<div class='form-control input-lg' id="card-cvc-element"></div>
                                    <span class='incomplete_cvc text-danger error-card'></span>
								</div>
								<div class="col-sm-4">
                                    <div class="form-group">
                                    	<label class="control-label">Postal Code</label>
                                        <div class='form-control input-lg' id="postal-code-element"></div>
                                        <span class='incomplete_zip text-danger error-card'></span>
                                    </div>
                                </div>
							</div>
						</div>
						<?php if($this->session->userdata('user_id')):?>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-check">
											<div class="check-box">
												<input class="checkbox-effect" id="Save_Card" type="checkbox" value="Save-Card" name="save_card"/>
												<label for="Save_Card">Save Card</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>											
				</div>
				<div class="col-sm-4">
					<div class="card-summary">
						<div class="celebration-box" id="discountMsgDiv" style="display:none;">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M4.01207 15.7618L5.70156 10.6933C6.46758 8.39525 6.85059 7.24623 7.75684 7.03229C8.6631 6.81835 9.51953 7.67478 11.2324 9.38764L14.6114 12.7666C16.3242 14.4795 17.1807 15.3359 16.9667 16.2422C16.7528 17.1484 15.6038 17.5314 13.3057 18.2975L8.23724 19.987C5.47183 20.9088 4.08912 21.3697 3.35924 20.6398C2.62936 19.9099 3.09026 18.5272 4.01207 15.7618Z" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
								<path opacity="0.5" d="M12.2351 18.3461C12.2351 18.3461 11.477 16.0649 11.477 14.5552C11.477 13.0454 12.2351 10.7643 12.2351 10.7643M8.06517 19.4833C8.06517 19.4833 7.42484 16.7314 7.307 14.9343C7.11229 11.965 8.06517 7.35254 8.06517 7.35254" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M14.5093 10.0061L14.6533 9.28614C14.7986 8.55924 15.3224 7.96597 16.0256 7.73155C16.7289 7.49714 17.2526 6.90387 17.398 6.17697L17.542 5.45703" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M17.5693 13.2533L17.7822 13.3762C18.4393 13.7556 19.2655 13.6719 19.8332 13.1685C20.3473 12.7126 21.0794 12.597 21.709 12.8723L22.0005 12.9997" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
								<path d="M9.79489 2.77903C9.4574 3.33109 9.54198 4.04247 9.99951 4.5L10.0974 4.59788C10.4906 4.99104 10.6355 5.56862 10.4746 6.10085" stroke="#fe8a0f" stroke-width="1.5" stroke-linecap="round"/>
								<g opacity="0.5">
									<path d="M6.92761 3.94079C7.13708 3.73132 7.47669 3.73132 7.68616 3.94079C7.89563 4.15026 7.89563 4.48988 7.68616 4.69935C7.47669 4.90882 7.13708 4.90882 6.92761 4.69935C6.71814 4.48988 6.71814 4.15026 6.92761 3.94079Z" fill="#fe8a0f"/>
								</g>
								<g opacity="0.5">
									<path d="M12.1571 7.1571C12.3666 6.94763 12.7062 6.94763 12.9157 7.1571C13.1251 7.36657 13.1251 7.70619 12.9157 7.91566C12.7062 8.12512 12.3666 8.12512 12.1571 7.91566C11.9476 7.70619 11.9476 7.36657 12.1571 7.1571Z" fill="#fe8a0f"/>
								</g>
								<g opacity="0.5">
									<path d="M17.1571 10.1571C17.3666 9.94763 17.7062 9.94763 17.9157 10.1571C18.1251 10.3666 18.1251 10.7062 17.9157 10.9157C17.7062 11.1251 17.3666 11.1251 17.1571 10.9157C16.9476 10.7062 16.9476 10.3666 17.1571 10.1571Z" fill="#fe8a0f"/>
								</g>
								<path opacity="0.5" d="M19.058 15.3134C19.2674 15.1039 19.6071 15.1039 19.8165 15.3134C20.026 15.5228 20.026 15.8624 19.8165 16.0719C19.6071 16.2814 19.2674 16.2814 19.058 16.0719C18.8485 15.8624 18.8485 15.5228 19.058 15.3134Z" fill="#fe8a0f"/>
								<path d="M19.1725 10.328L18.6871 10.4481L18.7596 10.7409L19.0523 10.8134L19.1725 10.328ZM21.0005 8.5L20.5005 8.49866C20.5001 8.63174 20.5528 8.75946 20.6469 8.85355C20.741 8.94765 20.8688 9.00035 21.0018 9L21.0005 8.5ZM19.1725 10.328C19.6578 10.2079 19.6579 10.208 19.6579 10.2081C19.6579 10.2081 19.6579 10.2081 19.6579 10.2082C19.6579 10.2083 19.6579 10.2083 19.6579 10.2083C19.6579 10.2083 19.6579 10.2082 19.6579 10.208C19.6578 10.2076 19.6576 10.2068 19.6572 10.2055C19.6566 10.2028 19.6556 10.1985 19.6542 10.1924C19.6513 10.1803 19.6471 10.1616 19.6417 10.1369C19.631 10.0876 19.616 10.0151 19.5999 9.92546C19.5675 9.74514 19.5314 9.50098 19.5147 9.2406C19.4979 8.97721 19.5022 8.71525 19.5417 8.49306C19.5825 8.26343 19.6511 8.13217 19.7153 8.06792L19.0082 7.36081C18.7373 7.63169 18.6146 7.9947 18.5571 8.31797C18.4983 8.64867 18.4972 8.99823 18.5168 9.30448C18.5366 9.61372 18.5788 9.89729 18.6157 10.1023C18.6342 10.2054 18.6516 10.2899 18.6645 10.3495C18.671 10.3793 18.6764 10.4029 18.6803 10.4196C18.6823 10.428 18.6838 10.4346 18.685 10.4394C18.6856 10.4418 18.686 10.4437 18.6864 10.4452C18.6866 10.4459 18.6867 10.4465 18.6868 10.447C18.6869 10.4473 18.687 10.4475 18.687 10.4477C18.687 10.4478 18.6871 10.4479 18.6871 10.4479C18.6871 10.448 18.6871 10.4481 19.1725 10.328ZM19.7153 8.06792C19.9581 7.82516 20.15 7.84372 20.2388 7.88469C20.3352 7.92922 20.5016 8.08886 20.5005 8.49866L21.5005 8.50134C21.5023 7.81729 21.2043 7.22917 20.6581 6.97686C20.1042 6.72101 19.4753 6.89367 19.0082 7.36081L19.7153 8.06792ZM19.1725 10.328C19.0523 10.8134 19.0525 10.8134 19.0526 10.8134C19.0526 10.8134 19.0527 10.8135 19.0528 10.8135C19.053 10.8135 19.0532 10.8136 19.0535 10.8136C19.054 10.8138 19.0546 10.8139 19.0553 10.8141C19.0568 10.8145 19.0587 10.8149 19.0611 10.8155C19.0659 10.8166 19.0725 10.8182 19.0809 10.8202C19.0975 10.8241 19.1212 10.8295 19.151 10.8359C19.2106 10.8489 19.2951 10.8663 19.3982 10.8848C19.6032 10.9217 19.8868 10.9639 20.196 10.9837C20.5023 11.0033 20.8518 11.0022 21.1825 10.9434C21.5058 10.8859 21.8688 10.7632 22.1397 10.4923L21.4326 9.78518C21.3683 9.84944 21.2371 9.91797 21.0074 9.9588C20.7852 9.99832 20.5233 10.0026 20.2599 9.98575C19.9995 9.96908 19.7553 9.93298 19.575 9.90058C19.4854 9.88447 19.4129 9.86952 19.3636 9.85879C19.3389 9.85344 19.3202 9.84915 19.3081 9.84633C19.302 9.84492 19.2976 9.84387 19.295 9.84324C19.2937 9.84293 19.2929 9.84272 19.2925 9.84262C19.2923 9.84257 19.2922 9.84255 19.2922 9.84255C19.2922 9.84256 19.2922 9.84257 19.2923 9.84258C19.2923 9.84259 19.2924 9.84261 19.2924 9.84262C19.2925 9.84264 19.2926 9.84266 19.1725 10.328ZM22.1397 10.4923C22.6068 10.0251 22.7795 9.3963 22.5236 8.84239C22.2713 8.29616 21.6832 7.99817 20.9992 8L21.0018 9C21.4116 8.9989 21.5713 9.16534 21.6158 9.26173C21.6568 9.35044 21.6753 9.54242 21.4326 9.78518L22.1397 10.4923Z" fill="#fe8a0f"/>
								<path opacity="0.5" d="M15.1881 3.41748L15.1605 3.51459C15.1302 3.62126 15.1151 3.67459 15.1222 3.72695C15.1294 3.77931 15.1581 3.82476 15.2154 3.91567L15.2677 3.99844C15.4695 4.31836 15.5704 4.47831 15.5017 4.60915C15.4329 4.73998 15.24 4.75504 14.8542 4.78517L14.7543 4.79296C14.6447 4.80152 14.5899 4.8058 14.542 4.83099C14.494 4.85618 14.4584 4.89943 14.3872 4.98592L14.3224 5.06467C14.0718 5.36905 13.9465 5.52124 13.8035 5.50167C13.6606 5.4821 13.5947 5.30373 13.4629 4.94699L13.4288 4.85469C13.3914 4.75332 13.3726 4.70263 13.3358 4.66584C13.2991 4.62905 13.2484 4.61033 13.147 4.57287L13.0547 4.53878C12.698 4.40698 12.5196 4.34108 12.5 4.19815C12.4805 4.05522 12.6326 3.92992 12.937 3.67932L13.0158 3.61448C13.1023 3.54327 13.1455 3.50767 13.1707 3.45974C13.1959 3.41181 13.2002 3.35699 13.2087 3.24735L13.2165 3.14753C13.2466 2.76169 13.2617 2.56877 13.3925 2.50001C13.5234 2.43124 13.6833 2.53217 14.0033 2.73403L14.086 2.78626C14.1769 2.84362 14.2224 2.8723 14.2747 2.87947C14.3271 2.88664 14.3804 2.87148 14.4871 2.84117L14.5842 2.81358C14.9596 2.70692 15.1472 2.65359 15.2477 2.75402C15.3481 2.85445 15.2948 3.04213 15.1881 3.41748Z" stroke="#fe8a0f"/>
							</svg>
							<p id="discountMsg"></p>
						</div>
						<div class="summary-box">
							<div class="summary-box-heding">
								<h4>summary</h4>
								<div>
									<span id="original_price">
										<?php echo '£'.number_format($totalPrice,2); ?>
									</span>
									<span id='discounted_price' style="display:none"></span>
								</div>
							</div>

							<div class="summary-feature-article">
								<a href="<?php echo base_url().'service/'.$service_details['slug']?>">
									<?php $image_path = FCPATH . 'img/services/' . ($service_details['image'] ?? ''); ?>
	            					<?php if (file_exists($image_path) && $service_details['image']): ?>
	            						<img src="<?php echo base_url('img/services/') . $service_details['image']; ?>" class="img-responsive">
	            					<?php else: ?>	
										<img src="<?php echo base_url('img/default-image.jpg'); ?>" class="img-responsive">
	            					<?php endif; ?>
									
									<span>
										<h4 style="margin-top:0px;"><b><?php echo $service_details['service_name']; ?></b></h4>
                                    	<p class="text-muted"><?php echo $package_description; ?></p>
									</span>
								</a>
							</div>
							<ul>
								<li>
									<p>Unit price (per <?php echo lcfirst($service_details['price_per_type']); ?>)</p> 
									<b><?php echo '£'.number_format($package_price,2); ?></b>
								</li>
								<li>
									<p>No. of <?php echo lcfirst($service_details['price_per_type']); ?></p> 
									<b><?php echo $serviceQty; ?></b>
								</li>
								<?php if(!empty($ex_services) && count($ex_services) > 0): ?>
									<li>
										<b>Extra Services</b> 
									</li>
									<?php foreach($ex_services as $exs):?>
										<li>
											<p><?php echo $exs['ex_service_name']; ?></p> 
											<b><?php echo '£'.number_format($exs['price'],2); ?></b>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
								<li>
									<p>Service fee <i class="fa fa-question-circle" aria-hidden="true"></i></p> 
									<b>
										<span id="serviceFee"><?php echo '£'.number_format($service_fee,2)?></span>
									</b>
								</li>
								<li><p>Discount</p><b id="discountVal">-</b></li>
								<li><b>Promo codes</b></li>
								<li id="promoCodeLi">
									<input class="form-control input-lg" name="promo_code" id="promo_code" type="text" placeholder="Enter code">
									<button type="button" id="codeApply" class="btn">APPLY</button>
									<button type="button" id="codeRemove" class="btn hide">Remove</button>
								</li>
									
								<li>
									<p>Total</p>
									<?php 
										$mainTotalPrice = $totalPrice + $service_fee;
									?>
									<b id="totalPrice">
										<?php echo '£'.number_format($mainTotalPrice,2); ?>
									</b>	
								</li>
								<?php if(!empty($delivery_date)): ?>
								<li style="font-size:14px;">
									<p>Delivered By</p>
									<b style="color:#4B8024">
										<?php echo $delivery_date; ?>
									</b>	
								</li>
								<?php endif; ?>
							</ul>
							
							<input type="hidden" name="pay_intent" id="pay_intent">
 
							<div class="form-group" style="margin-top:15px;">
								<div class="row">
									<div class="col-sm-12 text-center">										
										<button class="btn btn-warning btn-lg" type="button" id="checkoutBtn">
												Checkout											
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="stripe-payment-success-3ds" role="dialog" aria-labelledby="stripe-payment-success-3ds" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="payment-process-content loader-spinner">Loading...</div>
                <h3 class="payment-process-content">Please wait! while we verify your payment.</h3>
            </div>
        </div>
    </div>
</div>

<?php
  	require_once('application/libraries/stripe-php-7.49.0/init.php');
?>
<script src="https://js.stripe.com/v3/"></script>
<script>
	$(document).ready(function() {
	    $('input[type=radio][name=payment_method]').change(function() {
	        if (this.value == 'card') {
	            $('#card-detail').show();            
	        }
	        else{
	            $('#card-detail').hide();            
	        }
	    });

	    $('#codeApply').on('click', function(){
			var promo_code= $('#promo_code').val();
			$.ajax({
		        url: "<?= site_url().'checkout/checkPromoCode'; ?>", 
		        type: "POST", 
		        data: {"promo_code":promo_code},
		        dataType: 'json',
		        success: function (data) {
		        	if(data.status == 1){
		        		swal({
				            title: "Promo Code Applied",
				            text: data.message,
				            type: "success"
				        }, function() {
				        	$('#discountVal').text('£'+data.discount);
		        			$('#totalPrice').text('£'+data.discounted_amount);
				            $('#promo_code').prop('readonly', true);
				            $('#codeApply').addClass('hide');
				            $('#codeRemove').removeClass('hide');			            
				        });	        		
		        	}else{
		        		swal({
				            title: "Error",
				            text: "Invalid Promocode",
				            type: "error"
				        }, function() {
				            $('#promo_code').val('');
				            $('#discountVal').text('-');
		        			$('#totalPrice').text('<?php echo '£'.number_format($mainTotalPrice,2); ?>');
				        });
		        	}            
		        },
		        error:function(e){
		            swal({
			            title: "Error",
			            text: "Somethig is wrong. Try again!!!",
			            type: "error"
			        }, function() {
			            $('#promo_code').val('');
			        });
		        }
		    }); 
		});

		$('#codeRemove').on('click', function(){
			swal({
	            title: "Confirm?",
	            text: "Are you sure you want to remove this promo code?",
	            type: "warning",
	            showCancelButton: true,
		        confirmButtonText: 'Yes',
		        cancelButtonText: 'Cancel'
	        }, function() {
	            $('#promo_code').val('');
	            $('#discountVal').text('-');
				$('#totalPrice').text('<?php echo '£'.number_format($mainTotalPrice,2); ?>');
				$('#promo_code').prop('readonly', false);
	            $('#codeApply').removeClass('hide');
	            $('#codeRemove').addClass('hide');
	        });
		});

		$('#checkoutBtn').on('click', function(){
			$('#checkoutBtn').disabled = true;
	        var pMethod = $('input[name="payment_method"]:checked').val();
	        
	        if(pMethod != undefined){
	        	$('#formErrors').text('').parent('div').removeClass('alert alert-danger');
	        	$('#formErrors').closest('.col-sm-12').removeClass('mb-4');
	            $('#formErrors').fadeOut();

	        	swal({
		            title: "Confirm Order",
		            text: "Are you sure you want to place this order?",
		            type: "warning",
		            showCancelButton: true,
			        confirmButtonText: 'Place Order',
			        cancelButtonText: 'Cancel'
		        }, function() {
		    		if (pMethod == 'wallet') {
		    			var promo_code = $('#promo_code').val();
			           	$('#loader').removeClass('hide');

		    			$.ajax({
			                url: '<?= site_url().'checkout/placeOrder'; ?>',
			                type: 'POST',
			                data: {'payment_method':pMethod, 'promo_code':promo_code},
			                dataType: 'json',		                
			                success: function(result) {
			                	$('#loader').addClass('hide');
			                	if(result.status == 0){
			                		swal({
						            	title: "Error",
							            text: result.message,
							            type: "error"
							        });	
			                	}else if(result.status == 2){
			                		swal({
							            title: "Login Required!",
							            text: "If you want to order the please login first!",
							            type: "warning"
							        }, function() {
							            window.location.href = '<?php echo base_url().'login'; ?>';
							        });	
			                	}else{
									swal({
							            title: "Success",
							            text: result.message,
							            type: "success"
							        }, function() {
							        	window.location.href = '<?php echo base_url(""); ?>';
							        });
			                	}		                    
			                },
			                error: function(xhr, status, error) {
			                    // Handle error
			                }
			            });
			        }
			        else{
			        	if(pMethod == 'card'){
			        		payWithStripe();
			        	}else{
			        		payWithOldCard();
			        	}			        	
			        } 	
		        });
	        }else{
	    		$('#formErrors').text('Please select payment method').parent('div').addClass('alert alert-danger');
	    		$('#formErrors').closest('.col-sm-12').addClass('mb-4');
	            $('#formErrors').fadeIn();
	            return false;
	    	}
		});

		/*Strope Code Start*/

		var stripePublishableKey = '<?php echo $this->config->item('stripe_key');?>';
	    var stripe = Stripe(stripePublishableKey);
	    var elements = stripe.elements();
	    var style = {
	        base: {
	            color: "#000000",
	            fontSize: '18px',		   
	            "::placeholder": {
	                color: "#aab7c4"
	            }
	        },
	        invalid: {
	            color: "#fa755a",
	            iconColor: "#fa755a"
	        },
	    };

	    var cardNumber = elements.create('cardNumber', {
	        style: style,
	        showIcon: true,
	        iconStyle : 'solid',
	        placeholder : 'Ex. 0000 0000 0000 0000'
	    });
	    cardNumber.mount('#card-number-element');

	    var cardExpiry = elements.create('cardExpiry', {
	        style: style
	    });
	    cardExpiry.mount('#card-expiry-element');

	    var cardCvc = elements.create('cardCvc', {
	        style: style
	    });
	    cardCvc.mount('#card-cvc-element');

	    var postalCode = elements.create('postalCode', {
	        style: style
	    });
	    postalCode.mount('#postal-code-element');

	    // Handle real-time validation errors from the card Elements.
	    [cardNumber, cardExpiry, cardCvc, postalCode].forEach(function(element) {
	       element.on('change', function(event) {
	            if (event.error) {
	                $('#StripePaymentErrors').text(event.error.message).parent('div').addClass('alert alert-danger');
	                $('#StripePaymentErrors').fadeIn();
	            } else {
	                $('#StripePaymentErrors').text('').parent('div').removeClass('alert alert-danger');
	                $('#StripePaymentErrors').fadeOut();
	            }
	        });
	    });

	    async function payWithStripe() {
	        $('#loader').removeClass('hide');

	        // console.log(cardNumber);

	        var {token, error} = await stripe.createToken(cardNumber);

	        if (error) {
	            $('#loader').addClass('hide');
	            var code = error.code ? error.code : '';
	            var message = error.message ? error.message : '';
	            if(code && message){
	                $('#StripePaymentErrors').text(message);
	                $('#StripePaymentErrors').fadeIn();
	                $('.error-card').text('');
	                $('.'+code).text(message);
	            }
	            return;
	        }

	        stripe.createPaymentMethod({
	            type: 'card',
	            card: cardNumber,
	        }).then(stripePaymentMethodHandler);
	    }

	    function payWithOldCard() {
	    	var intentId = $('input[name="payment_method"]:checked').val();
	        var saveCard = $('#Save_Card').is(':checked');
	        var promo_code = $('#promo_code').val();
	        var price = $('#totalPrice').text().trim();
            var mainPrice = price.replace("£", "");

            var dataObj = {
                payment_method: 'card',
                payment_method_id: intentId,
                promo_code: promo_code,
                saveCard: saveCard,
                mainPrice: mainPrice,
            };

            $("#stripe-payment-success-3ds").modal('show');

	        $.ajax({
	            url: '<?= site_url().'checkout/placeOrderWithStripe'; ?>',
	            type: 'POST',
	            dataType: 'json',
	            data: dataObj,
	            success: function(result) {
	                handleServerResponse(result);
	            },
	            error: function(xhr, status, error) {
	            	console.log(xhr);
	            	console.log(status);
	            	console.log(error);
	                // Handle error
	            }
	        });
	    }

	    function stripePaymentMethodHandler(result) {
	        $('#loader').addClass('hide');
	        if (result.error) {
	            // Show error in payment form
	            $('#StripePaymentErrors').text(result.error.message);
	            $('#StripePaymentErrors').fadeIn();
	            $("#stripe-payment-success-3ds").modal('hide');
	        } else {
	            $("#stripe-payment-success-3ds").modal('show');
	            var promo_code = $('#promo_code').val();
	            var saveCard = $('#Save_Card').is(':checked');
	            
	            var dataObj = {
	                payment_method_id: result.paymentMethod.id,
	                promo_code: promo_code,
	                saveCard: saveCard,
	            };

	            var pMethod = $('input[name="payment_method"]:checked').val();
	            var price = $('#totalPrice').text().trim();
	            var mainPrice = price.replace("£", "");

	            var dataObj = {
	                payment_method_id: result.paymentMethod.id,
	                payment_method: pMethod,
	                promo_code: promo_code,
	                saveCard: saveCard,
	                mainPrice: mainPrice,
	            };

	            $.ajax({
	                url: '<?= site_url().'checkout/placeOrderWithStripe'; ?>',
	                type: 'POST',
	                data: dataObj,
	                dataType: 'json',                
	                success: function(result) {
	                	if(result.status == 2){
	                		swal({
					            title: "Login Required!",
					            text: "If you want to order the please login first!",
					            type: "warning"
					        }, function() {
					            window.location.href = '<?php echo base_url().'login'; ?>';
					        });	
	                	}else{
	                		handleServerResponse(result);	
	                	}
	                },
	                error: function(xhr, status, error) {
	                    // Handle error
	                }
	            });
	        }
	    }

	    function handleServerResponse(response) {
	    	if (response.error) {
	            $("#stripe-payment-success-3ds").modal('hide');
	            swal("Error", response.error, "error");
	            $("#pay_intent").val('');
	            // Show error from server on payment form
	        } else if (response.requires_action) {
	            stripe.confirmCardPayment(
	                response.payment_intent_client_secret
	            ).then(handleStripeJsResult);
	        } else {
	            // Show success message
	            $("#stripe-payment-success-3ds").modal('show');
	            payment_intent_ID = response.intent;
	            $("#pay_intent").val(payment_intent_ID);
	            $("#stripe-payment-success-3ds").modal('hide');
	            submitForm();
	        }
	    }

	    function handleStripeJsResult(result) {
	        //console.log(result);
	        if (result.error) {
	            $("#stripe-payment-success-3ds").modal('hide');
	            swal("Error", result.error.message, "error");
	        } else {
	        	payment_intent_ID = result.paymentIntent.id;
		        var pMethod = $('input[name="payment_method"]:checked').val();
		        var promo_code = $('#promo_code').val();
	            var price = $('#totalPrice').text().trim();
	            var mainPrice = price.replace("£", "");
	            var saveCard = $('#Save_Card').is(':checked');

	            var dataObj = {
	                payment_intent_id: result.paymentIntent.id,
	                payment_method: pMethod,
	                promo_code: promo_code,
	                saveCard: saveCard,
	                mainPrice: mainPrice,
	            };

	            $.ajax({
	                url: '<?= site_url().'checkout/placeOrderWithStripe'; ?>',
	                type: 'POST',
	                dataType: 'json',
	                data: dataObj,
	                success: function(confirmResult) {
	                    handleServerResponse(confirmResult);
	                },
	                error: function(xhr, status, error) {
	                    // Handle the error if needed
	                    console.error('AJAX request failed:', status, error);
	                }
	            });
	        }
	    }

	    function submitForm(){
	    	$('#loader').removeClass('hide');
	        formData = $("#checkoutForm").serialize();

	        $.ajax({
	            url: '<?= site_url().'checkout/placeOrder'; ?>',
	            type: 'POST',
	            data: formData,
	            dataType: 'json',		                
	            success: function(result) {
	            	$('#loader').addClass('hide');
	            	if(result.status == 0){
	            		swal({
			            	title: "Error",
				            text: result.message,
				            type: "error"
				        });	
	            	}else if(result.status == 2){
	            		swal({
				            title: "Login Required!",
				            text: "If you want to order the please login first!",
				            type: "warning"
				        }, function() {
				            window.location.href = '<?php echo base_url().'login'; ?>';
				        });	
	            	}else{
						swal({
				            title: "Success",
				            text: result.message,
				            type: "success"
				        }, function() {
				        	window.location.href = '<?php echo base_url(""); ?>';
				        });
	            	}		                    
	            },
	            error: function(xhr, status, error) {
	                // Handle error
	            }
	        });
	    }

		/*Strope Code End*/
	});



</script>
<?php include ("include/footer.php") ?>