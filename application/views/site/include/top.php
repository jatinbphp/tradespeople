<?php
$page_name=$this->uri->segment(1);

if(!isset($post_id) && $this->uri->segment(1)!='dispute') {
	$post_id=$_REQUEST['post_id']; 
	if(!$post_id && $this->uri->segment(3)){ 
		$post_id=$this->uri->segment(3); 
	} 
}

if($post_id){
	$get_job_detail=$this->common_model->get_single_data('tbl_jobs',array('job_id'=>$post_id,'is_delete'=>0));
	if($get_job_detail==false){
		redirect('dashboard');
	}
	if($user_data['type']==2 && $get_job_detail['userid'] != $user_data['id']){
		redirect('dashboard');
	}
	$get_commision=$this->common_model->get_commision(); 

	$closed_date=$get_commision[0]['closed_date'];

	$review_days = $get_commision[0]['feedback_day_limit'];

	$review_close_date = date('Y-m-d', strtotime($get_job_detail['update_date']. ' + '.$review_days.' days'));

	$datesss= date('Y-m-d', strtotime($get_job_detail['c_date']. ' + '.$closed_date.' days')); 
	
	$admin= $this->common_model->get_single_data('admin',['id'=>1]); 
	$exp_date= date('Y-m-d H:i:s', strtotime($get_job_detail['c_date']. ' + '.$admin['waiting_time_accept_offer'].' days')); 
	$get_post_bid=$this->common_model->get_post_bids('tbl_jobpost_bids',$post_id,$user_data['id']);
		
	$get_post_bids=$this->common_model->get_post_bidss('tbl_jobpost_bids',$post_id,$user_data['id']);
}
?>
<div class="menu-for-mobile">
	<?php include('sidebar.php');?>
