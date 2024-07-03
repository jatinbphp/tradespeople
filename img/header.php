<?php 
if($this->session->userdata('user_id')){
	$user_id=$this->session->userdata('user_id');
	$user_data=$this->common_model->get_userDataByid($user_id);
	if($user_data['u_email_verify']==0) {
		redirect('email_verify');
	}
}

$get_home=$this->common_model->get_all_data('home_content',''); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <?php if($this->uri->segment(1)!='category_detail' && $this->uri->segment(1)!='blog_detail'){ ?>
  <title><?php echo $get_home['0']['meta_title']; ?></title>
   <meta name="description" content="<?php echo $get_home['0']['meta_description']; ?>">
 <?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <meta name="author" content="">	
	<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/jquery.fancybox.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo site_url().'css/sweetalert.css'; ?>" rel="stylesheet">
<!--	<link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet">-->
  <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favi.png">

  <script type="text/javascript" >
    var site_url='<?php echo base_url(); ?>';
	</script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/scrolly.js"></script> 
  <script type="text/javascript" src="<?php echo base_url(); ?>js/scrolltopcontrol.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
	<script src="<?php echo site_url().'js/sweetalert.js'; ?>"></script>
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
    </div>
    <div class="collapse navbar-collapse" id="main-menu">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo base_url('about'); ?>">About Us</a></li> 
        <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<li><a href="<?php echo base_url('category_detail'); ?>">Find Tradesmen</a></li>  
    <?php } } else { ?>
        <li><a href="<?php echo base_url('category_detail'); ?>">Find Tradesmen</a></li>  
    <?php } ?>      
		<li><a href="<?php echo base_url('advice_centre') ?>">Advice Centre</a></li>  
    <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==1){ ?>
     <li><a href="<?php echo base_url('find_jobs'); ?>">Find Jobs</a></li> 
   <?php } }else{?>
     <li><a href="<?php echo base_url('find_jobs'); ?>">Find Jobs</a></li> 
   <?php } ?>
    <li><a href="<?php echo base_url(); ?>#top_categories" style="display: none;">Category</a></li>  
    <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?>   
		<li><a href="<?php echo base_url('tradesman_start') ?>">Tradesman Start</a></li>
    <?php } }else{ ?>
          <li><a href="<?php echo base_url('login') ?>">Tradesman Start</a></li>
    <?php } ?> 
    <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==1){ ?> 
    <li><a href="<?php echo base_url('membership_plans'); ?>">Packages</a></li>
  <?php } } else{ ?>
      <li><a href="<?php echo base_url('login'); ?>">Packages</a></li>
  <?php } ?>
        <?php if($this->session->userdata('user_id'))
        {
            $where = array('nt_userId'=>$this->session->userdata('user_id'),'nt_satus'=>0);
              
              $unread_notCount =  $this->common_model->get_data('notification',$where);
              $count = (count($unread_notCount))?count($unread_notCount):'';
              ?>
        <li class="nav-item dropdown" style="width: 35px;height: 35px; border: none;">
                  <a class="nav-link text-light" href="#" onclick="update_noti()" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"><span class="label label-danger" id="unread_notCount"><?= $count; ?></span></i>
                  </a>
                    <ul class="dropdown-menu" style="width: 460px;top: 50px;right: 0px;left: unset;width: 460px;box-shadow: 0px 5px 7px -1px #c1c1c1;padding-bottom: 0px;padding: 0px;">
                      <li class="footer text-light bg-dark">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-12">
                            <span>Notifications</span>
                            <a href="<?php echo base_url('notifications'); ?>"><span class="pull-right" style="color: #fff;">View All</span></a>
                          </div>
                      </li>

                  <?php
              
                $Latest_five_notif = $this->common_model->Latest_five_notif($this->session->userdata('user_id'));
          
              ?>
                <?php 
                if($Latest_five_notif) { ?>
                  <div id="Latest_five_notif">
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
                    <?php } ?></div>        <li class="footer bg-dark text-center">
                        <a href="<?php echo base_url('notifications'); ?>">View All Notification</a>
                      </li><?php  }else{ ?>
                        <div class="alert alert-warning text-center">
                  No Records Found
                </div>
                    <?php } ?>
           
               
              
                    </ul>
                </li>
              <?php } ?>
    <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==1){?>
    <li class="post-btn"><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li>
  <?php }else{ ?> <li class="post-btn"><a href="<?php echo base_url('my_account'); ?>"><i class="fa fa-user" aria-hidden="true"></i> My Account</a></li><?php } ?>
      <?php }else{ ?>   <li><a href="<?php echo base_url('login'); ?>">Login</a></li>    
<?php } ?>    

<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<li class="post-btn"><a href="<?php echo base_url('post_job'); ?>">Post a job</a></li>
  <?php } } else{ ?>
      <li class="post-btn"><a href="<?php echo base_url('post_job'); ?>">Post a job</a></li>
  <?php } ?>

      <?php if($this->session->userdata('user_id')){  ?>
   <div class="profile_user pull-right" style="margin-left: -2px;">   
          <ul class="ul_set nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $user_data['f_name'].' '.$user_data['l_name']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?= site_url().'edit_profile'?>"> 
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
        $('#unread_notCount').html(resp.unread);
        $('#Latest_five_notif').html(resp.data);
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
        $('#unread_notCount').hide();
      }
    }
  });
}   //setInterval(function(){ check_welcome_message(<?= $user_id; ?>); }, 5000);
      </script>