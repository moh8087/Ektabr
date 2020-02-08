<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'لوحة تحكم الطالب';
include ('includes/header_student.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']))
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
if (($_SESSION['user_level'] == 1)) // if he is a teacher
{
	// Display teacher menu:
	include ('includes/teacher_menu.php');
}
else {   // if he is a student

	// Display teacher menu:
	include ('includes/student_menu.php');
}


	require_once (MYSQL);

	// define the user
	$user = $_SESSION['user_id'];


	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From student.php
           $id = $_GET['id'];


		   require_once (MYSQL);


		$show_result = 1;





									$q2 = "SELECT exam_id, exam_name, show_result FROM exam WHERE exam_id='$id'";
									$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));


										if (mysqli_num_rows($r2) > 0)
											{
											  $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);

											  $ex_name = $row2['exam_name'];
												$show_result = $row2['show_result'];
											  mysqli_free_result ($r2); // Free up the resources

											}



if ( $show_result == 1 )
{ // 300

	// Display all teacher's exams
	$q = "SELECT result_id, exam_id, user_id, total_mark, got_mark from result WHERE exam_id='$id'  AND user_id='$user' ";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

			echo '<br>';
				echo'<div id="logo">
            <h3>نتيجة اختبار:</h3>
            </div>';

			echo '<br>';

			echo '<div class="table-responsive">
                  <table class="table table-striped">
			<tr class="success">
			<td style="font-weight:bold;color:green;">اسم الاختبار</td>
			<td style="font-weight:bold;color:green;">درجتك المكتسبة</td>
			<td style="font-weight:bold;color:green;">من</td>
			<td style="font-weight:bold;color:green;">النسبة</td>

			</tr>';

			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			$total_mark = $row['total_mark'];
			$got_mark = $row['got_mark'];
			$per = ($got_mark/$total_mark) * 100;
			$per2 = round($per, 2);

			echo '<tr>

			<td>' . $ex_name . '</td>
			<td style="font-weight:bold;color:green;">' . $got_mark . '</td>
			<td>' . $total_mark . '</td>
			<td>' . $per2 . ' %</td>

			</tr>';


			echo '</table></div>'; // Close the table

					 echo'<div class="progress">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' . $per2 . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $per2 . '%">
      ' . $per2 . ' %
    </div>
  </div>';


			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			echo '<div class="alert alert-warning">لا توجد نتيجة لعرضها</div>';

		}

} // 300

else {
	echo '<div class="alert alert-danger">لا يمكن عرض النتيجة حالياً ، للحصول على النتيجة راجع المسؤول عن الاختبار</div>';
}




	}

		else{

			echo '<div class="alert alert-danger">لا يوجد نتيجة لعرضها</div>';
		}







?>

</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
