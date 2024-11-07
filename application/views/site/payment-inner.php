<?php
include("include/header.php");
include("include/top.php");

$get_bid_post = $this->common_model->get_paybids('tbl_jobpost_bids', $_REQUEST['post_id']);

$get_users = $this->common_model->get_single_data('users', array('id' => $get_bid_post[0]['bid_by']));

$get_jobs = $this->common_model->get_single_data('tbl_jobs', array('job_id' => $_REQUEST['post_id']));

if ($get_jobs['status'] == 3) {
   redirect('proposals?post_id=' . $_REQUEST['post_id']);
}

$user_id2 = $this->session->userdata('user_id');
if (!$post_id || $get_job_detail == false || ($user_id2 != $get_job_detail['userid'] && $user_id2 != $get_job_detail['awarded_to'])) {
   redirect('dashboard');
}

$get_commision = $this->common_model->get_commision();

$paypal_comm_per = $get_commision[0]['paypal_comm_per'];
$paypal_comm_fix = $get_commision[0]['paypal_comm_fix'];

$stripe_comm_per = $get_commision[0]['stripe_comm_per'];
$stripe_comm_fix = $get_commision[0]['stripe_comm_fix'];
$bank_processing_fee = $get_commision[0]['processing_fee'];

$p_min_d = $get_commision[0]['p_min_d'];

if ($this->session->userdata('type') == 2) {
   if ($stripe_comm_per > 0 && $stripe_comm_fix > 0) {
      $processing_fee = (1 * $p_min_d * $stripe_comm_per) / 100;
      $amount_wp2 = $p_min_d + $processing_fee + $stripe_comm_fix;
   } else {
      $amount_wp2 = $p_min_d;
   }
} else {
   $amount_wp2 = $p_min_d;
}

$amount_wp2 = round($amount_wp2, 2);

$bank_Pay_info = '';
$strip_Pay_info = '';
$paypal_Pay_info = '';

if ($this->session->userdata('type') == 2) {
   $strip_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Strip charges (' . $stripe_comm_per . '%+' . $stripe_comm_fix . ') processing fee and processes your payment immediately ." data-original-title="" class="red-tooltip toll stripe-tooltip"><i class="fa fa-info-circle"></i></a>';


   $paypal_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Paypal charges (' . $paypal_comm_per . '%+' . $paypal_comm_fix . ') processing fee and processes your payment immediately." data-original-title="" class="red-tooltip toll paypal-tooltip"><i class="fa fa-info-circle"></i></a>';


   $bank_Pay_info = '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="We charge ' . $bank_processing_fee . '% processing fee and process your payment within 1-2 working days." data-original-title="" class="red-tooltip toll bank-tooltip"><i class="fa fa-info-circle"></i></a>';
}

?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
   var processing_perc = <?= $get_commision[0]['processing_fee']; ?>;
   var type = <?= $this->session->userdata('type'); ?>;
</script>
<style type="text/css">
   a.disabled {
      pointer-events: none;
      cursor: default;
   }

   .tox-toolbar__primary,
   .tox-editor-header {
      display: none !important;
   }
