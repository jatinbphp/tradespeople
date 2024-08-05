<div class="modal fade in" id="service_category_modal">
 	<div class="modal-body" id="msg">
    <div class="modal-dialog">	 
       <div class="modal-content">         	
	  		<form method="post" id="service_category_form" enctype="multipart/form-data">
          <div class="modal-header">
            <div class="msg"><?= $this->session->flashdata('msg'); ?></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Add Service Category</h4>
          </div>
          <div class="modal-body form_width100">
          	<div class="form-group">
							<label for="email"> Main Category:</label>
							<input type="text" name="main_category" id="main_category" onkeyup="create_slug(0,this.value,0);" class="form-control" value="<?php echo $data['main_service']['cat_name']; ?>" required>
						</div>

						<div class="form-group">
							<label for="email"> Sub Category:</label>
							<input type="text" name="sub_category" value="<?php echo $data['subCategory']['cat_name']; ?>" id="sub_category" onkeyup="create_slug(0,this.value,1);" class="form-control" required>
							<input type="hidden" name="sub_category_slug" value="<?php echo $data['subCategory']['slug']; ?>" id="slug1" class="form-control">
						</div>

						<div class="form-group">
							<label for="email"> Service Type:</label>
							<input id="service_type_category" value="<?php echo $data['service_type_name']; ?>" name="service_type_category"  placeholder="Service Type" class="form-control input-md" data-role="tagsinput" type="text" value="">
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
								?>
								<input type="checkbox" name="price_type" id="price_type" <?php echo $checked; ?> >
								<span class="switch-slider round"></span>						  
							</label>
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
          	<button type="button" onclick="submitServiceCategory(<?php echo $data['formType']; ?>, <?php echo $data['catId']; ?>)" class="btn btn-info signup_btn" >Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
		   </form>
          </div>			
       </div>
    </div>
 </div>