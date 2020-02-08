<?php # Script 16.10 - forgot_password.php
// This page allows a user to reset their password, if forgotten.

require_once ('includes/config.inc.php'); 
$page_title = 'استعادة كلمة المرور';
include ('includes/header.html');

if (isset($_POST['submitted'])) {
	require_once (MYSQL);

	// Assume nothing:
	$uid = FALSE;

	// Validate the email address...
	if (!empty($_POST['email'])) {
	
		// Check for the existence of that email address...
		$q = 'SELECT user_id FROM users WHERE email="'.  mysqli_real_escape_string ($dbc, $_POST['email']) . '"';
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM); 
		} else { // No database match made.
			echo '<p class="error">البريد الإلكتروني المدخل غير موجود</p>';
		}
		
	} else { // No email!
		echo '<p class="error">الرجاء ادخل البريد الإلكتروني </p>';
	} // End of empty($_POST['email']) IF.
	
	if ($uid) { // If everything's OK.

		// Create a new, random password:
		$p = substr ( md5(uniqid(rand(), true)), 3, 6); 

		// Update the database:
		$q = "UPDATE users SET pass=SHA1('$p') WHERE user_id=$uid LIMIT 1";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Send an email:
			$body = "new password is :  ";
            $body .= " $p ";
            
			mail ($_POST['email'], 'استعادة كلمة المرور في اختبر', $body, 'From: moh8087@hotmail.com');
			
			// Print a message and wrap up:
			echo '<center><div class="alert alert-success">تم إرسال كلمة المرور لبريدك الإلكتروني</div></center>';
			
			mysqli_close($dbc);
			include ('includes/footer.html');
			exit(); // Stop the script.
			
		} else { // If it did not run OK.
			echo '<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
		}

	} else { // Failed the validation test.
		echo '<p class="error">Please try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.

?>
<div id="banner-wrapper">
					<div id="banner" class="box container">

<div id="logo">
<h3>استعادة كلمة المرور </h3>
 </div>
 


<div id="login-form">
<form action="forgot_password.php" method="post" role="form">

<div class="form-group">
      <label for="email">ادخل البريد الالكتروني:</label>
      <input type="text" name="email" class="form-control" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
    </div> 

<button type="submit" name="submit" class="btn btn-primary btn-lg" >استعادة كلمة المرور</button>
	<input type="hidden" name="submitted" value="TRUE" />

</form>
</div>

</div>
</div>
<?php
include ('includes/footer.html');
?>
