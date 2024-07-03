<?php 
  include_once('include/header.php');
  if(!in_array(1,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
  .btn.btn_theme.btn-lg {
  background: #3d78cb;
  color: #fff;
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





/*chat messange*/
.left_chat{
  border: 1px solid #e1e1e1;
}
.hedadeer_left h4 {
  background: #3d78cb;
  color: #fff;
  font-size: 20px;
  margin: 0;
  padding: 8px 15px;
}

.auto_scol_left ul li a {
  color: #333;
  display: inline-block;
  min-height: 50px;
  overflow: hidden;
  padding: 5px 15px 5px 58px;
  position: relative;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 100%;
}
.auto_scol_left ul li a:hover,
.auto_scol_left ul li.active a

{
background: #f1f1f1;
}
.auto_scol_left ul li a .chat_user_img {
  display: inline-block;
  height: 40px;
  left: 10px;
  position: absolute;
  top: 5px;
  width: 40px;
}
.auto_scol_left ul li a .chat_user_img img {
  border-radius: 0;
  height: 100%;
  object-fit: cover;
  width: 100%;
}
.auto_scol_left {
  height: 513px;
  overflow-x: hidden;
  overflow-y: auto;
  background: #fff;
}
.hedadeer_riht h4 {
  background: #3d78cb;
  color: #fff;
  font-size: 20px;
  margin: 0;
  padding: 8px 15px;
}
.right_messge {
  border: 1px solid #e1e1e1;
  background: #fff;
}
.cha_magge_us2 ul > li {
  margin-bottom: 15px;
  min-height: 40px;
  padding: 0 10px;
}
.message-data {
  padding-left: 40px;
  position: relative;
}
.message-data .mess_dat_img {
  display: inline-block;
  height: 34px;
  left: 0;
  position: absolute;
  top: 0;
  width: 34px;
}
.mess_dat_img > img {
  border-radius: 0;
  height: 100%;
  width: 100%;
  object-fit: cover;
}
.messge_cont p{
  margin: 0;
  margin-bottom:0px;
}
.messge_cont p .message_box {
  background: #f1f1f1;
  border-radius: 4px;
  color: #333;
  padding: 6px 12px;
  display: inline-block;
  font-size: 15px;
}
.messge_cont span.time{
  display: inline-block;
  width: 100%;
  font-size: 13px;
}
.cha_magge_us2 {
  height: 447px;
  overflow-x: hidden;
  overflow-y: auto;
  padding: 20px 0;
}
.recever .message-data{
  padding-left: 0;
  padding-right: 0;
}
.recever .message-data .mess_dat_img{
  left: auto;
  right: 0;
}
.recever .messge_cont p .message_box{
  background: #3d78cb;
  color: #fff;
}
.recever .messge_cont{
  text-align: right;
}
.chat_stas {
  border-radius: 100%;
  height: 9px;
  right: 0;
  position: absolute;
  bottom: 0;
  width: 9px;
  z-index: 999;
  border: 1px solid #fff;
  box-shadow: 0 0 5px rgba(0,0,0,0.02);
}
.online1{
  background: #0eba1e;
}
.offline{
  background: #999;
}
.read_onle{
  background: #d67707;
}
.messge_send {
  background: #333;
  padding: 10px 15px;
}
.ul_set {
  list-style: none;
  padding: 0;
  margin: 0;
}
.auto_scol_left ul li a .namechat {
  font-size: 16px;
  margin: 0;
  line-height: 1.2;
  color: #888;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding-right: 25px;
}
.auto_scol_left ul li a .namechat b {
  color: #333;
  font-weight: 600;
}
.auto_scol_left ul li a .text_usch{
  margin: 0;
  color: #888;
  font-size: 14px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
/*chat messange close*/

.timexddd{
  text-align: center;
}
.left_chat .btn{
  border-radius: 0;
}
.left_chat ul{
  margin-top: 10px;
}
.row.mann_chaha .col-sm-4, .row.mann_chaha .col-sm-8 {
  padding: 0;
}
.row.mann_chaha {
  margin: 0;
}
.reed {
  background: #f00;
  color: #fff;
  width: 20px;
  display: inline-block;
  height: 20px;
  text-align: center;
  font-size: 14px;
  vertical-align: middle;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  position: absolute;
  right: 15px;
  top: 2px;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Message Center</h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Message Center</li>
    </ol> 
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12 head">
        <div class="" style="padding-bottom:20px;">
          <button style="display:none;" onclick="export_user();" class="btn btn-primary"><i class="exp"></i> Export</button>
        </div>
      </div>

      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
            <div class="box-body">
              <div class="row mann_chaha">
                <div class="col-sm-4">
                  <div class="left_chat show-mmm">
          
          <div class="auto_scol_left">
            <div class="input-group">
              <input name="" placeholder="Search User" id="user_search" class="form-control input-lg" type="text">
              <span class="input-group-btn">
                <button class="btn btn_theme btn-lg"><i class="fa fa-search"></i></button>
              </span>
            </div>
            <ul class="ul_set" id="user_list">
              <?php
                foreach($chatUsers as $serialNumber => $chatUser){
                  if($selectedUserChatId){
                    if($chatUser['admin_chat_id'] == $selectedUserChatId){
                      $get_admin_chat_id = $chatUser['admin_chat_id'];
                      $get_message_user_id = $chatUser['id'];
                      $get_message_username = $chatUser['f_name'] .' ' .$chatUser['l_name'];
                      $get_message_email = $chatUser['email'];
                      $get_message_active_class = 'user_list_' .$serialNumber;
                    }
                  }
                  $profile = ($chatUser['profile']) ? $chatUser['profile'] : 'dummy_profile.jpg';
              ?>
                  <li class="user_list_<?=$serialNumber;?>">
                    <a href="javascript:void(0);" onclick="get_message(<?=$chatUser['admin_chat_id'];?>, <?=$chatUser['id'];?>, '<?=$chatUser['f_name'] .' ' .$chatUser['l_name']?>', '<?=$chatUser['email'];?>', 'user_list_<?=$serialNumber;?>');">
                      <span class="chat_user_img">
                        <img src="<?=site_url('img/profile/' . $profile);?>">
                        <span class="chat_stas online1 "></span>
                      </span>
                      <p class="namechat"><b><?=$chatUser['f_name'] .' ' .$chatUser['l_name'];?></b> <?=($chatUser['type'] == 2) ? 'Homeowner' : 'Tradesman';?> </p>
                      <?php
                        if($chatUser['admin_chat_id']){
                      ?>
                          <?php
                            if($chatUser['unreadCount'] > 0){
                          ?>
                              <span class="reed"><?=$chatUser['unreadCount'];?></span>
                          <?php
                            }
                          ?>
                          <p class="text_usch">Ticket ID: <?=$chatUser['ticket_id'];?></p>
                      <?php
                        }
                      ?>
                    </a>
                  </li>
                  
              <?php
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8" id="messages_section">
        <div class="right_messge show-mmm">
          <div class="cha_magge_us2">
            <ul class="ul_set" id="append_messages">
              <p class="timexddd">
                Click on a user to start messaging.
              </p>
              <li class="sender" style="display:none;">
                <div class="message-data">
                  <div class="mess_dat_img">
                    <img src="https://stylesatlife.com/wp-content/uploads/2018/02/professional-hairstyle-11.jpg">
                  </div>
                  <div class="messge_cont">
                    <p>
                      <span class="message_box">yes well done </span>
                    </p>
                  </div>
                </div>
              </li>
              <li class="recever" style="display:none;">
                <div class="message-data">
                 
                  <div class="messge_cont">
                    <p>
                      <span class="message_box">yes well done </span>
                    </p>
                  </div>
                </div>
              </li>
              <li class="recever" style="display:none;">
                <div class="message-data">
                  <div class="messge_cont">
                    <p>
                      <span class="message_box">done </span>
                    </p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="messge_send">
            <div class="input-group">
              <input name="message" id="message" placeholder="Message" class="form-control input-lg" type="text">
              <input type="hidden" id="receiver_id" value="" >
              <input type="hidden" id="admin_chat_id" value="0" >
              <input type="hidden" id="email" >
              <input type="hidden" id="username" >
              <span class="input-group-btn">
                <button class="btn btn_theme btn-lg" id="message_send_btn" onclick="send_message();" >Send</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>



           <!--  <?php if($this->session->flashdata('error')) { ?>

            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>

            <?php	} ?>

            <div class="table-responsive">
              <table id="ExportDatable" class="table table-bordered table-striped">
                <thead>
                  <tr> 
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($chats as $serialNumber => $chat){
                  ?>
                      <tr>
                        <td><?=$serialNumber + 1;?></td>
                        <td><?=$chat['f_name'] . " " .$chat['l_name'];?></td>
                        <td><?=$chat['email'];?></td>
                        <td><?=$chat['message'];?></td>
                        <td>
                          <a class="btn btn-primary" href="<?=site_url('Admin/Chats/details/' .$chat['receiver_id']);?>" >
                            Send message
                            <?php
                              if($chat['unreadCount'] > 0){
                            ?>
                                <span style="background:red;color:#fff;" class="badge"><?=$chat['unreadCount'];?></span>
                            <?php
                              }
                            ?>
                          </a>
                        </td>
                      </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>   
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include_once('include/footer.php'); ?>

<script>
  $(document).ready(function(){
    $("#user_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#user_list li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  $("#messages_section").hide();
  let totalMessages = 0;
  function get_message(admin_chat_id, user_id, username, email, activeList){
    $("#user_list>li.active").removeClass("active");
    $("." + activeList).addClass("active");
    $("#messages_section").show();
    $("#receiver_id").val(user_id);
    $("#email").val(email);
    $("#username").val(username);
    $.ajax({
      type:'post',
      url: site_url + 'Admin/Chats/get_messages',
      data:{
        'admin_chat_id': admin_chat_id
      },
      dataType:'json',
      success:function(response){
        totalMessages = response.totalMessages;
        $("#admin_chat_id").val(response.admin_chat_id);
        var oldscrollHeight = $(".cha_magge_us2").prop("scrollHeight");
        $(".cha_magge_us2").html(response.messages);
        var newscrollHeight = $(".cha_magge_us2").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $(".cha_magge_us2").animate({
            scrollTop: newscrollHeight
          }, 'normal');
        }
        // $("#message_send_btn").attr('disabled' , false);
      }
    });
  }

  function send_message(){
    let message = $("#message").val();
    let receiver_id = $("#receiver_id").val();
    let admin_chat_id = $("#admin_chat_id").val();
    let email = $("#email").val();
    let username = $("#username").val();
    if(message == ''){
      return false;
    }
    $.ajax({
      type:'POST',
      url: site_url + 'Admin/Chats/send_message',
      data:{
        'message': message,
        'receiver_id' : receiver_id,
        'admin_chat_id' : admin_chat_id,
        'email' : email,
        'username' : username
      },
      dataType:'json',
      success:function(response){
        var oldscrollHeight = $("#append_messages").prop("scrollHeight");
        $("#append_messages").append('<li class="recever"><div class="message-data"><div class="messge_cont"><p><span class="message_box">' + message + ' </span></p></div></div></li>');
        $("#message").val('');
        toastr.success('Message sent successfully');
        $("#admin_chat_id").val(response.admin_chat_id);

        var newscrollHeight = $("#append_messages").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $("#append_messages").animate({
            scrollTop: newscrollHeight
          }, 'normal');
        }
      }
    });
  }

  function refresh_messages(){
    $.ajax({
      type:'post',
      url: site_url + 'Admin/Chats/refresh_messages',
      data:{},
      dataType:'json',
      success:function(response){
        if(totalMessages != response.totalMessages && response.admin_chat_id != 0){
          var oldscrollHeight = $("#append_messages").prop("scrollHeight");
          $("#append_messages").html(response.messages);
          var newscrollHeight = $("#append_messages").prop("scrollHeight");
          if (newscrollHeight > oldscrollHeight) {
            $("#append_messages").animate({
              scrollTop: newscrollHeight
            }, 'normal');
          }
        }
      }
    });
  }

  let load_messages  = setInterval(function(){
    refresh_messages();
  }, 1500);
  
  <?php
    if($selectedUserChatId){
  ?>
      get_message(<?=$get_admin_chat_id;?>, <?=$get_message_user_id;?>, '<?=$get_message_username;?>', '<?=$get_message_email;?>', '<?=$get_message_active_class;?>');
  <?php
    }
  ?>
</script>