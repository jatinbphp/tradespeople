<?php 
    include_once('include/header.php');
    if(!in_array(21,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo ($page_title ?? 'coupons') ?></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"><?php echo ($page_title ?? 'coupons') ?></li>
		</ol>
    </section>
    <section class="content-header text-right">
	    <button  data-toggle="modal" data-target="#add_coupons" class="btn btn-success">Add</button>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="div-action pull pull-right" style="padding-bottom:20px;"></div> 
                    <div class="box-body">
                        <?php echo $this->session->flashdata('msg'); ?>
                        <div class="table-responsive">
                            <table id="boottable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>		
                                        <th>S.No</th> 
                                        <th>Code</th>
                                        <th>Is Limited</th>
                                        <th>Limited User</th>
                                        <th>Exceeded Limit</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($coupons as $key => $row): ?>   
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $row['code'] ?></td>
                                        <td><?php echo (($row['is_limited'] && $row['is_limited'] == 'yes') ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>') ?></td>
                                        <td><?php echo $row['limited_user'] ?></td>
                                        <td><?php echo $row['exceeded_limit'] ?></td>
                                        <td><?php echo $row['discount'] ?></td>
                                        <td><?php echo $row['discount_type'] ?></td>
                                        <td>   
                                            <a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_coupons<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
                                            <a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/coupons/delete_coupons/'.$row['id']); ?>" onclick="return confirm('Are you sure! you want to delete this coupon?');">Delete</a> 
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php foreach($coupons as $key => $row) :?>
    <div class="modal fade in" id="edit_coupons<?php echo $row['id']; ?>">
        <div class="modal-body" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="<?php echo site_url('Admin/coupons/edit_coupon/').$row['id']; ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Edit <?php echo ($page_title ?? 'coupons') ?></h4>
                        </div>
                        <div class="modal-body">
                            <?php $this->load->view('Admin/coupon_form', ['coupon' => $row]) ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Update</button>
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
                <form method="post" action="<?php echo site_url().'Admin/coupons/add_coupon'; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Add <?php echo ($page_title ?? 'coupons') ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php $this->load->view('Admin/coupon_form', ['coupon' => []]) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Save</button>
                        <button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    $(".is-limited-user-selection").change(function (){
        var dataId = $(this).attr('data-id');
        if($(this).val() == 'yes'){
            $('.limited_user_filed_'+dataId).show();
        } else {
            $('.limited_user_filed_'+dataId).hide();
        }
    });
</script>
<?php include_once('include/footer.php'); ?>