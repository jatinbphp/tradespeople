<?php
    include "include/header.php";

    if (!$this->session->userdata('user_id')) {
        //redirect('login'); die;
    }
    if ($this->session->userdata('type') == 2) {
        redirect('home');die;
    }

    if ($selected_categroy['cat_image']) {
        //$default_image_class = 'banner-unique-class';
        $default_svg_opcity = '0.8';
        //$default_svg_fill = '#f9f9f9';

        $default_image_class = 'banner-unique-default';
        $default_svg_fill    = '#FFFFFF';

        $cat_img = base_url() . 'img/category/' . $selected_categroy['cat_image'];
    } else {
        $default_image_class = 'banner-unique-default';
        $default_svg_opcity  = '0.8';
        $default_svg_fill    = '#FFFFFF';
        $cat_img             = base_url() . 'img/find-tradesmen-new.png';
    }

    $get_all_categories = $this->common_model->GetColumnName('category', ['show_at_job_search' => 1, 'is_delete' => 0, 'cat_parent' => 0], null, true, 'cat_id', 'asc');
?>

<link href="css/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-ui.js"></script>
<style>
.clear-rating.clear-rating-active {
    display: none !important;
}
.caption {
    display: none !important;
}
.set-slide.banner-unique-class{
    background-position: right !important;
    background-size: 54% 100% !important;
}
.textEditorClass {
    padding: 15px;
    background: #f1f1f1;
}
.textEditorClass1 {
    padding: 15px;
}
/*.set-slide.banner-unique-class svg {
	width: 53%;
}*/

@media(max-width: 767px){
  .tradesmen-top h3 {
  font-size: 17px;
}
}
</style>
<!-- Custom banner -->
<div class="home-page catdtilslider">
	<div class="home-demo first-home" >
		<div class="">
			<div class="set-slide			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                     			                      <?php echo $default_image_class; ?>" style="background-image: url(<?php echo $cat_img; ?>); background-position: right !important;">
				<svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon opacity="<?php echo $default_svg_opcity; ?>" fill="<?php echo $default_svg_fill; ?>" points="0 0 740 0 700 650 0 650"></polygon></svg>
				<div class="container">
					<div class="row set-m-10">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="slice-text slice-text_home">
										<?php if ($selected_categroy) {?>
										<p class="nomargin headHead1"><?php echo $selected_categroy['find_job_title']; ?></p>
										<p style="margin-top: 17px;">										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                              <?php echo $selected_categroy['description']; ?></p>
										<?php } else if ($city_data2) {?>

										<p class="nomargin headHead1"><?php echo $city_data2['meta_title2']; ?></p>
										<p style="margin-top: 17px;">										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                             										                              <?php echo $city_data2['meta_description2']; ?></p>

										<?php } else {

                                                $find_job_content = $this->common_model->GetColumnName('other_content', ['id' => 2]);

                                            ?>
										<p class="nomargin headHead1"><?php echo $find_job_content['title']; ?></p>
										<p style="margin-top: 17px;"><?php echo $find_job_content['description']; ?></p>
										<?php }?>


										<div class="banner-btn">
											<a href="<?php echo base_url('signup-step1'); ?>" class="btn btn-warning btn-lg"><b>Join us now</b></a>
										</div>
									</div>
								</div>
                <div class="col-sm-6">
                </div>
							</div>
						</div>
					</div>
				</div>
				<?php //print_r($category_details); ?>
				<!-- set-bg-img class add in next div -->
			</div>
		</div>
	</div>
