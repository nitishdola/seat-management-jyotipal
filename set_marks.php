<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['FACULTY_ID'])){
	header("location:index.php");
} 
if(isset($_POST['update']) && ($_POST['subject_number']!=''))
{
	for($i=0;$i<count($_POST['student_id']);$i++){  
		$check=mysql_query("update student_marks set subject".$_POST['subject_number']."=".$_POST['mark'][$i]." where student_id='".$_POST['student_id'][$i]."'   ") or die(mysql_error());
	}
	$_SESSION['sess_msg'] = 'Information updated successfully.';	
} else {
	$_SESSION['sess_msg'] = '';	
}
	$subject = mysql_fetch_assoc(mysql_query("SELECT s.department_id,s.semester,s.subject_id,s.subject_code,d.full_name from subject s right outer join department d on d.department_id=s.department_id where s.subject_id=".$_GET['subject_id']." "));
	$subject_number=substr($subject['subject_code'],-1);
	$result=mysql_query("select s.student_id,s.name,sm.subject$subject_number from student s right outer join student_marks sm on sm.student_id=s.student_id where department_id=".$subject['department_id']." and semester=".$subject['semester']." "); 	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />
	<title> Admin</title>
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

			<h1>Subject Marks Entry </h1>
           
		  <!-- Form -->			
			     <fieldset style="padding:20px;"> 
                  
               <div class="divshow">
                <h5><?php echo 'Subject Code: '.$subject['subject_code'].'<br>Semester: '.$subject['semester'].'<br>Department: '.$subject['full_name'];?></h5>
             
               <table align="center" width="100%">
					<?php if($_SESSION['sess_msg']!=''){?>
                <tr>
                  <td colspan="3" align="left" style="vertical-align:top;" class="msg info" style="padding-left:40px;"><?php echo $_SESSION['sess_msg']?>
                  <?php $_SESSION['sess_msg']='';?></td>
                </tr>
                <?php }?> 
  
				</table>

 <form method="post">
            	<table align="center" style="padding:1px;" width="100%">
				<tr>
				    <th width="5%">S.No.</th> 
                    <th width="15%">Student </th>	 
					<th width="15%">Mark</th>	 
              
				</tr> 	 	<input type="hidden" name="subject_number" value="<?php echo $subject_number;?>" />
				<?php $i=1;  while($data =mysql_fetch_array($result)){?>
                <tr class="<?php if($i%2==1){echo "bg";} ?>">
				    <td><?php echo $i;?>.</td> 
                    <td><?php echo $data[1].'('.$data[0].')'; ?> </td> 
                    <td><input type="hidden" value="<?php echo $data[0];?>" name="student_id[]" /><input type="text" value="<?php echo $data[2];?>" name="mark[]" /> </td>  
				</tr>
                <?php $i++; } ?>
<tr class="bgg3" onmouseover="this.className='bgg2'" onmouseout="this.className='bgg3'">
                  <td align="left" style="vertical-align:top;">&nbsp;</td>
                  <td colspan="2" align="left" style="vertical-align:top;"><label>
                    <input type="submit" name="update" class="input-submit" id="button" value="Update" />
                  </label></td>
                </tr>			</table> 
</form>			
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