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
                    	<h1>Spend Transaction History</h1> 
                            <div class="setbox2">
                              <div class="table-responsive">
                                <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
                  <th>S.No</th> 
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Detail</th>
                  <th style="display: none;">Transaction Id</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
     <?php 
                foreach($transactions as $key=>$list) {
                ?>
                <tr>
                  <td><?php  echo $key+1; ?></td>
                  <td><?= date('d-m-Y h:i:s A',strtotime($list['tr_created']));?></td>
                  <td>  <?php
                        if($list['tr_type']==1) {
                          echo '<span class="text-success">+<i class="fa fa-gbp"></i>'.$list['tr_amount'].'</span>'; 
                        } else {
                          echo '<span class="text-danger">-<i class="fa fa-gbp"></i>'.$list['tr_amount'].'</span>'; 
                        } ?> </td>
                  <td><?= $list['tr_message']; ?></td> 
                  <td style="display: none;"><?= $list['tr_transactionId']; ?></td>
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
  function update_profile(){
  $('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
  $('.submit_btn').prop('disabled',true);
}
function getcity(val)
{
  $.ajax({
      url:site_url+'home/get_city',
      type:"POST",
      dataType:'json',
      data:{'val':val},
      success:function(datas)
      {
      
       $('#city').html(datas.cities);
  
        return false;
      }
  });
  return false;
  
}
</script>
<?php include 'include/footer.php'; ?>
	