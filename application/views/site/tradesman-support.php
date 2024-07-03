<?php include ("include/header.php") ?>
<div class="graty_bg">
	<div class="inner_list">
		<div class="container">
			<ul class="page_linkk ul_set">
				<li>
					<a href="index.php">Home</a>
				</li>
				<li class="active">
					Homeowner support
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="dashboard">
	<div class="container">
		<div class="dash-page">
			<div class="row">
				<!-- left -->
				<div class="col-sm-3">
					
 <div class="stickydiv"  id="sidebar">
<div class="left-menu">
	<ul>
		<li><a href="#">About our fees</a></li>
		<li><a href="#">Joining TradespeopleHub </a></li>
		<li><a href="#">How to win more work</a></li>
		<li><a href="#">Job leads & shortlisting</a></li>
		<li><a href="#">Feedback</a></li>
		<li><a href="#">Technical help</a></li>
	</ul>
</div>
</div>

				</div>
				<!-- left -->
				<!-- right -->
				<div class="col-sm-9" id="content">
					<div class="rightside">
					<div class="top-head">
						<h1>About our fees</h1>
					</div>
						
						<div class="box-inner">
						<h6>Does it cost anything to post a job?</h6>
						<p>
							

It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.  It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.   It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted. 

						</p>
						<h6>Does it cost anything to post a job?</h6>
						<p>
							

It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.  It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.   It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted. 

						</p>
					</div>
					<div class="top-head mt20">
						<h1>Joining TradespeopleHub</h1>
					</div>
						
						<div class="box-inner">
						<h6>Does it cost anything to post a job?</h6>
						<p>
							

It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.  It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.   It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted. 

						</p>
						<h6>Does it cost anything to post a job?</h6>
						<p>
							

It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.  It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted.   It doesn’t cost anything to post a job on TradespeopleHub.com. We charge tradespeople an introduction fee based on the size of the job that you have posted. 

						</p>
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

  $(document).ready(function () {

   

    $(document).on("scroll", onScroll);

   

  $('a[href^="#"]').on('click', function (e) {

        e.preventDefault();

          $(document).off("scroll");

           $('a').each(function () {

              $(this).removeClass('active');

          })

          $(this).addClass('active');

           var target = this.hash,

           menu = target;

           $target = $(target);

         $('html, body').stop().animate({

              'scrollTop': $target.offset().top+2

          }, 1000, 'swing', function () {

              window.location.hash = target;

              $(document).on("scroll", onScroll);

          });

      });

  });
  function onScroll(event){

      var scrollPos = $(document).scrollTop();

      $('#sidebar a').each(function () {

          var currLink = $(this);

         var refElement = $(currLink.attr("href"));

          if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {

              $('#sidebar ul li a').removeClass("active");

              currLink.addClass("active");

          }
          else{
              currLink.removeClass("active");

          }

      });

  }


  </script>