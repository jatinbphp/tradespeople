<?php include ("include/header.php") ?>

<link href="css/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<?php $this->load->view('site/category_header'); ?>
<div class="categories-results">
	<div class="container">
		<?php if(isset($_GET['search']) && !empty($_GET['search'])):?>
		<h1>Results for <b><?php echo $_GET['search']; ?></b></h1>
	<?php endif; ?>
		<div class="floating-top-bar">
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Service options
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu default-menu" aria-labelledby="dropdownMenu1">
					<div class="content-scroll">
						<div class="more-filter-item">
							<div class="content-title">Seller level</div>
							<div class="checkbox-list">
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Health" type="checkbox" value="Health" name="get-up-1"/>
										<label for="Health">Health & wellness <span class="count">(41,079)</span></label>
									</div>
								</div>
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Education" type="checkbox" value="get-up-1" name="Education"/>
										<label for="Education">Education <span class="count">(40,323)</span></label>
									</div>
								</div>
							</div>
						</div>
						<div class="more-filter-item">
							<div class="content-title">Service includes</div>
							<div class="checkbox-list">
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="get-up-1" type="checkbox" value="Offers" name="Offers"/>
										<label for="Offers">Offers subscriptions <span class="count">(4,579)</span></label>
									</div>
								</div>
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Paid" type="checkbox" value="Paid" name="Paid"/>
										<label for="get-up-1">Paid video consultations <span class="count">(1,498)</span></label>
									</div>
								</div>
							</div>
							<div class="show-more-less">+34 more</div>
						</div>

					</div>
					<div class="button-row">
						<button class="btn clear-all">Clear All</button>
						<button class="btn btn-warning">Apply</button>
					</div>
				</ul>
			</div>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Seller details
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu default-menu" aria-labelledby="dropdownMenu1">
					<div class="content-scroll">
						<div class="more-filter-item">
							<div class="content-title">Seller level</div>
							<div class="checkbox-list">
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Health" type="checkbox" value="Health" name="get-up-1"/>
										<label for="Health">Health & wellness <span class="count">(41,079)</span></label>
									</div>
								</div>
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Education" type="checkbox" value="get-up-1" name="Education"/>
										<label for="Education">Education <span class="count">(40,323)</span></label>
									</div>
								</div>
							</div>
						</div>
						<div class="more-filter-item">
							<div class="content-title">Service includes</div>
							<div class="checkbox-list">
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="get-up-1" type="checkbox" value="Offers" name="Offers"/>
										<label for="Offers">Offers subscriptions <span class="count">(4,579)</span></label>
									</div>
								</div>
								<div class="form-check">
									<div class="check-box">
										<input class="checkbox-effect" id="Paid" type="checkbox" value="Paid" name="Paid"/>
										<label for="get-up-1">Paid video consultations <span class="count">(1,498)</span></label>
									</div>
								</div>
							</div>
							<div class="show-more-less">+34 more</div>
						</div>

					</div>
					<div class="button-row">
						<button class="btn clear-all">Clear All</button>
						<button class="btn btn-warning">Apply</button>
					</div>
				</ul>
			</div>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Budget
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu default-menu" aria-labelledby="dropdownMenu1">
					<div class="content-scroll">
						<div class="radio-item checked">
							<input type="radio" id="Value" name="radio-group" checked>
    						<label for="Value">Value <span>Under ₹5,257</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Mid-range" name="radio-group">
    						<label for="Mid-range">Mid-range <span>₹5,257-₹15,334</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Mid-range" name="radio-group">
    						<label for="Mid-range">High-end <span>₹15,334 & Above</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Custom" name="radio-group">
    						<label for="Custom">Custom </label>
    						<div class="price-range-filter-inputs">
    							<input type="number" placeholder="Enter budget" min="0" max="50000" value=""><i>₹</i>
    						</div>
						</div>

					</div>
					<div class="button-row">
						<button class="btn clear-all">Clear All</button>
						<button class="btn btn-warning">Apply</button>
					</div>
				</ul>
			</div>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Delivery time
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu default-menu" aria-labelledby="dropdownMenu1">
					<div class="content-scroll">
						<div class="radio-item checked">
							<input type="radio" id="Value" name="radio-group" checked>
    						<label for="Value">Value <span>Under ₹5,257</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Mid-range" name="radio-group">
    						<label for="Mid-range">Mid-range <span>₹5,257-₹15,334</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Mid-range" name="radio-group">
    						<label for="Mid-range">High-end <span>₹15,334 & Above</span></label>
						</div>
						<div class="radio-item">
							<input type="radio" id="Custom" name="radio-group">
    						<label for="Custom">Custom </label>
    						<div class="price-range-filter-inputs">
    							<input type="number" placeholder="Enter budget" min="0" max="50000" value=""><i>₹</i>
    						</div>
						</div>

					</div>
					<div class="button-row">
						<button class="btn clear-all">Clear All</button>
						<button class="btn btn-warning">Apply</button>
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
					<?php
						$data['all_services'] = $all_services;
						$this->load->view('site/service_list',$data);
					?>					
				</div>					
			</div>
		</div>
	</div>
</div>
<?php include ("include/footer.php") ?>

