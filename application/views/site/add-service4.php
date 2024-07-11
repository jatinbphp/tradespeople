<style>
	.tox-toolbar__primary, .tox-editor-header{
		display:none !important;
	}
	#videoprofile {
		display: none;
	}
	#imageContainer1 {
		cursor: pointer;
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

	#serviceImage{display: none;}
	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center}
	.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
	.imgUp{margin-bottom:15px}
	.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
	.removeDoc {position: absolute; top: 0; right: 0; margin-right: 15px;}
	.boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;}
	.boxImage img { height: 100%;object-fit: contain;}
</style>
<form action="<?= site_url().'users/storeServices4'; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="msg"><?= $this->session->flashdata('msg');?></div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="text-info">
					Show case your service in a service gallery
				</h4>
				<span>
					Encourage buyer to choose your service by featuring a variety of your work.
				</span>
				<hr>
				<div class="" id="video-div" style="border-bottom:1px solid #b0c0d3;">
					<h4>
						Get image guidelines
					</h4>
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Video (one only)
					</label>
					<span>
						Capture buyer attention with a video that showcase your service. Please choose a video shorter than 75 seconds and smaller than 60MB.
					</span>

					<div id="imageContainer1" class="file-upload-btn imgUp">
						<img src="<?php echo base_url()?>img/upload-video.png" alt="Click to select image">
						<div class="btn-text">Drag & drop video or <span>Browser</span></div>
						<input type="file" name="video" id="videoprofile" class="form-control input-md" accept="video/*" onchange="return seeVideoPreview();">
					</div>
					<div id="videoPreview">
						<?php if(isset($serviceData['video']) && $serviceData['video']): ?>
							<?php $video_path = FCPATH . 'img/services/' . ($serviceData['video'] ?? ''); ?>
							<?php if(file_exists($video_path) && $video_path): ?>
								<video src="<?php echo base_url().'img/services/'.$serviceData['video']; ?>" controls style="width:162px; height:113px;"></video>
							<?php endif; ?>	
						<?php endif; ?>	
					</div>
				</div>
				
				<div id="image-div" style="margin-top: 10px; border-bottom:1px solid #b0c0d3;">
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Images (up to 3)
					</label>
					<span>
						Get noticed by the right buyer with visual examples of your services.
					</span>

					<div class="row loader">
						<div id="loader1" class="loader_ajax_small"></div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer2">
							<div class="file-upload-btn addWorkImage imgUp">
								<img src="img/dImg.png" id="defaultImg">
								<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
								<input type="file" name="workImage" id="profile2">		
							</div>
						</div>
					</div>
					<input type="hidden" name="multiImgIds" id="multiImgIds">
					<div class="row" id="previousImg">
						<?php if(isset($serviceData['multi_images']) && $serviceData['multi_images']): ?>
							<?php foreach($serviceData['multi_images'] as $id => $image): ?>
								<?php if(file_exists($image) && $image): ?>
									<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv<?php echo $id; ?>">
										<div class="boxImage imgUp">
											<div class="imagePreviewPlus">
												<div class="text-right">
													<button type="button" class="btn btn-danger removeImage" onclick="removeImage('<?php echo $id ?>', 1)">
														<i class="fa fa-trash"></i>
													</button>
												</div>
												<img style="width: inherit; height: inherit;" src="<?php echo $image ?>" alt="Image">
											</div>
										</div>
									</div>
								<?php endif; ?>			
							<?php endforeach ?>
						<?php endif; ?>
					</div>
				</div>
				
				<div id="doc-div" style="margin-top: 10px;">
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Documents (up to 2)
					</label>
					<span>
						Show some of the best work you created in a document (PDFs only)
					</span>

					<div class="row loader">
						<div id="loader2" class="loader_ajax_small"></div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer3">
							<div class="file-upload-btn addWorkDoc imgUp">
								<img src="img/defaultDoc.png" id="defaultDoc">
								<div class="btn-text">Drag & drop PDF or <span>Browser</span></div>
								<input type="file" name="workDoc" id="profile3" accept="application/pdf">		
							</div>
						</div>
					</div>
					<input type="hidden" name="multiDocIds" id="multiDocIds">
					<div class="row" id="previousDoc">
						<?php if(isset($serviceData['multi_files']) && $serviceData['multi_files']): ?>
							<?php foreach($serviceData['multi_files'] as $id => $file): ?>
								<?php if(file_exists($file) && $file): ?>
									<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv<?php echo $id; ?>">
										<div class="boxImage imgUp">
											<div class="imagePreviewPlus">
												<div class="text-right">
													<button type="button" class="btn btn-danger removeDoc" onclick="removeImage('<?php echo $id; ?>',2)"><i class="fa fa-trash"></i></button>
												</div>
												<img style="width: inherit; height: inherit;" src="img/defaultDoc.png" alt="PDF">
											</div>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach ?>
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

