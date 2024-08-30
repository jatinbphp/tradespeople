<?php include ("include/header.php") ?>
<style>
	html {
		scroll-behavior: smooth;
	}
	.help-center .box-inner h6{
  margin:10px 0px;
  padding: 12px 0;
  cursor: pointer;
}
.help-center .box-inner h6 i{
    font-size: 18px;
    vertical-align: middle;
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
					Tradesman Help
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
									<div class="panel-heading" role="tab" id="headingTwo1">
										<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Getting Started</a>
										</h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo1">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('getting-started','getting-started-1');" href="javascript:void(0);">How it works</a></li>
												<li><a onclick="open_possition('getting-started','getting-started-2');" href="javascript:void(0);">Why choose us</a></li>
											</ul>
										</div>
									</div>
								</div>
								<!-- Panel-->
								
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											Job
										</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Job','Job-1');" href="javascript:void(0);">Tips for winning a job</a></li>
												<li><a onclick="open_possition('Job','Job-2');" href="javascript:void(0);">Responding to a job offer</a></li>
												<li><a onclick="open_possition('Job','Job-3');" href="javascript:void(0);">What is a direct job offer?</a></li>
												<!-- <li><a onclick="open_possition('Job','Job-3');" href="javascript:void(0);">Accepting awarded jobs. Choosing the right tradesman</a></li>
												<li><a onclick="open_possition('Job','Job-4');" href="javascript:void(0);">I was awarded a job that I did not quote on</a></li> -->
											</ul>
										</div>
									</div>
								</div>
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingTwo">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Quotes</a>
										</h4>
									</div>
									<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Quotes','Quotes-1');" href="javascript:void(0);">Quoting a job.</a></li>
												<li><a onclick="open_possition('Quotes','Quotes-2');" href="javascript:void(0);">Write a winning quote!</a></li>
												<!-- <li><a onclick="open_possition('Quotes','Quotes-1');" href="javascript:void(0);">Quoting on jobs.</a></li>
												<li><a onclick="open_possition('Quotes','Quotes-2');" href="javascript:void(0);">Job quoting requirements</a></li>
												<li><a onclick="open_possition('Quotes','Quotes-3');" href="javascript:void(0);">Writing a winning quote proposal</a></li>
												<li><a onclick="open_possition('Quotes','Quotes-4');" href="javascript:void(0);">Edit/Upgrading a Quote</a></li> -->
											</ul>
										</div>
									</div>
								</div>
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingThree">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#paymentTab" aria-expanded="false" aria-controls="paymentTab">Payment
										</a>
										</h4>
									</div>
									<div id="paymentTab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Payment','Payment-1');" href="javascript:void(0);">Milestone payment system</a></li>
												<li><a onclick="open_possition('Payment','Payment-2');" href="javascript:void(0);">Suggested milestone payments </a></li>
												<li><a onclick="open_possition('Payment','Payment-3');" href="javascript:void(0);">Milestone payment dispute</a></li>
												<li><a onclick="open_possition('Payment','Payment-4');" href="javascript:void(0);">Fund withdrawal</a></li>
												<!-- <li><a onclick="open_possition('Payment','Payment-1');" href="javascript:void(0);">How do I get paid?</a></li>
												<li><a onclick="open_possition('Payment','Payment-2');" href="javascript:void(0);">Withdrawing earned funds</a></li>
												<li><a onclick="open_possition('Payment','Payment-3');" href="javascript:void(0);">Suggested Milestones</a></li>
												<li><a onclick="open_possition('Payment','Payment-4');" href="javascript:void(0);">Rewards</a></li> -->
											</ul>
										</div>
									</div>
								</div>
								<!-- account panel -->
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingFive">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accountTab" aria-expanded="false" aria-controls="accountTab">Account
										</a>
										</h4>
									</div>
									<div id="accountTab" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Account','Account-1');" href="javascript:void(0);">Account</a></li>
											</ul>
										</div>
									</div>
								</div>
								<!-- account panel -->
							
								<!-- Panel-->
								<?php if($setting[0]['payment_method'] == 1){?>			
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingFour">
											<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" href="javascript:void(0);">Memberships
											</a>
											</h4>
										</div>
										<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
											<div class="panel-body">
												<ul>
													<li><a onclick="open_possition('Memberships','Memberships-1');" href="javascript:void(0);">Membership & Fees</a></li>


													<li><a onclick="open_possition('Memberships','Memberships-2');" href="javascript:void(0);">Billing</a></li>
												</ul>
											</div>
										</div>
									</div>
								<?php }?>
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingSix">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accountTab6" aria-expanded="false" aria-controls="accountTab6">Feedback
										</a>
										</h4>
									</div>
									<div id="accountTab6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Feedback','Feedback-1');" href="javascript:void(0);">Feedback</a></li>
											</ul>
										</div>
									</div>
								</div>
								
								<!-- Panel-->
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingSeven">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#accountTab7" aria-expanded="false" aria-controls="accountTab7">Profile page
										</a>
										</h4>
									</div>
									<div id="accountTab7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Profilepage','Profilepage-1');" href="javascript:void(0);">Profile page</a></li>
											</ul>
										</div>
									</div>
								</div>
								
								<!-- Dispute resolution -->
								<!-- <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingFive">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive" onclick="open_possition('Disputeresolution','Disputeresolution-1');">Dispute resolution
										</a>
										</h4>
									</div>
								</div>
								 -->
								<!-- Panel-->

								<!-- Resolution  -->

								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingEight">
										<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#dispute" aria-expanded="false" aria-controls="dispute" href="javascript:void(0);">Dispute resolution
										</a>
										</h4>
									</div>
									<div id="dispute" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
										<div class="panel-body">
											<ul>
												<li><a onclick="open_possition('Disputeresolution','Disputeresolution-1');" href="javascript:void(0);">Dispute resolution</a></li>


												<li><a onclick="open_possition('Disputeresolution','Disputeresolution-2');" href="javascript:void(0);">Milestone Dispute Resolution Process</a></li>
												
												<li><a onclick="open_possition('Disputeresolution','Disputeresolution-3');" href="javascript:void(0);">Evidential Requirements for Your Dispute</a></li>


											</ul>
										</div>
									</div>
								</div>
								<!-- End Resolution  -->
							</div>
						</div>
					</div>
				</div>
				<!-- left -->
				<!-- right -->
				<div class="col-sm-9" id="content">
					<div class="rightside">
						<div class="top-head Job-Head Common-Head" id="Job" style="display:none;">
							<h1>Job</h1>
						</div>
						<div class="box-inner Job-Body Common-Body" style="display:none;">
							<div class="Common-Content Content-Job-1">
								<p>Finding a local trade job from us is effortless as more than 10K jobs are posted on our platform every month by dedicated homeowners and are waiting for a tradesperson like you to do them. </p>
								<p>There are different way to find work on our platform. Whenever a new job that matches your skills and your selected location is posted on our platform, we will instantly notify you by email and SMS.  You can also find active work from the "Find a job" page located on the top menu.
								</p>
								<h6 id="Job-1" >Tips for winning jobs </h6>
								
									<p>Each homeowner is as different as each tradesperson is; so there is no “magic formula” that works for every quote. To help increase the chances that a prospective homeowner will consider your quote, here are some things we suggest you practice:</p>
								
								<h6  class="georgia_font_italic" id="Jobs-1" data-toggle="collapse" data-target="#job_co1">Read the job description thoroughly. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co1" class="collapse">
									<p>Take the time to go through the job description. If the homeowner feels that you do not understand the job enough, you are not likely to make the shortlist.</p>
								</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co2">Keep your quote clear and concise.
									 <i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co2" class="collapse">
								<p>Homeowners may have dozens of quotes to consider. Make your quote short but meaty.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co3">Suggest Milestones payment. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co3" class="collapse">
								<p>One of the ways to showcase your professionalism and prove to the homeowner that you are serious about their jobs is by listing down 3-5 milestones in your quotes.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co4">Be competitive with your pricing. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co4" class="collapse">
								<p>Being competitive does not necessarily mean quoting a low price. If you are relatively new to our platform, you may need to establish a reputation first. However, if your work is really above average, price it accurately. Some homeowners are willing to pay for quality. </p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co5">Do not oversell yourself. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co5" class="collapse">
								<p>A bit of self-confidence is a good thing, but over claiming is not likely to impress anyone. Being truthful about your capabilities and skills will get you much further than much hype.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co6">Proofread your quote before you submit it. 
									<i class="fa fa-angle-down"></i>

								</h6>
								<div id="job_co6" class="collapse">
								<p>Irrespective of what kind of job you are quoting on, a poorly written proposal entails lacking attention to details and poor work quality, neither of which is going to work in your favour.
									After submitting your quote, we encourage implementing the following practices to improve further your chances of winning jobs:
								</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co7">Upload previous work samples to your portfolio. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co7" class="collapse">
								<p>Quality, not quantity, is usually the rule of thumb when uploading examples of your work on your portfolio. Make sure that your samples are relevant for the job and that they represent your best work.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co8">Request feedback /external references. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co8" class="collapse">
								<p>Always request feedback after job completion as it will help you get a future job. If you have not yet received any feedback, we suggest you ask external references from your previous work. Once approved, they will be available to potential clients.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co9">Let your Qualifications speak for you. 
									 <i class="fa fa-angle-down"></i> 
								</h6>
								<div id="job_co9" class="collapse">
								<p>Stand out by listing any trade qualifications, accreditations, experience, relevant courses and membership of any trade bodies you may have attended.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co10">List your Public Insurance. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co10" class="collapse">
								<p>Let the customer see that you are covered by listing any professional public insúrance that you might have.</p>
							</div>
								
								<h6  class="georgia_font_italic" id="Jobs-1"  data-toggle="collapse" data-target="#job_co11">Try to respond promptly when the customer contacts you. 
									<i class="fa fa-angle-down"></i>
								</h6>
								<div id="job_co11" class="collapse">
								<p> Most homeowners award jobs within the first 24 hours of posting. So make sure to keep yourself available to answer.</p>
							</div>
								
							</div>
							<div class="Common-Content Content-Job-2" style="display:none;">
								<h6 id="Jobs-1">Responding to a job offer</h6>
								<p> After receiving quotes, a homeowner at any time may award the job, and if you´ve been offered the post, we will notify by email, SMS and news feed.</p>
								<p>Whether it is a work you have placed a quote on or a direct job offer, you have 24 hours to either accept or reject the award. </p>
								
								<h6 class="georgia_font_italic" id="Jobs-1" data-toggle="collapse" data-target="#trad_hel_18">How do you accept or reject or reject a job offer? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_18" class="collapse">
								<p>You can accept an awarded job via the following:</p>
								<ul>
									<li>The email notification</li>
									<li>The news feed notification</li>
									<li>The job page</li>
								</ul>
								<p>Failure to respond to the job award within the 24 hours window will automatically revoke it. Rejecting an offer affects your reputation as it gives the homeowners the impression that you are quoting a job you´re not capable of completing. We recommend that you only quote on posts that you can commit to complete.
								</p>
							</div>
							</div>
							<div class="Common-Content Content-Job-3" style="display:none;">
								<h6 id="Job-3">What is a direct job offer?</h6>
								<p>Instead of posting a job for everyone to provide a quote, a homeowner can go to find tradespeople page or category, search for a tradesperson in their area and hire those they would like to work with immediately. If a customer offers you a direct job, you will receive an email notification or a text message.</p>
								<br>
								<h6 class="georgia_font_italic" id="Jobs-1" data-toggle="collapse" data-target="#trad_hel_19">Do I have to respond to a direct job?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_19" class="collapse">
								<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>
								<br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-1" data-toggle="collapse" data-target="#trad_hel_20">Can homeowner resent the direct offer after I have reject the initial offer? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_20" class="collapse">
								<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>
								<br>
							</div>
							</div>
						</div>
						<!-- <div class="box-inner Job-Body Common-Body" style="display:none;">
							<div class="Common-Content Content-Job-1">
								<h6 id="Job-1">Tips for winning jobs </h6>
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
							</div>
							<div class="Common-Content Content-Job-2" style="display:none;">
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
							</div>
							<div class="Common-Content Content-Job-3" style="display:none;">
								<h6 id="Job-3">What is a direct job offer?</h6>
								<p>Instead of posting a job for everyone to provide a quote, a homeowner can go to find tradespeople page or category, search for a tradesperson in their area and hire those they would like to work with immediately. If a customer offers you a direct job, you will receive an email notification or a text message.</p>
								<br>
								<h6 id="Jobs-1">Do I have to respond to a direct job? </h6>
								<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>
								<br>
								<h6 id="Jobs-1">Can homeowner resent the direct offer after I have reject the initial offer?</h6>
								<p>You have the option to either accept or decline a direct job offer. To reject an offer, you need to state the reason for doing so, and we will notify the customer.</p>
								<br>
							</div> -->
						<!-- </div> --> 
						<!-- <div class="Common-Content Content-Job-4" style="display:none;">
								<h6 id="Job-4">I was awarded a job that I did not quote on </h6>
								<p>Hire Me job allows homeowners to offer their jobs directly to tradespeople  they worked with in the past or to those whom they found by browsing the find tradesman or trades category  page.</p>
								<p>You can either accept or reject a Hire Me job offer within 24  hours of awarding before it expires.</p>
								<p>If you click Reject, you will be asked a reason for rejecting the job offer, or you may choose to make a counter offer for the job’s budget and deadline.</p>
						</div> -->
						<div class="top-head mt20 Quotes-Head Common-Head" id="Quotes"  style="display:none;">
							<h1>Quotes</h1>
						</div>
						<div class="box-inner Quotes-Body Common-Body"  style="display:none;">
							<div class="Common-Content georgia_font Content-Quotes-1"  style="display:none;">
								<h6 id="Quotes-1">Quoting on jobs.</h6>
								<p>To quote a job post, go to my job page or notification bell icon or dashboard, select the job and then click quote.</p><br>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_21">What are the requirements for quoting a job? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_21" class="collapse">
								<p>The following requirements must be met to quote a job:</p><br>
							</div>
								<ul ><li><h6 class="georgia_font_italic_small"  id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_22">Verify your email.  <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_22" class="collapse">
								<p>Verify the email address linked to your Tradespeoplehub.co.uk account. Check your registered email address for the verification link, and follow the instructions provided.</p><br>
							</div>
								<ul ><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_23">Update your trade category <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_23" class="collapse">
								 	<p>You can only quote on a job if you have registered at least in one of the skills required for it</p><br>
								 </div>
								<ul ><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_24">Complete profile. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_24" class="collapse">
								<p>Taking time to complete your profile is a must when quoting on posted jobs as a complete profile to let the homeowner know why you're best suited for the job.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_25">Can I edit my quote? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_25" class="collapse">
								<p>Editing a quote for a posted job that is already awarded requires the homeowner's confirmation. You can easily edit a quote if the job post is not yet assigned to anyone.</p>
								<p>You will be able to edit the following:</p>
								<ul><li style="font-size:16px;font-weight:normal;color:#464C5B">The quote amount</li></ul>
								<ul><li style="font-size:16px;font-weight:normal;color:#464C5B">The deadline or number of days you are committing to complete the work.</li></ul>
								<ul><li style="font-size:16px;font-weight:normal;color:#464C5B">The description </li></ul><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_26">How much details do I have to provide on my quote? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_26" class="collapse">
								<p>We recommend you add as many details as you can for detailed quotes are more likely to be accepted by homeowners.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_27">Can I set up milestone payments on my quote? <i class="fa fa-angle-down"></i></h6>
								<div id="trad_hel_27" class="collapse">
								<p>You can add split payments on your quote using our suggested milestone feature.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_28">Can I delete a quote? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_28" class="collapse">
								<p>No, although you can retract any quote that has not been accepted by the homeowner.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_29">Can I quote for any of the jobs on the platform? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_29" class="collapse">
								<p>Yes, you are free to quote for any jobs found on the platform which are within your selected distance and trade skill categories. Please only quote for jobs you are capable of completing.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_30">How many quotes can each job receive?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_30" class="collapse">
								<p>There is no limit to the number of quotes a job can receive. However, a post stops receiving quotes once it has been awarded to a tradesperson. Jobs can also stay on the TradespeopleHub for a maximum of 14 days, after which they are automatically closed for accepting quotes.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_31">Can I discuss my quote with the customer?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_31" class="collapse">
								<p>After submitting a quote, you will be able to chat and discuss the quote with the customer in real-time.</p><br>
							</div>
							</div>
							<div class="Common-Content georgia_font Content-Quotes-2" style="display:none;">
								<h6 id="Quotes-2">Write a winning quote!</h6>
								<p>To be offered a job, it is necessary to write and submit a winning quote.</p><br>
								<h6 class="georgia_font_italic" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_32">What are tips for writing a winning quote? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_32" class="collapse">
								<p>Your quote should clearly express your interest in and highlight your suitability to the job you are quoting on. Follow these tips for writing a proper quote that will increase your chances of getting that job.</p><br>
							</div>
								<ul><li ><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_33">Tailor your content. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_33" class="collapse">
								<p>Let the job poster know that you have thoroughly read the job specs and understood what is being required. Make sure that your quote is relevant to the tasks specified on the job description. Give your time frame and budget estimates concerning what the homeowner wants done. Ask questions if you need something made clear.</p><br>
							</div>
								<ul><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_34">Introduce yourself. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_34" class="collapse">
								<p>Give a short background of yourself, your passion, profession and state how these compliment your work performance. Professionally present yourself and try to add a little touch of your personality in your proposal.</p><br>
							</div>
								<ul><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_35">Highlight your qualifications. <i class="fa fa-angle-down"></i></h6> </li></ul>
								 <div id="trad_hel_35" class="collapse">
								<p>State you're relevant work experiences and include samples of similar projects you have done in the past. Invite the homeowner to visit your portfolio so they can see if the quality of your previous work matches what they are looking forward to achieve.</p><br>
							</div>
								<ul><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_36"> Keep it concise. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_36" class="collapse">
								<p>Make your quote short but meaty. Include only relevant information indicating your suitability to the job and any details that the homeowner might have requested.</p><br>
							</div>
								<ul><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_37">Be sincere. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_37" class="collapse">
								<p>A little self-confidence is a good thing, but overconfidence is not likely to impress anyone. Be truthful about your skills and qualifications to ensure that the homeowner gets what has been promised.</p><br>
							</div>
								<ul><li><h6 class="georgia_font_italic_small" id="Jobs-3" data-toggle="collapse" data-target="#trad_hel_38">Proofread. <i class="fa fa-angle-down"></i></h6></li></ul>
								 <div id="trad_hel_38" class="collapse">
								<p>Cross-check if you have provided all the required information. Check your grammar and spelling for a perfect first impression.</p><br>
							</div>
								<h6 class="georgia_font_italic_small" id="Jobs-3"  data-toggle="collapse" data-target="#trad_hel_39">What to avoid on a quote <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_39" class="collapse">
								<p>It would be best if you abstain from doing any of the following practices to avoid incurring penalties:</p><br>
								<ul><li style="color:#464C5B;font-size:16px;">Using generic quotes (quotes with the same content) on multiple jobs</li></ul>
								<ul><li style="color:#464C5B;font-size:16px;">Quoting on and accepting jobs you do not have the required expertise on</li></ul>
								<ul><li style="color:#464C5B;font-size:16px;">Providing a low price and increasing the amount significantly once the job awarded</li></ul>
								<ul><li style="color:#464C5B;font-size:16px;">Giving out or asking for contact information in your quote</li></ul>
							</div>
							</div>
							<div class="Common-Content Content-Quotes-3" style="display:none;">
								<h6 id="Quotes-3" data-toggle="collapse" data-target="#trad_hel_40">Awarding jobs <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_40" class="collapse">
								<p>Your quote should clearly express your interest in and highlight your suitability to the job you are quoting on.</p>
								<p>Follow these tips for writing a proper quote that will  increase your chances of getting that job you are eager to start working on.</p><br>
								<p><ul><li><b>Tailor your content.</b> Let the job poster or homeowner  know that you have thoroughly read the job specs and understood what is being required. Make sure that your quote is relevant to the tasks specified on the job description. Give your time frame and budget estimates in relation to what the homeowner wants done. Ask questions if you need something made clear.
								</li></ul></p><br>
								<p><ul><li><b>Introduce yourself.</b> Give a short background of yourself, your passion,  profession and state how these complement your work performance. Present yourself in a professional way and try to add a little touch of your personality in your proposal.
								</li></ul></p><br>
								<p><ul><li><b>Highlight your qualifications.</b> State your relevant work experiences and include samples of similar projects  you have done in the past. Invite the homeowner to visit your portfolio so they can see if your quality of work matches what they are looking for.
								</li></ul></p><br>
								<p><ul><li><b>Keep it concise.</b> Make your quote short but meaty. Include only relevant information indicating your suitability to the job and any details that the homeowner might have requested.
								</li></ul></p><br>
								<p><ul><li><b>Be sincere.</b> A little self confidence is a good thing, but overconfidence is not likely to impress anyone. Be truthful about your skills and qualifications to ensure that the homeowner definitely gets what has been promised.
								</li></ul></p><br>
								<p><ul><li><b>Proofread.</b> Cross check if you have provided all the required information. Check your grammar and spelling for a perfect first impression.
								</li></ul></p><br>
								<h6>What to avoid when quoting a job</h6>
								<p>You should abstain from doing any of the following practices to avoid incurring penalties.</p><br>
								<p>
									<ul>
										<li>Using generic quotes (quotes with the exact same content) on multiple jobs</li>
										<li>Quoting on and accepting jobs you do not have the required expertise on</li>
										<li>Bidding with a very low amount and increasing the amount significantly once awarded</li>
										<li>Giving out or asking for contact information in your quotes</li>
									</ul>
								</p>
								<br>
							</div>

							</div>
							<div class="Common-Content Content-Quotes-4" style="display:none;">
								<h6 id="Quotes-4" data-toggle="collapse" data-target="#trad_hel_41">Edit/Upgrading a Quote <i class="fa fa-angle-down"></i>
</h6>
 <div id="trad_hel_41" class="collapse">
								<p>Editing a tradesperson's quote for a posted job that is already already awarded  requires the homeowner's confirmation.Tradespeople can easily edit their quotes if the job post is not yet awarded.</p><br>
								<p>You will be able to upgrade the following:</p><br>
								<p>Your quote amount</p>
								<p>The deadline or number of days you are committing to complete the work.</p>
								<p>Quote description Description</p><br>
								<br>
							</div>
							</div>
						</div>
						<div class="top-head mt20 Payment-Head Common-Head" id="Payment" style="display:none;">
							<h1>Protected payment</h1>
						</div>
						<div class="box-inner Payment-Body Common-Body"  style="display:none;">
							<div class="Common-Content Content-Payment-1"  style="display:none;">
								<!-- <h6 id="Payment-1">Protected Payments</h6> -->
								<p>Protected payments is a safe and secure way to get paid using our milestone payment system, for the work you have done through our platform.</p>
								<h6 id="Payment-1">Milestone payment system</h6>
								<p>When taking up a trade job, there are several crucial criteria to consider. Arguably the most important is when and where payments should be made. There can often be a difference in preference of payment between you and the homeowner. You may prefer to be paid in advance or on acceptance of work, whereas a homeowner may feel more comfortable paying after the job is complete.</p><br>
								<p>The TradespeopleHub milestone payment system is established to manage both you and the customer's intention and to create a safe earth for the payment of the work you've done.</p><br>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_42">Why should I use the milestone payment system? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_42" class="collapse">
								<ul><li>As a tradesperson, the milestone creation and release is a significant benefit which allows you to work without burden by knowing your payment is in the hands of a trusted third party. As many homeowners also prefer to pay after a job is completed, this gives you and them peace of mind when it comes to payment.</li></ul>
								<ul><li>Issuing paper invoices to the customer becomes a hassle of the past as our system automatically generates invoices for them when they created and released milestone payment.</li></ul>
								<ul><li>Our dispute resolution centre deals with jobs that were paid with milestone payment. Therefore, every payment should be made from the site so that we can retrieve the data on transactions and work deliveries to ascertain who wrongs. Nonetheless, work done in private means may not win a resolution in the case of a dispute from our centre. </li></ul><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_43">How can I protect myself against fraudulent customers that don't want to pay for their job? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_43" class="collapse">
								<p>We recommend using our milestone payment in any work taken on our platform as this gives you optimum protection. </p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_44">When is the milestone payment created? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_44" class="collapse">
								<p>It is created by the homeowner when or after awarding a job. If this is not done, to be on the safest side, then request a milestone from your end. </p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1"  data-toggle="collapse" data-target="#trad_hel_45">Does it mean I have been paid when the customer creates a milestone payment? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_45" class="collapse">
								<p>Yes, it means that you have been paid in advance for work you have not yet completed. The fund is however held in safe hands (FSCS protected ring-fenced account provided by Natwest in the UK) and that the money becomes yours entirely when the customer releases it upon completion of the job. </p><br>
								<p>Milestone payment created is the same as a payment made in advance for the work or task that you have not yet completed.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_46">What happens if the homeowner does not create a milestone?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_46" class="collapse">
								<p>If the homeowner did not create a milestone and you want to receive your money using our platform and feel secure in receiving your payment, then all you have to do is request a milestone by clicking the 'request a milestone' button on the job payment page.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_47">How do I request a milestone? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_47" class="collapse">
								<p>Go to job payment and click the request milestone.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_48">Can I view the milestone payment for a job? <i class="fa fa-angle-down"></i>
</h6>
								 <div id="trad_hel_48" class="collapse">
								<p>Yes, once the milestone is created, you will be able to view the money in the payment section of the job. </p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_49">When is the milestone payment released? <i class="fa fa-angle-down"></i>
</h6>
 <div id="trad_hel_49" class="collapse">
								<p>Once the job or task is completed, the homeowner will release the milestone, and the held money becomes yours entirely. From there, the funds can be transferred to your bank account or Paypal. </p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_50">How do I request a milestone payment release? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_50" class="collapse">
								<p>To request a milestone release, you can either ask the homeowner after work completion or use our site to make the request. In your account, on the job payment page, click on the 'request milestone release.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_51">Can I have the invoice of the milestone payment released to me? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_51" class="collapse">
								<p>Yes, every Milestone Payment that is released has its invoice that can be viewed and downloaded from the job page.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-1" data-toggle="collapse" data-target="#trad_hel_52">Do I have to issue an invoice to the homeowner for the milestone payment? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_52" class="collapse">
								<p>Invoice is being generated for the homeowner to view and download upon creating and releasing a milestone payment to you.</p>
								<br>
							</div>
							</div>
							<div class="Common-Content Content-Payment-2"  style="display:none;">
								<h6 id="Payment-2">Suggested milestone payments </h6>
								<p>For high budget projects, you may need payment done in completion of bits on the job to sustain yourself in the duration of working on the project. The suggested milestones payment is also ideal for the homeowners who may also not feel comfortable in creating a milestone for the whole budget without being sure whether they will get satisfying results of the work done. </p><br>
								<p>To achieve this, we have integrated suggested milestones in our quoting feature as the best way to showcase your professionalism and prove to the homeowner that you are serious about getting the job done</p><br>
								<p>Our suggested milestone enables you to suggest in your quote how you want your payment to be made. For example, if you have quoted £3000 for a work that will be done in 5 days and want to receive £1000 every two days or upon completing a task, you can use our Suggested Milestone payment function to propose that. </p><br>
								<h6 class="georgia_font_italic" id="Payment-2" data-toggle="collapse" data-target="#trad_hel_53">What can the suggested milestone use for? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_53" class="collapse">
								<p>Homeowners like professional quotes so use our suggested milestone payment feature to professionalise your quote and win a job.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Payment-2" data-toggle="collapse" data-target="#trad_hel_54">How do I suggest milestones in my quote?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_54" class="collapse">
								<p>After explaining your quote, click add suggested milestone, add amounts together with the durations. You can only suggest ten milestones, and the total value of these milestones must be equal to your quoted budget</p>
								<br>
							</div>
							</div>
							<div class="Common-Content Content-Payment-3"  style="display:none;">
								<h6 id="Payment-3">Milestone payment dispute</h6>
								<p>If a situation ever arises where a homeowner, after creating a milestone has changed their mind on doing the job when you have entirely accepted and committed to it, then the issue can be resolved using our Milestone Dispute System. The system is designed to be fair, neutral and to provide both parties with a satisfactory result. Read more about <a>our dispute resolution policy.</a></p><br>
								<h6 class="georgia_font_italic" id="Payment-3" data-toggle="collapse" data-target="#trad_hel_55">What happens if the work is complete to a high standard, and the homeowner tries not to release the milestone? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_55" class="collapse">
								<p>Try and resolve the dispute directly with the homeowner in the first instance. If you cannot solve it this way, our milestone payment system has a disputes process designed to help you come to a resolution. Either you or the homeowner can raise a dispute</p>
								<br>
							</div>
							</div>
							<div class="Common-Content Content-Payment-4"  style="display:none;">
								<h6 id="Payment-4">Fund withdrawal</h6>
								<p>When you're ready to withdraw the funds for the first time, we will ask you for your bank account or Paypal details. Once you've withdrawn your funds, they'll arrive in your nominated bank account, usually within one business day.</p>
								<h6 class="georgia_font_italic" id="Payment-4" data-toggle="collapse" data-target="#trad_hel_56">How do I withdraw my money? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_56" class="collapse">
								<p>You can have your funds withdrawn by:</p>
								<ul style="list-style-type: decimal">
								<li>Click on the fund withdrawal tab</li>
								<li>Choose your preferred method of receiving your earnings.</li>
								<li>Provide the required details for your chosen withdrawal method.</li>
								<li>Indicate how much you wish to withdraw</li>
								<li>Click Withdraw Funds to submit your request.</li>
								</ul>
								<br>
							</div>
							</div>
						</div>
						<!-- account code -->
						<!-- end Account Code -->
						<div class="top-head mt20 Memberships-Head Common-Head" id="Memberships" style="display:none;">
							<h1>Memberships</h1>
						</div> 
						<div class="box-inner Memberships-Body Common-Body"  style="display:none;">
						 
							<!-- <p>Signing up for a trade account is free and automatically subscribes you to a free membership. Unlike other matching services that connect tradespeople to homeowners we don’t charge any monthly fees for using our platform. To get your trade account up and running open today, <a href="<?=site_url('signup');?>">register here</a>. After registration, verify your email address, phone number and go to my profile to complete your account details. Send the required documents for verification.</p> -->
							<div class="Common-Content Content-Memberships-1"  style="display:none;">
								
								<!-- <h6 id="Memberships-1">Billing</h6> -->
								<h6 id="Memberships-1">Membership & Fees</h6>
								<p>
									Becoming a trade member with TradespeopleHub gives you a range of benefits. We offer several membership levels to suit your needs and budget. There are no contracts, pay per month or as you go - change your membership level or cancel at any time.
								</p><br>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_68">What are the costs? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_68" class="collapse">
								<p>TradespeopleHub is free to sign up, create a profile, select skills of projects you are interested in, upload a portfolio, receive job notifications, discuss project details with the homeowner.</p>
								<p>To quote for a job, you need to be on Pay as go or have an active membership. The membership is available in different plans and can be purchased instantaneously by credit or debit card. A small administrative fee of an amount equal or greater than £2 (2% of the job value) is charged when a job is awarded. The monthly plan starts from £5 per month. </p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_69">What are credits? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_69" class="collapse">
								<p>Members receive up to 50 credits each month. Use them to quote a job—the average job quote costs around one credit. The average cost is £2 and depends on a membership plan. An active member enjoys up to a 50% credit discount. Unlike others who charge credits based on job budget, demand and size, we only charge one credit per job irrespective of job size and budget. Free trial members receive initially free credits to quote a post for free. </p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_70">Do you have monthly plans available? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_70" class="collapse">
								<p>Yes, we do have monthly pricing plans available. Please select from a range of membership plans (Basic, Standard or Pro subscription)to determine the fees you pay for our service. You can work on the site either as a pay as you go member, or gain additional benefits as a paid member by upgrading to a paid plan.</p>
								<p>Memberships will recur monthly on the anniversary of your subscription, unless cancelled. If funds are insufficient, we will try to renew your membership until funds are made available.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_71">Can I cancel my plan? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_71" class="collapse">
								<p>You may cancel your plan at any time from the user settings page, which will cease billing at the end of your subscription period without additional costs. </p>
							</div>
								<h6 class="georgia_font_italic"  id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_72">Can I try Tradespeoplehub before purchasing a plan? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_72" class="collapse">
								<p>Absolutely! We offer a one-month free trial. When you create an account, you will be asked to choose a free trial plan. We guarantee the first-class quality of our service, and as a result, we're allowing you the opportunity to trial our service for free! By doing so, you'll accustom yourself as to how the platform works. There are no restrictions, and you have no obligation to continue beyond your trial. You won't be billed until after your 30-day trial is complete. You can cancel at any time.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_73">Why choose a pay-as-you-go plan? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_73" class="collapse">
								<p>A pay-as-you-go plan is ideal if you want to do a few works. PAYG credits do not expire so that you can use them at your own pace. You still get all of our great features and services. However, PAYG does not include SMS alerts.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_74">Are there any contracts? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_74" class="collapse">
								<p>There are no contracts or hidden fees with Tradespeoplehub. You may change plans or cancel at any time or purchase credits as you need them at no additional charges.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_75">How can I pay? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_75" class="collapse">
								<p>All payments are made by credit card, through our secure payment processor like Stripe and Paypal. If you subscribe to a monthly plan, the subscription period is 30 days and charges are processed at the beginning of each period. All statements are available within your account.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_76">What if I change my mind? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_76" class="collapse">
								<p>If you change your mind, you can cancel your plan at any time directly from your account. Your data will be stored if you wish to use our services again, or we can delete all of your records upon your request.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1" data-toggle="collapse" data-target="#trad_hel_77">How do I cancel my membership?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_77" class="collapse">
								<p>You can easily cancel plans via your account dashboard by clicking "Account">> "Manage Membership">> "Subscription">> Deactivate.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-1"  data-toggle="collapse" data-target="#trad_hel_78">Can I change my monthly plans? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_78" class="collapse">
								<p>You can easily change plans by clicking "Account" and then "Change Subscription Plan." You're welcome to upgrade your plan at any time. </p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-3" data-toggle="collapse" data-target="#trad_hel_79">What's the difference between Monthly plan and Pay as you go pricing? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_79" class="collapse">
								<p>Monthly plans are billed as a single payment once per month at a discount rate of 50% while Pay, as you go, are billed every anytime you recharge your account. Monthly plan gives access to a premium service which including SMS notification.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-3" data-toggle="collapse" data-target="#trad_hel_80">Do you issue a refund? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_80" class="collapse">
								<p>We can't guarantee you'll get a refund when you're not hired.</p>
							</div>
								
							</div>


							<div class="Common-Content Content-Memberships-2"  style="display:none;">
								 
								<h6 id="Memberships-2">Billing </h6>
								<h6 class="georgia_font_italic" id="Memberships-2" data-toggle="collapse" data-target="#trad_hel_81">When do I get billed? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_81" class="collapse">
								<p>Payment is taken when your monthly plan is due and any time you purchase credits. To view when your next payment will be made, log in to your account, select subscription under membership management tab.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-2" data-toggle="collapse" data-target="#trad_hel_82">How do I view my invoices? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_82" class="collapse">
								<p>Your invoices, including your milestone payments, can be viewed and downloaded at any time by login to your account and select ‘Billing’ and ‘Invoices’ tab.</p>
							</div>
								<h6 class="georgia_font_italic" id="Memberships-2" data-toggle="collapse" data-target="#trad_hel_83">Where can I view my transaction history? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_83" class="collapse">
								<p> All the payment that you made and received from Tradespeople Hub can be viewed by clicking on billing and then history.</p>
							</div>

								<h6 class="georgia_font_italic" id="Memberships-2" data-toggle="collapse" data-target="#trad_hel_84">Still have questions? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_84" class="collapse">
								<p>Contact us at info@tradespeoplehub.co.uk, and we would be happy to answer any additional questions you may have.</p>
								<br>
								<br>
							</div>
							</div>
							
								</div>
								<div class="top-head mt20 Feedback-Head Common-Head" id="Feedback" style="display:none;">
									<h1>Feedback</h1>
								</div>
								<div class="box-inner Feedback-Body Common-Body"  style="display:none;">
									<div class="Common-Content Content-Feedback-1"  style="display:none;">
										<!-- <h6 id="Feedback-1">How to Rate a homeowner</h6> -->
										<!-- <h6 id="Feedback-1">Feedback</h6> -->
										<p>The review that the homeowner leaves on your profile plays a vital role in how likely others will hire you. While it is not compulsory, it is highly recommended as this lets the future customers know what to expect from you. Building quality feedback and 5-stars rating can help you stay competitive and win more work. </p>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_85">Why should I request a review? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_85" class="collapse">
										<p>The reviews in your profile act as your online word-of-mouth and reputation. Anytime you quote a job, we present your profile which contains your reviews to the homeowner. The more positive feedback you accumulate, the more easier it will be to win a work. So requesting and having previous people that you work with to give a feedback about the quality of your work will help you to grow your business.</p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_86">Where do my reviews go? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_86" class="collapse">
										<p>All of your reviews are shown on your profile page under the 'review' tab. Your most recent feedbacks are also displayed on the home page. </p>
									</div>
										<h6  class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_87">How do I request a review? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_87" class="collapse">
										<p>When you've completed a job, and the homeowner release all your payment, a review page will open for them to rate you. If the homeowner didn't rate you at that point, we would send reminders asking them to leave a feedback to you.</p>
										<p>For jobs that were awarded without milestone payment, you can invite the homeowner to leave a review after you have completed the job. </p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_88">How can I get more reviews? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_88" class="collapse">
										<p>The best way to get more reviews is to build a good working relationship with your customer and explain how important it is that they leave feedback. The more positive feedback you receive, the more trust you built.</p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_89">How to remove an inappropriate review <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_89" class="collapse">
										<p>We usually don't remove a review unless it violates our community rules. We will remove or edit feedback if it contains abusive or harmful language. If you can provide us with evidence that the review is inaccurate, we will investigate and take the right action.</p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_90">Can I delete a negative or unfair review? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_90" class="collapse">
										<p>No, If you receive a negative review that you think is unfair, we urge you to contact the client directly to address their concerns. If you couldn't resolve it with the customer, please get in touch with us to investigate.</p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_91">I'm new, and I don't have any feedback. What do I do? <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_91" class="collapse">
										<p>Getting your first customer review is a vital step for successfully winning more jobs. When you first join us, you can invite a customer whom you recently completed a job for to share their experience of working with you on our platform. We do not guarantee to publish this review until our team investigate and satisfied that your recently did this job. </p>
									</div>
										<h6 class="georgia_font_italic" id="Feedback-1" data-toggle="collapse" data-target="#trad_hel_92">Can I leave a feedback to the homeowner? <i class="fa fa-angle-down"></i>
</h6>	
											 <div id="trad_hel_92" class="collapse">
										<p>After completing your job, you will share your experience of what is it like working with the homeowner by leaving a review, in this way future tradespeople will know what it like working with the customer. </p>
										<br>
									</div>
									</div>
									
								</div>
									<div class="top-head mt20 Profilepage-Head Common-Head" id="Profilepage" style="display:none;">
									<h1>Profile Page</h1>
								</div>
								<div class="box-inner Profilepage-Body Common-Body"  style="display:none;">
									<div class="Common-Content Content-Profilepage-1"  style="display:none;">
										<!-- <h6 id="Profilepage-1">How to Rate a homeowner</h6> -->
										<!-- <h6 id="Profilepage-1">Profile page</h6> -->
										<p>On Tradespeoplehub.co.uk, your profile is your storefront. Like a storefront, your profile page gives the homeowner insights about you and the quality of your work. First impressions are everything, so your profile page must be polished to perfection -- just like your work.</p><br>
										<h6 class="georgia_font_italic" id="Profilepage-1" data-toggle="collapse" data-target="#trad_hel_93">What did homeowners usually look for when browsing profiles?  <i class="fa fa-angle-down"></i></h6>
										 <div id="trad_hel_93" class="collapse">
										<ul><li>A comprehensive yet concise summary about you and what you have done</li></ul>
										<ul><li>A remarkable and diverse portfolio with clear images of your previous work</li></ul>
										<ul><li>A bunch of quality reviews and a 5-star rating.</li></ul>
										<ul><li>Qualification</li></ul>
										<ul><li>Insurance </li></ul><br>
										<p>With thousands of tradespeople on the site, you need to stand out to increase your chances of getting hired. Your profile is the best place to start. Now is a great time to get your profile into shape.</p><br>
									</div>
										<h6 class="georgia_font_italic" id="Profilepage-1" data-toggle="collapse" data-target="#trad_hel_94">How do I make my profile stand out, thereby maximising my chances of being hired?  <i class="fa fa-angle-down"></i> </h6>
										 <div id="trad_hel_94" class="collapse">
										<ul><li>Upload a photo that’s professional, in focus. Don’t look too serious -- smile!</li></ul>
										<ul><li>Make sure your summary is well written, concise and has no spelling and grammar mistakes.</li></ul>
										<ul><li>Your Portfolio should only showcase your best quality work -- exclude work of mediocre quality.</li></ul>
										<ul><li>Add something extra such as public insurance, recent recognition or a certification that shows off your skills.</li></ul>
										<ul><li>Remember, the key to getting the posted job is to make every opportunity count. Don’t underestimate your profile -- it might just be costing you jobs and money.</li></ul><br>
									</div>
										<h6 class="georgia_font_italic" id="Profilepage-1" data-toggle="collapse" data-target="#trad_hel_95">How do I edit my trade skill category? <i class="fa fa-angle-down"></i></h6>

 								<div id="trad_hel_95" class="collapse">
										<p>Adding trade skill categories is part of completing your profile. Doing so allows you to quote on projects that require the categories you have on your profile.</p>
									<ol>1. Log in to your Tradespeoplehub.co.uk account.</ol>
								<ol>2. Click my account from the main menu bar. Then, click my details.</ol>
							<ol>3. On your details page, click the category to edit or add.</ol><br>
								</div>
							<h6 class="georgia_font_italic" id="Profilepage-1" data-toggle="collapse" data-target="#trad_hel_96">How do I edit my profile page?  <i class="fa fa-angle-down"></i></h6>
<div id="trad_hel_96" class="collapse">
							<p>To edit your profile page, log in to your account and click the ‘my details’ tab. From there you can update any part of your profile page including your company description, profile picture and cover image. </p><br>
							<p>What you can update:</p><br>
							<ul><li>profile picture</li></ul>
							<ul><li>company description</li></ul>
							<ul><li>Trade category</li></ul>
							<ul><li>Previous work photos</li></ul>
							<ul><li>insurance</li></ul>
							<ul><li>work distance</li></ul>
							<ul><li>Qualifications</li></ul><br>
							 </div>
							<h6 class="georgia_font_italic" id="Profilepage-1" data-toggle="collapse" data-target="#trad_hel_97">Can I upload pictures of my previous work? <i class="fa fa-angle-down"></i>
</h6>

 <div id="trad_hel_97" class="collapse">
							<p>To upload images of your work to you, log in to your account and select ‘Account’ and then ‘My Profile’. Under Portfolio click the ‘Add portfolio’ button to choose the pictures saved on your phone or computer. The images you upload will show on your profile page under Portfolio.</p><br>
						</div>
						</div>
						
					</div>
					<div class="top-head mt20 Disputeresolution-Head Common-Head" id="Dispute Resolution" style="display:none;">
							<h1>Dispute Resolution</h1>
						</div>
					<div class="box-inner Disputeresolution-Body Common-Body"  style="display:none;">
						<div class="Common-Content georgia_font  Content-Disputeresolution-1"  style="display:none;">
							<!-- <h6 id="Disputeresolution-1">How to Rate a homeowner</h6> -->
							<h6 id="Disputeresolution-1">Dispute Resolution</h6>
							<p>The Dispute Resolution Service allows you to contest the return of unreleased milestone payments (those that are not yet released) if you have completed a milestone (task) or the whole work, but the homeowner disagree to release the fund.
							In all situations, we encourage you to resolve work-related issues or disputes between yourselves rather than use our resolution service. It is provided only as a last resort should you be unable to reach an agreement with a tradesperson. Dispute decisions are final and irreversible.</p><br>
							<h6 id="Disputeresolution-1">Milestone Dispute Resolution Policy</h6>
							<p>This Policy sets out the dispute process to be followed when you and the homeowner who has used our Milestone Payment system chooses to use our Milestone Dispute Resolution process to resolve a dispute between you and them.
							</p><br>
							
							<ul><li><h6 id="Disputeresolution-1" class="georgia_font_normal" data-toggle="collapse" data-target="#trad_hel_98">The Milestone Dispute Team <i class="fa fa-angle-down"></i></h6></li></ul>
							 <div id="trad_hel_98" class="collapse">
							<p>
							You and homeowners can choose to have your dispute arbitrated by our dispute team. The work of the dispute team is to take all the actions necessary needed in resolving the case in an impartial and evidential manner. You acknowledge that the decision of the dispute team is final, binding, and unalterable.</p><br>
						</div>
							<ul><li><h6 id="Disputeresolution-1" class="georgia_font_normal" data-toggle="collapse" data-target="#trad_hel_99">Your Responsiveness <i class="fa fa-angle-down"></i></h6></li></ul>
							 <div id="trad_hel_99" class="collapse">
							<p>Once a dispute is opened, you're given 4 days to respond to it. Otherwise, you will automatically lose the case, and the pending Milestone will be returned to the homeowner's account. </p><br>
							<p>When you got a reply from the homeowner, you've until 48 hours to respond, failure to do so closes the case automatically and decides in favour of the homeowner.</p><br>
						</div>
							</div>

							<!-- second part -->

							<div class="Common-Content Content-Disputeresolution-2"  style="display:none;">
							<!-- <h6 id="Disputeresolution-1">How to Rate a homeowner</h6> -->
							<h6 id="Disputeresolution-2">Milestone Dispute Resolution Process</h6><br>
							 <ul><li ><h6 class="georgia_font_italic" id="Disputeresolution-2" data-toggle="collapse" data-target="#trad_hel_100">STAGE 1 - Identifying the issue <i class="fa fa-angle-down"></i></h6></li></ul><br>
							  <div id="trad_hel_100" class="collapse">
							<p>You should select the work and the Milestone payment or payments to be disputed. You could contest all the Milestones related to a single job post in one dispute.</p>
							<p>After that, a description of the problem and an explanation of why the dispute is being opened. From this stage to Stage 3, you are advised to append any files that could support your claim.</p><br>
						</div>
							 <ul><li ><h6 class="georgia_font_italic" id="Disputeresolution-2" data-toggle="collapse" data-target="#trad_hel_101">STAGE 2 - Negotiations <i class="fa fa-angle-down"></i></h6></li></ul><br>
							  <div id="trad_hel_101" class="collapse">
							<p>At this stage, either you or the homeowner can negotiate for partial compensation or choose to have our Dispute Team arbitrate the dispute. Both parties will have the chance to narrate their side of the story and also negotiate terms to resolve the problem between themselves.
							Only the party who initially filed for a dispute can cancel the dispute. If the issue cannot be resolved through negotiation, either party can decide to have the dispute arbitrated by our dispute team.</p><br>
						</div>
							<ul><li ><h6  class="georgia_font_italic" id="Disputeresolution-2" data-toggle="collapse" data-target="#trad_hel_102">STAGE 3 - Final Offers and Evidence <i class="fa fa-angle-down"></i></h6></li></ul><br>
							 <div id="trad_hel_102" class="collapse">
							<p>
							Stage 3 is the final stage, where both you and the homeowner can submit your last evidence to support your case. After Stage 3, the involved users are no longer allowed to provide proof.</p><br>
							<p>The dispute will be resolved based on the evidence provided to our dispute team, or that is otherwise available, such as job description and communication between you and the homeowner.
							</p><br>
							<p>Once the dispute has proceeded to Stage 4, additional evidence will no longer be accepted.
							</p><br>
						</div>
							<ul><li ><h6 class="georgia_font_italic" id="Disputeresolution-2" data-toggle="collapse" data-target="#trad_hel_103">STAGE 4 - Arbitration <i class="fa fa-angle-down"></i></h6></li></ul><br>
							 <div id="trad_hel_103" class="collapse">
							<p>At this stage, the dispute team will analyze all the evidence and other information submitted to decide within 48 hours. Dispute decisions are final, binding, and irreversible.</p><br>
						</div>
							</div>

							<!-- Third part -->
							<div class="Common-Content Content-Disputeresolution-3"  style="display:none;">
							<!-- <h6 id="Disputeresolution-1">How to Rate a homeowner</h6> -->
							
							<h6 id="Disputeresolution-3">Evidential Requirements for Your Dispute</h6><br>
							<p>Should you elect to have the Dispute Team arbitrate your dispute, you agree to allow the Dispute Team to read all communication made on our platform and download or access all uploaded files including images to the dispute for the sole purpose of having your dispute resolved.</p>
							<p>We highly advise you to submit all the documents that would support your claims.</p><br>
							<p>Submit e-mail communication as screenshots. For proof of external communication, users should provide screenshots of their entire unedited conversation.</p><br>
							<p>Tradespeoplehub.co.uk will retain the confidentiality of the project and the privacy of the involved users and will not release the collected information to any party unless required by law.
							</p><br>
							</div>
						</div>
						<!-- Account panel -->
						<div class="top-head mt20 Account-Head Common-Head" id="Account" style="display:none;">
							<h1>Account</h1>
						</div>
						<div class="box-inner Account-Body Common-Body"  style="display:none;">
							<div class="Common-Content Content-Account-1"  style="display:none;">
								<!-- <h6 id="Feedback-1">How to Rate a homeowner</h6> -->
								<!-- <h6 id="Account-1">Account</h6> -->
								<p>Signing up for a trade account is free. To get your trade account up and running today, register here. After registration, you need to verify your email address, phone number and send the required documents for the account verification. </p><br>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_57">What is account verification? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_57" class="collapse">
								<p>It is an identity verification process that ensures a safer and secure online workplace for all Traespeoplehub.co.uk users. To market yourself as a trusted member of our online community, we must verify your identity. It helps to prevent fraud.</p><br>
							</div>
								<h6 id="Account-1" class="georgia_font_italic" data-toggle="collapse" data-target="#trad_hel_58">Why do I have to verify my account? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_58" class="collapse">
								<p>To approve the ownership of your account, we need to verify the name and address you provided when registering. The checks we carry out establishes your identity in the same manner banks do. </p><br>
							</div>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_59">How do I verify my account?  <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_59" class="collapse">
								<p>To verify your trade account, follow these steps:
								Go to My account > Account verification > Upload the required documents and Click verify).</p><br>
								<p>The Tradespeoplehub.co.uk verification team will review your documents. It can take up to 1- business day and you will be notified when the review process is complete.
								</p><br>
							</div>
								<h6  class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_60"
