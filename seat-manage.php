<?php
ob_start();
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");}

if(isset($_POST['room_id']) && $_POST['room_id']!='')
{
	/**
	* throwing error default room
	* added later
	* remove if login is incorrect
	*/
	//get the default room
	$room_info = mysql_query("SELECT id,name FROM room WHERE id = ".$_POST['room_id']);
	$default_room = $room_info['name'];
	/** end */

	for($i=0;$i<20;$i++){    
		if(isset($_POST['student_id'][$i])){
			$check=mysql_query("select * from exam_seat where exam_id=".$_GET['exam_id']." and student_id=".$_POST['student_id'][$i]." ") ;
			if(mysql_num_rows($check)==0)
			mysql_query("update exam_seat set student_id='".$_POST['student_id'][$i]."' where exam_id='".$_GET['exam_id']."' and room_id='".$_REQUEST['room_id']."' and seat_no='".($i+1)."' ") ;
		}
	}
	if(isset($_REQUEST['faculty_id'])):
	mysql_query("update exam_duty set faculty_id=".$_REQUEST['faculty_id']."  where exam_id='".$_GET['exam_id']."' and room_id='".$_REQUEST['room_id']."' ");
	endif;

	$_SESSION['sess_msg'] = 'Information updated successfully.';	
} else {
	$_SESSION['sess_msg'] = '';	
}
	
if(isset($_REQUEST['room_id']) && ($_REQUEST['room_id']!=''))
{  
   	$cmss = mysql_query("select s.student_id,es.seat_no,s.name from exam_seat es left outer join student s on s.student_id=es.student_id where es.room_id = '".$_REQUEST['room_id']."' and es.exam_id=".$_GET['exam_id']." ");

   	$room = mysql_fetch_assoc(mysql_query("select * from room where room_id=".$_REQUEST['room_id']." "));

$rows 		= $room['rows']; 
$columns 	= $room['columns'];
} else {
	$cmss = "";
} 
$exam = mysql_fetch_assoc(mysql_query("select * from exam where exam_id=".$_GET['exam_id']." "));  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />	
    <title>  Admin</title>
     <!-- include common -->
    <?php include('comman.php');?>
</head>

<body>

<div id="main">

	<!-- header -->
	<?php include("header.php");?>
    <!-- header -->
	<hr class="noscreen" />

	<!-- Columns -->
	<div id="cols" class="box">

		<!-- Aside (Left Column) -->
		<?php include("left.php");?> 
         <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
		<div id="content" class="box">

			<h1>Seat Management </h1>

			<form action="" method="post" class="frm" id="frm" name="frm"  >
              <table width="100%" border="0" cellpadding="10" cellspacing="2" bgcolor="#E9E7E8">
                
                <?php if($_SESSION['sess_msg']!=''){?>
                <tr>
                  <td colspan="3" align="left" style="vertical-align:top;" class="msg info" style="padding-left:40px;"><?php echo $_SESSION['sess_msg']?>
                  <?php $_SESSION['sess_msg']='';?></td>
                </tr>
                <?php }?>
                <tr class="bgg1" onmouseover="this.className='bgg2'" onmouseout="this.className='bgg1'">
                  <td width="21%" align="left" style="vertical-align:top;" nowrap="nowrap" class="bgg3">Select Room :</td>
