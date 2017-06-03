<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['FACULTY_ID'])){
	header("location:index.php");
}

	$result=mysql_query("select s.subject_id,s.subject_code,s.name,s.semester from subject s right outer join faculty_subject fs on fs.subject_id=s.subject_id where fs.faculty_id=".$_SESSION['FACULTY_ID']." ") or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<title> Faculty</title>
    <!-- include common -->
    <?php include('comman.php');?>   
     
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

			<h1>Marks</h1>
           
		  <!-- Form -->			
			     <fieldset style="padding:20px;">
				<legend> <span class="headbox">Manage Marks</span></legend>
                  
               <div class="divshow">
                
             
               <table align="center" width="100%">
					<tr>
					 <td class="rd1">
					Total <b><?=$total_pages;?> </b> Records Found
					</td>  
					</tr>
  
				</table>

 
            	<table align="center" style="padding:1px;" width="100%">
				<tr>
				    <th width="5%">S.No.</th> 
                    <th width="15%">Subject Code</th>	 
					<th width="15%">Name</th>	
					<th width="15%">Semester</th>						
					<th width="15%">Action</th>
              
				</tr> 	 	
				<?php $i=1; $j=1; $k=0; while($data =mysql_fetch_array($result)){?>
                <tr class="<?php if($i%2==1){echo "bg";} ?>">
				    <td><?php echo ++$start;?>.</td> 
                    <td><?php echo $data['subject_code']; ?> </td> 
					<td><?php echo $data['name']; ?> </td> 
					<td><?php echo $data['semester']; ?> </td> 
					 <td><a href="set_marks.php?subject_id=<?php echo $data['subject_id']; ?>">Set Marks</td>
				</tr>
                <?php $i++; } ?>
			</table>  
            </div>
			<?php echo $paginate; ?>
			</fieldset>
			<h1>Faculty Duty </h1>
           
		  <!-- Form -->			
			     <fieldset style="padding:20px;"> 
                  
               <div class="divshow"> 
			<table align="center" style="padding:1px;" width="100%"><tr><th>Exam</th><th>Room </th></tr>
			<?php 
			$dutyq=mysql_query("select 	e.exam_date,e.timing,e.semester,r.name from exam_duty ed right outer join exam e on e.exam_id=ed.exam_id right outer join room r on r.room_id=ed.room_id where faculty_id=".$_SESSION['FACULTY_ID']." ") or die(mysql_error());
			while($duty=mysql_fetch_assoc($dutyq)){
			?>
			<tr><td><?php echo $duty['exam_date'].' - '.$duty['timing'].'<br>Semester: '.$duty['semester'];?></td><td><?php echo $duty['name'];?></td></tr>	  
<?php }?>			
 			</table> 
 		
            </div>
			<?php echo $paginate; ?>
			</fieldset>

		</div> <!-- /content -->

	</div> <!-- /cols -->

	<hr class="noscreen" />

	<!-- Footer -->
	<?php include('footer.php'); ?> <!-- /footer -->

</div> <!-- /main -->
<script type="text/javascript">
$(document).ready(function() {
	$(".example1").fancybox({
		'width' : '70%',
		'height' : '80%',
		'autoScale' : false,
		'titleShow' : false,    
		'type' : 'iframe'
	});
});
</script>
</body>
</html>