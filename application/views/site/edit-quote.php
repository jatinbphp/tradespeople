<?php include ("include/header.php") ?>
<?php include ("include/top.php");  ?>
<style type="text/css">
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}

.pagination{
	margin:0px !important;
}
.job-description-detail p{
  white-space: pre-line;
}

</style>
<?php  
$get_commision=$this->common_model->get_commision(); 

$bank_Pay_info = '';
$strip_Pay_info = '';
$paypal_Pay_info = '';

$paypal_comm_per = $get_commision[0]['paypal_comm_per'];
$paypal_comm_fix = $get_commision[0]['paypal_comm_fix'];

$stripe_comm_per = $get_commision[0]['stripe_comm_per'];
$stripe_comm_fix = $get_commision[0]['stripe_comm_fix'];
$bank_processing_fee = $get_commision[0]['processing_fee'];

if($this->session->userdata('type')==2){
	$strip_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Strip charges ('.$stripe_comm_per.'%+'.$stripe_comm_fix.') processing fee and processes your payment immediately ." data-original-title="" class="red-tooltip toll stripe-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$paypal_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Paypal charges ('.$paypal_comm_per.'%+'.$paypal_comm_fix.') processing fee and processes your payment immediately." data-original-title="" class="red-tooltip toll paypal-tooltip"><i class="fa fa-info-circle"></i></a>';
	
	
	$bank_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="We charge '.$bank_processing_fee.'% processing fee and process your payment within 1-2 working days." data-original-title="" class="red-tooltip toll bank-tooltip"><i class="fa fa-info-circle"></i></a>';
}

