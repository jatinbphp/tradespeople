<style>
	#imageContainer{
		border: unset!important;
		padding-left: 15px!important;
	}

	#imageContainer img {
	    border-radius: 5px;
	    width: 30px!important;
	    height: 30px!important;
	}

	.main-label{
		padding-top: 0!important;
		padding-bottom: 10px;
	}
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
	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center; border-radius: 10px;}
	.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
	.imgUp{margin-bottom:15px}
	.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
	.removeVideo {position: absolute; right: -15px; margin-right: 15px; z-index: 999;}
	.removeDoc {position: absolute; top: 0; right: 0; margin-right: 15px;}
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
<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
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
				<div id="image-div" style="margin-top: 10px; border-bottom:1px solid #b0c0d3;">
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Images (up to 3)
					</label>
					<span>
						Get noticed by the right buyer with visual examples of your services.
					</span>

					<div class="row">
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer">
							<div class="file-upload-btn imgUp">
								<div class="btn-text main-label">Main Image</div>
								<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
								<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
								<input type="file" name="image" id="profile" accept="image/*" onchange="return seepreview();">		
							</div>
							<input type="hidden" name="service_image_old" value="<?php echo $serviceData['image'];?>" >
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imgpreview">
							<?php $image_path = FCPATH . 'img/services/' . ($serviceData['image'] ?? ''); ?>
				            <?php if (file_exists($image_path) && $serviceData['image']): ?>
				                <?php
				                $mime_type = get_mime_by_extension($image_path);
				                $is_image = strpos($mime_type, 'image') !== false;
				                $is_video = strpos($mime_type, 'video') !== false;
				                ?>
				                <?php if ($is_image): ?>
				                    <div style="padding-left:15px" id="smImage">
				                        <div class="boxImage imgUp">
				                            <div class="imagePreviewPlus">
				                            	<button type="button" class="btn btn-danger removeImage" style="margin-top:15px;" onclick="removeVideo('image')">
													<i class="fa fa-trash"></i>
												</button>
				                                <img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/') . $serviceData['image']; ?>" alt="Image">
				                            </div>
				                        </div>
				                    </div>
				                <?php elseif ($is_video): ?>
				                    <div style='padding-left:15px'>
				                        <div class="imgUp">
				                            <div class="videoPreviewPlus">
				                                <video 
				                                    src="<?php echo base_url('img/services/') . $serviceData['image']; ?>" 
				                                    type="<?php echo $mime_type; ?>" 
				                                     loop 
				                                    class="serviceVideo">
				                                </video>
					                            <svg id="play-control-btn" class="playing" width="30" height="30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">
					                                <path id="border" fill="none" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" d="M50,2.9L50,2.9C76,2.9,97.1,24,97.1,50v0C97.1,76,76,97.1,50,97.1h0C24,97.1,2.9,76,2.9,50v0C2.9,24,24,2.9,50,2.9z"/>
					                                <path id="bar" fill="none" stroke="#fff" stroke-width="4.5" stroke-miterlimit="10" d="M50,2.9L50,2.9C76,2.9,97.1,24,97.1,50v0C97.1,76,76,97.1,50,97.1h0C24,97.1,2.9,76,2.9,50v0C2.9,24,24,2.9,50,2.9z" style="transition: all .3s;"/>
					                                <g id="pause">
					                                    <g>
					                                        <path fill="#fff" d="M46.1,65.7h-7.3c-0.4,0-0.7-0.3-0.7-0.7V35c0-0.4,0.3-0.7,0.7-0.7h7.3c0.4,0,0.7,0.3,0.7,0.7V65 C46.8,65.4,46.5,65.7,46.1,65.7z"/>
					                                        <path fill="#fff" d="M61.2,65.7h-7.3c-0.4,0-0.7-0.3-0.7-0.7V35c0-0.4,0.3-0.7,0.7-0.7h7.3c0.4,0,0.7,0.3,0.7,0.7V65 C61.9,65.4,61.6,65.7,61.2,65.7z"/>
					                                    </g>
					                                </g>
					                                <g id="play">
					                                    <path fill="#fff" d="M41.1,33.6l24.5,15.6c0.6,0.4,0.6,1.1,0,1.5L41.1,66.4c-0.7,0.5-1.8,0-1.8-0.7V34.4 C39.3,33.6,40.4,33.2,41.1,33.6z"/>
					                                </g>
					                            </svg>
				                        	</div>
				                   		</div>
				                	</div>
				    			<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div id="loader1" class="loader_ajax_small"></div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer2">
							<div class="file-upload-btn addWorkImage imgUp">
								<div class="btn-text main-label">Additional Image</div>
								<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
								<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
								<input type="file" name="workImage" id="profile2">		
							</div>
						</div>
					</div>					

					<input type="hidden" name="multiImgIds" id="multiImgIds">
					<div class="row pb-4" id="previousImg">
						<?php if(isset($serviceData['multi_images']) && $serviceData['multi_images']): ?>
							<?php foreach($serviceData['multi_images'] as $id => $image): ?>
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
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				
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
					<div id="loader3" class="loader_ajax_small"></div>
					<div id="videoPreview" style="position:relative; width: fit-content;">
						<?php if(isset($serviceData['video']) && $serviceData['video']): ?>
							<?php $video_path = FCPATH . 'img/services/' . ($serviceData['video'] ?? ''); ?>
							<?php if(file_exists($video_path) && $video_path): ?>
								<button type="button" class="btn btn-danger removeVideo" onclick="removeVideo('video')">
									<i class="fa fa-trash"></i>
								</button>
								<video src="<?php echo base_url().'img/services/'.$serviceData['video']; ?>" controls style="width:162px;"></video>
							<?php endif; ?>	
						<?php endif; ?>	
					</div>
				</div>
				
				<div id="doc-div" style="border-bottom:1px solid #b0c0d3; margin-top: 10px;">
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Documents (up to 2)
					</label>
					<span>
						Show some of the best work you created in a document (PDFs only)
					</span>

					<div class="row ">
						<div id="loader2" class="loader_ajax_small"></div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd " id="imageContainer3">
							<div class="file-upload-btn addWorkDoc imgUp">
								<img src="<?php echo base_url()?>img/defaultDoc.png" id="defaultDoc">
								<div class="btn-text">Drag & drop PDF or <span>Browser</span></div>
								<input type="file" name="workDoc" id="profile3" accept="application/pdf">		
							</div>
						</div>
					</div>
					<input type="hidden" name="multiDocIds" id="multiDocIds">
					<div class="row pb-4" id="previousDoc">
						<?php if(isset($serviceData['multi_files']) && $serviceData['multi_files']): ?>
							<?php foreach($serviceData['multi_files'] as $id => $file): ?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="portDiv<?php echo $id; ?>">
									<div class="boxImage imgUp">
										<div class="imagePreviewPlus">
											<div class="text-right">
												<button type="button" class="btn btn-danger removeDoc" onclick="removeImage('<?php echo $id; ?>',2)"><i class="fa fa-trash"></i></button>
											</div>
											<img style="width: inherit; height: inherit;" src="<?php echo base_url()?>img/defaultDoc.png" alt="PDF">
										</div>
									</div>
								</div>
							<?php endforeach ?>
						<?php endif; ?>
					</div>
				</div>

				<div id="portfolio-div" style="margin-top: 10px;">
					<label class="col-md-12 control-label" for="" style="padding: 0;">
						Poortfolio
					</label>
					<div class="row">
						<div id="loader4" class="loader_ajax_small"></div>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageContainer4">
							<div class="file-upload-btn addWorkPImage imgUp">
								<div class="btn-text main-label">Portfolio Image</div>
								<img src="<?php echo base_url()?>img/dImg.png" id="defaultImg">
								<div class="btn-text">Drag & drop Photo or <span>Browser</span></div>
								<input type="file" name="portfolioImage" id="profile4">		
							</div>
						</div>
					</div>					

					<input type="hidden" name="multiPortImgIds" id="multiPortImgIds">
					<div class="row" id="previousPortImg">
						<?php if(!empty($portfolio)): ?>
							<?php foreach($portfolio as $pid => $img): ?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pb-4" id="portImageDiv<?php echo $img['id']; ?>">
									<div class="boxImage imgUp">
										<div class="imagePreviewPlus">
											<div class="text-right">
												<button type="button" class="btn btn-danger removeImage" onclick="removePortfolioImage('<?php echo $img['id']; ?>', 1)">
													<i class="fa fa-trash"></i>
												</button>
											</div>
											<img style="width: inherit; height: inherit;" src="<?php echo base_url().'img/profile/'.$img['port_image'];?>" alt="">
										</div>
									</div>
								</div>		
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>														
		</div>																
	</div>
	<div class="edit-user-section gray-bg">
		<div class="row nomargin">
			<div class="col-sm-12 serviceBtn">
				<!-- <input type="submit" name="submit_listing" class="btn btn-warning submit_btn mr-3" value="Submit Listing"> -->
				<button type="submit" class="btn btn-warning submit_btn">Save & Continue</button>
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

	document.getElementById('imageContainer4').addEventListener('click', function() {
		document.getElementById('profile4').click();
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

	function seeVideoPreview() {
	    $('#loader3').show();
	    var fileUploads = $("#videoprofile")[0];
	    var file = fileUploads.files[0];

	    // Check if a file is selected
	    if (file) {
	        // Check if the file size is greater than 60MB
	        var fileSizeInMB = file.size / (1024 * 1024);
	        if (fileSizeInMB > 60) {
	            $('#loader3').hide();
	            alert("File size exceeds 60MB. Please upload a smaller video file.");
	            return;
	        }

	        // Check if the file is a video
	        if (file.type.startsWith('video/')) {
	            var reader = new FileReader();
	            reader.readAsDataURL(file);
	            reader.onload = function (e) {
	                var video = document.createElement('video');
	                video.src = e.target.result;
	                video.onloadedmetadata = function () {
	                    $('#loader3').hide();
	                    var height = this.videoHeight;
	                    var width = this.videoWidth;
	                    $('#videoPreview').html('<video src="' + video.src + '" controls style="width:162px; height:113px;"></video>'); 
	                };
	            };
	        } else {
	            $('#loader3').hide();
	            alert("Please upload a valid video file.");
	        }
	    } else {
	        $('#loader3').hide();
	        alert("No file selected. Please select a video file.");
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
        if (validImageTypes.indexOf(file_data.type) == -1) {
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
						'<img style="width: inherit; height: inherit;" src="<?php echo site_url('img/defaultDoc.png'); ?>" alt="'+response.id+'">'
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

	function removeVideo(type){
		var sId = <?php echo isset($serviceData['id']) ? $serviceData['id'] : 0; ?>;
		$.ajax({
			url:site_url+'users/removeServiceVideo',
			type:"POST",
			data:{'sId':sId,'type':type},
			success:function(data){
				if(type == 'video'){
					$('#videoPreview').remove();
					alert('video deleted successfully');	
				}
				if(type == 'image'){
					$('#smImage').remove();
					alert('main image deleted successfully');	
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

    const portDropArea = document.querySelector(".addWorkPImage"),
		port_button = portDropArea.querySelector("img"),
		port_input = portDropArea.querySelector("input");
	let file2;
	var filename2;

	port_button.onclick = () => {port_input.click();};

	port_input.addEventListener("change", function (e) {
		e.preventDefault();
		var multiPImgIds = $('#multiPortImgIds').val();

		var idsArray = multiPImgIds.split(',');
    	var file_data = $('#profile4').prop('files')[0];

		var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", "image/webp"];
        if (validImageTypes.indexOf(file_data.type) == -1) {
            alert("Please upload a valid image file (GIF, JPEG, JPG, PNG, or WEBP).");
            return false;
        }
		
		var form_data = new FormData();
		form_data.append('file', file_data);	
		$('#loader4').show();
		$('#previousPortImg').css('opacity', '0.6');
		$.ajax({
			url:site_url+'users/dragDrop',
			type: "POST",
			data: form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType:'json',
			success: function(response){
				if(response.status == 1){
					if(multiPImgIds != ""){
						var ids = multiPImgIds+','+response.id;
						$('#multiPortImgIds').val(ids);
					}else{
						$('#multiPortImgIds').val(response.id);
					}

					var portElement = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pb-4" id="portImageDiv'+response.id+'">' +
						'<div class="boxImage imgUp">'+
						'<div class="imagePreviewPlus">'+
						'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removePortfolioImage('+response.id+')"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
						'</div></div></div>';
					$('#previousPortImg').append(portElement);
					$('#loader4').hide();
					$('#previousPortImg').css('opacity', '1');
				}
			}
		});
	});

	function removePortfolioImage(pImgId){
		$.ajax({
			url:site_url+'users/removePortfolio',
			type:"POST",
			data:{'pImgId':pImgId},
			success:function(data){
				$('#portImageDiv'+pImgId).remove();
				removeIdFromHiddenField(pImgId.toString(), 'multiPortImgIds');					
				alert('image deleted successfully');
			}
		});
	}
</script>
