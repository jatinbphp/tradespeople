<?php
include 'include/header.php';
$get_commision = $this->common_model->get_commision();
?>
<style type="text/css">
	#openChat{cursor: pointer;}
	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
    .btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
    .imgUp{margin-bottom:15px}
    .boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;}
    .boxImage img { height: 100%;object-fit: contain;}
    #imgpreview {
        padding-top: 15px;
    }
    .boxImage {
        margin: 0;
    }
    .imagePreviewPlus {
        height: 150px;
        box-shadow: none;
    }

	.tradesmen-top{
		padding: 15px 15px 10px;
	}
	.img-name{
		display: flex;
    	gap: 75px;
	}
	.img-name img{
		width: 130px;
		height: 75px;	
	}
	img {
		display: block;
		max-width: 100%;
	}

	.timeline-div{border-radius: 5px;}
	
	.faicon{
		font-size: 30px;
		color: #2875D7;
	}
	.filled-icon svg {
		fill: #2875D7;
	}

	.timeline {
		width: 85%;
		max-width: 700px;
		margin-left: auto;
		margin-right: auto;
		display: flex;
		flex-direction: column;
		padding: 0 0 0 32px;
		border-left: 3px solid #ddd;		
	}

	.timeline li{
		border-bottom: 1px solid #dbd6d6;
		padding-bottom: 1.5rem;
	}

	.delivery-time li{
		padding-bottom: 0;	
	}

	.timeline-item {
		display: flex;
		gap: 24px;
		& + * {
			margin-top: 6px;
		}		
	}

	.new-comment {
		width: 100%;
		input {
			border: 1px solid #f1f1f1 ;
			border-radius: 6px;
			height: 48px;
			padding: 0 16px;
			width: 100%;
			&::placeholder {
				color: var(--c-grey-300);
			}

			&:focus {
				border-color: var(--c-grey-300);
				outline: 0; // Don't actually do this
				box-shadow: 0 0 0 4px var(--c-grey-100);
			}
		}
	}

	.timeline-item-icon {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 30px;
		height: 30px;
		margin-left: -48px;
		flex-shrink: 0;
		overflow: hidden;
		/*box-shadow: 0 0 0 6px #fff;*/
		svg {
			width: 20px;
			height: 20px;
		}

		&.faded-icon {
			background-color: #fff;
			color: var(--c-grey-400);
		}

		&.filled-icon {
			background-color: #fff;
			color: #fff;
		}
	}

	.timeline-item-description {
		display: flex;
		padding-top: 6px;
		gap: 8px;
		color: var(--c-grey-400);
		flex-wrap: wrap;
		.delivery-time {
		    width: 100%;
		    background: #dddddd;
		    margin: 0;
		    list-style: none;
		    display: flex;
		    align-items: center;
		    justify-content: space-around;
		    border-radius: 10px;
		    padding: 10px;
		    text-align: center;
		    font-size: 15px;
		}
		img {
			flex-shrink: 0;
		}
		a {
			color: var(--c-grey-500);
			font-weight: 500;
			text-decoration: none;
			&:hover,
			&:focus {
				outline: 0; // Don't actually do this
				color: var(--c-blue-500);
			}
		}
	}

	.avatar {
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		overflow: hidden;
		aspect-ratio: 1 / 1;
		flex-shrink: 0;
		width: 40px;
		height: 40px;
		&.small {
			width: 28px;
			height: 28px;
		}

		img {
			object-fit: cover;
		}
	}

	.comment {
		border: 1px solid #d5d5d5;
		box-shadow: 0 4px 4px 0 #f1f1f1;
		border-radius: 6px;
		padding: 10px;
	}

	.button {
		border: 0;
		padding: 0;
		display: inline-flex;
		vertical-align: middle;
		margin-right: 4px;
		margin-top: 12px;
		align-items: center;
		justify-content: center;
		font-size: 1rem;
		height: 32px;
		padding: 0 8px;
		background-color: var(--c-grey-100);
		flex-shrink: 0;
		cursor: pointer;
		border-radius: 99em;

		&:hover {
			background-color: var(--c-grey-200);
		}

		&.square {
			border-radius: 50%;
			color: var(--c-grey-400);
			width: 32px;
			height: 32px;
			padding: 0;
			svg {
				width: 24px;
				height: 24px;
			}

			&:hover {
				background-color: var(--c-grey-200);
				color: var(--c-grey-500);
			}
		}
	}

	.show-replies {
		color: var(--c-grey-300);
		background-color: transparent;
		border: 0;
		padding: 0;
		margin-top: 16px;
		display: flex;
		align-items: center;
		gap: 6px;
		font-size: 1rem;
		cursor: pointer;
		svg {
			flex-shrink: 0;
			width: 24px;
			height: 24px;
		}

		&:hover,
		&:focus {
			color: var(--c-grey-500);
		}
	}

	.avatar-list {
		display: flex;
		align-items: center;
		& > * {
			position: relative;
			box-shadow: 0 0 0 2px #fff;
			margin-right: -8px;
		}
	}

	.timeline-item-description h5{
		margin-top: 0!important;
		width: 100%;
	}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include 'include/sidebar.php'; ?>				
			</div>
			<div class="col-md-9">
				<div class="mjq-sh">					
					<h4 class="pull-left mr-3 pb-2" style="border-bottom: 1px solid #fe8a0f; color: #fe8a0f;">
						Timeline
					</h4>
					<h4 id="openChat" data-id="<?php echo $service['user_id']?>">Chat</h4>
				</div>
				<div class="tradesmen-box mt-4">
					<div class="tradesmen-top" style="border-bottom:0">
						<div class="pull-left">
							<div class="img-name">
								<a href="<?php echo base_url('service/'.$service['slug']); ?>">
									<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
									<?php if (file_exists($image_path) && $service['image']): ?>
										<img src="<?php echo  base_url().'img/services/'.$service['image']; ?>" style="border-radius: 0!important;">
									<?php else: ?>
										<img src="<?php echo  base_url().'img/default-image.jpg'; ?>" style="border-radius: 0!important;">
									<?php endif; ?>
								</a>
								<div class="names">
									<a href="<?php echo base_url().'service/'.$service['slug']?>">
										<p>
											<?php
												$totalChr = strlen($service['description']);
												if($totalChr > 120 ){
													echo substr($service['description'], 0, 120).'...';		
												}else{
													echo $service['description'];
												}
											?>											
										</p>
										<span class="badge bg-dark p-2 pl-4 pr-4">
											<?php echo ucfirst($order['status']) ?>
										</span>
										<span class="pull-right">
											<?php echo '£'.number_format($order['total_price'],2); ?>
										</span>
									</a>
									
									<a class="text-muted" href="<?php echo base_url('profile/'.$list['user_id']); ?>">
										<?php echo $list['trading_name'];?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="timeline-div bg-white p-4">
					<ol class="timeline">
						<li class="timeline-item">
							<span class="timeline-item-icon | faded-icon">
								<i class="fa fa-clock-o faicon"></i>
							</span>
							<div class="timeline-item-description">
								<h5>Expected delivery <?php echo $delivery_date; ?></h5>						
								<ul class="delivery-time">
									<li><b><?php echo $rDays; ?></b><br/>Days</li>
									<li><b><?php echo $rHours; ?></b><br/>Hours</li>
									<li><b><?php echo $rMinutes; ?></b><br/>Minutes</li>
								</ul>														
							</div>
						</li>
						<li class="timeline-item">
							<span class="timeline-item-icon | faded-icon">
								<i class="fa fa-file-text-o faicon" aria-hidden="true"></i>
							</span>
							<div class="timeline-item-description">
								<h5>Your delivery data was updated to <?php echo $delivery_date; ?></h5>
							</div>
						</li>
						<li class="timeline-item | extra-space">
							<span class="timeline-item-icon | filled-icon ">
								<i class="fa fa-paper-plane faicon" aria-hidden="true"></i>
							</span>
							<div class="timeline-item-wrapper">
								<div class="timeline-item-description">
									<h5>Order Started</h5>
								</div>
							</div>
						</li>
						<li class="timeline-item">
							<span class="timeline-item-icon | faded-icon">
								<i class="fa fa-file-text-o faicon" aria-hidden="true"></i>
							</span>
							<div class="timeline-item-description" style="width:100%">
								<h5 id="order-requirement">
									Order Requirement Submitted
									<i class="fa fa-angle-down pull-right"></i>
								</h5>

								<?php if(!empty($requirements)): ?>
									<div class="comment" id="requirement-div"  style="display:none;">
										<h4 style="margin-top:0px">Order Requirements</h4>
										<p><?php echo $requirements['requirement']; ?></p>

										<?php if(!empty($requirements['location'])):?>
											<h4 style="margin-top:0px">Order Location</h4>
											<p><?php echo $requirements['location']; ?></p>
										<?php endif;?>

										<?php if(!empty($attachements)):?>
											<h4>Order Attachments</h4>
											<div class="row" id="attachments">
												<?php foreach ($attachements as $key => $value): ?>
													<?php $image_path = FCPATH . 'img/services/' . ($value['attachment'] ?? ''); ?>
													<?php if (file_exists($image_path) && $value['attachment']):?>
														<div class="col-md-4 col-sm-6 col-xs-12">
															<div class="boxImage imgUp">
																<div class="imagePreviewPlus">
																	<img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/').$value['attachment']?>" alt="<?php echo $value['id']; ?>">
																</div>
															</div>
														</div>
													<?php endif; ?>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
						<li class="timeline-item | extra-space" style="padding-bottom: 0; border-bottom: 0;">
							<span class="timeline-item-icon | filled-icon ">
								<i class="fa fa-calendar faicon" aria-hidden="true"></i>
							</span>
							<div class="timeline-item-description" style="width:100%">
								<h5 id="order-created">
									Order Created
									<i class="fa fa-angle-down pull-right"></i>
								</h5>
								<div class="comment" id="order-created-div"  style="display:none; width: 100%;">
									<p><?php echo $created_date; ?></p>
								</div>
							</div>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'include/footer.php'; ?>
<script>
$(document).ready(function() {
    $("#order-requirement").click(function() {
        $("#requirement-div").slideToggle(); // Toggle the visibility with sliding effect
        $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
    });

    $("#order-created").click(function() {
        $("#order-created-div").slideToggle(); // Toggle the visibility with sliding effect
        $(this).find("i").toggleClass("fa-angle-down fa-angle-up"); // Toggle the icon class
    });
});

$('#openChat').on('click', function(){
	get_chat_onclick(<?php echo $service['user_id'];?>, <?php echo $service['id'];?>);
	showdiv();
});

</script>