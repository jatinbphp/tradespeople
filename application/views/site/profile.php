<?php 
  include 'include/header.php';
  $user_id = $this->session->userdata('user_id');
  //print_r($this->common_model->check_postalcode('W22SZ'));
?>
<style>
.tox-toolbar__primary{
	display:none !important;
}
</style>
<div class="">
    
	<div  class="imgbbg">
		<div class="main_bg_line">
			<div class="container">
				<ul class="page_linkk ul_set">
        <li>
          Find tradesman
        </li>
        <li>
          <?php echo ucfirst($user_profile['county']); ?>
        </li>
				<li>
          <?php echo ucfirst($user_profile['city']); ?>
        </li>
				<li>
          <?php
					$len = (strlen($user_profile['postal_code'])>=7)?4:3;
									
					echo strtoupper(substr($user_profile['postal_code'],0,$len));
					?>
        </li>
				<li>
          <?php echo ucfirst($user_profile['trading_name']); ?>
        </li>
      </ul>
			</div>
		</div>
		<!-- <img src="<?php echo site_url(); ?>img/profile-cover.png" class="img_r"> -->
		<div class="uerr_hire">
			<div class="container">
				<div class="row">
				<div class="col-sm-12">
					<div class="profile-edit-white dashboard-white set-dashboardnw">
						<div class="row">
							<div class="col-sm-2  col-xs-4 text-center">
								<div class="profile-pic over-profile" style="margin-bottom: 20px;width: 100%;height: 95px;border-radius: 5px;">
									<?php if($user_profile['profile']){ ?>
									<img src="<?= site_url(); ?>img/profile/<?= $user_profile['profile']; ?>" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
									<?php } else { ?>
									<img src="<?= site_url(); ?>img/profile/dummy_profile.jpg" class="img-responsive" style="width: 100%;height: 95px;border-radius: 5px;">
									<?php } ?>
									
									<?php if($this->session->userdata('user_id')==$this->uri->segment(2)){ ?>  
									<a href="" data-target="#edit_profile" data-toggle="modal">
										<div class="status-user pro-pic-edit">
											<i class="fa fa-camera" aria-hidden="true"></i>
										</div>
									</a>
									<?php } ?>
								</div>
							</div>
							<div class="col-sm-10 col-xs-8" style="padding-left:0px;">
								<div class="detaii_hh">
									<ul class="ul_set list_user">
										<li class="profile_user_name">
											<h4> <?php echo $user_profile['trading_name']; ?></h4>
										</li>
										<li>
											<i class="fa fa-map-marker"></i>
											<!-- <?=$user_profile['city'];?>, <?=$user_profile['county'];?> -->
                                            <?=$user_profile['city'];?>
										</li>
										<li>
											<i class="fa fa-calendar"></i> Member since <?=date('M Y', strtotime($user_profile['cdate']));?>
										</li>
										<li>
											<span class="btn btn-warning btn-xs"><?=$user_profile['average_rate'];?></span>
											<span class="star_r">
												<?php
												for($i=1;$i<=5;$i++){
												if($i<=$user_profile['average_rate']) {
												?>
												<i class="fa fa-star active"></i>
												<?php }else{ ?>
												<i class="fa fa-star"></i>
												<?php } } ?>
											</span>
											<span> (<?=$user_profile['total_reviews'];?> reviews)</span>
										</li>
										
									</ul>
								</div>
							</div>
						</div>
				
						<div class="setskil-padding review-mail" id="search_data">
				
							<?php if(count($get_reviews)>0){ ?>
							<div class="review-pro">
								<div class=" dashboard-profile edit-pro89">
									 <h2>Reviews</h2>
								</div>
				  
								<div class="min_h3">
									<?php foreach ($get_reviews as $r) {
									$job_title = $this->common_model->GetColumnName('tbl_jobs',array('job_id'=>$r['rt_jobid']),array('title','direct_hired'));
									$get_users = $this->common_model->GetColumnName('users',array('id'=>$r['rt_rateBy']),array('trading_name'));
									?>
						
									<div class="tradesman-feedback">
										<div class="set-gray-box">
											<p class="recent-feedback">
												<?php if($job_title['direct_hired']==1){ ?>
												<h4>Work for <?= $get_users['trading_name'];?></h4>	
												<?php } else if($job_title['title']){ ?>
												<h4><?= $job_title['title'];?></h4>
												<?php } else { ?>
												<h4>Work for <?= $get_users['trading_name'];?></h4>
												<?php } ?>
											</p>
											<div class="from-group revie">
												<span class="btn btn-warning btn-xs"><?php if($r['rt_rate']!=''){ echo $r['rt_rate']; } ?>
												</span>
												<span class="star_r">
													<?php 
													for($i=1;$i<=5;$i++){
														if($r['rt_rate']) {
															if($i<=$r['rt_rate']) { ?>  
															<i class="fa fa-star active"></i>
															<?php   } else{  ?>
															<i class="fa fa-star"></i>
													<?php  } } else  { ?> 
														<i class="fa fa-star"></i>
													<?php } ?>
													<?php } ?>
												</span>
											</div>
											<div cite="/job/view/5059288" class="summary">
												<p><?php echo $r['rt_comment']; ?></p>
											</div>
												<p class="tradesman-feedback__meta">By <strong class="job-author"><?php echo $get_users['trading_name']; ?></strong>&nbsp;on
                  
												<em class="job-date">
													<?php 	
													$time_ago = $this->common_model->time_ago($r['rt_create']); 
													?>
													<?=$time_ago;  ?>
												</em>
											</p>
										</div>
									</div>
						
									<?php } ?>
									<hr>
								</div>
							</div>
							<?= $this->ajax_pagination->create_links(); ?>
							<?php } ?>
							<div style="display:none;">
								<a href="#" class="btn btn-default"> Leave a Review</a>
							</div>
               
						</div>
			   
			   
					</div>

         </div>
      </div>
   </div>
