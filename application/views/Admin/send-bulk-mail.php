<?php 
include_once('include/header.php');
if(!in_array(7,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
@import url("//cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css");

body {
  padding: 10px;
}

.row{
  margin-top: 15px;
  margin-bottom: 15px
}

.btn-group,
.multiselect {
  width: 100%;
}

.multiselect {
  text-align: left;
  padding-right: 32px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.multiselect .caret {
  right: 12px;
  top: 45%;
  position: absolute;
}

.multiselect-container.dropdown-menu {
    min-width: 0px;
}

.multiselect-container>li>a>label {
    white-space: normal;
    padding: 5px 15px 5px 35px;
}

.multiselect-container > li > a > label > input[type="checkbox"] {
    margin-top: 3px;
}
/*
.multiselect-container>li>a>label {
  padding-right: 0;
  padding-left: 20px;
}
*/

.maltipal_desgin .multiselect-container.dropdown-menu {
	width: 100%;
	height: 200px;
	overflow-y: auto;
	overflow-x: hidden;
} 
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Send bulk messages</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send bulk messages</li>
      </ol>
  </section>

  <section class="content">   
    <div class="row">
			<div class="col-md-12">
        <div class="box">
					<div class="box-body">
						<?php echo $this->session->flashdata('msg'); ?>
						<p id="msg"></p>
					</div> 
            <!-- /.box-header -->
            <!-- form start -->
 
					<form class="form-horizontal" onsubmit="return submit_send_bulk_mail();"  method="POST" id="submit_send_bulk_mail">
						<div class="box-body">
						
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">User Type</label>
								<div class="col-sm-10">
									<select class="form-control" name="user_type" id="user_type" onchange="filter_users(this.value);" required>
										<option value="0">All</option>
										<option value="1">Tradesmen</option>
										<option value="2">Homeowners</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Select Users</label>
								<div class="col-sm-10 maltipal_desgin" id="user_div">
                  <select class="multi_select form-control" id="users" name="users[]" multiple="multiple">
                   <?php foreach($users as $key => $row){
                                      $type = ($row['type']==1) ? '' : ''; 
                                      echo '<option data-id="'.$row['type'].'" value="'.$row['id'].'">'.$row['f_name'].' '.$row['l_name'].' '.$type.'</option>';
                                    } ?>
                </select>
									<!-- <select multiple="multiple" class="multi_select form-control" name="users[]" id="users" required>
										<?php foreach($users as $key => $row){
											$type = ($row['type']==1) ? '(T)' : '(H)'; 
											echo '<option data-id="'.$row['type'].'" value="'.$row['id'].'">'.$row['f_name'].' '.$row['l_name'].' '.$type.'</option>';
										} ?>
									</select> -->
								</div>
								<div class="col-sm-10 maltipal_desgin"  id="user_div1" style="display:none;">
									<select multiple="multiple" class="multi_select form-control" name="users[]" id="users1">
										<?php foreach($users1 as $key => $row){
											$type = ($row['type']==1) ? '' : ''; 
											echo '<option data-id="'.$row['type'].'" value="'.$row['id'].'">'.$row['f_name'].' '.$row['l_name'].' '.$type.'</option>';
										} ?>
									</select>
								</div>
								<div class="col-sm-10 maltipal_desgin"  id="user_div2" style="display:none;">
									<select multiple="multiple" class="multi_select form-control" name="users[]" id="users2">
										<?php foreach($users2 as $key => $row){
											$type = ($row['type']==1) ? '' : ''; 
											echo '<option data-id="'.$row['type'].'" value="'.$row['id'].'">'.$row['f_name'].' '.$row['l_name'].' '.$type.'</option>';
										} ?>
									</select>
								</div>
							</div>
						
							<div class="form-group">  
								<label for="Username" class="col-sm-2 control-label">Subject</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="subject" id="subject" required>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Message</label>
								<div class="col-sm-10">
									<textarea name="messages" required class="form-control" rows="12" ></textarea>
								</div>
							</div>
						</div>    
					

						
						       
						<div class="box-footer">
							<button type="submit" class="btn btn-primary pull-right"   data-loading-text="Loading..." id="changeUsernameBtn">Send</button>
						</div>
					</form>
        </div>
      </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
function filter_users(type){
	if(type==1){
		$('#user_div').hide();
		$('#users').removeAttr('required');
		$('#users').removeAttr('name');
		
		$('#user_div2').hide();
		$('#users2').removeAttr('required');
		$('#users2').removeAttr('name');
		
		$('#user_div1').show();
		$('#users1').attr('required','required');
		$('#users1').attr('name','users[]');
		
	} else if(type==2){
		$('#user_div').hide();
		$('#users').removeAttr('required');
		$('#users').removeAttr('name');
		
		$('#user_div1').hide();
		$('#users1').removeAttr('required');
		$('#users1').removeAttr('name');
		
		$('#user_div2').show();
		$('#users2').attr('required','required');
		$('#users2').attr('name','users[]');
	} else {
		$('#user_div1').hide();
		$('#users1').removeAttr('required');
		$('#users1').removeAttr('name');
		
		$('#user_div2').hide();
		$('#users2').removeAttr('required');
		$('#users2').removeAttr('name');
		
		$('#user_div').show();
		$('#users').attr('required','required');
		$('#users').attr('name','users[]');
	}
	/*
	$.ajax({
		type:'POST',
		url:site_url+'Admin/packages/get_users_option/'+type,
		dataType:'JSON',
		beforeSend:function(){
		},
		success:function(res){
			$('#users').html(res.data);
		}
	});*/
	return false;
}
function submit_send_bulk_mail(){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/packages/submit_send_bulk_mail',
		dataType:'JSON',
		data:$('#submit_send_bulk_mail').serialize(),
		beforeSend:function(){
			$('#msg').html('<div class="alert alert-warning">Please wait it will take time upto 5 minutes.</div>');
			$('#changeUsernameBtn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('#changeUsernameBtn').prop('disabled',true);
		},
		success:function(res){
			if(res.status==1){
				location.reload();
			} else {
				$('#msg').html('<div class="alert alert-danger">Something went wrong, try again later!</div>');
				$('#changeUsernameBtn').html('Send');
				$('#changeUsernameBtn').prop('disabled',false);
			}
		}
	});
	return false;
}
</script>
<script>
$(document).ready(function() {
  $('#users').multiselect({
    numberDisplayed: 1,
    includeSelectAllOption: true,
    //search: true,
    allSelectedText: 'All Users selected',
    nonSelectedText: 'No Users selected',
    selectAllValue: 'All',
    selectAllText: 'Select All',
    unselectAllText: 'Unselect All',
    onSelectAll: function(checked) {
      var all = $('#users ~ .btn-group .dropdown-menu .multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(checked ? this.unselectAllText : this.selectAllText);
    },
    onChange: function() {
        //debugger;
      var select = $(this.$select[0]);
      var dropdown = $(this.$ul[0]);
      var options = select.find('option').length;
      var selected = select.find('option:selected').length;
      var all = dropdown.find('.multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(options === selected ? this.options.unselectAllText : this.options.selectAllText);
    }
  });

  $('#users1').multiselect({
    numberDisplayed: 1,
    includeSelectAllOption: true,
    //search: true,
    allSelectedText: 'All Users selected',
    nonSelectedText: 'No Users selected',
    selectAllValue: 'All',
    selectAllText: 'Select All',
    unselectAllText: 'Unselect All',
    onSelectAll: function(checked) {
      var all = $('#users1 ~ .btn-group .dropdown-menu .multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(checked ? this.unselectAllText : this.selectAllText);
    },
    onChange: function() {
        //debugger;
      var select = $(this.$select[0]);
      var dropdown = $(this.$ul[0]);
      var options = select.find('option').length;
      var selected = select.find('option:selected').length;
      var all = dropdown.find('.multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(options === selected ? this.options.unselectAllText : this.options.selectAllText);
    }
  });

  $('#users2').multiselect({
    numberDisplayed: 1,
    //search: true,
    includeSelectAllOption: true,
    allSelectedText: 'All Users selected',
    nonSelectedText: 'No Users selected',
    selectAllValue: 'All',
    selectAllText: 'Select All',
    unselectAllText: 'Unselect All',
    onSelectAll: function(checked) {
      var all = $('#users2 ~ .btn-group .dropdown-menu .multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(checked ? this.unselectAllText : this.selectAllText);
    },
    onChange: function() {
        //debugger;
      var select = $(this.$select[0]);
      var dropdown = $(this.$ul[0]);
      var options = select.find('option').length;
      var selected = select.find('option:selected').length;
      var all = dropdown.find('.multiselect-all .checkbox');
      all
      // get all child nodes including text and comment
        .contents()
        // iterate and filter out elements
        .filter(function() {
          // check node is text and non-empty
          return this.nodeType === 3 && this.textContent.trim().length;
          // replace it with new text
        }).replaceWith(options === selected ? this.options.unselectAllText : this.options.selectAllText);
    }
  });

});
$('#multiselect').multiselect();

$('#users').multiselect({
		includeSelectAllOption: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		filterPlaceholder: 'Search for something...'
});
$('#users1').multiselect({
	includeSelectAllOption: true,
	enableFiltering: true,
	enableCaseInsensitiveFiltering: true,
	filterPlaceholder: 'Search for something...'
});
 $('#users2').multiselect({
	includeSelectAllOption: true,
	enableFiltering: true,
	enableCaseInsensitiveFiltering: true,
	filterPlaceholder: 'Search for something...'
});
</script>