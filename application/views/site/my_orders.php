<?php include 'include/header.php'; ?>
<style type="text/css">
    table{
        width: 100%;
    }

    .imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
    .btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
    .imgUp{margin-bottom:15px}
    .boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;}
    .boxImage img { height: 100%;object-fit: contain;}
    #imgpreview {
        padding-top: 15px;
    }
    .boxImage {
        margin: 0;
    }
    .imagePreviewPlus {
        height: 150px;
        box-shadow: none;
    }
    .orderReason{
        cursor: pointer;
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
                                            <li class="<?php echo $list == $_GET['status'] ? 'active' : ''; ?>">
                                                <a href="<?php echo base_url().'my-orders?status='.$list; ?>">
                                                    <?php echo ucfirst($list); ?> 
                                                    <span class="<?php echo $list == $_GET['status'] ? 'bg-yellow text-white' : 'bg-gray'; ?>">
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
                                                        <th>Order Id</th>                     
                                                        <th>Image/Video</th>                     
                                                        <th>Service Name</th>                     
                                                        <th>Order Date</th>                     
                                                        <th>Total</th>
                                                        <?php if($this->session->userdata('type') == 2):?>
                                                            <th>Status</th>
                                                        <?php endif; ?>
                                                        <?php if($this->session->userdata('type') == 2):?>
                                                            <th>View Order</th>
                                                        <?php endif; ?>
                                                        <?php if($this->session->userdata('type') == 1):?>
                                                            <th>View Order</th>
                                                        <?php endif; ?>
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

<div class="modal fade in" id="order_reason_modal">
    <div class="modal-body" id="msg">
        <div class="modal-dialog modal-lg">  
            <div class="modal-content">             
                <form method="post" id="order_requirement_form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="reasonTitle"></h4>
                    </div>
                    <div class="modal-body form_width100">
                        <h4 style="margin-top:0px" id="orderReason"></h4>
                        <div class="row" id="reason"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>          
        </div>
    </div>
 </div>

<div class="modal fade in" id="order_requirement_modal">
    <div class="modal-body" id="msg">
        <div class="modal-dialog modal-lg">  
            <div class="modal-content">             
                <form method="post" id="order_requirement_form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Order Requirements & Attachments</h4>
                    </div>
                    <div class="modal-body form_width100">
                        <h4 style="margin-top:0px">Order Requirements</h4>
                        <div class="row" id="requirements" style="border-bottom:1px solid #ddd;">
                        </div>
                        <!-- <h4>Order Location</h4>
                        <div class="row" id="location" style="border-bottom:1px solid #ddd;"> 
                        </div>-->
                        <h4>Order Attachments</h4>
                        <div class="row" id="attachments">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
             { "data": "order_id"},
            { "data": "service_name", "render": function(data, type, row) {
               if (row.service_name.file) {
                    if (row.service_name.file.endsWith('.mp4')) {
                        return '<a href="'+row.service_name.link+'"><video class="mr-4" width="100" controls autoplay><source src="'+site_url+'img/services/'+row.service_name.file+'" type="video/mp4">Your browser does not support the video tag.</video></a>';
                    } else {
                        return '<a href="'+row.service_name.link+'"><img class="mr-4" src="'+site_url+'img/services/'+row.service_name.file+'" alt="Service Image" width="100"></a>';
                    }
                } else {
                    <?php if($this->session->userdata('type') == 1):?>
                        return '<img class="mr-4" src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="100">';
                    <?php endif; ?>
                    <?php if($this->session->userdata('type') == 2):?>
                        return '<a href="'+row.service_name.link+'"><img class="mr-4" src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="100"></a>';
                    <?php endif; ?>
                }
            }},
            { "data": "service_name", "render": function(data, type, row) {
                return '<a href="'+row.service_name.link+'">'+row.service_name.service_name+'</a>';
            }},
            { "data": "created_at"},
            { "data": "total_price"},
            <?php if($this->session->userdata('type') == 2):?>
            { "data": "status", "render": function(data, type, row) {
                return row.status;
            }},
            <?php endif; ?>
            <?php if($this->session->userdata('type') == 2):?>
                { "data": "viewOrder", "render": function(data, type, row) {
                    return row.viewOrder;
                }},
            <?php endif; ?>
            <?php if($this->session->userdata('type') == 1):?>
                { "data": "viewOrder", "render": function(data, type, row) {
                    return row.viewOrder;
                }},
            <?php endif; ?>
        ]
    });
});

$('#boottable tbody').on('change', '.orderStatus', function (event) {
    event.preventDefault();

    var status = $(this).val();
    var oId = $(this).data('id');

    var userConfirmed = confirm('Are you sure to update a status of the order?');

    if (userConfirmed) {
        $.ajax({
            type:'POST',
            url:site_url+'users/updateStatus',
            data:{id:oId,status:status},
            success:function(response){
                if(response == 1){
                    window.location.reload();
                }else{
                    alert('Something is wrong.');
                }
            }
        });
    } else {
        $(this).prop('selectedIndex', 0);
    }
  });

$('#boottable tbody').on('click', '.orderAgain', function (event) {
    var oId = $(this).data('id');
    swal({
        title: "Confirm Order",
        text: "Are you sure you want to place this order?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: 'Place Order',
        cancelButtonText: 'Cancel'
    }, function() {        
        $.ajax({
          type:'POST',
          url:site_url+'users/orderAgain',
          data:{oId:oId},
          dataType: 'json',
          success:function(response){
            if(response.status == 0){
              swal({
                  title: "Login Required!",
                  text: "If you want to again placed this order then please login first!",
                  type: "warning"
              }, function() {
                  window.location.href = '<?php echo base_url().'login'; ?>';
              });
            }else{
              window.location.href = '<?php echo base_url().'serviceCheckout'; ?>';
            }      
          }
        });
    });    
});

$('#boottable tbody').on('click', '.requirements', function (event) {
    event.preventDefault();
    var oId = $(this).data('id');

    $.ajax({
        type:'POST',
        url:site_url+'users/getRequirements',
        data:{oId:oId},
        dataType:'json',
        success:function(data){
            if(data.status == 1){
                $('#requirements').html(data.requirements);
                // $('#location').html(data.location);
                $('#attachments').html(data.attachements);
                $('#order_requirement_modal').modal('show');
            }else{
                alert('Order requirement not found.');
            }
        }
    });
});

$('#boottable tbody').on('click', '.orderReason', function (event) {
    event.preventDefault();
    var oId = $(this).data('id');

    $.ajax({
        type:'POST',
        url:site_url+'users/getOrderReason',
        data:{oId:oId},
        dataType:'json',
        success:function(data){
            if(data.status == 1){
                if(data.order_status == 'cancelled'){
                    $('#reasonTitle').text('Order Cancelled');
                    $('#orderReason').text('Reason For Cancelled');
                }

                if(data.order_status == 'disputed'){
                    $('#reasonTitle').text('Order Disputed');
                    $('#orderReason').text('Reason For Disputed');
                }

                $('#reason').html(data.reason);
                $('#order_reason_modal').modal('show');
            }else{
                alert('Reason not found.');
            }
        }
    });
});
</script>