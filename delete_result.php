<?php
// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - حذف نتيجة طالب';
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

	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From result.php
           $id = $_GET['id'];

			 require_once (MYSQL);

		 // To prevent the other teachter to delete other student's results
		$q = "SELECT result_id, exam_id, user_id FROM result WHERE (result_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_num_rows($r) > 0) {

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			$exam_idd = $row['exam_id']; // to identify the exam id
			$student_id = $row['user_id']; // to identify the student user id


			}
			else{
				echo '<div class="alert alert-danger">لا توجد نتيجة بهذا الرقم</div>';

			}

			mysqli_free_result ($r); // Free up the resources



			// To prevent the other teachter to delete other student's results
		$q2 = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$exam_idd')";
		$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));

			$row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);

			if (($_SESSION['user_id']) != $row2['user_id'] )
			{

				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			}

				else
				{


			echo '<form action="delete_result.php" method="post">';

			echo '<div class="panel panel-danger">
      <div class="panel-heading"> هل تريد حذف نتيجة الطالب بالفعل؟</div>
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

		  // To prevent the other teachter to delete other student's results
		$q = "SELECT result_id, exam_id, user_id FROM result WHERE (result_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_num_rows($r) > 0) {

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			$exam_idd = $row['exam_id']; // to identify the exam id
			$student_id = $row['user_id']; // to identify the student user id


			}
			else{
				echo '<div class="alert alert-danger">لا توجد نتيجة بهذا الرقم</div>';

			}

			mysqli_free_result ($r); // Free up the resources



	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);






	if ($trimmed['active'] == 1) { // If the choice is OK for delete test...



			// Move it to trash table
			$new_q = "INSERT INTO result_trash select * from result where result_id='$id'";
			$new_r = mysqli_query ($dbc, $new_q) or trigger_error("Query: $new_q\n<br />MySQL Error: " . mysqli_error($dbc));


			if (mysqli_affected_rows($dbc) == 1) {



				// delete the exam to the database:
			$q = "DELETE from result  WHERE result_id='$id'";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.


				//echo '<div class="alert alert-success">تم حذف النتيجة بنجاح</div>';




			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية الحذف </div>';
			}

			}


			// require_once (MYSQL);

		// Move it to trash table from answer table as well
			$new_q2 = "INSERT INTO answer_trash select * from answer WHERE (exam_id='$exam_idd' AND user_id='$student_id')";
			$new_r2 = mysqli_query ($dbc, $new_q2) or trigger_error("Query: $new_q2\n<br />MySQL Error: " . mysqli_error($dbc));


			if (mysqli_affected_rows($dbc) > 0) {



				// delete the exam to the database:
			$q4 = "DELETE from answer  WHERE (exam_id='$exam_idd' AND user_id='$student_id')";
			$r4 = mysqli_query ($dbc, $q4) or trigger_error("Query: $q4\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) > 0) { // If it ran OK.


				echo '<div class="alert alert-success">تم حذف النتيجة بنجاح</div>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.


			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية الحذف </div>';
			}
			mysqli_free_result ($r4); // Free up the resources
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
