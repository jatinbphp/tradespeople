<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <img src="<?php echo base_url(); ?>img/logo_invert.png"> <span style="float: right;">Invoice</span>
          </h2>
        </div>
        <!-- /.col -->
      </div> 
      <div class="row">
        <div class="col-xs-12">
					<button class="btn btn-primary pull-right" onclick="window.print();">
            Print
          </button>
        </div>
        <!-- /.col -->
      </div> 
      <!-- info row -->
      <div class="row invoice-info">
				
        <div class="col-sm-6 invoice-col">
          <b> Billed to </b>
          <address>
            <?php $get_users=$this->common_model->get_single_data('users',array('id'=>$userId)); ?>
            <strong><?php echo $get_users['f_name'].' '.$get_users['l_name']; ?></strong><br>
            <?php if($get_users['e_address']){ echo $get_users['e_address'].' ,'.$get_users['locality']; ?><br><?php } ?>
            <?php if($get_users['postal_code']){ echo $get_users['postal_code']; ?><br><?php } ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
         
          <b> Issued by </b>
          <address>
Tradespeoplehub LTD<br>
info@tradespeoplehub.co.uk
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped table-bordered">
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
              <td><?php echo date('d F Y',strtotime($startdate)); ?></td>
              <td><?php echo $msg; ?></td>
              <td>Paid</td>
              <td><i class="fa fa-gbp"></i><?php echo $amount; ?> GBP</td>
            </tr>
            <tr>
              <td colspan="2"></td>
              <td>Total</td>
              <td><i class="fa fa-gbp"></i><?php echo $amount; ?> GBP</td>
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
</body>
</html>