</div>
<div class="list-tradesmen nwess1 searc_postdd1">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 floss2">

				<div class="top-search">

			<div class="input-group">
					    <input type="text" placeholder="Search"  class="form-control" name="search1"  id="search1">
					    <span class="input-group-btn">
					  <button type="button" class="button btn btn-default" onclick="searchFilter()"><i class="fa fa-search"></i></button>
					    </span>
					</div>

				</div>
				<!-- loop -->
					<div  id="search_data">
				<?php if ($all_jobs) {
                        foreach ($all_jobs as $jobs) {
                        ?>

				<div class="tradesmen-box">
					<div class="tradesmen-top">
						<div class="row">
							<div class="col-sm-9 col-xs-7">
							<div class="pull-left">

									<div class="names">
									<a href="<?php echo base_url('details?post_id=' . $jobs['job_id']); ?>"><h4> <?=$jobs['title'];?> </h4></a>
													<span class="from-group">
										<?php $get_user = $this->common_model->get_user_by_id($jobs['userid']);
                                                    $time_ago                 = $this->common_model->time_ago($jobs['c_date']);
                                                    echo $time_ago . " by " . $get_user[0]['f_name'] . ' ' . $get_user[0]['l_name'] . "";

                                                ?>
							</span>
									</div>

							</div>
							</div>
							<div class="col-sm-3 col-xs-5">
							<div class="pull-right">
								<?php if ($show_budget == 1) {?>
								<h3><?php echo ($jobs['budget']) ? '£' . $jobs['budget'] : ''; ?><?php echo ($jobs['budget2']) ? ' - £' . $jobs['budget2'] : ''; ?></h3>
								<?php }?>
								<div class="from-group text-right" style="margin-top: 10px;">
									<?php
										if ($this->session->userdata('user_id')) {
											if ($this->session->userdata('type') == 1) {
									?>
												<a href="<?php echo base_url('details/?post_id=' . $jobs['job_id']); ?>" class="btn btn-warning">Quote Now</a>
									<?php
											}
										}else{
									?>
											<a href="<?php echo base_url('login'); ?>" class="btn btn-warning">Quote Now</a>
									<?php }?>
								</div>
								<!--<a href="javascript:void(0)" onclick="reportJobPopup(<?php echo $jobs['job_id'] ?>)" style="padding-left: 30px;">Report this job</a>-->
							</div>
							</div>
						</div>
					</div>
					<div class="tradesmen-bottom">

						<div class="tradesmen-desc">
						<p><?php echo $jobs['description']; ?> </p>
						</div>
					</div>
				</div>

			<?php	}} else {?> <div class="alert alert-warning">No jobs found.</div><?php }?>
			<?=$this->ajax_pagination->create_links();?>
		</div>


		<?php $footerText = '';?>

		<?php
            if ($selected_categroy) {
                if (strlen(strip_tags($selected_categroy['slug_footer_description'])) > 0) {
                    $footerText = $selected_categroy['slug_footer_description'];
                }
            } else if ($city_data2) {
                if (strlen(strip_tags($city_data2['jobpage_footer_description'])) > 0) {
                    $footerText = $city_data2['jobpage_footer_description'];
                }
            } else {

                $find_job_content = $this->common_model->GetColumnName('other_content', ['id' => 2]);
                if ($find_job_content && strlen(strip_tags($find_job_content['footer_description'])) > 0) {

                    $footerText = $find_job_content['footer_description'];

            }}?>
<?php if ($footerText) {

        $footerTextLen = strlen($footerText);
        $is_long_text  = false;
        if ($footerTextLen > 700) {
            $is_long_text = true;
        }
    ?>

			<div class="FooterTextFull " style="<?php echo ($is_long_text) ? 'display:none;' : '' ?>">
				<div style="padding:15px;" class="tradesmen-box set-gray-box">
				<div class="textEditorClass1">
				<?php echo $footerText; ?>
				</div> <br>
				<div class="text-center">
					<a style="display:none" class="btn text-center btn-default read-more-footer-btn2" href="javascript:void(0);" onclick="$('.FooterTextShort').show(); $('.FooterTextFull').hide();">Hide</a>
				</div>
				</div>

			</div>
			<div class="FooterTextShort " style="<?php echo ($is_long_text) ? '' : 'display:none;' ?>">
				<div style="padding:15px;" class="tradesmen-box set-gray-box">
				<div class="textEditorClass">
					<?php echo html_cut($footerText, 700); ?>
				</div> <br>
				<div class="text-center">
					<a class="btn text-center btn-default read-more-footer-btn" href="javascript:void(0);" onclick="$('.FooterTextShort').hide(); $('.FooterTextFull').show(); $('.read-more-footer-btn2').show();">Read more</a>
				</div>
				</div>
			</div>


			<?php }?>

		</div>
			<div class="col-sm-4 floss1">
				<div class="fat-side-item fiilter">
					<h4>Narrow down your search</h4>
					<div class="from-group hide">
						<label>Location</label>
						<div class="from-group">
					    <input placeholder="Location" class="form-control" name="location" id="location" type="text" onchange="searchFilter();">
					    <span class="input-group-btn">

					    </span>
					</div>
					</div>
											<div class="from-group">
												<label>Category</label>

						<select class="form-control" name="category_id"  id="category_id" onchange="searchFilter1(this.value);">
							<option value="">Select Category</option>
							<?php	foreach ($get_all_categories as $c) {
                                    $selected = (isset($selected_categroy) && $selected_categroy['cat_id'] == $c['cat_id']) ? 'selected' : '';
                                ?>
							<option<?php echo $selected; ?> value="<?php echo $c['slug']; ?>"><?php echo $c['cat_name']; ?></option>
						<?php }?>


						</select>
					</div>

					 <button type="submit" class="button btn btn-default" onclick="searchFilter();">Search</button>
				</div>
				<div class="Locations_list11 fat-side-item open_omon2">
					<h4>Top Categories</h4>
					<ul class="ul_set lislocc1">
									<?php
                                        foreach ($get_all_categories as $c) {
                                        ?>
							<li><a href="<?php echo base_url('find-jobs/' . $c['slug']); ?>"><?php echo $c['cat_name']; ?></a></li>
						<?php }?>
					</ul>
				</div>

				<div class="Locations_list11 fat-side-item">
				<h4>How it works</h4>
					<h5 class="h4_size">
						1) Create Profile
					</h5>
					<p>
						Create a profile, choose the location you want to work in and get a list of homeowners who need your help.
					</p>
					<h5 class="h4_size">
						2) Pick your job
					</h5>
					<p>
						Access list of jobs and provide quotes for a small fee taken off your credit. Discuss details.Milestone payment created.
					</p>
					<h5 class="h4_size">
						3) Get paid
					</h5>
					<p>
						Job done as agreed. Milestone released and payment made. Share your experience and let other tradespeople know what it is like working with your homeowner.</p>
				</div>

				<div class="Locations_list11 fat-side-item open_omon1">
					<h4>Top Categories</h4>
					<ul class="ul_set lislocc1">
									<?php
                                        foreach ($get_all_categories as $c) {
                                        ?>
							<li><a href="<?php echo base_url('find-jobs/' . $c['slug']); ?>"><?php echo $c['cat_name']; ?></a></li>
						<?php }?>
					</ul>
				</div>

				<div class="Locations_list11 fat-side-item open_omon1">
					<h4>Top Location</h4>
					<ul class="ul_set lislocc1">
									<?php

                                        $whereCity = ['is_delete' => 0];

                                        if (isset($city_name) && !empty($city_name)) {
                                            $whereCity['city_name != '] = $city_name;
                                        }

                                        $cites = $this->common_model->GetColumnName('tbl_city', $whereCity, null, true);
                                        //echo $this->db->last_query();
                                        foreach ($cites as $city) {
                                        ?>
							<li><a href="<?php echo base_url('find-jobs?location=' . strtolower($city['city_name'])); ?>"><?=$city['city_name'];?></a></li>
						<?php }?>
					</ul>
				</div>

			</div>

		</div>
	</div>
