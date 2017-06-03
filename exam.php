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
	$editrow = mysql_query("SELECT * FROM exam where exam_id='".$editID."'");	
	$result=mysql_fetch_array($editrow);
}

if(isset($_POST['addfaq']))
{    
	$exam_date = empty($_POST['exam_date']) ? '' : trim($_POST['exam_date']); 
	$timing = empty($_POST['timing']) ? '' : trim($_POST['timing']);	
	$semester = empty($_POST['semester']) ? '' : trim($_POST['semester']);	
	$subject_code = empty($_POST['subject_code']) ? '' : trim($_POST['subject_code']);	
	$get = mysql_query("SELECT * FROM exam where     semester='".$semester."' and  exam_date='".$exam_date."' ");	
	$getr=mysql_fetch_array($get);
	$get1 = mysql_query("SELECT * FROM exam where     semester='".$semester."' and  subject_code='".$subject_code."' ");	
	$getr1=mysql_fetch_array($get1);
	if($getr['exam_id']){
		$message='This semester have already exam on that day.  !'; 
	}else if($getr1['exam_id']){
		$message='This paper have already sheduled for exam.  !'; 
		
	}else{ 
		$message='';
		if($editID !="")
		{
			$Update = mysql_query("UPDATE exam set   subject_code='".$subject_code."',semester='".$semester."',timing='$timing',exam_date='".$exam_date."' where exam_id='".$editID."'"); 
		}
		else
		{
			$Insert = mysql_query("INSERT INTO  exam set   subject_code='".$subject_code."',semester='".$semester."',timing='$timing',exam_date='".$exam_date."' ") or die(mysql_error()); 
			$exam_id=mysql_insert_id();
			$get=mysql_query('select room_id,seat from room ');
			while($row=mysql_fetch_array($get)){
				for($i=1;$i<=$row[1];$i++){
					mysql_query('insert into exam_seat set exam_id="'.$exam_id.'",room_id="'.$row[0].'",seat_no="'.$i.'" ');
				}
				mysql_query('insert into exam_duty set exam_id="'.$exam_id.'",room_id="'.$row[0].'",faculty_id=0 ');
			}
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
			
			<h1>Exam</h1>
           
			<!-- Form -->
			<fieldset style="padding:20px;">
				<legend> <span class="headbox">Add Exam</span></legend>
				<form action="" method="post" id="catform"> <p style='color:red;'><?php echo $message;?></p>
					<p><br />
						<label style="display:inline-block; width:150px;">Sift:</label>
						<select name="timing" id="timing" style="width:100px; height: 25px;  vertical-align:top;"><option value="morning" <?php if(isset($result['timing']) && $result['timing']=='morning')echo 'selected'; ?> >Morning</option><option <?php if(isset($result['timing']) && $result['timing']=='evening') echo 'selected'; ?>  value="evening">Evening</option></select>
						</p> 	
                                    <p>  	
					<p><br />
						<label style="display:inline-block; width:150px;">Date:</label>
						<input type="text" style="width:200px; margin-right:10px;" name="exam_date" id="date" value="<?php if(isset($result['exam_date']) && strtotime($result['exam_date'])!=0) echo date_format(new DateTime($result['exam_date']), 'd-m-Y');?>" class="input-text" readonly/><br /><br /><br />
						</p> 
<p><br />
						<label style="display:inline-block; width:150px;">Semester:</label>
						<select  <?php if(isset($result['semester'])) echo'disabled'; ?>  name="semester" id="semester" class="input-text" style="width:90px;" > 
                       <option <?php if(isset($result['semester']) && $result['semester']=='2' ) echo'selected'; ?> value="2">2</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='4' ) echo'selected'; ?> value="4">4</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='6' ) echo'selected'; ?> value="6">6</option> 
					   <option <?php if(isset($result['semester']) && $result['semester']=='8' ) echo'selected'; ?> value="8">8</option> 
                  </select><br /><br /><br />
						</p> 						
                                <p><br />
						<label style="display:inline-block; width:150px;">Subject NO:</label>
						<select  <?php if(isset($result['subject_code'])) echo'disabled'; ?>  name="subject_code" id="subject_code" class="input-text" style="width:90px;" > 
                       <option <?php if(isset($result['subject_code']) && $result['subject_code']=='1' ) echo'selected'; ?> value="1">1</option> 
					   <option <?php if(isset($result['subject_code']) && $result['subject_code']=='2' ) echo'selected'; ?> value="2">2</option> 
					   <option <?php if(isset($result['subject_code']) && $result['subject_code']=='3' ) echo'selected'; ?> value="3">3</option> 
					   <option <?php if(isset($result['subject_code']) && $result['subject_code']=='4' ) echo'selected'; ?> value="4">4</option> 
                  </select><br /><br /><br />
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