<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Home Content Management</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Home Content Management</li>
      </ol>
    
  </section>

<!--<section class="content-header text-right">
    
    <a href="javascript:void(0);"  data-toggle="modal" data-target="#Add_plans" class="btn btn-success">Add Content</a> 
  </section>-->
  <iframe id="txtArea1" style="display:none"></iframe>
  
  <section class="content">   
    <div class="row">
      
<div class="col-md-12">
        <div class="box">
                     <div class="box-body">
      <?php 
      if($this->session->flashdata('error'))
      {
        ?>
        <p class="alert alert-danger hide-it"><?php echo $this->session->flashdata('error'); ?></p>
        <?php
      }
      if($this->session->flashdata('success'))
      {
        ?>
        <p class="alert alert-success hide-it"><?php echo $this->session->flashdata('success'); ?></p>
        <?php
      }
      ?>
       <p id="success" class="alert alert-success hide-it" style="display: none"></p>
</div>
            <div class="box-header with-border">
              <h3 class="box-title">HOME PAGE CONTENT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
 
       <form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/Admin/update_content/'.$listing['0']['id']); ?>" enctype="multipart/form-data">
            
              <div class="box-body">

                  <div class="form-group">  
                  <label for="Username" class="col-sm-2 control-label"> Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="" value="<?php echo $listing['0']['meta_title']; ?>">
                  </div>
                </div>
                  <div class="form-group">  
                  <label for="Username" class="col-sm-2 control-label"> Meta Keywords</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="meta_key" id="meta_key" placeholder="" value="<?php echo $listing['0']['meta_key']; ?>">
                  </div>
                </div>

                  <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Description</label>
        <div class="col-sm-10">
        <textarea name="meta_description" required class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['meta_description']; ?></textarea>
      </div>
       </div>
  
              </div>            
              <div class="box-footer">
               <input type="hidden" name="user_id" id="user_id" value="1" />
                <button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>
                        <div class="box-header with-border">
              <h3 class="box-title">SCRIPT MANAGEMENT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
 
       <form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/Admin/update_script/'.$listing['0']['id']); ?>" enctype="multipart/form-data">
            
              <div class="box-body">
                  <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Header Script</label>
        <div class="col-sm-10">
        <textarea name="header_script" required class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['header_script']; ?></textarea>
      </div>
       </div>
                         <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Body Script</label>
        <div class="col-sm-10">
        <textarea name="body_script" required class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['body_script']; ?></textarea>
      </div>
       </div>
                         <div class="form-group" style="display: none;">
        <label for="email" class="col-sm-2 control-label">Footer Script</label>
        <div class="col-sm-10">
        <textarea name="footer_script" class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['footer_script']; ?></textarea>
      </div>
       </div>
  
              </div>            
              <div class="box-footer">
               <input type="hidden" name="user_id" id="user_id" value="1" />
                <button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>
                           <div class="box-header with-border">
              <h3 class="box-title">BLOG CONTENT</h3>
            </div>
                   <form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/Admin/update_blog/'.$listing['0']['id']); ?>" enctype="multipart/form-data">
            
              <div class="box-body">

                  <div class="form-group">  
                  <label for="Username" class="col-sm-2 control-label"> Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="blog_title" id="blog_title" placeholder="" value="<?php echo $listing['0']['blog_title']; ?>">
                  </div>
                </div>

                  <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
        <textarea name="blog_description" required class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['blog_description']; ?></textarea>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Title</label>
        <div class="col-sm-10">
        <input name="blog_footer_title"  class="form-control" value="<?php echo $listing['0']['blog_footer_title']; ?>" ></>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Key</label>
        <div class="col-sm-10">
        <input name="blog_footer_key"  class="form-control" value="<?php echo $listing['0']['blog_footer_key']; ?>" ></>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Description</label>
        <div class="col-sm-10">
        <textarea name="blog_footer_description"  class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['blog_footer_description']; ?></textarea>
      </div>
       </div>
  
              </div>            
              <div class="box-footer">
               <input type="hidden" name="user_id" id="user_id" value="1" />
                <button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>



            <div class="box-header with-border">
              <h3 class="box-title">COST GUIDES</h3>
            </div>
                   <form class="form-horizontal"  method="POST" action="<?php echo site_url('Admin/Admin/update_cost/'.$listing['0']['id']); ?>" enctype="multipart/form-data">
            
              <div class="box-body">

                  <div class="form-group">  
                  <label for="Username" class="col-sm-2 control-label"> Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="cost_title" id="blog_title" placeholder="" value="<?php echo $listing['0']['cost_title']; ?>">
                  </div>
                </div>

                  <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
        <textarea name="cost_description" required class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['cost_description']; ?></textarea>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Title</label>
        <div class="col-sm-10">
        <input name="cost_meta_title"  class="form-control" value="<?php echo $listing['0']['cost_meta_title']; ?>" ></textarea>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Key</label>
        <div class="col-sm-10">
        <input name="cost_meta_key"  class="form-control" value="<?php echo $listing['0']['cost_meta_key']; ?>" ></textarea>
      </div>
       </div>


           <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Meta Description</label>
        <div class="col-sm-10">
        <textarea name="cost_meta_description"  class="form-control" cols="6" style="height: 120px;"><?php echo $listing['0']['cost_meta_description']; ?></textarea>
      </div>
       </div>
  
              </div>            
              <div class="box-footer">
               <input type="hidden" name="user_id" id="user_id" value="1" />
                <button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>

       
        </div>
       
      </div>
    </section>

