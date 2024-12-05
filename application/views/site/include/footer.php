<style type="text/css">
  #accordion .card-body, #accordion h4{padding: 15px 20px; margin: 0px;}
  #accordion .card-header{border-bottom: 1px solid #dbdbdb;}

  .trads-offer{
      color:#FF3500;
  }
  .tradsman-banner .card{
      background:#fff;
      border-radius:5px;
      padding:20px 10px 10px 30px;
      margin-bottom: 10px;
  }
  .tradsman-banner .card p{
      font-size:18px;
      font-weight:500;
  }
  	
  .tt-menu {
      width: 100%; /* Make the dropdown the same width as the input */
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 4px;
      z-index: 1000; /* Ensure it appears above other elements */
  }

  .tt-suggestion {
      padding: 10px;
      cursor: pointer;
  }

  .tt-suggestion:hover {
      background-color: #f0f0f0;
  }	
  .live-chat h4, .live-chat1 h4{
    display: flex!important;
  }
</style>
<div class="modal fade viewaccount" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose Type</h4>
            </div>
            <div class="modal-body">
                <div class="msgs"></div>
                <div class="row">
                    <div class="col-sm-6 plan_bid">
                    <?php 
                        $get_commision=$this->common_model->get_commision();
                        $credit_amount=$get_commision[0]['credit_amount']; ?>
                        <p>If you select this option, then for every chat £<?=$credit_amount; ?> will be deducted from your wallet.</p>
                        <input type="hidden" name="job_ids" id="job_ids" value="">
                        <input type="hidden" name="poster_user" value="" id="poster_user">
                        <button class="btn btn-warning" onclick="pay_chats();">Pay as you go</button>
                    </div>
                    <div class="col-sm-6 plan_bid">
                        <p>If you select this option, then you have to purchase plan to place bid.</p>
                        <a href="<?=base_url('membership-plans'); ?>"><button class="btn btn-primary" style="position: absolute;bottom: 0;">Monthly Subscription</button></a>
                    </div>
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="customOfferPopUp" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content single-payment-offer" id="customOfferModalBody"></div>
    </div>
</div>

