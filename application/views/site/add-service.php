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
	.videoPreviewPlus{width: fit-content;
    padding: 5px;
    border: 1px solid #b0c0d3;
    border-radius: 10px;display: inline-block;}
    .videoPreviewPlus video {
    	width: 100%;
    	float: left;
    }
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
					<?php if($this->session->flashdata('error')): ?>
						<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
						<?php unset($_SESSION['error']) ?>
					<?php endif; ?>
					<?php if($this->session->flashdata('success')): ?>
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php unset($_SESSION['success']) ?>
					<?php endif; ?>
					<?php
						$nextStep = $this->session->userdata('next_step');
						$active = 1;
						if($nextStep){
							$active = $nextStep;
						}
						$serviceData = $this->session->userdata('service_data');
						// echo '<pre>';
						// print_r($serviceData);
						// exit;
					?>
					<div class="user-right-side">
						<h1>Add Service</h1>
						<ul id="myTabs" class="nav nav-tabs">
							<li class="<?php echo ($active == 1) ? 'active ' : ''; echo ($nextStep >= 1) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step1">Service Details</a></li>

							<!-- <li class="<?php echo ($active == 2) ? 'active ' : ''; echo ($nextStep >= 2) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step2">Categroy</a></li> -->
							
							<li class="<?php echo ($active == 7) ? 'active ' : ''; echo ($nextStep >= 7) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step7">Package</a></li>
							
							<li class="<?php echo ($active == 3) ? 'active ' : ''; echo ($nextStep >= 3) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step3">Extra Service</a></li>
							
							<li class="<?php echo ($active == 4) ? 'active ' : ''; echo ($nextStep >= 4) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step4">Gallery</a></li>
							
							<li class="<?php echo ($active == 5) ? 'active ' : ''; echo ($nextStep >= 5) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step5">FAQs</a></li>
							
							<li class="<?php echo ($active == 6) ? 'active ' : ''; echo ($nextStep >= 6) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step6">Availability</a></li>
							
							<li class="<?php echo ($active == 8) ? 'active ' : ''; echo ($nextStep >= 8) ? '' : 'disabled' ?>"><a data-toggle="tab" href="#step6">Profile</a></li>
						</ul>
						<div class="tab-content">
							<div id="step1" class="tab-pane fade <?php echo ($active == 1) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service1', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices']); ?>
							</div>

							<!-- <div id="step2" class="tab-pane fade <?php echo ($active == 2) ? 'active in' : '' ?>">
								<?php //$this->load->view('site/add-service2', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices2']); ?>
							</div> -->

							<div id="step7" class="tab-pane fade <?php echo ($active == 7) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service7', ['serviceData' => $serviceData, 'url' => site_url()."users/storeServices7"]); ?>
							</div>

							<div id="step3" class="tab-pane fade <?php echo ($active == 3) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service3', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices3']); ?>
							</div>

							<div id="step4" class="tab-pane fade <?php echo ($active == 4) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service4', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices4']); ?>
							</div>

							<div id="step5" class="tab-pane fade <?php echo ($active == 5) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service5', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices5']); ?>
							</div>

							<div id="step6" class="tab-pane fade <?php echo ($active == 6) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service6', ['serviceData' => $serviceData, 'url' => site_url().'users/storeServices6', 'type' => 'add']); ?>
							</div>
							
							<div id="step8" class="tab-pane fade <?php echo ($active == 8) ? 'active in' : '' ?>">
								<?php $this->load->view('site/add-service8', ['serviceData' => $serviceData, 'url' => site_url()."users/storeServices8"]); ?>
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
</script>
<script>
	document.addEventListener('DOMContentLoaded', (event) => {
        const video = document.getElementById('hoverVideo');

        video.addEventListener('mouseenter', () => {
            console.log('Mouse entered');
            video.play();
        });

        video.addEventListener('mouseleave', () => {
            console.log('Mouse left');
            video.pause();
        });
    });
    

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
	  var file = fileUploads.files[0];
	  var reader = new FileReader();
	  var fileType = file.type.split('/')[0];

	  reader.readAsDataURL(fileUploads.files[0]);
	  reader.onload = function (e) {
	    if (fileType === 'image') {
            var image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                var height = this.height;
                var width = this.width;
                var html = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="padding-left:30px">'+
                                '<div class="boxImage imgUp">'+
                                    '<div class="imagePreviewPlus">'+
                                        '<img style="width: inherit; height: inherit;" src="'+image.src+'" alt="Image">'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                $('#imgpreview').html('').html(html);
            };
        } else if (fileType === 'video') {
            var html = '<div class="col-md-4 col-sm-6 col-xs-12" style="padding-left:30px">'+
                            '<div class="videoPreviewPlus">'+
                                '<video controls autoplay>'+
                                    '<source src="'+e.target.result+'" type="'+file.type+'">'+
                                    'Your browser does not support the video tag.'+
                                '</video>'+
                            '</div>'+
                        '</div>';
            $('#imgpreview').html('').html(html);
        } else {
            alert("Unsupported file type!");
        }
	  }     
	}

	$(document).ready(function(){
    	// Disable tabs function
    	$('#myTabs li.disabled a').click(function(e) {
      		e.preventDefault();
    	  	return false;
    	});
  	});
</script>
<?php include 'include/footer.php'; ?>