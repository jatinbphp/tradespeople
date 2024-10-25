<?php
include_once('include/header.php');
if (!in_array(10, $my_access)) {
  redirect('Admin_dashboard');
}

$Claimant = $this->Common_model->GetColumnName('users', array('id' => $dispute['disputed_by']), array('f_name', 'l_name', 'type', 'trading_name', 'profile'));

$showStepIn = false;
$new = date('Y-m-d H:i:s');
if ($checkOtherUserReply) {
  $stepINTime = date('Y-m-d H:i:s', strtotime($checkOtherUserReply['dct_created'] . ' +' . $setting['step_in_day'] . ' days'));
  if (strtotime($stepINTime) > strtotime($new)) {
    $diff = date_difference($new, $stepINTime);
    $timeString = '';
    if ($diff['days'] > 0) {
      $timeString .= $diff['days'] > 1 ? $diff['days'] . ' days ' : $diff['days'] . ' day ';
    } else if ($diff['hours'] > 0) {
      $timeString .= $diff['hours'] > 1 ? $diff['hours'] . ' hours ' : $diff['hours'] . ' hour ';
      $timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
    } else if ($diff['minutes'] > 0) {
      $timeString .= $diff['minutes'] > 1 ? $diff['minutes'] . ' minutes ' : $diff['minutes'] . ' minute ';
    }

    if ($timeString) {
      $showStepIn = '<h3 class="text-primary text-center">' . $timeString . '</h3><h5 class="text-primary text-center">left to ask admin to step in</h5>';
    } else {
      $showStepIn = '<h3 class="text-primary text-center">' . (strtotime($stepINTime) - strtotime($new)) . ' Seconds</h3><h5 class="text-primary text-center">left to ask admin to step in</h5>';
    }
  }
}
?>
<style type="text/css">
 .tox-toolbar__primary,
  .tox-editor-header {
    display: none !important;
  }

  .p-0 {padding: 0!important } .p-1 {padding: .25rem!important } .p-2 {padding: .5rem!important } .p-3 {padding: 1rem!important } .p-4 {padding: 1.5rem!important } .p-5 {padding: 3rem!important } .px-0 {padding-right: 0!important; padding-left: 0!important } .px-1 {padding-right: .25rem!important; padding-left: .25rem!important } .px-2 {padding-right: .5rem!important; padding-left: .5rem!important } .px-3 {padding-right: 1rem!important; padding-left: 1rem!important } .px-4 {padding-right: 1.5rem!important; padding-left: 1.5rem!important } .px-5 {padding-right: 3rem!important; padding-left: 3rem!important } .py-0 {padding-top: 0!important; padding-bottom: 0!important } .py-1 {padding-top: .25rem!important; padding-bottom: .25rem!important } .py-2 {padding-top: .5rem!important; padding-bottom: .5rem!important } .py-3 {padding-top: 1rem!important; padding-bottom: 1rem!important } .py-4 {padding-top: 1.5rem!important; padding-bottom: 1.5rem!important } .py-5 {padding-top: 3rem!important; padding-bottom: 3rem!important } .pt-0 {padding-top: 0!important } .pt-1 {padding-top: .25rem!important } .pt-2 {padding-top: .5rem!important } .pt-3 {padding-top: 1rem!important } .pt-4 {padding-top: 1.5rem!important } .pt-5 {padding-top: 3rem!important } .pe-0 {padding-right: 0!important } .pe-1 {padding-right: .25rem!important } .pe-2 {padding-right: .5rem!important } .pe-3 {padding-right: 1rem!important } .pe-4 {padding-right: 1.5rem!important } .pe-5 {padding-right: 3rem!important } .pb-0 {padding-bottom: 0!important } .pb-1 {padding-bottom: .25rem!important } .pb-2 {padding-bottom: .5rem!important } .pb-3 {padding-bottom: 1rem!important } .pb-4 {padding-bottom: 1.5rem!important } .pb-5 {padding-bottom: 3rem!important } .ps-0 {padding-left: 0!important } .ps-1 {padding-left: .25rem!important } .ps-2 {padding-left: .5rem!important } .ps-3 {padding-left: 1rem!important } .ps-4 {padding-left: 1.5rem!important } .ps-5 {padding-left: 3rem!important }
 .m-0 {margin: 0!important } .m-1 {margin: .25rem!important } .m-2 {margin: .5rem!important } .m-3 {margin: 1rem!important } .m-4 {margin: 1.5rem!important } .m-5 {margin: 3rem!important } .m-auto {margin: auto!important } .mx-0 {margin-right: 0!important; margin-left: 0!important } .mx-1 {margin-right: .25rem!important; margin-left: .25rem!important } .mx-2 {margin-right: .5rem!important; margin-left: .5rem!important } .mx-3 {margin-right: 1rem!important; margin-left: 1rem!important } .mx-4 {margin-right: 1.5rem!important; margin-left: 1.5rem!important } .mx-5 {margin-right: 3rem!important; margin-left: 3rem!important } .mx-auto {margin-right: auto!important; margin-left: auto!important } .my-0 {margin-top: 0!important; margin-bottom: 0!important } .my-1 {margin-top: .25rem!important; margin-bottom: .25rem!important } .my-2 {margin-top: .5rem!important; margin-bottom: .5rem!important } .my-3 {margin-top: 1rem!important; margin-bottom: 1rem!important } .my-4 {margin-top: 1.5rem!important; margin-bottom: 1.5rem!important } .my-5 {margin-top: 3rem!important; margin-bottom: 3rem!important } .my-auto {margin-top: auto!important; margin-bottom: auto!important } .mt-0 {margin-top: 0!important } .mt-1 {margin-top: .25rem!important } .mt-2 {margin-top: .5rem!important } .mt-3 {margin-top: 1rem!important } .mt-4 {margin-top: 1.5rem!important } .mt-5 {margin-top: 3rem!important } .mt-auto {margin-top: auto!important } .me-0 {margin-right: 0!important } .me-1 {margin-right: .25rem!important } .me-2 {margin-right: .5rem!important } .me-3 {margin-right: 1rem!important } .me-4 {margin-right: 1.5rem!important } .me-5 {margin-right: 3rem!important } .me-auto {margin-right: auto!important } .mb-0 {margin-bottom: 0!important } .mb-1 {margin-bottom: .25rem!important } .mb-2 {margin-bottom: .5rem!important } .mb-3 {margin-bottom: 1rem!important } .mb-4 {margin-bottom: 1.5rem!important } .mb-5 {margin-bottom: 3rem!important } .mb-auto {margin-bottom: auto!important }
  .step-main {
    background: #fff;
    margin-top: 15px;
    border: 1px solid #e1e1e1;
  }

  .files {
    margin: 0px;
    padding: 0px;
  }

  .step-main .col-sm-6.text-center {
    position: relative;
    min-height: 210px;
    padding-bottom: 100px;
  }

  /*.myBtag {
    padding: 5px;
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    white-space: normal;
      width: 90%;
    cursor: context-menu;
  }*/

  .myBtag {
    padding: 5px;
    color: #fff;
    position: absolute;
    bottom: 0px;
    left: 50%;
    background: #3d78cb;
    border-radius: 5px;
    font-size: 11px;
    transform: translateX(-50%);
    width: 88%;
    font-weight: 500;
    font-style: italic;
    white-space: break-spaces;
  }

  .btn-mytab-1 {
    position: absolute;
    bottom: 9px;
    left: 20px;
  }
  .reply-btn {
    margin-bottom: 10px;
  }
  .border-top{
      border-top: 1px solid #c5c5c5;
  }
  .border_dashed_top{
      border-bottom: 1px dashed #c5c5c5;
  }
  .border_dashed_bottom{
      border-bottom: 1px dashed #c5c5c5;
  }
  .btn_show_milestone {
    font-style: italic;
    cursor: pointer;
    margin-bottom: 10px;
}
.font-bold {
    font-weight: 600;
}