$closed_date=$get_commision[0]['closed_date'];
$datesss= date('Y-m-d H:i:s', strtotime($project_details['c_date']. ' + '.$closed_date.' days')); ?>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				
        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
        <div class="msg1"><?= $this->session->flashdata('msg1'); ?></div>
				
				<?php if($this->session->flashdata('error1')) { ?>
          
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
				
				<?php } if($success1 = $this->session->flashdata('success1')) { ?>
          
					<p class="alert alert-success"><?php echo $success1; ?></p>
          
				<?php } ?>
          
				<?php if($this->session->flashdata('error2')) { ?>
         
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error2'); ?></p>
          
				<?php } if($this->session->flashdata('success2')) { ?>
         
					<p class="alert alert-success"><?php echo $this->session->flashdata('success2'); ?></p>
				
				<?php } ?>
    
				<?php 
				if($this->session->userdata('user_id')){ 
					if($this->session->userdata('type')==2){ 
					$get_post_bid=$this->common_model->get_post_bids('tbl_jobpost_bids',$_REQUEST['post_id'],$this->session->userdata('user_id')); 
					} 
				}
				if($this->session->userdata('type')==1){
 
					$datesss= date('Y-m-d H:i:s', strtotime($project_details['c_date']. ' + '.$closed_date.' days'));
					if(date('Y-m-d H:i:s')>=$datesss) {
				?>
				<!-- <div class="verify-page">
					<div style="background-color:#fff;padding: 20px;">
						<h3>Project has been closed</h3>
						<p>You can not place quote as this project has been closed.<a href="<?php echo base_url('dashboard'); ?>">Click here</a> to quote other project.</p>
					</div>
				</div> -->

				<?php  } else if((count($get_post_bid)>0 && $get_post_bid[0]['status']==0) && ($project_details['status']!=4 && $project_details['status']!=7 && $project_details['status']!=5) && (date('Y-m-d H:i:s')<$datesss)){ 
				
					$get_bid_user=$this->common_model->get_single_data('users',array('id'=>$get_post_bid[0]['bid_by']));
					
					$get_user_suggest = $this->common_model->get_all_data('tbl_milestones',array('bid_id'=>$get_post_bid[0]['id']));
					?>
				<form method="post" id="update_bid" enctype="multipart/form-data"  onsubmit="return update_bid(<?php echo $get_post_bid[0]['id']; ?>);">

					<div class="dashboard-white" id="bids">
						<div class="dashboard-profile dhash-news">
							<h3>Edit your quote on this job <i data-toggle="tooltip" title="You will be able to edit your quote until the job is awarded to someone." class="fa fa-info-circle" style="color:#3D78CB; vertical-align: top; margin-top: -5px;"></i></h3>
						</div>

						<div class="dhash-news-main">
							
				
								<div class="row">
									<div class="col-sm-6">
										<div class="from-group">
											<p><b>Quote Amount</b></p>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
												<input class="form-control" placeholder="4" type="number" name="bid_amount" min="1" value="<?php echo $get_post_bid[0]['bid_amount']; ?>" required=""><span class="input-group-addon" >GBP</span>
											</div>
									 </div>
									</div>
									<div class="col-sm-6">
										 <div class="from-group">
											 <p><b>This job will be finished in</b></p>
												<div class="input-group">
													 <input class="form-control" placeholder="7" type="number" name="delivery_days" required="" value="<?php echo $get_post_bid[0]['delivery_days']; ?>"> 
													 <span class="input-group-addon">Days</span>
												</div>
										 </div>
									</div>
								</div>

								<div class="from-group">
									<p><b>Describe your proposal</b></p>
									<textarea class="form-control pro-text textarea" placeholder="What make you the best candidate for this job ?" name="propose_description" required=""><?=$get_post_bid[0]['propose_description']; ?></textarea>
									<div class="contact-detected" style="margin-top:10px;"></div>
								</div>
								<hr>
								<p>
									 Suggest milestone payment break-down “<a href="#" data-toggle="tooltip" title="You can remove the milestone by clicking on Remove button.">optional</a>”! Click <a target="_blank" href="<?php echo site_url(); ?>tradesman-help#Payment-2">here</a> to learn more.
								</p>
		
									 
								<div class="input-append">
									<?php if(count($get_user_suggest) > 0) { ?>
									<?php foreach($get_user_suggest as $key => $row1) { ?>
									<div class="suggest_mile" id="field<?php echo $key; ?>">
										<div class="row">
											<div class="col-sm-6">
												<div class="from-group">
												 <input type="text" class="form-control miname_1" name="tsm_name[]" value="<?php echo $row1['milestone_name']; ?>" placeholder="Define the tasks that you will complete for this" required>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="from-group input-group">
													<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
													<input type="number" class="form-control miamount_1" min="1" value="<?php echo $row1['milestone_amount']; ?>" name="tsm_amount[]" required>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<button class="btn btn-danger" onclick="removeadd(1)" type="button">Remove</button>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
									<?php } ?>
								</div>
								<div class="from-group">
									<a href="javascript:void(0);" class="btn btn-primary add_more_btn" onclick="add_more_miles();">Add milestone </a>
								</div>
								<div class="from-group text-right">
									<button type="submit" class="btn btn-primary submit_btn13">Update Quote</button>
				 
								</div>      
							</div>
  
					</div>
 
        </form>
     
				<?php } else if($project_details['status']!=7 && $project_details['status']!=4 && $project_details['status']!=5 && strtotime($datesss) > strtotime(date())){ 
				
				if(count($get_post_bid)==0 || ($get_post_bid[0]['status']==8 && $get_post_bid[0]['hiring_type']==0)){  ?>

				<!-- <form method="post" id="post_bid" enctype="multipart/form-data"  onsubmit="return post_bid();">

					<div class="dashboard-white" id="bids">
						<div class="dashboard-profile dhash-news">
							<h3>Submit a quote for this job  <i data-toggle="tooltip" title="You will be able to edit your quote until the job is awarded to someone." class="fa fa-info-circle" style="color:#3D78CB; vertical-align: top; margin-top: -5px;"></i></h3>
						</div>

						<div class="dhash-news-main">
							
							<div class="row">
								<div class="col-sm-6">
									 <div class="from-group">
										 <p><b>Quote Amount</b></p>
											<div class="input-group">
												 <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
												 <input class="form-control" placeholder="Enter Your quote amount" type="number" name="bid_amount" min="1" required=""><span class="input-group-addon">GBP</span>
											</div>
									 </div>
								</div>
								<div class="col-sm-6">
									 <div class="from-group">
										 <p><b>This job will be finished in</b></p>
											<div class="input-group">
												 <input class="form-control" placeholder="This job will be finished in" type="number" min="1" name="delivery_days" required="">
													<input type="hidden" name="post_id" id="get_post_id" value="<?php echo $_REQUEST['post_id']; ?>">
													<input type="hidden" name="posted_by" value="<?php echo $project_details['userid']; ?>">
												 <span class="input-group-addon">Days</span>
											</div>
									 </div>
								</div>
							</div>

							<div class="from-group">
								<p><b>Describe your proposal</b></p>
								<textarea class="form-control pro-text textarea" placeholder="What make you the best candidate for this job ?" name="propose_description" required=""></textarea>
							</div>
							<hr>
							<p>
								 Suggest milestone payment break-down “<a href="#" data-toggle="tooltip" title="You can remove the milestone by clicking on Remove button.">optional</a>”! Click <a target="_blank" href="<?php echo site_url(); ?>tradesman-help#Payment-2">here</a> to learn more.
							</p> <br>
  
								 
							<div class="input-append milestoneSuggestion">
							</div>
							<div class="from-group">
								<a href="javascript:void(0);" class="btn btn-primary add_more_btn" onclick="add_more_miles();">Add milestone </a>
							</div>
							<div class="from-group text-right">
								<button type="submit" class="btn btn-primary submit_btn13">Submit Quote</button>
 
							</div>      
						</div>
						<input type="hidden" name="option" id="option" value="">
					

					</div>
 
				</form> -->
				
				<!-- <div class="modal fade" id="viewaccount" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Choose Type</h4>
							</div>
							<div class="modal-body">
								<div class="msgs insufficient-msg"></div>
								<div class="row">
							
									<div class="col-sm-6 plan_bid">
										<?php  
										$credit_amount=$get_commision[0]['credit_amount']; 
										?>
										<!--p>If you for <b>Pay as you go</b> option, then for every quote £<?php // echo $credit_amount; ?> will be deducted from your wallet.</p-->
										<p>To add credits on your wallet click on pay as you button.</p>
										<button class="btn btn-warning pay-as-you-go-btn" onclick="get_option();">Pay as you go</button>
									
									
									</div>
									<div class="col-sm-6 plan_bid">
										<p>To become an active member click on monthly subscription button</p>
										<a href="<?php echo site_url().'membership-plans'; ?>" class="btn btn-primary " style="position: absolute;bottom: 0;" >Monthly Subscription</a>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center instant-payment-button common_pay_main_div" style="display:none;">
										<p>Click on pay now button to add amount in you wallet.</p>
										<div class="form-group">
											<label>Enter Amount</label>
											<input type="number" class="form-control" value="<?php echo $get_commision[0]['p_min_d']; ?>" onkeyup="check_value(this.value);" id="amount">
										</div>
										
										<p class="instant-err alert alert-danger" style="display:none;"></p>
										
										<div class="card pay_btns all-pay-tooltip">
											<div class="col-sm-2"  style="padding: 0;"></div>
											<div class="col-sm-4" style="padding: 0;">
												<div class="bonnnttlllo4">
													<div class="pay_btn strip_btn" id="strip_btn"><img src="<?= base_url(); ?>img/pay_with.png"></div>  <?= $strip_Pay_info; ?>
												</div>
												
											</div>
											<div class="col-sm-4"  style="padding: 0;">
												<div class="bonnnttlllo4">
													<div class="pay_btn paypal_btn" id="paypal_btn"></div>  <?= $paypal_Pay_info; ?>
												<input type="hidden" id="payProcess" value="0">
												</div>
											</div>
											<?php /*if($this->session->userdata('type')==2){ ?>
											<div class="col-sm-4"  style="padding: 0;">
												<div class="bonnnttlllo4 bonnnttlllo5">
													<a href="../wallet?bank-transfer=1" class="btn btn-primary">Bank Transfer</a>  <?= $bank_Pay_info; ?>
												</div>
											</div>
											<?php } */?>
										</div>
										
										<div class="common_pay_loader pay_btns_laoder text-center" style="display:none;"> 
											<i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
										</div>
										
										
									</div>
							
								</div>
							
							 
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
						
					</div>
				</div> -->
<script>
//var amounts = <?php echo $credit_amount; ?>;
var amounts = $('#amount').val();
//$('#post_bid').submit();
</script>	

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
check_value(<?php echo $get_commision[0]['p_min_d']; ?>);
function check_value(value){
  var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
	var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;
  if(value >= min_amount && value <= max_amount){
    //$('.show_btn').prop('disabled',false);
    $('.instant-err').hide();
    $('.instant-err').html('');
    
		var actual_amt = parseFloat(value);
		
		var stripe_comm_per = <?= $stripe_comm_per; ?>;
		var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
		var type = <?= $this->session->userdata('type'); ?>;
		var processing_fee = 0;
		var amounts = actual_amt;
		
		if(type == 2){
			if(stripe_comm_per > 0 || stripe_comm_fix == 0){
				processing_fee = (1 * actual_amt * stripe_comm_per)/100;
				amounts = actual_amt + processing_fee + stripe_comm_fix;
			}
		}
		
		amounts = amounts.toFixed(2);
		
		show_main_btn(value);
		
		$('#strip_btn').attr('onclick','show_lates_stripe_popup('+amounts+','+actual_amt+',3);');
    //amounts = value;
  } else {
    $('.card').hide();
    //$('.show_btn').prop('disabled',true);
    $('.instant-err').show();
    $('.instant-err').html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+min_amount+' and less than <i class="fa fa-gbp"></i>'+max_amount+'!');
    $('.pay_btns').hide();
  }
}

function show_main_btn(amounts){
		$('.pay_btns').show();
    $('.paypal_btn').html('');
		
		var actual_amt = parseFloat(amounts);
		
		var type = <?= $this->session->userdata('type'); ?>;
		var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
		var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
		var processing_fee = 0;
		var amounts = actual_amt;
		
		if(type == 2){
			if(paypal_comm_per > 0 || paypal_comm_fix > 0){
				processing_fee = ((actual_amt * paypal_comm_per)/100);
				var amounts = processing_fee+actual_amt+paypal_comm_fix;
			}
		}
			
		var amounts = amounts.toFixed(2);
		
    paypal.Button.render({
      env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
      client: {
        sandbox:    '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
        production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
      },

      // Show the buyer a 'Pay Now' button in the checkout flow
      commit: true,

      // payment() is called when the button is clicked
      payment: function(data, actions) {
				
				// Make a call to the REST api to create the payment
        return actions.payment.create({
          payment: {
            transactions: [
              {
                amount: { total: amounts, currency: 'GBP' }
              }
            ]
          }
        });
      },

      // onAuthorize() is called when the buyer approves the payment
      onAuthorize: function(data, actions) {  
        // Make a call to the REST api to execute the payment
        return actions.payment.execute().then(function() {
          console.log('Payment Complete!');
          $.ajax({
            type:'POST',
            url:site_url+'wallet/paypal_deposite',
            data:{
              itemPrice : $('#amount').val(),
              itemId : 'Deposit in wallet',
              orderID : data.orderID,
              txnID : data.paymentID,
            },
            dataType:'JSON',
            beforeSend:function(){
              $('.pay_btns').hide();
              $('.pay_btns_laoder').show();
            },
            success:function(resp){ 
              if(resp.status == 1) {
                //location.reload();
                //window.location.href=site_url+'Users/success/5/'+resp.tranId;
								$('#post_bid').submit();
								get_option();
              } else {
                $('.pay_btns').show();
                $('.pay_btns_laoder').hide();
                swal(resp.msg);
              }
            }
          });
        });
      }
    }, '#paypal_btn');

}

</script>
      <?php } } }?>
			</div>
			<div class="col-sm-4">
				<div class="dashboard-white edit-pro89"> 
					<div class=" dashboard-profile Locations_list11">
						<h2>About the Homeowner </h2>
					
                 
						<p><i class="fa fa-user"></i><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></p>
                 
						<?php if($project_details['city']) { ?>
						<p><i class="fa fa-map-marker"></i><?php echo $project_details['city']; ?><?php echo ($project_details['country']) ? ', '.$project_details['country'] : '';?> 
						<?php } ?>
							 
						</p>
						<p class="pd-icon"><i class="fa fa-user-circle-o"></i>
						<?php if($get_users['average_rate']){ ?>
						<span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?>
						</span>
						<?php } ?>
						
						<span class="star_r">
							<?php for($i=1;$i<=5;$i++){
							if($get_users['average_rate']) {
								if($i<=$get_users['average_rate']) { ?>  
								<i class="fa fa-star active"></i>
								<?php } else {  ?>
								<i class="fa fa-star"></i><?php 
								}
							} else { ?> 
							<i class="fa fa-star"></i>
							<?php } ?>
							<?php } ?>
						</span>
						</p>
						<p>
							<i class="fa fa-clock-o"></i>
							Member Since <?php $yrdata= strtotime($get_users['cdate']);
							echo date('M', $yrdata); ?>, <?php echo date('Y',$yrdata); ?>
						</p>
					</div>
        </div>
				
				<?php if(count($get_reviews)>0){ ?>
				<div class="dashboard-white edit-pro89" id="search_data"> 
					<div class=" dashboard-profile ">
						<h2>Recent reviews</h2>
							<div class="min_h3">
								<?php foreach ($get_reviews as $serialNumber => $r) {
                  $job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
                  $get_users22 = $this->common_model->GetColumnName('users',array('id'=>$r['rt_rateBy']),array('trading_name'));
								?>
						
								<div class="tradesman-feedback" <?=($serialNumber > 0) ? 'style="display:none;"' : ''; ?>  >
									<div class="set-gray-box">
										<div class="from-group revie">
											<span class="btn btn-warning btn-xs"><?php if($r['rt_rate']!=''){ echo $r['rt_rate']; } ?> </span>
                        <span class="star_r">
                          <?php 
                            for($i = 1; $i <= 5; $i++){
                              if($r['rt_rate']) {
                                if($i <= $r['rt_rate']) {
                          ?>
                                  <i class="fa fa-star active"></i>
                          <?php
                                } else{
                          ?>
                                  <i class="fa fa-star"></i>
                          <?php
                                }
                              } else  {
                          ?>
                                <i class="fa fa-star"></i>
                          <?php
                              }
                            }
                          ?>
                        </span>
										</div>
										<div cite="/job/view/5059288" class="summary">
											<?php
                        if(strlen(strip_tags($r['rt_comment'])) > 100){
                      ?>
                          <p class="short_review_<?=$serialNumber;?>"><?php echo substr(strip_tags($r['rt_comment']),0,100); ?>... 
                            <a onclick="$('.short_review_<?=$serialNumber;?>').hide(); $('.long_review_<?=$serialNumber;?>').show();" href="javascript:void(0);">read more</a>
                          </p>
                          <p class="long_review_<?=$serialNumber;?>" style="display:none;"><?php echo $r['rt_comment']; ?></p>
											<?php
                        } else {
                      ?>
                          <p class="long_review_<?=$serialNumber;?>"><?php echo $r['rt_comment']; ?></p>
											<?php } ?>
										</div>
										<p class="tradesman-feedback__meta">By <strong class="job-author"><?php echo $get_users22['trading_name']; ?></strong>&nbsp;on
                 
											<em class="job-date">
											<?php 	
											$time_ago = $this->common_model->time_ago($r['rt_create']); 
											?>
											<?=$time_ago;  ?>
											</em>
										</p>
									</div>
								</div>
						   <?php } ?>
							
							</div>
               
				
					</div>
        </div>
        <div id="ajax_link">
            <!--button type="button" class="btn btn-default btn-block" onclick="show_review('<?php //echo site_url('profile/' .$get_users['id']);?>');" > View more </button-->
						<?= $this->ajax_pagination->create_links(); ?>
        </div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="RejectPost" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reason</h4>
      </div>
      <form method="post" id="RejectReasonPost" onsubmit="return RejectReasonPosts();">
        <div class="modal-body">
          <div class="form-group">
            <label>Reason:</label>
            <textarea class="form-control" name="reject_mgs" required="" rows="5"></textarea>
          </div>
          <input type="hidden" name="post_ids" id="post_ids">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="rjiwi">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
      
  </div>
</div>

<?php include ("include/footer.php") ?>
<script>
  $(".milestoneSuggestion").hide();

  var next = 100000;
  function add_more_miles() {
    if(next == 100000){
      $(".milestoneSuggestion").show();
      $(".add_more_btn").text('Add another milestone');
    }
  next = next + 1;
  $(".input-append").append('<div class="suggest_mile" id="field'+next+'"><div class="row"><div class="col-sm-6""><div class="form-group"  style="margin-top:-10px;"><input type="text" class="form-control miname_1" name="tsm_name[]" placeholder="Define the tasks that you will complete for this" required></div></div><div class="col-sm-4"><div class="form-group input-group"  style="margin-top:-10px;"><span class="input-group-addon"><i class="fa fa-gbp"></i></span><input type="number" class="form-control miamount_1" min="1" name="tsm_amount[]" required></div></div><div class="col-sm-2"><div class="form-group"><button class="btn btn-danger" onclick="removeadd('+next+')" type="button" style="margin-top: -10px;">Remove</button></div></div></div></div>');

}

function removeadd(id) {
  $("#field"+id).remove();
}
function get_option()
{
  //$("#option").val('1');
	/*$('.pay-as-you-go-btn').prop('disabled',true);
	$('.pay-as-you-go-btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
	post_bid();*/
	
	$('.instant-payment-button').show();
}
function get_options()
{
    $("#option").val('2');
		post_bid();
}
function update_bid(post_id){
  $.ajax({
    type:'POST',
    url:site_url+'bids/update_bid/'+post_id,
    data:$('#update_bid').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.submit_btn13').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.submit_btn13').prop('disabled',true);
      $('.msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
        // $('.msg').html(resp.msg);
        // location.reload();
        window.location.href='<?php echo base_url('proposals?post_id='.$_GET['post_id']); ?>';
      }else if(resp.status==7){
      	//swal(resp.msg);
      	swal("", resp.msg, "error");
        //$('.contact-detected').html(resp.msg);
				$('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
      }else {
        $('.msg1').html(resp.msg);
        $('.submit_btn13').html('Update Quote');
        $('.submit_btn13').prop('disabled',false);
      }
    }
  });
  return false;
}

