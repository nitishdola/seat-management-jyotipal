<?php session_start();
include('config/db.php');
if($_SESSION['Admin_ID']!='')
{
	mysql_query("UPDATE admin SET logout_time='".time()."' WHERE admin_id ='".$_SESSION['Admin_ID']."'");
}
session_destroy();
header("location:index.php");
?>