$(function () {
	var input_file = document.getElementById('upload_files');
	var deleted_file_ids = [];
	var dynm_id = 1;
	var len = input_file.files.length;
	var valueimg;

	var max_file_count=200;

	$("#upload_files").change(function (event) {

		var len1 =$('#last_count_file').val();


		$('#add_post_btn').attr('disabled',true); 
 if(input_file.files.length>max_file_count){
                  alert("You are only allowed to upload a maximum of "+max_file_count+" files");
                  return false;
               }
               else if(input_file.files.length >len12)
{
     alert("You are only allowed to upload a maximum of "+max_file_count+" files");
      $('#add_post_btn').attr('disabled',false); 

      return false;
      
}              

                var fd = new FormData();

 	for(var j=0; j<max_file_count; j++) {
 	      valueimg=input_file.files[j];
	      //var fsixe=$this.size;
			var Size111= Math.round(valueimg.size/ 1024);

                 if(Size111>=size_check) { 
                                    alert( "One of the images exceeding the Maximum file size, please choose another image and re-submit"); 
                                      return false;
                                }
        var ad_ID=$('#ad_ID').val();
        fd.append('file',valueimg);
        fd.append('ad_ID',ad_ID);
      
         
send_image_request(dynm_id ,fd,valueimg);
   	
$('#last_count_file').val(dynm_id);

var remaning=parseInt(max_file_count)-parseInt(dynm_id)
$('#last_count_file_remaning').val(remaning);

dynm_id++;



    };
  
	
});
function send_image_request(dynm_id,fd,valueimg){
   // console.log(valueimg);
      fd.append('dynm_id',dynm_id);
   // console.log(dynm_id);
    
   var xhr = new XMLHttpRequest();
  xhr.open('POST', site_url+'sessionImage?1',true);
//  xhr.timeout = 20000;
  xhr.upload.onprogress = function(e) {
      
      $('#image-load').show(); 
 $('#add_post_btn').attr('disabled',true);
    if (e.lengthComputable) {


      var percentComplete = (e.loaded / e.total) * 100;
    //  console.log(percentComplete + '% uploaded');


      $('#progress-bar-file'+dynm_id).addClass('progress ');
    $('#progress-bar-file'+dynm_id).width(percentComplete + '%').html(Math.round(percentComplete) + '%');


    }
   

  };
    xhr.send(fd); 
    
      xhr.onload = function() {
    
	if (this.status == 200) {
	    $('#image-load').hide(); 
 $('#add_post_btn').attr('disabled',false); 
      $('#progress-bar-file'+dynm_id).removeClass('progress');


	   var reader = new FileReader();
		var name = valueimg.name;

 $('#preview_file_div div#a'+dynm_id).html("");

	
		   var reader = new FileReader();
    
    reader.onload = function(e) {

		var src = e.target.result;
		$('#progress-bar-file'+dynm_id).html("<div   data-id='"+xhr.response+"' class=' box_bro1 ' id='" + dynm_id + "'><img  src='"+src+"' class='up_img2' title='"+name+"'><p class='close close_imgs ' idd='"+xhr.response+"' id='" + dynm_id + "'><i class='fa fa-times-circle'></i><input type='hidden' name='image_id[]'  id='"+xhr.response+"' value='"+xhr.response+"'></p></div>");
//	$('#a'+dynm_id).removeClass('ui-state-disabled');
	

    }
	reader.readAsDataURL(valueimg)
	return true;
	   
	};

 	}
 	

}
$(document).on('click','p.close', function() {
	var id = $(this).attr('id');
   	var idd = $(this).attr('idd');
	deleted_file_ids.push(id);
   // $('div#'+id).remove();
   

for(m = id; m <= 10; m++) {
    var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
       document.getElementById("demo").innerHTML = xhttp.responseText;
    }
};
xhttp.open("GET", site_url+"removeImage?image_id="+idd, true);
xhttp.send();







		var newid=parseInt(m)+1;
//   console.log(newid);
var nextimg= $('div#'+newid+' img').attr('src');
	  if(nextimg==undefined){
 $('#preview_file_div div#a'+dynm_id).html("");

			$('#progress-bar-file'+m).html("<div class='box_bro1'><img src='<?php echo base_url(); ?>assets/img/icon_us1.png' class='up_img1' ></div>");
				$('#image_id'+m).remove();

	  }else{



	$('div#'+m+' img').attr('src',nextimg);

	 // $('#preview_file_div div#a'+newid).html("<div class='box_bro1'><img src='<?php echo base_url(); ?>assets/img/icon_us1.png' class='up_img1' ></div>");

}

}
	if(("div").length == 0) document.getElementById('upload_files').value=""; 
	 dynm_id--;


});

});
$(document).on('click','#show_phone', function() {
    
    
    if ($('#show_phone').is(':checked')) {
           // alert(1);
            
         		$('#post_phone').attr('required','required');
   

    }else{
                 		$('#post_phone').removeAttr('required');

    }

});

     $(document).ready(function(){

$(".sortable").sortable({
    start: function(event, ui) {
        ui.item.startPos = ui.item.index();
    },
    stop: function(event, ui) {
        var total =parseInt($("#last_count_file").val())-parseInt(1);

       // console.log("Start position: " + ui.item.startPos);
        if(ui.item.index()>total){
          
        //console.log("New position: " + ui.item.index());
          return false;
        }
        else{
              return true;
        }
    }
});
     });


  
