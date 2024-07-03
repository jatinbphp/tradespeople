<?php include 'include/header.php'; ?>

<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<style type="text/css">
	.trads-offer{
		color:#FF3500;
	}
	.tradsman-banner .card {
		background:#fff;
		border-radius:5px;
		padding:10px !important;
		margin-bottom:10px;
		position: relative;
		overflow: hidden;
		padding: 10px 10px 10px 0px !important;
	}
	.tradsman-banner .card:before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 18%;
		background-color: #fff;
		height: 100%;
	}

	.tradsman-banner .card p{
		font-size:18px;
		font-weight:500;
		margin: 0;
	}
	#vote_buttons:hover {
		cursor:pointer;
	}
	/*
	.modal {
	  display: none;
	  position: fixed;
	  z-index: 1;
	  padding-top: 100px;
	  left: 0;
	  top: 0;
	  width: 100%;
	  height: 100%;
	  overflow: auto;
	  background-color: rgb(0,0,0);
	  background-color: rgba(0,0,0,0.4);
	}
	.modal-content {
	  background-color: #fefefe;
	  margin: auto;
	  padding: 20px;
	  border: 1px solid #888;
	  width: 43%;
	}*/
	.emailmsg{
		text-align: center;
		background: green;
		color: white;
		padding: 10px;
		font-size: 15px;
		display: none;
	}

	.animate-text {
		-webkit-backface-visibility: hidden;
		-webkit-perspective: 1000;
		-webkit-transform: translate3d(0,0,0);
	}

	.animate-text > span {
		overflow:hidden;
		white-space:nowrap;
	}

	.animate-text > span:first-of-type {
		animation: showup 7s;
		/*  background-color: #FFF;*/
	}

	.animate-text > span:last-of-type {
		width:0px;
		/*  animation: reveal 7s;*/
	}

	.animate-text > span:last-of-type {
		animation: slidein 7s;
	}

	@keyframes showup {
		0% {opacity:0; padding-left: 40%;}
		20% {opacity:1; padding-left: 40%}
		35% {opacity:1; padding-left: 0%}
		100% {opacity:1; padding-left: 0%}
	}

	@keyframes slidein {
		0% { margin-left:-150%; }
		20% { margin-left:-150%; }
		35% { margin-left:0%; }
		100% { margin-left:0%; }
	}

	/*@keyframes slidein {
	  0% { margin-left:40%; }
	  20% { margin-left:40%; }
	  35% { margin-left:0%; }
	  100% { margin-left:0%; }
	}*/

	/*@keyframes slidein {
	  0% { margin-left:-800px; }
	  20% { margin-left:-800px; }
	  35% { margin-left:0px; }
	  100% { margin-left:0px; }
	}*/

	@keyframes reveal {
		0% {opacity:0;width:0px;}
		20% {opacity:1;width:0px;}
		30% {width:355px;}
		100% {opacity:1;}
		/*  100% {opacity:0;width:355px;}*/
	}



</style>
<div class="acount-page membership-page">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php include 'include/sidebar.php'; ?>
			</div>
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="user-right-side">
							<h1>Delete My Account Forever</h1>
							<form id="delete_account" method="post" enctype="multipart/form-data" onsubmit="return delete_account_request();">
								<div class="edit-user-section">
									<div>
										<span>Are you sure you want to delete your?</span>
									</div>
									<div class="mt20">
										<span class="mt-2">You will not be able to log into your profile anymore. All history of your account will be permanent deleted without the possibility to restore it.</span>
									</div>
									<div class="mt20">
										<select name="reason" id="reason" class="form-control">
											<option value="">Why Do you Leave?</option>
											<option value="I have duplicate account.">I have duplicate account.</option>
											<option value="I get too many notifications.">I get too many notifications.</option>
											<option value="I haven't found anything interesting.">I haven't found anything interesting.</option>
											<option value="Other reason.">Other reason.</option>
										</select>
										<span class="text-danger" id="deleteReasonMsg"></span>
									</div>
									<div class="mt20">
										<button type="submit" class="btn btn-danger request_btn" style="width: 100%;">Delete my account forever</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function delete_account_request(){
		var reason = $('#reason').val();
		if(reason == ""){
			$('#deleteReasonMsg').html('Please select a reason for delete your account.');
			return false;
		}else{
			$('#deleteReasonMsg').html('');
		}

		$.ajax({
			type:'POST',
			url:site_url+'users/send_delete_request',
			data: {reason:reason},
			beforeSend:function(){
				$('.request_btn').prop('disabled',true);
				$('.request_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			},
			success:function(resp){
				$('.request_btn').prop('disabled',false);
				$('.request_btn').html('Delete my account forever </i>');
				if(resp == 1){
					swal("Success", "Your delete account request has been submitted successfully.", "success");
				}else if(resp == 2){
					swal("Error", "Your delete account request already submitted.", "error");
				}else{
					swal("Success", "Something is wrong.", "error");
				}
			}
		});
		return false;
	}
</script>
<?php include 'include/footer.php'; ?>



