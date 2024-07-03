<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
	<div class="container user-right-side">
		<div class="user-setting" style="margin: 0 0px;">
			<div class="row">
				<div class="col-md-3 nopadding">
					<div class="inbox_people">
						<div class="headind_srch">
							<div class="recent_heading">
								<h4>Recent</h4>
							</div>
							<div class="srch_bar">
								<!--  <form method="get" id="search_forms" onsubmit="return do_search();"> -->
								<div class="stylish-input-group">   
									<input type="text" class="search-bar"  placeholder="Search for People" name="searches"  id="searches">
									
									<span class="input-group-addon">
										<button type="submit"> <i class="fa fa-search" aria-hidden="true"></i> </button>
									</span>
								</div>
               <!-- </form> -->
							</div>
						</div>
						<div class="inbox_chat">
							<div id="user_list_div">
								<?php
								$chat_list = $this->common_model->get_chat_list($this->session->userdata('user_id'));
								$first = false;
								$post_id=false;
								if($chat_list) {
									foreach($chat_list as $row) { 
										$rid = ($row['sender_id']==$this->session->userdata('user_id'))?$row['receiver_id']:$row['sender_id'];
										$get_job_details=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$row['post_id']));
										if($first==false) {
											
											$first = $rid;
										}
										if($post_id==false) {
											$post_id = $row['post_id'];
										}
										$sender = $this->common_model->get_single_data('users',array('id'=>$rid)); 
										
										$unread=$this->common_model->get_unread_by_sid_rid($this->session->userdata('user_id'),$rid,$row['post_id']);
              
										?>

								<div class="chat_list">
									<div class="chat_people">
										<div class="chat_img">
											<?php  if($sender['profile']) { ?>
											<img src="<?= site_url(); ?>img/profile/<?= $sender['profile']; ?>" alt="">
											<?php } else{ ?>
											<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" alt="">
											<?php } ?> 
										</div>
										<div class="chat_ib">
											<h5 id="vote_buttons"><b><p style="color: black" onclick="get_chat_onclick1(<?php echo $rid; ?>,<?php echo $row['post_id']; ?>);"><?php echo $sender['f_name'].' '.$sender['l_name']; ?></p></b> </h5>
											<p><?php echo $get_job_details['title']; ?></p>
										</div>
										<?php if($unread[0]['total']>0) { ?>
											<span class="count_un_msg<?php echo $row['post_id']; ?>"><?php echo 	$unread[0]['total']; ?></span>
										<?php }else{ ?>
										<span class="count_un_msg<?php echo $row['post_id']; ?>"></span><?php } ?>
                   
									</div>
								</div>
 
								<?php  } } else  { ?>
                <div class="alert alert-warning">No record found!</div>
                <?php  } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="mesgs" id="usermsg1">

						<div class="msg_history">
            
						</div>

						<div class="type_msg">
							<div class="input_msg_write">
								<form id="send_msg" method="post" onsubmit="return send_msg();" class="fixed_1_bbb">
								<input type="text" class="write_msg" placeholder="Type a message" name="ch_msg1" id="ch_msg1" autofocus required=""/>
								<input name="rid" id="rid" type="hidden" value="">
								<input name="post_id" id="post_idsss" type="hidden" value="">
								<button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'include/footer.php'; ?>
<script type="text/javascript">
    function do_search(){
  $('.search_btn').prop('disabled',true);
  $('.search_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
}
function get_chat_onclick1(id,job_id)
{

    $.ajax({
    type:'POST',
    url:site_url+'chat/get_inbox_chat',
    data:{id:id,job_id:job_id},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#rid').val(id);
        $('#post_idsss').val(job_id);
        var oldscrollHeight = $(".msg_history").prop("scrollHeight");         
          $('.msg_history').html(resp.data);  
        var newscrollHeight = $(".msg_history").prop("scrollHeight");
        if (newscrollHeight > oldscrollHeight) {
          $(".msg_history").animate({
              scrollTop: newscrollHeight
          }, 'normal');
        }

      } 
 
    }
  });
  return false;

}
function send_msg()
{
  $.ajax({
    type:'POST',
     url:site_url+'chat/send_msg_inbox',
    data:$('#send_msg').serialize(),
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#ch_msg1').val('');
      }
    }
  });
  return false;
}
function get_chat_history_interwal()
{
  var id = $('#rid').val();
  var job_id=$('#post_idsss').val();
  if(id)
  {
    get_chat_onclick1(id,job_id);
  }
}

function get_unread_msg_count(post_id,rid,bid_by)
{
  $.ajax({
    type:'POST',
   url:site_url+'chat/get_inbox_unread_msg_count',
    data:{post:post_id,rid:rid,bid_by:bid_by},
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.count_un_msg'+post_id).html('('+resp.count+')');
      }
      else
      {
        $('.count_un_msg'+post_id).html('');
      }
    }
  });
  return false;
}
get_chat_onclick1(<?php echo $first; ?>,<?php echo $post_id; ?>);
function get_chat_users_list()
{
  $.ajax({
    type:'POST',
     url:site_url+'chat/get_chat_users_list',
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('#user_list_div').html(resp.data);
      }
    }
  });
  return false;
}
</script>
<script>
setInterval(function(){ get_chat_users_list(); }, 10000);
</script>
<script>
setInterval(function(){ get_chat_history_interwal(); }, 5000);
</script>
<script>
$(document).ready(function(){
  $("#searches").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#user_list_div .chat_list").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>