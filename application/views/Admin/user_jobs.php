<?php 
include_once('include/header.php');
if(!in_array(9,$my_access)) { redirect('Admin_dashboard'); }

$get_commision=$this->Common_model->get_commision(); 

$closed_date=$get_commision[0]['closed_date'];
?>
<style>
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
<div class="content-wrapper">

  <section class="content-header">
    <h1>Job Posts</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Job Posts</li>
    </ol> 
    <?=$this->session->flashdata('responseMessage');?>
  </section>

  <section class="content">
  
    <div class="row">
    
      <div class="col-xs-12">
      
        <div class="box">
					<?php
					$first_checkbox = $this->Common_model->get_single_data('show_page',array('id'=>1));
					?>
          <div class="div-action text-right" style="padding-bottom:10px;padding-top:10px; margin-right: 25px;"> 
						<b>Find job page:</b> 
						<label class="radio-inline"><input type="radio" onchange="make_job_page_publicly(1);" <?php echo ($first_checkbox['status']==1) ? 'checked':''; ?> name="first_checkbox">Make public</label>
						<label class="radio-inline"><input type="radio" onchange="make_job_page_publicly(0);" <?php echo ($first_checkbox['status']==0) ? 'checked':''; ?> name="first_checkbox">Make Private</label>
						<div class="checkbox">
							
						</div>
					</div> 
          
          <div class="box-body">
						
      <div class="table-responsive">
            
            <table id="boottable11" class="table table-bordered table-striped">
            
              <thead>
              
                <tr> 
                  <th class="hide">S.NO</th> 
                  <th>Job ID</th> 
                  <th>User</th> 
                  <th>Job Title</th>
                  <th>Job Description</th>
                  <th>Price</th> 
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Postcode</th>
                  <th>Create Date</th>  
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                
              </thead>
              
              <tbody>
              
                <?php
                
                $x=1;
                
                foreach($user_jobs as $lists) {
                  
                  $user=$this->Common_model->get_userDataByid($lists['userid']);
                  $category_name="";
                  if($lists['category']){
                    $where='cat_id = '.$lists['category'].'';
                    $category=$this->Common_model->get_all_data('category',$where);
                    if(count($category)>0){
                     $category_name='';
                     foreach ($category as $key => $value) {
                      $category_name .= $value['cat_name'];
                     }
                    }
                  }
                  $subcat="";
                  if($lists['subcategory'])
                  { 
                    $where1='cat_id ='.$lists['subcategory'].'';
                    $subcategory=$this->Common_model->get_all_data('category',$where1);
                    if(count($subcategory)>0){
                     $subcat='';
                     foreach ($subcategory as $key => $value) {
                      $subcat .= $value['cat_name'];
                     }
                    }

                  }
                ?>

                <?php $get_total_bids=$this->Common_model->get_single_data('tbl_jobpost_bids',array('job_id'=>$lists['job_id'])); ?>
                <tr role="row" class="odd">
                  <td class="hide"><?php echo $x; ?></td>  
                  <td><?php echo $lists['project_id']; ?></td>  
                  <td><?php echo $user['f_name']." ".$user['l_name']; ?></td>
                  <td><?php echo $lists['title']; ?></td>
                  <td>
                      <?php if(strlen($lists['description'])<100){
                         echo strip_tags($lists['description']);
                       }else{
                         echo substr(strip_tags($lists['description']), 0,100).'... <a type="button"  data-toggle="modal" href="javascript:void(0);" data-target="#job_description'.$lists['job_id'].'">Read more</a>';
                       } ?>       
                  </td>
                  <td><?php echo ($lists['budget'])?'£'.$lists['budget']:''; ?><?php echo ($lists['budget2'])?' - £'.$lists['budget2']:''; ?></td>      
                  <td><?php echo $category_name; ?></td>
                  <td><?php echo $subcat; ?></td>
                   <td><?php echo $lists['post_code']; ?></td>
                  <td><?php echo date('d-m-Y',strtotime($lists['c_date'])); ?></td>
                  <td>
                      <?php 
											
											$datesss= date('Y-m-d', strtotime($lists['c_date']. ' + '.$closed_date.' days'));

											if(($lists['status']==3 || $lists['status']==1 || $lists['status']==0) && (date('Y-m-d')<$datesss)){
												echo '<span class="label label-success" style="width:44px;">New</span>';
												
											} else if(($lists['status']==4) && (date('Y-m-d') < $datesss)){
												
												echo '<span class="label label-success" style="width:44px;">AWAITING ACCEPTANCE</span>';
												
											}else if($lists['status']==5){
												
												echo '<span class="label label-success" style="width:44px;">COMPLETED</span>';
											
											}else if(($lists['status']==7) && (date('Y-m-d')<$datesss)){
											
												echo '<span class="label label-success" style="width:44px;">ACCEPTED</span>';
											
											}else if($lists['status']==6 || $lists['status']==10){
											
												echo '<span class="label label-success" style="width:44px;">DISPUTE</span>';
												
											}else if(empty($get_total_bids)){
												
												echo '<span class="label label-success" style="width:44px;">CLOSED</span>';
												
											
											}else if($lists['status']==8){
											
												echo '<span class="label label-success" style="width:44px;">REJECTED</span>';
											
											} if(($list['status']==0 || $list['status']==1 || $list['status']==2 || $list['status']==3) && !empty($get_total_bids)){ 
                
                  echo  '<span class="label label-success">Open</span>';
                  
                 }
												
                      ?>
                  </td>
                  <td>
                    <?php if($lists['status'] == 0 || $lists['status'] == 1){ ?>
										<button type="button" onclick="delete_job(<?=$lists['job_id'];?>);" class="btn btn-danger btn-xs"> Delete </button> 
                    <?php } ?>
										<a href="<?php echo site_url().'Admin/post/edit/'.$lists['job_id']; ?>" class="btn btn-primary btn-xs"> Edit </a>
                  </td>
                </tr>

                 

  <!-- Modal -->
  <div class="modal fade" id="job_description<?= $lists['job_id']; ?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Job Description</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $lists['description']; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
                
              <?php $x++; } ?>
              
              </tbody>
              
            </table>   
        </div>
      
          </div>
          
        </div>
        
      </div>
      
    </div>
    
  </section>
  
</div>
<script>
  $(document).ready(function(){
    mark_read_in_admin('tbl_jobs',"1=1");
  });
	
	function make_job_page_publicly(status){
		
		$.ajax({
			type:'POST',
			url:site_url + 'Admin/post/make_job_page_publicly',
			data: {
				'status' : status
			},
			dataType: 'JSON',
			success:function(response){
				toastr.success(response.msg);
			}
		});
	}

  function delete_job(job_id){
    if(confirm("Are you sure want to delete this job? You cannot undo this action and everything related to this job will be deleted too.")){
      $.ajax({
        type:'POST',
        url:site_url + 'Admin/Admin/delete_job',
        data: {
          'job_id' : job_id
        },
        dataType: 'JSON',
        beforeSend:function(){
          
        },
        success:function(response){
          location.reload();
        }
      });
      
    }
  }
$(function(){
	$('#boottable11').DataTable({
		//order:false
		"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
		"pageLength": 25,
		"ordering":false
	})
})
</script>
<?php include_once('include/footer.php'); ?>



  