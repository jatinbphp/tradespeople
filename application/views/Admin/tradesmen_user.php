<?php 
   include_once('include/header.php');
   if(!in_array(1,$my_access)) { redirect('Admin_dashboard'); }
   ?>
<style>
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
</style>
<div class="content-wrapper">
   <section class="content-header">
      <h1>Tradesmen Users</h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Tradesmen Users</li>
      </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12 head">
            <div class="" style="padding-bottom:20px;">
               <!--a href="<?=site_url().'Admin/exportImport/export/1'; ?>" class="btn btn-primary"><i class="exp"></i> Export</a-->
               <button onclick="export_user();" class="btn btn-primary"><i class="exp"></i> Export</button>
               <button onclick="delete_user();" class="btn btn-danger" id="deleteBtn" style="display:none;"><i class="exp"></i> Delete</button>
            </div>
         </div>
         <div class="col-xs-12">
            <div class="box">
               <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>
               <div class="box-body">
                  <?php if($this->session->flashdata('error')) { ?>
                  <p class="alert alert-danger"><?=$this->session->flashdata('error'); ?></p>
                  <?php } ?>
                  <?php if($this->session->flashdata('success')) { ?>
                  <p class="alert alert-success"><?=$this->session->flashdata('success'); ?></p>
                  <?php } ?>
                  <?=$this->session->flashdata('my_msg'); ?>
                  <div class="table-responsive">
                     <table id="ExportDatable" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th style="display:none;">S No.</th>
                              <th><input type="checkbox" value="1" class="checkbox_header"></th>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Trading name</th>
                              <th>Email</th>
                              <!--  <th style="min-width: 250px">Address</th> -->
                              <th>Phone Number</th>
                              <th>Address</th>
                              <th>Email Verified</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              $x = 1;
                              foreach($users as $lists) {
                                $doc = 0;
                              if($lists['u_status_add'] == 1){
                                $doc++;
                              }
                              if($lists['u_id_card_status'] == 1){
                                $doc++;
                              }
                              if($lists['u_status_insure'] == 1){
                                $doc++;
                              }
                              $doc_text = ($doc > 0) ?  '<span style="background:red;color:#fff;" class="badge">'.$doc.'</span>' : '';
                              
                              $today = date('Y-m-d');
                              $check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                              $create_date = date('Y-m-d',strtotime($lists['cdate']));
                              
                              $new_label = '';
                              
                              if($create_date > $check_date or $lists['is_admin_read']==0){
                              $new_label = '<span style="background:red;color:#fff;" class="label">New</span>';
                              }
                              
                              ?>
                           <tr role="row" class="odd">
                              <td style="display:none;"><?=$x; ?></td>
                              <td><input type="checkbox" name="seleceted_users[]" value="<?=$lists['id']; ?>" class="checkbox_body"></td>
                              <td><?=$lists['unique_id']; ?></td>
                              <td>
                                 <?=$lists['f_name']." ".$lists['l_name']; ?> <?= $new_label; ?>
                                 <br>
                                 <?php echo '<b>Signup date:</b> '.date('d-m-Y h:i A',strtotime($lists['cdate'])); ?>
                              </td>
                              <td><?=$lists['trading_name']; ?></td>
                              <td><?=$lists['email']; ?></td>
                              <td><?=$lists['phone_no']; ?></td>
                              <td>
                                 <b>Address:</b> <?php echo $lists['e_address']; ?><br>
                                 <b>County:</b> <?php echo $lists['county']; ?><br>
                                 <b>City:</b> <?php echo $lists['city']; ?><br>
                                 <b>Postcode:</b> <?php echo $lists['postal_code']; ?><br>
                              </td>
                              <td><?php if($lists['u_email_verify']==1){ echo '<span class="label label-success">Yes</span><b style="opacity:0;">Yes</b>';} else{ echo '<span class="label label-danger">No</span><b style="opacity:0;">No</b>'; } ?></td>
                              <td><?php echo ($lists['status']==1) ? '<span class="label label-danger">Blocked</span>' : '<span class="label label-success">Active</span>'; ?></td>
                              <td>
                                 <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select <?=$doc_text; ?> <span class="caret"></span></button>
                                    <ul class="dropdown-menu" style="text-align: left;">
                                       <li style="display:none;"><a href="<?=site_url('Admin/Chats/?user_id=' .$lists['id']);?>" >Send message</a></li>
                                       <!-- Old modal -->
                                       <li>
                                          <a data-target="#contact_form<?=$lists['id']; ?>" href="" data-toggle="modal">Send message</a>
                                       </li>
                                       <?php if($lists['type']==1){ ?>
                                       <li><a  target="_blank"  href="<?=base_url('public_profile/'.$lists['id']); ?>">View Profile</a></li>
                                       <?php } ?>
                                       <?php if($lists['status']==0){ ?> 
                                       <li><a href="<?=base_url(); ?>Admin/Admin/Blockuser/<?=$lists['id'];?>/1" onclick="return confirm('Are you sure! you want to block this user?');">Block</a></li>
                                       <?php }else{ ?>   
                                       <li><a href="<?=base_url(); ?>Admin/Admin/Blockuser/<?=$lists['id'];?>/0" onclick="return confirm('Are you sure! you want to unblock this user?');">UnBlock</a></li>
                                       <?php }  ?>
                                       <?php if($lists['review_invitation_status']==0){ ?> 
                                       <li><a href="<?=base_url(); ?>Admin/Admin/review_invitation_status/<?=$lists['id'];?>/1" onclick="return confirm('Are you sure! you want to block this user?');">Un-block review invitation</a></li>
                                       <?php }else{ ?>   
                                       <li><a href="<?=base_url(); ?>Admin/Admin/review_invitation_status/<?=$lists['id'];?>/0" onclick="return confirm('Are you sure! you want to unblock this user?');">Block review invitation</a></li>
                                       <?php }  ?>
                                       <li><a  target="_blank"  href="<?=base_url('edit-profile/'.$lists['id']); ?>">Edit</a></li>
                                       <li><a data-target="#view_document<?=$lists['id']; ?>" href="" data-toggle="modal">View Documents <?=$doc_text; ?></a></li>
                                       <li><a data-target="#view_note<?=$lists['id']; ?>" href="" data-toggle="modal">View Note</a></li>
                                       <li class="hide"><a href="javascript:void(0);" onclick="send_email('<?=$lists['email']; ?>')">Send Email</a></li>
                                       <?php //if($lists['u_email_verify']==0){ ?>
                                       <li><a href="<?=base_url(); ?>Admin/Admin/delete_user/<?=$lists['id'];?>/tradesmen_user" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></li>
                                       <?php //} ?>
                                    </ul>
                                 </div>
                              </td>
                           </tr>
                           <div class="modal fade popup" id="view_document<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">DOCUMENTS</h4>
                                    </div>
                                    <div class="modal-body">
                                       <div><?=$this->session->flashdata('my_msg_doc'.$lists['id']); ?></div>
                                       <fieldset>
                                          <!-- Text input-->
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <p >Address Document</p>
                                                <?php if($lists['u_address']){ ?>
                                                <div class="row">
                                                   <div class="col-sm-8">
                                                      <div class="form-group">
                                                         <a href="<?=base_url('img/verify/'.$lists['u_address']); ?>" download><i class="fa fa-paperclip"></i> <?=$lists['u_address']; ?></a>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-4">
                                                      <?php if($lists['u_status_add']==1){  ?>
                                                      <a href="<?=base_url(); ?>Admin/Admin/update_address/<?=$lists['id'];?>/2" onclick="return confirm('Are you sure! you want to verify this document?');" class="btn btn-success btn-xs">Verify</a>  
                                                      <button type="button" data-toggle="modal" data-target="#id_add_modal<?=$lists['id']; ?>" class="btn btn-danger btn-xs">Reject</button>  
                                                      <?php }else{ ?><button class="btn btn-success btn-xs">Verified</button><?php } ?>
                                                   </div>
                                                </div>
                                                <?php } else{ ?>
                                                <p style="color: red"><b>No Document Found.</b></p>
                                                <?php } ?>
                                             </div>
                                             <div class="col-md-12">
                                                <p >Insurance Document</p>
                                                <?php if($lists['u_insurrance_certi']){ ?>
                                                <div class="row">
                                                   <div class="col-sm-8">
                                                      <div class="form-group">
                                                         <a href="<?=base_url('img/verify/'.$lists['u_insurrance_certi']); ?>" download><i class="fa fa-paperclip"></i> <?=$lists['u_insurrance_certi']; ?></a>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-4">
                                                      <?php if($lists['u_status_insure']==1){ ?>
                                                      <a href="<?=base_url(); ?>Admin/Admin/update_insurance/<?=$lists['id'];?>/2" onclick="return confirm('Are you sure! you want to verify this document?');" class="btn btn-success btn-xs">Verify</a>  
                                                      <button type="button" data-toggle="modal" data-target="#id_insure_modal<?=$lists['id']; ?>" class="btn btn-danger btn-xs">Reject</button>  
                                                      <?php }else{ ?><button class="btn btn-success btn-xs">Verified</button><?php } ?>
                                                   </div>
                                                </div>
                                                <?php } else{ ?>
                                                <p style="color: red"><b>No Document Found.</b></p>
                                                <?php } ?>
                                             </div>
                                             <div class="col-md-12">
                                                <p >ID Card Document</p>
                                                <?php if($lists['u_id_card']){ ?>
                                                <div class="row">
                                                   <div class="col-sm-8">
                                                      <div class="form-group">
                                                         <a href="<?=base_url('img/verify/'.$lists['u_id_card']); ?>" download><i class="fa fa-paperclip"></i> <?=$lists['u_id_card']; ?></a>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-4">
                                                      <?php if($lists['u_id_card_status']==1){ ?>
                                                      <a href="<?=base_url(); ?>Admin/Admin/update_idcard/<?=$lists['id'];?>/2" onclick="return confirm('Are you sure! you want to verify this document?');" class="btn btn-success btn-xs">Verify</a>  
                                                      <button type="button" data-toggle="modal" data-target="#id_card_reject_modal<?=$lists['id']; ?>" class="btn btn-danger btn-xs">Reject</button>  
                                                      <?php }else{ ?>
                                                      <button class="btn btn-success btn-xs">Verified</button>
                                                      <?php } ?>
                                                   </div>
                                                </div>
                                                <?php } else{ ?>
                                                <p style="color: red"><b>No Document Found.</b></p>
                                                <?php } ?>
                                             </div>
                                          </div>
                                       </fieldset>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade popup" id="id_add_modal<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">Address Document</h4>
                                    </div>
                                    <form method="post" action="<?=base_url(); ?>Admin/Admin/update_address/<?=$lists['id'];?>/0">
                                       <div class="modal-body">
                                          <fieldset>
                                             <!-- Text input-->
                                             <div class="form-group">
                                                <textarea name="reason" required class="form-control"></textarea>
                                             </div>
                                          </fieldset>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade popup" id="id_insure_modal<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">Insurance Document</h4>
                                    </div>
                                    <form method="post" action="<?=base_url(); ?>Admin/Admin/update_insurance/<?=$lists['id'];?>/0">
                                       <div class="modal-body">
                                          <fieldset>
                                             <!-- Text input-->
                                             <div class="form-group">
                                                <textarea name="reason" required class="form-control"></textarea>
                                             </div>
                                          </fieldset>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade popup" id="id_card_reject_modal<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">ID Card Document</h4>
                                    </div>
                                    <form method="post" action="<?=base_url(); ?>Admin/Admin/update_idcard/<?=$lists['id'];?>/0">
                                       <div class="modal-body">
                                          <fieldset>
                                             <!-- Text input-->
                                             <div class="form-group">
                                                <textarea name="reason" required class="form-control"></textarea>
                                             </div>
                                          </fieldset>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="submit" class="btn btn-success">Submit</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade popup" id="contact_form<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">Send message</h4>
                                    </div>
                                    <!--
                                       Old
                                       <form method="post" action="<?=base_url(); ?>Admin/Admin/send_direct_mail/<?=$lists['id'];?>">
                                       -->
                                    <form method="POST" name="sendMessageForm_<?=$lists['id'];?>" id="sendMessageForm_<?=$lists['id'];?>" onsubmit="send_message(event, 'sendMessageForm_<?=$lists['id'];?>');" >
                                       <div class="modal-body">
                                          <fieldset>
                                             <!-- Text input-->
                                             <!--
                                                <div class="form-group">
                                                  <label>Submit</label>
                                                  <input name="subject" required class="form-control">
                                                </div>
                                                -->
                                             <div class="form-group">
                                                <label>Message</label>
                                                <textarea name="message" required class="form-control"></textarea>
                                                <input type="hidden" name="admin_chat_id" value="0" required="" >
                                                <input type="hidden" name="email" value="<?=$lists['email'];?>" required="" >
                                                <input type="hidden" name="username" value="<?=$lists['f_name'] .' ' .$lists['l_name'];?>" required="" >
                                                <input type="hidden" name="receiver_id" value="<?=$lists['id'];?>" required="" >
                                             </div>
                                          </fieldset>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="submit" class="btn btn-success">Send</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                           <div class="modal fade popup" id="view_note<?=$lists['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                       <h4 class="modal-title" id="myModalLabel">Save note</h4>
                                    </div>
                                    <div class="modal-body">
                                       <div class="form-group">
                                          <label>Comment </label>
                                          <textarea id="admin_note<?=$lists['id'];?>" name="admin_note" rows="7" class="form-control"><?=$lists['admin_note'];?></textarea>
                                          <input type="hidden" name="id" value="<?=$lists['id'];?>" required="" >
                                       </div>
                                       <div class="form-group">
                                          <p id="last_note_update<?=$lists['id'];?>">
                                             <?php if($lists['admin_note']) {
                                                echo 'Last updated: '.date('d M Y h:i A',strtotime($lists['admin_update']));
                                                } ?>
                                          </p>
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="submit" onclick="return add_note(<?=$lists['id'];?>);" class="btn btn-success note-save-btn<?=$lists['id'];?>">Save</button>
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php $x++; } ?>
                        </tbody>
                    </table>                    
                  </div>    
                  <div class="pagination pull-right" style="margin-top: 0px!important;">
                    <?php echo $this->pagination->create_links(); ?>
                  </div>              
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<?php /*
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
   
   <script>
   $(document).ready(function() {
       $('#ExportDatable').DataTable( {
           dom: 'Bfrtip',
           buttons: [
               'csv', 'excel', 'pdf', 'print'
           ]
       } );
   } );
   
   </script>*/ ?>
