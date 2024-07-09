<?php include 'include/header.php'; ?>
<style>
	.addFaqs{cursor: pointer;}
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
						<h1>Add Service</h1> 
						<form action="<?= site_url().'users/storeServices6'; ?>" id="update_service" method="post" enctype="multipart/form-data">  
							<div class="edit-user-section">
								<div class="msg"><?= $this->session->flashdata('msg');?></div>
								<div class="row">
									<div class="col-sm-12" style="border-bottom:1px solid #b0c0d3;">
										<h4 class="text-info">
											Select Availablity
										</h4>
									</div>
									<div class="col-sm-12" style="margin-top:10px; border-bottom:1px solid #b0c0d3;">
										<span>Are you avaialble anytime between Monday To Fridays</span>
										<div class="row">
											<div class="col-sm-2">
												<div class="form-group">
													<div class="form-check" style="margin: 0;">
														<input class="form-check-input" type="checkbox" name="available_mon_fri" value="yes" style="margin-right:10px;">
														<label class="form-check-label" style="margin-top:10px; font-weight: normal;">Yes</label>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-check" style="margin: 0;">
														<input class="form-check-input" type="checkbox" name="available_mon_fri" value="no" style="margin-right:10px;">
														<label class="form-check-label" style="margin-top:10px; font-weight: normal;">No</label>
													</div>
											</div>
										</div>
									</div>

									<div class="col-sm-12" style="margin-top:10px; border-bottom:1px solid #b0c0d3;">
										<span>If No add the days and time you not available</span><br>
										<span style="font-size: 12px; color: #b0c0d3;">
											Days you will not available?
										</span>
										<input type="hidden" name="selectedDates" id="selectedDates">
										<div id="datepicker" style="width: 100%; margin:10px 0;">
										</div>
										<span style="font-size: 12px; color: #b0c0d3;">
											Time you will not be available?
										</span>
										<div>
											<select class="form-control input-md"
											 name="time" id="timeSlot">
												<option value="">Specify your unavailable time range</option>
												<?php
												for ($hour = 0; $hour <= 23; $hour++) {
										            $hour_padded = sprintf("%02d", $hour % 12 == 0 ? 12 : $hour % 12); // Convert 0 to 12 for am/pm display
										            $ampm = $hour < 12 ? 'am' : 'pm'; // Determine am/pm
										            echo "<option value=\"$hour_padded:00 $ampm\">$hour_padded:00 $ampm</option>\n";
										        }
												?>
											</select>
										</div>
										<div style="border-bottom:1px solid #b0c0d3; padding: 10px 0;">
											<span>
												Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
											</span>
										</div>
										<div id="notAvailablMsg" style="padding: 10px 0;">
											<span>
												Not available from: 
												<span class="text-info pull-right">
													May 2nd to 3rd, till 08:00 pm
												</span>
											</span>
										</div>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$('#timeSlot').on('change', function() {
        updateAvailabilityMessage(); // Call formatSentence when time slot changes
    });
</script>

<?php include 'include/footer.php'; ?>