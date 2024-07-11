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
						<?php
						$nextStep = $this->session->userdata('next_step');

						$active = 1;
						if($nextStep){
							$active = $nextStep;
						}
						// unset($_SESSION);
						// session_destroy();
						$serviceData = $this->session->userdata('edit_service_data');
						
						// echo "<Pre>";
						// // print_r($_SESSION);
						// print_r($serviceData);
						// echo "</Pre>";
					?>
						<ul id="myTabs" class="nav nav-tabs">
							<li class="<?php echo ($active == 1) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step1">Step-1</a></li>
							<li class="<?php echo ($active == 2) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step2">Step-2</a></li>
							<li class="<?php echo ($active == 3) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step3">Step-3</a></li>
							<li class="<?php echo ($active == 4) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step4">Step-4</a></li>
							<li class="<?php echo ($active == 5) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step5">Step-5</a></li>
							<li class="<?php echo ($active == 6) ? 'active ' : ''; ?>"><a data-toggle="tab" href="#step6">Step-6</a></li>
						</ul>
						<div class="tab-content">
							<div id="step1" class="tab-pane fade <?php echo ($active == 1) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service1', ['serviceData' => $serviceData]); ?>
							</div>
							<div id="step2" class="tab-pane fade <?php echo ($active == 2) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service2', ['serviceData' => $serviceData]); ?>
							</div>
							<div id="step3" class="tab-pane fade <?php echo ($active == 3) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service3', ['serviceData' => $serviceData]); ?>
							</div>
							<div id="step4" class="tab-pane fade <?php echo ($active == 4) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service4', ['serviceData' => $serviceData]); ?>
							</div>
							<div id="step5" class="tab-pane fade <?php echo ($active == 5) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service5', ['serviceData' => $serviceData]); ?>
							</div>
							<div id="step6" class="tab-pane fade <?php echo ($active == 6) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service6'); ?>
							</div>
						</div>
					</div>
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
		var file_data = $('#serviceImage').prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('service_id', <?php echo $service['id']; ?>);
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