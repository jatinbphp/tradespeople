<?php include ("include/header.php") ?>
<!-- Slider -->
<div class="home-page">
 <div class="home-demo first-home">
	<div class="owl-carousel banner-slider">
		<div class="item">
			<div class="set-slide" style="background: url(img/banner.png);">
      <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon opacity="0.8" fill="#FFFFFF" points="0 0 740 0 700 650 0 650"></polygon></svg>
				<div class="container">
        <div class="row set-m-10">
        <div class="col-sm-10">
					<div class="row">
						<div class="col-sm-7">
							<div class="slice-text slice-text_home">
					<p class="nomargin headHead1">How Tradespeoplehub works</p>
					<p> Traders People Hub has thousands of local and reliable Builders across the UK. We screen our trade members and every job is up for review. Post your job now to get quick responses from local Builders across the UK. </p>
					<div class="banner-btn">
						<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<a href="<?php echo base_url('post-job'); ?>" class="btn btn-warning btn-lg">Post a job now</a>
  <?php } } else{ ?>
     <a href="<?php echo base_url('post-job'); ?>" class="btn btn-warning btn-lg">Post a job now</a>
  <?php } ?>
	
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
<!-- Slider -->
<div class="graty_bg">
	<div class="inner_list">
		<div class="container">
			<ul class="page_linkk ul_set">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li class="active">
					Advice centre
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="Advice_c paddg_0">
	<div class="container">
		<div class="box_whitte">
		<h1 class="head-home">Advice centre</h1>
		<div class="row">
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_1.png" class="img_r">
					<div class="contt">
						<h4>Building regulations</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_2.png" class="img_r">
					<div class="contt">
						<h4>Planning permission</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_3.png" class="img_r">
					<div class="contt">
						<h4>Permitted development</h4>
					</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_1.png" class="img_r">
					<div class="contt">
						<h4>Building regulations</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_2.png" class="img_r">
					<div class="contt">
						<h4>Planning permission</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_3.png" class="img_r">
					<div class="contt">
						<h4>Permitted development</h4>
					</div>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_1.png" class="img_r">
					<div class="contt">
						<h4>Building regulations</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_2.png" class="img_r">
					<div class="contt">
						<h4>Planning permission</h4>
					</div>
				</a>
			</div>
			<div class="col-sm-4">
				<a class="boxus_1">
					<img src="img/img_3.png" class="img_r">
					<div class="contt">
						<h4>Permitted development</h4>
					</div>
				</a>
			</div>
		</div>
		</div>
	</div>
</div>



<?php include ("include/footer.php") ?>