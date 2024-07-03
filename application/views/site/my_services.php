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
                    <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                    <div class="mjq-sh">
                        <h2>
                            <strong>My Services</strong>
                            <a href="<?= base_url('add-service'); ?>">
                                <span class="always-hide-mobile btn btn-primary btn-xs">Add New</span>
                            </a>
                        </h2>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                            <div class="dashboard-white"> 
                                <div class="row dashboard-profile dhash-news">
                                    <div class="col-md-12">
                                        <?php if($my_services){ ?>
                                            <table id="boottable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th>Service Name</th> 
                                                        <th>Category</th>
                                                        <th>Price</th>                     
                                                        <th>Status</th>                     
                                                        <th>Action</th>                     
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($my_services as $key => $list) { ?>
                                                        <tr>
                                                            <td style="display: none;"><?php  echo $key+1; ?></td>
                                                            <td><?php echo $list['service_name']; ?></td>
                                                            <td><?php echo $list['cat_name']; ?></td>
                                                            <td><?php echo '£'.$list['price']; ?></td>
                                                            <td>
                                                                <?php 
                                                                    echo $list['status'] == 1 ? 'Active' : 'Inactive';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-warning btn-sm" href="<?= base_url('edit-service/'.$list['id']); ?>">Edit</a>
                                                                 <a class="btn btn-danger btn-sm" href="<?= base_url('delete-service/'.$list['id']); ?>" onclick="confirm('Are you sure want to delete this service?')">Delete</a>
                                                            </td>
                                                        </tr>                                  
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="verify-page">
                            					<div  style="background-color:#fff;padding: 10px;" class="">
                            						<p>No service found.</p>
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
	