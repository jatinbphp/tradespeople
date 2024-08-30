<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <style type="text/css">

.table-responsive {
    overflow: auto;
}
/* The Modal (background) */

</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row" >
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>         
				</div>
				<div class="col-sm-9" >

<section class="tradsman-banner">
    <div class="card">
        <h1>Payment History</h1>
        <!-- <ul class="nav nav-tabs refferal_types">
        <li class="active pending_table" data-type="1">
            <a data-toggle="tab" style="cursor: pointer;color: black;">Pending Request</a>
        </li>
        <li class="approved_table" data-type="2">
            <a data-toggle="tab" style="cursor: pointer;color: black;">Approved Request</a>
        </li>
        <li class="rejected_table" data-type="3">
            <a data-toggle="tab" style="cursor: pointer;color: black;">Rejected Request</a>
        </li>
        
    </ul> -->

    </div>
</section>
 

<div class="user-right-side">

    <section class="tradsman" style="margin:0px 20px 20px 20px"> 
        <div class="box" style="padding: 50px 0px;">
            <div class="box-body">
                <div class="table-responsive" id="pending_table">
                 
                    <div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="boottable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th> 
                                            <!-- <th>Name</th> -->
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>status</th>
                                            <!-- <th>Reason</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php if(isset($pending_payout_requests) && !empty($pending_payout_requests)){ $sn= 1;  foreach ($pending_payout_requests as $key => $payout) { 
                                            // $user= $this->db->select('f_name, l_name')->where('id', $payout['user_id'])->get('users')->row(); ?>  
                                            <tr>
                                                <td style="width: 16%;padding-right: 0;"><?= $payout['trans_id']; ?></td>
                                                <!-- <td><?php if(!empty($user)){ echo $user->f_name.' '.$user->l_name; } ?></td> -->
                                                <td>£<?= $payout['request_amount']; ?></td>
                                                <td><?= (!empty($payout['payment_method']))? $payout['payment_method']:"Wallet request"; ?></td>
                                                <td>
                                                    <?php if($payout['status']==0){ ?>
                                                        <span class="label label-warning">Pending</span>
                                                    <?php }elseif($payout['status']==1){ ?>
                                                        <span class="label label-success">Paid</span>
                                                    <?php }elseif($payout['status']==2){ ?>
                                                        <span class="label label-danger">Rejected</span>

                                                        <span class="label label-primary" data-toggle="modal" data-target="#view_reasion<?=$payout['id']; ?>" style="cursor: pointer;">View Reason</span>

                                                        <!-- View Reasion -->
                                                    <div class="modal fade popup" id="view_reasion<?=$payout['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                      <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Reason </h4>
                                                          </div>
                                                        
                                                            <div class="modal-body">
                                                                <p><?= $payout['reason_for_reject']; ?></p>   
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                      </div>
                                                    </div>



                                                    <?php } ?>
                                                </td>
                                                <!-- <td><?= $payout['reason_for_reject']; ?></td> -->
                                            </tr> 

                                            

                                    <?php } } ?> 
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
        <?php if($this->session->userdata('type')==2){ ?>
        <div style="padding:20px 0px;">
          <a href="<?= base_url('manage-bank'); ?>" class="btn btn-block" type="button" style="color: #007bff; background-color: transparent; background-image: none;     border: 2px solid #007bff; font-weight: bold;">Edit payment method</a>
        </div>
        <?php } ?>
    </section>


                        
      </div>             

</div>
</div>

<?php include 'include/footer.php'; ?>

  <script> 
    $(document).ready(function() {
    $('#boottable').DataTable({
        ordering:false
    });
} );
 
  </script> 