<!--
<div class="modal fade in" id="Add_plans">
   <div class="modal-body" >
      <div class="modal-dialog">
   
         <div class="modal-content">
      <form method="POST" action="<?php echo site_url('Admin/Admin/add_content'); ?>"  enctype="multipart/form-data">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Add Content</h4>
            </div>
            <div class="modal-body form_width100">
      <div class="form-group">
        <label for="email"> Meta Title:</label>
        <input type="text" name="meta_title"  required class="form-control" >
       </div>

      <div class="form-group">
        <label for="email"> Meta Description:</label>
        <input type="text" name="meta_description" id="meta_description" required class="form-control" >
       </div>

               <div class="modal-footer">
        <button type="submit" class="btn btn-info" >Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
         </form>
            </div>
      
         </div>
      </div>
   </div> -->
 </div>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>

<script>
tinymce.init({
  selector: '.textarea',
  height:250,
  plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  setup: function (editor) {
    editor.on('change', function () {
      tinymce.triggerSave();
    });
  }
});
</script> 
<script>

function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('boottable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
</script>    



<script>
function seepreview(id){
  //alert(id);
  var fileUploads = $("#image"+id)[0];
  var reader = new FileReader();
  reader.readAsDataURL(fileUploads.files[0]);
  reader.onload = function (e) {
    var image = new Image();
    image.src = e.target.result;
    image.onload = function () {
      var height = this.height;
      var width = this.width;
    ///  var type=this.type;
   //   alert(width);
        $('#imgpreview'+id).attr('src', image.src); 
        $('#imgpreview'+id).show();
    }
  }   
}
/*
  uploader.onchange = function(){
        reader = new FileReader();
        reader.onload = function(e) {
          var videoElement = document.createElement('videos');
          videoElement.src = e.target.result;
          var timer = setInterval(function () {
            if (videoElement.readyState === 4){
              console.log("The duration is: " + videoElement.duration.toFixed(2) + " seconds");
              clearInterval(timer);
              co
            }
          }, 500)
        };    
        reader.readAsDataURL(files[0]);*/

  </script>

  <script type="text/javascript">
 /*   $(function() {
  
    $(".hide-it").hide(5000);

});*/
  </script>
  <?php include_once('include/footer.php'); ?>