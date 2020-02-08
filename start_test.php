<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - بدء الاختبار';
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

// Welcome the user (by name if they are logged in):
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


	// to set up all privivous variable to 0
	unset($_SESSION['start_test']);
		unset($_SESSION['time_remaining']);
		unset($_SESSION['time_limit']);



	require_once (MYSQL);

	// define the user
	$ec = $_SESSION['exam_code2'];


	// Display all teacher's exams
	$q = "SELECT exam_id, exam_name, exam_code, description, active, time_limit FROM exam WHERE exam_code='$ec'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) == 1)
		{ // 100

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

		// to make sure the exam is active

		if ( $row['active'] == 1 )

		{ // 200

		// to define exam id by identfied exam code
			$exam_id= $row['exam_id'];

			 // define the user
	       $user = $_SESSION['user_id'];
			 // define Time duration
			 		$time_duration = $row['time_limit'];
				// to use this time in real_test.php
				$_SESSION['time_limit'] = $time_duration;


				$q3= "SELECT answer_id, exam_id, question_id, user_id, selected_answer, correct_answer from answer WHERE (exam_id='$exam_id' AND user_id='$user')";
				$r3 = mysqli_query ($dbc, $q3) or trigger_error("Query: $q3\n<br />MySQL Error: " . mysqli_error($dbc));


				if (mysqli_num_rows($r3) <= 0 )
				{



					// new query to identify the number of quetions in this exam
			$q2 = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$exam_id'";
         	$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	        $questions_count = mysqli_num_rows($r2);
	        @mysqli_free_result($r2);




			echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li class="active"><a href="doing_test.php">ادخال رمز الاختبار</a></li>
			<li class="active"><a href="start_test.php">تعليمات الاختبار</a></li>
			<li>عمل الاختبار</li>
			<li>النتيجة</li>
			</ol>
			<br>';


echo '<br>';
			echo'<div id="logo">
            <h3>معلومات الاختبار:  </h3>
            </div>';

			echo '<br>';

			echo '<div class="table-responsive">
                  <table class="table table-hover">
			<tr>
			<td><b>اسم الاختبار: </b> ' . $row['exam_name'] . '</td></tr>
			<tr><td><b>عدد الأسئلة: </b>' . $questions_count . '</td></tr>
			<tr><td><b>مدة الاختبار: </b>' . $time_duration . ' دقيقة</td></tr>
			<tr><td><b>معلومات الاختبار:</b></td></tr>
			<tr><td><textarea disabled name="description" rows="5" cols="50" >' . $row['description'] . '</textarea></td></tr>

			<tr><td><b><a href="real_test.php">بدء الاختبار</a></b></td></tr>';
			echo '</table></div>'; // Close the table

			// identfiing the exam id
			$_SESSION['exam_id2']= $row['exam_id'];


			mysqli_free_result ($r); // Free up the resources




				}

				else
				{
					echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li class="active"><a href="doing_test.php">ادخال رمز الاختبار</a></li>
			<li class="active"><a href="start_test.php">تعليمات الاختبار</a></li>
			<li>عمل الاختبار</li>
			<li>النتيجة</li>
			</ol>
			<br>';



			echo '<div class="alert alert-danger">تم دخول هذا الاختبار مسبقاً ولا يمكن الدخول مرة أخرى</div>';
					echo '<div class="alert alert-danger">إذا كنت ترغب بدخول الاختبار مرة أخرى ، الرجاء التحدث مع أستاذ المقرر لحذف النتيجة السابقة</div>';

					mysqli_free_result ($r3); // Free up the resources

				}

			} // 200


				else // 200
				{
					echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li class="active"><a href="doing_test.php">ادخال رمز الاختبار</a></li>
			<li class="active"><a href="start_test.php">تعليمات الاختبار</a></li>
			<li>عمل الاختبار</li>
			<li>النتيجة</li>
			</ol>
			<br>';


					echo '<div class="alert alert-danger">الاختبار غير مفعل حالياً</div>';
				}





			} // 100
			else
			{
				echo "لا يوجد اختبار";
			}





?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
