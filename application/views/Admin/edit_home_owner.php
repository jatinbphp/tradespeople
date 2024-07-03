<?php include_once('include/header.php'); ?>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
<style>.us_er3 a{	color:#fff !important;	background:#1e282c;	border-left-color:#ff797a !important;}
.custo {margin-top: 15px;}</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit User</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User</li>
      </ol>
	  
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        <div class="box">
          <div class="div-action pull pull-right" style="padding-bottom:20px;">
          </div> 
          <div class="box-body">
		  <?php 
			if($this->session->flashdata('error'))
			{
				?>
				<p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
				<?php
			}
			if($this->session->flashdata('success'))
			{
				?>
				<p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
				<?php
			}
			?>
		
			<div class="row"> 
			<div class="col-sm-8">			
			<form method="POST" id="result_form"  onsubmit="return edituser(<?php echo $userinfo['id']; ?>);" enctype='multipart/form-data' >
            
			<div class="form-group">
				<label for="email">Profile Image</label>
				<input type="file" name="profile_img" class="form-control" >
				<img width="100" height="100" src="<?php echo base_url('img/profile/'.$userinfo['profile']); ?>" >
			 </div>
			 
			 <div class="form-group">
				<label for="email">First Name:</label>
				<input type="text" name="f_name" value="<?php echo $userinfo['f_name']; ?>" required class="form-control" >
			 </div>
			  <div class="form-group">
				<label for="email">Last Name:</label>
				<input type="text" name="l_name" value="<?php echo $userinfo['l_name']; ?>" required class="form-control" >
			 </div>
			 <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" required name="email" value="<?php echo $userinfo['email']; ?>" class="form-control" >
			 </div>
			 	<div id="msg" style="color: red"></div>
			  <div class="form-group">
				<label for="email">Password:</label>
				<input type="password" required name="password" value="<?php echo $userinfo['password']; ?>" class="form-control" >
			 </div>
			  <div class="form-group">
            <label for="email">Company:</label>
           <input type="text" name="company" value="<?php echo $userinfo['company']; ?>" class="form-control" >
        
       </div>
			 <div class="form-group">
				<label for="email">About Business:</label>
				<textarea class="form-control" name="about_business" id="about_business"><?php echo $userinfo['about_business']; ?></textarea>
			 </div>
			 <div class="form-group">
				<label for="email">County:</label>
				  <select class="form-control" name="county_id" id="county_id" onchange="return getcity($(this).val())">
                  <option>Select County</option>   
              <?php $get_region=$this->Common_model->getRows('tbl_region');
                      foreach ($get_region as $reg) {
                        ?>
                          <option value="<?php echo $reg['id']; ?>" <?php if($userinfo['county']==$reg['id']){ echo "selected"; } ?>><?php echo $reg['region_name']; ?></option>
                        <?php
                      }
                 ?>
                      
            </select>
			 </div>
			 <div class="form-group">
				<label for="email">City:</label>
                <?php $get_city=$this->Common_model->newgetRows('tbl_city',array('county_id'=>$userinfo['county']));?>
                                       <select name="city" id="city" class="form-control input-md">
              <option value="">Select a City</option>
              <?php foreach ($get_city as $c) {
               ?>
              <option value="<?php echo $c['id']; ?>" <?php if($c['id']==$userinfo['city']){ echo "selected"; } ?>><?php echo $c['city_name']; ?></option>
            <?php } ?>
            </select>
				
			 </div>

			  <div class="form-group">
				<label for="email">Postal Code:</label>
			  <input type="text" placeholder="PostCode" value="<?php echo $userinfo['postal_code']; ?>" name="postal_code" class="form-control">
				<input name="lat" id="e_lat" value="" type="hidden" value="">
												<input value="" name="lng" id="e_lng" type="hidden" value="">
			 </div>
		
           
			 <div class="form-group">
				<label for="email">Phone:</label>
				<input type="text" name="phone"  value="<?php echo $userinfo['phone_no']; ?>" required class="form-control phonevalidation" >
					 	<div id="msg1" style="color: red"></div>
			 </div>


	

    


               <div>
				<button type="submit" class="btn btn-info" >Save</button>             
               </div>
			   </form>
			</div>
			</div>
			
			   </div>
        </div>
      </div>
    </div>
  </section>
 </div>

 <script>
	$(function(){
	
	$("#geocomplete").geocomplete({
		details: "form",
		types: ["geocode", "establishment"],
	});
	$("#find").click(function(){
	  $("#geocomplete").trigger("geocode");
	});
});
</script>
 <script>
 function edituser(id)
{
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('Admin/Admin/update_tradesmen/') ?>'+id,
			data: new FormData($('#result_form')[0]),
			dataType : 'JSON',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				
			},
			success: function (data) {
				
				if (data == 1) {
                    window.location.href = site_url+'tradesmen_user';
					
				}
				else if (data == 2) {
					$('#msg').html('This email address already registered with us!');
					return false;
				}
				return false;
			}
		});
		return false;
	
}
function getcity(val)
{
  $.ajax({
      url:site_url+'home/get_city',
      type:"POST",
      dataType:'json',
      data:{'val':val},
      success:function(datas)
      {
      
       $('#city').html(datas.cities);
  
        return false;
      }
  });
  return false;
  
}
 
	 </script>
	  <script type="text/javascript">
	  	$('.showthis').hide();
        $('.trigger').click(function(){
this.checked?$('.showthis').show():$('.showthis').hide(); //time for show
});

</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
               // alert("Checkbox is checked.");
            }
            else if($(this).prop("checked") == false){
               // alert("Checkbox is unchecked.");
            }
        });
    });
</script>
<?php include_once('include/footer.php'); ?>