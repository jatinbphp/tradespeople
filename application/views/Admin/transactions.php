<?php 
include_once('include/header.php');
if(!in_array(13,$my_access)) { redirect('Admin_dashboard'); }
?>
<style>
.table-responsive {
    overflow: auto;
}
@media (max-width:575.98px){
    .table-responsive-sm{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-sm>.table-bordered{
        border:0
    }
}
@media (max-width:767.98px){
    .table-responsive-md{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-md>.table-bordered{
        border:0
    }
}
@media (max-width:991.98px){
    .table-responsive-lg{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-lg>.table-bordered{
        border:0
    }
}
@media (max-width:1199.98px){
    .table-responsive-xl{
        display:block;
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
        -ms-overflow-style:-ms-autohiding-scrollbar
    }
    .table-responsive-xl>.table-bordered{
        border:0
    }
}
</style>
<div class="content-wrapper">

  <section class="content-header">
	
    <h1>Transaction History</h1>
		
		<ol class="breadcrumb">
		
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			
			<li class="active">Transaction History</li>
			
		</ol> 
		
	</section>

  <section class="content">
	
    <div class="row">
		
      <div class="col-xs-12">
			
        <div class="box">
				
          <div class="div-action pull pull-right" style="padding-bottom:20px;"> </div> 
					
          <div class="box-body">
					
			<div class="table-responsive">
						
            <table id="boottable" class="table table-bordered table-striped">
						
              <thead>
							
                <tr> 
                  <th>S.NO</th>	
                  <th>Amount</th>
                  <th>User</th>	
                  <th>Message</th>		
                  <th>Transaction ID</th>							
                  <th>Type</th>	
                  <th>Status</th>
                  <th>Date</th>		
                </tr>
								
              </thead>
							
              <tbody>
							
								<?php
								
								$x=1;
								
								foreach($trasactions as $lists) {
		                        $user=$this->Common_model->get_userDataByid($lists['tr_userid']);
								?>
             
                <tr role="row" class="odd">
				  <td><?php echo $x; ?></td>	
				  <td>£<?php echo $lists['tr_amount']; ?></td>			
                  <td><?php echo $user['f_name']." ".$user['l_name']; ?></td>
                  <td><?php echo $lists['tr_message']; ?></td>
                  <td><?php echo $lists['tr_transactionId']; ?></td>
                  <td>
                  	  <?php if($lists['tr_type']==1){
                        echo "Credited";
                      }else{
                        echo "Debited";
                      }?>
                  </td>
                  <td>
                  	  <?php if($lists['tr_status']==1){
                        echo "Success";
                      }else{
                        echo "Failed";
                      }?>
                  </td>
                  <td><?php echo date('d-m-Y h:i:s A',strtotime($lists['tr_created'])); ?></td>
                </tr>
								
              <?php $x++; } ?>
							
              </tbody>
							
            </table>   
        </div>
			
          </div>
					
        </div>
				
      </div>
			
    </div>
		
  </section>
	
</div>
<script>
$(document).ready(function(){
	mark_read_in_admin('transactions',"1=1");
});
</script>
<?php include_once('include/footer.php'); ?>
<script>

function fnExcelReport() {
	
	var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
	
	var textRange; var j=0;
	
	tab = document.getElementById('boottable'); // id of table

	for(j = 0 ; j < tab.rows.length ; j++) { 
	
		tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
		//tab_text=tab_text+"</tr>";
	}

	tab_text=tab_text+"</table>";
	
	tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
	
	tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
	
	tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

	var ua = window.navigator.userAgent;
	
	var msie = ua.indexOf("MSIE "); 

	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
		
		txtArea1.document.open("txt/html","replace");
		
		txtArea1.document.write(tab_text);
		
		txtArea1.document.close();
		
		txtArea1.focus();
		
		sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		
	} else  {    
		//other browser not tested on IE 11
		sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text)); 
	}

    return (sa);
}
</script>




  