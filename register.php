<?php
require_once ('includes/config.inc.php');
$page_title = 'تسجيل جديد';
include ('includes/header_login.html');

if (isset($_POST['submitted'])) { // Handle the form.

	require_once (MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$fn = $ln = $e = $p = $phone = FALSE;

	// Check for a first name:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['fullname'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['fullname']);
	} else {
		echo '<div class="alert alert-danger">ادخل الاسم في الحقل المناسب<div>';
	}


	// Check for an email address:
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/', $trimmed['email'])) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<div class="alert alert-danger">ادخل البريد الإلكتروني </div>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{6,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		} else {
			echo '<div class="alert alert-danger">كلمة المرور غير متطابقة</div>';
		}
	} else {
		echo '<div class="alert alert-danger">ادخل كلمة مرور مناسبة ولا تقل عن 6 أحرف أو أرقام</div>';
	}

	// Check for the phone:
	if (!empty ($trimmed['phone'] ) ) // becacuse phone is optional.
	 {
		 if (preg_match ('/^[0-9]{1,}$/', $trimmed['phone'])) {
		$phone = mysqli_real_escape_string ($dbc, $trimmed['phone']);
	}
	else {
		echo '<div class="alert alert-danger">رقم الجوال يجب أن يكون أرقام</div>';

	}

	 }

	else
	{
		$phone = TRUE;

	}
    $membership = "free";



	if ($fn && $e && $p && $phone) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 0) { // Available.

			/*if you want to force users to activation
			// Create the activation code:
			$a = md5(uniqid(rand(), true));
			$q = "INSERT INTO users (email, pass, fullname, active, registration_date) VALUES ('$e', SHA1('$p'), '$fn', '$a', NOW() )";

			*/


			// Add the user to the database:
			$q = "INSERT INTO users (email, pass, fullname, user_level, membership, registration_date, phone) VALUES ('$e', SHA1('$p'), '$fn','1', '$membership', NOW(), '$phone')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Send the email:
				$body = "نشكركم على تسجيلكم في اختبر ";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: info@ektabr.com');

				// Finish the page:
				echo '<div id="banner-wrapper">
									<div id="banner" class="box container">
									<center><div class="alert alert-success">تم التسجيل بنجاح </div>';
				echo '<div id="logo">
				<h3>تسجيل الدخول </h3>
				 </div></center>';

				// put login page
				echo'	<div class="container-fluid">
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
				</div>
				</div>
				</div>';


				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.



				/* to send activation code to the user's email use this code:
				// Send the email:
				$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');

				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				*/




			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية التسجيل لوجود مشكلة بالنظام .. نأسف</div>';
				//echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}

		} else { // The email address is not available.
			echo '<div class="alert alert-danger">البريد الإلكتروني المدخل موجود مسبقاً ، الرجاء الضغط على نسيت كلمة المرور لاسترجاعها</div>';
				}

	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">أعد كتابة كلمة المرور مرة أخرى</div>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>

<div id="banner-wrapper">
					<div id="banner" class="box container">

<div id="logo">
<h3>تسجيل حساب معلم جديد:   </h3>
 </div>



<div class="container-fluid">
   <form form action="register.php" method="post" role="form">
    <div class="form-group">
      <label for="text">الاسم:</label>
      <input type="text" name="fullname" class="form-control" id="usr" placeholder="" value="<?php if (isset($trimmed['fullname'])) echo $trimmed['fullname']; ?>">
    </div>
	<div class="form-group">
      <label for="email">البريد الالكتروني:</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>">
    </div>
    <div class="form-group">
      <label for="pwd">ادخل كلمة المرور:</label>
      <input type="password" name="password1" class="form-control" id="pwd" placeholder="">
    </div>
	<div class="form-group">
      <label for="pwd">إعادة كلمة المرور:</label>
      <input type="password" name="password2" class="form-control" id="pwd" placeholder="">
    </div>

	<div class="form-group">
      <label for="text">رقم الجوال ( اختياري ) :</label>
      <input type="text"  name="phone" class="form-control" value="<?php if (isset($trimmed['phone'])) echo $trimmed['phone']; ?>" />
    </div>


    <button type="submit" class="btn btn-primary btn-lg">تسجيل</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>







<a href="login.php" title="Login"> هل تملك حساب ؟ تسجيل الدخول </a><br /></center>



</div>

</div>
</div>

<?php // Include the HTML footer.
include ('includes/footer.html');
?>
