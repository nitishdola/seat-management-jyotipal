<?php
//error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
define("HOMETITLE","Atreyi Travels",TRUE);
define('ADMINTITLE','Atreyi Admin',TRUE);
$host="localhost";
$username="root";
$password="";
$db_name="jyotipal";
$con=mysql_connect("$host", "$username", "$password")or die("Connection Not Created!");
mysql_select_db("$db_name", $con)or die("DB Selection Terminated!");
?>