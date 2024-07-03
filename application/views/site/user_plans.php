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
	
    <h1>User Plans</h1>
		
		<ol class="breadcrumb">
		
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			
			<li class="active">User Plans</li>
			
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
                  <th>User</th>	
                  <th>Plan</th> 
                  <th>Amount</th>
                  <th>Total Bids</th>
                  <th>Used Bids</th>
                  <th>Start Date</th>									
                  <th>End Date</th>	
                  <th>Status</th>
                </tr>
								
              </thead>
							
              <tbody>
							
								<?php
								
								$x=1;
								
								foreach($user_plans as $lists) {
		              $user=$this->Common_model->get_userDataByid($lists['up_user']);
                  $plan=$this->Common_model->get_single_data('tbl_package',array('id'=>$lists['up_plan']));
                  $plan_name="NA";
                  if($plan){
                  $plan_name=$plan['package_name'];
                  }
								?>
             
                <tr role="row" class="odd">
				          <td><?php echo $x; ?></td>	
                  <td><?php echo $user['f_name']." ".$user['l_name']; ?></td>
                  <td><?php echo $plan_name; ?></td>
                  <td>$<?php echo $lists['up_amount']; ?></td>
                  <td>
                     <?php 
                      if($lists['bid_type']==1){
                       echo $lists['up_bid']; 
                      }else{
                       echo "Unlimited"; 
                      }
                     ?>
                  </td>  
                  <td><?php echo $lists['up_used_bid']; ?></td>   
                  <td><?php echo date('d-m-Y',strtotime($lists['up_startdate'])); ?></td>
                  <td><?php echo date('d-m-Y',strtotime($lists['up_enddate'])); ?></td>
                  <td>
                      <?php
                      if($lists['up_status'] == 1 and strtotime($lists['up_enddate']) >= strtotime(date('Y-m-d'))) {
                        echo '<span class="label label-success">Active</span>';
                      } else {
                        echo '<span class="label label-danger">Expired</span>';
                      }
                      ?>
                  </td>
                </tr>
								
              <?php $x++; } ?>
							
              </tbody>
							
            </table>   
        </div>
			
          </div>
					
        </div>
				
      </div>
			
    </div>
		
  </section>
	
</div>




  