<?php 
include_once('include/header.php');
if(!in_array(10,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
.album a{ color:#fff !important;	background:#1e282c;	border-left-color:#057e8c !important;}
.imgvidioaudio{height: 87px;
    width: 133px;}
</style>
<div class="content-wrapper">
  <section class="content-header">
		<?php if(isset($_SESSION['succ']))
		{
			echo $_SESSION['succ'];
			unset($_SESSION['succ']);
		}
		if(isset($_SESSION['err']))
		{
			echo $_SESSION['err'];
			unset($_SESSION['err']);
		}?>
    <h1>Milestone Dispute Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Milestone Dispute Management</li>
		</ol>
	</section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
          	<div class="table-responsive">
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>Job Title</th>
                  <th>Milestone Name</th>
                  <th>Homeowner</th>
                  <th>Tradesmen</th>
    			  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
						//print_r($dispute_user);
							if($dispute_user) {
							$x = 1;
							foreach($dispute_user as $row) {
							 $job=$this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$row['ds_job_id']));
							 $milestone=$this->Common_model->get_single_data('tbl_milestones',array('id'=>$row['mile_id']));
                             $post_user=$this->Common_model->get_userDataByid($row['ds_puser_id']);
                             $bid_user=$this->Common_model->get_userDataByid($row['ds_buser_id']);
                    
              ?>  
							<tr role="row" class="odd">
								<td><?php echo $x++; ?></td>
								<td><?php echo $job['title']; ?></td>
								<td><?php echo $milestone['milestone_name']; ?></td>
								
								<td><?php echo $post_user['f_name'].' '.$post_user['l_name']; ?></td>
								<td><?php echo $bid_user['f_name'].' '.$bid_user['l_name']; ?></td>
               
				  		      <!--  <td><?php 
								if($row['ds_favour']==$info_inv['id']){
									echo $info_inv['username'];	
								} else if($row['ds_favour']==$info_thin['id']) {
									echo $info_thin['username'];	
								} else if($row['ds_favour']==''){
									echo "NA";	
								} ?>
								</td> -->
								<td>
								<?php
								if($row['ds_status']=='1') {
									echo "Resolve";
								} else {
									echo "Pending";
								} ?>
								</td>
								<td>
									<?php 
									  if($row['ds_status']=='1'){?>
									<a  class="btn btn-info btn-xs" href="<?php echo site_url('dispute_details/'.$row['ds_id']); ?>">view</a>
					 				
									<?php } else { ?>
								<a  class="btn btn-info btn-xs" href="<?php echo site_url('dispute_details/'.$row['ds_id']); ?>">Resolve</a>
									<?php } 
								?>
									
									<!--add	new-->
									<!-- Modal -->
<div class="modal fade" id="myModal<?php echo $row['ds_id']; ?>" role="dialog">
	<div class="modal-dialog">
    
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Resolve</h4>
			</div>
			<form class="form-horizontal" action="process/process.php?action=Resolve&id=<?php echo $row['ds_id']; ?>" method="post">
        <div class="modal-body">
					<div class="box-body">

						<div class="form-group">
							<label for="subcategory" class="col-sm-2 control-label">Favour</label>
							<div class="col-sm-10">								
								<select name="favo" class="form-control">
									<option  value="<?php echo $info_inv['id'];?>"><?php echo $info_inv['username'];?></option>
									<option  value="<?php echo $info_thin['id'];?>"><?php echo $info_thin['username'];?></option>
								</select> 
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="subcategory" class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10">
								<textarea name="cmt"></textarea> 
							</div>
						</div>
					</div>
				</div>
        <div class="modal-footer">
				  <button type="submit" class="btn btn-theme">Save</button>

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
			</form>
		</div>
      
    </div>
  </div>
  
</div>
                    					
				    <!--add new--> 


  <!-- Modal -->
<div class="modal fade" id="view<?php echo $row['ds_id']; ?>" role="dialog">
	<div class="modal-dialog">
    
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Dispute Information</h4>
			</div>
			<div class="modal-body">
				<p><?php echo $row['ds_comment'];?></p>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
      
	</div>
</div>
				

				  
 
                  </td>
                </tr>
								<?php } ?>     
                <?php  }  ?>
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
$(document).ready(function(){
	mark_read_in_admin('tbl_dispute',"1=1");
});
</script>
<?php include_once('include/footer.php'); ?>