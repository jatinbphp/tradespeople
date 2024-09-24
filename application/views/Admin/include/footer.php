	
 <script src="<?php echo base_url(); ?>asset/admin/dist/js/multiselect.js"></script>
  <footer class="main-footer">
		<strong>Copyright &copy; <?php echo date('Y'); ?> TradersPeopleHub.</strong> All rights
		 reserved.
	</footer>
	<div class="control-sidebar-bg"></div>
</div>
<!-- textaria editer -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.13/tinymce.min.js"></script> -->

<script src="<?php echo base_url(); ?>asset/admin/dist/js/select2.full.min.js"></script>  

<script>
    $(function(){
        $('.select2').select2();    
    });
</script>

<script type="text/javascript">
function mark_read_in_admin(table,where){
	$.ajax({ 
		type:"post",
		url:'<?php echo site_url();?>Admin/Admin/mark_read_in_admin',
		data:{'table':table,'where':where},
		dataType: "JSON",
		success:function(ress){
			console.log(ress);
		}
	});
}
function search() {
	var date = $('#das_date').val();
	var monthvalue = $('#das_month').val();
	var year = $('#das_year').val();
	$.ajax({
		type:"post",
		url:'<?php echo site_url();?>Admin/Admin/admin_dashbord_search',
		data:{'date':date,'month':monthvalue,'year':year},
              dataType: "JSON",
              success:function(data){
                if(data.status==1)
                {
                  $('#das_id').html(data.page_data);

                  if(data.month==1){
                   $('#das_month').prop('disabled',false);
                  }

                  if(data.day==1){
                   $('#das_date').prop('disabled',false);
                  }

                }else{
                  $('#erre_id').hide();
                  $('#erre_id').show();
                  $('#das_id').html(data.msg);
                }
              }
             });
    }
</script>

<script> 
tinymce.init({ 
	selector: '.textarea', 
	height: 200, 
	plugins: [ 
        "advlist autolink lists link charmap print preview anchor textcolor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | forecolor backcolor",
	setup: function (editor) { 
		editor.on('change', function () { 
			tinymce.triggerSave(); 
		}); 
	} 
}); 
</script>

<script type="text/javascript">
  toastr.options = {
      "closeButton": true,
      "debug": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "400",
      "hideDuration": "1000",
      "timeOut": "6000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  }
</script> 
<script type="text/javascript">
   <?php 
	 if($this->session->flashdata("succ")){ ?>
       toastr.success('<?php echo $this->session->flashdata("succ"); ?>');
   <?php } ?>  
   
   <?php if($this->session->flashdata("err")){ ?>
       toastr.error('<?php echo $this->session->flashdata("err"); ?>'); 
   <?php } ?>  
</script>
<script>
$(document).ready(function() {
	//setInterval(updatechat, 10000);
    $(".phonevalidation").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        } 
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});

function initializeTagsInput() {
    $('#service_type_category').tagsinput({
        minTags: 5
    });

    $('#service_type_category').on('beforeItemAdd', function(event) {
        var tag = event.item;
        var regex = /^[a-zA-Z0-9\s]+$/;
        if (!regex.test(tag)) {
            event.cancel = true; // Cancel adding the tag
        }
    });
}

$('.area').on('beforeItemAdd', function(event) {
    var tag = event.item;
    var regex = /^[a-zA-Z0-9\s]+$/;
    if (!regex.test(tag)) {
        event.cancel = true; // Cancel adding the tag
    }
});

</script>
<script>
var url = window.location;
// for sidebar menu but not for treeview submenu
$('ul.sidebar-menu a').filter(function() {
    return this.href == url;
}).parent().siblings().removeClass('active').end().addClass('active');
// for treeview which is like a submenu
$('ul.treeview-menu a').filter(function() {
    return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
</script>
<?php  
    unset($_SESSION['msg']);
?>

<?php 
    if($this->session->flashdata('success')){
        unset($_SESSION['success']);
    }
    if($this->session->flashdata('error')){
        unset($_SESSION['error']);
    }
?>

</body>
</html>
