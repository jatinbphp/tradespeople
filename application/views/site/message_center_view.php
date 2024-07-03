<?php 
include_once('include/header.php');
?>
<style type="text/css">
  .reply-btn .btn{
    margin: 0 3px;
  }
  .tox-toolbar__primary, .tox-editor-header{
    display:none !important;
  }
.mrsssagen_cantet_555 .inner-body {
  height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
  margin-bottom: 15px;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
  
    <h1>Message Center</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Message Center</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="col-sm-9">
              <div class="manage-profile">
                <div class="inner-box mrsssagen_cantet_555">
                  <div class="inner-body">
                    <div class="dispute">
                      <div class="">
                        <div class="dis-section">
                          <?php
                            foreach($chats as $chat){
                          ?>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="dis_div chan_dess">
                                    <div class="user-imge">
                                      <?php
                                      if($chat['profile']){
                                        $profile = $chat['profile'];
                                      } else {
                                        $profile="dummy_profile.jpg";
                                      }
                                      ?>
                                      <a href="<?=site_url('Admin/Chats/details/' .$chat['user_id']);?>" >
                                        <img src="<?=site_url('img/profile/'.$profile);?>">
                                      </a>
                                      <span><?=$chat['f_name'] ." " .$chat['l_name'];?></span>
                                    </div>
                                    <div class="panel panel-default panel-final">
                                      <div class="panel-heading">	
                                        <p class="rbefff1"><?php echo $owner['f_name'].' '.$owner['l_name']; ?></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php if($dispute['ds_status'] == '0') { ?>

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
                <option value="<?php echo $owner['id']; ?>" ><?php echo $owner['f_name'].' '.$owner['l_name']; ?>(Homeowner)</option>
                <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'].' '.$tradmen['l_name']; ?>(Tradesman )</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Comment : </label>
            <div class="">    
              <textarea cols="45" rows="5" name="massage" id="dct_msg1" class="form-control textarea"></textarea>
            </div>
          </div>

            <input type="hidden" name="ds_id" value="<?php echo $dispute['ds_id'];?>">
            <input type="hidden" name="homeowner_id" value="<?php echo $dispute['ds_puser_id']; ?>">
            <input type="hidden" name="tradesman_id" value="<?php echo $dispute['ds_buser_id']; ?>">
            <input type="hidden" name="job_id" value="<?php echo $dispute['ds_job_id']; ?>">
            <input type="hidden" name="mile_id" value="<?php echo $dispute['mile_id']; ?>">          
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
                <option value="<?php echo $owner['id']; ?>" ><?php echo $owner['f_name'].' '.$owner['l_name']; ?>(Homeowner)</option>
                <option value="<?php echo $tradmen['id']; ?>"><?php echo $tradmen['f_name'].' '.$tradmen['l_name']; ?>(Tradesman )</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Comment : </label>
            <div class="">    
              <textarea cols="45" rows="5" name="massage" id="dct_msg2" class="form-control textarea" ></textarea>
            </div>
          </div>

          <input type="hidden" name="dispute_id" value="<?php echo $dispute['ds_id'];?>">
          <input type="hidden" name="job_id" value="<?php echo  $dispute['ds_job_id'] ?>">
          <input type="hidden" name="serid" value="<?php echo  $dispute['caseid']; ?>">
          <input type="hidden" name="tradesman_id" value="<?php echo  $dispute['ds_buser_id']; ?>">
          <input type="hidden" name="homeowner_id" value="<?php echo  $dispute['ds_puser_id']; ?>">
          <input type="hidden" name="mile_id" value="<?php echo $dispute['mile_id']; ?>">
          
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
function check_from(id){
  var msg = $('#dct_msg'+id).val();
  if(!msg){
    alert('Add you comment!');
    return false;
  }
}
</script>