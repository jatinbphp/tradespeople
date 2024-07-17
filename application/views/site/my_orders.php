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
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php unset($_SESSION['error']) ?>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('success')): ?>
                        <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
                        <?php unset($_SESSION['success']) ?>
                    <?php endif; ?>
                    <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                    <div class="mjq-sh">
                        <h2>
                            <strong>Manage Orders</strong>                            
                        </h2>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                            <div class="dashboard-white"> 
                                <div class="verification-checklist order-metrics mb-5">
                                    <ul class="list">
                                        <li>
                                            Placed 
                                            <span class="bg-gray">
                                                <?php echo $totalStatusOrder['total_pending']; ?>
                                            </span>
                                        </li>
                                        <li>
                                            Completed 
                                            <span class="bg-gray">
                                                <?php echo $totalStatusOrder['total_complete']; ?>
                                            </span>
                                        </li>
                                        <li>
                                            Cancelled 
                                            <span class="bg-gray">
                                                <?php echo $totalStatusOrder['total_cancel']; ?>
                                            </span>
                                        </li>
                                        <li>
                                            All 
                                            <span class="bg-green">
                                                <?php echo $totalStatusOrder['total_orders']; ?>
                                            </span>
                                        </li>
                                    </ul>                                    
                                </div> 
                                <div class="row dashboard-profile dhash-news">
                                    <div class="col-md-12">
                                        <?php if($my_orders){ ?>
                                            <table id="boottable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Service Name</th>                     
                                                        <th>Order Date</th>                     
                                                        <th>Total</th> 
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="verify-page">
                            					<div  style="background-color:#fff;padding: 10px;" class="">
                            						<p>No order found.</p>
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
    var table = $("#boottable").DataTable({
        stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25,
        "ajax": {
            "url": site_url + 'users/getAllOrders',
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "service_name", "render": function(data, type, row) {
               if (row.service_name.file) {
                    if (row.service_name.file.endsWith('.mp4')) {
                        return '<video class="mr-4" width="100" controls autoplay><source src="'+site_url+'img/services/'+row.service_name.file+'" type="video/mp4">Your browser does not support the video tag.</video><span>'+row.service_name.service_name+'</span>';
                    } else {
                        return '<img class="mr-4" src="'+site_url+'img/services/'+row.service_name.file+'" alt="Service Image" width="50"><span>'+row.service_name.service_name+'</span>';
                    }
                } else {
                    return '<img class="mr-4" src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50"><span>'+row.service_name.service_name+'</span>';
                }
            }},
            { "data": "created_at"},
            { "data": "total_price"},
            { "data": "status", "render": function(data, type, row) {
                return '<span class="btn btn-success btn-sm">'+row.status+'</span>';
            }}
        ]
    });
});
</script>