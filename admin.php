<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");}
$admin_data = mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE admin_id='".$_SESSION['Admin_ID']."'"));
$message;
if(isset($_POST['submit'])){
$username = mysql_real_escape_string($_POST['username']);
$email = mysql_real_escape_string($_POST['email']);
if($username!='' && $email!=''){ $u = mysql_query("UPDATE admin SET username = '".$username."',email='".$email."' WHERE admin_id = '".$_SESSION['Admin_ID']."'");
if(isset($u)){$message ='<p class="msg done">Sucessfully Record Updated.</p>';}else{ $message = '<p class="msg error">Error occured at insertion time.</p>';}
}else{$message='<p class="msg error">Field should not be blank.</p>';}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<title>Atreyi Admin</title>
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
		
			<fieldset style="width:250px; float:left; margin-right:5px;">
				<legend>Admin Setting</legend>
				<table class="nostyle">
					<tr>
						
						<td style="border:1px solid #06F;"><a href="dashboard.php"><img src="tmp/dashboard.png"   alt="Admin" title="Admin"/></a></td>
                       <?php /*?> <td><a href=""><img src="tmp/configuration.png"   alt="Info" title="Admin Info" /></a></td>
                        <td><a href=""><img src="tmp/errorlog.png"  alt="Attampt" title="Bad Attampt" /></a></td><?php */?>
                        <td style="background-color:#FFCCCC;"><a href="admin.php"><img src="tmp/services.png"  alt="user" title="Settings" /></a></td>
                        <td><a href="adminchangepassword.php"><img src="tmp/login.png"   alt="user" title="Login Details" /></a></td>
                        
					</tr>
			
				</table>
                
			</fieldset>

			<fieldset style=" float:left;">
				<legend>Project</legend>
				<table class="nostyle">
					<tr>
						
						<td><img src="tmp/customers.png"  alt="User"/></td>
                        <td><img src="tmp/countries.png"  alt="Countries" /></td>
                      
					</tr>
			
				</table>
                
			</fieldset>
           <hr class="noscreen" />
 
            <fieldset>
				<legend>Dashboard</legend>
				<h3 class="tit">Admin Info</h3>
                <?php  if(isset($message)){echo $message; $message='';}?>
                <form method="post" action="" onsubmit="return validate();">
			<table style="width:800px;" class="nostyle">
				
					<tr>
						<td style="width:200px;">User Name:</td>
						<td><input type="text" size="40" name="username" id="username" value="<?php echo $admin_data['username'];?>" class="input-text" disabled="disabled" /></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" size="40" name="email" id="email" value="<?php echo $admin_data['email'];?>" class="input-text"  disabled="disabled" /></td>
					</tr>
                     <tr>
						<td>Password:</td>
						<td><input type="password" size="40" name="password" id="password" value="<?php echo $admin_data['password'];?>" class="input-text"  disabled="disabled" /></td>
					</tr>
                   					
					<?php /*?><tr>
						<td colspan="2" class="t-center"><input type="submit" name="submit" class="input-submit" value="Submit" /></td>
					</tr><?php */?>
                    
                          
				
			</table>
            </form>
                
			</fieldset>
		</div> <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />

	<!-- Footer -->
	<?php include('footer.php'); ?> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>