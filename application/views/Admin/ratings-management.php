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
.active-rating{
  color: #FF912C;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Ratings Management</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Ratings Management</li>
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
                    <th>S.NO.</th>
                    <th>Rate By</th>
                    <th>Rate To</th>
                    <th>Ratings</th>
                    <th>Job Title</th>
                    <th>Comment</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($ratings as $key => $rating){
                  ?>
                      <tr role="row" class="odd">
                        <td><?=$key + 1;?></td>
                        <td><?=$rating['by_username'];?></td>
                        <td><?=$rating['to_username'];?></td>
                        <td>
                          <?php
                            for($i = 1; $i <= 5; $i++){
                              $class = ($i <= $rating['rt_rate']) ? 'fa fa-star active-rating' : 'fa fa-star';
                              echo '<i class="' .$class .'"></i>';
                            }
                          ?>
                        </td>
                        <td><?= ($rating['title']) ? $rating['title'] : 'Work for '.$rating['trading_name'];?></td>
                        <td><?=substr($rating['rt_comment'], 0, 100);?></td>
                        <td>
                          <button type="button" data-toggle="modal" data-target="#editRatingModal<?=$rating['tr_id'];?>"> Edit </button>
                          <button type="button" onclick="delete_rating(<?=$rating['tr_id'];?>);" > Delete </button>
                          <!-- Modal -->
                          <div class="modal fade" id="editRatingModal<?=$rating['tr_id'];?>" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <form method="post" id="updateRatingForm<?=$rating['tr_id'];?>" name="updateRatingForm<?=$rating['tr_id'];?>" onsubmit="update_rating(event, <?=$rating['tr_id'];?>);">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Rating</h4>
                                    <input type="hidden" name="ratingId" value="<?=$rating['tr_id'];?>" />
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label>Review</label>
                                      <textarea class="form-control" type="text" name="rt_comment" required><?=$rating['rt_comment'];?></textarea>
                                    </div>
                                    <div class="form-group">
                                      <label>Rating</label>
                                      <select name="rt_rate" class="form-control" required>
                                        <?php
                                          for($a = 1; $a <= 5; $a++){
                                            $selected = ($rating['rt_rate'] == $a) ? 'selected' : '';
                                        ?>
                                            <option value="<?=$a;?>" <?=$selected;?> > <?=$a;?> </option>
                                        <?php
                                          }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-default" >Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <!-- Modal -->
                        </td>
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
  </section>
</div>
<script>
  function update_rating(e, ratingId){
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: '<?=site_url();?>Admin/Admin/update_rating',
      contentType: false,
      cache: false,
      processData:false,
      data: new FormData($('#updateRatingForm' + ratingId)[0]),
      dataType: "JSON",
      success:function(response){
        if(response.status == 1){
          toastr.success('Rating updated successfully');
        }else{
          toastr.error('Something went wrong. Try later');
        }
        $('#editRatingModal' + ratingId).modal('toggle');
        location.reload();
      }
    });
  }

  function delete_rating(ratingId){
    if(confirm("Are you sure want to delete this rating?")){
      $.ajax({
        type: "POST",
        url: '<?=site_url();?>Admin/Admin/delete_rating',
        data: {
          ratingId: ratingId
        },
        dataType: "JSON",
        success:function(response){
          if(response.status == 1){
            toastr.success('Rating deleted successfully');
          }else{
            toastr.error('Something went wrong. Try later');
          }
          location.reload();
        }
      });
    }
  }

</script>
<script>
$(document).ready(function(){
	mark_read_in_admin('rating_table',"1=1");
});
</script>