</style>
<div class="acount-page membership-page project-list">
   <div class="container">
      <div class="row">
         <div class="col-sm-9">
            <?php if ($this->session->userdata('message')) {
               echo $this->session->userdata('message');
               $this->session->unset_userdata('message');
            } ?>
            <?php if ($this->session->flashdata('error1')) { ?>
               <p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
            <?php } else if ($this->session->flashdata('success1')) { ?>
               <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
            <?php } ?>
            <?php if ($this->session->flashdata('error2')) { ?>
               <p class="alert alert-danger"><?php echo $this->session->flashdata('error2'); ?></p>
            <?php } else if ($this->session->flashdata('success2')) { ?>
               <p class="alert alert-success"><?php echo $this->session->flashdata('success2'); ?></p>
            <?php } ?>
            <div class="dashboard-white dashboard-white2">
               <div class="img-name1">
                  <div>
                     <?php if ($get_users['profile']) { ?>
                        <a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="pro-img"></a>
                     <?php } else { ?>
                        <a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="pro-img"></a>
                     <?php } ?>
                     <div class="names1">
                        <h4><b><a onclick="show_tradesment_profile(<?php echo $get_users['id']; ?>);" href="javascript:void(0);"><?php echo $get_users['trading_name']; ?></a></b></h4>
                        <div class="from-group revie">
                           <?php if ($get_users['average_rate']) { ?>
                              <span class="btn btn-warning btn-xs"><?php echo $get_users['average_rate']; ?>
                              </span>
                           <?php } ?>
                           <span class="star_r">
                              <?php for ($i = 1; $i <= 5; $i++) { ?>
                                 <?php if ($get_users['average_rate']) { ?>
                                    <?php if ($i <= $get_users['average_rate']) { ?>
                                       <i class="fa fa-star active"></i>
                                    <?php  } else { ?>
                                       <i class="fa fa-star"></i>
                                    <?php } ?>
                                 <?php } else { ?>
                                    <i class="fa fa-star"></i>
                                 <?php } ?>
                              <?php } ?>
                           </span> (<?php if ($get_users['total_reviews']) {
                                       echo $get_users['total_reviews'];
                                    } else {
                                       echo "0";
                                    } ?> reviews)
                           <span class="loder-pro" style="display: none;">
                              <ul class="ul_set">
                                 <li class="active"></li>
                                 <li class="active"></li>
                                 <li class="active"></li>
                                 <li class="active"></li>
                                 <li></li>
                              </ul>
                           </span>
                        </div>
                     </div>
                  </div>
                  <div class="pull-right">
                     <h3><i class="fa fa-gbp"></i><?php echo $get_bid_post[0]['bid_amount']; ?> GBP</h3>
                  </div>
               </div>
               <div class="Required_mne">
                  <a href="#" class="pull-left">
                     Milestone Payments
                  </a>
                  <?php if ($get_bid_post[0]['status'] == 5 || $get_bid_post[0]['status'] == 10) {
                  } ?>
                  <?php if ($this->session->userdata('type') == 2) {
                     $active_milestones = $this->common_model->get_active_milestone($get_bid_post[0]['id']);

                  ?>
                     <a href="#" data-target="#create_miles<?php echo $_REQUEST['post_id']; ?>" data-toggle="modal" class="btn btn-primary pull-right" style="color: #fff" ;>Create Milestone</a>
                  <?php } else { ?>
                     
                     <?php if($get_bid_post[0]['paid_total_miles'] < $get_bid_post[0]['bid_amount']){
                     if ($get_bid_post[0]['status'] == 7) {
                        $active_milestones = $this->common_model->get_active_milestone($get_bid_post[0]['id']);
                        $remaining = $get_bid_post[0]['bid_amount'] - $active_milestones['amount'];

                     ?>
                        <a href="javascript:void(0);" data-target="#create_mile<?php echo $_REQUEST['post_id']; ?>" data-toggle="modal" class="btn btn-primary pull-right" style="color: #fff" ;>Request Milestone</a>
                     <?php } else { ?>
                        <a href="javascript:void(0);" data-target="#create_mile<?php echo $_REQUEST['post_id']; ?>" data-toggle="modal" class="btn btn-primary pull-right" style="color: #fff" ;>Request Milestone</a>
                     <?php } ?>
                  <?php } ?>
                  <?php } ?>
               </div>
               <div class="modal fade popup" id="create_mile<?php echo $_REQUEST['post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabel">Request Milestone</h4>
                        </div>
                        <div id="msg1"><?= $this->session->flashdata('msg'); ?></div>
                        <form method="post" id="post_mile1_<?= $_REQUEST['post_id']; ?>" enctype="multipart/form-data" onsubmit="return update_milestones1(<?php echo $_REQUEST['post_id']; ?>);">
                           <div class="modal-body">
                              <fieldset>
                                 <div id="milessss">
                                    <div class="row">
                                       <div class="col-sm-8">
                                          <p>Describe what the milestone payment is for, e.g payment for plumbing work.</p>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-8">
                                          <div class="from-group">
                                             <input type="text" class="form-control miname_1" name="tsm_name1" placeholder="Project Milestone">
                                          </div>
                                       </div>
                                       <div class="col-sm-4">
                                          <div class="from-group">
                                             <input type="hidden" name="total_bids_amount" id="total_bids_amount1" value="<?php echo $get_bid_post[0]['bid_amount']; ?>">
                                             <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
                                                <input type="number" class="form-control miamount_1" placeholder="Project Amount" min="1" required name="tsm_amount1">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="input-append1">
                                    <div id="fields">
                                       <input type="hidden" name="post_id" id="post_id1" value="<?php echo $get_bid_post[0]['id']; ?>">
                                    </div>
                                 </div>
                                 <div class="from-group" style="display: none;">
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="add_more_miles1();">Add another milestone </a>
                                 </div>
                              </fieldset>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-warning submit_btn5">Request Now</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="modal fade popup" id="create_miles<?php echo $_REQUEST['post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabel">Create Milestone</h4>
                        </div>
                        <div id="msg"><?= $this->session->flashdata('msg'); ?></div>
                        <form method="post" id="post_mile<?php echo $_REQUEST['post_id']; ?>" enctype="multipart/form-data" onsubmit="return update_milestones(<?php echo $_REQUEST['post_id']; ?>)">
                           <div class="modal-body">
                              <div id="mymsg"></div>
                              <fieldset>
                                 <div id="milessss">
                                    <div class="row">
                                       <div class="col-sm-8">
                                          <p>Describe what the milestone payment is for, e.g payment for plumbing work.</p>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-8">
                                          <div class="from-group">
                                             <input type="text" class="form-control miname_1" name="tsm_name1" placeholder="Project Milestone">
                                          </div>
                                       </div>
                                       <div class="col-sm-4">
                                          <div class="from-group">
                                             <input type="hidden" name="total_bids_amount" id="total_bids_amount" value="<?php echo $get_bid_post[0]['bid_amount']; ?>">
                                             <?php
                                             $active_milestones = $this->common_model->get_active_milestone($get_bid_post[0]['id']);

                                             $remaining = $get_bid_post[0]['bid_amount'] - $active_milestones['amount'];
                                             ?>
                                             <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
                                                <!-- <input type="number" class="form-control miamount_1" placeholder="Milestone Amount" onkeyup=" amounts = this.value;" min="1" value="<?php echo $remaining; ?>" name="tsm_amount1" id="tsm_amount1123" required> -->
                                                <input type="number" class="form-control miamount_1" placeholder="Milestone Amount" onkeyup=" amounts = this.value;" min="1" name="tsm_amount1" id="tsm_amount1123" required>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="common_pay_main_div text-center instant-payment-button" style="display:none;">
                                    <div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet.</div>
                                    <br>
                                    <div class="form-group">
                                       <label>Enter Amount</label>
                                       <input type="number" class="form-control" value="<?php echo $get_commision[0]['p_min_d']; ?>" onkeyup="check_value(this.value);" id="amount">
                                    </div>
                                    <p class="instant-err alert alert-danger" style="display:none;"></p>
                                    <div class="card pay_btns  all-pay-tooltip">
                                       <div class="col-sm-4" style="padding: 0;">
                                          <div class="bonnnttlllo4">
                                             <div onclick="show_lates_stripe_popup(<?php echo $amount_wp2; ?>,<?php echo $get_commision[0]['p_min_d']; ?>,7);" class="pay_btn strip_btn" id="strip_btn"><img src="<?= base_url(); ?>img/pay_with.png"></div>
                                             <?= $strip_Pay_info; ?>
                                          </div>
                                       </div>
                                       <div class="col-sm-4" style="padding: 0;">
                                          <div class="bonnnttlllo4">
                                             <div class="pay_btn paypal_btn" id="paypal_btn"></div>
                                             <?= $paypal_Pay_info; ?>
                                             <input type="hidden" id="payProcess1" value="0">
                                          </div>
                                       </div>
                                       <div class="col-sm-4" style="padding: 0;">
                                          <div class="bonnnttlllo4 bonnnttlllo5">
                                             <a href="<?php echo site_url() . 'wallet?bank-transfer=1&amount=' . $get_commision[0]['p_min_d']; ?>" class="btn btn-primary bkd_url">Bank Transfer</a> <?= $bank_Pay_info; ?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="common_pay_loader pay_btns_laoder text-center" style="display:none;">
                                       <i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
                                    </div>
                                 </div>
                                 <div class="input-append1">
                                    <div id="fields">
                                       <input type="hidden" name="post_id" id="post_id123" value="<?php echo $get_bid_post[0]['id']; ?>">
                                       <input type="hidden" name="bid_by" id="bid_by" value="<?php echo $get_bid_post[0]['bid_by']; ?>">
                                    </div>
                                 </div>
                                 <div class="from-group" style="display: none;">
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="add_more_miles1();">Add another milestone </a>
                                 </div>
                              </fieldset>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-warning create_milestone">Create</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <?php
               if($get_bid_post[0]['paid_total_miles'] < $get_bid_post[0]['bid_amount']){
               $get_milestones2 = $this->common_model->get_all_data('tbl_milestones', array('bid_id' => $get_bid_post[0]['id'], 'created_by' => $get_bid_post[0]['bid_by'], 'post_id' => $_REQUEST['post_id']), 'id');?>
               <?php if (count($get_milestones2)) { ?>
                  <h4> Requested Milestones </h4>
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Description</th>
                              <th>Status</th>
                              <th>Amount</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $toatal1 = 0;
                           foreach ($get_milestones2 as $key => $mile) {
                              $toatal1 += $mile['milestone_amount'];
                           ?>
                              <tr>
                                 <td>
                                    <?php
                                    $yrdata = strtotime($mile['cdate']);
                                    echo date('d', $yrdata) . " " . date('F', $yrdata);
                                    echo date('Y', $yrdata); ?>
                                 </td>
                                 <td><?php echo $mile['milestone_name']; ?></td>
                                 <td> Pending </td>
                                 <td><i class="fa fa-gbp"></i><?php echo $mile['milestone_amount']; ?> GBP</td>
                                 <td>
                                    <?php if ($get_jobs['status'] == 7 || $get_jobs['status'] == 5) { ?>
                                       <?php if ($this->session->userdata('user_id') == $get_bid_post[0]['bid_by']) { ?>
                                          <?php if ($mile['is_suggested'] == 1) { ?>
                                             <button type="button" onclick="return send_resend_request(<?php echo $mile['id']; ?>);" href="" class="btn btn-primary btn-sm resend_btn<?php echo $mile['id']; ?>">Resend request</button>
                                          <?php } else { ?>
                                             <a onclick="return confirm('Are you sure you want to cancel this request?');" href="<?php echo site_url('posts/cancel_requested_milestone/' . $mile['id'] . '/' . $mile['post_id']); ?>" class="btn btn-primary btn-sm">Cancel request</a>
                                          <?php } ?>
                                       <?php } else if ($this->session->userdata('user_id') == $get_bid_post[0]['posted_by']) {  ?>
                                          <div class="btn-group">
                                             <button type="button" class="btn btn-primary">Action</button>
                                             <button type="button" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                                             <ul class="dropdown-menu" style="text-align: left;">
                                                <li><a onclick="miles_id = <?php echo $mile['id']; ?>; " data-target="#accept_releaseMS<?php echo $mile['id']; ?>" data-toggle="modal" href="javascript:void(0);">Accept Request</a></li>
                                                <li><a onclick="return confirm('Are you sure you want to decline this request');" href="<?php echo site_url('posts/decline_requested_milestone/' . $mile['id'] . '/' . $mile['post_id']); ?>">Decline Request</a></li>
                                             </ul>
                                          </div>
                                          <div class="modal fade popup modalNX" id="accept_releaseMS<?php echo $mile['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                             <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                      <h4 class="modal-title" id="myModalLabel">Accept Request</h4>
                                                   </div>
                                                   <form method="post" id="accept_releaseMSForm<?php echo $mile['id']; ?>" onsubmit="return accept_requested_milestone(<?php echo $mile['id']; ?>)">
                                                      <div class="modal-body">
                                                         <div id="AcceptReqmsg<?php echo $mile['id']; ?>"></div>
                                                         <fieldset>
                                                            <div id="milessss">
                                                               <div class="row">
                                                                  <div class="col-sm-8">
                                                                     <div class="from-group">
                                                                        <input type="text" class="form-control miname_1" name="tsm_name1" readonly value="<?php echo $mile['milestone_name']; ?>" placeholder="Project Milestone">
                                                                     </div>
                                                                  </div>
                                                                  <div class="col-sm-4">
                                                                     <div class="from-group">
                                                                        <input type="hidden" name="total_bids_amount" readonly value="<?php echo $get_bid_post[0]['bid_amount']; ?>">
                                                                        <input type="number" class="form-control miamount_1" placeholder="Milestone Amount" min="1" value="<?php echo $mile['milestone_amount']; ?>" readonly name="tsm_amount1">
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <div class="common_pay_main_div instant-payment-button_<?php echo $mile['id']; ?>" style="display:none;">
                                                               <div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet. <span class="Current_wallet_amount"></span></div>
                                                               <br>
                                                               <div class="form-group">
                                                                  <label>Enter Amount</label>
                                                                  <input type="number" class="form-control" value="<?php echo $get_commision[0]['p_min_d']; ?>" onkeyup="check_value_two(<?php echo $mile['id']; ?>,this.value);" id="amount_<?php echo $mile['id']; ?>">
                                                               </div>
                                                               <p class="instant-err_<?php echo $mile['id']; ?> alert alert-danger" style="display:none;"></p>
                                                               <div class="card_ pay_btns_<?php echo $mile['id']; ?> all-pay-tooltip">
                                                                  <div class="col-sm-4" style="padding: 0;">
                                                                     <div data-id="<?php echo $mile['id']; ?>" onclick="show_lates_stripe_popup(<?php echo $amount_wp2; ?>,<?php echo $get_commision[0]['p_min_d']; ?>,8,<?php echo $mile['id']; ?>);" class="pay_btn_<?php echo $mile['id']; ?> strip_btn" id="strip_btn_<?php echo $mile['id']; ?>"><img src="<?= base_url(); ?>img/pay_with.png"></div>
                                                                     <?= $strip_Pay_info; ?>
                                                                  </div>
                                                                  <div class="col-sm-4" style="padding: 0;">
                                                                     <div class="pay_btn_<?php echo $mile['id']; ?> paypal_btn" id="paypal_btn_<?php echo $mile['id']; ?>"></div>
                                                                     <?= $paypal_Pay_info; ?>
                                                                     <input type="hidden" id="payProcess" value="0">
                                                                  </div>
                                                                  <div class="col-sm-4" style="padding: 0;">
                                                                     <a href="<?php echo site_url() . 'wallet?bank-transfer=1&amount=' . $get_commision[0]['p_min_d']; ?>" class="btn btn-primary bkd_url">Bank Transfer</a> <?= $bank_Pay_info; ?>
                                                                  </div>
                                                               </div>
                                                               <div class="common_pay_loader pay_btns_laoder_<?php echo $mile['id']; ?> text-center" style="display:none;">
                                                                  <i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
                                                               </div>
                                                            </div>
                                                            <div class="input-append1">
                                                               <div id="fields">
                                                                  <input type="hidden" name="miles_id" value="<?php echo $mile['id']; ?>">
                                                                  <input type="hidden" name="post_id" value="<?php echo $get_bid_post[0]['id']; ?>">
                                                                  <input type="hidden" name="bid_by" value="<?php echo $get_bid_post[0]['bid_by']; ?>">
                                                               </div>
                                                            </div>
                                                         </fieldset>
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                         <button type="submit" class="btn btn-warning create_milestone_<?php echo $mile['id']; ?>">Accept</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                          <?php
                                          $user_id = $this->session->userdata('user_id');

                                          $user = $this->common_model->get_userDataByid($user_id);

                                          $amounts = $mile['milestone_amount'] - $user['u_wallet'];
                                          ?>
                                          <script>
                                             var miles_id = <?php echo $mile['id']; ?>;
                                             var amount2 = $('#amount_' + miles_id).val();
                                             $(document).ready(function() {
                                                show_main_btn_two(<?php echo $mile['id']; ?>, amount2);
                                             });
                                          </script>
                                       <?php } ?>
                                    <?php } else { ?>
                                       <button disabled class="btn btn-primary" style="color: #fff" ;>Action</button>
                                    <?php }  ?>
                                 </td>
                              </tr>
                           <?php } ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td></td>
                              <td></td>
                              <td>Total</td>
                              <td><i class="fa fa-gbp"></i><?php echo $toatal1; ?></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               <?php } ?>
               <?php } ?>
               <?php
               $get_milestones = $this->common_model->get_all_data('tbl_milestones', array('bid_id' => $get_bid_post[0]['id'], 'created_by' => $get_bid_post[0]['posted_by'], 'post_id' => $_REQUEST['post_id']), 'id'); ?>
               <?php if (count($get_milestones)) { ?>
                  <h4> Created Milestones </h4>
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Date</th>
                              <th>Description</th>
                              <th>Status</th>
                              <th>Amount</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($get_milestones as $key => $mile) {
                           ?>
                              <tr>
                                 <td>
                                    <?php
                                    $yrdata = strtotime($mile['cdate']);
                                    echo date('d', $yrdata) . " " . date('F', $yrdata);
                                    echo date('Y', $yrdata); ?>
                                 </td>
                                 <td><?php echo $mile['milestone_name']; ?></td>
                                 <td>
                                    <?php if ($mile['status'] == 0) { ?>
                                       Pending
                                    <?php } else if ($mile['status'] == 2) { ?>
                                       Released
                                    <?php } else if ($mile['status'] == 3) { ?>
                                       Requested
                                    <?php } else if ($mile['status'] == 4) { ?>
                                       Cancelled Request
                                    <?php } else if ($mile['status'] == 5) { ?>
                                       Disputing
                                    <?php } else if ($mile['status'] == 6) { ?>
                                       Dispute Resolved
                                    <?php } else if ($mile['status'] == 8) {
                                       // echo "<pre>"; print_r($mile);
                                    ?>
                                       Rejected <br>
                                       <a href="#" data-target="#view_reject_reason<?php echo $mile['id']; ?>" data-toggle="modal">View Reason</a>
                                       <div class="modal fade popup" id="view_reject_reason<?php echo $mile['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog" role="document">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                   <h4 class="modal-title">Reason Details</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <fieldset>
                                                      <div id="milesssstone">
                                                         <div class="row">
                                                            <div class="col-sm-12">
                                                               <div class="from-group">
                                                                  <label class="control-label" for="textinput"><b>Reason</b></label>
                                                                  <p><?= $mile['reason_cancel']; ?></p>
                                                                  <!-- <textarea class="form-control" rows="5" readonly></textarea> -->
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </fieldset>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <?php } ?>
                                 </td>
                                 <td><i class="fa fa-gbp"></i><?php echo $mile['milestone_amount']; ?> GBP</td>
                                 <td>
                                    <?php if ($get_jobs['status'] == 7 || $get_jobs['status'] == 5) { ?>
                                       <?php if ($this->session->userdata('type') == 1) { ?>
                                          <?php if ($mile['status'] == 0 || $mile['status'] == 3 || $mile['status'] == 8) {  ?>
                                             <div class="btn-group">
                                                <button type="button" <?php if ($mile['status'] == 5) { ?>disabled <?php } ?> class="btn btn-primary">Action</button>
                                                <button type="button" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu" style="text-align: left;">
                                                   <?php if ($mile['is_requested'] == 0) { ?>
                                                      <li><a href="javascript:void(0);" onclick="request_release(<?php echo $mile['id']; ?>)">Request for release</a></li>
                                                   <?php } ?>
                                                   <li><a href="<?php echo base_url(); ?>mile-invoice/<?php echo $mile['id']; ?>">View Invoice</a></li>
                                                   <?php if ($mile['status'] == 5 || $mile['status'] == 6) { ?>
                                                      <li><a href="<?php echo site_url('dispute/' . $mile['dispute_id']); ?>">View Dispute</a></li>
                                                     
                                                   <?php } else { ?>
                                                      <li><a href="javascript:void(0);" data-target="#dispute_mileds<?php echo $mile['id']; ?>" data-toggle="modal">Dispute</a></li>
                                                   <?php } ?>
                                                </ul>
                                             </div>
                                          <?php } else if ($mile['status'] == 2) { ?>
                                             <a href="<?php echo base_url(); ?>mile-invoice/<?php echo $mile['id']; ?>" class="btn btn-primary btn-sm">View Invoice</a>
                                          <?php } else if ($mile['status'] == 5  || $mile['status'] == 6) { ?>
                                             <a href="<?php echo site_url('dispute/' . $mile['dispute_id']); ?>" class="btn btn-primary btn-sm">View Dispute</a>
                                            
                                          <?php  } else if ($mile['status'] == 4 || $mile['status'] == 8) { ?>
                                             <a class="btn btn-primary" href="#" data-target="#make_decision<?php echo $mile['id']; ?>" data-toggle="modal">Make Decision</a>
                                          <?php } ?>
                                       <?php } else { ?>
                                          <?php if ($mile['status'] == 0 || $mile['status'] == 3 || $mile['status'] == 8) { ?>
                                             <div class="btn-group">
                                                <button type="button" class="btn btn-primary" <?php if ($mile['status'] == 5) { ?>disabled <?php  } ?>>Action</button>
                                                <button type="button" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu" style="text-align: left;">
                                                   <li><a href="javascript:void(0);" onclick="release_amount123(<?php echo $mile['id']; ?>,<?php echo $get_bid_post[0]['id'] ?>,<?php echo $get_jobs['status']; ?>,<?php echo $_REQUEST['post_id']; ?>)">Release</a></li>
                                                   <li><a href="<?php echo base_url(); ?>mile-invoice/<?php echo $mile['id']; ?>">View Invoice</a></li>
                                                   <li style="display: none;"><a <?php if ($mile['status'] == 5) { ?>class="disabled" <?php } ?> href="#" data-target="#create_miles<?php echo $_REQUEST['post_id']; ?>" data-toggle="modal">Create Similar</a></li>
                                                   <?php if ($mile['created_by'] == $this->session->userdata('user_id')) { ?>
                                                      <li><a <?php if ($mile['status'] == 5) { ?>class="disabled" <?php } ?> href="#" data-toggle="modal" data-target="#request_cancel">Request Cancellation</a></li>
                                                   <?php } ?>
                                                   <?php if ($mile['status'] == 5  || $mile['status'] == 6) { ?>
                                                      <li><a href="<?php echo site_url('dispute/' . $mile['dispute_id']); ?>">View Dispute</a></li>
                                                    
                                                   <?php } else { ?>
                                                      <li><a href="#" data-target="#dispute_mileds<?php echo $mile['id']; ?>" data-toggle="modal">Dispute</a></li>
                                                   <?php  }  ?>
                                                </ul>
                                             </div>
                                             <div class="modal fade awaddd" id="request_cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                      <div class="modal-body">
                                                         <div class="box_SetPayments">
                                                            <div class="row mmm0">
                                                               <div class="col-sm-1"></div>
                                                               <div class="col-sm-10">
                                                                  <div class="box_SetPayments2">
                                                                     <h3>
                                                                        <b> Milestone Cancellation Request</b>
                                                                     </h3>
                                                                     <p>
                                                                        In order to cancel a milestone, you nee to send a cancellation request to your tradesmen. Once they accept the request, the milestone will be cancelled and the funds will be returned to you. If the request is denied, you can initiate a dispute.
                                                                     </p>
                                                                     <hr>
                                                                     <div class="Milestone2">
                                                                        <div class="row">
                                                                           <div class="col-sm-8">
                                                                              <p><b>Project Name</b><span style="float: right;"><?php echo $get_jobs['title']; ?></span></p>
                                                                              <p><b>Tradesmen Name</b><span style="float: right;"><?php echo $get_users['trading_name']; ?></span></p>
                                                                              <p><b>Milestone Description</b><span style="float: right;"><?php echo $mile['milestone_name']; ?></span></p>
                                                                              <p><b>Milestone Amount</b><span style="float: right;"><i class="fa fa-gbp"></i><?php echo $mile['milestone_amount']; ?> GBP</span></p>
                                                                              <p><b>Date Created</b><span style="float: right;"><?php 
                                                                              $yrdata = strtotime($mile['cdate']);
                                                                              echo date('d', $yrdata) . " " . date('F', $yrdata); ?>, <?php echo date('Y', $yrdata); ?></span></p>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                     <hr>
                                                                     <h3><b>Why do you want to cancel this milestone?</b></h3>
                                                                     <form action="<?php echo base_url('posts/cancel_request/' . $mile['id'] . '/' . $_REQUEST['post_id']); ?>" method="post" enctype="multipart/form-data">
                                                                        <p>
                                                                           <textarea name="reason_cancel" class="form-control" rows="5" required></textarea>
                                                                        </p>
                                                                        <h3><b>Upload Image (Optional)</b></h3>
                                                                        <p><input type="file" name="dct_image" class="form-control"></p>
                                                                        <div class="text-right">
                                                                           <button type="submit" class="btn btn-primary">Request Cancellation</button>
                                                                        </div>
                                                                     </form>
                                                                     <br>
                                                                  </div>
                                                               </div>
                                                               <div class="col-sm-1">
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          <?php } else if ($mile['status'] == 2) { ?>
                                             <a href="<?php echo base_url(); ?>mile-invoice/<?php echo $mile['id']; ?>" class="btn btn-primary btn-sm">View Invoice</a>
                                          <?php } else if ($mile['status'] == 5 || $mile['status'] == 6) { ?>
                                             <a href="<?php echo site_url('dispute/' . $mile['dispute_id']); ?>" class="btn btn-primary btn-sm">View Dispute</a>
                                             
                                          <?php  } ?>
                                       <?php  } ?>
<?php if ($mile['status'] == 0 || $mile['status'] == 3 || $mile['status'] == 8) { ?>
   <div class="modal fade popup nxDisputeModal" id="dispute_mileds<?php echo $mile['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Dispute Milestone</h4>
               <div class="alert alert-warning">
                  <ul>
                     <li> Most disputes are the result of a simple misunderstanding.</li>
                     <li> Our dispute resolution system is designed to allow both parties to resolve the issue amongst themselves.</li>
                     <li> Most disputes are resolved without arbitration.</li>
                     <li> If an agreement cannot be reached, either party may elect to pay an arbitration fee for our dispute team to resolve the matter.</li>
                  </ul>
               </div>
            </div>
            <div id="msg1"><?= $this->session->flashdata('msg'); ?></div>
            <form method="post" id="dispute_milesss<?php echo $mile['id']; ?>" enctype="multipart/form-data" action="<?php echo site_url('dispute-job/' . $mile['id']); ?>" onsubmit="return edit_portfolio(<?php echo $mile['id']; ?>);">
            <input type="hidden" name="post_id" required value="<?php echo $get_jobs['job_id']; ?>">
               <div class="modal-body">
                  <fieldset>
                     <div id="milesssstone">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="from-group">
                                 <label class="control-label" for="textinput"><b>Please describe in detail what the requirements were for the milestone(s) you wish to dispute.</b></label>
                                 <textarea class="form-control" name="dispute_reason" rows="5" required></textarea>
                                 <br>
                                 <label class="control-label" for="textinput"><b>Please describe in detail which of these requirements were not completed.</b></label>
                                 <textarea class="form-control" name="reason2" rows="5" required></textarea>
                                 <br>
                                 <label class="control-label" for="textinput"><b>Please include evidence of how the milestone requirements we communicated, as well as any other evidence that supports your case.</b></label>
                                 <input type="file" onchange="uploadImageForDispute(<?php echo $mile['id']; ?>)" id="dispute-file-upload-input-<?php echo $mile['id']; ?>" name="files[]" accept="image/*,pdf" multiple class="form-control">
                                 <div class="col-sm-12" style="margin-top: 10px; padding: 0px;">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                          </tr>
                                       </thead>
                                       <tbody class="disputeUploadFilesHtml<?php echo $mile['id']; ?>">
                                          
                                       </tbody>
                                    </table>
                                 </div>

                                 <div class="col-sm-12">
                                    <div class="from-group">
                                       <label class="control-label" for="textinput"><b>Select the milestone you want to dispute</b></label><br>
                                       <?php 
                                       
                                       $get_milestones_notpaid=$this->common_model->get_milestones_notpaid($mile['post_id']); 

                                       foreach($get_milestones_notpaid as $m){ ?>
                                       
                                       <input data-amount="<?php echo $m['milestone_amount']; ?>" class="dispute_milestones-<?php echo $mile['id']; ?>" type="checkbox" onchange="selectMilesForDispute(this,<?php echo $mile['id']; ?>)" name="milestones[]" <?php if($mile['id']==$m['id']){ ?>checked<?php } ?> value="<?php echo $m['id']; ?>"> <?php echo $m['milestone_name']; ?><br>
                                       <?php } ?>

                                    </div>
                                 </div>
                                 
                                 <label class="control-label" for="textinput"><b>Total Amount In dispute: <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $mile['id']; ?>"><?= $mile['milestone_amount']; ?></span></b></label><br>
                                 <label class="control-label" for="textinput"><b>Offer the amount you are prepared to pay:</b></label>
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-gbp"></i></span>
                                    <input type="number" id="offer_amount<?php echo $mile['id']; ?>" required min="0" name="offer_amount" max="<?= $mile['milestone_amount']; ?>" class="form-control" placeholder="Amount">
                                 </div>

                                 <p>Please enter an amount between <i class="fa fa-gbp"></i>0 to <i class="fa fa-gbp"></i><span class="totalDispute<?php echo $mile['id']; ?>"><?= $mile['milestone_amount']; ?></span>.</p>
                                 <br>
                                 <div class="caution-txt">
                                    <b class="text-danger">Caution!</b> You are entering the amount of the milestone that you are happy for the other
                                    party to receive.
                                    You may increase your offer in the future but you may not lower it.
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </fieldset>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-warning dispute_btn<?php echo $mile['id']; ?>">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php  } ?>
                                    <?php } else if ($get_jobs['status'] == 5) { ?>
                                       <?php if ($mile['status'] == 2) { ?>
                                          <a href="<?php echo base_url(); ?>mile-invoice/<?php echo $mile['id']; ?>" class="btn btn-primary btn-sm">View Invoice</a>
                                       <?php  } else { ?>
                                          <!-- <button disabled class="btn btn-primary" style="color: #fff"; >Action</button> -->
                                       <?php } ?>
                                    <?php } else { ?>
                                       <!-- <button disabled class="btn btn-primary" style="color: #fff"; >Action</button> -->
                                    <?php }  ?>
                                 </td>
                              </tr>
                              <div class="modal fade popup" id="make_decision<?php echo $mile['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" class="close" id="close<?php echo $mile['id']; ?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title" id="myModalLabel">Take a Decision</h4>
                                       </div>
                                       <div id="msg"><?= $this->session->flashdata('msg'); ?></div>
                                       <div class="modal-body">
                                          <fieldset>
                                             <div id="milessss">
                                                <div class="row">
                                                   <div class="col-sm-12">
                                                      <p><b>Reason of Cancellation: </b><?php echo $mile['reason_cancel']; ?></p>
                                                      <?php if ($mile['dct_image'] != '') { ?>
                                                         <a href="<?php echo base_url('img/request_cancel/' . $mile['dct_image']); ?>" target="_blank"><img src="<?php echo site_url('img/request_cancel/' . $mile['dct_image']); ?>" width='100' height='100'></a>
                                                      <?php } ?>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <p style="text-align: center;">If you approve this request of cancellation, then the milestone amount that you have created will be added to your wallet.</p>
                                                   <div class="col-sm-3"></div>
                                                   <div class="col-sm-4">
                                                      <div class="from-group">
                                                         <button class="btn btn-warning btn-lg" onclick="accept_decision(<?php echo $mile['id']; ?>)">Approve</button>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-4">
                                                      <a class="btn btn-danger btn-lg" href="#" data-target="#decline_request<?php echo $mile['id']; ?>" onclick="return decliensss(<?php echo $mile['id']; ?>)" data-toggle="modal">Decline</a>
                                                   </div>
                                                   <div class="col-sm-1"></div>
                                                </div>
                                             </div>
                                             <div class="input-append1">
                                                <div id="fields">
                                                   <input type="hidden" name="post_id" id="post_id" value="<?php echo $get_bid_post[0]['id']; ?>">
                                                   <input type="hidden" name="bid_by" id="bid_by" value="<?php echo $get_bid_post[0]['bid_by']; ?>">
                                                   <input type="hidden" name="amounts" id="amounts" value="<?php echo $get_bid_post[0]['bid_amount']; ?>">
                                                </div>
                                             </div>
                                          </fieldset>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal fade awaddd" id="decline_request<?php echo $mile['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <div class="modal-body">
                                          <div class="box_SetPayments">
                                             <div class="row mmm0">
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-10">
                                                   <div class="box_SetPayments2">
                                                      <h3>
                                                         <b> Milestone Decline Cancellation</b>
                                                      </h3>
                                                      <hr>
                                                      <h3><b>Why do you want to decline this request?</b></h3>
                                                      <form action="<?php echo site_url('posts/decline_request/' . $mile['id']); ?>" method="post" enctype="multipart/form-data">
                                                         <p>
                                                            <textarea name="decline_reason" class="form-control" rows="5" required></textarea>
                                                         </p>
                                                         <div class="text-right">
                                                            <button type="submit" class="btn btn-primary">Decline</button>
                                                         </div>
                                                      </form>
                                                      <br>
                                                   </div>
                                                </div>
                                                <div class="col-sm-1">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php } ?>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td></td>
                              <td></td>
                              <td>Total</td>
                              <td><i class="fa fa-gbp"></i><?php echo $get_bid_post[0]['total_milestone_amount']; ?></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               <?php } ?>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="dashboard-white edit-pro89">
               <div class=" dashboard-profile Locations_list11">
                  <h2>Payment Summary</h2>
                  <h5><b>Payment-to-date</b></h5>
                  <h4><?php $get_milestone_release = $this->common_model->get_milestone_paid($get_bid_post[0]['bid_by'], $_REQUEST['post_id']); ?><?php if ($get_milestone_release[0]['amount']) {
                                                                                                                                                      echo "£" . $get_milestone_release[0]['amount'];
                                                                                                                                                   } else {
                                                                                                                                                      echo "£0.00";
                                                                                                                                                   } ?> GBP</h4>
                  <br>
                  <h5><b>Pending Milestones</b></h5>
                  <h4><?php $get_milestone_pending = $this->common_model->get_milestone_pending($get_bid_post[0]['bid_by'], $_REQUEST['post_id']); ?><?php if ($get_milestone_pending[0]['amount']) {
                                                                                                                                                         echo "£" . $get_milestone_pending[0]['amount'];
                                                                                                                                                      } else {
                                                                                                                                                         echo "£0.00";
                                                                                                                                                      } ?> GBP</h4>
               </div>
            </div>
            <div class="dashboard-white edit-pro89">
               <div class=" dashboard-profile Locations_list11">
                  <h2>What is a milestone payment?</h2>
                  <?php if ($this->session->userdata('type') == 1) { ?>
                     <p>
                        Milestone Payment is a recommended way of getting paid by the homeowners on our platform. It is created before work starts.Once it is created, we securely hold the deposited funds.This system ensures money is available to be released when you finish your work.
                     </p>
                  <?php } else { ?>
                     <p>
                        Milestone Payment is a recommended set of paying tradespeople on our platform. It is created before work starts.Once you create a Milestone Payment, we securely hold your funds so the tradesperson cannot access them. You should release the Milestone Payments only when you are 100% satisfied with the work carried out.
                     </p>
                  <?php } ?>
                  <div class="Created_mm2">
                     <div class="row">
                        <div class="col-xs-4">
                           <img src="<?php echo base_url(); ?>img/img_13.png" class="img_r">
                           <p>
                              Created
                           </p>
                        </div>
                        <div class="col-xs-4">
                           <img src="<?php echo base_url(); ?>img/img_14.png" class="img_r">
                           <p>
                              Secured
                           </p>
                        </div>
                        <div class="col-xs-4">
                           <img src="<?php echo base_url(); ?>img/img_15.png" class="img_r">
                           <p>
                              Released
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="Milestone_aa">
                     <h5><b>Milestone are:</b></h5>
                     <ul class="ul_set">
                        <?php if ($this->session->userdata('type') == 1) { ?>
                           <li><span><i class="fa fa-check"></i> Safe and secure</span> We securely hold the homeowner’s deposited money.</li>
                           <li><span><i class="fa fa-check"></i> Controlled by you</span> Only you can cancel a created Milestone.</li>
                           <li> <span><i class="fa fa-check"></i> Released on completion</span> Once you complete a job, you can request the release of the Milestone</li>
                        <?php } else { ?>
                           <li><span><i class="fa fa-check"></i> Safe and Secure</span> We hold Milestone Payments until you decide to release them.</li>
                           <li><span><i class="fa fa-check"></i> Controlled by you</span> To ensure your tradesperson is on track, you can create the milestones in parts.</li>
                           <li> <span><i class="fa fa-check"></i> Disputable</span> You're protected by Tradespeoplehub’s Dispute Resolution Service, which assures that you only pay for work you’ve approved.</li>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade popup" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="rejectionModal">Rejection Reason</h4>
         </div>
         <div class="modal-body">
            <p style="font-size: 15px;">
               <?= $this->session->flashdata('reject_reason'); ?>
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<?php include("include/footer.php") ?>
<!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script-->
<script>
   <?php
   if ($this->session->flashdata('reject_reason')) {
   ?>
      $("#rejectModal").modal('show');
   <?php
   }
   ?>

   function edit_portfolio(id) {
      $('.dispute_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      $('.dispute_btn'+id).prop('disabled', true);
   }
   function selectMilesForDispute(e,id) {
      
      var total = 0;
      $('.dispute_milestones-'+id).each((index,item)=>{
         if($(item).is(':checked')){
            let amount = $(item).data('amount');
            total += amount;
         }
      })
      $('.totalDispute'+id).html(total)
      $('#offer_amount'+id).attr('max',total)
      
   }

   

   function uploadImageForDispute(id) {
      var formData = new FormData($('#dispute_milesss'+id)[0]);

      $.ajax({
         url: '<?= base_url() ?>Dispute/add_dispute_files',
         type: 'POST',
         cache: false,
         contentType: false,
         processData: false,
         data: formData,
         dataType: 'json',
         success: function(res) {
            
            if (res.status == 1) {
               
               $(`#dispute-file-upload-input-`+id).val('');

               for(let i =0 ; i < res.files.length; i++){
                  let fileData = res.files[i];
                  let html = `<tr>
                                 <td>${fileData.original_name}</td>
                                 <td>${fileData.size}</td>
                                 <td><button onclick="$(this).parent('td').parent('tr').remove()" type="button" class="btn btn-default" style=" padding: 1px 11px;">Delete</button></td>
                                 <input type="hidden" name="file_name[]" value="${fileData.name}">
                                 <input type="hidden" name="file_original_name[]" value="${fileData.original_name}">
                              </tr>`;

                     $('.disputeUploadFilesHtml'+id).append(html)

               }


            } else {
               swal({
                  html: true,
                  title: res.message,
                  type: "warning"
               });
            }
         }
      });
      return false;
   }

   function update_milestones(id) {
      $.ajax({
         type: 'POST',
         url: site_url + 'posts/update_milestones/' + id,
         data: $('#post_mile' + id).serialize(),
         dataType: 'JSON',
         beforeSend: function() {
            $('#msg').html('');
            $('#mymsg').html('');
            $('.create_milestone').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
            $('.create_milestone').prop('disabled', true);
         },
         success: function(resp) {
            $('.create_milestone').html('Create');
            $('.create_milestone').prop('disabled', false);
            if (resp.status == 1) {
               location.reload();
            } else if (resp.status == 2) {
               //$('#mymsg').html(resp.msg);
               $('.instant-payment-button').show();
               //amounts = resp.amount;
            } else {
               $('#msg').html(resp.msg);
            }
         }
      });
      return false;
   }

   function accept_requested_milestone(id) {
      $.ajax({
         type: 'POST',
         url: site_url + 'posts/accept_requested_milestone',
         data: $('#accept_releaseMSForm' + id).serialize(),
         dataType: 'JSON',
         beforeSend: function() {
            $('#AcceptReqmsg' + id).html('');
            $('.create_milestone_' + id).html('<i class="fa fa-spin fa-spinner"></i> Processing...');
            $('.instant-payment-button_' + id).hide();
            $('.create_milestone_' + id).prop('disabled', true);
         },
         success: function(resp) {
            $('.create_milestone_' + id).html('Accept');
            $('.create_milestone_' + id).prop('disabled', false);
            if (resp.status == 1) {
               location.reload();
            } else if (resp.status == 2) {
               $('.instant-payment-button_' + id).show();
               $('.pay_btns_' + id).show();
               $('.pay_btns_laoder_' + id).hide();
            } else {
               $('.instant-payment-button_' + id).show();
               $('.pay_btns_' + id).show();
               $('.pay_btns_laoder_' + id).hide();
               $('#AcceptReqmsg' + id).html(resp.msg);
            }
         }
      });
      return false;
   }


   function decliensss(mile) {
      $("#close" + mile).trigger("click");
   }

   function update_milestones1(id) {
      $.ajax({
         type: 'POST',
         url: site_url + 'posts/update_milestones1/' + id,
         data: $('#post_mile1_' + id).serialize(),
         dataType: 'JSON',
         beforeSend: function() {
            $('#msg1').html('');
            $('.submit_btn5').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
            $('.submit_btn5').prop('disabled', true);
         },
         success: function(resp) {
            if (resp.status == 1) {
               location.reload();
            } else {
               $('#msg1').html(resp.msg);
               $('.submit_btn5').html('Request Now');
               $('.submit_btn5').prop('disabled', false);
            }
         }
      });
      return false;
   }

   function request_release(id) {
      if (confirm("Are you sure you want to request for this milestone to release?")) {
         var post_id = '<?php echo $_REQUEST['post_id']; ?>';
         $.ajax({
            type: 'POST',
            url: site_url + 'posts/request_mile/' + id + '/' + post_id,
            dataType: 'JSON',
            success: function(resp) {
               if (resp.status == 1) {
                  location.reload();
               } else {
                  location.reload();
               }
            }
         });
      }
   }

   function release_amount123(id, post_id, status, job_id) {
      if (status == 7 || status == 5) {
         //var job_id='<?php echo $_REQUEST['post_id']; ?>';

         swal({
               title: 'Confirm Release of Funds',
               text: 'Only release milestone payments when you are 100% satisfied with your tradesperson work.They cannot be returned once released.',
               type: "warning",
               customClass: 'custom-swal',
               showCancelButton: true,
               confirmButtonClass: "btn-success",
               cancelButtonClass: "btn-danger",
               confirmButtonText: 'Release Payment',
               cancelButtonText: 'Cancel',
               closeOnConfirm: true,
               closeOnCancel: true
            },
            function(isConfirm) {
               if (isConfirm) {
                  //alert(site_url+'newPost/release_amount1/'+id+'/'+post_id+'/'+job_id);
                  window.location.href = site_url + 'newPost/release_amount1/' + id + '/' + post_id + '/' + job_id;
                  return false;
               }
            });

      } else {

         swal({
            html: true,
            title: 'You can not release amount as the awarded tradesmen has not accepted your proposal.',
            type: "info"
         });
         return false;

      }
      return false;
   }

   function accept_decision(id) {
      if (confirm("Are you sure you want to approve this request cancellation?")) {
         $.ajax({
            type: 'POST',
            url: site_url + 'posts/approve_decision/' + id,
            dataType: 'JSON',
            success: function(resp) {
               if (resp.status == 1) {
                  location.reload();
               }
            }
         });
      }
   }
</script>
<script>
   var post_id = <?php echo $_REQUEST['post_id']; ?>;

   var amounts = $('#tsm_amount1123').val();
</script>
<!-- instant paymet-->
<script>
   show_main_btn($('#amount').val());

   function check_value(value) {
      var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
      var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;

      change_bank_transafer_url(value);

      if (value >= min_amount && value <= max_amount) {
         //$('.show_btn').prop('disabled',false);
         $('.instant-err').hide();
         $('.instant-err').html('');
         amounts = value;

         var actual_amt = parseFloat(amounts);

         var stripe_comm_per = <?= $stripe_comm_per; ?>;
         var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
         var type = <?= $this->session->userdata('type'); ?>;
         var processing_fee = 0;
         var amount_wp2 = actual_amt;

         if (type == 2) {
            if (stripe_comm_per > 0 || stripe_comm_fix == 0) {
               processing_fee = (1 * actual_amt * stripe_comm_per) / 100;
               amount_wp2 = actual_amt + processing_fee + stripe_comm_fix;
            }
         }

         amount_wp2 = amount_wp2.toFixed(2);

         $('#strip_btn').attr('onclick', 'show_lates_stripe_popup(' + amount_wp2 + ',' + actual_amt + ',7);');

         show_main_btn(amounts);
      } else {
         $('.card').hide();
         //$('.show_btn').prop('disabled',true);
         $('.instant-err').show();
         $('.instant-err').html('Deposit amount must be more than <i class="fa fa-gbp"></i>' + min_amount + ' and less than <i class="fa fa-gbp"></i>' + max_amount + '!');
         $('.pay_btns').hide();
      }
   }

   function show_main_btn(amounts) {
      $('.pay_btns').show();
      $('.paypal_btn').html('');

      var actual_amt = parseFloat(amounts);

      var type = <?= $this->session->userdata('type'); ?>;
      var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
      var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
      var processing_fee = 0;
      var amount_wp2 = actual_amt;

      if (type == 2) {
         if (paypal_comm_per > 0 || paypal_comm_fix > 0) {
            processing_fee = ((actual_amt * paypal_comm_per) / 100);
            var amount_wp2 = processing_fee + actual_amt + paypal_comm_fix;
         }
      }

      var amount_wp2 = amount_wp2.toFixed(2);

      paypal.Button.render({
         env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
         client: {
            sandbox: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
            production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
         },

         // Show the buyer a 'Pay Now' button in the checkout flow
         commit: true,

         // payment() is called when the button is clicked
         payment: function(data, actions) {

            // Make a call to the REST api to create the payment
            return actions.payment.create({
               payment: {
                  transactions: [{
                     amount: {
                        total: amount_wp2,
                        currency: 'GBP'
                     }
                  }]
               }
            });
         },

         // onAuthorize() is called when the buyer approves the payment
         onAuthorize: function(data, actions) {
            // Make a call to the REST api to execute the payment
            return actions.payment.execute().then(function() {
               console.log('Payment Complete!');
               $.ajax({
                  type: 'POST',
                  url: site_url + 'wallet/paypal_deposite',
                  data: {
                     itemPrice: amounts,
                     itemId: 'Deposit in wallet',
                     orderID: data.orderID,
                     txnID: data.paymentID,
                  },
                  dataType: 'JSON',
                  beforeSend: function() {
                     $('.pay_btns').hide();
                     $('.pay_btns_laoder').show();
                  },
                  success: function(resp) {
                     if (resp.status == 1) {
                        //location.reload();
                        //window.location.href=site_url+'Users/success/5/'+resp.tranId;
                        $('#post_mile' + post_id).submit();
                     } else {
                        $('.pay_btns').show();
                        $('.pay_btns_laoder').hide();
                        toastr.error(resp.msg);
                     }
                  }
               });
            });
         }
      }, '#paypal_btn');

   }

   function check_value_two(id, value) {
      var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
      var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;

      change_bank_transafer_url(value);

      if (value >= min_amount && value <= max_amount) {
         //$('.show_btn').prop('disabled',false);
         $('.instant-err_' + id).hide();
         $('.instant-err_' + id).html('');
         amount2 = value;

         var actual_amt = parseFloat(amount2);

         var stripe_comm_per = <?= $stripe_comm_per; ?>;
         var stripe_comm_fix = <?= $stripe_comm_fix; ?>;
         var type = <?= $this->session->userdata('type'); ?>;
         var processing_fee = 0;
         var amount_wp2 = actual_amt;

         if (type == 2) {
            if (stripe_comm_per > 0 || stripe_comm_fix == 0) {
               processing_fee = (1 * actual_amt * stripe_comm_per) / 100;
               amount_wp2 = actual_amt + processing_fee + stripe_comm_fix;
            }
         }

         amount_wp2 = amount_wp2.toFixed(2);

         $('#strip_btn_' + id).attr('onclick', 'show_lates_stripe_popup(' + amount_wp2 + ',' + actual_amt + ',8,' + id + ');');

         show_main_btn_two(id, amount2);
      } else {
         $('.card_' + id).hide();
         //$('.show_btn').prop('disabled',true);
         $('.instant-err_' + id).show();
         $('.instant-err_' + id).html('Deposit amount must be more than <i class="fa fa-gbp"></i>' + min_amount + ' and less than <i class="fa fa-gbp"></i>' + max_amount + '!');
         $('.pay_btns_' + id).hide();
      }
   }

   function show_main_btn_two(id, amount2) {
      $('.pay_btns_' + id).show();
      $('#paypal_btn_' + id).html('');

      var actual_amt = parseFloat(amount2);


      var type = <?= $this->session->userdata('type'); ?>;
      var paypal_comm_per = parseFloat(<?= $paypal_comm_per; ?>);
      var paypal_comm_fix = parseFloat(<?= $paypal_comm_fix; ?>);
      var processing_fee = 0;
      var amount_wp2 = actual_amt;

      if (type == 2) {
         if (paypal_comm_per > 0 || paypal_comm_fix > 0) {
            processing_fee = ((actual_amt * paypal_comm_per) / 100);
            var amount_wp2 = processing_fee + actual_amt + paypal_comm_fix;

         }
      }

      amount_wp2 = amount_wp2.toFixed(2);

      paypal.Button.render({
         env: '<?php echo $this->config->item('PayPal_ENV'); ?>',
         client: {
            sandbox: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>',
            production: '<?php echo $this->config->item('PayPal_CLIENT_ID'); ?>'
         },

         // Show the buyer a 'Pay Now' button in the checkout flow
         commit: true,

         // payment() is called when the button is clicked
         payment: function(data, actions) {

            // Make a call to the REST api to create the payment
            return actions.payment.create({
               payment: {
                  transactions: [{
                     amount: {
                        total: amount_wp2,
                        currency: 'GBP'
                     }
                  }]
               }
            });
         },

         // onAuthorize() is called when the buyer approves the payment
         onAuthorize: function(data, actions) {
            // Make a call to the REST api to execute the payment
            return actions.payment.execute().then(function() {
               console.log('Payment Complete!');
               $.ajax({
                  type: 'POST',
                  url: site_url + 'wallet/paypal_deposite',
                  data: {
                     itemPrice: amount2,
                     itemId: 'Deposit in wallet',
                     orderID: data.orderID,
                     txnID: data.paymentID,
                  },
                  dataType: 'JSON',
                  beforeSend: function() {
                     $('.pay_btns_' + id).hide();
                     $('.pay_btns_laoder_' + id).show();
                  },
                  success: function(resp) {
                     if (resp.status == 1) {
                        //location.reload();
                        //window.location.href=site_url+'Users/success/5/'+resp.tranId;
                        $('#accept_releaseMSForm' + id).submit();
                     } else {
                        $('.pay_btns_' + id).show();
                        $('.pay_btns_laoder_' + id).hide();
                        toastr.error(resp.msg);
                     }
                  }
               });
            });
         }
      }, '#paypal_btn_' + id);
   }

   function send_resend_request(id) {
      if (confirm("Are you sure you want to resend request?")) {
         $.ajax({
            type: 'POST',
            url: site_url + 'bids/send_resend_request/' + id,
            dataType: 'JSON',
            beforeSend: function() {
               $('.resend_btn' + id).html('<i class="fa fa-spin fa-spinner"></i>');
               $('.resend_btn' + id).prop('disabled', true);
            },
            success: function(resp) {
               $('.resend_btn' + id).html('Resend request');
               $('.resend_btn' + id).prop('disabled', false);
               if (resp.status == 1) {
                  swal('Resend request has been sent successfully.');
               } else {
                  swal('Something went wrong, please try again later.');
               }
            }
         });
      }
   }

   tinymce.init({
      selector: '.textarea',
      height: 200,
      plugins: [
         "advlist autolink lists link image charmap print preview anchor",
         "searchreplace visualblocks code fullscreen",
         "insertdatetime media table contextmenu paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      setup: function(editor) {
         editor.on('change', function() {
            tinymce.triggerSave();
         });
      }
   });

   function change_bank_transafer_url(amt) {
      $('.bkd_url').attr('href', site_url + 'wallet?bank-transfer=1&amount=' + amt);
   }

   function show_tradesment_profile(id) {
      $.ajax({
         type: 'post',
         url: site_url + 'users/show_tradesment_profile/' + id,
         beforeSend: function() {

         },
         success: function(res) {
            $('#View_profileman').html(res);
            $('#View_profileman').modal('show');
         }
      });
   }
   $('#View_profileman').on('hidden.bs.modal', function() {
      $('#View_profileman').html('');
   })
</script>
<div id="View_profileman" class="modal fade right_mddal" role="dialog"></div>