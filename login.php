<?php # login.php
// This is the login page for the site.

require_once ('includes/config.inc.php');
$page_title = 'تسجيل الدخول';
include ('includes/header_login.html');
?>

<div id="banner-wrapper">
					<div id="banner" class="box container">

<div id="logo">
<h3>تسجيل الدخول </h3>
 </div>


<?php

if (isset($_POST['submitted'])) {
	require_once (MYSQL);

	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<div class="alert alert-danger">نسيت إدخال البريد الإلكتروني</div>';
	}

	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
	} else {
		$p = FALSE;
		echo '<div class="alert alert-danger">ادخل كلمة المرور في الحقل المناسب</div>';
	}

	if ($e && $p) { // If everything's OK.

		// Query the database:
		$q = "SELECT user_id, fullname, email, user_level, membership FROM users WHERE (email='$e' AND pass=SHA1('$p'))";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		// if you want to force users to active thier accounts use this
		// $q = "SELECT user_id, first_name, user_level FROM users WHERE (email='$e' AND pass=SHA1('$p')) AND active IS NULL";


		if (@mysqli_num_rows($r) == 1) { // A match was made.

			// Register the values & redirect:
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC);
			mysqli_free_result($r);
			mysqli_close($dbc);
			//$_SESSION['email'] = $_POST['email'];

			$url = BASE_URL . 'index.php'; // Define the URL:
			ob_end_clean(); // Delete the buffer.
			header("Location: $url");
			exit(); // Quit the script.

		} else { // No match was made.
			echo '<div class="alert alert-danger">اسم المستخدم أو كلمة المرور غير صالحة<div>';
		}

	} else { // If everything wasn't OK.
		echo '<div class="alert alert-danger">الرجاء المحاولة مرة أخرى</div>';
	}

	mysqli_close($dbc);

} // End of SUBMIT conditional.
?>


<div class="container-fluid">
   <form action="login.php" method="post" role="form">
    <div class="form-group">
      <label for="email">البريد الالكتروني:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="">
    </div>
    <div class="form-group">
      <label for="pwd">كلمة المرور:</label>
      <input type="password" name="pass" class="form-control" id="pwd" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">دخول</button>
	<input type="hidden" name="submitted" value="TRUE" />
	<a href="forgot_password.php">    استعادة كلمة المرور</a>
  </form>
</div>



<br>
<br>
<a href="register.php" title="Login"> <img src="images/teacher3.png" alt="" /> تسجيل معلم جديد </a>
<br>
<a href="student_register.php" title="Login"> <img src="images/student3.png" alt="" /> تسجيل طالب جديد </a>








</div>

<?php // Include the HTML footer.
include ('includes/footer.html');
?>
