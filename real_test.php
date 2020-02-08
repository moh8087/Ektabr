<?php

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - الاختبار الفعلي';
include ('includes/header.html');



	// to identify exam id first of all:
		$eid = $_SESSION['exam_id2'];




// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']))
{

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}

if (!isset($_SESSION['exam_id2']))  // To prevent student to come here without knowing what is the exam id that we obtain from start_test.php
{

	echo '<div class="alert alert-danger">لا يمكن دخول هذه الصفحة</div>';
	$url = BASE_URL . 'student.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}

// to set the start date and time
if (!isset($_SESSION['start_test']))
{

	$_SESSION['start_test'] = date("Y-m-d H:i:s");

}



// to set the countdown Timer : /////////////////////////////////////////////////////////////////////////////////////////////////



 if (!isset($_SESSION['time_remaining'])) {

		 $time = time();

					$_SESSION['time_started'] = $time;
			  	$time_duration = $_SESSION['time_limit'] ;

					$m = $time_duration * 60; // convert to seconds
					$_SESSION['time_remaining'] = $m;

		  }

else {

		  $oldtime = $_SESSION['time_started'];
          $newtime = time();
          $difference = $newtime - $oldtime;
          $_SESSION['time_remaining'] = $_SESSION['time_remaining'] - $difference;
          if ($_SESSION['time_remaining'] > 0)
          {
              $_SESSION['time_started'] = $newtime;
             //continue
          } else {
             //out of time
			  // Display teacher menu:
					include ('includes/student_menu.php');


				 echo '<div class="alert alert-danger">انتهى الوقت</div>';


				 // Calculate results
				 require_once (MYSQL);
				 require_once ('calculate_result.php');


				// Finish the page:
			    echo '<div class="alert alert-success">تم تسليم الاختبار بنجاح ۔۔ تمنياتنا بالتوفيق</div>';
				echo '<b><a href="show_result.php?id=' .  $_SESSION['exam_id2'] . '" > اضغط هنا لعرض النتيجة</a></b><br />';

				 //to prevent student to enter the exam again
				 unset($_SESSION['exam_id2']);

				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
          }
		  }







// countdown Timer /////////////////////////////////////////////////////////////////////////////////////////////////




?>

<div class="container-fluid">
<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

echo '<h1 align="left" style="color:red;"> الوقت المتبقي : ';
 echo gmdate("H:i:s",  $_SESSION['time_remaining']);
echo '</h1>';





	require_once (MYSQL);

	if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id'];
		$idq = $_POST['id'];


		// define the user
	    $user = $_SESSION['user_id'];
		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer

	       if(isset($_POST['correct_answer']))
		   { //100

			$selected_answer = $_POST['correct_answer'];
			//echo $selected_answer;

			$next = $page + 1; // next question
			$page = $page + 1;
			$prev = $page - 1;  // previous question


		$q = "SELECT answer_id, exam_id, question_id, user_id, selected_answer, correct_answer from answer WHERE (question_id='$question_number' AND user_id='$user')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0 )
		{

			mysqli_free_result ($r); // Free up the resources


			// Update the answer to the database:
			$q3 = "UPDATE answer SET selected_answer='$selected_answer' WHERE (question_id='$question_number' and user_id='$user')";
			$r3 = mysqli_query ($dbc, $q3) or trigger_error("Query: $q3\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

			    echo '<div class="alert alert-success">تم تعديل وحفظ الإجابة</div>';

			}


		}
		else
		{ // 101




			// Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.


						 //echo '<div class="alert alert-success">تم حفظ الإجابة بنجاح</div>';

						 echo'
						 <div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert">&times;</a>
    <div>تم حفظ الإجابة بنجاح</div>
</div>

						 ';


			}
			else { // If it did not run OK.
				//echo '<div class="alert alert-danger">ملاحظة: لم تتم اختيار إجابة في السؤال السابق</div>';

				echo'
				<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert">&times;</a>
<div>ملاحظة: لم تتم اختيار إجابة في السؤال السابق</div>
</div>

				';

			}


		   } // for 101


		   } // 100
            else
			{
				echo '<div class="alert alert-danger">ملاحظة: لم تتم اختيار إجابة في السؤال السابق</div>';
				$next = $page + 1; // next question
			    $page = $page + 1;
			    $prev = $page - 1;  // previous question


			}


	}
	elseif ( (isset($_POST['id2'])) && (is_numeric($_POST['id2'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id2'];
		$idq = $_POST['id2'];

		// define the user
	      $user = $_SESSION['user_id'];

		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer


	       if(isset($_POST['correct_answer']))
		   { //200
			$selected_answer = $_POST['correct_answer'];
			//echo $selected_answer;

			$next = $page; // next question
			//$page = $page + 1;
			$prev = $page - 1;  // previous question





			/* Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

			     echo '<div class="alert alert-success">تم حفظ الإجابة بنجاح</div>';

			}
			else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم يتم حفظ الإجابة ، فضلاً حاول مرة أخرى</div>';

			}   */



		   } // 200
            else
			{
		      $next = $page; // next question
			  //$page = $page + 1;
			  $prev = $page - 1;  // previous question
			}


	}
	elseif ( (isset($_POST['id3'])) && (is_numeric($_POST['id3'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id3'];
		$idq = $_POST['id3'];

		// define the user
	      $user = $_SESSION['user_id'];

		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer


	       if(isset($_POST['correct_answer']))
		   {
			$selected_answer = $_POST['correct_answer'];
			//echo $selected_answer;

			// Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

				// Display teacher menu:
				if (($_SESSION['user_level'] == 1)) // if he is a teacher
				{
					// Display teacher menu:
					include ('includes/teacher_menu.php');
				}
				else {   // if he is a student

					// Display teacher menu:
					include ('includes/student_menu.php');
				}


				 echo '<div class="alert alert-success">تم حفظ الإجابة بنجاح</div>';


				 // Calculate results
				 require_once ('calculate_result.php');


				// Finish the page:
			    echo '<div class="alert alert-success">تم تسليم الاختبار بنجاح ۔۔ تمنياتنا بالتوفيق</div>';
				echo '<b><a href="show_result.php?id=' .  $_SESSION['exam_id2'] . '" > اضغط هنا لعرض النتيجة</a></b><br />';

				 //to prevent student to enter the exam again
				 unset($_SESSION['exam_id2']);

				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.

			}
			else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم يتم حفظ الإجابة ، فضلاً حاول مرة أخرى</div>';

			}



		   }
            else
			{
				echo '<div class="alert alert-danger">اختر إجابة لتسليم الاختبار</div>';

					$next = $page; // stay in last question
			        $prev = $page - 1;  // previous question
			}


	}
	else
	{
			$page = 1;
			$next = $page;
			$prev = 0;
	}



	$questions_at_page = 1;

	$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$eid'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	$questions_count = mysqli_num_rows($r);
	@mysqli_free_result($r);

	$pages_count = (int)ceil ($questions_count / $questions_at_page );

	if (($page > $pages_count) || ($page <=0))
	{
		mysqli_close($dbc);
		die('لا يوجد المزيد من الأسئلة');
	}

	$start = ($page - 1 ) * $questions_at_page;
	$end = $questions_at_page;

	if ($questions_count !=0)
	{
		// To show the question
		$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$eid' LIMIT $start,$end";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0 )
		{
			$row = mysqli_fetch_array($r, MYSQLI_NUM); // very important MYSQLI_NUM insted of MYSQLI_ASSOC

		  $_SESSION['question'] = $row[0]; // to keep that number then add it to answer table during the forms submitted in next question
		  $_SESSION['c_answer'] = $row[6]; // to save the correct_answer

		  $question_number = $_SESSION['question'];
		  // define the user
	       $user = $_SESSION['user_id'];

		  // To get the number of selected answer if is already selected and saved in the database
		  $q2 = "SELECT answer_id, exam_id, question_id, user_id, selected_answer, correct_answer from answer WHERE (question_id='$question_number' AND user_id='$user')";
		$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r2) > 0 )
		{

			$row2 = mysqli_fetch_array($r2, MYSQLI_NUM); // very important MYSQLI_NUM insted of MYSQLI_ASSOC

			$choice = $row2[4];
		}
		else
		{
			$choice = 0;
		}


			echo '<form action="real_test.php" method="post">';

			echo '<table class="table">

                  <tr class="warning">
                  <td><b> ' . $page . ' . ' . $row[1] . '; </b></td>
                  </tr>
                  <tr>
                  <td align="right"><b> اختر الإجابة الصحيحة: </b>
                  <br><br>';

				  if ( $choice == 1)
		{
			echo '<input type="radio" name ="correct_answer" value="1" checked> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                 ';
		}
		elseif ( $choice == 2)
		{
			echo '<input type="radio" name ="correct_answer" value="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2" checked> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                  ';
		}
		elseif ( $choice == 3)
		{
			echo '<input type="radio" name ="correct_answer" value="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3" checked> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                  ';
		}
		elseif ( $choice == 4)
		{
			echo '<input type="radio" name ="correct_answer" value="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4" checked> ' . $row[5] . ' <br>
                  ';
		}
		else
		{
			echo '<input type="radio" name ="correct_answer" value="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                  ';
		}


			echo'</td>
                  </tr> <tr><td>
                  ';




mysqli_free_result ($r); // Free up the resources
		}




		if ($prev > 0 )
		{
			echo '<button name="id2" class="btn btn-primary btn-md type="submit" value="' . $prev . '">السابق</button>';
		}

		if (($next < $pages_count) && ($prev > 0) )
			{
				echo ' - ';
			}


		if ($next < $pages_count)
{
	echo '<button name="id" class="btn btn-primary btn-md type="submit" value="' . $next . '">التالي</button>';
}





 if ($next >= $questions_count )
	 {
	   echo ' - ';
	   echo '<button name="id3" class="btn btn-danger btn-md" type="submit" value="' . $page . '">تسليم الاختبار</button>';
	 }


echo '
</td>
</tr>
</table>

</form>
';

mysqli_close($dbc);




	}



?>




</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
