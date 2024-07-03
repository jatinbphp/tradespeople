<?php 
if(isset($_GET['referral']) && !empty($_GET['referral'])){
	$this->session->set_userdata('referred_by',$_GET['referral']);
	$this->session->set_userdata('referred_link',$_SERVER['REDIRECT_SCRIPT_URI']);

	$this->input->set_cookie('referred_by',$_GET['referral'],43200*60);
	$this->input->set_cookie('referred_link',$_SERVER['REDIRECT_SCRIPT_URI'],43200*60);
}
if($this->session->userdata('user_id')){
	$user_id=$this->session->userdata('user_id');
	$user_data=$this->common_model->get_userDataByid($user_id);
	/*if($user_data['u_email_verify']==0) {
		redirect('email-verify');
	}*/
}
if(!$this->session->userdata('user_id') && $this->input->cookie('user_id'))
{
	$this->session->set_userdata('user_logIn',true);
	$this->session->set_userdata('type',$this->input->cookie('type'));
	$this->session->set_userdata('user_id',$this->input->cookie('user_id'));
	$this->session->set_userdata('email',$this->input->cookie('email'));
	$u_name = $this->input->cookie('f_name').' '.$this->input->cookie('l_name');
	$this->session->set_userdata('u_name',$u_name);

	$this->session->set_userdata('referred_by',$this->input->cookie('referral'));
	$this->session->set_userdata('referred_link',$this->input->cookie('REDIRECT_SCRIPT_URI'));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php if($affilateMeataSignup) {  ?>
		<title><?php if(!empty($affilateMeataSignup['meta_title'])){ echo $affilateMeataSignup['meta_title']; }else{ echo 'Tradespeople Hub'; } ?></title>
		
		<meta charset="utf-8">

	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--  -->
	  <meta name="author" content="">	
		<meta name="description" content="<?php echo $affilateMeataSignup['meta_description']; ?>" />
		<meta name="keywords" content="<?php echo $affilateMeataSignup['meta_key']; ?>" />
		<meta property="og:title" content="<?php echo $affilateMeataSignup['meta_title']; ?>" />

	<?php } ?>

	<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/jquery.fancybox.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/style.css?time=<?php echo time(); ?>" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo site_url().'css/sweetalert.css'; ?>" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4GTdudcf_UQnKPmPW4QKt82kel3Fhd6c&amp;libraries=places"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.7.0/jquery.geocomplete.min.js"></script>
	<script src="<?php echo site_url().'js/sweetalert.js'; ?>"></script>
	<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=y8edi4divxwsplcdd28rzuyx245zbzdndm22yzhuaanemki5"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

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
      
  </div>
</nav>
</div>