<?php include 'include/header.php'; ?>
<style>
.chosen-container.chosen-container-multi {
  width: 100% !important;
  #processing-popup .modal-dialog{
    display: table;
    position: relative;
    margin: 0 auto;
    top: calc(50% - 24px);
  }
}

.form-rounded {
border-radius: 1rem;
}
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
<script>
function CopyToClipboard(containerid) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy");
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    //alert("Text has been copied, now paste in the text-area")
  }
}
function goBack() {
  window.history.back();
}
/*function myFunction() {
  var copyText = document.getElementsByClassName('test');
copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand('copy');
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText;
}

function outFunc () {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}*/
</script>
<div class="content-wrapper">
	<div class="panel panel-default" style="width:96%; margin:auto;">
		<div class="panel-heading">
			<section class="content-header">
			<h1>Generate HTML Code</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Generate HTML Code</li>
			</ol>
			</section>
		</div>
		<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form method="POST" name="form_send_emails" id="form_send_emails" action="" enctype="multipart/form-data">
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-body" id="email_container">
							<pre><?php echo $htm;?></pre>
						</div>
						<div class="panel-footer">
							<button type="button" class="btn btn-warning" onclick="CopyToClipboard('email_container')">
							Copy Code
							</button> &nbsp;&nbsp; 
							<button type="button" class="btn btn-primary" onclick="goBack()">
							Back
							</button>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		</section>
	</div>
</div>

<?php include 'include/footer.php'; ?>
	