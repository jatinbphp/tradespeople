<?php 
include_once('include/header.php');
if(!in_array(9,$my_access)) { redirect('Admin_dashboard'); }

$get_commision=$this->Common_model->get_commision(); 

$closed_date=$get_commision[0]['closed_date'];
?>
<style>
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit job</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit job</li>
    </ol> 
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
					<div class="box-body">
						<div class="row"> 
							<div class="col-sm-12">			
								<form method="POST" action="" id="update_job" onsubmit="return update_job();" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?php echo $post['job_id']; ?>">
									<div class="edit-user-section"> 
										<div class="msg"><?php echo $this->session->flashdata('msg'); ?></div>
										
										<div class="row">
											<div class="col-sm-12">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b>Job title</b></label>  
													<div class="col-md-12">
														<input id="title" name="title" placeholder="Job title" class="form-control input-md" type="text" value="<?php echo $post['title']; ?>" required="">
													</div>
												</div>
											</div>
										</div>
										<div class="">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b>Budget 1</b></label>  
													<div class="col-md-12 input-group">
														<span class="input-group-addon">£</span>
														<input id="budget" name="budget" placeholder="Job title" class="form-control input-md" type="number" value="<?php echo $post['budget']; ?>" required="">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b>Budget 2</b></label>  
													<div class="col-md-12 input-group">
														<span class="input-group-addon">£</span>
														<input id="budget2" name="budget2" placeholder="budget 2" class="form-control input-md" type="number" value="<?php echo $post['budget2']; ?>" required="">
													</div>
												</div>
											</div>
										</div>	
										<div class="add-space"><br></div>
										<div class="row">
											<div class="col-sm-12">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b>Description</b></label>  
													<div class="col-md-12">
														<textarea id="description" name="description" placeholder="Description" class="form-control textarea2" required=""><?php echo $post['description']; ?></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										<div class="row">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b>What would you like to have done?</b></label>  
													<div class="col-md-12">
														<select id="category" name="category" class="form-control" required=""  onchange="return changecategory(this.value)">
															<option value="">Pick Category</option>
															<?php foreach($category as $row) { ?>
															<option <?php echo ($row['cat_id']==$post['category']) ? 'selected' : ''; ?> value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										<?php
										if(count($cate_arr) > 1) {
											
											$show_cate2 = $cate_arr[1];
											
											$cate_data2 = $this->Common_model->get_single_data('category',array('cat_id'=>$cate_arr[0]));
											
											$data_set2 = $this->Common_model->newgetRows('category',array('cat_parent'=>$cate_arr[0],'is_delete'=>0));
											
										} else {
											
											$show_cate2 = false;
										}
										?>
										
										<div class="row" id="div_2" style="display: <?php echo ($show_cate2) ? 'block' : 'none'; ?>;">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b id="cate_level_1"><?php echo ($show_cate2) ? 'What type of '.$cate_data2['cat_name'].' work do you need?' : ''; ?> </b></label>  
													<div class="col-md-12" id="subcategories">
														<?php if($show_cate2) { ?>
														
														<div class="row"> 
														<?php 
														foreach($data_set2 as $subcategory){
															$selected2 = ($show_cate2==$subcategory['cat_id']) ? 'checked' : '';
															echo '<div class="col-sm-6"><div class="radio-how"><label><input type="radio" name="subcategory" '.$selected2.' onchange="return changesub($(this).val())" id="subcategory'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'"> '.$subcategory['cat_name'].'<span class="outside"><span class="inside"></span></span></label></div></div>';
															
														}
														
														?>
														</div>
														
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										<?php
										if(count($cate_arr) > 2) {
											
											$show_cate3 = $cate_arr[2];
											
											$cate_data3 = $this->Common_model->get_single_data('category',array('cat_id'=>$cate_arr[1]));
											
											$data_set3 = $this->Common_model->newgetRows('category',array('cat_parent'=>$cate_arr[1],'is_delete'=>0));
											
										} else {
											
											$show_cate3 = false;
										}
										?>
										
										<div class="row" id="div_9" style="display: <?php echo ($show_cate3) ? 'block' : 'none'; ?>;">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b id="cate_level_2"><?php echo ($show_cate3) ? 'What type of '.$cate_data3['cat_name'].' work do you need?' : ''; ?></b></label>  
													<div class="col-md-12" id="subcategories_1">
														<?php if($show_cate3) { ?>
														
														<div class="row"> 
														<?php 
														foreach($data_set3 as $subcategory){
															$selected3 = ($show_cate3==$subcategory['cat_id']) ? 'checked' : '';
															echo '<div class="col-sm-6"><div class="radio-how"><label><input type="radio" name="subcategory_2" '.$selected3.' onchange="return changesub_sub($(this).val())" id="subcategory'.$subcategory['cat_id'].'" value="'.$subcategory['cat_id'].'"> '.$subcategory['cat_name'].'<span class="outside"><span class="inside"></span></span></label></div></div>';
															
														}
														
														?>
														</div>
														
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										<div class="row" id="div_10" style="display: none;">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for=""><b id="cate_level_3">What would you like to have done? </b></label>  
													<div class="col-md-12" id="subcategories_2">
													
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										<div class="row">
											<div class="col-sm-6">
												<!-- Text input-->
												<div class="form-group">
													<label class="col-md-12 control-label" for="">Postcode for the job</label>  
													<div class="col-md-12">
														<input id="post_code" name="post_code" placeholder="Postcode for the job" class="form-control" type="text" value="<?php echo $post['post_code']; ?>" required="">
														<p class="text-danger postcode-err" style="display:none;">Please enter valid UK postcode</p>
													</div>
												</div>
											</div>
										</div>
										<div class="add-space"><br></div>
										
																			
										<div class="row">
											<div class="col-sm-12 text-center" style="margin-top: 15px;">
												<div class="form-group">
													<button type="submit" class="btn btn-primary submit_btn">Update Job</button>
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
  </section>

</div>
<script>
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea2',
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
function changecategory(val){
	
	//$("html, body").animate({ scrollTop: $(document).height() }, 10);	
	$.ajax({
		url:site_url+'home/get_subcategories',
		type:"POST",
		dataType:'json',
		data:{'val':val},
		success:function(datas){
			$("#div_9").hide();
			$("#div_10").hide();
			if(datas.status==1){
				$('#subcategories').html(datas.subcategory);
				$('#cate_level_1').html(datas.label);
				$("#div_2").show();
			}
			return false;
		}
	});
	return false;
}

function changesub(val){
 if($('#subcategory'+val).is(':checked')) { 
		$.ajax({
			url:site_url+'home/get_subcategories_sub2',
			type:"POST",
			dataType:'json',
			data:{'val':val},
			success:function(datas){
				$("#div_10").hide();
				if(datas.status==1){
					$('#subcategories_1').html(datas.subcategory);
					$('#cate_level_2').html(datas.label);
					$("#div_9").show();
				} else {
					$("#div_9").hide();
				}
				return false;
			}
		});
	}
}

function update_job(){
	$.ajax({
		url:site_url+'Admin/post/update_job',
		type:"POST",
		dataType:'json',
		data:$('#update_job').serialize(),
		beforeSend:function(){
			$('.postcode-err').hide();
			$('.submit_btn').prop('disabled',true);
			$('.msg').html('');
		},
		success:function(res){
			$("#div_10").hide();
			if(res.status==1){
				location.reload();
			} else if(res.status==2){
				$('.postcode-err').show();
				$('.submit_btn').prop('disabled',false);
			} else {
				$('.msg').html(res.msg);
				$('.submit_btn').prop('disabled',false);
			}
			
		}
	});
	return false;
}

function changesub_sub(val) {
 
}

function changesub_sub_sub(val) {
 
}
</script>
<?php include_once('include/footer.php'); ?>



  