<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'لوحة تحكم الطالب';
include ('includes/header.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 2))  
{ 
	
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}



?>

<div class="container-fluid">
<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";
	
echo '</h1>';

// Display teacher menu:
	include ('includes/student_menu.php'); 
	
	
	require_once (MYSQL);
	
	// define the user
	$user = $_SESSION['user_id'];
	
	
	// Display all teacher's exams
	$q = "SELECT result_id, exam_id, user_id, total_mark, got_mark from result WHERE user_id='$user' ORDER BY result_id DESC LIMIT 10";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		
		if (mysqli_num_rows($r) > 0)
		{
			
			echo '<br>';
				echo'<div id="logo">
            <h3>قائمة الاختبارات التي تم  انجازها:  </h3>
            </div>';

			echo '<br>';
			
			echo '<div class="table-responsive">          
                  <table class="table table-hover"> 
			<tr style="border-bottom:1pt solid gray;">
			<td><b>رقم</b></td>
			<td><b>رقم الاختبار</b></td>
			<td><b>الدرجة المكتسبة</b></td>
			<td><b>الدرجة الكلية</b></td>
			<td><b>النسبة</b></td>
			
			</tr>';
			
			$i=0;
			
			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			
			$i++;
			echo '<tr style="border-bottom:1pt solid gray;">
			
			<td>' . $i . '</td>
			<td>' . $row['exam_id'] . '</td>
			<td>' . $row['got_mark'] . '</td>
			<td>' . $row['total_mark'] . '</td>
			<td> </td>
			
			</tr>';
            }
			
			echo '</table></div>'; // Close the table
			echo '<a href ="myexams.php"> المزيد </a>';
			mysqli_free_result ($r); // Free up the resources
		}
		
		else
		{
			echo '<div class="alert alert-warning">مرحبا ، بإمكانك دخول الاختبار من خلال القائمة أعلاه</div>';
			
		}
	
	
	
	

	

?>

</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
