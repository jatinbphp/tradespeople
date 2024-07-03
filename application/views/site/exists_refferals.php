<?php include 'include/header.php'; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <style type="text/css">
.trads-offer{
    color:#FF3500;
}
.tradsman-banner .card{
background:#fff;
border-radius:5px;
padding:20px 10px 10px 30px;
}
.tradsman-banner .card p{
font-size:18px;
font-weight:500;
}
.referar-earnings{
margin-bottom:20px;
background:#fff;
border-radius:10px;
margin-top:30px
}
.earn-bnts .btn-warning{
background: #3d78cb;
    border-color: #3d78cb;
margin:0px 10px
}
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
.earn-bnts{
padding-top:25px;
}
  .rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
.table-responsive {
    overflow: auto;
}
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal_wallet {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 31%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

	  .cashout-popup{
		  margin:25px;
          margin-top: 1px;
		  text-align: center;
	  }
	  .cashout-popup button{
		width: 80%;
		margin: 20px 0;
		padding: 20px;
	  }
	  .cashout-popup input{
		  padding: 28px;
		  font-size: 23px;
		  margin: auto;
/*		  width: 80%;*/
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
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row" >
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>         
				</div>
				<div class="col-sm-9" >
<!-- main content-->
 <?php 
 // if($this->session->userdata('type')==1){
$settings = $this->db->where('id', 1)->get('admin_settings')->row();
$settings2 = $this->db->where('id', 2)->get('admin_settings')->row();
$paymentSettings = $this->common_model->get_all_data('admin');
//print_r($settings);
 if($settings->banner == 'enable'){
	 ?>
<!-- <section class="tradsman-banner">
    <div class="card">
        
        <p><img src="<?php echo base_url('asset/admin/img/Gas.png')?>" alt=""><span class="trads-offer">Did you know ?</span>   Refer another trade and earn free leads once they purchase their first job</p>
    </div>
</section> -->
 <?php
} 
// } 
?>
<?php 
    if($balance_amount != ''){
        // $balance = $balance_amount[0]->balance;
        $balance = $balance_amount->referral_earning;
    }else{
       $balance = 0; 
    }
?>
<section class="referar-earnings">
   <h1 style="font-size:18px;border-bottom: 1px solid #dadada;padding: 14px 20px;">Balance</h1>
   <?php echo $this->session->flashdata('success'); ?>
   <?php echo $this->session->flashdata('success1234'); ?>
<div class="row" style="padding:25px">
<div class="col-lg-4 ">
<div class="referar-earnings-wallet">
<div class="Wallet_1 well wel-main">
<h3 class="text"> <i class="fa fa-money"></i> Balance <span><i class="fa fa-gbp"></i><?php echo $balance;?></span> </h3>
</div>
</div>
</div>

    <?php if($this->session->userdata('type')==1){?>
        <div class="col-lg-8  earn-bnts">
            <p>
                <?php if($admin_settings[0]['payment_method'] == 1){?>
                    <button id="myBtn_wallet" class="btn btn-warning btn-lg">Add to wallet</button>
                <?php }?>
                <button id="myBtn" class="btn btn-warning btn-lg">Cash out</button>
            </p>
            <!-- <p>Add your referral earnings to your wallet and use it to quote a job. </p> -->
            <p>Add your earning to your wallet and use it to pay for job or withdraw it. If you want to cashout your earning must reach £<?php echo $min_cashout?>. <a href="<?php echo base_url('payout-request-list'); ?>"> View Payment</a> </p>
        </div>
    <?php }?>

    <?php if($this->session->userdata('type')==2){?>
        <div class="col-lg-8  earn-bnts">
            <p>
                <button id="myBtn_wallet" class="btn btn-warning btn-lg">Add to wallet</button>
                <button id="myBtn" class="btn btn-warning btn-lg">Cash out</button>
            </p>
            <p>Add your earning to your wallet and use it to pay for job or withdraw it. If you want to cashout your earning must reach £<?php echo $min_cashout?>. <a href="<?php echo base_url('payout-request-list'); ?>"> View Payment</a> </p>
        </div>
    <?php }?>


</div>
</section>
<div class="user-right-side">
            <h1>Referral Report</h1>
                    <div class="setbox2">

                      <div class="table-responsive">
              <div id="boottable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-12"><table id="boottable1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="boottable_info">
              <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Job Id: activate to sort column ascending" style="width: 39.8889px;"> S.no</th>
                    <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Job Title: activate to sort column ascending" style="width: 53.8889px;">Name</th>
                    <th style="width: 119.889px;" class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending">User Type</th>
                    <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Posted By: activate to sort column ascending" style="width: 60.8889px;">Signed-up</th>
                    <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Budget: activate to sort column ascending" style="width: 43.8889px;">
                        <?php 
                            if($paymentSettings[0]['payment_method'] == 1){
                                echo 'Quote Provide/Received';
                            }else{
                                echo 'Milestone Released(£)';
                            }
                        ?>
                    </th>
                    <th style="width: 96.8889px;" class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Postcode / Distance: activate to sort column ascending">Job Posted</th>
                    <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 37.8889px;">Earnings</th>
                    <!-- <th class="sorting" tabindex="0" aria-controls="boottable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 37.8889px;">Referred Link</th> -->
                    </tr>
              </thead>
    <tbody>
                                     <?php
                                    if(!empty($marketers_referrals_list)){
                                        $k=1;
                                        foreach($marketers_referrals_list as $marketers_referrals){
                                            if($marketers_referrals['earn_amount'] == ''){
                                                $marketers_referrals['earn_amount'] = 'Pending';
                                            }
                                             $signed=$marketers_referrals['signed_up'];
                                             $final_signed = date_create($signed);
                                             $signed_on = date_format($final_signed,"d/m/Y");
                                        ?>
                                        <tr>
                                        <td><?php echo $k ?></td>
                                        <td><?php echo $marketers_referrals['f_name'].' '.$marketers_referrals['l_name'];?></td>
                                        <td><?php echo $marketers_referrals['type']?></td>
                                        <td><?php echo $signed_on?></td>
                                        <td><?php echo $marketers_referrals['quotes']?></td>
                                        <td><?php echo $marketers_referrals['jobs']?></td>
                                        <td><?php echo $marketers_referrals['earn_amount']?></td>
                                        <!-- <td><?php echo ($marketers_referrals['referred_link']) ? $marketers_referrals['referred_link'].'?referral='.$user_id : ''; ?></td> -->
                                    </tr> 
                                <?php
                                    $k++;       
                                    }
                                    }
                                ?> 
   </tbody>
            </table></div></div></div>

                              </div>
                            </div>
                        
                    </div>
<!-- main content end here-->
</div>
</div>
</div>
</div>
</div>
<div id="myModal_wallet" class="modal_wallet cashout_popup">

  <!-- Modal content -->
    <div class="modal-content">
     <div class="row"><i class="fa fa-times-circle fa-3 cashout_close" aria-hidden="true" style="text-align: right;float: right;font-size: 17px;color: #3d78cb;cursor: pointer;"></i></div>
            <div class="col-lg-12">
                <p class="text-center">Available Balance: £<?php echo $balance;?></p>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                   <input type="text" placeholder="Enter Amount" value="" name="request_amount" id="user_request_amount" class="form-control input-md text-center">
                </div>
            </div>
            <div class="row">
                <div id="walletErr" style="color:red;"></div>
                <!-- <div id="walletSuccess" style="color:green;"></div> -->
                <div class="col-lg-4"></div>
               <div class="col-lg-6" style="margin-top: 10px;margin-left: 14px;">
                   <button class="btn btn-primary user_wallet_cashout_request">SUBMIT</button> 
               </div>
            </div>
    </div>

</div>
<div id="myModal" class="modal cashout_popup">

  <!-- Modal content -->
  <div class="modal-content">
    <!-- <span class="close">&times;</span> -->
   
	  <div class="cashout-popup">
            <div class="row">
                <i class="fa fa-times-circle fa-3 cashout_close" aria-hidden="true" style="text-align: right;float: right;font-size: 17px;color: #3d78cb;cursor: pointer;"></i>
            </div>
		   <p class="text-center">Available Balance: £<?php echo $balance;?></p>
		  <input type="text" placeholder="Enter Amount to Cashout" value="" name="cashout_value" id="cashout_value" class="form-control input-md text-center">
          <input type="hidden" id="balance_min" value="<?php echo $min_cashout?>">
          <input type="hidden" id="balance" value="<?php echo $balance?>">

          <?php 
          if(!empty($account_info)){
                $payout_bank_name = $account_info->wd_bank;
                $payout_account_number = $account_info->wd_account;
                $payout_sort_code = $account_info->wd_ifsc_code;
                $payout_account_holder_name = $account_info->wd_account_holder;
                $payout_paypal_email_address = $account_info->paypal_email_address;
                if(isset($settings2) && $settings2->payment_method=='both'){ ?>
                    <div class="row" style="text-align: left;">
                    <?php  if($account_info->wd_account!=''){ $a = 1; ?>
                        <label class="radio-inline">
                            <input type="radio" name="account_details" value="Bank Transfer"> Send Payout to <?php echo $account_info->wd_bank; ?> bank <?php echo $account_info->wd_account; ?>
                        </label>
                    <?php }
                        if($account_info->paypal_email_address!=''){
                            $b = 1; $paypal_email_address=$account_info->paypal_email_address; ?>
                                <label class="radio-inline">
                                    <input type="radio" class="paypal_details" name="account_details" value="Paypal Transfer"> Send Payout to Paypal <?php echo $paypal_email_address?>
                                </label>
                    <?php    } ?>
                    </div>
                <?php }elseif(isset($settings2) && $settings2->payment_method=='bank_transfer'){
                    if($account_info->wd_account!=''){ $a = 1; ?>
                        <div class="row">
                          <input type="radio" style="width: 4%; margin-top: 18px;" name="account_details" value="Bank Transfer">
                          <span>Send Payout to <?php echo $account_info->wd_bank; ?> bank <?php echo $account_info->wd_account; ?> </span>
                        </div>

                    <?php } 
                }elseif(isset($settings2) && $settings2->payment_method=='paypal' && $account_info->paypal_email_address != ''){ $b = 1;
                    $paypal_email_address=$account_info->paypal_email_address;
                 ?>
                 <div class="row">
                      <input type="radio" style="width: 4%; margin-top: 12px;" class="paypal_details" name="account_details" value="Paypal Transfer">
                      <span>Send Payout to Paypal <?php echo $paypal_email_address?></span>
                </div> 
               <?php  } }else{  ?>
               
                <p style="padding-top: 10px; margin-bottom: -10px;"><a href="<?= base_url('manage-bank'); ?>" style="text-decoration: none;">Please fill the Bank Account details</a></p>
            <?php } ?>
            <p class="text-center" id="payErr" style="color:red;"></p>
            <!-- <p class="text-center" id="paySuccess" style="color:green;"></p> -->

		   <button class="btn btn-primary cashout_request">SUBMIT</button>   
		  <!-- <p class="text-center">if want to cash out, it must reach £<?php echo $min_cashout?>  </p> -->
          
	  </div>
  </div> 
 
</div>

<script>
    jQuery(document).ready(function(){
        jQuery(document).on('click','.cashout_close',function(){
            jQuery('.cashout_popup').hide();
        });
   
$(function(){
    $("#boottable1").DataTable({
            stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
        });
  });
// Get the modal
var modal = document.getElementById("myModal");
var modal_wallet = document.getElementById("myModal_wallet");

// Get the button that opens the modal
var btn_wallet = document.getElementById("myBtn_wallet");
var btn = document.getElementById("myBtn");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
if(btn_wallet){
	btn_wallet.onclick = function() {
	  modal_wallet.style.display = "block";
	}
}

btn.onclick = function() {
	console.log("d");
  modal.style.display = "block";
}



// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_wallet) {
    modal_wallet.style.display = "none";
  }
  if (event.target == modal) {
    modal.style.display = "none";
  }
  
}
 });

