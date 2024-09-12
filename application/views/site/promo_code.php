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
                            <strong>Promo Code</strong>                            
                            <span class="always-hide-mobile btn btn-primary btn-xs" data-toggle="modal" data-target="#add_coupons">Generate Promotion Code</span>
                        </h2>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                            <div class="dashboard-white"> 
                                <div class="row dashboard-profile dhash-news">
                                    <div class="col-md-12">
                                        <?php if($promo_code){ ?>
                                            <table id="boottable1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>                     
                                                        <th>Code</th>                     
                                                        <th>Is Limited</th>                     
                                                        <th>Limited User</th> 
                                                        <th>Exceeded Limit</th> 
                                                        <th>Discount</th> 
                                                        <th>Discount Type</th> 
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="verify-page">
                            					<div  style="background-color:#fff;padding: 10px;" class="">
                            						<p>No promo code found.</p>
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

<?php foreach($promo_code as $key => $row) :?>
    <div class="modal fade in" id="edit_coupons<?php echo $row['id']; ?>">
        <div class="modal-body" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" class="promocodeForm" action="<?php echo site_url('users/edit_coupon/').$row['id']; ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit <?php echo ($page_title ?? 'coupons') ?></h4>
                        </div>
                        <div class="modal-body">
                            <?php $this->load->view('site/coupon_form', ['coupon' => $row]) ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info save">Update</button>
                            <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="modal fade in" id="add_coupons">
    <div class="modal-body" >
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" class="promocodeForm" action="<?php echo site_url().'users/add_coupon'; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Add <?php echo ($page_title ?? 'coupons') ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('site/coupon_form', ['coupon' => []]) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info save">Save</button>
                        <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include 'include/footer.php'; ?>

<script>
 $(document).ready(function() {
     $.validator.addMethod("percentageLimit", function(value, element) {
        var discountType = $(element).closest('form').find("#discount_type").val();
        if (discountType === "percentage") {
            return !isNaN(parseFloat(value)) && parseFloat(value) <= 100;
        }
        return true; // Allow other discount types
    }, "Discount percentage cannot exceed 100");

    $("form.promocodeForm").each(function() {
        $(this).validate({
            rules: {
                code: "required",
                discount_type: "required",
                discount: {
                    required: true,
                    percentageLimit: true
                },
                is_limited: "required",
                status: "required",
            },
            messages: {
                code: "Please enter code",
                discount_type: "Please select discount type",
                discount: {
                    required: "Please enter discount",
                    percentageLimit: "Discount percentage cannot exceed 100"
                },
                is_limited: "Please select if limited",
                status: "Please select status",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
});



$(function () {
    var table = $("#boottable1").DataTable({
        stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25,
        "ajax": {
            "url": site_url + 'users/getAllPromoCode',
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id"},
            { "data": "code"},
            { "data": "is_limited", "render": function(data, type, row) {
                return data;
            }},
            { "data": "limited_user"},
            { "data": "exceeded_limit"},
            { "data": "discount"},
            { "data": "discount_type"},
            { "data": "status"},
            { "data": "id", "render": function(data, type, row) {
                return '<div class="btn-group">'+
                            '<button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">'+
                                '<span class="sr-only">Toggle Dropdown</span>'+
                            '</button>'+
                            '<div class="dropdown-menu action" role="menu">'+
                                '<a class="dropdown-item" href="" data-toggle="modal" data-target="#edit_coupons'+data+'"><i class="fa fa-edit pr-3"></i>Edit</a>'+
                                '<a class="dropdown-item" href="'+site_url+'delete-promo-code/'+data+'" onclick="return confirm(\'Are you sure want to delete this promo code?\')"><i class="fa fa-trash pr-3"></i>Delete</a>'+
                            '</div>'+
                        '</div>';
            }}
        ]
    });
});

$(".is-limited-user-selection").change(function (){
    var dataId = $(this).attr('data-id');
    if($(this).val() == 'yes'){
        $('.limited_user_filed_'+dataId).show();
    } else {
        $('.limited_user_filed_'+dataId).hide();
    }
});
</script>