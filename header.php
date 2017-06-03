<div id="main">
	<!-- Tray -->
	<div id="tray" class="box">
		<p class="f-left box">
			<!-- Switcher -->
			<span class="f-left" id="switcher">
				<a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="design/switcher-1col.gif" alt="1 Column" /></a>
				<a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="design/switcher-2col.gif" alt="2 Columns" /></a>
			</span> 
		</p>

		<p class="f-right">User: <strong><a href="admin.php"><?php echo $_SESSION['Admin_Name']; ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="logout.php" id="logout.php">Logout</a></strong></p>
	</div> <!--  /tray -->

	<hr class="noscreen" />

	<!-- Menu -->
	<div id="menu" class="box" style="background-color: #213F99 !important;">
		 
		<ul class="box">
			<?php if(isset($_SESSION['Admin_ID'])){?><li <?php if(strstr($_SERVER['REQUEST_URI'],'dashboard') || strstr($_SERVER['REQUEST_URI'],'admin1') || strstr($_SERVER['REQUEST_URI'],'adminchangepassword')){echo 'id="menu-active"';}?>><a href="dashboard.php"><span>Dashboard</span></a></li> <!-- Active -->
			<li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_department')){echo 'id="menu-active"';}?>><a href="manage_department.php"><span>Department</span></a> </li>
                        <li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_subject')){echo 'id="menu-active"';}?>><a href="manage_subject.php"><span>Subject</span></a> </li>	
                        <li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_room')){echo 'id="menu-active"';}?>><a href="manage_room.php"><span>Room</span></a> </li> 
						<li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_faculty')){echo 'id="menu-active"';}?>><a href="manage_faculty.php"><span>Faculty</span></a> </li> 
						<li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_student')){echo 'id="menu-active"';}?>><a href="manage_student.php"><span>Student</span></a> </li>
						<li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_exam')){echo 'id="menu-active"';}?>><a href="manage_exam.php"><span>Exam</span></a> </li> 
			<?php }else if(isset($_SESSION['FACULTY_ID'])){?>
			<li <?php if(strstr($_SERVER['REQUEST_URI'],'manage_marks')){echo 'id="menu-active"';}?>><a href="manage_marks.php"><span>Student Marks</span></a> </li>	
			<?php } else if(isset($_SESSION['FACULTY_ID'])){?>
			<li <?php if(strstr($_SERVER['REQUEST_URI'],'view_marks')){echo 'id="menu-active"';}?>><a href="view_marks.php"><span>View Marks</span></a> </li>	
			<?php } ?>
				</ul>
	</div>