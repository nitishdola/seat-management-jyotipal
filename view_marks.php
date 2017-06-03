<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['STUDENT_ID'])){
	header("location:index.php");
} 
$mark=mysql_fetch_array(mysql_query('select * from student_marks where student_id='.$_SESSION['STUDENT_ID'].' '));
$student=mysql_fetch_assoc(mysql_query('select s.student_id,s.department_id,s.name,s.semester,d.full_name from student s right outer join department d on d.department_id=s.department_id where student_id='.$_SESSION['STUDENT_ID'].' '));
$subject=mysql_query('select * from subject where semester='.$student['semester'].' and department_id='.$student['department_id'].' ');
$subject_code=array();
while($row=mysql_fetch_assoc($subject)){  
	$subject_code[]=$row['subject_code'];
}
$seatQ=mysql_query("select * from exam where semester=".$student['semester']." ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<title> Student</title>
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

			<h1>Marks View </h1>
           
		  <!-- Form -->			
			     <fieldset style="padding:20px;"> 
                  
               <div class="divshow">
                <h5><?php echo 'Name: '.$student['name'].'<br>Semester: '.$student['semester'].'<br>Department: '.$student['full_name'];?></h5>
             
               
 
			<table align="center" style="padding:1px;" width="100%"><tr><th>Subject</th><th>Mark</th></tr>
			<tr><td><?php echo $subject_code[0];?></td><td><?php echo $mark[1];?></td></tr>	 
			<tr><td><?php echo $subject_code[1];?></td><td><?php echo $mark[2];?></td></tr>	 
			<tr><td><?php echo $subject_code[2];?></td><td><?php echo $mark[3];?></td></tr>	 
 			</table> 
 		
            </div>
			<?php echo $paginate; ?>
			</fieldset>
			
			<br><br>
			<h1>Exam Seat </h1>
           
		  <!-- Form -->			
			 <fieldset style="padding:20px;"> 
                  
		   <div class="divshow">
			<?php while($seat=mysql_fetch_assoc($seatQ)){
			$exam_seat=mysql_fetch_assoc(mysql_query("select r.name,es.seat_no from exam_seat es right outer join room r on r.room_id=es.room_id where exam_id=".$seat['exam_id']." and student_id=".$student['student_id']." ") );
			 ?>
			<h5>Date: - <?php echo $seat['exam_date'].' Sift: '.$seat['timing'];?></h5> 
			<h4>Semester- <?php echo $seat['semester'];?></h4>
			<table align="center" style="padding:1px;" width="100%"><tr><th>Room: <?php echo $exam_seat['name'];?></th><th>Seat No: <?php echo $exam_seat['seat_no'];?></th><th>Subject Code: <?php echo $seat['semester'].'0'.$seat['subject_code'];?></th></tr>  
 			</table> 
			<?php }?>
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