</div>



<div class="modal fade" id="reportJobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header" style="border-bottom:none;">
		      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		        <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;
		    font-size: 25px;padding-bottom: 15px;">Report This Job</h5>
		        <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;
		    font-size: 20px;">Please let us know why do you want to report this job.</h5>
	      	</div>
	        <form name="frm" method="post" id="reportForm">
		      	<div class="modal-body">
		        	<input type="hidden" name="job_id" id="job_id" value="">
					<div class="form-group">
						<select class="form-control" required name="reason" id="reason">
							<option value="">- Please Select -</option>
							<option value="doesn't make sense">Doesn't make sense</option>
							<option value="contains offensive language">Contains offensive language</option>
							<option value="incorrect category">Incorrect category</option>
							<option value="Doesn't require gas or eletric qualification">Doesn't require gas or eletric qualification</option>
							<option value="Other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="otherReason" id="otherReason" placeholder="Enter your reason" class="form-control" style="display:none;">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" class="btn btn-primary submit_btn">Submit</button>
				</div>
	        </form>
	    </div>
  	</div>
</div>

<?php include "include/footer.php"?>
<script type="text/javascript">
	$( function() {


    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      values: [ 25, 75 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "£" + ui.values[ 0 ] + " - £" + ui.values[ 1 ] );
        $( "#amount1" ).val(ui.values[0]);
        $( "#amount2" ).val(ui.values[1]);

      }
    });
    $( "#amount" ).val( "£" + $( "#slider-range" ).slider( "values", 0 ) +
      " - £" + $( "#slider-range" ).slider( "values", 1 ) );
  } );

function searchFilter1(page_num)
{
	if(page_num){
		window.location.href=site_url + "find-jobs/" + page_num;
	}
}
function searchFilter(page_num)
{
	page_num = page_num?page_num:0;
	var search1 = $('#search1').val();
	var category_id = $('#category_id').val();
	var location = $('#location').val();
	var amount1 = $('#amount1').val();
	var amount2 = $('#amount2').val();
	$.ajax({
		type:'POST',
		url:site_url+'search/search_ajax/'+page_num,
		data:'page_num='+page_num+'&search1='+search1+'&category_id='+category_id+'&location='+location+'&amount1='+amount1+'&amount2='+amount2,
		dataType:'JSON',
		beforeSend:function()
		{
			$('.search_btn').prop('disabled',true);
			$('.btn_loader').show();
		},
		success:function(resp)
		{
			$('.search_btn').prop('disabled',false);
			$('.btn_loader').hide();
			$('#search_data').html(resp.data);
		}
	});
	return false;
}

function reportJobPopup(jobId) {
	$("#reportJobModal").modal('show');
	$("#job_id").val(jobId);
}

$("#reason").change(function(){
	var reason = $("#reason").val();
	if(reason == "Other") {
		$("#otherReason").show();
	} else {
		$("#otherReason").hide();
	}
});

$(function () {
    $('#reportForm').on('submit', function (e) {
		e.preventDefault();
		$('.submit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...');
		$('.submit_btn').prop('disabled',true);
		$.ajax({
			type: 'post',
			url:site_url+'search/report_job',
			data: $('#reportForm').serialize(),
			success: function (data) {
				$('.submit_btn').html('Submit');
				$('.submit_btn').prop('disabled',false);
				$("#otherReason").val("");
				$("#otherReason").hide();
				$("#reason").val("");
				$("#reportJobModal").modal('hide');
			  	swal("", "Report add successfully!", "success");
			}
		});
	});
});

function showPopup(type){
	if(type == 1){
		swal("Error", "Your Email is Not Verified", "error");
	}else{
		swal("Error", "About Your Business Details Is Not Filled", "error");
	}
}

</script>