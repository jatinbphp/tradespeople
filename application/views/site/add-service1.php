<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
    <div class="edit-user-section">
        <!-- <div class="msg"><?= $this->session->flashdata('msg');?></div> -->
        <div class="row">
            <div class="col-sm-12">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Service Title</label>
                    <div class="col-md-12">
                        <input id="service" value="<?php echo $serviceData['service_name'] ?? '' ?>" name="service_name" placeholder="Service Title" class="form-control input-md" type="text" required>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">
                        About Your Service 
                    </label>
                    <div class="col-md-12">
                        <textarea class="form-control input-md" name="description" id="description" placeholder="Description" rows="10"><?php echo $serviceData['description'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Location</label>
                    <div class="col-md-12">
                        <select class="form-control input-md" name="location"  id="city_id">
                            <option value="">Select Location</option>
                            <?php $selected = $serviceData['location'] ?? '' ?>
                            <?php foreach ($cities as $city) { ?>
                                <option <?php echo (($selected == $city['city']) ? 'selected' : '') ?> value="<?php echo $city['city']; ?>">
                                    <?php echo $city['city']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Price</label>
                    <div class="col-md-12">
                        <input id="price" value="<?php echo $serviceData['price'] ?? '' ?>" name="price" placeholder="Price" class="form-control input-md" type="text" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">
                        Positive Keywords
                    </label>
                    <div class="col-md-12">
                        <input id="positive_keywords" value="<?php echo $serviceData['positive_keywords'] ?? '' ?>" name="positive_keywords"  placeholder="Positive Keywords" class="form-control input-md" data-role="tagsinput" type="text" value="">
                        <span class="text-muted">5 tags maximum. Use letters and numbers only.</span>
                    </div>
                </div>
            </div>									
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">
                        Upload Image/Video (Optional)
                    </label>
                    <div class="col-md-6">
                        <div id="imageContainer">
                            <img src="<?php echo base_url()?>img/plus2.png" alt="Click to select image">
                            <input type="file" name="image" id="profile" class="form-control input-md" accept="image/*" onchange="return seepreview();">
                        </div>
                        <input type="hidden" name="service_image_old" value="" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="imgpreview">
            <?php $image_path = FCPATH . 'img/services/' . ($serviceData['image'] ?? ''); ?>
            <?php if(file_exists($image_path) && $serviceData['image']): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style='padding-left:30px'>
                    <div class="boxImage imgUp">
                        <div class="imagePreviewPlus">
                            <img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/').$serviceData['image']; ?>" alt="Image">
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>								
    </div>                        
    <div class="edit-user-section gray-bg">
        <div class="row nomargin">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary submit_btn">Continue</button>
            </div>                                 
        </div>
    </div>                        
</form>