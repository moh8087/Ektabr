<?php # Script create_test.php
// to create a new test

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'دخول الاختبار';
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

	echo '<p><h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1></p>';


if (($_SESSION['user_level'] == 1)) // if he is a teacher
{
	// Display teacher menu:
	include ('includes/teacher_menu.php');
}
else {   // if he is a student

	// Display teacher menu:
	include ('includes/student_menu.php');
}


if (isset($_POST['submitted'])) { // Handle the form.

	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$ec = FALSE;

	// Check for the exam code:
	if (!empty ($trimmed['exam_code'] ) )
	 {

		$ec = mysqli_real_escape_string ($dbc, $trimmed['exam_code']);
		$ec = trim($ec);
    $ec = htmlspecialchars($ec);
	} else {
		echo '<div class="alert alert-danger"> ادخل رمز الاختبار</div>';

	}




	if ($ec) { // If everything's OK...

		// Make sure the exam code is existing:
		$q = "SELECT exam_id FROM exam WHERE exam_code='$ec'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 1) { // existing.


		 $_SESSION['exam_code2'] = $ec;


			$url = BASE_URL . 'start_test.php'; // Define the URL:
			ob_end_clean(); // Delete the buffer.
			header("Location: $url");
			exit(); // Quit the script.

		} else { // The exam code is not available.
				echo '<div class="alert alert-danger">لا يوحد اختبار لهذا الرمز ، الرجاء تآكد من رمز الاختبار </div>';

		}

	} else { // If one of the data tests failed.
			echo '<div class="alert alert-danger">ادخل رمز الاختبار بشكل صحيح</div>';

	}

	mysqli_close($dbc);

} // End of the main Submit conditional.









?>

<ol class="breadcrumb" style="margin-bottom: 5px;">
<li class="active"><a href="doing_test.php">ادخال رمز الاختبار</a></li>
<li>تعليمات الاختبار</li>
<li>عمل الاختبار</li>
<li>النتيجة</li>
</ol>
<br>

<form action="doing_test.php" method="post" role="form">

	<div class="panel panel-default">
	      <div class="panel-heading">ادخل رمز أو كود الاختبار :</div>
	      <div class="panel-body">
		 <form action="doing_test.php" method="post" role="form">
		<div class="form-group">
		<input type="text" name="exam_code" class="form-control"  value="<?php if (isset($trimmed['exam_code'])) echo $trimmed['exam_code']; ?>">
		<br>
		<button type="submit" class="btn btn-primary btn-md" name="submit">دخول الاختبار</button>
		<input type="hidden" name="submitted" value="TRUE" />


</form>




</div>
</div>
</div>



<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