</div>
<?php include 'include/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<link href="css/tagmanager.css" rel="stylesheet">
<script src="js/tagmanager.js"></script>
<script type="text/javascript">
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		height:250,
		menubar: false,
		branding: false,
		statusbar: false,
		//toolbar: 'bold | alignleft alignjustify | numlist',
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}
   function check_file_size(e,id){
   	var size = e.files[0].size;
   	
   	var ext = e.value.split('.').pop().toLowerCase();
   	
   	if(ext=='jpeg' || ext=='png' || ext=='jpg' || ext=='gif'){
   		$('.port_btn'+id).prop('disabled',false);
   	} else {
   		$('.port_btn'+id).prop('disabled',true);
   		swal('This file type is not allowed, Allow types are jpeg, png, jpg, gif.');
   		return false;
   	}
   	
   	var max = 1024*20*1024;
   	if(max >= size){
   		$('.port_btn'+id).prop('disabled',false);
   	} else {
   		$('.port_btn'+id).prop('disabled',true);
   		swal('File too large. File must be less than 20 MB.');
   		return false;
   	}
   		
   	
   }
   function update_profile1(){
       $('.submit_btn7').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn7').prop('disabled',true);
   }
   function update_profile2()
   {
         $('.submit_btn13').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn13').prop('disabled',true);
   }
   function update_category()
   {
        $('.submit_btn11').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn11').prop('disabled',true);
   }
   function update_skills1(){
       $('.submit_btn10').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn10').prop('disabled',true);
   }
   function update_profile(){
       $('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn').prop('disabled',true);
   }
   function add_portfolio(){
       $('.submit_btn1').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn1').prop('disabled',true);
   }
   function edit_portfolio(){
       $('.submit_btn5').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn5').prop('disabled',true);
   }
   function edit_certificate(){
       $('.submit_btn6').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn6').prop('disabled',true);
   }
   
   
   function add_education(){
       $('.submit_btn2').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn2').prop('disabled',true);
   }
   function edit_education()
   {
        $('.submit_btn3').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn3').prop('disabled',true);
   }
   function add_certification()
   {
        $('.submit_btn4').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
       $('.submit_btn4').prop('disabled',true);
   }
   
   $("#u_profile").change(function () {
       filePreview(this);
   });
   $("#port_image").change(function () {
       filePreview1(this);
   });
   function filePreview(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.perview_pro_img').html('');
               $('.perview_pro_img').html('<img src="'+e.target.result+'" width="100" height="80"/>');
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   function filePreview1(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.perview_pro_img1').html('');
               $('.perview_pro_img1').html('<img src="'+e.target.result+'" width="100" height="80"/>');
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   
   (function($) {
       $.fn.chosenImage = function(options) {
           return this.each(function() {
   
               var $select = $(this),
               imgMap  = {};
   
               $select.find('option').filter(function(){
                   return $(this).text();
               }).each(function(i) {
                   var imgSrc   = $(this).attr('data-img-src');
                   imgMap[i]    = imgSrc;
               });
   
               $select.chosen(options);
   
               var chzn_id = $select.attr('id');
               chzn_id += "_chzn";
               console.log('before class addition');
               var  chzn      = '#' + chzn_id,            
               $chzn = $(chzn).addClass('chznImage-container');
       
               $chzn.find('.chzn-results li').each(function(i) {
                   $(this).css(cssObj(imgMap[i]));
               });
   
               $select.change(function() {
                   var imgSrc = ($select.find('option:selected').attr('data-img-src')) ? $select.find('option:selected').attr('data-img-src') : '';
                   $chzn.find('.chzn-single span').css(cssObj(imgSrc));
               });
   
               $select.trigger('change');
   
               function cssObj(imgSrc) {
                   if(imgSrc) {
                       return {
                           'background-image': 'url(' + imgSrc + ')',
                           'background-repeat': 'no-repeat'
                   }
                   } else {
                       return {
                           'background-image': 'none'
                       }
                   }
               }
           });
       }
   })(jQuery);
   
   
</script>
<script>
   $(document).ready(function(e) {
     $(".user-pic-click").click(function(e) {
     $(".right-side-user").addClass("right-side-user-0");
   });
     $(".close-right-menu").click(function(e) {
     $(".right-side-user").removeClass("right-side-user-0");
   });
     $(".acount-page .container").click(function(e) {
     $(".right-side-user").removeClass("right-side-user-0");
   });
     $(".portfolio-show").click(function(e) {
     $(".show-project-fill").addClass("show-portfolio");   
   }); 
     $(".hide-port-sect").click(function(e) {  
     $(".show-project-fill").removeClass("show-portfolio");
   });
   
   });
   
</script>
<script>
   jQuery(".tm-input.tm-input-01").tagsManager({
     prefilled: ["Real State", "Graphic Design"],
     blinkBGColor_1: '#FE7508',
     blinkBGColor_2: '#CDE69C'//,
   });
   
</script>
<script type="text/javascript">
   $(function() {
   $('#form-tags-1').tagsInput();
   
   $('#form-tags-2').tagsInput({
     'onAddTag': function(input, value) {
       console.log('tag added', input, value);
     },
     'onRemoveTag': function(input, value) {
       console.log('tag removed', input, value);
     },
     'onChange': function(input, value) {
       console.log('change triggered', input, value);
     }
   });
   
   $('#form-tags-3').tagsInput({
     'unique': true,
     'minChars': 2,
     'maxChars': 10,
     'limit': 5,
     'validationPattern': new RegExp('^[a-zA-Z]+$')
   });
   
   $('#form-tags-4').tagsInput({
     'autocomplete': {
       source: [
         'apple',
         'banana',
         'orange',
         'pizza'
       ]
     }
   });
   
   $('#form-tags-5').tagsInput({
     'delimiter': ';'
   });
   
   $('#form-tags-6').tagsInput({
     'delimiter': [',', ';']
   });
   });
   
   
   
   /* jQuery Tags Input Revisited Plugin
   *
   * Copyright (c) Krzysztof Rusnarczyk
   * Licensed under the MIT license */
   
   (function($) {
   var delimiter = [];
   var inputSettings = [];
   var callbacks = [];
   
   $.fn.addTag = function(value, options) {
     options = jQuery.extend({
       focus: false,
       callback: true
     }, options);
     
     this.each(function() {
       var id = $(this).attr('id');
   
       var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
       if (tagslist[0] === '') tagslist = [];
   
       value = jQuery.trim(value);
       
       if ((inputSettings[id].unique && $(this).tagExist(value)) || !_validateTag(value, inputSettings[id], tagslist, delimiter[id])) {
         $('#' + id + '_tag').addClass('error');
         return false;
       }
       
       $('<span>', {class: 'tag'}).append(
         $('<span>', {class: 'tag-text'}).text(value),
         $('<button>', {class: 'tag-remove'}).click(function() {
           return $('#' + id).removeTag(encodeURI(value));
         })
       ).insertBefore('#' + id + '_addTag');
   
       tagslist.push(value);
   
       $('#' + id + '_tag').val('');
       if (options.focus) {
         $('#' + id + '_tag').focus();
       } else {
         $('#' + id + '_tag').blur();
       }
   
       $.fn.tagsInput.updateTagsField(this, tagslist);
   
       if (options.callback && callbacks[id] && callbacks[id]['onAddTag']) {
         var f = callbacks[id]['onAddTag'];
         f.call(this, this, value);
       }
       
       if (callbacks[id] && callbacks[id]['onChange']) {
         var i = tagslist.length;
         var f = callbacks[id]['onChange'];
         f.call(this, this, value);
       }
     });
   
     return false;
   };
   
   $.fn.removeTag = function(value) {
     value = decodeURI(value);
     
     this.each(function() {
       var id = $(this).attr('id');
   
       var old = $(this).val().split(_getDelimiter(delimiter[id]));
   
       $('#' + id + '_tagsinput .tag').remove();
       
       var str = '';
       for (i = 0; i < old.length; ++i) {
         if (old[i] != value) {
           str = str + _getDelimiter(delimiter[id]) + old[i];
         }
       }
   
       $.fn.tagsInput.importTags(this, str);
   
       if (callbacks[id] && callbacks[id]['onRemoveTag']) {
         var f = callbacks[id]['onRemoveTag'];
         f.call(this, this, value);
       }
     });
   
     return false;
   };
   
   $.fn.tagExist = function(val) {
     var id = $(this).attr('id');
     var tagslist = $(this).val().split(_getDelimiter(delimiter[id]));
     return (jQuery.inArray(val, tagslist) >= 0);
   };
   
   $.fn.importTags = function(str) {
     var id = $(this).attr('id');
     $('#' + id + '_tagsinput .tag').remove();
     $.fn.tagsInput.importTags(this, str);
   };
   
   $.fn.tagsInput = function(options) {
     var settings = jQuery.extend({
       interactive: true,
       placeholder: 'Add a tag',
       minChars: 0,
       maxChars: null,
       limit: null,
       validationPattern: null,
       width: 'auto',
       height: 'auto',
       autocomplete: null,
       hide: true,
       delimiter: ',',
       unique: true,
       removeWithBackspace: true
     }, options);
   
     var uniqueIdCounter = 0;
   
     this.each(function() {
       if (typeof $(this).data('tagsinput-init') !== 'undefined') return;
   
       $(this).data('tagsinput-init', true);
   
       if (settings.hide) $(this).hide();
       
       var id = $(this).attr('id');
       if (!id || _getDelimiter(delimiter[$(this).attr('id')])) {
         id = $(this).attr('id', 'tags' + new Date().getTime() + (++uniqueIdCounter)).attr('id');
       }
   
       var data = jQuery.extend({
         pid: id,
         real_input: '#' + id,
         holder: '#' + id + '_tagsinput',
         input_wrapper: '#' + id + '_addTag',
         fake_input: '#' + id + '_tag'
       }, settings);
   
       delimiter[id] = data.delimiter;
       inputSettings[id] = {
         minChars: settings.minChars,
         maxChars: settings.maxChars,
         limit: settings.limit,
         validationPattern: settings.validationPattern,
         unique: settings.unique
       };
   
       if (settings.onAddTag || settings.onRemoveTag || settings.onChange) {
         callbacks[id] = [];
         callbacks[id]['onAddTag'] = settings.onAddTag;
         callbacks[id]['onRemoveTag'] = settings.onRemoveTag;
         callbacks[id]['onChange'] = settings.onChange;
       }
   
       var markup = $('<div>', {id: id + '_tagsinput', class: 'tagsinput'}).append(
         $('<div>', {id: id + '_addTag'}).append(
           settings.interactive ? $('<input>', {id: id + '_tag', class: 'tag-input', value: '', placeholder: settings.placeholder}) : null
         )
       );
   
       $(markup).insertAfter(this);
   
       $(data.holder).css('width', settings.width);
       $(data.holder).css('min-height', settings.height);
       $(data.holder).css('height', settings.height);
   
       if ($(data.real_input).val() !== '') {
         $.fn.tagsInput.importTags($(data.real_input), $(data.real_input).val());
       }
       
       // Stop here if interactive option is not chosen
       if (!settings.interactive) return;
       
       $(data.fake_input).val('');
       $(data.fake_input).data('pasted', false);
       
       $(data.fake_input).on('focus', data, function(event) {
         $(data.holder).addClass('focus');
         
         if ($(this).val() === '') {
           $(this).removeClass('error');
         }
       });
       
       $(data.fake_input).on('blur', data, function(event) {
         $(data.holder).removeClass('focus');
       });
   
       if (settings.autocomplete !== null && jQuery.ui.autocomplete !== undefined) {
         $(data.fake_input).autocomplete(settings.autocomplete);
         $(data.fake_input).on('autocompleteselect', data, function(event, ui) {
           $(event.data.real_input).addTag(ui.item.value, {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         });
         
         $(data.fake_input).on('keypress', data, function(event) {
           if (_checkDelimiter(event)) {
             $(this).autocomplete("close");
           }
         });
       } else {
         $(data.fake_input).on('blur', data, function(event) {
           $(event.data.real_input).addTag($(event.data.fake_input).val(), {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         });
       }
       
       // If a user types a delimiter create a new tag
       $(data.fake_input).on('keypress', data, function(event) {
         if (_checkDelimiter(event)) {
           event.preventDefault();
           
           $(event.data.real_input).addTag($(event.data.fake_input).val(), {
             focus: true,
             unique: settings.unique
           });
           
           return false;
         }
       });
       
       $(data.fake_input).on('paste', function () {
         $(this).data('pasted', true);
       });
       
       // If a user pastes the text check if it shouldn't be splitted into tags
       $(data.fake_input).on('input', data, function(event) {
         if (!$(this).data('pasted')) return;
         
         $(this).data('pasted', false);
         
         var value = $(event.data.fake_input).val();
         
         value = value.replace(/\n/g, '');
         value = value.replace(/\s/g, '');
         
         var tags = _splitIntoTags(event.data.delimiter, value);
         
         if (tags.length > 1) {
           for (var i = 0; i < tags.length; ++i) {
             $(event.data.real_input).addTag(tags[i], {
               focus: true,
               unique: settings.unique
             });
           }
           
           return false;
         }
       });
       
       // Deletes last tag on backspace
       data.removeWithBackspace && $(data.fake_input).on('keydown', function(event) {
         if (event.keyCode == 8 && $(this).val() === '') {
            event.preventDefault();
            var lastTag = $(this).closest('.tagsinput').find('.tag:last > span').text();
            var id = $(this).attr('id').replace(/_tag$/, '');
            $('#' + id).removeTag(encodeURI(lastTag));
            $(this).trigger('focus');
         }
       });
   
       // Removes the error class when user changes the value of the fake input
       $(data.fake_input).keydown(function(event) {
         // enter, alt, shift, esc, ctrl and arrows keys are ignored
         if (jQuery.inArray(event.keyCode, [13, 37, 38, 39, 40, 27, 16, 17, 18, 225]) === -1) {
           $(this).removeClass('error');
         }
       });
     });
   
     return this;
   };
   
   $.fn.tagsInput.updateTagsField = function(obj, tagslist) {
     var id = $(obj).attr('id');
     $(obj).val(tagslist.join(_getDelimiter(delimiter[id])));
   };
   
   $.fn.tagsInput.importTags = function(obj, val) {
     $(obj).val('');
     
     var id = $(obj).attr('id');
     var tags = _splitIntoTags(delimiter[id], val); 
     
     for (i = 0; i < tags.length; ++i) {
       $(obj).addTag(tags[i], {
         focus: false,
         callback: false
       });
     }
     
     if (callbacks[id] && callbacks[id]['onChange']) {
       var f = callbacks[id]['onChange'];
       f.call(obj, obj, tags);
     }
   };
   
   var _getDelimiter = function(delimiter) {
     if (typeof delimiter === 'undefined') {
       return delimiter;
     } else if (typeof delimiter === 'string') {
       return delimiter;
     } else {
       return delimiter[0];
     }
   };
   
   var _validateTag = function(value, inputSettings, tagslist, delimiter) {
     var result = true;
     
     if (value === '') result = false;
     if (value.length < inputSettings.minChars) result = false;
     if (inputSettings.maxChars !== null && value.length > inputSettings.maxChars) result = false;
     if (inputSettings.limit !== null && tagslist.length >= inputSettings.limit) result = false;
     if (inputSettings.validationPattern !== null && !inputSettings.validationPattern.test(value)) result = false;
     
     if (typeof delimiter === 'string') {
       if (value.indexOf(delimiter) > -1) result = false;
     } else {
       $.each(delimiter, function(index, _delimiter) {
         if (value.indexOf(_delimiter) > -1) result = false;
         return false;
       });
     }
     
     return result;
   };
   
   var _checkDelimiter = function(event) {
     var found = false;
     
     if (event.which === 13) {
       return true;
     }
   
     if (typeof event.data.delimiter === 'string') {
       if (event.which === event.data.delimiter.charCodeAt(0)) {
         found = true;
       }
     } else {
       $.each(event.data.delimiter, function(index, delimiter) {
         if (event.which === delimiter.charCodeAt(0)) {
           found = true;
         }
       });
     }
     
     return found;
    };
    
    var _splitIntoTags = function(delimiter, value) {
      if (value === '') return [];
      
      if (typeof delimiter === 'string') {
        return value.split(delimiter);
      } else {
        var tmpDelimiter = '∞';
        var text = value;
        
        $.each(delimiter, function(index, _delimiter) {
          text = text.split(_delimiter).join(tmpDelimiter);
        });
        
        return text.split(tmpDelimiter);
      }
      
      return [];
    };
   })(jQuery);
   
   $('.chosen-select').chosen({}).change( function(obj, result) {
     console.debug("changed: %o", arguments);
     
     console.log("selected: " + result.selected);
   });
</script>
<script>
   $('.owl-carousel').owlCarousel({
   		loop:false,
           pagination: false,
           slideSpeed: 700,
           paginationSpeed: 700,
           rewindSpeed: 700,
           lazyLoad: true,
   		margin:5,		
   		responsive:{
   			0:{
   				items:1
   			},
   			600:{
   				items:3
   			},
   			1000:{
   				items:6
   			}
   		}
   });
   
   $().fancybox({
     selector : '.owl-item:not(.cloned) a',
     hash   : false,
     thumbs : {
       autoStart : true
     },
   	beforeShow : function(){
      this.title =  this.title + " - " + $(this.element).data("caption");
     },
     buttons : [
       'zoom',
       'download',
       'close'
     ]
   });
   function direct_hiring(){
     $.ajax({
       type:'POST',
       url:site_url+'direct_hire/direct_hire',
       data:$('#direct_hire').serialize(),
       dataType:'JSON',
       beforeSend:function(){
         $('#msg').html('');
   			$('.hire_me').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
   			$('.hire_me').prop('disabled',true);
       },
       success:function(resp){
         if(resp.status==1){
           window.location.href=site_url+"my-account";
         } else {
					 $('.hire_me').html('Hire me');
					$('.hire_me').prop('disabled',false);
           $('#msg').html(resp.msg);
         }
       }
     });
     return false;
   }

  function show_hide_more(){
    $(".hide-skill").slideToggle();
    if ($("#show-more-btn").text() == "hide") {
      $("#show-more-btn").text('View all');
    }else {
      $("#show-more-btn").text('hide');
    }
  }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css">

<script>
$('p').each(function() {
    var $this = $(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
        $this.remove();
});
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var userid = '<?php echo $this->uri->segment(2); ?>';
	$.ajax({ 
		type:'POST',
		url:site_url+'users/find_rating_ajax/'+page_num,
		data:'page_num='+page_num+'&userid='+userid,
		dataType:'JSON',
		beforeSend:function()
		{
			$('.search_btn').prop('disabled',true);
			$('.btn_loader').show();
		},
		success:function(resp)
		{
			$('.search_btn').prop('disabled',false);
			$('.btn_loader').hide();
			$('#search_data').html(resp.data);
		}
	});
	return false;
}
</script>