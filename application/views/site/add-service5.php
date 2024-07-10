<style>
	.addFaqs{cursor: pointer;}
</style>
<form action="<?= site_url().'users/storeServices5'; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="msg"><?= $this->session->flashdata('msg');?></div>
		<div class="row">
			<div class="col-sm-12" style="border-bottom:1px solid #b0c0d3;">
				<h4 class="text-info">
					Frequently asked questions
					<span class="pull-right addFaqs"><i class="fa fa-plus" style="font-size:12px;"></i> Add FAQ</span>
				</h4>																	
			</div>	
			<div class="col-sm-12" style="margin-top:10px;">
				<span>Add questions & answers for your Buyers.</span>
				<div id="faq-div" style="margin-top:10px">
						<?php if(isset($serviceData['faqs']) && $serviceData['faqs']): ?>
							<?php foreach($serviceData['faqs'] as $key => $faq): ?>
								<div class="row" id="faq<?php echo $key; ?>" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">
									<div class="col-md-12" style="margin-top:10px;">
										<div class="form-group">
											<label class="control-label" for="" style="width:100%">Question <?php echo $key + 1; ?> <span class="btn btn-sm btn-danger pull-right removeFaqs" data-id="<?php echo $key; ?>"><i class="fa fa-trash"></i></span></label>
											<div>
												<textarea class="form-control input-md" name="faq[<?php echo $key; ?>][question]" id="question<?php echo $key; ?>" placeholder="Question" rows="3" required><?php echo $faq['question'] ?? '' ?></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="">Answer <?php echo $key + 1; ?></label>
											<div class="">
												<textarea class="form-control input-md" name="faq[<?php echo $key; ?>][answer]" id="answer<?php echo $key; ?>" placeholder="Answer" rows="3" required><?php echo $faq['answer'] ?? '' ?></textarea>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach ?>
						<?php endif; ?>
				</div>
				<span class="text-info addFaqs"><i class="fa fa-plus" style="font-size:12px;"></i> Add FAQ</span>
			</div>												
		</div>																
	</div>                        
	<!-- Edit-section-->
		
	<div class="edit-user-section gray-bg">
		<div class="row nomargin">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary submit_btn">Continue</button>
			</div>                                 
		</div>
	</div>                        
	<!-- Edit-section-->
</form>

<script>
	var totalFaqs = 0;
	$('.addFaqs').on('click', function(){
		totalFaqs++;
		var html = '<div class="row" id="faq'+totalFaqs+'" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">'+
					'<div class="col-md-12" style="margin-top:10px;">'+
						'<div class="form-group">'+
							'<label class="control-label" for="" style="width:100%">Question '+totalFaqs+' <span class="btn btn-sm btn-danger pull-right removeFaqs" data-id="'+totalFaqs+'"><i class="fa fa-trash"></i></span></label>'+
							'<div>'+
								'<textarea class="form-control input-md" name="faq['+totalFaqs+'][question]" id="question'+totalFaqs+'" placeholder="Question" rows="3" required></textarea>'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-12">'+
						'<div class="form-group">'+
							'<label class="control-label" for="">Answer '+totalFaqs+'</label>'+
							'<div class="">'+
								'<textarea class="form-control input-md" name="faq['+totalFaqs+'][answer]" id="answer'+totalFaqs+'" placeholder="Answer" rows="3" required></textarea>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';

		$('#faq-div').append(html);
	});	


	$('#faq-div').on('click', '.removeFaqs', function (event) {
		event.preventDefault();
		var fId = $(this).attr('data-id');
		console.log(fId);
		$('#faq'+fId).remove();
		totalFaqs--;
	});
</script>
