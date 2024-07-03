<?php include 'include/header.php'; ?>

<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
#messageError{
  display:none;
}
#vote_buttons :hover {
  cursor:pointer;
}
.message_manb .dispute .panel.panel-final {
  border: 1px solid #e1e1e1;
  box-shadow: 0px 0px 0px;
  min-height: 50px;
  padding: 15px 0;
}
.text_uuu {
  font-size: 14px;
}
.message_manb{
  padding: 15px;
  background: #fff;
}
.message_manb .reppll {
  display: inline-block;
  width: 100%;
}
.mrsssagen_cantet_555 .inner-body {
  height: <?php echo ($user_data['type']==2) ? '385px' : '667px';?>;
  overflow-y: auto;
  overflow-x: hidden;
  margin-bottom: 15px;
}
</style>
<style type="text/css">
#vote_buttons :hover {
  cursor:pointer;
}
.rating-stars ul {
  list-style-type:none;
  padding:0;
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
</style>
<style type="text/css">
  .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #fff none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 100%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}

.stylish-input-group {
  display: flex;
}
.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 100%;
}
.srch_bar .input-group-addon i {
  position: absolute;
  top: 4px;
  right: 4px;
}
.headind_srch{ padding:10px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
  display: none;
}
.srch_bar input{ border: 0; box-shadow: 0 1px 2px #00000012; width:100%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -24px; position: relative;border: 0px;border-radius: 0;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; }
.chat_img {
  float: left;
  width: 40px;
  background: #fff;
  padding: 2px;
  border-radius: 3px;
  box-shadow: 0px 1px 2px #0000003d;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 80%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
 /* border-bottom: 1px solid #c4c4c4;*/
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 40px;
  box-shadow: 0px 1px 2px #0000001a;
  padding: 2px;
  margin-left: 2px;
  border-radius: 3px;
  position: absolute;
  left: 0;
  bottom: 25px;
}
.incoming_msg {
  position: relative;
}
.outgoing_msg_img {
  display: inline-block;
  width: 40px;
  box-shadow: 0px 1px 2px #0000001a;
  padding: 2px;
  margin-left: 2px;
  border-radius: 3px;
  position: absolute;
  right: 0;
  top: 0;
  height: 30px;
  overflow: hidden;
}
.outgoing_msg {
  position: relative;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
  margin-left: 45px;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 10px 0 10px;
  width: 100%;

}
.msg_history{
  overflow-y: auto;
  overflow-x: hidden;
}

 .sent_msg p {
  background: #3d78cb none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg {
  overflow: hidden;
  margin: 20px 0;
}
.incoming_msg {
  margin: 20px 0;
}
.sent_msg {
  float: right;
  width: 46%;
  margin-right: 50px;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #3d78cb none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 10px;
  top: 8px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 500px;
  
}
  #vote_buttons :hover {
    cursor:pointer;
}
.write_msg{
  padding: 10px;
}
@media(max-width: 767px){
  .inbox_chat{
    height: 350px;
  }
  .msg_history {
  height: 370px;
  
}
.inbox_people{
  border-bottom: 5px solid #e1e1e1;
}
}
</style>
<div class="acount-page membership-page">
  <div class="container">
    <!-- <div class="container ">  -->
      <!-- user-right-side -->
    <div class="user-setting" style="margin: 0 0px;">

    <div class="row">
      <div class="col-md-3 nopadding">
        <!-- sidebar here -->
        <?php include 'include/sidebar.php'; ?>
        <!-- sidebar here -->
      </div>

      <div class="col-md-9">
        <?=$this->session->flashdata('responseMessage');?>
        <div class="verify-page">
          <div class="message_manb">
            <div class="mjq-sh man_osp1" style="padding: 5px;">
              <a href="<?=site_url('Support/new_ticket');?>" type="button" class="btn btn-primary" > Create new ticket </a>
            </div>
            <div class="manage-profile mrsssagen_cantet_555">
              <div class="table table-responsive">
                <table class="DataTable table table-striped">
                  <thead>
                    <tr>
                    <th>Ticket Number</th>
                    <th>Message</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach($adminChats as $adminChat){
                    ?>
                        <tr>
                        <td><?=$adminChat['ticket_id'];?> </a> </td>
                        <td><?=$adminChat['message'][0]['message'];?></td>
                        <td><?=$adminChat['created'];?></td>
                        <td>
                          <?php if($adminChat['ticket_status']==1){ ?>
                            <span class="label label-danger">Closed</span>
                          <?php }else{ ?>
                            <span class="label label-success">Open</span>
                          <?php  } ?>
                          
                        </td>
                        <td><a href="<?=site_url('Support/details/' .$adminChat['id']);?>" > View </a> </td>
                        </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>

              <!--
              <div class="inner-box" >
                <div class="inner-body">
                  <div class="dispute">
                    <div class="" id="append_messages">
                      <form method="post" onsubmit="send_message_old(event);" id="messageform" name="messageform" >
                        <?php 
                        $help_link = ($user_data['type']==2) ? site_url() . 'homeowner-help-centre' : site_url() . 'tradesman-help';
                        ?>
                        <div class="mjq-sh man_osp4"><p>Have you read our <a href="<?php echo $help_link; ?>">help centre?</a></p></div>
                        <div class="mjq-sh man_osp2"><h2><strong>Support</strong></h2></div>

                        <div class="mjq-sh man_osp3">
                        <p>Please write your message below and we´ll get back as soon as possible.</p>
                        <p>Please be as detailed as possible so that we can give you a tailored response.</p>
                        <br>
                        <div class="form-group">
                          <label>Message</label>
                          <textarea style="height: 130px" name="message" class="form-control" required id="message" > </textarea>
                          <input type="hidden" name="admin_chat_id" id="admin_chat_id" class="form-control" required="" value="0" />
                          <input type="hidden" name="receiver_id" class="form-control" required="" value="<?=$receiverData['id'];?>" />
                        </div>
                     
                        <button type="submit" class="btn btn-primary submit-btn" value="submit"> Send </button>             
                        </div>
                     
                      </form>
                    </div>
                  </div>
                </div>
                <div class="reppll">
                  <a class="btn btn-info pull-right" data-toggle="modal" data-target="#messageModal"> Send Message </a>
                </div>
              </div>
              -->

            </div>
          </div>
            <!-- start usi -->
        </div>
      </div>
    </div>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messageModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form method="post" onsubmit="send_message(event);" id="messageform" name="messageform" >
        <?php 
        $help_link = ($user_data['type']==2) ? site_url() . 'homeowner-help-centre' : site_url() . 'tradesman-help';
        ?>
        <div class="mjq-sh man_osp4"><p>Have you read our <a href="<?php echo $help_link; ?>">help centre?</a></p></div>
        <div class="mjq-sh man_osp2"><h2><strong>Support</strong></h2></div>

        <div class="mjq-sh man_osp3">
        <p>Please write your message below and we´ll get back as soon as possible.</p>
        <p>Please be as detailed as possible so that we can give you a tailored response.</p>
        <br>
        <div class="form-group">
          <label>Message</label>
          <textarea style="height: 130px" name="message" class="form-control" required id="message_text" ></textarea>
          <p id="messageError" class="alert alert-danger"> Message cannot be blank </p>
          <input type="hidden" name="admin_chat_id" id="admin_chat_id" class="form-control" required="" value="0" />
          <input type="hidden" name="receiver_id" class="form-control" required="" value="<?=$receiverData['id'];?>" />
        </div>
     
        <button type="submit" class="btn btn-primary submit-btn" > Send </button>
        </div>
     
      </form>

      <!--
      <form method="post" onsubmit="send_message_old(event);" id="messageform" name="messageform" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> Message Support </h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Message</label>
            <textarea name="message" class="form-control" id="message" required > </textarea>
            <p id="messageError" class="alert alert-danger"> Message cannot be blank </p>
            <input type="hidden" name="admin_chat_id" id="admin_chat_id" class="form-control" required="" value="<?=$admin_chat_id;?>" />
            <input type="hidden" name="receiver_id" class="form-control" required="" value="<?=$receiverData['id'];?>" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-theme submit-btn" value="submit"> Send </button>
        </div>
      </form>
      -->

    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>

<script type="text/javascript">
	$(document).ready(function(){
  $("#man_bbbon").click(function(){
    $("#sidd_cll").toggleClass("opn_d");
  });
});
</script>

<script>
function send_message(e){
	e.preventDefault();
  $("#messageError").hide();
  if(check_form_error()){
    $("#messageError").show();
  }else{
    $.ajax({
      type:'POST',
      url:site_url + 'Support/send_message',
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
        $("#admin_chat_id").val(response.admin_chat_id);
        $('#messageModal').modal('hide');
        $("#message").val('');
        if(response.status == 1) location.reload();
        $('.submit-btn').html('Send');
        $('.submit-btn').prop('disabled', false);
      }
    });
  }
}

let totalMessages = 0;
function refresh_messages(){
	$.ajax({
		type:'post',
		url: site_url + 'Chat/refresh_messages',
		data:{},
		dataType:'json',
		success:function(response){
			if(totalMessages != response.totalMessages && response.admin_chat_id != 0){
				var oldscrollHeight = $(".msg_history").prop("scrollHeight");
				$(".msg_history").html(response.newMessages);
				var newscrollHeight = $(".msg_history").prop("scrollHeight");
				if (newscrollHeight > oldscrollHeight) {
					$(".msg_history").animate({
						scrollTop: newscrollHeight
					}, 'normal');
				}
			}
		}
	});
}

  function check_form_error(){
    let message = $("#message_text").val();
    return (message.length > 0) ? false : true;
  }

$('.inner-body').animate({ scrollTop: 20000000 }, "slow");
$(function(){
	$(".DataTable").DataTable({
    ordering:false,
		stateSave: true,
		lengthChange: false,
		searching: false,
	});
	$('#DataTables_Table_0_paginate').addClass('pull-right');
});
</script>