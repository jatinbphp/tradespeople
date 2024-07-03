<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="row">
	<div class="col-md-9">
		<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <img src="<?php echo base_url(); ?>img/mini-logo.png"> Invoice : <?php echo $miles['milestone_name']; ?>
         
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
           <small class="pull-right">Date: <?php $yrdata= strtotime($miles['cdate']);   echo date('d', $yrdata)." ".date('F', $yrdata); ?> <?php echo date('Y',$yrdata); ?></small><br>
           <br>
        <?php /*<div class="col-sm-6 invoice-col">
          From
          <address>
            <?php $get_users=$this->common_model->get_single_data('users',array('id'=>$miles['posted_user'])); ?>
            <strong><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></strong><br>
            <?php if($get_users['e_address']){ echo $get_users['e_address'].' ,'.$get_users['locality']; ?><br><?php } ?>
            <?php if($get_users['postal_code']){ echo $get_users['postal_code']; ?><br><?php } ?>
            Phone: <?php echo $get_users['phone_no']; ?><br>
            Email: <?php echo $get_users['email']; ?>
          </address>
        </div> */?>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
          To
          <address>
             <?php $get_users1=$this->common_model->get_single_data('users',array('id'=>$miles['userid'])); ?>
            <strong><?php echo $get_users1['f_name'].' '.$get_users1['l_name']; ?></strong><br>
            <?php if($get_users1['e_address']){ echo $get_users1['e_address'].' ,'.$get_users1['locality']; ?><br><?php } ?>
            <?php if($get_users1['postal_code']){ echo $get_users1['postal_code']; ?><br><?php } ?>
            Phone: <?php echo $get_users1['phone_no']; ?><br>
            Email: <?php echo $get_users1['email']; ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice </b><br>
          <br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Date</th>
              <th>Description</th>
              <th>Status</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><?php $yrdata= strtotime($miles['cdate']);   echo date('d', $yrdata)." ".date('F', $yrdata); ?> <?php echo date('Y',$yrdata); ?></td>
              <td><?php echo $miles['milestone_name']; ?></td>
              <td><?php if($miles['status']!=2){ ?>Pending<?php }else{ ?>Released<?php } ?></td>
              <td><i class="fa fa-gbp"></i><?php echo $miles['milestone_amount']; ?> GBP</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row" style="display: none;">
        <!-- accepted payments column -->
        <div class="col-xs-6 img_card">
          <p class="lead">Payment Methods:</p>
          <img src="<?php echo base_url(); ?>img/card-major.png" alt="Visa">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due 2/22/2014</p>

          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Subtotal:</th>
                <td>$250.30</td>
              </tr>
              <tr>
                <th>Tax (9.3%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>$265.24</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print" style="display: none;">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>
	</div>
	<div class="col-md-3"></div>
</div>
</div>