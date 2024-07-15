<?php
    $adminId   = $this->session->userdata('session_adminId');
    $admininfo = $this->Common_model->getRows('admin', $adminId);

    //$roles_array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

    $my_access = explode(',', $admininfo['roles']);
    // print_r($my_access);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=Project;?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>asset/admin/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/toastr.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/multiselect.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
  <!--link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/croppie.css" type="text/css" /-->


	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="shortcut icon" href="img/favi.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



  <script>
  $.widget.bridge('uibutton', $.ui.button);
  </script>
  <script src="<?php echo base_url(); ?>asset/admin/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

  <script>
  $(function(){
    $("#boottable").DataTable({
      ordering: false,
			stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
		});
		$(".DataTable").DataTable({
			stateSave: true
		});
  });
  </script>

 <!-- <script src="//cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script> -->




  <script src="<?php echo base_url(); ?>asset/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/fastclick/fastclick.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/dist/js/app.min.js"></script>


  <script src="<?php echo base_url(); ?>asset/admin/dist/js/demo.js"></script>
  <!--script type="text/javascript" src="<?php echo base_url(); ?>asset/admin/dist/js/croppie.js"></script-->
  <script src="<?php echo base_url(); ?>asset/admin/dist/js/toastr.min.js"></script>
  <script>
		var globalbase_url = '<?php echo base_url() ?>';
		var site_url = '<?php echo site_url() ?>';
	</script>

	<script src="<?php echo base_url(); ?>asset/admin/dist/js/scripts.js"></script>
	<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="<?php echo base_url() . 'Admin_dashboard'; ?>" class="logo" style="background: #3d78cb;">
        <span class="logo-mini"><img src="<?php echo base_url(); ?>img/logo.png" height="40"></span>
        <span class="logo-lg"><img src="<?php echo base_url(); ?>img/logo.png" height="40"></span>
      </a>
      <nav class="navbar navbar-static-top mu_uus">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<b><?=$admininfo['username'];?></b>
                <span class="hidden-xs"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <p><?=$admininfo['username'];?> </p>
									<p><?=$admininfo['email'];?></p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo base_url(); ?>Admin/Manage_profile" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url(); ?>Admin_logout" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel" style="display:inline-block; width:100%; display: none;">
          <div class="info">
            <p><?php //echo ucfirst($row['username']) ?></p>
          </div>
        </div>
        <ul class="sidebar-menu">
          <!-- <li class="header">MAIN NAVIGATION</li> -->
					<li class="DashboardManage">
						<a href="<?php echo base_url(); ?>Admin_dashboard">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<?php if (in_array(1, $my_access) or in_array(2, $my_access)) {
                        ?>
          <li class="us_er3">
            <a href="#">
							<?php
                                $new_user_count_h = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 2], 'id');
                                    $new_user_count_t = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 1], 'id');
                                    $new_user_count   = $new_user_count_h + $new_user_count_t;
                                ?>
              <i class="fa fa-list"></i> <span>User Management<?php echo ($new_user_count > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_user_count . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
							<?php if (in_array(1, $my_access)) {
                                        $new_trades = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.user_type' => 1])->count_all_results();
                                        $new_trades = $new_trades + $new_user_count_t;
                                    ?>
              <li><a href="<?php echo base_url(); ?>tradesmen_user"><i class="fa fa-circle-o"></i> Tradesmen users<?php echo ($new_trades > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_trades . '</span>' : ''; ?></a></li>
							<?php }?>
<?php if (in_array(2, $my_access)) {
            $new_homes = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.user_type' => 2])->count_all_results();
            $new_homes = $new_homes + $new_user_count_h;
        ?>
              <li><a href="<?php echo base_url(); ?>homeowners_users"><i class="fa fa-circle-o"></i> Homeowners users<?php echo ($new_homes > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_homes . '</span>' : ''; ?></a></li>
							<?php }?>
              <li><a href="<?php echo base_url(); ?>Admin/send-bulk-mail"><i class="fa fa-circle-o"></i> Send bulk mail</a></li>
            </ul>
          </li>
					<?php }?>

					<?php if (in_array(3, $my_access)) {?>

					<li class="us_er3">
            <a href="#">

              <i class="fa fa-list"></i> <span>Category Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>category"><i class="fa fa-circle-o"></i> Category</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/category-find-job"><i class="fa fa-circle-o"></i> Category (Find Job)</a></li>
              <li class=""><a href="<?php echo base_url(); ?>Admin/category-default-content"><i class="fa fa-circle-o"></i> Default content</a></li>

            </ul>
          </li>
					<?php }?>

					<?php if (in_array(4, $my_access)) {?>
          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>packages">
              <i class="fa fa-users"></i> <span>Packages</span>
            </a>
          </li>

					<li class="DashboardManage">
            <a href="<?php echo base_url(); ?>Admin/addons-management">
              <i class="fa fa-users"></i> <span>Package Addons</span>
            </a>
          </li>
					<?php }?>

          <?php if (in_array(21, $my_access)) {?>
					<li class="DashboardManage">
            <a href="<?php echo base_url(); ?>Admin/coupon-management">
              <i class="fa fa-gift"></i> <span>Coupon Management</span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(5, $my_access)) {
                        ?>

					<?php
                        $new_contact_h = $this->Common_model->check_admin_unread('contact_request', ['is_admin_read' => 0, 'type' => 2], 'id');

                            // $new_contact_m = $this->Common_model->check_admin_unread('contact_request',array('is_admin_read'=>0,'type'=>3),'id');

                            $new_contact_t = $this->Common_model->check_admin_unread('contact_request', ['is_admin_read' => 0, 'type' => 1], 'id');
                            $new_contact   = $this->Common_model->check_admin_unread('contact_request', ['is_admin_read' => 0], 'id');
                        ?>

					<li class="us_er3">
            <a href="#">
              <i class="fa fa-list"></i> <span>Contact Requests                                                                <?php echo ($new_contact > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>tradesmen_contacts"><i class="fa fa-circle-o"></i> Tradesmens Requests<?php echo ($new_contact_t > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact_t . '</span>' : ''; ?></a></li>
              <li><a href="<?php echo base_url(); ?>homeowners_contacts"><i class="fa fa-circle-o"></i> Homeowners Requests<?php echo ($new_contact_h > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact_h . '</span>' : ''; ?></a></li>

               <!-- <li><a href="<?php echo base_url(); ?>marketers-contacts"><i class="fa fa-circle-o"></i> Marketers Requests<?php echo ($new_contact_m > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact_m . '</span>' : ''; ?></a></li> -->
            </ul>
          </li>
					<?php }?>

					<?php if (in_array(6, $my_access)) {?>

					<li class="us_er3">
            <a href="#">
              <i class="fa fa-list"></i> <span>Region management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>admin_county"><i class="fa fa-circle-o"></i> County </a></li>
              <li><a href="<?php echo base_url(); ?>admin_city"><i class="fa fa-circle-o"></i> City</a></li>
              <!-- <li><a href="<?php echo base_url(); ?>Admin/incoming_user"><i class="fa fa-circle-o"></i> Incoming Users Requests</a></li>-->
            </ul>
          </li>

					<?php }?>

					<?php if (in_array(7, $my_access)) {?>
          <li class="us_er3">
            <a href="#">
              <i class="fa fa-pie-chart"></i> <span>Content Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>homepage_content"><i class="fa fa-circle-o"></i> Homepage Content</a></li>
              <li><a href="<?php echo base_url(); ?>blog_management"><i class="fa fa-circle-o"></i> Blog Management</a></li>
              <li><a href="<?php echo base_url(); ?>homepage_banner"><i class="fa fa-circle-o"></i> Homepage Banner</a></li>
              <li><a href="<?=base_url();?>cost_guide_management"><i class="fa fa-circle-o"></i> Cost Guide</a></li>
            </ul>
          </li>
					<?php }?>

					<?php if (in_array(13, $my_access)) {
                        ?>

					<?php
                        $new_trans = $this->Common_model->check_admin_unread('transactions', ['is_admin_read' => 0], 'tr_id');
                        ?>
          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>users_transactions">
              <i class="fa fa-money"></i> <span>Transaction History                                                                    <?php echo ($new_trans > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_trans . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(8, $my_access)) {
                        ?>

					<?php
                        $new_plans = $this->Common_model->check_admin_unread('user_plans', ['is_admin_read' => 0], 'up_id');
                        ?>

          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>user_plans">
              <i class="fa fa-tasks"></i> <span>User Plans                                                           <?php echo ($new_plans > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_plans . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>


					<?php if (in_array(9, $my_access)) {
                        ?>

					<?php
                        $new_jobs = $this->Common_model->check_admin_unread('tbl_jobs', ['is_admin_read' => 0], 'job_id');

                            $new_bides = $this->Common_model->check_admin_unread('tbl_jobpost_bids', ['is_admin_read' => 0], 'id');
                        ?>

          <li class="us_er3">
            <a href="#">
              <i class="fa fa-pie-chart"></i> <span>Job Management                                                                   <?php echo ($new_jobs > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_jobs . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
							<li class="DashboardManage">
                <a href="<?=base_url();?>Admin/create-post">
                  <i class="fa fa-tasks"></i> <span>Post a job</span>
                </a>
              </li>
              <li class="DashboardManage">
                <a href="<?php echo base_url(); ?>user_jobs">
                  <i class="fa fa-tasks"></i> <span>Job Posts                                                              <?php echo ($new_jobs > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_jobs . '</span>' : ''; ?></span>
                </a>
              </li>

              <li class="DashboardManage">
                <a href="<?php echo base_url(); ?>user_bid_jobs">
                  <i class="fa fa-tasks"></i> <span>Bids on Posts                                                                  <?php echo ($new_bides > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_bides . '</span>' : ''; ?></span>
                </a>
              </li>

              <li class="DashboardManage" style="display:none;">
                <a href="<?=base_url();?>Admin/edit-post">
                  <i class="fa fa-tasks"></i> <span>Post Management</span>
                </a>
              </li>
							<li class="DashboardManage">
                <a href="<?=base_url();?>Admin/send-emails">
                  <i class="fa fa-tasks"></i> <span>Send Emails</span>
                </a>
              </li>
							<li class="DashboardManage">
                <a href="<?=base_url();?>Admin/generate-html">
                  <i class="fa fa-tasks"></i> <span>Generate HTML</span>
                </a>
              </li>
							<li class="DashboardManage">
                <a href="<?=base_url();?>Admin/job-amount">
                  <i class="fa fa-tasks"></i> <span>Job Amount</span>
                </a>
              </li>
            </ul>
          </li>
					<?php }?>
<?php if (in_array(18, $my_access)) {
    ?>

					<?php
                        $new_rating = $this->Common_model->check_admin_unread('rating_table', ['is_admin_read' => 0], 'tr_id');
                        ?>

          <li class="DashboardManage">
            <a href="<?=base_url();?>ratings_management">
              <i class="fa fa-star"></i> <span>Ratings Management                                                                  <?php echo ($new_rating > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_rating . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>
<?php if (in_array(12, $my_access)) {?>
					<li class="DashboardManage">
            <a href="<?php echo base_url(); ?>payment_setting">
              <i class="fa fa-money"></i> <span>Payment Settings</span>
            </a>
          </li>
					<?php }?>
<?php if (in_array(16, $my_access)) {
    ?>

					<?php
                        $new_bank_trng = $this->Common_model->check_admin_unread('bank_transfer', ['is_admin_read' => 0], 'id');
                        ?>

					<li class="DashboardManage">
            <a href="<?php echo base_url(); ?>bank-transfer-request">
              <i class="fa fa-money"></i> <span>Bank Transfer Request                                                                      <?php echo ($new_bank_trng > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_bank_trng . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(14, $my_access)) {
                        ?>

					<?php
                        $new_with_req = $this->Common_model->check_admin_unread('tbl_withdrawal', ['is_admin_read' => 0], 'wd_id');
                        ?>

          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>withdrawal_history">
              <i class="fa fa-money"></i> <span>Withdrawal Request                                                                   <?php echo ($new_with_req > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_with_req . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(10, $my_access)) {
                        ?>

					<?php
                        $new_dispute    = $this->Common_model->check_admin_unread('tbl_dispute', ['is_admin_read' => 0], 'ds_id');
                            $check_dispute2 = $this->Common_model->GetColumnName('tbl_dispute', "ds_status = 0 and (select count(id) from ask_admin_to_step where ask_admin_to_step.dispute_id = tbl_dispute.ds_id and ask_admin_to_step.is_admin_read = 0) >= 2", ['count(ds_id) as total']);
                        ?>

        <li class="us_er3">
            <a href="#">
              <i class="fa fa-gavel"></i> <span>Dispute Management                                                                   <?php echo (($new_dispute + $check_dispute2['total']) > 0) ? '<span style="background:red;color:#fff;" class="badge">' . ($new_dispute + $check_dispute2['total']) . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
							<li class="DashboardManage">
              <a href="<?php echo base_url(); ?>dispute">
                <i class="fa fa-money"></i> <span>Dispute List                                                               <?php echo ($new_dispute > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_dispute . '</span>' : ''; ?></span>
              </a>
              </li>
              <li class="DashboardManage">
                <a href="<?php echo base_url(); ?>Admin/ask-step-in">
                  <i class="fa fa-tasks"></i> <span>Ask Step In                                                                <?php echo ($check_dispute2['total'] > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $check_dispute2['total'] . '</span>' : ''; ?></span>
                </a>
              </li>

            </ul>
          </li>

					<?php }?>

					<?php if (in_array(11, $my_access)) {?>
					<li class="DashboardManage">
            <a href="<?php echo base_url(); ?>user_rewards">
              <i class="fa fa-money"></i> <span>Rewards</span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(15, $my_access)) {?>
          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>sub_admin">
              <i class="fa fa-tasks"></i> <span>Sub Admin</span>
            </a>
          </li>
					<?php }?>

					<?php if (in_array(17, $my_access)) {
                        ?>
<?php
    $new_fund_with = $this->Common_model->check_admin_unread('homeowner_fund_withdrawal', ['is_admin_read' => 0], 'id');
    ?>
          <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>Admin/homeowner-fund-withdrawal">
              <i class="fa fa-tasks"></i> <span>Homeowners Refund                                                                  <?php echo ($new_fund_with > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_fund_with . '</span>' : ''; ?></span>
            </a>
          </li>
					<?php }?>

          <?php
              if (in_array(19, $my_access)) {
                  // $unreadMessages = $this->Common_model->check_admin_unread('admin_chat_details', array('is_read' => 0, 'is_admin' => 0), 'is_read');
                  $unreadMessages = $this->My_model->get_unread_support_msg_count();
              ?>
						<li class="DashboardManage">
							<a href="<?=base_url('Admin/Chats');?>">
								<i class="fa fa-list"></i> <span> Message Center <?=($unreadMessages > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $unreadMessages . '</span>' : '';?> </span>
							</a>
						</li>
          <?php
              }
          ?>
<?php if (in_array(1, $my_access)) {
    ?>
          <li class="us_er3">
            <a href="#">
              <?php

                      $unreadMessages1    = $this->My_model->get_unread_support_msg_count(3);
                      $afi_pending_payout = $this->Common_model->get_marketer_payouts_pending(3);
                      $affiliate          = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 3])->count_all_results();

                      $new_user_count_m = $this->Common_model->check_admin_unread('users', ['is_admin_read' => 0, 'type' => 3], 'id');

                      // $total_afiliate_request = $affiliate + $afi_pending_payout + $unreadMessages1 + $new_user_count_m;
                      $total_afiliate_request = 0;
                      $affiliate              = $affiliate + $new_user_count_m;
                      // $new_contact_m = $this->Common_model->check_admin_unread('contact_request',array('is_admin_read'=>0,'type'=>3),'id');

                  ?>
              <i class="fa fa-pie-chart"></i> <span>Affiliate<?php echo ($total_afiliate_request > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $total_afiliate_request . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>affiliaters"><i class="fa fa-circle-o"></i>Affiliters<?php echo ($affiliate > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $affiliate . '</span>' : ''; ?></a></li>
              <li><a href="<?php echo base_url(); ?>Admin/marketers-sharable-link"><i class="fa fa-circle-o"></i>Shareable Links</a></li>
              <li><a href="<?php echo base_url(); ?>payouts"><i class="fa fa-circle-o"></i> Pay Outs<?php echo ($afi_pending_payout > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $afi_pending_payout . '</span>' : ''; ?></a></li>
              <li><a href="<?php echo base_url(); ?>Admin/marketers-setting"><i class="fa fa-circle-o"></i>Affiliate setting</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/affiliate-metadata"><i class="fa fa-circle-o"></i> Affiliate metadata</a></li>

               <!-- <li><a href="<?php echo base_url(); ?>marketers-contacts"><i class="fa fa-circle-o"></i> Affiliate Support<?php echo ($new_contact_m > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $new_contact_m . '</span>' : ''; ?></a></li> -->
               <li><a href="<?php echo base_url('Admin/Chats?m=1'); ?>"><i class="fa fa-circle-o"></i> Affiliate Support<?php echo ($unreadMessages1 > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $unreadMessages1 . '</span>' : ''; ?></a></li>
            </ul>
          </li>
        <?php }?>
<?php if (in_array(2, $my_access)) {
    ?>
          <li class="us_er3">
            <a href="#">
              <?php
                  $homeown_pending_payout = $this->Common_model->get_marketer_payouts_pending(2);                  

                      $homeown            = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 2])->count_all_results();
                      // $total_home_request = $homeown + $homeown_pending_payout;
                      $total_home_request = 0;
                  ?>
              <i class="fa fa-pie-chart"></i> <span>Homeowner referrals<?php echo ($total_home_request > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $total_home_request . '</span>' : ''; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>Admin/homeowner-sharable"><i class="fa fa-circle-o"></i>Shareable Links</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/homeowner-invertees"><i class="fa fa-circle-o"></i>Invertees<?php echo ($homeown > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $homeown . '</span>' : ''; ?> </a></li>
              <li><a href="<?php echo base_url(); ?>payouts?v=h"><i class="fa fa-circle-o"></i> Pay Outs<?php echo ($homeown_pending_payout > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $homeown_pending_payout . '</span>' : ''; ?></a></li>
              <li><a href="<?php echo base_url(); ?>Admin/homeowner-setting"><i class="fa fa-circle-o"></i>Homeowner setting</a></li>
            </ul>
          </li>
        <?php }?>
<?php if (in_array(1, $my_access)) {
    ?>
<?php
    $tradesman_pending_payout = $this->Common_model->get_marketer_payouts_pending(1);
        $tradsm               = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read' => 0, 'referrals_earn_list.referred_type' => 1])->count_all_results();
        $total_trads_request  = $trads_pending_payout + $tradsm;

    ?>
          <li class="us_er3">

            <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Tradesman referrals                                                                          <?php echo ($total_trads_request > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $total_trads_request . '</span>' : ''; ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>Admin/tradesman-sharable"><i class="fa fa-circle-o"></i>Shareable Links</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/tradesman-invertees"><i class="fa fa-circle-o"></i>Invertees <span><?php echo ($tradsm > 0) ? '<span style="background:red;color:#fff;" class="badge">' . $tradsm . '</span>' : ''; ?></span></a></li>
              <li><a href="<?php echo base_url(); ?>payouts?v=t"><i class="fa fa-circle-o"></i> Pay Outs <?php echo ($tradesman_pending_payout > 0) ?  '<span style="background:red;color:#fff;" class="badge">'.$tradesman_pending_payout.'</span>' : '';?></a></li>
              <li><a href="<?php echo base_url(); ?>Admin/tradesman-setting"><i class="fa fa-circle-o"></i>Tradesman setting</a></li>
            </ul>
          </li>
          <?php }?>

          <?php if (in_array(1, $my_access)) {
              ?>
<?php
    $Flagged = $this->db->select('*')->from('report_job')->count_all_results();
    ?>
          <li class="us_er3">
            <a href="#">
                <i class="fa fa-exclamation-triangle"></i> <span>Flagged                                                                                                                                                                                                                                                                                      <?php echo ($Flagged > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $Flagged . '</span>' : ''; ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>job_report"><i class="fa fa-circle-o"></i>Job<?php echo ($Flagged > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $Flagged . '</span>' : ''; ?></a> </li>
            </ul>
          </li>
          <?php }?>

          <?php
            if (in_array(1, $my_access)) {
              $tradesmanRequest = $this->db->select(['id','user_type','delete_request'])->from('delete_account_request')->where('user_type',1)->where('delete_request',1)->count_all_results();
              $homeownerRequest = $this->db->select(['id','user_type','delete_request'])->from('delete_account_request')->where('user_type',2)->where('delete_request',1)->count_all_results();
              $totalRequest = $tradesmanRequest + $homeownerRequest;
          ?>
            <li class="us_er3">
              <a href="#">
                <i class="fa fa-trash"></i> <span>Delete Account <?php echo ($totalRequest > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $totalRequest . '</span>' : ''; ?></span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url(); ?>deleted_accounts?user=1"><i class="fa fa-circle-o"></i>Trades Man<?php echo ($tradesmanRequest > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $tradesmanRequest . '</span>' : ''; ?></a> </li>
                <li><a href="<?php echo base_url(); ?>deleted_accounts?user=2"><i class="fa fa-circle-o"></i>Home Owner<?php echo ($homeownerRequest > 0) ? ' <span style="background:red;color:#fff;" class="badge">' . $homeownerRequest . '</span>' : ''; ?></a> </li>
              </ul>
            </li>
          <?php }?>

         <!--  <li class="us_er3">
            <a href="#">
              <i class="fa fa-pie-chart"></i> <span>Referral</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>refferals"><i class="fa fa-circle-o"></i>Referrals</a></li>
              <li><a href="<?php echo base_url(); ?>pending_referral_payouts"><i class="fa fa-circle-o"></i>Pending Pay Outs</a></li>
              <li><a href="<?php echo base_url(); ?>approved_referral_payouts"><i class="fa fa-circle-o"></i>Approved Pay Outs</a></li>
              <li><a href="<?php echo base_url(); ?>reject_referral_payouts"><i class="fa fa-circle-o"></i>Rejected Pay Outs</a></li>
            </ul>
          </li> -->
         <!--  <li class="DashboardManage">
            <a href="/<?php echo base_url(); ?>marketer_refferals">
              <i class="fa fa-tasks"></i> <span>Marketer Refferal</span>
            </a>
          </li>  -->

          <!-- <li class="DashboardManage">
            <a href="<?php echo base_url(); ?>admin_settings">
              <i class="fa fa-tasks"></i> <span>Settings</span>
            </a>
          </li> -->
          <!-- <li class="us_er3">
            <a href="#">
              <i class="fa fa-pie-chart"></i> <span>Sharable Links</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url(); ?>Admin/marketers-sharable"><i class="fa fa-circle-o"></i>Marketers Sharable Links</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/homeowner-sharable"><i class="fa fa-circle-o"></i> Homeowner Sharable Links</a></li>
              <li><a href="<?php echo base_url(); ?>Admin/tradesman-sharable"><i class="fa fa-circle-o"></i> Tradesman Sharable Links</a></li>
            </ul>
          </li> -->


          <!--li class="DashboardManage">
            <a href="<?php echo base_url(); ?>local-category">
              <i class="fa fa-tasks"></i> <span> Local Category</span>
            </a>
          </li-->


				</ul>
      </section>
    </aside>