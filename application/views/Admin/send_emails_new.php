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
<script>
function send_job_info2(){
	 $.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/send_emails_to_external_tradesman',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
				$('#processing-popup').modal('show');
				$('.post_btn').prop('disabled',true);
				$('.post_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			},
			success:function(resp){
				if(resp.status==1){
					$('#processing-popup').modal('hide');
					$(".post_btn").removeClass("btn-warning");
					$(".post_btn").addClass("btn-success");
					$(".post_btn").html("Email Sent");
						//window.location.href = site_url+'Admin/Home/proposals?post_id='+resp.job_id;
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
		return false;
 }
function send_job_info1(){
	 $.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/send_emails_to_internal_tradesman',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
				$('#processing-popup').modal('show');
				$('.post_btn').prop('disabled',true);
				$('.post_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			},
			success:function(resp){
				if(resp.status==1){
					$('#processing-popup').modal('hide');
					$(".post_btn").removeClass("btn-warning");
					$(".post_btn").addClass("btn-success");
					$(".post_btn").html("Email Sent");
						//window.location.href = site_url+'Admin/Home/proposals?post_id='+resp.job_id;
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
		return false;
 }
function del_job(id) {
	//pass additional parameter with form data
	//var form_data = new FormData($('#form_send_emails')[0]);
	//form_data.append("del_id", id);
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/delete_job/'+id,
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){console.log(resp.selected_jobs_list);console.log(resp.sess_ids);
				if(resp.status==1){
					if(resp.selected_jobs_list == ""){
						$("#send_btn").hide();
					}
					$('#is_set_job').val(1);
					$('#del_job'+id).remove();
					//$("#selected_tradesman").html(resp.selected_tradesmans);
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
function del_tradesman(id) {
	//pass additional parameter with form data
	//var form_data = new FormData($('#form_send_emails')[0]);
	//form_data.append("del_id", id);
	if(id>0){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/delete_tradesman/'+id,
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){console.log(resp.selected_tradesman_list);console.log(resp.sess_ids);
			
				if(resp.status==1){
					if(resp.selected_tradesman_list == ""){
						$("#send_btn").hide();
					}
					$('#is_set_tradsman').val(1);
					$('#del_tradesman'+id).remove();
					//$("#selected_tradesman").html(resp.selected_tradesmans);
					$("#tradesman_list").val(resp.selected_tradesman_list);
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	}
	return false;
}
function add_tradesman(){
	/* var tradsman_sel = $("#tradesman").val();alert(tradsman_sel);
	if(tradsman_sel === "" || tradsman_sel === null){
		alert("Please select tradsman from the list.")
	}else{ */
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/add_tradesman',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){console.log(resp.sess_ids);
				if(resp.status==1){
					$("#selected_tradesman").html(resp.selected_tradesmans);
					$("#tradesman-popup").modal('hide');
					$("#tradesman_list").val(resp.selected_tradesman_list);
					$("#add_onclick_btn").html('<button type="button" class="btn btn-warning" onclick="add_jobs(1)">Add</button>');
					$("#job_info_form").show();
					window.location.href="#job_info_form";
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	//}
	return false;
}
function add_jobs(){
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/add_job',
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
					$("#add_onclick_send_btn").html('<button type="button" onclick="send_job_info1()" class="btn btn-warning btn-lg post_btn" id="buttonpost1">Send Email</button>');
					$("#send_btn").show();
					window.location.href="#send_btn";
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	return false;
}

function del_ext_tradsman(id) {
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/delete_external_tradesman/'+id,
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){
				if(resp.status==1){
					if(resp.added_ext_tradsman_count == 0){
						$("#send_btn").hide();
					}
					$("#count_ext_tradsman").val(resp.added_ext_tradsman_count);
					$('#del_ext_tradsman'+id).remove();
					$("#ext_tradesman_list").val(resp.added_ext_tradsman_email);
					$("#ext_tradesman_name_list").val(resp.added_ext_tradsman_name);
					$("#added_ext_tradsmans").html(resp.added_ext_tradsmans);
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	
	return false;
}
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function add_tradsman_info(){
	var err = 0;
	var user_email = $("#user_email").val();
	if(user_email == "" || user_email == null){
		$("#email_error").html("Please enter email address.");
		err = 1;
	}else{
		var result = validateEmail(user_email);
		if(result === false){
			$("#email_error").html("Please enter valid email address.");
			err = 1;
		}else{
			$("#email_error").html("");
		}
	}
	
	if(err == 0){
	var user_name = $("#user_name").val();
	if(user_name == "" || user_name == null){
		$("#user_name").val("---");
	}
	$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/add_tradsman_information',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
			},
			success:function(resp){
				if(resp.status==1){
					$("#added_ext_tradsmans").append(resp.added_ext_tradsmans);
					$("#ext_tradesman_list").val(resp.added_ext_tradsman_email);
					$("#ext_tradesman_name_list").val(resp.added_ext_tradsman_name);
					$("#count_ext_tradsman").val(resp.added_ext_tradsman_count);
					$("#add_onclick_send_btn").html('<button type="button" onclick="send_job_info2()" class="btn btn-warning btn-lg post_btn" id="buttonpost1">Send Email</button>');
					$("#send_btn").show();
					window.location.href="#send_btn";
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	}
	return false;
}
function upload_tradsman_csv_file(){
	var err = 0;
	var csv_file = document.getElementById("tradsman_file").value;
	if(csv_file != "") {
		if( document.getElementById("tradsman_file").files.length == 0 ){
			err = 1;
		}
	}else{
		err = 1;
	}
	
	if(err == 0){
	 $.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/upload_tradsman_file',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
				$('#upload_csv_file').prop('disabled',true);
				$('#upload_csv_file').html('<i class="fa fa-spin fa-spinner"></i> Uploading...');
			},
			success:function(resp){
				if(resp.status==1){
					$('#upload_csv_file').hide();
					$("#display_csv_info_container").show();
					$("#display_csv_info").html(resp.data);
					$("#csv_file_name").val(resp.csv_file_name);
					/*$("#upload_csv_file").removeClass("btn-warning");
					$("#upload_csv_file").addClass("btn-success");
					$("#upload_csv_file").html("Email Sent");*/
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	}else{
		alert("Please upload csv file.");
	}
	return false;
}
function send_bulk_email(){
	var csv_file = $("#csv_file_name").val();
	 $.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/bulk_emails_sending/',
			data: new FormData($('#form_send_emails')[0]),
			dataType: 'JSON',
			processData: false,           
			contentType: false,
			cache: false,
			beforeSend:function (){
				$('#processing-popup').modal('show');
				$('.post_btn').prop('disabled',true);
				$('.post_btn').html('<i class="fa fa-spin fa-spinner"></i> Sending...');
			},
			success:function(resp){
				if(resp.status==1){
					$('#processing-popup').modal('hide');
					$(".post_btn").removeClass("btn-warning");
					$(".post_btn").addClass("btn-success");
					$(".post_btn").html("Email Sent");
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	return false;
}
function add_jobs_sendtype(tp){
	if(tp == 1){
		$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/add_job',
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
					$("#add_tradsman_form").show();
					window.location.href="#add_tradsman_form";
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	}else{
		$.ajax({
			type:'POST',
			url:site_url+'Admin/Send_mails_new/add_job',
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
					$("#add_bulk_form").show();
					$('#upload_csv_file').prop('disabled',false);
					$('#upload_csv_file').html('Upload');
					$('#upload_csv_file').show();
					window.location.href="#add_bulk_form";
				}
			},
			error: function(data) {alert("error");
					console.log('error');
					console.log(data);
				}
		});
	}
	return false;
}
function changesendtype(val){
	$("#add_bulk_form").hide();
	//$("#display_csv_info").html("");
	$("#display_csv_info_container").hide();
	$("#add_tradsman_form").hide();
	$("#send_btn").hide();
	if(val == 1){
		$("#add_onclick_btn").html('<button type="button" class="btn btn-warning" onclick="add_jobs_sendtype(1)">Add</button>');
		$("#job_info_form").show();
	}else if(val == 2){
		$("#add_onclick_btn").html('<button type="button" class="btn btn-warning" onclick="add_jobs_sendtype(1)">Add</button>');
		$("#job_info_form").show();
	}else if(val == 3){
		$("#add_onclick_btn").html('<button type="button" class="btn btn-warning" onclick="add_jobs_sendtype(2)">Add</button>');
		$("#job_info_form").show();
	}else{
		$("#job_info_form").hide();
		$("#send_btn").hide();
	}
	return false;
}
function changeusertype(val){
	$("#add_bulk_form").hide();
	//$("#display_csv_info").html("");
	$("#display_csv_info_container").hide();
	$("#add_tradsman_form").hide();
	$("#send_type_container").hide();
	$("#job_info_form").hide();
	$("#send_btn").hide();
	if(val == 1){
		$("#add_tradesman_btn").show();
		window.location.href="#add_tradesman_btn";
	}else if(val == 2){
		$("#add_tradesman_btn").hide();
		$("#send_type_container").show();
	}else{
		$("#add_tradesman_btn").hide();
	}
	return false;
}
</script>
<style>
.form-rounded {
border-radius: 1rem;
}
</style>
<div class="content-wrapper">
	<div class="panel panel-default" style="width:96%; margin:auto;">
		<div class="panel-heading">
			<section class="content-header">
			<h1>Send Emails</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Send Emails</li>
			</ol>
			</section>
		</div>
		<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form method="POST" name="form_send_emails" id="form_send_emails" action="" enctype="multipart/form-data">
				<div class="panel-group">
					<div class="panel panel-default" id="div_main">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group" style="margin-bottom:0px;">
									<div class="col-md-12"><label class="control-label"><b>Select who you want to send?</b></label></div>
									<div class="col-md-8">
										<select data-placeholder="Select User Type" class="form-control input-lg form-rounded" name="user_type" id="user_type" onchange="return changeusertype(this.value)">
											<option value="0">Select user type</option>
											<option value="1">Internal users( Tradesmen)</option>
											<option value="2">External users( Tradesmen)</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="add_tradesman_btn" style="display:none;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="col-md-12"><label class="control-label"><b>Tradesman</b></label> </div>
								<div class="col-md-12" id="selected_tradesman"></div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-2" style=" margin-left:0px; padding:0px;">&nbsp;</div>
								<div class="col-md-9 border border-dark" style=" margin-left:0px; padding:0px;">
									<a class="btn btn-warning" href="" data-toggle="modal" data-target="#tradesman-popup">Add Tradesman</a>
								</div>
								<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							</div>
						</div>
					</div>
					<div class="modal fade popup" id="tradesman-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Tradesman</h4>
								</div>
								<div class="modal-body">
									<fieldset>
									<!-- Text input-->
									<div class="form-group">
										<label class="col-md-12 control-label" for="textinput">Select Tradesman</label>  
										<div class="col-md-12"> 
											<select data-placeholder="Select Tradesman" class="form-control input-md chosen-select form-rounded" multiple style="width:350px;" tabindex="4" name="tradesman[]" id="tradesman">
											<?php 
											//$selected_lang = ($user_profile['category'])?explode(',',$user_profile['category']):array();

											foreach($tradesmans as $row) { 
											//$selected = (in_array($row['cat_id'],$selected_lang))?'selected':'';
											?>
											<option value="<?= $row['id']; ?>"> <?= $row['f_name']; ?> <?= $row['l_name']; ?></option>
											<?php } ?>
											</select>   
											<input type="hidden" name="trades" value="trades">
										</div>
									</div>
									</fieldset>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-warning submit_btn11" onclick="add_tradesman()">Add</button>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default" id="send_type_container" style="display:none; margin-top:10px;">
						<div class="panel-body">
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
								<div class="form-group" style="margin-bottom:0px;">
									<div class="col-md-12"><label class="control-label"><b>Select send type?</b></label></div>
									<div class="col-md-8">
										<select data-placeholder="Select User Type" class="form-control input-lg form-rounded" name="send_type" id="send_type" onchange="return changesendtype(this.value)">
											<option value="0">Select send type</option>
											<option value="1">Single job post to 1 or 2 external users</option>
											<option value="2">Multiple job Post to 1 or 2 external users</option>
											<option value="3">Bulk job Post  to multiple users ( Tradesmen)</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
					<div class="panel panel-default" id="job_info_form" style="display:none;">
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
										</div>
									</div>
									</fieldset>
								</div>
								<div class="modal-footer">
									<div class="col-md-12">
										<div class="col-md-8">&nbsp;</div>
										<div class="col-md-2"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
										<div class="col-md-2" id="add_onclick_btn"><button type="button" class="btn btn-warning" onclick="add_jobs()">Add</button></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="panel panel-default" id="add_tradsman_form" style="display:none;margin-top:10px;">
					<div class="panel-body">
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
							<div class="col-md-12">
								<div class="form-group" style="margin-bottom:0px;">
									<div class="col-md-12"><label class="control-label"><b>External Tradsman</b></label> </div>
									<div class="col-md-12" id="added_ext_tradsmans"></div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5">
									<div class="form-group">
										<label class="control-label"><b>Tradesman Email</b></label>
										<input type="text" placeholder="Tradesman Email" class="form-control form-rounded" name="user_email" id="user_email">
										<span class="help-block error" id="email_error" style="color:red;"></span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label"><b>Tradesman Name</b></label>
										<input type="text" placeholder="Tradesman Name" class="form-control form-rounded" name="user_name" id="user_name">
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label class="control-label">&nbsp;</label>
										<button type="button" class="btn btn-primary" name="add_ex" id="add_ex" onclick="add_tradsman_info()">Add Tradsman</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
					</div>
				</div>
				<div class="panel panel-default" id="add_bulk_form" style="display:none;">
					<div class="panel-body">
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label"><b>Add Tradsman CSV File</b></label>
										<input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" placeholder="Tradesman CSV File" class="form-control" name="tradsman_file" id="tradsman_file">
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label class="control-label">&nbsp;</label>
										<button type="button" class="btn btn-primary" name="upload_csv_file" id="upload_csv_file" onclick="upload_tradsman_csv_file()">Upload</button>
									</div>
								</div>
								<div class="col-md-6">&nbsp;</div>
							</div>
						</div>
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
					</div>
				</div>
				<div class="panel panel-default" id="display_csv_info_container" style="display:none;">
					<div class="panel-body">
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						<div class="col-md-10 border border-dark" style=" margin-left:0px; padding:0px;">
							<div class="col-md-12"><label class="control-label"><b>External Tradsman from CSV</b></label> </div>
							<div class="col-md-12" id="display_csv_info"></div>
						</div>
						<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-2" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-9 border border-dark" style=" margin-left:0px; padding:0px;">
								<input type="hidden" name="csv_file_name" id="csv_file_name">
								<button type="button" name="send_bulk" id="send_bulk" onclick="send_bulk_email()" class="btn btn-warning btn-lg post_btn">Send Email</button>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default" id="send_btn" style="display:none;">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-2" style=" margin-left:0px; padding:0px;">&nbsp;</div>
							<div class="col-md-9" style=" margin-left:0px; padding:0px;">
								<div class="form-group" style="margin-bottom:0px;">
									<input type="hidden" name="count_ext_tradsman" id="count_ext_tradsman" value="0" />
									<input type="hidden" name="ext_tradesman_list" id="ext_tradesman_list" value="" />
									<input type="hidden" name="ext_tradesman_name_list" id="ext_tradesman_name_list" value="" />
									<input type="hidden" name="tradesman_list" id="tradesman_list" value="" />
									<input type="hidden" name="jobs_list" id="jobs_list" value="" />
									<input type="hidden" name="is_set_tradsman" id="is_set_tradsman" value="0" />
									<input type="hidden" name="is_set_job" id="is_set_job" value="0" />
									<div id="add_onclick_send_btn"><button type="button" onclick="send_job_info1()" class="btn btn-warning btn-lg post_btn" id="buttonpost1">Send Email</button></div>
								</div>
							</div>
							<div class="col-md-1" style=" margin-left:0px; padding:0px;">&nbsp;</div>
						</div>
					</div>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="processing-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header" style="background-color:#6971A4; color:#FFFFFF; height:60px;">
						<h3 class="modal-title" id="exampleModalLabel">Work in progress...</h3>
					  </div>
					  <div class="modal-body">
						<div class="text-center">
							<span class="fa fa-spinner fa-spin fa-3x"></span> Processing...
						</div>
							<!--<div class="text-center">
							  <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
								<span class="sr-only">Processing...</span>
							  </div>
							</div>-->
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					  </div>
					</div>
				  </div>
				</div>
				</form>
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
</script>
	