<?php ob_start(); 
session_start();
include("config/db.php"); 
if($_POST['room_id'])
{
	$new = array(); 
	for($i=0;$i<20;$i++){  
		if($_POST['student_id'][$i]!=''){
			if (in_array($_POST['student_id'][$i], $new)){
				echo ($i+1);
				exit();
			}else 		$new[]=$_POST['student_id'][$i];
		}
	} 
}