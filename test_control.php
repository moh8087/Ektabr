<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - تفاصيل الاختبار';
include ('includes/header.html');

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




	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];


		   require_once (MYSQL);



		// To prevent the other teachter to edit each other
		$q = "SELECT exam_id, user_id, exam_name, exam_code, created, active FROM exam WHERE (exam_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			if (($_SESSION['user_id']) != $row['user_id'] )
			{
				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			}

				else
				{


			echo '<br>';
			echo'<div id="logo">
					<h3>تفاصيل الاختبار: </h3>
					</div>';

		echo '<br>';



								$new_date = date('d/m/Y', strtotime($row['created']));
								$test_link = BASE_URL . 'start_test_online.php?id=' .  $row['exam_code'] . '';

								echo '<div class="table-responsive">
												 <table class="table table-bordered">
												 <tr><td><b>اسم الاختبار:   </b></td><td>' . $row['exam_name'] . '</td></tr>
												 <tr><td><b>رمز الاختبار :  </b></td><td>' . $row['exam_code'] . '</td></tr>
												 <tr><td><b>تاريخه: </b></td><td>' . $new_date . ' </td></tr>
												 <tr><td><b>رابط الاختبار: </b></td><td> <input type="text" name="test_link" class="form-control input-sm" value="' . $test_link . '"></td></tr>
												 <tr><td><b>معاينة الاختبار : </b></td><td> <a href="' . $test_link . '">معاينة وتجربة الاختبار</a> </td></tr>

												 ';




										echo '</table></div>'; // Close the table


		echo '<div class="table-responsive">
  					<table class="table">
		<tr>
		<td><b><img src="images/result.png" alt="" /></b></td>
		<td><b><img src="images/edit.png" alt="" /></b></td>
		<td><b><img src="images/add.png" alt="" /></b></td>
		<td><b><img src="images/edit2.png" alt="" /></b></td>
		<td><b><img src="images/delete.png" alt="" /></b></td>
		</tr>';

		echo '<tr>

		<td><a href="results.php?id=' .  $row['exam_id'] . '">عرض النتائج</a></td>
		<td><a href="edit_test.php?id=' .  $row['exam_id'] . '">تعديل الاختبار</a></td>
		<td><a href="add_question2.php?id=' .  $row['exam_id'] . '">إضافة أسئلة</a></td>
		<td><a href="show_questions.php?id=' .  $row['exam_id'] . '">عرض الأسئلة</a></td>
		<td><a href="delete_test.php?id=' . $row['exam_id'] . '">حذف الاختبار</a></td>
		</tr>';


			echo '</table></div>'; // Close the table


		mysqli_free_result ($r); // Free up the resources




	}
	}


	else
	{
		echo '<p class="error">لا يوجد اختبار لعرضه</p>';
	}



echo'<div class="panel panel-success">
				<div class="panel-heading">تعليمات:</div>
				<div class="panel-body">لنشر الاختبار للطلاب ، قم بإعطائهم رمز أو كود الاختبار فقط</div>
				</div>';





?>






</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