.ShowMilestones{
      width: 70%;
      margin: 0 auto;
  }
  .ShowMilestones ul {
      padding: 0;
  }
  .ShowMilestones ul li {
      display: flex;
      gap: 8px;
  }
  .ShowMilestones ul li p{
    margin: 0;
  }
  .p_left{
    text-align: right;
    width: 30%;
  }
  .p_right{
    text-align: left;
		width: 70%;
  }
  .mx-auto{
    margin-right: auto;
    margin-left: auto;
  }
  .w-70{
    width: 70%
  }
 /* .panel-success>.panel-heading {
		color: #3c763d;
		background-color: #FEE0CC !important;
	}
	.panel-success>.panel-body {
		color: #3c763d;
		background-color: #FFEFE4 !important;
	}*/


  .btn-mytab-1 a{margin-top:5px;}
	.top_manin_he1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.top-project-status{
	margin:0;
}

.step-main {
    padding: 0 15px;
}

.dispute.d_sm_block {
    display: none;
}

	@media screen and (max-width:767px) {
		.treadman_50{
			display: flex;
    justify-content: center;
    align-items: flex-start;
		}
		.treadman_50 .col-sm-6{
			width:50%;
		}
		.btn-mytab-1 {
			display: flex;
   			 justify-content: center;
    		align-items: center;
			gap:5px;
			width:100%;
			flex-wrap:wrap;
		}
		.width-40{
			width:80%;
			float:left;
			margin-left:5%;
		}


    .dispute.d_sm_block {
        display: block;
    }
    .row.row_for_mobile {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        flex-flow: column-reverse;
    }
    .step-main {
        margin-top: 0px;
    }
    .d_lg_block {
        display: none;
    }
    h1.heading-inner.d_sm_block {
        font-size: 25px;
        padding: 0 15px;
    }
    .dis-section {
        margin-top: 20px;
    }
	}
	@media screen and (max-width:600px){
		.width-40{
			width:70%;
			margin-left:5%;
		}
		.btn-mytab-1{
			justify-content: unset;
			gap:0;
			width: unset ;
		}
	}
	@media screen and (max-width:375px){
		.width-40{
			margin-left:0;
		}
	}