<!--****************FILE UPLOAD FUNCTION CODE START****************-->
<script>
	document.getElementById('imageContainer1').addEventListener('click', function() {
		document.getElementById('videoprofile').click();
	});

	document.getElementById('imageContainer2').addEventListener('click', function() {
		document.getElementById('profile2').click();
	});

	document.getElementById('imageContainer3').addEventListener('click', function() {
		document.getElementById('profile3').click();
	});

	document.getElementById('videoprofile').addEventListener('change', function(e) {
		var file = e.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			//$('#imageContainer1').html('<img src="'+e.target.result+'" style="width:160px!important; height:122px!important;">'); 
			//var image = document.querySelector('#imageContainer1 img');
			//image.src = e.target.result;
		};

		reader.readAsDataURL(file);
	});

	function seeVideoPreview(){
		var fileUploads = $("#videoprofile")[0];
	    var file = fileUploads.files[0];
	    
	    // Check if the file is a video
	    if (file && file.type.startsWith('video/')) {
	        var reader = new FileReader();
	        reader.readAsDataURL(file);
	        reader.onload = function (e) {
	            var video = document.createElement('video');
	            video.src = e.target.result;
	            video.onloadedmetadata = function () {
	            	var height = this.videoHeight;
	                var width = this.videoWidth;
	                $('#videoPreview').html('<video src="' + video.src + '" controls style="width:162px; height:113px;"></video>'); 
	            }
	        }
	    } else {
	        alert("Please upload a valid video file.");
	    }     
	} 

	const dropArea = document.querySelector(".addWorkImage"),
		button = dropArea.querySelector("img"),
		input = dropArea.querySelector("input");
	let file;
	var filename;

	button.onclick = () => {input.click();};

	input.addEventListener("change", function (e) {
		e.preventDefault();
		var multiImgIds = $('#multiImgIds').val();

		var idsArray = multiImgIds.split(',');
    	var totalCount = idsArray.length;

    	if(totalCount >= 3){
    		alert("Up to 3 images can be uploaded for your service.");
    		return false;
    	}

		var file_data = $('#profile2').prop('files')[0];

		var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp"];
        if (validImageTypes.indexOf(file_data.type) === -1) {
            alert("Please upload a valid image file (GIF, JPEG, JPG, PNG, or WEBP).");
            return false;
        }

		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('service_id', 0);
		form_data.append('type', 'image');
		$('#loader1').show();
		$('#previousImg').css('opacity', '0.6');
		$.ajax({
			url:site_url+'users/dragDropService',
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
					var portElement = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
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

	const dropArea1 = document.querySelector(".addWorkDoc"),
		button1 = dropArea1.querySelector("img"),
		input1 = dropArea1.querySelector("input");
	let file1;
	var filename1;

	button1.onclick = () => {input1.click();};

	input1.addEventListener("change", function (e) {
		e.preventDefault();
		var multiDocIds = $('#multiDocIds').val();

		var idsArray = multiDocIds.split(',');
    	var totalCount = idsArray.length;

    	if(totalCount >= 2){
    		alert("Up to 2 PDFs can be uploaded for your service.");
    		return false;
    	}
		var file_data = $('#profile3').prop('files')[0];

		var validFileTypes = ["application/pdf"];
		if (validFileTypes.indexOf(file_data.type) === -1) {
			alert("Please upload a valid PDF file.");
			return false;
		}
		
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('service_id', 0);
		form_data.append('type', 'file');
		$('#loader2').show();
		$('#previousDoc').css('opacity', '0.6');
		$.ajax({
			url:site_url+'users/dragDropService',
			type: "POST",
			data: form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType:'json',
			success: function(response){
				if(response.status == 1){
					if(multiDocIds != ""){
						var ids = multiDocIds+','+response.id;
						$('#multiDocIds').val(ids);
					}else{
						$('#multiDocIds').val(response.id);
					}
					var portElement = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv'+response.id+'">' +
						'<div class="boxImage imgUp">'+
						'<div class="imagePreviewPlus">'+
						'<div class="text-right"><button type="button" class="btn btn-danger removeDoc" onclick="removeImage('+response.id+',2)"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="img/defaultDoc.png" alt="'+response.id+'">'+
						'</div></div></div>';
					$('#previousDoc').append(portElement);
					$('#loader2').hide();
					$('#previousDoc').css('opacity', '1');
				}
			}
		});
	});

	function removeImage(imgId, type){
		$.ajax({
			url:site_url+'users/removeServiceImage',
			type:"POST",
			data:{'imgId':imgId},
			success:function(data){
				$('#portDiv'+imgId).remove();
				if(type == 1){
					removeIdFromHiddenField(imgId.toString(), 'multiImgIds');
					alert('image deleted successfully');
				}else{
					removeIdFromHiddenField(imgId.toString(), 'multiDocIds');
					alert('document deleted successfully');
				}				
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
</script>