<td width="79%" colspan="2" align="left" style="vertical-align:top;" class="bgg3">
                   
					<select     name="room_id" id="room_id" class="input-text" style="width:90px;" onchange="submit();"> 
					 <option value="">Select</option>
                    <?php $cms = mysql_query("select * from room");while($val = mysql_fetch_array($cms)){?>    <option <?php if(isset($_REQUEST['room_id']) && $_REQUEST['room_id']==$val['room_id'] ) echo'selected'; ?> value="<?php echo $val['room_id']; ?>"><?php echo $val['name']; ?></option>  <?php }?>
                  </select>
					<?php if(isset($_REQUEST['room_id'])){?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Faculty Duty: </b>

				  <select     name="faculty_id" id="faculty_id" class="input-text"  > 
					 <option value="">Select</option>
                    <?php $faculty_duty=mysql_fetch_assoc(mysql_query("select faculty_id from exam_duty where exam_id=".$_GET['exam_id']." and room_id=".$_REQUEST['room_id']." "));$cms1 = mysql_query("select * from faculty");while($val = mysql_fetch_array($cms1)){?> 
					<option <?php if(isset($faculty_duty['faculty_id']) && $faculty_duty['faculty_id']==$val['faculty_id'] ) echo'selected'; ?> value="<?php echo $val['faculty_id']; ?>"><?php echo $val['name']; ?></option>  <?php }?>
                  </select>
					<?php }?>
				  </td>
                </tr>
			</table>

			<table width="100%">


                <?php for( $r=1; $r <= $rows; $r++){ ?>
		        <tr width="<?php echo 100/$columns; ?>"%>
		        	<?php for($c=1; $c <= $columns; $c++) { ?>
		            	<td> ROW - <?php echo $r.' COLUMN - '.$c; ?>
		           		
		           		<?php 
		           		$department_id=1;
						while($row=mysql_fetch_assoc($cmss)){  
							if($department_id>4) $department_id=1;
							$query=mysql_query("select * from student where department_id=$department_id  and semester=".$exam['semester']."  ");

							if($department_id==1){ 
								$dd='PE/';$color='orange;';
							}else if($department_id==2){
								$dd='ME/';$color='lightgreen;';
							}else if($department_id==3){
									$dd='CSE/';$color='lightyellow;';
							}else if($department_id==4){
								$dd='ECE/';$color='lightgrey;';
							}
						?>
						<select name="student_id[]" style="min-width:200px;width:200px;">
							<?php 
							if(isset($row['name'])){ 
								while($option=mysql_fetch_assoc($query)){ 
									if($row['student_id']==$option['student_id']) $selected_value='selected'; else $selected_value=''; 
									echo '<option '.$selected_value.'  value="'.$option['student_id'].'">'.$option['name'].' &nbsp;&nbsp;('.$dd.$option['student_id'].')</option>';
								} 
							}else{
								echo '<option disabled selected value="">Not Set</option>';
								while($option=mysql_fetch_assoc($query)){ 
									$filter=mysql_query("select * from exam_seat where student_id=".$option['student_id']." and exam_id=".$_GET['exam_id']."  ");
									if(!mysql_num_rows($filter)){ 
										echo '<option '.$selected_value.'  value="'.$option['student_id'].'">'.$option['name'].' &nbsp;&nbsp;('.$dd.$option['student_id'].')</option>';
									}
								} 
							}
							?>
						  </select>
							
						<?php
						}
						?>

					<? } ?>
					
		            </td>
		            <?php } ?>
		        </tr>

		        <?php } ?>

                <tr>
				<?php 
					$department_id=1;
					while($row=mysql_fetch_assoc($cmss)){  
						if($department_id>4) $department_id=1;
					$query=mysql_query("select * from student where department_id=$department_id  and semester=".$exam['semester']."  ");
					if($department_id==1){ 
						$dd='PE/';$color='orange;';
					}else if($department_id==2){
						$dd='ME/';$color='lightgreen;';
					}else if($department_id==3){
							$dd='CSE/';$color='lightyellow;';
					}else if($department_id==4){
						$dd='ECE/';$color='lightgrey;';
					}?>
                <tr class="bgg3" onmouseover="this.className='bgg2'" onmouseout="this.className='bgg3'" style="background-color:<?php echo $color;?>">
                  <td align="left" style="vertical-align:top;" nowrap="nowrap">Seat No :<?php echo $default_room.' - '.$row['seat_no'];?></td>
                  <td colspan="2" align="left" style="vertical-align:top;">
				  <select name="student_id[]" style="min-width:200px;width:200px;">
					<?php 
					if(isset($row['name'])){ 
						while($option=mysql_fetch_assoc($query)){ 
							if($row['student_id']==$option['student_id']) $selected_value='selected'; else $selected_value=''; 
							echo '<option '.$selected_value.'  value="'.$option['student_id'].'">'.$option['name'].' &nbsp;&nbsp;('.$dd.$option['student_id'].')</option>';
						} 
					}else{
						echo '<option disabled selected value="">Not Set</option>';
						while($option=mysql_fetch_assoc($query)){ 
							$filter=mysql_query("select * from exam_seat where student_id=".$option['student_id']." and exam_id=".$_GET['exam_id']."  ");
							if(!mysql_num_rows($filter)){ 
								echo '<option '.$selected_value.'  value="'.$option['student_id'].'">'.$option['name'].' &nbsp;&nbsp;('.$dd.$option['student_id'].')</option>';
							}
						} 
					}
					?>
				  </select>
				  &nbsp;&nbsp;&nbsp;<?php if(isset($row['name'])) echo $row['name'].'('.$row['student_id'].')';?>
				  </td>
                </tr>
				<?php $department_id++;}?>
                   
                <tr class="bgg3" onmouseover="this.className='bgg2'" onmouseout="this.className='bgg3'">
                  <td align="left" style="vertical-align:top;">&nbsp;</td>
                  <td colspan="2" align="left" style="vertical-align:top;"><label>
                    <input type="button" name="update" class="input-submit" id="button" value="Update" />
                  </label></td>
                </tr>
              </table>
		  </form>

<div class="fix"></div>
			<h3>&nbsp;</h3>
</div> 
	</div> <!-- /cols -->
	<hr class="noscreen" />
	<!-- Footer -->
	<?php include("footer.php");?>
    <!-- /footer -->
</div> <!-- /main -->
<script type="text/javascript">
$('document').ready(function(){   
	$("#button").click(function(){   
		$.ajax({
			type:'post', 
			cache:false, 
			url:"ajaxsubmit.php",
			data: $("#frm").serialize(), 
			success: function(data) {  
				if(data===''){
					 $("#frm").submit();
				}else{
					alert('Duplicate entry at seat no '+data);
					return false;
				} 
			}
		}); 
    });
});
</script>
</body>
</html>
