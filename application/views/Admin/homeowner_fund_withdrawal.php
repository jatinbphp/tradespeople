<?php 
include_once('include/header.php');
if(!in_array(14,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
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
.select2-container{
	width:100% !important;
}
</style>
<div class="content-wrapper">

  <section class="content-header">
	
    <h1>Homeowners Refund</h1>
		
		<ol class="breadcrumb">
		
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			
			<li class="active">Withdrawal History</li>
			
		</ol> 
		
	</section>
   

  <section class="content">
		<div class="div-action pull-right" style="padding-bottom:20px;">
			<button  data-toggle="modal" data-target="#send_request_modal" class="btn btn-success">Send Request</button> 
		</div> 
    <div class="row">
		
      <div class="col-xs-12">
			
        <div class="box">
				
          	
					
          <div class="box-body">
						
						<?php echo $this->session->flashdata('msg'); ?>
     
						<div class="table-responsive">
						
							<table id="boottable" class="table table-bordered table-striped">
						
								<thead>
									<tr> 
										<th style="display:none">S.NO</th> 
										<th>Date</th> 
										<th>Username</th>
										<th>Current Wallet amount</th>
										<th>Withdrawal Amount</th>
										<th>Status</th>  
										<th>Action</th> 
									</tr>
								</thead>
							
								<tbody>
								
									<?php
									
									$x=1;
									
									foreach($withdrawal as $lists) {
									$user=$this->Common_model->GetColumnName('users',array('id'=>$lists['user_id']),array('f_name','u_wallet','unique_id'));
									?>
							 
									<tr role="row" class="odd">
										<td style="display:none"><?php echo $x; ?></td>	
										<td><?php echo date('d-m-Y h:i:s A',strtotime($lists['create_date'])); ?></td>
										<td><?php echo $user['f_name'].' - '.$user['unique_id']; ?></td>
										<td><i class="fa fa-gbp"></i><?php echo $user['u_wallet']; ?></td>
										<td><i class="fa fa-gbp"></i><?php if($lists['amount']){ echo $lists['amount']; }else{ echo "0"; } ?></td>
										<td>
											<?php if($lists['status']==0){ ?>
												<span class="label label-warning">Pending</span>
											<?php }else if($lists['status']==1){ ?>
												<span class="label label-success">Accepted</span>
											<?php }else if($lists['status']==3){ ?>
												<span class="label label-warning">Information added</span>
											<?php } else { ?>
												<span class="label label-danger">Rejected</span>
											<?php } ?>
											 
										</td>   
										<td>
											<?php if($lists['status']!=0){ ?>
											<a data-target="#view_document<?php echo $lists['id']; ?>" href="" data-toggle="modal" class="btn btn-warning btn-xs">View Details</a>
<div class="modal fade popup" id="view_document<?php echo $lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">MORE INFORMATION</h4>
			</div>
			<div class="modal-body">
				<fieldset>
						
					<!-- Text input-->
					<div class="form-group">
								 
						<div class="col-md-12">
							
							<div class="row">
								<div class="col-sm-8">          
									<div class="form-group">
										<?php if($lists['pay_method']=='Bank Transfer'){ ?>
										<p><b>Account Holder Name : </b><?php echo $lists['account_holder_name']; ?></p>
										<p><b>Bank Name : </b><?php echo $lists['bank_name']; ?></p>
										<p><b>Account Number: </b><?php echo $lists['account_number']; ?></p>
										<p><b>Sort Code : </b><?php echo $lists['short_code']; ?></p>
										
										<?php } else if($lists['pay_method']=='Paypal'){ 
										$isExist = $this->Common_model->GetColumnName('billing_details', array('user_id' => $lists['user_id']),array('paypal_id'));
										?>
										
										<p><b>Paypal Id : </b><?php echo $isExist['paypal_id']; ?></p>
										<?php } else {
										$isExist = $this->Common_model->GetColumnName('billing_details', array('user_id' => $lists['user_id']),array('name','card_number','card_exp_month','card_exp_year','card_cvc','postcode','address'));
										?>
										<p><b>Card holder name: </b><?php echo $isExist['name']; ?></p>
										<p><b>Card number: </b><?php echo $isExist['card_number']; ?></p>
										<!--p><b>Card expiry month: </b><?php //echo $isExist['card_exp_month']; ?></p>
										<p><b>Card expiry Year: </b><?php //echo $isExist['card_exp_year']; ?></p>
										<p><b>cvc/cvv: </b><?php //echo $isExist['card_cvc']; ?></p-->
										<p><b>Postcode: </b><?php echo $isExist['postcode']; ?></p>
										<p><b>Address: </b><?php echo $isExist['address']; ?></p>
										<?php } ?>
									</div>
								</div>
								 
							</div>
						</div>
					 
					</div>
					
				</fieldset>
	 
			</div>
		</div>
	</div>
</div>
												
											<?php } ?>
											<?php if($lists['status']==3){ ?>
											
											<a href="<?php echo base_url(); ?>Admin/withdrawal/accept_withdraw/<?php echo $lists['id'];?>" onclick="return confirm('Are you sure! you want to accept this withdrawal request?');" class="btn btn-success btn-xs">Accept</a>
											<button class="btn btn-danger btn-xs" onclick="return Reject('<?php echo $lists['id'];?>','<?php echo $lists['user_id'];?>','<?php echo $lists['amount'];?>');">Reject</button>
												
											<?php } else if($lists['status']==0){ ?>
											<a href="<?php echo base_url(); ?>Admin/withdrawal/delete_request/<?php echo $lists['id'];?>" onclick="return confirm('Are you sure! you want to delete this withdrawal request?');" class="btn btn-danger btn-xs">Delete</a>
											<?php } ?>  

											<?php if($lists['status']==2){ ?>
											
											<button class="btn btn-danger btn-xs" data-target="#viewrejectreason1<?php echo $lists['wd_id']; ?>" data-toggle="modal">View Reason</button>
											
											<?php } ?>
										</td>
	 
<div class="modal fade popup" id="viewrejectreason1<?php echo $lists['wd_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: left">Reject Reason</h4>
			</div>
			<div class="modal-body">
				<fieldset>
					<div class="form-group">
						<div class="col-md-12" style="text-align: left;">
							<?php echo $lists['wd_reason']; ?>
						</div>
					</div>
					<div class="col-md-12">
						<div class="perview_pro_img"></div>
					</div>
				</fieldset>
	 
			</div>
		</div>
	</div>
</div>

					 
									</tr>
									
									<?php $x++; } ?>
								
								</tbody>
								
							</table>   
						</div>
			
          </div>
					
        </div>
				
      </div>
			
    </div>
		
  </section>
	
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
            <textarea class="form-control" name="reason" required="" rows="5"></textarea>
          </div>
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="user_id" id="user_id">
          <input type="hidden" name="amount" id="amount">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="rjiwi">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
      
  </div>
</div>

<div class="modal fade" id="send_request_modal" role="dialog">
  <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Request</h4>
      </div>
      <form method="post" id="send_request" onsubmit="return send_request();">
        <div class="modal-body">	
					<div class="add_msg"></div>
          <div class="form-group">
            <label>Select user:</label>
            <select class="form-control select2" onchange="get_user_wallet(this.value);" name="user_id" id="user_id1">
							<option value="">Select homeowner</option>
							<?php foreach($users as $key => $value){ ?>
							<option value="<?php echo $value['id']; ?>"><?php echo $value['f_name'].' - '.$value['unique_id']; ?></option>
							<?php } ?>
						</select>
          </div>
          <div class="form-group wallet-div" style="display:none;">
            <label>Current wallet amount:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
							<input type="number" readonly class="form-control" name="wallet" id="wallet">
						</div>
          </div>
          <div class="form-group pay_method-div" style="display:none;">
            <label>Recent payment method:</label>
						<input type="text" readonly class="form-control" name="pay_method" id="pay_method">
          </div>
          <div class="form-group">
            <label>Amount:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-gbp"></i></span>
							<input type="number" min="1" step="0.01" class="form-control" name="amount" required>
						</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary send_btn" id="send_btn">Send</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
      
  </div>
</div>

<?php include('include/footer.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();
});
function Reject(wd_id,wd_userid,wd_amount) {
  if(wd_id) {
    $('#RejectPost').modal('show');
    $('#id').val(wd_id);
    $('#user_id').val(wd_userid);
		$('#amount').val(wd_amount);
  }
}
function send_request() {
	var user_id1 = $('#user_id1').val();
	if(user_id){
		$.ajax({
			type: "post",
			url:site_url+'Admin/withdrawal/send_request',
			data: $("#send_request").serialize(),
			dataType:'json',
			beforeSend:function(){
				$('.add_msg').html('');
				$('.send_btn').prop('disabled',true);
			},
			success:function(response) {            
				if(response.status==1) {
					location.reload();
				}  else {
					$('.send_btn').prop('disabled',false);
					$('.add_msg').html(response.msg);
				}
			}
		});
	} else {
		alert('please select homeowner!');
	}
  return false;
}
function get_user_wallet(id) {
	if(id){
		$.ajax({
			type: "post",
			url:site_url+'Admin/withdrawal/get_user_wallet/'+id,
			dataType:'json',
			async:false,
			success:function(response) {            
				if(response.status==1) {
					$('#wallet').val(response.wallet);
					$('#pay_method').val(response.pay_method);
					$('.wallet-div').show();
					$('.pay_method-div').show();
				}  else {
					alert('We did not found deposit transaction history with this user.');
				}
			}
		});
	} else {
		$('.pay_method-div').hide();
		$('.wallet-div').hide();
		$('#wallet').val(0);
	}
  return false;
}
function RejectReasonPosts() {
  var formData = $("#RejectReasonPost").serialize();
  $.ajax({
   url:site_url+'Admin/withdrawal/reject_post',
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
	mark_read_in_admin('homeowner_fund_withdrawal',"is_admin_read=0");
});
</script>




  