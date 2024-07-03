<?php include 'include/header.php'; ?>
<style type="text/css">
  table{
    width: 100%;
  }
</style>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<div class="acount-page membership-page">
<div class="container">
    	<div class="user-setting">
        	<div class="row">
            	<div class="col-sm-3">
                	<?php include 'include/sidebar.php'; ?>
                </div>
            	<div class="col-sm-9">
              <div class="mjq-sh">
            <h2><strong>Notifications</strong>
            </h2>
   </div>
             <div class="row">
        <div class="col-md-12 col-sm-12"> 
            <div class="dashboard-white"> 
                <div class="row dashboard-profile dhash-news">
                    <div class="col-md-12">
                         <?php if($trade_news){ ?>
                          <table class="Paging">
                            <thead>
                              <th></th>
                            </thead>
                            <tbody>
                              <?php foreach ($trade_news as $key => $list) { 
                            $get_users=$this->common_model->get_single_data('users',array('id'=>$list['posted_by']));
                           ?>
                           <tr><td>
                                      <div class="dhash-news-main">
                            <div class="row">
                                <div class="col-md-1 col-xs-2">
                                   <?php if($get_users['profile']){ ?>   
                <a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/<?= $get_users['profile']; ?>" class="img-resposive" style="width: 50px;height: 50px;"></a>
            <?php } else { ?>
                  <a href="<?php echo base_url('profile/'.$get_users['id']); ?>"><img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-resposive" style="width: 50px;height: 50px;"></a>
                  <?php } ?> 
                                </div>
                                <div class="col-md-11 col-xs-10">
                                    <p><?php echo $list['nt_message']; ?><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
                                    <?php if($list['job_id']!=''){ $get_job_bids=$this->common_model->get_post_bids('tbl_jobpost_bids',$list['job_id'],$list['nt_userId']); } ?>     
                                </div>
                            </div>
                                      <?php if($list['nt_apstatus']==1){ ?>
                            <div class="row">
                              <div class="col-md-1 col-xs-2"> </div>
                                    <div class="col-md-11 col-xs-10">
  
                                    <p><b><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?> bid £ <?php echo $get_job_bids[0]['bid_amount']; ?> GBP to complete in <?php echo $get_job_bids[0]['delivery_days']; ?> day(s)</b><br><small><?php $time_ago = $this->common_model->time_ago($list['nt_create']); echo $time_ago; ?></small></p>
                                    <?php echo $get_job_bids[0]['propose_description'];  ?>  
                                    </div>   
                 
                        </div> 
                                 <?php }else if(false){ ?>
                                                    <div class="row">
                              <div class="col-md-1 col-xs-2"> </div>
                                    <div class="col-md-11 col-xs-10">
  
                                    <p><b>Reason of rejection</b><br></p>
                                    <?php echo $get_job_bids[0]['reject_reason'];  ?>  
                                    </div>   
                        </div> 
                                 <?php } ?>
                
                    </div></td></tr>
              
                         <?php } ?>
                       </tbody>
                             </table>
                         <?php }else{ ?>
                              <div class="verify-page">
					<div  style="background-color:#fff;padding: 10px;" class="">
						<p>No jobs found.</p>
					</div>
				</div>
                         <?php } ?>
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
<?php include 'include/footer.php'; ?>
<script>
  $(function () {
$('.Paging').DataTable({
 "searching": false,
 "lengthChange": false,
 "ordering": false,
 "pageLength": 15,
 "info": false,
fnDrawCallback: function() {
$(".Paging thead").remove();
}
});
});
</script>
	