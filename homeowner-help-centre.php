<?php include ("include/header.php") ?>
<style>
	html {
		scroll-behavior: smooth;
	}
</style>
<div class="graty_bg">
	<div class="inner_list">
		<div class="container">
			<ul class="page_linkk ul_set">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li class="active">
					Homeowner Help Center
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="dashboard help-center">
	<div class="container">
		<div class="dash-page">
			<div class="row flex-dis">
				<!-- left -->
				<div class="col-sm-3">
					
					<div class="stickydiv" id="">
						<div class="left-menu">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												General
											</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('General','General-1');" href="javascript:void(0);">Who is Tradespeoplehub.co.uk ?</a></li>
												<li><a onclick="open_possition('General','General-2');" href="javascript:void(0);">Getting work done on Tradespeoplehub.co.uk</a></li>
												<li><a onclick="open_possition('General','General-3');" href="javascript:void(0);">Choosing the right tradesman</a></li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingTwo">
										<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Jobs</a>
										</h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
										<div class="panel-body">      
											<ul>
                   <!--  <li><a onclick="open_possition('Jobs','Jobs-1');" href="javascript:void(0);">Posting Jobs</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-2');" href="javascript:void(0);">Tips for posting jobs/ getting quotes</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-3');" href="javascript:void(0);">Awarding jobs</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-4');" href="javascript:void(0);">Editing a Job after It's Posted</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-5');" href="javascript:void(0);">What to Do after Posting a job</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-6');" href="javascript:void(0);">Directly hiring a tradesman</a></li> -->
                    <li><a onclick="open_possition('Jobs','Jobs-2');" href="javascript:void(0);">Getting started with TradespeopleHub</a></li>
                    <li><a onclick="open_possition('Jobs','Jobs-1');" href="javascript:void(0);">Job</a></li>
                     <li><a onclick="open_possition('Jobs','Jobs-3');" href="javascript:void(0);">Quotes</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Panel-->
    <div class="panel panel-default">
    	<div class="panel-heading" role="tab" id="headingThree">
    		<h4 class="panel-title">
    			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Payment
    			</a>
    		</h4>
    	</div>
    	<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
    		<div class="panel-body">
    			<ul>
    				<li><a onclick="open_possition('Payment','Payment-1');" href="javascript:void(0);">Paying my tradesman</a></li>
    				<li><a onclick="open_possition('Payment','Payment-2');" href="javascript:void(0);">Creating Milestone Payments</a></li>
    				<li><a onclick="open_possition('Payment','Payment-3');" href="javascript:void(0);">Releasing Milestone Payments</a></li>
    				<li><a onclick="open_possition('Payment','Payment-4');" href="javascript:void(0);">Cancelling Milestone Payments</a></li>
    				<li><a onclick="open_possition('Payment','Payment-5');" href="javascript:void(0);">What happens to canceled Milestone Payments?</a></li>
    				<li><a onclick="open_possition('Payment','Payment-6');" href="javascript:void(0);">Proposed/suggested milestone </a></li>
    				<li><a onclick="open_possition('Payment','Payment-7');" href="javascript:void(0);">Depositing funds</a></li>
    				<li><a onclick="open_possition('Payment','Payment-8');" href="javascript:void(0);">PayPal Deposits</a></li>
    				<li><a onclick="open_possition('Payment','Payment-9');" href="javascript:void(0);">Making a Bank Deposit</a></li>
    				<li><a onclick="open_possition('Payment','Payment-10');" href="javascript:void(0);">Communicating or paying outside Tradespeoplehub.co.uk</a></li>
    			</ul>
    		</div>
    	</div>
    </div>       
    <!-- Panel-->
    <div class="panel panel-default">
    	<div class="panel-heading" role="tab" id="headingFour">
    		<h4 class="panel-title">
    			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Feedback
    			</a>
    		</h4>
    	</div>
    	<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
    		<div class="panel-body">
    			<ul>
    				<li><a onclick="open_possition('Feedback','Feedback-1');" href="javascript:void(0);">How to Rate a Tradesperson</a></li>
    				<li><a onclick="open_possition('Feedback','Feedback-2');" href="javascript:void(0);">Changing the review I gave a freelancer</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
    <!-- Panel-->
    <div class="panel panel-default">
    	<div class="panel-heading" role="tab" id="headingFive">
    		<h4 class="panel-title">
    			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Dispute Resolution
    			</a>
    		</h4>
    	</div>
    	<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
    		<div class="panel-body">
    			<ul>
    				<li><a onclick="open_possition('Dispute-Resolution','Dispute-Resolution-1');" href="javascript:void(0);">Dispute Resolution Service</a></li>
    				<li><a onclick="open_possition('Dispute-Resolution','Dispute-Resolution-2');" href="javascript:void(0);">Tradespeoplehub Milestone Dispute Resolution Policy</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
    <!-- Panel-->
    <div class="panel panel-default">
    	<div class="panel-heading" role="tab" id="headingSix">
    		<h4 class="panel-title">
    			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Others
    			</a>
    		</h4>
    	</div>
    	<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
    		<div class="panel-body">
    			<ul>
    				<li><a onclick="open_possition('Others','Others-1');" href="javascript:void(0);">I have issues with my freelancer</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
    <!-- Panel-->

</div>

</div>
</div>