>What documents do I need to verify my account? <i class="fa fa-angle-down"></i></h6>
 <div id="trad_hel_60" class="collapse">
								<p>To become Tradespeople Hub verified, we require you to provide the following:</p><br>
							</div>
								<h6 class="georgia_font_normal" data-toggle="collapse" data-target="#trad_hel_61"><ul><li>Proof of identity  <i class="fa fa-angle-down"></i></li></ul></h6>
								 <div id="trad_hel_61" class="collapse">
								<p>Proof of identity by submitting a Government-issued photo ID document, such as a passport or driver's license.</p><br>
							</div>
								<h6 class="georgia_font_normal" data-toggle="collapse" data-target="#trad_hel_62"><ul><li>Proof of address  <i class="fa fa-angle-down"></i></li></ul></h6>
								 <div id="trad_hel_62" class="collapse">
								<p>Proof of address by submitting a recent utility bill, such as electric, gas, water or phone bills, a recent bank statement or driver's license. </p><br>
							</div>
								<h6 class="georgia_font_normal"  data-toggle="collapse" data-target="#trad_hel_63"><ul><li>Proof of trade qualification & public insurance (optional). <i class="fa fa-angle-down"></i></li></ul></h6>
								 <div id="trad_hel_63" class="collapse">
								<p>The details registered on your Tradespeoplehub.co.uk account must match the name on your documentation.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_64">What happens if we're not able to verify your account? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_64" class="collapse">
								<p>If you are unable to become Tradespeoplehub.co.uk Verified, Tradespeoplehub.co.uk may place an account limitation or suspend your account as a security measure.</p><br>
								<p>Falsifying your identity is a crime. Tradespeoplehub.co.uk may report users that provide false documentation.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_65">Can I change/update my contact details or address? <i class="fa fa-angle-down"></i></h6>
								 <div id="trad_hel_65" class="collapse">
								<p>To change your contact details, log in to your account and select 'Account' and 'My details'. From there you can update your contact information or your address.
								To change your contact details using the mobile app, select 'Contact details' from the </p><br><br>
							</div>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_66">What do I need to create an account? <i class="fa fa-angle-down"></i>
