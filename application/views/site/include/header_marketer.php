<?php 
if($this->session->userdata('user_id')){
	$user_id=$this->session->userdata('user_id');
	$user_data=$this->common_model->get_userDataByid($user_id);
	/*if($user_data['u_email_verify']==0) {
		redirect('email-verify');
	}*/

	$where = array('nt_userId'=>$this->session->userdata('user_id'),'nt_satus'=>0);
              
	$unread_notCount =  $this->common_model->get_data('notification',$where);
	$count = (count($unread_notCount))?count($unread_notCount):'';
}

$get_home=$this->common_model->get_all_data('home_content',''); 



// Get Data by default page name 
  $get_find_trades =$this->common_model->get_single_data('other_content','id=1');
  $get_find_job =$this->common_model->get_single_data('other_content','id=2'); 


$pageName = $this->uri->segment(1);
 
$check_budget = $this->common_model->get_single_data('show_page',array('id'=>2));
$show_buget = 1;
if($check_budget && $check_budget['status']==0){
	$show_buget = 0;
}
if(!$this->session->userdata('user_id') && $this->input->cookie('user_id'))
{
	$this->session->set_userdata('user_logIn',true);
	$this->session->set_userdata('type',$this->input->cookie('type'));
	$this->session->set_userdata('user_id',$this->input->cookie('user_id'));
	$this->session->set_userdata('email',$this->input->cookie('email'));
	$u_name = $this->input->cookie('f_name').' '.$this->input->cookie('l_name');
	$this->session->set_userdata('u_name',$u_name);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="index,follow" />
<?php if($category_details){ ?>
<title><?php echo $category_details['meta_title']; ?></title>
<meta name="description" content="<?php echo $category_details['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $category_details['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $category_details['meta_title']; ?>" />
<?php } else if($selected_categroy){ ?>
<title><?php echo $selected_categroy['meta_title2']; ?></title>
<meta name="description" content="<?php echo $selected_categroy['meta_description2']; ?>" />
<meta name="keywords" content="<?php echo $selected_categroy['meta_key2']; ?>" />
<meta property="og:title" content="<?php echo $selected_categroy['meta_title2']; ?>" />
<?php } else if($city_data2){ ?>
<title><?php echo $city_data2['meta_title3']; ?></title>
<meta name="description" content="<?php echo $city_data2['meta_description3']; ?>" />
<meta name="keywords" content="<?php echo $city_data2['meta_key3']; ?>" />
<meta property="og:title" content="<?php echo $city_data2['meta_title3']; ?>" />
<?php } else if($local_category_data){ ?>
<title><?php echo $local_category_data['title']; ?></title>
<meta name="description" content="<?php echo $local_category_data['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $local_category_data['keyword']; ?>" />
<meta property="og:title" content="<?php echo $local_category_data['title']; ?>" />
<?php } else if($city_data){ ?>
<title><?php echo $city_data['meta_title4']; ?></title>
<meta name="description" content="<?php echo $city_data['meta_description4']; ?>" />
<meta name="keywords" content="<?php echo $city_data['meta_key4']; ?>" />
<meta property="og:title" content="<?php echo $city_data['meta_title4']; ?>" />
<?php } else if($get_city) {  ?>
<title><?php echo $get_city['meta_title']; ?></title>
<meta name="description" content="<?php echo $get_city['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $get_city['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $get_city['meta_title']; ?>" />
<?php } else if($pageName=='cost-guides') {
if($costGuide){  ?>
<title><?php echo $costGuide['meta_title']; ?></title>
<meta name="description" content="<?php echo strip_tags($costGuide['meta_desc']); ?>" />
<meta name="keywords" content="<?php echo $costGuide['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $costGuide['meta_title']; ?>" />
<?php }else{ ?>
<title><?php echo $get_home['0']['cost_meta_title']; ?></title>
<meta name="description" content="<?php echo $get_home['0']['cost_meta_description']; ?>" />
<meta name="keywords" content="<?php echo $get_home['0']['cost_meta_key']; ?>" />
<meta property="og:title" content="<?php echo $get_home['0']['cost_meta_title']; ?>">
<?php } ?>
<?php } else if($pageName=='blog') { ?>
<?php if($blogDetail) { ?>
<title><?php echo $blogDetail['b_meta_title']; ?></title>
<meta name="description" content="<?php echo strip_tags($blogDetail['b_meta_description']); ?>" />
<meta name="keywords" content="<?php echo $blogDetail['b_meta_key']; ?>" />
<meta property="og:title" content="<?php echo $blogDetail['b_meta_title']; ?>" />
<?php }else{ ?>
<title><?php echo $get_home['0']['blog_footer_title']; ?></title>
<meta name="description" content="<?php echo $get_home['0']['blog_footer_description']; ?>" />
<meta name="keywords" content="<?php echo $get_home['0']['blog_footer_key']; ?>" />
<meta property="og:title" content="<?php echo $get_home['0']['blog_footer_title']; ?>" />
<?php } ?>
<?php } else if($find_trades) {?>
<title><?php echo $find_trades['meta_title']; ?></title>
<meta name="description" content="<?php echo $find_trades['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $find_trades['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $find_trades['meta_title']; ?>" />
<?php } else if($find_job) {?>
<title><?php echo $find_job['meta_title']; ?></title>
<meta name="description" content="<?php echo $find_job['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $find_job['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $find_job['meta_title']; ?>" />
<?php }else { ?>
<title><?php echo $get_home['0']['meta_title']; ?></title>
<meta name="description" content="<?php echo $get_home['0']['meta_description']; ?>" />
<meta name="keywords" content="<?php echo $get_home['0']['meta_key']; ?>" />
<meta property="og:title" content="<?php echo $get_home['0']['meta_title']; ?>" />
<?php } ?>
<meta property="og:type" content="website" />
<meta property="og:url" content="<?= $_SERVER['SCRIPT_URI']; ?>" />
<meta name="author" content="" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favi.png">
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/jquery.fancybox.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style.css?time=<?php echo time(); ?>" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo site_url().'css/sweetalert.css'; ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables/dataTables.bootstrap.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" >
	var site_url='<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/scripts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
<script src="<?php echo site_url().'js/sweetalert.js'; ?>"></script>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//FANCYBOX
	//https://github.com/fancyapps/fancyBox
	$(".fancybox").fancybox({
			openEffect: "none",
			closeEffect: "none"
	});
});
</script>
<style type="text/css">
.head{
	padding:5px 15px;
	border-radius: 3px 3px 0px 0px;
}
.footer{
	padding:5px 15px;
	border-radius: 0px 0px 3px 3px; 
}
.notification-box{
	padding: 10px 0px; 
}
.bg-gray{
	background-color: #eee;
}
.bg-dark
{
	background-color: #376cb6;
}

