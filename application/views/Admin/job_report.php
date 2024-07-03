<?php
    include_once 'include/header.php';
    if (!in_array(13, $my_access)) {redirect('Admin_dashboard');}
?>
<style>
.table-responsive {
    overflow: auto;
}
@media (max-width:575.98px){
    .table-responsive-sm{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-sm>.table-bordered{
        border:0
    }
}
@media (max-width:767.98px){
    .table-responsive-md{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-md>.table-bordered{
        border:0
    }
}
@media (max-width:991.98px){
    .table-responsive-lg{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-lg>.table-bordered{
        border:0
    }
}
@media (max-width:1199.98px){
    .table-responsive-xl{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-xl>.table-bordered{
        border:0
    }
}
</style>
<div class="content-wrapper">

  <section class="content-header">

    <h1>Reported Jobs</h1>

		<ol class="breadcrumb">

			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

			<li class="active">Reported Jobs</li>

		</ol>

	</section>

  <section class="content">

    <div class="row">

      <div class="col-xs-12">

        <div class="box">

          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>

          <div class="box-body">

			<div class="table-responsive">

            <table id="boottable" class="table table-bordered table-striped">

              <thead>

                <tr>
                  <th>S.NO</th>
                  <th>Job Name</th>
                  <th>Job Id</th>
                  <th>Reason</th>
                  <th>View Job</th>
                  <th>Action</th>
                </tr>

              </thead>

              <tbody>

			<?php foreach ($reports as $key => $lists) {?>
                <tr role="row" class="odd" id="job_<?php echo $lists['id']; ?>">
				  <td><?php echo $key + 1; ?></td>
				  <td><?php echo $lists['title']; ?></td>
                  <td><?php echo $lists['job_id']; ?></td>
                  <td><?php echo $lists['reason']; ?></td>
                  <td><a href="<?php echo base_url('details?post_id=' . $lists['job_id']) ?>" target="_blank"><i class="fa fa-eye"></i></a></td>
                  <td><a href="javascript:void(0)" onclick="deleteJobReport(<?php echo $lists['id'] ?>,<?php echo $lists['job_id'] ?>)"><i class="fa fa-trash"></i></a></td>
                </tr>
            <?php }?>
              </tbody>
            </table>
        </div>

          </div>

        </div>

      </div>

    </div>

  </section>

</div>
<?php include_once 'include/footer.php';?>

<script type="text/javascript">
	function deleteJobReport(id,job_id) {
		if(confirm('Are you sure you want to remove?')){
			$.ajax({
				type:'POST',
				url:site_url+'Admin/admin/remove_report_job',
				data:{
					id:id,
                    job_id:job_id,
				},
				success:function(res){
					toastr.success('Report job successfully deleted');
					$("#job_"+id).remove();
				}
			});
		}
	}
</script>

