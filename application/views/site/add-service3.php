
<form action="<?= site_url().'users/storeServices3'; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="msg"><?= $this->session->flashdata('msg');?></div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">
						What does the offer include?
					</label>
					<div class="col-md-12">
						<?php if(!empty($ex_service)):?>
							<div class="row">
								<?php
									$exServices = $serviceData['extra_service'] ?? '';
									$selectedExServices = explode(',', $exServices);
								?>
								<?php foreach($ex_service as $list):?>
									<div class="col-sm-12">
										<div class="form-group">
											<div class="form-check" style="margin: 0;">
												<input class="form-check-input" <?php echo in_array($list['id'], $selectedExServices) ? 'checked' : ''; ?> type="checkbox" name="extra_service[]" value="<?php echo $list['id']?>" style="margin-right:10px;">
												<label class="form-check-label" style="margin-top:10px; font-weight: normal;"><?php echo $list['ex_service_name']?></label>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>														
		</div>																
	</div>	
	<div class="edit-user-section gray-bg">
		<div class="row nomargin">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary submit_btn">Continue</button>
			</div>                                 
		</div>
	</div>                        
</form>
