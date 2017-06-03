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
	$editrow = mysql_query("SELECT * FROM subject where subject_id='".$editID."'");	
	$result=mysql_fetch_array($editrow);
	$editrow = mysql_query("SELECT faculty_id FROM faculty_subject where subject_id='".$editID."'");	
	$result1=mysql_fetch_array($editrow);
}

if(isset($_POST['addfaq']))
{   
$department_id = empty($_POST['department_id']) ? '' : trim($_POST['department_id']);
	$name = empty($_POST['name']) ? '' : trim($_POST['name']);
	$faculty_id = empty($_POST['faculty_id']) ? '' : trim($_POST['faculty_id']);  	
	$getr=mysql_fetch_array($get);
	 
			$Update = mysql_query("UPDATE subject set  name='$name'  where subject_id='".$editID."'"); 
			mysql_query("delete from  faculty_subject where subject_id='".$editID."'"); 
	  mysql_query("insert into  faculty_subject set  faculty_id='$faculty_id' , subject_id='".$editID."'"); 
		 
		echo "<script>location.href='manage_subject.php'</script>";
	 
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
			
			<h1>Subject</h1>
           
			<!-- Form -->
			<fieldset style="padding:20px;">
				<legend> <span class="headbox">  Subejct</span></legend>
				<form action="" method="post" id="catform"> <p style='color:red;'><?php echo $message;?></p>
					
					
					<p><br />
						<label style="display:inline-block; width:150px;">Faculty:</label>
						<select   name="faculty_id" id="faculty_id" class="input-text" style="width:290px;" > <option value="" disabled selected >Select ..</option>
                      <?php 
$cms = mysql_query("select * from faculty"); while($val = mysql_fetch_array($cms)){?>
						<option value="<?php echo $val['faculty_id']?>" <?php if(isset($result1['faculty_id']) && $result1['faculty_id'] == $val['faculty_id']){ echo "SELECTED"; }?>><?php echo $val['name']?>
						</option>
                      <?php }?>
                  </select><br /> 
						</p> 	
                    <p>
					 
						</p> 	
                    <p>
					<p><br />
						<label style="display:inline-block; width:150px;">Name:</label>
						<input type="text" style="width:200px; margin-right:10px;" name="name" id="name" value="<?php if(isset($result['name'])) echo ($result['name']);?>" class="input-text" /><br /> 
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