<?php include 'include/header.php'; ?>

<div class="acount-page membership-page">
<div class="container">
    	<div class="user-setting">
        	<div class="row">
            	<div class="col-sm-3">
                	<?php include 'include/sidebar.php'; ?>
                </div>
            	<div class="col-sm-9">
                <div class="user-right-side">
                  <h1>Category</h1>
                  <!-- Edit-section-->
                  
                  <div class="edit-user-section">
                    
                    
                    
                    <div class="msg"><?= $this->session->flashdata('msg');?></div>
                    <div class="msg3"><?= $this->session->flashdata('msg3');?></div>
                    <div class="row">
                      <?php if($this->session->userdata('type')==1){ ?>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <?php if(!empty($user_profile['category'])){ ?>
                          <?php
                          
                          $selected_lang = explode(',',$user_profile['category']);
                          
                          foreach($category as $row) {
                          if(in_array($row['cat_id'],$selected_lang))
                          {
                          ?>
                          <p id="del_doc<?php echo $row['cat_id']; ?>" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm"> <button type="button" class="btn btn-danger btn-xs" onclick="delete_cat(<?php echo $row['cat_id'];?>)"><i class="fa fa-close"></i></button> <?= $row['cat_name']; ?></p><?php
                          }
                          ?>
                          
                          <?php } ?>
                          <?php } else{ ?>
                          <p>No Category Added</p>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } ?>
                      
                    </div>
                    
                  </div>
                  <!-- Edit-section-->
                  
                  <!-- Edit-section-->
                  <div class="edit-user-section gray-bg">
                    <div class="row nomargin">
                      <div class="col-sm-12">
                        <a class="btn btn-warning" href="" data-toggle="modal" data-target="#category-popup">Add Another Category</a>
                        
                      </div>
                    </div>
                  </div>
                  <div class="modal fade popup" id="category-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Category</h4>
                        </div>
                        <form method="POST" id="skilledit" action="<?php echo base_url('users/update_catgory/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data">
                          <div class="modal-body">
                            <fieldset>
                              
                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-12 control-label" for="textinput">Select Category</label>
                                <div class="col-md-12">
                                  <select data-placeholder="Select Category" class="form-control input-md chosen-select" multiple style="width:350px;" tabindex="4" name="category[]">
                                    
                                    <?php
                                    $selected_lang = ($user_profile['category'])?explode(',',$user_profile['category']):array();
                                    foreach($parent_category as $row) {
                                    $selected = (in_array($row['cat_id'],$selected_lang))?'selected':'';
                                    ?>
                                    <option <?= $selected; ?> value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
                                    <?php } ?>
                                  </select>
                                  <input type="hidden" name="trades" value="trades">
                                </div>
                              </div>
                            </fieldset>
                            
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning submit_btn11">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Edit-section-->
                  
                  
                  
                </div>
                <br><hr>
                <div class="user-right-side">
                  <h1>Subcategory</h1>
                  <!-- Edit-section-->
                  
                  <div class="edit-user-section">
                    
                    
                    
                    <div class="msg"><?= $this->session->flashdata('msg');?></div>
                    <div class="msg3"><?= $this->session->flashdata('msg3');?></div>
                    <div class="row">
                      <?php if($this->session->userdata('type')==1){ ?>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <?php if(!empty($user_profile['subcategory'])){ ?>
                          <?php
                          
                          $selected_lang = explode(',',$user_profile['subcategory']);
                          
                          foreach($category as $row) {
                          if(in_array($row['cat_id'],$selected_lang))
                          {
                             if (strtolower(trim($row['cat_name'])) == "others" || strtolower(trim($row['cat_name'])) == "other") {
                              continue;
                            }
                          ?>
                          <p id="del_doc<?php echo $row['cat_id']; ?>" style="white-space: inherit; margin: 3px; text-align: left;" class="btn btn-default btn-sm"> <button type="button" class="btn btn-danger btn-xs" onclick="delete_subcat(<?php echo $row['cat_id'];?>)"><i class="fa fa-close"></i></button> <?= $row['cat_name']; ?></p><?php
                          }
                          ?>
                          
                          <?php } ?>
                          <?php } else{ ?>
                          <p>No Category Added</p>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } ?>
                      
                    </div>
                    
                  </div>
                  <!-- Edit-section-->
                  
                  <!-- Edit-section-->
                  <div class="edit-user-section gray-bg">
                    <div class="row nomargin">
                      <div class="col-sm-12">
                        <a class="btn btn-warning" href="" data-toggle="modal" data-target="#subcategory-popup">Add Another Subcategory</a>
                        
                      </div>
                    </div>
                  </div>
                  <div class="modal fade popup" id="subcategory-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Subcategory</h4>
                        </div>
                        <form method="POST" id="skilledit" action="<?php echo base_url('users/update_subcatgory/'.$this->session->userdata('user_id')); ?>" enctype="multipart/form-data">
                          <div class="modal-body">
                            <fieldset>
                              
                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-12 control-label" for="textinput">Select Subcategory</label>
                                <div class="col-md-12">
                                  <select data-placeholder="Select Category" class="form-control input-md chosen-select" multiple style="width:350px;" tabindex="4" name="subcategory[]">
                                    
                                    <?php
                                    $selected_lang = ($user_profile['subcategory'])?explode(',',$user_profile['subcategory']):array();
                                    $categories = ($user_profile['category'])?explode(',',$user_profile['category']):array();
                                    $subcategories = [];
                                    foreach($categories as $parent)
                                    {

                                      $subcat = $this->common_model->GetAllData('category' , array('cat_parent' => $parent));
                                      foreach($subcat as $row)
                                      {
                                        array_push($subcategories, $row['cat_id']);
                                      }
                                      
                                      
                                    }
                                   // print_r($subcategories);print_r($categories);die();
                                    
                                    $this->db->where_in('cat_id' , $subcategories);
                                    $category = $this->db->get('category')->result_array();
                                    foreach($category as $row) {
                                    $selected = (in_array($row['cat_id'],$selected_lang))?'selected':'';

                                    if (strtolower(trim($row['cat_name'])) == "others" || strtolower(trim($row['cat_name'])) == "other") {
                                      continue;
                                    }
                                    ?>

                                    <option <?= $selected; ?> value="<?= $row['cat_id']; ?>"> <?= $row['cat_name']; ?> </option>
                                    <?php $allchild = $this->common_model->get_all_child($row['cat_id']);
                                   // print_r($allchild); die;
                                      foreach($allchild as $nchild) { 
                                        $selected = (in_array($nchild ,$selected_lang))?'selected':'';
                                        $nchild = getRecordOnId('category' , array('cat_id' => $nchild));
                                        if (strtolower(trim($nchild['cat_name'])) == "others" || strtolower(trim($nchild['cat_name'])) == "other") {
                                            continue;
                                          } 
                                        ?>
                                        <option <?= $selected; ?> value="<?= $nchild['cat_id']; ?>"> <?= $nchild['cat_name']; ?> </option>

                                    <?php } } ?>
                                  </select>
                                  <input type="hidden" name="trades" value="trades">
                                </div>
                              </div>
                              <?php print_r($ids); ?>
                            </fieldset>
                            
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning submit_btn11">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Edit-section-->
                  
                  
                  
                </div>
                </div>
            </div>
        </div>
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
  $('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});
  function delete_cat(id) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_category/'+id,
            dataType: 'JSON',
             success:function(resp){
              $('#del_doc'+id).remove();
              location.reload();
            } 
        });
  }function delete_subcat(id) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_subcategory/'+id,
            dataType: 'JSON',
             success:function(resp){
              $('#del_doc'+id).remove();
              location.reload();
            } 
        });
  }
</script>
	