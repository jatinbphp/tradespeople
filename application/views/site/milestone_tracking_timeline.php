<?php 

    $total_deliveries1 = 0;
      foreach($list['order_submit_conversation'] as $clist1) {
          if($clist1['status'] == 'delivered') {
              $total_deliveries1++;
          }
      }
  ?>
  <?php foreach($list['order_submit_conversation'] as $ckey => $mList):?>
    <li class="timeline-item mt-2">
      <span class="timeline-item-icon | faded-icon">
        <?php if($mList['sender'] == 0 && $mList['receiver'] == 0 && $mList['is_cancel'] == 1):?>
          <i class="fa fa-times-circle faicon"></i>
        <?php elseif($mList['sender'] == 0 && $mList['receiver'] == 0 && $mList['status'] == 'completed'):?>
          <i class="fa fa-check-square-o faicon"></i>
        <?php elseif($mList['sender'] == 0 && $mList['receiver'] == 0 && $order['is_cancel'] == 8):?>
          <i class="fa fa-check-square-o faicon"></i> 
        <?php else:?>
          <?php if($mList['sender'] == $tradesman['id']): ?>
            <?php if($mList['status'] == 'cancelled' && $order['is_cancel'] == 1):?>
              <i class="fa fa-times-circle faicon"></i>
            <?php elseif($mList['status'] == 'declined'):?>
              <i class="fa fa-times-circle faicon"></i> 
            <?php else:?> 
              <i class="fa fa-truck faicon"></i>
            <?php endif; ?>
          <?php endif;?>

          <?php if($mList['sender'] == $homeowner['id']): ?>
            <?php if($mList['status'] == 'completed'):?>
              <i class="fa fa-check-square-o faicon"></i>
            <?php elseif($mList['status'] == 'cancelled' && $order['is_cancel'] == 1):?>
              <i class="fa fa-times-circle faicon"></i>
            <?php elseif($mList['status'] == 'declined'):?>
              <i class="fa fa-times-circle faicon"></i>
            <?php else:?>
              <i class="fa fa-edit faicon"></i>
            <?php endif;?>
          <?php endif;?>  
        <?php endif;?>
      </span>
      <div class="timeline-item-description">
        <?php 
        $conDate = new DateTime($mList['created_at']);
        $conversation_date = $conDate->format('D jS F, Y H:i');
        ?>

        <?php if($mList['sender'] == 0 && $mList['receiver'] == 0 && $mList['is_cancel'] == 1):?>
          <h5>
            Your order has been cancelled itself
            <span class="text-muted" style="font-size: 12px;">
              <i><?php echo $conversation_date ?></i>
            </span>
          </h5>
        <?php elseif($mList['sender'] == 0 && $mList['receiver'] == 0 && $mList['status'] == 'completed'):?>
          <h5>
            Your order has been completed itself
            <span class="text-muted" style="font-size: 12px;">
              <i><?php echo $conversation_date ?></i>
            </span>
          </h5> 
        <?php elseif($mList['sender'] == 0 && $mList['receiver'] == 0 && $order['is_cancel'] == 8):?>
          <h5>
            Your order has been completed itself due to dispute cancel itself
            <span class="text-muted" style="font-size: 12px;">
              <i><?php echo $conversation_date ?></i>
            </span>
          </h5>   
        <?php else: ?>
          <?php if($mList['sender'] == $tradesman['id']): ?>           
            <?php if($this->session->userdata('type')==1):?>
              <?php if($mList['status'] == 'delivered'):?>
                  <h4 class="mt-1 mb-0"><b>Delivery <?php echo '#'.$total_deliveries1--; ?></b></h4>
                  <h5>
                    You delivered your order 
                    <span class="text-muted" style="font-size: 12px;">
                      <i><?php echo $conversation_date ?></i>
                    </span>
                  </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'disputed'):?>
                <h5>
                  You order disputed
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>          

              <?php if($mList['status'] == 'disputed_cancelled'):?>
                <h5>
                  You order disputed cancelled
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'disputed_accepted'):?>
                <h5>
                  You order disputed accepted
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                <h5>
              <?php endif;?>

              <?php if($mList['status'] == 'cancelled' && $mList['is_cancel'] == 2):?>
                <h5>
                  You ask to cancel this order
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'withdraw_cancelled' && $mList['is_cancel'] == 4):?>
                <h5>
                  You havebeen withdraw order cancellation request
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>                                     
              <?php endif;?>

              <?php if($mList['status'] == 'declined' && $mList['is_cancel'] == 3):?>
                <h5>
                  You declined order request
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'cancelled' && $mList['is_cancel'] == 1):?>
                <h5>
                  <?php if($order['is_custom'] == 1):?>
                    Your custom offer is cancelled
                  <?php else:?>
                    You accepted order cancellation request
                  <?php endif; ?> 
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>
            <?php else:?>
              <?php if($mList['status'] == 'delivered'):?>
                  <h4 class="mt-1 mb-0"><b>Delivery <?php echo '#'.$total_deliveries1--; ?></b></h4>
                  <h5>
                    <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a>
                    delivered your order 
                    <span class="text-muted" style="font-size: 12px;">
                      <i><?php echo $conversation_date ?></i>
                    </span>
                  </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'disputed'):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> order disputed
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'disputed_accepted'):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> order disputed accepted
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'disputed_cancelled'):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> order disputed rejected
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>

              <?php if($mList['status'] == 'cancelled' && $mList['is_cancel'] == 2):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> ask to cancel this order
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>  

              <?php if($mList['status'] == 'withdraw_cancelled' && $mList['is_cancel'] == 4):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                    <?php echo $tradesman['trading_name']; ?>
                    </a> has been withdraw order cancellation request
                    <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5> 
              <?php endif;?>

              <?php if($mList['status'] == 'declined' && $mList['is_cancel'] == 3):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> declined order cancellation request
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>            

              <?php if($mList['status'] == 'cancelled' && $mList['is_cancel'] == 1):?>
                <h5>
                  <a href="<?php echo base_url('profile/'.$tradesman['id']); ?>" style="color: #3d78cb;">
                      <?php echo $tradesman['trading_name']; ?>
                    </a> is accepted order cancellation request
                  <span class="text-muted" style="font-size: 12px;">
                    <i><?php echo $conversation_date ?></i>
                  </span>
                </h5>
              <?php endif;?>
            <?php endif; ?>
          <?php endif; ?>
          <?php if($mList['sender'] == $homeowner['id']): ?>
            <?php if($this->session->userdata('type')==1):?>
              <h5>
                <?php if($mList['status'] == 'completed'):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> approved order
                <?php elseif($mList['status'] == 'disputed'):?>
                    <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed
                <?php elseif($mList['status'] == 'disputed_cancelled'):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed cancelled
                <?php elseif($mList['status'] == 'disputed_accepted'):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order disputed accepted
                <?php elseif($mList['status'] == 'cancelled' && $mList['is_cancel'] == 2):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> ask to cancel this order
                <?php elseif($mList['status'] == 'cancelled' && $mList['is_cancel'] == 1):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> order is cancelled
                <?php elseif($mList['status'] == 'withdraw_cancelled' && $mList['is_cancel'] == 4):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> has been withdraw order cancellation request
                <?php elseif($mList['status'] == 'declined' && $mList['is_cancel'] == 3):?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> declined order cancellation request
                <?php else:?>
                  <?php echo $homeowner['f_name'].' '.$homeowner['l_name']; ?> requested a modification
                <?php endif;?>    
                <span class="text-muted" style="font-size: 12px;">
                  <i><?php echo $conversation_date ?></i>
                </span>
              </h5>
            <?php else:?>
              <h5>
                <?php if($mList['status'] == 'completed'):?>
                  You approved order
                <?php elseif($mList['status'] == 'disputed'):?>
                  You dispute order
                <?php elseif($mList['status'] == 'disputed_cancelled'):?>
                  You order disputed cancelled
                <?php elseif($mList['status'] == 'disputed_accepted'):?>
                  You order disputed accepted
                <?php elseif($mList['status'] == 'cancelled' && $mList['is_cancel'] == 2):?>
                  You ask to cancel this order
                <?php elseif($mList['status'] == 'cancelled' && $mList['is_cancel'] == 1):?>
                  You order is cancelled
                <?php elseif($mList['status'] == 'withdraw_cancelled' && $mList['is_cancel'] == 4):?>
                  You have been withdraw order cancellation request
                <?php elseif($mList['status'] == 'declined' && $mList['is_cancel'] == 3):?>
                  You declined order cancellation request
                <?php else:?>
                  You requested a modification 
                <?php endif;?>    
                <span class="text-muted" style="font-size: 12px;">
                  <i><?php echo $conversation_date ?></i>
                </span>
              </h5>
            <?php endif;?>
          <?php endif; ?> 
        <?php endif; ?>       

        <?php
          if(in_array($mList['status'],['completed','cancelled']) && empty($mList['description'])){
          $style = 'display:none;';
          }else{
            $style = 'display:block;';
          }
        ?>

        <span class="delivery-conversation text-left" style="<?php echo $style; ?>">
          <p><?php echo $mList['description']; ?></p>

          <?php 
          $conAttachments = $this->common_model->get_all_data('order_submit_attachments',['conversation_id'=>$mList['id']])
          ?>

          <?php if(!empty($conAttachments)):?>
            <h5 style="width: 100%; font-size: 15px;">Attachments</h5>
            <div class="row other-post-view" id="con_attachments">
              <?php foreach ($conAttachments as $con_key => $con_value): ?>
                <?php $image_path = FCPATH . 'img/services/' . ($con_value['attachment'] ?? ''); ?>
                <?php if (file_exists($image_path) && $con_value['attachment']): ?>
                  <?php
                  $mime_type = get_mime_by_extension($image_path);
                  $is_image = strpos($mime_type, 'image') !== false;
                  $is_video = strpos($mime_type, 'video') !== false;
                  ?>
                  <div class="col-md-4 pr-3 pl-3">
                    <?php if ($is_image): ?>
                      <a href="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
                      <img src="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" alt="">
                      </a>
                    <?php elseif ($is_video): ?>  
                      <a href="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" data-fslightbox="<?php echo $order['order_id']?>" data-title="<?php echo $order['order_id']?>">
                        <video controls src="<?php echo base_url('img/services/') . $con_value['attachment']; ?>" type="<?php echo $mime_type; ?>" loop class="serviceVideo">
                        </video>
                      </a>
                    <?php endif; ?>
                  </div>
                <?php endif; ?> 
              <?php endforeach; ?>
            </div>                                  
          <?php endif; ?>
        </span>
        <?php //if($mList['status'] == 'cancelled' && !in_array($order['is_cancel'], [1,3,4]) && $order['status'] != 'declined'):?>
        <?php if($ckey == 0 && !in_array($order['is_cancel'], [0,1,3,4,6,7,8])):?>
          <p class="alert alert-danger mb-0">
            <?php 
              if($mList['sender'] == $tradesman['id']){
                $ocruName = $this->session->userdata('type')==1 ? $homeowner['f_name'].' '.$homeowner['l_name'].' has' : 'You have';
                $oppoName = $this->session->userdata('type')==1 ? 'your' : $tradesman['trading_name'];
              }

              if($mList['sender'] == $homeowner['id']){
                $ocruName = $this->session->userdata('type')==1 ? 'You have' : $tradesman['trading_name'].' has';
                $oppoName = $this->session->userdata('type')==1 ? $homeowner['f_name'].' '.$homeowner['l_name'] : 'your';
              }
            ?>
            <?php if($order['is_cancel'] == 5):?>
              <?php if($mList['sender'] == $homeowner['id']): ?>
                <i class="fa fa-info-circle"></i> 
                <?php echo $ocruName; ?> until <?php echo $newTime; ?> to respond. Not responding within the time frame will result in closing the case and deciding in <?php echo $oppoName; ?> favour.
              <?php else: ?>
                <i class="fa fa-info-circle"></i> 
                Not responding before <?php echo $newTime; ?> will result in closing this case and deciding in the <?php echo $oppoName; ?> favour. Any decision reached is final and irrevocable. Once a case has been closed, it can't be reopened.
              <?php endif; ?> 
            <?php else:?>
              <i class="fa fa-info-circle"></i> 
              <?php echo $ocruName; ?> have until <?php echo $newTime; ?> to respond to this request or the order will be cancelled. Cancelled orders will be credited to your Tradespeople Wallet. Need another tradesman? We can help?
            <?php endif;?>  
          </p>
            <div class="text-right width-100">
              <?php if($user['id'] != $mList['sender'] && $mList['is_cancel'] == 2 && $order['is_cancel'] == 2):?>
                <a class="btn btn-default" href="#" data-target="#decline_request_modal" onclick="return decliensss()" data-toggle="modal">Decline</a>
                <button class="btn btn-warning" onclick="accept_decision(<?php echo $order['id']; ?>)">
                  Accept Request
                </button>
              <?php else: ?>
                <?php if($mList['is_cancel'] == 2 && $order['is_cancel'] == 2):?>
                  <button class="btn btn-warning" onclick="withdraw_request(<?php echo $order['id']; ?>)">
                    Withdraw Request
                  </button>
                  <?php endif;?>
              <?php endif;?>
            </div>                                
        <?php endif;?>

        <?php 
          $is_milestone = 0;
          if($mList['milestone_id'] && $mList['milestone_id'] > 0 && $mList['status'] == 'delivered'){
            $is_milestone = 1;
          }
        ?>

        <?php
        if($this->session->userdata('type')==2 && $mList['status'] == 'delivered' && $ckey == 0):?>
          <form id="approved_order_form_<?php echo $mList['id']; ?>" style="width:100%">
            <input type="hidden" name="order_id" value="<?php echo $order['id']?>">
            <input type="hidden" name="milestone_id" value="<?php echo $mList['milestone_id']?>">
            <input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
            <input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
            <input type="hidden" name="status" value="completed">
            <!-- <textarea rows="7" class="form-control" id="approve-decription" name="approve_decription"></textarea> -->
          </form>

          <?php if($order['is_custom'] == 1 && $order['order_type'] == "milestone"): ?>

            <?php if($list['service_status'] == 'delivered'): ?>
            <p class="alert alert-info mb-0">
              <i class="fa fa-info-circle"></i> 
              Keep in mind that you have untill <?php echo $newTime; ?> to approve this delivery or request a revision. After this date, the order will be finalized and marked as complete.
            </p>

            <div id="approved-btn-div">
              <button type="button" id="approved-order-btn" data-id="<?php echo $mList['id']; ?>" class="btn btn-warning mr-3 approved-order-btn">
                Approve
              </button>
              <button type="button" id="modification-btn" class="btn btn-default">
                Request Modification
              </button>
            </div>
            <?php endif; ?>

          <?php else: ?>

            <?php if($order['status'] != 'disputed'){ ?>
            <p class="alert alert-info mb-0">
              <i class="fa fa-info-circle"></i> 
              Keep in mind that you have untill <?php echo $newTime; ?> to approve this delivery or request a revision. After this date, the order will be finalized and marked as complete.
            </p>

            <div id="approved-btn-div">
              <button type="button" id="approved-order-btn" data-id="<?php echo $mList['id']; ?>" class="btn btn-warning mr-3 approved-order-btn">
                Approve
              </button>
              <button type="button" id="modification-btn" class="btn btn-default">
                Request Modification
              </button>
            </div>
            <?php } ?>

          <?php endif; ?>
          

          <div id="modification-div" style="display:none; width: 100%;">
            <form id="request_modification_form_<?php echo $mList['id']; ?>">
              <input type="hidden" name="order_id" value="<?php echo $order['id']?>">
              <input type="hidden" name="milestone_id" value="<?php echo $mList['milestone_id']?>">
              <input type="hidden" name="tradesman_id" value="<?php echo $tradesman['id']; ?>">
              <input type="hidden" name="homeowner_id" value="<?php echo $user['id']?>">
              <input type="hidden" name="status" value="request_modification">
              <textarea rows="7" class="form-control" id="modification-decription" name="modification_decription"></textarea>
              <div class="row">
                <div id="loader2" class="loader_ajax_small"></div>
                <div class="col-md-6 col-xs-12 imgAdd" id="imageContainer1">
                  <div class="file-upload-btn addWorkImage1 imgUp">
                    <div class="btn-text main-label">Attachments</div>
                    <img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
                    <div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
                    <input type="file" name="modification_attachments" id="modification_attachments"> 
                  </div>
                </div>
              </div>
              <input type="hidden" name="multiModificationImgIds" id="multiModificationImgIds"> 
              <div class="row" id="previousModificationImg">
              </div>
              <div class="text-center">
                <button type="button" onclick="submitModification('request_modification_form_<?php echo $mList['id']; ?>')" class="btn btn-warning mr-3">
                  Submit request
                </button>
              </div>
            </form>
          </div>
        <?php endif;?>
      </div>
    </li>
  <?php endforeach;?>