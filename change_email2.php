<?php
// This page allows a logged-in user to change their email .

require_once ('includes/config.inc.php');
$page_title = 'تغيير الايميل';
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

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';



	// Display teacher menu:
	include ('includes/student_menu.php');







if (isset($_POST['submitted'])) {
	require_once (MYSQL);

	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $_POST['email'])) {
		if ($_POST['email'] == $_POST['email2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['email']);
		} else {
			echo '<div class="alert alert-danger">البريد الإلكتروني غير متطابق</div>';
		}
	} else {
		echo '<div class="alert alert-danger">ادخل كلمة بريد إلكتروني مناسب</div>';
	}

	if ($p) { // If everything's OK.

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$p'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 0) { // Available.


		// Make the query.
		$q = "UPDATE users SET email='$p' WHERE user_id={$_SESSION['user_id']} LIMIT 1";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email, if desired.
			echo '<div class="alert alert-success">تم تعديل البريد الإلكتروني بنجاح</div>';
			mysqli_close($dbc); // Close the database connection.
			include ('includes/footer.html'); // Include the HTML footer.
			exit();

		} else { // If it did not run OK.

			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>';

		}

	}
	else {
		 echo '<div class="alert alert-danger">البريد الإلكتروني موجود مسبقاً</div>';
	}








	} else { // Failed the validation test.
		echo '<div class="alert alert-danger">حاول مرة أخرى</div>';
	}

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>

<div id="logo">
<h3>تغيير البريد الإلكتروني: </h3>
 </div>


<div class="container-fluid">
  <form action="change_email.php" method="post" role="form">
      <div class="form-group">
      <label for="pwd">البريد الإلكتروني الجديد:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="">
    </div>
    <div class="form-group">
      <label for="pwd">تأكيد البريد الإلكتروني:</label>
      <input type="email" name="email2" class="form-control" id="pwd" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">تغيير</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>





</div>
</div>

<?php
include ('includes/footer.html');
?>
