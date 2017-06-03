<html>
<head>
<title>ROUTINE ENTRY</title>
 <center><h1>ENTER THE DETAILS</h1></center>
<hr color="green" width="100%"/>
</head>
<body>
<form method="">
<table align="center">
<tr>
<td>DEPARTMENT: <input type="text" name="txt_dep" placeholder="Enter the dep :"/></td></tr>
<tr>
<br>
<br>
<tr>
<td>SEMESTER : <input type="text" name="txt_sem" placeholder="Enter the semester :"/></td></tr>
<br>
<br>
<tr>
<td>DATE: <input type="text" name="txt_date" placeholder="Enter the date :"/></td></tr>
<br>
<br>
<tr>
<td>SHIFT:<input type="text"name="txt_shift" placeholder=" enter the shift"/></td></tr>
<br>
<br>
<td>SUBJECT_CODE:<input type="text"name="txt_scode" placeholder=" enter the scode"/></td></tr>
<br>
<br>
<tr>
<td>Submit : <input type ="submit" name="btn_sub" value="Submit"/></td></tr>
<tr>
<td> <input type ="submit" name="btn_go" value="GO"/></td></tr>
</table>


<?php
if(isset($_GET["btn_go"]))
{
	header("location:manage_student.php");
}
if(isset($_GET["btn_sub"]))
{
$s=$_GET["txt_dep"];
$p=$_GET["txt_sem"];
$r=$_GET["txt_date"];
$b=$_GET["txt_shift"];
$c=$_GET["txt_scode"];
$con=mysqli_connect("localhost","root","");
if(!$con)
{
	die('could not connect:'.mysql_error());
}
mysqli_select_db($con,"jyotipal123");
$sql="Insert INTO manage_routine (DEPARTMENT,SEMESTER,DATE,SHIFT,SUBJECT_CODE) VALUES('$s','$p','$r','$b','$c')";
if(!mysqli_query($con,$sql))
{
	die('error'.mysql_error());
	
}
echo "1 value added";
mysqli_close($con);
}
?>
</form>
</body>
</head>
</html>