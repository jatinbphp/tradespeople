<?php 
include_once('include/header.php');
?>
<style>
.well {
    background: rgba(61,120,203,1) url(../img/wallet.png);
    border: 1px solid #3d78cb;
    color: #fff;
    padding: 22px 15px;
    min-height: 110px !important;
    background-repeat: no-repeat;
    background-size: 25%;
    background-position: center;
}
</style>
<div class="content-wrapper" style="min-height: 933px;">
<!-- main content-->
<section class="content-header">
    <h1>Referrals</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Referrals</li>
      </ol>
	  
  </section>
<section>
    <div class="user-right-side" style="background:#fff; margin:20px 20px 0px 20px;padding:20px;"><h1>Balance</h1><div class="edit-user-section"><div>
    </div>
    <div class="msg"></div>
    <ul class="nav nav-tabs refferal_types">
        <li class="<?php if(!isset($_GET['t']) && !isset($_GET['h']) || $_GET['h']==1){ echo 'active'; }else{ echo ''; } ?> homeowner_table" data-type="1">
            <a data-toggle="tab" style="cursor: pointer;color: black;">Home Owner</a>
        </li>
        <li class="<?= (isset($_GET['h']) || !isset($_GET['t']))?'':'active'; ?> trades_table" data-type="2">
            <a data-toggle="tab" style="cursor: pointer;color: black;">Tradsman</a>
        </li>
        <!-- <li class="marketer_table" data-type="3"><a data-toggle="tab" style="cursor: pointer;color: black;">Marketer</a></li> -->
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <div class="row">
                <div class="col-sm-5" style="margin-top:20px;">
                    <div class="loop_itm">
                        <div class="profile_detaillls">
                            <div class="row">
                                <div class="col-sm-12"><div class="msg" id="msg"></div>
                                    <div class="row">
                                        <div class="col-sm-12  text-center">
                                            <div class="Wallet_1 well wel-main">
                                                <h3 class="text"> <i class="fa fa-money"></i> Balance <span><i class="fa fa-gbp"></i><?= (!empty($total_earnig['earn_amount']))?$total_earnig['earn_amount']:'0'; ?></span> </h3>
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
    </div>

        <!-- </div> -->
        
    <!-- Edit-section-->
    <!-- </div> -->
</section>


