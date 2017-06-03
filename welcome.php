<?php session_start();
include("config/db.php");
if(!isset($_POST['submit'])){
	header("location:index.php");
} else {
	$user_name = mysql_real_escape_string($_POST['username']);
	$user_pass = mysql_real_escape_string($_POST['password']);
	if($user_name!='' && $user_pass!=''){	
		if($_POST['type']=='admin'){
			$query = mysql_query("SELECT * FROM admin WHERE username = '".$user_name."' AND password ='".$user_pass."'");
			$match = mysql_num_rows($query);
			if($match){
				$admin_record = mysql_fetch_object($query); 
				$_SESSION['Admin_ID']=$admin_record->admin_id;
				$_SESSION['Admin_Name']=$admin_record->username;
				$query = mysql_fetch_array(mysql_query("SELECT * from admin WHERE admin_id ='".$_SESSION['Admin_ID']."'"));
				mysql_query("UPDATE admin SET last_login_ip='".$query['current_login_ip']."',last_login_time='".$query['current_login_time']."' ,current_login_ip='".$_SERVER['REMOTE_ADDR']."',current_login_time='".time()."' WHERE admin_id ='".$_SESSION['Admin_ID']."'");
				header("location:dashboard.php");
			} else {

				$invalidlogin = 'Invalid Username Or Password!'; 
				header("location:index.php?msg=".$invalidlogin);
			} 
		}else if($_POST['type']=='faculty'){  
			$query = mysql_query("SELECT * FROM faculty WHERE user_name = '".$user_name."' AND password ='".$user_pass."'");
			$match = mysql_num_rows($query);
			if($match){ 
				$admin_record = mysql_fetch_object($query); 
				$_SESSION['FACULTY_ID']=$admin_record->faculty_id;
				$_SESSION['Admin_Name']=$admin_record->user_name;
				header("location:manage_marks.php");
			} else {
				$invalidlogin = 'Invalid Username Or Password!'; 
				header("location:index.php?msg=".$invalidlogin);
			} 
		}else if($_POST['type']=='student'){
			$query = mysql_query("SELECT * FROM student WHERE user_name = '".$user_name."' AND password ='".$user_pass."'");
			$match = mysql_num_rows($query);
			if($match){
				$admin_record = mysql_fetch_object($query); 
				$_SESSION['STUDENT_ID']=$admin_record->student_id;
				$_SESSION['Admin_Name']=$admin_record->user_name;
				header("location:view_marks.php");
			} else {
				$invalidlogin = 'Invalid Username Or Password!'; 
				header("location:index.php?msg=".$invalidlogin);
			} 
		}
	} else {
		header("location:index.php");
	}
}
?>