<?php ob_start(); 
session_start();
include("config/db.php"); 
if(!isset($_SESSION['Admin_ID'])){
	header("location:index.php");
}

	$tableName = "exam";
	$tableId = "exam_id";
	$targetpage = "manage_exam.php";
	$limit = 10; 

	$searchcriteria = "";
	$searchtext = empty($_GET['searchtext']) ? '' : trim($_GET['searchtext']);
	$searchcat = empty($_GET['searchcat']) ? '' : trim($_GET['searchcat']);
	if($searchtext != '' && $searchcat != ''){
		$searchcriteria = " where lower(".$searchcat.") like lower('%".$searchtext."%')";
	}
	
	$query = "";
	if($searchcriteria == '') {
		$query = "SELECT COUNT(*) as num FROM $tableName";
	} else {
		$query = "SELECT COUNT(*) as num FROM $tableName $searchcriteria"; }
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];

	$stages = 3;
	$page = empty($_GET['page']) ? 0 : mysql_real_escape_string($_GET['page']);
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
	$query1 = "";
	// Get page data
	if($searchcriteria == '') {
		$query1 = "SELECT * FROM $tableName order by exam_date LIMIT $start, $limit";
	} else {
		$query1 = "SELECT * FROM $tableName $searchcriteria  order by exam_date LIMIT $start, $limit";
	}
	$result = mysql_query($query1) or die(mysql_error());
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1){
			if($searchtext != '' && $searchcat != '')
				$paginate.= "<a href='$targetpage?page=$prev&searchtext=$searchtext&searchcat=$searchcat'>previous</a>";
			else
				$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
		}else{
			$paginate.= "<span class='disabled'>previous</span>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					if($searchtext != '' && $searchcat != '')
						$paginate.= "<a href='$targetpage?page=$counter&searchtext=$searchtext&searchcat=$searchcat'>$counter</a>";
					else
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
				}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						if($searchtext != '' && $searchcat != '')
							$paginate.= "<a href='$targetpage?page=$counter&searchtext=$searchtext&searchcat=$searchcat'>$counter</a>";
						else
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
					}
				}
				$paginate.= "...";
				if($searchtext != '' && $searchcat != '') {
					$paginate.= "<a href='$targetpage?page=$LastPagem1&searchtext=$searchtext&searchcat=$searchcat'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage&searchtext=$searchtext&searchcat=$searchcat'>$lastpage</a>";
				} else {
					$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
				}
			}
			else if($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) 
			{ // Middle hide some front and some back
				if($searchtext != '' && $searchcat != '') {
					$paginate.= "<a href='$targetpage?page=1&searchtext=$searchtext&searchcat=$searchcat'>1</a>";
					$paginate.= "<a href='$targetpage?page=2&searchtext=$searchtext&searchcat=$searchcat'>2</a>";
				} else {
					$paginate.= "<a href='$targetpage?page=1'>1</a>";
					$paginate.= "<a href='$targetpage?page=2'>2</a>";
				}

				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						if($searchtext != '' && $searchcat != '')
							$paginate.= "<a href='$targetpage?page=$counter&searchtext=$searchtext&searchcat=$searchcat'>$counter</a>";
						else
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
					}					
				}

				$paginate.= "...";
				if($searchtext != '' && $searchcat != '') {
					$paginate.= "<a href='$targetpage?page=$LastPagem1&searchtext=$searchtext&searchcat=$searchcat'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage&searchtext=$searchtext&searchcat=$searchcat'>$lastpage</a>";		
				} else {
					$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
					$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";	
				}
			}
			else // End only hide early pages
			{
				if($searchtext != '' && $searchcat != '') {
					$paginate.= "<a href='$targetpage?page=1&searchtext=$searchtext&searchcat=$searchcat'>1</a>";
					$paginate.= "<a href='$targetpage?page=2&searchtext=$searchtext&searchcat=$searchcat'>2</a>";
				} else {
					$paginate.= "<a href='$targetpage?page=1'>1</a>";
					$paginate.= "<a href='$targetpage?page=2'>2</a>";
				}
				
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						if($searchtext != '' && $searchcat != '')
							$paginate.= "<a href='$targetpage?page=$counter&searchtext=$searchtext&searchcat=$searchcat'>$counter</a>";
						else
							$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";
					}					
				}
			}
		}
					
		// Next
		if ($page < $counter - 1){ 
			if($searchtext != '' && $searchcat != '')
				$paginate.= "<a href='$targetpage?page=$next&searchtext=$searchtext&searchcat=$searchcat'>next</a>";
			else
				$paginate.= "<a href='$targetpage?page=$next'>next</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span>";
			}
			
		$paginate.= "</div>";		
}
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

			<h1>Exam</h1>
           
		  <!-- Form -->			
			     <fieldset style="padding:20px;">
				<legend> <span class="headbox">Manage Exam</span></legend>
                  
               <div class="divshow">
                
             
               <table align="center" width="100%">
					<tr>
					 <td class="rd1">
					Total <b><?=$total_pages;?> </b> Records Found
					</td> 
<td><a href="exam.php">Add Exam</a></td>
					</tr>
  
				</table>

 
            	<table align="center" style="padding:1px;" width="100%">
				<tr>
				    <th width="5%">S.No.</th> 
                    <th width="15%">Date</th>	 
					<th width="15%">Semester</th>
						<th width="10%">Subject Code
						</th>
					<th width="15%">Timing</th>	 
					<th width="15%">Action</th>
              
				</tr> 	 	
				<?php $i=1; $j=1; $k=0; while($data =mysql_fetch_array($result)){?>
                <tr class="<?php if($i%2==1){echo "bg";} ?>">
				    <td><?php echo ++$start;?>.</td> 
                    <td><?php echo $data['exam_date']; ?> </td> 
                    <td><?php echo $data['semester']; ?> </td> 
					<td><?php echo $data['semester'].'0'.$data['subject_code']; ?> </td> 
					<td><?php echo $data['timing']; ?> </td> 
					 <td><a href="seat-manage.php?exam_id=<?php echo $data['exam_id']; ?>">Arrange Seat</td>
				</tr>
                <?php $i++; } ?>
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