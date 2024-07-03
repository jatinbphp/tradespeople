<?php include 'include/header.php'; ?>
<style>
.chosen-container.chosen-container-multi {
  width: 100% !important;
  #processing-popup .modal-dialog{
    display: table;
    position: relative;
    margin: 0 auto;
    top: calc(50% - 24px);
  }
}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<style>
.form-rounded {
border-radius: 1rem;
}
</style>
<div class="content-wrapper">
	<div class="panel panel-default" style="width:96%; margin:auto;">
		<div class="panel-heading">
			<section class="content-header">
			<h1>Generate HTML Code</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Generate HTML Code</li>
			</ol>
			</section>
		</div>
		<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form method="POST" name="form_send_emails" id="form_send_emails" action="" enctype="multipart/form-data">
				<div class="panel-group">
					<div class="panel panel-default" id="job_info_form">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-12"><label class="control-label"><b>Job Posts</b></label> </div>
								<div class="col-md-12" id="selected_jobs"></div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-2" style=" margin-left:0px; padding:0px;">&nbsp;</div>
								<div class="col-md-9 border border-dark" style=" margin-left:0px; padding:0px;">
									<a class="btn btn-warning" href="" data-toggle="modal" data-target="#jobs-popup">Add Job</a>
								</div>
								<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-2" style=" margin-left:0px; padding:0px;">&nbsp;</div>
								<div class="col-md-9 border border-dark" style=" margin-left:0px; padding:0px;">
									<!--<a class="btn btn-warning" href="Javascript:generate_html()">Generate html</a>-->
									<button type="submit" class="btn btn-warning" name="submit" value="generate">Generate html</button>
								</div>
								<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							</div>
						</div>
					</div>
					<div class="modal fade popup" id="jobs-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Job Posts</h4>
								</div>
								<div class="modal-body">
									<fieldset>
									<!-- Text input-->
									<div class="form-group">
										<label class="col-md-12 control-label" for="textinput">Select Job</label>  
										<div class="col-md-12"> 
											<select data-placeholder="Select Job" class="form-control input-md chosen-select form-rounded" multiple style="width:350px;" tabindex="4" name="job_ids[]" id="job_ids">
											<?php 
											//$selected_lang = ($user_profile['category'])?explode(',',$user_profile['category']):array();

											foreach($jobs as $jo) { 
											//$selected = (in_array($row['cat_id'],$selected_lang))?'selected':'';
											?>
											<option value="<?= $jo['job_id']; ?>"> <?= $jo['title']; ?></option>
											<?php } ?>
											</select>   
											<input type="hidden" name="jobs" value="jobs">
											<input type="hidden" name="jobs_list" id="jobs_list" value="" />
										</div>
									</div>
									</fieldset>
								</div>
								<div class="modal-footer">
									<div class="col-md-12">
										<div class="col-md-8">&nbsp;</div>
										<div class="col-md-2"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
										<div class="col-md-2"><button type="button" class="btn btn-warning" onclick="add_jobs()">Add</button></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		</section>
	</div>
</div>

<?php include 'include/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>
  $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});
function add_jobs(){
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Gen_html/add_job',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){
				if(resp.status==1){
					$("#selected_jobs").html(resp.selected_jobs);
					$("#jobs-popup").modal('hide');
					$("#jobs_list").val(resp.selected_jobs_list);
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	return false;
}
function generate_html(){
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Gen_html/generate_html',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){
				if(resp.status==1){
					//$("#test").html("<pre>"+resp.htm+"</pre>");
					//$("#selected_jobs").html(resp.selected_jobs);
					$("#jobs-popup").modal('hide');
					//$("#jobs_list").val(resp.selected_jobs_list);
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	return false;
}
</script>
	