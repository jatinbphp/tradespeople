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
                                                        <th style="display: none;"></th>
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
                                                    <?php foreach ($my_services as $key => $list) { ?>
                                                        <tr>
                                                            <td style="display: none;"><?php  echo $key+1; ?></td>
                                                            <td>
                                                                <input type="checkbox" name="serviceIds[]" value="<?php echo $list['id']; ?>" class="checkBoxClass" id="service_<?php echo $list['id']; ?>">
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    echo $list['status'] == 1 ? 'Active' : 'Inactive';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                    $CI =& get_instance();
                                                                    $CI->load->model('Common_model');
                                                                    $img = 'img/services/' . $list['image'];
                                                                    echo $CI->Common_model->checkFile($img);
                                                                ?>
                                                            </td>
                                                            <td><?php echo $list['service_name']; ?></td> 
                                                            <td><?php echo date('d/m/Y h:i:s', strtotime($list['created_at'])); ?></td>
                                                            <td><?php echo '£'.number_format($list['price'],2); ?></td>                   
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
    var table = $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
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

            console.log(selectedValues);
            
            $.ajax({
                url:site_url+'users/deleteAllServices',
                type:"POST",
                data:{'servicesIds':selectedValues},
                success:function(data){
                    if(data == 0){
                        alert('Please select at least one service');
                    }else{
                        table.ajax.reload(null, false);
                    }
                }
            });
        }
    });
});

$("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    var chkLength = $(".checkBoxClass:checked").length;
    $('#defaultOption').text('Action on '+chkLength+' selected');
});

$('.checkBoxClass').click(function(){
    if($(".checkBoxClass").length == $(".checkBoxClass:checked").length) { 
        $("#ckbCheckAll").prop("checked", true);        
    }else {
        $("#ckbCheckAll").prop("checked", false);        
    }
    var chkLength = $(".checkBoxClass:checked").length;
    $('#defaultOption').text('Action on '+chkLength+' selected');
});


</script>