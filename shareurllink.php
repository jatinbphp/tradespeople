

<!DOCTYPE html>

<html>

   <head>

   <title>Tradespeople hub</title>

   <script src='//code.jquery.com/jquery-1.11.2.min.js'></script>



     <script>



     



   (function() {

 var app = {

   launchApp: function() {

       

       var get_link = '<?php echo $_GET['link']; ?>';
        window.location.replace(get_link);

       <?php

          // $get_link = $_GET['link'];

           //header("Location: ".$get_link);

       ?>

     // window.location.replace("twitter://");

     this.timer = setTimeout(this.openWebApp, 3000);

   },



   openWebApp: function() {

     window.location.replace("https://www.tradespeoplehub.co.uk/app_api/webservice/downloadApp.php");

   }

 };



 app.launchApp();

})();

   </script>

   <style type="text/css">

     .twitter-detect {

       display: none;

     }

   </style>

   </head>

   <body>

   <p>Website content.</p>

   </body>

</html>