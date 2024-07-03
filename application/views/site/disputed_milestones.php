<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <style type="text/css">
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
<div class="acount-page membership-page">
<div class="container">
      <div class="user-setting">
          <div class="row">
              <div class="col-sm-3">
                  <?php include 'include/sidebar.php'; ?>         
                </div>
              <div class="col-sm-9">
                                <?php if($this->session->flashdata('error1')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success1')) { ?>
            <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
            <?php } ?>
                  <div class="user-right-side"><h1>Disputed Milestones</h1>
                            <div class="setbox2">
                                <?php if($this->session->flashdata('error')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
            <?php } ?>
                              <div class="table-responsive">
                  <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                   <th style="display: none;"></th>
                  <th>Project Id</th> 
                  <th>Project Name</th>
                  <th>Milestone Name</th>
                  <th>Milestone Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
 <?php 
                foreach($dispute_miles as $key=>$list) {
                 
                ?>
                <tr>
                  <td style="display: none;"><?php  echo $key+1; ?></td>
                    <td><?php $get_jobs=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$list['ds_job_id'])); echo $get_jobs['project_id'] ?></td>
                  <td><a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $get_jobs['title']; ?></a></td>
                       <td><a href="<?php echo base_url('payments/?post_id='.$list['ds_job_id']); ?>"><?php $get_milestone=$this->common_model->get_single_data('tbl_milestones',array('id'=>$list['mile_id'])); echo $get_milestone['milestone_name']; ?></a></td>
                       <td><i class="fa fa-gbp"></i><?php echo $get_milestone['milestone_amount']; ?></td>
                       <td><a href="<?php echo site_url('dispute/'.$list['mile_id'].'/'.$list['ds_job_id']); ?>" class="btn btn-primary btn-sm">View Dispute</a></td>
        

          </tr> 
          <?php 
        }
        
        ?>
              </tbody>
            </table>

                              </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script> 

  $(function(){
    $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
  </script>

<?php include 'include/footer.php'; ?>
  