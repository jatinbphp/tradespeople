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
    
  </section>

  <section class="content">
  
    <div class="row">
    
      <div class="col-xs-12">
      
        <div class="box">
        
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
          
          <div class="box-body">
          
      <div class="table-responsive">
            
            <table id="boottable" class="table table-bordered table-striped">
            
              <thead>
              
                <tr> 
                  <th>S.NO</th> 
                  <th>User</th> 
                  <th>Job Title</th>
                  <th>Job Description</th>
                  <th>Price</th> 
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Postcode</th>
                  <th>Create Date</th>  
                     <th>Status</th>               
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
             
                <tr role="row" class="odd">
                  <td><?php echo $x; ?></td>  
                  <td><?php echo $user['f_name']." ".$user['l_name']; ?></td>
                  <td><a href="<?php echo base_url(); ?>details/?post_id="><?php echo $lists['title']; ?></td>
                  <td>
                      <?php if(strlen($lists['description'])<100){
                         echo $lists['description'];
                       }else{
                         echo substr($lists['description'], 0,100).'...<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#job_description'.$lists['job_id'].'">Read more</button>';
                       } ?>       
                  </td>
                  <td>
										 <?php echo ($lists['budget'])?'£'.$lists['budget']:''; ?><?php echo ($lists['budget2'])?' - £'.$lists['budget2']:''; ?>
                  </td>      
                  <td><?php echo $category_name; ?></td>
                  <td><?php echo $subcat; ?></td>
                   <td><?php echo $lists['post_code']; ?></td>
                  <td><?php echo date('d-m-Y',strtotime($lists['c_date'])); ?></td>
                  <td>
                      <?php 
                      if($lists['status']==0){
                        echo '<p class="btn-sm btn-primary">Signup</p>';
                      }else if($lists['status']==1){
                        echo '<p class="btn-sm btn-success" style="width:44px;">New</p>';
                      }/*else if($lists['status']==2){
                        echo '<p class="btn-sm btn-warning">Posted</p>';
                      }*/
                      ?>
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




  