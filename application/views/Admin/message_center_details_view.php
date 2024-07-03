<?php 
  include_once('include/header.php');
  if(!in_array(10,$my_access)) { redirect('Admin_dashboard'); }
?>
<style type="text/css">
.reply-btn .btn{
  margin: 0 3px;
}
.tox-toolbar__primary, .tox-editor-header{
  display:none !important;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Message Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Message Details</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="col-sm-9">
              <div class="manage-profile">
                <p><?php echo $this->session->flashdata('responseMessage');?></p>
                <div class="inner-box">
                  <div class="inner-body">
                    <div class="dispute">
                      <div class="">
                        <div class="lislll_ideaa">
                          <div class="listr_uuusdisp2">
                            <p>Name: <span class="bol_c2 pull-right"><?=$receiverData['f_name'] ." " .$receiverData['l_name']; ?></span></p>
                            <?php
                              if($receiverData['profile']){
                                $receiverProfile = $receiverData['profile'];
                              } else {
                                $receiverProfile = "dummy_profile.jpg";
                              }
                            ?>
                            <p>
                              <img width="100" src="<?=site_url('img/profile/' .$receiverProfile);?>">
                            </p>
                          </div>
                        </div>
                        <?php
                          if(!empty($isNewChat)){
                        ?>
                            <?php
                              foreach($chatDetails as $chatDetail){
                            ?>
                                <div class="dis-section">
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="dis_div chan_dess">
                                        <?php
                                          if($chatDetail['sender_id'] == $receiverData['id']){
                                        ?>
                                            <div class="user-imge">
                                              <?php
                                              if($chatDetail['profile']){
                                                $profile = $chatDetail['profile'];
                                              } else {
                                                $profile = "dummy_profile.jpg";
                                              }
                                              ?>
                                              <img src="<?=site_url('img/profile/' .$profile);?>">
                                            </div>
                                        <?php
                                          }else{
                                        ?>
                                            <div class="user-imge">
                                              <img src="<?=site_url('img/profile/admin-img.png');?>">
                                            </div>
                                        <?php
                                          }
                                        ?>
                                        <div class="panel panel-default panel-final">
                                          <div class="panel-heading">
                                            <b>
                                            <?php
                                              if($chatDetail['sender_id'] == $receiverData['id']){
                                            ?>
                                                <?=$receiverData['f_name'] ." " .$receiverData['l_name'];?> : 
                                            <?php
                                              }else{
                                            ?>
                                                Support Team :
                                            <?php
                                              }
                                            ?>
                                            </b>
                                          </div>
                                          <div class="panel-body">
                                           <?=$chatDetail['message']; ?>
                                          </div>
                                          <div class="panel-heading">
                                            <span class="pull-right"><?=date('d-M-Y h:i:s A',strtotime($chatDetail['create_time']));?></span></h3>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            <?php
                              }
                            ?>
                        <?php
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="reppll">
                    <a class="btn btn-info pull-right" data-toggle="modal" data-target="#messageModal"> Send Message </a>
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

<div class="modal fade" id="messageModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form method="post" onsubmit="send_message(event);" id="messageform" name="messageform" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Message User </h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label> Email </label>
            <span class="form-control"> <?=$receiverData['email'];?> </span>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea name="message" class="form-control" required="" > </textarea>
            <input type="hidden" name="admin_chat_id" class="form-control" required="" value="<?=$admin_chat_id;?>" />
            <input type="hidden" name="receiver_id" class="form-control" required="" value="<?=$receiverData['id'];?>" />
            <input type="hidden" name="email" class="form-control" required="" value="<?=$receiverData['email'];?>" />
            <input type="hidden" name="username" class="form-control" required="" value="<?=$receiverData['f_name'] ." " .$receiverData['l_name'];?>" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-theme submit-btn" value="submit"> Send </button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php include_once('include/footer.php'); ?>
<script>
  <?php
    if(empty($isNewChat)){
  ?>
      $('#messageModal').modal('show');
  <?php
    }
  ?>

  function send_message(e){
    e.preventDefault();
    $.ajax({
      type:'POST',
      url:site_url+'Admin/Chats/send_message',
      data: new FormData($('#messageform')[0]),
      dataType: 'JSON',
      processData: false,           
      contentType: false,
      cache: false,
      beforeSend:function(){
        $('.submit-btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        $('.submit-btn').prop('disabled',true);
      },
      success:function(response){
        if(response.status == 1) location.reload();
        $('.submit-btn').html('Send');
        $('.submit-btn').prop('disabled', false);
      } 
    });
  }
</script>