<?php if($this->session->userdata('user_id') && $this->session->userdata('type')!=3){ ?>

<div class="live-chat live-users" id="chat_user" style="display: none;" >
        
  <header class="clearfix">
    <a href="#" class="chat-close">x</a> 
    <div id="userdetail">
      <h4 class="mine_headr">
        <span id="image">
        </span>
        <span id="chatername"></span>
      </h4>
    </div>
  </header>
  <div class="chat">
    <div class="chat-history" id="usermsg"> 
      <div class="chhhat_list">
        <div >
          <ul id="get_chat" class="user_chat"></ul>
        </div>
      </div>
    </div> 
    <div class="form_middle chet_fix">
      <form id="send_msg" method="post" onsubmit="return send_msg();" class="fixed_1_bbb">
        <input name="rid" id="rid-footer" type="hidden" value="0">
        <input name="post_id" id="post_id-footer" type="hidden" value="0">
        <input name="type" id="type" type="hidden" value="<?=$this->session->userdata('type'); ?>">         
        <input name="chat_type" id="chat_type" type="hidden" value="">
        <input type="text" placeholder="Type your message…" name="ch_msg" id="ch_msg" autofocus required="">
        <input type="hidden"  name="check" id="check" autofocus>
        <button type="submit" id="btnbtn" class="btn btn_theme"><i class="fa fa-paper-plane"></i></button>
      </form>
    </div>
    <div class="great-offer-chat" id="great-offer1">
      <div class="great-offer-chat-heding">
        <h5>Select a Service</h5><a href="#" class="close">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
          </svg>
        </a>
      </div>
      <div class="great-offer-chat-middle">
          <ul class="great-offer-list" id="chatServiceList">
          </ul>
      </div>
    </div>

    <div class="great-offer-chat" id="great-offer2">
      <div class="great-offer-chat-heding">
        <h5>How would you liketo get paid?</h5><a href="#" class="close">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
          </svg>
        </a>
      </div>
      <div class="great-offer-chat-middle">
        <p class="text-muted">Get paid in full once the project is completed or break into a  small chunks called milestone to get paid as you go?</p>
          <ul class="great-offer-list">
            <li onclick="nextStep2(1)">
              <a href="#">
                <div class="box">
                <div class="img">
                  <img src="http://localhost/tradespeople/img/Contractor-Banner.jpg" alt="" />
                </div>
                <div class="des">
                <h3>Single Payment</h3>
                <p class="text-muted">Receive one payment for the entire project once completed</p>
              </div>
            </div>
              </a>
            </li>
            <li onclick="nextStep2(2)">
              <a href="#">
                <div class="box">
                <div class="img">
                  <img src="http://localhost/tradespeople/img/Contractor-Banner.jpg" alt="" />
                </div>
                <div class="des">
                <h3>Milestone</h3>
                <p class="text-muted">Work in gradual steps and get paid for each completed milestone.</p>
              </div>
            </div>
              </a>
            </li>
          </ul>
      </div>
      <div class="great-offer-chat-footer">
         <a href="#" class="back">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
          </svg> 
          <span>Back</span>
        </a>
      </div>
    </div>

    <div class="great-offer-chat" id="great-offer3">
      <form method="post" id="customOfferForm" style="background:none!important; padding: 0;">
        <input type="hidden" name="chatUserId" id="chatUserId"> 
        <input type="hidden" name="chatServiceId" id="chatServiceId"> 
        <input type="hidden" name="paymentType" id="paymentType"> 
        <div class="great-offer-chat-heding">
          <h5>Create a single payment offer</h5><a href="#" class="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
            </svg>
          </a>
        </div>
        <div class="great-offer-chat-middle">
          <div class="great-offer-singal">
            <h4 id="chatServiceTitle">Tradespeoplehub checks the service for authenticity</h4>
            <!-- <button type="submit" class="btn btn-outline-warning">Select A Package</button> -->
            <div class="package-img" id="chatServiceImage">
              <img src="http://localhost/tradespeople/img/team3.png" alt="" />
            </div>
            <label class="control-label">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="4" name="description" required placeholder="Offer Description..."></textarea>

            <p>Visit our tradesmen <a href="#">help centre</a></p>
            <p>please send us a message.</p>

            <div class="select-price-box">
              <div class="form-group">
                <label class="control-label"> Revision</label>
                <select class="form-control">
                  <option value="">Select</option>                 
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Delivery <span class="text-danger">*</span></label>
                <select name="delivery_days" class="form-control" required>
                  <?php
                    for($j=1; $j<=10;$j++){
                      echo '<option value="'.$j.'">'.$j.' Day</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label">Price <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="price" placeholder="0.00" required>
              </div>
            </div>

            <ul class="check-list">
              <li>
                <div class="form-check">
                  <div class="check-box">
                    <input class="checkbox-effect" id="is_expiry" type="checkbox" name="is_expiry">
                    <label for="is_expiry">Offer expiration time</label>
                  </div>
                </div>
                <div class="form-group">
                  <select disabled name="offer_expiry_day" id="offer_expiry_day" class="form-control">
                    <?php
                      for($i=1; $i<=10;$i++){
                        echo '<option value="'.$i.'">'.$i.' Day</option>';
                      }
                    ?>
                  </select>
                </div>
              </li>
              <li class="hide" id="exOfferTitle"><h3>Offer includes</h3></li>
            </ul>
          </div>
        </div>
        <div class="great-offer-chat-footer">
           <a href="#" class="back">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
            </svg> 
            <span>Back</span>
          </a>
           <button type="button" class="btn btn-warning" id="sendOfferBtn">Sand Offer</button>
        </div>
      </form>
    </div>

    <?php if($this->session->userdata('type') == 1): ?>
      <div class="great-offer-btn">
        <button type="submit" id="startCustomOffer" class="btn btn-warning">Custom Offer</button>     
      </div>
    <?php endif; ?>  
  </div>  
</div>
<script type="text/javascript">
  /* */
$(".great-offer-chat").hide();

$(".great-offer-chat-heding .close").click(function() {
  $(".great-offer-chat").hide();
});  

$("#startCustomOffer").click(function() {
  var tradesMan = <?php echo $this->session->userdata('user_id'); ?>;
  var chatUserId = $('#rid-footer').val();
  $('#chatUserId').val(chatUserId);
  $.ajax({
      url: '<?= site_url().'users/getServiceList'; ?>',
      type: 'POST',
      dataType: 'json',
      data: {'tradesMan': tradesMan},
      success: function(result) {
        if(result.status ==1){
          var services = result.services;
          var serviceHtml = '';
          services.forEach(function(service) {
            if (service.image) {
                var imagePath = `img/services/${service.image}`;
                if (service.image.endsWith('.mp4')) {
                    var serviceFile = '<img src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
                } else {
                    var serviceFile = '<img src="'+site_url+'img/services/'+service.image+'" alt="Service Image" width="50">';
                }
            } else {
                var serviceFile = '<img src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
            }

            serviceHtml += `<li onclick="nextStep(${service.id})">
              <a href="#">
                <div class="box">
                  <div class="img">
                    ${serviceFile}
                  </div>
                  <div class="des">
                    <h3>${service.service_name}</h3>
                  </div>
                </div>
              </a>
            </li>`;
          });
          $('#chatServiceList').html(serviceHtml);
        }else{
          var serviceHtml = `<li>
              <a href="#">
                <div class="box">
                  <div class="des">
                    <h3>Service not found</h3>
                  </div>
                </div>
              </a>
            </li>`;
          $('#chatServiceList').html(serviceHtml);
        }
        $("#great-offer1").show();          
      },
      error: function(xhr, status, error) {
          console.error('AJAX request failed:', status, error);
      }
  });      
});

$('#is_expiry').change(function() {
    if ($(this).is(':checked')) {
        $('#offer_expiry_day').prop('disabled', false);
    } else {
        $('#offer_expiry_day').prop('disabled', true);
    }
});

function nextStep(sId){

  //window.location.href = '<?php echo base_url().'custom_offer/send'; ?>/'+sId+'/'+$('#rid-footer').val();

  $('#chatServiceId').val(sId);
  $("#great-offer2").show();
  $("#great-offer1").hide();
}

function nextStep2(method){
  $("#great-offer2").show();
  $("#great-offer1").hide();

  var sId = $('#chatServiceId').val();

  var baseUrl = '<?php echo rtrim(base_url().'custom_offer/send', '/'); ?>'; // Ensure there's no trailing slash
  var sId = encodeURIComponent(sId); // Encode the sId
  var ridFooter = encodeURIComponent($('#rid-footer').val()); // Encode the value of #rid-footer
  var pMethod = encodeURIComponent(method); // Encode the pMethod
  var url = baseUrl + '/' + sId + '/' + ridFooter + '/' + pMethod;


  $.ajax({
    url: url,
    type: 'GET',
    processData: false,
    contentType: false,
    cache: false,
    success: function (resp) {
      $('#customOfferModalBody').html(resp);
      $('#customOfferPopUp').modal('show');
    }
  });
 
  //window.location.href = url;


  //window.location.href = '<?php echo base_url().'custom_offer/send'; ?>/'+sId+'/'+$('#rid-footer').val()+'?pMethod='+method;

  /*
  var pMethod = $('#paymentType').val(method);
  $.ajax({
    url: '<?= site_url().'users/getServiceDetail'; ?>',
    type: 'POST',
    dataType: 'json',
    data: {'sId': sId},
    success: function(result) {
      if(result.status ==1){
        var service = result.service;
          if (service.image) {
            var imagePath = `img/services/${service.image}`;
            if (service.image.endsWith('.mp4')) {
                var serviceFile = '<img src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
            } else {
                var serviceFile = '<img src="'+site_url+'img/services/'+service.image+'" alt="Service Image" width="50">';
            }
          } else {
              var serviceFile = '<img src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
          }

        $('#chatServiceTitle').text(service.service_name);
        $('#chatServiceImage').html(serviceFile);

        var exService = result.exServices;

        console.log(exService.length);

        if(exService.length > 0){
          $('#exOfferTitle').removeClass('hide');
          exService.forEach(function(exS) {
            var exServiceHtml = ` <li class="exServiceList">
                  <div class="form-check">
                  <div class="check-box">
                  <input class="checkbox-effect" id="${exS.ex_service_name}" type="checkbox" value="${exS.id}" name="ex_service[]">
                  <label for="${exS.ex_service_name}">${exS.ex_service_name}</label>
                </div>
              </div>
            </li>`;
            $('#exOfferTitle').after(exServiceHtml);
          });
        }else{
          $('#exOfferTitle').addClass('hide');
          $('.exServiceList').remove();
        }

      }else{
        $('#great-offer3').html('Service not found');
      }      
    },
    error: function(xhr, status, error) {
        console.error('AJAX request failed:', status, error);
    }
  });
  $("#great-offer2").hide();*/
}

$('#sendOfferBtn').on('click', function(){
  $('#sendOfferBtn').disabled = true;

  let isValid = true;
  let emptyFields = [];
  $('#customOfferForm textarea[required]').each(function() {
    if ($(this).val() === '') {
      isValid = false;
      emptyFields.push($(this).attr('name')); // Collect the name of the empty field
    }
  });

  $('#customOfferForm input[required]').each(function() {
    if ($(this).val() === '') {
      isValid = false;
      emptyFields.push($(this).attr('name'));
      // return false; // Break out of the loop
    }
  });

  if (!isValid) {
    let fieldNames = emptyFields.join(', ');
    swal({
      title: "Error",
      text: "Please fill out the following required fields: " + fieldNames,
      icon: "error",
      button: "OK"
    });
  } else {
    swal({
      title: "Send Offer",
      text: "Are you sure you want to send custom offer?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Send Offer',
      cancelButtonText: 'Cancel'
    }, function() {
      var formData = $('#customOfferForm').serialize();

      $.ajax({
        url: '<?= site_url().'users/sendCustomOffer'; ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',                   
        success: function(result) {
          if(result.status == 0){
            swal({
              title: "Error",
              text: result.message,
              type: "error"
            }); 
          }else if(result.status == 2){
            swal({
              title: "Login Required!",
              text: "If you want to order the please login first!",
              type: "warning"
            }, function() {
              window.location.href = '<?php echo base_url().'login'; ?>';
            }); 
          }else{
            swal({
              title: "Success",
              text: result.message,
              type: "success"
            }, function() {
                $(".great-offer-chat").hide();
            });
          }
        },
        error: function(xhr, status, error) {
                // Handle error
        }
      }); 
    });
  }  
});



// $(".great-offer-list .serviceList").click(function() {
//   var chatServiceId = $(this).attr('data-id');
//   $('#chatServiceId').val(chatServiceId);
//   $("#great-offer2").show();
//   $("#great-offer1").hide();
//  }); 

/*$("#great-offer2 .great-offer-list li").click(function() {
    //$("#great-offer3").show();
    $("#great-offer2").hide();
 }); */

$("#great-offer2 .back").click(function() {
    $("#great-offer2").hide();
    $("#great-offer1").show();
}); 

/*$("#great-offer3 .back").click(function() {
  $("#great-offer3").hide();
    $("#great-offer2").show();
});*/ 


</script>

<?php
$this->db->query("set sql_mode = ''");
$user_id = $this->session->userdata('user_id');
$type = $this->session->userdata('type');
$chat_list = $this->common_model->get_chat_list($user_id);
$total_unread = $this->common_model->GetColumnName('chat',array('receiver_id'=>$user_id,'is_read'=>0),array('count(id) as total'));
?>
<div class="live-chat1 live-users" id="chat_user_list">
  <header class="clearfix">
    <a href="#" class="chat-close1">x</a> 
    <div id="userdetail_list">
      <h4 class="mine_headr">
        <span id="image_list">
        </span>
        <span id="chatername_list">
          <h4 class="mine_headr"><span class="red-dot-foot" style="<?php echo ($total_unread['total'] > 0) ? 'block' : 'none'; ?>"></span> Chat <span class="footer_total_count">(<?php echo $total_unread['total']; ?>)</span></h4>
        </span>
      </h4>
    </div>
  </header>
  <div class="chat1" style="display: none;">
    <div class="chat-history" id="usermsg_list"> 
      <div class="chhhat_list">
        <div>
          <ul id="get_chat_list" class="user_chat1">
            <?php
              if($chat_list) {
                foreach($chat_list as $row) {             
                  if($row['post_id']) {
                    $rid = ($row['sender_id']==$user_id)?$row['receiver_id']:$row['sender_id'];
                    $get_job_details=$this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$row['post_id']),array('job_id','title','project_id','direct_hired','awarded_to'));
                    $sender = $this->common_model->get_single_data('users',array('id'=>$rid));

                    $serviceName = '';
                    if($row['type'] == 'service'){
                      $service = $this->common_model->GetSingleData('my_services',['id'=>$row['post_id']]); 
                      if(!empty($service)){
                        $totalChr = strlen($service['service_name']);
                        if($totalChr > 22 ){
                          $sname = substr($service['service_name'], 0, 21).'...';   
                        }else{
                          $sname = $service['service_name'];
                        }
                        $serviceUrl = base_url().'service/'.$service['slug'];
                        $serviceName = '<span class="time" style="display:block; font-size:12px;">'.$sname.'</span>';  
                      }             
                    }
            
                    if($type == 1){
                      $showName = $sender['f_name'].' '.$sender['l_name'];
                      $get_plan_bids=$this->common_model->get_single_data('user_plans',array('up_user'=>$user_id,'up_status'=>1),'up_id');
                      $get_chat_paid=$this->common_model->get_single_data('chat_paid',array('user_id'=>$user_id,'post_id'=>$row['post_id']));

                      if($get_job_details['direct_hired']==0 || ($get_plan_bids && $get_plan_bids['up_status']==1 && strtotime($get_plan_bids['up_enddate'])>=strtotime(date('Y-m-d')) || $get_plan_bids['valid_type']==1) || $get_chat_paid){
                        $onclick = 'get_chat_onclick('.$rid.','.$row['post_id'].');showdiv();';
                      } else {
                        $onclick = 'pay_chat_first('.$rid.','.$row['post_id'].',1);';
                      }
                      //$onclick = 'get_chat_onclick('.$rid.','.$row['post_id'].');showdiv();';
                    } else {
                      $showName = $sender['trading_name'];
                      $onclick = 'get_chat_onclick('.$rid.','.$row['post_id'].');showdiv();';
                    }
            
                    if($get_job_details['direct_hired']==1){              
                      $tradesman = $this->common_model->GetColumnName('users',array('id'=>$get_job_details['awarded_to']),array('trading_name'));
                      $jobName = 'Work for '.$tradesman['trading_name'];
                    } else {
                      $jobName = $get_job_details['title'];
                    }
            
                    if(strlen($jobName) > 30){
                      $jobName = substr($jobName,0,30).'...';
                    } 
                    $itemName = $row['type'] == 'service' ? $serviceName : '<span class="time" style="display:block; font-size:12px;">'.$jobName.'<span>';
                    $unread = $this->common_model->get_unread_by_sid_rid($user_id,$rid,$row['post_id']);
            ?> 
                    <li class="other-message">
                      <a href="javascript:void(0);" onclick="<?php echo $onclick; ?>">
                        <div class="message-data"> 
                          <?php  if($sender['profile']) { ?>
                          <img src="<?= site_url(); ?>img/profile/<?= $sender['profile']; ?>" alt="">
                          <?php } else{ ?>
                          <img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" alt="">
                          <?php } ?>
                          <div class="message me-message">
                            <span class="message-data-name"><?php echo $showName; ?> <?php ($unread[0]['total']>0) ? '('.$unread[0]['total'].')' : ''?></span>
                            <?php echo $itemName; ?>
                          </div>
                        </div>
                      </a>
                    </li> 
            <?php   
                  } 
                } 
              }else{
            ?>
                <div class="alert alert-warning">We did not find any records!</div>
            <?php  } ?>
          </ul>
        </div>

      </div>
    </div> 
  </div> 
</div>
<!-- footer -->
<?php } ?> 
 
