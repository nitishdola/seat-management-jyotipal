<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");}
$admin_data1 = mysql_query("SELECT * FROM admin WHERE admin_id='".$_SESSION['Admin_ID']."'");
$admin_data=mysql_fetch_array($admin_data1);
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
			<h1>Styles</h1>
		
			<fieldset style="width:250px; float:left; margin-right:5px; display:block;">
				<legend>Admin Setting</legend>
				<table class="nostyle">
					<tr>
						
						<td style=" background-color:#FFCCCC;"><a href="dashboard.php"><img src="tmp/dashboard.png"   alt="Dashboard" title="Dashboard"/></a></td>
                       <?php /*?> <td><a href=""><img src="tmp/configuration.png"   alt="Info" title="Admin Info" /></a></td>
                        <td><a href=""><img src="tmp/errorlog.png"  alt="Attampt" title="Bad Attampt" /></a></td><?php */?>
                        <td><a href="admin.php"><img src="tmp/services.png"  alt="user" title="Settings" /></a></td>
                    <td><a href="adminchangepassword.php"><img src="tmp/login.png"   alt="user" title="Login Details" /></a></td>
                        
					</tr>
			
				</table>
                
			</fieldset>

			<fieldset style="float:left;">
				<legend>Project</legend>
				<table class="nostyle">
					<tr>
						<td><img src="tmp/customers.png"  alt="User"/></td>
                        <td><img src="tmp/countries.png"  alt="Countries" /></td>
					</tr>
				</table>
                
			</fieldset>
			
           <hr class="noscreen" />
 
            <fieldset >
				<legend>Dashboard</legend>
				<h3 class="tit">Login Info</h3>
			<table style="width:800px;">
				
				<tr class="bg">
				    <td width="250">Last Login :</td>
				    <td><?php echo date('d-m-Y h:s (D)',$admin_data['last_login_time']); ?></td>
				    
				</tr>
                
                <tr class="bg">
				    <td>Last Logout:</td>
				    <td><?php echo date('d-m-Y h:s (D)',$admin_data['logout_time']); ?></td>
				    
				</tr>
                <?php if($admin_data['logout_time']< $admin_data['last_login_time']){?>
                  <tr class="bg">
				    <td>Alert:</td>
				    <td><?php if($admin_data['logout_time']< $admin_data['last_login_time']){echo 'You have not properly logout last time.';} ?></td>
				    
				</tr>
                <?php }?>
				<tr>
				    <td >Last Login IP:</td>
				    <td><?php echo $admin_data['last_login_ip'];?></td>
				    
				</tr>
				 
			</table>
            
           
		</div> <!-- /content -->
	</div> <!-- /cols -->
	<hr class="noscreen" />
	<!-- Footer -->
	<?php include('footer.php'); ?> <!-- /footer -->
</div> <!-- /main -->
</body>
</html>