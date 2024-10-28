<?php
include_once 'include/header.php';
if (!in_array(22, $my_access)) {redirect('Admin_dashboard');}
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
		<h1><?php echo $menu; ?></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Service Orders List</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			
			<div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total <?php echo $menu; ?> Amount</span>
            <span class="info-box-number"><?php echo '£'.number_format($counter['totalCompletedOrderAmount'],2);?></span>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total <?php echo $menu; ?></span>
            <span class="info-box-number"><?php echo $counter['totalCompletedOrder'];?></span>
          </div>
        </div>
      </div>
			
			<?php if($service_fee == 'show'):?>      
	      <div class="col-md-4 col-sm-6 col-xs-12">
	        <div class="info-box">
	          <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>
	          <div class="info-box-content">
	            <span class="info-box-text">Total Service Fees</span>
	            <span class="info-box-number"><?php echo '£'.number_format($counter['totalServiceFees'],2);?></span>
	          </div>
	        </div>
	      </div>
	    <?php endif; ?>  

			<div class="col-xs-12">
				<div class="box">
					<div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Order Id</th>
										<th>Service Name</th>
										<th>Homeowner</th>
										<th>Price</th>
										<th>Payment Method</th>
										<th>Status</th>										
										<th>Created At</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($order_list as $key => $lists) {?>
									<tr role="row" class="odd" id="request_<?php echo $lists['id']; ?>">
										<td><?php echo $lists['order_id']; ?></td>
										<td><?php echo $lists['service_name']; ?></td>
										<td><?php echo $lists['f_name'].' '.$lists['l_name']; ?></td>
										<td><?php echo '£'.number_format($lists['price'],2); ?></td>
										<td><?php echo ucfirst($lists['payment_method']); ?></td>												
										<td><?php echo ucfirst($lists['status']); ?></td>												
										<td><?php echo $lists['created_at']; ?></td>
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

<div class="modal fade bd-example-modal-lg" id="serviceDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header">
	        <h3 class="modal-title pull-left"></h3>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div id="serviceDetailsDiv">
	    	</div>
	    </div>
	    <div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      	</div>
    </div>
  </div>
</div>

<?php include_once 'include/footer.php';?>