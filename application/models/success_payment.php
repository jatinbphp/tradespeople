<?php include 'include/header.php'; ?>

<div class="content-wrapper">
	<section class="content">
		<div class="profile_1">
			<!-- loop -->
			<div class="loop_itm">        
				<div class="profile_detaillls">
				  <div class="row">
				  
				  	<div class="col-md-3"></div>
				  	<?php if($payment_detail) { ?>
							<div class="col-md-6" style="text-align: center;">
								<div class="set-box-last">
									<div class="msg" id="msg"><?= $this->session->flashdata('msg'); ?></div>

									<p>
										<span class="logo-lg"><img src="https://www.webwiders.com/WEB01/OpenSoccerTrials/assets/site/img/logo4.png" class="img_r" style="height: 50px;">
										</span><br><?php echo Project; ?>
									</p>
									<?php if($type==5){ ?>
									<h1>$<?php echo $payment_detail['tr_amount']; ?></h1>
									<p class="grey-color"><?php echo date('D,h:s:A',strtotime($payment_detail['tr_created']));?><br><?php echo date('d-m-Y',strtotime($payment_detail['tr_created']));?></p> 
									<?php } else { ?>
									<h1>$<?php echo $payment_detail['ua_amount']+$payment_detail['ua_fee']; ?></h1>
									<p class="grey-color"><?php echo date('D,h:s:A',strtotime($payment_detail['ua_create']));?><br><?php echo date('d-m-Y',strtotime($payment_detail['ua_create']));?></p>
									<?php } ?>  
						 
					  	   
									<div class="dispote-seci">
										<i class="fa fa-check-circle fa-2x"></i>
										<h3>Success</h3>
									</div>
									<?php if($type==5) { ?>
										<p class="set-l-r">
											<b>Amount : </b> <span>$<?php echo $payment_detail['tr_amount']; ?></span><br>
											<?php if(!empty($payment_detail['tr_transactionId']) && $payment_detail['tr_transactionId']!='NA'){?>
											 <b>Transaction Id : </b> <span><?php echo $payment_detail['tr_transactionId']; ?></span><br>
											 <div class="alert alert-success"><span>$<?php echo $payment_detail['tr_amount']; ?></span> has been deposited in you wallet successfully.</div>
											<?php } ?>
										</p>
									<?php } else { ?>
										<p class="set-l-r">    
											<?php 
											if($payment_detail['ua_type']==1){
												
												if($payment_detail['ua_ticket_id']){
													$j=0;
													$ticket_id=explode(',',$payment_detail['ua_ticket_id']);
													$quantity=explode(',',$payment_detail['ua_quantity']);
													$t_price=explode(',',$payment_detail['ua_sub_price']);
													echo '<h3>Tickets</h3>';
													foreach($ticket_id as $value) {
									
														$tickets = $this->common_model->get_single_data('tickets',array('te_id'=>$ticket_id[$j]));
														if($tickets) {
															 echo '<b></b><span>'.$tickets['te_name'].' - $'.$t_price[$j].' X '.$quantity[$j].'Q = $'.($t_price[$j]*$quantity[$j]).'</span><br>';
														}
														$j++; 
													}
												?>
												<b>Fee : </b><span>$<?php echo $payment_detail['ua_fee']; ?></span><br>
												<b>Total Amount : </b> <span>$<?php echo $payment_detail['ua_amount']+$payment_detail['ua_fee']; ?></span><br>
												<div class="alert alert-success"><span>Congratulations your ticket has been booked successfully.</div>
												<?php } else { ?>
													<div class="alert alert-danger"><span>Something went wrong, try again later.</div>
												<?php } ?>
											<?php }else if($payment_detail['ua_type']==3){ ?>
                                  
												<?php
													$course=$this->common_model->get_single_data('cources',array('co_id'=>	$payment_detail['ua_course_id']));
													if($course){
														echo '<h3>'.$course['co_name'].'</h3>';
													}
												?>
												<b>Fee: </b> <span>$<?php echo $payment_detail['ua_amount']; ?></span><br>
												<b>Transaction Fee: </b> <span>$<?php echo $payment_detail['ua_fee']; ?></span><br>
												<b>Total Amount : </b> <span>$<?php echo $payment_detail['ua_amount']+$payment_detail['ua_fee']; ?></span><br> 
												<div class="alert alert-success"><span>Congratulations you have successfully applied on course.</div>
												<?php }else if($payment_detail['ua_type']==4){?>


													<?php  
													$merchandise=$this->common_model->get_single_data('merchandise',array('m_id'=>$payment_detail['ua_merchandise_id']));
													if($merchandise) {
														echo '<h3>'.$merchandise['m_name'].'</h3>';
													}
													?>

													<b>Price: </b> <span>$<?php echo $payment_detail['ua_product_amount']; ?></span><br>
													<b>Shipping Fee: </b> <span>$<?php echo $payment_detail['ua_shiping_fee']; ?></span><br>
													<b>Transaction Fee: </b> <span>$<?php echo $payment_detail['ua_fee']; ?></span><br>
													<b>Total Amount: </b> <span>$<?php echo $payment_detail['ua_amount']+$payment_detail['ua_fee']; ?></span><br>
													<div class="alert alert-success"><span>Congratulations Your order placed successfully.</div>
												<?php } ?>

									
									<?php } ?>
					  	 </div>
				  	</div>
				    <?php }else{ ?>
                    </div class="col-md-6">
                      <div class="alert alert-danger"><?php echo $msg;  ?></div>
                    </div>
				    <?php } ?>
				    <div class="col-md-3"></div>
				  </div>
				</div>
			</div>
			<!-- loop -->
			
		</div>
	</section>
</div>
<!-- /.content-wrapper -->
<?php include 'include/footer.php'; ?>
