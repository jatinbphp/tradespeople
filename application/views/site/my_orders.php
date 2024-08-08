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
                                        <?php foreach($statusArr as $list): ?>
                                            <li>
                                                <a href="<?php echo base_url().'my-orders?status='.$list; ?>">
                                                    <?php echo ucfirst($list); ?> 
                                                    <span class="<?php echo $list == $_GET['status'] ? 'bg-green text-white' : 'bg-gray'; ?>">
                                                        <?php echo $totalStatusOrder['total_'.$list]; ?>
                                                    </span>
                                                </a>
                                            </li>                                            
                                        <?php endforeach; ?>
                                    </ul>                                    
                                </div> 
                                <div class="row dashboard-profile dhash-news">
                                    <div class="col-md-12">
                                        <?php if($my_orders){ ?>
                                            <table id="boottable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Image/Video</th>                     
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
    <?php
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $order_url = 'users/getAllOrders?status='.$_GET['status'];
        }else{
            $order_url = 'users/getAllOrders';
        }
    ?>

    var table = $("#boottable").DataTable({
        stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25,
        "ajax": {
            "url": site_url + '<?php echo $order_url; ?>',
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "service_name", "render": function(data, type, row) {
               if (row.service_name.file) {
                    if (row.service_name.file.endsWith('.mp4')) {
                        return '<video class="mr-4" width="100" controls autoplay><source src="'+site_url+'img/services/'+row.service_name.file+'" type="video/mp4">Your browser does not support the video tag.</video>';
                    } else {
                        return '<img class="mr-4" src="'+site_url+'img/services/'+row.service_name.file+'" alt="Service Image" width="50">';
                    }
                } else {
                    return '<img class="mr-4" src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
                }
            }},
            { "data": "service_name", "render": function(data, type, row) {
                return row.service_name.service_name;                    
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