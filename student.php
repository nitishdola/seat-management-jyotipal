<?php
ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");} 

$pagename = empty($_GET['pagename']) ? '' : $_GET['pagename'];
$page = empty($_GET['page']) ? '' : $_GET['page'];
$searchtext = empty($_GET['searchtext']) ? '' : $_GET['searchtext'];
$searchcat = empty($_GET['searchcat']) ? '' : $_GET['searchcat'];

$url = $pagename.'?page='.$page.'&searchtext='.$searchtext.'&searchcat='.$searchcat;
$url1 = 'pagename='.$pagename.'&page='.$page.'&searchtext='.$searchtext.'&searchcat='.$searchcat;

$editID = empty($_GET['editID']) ? 0 : mysql_real_escape_string($_GET['editID']);

if($editID !="")
{
	$editrow = mysql_query("SELECT * FROM student where student_id='".$editID."'");	
	$result=mysql_fetch_array($editrow);
}

if(isset($_POST['addfaq']))
{   
$department_id = empty($_POST['department_id']) ? '' : trim($_POST['department_id']);
	$name = empty($_POST['name']) ? '' : trim($_POST['name']);
	$user_name = empty($_POST['user_name']) ? '' : trim($_POST['user_name']); 
	$password = empty($_POST['password']) ? '' : trim($_POST['password']);	
	$get = mysql_query("SELECT * FROM student where  user_name='$user_name' and password='".$password."' ");	
	$getr=mysql_fetch_array($get);
	if($getr['student_id']){
		$message='Duplicate username !'; 
	}else{ 
		$message='';
		if($editID !="")
		{
			$Update = mysql_query("UPDATE student set  name='$name',password='".$password."' where student_id='".$editID."'"); 
		}
		else
		{
			$Insert = mysql_query("INSERT INTO  student set  department_id='$department_id',name='$name',password='".$password."',user_name='".$user_name."' ") or die(mysql_error()); 
			mysql_query("insert into student_marks set student_id=".mysql_insert_id()." ");
		}

		echo "<script>location.href='".$url."'</script>";
	}
} else if(isset($_POST['canceldata'])) {
	echo "<script>location.href='".$url."'</script>";
}

$delID = empty($_GET['delID']) ? 0 : mysql_real_escape_string($_GET['delID']);
if($delID !="")
{
	$Delete = mysql_query("DELETE from destination where destination_id = '".$delID."'");	
	echo "<script>location.href='manage_destination.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-language" content="en" />
<meta name="robots" content="noindex,nofollow" />
<title> Admin</title>

<!-- include common -->
<?php include('comman.php');?>
<script>
var http1 = createRequestObject();
var http2 = createRequestObject();

function createRequestObject() {
    var tmpXmlHttpObject;
    
    //depending on what the browser supports, use the right way to create the XMLHttpRequest object
    if (window.XMLHttpRequest) { 
        // Mozilla, Safari would use this method ...
        tmpXmlHttpObject = new XMLHttpRequest();
	
    }
	else if (ua.indexOf('msie 5') == -1) {
		tmpXmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP");
	}
	else { 
		tmpXmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return tmpXmlHttpObject;
}

function contactFrm111(){ 
	if($('#destination_en').val()=='') {
		alert("Please Enter Destination");
		$('#destination_en').focus();
		return false;
	}
        if($('#destination_ru').val()=='') {
		alert("Please Enter Destination(Russian)");
		$('#destination_ru').focus();
		return false;
	}
}

$(document).ready(function(){ 
	$('#date').datepick({ 
    multiSelect: 0, monthsToShow: 2, 
    showTrigger: '#calImg', defaultDate: new Date(), minDate: new Date(), dateFormat: 'yyyy-mm-dd'});
});

function getRegions(ID) { 
	var url="ID="+ID; 
	http1.open('POST', 'regions-dest.php', true);

	http1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http1.setRequestHeader("Content-length", url.length);
	http1.setRequestHeader("Cache-Control", "no-cache, must-revalidate");
	http1.setRequestHeader("Connection", "close");

	//assign a handler for the response
	http1.onreadystatechange = getRegion_listResponse;

	//actually send the request to the server
	http1.send(url);
}

function getRegion_listResponse() {
    if(http1.readyState == 4 && http1.status == 200){
		var response = http1.responseText;
		if(response!=""){
			$("select[id$=region] > option").remove();
			document.getElementById('region').innerHTML=response;
		}
    }
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
			
			<h1>student</h1>
           
			<!-- Form -->
			<fieldset style="padding:20px;">
				<legend> <span class="headbox">  student</span></legend>
				<form action="" method="post" id="catform"> <p style='color:red;'><?php echo $message;?></p>
					
					
					<p><br />
						<label style="display:inline-block; width:150px;">Department:</label>
						<select  <?php if(isset($result['department_id'])) echo'disabled'; ?> name="department_id" id="department_id" class="input-text" style="width:290px;" > 
                      <?php 
$cms = mysql_query("select * from department"); while($val = mysql_fetch_array($cms)){?>
						<option value="<?php echo $val['department_id']?>" <?php if(isset($result['department_id']) && $result['department_id'] == $val['department_id']){ echo "SELECTED"; }?>><?php echo $val['full_name']?>
						</option>
                      <?php }?>
                  </select><br /> 
						</p> 	
                    <p>
					<p><br />
						<label style="display:inline-block; width:150px;">Semester:</label>
						<select  <?php if(isset($result['semester'])) echo'disabled'; ?>  name="semester" id="semester" class="input-text" style="width:90px;" > 
                       <option <?php if(isset($result['semester']) && $result['semester']=='2' ) echo'selected'; ?> value="2">2</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='4' ) echo'selected'; ?> value="4">4</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='6' ) echo'selected'; ?> value="6">6</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='8' ) echo'selected'; ?> value="8">8</option> 
                  </select><br /> 
						</p> 	
                    <p>
					<p><br />
						<label style="display:inline-block; width:150px;">Name:</label>
						<input type="text" style="width:200px; margin-right:10px;" name="name" id="name" value="<?php if(isset($result['name'])) echo ($result['name']);?>" class="input-text" /><br /> 
						</p> 	
                    <p><br />
						<label style="display:inline-block; width:150px;">User Name:</label>
						<input type="text" style="width:200px; margin-right:10px;" name="user_name" id="user_name" value="<?php if(isset($result['user_name'])) echo ($result['user_name']);?>" <?php if(isset($result['user_name'])) echo 'disabled';?> class="input-text" /><br /> 
						</p> 	
							<p><br />
						<label style="display:inline-block; width:150px;">Password:</label>
						<input type="text" style="width:200px; margin-right:10px;" name="password" id="password" value="<?php if(isset($result['password'])) echo ($result['password']);?>" class="input-text" /><br /> 
						</p> 	
						    
					 
					<table>
					
             
					</table>
					<p><input class="button" type="submit" value="Submit" name="addfaq" id="addfaq" onclick="return contactFrm111();" />
          				<input class="button" type="submit" value="Cancel" name="canceldata" id="canceldata"  />
					</p>
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