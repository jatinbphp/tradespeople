<?php 
include_once('include/header.php');
if(!in_array(11,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
.album a{ color:#fff !important;	background:#1e282c;	border-left-color:#057e8c !important;}
.imgvidioaudio{height: 87px;
    width: 133px;}
</style>
<div class="content-wrapper">
  <section class="content-header">
		<?php if(isset($_SESSION['succ']))
		{
			echo $_SESSION['succ'];
			unset($_SESSION['succ']);
		}
		if(isset($_SESSION['err']))
		{
			echo $_SESSION['err'];
			unset($_SESSION['err']);
		}?>
    <h1>Rewards</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Rewards</li>
		</ol>
	</section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            <div class="table-responsive">
            <table id="boottable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>Date</th>
                  <th>Username</th>
                  <th>Plan</th>
                  <th>Plan Amount</th>
                  <th>Reward</th>
    			  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              <?php
						//print_r($dispute_user);
							if($rewards) {
							$x = 1;
							foreach($rewards as $row) {
							 $plans=$this->Common_model->get_single_data('tbl_package',array('id'=>$row['tr_plan']));
						 $get_users=$this->Common_model->get_single_data('users',array('id'=>$row['tr_userid']));
                    
              ?>  
							<tr role="row" class="odd">
								<td><?php echo $x++; ?></td>
								  <td><?= date('d-m-Y h:i:s A',strtotime($row['tr_created']));?></td>
								  <td><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></td>
								<td><?php echo $plans['package_name']; ?></td>
								<td><?php echo '<span class="text-danger">-<i class="fa fa-gbp"></i>'. $plans['amount'].'</span>'; ?></td>
								<td><?php echo '<span class="text-success">+<i class="fa fa-gbp"></i>'. $plans['reward_amount'].'</span>'; ?></td>
								    <td><?php
                      if($row['tr_status'])
                      {
                        echo '<span class="text-success">Success</span>';
                      }
                      else
                      {
                        echo '<span class="text-danger">Failed</span>';
                      }
                      ?> </td>	

				  
 
                  </td>
                </tr>
								<?php } ?>     
                <?php  }  ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include_once('include/footer.php'); ?>