<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['FACULTY_ID'])){header("location:index.php");} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<title>Dashboard</title>
    <!-- include common -->
    <?php include('comman.php');?>
</head>

<body>
<?php include('header.php');?>
 <!-- /header -->

	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
        <?php include('left.php'); ?>
		 <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">
			<h1>Dashboard</h1>
		
			 
			
           <hr class="noscreen" />
 
           
            
           
		</div> <!-- /content -->
	</div> <!-- /cols -->
	<hr class="noscreen" />
	<!-- Footer -->
	<?php include('footer.php'); ?> <!-- /footer -->
</div> <!-- /main -->
</body>
</html>