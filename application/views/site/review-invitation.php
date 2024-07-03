<?php 
include ("include/header1.php");
?>
<style>
.form-group-us1 {
	margin-bottom: 15px;
}
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
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
<div class="start-sign">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="msg"><?= $this->session->flashdata('msg123'); ?></div>
				<div class="white-start">
					<div class="sing-top">
						
						<h1>Review Invitation</h1>
						<?php if($data['status']==0){ ?>
						<h4 style="padding-bottom: 20px;" class="text-center"></h4>
						<?php } ?>
					</div>
					
					<div class="sing-body">
						<?php if($status==1){ ?>
						
						<?php
              if($isUrlExpired){
            ?>
                <div class="alert alert-danger">Sorry this URL has been expired.</div>
            <?php
              }else if($data['status'] == 0){
            ?>
<div class="modal fade popup" id="mark_as_complete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel" style="text-align: left">Please leave your feedback</h4>
			</div>
			<form method="post" id="marks_as_complete" onsubmit="return mark_complete();">
				<div class="modal-body">
					<p class="err"></p>
					<p>Leave a review here if you have hired this tradesperson to complete any work around your home and would like to share your thought with other customers.</p>
					<fieldset>
            
						<!-- Text input-->
						<div class="form-group">
							<div class="col-md-12" style="text-align: left;">
								<div class='rating-stars text-center'>
									<ul id='stars'>
										<li class='star' title='Poor' data-value='1'>
											<i class='fa fa-star fa-fw'></i>
										</li>
										<li class='star' title='Fair' data-value='2'>
											<i class='fa fa-star fa-fw'></i>
										</li>
										<li class='star' title='Good' data-value='3'>
											<i class='fa fa-star fa-fw'></i>
										</li>
										<li class='star' title='Excellent' data-value='4'>
											<i class='fa fa-star fa-fw'></i>
										</li>
										<li class='star' title='WOW!!!' data-value='5'>
											<i class='fa fa-star fa-fw'></i>
										</li>
									</ul>
									<input type="hidden" name="rt_rate" class="rating" value="0" required="" />
									<input type="hidden" name="job_id" value="<?php echo $data['job_id']; ?>">
									<input type="hidden" name="bid_by" value="<?php echo $data['invite_by']; ?>">
									<input type="hidden" name="is_invited" value="<?php echo $data['id']; ?>">
									<input type="hidden" name="posted_by" value="<?php echo $data['invite_to']; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Feedback:</label>
							<textarea required class="form-control" rows="7" name="rt_comment" required=""></textarea>
						</div>
					</fieldset>
   
				</div>
				<div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="wrbtn">Submit<i class="fa fa-spinner fa-spin wrbtnloader" style="font-size:24px;display:none;"></i></button>
        </div>
			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#mark_as_complete').modal({
    backdrop: 'static',
    keyboard: false
	});
});
</script>				
						<?php } else if($data['status']==1){ ?>
						<div class="alert alert-success">Your review submitted successfully.</div>
						<?php } ?>
						
						
						<?php } else { ?>
						<div class="alert alert-danger"><?php echo $msg; ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
				$(this).addClass('hover');
      } else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
		$('.rating').val(ratingValue);
    
	});
  
});

function mark_complete() {
	$.ajax({
		type:'POST',
		url:site_url+'users/give_invited_review/',
		dataType: 'JSON',
		data:$('#marks_as_complete').serialize(),
		beforeSend:function(){
			$('.err').html('');
		},
		success:function(resp){
			
			if(resp.status==1){
				location.reload();
			} else {
				$('.err').html(resp.msg);
			}
		} 
	});
	return false;
}
</script>
<!-- upper-footer -->
<?php include ("include/footer.php") ?>
