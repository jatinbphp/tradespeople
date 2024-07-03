<?php include ("include/header.php") ?>
<style>
  .contact-submit-btn .btn {
    margin-top: 15px;
  }
 .Mailing12 p span {
	font-family: "treB";
	margin-bottom: 5px;
	display: inline-block;
	width: 100%;
	font-size: 18px;
}
.white-start .sing-body p {
	margin-bottom: 25px;
	font-size: 16px;
}
</style>

<!-- how-it-work -->
<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="white-start">
					<div class="sing-top">
						<h1> 
						Help centre</h1>
					</div>
					
				<div class="sing-body Mailing12 ">
					
					<p>
						<span>Opening Time</span><br> Hours of Operations Monday to Friday 9:00 am to 5:00 pm
					</p>
					<p>
						<span>I´m a tradesperson</span><br> Visit our tradesmen <a href="<?php echo base_url('tradesman-help'); ?>" target="Blank">help centre</a> for answers to most of your questions. If a solution is not listed, please send us a message.

					</p>
					<p>
						<span>I´m a homeowner</span><br> 

						If you’re a homeowner, visit our <a href="<?php echo base_url('homeowner-help-centre'); ?>" target="Blank">help centre </a> for answers to most common questions. If a solution is not found there, please don´t hesitate to contact us.


					</p>
				</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="white-start">
					<div class="sing-top">
						<h1> 
						Contact us </h1>
					</div>
					  <form  method="post" name="submit_form" id="submit_form" enctype="multipart/form-data">
					<div class="sing-body">
						<div  id="slSuccess"></div>  
						<div class="row">
								<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-md-12 control-label"> Select Type </label>  
						  <div class="col-md-12">
						  	<select required="" class="form-control input-lg" name="type" id="type">
						  		<option value="">Select Type</option>
						  		<option value="1">Tradesman</option>
						  		<option value="2">Homeowner</option>
						  	</select>
						
						  </div>
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-md-12 control-label"> First name </label>  
						  <div class="col-md-12">
						  <input type="text" class="form-control input-lg" name="first_name" id="first_name" required="">	
						  </div>
						</div>
						</div>
						
						
						<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-md-12 control-label"> Last name </label>  
						  <div class="col-md-12">
						  <input type="text" class="form-control input-lg" name="last_name" id="last_name" required="">	
						  </div>
						</div>
						</div>
						<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-md-12 control-label"> Email </label>  
						  <div class="col-md-12">
						  <input type="email" class="form-control input-lg" name="email" id="email" required="">	
						  </div>
						</div>
						</div>
				

						</div>
	<div class="form-group">
						  <label class="col-md-12 control-label"> Phone </label>  
						  <div class="col-md-12">
						  <input type="number" class="form-control input-lg" name="phone_no" id="phone_no" required="">	
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-12 control-label">Message </label>  
						  <div class="col-md-12"><textarea  class="form-control input-lg" rows="5" name="message" id="message" required=""></textarea></div>
						</div>
						
						
            <div class="term-acc">
              <p class="text-center">I have read and understood the <a href="<?php echo base_url('privacy-policy'); ?>">privacy notice</a> and <a href="<?php echo base_url('cookie-policy'); ?>">cookie policy</a>, and I agree to the <a href="<?php echo base_url('terms-and-conditions'); ?>">terms and conditions.</a></p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                  <div class="g-recaptcha" data-type="image" data-sitekey="6Lfvi7IZAAAAABKCAhUwDjsYtsrJOHh4c52W34PB" required="required">
                  </div>
                  <p id="captchmsg" ></p>
                </div>
                <div class="start-btn text-center col-sm-6 contact-submit-btn"> <button class="btn btn-warning btn-lg sendbtn1" type="submit" id="" >Submit</button>
              </div>
						</div>
					</div>
				</form>
				</div>
			</div>
			
		</div>
				</div>
	</div>
<script>

$("#submit_form").submit(function (event) {
    event.preventDefault();
    $.ajax({
        url: "<?php echo site_url('home/contact_request') ?>",
        type: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $('.sendbtn1').prop('disabled', true);
            $('.sendbtn1').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
             $("#captchmsg").hide();
        },
        success: function (resp) {


            $('.sendbtn1').prop('disabled', false);
            $('.sendbtn1').html(resp.button);
            if (resp.status == 1) {
                $("#slSuccess").html(resp.msg);
                $("#submit_form").trigger('reset');
                $("#captchmsg").html('');
                grecaptcha.reset();
            } else if(resp.status == 2){
            	$("#captchmsg").show();
            	$("#captchmsg").html(resp.msg);
            }
            else {
                $("#slSuccess").html(resp.msg);

            }


        }

    });


});
            
    </script>  
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
 <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDa0tOAIUG6K8mL9wulFR2dzm6PSviZyXg&libraries=places&callback=initAutocomplete" async defer></script>