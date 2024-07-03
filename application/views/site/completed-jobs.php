<?php include ("include/header.php") ?>
<?php include ("include/top.php") ?>
    <?php  $page_name=$this->uri->segment(1); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
 <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <style type="text/css">
    .table-responsive {
    overflow: auto;
}
@media (max-width:575.98px){
    .table-responsive-sm{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-sm>.table-bordered{
        border:0
    }
}
@media (max-width:767.98px){
    .table-responsive-md{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-md>.table-bordered{
        border:0
    }
}
@media (max-width:991.98px){
    .table-responsive-lg{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-lg>.table-bordered{
        border:0
    }
}
@media (max-width:1199.98px){
    .table-responsive-xl{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-xl>.table-bordered{
        border:0
    }
}


  </style>

<div class="acount-page membership-page project-list">
     
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 style="font-size: 20px;"><b>Jobs</b></h3>
              <?php  include("include/top_project.php") ?>
              <div class="acount-page membership-page">
<div class="container">
      <div class="user-setting">
          <div class="row">
              <div class="col-sm-12">
                  <div class="user-right-side" style="margin-top: -30px;">
                            <div class="setbox2">
                                            <?php if($this->session->flashdata('error1')) { ?>
            <p class="alert alert-danger"><?php echo $this->session->flashdata('error1'); ?></p>
            <?php } ?>
            <?php if($this->session->flashdata('success1')) { ?>
            <p class="alert alert-success"><?php echo $this->session->flashdata('success1'); ?></p>
            <?php } ?>
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
				  <th style="display: none;"></th>
                  <th>Job Id</th> 
                  <th>Job Title</th>
                  <th>Quotes</th>
			<?php if($show_buget==1){ ?>
                  <th>Budget</th>
			<?php } ?>
                  <th>Average Quote</th>
				  <th>Action</th>
                </tr>
              </thead>
              <tbody>
     <?php foreach($posts as $key=>$list) {
                ?>
                <tr>
				  <td style="display: none;"><?php  echo $key+1; ?></td>
                  <td><?php  echo $list['project_id']; ?></td>
                  <td>
					<?php
						if($list['direct_hired']==1){
							$tradesment=$this->common_model->GetColumnName('users',array('id'=>$list['awarded_to']),array('trading_name'));
							$job_title = 'Work for '.$tradesment['trading_name'];
						} else {
							$job_title = $list['title'];
						}
					?>
	<a href="<?php echo base_url('details/?post_id='.$list['job_id']); ?>"><?php echo $job_title; ?></a>
				</td>
                  <td><?php $get_total_bids=$this->common_model->get_total_bids($this->session->userdata('user_id'),$list['job_id']); echo $get_total_bids[0]['bids']; ?></td>
		<?php if($show_buget==1){ ?>
                  <td><?php echo ($list['budget'])?'£'.$list['budget']:''; ?><?php echo ($list['budget2'])?' - £'.$list['budget2']:''; ?> </td>
									<?php } ?>
                  <td><i class="fa fa-gbp"></i><?php $get_avg_bid=$this->common_model->get_avg_bid($this->session->userdata('user_id'),$list['job_id']); if($get_avg_bid[0]['average_amt']){ ?><?php echo number_format($get_avg_bid[0]['average_amt'],2); } else { echo "0"; } ?> GBP</td>
                  <td><a class="btn btn-anil_btn" href="<?php echo base_url('proposals?post_id='.$list['job_id']); ?>">View Quotes</a></td>
                        

          </tr> 
          <?php 
        }
        
        ?>
              </tbody>
            </table>
                              </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
</div>

                                 
   

                        </div>
                    </div>
              
                </div>
                </div>


            </div>
      
      
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<script>  
    /*$('.chosen-select').chosen({}).change( function(obj, result) {
    console.debug("changed: %o", arguments);
    
    console.log("selected: " + result.selected);
});*/
  $(function(){
    $("#boottable").DataTable({
      stateSave: true,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         "pageLength": 25
    });
    $(".DataTable").DataTable({
      stateSave: true
    });
  });
  </script>
<script>/*
function changecategory(val,id)
{

  $.ajax({
      url:site_url+'home/get_subcategory',
      type:"POST",
      dataType:'json',
      data:{'val':val,'id':id},
      success:function(datas)
      {
      
          $('#subcategories'+id).html(datas.subcategory);
  
        return false;
      }
  });
  return false;
}
  $(function(){
  
  $("#geocomplete").geocomplete({
    details: "form",
    types: ["geocode", "establishment"],
  });
  $("#find").click(function(){
    $("#geocomplete").trigger("geocode");
  });
});
  function update_profile(){
  $('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
  $('.submit_btn').prop('disabled',true);
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
function edit_post(id){
  $.ajax({
   type:'POST',
    url:site_url+'posts/edit_post/'+id,
   data: new FormData($('#edit_post1'+id)[0]),
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
      }
      else if(resp.status==2)
      {
         location.reload();
      } else {
        $('.edit_btn'+id).prop('disabled',false);
        $('.edit_btn'+id).html('Save');
        $('.editmsg'+id).html(resp.msg);
      }
    }
  });
  return false;
}
function delenquiry(id) {
   if (confirm("Are you sure?")) {
        $.ajax({
            type:'POST',
            url:site_url+'posts/delete_file/'+id,
            dataType: 'JSON',
             success:function(resp){
              $('#del_doc'+id).remove();
            } 
        });
    } 
  }*/
</script>
<?php include 'include/footer.php'; ?>