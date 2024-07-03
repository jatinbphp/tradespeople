<?php 
include_once('include/header.php');
if(!in_array(5,$my_access)) { redirect('Admin_dashboard'); }
?>
<style type="text/css">
.modal {background-color:transparent;}
.fade.in
{
  background-color:transparent;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Contact Requests</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Contact Requests</li>
      </ol>
	  
  </section>

  <section class="content"> 
		<div class="msg" id="msg"><?php echo $this->session->flashdata('msg'); ?></div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
					
      <!--    <div class="box-header">
            <a href="javascript:void(0);"  data-toggle="modal" data-target="#addCountryModal" class="btn btn-success pull-right">Add Country</a> 
          </div> -->

          <div class="box-body">
						  <?php if($this->session->flashdata('error')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success')) { ?>
            <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
            <?php } ?>
            <div class="table-responsive">
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.No</th> 
                  <th>Name</th>
									<th>Email ID</th>
									<th>Phone No.</th>
									<th>Message</th>
									<th>Date</th>
                  <th>Status</th>
									<th>Action</th>
                </tr>
              </thead>
              <tbody>
								<?php 

                if($this->uri->segment(1)=='tradesmen_contacts')
                {
								$i = 1;
								foreach($listing as $row) {
								//$cate = $this->common_model->getRows('category',$row['p_cate']);
								?>
									<tr class="<?= ($row['status']==0)?'active1':''; ?>">
										<td><?= $i++; ?></td>
										<td><?= $row['first_name'].' '.$row['last_name']; ?></td>
										<td><?= $row['email']; ?></td>
										<td><?= $row['phone_no']; ?></td>
										<td><?php $len=strlen($row['message']); if($len>100){
                     echo substr($row['message'],0,100); ?>  <a href="javascript:void(0);" class="btn btn-warning btn-xs"  data-toggle="modal" data-target="#add_category<?php echo $row['id']; ?>">Read More</a><?php
                    } else{ echo $row['message']; } ?>
                   </td>
										<td><?= date('d-m-Y H:i: a', strtotime($row['cdate'])); ?></td>
                     <td><span class="label label-success"><?php if($row['status']==0){echo "New";}else if($row['status']==1){ echo "Read"; }else{ echo "Unread";} ?></span></td>
                    
										<td>
										<?php if($row['status']==0){ ?> 
                    
                    <a href="<?php echo base_url(); ?>Admin/Admin/mark_read/<?php echo $row['id'];?>/1/tradesmen_contacts" class="btn btn-success btn-xs">Mark as Read</a>  
                    <?php }?>
                    <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="modal" data-target="#send_reply<?php echo $row['id']; ?>">Reply</a>  
											<a onclick="return confirm('are you sure to delete this request');" href="<?= site_url().'/Admin/Admin/delete_request/'.$row['id']; ?>/tradesmen_contacts" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 

										</td>
                  
									</tr>

     	
								<?php }

                            foreach($listing as $row) { ?>
                              <div class="modal fade in" id="send_reply<?php echo $row['id']; ?>">
                               <div class="modal-body" >
                                  <div class="modal-dialog">
                               
                                     <div class="modal-content">
                                     
                                    <form onsubmit="return send_mail();" action="<?php echo base_url('Admin/Admin/send_mail/'.$row['id'].'/tradesmen_contacts'); ?>" method="post"  enctype="multipart/form-data">
                                      <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                         <h4 class="modal-title">Reply Request</h4>
                                      </div>
                                      <div class="modal-body">

                                  <div class="form-group hide">
                                    <label for="email"> Subject:</label>
                                    <input type="text" name="subject" id="subject"  value="You´ve got a reply from TradespeopleHub" required class="form-control" >
                                   </div>
                                       <div class="form-group">
                                    <label for="email"> Message:</label>
                                    <input type="hidden" name="first_name" value="<?php echo $row['first_name']; ?>">
                                    <input type="hidden" name="last_name" value="<?php echo $row['last_name']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                    <textarea rows="5" placeholder="" name="message" id="message" class="form-control"></textarea>
                                   </div>
                                         </div>
                                           <div class="modal-footer">
                                    <button type="submit" class="btn btn-info edit_btn signup_btn1<?= $row['id']; ?>" >Send</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           </div>
                                     </form>
                             
                                        </div>
                                  
                                     </div>
                                  </div>
                               </div>
                            <?php 
                                                  }

        

                      foreach($listing as $row) { ?>
                        <div class="modal fade in" id="add_category<?php echo $row['id']; ?>">
                         <div class="modal-body" >
                            <div class="modal-dialog">
                         
                               <div class="modal-content">
                                
                           
                                  <div class="modal-header">
                                    <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                     <h4 class="modal-title">Message</h4>
                                  </div>
                                  <div class="modal-body form_width100">
                          
                       <p> <?php echo $row['message']; ?></p>
                                   </div>
                                     <div class="modal-footer">
                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                     </div>
                       
                                  </div>
                            
                               </div>
                            </div>
                         </div>
                      <?php 
                      }

                ?>

              <script>
              $(document).ready(function(){
              	mark_read_in_admin('contact_request',"type=1");
              });
              </script>

                <?php


                }elseif($this->uri->segment(1)=='marketers-contacts'){
                  $i = 1;
                  foreach($listing2 as $row) { ?>
                    <tr class="<?= ($row['status']==0)?'active1':''; ?>">
                    <td><?= $i++; ?></td>
                    <td><?= $row['first_name'].' '.$row['last_name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['phone_no']; ?></td>
                    <td><?php $len=strlen($row['message']); if($len>100){
                     echo substr($row['message'],0,100); ?>  <a href="javascript:void(0);" class="btn btn-warning btn-xs"  data-toggle="modal" data-target="#add_category<?php echo $row['id']; ?>">Read More</a><?php
                    } else{ echo $row['message']; } ?>
                   </td>
                    <td><?= date('d-m-Y H:i: a', strtotime($row['cdate'])); ?></td>
                     <td><span class="label label-success"><?php if($row['status']==0){echo "New";}else if($row['status']==1){ echo "Read"; }else{ echo "Unread";} ?></span></td>
                    
                    <td>
                    <?php if($row['status']==0){ ?> 
                    
                    <a href="<?php echo base_url(); ?>Admin/Admin/mark_read/<?php echo $row['id'];?>/1/marketers-contacts" class="btn btn-success btn-xs">Mark as Read</a>  
                    <?php }?>
                    <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="modal" data-target="#send_reply<?php echo $row['id']; ?>">Reply</a>  
                      <a onclick="return confirm('are you sure to delete this request');" href="<?= site_url().'/Admin/Admin/delete_request/'.$row['id']; ?>/marketers-contacts" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 

                    </td>
                  
                  </tr>
                  <?php } foreach($listing2 as $row) { ?>
                      <div class="modal fade in" id="send_reply<?php echo $row['id']; ?>">
                       <div class="modal-body" >
                          <div class="modal-dialog">
                       
                             <div class="modal-content">
                             
                            <form onsubmit="return send_mail();" action="<?php echo base_url('Admin/Admin/send_mail/'.$row['id'].'/marketers-contacts'); ?>" method="post"  enctype="multipart/form-data">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 <h4 class="modal-title">Reply Request</h4>
                              </div>
                              <div class="modal-body">

                          <div class="form-group hide">
                            <label for="email"> Subject:</label>
                            <input type="text" name="subject" id="subject"  value="You´ve got a reply from TradespeopleHub" required class="form-control" >
                           </div>
                               <div class="form-group">
                            <label for="email"> Message:</label>
                            <input type="hidden" name="first_name" value="<?php echo $row['first_name']; ?>">
                            <input type="hidden" name="last_name" value="<?php echo $row['last_name']; ?>">
                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                            <textarea rows="5" placeholder="" name="message" id="message" class="form-control"></textarea>
                           </div>
                                 </div>
                                   <div class="modal-footer">
                            <button type="submit" class="btn btn-info edit_btn signup_btn1<?= $row['id']; ?>" >Send</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                   </div>
                             </form>
                     
                                </div>
                          
                             </div>
                          </div>
                       </div>
                    <?php } foreach($listing2 as $row) { ?>
                        <div class="modal fade in" id="add_category<?php echo $row['id']; ?>">
                         <div class="modal-body" >
                            <div class="modal-dialog">
                         
                               <div class="modal-content">
                                
                           
                                  <div class="modal-header">
                                    <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                     <h4 class="modal-title">Message</h4>
                                  </div>
                                  <div class="modal-body form_width100">
                          
                       <p> <?php echo $row['message']; ?></p>
                                   </div>
                                     <div class="modal-footer">
                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                     </div>
                       
                                  </div>
                            
                               </div>
                            </div>
                         </div>
                      <?php  
                      } ?>
                  <script>
                    $(document).ready(function(){
                      mark_read_in_admin('contact_request',"type=3");
                    });
                  </script>






                <?php }else
                {
                  $i = 1;
                foreach($listing1 as $row) {
                //$cate = $this->common_model->getRows('category',$row['p_cate']);
                ?>
                  <tr class="<?= ($row['status']==0)?'active1':''; ?>">
                    <td><?= $i++; ?></td>
                    <td><?= $row['first_name'].' '.$row['last_name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['phone_no']; ?></td>
                    <td><?php $len=strlen($row['message']); if($len>100){
                     echo substr($row['message'],0,100); ?>  <a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#add_category1<?php echo $row['id']; ?>">Read More</a><?php
                    } else{ echo $row['message']; } ?>
                   </td>
                     <td><?= date('d-m-Y H:i: a', strtotime($row['cdate'])); ?></td>
                    <td><span class="label label-success"><?php if($row['status']==0){echo "New";}else if($row['status']==1){ echo "Read"; }else{ echo "Unread";} ?></span></td>
                  
                    <td>
                        <?php if($row['status']==0){ ?> 
                    
                    <a href="<?php echo base_url(); ?>Admin/Admin/mark_read/<?php echo $row['id'];?>/1/homeowners_contacts" class="btn btn-success btn-xs">Mark as Read</a>  
                    <?php }?>
                    <a href="javascript:void(0);" class="btn btn-info btn-xs" data-toggle="modal" data-target="#send_reply1<?php echo $row['id']; ?>">Reply</a>  
                      <a onclick="return confirm('are you sure to delete this request');" href="<?= site_url().'/Admin/Admin/delete_request/'.$row['id']; ?>/homeowners_contacts" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
                    </td>
                  </tr>
                
                <?php }

                      foreach($listing1 as $row) {?>
                        <div class="modal fade in" id="send_reply1<?php echo $row['id']; ?>">
                       <div class="modal-body" >
                          <div class="modal-dialog">
                       
                             <div class="modal-content">
                             
                            <form onsubmit="return send_mail();" action="<?php echo base_url('Admin/Admin/send_mail/'.$row['id'].'/homeowners_contacts'); ?>" method="post"  enctype="multipart/form-data">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 <h4 class="modal-title">Reply Request</h4>
                              </div>
                              <div class="modal-body">

                          <div class="form-group hide">
                            <label for="email"> Subject:</label>
                            <input type="text" name="subject" id="subject"  value="You´ve got a reply from TradespeopleHub" required class="form-control" >
                           </div>
                               <div class="form-group">
                            <label for="email"> Message:</label>
                            <input type="hidden" name="first_name" value="<?php echo $row['first_name']; ?>">
                            <input type="hidden" name="last_name" value="<?php echo $row['last_name']; ?>">
                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                            <textarea rows="5" placeholder="" name="message" id="message" class="form-control"></textarea>
                           </div>
                                 </div>
                                   <div class="modal-footer">
                            <button type="submit" class="btn btn-info edit_btn signup_btn1<?= $row['id']; ?>" >Send</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                   </div>
                             </form>
                     
                                </div>
                          
                             </div>
                          </div>
                       </div>
                    <?php 
                      }


                      foreach($listing1 as $row) {?>
                        <div class="modal fade in" id="add_category1<?php echo $row['id']; ?>">
               <div class="modal-body" >
                  <div class="modal-dialog">
               
                     <div class="modal-content">
                        <div class="modal-header">
                          <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                           <h4 class="modal-title">Message</h4>
                        </div>
                        <div class="modal-body form_width100">
                
             <p><?php echo $row['message']; ?></p>
                         </div>
                           <div class="modal-footer">
             
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                           </div>
                     </form>
                        </div>
                  
                     </div>
                  </div>
               </div>
             <script>
$(document).ready(function(){
	mark_read_in_admin('contact_request',"type=2");
});
</script>
<?php 
                      }
                
                }?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  function send_mail(){
    $('.signup_btn1').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
    $('.signup_btn1').prop('disabled',true);
}
</script>

<?php include_once('include/footer.php'); ?>