<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختباراتي';
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

	if (!isset($_GET['page']))
	{
		$page = 1;
	}
	else
	{
		$page = (int) $_GET['page'];
	}

	// define the user
	$u = $_SESSION['user_id'];


	$questions_at_page = 20;

	$q = "SELECT exam_id, exam_name, exam_code, created FROM exam WHERE user_id='$u'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	$questions_count = mysqli_num_rows($r);
	@mysqli_free_result($r);

	$pages_count = (int)ceil ($questions_count / $questions_at_page );

	if (($page > $pages_count) || ($page <=0))
	{
		mysqli_close($dbc);
		die('لا يوجد المزيد من السجلات');
	}

	$start = ($page - 1 ) * $questions_at_page;
	$end = $questions_at_page;

	if ($questions_count !=0)
	{
		$q = "SELECT exam_id, exam_name, exam_code, created FROM exam WHERE user_id='$u' ORDER BY exam_id DESC LIMIT $start,$end";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0 )
		{
			echo '<br>';
			echo'<div id="logo">
            <h3>قائمة الاختبارات التي أنشأتها :  </h3>
            </div>';

			echo '<br>';

			echo '
            <table class="table">
			<tr class="active">
			<td><b>رقم</b></td>
			<td><b>اسم الاختبار</b></td>
			<td><b>رمز الاختبار</b></td>
			<td><b>تاريخه</b></td>
			<td><b>نشر الاختبار</b></td>
			<td><b>عرض النتائج</b></td>
			<td><b>إعدادات الاختبار</b></td>
			<td><b>إضافة أسئلة</b></td>
			<td><b>عرض الأسئلة</b></td>
			<td><b>حذف الاختبار</b></td>

			</tr>';

			$i=0;

			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			$i++;

			$new_date = date('d/m/Y', strtotime($row['created']));
			echo '<tr>

			<td>' . $i . '</td>
			<td><a href="test_control.php?id=' .  $row['exam_id'] . '">' .  $row['exam_name'] . '</a></td>
			<td>' . $row['exam_code'] . '</td>
			<td>' . $new_date . '</td>
			<td><a href="test_control.php?id=' .  $row['exam_id'] . '"><img src="images/link.png" alt="" /></a></td>
			<td><a href="results.php?id=' .  $row['exam_id'] . '"><img src="images/result.png" alt="" /></a></td>
			<td><a href="edit_test.php?id=' .  $row['exam_id'] . '"><img src="images/edit.png" alt="" /></a></td>
			<td><a href="add_question2.php?id=' .  $row['exam_id'] . '"><img src="images/add.png" alt="" /></a></td>
			<td><a href="show_questions.php?id=' .  $row['exam_id'] . '"><img src="images/edit2.png" alt="" /></a></td>
			<td><a href="delete_test.php?id=' . $row['exam_id'] . '"><img src="images/delete.png" alt="" /></a></td>
			</tr>';

            }

			echo '</table>'; // Close the table

		}

		else
		{
			echo '<p class="error">لا يوجد سجلات</p>';
		}


mysqli_free_result ($r); // Free up the resources
		}


$next = $page + 1;
$prev = $page -1;

if ($next <= $pages_count)
echo '<a href ="mytest.php?page=' . $next . '"> التالي </a>';

	 if (($next <= $pages_count) && ($prev > 0) )
	   echo ' - ';

if ($prev > 0 )
	echo '<a href ="mytest.php?page=' . $prev . '"> السابق </a>';

mysqli_close($dbc);







?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