jQuery(document).ready(function(){
    jQuery('.user_wallet_cashout_request').on("click",function(){
        // alert('user_wallet_cashout_request');
        var balance= jQuery('#balance').val();
        var amount= jQuery('#user_request_amount').val();
        var min_amount= jQuery('#balance_min').val();
        if(amount == '' || amount == '0'){
            $('#walletErr').text('Please Enter Cashout Amount');
        }else{
            if(balance == '0'){
                $('#walletErr').text('There is no balance to cashout');
                return;
            }else{
                // if(parseInt(balance) >= parseInt(min_amount)){
                    if(parseInt(amount) > parseInt(balance)){
                        $('#walletErr').text('There is not enough balance');
                    }else{
                        

                        jQuery.ajax({
                            // url:'<?= base_url(); ?>Users/users_payouts',
                            url:'<?= base_url(); ?>Users/user_wallet_payouts',
                            type:"post",
                            dataType:'json',
                            data :
                        {   
                            amount:amount,
                        },
                        cache: false,
                        success: function(response)
                        { 
                            console.log(response);
                            if(response == 1){
                                // $('#walletSuccess').text('Successfully Send request to admin');
                                      location.reload(true);
                                // setTimeout(function(){
                                //        }, 1000);
                            }
                            

                        } 
                            });
                        
                    }
                // }else{
                //     alert('If you want to cash out,it must reach '+min_amount+'');
                // }
            }
        }
    });
});