</style>
<div class="content-wrapper">
  <section class="content-header">

    <h1>Dispute Detail</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dispute Detail</li>
    </ol>
  </section>
  <section class="content">
    
      <div class="col-xs-12 p-0">
        <div class="box">
          <div class="box-body">
            <div class="row row_for_mobile">
            <?php if ($dispute) { ?>
              <div class="col-sm-8">
                <div class="manage-profile">
                  <!--<h1 class="heading-inner">DISPUT CONVERSATION</h1>-->
                  <p><?php echo $this->session->flashdata('msg'); ?></p>

                  <div class="inner-box">
                    <div class="inner-body">
                      <div class="dispute">
                        <div class="">
                          <div class="lislll_ideaa d_lg_block">
                            <div class="listr_uuusdisp2">
                              
                              <p>Claimant: <span class="bol_c2 pull-right"><?php echo ($Claimant['type'] == 2) ? $Claimant['f_name'] . ' ' . $Claimant['l_name'] : $Claimant['trading_name']; ?></span></p>

                              <p>Client: <span class="bol_c2 pull-right"><?php echo $owner['f_name'] . ' ' . $owner['l_name']; ?></span></p>

                              <p>Tradesperson: <span class="bol_c2 pull-right"><?php echo $tradmen['trading_name']; ?></span></p>

                              <p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>
                              <p>Case status: <span class="bol_c2 pull-right">
                                  <?php if ($dispute['ds_status'] == '0') {
                                    echo 'Open';
                                  } else {
                                    echo 'Closed';
                                  }; ?>
                                </span></p>
                              <?php if ($dispute['ds_status'] == '1') { ?>
                                <p>Decided in: <span class="bol_c2 pull-right">
                                    <?php
                                    $favorOf = $this->Common_model->GetColumnName('users', array('id' => $dispute['ds_favour']), array('f_name', 'l_name', 'type', 'trading_name'));


                                    $winner = ($favorOf['type'] == 2) ? $favorOf['f_name'] . ' ' . $favorOf['l_name'] : $favorOf['trading_name'];


                                    echo $winner . ' favour';
                                    ?>
                                  </span>
                                </p>
                              <?php } ?>
                            </div>

                          </div>

                          <div class="dis-section">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="dis_div chan_dess">
                                  <div class="user-imge">
                                    <?php
                                    if ($Claimant['profile']) {
                                      $profile = $Claimant['profile'];
                                    } else {
                                      $profile = "dummy_profile.jpg";
                                    }
                                    ?>
                                    <img src="<?php echo site_url('img/profile/' . $profile); ?>">
                                  </div>
                                  <div class="panel panel-default panel-final">
                                    <div class="panel-heading">
                                      <h1>
                                        Claimant:
                                      </h1>

                                      <p class="rbefff1"><?php echo $owner['f_name'] . ' ' . $owner['l_name']; ?></p>
                                    </div>
                                    <div class="panel-body">
                                      <?php echo $dispute['ds_comment']; ?>
                                      <br>
                                      <?php echo $dispute['reason2'];
                                      if (!empty($files)) {
                                        foreach ($files as $file) {
                                          echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
                                        }
                                      } ?>

                                    </div>
                                    <div class="panel-heading">

                                    </div>
                                  </div>
                                </div>
                                <!--loop-->
                                <?php
                                if ($disput_comment) {
                                  $k = 1;
                                  $profile = "dummy_profile.jpg";
                                  foreach ($disput_comment as $value) {
                                    $class = "default";
                                    if ($value['dct_isfinal'] == 1) {
                                      //$class = "success";
                                    }
                                    if ($value['dct_userid'] == 0) {

                                      $profile = 'admin-img.png';
                                      $name = 'Dispute team';
                                   
                                    } else {
                                      $user = $this->Common_model->get_userDataByid($value['dct_userid']);

                                      if ($user['profile']) {
                                        $profile = $user['profile'];
                                      } else {
                                        $profile = 'dummy_profile.jpg';
                                      }
                                      $name = ($user['type'] == 1) ? $user['trading_name'] : $user['f_name'] . ' ' . $user['l_name'];
                                    }
                                    $c_files = $this->Common_model->get_all_data('dispute_file',"dispute_id = '".$dispute['ds_id']."' and conversation_id = '".$value['dct_id']."'", 'id', 'ASC');
                                ?>
                                    <div class="dis_div chan_dess">

                                      <div class="user-imge">
                                        <?php if ($profile) { ?>
                                          <img src="<?php echo site_url('img/profile/' . $profile); ?>">
                                        <?php } ?>
                                      </div>
                                      <div class="panel panel-<?php echo $class; ?> panel-final">
                                        <div class="panel-heading" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FEE0CC"' : '' ?> >
                                          <h1>
                                            <?php echo $name; ?>
                                            <?php if ($value['dct_isfinal'] == 1 && $value['is_reply_pending'] == 1) { ?>
                                              <span class="ddell">Deadline: No reply</span>
                                            <?php } ?>
                                          </h1>
                                          
                                        </div>
                                        <div class="panel-body" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FFEFE4"' : '' ?>>
                                          <?php echo  $value['dct_msg']; ?> <br><br>
                                          <?php if (!empty($c_files)) {
																				foreach ($c_files as $file) {
																					echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
																				}
																			} ?>
                                        </div>
                                        <div class="panel-heading" <?= ($value['dct_isfinal'] == 1) ? 'style="background:#FEE0CC"' : '' ?>>
                                          <h3>
                                            <?php
                                            if ($value['message_to'] != 0) {
                                              $reply_to = $this->Common_model->GetColumnName('users', array('id' => $value['message_to']), array('f_name', 'l_name', 'type', 'trading_name'));
                                            ?>
                                              <p class="rrrdd">
                                                Message for: <?php echo ($reply_to['type'] == 2) ? $reply_to['f_name'] . ' ' . $reply_to['l_name'] : $reply_to['trading_name']; ?>,
                                                <?php if ($value['is_reply_pending'] == 1) { ?>
                                                  reply before: <?php echo date('d M Y h:i:s A', strtotime($value['end_time'])); ?>
                                                <?php } ?>
                                              </p>
                                            <?php } ?>
                                            <span class="pull-right"><?php echo date('d-M-Y h:i:s A', strtotime($value['dct_created'])); ?></span>
                                          </h3>
                                        </div>
                                      </div>
                                    </div>
                                <?php $k++;
                                  }
                                } ?>

<?php
                                if ($disput_comment_arbitration) {
                                  $k = 1;
                                  $profile = "dummy_profile.jpg";
                                  foreach ($disput_comment_arbitration as $value) {
                                    $class = "default";
                                    if ($value['dct_isfinal'] == 1) {
                                      $class = "success";
                                    }
                                    $profile = 'admin-img.png';
                                    $name = 'Arbitrate team';
                                    $c_files = $this->Common_model->get_all_data('dispute_file',"dispute_id = '".$dispute['ds_id']."' and conversation_id = '".$value['dct_id']."'", 'id', 'ASC');
                                ?>
                                    <div class="dis_div chan_dess">

                                      <div class="user-imge">
                                        <?php if ($profile) { ?>
                                          <img src="<?php echo site_url('img/profile/' . $profile); ?>">
                                        <?php } ?>
                                      </div>
                                      <div class="panel panel-<?php echo $class; ?> panel-final">
                                        <div class="panel-heading" style="background:#FEE0CC">
                                          <h1>
                                            <?php echo $name; ?>
                                            <?php if ($value['dct_isfinal'] == 1 && $value['is_reply_pending'] == 1) { ?>
                                              <span class="ddell">Deadline: No reply</span>
                                            <?php } ?>
                                          </h1>
                                          
                                          
                                        </div>
                                        <div class="panel-body" style="background:#FFEFE4">
                                          <?php echo  $value['dct_msg']; ?> <br><br>
                                          <?php if (!empty($c_files)) {
																				foreach ($c_files as $file) {
																					echo '<p class="files"><a target="_blank" download href="' . base_url($file['file']) . '">' . $file['original_name'] . '</a></p>';
																				}
																			} ?>
                                        </div>
                                        <div class="panel-heading" style="background:#FEE0CC">
                                          <h3>
                                            <?php
                                            if ($value['message_to'] != 0) {
                                              $reply_to = $this->Common_model->GetColumnName('users', array('id' => $value['message_to']), array('f_name', 'l_name', 'type', 'trading_name'));
                                            ?>
                                              <p class="rrrdd">
                                                Message for: <?php echo ($reply_to['type'] == 2) ? $reply_to['f_name'] . ' ' . $reply_to['l_name'] : $reply_to['trading_name']; ?>,
                                                <?php if ($value['is_reply_pending'] == 1) { ?>
                                                  reply before: <?php echo date('d M Y h:i:s A', strtotime($value['end_time'])); ?>
                                                <?php } ?>
                                              </p>
                                            <?php } ?>
                                            <span class="pull-right"><?php echo date('d-M-Y h:i:s A', strtotime($value['dct_created'])); ?></span>
                                          </h3>
                                        </div>
                                      </div>
                                    </div>
                                <?php $k++;
                                  }
                                } ?>
                                <!--loop-->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="reppll">



                      <?php if ($dispute['ds_status'] == '0') { ?>
                        <div class="reply-btn">

                          <a class="btn btn-info pull-right m-2" data-toggle="modal" data-target="#disputework">Reply</a> &nbsp;
                          <a class="btn btn-primary pull-right m-2" data-toggle="modal" data-target="#FinalDecision">Make Final Decision</a>
                        </div>
                      <?php } ?>


                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">

                <div class="dispute d_sm_block">
                <div class="lislll_ideaa">
                            <div class="listr_uuusdisp2">
                              
                              <p>Claimant: <span class="bol_c2 pull-right"><?php echo ($Claimant['type'] == 2) ? $Claimant['f_name'] . ' ' . $Claimant['l_name'] : $Claimant['trading_name']; ?></span></p>

                              <p>Client: <span class="bol_c2 pull-right"><?php echo $owner['f_name'] . ' ' . $owner['l_name']; ?></span></p>

                              <p>Tradesperson: <span class="bol_c2 pull-right"><?php echo $tradmen['trading_name']; ?></span></p>

                              <p>Dispute ID: <span class="bol_c2 pull-right"><?php echo $dispute['caseid']; ?></span></p>
                              <p>Case status: <span class="bol_c2 pull-right">
                                  <?php if ($dispute['ds_status'] == '0') {
                                    echo 'Open';
                                  } else {
                                    echo 'Closed';
                                  }; ?>
                                </span></p>
                              <?php if ($dispute['ds_status'] == '1') { ?>
                                <p>Decided in: <span class="bol_c2 pull-right">
                                    <?php
                                    $favorOf = $this->Common_model->GetColumnName('users', array('id' => $dispute['ds_favour']), array('f_name', 'l_name', 'type', 'trading_name'));


                                    $winner = ($favorOf['type'] == 2) ? $favorOf['f_name'] . ' ' . $favorOf['l_name'] : $favorOf['trading_name'];


                                    echo $winner . ' favour';
                                    ?>
                                  </span>
                                </p>
                              <?php } ?>
                            </div>

                          </div>
                          </div>

                <div class="step-main">
                <div class="bg-light p-0">
                  <?php

                  if (!$checkOtherUserReply) {

                    $newTime = date('Y-m-d H:i:s', strtotime($dispute['ds_create_date'] . ' +' . $setting['waiting_time'] . ' days'));
                    $diff = date_difference($new, $newTime);


                  ?>
                    <h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
                    <h5 class="text-primary text-center">left for <?= ($dispute['disputed_by'] == $tradmen['id']) ? $owner['f_name'] . ' ' . $owner['l_name'] : $tradmen['trading_name'] ?> to respond</h5>

                  <?php } else if ($showStepIn) {
                    echo $showStepIn;
                  } else if ($home_stepin && $trades_stepin) { ?>
                  <?php } else if ($home_stepin) {

                    $newTime = $home_stepin['expire_time'];
                    $diff = date_difference($new, $newTime);


                  ?>
                    <h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
                    <h5 class="text-primary text-center">left for <?= $tradmen['trading_name'] ?> to arbitration fee</h5>


                  <?php } else if ($trades_stepin) {
                    $newTime = $trades_stepin['expire_time'];
                    $diff = date_difference($new, $newTime);


                  ?>
                    <h3 class="text-primary text-center"><?= $diff['days']; ?> days, <?= $diff['hours']; ?> hours</h3>
                    <h5 class="text-primary text-center">left for <?= $owner['f_name'] . ' ' . $owner['l_name'] ?> to arbitration fee</h5>
                  <?php } ?>

                  <h5 class="text-center border_dashed_top py-3 w-70 mx-auto">Total amount disputed: <font style="font-size: 24px;">£<?php echo $dispute['total_amount']; ?></font>
                  </h5>
                  <div class="row">
                    <div class="col-sm-12 ">
                        
                        <div class="ShowMilestones hide border_dashed_bottom pb-3">
                          <ul style="text-align: center;">
                            <?php foreach($milestones as $milestone) {
                              echo '<li style="list-style: none;" ><p class="p_left">£'.$milestone['milestone_amount'].':</p><p class="p_right">'.$milestone['milestone_name'].'</p></li>';
                            }?>
                          </ul>
                          <p style="text-align:center;" class="mb-0">Project will be closed upon resolution</p>
                        </div>

                        <a class="pull-right btn_show_milestone pt-2" onclick="$('.ShowMilestones').toggleClass('hide')">
                          Show Milestones
                        </a>

                      </div>
                    </div>
                  <div class="row pt-3 border-top treadman_50">

                    <div class="col-sm-6 text-center">
                      Homeowner <?= $owner['f_name']; ?> wants to pay:<br>
                      <?php if ($dispute['homeowner_offer']) { ?>

                        <font style="font-size: 30px">£<?= $dispute['homeowner_offer'] ?></font>
                      <?php } else { ?>
                        <p class="myBtag btn btn-anil_btn"><?= $owner['f_name']; ?> have not made an offer yet</p>
                      <?php } ?>

                      <br>

                      <?php
                      if ($dispute['ds_status'] == '0') {
                        if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 0) {
                          echo '<p class="myBtag btn btn-anil_btn">Awaiting tradesman response</p>';
                        } else if ($dispute['homeowner_offer'] && $dispute['offer_rejected_by_tradesmen'] == 2) {
                          echo '<p class="myBtag btn btn-anil_btn">Tradesman rejected your offer</p>';
                        }
                      }
                      ?>

                    </div>
                    <div class="col-sm-6 text-center" style="border-left: 1px solid #c5c5c5;">

                      Tradesman (<?= $tradmen['trading_name']; ?>) want to receive:<br>
                      <?php if ($dispute['tradesmen_offer']) { ?>
                        <font style="font-size: 30px">£<?= $dispute['tradesmen_offer'] ?></font>
                      <?php } else { ?>
                        <p class="myBtag btn btn-anil_btn"><?= $tradmen['trading_name']; ?> has not made an offer yet</p>
                      <?php } ?>
                      <br>

                      <?php
                      if ($dispute['ds_status'] == '0') {
                        if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 0) {
                          echo '<p class="myBtag btn btn-anil_btn">Awaiting homeowner response</p>';
                        } else if ($dispute['tradesmen_offer'] && $dispute['offer_rejected_by_homeowner'] == 2) {
                          echo '<p class="myBtag btn btn-anil_btn ">Homeowner rejected tradesman offer</p>';
                        }
                      }
                      ?>


                    </div>

                  </div>

                  <div class="reppll">
                    <?php if ($dispute['ds_status'] == '0') { ?>

                      <hr>
                      <div style=" text-align:center">
                        <p style=""><strong>Agreed: </strong>£0.00</p>
                      </div>

                      <?php } else { ?>
                      <hr>
                      <div style=" text-align:center">
                        <p style=""><strong>Agreed: </strong>£<?php echo ($dispute['caseCloseStatus']==5) ? $dispute['agreed_amount'] : '0.00'; ?></p>
                        <p style="color:red; text-transform:uppercase;"><strong>
                          
                          <?php
                          if($dispute['caseCloseStatus']==1) {

                            echo "Resolved, Not Responded";
        
                          } else if($dispute['caseCloseStatus']==2){
        
                            echo "Resolved, Cancelled";
        
                          } else if($dispute['caseCloseStatus']==3){
        
                            echo "Arbitration Fees Not Paid";
        
                          } else if($dispute['caseCloseStatus']==4){
        
                            echo "Resolved By Dispute Team";
        
                          } else if($dispute['caseCloseStatus']==5){
        
                            echo "Resolved, Offer Accepted";
        
                          } else {
                            echo "Resolved, Dispute Closed";
                          }
                          ?>
                        
                      
                        </strong></p>
                      </div>
                    <?php } ?>
                  </div>
                  <hr>

                  <h3 class="text-dark text-center font-bold">Dispute Event History</h3>

                  <?php foreach($dispute_events as $dispute_event) { 
                    ?>
                    
                    
                    <h4 class="text-primary"><?= ($dispute_event['user_type']==1) ? $dispute_event['trading_name'] : $dispute_event['f_name'].' '.$dispute_event['l_name']; ?></h4>
                    <p  class="text-dark m-0"><?php echo $dispute_event['message']; ?></p>
                    <p  class="" style="font-size: 12px;"><?php echo date('d M y h:i A',strtotime($dispute_event['created_at'])); ?></p>
                    <hr>
                  <?php }?>

                </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php if ($dispute['ds_status'] == '0') { ?>

  <div class="modal fade" id="FinalDecision" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form method="post" onsubmit="return check_from(1);" action="<?php echo site_url('makedisputefinal'); ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reply on Dispute</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label">In Favor of: </label>
              <div class="">
                <select class="form-control" name="ds_favour" required>
                  <option value="">Select </option>
                  <option value="<?php echo $owner['id']; ?>"><?php echo $owner['f_name'] . ' ' . $owner['l_name']; ?>(Homeowner)</option>
                  <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'] . ' ' . $tradmen['l_name']; ?>(Tradesman )</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Comment : </label>
              <div class="">
                <textarea cols="45" rows="5" name="massage" id="dct_msg1" class="form-control"></textarea>
              </div>
            </div>

            <input type="hidden" name="ds_id" value="<?php echo $dispute['ds_id']; ?>">
            <input type="hidden" name="homeowner_id" value="<?php echo $dispute['ds_puser_id']; ?>">
            <input type="hidden" name="tradesman_id" value="<?php echo $dispute['ds_buser_id']; ?>">
            <input type="hidden" name="job_id" value="<?php echo $dispute['ds_job_id']; ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-theme disput_btn" value="submit">Submit <i class="fa fa-spin fa-spinner disput_loader" style="font-size:24px;display:none;"></i></button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <div class="modal fade" id="disputework" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form method="post" onsubmit="return check_from(2);" action="<?php echo site_url('add_dispute_comment'); ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reply on Dispute</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="control-label">Message to: </label>
              <div class="">
                <select class="form-control" name="message_to" required>
                  <option value="">Select </option>
                  <option value="<?php echo $owner['id']; ?>"><?php echo $owner['f_name'] . ' ' . $owner['l_name']; ?>(Homeowner)</option>
                  <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'] . ' ' . $tradmen['l_name']; ?>(Tradesman )</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Comment : </label>
              <div class="">
                <textarea cols="45" rows="5" name="massage" id="dct_msg2" class="form-control"></textarea>
              </div>
            </div>

            <input type="hidden" name="dispute_id" value="<?php echo $dispute['ds_id']; ?>">
            <input type="hidden" name="job_id" value="<?php echo  $dispute['ds_job_id'] ?>">
            <input type="hidden" name="serid" value="<?php echo  $dispute['caseid']; ?>">
            <input type="hidden" name="tradesman_id" value="<?php echo  $dispute['ds_buser_id']; ?>">
            <input type="hidden" name="homeowner_id" value="<?php echo  $dispute['ds_puser_id']; ?>">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-theme disput_btn" value="submit">Submit <i class="fa fa-spin fa-spinner disput_loader" style="font-size:24px;display:none;"></i></button>
          </div>
        </form>
      </div>

    </div>
  </div>

<?php } ?>


<?php include_once('include/footer.php'); ?>
<script>
  function check_from(id) {
    var msg = $('#dct_msg' + id).val();
    if (!msg) {
      alert('Add you comment!');
      return false;
    }
  }
</script>