<form action="<?= $url; ?>" method="post" enctype="multipart/form-data">  
    <div class="edit-user-section">
        <!-- <div class="msg"><?= $this->session->flashdata('msg');?></div> -->
        <div class="row">
            <div class="col-sm-12">
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Service Title</label>
                    <div class="col-md-12">
                        <input id="service" value="<?php echo $serviceData['service_name'] ?? '' ?>" name="service_name" placeholder="Service Title" class="form-control input-md" type="text" onkeypress="getSuggestedCategory(this.value)" required>
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
                    <label class="col-md-12 control-label" for="">Main Category</label>
                    <div class="col-md-12">
                        <select class="form-control input-md mainCategory" name="category" data-section="subcategories" id="category">
                            <option value="">Select Category</option>
                            <?php $selected = $serviceData['category'] ?? '' ?>
                            <?php foreach ($category as $cat) { ?>
                                <option <?php echo (($selected == $cat['cat_id']) ? 'selected' : '') ?> value="<?php echo $cat['cat_id']; ?>">
                                    <?php echo $cat['cat_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>           

            <div class="col-sm-12 hidden" id="subcategories_div">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Sub Category</label>
                    <div class="col-md-12">
                        <!--<select class="form-control input-md subCategory categories" name="sub_category" data-section="service_type" id="sub_category">
                            <option value="">Select Sub Category</option>
                        </select>-->
                        <div id="subcategories"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-3 pl-5 hidden" id="suggestedCategory"></div>

            <div class="col-sm-12 hidden" id="service_type_div">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="">Service Type</label>
                    <div class="col-md-12">
                        <!--<select class="form-control input-md serviceType categories" name="service_type" data-section="plugins" id="service_type">
                            <option value="">Select Service Type</option>
                        </select>-->
                        <div id="subcategories_1"></div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="location">Location</label>
                    <div class="col-md-12">
                        <select class="form-control input-md" name="location" id="location">
                            <option value="">Select Location</option>
                            <?php $selected = $serviceData['location'] ?? '' ?>
                            <?php foreach ($cities as $city) { ?>
                                <option <?php echo $selected == $city['id'] ? 'selected' : ''; ?> value="<?php echo $city['id']; ?>">
                                    <?php echo $city['city_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 <?php echo isset($serviceData) && !empty($serviceData['area']) ? '' : 'hidden'; ?>" id="townDiv">
                <div class="form-group">
                    <label class="col-md-12 control-label" for="city">City/Town</label>
                    <div class="col-md-12">
                        <select class="form-control input-md" name="area" id="area">
                            <?php if(!empty($all_area)):?>
                                <?php foreach($all_area as $area):?>
                                    <option value="<?php echo $area; ?>" <?php echo $serviceData['area'] == $area ? 'selected' : ''; ?> ><?php echo $area; ?></option>
                                <?php endforeach;?>
                            <?php endif;?>    
                        </select>
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
            <?php if (file_exists($image_path) && $serviceData['image']): ?>
                <?php
                $mime_type = get_mime_by_extension($image_path);
                $is_image = strpos($mime_type, 'image') !== false;
                $is_video = strpos($mime_type, 'video') !== false;
                ?>
                <?php if ($is_image): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style='padding-left:30px'>
                        <div class="boxImage imgUp">
                            <div class="imagePreviewPlus">
                                <img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/') . $serviceData['image']; ?>" alt="Image">
                            </div>
                        </div>
                    </div>
                <?php elseif ($is_video): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12" style='padding-left:30px'>
                        <div class="imgUp">
                            <div class="videoPreviewPlus">
                                <video 
                                    src="<?php echo base_url('img/services/') . $serviceData['image']; ?>" 
                                    type="<?php echo $mime_type; ?>" 
                                     loop 
                                    class="serviceVideo">
                                </video>
                            <svg id="play-control-btn" class="playing" width="30" height="30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100">
                                <path id="border" fill="none" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" d="M50,2.9L50,2.9C76,2.9,97.1,24,97.1,50v0C97.1,76,76,97.1,50,97.1h0C24,97.1,2.9,76,2.9,50v0C2.9,24,24,2.9,50,2.9z"/>
                                <path id="bar" fill="none" stroke="#fff" stroke-width="4.5" stroke-miterlimit="10" d="M50,2.9L50,2.9C76,2.9,97.1,24,97.1,50v0C97.1,76,76,97.1,50,97.1h0C24,97.1,2.9,76,2.9,50v0C2.9,24,24,2.9,50,2.9z" style="transition: all .3s;"/>
                                <g id="pause">
                                    <g>
                                        <path fill="#fff" d="M46.1,65.7h-7.3c-0.4,0-0.7-0.3-0.7-0.7V35c0-0.4,0.3-0.7,0.7-0.7h7.3c0.4,0,0.7,0.3,0.7,0.7V65 C46.8,65.4,46.5,65.7,46.1,65.7z"/>
                                        <path fill="#fff" d="M61.2,65.7h-7.3c-0.4,0-0.7-0.3-0.7-0.7V35c0-0.4,0.3-0.7,0.7-0.7h7.3c0.4,0,0.7,0.3,0.7,0.7V65 C61.9,65.4,61.6,65.7,61.2,65.7z"/>
                                    </g>
                                </g>
                                <g id="play">
                                    <path fill="#fff" d="M41.1,33.6l24.5,15.6c0.6,0.4,0.6,1.1,0,1.5L41.1,66.4c-0.7,0.5-1.8,0-1.8-0.7V34.4 C39.3,33.6,40.4,33.2,41.1,33.6z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
    <?php endif; ?>
<?php endif; ?>
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

<script type="text/javascript">
    // $('#price_per_type').on('change', function(){
    //     var priceType = $(this).val();
    //     $('#priceLabel').text('How much do you charge per '+priceType.toLowerCase()+'?');
    // });

    var subCategory = 1;
    var serviceType = 1;
    var priceType = 1;
    var plugin = 1;
    $('.mainCategory').on('change', function(){
        var cat_id = $(this).val();
        var sectionId = $(this).attr('data-section');
        $('.categories').empty();
        $('.categories_div').addClass('hidden');
        $.ajax({
            url:site_url+'users/getSubCategory',
            type:"POST",
            data:{'cat_id':cat_id,'type':1},
            success:function(data){
                if(data != ""){
                    $('#'+sectionId+'_div').removeClass('hidden');
                    $('#'+sectionId).empty().html(data);
                }else{
                    $('#'+sectionId+'_div').addClass('hidden');
                }
            }
        });
    });

    $('.subCategory').on('change', function(){
        var cat_id = $(this).val();
        var sectionId = $(this).attr('data-section');
        $.ajax({
            url:site_url+'users/getSubCategory',
            type:"POST",
            data:{'cat_id':cat_id,'type':2},
            success:function(data){
                if(data != ""){
                    $('#'+sectionId+'_div').removeClass('hidden');
                    $('#'+sectionId).empty().html(data);
                    <?php if(isset($serviceData['service_type']) && $serviceData['service_type']): ?>
                        if(serviceType == 1){
                            $('.serviceType').val(<?php echo $serviceData['service_type'] ?? '' ?>);
                            $('.serviceType').trigger('change');
                            serviceType = 0;
                        }else{
                            serviceType = 0;
                        }
                    <?php endif ?>
                }else{
                    $('#'+sectionId+'_div').addClass('hidden');
                }
            }
        });
    });

    function changesub(){
        var checkedValues = $('.subCategory:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            url:site_url+'users/getSubCategory',
            type:"POST",
            data:{'cat_id':checkedValues,'type':2},
            success:function(data){
                if(data != ""){
                    $('#service_type_div').removeClass('hidden');
                    $('#subcategories_1').empty().append(data);                        
                }else{
                    $('#service_type_div').addClass('hidden');
                    $('#subcategories_1').empty(); 
                }
            }
        });
    }

    $(document).ready(function(){
        <?php if(isset($serviceData['category']) && $serviceData['category']): ?>
            $('.mainCategory').val(<?php echo $serviceData['category'] ?? '' ?>);
            $('.mainCategory').trigger('change');
            setTimeout(changesub, 2000);            
        <?php endif ?>
    });

    function getSuggestedCategory(title){
        $.ajax({
            url:site_url+'users/getSuggestedCategory',
            type:"POST",
            data:{'title':title},
            success:function(data){
                if(data != ""){
                    var categories = JSON.parse(data);
                    var formattedOutput = '<span>Suggested categories</span><br>';
                    categories.forEach(function(category) {
                        formattedOutput += '<span onclick="setCategory('+category.cat_id+','+category.child_cat_id+')" style="color:#fe8a0f">'+category.cat_name +' > '+category.child_cat_name+'</span><br>';                    
                    });
                    
                    $('#suggestedCategory').html(formattedOutput);
                    $('#suggestedCategory').removeClass('hidden');
                }else{
                    $('#suggestedCategory').addClass('hidden');
                }                
            }
        });
    }

    function setCategory(mcId, scId){
        $('.mainCategory').val(mcId);
        $('.mainCategory').trigger('change');

        setTimeout(function() {
            $('#subcategory' + scId).prop('checked', true);
        }, 800);
    }

    $('#location').on('change', function(){
        var location = $(this).val();
         $.ajax({
            url:site_url+'users/getArea',
            type:"POST",
            data:{'location':location},
            success:function(data){
                if(data != ""){
                    $('#townDiv').removeClass('hidden');
                    $('#area').empty().html(data);
                    $('#area').val(<?php echo $serviceData['area'] ?? '' ?>);
                }else{
                    $('#townDiv').addClass('hidden');
                }
            }
        });
    });

</script>