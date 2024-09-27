<?php include ("include/header.php") ?>
<style>
	.payment_method{
		margin-right: 10px!important;
	}

	/*----------LOADER CSS START----------*/
	.loader_ajax_small {
		display: none;
		border: 2px solid #f3f3f3 !important;
		border-radius: 50%;
		border-top: 2px solid #2D2D2D !important;
		width: 29px;
		height: 29px;
		margin: 0 auto;
		-webkit-animation: spin_loader_ajax_small 2s linear infinite;
		animation: spin_loader_ajax_small 2s linear infinite;
	}

	@-webkit-keyframes spin_loader_ajax_small {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin_loader_ajax_small {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	/*----------LOADER CSS END----------*/

	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
	.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
	.imgUp{margin-bottom:15px}
	.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
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
</style>
<div class="loader-bg hide" id='loader'>
	<span class="loader"></span>
</div>
<div class="checkout-page">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="thank-purchase-msg alert alert-success">
					<span class="icon">
						<i class="fa fa-check" aria-hidden="true"></i>
					</span>
					<div>
						<h2>Thank You for your Purchase</h2>
						<p><b>A recept wes sent to your email address</b></p>
					</div>
					<!-- <button type="button" class="btn-close" aria-label="Close">&times;</button> -->
				</div>
			</div>

			<div class="col-sm-8 checkout-form">
				<div class="submit-requirements">
					<h4 class="submit-title">Submit Requirements to Start Your Order</h4>
					<div class="p-4">
						<h4>The tradesman needs the following information to start working on your order:</h4>
						<form method="post" id="order_requirement_form" enctype="multipart/form-data">
							<div class="form-group">
								<label for="requirement"> What do you need for this order?</label>
								<textarea rows="5" placeholder="" name="requirement" id="requirement" class="form-control"></textarea>
							</div>
							<!-- <div class="form-group">
								<label for="location"> Where is task located?</label>
								<textarea rows="5" placeholder="" name="location" id="location" class="form-control"></textarea>
							</div> -->

							<div class="row">
								<div id="loader1" class="loader_ajax_small"></div>
								<div class="col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer2">
									<div class="file-upload-btn addWorkImage imgUp">
										<div class="btn-text main-label">Attachments</div>
										<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
										<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
										<input type="file" name="attachments" id="attachments">		
									</div>
								</div>
							</div>
							<input type="hidden" name="multiImgIds" id="multiImgIds">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>" id="order_id">
							<div class="row" id="previousImg">
							</div>

							<!--<div class="form-group mt-3">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-check" id="term-chk">
											<div class="check-box">
												<input class="checkbox-effect" id="terms" type="checkbox" value="1" name="terms"/>
												<label for="terms">By clicking at the button you agreed to our<a href="<?php //echo base_url('terms-and-conditions'); ?>" target="_blank" class="ml-1">terms & conditions</a>.</label>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<div class="btn-group-div">
								<p><a href="<?php echo base_url('order-tracking/'.$order['id']); ?>">Remind Me Latter</a></p>
								<button class="btn btn-success btn-lg sendbtn1" type="submit">Start Order</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="box-border p-4 submit-requirements-sidebar">

					<?php $image_path = FCPATH . 'img/services/' . ($service['image'] ?? ''); ?>
					<?php if (file_exists($image_path) && $service['image']): ?>
						<img src="<?php echo base_url('img/services/') . $service['image']; ?>" class="img-responsive">
					<?php else: ?>	
						<img src="<?php echo base_url('img/default-image.jpg'); ?>" class="img-responsive">
					<?php endif; ?>

					<h3 style="margin-top: 10px; font-weight: bold;"><?php echo $service['service_name'];?></h3>
					<?php if(!empty($ex_services)): ?>
						<h5 class="mt-3"><b>Extra Services</b></h5>
						<ul class="fix-block-website">
							<?php foreach($ex_services as $exs): ?>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i> 
									<?php echo $exs['ex_service_name']; ?>
								</li>
							<?php endforeach; ?>	
						</ul>
					<?php endif; ?>

					<ul class="status-order" style="border-bottom: 1px solid #efeff0;">
						<li><span>Status</span> <span class="bg-warning"><?php echo ucfirst($order['status'])?></span></li>
						<li><span>Order</span> <span><?php echo ucfirst($order['order_id'])?></span></li>
						<li><span>Order Date</span> <span><?php echo $created_date; ?></span></li>
						<li><span>Quantity</span> <span><?php echo $order['service_qty']; ?></span></li>
						<li><span>Price</span> <span><?php echo '£'.number_format($order['total_price'],2); ?></span></li>
					</ul>
					<?php if(!empty($taskAddress)):?>
						<h5 class="mt-3"><b>Task Address</b></h5>
						<span><?php echo $taskAddress['address']; ?></span></li>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>
<script>
	$(document).ready(function(){
        $("#order_requirement_form").validate({
            rules: {
                requirement: "required",
                //location: "required",                
               //terms: "required",                
            },
            messages: {
                requirement: "Please enter requirement for your order",
                //location: "Please enter location for your order",
                //terms: "Please select Terms & Conditions!!!",
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "terms") {
                    error.insertAfter("#term-chk");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
	            submitRequirement();
	        }
        });     
    });


	document.getElementById('imageContainer2').addEventListener('click', function() {
		document.getElementById('attachments').click();
	});

	/*Start Code For Submit Requirement */
	const dropArea = document.querySelector(".addWorkImage"),
		button = dropArea.querySelector("img"),
		input = dropArea.querySelector("input");
	let file;
	var filename;

	button.onclick = () => {input.click();};

	input.addEventListener("change", function (e) {
		e.preventDefault();
		var multiImgIds = $('#multiImgIds').val();    	
		var file_data = $('#attachments').prop('files')[0];

		var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp"];
        if (validImageTypes.indexOf(file_data.type) == -1) {
            alert("Please upload a valid image file (GIF, JPEG, JPG, PNG, or WEBP).");
            return false;
        }

		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('requirement_id', 0);
		$('#loader1').show();
		$('#previousImg').css('opacity', '0.6');
		$.ajax({
			url:site_url+'users/dragDropRequirementAttachment',
			type: "POST",
			data: form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType:'json',
			success: function(response){
				if(response.status == 1){
					if(multiImgIds != ""){
						var ids = multiImgIds+','+response.id;
						$('#multiImgIds').val(ids);
					}else{
						$('#multiImgIds').val(response.id);
					}
					var portElement = '<div class="col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
						'<div class="boxImage imgUp">'+
						'<div class="imagePreviewPlus">'+
						'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage('+response.id+', 1)"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
						'</div></div></div>';
					$('#previousImg').append(portElement);
					$('#loader1').hide();
					$('#previousImg').css('opacity', '1');
				}
			}
		});
	});

	function removeImage(imgId, type){
		$.ajax({
			url:site_url+'users/removeAttachment',
			type:"POST",
			data:{'imgId':imgId},
			success:function(data){
				$('#portDiv'+imgId).remove();
				removeIdFromHiddenField(imgId.toString(), 'multiImgIds');
				alert('Attachment deleted successfully');				
			}
		});
	}

	function removeIdFromHiddenField(idToRemove, divId) {
        var hiddenFieldValue = $('#'+divId).val();
        var idsArray = hiddenFieldValue.split(',');
        var newIdsArray = idsArray.filter(function(id) {
            return id !== idToRemove.toString();
        });
        var newHiddenFieldValue = newIdsArray.join(',');
        $('#'+divId).val(newHiddenFieldValue);        
    }

    function submitRequirement(){
    	/*var termsConditions = $('input[name="terms"]:checked').val();

		if(termsConditions == undefined){
			swal({
				title: "Error",
				text: "Please select Terms & Conditions!!!",
				type: "error"
			});	

			return false
		}*/

		$('#loader').removeClass('hide');
        formData = $("#order_requirement_form").serialize();

        $.ajax({
            url: '<?= site_url().'users/submitRequirement'; ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',		                
            success: function(result) {
            	console.log(result);
            	$('#loader').addClass('hide');
            	if(result.status == 0){
            		swal({
		            	title: "Error",
			            text: result.message,
			            type: "error"
			        }, function() {
			        	window.location.reload();
			        });	
            	}else if(result.status == 2){
            		swal({
			            title: "Login Required!",
			            text: "If you want to order the please login first!",
			            type: "warning"
			        }, function() {
			            window.location.href = '<?php echo base_url().'login'; ?>';
			        });	
            	}else{
					/*swal({
			            title: "Success",
			            text: result.message,
			            type: "success"
			        }, function() {
			        	window.location.href = '<?php echo base_url('order-tracking/'.$order['id']); ?>';
			        });*/
			        window.location.href = '<?php echo base_url('order-tracking/'.$order['id']); ?>';
            	}		                    
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });
	}

	/*End Code For Submit Requirement */
</script>