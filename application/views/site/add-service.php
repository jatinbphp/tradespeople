<?php include 'include/header.php'; ?>
<style>
	.tox-toolbar__primary, .tox-editor-header{
		display:none !important;
	}
	#profile {
		display: none;
	}
	#imageContainer {
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
	.imagePreviewPlus{width:100%;height:134px;background-position:center center;background-color:#F1F2F6;background-size:cover;background-repeat:no-repeat;display:inline-block;box-shadow:0 -3px 6px 2px rgba(0,0,0,0.2);display:flex;align-content:center;justify-content:center;align-items:center}
	.btn-primary{display:block;border-radius:0;box-shadow:0 4px 6px 2px rgba(0,0,0,0.2);margin-top:-5px}
	.imgUp{margin-bottom:15px}
	.removeImage {position: absolute; top: 0; right: 0; margin-right: 15px;}
	.boxImage { height: 100%;}
	.boxImage img { height: 100%;object-fit: contain;}
</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="user-setting">
			<div class="row">
				<div class="col-sm-3">
					<?php include 'include/sidebar.php'; ?>
				</div>
				<div class="col-sm-9">
					<div class="user-right-side">
						<h1>Edit Service</h1> 
						<form action="<?= site_url().'users/storeServices'; ?>" id="update_service" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="form-group"> <label
										class="col-md-12 control-label"
										for="">Service Name*</label>  <div
										class="col-md-12"> <input
										id="service" name="service_name"
										placeholder="Service Name"
										class="form-control input-md" type="text" value="" required>
                                        
											</div>
										</div>
									</div>									
									<div class="col-sm-12">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Category*</label>  
											<div class="col-md-12">
												<select class="form-control input-md" name="category" id="category" required>
													<option value="">Please select</option>
													<?php 
														foreach($category as $list){		
													?>
														<option value="<?php echo $list['cat_id']; ?>">
															<?php echo $list['path']?>
														</option>
													<?php		
														}
													?>
												</select>
											</div>
										</div>
									</div>
																			
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Image*</label>
											<div class="col-md-12">
												<div id="imageContainer">
													<img src="<?php echo base_url()?>img/upImage.png" alt="Click to select image" width="200" height="217">
													<input type="file" name="image" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();">
												</div>

												<input type="hidden" name="service_image_old" value="" >
											</div>
										</div>
									</div>

									<div class="col-md-9">
										<div class="form-group">
											<label class="col-md-12 control-label" for="">
												About Your Service 
											</label>
											<div class="col-md-12">
												<textarea class="form-control input-md" name="description" id="description" rows="10"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Price*</label>  
											<div class="col-md-12">
												<input id="price" name="price" placeholder="Price" class="form-control input-md" type="text" value="" required>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-12 control-label" for="">Status*</label>  
											<div class="col-md-12">
												<select class="form-control input-md" name="status" id="status" required>
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>                        
							<!-- Edit-section-->

							<!-- Edit-section--> 
							<div class="edit-user-section">
								<div class="col-md-12">
									<h2>Add Multiple Images</h2>
									<input type="hidden" name="multiImgIds" id="multiImgIds">
									<div class="row loader">
										<div class="loader_ajax_small"></div>
										<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 imgAdd" id="imageAdd">
											<div class="addWorkImage imagePreviewPlus imgUp">
												<input type="file" name="serviceImage" id="serviceImage">
												<img src="<?php echo base_url()?>img/upImage.png" id="defaultImg">
											</div>
										</div>
										<div id="previousImg"></div>
									</div>
								</div>
							</div>                        
							<!-- Edit-section-->
							  
							<div class="edit-user-section gray-bg">
								<div class="row nomargin">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary submit_btn">Save</button>
									</div>                                 
								</div>
							</div>                        
							<!-- Edit-section-->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script type="text/javascript">	
  	document.getElementById('imageContainer').addEventListener('click', function() {
		document.getElementById('profile').click();
	});

	document.getElementById('profile').addEventListener('change', function(e) {
		var file = e.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			var image = document.querySelector('#imageContainer img');
			image.src = e.target.result;
		};

		reader.readAsDataURL(file);
	});

</script>
<script>
  	init_tinymce();
  	function init_tinymce(){
	    tinymce.init({
	      selector: '.textarea',
	      height:250,
	      menubar: false,
	      branding: false,
	      statusbar: false,
	      plugins: [ 
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table paste"
	      ],
	      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	      setup: function (editor) {
	        editor.on('change', function () {
	          tinymce.triggerSave();
	        });
	      }
	    });
  	}

	function seepreview(){
	  var fileUploads = $("#profile")[0];
	  var reader = new FileReader();
	  reader.readAsDataURL(fileUploads.files[0]);
	  reader.onload = function (e) {
	    var image = new Image();
	    image.src = e.target.result;
	    image.onload = function () {
	      var height = this.height;
	      var width = this.width;
	      $('#imgpreview').html('<img src="'+image.src+'"  width="100px" height="100px">'); 
	    }
	  }     
	} 
</script>
<?php include 'include/footer.php'; ?>

<!--****************FILE UPLOAD FUNCTION CODE START****************-->
<script>
	const dropArea = document.querySelector(".addWorkImage"),
		button = dropArea.querySelector("img"),
		input = dropArea.querySelector("input");
	let file;
	var filename;

	button.onclick = () => {input.click();};

	input.addEventListener("change", function (e) {
		e.preventDefault();
		var multiImgIds = $('#multiImgIds').val();
		var file_data = $('#serviceImage').prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('service_id', 0);
		$('.loader_ajax_small').show();
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
						'<div class="text-right"><button type="button" class="btn btn-danger removeImage" onclick="removeImage('+response.id+')"><i class="fa fa-trash"></i></button></div>'+
						'<img style="width: inherit; height: inherit;" src="'+response.imgName+'" alt="'+response.id+'">'+
						'</div></div></div>';
					$('#previousImg').append(portElement);
					$('.loader_ajax_small').hide();
					$('#previousImg').css('opacity', '1');
				}
			}
		});
	});

	$('.removeImage').on('click', function(e){
		removeImage($(this).attr('data-id'));
	});

	function removeImage(imgId){
		$.ajax({
			url:site_url+'users/removeServiceImage',
			type:"POST",
			data:{'imgId':imgId},
			success:function(data){
				$('#portDiv'+imgId).remove();
				alert('image deleted successfully');
			}
		});
	}
</script>
<!--****************FILE UPLOAD FUNCTION CODE END****************-->