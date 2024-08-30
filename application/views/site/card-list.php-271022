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
              <div class="mjq-sh">
            <h2><strong>Card List</strong>
            </h2>
   </div>
             <div class="row">
                <?= $this->session->flashdata('message'); ?>
        <div class="col-md-12 col-sm-12"> 
            <div class="dashboard-white"> 
                <div class="row dashboard-profile dhash-news">
                    <div class="col-md-12">
                         <?php if($cards){ ?>
                            <table class="Paging table table-bordered">
                                <thead>
                                    <th>Sn.</th>
                                    <th>Card Holder</th>
                                    <th>Card number</th>
                                    <th>Expire</th>
                                    <th>Card</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php $sn=1; foreach ($cards as $key => $val) { ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= $val['u_name']; ?></td>
                                            <td>**** **** **** <?= $val['last4']; ?></td>
                                            <td><?= $val['exp_month']; ?>/<?= $val['exp_year']; ?></td>
                                            <td><?= $val['brand']; ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="<?= base_url('card-info/'.$val['id']); ?>">Edit</a>
                                                <a class="btn btn-danger btn-sm" href="<?= base_url('delete-card/'.$val['id']); ?>" onclick="confirm('Are you sure want to delete this card?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                         <?php }else{ ?>
                              <div class="verify-page">
					<div  style="background-color:#fff;padding: 10px;" class="">
						<p>No cards found.</p>
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
$('.Paging').DataTable({
 // "searching": false,
 // "lengthChange": false,
 "ordering": false,
 // "pageLength": 15,
 // "info": false,
fnDrawCallback: function() {
// $(".Paging thead").remove();
}
});
});
</script>
	