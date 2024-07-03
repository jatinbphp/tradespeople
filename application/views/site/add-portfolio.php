
<?php include 'include/header.php'; ?>


<div class="acount-page membership-page">
<div class="container">
  <div class="fullwidth">
      <a href="edit-profile.html" class="btn btn-default">Go back to Profile Page</a>
    </div>
  <!-- project-detail-->
    <div class="show-project-fill">
       <h2>Portfolio Upload <span class="pull-right">Added : 0</span></h2>
         <div class="form-portfolio">
         <h3 class="col-md-12">Add Portfolio Item</h3>
         <div class="form-group">
          <label class="col-md-12 control-label" for="">Content Type:</label>  
          <div class="col-md-12"> 
            <label class="radio-inline" for="radios-0">
              <input name="radios" id="radios-0" value="1" checked="checked" type="radio">
              Image
            </label> 
            <label class="radio-inline" for="radios-1">
              <input name="radios" id="radios-1" value="2" type="radio">
              Article
            </label> 
            <label class="radio-inline" for="radios-2">
              <input name="radios" id="radios-2" value="3" type="radio">
              Code
            </label> 
            <label class="radio-inline" for="radios-3">
              <input name="radios" id="radios-3" value="4" type="radio">
              Video
            </label>
            <label class="radio-inline" for="radios-4">
              <input name="radios" id="radios-4" value="5" type="radio">
              Audio
            </label>
            <label class="radio-inline" for="radios-5">
              <input name="radios" id="radios-5" value="6" type="radio">
              Others
            </label>
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="">Title:</label>  
          <div class="col-md-12">
          <input id="textinput" name="textinput" placeholder="" class="form-control input-md" type="text"> 
          <p class="text-right nomargin"><small>60 characters</small></p>           
          </div>
        </div>
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="">Item Description:</label>  
          <div class="col-md-12">
          <textarea rows="5" placeholder="" class="form-control input-md"></textarea>
          <p class="text-right nomargin"><small>1000 characters</small></p>     
          </div>
        </div>        
        
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="">Upload File <small>(Maximum file size: 20MB)</small></label>  
          <div class="col-md-12">
          <input type="file" class=""/>  
          </div>
        </div>     
        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-12 control-label" for="">Skills  <small>(Select from list or type your own)</small></label>  
          
           <div class="col-md-12">
              <input id="form-tags-1" name="tags-1" type="text" value="jQuery,Script,Net">
        <!-- 
            <label>Tags input with callbacks (check console):</label>
            <input id="form-tags-2" name="tags-2" type="text" value="apple,banana,pizza">
        
            <label>Tags input with various validation:</label>
            <input id="form-tags-3" name="tags-3" type="text" value="">
        
            <label>Tags input with autocomplete:</label>
            <input id="form-tags-4" name="tags-4" type="text" value=""> -->
           </div>

        </div>     
        <hr />
        <div class="form-group">
          <div class="col-md-12">
            <button id="button1id" name="button1id" class="btn btn-warning">Save</button>
            <a class="btn btn-default hide-port-sect">Cancel</a>
          </div>
        </div>   
        
        
        </div>
    </div>    
    <div class="row">
      <div class="add-portfolio">
          <div class="col-md-3 col-sm-4">
            <div class="text-right portfolio-edit">
              <a href="javascript:void(0)" class="portfolio-show">edit</a>
              <a href="">delete</a>
            </div>
              <div class="portfolio-item">
                  <div class="img-portfolio">
                      <img src="img/sale.png" class="img-responsive" />
                        <div class="portfolio-name">
                          <h1>Project Name</h1>       
                            <p class="hide-portfolio">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-4">
            <div class="text-right portfolio-edit">
              <a href="javascript:void(0)" class="portfolio-show">edit</a>
              <a href="">delete</a>
            </div>
              <div class="portfolio-item">
                  <div class="img-portfolio">
                      <img src="img/sale.png" class="img-responsive" />
                        <div class="portfolio-name">
                          <h1>Project Name</h1>       
                            <p class="hide-portfolio">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-3 col-sm-4">
            <div class="text-right portfolio-edit">
              <a href="javascript:void(0)" class="portfolio-show">edit</a>
              <a href="">delete</a>
            </div>
              <div class="portfolio-item">
                  <div class="img-portfolio">
                      <img src="img/sale.png" class="img-responsive" />
                        <div class="portfolio-name">
                          <h1>Project Name</h1>       
                            <p class="hide-portfolio">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
          <div class="col-md-3 col-sm-4">
              <div class="portfolio-item portfolio-show">
                    <a class="btn">+ Add Portfolio Item</a>
                </div>
            </div>
        </div>
    </div>
  <!-- project-detail-->
</div>
</div>


<link href="css/tagmanager.css" rel="stylesheet">
  <script src="js/tagmanager.js"></script>



<?php include 'include/footer.php'; ?>

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

</script>