<?php include 'include/header.php';?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
    <p id="erre_id"></p>
  </section>
  <section class="content">
    <div class="row" id="das_id">
      <?php
          if (in_array(1, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <?php
                  $new_trades = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 1], 'id');
                  ?>
              <span class="info-box-text">Tradesmen<?php echo ($new_trades > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_trades . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('users', ['type' => 1], 'id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(2, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <?php
                  $new_homes = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 2], 'id');
                  ?>
              <span class="info-box-text">Homeowners<?php echo ($new_homes > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_homes . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('users', ['type' => 2], 'id'); ?></span>
            </div>
          </div>
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(15, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Subadmin</span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('admin', ['type' => 2], 'id'); ?></span>
            </div>
          </div>
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(9, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-file-image-o"></i></span>

            <div class="info-box-content">
              <?php
                  $new_jobs = $this->Common_model->check_admin_unread('tbl_jobs', ['is_admin_read' => 0], 'job_id');
                  ?>
              <span class="info-box-text">Total Job<?php echo ($new_jobs > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_jobs . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('tbl_jobs', ['status != ' => 0], 'job_id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      <?php
          }
      ?>

      <?php
          if (in_array(10, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
            <?php
                $new_dispute = $this->Common_model->check_admin_unread('tbl_dispute', ['is_admin_read' => 0], 'ds_id');
                ?>
            <div class="info-box-content">
              <span class="info-box-text">Total Job In Dispute                                                               <?php echo ($new_dispute > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_dispute . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('tbl_dispute', null, 'ds_id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(10, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Plans & Packages</span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('tbl_package', null, 'id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(3, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Category</span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('category', null, 'cat_id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(17, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
            <?php
                $new_with_req = $this->Common_model->check_admin_unread('tbl_withdrawal', ['is_admin_read' => 0, 'wd_status' => 0], 'wd_id');
                ?>
            <div class="info-box-content">
              <span class="info-box-text">Pending Withdrawal Request                                                                     <?php echo ($new_with_req > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_with_req . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('tbl_withdrawal', ['wd_status' => 0], 'wd_id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(5, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
            <?php
                $new_contact = $this->Common_model->check_admin_unread('contact_request', ['is_admin_read' => 0], 'id');
                ?>
            <div class="info-box-content">
              <span class="info-box-text">New Contact Request                                                              <?php echo ($new_contact > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $this->Common_model->get_data_count('contact_request', ['status' => 0], 'id'); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(1, $my_access) || in_array(2, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-file-text"></i></span>
            <?php
                $doct_1 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_status_add' => 2], ['count(id) as total']);

                    $doct_2 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_id_card_status' => 2], ['count(id) as total']);

                    $doct_3 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_status_insure' => 2], ['count(id) as total']);

                    $doct_11 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_status_add' => 1], ['count(id) as total']);

                    $doct_22 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_id_card_status' => 1], ['count(id) as total']);

                    $doct_33 = $this->Common_model->GetColumnName('users', ['type' => 1, 'u_status_insure' => 1], ['count(id) as total']);

                    $doc  = $doct_1['total'] + $doct_2['total'] + $doct_3['total'];
                    $doc2 = $doct_11['total'] + $doct_22['total'] + $doct_33['total'];
                ?>
            <div class="info-box-content">
              <span class="info-box-text">Account Verification Document                                                                        <?php echo ($doc2 > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $doc2 . '</span>' : ''; ?></span>
              <span class="info-box-number"><?php echo $doc; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(19, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>
            <?php
                $unreadMessages = $this->Common_model->check_admin_unread('admin_chat_details', ['is_read' => 0, 'is_admin' => 0], 'is_read');
                ?>
            <div class="info-box-content">
              <span class="info-box-text"> Message Center <?=($unreadMessages > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $unreadMessages . '</span>' : '';?></span>
              <?php
                  $totalMessages = $this->Common_model->newgetRows('admin_chats');
                  ?>
              <span class="info-box-number"><?=count($totalMessages);?></span>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
            <?php
                $affiliate = $this->Common_model->check_admin_unread('referrals_earn_list', ['referred_type' => 3], 'id');

                    $affiliate1       = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 3])->count_all_results();
                    $new_user_count_m = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 3], 'id');
                    $affiliate1       = $affiliate1 + $new_user_count_m;
                ?>
            <div class="info-box-content">
              <span class="info-box-text">Affiliate <?=($affiliate1 > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $affiliate1 . '</span>' : '';?></span>

              <span class="info-box-number"><?=$affiliate;?> </span>
            </div>
          </div>
        </div>
      <?php
          }
      ?>
<?php
    if (in_array(1, $my_access)) {
    ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <?php
                  $tradsm  = $this->Common_model->check_admin_unread('referrals_earn_list', ['referred_type' => 1], 'id');
                      $tradsm1 = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 1])->count_all_results();
                  ?>
              <span class="info-box-text">Tradesmen referrals <?=($tradsm1 > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $tradsm1 . '</span>' : '';?></span>
              <span class="info-box-number"><?=$tradsm;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(2, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <?php
                  $homeown  = $this->Common_model->check_admin_unread('referrals_earn_list', ['referred_type' => 2], 'id');
                      $homeown1 = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 2])->count_all_results();
                  ?>
              <span class="info-box-text">Homeowner referrals <?=($homeown1 > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $homeown1 . '</span>' : '';?></span>
              <span class="info-box-number"><?=$homeown;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(10, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-gavel"></i></span>
            <?php

                    $check_dispute  = $this->Common_model->GetColumnName('tbl_dispute', "ds_status = 0 and (select count(id) from ask_admin_to_step where ask_admin_to_step.dispute_id = tbl_dispute.ds_id) >= 2", ['count(ds_id) as total']);
                    $check_dispute2 = $this->Common_model->GetColumnName('tbl_dispute', "ds_status = 0 and (select count(id) from ask_admin_to_step where ask_admin_to_step.dispute_id = tbl_dispute.ds_id and ask_admin_to_step.is_admin_read = 0) >= 2", ['count(ds_id) as total']);
                ?>
            <div class="info-box-content">
              <span class="info-box-text">Ask to step in <?=($check_dispute2['total'] > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $check_dispute2['total'] . '</span>' : '';?></span>

              <span class="info-box-number"><?=$check_dispute['total'];?> </span>
            </div>
          </div>
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(1, $my_access)) {
          ?>
          <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <a href="<?php echo base_url('job_report') ?>" title="Flagged">
                  <span class="info-box-icon bg-yellow"><i class="fa fa-link"></i></span>
                </a>
                <div class="info-box-content">
                  <?php
                      $Flagged = $this->db->select('*')->from('report_job')->count_all_results();
                      ?>
                  <span class="info-box-text">Flagged<?php echo ($Flagged > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $Flagged . '</span>' : ''; ?></span></span>
                  <span class="info-box-number"><?=$Flagged;?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->

          </div>
      <?php
          }
      ?>

      <?php if (in_array(1, $my_access)) { ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#" title="Deleted Account">
              <span class="info-box-icon bg-red"><i class="fa fa-trash"></i></span>
            </a>
            <div class="info-box-content">
              <?php
              $deleteRequest = $this->db->select(['id','delete_request'])->from('delete_account_request')->where('delete_request',1)->count_all_results();
              ?>
              <span class="info-box-text">Deleted Account<?php echo ($deleteRequest > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $deleteRequest . '</span>' : ''; ?></span></span>
              <span class="info-box-number"><?=$deleteRequest;?></span>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
          if (in_array(10, $my_access)) {
          ?>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>           
            <div class="info-box-content">
              <?php
              $totalService = $this->db->select(['id'])->from('my_services')->count_all_results();
              ?>
              <span class="info-box-text">Service Listing</span>
              <span class="info-box-number"><?=$totalService;?> </span>
            </div>
          </div>
        </div>
      <?php
          }
      ?>

      <?php
          if (in_array(1, $my_access)) {
          ?>
          <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                  <?php
                      $serviceOrders = $this->db->select('*')->from('service_order')->count_all_results();
                      ?>
                  <span class="info-box-text">Orders</span></span>
                  <span class="info-box-number"><?=$serviceOrders;?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->

          </div>
      <?php
          }
      ?>

    </div>
  </section>
</div>
<?php include_once 'include/footer.php';?>