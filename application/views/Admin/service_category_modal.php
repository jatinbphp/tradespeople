<div class="modal fade in" id="service_category_modal">
 	<div class="modal-body" id="msg">
    <div class="modal-dialog">	 
       <div class="modal-content">         	
	  		<form method="post" id="service_category_form" enctype="multipart/form-data">
          <div class="modal-header">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body form_width100">
          	<div class="form-group" id="main-cat-div">
							<label for="main_category"> Main Category:</label>
							<select name="main_category" id="main_category" class="form-control" onchange="getSubCategory(this.value)">
								<option value=''>Select</option>
								<?php foreach($data['parent_category'] as $key => $val): ?>
									<?php $selected = $data['main_service']['original_cat_id'] == $val['cat_id'] ? 'selected' : ''; ?>
									<option value="<?php echo $val['cat_id']; ?>" <?php echo $selected; ?> ><?php echo $val['cat_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="sub_category"> Sub Category:</label>
							<select name="sub_category[]" id="sub_category" class="form-control" multiple>
								<option value=''>Select</option>
							</select>
						</div>

						<div class="form-group">
							<label for="service_type_category"> Service Type:</label>
							<select name="service_type_category[]" id="service_type_category" class="form-control select2" multiple>
								<option value=''>Select</option>								
							</select>
							<span class="text-muted">Add atleast 3 service types. Use letters and numbers only.</span>
						</div>

						<div class="form-group">
							<label id="addAttribute" onclick="addAttribute()"><i class="fa fa-plus"></i> Add Attributes:</label>							
							<div id="attributeList">
								<?php echo $data['attributeList']; ?>
							</div>
						</div>

						<div class="form-group">
							<label id="addExService" onclick="addextraService()"><i class="fa fa-plus"></i> Add Extra Service:</label>
							<div id="exServiceList">
								<?php echo $data['exServicesList']; ?>
							</div>
						</div>

						<div class="form-group">
							<label> Price Per Unit:</label>
							<label class="switch pull-right">
								<?php
									$checked = $data['main_service']['price_type'] == 1 ? 'checked' : '';
									$class = $data['main_service']['price_type'] == 1 ? '' : 'hide';
								?>
								<input type="checkbox" name="price_type" id="price_type" <?php echo $checked; ?> >
								<span class="switch-slider round"></span>						  
							</label>
						</div>

						<div class="form-group <?php echo $class; ?>" id="priceUnitListDiv">
							<label id="addPriceUnit" onclick="addPriceUnit()"><i class="fa fa-plus"></i> Add Price Unit:</label>							
							<div id="priceUnitList">
								<?php echo $data['priceUnitList']; ?>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email"> Slug:</label>
							<input type="text" name="slug" id="slug0" value="<?php echo $data['main_service']['slug']; ?>" class="form-control" required>
							<p class="text-danger">Special characters are not allowed except dash(-) and underscore(_).</p>
						</div>

			 	 		<div class="form-group">
							<label for="email"> Description:</label>
							<textarea rows="5" placeholder="" name="cat_description" id="cat_description" class="form-control"><?php echo $data['main_service']['cat_description']; ?></textarea>
			 			</div>

					 	<div class="form-group hide">
							<label for="description0"> Description (For find job page):</label>
							<textarea rows="5" placeholder="" name="description" id="description0" class="form-control"><?php echo $data['main_service']['description']; ?></textarea>
					 	</div>

					 	<div class="form-group">
							<label for="email"> Meta Title:</label>
							<input type="text" name="meta_title" id="meta_title" class="form-control" value="<?php echo $data['main_service']['meta_title']; ?>" >
					 	</div>

			 			<div class="form-group">
							<label for="email"> Meta Keywords:</label>
							<input type="text" name="meta_key" id="meta_key" class="form-control" value="<?php echo $data['main_service']['meta_key']; ?>" >
			 			</div>

					 	<div class="form-group">
							<label for="email"> Meta Description:</label>
							<textarea rows="5" placeholder="" name="meta_description" id="meta_description" class="form-control"><?php echo $data['main_service']['meta_description']; ?></textarea>
					 	</div>

			 			<div class="form-group">
							<label for="email"> Footer Description:</label>
							<textarea rows="5" placeholder="" name="footer_description" id="footer_description" class="form-control textarea"><?php echo $data['main_service']['footer_description']; ?></textarea>
			 			</div>
          </div>
          <div class="modal-footer">
          	<input type="hidden" value="<?php echo !empty($data['catId']) ? $data['catId'] : 0; ?>" id="service_cat_id">
          	<button type="button" onclick="submitServiceCategory(<?php echo $data['formType']; ?>, <?php echo $data['catId']; ?>)" class="btn btn-info signup_btn" >Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
		   </form>
          </div>			
       </div>
    </div>
 </div>

<script src="<?php echo base_url(); ?>asset/admin/dist/js/select2.full.min.js"></script>  

<script>
    $(function(){
        $('.select2').select2();    
    });
</script>