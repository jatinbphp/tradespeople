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
                            <strong>My Services</strong>
                            <a href="<?= base_url('add-service'); ?>">
                                <span class="always-hide-mobile btn btn-primary btn-xs">Add New</span>
                            </a>
                        </h2>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12"> 
                            <div class="dashboard-white"> 
                                <div class="row">
                                    <div class="col-sm-3" id="filterDiv">
                                        <div class="form-group">
                                            <select class="form-control input-md" name="action" id="action">
                                                <option id="defaultOption" value="">
                                                    Action on 0 selected
                                                </option>  
                                                <option value="delete_all">
                                                    Delete All
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row dashboard-profile dhash-news">
                                    <div class="col-md-12">
                                        <?php if($my_services){ ?>
                                            <table id="boottable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" name="selectAll" id="ckbCheckAll">
                                                        </th>                     
                                                        <th>Status</th>                     
                                                        <th>Image</th>                     
                                                        <th>Service Name</th> 
                                                        <th>Date Created</th> 
                                                        <th>Price</th>                     
                                                        
                                                        <th>Action</th>                     
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
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
    var table = $("#boottable").DataTable({
        stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25,
        "ajax": {
            "url": site_url + 'users/getAllServices',
            "type": "GET",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id", "render": function(data, type, row) {
                return '<input type="checkbox" name="serviceIds[]" value="'+data+'" class="checkBoxClass" id="service_'+data+'">';
            }},
            { "data": "status", "render": function(data, type, row) {
                return data == 1 ? 'Active' : 'Inactive';
            }},
            { 
                "data": null,
                "render": function(data, type, row) {
                    if (row.image) {
                        // Check if the image is actually a video by checking the file extension
                        if (row.image.endsWith('.mp4')) {
                            return '<video width="100" controls autoplay><source src="'+site_url+'img/services/'+row.image+'" type="video/mp4">Your browser does not support the video tag.</video>';
                        } else {
                            return '<img src="'+site_url+'img/services/'+row.image+'" alt="Service Image" width="50">';
                        }
                    } else {
                        return '<img src="'+site_url+'img/default-image.jpg'+'" alt="Default Image" width="50">';
                    }
                }
            },
            { "data": "service_name" },
            { "data": "created_at", "render": function(data, type, row) {
                return new Date(data).toLocaleDateString() + ' ' + new Date(data).toLocaleTimeString();
            }},
            { "data": "price", "render": function(data, type, row) {
                return '£' + parseFloat(data).toFixed(2);
            }},
            { "data": "id", "render": function(data, type, row) {
                return '<a class="btn btn-warning btn-sm" href="'+site_url+'edit-service/'+data+'">Edit</a>' +
                       ' <a class="btn btn-danger btn-sm" href="'+site_url+'delete-service/'+data+'" onclick="return confirm(\'Are you sure want to delete this service?\')">Delete</a>';
            }}
        ]
    });

    $('#action').on('change', function(){
        var action = $(this).val();
        if(action == 'delete_all'){
            var selectedValues = [];
            $('.checkBoxClass:checked').each(function() {
                selectedValues.push($(this).val());
            });

            if(selectedValues.length == 0){
                alert('Please select at least one service');
                return false;
            }

            $.ajax({
                url: site_url + 'users/deleteAllServices',
                type: "POST",
                data: {'servicesIds': selectedValues},
                dataType: 'json',
                success: function(data){
                    if(data.status == 'success'){
                        table.ajax.reload(null, false);  // Reload DataTable without resetting the pagination
                        alert('Selected services are deleted successfully.');
                    } else {
                        alert('Please select at least one service');
                    }
                     $('#action').val('');
                }
            });
        }
    });

    // Handle the "Select All" checkbox functionality
    $('#ckbCheckAll').on('change', function(){
        $('.checkBoxClass').prop('checked', $(this).prop('checked'));
        var chkLength = $(".checkBoxClass:checked").length;
        $('#defaultOption').text('Action on '+chkLength+' selected');
    });

    $(document).on('change', '.checkBoxClass', function() {
        if($(".checkBoxClass").length == $(".checkBoxClass:checked").length) { 
            $("#ckbCheckAll").prop("checked", true);        
        }else {
            $("#ckbCheckAll").prop("checked", false);        
        }
        var chkLength = $(".checkBoxClass:checked").length;
        $('#defaultOption').text('Action on '+chkLength+' selected');
    });
});
</script>