<?php include ("include/header.php") ?>

<link href="css/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<?php $this->load->view('site/category_header'); ?>
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

