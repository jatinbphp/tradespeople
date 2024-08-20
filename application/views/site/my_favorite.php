<?php include 'include/header.php'; ?>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

<div class="acount-page membership-page">
	<div class="container">
    	<div class="user-setting">
        	<div class="row">
            	<div class="col-sm-3">
                	<?php include 'include/sidebar.php'; ?>
                </div>
            	<div class="col-sm-9">
                    <div class="mjq-sh">
                        <h2>
                            <strong>My Faviourit Services</strong>                            
                        </h2>                        
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 col-sm-12"> 
                           	<div class="row">
								<?php
									$data['all_services'] = $my_favourites;
									$data['is_wishlist'] = 1;
									$this->load->view('site/service_list',$data);
								?>					
							</div>  
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'include/footer.php'; ?>