<div class="footer" id="footer" style="padding:40px 0px 20px 0px">
  <div class="container">
  <div class="row">
    <div class="col-sm-8">
        <div class="row">
          
      <!-- loop -->
      <div class="col-sm-4">
        <div class="foot-menu">
        <h2>Homeowners</h2>
        <?php if($this->session->userdata('user_id')){ ?>
          <?php if($this->session->userdata('type')==2){ ?>
          <p><a href="<?=base_url('post-job'); ?>"><i class="fa fa-caret-right"></i> Post a job</a></p>
          <?php } ?>
        <?php }else{ ?>
        <p><a href="<?=base_url('post-job'); ?>"><i class="fa fa-caret-right"></i> Post a job</a></p>
        <?php } ?>
        <p><a href="<?=base_url('how-it-work'); ?>"><i class="fa fa-caret-right"></i> How it works</a></p>
        <?php if($this->session->userdata('user_id')){ ?>
          <?php if($this->session->userdata('type')==2){ ?>
          <p><a href="<?=base_url('find-tradesmen');  ?>"><i class="fa fa-caret-right"></i> Find tradesmen</a></p>
          <?php } ?>
        <?php }else{ ?>
          <p><a href="<?=base_url('find-tradesmen'); ?>"><i class="fa fa-caret-right"></i> Find tradesmen</a></p>
        <?php } ?>
        <?php /*<p><a href="<?=base_url('homeowner-support'); ?>"><i class="fa fa-caret-right"></i> Homeowner support</a></p> */ ?>
        <p><a href="<?=base_url('homeowner-help-centre'); ?>"><i class="fa fa-caret-right"></i> Help centre</a></p>
        <p><a href="<?=base_url('cost-guides'); ?>"><i class="fa fa-caret-right"></i> Cost guide</a></p>
        <?php /*if($this->session->userdata('user_id')){ ?>
          <p><a href="#" onclick="alert('coming soon');"><i class="fa fa-caret-right"></i> Live leads</a></p>
        <?php } else { ?>
          <p><a href="<?=base_url('login'); ?>"><i class="fa fa-caret-right"></i> Live leads</a></p>
        <?php } */?>
        </div>
      </div>
      <!-- loop -->
      
      
      
      <!-- loop -->
      <div class="col-sm-4">
        <div class="foot-menu">
        <h2>Tradesmen</h2>
        <?php if(!$this->session->userdata('user_id')){ ?> 
        
        <p><a href="<?=base_url('signup-step1'); ?>"><i class="fa fa-caret-right"></i> Sign up</a></p>
        
        <?php } ?>
        
        <p><a href="<?=base_url('register'); ?>"><i class="fa fa-caret-right"></i> How it works</a></p>
        <!--<p><a href="<?=base_url('how_it_work_tradesmen'); ?>"><i class="fa fa-caret-right"></i> How it works</a></p>-->
      
        <!--p><a href="<?=base_url('faq'); ?>"><i class="fa fa-caret-right"></i> FAQ</a></p-->
<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==1){ ?> 
          <p><a href="<?php echo base_url('find-jobs'); ?>"><i class="fa fa-caret-right"></i> Find Jobs</a></p>     
        <?php } } else { ?>
        <p><a href="<?php echo base_url('login'); ?>"><i class="fa fa-caret-right"></i> Find Jobs</a></p>
        <?php } ?>  
        <p><a href="<?=base_url('tradesman-help'); ?>"><i class="fa fa-caret-right"></i> Help Centre </a></p>
        
        </div>
      </div>
      <!-- loop -->
      
      <!-- loop -->
      <div class="col-sm-4">
        <div class="foot-menu">
        <h2>Company</h2>
        <p><a href="<?=base_url('about-us'); ?>"><i class="fa fa-caret-right"></i> About us</a></p>
        <!-- <p><a href="<?=base_url('testimonial'); ?>"><i class="fa fa-caret-right"></i> Testimonials</a></p>-->
        <p><a href="<?=base_url('contact'); ?>"><i class="fa fa-caret-right"></i> Contact us</a></p>
        <p><a href="<?=base_url('affiliate'); ?>"><i class="fa fa-caret-right"></i>Affiliate</a></p>
        <p><a href="<?=base_url('terms-and-conditions'); ?>"><i class="fa fa-caret-right"></i> Terms & Conditions</a></p>
        <!-- <p><a href="<?=base_url('privacy-policy'); ?>"><i class="fa fa-caret-right"></i> Privacy policy</a></p> -->
        <!--<p><a href="<?=base_url('cookie-policy'); ?>"><i class="fa fa-caret-right"></i> Cookie policy</a></p>-->
        <p><a href="<?=base_url('blog'); ?>"><i class="fa fa-caret-right"></i> Blog</a></p>
        
        </div>
      </div>
      <!-- loop -->
      
        </div>
    </div>
    <div class="col-sm-4">
    
       <div class="right-footer">
          <div class="foot-menu">
            <h2><img src="<?=base_url(); ?>img/logo.png"></h2>
          </div>
          <div><p>TradesPeopleHub connects homeowners <br>to trusted local tradespeople across the UK.</p></div>
          
          <div class="social-cions" style="margin:10px 0px 20px 0px;">
            <div class="">
              <?php if(1==2 && isset($pageName) && ($pageName=='blog' || $pageName=='cost-guides')){ ?>
              <!-- AddToAny BEGIN -->
              <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_button_facebook"><i class="fa fa-facebook"></i></a>
                <a class="a2a_button_twitter"><i class="fa fa-twitter"></i></a>
                <a class="a2a_button_pinterest"><i class="fa fa-pinterest-p"></i></a>
                <a target="_blank" href="https://www.instagram.com/tradespeoplehub.co.uk/"><i class="fa fa-instagram"></i></a>
              </div>
              <script async src="https://static.addtoany.com/menu/page.js"></script>
              <!-- AddToAny END --> 
              <?php } else { ?>
              <a target="_blank" href="https://www.facebook.com/Tradespeoplehub.co.uk/"><i class="fa fa-facebook"></i></a>
              <a target="_blank" href="https://twitter.com/tradespeoplehub"><i class="fa fa-twitter"></i></a>
              <a target="_blank" href="https://www.pinterest.co.uk/tradespeoplehub/"><i class="fa fa-pinterest-p"></i></a>
              <a target="_blank" href="https://www.instagram.com/tradespeoplehub.co.uk/"><i class="fa fa-instagram"></i></a>
              <?php } ?>
              
            </div>
          </div>

          <!-- <script>
            $(document).ready(function(){
              $('.foot-menu .nav.ftr li a.dropdown-toggle').click(function(e) {
                  e.preventDefault();
                  var $this = $(this);
                  if ($this.next().hasClass('show')) {
                      $this.next().removeClass('show');
                      $this.next().slideUp(350);
                      $this.removeClass('active');
                  } else {
                      $this.parent().parent().find('li .dropdown-menu').removeClass('show');
                      $this.parent().parent().find('li .dropdown-menu').slideUp(350);
                      $this.next().toggleClass('show');
                      $this.next().slideToggle(350);
                      $this.addClass('active');
                  }
              });
            });
          </script> -->
          <div class="foot-menu" style="margin:6px 0 20px;">
            <h2>Download our app</h2>
            <ul class="nav ftr">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  <img src="https://www.tradespeoplehub.co.uk/img/ios-appStore-transparent.png">
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-homeowners/id6450202456">Homeowner's app</a>
                  </li>
                  <li>
                    <a target="_blank" href="https://apps.apple.com/app/tradespeoplehub-for-provider/id6450201899">Tradespeople's app</a>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  <img src="https://www.tradespeoplehub.co.uk/img/google-appStore-transparent.png">
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradespeoplehub">Homeowner's app</a>
                  </li>
                  <li>
                    <a target="_blank" href="https://play.google.com/store/apps/details?id=com.tradesprovider">Tradespeople's app</a>
                  </li>
                </ul>
              </li>
            </ul>
            <!-- <div class="panel panel-default">
              <div class="panel-heading panel-heading-nav">
                 <ul class="nav nav-tabs">
                    <li role="presentation">
                       <a href="#one" aria-controls="one" role="tab" data-toggle="tab">
                         <img src="https://www.tradespeoplehub.co.uk/img/ios-appStore-transparent.png">
                       </a>
                    </li>
                    <li role="presentation">
                       <a href="#two" aria-controls="two" role="tab" data-toggle="tab">
                         <img src="https://www.tradespeoplehub.co.uk/img/google-appStore-transparent.png">
                       </a>
                    </li>
                 </ul>
              </div>
              <div class="panel-body">
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="one">
                      <ul class="appStore-options">
                        <li><a href="#">Homeowner app</a></li>
                        <li><a href="#">Tradespeople</a></li>
                      </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="two">
                      <ul class="appStore-options">
                        <li><a href="#">Homeowner app</a></li>
                        <li><a href="#">Tradespeople</a></li>
                      </ul>
                    </div>
                 </div>
              </div>
            </div> -->
          </div>
          <div class="">
            <img src="<?=base_url(); ?>img/payment-card.png">
          </div>
          
       </div>
    </div>
  </div>
    <div class="row">
      <!-- loop -->
      <div class="col-sm-3" style="display: none;">
        <div class="foot-menu">
        <h2>Advice centre</h2>
        <p><a href="<?=base_url('advice-guides'); ?>"><i class="fa fa-caret-right"></i> Advice guides</a></p>
        <p><a href="<?=base_url('hiring-advice'); ?>"><i class="fa fa-caret-right"></i> Hiring advice</a></p>
        <p><a href="<?=base_url('pricing-guides'); ?>"><i class="fa fa-caret-right"></i> Pricing guides</a></p>
       
        
        <p><a href=""><i class="fa fa-caret-right"></i> Ask a tradesman</a></p>
        </div>
      </div>
      <!-- loop -->
      <div class="col-sm-3" style="display: none;">
        <div class="foot-menu">
        <h2>Advice centre</h2>
        <p><a href="<?=base_url('advice-guides'); ?>"><i class="fa fa-caret-right"></i> Advice guides</a></p>
        <p><a href="<?=base_url('hiring-advice'); ?>"><i class="fa fa-caret-right"></i> Hiring advice</a></p>
        <p><a href="<?=base_url('pricing-guides'); ?>"><i class="fa fa-caret-right"></i> Pricing guides</a></p>
      
        
        <p><a href=""><i class="fa fa-caret-right"></i> Ask a tradesman</a></p>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- footer -->
<!-- copy -->
<div class="copyright">
  <div class="container">
  <P>&copy Copyright <?=date('Y');?> TradesPeopleHub. All Rights Reserved.</P> 
  <ul>
    <li style="margin:5px 0px 0px;">
      <a href="<?=base_url('cookie-policy'); ?>" style="color:#fff;"> Cookie policy</a>
    </li>
    <li style="margin:5px 0px 0px;">
      <a href="<?=base_url('privacy-policy'); ?>" style="color:#fff;"> Privacy policy</a>
    </li>
  </ul>
  </div>
</div>

