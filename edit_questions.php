<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - تعديل الأسئلة';
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

	echo'<div id="logo">
            <h2>تعديل سؤال: </h2>
            </div>';


	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];


		    require_once (MYSQL);

		   // To prevent the other teachter to edit each other

		$q = "SELECT exam.exam_id FROM exam, question  WHERE (exam.exam_id = question.exam_id AND question.question_id ='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_NUM); // very important to be MYSQLI_NUM notMYSQLI_ASSOC
			$id2 = $row[0]; // This is the exam id that this question is related to.
			mysqli_free_result ($r); // Free up the resources

		require_once (MYSQL);

		$q = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$id2')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

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
	$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE question_id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) == 1)
		{
			$row = mysqli_fetch_array($r, MYSQLI_NUM); // very important MYSQLI_NUM insted of MYSQLI_ASSOC


			echo '<form action="edit_questions.php" method="post">';

			echo '<div class="panel panel-default">
      <div class="panel-heading">ادخل السؤال :</div>
      <div class="panel-body">
	  <div class="form-group">
	  <input type="text" name="question" size="50" value="' . $row[1] . '">
	  </div></div>
    </div>

<div class="panel panel-default">
      <div class="panel-heading">الاجابات:</div>
      <div class="panel-body">
	  <div class="form-group">
	  <input type="text" name="answer1" size="50" value="' . $row[2] . '">
	  </div>
	  <div class="form-group">
 <input type="text" name="answer2" size="50" value="' . $row[3] . '">
      </div>

 <div class="form-group">
 <input type="text" name="answer3" size="50" value="' . $row[4] . '">
 </div>
 <div class="form-group">
 <input type="text" name="answer4" size="50" value="' . $row[5] . '">
 </div>
 </div>
 </div>

<div class="panel panel-danger">
      <div class="panel-heading">الإجابة الصحيحة هي الخيار رقم:</div>
      <div class="panel-body">
';

		if ( $row[6] == 1)
		{
			echo '<input type="radio" name ="correct_answer" value="1" checked > 1 <br>
                  <input type="radio" name ="correct_answer" value="2"> 2 <br>
	              <input type="radio" name ="correct_answer" value="3"  > 3 <br>
                  <input type="radio" name ="correct_answer" value="4"> 4 <br>
                  </div>
                  </div>';
		}
		elseif ( $row[6] == 2)
		{
			echo '<input type="radio" name ="correct_answer" value="1"  > 1 <br>
                  <input type="radio" name ="correct_answer" value="2" checked > 2 <br>
	              <input type="radio" name ="correct_answer" value="3"  > 3 <br>
                  <input type="radio" name ="correct_answer" value="4"> 4 <br>
                  </div>
                  </div>';
		}
		elseif ( $row[6] == 3)
		{
			echo '<input type="radio" name ="correct_answer" value="1"  > 1 <br>
                  <input type="radio" name ="correct_answer" value="2"  > 2 <br>
	              <input type="radio" name ="correct_answer" value="3"  checked> 3 <br>
                  <input type="radio" name ="correct_answer" value="4"> 4 <br>
                  </div>
                  </div>';
		}
		else
		{
			echo '<input type="radio" name ="correct_answer" value="1"  > 1 <br>
                  <input type="radio" name ="correct_answer" value="2"  > 2 <br>
	              <input type="radio" name ="correct_answer" value="3"  > 3 <br>
                  <input type="radio" name ="correct_answer" value="4" checked > 4 <br>
                  </div>
                  </div>';
		}

echo '<br>
      <button type="submit" class="btn btn-primary btn-lg" name="submit">تعديل السوال</button>
	<input type="hidden" name="id" value="' . $id . '" />

</form>
';

mysqli_free_result ($r); // Free up the resources
            }




	}
	}

	 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];



		 require_once (MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$qn = $an1 = $an2 = $an3 = $an4 = FALSE;

	// Check for the question:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['question'])) {
		$qn = mysqli_real_escape_string ($dbc, $trimmed['question']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل السؤال ۔۔</div>';
	}

	// Check for the answer 1:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['answer1'])) {
		$an1= mysqli_real_escape_string ($dbc, $trimmed['answer1']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 1</div>';
	}

	// Check for the answer 2:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['answer2'])) {
		$an2 = mysqli_real_escape_string ($dbc, $trimmed['answer2']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 2</div>';
	}

	// Check for the answer 3:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['answer3'])) {
		$an3 = mysqli_real_escape_string ($dbc, $trimmed['answer3']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 3</div>';
	}

	// Check for the answer 4:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['answer4'])) {
		$an4 = mysqli_real_escape_string ($dbc, $trimmed['answer4']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 4</div>';
	}



	$co = $trimmed['correct_answer'];



	if ($qn && $an1 && $an2 && $an3 && $an4) { // If everything's OK...



			// update the exam to the database:
			$q = "UPDATE question SET question='$qn',answer1='$an1', answer2='$an2', answer3='$an3', answer4='$an4', correct_answer='$co'  WHERE question_id='$id'";

			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.


			    echo '<div class="alert alert-success">تم تعديل البيانات</div>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.


			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية تعديل البيانات </div>';
			}
	}


	else { // No valid ID, stop the script.
           echo '<div class="alert alert-danger">ادخل البيانات بالشكل المطلوب</div>';
          }




	}


	else
	{
		echo '<div class="alert alert-danger">خطأ في نقل البيانات</div>';
	}



?>

</div>
</div>
</div>

<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
