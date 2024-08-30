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
    <h1>Invertees</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Invertees</li>
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
								<i class="fa fa-gbp"></i><?= (!empty($total_earnig2))?$total_earnig2:'0.00'; ?>
							</span> 
						</h3>
					</div>
			  </div>
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          	    	  
          </div> 
          <div class="box-body">
						<?php echo $this->session->flashdata('my_msg'); ?>
						<?php if($this->uri->segment(2)=='homeowner-invertees'){ ?>
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
    									<tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending" style="width: 40.816px;">User Id</th>
                        <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Referr by</th> -->
                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Homeowner name</th>
                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th>

                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Quotes job received</th>

                        <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer acquired</th>
                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th> -->

                        <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer Types</th> -->
                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="status: activate to sort column ascending" style="width: 85.4688px;">Revenue</th>
                        <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Credit transferred to wallet  </th> -->

                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Joined Date </th>

                        

                        <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Details</th>
                    
                    </tr>
    								</thead>
										<tbody>   
        								<?php 
                            if(!empty($get_reff_homeowner)){
                                foreach($get_reff_homeowner as $homeowner){
                                  $homeRefe = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read'=>0, 'referrals_earn_list.referred_by'=>$homeowner['referred_by']])->count_all_results();

                                	 $checkBidCount = $this->Common_model->GetColumnName('tbl_jobpost_bids',['posted_by'=>$homeowner['referred_by']],['count(id) as total']);

                                    $users = $this->db->where('id', $homeowner['referred_by'])->get('users')->row_array();
                                    $cdate = $users['cdate'];
                                    $final_signed = date_create($cdate);
                                    $joined_on = date_format($final_signed,"d/m/Y");
                                    // echo "<pre>"; print_r($users);

                                  $today = date('Y-m-d');
                                  $check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                                  $create_date = date('Y-m-d',strtotime($users['cdate']));
                                  
                                  $new_label = '';
                                  
                                  if($create_date > $check_date or $users['is_admin_read']==0){
                                    $new_label = '<br><span style="background:red;color:#fff;" class="label">New</span>';
                                  }

                                ?>
                                <tr role="row" class="odd">
                                <td class="sorting_1"><?php echo $homeowner['referred_by']?></td>
                                <td><?php echo $users['f_name'].' '.$users['l_name'];?> <?= $new_label; ?></td>
                                <td><?php echo $users['email']?></td>
                                <td><?= $checkBidCount['total']; ?></td>

                                <td><?php
                                  $total_earnig = $this->db->select_sum('earn_amount')->from('referrals_earn_list')->where('referred_by', $homeowner['referred_by'])->where('user_type', 2)->get()->row()->earn_amount;
                                 
                                  if(!empty($total_earnig)) { echo $total_earnig; }else{ echo '0.00'; } 
                                ?></td>
                                <!-- <td>No</td> -->
                                <td><?php echo $joined_on?></td>
                              
                                <td>

                                    <a href="<?php echo base_url('view-referrals/'.$homeowner['referred_by']); ?>" class="btn btn-info btn-xs">View child<?php if($homeRefe!==0){ ?> <span style="background:red;color:#fff;" class="badge"><?= $homeRefe; ?></span><?php } ?></a>
                                </tr> 
                        <?php
                            }
                                }
                        ?>	 

                    </tbody>
							</table>
						</div>
						<?php }else{ ?> 
							<div class="table-responsive">
								<table id="boottable" class="table table-bordered table-striped">
										<thead>
	    									<tr role="row">
                          <th class="sorting_asc" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending" style="width: 40.816px;">Id</th>
                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Tradsman Name</th>
                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th>

                          <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer acquired</th> -->
                          <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th> -->
                          <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer Types</th> -->
                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="status: activate to sort column ascending" style="width: 85.4688px;">Quotes Provided</th>

                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="status: activate to sort column ascending" style="width: 85.4688px;">Revenue</th>
                          <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Credit transferred to wallet  </th> -->

                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Joined Date </th>

                          <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Customer Post/Quote received</th> -->


                          <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Details</th>
                      
                      </tr>
										</thead>
										<tbody> 
                      <?php 
                          if(!empty($get_reff_tradsman)){
                              foreach($get_reff_tradsman as $tradsman){
                                $tradsRefe = $this->db->select('*')->from('referrals_earn_list')->join('users', 'users.id = referrals_earn_list.user_id')->where(['users.is_admin_read'=>0, 'referrals_earn_list.referred_by'=>$tradsman['referred_by']])->count_all_results();

                                 $users = $this->db->where('id', $tradsman['referred_by'])->get('users')->row_array();
                                  $cdate = $users['cdate'];
                                  $final_signed = date_create($cdate);
                                  $joined_on = date_format($final_signed,"d/m/Y");

                                  $today = date('Y-m-d');
                                  $check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                                  $create_date = date('Y-m-d',strtotime($users['cdate']));
                                  
                                  $new_label = '';
                                  
                                  if($create_date > $check_date or $users['is_admin_read']==0){
                                    $new_label = '<br><span style="background:red;color:#fff;" class="label">New</span>';
                                  }
                              ?>  
															<tr role="row" class="odd">
                              <td class="sorting_1"><?php echo $tradsman['referred_by']?></td>
                              <td><?php echo $users['f_name'].' '.$users['l_name']; ?><?= $new_label; ?></td>
                              <td> <?php echo $users['email']; ?></td>
                              <td>
                                <?php 
                                     $checkBidCount1 = $this->Common_model->GetColumnName('tbl_jobpost_bids',['bid_by'=>$tradsman['referred_by']],['count(id) as total']);
                                     echo $checkBidCount1['total'];
                                 ?>
                                 </td>
                                <td><?php
                                  $total_earnig1 = $this->db->select_sum('earn_amount')->from('referrals_earn_list')->where('referred_by', $tradsman['referred_by'])->where('user_type', 1)->get()->row()->earn_amount;
                                  // echo $this->db->last_query();
                                  if(!empty($total_earnig1)) { echo $total_earnig1; }else{ echo '0.00'; } 
                                ?></td>
                             
                              <!-- <td>No</td> -->
                              <td><?php echo $joined_on?></td>
                            
                              <td>
                                  <a href="<?php echo base_url('view-referrals/'.$tradsman['referred_by']); ?>" class="btn btn-info btn-xs">View child<?php if($tradsRefe!==0){ ?> <span style="background:red;color:#fff;" class="badge"><?= $tradsRefe; ?></span><?php } ?></a> 

                                  <!-- <a href="https://www.tradespeoplehub.co.uk/homeowners_users">view</a> -->
                              </td>
                              </tr> 
                        <?php
                          }
                              }
                      ?>
                  </tbody>
								</table>
							</div>





						<?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include_once('include/footer.php');
if($this->uri->segment(2)=='homeowner-invertees'){ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      mark_read_in_admin('users',"type=2");
    });
  </script>
<?php } if($this->uri->segment(2)=='tradesman-invertees'){ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      mark_read_in_admin('users',"type=1");
    });
  </script>
 <?php } ?>