<?php
if($this->session->userdata('user_id')){
$get_commision = $this->common_model->get_commision();
?>

<div class="modal fade" id="chat_payment_model" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Type</h4>
      </div>
      <div class="modal-body">
        <div class="msgs2"></div>
        <div class="row">
          <div class="col-sm-6 plan_bid">
            <input type="hidden" value="" value="0" id="pay_chat_job_id">
            <input type="hidden" value="" value="0" id="pay_chat_user_id">
            <p>To add credits on your wallet click on pay as you button.</p>
            <button class="btn btn-warning" id="pay_as_you_go_foot_chat">Pay as you go</button>
          </div>
          <div class="col-sm-6 plan_bid">
            <p>To become an active member click on monthly subscription button</p>
            <a href="<?php echo base_url('membership-plans'); ?>"><button class="btn btn-primary" style="position: absolute;bottom: 0;">Monthly Subscription</button></a>
          </div>
        </div>
        <div class="common_pay_main_div instant-payment-button__1" style="display:none;">
          <div class="alert alert-danger">Insufficient amount in your wallet. Click on pay now and add money to wallet. <span class="Current_wallet_amount__1"></span></div> <br>
          
          <div class="form-group">
            <label>Enter Amount</label>
            <input type="number" class="form-control" value="<?php echo $get_commision[0]['p_min_d']; ?>" onkeyup="check_value__1(this.value);" id="amount__1">
          </div>
          
          
          
          <p class="instant-err__1 alert alert-danger" style="display:none;"></p>
          
          <div class="card pay_btns__1 all-pay-tooltip">
            <div class="col-sm-2"  style="padding: 0;"></div>
            <div class="col-sm-4" style="padding: 0;">
              <div onclick="show_lates_stripe_popup(<?php echo $get_commision[0]['p_min_d']; ?>,<?php echo $get_commision[0]['p_min_d']; ?>,6);" class="pay_btn__1 strip_btn" id="strip_btn__1"><img src="<?= base_url(); ?>img/pay_with.png"></div> 
            </div>
            <div class="col-sm-4"  style="padding: 0;">
              <div class="pay_btn__1 paypal_btn" id="paypal_btn__1"></div>
            </div>
          </div>
          <div class="common_pay_loader pay_btns_laoder__1 text-center" style="display:none;"> 
            <i class="fa fa-spin fa-spinner" style="font-size:26px"></i> Processing...
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="contactServiceName">
<input type="hidden" id="contactServiceOrder">

<?php
if($pageName != 'proposals' && $pageName != 'payments' && $pageName != 'wallet' && $pageName != 'signup-step8' && $pageName != 'details' && $pageName != 'make-addon-payment'){;
?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<?php } ?>
<script>

$(document).ready(function(){
  show_main_btn_two__1();
});


var amount__1 = $('#amount__1').val();

function check_value__1(value){
  var min_amount = <?php echo $get_commision[0]['p_min_d']; ?>;
  var max_amount = <?php echo $get_commision[0]['p_max_d']; ?>;
  if(value >= min_amount && value <= max_amount){
    //$('.show_btn').prop('disabled',false);
    $('.instant-err__1').hide();
    $('.instant-err__1').html('');
    amount__1 = value;
    
    $('#strip_btn__1').attr('onclick','show_lates_stripe_popup('+amount__1+','+amount__1+',6);');
  
    show_main_btn_two__1();
  } else {
    $('.card__1').hide();
    //$('.show_btn').prop('disabled',true);
    $('.instant-err__1').show();
    $('.instant-err__1').html('Deposit amount must be more than <i class="fa fa-gbp"></i>'+min_amount+' and less than <i class="fa fa-gbp"></i>'+max_amount+'!');
    $('.pay_btns__1').hide();
  }
}

function show_main_btn_two__1(){
    $('.pay_btns__1').show();
    $('#paypal_btn__1').html('');
    
    var processing_fee = 0;
    var actual_amt = parseFloat(amount__1);
    
    var amount__1_wp = actual_amt;

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
            transactions: [
              {
                amount: { total: amount__1_wp, currency: 'GBP' }
              }
            ]
          }
        });
      },

      // onAuthorize() is called when the buyer approves the payment
      onAuthorize: function(data, actions) {  
        // Make a call to the REST api to execute the payment
        return actions.payment.execute().then(function() {
          console.log('Payment Complete!');
          $.ajax({
            type:'POST',
            url:site_url+'wallet/paypal_deposite',
            data:{
              itemPrice : amount__1,
              itemId : 'Deposit in wallet',
              orderID : data.orderID,
              txnID : data.paymentID,
            },
            dataType:'JSON',
            beforeSend:function(){
              $('.pay_btns__1').hide();
              $('.pay_btns_laoder__1').show();
            },
            success:function(resp){ 
              if(resp.status == 1) {
                var pay_chat_job_id = $('#pay_chat_job_id').val(); 
                var pay_chat_user_id = $('#pay_chat_user_id').val(); 
                pay_chat(pay_chat_user_id,pay_chat_job_id);
              } else {
                $('.pay_btns__1').show();
                $('.pay_btns_laoder__1').hide();
                toastr.error(resp.msg);
              }
            }
          });
        });
      }
    }, '#paypal_btn__1');
}
function pay_chat(id,post) {
  $.ajax({
    type:'POST',
    url:site_url+'chat/pay_chat',
    data:{id:id,post:post},
    dataType:'JSON',
    async:false,
    success:function(resp)
    {
      if(resp.status==1)
      {
        //$(".close").trigger("click");
        //get_chat_onclick(id);
        //showdiv();
        location.reload();
      } 
      else
      {
        $('.instant-payment-button__1').show();
        $('.msgs2').html(resp.msg);
        $('.pay_btns__1').show();
        $('.Current_wallet_amount__1').html('Your last updated wallet amount is <i class="fa fa-gbp"></i>'+resp.wallet);
        $('.pay_btns_laoder__1').hide();
      }
    }
  });
  return false;
}

function pay_chat_first(id,post,comm) {
  $('#pay_chat_job_id').val(post);
  $('#pay_chat_user_id').val(id);
  $('#pay_as_you_go_foot_chat').attr('onclick','pay_chat('+id+','+post+');');
  
  $('.chat-close').trigger('click');
    $.ajax({
      type:'POST',
      url:site_url+'chat/pay_chat',
      data:{id:id,post:post},
      dataType:'JSON',
      async:false,
      beforeSend:function(){
        $('.my-chat-'+id).prop('disabled',true);
        $('.my-chat-'+id).html('<i class="fa fa-spin fa-spinner"></i>');
      },
      success:function(resp)
      {
        if(resp.status==1)
        {
          //$(".close").trigger("click");
          get_chat_onclick(id, post);
          showdiv();
          location.reload();
        } 
        else
        {
          $('.my-chat-'+id).prop('disabled',false);
          $('.my-chat-'+id).html('Chat');
          $('.msgs2').html(resp.msg);
          $('#chat_payment_model').modal('show');
        }
      }
    });
  //}
  return false;
}

</script>
<?php } ?>

