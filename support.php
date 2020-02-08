<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - الدعم الفني';
include ('includes/header_teacher.html');

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


			echo '<br>';
			echo '	<div id="logo">
                    <h3> الدعم الفني :  </h3>
                    </div>';

			echo '<br>';

			echo '<center>';

			echo '

			<br>
			 <img class="img-responsive" src="images/support.png" alt=""> 
			<b>البريد الإلكتروني:</b>
			<br>
			info@ektabr.com
			<br>
			<b>رقم الجوال:</b>
			<br>
            00966-568808087
            ';
			
			echo '<br>
			<b>واتس اب - Whatsapp</b>
            <br>
            00966-568808087
            <br>';
            
            
            
			echo'</center>
			';
            





?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
