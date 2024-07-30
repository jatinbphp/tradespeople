<style>
  .imagePreviewPlus{width:100%;max-height:134px;background-position:center center;background-size:cover;background-repeat:no-repeat;display:inline-block;display:flex;align-content:center;justify-content:center;align-items:center}
  .imgUp{margin-bottom:15px}
  .boxImage { height: 100%; border: 1px solid #b0c0d3; border-radius: 10px;overflow: hidden;padding: 5px;}
  .boxImage img { height: 100%;object-fit: contain;border-radius: 10px;}
</style>

<div class="w3-bar w3-black" style="margin-bottom:15px;">
  <button class="btn btn-sm btn-primary" onclick="openServiceTab('service-details')">Service Details</button>
  <button class="btn btn-sm" onclick="openServiceTab('extra-service')">Extra Service</button>
  <button class="btn btn-sm" onclick="openServiceTab('gallery')">Gallery</button>
  <button class="btn btn-sm" onclick="openServiceTab('faqs')">FAQs</button>
</div>

<div id="service-details" class="w3-container sTab">
  <div class="table-responsive">
      <table id="boottable" class="table table-bordered table-striped">
        <tr>
          <th>Service Name</th>
          <td><?php echo $service_details['service_name']?></td>
        </tr>

        <tr>
          <th>Description</th>
          <td><?php echo $service_details['description']?></td>
        </tr>

        <tr>
          <th>Location</th>
          <td><?php echo $service_details['location']?></td>
        </tr>

        <tr>
          <th>Price</th>
          <td><?php echo '£'.number_format($service_details['price'],2);?></td>
        </tr>

        <tr>
          <th>Positive Keywords</th>
          <td><?php echo $service_details['positive_keywords'];?></td>
        </tr>

        <tr>
          <th>Category</th>
          <td>
            <?php
              $category = $this->Common_model->get_single_data('category',array('cat_id'=>$service_details['category']));
              echo $category['cat_name'];
            ?>
          </td>
        </tr>

        <tr>
          <th>Sub Category</th>
          <td>
            <?php
              $sub_category = $this->Common_model->get_single_data('category',array('cat_id'=>$service_details['sub_category']));
              echo $sub_category['cat_name'];
            ?>
          </td>
        </tr>

        <tr>
          <th>Service Type</th>
          <td>
            <?php
              $service_type = $this->Common_model->get_single_data('category',array('cat_id'=>$service_details['service_type']));
              echo $service_type['cat_name'];
            ?>
          </td>
        </tr>

        <tr>
          <th>Plugins</th>
          <td>
            <?php
              $pluginList = '';
              if(!empty($service_details['plugins'])){
                $plugins = explode(',', $service_details['plugins']);
                foreach($plugins as $plug){
                  $plugin_name = $this->Common_model->get_single_data('category',array('cat_id'=>$plug));
                  $pluginList .= $plugin_name['cat_name'].', ';
                }
              }          
              echo rtrim($pluginList,',');
            ?>
          </td>
        </tr>

        <tr>
          <th>Image/Video</th>
          <td>
            <?php $image_path = FCPATH . 'img/services/' . ($service_details['image'] ?? ''); ?>
            <?php if (file_exists($image_path) && $service_details['image']): ?>
              <?php
                $mime_type = get_mime_by_extension($image_path);
                $is_image = strpos($mime_type, 'image') !== false;
                $is_video = strpos($mime_type, 'video') !== false;
              ?>
              <?php if ($is_image): ?>
                <div class="row"> 
                  <div class="col-lg-4 col-xs-12" style='padding-left:30px'>
                    <div class="boxImage imgUp">
                        <div class="imagePreviewPlus">
                            <img style="width: inherit; height: inherit;" src="<?php echo base_url('img/services/') . $service_details['image']; ?>" alt="Image">
                        </div>
                    </div>
                  </div>
                </div>
              <?php elseif ($is_video): ?>
                <div class="row"> 
                  <div class="col-md-4 col-xs-12" style='padding-left:30px'>
                    <div class="imgUp">
                        <div class="videoPreviewPlus">
                            <video controls
                            src="<?php echo base_url('img/services/') . $service_details['image']; ?>" 
                            type="<?php echo $mime_type; ?>" loop class="serviceVideo" style="width: 200px;">
                            </video>                            
                        </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </td>
        </tr>

        <?php if(!empty($service_availability)): ?>
          <tr>
            <th>Trades Man Availability</th>
            <input type="hidden" id="selectedDates" value="<?php echo $service_availability['selected_dates']; ?>">
            <input type="hidden" id="timeSlot" value="<?php echo $service_availability['time_slot']; ?>">
            <td>
              <div>
                <b>Availability Monday-Friday: </b> 
                <?php echo ucfirst($service_availability['available_mon_fri']); ?>
                <?php if($service_availability['available_mon_fri'] == 'no'): ?>
                  <br>
                  <span id="notAvailablMsg"></span>
                <?php endif;?>
              </div>

              <div style="margin-top:15px;">
                <b>Availability On Weekends: </b> 
                <?php echo ucfirst($service_availability['weekend_available']); ?>
                <?php if($service_availability['weekend_available'] == 'no'): ?>
                  <br>
                  <b>Not Available Days On Weekends: </b>
                  <span>
                    <?php echo ucwords(str_replace('_', ' ', $service_availability['not_available_days'])); ?>
                  </span>
                <?php endif;?>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </table>
    </div>   
</div>

<div id="extra-service" class="w3-container sTab" style="display:none">
  <div class="table-responsive">
      <table id="boottable" class="table table-bordered table-striped">
        <tr>
          <th>Extra Service Name</th>
          <th>Additional Working Days</th>
          <th>Price</th>
        </tr>
        <?php if(!empty($extra_services) && count($extra_services) > 0): ?>
          <?php foreach($extra_services as $exs): ?>
            <tr>
              <td><?php echo $exs['ex_service_name']; ?></td>
              <td><?php echo $exs['additional_working_days']; ?></td>
              <td><?php echo '£'.number_format($exs['price'],2);?></td>
            </tr>
          <?php endforeach; ?>
        <?php else:?>    
          <tr>
            <td rowspan="3">No data found</td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
</div>

<div id="gallery" class="w3-container sTab" style="display:none">
  <h4>
    Images
    <br>
    <small>Get noticed by the right buyer with visual examples of tradesman services.</small>
  </h4>

  <?php if(!empty($service_images) && count($service_images)>0):?>
    <div class="row">
      <?php foreach($service_images as $sImg): ?>
        <div class="col-md-3">
          <div class="boxImage imgUp">
            <div class="imagePreviewPlus">
              <img style="width: inherit; height: inherit;" src="<?php echo site_url()."img/services/".$sImg['image'] ?>" alt="Image">
            </div>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  <?php else:?>  
    <span>No image found</span>
  <?php endif; ?>

  <h4>
    Documents
    <br>
    <small>Show some document of the best work created by tradesman</small>
  </h4>

  <?php if(!empty($service_docs) && count($service_docs)>0):?>
    <div class="row">
      <?php foreach($service_docs as $sDoc): ?>
        <div class="col-md-3">
          <a href="<?php echo site_url()."img/services/".$sImg['image'] ?>" target="_blank">
            <div class="boxImage imgUp">
              <div class="imagePreviewPlus">
                <img style="width: inherit; height: inherit;" src="<?php echo site_url()."img/defaultDoc.png"?>" alt="Image">
              </div>
            </div>
          </a>
        </div>
      <?php endforeach;?>
    </div>
  <?php else:?>  
    <span>No document found</span>
  <?php endif; ?>
</div>

<div id="faqs" class="w3-container sTab" style="display:none">
  <h4>
    Frequently asked questions
    <br>
    <small>Questions & Answers for tradesman's Buyers.</small>
  </h4>
  <div class="table-responsive">
    <table id="boottable" class="table table-bordered table-striped">
      <?php if(!empty($service_faqs) && count($service_faqs) > 0): ?>
        <?php foreach($service_faqs as $faq):?>
            <tr>
              <table class="table table-bordered">
                <tr>
                  <td><span class="text-bold">Question:</span><br><?php echo $faq['question'];?></td>
                </tr>
                <tr>
                  <td><span class="text-bold">Answer:</span><br><?php echo $faq['answer'];?></td>
                </tr>
              </table>            
            </tr>
        <?php endforeach;?> 
      <?php else:?>  
        <tr>
          <td>No faqs found</td>
        </tr>     
      <?php endif; ?>
    </table>
  </div>  
</div>

<script type="text/javascript">
  function openServiceTab(tabName) {
    var i;
    var x = document.getElementsByClassName("sTab");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    document.getElementById(tabName).style.display = "block"; 

    var buttons = document.querySelectorAll('.w3-bar .btn');
    buttons.forEach(function(button) {
      button.classList.remove('btn-primary');
    });
    
    var activeButton = document.querySelector('button[onclick="openServiceTab(\'' + tabName + '\')"]');
    activeButton.classList.add('btn-primary');
  }
</script>