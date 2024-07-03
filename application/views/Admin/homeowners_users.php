<?php 
   include_once('include/header.php');
   if(!in_array(2,$my_access)) { redirect('Admin_dashboard'); }
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
      <h1>Homeowner Users</h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Homeowner Users</li>
      </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12 head">
            <div class="" style="padding-bottom:20px;">
               <!--a href="<?php echo site_url().'Admin/exportImport/export/1'; ?>" class="btn btn-primary"><i class="exp"></i> Export</a-->
               <button onclick="export_user();" class="btn btn-primary"><i class="exp"></i> Export</button>
               <button onclick="delete_user();" class="btn btn-danger" id="deleteBtn" style="display:none;"><i class="exp"></i> Delete</button>
            </div>
         </div>
         <div class="col-xs-12">
            <div class="box">
               <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>
               <div class="box-body">
                  <?php if($this->session->flashdata('error')) { ?>
                  <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
                  <?php	} ?>
                  <?php if($this->session->flashdata('success')) { ?>
                  <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
                  <?php } ?>
                  <?php echo $this->session->flashdata('my_msg'); ?>
                  <div class="table-responsive">
                     <table id="ExportDatable" class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th style="display:none;">S No.</th>
                              <th><input type="checkbox" value="1" class="checkbox_header"></th>
                              <th>ID</th>
                              <th>Name</th>
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
                              $x=1;
                              
                              foreach($users as $lists) {
                              	$today = date('Y-m-d');
                              	$check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                              	$create_date = date('Y-m-d',strtotime($lists['cdate']));
                              	
                              	$new_label = '';
                              	
                              	if($create_date > $check_date or $lists['is_admin_read']==0){
                              		$new_label = '<span style="background:red;color:#fff;" class="label">New</span>';
                              	}
                              ?>
                           <tr role="row" class="odd">
                              <td style="display:none;"><?php echo $x; ?></td>
                              <td><input type="checkbox" name="seleceted_users[]" value="<?php echo $lists['id']; ?>" class="checkbox_body"></td>
                              <td><?php echo $lists['unique_id']; ?></td>
                              <td>
                                 <?php echo $lists['f_name']." ".$lists['l_name']; ?> <?= $new_label; ?>
                                 <br>
                                 <?php echo '<b>Signup date:</b> '.date('d-m-Y h:i A',strtotime($lists['cdate'])); ?>
                              </td>
                              <td><?php echo $lists['email']; ?></td>
                              <td><?php echo $lists['phone_no']; ?></td>
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
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select <span class="caret"></span></button>
                                    <ul class="dropdown-menu" style="text-align: left;">
                                       <li>
                                          <a data-target="#contact_form<?=$lists['id']; ?>" href="" data-toggle="modal">Send message</a>
                                       </li>
                                       <?php if($lists['status']==0){ ?> 
                                       <li><a href="<?php echo base_url(); ?>Admin/Admin/Blockuser/<?php echo $lists['id'];?>/1" onclick="return confirm('Are you sure! you want to block this user?');" >Block</a></li>
                                       <?php }else{ ?>   
                                       <li><a href="<?php echo base_url(); ?>Admin/Admin/Blockuser/<?php echo $lists['id'];?>/0" onclick="return confirm('Are you sure! you want to unblock this user?');" >UnBlock</a></li>
                                       <?php }  ?>
                                       <li><a  target="_blank" href="<?php echo base_url('edit-profile/'.$lists['id']); ?>">Edit</a></li>
                                       <li><a data-target="#view_note<?=$lists['id']; ?>" href="" data-toggle="modal">View Note</a></li>
                                       <li><a href="<?=base_url(); ?>Admin/Admin/delete_user/<?=$lists['id'];?>/homeowners_users" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></li>
                                    </ul>
                                 </div>
                              </td>
                           </tr>
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
                                          <label>Comment</label>
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
   
   </script> */ ?>
<script>
   $(document).ready(function(){
   	var total_users = <?php echo $x-1; ?>;
   	$('#ExportDatable').DataTable( {
   		"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],	
   		//"ordering": false,
   		"paging": false,
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
   
   function export_user(){
   	var seleceted_users = $.map($('input[name="seleceted_users[]"]:checked'), function(c){return c.value; });
   	
   	if(seleceted_users && seleceted_users.length > 0){
   		
   		var x = seleceted_users.toString();
   		window.location.href=site_url+"Admin/exportImport/export/2?seleceted_users="+x
   	} else {
   		alert('Select users');
   	}
   }

   function delete_user(){
      var seleceted_users = $.map($('input[name="seleceted_users[]"]:checked'), function(c){return c.value; });
      if(seleceted_users && seleceted_users.length > 0){
         var uIds = seleceted_users.toString();
         if (confirm('Are you sure you want to delete selected homwowner?')) {
            $.ajax({
               type:'POST',
               url: site_url + 'Admin/Admin/deleteUsers',
               data:  {
                  seleceted_users : uIds,
               },
               success:function(response){
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
   	mark_read_in_admin('users',"type=2");
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