<?php 
include_once('include/header.php');
if(!in_array(9,$my_access)) { redirect('Admin_dashboard'); }
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
  
    <h1>Bid jobs</h1>
    
    <ol class="breadcrumb">
    
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      
      <li class="active">Bid jobs</li>
      
    </ol> 
    
  </section>

  <section class="content">
  
    <div class="row">
    
      <div class="col-xs-12">
      
        <div class="box">
        
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
          
          <div class="box-body">
          
      <div class="table-responsive">
            
            <table id="boottable" class="table table-bordered table-striped">
            
              <thead>
              
                <tr> 
                  <th class="hide">S.NO</th> 
                  <th>Job ID</th> 
                  <th>Post User</th> 
                  <th>Job Title</th> 
                  <th>Description</th> 
                  <th>Bid User</th>
                  <th>Bid Amount</th>
                  <th>Create Date</th>                 
                </tr>
                
              </thead>
              
              <tbody>
              
                <?php
                
                $x=1;
                if(count($bid_user_jobs)>0){
                foreach($bid_user_jobs as $lists) {
                  $post_user=$this->Common_model->get_userDataByid($lists['posted_by']);
                  $bid_user=$this->Common_model->get_userDataByid($lists['bid_by']);
                  $job_title="NA";
                  if($lists['job_id']){
                    $job=$this->Common_model->get_single_data('tbl_jobs',array('job_id'=>$lists['job_id']));
                    if($job){
                     $job_title=$job['title'];
                    }
                  }
                ?>
             
                <tr role="row" class="odd">
                  <td class="hide"><?php echo $x; ?></td>
                  <td><?php echo $job['project_id']; ?></td>
                  <td><?php echo $post_user['f_name']." ".$post_user['l_name']; ?></td>
                  <td><?php echo $job_title; ?></td>  
                  <td>
                      <?php if($lists['propose_description']){

                       if(strlen($lists['propose_description'])<100){
                         echo $lists['propose_description'];
                       }else{
                         echo substr($lists['propose_description'], 0,100).'...<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#job_description'.$lists['id'].'">Read more</button>';
                       }} ?>       
                  </td>
                  <td><?php echo $bid_user['f_name']." ".$bid_user['l_name']; ?></td>
                  <td>
                     <?php 
                      if($lists['bid_amount']){
                        echo '<i class="fa fa-gbp"></i>'.$lists['bid_amount']; 
                      }
                     ?>
                  </td>      
                  <td><?php echo date('d-m-Y',strtotime($lists['cdate'])); ?></td>
                </tr>

                 
<?php if($lists['propose_description']){ ?>
  <!-- Modal -->
  <div class="modal fade" id="job_description<?= $lists['id']; ?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Description</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $lists['propose_description']; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
                
              <?php $x++; }} ?>
              
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
	mark_read_in_admin('tbl_jobpost_bids',"1=1");
});
</script>
<?php include_once('include/footer.php'); ?>



  