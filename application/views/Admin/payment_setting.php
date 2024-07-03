<?php 
include_once('include/header.php');
if(!in_array(12,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Payment Settings</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Payment Settings</li>
    </ol> 
  </section>
  <section class="content">   
                                
    <div class="row" style="background:white;">
      <form action="<?php echo site_url('Admin/Admin/update_payment'); ?>" method="post">
      <div class="col-sm-12">
      <?php 
           if($this->session->flashdata('msg')){
             echo $this->session->flashdata('msg');
            }
      ?>  
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="p_max_w">Max Withdraw Amount:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number" min="1" class="form-control" id="p_max_w" name="p_max_w" value="<?php echo $setting[0]['p_max_w']; ?>">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
					
          <label for="p_min_w">Min Withdraw Amount:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number" min="1" class="form-control" id="p_min_w" name="p_min_w" value="<?php echo $setting[0]['p_min_w']; ?>">
					</div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label for="p_max_d">Max Deposit Amount:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number" min="1" class="form-control" id="p_max_d" name="p_max_d" value="<?php echo $setting[0]['p_max_d']; ?>">
						<input type="hidden" class="form-control" id="admin_id" name="admin_id" value="<?php echo $setting[0]['id']; ?>">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="p_min_d">Min Deposit Amount:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number" min="1" class="form-control" id="p_min_d" name="p_min_d" value="<?php echo $setting[0]['p_min_d']; ?>">
					</div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label for="commision">Admin Commission in percentage(For Tradesman):</label>
					<div class="input-group">
          <input type="number" step="0.01" min="0.01" max="100" class="form-control" id="commision" name="commision" value="<?php echo $setting[0]['commision']; ?>">
						<span class="input-group-addon">%</span>
        </div>
        </div>
      </div>

      
			<div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Credit Amount for Chat/Bid(Pay as you go):</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number" step="0.01" min="0" class="form-control" id="credit_amount" name="credit_amount" value="<?php echo $setting[0]['credit_amount']; ?>">
					</div>
        </div>
      </div>
			<div class="col-sm-6">
        <div class="form-group">
          <label for="closed_date">Closed Project Day(s):</label>
					<div class="input-group">
						<input type="number" min="1" class="form-control" id="closed_date" name="closed_date" value="<?php echo $setting[0]['closed_date']; ?>">
						<span class="input-group-addon">Day(s)</span>
					</div>
        </div>
      </div>
			
			<div class="col-sm-6">
        <div class="form-group">
          <label for="waiting_time">Wating time in days(s): <span data-toggle="tooltip" title="This is maximum wating time for on dispute reply."><i class="fa fa-info"></i></span></label>
					<div class="input-group">
						<input type="number" min="1" class="form-control" id="waiting_time" name="waiting_time" value="<?php echo $setting[0]['waiting_time']; ?>">
						<span class="input-group-addon">Day(s)</span>
					</div>
        </div>
      </div>
			
			<div class="col-sm-6">
        <div class="form-group">
          <label for="waiting_time">Feedback/Review validity(Days): <span data-toggle="tooltip" title="This is maximum time allowed for which user can make review/feedback."><i class="fa fa-info"></i></span></label>
					<div class="input-group">
						<input type="number" min="1" class="form-control" id="feedback_day_limit" name="feedback_day_limit" value="<?php echo $setting[0]['feedback_day_limit']; ?>">
						<span class="input-group-addon">Day(s)</span>
					</div>
        </div>
      </div>
			<div class="col-sm-6">
        <div class="form-group">
          <label for="processing_fee">Bank Processing fee(%)(For Homeowners):</label>
					<div class="input-group">
						<input type="number" step="0.01" min="0" class="form-control" id="processing_fee" name="processing_fee" value="<?php echo $setting[0]['processing_fee']; ?>">
						<span class="input-group-addon">%</span>
					</div>
        </div>
      </div>
			<div class="col-sm-6">
        <div class="form-group">
          <label for="processing_fee">Invite to review:</label>
          <select class="form-control" name="invite_to_review_status">
						<option value="1" <?php echo ($setting[0]['invite_to_review_status']==1) ? 'selected' : ''; ?> >Activated</option>
						<option value="0" <?php echo ($setting[0]['invite_to_review_status']==0) ? 'selected' : ''; ?> >Dactivated</option>
					</select>
        </div>
      </div>
			<div class="col-sm-6">
        <div class="form-group">
          <label for="waiting_time_offer">Wating time to accept offer: <span data-toggle="tooltip" title="This is maximum wating time for award accept."><i class="fa fa-info"></i></span></label>
          <input type="number" min="1" class="form-control" id="waiting_time_accept_offer" name="waiting_time_accept_offer" value="<?php echo $setting[0]['waiting_time_accept_offer']; ?>">
        </div>
      </div>
			
			<div class="col-sm-6">
        <div class="form-group">
          <label for="paypal_comm_per">Paypal commision:</label>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group">
								<input type="number" step="0.01" min="1" max="100" class="form-control" id="paypal_comm_per" name="paypal_comm_per" value="<?php echo $setting[0]['paypal_comm_per']; ?>">
								<span class="input-group-addon">%</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<input type="number" step="0.01" min="0" class="form-control" id="paypal_comm_fix" name="paypal_comm_fix" value="<?php echo $setting[0]['paypal_comm_fix']; ?>">
								<span class="input-group-addon">Fixed</span>
							</div>
						</div>
						<div class="col-sm-12">
						<p>Total comission will be: <b>(<?php echo $setting[0]['paypal_comm_per']; ?>%+<?php echo $setting[0]['paypal_comm_fix']; ?>)</b></p>
						</div>
					</div>
        </div>
      </div>
			
			<div class="col-sm-6">
        <div class="form-group">
          <label for="stripe_comm_per">Stripe commision:</label>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group">
								<input type="number" step="0.01" min="1" max="100" class="form-control" id="stripe_comm_per" name="stripe_comm_per" value="<?php echo $setting[0]['stripe_comm_per']; ?>">
								<span class="input-group-addon">%</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<input type="number" step="0.01" min="0" class="form-control" id="stripe_comm_fix" name="stripe_comm_fix" value="<?php echo $setting[0]['stripe_comm_fix']; ?>">
								<span class="input-group-addon">Fixed</span>
							</div>
						</div>
						<div class="col-sm-12">
						<p>Total comission will be: <b>(<?php echo $setting[0]['stripe_comm_per']; ?>%+<?php echo $setting[0]['stripe_comm_fix']; ?>)</b></p>
						</div>
					</div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Account Name:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text"  class="form-control"  name="acc_name" value="<?php echo $setting[0]['acc_name']; ?>" placeholder="Enter account name">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Sort Code:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-code"></i></span>
						<input type="text"  class="form-control"  name="sort_code" value="<?php echo $setting[0]['sort_code']; ?>" placeholder="Enter sort code">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Account Number:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-info"></i></span>
						<input type="number"  class="form-control"  name="acc_number" value="<?php echo $setting[0]['acc_number']; ?>" placeholder="Enter account number">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Bank Name:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bank"></i></span>
						<input type="text"  class="form-control"  name="bank_name" value="<?php echo $setting[0]['bank_name']; ?>" placeholder="Enter bank name">
					</div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Step In Amount:</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
						<input type="number"  class="form-control"  name="step_in_amount" value="<?php echo $setting[0]['step_in_amount']; ?>" placeholder="Enter step in Amount">
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Step In Day(s): <span data-toggle="tooltip" title="The step in button will show after <?php echo $setting[0]['step_in_day']; ?> day(s) from dispute got reply."><i class="fa fa-info"></i></span></label>
					<div class="input-group">
            <input type="number" min="1" class="form-control"  name="step_in_day" value="<?php echo $setting[0]['step_in_day']; ?>" placeholder="Step In Day(s)">
						<span class="input-group-addon">Day(s)</span>
					</div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="credit_amount">Arbitration fee deadline In Day(s): <span data-toggle="tooltip" title="User have <?php echo $setting[0]['arbitration_fee_deadline']; ?> day(s) to pay arbitration fee."><i class="fa fa-info"></i></span></label>
					<div class="input-group">
            <input type="number" min="1" class="form-control"  name="arbitration_fee_deadline" value="<?php echo $setting[0]['arbitration_fee_deadline']; ?>" placeholder="Step In Day(s)">
						<span class="input-group-addon">Day(s)</span>
					</div>
        </div>
      </div>
      <div class="col-sm-6">
				<div class="form-group">
					<label for="waiting_time_offer">Search API Key: <span data-toggle="tooltip" title="This API key used for search location"><i class="fa fa-info"></i></span></label>
					<input type="text" class="form-control" id="search_api_key" name="search_api_key" 
					value="<?php echo $setting[0]['search_api_key']; ?>">
				</div>
			</div>

      <div class="col-md-12">
				<div class="form-group">
					<label for="payment_method">Payment Method:</label>
					<?php echo $setting[0]['payment_method']; ?>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment_method" value="1" <?php echo $setting[0]['payment_method'] == 1 ? "checked" : "" ; ?> >
							<label class="form-check-label">Enable</label>

							<input class="form-check-input" type="radio" name="payment_method" value="0" <?php echo $setting[0]['payment_method'] == 0 ? "checked" : "" ; ?>>
							<label class="form-check-label">Disable</label>
						</div>
					</div>
				</div>
			</div>

      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary pull-right">Update</button>
      </div>
      </form>
      </div>

     </div>
  </section>
</div>
<?php include_once('include/footer.php'); ?>
 
  