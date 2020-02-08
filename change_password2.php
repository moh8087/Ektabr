<?php # Script 16.11 - change_password.php
// This page allows a logged-in user to change their password.

require_once ('includes/config.inc.php');
$page_title = 'تغيير كلمة المرور';
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
	if (preg_match ('/^(\w){4,20}$/', $_POST['password1']) ) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['password1']);
		} else {
			echo '<div class="alert alert-danger">كلمة المرور غير متطابقة</div>';
		}
	} else {
		echo '<div class="alert alert-danger">ادخل كلمة مرور مناسبة ولا تقل عن 6 أحرف أو أرقام</div>';
	}

	if ($p) { // If everything's OK.

		// Make the query.
		$q = "UPDATE users SET pass=SHA1('$p') WHERE user_id={$_SESSION['user_id']} LIMIT 1";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Send an email, if desired.
			echo '<div class="alert alert-success">تم تعديل كلمة المرور بنجاح</div>';
			mysqli_close($dbc); // Close the database connection.
			include ('includes/footer.html'); // Include the HTML footer.
			exit();

		} else { // If it did not run OK.

			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>';

		}

	} else { // Failed the validation test.
		echo '<div class="alert alert-danger">حاول مرة أخرى</div>';
	}

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>

<div id="logo">
<h3>تغيير كلمة المرور </h3>
 </div>


<div class="container-fluid">
  <form action="change_password.php" method="post" role="form">
      <div class="form-group">
      <label for="pwd">كلمة المرور الجديدة:</label>
      <input type="password" name="password1" class="form-control" id="pwd" placeholder="">
    </div>
    <div class="form-group">
      <label for="pwd">تأكيد كلمة المرور:</label>
      <input type="password" name="password2" class="form-control" id="pwd" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">تآكيد</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>





</div>
</div>

<?php
include ('includes/footer.html');
?>
