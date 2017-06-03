<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");}
$admin_data = mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE admin_id='".$_SESSION['Admin_ID']."'"));
$message;
if(isset($_POST['update_pass'])){
$current_pass = mysql_real_escape_string($_POST['curr_pass']);
$new_pass = mysql_real_escape_string($_POST['new_pass']);
$conf_pass = mysql_real_escape_string($_POST['conf_pass']);
if($admin_data['password']==$current_pass && $new_pass==$conf_pass && $new_pass!='' && $conf_pass!='') 
{
$u = mysql_query("UPDATE admin SET password = '".$new_pass."' WHERE admin_id = '".$_SESSION['Admin_ID']."'");
if(isset($u)){$message ='<p class="msg done">Sucessfully Record Updated.</p>';}else{ $message = '<p class="msg error">Error occured at insertion time.</p>';
} 
}else{ if($new_pass=='' || $conf_pass=='' ||$current_pass=='' ){$message='<p class="msg error">Field should not be blank.</p>';}else{$message='<p class="msg error">Record not matched.</p>';}
}
}
if(isset($_POST['update_email'])){
$current_pass = mysql_real_escape_string($_POST['curr_pass']);
$new_email = mysql_real_escape_string($_POST['new_email']);
$conf_email = mysql_real_escape_string($_POST['conf_email']);
if($admin_data['password']==$current_pass && $new_email==$conf_email && $new_email!='' && $conf_email!='') 
{
$u = mysql_query("UPDATE admin SET email = '".$new_email."' WHERE admin_id = '".$_SESSION['Admin_ID']."'");
if(isset($u)){$message1 ='<p class="msg done">Sucessfully Record Updated.</p>';}else{ $message1 = '<p class="msg error">Error occured at insertion time.</p>';
} 
}else{$message1='<p class="msg error">Field should not be blank.</p>';}

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
    
 <script type="text/javascript">
 function changeFrm(){
	 
	 
	 
 }
 </script>
    
    
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
						
						<td	><a href="dashboard.php"><img src="tmp/dashboard.png"   alt="Admin" title="Admin"/></a></td>
                      <?php /*?>  <td><a href=""><img src="tmp/configuration.png"   alt="Info" title="Admin Info" /></a></td>
                        <td><a href=""><img src="tmp/errorlog.png"  alt="Attampt" title="Bad Attampt" /></a></td><?php */?>
                        <td><a href="admin.php"><img src="tmp/services.png"  alt="user" title="Settings" /></a></td>
                        <td style="background-color:#FFCCCC;"><a href="adminchangepassword.php"><img src="tmp/login.png"   alt="user" title="Login Details" /></a></td>
                        
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
				<h3 class="tit">Change Password</h3>
                <?php  if(isset($message)){echo $message; $message='';}?>
                <form method="post" action="" onsubmit="return validate();">
			<table style="width:800px;" class="nostyle">
				
					<tr>
						<td style="width:200px;">Current Password:</td>
						<td><input type="password" size="40" name="curr_pass" id="curr_pass" value="" class="input-text" /></td>
					</tr>
					<tr>
						<td>New Password:</td>
						<td><input type="password" size="40" name="new_pass" id="new_pass" value="" class="input-text"  /></td>
					</tr>
                    
                    <tr>
						<td>Confirm Password:</td>
						<td><input type="password" size="40" name="conf_pass" id="conf_pass" value="" class="input-text" /></td>
					</tr>
                   					
					<tr>
						<td colspan="2" class="t-center"><input type="submit" name="update_pass" class="input-submit" value="Update Password" /></td>
					</tr>
				
			</table>
            </form>
            
            
            		<h3 class="tit">Change Email</h3>
                <?php  if(isset($message1)){echo $message1; $message1='';}?>
                <form method="post" action="" onsubmit="return validate();">
			<table style="width:800px;" class="nostyle">
				
					<tr>
						<td style="width:200px;">Password:</td>
						<td><input type="password" size="40" name="curr_pass" id="curr_pass" value="" class="input-text" /></td>
					</tr>
					<tr>
						<td>New Email:</td>
						<td><input type="text" size="40" name="new_email" id="new_email" value="" class="input-text"  /></td>
					</tr>
                    
                    <tr>
						<td>Confirm Email:</td>
					<td><input type="text" size="40" name="conf_email" id="conf_email" value="" class="input-text" /></td>
					</tr>
                   					
					<tr>
						<td colspan="2" class="t-center"><input type="submit" name="update_email" class="input-submit" value="Update Mail" /></td>
					</tr>
				
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