</h6>
								 <div id="trad_hel_66" class="collapse">
								<p>To create an account with Tradespeople Hub, we require the following information:</p><br>
								<ul><li>Your first name and surname</li></ul>
								<ul><li>Your personal or business address </li></ul>
								<ul><li>Your phone number and email address for receiving notifications</li></ul>
								<ul><li>Your main trade, type of business and number of employees (including yourself)</li></ul>
								<ul><li>Valid UK debit or credit card</li></ul>
								<ul><li>UK bank account for receiving your money </li></ul>
								<p>NB: We don't accept PO Box or virtual address.</p><br>
							</div>
								<h6 class="georgia_font_italic" id="Account-1" data-toggle="collapse" data-target="#trad_hel_67">Can I update my trade category, working distance, company details or password? <i class="fa fa-angle-down"></i>
</h6>
 <div id="trad_hel_67" class="collapse">
								<p>Your trade skills, working distance, company details or the password that you selected during account creation can be changed by logging in to your account and selecting my details.</p><br>
							</div>
							</div>
						</div>
						<div class="box-inner getting-started-Body Common-Body">
							<div class="Common-Content Content-getting-started-1">
								<div class="top-head" id="gettingstarted" style="margin: -20px;margin-bottom: 20px;">
									<h1>Getting Started</h1>
								</div>
								<!-- <h6 id="gettingstarted">How it works</h6>  -->
								<div class="georgia_font">
									<p>
									Tradespeoplehub.co.uk is an online marketplace that connects homeowners and tradespeople across the UK. For tradespeople, we offers a constant source of part-time to full-time job opportunities, without the trouble and expenses of advertising and self-promotion. </p><br>
									<h6 class="georgia_font" id="getting-started-1">How does the site work for tradespeople? </h6>
									<p> Over 20,000 tradespeople across the UK have successfully established their businesses by working with us. They have achieved phenomenal success. You want to know How? </p><br>
									<ul>
										<li>
											<h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_1">Sign up for a free trial <i class="fa fa-angle-down"></i>
											</h6>
										</li>
									</ul>
									 <div id="trad_hel_1" class="collapse">
									<p> Create a trade account (it's free): Tell us where you are and the type of work you do. We'll keep you updated by email & SMS for free when new jobs that match your settings are posted on the site.
									</p><br>
								</div>
									<ul>
										<li><h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_2">Pick a job 
											<i class="fa fa-angle-down"></i>
											</h6>
										</li>
									</ul>
									 <div id="trad_hel_2" class="collapse">
									<p>On our website, homeowners are posting jobs continuously whenever they need a tradesperson. We have more than 30,000 job posts every month, which means you have a better chance to be selected for the best one matching your skills. You will be notified instantly whenever a relevant job is posted. Alternatively, you can also choose from 'find a job' page and choose any active jobs that interest you.
									</p><br>
								</div>
									<ul>
										<li><h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_3">Send your quote <i class="fa fa-angle-down"></i>
											</h6>
										</li>
									</ul>
									 <div id="trad_hel_3" class="collapse">
									<p>Sending quotes was never this easy as it is with us. The ideal way is to introduce yourself, quote your price, mention the time you needed to complete it, and a detailed description of the job. We also provide you with a chat feature which allows you to chat and discuss the job details with the homeowner in real-time.
									</p><br>
								</div>
									<ul>
										<li><h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_4">Job offered  <i class="fa fa-angle-down"></i>
</h6>
										</li>
									</ul>
									 <div id="trad_hel_4" class="collapse">
									<p>Once the homeowner accepts your quote and decides to hire you, then he will officially award you the job by creating a milestone used as an advanced payment.
									</p><br>
								</div>
									<ul>
										<li><h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_5">Get paid <i class="fa fa-angle-down"></i></h6>
										</ul>
										 <div id="trad_hel_5" class="collapse">
											<p>Accept the job offer and always give it your best. Once completed, the homeowner will release the Milestone payment, and the money will be transferred into your bank account.</p><br>
										</div>
										<ul>
											<li><h6 class="georgia_font_italic" id="getting-started-1" data-toggle="collapse" data-target="#trad_hel_6">Provide Feedback <i class="fa fa-angle-down"></i>
												</h6>
											</li>
										</ul>
										 <div id="trad_hel_6" class="collapse">
											<p>Once the job is marked completed, we will ask the homeowner to leave a review and rate your work. Gaining good reviews will help you win future jobs. You can also leave a review for the homeowner to enable prospective employees to know what it's like working with their company.</p><br>
										</div>
										</div>
									</div>
									<div class="Common-Content Content-getting-started-2"  style="display:none;">
										<div class="top-head" id="gettingstarted" style="margin: -20px;margin-bottom: 20px;">
											<h1>Getting Started</h1>
										</div>
										<div class="georgia_font">
											<h6 id="gettingstarted">Why choose us</h6>
											<ul>
												<li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_7"> 100% free trial <i class="fa fa-angle-down"></i></h6></li>
											</ul>
											 <div id="trad_hel_7" class="collapse">
											<p>A free trial plan allows you to try our services entirely free of cost and helps you to decide if it's right for you. </p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_8"> Pay as you go option <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_8" class="collapse">
											<p>Pay as you go, with no monthly fees.</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_9"> Flexible monthly plan <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_9" class="collapse">
											<p>Monthly plans start from £5 a month. You're not bound to any contract.
											You can change your plan and cancel it at any time. </p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_10"> Milestone payment system <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_10" class="collapse">
											<p>Our milestone system makes your payments secure, providing you with peace of mind and acts as a contractual payment between you and the homeowner </p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_11">   Average job lead cost  <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_11" class="collapse">
											<p>
												We offer the lowest lead job cost in the UK. Our average lead cost is £2-5 irrespective of location, size of the job, and demand.
											</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_12"> Time and cost saver – offering significant savings! <i class="fa fa-angle-down"></i>
</h6></li></ul>
 <div id="trad_hel_12" class="collapse">
											<p>
												Our job is to make it easier and cheaper for you to run your business. You're fully in control of the operational side while we're in charge of searching for the right clientele. With us you will worry less about paperwork, and you can spend most of your time making money.
											</p><br>
											<p>
												You will be able to gain savings from the costs of running your business as we handle the complete process of getting you the right clientele from the best available choices. We aim to make the entire practice seamless.
											</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_13">We take care of your marketing <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_13" class="collapse">
											<p>We use our expertise to launch an online marketing strategy to invite homeowners to post jobs with us. We invest heavily with the big search engines like Google and Bing, so whenever the homeowner is looking for a tradesperson online, we're always at the top of the list, finding the right jobs for you.
											</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_14"> Invoicing <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_14" class="collapse">
											<p>There's no need to waste time with documentation as we assist you in handling all the invoices. Our milestone system will take all the pressure from you. When your homeowner releases the milestone payment, an invoice will be generated, and it will be available for both parties to download.</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_15">We offer a first-class service <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_15" class="collapse">
											<p>By gaining access to 10,000 job leads a month from over 40 trade categories on our site, you will be able to build your reputation online. We also offer direct hiring services where homeowners can provide you with a job directly without posting it to the public. They are equipped with access to find you in the directory and your registered trade categories and can hire you directly. </p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_16">Help you in your digital marketing. <i class="fa fa-angle-down"></i>

											</h6></li></ul>
											 <div id="trad_hel_16" class="collapse">
											<p>There's no need to worry about how to find new clientele or paying vast amounts of money to be listed on search engines and Social Media. We do all this for you at little cost, i.e., one-tenth of what you'd pay on directories and Google.
											</p><br>
										</div>
											<ul><li><h6 class="georgia_font_italic" id="gettingstarted-2" data-toggle="collapse" data-target="#trad_hel_17">Embrace the power of our suggested Milestone  <i class="fa fa-angle-down"></i></h6></li></ul>
											 <div id="trad_hel_17" class="collapse">
											<p>We offer a suggested milestone feature, enabling you to suggest a payment breakdown when the job has a large budget.
											</p><br>
										</div>
										</div>
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
	if(main == 'Memberships'){
		$('.'+main+'-Head').hide();
		$('.'+main+'-Body').hide();	
	}else{
		$('.'+main+'-Head').show();
		$('.'+main+'-Body').show();	
	}

	if(content == 'Memberships-1' || content == 'Memberships-2'){
		$('.Content-'+content).hide();	
	}else{
		$('.Content-'+content).show();	
	}	
	
	window.location.href='#'+content;
}

$(document).ready(function(){
	<?php if($setting[0]['payment_method'] == 0){?>
		$('#Memberships').remove();
		$('#Memberships-1').remove();
		$('#Memberships-2').remove();
	<?php }?>
	var textss = window.location.hash.substr(1);
	if(textss){
		var res = textss.split("-");
		
		if(res.length > 2){
			var main = res[0]+'-'+res[1];
		} else {
			var main = res[0];
		}
		
		if(main=='getting-started'){
			$('#headingTwo1 a').click();
		} else if(main=='Job'){
			$('#headingOne a').click();
		} else if(main=='Quotes'){
			$('#headingTwo a').click();
		} else if(main=='Payment'){
			$('#headingThree a').click();
		} else if(main=='Account'){
			$('#headingFive a').click();
		} else if(main=='Memberships'){
			$('#headingFour a').click();
		} else if(main=='Feedback'){
			$('#headingSix a').click();
		} else if(main=='Profilepage'){
			$('#headingSeven a').click();
		} else if(main=='Disputeresolution'){
			$('#headingEight a').click();
		}
		open_possition(res[0],textss);
	}
	
});
</script>