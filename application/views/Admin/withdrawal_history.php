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
</style>
<div class="content-wrapper">

  <section class="content-header">
	
    <h1>Withdrawal Tradesman</h1>
		
		<ol class="breadcrumb">
		
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			
			<li class="active">Withdrawal History</li>
			
		</ol> 
		
	</section>
   

  <section class="content">
	
    <div class="row">
		
      <div class="col-xs-12">
			
        <div class="box">
				
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
					
          <div class="box-body">
					     <?php if($this->session->flashdata('error')) { ?>
          <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
          <?php } if($this->session->flashdata('success')) { ?>
          <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
          <?php } ?>
			<div class="table-responsive">
						
            <table id="boottable" class="table table-bordered table-striped">
						
              <thead>
							
                <tr> 
                   <th>S.NO</th> 
                  <th>Date</th> 
                  <th>Username</th>
                  <th>Amount</th>
                  <th>Payment By</th>
                  <th>Status</th>  
                  <th>Action</th> 
                </tr>
              </thead>
							
              <tbody>
							
								<?php
								
								$x=1;
								
								foreach($withdrawal as $lists) {
		                        $user=$this->Common_model->get_userDataByid($lists['wd_userid']);
								?>
             
                <tr role="row" class="odd">
				  <td><?php echo $x; ?></td>	

                  <td><?php echo date('d-m-Y h:i:s A',strtotime($lists['wd_create'])); ?></td>
                  <td><?php echo $user['f_name'].' '.$user['l_name']; ?></td>
                  <td><i class="fa fa-gbp"></i><?php if($lists['wd_amount']){ echo $lists['wd_amount']; }else{ echo "0"; } ?></td>
                 <td><?php if($lists['wd_payment_type']==1){ echo "Paypal"; }else{ echo "Bank Transfer"; } ?></td>
                 <td><?php if($lists['wd_status']==0){ ?><span class="label label-success">Pending</span><?php }else if($lists['wd_status']==1){ ?><span class="label label-success">Accepted</span><?php }else{ ?><span class="label label-danger">Rejected</span><?php } ?>
                     
                  </td>   
                  <td>
                    <?php if($lists['wd_status']==0){ ?>
                      <a href="<?php echo base_url(); ?>Admin/Admin/accept_withdraw/<?php echo $lists['wd_id'];?>/1/<?php echo $lists['wd_amount']; ?>/<?php echo $lists['wd_userid']; ?>" onclick="return confirm('Are you sure! you want to accept this withdrawal request?');" class="btn btn-success btn-xs">Accept</a>
                        <button class="btn btn-danger btn-xs" onclick="return Reject('<?php echo $lists['wd_id'];?>','<?php echo $lists['wd_userid'];?>','<?php echo $lists['wd_amount'];?>');">Reject</button>
                      
                      <?php } ?>  

                      <a data-target="#view_document<?php echo $lists['wd_id']; ?>" href="" data-toggle="modal" class="btn btn-warning btn-xs">View More</a>
                                           <?php if($lists['wd_status']==2){ ?>
                       <a href="#" data-target="#viewrejectreason1<?php echo $lists['wd_id']; ?>" data-toggle="modal"><button class="btn btn-danger btn-xs">View Reason</button></a>   <?php } ?>
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
            
                      <!-- Text input-->
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

                                                    <div class="modal fade popup" id="view_document<?php echo $lists['wd_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                <p style="font-size: 15px;"><b>Payment Method :</b>
                              <?php if($lists['wd_payment_type']==1){ ?>
                                 <?php echo "PayPal"; ?> <?php }else{ echo "Bank Transfer"; } ?></p>
                                 <?php if($lists['wd_payment_type']==1){ ?><p><b>PayPal Email : </b><?php echo $lists['wd_pay_email']; ?></p><?php }else{ 
																 $bank_detail=$this->Common_model->get_single_data('wd_bank_details',array('id'=>$lists['wd_bankid']));
																 ?><p><b>Account Holder Name : </b><?php echo $bank_detail['wd_account_holder']; ?></p>
                                 <p><b>Bank Name : </b><?php echo $bank_detail['wd_bank']; ?></p>
                                 <p><b>Account Name: </b><?php echo $bank_detail['wd_account']; ?></p>
                                 <p><b>Sort Code : </b><?php echo $bank_detail['wd_ifsc_code']; ?></p>
                               
                               <?php } ?>
                      </div></div>
                 
                          </div>
                   
               
                        </div>
           
        
             
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
            <textarea class="form-control" name="reject_mgs" required="" rows="5"></textarea>
          </div>
          <input type="hidden" name="wd_id" id="wd_id">
          <input type="hidden" name="wd_userid" id="wd_userid">
            <input type="hidden" name="wd_amount" id="wd_amount">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="rjiwi">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
      
  </div>
</div>
<?php include('include/footer.php'); ?>
<script>
function Reject(wd_id,wd_userid,wd_amount) {
  if(wd_id) {
    $('#RejectPost').modal('show');
    $('#wd_id').val(wd_id);
    $('#wd_userid').val(wd_userid);
     $('#wd_amount').val(wd_amount);
  }
}
function RejectReasonPosts() {
  var formData = $("#RejectReasonPost").serialize();
  $.ajax({
   url:site_url+'Admin/Admin/reject_post',
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
</script>
<script>
$(document).ready(function(){
	mark_read_in_admin('tbl_withdrawal',"1=1");
});
</script>



  