<?php if($this->session->userdata('user_id')){ ?>
<?php if($pageName != 'billing-info' && $pageName != 'signup-step8'){ ?>
<script src="https://js.stripe.com/v3/"></script>

<div class="modal fade" id="latest_stripe_modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pay with card</h4>
      </div>
      <form id="latest-stipe-from">
        <div class="modal-body">
          <div class="latest_stripe_err"></div>
          <div class="row">
            <div class="col-sm-12  text-center">
              <div class="Wallet_1 well wel-main">
                <h3 class="text"> <i class="fa fa-money"></i> Amount <span><i class="fa fa-gbp"></i><span class="latest-strip-deposit-amount"></span></span> </h3>
              </div>
            </div>
          </div>
          <?php 
          $saveCards = $this->common_model->get_data('save_cards',['status'=>1,'user_id'=>$user_id]);
          //
          ?>
          <div class="row">
            <div class="col-sm-12 card-table">
              <?php if(!empty($saveCards)){ ?>
              <div class="row card_details">
                <div class="col-md-3"><label>Select Card</label></div>
                <div class="col-md-3"><label>Card Number</label></div>
                <div class="col-md-3"><label>Expire date</label></div>
                <div class="col-md-3"><label>Name on card</label></div>
              </div>
              
              <?php foreach($saveCards  as $key => $saveCard){ ?>
              <div class="card-detail">
                <div class="row">
                  
                  <div class="col-md-3">

                    <input type="radio" name="paymentFrom" id="<?= $saveCard['id']; ?>" value="<?= $saveCard['id']; ?>" <?php echo ($key==0)?'checked':'';  ?>>
                    <label for="<?= $saveCard['id']; ?>"><img src="<?php echo base_url('asset/admin/img/card-logo/'.$saveCard['brand'].'.svg') ?>"></label>
                  </div>
                  <div class="col-md-3">**** **** **** <?= $saveCard['last4']; ?></div>
                  <div class="col-md-3"><?= $saveCard['exp_month']; ?>/<?= $saveCard['exp_year']; ?></div>
                  <div class="col-md-3"><?= $saveCard['u_name']; ?></div>
              
                </div>
              </div>
              
              <?php } ?>
              <?php } ?>
              
              <div class="card-detail mt-5" style="display:<?php echo (empty($saveCards))? 'none':'block' ?>;">
                <div class="row">
                  <div class="col-md-3 radio-custom"> 
                    <input type="radio" class="" <?php if(empty($saveCards)){ echo 'checked'; } ?> name="paymentFrom" value="0" id="plus">

                    <label for="plus" class="radio-custom-label"> 
                     Add card</label>
                   </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <hr>
            <div class="col-sm-12">
              <br>
              <div class="form-group" id="card_u_name_div" style="display:none;">
                <label>Name on Card</label>
                <input type="text" name="card_u_name"  id="card_u_name" minlength="2" placeholder="Enter name"  value="" class="form-control" autofocus="" >
              </div>
              <div id="card-element" style="display:none;"><!--Stripe.js injects the Card Element--></div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              
              <p id="latest-stripe-card-error" class="text-danger" role="alert"></p>
              
            </div>
          </div>
          <!-- <div class="row text-center">
            <div class="col-sm-12">
              <button class="btn btn-primary btn-lg" id="latest-stipe-submit">
                <span class="fa fa-spin fa-spinner" style="display:none;" id="latest-stipe-spinner"></span>
                <span id="button-text">Pay</span>
              </button>
            </div>
          </div> -->
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="latest-stipe-submit">
            <span class="fa fa-spin fa-spinner" style="display:none;" id="latest-stipe-spinner"></span>
            <span id="button-text">Pay</span>
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php if(!empty($saveCards)){ ?>
  <script type="text/javascript">
    $("#latest-stipe-submit").removeAttr('disabled');
    $('#card-element').hide();
    $('#card_u_name_div').hide();
    $('#card_u_name').removeAttr('required');

    $('.radio-custom').on('click', function() {
      $('#card-element').show();
      $('#card_u_name_div').show();
      $('#card_u_name').attr('required', 'required');

    })
  </script>
<?php }else{ ?>
  <script type="text/javascript">

    $('#card-element').show();
    $('#card_u_name_div').show();
    $('#card_u_name').attr('required', 'required');
  $("#latest-stipe-submit").prop('disabled',true);
    
  </script>
<?php } ?>

<script>
/*
type = 1 deposite in wallet 
type = 2 buy membership-plans 
type = 3 Bid on post 
type = 4 Accept proposals 
type = 5 Accept direct_hired 
type = 6 pay chat direct_hired 
type = 7 create milestones
type = 8 Accept milestones
type = 9 add addon
type = 10 ask admin to step in
 

*/
var stripe = Stripe('<?php echo $this->config->item('stripe_key'); ?>');
function show_lates_stripe_popup(amount,actual_amt,type,onSuccess=null,onError=null,onCancel=null){
  $('#pay_when_accept_direct_hire_model').modal('hide');

  $('.latest-strip-deposit-amount').html(amount);
  
  $('#latest_stripe_modal').modal({
    backdrop: 'static',
    keyboard: false
  });
  
  // $("#latest-stipe-submit").prop('disabled',true);  
  var statement_descriptor = 'Diposit in wallet';  
  if(type==2){
    statement_descriptor = 'Subscription renewed';
  } else if(type==9){
    statement_descriptor = 'Buy addon';
  }
  
  fetch(site_url+"home/createPaymentIntent/"+amount+"/"+type, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    }
  }).then(function(result) {
      return result.json();
  }).then(function(data) {
    var elements = stripe.elements();
    var style = {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    };
    
    var card = elements.create("card", { style: style });
    // Stripe injects an iframe into the DOM
    card.mount("#card-element");
    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      $("#latest-stipe-submit").prop('disabled',false);
      
      $("#latest-stripe-card-error").html(event.error ? event.error.message : "");
    });
    
    var form = document.getElementById("latest-stipe-from");
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      
      // Complete payment when the submit button is clicked
      
      
      var paymentFrom = $('input[type=radio][name=paymentFrom]:checked').val();
      paymentFrom = parseInt(paymentFrom);
      var card_u_name = $('#card_u_name').val();
      if(paymentFrom==0 || paymentFrom==undefined){
        // alert(card_u_name);
        payWithCard(actual_amt,stripe, card, data.clientSecret, data.customerID,type,onSuccess,onError,onCancel,card_u_name);
      } else {
        console.log('payWithSaveCard');
        payWithSaveCard(actual_amt,type,paymentFrom,onSuccess,onError,onCancel);
      }
    });
  });
}
var payWithCard = function(actual_amt,stripe, card, clientSecret, customerID,type,onSuccess=null,onError=null,onCancel=null,card_u_name) {
  loading(true);
  stripe.confirmCardPayment(clientSecret, {
    payment_method: {
      card: card
    },
  }).then(function(result) {
    if (result.error) {
      // Show error to your customer
      showError(result.error.message,result,type,onSuccess,onError,onCancel);
    } else {
      // The payment succeeded!
      orderComplete(actual_amt,result,customerID,type,onSuccess,onError,onCancel,card_u_name);
    }
  });
};
/* ------- UI helpers ------- */
// Shows a success message when the payment is complete
var orderComplete = function(actual_amt,result,customerID,type,onSuccess=null,onError=null,onCancel=null,card_u_name) {
  
  if(result.paymentIntent.status=='succeeded'){
    saveCards(customerID,result.paymentIntent.payment_method,card_u_name);
    // return false;
  }
  
 
  //$("#latest-stripe-card-error").hide();
  //$("#latest-stipe-submit").prop('disabled',false);
  if(type==2){
    
    $.ajax({
      type:'post',
      url:site_url+'subcription_plan/pay_membership_plan',
      dataType:'JSON',
      data:{data:result,customerID:customerID,plan_id:onSuccess},
      success:function(res){
        if(res.status == 1){
         window.location.href = site_url + 'subscription-plan';
        } else {
          loading(false);
          swal('Some problem occurred, please try again.');
        }
      }
    });
    
  } else if(type==9) {
    
    buy_addons(onSuccess);

  } else {
    $.ajax({
      type:'post',
      url:site_url+"wallet/newStripeSuccess",
      dataType:'JSON',
      data:{data:result,actual_amt:actual_amt,customerID:customerID},
      success:function(res){
        
        if(res.status == 1){
        
          if(type==1){
          
          window.location.href=site_url+'wallet';
          
          } else if(type==3){
            
            $('#latest_stripe_modal').modal('hide');
            $('#post_bid').submit();
            
          } else if(type==4){
            
            show_loader = true;
            
            $('#latest_stripe_modal').modal('hide');
            accept_post(onSuccess,3);
        
          } else if(type==5){
            
            $('#latest_stripe_modal').modal('hide');
            $('.instant-payment-button___1').hide();
            $('.pay_btns_laoder___1').hide();
        
            accept_award123(onSuccess,7);
          
          } else if(type==6){
            
            $('#latest_stripe_modal').modal('hide');
            $('.instant-payment-button__1').hide();
            $('.pay_btns_laoder__1').hide();
            var pay_chat_job_id = $('#pay_chat_job_id').val(); 
            var pay_chat_user_id = $('#pay_chat_user_id').val(); 
            pay_chat(pay_chat_user_id,pay_chat_job_id);
          } else if(type==7){
            
            $('#latest_stripe_modal').modal('hide');
            
            var post_id = <?php echo ($_REQUEST['post_id'])?$_REQUEST['post_id']:0; ?>;
            
            $('.instant-payment-button').hide();
            $('.pay_btns_laoder').hide();
            $('#post_mile'+post_id).submit();
            
          } else if(type==8){
            
            $('#latest_stripe_modal').modal('hide');
            
            $('.instant-payment-button_'+onSuccess).hide();
            $('.pay_btns_laoder_'+onSuccess).hide();
          
            $('#accept_releaseMSForm'+onSuccess).submit();
          } else if(type==10){
            $('#latest_stripe_modal').modal('hide');
            
            $('.pay_btns__1').hide();
            $('.instant-err___1').hide();
            $('.pay_btns_laoder___1').hide();
            submitAsktoAdmin();
          } else if(type==11){
            $('#latest_stripe_modal').modal('hide');            
            $('#checkoutBtn').trigger('click');
          } else {
            loading(false);
            swal('Some problem occurred, please try again.');
          }
          
          $('#latest-stipe-submit').prop('disabled',false);
          $('#latest-stipe-submit').html('Pay');
          
        } else {
          loading(false);
          swal('Some problem occurred, please try again.');
        }
      }
    });
  }
  
};


var payWithSaveCard = function(actual_amt,type,cardID,onSuccess,onError,onCancel) {
  
  loading(true);
  //$("#latest-stripe-card-error").hide();
  //$("#latest-stipe-submit").prop('disabled',false);
  if(type==2){
    // alert('coming soon'); return false;
    $.ajax({
      type:'post',
      url:site_url+'subcription_plan/pay_membership_plan',
      dataType:'JSON',
      // data:{data:result,customerID:customerID,plan_id:onSuccess},
      data:{plan_id:onSuccess, cardID:cardID,actual_amt:actual_amt},
      
      success:function(res){
        if(res.status == 1){
         window.location.href = site_url + 'subscription-plan';
        } else {
          loading(false);
          swal('Some problem occurred, please try again.');
        }
      }
    });
    
  } else if(type==9) {
    // alert('coming soon'); return false;
    // alert('coming soon buy_addons');
    buy_addons(onSuccess, cardID, actual_amt);

  } else {
    $.ajax({
      type:'post',
      url:site_url+"wallet/newStripeSuccess",
      dataType:'JSON',
      data:{cardID:cardID,actual_amt:actual_amt},
      success:function(res){
        
        if(res.status == 1){
        
          if(type==1){
          
            window.location.href=site_url+'wallet';
          
          } else if(type==3){
            // alert(type);
            
            $('#latest_stripe_modal').modal('hide');
            $('#post_bid').submit();
            
          } else if(type==4){
            
            show_loader = true;
            
            $('#latest_stripe_modal').modal('hide');
            accept_post(onSuccess,3);
        
          } else if(type==5){
            
            $('#latest_stripe_modal').modal('hide');
            $('.instant-payment-button___1').hide();
            $('.pay_btns_laoder___1').hide();
        
            accept_award123(onSuccess,7);
          
          } else if(type==6){
            
            $('#latest_stripe_modal').modal('hide');
            $('.instant-payment-button__1').hide();
            $('.pay_btns_laoder__1').hide();
            var pay_chat_job_id = $('#pay_chat_job_id').val(); 
            var pay_chat_user_id = $('#pay_chat_user_id').val(); 
            pay_chat(pay_chat_user_id,pay_chat_job_id);
          } else if(type==7){
            
            $('#latest_stripe_modal').modal('hide');
            
            var post_id = <?php echo ($_REQUEST['post_id'])?$_REQUEST['post_id']:0; ?>;
            
            $('.instant-payment-button').hide();
            $('.pay_btns_laoder').hide();
            $('#post_mile'+post_id).submit();
            
          } else if(type==8){
            
            $('#latest_stripe_modal').modal('hide');
            
            $('.instant-payment-button_'+onSuccess).hide();
            $('.pay_btns_laoder___1').hide();
          
            $('#accept_releaseMSForm'+onSuccess).submit();
        
          } else if(type==10){
            $('#latest_stripe_modal').modal('hide');
            
            $('.pay_btns_laoder___1').hide();
            submitAsktoAdmin();
          }else if(type==11){
            $('#latest_stripe_modal').modal('hide');            
            $('#checkoutBtn').trigger('click');
          } 
          
          $('#latest-stipe-submit').prop('disabled',false);
          $('#latest-stipe-submit').html('Pay');
          
        } else {
          loading(false);
          swal('Some problem occurred, please try again.');
        }
      }
    });
  }
  
};

// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText,result,type,onSuccess=null,onError=null,onCancel=null) {
  loading(false); 

  $("#latest-stripe-card-error").show();
  $("#latest-stripe-card-error").html(errorMsgText);

  $('#latest-stipe-submit').prop('disabled',false);
    $('#latest-stipe-spinner').hide();
    $('#button-text').show();
  
  /*$.ajax({
    type:'post',
    url:site_url+"wallet/newStripeError",
    data:{data:result},
    dataType:'JSON'
  });*/
  
  /*setTimeout(function() {
    errorMsg.textContent = "";
  }, 4000);*/

};
// Show a spinner on payment submission
var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    $('#latest-stipe-submit').prop('disabled',true);
    $('#latest-stipe-spinner').show();
    $('#button-text').hide();
    
  } else {
    $('#latest-stipe-submit').prop('disabled',false);
    $('#latest-stipe-spinner').hide();
    $('#button-text').show();
  }
};

