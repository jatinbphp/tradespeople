<?php 
include_once('include/header.php');
?>
<style>
	.well {
    background: rgba(61,120,203,1) url(../img/wallet.png);
    border: 1px solid #3d78cb;
    color: #fff;
    padding: 35px 15px;
	margin: 10px 22px;
    min-height: 110px !important;
    background-repeat: no-repeat;
    background-size: 25%;
    background-position: center;
}
	.well h3{
		font-size: 30px;
	}
</style>
<div class="content-wrapper" style="min-height: 933px;">
	 <section class="content-header">
    <h1>Affiliters</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Affiliters</li>
		</ol>
  </section>
  <section class="content">  

    <div class="row">
		 
      <div class="col-xs-12">
        <div class="box">	
			 	<div class="row">
	  			 <div class="Wallet_1 well wel-main col-lg-11.6 text-center">
						<h3 class="text"> 
							<i class="fa fa-money"></i> Total Revenue 
							<span>
								<i class="fa fa-gbp"></i><?= (!empty($total_earnig))?$total_earnig:'0.00'; ?>
							</span> 
						</h3>
					</div>
			  </div>
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          	    	  
          </div> 
          <div class="box-body">
						<?php echo $this->session->flashdata('my_msg'); ?>
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Id</th> 
										<th>Marketers Name</th>
										<th>Email</th>
										<th>Customer acquired</th>
										<!-- <th>Customer types</th> -->
										<th>Total Amount Earned</th>
										<!-- <th>Owed</th> -->
										<!-- <th>Paid</th>  -->
										<th>Joined Date</th>
										<!-- <th>Provided/Received Quotes</th> -->
										<th>Status</th>
										<th>Details</th>
									</tr>
								</thead>
								<tbody>  
								<?php 
								if(!empty($get_marketers)){
									// echo "<pre>"; print_r($get_marketers);
									foreach($get_marketers as $get_marketer){
										
										$cdate = $get_marketer['cdate'];
                    $final_signed = date_create($cdate);
                    $joined_on = date_format($final_signed,"d/m/Y");
                    $total_ref = $this->db->where('referred_by', $get_marketer['id'])->from('referrals_earn_list')->count_all_results();
                    $revan_amount = $this->db->where('referred_by', $get_marketer['id'])->get('referrals_earn_list')->row_array();

                    $afiRefe = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read'=>0, 'referrals_earn_list.referred_by'=>$get_marketer['id']])->count_all_results();
									 ?>
										<tr>
											<td><?php echo $get_marketer['id']?></td>
											<td><?php 
												$today = date('Y-m-d');
												$check_date = date('Y-m-d',strtotime($today.' - 2 days'));
												$create_date = date('Y-m-d',strtotime($get_marketer['cdate']));
												
												$new_label = '';
												
												if($create_date > $check_date or $get_marketer['is_admin_read']==0){
													$new_label = '<br><span style="background:red;color:#fff;" class="label">New</span>';
												}
											echo $get_marketer['f_name']?> <?php echo $get_marketer['l_name']; ?> <?= $new_label; ?></td>
											<td><?php echo $get_marketer['email']?></td>
											<td><?php if(!empty($total_ref)){ echo $total_ref; }else{ echo '0'; } ?></td>
											<!-- <td>Marketer</td> -->
											<!-- <td><?= (!empty($revan_amount['earn_amount']))?$revan_amount['earn_amount']:'0.00'; ?></td> -->
											<td><?= (!empty($get_marketer['referral_earning']))?$get_marketer['referral_earning']:'0.00'; ?></td>
											<!-- <td>0.00</td> -->
											<td><?php echo $joined_on?></td>
											<!-- <td>0</td> -->
											<td><?= ($get_marketer['status']==1)?'<span class="label label-danger">Blocked</span>':'<span class="label label-success">Active</span>'; ?></td>
											 <td>
									
										<div class="dropdown">
											<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select <?php if($afiRefe!==0){ ?> <span style="background:red;color:#fff;" class="badge"><?= $afiRefe; ?></span><?php } ?><span class="caret"></span></button>
											<ul class="dropdown-menu" style="text-align: left;">
												<li><a  target="_blank" href="<?php echo base_url('view-referrals/'.$get_marketer['id']); ?>">View Referrals<?php if($afiRefe!==0){ ?> <span style="background:red;color:#fff;" class="badge"><?= $afiRefe; ?></span><?php } ?></a></li>
												<li><a  target="_blank" href="<?php echo base_url('edit-marketer/'.$get_marketer['id']); ?>">Edit</a></li>
												<?php if($get_marketer['status']==1){ $statusType = 0; $statusText = 'Active'; }else{ $statusType = 1;  $statusText = 'Block'; } ?>
												<li><a href="<?php echo base_url('Admin/Admin/Blockuser2/'.$get_marketer['id'].'/'.$statusType); ?>" onclick="return confirm('Are you sure! you want to <?= $statusText; ?> this user?');"><?= ($get_marketer['status']==1)?'Active':'Block'; ?></a></li>

												<li><a href="<?=base_url(); ?>Admin/Admin/delete_user/<?=$get_marketer['id'];?>/affiliaters" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></li>
												
											</ul>
										</div>
				
					
                  </td>
										</tr>
							  <?php	}
								}
								?> 
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
<script type="text/javascript">
	$(document).ready(function(){
		mark_read_in_admin('users',"type=3");
	});
</script>