<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style>
/* The container */
.paymrnt_div {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background: #fff;
  box-shadow: 0 1px 2px #d0d0d0;
  padding: 20px;
  width: 100%;
  border-radius: 6px;
}
.modal-backdrop.fade.in {
  opacity: 0.5;
}

/* Hide the browser's default radio button */
.paymrnt_div input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 24px;
  left: 15px;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.paymrnt_div:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.paymrnt_div input:checked ~ .checkmark {
  background-color: #FE8A0F;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.paymrnt_div input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.paymrnt_div .checkmark:after {
  top: 3px;
  left: 3px;
  width: 19px;
  height: 19px;
  border-radius: 50%;
  background: white;
}
.contant_lable img {
  width: 100px;
  margin-left: 39px;
}
</style>
<style>
.fade {
  opacity: 0;
  -webkit-transition: opacity .15s linear;
  transition: opacity .15s linear;
  display: none;
}
.fade.in {
  opacity: 1;
  display: block;
}
#zoid-paypal-button-1c5cec317c {
		font-size: 0;
		width: 100%;
		overflow: hidden;
		min-width: 75px;
}

#zoid-paypal-button-1c5cec317c.paypal-button-size-responsive {
		text-align: center;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet {
		display: inline-block;
		min-width: 75px;
		max-width: 750px;
		position: relative;
}

#zoid-paypal-button-1c5cec317c.paypal-button-layout-vertical > .zoid-outlet {
		min-width: 75px;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet {
		width:  150px;
		height: 25px;
}

 #zoid-paypal-button-1c5cec317c.paypal-button-size-responsive > .zoid-outlet {
		width: 100%;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe {
		min-width: 100%;
		max-width: 100%;
		width: 75px;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-component-frame {
		z-index: 100;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-prerender-frame {
		transition: opacity .2s linear;
		z-index: 200;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-visible {
		opacity: 1;
}

#zoid-paypal-button-1c5cec317c > .zoid-outlet > iframe.zoid-invisible {
		opacity: 0;
		pointer-events: none;
}
.table-responsive {
	overflow: auto;
}
@media (max-width:575.98px){
	.table-responsive-sm{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-sm>.table-bordered{
			border:0
	}
}
@media (max-width:767.98px){
	.table-responsive-md{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-md>.table-bordered{
		border:0
	}
}
@media (max-width:991.98px){
	.table-responsive-lg{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-lg>.table-bordered{
		border:0
	}
}
@media (max-width:1199.98px){
	.table-responsive-xl{
		display:block;
		width:100%;
		overflow-x:auto;
		-webkit-overflow-scrolling:touch;
		-ms-overflow-style:-ms-autohiding-scrollbar
	}
	.table-responsive-xl>.table-bordered{
		border:0
	}
}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>         
				</div>
				<div class="col-sm-9">
					<div class="mjq-sh">
						<h2><strong>Your Earnings</strong></h2>
					</div>
					<?php if($this->session->flashdata('error')) { ?>
          
					<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
          
					<?php } ?> 
				
					<?php if($this->session->userdata('success121')){ ?>
					<p class="alert alert-success">Your request of withdrawal has been submitted successfully. Please wait for admin response.</p>
					<?php $this->session->unset_userdata('success121'); } ?>

					<div class="user-right-side">
						<div class="container">
							<br>
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#select">Earning</a></li>
								<li><a data-toggle="tab" href="#withdraw_history" id="withdraw-history-tab">Earning History</a></li> 
							</ul>
						</div>
						<div id="withdraw_history" class="tab-pane fade">
							<h1>Earning History</h1> 
							<div class="setbox2">
								<div class="table-responsive">
<table id="boottable" class="table table-bordered table-striped">
            
	<thead>

		<tr> 
			<th>S.NO</th> 
			<th>Date</th>
			<th>Job Title</th>
			<th>Description</th>
			<th>Amount</th>
			<th>Action</th>              
		</tr>
                
	</thead>
              
	<tbody>
						
		<?php
                
		$x=1;
                
		foreach($lists as $key => $list){
		
		?>
             
		<tr role="row" class="odd">
			<td><?php echo $key+1; ?></td> 
			<td>
				<?php echo date('d F Y',strtotime($list['cdate']));  ?>
			</td>			
			<td><?php echo $list['job_title']; ?></td>
			<td><?php echo $list['milestone_name']; ?></td>
								
			<td>
				
				<?php
				$admin_commission = ($list['milestone_amount']*$list['admin_commission'])/100;
				$total = $list['milestone_amount'] - $admin_commission;
				?>
			
			<i class="fa fa-gbp"></i><?php echo round($total,2); ?> GBP</td>
			
			<td><a class="btn btn-anil_btn" href="<?= site_url().'payments?post_id='.$list['post_id']; ?>">View Job Detail</a></td>
			
		</tr>

                
		<?php $x++; } ?>
              
	</tbody>
              
</table> 
								</div>
							</div>
						</div>
						
						<div id="select" class="tab-pane fade in active">
						
						
							<div class="setbox2" id="bank_account">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3 text-center">
										<h3 class="text"> Total Earnings</h3>
										<br>
										<br>
										<div class="Wallet_1 well wel-main">
											<h3 class="text"> <i class="fa fa-money" ></i> Balance
												<span><i class="fa fa-gbp"></i><?php if($user_profile['withdrawable_balance']!=''){ echo $user_profile['withdrawable_balance']; }else{ echo "0"; } ?></span>
											</h3>

										</div>
										<br>
										<br>
										<h3 class="text">
											<a class="btn btn-warning" href="<?php echo base_url('fund-withdrawal'); ?>">Withdraw Now</a>
										</h3>
									</div>
								</div>
			 
								<div class="msg2"><?= $this->session->flashdata('msg'); ?></div>
							</div>
						</div>


                        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>  
$(function(){
	$("#boottable").DataTable({
		stateSave: true,
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			 "pageLength": 25
	});
	$(".DataTable").DataTable({
		stateSave: true
	});
});

</script>
<?php if(isset($_GET['show_reason']) && !empty($_GET['show_reason'])){ ?>
<script>
$(document).ready(function(){
	var wd_id = '<?php echo $_GET['show_reason']; ?>';
	$('#withdraw-history-tab').trigger('click');
	$('#viewrejectreason1'+wd_id).modal('show');
});
</script>
<?php } ?>
<?php include 'include/footer.php'; ?>
	