<div class="modal fade popup" id="send_email-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Send Email</h4>
         </div>
         <form method="POST" id="sendEmailForm" onsubmit="return sendEmailForm();" >
            <div class="modal-body">
               <fieldset>
                  <!-- Text input-->
                  <div class="form-group">
                     <label>To</label>
                     <input name="email" id="email-2" value="" required class="form-control">
                  </div>
                  <div class="form-group">
                     <label>Submit</label>
                     <input name="subject" id="subject-2" required class="form-control">
                  </div>
                  <div class="form-group">
                     <label>Message</label>
                     <textarea name="message" id="message-2" rows="6" required class="form-control"></textarea>
                  </div>
               </fieldset>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success send_btn-2">Send</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   $(document).ready(function(){
    var total_users = <?=$x-1; ?>;
    $('#ExportDatable').DataTable( {
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "paging": false,
      //"ordering": false,
      "stateSave": true
    });
    
    $('#ExportDatable').on('draw.dt', function() {
      if($('.checkbox_header').is(':checked')){
        //$('.checkbox_body').prop('checked',true);
        $('.checkbox_header').prop('checked',true);
        $('#deleteBtn').show();
      }
    });
    
    $('.checkbox_header').on('change',function(){
      if($(this).is(':checked')){
        $('.checkbox_body').prop('checked',true);
        $('#deleteBtn').show();
      } else {
        $('.checkbox_body').prop('checked',false);
        $('#deleteBtn').hide();
      }
    });
    
    $('.checkbox_body').on('change',function(){
    
      if($(this).is(':checked')){
        $('#deleteBtn').show();
        var length = $('[name="seleceted_users[]"]:checked').length
        
        if(total_users==length){
          $('.checkbox_header').prop('checked',true);
        } else {
          $('.checkbox_header').prop('checked',false);
        }
      } else {
        $('.checkbox_header').prop('checked',false);
        var length = $('[name="seleceted_users[]"]:checked').length
      }

      if(length == 0){
         $('#deleteBtn').hide();
      }
    });
   });
   
   function send_email(email){
    $('#email-2').val(email);
    $('#subject-2').val('');
    $('#message-2').val('');
    
    $('#send_email-2').modal('show');
    return false;
   }
   
   function sendEmailForm(){
    $.ajax({
      type:'POST',
      url: site_url + 'Admin/user_Posts/sendEmailToUser',
      data: $('#sendEmailForm').serialize(),
      beforeSend:function(){
        $('.send_btn-2').prop('disabled',true);
        $('.send_btn-2').html('<i class="fa fa-spin fa-spin"></i> Sending...');
      },
      success:function(response){
        
        $('.send_btn-2').prop('disabled',false);
        $('.send_btn-2').html('Send');
        
        if(response == 1){
          toastr.success('Email has been sent successfully.');
          $('#send_email-2').modal('hide');
        } else {
          toastr.error('Something went wrong, try again later');
        }
      }
    });
    return false;
   }  
   
   function export_user(){
    var seleceted_users = $.map($('input[name="seleceted_users[]"]:checked'), function(c){return c.value; });
    
    if(seleceted_users && seleceted_users.length > 0){
      
      var x = seleceted_users.toString();
      window.location.href=site_url+"Admin/exportImport/export/1?seleceted_users="+x
    } else {
      alert('Select users');
    }
   }

   function delete_user(){
      var seleceted_users = $.map($('input[name="seleceted_users[]"]:checked'), function(c){return c.value; });
      if(seleceted_users && seleceted_users.length > 0){
         var uIds = seleceted_users.toString();
         //window.location.href=site_url+"Admin/Admin/deleteUsers?seleceted_users="+x
         if (confirm('Are you sure you want to delete selected tradesman?')) {
            $.ajax({
               type:'POST',
               url: site_url + 'Admin/Admin/deleteUsers',
               data:  {
                  seleceted_users : uIds,
               },
               success:function(response){
				 // console.log(response); 
                  toastr.success(response.msg);
                 window.location.reload();
               }
            });
            return false;
         }
      } else {
         alert('Select users');
      }
   }

   $(document).ready(function(){
    mark_read_in_admin('users',"type=1");
   });
     
   function send_message(e, form_id){
       e.preventDefault();
       $.ajax({
         type:'POST',
         url: site_url + 'Admin/Chats/send_message',
         data: new FormData($('#' + form_id)[0]),
         processData: false,
         contentType: false,
         cache: false,
         dataType:'json',
         success:function(response){
           if(response.status == 1) window.location.href = "/Admin/Chats?admin_chat_id=" + response.admin_chat_id;
         }
       });
   }  
   function add_note(id){
    $.ajax({
      type:'POST',
      url: site_url + 'Admin/admin/update_admin_note',
      data:  {
        admin_note : $('#admin_note'+id).val(),
        id : id,
      },
      dataType:'json',
      beforeSend:function(){
        $('.note-save-btn'+id).prop('disabled',true);
      },
      success:function(response){
        $('.note-save-btn'+id).prop('disabled',false);
        if(response.status == 1) {
          toastr.success(response.msg);
          $('#last_note_update'+id).html(response.date);
        } else {
          toastr.error(response.msg);
        }
      }
    });
    return false;
   }
</script>
<?php include_once('include/footer.php'); ?>
<?php if(isset($_GET['open_doc']) && !empty($_GET['open_doc'])){ ?>
<script>
   $(document).ready(function(){
    $('#view_document<?php echo $_GET['open_doc']; ?>').modal('show');
   });
</script>
<?php } ?>