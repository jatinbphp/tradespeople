<?php 
include_once('include/header.php');
if(!in_array(4,$my_access)) { redirect('Admin_dashboard'); }
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Package Management</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Package Management</li>
		</ol>
	  
  </section>
	<section class="content-header text-right">
	  <button data-toggle="modal" data-target="#add_package" class="btn btn-success">Add Package</button> 
  </section>

  <section class="content">   
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
						<?php if($this->session->flashdata('error')) { ?>
						<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
						<?php } ?>
						<?php if($this->session->flashdata('success')) { ?>
						<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
						<?php } ?>
<div class="table-responsive">
	<table id="boottable" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>S.No</th> 
				<th>Plan Name</th>
				<th>Amount</th>
				<th>Description</th>
				<th>No. of bids</th>
				<th>Email Notification</th>
				<th>Sms Notification</th>
				<th>Free Trial</th>
				<th>Category Listing</th>
				<th>Directory Listing</th>
				<th>Unlimited trade category</th>
				<th>Plan Valid</th>
				<!--th>Status</th-->
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($listing as $key=>$list) { ?>
			<tr>
				<td><?php  echo $key+1; ?></td>
				<td><?php echo $list['package_name']; ?></td>
				<td><i class="fa fa-gbp"></i><?php echo $list['amount']; ?></td>
				<td><?php echo $list['description']; ?></td>
				<td><?php if($list['unlimited_limited']==0){ echo $list['bids_per_month']; } else { echo "Unlimited bids"; }?></td>
				<td><?php if($list['email_notification']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo "<span class='label label-success'>Yes</span>"; } ?></td>
				<td><?php if($list['sms_notification']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo $list['total_notification'].' Notifications'; } ?></td>
				<td><?php if($list['is_free']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo '<span class="label label-success">Yes</span><br>'.$list['free_plan_exp']; } ?></td>
				<td><?php if($list['category_listing']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo "<span class='label label-success'>Yes</span>"; } ?></td>
				<td><?php if($list['directory_listing']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo "<span class='label label-success'>Yes</span>"; } ?></td>
				<td><?php if($list['unlimited_trade_category']==0){ ?><?php echo "<span class='label label-danger'>No</span>"; }else{ echo "<span class='label label-success'>Yes</span>"; } ?></td>
				<td><?php echo $list['validation_type']; ?></td>

								
				<td>   
					<a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_open<?php echo $list['id']; ?>" class="btn btn-success btn-xs">Edit</a> 
					<a class="btn btn-danger btn-xs" href="<?php echo site_url('Admin/Packages/delete_package/'.$list['id']); ?>" onclick="return confirm('Are you sure! you want to delete this Package?');">Delete</a>
				</td>
			</tr> 
			<?php } ?>
		</tbody>
	</table>
