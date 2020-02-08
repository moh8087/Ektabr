<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - الملف الشخصي';
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

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

	// Display teacher menu:
	include ('includes/student_menu.php');



	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];


	// Display all teacher's exams
	$q = "SELECT user_id, fullname, email, registration_date, phone  FROM users WHERE user_id='$u'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{

			echo '<br>';
			echo '	<div id="logo">
                    <h3> المعلومات الشخصية الخاصة بي :  </h3>
                    </div>';

			echo '<br>';

			echo '<center>';



			// Fetch and print the records:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);



			echo '

			<br>
			 <img class="img-responsive" src="images/photo.png" alt="">
			 <br>
			 <b>الاسم:</b>
			 <br>
			 ' . $row['fullname'] . '
			 <br>
			<b>البريد الإلكتروني:</b>
			<br>
			' . $row['email'] . '
			<br>
			<a href="change_email.php">تغيير البريد الإلكتروني</a>
			<br>
			<b>كلمة المرور:</b>
			<br>
			<a href="change_password.php">تغيير كلمة المرور</a>
			<br>
			<b>رقم الجوال:</b>
			<br>';

			if (empty ($row['phone'] ) )
			{
				echo '<a href="change_phone2.php">إضافة رقم الجوال</a>';
			}
			else{
				echo '' . $row['phone'] . ' ';

			}

			echo '<br>
			<a href="change_phone2.php">تعديل رقم الجوال</a>
			<br>
			</center>
			';

			mysqli_free_result ($r); // Free up the resources
		}

		else
		{
			echo '<div class="alert alert-danger">لم يتم العثور على بيانات</div>';
		}




?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
