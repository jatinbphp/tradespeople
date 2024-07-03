<?php include ("include/header.php") ?>

<link href="css/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 

<div class="categories-menu-main">
	<div class="container">
		<nav class="categories-menu">
			<button class="left"><span class="icon-chevron"><svg width="8" height="15" viewBox="0 0 8 15" xmlns="http://www.w3.org/2000/svg"><path d="M7.2279 0.690653L7.84662 1.30934C7.99306 1.45578 7.99306 1.69322 7.84662 1.83968L2.19978 7.5L7.84662 13.1603C7.99306 13.3067 7.99306 13.5442 7.84662 13.6907L7.2279 14.3094C7.08147 14.4558 6.84403 14.4558 6.69756 14.3094L0.153374 7.76518C0.00693607 7.61875 0.00693607 7.38131 0.153374 7.23484L6.69756 0.690653C6.84403 0.544184 7.08147 0.544184 7.2279 0.690653Z"></path></svg></span></button>
			<ul class="categories">
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a>
					<ul class="menu-panel">
						<ul class="menu-bucket">
							<li><a href="#">Data Science ML</a></li>
							<li><a href="#">Machine Learning new</a></li>
							<li><a href="#">Computer Vision</a></li>
							<li><a href="#">NLP</a></li>
							<li><a href="#">Deep Learning</a></li>
							<li><a href="#">Generative Models</a></li>
							<li><a href="#">Time Series Analysis</a></li>
						</ul>
						<ul class="menu-bucket">
							<li><a href="#">Data Science ML</a></li>
							<li><a href="#">Machine Learning new</a></li>
							<li><a href="#">Computer Vision</a></li>
							<li><a href="#">NLP</a></li>
							<li><a href="#">Deep Learning</a></li>
							<li><a href="#">Generative Models</a></li>
							<li><a href="#">Time Series Analysis</a></li>
						</ul>
						<ul class="menu-bucket">
							<li><a href="#">Data Science ML</a></li>
							<li><a href="#">Machine Learning new</a></li>
							<li><a href="#">Computer Vision</a></li>
							<li><a href="#">NLP</a></li>
							<li><a href="#">Deep Learning</a></li>
							<li><a href="#">Generative Models</a></li>
							<li><a href="#">Time Series Analysis</a></li>
						</ul>

					</ul>
				</li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
				<li><a href="#">Graphics & Design</a></li>
			</ul>
		</nav>
	</div>

</div>


<div class="categories-results">
	<div class="container">
		<h1>Results for <b>seo</b></h1>
		<div class="floating-top-bar">
			<div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Dropdown
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu default-menu" aria-labelledby="dropdownMenu1">
        <div class="more-filter-item">
        	<div class="content-title">Seller level</div>
        	<div class="checkbox-list">
        		<div class="form-check">
					    <input class="checkbox-effect" id="get-up-1" type="checkbox" value="get-up-1" name="get-up-1"/>
    					<label for="get-up-1">Get Up <span class="count">100</span></label>
  					</div>
  					<div class="form-check">
					    <input class="checkbox-effect" id="get-up-2" type="checkbox" value="get-up-1" name="get-up-1"/>
    					<label for="get-up-1">Get Up <span class="count">100</span></label>
  					</div>


        		</div>

        </div>
      </ul>
    </div>
			
			<!-- <div class="toggle-switch">
			  <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
			</div> -->
		</div>
</div>
</div>


<div class="list-tradesmen nwess1">
	<div class="container">
		<div class="row">			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="top-search">
							<div class="input-group">
							    <input type="email" placeholder="Search"  class="form-control">
							    <span class="input-group-btn">
								<a class="button btn btn-default">
									<i class="fa fa-search"></i>
								</a>
							    </span>
							</div>
						</div>
					</div>
					<?php 
						if(!empty($all_services)){
							foreach($all_services as $list){
					?>
								<div class="col-sm-3">
									<!-- loop -->
									<div class="tradespeople-box">
										<div class="tradespeople-box-img">
											<a href="<?php echo base_url().'service/'.$list['slug']?>">
												<img src="<?php echo  base_url().'img/services/'.$list['image']; ?>">
											</a>
										</div>
										<div class="tradespeople-box-avtar">
											<div class="avtar">	
												<img src="<?php echo  base_url().'img/profile/'.$list['profile']; ?>">
											</div>
											<div class="names">
												<a href="<?php echo base_url().'profile/'.$list['user_id']?>">
													<?php echo $list['trading_name']; ?>
												</a>					
											</div>											
										</div>
										<div class="tradespeople-box-desc">
											<a href="<?php echo base_url().'service/'.$list['slug']?>">
												<p>
													<?php
														$totalChr = strlen($list['service_name']);
														if($totalChr > 60 ){
															echo substr($list['service_name'], 0, 60).'...';		
														}else{
															echo $list['service_name'];
														}
													?>
												</p>
											</a>
										</div>
										<div class="rating">
											<b>
												<i class="fa fa-star active"></i>
												<?php echo number_format($list['average_rating'],1); ?>
											</b>
											(<?php echo $list['total_reviews']; ?>)	
										</div>
										<div class="price">
											<a href="<?php echo base_url().'service/'.$list['slug']?>">
												<b>
													<?php echo 'From £'.$list['price']; ?>	
												</b>
											</a>
										</div>
									</div>									
								</div>
					<?php			

							}
						}
					?>
				</div>					
			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>