</script>
<?php } ?>
<?php } ?>

<script>
  function saveCards(customerID,payment_method,card_u_name){
    $.ajax({
      type:'post',
      url:site_url+'wallet/saveCards',
      dataType:'JSON',
      data:{payment_method:payment_method,customerID:customerID,card_u_name:card_u_name},
      success:function(res){
        console.log(res);
      }
    });
  }
  var owl = $('.banner-slider');
  owl.owlCarousel({
    margin: 10,
    autoplay:true,
    autoplayTimeout:5000,
    responsive: {
      1000: {
        items: 1
      },
      0: {
        items: 1
      }
    }
  })
  var owl = $('.testimonial-slider');
  owl.owlCarousel({
    margin: 10,
    loop: true,
    responsive: {
      1000: {
        items: 1
      },
      0: {
        items: 1
      }
    }
  })

  $(function(){
    $('input[type=radio][name=paymentFrom]').change(function() {
      if (this.value == '0') {
        $('#card-element').show();
        $('#card_u_name_div').show();
        $('#card_u_name').attr('required', 'required');
      } else {
        $('#card-element').hide();
        $('#card_u_name_div').hide();
        $('#card_u_name').removeAttr('required');
        loading(false);

      }
      $('#latest-stripe-card-error').html('');
    });
  })
</script>

<script>
  $(document).ready(function(){
    //$('[data-toggle="tooltip"]').tooltip();
    (function() {
      $('.live-chat header').on('click', function() {
        $(this).next('.chat').slideToggle(300, 'swing');
      });
      
      $('.live-chat1 header').on('click', function() {
        $(this).next('.chat1').slideToggle(300, 'swing');
      });

      $('.chat-close').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.live-chat').fadeOut(300);
        $('#rid-footer').val(0);
        $('#post_id-footer').val(0);
      });

      /*$('.open-chat').on('click', function() {
        $('.live-chat').toggle();
      });*/

    })();
  });

  function showdiv(){
     $('#chat_user').show();    
  }

  function get_chat_onclick(id,post_id){
    //if(id && post_id){
      $('#rid-footer').val(id);
      $('#post_id-footer').val(post_id);
      var serviceName = $('#contactServiceName').val();
      var lastOrder = $('#contactServiceOrder').val();
      
      $.ajax({
        type:'POST',
        url:site_url+'chat/get_chats',
        data:{id:id,post:post_id,serviceName:serviceName,lastOrder:lastOrder},
        dataType:'JSON',
        success:function(resp) {
          if(resp.status==1) {
            $('#rid-footer').val(id);
            $('#userdetail').html(resp.userdetail);
            var oldscrollHeight = $("#usermsg").prop("scrollHeight");         
            $('.user_chat').html(resp.data);  
            var newscrollHeight = $("#usermsg").prop("scrollHeight");
            if (newscrollHeight > oldscrollHeight) {
              $("#usermsg").animate({
                scrollTop: newscrollHeight
              }, 'normal');
            }
          } else {
            $('#userdetail').html(resp.userdetail);
            $('.user_chat').html(resp.data); 
          }
        }
      });
    //}
    return false;
  }

  function get_chat_history_interwal(){
    var id = $('#rid-footer').val();
    var post_id = $('#post_id-footer').val();
    if(id && post_id && id > 0 && post_id > 0)
    {
      get_chat_onclick(id,post_id);
    }else{
      get_chat_onclick(id,0);
    }
  }

  function send_msg(){
    var post = $('#post_id-footer').val();
    $.ajax({
      type:'POST',
      url:site_url+'chat/send_msg',
      data:$('#send_msg').serialize(),
      dataType:'JSON',
      success:function(resp)
      {
        if(resp.status==1)
        {
          $('#ch_msg').val('');
        }
      }
    });
    return false;
  }

  function get_unread_msg_count(post_id, rid){
    $.ajax({
      type:'POST',
      url:site_url+'chat/get_unread_msg_count',
      data:{post:post_id,rid:rid},
      dataType:'JSON',
      success:function(resp)
      {
        if(resp.status==1)
        {
          $('.count_un_msg'+rid).html('('+resp.count+')');
          get_chat_onclick(rid,post_id);
          //showdiv();
        }
        else
        {
          $('.count_un_msg'+rid).html('');
        }
      }
    });
    return false;
  }

  function user_list_refresher(){
    $.ajax({
      type:'POST',
      url:site_url+'chat/user_list_refresher',
      dataType:'JSON',
      success:function(resp)
      {
        if(resp.status==1)
        {
          $('#get_chat_list').html(resp.list);
          $('.footer_total_count').html('('+resp.count+')');
          
          if(resp.count > 0){
            $('.red-dot-foot').show();
          } else {
            $('.red-dot-foot').hide();
          }
          //showdiv();
        }
      }
    });
  }
  //setInterval(function(){ get_chat_history_interwal(); }, 5000);
  //setInterval(function(){ user_list_refresher(); }, 5000);
</script>

<script>
  $(document).ready(function(){
    var user = accessCookie("testCookie");
    if (user!="") {
      $(".cookies").hide();
    } else {
      $(".cookies").show();
    }
  });
</script>
<script type="text/javascript">
  function createCookie(cookieName,cookieValue,daysToExpire) {
    var date = new Date();
    date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
    document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
  }

  function accessCookie(cookieName) {
    var name = cookieName + "=";
    var allCookieArray = document.cookie.split(';');
    for(var i=0; i<allCookieArray.length; i++){
      var temp = allCookieArray[i].trim();
      if (temp.indexOf(name)==0)
      return temp.substring(name.length,temp.length);
    }
    return "";
  }
    
  function checkCookie() {
    var user = accessCookie("testCookie");
    if (user!="") {
      $(".cookies").hide();
    } else {
      user = "p";
      num = 7;
      if (user!="" && user!=null) {
        createCookie("testCookie", user, num);
        $(".cookies").hide();
      }
    }
  }    
</script>
<style>
  .cookies {
      position: fixed;
      bottom: 0px;
      right: 0px;
      width:100%;
      background: rgba(00,00,00,0.8);
      color: #fff;
      padding: 15px;
    z-index:9999;
  }
  .cookies-text {
    padding-right: 80px;
    position: relative;
  }
  .cookies-close {
    background: #207cdf;
    border-radius: 5px;
    display: inline-block;
    font-size: 16px;
    font-weight: 600;
    padding: 6px 18px;
    position: absolute;
    right: 0;
    top: 0;
  }
  .footer .panel {
    background-color: transparent;
  }
  .footer .panel.panel-default::before {
    background-color: transparent;
    width: 0;
    height: 0;
  }
  .footer .panel .nav-tabs {
    border: 0;
  }
  .footer .nav>li {
    margin-right: 10px;
  }
  .footer .nav>li:last-child {
    margin-right:0px;
  }
  .footer .panel-default>.panel-heading {
      color: #ffffff;
      background-color: transparent;
      border-color: transparent;
      padding: 0;
      border: 0;
  }
  .footer .nav-tabs>li>a {
      margin-right: 0;
      line-height: normal;
      border: 0;
      border-radius: 0;
      padding: 0;
  }
  .footer .nav-tabs>li.active>a, .footer .nav-tabs>li.active>a:hover, .footer .nav-tabs>li.active>a:focus, 
  .footer .nav>li>a:hover, .footer .nav>li>a:focus {
    color: #ffffff;
    border: 0;
    background-color: #3d78cb;
    border-color: transparent;
  }
  .footer .nav a img {
      max-width: 100%;
      width: 100px;
      height: auto;
      object-fit: contain;
  }
  .footer .tab-content>.tab-pane {
    margin-top: 10px;
  }
  .footer .tab-content ul {
    padding: 0;
    margin: 0;
    list-style-type: none;
    display: flex;
    flex-flow: column;
  }
  .footer .tab-content ul li, 
  .footer .tab-content ul li a {
    color: #ffffff;
  }
  .footer .foot-menu .nav.ftr {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: flex-start;
  }
  .footer .foot-menu .nav.ftr li a {
      width: fit-content;
      padding: 0;
  }
  .footer .foot-menu .nav.ftr li .dropdown-menu>li>a {
      width: 100%;
      padding: 3px 20px;
  }
  .footer .foot-menu .nav.ftr .dropdown.open>a {
    background-color: transparent;
  }
  .footer .foot-menu .nav.ftr .dropdown.open>a:hover, 
  .footer .foot-menu .nav.ftr .dropdown.open>a:focus {
    background-color: #3d78cb;
  }
  .footer .foot-menu .nav.ftr .dropdown:hover>.dropdown-menu {
      display: none;
  }
  .footer .foot-menu .nav.ftr .dropdown.open>.dropdown-menu {
      display: block !important;
  }
  @media only screen and (max-width: 767px) {
    .footer .panel .nav {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .footer .foot-menu .nav.ftr {justify-content: center;}
    .footer .foot-menu .nav.ftr .dropdown>.dropdown-menu {padding: 5px 0;position: absolute;}
  }
</style>
<div class="cookies" id="cheack_float" style="display:none;">
  <div class="cookies-inner">
    <div class="cookies-text">
      We use cookies on this site to improve our users experience and for the purposes explained in our <a href="<?=site_url('cookie-policy'); ?>">cookie policy</a>. By proceeding, you agree to <a href="<?=site_url('terms-and-conditions'); ?>">our terms</a>
      <div onclick="checkCookie();" style="cursor:pointer" class="cookies-close">OK, got it</div>
    </div>
  
  </div>
</div>

  <script type="text/javascript">

   function checkOffset() {
  if($('#cheack_float').offset().top + $('#cheack_float').height() 
                                         >= $('#footer').offset().top - 10)
      $('#cheack_float').css('position', 'relative');
  if($(document).scrollTop() + window.innerHeight < $('#footer').offset().top)
      $('#cheack_float').css('position', 'fixed'); // restore when you scroll up
  // $('#cheack_float').text($(document).scrollTop() + window.innerHeight);
}
$(document).scroll(function() {
  checkOffset();
});
</script>

<?php /*
$script_details=$this->common_model->get_single_data('home_content',array('id'=>1));
echo $script_details['body_script'];*/
?>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-app.js";
  import { getMessaging, getToken , onMessage  } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-messaging.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-analytics.js";
  const firebaseConfig = {
      apiKey: "AIzaSyCf2hxRR5qvaAocU1foSeyCT0Wb_JDbbCk",
      authDomain: "tradespeoplehub-f4fbf.firebaseapp.com",
      projectId: "tradespeoplehub-f4fbf",
      storageBucket: "tradespeoplehub-f4fbf.appspot.com",
      messagingSenderId: "132127313614",
      appId: "1:132127313614:web:d4183282a65df1746b8a9f",
      measurementId: "G-Y9PYEX7SB9"
  };
  const app = initializeApp(firebaseConfig);

  const messaging = getMessaging(app);
  function requestPermission() {
      console.log("Requesting permission...");  
      Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");      
            getToken(messaging, {
              vapidKey:
                  "BAoOqRYuEpTb7kxPPvuI4pMJ8azN_avfQAUGqFZd537JAdGvqlqs-0eRHNAgbYNMhWzDPkiPVhZliYvF8b_ZgoQ",
            }).then((currentToken) => {
            if (currentToken) {
                console.log("currentToken: ", currentToken);
                var device_id = currentToken;
                updateDeviceId(currentToken);
                localStorage.setItem("device_id",currentToken);
              //$('body').html(currentToken)
          } else {
            console.log("Can not get token");
          }
        });
      } else {
        console.log("Do not have permission!");
      }

    });
  }

  function updateDeviceId(device_id){
    //alert(device_id);
    <?php if($this->session->userdata('user_id')) { ?>
    $.ajax({
         url: '<?= base_url('home/update_device_id') ?>',
         type: 'post',
         data: {'device_id' : device_id},
         dataType: 'json',
         success: function (data) {
          console.log('device_id updated',data)
         }
      });
    <?php } ?>
  }
  //requestPermission();