</div>
<!-- left -->
<!-- right -->
<div class="col-sm-9" id="content">
	<div class="rightside">
		<div class="top-head General-Head Common-Head" id="General">
			<h1>General</h1>
		</div>

		<div class="box-inner General-Body Common-Body">
			<div class="Common-Content Content-General-1">
				<h6 id="General-1">Who is Tradespeoplehub.co.uk ?</h6>
				<p>Tradespeoplehub.co.uk  is an online tradesmen  marketplace that connects  homeowners and tradespeople across the UK. Homeowners or businesses in need of skilled tradespeople for short or large projects can post those projects and allow tradesmen to submit quotes for the completion of the work. </p>
				<p>For the homeowner, Tradespeoplehub.co.uk  provides immediate access to thousands of independent tradesmen with specific skills, without the need for searching and making calls to individual tradesmen. For the tradespeople, Tradespeoplehub.co.uk offers a constant source of part-time to full-time work opportunities, without the trouble and expenses of advertising and self-promotion. </p>

				<h6>Becoming a member</h6>
				<p>Although anyone can browse tradesmen profiles on the site, posting jobs, getting and submitting quotes are restricted to registered members. Follow these easy steps to activate your Tradespeoplehub.co.uk  account:</p>
				<p>1) Fill out a short sign up form. From the Signup page, you’ll be asked to provide a unique username. You’ll also need to provide a valid email address and agree to our Terms and Conditions. No personal information will be demanded. </p>
				<p>2) Confirm your email address. When you submit the sign up form, a message containing a link  will be sent to the email address you provided. In order to activate your account, you must click on the link.</p>
				<p>3) Create your profile. Take a few minutes to provide some information about you or your business. This information will be saved on your profile page to provide other users with an overview of your skills and so on.</p>

				<h6>Job posting</h6>
				<p>Jobs are posted by registered homeowners with work descriptions, skill requirements, and a budget range. Tradesmen get notified of posted jobs that match their skills and interests. After reading the full descriptions of applicable jobs, tradespeople can submit quotes and upload their work samples on their portfolio page for homeowners to check. Homeowners then examine the posted quotes and work samples to determine the most qualified one and award the project to one tradesperson. </p>
				<p>Tradespeoplehub.co.uk encourages homeowners to provide accurate and complete descriptions when posting jobs. Our posting and quote systems are designed to maximize the potential for satisfactory results for both the homeowner and tradesmen. </p>

				<h6>Accounts </h6>
				<p>Each registered Tradespeoplehub.co.uk  user is provided with a free online account for payments or fund transfers. Funds can be added from various payment sources such as the user's credit card, PayPal or bank transfer.</p>
				<p>A Tradesperson can withdraw funds from his or her Tradespeoplehub.co.uk  account via express withdrawal, PayPal  or bank transfer.</p>

				<h6>Payments  </h6>
				<p>Homeowners can pay tradesmen via transfer from their accounts to tradesmen' accounts. This can be achieved through Milestone Payments.</p>
				<p>Funds can be deposited to Tradespeoplehub.co.uk Milestone Payment System and released when a specific task or entire project is completed and the homeowner is 100% satisfied.</p>
				<p>Homeowners are under no obligation to provide upfront payment and should only consider this with well-trusted tradespeople as released payments can only be returned upon consent of the tradesperson.</p>
				<p>Small projects can also be paid via our Milestone Payment System, to assure the tradesperson that the funds are available while allowing the homeowner to release the funds only after the job is completed and he or she is pleased. </p>
				<p>The Tradespeoplehub.co.uk  rating and feedback system explained below is only available for projects when payments are made through Tradespeoplehub.co.uk.</p>

				<h6>Ratings & Feedback</h6>
				<p>When a project is completed through payments made within theTradespeoplehub.co.uk system, the feedback and rating system for that project will be activated. This provides the opportunity for the homeowner and tradespeople to rate each other’s performance through comments and a simple 5-star rating scale. To ensure fairness, members may also post a response to the other party’s comments. A tradesperson's overall ratings and individual project ratings and feedback are shown on their profile page to help homeowners assess the value of working with that tradesperson. </p>
				<p>The feedback and rating system allows both homeowners and tradesmen the opportunity to build their reputations through performance. It also provides the entire Tradespeoplehub.co.uk community with added protection against potential scams and unsatisfactory project delivery. </p>

				<h6>Summary </h6>
				<p>Tradespeoplehub.co.uk strives to provide a safe, simple, and affordable environment for cooperation between tradespeople and homeowners across the UK. Join our ever-increasing community to find rated, reviewed and vetted local tradespeople near you or maximize the earning potential of your business.</p>
				<p>The feedback and rating system allows both homeowners and tradesmen the opportunity to build their reputations through performance. It also provides the entire Tradespeoplehub.co.uk community with added protection against potential scams and unsatisfactory project delivery. </p>

				<br>

			</div>
			<div class="Common-Content Content-General-2" style="display:none;">

				<h6 id="General-2">Getting work done on Tradespeoplehub.co.uk</h6>

				<p>Tradespeoplehubhub.co.uk makes finding and hiring local tradespeople near you for projects over a wide range of trade categories quick and easy. Simply <a href="<?php echo site_url().'post-job'; ?>">sign up</a> for free, and hire tradesmen to get your home improvement or repair work done securely for you.</p>

				<p><b>Post jobs.</b> Work with tradespeople of your choice. You can post jobs for tradesmen to quote on. Shortlist them, and award the job to who can best deliver your project’s needs. </p>
				<p><b>Directly hire tradespeople.</b> Instead of inviting quotes by posting jobs, you can directly hire tradesmen  if you are looking for something more specific to be delivered. Check the Browse tradespeople page, and use the filter section to narrow down the search result to what is applicable to your project. </p>
				<p>Please note that project success is dependent on effective collaboration between homeowner and tradesperson. Therefore what needs to be done has to be clear to both parties. Consider asking these questions to your tradesmen to help ensure your project is completed to your satisfaction.</p>

				<br>
			</div>
			<div class="Common-Content Content-General-3" style="display:none;">

				<h6 id="General-3">Choosing the right tradesman</h6>

				<p>Choosing a tradesperson to work with demands considerations on several factors. Here are some things to consider before awarding your job.</p>

				<h6>Project Budget</h6>

				<p>Staying within the posted job’s budget range is a major consideration for most homeowners. Eliminating tradespeople who went over your indicated budget is an easy way to shorten your quote list.</p>
				<p>We also suggest contacting and asking them why they priced their quotes as such. Tradespeople  who are experts in their fields will usually price themselves higher than others. If quality is what you are after, try to negotiate the job requirements and payments with experienced tradespeople to get the most out of your money’s worth.</p>

				<h6>Project Timeline</h6>

				<p>If the deadline is non-negotiable for your project, you can eliminate quotes that fall outside that range. Tradesmen may still indicate a longer time frame, especially if your deadline is too short for the work that the project requires. If this is the case, messaging your them is still the best way of knowing which tradespeople are most likely to make it to your shortlist.</p>

				<h6>Tradespeople’s Received Reviews/Feedback</h6>
				<p>The number of reviews received by tradesperson does not necessarily indicate higher skill and better output quality because some new tradesmen with no reviews may actually be experts in their fields.</p>
				<p>Checking out tradespeople  profile Portfolio is also recommended, as well as making an effort to reach out and ask for previous work samples to see if they are a match to what your project requires.</p>


				<h6>Quotes Quality</h6>

				<p>Tradesperson who try to tailor their quotes to address your project’s requirements at the onset show dedicated interest in getting your project completed. </p>
				<p>Asking for specific information in your project description can also be a way to determine if the tradesperson took the time to read it. If what you asked for is not included in their proposal, the quote can easily be disregarded.</p>

				<h6>Summary</h6>
				<p>What you need to accomplish is best known to you, so sit down and think about them before awarding your project. </p>
			</div>
		</div>

		<div class="top-head mt20 Jobs-Head Common-Head" id="Jobs"  style="display:none;">
			<h1>Jobs</h1>
		</div>

		<div class="box-inner Jobs-Body Common-Body"  style="display:none;">
			<div class="Common-Content Content-Jobs-1"  style="display:none;">
				<h6 id="Jobs-1">How do I find a job?.</h6>
				<p>Finding a local trade job from us is effortless as more than 10K jobs are posted on our platform every month by dedicated homeowners and are waiting for a tradesperson like you to do them. </p>

				There are different way to find work on our platform. Whenever a new job that matches your skills and your selected location is posted on our platform, we will instantly notify you by email and SMS.  You can also find active work from the "Find a job" page located on the top menu.
			</p><br>

			<h6 id="Jobs-1">Tips for winning a job.</h6>
			<p>Each homeowner is as different as each tradesperson is; so there is no “magic formula” that works for every quote. To help increase the chances that a prospective homeowner will consider your quote, here are some things we suggest you practice:</p>

			<br>

			<h6 id="Jobs-1">Read the job description thoroughly.</h6>
			<p>Take the time to go through the job description. If the homeowner feels that you do not understand the job enough, you are not likely to make the shortlist.</p>

			<br>

			<h6 id="Jobs-1">Keep your quote clear and concise.</h6>
			<p>Homeowners may have dozens of quotes to consider. Make your quote short but meaty.</p>

			<br>

			<h6 id="Jobs-1">Suggest Milestones payment.</h6>
			<p>One of the ways to showcase your professionalism and prove to the homeowner that you are serious about their jobs is by listing down 3-5 milestones in your quotes.</p>

			<br>


			<h6 id="Jobs-1">Be competitive with your pricing.</h6>
			<p>Being competitive does not necessarily mean quoting a low price. If you are relatively new to our platform, you may need to establish a reputation first. However, if your work is really above average, price it accurately. Some homeowners are willing to pay for quality. </p>

			<br>

			<h6 id="Jobs-1">Do not oversell yourself.</h6>
			<p>A bit of self-confidence is a good thing, but over claiming is not likely to impress anyone. Being truthful about your capabilities and skills will get you much further than much hype.</p>

			<br>

			<h6 id="Jobs-1">Proofread your quote before you submit it.</h6>
			<p>Irrespective of what kind of job you are quoting on, a poorly written proposal entails lacking attention to details and poor work quality, neither of which is going to work in your favour.
				After submitting your quote, we encourage implementing the following practices to improve further your chances of winning jobs:
			</p>

			<br>

			<h6 id="Jobs-1">Upload previous work samples to your portfolio.</h6>
			<p>Quality, not quantity, is usually the rule of thumb when uploading examples of your work on your portfolio. Make sure that your samples are relevant for the job and that they represent your best work.</p>

			<br>

			<h6 id="Jobs-1">Request feedback /external references.</h6>
			<p>Always request feedback after job completion as it will help you get a future job. If you have not yet received any feedback, we suggest you ask external references from your previous work. Once approved, they will be available to potential clients.</p>

			<br>

			<h6 id="Jobs-1">Let your Qualifications speak for you.</h6>
			<p>Stand out by listing any trade qualifications, accreditations, experience, relevant courses and membership of any trade bodies you may have attended.</p>

			<br>

			<h6 id="Jobs-1">List your Public Insurance.</h6>
			<p>Let the customer see that you are covered by listing any professional public insúrance that you might have.</p>

			<br>

			<h6 id="Jobs-1">Try to respond promptly when the customer contacts you.</h6>
			<p> Most homeowners award jobs within the first 24 hours of posting. So make sure to keep yourself available to answer.</p>

			<br>


			<h6 id="Jobs-1">Responding to a job offer</h6>
			<p> After receiving quotes, a homeowner at any time may award the job, and if you´ve been offered the post, we will notify by email, SMS and news feed.</p>

			<p>Whether it is a work you have placed a quote on or a direct job offer, you have 24 hours to either accept or reject the award. </p>

			<br>

			<h6 id="Jobs-1">How do you accept or reject or reject a job offer?</h6>
			<p>You can accept an awarded job via the following:</p>
			<ul>
				<li>The email notification</li>
				<li>The news feed notification</li>
				<li>The job page</li>
			</ul><br>
			<p>Failure to respond to the job award within the 24 hours window will automatically revoke it. Rejecting an offer affects your reputation as it gives the homeowners the impression that you are quoting a job you´re not capable of completing. We recommend that you only quote on posts that you can commit to complete.
			</p><br>


			<h6 id="Jobs-1">What is a direct job offer?</h6>
			<p>Instead of posting a job for everyone to provide a quote, a homeowner can go to find tradespeople page or category, search for a tradesperson in their area and hire those they would like to work with immediately. If a customer offers you a direct job, you will receive an email notification or a text message.</p>

			<br>
			<h6 id="Jobs-1">Do I have to respond to a direct job? </h6>
			<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>

			<br>

			<h6 id="Jobs-1">Can homeowner resent the direct offer after I have reject the initial offer?</h6>
			<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>

			<br>
		</div>
		<div class="Common-Content Content-Jobs-2" style="display:none;">

			<h6 id="Jobs-2">Getting started with TradespeopleHub</h6>
			<p> 
			Tradespeoplehub.co.uk is an online marketplace that connects homeowners and tradespeople across the UK. For tradespeople, we offers a constant source of part-time to full-time job opportunities, without the trouble and expenses of advertising and self-promotion. </p><br>

			<h6 id="Jobs-2">How does the site work for tradespeople? </h6>
			<p> Over 20,000 tradespeople across the UK have successfully established their businesses by working with us. They have achieved phenomenal success. You want to know How? </p><br>


			<h6 id="Jobs-2">Sign up for a free trial 
			</h6>
			<p> Create a trade account (it's free): Tell us where you are and the type of work you do. We'll keep you updated by email & SMS for free when new jobs that match your settings are posted on the site. 
			</p><br>


			<h6 id="Jobs-2">Pick a job

			</h6>
			<p>On our website, homeowners are posting jobs continuously whenever they need a tradesperson. We have more than 10,000 job posts every month, which means you have a better chance to be selected for the best one matching your skills. You will be notified instantly whenever a relevant job is posted. Alternatively, you can also choose from 'find a job' page and choose any active jobs that interest you. 

			</p><br>

			<h6 id="Jobs-2">Send your Quotes

			</h6>
			<p>Sending quotes was never this easy as it is with us. The ideal way is to introduce yourself, quote your price, mention the time you needed to complete it, and a detailed description of the job. We also provide you with a chat feature which allows you to chat and discuss the job details with the homeowner in real-time. 


			</p><br>

			<h6 id="Jobs-2">Job offered


			</h6>
			<p>Once the homeowner accepts your quote and decides to hire you, then he will officially award you the job by creating a milestone used as an advanced payment.
			</p><br>

			<h6 id="Jobs-2">Get paid</h6>
			<p>Accept the job offer and always give it your best. Once completed, the homeowner will release the Milestone payment, and the money will be transferred into your bank account.</p><br>


			<h6 id="Jobs-2">Provide Feedback
			</h6>
			<p>Once the job is marked completed, we will ask the homeowner to leave a review and rate your work. Gaining good reviews will help you win future jobs. You can also leave a review for the homeowner to enable prospective employees to know what it's like working with their company.</p><br>

			<h6 id="Jobs-2">Why do other tradespeople choose us?
			</h6>
			<ul>
				<li><h6 id="Jobs-2"> 100% free trial</h6></li>
			</ul>	
				<p>A free trial plan allows you to try our services entirely free of cost and helps you to decide if it's right for you. </p><br>

				<ul><li><h6 id="Jobs-2"> Pay as you go option</h6></li></ul>
				<p>Pay as you go, with no monthly fees.</p><br>

				<ul><li><h6 id="Jobs-2"> Flexible monthly plan</h6></li></ul>
				<p>Monthly plans start from £5 a month. You're not bound to any contract.
				You can change your plan and cancel it at any time. </p><br>

				<ul><li><h6 id="Jobs-2"> Milestone payment system</h6></li></ul>
				<p>Our milestone system makes your payments secure, providing you with peace of mind and acts as a contractual payment between you and the homeowner </p><br>
				<ul><li><h6 id="Jobs-2">   Average job lead cost </h6></li></ul>
				<p>
					We offer the lowest lead job cost in the UK. Our average lead cost is £2-5 irrespective of location, size of the job, and demand.
				</p><br>

				<ul><li><h6 id="Jobs-2"> Time and cost saver – offering significant savings!</h6></li></ul>
				<p>
					Our job is to make it easier and cheaper for you to run your business. You're fully in control of the operational side while we're in charge of searching for the right clientele. With us you will worry less about paperwork, and you can spend most of your time making money.

				</p><br>

				<p>
					You will be able to gain savings from the costs of running your business as we handle the complete process of getting you the right clientele from the best available choices. We aim to make the entire practice seamless.


				</p><br>

				<ul><li><h6 id="Jobs-2">We take care of your marketing</h6></li></ul>
				<p>We use our expertise to launch an online marketing strategy to invite homeowners to post jobs with us. We invest heavily with the big search engines like Google and Bing, so whenever the homeowner is looking for a tradesperson online, we're always at the top of the list, finding the right jobs for you.
				</p><br>
				<ul><li><h6 id="Jobs-2"> Invoicing</h6></li></ul>
				<p>There's no need to waste time with documentation as we assist you in handling all the invoices. Our milestone system will take all the pressure from you. When your homeowner releases the milestone payment, an invoice will be generated, and it will be available for both parties to download.</p><br>

				<ul><li><h6 id="Jobs-2">We offer a first-class service</h6></li></ul>
				<p>By gaining access to 10,000 job leads a month from over 40 trade categories on our site, you will be able to build your reputation online. We also offer direct hiring services where homeowners can provide you with a job directly without posting it to the public. They are equipped with access to find you in the directory and your registered trade categories and can hire you directly. </p><br>
				<ul><li><h6 id="Jobs-2">Help you in your digital marketing. 
				</h6></li></ul>
				<p>There's no need to worry about how to find new clientele or paying vast amounts of money to be listed on search engines and Social Media. We do all this for you at little cost, i.e., one-tenth of what you'd pay on directories and Google.
				</p><br>
				<ul><li><h6 id="Jobs-2">Embrace the power of our suggested Milestone </h6></li></ul>
				<p>We offer a suggested milestone feature, enabling you to suggest a payment breakdown when the job has a large budget.
				</p><br>

			</ul>
			<br>
		</div>
		<div class="Common-Content Content-Jobs-3" style="display:none;">
			<h6 id="Jobs-3">Quoting a job</h6>

			<p>To quote a job post, go to my job page or notification bell icon or dashboard, select the job and then click quote.</p><br>

			<h6 id="Jobs-3">What are the requirements for quoting a job?</h6>

			<p>The following requirements must be met to quote a job:</p><br>
			<ul><li>=Verify your email.</li></ul><p>Verify the email address linked to your Tradespeoplehub.co.uk account. Check your registered email address for the verification link, and follow the instructions provided.</p><br>


			<ul><li>=Update your trade category</li></ul><p>You can only quote on a job if you have registered at least in one of the skills required for it</p><br>

			<ul><li>=Complete profile.</li></ul><p>Taking time to complete your profile is a must when quoting on posted jobs as a complete profile to let the homeowner know why you're best suited for the job.</p><br>

			<h6 id="Jobs-3">Can I edit my quote?</h6>

			<p>Editing a quote for a posted job that is already awarded requires the homeowner's confirmation. You can easily edit a quote if the job post is not yet assigned to anyone.</p><br>

			<p>You will be able to edit the following:</p>
			 <ul><li>The quote amount</li></ul>
			 <ul><li>The deadline or number of days you are committing to complete the work.</li></ul>
			 <ul><li>The description </li></ul>

			<h6 id="Jobs-3">How much details do I have to provide on my quote?</h6>

			<p>We recommend you add as many details as you can for detailed quotes are more likely to be accepted by homeowners.</p><br>

			<h6 id="Jobs-3">Can I set up milestone payments on my quote?</h6>

			<p>You can add split payments on your quote using our suggested milestone feature.</p><br>

			<h6 id="Jobs-3">Can I delete a quote?</h6>

			<p>No, although you can retract any quote that has not been accepted by the homeowner.</p><br>

			<h6 id="Jobs-3">Can I quote for any of the jobs on the platform?</h6>

			<p>Yes, you are free to quote for any jobs found on the platform which are within your selected distance and trade skill categories. Please only quote for jobs you are capable of completing.</p><br>

			<h6 id="Jobs-3">How many quotes can each job receive? </h6>

			<p>There is no limit to the number of quotes a job can receive. However, a post stops receiving quotes once it has been awarded to a tradesperson. Jobs can also stay on the TradespeopleHub for a maximum of 14 days, after which they are automatically closed for accepting quotes.</p><br>

			<h6 id="Jobs-3">Can I discuss my quote with the customer? </h6>

			<p>After submitting a quote, you will be able to chat and discuss the quote with the customer in real-time.</p><br>

			<h6 id="Jobs-3">Write a winning quote!</h6>

			<p>To be offered a job, it is necessary to write and submit a winning quote.</p><br>

			<h6 id="Jobs-3">What are tips for writing a winning quote?</h6>

			<p>Your quote should clearly express your interest in and highlight your suitability to the job you are quoting on. Follow these tips for writing a proper quote that will increase your chances of getting that job.</p><br>

			<ul><li>Tailor your content.</li></ul>
			<p>Let the job poster know that you have thoroughly read the job specs and understood what is being required. Make sure that your quote is relevant to the tasks specified on the job description. Give your time frame and budget estimates concerning what the homeowner wants done. Ask questions if you need something made clear.</p><br>

			<ul><li>Introduce yourself.</li></ul>
			<p>Give a short background of yourself, your passion, profession and state how these compliment your work performance. Professionally present yourself and try to add a little touch of your personality in your proposal.</p><br>

			<ul><li>Highlight your qualifications. </li></ul>
			<p>State you're relevant work experiences and include samples of similar projects you have done in the past. Invite the homeowner to visit your portfolio so they can see if the quality of your previous work matches what they are looking forward to achieve.</p><br>


			<ul><li> Keep it concise.</li></ul>
			<p>Make your quote short but meaty. Include only relevant information indicating your suitability to the job and any details that the homeowner might have requested.</p><br>

			<ul><li>Be sincere.</li></ul>
			<p>A little self-confidence is a good thing, but overconfidence is not likely to impress anyone. Be truthful about your skills and qualifications to ensure that the homeowner gets what has been promised.</p><br>


			<ul><li>Proofread.</li></ul>
			<p>Cross-check if you have provided all the required information. Check your grammar and spelling for a perfect first impression.</p><br>

			<h6 id="Jobs-3">What to avoid on a quote</h6>
			<p>It would be best if you abstain from doing any of the following practices to avoid incurring penalties:</p><br>

			<ul><li>Using generic quotes (quotes with the same content) on multiple jobs</li></ul>	
			<ul><li>Quoting on and accepting jobs you do not have the required expertise on</li></ul>	
			<ul><li>Providing a low price and increasing the amount significantly once the job awarded</li></ul>	
			<ul><li>Giving out or asking for contact information in your quote</li></ul>	


		</div>
		<div class="Common-Content Content-Jobs-4" style="display:none;">

			<h6 id="Jobs-4">Editing a Job after It's Posted</h6>

			<p>Changes to the requirements of a job might be unavoidable. Hence, it is understandable why a homeowner might wish to edit a job that they already posted.</p>
			<p>Once a job is posted though, tradespeople  who have required skills are notified in case they want to quote. It would be unfair for a tradesperson to learn that he cannot quote on a job because the demanded skills had been changed. So, while it is still possible to alter some details of the job not all details can be edited.You can edit the job’s description after postage but not the title and the budget</p>

			<br>
		</div>
		<div class="Common-Content Content-Jobs-5" style="display:none;">
			<h6 id="Jobs-5">What to Do after Posting a job</h6>

			<p>Now that you have posted your job and are starting to get quotes from tradespeople, we suggest these steps to get the most out of the quotes, to choose the best tradespeople, and to get the work started.</p>
			<p>● Review the quotes.</p>
			<p>Compare the tradespeople quotes amounts and delivery time. Which of the quotes matches your expectations? Read their written quotes proposals.They will claim their expertise regarding the job and explain the way in which they will carry out the tasks to complete the job. Take note of who among them have a clear understanding of what you need done.</p>
			<p>● Check their profiles.</p>
			<p>Get to know the tradespeople, their qualifications, the quality of their  work, and their previous client’ experiences on working with them.</p>
			<p>Head on  to their profile page by clicking their photo or names. Check their overall ratings and feedback from previous jobs, profile summary, portfolio, reviews, insurance and trade certifications.</p>
			<p>● Chat with the tradespeople.</p>
			<p>Do not hesitate to message a tradesperson  if you need more information about them or their plans for the job. Also, some tradesmen  may have further questions about what you need to do. Just click the Chat button on their quotes card to contact them.</p>
			<p>For your security, keep all communications within our platform.. </p>
			<p>● Award and fund the job. </p>
			<p> Once you find the tradesman who has gained your confidence to get the work done, award them the job by clicking the Award button on their quote card. Then, fund the job by creating Milestone Payments. </p>

			<br>
		</div>
		<div class="Common-Content Content-Jobs-6" style="display:none;">
			<h6 id="Jobs-6">Directly hiring a tradesman</h6>

			<p>The Hire Me option allows you to directly offer a job to a specific tradesperson.</p>
			<p>1.  Go to the tradesperson’s profile page.</p>
			<p>2.  On the right side of the tradesperson’s profile is the Hire Me form. Edit the private message that will be sent to the tradesperson once your invitation is sent.</p>
			<p>3.  Choose the budget that suits your job.</p>
			<p>4.  Click the Hire  button.</p>
			<p>You can also hire a tradesperson directly when browsing for tradespeople on the find tradesmen page by clicking the Hire Me button beside their profile card.</p>
			<p> The tradesperson will then have the option to either accept the award, decline it, or make a counteroffer. It is best to contact them directly to have the job and payment details discussed and finalized first before the job is started.</p>
			<p>The reject button will be available on the job’s proposals tab if you want to cancel the award before the tradesperson responds to it.</p>

		</div>

	</div>

	<div class="top-head mt20 Payment-Head Common-Head" id="Payment" style="display:none;">
		<h1>Payment</h1>
	</div>

	<div class="box-inner Payment-Body Common-Body"  style="display:none;">
		<div class="Common-Content Content-Payment-1"  style="display:none;">
			<h6 id="Payment-1">Paying my tradesman</h6>
			<h6 class="sub-head15">Milestone Payments</h6>
			<p>The Milestone Payment System is the recommended set of paying your tradespeople on our platform. Milestone Payments are agreed upon by the homeowner and  tradesperson before the job begins. </p>
			<p>Once the homeowner creates a Milestone Payment, the funds for it will be securely held so the tradesperson cannot access them. Milestone Payments should only be released when the homeowner is 100% satisfied with the work.</p>
			<p>Using our Milestone Payments system also gives the homeowner and the tradesperson access to our Dispute Resolution Service in the event that the job doesn’t go as planned.</p>


			<br>
		</div>
		<div class="Common-Content Content-Payment-2"  style="display:none;">
			<h6 id="Payment-2">Creating Milestone Payments</h6>

			<p>Homeowners can easily create Milestone Payments through the following scenarios and pages on the platform:</p>

			<p>
				<ul>
					<li>When awarding a job.</li>
					<li>On  my job page once the award is accepted. Simply  go to the dashboard or my account, then the job title.Go to the payment page,  click create milestone and provide the amount.</li>
					<li>When a tradesperson requests you to create a creation.</li>
				</ul>
			</p>

			<p>Note that creating milestone payments immediately charges your account's balance or the verified payment method linked to your account.The funds will be held until you choose to release them to tradespeople.Note that you have to either add a verified payment method or make a deposit to fund the Milestone Payment creation.</p>

			<p>Every milestone payment that is created  generates its own invoice that can be viewed and downloaded from the job page.</p>



			<br>
		</div>
		<div class="Common-Content Content-Payment-3"  style="display:none;">
			<h6 id="Payment-3">Releasing Milestone Payments</h6>

			<p>We recommend releasing Milestone Payments only after your tradesperson completes the assigned tasks and submits the final output. When a Milestone is released, the money is transferred to the account of your tradesperson and can no longer be returned.</p>
			<p>To release a Milestone Payment, follow these steps: </p>
			<p>1.  Go to your project's Payments tab.</p>
			<p>2.  From the Existing Milestone Payments page, click Release on the Milestone that you wish to release.</p>
			<p>3. Confirm the amount you want to release. </p>
			<p>4. Click Release.</p>
			<p>5. You will see a confirmation pop up message,asking if you want to release the milestones as released milestones can no longer be returned. Check the box, and click confirm to release the payment.</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-4"  style="display:none;">
			<h6 id="Payment-4">Cancelling Milestone Payments</h6>
			<h6 class="sub-head15">For awarded jobs</h6>

			<p>As a homeowner, you may cancel any Milestone Payment that you created, provided your job has not yet been accepted by your awarded tradesperson.</p>
			<p>Here is how:</p>
			<p>1.  Go to your job's page.</p>
			<p>2.  Select the Payment tab of your job</p>
			<p>3.  On the milestone payments page, select the milestone you wish to cancel and click cancel.</p>

			<h6 class="sub-head15">For work in progress jobs</h6>
			<p> If your job is already in progress and you wish to cancel a Milestone Payment, ask your tradesman to cancel it for you. The Milestone Payment system works this way to protect both you and your tradesperson. </p>
			<p>In the event that your job does not go as scheduled and your tradesman refuses to cancel a pending Milestone Payment, you may use our Dispute Resolution Service to resolve the issue.</p>
			<br>
		</div>
		<div class="Common-Content Content-Payment-5"  style="display:none;">
			<h6 id="Payment-5">What happens to canceled Milestone Payments?</h6>

			<p> Canceling a Milestone Payment will remove it from the job, returning the funds to your Tradespeoplehub.co.uk account balance.</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-6"  style="display:none;">
			<h6 id="Payment-6">Proposed/suggested milestone</h6>

			<p>Are you a homeowner? Let Proposed Milestones find you the right tradesperson !</p>

			<p>Some homeowners who have yet to try working with tradespeople might think the latter will not complete the job to their standards. But there could be 10, 20, or even hundreds of excellent tradespeople waiting to work on your project.</p>
			<p>If you find the right tradespeople whose skills match the tasks of your posted job, you know it can be done right. Proposed Milestones will give you confidence in your shortlisted tradespeople even before awarding the job.</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-7"  style="display:none;">
			<h6 id="Payment-7">Depositing funds</h6>

			<p>To be able to pay a tradesperson through our platform fund you need to be on your Tradespeoplehub.co.uk account. To fund your account. Simply:</p>

			<p> 1. Click your billing  from my account bar, and select wallet..</p>
			<p>  2. Enter the amount and select your preferred deposit method.</p>
			<p>  3. Enter the details that your selected payment method requires.</p>
			<p>  4. Confirm.</p>
			<p>Note that your Credit/debit card issuer and PayPal charges a processing fee of 20p + 2.9% of the deposited amount. Bank transfer is free.</p>
			<p>You should be able to see the funds in your Transaction History on the same day of your deposit, except those made through Bank Deposit which takes 1-2 business days. To view and download the deposit invoice, click the invoice on the Billing.</p>
			<p>If your deposit takes longer than the time frames mentioned above,contact us to provide the details of your deposit.</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-8"  style="display:none;">
			<h6 id="Payment-8">PayPal Deposits</h6>

			<p>PayPal deposits are transferred to your Tradespeoplehub.co.uk  account in real time, except for eChecks, which occur when your PayPal balance is not enough to cover the amount of funds that you wish to deposit  and the funds will be taking from the linked bank account instead.</p>

			<h6 class="sub-head15">To deposit using PayPal:</h6>
			<p>1.  Click your billing from my account bar, and select wallet. </p>
			<p>2.  Enter the amount.</p>
			<p>3. Choose PayPal.</p>
			<p>4.  Click Confirm.</p>
			<p>5.  Log in to your PayPal account, and follow the  instructions.</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-9"  style="display:none;">
			<h6 id="Payment-9">Making a Bank Deposit</h6>

			<p>Making bank transfers is free.</p>
			<p> 1. Click your billing . Then, choose the wallet.</p>
			<p> 2. Enter amount</p>
			<p> 3. Select Bank Deposit to see our bank details including a reference number</p>
			<p> 4. Log in to your bank, and deposit the funds. Make note of the receipt or reference number of your deposit.</p>
			<p> 6. After the deposit has been made, go to the billing page of your Tradespeoplehub account. provide the details of the bank deposit, so we can trace and verify the transaction.</p>
			<p> 7. Confirm to finish.</p>
			<p> Bank deposits usually take 1-2 business days before reflecting on your  Tradespeoplehub.co.uk account.  You should be able to see the confirmation on your transaction History .</p>
			<p> If your deposit takes longer than the time frames specified above, contact us  and submit the following details:</p>
			<p> Full name of the depositor </p>
			<p> FExact date and time of the deposit</p>
			<p> Deposit amount</p>
			<p> Deposit transaction ID</p>

			<br>
		</div>
		<div class="Common-Content Content-Payment-10"  style="display:none;">
			<h6 id="Payment-10">Communicating or paying outside Tradespeoplehub.co.uk</h6>

			<p>To ensure you have the best protection possible in the unlikely event of a dispute, keep your communication and payments within Tradespeoplehub.co.uk. We equip you with the milestone payment system where the <b>dispute resolution service</b> is available, as well as a messaging system for efficient and secure project management within our platform. </p>
			<p> If you encounter users trying to initiate offsite communication and/or payments, report them to us. </p>
		</div>


	</div>

	<div class="top-head mt20 Feedback-Head Common-Head" id="Feedback" style="display:none;">
		<h1>Feedback</h1>
	</div>

	<div class="box-inner Feedback-Body Common-Body"  style="display:none;">

		<h6>We encourage leaving reviews to tradespeople  you worked with, so we and other users on the platform can know about your experience working with them. </h6>


		<div class="Common-Content Content-Feedback-1"  style="display:none;">

			<h6 id="Feedback-1" class="sub-head15">How to Rate a Tradesperson</h6>

			<p>User reviews help homeowners choose the best tradesperson for a job. Therefore, while it is not mandatory, it is highly recommended for homeowners to leave a review for a tradesman they have just completed a job with.</p>
			<p>In order to accurately reflect your working experience with a tradesperson, be honest with the review that you will leave for them. This will properly set the expectations of the homeowners that your tradesperson will work with in the future. The following scenarios will activate the review option:</p>
			<p>
				<ul>
					<li>When the released milestone payments are equal to or exceed the tradesmen’s quote for the job.</li>
					<li>A job is marked as completed.</li>
				</ul>
			</p>
			<p>Once your job is completed, you will be directed to the leave review page. On this page, you will be presented with five criteria to rate your tradesperson with -- from one star to five stars. A five-star rating means that the tradesperson was exceptional for that category. A comment box is also provided for you to leave your review of your  tradesman's work and their work ethics.  </p>
			<p>If you cannot give feedback at immediately, you can always do that at a later time through any of the following:</p>


			<h6 class="sub-head15">Through the Dashboard page</h6>

			<p>On your Dashboard, the notification about your job's completion and your option to give feedback will be shown. Click leave feedback, fill in  the form, and  rate once you are done.</p>

			<h6 class="sub-head15">Through the job page</h6>
			<p>You can also view the feedback option on the completed section of your job's page. Once you click the link to provide feedback to your tradesman, you will be redirected to the Leave Feedback page.
			</p>

			<h6 class="sub-head15">Through the notification email</h6>
			<p>A notification email will be sent to you stating that your had had been completed and the option to leave feedback is available. Check the email and click the Leave Feedback button to be redirected to the page where you can give your feedback.  
			</p>

			<h6 class="sub-head15">Through the Feedback page</h6>
			<p>You can also  review  your tradesperson from the feedback page. To go there, hover your mouse over my job and select completed job and then the feedback page. On the page, you will see a list of jobs that are awaiting for reviews. Locate the job you wish to leave review on and rate it. 
			</p>

			

			<br>
		</div>
		<div class="Common-Content Content-Feedback-2"  style="display:none;">
			<h6 id="Feedback-2" class="sub-head15">Changing the review I gave a freelancer</h6>

			<p>The reviews given to a tradesperson serve as reference points for their future homeowners, so they should reflect your honest experience in working with them. Changing or deleting written reviews/star ratings wrecks the trust and reputation system of our platform , so it is not allowed to alter a review.</p>
			<p> Tradespeople who insistently demand for positive reviews against your will are violating our Code of Conduct. We strongly recommend  that you report them to us.</p>
			<p>If you want to correct grammar or typo errors, or to remove any confidential details you have accidentally included in your review, please contact us.</p>
		</div>
	</div>

	<div class="top-head mt20 Dispute-Resolution-Head Common-Head" id="Dispute-Resolution" style="display:none;">
		<h1>Dispute Resolution</h1>
	</div>

	<div class="box-inner Dispute-Resolution-Body Common-Body"  style="display:none;">

		<div class="Common-Content Content-Dispute-Resolution-1"  style="display:none;">
			<h6 id="Dispute-Resolution-1">Dispute Resolution Service</h6>

			<p>The Dispute Resolution Service allows the homeowner  to contest the return of unreleased milestone payments (those that are not yet released) in the event that your work does not go as planned. This return can be accomplished by opening a dispute.
			</p>
			<p>In all situations, we encourage you to resolve work related issues or disputes between yourselves rather than use our resolution service. It is provided only as a last resort should you be unable to reach an agreement with a tradesperson. Dispute decisions  are final and irreversible. 
			</p>




			

			<br>
		</div>
		<div class="Common-Content Content-Dispute-Resolution-2"  style="display:none;">
			<h6 id="Dispute-Resolution-2">Tradespeoplehub Milestone Dispute Resolution Policy
			</h6>

			<p>This Policy sets out the dispute process to be followed when a homeowner and tradesperson who have used the Milestone Payment system choses to use our Milestone Dispute Resolution process to resolve a dispute between them.
			</p>

			<h6>The Milestone Dispute Team

			</h6>
			<p> Homeowners and tradespeople  can choose to have their dispute arbitrated by our dispute team. The duty of the dispute team is to take all actions necessary to resolve the case in an impartial and evidential manner. You acknowledge that the decision of the dispute team is final, binding, and unalterable.
			</p>
			<h6>User Responsiveness</h6>
			<h6 class="sub-head15">Homeowners</h6>
			<p> Once a dispute is opened, a homeowner is given 14 days to respond to it. If not, they will automatically lose the case and the pending Milestone will be transferred to the tradesperson account.</p>
			<h6 class="sub-head15">Tradespeople</h6>
			<p>Once a dispute is opened, a tradesperson  is given 4 days to respond to it. Otherwise, they will automatically lose the dispute and the pending Milestone will be returned to the homeowner's account.</p>
			<h6>Milestone Dispute Resolution Process</h6>
			<h6 class="sub-head15">STAGE 1 - Identifying the issue</h6>
			<p>The accuser should select the work and the Milestone payment or payments to be disputed. A User could contest all the Milestones related to a single job post in one dispute.</p>
			<p>Thereafter, a description of the problem and an explanation of why the dispute is being opened. From this stage to Stage 3, users are advised to append any files that could support their claims.</p>
			<p>Finally, the complainant is requested to enter the amount he or she is prepared to pay for the Project .The amount could be between 0 and the total amount of the Milestone Payment(s) in question.</p>

			<h6 class="sub-head15">STAGE 2 - Negotiations</h6>
			<p>At this stage, either party can negotiate for partial compensation, or (after a period of time) choose to have Tradespeople's Dispute Team arbitrate the dispute. Both parties will have the chance to narrate their side of the story and also negotiate terms to resolve the problem between themselves.</p>
			<p>Only the party who initially filed for a dispute can cancel the dispute. If the issue cannot be resolved through negotiation, either party can decide to have the dispute arbitrated by our  dispute team. </p>

			<h6 class="sub-head15">STAGE 3 - Final Offers and Evidence</h6>
			<p>Stage 3 is the final stage where both parties can submit their last evidence to support their case. After Stage 3, the involved users are no longer allowed to submit evidence. The dispute will be resolved based upon the evidence provided through our dispute system, or that is otherwise available to the dispute team, such as the project description and communication between the parties.</p>
			<p>Once the dispute has proceeded to Stage 4, additional evidence will no longer be accepted.</p>

			<h6 class="sub-head15">STAGE 4 - Arbitration</h6>
			<p>At this stage, the dispute team will analyze al thel evidence and other information submitted to make a decision  within 48 hours. Dispute decisions are final, binding, and irreversible. </p>
			<p>Evidential Requirements for Your Dispute</p>
			<p>Should you elect to have the Dispute Team arbitrate your dispute, you agree to allow the Dispute Team to read all communication made on our platform and download or access, all uploaded files including images to the dispute for the sole purpose of having your dispute resolved.</p>
			<p>We highly advise you to submit all the documents that would support your claims .</p>
			<p>Submit e-mail  communication as screenshots. For proof of external communication, users should provide screenshots of their entire unedited conversation.</p>
			<p>Tradespeoplehub.co.uk  will retain the confidentiality of the project and the privacy of the involved users and will not release the collected information to any party unless required by law.</p>
		</div>
	</div>

	<div class="top-head mt20 Others-Head Common-Head" id="Others" style="display:none;">
		<h1>Others</h1>
	</div>

	<div class="box-inner Others-Body Common-Body"  style="display:none;">

		<div class="Common-Content Content-Others-1"  style="display:none;">
			<h6 id="Others-1">I have issues with my freelancer</h6>

			<p>The quality of  output and the timetable of your posted job might have been affected by some issues between you and your hired tradesperson. We highly suggest that you resolve these issues through clear and constant communication to reach a mutual agreement that works for both of you.</p>
			<p> If there are other work issues affecting your work ’s completion, contact us so we can help you immediately. Just scroll down and contact us.</p>
		</div>


	</div>
</div>
</div>
<!-- right -->
</div>
</div>
</div>
</div>
<?php include ("include/footer.php") ?>

<script type="text/javascript" src="js/sticky-sidebar.js"></script>

<script type="text/javascript">

	var stickySidebar = new StickySidebar('#sidebar', {
		topSpacing: 20,
		bottomSpacing: 20,
		containerSelector: '.container',
		innerWrapperSelector: '.container'
	});

</script>


<script type="text/javascript">

	function open_possition(main,content){
		$('.Common-Head').hide();
		$('.Common-Body').hide();
		$('.Common-Content').hide();

		$('.'+main+'-Head').show();
		$('.'+main+'-Body').show();
		$('.Content-'+content).show();

		window.location.href='#'+content;

	}

</script>