jQuery(document).ready(function(){
    jQuery('.cashout_request').on("click",function(){
        var balance= jQuery('#balance').val();
        var amount= jQuery('#cashout_value').val();
        var min_amount= jQuery('#balance_min').val();
        if(amount == '' || amount == '0'){
             $('#payErr').text('Please Enter Cashout Amount');
        }else{
            if(balance == '0'){
                 $('#payErr').text('There is no balance to cashout');
                return;
            }else{
                if(parseInt(balance) >= parseInt(min_amount)){
                    if(parseInt(amount) > parseInt(balance)){
                         $('#payErr').text('There is not enough balance');
                    }else{
                        if(parseInt(amount) >= parseInt(min_amount)){
                            if(jQuery('input[name="account_details"]').is(':checked')){
                                var value= jQuery('input[name="account_details"]:checked').val();

                                    jQuery.ajax({
                                        url:'<?= base_url(); ?>Users/users_payouts',
                                        type:"post",
                                        dataType:'json',
                                        data :
                                    {   
                                        transfer_type:value,
                                        amount:amount,
                            
                            },
                            cache: false,
                            success: function(response)
                            { 
                                console.log(response);
                                if(response == 1){
                                    location.reload(true);
                                    //  $('#paySuccess').text('Successfully Send payout request to admin');
                                    // setTimeout(function(){
                                    //       location.reload(true);
                                    //        }, 1000);
                                }
                                if(response == 2){
                                     $('#payErr').text('You can not make new request while your previous request is pending..');
                                }

                            } 
                                });
                            }else{
                                 $('#payErr').text('Please Select Transfer Account');
                            }
                        }else{
                             $('#payErr').text('Minimum cashout amount must not be less than £'+min_amount);
                        }
                    }
                }else{
                     $('#payErr').text('If you want to cash out,it must reach £'+min_amount);
                }
            }
        }
    });
});

</script>
<?php include 'include/footer.php'; ?>