</script>

<?php if($this->session->userdata('type')==1){ ?>
<!-- Modal -->
<div id="invite_review" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invite to review</h4>
      </div>
      <form id="send_review_invitation" onsubmit="return send_review_invitation();">
        <div class="modal-body">
          <div class="err-Rev"></div>
          <div class="form-group">
            <label>Select Job</label>
            <select class="form-control" onchange="get_home_email_by_job_id(this.value);" name="review_job" id="review_job" <?=$required;?> >
              <?php
                if($isUrlExpired){
              ?>
                  <option value="">Please select a job</option>
              <?php
                }else{
              ?>
                  <option value="">Other job</option>
              <?php
                }
              ?>
              <?php
              $today = date('Y-m-d H:i:s');
              $check_date = date('Y-m-d H:i:s',strtotime($today.' - 24 hour'));
              
              $where_rew = "tbl_jobs.awarded_to = '".$user_profile['id']."' and tbl_jobs.direct_hired = '0' and (tbl_jobs.status = 4 or tbl_jobs.status = 7 or tbl_jobs.status = 9 or tbl_jobs.status = 10) and (select count(id) from tbl_milestones where tbl_milestones.post_id = tbl_jobs.job_id) = 0 and (select count(tr_id) from rating_table where rating_table.rt_jobid = tbl_jobs.job_id and rating_table.rt_rateBy = tbl_jobs.userid) = 0";
              
              $my_completed_job = $this->common_model->GetColumnName('tbl_jobs',$where_rew,array('title','job_id'),true,'tbl_jobs.job_id'); 
              
              //echo $this->db->last_query();
              //echo '<pre>'; print_r($my_completed_job); echo '</pre>';
              
              if(!empty($my_completed_job) && count($my_completed_job) > 0){ 
                foreach($my_completed_job as $Rkey => $Rrow){
                  echo '<option value="'.$Rrow['job_id'].'">'.$Rrow['title'].'</option>';
                } 
              } ?>
            </select>
          </div>
          <div class="form-group invite-email-div">
            <label>Enter recipient email address</label>
            <input type="email" class="form-control" value="" name="review_email" id="review_email" required>
            <input type="hidden" name="review_id" id="review_id" value="0">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>First name</label>
                <input type="text" class="form-control" name="f_name" id="Review_f_name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Last name</label>
                <input type="text" class="form-control" name="l_name" id="Review_l_name" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-invitation">Send invitation</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
  function get_home_email_by_job_id(id){
    if(id){
      $.ajax({
        type:'post',
        url:site_url+'users/get_home_email_by_job_id',
        data:{id:id},
        dataType:'json',
        success:function(res){
          if(res.status==1){
            $('#review_id').val(res.userid);
            $('#Review_l_name').val(res.l_name);
            $('#Review_f_name').val(res.f_name);
            $('#review_email').val(res.email);
            $('.invite-email-div').hide();
          } else {
            $('#review_id').val(0);
            $('.invite-email-div').show();
          }
        }
      });
    } else {
      $('#Review_l_name').val('');
      $('#Review_f_name').val('');
      $('#review_email').val('');
      $('#review_id').val(0);
      $('.invite-email-div').show();
    }
    return false;
  }
  function send_review_invitation(id){
    $.ajax({
      type:'post',
      url:site_url+'users/send_review_invitation/',
      data:$('#send_review_invitation').serialize(),
      dataType:'json',
      beforeSend:function(){
        $('.err-Rev').html('');
        $('.btn-invitation').prop('disabled',true);
        $('.btn-invitation').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      success:function(res){
        $('.err-Rev').html(res.msg);
        $('.btn-invitation').prop('disabled',false);
        $('.btn-invitation').html('Send invitation');
        if(res.status==1){
          setTimeout(function(){
            document.getElementById("review_job").selectedIndex = "0";
            $('.err-Rev').html('');
            $('#review_email').val('');
            $('#review_id').val('');
            $('#invite_review').modal('hide');
            $('.invite-email-div').show();
          },3000);
        }
      }
    });
    return false;
  }
</script>

<?php } ?>

<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-tagsinput.min.js">  
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.js"></script>
 
<script type="text/javascript">
  /*Check Logout Code Start*/

  let inactivityTime = function () {
    let time;
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer; 
    window.ontouchstart = resetTimer; 
    window.onclick = resetTimer;     
    window.onkeypress = resetTimer;   
    window.addEventListener('scroll', resetTimer, true);

    function logout() {
      $.ajax({
        url: 'home/auto_logout', // The endpoint to log out user
        method: 'POST',
        success: function (response) {
            window.location = 'login'; // Redirect to login page
        }
      });
    }

    function resetTimer() {
      clearTimeout(time);
      time = setTimeout(logout, 7200000);  // Auto logout after 30 minutes of inactivity
    }
  };

  inactivityTime();

  /*Check Logout Code End*/
  var monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
  ];
  $(document).ready(function() {
    var dateObjects  = [];
    if(selectedDate){
      dateObjects = JSON.parse(selectedDate).map(function(dateString) {
        var parts = dateString.split('/');
        var formattedDate = parts[2] + '-' + parts[0].padStart(2, '0') + '-' + parts[1].padStart(2, '0');
        return new Date(formattedDate);
    });
    }
    if($('#datepicker').length){
      var today = new Date();

      if(dateObjects.length > 0){
        $('#datepicker').multiDatesPicker({
          //minDate: 0, // Ensure today's date can be selected
          addDates: dateObjects,
          onSelect: function(dateText, inst) {
              var selectedDates = $('#datepicker').multiDatesPicker('getDates');
              $('#selectedDates').val(selectedDates.join(','));
              updateAvailabilityMessage();
          }
        });
      } else {
        $('#datepicker').multiDatesPicker({
          //minDate: 0, // Ensure today's date can be selected
          onSelect: function(dateText, inst) {
              var selectedDates = $('#datepicker').multiDatesPicker('getDates');
              $('#selectedDates').val(selectedDates.join(','));
              updateAvailabilityMessage();
          }
        });
      }

      <?php if(!isset($is_detail)): ?>
        $('#datepicker').datepicker("option", "disabled", true); // Disable datepicker by default
      <?php endif; ?>

      var selectedDates = $('#datepicker').multiDatesPicker('getDates');
      if (!selectedDates.includes(today.toISOString().slice(0, 10))) {
         //selectedDates.push(today.toISOString().slice(0, 10)); // Add current date if not already selected
      }
      $('#selectedDates').val(selectedDates.join(','));
      updateAvailabilityMessage();  
    }

    <?php $serviceData = $this->session->userdata('edit_service_data'); ?>
    <?php if(isset($serviceData['service_availiblity']['available_mon_fri']) && $serviceData['service_availiblity']['available_mon_fri'] == 'no'): ?>
      if(serviceOperationType == 'edit'){
        $('#noCheckbox').trigger('change');
      }
    <?php endif; ?>
    <?php if(isset($serviceData['service_availiblity']['available_mon_fri']) && $serviceData['service_availiblity']['available_mon_fri'] == 'yes'): ?>
      if(serviceOperationType == 'edit'){
        $('#yesCheckbox').trigger('change');
      }
    <?php endif; ?>
  });

  $('#datepickerAvailability').datepicker({
    minDate: 0,
    onSelect: function(dateText, inst) {
        $('#selectedDates').val(dateText);
    }
  });

  $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '.slider-nav'
  });

  $('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    arrows: true,
    focusOnSelect: true
  });

  $('.popular-subcategories-slider').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: false,
    variableWidth: true,
  });

  
  $('.category-list-slider').slick({
    dots: false,
    infinite: false,
    arrows: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    centerMode: false,
    variableWidth: true,
    adaptiveHeight: false,
  });
	
  $('.area').on('beforeItemAdd', function(event) {
      var tag = event.item;
      var regex = /^[a-zA-Z0-9\s]+$/;
      if (!regex.test(tag)) {
          event.cancel = true; // Cancel adding the tag
      }
  });

  function formatSentence(selectedDates, timeSlot, toTimeSlot) {
    var sentence = "";
    if (selectedDates.length > 0 && timeSlot && toTimeSlot) {
        // Sort the dates
        selectedDates.sort(function(a, b) {
            return new Date(a) - new Date(b);
        });

        var groupedDates = {}; // To store dates grouped by month

        selectedDates.forEach(function(dateStr) {
            var date = new Date(dateStr);
            var month = monthNames[date.getMonth()];
            if (!groupedDates[month]) {
                groupedDates[month] = [];
            }
            groupedDates[month].push(date);
        });

        var formattedDates = [];
        for (var month in groupedDates) {
            var dates = groupedDates[month];
            var dateRanges = [];
            var start = dates[0];
            var end = start;

            for (var i = 1; i < dates.length; i++) {
                if (dates[i] - end === 86400000) { // Check if the next date is consecutive (1 day in ms)
                    end = dates[i];
                } else {
                    dateRanges.push(formatDateRange(start, end));
                    start = dates[i];
                    end = start;
                }
            }
            dateRanges.push(formatDateRange(start, end)); // Add the last range
            formattedDates.push(month + " " + dateRanges.join(", "));
        }

        <?php if(isset($is_detail)): ?>
            sentence = "<span>Request for: <span class='text-info pull-right'>" + formattedDates.join(", ") + " from " + timeSlot + " to " + toTimeSlot + "</span></span>";
        <?php else: ?>
			console.log(formattedDates);
			if(formattedDates != "undefined NaNth to NaNth"){
				sentence = "<span>Not available on: <span class='text-info pull-right'>From " + formattedDates.join(", ") + " " + timeSlot + " to " + toTimeSlot + "</span></span>";
			}else{
				sentence = "<span>Not available: <span class='text-info pull-right'>From " + timeSlot + " to " + toTimeSlot + "</span></span>";
			}
            
        <?php endif; ?>
    }
    return sentence;
  }

  function formatDateRange(start, end) {
    if (start.getTime() === end.getTime()) {
        return formatDate(start);
    } else {
        return formatDate(start) + " to " + formatDate(end);
    }
  }

  function formatDate(date) {
    var day = date.getDate();
    var suffix = getOrdinalSuffix(day);
    return day + suffix;
  }

  function getOrdinalSuffix(date) {
    if (date > 3 && date < 21) return 'th';
    switch (date % 10) {
      case 1:  return "st";
      case 2:  return "nd";
      case 3:  return "rd";
      default: return "th";
    }
  }

  function updateAvailabilityMessage() {
    var selectedDates = $('#selectedDates').val().split(',');
    var timeSlot = $('#timeSlot').val();
    var timeSlotTo = $('#timeSlotTo').val();
    var sentence = formatSentence(selectedDates, timeSlot, timeSlotTo);
    //console.log('sentence====>'+sentence);
    if(sentence != ""){
      $('#notAvailablMsg').show().html(sentence); // Update the availability text  
    }    
  }

  function acceptCustomOffer(element){
    var dataUrl = $(element).data('url');
    swal({
      title: "Confirm?",
      text: "Are you sure you want to accept this offer?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Yes, Accept',
      cancelButtonText: 'Cancel'
    }, function() {
      window.location.href = dataUrl;
      acceptOffer();
    });
  }

  $('.icon-wishlist').on('click', function (){
    var sId = $(this).data('id');
    $.ajax({
      type:'POST',
      url:site_url+'users/updateWishlist',
      data:{sId:sId},
      dataType: 'json',
      success:function(response){
        if(response.status == 0){
          swal({
              title: "Login Required!",
              text: "If you want to add this service into your wishlist then please login first!",
              type: "warning"
          }, function() {
              window.location.href = '<?php echo base_url().'login'; ?>';
          });
        }else{
          if(response.status == 1){
            $('#serId_'+sId).addClass('liked-service');          
          }else{
            $('#serId_'+sId).removeClass('liked-service');          
          } 
        }      
      }
    });
  });
  
  let clip = document.querySelector(".serviceVideo") 
  // clip.addEventListener("mouseover", function (e) { 
  //     clip.play(); 
  // }) 

  // clip.addEventListener("mouseout", function (e) { 
  //     clip.pause(); 
  // })


  const bar = document.getElementById('bar'),
      video = document.getElementsByTagName('video')[0],
      btn = document.getElementById('play-control-btn'),
      totalLength = bar.getTotalLength();
  let   playing = true;

  const playVideo = () => {
    playing = true;
    btn.classList.add("playing");
    video.play();
  }

  const pauseVideo = () => {
    playing = false;
    btn.classList.remove("playing");
    video.pause();
  }

  bar.setAttribute('stroke-dasharray', totalLength);
  bar.setAttribute('stroke-dashoffset', totalLength);

  video.addEventListener("timeupdate", () => {
    const currentTime = video.currentTime,
          duration = video.duration,
          calc = totalLength - ( currentTime / duration * totalLength );

    bar.setAttribute('stroke-dashoffset', calc);
  });

  video.addEventListener("ended", () => {
    pauseVideo();
    video.currentTime = 0;
  });

  video.addEventListener("mouseover", () => playing ? pauseVideo() : playVideo());
