<?php
	session_start();
    define('DbHost', 'localhost');
    define('DbUser', 'tictadmi_tictme');
    define('DbPass', 'tictme@123');
    define('DbName', 'tictadmi_tictme');  
    define('MAIN_URL', 'http://tict.me/');  
    define('ADMIN_URL', 'http://tict.me/Admin/');
    define('Sitemail', 'info@tict.me');
    define('Project', 'TickMe');
	define('adminEmail', 'govinda.wedwider@gmail.com');
	date_default_timezone_set('Asia/Kolkata');

	class Functions
	 { 
	    function __construct()
        { 
       		
		  
           $this->con=mysqli_connect(DbHost, DbUser, DbPass, DbName) or die('Could not connect: ' . mysqli_connect_error());
		  
	    }
	    function lastId()
		{
			$q=mysqli_insert_id($this->con);
			return $q;
		}
	    function my_query($post)
		{	
			$sql="";
			foreach($post as $key=>$value) 
			{
				$sql.=$key."="."'".htmlentities($value,ENT_QUOTES)."',";
			}
			$sql=rtrim($sql,",");
			return $sql;
		}
		function my_query1($post)
		{	
			$sql="";
			foreach($post as $key=>$value) 
			{
				$sql.=$key."="."'".$value."',";
			}
			$sql=rtrim($sql,",");
			return $sql;
		}
 
	    function query($q)
	    {
	        $sqlquery = mysqli_query($this->con,$q);
	        return $sqlquery;
	    }
		function getuser()
		{
			$sql="select * from `admin` where id ='".$_SESSION['adminuserid']."'";
			$runquery=$this->query($sql);
			return $runquery;
		}
		function PendingUsers()
		{
			$sql = "SELECT * FROM  user_tbl WHERE verify='0' ORDER BY id DESC";
	 		$runquery=$this->query($sql);
			return $runquery;
		}
		function ActiveUsers()
		{
			$sql = "SELECT * FROM 	user_tbl ORDER BY id DESC";
	 		$runquery=$this->query($sql);
			return $runquery;
		}
		function GetuserByid($uid)
		{

		   $sql="SELECT * FROM user_tbl where id='$uid' ";
			$query=$this->query($sql);
	 		return $query;
	 		   
		}
		function Getcontact_us()
		{  

		   $sql="SELECT * FROM contact_us";
			$query=$this->query($sql);
	 		return $query;
	 		   
		}
		
		function Getsubscription_plan()
		{  

		    $sql="SELECT * FROM subscription_plan";
			$query=$this->query($sql);
	 		return $query;
	 		   
		}
		
		
		function GetstatisticsMonth($month,$year,$user_id)
		{ 
		    $sql="SELECT * FROM statistics where `month`='".$month."' and `year`='".$year."' and `user_id`='".$user_id."'";
			$query=$this->query($sql);
	 		return $query;
		  
		}
		function GetstatisticsToday($today,$user_id)
		{ 
		    $sql="SELECT * FROM statistics where `date`='".$today."' and  `user_id`='".$user_id."'";
			$query=$this->query($sql);
	 		return $query;
		
		}
		function Getstatisticsweek($monday,$sunday,$user_id)
		{ 
		   $sql="SELECT count(*) as hits,`date` FROM statistics where `date` BETWEEN  '".$monday."' and '".$sunday."' and `user_id`='".$user_id."' group by `date`";
			$query=$this->query($sql);
	 		return $query;   
		
		}
	
		}
?>	  