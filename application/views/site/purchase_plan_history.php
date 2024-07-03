<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
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
                	<div class="user-right-side">
                    	<h1>Purchase Plan History</h1> 
                            <div class="setbox2">
                              <div class="table-responsive">
                                <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
                  <th>S.No</th> 
                  <th>Plan</th>
                  <th>Amount</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
     <?php 
                foreach($plans as $key=>$list) {
                ?>
                <tr>
                  <td><?php  echo $key+1; ?></td>
                  <td><?= $list['up_planName'];?></td>
                  <td><i class="fa fa-gbp"></i><?= $list['up_amount'];?></td>
                  <td><?= date('d-m-Y',strtotime($list['up_startdate']));?></td>
                      <td><?= date('d-m-Y',strtotime($list['up_enddate']));?></td>
                 <td>
                      <?php
                      if($list['up_status'] == 1 and strtotime($list['up_enddate']) >= strtotime(date('Y-m-d'))) {
                        echo '<span class="label label-success">Active</span>';
                      } else {
                        echo '<span class="label label-danger">Expired</span>';
                      }
                      ?>
                      </td>
        
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
<script>
  $(function(){
  
  $("#geocomplete").geocomplete({
    details: "form",
    types: ["geocode", "establishment"],
  });
  $("#find").click(function(){
    $("#geocomplete").trigger("geocode");
  });
});


</script>
<?php include 'include/footer.php'; ?>
	