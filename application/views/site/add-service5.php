<style>
	.addFaqs{cursor: pointer;}
</style>
<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
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
							<?php $i= 1;?>
							<?php foreach($serviceData['faqs'] as $key => $faq): ?>
								<div class="row" id="faq<?php echo $i; ?>" style="border:1px solid #b0c0d3; border-radius: 10px; margin: 0; margin-top:10px; margin-bottom:10px;">
									<div class="col-md-12" style="margin-top:10px;">
										<div class="form-group">
											<label class="control-label" for="" style="width:100%">Question <?php echo $i; ?> <span class="btn btn-sm btn-danger pull-right removeFaqs" data-id="<?php echo $i; ?>"><i class="fa fa-trash"></i></span></label>
											<div>
												<textarea class="form-control input-md" name="faq[<?php echo $i; ?>][question]" id="question<?php echo $i; ?>" placeholder="Question" rows="3" required><?php echo $faq['question'] ?? '' ?></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="">Answer <?php echo $i; ?></label>
											<div class="">
												<textarea class="form-control input-md" name="faq[<?php echo $i; ?>][answer]" id="answer<?php echo $i; ?>" placeholder="Answer" rows="3" required><?php echo $faq['answer'] ?? '' ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<?php $i++; ?>
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
			<div class="col-sm-12 serviceBtn">
				<!-- <input type="submit" name="submit_listing" class="btn btn-warning submit_btn mr-3" value="Submit Listing"> -->
				<button type="submit" class="btn btn-warning submit_btn">Save & Continue</button>
			</div>                                 
		</div>
	</div>                        
	<!-- Edit-section-->
</form>

<script>
	var totalFaqs =  <?php echo ($i ?? 0); ?>;
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
		updateFaqIndices();
	});	


	$('#faq-div').on('click', '.removeFaqs', function (event) {
		event.preventDefault();
		var fId = $(this).attr('data-id');
		console.log(fId);
		$('#faq'+fId).remove();
		totalFaqs--;
		updateFaqIndices();
	});

	function updateFaqIndices() {
        $('#faq-div .row').each(function(index) {
            let newIndex = index + 1;
            $(this).attr('data-index', newIndex);
            $(this).find('label.control-label').first().html(`Question ${newIndex} <span class="btn btn-sm btn-danger pull-right removeFaqs" data-id="${newIndex}"><i class="fa fa-trash"></i></span>`);
            $(this).find('textarea[name^="faq"]').first().attr('name', `faq[${newIndex}][question]`);
            $(this).find('textarea[name^="faq"]').last().attr('name', `faq[${newIndex}][answer]`);
            $(this).find('label.control-label').last().text(`Answer ${newIndex}`);
        });
    }
</script>