function post_bid(){
  var get_post=$('#get_post_id').val();
  $.ajax({
    type:'POST',
    url:site_url+'bids/apply_post',
    data:$('#post_bid').serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('.submit_btn13').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.submit_btn13').prop('disabled',true);
      $('.msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
        window.location.href = site_url+'proposals?post_id='+get_post;
          $('.msg').html(resp.msg);
      }
      else if(resp.status==2) 
      {
        $("#viewaccount").modal('show');
        $('.msgs').html(resp.msg);
				$('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
      }
      else if(resp.status==5)
      {
        var url = "<?php echo base_url('membership_plans'); ?>";
        window.location=url;
      }
      else if(resp.status==4) 
      {
        //$("#viewaccount").modal('hide');
				
        $('.insufficient-msg').html(resp.msg);
        $('.instant-payment-button').show();
        //$("#post_bid").trigger('reset');
        $('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
				
      }
      else if(resp.status==6) 
      {
        $("#viewaccount").modal('show');
				
        $('.insufficient-msg').html(resp.msg);
        $('.instant-payment-button').show();
        //$("#post_bid").trigger('reset');
        $('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
				
      }else if(resp.status==7){
      	//swal(resp.msg);
      	swal("", resp.msg, "Error");
        //$('.contact-detected').html(resp.msg);
				$('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
      }
      else 
      {
         $("#viewaccount").modal('hide');
        $('.msg1').html(resp.msg);
        $('.submit_btn13').html('Submit Quote');
        $('.submit_btn13').prop('disabled',false);
				
				$('.pay-as-you-go-btn').prop('disabled',false);
				$('.pay-as-you-go-btn').html('Pay as you go');
      }
    }
  });
  return false;
}
function update_milestones(id){
  $.ajax({
    type:'POST',
    url:site_url+'posts/update_milestones',
    data:$('#post_mile'+id).serialize(),
    dataType:'JSON',
    beforeSend:function(){
      $('#msg').html('');
    },
    success:function(resp){
      if(resp.status==1){
        location.reload();
         
      } else {
        $('#msg').html(resp.msg);
      }
    }
  });
  return false;
}
function showdiv()
{
   $('#chat_user').show();
  
}
function get_chat_onclick(id)
{
  var post='<?php echo $_REQUEST['post_id']; ?>';
    $.ajax({
    type:'POST',
    url:site_url+'chat/get_chats',
    data:{id:id,post:post},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#rid').val(id);
        $('#userdetail').html(resp.userdetail);
        var oldscrollHeight = $("#usermsg").prop("scrollHeight");         
          $('.user_chat').html(resp.data);  
        var newscrollHeight = $("#usermsg").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $("#usermsg").animate({
              scrollTop: newscrollHeight
          }, 'normal');
        }

      } 
 
    }
  });
  return false;

}
function get_chat_history_interwal()
{
  var id = $('#rid').val();
  if(id)
  {
    get_chat_onclick(id);
  }
}
function send_msg()
{
    var post='<?php echo $_REQUEST['post_id']; ?>';
  $.ajax({
    type:'POST',
     url:site_url+'chat/send_msg',
    data:$('#send_msg').serialize(),
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#ch_msg').val('');
      }
    }
  });
  return false;
}
function get_unread_msg_count(post_id, rid)
{
  
  $.ajax({
    type:'POST',
   url:site_url+'chat/get_unread_msg_count',
    data:{post:post_id,rid:rid},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.count_un_msg'+rid).html('('+resp.count+')');
      }
      else
      {
        $('.count_un_msg'+rid).html('');
      }
    }
  });
  return false;
}
function accept_post(id,status) {
   if (confirm("Are you sure you want to award the job post to this tradesmen?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/accept_post/'+id+'/'+status,
            dataType: 'JSON',
             success:function(resp){
            if(resp.status==1)
            {
              location.reload();
            }
            } 
        });
    } 
  }
  function accept_mile_request(id,status)
  {
       if (confirm("Are you sure you want to accept this milestone request?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/accept_post/'+id+'/'+status,
            dataType: 'JSON',
             success:function(resp){
            if(resp.status==1)
            {
              location.reload();
            }
            } 
        });
    } 
  }
  function mark_complete(post_id)
  {
        $.ajax({
            type:'POST',
            url:site_url+'posts/mark_completed/'+post_id,
            dataType: 'JSON',
            data:$('#marks_as_complete'+post_id).serialize(),
             success:function(resp){
            if(resp.status==1)
           {
                                        
             location.reload();
           }
           return false;
            } 
        });
          return false;
  }
  function mark_complete1(post_id)
  {
          $.ajax({
            type:'POST',
            url:site_url+'posts/mark_completed/'+post_id,
            dataType: 'JSON',
            data:$('#marks_as_complete1'+post_id).serialize(),
             success:function(resp){
            if(resp.status==1)
           {
                                        
             location.reload();
           }
           return false;
            } 
        });
          return false;
  }
  function viewRatingOnModal(post_id) {
  if(post_id) {
    
    $.ajax({
      type : 'POST',
      url:site_url+'posts/getRating',
      data :{post_id:post_id},
      dataType:'json',
      success :  function(response) { 
        $("#viewRatingModal").modal('show');
        $("#viewRatingData").html(response.data);
      }
    });
  }
  return false;
}
function viewRatingOnModal1(post_id)
{
    if(post_id) {
    
    $.ajax({
      type : 'POST',
      url:site_url+'posts/getRating',
      data :{post_id:post_id},
      dataType:'json',
      success :  function(response) { 
        $("#viewRatingModal1").modal('show');
        $("#viewRatingData1").html(response.data);
      }
    });
  }
  return false;
}

  function accept_award(id,status)
  {
           if (confirm("Are you sure you want to accept this award request?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/accept_award/'+id+'/'+status,
            dataType: 'JSON',
             success:function(resp){
            if(resp.status==1)
            {
              location.reload();
            }
            } 
        });
    } 
  }
  function deletemile(id)
  {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_mile/'+id,
            dataType: 'JSON',
             success:function(resp){
              if(resp.status==1)
              {
                $('#milessss'+id).remove();
              }
              
            } 
        });
  }
  function request_release(id)
  {
    var post_id='<?php echo $_REQUEST['post_id']; ?>';
            $.ajax({
            type:'POST',
            url:site_url+'posts/request_mile/'+id+'/'+post_id,
            dataType: 'JSON',
             success:function(resp){
              if(resp.status==1)
              {
                 location.reload();
              }
              else
              {
                 location.reload();
              }

              
            } 
        });
  }
  function release_amount(id)
  {
            $.ajax({
            type:'POST',
            url:site_url+'posts/release_amount/'+id,
            dataType: 'JSON',
             success:function(resp){
              if(resp.status==1)
              {
                 location.reload();
              }
              else
              {
                 location.reload();
              }

              
            } 
        });
  }
  function Rejectpost(post_id) {
  if(post_id) {
    $('#RejectPost').modal('show');
    $('#post_ids').val(post_id);
  }
}
function RejectReasonPosts() {
  var formData = $("#RejectReasonPost").serialize();
  $.ajax({
   url:site_url+'posts/reject_post',
    type: "post",
    data: formData,
    dataType:'json',
    success:function(response) {            
      if(response.status==1)
      {
   
        location.reload();
        return false;
      }  else {
        return false;
      }
    }
  });
  return false;
}
$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
 $('.rating').val(ratingValue);
    
  });
  
});

