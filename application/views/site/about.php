<?php include ("include/header.php") 
?>

<div class="home-page">
   <div class="home-demo first-home">
      <div class="owl-carousel banner-slider">
         <div class="item">
            <div class="set-slide" style="background: url(img/Contractor-Banner.jpg);">
               <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 740 650" version="1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <polygon opacity="0.8" fill="#FFFFFF" points="0 0 740 0 700 650 0 650"></polygon>
               </svg>
               <div class="container">
                  <div class="row set-m-10">
                     <div class="col-sm-10">
                        <div class="row">
                           <div class="col-sm-7">
                              <div class="slice-text slice-text_home">
                                 <p class="nomargin headHead1">Connecting Homeowners To Dedicated Tradespeople</p>
									<p>We´re the UK most reputable platform for connecting homeowner to tradespeople. We make the process of paying, finding and hiring local traders secure, seamless and stress-free.</p> 
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

<div class="ouer_minsssion">
	<div class="container">
		<div class="headeroo">
			<h2>Our Mission</h2>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<p>
				 Our Mission is to connect homeowners to experienced tradespeople across the UK.
			</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="Our_Story ">
	<div class="container">
		<div class="headeroo">
			<h2>Our Story</h2>
			
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<p>Imagine having all kinds of projects from the smallest to the largest completed with utmost attention to detail and enjoying the outcome. Tradespeoplehub was created to fulfill that purpose, and so much more. To us, serving the needs of homeowners remain our top priority. That’s why our processes are geared towards eliminating the frustrations of finding trusted tradespersons across the UK. This includes our project milestone system that secures the check of our tradesmen and, at the same time, ensure they deliver on the job before they get paid.</p>

				<p>
					Tradespeoplehub began as a vision to build an intuitive website, backed by technology and the “human touch” in finding skilled tradespeople for home improvement projects. We wanted a better platform where we could find local builders who were trustworthy and could do what we needed when we needed them. Based on this need and lack of a solution, we put a lot of thought into creating the perfect platform that solves the problems of tradespeople and homeowners alike. Our trade platform doesn’t only bring tradespersons and homeowners together, it also ensures that both parties remain committed to their role and agreement. Our milestone system ensures that homeowners get what they paid for, and at the same time, tradespeople can work with focus and confidence knowing their check is waiting for them.
				</p>
			</div>
		</div>
	</div>
</div>
<div class="mission-about Our_Story">
<div class="container">
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<h3>Who are we?</h3>
		<p> Tradespeoplehub is a platform that allows homeowners to search and connect with vetted, dependable, and trusted skilled tradespeople across the UK. We also help tradespeople leverage powerful features to access vetted jobs and incredible rewards for their hard work.</p>

			<p>Our platform supports over 40 categories of skilled trades. We are a reputed tradesman finder, and our solutions cater to diverse tasks, including architectural designers, conversion specialists, electricians, operators, and many more. No matter the size or scope of your home improvement or home renovation projects, we’ve got your back.</p>



		<h3>How our service works</h3>
		<ol>
			<li>
				Homeowners post their job with complete descriptions of the project or browse through the website to directly hire tradespersons.
			</li>
			<li>
	           Tradespeoplehub checks the job for authenticity, which includes making payments that we’ll pay to the tradesperson once the homeowner gives the go-ahead.
			</li>
			<li>
				Using our tradesmen finder tool, we send homeowners’ posted jobs to local tradespeople suitable for it.
			</li>
			<li>
				Interested local tradespeople will send quotes or proposals to the Homeowner.
			</li>
			<li>
				The Homeowner evaluates quotes, reviews past jobs, and selects the best one. It’s so easy.
			</li>
		</ol>
		 <br>
		<h3>Why use our service as a homeowner?</h3>
		<ul>
			<li>
				We only work with tradespeople that are willing to put the extra effort into making a positive contribution to the lives of their clients. 
			</li>
			<li>
				Our platform is entirely free to use and provides access to affordable home improvement quotes within minutes of posting your project. It saves you time searching and trying to explain your tasks to various tradespeople. 
			</li>
			<li>
				Friendly & experienced customer service who do their best to get you the answers you need and solve your challenges at any time. 
			</li>
			<li>
				Useful resources to help you pick the best experts to achieve quality home improvements. 
			</li>
			<li>
				Read reviews from previous work to help determine the best expert for your project.
			</li>
			<li>
				Enjoy a sense of security and follow up on your hired tradesperson through our milestone system. 
			</li>
		</ul>
		<div class="posrr1">
									<?php if($this->session->userdata('user_id')){ if($this->session->userdata('type')==2){ ?> 
		<a href="<?php echo base_url('post-job'); ?>" class="btn btn-primary btn-lg">Post a job</a>
  <?php } } else{ ?>
     <a href="<?php echo base_url('post-job'); ?>" class="btn btn-primary btn-lg">Post a job</a>
  <?php } ?>
			<a href="<?php echo base_url('how-it-work'); ?>" class="btn btn-warning btn-lg"> How it works</a>
		 </div>
		 
		 
		 
		 <br>
		 <br>
		 
		<h3>Why join as a tradesperson?</h3>
		<ul>
			<li>
				Tradeshubpeople provides easy access to countless job opportunities (over 15,000+ leads) in your area. 
			</li>
			<li>
               Unlike directories, we help you access the best job leads guaranteed to maximize your returns on investment. That way, you can concentrate on delivering your best service instead of endless searches for potential clients.  
			</li>
			<li>
				Unlike directories, our platform is completely affordable. You can access our digital marketing strategies to improve your position and only pay according to flexible membership packages depending on jobs in your area. It’s so much better than trade directories that require up to £1,000 without guarantee of works. 
			</li>
			<li>
				We offer pay-as-you-go membership and flexible membership to allow you to pick what works best for you.
			</li>
			<li>
			Our project milestones protect your interest and that of your committed homeowner. So, you don’t have to worry about being owed. It also shows the commitment of your client when they create them.
			</li>
		</ul>
		<div class="posrr1">
			<a href="<?php echo base_url('signup-step1'); ?>" class="btn btn-primary btn-lg"> Sign up as a trade</a>
			<a href="<?php echo base_url('register'); ?>" class="btn btn-warning btn-lg">How it works</a>
		 </div>
	</div>
</div>
</div>
</div>
<?php include ("include/footer.php") ?>