</script>

<?php 
  if($this->session->flashdata('success')){
      unset($_SESSION['success']);
  }
  if($this->session->flashdata('error')){
      unset($_SESSION['error']);
  }
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
let isFirstClick = true; // Initialize the toggle flag

function toggleMilestones() {
  if (isFirstClick) {
    $('.regular_div').css('display', 'none');
    $('.milestone_div').css('display', 'block');
    $('#toggle-milestones').text('Switch to single payment offer');
    $('#mainTitle').text('Create a milestones offer');
    $('#orderType').val('milestone');
      /*$('#milestoneName').css('display', 'block');
      $('#milestoneDetails').css('display', 'block');
      $('.milestone_name').prop('required', true);
      $('.milestone_details').prop('required', true);*/
  } else {
    $('.regular_div').css('display', 'block');
    $('.milestone_div').css('display', 'none');
    $('#toggle-milestones').text('Switch to miletones');
    $('#mainTitle').text('Create a single payment offer');
    $('#orderType').val('single');
      /*$('#milestoneName').css('display', 'none');
      $('#milestoneDetails').css('display', 'none');
      $('.milestone_name').prop('required', false);
      $('.milestone_details').prop('required', false);*/
  }
  isFirstClick = !isFirstClick; // Toggle the flag
}

function toggleSelectBox(dId) {
  var checkBox = document.getElementById("is_offer_expires");
  var selectBox = document.getElementById("offer_expires_days"+dId);
  selectBox.disabled = !checkBox.checked;
}
  
function initializeValidation() {
  $("#custom_offer_submit").validate({
    rules: {
      description: "required",
      delivery: "required",
      price_per_type: "required",
      quantity: "required",
      price: {
        required: true,
        number: true
      },
      offer_expires_days: {
        required: function () {
          return $("#is_offer_expires").is(":checked");
        }
      }
    },
    messages: {
      description: "Please enter a description",
      delivery: "Please select delivery",
      price_per_type: "Please select the type of charge",
      quantity: "Please enter an quantity",
      price: {
        required: "Please enter a price",
        number: "Please enter a valid price"
      },
      offer_expires_days: "Please select the number of days for offer expiration"
    },
    submitHandler: function (form) {
      $.ajax({
        url: "<?php echo site_url('custom_offer/store') ?>",
        type: 'POST',
        data: new FormData(form),
        dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
          $('.sendbtn1').prop('disabled', true);
          $('.sendbtn1').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
        },
        success: function (resp) {
          $('.sendbtn1').prop('disabled', false);
          $('.sendbtn1').html(resp.button);

          if (resp.success) {
            $('#customOfferPopUp').modal('hide');
            $("#custom_offer_submit").trigger('reset');
            swal(resp.success);
            setTimeout(function(){
              window.location.href = "<?php echo site_url('my-orders') ?>";
            }, 2000);
          } else if (resp.error) {
            swal(resp.error);
            setTimeout(function(){
              location.reload();
            }, 2000);
          }
        }
      });
    }
  });
}

$('#customOfferPopUp').on('shown.bs.modal', function() {
    initializeValidation();
});

  $(document).ready(function () {
    initializeValidation();

    <?php if(!empty($milestones)): ?>
      $('#toggle-milestones').trigger('click');
    <?php endif; ?>

    function validateCustomOfferField(selector, validationType, errorMessage) {
      var field = $(selector);
      var value = field.val();
      var errorContainer = $(selector + "_error");
      errorContainer.text('');
      field.removeClass('is-invalid');

      if (validationType == 'required' && !value.trim()) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "This field is required.");
          return false;
      } 

      if (validationType == 'number' && isNaN(value)) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "Please enter a valid number.");
          return false;
      } else if (validationType == 'min' && parseFloat(value) <= 0) {
          field.addClass('is-invalid');
          errorContainer.text(errorMessage || "Value must be greater than 0.");
          return false;
      }

      return true;
    }

    function resetMilestoneForm() {
      $('#milestoneForm').find('input[type="text"], input[type="number"], input[type="radio"], input[type="checkbox"], select, textarea').each(function () {
          $(this).val(''); // Reset the value
          $(this).prop('checked', false); // For checkboxes and radio buttons
      });
      $('#milestoneForm').find('.error-message').text('');
      $('#milestoneForm').find('.is-invalid').removeClass('is-invalid');
    }

    $('#customOfferModalBody').on('click', '#milestoneSave', function (event) {
      $('#description_error').text('');
      var isValid = true;
      isValid &= validateCustomOfferField('#main_description', 'required', "Please enter a description");
      isValid &= validateCustomOfferField('#milestone_name', 'required', "Please enter a milestone name");
      isValid &= validateCustomOfferField('#milestone_delivery', 'required', "Please select a delivery option");
      isValid &= validateCustomOfferField('#milestone_price', 'required', "Please enter a price");
      if ($('#milestone_price').val() != '') {
        isValid &= validateCustomOfferField('#milestone_price', 'number', "Please enter a valid price");
      }
      
      isValid &= validateCustomOfferField('#milestone_details', 'required', "Please enter a description");

      if ($('#milestone_price_per_type').val() === '') {
        $('#milestone_price_per_type').addClass('is-invalid');
        $('#price_per_type_error').text("Please select a charge per option");
        isValid = false;
      } else {
        $('#milestone_price_per_type').removeClass('is-invalid');
        $('#price_per_type_error').text('');
      }

      var main_description = $('#main_description').val();
      var name = $('#milestone_name').val();
      var delivery = $('#milestone_delivery').val();
      var price = $('#milestone_price').val();
      var description = $('#milestone_details').val();
      var price_per_type = $('#milestone_price_per_type').val();
      var service_id = $('#service_id').val();
      var receiver_id = $('#receiver_id').val();
      var order_type = $('#orderType').val();

      if (isValid) {
        $.ajax({
          url: "<?php echo site_url('custom_offer/milestoneStore') ?>",
          type: 'POST',
          data: {main_description:main_description,name:name,delivery:delivery,price:price,description:description,price_per_type:price_per_type,service_id:service_id,receiver_id:receiver_id,order_type:order_type},
          // dataType: 'json',
          beforeSend: function () {
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spin fa-spinner"></i> Save...');
          },
          success: function (resp) {
            var data = JSON.parse(resp);
            resetMilestoneForm();
            $('#customOfferModalBody #milestoneList').empty();
            $('#customOfferModalBody #totalDays').text('Total: '+data.totalDays+' days');
            $('#customOfferModalBody #totalAmounts').text(data.totalAmount);
            $('#customOfferModalBody #milestoneList').html(data.viewData);
            $('#customOfferModalBody #customOrderId').val(data.oId);
            $('#customOfferModalBody #milestoneNumber').text(data.nextMilestone);
            $(this).prop('disabled', false);
            $(this).html('Save');
          }
        });
      }
    });
  });
</script>  