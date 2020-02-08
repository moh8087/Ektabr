<?php

         // define the user
	       $user = $_SESSION['user_id'];
		   $i=0;


		// calculate total question contains the exam :
		$q = "SELECT question_id, exam_id, question from question WHERE(exam_id='$eid')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		$total_mark = mysqli_num_rows($r);
    	@mysqli_free_result($r);




        $q2 = "SELECT answer_id, exam_id, question_id, user_id, selected_answer, correct_answer from answer WHERE (exam_id='$eid' AND user_id='$user')";
		$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r2) > 0 )
		{

			$i=0;

			// Fetch and print the records:
			while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) { //100


				if ($row2['selected_answer']== $row2['correct_answer'])
				{
					$i++;
				}
				else
				{
					$i=$i;
				}




			} //100

			$got_mark = $i;

			mysqli_free_result ($r2); // Free up the resources

		}

		$start_test = $_SESSION['start_test'];
		$end_test = date("Y-m-d H:i:s");

		// Add the results on the database:
			$q3 = "INSERT INTO result (exam_id, user_id, total_mark, got_mark, start_test, end_test) VALUES ('$eid', '$user', '$total_mark', '$got_mark', '$start_test','$end_test')";
			$r3 = mysqli_query ($dbc, $q3) or trigger_error("Query: $q3\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

			    echo '<div class="alert alert-success">تم حفظ النتيجة</div>';


			}
			else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم حفظ النتيجة</div>';
			}


		unset($_SESSION['start_test']);
	    unset($_SESSION['time_remaining']);
			unset($_SESSION['time_limit']);




?>