<section class="tradsman" style="margin:0px 20px 20px 20px"> 
        <div class="box">

          <!-- <div class="div-action pull pull-right" style="padding-bottom:20px;">
          	    	  
          </div>  -->
            <div class="box-body">
				<div class="table-responsive" id="homeowner_table">
                    <h2>Homeowner acquired by marketer</h2>
					<div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="boottable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
    								<thead>
    									<tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending" style="width: 40.816px;">User Id</th>
                                            <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Referr by</th> -->
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Homeowner name</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th>

                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">
                                                <?php 
                                                    if($paymentSettings[0]['payment_method'] == 1){
                                                        echo 'Quotes job received';
                                                    }else{
                                                        echo 'Milestone Released(£)';
                                                    }
                                                ?>                                                
                                            </th>

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
                                                  // echo "<pre>";  print_r( $homeowner);
                                                     
                                                    
                                                    $checkBidCount = $this->Common_model->GetColumnName('tbl_jobpost_bids',['posted_by'=>$homeowner['user_id']],['count(id) as total']);

                                                    
                                                    $cdate = $homeowner['cdate'];
                                                    $final_signed = date_create($cdate);
                                                    $joined_on = date_format($final_signed,"d/m/Y");
                                                ?>
                                                <tr role="row" class="odd">
                                                <td class="sorting_1"><?php echo $homeowner['user_id']; ?></td>
                                                <td><?php
                                                $invitedData = $this->Common_model->GetColumnName("users", array("id"=>$homeowner['user_id']));

                                                $today = date('Y-m-d');
                                                $check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                                                $create_date = date('Y-m-d',strtotime($invitedData['cdate']));
                                                
                                                $new_label = '';
                                                if($create_date > $check_date or $invitedData['is_admin_read']==0){
                                                    $new_label = '<br><span style="background:red;color:#fff;" class="label">New</span>';
                                                }
                                                echo $invitedData['f_name'].' '.$invitedData['l_name']; ?><?= $new_label; ?></td>
                                                <td><?php echo $invitedData['email']?></td>
                                                <td>
                                                    <?php
                                                        $firstMilestone = $this->Common_model->get_single_data("tbl_milestones", array("posted_user"=>$homeowner['user_id']));
                                                        if($adminSetting[0]['payment_method'] == 1){
                                                            echo $checkBidCount['total'];
                                                        }else{
                                                            echo $firstMilestone['milestone_amount'];
                                                        }                                                         
                                                    ?>                                                        
                                                </td>

                                                <!-- <td><?php
                                                $reffData = $this->Common_model->GetColumnName("users", array("id"=>$homeowner['referred_by']));
                                                 echo $reffData['f_name'];?></td>
                                                <td><?php echo $reffData['email']?></td> -->
                                                
                                               <!--  <td>
                                                    <?php
                                                        if ($invitedData['type'] == 2) {
                                                       echo "Homeowner";
                                                    }
                                                    ?>
                                                </td> -->
                                                <td><?= $homeowner['earn_amount']; ?></td>
                                                <!-- <td>No</td> -->
                                                <td><?php echo $joined_on?></td>
                                              
                                                <td>

                                                    <a href="<?php echo base_url('view-referrals/'.$homeowner['user_id']); ?>?h=1" class="btn btn-info btn-xs">View child</a> 
                                                </tr> 
                                        <?php
                                            } ?>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    mark_read_in_admin('users',"type=2");
                                                });
                                            </script>
                                        <?php } ?>	 
								
                                    </tbody>
							    </table>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="table-responsive" id="trades_table" style="display:none">
                    <h2>Tradsman acquired by marketer</h2>                           
					<div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="boottable_trades" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
    								<thead>
    									<tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending" style="width: 40.816px;">Id</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Tradsman Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th>

                                            <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer acquired</th> -->
                                            <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th> -->
                                            <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer Types</th> -->
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="status: activate to sort column ascending" style="width: 85.4688px;">
                                                <?php 
                                                    if($paymentSettings[0]['payment_method'] == 1){
                                                        echo 'Quotes Provided';
                                                    }else{
                                                        echo 'Milestone Released(£)';
                                                    }
                                                ?>
                                            </th>

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
                                                    $cdate = $tradsman['cdate'];
                                                    $final_signed = date_create($cdate);
                                                    $joined_on = date_format($final_signed,"d/m/Y");

                                                    
                                                ?>  
                								<tr role="row" class="odd">
                                                <td class="sorting_1"><?php echo $tradsman['user_id']?></td>
                                                <td><?php
                                                $invitedData = $this->Common_model->GetColumnName("users", array("id"=>$tradsman['user_id']));
                                                $today = date('Y-m-d');
                                                $check_date = date('Y-m-d',strtotime($today.' - 2 days'));
                                                $create_date = date('Y-m-d',strtotime($invitedData['cdate']));
                                                
                                                $new_label = '';
                                                if($create_date > $check_date or $invitedData['is_admin_read']==0){
                                                    $new_label = '<br><span style="background:red;color:#fff;" class="label">New</span>';
                                                }
                                                
                                                echo $invitedData['f_name'].' '.$invitedData['l_name']; ?><?= $new_label; ?></td>
                                                <td> <?php echo $invitedData['email']?></td>
                                                <td>
                                                <?php 
                                                    $firstMilestone = $this->Common_model->get_single_data("tbl_milestones", array("userid"=>$tradsman['user_id']));
                                                    if($paymentSettings[0]['payment_method'] == 1){
                                                        $checkBidCount1 = $this->Common_model->GetColumnName('tbl_jobpost_bids',['bid_by'=>$tradsman['user_id']],['count(id) as total']);
                                                        echo $checkBidCount1['total'];
                                                    }else{
                                                        echo $firstMilestone['milestone_amount'];
                                                    }
                                                 ?>
                                                 </td>
                                                <!-- <td><?php
                                                $reffData = $this->Common_model->GetColumnName("users", array("id"=>$tradsman['referred_by']));
                                                 echo $reffData['f_name'];?></td>
                                                <td><?php echo $reffData['email']?></td> -->
                                                
                                                <!-- <td>
                                                    <?php

                                                    if ($invitedData['type'] == 1) {
                                                       echo "Tradsman";
                                                      

                                                    }
                                                    ?>
                                                </td> -->
                                                <td><?= $tradsman['earn_amount']; ?></td>
                                                <!-- <td>No</td> -->
                                                <td><?php echo $joined_on?></td>
                                              
                                                <td>
                                                    <a href="<?php echo base_url('view-referrals/'.$tradsman['user_id']); ?>?t=1" class="btn btn-info btn-xs">View child</a> 

                                                    <!-- <a href="https://www.tradespeoplehub.co.uk/homeowners_users">view</a> -->
                                                </td>
                                                </tr> 
                                          <?php
                                            } ?>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    mark_read_in_admin('users',"type=1");
                                                });
                                            </script>
                                        <?php } ?>
                                    </tbody>
    							</table>
                            </div>
                        </div>
                    </div>
                </div>

               <!--  <div class="table-responsive" id="marketer_table" style="display:none"><h2>Affiliates</h2>
                    <div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="boottable_market" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Id: activate to sort column descending" style="width: 40.816px;">Id</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Marketers Name: activate to sort column ascending" style="width: 189.236px;">Marketer Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Requested Amount: activate to sort column ascending" style="width: 219.705px;">Email</th>

                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer acquired</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Payment Method: activate to sort column ascending" style="width: 195.174px;">Customer Types</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="status: activate to sort column ascending" style="width: 85.4688px;">Revenue</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Owned</th>
                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Paid</th>

                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Joined Date </th>


                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Customer Post/Quote received</th>

                                            <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 252.795px;">Details</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        <?php 
                                            if(!empty($get_reff_marketer)){
                                                foreach($get_reff_marketer as $marketerd){
                                                    $cdate = $marketerd['cdate'];
                                                    $final_signed = date_create($cdate);
                                                    $joined_on = date_format($final_signed,"d/m/Y");
                                                ?>
                                                <tr role="row" class="odd">
                                                <td class="sorting_1"><?php echo $marketerd['id']?></td>
                                                <td><?php
                                                $reffData = $this->Common_model->GetColumnName("users", array("id"=>$marketerd['referred_by']));
                                                 echo $reffData['f_name'];?></td>
                                                <td><?php echo $reffData['email']?></td>
                                                <td><?php
                                                $invitedData = $this->Common_model->GetColumnName("users", array("id"=>$marketerd['user_id']));
                                                echo $invitedData['f_name']?></td>
                                                <td>
                                                    <?php

                                                    if ($marketerd['referred_type'] == 1) {
                                                       echo "Tradsman";
                                                       $totalQuotest = $this->Common_model->GetColumnName("tbl_jobpost_bids", array("bid_by"=>$homeowner['user_id']), array("COUNT(id) as total"));

                                                    } else if ($marketerd['referred_type'] == 2) {
                                                        $totalQuotest = $this->Common_model->GetColumnName("tbl_jobpost_bids", array("posted_by"=>$homeowner['user_id']), array("COUNT(id) as total"));
                                                       echo "Homeowner";
                                                    } else if ($marketerd['referred_type'] == 3) {
                                                        echo "Marketer";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                $invitedData = $this->Common_model->GetColumnName("users", array("id"=>$marketerd['user_id']));
                                                echo $invitedData['f_name']?></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo $joined_on?></td>
                                                <td><?php
                                                if ($totalQuotest && $totalQuotest["total"] > 0) {
                                                   echo $totalQuotest["total"];
                                                } else {
                                                    echo 0;
                                                }
                                                ?></td>
                                                <td><a href="https://www.tradespeoplehub.co.uk/homeowners_users">view</a></td>
                                                </tr> 
                                        <?php
                                            }
                                                }
                                        ?>   
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
	


<!-- main content-->
<?php include_once('include/footer.php'); ?>
<script>  
  $(function(){
    $("#boottable_trades").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
  });


   $(function(){
    $("#boottable_market").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
  });


  </script>
    <?php 
        if(isset($_GET['t']) && $_GET['t']==1){ ?>
        <script> 
            jQuery(document).ready(function(){ 
                jQuery('#trades_table').show();
                jQuery('#homeowner_table').hide();
            });
        </script>
    <?php } ?>

    <?php 
        if(isset($_GET['h']) && $_GET['h']==1){ ?>
        <script> 
            jQuery(document).ready(function(){ 
                jQuery('#homeowner_table').show();
                jQuery('#trades_table').hide();
            });
        </script>
    <?php } ?>
  <script> 
  	jQuery(document).ready(function(){
  		jQuery(document).on('click','.homeowner_table',function(){
  			jQuery('#homeowner_table').show();
  			jQuery('#trades_table').hide();
            // jQuery('#marketer_table').hide();
  		});
  		jQuery(document).on('click','.trades_table',function(){

  			jQuery('#trades_table').show();
  			jQuery('#homeowner_table').hide();
            // jQuery('#marketer_table').hide();

  		});
        // jQuery(document).on('click','.marketer_table',function(){
        //     jQuery('#marketer_table').show();
        //     jQuery('#trades_table').hide();
        //     jQuery('#homeowner_table').hide();
        // });
  	});
  </script>
