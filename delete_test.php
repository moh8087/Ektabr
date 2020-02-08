<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - حذف اختبار';
include ('includes/header.html');

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

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];

			 require_once (MYSQL);

		   // To prevent the other teachter to edit each other
		$q = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			if (($_SESSION['user_id']) != $row['user_id'] )
			{
				mysqli_free_result ($r); // Free up the resources

				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			}

				else
				{


			echo '<form action="delete_test.php" method="post">';

			echo '<div class="panel panel-danger">
      <div class="panel-heading"> هل تريد حذف الاختبار بالفعل؟</div>
      <div class="panel-body">
	  <input type="radio" name ="active" value="1"  > نعم
     <input type="radio" name ="active" value="2" checked > لا
	 </div>
    </div>
	<br>
    <button type="submit" class="btn btn-danger btn-lg" name="submit">تأكيد</button>
	<input type="hidden" name="id" value="' . $id . '" />


</form>
';


				}

	}

	 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];



		 require_once (MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);






	if ($trimmed['active'] == 1) { // If the choice is OK for delete test...



			// Move it to trash table
			$new_q = "INSERT INTO exam_trash select * from exam where exam_id='$id'";
			$new_r = mysqli_query ($dbc, $new_q) or trigger_error("Query: $new_q\n<br />MySQL Error: " . mysqli_error($dbc));


			if (mysqli_affected_rows($dbc) == 1) {



				// delete the exam to the database:
			$q = "DELETE from exam  WHERE exam_id='$id'";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			     echo '<div class="alert alert-success">تم حذف الاختبار بنجاح</div>';
					 $url = BASE_URL . 'teacher.php'; // Define the URL:
	 				ob_end_clean(); // Delete the buffer.
	 				header("Location: $url");
	 				exit(); // Quit the script.


			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية الحذف </div>';
			}

			 mysqli_free_result ($r); // Free up the resources

			}
	}


	else { // No valid ID, stop the script.
           echo '<div class="alert alert-danger">لم تتم عملية الحذف </div>';
          }




	}


	else
	{
		echo '<div class="alert alert-danger">خطأ في حذف الاختبار </div>';
	}









?>






</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