</div>
<style>
.liskk2 .dropdown-menu li {
	width: 100%;
}
.liskk2 .dropdown-menu li a {
	padding: 6px 10px;
	color: #fff;
	background: transparent;
	width: 100%;
	display: inline-block;
	border:none;
}
.liskk2 .dropdown-menu {
	background: #0E1724;
	margin-top: 0;
    border-radius: 0;
}
.liskk2 .dropdown-menu li a:hover{
	color:#3d78cb;
}
.tox-toolbar__primary, .tox-editor-header{
	display:none !important;
}
</style>
<div class="gray-head">
	<div class="container">
		<div class="top_manin_he1">
			
			<?php $get_total_bidd=$this->common_model->get_single_data('tbl_jobpost_bids',['job_id'=>$get_job_detail['job_id']]); ?>
			<h3 class="pull-left"><?php echo $get_job_detail['title']; ?></h3>
            
			<?php 
			//print_r($get_job_detail);
			if($page_name=='details' || $page_name=='proposals' || $page_name=='files' || $page_name=='task' || $page_name=='reviews' || $page_name=='details' || $page_name=='payments' || $page_name=='dispute')  { ?>
        <button class="btn btn-primary pull-right top-project-status">
				
				
				<?php if(($get_job_detail['status']==3 || $get_job_detail['status']==1 || $get_job_detail['status']==0) && empty($get_total_bidd)) { ?>
					
				OPEN
					
				<?php }else if(($get_job_detail['status']==4)){ ?>
				
				AWAITING ACCEPTANCE
				
				<?php }else if($get_job_detail['status']==5){ ?>
				
				COMPLETED
				
				<?php }else if(($get_job_detail['status']==7)){ ?>
				
				ACCEPTED
				
				<?php }else if(($get_job_detail['status']!=3 || $get_job_detail['status']!=4 || $get_job_detail['status']!=5 || $get_job_detail['status']!=7) && empty($get_total_bidd) && (date('Y-m-d') > $exp_date)){ ?>
				
				CLOSED
				
				<?php }else if($get_job_detail['status']==6 || $get_job_detail['status']==10 && (date('Y-m-d') < $datesss)){ ?>
				
				DISPUTE
				
				<?php }else if($get_job_detail['status']==8){ ?>
				
				REJECTED

				<?php }else if(date('Y-m-d') < $exp_date){ ?>
								
					Open
				
				<?php } else if ($get_total_bidd) { ?>

					Open
				<?php }  ?>

				
				</button>
			<?php } ?>
		</div>
        
		<div class="liskk2">
			<?php if($page_name=='details' || $page_name=='proposals' || $page_name=='files' || $page_name=='task' || $page_name=='reviews' || $page_name=='details' || $page_name=='payments' || $page_name=='dispute' || $page_name=='proposals_edit')  { ?>
				<ul class="ul_set">
				
					<li <?php if($page_name=='details'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('details?post_id='.$post_id); ?>">Details</a></li>
					
					<li <?php if($page_name=='proposals'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('proposals?post_id='.$post_id); ?>">Quotes</a></li>
					
					<?php if((count($get_post_bid)>0 && $get_post_bid[0]['status']==0) && ($get_job_detail['status']!=4 && $get_job_detail['status']!=7 && $get_job_detail['status']!=5)){  ?>
						<!-- <li <?php if($page_name=='proposals_edit'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('proposals_edit?post_id='.$post_id); ?>">Edit</a></li> -->
						<li class="dropdown">
							<a href="" class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">More</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

								<li <?php if($page_name=='proposals_edit'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('proposals_edit?post_id='.$post_id); ?>">Edit</a></li>
								
								<li role="presentation"><a href="<?php echo site_url('posts/delete_bid/'.$get_post_bid[0]['id'].'/'.$post_id); ?>" onclick="return confirm('Are you sure! you want to retract your quote?');" role="menuitem">Retract</a></li>
								
							</ul>
						</li>


					<?php } ?>
					<?php if(count($get_post_bid)>0){ 
					
						if($get_post_bid[0]['status']==3 || $get_post_bid[0]['status']==4 || $get_post_bid[0]['status']==7 || $get_post_bid[0]['status']==5 || $get_post_bid[0]['status']==10){ ?> 
						
						<li <?php if($page_name=='payments' || $page_name=='dispute'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('payments/?post_id='.$post_id); ?>">Payments</a></li>
						
						<?php } 
					
					}else if(count($get_post_bids)>0){ 
					
						if($get_post_bids[0]['status']==3 || $get_post_bids[0]['status']==4 || $get_post_bids[0]['status']==7 || $get_post_bids[0]['status']==5 || $get_post_bids[0]['status']==10){ ?>
					
						<li <?php if($page_name=='payments' || $page_name=='dispute'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('payments/?post_id='.$post_id); ?>">Payments</a></li>
					
						<?php } 
						
					} else if($page_name=='dispute'){ ?>
					
						<li <?php if($page_name=='dispute'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('payments/?post_id='.$post_id); ?>">Payments</a></li>
					
					<?php } ?>
							
					<?php if(count($get_post_bid)>0){ 
					
						if($get_post_bid[0]['status']==3 || $get_post_bid[0]['status']==4 || $get_post_bid[0]['status']==7 || $get_post_bid[0]['status']==5 || $get_post_bid[0]['status']==10){ ?> 
					
						<li <?php if($page_name=='files'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('files/?post_id='.$post_id); ?>">Files</a></li>
					
						<?php } 
						
					}else if(count($get_post_bids)>0){ 
					
						if($get_post_bids[0]['status']==3 || $get_post_bids[0]['status']==4 || $get_post_bids[0]['status']==5 || $get_post_bids[0]['status']==7 || $get_post_bids[0]['status']==10){ ?>
					
						<li <?php if($page_name=='files'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('files/?post_id='.$post_id); ?>">Files</a></li>
					
						<?php }

					} else if($page_name=='dispute'){ ?>
					
						<li <?php if($page_name=='files'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('files/?post_id='.$post_id); ?>">Files</a></li>
					
					<?php } ?>
								 

								 
					<?php if(count($get_post_bid)>0){ 
					
						if($get_post_bid[0]['status']==7 || $get_post_bid[0]['status']==3 || $get_post_bid[0]['status']==4){ 
						
							if($get_job_detail['status']==5){ 
								if(strtotime($review_close_date) >= strtotime(date('Y-m-d'))){ 
								?> 
						
									<li <?php if($page_name=='reviews'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('reviews?post_id='.$post_id); ?>">Reviews</a></li>
						
								<?php } 
							} 
							
						} 
					}else if(count($get_post_bids)>0){ 
					
						if($get_post_bids[0]['status']==7 || $get_post_bids[0]['status']==3 || $get_post_bids[0]['status']==4){ 
					
							if($get_job_detail['status']==5){ 
								if(strtotime($review_close_date) >= strtotime(date('Y-m-d'))){
									?>
					
									<li <?php if($page_name=='reviews'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('reviews?post_id='.$post_id); ?>">Reviews</a></li>
					
								<?php } 
							} 
						} 
					} ?>
										
					<?php if($this->session->userdata('type')==2){ ?>
					<?php $tbl_bids = $this->common_model->get_single_data('tbl_jobpost_bids',['job_id'=>$post_id]); ?>
					<?php if(empty($tbl_bids)) {
						 
					?>
					<?php if($get_job_detail['status']==0 || $get_job_detail['status']==1 || $get_job_detail['status']==3 || $get_job_detail['status']==8 || $get_job_detail['status']==9){
						//echo $datesss;
						//echo date('Y-m-d');
						//print_r($get_job_detail);
					?>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">More</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
						
							<li role="presentation"><a href="javascript:void(0);"  data-toggle="modal" data-target="#edit_post<?php echo $post_id; ?>" role="menuitem" >Edit</a></li>
							
							<li role="presentation"><a href="<?php echo site_url('posts/delete_post/'.$post_id); ?>" onclick="return confirm('Are you sure! you want to delete this post?');" role="menuitem" href="#">Delete</a></li>
							
							<?php if(strtotime(date('Y-m-d')) > strtotime($datesss)){ ?>
							
							<li role="presentation"><a href="<?php echo site_url().'newPost/repost/'.$post_id.'/'.$page_name; ?>" onclick="return confirm('Are you sure you want to repost job')" role="menuitem">Repost</a></li>
							
							<?php } ?>
						</ul>
					</li>
					
					<?php } } ?>
					<?php } else { ?>
						<?php if($get_post_bid){ ?>
						
						<?php if($user_data['id']==$get_job_detail['awarded_to']){ ?>
					
						<?php } else { ?>
						
							<?php if((date('Y-m-d H:i:s')>=$datesss) && $get_post_bid[0]['status']==0 && $get_job_detail['status']!=7 && $get_job_detail['status']!=5 && $get_job_detail['status']!=4 && $get_job_detail['direct_hired']==0){ ?>
							
							<li class="dropdown">
								<a href="" class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">More</a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
								
									<li role="presentation"><a href="<?php echo base_url('details?post_id='.$post_id); ?>" role="menuitem" >Edit</a></li>
									
									<li role="presentation"><a href="<?php echo site_url('posts/delete_bid/'.$get_post_bid[0]['id'].'/'.$post_id); ?>" onclick="return confirm('Are you sure! you want to retract your quote?');" role="menuitem">Retract</a></li>
									
								</ul>
							</li>
							
							<?php } ?>
						
						<?php } ?>
						
						<?php } ?>
					<?php } ?>
					
				</ul>
				
			<?php } else{ ?>
            
				<ul class="ul_set">
								 
					<li <?php if($page_name=='my_posts' || $page_name=='in_progress' || $page_name=='completed_jobs'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('my-posts'); ?>">My Jobs</a></li>
								
					<li <?php if($page_name=='dashboard'){ ?>class="active"<?php } ?>><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
								 
					<li><a href="<?php echo base_url('inbox'); ?>">Inbox</a></li>
								
					<!--li><a href="<?php echo base_url('my_reviews'); ?>">Feedback</a></li-->
						 
				</ul>
				
			<?php } ?>

		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	//$('.liskk2 a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
})
</script>

<?php if($this->session->userdata('type')==2){ ?>
					
<?php if($page_name=='details' || $page_name=='proposals' || $page_name=='files' || $page_name=='task' || $page_name=='reviews' || $page_name=='details' || $page_name=='payments' || $page_name=='dispute')  { ?>
	
<?php if($get_job_detail['status']==0 || $get_job_detail['status']==1 || $get_job_detail['status']==3 || $get_job_detail['status']==8 || $get_job_detail['status']==9){

$category_1 = $this->common_model->get_parent_category('category');

$get_avg_bid=$this->common_model->get_avg_bid($this->session->userdata('user_id'),$post_id); 

if($get_avg_bid[0]['average_amt']){
	$editable = false;
} else {
	$editable = true;
}
?>


<div class="modal fade in" id="edit_post<?php echo $post_id; ?>">
  <div class="modal-body" >
    <div class="modal-dialog">
   
      <div class="modal-content">

        <form onsubmit="return edit_post(<?php echo $post_id; ?>);" id="edit_post1<?php echo $post_id; ?>" method="post"  enctype="multipart/form-data">
          <div class="modal-header">
            <div class="editmsg<?php echo $post_id; ?>" id="editmsg<?php echo $post_id; ?>"></div>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
             <h4 class="modal-title">Edit Posts</h4>
          </div>
          <div class="modal-body">
						<div class="form-group">
							<label for="email"> Category:</label>
							<select data-placeholder="Select Category" class="form-control" onchange="return changecategory($(this).val(),<?php echo $post_id; ?>)" disabled>
								<?php $categ = $this->common_model->get_single_data('category',array('cat_id'=>$get_job_detail['category']));
										if(!empty($categ)){ ?>
											<option selected><?= $categ['cat_name'];  ?></option>
								<?php } ?>                       
							</select>  
						</div>
						<div class="form-group">
    
							<div id="subcategories<?php echo $post_id; ?>">
								<label for="email"> Subcategory:</label>
								<select data-placeholder="Select Sub Category" class="form-control" disabled>
								<?php $data_set = $this->common_model->get_single_data('category',array('cat_id'=>$get_job_detail['subcategory']));
										if(!empty($data_set)){ ?>
											<option selected><?= $data_set['cat_name'];  ?></option>
								<?php } ?>                       
							</select> 

							</div> 
						</div>
						<div class="form-group">
							<label for="email"> Title:</label>
							<input type="text" readonly <?php echo ($editable==false)?'readonly':''; ?> value="<?php echo $get_job_detail['title']; ?>"  class="form-control" >
						</div>
						<div class="form-group">
							<label for="email"> Description:</label>
							<textarea rows="5" placeholder="" name="description" class="form-control textarea"><?php echo $get_job_detail['description']; ?></textarea>
						</div>
						<div class="form-group">
							<label for="email"> Document:</label>
							<input type="file" name="post_doc[]" id="post_doc" multiple>
						</div>
						<div class="form-group">
               
							<?php 
							$attachment=$this->common_model->get_all_files($post_id);
							if($attachment){
							foreach ($attachment as $doc) {
							?>
							<div id="del_doc<?php echo $doc['id']; ?>">
								<div class="row">
									<div class="col-sm-4">
										<a href="<?php echo base_url('img/jobs/'.$doc['post_doc']); ?>" download><i class="fa fa-paperclip"></i> <?php echo $doc['post_doc']; ?></a>
									</div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-danger btn-xs" onclick="delenquiry(<?php echo $doc['id'];?>)"><i class="fa fa-close"></i></button> 
									</div>
								</div>
							</div>

        
							<?php
							} }
							?>
		
						</div>

						
						<div class="form-group">
							<label for="email"> Budget:</label>
							<input type="number" name="budget" class="form-control" value="<?php echo $get_job_detail['budget'];  ?>" min="<?php echo $get_job_detail['budget'];  ?>" required>
						</div>
						<div class="form-group">
							<label for="email"> Budget 2:</label>
							<input type="number" name="budget2" class="form-control" value="<?php echo $get_job_detail['budget2'];  ?>" min="<?php echo $get_job_detail['budget2'];  ?>" required>
						</div>


						<div class="form-group">
							<label for="email"> Postcode:</label>
							<input  value="<?php echo $get_job_detail['post_code']; ?>"  class="form-control" readonly>
							<p class="text-danger postcode-err<?= $post_id; ?>" style="display:none;">Please enter valid UK postcode</p>
						</div>


       
					</div>
					<div class="modal-footer" id="edit_modal_btn<?php echo $post_id; ?>">
						<button type="submit" class="btn btn-primary edit_btn<?= $post_id; ?>" id="edit_btn<?= $post_id; ?>">Save</button>
						<button type="button" class="btn btn-default signup_btn1" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
      
		</div>
	</div>
</div>
<script>
function changecategory(val,id) {
  $.ajax({
		url:site_url+'home/get_subcategory',
		type:"POST",
		dataType:'json',
		data:{'val':val,'id':id},
		success:function(datas) {
			$('#subcategories'+id).html(datas.subcategory);
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
      //$('.edit_btn'+id).html('<i class="fa fa-spin fa-spinner"></i> Updating...');
      $('.editmsg'+id).html('');
			$('.postcode-err'+id).hide();
    },
    success:function(resp){
      if(resp.status==1){
				
        //window.location.href = site_url+'my-posts';
				
				location.reload();
				
			} else if(resp.status==3){
				$('.postcode-err'+id).show();
				$('.edit_btn'+id).prop('disabled',false);
			}	
      else if(resp.status==2) {
         location.reload();
				 
      } else {
        $('.edit_btn'+id).prop('disabled',false);
        //$('.edit_btn'+id).html('Save');
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
}
</script>
<script>
init_tinymce();
function init_tinymce(){
	tinymce.init({
		selector: '.textarea',
		menubar: false,
		branding: false,
		statusbar: false,
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	});
}
</script>
<?php if(isset($_GET['re-post']) && !empty($_GET['re-post'])){ ?>
<script>
$(document).ready(function(){
	var job_id = '<?php echo $get_job_detail['job_id']; ?>';
	$('#edit_post'+job_id).modal('show');
	$('#edit_btn'+job_id).hide();
	$('#edit_post1'+job_id).append('<input type="hidden" name="iss_repost" value="1">');
	$('#edit_modal_btn'+job_id).prepend('<button type="submit" class="btn btn-primary edit_btn'+job_id+'" >Re-post</button>');
});
</script>
<?php } ?>

<?php } ?>
<?php } ?>
<?php } ?>

