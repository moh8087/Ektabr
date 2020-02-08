<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'لوحة التحكم';
include ('includes/header_teacher.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 1))
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

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

	// Display teacher menu:
	include ('includes/teacher_menu.php');



	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];


	// Display all teacher's exams
	$q = "SELECT exam_id, exam_name, exam_code, created FROM exam WHERE user_id='$u' ORDER BY exam_id DESC LIMIT 10";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{


				echo '<br>';
				echo'<div id="logo">
            <h3>قائمة الاختبارات:  </h3>
            </div>';

			echo '<br>';

			echo '<table class="table table-condensed">
			<tr class="active">
			<td><b>اسم الاختبار</b></td>
			<td><b>رمز الاختبار</b></td>
			<td><b>تاريخه</b></td>
			<td><b>إعدادات الاختبار</b></td>
			<td><b>عرض النتائج</b></td>
			<td><b>حذف الاختبار</b></td>

			</tr>';


			
			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			$new_date = date('d/m/Y', strtotime($row['created']));
			echo '<tr>

			<td><a href="test_control.php?id=' .  $row['exam_id'] . '">' .  $row['exam_name'] . '</a></td>
			<td>' . $row['exam_code'] . '</td>
			<td>' . $new_date . '</td>
			<td><a href="test_control.php?id=' .  $row['exam_id'] . '"><img class="img-responsive" src="images/edit.png" alt="" /></a></td>
			<td><a href="results.php?id=' .  $row['exam_id'] . '"><img class="img-responsive" src="images/result.png" alt="" /></a></td>
			<td><a href="delete_test.php?id=' . $row['exam_id'] . '"><img class="img-responsive" src="images/delete.png" alt="" /></a></td>
			</tr>';

						}

			echo '</table>'; // Close the table
			echo '<a href ="mytest2.php"> المزيد </a>';
			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			  echo '<div class="alert alert-warning">مرحبا ، بإمكانك إنشاء اختبار جديد من القائمة</div>';
				echo'<div class="panel panel-success">
				<div class="panel-heading">تعليمات:</div>
				<div class="panel-body">لنشر الاختبار للطلاب ، قم بإعطائهم رمز أو كود الاختبار فقط</div>
				</div>';

				echo'<center><table>';

				  echo '<tr><td><img class="img-responsive" src="images/create.png" /> </td> ';
					echo '<td></td>';
					echo '<td><img class="img-responsive" src="images/arrows.png"  /></td>';
					echo '<td></td>';
					echo '<td><img class="img-responsive"src="images/addtest.png"  /></td>';
					echo '<td></td>';
					echo '<td><img class="img-responsive" src="images/arrows.png"  /></td>';
					echo '<td><img class="img-responsive" src="images/publish.png"  /></td>';



					echo '<tr ><td><a href="create_test.php">أنشيء اختبار</a> </td> ';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
				  echo '<td>أضف الأسئلة</td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td>انشر الاختبار</td></tr>';

					echo '</table></center>';


		}



?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
