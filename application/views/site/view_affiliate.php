<?php include ("include/header.php") ?>
     <style>
   .affilate-frist-sec .my-img{
padding:0px;
}
.reffer-header-img {
    width: 100%;
    margin-top: -20px;
    height: 100%;
}
.reffer-header-text {
    position: relative;
    margin-top: 85px;
    padding-left: 10%;
    padding-bottom: 20px;
}
    .reffer-header-text h1{
       font-size: 40px;
       font-weight: 500;
margin-bottom:20px;
    }
 .reffer-header-text p{
font-size:17px;
margin-bottom:20px;
}
    .btn{
      background:#fe8a0f;
    }
    .affilate-second-sec{
    background:#f1f1f1;
    padding:40px 0px;
    }
  .affilate-second-sec h1{
padding-bottom:40px;
font-size:30px;
color:#464c5b;
}
.steps {
    background: #fff;
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    height: 100%;
    min-height: 200px;
}
    .step-head-text{
    font-size:24px;
    font-weight:600;
    }
    .steps p{
    font-size:14px;
    }
.steps img{
position:relative;
top:-6px;
padding-right:5px;
}
.affilate-third-sec{
text-align:center;
background:url( https://www.tradespeoplehub.co.uk/asset/admin/img/bg-third.jpg);
background-size:cover;
background-repeat:no-repeat;
color:#fff;
padding:130px;
}
.affilate-third-sec h1{  
padding-bottom:30px;
}
.affilate-fourth-sec {
padding:50px 0px;
text-align:center;
}

.affilate-fourth-sec .btn{
margin-top:30px;
}
.benifits{
text-align:left;
}
.affilate-fourth-sec h1, .affilate-fifth-sec h1{
text-align:center;
padding-bottom:30px;
}
.affilate-fifth-sec{
padding:50px 0px;

}
.affilater-globe-section{
background:#f1f1f1;
padding:60px 0px;
}
		 .affilate-fourth-sec p{
			 font-size: 17px;
		 }
		 .affilater-globe-section p{
			 font-size: 16px;
		 }
		 .affilater-globe-section .txt-section{
			 position: relative;
			 top: 100px;
		 }
		 .vw-affiliate-benfts{
			 display: inline-flex;
		 }

.animate_text {
    animation: animate_text 2.2s;
    transition: all ease-in-out 4s;
    animation-delay: 0.3s;
    animation-iteration-count: infinite;
    padding: 5px 20px;
    animation-direction: alternate;
    white-space: normal;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    color: #fff;
    overflow: hidden;
}
@keyframes animate_text {
  0%   {
    background-color: white;
    width: 0%;
    color: #000;
   }
/*  25%  {
    background-color: yellow;
    width: 25%;
}
  50%  {
    background-color: blue;
    width: 50%;
}*/
  100% {
    background-color: red;
     width: 100%;
     color: #fff
}
}
     </style>
    <section class="affilate-frist-sec">
        <div class="home-demo first-home">
            <div class="owl-carousel banner-slider">
                    
            <?php
            $today = date('Y-m-d');
            $day=date("l");

            if(isset($_GET['perview_banner']) && !empty($_GET['perview_banner'])){
                $BaNwhere['hb_id'] = $_GET['perview_banner'];
            } else {
                $BaNwhere['hb_status'] = 1;
                $BaNwhere['hb_day'] = $day;
                $BaNwhere['hb_id != '] = 1;
            }

            $default_svg_opcity = '1';
                //$default_svg_fill = '#f9f9f9';
            $default_image_class = 'banner-unique-default';
            $default_svg_fill = '#FFFFFF';

            $banner_image = $this->common_model->get_all_data('hamepage_banner',$BaNwhere,'hb_id');
            if(count($banner_image) > 0){ 
            foreach($banner_image as $row){ 
            ?>

                    <div class="item">
                        <?php if(!empty($affilateMeata['image'])) : ?>
                        <div class="set-slide <?php echo $default_image_class; ?>" style="background-image: url(<?php echo base_url('img/common/'.$affilateMeata['image'])?>);">
                        <?php else : ?>
                        <div class="set-slide <?php echo $default_image_class; ?>" style="background-image: url(<?php echo base_url('asset/admin/img/affiliate_tradespeoplehub.jpg')?>);">
                        <?php endif ?>
                         <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon opacity="<?php echo $default_svg_opcity; ?>" fill="<?php echo $default_svg_fill; ?>" points="0 0 740 0 700 650 0 650"></polygon></svg>
                            <div class="container">
                                <div class="row set-m-10">        
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="slice-text slice-text_home">
                                                    <h1><?= $affilateMeata['title']; ?></h1>
                                                    <p><?= $affilateMeata['description']; ?></p>
                                                    <div class="banner-btn">
                                    
                                                <?php if($this->session->userdata('user_id')){ 
                                                
                                                if($this->session->userdata('type')==2){ ?> 
                                                <a href="<?php echo base_url('affiliate-signup')?>" class="btn btn-warning btn-lg">Start Earning Now</a>
                                                <!--a href="<?php echo base_url('find-tradesmen/?category_id=1'); ?>" class="btn btn-primary btn-lg">Find rated tradesman near you</a-->
                                                <?php } } else { ?>
                                                <a href="<?php echo base_url('affiliate-login')?>" class="btn btn-warning btn-lg">Sign In</a>
                                                <!-- <a href="<?php echo base_url('find-tradesmen'); ?>" class="btn btn-primary btn-lg">Find rated tradesman near you</a> -->
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
                    <?php } } else {
                        
                    $banner_image = $this->common_model->get_single_data('hamepage_banner',array('hb_id'=>1));
                    
                    ?>
                    <div class="item">
                        <?php if(!empty($affilateMeata['image'])) : ?>
                        <div class="set-slide <?php echo $default_image_class; ?>" style="background-image: url(<?php echo base_url('img/common/'.$affilateMeata['image'])?>);">
                        <?php else : ?>
                        <div class="set-slide <?php echo $default_image_class; ?>" style="background-image: url(<?php echo base_url('asset/admin/img/affiliate_tradespeoplehub.jpg')?>);">
                        <?php endif ?>
                <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon opacity="0.8" fill="#FFFFFF" points="0 0 740 0 700 650 0 650"></polygon></svg>
                            <div class="container">
                                <div class="row set-m-10">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="slice-text slice-text_home">
                                                    <h1><?= $affilateMeata['title']; ?></h1>
                                                    <p><?= $affilateMeata['description']; ?></p>
                                                    <div class="banner-btn">
                                    
                                                        <?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
                                                <a href="<?php echo base_url('affiliate-signup')?>" class="btn btn-warning btn-lg">Start Earning Now</a>
                                                <!--a href="<?php echo base_url('find-tradesmen'); ?>" class="btn btn-primary btn-lg">Find rated tradesman near you</a-->
                                                <?php } } else { ?>
                                                <a href="<?php echo base_url('affiliate-login')?>" class="btn btn-warning btn-lg">Sign In</a>
                                                <!-- <a href="<?php echo base_url('find-tradesmen'); ?>" class="btn btn-primary btn-lg">Find rated tradesman near you</a> -->
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
                    <?php } ?>
                </div>
            </div>
    </section> 
    <!-- <section class="affilate-frist-sec">
            <div class="container-fluid">
                <div class="row" style="margin:0px;">`
                    <div class="col-lg-6 reffer-header-text ">
                        <h1><?= $affilateMeata['title']; ?></h1>
                        <p style="margin-bottom:7px !important"><?= $affilateMeata['description']; ?>
                        </p>
                        <a href="<?php echo base_url('affiliate-signup')?>">
                        <button class="btn btn-warning btn-lg">Start Earning Now</button>
                        </a>
                        <?php
                        if (!$this->session->userdata('user_id')) { ?>
                         <a href="<?php echo base_url('affiliate-login')?>">
                        <button class="btn btn-warning btn-lg" style="background: #3d78cb; border-color: #3d78cb;">Sign In</button>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6 p-0 my-img">
                        <div><img class="reffer-header-img" src="<?php echo base_url('asset/admin/img/new REALTOR-REFERRAL.png')?>" alt=""></div>
                    </div>
                </div>
            </div>
    </section> -->
         <section class="affilate-second-sec">
            <div class="container">
                <h1 class="text-center">It’s easy to get started and make money from us</h1>
                <div class="col-lg-4 ">
                    <div class="steps">
                       <p><img src="<?php echo base_url('asset/admin/img/user.png')?>" alt="">
                        <span class="step-head-text">Sign up</span> </p> 
                   
                    <p>It’s free and easy to get started. Simply fill out a short form and send. Verify your email. Acces your account. <br><br></p>
     </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="steps">
                       <p><img src="<?php echo base_url('asset/admin/img/promotion.png')?>" alt="">
                        <span class="step-head-text">Promote</span> </p> 
                   
                    <p>Copy or share link with your audience. We have trackable links for publishers, individual bloggers and social media influencers.
</p>
     </div>
                </div>
                <div class="col-lg-4 ">
                    <div class="steps">
                       <p><img src="<?php echo base_url('asset/admin/img/paid.png')?>" alt="">
                        <span class="step-head-text">Earn</span> </p> 
                    <p>Earn up to 50% in affiliate commissions from qualifying quotes.Our competitive conversion rates help maximize earnings.</p>
     </div>
                </div>
            </div>
            
        </section>
    

     <section class="affilate-fourth-sec">
<div class="container">
<h1>Program Benefits</h1>
<div class="col-lg-6 benifits">
	<div class="vw-affiliate-benfts">
<img src="asset/admin/img/check-mark.png" width="50" height="50">
<h3>Greater Commissioning Opportunities</h3>
	</div>
<p>Go beyond a limited commissioning view and earn more for the new user you influence. Our Commissioning Suite helps you make strategic decisions and receive higher earnings.
</p>
	<div class="vw-affiliate-benfts">
<img src="asset/admin/img/check-mark.png" width="50" height="50" style="margin-top: 35px;">
<h3 style="margin-top: 35px;">The leading innovative home service marketplace</h3>
	</div>
<p>Tradespeople and homeowners come to Tradespeoplehub to find each other and create meaningful work relationships.
</p>
<!-- <h3>Maximum Earnings</h3>
<p>Get paid for every first-time buyer, with no referral limit.</p> -->
</div>

<div class="col-lg-6 benifits">
	<div class="vw-affiliate-benfts">
<img src="asset/admin/img/check-mark.png" width="50" height="50">
<h3>Track, analyze and optimise</h3>
	</div>
<p>Our dashboard provides comprehensive reports that deliver the rich, granular data you need to understand, manage, and improve your campaigns.
</p>
	<div class="vw-affiliate-benfts">
<img src="asset/admin/img/check-mark.png" width="50" height="50" style="margin-top: 35px;">
<h3 style="margin-top: 44px;">Maximum Earnings</h3>
	</div>
<p>Get paid for every first-time user, with no referral limit.Cashout whenever and wherever you want it.</p>
<!-- <h3>Join thousands of affiliates from across the globe</h3>
<p>Content creators, educators, influencers, and marketers are helping homeowner and tradespeople get connected via Tradespeoplehub, while earning competitive referral commissions, and elevating themselves as leaders in the industry.
</p> -->

</div>
</div>
<a href="<?php echo base_url('affiliate-signup')?>">
<button class="btn btn-warning btn-lg" style="">Join  & start earning</button>
</a>
</section>
<section class="affilater-globe-section">
<div class="container">
<div class="row">
<div class="col-lg-6 txt-section">
<h3>Join thousands of affiliates from across the globe</h3>
<p>Content creators, educators, influencers, and marketers are helping homeowner and tradespeople get connected via Tradespeoplehub, while earning competitive referral commissions, and elevating themselves as leaders in the industry.</p>
</div>
<div class="col-lg-6">
<img src="<?php echo base_url('asset/admin/img/right-agreement.jpg')?>" width="100%">
</div>
</div>
</div>
</section>
 <section class="affilate-fifth-sec">
<div class="container">
<h1>Frequently Asked Questions</h1>
<div class="col-lg-6 faq">
<div class="faq_content">
<h3>What is the Tradespeoplehub affiliate program?</h3>
<p>The Tradespeoplehub affiliate program gives partners an opportunity to earn commissions by promoting Tradespeoplehub on their websites or socal media through affiliate links.</p>
</div>
<div class="faq_content">
<h3>How does the Tradespeoplehub affiliate Program work?</h3>
<p>You can share Tradespeoplehub link with your audience and earn money on qualifying quotes and customer actions.</p>
</div>
<div class="faq_content">
<h3>How do I qualify for this program?</h3>
<p>Bloggers, publishers and content creators with a qualifying website or mobile app can participate in this program.</p>
</div>

</div>

<div class="col-lg-6 faq">
<div class="faq_content">
<h3>Who can become a Tradespeoplehub affiliate?</h3>
<p>Anyone can become an Tradespeoplehub affiliate! We encourage anyone to apply to be part of the affiliate program. Tradespeoplehub offers services for every demographic.</p>
</div>
<div class="faq_content">
<h3>What can I promote?</h3>
<p>The Tradespeoplehub affiliate program gives affiliates the opportunity to promote both our homeowners and tradespeople.</p>
</div>
<div class="faq_content">
<h3>Are international affiliates accepted?</h3>
<p>Yes. We encourage affiliates from all over the world to apply for the program.We only payout to a UK bank account or Paypal.</p>
</div>

</div>
</div>

</section>

 <!-- <section class="affilate-third-sec">
<div class="container">
<h1 class="text-white">Boost your earnings by sharing us 
to your audience </h1>
</div>
<a href="<?php echo base_url('affiliaters_signup')?>">
 <button class="btn btn-warning btn-lg">Sign up now</button>
</a>
</section> -->
<?php include ("include/footer.php") ?>