@media (max-width: 640px) {

		.nav{
			display: block;
		}
		.nav .nav-item,.nav .nav-item a{
			padding-left: 0px;
		}
		.message{
			font-size: 13px;
		}
		.slice-text p{
		font-family: "tre";
	}
}
</style>

<?php 
$script_details=$this->common_model->get_single_data('home_content',array('id'=>1)); 
echo $script_details['header_script']; 
?>

</head>
<body style="margin:0px; font-family: tre;font-size: 14px;">

<?php echo $script_details['body_script'] ; ?>

<div class="header">
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(""); ?>"><img src="<?php echo base_url(); ?>img/logo.png"></a>

    <?php if($this->session->userdata('user_id')) { ?>
    <div class="nav-item dropdown desktttop2" style="width: 35px;height: 35px; border: none;">
      <a class="nav-link text-light" href="#" onclick="update_noti()" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"><span class="label label-danger unread_notCount" id="unread_notCount"><?= $count; ?></span></i>
      </a>
      <ul class="dropdown-menu" style="box-shadow: 0px 5px 7px -1px #c1c1c1;padding-bottom: 0px;padding: 0px;">
      
        <li class="footer text-light bg-dark">
          <div class="row">
            <div class="col-lg-12 col-sm-12 col-12">
              <span>Notifications</span>
              <a href="<?php echo base_url('notifications'); ?>"><span class="pull-right" style="color: #fff;">View All</span></a>
            </div>
          </div>
        </li>

        <?php
        $Latest_five_notif = $this->common_model->Latest_five_notif($this->session->userdata('user_id'));
        ?>
        
        <?php 
        if($Latest_five_notif) { ?>
        <div id="Latest_five_notif" class="Latest_five_notif">
          <?php
          foreach($Latest_five_notif as $row){
          $style = ($row['nt_satus']==0)?'unread':'';
          ?>
            
          <li class="<?= $style; ?> notification-box">
            <div class="row">
              <div class="col-lg-11 col-sm-11 col-11" style="margin-left: 10px;">
                <?= $row['nt_message']; ?>  
              </div>    
            </div>
          </li>
          <?php } ?>
        </div>
        <li class="footer bg-dark text-center">
          <a href="<?php echo base_url('notifications'); ?>">View All Notification</a>
        </li>
          <?php  }else{ ?>
        <div class="alert alert-warning text-center">
          No Records Found
        </div>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>  


    </div>
    <div class="collapse navbar-collapse" id="main-menu">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li> 
        <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<li><a href="<?php echo base_url('find-tradesmen'); ?>">Find Tradesmen</a></li>  
    <?php } } else { ?>
        <li><a href="<?php echo base_url('find-tradesmen'); ?>">Find Tradesmen</a></li>  
    <?php } ?>
		
			<?php
			$show_page = $this->common_model->get_single_data('show_page',array('id'=>1));
			?>
			
			<?php if($this->session->userdata('user_id')){  ?>
				<?php if($this->session->userdata('type')==1){ ?> 
				<li><a href="<?php echo base_url('find-jobs'); ?>">Find Jobs</a></li>  
				<?php }  ?>
			<?php } else { ?>
				<?php if($show_page['status']==1){ ?> 
				<li><a href="<?php echo base_url('find-jobs'); ?>">Find Jobs</a></li> 
				<?php } else { ?>
				<li><a href="<?php echo base_url('affiliaters_signin'); ?>">Find Jobs</a></li> 
				<?php } ?>
			<?php } ?>
			
			
    <li><a href="<?php echo base_url(); ?>#top_categories" style="display: none;">Category</a></li>  
    <?php if($this->session->userdata('user_id')){ 
		if($this->session->userdata('type')==1){ ?>   
		<li><a href="<?php echo base_url('register') ?>">Tradesman Start</a></li>
    <?php } }else{ ?>
		<li><a href="<?php echo base_url('register') ?>">Tradesman Start</a></li>
    <?php } ?> 
		

		<?php if($this->session->userdata('user_id')) { ?>
		<li class="nav-item dropdown desktttop1" style="width: 35px;height: 35px; border: none;">
			<a class="nav-link text-light" href="#" onclick="update_noti()" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-bell"><span class="label label-danger unread_notCount" id="unread_notCount"><?= $count; ?></span></i>
			</a>
			<ul class="dropdown-menu" style="width: 460px;top: 50px;right: 0px;left: unset;width: 460px;box-shadow: 0px 5px 7px -1px #c1c1c1;padding-bottom: 0px;padding: 0px;">
			
				<li class="footer text-light bg-dark">
					<div class="row">
						<div class="col-lg-12 col-sm-12 col-12">
							<span>Notifications</span>
							<a href="<?php echo base_url('notifications'); ?>"><span class="pull-right" style="color: #fff;">View All</span></a>
						</div>
					</div>
				</li>

				<?php
				$Latest_five_notif = $this->common_model->Latest_five_notif($this->session->userdata('user_id'));
				?>
				
				<?php 
				if($Latest_five_notif) { ?>
				<div id="Latest_five_notif" class="Latest_five_notif">
					<?php
					foreach($Latest_five_notif as $row){
					$style = ($row['nt_satus']==0)?'unread':'';
					?>
						
					<li class="<?= $style; ?> notification-box">
						<div class="row">
							<div class="col-lg-11 col-sm-11 col-11" style="margin-left: 10px;">
								<?= $row['nt_message']; ?>  
							</div>    
						</div>
					</li>
					<?php } ?>
				</div>
				<li class="footer bg-dark text-center">
					<a href="<?php echo base_url('notifications'); ?>">View All Notification</a>
				</li>
					<?php  }else{ ?>
				<div class="alert alert-warning text-center">
					No Records Found
				</div>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>  
    
		
		<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==1 || $this->session->userdata('type')==3 ){?>
    <li class="post-btn"><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li>
  <?php }else{ ?> <li class="post-btn"><a href="<?php echo base_url('my-account'); ?>"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li><?php } ?>
      <?php }else{ ?>   <li><a href="<?php echo base_url('affiliaters_signin'); ?>">Login</a></li>    
<?php } ?>    

