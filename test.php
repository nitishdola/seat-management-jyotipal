<?php
ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){
	header("location:index.php");
} 

$get=mysql_query('select room_id from room ');
while($row=mysql_fetch_array($get)){
	for($i=1;$i<=20;$i++){
		mysql_query('insert into exam_seat set room_id="'.$row[0].'",seat_no="'.$i.'" ');
	}
}