</script>
<script>
  let review_show = false;
  function show_review(redirect){
    if(review_show){
      window.location.href = redirect;
    }else{
      $(".tradesman-feedback").show();
      review_show = true;
    }
  }
  setInterval(function(){ get_chat_history_interwal(); }, 5000);
</script>

<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
  init_tinymce();
  function init_tinymce(){
    tinymce.init({
      menubar: false,
      branding: false,
      statusbar: false,
      selector: '.textarea',
      height:250,
      plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      setup: function (editor) {
        editor.on('change', function () {
          tinymce.triggerSave();
        });
      }
    });
  }
	
</script>
<script>
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var userid = '<?php echo $get_users['id']; ?>';
	$.ajax({ 
		type:'POST',
		url:site_url+'users/find_rating_ajax_project_detail/'+page_num,
		data:'page_num='+page_num+'&userid='+userid,
		dataType:'JSON',
		beforeSend:function()
		{
			$('.search_btn').prop('disabled',true);
			$('.btn_loader').show();
		},
		success:function(resp)
		{
			$('.search_btn').prop('disabled',false);
			$('.btn_loader').hide();
			$('#search_data').html(resp.data);
			$('#ajax_link').html(resp.ajax_link);
		}
	});
	return false;
}
</script>
<?php 
if($this->session->userdata('user_id') && $this->session->userdata('type')==1){
$user_id = $this->session->userdata('user_id');
$check_visit = $this->common_model->GetColumnName('visit_job',array('job_id'=>$_REQUEST['post_id'],'user_id'=>$user_id),array('id'));
if(!$check_visit){
	$this->common_model->insert('visit_job',array('job_id'=>$_REQUEST['post_id'],'user_id'=>$user_id,'visit_date'=>date('Y-m-d')));
}
} ?>