<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<li class="post-btn"><a href="<?php echo base_url('post-job'); ?>">Get a quote</a></li>
  <?php } } else{ ?>
      <li class="post-btn"><a href="<?php echo base_url('post-job'); ?>">Get a quote</a></li>
  <?php } ?>

      <?php if($this->session->userdata('user_id')){  ?>
   <div class="profile_user pull-right" style="margin-left: -2px;">   
          <ul class="ul_set nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $user_data['f_name'].' '.$user_data['l_name']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?= site_url().'edit-profile'?>"> 
                <i title="Edit Profile" data-placement="left" class="fa fa-sign-out" aria-hidden="true"></i> Edit Profile</a></li>
              <li><a href="<?= site_url().'home/logout'?>">
                <i title="Logout" data-placement="left" class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
             
            </ul>
          </li>         
          </ul>
         </div>
      <?php  } ?>
  
      </ul>
    </div>

  </div>
</nav>
</div>

      <script>
      var notfication_interval = setInterval(function(){ get_unread_ontification(); }, 5000);
      function get_unread_ontification() {
  $.ajax({
    type:'POST',
    url:site_url+'Users/get_unread_ontification',
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.unread_notCount').html(resp.unread);
        $('.Latest_five_notif').html(resp.data);
      }
    }
  });
}
   
function update_noti()
{
    $.ajax({
    type:'POST',
    url:site_url+'Users/update_notification',
    dataType:'JSON',
    success:function(resp)
    {
      if(resp.status==1)
      {
        $('.unread_notCount').hide();
      }
    }
  });
}   
//setInterval(function(){ check_welcome_message(<?= $user_id; ?>); }, 5000);
      </script>