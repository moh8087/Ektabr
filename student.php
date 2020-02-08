<?php # Script student.php
// This is the cPanle of a student.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'لوحة تحكم الطالب';
include ('includes/header_student.html');

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

	// to access test fast


	 echo'<div id="logo">
			<h3>دخول الاختبار:   </h3>
			</div>

	<br>
	<div class="panel panel-default">
	      <div class="panel-heading">ادخل رمز الاختبار: </div>
	      <div class="panel-body">
		 <form action="doing_test.php" method="post" role="form">
		<div class="form-group">
		<input type="text" name="exam_code" class="form-control"  value="'; if (isset($trimmed['exam_code'])) echo $trimmed['exam_code'];
		echo'">
		<br>
		<button type="submit" class="btn btn-primary btn-md" name="submit">دخول الاختبار</button>
		<input type="hidden" name="submitted" value="TRUE" />


	</form>
		</div>
	    </div>




	</div>';


	require_once (MYSQL);

	// define the user
	$user = $_SESSION['user_id'];


	// Display all teacher's exams
	$q = "SELECT result_id, exam_id, user_id, total_mark, got_mark, end_test from result WHERE user_id='$user' ORDER BY result_id DESC LIMIT 10";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

			echo '<br>';
				echo'<div id="logo">
            <h3>قائمة الاختبارات التي تم  انجازها:  </h3>
            </div>';

			echo '<br>';

			echo '<table class="table table-bordered">
			<tr class="active" >
			<td><b>رقم</b></td>
			<td><b>اسم الاختبار</b></td>
			<td><b>التاريخ</b></td>
			<td><b>عرض النتيجة</b></td>

			</tr>';

			$i=0;

			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			$i++;
			echo '<tr>

			<td>' . $i . '</td>';

			$new_date = date('d/m/Y', strtotime($row['end_test']));

															// to bring the exam name from exam table
															$ex_id = $row['exam_id'];

									$q2 = "SELECT exam_id, exam_name FROM exam WHERE exam_id='$ex_id'";
									$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));


										if (mysqli_num_rows($r2) > 0)
											{
											  $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);

											  $ex_name = $row2['exam_name'];
											  mysqli_free_result ($r2); // Free up the resources

											}




			echo'
			<td>' . $ex_name . '</td>
			<td>' . $new_date . '</td>
			<td><a href="show_result.php?id=' .  $row['exam_id'] . '"><img src="images/result.png" alt="" /></a></td>


			</tr>';
            }

			echo '</table>'; // Close the table
			echo '<a href ="myexams.php">المزيد </a>';
			echo '<br>';
			echo '<br>';

			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			echo '<div class="alert alert-warning">مرحبا ، بإمكانك دخول الاختبار من خلال القائمة أعلاه</div>';
			echo'<div class="panel panel-success">
			<div class="panel-heading">تعليمات:</div>
			<div class="panel-body">لدخول الاختبار يجب عليك الحصول على رمز الاختبار.</div>
			</div>';

		}







?>


</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