</div>
			
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php 
foreach($listing as $key=>$list) {
//$where=array('id'=>$list['cat_id']);
//$recordbyid=recordbyid('category',$where);

?>

<div class="modal fade in" id="edit_open<?php echo $list['id']; ?>">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">

				<form onsubmit="return edit_count(<?= $list['id']; ?>);" id="edit_count<?= $list['id']; ?>" method="post"  enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Edit Package</h4>
					</div>
					<div class="modal-body">	
						<div class="editmsg<?= $list['id']; ?>" id="editmsg<?= $list['id']; ?>"></div>
						<div class="form-group">
							<label for="email"> Plan Name:</label>
							<input type="text" name="package_name"  value="<?php echo $list['package_name']; ?>" class="form-control" >
							<input type="hidden" name="plan_id" class="form-control" value="<?php echo $list['id']; ?>">
						</div>
						<div class="form-group">
							<label for="email"> Description:</label>
							<textarea name="description" class="form-control" ><?php echo $list['description']; ?></textarea>
						</div>
						<?php if($list['id']!=44){ ?>
						<div class="form-group">
							<label for="email"> Amount:</label>
							<input type="number" name="amount" class="form-control phonevalidation" value="<?php echo $list['amount']; ?>">
						</div>
						<?php } ?>
						<div class="form-group" id="bids_per_months<?php echo $list['id']; ?>">
							<label>No. of bids</label>
				
							<input type="number" min="1" name="bids_per_month" value="<?php $bid=$list['bids_per_month']; echo $bids=trim($bid,' bids'); ?>" class="form-control phonevalidation">
										
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="unlimited_limited" id="myChecks<?php echo $list['id']; ?>" value="1" onchange="valueChanged1(<?php echo $list['id']; ?>)" <?php if($list['unlimited_limited']==1){ ?>checked<?php } ?>><label for="email">&nbsp;&nbsp;&nbsp;Unlimited bid</label>
										
						</div>
						<div class="form-group" id="valid<?php echo $list['id']; ?>">
							<label>Plan Validity</label>   
							<div class="row">
								<div class="col-md-7">
									<?php
									if($list['validation_type']!=''){ $p_validity = explode(' ',$list['validation_type']); }
									?>
									<input type="number"  min="1" value="<?php if($list['validation_type']!=''){ echo $p_validity[0]; } ?>" name="number_count" class="form-control phonevalidation">
								</div>
								<div class="col-md-5">
									<select name="validation_type" class="form-control">
										<option <?= ($p_validity[1]=='Days')?'selected':''; ?> value="Days">Days</option>
										<option <?= ($p_validity[1]=='Weeks')?'selected':''; ?> value="Weeks">Weeks</option>
										<option <?= ($p_validity[1]=='Months')?'selected':''; ?> 	value="Months">Months</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="duration_type" value="1" <?php if($list['duration_type']==1){ ?>checked <?php } ?> id="plan_validities<?php echo $list['id']; ?>" onchange="plan_valids(<?php echo $list['id']; ?>)"><label for="email">&nbsp;&nbsp;&nbsp;Unlimited Plan Validity</label>
						</div>
					
						<div class="form-group">
				
							<input type="checkbox" name="reward_check" id="myreward<?php echo $list['id']; ?>" <?php if($list['reward']==1){ ?>checked <?php } ?> value="1" onchange="valueChangereward1(<?php echo $list['id']; ?>)"><label for="email">&nbsp;&nbsp;&nbsp;Reward</label>
							<?php if($list['reward']==1){ ?>

							<div class="form-group" id="reward_div<?php echo $list['id']; ?>">
								<label>Reward Amount</label>
				
								<input type="text" name="reward_amount" class="form-control" value="<?php echo $list['reward_amount']; ?>">
										
							</div>
							<?php } else { ?>
							<div class="form-group" id="reward_div<?php echo $list['id']; ?>" style="display: none;">
								<label>Reward Amount</label>
				
								<input type="text" name="reward_amount" class="form-control" value="<?php echo $list['reward_amount']; ?>">
										
							</div>
							<?php } ?>
										
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="is_free" id="is_free<?php echo $list['id']; ?>" onchange="change_is_free(<?php echo $list['id']; ?>)" value="1" <?php echo ($list['is_free']==1)?'checked':''; ?> ><label>&nbsp;&nbsp;&nbsp;Free Trial</label>
						</div>
						
						<div class="form-group is_free_div<?php echo $list['id']; ?>" style="display:<?php echo ($list['is_free']==1)?'block':'none'; ?>">
							<label>Free Plan Validity</label>   
							<div class="row">
								<div class="col-md-7">
									<?php
									if($list['free_plan_exp']!=''){ $free_plan_exp = explode(' ',$list['free_plan_exp']); }
									?>
									<input type="number" min="1" value="<?php if($list['free_plan_exp']!=''){ echo $free_plan_exp[0]; } ?>" name="number_count2" id="number_count2_<?php echo $list['id']; ?>" class="form-control phonevalidation" <?php echo ($list['is_free']==1)?'required':''; ?>>
								</div>
								<div class="col-md-5">
									<select name="validation_type2" class="form-control">
										<option <?= ($list['free_plan_exp'] && $free_plan_exp[1]=='Days')?'selected':''; ?> value="Days">Days</option>
										<option <?= ($list['free_plan_exp'] && $free_plan_exp[1]=='Weeks')?'selected':''; ?> value="Weeks">Weeks</option>
										<option <?= ($list['free_plan_exp'] && $free_plan_exp[1]=='Months')?'selected':''; ?> 	value="Months">Months</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="">
								<label>No. of free bids</label>
					
								<input type="number" min="1" name="free_bids_per_month" id="free_bids_per_month_<?php echo $list['id']; ?>" class="form-control phonevalidation" value="<?php $bid22=$list['free_bids_per_month']; echo $bids22=trim($bid22,' bids'); ?>" <?php echo ($list['is_free']==1)?'required':''; ?>>
											
							</div>
							<div class="form-group" id="">
								<label>No. of free sms</label>
								<input type="number" min="1" name="free_sms" id="free_sms_<?php echo $list['id']; ?>" class="form-control phonevalidation" value="<?php echo $list['free_sms'];?>" <?php echo ($list['is_free']==1)?'required':''; ?>>
							</div>
						</div>


						<div class="form-group">
							<input type="checkbox" name="email_notification" value="1" <?php echo ($list['email_notification']==1)?'checked':''; ?> ><label for="email">&nbsp;&nbsp;&nbsp;Email Notification</label>
						</div>

						<div class="form-group">
							<input type="checkbox" name="sms_notification" id="sms_notification<?php echo $list['id']; ?>" onchange="change_sms_noti(<?php echo $list['id']; ?>)" value="1" <?php echo ($list['sms_notification']==1)?'checked':''; ?> ><label for="email">&nbsp;&nbsp;&nbsp;SMS Notification</label>
						</div>
						
						<div class="form-group sms_notification_div<?php echo $list['id']; ?>" style="display:<?php echo ($list['sms_notification']==1)?'block':'none'; ?>">
							<label for="email"> Total notification:</label>
							<input type="number" name="total_notification" id="total_notification<?php echo $list['id']; ?>" class="form-control phonevalidation" value="<?php echo $list['total_notification']; ?>" <?php echo ($list['sms_notification']==1)?'required':''; ?>>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="category_listing"  value="1" <?php echo ($list['category_listing']==1)?'checked':''; ?> ><label for="email">&nbsp;&nbsp;&nbsp;Category Listing</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="directory_listing"  value="1" <?php echo ($list['directory_listing']==1)?'checked':''; ?> ><label for="email">&nbsp;&nbsp;&nbsp;Directory Listing</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="unlimited_trade_category"  value="1" <?php echo ($list['unlimited_trade_category']==1)?'checked':''; ?> ><label for="email">&nbsp;&nbsp;&nbsp;Unlimited trade category</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info edit_btn<?= $list['id']; ?>" >Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		
		</div>
	</div>
</div>

<?php } ?>
<div class="modal fade in" id="add_package">
	<div class="modal-body" >
		<div class="modal-dialog">
	 
			<div class="modal-content">
         	
				<form method="post" id="add_package1" enctype="multipart/form-data">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						 <h4 class="modal-title">Add Package</h4>
					</div>
					<div class="modal-body form_width100">
						<div class="msg"><?= $this->session->flashdata('msg'); ?></div>
						<div class="form-group">
							<label for="email"> Plan Name:</label>
							<input type="text" name="package_name"  class="form-control" >
						</div>
						<div class="form-group">
							<label for="email"> Description:</label>
							<textarea name="description"  class="form-control" ></textarea>
						</div>
						<div class="form-group">
							<label for="email"> Amount:</label>
							<input type="number" name="amount" class="form-control" >
						</div>

						<div class="form-group" id="bids_per_month">
							<label>No. of bids</label>
				
							<input type="text" name="bids_per_month" class="form-control">
										
						</div>
						<div class="form-group">
				
							<input type="checkbox" name="unlimited_limited" id="myCheck" value="1" onchange="valueChanged2()"><label for="email">&nbsp;&nbsp;&nbsp;Unlimited bid</label>
										
						</div>
						
						
						<div class="form-group" id="validity_id">
							<label>Plan Validity</label>
							<div class="row">
								<div class="col-md-7">
									<input type="number" min="1" name="number_count" class="form-control">
								</div>
								<div class="col-md-5">
									<select name="validation_type" class="form-control">
										<option value="Days">Days</option>
										<option value="Weeks">Weeks</option>
										<option value="Months">Months</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
				
							<input type="checkbox" name="reward_check" id="myreward" value="1" onchange="valueChangereward()">
							<label for="email">&nbsp;&nbsp;&nbsp;Reward</label>
							<div class="form-group" id="reward_div" style="display: none;">
								<label>Reward Amount</label>
				
								<input type="text" name="reward_amount" class="form-control">
							</div>
										
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="is_free" id="is_free0" onchange="change_is_free(0)" value="1"><label>&nbsp;&nbsp;&nbsp;Free Trial</label>
						</div>
						
						<div class="form-group is_free_div0" style="display:none;">
								<label>Free Plan Validity</label>   
							<div class="row">
								<div class="col-md-7">
									<input type="number" min="1" name="number_count2" id="number_count2_0" class="form-control">
								</div>
								<div class="col-md-5">
									<select name="validation_type2" class="form-control">
										<option value="Days">Days</option>
										<option value="Weeks">Weeks</option>
										<option value="Months">Months</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="">
								<label>No. of free bids</label>
					
								<input  type="number" min="1" name="free_bids_per_month" id="free_bids_per_month_0" class="form-control phonevalidation">
											
							</div>
							<div class="form-group" id="">
								<label>No. of free sms</label>
					
								<input  type="number" min="1" name="free_sms" id="free_sms_0" class="form-control phonevalidation">
											
							</div>
						</div>

						<div class="form-group">
							<input type="checkbox" name="duration_type" value="1" id="plan_validity" onchange="plan_valid()"><label for="email">&nbsp;&nbsp;&nbsp;Unlimited Plan Validity</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="email_notification" value="1" checked><label for="email">&nbsp;&nbsp;&nbsp;Email Notification</label>
						</div>
			
						<div class="form-group">
							<input type="checkbox" name="sms_notification" id="sms_notification0" onchange="change_sms_noti(0)" value="1" checked><label for="email">&nbsp;&nbsp;&nbsp;SMS Notification</label>
						</div>
						<div class="form-group sms_notification_div0">
							<label for="email"> Total notification:</label>
							<input type="number" name="total_notification" id="total_notification0" class="form-control" required>
						</div>
						<div class="form-group">
							<input type="checkbox" name="category_listing"  value="1" ><label for="email">&nbsp;&nbsp;&nbsp;Category Listing</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="directory_listing"  value="1" ><label for="email">&nbsp;&nbsp;&nbsp;Directory Listing</label>
						</div>
						<div class="form-group">
							<input type="checkbox" name="unlimited_trade_category"  value="1" ><label for="email">&nbsp;&nbsp;&nbsp;Unlimited trade category</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info signup_btn" >Save</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>


