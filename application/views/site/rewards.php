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
                  <div class="user-right-side">
                   <h1>Rewards</h1> 
                            <div class="setbox2">
                                <?php if($this->session->flashdata('error')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
            <?php } ?>
                              <div class="table-responsive">
                     <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="display: none;"></th>
                   <th>Date</th>
                  <th>Plan</th> 
                  <th>Plan Amount</th>
                  <th>Reward</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
     <?php foreach($rewards as $key=>$list) {
                ?>
                <tr>
                  <td style="display: none;"><?php  echo $key+1; ?></td>
                  <td><?= date('d-m-Y h:i:s A',strtotime($list['tr_created']));?></td>
                  <td><?php $plan_id=$list['tr_plan']; $get_plans=$this->common_model->get_single_data('tbl_package',array('id'=>$plan_id)); echo $get_plans['package_name']; ?></td>
                  <td><?php echo '<span class="text-danger">-<i class="fa fa-gbp"></i>'. $get_plans['amount'].'</span>'; ?></td>
                  <td><?php echo '<span class="text-success">+<i class="fa fa-gbp"></i>'. $get_plans['reward_amount'].'</span>'; ?></td>
                   <td><?php
                      if($list['tr_status'])
                      {
                        echo '<span class="text-success">Success</span>';
                      }
                      else
                      {
                        echo '<span class="text-danger">Failed</span>';
                      }
                      ?> </td>
 
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
  