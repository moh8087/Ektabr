<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - عرض الأسئلة';
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

	// Display page:



	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];


		   require_once (MYSQL);

		   // To prevent the other teachter to edit each other
		$q = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			echo'<div id="logo">
            <h3>عرض أسئلة اختبار :  ' . $row['exam_name'] . '</h3>
            </div>';



			if (($_SESSION['user_id']) != $row['user_id'] )
			{
				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			}

				else
				{


	// Display all teacher's exams
	$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer FROM question WHERE exam_id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		$questions_count = mysqli_num_rows($r);
	 echo'<br>';
	 echo '<b>عدد الأسئلة : </b> ' . $questions_count . ' ';
	 echo'<br>';

		if ($questions_count > 0)
		{


			$i=0;

			// Fetch and print the records:
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

			$i++;

			echo '<div class="panel-group">
	 <div class="panel panel-default">
		 <div class="panel-heading">
			 <h4 class="panel-title">
				 <a data-toggle="collapse" href="#collapse' . $i . '"><img src="images/down.png" alt="" /> ' . $i . ' . ' . $row['question'] . ' </a>
			 </h4>
		 </div>
		 <div id="collapse' . $i . '" class="panel-collapse collapse">
			 <div class="panel-body">';


			 echo '<div class="table-responsive">
                   <table class="table table-condensed">

			<tr><td><b>الاجابات:</b></td>
			 <tr><td>1. ' . $row['answer1'] . '</td></tr>
			 <tr><td>2. ' . $row['answer2'] . '</td></tr>
			 <tr><td>3. ' . $row['answer3'] . '</td></tr>
			 <tr><td>4. ' . $row['answer4'] . '</td>

			 </tr>';




					 echo '</table></div>'; // Close the table



			echo' </div>
			 <div class="panel-footer">
			 <div class="table-responsive">
									<table>
			<tr>
			<td><a href="edit_questions.php?id=' .  $row['question_id'] . '"><img src="images/edit.png" alt="" /> تعديل السؤال </a></td>
 		 <td><a href="delete_questions.php?id=' . $row['question_id'] . '"><img src="images/delete.png" alt="" /> حذف السؤال </a></td>

			</tr>';

			echo '

				</table></div>

			 </div>
		 </div>
	 </div>
 </div>';



						}




			mysqli_free_result ($r); // Free up the resources
       }

			 else {
			 	echo '<div class="alert alert-danger">لم يتم إضافة أسئلة للاختبار ، بإمكانك إضافة أسئلة عن طريق قائمة اختباراتي</div>';
			 }
	}
	}

	else { // No valid ID, stop the script.
           echo '<p class="error">This page has been accessed in error.</p>';
          }




  // define the exam_id from teacher.php
  //$exam_iddd = $_GET['id'];
  // echo $exam_iddd;






?>




</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