<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script>
$("#add_package1").submit(function (event) {	
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Packages/add_package',
		 data: new FormData(this),
		dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
		beforeSend:function(){       
			$('.signup_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
			$('.signup_btn').prop('disabled',true);
			$('.msg').html('');
		},
		success:function(resp){
			if(resp.status==1){
				location.reload();
			} else {
				$('.msg').html(resp.msg);
				$('.signup_btn').html('Save');
				$('.signup_btn').prop('disabled',false);
			}
		}
	});
	return false;
});
	 
function change_sms_noti(id){
	if($('#sms_notification'+id).is(':checked')){
		$('.sms_notification_div'+id).show();
		$('#total_notification'+id).attr('required','required');
	
	} else {
		$('.sms_notification_div'+id).hide();
		$('#total_notification'+id).removeAttr('required','required');
	}
}

function change_is_free(id){
	if($('#is_free'+id).is(':checked')){
		$('.is_free_div'+id).show();
		$('#number_count2_'+id).attr('required','required');
		$('#free_bids_per_month_'+id).attr('required','required');
		$('#free_sms_'+id).attr('required','required');
	
	} else {
		$('.is_free_div'+id).hide();
		$('#number_count2_'+id).removeAttr('required','required');
		$('#free_bids_per_month_'+id).removeAttr('required','required');
		$('#free_sms_'+id).removeAttr('required','required');
	}
}
function edit_count(id){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Packages/edit_package/'+id,
		data: new FormData($('#edit_count'+id)[0]),
		dataType: 'JSON',
        processData: false,
        contentType: false,
        cache: false,
		beforeSend:function(){
			$('.edit_btn'+id).prop('disabled',true);
			$('.edit_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
			$('.editmsg'+id).html('');
		},
		success:function(resp){
			if(resp.status==1){
				location.reload();
			} else if(resp.status==2)
			{
				location.reload();
			}

			else {
				$('.edit_btn'+id).prop('disabled',false);
				$('.edit_btn'+id).html('Save');
				$('.editmsg'+id).html(resp.msg);
			}
		}
	});
	return false;
}

  function valueChanged2()
  {
     if($('#myCheck').is(":checked"))  
     {
     	    $("#bids_per_month").hide();
     } 
     
     else
     {
  
         $("#bids_per_month").show();
     }
  
  }
  function valueChangereward()
  {
  	     if($('#myreward').is(":checked"))  
     {
     	    $("#reward_div").show();
     } 
     
     else
     {
  
         $("#reward_div").hide();
     }
  }
  function valueChangereward1(id)
  {
  	  	     if($('#myreward'+id).is(":checked"))  
     {
     	    $("#reward_div"+id).show();
     	    $("#reward_div"+id).show();
     } 
     
     else
     {
  
         $("#reward_div"+id).hide();
          $("#reward_div"+id).hide();
     }
  }
   function valueChanged1(id)
  {

     if($('#myChecks'+id).is(":checked"))  
     {
     	    $("#bids_per_months"+id).hide();
     } 
     
     else
     {
  
         $("#bids_per_months"+id).show();
     }
  
  }
  function plan_valids(id)
  {
  	     if($('#plan_validities'+id).is(":checked"))  
     {
     	    $("#valid"+id).hide();
     } 
     
     else
     {
  
         $("#valid"+id).show();
     }
  }
  function plan_valid()
  {
  	     if($('#plan_validity').is(":checked"))  
     {
     	    $("#validity_id").hide();
     } 
     
     else
     {
  
         $("#validity_id").show();
     }
  }

  function Package_status(id,status){
	$.ajax({
		type:'POST',
		url:site_url+'Admin/Admin/package_status/',
		data:{'id':id,'status':status},
		dataType: 'JSON',
		beforeSend:function(){
			$('.status_change'+id).prop('disabled',true);
			$('.status_change'+id).html('<i class="fa fa-spin fa-spinner"></i>process');
		},
		success:function(resp){

			if(status==0){
               var status=1
               var addbtnclass='btn-primary';
               var btn = 'Activate';
			}else{
			   var status=0
               var addbtnclass='btn-danger';
               var btn = 'Deactivate';
			}

            if(resp.result==1){
            location.reload();
			/*$('#status_append'+id).html('<button class="btn btn-xs btn-'+addbtnclass+' status_change'+id+' " onclick="Package_status('+id+',\''+status+'\');">'+btn+'</button>');*/
		    }

		}
	});
  }

</script>

<?php include_once('include/footer.php'); ?>
  


