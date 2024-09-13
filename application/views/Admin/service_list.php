<?php
include_once 'include/header.php';
if (!in_array(22, $my_access)) {redirect('Admin_dashboard');}
?>
<style>
	.table-responsive {
		overflow: auto;
	}
	@media (max-width:575.98px){
		.table-responsive-sm{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
		}
		.table-responsive-sm>.table-bordered{
			border:0
		}
	}
	@media (max-width:767.98px){
		.table-responsive-md{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
		}
		.table-responsive-md>.table-bordered{
			border:0
		}
	}
	@media (max-width:991.98px){
		.table-responsive-lg{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
		}
		.table-responsive-lg>.table-bordered{
			border:0
		}
	}
	@media (max-width:1199.98px){
		.table-responsive-xl{
			display:block;
			width:100%;
			overflow-x:auto;
			-webkit-overflow-scrolling:touch;
			-ms-overflow-style:-ms-autohiding-scrollbar
		}
		.table-responsive-xl>.table-bordered{
			border:0
		}
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Services</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Service List</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="div-action pull pull-right" style="padding-bottom:20px;"> </div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="boottable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>S.NO</th>
										<th>Service Name</th>
										<th>Category</th>
										<th>Added By</th>
										<th>Location</th>
										<th>Price</th>
										<th>Created At</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($service_list as $key => $lists) {?>
									<tr role="row" class="odd" id="request_<?php echo $lists['id']; ?>">
										<td><?php echo $key + 1; ?></td>
										<td>
											<?php echo $lists['service_name']; ?>
											<?php if(in_array($lists['status'], ['required_modification','denied'])):?>
												<br>
												<span class="viewReason text-danger" data-id="<?php echo $lists['id']; ?>">View Reason</span>
											<?php endif;?>	
										</td>
										<td><?php echo $lists['cat_name']; ?></td>
										<td><?php echo $lists['trading_name']; ?></td>
										<td><?php echo $lists['location']; ?></td>
										<td><?php echo '£'.number_format($lists['price'],2); ?></td>
										<td><?php echo $lists['created_at']; ?></td>
										<td>
											<select class="form-control serviceStatus" data-id="<?php echo $lists['id']; ?>" <?php echo $lists['status'] == 'active' ? 'disabled' : ''; ?>>
												<option value="approval_pending" <?php echo $lists['status'] == 'approval_pending' ? 'selected' : ''; ?> >Approval Pending</option>

												<option value="required_modification" <?php echo $lists['status'] == 'required_modification' ? 'selected' : ''; ?>>Required Modification</option>

												<option value="denied" <?php echo $lists['status'] == 'denied' ? 'selected' : ''; ?>>Denied</option>

												<option value="paused" <?php echo $lists['status'] == 'paused' ? 'selected' : ''; ?>>Paused</option>
												
												<option value="active" <?php echo $lists['status'] == 'active' ? 'selected' : ''; ?>>Approved</option>												
											</select>	

										</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary serviceDetails" data-id="<?php echo $lists['id']; ?>" data-name="<?php echo $lists['service_name']; ?>"><i class="fa fa-eye"></i></button>
										</td>				
									</tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade bd-example-modal-lg" id="serviceDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header">
	        <h3 class="modal-title pull-left"></h3>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div id="serviceDetailsDiv">
	    	</div>
	    </div>
	    <div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      	</div>
    </div>
  </div>
</div>

<div class="modal fade in" id="view_service_reason">
 	<div class="modal-body" id="msg">
    	<div class="modal-dialog modal-lg">	 
	       	<div class="modal-content">         	
		  		<form method="post" id="service_reason_form" enctype="multipart/form-data">
		        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	            	<h4 class="modal-title" id="reason_modal_title">View Reason</h4>
	          	</div>
	          	<div class="modal-body form_width100">
	          		<div class="form-group">
									<textarea rows="5" placeholder="" name="reason" id="view_service_reason_fields" class="form-control"></textarea>
					 			</div>
							</div>
	          	<div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	          	</div>
			   	</form>
	        </div>			
      	</div>
    </div>
 </div>

<div class="modal fade in" id="service_reason">
 	<div class="modal-body" id="msg">
    	<div class="modal-dialog modal-lg">	 
	       	<div class="modal-content">         	
		  		<form method="post" id="service_reason_form" enctype="multipart/form-data">
		        	<div class="modal-header">
	            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	            	<h4 class="modal-title" id="reason_modal_title">Reason</h4>
	          	</div>
	          	<div class="modal-body form_width100">
	          		<div class="form-group">
									<label for="reason" id="reasonField"></label>
									<textarea rows="5" placeholder="" name="reason" id="service_reason_fields" class="form-control"></textarea>
					 			</div>
							</div>
	          	<div class="modal-footer">
		          	<input type="hidden" name="service_id" value="" id="service_id">
		          	<input type="hidden" name="status" value="" id="service_status">
		          	<button type="button" class="btn btn-info signup_btn" id="submitReasonBtn" onclick="submitReason()">Submit</button>
		            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	          	</div>
			   	</form>
	        </div>			
      	</div>
    </div>
 </div>

<?php include_once 'include/footer.php';?>

<script type="text/javascript">
	var monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
  ];

	$('.serviceDetails').on('click', function(){
		var sId = $(this).data('id');
		var sName = $(this).data('name');
		$('.modal-title').text(sName);
		$.ajax({
			type:'POST',
			url:site_url+'Admin/admin/getServiceDetails',
			data:{id:sId},
			success:function(data){
				$('#serviceDetailsDiv').html(data);
				updateAvailabilityMessage();
				$('#serviceDetails').modal('show');
			}
		});
	});

	function formatSentence(selectedDates, timeSlot) {
    var sentence = "";
    if (selectedDates.length > 0 && timeSlot) {
      // Sort the dates
      selectedDates.sort(function(a, b) {
          return new Date(a) - new Date(b);
      });

      var groupedDates = {}; // To store dates grouped by month

      selectedDates.forEach(function(dateStr) {
        var date = new Date(dateStr);
        var month = monthNames[date.getMonth()];
        if (!groupedDates[month]) {
          groupedDates[month] = [];
        }
        groupedDates[month].push(date);
      });

      var formattedDates = [];
      for (var month in groupedDates) {
        var dates = groupedDates[month];
        var dateRanges = [];
        var start = dates[0];
        var end = start;

        for (var i = 1; i < dates.length; i++) {
          if (dates[i] - end === 86400000) { // Check if the next date is consecutive (1 day in ms)
              end = dates[i];
          } else {
              dateRanges.push(formatDateRange(start, end));
              start = dates[i];
              end = start;
          }
        }
        dateRanges.push(formatDateRange(start, end)); // Add the last range
        formattedDates.push(month + " " + dateRanges.join(", "));
      }
      sentence = "<span>Not available on: <span class='text-info'>" + formattedDates.join(", ") + ", till " + timeSlot+"</span></span>";
    }
    return sentence;
  }

  function formatDateRange(start, end) {
    if (start.getTime() === end.getTime()) {
        return formatDate(start);
    } else {
        return formatDate(start) + " to " + formatDate(end);
    }
  }

  function formatDate(date) {
    var day = date.getDate();
    var suffix = getOrdinalSuffix(day);
    return day + suffix;
  }

  function getOrdinalSuffix(date) {
    if (date > 3 && date < 21) return 'th';
    switch (date % 10) {
      case 1:  return "st";
      case 2:  return "nd";
      case 3:  return "rd";
      default: return "th";
    }
  }

  function updateAvailabilityMessage() {
  	if ($('#selectedDates').length) {
  		var selectedDates = $('#selectedDates').val().split(',');
	    var timeSlot = $('#timeSlot').val();
	    var sentence = formatSentence(selectedDates, timeSlot);
	    console.log('sentence====>'+sentence);
	    if(sentence != ""){
	      $('#notAvailablMsg').show().html(sentence); // Update the availability text  
	    }
  	}
  }

  $('.serviceStatus').on('change', function(){
  	var status = $(this).val();
  	var sId = $(this).data('id');

  	if(status == 'required_modification' || status == 'denied'){
		if(status == 'required_modification'){
			$('#reasonField').text('Reason for required modification');
			$('#reason_modal_title').text('Reason For Required Modification');
		}else{
			$('#reasonField').text('Reason for denied');
			$('#reason_modal_title').text('Reason For Denied');
		}
		var sId = $('#service_id').val(sId);
		var status = $('#service_status').val(status);
		$('#service_reason').modal('show');  			
	} else {

		var userConfirmed = confirm('Are you sure to update a status of the service?');
		
	  	if (userConfirmed) {
			updateServiceStatus(sId, status, '');
	    } else {
	    	$(this).prop('selectedIndex', 0);
	    }
   	}
  });

  function submitReason(){
  	var sId = $('#service_id').val();
  	var status = $('#service_status').val();
  	var reason = $('#service_reason_fields').val();
  	$('#submitReasonBtn').text('Submitting...');
  	$('#submitReasonBtn').attr('disabled','true');
  	updateServiceStatus(sId, status, reason);
  }

  function updateServiceStatus(sId, status, reason){
  	$.ajax({
			type:'POST',
			url:site_url+'Admin/admin/updateStatus',
			data:{id:sId,status:status,reason:reason},
			success:function(response){
				if(response == 1){
					window.location.reload();
				}else{
					alert('Something is wrong.');
				}
			}
		});
  }

  $('.viewReason').on('click', function(){
  	var sId = $(this).data('id');
  	$.ajax({
			type:'POST',
			url:site_url+'Admin/admin/getReason',
			data:{id:sId},
			dataType:'json',
			success:function(response){
				if(response.status == 1){
					$('#view_service_reason_fields').val(response.reason);
					$('#view_service_reason').modal('show');					
				}else{
					alert('Reson not found.');
				}
			}
		});
  });
</script>

