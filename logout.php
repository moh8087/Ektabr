<?php # Script 16.9 - logout.php
// This is the logout page for the site.

require_once ('includes/config.inc.php'); 
$page_title = 'Logout';
include ('includes/header.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname'])) {

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
} else { // Log out the user.

	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie (session_name(), '', time()-300); // Destroy the cookie.

}

// Print a customized message:
echo '<center><h1>تم تسجيل الخروج بنجاح</h1>';
echo '<a href="login.php" title="Login"><h1> لاعادة تسجيل الدخول اضغط هنا</h1></a><br /></center>';

$url = BASE_URL . 'login.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

include ('includes/footer.html');
?>
