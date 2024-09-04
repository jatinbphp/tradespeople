<style>
	#tprofileImage {
		display: none;
	}
	#profileImageContainer {
		cursor: pointer;
	}
</style>
<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
	<div class="edit-user-section">
		<div class="msg"><?= $this->session->flashdata('msg');?></div>
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Profile Picture*</label>
					<div class="col-md-12">
						<div id="profileImageContainer">
							<?php if($user_profile['profile']){ ?>
							<img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='200' height='217' style="width: 175px!important; height: 175px!important;">
							<?php }else{ ?>
							<img src="<?php echo base_url(); ?>img/default-img.png" alt="Click to select image" width="200" height="217">
							<?php }?>
							<input type="file" name="profile" id="tprofileImage" class="form-control input-md" accept="image/*" onchange="return seeProfilePreview();">
						</div>

						<input type="hidden" name="u_profile_old" value="<?= $user_profile['profile']; ?>" >
						<!--<div id="imgpreview">
			 <?php if($user_profile['profile']){ ?>
			  <img src="<?php echo base_url();?>img/profile/<?php echo $user_profile['profile'];?>"  width='100px' height='100px'>
			 <?php } ?>
			</div>-->
					</div>
				</div>
			</div>

			<?php if($this->session->userdata('type')==1){ ?>
			<div class="col-md-9">
				<div class="form-group">
					<label class="col-md-12 control-label" for="">About Your Business </label>
					<div class="col-md-12">
						<textarea class="form-control input-md" name="about_business" id="about_business" rows="10"><?php echo $user_profile['about_business']; ?></textarea>
						<div class="text-right"><small class="text-danger">(Minimum 100 characters)</small></div>
						<!--<div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Please don't include contact details or your website in this section.</div>-->
						<div class="msg1-11 text-danger" style="display: none; margin-top:10px;">Contact detail detected. Remove it to continue.</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<!-- <div class="col-sm-12">
		 <h2>Name</h2>
		</div> -->
		<div class="row">
			<div class="col-sm-6">
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-12 control-label" for="">First Name*</label>  
					<div class="col-md-12">
						<input id="f_name" name="f_name" placeholder="First Name" class="form-control input-md" type="text" value="<?php echo $user_profile['f_name']; ?>" readonly required>

					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Last Name*</label>  
					<div class="col-md-12">
						<input id="l_name" name="l_name" placeholder="Last Name" class="form-control input-md" type="text" value="<?php echo $user_profile['l_name']; ?>" readonly required>

					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-12 control-label" for="">Trading Name*</label>  
					<div class="col-md-12">
						<input id="trading_name" name="trading_name" placeholder="Trading Name" class="form-control input-md" type="text" value="<?php echo $user_profile['trading_name']; ?>" required>

					</div>
				</div>
			</div>
		</div>
	</div>   
	<!-- Edit-section-->

	<div class="edit-user-section gray-bg">
		<div class="row nomargin">
			<div class="col-sm-12 serviceBtn">
				<button type="submit" class="btn btn-warning submit_btn">Submit Listing Now</button>
			</div>                                 
		</div>
	</div>                        
	<!-- Edit-section-->
</form>

<script type="text/javascript">	
  	document.getElementById('profileImageContainer').addEventListener('click', function() {
		document.getElementById('tprofileImage').click();
	});

	document.getElementById('tprofileImage').addEventListener('change', function(e) {
		var file = e.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			var image = document.querySelector('#profileImageContainer img');
			image.src = e.target.result;
		};

		reader.readAsDataURL(file);
	});

	function seeProfilePreview(){
		var fileUploads = $("#tprofileImage")[0];
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
