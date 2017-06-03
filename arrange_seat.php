<?php
ob_start();
session_start();
include("config/db.php");
if(!isset($_SESSION['Admin_ID'])){header("location:index.php");}
$exam = mysql_fetch_assoc(mysql_query("select * from exam where exam_id=".$_GET['exam_id']." "));
$cms = mysql_query("select * from room");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />	
    <title>Atreyi Admin</title>
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

			<h1>Seat Management  </h1>
			<h2>Time: <?php echo $exam['exam_date'].' - '.$exam['timing'];?></h2>
			<form action="" method="post" id="frm"  name="frm" onsubmit="return validate();">
              <table width="100%" border="0" cellpadding="10" cellspacing="2" bgcolor="#E9E7E8">
                
                <?php if($_SESSION['sess_msg']!=''){?>
                <tr>
                  <td colspan="3" align="left" style="vertical-align:top;" class="msg info" style="padding-left:40px;"><?php echo $_SESSION['sess_msg']?>
                  <?php $_SESSION['sess_msg']='';?></td>
                </tr>
                <?php }?>
                
                <tr>
				<?php while($val = mysql_fetch_array($cms)){?>
						 
                <tr class="bgg3" onmouseover="this.className='bgg2'" onmouseout="this.className='bgg3'" style="background-color:<?php echo $color;?>">
                  <td align="left" style="vertical-align:top;" nowrap="nowrap"><?php echo $val['name'];?></td>
                  <td colspan="2" align="left" style="vertical-align:top;">
				   <a href="seat-manage.php?exam_id=<?php echo $_GET['exam_id']; ?>&room_id=<?php echo $val['room_id']; ?>">Seat Management</a>
				  </td>
                </tr>
				<?php  }?>
                    
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
</body>
</html>
